@extends('layouts.app')

@section('title', 'Browse Campaign Briefs & Casting Calls | Talent Marketplace')

@section('content')
    <!-- Directory Header & Filter -->
    <section class="py-12 lg:py-16 bg-white border-b border-slate-200 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="max-w-2xl space-y-2">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-600 font-display block">Open Casting Calls & Briefs</span>
                <h1 class="text-3xl sm:text-5xl font-black font-display text-slate-900 tracking-tight">
                    Explore <span class="text-brand-600">Brand Campaigns</span>
                </h1>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    Discover open sponsorship opportunities, fashion shoots, and UGC briefs. Apply directly with your custom rate proposal.
                </p>
            </div>

            <!-- In-Directory Filter Form -->
            <form method="GET" action="{{ route('campaigns.public') }}" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="lg:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by campaign title, brand, Nashik/location, or requirements..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div>
                    <select name="category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm shadow-sm transition">
                        Filter Briefs
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Campaigns Grid -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($campaigns as $campaign)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md hover:border-brand-300 transition duration-200 flex flex-col justify-between space-y-6 group">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 bg-brand-50 text-brand-700 border border-brand-200 text-xs font-bold rounded-full">
                                    {{ $campaign->category->name ?? 'General' }}
                                </span>
                                <span class="text-base font-black text-emerald-600 font-display">
                                    ₹{{ number_format($campaign->budget_max ?: $campaign->budget_min ?: $campaign->budget) }}
                                </span>
                            </div>

                            <div>
                                <h3 class="text-lg font-bold text-slate-900 leading-snug group-hover:text-brand-600 transition font-display">
                                    {{ $campaign->title ?: $campaign->name }}
                                </h3>
                                <span class="text-xs text-slate-500 font-semibold block mt-1">
                                    By {{ $campaign->brandProfile->company_name ?? 'Verified Brand' }}
                                </span>
                            </div>

                            <p class="text-slate-600 text-xs line-clamp-3 leading-relaxed">
                                {{ $campaign->description }}
                            </p>

                            <!-- Deliverable Tags -->
                            @if($campaign->deliverables && $campaign->deliverables->count() > 0)
                                <div class="flex flex-wrap gap-1.5 pt-1">
                                    @foreach($campaign->deliverables->take(2) as $del)
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200 text-[11px] text-slate-700 font-medium inline-flex items-center gap-1">
                                            <i data-lucide="package" class="w-3 h-3 text-slate-500"></i>
                                            <span>{{ $del->quantity }}x {{ $del->name }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Card Action -->
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-medium inline-flex items-center gap-1">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i>
                                <span>{{ $campaign->city ?: 'Remote / Any' }}</span>
                            </span>
                            <a href="{{ route('campaigns.public.show', $campaign->slug) }}" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold transition shadow-sm">
                                View & Apply &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-20 bg-white rounded-3xl border border-slate-200 shadow-sm space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                            <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 font-display">No active campaign briefs found</h3>
                        <p class="text-slate-500 text-xs max-w-sm mx-auto">Try selecting a different category or resetting your search filter.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $campaigns->links() }}
            </div>
        </div>
    </section>
@endsection
