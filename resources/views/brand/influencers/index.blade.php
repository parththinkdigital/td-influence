@extends('layouts.brand')

@section('title', 'Search Talent & Creators | Brand Studio')

@section('content')
    <div class="space-y-8">
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-indigo-50/70 via-purple-50/50 to-pink-50/30 border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-xs">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="px-3.5 py-1 bg-white border border-indigo-200/80 text-indigo-700 text-xs font-bold rounded-full inline-block mb-2 shadow-2xs">
                        Talent Discovery Console
                    </span>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Discover Verified Creators</h1>
                    <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                        Filter verified models, digital creators, event anchors, and UGC specialists in Nashik and across Maharashtra.
                    </p>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 text-center shadow-xs">
                    <span class="block text-[10px] text-slate-400 uppercase font-bold tracking-wider">Creators In Roster</span>
                    <span class="text-2xl font-black text-slate-900 font-display tabular-nums">{{ $talents->total() }}</span>
                </div>
            </div>

            <!-- In-Panel Filter Controls -->
            <form method="GET" action="{{ route('brand.influencers') }}" class="mt-6 pt-6 border-t border-slate-200/80 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, handle, or bio..." class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-xs font-semibold focus:outline-none focus:border-indigo-600 transition shadow-2xs">
                
                <select name="gender" class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-xs font-semibold focus:outline-none focus:border-indigo-600 transition shadow-2xs">
                    <option value="">All Genders</option>
                    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="non_binary" {{ request('gender') === 'non_binary' ? 'selected' : '' }}>Non-Binary</option>
                </select>

                <input type="text" name="city" value="{{ request('city') }}" placeholder="Filter by City (e.g. Nashik, Pune)" class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-xs font-semibold focus:outline-none focus:border-indigo-600 transition shadow-2xs">

                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl text-xs transition shadow-xs inline-flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Filter Talent</span>
                </button>
            </form>
        </div>

        <!-- Talent Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($talents as $talent)
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col justify-between hover:shadow-md hover:border-indigo-200 transition group">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <!-- Avatar / Photo -->
                            <div class="w-14 h-14 rounded-2xl overflow-hidden flex items-center justify-center border border-slate-200 flex-shrink-0 shadow-2xs bg-slate-100">
                                @if($talent->profile_image || $talent->user->avatar)
                                    <img src="{{ $talent->profile_image ?: $talent->user->avatar }}" class="w-full h-full object-cover">
                                @else
                                    <span class="font-black text-xl text-indigo-600">{{ strtoupper(substr($talent->display_name ?: $talent->user->name, 0, 1)) }}</span>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h3 class="font-black text-slate-900 text-base truncate font-display group-hover:text-indigo-600 transition">
                                    {{ $talent->display_name ?: $talent->user->name }}
                                </h3>
                                <span class="text-xs font-mono font-bold text-pink-600 block truncate">{{ '@' . $talent->username }}</span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 text-emerald-800 border border-emerald-200 text-[10px] font-black rounded-full mt-1">
                                    <i class="fa-solid fa-award text-amber-500 text-[9px]"></i> Level {{ $talent->verification_level ?: 1 }} Verified
                                </span>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-center text-xs text-slate-500 font-medium">
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-slate-400 text-xs"></i>
                                <span>{{ $talent->city ? $talent->city . ', ' . ($talent->state ?: 'Maharashtra') : 'Nashik, Maharashtra' }}</span>
                            </span>
                        </div>

                        @if(is_array($talent->primary_categories))
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(array_slice($talent->primary_categories, 0, 3) as $cat)
                                    <span class="px-2.5 py-1 bg-slate-50 text-slate-700 text-[10px] font-bold rounded-lg border border-slate-200/80">
                                        {{ $cat }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                            {{ $talent->bio ?: 'Verified creator specializing in commercial brand shoots, fashion styling & video content.' }}
                        </p>

                        <!-- Social Accounts Summary -->
                        @if($talent->socialAccounts->count() > 0)
                            <div class="bg-slate-50 border border-slate-100 p-3 rounded-2xl flex items-center justify-between text-xs font-bold text-slate-700">
                                @foreach($talent->socialAccounts->take(2) as $acc)
                                    <div class="flex items-center space-x-1.5">
                                        @if(strtolower($acc->platform) === 'instagram') 
                                            <i class="fa-brands fa-instagram text-[#E1306C] text-sm"></i>
                                        @elseif(strtolower($acc->platform) === 'youtube') 
                                            <i class="fa-brands fa-youtube text-[#FF0000] text-sm"></i>
                                        @else 
                                            <i class="fa-solid fa-globe text-slate-600 text-sm"></i>
                                        @endif
                                        <span class="font-mono">{{ number_format($acc->followers) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('brand.influencers.show', $talent->id) }}" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition shadow-2xs inline-flex items-center gap-1.5">
                            <span>View Comp Card</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                        <a href="{{ route('influencers.public.show', $talent->username) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:underline">
                            Public URL &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 p-16 text-center text-slate-400 bg-white rounded-3xl border border-slate-200/80">
                    <div class="w-16 h-16 rounded-3xl bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="font-bold text-slate-800 text-base">No creators matching your criteria</div>
                    <p class="text-xs text-slate-400 mt-1">Try clearing some filters or searching with broader keywords.</p>
                </div>
            @endforelse
        </div>

        @if(method_exists($talents, 'links'))
            <div class="mt-6">
                {{ $talents->links() }}
            </div>
        @endif
    </div>
@endsection
