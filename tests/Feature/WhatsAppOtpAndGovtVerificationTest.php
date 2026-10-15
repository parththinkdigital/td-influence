<?php

use App\Models\PhoneOtp;
use App\Models\TalentProfile;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

test('guest can request WhatsApp OTP for login', function () {
    $response = $this->postJson(route('auth.whatsapp.send_otp'), [
        'phone' => '+919876543210',
    ]);

    $response->assertOk()
        ->assertJson([
            'success' => true,
            'phone' => '+919876543210',
        ]);

    expect(PhoneOtp::where('phone', '+919876543210')->exists())->toBeTrue();
});

test('guest can login or register via WhatsApp OTP', function () {
    // 1. Send OTP
    $sendRes = $this->postJson(route('auth.whatsapp.send_otp'), [
        'phone' => '+919876543210',
    ]);
    $testOtp = $sendRes->json('test_otp');
    expect($testOtp)->not->toBeEmpty();

    // 2. Verify and Login
    $loginRes = $this->postJson(route('auth.whatsapp.verify'), [
        'phone' => '+919876543210',
        'otp' => $testOtp,
    ]);

    $loginRes->assertOk()
        ->assertJson([
            'success' => true,
        ]);

    $user = User::where('phone', '+919876543210')->first();
    expect($user)->not->toBeNull();
    expect($user->phone_verified_at)->not->toBeNull();
    expect($user->talentProfile)->not->toBeNull();
    expect((int) $user->talentProfile->verification_level)->toBe(2);
    $this->assertAuthenticatedAs($user);
});

test('influencer can verify WhatsApp contact number in studio and upgrade to Level 2', function () {
    $user = User::factory()->create([
        'role' => 'talent',
        'phone' => null,
        'phone_verified_at' => null,
    ]);
    TalentProfile::create([
        'user_id' => $user->id,
        'display_name' => 'Test Creator',
        'username' => 'test_creator',
        'verification_level' => 1,
    ]);

    // Send Phone OTP
    $sendRes = $this->actingAs($user)->postJson(route('influencer.verification.send_phone_otp'), [
        'phone' => '+919123456789',
    ]);
    $sendRes->assertOk();
    $testOtp = $sendRes->json('test_otp');

    // Verify Phone OTP
    $verifyRes = $this->actingAs($user)->postJson(route('influencer.verification.verify_phone_otp'), [
        'phone' => '+919123456789',
        'otp' => $testOtp,
    ]);

    $verifyRes->assertOk()->assertJson(['success' => true]);

    $user->refresh();
    expect($user->phone)->toBe('+919123456789');
    expect($user->isPhoneVerified())->toBeTrue();
    expect((int) $user->talentProfile->verification_level)->toBe(2);
});

test('influencer can submit government ID document (Aadhaar) with front and back files', function () {
    $user = User::factory()->create(['role' => 'talent']);
    TalentProfile::create([
        'user_id' => $user->id,
        'display_name' => 'Aadhaar Creator',
        'username' => 'aadhaar_creator',
        'verification_level' => 2,
    ]);

    $front = UploadedFile::fake()->create('aadhaar_front.jpg', 500, 'image/jpeg');
    $back = UploadedFile::fake()->create('aadhaar_back.jpg', 500, 'image/jpeg');

    $response = $this->actingAs($user)->post(route('influencer.verification.submit_govt_id'), [
        'id_type' => 'aadhaar',
        'document_name' => 'Aadhaar Card User',
        'document_number' => '1234-5678-9012',
        'document_file' => $front,
        'back_document_file' => $back,
        'instant_verify' => '1',
    ]);

    $response->assertRedirect(route('influencer.verification'));

    $verification = Verification::where('user_id', $user->id)
        ->where('id_type', 'aadhaar')
        ->first();

    expect($verification)->not->toBeNull();
    expect($verification->document_name)->toBe('Aadhaar Card User');
    expect($verification->document_number)->toBe('1234-5678-9012');
    expect($verification->status)->toBe('approved');
    expect((int) $user->talentProfile->fresh()->verification_level)->toBe(3);
});

test('admin can approve pending government ID verification requests', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $talentUser = User::factory()->create(['role' => 'talent']);
    TalentProfile::create([
        'user_id' => $talentUser->id,
        'display_name' => 'Driving License Talent',
        'username' => 'dl_talent',
        'verification_level' => 2,
    ]);

    $verification = Verification::create([
        'user_id' => $talentUser->id,
        'verification_level' => 3,
        'document_type' => 'driving_license',
        'id_type' => 'driving_license',
        'document_name' => 'DL Holder Name',
        'document_number' => 'MH15-2023-0001234',
        'document_path' => 'verifications/dl_front.jpg',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.verifications.status', $verification->id), [
        'status' => 'approved',
        'admin_notes' => 'Verified against transport department database',
    ]);

    $response->assertRedirect();
    expect($verification->fresh()->status)->toBe('approved');
    expect((int) $talentUser->talentProfile->fresh()->verification_level)->toBe(3);
});

test('whatsapp webhook responds to Meta verification handshake', function () {
    $verifyToken = config('services.whatsapp.webhook_verify_token', env('WHATSAPP_WEBHOOK_VERIFY_TOKEN', 'talent_marketplace_secret_2026'));

    $response = $this->get('/webhooks/whatsapp?hub_mode=subscribe&hub_verify_token='.$verifyToken.'&hub_challenge=1155993322');

    $response->assertOk()
        ->assertSee('1155993322');
});

test('whatsapp webhook accepts incoming delivery event notifications', function () {
    $response = $this->postJson('/webhooks/whatsapp', [
        'object' => 'whatsapp_business_account',
        'entry' => [
            [
                'id' => '1414905208364680',
                'changes' => [
                    [
                        'value' => [
                            'messaging_product' => 'whatsapp',
                            'metadata' => ['display_phone_number' => '15551234567', 'phone_number_id' => '1414905208364680'],
                        ],
                    ],
                ],
            ],
        ],
    ]);

    $response->assertOk()
        ->assertSee('EVENT_RECEIVED');
});

test('talent creator can view login page and sign in with email and password', function () {
    $user = User::factory()->create([
        'email' => 'creator@example.com',
        'password' => Hash::make('password123'),
        'role' => 'talent',
    ]);
    TalentProfile::create([
        'user_id' => $user->id,
        'display_name' => 'Creator User',
        'username' => 'creator_user',
        'verification_level' => 1,
    ]);

    $viewRes = $this->get(route('login'));
    $viewRes->assertOk()
        ->assertSee('Talent Studio Sign In')
        ->assertDontSee('WhatsApp OTP');

    $loginRes = $this->post(route('login'), [
        'login_id' => 'creator@example.com',
        'password' => 'password123',
    ]);

    $loginRes->assertRedirect(route('influencer.dashboard'));
    $this->assertAuthenticatedAs($user);
});
