@extends('layouts.brand')

@section('title', 'Brand Dashboard | Talent Marketplace')

@section('content')
    <div class="space-y-6 sm:space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-display">
                    {{ auth()->user()->brandProfile->company_name ?? auth()->user()->name }} Dashboard
                </h1>
                <p class="text-slate-500 text-sm mt-0.5">Campaign briefs, creator proposals, contract escrow, and tax invoices.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('influencers.public') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 border border-slate-200 bg-white hover:bg-slate-100 text-slate-800 h-9 px-3.5 shadow-2xs">
                    <svg class="w-3.5 h-3.5 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Search Creators</span>
                </a>
                <a href="{{ route('brand.campaigns.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-indigo-600 text-white hover:bg-indigo-700 h-9 px-4 shadow-xs">
                    + Post Requirement
                </a>
            </div>
        </div>

        <!-- shadcn dashboard-01 4-Card Top Metric Grid -->
        <div class="grid gap-4 md:grid-cols-2 md:gap-6 lg:grid-cols-4">
            <!-- Total Campaigns -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs hover:border-slate-300 transition">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="tracking-tight text-xs uppercase font-semibold text-slate-500">Active Campaigns</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-slate-400">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold tabular-nums text-indigo-600">{{ $stats['active_campaigns'] }}</div>
                    <p class="text-xs text-slate-500 mt-1">
                        <a href="{{ route('brand.campaigns') }}" class="text-indigo-600 font-semibold hover:underline">View live briefs &rarr;</a>
                    </p>
                </div>
            </div>

            <!-- Pitches Received -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs hover:border-slate-300 transition">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="tracking-tight text-xs uppercase font-semibold text-slate-500">Pitches Received</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-slate-400">
                        <rect width="20" height="14" x="2" y="5" rx="2" />
                        <line x1="2" x2="22" y1="10" y2="10" />
                    </svg>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold tabular-nums">{{ $stats['total_applications'] }}</div>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-emerald-600 font-semibold">{{ $stats['shortlisted_applications'] }} shortlisted</span>
                    </p>
                </div>
            </div>

            <!-- In Review / Moderation -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs hover:border-slate-300 transition">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="tracking-tight text-xs uppercase font-semibold text-slate-500">In Admin Review</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-slate-400">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold tabular-nums text-amber-600">{{ $stats['pending_campaigns'] }}</div>
                    <p class="text-xs text-slate-500 mt-1">Platform QA</p>
                </div>
            </div>

            <!-- Total Pitches / Action Required -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs hover:border-slate-300 transition">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="tracking-tight text-xs uppercase font-semibold text-slate-500">Needs Review</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-slate-400">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                    </svg>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold tabular-nums text-rose-600">{{ $stats['pending_applications'] }}</div>
                    <p class="text-xs text-slate-500 mt-1">
                        <a href="{{ route('brand.campaigns') }}" class="text-rose-600 font-semibold hover:underline">Review pitches &rarr;</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- shadcn dashboard-01 Main Grid (Table Card on Left + Quick Roster on Right) -->
        <div class="grid gap-4 md:gap-6 lg:grid-cols-7">
            <!-- Left Card: Recent Creator Applications Table (4 Cols) -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs lg:col-span-4 flex flex-col justify-between">
                <div>
                    <div class="p-6 flex flex-row items-center justify-between border-b border-slate-100">
                        <div>
                            <h3 class="font-semibold text-base tracking-tight">Recent Creator Pitches</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Pitches submitted by creators for your open campaign briefs.</p>
                        </div>
                        <a href="{{ route('brand.campaigns') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition hover:bg-slate-100 px-3 py-1.5 border border-slate-200">
                            All Campaigns &rarr;
                        </a>
                    </div>

                    <div class="p-0 overflow-x-auto">
                        <table class="w-full caption-bottom text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-100">
                                <tr>
                                    <th class="h-10 px-6 align-middle font-medium">Creator</th>
                                    <th class="h-10 px-4 align-middle font-medium">Campaign</th>
                                    <th class="h-10 px-4 align-middle font-medium text-right">Quoted Fee</th>
                                    <th class="h-10 px-6 align-middle font-medium text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($recentApplications as $app)
                                    <tr class="hover:bg-slate-50/60 transition">
                                        <td class="p-6 py-4 align-middle">
                                            <div class="flex items-center space-x-3">
                                                <img src="{{ ($app->talentProfile->profile_image ?? $app->influencerProfile->profile_image ?? '') ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop' }}" class="w-8 h-8 rounded-full object-cover border border-slate-200">
                                                <div class="min-w-0">
                                                    <div class="font-semibold text-slate-900 line-clamp-1">{{ $app->talentProfile->display_name ?? $app->influencerProfile->display_name ?? 'Creator' }}</div>
                                                    <div class="text-[11px] text-slate-400">@ {{ $app->talentProfile->username ?? 'talent' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4 align-middle text-slate-600 text-xs font-medium">
                                            <span class="line-clamp-1">{{ $app->campaign->name ?? $app->campaign->title ?? 'N/A' }}</span>
                                        </td>
                                        <td class="p-4 align-middle text-right font-bold text-slate-900 tabular-nums">
                                            ₹{{ number_format($app->quoted_price) }}
                                        </td>
                                        <td class="p-6 py-4 align-middle text-right whitespace-nowrap">
                                            <div class="inline-flex items-center space-x-1.5">
                                                <a href="{{ route('brand.chat', $app->id) }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-800 px-2.5 py-1.5 transition">
                                                    Chat
                                                </a>
                                                <form method="POST" action="{{ route('brand.applications.status', $app->id) }}" class="inline-flex">
                                                    @csrf
                                                    @if($app->status !== 'selected')
                                                        <button type="submit" name="status" value="selected" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold bg-indigo-600 hover:bg-indigo-700 text-white px-2.5 py-1.5 transition shadow-2xs">
                                                            Hire
                                                        </button>
                                                    @endif
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-slate-400 text-xs">
                                            No applications received yet. Post a brief or invite talent directly.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Showing recent incoming pitches</span>
                    <a href="{{ route('brand.messages') }}" class="font-semibold text-indigo-600 hover:underline">Open Inbox &rarr;</a>
                </div>
            </div>

            <!-- Right Card: Quick Rosters & Active Contracts (3 Cols) -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs lg:col-span-3 flex flex-col justify-between">
                <div>
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="font-semibold text-base tracking-tight">Talent Rosters & Shortlists</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Saved creators and direct collaboration hub.</p>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Shortlists Item -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-9 h-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                                    <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold leading-none text-slate-900">Custom Talent Rosters</p>
                                    <p class="text-xs text-slate-500 mt-1">Organize creators by campaign tier</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('brand.lists.index') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold bg-slate-900 text-white hover:bg-slate-800 px-3 py-1.5 transition">
                                    Open
                                </a>
                            </div>
                        </div>

                        <!-- Direct Messages Item -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-9 h-9 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center font-bold text-sm">
                                    <i data-lucide="message-square" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold leading-none text-slate-900">Messages & Inquiries</p>
                                    <p class="text-xs text-slate-500 mt-1">Real-time negotiations & agreements</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('brand.messages') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-800 px-3 py-1.5 transition">
                                    Inbox
                                </a>
                            </div>
                        </div>

                        <!-- Invoices Item -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                                    <i data-lucide="receipt" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold leading-none text-slate-900">Tax Invoices & Billing</p>
                                    <p class="text-xs text-slate-500 mt-1">GST-compliant disbursements</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('brand.invoices') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-800 px-3 py-1.5 transition">
                                    Ledger
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-100 bg-slate-50/50 rounded-b-xl">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">Enterprise Status</span>
                        <span class="inline-flex items-center gap-1.5 font-semibold text-sky-600">
                            <span class="w-2 h-2 rounded-full bg-sky-500"></span> Verified Client
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
