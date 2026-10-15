@extends('layouts.app')

@section('title', 'User Data Deletion Instructions | TD-Influence Marketplace')

@section('content')
    <section class="py-12 md:py-16 bg-slate-50 min-h-[85vh]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(request()->filled('code'))
                <div class="bg-emerald-50 border border-emerald-200 rounded-3xl p-6 md:p-8 flex items-start space-x-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-base font-bold text-emerald-900">Data Deletion Request Received</h3>
                        <p class="text-sm text-emerald-800">
                            Confirmation Tracking Code: <strong class="font-mono bg-white px-2.5 py-0.5 rounded border border-emerald-300 text-emerald-900">{{ request('code') }}</strong>
                        </p>
                        <p class="text-xs text-emerald-700 mt-1">
                            Your request is logged. All associated Facebook/Instagram tokens and cached social analytics data will be purged from our servers within 48 hours.
                        </p>
                    </div>
                </div>
            @endif

            <div class="bg-white border border-slate-200 rounded-3xl p-8 md:p-12 shadow-xs space-y-8">
                <div class="border-b border-slate-100 pb-6">
                    <span class="px-3.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 text-xs font-bold rounded-full inline-block mb-3">
                        Meta Platform Compliance & User Rights
                    </span>
                    <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">User Data Deletion Instructions</h1>
                    <p class="text-slate-500 text-xs sm:text-sm mt-2">Last updated: September 28, 2026</p>
                </div>

                <div class="space-y-6 text-slate-600 text-sm leading-relaxed">
                    <p>
                        <strong>TD-Influence Marketplace</strong> respects user privacy and complies with Meta's Platform Data Deletion Policy and global privacy standards. According to Meta Platform Rules, we provide this guide to explain how you can remove your activities and delete all personal and connected social data associated with our application.
                    </p>

                    <!-- Option 1: Remove permissions from Facebook/Instagram -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 space-y-3">
                        <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-slate-900 text-white text-xs flex items-center justify-center font-bold">1</span>
                            How to Remove TD-Influence from your Meta / Facebook / Instagram Account
                        </h2>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            If you connected your Instagram or Facebook account to TD-Influence and wish to revoke access and trigger automated data removal:
                        </p>
                        <ol class="list-decimal pl-5 space-y-1.5 text-xs text-slate-600">
                            <li>Log in to your <strong>Facebook</strong> or <strong>Instagram</strong> account.</li>
                            <li>Navigate to <strong>Settings &amp; Privacy &rarr; Settings</strong>.</li>
                            <li>Scroll down to the <em>Permissions</em> section and select <strong>Apps and Websites</strong>.</li>
                            <li>Search for <strong>TD-Influence Marketplace</strong> in your list of connected apps.</li>
                            <li>Click <strong>Remove</strong> to revoke authorization and automatically send a data deletion callback request.</li>
                        </ol>
                    </div>

                    <!-- Option 2: Remove data from marketplace dashboard -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 space-y-3">
                        <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-slate-900 text-white text-xs flex items-center justify-center font-bold">2</span>
                            How to Delete Connected Social Channels from within the Marketplace
                        </h2>
                        <ol class="list-decimal pl-5 space-y-1.5 text-xs text-slate-600">
                            <li>Log in to your account at <a href="{{ route('login') }}" class="text-[#108a00] font-bold hover:underline">TD-Influence Login</a>.</li>
                            <li>Go to your <strong>Creator Dashboard &rarr; Social Channels</strong> (<a href="{{ route('influencer.social') }}" class="text-[#108a00] font-bold hover:underline">/influencer/social</a>).</li>
                            <li>Locate your connected Instagram or YouTube account and click the red <strong>Delete / Disconnect</strong> button.</li>
                            <li>Confirm the action: all associated access tokens, follower snapshots, and media insights are permanently erased from our database immediately.</li>
                        </ol>
                    </div>

                    <!-- Option 3: Manual Request -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 space-y-3">
                        <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-slate-900 text-white text-xs flex items-center justify-center font-bold">3</span>
                            Request Manual Account &amp; Data Purge
                        </h2>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            If you would like our support team to completely purge your entire user profile, account details, email records, and campaign history:
                        </p>
                        <div class="bg-white border border-slate-200 rounded-xl p-4 text-xs space-y-2">
                            <p><strong>Email your request to:</strong> <a href="mailto:privacy@tdinfluence.com?subject=User%20Data%20Deletion%20Request" class="text-[#108a00] font-bold hover:underline">privacy@tdinfluence.com</a></p>
                            <p><strong>Required Details:</strong> Your registered email address, username, and Instagram/YouTube handle.</p>
                            <p class="text-slate-500">Our data protection officer will review and process your request within <strong>24-48 business hours</strong> and send an official confirmation.</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                        <p>Need further assistance? <a href="{{ route('contact') }}" class="text-[#108a00] font-bold hover:underline">Contact Support &rarr;</a></p>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('privacy') }}" class="hover:underline">Privacy Policy</a>
                            <span>&bull;</span>
                            <a href="{{ route('terms') }}" class="hover:underline">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
