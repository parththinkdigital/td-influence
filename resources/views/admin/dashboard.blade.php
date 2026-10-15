@extends('layouts.admin')

@section('title', 'Admin Platform Governance & Escrow Overview | Admin Gateway')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-display">Admin Governance Center</h1>
                <p class="text-slate-500 text-sm mt-0.5">Platform escrow volumes, creator moderation, and identity verifications.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.brands') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-slate-900 text-white hover:bg-slate-800 h-9 px-4 py-2 shadow-xs">
                    + Issue Brand Credentials
                </a>
            </div>
        </div>

        <!-- shadcn dashboard-01 4-Card Top Metric Grid -->
        <div class="grid gap-4 md:grid-cols-2 md:gap-6 lg:grid-cols-4">
            <!-- Total Revenue / Escrow GMV -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs hover:border-slate-300 transition">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="tracking-tight text-xs uppercase font-semibold text-slate-500">Gross Escrow Volume</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-slate-400">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold tabular-nums">₹{{ number_format($stats['total_gmv']) }}</div>
                    <p class="text-xs text-slate-500 mt-1 flex items-center justify-between">
                        <span>Disbursed: ₹{{ number_format($stats['disbursed_volume']) }}</span>
                        <span class="text-emerald-600 font-semibold">{{ $stats['completed_bookings'] }} Completed</span>
                    </p>
                </div>
            </div>

            <!-- Platform Commission Revenue -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs hover:border-slate-300 transition">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="tracking-tight text-xs uppercase font-semibold text-slate-500">Platform Revenue (10%)</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-slate-400">
                        <rect width="20" height="14" x="2" y="5" rx="2" />
                        <line x1="2" x2="22" y1="10" y2="10" />
                    </svg>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold tabular-nums text-red-600">₹{{ number_format($stats['platform_fee_revenue']) }}</div>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $stats['active_bookings'] }} active escrow contracts
                    </p>
                </div>
            </div>

            <!-- Verification Queue -->
            <div class="rounded-xl border {{ $stats['pending_verifications'] > 0 ? 'border-amber-300 bg-amber-50/20' : 'border-slate-200' }} bg-white text-slate-900 shadow-xs hover:border-slate-300 transition">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="tracking-tight text-xs uppercase font-semibold text-slate-500">Verification Queue</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-slate-400">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold tabular-nums">{{ $stats['pending_verifications'] }}</div>
                    <p class="text-xs text-slate-500 mt-1">
                        <a href="{{ route('admin.verifications') }}" class="text-red-600 font-semibold hover:underline">Review IDs &rarr;</a>
                    </p>
                </div>
            </div>

            <!-- Active Campaigns & Pitches -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs hover:border-slate-300 transition">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <h3 class="tracking-tight text-xs uppercase font-semibold text-slate-500">Active Campaigns</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-slate-400">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                    </svg>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold tabular-nums">{{ $stats['campaigns_count'] }}</div>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-emerald-600 font-semibold">{{ $stats['applications_count'] }} pitches submitted</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- shadcn dashboard-01 Main Grid (Table Card on Left + Entity Breakdown on Right) -->
        <div class="grid gap-4 md:gap-6 lg:grid-cols-7">
            <!-- Left Card: Recent Campaign Briefs (5 Cols) -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs lg:col-span-4 flex flex-col justify-between">
                <div>
                    <div class="p-6 flex flex-row items-center justify-between border-b border-slate-100">
                        <div>
                            <h3 class="font-semibold text-base tracking-tight">Campaign Briefs Awaiting Review</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Moderate brand briefs before publishing to the talent marketplace.</p>
                        </div>
                        <a href="{{ route('admin.campaigns') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition hover:bg-slate-100 px-3 py-1.5 border border-slate-200">
                            View All &rarr;
                        </a>
                    </div>

                    <div class="p-0 overflow-x-auto">
                        <table class="w-full caption-bottom text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-100">
                                <tr>
                                    <th class="h-10 px-6 align-middle font-medium">Campaign</th>
                                    <th class="h-10 px-4 align-middle font-medium">Client</th>
                                    <th class="h-10 px-4 align-middle font-medium text-right">Budget</th>
                                    <th class="h-10 px-6 align-middle font-medium text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($pendingCampaigns as $camp)
                                    <tr class="hover:bg-slate-50/60 transition">
                                        <td class="p-6 py-4 align-middle">
                                            <div class="font-semibold text-slate-900 line-clamp-1">{{ $camp->title ?? $camp->campaign_name }}</div>
                                            <div class="text-xs text-slate-400 mt-0.5">{{ $camp->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td class="p-4 align-middle text-slate-600 text-xs font-medium">
                                            {{ $camp->brandProfile->company_name ?? 'Client' }}
                                        </td>
                                        <td class="p-4 align-middle text-right font-bold text-slate-900 tabular-nums">
                                            ₹{{ number_format($camp->budget_max ?: $camp->budget_min ?: $camp->budget) }}
                                        </td>
                                        <td class="p-6 py-4 align-middle text-right whitespace-nowrap">
                                            <form method="POST" action="{{ route('admin.campaigns.status', $camp->id) }}" class="inline-flex">
                                                @csrf
                                                <input type="hidden" name="status" value="published">
                                                <button type="submit" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold bg-slate-900 text-white hover:bg-black px-3 py-1.5 transition shadow-2xs">
                                                    Approve &rarr;
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-slate-400 text-xs">
                                            <span class="inline-flex items-center gap-1.5"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i> All campaign briefs are currently approved and live.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Showing latest pending campaign submissions</span>
                    <a href="{{ route('admin.campaigns') }}" class="font-semibold text-red-600 hover:underline">Manage All Campaigns</a>
                </div>
            </div>

            <!-- Right Card: Recent Platform Activity & Breakdowns (3 Cols) -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs lg:col-span-3 flex flex-col justify-between">
                <div>
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="font-semibold text-base tracking-tight">Marketplace Directory Overview</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Active ecosystem participants in talent network.</p>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Registered Brands Item -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                                    <i data-lucide="building-2" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold leading-none text-slate-900">Registered Brands</p>
                                    <p class="text-xs text-slate-500 mt-1">Verified hiring agencies & companies</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-bold text-slate-900 tabular-nums">{{ $stats['brands_count'] }}</span>
                                <a href="{{ route('admin.brands') }}" class="block text-[11px] text-red-600 font-semibold hover:underline">View</a>
                            </div>
                        </div>

                        <!-- Verified Creators Item -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-9 h-9 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center font-bold text-sm">
                                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold leading-none text-slate-900">Verified Creators & Talent</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $stats['models_count'] }} Models &bull; {{ $stats['anchors_count'] }} Anchors</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-bold text-slate-900 tabular-nums">{{ $stats['influencers_count'] }}</span>
                                <a href="{{ route('admin.influencers') }}" class="block text-[11px] text-red-600 font-semibold hover:underline">View</a>
                            </div>
                        </div>

                        <!-- Platform Disputes Item -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-9 h-9 rounded-full {{ $stats['open_disputes'] > 0 ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center font-bold text-sm">
                                    <i data-lucide="scale" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold leading-none text-slate-900">Arbitration & Disputes</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $stats['open_disputes'] > 0 ? 'Disputes awaiting resolution' : 'Zero disputes pending' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-bold {{ $stats['open_disputes'] > 0 ? 'text-rose-600' : 'text-emerald-600' }} tabular-nums">{{ $stats['open_disputes'] }}</span>
                                <a href="{{ route('admin.disputes') }}" class="block text-[11px] text-slate-600 font-semibold hover:underline">Center</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-100 bg-slate-50/50 rounded-b-xl">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">Platform Health</span>
                        <span class="inline-flex items-center gap-1.5 font-semibold text-emerald-600">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> 100% Operational
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
