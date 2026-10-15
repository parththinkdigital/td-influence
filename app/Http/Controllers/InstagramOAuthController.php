<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\TalentProfile;
use App\Services\SocialSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramOAuthController extends Controller
{
    /**
     * Redirect the user to Instagram's OAuth authorization dialog.
     */
    public function redirect()
    {
        $appId = config('services.instagram.app_id') ?: config('services.meta.app_id');
        $redirectUri = rtrim(config('services.instagram.redirect_uri') ?: config('services.meta.instagram_redirect_uri', url('/auth/instagram/callback')), '/');
        $state = csrf_token();
        session(['instagram_oauth_state' => $state]);

        // Official Meta Instagram Business Login dialog endpoint
        $params = [
            'enable_fb_login' => '0',
            'force_authentication' => '1',
            'client_id' => $appId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'instagram_business_basic,instagram_business_manage_insights,instagram_business_manage_comments',
            'state' => $state,
        ];

        $url = 'https://www.instagram.com/oauth/authorize?'.http_build_query($params);

        return redirect()->away($url);
    }

    /**
     * Handle the OAuth callback from Instagram.
     */
    public function callback(Request $request, SocialSyncService $syncService)
    {
        if ($request->has('error')) {
            $errDesc = $request->input('error_description', $request->input('error_message', $request->input('error')));
            Log::warning('Instagram OAuth Denied/Error: '.$errDesc);

            return redirect()->route('influencer.social')->withErrors([
                'oauth' => 'Instagram authorization was cancelled or denied: '.$errDesc,
            ]);
        }

        $code = $request->input('code');
        if (! $code) {
            return redirect()->route('influencer.social')->withErrors([
                'oauth' => 'No authorization code received from Instagram.',
            ]);
        }

        // Meta Instagram OAuth may append '#_' to the code in URL redirect
        $code = preg_replace('/#_.*$/', '', $code);

        $appId = config('services.instagram.app_id') ?: config('services.meta.app_id');
        $appSecret = config('services.instagram.app_secret') ?: config('services.meta.app_secret');
        $redirectUri = rtrim(config('services.instagram.redirect_uri') ?: config('services.meta.instagram_redirect_uri', url('/auth/instagram/callback')), '/');

        try {
            // 1. Swap short-lived authorization code for Short-Lived Access Token
            $tokenResponse = Http::asForm()->timeout(15)->post('https://api.instagram.com/oauth/access_token', [
                'client_id' => $appId,
                'client_secret' => $appSecret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
                'code' => $code,
            ]);

            if (! $tokenResponse->successful() || empty($tokenResponse->json('access_token'))) {
                $errBody = $tokenResponse->json('error_message') ?? $tokenResponse->body();
                Log::error('Instagram Token Exchange Failed: '.$errBody);

                return redirect()->route('influencer.social')->withErrors([
                    'oauth' => 'Failed to obtain access token from Instagram: '.$errBody,
                ]);
            }

            $shortLivedToken = $tokenResponse->json('access_token');
            $igUserId = $tokenResponse->json('user_id');

            // 2. Exchange for 60-Day Long-Lived Token
            $longLivedToken = $shortLivedToken;
            $expiresAt = now()->addDays(60);

            $exchangeResp = Http::timeout(10)->get('https://graph.instagram.com/access_token', [
                'grant_type' => 'ig_exchange_token',
                'client_secret' => $appSecret,
                'access_token' => $shortLivedToken,
            ]);

            if ($exchangeResp->successful() && ! empty($exchangeResp->json('access_token'))) {
                $longLivedToken = $exchangeResp->json('access_token');
                $expiresInSeconds = (int) ($exchangeResp->json('expires_in') ?? 5184000);
                $expiresAt = now()->addSeconds($expiresInSeconds);
            }

            // 3. Fetch User Profile Info & Follower Count via graph.instagram.com
            // Attempt 1: Full professional fields (Creator / Business accounts)
            $profileResp = Http::timeout(10)->get('https://graph.instagram.com/me', [
                'fields' => 'id,username,name,account_type,profile_picture_url,followers_count,follows_count,media_count',
                'access_token' => $longLivedToken,
            ]);

            // Attempt 2: If full fields threw IGApiException (Code 100), fallback to standard basic fields
            if (! $profileResp->successful() || empty($profileResp->json('username'))) {
                $profileResp = Http::timeout(10)->get('https://graph.instagram.com/me', [
                    'fields' => 'id,username,account_type,media_count',
                    'access_token' => $longLivedToken,
                ]);
            }

            // Attempt 3: Direct User ID endpoint fallback
            if ((! $profileResp->successful() || empty($profileResp->json('username'))) && ! empty($igUserId)) {
                $profileResp = Http::timeout(10)->get("https://graph.instagram.com/{$igUserId}", [
                    'fields' => 'id,username,account_type,media_count',
                    'access_token' => $longLivedToken,
                ]);
            }

            if (! $profileResp->successful() || empty($profileResp->json('username'))) {
                Log::error('Instagram Profile Fetch Failed: '.$profileResp->body());
                $errMsg = $profileResp->json('error.message') ?? $profileResp->body();

                return redirect()->route('influencer.social')->withErrors([
                    'oauth' => 'Could not fetch Instagram profile info: '.$errMsg,
                ]);
            }

            $igData = $profileResp->json();
            $username = $igData['username'];
            $followers = (int) ($igData['followers_count'] ?? 0);
            $postsCount = (int) ($igData['media_count'] ?? 0);

            // Fetch live Reel / media stats for 30-day views
            $liveMetrics = $syncService->fetchMetrics('instagram', $username, null, true, $longLivedToken);

            $user = Auth::user();
            $talentProfile = TalentProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'display_name' => $user->name,
                    'username' => $username,
                    'is_profile_complete' => true,
                ]
            );

            $followersCount = $followers > 0 ? $followers : ($liveMetrics['followers'] ?? 0);
            $views30d = $liveMetrics['views_30d'] ?? $syncService->calculateInstagram30dViews($followersCount);
            $recentMedia = $liveMetrics['recent_media'] ?? [];
            $avgViews = $liveMetrics['avg_views'] ?? $syncService->calculateAvgViews('instagram', $followersCount, $views30d, $recentMedia);

            // 4. Save or Update Social Account
            SocialAccount::updateOrCreate(
                [
                    'talent_profile_id' => $talentProfile->id,
                    'platform' => 'instagram',
                ],
                [
                    'username' => $username,
                    'profile_url' => "https://instagram.com/{$username}",
                    'followers' => $followersCount,
                    'views_30d' => $views30d,
                    'avg_views' => $avgViews,
                    'avg_likes' => $liveMetrics['avg_likes'] ?? 0,
                    'avg_comments' => $liveMetrics['avg_comments'] ?? 0,
                    'engagement_rate' => $liveMetrics['engagement_rate'] ?? 0.0,
                    'posts_count' => $postsCount > 0 ? $postsCount : ($liveMetrics['posts_count'] ?? 0),
                    'recent_media' => $recentMedia,
                    'is_verified' => true,
                    'access_token' => $longLivedToken,
                    'token_expires_at' => $expiresAt,
                    'instagram_user_id' => (string) ($igData['id'] ?? $igUserId),
                    'last_synced_at' => now(),
                    'sync_source' => 'instagram_oauth',
                ]
            );

            return redirect()->route('influencer.social')->with(
                'success',
                "⚡ Instagram connected via OAuth! Verified @{$username} with ".number_format($followers > 0 ? $followers : ($liveMetrics['followers'] ?? 0)).' followers.'
            );

        } catch (\Throwable $e) {
            Log::error('Instagram OAuth Exception: '.$e->getMessage());

            return redirect()->route('influencer.social')->withErrors([
                'oauth' => 'An error occurred while connecting Instagram: '.$e->getMessage(),
            ]);
        }
    }
}
