@extends('layouts.app')

@section('title', 'Brand Campaign Briefs & Casting Calls — Apply with Escrow Protection | HypeMarket')

@section('content')
    <div class="relative">

        @php
            $currentType = request('type', 'all');
            $currentCategory = request('category', '');
            
            $cardAccents = ['#E2F163', '#F47FA2', '#7EC4FB', '#BDB0FC', '#FF3E14'];
        @endphp

        <!-- ========================================================================= -->
        <!-- SECTION 1: ASYMMETRIC HERO & CASTING BRIEF SPOTLIGHT                      -->
        <!-- ========================================================================= -->
        <section class="pt-8 pb-12 sm:pt-12 sm:pb-16 relative overflow-hidden">
            <!-- Glow Accents -->
            <div aria-hidden="true" class="absolute -left-20 top-10 h-72 w-72 rounded-full bg-[#E2F163]/25 blur-[120px] pointer-events-none -z-10"></div>
            <div aria-hidden="true" class="absolute -right-20 top-20 h-72 w-72 rounded-full bg-[#7EC4FB]/20 blur-[120px] pointer-events-none -z-10"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Left: Hero Headline, Value Prop & Live Stats -->
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border-2 border-[#181528] text-[#181528] text-xs font-mono font-black uppercase tracking-wider shadow-[3px_3px_0_#181528] -rotate-1 hover:rotate-0 transition-transform">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#FF3E14] animate-ping"></span>
                            <span>OPEN CASTING BRIEFS &bull; ESCROW SECURED BUDGETS</span>
                        </div>

                        <h1 class="font-display font-extrabold tracking-tight leading-[0.96] text-[#181528]" style="font-size: clamp(2.5rem, 5.5vw, 4.4rem);">
                            <span>Pitch To Verified</span><br>
                            <span class="grad-text2">Brand Campaigns</span><br>
                            <span>&amp; Open Casting</span>
                            <span class="sticker-lime mx-1.5 inline-block -rotate-3 rounded-2xl px-3 py-1 font-display font-extrabold text-[#181528] text-2xl sm:text-4xl shadow-[4px_4px_0_#181528] align-middle">Calls.</span>
                        </h1>

                        <p class="text-[#524B66] text-base sm:text-lg font-medium leading-relaxed max-w-xl font-sans">
                            Discover commercial lookbook shoots, Instagram reel sponsorships, and UGC ad video briefs. Pitch custom deliverables and get paid securely with milestone escrow.
                        </p>

                        <div class="flex flex-wrap items-center gap-4 pt-1">
                            <span class="font-caveat text-2xl text-[#FF3E14] font-bold -rotate-2">
                                direct brand review &bull; 100% pre-funded escrow &starf;
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap items-center gap-4 pt-2">
                            @auth
                                @if(auth()->user()->isBrand())
                                    <a href="{{ route('brand.campaigns.create') }}" class="hm-btn px-7 py-3.5 rounded-full bg-[#181528] text-white font-display font-black text-xs sm:text-sm shadow-[4px_4px_0_#E2F163] transition flex items-center space-x-2">
                                        <i class="fa-solid fa-plus text-[#E2F163]"></i>
                                        <span>Post a New Brief</span>
                                    </a>
                                @else
                                    <a href="#campaigns-grid" class="hm-btn px-7 py-3.5 rounded-full bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] border-2 border-[#181528] font-display font-black text-xs sm:text-sm shadow-[4px_4px_0_#181528] transition flex items-center space-x-2">
                                        <span>Browse Open Briefs</span>
                                        <i class="fa-solid fa-arrow-down text-xs"></i>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="hm-btn px-7 py-3.5 rounded-full bg-[#181528] text-white font-display font-black text-xs sm:text-sm shadow-[4px_4px_0_#E2F163] transition flex items-center space-x-2">
                                    <span>Post a Brief as Brand</span>
                                    <i class="fa-solid fa-arrow-right text-xs text-[#E2F163]"></i>
                                </a>
                                <a href="#campaigns-grid" class="hm-btn px-6 py-3.5 rounded-full bg-white hover:bg-[#FAF5EC] text-[#181528] border-2 border-[#181528] font-display font-black text-xs sm:text-sm shadow-[3px_3px_0_#181528] transition">
                                    <span>Browse Casting Calls &darr;</span>
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Right: Stacked Magazine-Style Brief Showcase -->
                    <div class="lg:col-span-5 relative flex justify-center">
                        <div class="relative w-full max-w-sm sm:max-w-md">
                            
                            <!-- Background Tilted Card -->
                            <div class="absolute inset-0 bg-[#7EC4FB] rounded-[32px] border-2 border-[#181528] shadow-[8px_8px_0_#181528] transform rotate-3 translate-x-2 translate-y-3 pointer-events-none"></div>

                            <!-- Main Featured Brief Spotlight Card -->
                            <div class="relative bg-white rounded-[32px] border-2 border-[#181528] shadow-[8px_8px_0_#181528] p-5 sm:p-6 overflow-hidden space-y-4">
                                
                                <!-- Top Pill Bar -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#181528] text-white text-[10px] font-mono font-bold uppercase">
                                        <span class="w-2 h-2 rounded-full bg-[#E2F163] animate-pulse"></span>
                                        <span>FEATURED CASTING CALL</span>
                                    </div>
                                    <span class="sticker-lime px-2.5 py-0.5 rounded-full text-[10px] font-mono font-black rotate-2">
                                        ₹60,000 BUDGET
                                    </span>
                                </div>

                                <div>
                                    <span class="text-xs font-mono font-bold text-[#FF3E14] block mb-1">By Aura Luxury Heritage</span>
                                    <h3 class="font-display font-black text-xl text-[#181528] leading-snug">
                                        Festive Ethnic Lookbook Shoot &amp; Reel Collab
                                    </h3>
                                    <p class="text-xs text-[#524B66] font-sans mt-2 line-clamp-2">
                                        Looking for 2 verified female fashion models for upcoming festive collection shoot at vineyard &amp; heritage locations in Nashik.
                                    </p>
                                </div>

                                <!-- Deliverables Preview -->
                                <div class="flex flex-wrap gap-1.5 pt-1">
                                    <span class="px-2.5 py-1 rounded-lg bg-[#FAF5EC] border border-[#181528] text-[11px] font-mono font-bold text-[#181528] shadow-[1px_1px_0_#181528]">
                                        <i class="fa-solid fa-camera text-[#FF3E14]"></i> 15x Outfit Stills
                                    </span>
                                    <span class="px-2.5 py-1 rounded-lg bg-[#FCE7EE] border border-[#181528] text-[11px] font-mono font-bold text-[#181528] shadow-[1px_1px_0_#181528]">
                                        <i class="fa-brands fa-instagram text-[#8F1449]"></i> 1x BTS Reel
                                    </span>
                                </div>

                                <!-- Escrow Guarantee Strip -->
                                <div class="bg-[#FAF5EC] border-2 border-[#181528] rounded-2xl p-3 flex items-center justify-between text-xs font-mono font-bold">
                                    <span class="flex items-center gap-1.5 text-[#181528]">
                                        <i class="fa-solid fa-shield-halved text-[#10B981]"></i>
                                        <span>Escrow Milestone</span>
                                    </span>
                                    <span class="text-[#FF3E14] font-black">Pre-funded</span>
                                </div>

                                <!-- Movable Sparkle Star in corner -->
                                <div class="movable-symbol anim-wobble absolute -bottom-3 -right-3 text-[#E2F163] cursor-grab active:cursor-grabbing hover:scale-125 transition-transform" title="Drag me!">
                                    <svg class="w-12 h-12 drop-shadow-[0_2px_4px_rgba(0,0,0,0.4)]" viewBox="0 0 100 100" fill="#E2F163">
                                        <path d="M50 0 C50 35 65 50 100 50 C65 50 50 65 50 100 C50 65 35 50 0 50 C35 50 50 35 50 0 Z"/>
                                    </svg>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- SECTION 2: BROWSE BY FORMAT — BENTO DECK                                  -->
        <!-- ========================================================================= -->
        <section class="py-4 sm:py-6 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex items-end justify-between mb-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-xs font-mono font-bold uppercase tracking-wider text-[#FF3E14]">
                            <i class="fa-solid fa-layer-group"></i>
                            <span>Campaign Format Deck</span>
                        </div>
                        <h2 class="font-display font-black text-xl sm:text-2xl text-[#181528] tracking-tight">
                            Filter By Deliverable Format
                        </h2>
                    </div>
                    <span class="hidden sm:block font-caveat text-lg text-[#524B66] -rotate-1">choose your specialty &darr;</span>
                </div>

                <!-- 5 Format Bento Cards (Compact Height, Soft Subtle Shadow) -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2.5 sm:gap-3">
                    
                    <!-- 1. All Briefs -->
                    <a href="{{ route('campaigns.public', array_merge(request()->except('type', 'page'), ['type' => 'all'])) }}"
                       class="rounded-2xl py-2.5 px-3 sm:py-3 sm:px-3.5 border border-[#181528]/80 transition-all duration-200 flex flex-col justify-between group relative {{ $currentType === 'all' || !$currentType ? 'bg-[#FF5722] text-white shadow-[2px_2px_0_#181528] -translate-y-0.5' : 'bg-white hover:bg-[#FAF5EC] text-[#181528] shadow-[1.5px_1.5px_0_#181528] hover:-translate-y-0.5' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center border border-[#181528]/40 {{ $currentType === 'all' || !$currentType ? 'bg-white text-[#FF5722]' : 'bg-[#FAF5EC] text-[#181528]' }}">
                                <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
                            </span>
                            <span class="text-[9px] font-mono font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $currentType === 'all' || !$currentType ? 'bg-white/25 text-white' : 'bg-black/5 text-[#524B66]' }}">ALL</span>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-sm sm:text-base leading-tight mb-0.5">All Briefs</h3>
                            <p class="text-[10px] sm:text-[11px] font-sans leading-tight {{ $currentType === 'all' || !$currentType ? 'text-white/90' : 'text-[#524B66]' }}">Every active casting call</p>
                        </div>
                    </a>

                    <!-- 2. Instagram Reels -->
                    <a href="{{ route('campaigns.public', array_merge(request()->except('type', 'page'), ['type' => 'reel'])) }}"
                       class="rounded-2xl py-2.5 px-3 sm:py-3 sm:px-3.5 border border-[#181528]/80 transition-all duration-200 flex flex-col justify-between group relative {{ $currentType === 'reel' ? 'bg-[#F47FA2] text-[#181528] shadow-[2px_2px_0_#181528] -translate-y-0.5' : 'bg-white hover:bg-[#FCE7EE] text-[#181528] shadow-[1.5px_1.5px_0_#181528] hover:-translate-y-0.5' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center border border-[#181528]/40 bg-white text-[#8F1449]">
                                <i class="fa-brands fa-instagram text-sm"></i>
                            </span>
                            <span class="text-[9px] font-mono font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-[#181528] text-white">REEL</span>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-sm sm:text-base leading-tight mb-0.5">Instagram Reels</h3>
                            <p class="text-[10px] sm:text-[11px] font-sans leading-tight text-[#181528]/80">Sponsored feed reels</p>
                        </div>
                    </a>

                    <!-- 3. UGC Video Ads -->
                    <a href="{{ route('campaigns.public', array_merge(request()->except('type', 'page'), ['type' => 'ugc'])) }}"
                       class="rounded-2xl py-2.5 px-3 sm:py-3 sm:px-3.5 border border-[#181528]/80 transition-all duration-200 flex flex-col justify-between group relative {{ $currentType === 'ugc' ? 'bg-[#7EC4FB] text-[#181528] shadow-[2px_2px_0_#181528] -translate-y-0.5' : 'bg-white hover:bg-[#EAF5FE] text-[#181528] shadow-[1.5px_1.5px_0_#181528] hover:-translate-y-0.5' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center border border-[#181528]/40 bg-white text-[#0E4875]">
                                <i class="fa-solid fa-video text-xs"></i>
                            </span>
                            <span class="text-[9px] font-mono font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-[#181528] text-white">UGC</span>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-sm sm:text-base leading-tight mb-0.5">UGC Video Ads</h3>
                            <p class="text-[10px] sm:text-[11px] font-sans leading-tight text-[#181528]/80">Meta ad creative videos</p>
                        </div>
                    </a>

                    <!-- 4. Photoshoots & Lookbooks -->
                    <a href="{{ route('campaigns.public', array_merge(request()->except('type', 'page'), ['type' => 'photoshoot'])) }}"
                       class="rounded-2xl py-2.5 px-3 sm:py-3 sm:px-3.5 border border-[#181528]/80 transition-all duration-200 flex flex-col justify-between group relative {{ $currentType === 'photoshoot' ? 'bg-[#FFF9AA] text-[#181528] shadow-[2px_2px_0_#181528] -translate-y-0.5' : 'bg-white hover:bg-[#FFFDE0] text-[#181528] shadow-[1.5px_1.5px_0_#181528] hover:-translate-y-0.5' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center border border-[#181528]/40 bg-white text-[#FF3E14]">
                                <i class="fa-solid fa-camera text-xs"></i>
                            </span>
                            <span class="text-[9px] font-mono font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-[#181528] text-white">SHOOT</span>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-sm sm:text-base leading-tight mb-0.5">Commercial Shoots</h3>
                            <p class="text-[10px] sm:text-[11px] font-sans leading-tight text-[#181528]/80">Runway &amp; catalogue looks</p>
                        </div>
                    </a>

                    <!-- 5. Event Hosting -->
                    <a href="{{ route('campaigns.public', array_merge(request()->except('type', 'page'), ['type' => 'event'])) }}"
                       class="col-span-2 md:col-span-1 rounded-2xl py-2.5 px-3 sm:py-3 sm:px-3.5 border border-[#181528]/80 transition-all duration-200 flex flex-col justify-between group relative {{ $currentType === 'event' ? 'bg-[#BDB0FC] text-[#181528] shadow-[2px_2px_0_#181528] -translate-y-0.5' : 'bg-white hover:bg-[#F1EEFD] text-[#181528] shadow-[1.5px_1.5px_0_#181528] hover:-translate-y-0.5' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center border border-[#181528]/40 bg-white text-[#3B2485]">
                                <i class="fa-solid fa-microphone-lines text-xs"></i>
                            </span>
                            <span class="text-[9px] font-mono font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-[#181528] text-white">EVENT</span>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-sm sm:text-base leading-tight mb-0.5">Event Hosting</h3>
                            <p class="text-[10px] sm:text-[11px] font-sans leading-tight text-[#181528]/80">Live emcees &amp; stage hosts</p>
                        </div>
                    </a>

                </div>

            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- SECTION 3: SEARCH & FILTER COMMAND BAR                                    -->
        <!-- ========================================================================= -->
        <section class="py-4 sm:py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
                
                <form method="GET" action="{{ route('campaigns.public') }}" class="bg-white p-5 sm:p-6 rounded-[32px] border-2 border-[#181528] shadow-[6px_6px_0_#181528] space-y-4">
                    <input type="hidden" name="type" value="{{ $currentType }}">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5">
                        
                        <!-- Search Keyword Input -->
                        <div class="lg:col-span-5">
                            <label class="block font-mono font-black text-[#524B66] uppercase text-[10px] mb-1.5">
                                Keyword, Brand or Location
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#827B96]">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by campaign title, brand, Nashik, or requirements..." class="w-full bg-[#FAF5EC] border-2 border-[#181528] rounded-2xl pl-10 pr-4 py-2.5 text-xs sm:text-sm font-semibold text-[#181528] placeholder-[#827B96] focus:outline-none focus:bg-white focus:shadow-[3px_3px_0_#181528] transition">
                            </div>
                        </div>

                        <!-- Industry Category Dropdown -->
                        <div class="lg:col-span-4">
                            <label class="block font-mono font-black text-[#524B66] uppercase text-[10px] mb-1.5">
                                Category / Industry
                            </label>
                            <select name="category" class="w-full bg-[#FAF5EC] border-2 border-[#181528] rounded-2xl px-3.5 py-2.5 text-xs sm:text-sm text-[#181528] font-bold focus:outline-none focus:bg-white focus:shadow-[3px_3px_0_#181528] transition">
                                <option value="">All Categories &amp; Niches</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Submit Button -->
                        <div class="lg:col-span-3 flex items-end space-x-2">
                            <button type="submit" class="hm-btn flex-grow py-2.5 px-5 rounded-2xl bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] border-2 border-[#181528] font-black font-display text-xs sm:text-sm shadow-[4px_4px_0_#181528] transition text-center flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-sliders text-xs"></i>
                                <span>Filter Briefs</span>
                            </button>
                            @if(request('search') || request('category') || ($currentType !== 'all' && $currentType !== ''))
                                <a href="{{ route('campaigns.public') }}" class="hm-btn px-4 py-2.5 bg-white hover:bg-[#FFEBE6] text-[#FF3E14] border-2 border-[#181528] rounded-2xl text-xs font-mono font-bold shadow-[2px_2px_0_#181528]" title="Reset Filters">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            @endif
                        </div>

                    </div>
                </form>

            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- SECTION 4: THE CAMPAIGNS & CASTING CALLS GRID                             -->
        <!-- ========================================================================= -->
        <section id="campaigns-grid" class="py-8 min-h-[600px] pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <!-- Results Bar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b-2 border-[#181528]/10">
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white border-2 border-[#181528] shadow-[3px_3px_0_#181528] text-xs font-mono font-black text-[#181528]">
                        <i class="fa-solid fa-briefcase text-[#FF3E14]"></i>
                        <span>Showing <span class="text-[#FF3E14] tabular-nums font-black">{{ $campaigns->total() }}</span> Active Casting Calls</span>
                    </div>

                    <div class="text-xs font-mono font-bold text-[#524B66] flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-[#10B981]"></i>
                        <span>All briefs are protected with <strong class="text-[#181528] underline decoration-[#E2F163] decoration-2">Milestone Escrow Payouts</strong></span>
                    </div>
                </div>

                <!-- Campaigns Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @forelse($campaigns as $campaign)
                        @php
                            $accent = $cardAccents[$loop->index % count($cardAccents)];
                            $budget = (float) ($campaign->budget_max ?: ($campaign->budget_min ?: ($campaign->budget ?: 0)));
                        @endphp

                        <div class="bg-white rounded-[32px] p-6 border-2 border-[#181528] flex flex-col justify-between transition-all duration-300 hover:-translate-y-2 group relative text-left"
                             style="box-shadow: 6px 6px 0 {{ $accent }};"
                             onmouseenter="this.style.boxShadow='9px 9px 0 #181528'"
                             onmouseleave="this.style.boxShadow='6px 6px 0 {{ $accent }}'">
                            
                            <div class="space-y-4">
                                <!-- Top Row: Category + Budget Pill -->
                                <div class="flex items-center justify-between gap-2">
                                    <span class="px-3 py-1 bg-[#FAF5EC] text-[#181528] border-2 border-[#181528] text-xs font-mono font-bold rounded-full shadow-[2px_2px_0_#181528]">
                                        {{ $campaign->category->name ?? 'General' }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#E2F163] border-2 border-[#181528] text-xs font-mono font-black text-[#181528] shadow-[2px_2px_0_#181528]">
                                        ₹{{ number_format($budget) }}
                                    </span>
                                </div>

                                <!-- Brand & Title -->
                                <div>
                                    <span class="text-xs font-mono font-bold text-[#524B66] flex items-center gap-1.5 mb-1">
                                        <i class="fa-solid fa-circle-check text-[#10B981] text-[10px]"></i>
                                        <span>By {{ $campaign->brandProfile->company_name ?? 'Verified Brand' }}</span>
                                    </span>
                                    <h3 class="font-display font-black text-xl text-[#181528] group-hover:text-[#FF3E14] transition leading-snug line-clamp-2">
                                        {{ $campaign->title ?: $campaign->name }}
                                    </h3>
                                </div>

                                <!-- Description Snippet -->
                                <p class="text-[#524B66] text-xs font-sans line-clamp-3 leading-relaxed">
                                    {{ $campaign->description }}
                                </p>

                                <!-- Deliverables Badges -->
                                @if($campaign->deliverables && $campaign->deliverables->count() > 0)
                                    <div class="flex flex-wrap gap-1.5 pt-1">
                                        @foreach($campaign->deliverables->take(2) as $del)
                                            <span class="px-2.5 py-1 rounded-lg bg-[#FAF5EC] border border-[#181528] text-[11px] font-mono font-bold text-[#181528] inline-flex items-center gap-1 shadow-[1px_1px_0_#181528]">
                                                <i class="fa-solid fa-box text-[#FF3E14] text-[10px]"></i>
                                                <span>{{ $del->quantity }}x {{ $del->name }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Bottom Row: Location & Action Button -->
                            <div class="pt-4 border-t-2 border-[#181528]/10 flex items-center justify-between text-xs mt-4">
                                <span class="font-mono font-bold text-[#524B66] inline-flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-[#FF3E14]"></i>
                                    <span>{{ $campaign->city ?: 'Remote / Pan-India' }}</span>
                                </span>
                                <a href="{{ route('campaigns.public.show', $campaign->slug) }}" class="hm-btn px-4 py-2 rounded-xl bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] text-xs font-display font-black border-2 border-[#181528] shadow-[3px_3px_0_#181528] flex items-center gap-1.5 transition">
                                    <span>View &amp; Pitch</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>

                        </div>
                    @empty
                        <!-- Showcase Fallback Briefs (Ensuring Page Always Looks Vibrant & Populated) -->
                        @php
                            $mockBriefs = [
                                [
                                    'title'        => 'Festive Ethnic Lookbook Shoot & Instagram BTS Reel',
                                    'brand'        => 'Aura Luxury Heritage',
                                    'category'     => 'Fashion Runway',
                                    'budget'       => '₹60,000',
                                    'desc'         => 'Looking for 2 professional female fashion models for our upcoming Festive Collection shoot across heritage vineyard villas in Nashik. Travel and stay provided.',
                                    'city'         => 'Nashik Hub, MH',
                                    'deliverables' => ['15x Lookbook Outfits', '1x BTS Video Reel'],
                                    'accent'       => '#E2F163'
                                ],
                                [
                                    'title'        => 'D2C Skincare Serum 30s UGC Hook & Organic Collab',
                                    'brand'        => 'GlowLab Clean Beauty',
                                    'category'     => 'UGC & Beauty',
                                    'budget'       => '₹25,000',
                                    'desc'         => 'Seeking 3 micro/mid skincare creators to film genuine 30s testimonial hook videos with before-and-after skin texture demonstration.',
                                    'city'         => 'Remote / Pan-India',
                                    'deliverables' => ['2x UGC Video Ad Hooks', '1x 30s Video Review'],
                                    'accent'       => '#F47FA2'
                                ],
                                [
                                    'title'        => 'B2B FinTech & AI App Launch Reel Series',
                                    'brand'        => 'VaultPay Technologies',
                                    'category'     => 'Tech & Finance',
                                    'budget'       => '₹45,000',
                                    'desc'         => 'Looking for charismatic tech creators and finance influencers to demonstrate how smart invoice escrow simplifies freelancer payouts in 60 seconds.',
                                    'city'         => 'Bangalore & Remote',
                                    'deliverables' => ['1x High-Energy Explainer Reel', '1x Story Set'],
                                    'accent'       => '#7EC4FB'
                                ],
                                [
                                    'title'        => 'Annual Corporate Innovation Summit Emcee & Host',
                                    'brand'        => 'Apex Enterprise Group',
                                    'category'     => 'Event Anchoring',
                                    'budget'       => '₹75,000',
                                    'desc'         => 'Seeking an experienced bilingual corporate emcee for our 2-day national leadership summit. Must have experience hosting onstage audiences over 500+ delegates.',
                                    'city'         => 'Mumbai Hub, MH',
                                    'deliverables' => ['2 Days Onstage Hosting', 'Speaker Panel Moderation'],
                                    'accent'       => '#BDB0FC'
                                ],
                                [
                                    'title'        => 'Sustainable Activewear Spring Fitness Campaign',
                                    'brand'        => 'AeroActive Performance',
                                    'category'     => 'Fitness & Wellness',
                                    'budget'       => '₹35,000',
                                    'desc'         => 'We need 2 athletic fitness creators for outdoor workout and running reels showcasing our new breathable recycled nylon activewear.',
                                    'city'         => 'Pune Hub & Remote',
                                    'deliverables' => ['2x Instagram Workout Reels', 'High-Res Stills Pack'],
                                    'accent'       => '#FF3E14'
                                ],
                                [
                                    'title'        => 'Organic Food & Quick Recipe Series Sponsorship',
                                    'brand'        => 'FarmFresh Organics',
                                    'category'     => 'Food & Recipes',
                                    'budget'       => '₹28,000',
                                    'desc'         => 'Calling all food creators and quick-meal chefs! Create a viral 45s recipe video integrating our cold-pressed mustard oil with step-by-step cooking steps.',
                                    'city'         => 'Remote / Pan-India',
                                    'deliverables' => ['1x Recipe Reel Video', 'High-Res Plated Photos'],
                                    'accent'       => '#E2F163'
                                ],
                            ];
                        @endphp

                        @foreach($mockBriefs as $mock)
                            <div class="bg-white rounded-[32px] p-6 border-2 border-[#181528] flex flex-col justify-between transition-all duration-300 hover:-translate-y-2 group relative text-left"
                                 style="box-shadow: 6px 6px 0 {{ $mock['accent'] }};"
                                 onmouseenter="this.style.boxShadow='9px 9px 0 #181528'"
                                 onmouseleave="this.style.boxShadow='6px 6px 0 {{ $mock['accent'] }}'">
                                
                                <div class="space-y-4">
                                    <!-- Top Row: Category + Budget Pill -->
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="px-3 py-1 bg-[#FAF5EC] text-[#181528] border-2 border-[#181528] text-xs font-mono font-bold rounded-full shadow-[2px_2px_0_#181528]">
                                            {{ $mock['category'] }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#E2F163] border-2 border-[#181528] text-xs font-mono font-black text-[#181528] shadow-[2px_2px_0_#181528]">
                                            {{ $mock['budget'] }}
                                        </span>
                                    </div>

                                    <!-- Brand & Title -->
                                    <div>
                                        <span class="text-xs font-mono font-bold text-[#524B66] flex items-center gap-1.5 mb-1">
                                            <i class="fa-solid fa-circle-check text-[#10B981] text-[10px]"></i>
                                            <span>By {{ $mock['brand'] }}</span>
                                        </span>
                                        <h3 class="font-display font-black text-xl text-[#181528] group-hover:text-[#FF3E14] transition leading-snug line-clamp-2">
                                            {{ $mock['title'] }}
                                        </h3>
                                    </div>

                                    <!-- Description Snippet -->
                                    <p class="text-[#524B66] text-xs font-sans line-clamp-3 leading-relaxed">
                                        {{ $mock['desc'] }}
                                    </p>

                                    <!-- Deliverables Badges -->
                                    <div class="flex flex-wrap gap-1.5 pt-1">
                                        @foreach($mock['deliverables'] as $del)
                                            <span class="px-2.5 py-1 rounded-lg bg-[#FAF5EC] border border-[#181528] text-[11px] font-mono font-bold text-[#181528] inline-flex items-center gap-1 shadow-[1px_1px_0_#181528]">
                                                <i class="fa-solid fa-box text-[#FF3E14] text-[10px]"></i>
                                                <span>{{ $del }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Bottom Row: Location & Action Button -->
                                <div class="pt-4 border-t-2 border-[#181528]/10 flex items-center justify-between text-xs mt-4">
                                    <span class="font-mono font-bold text-[#524B66] inline-flex items-center gap-1">
                                        <i class="fa-solid fa-location-dot text-[#FF3E14]"></i>
                                        <span>{{ $mock['city'] }}</span>
                                    </span>
                                    <a href="{{ route('register') }}" class="hm-btn px-4 py-2 rounded-xl bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] text-xs font-display font-black border-2 border-[#181528] shadow-[3px_3px_0_#181528] flex items-center gap-1.5 transition">
                                        <span>View &amp; Pitch</span>
                                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    @endforelse
                </div>

                <!-- Pagination (when real records exist) -->
                @if($campaigns->hasPages())
                    <div class="pt-8 flex justify-center">
                        {{ $campaigns->links() }}
                    </div>
                @endif

            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- SECTION 5: "READY TO CAST?" HIGH-CONVERTING BRAND CALLOUT                 -->
        <!-- ========================================================================= -->
        <section class="py-12 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-[#181528] text-white rounded-[36px] border-2 border-[#181528] shadow-[10px_10px_0_#E2F163] p-8 sm:p-14 relative overflow-hidden">
                    
                    <!-- Decorative Background Orbs -->
                    <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-[#FF3E14]/30 blur-[100px] pointer-events-none"></div>
                    <div class="absolute -left-16 -bottom-16 w-64 h-64 rounded-full bg-[#E2F163]/20 blur-[100px] pointer-events-none"></div>

                    <!-- Movable Sparkle Star Decor -->
                    <div class="movable-symbol anim-wobble absolute top-6 right-8 text-[#E2F163] hidden md:block cursor-grab hover:scale-125 transition-transform" title="Drag me!">
                        <svg class="w-14 h-14" viewBox="0 0 100 100" fill="#E2F163">
                            <path d="M50 0 C50 35 65 50 100 50 C65 50 50 65 50 100 C50 65 35 50 0 50 C35 50 50 35 50 0 Z"/>
                        </svg>
                    </div>

                    <div class="relative z-10 max-w-2xl text-left space-y-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#E2F163] text-[#181528] text-[11px] font-mono font-black uppercase tracking-wider shadow-[2px_2px_0_#FFFFFF]">
                            <i class="fa-solid fa-bullhorn text-[#FF3E14]"></i>
                            <span>FOR BRAND MANAGERS &amp; AGENCIES</span>
                        </span>

                        <h2 class="font-display font-extrabold text-3xl sm:text-5xl text-white tracking-tight leading-[1.05]">
                            Have an Upcoming Campaign or Lookbook Launch?
                        </h2>

                        <p class="text-white/80 text-sm sm:text-base font-sans leading-relaxed">
                            Stop DMing individual profiles. Post your brief to over 4,800 verified fashion models, Instagram creators, and UGC specialists in under 3 minutes.
                        </p>

                        <div class="flex flex-wrap items-center gap-4 pt-4">
                            @auth
                                @if(auth()->user()->isBrand())
                                    <a href="{{ route('brand.campaigns.create') }}" class="hm-btn px-7 py-3.5 rounded-full bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] border-2 border-[#181528] font-display font-black text-sm shadow-[4px_4px_0_#FFFFFF] transition flex items-center space-x-2">
                                        <span>Create a Campaign Brief</span>
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                @else
                                    <a href="{{ route('influencers.public') }}" class="hm-btn px-7 py-3.5 rounded-full bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] border-2 border-[#181528] font-display font-black text-sm shadow-[4px_4px_0_#FFFFFF] transition flex items-center space-x-2">
                                        <span>Explore Creator Roster</span>
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="hm-btn px-7 py-3.5 rounded-full bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] border-2 border-[#181528] font-display font-black text-sm shadow-[4px_4px_0_#FFFFFF] transition flex items-center space-x-2">
                                    <span>Post a Brief as Brand</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                                <a href="{{ route('pricing') }}" class="hm-btn px-6 py-3.5 rounded-full bg-white/10 hover:bg-white/20 text-white border-2 border-white/30 font-display font-black text-sm transition">
                                    <span>Estimate Escrow Budget &rarr;</span>
                                </a>
                            @endauth
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>
@endsection
