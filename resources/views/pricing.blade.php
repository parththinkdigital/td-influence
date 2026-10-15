@extends('layouts.app')

@section('title', 'Pricing & Transparent Escrow Fees | Talent Marketplace')

@section('content')
    <!-- Header -->
    <section class="py-16 lg:py-20 bg-slate-900 border-b border-slate-800 text-center relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
            <span class="text-xs font-bold uppercase tracking-widest text-brand-400 font-display block">Transparent Marketplace Fees</span>
            <h1 class="text-3xl sm:text-5xl font-black font-display text-white tracking-tight">
                Simple, Predictable <span class="text-brand-400">Pricing</span>
            </h1>
            <p class="text-slate-300 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                100% free for verified creators. Transparent milestone escrow and campaign tools for brands and agencies.
            </p>
        </div>
    </section>

    <!-- Pricing Cards Grid -->
    <section class="py-16 bg-slate-950">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Creator Tier -->
            <div class="bg-slate-900 p-8 rounded-3xl border border-slate-800 flex flex-col justify-between space-y-8">
                <div class="space-y-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-pink-400 bg-pink-500/10 border border-pink-500/20 px-3 py-1 rounded-full inline-block">
                        For Creators
                    </span>
                    <h3 class="text-xl font-bold font-display text-white">Talent Starter</h3>
                    <div class="flex items-baseline space-x-1">
                        <span class="text-4xl font-black text-white font-display tabular-nums">₹0</span>
                        <span class="text-slate-400 text-xs font-medium">/ forever</span>
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed">100% free for verified models, influencers, anchors, and UGC creators.</p>
                    
                    <ul class="space-y-3 text-xs text-slate-300 pt-4 border-t border-slate-800">
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            <span>Unlimited campaign brief discovery</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            <span>Direct custom pitch proposals</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            <span>Live Meta, Google & X API reach sync</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            <span>Guaranteed milestone escrow payouts</span>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="block text-center py-3 rounded-xl font-bold bg-white/10 hover:bg-white/20 text-white transition text-xs border border-white/10">
                    Join as Creator &rarr;
                </a>
            </div>

            <!-- Brand Pro Tier (Featured) -->
            <div class="bg-slate-900 p-8 rounded-3xl border-2 border-brand-500/60 shadow-xl shadow-brand-500/10 flex flex-col justify-between space-y-8 relative">
                <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-brand-600 text-white text-[10px] font-bold px-3.5 py-1 rounded-full uppercase tracking-wider shadow-sm">
                    Most Popular
                </span>
                <div class="space-y-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-300 bg-brand-500/10 border border-brand-500/20 px-3 py-1 rounded-full inline-block">
                        For Brands
                    </span>
                    <h3 class="text-xl font-bold font-display text-white">Brand Studio Growth</h3>
                    <div class="flex items-baseline space-x-1">
                        <span class="text-4xl font-black text-white font-display tabular-nums">₹19,999</span>
                        <span class="text-slate-400 text-xs font-medium">/ month</span>
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed">For growing brands scaling commercial influencer campaigns and shoots.</p>
                    
                    <ul class="space-y-3 text-xs text-slate-200 pt-4 border-t border-slate-800">
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            <span>Unlimited active campaign briefs</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            <span>Full verified talent roster access</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            <span>Milestone deliverable verification</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            <span>1-on-1 negotiation & proposal chat</span>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="block text-center py-3.5 rounded-xl font-bold bg-brand-600 hover:bg-brand-700 text-white shadow-md transition text-xs">
                    Start Hiring Creators &rarr;
                </a>
            </div>

            <!-- Agency Enterprise -->
            <div class="bg-slate-900 p-8 rounded-3xl border border-slate-800 flex flex-col justify-between space-y-8">
                <div class="space-y-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-sky-400 bg-sky-500/10 border border-sky-500/20 px-3 py-1 rounded-full inline-block">
                        Enterprise
                    </span>
                    <h3 class="text-xl font-bold font-display text-white">Agency & Media</h3>
                    <div class="flex items-baseline space-x-1">
                        <span class="text-4xl font-black text-white font-display">Custom</span>
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed">Multi-brand agency accounts with dedicated casting directors.</p>
                    
                    <ul class="space-y-3 text-xs text-slate-300 pt-4 border-t border-slate-800">
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            <span>Multi-brand sub-account workspaces</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            <span>Priority admin moderation & casting</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            <span>Custom commercial usage licenses</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            <span>Dedicated account manager & support</span>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('contact') }}" class="block text-center py-3 rounded-xl font-bold bg-white/10 hover:bg-white/20 text-white transition text-xs border border-white/10">
                    Contact Enterprise &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- Multi-Persona Interactive Creator Campaign Budget & Licensing Calculator -->
    <section class="py-16 bg-white border-t border-slate-200" 
             x-data="{
                 persona: 'influencer',
                 tier: 'micro',
                 deliverable: 'reel',
                 usageRights: 'organic_only',
                 talentCount: 2,

                 get baseRate() {
                     const rates = {
                         influencer: {
                             nano: { reel: 6000, story: 2500, dedicated_yt: 15000, post: 4000 },
                             micro: { reel: 18000, story: 6000, dedicated_yt: 40000, post: 12000 },
                             mid: { reel: 45000, story: 15000, dedicated_yt: 90000, post: 28000 },
                             macro: { reel: 120000, story: 35000, dedicated_yt: 250000, post: 75000 },
                             celebrity: { reel: 350000, story: 90000, dedicated_yt: 750000, post: 200000 }
                         },
                         modeling: {
                             nano: { half_day: 8000, full_day: 14000, runway: 12000, bridal: 18000 },
                             micro: { half_day: 15000, full_day: 25000, runway: 22000, bridal: 35000 },
                             mid: { half_day: 28000, full_day: 48000, runway: 42000, bridal: 65000 },
                             macro: { half_day: 55000, full_day: 95000, runway: 80000, bridal: 120000 },
                             celebrity: { half_day: 150000, full_day: 250000, runway: 200000, bridal: 350000 }
                         },
                         anchor: {
                             nano: { half_day: 7000, full_day: 12000, corporate: 15000, gala: 18000 },
                             micro: { half_day: 14000, full_day: 24000, corporate: 28000, gala: 32000 },
                             mid: { half_day: 28000, full_day: 45000, corporate: 55000, gala: 65000 },
                             macro: { half_day: 60000, full_day: 100000, corporate: 120000, gala: 140000 },
                             celebrity: { half_day: 180000, full_day: 300000, corporate: 350000, gala: 450000 }
                         },
                         ugc: {
                             nano: { raw_video: 4500, hook_pack: 6500, full_ad: 8000, ad_pack: 15000 },
                             micro: { raw_video: 8500, hook_pack: 12000, full_ad: 15000, ad_pack: 28000 },
                             mid: { raw_video: 18000, hook_pack: 24000, full_ad: 30000, ad_pack: 55000 },
                             macro: { raw_video: 35000, hook_pack: 48000, full_ad: 60000, ad_pack: 110000 },
                             celebrity: { raw_video: 85000, hook_pack: 120000, full_ad: 150000, ad_pack: 280000 }
                         }
                     };

                     const pRates = rates[this.persona] || rates.influencer;
                     const tRates = pRates[this.tier] || pRates.micro;
                     return tRates[this.deliverable] || Object.values(tRates)[0];
                 },

                 get usageMultiplier() {
                     const mult = {
                         organic_only: 1.0,
                         digital_ads_30d: 1.3,
                         digital_ads_90d: 1.5,
                         commercial_full_1y: 2.0,
                         perpetual_buyout: 2.8
                     };
                     return mult[this.usageRights] || 1.0;
                 },

                 get creatorFeeSubtotal() {
                     return Math.round(this.baseRate * this.usageMultiplier * this.talentCount);
                 },

                 get platformEscrowFee() {
                     return Math.round(this.creatorFeeSubtotal * 0.10);
                 },

                 get estimatedTotalBudget() {
                     return this.creatorFeeSubtotal + this.platformEscrowFee;
                 },

                 get estimatedAudienceReach() {
                     const reach = {
                         nano: 12000,
                         micro: 65000,
                         mid: 240000,
                         macro: 850000,
                         celebrity: 2500000
                     };
                     return (reach[this.tier] || 50000) * this.talentCount;
                 },

                 get estimatedViews() {
                     return Math.round(this.estimatedAudienceReach * 0.28);
                 }
             }">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center space-y-2">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-600 font-display">Interactive Cost Calculator</span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 font-display tracking-tight">Estimate Campaign Budget & Projected Reach</h2>
                <p class="text-slate-500 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">Simulate talent fees, usage rights licensing multipliers, and platform escrow breakdowns based on live marketplace data.</p>
            </div>

            <!-- Main Interactive Calculator Panel -->
            <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 sm:p-10 shadow-xs grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Controls (Left 7 Cols) -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- 1. Select Talent Persona -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">1. Select Talent Persona</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs font-semibold">
                            <button type="button" @click="persona = 'influencer'; deliverable = 'reel'" :class="persona === 'influencer' ? 'bg-brand-600 text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200'" class="p-3 rounded-2xl transition text-center">
                                <i data-lucide="camera" class="w-5 h-5 mx-auto mb-1"></i>
                                <span>Influencer</span>
                            </button>
                            <button type="button" @click="persona = 'modeling'; deliverable = 'full_day'" :class="persona === 'modeling' ? 'bg-brand-600 text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200'" class="p-3 rounded-2xl transition text-center">
                                <i data-lucide="sparkles" class="w-5 h-5 mx-auto mb-1"></i>
                                <span>Fashion Model</span>
                            </button>
                            <button type="button" @click="persona = 'anchor'; deliverable = 'corporate'" :class="persona === 'anchor' ? 'bg-brand-600 text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200'" class="p-3 rounded-2xl transition text-center">
                                <i data-lucide="mic" class="w-5 h-5 mx-auto mb-1"></i>
                                <span>Event Anchor</span>
                            </button>
                            <button type="button" @click="persona = 'ugc'; deliverable = 'full_ad'" :class="persona === 'ugc' ? 'bg-brand-600 text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200'" class="p-3 rounded-2xl transition text-center">
                                <i data-lucide="video" class="w-5 h-5 mx-auto mb-1"></i>
                                <span>UGC Video</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Select Tier / Follower Bracket -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">2. Talent Tier / Experience</label>
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 text-xs font-semibold">
                            <button type="button" @click="tier = 'nano'" :class="tier === 'nano' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-slate-200'" class="p-2.5 rounded-xl transition text-center">
                                <span class="block font-bold">Nano</span>
                                <span class="text-[10px] opacity-75">&lt; 15K</span>
                            </button>
                            <button type="button" @click="tier = 'micro'" :class="tier === 'micro' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-slate-200'" class="p-2.5 rounded-xl transition text-center">
                                <span class="block font-bold">Micro</span>
                                <span class="text-[10px] opacity-75">15K - 50K</span>
                            </button>
                            <button type="button" @click="tier = 'mid'" :class="tier === 'mid' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-slate-200'" class="p-2.5 rounded-xl transition text-center">
                                <span class="block font-bold">Mid-Tier</span>
                                <span class="text-[10px] opacity-75">50K - 250K</span>
                            </button>
                            <button type="button" @click="tier = 'macro'" :class="tier === 'macro' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-slate-200'" class="p-2.5 rounded-xl transition text-center">
                                <span class="block font-bold">Macro</span>
                                <span class="text-[10px] opacity-75">250K - 1M</span>
                            </button>
                            <button type="button" @click="tier = 'celebrity'" :class="tier === 'celebrity' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-slate-200'" class="p-2.5 rounded-xl transition text-center">
                                <span class="block font-bold">Celebrity</span>
                                <span class="text-[10px] opacity-75">1M+</span>
                            </button>
                        </div>
                    </div>

                    <!-- 3. Deliverables Format -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">3. Primary Deliverable / Scope</label>
                        <div class="grid grid-cols-2 gap-2 text-xs font-medium">
                            <template x-if="persona === 'influencer'">
                                <div class="contents">
                                    <button type="button" @click="deliverable = 'reel'" :class="deliverable === 'reel' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        Instagram Reel 60s
                                    </button>
                                    <button type="button" @click="deliverable = 'story'" :class="deliverable === 'story' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        Story Sequence 3x
                                    </button>
                                    <button type="button" @click="deliverable = 'dedicated_yt'" :class="deliverable === 'dedicated_yt' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        Dedicated YouTube Video
                                    </button>
                                    <button type="button" @click="deliverable = 'post'" :class="deliverable === 'post' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        Static Carousel Post
                                    </button>
                                </div>
                            </template>
                            <template x-if="persona === 'modeling'">
                                <div class="contents">
                                    <button type="button" @click="deliverable = 'full_day'" :class="deliverable === 'full_day' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        Full-Day Lookbook Shoot 8h
                                    </button>
                                    <button type="button" @click="deliverable = 'half_day'" :class="deliverable === 'half_day' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        Half-Day Catalogue Shoot 4h
                                    </button>
                                    <button type="button" @click="deliverable = 'runway'" :class="deliverable === 'runway' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        Fashion Week Runway Walk
                                    </button>
                                    <button type="button" @click="deliverable = 'bridal'" :class="deliverable === 'bridal' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        Bridal & Ethnic Couture Shoot
                                    </button>
                                </div>
                            </template>
                            <template x-if="persona === 'anchor'">
                                <div class="contents">
                                    <button type="button" @click="deliverable = 'corporate'" :class="deliverable === 'corporate' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        Corporate Summit Emcee Full Day
                                    </button>
                                    <button type="button" @click="deliverable = 'gala'" :class="deliverable === 'gala' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        Award Gala & Launch Hosting
                                    </button>
                                    <button type="button" @click="deliverable = 'half_day'" :class="deliverable === 'half_day' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        Half-Day Press Conference Emcee
                                    </button>
                                    <button type="button" @click="deliverable = 'full_day'" :class="deliverable === 'full_day' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        Multi-Day Festival Host
                                    </button>
                                </div>
                            </template>
                            <template x-if="persona === 'ugc'">
                                <div class="contents">
                                    <button type="button" @click="deliverable = 'full_ad'" :class="deliverable === 'full_ad' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        1 Complete UGC Ad + Captions
                                    </button>
                                    <button type="button" @click="deliverable = 'ad_pack'" :class="deliverable === 'ad_pack' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        3-Video UGC Variation Ad Pack
                                    </button>
                                    <button type="button" @click="deliverable = 'hook_pack'" :class="deliverable === 'hook_pack' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        5 Different Viral Hook Variations
                                    </button>
                                    <button type="button" @click="deliverable = 'raw_video'" :class="deliverable === 'raw_video' ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-white border-slate-200 text-slate-700'" class="p-3 rounded-xl border text-left transition">
                                        High-Res RAW B-Roll Footage
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- 4. Usage Rights Licensing (Blueprint Section 9) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">4. Commercial Usage Rights</label>
                        <select x-model="usageRights" class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <option value="organic_only">Organic Social Only (1.0x Base Rate)</option>
                            <option value="digital_ads_30d">30-Day Digital Ad Rights / Meta & Google (+30% multiplier)</option>
                            <option value="digital_ads_90d">90-Day Digital Ad Rights (+50% multiplier)</option>
                            <option value="commercial_full_1y">1-Year Full Commercial Buyout / OOH & Print (+100% multiplier)</option>
                            <option value="perpetual_buyout">Perpetual Buyout (+180% multiplier)</option>
                        </select>
                    </div>

                    <!-- 5. Quantity Slider -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold text-slate-700 uppercase">5. Number of Creators / Talents</label>
                            <span class="text-xs font-black text-brand-600 tabular-nums font-display" x-text="talentCount + ' Talent Profiles'"></span>
                        </div>
                        <input type="range" min="1" max="10" step="1" x-model="talentCount" class="w-full accent-brand-600">
                    </div>
                </div>

                <!-- Live Projection & Escrow Breakdown Card (Right 5 Cols) -->
                <div class="lg:col-span-5 bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 block mb-1">Live Estimate Breakdown</span>
                        <span class="text-xs text-slate-500 font-medium">Estimated Total Investment</span>
                        <div class="text-3xl sm:text-4xl font-black text-slate-900 font-display tabular-nums mt-1">
                            ₹<span x-text="estimatedTotalBudget.toLocaleString('en-IN')"></span>
                        </div>
                    </div>

                    <div class="space-y-3 pt-4 border-t border-slate-100 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Creator Fee Subtotal:</span>
                            <span class="font-bold text-slate-900 tabular-nums">₹<span x-text="creatorFeeSubtotal.toLocaleString('en-IN')"></span></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Platform Escrow Fee (10%):</span>
                            <span class="font-bold text-slate-900 tabular-nums">₹<span x-text="platformEscrowFee.toLocaleString('en-IN')"></span></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Projected Reach:</span>
                            <span class="font-bold text-slate-900 tabular-nums" x-text="estimatedAudienceReach.toLocaleString('en-IN') + ' Reach'"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Projected Views:</span>
                            <span class="font-bold text-emerald-600 tabular-nums" x-text="'~' + estimatedViews.toLocaleString('en-IN') + ' Impressions'"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Escrow Milestone Protection:</span>
                            <span class="font-bold text-indigo-600 inline-flex items-center gap-1"><i data-lucide="shield-check" class="w-3.5 h-3.5"></i> 100% Guaranteed</span>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('brand.campaigns.create') }}" class="block w-full text-center py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                            Post Campaign Brief with this Budget &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
