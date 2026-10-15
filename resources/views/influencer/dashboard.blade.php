@extends('layouts.influencer')

@section('title', 'Talent Dashboard | Talent Marketplace')

@section('content')
    @php
        // Profile completion calculation
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

    <div class="space-y-6 sm:space-y-8" x-data="{ copied: false }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2.5">
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-display">
                        {{ $profile->display_name ?: auth()->user()->name }} Studio
                    </h1>
                    <x-verification-badge :level="$profile->verification_level ?: 1" size="xs" />
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
                        class="inline-flex items-center justify-center rounded-lg text-xs font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 border border-slate-200 bg-white hover:bg-slate-100 text-slate-800 h-9 px-3.5 shadow-2xs">
                    <svg class="w-3.5 h-3.5 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                    <span x-text="copied ? 'Copied Media Kit Link' : 'Share Media Kit'"></span>
                </button>
                <a href="{{ route('influencer.campaigns') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-pink-600 text-white hover:bg-pink-700 h-9 px-4 shadow-xs">
                    Explore Brand Briefs &rarr;
                </a>
            </div>
        </div>

        <!-- shadcn dashboard-01 4-Card Top Metric Grid -->
        <div class="grid gap-4 md:grid-cols-2 md:gap-6 lg:grid-cols-4">
            <!-- Total Pitches / Proposals -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs hover:border-slate-300 transition">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="tracking-tight text-xs uppercase font-semibold text-slate-500">Total Pitches</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-slate-400">
                        <rect width="20" height="14" x="2" y="5" rx="2" />
                        <line x1="2" x2="22" y1="10" y2="10" />
                    </svg>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold tabular-nums text-pink-600">{{ $stats['applications_count'] }}</div>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-emerald-600 font-semibold">{{ $stats['shortlisted_count'] }} Shortlisted</span>
                    </p>
                </div>
            </div>

            <!-- Active Production Contracts -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs hover:border-slate-300 transition">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="tracking-tight text-xs uppercase font-semibold text-slate-500">Active Orders</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-slate-400">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold tabular-nums text-indigo-600">{{ $stats['active_bookings'] }}</div>
                    <p class="text-xs text-slate-500 mt-1">
                        <a href="{{ route('influencer.bookings') }}" class="text-indigo-600 font-semibold hover:underline">View Deliverables &rarr;</a>
                    </p>
                </div>
            </div>

            <!-- Completed Jobs & Escrow -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs hover:border-slate-300 transition">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="tracking-tight text-xs uppercase font-semibold text-slate-500">Completed Jobs</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-slate-400">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                    </svg>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold tabular-nums text-emerald-600">{{ $stats['completed_jobs'] }}</div>
                    <p class="text-xs text-slate-500 mt-1">100% Escrow Settled</p>
                </div>
            </div>

            <!-- Social Audience Reach -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs hover:border-slate-300 transition">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="tracking-tight text-xs uppercase font-semibold text-slate-500">Social Reach</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-slate-400">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="2" x2="22" y1="12" y2="12" />
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                    </svg>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold tabular-nums">{{ $totalFollowers > 0 ? number_format($totalFollowers) : '0' }}</div>
                    <p class="text-xs text-slate-500 mt-1">
                        <a href="{{ route('influencer.social') }}" class="text-pink-600 font-semibold hover:underline">{{ $profile->socialAccounts->count() }} Linked Channels &rarr;</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Profile Strength Banner if Incomplete -->
        @if($completionScore < 100)
            <div class="rounded-xl border border-pink-200 bg-pink-50/30 p-5 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center space-x-2">
                        <span class="font-bold text-slate-900 text-sm">Media Kit Profile Completeness</span>
                        <span class="px-2 py-0.5 bg-pink-100 text-pink-700 text-[10px] font-bold rounded-full">{{ $completionScore }}%</span>
                    </div>
                    <p class="text-xs text-slate-500">Complete missing details to gain Level 3 verification and high-ranking visibility for Nashik & Maharashtra brands.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if(empty($profile->bio))
                        <a href="{{ route('influencer.profile') }}" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-xs font-semibold transition">+ Bio</a>
                    @endif
                    @if($profile->socialAccounts->count() === 0)
                        <a href="{{ route('influencer.social') }}" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-xs font-semibold transition">+ Social Handles</a>
                    @endif
                    @if($profile->portfolios->count() === 0)
                        <a href="{{ route('influencer.portfolio') }}" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-xs font-semibold transition">+ Portfolio</a>
                    @endif
                </div>
            </div>
        @endif

        <!-- shadcn dashboard-01 Main Grid (Open Campaigns Table on Left + Quick Studio Hub on Right) -->
        <div class="grid gap-4 md:gap-6 lg:grid-cols-7">
            <!-- Left Card: Curated Brand Opportunities (4 Cols) -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs lg:col-span-4 flex flex-col justify-between">
                <div>
                    <div class="p-6 flex flex-row items-center justify-between border-b border-slate-100">
                        <div>
                            <h3 class="font-semibold text-base tracking-tight">Curated Brand Opportunities</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Live briefs matching your category and audience demographic.</p>
                        </div>
                        <a href="{{ route('influencer.campaigns') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition hover:bg-slate-100 px-3 py-1.5 border border-slate-200">
                            View All &rarr;
                        </a>
                    </div>

                    <div class="p-6 space-y-4">
                        @forelse($recommendedCampaigns as $camp)
                            <div class="p-4 rounded-xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50/50 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="space-y-1 min-w-0">
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-0.5 bg-pink-50 text-pink-700 text-[10px] font-bold rounded-md border border-pink-200">
                                            {{ $camp->category->name ?? 'General' }}
                                        </span>
                                        <span class="text-xs text-slate-400">By {{ $camp->brandProfile->company_name ?? 'Brand Partner' }}</span>
                                    </div>
                                    <h4 class="font-semibold text-slate-900 text-sm line-clamp-1">{{ $camp->title }}</h4>
                                    <p class="text-xs text-slate-500 line-clamp-1">{{ $camp->description }}</p>
                                </div>
                                <div class="flex items-center sm:flex-col sm:items-end justify-between sm:justify-center gap-2 flex-shrink-0">
                                    <span class="text-sm font-bold text-slate-900 tabular-nums">
                                        ₹{{ number_format($camp->budget_max ?: $camp->budget_min) }}
                                    </span>
                                    <a href="{{ route('influencer.campaigns.show', $camp->id) }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold bg-slate-900 text-white hover:bg-black px-3 py-1.5 transition shadow-2xs">
                                        Pitch &rarr;
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="py-10 text-center text-slate-400 text-xs inline-flex items-center justify-center gap-1.5 w-full">
                                <i data-lucide="megaphone" class="w-4 h-4"></i>
                                <span>No active brand campaigns available right now. Check back soon.</span>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="p-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Targeted briefs for Nashik, Pune & Mumbai campaigns</span>
                    <a href="{{ route('influencer.campaigns') }}" class="font-semibold text-pink-600 hover:underline">Explore All Briefs &rarr;</a>
                </div>
            </div>

            <!-- Right Card: Studio Management Shortcuts (3 Cols) -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs lg:col-span-3 flex flex-col justify-between">
                <div>
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="font-semibold text-base tracking-tight">Creator Studio Hub</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Quick access to manage social channels, deliverables & rate cards.</p>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Social Channels Item -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-9 h-9 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center font-bold text-sm">
                                    <i data-lucide="smartphone" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold leading-none text-slate-900">Connected Channels</p>
                                    <p class="text-xs text-slate-500 mt-1">Instagram & YouTube Live Sync</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('influencer.social') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold bg-slate-900 text-white hover:bg-slate-800 px-3 py-1.5 transition">
                                    Manage
                                </a>
                            </div>
                        </div>

                        <!-- Portfolios Item -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-9 h-9 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-sm">
                                    <i data-lucide="film" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold leading-none text-slate-900">Portfolio & Media</p>
                                    <p class="text-xs text-slate-500 mt-1">Photos, Reels & UGC showcase</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('influencer.portfolio') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-800 px-3 py-1.5 transition">
                                    Upload
                                </a>
                            </div>
                        </div>

                        <!-- Rates & Deliverable Packages Item -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                                    <i data-lucide="tag" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold leading-none text-slate-900">Deliverables & Rate Cards</p>
                                    <p class="text-xs text-slate-500 mt-1">Gigs, packages & sponsored rates</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('influencer.rates') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-800 px-3 py-1.5 transition">
                                    Edit Rates
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-100 bg-slate-50/50 rounded-b-xl">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">Security & Trust</span>
                        <span class="inline-flex items-center gap-1.5 font-semibold text-emerald-600">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Escrow Guarantee Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
