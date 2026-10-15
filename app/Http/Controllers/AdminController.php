<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Category;
use App\Models\Dispute;
use App\Models\Industry;
use App\Models\Invoice;
use App\Models\TalentProfile;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'brands_count' => BrandProfile::count(),
            'influencers_count' => TalentProfile::count(),
            'talents_count' => TalentProfile::count(),
            'campaigns_count' => Campaign::count(),
            'pending_campaigns' => Campaign::where('status', 'pending_review')->count(),
            'applications_count' => CampaignApplication::count(),
            'active_bookings' => Booking::whereIn('status', ['confirmed', 'in_progress', 'deliverables_submitted'])->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'total_gmv' => Booking::sum('total_amount') ?: 0,
            'platform_fee_revenue' => Booking::sum('platform_fee') ?: 0,
            'disbursed_volume' => Booking::where('status', 'completed')->sum('agreed_fee') ?: 0,
            'pending_verifications' => Verification::where('status', 'pending')->count(),
            'open_disputes' => Dispute::where('status', 'open')->count(),
            'models_count' => TalentProfile::whereNotNull('height_cm')->orWhereNotNull('modeling_categories')->count(),
            'anchors_count' => TalentProfile::whereNotNull('hosting_style')->orWhereNotNull('event_types')->count(),
        ];

        $recentBrands = BrandProfile::with('user', 'industry')->latest()->take(5)->get();
        $recentTalents = TalentProfile::with('user', 'socialAccounts')->latest()->take(5)->get();
        $pendingCampaigns = Campaign::where('status', 'pending_review')->with('brandProfile')->latest()->take(5)->get();
        $recentBookings = Booking::with('brandProfile', 'talentProfile', 'campaign')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBrands', 'recentTalents', 'pendingCampaigns', 'recentBookings'));
    }

    public function brands()
    {
        $brands = BrandProfile::with('user', 'industry')->latest()->paginate(10);
        $industries = Industry::where('status', 'active')->get();

        return view('admin.brands.index', compact('brands', 'industries'));
    }

    public function generateBrandCredentials(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->contact_name.' ('.$request->company_name.')',
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'brand',
            'status' => 'active',
        ]);

        BrandProfile::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'contact_person' => $request->contact_name,
            'contact_phone' => $request->phone,
            'verification_status' => 'verified',
        ]);

        return redirect()->route('admin.brands')->with('credential_created', [
            'company_name' => $request->company_name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
    }

    public function influencers()
    {
        $talents = TalentProfile::with(['user', 'socialAccounts', 'portfolios'])->latest()->paginate(10);
        $influencers = $talents;

        return view('admin.influencers.index', compact('talents', 'influencers'));
    }

    public function updateInfluencerStatus(Request $request, $id)
    {
        $talent = TalentProfile::findOrFail($id);

        if ($request->has('verification_level')) {
            $request->validate([
                'verification_level' => 'required|integer|min:1|max:5',
            ]);
            $talent->update(['verification_level' => $request->verification_level]);

            return back()->with('success', "Talent verification level updated to Level {$request->verification_level}.");
        }

        if ($request->has('verification_status')) {
            $request->validate([
                'verification_status' => 'required|in:verified,pending,rejected',
            ]);
            $levelMap = [
                'rejected' => 1,
                'pending' => 1,
                'verified' => 5,
            ];
            $talent->update(['verification_level' => $levelMap[$request->verification_status] ?? 1]);

            return back()->with('success', 'Talent verification status updated successfully.');
        }

        return back();
    }

    public function campaigns()
    {
        $campaigns = Campaign::with(['brandProfile', 'category'])->latest()->paginate(10);

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function updateCampaignStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:published,pending_review,paused,completed,cancelled',
        ]);

        $campaign = Campaign::findOrFail($id);
        $campaign->update(['status' => $request->status]);

        return back()->with('success', "Campaign status updated to '{$request->status}'.");
    }

    public function categories()
    {
        $categories = Category::latest()->get();
        $industries = Industry::latest()->get();

        return view('admin.categories.index', compact('categories', 'industries'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'type' => 'required|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => $request->type,
            'status' => 'active',
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    public function storeIndustry(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:industries,name',
        ]);

        Industry::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => 'active',
        ]);

        return back()->with('success', 'Industry created successfully.');
    }

    public function verifications()
    {
        $verifications = Verification::with('user')->latest()->paginate(10);

        return view('admin.verifications', compact('verifications'));
    }

    public function updateVerificationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $verification = Verification::with('user.talentProfile')->findOrFail($id);
        $verification->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'verified_at' => $request->status === 'approved' ? now() : null,
        ]);

        if ($request->status === 'approved' && $verification->user && $verification->user->talentProfile) {
            $currentLevel = $verification->user->talentProfile->verification_level;
            $newLevel = max($currentLevel, $verification->verification_level);
            $verification->user->talentProfile->update(['verification_level' => $newLevel]);
        }

        return back()->with('success', "Verification request marked as {$request->status}.");
    }

    public function disputes()
    {
        $disputes = Dispute::with(['booking.campaign', 'booking.brandProfile', 'booking.talentProfile', 'openedBy'])->latest()->paginate(10);

        return view('admin.disputes', compact('disputes'));
    }

    public function resolveDispute(Request $request, $id)
    {
        $request->validate([
            'resolution_decision' => 'required|string|max:500',
            'status' => 'required|in:resolved,rejected',
        ]);

        $dispute = Dispute::with('booking')->findOrFail($id);
        $dispute->update([
            'status' => $request->status,
            'resolution_decision' => $request->resolution_decision,
        ]);

        if ($request->status === 'resolved' && $dispute->booking) {
            $dispute->booking->update(['status' => 'completed']);
        }

        return back()->with('success', 'Dispute arbitrated and decision recorded.');
    }

    public function invoices(Request $request)
    {
        $query = Invoice::with(['booking.campaign', 'brandProfile.user', 'talentProfile.user']);

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('invoice_type', $request->type);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('invoice_number', 'like', "%{$s}%")
                    ->orWhereHas('brandProfile', function ($bq) use ($s) {
                        $bq->where('company_name', 'like', "%{$s}%");
                    })
                    ->orWhereHas('talentProfile', function ($tq) use ($s) {
                        $tq->where('display_name', 'like', "%{$s}%")
                            ->orWhere('username', 'like', "%{$s}%");
                    });
            });
        }

        $invoices = $query->latest()->paginate(20);

        $totalGstCollected = Invoice::where('invoice_type', 'brand_tax_invoice')->sum('total_tax_amount');
        $totalBilled = Invoice::where('invoice_type', 'brand_tax_invoice')->sum('grand_total_amount');
        $totalPaidOut = Invoice::where('invoice_type', 'creator_payout_receipt')->sum('grand_total_amount');

        return view('admin.invoices.index', compact('invoices', 'totalGstCollected', 'totalBilled', 'totalPaidOut'));
    }

    public function invoiceShow($id)
    {
        $invoice = Invoice::with(['booking.campaign', 'brandProfile.user', 'talentProfile.user'])->findOrFail($id);

        return view('admin.invoices.show', compact('invoice'));
    }
}
