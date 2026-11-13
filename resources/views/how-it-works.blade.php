@extends('layouts.app')

@section('title', 'How It Works — The Workflow for Brands & Verified Creators | HypeMarket')

@section('content')
    <div class="relative overflow-hidden">

        <!-- ========================================================================= -->
        <!-- SECTION 1: EDITORIAL HEADER & WORKFLOW INTRO                              -->
        <!-- ========================================================================= -->
        <section class="pt-8 pb-10 sm:pt-12 sm:pb-14 relative overflow-hidden">
            <!-- Ambient blurred glows matching theme -->
            <div aria-hidden="true" class="absolute -left-20 top-10 h-72 w-72 rounded-full bg-[#E2F163]/25 blur-[120px] pointer-events-none -z-10"></div>
            <div aria-hidden="true" class="absolute -right-20 top-20 h-72 w-72 rounded-full bg-[#F47FA2]/20 blur-[120px] pointer-events-none -z-10"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center space-y-4">
                    
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border-2 border-[#181528] text-[#181528] text-xs font-mono font-black uppercase tracking-wider shadow-[3px_3px_0_#181528] -rotate-1 hover:rotate-0 transition-transform">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#FF3E14] animate-ping"></span>
                        <span>END-TO-END WORKFLOW &bull; 100% ESCROW PROTECTED</span>
                    </div>

                    <h1 class="font-display font-extrabold tracking-tight leading-[0.98] text-[#181528]" style="font-size: clamp(2.4rem, 5.5vw, 4.2rem);">
                        <span>How</span>
                        <span class="grad-text2">HypeMarket</span>
                        <span>Brings</span><br>
                        <span>Campaigns to</span>
                        <span class="sticker-lime mx-1.5 inline-block -rotate-3 rounded-2xl px-3 py-1 font-display font-extrabold text-[#181528] text-2xl sm:text-4xl shadow-[4px_4px_0_#181528] align-middle">Life.</span>
                    </h1>

                    <p class="text-[#524B66] text-base sm:text-lg font-medium leading-relaxed max-w-2xl mx-auto font-sans">
                        A transparent, frictionless marketplace connecting ambitious brands with verified Instagram creators, models, and anchors. Zero bot inflation, zero payment anxiety.
                    </p>

                    <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border-2 border-[#181528] text-xs font-mono font-black text-[#181528] shadow-[2px_2px_0_#181528]">
                            <i class="fa-solid fa-check text-[#10B981]"></i> Meta Graph Verified
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border-2 border-[#181528] text-xs font-mono font-black text-[#181528] shadow-[2px_2px_0_#181528]">
                            <i class="fa-solid fa-shield-halved text-[#7EC4FB]"></i> Milestone Escrow
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border-2 border-[#181528] text-xs font-mono font-black text-[#181528] shadow-[2px_2px_0_#181528]">
                            <i class="fa-solid fa-bolt text-[#FF3E14]"></i> 48-Hour Turnaround
                        </span>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- SECTION 2: SIDE-BY-SIDE INTERACTIVE AUDIENCE PATHS                        -->
        <!-- ========================================================================= -->
        <section class="py-6 sm:py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

                <!-- 1. FOR BRANDS & AGENCIES -->
                <div class="bg-white rounded-[32px] border-2 border-[#181528] shadow-[6px_6px_0_#E2F163] p-6 sm:p-10 space-y-8">
                    
                    <!-- Header Strip -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b-2 border-[#181528]/10">
                        <div class="space-y-1">
                            <div class="inline-flex items-center gap-2 text-xs font-mono font-black uppercase tracking-wider text-[#FF3E14]">
                                <i class="fa-solid fa-briefcase"></i>
                                <span>For Brands, Founders &amp; Agencies</span>
                            </div>
                            <h2 class="font-display font-black text-2xl sm:text-3xl text-[#181528]">
                                The Brand Campaign Casting Journey
                            </h2>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="px-3.5 py-1.5 rounded-full bg-[#E2F163] border-2 border-[#181528] text-xs font-mono font-black text-[#181528] shadow-[2px_2px_0_#181528]">
                                Client Workflow
                            </span>
                            <a href="{{ route('campaigns.public') }}" class="hm-btn px-4 py-1.5 rounded-full bg-[#181528] text-white hover:bg-black text-xs font-display font-black transition">
                                Browse Briefs &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- 3 Sequential Steps -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Step 1 -->
                        <div class="bg-[#FAF5EC] rounded-2xl border-2 border-[#181528] p-6 space-y-3.5 flex flex-col justify-between shadow-[3px_3px_0_#181528] relative group hover:-translate-y-1 transition-all">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="w-9 h-9 rounded-xl bg-[#E2F163] text-[#181528] border-2 border-[#181528] flex items-center justify-center font-display font-black text-sm shadow-[1.5px_1.5px_0_#181528]">
                                        01
                                    </span>
                                    <span class="text-[10px] font-mono font-bold uppercase text-[#524B66] bg-white px-2 py-0.5 rounded-md border border-[#181528]/30">
                                        Setup Brief
                                    </span>
                                </div>
                                <h3 class="font-display font-black text-lg text-[#181528] leading-tight">
                                    Post Your Campaign Brief
                                </h3>
                                <p class="text-xs sm:text-sm font-sans text-[#524B66] leading-relaxed">
                                    Specify your required deliverables (Reels, Outfit Changes, Event Duration), commercial usage rights, target demographics, and escrow-backed budget brackets.
                                </p>
                            </div>
                            <div class="pt-3 border-t border-[#181528]/10 text-[11px] font-mono font-bold text-[#FF3E14] flex items-center gap-1.5">
                                <i class="fa-solid fa-sliders"></i>
                                <span>Multi-format deliverable builder</span>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="bg-[#FAF5EC] rounded-2xl border-2 border-[#181528] p-6 space-y-3.5 flex flex-col justify-between shadow-[3px_3px_0_#181528] relative group hover:-translate-y-1 transition-all">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="w-9 h-9 rounded-xl bg-[#7EC4FB] text-[#181528] border-2 border-[#181528] flex items-center justify-center font-display font-black text-sm shadow-[1.5px_1.5px_0_#181528]">
                                        02
                                    </span>
                                    <span class="text-[10px] font-mono font-bold uppercase text-[#524B66] bg-white px-2 py-0.5 rounded-md border border-[#181528]/30">
                                        Live Cast
                                    </span>
                                </div>
                                <h3 class="font-display font-black text-lg text-[#181528] leading-tight">
                                    Review Pitches &amp; Verify Metrics
                                </h3>
                                <p class="text-xs sm:text-sm font-sans text-[#524B66] leading-relaxed">
                                    Examine creator profiles with verified Meta Graph ER%, 30-day view velocity, audience demographics, and negotiate tailor-made proposals in real-time chat.
                                </p>
                            </div>
                            <div class="pt-3 border-t border-[#181528]/10 text-[11px] font-mono font-bold text-[#0E4875] flex items-center gap-1.5">
                                <i class="fa-solid fa-chart-simple"></i>
                                <span>100% Meta Graph OAuth verified</span>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="bg-[#FAF5EC] rounded-2xl border-2 border-[#181528] p-6 space-y-3.5 flex flex-col justify-between shadow-[3px_3px_0_#181528] relative group hover:-translate-y-1 transition-all">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="w-9 h-9 rounded-xl bg-[#FF3E14] text-white border-2 border-[#181528] flex items-center justify-center font-display font-black text-sm shadow-[1.5px_1.5px_0_#181528]">
                                        03
                                    </span>
                                    <span class="text-[10px] font-mono font-bold uppercase text-[#524B66] bg-white px-2 py-0.5 rounded-md border border-[#181528]/30">
                                        Milestone Release
                                    </span>
                                </div>
                                <h3 class="font-display font-black text-lg text-[#181528] leading-tight">
                                    Milestone Escrow &amp; Sign-off
                                </h3>
                                <p class="text-xs sm:text-sm font-sans text-[#524B66] leading-relaxed">
                                    Funds are safeguarded in secure escrow until deliverables are delivered. Review draft assets, request revisions with 1 click, or approve for instant wallet payout.
                                </p>
                            </div>
                            <div class="pt-3 border-t border-[#181528]/10 text-[11px] font-mono font-bold text-[#10B981] flex items-center gap-1.5">
                                <i class="fa-solid fa-lock"></i>
                                <span>Zero risk milestone guarantee</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- 2. FOR TALENT & CREATORS -->
                <div class="bg-white rounded-[32px] border-2 border-[#181528] shadow-[6px_6px_0_#F47FA2] p-6 sm:p-10 space-y-8">
                    
                    <!-- Header Strip -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b-2 border-[#181528]/10">
                        <div class="space-y-1">
                            <div class="inline-flex items-center gap-2 text-xs font-mono font-black uppercase tracking-wider text-[#8F1449]">
                                <i class="fa-solid fa-wand-magic-sparkles"></i>
                                <span>For Creators, Models &amp; Anchors</span>
                            </div>
                            <h2 class="font-display font-black text-2xl sm:text-3xl text-[#181528]">
                                The Creator Opportunity Journey
                            </h2>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="px-3.5 py-1.5 rounded-full bg-[#F47FA2] border-2 border-[#181528] text-xs font-mono font-black text-[#181528] shadow-[2px_2px_0_#181528]">
                                Talent Workflow
                            </span>
                            <a href="{{ route('influencers.public') }}" class="hm-btn px-4 py-1.5 rounded-full bg-[#181528] text-white hover:bg-black text-xs font-display font-black transition">
                                View Talent Roster &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- 3 Sequential Steps -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Step 1 -->
                        <div class="bg-[#FAF5EC] rounded-2xl border-2 border-[#181528] p-6 space-y-3.5 flex flex-col justify-between shadow-[3px_3px_0_#181528] relative group hover:-translate-y-1 transition-all">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="w-9 h-9 rounded-xl bg-[#F47FA2] text-[#181528] border-2 border-[#181528] flex items-center justify-center font-display font-black text-sm shadow-[1.5px_1.5px_0_#181528]">
                                        01
                                    </span>
                                    <span class="text-[10px] font-mono font-bold uppercase text-[#524B66] bg-white px-2 py-0.5 rounded-md border border-[#181528]/30">
                                        Profile Sync
                                    </span>
                                </div>
                                <h3 class="font-display font-black text-lg text-[#181528] leading-tight">
                                    Connect &amp; Authenticate Reach
                                </h3>
                                <p class="text-xs sm:text-sm font-sans text-[#524B66] leading-relaxed">
                                    Connect your Instagram, YouTube or TikTok handles via verified OAuth. Your ER%, view rates, and follower demographics sync automatically into your media kit.
                                </p>
                            </div>
                            <div class="pt-3 border-t border-[#181528]/10 text-[11px] font-mono font-bold text-[#8F1449] flex items-center gap-1.5">
                                <i class="fa-brands fa-instagram"></i>
                                <span>Automated real-time media kit</span>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="bg-[#FAF5EC] rounded-2xl border-2 border-[#181528] p-6 space-y-3.5 flex flex-col justify-between shadow-[3px_3px_0_#181528] relative group hover:-translate-y-1 transition-all">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="w-9 h-9 rounded-xl bg-[#BDB0FC] text-[#181528] border-2 border-[#181528] flex items-center justify-center font-display font-black text-sm shadow-[1.5px_1.5px_0_#181528]">
                                        02
                                    </span>
                                    <span class="text-[10px] font-mono font-bold uppercase text-[#524B66] bg-white px-2 py-0.5 rounded-md border border-[#181528]/30">
                                        Pitch &amp; Match
                                    </span>
                                </div>
                                <h3 class="font-display font-black text-lg text-[#181528] leading-tight">
                                    Pitch to Verified Brand Briefs
                                </h3>
                                <p class="text-xs sm:text-sm font-sans text-[#524B66] leading-relaxed">
                                    Browse open briefs in fashion, tech, lifestyle, beauty, and live events. Submit custom proposals, set starting rate cards, or accept direct brand casting invites.
                                </p>
                            </div>
                            <div class="pt-3 border-t border-[#181528]/10 text-[11px] font-mono font-bold text-[#3B2485] flex items-center gap-1.5">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Direct offer negotiations</span>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="bg-[#FAF5EC] rounded-2xl border-2 border-[#181528] p-6 space-y-3.5 flex flex-col justify-between shadow-[3px_3px_0_#181528] relative group hover:-translate-y-1 transition-all">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="w-9 h-9 rounded-xl bg-[#E2F163] text-[#181528] border-2 border-[#181528] flex items-center justify-center font-display font-black text-sm shadow-[1.5px_1.5px_0_#181528]">
                                        03
                                    </span>
                                    <span class="text-[10px] font-mono font-bold uppercase text-[#524B66] bg-white px-2 py-0.5 rounded-md border border-[#181528]/30">
                                        Guaranteed Pay
                                    </span>
                                </div>
                                <h3 class="font-display font-black text-lg text-[#181528] leading-tight">
                                    Submit Asset &amp; Withdraw Funds
                                </h3>
                                <p class="text-xs sm:text-sm font-sans text-[#524B66] leading-relaxed">
                                    Upload reel drafts or confirm live shoot attendance. Brand funds are pre-locked in escrow, ensuring timely and guaranteed release straight into your payout account.
                                </p>
                            </div>
                            <div class="pt-3 border-t border-[#181528]/10 text-[11px] font-mono font-bold text-[#181528] flex items-center gap-1.5">
                                <i class="fa-solid fa-wallet"></i>
                                <span>No chasing invoices or delayed payments</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- SECTION 3: CORE PILLARS BENTO GRID (SECURITY, GRAPH API, CONTRACTS)       -->
        <!-- ========================================================================= -->
        <section class="py-8 sm:py-12 bg-white/50 border-y-2 border-[#181528]/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs font-mono font-black uppercase tracking-wider text-[#FF3E14]">Platform Architecture</span>
                    <h2 class="font-display font-black text-2xl sm:text-3xl text-[#181528]">
                        Built on Trust, Escrow &amp; Real Data
                    </h2>
                    <p class="text-xs sm:text-sm text-[#524B66] font-sans">
                        Everything you need to collaborate with confidence from casting call to contract completion.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Pillar 1 -->
                    <div class="p-6 rounded-3xl bg-white border-2 border-[#181528] shadow-[4px_4px_0_#181528] space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-[#E2F163] border-2 border-[#181528] flex items-center justify-center text-[#181528] text-xl shadow-[2px_2px_0_#181528]">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="font-display font-black text-xl text-[#181528]">Milestone Escrow Protection</h3>
                        <p class="text-xs sm:text-sm text-[#524B66] leading-relaxed font-sans">
                            Brand funds are deposited before work begins. Creators know the payout is secured, and brands know payment is only released once satisfactory deliverables are approved.
                        </p>
                    </div>

                    <!-- Pillar 2 -->
                    <div class="p-6 rounded-3xl bg-white border-2 border-[#181528] shadow-[4px_4px_0_#181528] space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-[#7EC4FB] border-2 border-[#181528] flex items-center justify-center text-[#181528] text-xl shadow-[2px_2px_0_#181528]">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <h3 class="font-display font-black text-xl text-[#181528]">Meta Graph API Verification</h3>
                        <p class="text-xs sm:text-sm text-[#524B66] leading-relaxed font-sans">
                            Forget forged screenshots or bot-bought followings. We sync directly with the official Meta Graph API to read genuine follower numbers, real impression velocity, and authentic ER%.
                        </p>
                    </div>

                    <!-- Pillar 3 -->
                    <div class="p-6 rounded-3xl bg-white border-2 border-[#181528] shadow-[4px_4px_0_#181528] space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-[#F47FA2] border-2 border-[#181528] flex items-center justify-center text-[#181528] text-xl shadow-[2px_2px_0_#181528]">
                            <i class="fa-solid fa-file-contract"></i>
                        </div>
                        <h3 class="font-display font-black text-xl text-[#181528]">Commercial Usage Rights</h3>
                        <p class="text-xs sm:text-sm text-[#524B66] leading-relaxed font-sans">
                            Every collaboration includes clear digital licensing terms (organic reposting, Meta ad whitelisting, duration, and geo-territories) to prevent legal ambiguities.
                        </p>
                    </div>

                </div>

            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- SECTION 4: CALL TO ACTION BANNER                                          -->
        <!-- ========================================================================= -->
        <section class="py-12 sm:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative rounded-[36px] bg-[#181528] border-2 border-[#181528] shadow-[8px_8px_0_#FF3E14] p-8 sm:p-12 text-center overflow-hidden">
                    
                    <!-- Decorative floating elements -->
                    <div aria-hidden="true" class="absolute -left-12 -top-12 h-44 w-44 rounded-full bg-[#E2F163]/20 blur-[60px] pointer-events-none"></div>
                    <div aria-hidden="true" class="absolute -right-12 -bottom-12 h-44 w-44 rounded-full bg-[#F47FA2]/25 blur-[60px] pointer-events-none"></div>

                    <div class="relative z-10 max-w-2xl mx-auto space-y-6">
                        
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 text-[#E2F163] border border-white/20 text-xs font-mono font-bold uppercase tracking-wider">
                            <span>Ready to collaborate?</span>
                        </div>

                        <h2 class="font-display font-black text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-tight">
                            Start Casting in Minutes. Guaranteed Safe.
                        </h2>

                        <p class="text-white/70 text-sm sm:text-base font-sans max-w-xl mx-auto leading-relaxed">
                            Join over 4,800+ creators and forward-thinking brands running next-generation campaigns on HypeMarket.
                        </p>

                        <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="{{ route('register') }}" class="hm-btn w-full sm:w-auto px-8 py-3.5 rounded-full bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] font-display font-black text-sm border-2 border-[#181528] shadow-[3px_3px_0_white] transition">
                                Create Free Account &rarr;
                            </a>
                            <a href="{{ route('influencers.public') }}" class="hm-btn w-full sm:w-auto px-8 py-3.5 rounded-full bg-white hover:bg-[#FAF5EC] text-[#181528] font-display font-black text-sm border-2 border-[#181528] shadow-[3px_3px_0_#E2F163] transition">
                                Explore Creators Roster
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

