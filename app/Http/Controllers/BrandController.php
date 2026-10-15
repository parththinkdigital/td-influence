<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Booking;
use App\Models\BrandTalentListItem;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\DeliverableSubmission;
use App\Models\Industry;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\Review;
use App\Models\TalentProfile;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    protected function getBrandProfile()
    {
        return Auth::user()->brandProfile;
    }

    public function dashboard()
    {
        $brandProfile = $this->getBrandProfile();

        if (! $brandProfile) {
            return redirect('/')->with('error', 'Brand profile missing.');
        }

        $campaignIds = $brandProfile->campaigns()->pluck('id');

        $stats = [
            'active_campaigns' => $brandProfile->campaigns()->where('status', 'published')->count(),
            'pending_campaigns' => $brandProfile->campaigns()->where('status', 'draft')->count(),
            'total_applications' => CampaignApplication::whereIn('campaign_id', $campaignIds)->count(),
            'pending_applications' => CampaignApplication::whereIn('campaign_id', $campaignIds)->where('status', 'applied')->count(),
            'shortlisted_applications' => CampaignApplication::whereIn('campaign_id', $campaignIds)->where('status', 'shortlisted')->count(),
            'active_collaborations' => Booking::whereIn('campaign_id', $campaignIds)->whereIn('status', ['confirmed', 'in_progress'])->count(),
        ];

        $recentCampaigns = $brandProfile->campaigns()->with('category')->latest()->take(5)->get();
        $recentApplications = CampaignApplication::whereIn('campaign_id', $campaignIds)
            ->with(['campaign', 'talentProfile.user'])
            ->latest()
            ->take(5)
            ->get();

        return view('brand.dashboard', compact('brandProfile', 'stats', 'recentCampaigns', 'recentApplications'));
    }

    public function profile()
    {
        $brandProfile = $this->getBrandProfile();
        $industries = Industry::where('status', 'active')->get();

        return view('brand.profile', compact('brandProfile', 'industries'));
    }

    public function updateProfile(Request $request)
    {
        $brandProfile = $this->getBrandProfile();

        $request->validate([
            'company_name' => 'required|string|max:255',
            'logo' => 'nullable|url',
            'website' => 'nullable|url',
            'industry_id' => 'nullable|exists:industries,id',
            'description' => 'nullable|string',
            'year_established' => 'nullable|integer',
            'company_size' => 'nullable|string',
            'headquarters' => 'nullable|string',
            'cities_served' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'contact_designation' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'gstin_pan' => 'nullable|string',
        ]);

        $brandProfile->update($request->all());

        if ($request->filled('logo')) {
            Auth::user()->update(['avatar' => $request->logo]);
        }

        return back()->with('success', 'Brand profile & logo updated successfully.');
    }

    public function campaignsIndex()
    {
        $brandProfile = $this->getBrandProfile();
        $campaigns = $brandProfile->campaigns()->with(['category', 'applications', 'bookings'])->latest()->paginate(10);

        return view('brand.campaigns.index', compact('campaigns'));
    }

    public function campaignCreate()
    {
        $categories = Category::all();
        $industries = Industry::all();

        return view('brand.campaigns.create', compact('categories', 'industries'));
    }

    public function campaignEdit($id)
    {
        $brandProfile = $this->getBrandProfile();
        $campaign = Campaign::where('id', $id)->where('brand_profile_id', $brandProfile->id)->firstOrFail();
        $categories = Category::all();
        $industries = Industry::all();

        return view('brand.campaigns.edit', compact('campaign', 'categories', 'industries'));
    }

    public function campaignUpdate(Request $request, $id)
    {
        $brandProfile = $this->getBrandProfile();
        $campaign = Campaign::where('id', $id)->where('brand_profile_id', $brandProfile->id)->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'campaign_type' => 'required|string',
            'description' => 'required|string',
            'talent_type' => 'required|string',
            'budget_min' => 'required|numeric|min:0',
            'budget_max' => 'required|numeric|min:0',
        ]);

        $campaign->update([
            'title' => $request->title,
            'campaign_name' => $request->title,
            'category_id' => $request->category_id,
            'campaign_type' => $request->campaign_type,
            'industry_id' => $request->industry_id,
            'description' => $request->description,
            'talent_type' => $request->talent_type,
            'work_mode' => $request->work_mode ?: 'on_site',
            'city' => $request->city,
            'budget_min' => $request->budget_min,
            'budget_max' => $request->budget_max,
        ]);

        return redirect()->route('brand.campaigns')->with('success', 'Campaign updated successfully.');
    }

    public function campaignDelete($id)
    {
        $brandProfile = $this->getBrandProfile();
        $campaign = Campaign::where('id', $id)->where('brand_profile_id', $brandProfile->id)->firstOrFail();
        $campaign->delete();

        return redirect()->route('brand.campaigns')->with('success', 'Campaign deleted.');
    }

    public function campaignShow($id)
    {
        $brandProfile = $this->getBrandProfile();
        $campaign = Campaign::where('id', $id)
            ->where('brand_profile_id', $brandProfile->id)
            ->with([
                'category',
                'deliverables',
                'usageRight',
                'questions',
                'applications' => function ($q) {
                    $q->latest();
                },
                'applications.talentProfile.user',
                'bookings.talentProfile.user',
            ])
            ->firstOrFail();

        return view('brand.campaigns.show', compact('campaign'));
    }

    // In-Panel Talent Search for Brands
    public function influencersIndex(Request $request)
    {
        $query = TalentProfile::with(['user', 'socialAccounts', 'portfolios', 'rates']);

        if ($request->filled('category')) {
            $query->whereJsonContains('primary_categories', $request->category);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%'.$request->city.'%');
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('display_name', 'like', '%'.$request->search.'%')
                    ->orWhere('username', 'like', '%'.$request->search.'%')
                    ->orWhere('bio', 'like', '%'.$request->search.'%');
            });
        }

        $talents = $query->latest()->paginate(9);
        $categories = Category::all();

        return view('brand.influencers.index', compact('talents', 'categories'));
    }

    public function influencerShow($id)
    {
        $talent = TalentProfile::with(['user', 'socialAccounts', 'portfolios', 'rates', 'availabilities', 'bookings.reviews'])
            ->findOrFail($id);
        $myCampaigns = $this->getBrandProfile()->campaigns()->where('status', 'published')->get();

        return view('brand.influencers.show', compact('talent', 'myCampaigns'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:shortlisted,selected,rejected',
        ]);

        $application = CampaignApplication::with(['campaign.brandProfile', 'talentProfile.user'])->findOrFail($id);

        if ($application->campaign->brand_profile_id !== $this->getBrandProfile()->id) {
            abort(403);
        }

        $application->update(['status' => $request->status]);

        // If selected, automatically create a Booking record
        if ($request->status === 'selected') {
            $agreedFee = $application->quoted_price;
            $platformFee = $agreedFee * 0.10;

            Booking::firstOrCreate(
                [
                    'campaign_id' => $application->campaign_id,
                    'application_id' => $application->id,
                ],
                [
                    'brand_profile_id' => $application->campaign->brand_profile_id,
                    'talent_profile_id' => $application->talent_profile_id,
                    'agreed_fee' => $agreedFee,
                    'platform_fee' => $platformFee,
                    'total_amount' => $agreedFee + $platformFee,
                    'shoot_date' => $application->campaign->shoot_date ?: now()->addDays(7),
                    'location' => $application->campaign->city ?: 'Location agreed via Chat',
                    'status' => 'confirmed',
                ]
            );
        }

        // Notify Creator
        if ($application->talentProfile && $application->talentProfile->user_id) {
            $brandName = $application->campaign->brandProfile->company_name ?? Auth::user()->name;
            $title = $request->status === 'selected' ? '🎉 Selected for Campaign!' : 'Application status update';
            $body = "{$brandName} marked your application for '{$application->campaign->title}' as {$request->status}.";
            AppNotification::send(
                $application->talentProfile->user_id,
                $title,
                $body,
                route('influencer.applications'),
                'application',
                Auth::id()
            );
        }

        return back()->with('success', "Application status updated to '{$request->status}'.");
    }

    public function bookingsIndex()
    {
        $brandProfile = $this->getBrandProfile();
        $bookings = Booking::where('brand_profile_id', $brandProfile->id)
            ->with(['campaign.deliverables', 'talentProfile.user', 'submissions.deliverable', 'reviews'])
            ->latest()
            ->paginate(10);

        return view('brand.bookings.index', compact('bookings'));
    }

    public function approveDeliverable(Request $request, $bookingId, $submissionId, InvoiceService $invoiceService)
    {
        $brandProfile = $this->getBrandProfile();
        $booking = Booking::where('id', $bookingId)
            ->where('brand_profile_id', $brandProfile->id)
            ->with(['campaign', 'talentProfile.user'])
            ->firstOrFail();

        $submission = DeliverableSubmission::where('id', $submissionId)
            ->where('booking_id', $booking->id)
            ->firstOrFail();

        $submission->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        $booking->update([
            'status' => 'completed',
        ]);

        // Auto-Generate GST Tax Invoice for Brand and Disbursement Receipt for Talent
        $invoiceService->generateForBooking($booking);

        // Recalculate talent profile completion rate
        if ($booking->talentProfile) {
            $totalBookings = Booking::where('talent_profile_id', $booking->talent_profile_id)->count();
            $completedBookings = Booking::where('talent_profile_id', $booking->talent_profile_id)->where('status', 'completed')->count();
            $completionRate = $totalBookings > 0 ? round(($completedBookings / $totalBookings) * 100, 2) : 100.00;
            $booking->talentProfile->update(['completion_rate' => $completionRate]);
        }

        // Send celebratory notification to Creator
        if ($booking->talentProfile && $booking->talentProfile->user_id) {
            $brandName = $brandProfile->company_name ?? Auth::user()->name;
            AppNotification::send(
                $booking->talentProfile->user_id,
                '🎉 Deliverable Approved & Escrow Released!',
                "{$brandName} approved your content for '{$booking->campaign->title}'. Payout of ₹".number_format($booking->agreed_fee).' is released! Payout receipt generated.',
                route('influencer.bookings'),
                'booking',
                Auth::id()
            );
        }

        return back()->with('success', 'Deliverable approved successfully! Escrow payout of ₹'.number_format($booking->agreed_fee).' has been released and Tax Invoice #'.($booking->invoices->first()?->invoice_number ?? '').' generated.');
    }

    public function invoicesIndex()
    {
        $brandProfile = $this->getBrandProfile();
        $invoices = Invoice::where('brand_profile_id', $brandProfile->id)
            ->where('invoice_type', 'brand_tax_invoice')
            ->with(['booking.campaign', 'talentProfile'])
            ->latest()
            ->paginate(12);

        $totalSpent = Invoice::where('brand_profile_id', $brandProfile->id)->where('invoice_type', 'brand_tax_invoice')->sum('grand_total_amount');
        $totalTaxPaid = Invoice::where('brand_profile_id', $brandProfile->id)->where('invoice_type', 'brand_tax_invoice')->sum('total_tax_amount');

        return view('brand.invoices.index', compact('invoices', 'totalSpent', 'totalTaxPaid'));
    }

    public function invoiceShow($id)
    {
        $brandProfile = $this->getBrandProfile();
        $invoice = Invoice::where('id', $id)
            ->where('brand_profile_id', $brandProfile->id)
            ->with(['booking.campaign', 'talentProfile.user', 'brandProfile.user'])
            ->firstOrFail();

        return view('brand.invoices.show', compact('invoice'));
    }

    public function requestDeliverableRevision(Request $request, $bookingId, $submissionId)
    {
        $request->validate([
            'revision_feedback' => 'required|string|min:5|max:1000',
        ]);

        $brandProfile = $this->getBrandProfile();
        $booking = Booking::where('id', $bookingId)
            ->where('brand_profile_id', $brandProfile->id)
            ->with(['campaign', 'talentProfile.user'])
            ->firstOrFail();

        $submission = DeliverableSubmission::where('id', $submissionId)
            ->where('booking_id', $booking->id)
            ->firstOrFail();

        $submission->update([
            'status' => 'changes_requested',
            'revision_feedback' => $request->revision_feedback,
        ]);

        $booking->update([
            'status' => 'in_progress',
        ]);

        // Send revision alert to Creator
        if ($booking->talentProfile && $booking->talentProfile->user_id) {
            $brandName = $brandProfile->company_name ?? Auth::user()->name;
            AppNotification::send(
                $booking->talentProfile->user_id,
                "⚠️ Revision Requested for '{$booking->campaign->title}'",
                "{$brandName} requested modifications: '{$request->revision_feedback}'. Please submit an updated link.",
                route('influencer.bookings'),
                'booking',
                Auth::id()
            );
        }

        return back()->with('info', 'Revision feedback submitted. Creator has been notified to provide an updated deliverable.');
    }

    public function submitReview(Request $request, $bookingId)
    {
        $request->validate([
            'rating_overall' => 'required|integer|min:1|max:5',
            'quality_rating' => 'nullable|integer|min:1|max:5',
            'communication_rating' => 'nullable|integer|min:1|max:5',
            'punctuality_rating' => 'nullable|integer|min:1|max:5',
            'professionalism_rating' => 'nullable|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        $brandProfile = $this->getBrandProfile();
        $booking = Booking::where('id', $bookingId)
            ->where('brand_profile_id', $brandProfile->id)
            ->with(['campaign', 'talentProfile.user'])
            ->firstOrFail();

        $review = Review::updateOrCreate(
            [
                'booking_id' => $booking->id,
                'reviewer_id' => Auth::id(),
            ],
            [
                'reviewee_id' => $booking->talentProfile->user_id,
                'rating_overall' => $request->rating_overall,
                'quality_rating' => $request->quality_rating ?: $request->rating_overall,
                'communication_rating' => $request->communication_rating ?: $request->rating_overall,
                'punctuality_rating' => $request->punctuality_rating ?: $request->rating_overall,
                'professionalism_rating' => $request->professionalism_rating ?: $request->rating_overall,
                'review_text' => $request->review_text,
            ]
        );

        // Recalculate talent profile average rating and review counts
        if ($booking->talentProfile) {
            $reviews = Review::where('reviewee_id', $booking->talentProfile->user_id)->get();
            $avgRating = round($reviews->avg('rating_overall'), 2);
            $reviewsCount = $reviews->count();
            $booking->talentProfile->update([
                'rating_avg' => $avgRating,
                'reviews_count' => $reviewsCount,
            ]);
        }

        // Send Notification to Creator
        if ($booking->talentProfile && $booking->talentProfile->user_id) {
            $brandName = $brandProfile->company_name ?? Auth::user()->name;
            AppNotification::send(
                $booking->talentProfile->user_id,
                "⭐ {$request->rating_overall}-Star Review Received from {$brandName}!",
                "{$brandName} rated your work on '{$booking->campaign->title}': '{$request->review_text}'",
                route('influencer.bookings'),
                'review',
                Auth::id()
            );
        }

        return back()->with('success', 'Review submitted successfully! Thank you for rating the creator.');
    }

    public function messagesIndex()
    {
        $brandProfile = $this->getBrandProfile();
        $conversations = Conversation::where('brand_user_id', Auth::id())
            ->with(['campaign', 'talentUser.talentProfile', 'messages' => function ($q) {
                $q->latest();
            }])
            ->get()
            ->sortByDesc(function ($conv) {
                return $conv->messages->first()?->created_at ?? $conv->updated_at;
            });

        return view('brand.messages.index', compact('conversations', 'brandProfile'));
    }

    public function chat(Request $request, $applicationId = null)
    {
        $brandProfile = $this->getBrandProfile();

        if ($request->filled('talent_id') && ! $applicationId) {
            $talent = TalentProfile::with(['user', 'rates'])->findOrFail($request->talent_id);
            $campaign = $brandProfile->campaigns()->latest()->first();

            if (! $campaign) {
                $campaign = $brandProfile->campaigns()->create([
                    'title' => 'Direct Brand Collaboration with '.($brandProfile->company_name ?? 'Brand'),
                    'slug' => 'collab-'.Str::random(8),
                    'campaign_name' => 'Direct Collaboration',
                    'campaign_type' => 'influencer_campaign',
                    'budget_type' => 'negotiable',
                    'budget_min' => 10000,
                    'budget_max' => 50000,
                    'status' => 'published',
                ]);
            }

            $application = CampaignApplication::firstOrCreate(
                [
                    'campaign_id' => $campaign->id,
                    'talent_profile_id' => $talent->id,
                ],
                [
                    'proposed_price' => $talent->rates->min('rate_amount') ?: 15000,
                    'cover_note' => 'Direct brand collaboration inquiry',
                    'status' => 'shortlisted',
                ]
            );

            return redirect()->route('brand.chat', $application->id);
        }

        $application = CampaignApplication::with(['campaign.brandProfile', 'talentProfile.user'])->findOrFail($applicationId);

        if ($application->campaign->brand_profile_id !== $brandProfile->id) {
            abort(403);
        }

        $conversation = Conversation::firstOrCreate([
            'campaign_id' => $application->campaign_id,
            'application_id' => $application->id,
            'brand_user_id' => Auth::id(),
            'talent_user_id' => $application->talentProfile->user_id,
        ]);

        // Mark unread messages from talent as read
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

        return view('brand.chat', compact('conversation', 'application', 'messages', 'booking', 'jsonMessages'));
    }

    public function chatByConversation($conversationId)
    {
        $conversation = Conversation::with(['application'])->findOrFail($conversationId);
        if ($conversation->brand_user_id !== Auth::id()) {
            abort(403);
        }
        if ($conversation->application_id) {
            return redirect()->route('brand.chat', $conversation->application_id);
        }

        return redirect()->route('brand.messages');
    }

    public function fetchMessages($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        if ($conversation->brand_user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Mark talent's messages as read
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

        $conversation = Conversation::with(['campaign', 'talentUser.talentProfile', 'application'])->findOrFail($conversationId);

        if ($conversation->brand_user_id !== Auth::id()) {
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

        // Send AppNotification to Talent
        $brandName = Auth::user()->brandProfile->company_name ?? Auth::user()->name;
        $campaignTitle = $conversation->campaign->title ?? 'Campaign';

        $notifTitle = "New message from {$brandName}";
        $notifBody = $request->proposal_price
            ? 'Sent a commercial offer of ₹'.number_format($request->proposal_price)." for '{$campaignTitle}'"
            : ($request->message_text ? Str::limit($request->message_text, 80) : "Shared an attachment link for '{$campaignTitle}'");

        AppNotification::send(
            $conversation->talent_user_id,
            $notifTitle,
            $notifBody,
            route('influencer.chat', $conversation->application_id ?: $conversation->id),
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

        $conversation = Conversation::with(['campaign', 'talentUser.talentProfile', 'application'])->findOrFail($conversationId);

        if ($conversation->brand_user_id !== Auth::id()) {
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

            // Update application status to selected
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

            // Notify Creator
            $brandName = Auth::user()->brandProfile->company_name ?? Auth::user()->name;
            AppNotification::send(
                $conversation->talent_user_id,
                "✅ Offer Accepted by {$brandName}!",
                'Your rate of ₹'.number_format($agreedFee)." for '{$conversation->campaign->title}' was accepted. Booking is confirmed with {$usageLabel}!",
                route('influencer.bookings'),
                'booking',
                Auth::id()
            );

            return back()->with('success', 'Offer accepted! Booking confirmed at ₹'.number_format($agreedFee));
        } else {
            $message->update(['proposal_status' => 'rejected']);

            // Notify Creator
            $brandName = Auth::user()->brandProfile->company_name ?? Auth::user()->name;
            AppNotification::send(
                $conversation->talent_user_id,
                'Offer declined',
                "{$brandName} declined the commercial offer of ₹".number_format($message->proposal_price)." for '{$conversation->campaign->title}'. You can submit a revised quote.",
                route('influencer.chat', $conversation->application_id ?: $conversation->id),
                'proposal',
                Auth::id()
            );

            return back()->with('info', 'Offer declined.');
        }
    }

    public function notificationsIndex()
    {
        $notifications = Auth::user()->appNotifications()->with('sender')->paginate(20);

        return view('brand.notifications.index', compact('notifications'));
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

    /*
    |--------------------------------------------------------------------------
    | Brand Shortlists & Campaign Rosters
    |--------------------------------------------------------------------------
    */
    public function listsIndex()
    {
        $brandProfile = $this->getBrandProfile();
        $lists = $brandProfile->talentLists()->withCount('items')->latest()->get();

        return view('brand.lists.index', compact('lists', 'brandProfile'));
    }

    public function listStore(Request $request)
    {
        $brandProfile = $this->getBrandProfile();
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $brandProfile->talentLists()->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Talent shortlist created successfully.');
    }

    public function listShow($id)
    {
        $brandProfile = $this->getBrandProfile();
        $list = $brandProfile->talentLists()->with(['talents.user', 'talents.socialAccounts', 'talents.rates'])->findOrFail($id);
        $campaigns = $brandProfile->campaigns()->where('status', 'published')->get();

        // Calculate aggregated roster metrics
        $totalReach = 0;
        $totalEstimatedBudget = 0;
        foreach ($list->talents as $t) {
            $totalReach += $t->socialAccounts->sum('followers');
            $totalEstimatedBudget += ($t->rates->min('rate_amount') ?: 15000);
        }

        return view('brand.lists.show', compact('list', 'brandProfile', 'campaigns', 'totalReach', 'totalEstimatedBudget'));
    }

    public function listDelete($id)
    {
        $brandProfile = $this->getBrandProfile();
        $list = $brandProfile->talentLists()->findOrFail($id);
        $list->delete();

        return redirect()->route('brand.lists.index')->with('success', 'Talent shortlist deleted.');
    }

    public function toggleTalentListItem(Request $request)
    {
        $brandProfile = $this->getBrandProfile();
        $request->validate([
            'talent_profile_id' => 'required|exists:talent_profiles,id',
            'list_id' => 'nullable|exists:brand_talent_lists,id',
            'new_list_name' => 'nullable|string|max:255',
        ]);

        $list = null;
        if ($request->filled('new_list_name')) {
            $list = $brandProfile->talentLists()->create([
                'name' => $request->new_list_name,
            ]);
        } elseif ($request->filled('list_id')) {
            $list = $brandProfile->talentLists()->findOrFail($request->list_id);
        } else {
            // Default "Favorites / Shortlist"
            $list = $brandProfile->talentLists()->firstOrCreate([
                'name' => 'Default Shortlist',
            ]);
        }

        $existing = BrandTalentListItem::where('brand_talent_list_id', $list->id)
            ->where('talent_profile_id', $request->talent_profile_id)
            ->first();

        if ($existing) {
            $existing->delete();
            $action = 'removed';
        } else {
            BrandTalentListItem::create([
                'brand_talent_list_id' => $list->id,
                'talent_profile_id' => $request->talent_profile_id,
            ]);
            $action = 'added';
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'action' => $action,
                'list_name' => $list->name,
                'message' => $action === 'added' ? 'Added to '.$list->name : 'Removed from '.$list->name,
            ]);
        }

        return back()->with('success', $action === 'added' ? 'Talent added to roster.' : 'Talent removed from roster.');
    }

    public function bulkInviteToList(Request $request, $id)
    {
        $brandProfile = $this->getBrandProfile();
        $list = $brandProfile->talentLists()->with('talents.user')->findOrFail($id);

        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'note' => 'nullable|string',
        ]);

        $campaign = $brandProfile->campaigns()->findOrFail($request->campaign_id);
        $invitedCount = 0;

        foreach ($list->talents as $talent) {
            // Check if application / invite already exists
            $existingApp = CampaignApplication::firstOrCreate(
                [
                    'campaign_id' => $campaign->id,
                    'talent_profile_id' => $talent->id,
                ],
                [
                    'proposed_price' => $talent->rates->min('rate_amount') ?: $campaign->budget_min,
                    'cover_note' => $request->note ?: "You have been directly invited by {$brandProfile->company_name} for the '{$campaign->title}' campaign!",
                    'status' => 'shortlisted',
                ]
            );

            // Send In-App Notification to creator
            if ($talent->user) {
                AppNotification::create([
                    'user_id' => $talent->user->id,
                    'sender_id' => Auth::id(),
                    'type' => 'campaign_invite',
                    'title' => "Campaign Invite from {$brandProfile->company_name}",
                    'body' => "You have been invited to collaborate on '{$campaign->title}'. Click to view brief & respond.",
                    'action_url' => route('influencer.campaigns.show', $campaign->id),
                ]);
            }
            $invitedCount++;
        }

        return back()->with('success', "Bulk invitation dispatched to {$invitedCount} creators in this roster!");
    }
}
