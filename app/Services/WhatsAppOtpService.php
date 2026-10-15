<?php

namespace App\Services;

use App\Models\PhoneOtp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppOtpService
{
    /**
     * Normalize phone number to standard international format without '+' for Meta API.
     */
    public static function normalizePhone(string $phone): string
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);

        // If 10 digits (typical Indian mobile), prefix with 91
        if (strlen($cleaned) === 10) {
            $cleaned = '91'.$cleaned;
        }

        return '+'.$cleaned;
    }

    /**
     * Send WhatsApp OTP to phone number.
     *
     * @return array{success: bool, message: string, phone: string, test_otp?: string, expires_in_minutes: int, live_sent?: bool}
     */
    public function sendOtp(string $phone, string $purpose = 'login', ?string $ipAddress = null): array
    {
        $normalizedPhone = self::normalizePhone($phone);
        $recipientClean = ltrim($normalizedPhone, '+');

        // Generate secure 6-digit OTP
        $otp = (string) random_int(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        // Invalidate previous unverified OTPs for this phone & purpose
        PhoneOtp::where('phone', $normalizedPhone)
            ->where('purpose', $purpose)
            ->whereNull('verified_at')
            ->delete();

        // Store OTP Record
        PhoneOtp::create([
            'phone' => $normalizedPhone,
            'otp_hash' => Hash::make($otp),
            'purpose' => $purpose,
            'expires_at' => $expiresAt,
            'ip_address' => $ipAddress,
        ]);

        $sentViaLiveApi = false;
        $apiError = null;

        $metaToken = config('services.whatsapp.token') ?: env('WHATSAPP_TOKEN');
        $metaPhoneId = config('services.whatsapp.phone_number_id') ?: env('WHATSAPP_PHONE_NUMBER_ID', '1414905208364680');
        $apiVersion = config('services.whatsapp.api_version', 'v22.0');
        $templateName = config('services.whatsapp.template_name', 'hello_world');
        $templateLang = config('services.whatsapp.template_lang', 'en_US');

        if ($metaToken && $metaPhoneId) {
            $endpoint = "https://graph.facebook.com/{$apiVersion}/{$metaPhoneId}/messages";

            // 1. Primary: Send Direct Text Message containing the actual OTP Code
            $textPayload = [
                'messaging_product' => 'whatsapp',
                'to' => $recipientClean,
                'type' => 'text',
                'text' => [
                    'body' => "Talent Marketplace Verification Code: *{$otp}*\n\nYour 6-digit OTP is: *{$otp}*\n\nValid for 10 minutes. For your security, do not share this code with anyone.",
                ],
            ];

            try {
                $textRes = Http::withToken($metaToken)
                    ->acceptJson()
                    ->post($endpoint, $textPayload);

                if ($textRes->successful() && isset($textRes->json()['messages'])) {
                    $sentViaLiveApi = true;
                    Log::info("WhatsApp Direct OTP Text dispatched successfully to {$recipientClean}", $textRes->json());
                } else {
                    $apiError = $textRes->body();
                    Log::warning("WhatsApp Direct Text notice: {$apiError}");

                    // 2. If custom parameterized template or fallback is used
                    if ($templateName && $templateName !== 'none') {
                        $templatePayload = ($templateName === 'hello_world')
                            ? [
                                'messaging_product' => 'whatsapp',
                                'to' => $recipientClean,
                                'type' => 'template',
                                'template' => [
                                    'name' => 'hello_world',
                                    'language' => ['code' => $templateLang],
                                ],
                            ]
                            : [
                                'messaging_product' => 'whatsapp',
                                'to' => $recipientClean,
                                'type' => 'template',
                                'template' => [
                                    'name' => $templateName,
                                    'language' => ['code' => $templateLang],
                                    'components' => [
                                        [
                                            'type' => 'body',
                                            'parameters' => [
                                                ['type' => 'text', 'text' => $otp],
                                            ],
                                        ],
                                    ],
                                ],
                            ];

                        $templateRes = Http::withToken($metaToken)->acceptJson()->post($endpoint, $templatePayload);
                        if ($templateRes->successful() && isset($templateRes->json()['messages'])) {
                            $sentViaLiveApi = true;
                            Log::info("WhatsApp Template fallback dispatched to {$recipientClean}", $templateRes->json());
                        }
                    }
                }
            } catch (\Throwable $e) {
                $apiError = $e->getMessage();
                Log::error("Failed to send WhatsApp message via Meta Cloud API: {$e->getMessage()}");
            }
        }

        // Always log OTP for developer testing
        Log::info("WhatsApp OTP generated for {$normalizedPhone} [Purpose: {$purpose}]: {$otp}");

        $response = [
            'success' => true,
            'message' => $sentViaLiveApi
                ? "A WhatsApp verification code has been dispatched to {$normalizedPhone}."
                : "A WhatsApp verification code has been generated for {$normalizedPhone}.",
            'phone' => $normalizedPhone,
            'expires_in_minutes' => 10,
            'live_sent' => $sentViaLiveApi,
            'test_otp' => $otp,
        ];

        return $response;
    }

    /**
     * Verify submitted OTP against stored hash.
     */
    public function verifyOtp(string $phone, string $otp, string $purpose = 'login'): bool
    {
        $normalizedPhone = self::normalizePhone($phone);

        $record = PhoneOtp::where('phone', $normalizedPhone)
            ->where('purpose', $purpose)
            ->whereNull('verified_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (! $record) {
            return false;
        }

        if (Hash::check($otp, $record->otp_hash)) {
            $record->update(['verified_at' => now()]);

            return true;
        }

        return false;
    }
}
