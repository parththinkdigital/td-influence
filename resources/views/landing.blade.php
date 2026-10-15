@extends('layouts.app')

@section('title', 'Talent Marketplace — Curated Casting & Creator Network for Brands, Models & Influencers')

@section('content')
    <!-- HERO SECTION (AWWWARDS-INSPIRED EDITORIAL LIGHT MODE) -->
    <section class="relative pt-12 pb-20 lg:pt-20 lg:pb-28 bg-white border-b border-slate-200 overflow-hidden" x-data="{ activeTab: 'all' }">
        <!-- Subtle architectural grid backdrop -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#00000008_1px,transparent_1px),linear-gradient(to_bottom,#00000008_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] pointer-events-none -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-10 items-center">
                
                <!-- Left: Editorial Headline & Search -->
                <div class="lg:col-span-7 space-y-7 text-left">
                    <div class="inline-flex items-center space-x-2.5 px-3.5 py-1.5 rounded-full bg-slate-100 border border-slate-200/80 text-xs font-bold text-slate-800 tracking-wide">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="font-display uppercase text-[11px] tracking-wider">Verified Talent & Casting Network</span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black font-display tracking-tight text-slate-950 leading-[1.03]">
                        Cast verified talent. <br class="hidden sm:inline" />
                        <span class="text-brand-600">Scale brand impact.</span>
                    </h1>

                    <p class="text-slate-600 text-base sm:text-lg max-w-xl leading-relaxed font-normal">
                        Direct access to elite fashion models, authenticated Instagram & YouTube influencers, event emcees, and UGC video creators with real-time API audience metrics and escrow security.
                    </p>

                    <!-- Interactive Search Console -->
                    <div class="pt-2">
                        <form action="{{ route('influencers.public') }}" method="GET" class="bg-white border-2 border-slate-200 p-2 sm:p-2.5 rounded-2xl shadow-sm hover:border-brand-300 focus-within:border-brand-600 focus-within:ring-4 focus-within:ring-brand-500/10 flex flex-col sm:flex-row items-center gap-2 transition duration-200">
                            <div class="flex-grow flex items-center px-3 w-full">
                                <i data-lucide="search" class="w-4 h-4 text-slate-400 mr-2.5"></i>
                                <input type="text" name="search" placeholder="Search by niche, Nashik, College Road, or creator name..." class="w-full text-sm font-medium text-slate-900 outline-none placeholder-slate-400 bg-transparent">
                            </div>
                            <button type="submit" class="w-full sm:w-auto px-7 py-3.5 rounded-xl font-bold bg-brand-600 hover:bg-brand-700 text-white transition text-sm whitespace-nowrap shadow-sm hover:shadow">
                                Explore Talent &rarr;
                            </button>
                        </form>
                    </div>

                    <!-- Category Pills -->
                    <div class="flex flex-wrap items-center gap-2 pt-1 text-xs font-semibold text-slate-700">
                        <span class="text-slate-400 font-medium">Browse:</span>
                        <a href="{{ route('influencers.public', ['talent_type' => 'influencer']) }}" class="px-3.5 py-1.5 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-700 hover:border-brand-200 border border-slate-200 text-slate-700 transition font-medium inline-flex items-center gap-1.5">
                            <i data-lucide="smartphone" class="w-3.5 h-3.5"></i>
                            <span>Influencers</span>
                        </a>
                        <a href="{{ route('influencers.public', ['talent_type' => 'modeling']) }}" class="px-3.5 py-1.5 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-700 hover:border-brand-200 border border-slate-200 text-slate-700 transition font-medium inline-flex items-center gap-1.5">
                            <i data-lucide="camera" class="w-3.5 h-3.5"></i>
                            <span>Fashion Models</span>
                        </a>
                        <a href="{{ route('influencers.public', ['talent_type' => 'anchor']) }}" class="px-3.5 py-1.5 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-700 hover:border-brand-200 border border-slate-200 text-slate-700 transition font-medium inline-flex items-center gap-1.5">
                            <i data-lucide="mic" class="w-3.5 h-3.5"></i>
                            <span>Event Emcees</span>
                        </a>
                        <a href="{{ route('influencers.public', ['talent_type' => 'ugc']) }}" class="px-3.5 py-1.5 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-700 hover:border-brand-200 border border-slate-200 text-slate-700 transition font-medium inline-flex items-center gap-1.5">
                            <i data-lucide="video" class="w-3.5 h-3.5"></i>
                            <span>UGC Creators</span>
                        </a>
                    </div>
                </div>

                <!-- Right: High-End Live Interactive Spotlight Card -->
                <div class="lg:col-span-5">
                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 space-y-5 relative">
                        <!-- Top Header -->
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                                <span class="text-xs font-bold text-slate-900 uppercase tracking-wider font-display">Live Talent Spotlight</span>
                            </div>
                            <span class="text-[11px] font-bold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 inline-flex items-center gap-1">
                                <i data-lucide="check" class="w-3 h-3"></i> Live API Sync
                            </span>
                        </div>

                        <!-- Featured Talent Profile Card -->
                        <div class="bg-slate-50 border border-slate-200/80 p-4 sm:p-5 rounded-2xl flex items-center justify-between shadow-xs">
                            <div class="flex items-center space-x-3.5">
                                <div class="relative flex-shrink-0">
                                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&h=200&fit=crop" class="w-14 h-14 rounded-2xl object-cover border-2 border-brand-500 shadow-xs" alt="Arya Varma">
                                    <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white flex items-center justify-center text-white"><i data-lucide="check" class="w-2.5 h-2.5"></i></span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-bold text-slate-900 flex items-center gap-1.5 truncate">
                                        <span>Arya Varma</span>
                                        <span class="text-[10px] text-brand-700 bg-brand-50 px-1.5 py-0.5 rounded border border-brand-200 font-bold">L5 Verified</span>
                                    </h4>
                                    <p class="text-xs text-slate-500 font-medium truncate">Fashion Model &bull; Mumbai, India</p>
                                    <div class="flex items-center space-x-2 mt-1 text-[11px] font-bold text-slate-700">
                                        <span class="inline-flex items-center gap-1"><i data-lucide="camera" class="w-3 h-3 text-pink-600"></i> 185K</span>
                                        <span>&bull;</span>
                                        <span class="inline-flex items-center gap-1"><i data-lucide="play" class="w-3 h-3 text-red-600"></i> 92K</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">Starting</span>
                                <span class="text-sm font-black text-slate-900 font-display">₹25,000</span>
                            </div>
                        </div>

                        <!-- Live Escrow Milestone Pipeline -->
                        <div class="bg-slate-950 text-white p-5 rounded-2xl space-y-3.5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-300 font-semibold flex items-center gap-1.5">
                                    <i data-lucide="lock" class="w-3.5 h-3.5 text-slate-300"></i>
                                    <span>Milestone Escrow Protection</span>
                                </span>
                                <span class="text-emerald-400 font-bold text-[11px] bg-emerald-950/80 px-2 py-0.5 rounded border border-emerald-800">
                                    100% Protected
                                </span>
                            </div>

                            <!-- Progress Bar -->
                            <div class="space-y-1.5">
                                <div class="flex justify-between text-[11px] text-slate-400 font-medium">
                                    <span class="text-emerald-400 font-bold">1. Brief Deposit</span>
                                    <span class="text-white font-bold">2. Creator Shoot</span>
                                    <span>3. Instant Payout</span>
                                </div>
                                <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden flex">
                                    <div class="bg-emerald-500 h-full w-2/3 rounded-full"></div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between border-t border-slate-800/80 pt-3 text-xs">
                                <div>
                                    <span class="block text-[10px] text-slate-400">Payment Release</span>
                                    <span class="text-xs font-bold text-white">Direct Bank / UPI</span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[10px] text-slate-400">Dispute Rate</span>
                                    <span class="text-xs font-bold text-emerald-400">&lt; 0.2%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <a href="{{ route('influencers.public') }}" class="py-3 px-4 text-center rounded-xl font-bold bg-brand-600 hover:bg-brand-700 text-white transition text-xs shadow-sm">
                                Find Creators &rarr;
                            </a>
                            <a href="{{ route('campaigns.public') }}" class="py-3 px-4 text-center rounded-xl font-bold bg-slate-50 hover:bg-slate-100 text-slate-800 border border-slate-200 transition text-xs">
                                View Open Briefs
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- KINETIC BRAND TRUST TICKER (AWARDS EDITORIAL MARQUEE) -->
    <section class="py-8 border-b border-slate-200 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
            <p class="text-center text-xs font-bold text-slate-600 uppercase tracking-widest font-display">
                Trusted by leading brands, creative agencies, and over 4,800+ verified creators
            </p>
        </div>

        <!-- Marquee Track -->
        <div class="relative flex overflow-x-hidden group">
            <div class="py-3 animate-marquee whitespace-nowrap flex items-center space-x-12 sm:space-x-16 text-slate-400 font-display font-black text-xl sm:text-2xl tracking-tight uppercase">
                <span class="hover:text-slate-900 transition">ZARA</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">VOGUE</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">MYNTRA</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">SEPHORA</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">NIKE</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">NYKAA</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">PUMA</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">URBANIC</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">L'ORÉAL</span>
                <span class="text-slate-300">&bull;</span>
            </div>

            <div class="absolute top-0 py-3 animate-marquee2 whitespace-nowrap flex items-center space-x-12 sm:space-x-16 text-slate-400 font-display font-black text-xl sm:text-2xl tracking-tight uppercase">
                <span class="hover:text-slate-900 transition">ZARA</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">VOGUE</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">MYNTRA</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">SEPHORA</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">NIKE</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">NYKAA</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">PUMA</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">URBANIC</span>
                <span class="text-slate-300">&bull;</span>
                <span class="hover:text-slate-900 transition">L'ORÉAL</span>
                <span class="text-slate-300">&bull;</span>
            </div>
        </div>
    </section>

    <!-- METRICS STRIP -->
    <section class="py-12 border-b border-slate-200 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="space-y-1">
                    <span class="text-3xl lg:text-4xl font-black font-display text-slate-900 tracking-tight">
                        {{ $stats['brands'] ?? 150 }}+
                    </span>
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Active Hiring Brands</span>
                </div>
                <div class="space-y-1">
                    <span class="text-3xl lg:text-4xl font-black font-display text-brand-600 tracking-tight">
                        {{ $stats['talents'] ?? 4800 }}+
                    </span>
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Verified Creators</span>
                </div>
                <div class="space-y-1">
                    <span class="text-3xl lg:text-4xl font-black font-display text-slate-900 tracking-tight">
                        {{ $stats['campaigns'] ?? 350 }}+
                    </span>
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Campaigns Completed</span>
                </div>
                <div class="space-y-1">
                    <span class="text-3xl lg:text-4xl font-black font-display text-emerald-600 tracking-tight">
                        {{ $stats['reach'] ?? '12.5M+' }}
                    </span>
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Authenticated Reach</span>
                </div>
            </div>
        </div>
    </section>

    <!-- CURATED TALENT ROSTER -->
    <section class="py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div class="space-y-2">
                    <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block font-display">Talent Directory</span>
                    <h2 class="text-3xl sm:text-4xl font-black font-display text-slate-900 tracking-tight">
                        Featured Verified Creators
                    </h2>
                    <p class="text-slate-500 text-sm max-w-xl">
                        Discover top models, influencers, event emcees, and UGC video creators with verified audience reach.
                    </p>
                </div>
                <a href="{{ route('influencers.public') }}" class="text-sm font-bold text-brand-600 hover:text-brand-700 transition flex items-center space-x-1.5 self-start md:self-auto group">
                    <span>View all creators</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>
            </div>

            <!-- Creator Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($topTalents as $talent)
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-md hover:border-brand-300 transition duration-200 flex flex-col justify-between space-y-6 group">
                        <div class="space-y-4">
                            <!-- Avatar & Name -->
                            <div class="flex items-center space-x-4">
                                <img src="{{ $talent->profile_image ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&h=200&fit=crop' }}" alt="{{ $talent->display_name }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-slate-100 group-hover:border-brand-500 transition shadow-xs">
                                <div class="min-w-0">
                                    <h3 class="font-bold text-slate-900 text-base truncate group-hover:text-brand-600 transition font-display">
                                        {{ $talent->display_name ?: $talent->user->name }}
                                    </h3>
                                    <span class="text-xs text-brand-600 font-semibold block truncate">@ {{ $talent->username }}</span>
                                    <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-brand-50 text-brand-700 border border-brand-200">
                                        Level {{ $talent->verification_level ?: 1 }} Verified
                                    </span>
                                </div>
                            </div>

                            <p class="text-slate-600 text-xs line-clamp-2 leading-relaxed">
                                {{ $talent->bio ?: 'Professional creative talent available for brand campaigns, commercial shoots, and event hosting.' }}
                            </p>

                            <!-- Social Accounts Badges -->
                            @if($talent->socialAccounts->count() > 0)
                                <div class="bg-slate-50 border border-slate-100 p-3 rounded-2xl flex items-center justify-between text-xs font-bold text-slate-700">
                                    <div class="flex items-center space-x-3">
                                        @foreach($talent->socialAccounts->take(2) as $acc)
                                            @php
                                                $isYT = strtolower($acc->platform) === 'youtube';
                                                $isIG = strtolower($acc->platform) === 'instagram';
                                            @endphp
                                            <span class="flex items-center space-x-1.5">
                                                <span class="w-5 h-5 rounded-lg flex items-center justify-center text-[10px]
                                                    @if($isIG) bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 text-white shadow-2xs
                                                    @elseif($isYT) bg-gradient-to-tr from-red-600 via-rose-600 to-red-700 text-white shadow-2xs
                                                    @else bg-blue-50 text-blue-600 @endif">
                                                    @if($isIG) <i data-lucide="instagram" class="w-3 h-3 text-white"></i>
                                                    @elseif($isYT) <i data-lucide="youtube" class="w-3 h-3 text-white"></i>
                                                    @else <i data-lucide="globe" class="w-3 h-3"></i> @endif
                                                </span>
                                                <span class="text-slate-900 font-bold tabular-nums">{{ number_format($acc->followers) }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                    <span class="text-emerald-700 text-[11px] font-semibold flex items-center gap-1">
                                        <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400 text-amber-400"></i>
                                        <span>{{ number_format($talent->rating_avg ?: 5.0, 1) }}</span>
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Footer / Card Action -->
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">Starting Fee</span>
                                <span class="text-base font-black text-slate-900 font-display">
                                    ₹{{ number_format($talent->rates->first()->rate_amount ?? 15000) }}
                                </span>
                            </div>
                            <a href="{{ route('influencers.public.show', $talent->username) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-brand-600 hover:text-white text-slate-900 text-xs font-bold transition duration-150 shadow-xs">
                                View Profile &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-500">No featured creators available at the moment.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- BENTO GRID: THE MARKETPLACE INFRASTRUCTURE -->
    <section class="py-24 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block font-display">Platform Engine</span>
                <h2 class="text-3xl sm:text-5xl font-black font-display text-slate-900 tracking-tight">
                    Built for Real Creator Commerce
                </h2>
                <p class="text-slate-500 text-sm">
                    Everything you need to hire, collaborate, manage usage rights, and release payments with zero friction.
                </p>
            </div>

            <!-- Bento Layout (Asymmetric 4-Cell Grid) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Cell 1: Live API Follower Sync (Large 7-Col Cell) -->
                <div class="lg:col-span-7 bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-8">
                    <div class="space-y-3">
                        <span class="px-3 py-1 bg-brand-50 text-brand-700 border border-brand-200 text-xs font-bold rounded-full inline-block">
                            Live Social Engine
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-black font-display text-slate-900">
                            Real-Time API Audience Verification
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed max-w-lg">
                            We connect directly to Meta Graph API, Google YouTube Data API v3, and X APIs to authenticate live follower counts, view trends, and engagement metrics before you commit.
                        </p>
                    </div>

                    <!-- Visual Mini API Widget -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs">
                            <span class="text-xs font-bold text-pink-600 block inline-flex items-center gap-1"><i data-lucide="camera" class="w-3.5 h-3.5"></i> Instagram</span>
                            <span class="text-base font-black text-slate-900 font-display">Meta Graph</span>
                            <span class="text-[10px] text-emerald-600 font-bold block mt-1 inline-flex items-center gap-1"><i data-lucide="check" class="w-3 h-3"></i> Live Sync & Reels</span>
                        </div>
                        <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs">
                            <span class="text-xs font-bold text-red-600 block inline-flex items-center gap-1"><i data-lucide="play" class="w-3.5 h-3.5"></i> YouTube</span>
                            <span class="text-base font-black text-slate-900 font-display">Data API v3</span>
                            <span class="text-[10px] text-emerald-600 font-bold block mt-1 inline-flex items-center gap-1"><i data-lucide="check" class="w-3 h-3"></i> 30-Day Views & Subs</span>
                        </div>
                    </div>
                </div>

                <!-- Cell 2: Milestone Escrow Vault (5-Col Cell) -->
                <div class="lg:col-span-5 bg-slate-900 text-white p-8 sm:p-10 rounded-3xl shadow-sm flex flex-col justify-between space-y-6">
                    <div class="space-y-3">
                        <span class="px-3 py-1 bg-emerald-950 text-emerald-400 border border-emerald-800 text-xs font-bold rounded-full inline-block">
                            Escrow Protection
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-black font-display text-white">
                            Zero Payment Disputes
                        </h3>
                        <p class="text-slate-300 text-sm leading-relaxed">
                            Funds are safely deposited upfront into escrow and released only when deliverables are approved. Full protection for both brand and talent.
                        </p>
                    </div>

                    <div class="bg-slate-800/80 p-4 rounded-2xl border border-slate-700 space-y-2">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-400">Escrow Security:</span>
                            <span class="text-emerald-400 font-bold">100% Guaranteed</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-400">Payout Mechanism:</span>
                            <span class="text-white font-bold">Direct Bank / UPI</span>
                        </div>
                    </div>
                </div>

                <!-- Cell 3: Direct 1-on-1 Negotiations (5-Col Cell) -->
                <div class="lg:col-span-5 bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-6">
                    <div class="space-y-3">
                        <span class="px-3 py-1 bg-sky-50 text-sky-700 border border-sky-200 text-xs font-bold rounded-full inline-block">
                            Direct Studio Chat
                        </span>
                        <h3 class="text-2xl font-black font-display text-slate-900">
                            Custom Rates & Negotiation
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Discuss brief specifics, adjust deliverable counts, and agree on commercial quotes directly inside the platform chat room.
                        </p>
                    </div>
                    <div class="text-xs font-bold text-brand-600 flex items-center space-x-1">
                        <span>Real-time messaging & attachments</span>
                        <span>&rarr;</span>
                    </div>
                </div>

                <!-- Cell 4: Commercial Usage Rights (7-Col Cell) -->
                <div class="lg:col-span-7 bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-6">
                    <div class="space-y-3">
                        <span class="px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold rounded-full inline-block">
                            Legal Protection
                        </span>
                        <h3 class="text-2xl font-black font-display text-slate-900">
                            Automated Usage Rights & Licensing
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed max-w-lg">
                            Clear contractual terms for digital ad rights, social whitelisting, duration (3m/6m/12m), and geographic licensing built into every campaign agreement.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs font-semibold text-slate-700">
                        <span class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl inline-flex items-center gap-1.5"><i data-lucide="file-text" class="w-3.5 h-3.5 text-slate-500"></i> Digital Ad Rights</span>
                        <span class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl inline-flex items-center gap-1.5"><i data-lucide="globe" class="w-3.5 h-3.5 text-slate-500"></i> Global Whitelisting</span>
                        <span class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl inline-flex items-center gap-1.5"><i data-lucide="clock" class="w-3.5 h-3.5 text-slate-500"></i> 12-Month Buyout Options</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- OPEN CAMPAIGN BRIEFS -->
    <section class="py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div class="space-y-2">
                    <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block font-display">Casting Calls</span>
                    <h2 class="text-3xl sm:text-4xl font-black font-display text-slate-900 tracking-tight">
                        Live Brand Campaign Briefs
                    </h2>
                    <p class="text-slate-500 text-sm max-w-xl">
                        Apply directly to open brand sponsorship opportunities, fashion shoots, and UGC briefs.
                    </p>
                </div>
                <a href="{{ route('campaigns.public') }}" class="text-sm font-bold text-brand-600 hover:text-brand-700 transition flex items-center space-x-1.5 self-start md:self-auto group">
                    <span>Browse all briefs</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>
            </div>  

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($featuredCampaigns as $camp)
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-md hover:border-brand-300 transition duration-200 flex flex-col justify-between space-y-5 group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 bg-brand-50 text-brand-700 border border-brand-200 text-xs font-bold rounded-full">
                                    {{ $camp->category->name ?? 'General' }}
                                </span>
                                <span class="text-base font-black text-emerald-600 font-display">
                                    ₹{{ number_format($camp->budget_max ?: $camp->budget_min ?: $camp->budget) }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 leading-snug group-hover:text-brand-600 transition font-display">
                                {{ $camp->title ?: $camp->name }}
                            </h3>

                            <p class="text-slate-600 text-xs line-clamp-3 leading-relaxed">
                                {{ $camp->description }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-medium">By {{ $camp->brandProfile->company_name ?? 'Verified Brand' }}</span>
                            <a href="{{ route('campaigns.public.show', $camp->slug) }}" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold transition shadow-xs">
                                View Brief &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-500">No active campaigns posted yet.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS TIMELINE -->
    <section class="py-24 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block font-display">Four-Step Workflow</span>
                <h2 class="text-3xl sm:text-5xl font-black font-display text-slate-900 tracking-tight">
                    How Talent Marketplace Works
                </h2>
                <p class="text-slate-500 text-sm">A seamless, transparent operating pipeline from casting to deliverable sign-off.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white border border-slate-200 p-6 rounded-3xl space-y-4 shadow-sm hover:border-brand-300 transition">
                    <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center font-display font-black text-xl border border-brand-100">
                        01
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-display">Post Requirement</h3>
                    <p class="text-slate-600 text-xs leading-relaxed">Brands define deliverable formats (Reels, Shoots), usage rights, location, and target budget.</p>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-3xl space-y-4 shadow-sm hover:border-brand-300 transition">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-display font-black text-xl border border-purple-100">
                        02
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-display">Receive Creator Pitches</h3>
                    <p class="text-slate-600 text-xs leading-relaxed">Verified talent review requirements and submit tailored proposals with custom quotes.</p>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-3xl space-y-4 shadow-sm hover:border-brand-300 transition">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-display font-black text-xl border border-sky-100">
                        03
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-display">Escrow & Direct Chat</h3>
                    <p class="text-slate-600 text-xs leading-relaxed">Negotiate via 1-on-1 chat, agree on rates, and lock campaign funds safely in milestone escrow.</p>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-3xl space-y-4 shadow-sm hover:border-brand-300 transition">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-display font-black text-xl border border-emerald-100">
                        04
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-display">Approve & Payout</h3>
                    <p class="text-slate-600 text-xs leading-relaxed">Creators submit deliverable links, brands verify and approve, triggering instant payout release.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- DUAL CTA HERO BANNER (AWWWARDS HIGHLIGHT) -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Brand CTA -->
                <div class="bg-slate-50 p-8 sm:p-12 rounded-3xl border border-slate-200 space-y-6 shadow-sm hover:shadow-md transition">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block mb-2 font-display">For Brands & Agencies</span>
                        <h3 class="text-2xl sm:text-3xl font-black font-display text-slate-900">Hire Verified Talent For Your Next Campaign</h3>
                        <p class="text-slate-600 text-xs sm:text-sm mt-2 leading-relaxed">
                            Access top-tier fashion models, influencers, and UGC video creators with milestone escrow payment protection.
                        </p>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('register') }}" class="inline-block px-7 py-3.5 rounded-xl font-bold bg-brand-600 hover:bg-brand-700 text-white shadow-sm transition text-sm">
                            Create Brand Account &rarr;
                        </a>
                    </div>
                </div>

                <!-- Talent CTA -->
                <div class="bg-slate-950 text-white p-8 sm:p-12 rounded-3xl space-y-6 shadow-xl hover:shadow-2xl transition">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-brand-400 block mb-2 font-display">For Models & Creators</span>
                        <h3 class="text-2xl sm:text-3xl font-black font-display text-white">Get Booked For Commercial Shoots & Collabs</h3>
                        <p class="text-slate-300 text-xs sm:text-sm mt-2 leading-relaxed">
                            Showcase your verified social reach, set your rate cards, apply to open casting calls, and get paid on time.
                        </p>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('register') }}" class="inline-block px-7 py-3.5 rounded-xl font-bold bg-white hover:bg-slate-100 text-slate-950 transition text-sm shadow-sm">
                            Join as Creator &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
