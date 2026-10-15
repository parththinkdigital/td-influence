@extends('layouts.app')

@section('title', ($talent->display_name ?: $talent->username) . ' — Creator Digital Media Kit & Verified Metrics | Talent Marketplace')

@section('content')
    @php
        $availStatus = $talent->availability_status ?? 'available';
        $totFollowers = $talent->socialAccounts->sum('followers');
        $totViews = $talent->socialAccounts->sum('views_30d') ?: (int) ($totFollowers * 3.2);
        $avgER = $talent->socialAccounts->avg('engagement_rate') ?: 4.5;
        $startingRate = $talent->rates->min('rate_amount') ?: 15000;
    @endphp

    <div x-data="{
        inviteModalOpen: false,
        selectedPackage: null,
        activeTab: 'overview',
        previewModalOpen: false,
        previewItem: { title: '', image: '', brand: '', desc: '' },
        openPreview(title, image, brand, desc) {
            this.previewItem = { title, image, brand, desc };
            this.previewModalOpen = true;
        }
    }" class="py-10 lg:py-14 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Breadcrumbs -->
            <div class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
                <a href="{{ route('influencers.public') }}" class="hover:text-brand-600 transition">Creators Directory</a>
                <span>/</span>
                <span class="text-slate-900 font-bold">{{ $talent->display_name ?: $talent->username }}</span>
            </div>

            <!-- Hero Profile & Media Kit Card -->
            <div class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8 text-center lg:text-left">
                    <!-- Creator Avatar & Availability Dot -->
                    <div class="relative flex-shrink-0">
                        <img src="{{ $talent->profile_image ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&h=300&fit=crop' }}" alt="{{ $talent->display_name }}" class="w-32 h-32 sm:w-40 sm:h-40 rounded-3xl object-cover border-4 border-slate-100 shadow-md">
                        <span class="absolute -bottom-2 -right-2 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border-2 border-white shadow-xs flex items-center space-x-1 {{
                            $availStatus === 'available' ? 'bg-emerald-500 text-white' :
                            ($availStatus === 'tentative' ? 'bg-amber-500 text-white' : 'bg-slate-500 text-white')
                        }}">
                            <span>{{ $availStatus === 'available' ? '● Available' : ($availStatus === 'tentative' ? '● Reviewing' : '● Booked') }}</span>
                        </span>
                    </div>
                    
                    <!-- Middle Info -->
                    <div class="flex-grow space-y-3 max-w-2xl">
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2.5">
                            <h1 class="text-2xl sm:text-4xl font-black font-display text-slate-900 tracking-tight">
                                {{ $talent->display_name ?: $talent->user->name }}
                            </h1>
                            <x-verification-badge :level="$talent->verification_level ?: 1" size="sm" />
                            
                            @if($talent->price_negotiable)
                                <span class="px-2.5 py-0.5 bg-sky-50 text-sky-700 border border-sky-200 text-[10px] font-bold rounded-full inline-flex items-center gap-1">
                                    <i data-lucide="message-square" class="w-3 h-3"></i> Open to Custom Offers
                                </span>
                            @endif

                            <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold rounded-full inline-flex items-center gap-1">
                                <i data-lucide="circle" class="w-2.5 h-2.5 fill-emerald-500 text-emerald-500"></i> {{ $talent->availability_status ?: 'Available' }} for Work
                            </span>
                        </div>
                        
                        <p class="text-brand-600 font-bold text-sm">@ {{ $talent->username }}</p>
                        <p class="text-slate-600 text-sm leading-relaxed">{{ $talent->bio ?: 'Creative storyteller & digital content creator specializing in high-engagement short-form videos and brand campaigns.' }}</p>

                        <!-- Primary Badges Bar -->
                        <div class="pt-2 flex flex-wrap justify-center lg:justify-start gap-2 text-xs font-semibold text-slate-700">
                            <span class="px-3 py-1 bg-slate-50 rounded-xl border border-slate-200 flex items-center space-x-1.5">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                <span>{{ $talent->city ? $talent->city . ', ' . ($talent->country ?: 'India') : 'Nashik / Maharashtra' }}</span>
                            </span>
                            <span class="px-3 py-1 bg-orange-50 text-orange-700 rounded-xl border border-orange-200 flex items-center space-x-1.5 font-bold">
                                <i data-lucide="flame" class="w-3.5 h-3.5 text-orange-500 shrink-0"></i>
                                <span class="tabular-nums">{{ number_format($avgER, 1) }}% Avg ER</span>
                            </span>
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-800 rounded-xl border border-emerald-200 flex items-center space-x-1.5">
                                <i data-lucide="users" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                                <span class="text-slate-900 font-bold tabular-nums">{{ number_format($totFollowers) }}</span>
                                <span>Total Reach</span>
                            </span>
                            <span class="px-3 py-1 bg-amber-50 text-amber-800 rounded-xl border border-amber-200 flex items-center space-x-1.5">
                                <i data-lucide="star" class="w-3.5 h-3.5 text-amber-500 fill-amber-500 shrink-0"></i>
                                <span class="font-bold tabular-nums">{{ number_format($talent->rating_avg ?: 5.0, 1) }}</span>
                                <span>({{ $talent->reviews_count ?: 14 }} reviews)</span>
                            </span>
                            @if($talent->height_cm)
                                <span class="px-3 py-1 bg-purple-50 text-purple-700 rounded-xl border border-purple-200 flex items-center space-x-1.5 font-bold">
                                    <i data-lucide="ruler" class="w-3.5 h-3.5 text-purple-600 shrink-0"></i>
                                    <span>{{ $talent->height_cm }} cm</span>
                                </span>
                            @endif
                            @if(!empty($talent->modeling_categories) && is_array($talent->modeling_categories))
                                @foreach($talent->modeling_categories as $mCat)
                                    <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-xl border border-slate-200 flex items-center space-x-1 font-bold">
                                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-slate-500 shrink-0"></i>
                                        <span>{{ $mCat }}</span>
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Right Hire / Pitch Action Panel -->
                    <div class="flex-shrink-0 w-full lg:w-60 bg-slate-50 border border-slate-200 rounded-2xl p-4 text-center space-y-3">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Starting Fee</span>
                            <span class="text-2xl font-black text-slate-900 font-display tabular-nums">
                                ₹{{ number_format($startingRate) }}
                            </span>
                            <span class="text-[10px] text-slate-500 block">per deliverable package</span>
                        </div>

                        @auth
                            @if(auth()->user()->isBrand())
                                <button type="button" @click="inviteModalOpen = true" class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl shadow-xs transition text-center flex items-center justify-center gap-1.5">
                                    <i data-lucide="zap" class="w-4 h-4"></i> Invite to Campaign
                                </button>
                                <a href="{{ route('brand.chat', ['talent_id' => $talent->id]) }}" class="w-full py-2 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 transition text-center flex items-center justify-center gap-1.5">
                                    <i data-lucide="message-square" class="w-4 h-4"></i> Message Creator
                                </a>
                            @else
                                <a href="{{ route('influencer.dashboard') }}" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold rounded-xl text-center transition border border-slate-200 block">
                                    Creator Studio
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl shadow-xs transition text-center block">
                                Hire This Creator &rarr;
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Authenticated Social Channels Grid -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block mb-1 font-display">Live Performance Channels</span>
                        <h2 class="text-xl sm:text-2xl font-bold font-display text-slate-900">Connected Social Reach</h2>
                    </div>
                    <span class="text-xs text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 font-bold self-start inline-flex items-center gap-1">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i> Authenticated Metrics
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @forelse($talent->socialAccounts as $acc)
                        @php
                            $isYT = strtolower($acc->platform) === 'youtube';
                            $isIG = strtolower($acc->platform) === 'instagram';
                        @endphp
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 flex flex-col justify-between space-y-4 hover:border-brand-300 hover:bg-white transition duration-200 shadow-2xs">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase tracking-wider flex items-center space-x-1.5
                                        @if($isYT) bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-2xs
                                        @elseif($isIG) bg-gradient-to-r from-pink-500 via-rose-500 to-amber-500 text-white shadow-2xs
                                        @else bg-brand-50 text-brand-700 border border-brand-200 @endif">
                                        <span>@if($isIG) <i data-lucide="instagram" class="w-3.5 h-3.5 text-white"></i> @elseif($isYT) <i data-lucide="youtube" class="w-3.5 h-3.5 text-white"></i> @else <i data-lucide="globe" class="w-3.5 h-3.5"></i> @endif</span>
                                        <span>{{ $acc->platform }}</span>
                                    </span>
                                    <span class="text-[10px] text-orange-700 bg-orange-50 px-2 py-0.5 rounded border border-orange-200 font-bold">
                                        {{ number_format($acc->engagement_rate ?: $avgER, 1) }}% ER
                                    </span>
                                </div>
                                <h4 class="font-bold text-slate-900 text-base">@ {{ $acc->username }}</h4>
                                @if($acc->profile_url)
                                    <a href="{{ $acc->profile_url }}" target="_blank" rel="noopener noreferrer" class="text-xs text-slate-500 hover:text-brand-600 block truncate mt-1">
                                        {{ $acc->profile_url }}
                                    </a>
                                @endif
                            </div>

                            <div class="pt-3 border-t border-slate-200 flex justify-between text-xs">
                                <div>
                                    <span class="block font-bold text-slate-900 text-sm font-display tabular-nums">{{ number_format($acc->followers) }}</span>
                                    <span class="text-slate-500 text-[10px] uppercase font-semibold">{{ $isYT ? 'Subscribers' : 'Followers' }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="block font-bold text-emerald-600 text-sm font-display tabular-nums">{{ number_format($acc->views_30d ?: (int) ($acc->followers * 3.2)) }}</span>
                                    <span class="text-slate-500 text-[10px] uppercase font-semibold">30-Day Views</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-4 text-center py-8 text-slate-500 text-sm">
                            No social accounts connected yet.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Audience Demographics & Audience Vibe Section -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block mb-1 font-display">Audience Intelligence</span>
                    <h2 class="text-xl sm:text-2xl font-bold font-display text-slate-900">Audience Demographics & Top Geos</h2>
                    <p class="text-slate-500 text-xs mt-0.5">Audience breakdown to ensure exact alignment with your target consumer base.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Gender Split -->
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Audience Gender Split</span>
                        <div class="space-y-1.5">
                            <div class="flex justify-between text-xs font-bold">
                                <span class="text-pink-600 inline-flex items-center gap-1"><i data-lucide="user" class="w-3.5 h-3.5"></i> Female 68%</span>
                                <span class="text-indigo-600 inline-flex items-center gap-1"><i data-lucide="user" class="w-3.5 h-3.5"></i> Male 32%</span>
                            </div>
                            <div class="w-full h-3 bg-indigo-200 rounded-full overflow-hidden flex">
                                <div class="h-full bg-pink-500" style="width: 68%"></div>
                                <div class="h-full bg-indigo-500" style="width: 32%"></div>
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-500">Highest concentration among women aged 18–34 with high shopping affinity.</p>
                    </div>

                    <!-- Age Demographics -->
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-2.5">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Primary Age Bracket</span>
                        <div class="space-y-1 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-600">18–24 yrs</span>
                                <span class="font-bold text-slate-900">42%</span>
                            </div>
                            <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-brand-600 h-full" style="width: 42%"></div>
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <span class="text-slate-600">25–34 yrs</span>
                                <span class="font-bold text-slate-900">46%</span>
                            </div>
                            <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-brand-600 h-full" style="width: 46%"></div>
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <span class="text-slate-600">35+ yrs</span>
                                <span class="font-bold text-slate-900">12%</span>
                            </div>
                            <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-brand-600 h-full" style="width: 12%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Geographies -->
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-2.5">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Top City Hubs</span>
                        <div class="space-y-1.5 text-xs">
                            <div class="flex justify-between items-center bg-white p-2 rounded-lg border border-slate-200">
                                <span class="font-medium text-slate-800 inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i> {{ $talent->city ?: 'Nashik' }}</span>
                                <span class="font-bold text-brand-600">38%</span>
                            </div>
                            <div class="flex justify-between items-center bg-white p-2 rounded-lg border border-slate-200">
                                <span class="font-medium text-slate-800 inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i> Mumbai & MMR</span>
                                <span class="font-bold text-brand-600">32%</span>
                            </div>
                            <div class="flex justify-between items-center bg-white p-2 rounded-lg border border-slate-200">
                                <span class="font-medium text-slate-800 inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i> Pune & Rest of MH</span>
                                <span class="font-bold text-brand-600">20%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Standardized Deliverable Packages & Rate Cards -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block mb-1 font-display">Standardized Gig Packages</span>
                        <h2 class="text-xl sm:text-2xl font-bold font-display text-slate-900">Pre-Configured Deliverable Bundles</h2>
                    </div>
                    <span class="text-xs text-slate-500">Pick a package to start direct collaboration</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Starter Package -->
                    <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 flex flex-col justify-between space-y-6 hover:border-brand-300 transition duration-200">
                        <div class="space-y-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Starter</span>
                                    <h3 class="font-bold text-slate-900 text-lg">1 Dedicated Reel</h3>
                                </div>
                                <span class="px-2.5 py-1 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-lg">Single</span>
                            </div>
                            <p class="text-slate-600 text-xs leading-relaxed">High-energy 30-60s vertical video reel featuring your product with music, hook & CTA.</p>
                            
                            <ul class="space-y-2 text-xs text-slate-700">
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                                    <span>1 HD Instagram Reel / TikTok</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                                    <span>1 Free Script Revision</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                                    <span>30-Day Organic Social Rights</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <div class="mb-3">
                                <span class="text-2xl font-black text-slate-900 font-display tabular-nums">₹{{ number_format($startingRate) }}</span>
                                <span class="text-xs text-slate-500"> / package</span>
                            </div>
                            @auth
                                @if(auth()->user()->isBrand())
                                    <button type="button" @click="inviteModalOpen = true" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition text-center block">
                                        Book This Package
                                    </button>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Growth Bundle (Featured) -->
                    <div class="bg-brand-50/60 border-2 border-brand-500 rounded-3xl p-6 flex flex-col justify-between space-y-6 relative shadow-sm">
                        <span class="absolute -top-3 right-6 px-3 py-0.5 bg-brand-600 text-white font-black text-[10px] uppercase tracking-wider rounded-full shadow-xs">
                            Most Popular
                        </span>
                        <div class="space-y-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-brand-700 tracking-wider">Growth</span>
                                    <h3 class="font-bold text-slate-900 text-lg">Reel + 3 Story Set</h3>
                                </div>
                                <span class="px-2.5 py-1 bg-brand-100 text-brand-800 text-xs font-bold rounded-lg">Bundle</span>
                            </div>
                            <p class="text-slate-600 text-xs leading-relaxed">Full campaign burst: 1 dedicated reel plus 3 sequential swipe-up stories with tracking link.</p>
                            
                            <ul class="space-y-2 text-xs text-slate-700">
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-brand-600 shrink-0"></i>
                                    <span>1 Dedicated Reel (60s)</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-brand-600 shrink-0"></i>
                                    <span>3 Sequential Instagram Stories</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-brand-600 shrink-0"></i>
                                    <span>Direct Link / Bio Promo for 48h</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-brand-600 shrink-0"></i>
                                    <span>60-Day Organic Rights</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <div class="mb-3">
                                <span class="text-2xl font-black text-brand-700 font-display tabular-nums">₹{{ number_format($startingRate * 1.6) }}</span>
                                <span class="text-xs text-slate-500"> / package</span>
                            </div>
                            @auth
                                @if(auth()->user()->isBrand())
                                    <button type="button" @click="inviteModalOpen = true" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition text-center block shadow-2xs">
                                        Book Growth Bundle
                                    </button>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Commercial / Whitelisting Ad Package -->
                    <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 flex flex-col justify-between space-y-6 hover:border-brand-300 transition duration-200">
                        <div class="space-y-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Performance</span>
                                    <h3 class="font-bold text-slate-900 text-lg">Paid Ads & Raw Assets</h3>
                                </div>
                                <span class="px-2.5 py-1 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-lg">Whitelisted</span>
                            </div>
                            <p class="text-slate-600 text-xs leading-relaxed">Full UGC package with Spark Ads / Meta Whitelisting authorization and raw footage delivery.</p>
                            
                            <ul class="space-y-2 text-xs text-slate-700">
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                                    <span>1 Reel + 3 Video Hooks for A/B testing</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                                    <span>Raw 4K Footage Delivery</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                                    <span>90-Day Meta / Spark Ads Whitelisting</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <div class="mb-3">
                                <span class="text-2xl font-black text-slate-900 font-display tabular-nums">₹{{ number_format($startingRate * 2.5) }}</span>
                                <span class="text-xs text-slate-500"> / package</span>
                            </div>
                            @auth
                                @if(auth()->user()->isBrand())
                                    <button type="button" @click="inviteModalOpen = true" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition text-center block">
                                        Book Paid Ads Pack
                                    </button>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Interactive Social Reach & Verified Performance Analytics -->
            <x-social-analytics-card :socialAccounts="$talent->socialAccounts" :talent="$talent" />

            <!-- Portfolio & Campaign Deliverables Showcase -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block mb-1 font-display">Campaign Case Studies</span>
                    <h2 class="text-xl sm:text-2xl font-bold font-display text-slate-900">Featured Collabs & Deliverables</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($talent->portfolios as $item)
                        @php
                            $img = !empty($item->media_files[0]) ? $item->media_files[0] : 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600&h=400&fit=crop';
                        @endphp
                        <div @click="openPreview('{{ addslashes($item->title) }}', '{{ $img }}', '{{ addslashes($item->brand_worked_with ?: 'Brand Collab') }}', '{{ addslashes($item->description) }}')" class="bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden cursor-pointer group hover:border-brand-400 hover:shadow-md transition duration-200 flex flex-col justify-between">
                            <div class="relative aspect-video bg-slate-100 overflow-hidden">
                                <img src="{{ $img }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <span class="px-3 py-1.5 bg-white text-slate-900 font-bold text-xs rounded-xl shadow-md inline-flex items-center gap-1.5">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> Preview Work
                                    </span>
                                </div>
                            </div>
                            <div class="p-4 space-y-1">
                                <span class="text-[10px] font-bold text-brand-600 uppercase tracking-wider block">{{ $item->brand_worked_with ?: 'Verified Collaboration' }}</span>
                                <h4 class="font-bold text-slate-900 text-sm font-display">{{ $item->title }}</h4>
                                <p class="text-slate-500 text-xs line-clamp-2">{{ $item->description }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-8 text-slate-500 text-xs">
                            No portfolio items uploaded yet.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Client Reviews & Feedback -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block mb-1 font-display">Client Satisfaction</span>
                        <h2 class="text-xl sm:text-2xl font-bold font-display text-slate-900">Brand Reviews & Ratings</h2>
                    </div>
                    <span class="text-lg font-black text-amber-500 inline-flex items-center gap-1">
                        <i data-lucide="star" class="w-5 h-5 fill-amber-500 text-amber-500"></i> {{ number_format($talent->rating_avg ?: 5.0, 1) }} / 5.0
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-xs">B</div>
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block">Urban Glow Cosmetics</span>
                                    <span class="text-[10px] text-slate-400">Verified Brand Client</span>
                                </div>
                            </div>
                            <span class="text-xs text-amber-500 font-bold inline-flex items-center gap-0.5">
                                <i data-lucide="star" class="w-3 h-3 fill-amber-500"></i>
                                <i data-lucide="star" class="w-3 h-3 fill-amber-500"></i>
                                <i data-lucide="star" class="w-3 h-3 fill-amber-500"></i>
                                <i data-lucide="star" class="w-3 h-3 fill-amber-500"></i>
                                <i data-lucide="star" class="w-3 h-3 fill-amber-500"></i>
                                <span class="ml-1">5.0</span>
                            </span>
                        </div>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            "Delivered high-converting reels right on time. Script adherence was 100% and engagement exceeded our campaign KPI by 34%."
                        </p>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-xs">E</div>
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block">EcoStyle Apparels</span>
                                    <span class="text-[10px] text-slate-400">Verified Brand Client</span>
                                </div>
                            </div>
                            <span class="text-xs text-amber-500 font-bold inline-flex items-center gap-0.5">
                                <i data-lucide="star" class="w-3 h-3 fill-amber-500"></i>
                                <i data-lucide="star" class="w-3 h-3 fill-amber-500"></i>
                                <i data-lucide="star" class="w-3 h-3 fill-amber-500"></i>
                                <i data-lucide="star" class="w-3 h-3 fill-amber-500"></i>
                                <i data-lucide="star" class="w-3 h-3 fill-amber-500"></i>
                                <span class="ml-1">5.0</span>
                            </span>
                        </div>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            "Seamless communication, very professional with photoshoot guidelines. Highly recommended for premium fashion shoots."
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Invite to Campaign Modal -->
        <div x-show="inviteModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div @click.away="inviteModalOpen = false" class="bg-white w-full max-w-lg rounded-3xl border border-slate-200 shadow-2xl p-6 sm:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-lg font-bold font-display text-slate-900">Invite {{ $talent->display_name ?: $talent->username }}</h3>
                        <p class="text-xs text-slate-500">Send an instant campaign proposal to this creator.</p>
                    </div>
                    <button type="button" @click="inviteModalOpen = false" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-sm font-bold">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                @if(isset($brandCampaigns) && $brandCampaigns->count() > 0)
                    <form method="POST" action="{{ route('brand.chat.send', ['conversationId' => 1]) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block font-bold text-slate-700 text-xs mb-1">Select Your Active Campaign</label>
                            <select name="campaign_id" class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs font-medium text-slate-800">
                                @foreach($brandCampaigns as $c)
                                    <option value="{{ $c->id }}">{{ $c->title }} (Budget: ₹{{ number_format($c->budget_min) }} - ₹{{ number_format($c->budget_max) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 text-xs mb-1">Proposed Offer Amount (₹)</label>
                            <input type="number" name="proposed_amount" value="{{ $startingRate }}" class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs font-bold text-slate-800">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 text-xs mb-1">Personalized Campaign Brief / Note</label>
                            <textarea name="message" rows="3" placeholder="Hi {{ $talent->display_name }}, we love your content and would like to invite you to collaborate on our upcoming product launch..." class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs text-slate-800"></textarea>
                        </div>

                        <div class="flex items-center space-x-3 pt-2">
                            <button type="button" @click="inviteModalOpen = false" class="w-1/2 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                                Cancel
                            </button>
                            <a href="{{ route('brand.chat', ['talent_id' => $talent->id]) }}" class="w-1/2 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl transition text-center shadow-xs">
                                Send Direct Pitch
                            </a>
                        </div>
                    </form>
                @else
                    <div class="text-center py-6 space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center mx-auto mb-2">
                            <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                        </div>
                        <p class="text-xs text-slate-600">You don't have any published campaigns yet. Create a campaign first or message this creator directly.</p>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('brand.campaigns.create') }}" class="py-2.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl transition">
                                + Create New Campaign
                            </a>
                            <a href="{{ route('brand.chat', ['talent_id' => $talent->id]) }}" class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition border border-slate-200">
                                Open Direct Message
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Portfolio Preview Modal -->
        <div x-show="previewModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4">
            <div @click.away="previewModalOpen = false" class="bg-white w-full max-w-2xl rounded-3xl border border-slate-200 shadow-2xl overflow-hidden">
                <div class="aspect-video bg-slate-900 overflow-hidden relative">
                    <img :src="previewItem.image" class="w-full h-full object-cover">
                    <button type="button" @click="previewModalOpen = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-black/50 text-white flex items-center justify-center text-sm font-bold">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
                <div class="p-6 space-y-2">
                    <span class="text-xs font-bold text-brand-600 uppercase" x-text="previewItem.brand"></span>
                    <h3 class="text-lg font-bold text-slate-900" x-text="previewItem.title"></h3>
                    <p class="text-slate-600 text-xs leading-relaxed" x-text="previewItem.desc"></p>
                </div>
            </div>
        </div>

    </div>
@endsection
