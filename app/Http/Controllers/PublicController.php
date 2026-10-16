<?php

namespace App\Http\Controllers;

use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\TalentProfile;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $featuredCampaigns = Campaign::where('status', 'published')
            ->with(['brandProfile', 'category'])
            ->latest()
            ->take(6)
            ->get();

        $topTalents = TalentProfile::with(['user', 'socialAccounts', 'portfolios', 'rates'])
            ->latest()
            ->take(6)
            ->get();
        $topInfluencers = $topTalents;

        $stats = [
            'brands' => BrandProfile::count() ?: 120,
            'talents' => TalentProfile::count() ?: 4800,
            'influencers' => TalentProfile::count() ?: 4800,
            'campaigns' => Campaign::count() ?: 350,
            'reach' => '12.5M+',
        ];

        $categoriesList = Category::where('status', 'active')->get();

        return view('welcome', compact('featuredCampaigns', 'topTalents', 'topInfluencers', 'stats', 'categoriesList'));
    }

    public function about()
    {
        $stats = [
            'brands' => BrandProfile::count() ?: 150,
            'talents' => TalentProfile::count() ?: 5000,
            'campaigns' => Campaign::count() ?: 400,
            'satisfaction' => '98.5%',
        ];

        return view('about', compact('stats'));
    }

    public function howItWorks()
    {
        return view('how-it-works');
    }

    public function pricing()
    {
        return view('pricing');
    }

    public function contact()
    {
        return view('contact');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function terms()
    {
        return view('terms');
    }

    public function dataDeletion()
    {
        return view('data-deletion');
    }

    public function campaigns(Request $request)
    {
        $query = Campaign::where('status', 'published')->with(['brandProfile', 'category', 'deliverables', 'usageRight']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('type')) {
            $query->where('campaign_type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('campaign_name', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        $campaigns = $query->latest()->paginate(9);
        $categories = Category::where('status', 'active')->get();

        return view('campaigns.index', compact('campaigns', 'categories'));
    }

    public function campaignShow($slug)
    {
        $campaign = Campaign::where('slug', $slug)
            ->with(['brandProfile', 'category', 'deliverables', 'usageRight', 'questions'])
            ->firstOrFail();

        return view('campaigns.show', compact('campaign'));
    }

    public function influencers(Request $request)
    {
        $query = TalentProfile::with(['user', 'socialAccounts', 'portfolios', 'rates', 'availabilities']);

        // 1. Talent Type Persona Filter (Blueprint Section 3 & 7)
        $talentType = $request->input('talent_type', $request->input('persona'));
        if (! empty($talentType) && $talentType !== 'all') {
            $type = strtolower($talentType);
            if ($type === 'influencer') {
                $query->where(function ($q) {
                    $q->whereJsonContains('primary_categories', 'influencer')
                        ->orWhereJsonContains('primary_categories', 'Social Influencer')
                        ->orWhereJsonContains('primary_categories', 'Fashion & Lifestyle')
                        ->orWhere(function ($sub) {
                            $sub->whereNull('modeling_categories')
                                ->whereNull('event_types')
                                ->whereHas('socialAccounts');
                        });
                });
            } elseif (in_array($type, ['modeling', 'model'])) {
                $query->where(function ($q) {
                    $q->whereNotNull('height_cm')
                        ->orWhereNotNull('modeling_categories')
                        ->orWhereJsonContains('primary_categories', 'modeling')
                        ->orWhereJsonContains('primary_categories', 'Fashion Model');
                });
            } elseif (in_array($type, ['anchor', 'emcee'])) {
                $query->where(function ($q) {
                    $q->whereNotNull('hosting_style')
                        ->orWhereNotNull('event_types')
                        ->orWhere('has_stage_exp', true)
                        ->orWhere('has_tv_radio_exp', true)
                        ->orWhereJsonContains('primary_categories', 'anchor')
                        ->orWhereJsonContains('primary_categories', 'Event Anchor & Emcee');
                });
            } elseif ($type === 'ugc') {
                $query->where(function ($q) {
                    $q->whereJsonContains('primary_categories', 'ugc')
                        ->orWhereJsonContains('primary_categories', 'UGC Creator')
                        ->orWhereHas('rates', function ($rq) {
                            $rq->where('rate_type', 'like', '%ugc%');
                        });
                });
            } else {
                $query->where(function ($q) use ($type) {
                    $q->whereJsonContains('primary_categories', $type)
                        ->orWhere('bio', 'like', '%'.$type.'%');
                });
            }
        }

        // 2. City / Regional Hub Filter
        if ($request->filled('city') && $request->city !== 'all') {
            $query->where('city', 'like', '%'.$request->city.'%');
        }

        // 3. Gender Filter
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        // 4. Verification Level Filter (Level 1 to 5)
        if ($request->filled('verification_level') && $request->verification_level !== 'all') {
            $query->where('verification_level', '>=', (int) $request->verification_level);
        }

        // 5. Availability Status Filter (Blueprint Section 5)
        $availStatus = $request->input('availability', $request->input('status'));
        if (! empty($availStatus) && $availStatus !== 'all') {
            $query->where('availability_status', $availStatus);
        }

        // 6. Price Negotiable Filter
        if ($request->filled('negotiable') && $request->negotiable == '1') {
            $query->where('price_negotiable', true);
        }

        // 7. Modeling Specific Category (e.g. Runway, Bridal, Catalogue)
        if ($request->filled('modeling_category')) {
            $query->whereJsonContains('modeling_categories', $request->modeling_category);
        }

        // 8. Anchor Specific Event Type (e.g. Corporate Events, Award Functions)
        if ($request->filled('event_type')) {
            $query->whereJsonContains('event_types', $request->event_type);
        }

        // 9. Niche / Vertical Filter (Skincare, Tech, Fitness, Food, Gaming, Fashion, Travel, Parenting, Auto, Finance)
        if ($request->filled('niche') && $request->niche !== 'all') {
            $niche = $request->niche;
            $query->where(function ($q) use ($niche) {
                $q->whereJsonContains('primary_categories', $niche)
                    ->orWhereJsonContains('modeling_categories', $niche)
                    ->orWhereJsonContains('event_types', $niche)
                    ->orWhere('bio', 'like', '%'.$niche.'%')
                    ->orWhereHas('portfolios', function ($pq) use ($niche) {
                        $pq->where('title', 'like', '%'.$niche.'%')
                            ->orWhere('category', 'like', '%'.$niche.'%')
                            ->orWhere('description', 'like', '%'.$niche.'%');
                    });
            });
        }

        // 10. Deliverable / Service Format Filter
        if ($request->filled('deliverable') && $request->deliverable !== 'all') {
            $deliverable = strtolower($request->deliverable);
            $query->whereHas('rates', function ($rq) use ($deliverable) {
                $rq->where('rate_type', 'like', '%'.$deliverable.'%')
                    ->orWhere('title', 'like', '%'.$deliverable.'%');
            });
        }

        // 11. Follower Bracket Filter
        $bracket = $request->input('follower_bracket', $request->input('reach'));
        if (! empty($bracket) && $bracket !== 'all') {
            $query->whereHas('socialAccounts', function ($q) use ($bracket) {
                if ($bracket === 'nano') {
                    $q->where('followers', '<', 10000);
                } elseif ($bracket === 'micro') {
                    $q->whereBetween('followers', [10000, 50000]);
                } elseif ($bracket === 'mid') {
                    $q->whereBetween('followers', [50000, 250000]);
                } elseif ($bracket === 'macro') {
                    $q->whereBetween('followers', [250000, 1000000]);
                } elseif ($bracket === 'celebrity') {
                    $q->where('followers', '>=', 1000000);
                }
            });
        }

        // 12. Minimum Engagement Rate Filter
        if ($request->filled('min_engagement')) {
            $minEng = (float) $request->min_engagement;
            $query->whereHas('socialAccounts', function ($sq) use ($minEng) {
                $sq->where('engagement_rate', '>=', $minEng);
            });
        }

        // 13. Keyword Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('display_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('username', 'like', '%'.$searchTerm.'%')
                    ->orWhere('bio', 'like', '%'.$searchTerm.'%')
                    ->orWhere('city', 'like', '%'.$searchTerm.'%')
                    ->orWhere('hosting_style', 'like', '%'.$searchTerm.'%')
                    ->orWhere('voice_style', 'like', '%'.$searchTerm.'%');
            });
        }

        // 14. Sorting
        $sort = $request->get('sort', 'recent');
        if ($sort === 'rating') {
            $query->orderByDesc('rating_avg');
        } elseif ($sort === 'verification') {
            $query->orderByDesc('verification_level');
        } else {
            $query->latest();
        }

        $talents = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('influencers.index', compact('talents', 'categories'));
    }

    public function influencerShow($username)
    {
        $talent = TalentProfile::where('username', $username)
            ->with(['user', 'socialAccounts', 'portfolios', 'rates', 'availabilities', 'bookings.reviews'])
            ->firstOrFail();

        $brandCampaigns = collect();
        if (auth()->check() && auth()->user()->isBrand() && auth()->user()->brandProfile) {
            $brandCampaigns = auth()->user()->brandProfile->campaigns()->whereIn('status', ['published', 'draft', 'in_progress'])->get();
        }

        return view('influencers.show', compact('talent', 'brandCampaigns'));
    }

    public function talentCompare(Request $request)
    {
        $ids = explode(',', $request->query('ids', ''));
        $talents = TalentProfile::whereIn('id', $ids)
            ->with(['user', 'socialAccounts', 'portfolios', 'rates'])
            ->get();

        return response()->json([
            'talents' => $talents->map(function ($t) {
                $topSocial = $t->socialAccounts->sortByDesc('followers')->first();
                $avgER = $t->socialAccounts->avg('engagement_rate') ?: 4.2;
                $totFollowers = $t->socialAccounts->sum('followers');
                $startingRate = $t->rates->min('rate_amount') ?: 15000;

                return [
                    'id' => $t->id,
                    'name' => $t->display_name ?: $t->user->name,
                    'username' => $t->username,
                    'avatar' => $t->profile_image ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&h=200&fit=crop',
                    'city' => $t->city ?: 'Nashik / Maharashtra',
                    'verification_level' => $t->verification_level ?: 1,
                    'rating' => (float) ($t->rating_avg ?: 5.0),
                    'total_followers' => $totFollowers,
                    'engagement_rate' => number_format($avgER, 1).'%',
                    'starting_rate' => '₹'.number_format($startingRate),
                    'top_platform' => $topSocial ? $topSocial->platform : 'Instagram',
                    'categories' => $t->primary_categories ?: ['Creator', 'Influencer'],
                    'profile_url' => route('influencers.public.show', $t->username),
                ];
            }),
        ]);
    }

    public function fontPairs()
    {
        return view('font-pairs');
    }

    public function homeLight()
    {
        $featuredCampaigns = Campaign::where('status', 'published')
            ->with(['brandProfile', 'category'])
            ->latest()
            ->take(6)
            ->get();

        $topTalents = TalentProfile::with(['user', 'socialAccounts', 'portfolios', 'rates'])
            ->latest()
            ->take(6)
            ->get();
        $topInfluencers = $topTalents;

        $stats = [
            'brands' => BrandProfile::count() ?: 120,
            'talents' => TalentProfile::count() ?: 4800,
            'influencers' => TalentProfile::count() ?: 4800,
            'campaigns' => Campaign::count() ?: 350,
            'reach' => '12.5M+',
        ];

        $categoriesList = Category::where('status', 'active')->get();

        return view('home-light', compact('featuredCampaigns', 'topTalents', 'topInfluencers', 'stats', 'categoriesList'));
    }

    public function homeDark2()
    {
        return view('home-dark2');
    }

    public function homeLight2()
    {
        return view('home-light2');
    }

    public function homeLight3()
    {
        return view('home-light3');
    }

    public function homeDark()
    {
        $featuredCampaigns = Campaign::where('status', 'published')
            ->with(['brandProfile', 'category'])
            ->latest()
            ->take(6)
            ->get();

        $topTalents = TalentProfile::with(['user', 'socialAccounts', 'portfolios', 'rates'])
            ->latest()
            ->take(6)
            ->get();
        $topInfluencers = $topTalents;

        $stats = [
            'brands' => BrandProfile::count() ?: 120,
            'talents' => TalentProfile::count() ?: 4800,
            'influencers' => TalentProfile::count() ?: 4800,
            'campaigns' => Campaign::count() ?: 350,
            'reach' => '12.5M+',
        ];

        $categoriesList = Category::where('status', 'active')->get();

        return view('home-dark', compact('featuredCampaigns', 'topTalents', 'topInfluencers', 'stats', 'categoriesList'));
    }

    public function homeDark3()
    {
        $featuredCampaigns = Campaign::where('status', 'published')
            ->with(['brandProfile', 'category'])
            ->latest()
            ->take(6)
            ->get();

        $topTalents = TalentProfile::with(['user', 'socialAccounts', 'portfolios', 'rates'])
            ->latest()
            ->take(6)
            ->get();
        $topInfluencers = $topTalents;

        $stats = [
            'brands' => BrandProfile::count() ?: 120,
            'talents' => TalentProfile::count() ?: 4800,
            'influencers' => TalentProfile::count() ?: 4800,
            'campaigns' => Campaign::count() ?: 350,
            'reach' => '12.5M+',
        ];

        $categoriesList = Category::where('status', 'active')->get();

        return view('home-dark3', compact('featuredCampaigns', 'topTalents', 'topInfluencers', 'stats', 'categoriesList'));
    }
}
