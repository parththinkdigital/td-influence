<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    /**
     * Handle Meta / WhatsApp Webhook Verification Handshake (GET).
     */
    public function verify(Request $request)
    {
        $mode = $request->query('hub_mode', $request->input('hub_mode', $request->input('hub.mode')));
        $token = $request->query('hub_verify_token', $request->input('hub_verify_token', $request->input('hub.verify_token')));
        $challenge = $request->query('hub_challenge', $request->input('hub_challenge', $request->input('hub.challenge')));

        $expectedToken = config('services.whatsapp.webhook_verify_token')
            ?: config('services.meta.webhook_verify_token', env('WHATSAPP_WEBHOOK_VERIFY_TOKEN', 'talent_marketplace_secret_2026'));

        if ($mode === 'subscribe' && (string) $token === (string) $expectedToken) {
            Log::info('WhatsApp Webhook Verified Successfully!', ['challenge' => $challenge]);

            return response((string) $challenge, 200, [
                'Content-Type' => 'text/plain; charset=utf-8',
                'Content-Length' => strlen((string) $challenge),
            ]);
        }

        Log::warning('WhatsApp Webhook Verification Failed', [
            'mode' => $mode,
            'token_received' => $token,
            'expected_token' => $expectedToken,
        ]);

        return response('Forbidden', 403);
    }

    /**
     * Handle Incoming WhatsApp Webhook Events (POST).
     * Receives message delivery statuses (sent, delivered, read) and incoming messages.
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        Log::info('WhatsApp Webhook Event Received:', $payload);

        return response('EVENT_RECEIVED', 200);
    }
}
