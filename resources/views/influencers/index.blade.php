@extends('layouts.app')

@section('title', 'Verified Talent Directory — Models, Influencers, Anchors & UGC Creators | Talent Marketplace')

@section('content')
    <div x-data="{
        showAdvanced: {{ request()->hasAny(['follower_bracket', 'verification_level', 'availability', 'negotiable', 'modeling_category', 'event_type', 'min_engagement', 'deliverable', 'sort']) ? 'true' : 'false' }},
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

        <!-- Directory Header & Multi-Persona Filter Suite -->
        <section class="py-10 lg:py-14 bg-white border-b border-slate-200 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <!-- Header Text -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="max-w-3xl space-y-2">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-xs font-bold uppercase tracking-wider">
                            <i data-lucide="zap" class="w-3.5 h-3.5"></i> <span>Precision Talent Discovery</span>
                        </div>
                        <h1 class="text-3xl sm:text-5xl font-black font-display text-slate-900 tracking-tight">
                            Find the <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-indigo-600">Right Niche Creator</span> for Your Brand
                        </h1>
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                            Search through pre-vetted creators, fashion models, and UGC video specialists filtered by verified reach, engagement rates, and exact industry vertical.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 text-xs font-semibold">
                        <a href="{{ route('pricing') }}" class="px-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl transition flex items-center space-x-1.5 shadow-2xs">
                            <i data-lucide="calculator" class="w-4 h-4 text-indigo-600"></i>
                            <span>Creator Rate Calculator</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Persona Navigation Tabs -->
                @php
                    $currentType = request('talent_type', 'all');
                    $currentNiche = request('niche', 'all');
                    $currentDeliverable = request('deliverable', 'all');
                @endphp
                <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-100 text-xs sm:text-sm font-bold no-scrollbar">
                    <a href="{{ route('influencers.public', array_merge(request()->except('talent_type', 'page'), ['talent_type' => 'all'])) }}"
                       class="px-4 py-2.5 rounded-xl transition whitespace-nowrap flex items-center space-x-2 {{ $currentType === 'all' || !$currentType ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200' }}">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                        <span>All Talent</span>
                    </a>
                    <a href="{{ route('influencers.public', array_merge(request()->except('talent_type', 'page'), ['talent_type' => 'influencer'])) }}"
                       class="px-4 py-2.5 rounded-xl transition whitespace-nowrap flex items-center space-x-2 {{ $currentType === 'influencer' ? 'bg-brand-600 text-white shadow-xs' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200' }}">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                        <span>Social Influencers</span>
                    </a>
                    <a href="{{ route('influencers.public', array_merge(request()->except('talent_type', 'page'), ['talent_type' => 'ugc'])) }}"
                       class="px-4 py-2.5 rounded-xl transition whitespace-nowrap flex items-center space-x-2 {{ $currentType === 'ugc' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200' }}">
                        <i data-lucide="video" class="w-4 h-4"></i>
                        <span>UGC Creators</span>
                    </a>
                    <a href="{{ route('influencers.public', array_merge(request()->except('talent_type', 'page'), ['talent_type' => 'modeling'])) }}"
                       class="px-4 py-2.5 rounded-xl transition whitespace-nowrap flex items-center space-x-2 {{ $currentType === 'modeling' ? 'bg-pink-600 text-white shadow-xs' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200' }}">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                        <span>Fashion & Runway Models</span>
                    </a>
                    <a href="{{ route('influencers.public', array_merge(request()->except('talent_type', 'page'), ['talent_type' => 'anchor'])) }}"
                       class="px-4 py-2.5 rounded-xl transition whitespace-nowrap flex items-center space-x-2 {{ $currentType === 'anchor' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200' }}">
                        <i data-lucide="mic" class="w-4 h-4"></i>
                        <span>Event Emcees & Anchors</span>
                    </a>
                </div>

                <!-- Niche & Industry Filter Strip -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <span class="inline-flex items-center gap-1.5"><i data-lucide="target" class="w-3.5 h-3.5 text-brand-600"></i> Popular Vertical / Niche:</span>
                        @if($currentNiche !== 'all' || $currentDeliverable !== 'all')
                            <a href="{{ route('influencers.public', request()->except('niche', 'deliverable', 'page')) }}" class="text-brand-600 hover:text-brand-700 lowercase">clear niche filters</a>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 no-scrollbar text-xs font-semibold">
                        @php
                            $niches = [
                                'Beauty' => 'Clean Skincare & Beauty',
                                'Tech' => 'B2B Tech & AI',
                                'Fitness' => 'Fitness & Wellness',
                                'Food' => 'Food & Quick Recipes',
                                'Fashion' => 'Fashion & Styling',
                                'Travel' => 'Travel & Lifestyle',
                                'Gaming' => 'Gaming & Streaming',
                                'Parenting' => 'Parenting & Family',
                                'Finance' => 'Business & Finance',
                                'Auto' => 'Auto & EV',
                            ];
                        @endphp
                        <a href="{{ route('influencers.public', array_merge(request()->except('niche', 'page'), ['niche' => 'all'])) }}"
                           class="px-3 py-1.5 rounded-lg whitespace-nowrap transition {{ $currentNiche === 'all' || !$currentNiche ? 'bg-brand-50 text-brand-700 border border-brand-300 font-bold' : 'bg-slate-100 hover:bg-slate-200 text-slate-600 border border-slate-200' }}">
                            All Niches
                        </a>
                        @foreach($niches as $key => $label)
                            <a href="{{ route('influencers.public', array_merge(request()->except('niche', 'page'), ['niche' => $key])) }}"
                               class="px-3 py-1.5 rounded-lg whitespace-nowrap transition {{ $currentNiche === $key ? 'bg-brand-600 text-white font-bold shadow-2xs' : 'bg-slate-50 hover:bg-brand-50 hover:text-brand-700 text-slate-700 border border-slate-200' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Primary Search & Filter Bar -->
                <form method="GET" action="{{ route('influencers.public') }}" class="bg-slate-50/90 p-4 sm:p-5 rounded-3xl border border-slate-200 shadow-2xs space-y-4">
                    <input type="hidden" name="talent_type" value="{{ $currentType }}">
                    <input type="hidden" name="niche" value="{{ $currentNiche }}">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
                        <!-- Search Field -->
                        <div class="lg:col-span-4">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i data-lucide="search" class="w-4 h-4"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, handle, city (e.g. Nashik), or keywords..." class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 transition font-medium shadow-2xs">
                            </div>
                        </div>

                        <!-- City Selection -->
                        <div class="lg:col-span-3">
                            <select name="city" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 transition shadow-2xs">
                                <option value="">All Cities & Locations</option>
                                <option value="Nashik" {{ request('city') === 'Nashik' ? 'selected' : '' }}>Nashik, Maharashtra</option>
                                <option value="Mumbai" {{ request('city') === 'Mumbai' ? 'selected' : '' }}>Mumbai, Maharashtra</option>
                                <option value="Pune" {{ request('city') === 'Pune' ? 'selected' : '' }}>Pune, Maharashtra</option>
                                <option value="Delhi" {{ request('city') === 'Delhi' ? 'selected' : '' }}>Delhi NCR</option>
                                <option value="Bangalore" {{ request('city') === 'Bangalore' ? 'selected' : '' }}>Bangalore</option>
                                <option value="Hyderabad" {{ request('city') === 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
                                <option value="Remote" {{ request('city') === 'Remote' ? 'selected' : '' }}>Remote / Pan-India</option>
                            </select>
                        </div>

                        <!-- Deliverable Format Filter -->
                        <div class="lg:col-span-2">
                            <select name="deliverable" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 transition shadow-2xs">
                                <option value="all">All Formats</option>
                                <option value="reel" {{ request('deliverable') === 'reel' ? 'selected' : '' }}>Instagram Reel</option>
                                <option value="ugc" {{ request('deliverable') === 'ugc' ? 'selected' : '' }}>UGC Video</option>
                                <option value="youtube" {{ request('deliverable') === 'youtube' ? 'selected' : '' }}>YouTube Video</option>
                                <option value="story" {{ request('deliverable') === 'story' ? 'selected' : '' }}>Story Set</option>
                                <option value="shoot" {{ request('deliverable') === 'shoot' ? 'selected' : '' }}>Photoshoot / Day</option>
                            </select>
                        </div>

                        <!-- Toggle Advanced Filters & Submit -->
                        <div class="lg:col-span-3 flex items-center space-x-2">
                            <button type="button" @click="showAdvanced = !showAdvanced" class="px-3.5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold rounded-xl transition flex-shrink-0 flex items-center space-x-1.5 shadow-2xs">
                                <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5 text-slate-500"></i>
                                <span>Filters</span>
                                <span x-text="showAdvanced ? '▲' : '▼'"></span>
                            </button>
                            <button type="submit" class="flex-grow py-2.5 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm shadow-sm transition text-center">
                                Search Talent
                            </button>
                        </div>
                    </div>

                    <!-- Advanced Filter Drawer -->
                    <div x-show="showAdvanced" x-cloak x-transition class="pt-4 border-t border-slate-200 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                        <!-- Follower Reach Bracket -->
                        <div>
                            <label class="block font-bold text-slate-600 uppercase text-[10px] mb-1">Follower Reach</label>
                            <select name="follower_bracket" class="w-full bg-white border border-slate-200 rounded-xl p-2.5 font-medium text-slate-800">
                                <option value="all">Any Reach</option>
                                <option value="nano" {{ request('follower_bracket') === 'nano' ? 'selected' : '' }}>Nano (&lt; 10K)</option>
                                <option value="micro" {{ request('follower_bracket') === 'micro' ? 'selected' : '' }}>Micro (10K - 50K)</option>
                                <option value="mid" {{ request('follower_bracket') === 'mid' ? 'selected' : '' }}>Mid-Tier (50K - 250K)</option>
                                <option value="macro" {{ request('follower_bracket') === 'macro' ? 'selected' : '' }}>Macro (250K - 1M)</option>
                                <option value="celebrity" {{ request('follower_bracket') === 'celebrity' ? 'selected' : '' }}>Celebrity (1M+)</option>
                            </select>
                        </div>

                        <!-- Minimum Engagement Rate -->
                        <div>
                            <label class="block font-bold text-slate-600 uppercase text-[10px] mb-1">Min. Engagement Rate</label>
                            <select name="min_engagement" class="w-full bg-white border border-slate-200 rounded-xl p-2.5 font-medium text-slate-800">
                                <option value="">Any Engagement</option>
                                <option value="2.0" {{ request('min_engagement') == '2.0' ? 'selected' : '' }}>&gt; 2.0% (Good)</option>
                                <option value="4.0" {{ request('min_engagement') == '4.0' ? 'selected' : '' }}>&gt; 4.0% (High)</option>
                                <option value="6.0" {{ request('min_engagement') == '6.0' ? 'selected' : '' }}>&gt; 6.0% (Viral / Super)</option>
                            </select>
                        </div>

                        <!-- Verification Badge Level -->
                        <div>
                            <label class="block font-bold text-slate-600 uppercase text-[10px] mb-1">Verification Tier</label>
                            <select name="verification_level" class="w-full bg-white border border-slate-200 rounded-xl p-2.5 font-medium text-slate-800">
                                <option value="all">All Verification Levels</option>
                                <option value="1" {{ request('verification_level') == '1' ? 'selected' : '' }}>Level 1+ (Basic)</option>
                                <option value="2" {{ request('verification_level') == '2' ? 'selected' : '' }}>Level 2+ (Social Authenticated)</option>
                                <option value="3" {{ request('verification_level') == '3' ? 'selected' : '' }}>Level 3+ (Govt ID Verified)</option>
                                <option value="4" {{ request('verification_level') == '4' ? 'selected' : '' }}>Level 4+ (Top Performer)</option>
                                <option value="5" {{ request('verification_level') == '5' ? 'selected' : '' }}>Level 5 (Celebrity)</option>
                            </select>
                        </div>

                        <!-- Availability Status -->
                        <div>
                            <label class="block font-bold text-slate-600 uppercase text-[10px] mb-1">Booking Availability</label>
                            <select name="availability" class="w-full bg-white border border-slate-200 rounded-xl p-2.5 font-medium text-slate-800">
                                <option value="all">All Availability</option>
                                <option value="available" {{ request('availability') === 'available' ? 'selected' : '' }}>Available for Work</option>
                                <option value="tentative" {{ request('availability') === 'tentative' ? 'selected' : '' }}>Reviewing Offers</option>
                                <option value="booked" {{ request('availability') === 'booked' ? 'selected' : '' }}>Busy on Shoots</option>
                            </select>
                        </div>

                        <!-- Gender Filter -->
                        <div>
                            <label class="block font-bold text-slate-600 uppercase text-[10px] mb-1">Gender</label>
                            <select name="gender" class="w-full bg-white border border-slate-200 rounded-xl p-2.5 font-medium text-slate-800">
                                <option value="">Any Gender</option>
                                <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="non_binary" {{ request('gender') === 'non_binary' ? 'selected' : '' }}>Non-Binary</option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div>
                            <label class="block font-bold text-slate-600 uppercase text-[10px] mb-1">Sort Results</label>
                            <select name="sort" class="w-full bg-white border border-slate-200 rounded-xl p-2.5 font-medium text-slate-800">
                                <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>Newest Profiles</option>
                                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Highest Rated (5.0)</option>
                                <option value="verification" {{ request('sort') === 'verification' ? 'selected' : '' }}>Top Verified First</option>
                            </select>
                        </div>

                        <!-- Price Negotiable Toggle -->
                        <div class="sm:col-span-2 flex items-center space-x-2 pt-4">
                            <label class="inline-flex items-center space-x-2 cursor-pointer font-bold text-slate-700">
                                <input type="checkbox" name="negotiable" value="1" {{ request('negotiable') ? 'checked' : '' }} class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                <i data-lucide="message-square" class="w-3.5 h-3.5 text-brand-600"></i>
                                <span>Open to Negotiate Rates</span>
                            </label>
                        </div>
                    </div>
                </form>

                <!-- Quick Regional Hub Chips -->
                <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
                    <span class="text-slate-400 font-semibold">Popular Hubs:</span>
                    <a href="{{ route('influencers.public', array_merge(request()->except('city', 'search', 'page'), ['city' => 'Nashik'])) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-slate-100 hover:bg-brand-50 hover:text-brand-700 border border-slate-200 text-slate-700 font-medium transition {{ request('city') === 'Nashik' ? 'bg-brand-50 border-brand-300 text-brand-700 font-bold' : '' }}">
                        <i data-lucide="map-pin" class="w-3 h-3 text-slate-500"></i> Nashik Hub
                    </a>
                    <a href="{{ route('influencers.public', array_merge(request()->except('city', 'search', 'page'), ['city' => 'Mumbai'])) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-slate-100 hover:bg-brand-50 hover:text-brand-700 border border-slate-200 text-slate-700 font-medium transition {{ request('city') === 'Mumbai' ? 'bg-brand-50 border-brand-300 text-brand-700 font-bold' : '' }}">
                        <i data-lucide="map-pin" class="w-3 h-3 text-slate-500"></i> Mumbai Hub
                    </a>
                    <a href="{{ route('influencers.public', array_merge(request()->except('city', 'search', 'page'), ['city' => 'Pune'])) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-slate-100 hover:bg-brand-50 hover:text-brand-700 border border-slate-200 text-slate-700 font-medium transition {{ request('city') === 'Pune' ? 'bg-brand-50 border-brand-300 text-brand-700 font-bold' : '' }}">
                        <i data-lucide="map-pin" class="w-3 h-3 text-slate-500"></i> Pune Hub
                    </a>
                    <a href="{{ route('influencers.public', array_merge(request()->except('city', 'search', 'page'), ['city' => 'Bangalore'])) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-slate-100 hover:bg-brand-50 hover:text-brand-700 border border-slate-200 text-slate-700 font-medium transition {{ request('city') === 'Bangalore' ? 'bg-brand-50 border-brand-300 text-brand-700 font-bold' : '' }}">
                        <i data-lucide="map-pin" class="w-3 h-3 text-slate-500"></i> Bangalore
                    </a>
                    <a href="{{ route('influencers.public') }}" class="text-xs text-slate-400 hover:text-slate-700 ml-2 font-medium underline">Reset All Filters</a>
                </div>
            </div>
        </section>

        <!-- Talent Cards Grid Section -->
        <section class="py-14 bg-slate-50 min-h-[600px] pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <!-- Results Counter & Live Stats -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <span>Showing <span class="text-slate-900 font-black tabular-nums">{{ $talents->total() }}</span> Verified Talent Profiles</span>
                    </div>
                    
                    <div class="text-xs text-slate-500">
                        Select checkbox on any card to <strong class="text-slate-800">Compare up to 3 creators</strong>
                    </div>
                </div>

                <!-- Responsive Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($talents as $t)
                        @php
                            $avail = $t->availability_status ?? 'available';
                            $totFollowers = $t->socialAccounts->sum('followers');
                            $totViews = $t->socialAccounts->sum('views_30d') ?: (int) ($totFollowers * 3.2);
                            $avgER = $t->socialAccounts->avg('engagement_rate') ?: 4.2;
                            $startingRate = $t->rates->min('rate_amount') ?: 15000;
                        @endphp
                        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-lg hover:border-brand-300 transition duration-200 flex flex-col justify-between space-y-5 group relative">
                            
                            <!-- Card Header: Avatar, Name, Badges & Compare Toggle -->
                            <div class="space-y-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-center space-x-3.5 min-w-0">
                                        <div class="relative flex-shrink-0">
                                            <img src="{{ $t->profile_image ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&h=200&fit=crop' }}" alt="{{ $t->display_name }}" class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl object-cover border-2 border-slate-100 group-hover:border-brand-500 transition shadow-2xs">
                                            <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white {{
                                                $avail === 'available' ? 'bg-emerald-500' :
                                                ($avail === 'tentative' ? 'bg-amber-500' : 'bg-slate-400')
                                            }}"></span>
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <h3 class="font-bold text-slate-900 text-base truncate group-hover:text-brand-600 transition font-display">
                                                {{ $t->display_name ?: $t->user->name }}
                                            </h3>
                                            <p class="text-xs text-brand-600 font-semibold truncate mb-1">@ {{ $t->username }}</p>
                                            <x-verification-badge :level="$t->verification_level ?: 1" size="xs" />
                                        </div>
                                    </div>

                                    <!-- Compare Checkbox & Availability -->
                                    <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                                        <label class="inline-flex items-center space-x-1.5 cursor-pointer text-[11px] font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200 transition select-none">
                                            <input type="checkbox" :checked="compareList.includes({{ $t->id }})" @change="toggleCompare({{ $t->id }})" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                            <span>Compare</span>
                                        </label>

                                        @if($t->price_negotiable)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-sky-700 bg-sky-50 px-2 py-0.5 rounded-md border border-sky-200">
                                                <i data-lucide="message-square" class="w-3 h-3 text-sky-600"></i>
                                                <span>Negotiable</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Bio Snippet -->
                                <p class="text-slate-600 text-xs line-clamp-2 leading-relaxed">
                                    {{ $t->bio ?: 'Professional verified talent available for brand commercial shoots, digital reels, and activations.' }}
                                </p>

                                <!-- Niche & Specialty Tags -->
                                <div class="flex flex-wrap gap-1.5 text-[11px] font-medium">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-slate-100 border border-slate-200 text-slate-700 rounded-md">
                                        <i data-lucide="map-pin" class="w-3 h-3 text-slate-500"></i>
                                        <span>{{ $t->city ?: 'Nashik' }}</span>
                                    </span>
                                    
                                    <!-- Engagement Rate Badge -->
                                    <span class="px-2.5 py-0.5 bg-orange-50 border border-orange-200 text-orange-700 font-bold rounded-md flex items-center space-x-1">
                                        <i data-lucide="flame" class="w-3 h-3 text-orange-600"></i>
                                        <span>{{ number_format($avgER, 1) }}% ER</span>
                                    </span>

                                    @if(!empty($t->primary_categories))
                                        @foreach(array_slice((array)$t->primary_categories, 0, 2) as $cat)
                                            <span class="px-2.5 py-0.5 bg-brand-50 border border-brand-200 text-brand-700 rounded-md font-semibold">
                                                {{ $cat }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Connected Social Reach Breakdown -->
                                <div class="bg-slate-50 border border-slate-200 p-3 rounded-2xl flex items-center justify-between text-xs font-bold text-slate-800">
                                    <div class="flex items-center space-x-3">
                                        @if($t->socialAccounts->count() > 0)
                                            @foreach($t->socialAccounts->take(2) as $acc)
                                                @php
                                                    $isYT = strtolower($acc->platform) === 'youtube';
                                                    $isIG = strtolower($acc->platform) === 'instagram';
                                                @endphp
                                                <span class="flex items-center space-x-1.5 tabular-nums">
                                                    <span class="w-5 h-5 rounded-lg flex items-center justify-center text-[10px]
                                                        @if($isIG) bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 text-white shadow-2xs
                                                        @elseif($isYT) bg-gradient-to-tr from-red-600 via-rose-600 to-red-700 text-white shadow-2xs
                                                        @else bg-blue-50 text-blue-600 @endif">
                                                        @if($isIG) <i data-lucide="instagram" class="w-3 h-3 text-white"></i>
                                                        @elseif($isYT) <i data-lucide="youtube" class="w-3 h-3 text-white"></i>
                                                        @else <i data-lucide="globe" class="w-3 h-3"></i> @endif
                                                    </span>
                                                    <span class="text-slate-900 font-display font-bold">{{ number_format($acc->followers) }}</span>
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-slate-500 text-[11px]">Direct Talent Profile</span>
                                        @endif
                                    </div>
                                    <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200 text-[10px] font-bold tabular-nums">
                                        <i data-lucide="star" class="w-3 h-3 text-amber-500 fill-amber-500"></i>
                                        <span>{{ number_format($t->rating_avg ?: 5.0, 1) }}</span>
                                        <span class="text-slate-400 font-normal">({{ $t->reviews_count ?: 12 }})</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Card Action & Starting Rate -->
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Starting Rate</span>
                                    <span class="text-base font-black text-slate-900 font-display tabular-nums">
                                        ₹{{ number_format($startingRate) }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('influencers.public.show', $t->username) }}" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold transition shadow-2xs flex items-center space-x-1">
                                        <span>View Media Kit</span>
                                        <span>&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 bg-white rounded-3xl border border-slate-200 shadow-sm space-y-3">
                            <div class="w-14 h-14 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                <i data-lucide="user-x" class="w-7 h-7"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 font-display">No matching creators found</h3>
                            <p class="text-slate-500 text-xs max-w-sm mx-auto">Try broadening your search criteria or resetting filters to discover more talent.</p>
                            <a href="{{ route('influencers.public') }}" class="inline-block mt-2 px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
                                Reset All Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="pt-6">
                    {{ $talents->links() }}
                </div>
            </div>
        </section>

        <!-- Floating Comparison Sticky Bar (Alpine.js) -->
        <div x-show="compareList.length > 0" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100" class="fixed bottom-6 inset-x-0 z-40 max-w-2xl mx-auto px-4">
            <div class="bg-slate-900 text-white p-4 rounded-2xl shadow-2xl border border-slate-700 flex items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <span class="w-7 h-7 rounded-full bg-brand-500 text-white flex items-center justify-center font-bold text-xs" x-text="compareList.length"></span>
                    <span class="text-xs sm:text-sm font-semibold">Creators selected for comparison</span>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="button" @click="compareList = []" class="px-3 py-1.5 text-xs text-slate-300 hover:text-white font-medium">
                        Clear
                    </button>
                    <button type="button" @click="openCompareModal()" class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-xs transition">
                        Compare Now &rarr;
                    </button>
                </div>
            </div>
        </div>

        <!-- Side-by-Side Comparison Slide-Over / Modal -->
        <div x-show="compareModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div @click.away="compareModalOpen = false" class="bg-white w-full max-w-4xl rounded-3xl border border-slate-200 shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold font-display text-slate-900">Talent Comparison Matrix</h2>
                        <p class="text-xs text-slate-500">Side-by-side comparison of reach, engagement, rates, and verified tier.</p>
                    </div>
                    <button type="button" @click="compareModalOpen = false" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center text-sm font-bold">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto space-y-6">
                    <div x-show="loadingCompare" class="text-center py-12 text-slate-500 text-sm">
                        Loading creator statistics...
                    </div>

                    <div x-show="!loadingCompare && compareData.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <template x-for="item in compareData" :key="item.id">
                            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 space-y-4 flex flex-col justify-between">
                                <div class="space-y-3">
                                    <div class="flex items-center space-x-3">
                                        <img :src="item.avatar" class="w-12 h-12 rounded-xl object-cover border border-slate-200">
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-sm" x-text="item.name"></h4>
                                            <p class="text-xs text-brand-600 font-medium" x-text="'@' + item.username"></p>
                                        </div>
                                    </div>

                                    <div class="space-y-2 pt-2 text-xs">
                                        <div class="flex justify-between py-1.5 border-b border-slate-200">
                                            <span class="text-slate-500">Location</span>
                                            <span class="font-bold text-slate-800" x-text="item.city"></span>
                                        </div>
                                        <div class="flex justify-between py-1.5 border-b border-slate-200">
                                            <span class="text-slate-500">Total Reach</span>
                                            <span class="font-bold text-slate-900 tabular-nums" x-text="item.total_followers.toLocaleString()"></span>
                                        </div>
                                        <div class="flex justify-between py-1.5 border-b border-slate-200">
                                            <span class="text-slate-500">Avg Engagement Rate</span>
                                            <span class="font-bold text-orange-600 tabular-nums" x-text="item.engagement_rate"></span>
                                        </div>
                                        <div class="flex justify-between py-1.5 border-b border-slate-200">
                                            <span class="text-slate-500">Starting Rate</span>
                                            <span class="font-bold text-slate-900 tabular-nums" x-text="item.starting_rate"></span>
                                        </div>
                                        <div class="flex justify-between py-1.5 border-b border-slate-200">
                                            <span class="text-slate-500">Rating</span>
                                            <span class="font-bold text-amber-600" x-text="'Rating: ' + item.rating.toFixed(1)"></span>
                                        </div>
                                    </div>
                                </div>

                                <a :href="item.profile_url" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl text-center transition block">
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
