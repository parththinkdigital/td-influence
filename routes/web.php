<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\InstagramOAuthController;
use App\Http\Controllers\InstagramWebhookController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WhatsAppWebhookController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Marketplace Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/how-it-works', [PublicController::class, 'howItWorks'])->name('how-it-works');
Route::get('/pricing', [PublicController::class, 'pricing'])->name('pricing');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::get('/privacy', [PublicController::class, 'privacy'])->name('privacy');
Route::get('/privacy-policy', [PublicController::class, 'privacy']);
Route::get('/terms', [PublicController::class, 'terms'])->name('terms');
Route::get('/terms-of-service', [PublicController::class, 'terms']);
Route::get('/data-deletion', [PublicController::class, 'dataDeletion'])->name('data-deletion');
Route::get('/user-data-deletion', [PublicController::class, 'dataDeletion']);

Route::get('/campaigns', [PublicController::class, 'campaigns'])->name('campaigns.public');
Route::get('/campaigns/{slug}', [PublicController::class, 'campaignShow'])->name('campaigns.public.show');
Route::get('/influencers', [PublicController::class, 'influencers'])->name('influencers.public');
Route::get('/talent/compare-data', [PublicController::class, 'talentCompare'])->name('talent.compare.data');
Route::get('/influencers/{username}', [PublicController::class, 'influencerShow'])->name('influencers.public.show');
Route::get('/font-pair', [PublicController::class, 'fontPairs'])->name('font.pairs');
Route::get('/light', [PublicController::class, 'homeLight'])->name('home.light');
Route::get('/light2', [PublicController::class, 'homeLight2'])->name('home.light2');
Route::get('/light3', [PublicController::class, 'homeLight3'])->name('home.light3');
Route::get('/dark', [PublicController::class, 'homeDark'])->name('home.dark');
Route::get('/dark2', [PublicController::class, 'homeDark2'])->name('home.dark2');
Route::get('/dark3', [PublicController::class, 'homeDark3'])->name('home.dark3');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::post('/register/influencer', [AuthController::class, 'registerInfluencer'])->name('register.influencer');

    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin']);

    Route::get('/brand/login', [AuthController::class, 'showBrandLogin'])->name('brand.login');
    Route::post('/brand/login', [AuthController::class, 'brandLogin']);

    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

    // WhatsApp Instant Login & Registration
    Route::post('/auth/whatsapp/send-otp', [AuthController::class, 'sendWhatsAppLoginOtp'])->name('auth.whatsapp.send_otp');
    Route::post('/auth/whatsapp/verify', [AuthController::class, 'verifyWhatsAppLoginOtp'])->name('auth.whatsapp.verify');
});

// Instagram OAuth Routes (Requires Logged-In User)
Route::middleware('auth')->group(function () {
    Route::get('/auth/instagram/redirect', [InstagramOAuthController::class, 'redirect'])->name('auth.instagram.redirect');
    Route::get('/auth/instagram/callback', [InstagramOAuthController::class, 'callback'])->name('auth.instagram.callback');
});

// Instagram Webhooks
Route::get('/webhooks/instagram', [InstagramWebhookController::class, 'verify']);
Route::post('/webhooks/instagram', [InstagramWebhookController::class, 'handle']);
Route::match(['get', 'post'], '/webhooks/data-deletion', [InstagramWebhookController::class, 'dataDeletionCallback'])->name('webhooks.data-deletion');

// WhatsApp Cloud API Webhooks
Route::get('/webhooks/whatsapp', [WhatsAppWebhookController::class, 'verify']);
Route::post('/webhooks/whatsapp', [WhatsAppWebhookController::class, 'handle']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Portal
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', RoleMiddleware::class.':admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/brands', [AdminController::class, 'brands'])->name('brands');
    Route::post('/brands/generate', [AdminController::class, 'generateBrandCredentials'])->name('brands.generate');

    Route::get('/influencers', [AdminController::class, 'influencers'])->name('influencers');
    Route::post('/influencers/{id}/status', [AdminController::class, 'updateInfluencerStatus'])->name('influencers.status');

    Route::get('/campaigns', [AdminController::class, 'campaigns'])->name('campaigns');
    Route::post('/campaigns/{id}/status', [AdminController::class, 'updateCampaignStatus'])->name('campaigns.status');

    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories/store', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::post('/industries/store', [AdminController::class, 'storeIndustry'])->name('industries.store');

    Route::get('/verifications', [AdminController::class, 'verifications'])->name('verifications');
    Route::post('/verifications/{id}/status', [AdminController::class, 'updateVerificationStatus'])->name('verifications.status');

    Route::get('/disputes', [AdminController::class, 'disputes'])->name('disputes');
    Route::post('/disputes/{id}/status', [AdminController::class, 'resolveDispute'])->name('disputes.status');

    Route::get('/invoices', [AdminController::class, 'invoices'])->name('invoices');
    Route::get('/invoices/{id}', [AdminController::class, 'invoiceShow'])->name('invoices.show');
});

/*
|--------------------------------------------------------------------------
| Brand Portal
|--------------------------------------------------------------------------
*/
Route::prefix('brand')->middleware(['auth', RoleMiddleware::class.':brand'])->name('brand.')->group(function () {
    Route::get('/dashboard', [BrandController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [BrandController::class, 'profile'])->name('profile');
    Route::post('/profile', [BrandController::class, 'updateProfile']);

    Route::get('/campaigns', [BrandController::class, 'campaignsIndex'])->name('campaigns');
    Route::get('/campaigns/create', [BrandController::class, 'campaignCreate'])->name('campaigns.create');
    Route::post('/campaigns', [BrandController::class, 'campaignStore']);
    Route::get('/campaigns/{id}', [BrandController::class, 'campaignShow'])->name('campaigns.show');
    Route::get('/campaigns/{id}/edit', [BrandController::class, 'campaignEdit'])->name('campaigns.edit');
    Route::put('/campaigns/{id}', [BrandController::class, 'campaignUpdate'])->name('campaigns.update');
    Route::delete('/campaigns/{id}', [BrandController::class, 'campaignDelete'])->name('campaigns.delete');

    Route::get('/influencers', [BrandController::class, 'influencersIndex'])->name('influencers');
    Route::get('/influencers/{id}', [BrandController::class, 'influencerShow'])->name('influencers.show');
    Route::get('/influencer/{id}', [BrandController::class, 'influencerShow'])->name('influencer.show');

    Route::post('/applications/{id}/status', [BrandController::class, 'updateApplicationStatus'])->name('applications.status');

    // Brand Chat & Negotiation
    Route::get('/messages', [BrandController::class, 'messagesIndex'])->name('messages');
    Route::get('/chat/c/{conversationId}', [BrandController::class, 'chatByConversation'])->name('chat.conversation');
    Route::get('/chat/{applicationId?}', [BrandController::class, 'chat'])->name('chat');
    Route::post('/chat/{conversationId}/send', [BrandController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/{conversationId}/offer-action', [BrandController::class, 'offerAction'])->name('chat.offer_action');
    Route::get('/chat/{conversationId}/fetch', [BrandController::class, 'fetchMessages'])->name('chat.fetch');

    // Brand Notifications
    Route::get('/notifications', [BrandController::class, 'notificationsIndex'])->name('notifications');
    Route::post('/notifications/{id}/read', [BrandController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [BrandController::class, 'markAllNotificationsRead'])->name('notifications.read_all');
    Route::get('/notifications/unread-count', [BrandController::class, 'unreadNotificationsCount'])->name('notifications.unread_count');

    Route::get('/bookings', [BrandController::class, 'bookingsIndex'])->name('bookings');
    Route::post('/bookings/{bookingId}/submissions/{submissionId}/approve', [BrandController::class, 'approveDeliverable'])->name('bookings.approve');
    Route::post('/bookings/{bookingId}/submissions/{submissionId}/revision', [BrandController::class, 'requestDeliverableRevision'])->name('bookings.revision');
    Route::post('/bookings/{bookingId}/review', [BrandController::class, 'submitReview'])->name('bookings.review');

    // Brand Invoices & Billing
    Route::get('/invoices', [BrandController::class, 'invoicesIndex'])->name('invoices');
    Route::get('/invoices/{id}', [BrandController::class, 'invoiceShow'])->name('invoices.show');

    // Brand Talent Lists & Rosters
    Route::get('/lists', [BrandController::class, 'listsIndex'])->name('lists.index');
    Route::post('/lists', [BrandController::class, 'listStore'])->name('lists.store');
    Route::get('/lists/{id}', [BrandController::class, 'listShow'])->name('lists.show');
    Route::delete('/lists/{id}', [BrandController::class, 'listDelete'])->name('lists.delete');
    Route::post('/lists/toggle-item', [BrandController::class, 'toggleTalentListItem'])->name('lists.toggle');
    Route::post('/lists/{id}/bulk-invite', [BrandController::class, 'bulkInviteToList'])->name('lists.bulk_invite');
});

/*
|--------------------------------------------------------------------------
| Talent / Creator Portal
|--------------------------------------------------------------------------
*/
Route::prefix('influencer')->middleware(['auth', RoleMiddleware::class.':talent,influencer'])->name('influencer.')->group(function () {
    Route::get('/dashboard', [InfluencerController::class, 'dashboard'])->name('dashboard');
    Route::get('/onboarding', [InfluencerController::class, 'onboarding'])->name('onboarding');
    Route::post('/onboarding', [InfluencerController::class, 'saveOnboarding'])->name('onboarding.save');

    Route::get('/profile', [InfluencerController::class, 'profile'])->name('profile');
    Route::post('/profile', [InfluencerController::class, 'updateProfile']);
    Route::post('/profile/fetch-social-avatar', [InfluencerController::class, 'fetchSocialAvatar'])->name('profile.fetch_social_avatar');
    Route::post('/availability', [InfluencerController::class, 'updateAvailabilityStatus'])->name('availability.update');
    Route::post('/availability/date', [InfluencerController::class, 'storeAvailabilityDate'])->name('availability.date.store');
    Route::delete('/availability/date/{id}', [InfluencerController::class, 'deleteAvailabilityDate'])->name('availability.date.delete');

    Route::get('/portfolio', [InfluencerController::class, 'portfolioIndex'])->name('portfolio');
    Route::post('/portfolio', [InfluencerController::class, 'storePortfolio']);
    Route::delete('/portfolio/{id}', [InfluencerController::class, 'deletePortfolio'])->name('portfolio.delete');

    Route::get('/social', [InfluencerController::class, 'socialIndex'])->name('social');
    Route::post('/social', [InfluencerController::class, 'storeSocial']);
    Route::post('/social/sync-all', [InfluencerController::class, 'syncAllSocial'])->name('social.sync_all');
    Route::post('/social/add-collaboration-reel', [InfluencerController::class, 'addCollaborationReel'])->name('social.add_collab_reel');
    Route::post('/social/remove-collaboration-reel', [InfluencerController::class, 'removeCollaborationReel'])->name('social.remove_collab_reel');
    Route::put('/social/{id}', [InfluencerController::class, 'updateSocial'])->name('social.update');
    Route::post('/social/{id}/refresh', [InfluencerController::class, 'refreshSocial'])->name('social.refresh');
    Route::delete('/social/{id}', [InfluencerController::class, 'deleteSocial'])->name('social.delete');

    Route::get('/rates', [InfluencerController::class, 'ratesIndex'])->name('rates');
    Route::get('/gigs', [InfluencerController::class, 'ratesIndex'])->name('gigs');
    Route::post('/rates', [InfluencerController::class, 'storeRate']);
    Route::post('/gigs', [InfluencerController::class, 'storeRate'])->name('gigs.store');
    Route::put('/gigs/{id}', [InfluencerController::class, 'updateGig'])->name('gigs.update');
    Route::delete('/gigs/{id}', [InfluencerController::class, 'deleteGig'])->name('gigs.delete');

    Route::get('/applications', [InfluencerController::class, 'applicationsIndex'])->name('applications');
    Route::get('/campaigns', [InfluencerController::class, 'campaignsIndex'])->name('campaigns');
    Route::get('/campaigns/{id}', [InfluencerController::class, 'campaignShow'])->name('campaigns.show');
    Route::post('/campaigns/{id}/apply', [InfluencerController::class, 'apply'])->name('campaigns.apply');

    Route::get('/collaborations', [InfluencerController::class, 'bookingsIndex'])->name('collaborations');
    Route::get('/collaborations/{id}', [InfluencerController::class, 'bookingsIndex'])->name('collaborations.show');

    Route::get('/bookings', [InfluencerController::class, 'bookingsIndex'])->name('bookings');
    Route::post('/bookings/{id}/submit', [InfluencerController::class, 'submitDeliverable'])->name('bookings.submit');

    // Talent Invoices & Payout Receipts
    Route::get('/invoices', [InfluencerController::class, 'invoicesIndex'])->name('invoices');
    Route::get('/invoices/{id}', [InfluencerController::class, 'invoiceShow'])->name('invoices.show');

    // Talent Chat & Negotiation
    Route::get('/messages', [InfluencerController::class, 'messagesIndex'])->name('messages');
    Route::get('/chat/c/{conversationId}', [InfluencerController::class, 'chatByConversation'])->name('chat.conversation');
    Route::get('/chat/{applicationId}', [InfluencerController::class, 'chat'])->name('chat');
    Route::post('/chat/{conversationId}/send', [InfluencerController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/{conversationId}/offer-action', [InfluencerController::class, 'offerAction'])->name('chat.offer_action');
    Route::get('/chat/{conversationId}/fetch', [InfluencerController::class, 'fetchMessages'])->name('chat.fetch');

    // Talent Notifications
    Route::get('/notifications', [InfluencerController::class, 'notificationsIndex'])->name('notifications');
    Route::post('/notifications/{id}/read', [InfluencerController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [InfluencerController::class, 'markAllNotificationsRead'])->name('notifications.read_all');
    Route::get('/notifications/unread-count', [InfluencerController::class, 'unreadNotificationsCount'])->name('notifications.unread_count');

    // Talent Verification & Govt KYC Hub
    Route::get('/verification', [VerificationController::class, 'index'])->name('verification');
    Route::post('/verification/send-phone-otp', [VerificationController::class, 'sendPhoneOtp'])->name('verification.send_phone_otp');
    Route::post('/verification/verify-phone-otp', [VerificationController::class, 'verifyPhoneOtp'])->name('verification.verify_phone_otp');
    Route::post('/verification/submit-id', [VerificationController::class, 'submitGovtId'])->name('verification.submit_govt_id');
});
