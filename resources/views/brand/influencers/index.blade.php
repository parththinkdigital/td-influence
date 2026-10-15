@extends('layouts.brand')

@section('title', 'Search Talent & Creators | Brand Studio')

@section('content')
    <div class="space-y-8">
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-sky-50 via-blue-50 to-indigo-50 border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="px-3.5 py-1 bg-white/80 backdrop-blur border border-blue-200 text-[#0866FF] text-xs font-bold rounded-full inline-block mb-2 shadow-xs">
                        In-Panel Talent Directory
                    </span>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Search Talent & Creators</h1>
                    <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                        Discover verified models, digital influencers, anchors, and UGC video creators in or around Nashik & Maharashtra.
                    </p>
                </div>

                <div class="bg-white p-3 rounded-2xl border border-slate-200 text-center self-start md:self-auto shadow-xs">
                    <span class="block text-[10px] text-slate-400 uppercase font-bold">Verified Creators</span>
                    <span class="text-2xl font-black text-slate-900">{{ $talents->total() }}</span>
                </div>
            </div>

            <!-- In-Panel Filter Controls -->
            <form method="GET" action="{{ route('brand.influencers') }}" class="mt-6 pt-6 border-t border-slate-200/80 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, handle, or bio..." class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/10 focus:border-[#0866FF] transition">
                
                <select name="gender" class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500/10 focus:border-[#0866FF] transition">
                    <option value="">All Genders</option>
                    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="non_binary" {{ request('gender') === 'non_binary' ? 'selected' : '' }}>Non-Binary</option>
                </select>

                <input type="text" name="city" value="{{ request('city') }}" placeholder="Filter by City (e.g. Nashik, Pune)" class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/10 focus:border-[#0866FF] transition">

                <button type="submit" class="px-6 py-2.5 bg-[#0866FF] hover:bg-[#0052CC] text-white font-extrabold rounded-xl text-sm transition shadow-sm">
                    Filter Talent
                </button>
            </form>
        </div>

        <!-- Talent Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($talents as $talent)
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs flex flex-col justify-between hover:shadow-md hover:border-brand-200 transition group">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <!-- Avatar / Logo -->
                            <div class="w-14 h-14 rounded-2xl bg-pink-50 text-[#E1306C] overflow-hidden flex items-center justify-center font-black text-2xl border border-pink-200 flex-shrink-0">
                                @if($talent->profile_image || $talent->user->avatar)
                                    <img src="{{ $talent->profile_image ?: $talent->user->avatar }}" class="w-full h-full object-cover">
                                @else
                                    <span>{{ strtoupper(substr($talent->display_name ?: $talent->user->name, 0, 1)) }}</span>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h3 class="font-extrabold text-slate-900 text-base truncate group-hover:text-[#0866FF] transition">
                                    {{ $talent->display_name ?: $talent->user->name }}
                                </h3>
                                <span class="text-xs font-semibold text-slate-500 block truncate">@ {{ $talent->username }}</span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 text-[#108a00] border border-emerald-200 text-[10px] font-extrabold rounded-full mt-1">
                                    <i data-lucide="shield-check" class="w-3 h-3"></i> Level {{ $talent->verification_level ?: 1 }} Verified
                                </span>
                            </div>
                        </div>

                        <!-- Location & Categories -->
                        <div class="flex items-center text-xs text-slate-500 font-medium">
                            <span class="inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> {{ $talent->city ? $talent->city . ', ' . ($talent->state ?: 'Maharashtra') : 'Nashik, Maharashtra' }}</span>
                        </div>

                        @if(is_array($talent->primary_categories))
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(array_slice($talent->primary_categories, 0, 3) as $cat)
                                    <span class="px-2.5 py-1 bg-slate-50 text-slate-700 text-[11px] font-bold rounded-lg border border-slate-200">
                                        {{ $cat }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                            {{ $talent->bio ?: 'Digital creator specializing in commercial brand shoots & video campaigns.' }}
                        </p>

                        <!-- Social Accounts Summary -->
                        @if($talent->socialAccounts->count() > 0)
                            <div class="bg-slate-50 border border-slate-100 p-3 rounded-2xl flex items-center justify-between text-xs font-bold text-slate-700">
                                @foreach($talent->socialAccounts->take(2) as $acc)
                                    <div class="flex items-center space-x-1">
                                        @if(strtolower($acc->platform) === 'instagram') <i data-lucide="instagram" class="w-3.5 h-3.5 text-pink-600"></i> @elseif(strtolower($acc->platform) === 'youtube') <i data-lucide="youtube" class="w-3.5 h-3.5 text-red-600"></i> @else <i data-lucide="globe" class="w-3.5 h-3.5 text-slate-600"></i> @endif
                                        <span>{{ number_format($acc->followers) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Starting Rate</span>
                            <span class="text-base font-black text-slate-900">
                                ₹{{ number_format($talent->rates->first()->rate_amount ?? 15000) }}
                            </span>
                        </div>
                        <a href="{{ route('brand.influencers.show', $talent->id) }}" class="px-4 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition shadow-xs">
                            View Profile &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-white border border-slate-200 rounded-3xl space-y-3">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto"><i data-lucide="users" class="w-8 h-8"></i></div>
                    <h3 class="text-base font-bold text-slate-800">No creators found</h3>
                    <p class="text-slate-500 text-xs max-w-md mx-auto">Try broadening your search query or removing category filters.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $talents->links() }}
        </div>
    </div>
@endsection
