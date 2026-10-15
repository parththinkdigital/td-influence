<?php

namespace Database\Seeders;

use App\Models\AppNotification;
use App\Models\Booking;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\CampaignDeliverable;
use App\Models\CampaignQuestion;
use App\Models\CampaignUsageRight;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Industry;
use App\Models\Message;
use App\Models\Review;
use App\Models\SocialAccount;
use App\Models\TalentPortfolio;
use App\Models\TalentProfile;
use App\Models\TalentRate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Industries
        $fashionInd = Industry::create(['name' => 'Fashion & Apparel', 'slug' => 'fashion-apparel']);
        $beautyInd = Industry::create(['name' => 'Beauty & Cosmetics', 'slug' => 'beauty-cosmetics']);
        $techInd = Industry::create(['name' => 'Consumer Electronics', 'slug' => 'consumer-electronics']);
        $foodInd = Industry::create(['name' => 'Food & Beverage', 'slug' => 'food-beverage']);

        // 2. Categories
        $modelingCat = Category::create(['name' => 'Fashion & Runway Modeling', 'slug' => 'fashion-modeling', 'type' => 'modeling']);
        $influencerCat = Category::create(['name' => 'Social Media Influencer', 'slug' => 'influencer', 'type' => 'influencer']);
        $anchorCat = Category::create(['name' => 'Event & TV Anchor', 'slug' => 'event-anchor', 'type' => 'anchor']);
        $ugcCat = Category::create(['name' => 'UGC Video Creator', 'slug' => 'ugc-creator', 'type' => 'ugc']);

        // 3. Admin Account
        User::create([
            'name' => 'Platform Administrator',
            'email' => 'admin@td.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // 4. Brand Account
        $brandUser = User::create([
            'name' => 'Aura Luxe Fashion',
            'email' => 'brand@td.com',
            'password' => Hash::make('123456'),
            'role' => 'brand',
            'status' => 'active',
        ]);

        $brandProfile = BrandProfile::create([
            'user_id' => $brandUser->id,
            'company_name' => 'Aura Luxe International',
            'website' => 'https://auraluxe.com',
            'industry_id' => $fashionInd->id,
            'description' => 'Premium luxury apparel and haute couture fashion brand with flagship studios in Nashik & Mumbai.',
            'year_established' => 2018,
            'company_size' => '51-200',
            'headquarters' => 'College Road, Nashik, Maharashtra',
            'cities_served' => 'Nashik, Pune, Mumbai, Thane',
            'contact_person' => 'Ria Sharma',
            'contact_designation' => 'Head of Brand Marketing',
            'contact_phone' => '+91 98765 43210',
            'gstin_pan' => '27AAACA12341ZB',
            'verification_status' => 'verified',
        ]);

        // 5. Talent Account 1: Model
        $modelUser = User::create([
            'name' => 'Arya Varma',
            'email' => 'model@td.com',
            'password' => Hash::make('123456'),
            'role' => 'talent',
            'status' => 'active',
        ]);

        $modelProfile = TalentProfile::create([
            'user_id' => $modelUser->id,
            'username' => 'arya_varma',
            'display_name' => 'Arya Varma',
            'gender' => 'female',
            'dob' => '1998-05-14',
            'city' => 'Nashik',
            'state' => 'Maharashtra',
            'country' => 'India',
            'languages' => ['English', 'Hindi', 'Marathi'],
            'height_cm' => 176,
            'weight_kg' => 54.5,
            'chest_waist_hip' => '34-26-36',
            'shoe_size' => '39 EU / 6 UK',
            'clothing_size' => 'S',
            'hair_color' => 'Dark Brown',
            'eye_color' => 'Hazel',
            'primary_categories' => ['modeling', 'influencer'],
            'bio' => 'Professional fashion and editorial model based in Nashik with 4+ years runway and campaign experience across Maharashtra.',
            'verification_level' => 5,
            'completion_rate' => 98.00,
            'response_rate' => 95.00,
            'rating_avg' => 4.90,
            'reviews_count' => 14,
        ]);

        TalentPortfolio::create([
            'talent_profile_id' => $modelProfile->id,
            'title' => 'Vogue Autumn Vineyard Catalogue Shoot',
            'category' => 'modeling',
            'description' => 'Editorial shoot featured in Vogue India, shot at Sula Vineyards, Nashik.',
            'media_files' => ['https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600'],
            'brand_worked_with' => 'Vogue India',
            'event_date' => '2025-09-10',
            'location' => 'Sula Vineyards, Govardhan, Nashik',
            'role_played' => 'Lead Female Model',
            'campaign_type' => 'Editorial Photoshoot',
        ]);

        TalentRate::create([
            'talent_profile_id' => $modelProfile->id,
            'rate_type' => 'full_day',
            'rate_amount' => 35000.00,
            'currency' => 'INR',
            'is_negotiable' => true,
        ]);

        // 6. Talent Account 2: Influencer
        $infUser = User::create([
            'name' => 'Karan Malhotra',
            'email' => 'influencer@td.com',
            'password' => Hash::make('123456'),
            'role' => 'talent',
            'status' => 'active',
        ]);

        $infProfile = TalentProfile::create([
            'user_id' => $infUser->id,
            'username' => 'karan_creates',
            'display_name' => 'Karan Malhotra',
            'gender' => 'male',
            'dob' => '1996-08-22',
            'city' => 'Nashik',
            'state' => 'Maharashtra',
            'country' => 'India',
            'languages' => ['English', 'Hindi', 'Marathi'],
            'primary_categories' => ['influencer', 'ugc'],
            'bio' => 'Tech & lifestyle content creator based in Gangapur Road, Nashik with 250K+ engaged followers across Instagram and YouTube.',
            'verification_level' => 4,
            'completion_rate' => 100.00,
            'response_rate' => 98.00,
            'rating_avg' => 4.85,
            'reviews_count' => 9,
        ]);

        SocialAccount::create([
            'talent_profile_id' => $infProfile->id,
            'platform' => 'instagram',
            'username' => 'karan_creates',
            'profile_url' => 'https://instagram.com/karan_creates',
            'followers' => 185000,
            'following' => 450,
            'posts_count' => 620,
            'avg_views' => 45000,
            'avg_likes' => 12000,
            'engagement_rate' => 6.48,
            'is_verified' => true,
        ]);

        TalentRate::create([
            'talent_profile_id' => $infProfile->id,
            'rate_type' => 'instagram_reel',
            'rate_amount' => 25000.00,
            'currency' => 'INR',
            'is_negotiable' => false,
        ]);

        // 7. Talent Account 3: Anchor
        $anchorUser = User::create([
            'name' => 'Simran Kapoor',
            'email' => 'anchor@td.com',
            'password' => Hash::make('123456'),
            'role' => 'talent',
            'status' => 'active',
        ]);

        $anchorProfile = TalentProfile::create([
            'user_id' => $anchorUser->id,
            'username' => 'simran_hosts',
            'display_name' => 'Simran Kapoor',
            'gender' => 'female',
            'city' => 'Nashik',
            'state' => 'Maharashtra',
            'country' => 'India',
            'languages' => ['English', 'Hindi', 'Marathi', 'Punjabi'],
            'years_experience' => 6,
            'hosting_style' => 'High Energy Corporate, Vineyard Fest & Award Show Emcee',
            'voice_style' => 'Warm, Eloquent, Clear Accent',
            'has_stage_exp' => true,
            'has_tv_radio_exp' => true,
            'primary_categories' => ['anchor'],
            'bio' => 'Celebrity emcee and corporate event anchor having hosted 200+ summits, wine fests, and award galas across Nashik, Pune & Mumbai.',
            'verification_level' => 5,
            'completion_rate' => 100.00,
            'response_rate' => 100.00,
            'rating_avg' => 5.00,
            'reviews_count' => 22,
        ]);

        // 7b. Talent Account 4: Gargi (Creator)
        $gargiUser = User::create([
            'name' => 'Gargi Kulkarni',
            'email' => 'gargi@td.com',
            'password' => Hash::make('123456'),
            'role' => 'talent',
            'status' => 'active',
        ]);

        $gargiProfile = TalentProfile::create([
            'user_id' => $gargiUser->id,
            'username' => 'gargi_era',
            'display_name' => 'Gargi Kulkarni',
            'gender' => 'female',
            'dob' => '2000-03-12',
            'city' => 'Nashik',
            'state' => 'Maharashtra',
            'country' => 'India',
            'languages' => ['English', 'Hindi', 'Marathi'],
            'primary_categories' => ['influencer', 'ugc'],
            'bio' => 'Fashion, beauty, and local lifestyle creator from College Road, Nashik sharing daily aesthetic finds and honest product reviews.',
            'verification_level' => 4,
            'completion_rate' => 100.00,
            'response_rate' => 96.00,
            'rating_avg' => 4.90,
            'reviews_count' => 6,
        ]);

        SocialAccount::create([
            'talent_profile_id' => $gargiProfile->id,
            'platform' => 'instagram',
            'username' => 'gargi_era',
            'profile_url' => 'https://instagram.com/gargi_era',
            'followers' => 840,
            'following' => 310,
            'posts_count' => 85,
            'avg_views' => 2100,
            'avg_likes' => 180,
            'engagement_rate' => 7.20,
            'is_verified' => false,
        ]);

        TalentRate::create([
            'talent_profile_id' => $gargiProfile->id,
            'rate_type' => 'instagram_reel',
            'rate_amount' => 8500.00,
            'currency' => 'INR',
            'is_negotiable' => true,
        ]);

        // 8. Sample Campaign / Job Creation by Brand
        $campaign = Campaign::create([
            'brand_profile_id' => $brandProfile->id,
            'title' => 'Aura Festive Collection 2026 Photoshoot & Reel Campaign',
            'campaign_name' => 'Aura Festiva 2026',
            'slug' => 'aura-festive-collection-2026',
            'category_id' => $modelingCat->id,
            'campaign_type' => 'photoshoot',
            'industry_id' => $fashionInd->id,
            'objective' => 'Launch high-end festive ethnic wear line across digital & print media with scenic heritage look',
            'description' => 'Looking for top female models and fashion influencers for our upcoming Festive Collection shoot at vineyard & heritage locations in Nashik.',
            'talent_type' => 'model',
            'number_required' => 2,
            'gender_req' => 'female',
            'age_min' => 20,
            'age_max' => 30,
            'height_min_cm' => 170,
            'height_max_cm' => 182,
            'experience_req' => 'At least 2 years in fashion lookbooks or brand shoots',
            'languages_req' => ['English', 'Hindi', 'Marathi'],
            'work_mode' => 'on_site',
            'country' => 'India',
            'state' => 'Maharashtra',
            'city' => 'Nashik',
            'venue' => 'Sula Vineyards & Heritage Resort Studio',
            'address' => 'Gangapur-Savargaon Road, Govardhan Village, Nashik, Maharashtra 422222',
            'travel_required' => true,
            'travel_reimbursement' => true,
            'accommodation_provided' => true,
            'transport_provided' => true,
            'application_deadline' => '2026-09-25',
            'shoot_date' => '2026-10-05',
            'start_time' => '09:00:00',
            'end_time' => '18:00:00',
            'duration_days' => 2,
            'call_time' => '08:00 AM',
            'budget_type' => 'fixed',
            'budget_min' => 40000.00,
            'budget_max' => 60000.00,
            'currency' => 'INR',
            'status' => 'published',
        ]);

        CampaignDeliverable::create([
            'campaign_id' => $campaign->id,
            'name' => 'High-Res Edited Outfit Photos',
            'type' => 'photo_pack',
            'quantity' => 15,
            'description' => '15 retouched fashion images per model in brand ethnic outfits.',
        ]);

        CampaignDeliverable::create([
            'campaign_id' => $campaign->id,
            'name' => 'Behind The Scenes Instagram Reel',
            'type' => 'reel',
            'quantity' => 1,
            'description' => '1 Instagram reel collaboration post tagging @auraluxe.',
        ]);

        CampaignUsageRight::create([
            'campaign_id' => $campaign->id,
            'channels' => ['organic_social', 'paid_ads', 'website', 'e_commerce', 'print'],
            'duration' => '12_months',
            'geography' => 'India',
            'exclusivity' => 'category',
        ]);

        CampaignQuestion::create([
            'campaign_id' => $campaign->id,
            'question_text' => 'Have you worked with luxury ethnic fashion brands before? Please specify.',
            'is_required' => true,
        ]);

        // 9. Sample Application
        $application = CampaignApplication::create([
            'campaign_id' => $campaign->id,
            'talent_profile_id' => $modelProfile->id,
            'cover_note' => 'I would love to be the face of Aura Festiva! Based in Nashik, height 176cm, with extensive experience in luxury brand shoots and ethnic campaigns.',
            'quoted_price' => 50000.00,
            'selected_portfolio_ids' => [1],
            'answers' => [1 => 'Yes, worked with luxury ethnic fashion brands and local designer houses across Nashik & Mumbai.'],
            'status' => 'shortlisted',
        ]);

        // 10. Sample Conversation & Message
        $conversation = Conversation::create([
            'campaign_id' => $campaign->id,
            'application_id' => $application->id,
            'brand_user_id' => $brandUser->id,
            'talent_user_id' => $modelUser->id,
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $brandUser->id,
            'message_text' => 'Hi Arya! We reviewed your portfolio and loved your work. Are you available on Oct 5th & 6th in Nashik?',
            'proposal_price' => 50000.00,
            'proposal_status' => 'accepted',
            'read_at' => now(),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $modelUser->id,
            'message_text' => 'Hi Ria! Yes, I am located in Nashik and fully available on those dates. Happy to proceed!',
            'read_at' => now(),
        ]);

        // Sample App Notifications
        AppNotification::send(
            $modelUser->id,
            'Commercial Offer Accepted!',
            'Sula Studios confirmed your rate of ₹50,000 for the Festive Lookbook Shoot in Nashik.',
            route('influencer.bookings'),
            'booking',
            $brandUser->id
        );

        AppNotification::send(
            $brandUser->id,
            'New Talent Application',
            'Arya Joshi applied to Festive Lookbook Photoshoot with a quote of ₹50,000.',
            route('brand.campaigns.show', $campaign->id),
            'application',
            $modelUser->id
        );

        // 11. Sample Booking & Review
        $booking = Booking::create([
            'campaign_id' => $campaign->id,
            'application_id' => $application->id,
            'brand_profile_id' => $brandProfile->id,
            'talent_profile_id' => $modelProfile->id,
            'agreed_fee' => 50000.00,
            'platform_fee' => 5000.00,
            'total_amount' => 55000.00,
            'shoot_date' => '2026-10-05',
            'location' => 'Sula Vineyards Resort Studio, Nashik',
            'status' => 'completed',
        ]);

        Review::create([
            'booking_id' => $booking->id,
            'reviewer_id' => $brandUser->id,
            'reviewee_id' => $modelUser->id,
            'rating_overall' => 5,
            'professionalism_rating' => 5,
            'punctuality_rating' => 5,
            'communication_rating' => 5,
            'quality_rating' => 5,
            'review_text' => 'Arya was exceptional! Punctual, extremely professional, and delivered top-tier shots.',
        ]);
    }
}
