# Talent Marketplace Platform — Comprehensive Project Plan

Based on the specification in `talent_marketplace_blueprint.pdf`, this plan outlines the architecture, database schema, dynamic forms, backend logic, and frontend UI for building the full two-sided Talent Marketplace Platform in Laravel (`new-laravel`).

---

## 1. Executive Summary & Core Marketplace Loop

The product is a two-sided talent marketplace connecting diverse talent (models, influencers, anchors, UGC creators, photographers, videographers, makeup artists, stylists) with brands and agencies.

### The Core Marketplace Loop
```
Brand Posts Requirement ──► Applications Received ──► Shortlisting & Chat ──► Price Proposal / Negotiation
                                                                                  │
Review & Reputation ◄── Complete & Approve ◄── Submit Deliverables ◄── Payment & Booking Confirmation ◄┘
```

---

## 2. Technical Stack & Architecture

- **Backend Framework**: Laravel 13.x (PHP 8.3+)
- **Database**: SQLite / MySQL (Eloquent ORM, Migrations, Seeders)
- **Frontend / Templating**: Blade components, Tailwind CSS v4, Alpine.js for interactive dynamic forms & realtime UI
- **Auth & Authorization**: Laravel Session Auth with multi-role middleware (`admin`, `brand`, `talent`)
- **Storage**: Laravel Disk (`public`/`private` storage for portfolio media, verification documents, and chat attachments)

---

## 3. Comprehensive Database Schema Plan

### Core User & Profile Tables
1. **`users`**
   - `id`, `name`, `email`, `password`, `role` (`talent`, `brand`, `admin`), `phone`, `avatar`, `status` (`active`, `suspended`), `email_verified_at`, `timestamps`
2. **`talent_profiles`**
   - `id`, `user_id` (foreign), `display_name`, `gender`, `dob`, `city`, `state`, `country`, `languages` (json)
   - **Model Fields**: `height_cm`, `weight_kg`, `chest_waist_hip`, `shoe_size`, `clothing_size`, `hair_color`, `eye_color`, `beard`, `tattoos_piercings`
   - **Influencer Fields**: `primary_platform`, `bio`
   - **Anchor/Creator Fields**: `years_experience`, `hosting_style`, `voice_style`, `has_stage_exp`, `has_tv_radio_exp`
   - `categories` (json array: modeling, influencer, anchor, ugc, photography, etc.)
   - `verification_level` (int 1-5, default 1)
   - `completion_rate`, `response_rate`, `rating_avg`, `timestamps`
3. **`talent_portfolios`**
   - `id`, `talent_profile_id`, `title`, `category`, `description`, `media_files` (json), `brand_worked_with`, `event_date`, `location`, `role_played`, `campaign_type`, `timestamps`
4. **`talent_social_accounts`**
   - `id`, `talent_profile_id`, `platform` (instagram, youtube, facebook, tiktok, etc.), `username`, `profile_url`, `followers_count`, `following_count`, `posts_count`, `avg_views`, `avg_likes`, `engagement_rate`, `audience_demographics` (json), `timestamps`
5. **`talent_rates`**
   - `id`, `talent_profile_id`, `service_type` (hourly, half_day, full_day, per_shoot, per_campaign, instagram_reel, youtube_video, ugc_video), `rate_amount`, `currency`, `is_negotiable` (boolean), `timestamps`
6. **`talent_availabilities`**
   - `id`, `talent_profile_id`, `date`, `status` (`available`, `tentative`, `booked`, `unavailable`), `notes`, `timestamps`
7. **`brand_profiles`**
   - `id`, `user_id`, `company_name`, `logo`, `website`, `industry`, `description`, `year_established`, `company_size`, `headquarters`, `cities_served`, `contact_person`, `contact_designation`, `contact_phone`, `gstin_pan`, `verification_status` (`unverified`, `pending`, `verified`), `verification_docs` (json), `timestamps`

### Marketplace & Job Posting Tables
8. **`jobs`** (Campaigns / Requirements)
   - `id`, `brand_profile_id`, `title`, `campaign_name`, `campaign_category`, `campaign_type` (photoshoot, video_shoot, influencer_campaign, instagram_campaign, product_promotion, event, corporate_event, wedding, fashion_show, ugc, tv_ott, music_video, print, voice_over, hosting), `industry`, `objective`, `description`
   - **Talent Requirements**: `talent_type`, `number_required`, `gender_req`, `age_min`, `age_max`, `height_min`, `height_max`, `experience_req`, `languages_req` (json), `look_requirements`
   - **Location & Schedule**: `work_mode` (`remote`, `on_site`, `hybrid`), `country`, `state`, `city`, `venue`, `address`, `travel_required` (bool), `travel_reimbursement` (bool), `accommodation_provided` (bool), `transport_provided` (bool), `application_deadline`, `shoot_date`, `start_time`, `end_time`, `duration_days`, `backup_date`, `call_time`
   - **Budget & Status**: `budget_type` (`fixed`, `hourly`, `negotiable`), `budget_min`, `budget_max`, `status` (`draft`, `pending_review`, `published`, `in_progress`, `completed`, `cancelled`), `timestamps`
9. **`job_deliverables`**
   - `id`, `job_id`, `deliverable_type` (reel, post, story, youtube_video, photo_pack, outfit_change, event_duration, ugc_qty), `quantity`, `description`, `timestamps`
10. **`job_usage_rights`**
    - `id`, `job_id`, `channels` (json: organic_social, paid_ads, website, ecommerce, print, billboard, tv, ott, youtube, meta_ads, google_ads), `duration_months`, `geography` (`local`, `state`, `india`, `international`), `exclusivity` (`none`, `category`, `full`), `timestamps`
11. **`job_questions`**
    - `id`, `job_id`, `question_text`, `is_required`, `timestamps`
12. **`applications`**
    - `id`, `job_id`, `talent_profile_id`, `proposed_price`, `cover_note`, `selected_portfolio_ids` (json), `answers` (json), `status` (`applied`, `viewed`, `shortlisted`, `discussion`, `selected`, `contract`, `payment_pending`, `confirmed`, `rejected`, `withdrawn`), `timestamps`

### Negotiation, Booking, Reputation & Moderation Tables
13. **`conversations`**
    - `id`, `job_id`, `application_id`, `brand_user_id`, `talent_user_id`, `timestamps`
14. **`messages`**
    - `id`, `conversation_id`, `sender_id`, `message_text`, `attachments` (json), `proposal_price`, `proposal_status` (`none`, `proposed`, `countered`, `accepted`, `rejected`), `timestamps`
15. **`bookings`**
    - `id`, `job_id`, `application_id`, `brand_profile_id`, `talent_profile_id`, `agreed_fee`, `platform_fee`, `total_amount`, `shoot_date`, `location`, `status` (`pending_payment`, `confirmed`, `in_progress`, `deliverables_submitted`, `approved`, `completed`, `cancelled`), `timestamps`
16. **`deliverable_submissions`**
    - `id`, `booking_id`, `job_deliverable_id`, `submission_url`, `file_paths` (json), `notes`, `status` (`submitted`, `changes_requested`, `approved`), `feedback_notes`, `timestamps`
17. **`reviews`**
    - `id`, `booking_id`, `reviewer_id`, `reviewee_id`, `rating_overall`, `professionalism_rating`, `punctuality_rating`, `communication_rating`, `quality_rating`, `review_text`, `timestamps`
18. **`disputes`**
    - `id`, `booking_id`, `opened_by_user_id`, `reason`, `description`, `evidence_files` (json), `resolution_decision`, `status` (`open`, `under_review`, `resolved`, `rejected`), `timestamps`
19. **`verifications`**
    - `id`, `user_id`, `verification_type` (id_card, pan, passport, portfolio_doc), `document_path`, `status` (`pending`, `approved`, `rejected`), `admin_notes`, `timestamps`

---

## 4. Dynamic Form Architecture

As specified in Section 20 of the blueprint, forms dynamically adapt to context:
- **Talent Profile Onboarding**:
  - Model selected: reveals height, clothing size, shoe size, chest/waist/hip, modeling categories, photo portfolio.
  - Influencer selected: reveals platform handle, followers, engagement rate, content niche, reel links.
  - Anchor selected: reveals hosting experience, event types, stage/TV history, voice/video samples.
- **Job / Campaign Creation**:
  - Influencer campaign: shows deliverable builder (reels, stories, posts), usage rights (duration, channels, exclusivity), target follower count.
  - Photoshoot campaign: shows model specifications (height range, outfit count, shoot duration, call time, location/venue details).

---

## 5. UI & View Structure

```
resources/views/
├── components/
│   ├── layout.blade.php
│   ├── navbar.blade.php
│   ├── footer.blade.php
│   ├── badge.blade.php
│   └── alert.blade.php
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
├── public/
│   ├── home.blade.php
│   ├── talent-directory.blade.php
│   ├── talent-show.blade.php
│   ├── jobs-directory.blade.php
│   └── job-show.blade.php
├── talent/
│   ├── dashboard.blade.php
│   ├── profile-edit.blade.php
│   ├── portfolio.blade.php
│   ├── rates-availability.blade.php
│   ├── applications.blade.php
│   ├── bookings.blade.php
│   └── chat.blade.php
├── brand/
│   ├── dashboard.blade.php
│   ├── profile-edit.blade.php
│   ├── jobs-create.blade.php
│   ├── jobs-manage.blade.php
│   ├── job-applications.blade.php
│   ├── bookings.blade.php
│   └── chat.blade.php
└── admin/
    ├── dashboard.blade.php
    ├── users.blade.php
    ├── verifications.blade.php
    ├── jobs.blade.php
    ├── bookings.blade.php
    └── disputes.blade.php
```

---

## 6. Phased Implementation Roadmap

1. **Phase 1: Foundation & Models**
   - Update database migrations for full Talent Marketplace schema.
   - Create Eloquent Models with relationships, cast types, and dynamic accessors.
   - Seed baseline data (industries, categories, demo users, profiles, jobs, portfolios).

2. **Phase 2: Authentication & Profile Onboarding**
   - Custom registration for Talent (with multi-type selection) and Brand.
   - Interactive profile management with dynamic fields via Alpine.js.
   - Portfolio uploading and rate card configuration.

3. **Phase 3: Job Posting & Search Directory**
   - Step-by-step wizard for Brand Job Posting with dynamic deliverables & usage rights.
   - Search & filtering engine for Talent (by type, height, location, followers, rate) and Jobs (by category, budget, location).

4. **Phase 4: Applications, Negotiation & Chat**
   - Job application flow with portfolio item selection & custom questions.
   - Real-time/interactive messaging interface between Brands and Talent with structured price counter-offers.

5. **Phase 5: Booking, Deliverables & Reputation**
   - Selection to Booking transition with total fee breakdown.
   - Deliverable submission & approval workflow.
   - Multi-criteria rating & review system.

6. **Phase 6: Admin Panel & Dispute Resolution**
   - Verification queue management (5-tier verification system).
   - Dispute management dashboard with evidence inspection and decision handling.
