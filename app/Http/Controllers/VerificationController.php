<?php

namespace App\Http\Controllers;

use App\Models\TalentProfile;
use App\Models\Verification;
use App\Services\WhatsAppOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    protected WhatsAppOtpService $otpService;

    public function __construct(WhatsAppOtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Influencer Verification & KYC Dashboard Hub
     */
    public function index()
    {
        $user = Auth::user();
        $talent = $user->talentProfile ?? TalentProfile::firstOrCreate(['user_id' => $user->id], [
            'display_name' => $user->name,
            'username' => 'creator_'.strtolower(Str::random(6)),
            'verification_level' => 1,
        ]);

        $verifications = Verification::where('user_id', $user->id)->latest()->get();
        $phoneVerification = $verifications->firstWhere('id_type', 'phone_whatsapp');
        $govtVerification = $verifications->whereIn('id_type', ['aadhaar', 'driving_license', 'pan_card', 'passport', 'voter_id'])->first();

        return view('influencer.verification.index', compact('user', 'talent', 'verifications', 'phoneVerification', 'govtVerification'));
    }

    /**
     * Send WhatsApp OTP for Phone Verification
     */
    public function sendPhoneOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:8|max:20',
        ]);

        $phone = $request->phone;
        $result = $this->otpService->sendOtp($phone, 'phone_verify', $request->ip());

        return response()->json($result);
    }

    /**
     * Verify WhatsApp OTP and mark phone as verified
     */
    public function verifyPhoneOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:8|max:20',
            'otp' => 'required|string|min:4|max:8',
        ]);

        $phone = $request->phone;
        $otp = $request->otp;

        $isValid = $this->otpService->verifyOtp($phone, $otp, 'phone_verify');

        if (! $isValid) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired WhatsApp OTP code. Please request a new code.',
            ], 422);
        }

        $user = Auth::user();
        $normalizedPhone = WhatsAppOtpService::normalizePhone($phone);

        $user->update([
            'phone' => $normalizedPhone,
            'phone_verified_at' => now(),
            'whatsapp_opt_in' => true,
        ]);

        // Create or update phone verification record
        $verification = Verification::updateOrCreate(
            ['user_id' => $user->id, 'id_type' => 'phone_whatsapp'],
            [
                'document_type' => 'phone_whatsapp',
                'verification_level' => 2,
                'status' => 'approved',
                'verified_at' => now(),
                'admin_notes' => "Verified automatically via WhatsApp OTP to {$normalizedPhone}",
            ]
        );

        // Upgrade Talent Profile verification level to at least Level 2
        if ($user->talentProfile) {
            $currentLevel = (int) ($user->talentProfile->verification_level ?: 1);
            if ($currentLevel < 2) {
                $user->talentProfile->update(['verification_level' => 2]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'WhatsApp mobile number verified successfully! Your profile badge has been upgraded to Level 2 (Phone Verified).',
            'phone' => $normalizedPhone,
            'level' => $user->talentProfile->verification_level ?? 2,
        ]);
    }

    /**
     * Submit Government Document (Aadhaar, Driving License, PAN, Passport, Voter ID)
     */
    public function submitGovtId(Request $request)
    {
        $request->validate([
            'id_type' => 'required|in:aadhaar,driving_license,pan_card,passport,voter_id',
            'document_name' => 'required|string|max:255',
            'document_number' => 'required|string|max:100',
            'document_file' => 'required|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'back_document_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'instant_verify' => 'nullable|boolean',
        ]);

        $user = Auth::user();

        // Store front document
        $frontPath = $request->file('document_file')->store('verifications/'.$user->id, 'public');

        // Store back document if uploaded
        $backPath = null;
        if ($request->hasFile('back_document_file')) {
            $backPath = $request->file('back_document_file')->store('verifications/'.$user->id, 'public');
        }

        $idTypeTitles = [
            'aadhaar' => 'Aadhaar Card',
            'driving_license' => "Driver's License",
            'pan_card' => 'PAN Card',
            'passport' => 'Passport',
            'voter_id' => 'Voter ID Card',
        ];
        $idTitle = $idTypeTitles[$request->id_type] ?? 'Government ID';

        $isInstant = $request->boolean('instant_verify');
        $status = $isInstant ? 'approved' : 'pending';

        $verification = Verification::create([
            'user_id' => $user->id,
            'verification_level' => 3,
            'document_type' => $request->id_type,
            'id_type' => $request->id_type,
            'document_name' => $request->document_name,
            'document_number' => $request->document_number,
            'document_path' => $frontPath,
            'back_document_path' => $backPath,
            'status' => $status,
            'verified_at' => $isInstant ? now() : null,
            'admin_notes' => $isInstant ? "Verified via Instant KYC verification for {$idTitle}" : null,
        ]);

        if ($isInstant && $user->talentProfile) {
            $user->talentProfile->update(['verification_level' => max((int) $user->talentProfile->verification_level, 3)]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $isInstant
                    ? "Your {$idTitle} has been verified! Level 3 (ID Verified) badge is now active."
                    : "Your {$idTitle} document has been submitted for verification.",
                'verification' => $verification,
            ]);
        }

        $msg = $isInstant
            ? "Your {$idTitle} has been verified! Level 3 (ID Verified) badge is now active on your Media Kit."
            : "Your {$idTitle} document was submitted successfully. Our compliance team will review and verify it.";

        return redirect()->route('influencer.verification')->with('success', $msg);
    }
}
