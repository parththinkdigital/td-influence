@extends('layouts.app')

@section('title', 'Terms of Service | TD-Influence Marketplace')

@section('content')
    <section class="py-12 md:py-16 bg-slate-50 min-h-[85vh]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white border border-slate-200 rounded-3xl p-8 md:p-12 shadow-xs space-y-8">
                <div class="border-b border-slate-100 pb-6">
                    <span class="px-3.5 py-1 bg-emerald-50 text-[#108a00] border border-emerald-200 text-xs font-bold rounded-full inline-block mb-3">
                        Terms & Conditions
                    </span>
                    <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Terms of Service</h1>
                    <p class="text-slate-500 text-xs sm:text-sm mt-2">Last updated: September 11, 2026</p>
                </div>

                <div class="space-y-6 text-slate-600 text-sm leading-relaxed">
                    <section class="space-y-2">
                        <h2 class="text-lg font-extrabold text-slate-900">1. Acceptance of Terms</h2>
                        <p>By registering for an account or using the TD-Influence platform, you agree to comply with and be bound by these Terms of Service. These terms apply to all users, including Brand clients, agencies, models, digital influencers, anchors, and UGC creators.</p>
                    </section>

                    <section class="space-y-2">
                        <h2 class="text-lg font-extrabold text-slate-900">2. Account Registration & User Types</h2>
                        <ul class="list-disc pl-5 space-y-1 text-slate-600">
                            <li><strong>Influencers / Creators:</strong> Must provide accurate personal details, verified social account metrics, and honor agreed campaign deliverables.</li>
                            <li><strong>Brand Clients:</strong> Responsible for maintaining accurate brand profiles, posting clear campaign briefs, and funding contract escrows.</li>
                            <li>You are responsible for maintaining the confidentiality of your account credentials.</li>
                        </ul>
                    </section>

                    <section class="space-y-2">
                        <h2 class="text-lg font-extrabold text-slate-900">3. Escrow Payments & Commercial Fees</h2>
                        <p>To protect both Brands and Creators, TD-Influence utilizes an Escrow Protection System:</p>
                        <ul class="list-disc pl-5 space-y-1 text-slate-600">
                            <li>Brands deposit the agreed project fee into escrow prior to the shoot or content creation start date.</li>
                            <li>Funds are released to the Creator upon approval of deliverables or verified campaign publication.</li>
                            <li>All fee negotiations and payments must remain on the TD-Influence platform. Off-platform circumvention is strictly prohibited.</li>
                        </ul>
                    </section>

                    <section class="space-y-2">
                        <h2 class="text-lg font-extrabold text-slate-900">4. Content Ownership & Usage Rights</h2>
                        <p>Specific usage rights (channels, duration, licensing, exclusivity) are agreed upon during campaign proposal acceptance. Creators retain moral rights to work created unless explicit buyout agreements are concluded in writing.</p>
                    </section>

                    <section class="space-y-2">
                        <h2 class="text-lg font-extrabold text-slate-900">5. Code of Conduct & Dispute Resolution</h2>
                        <p>Users must treat all party members professionally. In the event of a deliverable dispute, either party may request administrative mediation. TD-Influence staff will review contract terms and evidence to reach a binding resolution.</p>
                    </section>

                    <section class="pt-4 border-t border-slate-100 text-xs text-slate-500">
                        Have questions about our Terms of Service? <a href="{{ route('contact') }}" class="text-[#108a00] font-bold hover:underline">Contact Support &rarr;</a>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection
