@extends('layouts.admin')

@section('title', 'Admin Platform Governance & Escrow Overview | Admin Gateway')

@section('content')
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Admin Governance Center</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 font-display">Governance &amp; Escrow Control Center</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Real-time marketplace escrow custody, creator verification pipeline, and platform telemetry.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.brands') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-slate-800 text-xs font-bold transition shadow-sm active:scale-95">
                    <i class="fa-solid fa-plus text-[10px] text-amber-400"></i>
                    <span>Issue Brand Account</span>
                </a>
                <a href="{{ route('admin.verifications') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-bold transition shadow-2xs">
                    <i class="fa-solid fa-id-card-clip text-red-500 text-[11px]"></i>
                    <span>Verify Talent ({{ $stats['pending_verifications'] }})</span>
                </a>
            </div>
        </div>

        <!-- VISUAL ESCROW FLOW PIPELINE -->
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-5 border-b border-slate-100 gap-2">
                <div>
                    <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-red-600 block">// PLATFORM ESCROW ENGINE</span>
                    <h3 class="text-sm font-bold text-slate-900 mt-0.5">End-to-End Escrow Custody &amp; Payout Flow</h3>
                </div>
                <div class="flex items-center space-x-2 text-xs font-mono">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-emerald-700 font-bold">100% Milestone Protected</span>
                </div>
            </div>

            <!-- 4-Stage Horizontal Pipeline -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pt-5">
                <!-- Step 1: Gross Deposited Volume -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 relative overflow-hidden">
                    <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                        <span class="font-mono text-[10px] uppercase font-bold text-slate-400">01. Gross Deposited</span>
                        <i class="fa-solid fa-vault text-slate-400"></i>
                    </div>
                    <div class="text-xl font-bold font-mono-numbers text-slate-900">₹{{ number_format($stats['total_gmv']) }}</div>
                    <p class="text-[11px] text-slate-500 mt-1 flex items-center justify-between">
                        <span>Total Escrow Volume</span>
                        <span class="text-emerald-600 font-semibold font-mono">{{ $stats['campaigns_count'] }} Deals</span>
                    </p>
                </div>

                <!-- Step 2: Currently Locked in Custody -->
                <div class="p-4 rounded-xl bg-amber-50/40 border border-amber-200/80 relative overflow-hidden">
                    <div class="flex items-center justify-between text-xs text-amber-700 mb-1">
                        <span class="font-mono text-[10px] uppercase font-bold text-amber-600">02. Held in Escrow</span>
                        <i class="fa-solid fa-lock text-amber-500"></i>
                    </div>
                    <div class="text-xl font-bold font-mono-numbers text-amber-900">
                        ₹{{ number_format(max(0, $stats['total_gmv'] - $stats['disbursed_volume'])) }}
                    </div>
                    <p class="text-[11px] text-amber-700/80 mt-1 flex items-center justify-between">
                        <span>Production Active</span>
                        <span class="font-bold font-mono">{{ $stats['active_bookings'] }} Contracts</span>
                    </p>
                </div>

                <!-- Step 3: Disbursed to Talent -->
                <div class="p-4 rounded-xl bg-emerald-50/40 border border-emerald-200/80 relative overflow-hidden">
                    <div class="flex items-center justify-between text-xs text-emerald-700 mb-1">
                        <span class="font-mono text-[10px] uppercase font-bold text-emerald-600">03. Disbursed Payouts</span>
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    </div>
                    <div class="text-xl font-bold font-mono-numbers text-emerald-900">₹{{ number_format($stats['disbursed_volume']) }}</div>
                    <p class="text-[11px] text-emerald-700/80 mt-1 flex items-center justify-between">
                        <span>Settled to Creators</span>
                        <span class="font-bold font-mono">{{ $stats['completed_bookings'] }} Paid</span>
                    </p>
                </div>

                <!-- Step 4: Platform Commission (10%) -->
                <div class="p-4 rounded-xl bg-red-50/40 border border-red-200/80 relative overflow-hidden">
                    <div class="flex items-center justify-between text-xs text-red-700 mb-1">
                        <span class="font-mono text-[10px] uppercase font-bold text-red-600">04. Platform Take (10%)</span>
                        <i class="fa-solid fa-coins text-red-500"></i>
                    </div>
                    <div class="text-xl font-bold font-mono-numbers text-red-700">₹{{ number_format($stats['platform_fee_revenue']) }}</div>
                    <p class="text-[11px] text-red-700/80 mt-1 flex items-center justify-between">
                        <span>Retained Earnings</span>
                        <span class="font-bold font-mono">10% Fixed Fee</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- 4-Card Executive KPI Grid -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <!-- Metric 1: Talent Roster by Category -->
            <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between pb-2">
                    <span class="text-xs uppercase font-bold font-mono text-slate-500">Talent Roster</span>
                    <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <div class="text-2xl font-black font-mono-numbers text-slate-900">{{ $stats['influencers_count'] }}</div>
                <div class="mt-2 text-xs text-slate-500 flex items-center justify-between pt-2 border-t border-slate-100 font-medium">
                    <span>{{ $stats['models_count'] }} Models</span>
                    <span class="text-slate-300">&bull;</span>
                    <span>{{ $stats['anchors_count'] }} Anchors</span>
                    <span class="text-slate-300">&bull;</span>
                    <a href="{{ route('admin.influencers') }}" class="text-red-600 font-bold hover:underline">Manage</a>
                </div>
            </div>

            <!-- Metric 2: Brand Accounts -->
            <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between pb-2">
                    <span class="text-xs uppercase font-bold font-mono text-slate-500">Registered Brands</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-building"></i>
                    </div>
                </div>
                <div class="text-2xl font-black font-mono-numbers text-slate-900">{{ $stats['brands_count'] }}</div>
                <div class="mt-2 text-xs text-slate-500 flex items-center justify-between pt-2 border-t border-slate-100 font-medium">
                    <span>Verified Hiring Clients</span>
                    <a href="{{ route('admin.brands') }}" class="text-red-600 font-bold hover:underline">Directory &rarr;</a>
                </div>
            </div>

            <!-- Metric 3: Verification Queue -->
            <div class="rounded-2xl border {{ $stats['pending_verifications'] > 0 ? 'border-amber-300 bg-amber-50/10' : 'border-slate-200/90 bg-white' }} p-5 shadow-xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between pb-2">
                    <span class="text-xs uppercase font-bold font-mono text-slate-500">ID Verification Queue</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                </div>
                <div class="text-2xl font-black font-mono-numbers {{ $stats['pending_verifications'] > 0 ? 'text-amber-600' : 'text-slate-900' }}">
                    {{ $stats['pending_verifications'] }}
                </div>
                <div class="mt-2 text-xs text-slate-500 flex items-center justify-between pt-2 border-t border-slate-100 font-medium">
                    <span>{{ $stats['pending_verifications'] > 0 ? 'Action required' : 'Queue cleared' }}</span>
                    <a href="{{ route('admin.verifications') }}" class="text-red-600 font-bold hover:underline">Review IDs &rarr;</a>
                </div>
            </div>

            <!-- Metric 4: Open Disputes -->
            <div class="rounded-2xl border {{ $stats['open_disputes'] > 0 ? 'border-rose-300 bg-rose-50/20' : 'border-slate-200/90 bg-white' }} p-5 shadow-xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between pb-2">
                    <span class="text-xs uppercase font-bold font-mono text-slate-500">Arbitration / Disputes</span>
                    <div class="w-8 h-8 rounded-lg {{ $stats['open_disputes'] > 0 ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center text-xs">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                </div>
                <div class="text-2xl font-black font-mono-numbers {{ $stats['open_disputes'] > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                    {{ $stats['open_disputes'] }}
                </div>
                <div class="mt-2 text-xs text-slate-500 flex items-center justify-between pt-2 border-t border-slate-100 font-medium">
                    <span>{{ $stats['open_disputes'] > 0 ? 'Open escrow disputes' : 'All contracts clean' }}</span>
                    <a href="{{ route('admin.disputes') }}" class="text-red-600 font-bold hover:underline">Arbitrate &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Main Workspace Grid: Pending Campaigns on Left + Activity on Right -->
        <div class="grid gap-6 lg:grid-cols-7">
            <!-- Left: Campaign Briefs Awaiting Moderation (4 Cols) -->
            <div class="rounded-2xl border border-slate-200/90 bg-white shadow-xs lg:col-span-4 flex flex-col justify-between overflow-hidden">
                <div>
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div>
                            <h3 class="font-bold text-sm text-slate-900 font-display">Campaign Briefs Awaiting Moderation</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Review and approve brand job briefs before publishing to marketplace.</p>
                        </div>
                        <a href="{{ route('admin.campaigns') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 border border-slate-200 px-3 py-1.5 rounded-xl hover:bg-slate-100 transition">
                            View All ({{ $stats['campaigns_count'] }})
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-700">
                            <thead class="bg-slate-50 text-slate-400 font-mono text-[10px] uppercase font-bold border-b border-slate-100">
                                <tr>
                                    <th class="px-5 py-3.5">Campaign Title</th>
                                    <th class="px-4 py-3.5">Brand Client</th>
                                    <th class="px-4 py-3.5 text-right">Escrow Budget</th>
                                    <th class="px-5 py-3.5 text-right">Moderation</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($pendingCampaigns as $camp)
                                    <tr class="hover:bg-slate-50/60 transition">
                                        <td class="px-5 py-4">
                                            <div class="font-bold text-slate-900 line-clamp-1 text-xs">{{ $camp->title ?? $camp->campaign_name }}</div>
                                            <div class="text-[11px] text-slate-400 font-mono mt-0.5">{{ $camp->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td class="px-4 py-4 text-slate-600 text-xs">
                                            <span class="font-semibold text-slate-800">{{ $camp->brandProfile->company_name ?? 'Client Brand' }}</span>
                                        </td>
                                        <td class="px-4 py-4 text-right font-bold text-slate-900 font-mono-numbers">
                                            ₹{{ number_format($camp->budget_max ?: $camp->budget_min ?: $camp->budget) }}
                                        </td>
                                        <td class="px-5 py-4 text-right whitespace-nowrap">
                                            <form method="POST" action="{{ route('admin.campaigns.status', $camp->id) }}" class="inline-flex">
                                                @csrf
                                                <input type="hidden" name="status" value="published">
                                                <button type="submit" class="inline-flex items-center space-x-1 px-3 py-1.5 bg-slate-900 hover:bg-black text-white rounded-lg text-xs font-bold transition shadow-2xs">
                                                    <span>Approve</span>
                                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-slate-400 text-xs">
                                            <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-2">
                                                <i class="fa-solid fa-check"></i>
                                            </div>
                                            <p class="font-bold text-slate-700">All campaign briefs are reviewed and approved</p>
                                            <p class="text-[11px] text-slate-400 mt-0.5">New submissions from brands will appear here immediately.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="p-4 border-t border-slate-100 bg-slate-50/30 flex items-center justify-between text-xs text-slate-500">
                    <span class="font-mono text-[11px]">{{ $stats['pending_campaigns'] }} pending briefs awaiting approval</span>
                    <a href="{{ route('admin.campaigns') }}" class="font-bold text-red-600 hover:underline">Open Campaign Manager &rarr;</a>
                </div>
            </div>

            <!-- Right: Urgent Actions Workbench & Directory Breakdown (3 Cols) -->
            <div class="rounded-2xl border border-slate-200/90 bg-white shadow-xs lg:col-span-3 flex flex-col justify-between overflow-hidden">
                <div>
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-sm text-slate-900 font-display">Moderator Priority Workbench</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Urgent compliance and verification items.</p>
                    </div>

                    <div class="p-6 space-y-5">
                        <!-- Pending Verifications Alert -->
                        <div class="p-4 rounded-xl border {{ $stats['pending_verifications'] > 0 ? 'bg-amber-50/50 border-amber-200' : 'bg-slate-50 border-slate-200/80' }} flex items-start space-x-3.5">
                            <div class="w-9 h-9 rounded-xl {{ $stats['pending_verifications'] > 0 ? 'bg-amber-100 text-amber-700' : 'bg-slate-200 text-slate-600' }} flex items-center justify-center font-bold text-sm flex-shrink-0">
                                <i class="fa-solid fa-id-card"></i>
                            </div>
                            <div class="flex-grow min-w-0">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-xs font-bold text-slate-900">Creator KYC Submissions</h4>
                                    <span class="font-mono text-xs font-bold {{ $stats['pending_verifications'] > 0 ? 'text-amber-700' : 'text-slate-500' }}">
                                        {{ $stats['pending_verifications'] }} Pending
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-1">Review government IDs and assign Level 1 - 5 badges.</p>
                                <a href="{{ route('admin.verifications') }}" class="inline-block mt-2 text-xs font-bold text-red-600 hover:underline">
                                    Open Verification Queue &rarr;
                                </a>
                            </div>
                        </div>

                        <!-- Open Disputes Alert -->
                        <div class="p-4 rounded-xl border {{ $stats['open_disputes'] > 0 ? 'bg-rose-50/50 border-rose-200' : 'bg-slate-50 border-slate-200/80' }} flex items-start space-x-3.5">
                            <div class="w-9 h-9 rounded-xl {{ $stats['open_disputes'] > 0 ? 'bg-rose-100 text-rose-700' : 'bg-slate-200 text-slate-600' }} flex items-center justify-center font-bold text-sm flex-shrink-0">
                                <i class="fa-solid fa-scale-balanced"></i>
                            </div>
                            <div class="flex-grow min-w-0">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-xs font-bold text-slate-900">Escrow Dispute Arbitration</h4>
                                    <span class="font-mono text-xs font-bold {{ $stats['open_disputes'] > 0 ? 'text-rose-700' : 'text-slate-500' }}">
                                        {{ $stats['open_disputes'] }} Cases
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-1">Resolve milestone release disagreements between brands and creators.</p>
                                <a href="{{ route('admin.disputes') }}" class="inline-block mt-2 text-xs font-bold text-red-600 hover:underline">
                                    Open Dispute Center &rarr;
                                </a>
                            </div>
                        </div>

                        <!-- Brand Credential Generator Quick Access -->
                        <div class="p-4 rounded-xl border border-blue-100 bg-blue-50/30 flex items-start space-x-3.5">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm flex-shrink-0">
                                <i class="fa-solid fa-key"></i>
                            </div>
                            <div class="flex-grow min-w-0">
                                <h4 class="text-xs font-bold text-slate-900">Brand Onboarding Dispatch</h4>
                                <p class="text-[11px] text-slate-500 mt-1">Generate verified login credentials for agency and brand partners.</p>
                                <a href="{{ route('admin.brands') }}" class="inline-block mt-2 text-xs font-bold text-blue-700 hover:underline">
                                    Issue Brand Account &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Status -->
                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-mono text-[11px]">Platform Protocol Status</span>
                    <span class="inline-flex items-center space-x-1.5 font-bold text-emerald-600">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>100% Operational</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
