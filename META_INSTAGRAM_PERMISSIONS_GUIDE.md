# Meta / Instagram Developer Permissions & Configuration Guide

This guide details which Meta / Instagram Graph API permissions are required for the **Talent / Influencer Marketplace** project, why each permission is used, and how to configure them in **Development Mode** and **Live Mode (App Review)**.

---

## 1. Summary of Required Permissions

| Permission Name | Category | Priority | What It Provides |
| :--- | :--- | :--- | :--- |
| **`instagram_business_manage_insights`** | Instagram API with Instagram Login | **Critical (Must Have)** | Fetches video view counts, reach, video plays, impressions, and engagement metrics for synced Reels and posts. |
| **`instagram_business_basic`** | Instagram API with Instagram Login | **Critical (Must Have)** | Fetches creator profile details (username, user ID, media count) and media feed (captions, thumbnails, permalinks, like counts, comment counts, timestamps). |
| **`instagram_business_manage_comments`** | Instagram API with Instagram Login | **Essential for Collabs** | Grants access to tagged media and co-authored collaboration Reels (`/me/tags`). |
| **`instagram_manage_insights`** | Instagram Graph API (Page-linked) | **Recommended** | Used when creators connect through a linked Facebook Page rather than standalone Instagram login. |
| **`instagram_basic`** | Instagram Graph API (Page-linked) | **Recommended** | Reads basic profile information via Facebook Page connection. |
| **`public_profile`** & **`email`** | Facebook / Meta Identity | **Optional** | Standard user authentication and email retrieval for SSO login. |

---

## 2. Permissions We Do NOT Need

You can safely ignore or leave inactive all of the following in your Meta App Dashboard:
- `ads_management`, `ads_read`, `attribution_read`
- `commerce_account_manage_orders`, `commerce_account_read_orders`, `commerce_account_read_reports`, `commerce_account_read_settings`
- `leads_retrieval`, `manage_fundraisers`, `pages_manage_ads`
- `live_shopping_manage_video`, `paid_marketing_messages`, `marketing_messages_messenger`
- `pages_manage_instant_articles`, `pages_utility_messaging`, `pages_user_gender`, `pages_user_timezone`, `pages_user_locale`

---

## 3. How to Enable & Test in Development Mode

Since your Meta App (**`td_influence`**) is currently in **`App Mode: Development`**, you can access full insights and metrics immediately for test creators without waiting for Meta App Review:

### Step 1: Add Creator Accounts as Instagram Testers
1. Go to **[Meta for Developers](https://developers.facebook.com/)** $\rightarrow$ Select **`td_influence`**.
2. In the left navigation, click **App Roles** $\rightarrow$ **Roles** (or **Instagram Testers** under Products $\rightarrow$ Instagram).
3. Under **Instagram Testers**, click **Add Instagram Testers**.
4. Enter the Instagram usernames (e.g. `wellparth`, `gargi_era`).

### Step 2: Accept the Invitation on Instagram
1. Log into the respective account on Instagram (via mobile app or web browser at `https://www.instagram.com/accounts/manage_access/`).
2. Go to **Settings & Privacy** $\rightarrow$ **Apps and Websites** $\rightarrow$ **Tester Invites**.
3. Click **Accept** on the pending invite from `td_influence`.

### Step 3: Connect Account in the Marketplace
1. In the influencer marketplace portal, go to **Talent Dashboard** $\rightarrow$ **Social Accounts**.
2. Click **Connect Instagram**.
3. Accept the authorization dialog (which requests `instagram_business_basic` and `instagram_business_manage_insights`).
4. The system will automatically fetch live reels, like counts, comment counts, and direct API view insights.

---

## 4. How to Go Live for Public Creators (App Review)

When you are ready to switch the app from **Development Mode** to **Live Mode** so that any external creator can connect without being added as a tester:

1. Go to **Meta App Dashboard** $\rightarrow$ **App Review** $\rightarrow$ **Permissions and Features**.
2. Locate:
   - `instagram_business_basic`
   - `instagram_business_manage_insights`
3. Click **Request Advanced Access**.
4. Meta will ask for:
   - A short screen recording (screencast) demonstrating how creators connect their account and see their verified Reel reach and analytics on the platform.
   - A brief explanation of why the permission is needed:
     > *"Our application is an influencer marketing marketplace where creators connect their professional Instagram accounts to showcase their verified Reel reach, video view metrics, and engagement statistics to brands."*
5. Submit the review. Approval usually takes 1–3 business days.

---

## 5. Codebase Configuration Reference

- **OAuth Authorization Controller**: `app/Http/Controllers/InstagramOAuthController.php`
  - Requests: `scope=instagram_business_basic,instagram_business_manage_insights`
- **Social Sync Service**: `app/Services/SocialSyncService.php`
  - Fetches `/me`, `/me/media`, and `/{media_id}/insights?metric=views,reach,total_interactions`
- **Reels Analytics Blade Component**: `resources/views/components/social-analytics-card.blade.php`
  - Renders 7d, 30d, 90d, all-time, and custom date range filters for verified Reels only.
