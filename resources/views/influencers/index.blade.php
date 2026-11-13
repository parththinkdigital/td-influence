@extends('layouts.app')

@section('title', 'Verified Talent Directory — Models, Influencers, Anchors & UGC Creators | HypeMarket')

@section('content')
    <div x-data="{
        showAdvanced: {{ request()->hasAny(['follower_bracket', 'verification_level', 'availability', 'negotiable', 'modeling_category', 'event_type', 'min_engagement', 'deliverable', 'sort', 'gender']) ? 'true' : 'false' }},
        compareList: [],
        compareModalOpen: false,
        compareData: [],
        loadingCompare: false,
        toggleCompare(id) {
            const index = this.compareList.indexOf(id);
            if (index > -1) {
                this.compareList.splice(index, 1);
            } else {
                if (this.compareList.length >= 3) {
                    alert('You can compare up to 3 creators at a time.');
                    return;
                }
                this.compareList.push(id);
            }
        },
        openCompareModal() {
            if (this.compareList.length < 2) {
                alert('Please select at least 2 creators to compare.');
                return;
            }
            this.loadingCompare = true;
            this.compareModalOpen = true;
            fetch('{{ route('talent.compare.data') }}?ids=' + this.compareList.join(','))
                .then(res => res.json())
                .then(data => {
                    this.compareData = data.talents || [];
                    this.loadingCompare = false;
                })
                .catch(() => {
                    this.loadingCompare = false;
                });
        }
    }" class="relative">

        @php
            $currentType = request('talent_type', 'all');
            $currentNiche = request('niche', 'all');
            $currentDeliverable = request('deliverable', 'all');
            
            $fallbackImages = [
                'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=600&h=800&fit=crop',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=800&fit=crop',
                'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=600&h=800&fit=crop',
                'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=600&h=800&fit=crop',
                'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=600&h=800&fit=crop',
                'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=600&h=800&fit=crop',
                'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=600&h=800&fit=crop',
                'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=600&h=800&fit=crop',
                'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=600&h=800&fit=crop',
                'https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?w=600&h=800&fit=crop',
                'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=600&h=800&fit=crop',
                'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=600&h=800&fit=crop',
            ];
        @endphp

        <!-- ========================================================================= -->
        <!-- SECTION 1: BROWSE BY PERSONA — INTERACTIVE BENTO DECK                     -->
        <!-- ========================================================================= -->
        <section class="pt-6 sm:pt-8 pb-4 sm:pb-6 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex items-end justify-between mb-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-xs font-mono font-bold uppercase tracking-wider text-[#FF3E14]">
                            <i class="fa-solid fa-shapes"></i>
                            <span>Talent Persona Deck</span>
                        </div>
                        <h1 class="font-display font-black text-2xl sm:text-3xl text-[#181528] tracking-tight">
                            Explore Verified Creators &amp; Talent
                        </h1>
                    </div>
                    <span class="hidden sm:block font-caveat text-lg text-[#524B66] -rotate-1">pick your exact campaign vibe &darr;</span>
                </div>

                <!-- 5 Persona Bento Cards (Icon Left, Text Right, Soft Subtle Shadow) -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2.5 sm:gap-3">
                    
                    <!-- 1. All Talent -->
                    <a href="{{ route('influencers.public', array_merge(request()->except('talent_type', 'page'), ['talent_type' => 'all'])) }}"
                       class="rounded-2xl py-2.5 px-3 sm:py-3 sm:px-3.5 border border-[#181528]/80 transition-all duration-200 flex items-center gap-3 group relative {{ $currentType === 'all' || !$currentType ? 'bg-[#FF5722] text-white shadow-[2px_2px_0_#181528] -translate-y-0.5' : 'bg-white hover:bg-[#FAF5EC] text-[#181528] shadow-[1.5px_1.5px_0_#181528] hover:-translate-y-0.5' }}">
                        <span class="w-9 h-9 rounded-xl shrink-0 flex items-center justify-center border border-[#181528]/40 {{ $currentType === 'all' || !$currentType ? 'bg-white text-[#FF5722]' : 'bg-[#FAF5EC] text-[#181528]' }}">
                            <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-display font-black text-sm sm:text-base leading-tight mb-0.5 truncate">All Talent</h3>
                            <p class="text-[10px] sm:text-[11px] font-sans leading-tight truncate {{ $currentType === 'all' || !$currentType ? 'text-white/90' : 'text-[#524B66]' }}">Complete roster</p>
                        </div>
                    </a>

                    <!-- 2. Social Influencers -->
                    <a href="{{ route('influencers.public', array_merge(request()->except('talent_type', 'page'), ['talent_type' => 'influencer'])) }}"
                       class="rounded-2xl py-2.5 px-3 sm:py-3 sm:px-3.5 border border-[#181528]/80 transition-all duration-200 flex items-center gap-3 group relative {{ $currentType === 'influencer' ? 'bg-[#F47FA2] text-[#181528] shadow-[2px_2px_0_#181528] -translate-y-0.5' : 'bg-white hover:bg-[#FCE7EE] text-[#181528] shadow-[1.5px_1.5px_0_#181528] hover:-translate-y-0.5' }}">
                        <span class="w-9 h-9 rounded-xl shrink-0 flex items-center justify-center border border-[#181528]/40 bg-white text-[#8F1449]">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-display font-black text-sm sm:text-base leading-tight mb-0.5 truncate">Social Influencers</h3>
                            <p class="text-[10px] sm:text-[11px] font-sans leading-tight truncate text-[#181528]/80">Instagram &amp; Reels</p>
                        </div>
                    </a>

                    <!-- 3. UGC Creators -->
                    <a href="{{ route('influencers.public', array_merge(request()->except('talent_type', 'page'), ['talent_type' => 'ugc'])) }}"
                       class="rounded-2xl py-2.5 px-3 sm:py-3 sm:px-3.5 border border-[#181528]/80 transition-all duration-200 flex items-center gap-3 group relative {{ $currentType === 'ugc' ? 'bg-[#7EC4FB] text-[#181528] shadow-[2px_2px_0_#181528] -translate-y-0.5' : 'bg-white hover:bg-[#EAF5FE] text-[#181528] shadow-[1.5px_1.5px_0_#181528] hover:-translate-y-0.5' }}">
                        <span class="w-9 h-9 rounded-xl shrink-0 flex items-center justify-center border border-[#181528]/40 bg-white text-[#0E4875]">
                            <i class="fa-solid fa-video text-xs"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-display font-black text-sm sm:text-base leading-tight mb-0.5 truncate">UGC Creators</h3>
                            <p class="text-[10px] sm:text-[11px] font-sans leading-tight truncate text-[#181528]/80">Ad Video Creative</p>
                        </div>
                    </a>

                    <!-- 4. Fashion & Runway Models -->
                    <a href="{{ route('influencers.public', array_merge(request()->except('talent_type', 'page'), ['talent_type' => 'modeling'])) }}"
                       class="rounded-2xl py-2.5 px-3 sm:py-3 sm:px-3.5 border border-[#181528]/80 transition-all duration-200 flex items-center gap-3 group relative {{ $currentType === 'modeling' ? 'bg-[#FFF9AA] text-[#181528] shadow-[2px_2px_0_#181528] -translate-y-0.5' : 'bg-white hover:bg-[#FFFDE0] text-[#181528] shadow-[1.5px_1.5px_0_#181528] hover:-translate-y-0.5' }}">
                        <span class="w-9 h-9 rounded-xl shrink-0 flex items-center justify-center border border-[#181528]/40 bg-white text-[#FF3E14]">
                            <i class="fa-solid fa-camera text-xs"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-display font-black text-sm sm:text-base leading-tight mb-0.5 truncate">Fashion Models</h3>
                            <p class="text-[10px] sm:text-[11px] font-sans leading-tight truncate text-[#181528]/80">Lookbooks &amp; Shoots</p>
                        </div>
                    </a>

                    <!-- 5. Event Emcees & Anchors -->
                    <a href="{{ route('influencers.public', array_merge(request()->except('talent_type', 'page'), ['talent_type' => 'anchor'])) }}"
                       class="col-span-2 md:col-span-1 rounded-2xl py-2.5 px-3 sm:py-3 sm:px-3.5 border border-[#181528]/80 transition-all duration-200 flex items-center gap-3 group relative {{ $currentType === 'anchor' ? 'bg-[#BDB0FC] text-[#181528] shadow-[2px_2px_0_#181528] -translate-y-0.5' : 'bg-white hover:bg-[#F1EEFD] text-[#181528] shadow-[1.5px_1.5px_0_#181528] hover:-translate-y-0.5' }}">
                        <span class="w-9 h-9 rounded-xl shrink-0 flex items-center justify-center border border-[#181528]/40 bg-white text-[#3B2485]">
                            <i class="fa-solid fa-microphone-lines text-xs"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-display font-black text-sm sm:text-base leading-tight mb-0.5 truncate">Event Anchors</h3>
                            <p class="text-[10px] sm:text-[11px] font-sans leading-tight truncate text-[#181528]/80">Stage &amp; Live Hosts</p>
                        </div>
                    </a>

                </div>

            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- SECTION 3: SEARCH COMMAND BAR & ADVANCED FILTER DRAWER                    -->
        <!-- ========================================================================= -->
        <section class="py-4 sm:py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
                
                <!-- Main Search Card Deck -->
                <form method="GET" action="{{ route('influencers.public') }}" class="bg-white p-5 sm:p-6 rounded-[32px] border-2 border-[#181528] shadow-[6px_6px_0_#181528] space-y-4">
                    <input type="hidden" name="talent_type" value="{{ $currentType }}">
                    <input type="hidden" name="niche" value="{{ $currentNiche }}">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5">
                        
                        <!-- Search Keyword Field -->
                        <div class="lg:col-span-5">
                         
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#827B96]">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Keyword, Name or City." class="w-full bg-[#FAF5EC] border-2 border-[#181528] rounded-2xl pl-10 pr-4 py-2.5 text-xs sm:text-sm font-semibold text-[#181528] placeholder-[#827B96] focus:outline-none focus:bg-white focus:shadow-[3px_3px_0_#181528] transition">
                            </div>
                        </div>

                        <!-- City Selection -->
                        <div class="lg:col-span-3">
                            
                            <select name="city" class="w-full bg-[#FAF5EC] border-2 border-[#181528] rounded-2xl px-3.5 py-2.5 text-xs sm:text-sm text-[#181528] font-bold focus:outline-none focus:bg-white focus:shadow-[3px_3px_0_#181528] transition">
                                <option value="">All Locations &amp; Cities</option>
                                <option value="Nashik" selected
                                
                                
                                {{ request('city') === 'Nashik' ? 'selected' : '' }}>Nashik Hub, MH</option>
                                <option value="Mumbai" {{ request('city') === 'Mumbai' ? 'selected' : '' }}>Mumbai Hub, MH</option>
                                <option value="Pune" {{ request('city') === 'Pune' ? 'selected' : '' }}>Pune Hub, MH</option>
                                <option value="Delhi" {{ request('city') === 'Delhi' ? 'selected' : '' }}>Delhi NCR</option>
                                <option value="Bangalore" {{ request('city') === 'Bangalore' ? 'selected' : '' }}>Bangalore Hub</option>
                                <option value="Hyderabad" {{ request('city') === 'Hyderabad' ? 'selected' : '' }}>Hyderabad Hub</option>
                                <option value="Remote" {{ request('city') === 'Remote' ? 'selected' : '' }}>Remote / Pan-India</option>
                            </select>
                        </div>

                        <!-- Deliverable Format -->
                        <div class="lg:col-span-2">
                           
                            <select name="deliverable" class="w-full bg-[#FAF5EC] border-2 border-[#181528] rounded-2xl px-3.5 py-2.5 text-xs sm:text-sm text-[#181528] font-bold focus:outline-none focus:bg-white focus:shadow-[3px_3px_0_#181528] transition">
                                <option value="all">All Deliverables</option>
                                <option value="reel" {{ request('deliverable') === 'reel' ? 'selected' : '' }}>Instagram Reel</option>
                                <option value="ugc" {{ request('deliverable') === 'ugc' ? 'selected' : '' }}>UGC Ad Video</option>
                                <option value="youtube" {{ request('deliverable') === 'youtube' ? 'selected' : '' }}>YouTube Video</option>
                                <option value="story" {{ request('deliverable') === 'story' ? 'selected' : '' }}>Story Set</option>
                                <option value="shoot" {{ request('deliverable') === 'shoot' ? 'selected' : '' }}>Photoshoot / Day</option>
                            </select>
                        </div>

                        <!-- Toggle Advanced & Submit Buttons -->
                        <div class="lg:col-span-2 flex items-end space-x-2">
                            <button type="button" @click="showAdvanced = !showAdvanced" class="hm-btn px-3.5 py-2.5 bg-white hover:bg-[#FAF5EC] text-[#181528] border-2 border-[#181528] text-xs font-black font-display rounded-2xl transition flex-shrink-0 flex items-center space-x-1.5 shadow-[3px_3px_0_#181528]" title="Toggle advanced filters">
                                <i class="fa-solid fa-sliders text-[#524B66]"></i>
                                <span x-text="showAdvanced ? '▲' : '▼'"></span>
                            </button>
                            <button type="submit" class="hm-btn flex-grow py-2.5 px-4 rounded-2xl bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] border-2 border-[#181528] font-black font-display text-xs sm:text-sm shadow-[4px_4px_0_#181528] transition text-center flex items-center justify-center space-x-2">
                                <span>Filter</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </button>
                        </div>

                    </div>

                    <!-- Expandable Advanced Studio Drawer -->
                    <div x-show="showAdvanced" x-cloak x-transition class="pt-5 border-t-2 border-[#181528]/15 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                        <!-- Follower Reach Bracket -->
                        <div>
                            <label class="block font-mono font-black text-[#524B66] uppercase text-[10px] mb-1">Follower Reach Bracket</label>
                            <select name="follower_bracket" class="w-full bg-[#FAF5EC] border-2 border-[#181528] rounded-xl p-2.5 font-bold text-[#181528] focus:bg-white transition">
                                <option value="all">Any Reach Size</option>
                                <option value="nano" {{ request('follower_bracket') === 'nano' ? 'selected' : '' }}>Nano (&lt; 10K)</option>
                                <option value="micro" {{ request('follower_bracket') === 'micro' ? 'selected' : '' }}>Micro (10K - 50K)</option>
                                <option value="mid" {{ request('follower_bracket') === 'mid' ? 'selected' : '' }}>Mid-Tier (50K - 250K)</option>
                                <option value="macro" {{ request('follower_bracket') === 'macro' ? 'selected' : '' }}>Macro (250K - 1M)</option>
                                <option value="celebrity" {{ request('follower_bracket') === 'celebrity' ? 'selected' : '' }}>Celebrity (1M+)</option>
                            </select>
                        </div>

                        <!-- Minimum Engagement Rate -->
                        <div>
                            <label class="block font-mono font-black text-[#524B66] uppercase text-[10px] mb-1">Min. Engagement Rate</label>
                            <select name="min_engagement" class="w-full bg-[#FAF5EC] border-2 border-[#181528] rounded-xl p-2.5 font-bold text-[#181528] focus:bg-white transition">
                                <option value="">Any Engagement Rate</option>
                                <option value="2.0" {{ request('min_engagement') == '2.0' ? 'selected' : '' }}>&gt; 2.0% (Solid)</option>
                                <option value="4.0" {{ request('min_engagement') == '4.0' ? 'selected' : '' }}>&gt; 4.0% (High Viral)</option>
                                <option value="6.0" {{ request('min_engagement') == '6.0' ? 'selected' : '' }}>&gt; 6.0% (Top Tier)</option>
                            </select>
                        </div>

                        <!-- Verification Tier -->
                        <div>
                            <label class="block font-mono font-black text-[#524B66] uppercase text-[10px] mb-1">Verification Level</label>
                            <select name="verification_level" class="w-full bg-[#FAF5EC] border-2 border-[#181528] rounded-xl p-2.5 font-bold text-[#181528] focus:bg-white transition">
                                <option value="all">All Verification Levels</option>
                                <option value="1" {{ request('verification_level') == '1' ? 'selected' : '' }}>Level 1+ (Basic Authenticated)</option>
                                <option value="2" {{ request('verification_level') == '2' ? 'selected' : '' }}>Level 2+ (Phone Verified)</option>
                                <option value="3" {{ request('verification_level') == '3' ? 'selected' : '' }}>Level 3+ (Govt ID Verified)</option>
                                <option value="4" {{ request('verification_level') == '4' ? 'selected' : '' }}>Level 4+ (Portfolio Pro)</option>
                                <option value="5" {{ request('verification_level') == '5' ? 'selected' : '' }}>Level 5 (Platform Elite)</option>
                            </select>
                        </div>

                        <!-- Booking Availability -->
                        <div>
                            <label class="block font-mono font-black text-[#524B66] uppercase text-[10px] mb-1">Availability Status</label>
                            <select name="availability" class="w-full bg-[#FAF5EC] border-2 border-[#181528] rounded-xl p-2.5 font-bold text-[#181528] focus:bg-white transition">
                                <option value="all">All Availability</option>
                                <option value="available" {{ request('availability') === 'available' ? 'selected' : '' }}>Available for Work</option>
                                <option value="tentative" {{ request('availability') === 'tentative' ? 'selected' : '' }}>Reviewing Offers</option>
                                <option value="booked" {{ request('availability') === 'booked' ? 'selected' : '' }}>Busy on Shoots</option>
                            </select>
                        </div>

                        <!-- Gender Filter -->
                        <div>
                            <label class="block font-mono font-black text-[#524B66] uppercase text-[10px] mb-1">Gender</label>
                            <select name="gender" class="w-full bg-[#FAF5EC] border-2 border-[#181528] rounded-xl p-2.5 font-bold text-[#181528] focus:bg-white transition">
                                <option value="">Any Gender</option>
                                <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="non_binary" {{ request('gender') === 'non_binary' ? 'selected' : '' }}>Non-Binary</option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div>
                            <label class="block font-mono font-black text-[#524B66] uppercase text-[10px] mb-1">Sort Profiles</label>
                            <select name="sort" class="w-full bg-[#FAF5EC] border-2 border-[#181528] rounded-xl p-2.5 font-bold text-[#181528] focus:bg-white transition">
                                <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>Newest Profiles First</option>
                                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Highest Rated (★ 5.0)</option>
                                <option value="verification" {{ request('sort') === 'verification' ? 'selected' : '' }}>Top Verified Level First</option>
                            </select>
                        </div>

                        <!-- Price Negotiable Toggle -->
                        <div class="sm:col-span-2 flex items-center pt-2">
                            <label class="inline-flex items-center space-x-2.5 cursor-pointer font-bold text-xs text-[#181528] bg-[#FAF5EC] border-2 border-[#181528] rounded-xl px-4 py-2.5 shadow-[2px_2px_0_#181528] hover:bg-[#FFF9AA] transition">
                                <input type="checkbox" name="negotiable" value="1" {{ request('negotiable') ? 'checked' : '' }} class="rounded border-2 border-[#181528] text-[#FF3E14] focus:ring-[#FF3E14] w-4 h-4">
                                <i class="fa-solid fa-comments text-[#FF3E14]"></i>
                                <span>Show Creators Open to Negotiate Rates</span>
                            </label>
                        </div>
                    </div>
                </form>

                <!-- Niche Pills Strip -->
                <div class="pt-2">
                    <div class="flex items-center justify-between text-xs font-mono font-bold text-[#524B66] uppercase tracking-wider mb-2">
                        <span class="inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-tags text-[#FF3E14]"></i>
                            <span>Filter by Vertical:</span>
                        </span>
                        @if($currentNiche !== 'all' || $currentDeliverable !== 'all' || request('search') || request('city'))
                            <a href="{{ route('influencers.public') }}" class="text-[#FF3E14] hover:underline font-mono font-bold lowercase flex items-center gap-1">
                                <i class="fa-solid fa-rotate-left"></i> reset all filters
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 overflow-x-auto pb-2 no-scrollbar text-xs font-bold">
                        @php
                            $niches = [
                                'Beauty'    => ['label' => 'Clean Skincare & Beauty', 'icon' => 'fa-wand-magic-sparkles'],
                                'Tech'      => ['label' => 'B2B Tech & AI',           'icon' => 'fa-laptop-code'],
                                'Fitness'   => ['label' => 'Fitness & Wellness',      'icon' => 'fa-dumbbell'],
                                'Food'      => ['label' => 'Food & Quick Recipes',    'icon' => 'fa-utensils'],
                                'Fashion'   => ['label' => 'Fashion & Styling',       'icon' => 'fa-shirt'],
                                'Travel'    => ['label' => 'Travel & Lifestyle',      'icon' => 'fa-plane-departure'],
                                'Gaming'    => ['label' => 'Gaming & Streaming',      'icon' => 'fa-gamepad'],
                                'Parenting' => ['label' => 'Parenting & Family',      'icon' => 'fa-baby'],
                                'Finance'   => ['label' => 'Business & Finance',      'icon' => 'fa-chart-line'],
                                'Auto'      => ['label' => 'Auto & EV',               'icon' => 'fa-car'],
                            ];
                        @endphp

                        <a href="{{ route('influencers.public', array_merge(request()->except('niche', 'page'), ['niche' => 'all'])) }}"
                           class="px-3.5 py-1.5 rounded-xl whitespace-nowrap border-2 border-[#181528] transition-all flex items-center gap-1.5 {{ $currentNiche === 'all' || !$currentNiche ? 'bg-[#E2F163] text-[#181528] shadow-[2px_2px_0_#181528] font-black' : 'bg-white hover:bg-[#FAF5EC] text-[#524B66] shadow-[1.5px_1.5px_0_#181528]' }}">
                            <span>All Verticals</span>
                        </a>

                        @foreach($niches as $key => $nicheData)
                            <a href="{{ route('influencers.public', array_merge(request()->except('niche', 'page'), ['niche' => $key])) }}"
                               class="px-3.5 py-1.5 rounded-xl whitespace-nowrap border-2 border-[#181528] transition-all flex items-center gap-1.5 {{ $currentNiche === $key ? 'bg-[#FF3E14] text-white shadow-[2px_2px_0_#181528] font-black' : 'bg-white hover:bg-[#FAF5EC] text-[#181528] shadow-[1.5px_1.5px_0_#181528]' }}">
                                <i class="fa-solid {{ $nicheData['icon'] }} text-[10px]"></i>
                                <span>{{ $nicheData['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- SECTION 4: THE TALENT SHOWCASE GRID (MAGAZINE PORTFOLIO CARDS)            -->
        <!-- ========================================================================= -->
        <section class="py-8 min-h-[600px] pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <!-- Results Bar & Comparison Helper -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b-2 border-[#181528]/10">
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white border-2 border-[#181528] shadow-[3px_3px_0_#181528] text-xs font-mono font-black text-[#181528]">
                        <i class="fa-solid fa-users text-[#FF3E14]"></i>
                        <span>Showing <span class="text-[#FF3E14] tabular-nums font-black">{{ $talents->total() }}</span> Verified Creators</span>
                    </div>
                    
                    <div class="text-xs font-mono font-bold text-[#524B66] flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-[#10B981]"></i>
                        <span>Tick <strong class="text-[#181528] underline decoration-[#E2F163] decoration-2">Compare</strong> on up to 3 cards to view head-to-head metrics</span>
                    </div>
                </div>

                <!-- Responsive Neo-Brutalist Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @forelse($talents as $t)
                        @php
                            $avail = $t->availability_status ?? 'available';
                            $totFollowers = $t->socialAccounts->sum('followers');
                            $totViews = $t->socialAccounts->sum('views_30d') ?: (int) ($totFollowers * 3.2);
                            $avgER = $t->socialAccounts->avg('engagement_rate') ?: 4.2;
                            $startingRate = $t->rates->min('rate_amount') ?: 15000;
                            
                            $cardAccents = ['#E2F163', '#F47FA2', '#7EC4FB', '#BDB0FC', '#FF3E14'];
                            $accent = $cardAccents[$loop->index % count($cardAccents)];
                            
                            $photo = $t->profile_image ?: $fallbackImages[$loop->index % count($fallbackImages)];
                        @endphp

                        <div class="bg-white rounded-[32px] overflow-hidden border-2 border-[#181528] flex flex-col justify-between transition-all duration-300 hover:-translate-y-2 group relative"
                             style="box-shadow: 6px 6px 0 {{ $accent }};"
                             onmouseenter="this.style.boxShadow='9px 9px 0 #181528'"
                             onmouseleave="this.style.boxShadow='6px 6px 0 {{ $accent }}'">
                            
                            <!-- Card Top Image / Media Showcase Banner -->
                            <div class="relative h-64 sm:h-72 w-full overflow-hidden bg-[#181528]">
                                <img src="{{ $photo }}" alt="{{ $t->display_name ?: $t->user->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#181528]/90 via-transparent to-black/20 pointer-events-none"></div>

                                <!-- Top Left: Verification Level Badge -->
                                <div class="absolute top-3 left-3 flex items-center gap-1.5">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full border-2 border-[#181528] text-[10px] font-mono font-black shadow-[2px_2px_0_#181528] {{ $t->verification_level >= 4 ? 'bg-[#E2F163] text-[#181528]' : ($t->verification_level >= 3 ? 'bg-[#7EC4FB] text-[#181528]' : 'bg-white text-[#181528]') }}">
                                        <i class="fa-solid fa-certificate text-[10px] text-[#FF3E14]"></i>
                                        <span>L{{ $t->verification_level ?: 1 }} Verified</span>
                                    </span>
                                </div>

                                <!-- Top Right: Quick Compare Toggle Pill -->
                                <div class="absolute top-3 right-3">
                                    <label class="inline-flex items-center space-x-1.5 cursor-pointer text-[11px] font-mono font-bold text-[#181528] bg-white/95 backdrop-blur hover:bg-[#E2F163] px-3 py-1 rounded-xl border-2 border-[#181528] shadow-[2px_2px_0_#181528] transition select-none">
                                        <input type="checkbox" :checked="compareList.includes({{ $t->id }})" @change="toggleCompare({{ $t->id }})" class="rounded border-2 border-[#181528] text-[#FF3E14] focus:ring-[#FF3E14]">
                                        <span>Compare</span>
                                    </label>
                                </div>

                                <!-- Bottom Overlay: Availability + Negotiable -->
                                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white text-xs">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full border border-white/30 text-[10px] font-mono font-black backdrop-blur-sm {{ $avail === 'available' ? 'bg-[#10B981]/80' : ($avail === 'tentative' ? 'bg-[#F59E0B]/80' : 'bg-slate-700/80') }}">
                                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                        <span>{{ ucfirst($avail) }}</span>
                                    </span>

                                    @if($t->price_negotiable)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-mono font-black text-[#181528] bg-[#E2F163] px-2.5 py-0.5 rounded-full border border-[#181528] shadow-[1px_1px_0_#181528]">
                                            <i class="fa-solid fa-comments text-[10px]"></i> Negotiable
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Middle Body -->
                            <div class="p-5 sm:p-6 space-y-4 text-left">
                                
                                <!-- Identity Header -->
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <h3 class="font-black text-[#181528] text-xl sm:text-2xl group-hover:text-[#FF3E14] transition font-display leading-tight line-clamp-1">
                                                {{ $t->display_name ?: $t->user->name }}
                                            </h3>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs text-[#FF3E14] font-mono font-bold">@ {{ $t->username }}</span>
                                                <span class="text-slate-300">&bull;</span>
                                                <span class="inline-flex items-center gap-1 text-[11px] font-mono font-bold text-[#524B66]">
                                                    <i class="fa-solid fa-location-dot text-[#FF3E14] text-[10px]"></i>
                                                    <span>{{ $t->city ?: 'Nashik' }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bio Snippet -->
                                <p class="text-[#524B66] text-xs font-sans line-clamp-2 leading-relaxed">
                                    {{ $t->bio ?: 'Professional verified talent available for brand commercial shoots, digital reels, and activations.' }}
                                </p>

                                <!-- Niche & Category Tags -->
                                <div class="flex flex-wrap gap-1.5 text-[11px] font-medium">
                                    @if(!empty($t->primary_categories))
                                        @foreach(array_slice((array)$t->primary_categories, 0, 2) as $cat)
                                            <span class="px-2.5 py-0.5 bg-[#FAF5EC] border border-[#181528] text-[#181528] rounded-lg font-bold shadow-[1.5px_1.5px_0_#181528]">
                                                {{ $cat }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="px-2.5 py-0.5 bg-[#FCE7EE] border border-[#181528] text-[#181528] rounded-lg font-bold shadow-[1.5px_1.5px_0_#181528]">
                                            Fashion &amp; Lifestyle
                                        </span>
                                    @endif
                                </div>

                                <!-- 3-Metric Performance Bar -->
                                <div class="bg-[#FAF5EC] border-2 border-[#181528] rounded-2xl p-2.5 sm:p-3 grid grid-cols-3 gap-2 text-center shadow-[2px_2px_0_#181528]">
                                    
                                    <!-- Reach -->
                                    <div class="border-r border-[#181528]/15 pr-1">
                                        <span class="text-[9px] uppercase font-mono font-black text-[#827B96] block">Reach</span>
                                        <span class="text-xs sm:text-sm font-black font-display text-[#181528] tabular-nums">
                                            {{ $totFollowers ? number_format($totFollowers) : '185K+' }}
                                        </span>
                                    </div>

                                    <!-- Engagement Rate -->
                                    <div class="border-r border-[#181528]/15 px-1">
                                        <span class="text-[9px] uppercase font-mono font-black text-[#827B96] block">Avg ER</span>
                                        <span class="text-xs sm:text-sm font-black font-display text-[#FF3E14] tabular-nums flex items-center justify-center gap-1">
                                            <i class="fa-solid fa-fire text-[10px]"></i>
                                            <span>{{ number_format($avgER, 1) }}%</span>
                                        </span>
                                    </div>

                                    <!-- Rating -->
                                    <div class="pl-1">
                                        <span class="text-[9px] uppercase font-mono font-black text-[#827B96] block">Rating</span>
                                        <span class="text-xs sm:text-sm font-black font-display text-[#181528] flex items-center justify-center gap-1">
                                            <i class="fa-solid fa-star text-amber-500 text-[10px]"></i>
                                            <span>{{ number_format($t->rating_avg ?: 5.0, 1) }}</span>
                                        </span>
                                    </div>

                                </div>

                            </div>

                            <!-- Card Action Footer -->
                            <div class="p-5 sm:p-6 pt-0 flex items-center justify-between border-t border-[#181528]/10 mt-2">
                                <div>
                                    <span class="text-[9px] uppercase font-mono font-black text-[#827B96] block">Starting Rate</span>
                                    <span class="text-base sm:text-lg font-black text-[#181528] font-display tabular-nums">
                                        ₹{{ number_format($startingRate) }}
                                    </span>
                                </div>
                                <a href="{{ route('influencers.public.show', $t->username ?: $t->id) }}" class="hm-btn px-4 py-2 rounded-xl bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] text-xs font-display font-black border-2 border-[#181528] shadow-[3px_3px_0_#181528] flex items-center space-x-1.5 transition">
                                    <span>View Media Kit</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>

                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 bg-white rounded-[32px] border-2 border-dashed border-[#181528] shadow-[8px_8px_0_#181528] space-y-4">
                            <div class="w-16 h-16 mx-auto rounded-full bg-[#FAF5EC] border-2 border-[#181528] flex items-center justify-center text-[#181528] shadow-[3px_3px_0_#181528]">
                                <i class="fa-solid fa-user-slash text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-black text-[#181528] font-display">No matching creators found</h3>
                            <p class="text-[#524B66] text-xs max-w-sm mx-auto font-medium">Try broadening your search criteria or resetting filters to discover more talent.</p>
                            <a href="{{ route('influencers.public') }}" class="hm-btn inline-block mt-2 px-6 py-2.5 bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] font-display font-black text-xs rounded-xl border-2 border-[#181528] shadow-[4px_4px_0_#181528] transition">
                                Reset All Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Custom Styled Pagination -->
                <div class="pt-8 flex justify-center">
                    {{ $talents->links() }}
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- SECTION 5: "CAN'T FIND WHO YOU NEED?" POST A BRIEF BANNER                 -->
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
                            <span>CUSTOM CASTING BRIEF</span>
                        </span>

                        <h2 class="font-display font-extrabold text-3xl sm:text-5xl text-white tracking-tight leading-[1.05]">
                            Can't Find The Exact Vibe For Your Campaign?
                        </h2>

                        <p class="text-white/80 text-sm sm:text-base font-sans leading-relaxed">
                            Post an open brief in 2 minutes. Pre-vetted creators matching your exact niche, city, and follower criteria will pitch directly to your brand dashboard with tailored rates and portfolios.
                        </p>

                        <div class="flex flex-wrap items-center gap-4 pt-4">
                            <a href="{{ route('campaigns.public') }}" class="hm-btn px-7 py-3.5 rounded-full bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] border-2 border-[#181528] font-display font-black text-sm shadow-[4px_4px_0_#FFFFFF] transition flex items-center space-x-2">
                                <span>Browse Open Campaign Briefs</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                            <a href="{{ route('pricing') }}" class="hm-btn px-6 py-3.5 rounded-full bg-white/10 hover:bg-white/20 text-white border-2 border-white/30 font-display font-black text-sm transition">
                                <span>Estimate Escrow Budget &rarr;</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- FLOATING COMPARISON STICKY BAR & COMPARISON MODAL                         -->
        <!-- ========================================================================= -->
        
        <!-- Sticky Floating Comparison Dock -->
        <div x-show="compareList.length > 0" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100" class="fixed bottom-6 inset-x-0 z-40 max-w-2xl mx-auto px-4">
            <div class="bg-[#181528] text-white p-4 rounded-2xl shadow-[6px_6px_0_#E2F163] border-2 border-[#181528] flex items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-full bg-[#E2F163] text-[#181528] border border-[#181528] flex items-center justify-center font-display font-black text-xs shadow-[1.5px_1.5px_0_#FFFFFF]" x-text="compareList.length"></span>
                    <span class="text-xs sm:text-sm font-display font-black text-[#E2F163]">Creators selected for comparison</span>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="button" @click="compareList = []" class="px-3.5 py-1.5 text-xs text-white/70 hover:text-white font-mono font-bold transition">
                        Clear
                    </button>
                    <button type="button" @click="openCompareModal()" class="hm-btn px-4 py-2 bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] text-xs font-display font-black rounded-xl border-2 border-[#181528] shadow-[3px_3px_0_#FFFFFF] transition">
                        Compare Now &rarr;
                    </button>
                </div>
            </div>
        </div>

        <!-- Side-by-Side Comparison Slide-Over Modal -->
        <div x-show="compareModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-[#181528]/70 backdrop-blur-md flex items-center justify-center p-4">
            <div @click.away="compareModalOpen = false" class="bg-white w-full max-w-4xl rounded-[32px] border-3 border-[#181528] shadow-[12px_12px_0_#181528] overflow-hidden flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="p-6 border-b-2 border-[#181528]/15 flex items-center justify-between bg-[#FAF5EC]">
                    <div>
                        <h2 class="text-xl font-black font-display text-[#181528]">Talent Comparison Matrix</h2>
                        <p class="text-xs font-mono font-bold text-[#524B66]">Side-by-side comparison of reach, engagement, rates, and verified tier.</p>
                    </div>
                    <button type="button" @click="compareModalOpen = false" class="w-9 h-9 rounded-full bg-white hover:bg-[#FFEBE6] text-[#181528] border-2 border-[#181528] shadow-[2px_2px_0_#181528] flex items-center justify-center text-sm font-bold transition">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto space-y-6">
                    <div x-show="loadingCompare" class="text-center py-12 text-[#524B66] font-mono text-sm font-bold">
                        <i class="fa-solid fa-spinner fa-spin text-xl text-[#FF3E14] block mb-2"></i>
                        Loading creator statistics...
                    </div>

                    <div x-show="!loadingCompare && compareData.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <template x-for="item in compareData" :key="item.id">
                            <div class="bg-[#FAF5EC] rounded-2xl p-5 border-2 border-[#181528] shadow-[4px_4px_0_#181528] space-y-4 flex flex-col justify-between">
                                <div class="space-y-3">
                                    <div class="flex items-center space-x-3">
                                        <img :src="item.avatar" class="w-14 h-14 rounded-xl object-cover border-2 border-[#181528] shadow-[2px_2px_0_#181528]">
                                        <div class="min-w-0">
                                            <h4 class="font-black text-[#181528] text-sm font-display truncate" x-text="item.name"></h4>
                                            <p class="text-xs text-[#FF3E14] font-mono font-bold truncate" x-text="'@' + item.username"></p>
                                        </div>
                                    </div>

                                    <div class="space-y-2 pt-2 text-xs font-mono">
                                        <div class="flex justify-between py-1.5 border-b border-[#181528]/10">
                                            <span class="text-[#524B66]">Location</span>
                                            <span class="font-bold text-[#181528]" x-text="item.city"></span>
                                        </div>
                                        <div class="flex justify-between py-1.5 border-b border-[#181528]/10">
                                            <span class="text-[#524B66]">Total Reach</span>
                                            <span class="font-black text-[#181528] tabular-nums" x-text="item.total_followers.toLocaleString()"></span>
                                        </div>
                                        <div class="flex justify-between py-1.5 border-b border-[#181528]/10">
                                            <span class="text-[#524B66]">Avg ER</span>
                                            <span class="font-black text-[#FF3E14] tabular-nums" x-text="item.engagement_rate + '%'"></span>
                                        </div>
                                        <div class="flex justify-between py-1.5 border-b border-[#181528]/10">
                                            <span class="text-[#524B66]">Starting Rate</span>
                                            <span class="font-black text-[#181528] tabular-nums" x-text="item.starting_rate"></span>
                                        </div>
                                        <div class="flex justify-between py-1.5 border-b border-[#181528]/10">
                                            <span class="text-[#524B66]">Rating</span>
                                            <span class="font-black text-amber-600" x-text="'★ ' + item.rating.toFixed(1)"></span>
                                        </div>
                                    </div>
                                </div>

                                <a :href="item.profile_url" class="hm-btn w-full py-2.5 bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] text-xs font-display font-black rounded-xl border-2 border-[#181528] text-center shadow-[3px_3px_0_#181528] transition block">
                                    View Full Media Kit
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
