@extends('layouts.app')

@section('title', 'How It Works — Marketplace Collaboration Guide | Talent Marketplace')

@section('content')
    <!-- Header -->
    <section class="py-16 lg:py-24 border-b border-white/[0.08] relative overflow-hidden text-center">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-brand-600/15 blur-[140px] pointer-events-none rounded-full -z-10"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
            <span class="text-xs font-bold uppercase tracking-widest text-brand-400 font-display block">End-to-End Workflow</span>
            <h1 class="text-3xl sm:text-5xl font-black font-display text-white tracking-tight">
                How <span class="gradient-brand">Talent Marketplace</span> Operates
            </h1>
            <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                A structured, transparent marketplace designed for reliable brand casting and guaranteed creator compensation.
            </p>
        </div>
    </section>

    <!-- Main Step-by-Step Sections -->
    <section class="py-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            
            <!-- Brand Journey -->
            <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-white/10 space-y-8">
                <div class="flex items-center justify-between border-b border-white/10 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-accent-cyan font-display block">For Brands & Agencies</span>
                        <h2 class="text-2xl font-bold font-display text-white">Brand Campaign Casting Journey</h2>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-brand-500/10 text-brand-300 border border-brand-500/20 text-xs font-bold">
                        Client Workflow
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs text-slate-300">
                    <div class="bg-white/[0.03] p-6 rounded-2xl border border-white/10 space-y-2.5">
                        <span class="w-8 h-8 rounded-xl bg-brand-500/10 text-brand-400 flex items-center justify-center font-bold text-sm">1</span>
                        <h4 class="text-white font-bold text-sm">Post Campaign Brief</h4>
                        <p class="text-slate-400 leading-relaxed">Specify required deliverables (Reels, Outfit Changes, Event Duration), commercial usage rights, and budget parameters.</p>
                    </div>

                    <div class="bg-white/[0.03] p-6 rounded-2xl border border-white/10 space-y-2.5">
                        <span class="w-8 h-8 rounded-xl bg-brand-500/10 text-brand-400 flex items-center justify-center font-bold text-sm">2</span>
                        <h4 class="text-white font-bold text-sm">Review Pitches & Chat</h4>
                        <p class="text-slate-400 leading-relaxed">Examine creator profiles, verified API metrics, portfolio media, and negotiate custom pricing counter-offers in real-time chat.</p>
                    </div>

                    <div class="bg-white/[0.03] p-6 rounded-2xl border border-white/10 space-y-2.5">
                        <span class="w-8 h-8 rounded-xl bg-brand-500/10 text-brand-400 flex items-center justify-center font-bold text-sm">3</span>
                        <h4 class="text-white font-bold text-sm">Escrow & Sign-off</h4>
                        <p class="text-slate-400 leading-relaxed">Deposit milestone funds securely into escrow. Review submitted deliverables, request changes or approve to release payout.</p>
                    </div>
                </div>
            </div>

            <!-- Creator Journey -->
            <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-white/10 space-y-8">
                <div class="flex items-center justify-between border-b border-white/10 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-accent-pink font-display block">For Talent & Creators</span>
                        <h2 class="text-2xl font-bold font-display text-white">Creator Opportunity Journey</h2>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-accent-pink/10 text-accent-pink border border-accent-pink/20 text-xs font-bold">
                        Talent Workflow
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs text-slate-300">
                    <div class="bg-white/[0.03] p-6 rounded-2xl border border-white/10 space-y-2.5">
                        <span class="w-8 h-8 rounded-xl bg-accent-pink/10 text-accent-pink flex items-center justify-center font-bold text-sm">1</span>
                        <h4 class="text-white font-bold text-sm">Connect & Verify Reach</h4>
                        <p class="text-slate-400 leading-relaxed">Create your profile, link Instagram, YouTube, TikTok handles with instant API verification, and set service rate cards.</p>
                    </div>

                    <div class="bg-white/[0.03] p-6 rounded-2xl border border-white/10 space-y-2.5">
                        <span class="w-8 h-8 rounded-xl bg-accent-pink/10 text-accent-pink flex items-center justify-center font-bold text-sm">2</span>
                        <h4 class="text-white font-bold text-sm">Pitch to Open Briefs</h4>
                        <p class="text-slate-400 leading-relaxed">Explore casting calls across fashion, tech, beauty, and events. Submit tailored proposals with custom rate quotes.</p>
                    </div>

                    <div class="bg-white/[0.03] p-6 rounded-2xl border border-white/10 space-y-2.5">
                        <span class="w-8 h-8 rounded-xl bg-accent-pink/10 text-accent-pink flex items-center justify-center font-bold text-sm">3</span>
                        <h4 class="text-white font-bold text-sm">Submit & Get Paid</h4>
                        <p class="text-slate-400 leading-relaxed">Submit your deliverable links or shoot attendance confirmations. Once approved, funds release directly to your wallet.</p>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center pt-8">
                <a href="{{ route('register') }}" class="btn-gradient px-8 py-4 rounded-xl font-bold text-white shadow-glow hover:shadow-glow-lg transition text-sm inline-flex items-center space-x-2">
                    <span>Create Your Marketplace Account</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </section>
@endsection
