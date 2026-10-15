@extends('layouts.app')

@section('title', 'Contact & Partnership Inquiries | Talent Marketplace')

@section('content')
    <!-- Header -->
    <section class="py-16 lg:py-24 border-b border-white/[0.08] relative overflow-hidden text-center">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-brand-600/15 blur-[140px] pointer-events-none rounded-full -z-10"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
            <span class="text-xs font-bold uppercase tracking-widest text-brand-400 font-display block">Get In Touch</span>
            <h1 class="text-3xl sm:text-5xl font-black font-display text-white tracking-tight">
                Contact <span class="gradient-brand">Talent Marketplace</span>
            </h1>
            <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                Have questions about brand onboarding, casting campaigns, API verification, or enterprise agreements? We are here to help.
            </p>
        </div>
    </section>

    <!-- Form Section -->
    <section class="py-20">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-white/10 shadow-glow">
                <form action="#" method="POST" class="space-y-5" onsubmit="event.preventDefault(); alert('Thank you for reaching out! Our marketplace support team will respond within 2 hours.');">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2 font-display">Full Name</label>
                        <input type="text" required class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-brand-500 placeholder-slate-500" placeholder="e.g. Ria Sharma">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2 font-display">Work Email Address</label>
                        <input type="email" required class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-brand-500 placeholder-slate-500" placeholder="ria@auraluxe.com">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2 font-display">Inquiry Type</label>
                        <select required class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-brand-500 font-medium">
                            <option value="brand">Brand Campaign & Casting Inquiry</option>
                            <option value="creator">Creator Verification & Rate Cards</option>
                            <option value="api">API Verification & Social Sync</option>
                            <option value="enterprise">Agency Enterprise Partnership</option>
                            <option value="other">General Support</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2 font-display">Message & Details</label>
                        <textarea rows="4" required class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-brand-500 placeholder-slate-500 leading-relaxed" placeholder="Tell us about your brand requirement or question..."></textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-xl font-bold btn-gradient text-white shadow-glow hover:shadow-glow-lg transition text-sm">
                        Submit Inquiry &rarr;
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
