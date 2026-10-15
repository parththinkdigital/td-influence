<?php

namespace App\Http\Controllers;

use App\Models\BrandProfile;
use App\Models\TalentProfile;
use App\Models\User;
use App\Models\Verification;
use App\Services\WhatsAppOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginId = trim($request->input('login_id'));
        $password = $request->input('password');

        $credentials = ['password' => $password];

        if (filter_var($loginId, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = strtolower($loginId);
        } elseif (preg_match('/^[0-9+\-\s]{7,15}$/', $loginId)) {
            $credentials['phone'] = $loginId;
        } else {
            // Support logging in with Creator Handle (@username or username)
            $talent = TalentProfile::where('username', ltrim($loginId, '@'))->with('user')->first();
            if ($talent && $talent->user) {
                $credentials['email'] = $talent->user->email;
            } else {
                $credentials['email'] = strtolower($loginId);
            }
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'login_id' => 'The provided credentials do not match our records.',
        ])->onlyInput('login_id');
    }

    public function showAdminLogin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin'], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')->with('success', 'Welcome to Admin Control Center.');
        }

        return back()->withErrors([
            'email' => 'Invalid admin credentials.',
        ])->onlyInput('email');
    }

    public function showBrandLogin()
    {
        if (Auth::check() && Auth::user()->isBrand()) {
            return redirect()->route('brand.dashboard');
        }

        return view('brand.auth.login');
    }

    public function brandLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'brand'], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('brand.dashboard')->with('success', 'Welcome to Brand Studio.');
        }

        return back()->withErrors([
            'email' => 'Invalid brand login credentials.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:talent,brand,influencer',
            'primary_categories' => 'nullable|array',
            'company_name' => 'required_if:role,brand|nullable|string|max:255',
        ]);

        $role = $request->role === 'influencer' ? 'talent' : $request->role;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ?: null,
            'password' => Hash::make($request->password),
            'role' => $role,
            'status' => 'active',
        ]);

        if ($role === 'brand') {
            BrandProfile::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name ?: $user->name.' Co',
                'contact_person' => $user->name,
                'contact_phone' => $user->phone,
                'verification_status' => 'unverified',
            ]);
            Auth::login($user);

            return redirect()->route('brand.dashboard')->with('success', 'Brand Account created successfully!');
        } else {
            TalentProfile::create([
                'user_id' => $user->id,
                'display_name' => $user->name,
                'username' => 'talent_'.Str::lower(Str::random(8)),
                'primary_categories' => $request->primary_categories ?: ['modeling'],
                'verification_level' => 1,
            ]);
            Auth::login($user);

            return redirect()->route('influencer.onboarding')->with('success', 'Talent Account created! Complete your profile onboarding to start pitching.');
        }
    }

    public function registerInfluencer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email ?: null,
            'phone' => $request->phone ?: null,
            'password' => Hash::make($request->password),
            'role' => 'influencer',
            'status' => 'active',
        ]);

        TalentProfile::create([
            'user_id' => $user->id,
            'display_name' => $user->name,
            'username' => 'creator_'.Str::lower(Str::random(6)),
            'verification_level' => 1,
        ]);

        Auth::login($user);

        return redirect()->route('influencer.onboarding')->with('success', 'Welcome! Let\'s setup your Upwork-style creator profile.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if (! $user) {
                $user = User::create([
                    'name' => $googleUser->getName() ?: $googleUser->getNickname() ?: 'Google User',
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'influencer',
                    'status' => 'active',
                    'avatar' => $googleUser->getAvatar(),
                ]);

                TalentProfile::create([
                    'user_id' => $user->id,
                    'display_name' => $user->name,
                    'username' => 'creator_'.Str::lower(Str::random(6)),
                    'verification_level' => 1,
                ]);
            } else {
                if (! $user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            }

            Auth::login($user);

            return $this->redirectBasedOnRole($user);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'login_id' => 'Google authentication failed: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Send WhatsApp OTP for Login / Instant Auth
     */
    public function sendWhatsAppLoginOtp(Request $request, WhatsAppOtpService $otpService)
    {
        $request->validate([
            'phone' => 'required|string|min:8|max:20',
        ]);

        $result = $otpService->sendOtp($request->phone, 'login', $request->ip());

        return response()->json($result);
    }

    /**
     * Verify WhatsApp OTP and Authenticate User
     */
    public function verifyWhatsAppLoginOtp(Request $request, WhatsAppOtpService $otpService)
    {
        $request->validate([
            'phone' => 'required|string|min:8|max:20',
            'otp' => 'required|string|min:4|max:8',
        ]);

        $phone = $request->phone;
        $otp = $request->otp;

        $isValid = $otpService->verifyOtp($phone, $otp, 'login');

        if (! $isValid) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired WhatsApp OTP code. Please request a new code.',
            ], 422);
        }

        $normalizedPhone = WhatsAppOtpService::normalizePhone($phone);
        $strippedPhone = ltrim($normalizedPhone, '+');

        // Look for user with formatted or raw phone
        $user = User::where('phone', $normalizedPhone)
            ->orWhere('phone', $strippedPhone)
            ->first();

        if (! $user) {
            // Auto-create talent user for seamless 1-click WhatsApp signup
            $user = User::create([
                'name' => 'Creator '.substr($normalizedPhone, -4),
                'phone' => $normalizedPhone,
                'phone_verified_at' => now(),
                'whatsapp_opt_in' => true,
                'email' => 'whatsapp_'.$strippedPhone.'@talentmarketplace.in',
                'password' => Hash::make(Str::random(24)),
                'role' => 'influencer',
                'status' => 'active',
            ]);

            TalentProfile::create([
                'user_id' => $user->id,
                'display_name' => $user->name,
                'username' => 'creator_'.Str::lower(Str::random(6)),
                'verification_level' => 2, // WhatsApp Verified
            ]);

            Verification::create([
                'user_id' => $user->id,
                'id_type' => 'phone_whatsapp',
                'document_type' => 'phone_whatsapp',
                'verification_level' => 2,
                'status' => 'approved',
                'verified_at' => now(),
                'admin_notes' => 'Verified via WhatsApp 1-Click Login',
            ]);
        } else {
            $user->update([
                'phone_verified_at' => now(),
                'whatsapp_opt_in' => true,
            ]);

            if ($user->talentProfile && (int) $user->talentProfile->verification_level < 2) {
                $user->talentProfile->update(['verification_level' => 2]);
            }
        }

        Auth::login($user, $request->boolean('remember', true));
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Successfully verified! Redirecting to your dashboard...',
            'redirect' => $this->getRedirectUrlBasedOnRole($user),
        ]);
    }

    protected function redirectBasedOnRole($user)
    {
        return redirect($this->getRedirectUrlBasedOnRole($user));
    }

    protected function getRedirectUrlBasedOnRole($user): string
    {
        if ($user->isAdmin()) {
            return route('admin.dashboard');
        } elseif ($user->isBrand()) {
            return route('brand.dashboard');
        } else {
            return route('influencer.dashboard');
        }
    }
}
