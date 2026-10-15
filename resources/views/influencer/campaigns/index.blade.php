@extends('layouts.influencer')

@section('title', 'Find Brand Campaign Jobs & Briefs | Talent Studio')

@section('content')
    <div class="space-y-8">
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-pink-50 via-sky-50 to-blue-50 border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="px-3.5 py-1 bg-white/80 backdrop-blur border border-pink-200 text-[#E1306C] text-xs font-bold rounded-full inline-block mb-3 shadow-xs">
                        Marketplace Campaign Briefs
                    </span>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Open Brand Jobs & Campaign Briefs</h1>
                    <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                        Browse all open commercial jobs posted by verified brand clients and pitch your proposals directly.
                    </p>
                </div>

                <div class="bg-white p-2 rounded-2xl border border-slate-200 text-center self-start md:self-auto">
                    <span class="block text-[10px] text-slate-400 uppercase font-bold">Total Active Jobs</span>
                    <span class="text-2xl font-black text-slate-900">{{ $campaigns->total() }}</span>
                </div>
            </div>

            <!-- Filter & Search Controls -->
            <form method="GET" action="{{ route('influencer.campaigns') }}" class="mt-6 pt-6 border-t border-slate-200/80 flex flex-col md:flex-row gap-3">
                <div class="relative flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by brand name, job title, or keyword..." class="w-full bg-white border border-slate-300 rounded-xl pl-4 pr-10 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-[#0866FF]">
                </div>
                <select name="category" class="bg-white border border-slate-300 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-[#0866FF]">
                    <option value="all" {{ request('category') === 'all' || !request('category') ? 'selected' : '' }}>All Marketplace Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-6 py-3 bg-[#0866FF] hover:bg-[#0052CC] text-white font-extrabold rounded-xl text-sm transition shadow-sm">
                    Filter Jobs
                </button>
            </form>
        </div>

        <!-- All Campaigns Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($campaigns as $camp)
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs flex flex-col justify-between hover:shadow-md transition group">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="px-3 py-1 bg-slate-100 text-slate-800 text-xs font-extrabold rounded-full border border-slate-200">
                                {{ $camp->category->name ?? 'General' }}
                            </span>
                            <span class="text-[#0866FF] font-black text-xl">
                                ₹{{ number_format($camp->budget_max ?: $camp->budget_min ?: $camp->budget) }}
                                <span class="text-xs text-slate-400 font-normal">INR</span>
                            </span>
                        </div>
                        
                        <h3 class="text-lg font-black text-slate-900 mb-2 leading-snug group-hover:text-[#0866FF] transition">
                            {{ $camp->title ?: $camp->name }}
                        </h3>
                        <p class="text-slate-600 text-xs line-clamp-3 mb-4 leading-relaxed">
                            {{ $camp->description }}
                        </p>

                        <!-- Key Campaign Attributes -->
                        <div class="space-y-2 mb-4 text-xs text-slate-500">
                            @if($camp->work_mode)
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3.5 h-3.5"></i> Location / Mode:</span>
                                    <strong class="text-slate-800 capitalize">{{ str_replace('_', ' ', $camp->work_mode) }} {{ $camp->city ? $camp->city : '' }}</strong>
                                </div>
                            @endif

                            @if($camp->shoot_date)
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center gap-1"><i data-lucide="calendar" class="w-3.5 h-3.5"></i> Shoot Date:</span>
                                    <strong class="text-slate-800">{{ \Carbon\Carbon::parse($camp->shoot_date)->format('M d, Y') }}</strong>
                                </div>
                            @endif
                        </div>

                        <!-- Deliverables Summary -->
                        @if($camp->deliverables && $camp->deliverables->count() > 0)
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                @foreach($camp->deliverables->take(3) as $del)
                                    <span class="px-2.5 py-1 bg-slate-50 text-slate-700 text-[11px] font-bold rounded-lg border border-slate-200">
                                        {{ $del->quantity }}x {{ strtoupper($del->type) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-2">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold block uppercase">Brand Client</span>
                            <span class="text-xs font-extrabold text-slate-900">{{ $camp->brandProfile->company_name ?? 'Verified Brand' }}</span>
                        </div>
                        <a href="{{ route('influencer.campaigns.show', $camp->id) }}" class="px-5 py-2.5 rounded-2xl bg-slate-900 hover:bg-black text-white text-xs font-extrabold transition shadow-sm">
                            View Brief & Apply &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 py-16 text-center bg-white border border-slate-200 rounded-3xl space-y-3">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                        <i data-lucide="briefcase" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">No open brand jobs found</h3>
                    <p class="text-slate-500 text-xs max-w-md mx-auto">There are currently no active briefs matching your search filter. Try clearing filters to see all available campaign jobs.</p>
                    <a href="{{ route('influencer.campaigns') }}" class="inline-block px-5 py-2.5 bg-[#0866FF] text-white text-xs font-bold rounded-xl hover:bg-[#0052CC] transition">
                        Reset Filters
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $campaigns->links() }}
        </div>
    </div>
@endsection
