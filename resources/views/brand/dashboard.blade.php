@extends('layouts.brand')

@section('title', 'Brand Dashboard | Talent Marketplace')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    <span>Brand Command Center</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 font-display">
                    {{ auth()->user()->brandProfile->company_name ?? auth()->user()->name }}
                </h1>
                <p class="text-slate-500 text-sm mt-0.5">Campaign briefs, creator proposals, contract escrow, and tax invoices.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('brand.influencers') }}" class="inline-flex items-center justify-center rounded-xl text-xs font-bold transition border border-slate-200 bg-white hover:bg-slate-50 text-slate-800 h-10 px-4 shadow-2xs">
                    <i class="fa-solid fa-magnifying-glass mr-2 text-slate-400 text-xs"></i>
                    <span>Discover Creators</span>
                </a>
                <a href="{{ route('brand.campaigns.create') }}" class="inline-flex items-center justify-center rounded-xl text-xs font-bold bg-indigo-600 text-white hover:bg-indigo-700 h-10 px-5 shadow-xs transition active:scale-95">
                    <i class="fa-solid fa-plus mr-1.5 text-xs"></i>
                    <span>Post Requirement</span>
                </a>
            </div>
        </div>

        <!-- Action Needed Alert Ribbon (if pending pitches or submissions exist) -->
        @if(($stats['pending_applications'] ?? 0) > 0 || ($stats['pending_campaigns'] ?? 0) > 0)
            <div class="bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-transparent border border-amber-200/80 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center space-x-3.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 text-base shadow-xs">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 font-display">
                            You have {{ $stats['pending_applications'] ?? 0 }} creator pitch(es) awaiting your review
                        </h4>
                        <p class="text-xs text-slate-500 mt-0.5">Review candidate quotes and shortlist creators to lock in commercial terms before campaign deadlines.</p>
                    </div>
                </div>
                <a href="{{ route('brand.campaigns') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition shadow-xs flex-shrink-0">
                    <span>Review Pitches</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        @endif

        <!-- 4-Card Top Metric Grid -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Active Campaigns -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between pb-3">
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Active Campaigns</span>
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                </div>
                <div class="text-2xl font-black tabular-nums text-slate-900 font-display">{{ $stats['active_campaigns'] }}</div>
                <p class="text-[11px] text-slate-500 mt-1 flex items-center justify-between">
                    <span>Live casting briefs</span>
                    <a href="{{ route('brand.campaigns') }}" class="text-indigo-600 font-bold hover:underline">View briefs &rarr;</a>
                </p>
            </div>

            <!-- Pitches Received -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between pb-3">
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Pitches Received</span>
                    <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                </div>
                <div class="text-2xl font-black tabular-nums text-slate-900 font-display">{{ $stats['total_applications'] }}</div>
                <p class="text-[11px] text-slate-500 mt-1 flex items-center justify-between">
                    <span class="text-emerald-600 font-bold">{{ $stats['shortlisted_applications'] }} shortlisted</span>
                    <span class="text-slate-400">Total submitted</span>
                </p>
            </div>

            <!-- Active Collaborations -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between pb-3">
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Active Orders</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                </div>
                <div class="text-2xl font-black tabular-nums text-slate-900 font-display">{{ $stats['active_collaborations'] ?? 0 }}</div>
                <p class="text-[11px] text-slate-500 mt-1 flex items-center justify-between">
                    <span>Production & Escrow</span>
                    <a href="{{ route('brand.bookings') }}" class="text-emerald-600 font-bold hover:underline">Track orders &rarr;</a>
                </p>
            </div>

            <!-- Needs Action / Pending -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between pb-3">
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Needs Review</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                </div>
                <div class="text-2xl font-black tabular-nums text-amber-600 font-display">{{ $stats['pending_applications'] }}</div>
                <p class="text-[11px] text-slate-500 mt-1 flex items-center justify-between">
                    <span>Awaiting your decision</span>
                    <a href="{{ route('brand.campaigns') }}" class="text-amber-600 font-bold hover:underline">Review &rarr;</a>
                </p>
            </div>
        </div>

        <!-- Main Grid: Recent Creator Pitches (Left) + Quick Campaign Overview (Right) -->
        <div class="grid gap-6 lg:grid-cols-7">
            <!-- Left Card: Recent Creator Applications Table (4 Cols) -->
            <div class="rounded-3xl border border-slate-200/80 bg-white text-slate-900 shadow-xs lg:col-span-4 flex flex-col justify-between overflow-hidden">
                <div>
                    <div class="p-6 flex flex-row items-center justify-between border-b border-slate-100 bg-slate-50/50">
                        <div>
                            <h3 class="font-black text-base tracking-tight font-display">Recent Creator Pitches</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Pitches submitted by creators for your open campaign briefs.</p>
                        </div>
                        <a href="{{ route('brand.campaigns') }}" class="inline-flex items-center justify-center rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 transition hover:bg-slate-100 px-3.5 py-2 border border-slate-200 bg-white shadow-2xs">
                            <span>All Campaigns</span>
                            <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-700">
                            <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[11px] border-b border-slate-100">
                                <tr>
                                    <th class="p-4 pl-6">Creator</th>
                                    <th class="p-4">Campaign</th>
                                    <th class="p-4 text-right">Quoted Fee</th>
                                    <th class="p-4 pr-6 text-right">Quick Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-sans">
                                @forelse($recentApplications as $app)
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <td class="p-4 pl-6 font-bold text-slate-900">
                                            <div class="flex items-center space-x-3">
                                                <img src="{{ ($app->talentProfile->profile_image ?? $app->influencerProfile->profile_image ?? '') ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop' }}" 
                                                     class="w-9 h-9 rounded-xl object-cover border border-slate-200 shadow-2xs">
                                                <div class="min-w-0">
                                                    <div class="font-black text-slate-900 truncate">{{ $app->talentProfile->display_name ?? $app->influencerProfile->display_name ?? 'Creator' }}</div>
                                                    <div class="text-[10px] text-pink-600 font-mono font-bold">{{ '@' . ($app->talentProfile->username ?? 'talent') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4 text-slate-600 font-medium">
                                            <span class="line-clamp-1 text-slate-800 font-bold">{{ $app->campaign->title ?: ($app->campaign->name ?: 'Campaign') }}</span>
                                            <span class="text-[10px] text-slate-400">{{ $app->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td class="p-4 text-right font-black text-slate-900 tabular-nums text-sm">
                                            ₹{{ number_format($app->quoted_price) }}
                                        </td>
                                        <td class="p-4 pr-6 text-right whitespace-nowrap">
                                            <div class="inline-flex items-center space-x-1.5">
                                                <a href="{{ route('brand.chat', $app->id) }}" class="inline-flex items-center justify-center rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 px-3 py-1.5 transition">
                                                    <i class="fa-regular fa-comment-dots mr-1"></i>
                                                    <span>Chat</span>
                                                </a>
                                                <form method="POST" action="{{ route('brand.applications.status', $app->id) }}" class="inline-flex">
                                                    @csrf
                                                    @if($app->status !== 'selected')
                                                        <button type="submit" name="status" value="selected" class="inline-flex items-center justify-center rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 transition shadow-2xs">
                                                            <i class="fa-solid fa-check mr-1 text-[10px]"></i>
                                                            <span>Hire</span>
                                                        </button>
                                                    @else
                                                        <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-bold text-[10px] uppercase">Hired</span>
                                                    @endif
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-12 text-center text-slate-400">
                                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-xl">
                                                <i class="fa-solid fa-inbox"></i>
                                            </div>
                                            <div class="font-bold text-slate-700">No pitches received yet</div>
                                            <p class="text-xs text-slate-400 mt-0.5">Post a campaign requirement to begin receiving creator quotes.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Card: Active Campaigns Summary (3 Cols) -->
            <div class="rounded-3xl border border-slate-200/80 bg-white text-slate-900 shadow-xs lg:col-span-3 flex flex-col justify-between overflow-hidden">
                <div>
                    <div class="p-6 flex flex-row items-center justify-between border-b border-slate-100 bg-slate-50/50">
                        <div>
                            <h3 class="font-black text-base tracking-tight font-display">Active Campaigns</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Your live briefs and application pipelines.</p>
                        </div>
                        <a href="{{ route('brand.campaigns.create') }}" class="text-xs font-bold text-indigo-600 hover:underline">
                            + New Brief
                        </a>
                    </div>

                    <div class="p-6 space-y-4">
                        @forelse($recentCampaigns as $camp)
                            <div class="p-4 rounded-2xl border border-slate-200/80 hover:border-slate-300 transition space-y-2 bg-slate-50/40">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 text-[10px] font-extrabold uppercase">
                                        {{ $camp->category->name ?? 'General' }}
                                    </span>
                                    <span class="text-xs font-black text-slate-900 tabular-nums">
                                        ₹{{ number_format($camp->budget_min ?: $camp->budget) }} - ₹{{ number_format($camp->budget_max ?: $camp->budget) }}
                                    </span>
                                </div>
                                <h4 class="font-bold text-slate-900 text-sm line-clamp-1">
                                    <a href="{{ route('brand.campaigns.show', $camp->id) }}" class="hover:text-indigo-600 transition">
                                        {{ $camp->title ?: $camp->name }}
                                    </a>
                                </h4>
                                <div class="flex items-center justify-between text-xs text-slate-500 pt-1 border-t border-slate-200/60">
                                    <span class="inline-flex items-center gap-1">
                                        <i class="fa-solid fa-users text-slate-400 text-[10px]"></i>
                                        <span>{{ $camp->applications()->count() }} Pitches</span>
                                    </span>
                                    <a href="{{ route('brand.campaigns.show', $camp->id) }}" class="font-bold text-indigo-600 hover:underline inline-flex items-center gap-1">
                                        <span>Review Board</span>
                                        <i class="fa-solid fa-arrow-right text-[9px]"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-400">
                                <p class="text-xs">No active campaigns posted yet.</p>
                                <a href="{{ route('brand.campaigns.create') }}" class="inline-block mt-3 px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold">
                                    Post Your First Campaign
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between text-xs">
                    <span class="text-slate-500">Need custom enterprise casting?</span>
                    <a href="{{ route('brand.influencers') }}" class="font-bold text-indigo-600 hover:underline">
                        Explore Talent Roster &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
