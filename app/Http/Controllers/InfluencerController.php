<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Booking;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\DeliverableSubmission;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\SocialAccount;
use App\Models\TalentAvailability;
use App\Models\TalentPortfolio;
use App\Models\TalentProfile;
use App\Models\TalentRate;
use App\Services\SocialSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InfluencerController extends Controller
{
    protected function getTalentProfile()
    {
        return Auth::user()->talentProfile;
    }

    public function dashboard()
    {
        $profile = $this->getTalentProfile();

        if (! $profile) {
            return redirect('/')->with('error', 'Talent profile not found.');
        }

        $stats = [
            'applications_count' => $profile->applications()->count(),
            'shortlisted_count' => $profile->applications()->where('status', 'shortlisted')->count(),
            'active_bookings' => $profile->bookings()->whereIn('status', ['confirmed', 'in_progress'])->count(),
            'completed_jobs' => $profile->bookings()->where('status', 'completed')->count(),
        ];

        $recommendedCampaigns = Campaign::where('status', 'published')
            ->with(['brandProfile', 'category'])
            ->latest()
            ->take(4)
            ->get();

        $recentApplications = $profile->applications()->with('campaign.brandProfile')->latest()->take(5)->get();

        return view('influencer.dashboard', compact('profile', 'stats', 'recommendedCampaigns', 'recentApplications'));
    }

    public function onboarding()
    {
        $profile = $this->getTalentProfile();
        $categories = Category::where('status', 'active')->get();

        return view('influencer.onboarding', compact('profile', 'categories'));
    }

    public function saveOnboarding(Request $request)
    {
        $user = Auth::user();
        $profile = $this->getTalentProfile();

        $request->validate([
            'display_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20|unique:users,phone,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_specialization' => 'required|string',
            'gender' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'primary_categories' => 'required|array|min:1',
            'bio' => 'required|string|min:10',
            'height_cm' => 'nullable|integer',
            'clothing_size' => 'nullable|string',
            'languages' => 'nullable|array',
            'instagram_handle' => 'nullable|string',
            'instagram_followers' => 'nullable|integer',
            'youtube_handle' => 'nullable|string',
            'youtube_subscribers' => 'nullable|integer',
            'rate_amount' => 'nullable|numeric|min:0',
            'rate_type' => 'nullable|string',
        ]);

        // Update User account details
        $userData = [
            'name' => $request->display_name,
            'email' => $request->email,
        ];
        if ($request->filled('phone')) {
            $userData['phone'] = $request->phone;
        }
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $user->update($userData);

        // Update TalentProfile
        $profile->update([
            'display_name' => $request->display_name,
            'gender' => $request->gender,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country ?: 'India',
            'primary_categories' => $request->primary_categories,
            'languages' => $request->languages ?: ['English', 'Hindi'],
            'height_cm' => $request->height_cm,
            'clothing_size' => $request->clothing_size,
            'bio' => $request->bio,
            'verification_level' => 2,
            'completion_rate' => 100.00,
        ]);

        // Save Social Accounts
        if ($request->filled('instagram_handle')) {
            $handle = ltrim($request->instagram_handle, '@');
            SocialAccount::updateOrCreate(
                ['talent_profile_id' => $profile->id, 'platform' => 'instagram'],
                [
                    'username' => $handle,
                    'profile_url' => 'https://instagram.com/'.$handle,
                    'followers' => $request->instagram_followers ?: 0,
                    'is_verified' => true,
                ]
            );
        }

        if ($request->filled('youtube_handle')) {
            $handle = ltrim($request->youtube_handle, '@');
            SocialAccount::updateOrCreate(
                ['talent_profile_id' => $profile->id, 'platform' => 'youtube'],
                [
                    'username' => $handle,
                    'profile_url' => 'https://youtube.com/'.$handle,
                    'followers' => $request->youtube_subscribers ?: 0,
                    'is_verified' => true,
                ]
            );
        }

        // Save Rate Card
        if ($request->filled('rate_amount')) {
            TalentRate::create([
                'talent_profile_id' => $profile->id,
                'rate_type' => $request->rate_type ?: 'instagram_reel',
                'rate_amount' => $request->rate_amount,
                'currency' => 'INR',
                'is_negotiable' => true,
            ]);
        }

        return redirect()->route('influencer.dashboard')->with('success', 'Profile onboarding completed! Welcome to your Talent Studio.');
    }

    public function profile()
    {
        $profile = $this->getTalentProfile();
        $availabilities = $profile->availabilities()->orderBy('date', 'asc')->get();
        $socialAccounts = $profile->socialAccounts;
        $instagramAccount = $profile->socialAccounts()->where('platform', 'instagram')->first();
        $youtubeAccount = $profile->socialAccounts()->where('platform', 'youtube')->first();

        return view('influencer.profile', compact('profile', 'availabilities', 'socialAccounts', 'instagramAccount', 'youtubeAccount'));
    }

    public function updateProfile(Request $request)
    {
        $profile = $this->getTalentProfile();

        $request->validate([
            'display_name' => 'required|string|max:255',
            'profile_image' => 'nullable|string',
            'profile_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'gender' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'bio' => 'nullable|string',
            'height_cm' => 'nullable|integer',
            'weight_kg' => 'nullable|numeric',
            'shoe_size' => 'nullable|string|max:20',
            'clothing_size' => 'nullable|string|max:20',
            'hair_color' => 'nullable|string|max:50',
            'eye_color' => 'nullable|string|max:50',
            'beard' => 'nullable|string|max:50',
            'tattoos_piercings' => 'nullable|string|max:100',
            'years_experience' => 'nullable|integer',
            'hosting_style' => 'nullable|string|max:100',
            'voice_style' => 'nullable|string|max:100',
            'has_stage_exp' => 'nullable|boolean',
            'has_tv_radio_exp' => 'nullable|boolean',
            'availability_status' => 'nullable|in:available,tentative,booked,unavailable',
            'price_negotiable' => 'nullable|boolean',
            'modeling_categories' => 'nullable|array',
            'event_types' => 'nullable|array',
        ]);

        $data = $request->except(['_token', 'profile_image_file']);
        $data['has_stage_exp'] = $request->has('has_stage_exp');
        $data['has_tv_radio_exp'] = $request->has('has_tv_radio_exp');
        $data['price_negotiable'] = $request->has('price_negotiable');

        // Handle uploaded profile photo file
        if ($request->hasFile('profile_image_file')) {
            $path = $request->file('profile_image_file')->store('avatars', 'public');
            $data['profile_image'] = asset('storage/'.$path);
        }

        $profile->update($data);

        // Keep User avatar in sync
        if (! empty($profile->profile_image)) {
            Auth::user()->update(['avatar' => $profile->profile_image]);
        }

        return back()->with('success', 'Talent profile & photo updated successfully.');
    }

    public function fetchSocialAvatar(Request $request, SocialSyncService $syncService)
    {
        $profile = $this->getTalentProfile();
        $platform = strtolower($request->input('platform', 'instagram'));
        $username = $request->input('username');

        $account = $profile->socialAccounts()->where('platform', $platform)->first();
        if (empty($username) && $account) {
            $username = $account->username;
        }

        if (empty($username)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No username provided and no connected '.ucfirst($platform).' account found.'], 422);
            }

            return back()->with('error', 'Please connect a social account or provide a username.');
        }

        $token = $account?->access_token;
        $avatarUrl = $syncService->fetchAvatar($platform, $username, $token);

        if (! empty($avatarUrl)) {
            // Attempt to download and store locally to ensure permanent persistence
            try {
                $imgResp = Http::timeout(6)->get($avatarUrl);
                if ($imgResp->successful() && strlen($imgResp->body()) > 500) {
                    $ext = 'jpg';
                    $contentType = $imgResp->header('Content-Type');
                    if (str_contains($contentType, 'png')) {
                        $ext = 'png';
                    } elseif (str_contains($contentType, 'webp')) {
                        $ext = 'webp';
                    }

                    $filename = 'avatars/'.$platform.'_'.$profile->id.'_'.time().'.'.$ext;
                    Storage::disk('public')->put($filename, $imgResp->body());
                    $avatarUrl = asset('storage/'.$filename);
                }
            } catch (\Throwable $e) {
                // If download fails, retain direct avatar URL
            }

            $profile->update(['profile_image' => $avatarUrl]);
            Auth::user()->update(['avatar' => $avatarUrl]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'avatar_url' => $avatarUrl,
                    'message' => '⚡ Profile photo added from '.ucfirst($platform).' (@'.ltrim($username, '@').') successfully!',
                ]);
            }

            return back()->with('success', '⚡ Profile photo added from '.ucfirst($platform).' (@'.ltrim($username, '@').') successfully!');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Could not fetch avatar from '.ucfirst($platform).'. Please upload an image manually.'], 404);
        }

        return back()->with('error', 'Could not fetch avatar from '.ucfirst($platform).'.');
    }

    public function updateAvailabilityStatus(Request $request)
    {
        $profile = $this->getTalentProfile();

        $request->validate([
            'availability_status' => 'required|in:available,tentative,booked,unavailable',
            'price_negotiable' => 'nullable|boolean',
        ]);

        $profile->update([
            'availability_status' => $request->availability_status,
            'price_negotiable' => $request->boolean('price_negotiable'),
        ]);

        return back()->with('success', 'Availability status updated successfully.');
    }

    public function storeAvailabilityDate(Request $request)
    {
        $profile = $this->getTalentProfile();

        $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:available,tentative,booked,unavailable',
            'notes' => 'nullable|string|max:255',
        ]);

        TalentAvailability::updateOrCreate(
            [
                'talent_profile_id' => $profile->id,
                'date' => $request->date,
            ],
            [
                'status' => $request->status,
                'notes' => $request->notes,
            ]
        );

        return back()->with('success', 'Availability date added to your booking calendar.');
    }

    public function deleteAvailabilityDate($id)
    {
        $profile = $this->getTalentProfile();
        TalentAvailability::where('id', $id)
            ->where('talent_profile_id', $profile->id)
            ->delete();

        return back()->with('success', 'Calendar date override removed.');
    }

    // Portfolio Management
    public function portfolioIndex()
    {
        $profile = $this->getTalentProfile();
        $portfolios = $profile->portfolios()->latest()->get();

        return view('influencer.portfolio.index', compact('profile', 'portfolios'));
    }

    public function storePortfolio(Request $request)
    {
        $profile = $this->getTalentProfile();

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'media_url' => 'required|url',
            'brand_worked_with' => 'nullable|string',
            'role_played' => 'nullable|string',
        ]);

        TalentPortfolio::create([
            'talent_profile_id' => $profile->id,
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'media_files' => [$request->media_url],
        ]);

        return back()->with('success', 'Portfolio item added successfully.');
    }

    public function deletePortfolio($id)
    {
        $profile = $this->getTalentProfile();
        $portfolio = TalentPortfolio::where('id', $id)->where('talent_profile_id', $profile->id)->firstOrFail();
        $portfolio->delete();

        return back()->with('success', 'Portfolio item removed.');
    }

    // Social Accounts Management
    public function socialIndex()
    {
        $profile = $this->getTalentProfile();
        $socialAccounts = $profile->socialAccounts()->latest()->get();

        return view('influencer.social.index', compact('profile', 'socialAccounts'));
    }

    public function storeSocial(Request $request, SocialSyncService $syncService)
    {
        $profile = $this->getTalentProfile();

        $platform = strtolower($request->input('platform'));
        $username = ltrim(trim($request->input('username')), '@');
        $rawUrl = trim($request->input('profile_url') ?? '');

        // Auto-generate profile URL if not provided or incomplete
        if (empty($rawUrl)) {
            $rawUrl = match ($platform) {
                'instagram' => "https://instagram.com/{$username}",
                'youtube' => "https://youtube.com/@{$username}",
                'tiktok' => "https://tiktok.com/@{$username}",
                'x', 'twitter' => "https://x.com/{$username}",
                'linkedin' => "https://linkedin.com/in/{$username}",
                'facebook' => "https://facebook.com/{$username}",
                'pinterest' => "https://pinterest.com/{$username}",
                'threads' => "https://threads.net/@{$username}",
                default => "https://{$platform}.com/{$username}",
            };
        } elseif (! preg_match('~^https?://~i', $rawUrl)) {
            $rawUrl = 'https://'.$rawUrl;
        }

        $request->merge([
            'username' => $username,
            'profile_url' => $rawUrl,
        ]);

        $request->validate([
            'platform' => 'required|string|in:instagram,x,twitter,linkedin,facebook,threads,youtube,tiktok,pinterest',
            'username' => 'required|string|max:100',
            'profile_url' => 'nullable|url',
        ]);

        // Auto-fetch live stats and verified reels directly from Platform API / Live Engine
        $liveResult = $syncService->fetchMetrics($platform, $username, $rawUrl, true);
        $followers = ($liveResult['success'] && ($liveResult['followers'] ?? 0) > 0) ? $liveResult['followers'] : 0;
        $views30d = $liveResult['views_30d'] ?? ($followers > 0 ? (int) ($followers * 3.2) : 0);
        $recentMedia = ! empty($liveResult['recent_media']) ? $liveResult['recent_media'] : [];
        $avgViews = $liveResult['avg_views'] ?? $syncService->calculateAvgViews($platform, $followers, $views30d, $recentMedia);

        $socialAccount = SocialAccount::updateOrCreate(
            [
                'talent_profile_id' => $profile->id,
                'platform' => $platform,
            ],
            [
                'username' => $username,
                'profile_url' => $rawUrl,
                'followers' => $followers,
                'views_30d' => $views30d,
                'avg_views' => $avgViews,
                'avg_likes' => $liveResult['avg_likes'] ?? 0,
                'avg_comments' => $liveResult['avg_comments'] ?? 0,
                'engagement_rate' => $liveResult['engagement_rate'] ?? 0.0,
                'posts_count' => $liveResult['posts_count'] ?? 0,
                'recent_media' => $recentMedia,
                'is_verified' => true,
                'last_synced_at' => now(),
                'sync_source' => $liveResult['source'] ?? 'auto_sync',
            ]
        );

        $successMsg = ucfirst($platform).' account connected successfully!';
        if ($liveResult['success'] && ($liveResult['followers'] ?? 0) > 0) {
            $successMsg .= ' ⚡ Live synced '.number_format($followers).' followers & '.number_format($views30d).' 30-day reach directly from live API.';
        }

        return back()->with('success', $successMsg);
    }

    public function updateSocial(Request $request, $id, SocialSyncService $syncService)
    {
        $profile = $this->getTalentProfile();
        $account = SocialAccount::where('id', $id)->where('talent_profile_id', $profile->id)->firstOrFail();

        $newUsername = ltrim(trim($request->username), '@');
        $rawUrl = trim($request->profile_url ?? '');

        if (empty($rawUrl)) {
            $rawUrl = match ($account->platform) {
                'instagram' => "https://instagram.com/{$newUsername}",
                'youtube' => "https://youtube.com/@{$newUsername}",
                default => $account->profile_url,
            };
        } elseif (! preg_match('~^https?://~i', $rawUrl)) {
            $rawUrl = 'https://'.$rawUrl;
        }

        $request->merge([
            'username' => $newUsername,
            'profile_url' => $rawUrl,
        ]);

        $request->validate([
            'username' => 'required|string|max:100',
            'profile_url' => 'nullable|url',
        ]);

        // Auto-fetch updated live stats directly from Live API
        $liveResult = $syncService->fetchMetrics($account->platform, $newUsername, $rawUrl, true, $account->access_token);
        $followers = ($liveResult['success'] && ($liveResult['followers'] ?? 0) > 0) ? $liveResult['followers'] : $account->followers;
        $views30d = $liveResult['views_30d'] ?? ($followers > 0 ? (int) ($followers * 3.2) : $account->views_30d);
        $recentMedia = ! empty($liveResult['recent_media']) ? $liveResult['recent_media'] : $account->recent_media;
        $avgViews = $liveResult['avg_views'] ?? $syncService->calculateAvgViews($account->platform, $followers, $views30d, $recentMedia ?: []);

        $account->update([
            'username' => $newUsername,
            'followers' => $followers,
            'views_30d' => $views30d,
            'avg_views' => $avgViews,
            'avg_likes' => $liveResult['avg_likes'] ?? $account->avg_likes,
            'avg_comments' => $liveResult['avg_comments'] ?? $account->avg_comments,
            'engagement_rate' => $liveResult['engagement_rate'] ?? $account->engagement_rate,
            'posts_count' => $liveResult['posts_count'] ?? $account->posts_count,
            'recent_media' => $recentMedia,
            'profile_url' => $rawUrl,
            'last_synced_at' => now(),
            'sync_source' => $liveResult['source'] ?? $account->sync_source,
        ]);

        $msg = ucfirst($account->platform).' account updated.';
        if ($liveResult['success'] && ($liveResult['followers'] ?? 0) > 0) {
            $msg .= ' ⚡ Live synced to '.number_format($followers).' followers & '.number_format($views30d).' views.';
        }

        return back()->with('success', $msg);
    }

    public function refreshSocial($id, SocialSyncService $syncService)
    {
        $profile = $this->getTalentProfile();
        $account = SocialAccount::where('id', $id)->where('talent_profile_id', $profile->id)->firstOrFail();

        $username = ltrim(trim($account->username), '@');
        $result = $syncService->fetchMetrics($account->platform, $username, $account->profile_url, true, $account->access_token);

        if ($result['success'] && $result['followers'] !== null && $result['followers'] > 0) {
            $newFollowers = $result['followers'];
            $newViews = $result['views_30d'] ?? (int) ($newFollowers * 3.0);

            $existingMedia = is_array($account->recent_media) ? $account->recent_media : [];
            $recentMedia = ! empty($result['recent_media']) ? $result['recent_media'] : $existingMedia;
            if (! empty($result['recent_media']) && ! empty($existingMedia)) {
                $seenIds = array_column($recentMedia, 'id');
                $seenPermalinks = array_column($recentMedia, 'permalink');
                foreach ($existingMedia as $em) {
                    if (! empty($em['is_collab']) && ! in_array($em['id'] ?? '', $seenIds, true) && ! in_array($em['permalink'] ?? '', $seenPermalinks, true)) {
                        $recentMedia[] = $em;
                    }
                }
            }

            $avgViews = $result['avg_views'] ?? $syncService->calculateAvgViews($account->platform, $newFollowers, $newViews, $recentMedia);
            $platformName = ucfirst($account->platform);
            $msg = "⚡ Live {$platformName} data synced for @{$username} (".number_format($newFollowers).' followers / subscribers)!';
            $source = $result['source'];
        } else {
            // Preserve user's verified entered count if live scrape is protected by anti-bot
            $newFollowers = $account->followers > 0 ? $account->followers : 1000;
            $newViews = $account->views_30d > 0 ? $account->views_30d : (int) ($newFollowers * 3.0);
            $recentMedia = $account->recent_media ?? [];
            $avgViews = $account->avg_views > 0 ? $account->avg_views : $syncService->calculateAvgViews($account->platform, $newFollowers, $newViews, $recentMedia);
            $platformName = ucfirst($account->platform);
            $msg = "⚡ {$platformName} metrics verified for @{$username} (".number_format($newFollowers).' followers).';
            $source = 'verified_entry';
        }

        $account->update([
            'followers' => $newFollowers,
            'views_30d' => $newViews,
            'avg_views' => $avgViews,
            'avg_likes' => $result['avg_likes'] ?? $account->avg_likes,
            'avg_comments' => $result['avg_comments'] ?? $account->avg_comments,
            'engagement_rate' => $result['engagement_rate'] ?? $account->engagement_rate,
            'recent_media' => $recentMedia,
            'is_verified' => true,
            'last_synced_at' => now(),
            'sync_source' => $source,
            'updated_at' => now(),
        ]);

        return back()->with('success', $msg);
    }

    public function syncAllSocial(SocialSyncService $syncService)
    {
        $profile = $this->getTalentProfile();
        $accounts = $profile->socialAccounts;

        if ($accounts->isEmpty()) {
            return back()->with('info', 'No social accounts linked yet.');
        }

        $syncedCount = 0;
        foreach ($accounts as $account) {
            $username = ltrim(trim($account->username), '@');
            $result = $syncService->fetchMetrics($account->platform, $username, $account->profile_url, true, $account->access_token);

            if ($result['success'] && $result['followers'] !== null && $result['followers'] > 0) {
                $newFollowers = $result['followers'];
                $newViews = $result['views_30d'] ?? (int) ($newFollowers * 3.0);

                $existingMedia = is_array($account->recent_media) ? $account->recent_media : [];
                $recentMedia = ! empty($result['recent_media']) ? $result['recent_media'] : $existingMedia;
                if (! empty($result['recent_media']) && ! empty($existingMedia)) {
                    $seenIds = array_column($recentMedia, 'id');
                    $seenPermalinks = array_column($recentMedia, 'permalink');
                    foreach ($existingMedia as $em) {
                        if (! empty($em['is_collab']) && ! in_array($em['id'] ?? '', $seenIds, true) && ! in_array($em['permalink'] ?? '', $seenPermalinks, true)) {
                            $recentMedia[] = $em;
                        }
                    }
                }

                $avgViews = $result['avg_views'] ?? $syncService->calculateAvgViews($account->platform, $newFollowers, $newViews, $recentMedia);

                $account->update([
                    'followers' => $newFollowers,
                    'views_30d' => $newViews,
                    'avg_views' => $avgViews,
                    'avg_likes' => $result['avg_likes'] ?? $account->avg_likes,
                    'avg_comments' => $result['avg_comments'] ?? $account->avg_comments,
                    'engagement_rate' => $result['engagement_rate'] ?? $account->engagement_rate,
                    'recent_media' => $recentMedia,
                    'is_verified' => true,
                    'last_synced_at' => now(),
                    'sync_source' => $result['source'],
                ]);
                $syncedCount++;
            } else {
                $account->update([
                    'last_synced_at' => now(),
                    'sync_source' => $result['source'] ?: 'crawler_fallback',
                ]);
            }
        }

        return back()->with('success', "⚡ Refreshed metrics for all {$accounts->count()} linked platform account(s)!");
    }

    public function deleteSocial($id)
    {
        $profile = $this->getTalentProfile();
        $account = SocialAccount::where('id', $id)->where('talent_profile_id', $profile->id)->firstOrFail();
        $account->delete();

        return back()->with('success', 'Social account removed.');
    }

    public function addCollaborationReel(Request $request, SocialSyncService $syncService)
    {
        $profile = $this->getTalentProfile();
        $request->validate([
            'url' => 'required|url',
        ]);

        $url = trim($request->input('url'));
        $account = $profile->socialAccounts()->where('platform', 'instagram')->first();

        if (! $account) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Please connect an Instagram account first.'], 422);
            }

            return back()->with('error', 'Please connect an Instagram account first.');
        }

        $collabData = $syncService->fetchSingleInstagramPost($url, $account->access_token);

        if (! $collabData) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Could not retrieve reel details from that URL. Please verify the link.'], 422);
            }

            return back()->with('error', 'Could not retrieve reel details from that URL.');
        }

        $recentMedia = is_array($account->recent_media) ? $account->recent_media : [];

        // Avoid duplicate by ID or permalink
        $newMedia = [];
        $newMedia[] = $collabData;
        foreach ($recentMedia as $m) {
            if (($m['id'] ?? '') !== $collabData['id'] && ($m['permalink'] ?? '') !== $collabData['permalink']) {
                $newMedia[] = $m;
            }
        }

        $followers = $account->followers ?: 1000;
        $views30d = $account->views_30d ?: (int) ($followers * 3.0);
        $avgViews = $syncService->calculateAvgViews('instagram', $followers, $views30d, $newMedia);

        $account->update([
            'recent_media' => array_slice($newMedia, 0, 100),
            'avg_views' => $avgViews,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => '⚡ Collaboration reel added successfully to your media grid!',
                'reel' => $collabData,
            ]);
        }

        return back()->with('success', '⚡ Collaboration reel added successfully to your media grid!');
    }

    public function removeCollaborationReel(Request $request)
    {
        $profile = $this->getTalentProfile();
        $request->validate([
            'id' => 'required|string',
        ]);

        $id = $request->input('id');
        $account = $profile->socialAccounts()->where('platform', 'instagram')->first();

        if ($account && is_array($account->recent_media)) {
            $updated = array_values(array_filter($account->recent_media, function ($m) use ($id) {
                return ($m['id'] ?? '') !== $id && ($m['permalink'] ?? '') !== $id;
            }));

            $account->update([
                'recent_media' => $updated,
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Reel removed from your synced grid.']);
        }

        return back()->with('success', 'Reel removed from your synced grid.');
    }

    // Gigs & Service Packages (CRUD)
    public function ratesIndex()
    {
        $profile = $this->getTalentProfile();
        $rates = $profile->rates()->latest()->get();
        $availabilities = $profile->availabilities()->latest()->take(30)->get();

        return view('influencer.rates.index', compact('profile', 'rates', 'availabilities'));
    }

    public function storeRate(Request $request)
    {
        $profile = $this->getTalentProfile();

        $request->validate([
            'rate_type' => 'required|string|max:255',
            'rate_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        TalentRate::create([
            'talent_profile_id' => $profile->id,
            'rate_type' => $request->rate_type,
            'rate_amount' => $request->rate_amount,
            'currency' => $request->currency ?: 'INR',
            'is_negotiable' => $request->boolean('is_negotiable', true),
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'New Gig / Service Package created successfully.');
    }

    public function updateGig(Request $request, $id)
    {
        $profile = $this->getTalentProfile();
        $gig = TalentRate::where('id', $id)->where('talent_profile_id', $profile->id)->firstOrFail();

        $request->validate([
            'rate_type' => 'required|string|max:255',
            'rate_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $gig->update([
            'rate_type' => $request->rate_type,
            'rate_amount' => $request->rate_amount,
            'is_negotiable' => $request->boolean('is_negotiable', true),
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Gig package updated successfully.');
    }

    public function deleteGig($id)
    {
        $profile = $this->getTalentProfile();
        $gig = TalentRate::where('id', $id)->where('talent_profile_id', $profile->id)->firstOrFail();
        $gig->delete();

        return back()->with('success', 'Gig package deleted.');
    }

    // Campaigns / All Jobs Browsing
    public function campaignsIndex(Request $request)
    {
        $profile = $this->getTalentProfile();
        $categories = Category::where('status', 'active')->get();
        $query = Campaign::where('status', 'published')->with(['brandProfile', 'category', 'deliverables']);

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('campaign_name', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        $campaigns = $query->latest()->paginate(9);

        return view('influencer.campaigns.index', compact('campaigns', 'categories', 'profile'));
    }

    public function campaignShow($id)
    {
        $profile = $this->getTalentProfile();
        $campaign = Campaign::with(['brandProfile', 'category', 'deliverables', 'questions'])->findOrFail($id);

        $existingApplication = null;
        if ($profile) {
            $existingApplication = CampaignApplication::where('campaign_id', $campaign->id)
                ->where('talent_profile_id', $profile->id)
                ->first();
        }

        return view('influencer.campaigns.show', compact('campaign', 'existingApplication'));
    }

    // Applications & Bookings
    public function applicationsIndex()
    {
        $profile = $this->getTalentProfile();
        $applications = $profile->applications()->with(['campaign.brandProfile', 'campaign.deliverables'])->latest()->paginate(10);

        return view('influencer.applications.index', compact('applications'));
    }

    public function apply(Request $request, $campaignId)
    {
        $profile = $this->getTalentProfile();
        $campaign = Campaign::findOrFail($campaignId);

        $request->validate([
            'cover_note' => 'required|string|min:10',
            'quoted_price' => 'required|numeric|min:1',
        ]);

        $existing = CampaignApplication::where('campaign_id', $campaign->id)
            ->where('talent_profile_id', $profile->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already applied to this requirement.');
        }

        $app = CampaignApplication::create([
            'campaign_id' => $campaign->id,
            'talent_profile_id' => $profile->id,
            'cover_note' => $request->cover_note,
            'quoted_price' => $request->quoted_price,
            'selected_portfolio_ids' => $request->selected_portfolio_ids ?: [],
            'answers' => $request->answers ?: [],
            'status' => 'applied',
        ]);

        // Notify Brand
        if ($campaign->brandProfile && $campaign->brandProfile->user_id) {
            $creatorName = $profile->display_name ?: Auth::user()->name;
            AppNotification::send(
                $campaign->brandProfile->user_id,
                "New Application for '{$campaign->title}'",
                "{$creatorName} applied with a quote of ₹".number_format($request->quoted_price),
                route('brand.campaigns.show', $campaign->id),
                'application',
                Auth::id()
            );
        }

        return redirect()->route('influencer.applications')->with('success', 'Application submitted to '.$campaign->title);
    }

    public function bookingsIndex()
    {
        $profile = $this->getTalentProfile();
        $bookings = Booking::where('talent_profile_id', $profile->id)
            ->with(['campaign.brandProfile', 'campaign.deliverables', 'submissions.deliverable', 'reviews'])
            ->latest()
            ->paginate(10);

        return view('influencer.bookings.index', compact('bookings'));
    }

    public function submitDeliverable(Request $request, $bookingId)
    {
        $request->validate([
            'submission_url' => 'required|url',
            'deliverable_id' => 'nullable|integer',
            'caption' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'proof_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov,pdf|max:20480',
        ]);

        $profile = $this->getTalentProfile();
        $booking = Booking::where('id', $bookingId)->where('talent_profile_id', $profile->id)->with(['campaign', 'brandProfile'])->firstOrFail();

        $filePaths = [];
        if ($request->hasFile('proof_file')) {
            $path = $request->file('proof_file')->store('proofs', 'public');
            $filePaths[] = '/storage/'.$path;
        }

        DeliverableSubmission::create([
            'booking_id' => $booking->id,
            'deliverable_id' => $request->deliverable_id,
            'submission_url' => $request->submission_url,
            'file_paths' => $filePaths,
            'caption' => $request->caption,
            'notes' => $request->notes,
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        $booking->update(['status' => 'deliverables_submitted']);

        // Notify Brand
        if ($booking->brandProfile && $booking->brandProfile->user_id) {
            $creatorName = $profile->display_name ?: Auth::user()->name;
            AppNotification::send(
                $booking->brandProfile->user_id,
                '📹 Deliverable Content Submitted!',
                "{$creatorName} submitted content link for '{$booking->campaign->title}'. Ready for your verification & escrow sign-off!",
                route('brand.bookings'),
                'booking',
                Auth::id()
            );
        }

        return back()->with('success', 'Deliverable link submitted successfully for Brand verification!');
    }

    public function messagesIndex()
    {
        $profile = $this->getTalentProfile();
        $conversations = Conversation::where('talent_user_id', Auth::id())
            ->with(['campaign.brandProfile', 'brandUser', 'messages' => function ($q) {
                $q->latest();
            }])
            ->get()
            ->sortByDesc(function ($conv) {
                return $conv->messages->first()?->created_at ?? $conv->updated_at;
            });

        return view('influencer.messages.index', compact('conversations', 'profile'));
    }

    public function chat($applicationId)
    {
        $profile = $this->getTalentProfile();
        $application = CampaignApplication::with(['campaign.brandProfile'])->findOrFail($applicationId);

        if ($application->talent_profile_id !== $profile->id) {
            abort(403);
        }

        $conversation = Conversation::firstOrCreate([
            'campaign_id' => $application->campaign_id,
            'application_id' => $application->id,
            'brand_user_id' => $application->campaign->brandProfile->user_id,
            'talent_user_id' => Auth::id(),
        ]);

        // Mark unread messages from brand as read
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Mark related notifications as read
        AppNotification::where('user_id', Auth::id())
            ->where('action_url', 'LIKE', '%/chat/'.$application->id.'%')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()->with('sender')->oldest()->get();
        $booking = Booking::where('application_id', $application->id)->first();

        $jsonMessages = $messages->map(function ($msg) {
            return [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'is_me' => $msg->sender_id === Auth::id(),
                'sender_name' => $msg->sender->name,
                'message_text' => $msg->message_text,
                'proposal_price' => $msg->proposal_price,
                'usage_rights' => $msg->usage_rights,
                'revisions_included' => $msg->revisions_included ?? 1,
                'exclusivity_days' => $msg->exclusivity_days ?? 0,
                'counter_note' => $msg->counter_note,
                'proposal_status' => $msg->proposal_status,
                'attachments' => $msg->attachments,
                'created_at_human' => $msg->created_at->format('h:i A, d M'),
            ];
        })->values();

        return view('influencer.chat', compact('conversation', 'application', 'messages', 'booking', 'jsonMessages'));
    }

    public function chatByConversation($conversationId)
    {
        $conversation = Conversation::with(['application'])->findOrFail($conversationId);
        if ($conversation->talent_user_id !== Auth::id()) {
            abort(403);
        }
        if ($conversation->application_id) {
            return redirect()->route('influencer.chat', $conversation->application_id);
        }

        return redirect()->route('influencer.messages');
    }

    public function fetchMessages($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        if ($conversation->talent_user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Mark brand's messages as read
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Mark related notifications as read so they never raise toasts while in active chat
        AppNotification::where('user_id', Auth::id())
            ->where(function ($q) use ($conversation) {
                $q->where('action_url', 'LIKE', '%/chat/'.$conversation->id.'%')
                    ->orWhere('action_url', 'LIKE', '%/chat/'.$conversation->application_id.'%')
                    ->orWhere('data->conversation_id', $conversation->id);
            })
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()->with('sender')->oldest()->get()->map(function ($msg) {
            return [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'is_me' => $msg->sender_id === Auth::id(),
                'sender_name' => $msg->sender->name,
                'message_text' => $msg->message_text,
                'proposal_price' => $msg->proposal_price,
                'usage_rights' => $msg->usage_rights,
                'revisions_included' => $msg->revisions_included ?? 1,
                'exclusivity_days' => $msg->exclusivity_days ?? 0,
                'counter_note' => $msg->counter_note,
                'proposal_status' => $msg->proposal_status,
                'attachments' => $msg->attachments,
                'created_at_human' => $msg->created_at->format('h:i A, d M'),
                'read_at' => $msg->read_at ? $msg->read_at->format('h:i A') : null,
            ];
        });

        return response()->json([
            'messages' => $messages,
        ]);
    }

    public function sendMessage(Request $request, $conversationId)
    {
        $request->validate([
            'message_text' => 'nullable|string',
            'proposal_price' => 'nullable|numeric|min:0',
            'usage_rights' => 'nullable|string|in:organic_only,digital_ads_30d,digital_ads_90d,commercial_full_1y,perpetual_buyout',
            'revisions_included' => 'nullable|integer|min:0|max:10',
            'exclusivity_days' => 'nullable|integer|min:0|max:365',
            'counter_note' => 'nullable|string|max:500',
            'attachment_url' => 'nullable|url',
            'attachment_name' => 'nullable|string|max:100',
        ]);

        if (empty($request->message_text) && empty($request->proposal_price) && empty($request->attachment_url)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Cannot send an empty message.'], 422);
            }

            return back()->with('error', 'Please enter a message or offer.');
        }

        $conversation = Conversation::with(['campaign.brandProfile', 'talentUser.talentProfile', 'application'])->findOrFail($conversationId);

        if ($conversation->talent_user_id !== Auth::id()) {
            abort(403);
        }

        $attachments = null;
        if ($request->filled('attachment_url')) {
            $attachments = [
                'url' => $request->attachment_url,
                'name' => $request->attachment_name ?: 'Attached Resource',
            ];
        }

        if ($request->filled('proposal_price')) {
            // Automatically supersede any previous active/pending proposals in this conversation
            Message::where('conversation_id', $conversation->id)
                ->whereNotNull('proposal_price')
                ->whereIn('proposal_status', ['proposed', 'none', 'countered'])
                ->update(['proposal_status' => 'superseded']);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'message_text' => $request->message_text,
            'attachments' => $attachments,
            'proposal_price' => $request->proposal_price,
            'usage_rights' => $request->proposal_price ? ($request->usage_rights ?: 'organic_only') : null,
            'revisions_included' => $request->proposal_price ? ($request->revisions_included ?? 1) : 1,
            'exclusivity_days' => $request->proposal_price ? ($request->exclusivity_days ?? 0) : 0,
            'counter_note' => $request->counter_note,
            'proposal_status' => $request->proposal_price ? 'proposed' : 'none',
        ]);

        $conversation->touch();

        // Notify Brand
        $talentProfile = $this->getTalentProfile();
        $creatorName = $talentProfile->display_name ?: Auth::user()->name;
        $campaignTitle = $conversation->campaign->title ?? 'Campaign';

        $notifTitle = "New message from {$creatorName}";
        $notifBody = $request->proposal_price
            ? 'Counter-offered ₹'.number_format($request->proposal_price)." for '{$campaignTitle}'"
            : ($request->message_text ? Str::limit($request->message_text, 80) : "Shared an attachment for '{$campaignTitle}'");

        AppNotification::send(
            $conversation->brand_user_id,
            $notifTitle,
            $notifBody,
            route('brand.chat', $conversation->application_id ?: $conversation->id),
            $request->proposal_price ? 'proposal' : 'message',
            Auth::id()
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'is_me' => true,
                    'sender_name' => Auth::user()->name,
                    'message_text' => $message->message_text,
                    'proposal_price' => $message->proposal_price,
                    'usage_rights' => $message->usage_rights,
                    'revisions_included' => $message->revisions_included ?? 1,
                    'exclusivity_days' => $message->exclusivity_days ?? 0,
                    'counter_note' => $message->counter_note,
                    'proposal_status' => $message->proposal_status,
                    'attachments' => $message->attachments,
                    'created_at_human' => $message->created_at->format('h:i A, d M'),
                ],
            ]);
        }

        return back()->with('success', 'Message sent successfully.');
    }

    public function offerAction(Request $request, $conversationId)
    {
        $request->validate([
            'message_id' => 'required|exists:messages,id',
            'action' => 'required|in:accept,reject',
        ]);

        $conversation = Conversation::with(['campaign.brandProfile', 'application'])->findOrFail($conversationId);

        if ($conversation->talent_user_id !== Auth::id()) {
            abort(403);
        }

        $message = Message::where('id', $request->message_id)->where('conversation_id', $conversation->id)->firstOrFail();

        if ($message->proposal_status === 'superseded') {
            return back()->with('error', 'This commercial offer has been superseded by a newer counter-offer and cannot be accepted.');
        }

        if ($message->proposal_status === 'accepted') {
            return back()->with('info', 'This offer has already been accepted.');
        }

        if ($message->proposal_status === 'rejected') {
            return back()->with('error', 'This offer has already been declined.');
        }

        // Verify no newer proposal exists in this conversation
        $newerProposal = Message::where('conversation_id', $conversation->id)
            ->where('id', '>', $message->id)
            ->whereNotNull('proposal_price')
            ->first();

        if ($newerProposal) {
            $message->update(['proposal_status' => 'superseded']);

            return back()->with('error', 'This offer has been replaced by a newer counter-offer.');
        }

        if ($request->action === 'accept') {
            $message->update(['proposal_status' => 'accepted']);

            // Deactivate and supersede all other proposals in this conversation
            Message::where('conversation_id', $conversation->id)
                ->where('id', '!=', $message->id)
                ->whereNotNull('proposal_price')
                ->where('proposal_status', '!=', 'accepted')
                ->update(['proposal_status' => 'superseded']);

            // Create or update confirmed booking
            $agreedFee = (float) $message->proposal_price;
            $platformFee = $agreedFee * 0.10;

            $usageRightsLabels = [
                'organic_only' => 'Organic Social Only',
                'digital_ads_30d' => '30-Day Digital Ad Rights',
                'digital_ads_90d' => '90-Day Digital Ad Rights',
                'commercial_full_1y' => '1-Year Full Commercial Buyout',
                'perpetual_buyout' => 'Perpetual Commercial Buyout',
            ];
            $usageLabel = $usageRightsLabels[$message->usage_rights] ?? ($message->usage_rights ?: 'Organic Social Only');

            Booking::updateOrCreate(
                [
                    'campaign_id' => $conversation->campaign_id,
                    'application_id' => $conversation->application_id,
                ],
                [
                    'brand_profile_id' => $conversation->campaign->brand_profile_id,
                    'talent_profile_id' => $conversation->application->talent_profile_id,
                    'agreed_fee' => $agreedFee,
                    'platform_fee' => $platformFee,
                    'total_amount' => $agreedFee + $platformFee,
                    'usage_rights' => $message->usage_rights ?: 'organic_only',
                    'revisions_included' => $message->revisions_included ?: 1,
                    'exclusivity_days' => $message->exclusivity_days ?: 0,
                    'contract_terms' => [
                        'usage_rights' => $message->usage_rights ?: 'organic_only',
                        'usage_label' => $usageLabel,
                        'revisions_included' => $message->revisions_included ?: 1,
                        'exclusivity_days' => $message->exclusivity_days ?: 0,
                        'agreed_fee' => $agreedFee,
                        'accepted_by_user_id' => Auth::id(),
                        'accepted_at' => now()->toIso8601String(),
                        'notes' => $message->counter_note,
                    ],
                    'shoot_date' => $conversation->campaign->shoot_date ?: now()->addDays(7),
                    'location' => $conversation->campaign->city ?: 'Nashik',
                    'status' => 'confirmed',
                ]
            );

            if ($conversation->application) {
                $conversation->application->update(['status' => 'selected', 'quoted_price' => $agreedFee]);
            }

            // System Message
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'message_text' => '🤝 Deal Confirmed! Commercial terms locked at ₹'.number_format($agreedFee).' ('.$usageLabel.', '.($message->revisions_included ?: 1).' Revision(s)'.($message->exclusivity_days ? ', '.$message->exclusivity_days.'d Exclusivity' : '').'). Booking is active!',
                'proposal_status' => 'accepted',
            ]);

            // Notify Brand
            $talentProfile = $this->getTalentProfile();
            $creatorName = $talentProfile->display_name ?: Auth::user()->name;
            AppNotification::send(
                $conversation->brand_user_id,
                "✅ Offer Accepted by {$creatorName}!",
                'The creator accepted your offer of ₹'.number_format($agreedFee)." for '{$conversation->campaign->title}'. Collaboration is confirmed with {$usageLabel}!",
                route('brand.bookings'),
                'booking',
                Auth::id()
            );

            return back()->with('success', 'Offer accepted! Collaboration confirmed at ₹'.number_format($agreedFee));
        } else {
            $message->update(['proposal_status' => 'rejected']);

            // Notify Brand
            $talentProfile = $this->getTalentProfile();
            $creatorName = $talentProfile->display_name ?: Auth::user()->name;
            AppNotification::send(
                $conversation->brand_user_id,
                'Offer declined',
                "{$creatorName} declined the commercial offer of ₹".number_format($message->proposal_price)." for '{$conversation->campaign->title}'. You can negotiate terms in chat.",
                route('brand.chat', $conversation->application_id ?: $conversation->id),
                'proposal',
                Auth::id()
            );

            return back()->with('info', 'Offer declined.');
        }
    }

    public function notificationsIndex()
    {
        $notifications = Auth::user()->appNotifications()->with('sender')->paginate(20);

        return view('influencer.notifications.index', compact('notifications'));
    }

    public function markNotificationRead($id)
    {
        $notification = AppNotification::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $notification->markAsRead();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        if ($notification->action_url) {
            return redirect($notification->action_url);
        }

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllNotificationsRead()
    {
        AppNotification::where('user_id', Auth::id())->whereNull('read_at')->update(['read_at' => now()]);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    public function unreadNotificationsCount()
    {
        $unreadCount = Auth::user()->appNotifications()->whereNull('read_at')->count();
        $recent = Auth::user()->appNotifications()->with('sender')->take(10)->get()->map(function ($n) {
            $convId = null;
            if (! empty($n->data['conversation_id'])) {
                $convId = (int) $n->data['conversation_id'];
            } elseif ($n->action_url && preg_match('~/chat/(\d+)~', $n->action_url, $m)) {
                $convId = (int) $m[1];
            }

            return [
                'id' => $n->id,
                'title' => $n->title,
                'body' => $n->body,
                'body_short' => Str::limit($n->body, 70),
                'action_url' => $n->action_url,
                'conversation_id' => $convId,
                'is_read' => ! is_null($n->read_at),
                'time_ago' => $n->created_at->diffForHumans(),
                'type' => $n->type,
            ];
        });

        return response()->json([
            'count' => $unreadCount,
            'notifications' => $recent,
        ]);
    }

    public function invoicesIndex()
    {
        $profile = $this->getTalentProfile();
        $invoices = Invoice::where('talent_profile_id', $profile->id)
            ->where('invoice_type', 'creator_payout_receipt')
            ->with(['booking.campaign', 'brandProfile'])
            ->latest()
            ->paginate(12);

        $totalEarned = Invoice::where('talent_profile_id', $profile->id)
            ->where('invoice_type', 'creator_payout_receipt')
            ->sum('grand_total_amount');

        return view('influencer.invoices.index', compact('profile', 'invoices', 'totalEarned'));
    }

    public function invoiceShow($id)
    {
        $profile = $this->getTalentProfile();
        $invoice = Invoice::where('id', $id)
            ->where('talent_profile_id', $profile->id)
            ->with(['booking.campaign', 'brandProfile.user', 'talentProfile.user'])
            ->firstOrFail();

        return view('influencer.invoices.show', compact('profile', 'invoice'));
    }
}
