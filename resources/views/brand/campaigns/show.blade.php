@extends('layouts.brand')

@section('title', ($campaign->title ?? $campaign->name) . ' | Brand Portal')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-semibold text-slate-700">{{ $campaign->category->name ?? 'General Niche' }}</span>
                @if($campaign->city)
                    <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-semibold text-slate-700 inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> {{ $campaign->city }}</span>
                @endif
                @if($campaign->status === 'published')
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold">Published & Active</span>
                @elseif($campaign->status === 'draft')
                    <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-bold">Draft</span>
                @else
                    <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-bold">{{ ucfirst($campaign->status) }}</span>
                @endif
            </div>
            <h1 class="text-3xl font-black text-slate-900">{{ $campaign->title ?? $campaign->name }}</h1>
            <p class="text-slate-700 font-bold text-base mt-1">
                Budget: ₹{{ number_format($campaign->budget_min ?: $campaign->budget) }} - ₹{{ number_format($campaign->budget_max ?: $campaign->budget) }} INR
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('brand.campaigns.edit', $campaign->id) }}" class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 shadow-sm transition">
                Edit Campaign
            </a>
            <a href="{{ route('brand.campaigns') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold rounded-xl transition">
                ← Back to Campaigns
            </a>
        </div>
    </div>

    @php
        $activeApps = $campaign->applications->where('status', '!=', 'rejected');
        $declinedApps = $campaign->applications->where('status', 'rejected');
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="{ filter: 'all', showDeclined: false }">
        <div class="lg:col-span-2 space-y-6">
            <!-- Main Active Applications Card -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <div class="flex items-center space-x-2">
                            <h3 class="text-lg font-black text-slate-900">Recent Applications</h3>
                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 text-xs font-black rounded-full border border-indigo-100">{{ $activeApps->count() }}</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Most recent pitches appear first &bull; click Chat to negotiate</p>
                    </div>

                    <!-- Filter Chips -->
                    <div class="flex items-center space-x-1.5 bg-slate-100 p-1 rounded-2xl text-xs font-bold">
                        <button type="button" @click="filter = 'all'" :class="filter === 'all' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-800'" class="px-3 py-1.5 rounded-xl transition">
                            All Active • {{ $activeApps->count() }}
                        </button>
                        <button type="button" @click="filter = 'shortlisted'" :class="filter === 'shortlisted' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-800'" class="px-3 py-1.5 rounded-xl transition">
                            Shortlisted • {{ $activeApps->where('status', 'shortlisted')->count() }}
                        </button>
                        <button type="button" @click="filter = 'selected'" :class="filter === 'selected' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-800'" class="px-3 py-1.5 rounded-xl transition">
                            Hired • {{ $activeApps->where('status', 'selected')->count() }}
                        </button>
                    </div>
                </div>

                <!-- Active Applications Stream (Recent First) -->
                <div class="space-y-4">
                    @forelse($activeApps as $app)
                        @php
                            $talent = $app->talentProfile;
                            $creatorName = $talent->display_name ?? ($app->talentProfile->user->name ?? 'Creator');
                            $creatorAvatar = $talent->profile_photo_url ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80';
                        @endphp
                        <div class="bg-slate-50/70 border border-slate-200 hover:border-slate-300 p-5 rounded-2xl space-y-3 transition"
                             x-show="filter === 'all' || (filter === 'shortlisted' && '{{ $app->status }}' === 'shortlisted') || (filter === 'selected' && '{{ $app->status }}' === 'selected')">
                            
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center space-x-3.5">
                                    <img src="{{ $creatorAvatar }}" class="w-12 h-12 rounded-2xl object-cover border border-slate-200 shadow-2xs">
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <h4 class="font-bold text-slate-900 text-base">{{ $creatorName }}</h4>
                                            @if($talent && $talent->city)
                                                <span class="px-2 py-0.5 bg-white border border-slate-200 text-slate-600 text-[10px] font-semibold rounded-md inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i> {{ $talent->city }}</span>
                                            @endif
                                            <span class="text-[10px] text-slate-400 font-medium hidden sm:inline">&bull; Applied {{ $app->created_at->diffForHumans() }}</span>
                                        </div>
                                        <span class="text-xs text-slate-500 font-medium">{{ $talent->primary_niche ?? 'Content Creator' }}</span>
                                    </div>
                                </div>
                                <div class="sm:text-right">
                                    <span class="text-slate-900 font-black text-lg block">₹{{ number_format($app->quoted_price) }}</span>
                                    <span class="text-[11px] text-slate-400 font-medium">Quoted Rate</span>
                                </div>
                            </div>

                            @if($app->cover_note || $app->proposal)
                                <div class="bg-white p-3.5 rounded-xl text-xs text-slate-700 leading-relaxed border border-slate-200">
                                    <span class="font-bold text-slate-900 block mb-1">Pitch & Cover Note:</span>
                                    {{ $app->cover_note ?: $app->proposal }}
                                </div>
                            @endif

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-2 border-t border-slate-200/60 gap-3">
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-slate-500 font-medium">Status:</span>
                                    @if($app->status === 'selected')
                                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-bold rounded-lg uppercase inline-flex items-center gap-1"><i data-lucide="check" class="w-3 h-3"></i> Selected & Hired</span>
                                    @elseif($app->status === 'shortlisted')
                                        <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-bold rounded-lg uppercase">Shortlisted</span>
                                    @else
                                        <span class="px-2.5 py-0.5 bg-sky-50 text-sky-700 border border-sky-100 text-[11px] font-bold rounded-lg uppercase">Under Review</span>
                                    @endif
                                </div>

                                <div class="flex items-center space-x-2 flex-wrap gap-y-2">
                                    <!-- Chat & Negotiate Button -->
                                    <a href="{{ route('brand.chat', $app->id) }}" class="px-3.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 text-xs font-bold rounded-xl transition flex items-center space-x-1.5 shadow-2xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        <span>Chat / Negotiate</span>
                                    </a>

                                    <form method="POST" action="{{ route('brand.applications.status', $app->id) }}" class="inline-flex space-x-1.5">
                                        @csrf
                                        @if($app->status !== 'shortlisted')
                                            <button type="submit" name="status" value="shortlisted" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold rounded-xl transition shadow-2xs">Shortlist</button>
                                        @endif
                                        @if($app->status !== 'selected')
                                            <button type="submit" name="status" value="selected" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-2xs">Hire & Confirm</button>
                                        @endif
                                        <button type="submit" name="status" value="rejected" class="px-2.5 py-1.5 bg-transparent hover:bg-rose-50 text-slate-400 hover:text-rose-600 text-xs font-medium rounded-xl transition" title="Move to Declined Drawer">Decline</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400 bg-slate-50 rounded-2xl">
                            <p class="text-sm font-bold text-slate-700">No active applications currently</p>
                            <p class="text-xs text-slate-400 mt-0.5">New creator applications in Nashik will appear here automatically.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Bottom Collapsible Drawer: Declined Applications -->
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden transition">
                <!-- Drawer Header / Trigger Bar -->
                <button type="button" @click="showDeclined = !showDeclined" class="w-full p-5 text-left flex items-center justify-between bg-slate-50/80 hover:bg-slate-100/80 transition cursor-pointer">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-slate-200/70 text-slate-600 flex items-center justify-center font-bold text-xs">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <h4 class="font-bold text-slate-900 text-sm">Declined Applications</h4>
                                <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-[10px] font-black rounded-full">{{ $declinedApps->count() }}</span>
                            </div>
                            <p class="text-[11px] text-slate-500 font-medium">Click to unfold / view archived pitches</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 text-xs font-bold text-slate-600">
                        <span x-text="showDeclined ? 'Hide Drawer' : 'Unfold Drawer'"></span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="showDeclined ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>

                <!-- Unfolded Content -->
                <div x-show="showDeclined" x-collapse x-cloak class="p-6 border-t border-slate-200 bg-slate-50/30 space-y-4">
                    @forelse($declinedApps as $app)
                        @php
                            $talent = $app->talentProfile;
                            $creatorName = $talent->display_name ?? ($app->talentProfile->user->name ?? 'Creator');
                            $creatorAvatar = $talent->profile_photo_url ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80';
                        @endphp
                        <div class="bg-white border border-slate-200 p-5 rounded-2xl space-y-3 shadow-2xs opacity-90 hover:opacity-100 transition">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center space-x-3.5">
                                    <img src="{{ $creatorAvatar }}" class="w-11 h-11 rounded-2xl object-cover border border-slate-200 grayscale-30">
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <h4 class="font-bold text-slate-900 text-sm">{{ $creatorName }}</h4>
                                            @if($talent && $talent->city)
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-semibold rounded-md inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i> {{ $talent->city }}</span>
                                            @endif
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-bold rounded-md uppercase">Declined</span>
                                        </div>
                                        <span class="text-xs text-slate-500">{{ $talent->primary_niche ?? 'Content Creator' }}</span>
                                    </div>
                                </div>
                                <div class="sm:text-right">
                                    <span class="text-slate-700 font-bold text-base block">₹{{ number_format($app->quoted_price) }}</span>
                                    <span class="text-[10px] text-slate-400">Original Quote</span>
                                </div>
                            </div>

                            @if($app->cover_note || $app->proposal)
                                <div class="bg-slate-50 p-3 rounded-xl text-xs text-slate-600 leading-relaxed border border-slate-100">
                                    {{ $app->cover_note ?: $app->proposal }}
                                </div>
                            @endif

                            <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                <span class="text-[11px] text-slate-400">Applied {{ $app->created_at->format('d M, Y') }}</span>

                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('brand.chat', $app->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                                        View Chat History
                                    </a>

                                    <form method="POST" action="{{ route('brand.applications.status', $app->id) }}">
                                        @csrf
                                        <button type="submit" name="status" value="shortlisted" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                            Reconsider & Shortlist
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-400">
                            <p class="text-xs font-medium">No declined applications in drawer.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-slate-900">Campaign Overview</h3>
                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Category / Niche:</span>
                        <span class="font-bold text-slate-900">{{ $campaign->category->name ?? 'General' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Location:</span>
                        <span class="font-bold text-slate-900">{{ $campaign->city ?: 'Nashik, Maharashtra' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Shoot Venue:</span>
                        <span class="font-bold text-slate-900">{{ $campaign->venue ?: 'Studio in Nashik' }}</span>
                    </div>
                </div>

                @if($campaign->deliverables && $campaign->deliverables->count() > 0)
                    <div class="pt-4 border-t border-slate-100 space-y-2">
                        <span class="text-xs font-bold text-slate-800">Required Deliverables:</span>
                        <div class="space-y-2 text-xs">
                            @foreach($campaign->deliverables as $del)
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                                    <span class="font-bold text-slate-900">{{ $del->deliverable_type ?? $del->name }}</span>
                                    <span class="text-slate-500 font-semibold">Qty: {{ $del->quantity }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
