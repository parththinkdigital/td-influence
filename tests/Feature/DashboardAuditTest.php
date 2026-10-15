<?php

use App\Models\Booking;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Category;
use App\Models\Dispute;
use App\Models\SocialAccount;
use App\Models\TalentProfile;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Support\Facades\Hash;

test('systematic audit of all public and guest routes', function () {
    $brandUser = User::create(['name' => 'Public Brand', 'email' => 'pub_brand@test.com', 'password' => Hash::make('secret'), 'role' => 'brand']);
    $brandProfile = BrandProfile::create(['user_id' => $brandUser->id, 'company_name' => 'Public Brand Co']);

    $talentUser = User::create(['name' => 'Public Talent', 'email' => 'pub_talent@test.com', 'password' => Hash::make('secret'), 'role' => 'influencer']);
    $talentProfile = TalentProfile::create([
        'user_id' => $talentUser->id,
        'username' => 'publictalent',
        'display_name' => 'Public Talent',
        'city' => 'Nashik',
        'availability_status' => 'available',
    ]);
    SocialAccount::create([
        'talent_profile_id' => $talentProfile->id,
        'platform' => 'instagram',
        'username' => 'publictalent',
        'followers' => 45000,
        'is_verified' => true,
    ]);

    $campaign = Campaign::create([
        'brand_profile_id' => $brandProfile->id,
        'campaign_name' => 'Public Test Campaign',
        'campaign_type' => 'influencer_campaign',
        'slug' => 'public-test-campaign',
        'title' => 'Public Test Campaign',
        'description' => 'Public campaign description',
        'status' => 'published',
    ]);

    $publicRoutes = [
        route('home'),
        route('about'),
        route('how-it-works'),
        route('pricing'),
        route('contact'),
        route('privacy'),
        route('terms'),
        route('login'),
        route('register'),
        route('brand.login'),
        route('admin.login'),
        route('campaigns.public'),
        route('campaigns.public.show', $campaign->slug),
        route('influencers.public'),
        route('influencers.public.show', $talentProfile->username),
    ];

    foreach ($publicRoutes as $url) {
        $resp = $this->get($url);
        expect($resp->status())->toBe(200);
    }
});

test('systematic audit of all admin portal screens and management actions', function () {
    $admin = User::create(['name' => 'Master Admin', 'email' => 'master_admin@tdinfluence.com', 'password' => Hash::make('secret'), 'role' => 'admin']);
    $brandUser = User::create(['name' => 'Admin Test Brand', 'email' => 'admin_brand@test.com', 'password' => Hash::make('secret'), 'role' => 'brand']);
    $brandProfile = BrandProfile::create(['user_id' => $brandUser->id, 'company_name' => 'Admin Test Brand Co']);
    $talentUser = User::create(['name' => 'Admin Test Talent', 'email' => 'admin_talent@test.com', 'password' => Hash::make('secret'), 'role' => 'influencer']);
    $talentProfile = TalentProfile::create(['user_id' => $talentUser->id, 'username' => 'admintalent', 'display_name' => 'Admin Talent']);

    $campaign = Campaign::create([
        'brand_profile_id' => $brandProfile->id,
        'campaign_name' => 'Admin Audit Campaign',
        'campaign_type' => 'influencer_campaign',
        'slug' => 'admin-audit-campaign',
        'title' => 'Admin Audit Campaign',
        'description' => 'Brief',
        'status' => 'pending_review',
    ]);

    $verification = Verification::create([
        'user_id' => $talentUser->id,
        'verification_level' => 2,
        'document_type' => 'Govt ID',
        'status' => 'pending',
    ]);

    $application = CampaignApplication::create([
        'campaign_id' => $campaign->id,
        'talent_profile_id' => $talentProfile->id,
        'quoted_price' => 10000,
        'status' => 'selected',
    ]);

    $booking = Booking::create([
        'campaign_id' => $campaign->id,
        'application_id' => $application->id,
        'brand_profile_id' => $brandProfile->id,
        'talent_profile_id' => $talentProfile->id,
        'agreed_fee' => 10000,
        'total_amount' => 11000,
        'status' => 'in_progress',
    ]);

    $dispute = Dispute::create([
        'booking_id' => $booking->id,
        'opened_by_user_id' => $brandUser->id,
        'reason' => 'Delay',
        'description' => 'Details',
        'status' => 'open',
    ]);

    $this->actingAs($admin);

    $adminRoutes = [
        route('admin.dashboard'),
        route('admin.brands'),
        route('admin.influencers'),
        route('admin.campaigns'),
        route('admin.categories'),
        route('admin.verifications'),
        route('admin.disputes'),
    ];

    foreach ($adminRoutes as $url) {
        $resp = $this->get($url);
        expect($resp->status())->toBe(200);
    }

    // Admin Status Actions
    $campStatusResp = $this->post(route('admin.campaigns.status', $campaign->id), ['status' => 'published']);
    $campStatusResp->assertSessionHas('success');
    expect($campaign->fresh()->status)->toBe('published');

    $talentStatusResp = $this->post(route('admin.influencers.status', $talentProfile->id), ['status' => 'active', 'verification_level' => 4]);
    $talentStatusResp->assertSessionHas('success');
    expect($talentProfile->fresh()->verification_level)->toBe(4);

    $verifResp = $this->post(route('admin.verifications.status', $verification->id), ['status' => 'approved']);
    $verifResp->assertSessionHas('success');
    expect($verification->fresh()->status)->toBe('approved');

    $dispResp = $this->post(route('admin.disputes.status', $dispute->id), ['status' => 'resolved', 'resolution_decision' => 'Resolved by admin']);
    $dispResp->assertSessionHas('success');
    expect($dispute->fresh()->status)->toBe('resolved');
});

test('systematic audit of all brand studio screens and workflows', function () {
    $brandUser = User::create(['name' => 'Brand Executive', 'email' => 'brand_exec@test.com', 'password' => Hash::make('secret'), 'role' => 'brand']);
    $brandProfile = BrandProfile::create(['user_id' => $brandUser->id, 'company_name' => 'Exec Brand Co', 'city' => 'Nashik']);

    $talentUser = User::create(['name' => 'Brand View Talent', 'email' => 'bvt@test.com', 'password' => Hash::make('secret'), 'role' => 'influencer']);
    $talentProfile = TalentProfile::create(['user_id' => $talentUser->id, 'username' => 'bvttalent', 'display_name' => 'BVT Star']);

    $category = Category::create(['name' => 'Beauty', 'slug' => 'beauty', 'status' => 'active']);

    $campaign = Campaign::create([
        'brand_profile_id' => $brandProfile->id,
        'category_id' => $category->id,
        'campaign_name' => 'Brand Suite Campaign',
        'campaign_type' => 'influencer_campaign',
        'slug' => 'brand-suite-campaign',
        'title' => 'Brand Suite Campaign',
        'description' => 'Comprehensive Brief',
        'status' => 'published',
    ]);

    $application = CampaignApplication::create([
        'campaign_id' => $campaign->id,
        'talent_profile_id' => $talentProfile->id,
        'quoted_price' => 18000,
        'status' => 'applied',
    ]);

    $this->actingAs($brandUser);

    // 1. Dashboard, Profile, Influencers directory and show
    $this->get(route('brand.dashboard'))->assertStatus(200);
    $this->get(route('brand.profile'))->assertStatus(200);
    $this->get(route('brand.campaigns'))->assertStatus(200);
    $this->get(route('brand.campaigns.create'))->assertStatus(200);
    $this->get(route('brand.campaigns.show', $campaign->id))->assertStatus(200);
    $this->get(route('brand.influencers'))->assertStatus(200);
    $this->get(route('brand.influencer.show', $talentProfile->id))->assertStatus(200);
    $this->get(route('brand.messages'))->assertStatus(200);
    $this->get(route('brand.chat', $application->id))->assertStatus(200);
    $this->get(route('brand.bookings'))->assertStatus(200);
    $this->get(route('brand.notifications'))->assertStatus(200);

    // 2. Profile Update
    $profResp = $this->post(route('brand.profile'), [
        'company_name' => 'Exec Brand Global',
        'description' => 'Premium brand agency',
        'city' => 'Nashik',
    ]);
    $profResp->assertSessionHas('success');
    expect($brandProfile->fresh()->company_name)->toBe('Exec Brand Global');

    // 3. Shortlist Application
    $appResp = $this->post(route('brand.applications.status', $application->id), ['status' => 'shortlisted']);
    $appResp->assertSessionHas('success');
    expect($application->fresh()->status)->toBe('shortlisted');
});

test('systematic audit of all creator studio screens and workflows', function () {
    $brandUser = User::create(['name' => 'Creator Brand Client', 'email' => 'cbc@test.com', 'password' => Hash::make('secret'), 'role' => 'brand']);
    $brandProfile = BrandProfile::create(['user_id' => $brandUser->id, 'company_name' => 'Client Brands']);

    $creatorUser = User::create(['name' => 'Creator Pro Studio', 'email' => 'cps@test.com', 'password' => Hash::make('secret'), 'role' => 'influencer']);
    $talentProfile = TalentProfile::create([
        'user_id' => $creatorUser->id,
        'username' => 'creatorprostudio',
        'display_name' => 'Creator Pro Studio',
        'city' => 'Nashik',
        'availability_status' => 'available',
    ]);

    $campaign = Campaign::create([
        'brand_profile_id' => $brandProfile->id,
        'campaign_name' => 'Creator Explore Campaign',
        'campaign_type' => 'influencer_campaign',
        'slug' => 'creator-explore-campaign',
        'title' => 'Creator Explore Campaign',
        'description' => 'Brief details',
        'status' => 'published',
    ]);

    $this->actingAs($creatorUser);

    // 1. Check all Studio screens
    $this->get(route('influencer.dashboard'))->assertStatus(200);
    $this->get(route('influencer.profile'))->assertStatus(200);
    $this->get(route('influencer.portfolio'))->assertStatus(200);
    $this->get(route('influencer.social'))->assertStatus(200);
    $this->get(route('influencer.rates'))->assertStatus(200);
    $this->get(route('influencer.campaigns'))->assertStatus(200);
    $this->get(route('influencer.campaigns.show', $campaign->id))->assertStatus(200);
    $this->get(route('influencer.applications'))->assertStatus(200);
    $this->get(route('influencer.bookings'))->assertStatus(200);
    $this->get(route('influencer.messages'))->assertStatus(200);
    $this->get(route('influencer.notifications'))->assertStatus(200);

    // 2. Add Portfolio Item
    $portResp = $this->post(route('influencer.portfolio'), [
        'title' => 'Nike Commercial Video',
        'media_url' => 'https://instagram.com/reel/nike123',
        'category' => 'Commercial',
    ]);
    $portResp->assertSessionHas('success');
    expect($talentProfile->portfolios()->count())->toBe(1);

    // 3. Add Gig / Rate Package
    $gigResp = $this->post(route('influencer.rates'), [
        'rate_type' => 'Dedicated Reel (4K)',
        'rate_amount' => 22000,
        'notes' => 'Includes 2 revisions and 30-day ads rights.',
    ]);
    $gigResp->assertSessionHas('success');
    expect($talentProfile->rates()->count())->toBe(1);

    // 4. Apply to Campaign
    $applyResp = $this->post(route('influencer.campaigns.apply', $campaign->id), [
        'cover_note' => 'I would love to produce a 4K Reel for this campaign with high production quality.',
        'quoted_price' => 20000,
    ]);
    $applyResp->assertSessionHas('success');
    expect(CampaignApplication::where('campaign_id', $campaign->id)->where('talent_profile_id', $talentProfile->id)->exists())->toBeTrue();
});
