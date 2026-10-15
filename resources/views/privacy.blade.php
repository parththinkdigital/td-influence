@extends('layouts.app')

@section('title', 'Privacy Policy | TD-Influence Marketplace')

@section('content')
    <section class="py-12 md:py-16 bg-slate-50 min-h-[85vh]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white border border-slate-200 rounded-3xl p-8 md:p-12 shadow-xs space-y-8">
                <div class="border-b border-slate-100 pb-6">
                    <span class="px-3.5 py-1 bg-emerald-50 text-[#108a00] border border-emerald-200 text-xs font-bold rounded-full inline-block mb-3">
                        Legal & Compliance
                    </span>
                    <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Privacy Policy</h1>
                    <p class="text-slate-500 text-xs sm:text-sm mt-2">Last updated: September 11, 2026</p>
                </div>

                <div class="space-y-6 text-slate-600 text-sm leading-relaxed">
                    <section class="space-y-2">
                        <h2 class="text-lg font-extrabold text-slate-900">1. Information We Collect</h2>
                        <p>When you register as a Brand or Creator on TD-Influence, we collect personal and professional information necessary to facilitate campaign management, creator discovery, and escrow payments:</p>
                        <ul class="list-disc pl-5 space-y-1 text-slate-600">
                            <li><strong>Account Credentials:</strong> Full Name, Email Address, Contact Number, and Encrypted Password.</li>
                            <li><strong>Creator Profile Data:</strong> Display Name, Bio, Location (City, State, Country), Primary Niches, and Base Pricing.</li>
                            <li><strong>Connected Social Media Data (Meta / Instagram &amp; YouTube):</strong> When you connect your Instagram or YouTube channels via OAuth or public lookup, we retrieve verified metrics such as follower counts, subscriber counts, total post counts, 30-day view estimates, and Reel play metrics.</li>
                            <li><strong>Transaction Data:</strong> Invoicing, contract deliverables, payout records, and escrow transaction logs.</li>
                        </ul>
                    </section>

                    <section class="space-y-2">
                        <h2 class="text-lg font-extrabold text-slate-900">2. How We Use Social Media &amp; API Data</h2>
                        <p>We use data retrieved from third-party APIs (including Meta Graph API and YouTube Data API v3) strictly to:</p>
                        <ul class="list-disc pl-5 space-y-1 text-slate-600">
                            <li>Display verified audience statistics on your public marketplace profile.</li>
                            <li>Help brands discover creators matching their target demographics and reach requirements.</li>
                            <li>We <strong>never</strong> publish content, post on your behalf, or access private direct messages (DMs).</li>
                            <li>We <strong>do not sell</strong> your connected social data or personal information to third-party data brokers.</li>
                        </ul>
                    </section>

                    <section class="space-y-2">
                        <h2 class="text-lg font-extrabold text-slate-900">3. Token Security &amp; Data Storage</h2>
                        <p>All API access tokens retrieved during Instagram OAuth are encrypted at rest using industry-standard AES-256 encryption. We utilize automated token refreshing and expire stored credentials immediately upon account disconnection.</p>
                    </section>

                    <section class="space-y-2">
                        <h2 class="text-lg font-extrabold text-slate-900">4. User Data Deletion &amp; Rights</h2>
                        <p>
                            You have full ownership of your data. You may disconnect your social accounts or request a complete purge of your account data at any time.
                        </p>
                        <p>
                            For step-by-step instructions on deleting your stored information or revoking Meta permissions, please visit our <a href="{{ route('data-deletion') }}" class="text-[#108a00] font-bold hover:underline">User Data Deletion Instructions page</a> or email <a href="mailto:privacy@tdinfluence.com" class="text-[#108a00] font-bold hover:underline">privacy@tdinfluence.com</a>.
                        </p>
                    </section>

                    <section class="space-y-2">
                        <h2 class="text-lg font-extrabold text-slate-900">5. Contact Us</h2>
                        <p>If you have any questions regarding this Privacy Policy or your personal information, please reach out through our <a href="{{ route('contact') }}" class="text-[#108a00] font-bold hover:underline">Contact Form</a> or write to <span class="font-mono text-slate-800">privacy@tdinfluence.com</span>.</p>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection
