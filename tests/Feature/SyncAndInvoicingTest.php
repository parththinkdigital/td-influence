<?php

use App\Models\Booking;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\DeliverableSubmission;
use App\Models\Invoice;
use App\Models\SocialAccount;
use App\Models\TalentProfile;
use App\Models\User;
use App\Services\InvoiceService;
use App\Services\SocialSyncService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

test('artisan social:sync-metrics command updates outdated social metrics successfully', function () {
    config(['services.meta.access_token' => 'mock_meta_token']);

    Http::fake([
        'https://graph.facebook.com/*' => Http::response([
            'followers_count' => 12500,
            'media_count' => 84,
            'username' => 'synctest_insta',
        ], 200),
    ]);

    $talentUser = User::create([
        'name' => 'Sync Tester',
        'email' => 'sync_tester_'.uniqid().'@example.com',
        'password' => Hash::make('password123'),
        'role' => 'talent',
        'status' => 'active',
    ]);

    $talent = TalentProfile::create([
        'user_id' => $talentUser->id,
        'display_name' => 'Sync Tester',
        'username' => 'synctester_'.uniqid(),
        'verification_level' => 1,
    ]);

    $account = SocialAccount::create([
        'talent_profile_id' => $talent->id,
        'platform' => 'instagram',
        'username' => 'synctest_insta',
        'followers' => 10000,
        'engagement_rate' => 3.50,
        'is_verified' => false,
        'last_synced_at' => now()->subDays(2),
        'sync_source' => 'manual',
    ]);

    $exitCode = Artisan::call('social:sync-metrics', [
        '--platform' => 'instagram',
        '--force' => true,
    ]);

    expect($exitCode)->toBe(0);

    $account->refresh();
    expect($account->last_synced_at)->not->toBeNull();
    expect($account->followers)->toBe(12500);
    expect($account->sync_source)->toBe('meta_graph_api');
});

test('instagram sync fetches real 30-day reel views and engagement from meta graph api', function () {
    config([
        'services.meta.access_token' => 'mock_meta_user_token',
        'services.meta.instagram_account_id' => '17841400000000001',
    ]);

    $now = now();

    Http::fake([
        'https://graph.facebook.com/v22.0/*' => Http::response([
            'business_discovery' => [
                'followers_count' => 12500,
                'media_count' => 42,
                'name' => 'Sync Tester Co',
                'media' => [
                    'data' => [
                        [
                            'id' => 'reel_a',
                            'media_type' => 'VIDEO',
                            'media_product_type' => 'REELS',
                            'timestamp' => $now->copy()->subDays(3)->format('Y-m-d\TH:i:sP'),
                            'view_count' => 50000,
                            'like_count' => 1000,
                            'comments_count' => 50,
                        ],
                        [
                            'id' => 'reel_b',
                            'media_type' => 'VIDEO',
                            'media_product_type' => 'REELS',
                            'timestamp' => $now->copy()->subDays(10)->format('Y-m-d\TH:i:sP'),
                            'view_count' => 30000,
                            'like_count' => 600,
                            'comments_count' => 30,
                        ],
                        [
                            'id' => 'reel_old',
                            'media_type' => 'VIDEO',
                            'media_product_type' => 'REELS',
                            'timestamp' => $now->copy()->subDays(45)->format('Y-m-d\TH:i:sP'),
                            'view_count' => 999999,
                            'like_count' => 900,
                            'comments_count' => 40,
                        ],
                        [
                            'id' => 'album_a',
                            'media_type' => 'CAROUSEL_ALBUM',
                            'media_product_type' => 'FEED',
                            'timestamp' => $now->copy()->subDays(5)->format('Y-m-d\TH:i:sP'),
                            'like_count' => 200,
                            'comments_count' => 0,
                        ],
                    ],
                ],
            ],
        ], 200),
    ]);

    $talentUser = User::create([
        'name' => 'Insta Views Tester',
        'email' => 'insta_views_'.uniqid().'@example.com',
        'password' => Hash::make('password123'),
        'role' => 'talent',
        'status' => 'active',
    ]);

    $talent = TalentProfile::create([
        'user_id' => $talentUser->id,
        'display_name' => 'Insta Views Tester',
        'username' => 'instaviews_'.uniqid(),
        'verification_level' => 1,
    ]);

    $account = SocialAccount::create([
        'talent_profile_id' => $talent->id,
        'platform' => 'instagram',
        'username' => 'synctest_insta',
        'followers' => 100,
        'views_30d' => 100,
        'is_verified' => false,
    ]);

    $exitCode = Artisan::call('social:sync-metrics', [
        '--platform' => 'instagram',
        '--force' => true,
    ]);

    expect($exitCode)->toBe(0);

    $account->refresh();
    expect($account->followers)->toBe(12500);
    expect($account->views_30d)->toBe(80000);
    expect($account->avg_views)->toBe(360000);
    expect($account->avg_likes)->toBe(675);
    expect($account->avg_comments)->toBe(30);
    expect((float) $account->engagement_rate)->toBe(5.64);
    expect($account->sync_source)->toBe('meta_graph_api');
    expect($account->is_verified)->toBeTrue();
});

test('social sync service accurately computes 30-day reach and per-deliverable average views', function () {
    $service = new SocialSyncService;

    // Instagram 30d reach tiers
    expect($service->calculateInstagram30dViews(235))->toBe(752);
    expect($service->calculateInstagram30dViews(10000))->toBe(28000);
    expect($service->calculateInstagram30dViews(500000))->toBe(800000);

    // YouTube 30d views tiers
    expect($service->calculateYouTube30dViews(5000))->toBe(10000);
    expect($service->calculateYouTube30dViews(1150000))->toBe(632500);

    // Instagram Average Views per deliverable
    // 1. From real media
    $media = [
        ['is_reel' => true, 'view_count' => 638],
        ['is_reel' => true, 'view_count' => 488],
        ['is_reel' => true, 'view_count' => 775],
    ];
    expect($service->calculateAvgViews('instagram', 235, 752, $media))->toBe(634);

    // 2. From 30d views fallback
    expect($service->calculateAvgViews('instagram', 10000, 28000))->toBe(7840);
    expect($service->calculateAvgViews('youtube', 1150000, 632500))->toBe(158125);
});

test('instagram views aggregation excludes non-reels and media older than 30 days', function () {
    $service = new SocialSyncService;
    $now = now();

    $media = [
        ['media_product_type' => 'REELS', 'timestamp' => $now->copy()->subDays(2)->toIso8601String(), 'view_count' => 10000],
        ['media_product_type' => 'REELS', 'timestamp' => $now->copy()->subDays(29)->toIso8601String(), 'view_count' => 5000],
        ['media_product_type' => 'REELS', 'timestamp' => $now->copy()->subDays(31)->toIso8601String(), 'view_count' => 90000],
        ['media_product_type' => 'FEED', 'timestamp' => $now->toIso8601String(), 'view_count' => 70000],
        [],
    ];

    expect($service->instagramViews30d($media))->toBe(15000);
});

test('instagram engagement metrics compute averages and engagement rate', function () {
    $service = new SocialSyncService;

    $result = $service->instagramEngagementMetrics([
        ['like_count' => 1000, 'comments_count' => 50],
        ['like_count' => 500, 'comments_count' => 30],
    ], 10000);

    expect($result['avg_likes'])->toBe(750);
    expect($result['avg_comments'])->toBe(40);
    expect($result['engagement_rate'])->toBe(7.9);
});

test('instagram collaboration post detector distinguishes authentic collaborations from simple tags', function () {
    $service = new SocialSyncService;

    // 1. Joint caption with multiplication symbol (×)
    $collabItem1 = [
        'id' => '18037384658783836',
        'caption' => "Day 1 : Run. Refuel. Repeat.\nWith Anabolic Club, Brotein Bistro…\n@anabolic_club × @broteinbistro_india × @well_parth",
    ];
    expect($service->isCollaborationPost($collabItem1, 'wellparth'))->toBeTrue();

    // 2. Collab with 'x' or 'with' phrasing
    $collabItem2 = [
        'id' => '12345',
        'caption' => 'Excited for this drop! In collaboration with @nike #ad',
    ];
    expect($service->isCollaborationPost($collabItem2, 'creator'))->toBeTrue();

    // 3. Different owner username (co-authored media)
    $collabItem3 = [
        'id' => '67890',
        'caption' => 'Standard caption',
        'owner' => ['username' => 'brand_official'],
    ];
    expect($service->isCollaborationPost($collabItem3, 'influencer_user'))->toBeTrue();

    // 4. Standard solo post (not a collab)
    $soloItem = [
        'id' => '99999',
        'caption' => 'Morning coffee vibes ☕ #fyp #lifestyle',
        'owner' => ['username' => 'wellparth'],
    ];
    expect($service->isCollaborationPost($soloItem, 'wellparth'))->toBeFalse();
});

test('talent can add external collaboration reel link directly to their media grid', function () {
    $talentUser = User::create([
        'name' => 'Collab Creator',
        'email' => 'collab_creator_'.uniqid().'@example.com',
        'password' => Hash::make('password123'),
        'role' => 'talent',
        'status' => 'active',
    ]);

    $talent = TalentProfile::create([
        'user_id' => $talentUser->id,
        'display_name' => 'Collab Creator',
        'username' => 'collabcreator_'.uniqid(),
        'verification_level' => 1,
    ]);

    $account = SocialAccount::create([
        'talent_profile_id' => $talent->id,
        'platform' => 'instagram',
        'username' => 'collabcreator',
        'followers' => 25000,
        'recent_media' => [],
    ]);

    Http::fake([
        'https://www.instagram.com/p/DWvYrptCEWE/*' => Http::response(
            '<html><head><meta property="og:image" content="https://cdn.instagram.com/thumb.jpg"><meta property="og:description" content="500 likes, 25 comments - brand on April 5, 2026: &quot;Joint launch @brand × @collabcreator&quot;"></head></html>',
            200
        ),
    ]);

    $response = $this->actingAs($talentUser)->postJson(route('influencer.social.add_collab_reel'), [
        'url' => 'https://www.instagram.com/reel/DWvYrptCEWE/',
    ]);

    $response->assertOk();
    $response->assertJson(['success' => true]);

    $account->refresh();
    expect($account->recent_media)->toHaveCount(1);
    expect($account->recent_media[0]['is_collab'])->toBeTrue();
    expect($account->recent_media[0]['permalink'])->toBe('https://www.instagram.com/p/DWvYrptCEWE/');
});

test('talent can trigger 1-click sync for all connected social channels', function () {
    config(['services.youtube.api_key' => 'mock_youtube_key']);

    Http::fake([
        'https://www.googleapis.com/youtube/v3/channels*' => Http::response([
            'items' => [
                [
                    'statistics' => [
                        'subscriberCount' => '55000',
                        'viewCount' => '1200000',
                        'videoCount' => '120',
                    ],
                ],
            ],
        ], 200),
    ]);

    $talentUser = User::create([
        'name' => 'Creator OneClick',
        'email' => 'oneclick_'.uniqid().'@example.com',
        'password' => Hash::make('password123'),
        'role' => 'talent',
        'status' => 'active',
    ]);

    $talent = TalentProfile::create([
        'user_id' => $talentUser->id,
        'display_name' => 'Creator OneClick',
        'username' => 'oneclick_'.uniqid(),
        'verification_level' => 2,
    ]);

    SocialAccount::create([
        'talent_profile_id' => $talent->id,
        'platform' => 'youtube',
        'username' => 'oneclick_yt',
        'followers' => 50000,
        'engagement_rate' => 5.00,
    ]);

    $response = $this->actingAs($talentUser)->post(route('influencer.social.sync_all'));

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $account = SocialAccount::where('talent_profile_id', $talent->id)->first();
    expect($account->last_synced_at)->not->toBeNull();
    expect($account->followers)->toBe(55000);
    expect($account->sync_source)->toBe('google_youtube_api_v3');
});

test('invoice service accurately computes Intra-State Maharashtra CGST and SGST', function () {
    $brandUser = User::create([
        'name' => 'Mumbai Brand Lead',
        'email' => 'mumbai_'.uniqid().'@brand.com',
        'password' => Hash::make('password123'),
        'role' => 'brand',
        'status' => 'active',
    ]);

    $brand = BrandProfile::create([
        'user_id' => $brandUser->id,
        'company_name' => 'Mumbai Tech Media',
        'city' => 'Mumbai',
        'state' => 'Maharashtra',
        'gstin_pan' => '27ABCDE1234F1Z5',
    ]);

    $talentUser = User::create([
        'name' => 'Nashik Creator',
        'email' => 'nashik_'.uniqid().'@creator.com',
        'password' => Hash::make('password123'),
        'role' => 'talent',
        'status' => 'active',
    ]);

    $talent = TalentProfile::create([
        'user_id' => $talentUser->id,
        'display_name' => 'Nashik Creator',
        'username' => 'nashik_'.uniqid(),
        'city' => 'Nashik',
        'state' => 'Maharashtra',
    ]);

    $campaign = Campaign::create([
        'brand_profile_id' => $brand->id,
        'title' => 'Maharashtra Monsoon Campaign',
        'campaign_name' => 'Maharashtra Monsoon Campaign',
        'slug' => 'maharashtra-monsoon-'.uniqid(),
        'campaign_type' => 'influencer_campaign',
        'description' => 'Festive Monsoon Collection Showcase in Maharashtra.',
        'status' => 'published',
        'budget' => 50000,
    ]);

    $application = CampaignApplication::create([
        'campaign_id' => $campaign->id,
        'talent_profile_id' => $talent->id,
        'quoted_price' => 10000.00,
        'status' => 'confirmed',
    ]);

    $booking = Booking::create([
        'campaign_id' => $campaign->id,
        'application_id' => $application->id,
        'brand_profile_id' => $brand->id,
        'talent_profile_id' => $talent->id,
        'agreed_fee' => 10000.00,
        'platform_fee' => 1000.00,
        'total_amount' => 11000.00,
        'status' => 'confirmed',
    ]);

    $invoiceService = new InvoiceService;
    $result = $invoiceService->generateForBooking($booking);

    /** @var Invoice $brandInvoice */
    $brandInvoice = $result['brand_invoice'];
    /** @var Invoice $creatorReceipt */
    $creatorReceipt = $result['creator_receipt'];

    // Taxable base = 10,000 + 1,000 = 11,000
    // CGST (9%) = 990, SGST (9%) = 990, IGST = 0, Total Tax = 1,980, Grand Total = 12,980
    expect($brandInvoice->tax_type)->toBe('cgst_sgst');
    expect((float) $brandInvoice->taxable_amount)->toBe(11000.00);
    expect((float) $brandInvoice->cgst_amount)->toBe(990.00);
    expect((float) $brandInvoice->sgst_amount)->toBe(990.00);
    expect((float) $brandInvoice->igst_amount)->toBe(0.00);
    expect((float) $brandInvoice->total_tax_amount)->toBe(1980.00);
    expect((float) $brandInvoice->grand_total_amount)->toBe(12980.00);
    expect($brandInvoice->hsn_sac_code)->toBe('998365');
    expect($brandInvoice->invoice_number)->toStartWith('INV-');

    // Creator receipt = 10,000 net, zero platform fee deducted from creator
    expect($creatorReceipt->invoice_type)->toBe('creator_payout_receipt');
    expect((float) $creatorReceipt->grand_total_amount)->toBe(10000.00);
    expect($creatorReceipt->invoice_number)->toStartWith('REC-');
});

test('invoice service accurately computes Inter-State IGST for non-Maharashtra clients', function () {
    $brandUser = User::create([
        'name' => 'Bangalore Brand',
        'email' => 'blr_'.uniqid().'@brand.com',
        'password' => Hash::make('password123'),
        'role' => 'brand',
        'status' => 'active',
    ]);

    $brand = BrandProfile::create([
        'user_id' => $brandUser->id,
        'company_name' => 'Bangalore Startups Hub',
        'headquarters' => 'Bengaluru, Karnataka',
        'gstin_pan' => '29XYZAB5678C1Z2',
    ]);

    $talentUser = User::create([
        'name' => 'Pune Artist',
        'email' => 'pune_'.uniqid().'@creator.com',
        'password' => Hash::make('password123'),
        'role' => 'talent',
        'status' => 'active',
    ]);

    $talent = TalentProfile::create([
        'user_id' => $talentUser->id,
        'display_name' => 'Pune Artist',
        'username' => 'pune_'.uniqid(),
        'city' => 'Pune',
        'state' => 'Maharashtra',
    ]);

    $campaign = Campaign::create([
        'brand_profile_id' => $brand->id,
        'title' => 'Pan-India App Launch',
        'campaign_name' => 'Pan-India App Launch',
        'slug' => 'pan-india-app-'.uniqid(),
        'campaign_type' => 'influencer_campaign',
        'description' => 'Pan-India Digital App Creator Promotion.',
        'status' => 'published',
        'budget' => 20000,
    ]);

    $application = CampaignApplication::create([
        'campaign_id' => $campaign->id,
        'talent_profile_id' => $talent->id,
        'quoted_price' => 20000.00,
        'status' => 'confirmed',
    ]);

    $booking = Booking::create([
        'campaign_id' => $campaign->id,
        'application_id' => $application->id,
        'brand_profile_id' => $brand->id,
        'talent_profile_id' => $talent->id,
        'agreed_fee' => 20000.00,
        'platform_fee' => 2000.00,
        'total_amount' => 22000.00,
        'status' => 'confirmed',
    ]);

    $invoiceService = new InvoiceService;
    $result = $invoiceService->generateForBooking($booking);

    /** @var Invoice $brandInvoice */
    $brandInvoice = $result['brand_invoice'];

    // Taxable base = 22,000. IGST (18%) = 3,960. Grand Total = 25,960.
    expect($brandInvoice->tax_type)->toBe('igst');
    expect((float) $brandInvoice->cgst_amount)->toBe(0.00);
    expect((float) $brandInvoice->sgst_amount)->toBe(0.00);
    expect((float) $brandInvoice->igst_amount)->toBe(3960.00);
    expect((float) $brandInvoice->grand_total_amount)->toBe(25960.00);
});

test('approving deliverable automatically generates tax invoice and makes views accessible to brand, creator, and admin', function () {
    $brandUser = User::create([
        'name' => 'Verified Brand Client',
        'email' => 'brand_client_'.uniqid().'@test.com',
        'password' => Hash::make('password123'),
        'role' => 'brand',
        'status' => 'active',
    ]);

    $brand = BrandProfile::create([
        'user_id' => $brandUser->id,
        'company_name' => 'Apex Apparel Inc',
        'city' => 'Mumbai',
        'state' => 'Maharashtra',
    ]);

    $talentUser = User::create([
        'name' => 'Top Fashion Influencer',
        'email' => 'fashion_'.uniqid().'@test.com',
        'password' => Hash::make('password123'),
        'role' => 'talent',
        'status' => 'active',
    ]);

    $talent = TalentProfile::create([
        'user_id' => $talentUser->id,
        'display_name' => 'Apex Model',
        'username' => 'apexmodel_'.uniqid(),
        'city' => 'Mumbai',
        'state' => 'Maharashtra',
    ]);

    $adminUser = User::create([
        'name' => 'Platform Admin',
        'email' => 'admin_inv_'.uniqid().'@tdinfluence.com',
        'password' => Hash::make('password123'),
        'role' => 'admin',
        'status' => 'active',
    ]);

    $campaign = Campaign::create([
        'brand_profile_id' => $brand->id,
        'title' => 'Summer Festive Line',
        'campaign_name' => 'Summer Festive Line',
        'slug' => 'summer-festive-'.uniqid(),
        'campaign_type' => 'influencer_campaign',
        'description' => 'Festive Summer Influencer Catalog Shoot.',
        'status' => 'published',
        'budget' => 15000,
    ]);

    $application = CampaignApplication::create([
        'campaign_id' => $campaign->id,
        'talent_profile_id' => $talent->id,
        'quoted_price' => 15000.00,
        'status' => 'confirmed',
    ]);

    $booking = Booking::create([
        'campaign_id' => $campaign->id,
        'application_id' => $application->id,
        'brand_profile_id' => $brand->id,
        'talent_profile_id' => $talent->id,
        'agreed_fee' => 15000.00,
        'platform_fee' => 1500.00,
        'total_amount' => 16500.00,
        'status' => 'deliverables_submitted',
    ]);

    $submission = DeliverableSubmission::create([
        'booking_id' => $booking->id,
        'talent_profile_id' => $talent->id,
        'deliverable_url' => 'https://instagram.com/p/C_festive_post',
        'notes' => 'Deliverables live on Instagram with sponsor tags.',
        'status' => 'submitted',
    ]);

    // 1. Brand approves deliverable & releases escrow
    $approveResponse = $this->actingAs($brandUser)->post(route('brand.bookings.approve', [
        'bookingId' => $booking->id,
        'submissionId' => $submission->id,
    ]));

    $approveResponse->assertRedirect();
    $approveResponse->assertSessionHas('success');

    $booking->refresh();
    expect($booking->status)->toBe('completed');

    $brandInvoice = Invoice::where('booking_id', $booking->id)->where('invoice_type', 'brand_tax_invoice')->first();
    expect($brandInvoice)->not->toBeNull();

    $creatorReceipt = Invoice::where('booking_id', $booking->id)->where('invoice_type', 'creator_payout_receipt')->first();
    expect($creatorReceipt)->not->toBeNull();

    // 2. Brand Views Invoices
    $this->actingAs($brandUser)
        ->get(route('brand.invoices'))
        ->assertStatus(200)
        ->assertSee($brandInvoice->invoice_number)
        ->assertSee('Summer Festive Line');

    $this->actingAs($brandUser)
        ->get(route('brand.invoices.show', $brandInvoice->id))
        ->assertStatus(200)
        ->assertSee('TAX INVOICE')
        ->assertSee($brandInvoice->invoice_number)
        ->assertSee('Apex Apparel Inc')
        ->assertSee('998365');

    // 3. Creator Views Payout Receipts
    $this->actingAs($talentUser)
        ->get(route('influencer.invoices'))
        ->assertStatus(200)
        ->assertSee($creatorReceipt->invoice_number)
        ->assertSee('Summer Festive Line');

    $this->actingAs($talentUser)
        ->get(route('influencer.invoices.show', $creatorReceipt->id))
        ->assertStatus(200)
        ->assertSee('PAYOUT RECEIPT')
        ->assertSee($creatorReceipt->invoice_number)
        ->assertSee('Apex Model');

    // 4. Admin Views Platform Central Tax Ledger
    $this->actingAs($adminUser)
        ->get(route('admin.invoices'))
        ->assertStatus(200)
        ->assertSee($brandInvoice->invoice_number)
        ->assertSee($creatorReceipt->invoice_number);

    $this->actingAs($adminUser)
        ->get(route('admin.invoices.show', $brandInvoice->id))
        ->assertStatus(200)
        ->assertSee($brandInvoice->invoice_number)
        ->assertSee('Audit Invoice');
});

test('instagram oauth reels and permalinks format properly and display on creator profile', function () {
    $service = new SocialSyncService;

    $mockMedia = [
        [
            'id' => '18029384756192837',
            'caption' => 'Latest festive campaign shoot for @zara #ad',
            'media_type' => 'VIDEO',
            'media_product_type' => 'REELS',
            'permalink' => 'https://www.instagram.com/reel/C8xK9yZ001/',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600&h=400&fit=crop',
            'view_count' => 125000,
            'like_count' => 8400,
            'comments_count' => 320,
            'timestamp' => now()->subDays(3)->toIso8601String(),
        ],
        [
            'id' => '18029384756192838',
            'caption' => 'Studio portrait series behind the scenes',
            'media_type' => 'IMAGE',
            'media_product_type' => 'FEED',
            'permalink' => 'https://www.instagram.com/p/C8xK9yZ002/',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=600&h=400&fit=crop',
            'view_count' => 0,
            'like_count' => 3100,
            'comments_count' => 95,
            'timestamp' => now()->subDays(5)->toIso8601String(),
        ],
    ];

    $formatted = $service->formatInstagramMedia($mockMedia);

    expect($formatted)->toHaveCount(2);
    expect($formatted[0]['is_reel'])->toBeTrue();
    expect($formatted[0]['permalink'])->toBe('https://www.instagram.com/p/C8xK9yZ001/');
    expect($formatted[0]['view_count'])->toBe(125000);
    expect($formatted[0]['caption'])->toContain('festive campaign');

    // Create talent with verified social account containing recent_media
    $user = User::factory()->create(['role' => 'talent', 'status' => 'active']);
    $talent = TalentProfile::create([
        'user_id' => $user->id,
        'username' => 'reeltalent_99',
        'display_name' => 'Reel Creator',
        'is_profile_complete' => true,
    ]);

    SocialAccount::create([
        'talent_profile_id' => $talent->id,
        'platform' => 'instagram',
        'username' => 'reeltalent_99',
        'followers' => 45000,
        'views_30d' => 125000,
        'recent_media' => $formatted,
        'is_verified' => true,
    ]);

    // Public / Brand profile view shows the verified reels section and watch link
    $this->get(route('influencers.public.show', 'reeltalent_99'))
        ->assertStatus(200)
        ->assertSee('Verified Reels & Video Performance', false)
        ->assertSee('https://www.instagram.com/p/C8xK9yZ001/', false)
        ->assertSee('Watch on Instagram');
});

test('talent profile and brand studio render interactive timeframe performance filters', function () {
    $user = User::factory()->create(['role' => 'talent', 'status' => 'active']);
    $talent = TalentProfile::create([
        'user_id' => $user->id,
        'username' => 'filter_tester_'.uniqid(),
        'display_name' => 'Filter Tester',
        'is_profile_complete' => true,
    ]);

    SocialAccount::create([
        'talent_profile_id' => $talent->id,
        'platform' => 'instagram',
        'username' => 'filter_tester',
        'followers' => 25000,
        'views_30d' => 70000,
        'avg_views' => 20000,
        'avg_likes' => 1200,
        'avg_comments' => 60,
        'engagement_rate' => 5.04,
        'recent_media' => [
            [
                'id' => 'reel_test_1',
                'is_reel' => true,
                'caption' => 'Amazing summer look #fashion',
                'permalink' => 'https://www.instagram.com/reel/C9xTest001/',
                'view_count' => 25000,
                'like_count' => 1500,
                'comments_count' => 80,
                'timestamp' => now()->subDays(4)->toIso8601String(),
            ],
        ],
        'is_verified' => true,
    ]);

    // Check Public Discovery Page
    $response = $this->get(route('influencers.public.show', $talent->username));
    $response->assertStatus(200);
    $response->assertSee('7 Days');
    $response->assertSee('30 Days');
    $response->assertSee('90 Days');
    $response->assertSee('Custom');
    $response->assertSee('Avg Views / Reel');
    $response->assertSee('Avg Likes / Reel');
    $response->assertSee('Avg Comments / Reel');

    // Check Creator Studio Page
    $studioResp = $this->actingAs($user)->get(route('influencer.social'));
    $studioResp->assertStatus(200);
    $studioResp->assertSee('7 Days');
    $studioResp->assertSee('30 Days');
    $studioResp->assertSee('90 Days');
    $studioResp->assertSee('Custom');
});

test('influencer profile supports uploading local photo and updating avatar', function () {
    Storage::fake('public');

    $user = User::factory()->create(['role' => 'talent', 'status' => 'active']);
    $talent = TalentProfile::create([
        'user_id' => $user->id,
        'username' => 'photo_tester_'.uniqid(),
        'display_name' => 'Photo Tester',
    ]);

    $file = UploadedFile::fake()->create('my_portrait.jpg', 500, 'image/jpeg');

    $response = $this->actingAs($user)->post(route('influencer.profile'), [
        'display_name' => 'Updated Photo Talent',
        'profile_image_file' => $file,
    ]);

    $response->assertSessionHasNoErrors();
    $talent->refresh();
    $user->refresh();

    expect($talent->profile_image)->not->toBeNull();
    expect($talent->profile_image)->toContain('storage/avatars/');
    expect($user->avatar)->toBe($talent->profile_image);
});

test('influencer profile supports auto-fetching avatar from instagram endpoint', function () {
    $user = User::factory()->create(['role' => 'talent', 'status' => 'active']);
    $talent = TalentProfile::create([
        'user_id' => $user->id,
        'username' => 'auto_avatar_'.uniqid(),
        'display_name' => 'Auto Avatar Talent',
    ]);

    SocialAccount::create([
        'talent_profile_id' => $talent->id,
        'platform' => 'instagram',
        'username' => 'creator_insta_test',
        'followers' => 12000,
    ]);

    $response = $this->actingAs($user)->postJson(route('influencer.profile.fetch_social_avatar'), [
        'platform' => 'instagram',
        'username' => 'creator_insta_test',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['success' => true]);

    $talent->refresh();
    expect($talent->profile_image)->not->toBeNull();
});
