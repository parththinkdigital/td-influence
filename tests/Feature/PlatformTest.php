<?php

use App\Models\Booking;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\CampaignDeliverable;
use App\Models\Conversation;
use App\Models\DeliverableSubmission;
use App\Models\Dispute;
use App\Models\Message;
use App\Models\SocialAccount;
use App\Models\TalentProfile;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Support\Facades\Hash;

test('public pages load successfully', function () {
    $this->get('/')->assertStatus(200);
    $this->get('/light')->assertStatus(200)->assertSee('HypeMarket');
    $this->get('/dark')->assertStatus(200)->assertSee('HypeMarket');
    $this->get('/dark3')->assertStatus(200)->assertSee('MATTERS');
    $this->get('/font-pair')->assertStatus(200)->assertSee('Typography');
    $this->get('/about')->assertStatus(200)->assertSee('About');
    $this->get('/how-it-works')->assertStatus(200)->assertSee('Workflow');
    $this->get('/pricing')->assertStatus(200)->assertSee('Pricing');
    $this->get('/contact')->assertStatus(200)->assertSee('Contact');
    $this->get('/privacy')->assertStatus(200)->assertSee('Privacy Policy');
    $this->get('/terms')->assertStatus(200)->assertSee('Terms of Service');
    $this->get('/campaigns')->assertStatus(200)->assertSee('Campaigns');
    $this->get('/influencers')->assertStatus(200)->assertSee('Creators');
    $this->get('/register')->assertStatus(200)->assertSee('Continue with Google');
});

test('google auth route redirects to google oauth', function () {
    $response = $this->get(route('auth.google'));
    $response->assertRedirect();
});

test('dedicated admin login page loads and authenticates admin user', function () {
    $admin = User::create([
        'name' => 'TD-Influence Admin',
        'email' => 'admin_test@tdinfluence.com',
        'password' => Hash::make('password123'),
        'role' => 'admin',
        'status' => 'active',
    ]);

    $this->get('/admin/login')->assertStatus(200)->assertSee('Admin Portal Sign In');

    $response = $this->post('/admin/login', [
        'email' => 'admin_test@tdinfluence.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($admin);
});

test('dedicated brand login page loads and authenticates brand user', function () {
    $brandUser = User::create([
        'name' => 'Acme Brand Contact',
        'email' => 'brand_test@company.com',
        'password' => Hash::make('password123'),
        'role' => 'brand',
        'status' => 'active',
    ]);

    BrandProfile::create([
        'user_id' => $brandUser->id,
        'company_name' => 'Acme Test Company',
    ]);

    $this->get('/brand/login')->assertStatus(200)->assertSee('Brand Studio Sign In');

    $response = $this->post('/brand/login', [
        'email' => 'brand_test@company.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('brand.dashboard'));
    $this->assertAuthenticatedAs($brandUser);
});

test('influencer can register with email and password', function () {
    $response = $this->post('/register/influencer', [
        'name' => 'Test Creator',
        'email' => 'creator_test@tdinfluence.com',
        'phone' => '+1555999000',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('influencer.onboarding'));
    $this->assertDatabaseHas('users', [
        'email' => 'creator_test@tdinfluence.com',
        'role' => 'influencer',
    ]);
});

test('admin can access dashboard with correct statistics and view', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin_dash@tdinfluence.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'status' => 'active',
    ]);

    $this->actingAs($admin);

    $response = $this->get(route('admin.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Admin Governance Center');
    $response->assertSee('Brands');
    $response->assertSee('Creators');
});

test('admin can access influencers management page and update verification', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin_inf@tdinfluence.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'status' => 'active',
    ]);

    $creator = User::create([
        'name' => 'Creator Demo',
        'email' => 'creator_demo@tdinfluence.com',
        'password' => Hash::make('password'),
        'role' => 'influencer',
        'status' => 'active',
    ]);

    $profile = TalentProfile::create([
        'user_id' => $creator->id,
        'username' => 'creatordemo',
        'display_name' => 'Creator Demo',
        'verification_level' => 1,
    ]);

    $this->actingAs($admin);

    $response = $this->get(route('admin.influencers'));
    $response->assertStatus(200);
    $response->assertSee('Creator Network Moderation');
    $response->assertSee('creatordemo');

    $postResp = $this->post(route('admin.influencers.status', $profile->id), [
        'verification_level' => 4,
    ]);
    $postResp->assertSessionHas('success');
    expect($profile->fresh()->verification_level)->toBe(4);
});

test('admin can review verification queue and approve creator identity documents', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin_verif@tdinfluence.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'status' => 'active',
    ]);

    $user = User::create([
        'name' => 'Identity Creator',
        'email' => 'identity_creator@tdinfluence.com',
        'password' => Hash::make('password'),
        'role' => 'influencer',
        'status' => 'active',
    ]);

    $profile = TalentProfile::create([
        'user_id' => $user->id,
        'username' => 'identitycreator',
        'display_name' => 'Identity Creator',
        'verification_level' => 1,
    ]);

    $verification = Verification::create([
        'user_id' => $user->id,
        'verification_level' => 3,
        'document_type' => 'Govt Aadhar ID',
        'status' => 'pending',
    ]);

    $this->actingAs($admin);

    $this->get(route('admin.verifications'))
        ->assertStatus(200)
        ->assertSee('Verification Queue');

    $resp = $this->post(route('admin.verifications.status', $verification->id), [
        'status' => 'approved',
    ]);
    $resp->assertSessionHas('success');
    expect($verification->fresh()->status)->toBe('approved');
    expect($profile->fresh()->verification_level)->toBe(3);
});

test('admin can arbitrate and resolve disputes', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin_disp@tdinfluence.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'status' => 'active',
    ]);

    $brandUser = User::create(['name' => 'Brand User', 'email' => 'disp_brand@test.com', 'password' => Hash::make('pass'), 'role' => 'brand']);
    $talentUser = User::create(['name' => 'Talent User', 'email' => 'disp_talent@test.com', 'password' => Hash::make('pass'), 'role' => 'influencer']);
    $brandProfile = BrandProfile::create(['user_id' => $brandUser->id, 'company_name' => 'Dispute Brand']);
    $talentProfile = TalentProfile::create(['user_id' => $talentUser->id, 'username' => 'disptalent']);

    $campaign = Campaign::create([
        'brand_profile_id' => $brandProfile->id,
        'campaign_name' => 'Dispute Test Campaign',
        'campaign_type' => 'influencer_campaign',
        'slug' => 'dispute-test-campaign',
        'title' => 'Dispute Test Campaign',
        'description' => 'Test brief',
        'budget_min' => 10000,
        'budget_max' => 15000,
        'status' => 'in_progress',
    ]);

    $application = CampaignApplication::create([
        'campaign_id' => $campaign->id,
        'talent_profile_id' => $talentProfile->id,
        'quoted_price' => 12000,
        'status' => 'selected',
    ]);

    $booking = Booking::create([
        'campaign_id' => $campaign->id,
        'application_id' => $application->id,
        'brand_profile_id' => $brandProfile->id,
        'talent_profile_id' => $talentProfile->id,
        'agreed_fee' => 12000,
        'total_amount' => 12000,
        'status' => 'in_progress',
    ]);

    $dispute = Dispute::create([
        'booking_id' => $booking->id,
        'opened_by_user_id' => $brandUser->id,
        'reason' => 'Draft delayed',
        'description' => 'Draft content was not submitted according to timeline.',
        'status' => 'open',
    ]);

    $this->actingAs($admin);

    $this->get(route('admin.disputes'))
        ->assertStatus(200)
        ->assertSee('Dispute Resolution Center');

    $resp = $this->post(route('admin.disputes.status', $dispute->id), [
        'status' => 'resolved',
        'resolution_decision' => 'Escrow verified and released by admin arbitration.',
    ]);
    $resp->assertSessionHas('success');
    expect($dispute->fresh()->status)->toBe('resolved');
    expect($booking->fresh()->status)->toBe('completed');
});

test('admin can generate brand credentials', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin_gen@tdinfluence.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'status' => 'active',
    ]);

    $this->actingAs($admin);

    $response = $this->post(route('admin.brands.generate'), [
        'company_name' => 'Acme Innovation',
        'contact_name' => 'John Director',
        'email' => 'brand_acme@tdinfluence.com',
        'phone' => '+18005551234',
        'password' => 'BrandPass123',
    ]);

    $response->assertRedirect(route('admin.brands'));
    $this->assertDatabaseHas('users', [
        'email' => 'brand_acme@tdinfluence.com',
        'role' => 'brand',
    ]);
});

test('influencer can access and complete onboarding wizard', function () {
    $user = User::create([
        'name' => 'Onboarding Creator',
        'email' => 'onboard_creator@tdinfluence.com',
        'password' => Hash::make('password123'),
        'role' => 'talent',
        'status' => 'active',
    ]);

    TalentProfile::create([
        'user_id' => $user->id,
        'display_name' => 'Onboarding Creator',
        'username' => 'onboard_creator_123',
    ]);

    $this->actingAs($user);

    $this->get(route('influencer.onboarding'))
        ->assertStatus(200)
        ->assertSee('Complete Your Creator Profile');

    $response = $this->post(route('influencer.onboarding.save'), [
        'role_specialization' => 'influencer',
        'display_name' => 'Onboarding Creator Pro',
        'email' => 'onboard_creator@tdinfluence.com',
        'city' => 'Mumbai',
        'country' => 'India',
        'primary_categories' => ['Fashion & Lifestyle', 'Tech & Gaming'],
        'bio' => 'Professional digital creator specializing in tech reviews and fashion campaigns.',
        'rate_amount' => 20000,
        'rate_type' => 'instagram_reel',
    ]);

    $response->assertRedirect(route('influencer.dashboard'));
    $this->assertDatabaseHas('talent_profiles', [
        'user_id' => $user->id,
        'display_name' => 'Onboarding Creator Pro',
    ]);
});

test('brand and influencer can chat negotiate counter offers and receive notifications', function () {
    $brandUser = User::create([
        'name' => 'Sula Vineyards Brand',
        'email' => 'sula@brand.com',
        'password' => Hash::make('password'),
        'role' => 'brand',
    ]);
    $brandProfile = BrandProfile::create([
        'user_id' => $brandUser->id,
        'company_name' => 'Sula Vineyards Nashik',
    ]);

    $talentUser = User::create([
        'name' => 'Ananya Sharma',
        'email' => 'ananya@creator.com',
        'password' => Hash::make('password'),
        'role' => 'influencer',
    ]);
    $talentProfile = TalentProfile::create([
        'user_id' => $talentUser->id,
        'display_name' => 'Ananya Sharma',
        'username' => 'ananya_nashik',
        'city' => 'Nashik',
    ]);

    $campaign = Campaign::create([
        'brand_profile_id' => $brandProfile->id,
        'title' => 'Sula Vineyard Monsoon Shoot',
        'campaign_name' => 'Sula Vineyard Monsoon Shoot',
        'campaign_type' => 'influencer_campaign',
        'slug' => 'sula-monsoon-shoot',
        'description' => 'Looking for creators in Nashik for monsoon harvest reels.',
        'budget_min' => 30000,
        'budget_max' => 50000,
        'city' => 'Nashik',
        'status' => 'published',
    ]);

    $application = CampaignApplication::create([
        'campaign_id' => $campaign->id,
        'talent_profile_id' => $talentProfile->id,
        'cover_note' => 'I would love to shoot at Sula Vineyards.',
        'quoted_price' => 40000,
        'status' => 'applied',
    ]);

    // Brand views chat and sends a message with a commercial offer and usage rights
    $this->actingAs($brandUser);
    $this->get(route('brand.chat', $application->id))
        ->assertStatus(200)
        ->assertSee('Sula Vineyard Monsoon Shoot');

    $conversation = Conversation::where('application_id', $application->id)->first();
    expect($conversation)->not->toBeNull();

    $this->post(route('brand.chat.send', $conversation->id), [
        'message_text' => 'We can offer 45000 for 1 reel and 2 stories with 30d digital ads.',
        'proposal_price' => 45000,
        'usage_rights' => 'digital_ads_30d',
        'revisions_included' => 1,
        'exclusivity_days' => 0,
    ])->assertRedirect();

    // Check creator received notification
    $this->assertDatabaseHas('app_notifications', [
        'user_id' => $talentUser->id,
        'type' => 'proposal',
    ]);

    // Influencer opens chat and counters with 90d ad rights + 2 revisions
    $this->actingAs($talentUser);
    $this->get(route('influencer.chat', $application->id))
        ->assertStatus(200)
        ->assertSee('Sula Vineyards Nashik');

    $fetchResponse = $this->get(route('influencer.chat.fetch', $conversation->id));
    $fetchResponse->assertStatus(200)->assertJsonStructure(['messages']);
    expect($fetchResponse->json('messages.0.usage_rights'))->toBe('digital_ads_30d');

    // Influencer sends revised counter proposal
    $this->post(route('influencer.chat.send', $conversation->id), [
        'message_text' => 'For 90-day ad rights and 2 revisions, we can do ₹48,000 with 30-day category exclusivity.',
        'proposal_price' => 48000,
        'usage_rights' => 'digital_ads_90d',
        'revisions_included' => 2,
        'exclusivity_days' => 30,
        'counter_note' => 'Includes 1 high-res IG Reel + 2 Stories with RAW footage',
    ])->assertRedirect();

    // Brand reviews creator counter offer and accepts
    $this->actingAs($brandUser);
    $creatorMsg = Message::where('conversation_id', $conversation->id)->where('sender_id', $talentUser->id)->first();
    expect($creatorMsg)->not->toBeNull();
    expect((float) $creatorMsg->proposal_price)->toBe(48000.0);

    $this->post(route('brand.chat.offer_action', $conversation->id), [
        'message_id' => $creatorMsg->id,
        'action' => 'accept',
    ])->assertRedirect();

    // Booking should be confirmed at ₹48,000 with digital_ads_90d and contract terms
    $booking = Booking::where('campaign_id', $campaign->id)->first();
    expect($booking)->not->toBeNull();
    expect((float) $booking->agreed_fee)->toBe(48000.0);
    expect($booking->usage_rights)->toBe('digital_ads_90d');
    expect($booking->revisions_included)->toBe(2);
    expect($booking->exclusivity_days)->toBe(30);
    expect($booking->status)->toBe('confirmed');
    expect($booking->contract_terms)->toBeArray();
    expect($booking->contract_terms['usage_rights'])->toBe('digital_ads_90d');

    // Notifications count endpoint for creator
    $this->actingAs($talentUser);
    $notifResponse = $this->get(route('influencer.notifications.unread_count'));
    $notifResponse->assertStatus(200)->assertJsonStructure(['count', 'notifications']);

    // Notifications count endpoint for brand
    $this->actingAs($brandUser);
    $brandNotifResponse = $this->get(route('brand.notifications.unread_count'));
    $brandNotifResponse->assertStatus(200)->assertJsonStructure(['count', 'notifications']);
});

test('influencer and models can check and manually update their availability status and calendar dates', function () {
    $user = User::create([
        'name' => 'Fashion Model Maya',
        'email' => 'maya_model@tdinfluence.com',
        'password' => Hash::make('password'),
        'role' => 'influencer',
        'status' => 'active',
    ]);

    $profile = TalentProfile::create([
        'user_id' => $user->id,
        'username' => 'mayamodel',
        'display_name' => 'Maya Model Pro',
        'city' => 'Nashik',
        'availability_status' => 'available',
        'price_negotiable' => true,
    ]);

    $this->actingAs($user);

    // 1. Visit Profile & Availability Page
    $response = $this->get(route('influencer.profile'));
    $response->assertStatus(200);
    $response->assertSee('Live Booking Availability Status');
    $response->assertSee('Fashion & Commercial Model Attributes', false);

    // 2. Update manual availability status to booked
    $statusResp = $this->post(route('influencer.availability.update'), [
        'availability_status' => 'booked',
        'price_negotiable' => 1,
    ]);
    $statusResp->assertSessionHas('success');
    expect($profile->fresh()->availability_status)->toBe('booked');

    // 3. Add specific calendar date override
    $dateResp = $this->post(route('influencer.availability.date.store'), [
        'date' => '2026-10-15',
        'status' => 'unavailable',
        'notes' => 'Commercial bridal runway shoot',
    ]);
    $dateResp->assertSessionHas('success');
    expect($profile->availabilities()->where('status', 'unavailable')->where('notes', 'Commercial bridal runway shoot')->exists())->toBeTrue();

    // 4. Update complete persona specifications (Model + Anchor fields)
    $profileResp = $this->post(route('influencer.profile'), [
        'display_name' => 'Maya Model Elite',
        'city' => 'Nashik',
        'height_cm' => 176,
        'clothing_size' => 'S',
        'chest_waist_hip' => '34-25-35',
        'modeling_categories' => ['Fashion', 'Runway', 'Bridal'],
        'event_types' => ['Fashion Shows'],
        'availability_status' => 'tentative',
    ]);
    $profileResp->assertSessionHas('success');
    $fresh = $profile->fresh();
    expect($fresh->height_cm)->toBe(176);
    expect($fresh->modeling_categories)->toContain('Runway');
    expect($fresh->availability_status)->toBe('tentative');

    // 5. Public media kit displays availability status and persona specs
    $publicResp = $this->get(route('influencers.public.show', 'mayamodel'));
    $publicResp->assertStatus(200);
    $publicResp->assertSee('tentative for Work');
    $publicResp->assertSee('176 cm');
    $publicResp->assertSee('Runway');
});

test('public talent directory supports multi-persona filtering, city, and follower tiers', function () {
    // 1. Create creators in different personas and locations
    $user1 = User::create(['name' => 'Fashion Model Anya', 'email' => 'anya@test.com', 'password' => Hash::make('secret'), 'role' => 'influencer']);
    $profile1 = TalentProfile::create([
        'user_id' => $user1->id,
        'username' => 'anyamodel',
        'display_name' => 'Anya Runway',
        'city' => 'Mumbai',
        'availability_status' => 'available',
        'is_model' => true,
        'modeling_categories' => ['Fashion', 'Runway', 'High Fashion'],
        'verification_level' => 3,
        'starting_price' => 25000,
    ]);
    SocialAccount::create([
        'talent_profile_id' => $profile1->id,
        'platform' => 'instagram',
        'username' => 'anyamodel',
        'followers' => 150000, // Mid Tier
        'is_verified' => true,
    ]);

    $user2 = User::create(['name' => 'Anchor Rohan', 'email' => 'rohan@test.com', 'password' => Hash::make('secret'), 'role' => 'influencer']);
    $profile2 = TalentProfile::create([
        'user_id' => $user2->id,
        'username' => 'rohananchor',
        'display_name' => 'Rohan Emcee',
        'city' => 'Nashik',
        'availability_status' => 'booked',
        'is_anchor' => true,
        'event_types' => ['Corporate', 'Conferences'],
        'verification_level' => 2,
        'starting_price' => 15000,
    ]);
    SocialAccount::create([
        'talent_profile_id' => $profile2->id,
        'platform' => 'instagram',
        'username' => 'rohananchor',
        'followers' => 25000, // Micro Tier
        'is_verified' => false,
    ]);

    // Test Persona Filter: Modeling
    $respModel = $this->get(route('influencers.public', ['persona' => 'modeling']));
    $respModel->assertStatus(200);
    $respModel->assertSee('Anya Runway');
    $respModel->assertDontSee('Rohan Emcee');

    // Test Persona Filter: Anchor
    $respAnchor = $this->get(route('influencers.public', ['persona' => 'anchor']));
    $respAnchor->assertStatus(200);
    $respAnchor->assertSee('Rohan Emcee');
    $respAnchor->assertDontSee('Anya Runway');

    // Test City Filter: Nashik
    $respCity = $this->get(route('influencers.public', ['city' => 'Nashik']));
    $respCity->assertStatus(200);
    $respCity->assertSee('Rohan Emcee');
    $respCity->assertDontSee('Anya Runway');

    // Test Availability Status Filter: available
    $respAvail = $this->get(route('influencers.public', ['status' => 'available']));
    $respAvail->assertStatus(200);
    $respAvail->assertSee('Anya Runway');
    $respAvail->assertDontSee('Rohan Emcee');

    // Test Follower Reach Tier: mid (100k - 500k)
    $respReach = $this->get(route('influencers.public', ['reach' => 'mid']));
    $respReach->assertStatus(200);
    $respReach->assertSee('Anya Runway');
    $respReach->assertDontSee('Rohan Emcee');

    // Test Pricing Calculator page
    $respPricing = $this->get(route('pricing'));
    $respPricing->assertStatus(200);
    $respPricing->assertSee('Interactive Cost Calculator');
    $respPricing->assertSee('Estimate Campaign Budget');
});

test('phase 3 milestone collaboration workflow handles submissions, revisions, approvals, and reviews', function () {
    // 1. Create Brand and Influencer
    $brandUser = User::create(['name' => 'Brand Boss', 'email' => 'boss@acme.com', 'password' => Hash::make('secret'), 'role' => 'brand']);
    $brandProfile = BrandProfile::create(['user_id' => $brandUser->id, 'company_name' => 'Acme Global Brands']);

    $creatorUser = User::create(['name' => 'Creator Star', 'email' => 'star@creators.com', 'password' => Hash::make('secret'), 'role' => 'influencer']);
    $talentProfile = TalentProfile::create([
        'user_id' => $creatorUser->id,
        'username' => 'creatorstar',
        'display_name' => 'Creator Star',
        'city' => 'Nashik',
        'verification_level' => 3,
    ]);

    $campaign = Campaign::create([
        'brand_profile_id' => $brandProfile->id,
        'campaign_name' => 'Summer Brand Launch',
        'campaign_type' => 'influencer_campaign',
        'slug' => 'summer-brand-launch',
        'title' => 'Summer Brand Launch',
        'description' => 'Create a high-energy Instagram Reel showcasing our new summer collection.',
        'budget_min' => 20000,
        'budget_max' => 30000,
        'status' => 'in_progress',
    ]);

    $deliverable = CampaignDeliverable::create([
        'campaign_id' => $campaign->id,
        'name' => '1x 4K Instagram Reel',
        'type' => 'reel',
        'quantity' => 1,
    ]);

    $application = CampaignApplication::create([
        'campaign_id' => $campaign->id,
        'talent_profile_id' => $talentProfile->id,
        'quoted_price' => 25000,
        'status' => 'selected',
    ]);

    $booking = Booking::create([
        'campaign_id' => $campaign->id,
        'application_id' => $application->id,
        'brand_profile_id' => $brandProfile->id,
        'talent_profile_id' => $talentProfile->id,
        'agreed_fee' => 25000,
        'platform_fee' => 2500,
        'total_amount' => 27500,
        'usage_rights' => 'digital_ads_90d',
        'revisions_included' => 2,
        'exclusivity_days' => 30,
        'status' => 'confirmed',
    ]);

    // 2. Creator visits Bookings view
    $this->actingAs($creatorUser);
    $resp = $this->get(route('influencer.bookings'));
    $resp->assertStatus(200);
    $resp->assertSee('Summer Brand Launch');
    $resp->assertSee('90-Day Digital Ad Rights');

    // 3. Creator submits Deliverable Proof
    $submitResp = $this->post(route('influencer.bookings.submit', $booking->id), [
        'submission_url' => 'https://instagram.com/reel/C89abcXYZ',
        'deliverable_id' => $deliverable->id,
        'caption' => 'Loving the new collection #ad #brand',
        'notes' => 'Color graded and audio synced.',
    ]);
    $submitResp->assertSessionHas('success');
    expect($booking->fresh()->status)->toBe('deliverables_submitted');
    $submission = DeliverableSubmission::where('booking_id', $booking->id)->first();
    expect($submission)->not->toBeNull();
    expect($submission->status)->toBe('submitted');

    // 4. Brand views Bookings view and inspects proof
    $this->actingAs($brandUser);
    $brandViewResp = $this->get(route('brand.bookings'));
    $brandViewResp->assertStatus(200);
    $brandViewResp->assertSee('https://instagram.com/reel/C89abcXYZ');
    $brandViewResp->assertSee('90-Day Digital Ad Rights');

    // 5. Brand requests revision
    $revResp = $this->post(route('brand.bookings.revision', ['bookingId' => $booking->id, 'submissionId' => $submission->id]), [
        'revision_feedback' => 'Please add brand logo overlay at 0:03 mark and tag official account.',
    ]);
    $revResp->assertSessionHas('info');
    expect($submission->fresh()->status)->toBe('changes_requested');
    expect($submission->fresh()->revision_feedback)->toBe('Please add brand logo overlay at 0:03 mark and tag official account.');
    expect($booking->fresh()->status)->toBe('in_progress');

    // 6. Creator views revision alert & submits revised proof
    $this->actingAs($creatorUser);
    $creatorRevResp = $this->get(route('influencer.bookings'));
    $creatorRevResp->assertStatus(200);
    $creatorRevResp->assertSee('Brand Client Requested Revisions');
    $creatorRevResp->assertSee('Please add brand logo overlay');

    $resubmitResp = $this->post(route('influencer.bookings.submit', $booking->id), [
        'submission_url' => 'https://instagram.com/reel/C89abcXYZ_v2',
        'deliverable_id' => $deliverable->id,
        'caption' => 'Updated with official tags!',
        'notes' => 'Logo added at 0:03 as requested.',
    ]);
    $resubmitResp->assertSessionHas('success');
    $submission2 = DeliverableSubmission::where('booking_id', $booking->id)->latest()->first();

    // 7. Brand approves deliverable & releases escrow
    $this->actingAs($brandUser);
    $approveResp = $this->post(route('brand.bookings.approve', ['bookingId' => $booking->id, 'submissionId' => $submission2->id]));
    $approveResp->assertSessionHas('success');
    expect($booking->fresh()->status)->toBe('completed');
    expect($submission2->fresh()->status)->toBe('approved');
    expect((float) $talentProfile->fresh()->completion_rate)->toBe(100.0);

    // 8. Brand submits 5-star review
    $reviewResp = $this->post(route('brand.bookings.review', $booking->id), [
        'rating_overall' => 5,
        'quality_rating' => 5,
        'communication_rating' => 5,
        'punctuality_rating' => 5,
        'review_text' => 'Outstanding video production, swift revisions, and great engagement!',
    ]);
    $reviewResp->assertSessionHas('success');
    expect((float) $talentProfile->fresh()->rating_avg)->toBe(5.0);
    expect($talentProfile->fresh()->reviews_count)->toBe(1);

    // 9. Creator sees completed status and 5-star review testimonial
    $this->actingAs($creatorUser);
    $finalResp = $this->get(route('influencer.bookings'));
    $finalResp->assertStatus(200);
    $finalResp->assertSee('Milestone Completed');
    $finalResp->assertSee('Outstanding video production');
});
