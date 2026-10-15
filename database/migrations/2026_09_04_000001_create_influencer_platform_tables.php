<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Users table modifications
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->unique()->after('email');
            }
            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'brand', 'talent', 'influencer'])->default('talent')->after('password');
            }
            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('role');
            }
            if (! Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('status');
            }
        });

        // 2. Industries
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // 3. Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('general'); // modeling, influencer, anchor, ugc, styling, photography
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // 4. Brand Profiles
        Schema::create('brand_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->foreignId('industry_id')->nullable()->constrained('industries')->onDelete('set null');
            $table->text('description')->nullable();
            $table->integer('year_established')->nullable();
            $table->string('company_size')->nullable(); // 1-10, 11-50, 51-200, 200+
            $table->string('headquarters')->nullable();
            $table->string('cities_served')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_designation')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('gstin_pan')->nullable();
            $table->string('verification_status')->default('unverified'); // unverified, pending, verified
            $table->json('verification_docs')->nullable();
            $table->timestamps();
        });

        // 5. Talent Profiles (Models, Influencers, Anchors, UGC Creators, Photographers, etc.)
        Schema::create('talent_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('username')->nullable()->unique();
            $table->string('display_name')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('gender')->nullable(); // male, female, non_binary, other
            $table->date('dob')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('India');
            $table->json('languages')->nullable(); // ["English", "Hindi", "Marathi"]

            // Model-specific fields
            $table->integer('height_cm')->nullable();
            $table->decimal('weight_kg', 5, 2)->nullable();
            $table->string('chest_waist_hip')->nullable(); // e.g. "36-28-36"
            $table->string('shoe_size')->nullable();
            $table->string('clothing_size')->nullable(); // XS, S, M, L, XL
            $table->string('hair_color')->nullable();
            $table->string('eye_color')->nullable();
            $table->string('beard')->nullable(); // clean_shaved, stubble, full_beard, n_a
            $table->string('tattoos_piercings')->nullable();

            // Anchor & UGC creator fields
            $table->integer('years_experience')->default(0);
            $table->string('hosting_style')->nullable();
            $table->string('voice_style')->nullable();
            $table->boolean('has_stage_exp')->default(false);
            $table->boolean('has_tv_radio_exp')->default(false);

            // Categories & Bio
            $table->json('primary_categories')->nullable(); // ["modeling", "influencer", "anchor"]
            $table->text('bio')->nullable();

            // Verification & Marketplace Reputation Metrics
            $table->integer('verification_level')->default(1); // 1: Email, 2: Mobile, 3: ID, 4: Portfolio, 5: Platform Verified
            $table->decimal('completion_rate', 5, 2)->default(100.00);
            $table->decimal('response_rate', 5, 2)->default(100.00);
            $table->decimal('rating_avg', 3, 2)->default(5.00);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->timestamps();
        });

        // 6. Talent Portfolios
        Schema::create('talent_portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_profile_id')->constrained('talent_profiles')->onDelete('cascade');
            $table->string('title');
            $table->string('category')->nullable(); // modeling, photoshoot, hosting, video
            $table->text('description')->nullable();
            $table->json('media_files')->nullable(); // Array of image/video URLs
            $table->string('brand_worked_with')->nullable();
            $table->date('event_date')->nullable();
            $table->string('location')->nullable();
            $table->string('role_played')->nullable();
            $table->string('campaign_type')->nullable();
            $table->timestamps();
        });

        // 7. Social Accounts (Influencers / Content Creators)
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_profile_id')->constrained('talent_profiles')->onDelete('cascade');
            $table->string('platform'); // instagram, youtube, facebook, tiktok, x, snapchat
            $table->string('username');
            $table->string('profile_url')->nullable();
            $table->unsignedBigInteger('followers')->default(0);
            $table->unsignedBigInteger('following')->default(0);
            $table->unsignedBigInteger('posts_count')->default(0);
            $table->unsignedBigInteger('avg_views')->default(0);
            $table->unsignedBigInteger('views_30d')->default(0);
            $table->unsignedBigInteger('avg_likes')->default(0);
            $table->unsignedBigInteger('avg_comments')->default(0);
            $table->decimal('engagement_rate', 5, 2)->default(0.00);
            $table->json('audience_demographics')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });

        // 8. Talent Rate Cards
        Schema::create('talent_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_profile_id')->constrained('talent_profiles')->onDelete('cascade');
            $table->string('rate_type'); // hourly, half_day, full_day, per_shoot, per_campaign, instagram_post, instagram_reel, instagram_story, youtube_video, ugc_video
            $table->decimal('rate_amount', 12, 2);
            $table->string('currency')->default('INR');
            $table->boolean('is_negotiable')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 9. Talent Availability Calendar
        Schema::create('talent_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_profile_id')->constrained('talent_profiles')->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['available', 'tentative', 'booked', 'unavailable'])->default('available');
            $table->string('notes')->nullable();
            $table->timestamps();
        });

        // 10. Campaigns / Jobs
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_profile_id')->constrained('brand_profiles')->onDelete('cascade');
            $table->string('title');
            $table->string('campaign_name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('campaign_type'); // photoshoot, video_shoot, advertisement, influencer_campaign, instagram_campaign, product_promotion, event, corporate_event, wedding, fashion_show, catalogue, ugc, tv_ott, music_video, print, voice_over, hosting
            $table->foreignId('industry_id')->nullable()->constrained('industries')->onDelete('set null');
            $table->string('objective')->nullable();
            $table->text('description');

            // Talent Requirements
            $table->string('talent_type')->default('any'); // model, influencer, anchor, ugc_creator, photographer, etc.
            $table->integer('number_required')->default(1);
            $table->string('gender_req')->default('any'); // any, female, male, non_binary
            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();
            $table->integer('height_min_cm')->nullable();
            $table->integer('height_max_cm')->nullable();
            $table->string('experience_req')->nullable();
            $table->json('languages_req')->nullable();
            $table->text('look_requirements')->nullable();

            // Location & Schedule
            $table->string('work_mode')->default('on_site'); // remote, on_site, hybrid
            $table->string('country')->default('India');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('venue')->nullable();
            $table->text('address')->nullable();
            $table->boolean('travel_required')->default(false);
            $table->boolean('travel_reimbursement')->default(false);
            $table->boolean('accommodation_provided')->default(false);
            $table->boolean('transport_provided')->default(false);

            $table->date('application_deadline')->nullable();
            $table->date('shoot_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('duration_days')->default(1);
            $table->date('backup_date')->nullable();
            $table->string('call_time')->nullable();

            // Budget & Pricing
            $table->string('budget_type')->default('fixed'); // fixed, hourly, negotiable
            $table->decimal('budget_min', 12, 2)->default(0.00);
            $table->decimal('budget_max', 12, 2)->default(0.00);
            $table->string('currency')->default('INR');
            $table->string('status')->default('pending_review'); // draft, pending_review, published, paused, in_progress, completed, cancelled

            $table->timestamps();
        });

        // 11. Campaign Deliverables
        Schema::create('campaign_deliverables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // reel, post, story, youtube_video, short, photo_pack, outfit_change, event_duration, ugc_qty
            $table->integer('quantity')->default(1);
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();
        });

        // 12. Campaign Usage Rights
        Schema::create('campaign_usage_rights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->json('channels')->nullable(); // ["organic_social", "paid_ads", "website", "ecommerce", "print", "billboard", "tv", "ott"]
            $table->string('duration')->default('3_months'); // 1_month, 3_months, 6_months, 12_months, perpetual
            $table->string('geography')->default('India'); // local, state, India, international
            $table->string('exclusivity')->default('none'); // none, category, full
            $table->timestamps();
        });

        // 13. Campaign Custom Questions
        Schema::create('campaign_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->string('question_text');
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });

        // 14. Campaign Applications
        Schema::create('campaign_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->foreignId('talent_profile_id')->constrained('talent_profiles')->onDelete('cascade');
            $table->text('cover_note')->nullable();
            $table->decimal('quoted_price', 12, 2);
            $table->json('selected_portfolio_ids')->nullable(); // Array of portfolio IDs
            $table->json('answers')->nullable(); // {"question_id": "answer_text"}
            $table->string('status')->default('applied'); // applied, viewed, shortlisted, discussion, selected, contract, payment_pending, confirmed, rejected, withdrawn
            $table->timestamps();
        });

        // 15. Conversations & Internal Chat
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->foreignId('application_id')->nullable()->constrained('campaign_applications')->onDelete('cascade');
            $table->foreignId('brand_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('talent_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // 16. Messages & Structured Counter-offers
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->text('message_text')->nullable();
            $table->json('attachments')->nullable();
            $table->decimal('proposal_price', 12, 2)->nullable();
            $table->string('proposal_status')->default('none'); // none, proposed, countered, accepted, rejected
            $table->timestamps();
        });

        // 17. Bookings & Contracts
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->foreignId('application_id')->constrained('campaign_applications')->onDelete('cascade');
            $table->foreignId('brand_profile_id')->constrained('brand_profiles')->onDelete('cascade');
            $table->foreignId('talent_profile_id')->constrained('talent_profiles')->onDelete('cascade');
            $table->decimal('agreed_fee', 12, 2);
            $table->decimal('platform_fee', 12, 2)->default(0.00);
            $table->decimal('total_amount', 12, 2);
            $table->date('shoot_date')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('confirmed'); // pending_payment, confirmed, in_progress, deliverables_submitted, approved, completed, cancelled
            $table->timestamps();
        });

        // 18. Deliverable Submissions
        Schema::create('deliverable_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('deliverable_id')->nullable()->constrained('campaign_deliverables')->onDelete('set null');
            $table->string('submission_url')->nullable();
            $table->json('file_paths')->nullable();
            $table->text('caption')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('submitted'); // draft, submitted, changes_requested, approved
            $table->text('revision_feedback')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        // 19. Reviews & Reputation
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewee_id')->constrained('users')->onDelete('cascade');
            $table->integer('rating_overall')->default(5);
            $table->integer('professionalism_rating')->default(5);
            $table->integer('punctuality_rating')->default(5);
            $table->integer('communication_rating')->default(5);
            $table->integer('quality_rating')->default(5);
            $table->text('review_text')->nullable();
            $table->timestamps();
        });

        // 20. Disputes
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('opened_by_user_id')->constrained('users')->onDelete('cascade');
            $table->string('reason');
            $table->text('description');
            $table->json('evidence_files')->nullable();
            $table->string('resolution_decision')->nullable();
            $table->string('status')->default('open'); // open, under_review, resolved, rejected
            $table->timestamps();
        });

        // 21. Verification Records
        Schema::create('verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('verification_level')->default(1);
            $table->string('document_type')->nullable(); // id_proof, pan_card, passport, portfolio_proof
            $table->string('document_path')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('admin_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifications');
        Schema::dropIfExists('disputes');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('deliverable_submissions');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('campaign_applications');
        Schema::dropIfExists('campaign_questions');
        Schema::dropIfExists('campaign_usage_rights');
        Schema::dropIfExists('campaign_deliverables');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('talent_availabilities');
        Schema::dropIfExists('talent_rates');
        Schema::dropIfExists('social_accounts');
        Schema::dropIfExists('talent_portfolios');
        Schema::dropIfExists('talent_profiles');
        Schema::dropIfExists('brand_profiles');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('industries');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'status', 'avatar']);
        });
    }
};
