@extends('layouts.app')

@section('title', 'About Us — Mission & Platform Standards | Talent Marketplace')

@section('content')
    <!-- Header -->
    <section class="py-16 lg:py-24 border-b border-white/[0.08] relative overflow-hidden text-center">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-brand-600/15 blur-[140px] pointer-events-none rounded-full -z-10"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
            <span class="text-xs font-bold uppercase tracking-widest text-brand-400 font-display block">Our Mission & Standards</span>
            <h1 class="text-3xl sm:text-5xl font-black font-display text-white tracking-tight">
                About <span class="gradient-brand">Talent Marketplace</span>
            </h1>
            <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                Building an authenticated, trustworthy infrastructure where brands and diverse creators collaborate with complete transparency.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <span class="text-xs font-bold uppercase tracking-widest text-accent-cyan font-display block">Why We Built This</span>
                    <h2 class="text-2xl sm:text-4xl font-black font-display text-white tracking-tight">
                        Bridging Brands & Independent Creative Talent
                    </h2>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        Influencer marketing and commercial casting have long been hindered by unverified follower claims, opaque agency markups, and delayed creator payments.
                    </p>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        Talent Marketplace solves this by connecting directly with official Meta, Google YouTube, and X APIs to verify live audience reach, providing milestone escrow protection, and unifying casting calls into a seamless workflow.
                    </p>

                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="glass-panel p-4 rounded-2xl border border-white/10">
                            <h4 class="font-bold text-white text-sm font-display">API-Verified Reach</h4>
                            <p class="text-slate-400 text-xs mt-1">Real-time follower & 30-day view counts directly from platform servers.</p>
                        </div>
                        <div class="glass-panel p-4 rounded-2xl border border-white/10">
                            <h4 class="font-bold text-white text-sm font-display">Milestone Escrow</h4>
                            <p class="text-slate-400 text-xs mt-1">Guaranteed payments locked safely upon hire and released upon approval.</p>
                        </div>
                    </div>
                </div>

                <div class="glass-panel p-3 rounded-3xl border border-white/10 shadow-glow relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop" alt="Talent Marketplace Team" class="rounded-2xl w-full object-cover">
                </div>
            </div>

            <!-- Platform Core Pillars -->
            <div class="glass-panel p-8 sm:p-12 rounded-3xl border border-white/10 space-y-8">
                <div class="text-center max-w-xl mx-auto space-y-2">
                    <span class="text-xs font-bold uppercase tracking-widest text-brand-400 font-display block">Core Guarantees</span>
                    <h3 class="text-2xl font-bold font-display text-white">Platform Standards</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs text-slate-300">
                    <div class="bg-white/[0.03] p-6 rounded-2xl border border-white/10 space-y-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand-400 inline-block"></span>
                        <h4 class="text-white font-bold text-sm">Authenticated Profiles</h4>
                        <p class="text-slate-400 leading-relaxed">Every creator profile undergoes 5-tier verification with ID cards, PAN, and portfolio proof.</p>
                    </div>
                    <div class="bg-white/[0.03] p-6 rounded-2xl border border-white/10 space-y-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-accent-emerald inline-block"></span>
                        <h4 class="text-white font-bold text-sm">Direct Negotiation Chat</h4>
                        <p class="text-slate-400 leading-relaxed">Brands and talent communicate directly with price proposal and counter-offer tooling.</p>
                    </div>
                    <div class="bg-white/[0.03] p-6 rounded-2xl border border-white/10 space-y-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-accent-pink inline-block"></span>
                        <h4 class="text-white font-bold text-sm">Escrow Safe Payouts</h4>
                        <p class="text-slate-400 leading-relaxed">Complete clarity on deliverables, usage rights duration, and instant wallet releases.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
