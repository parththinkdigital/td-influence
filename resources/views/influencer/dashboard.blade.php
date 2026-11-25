@extends('layouts.influencer')

@section('title', 'Talent Dashboard | Creator Studio')

@section('content')
    @php
        $completionScore = 0;
        if (!empty($profile->display_name)) $completionScore += 15;
        if (!empty($profile->bio)) $completionScore += 20;
        if (!empty($profile->city)) $completionScore += 15;
        if (!empty($profile->primary_categories) && count($profile->primary_categories) > 0) $completionScore += 20;
        if ($profile->socialAccounts->count() > 0) $completionScore += 15;
        if ($profile->portfolios->count() > 0) $completionScore += 15;

        $totalFollowers = $profile->socialAccounts->sum('followers');
        $totalViews30d = $profile->socialAccounts->sum('views_30d');
    @endphp

    <div class="space-y-8" x-data="{ copied: false, qrModal: false }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="w-2 h-2 rounded-full bg-pink-500"></span>
                    <span>Creator Command Center</span>
                </div>
                <div class="flex items-center space-x-2.5">
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 font-display">
                        {{ $profile->display_name ?: auth()->user()->name }}
                    </h1>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-black rounded-full shadow-2xs">
                        <i class="fa-solid fa-award text-amber-500 text-[10px]"></i>
                        <span>Level {{ $profile->verification_level ?: 1 }} Verified</span>
                    </span>
                </div>
                <p class="text-slate-500 text-sm mt-0.5">Pitch to verified brands, upload licensed deliverables, and track escrow payouts.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <button type="button" 
                        @click="
                            navigator.clipboard.writeText('{{ route('influencers.public.show', $profile->username ?: 'me') }}');
                            copied = true;
                            setTimeout(() => copied = false, 2500);
                        "
                        class="inline-flex items-center justify-center rounded-xl text-xs font-bold transition border border-slate-200 bg-white hover:bg-slate-50 text-slate-800 h-10 px-4 shadow-2xs">
                    <i class="fa-regular fa-copy mr-1.5 text-slate-400 text-xs"></i>
                    <span x-text="copied ? 'Copied Comp Card Link!' : 'Copy Comp Card Link'"></span>
                </button>
                <a href="{{ route('influencer.campaigns') }}" class="inline-flex items-center justify-center rounded-xl text-xs font-bold bg-pink-600 hover:bg-pink-700 text-white h-10 px-5 shadow-xs transition active:scale-95">
                    <i class="fa-solid fa-compass mr-1.5 text-xs"></i>
                    <span>Explore Brand Briefs</span>
                </a>
            </div>
        </div>

        <!-- 4-Card Top Metric Grid -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Pitches -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between pb-3">
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Total Pitches</span>
                    <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                </div>
                <div class="text-2xl font-black tabular-nums text-pink-600 font-display">{{ $stats['applications_count'] }}</div>
                <p class="text-[11px] text-slate-500 mt-1 flex items-center justify-between">
                    <span class="text-emerald-600 font-bold">{{ $stats['shortlisted_count'] }} Shortlisted</span>
                    <a href="{{ route('influencer.applications') }}" class="text-pink-600 font-bold hover:underline">View proposals &rarr;</a>
                </p>
            </div>

            <!-- Active Production Orders -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between pb-3">
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Active Orders</span>
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-video"></i>
                    </div>
                </div>
                <div class="text-2xl font-black tabular-nums text-slate-900 font-display">{{ $stats['active_bookings'] }}</div>
                <p class="text-[11px] text-slate-500 mt-1 flex items-center justify-between">
                    <span>Shoot & Deliver</span>
                    <a href="{{ route('influencer.bookings') }}" class="text-indigo-600 font-bold hover:underline">Upload proof &rarr;</a>
                </p>
            </div>

            <!-- Completed Jobs -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between pb-3">
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Completed Jobs</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <div class="text-2xl font-black tabular-nums text-emerald-600 font-display">{{ $stats['completed_jobs'] }}</div>
                <p class="text-[11px] text-slate-500 mt-1 flex items-center justify-between">
                    <span>100% Escrow Settled</span>
                    <a href="{{ route('influencer.invoices') }}" class="text-emerald-600 font-bold hover:underline">Receipts &rarr;</a>
                </p>
            </div>

            <!-- Social Audience Footprint -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between pb-3">
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Audience Reach</span>
                    <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </div>
                </div>
                <div class="text-2xl font-black tabular-nums text-slate-900 font-display">{{ $totalFollowers > 0 ? number_format($totalFollowers) : '0' }}</div>
                <p class="text-[11px] text-slate-500 mt-1 flex items-center justify-between">
                    <span class="text-pink-600 font-bold">{{ $profile->socialAccounts->count() }} Linked Channels</span>
                    <a href="{{ route('influencer.social') }}" class="text-purple-600 font-bold hover:underline">Analytics &rarr;</a>
                </p>
            </div>
        </div>

        <!-- Profile Strength Banner if Incomplete -->
        @if($completionScore < 100)
            <div class="rounded-2xl border border-pink-200/80 bg-pink-50/40 p-5 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center space-x-2">
                        <span class="font-black text-slate-900 text-sm font-display">Media Kit Profile Completeness</span>
                        <span class="px-2.5 py-0.5 bg-pink-100 text-pink-700 text-[10px] font-black rounded-full">{{ $completionScore }}%</span>
                    </div>
                    <p class="text-xs text-slate-600">Complete missing profile sections to unlock Level 3 verified status and top-tier placement for brand discovery.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if(empty($profile->bio))
                        <a href="{{ route('influencer.profile') }}" class="px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 rounded-xl text-xs font-bold transition shadow-2xs">+ Bio</a>
                    @endif
                    @if($profile->socialAccounts->count() === 0)
                        <a href="{{ route('influencer.social') }}" class="px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 rounded-xl text-xs font-bold transition shadow-2xs">+ Social Handles</a>
                    @endif
                    @if($profile->portfolios->count() === 0)
                        <a href="{{ route('influencer.portfolio') }}" class="px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 rounded-xl text-xs font-bold transition shadow-2xs">+ Portfolio</a>
                    @endif
                </div>
            </div>
        @endif

        <!-- Main Grid: Recommended Briefs (Left) + Recent Pitches (Right) -->
        <div class="grid gap-6 lg:grid-cols-7">
            <!-- Left: Recommended Campaigns (4 Cols) -->
            <div class="rounded-3xl border border-slate-200/80 bg-white text-slate-900 shadow-xs lg:col-span-4 flex flex-col justify-between overflow-hidden">
                <div>
                    <div class="p-6 flex flex-row items-center justify-between border-b border-slate-100 bg-slate-50/50">
                        <div>
                            <h3 class="font-black text-base tracking-tight font-display">Recommended Casting Calls</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Campaign briefs matching your niche and creative skills.</p>
                        </div>
                        <a href="{{ route('influencer.campaigns') }}" class="inline-flex items-center justify-center rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 transition hover:bg-slate-100 px-3.5 py-2 border border-slate-200 bg-white shadow-2xs">
                            <span>Browse All</span>
                            <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                        </a>
                    </div>

                    <div class="p-6 space-y-4">
                        @forelse($recommendedCampaigns as $camp)
                            <div class="p-4 rounded-2xl border border-slate-200/80 hover:border-slate-300 transition space-y-2 bg-slate-50/40">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-lg bg-pink-50 text-pink-700 text-[10px] font-extrabold uppercase tracking-wider">
                                        {{ $camp->category->name ?? 'General' }}
                                    </span>
                                    <span class="text-xs font-black text-slate-900 tabular-nums">
                                        ₹{{ number_format($camp->budget_min ?: $camp->budget) }} - ₹{{ number_format($camp->budget_max ?: $camp->budget) }}
                                    </span>
                                </div>
                                <h4 class="font-bold text-slate-900 text-sm line-clamp-1">
                                    <a href="{{ route('influencer.campaigns.show', $camp->id) }}" class="hover:text-pink-600 transition">
                                        {{ $camp->title ?: $camp->name }}
                                    </a>
                                </h4>
                                <div class="flex items-center justify-between text-xs text-slate-500 pt-1 border-t border-slate-200/60">
                                    <span class="font-bold text-slate-700">
                                        {{ $camp->brandProfile->company_name ?? 'Verified Brand' }}
                                    </span>
                                    <a href="{{ route('influencer.campaigns.show', $camp->id) }}" class="font-bold text-pink-600 hover:underline inline-flex items-center gap-1">
                                        <span>View Brief & Apply</span>
                                        <i class="fa-solid fa-arrow-right text-[9px]"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-400">
                                <p class="text-xs">No open campaigns currently available.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right: Recent Applications Tracking (3 Cols) -->
            <div class="rounded-3xl border border-slate-200/80 bg-white text-slate-900 shadow-xs lg:col-span-3 flex flex-col justify-between overflow-hidden">
                <div>
                    <div class="p-6 flex flex-row items-center justify-between border-b border-slate-100 bg-slate-50/50">
                        <div>
                            <h3 class="font-black text-base tracking-tight font-display">My Recent Proposals</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Live status of your submitted pitches.</p>
                        </div>
                        <a href="{{ route('influencer.applications') }}" class="text-xs font-bold text-pink-600 hover:underline">
                            All Proposals &rarr;
                        </a>
                    </div>

                    <div class="p-6 space-y-4">
                        @forelse($recentApplications as $app)
                            <div class="p-4 rounded-2xl border border-slate-200/80 space-y-2 bg-slate-50/40">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-slate-900 text-xs line-clamp-1">
                                        {{ $app->campaign->title ?: ($app->campaign->name ?: 'Campaign') }}
                                    </span>
                                    <span class="font-black text-xs text-slate-900 tabular-nums">
                                        ₹{{ number_format($app->quoted_price) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-200/60">
                                    <span class="text-[10px] text-slate-400">{{ $app->created_at->diffForHumans() }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $app->status === 'selected' ? 'bg-emerald-50 text-emerald-700' : ($app->status === 'shortlisted' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-700') }}">
                                        {{ $app->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-400">
                                <p class="text-xs">You haven't submitted any pitches yet.</p>
                                <a href="{{ route('influencer.campaigns') }}" class="inline-block mt-3 px-4 py-2 bg-pink-600 text-white rounded-xl text-xs font-bold">
                                    Find Campaigns
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between text-xs">
                    <span class="text-slate-500">Need to update your rates?</span>
                    <a href="{{ route('influencer.rates') }}" class="font-bold text-pink-600 hover:underline">
                        Manage Gigs &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
