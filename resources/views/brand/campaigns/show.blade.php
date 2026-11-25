@extends('layouts.brand')

@section('title', ($campaign->title ?? $campaign->name) . ' | Brand Portal')

@section('content')
<div class="space-y-8" x-data="{ 
    filter: 'all', 
    showDeclined: false 
}">
    <!-- Top Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200/80 pb-5">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <span class="px-3 py-1 bg-indigo-50 border border-indigo-100 rounded-full text-xs font-bold text-indigo-700 uppercase tracking-wider">
                    {{ $campaign->category->name ?? 'General Niche' }}
                </span>
                @if($campaign->city)
                    <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-semibold text-slate-700 inline-flex items-center gap-1">
                        <i class="fa-solid fa-location-dot text-slate-400 text-xs"></i>
                        <span>{{ $campaign->city }}</span>
                    </span>
                @endif
                @if($campaign->status === 'published')
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold inline-flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published & Active
                    </span>
                @elseif($campaign->status === 'draft')
                    <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-bold">Draft</span>
                @else
                    <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-bold">{{ ucfirst($campaign->status) }}</span>
                @endif
            </div>
            <h1 class="text-3xl font-black text-slate-900 font-display tracking-tight">{{ $campaign->title ?? $campaign->name }}</h1>
            <p class="text-slate-600 font-bold text-sm mt-1">
                Target Budget: <span class="text-slate-900 font-black">₹{{ number_format($campaign->budget_min ?: $campaign->budget) }} - ₹{{ number_format($campaign->budget_max ?: $campaign->budget) }}</span> INR
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('brand.campaigns.edit', $campaign->id) }}" class="px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 shadow-2xs transition inline-flex items-center gap-1.5">
                <i class="fa-solid fa-pen-to-square text-xs"></i>
                <span>Edit Campaign</span>
            </a>
            <a href="{{ route('brand.campaigns') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold rounded-xl transition inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>All Campaigns</span>
            </a>
        </div>
    </div>

    @php
        $activeApps = $campaign->applications->where('status', '!=', 'rejected');
        $declinedApps = $campaign->applications->where('status', 'rejected');
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Active Applications Pitch Review Board (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <div class="flex items-center space-x-2">
                            <h3 class="text-base font-black text-slate-900 font-display">Creator Pitch Review Board</h3>
                            <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 text-xs font-black rounded-full border border-indigo-100">{{ $activeApps->count() }}</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Filter pitches by status, inspect comp cards, negotiate in chat, and lock escrow.</p>
                    </div>

                    <!-- Filter Chips -->
                    <div class="flex items-center space-x-1.5 bg-slate-100 p-1 rounded-2xl text-xs font-bold">
                        <button type="button" @click="filter = 'all'" :class="filter === 'all' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-800'" class="px-3 py-1.5 rounded-xl transition">
                            All Active ({{ $activeApps->count() }})
                        </button>
                        <button type="button" @click="filter = 'shortlisted'" :class="filter === 'shortlisted' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-800'" class="px-3 py-1.5 rounded-xl transition">
                            Shortlisted ({{ $activeApps->where('status', 'shortlisted')->count() }})
                        </button>
                        <button type="button" @click="filter = 'selected'" :class="filter === 'selected' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-800'" class="px-3 py-1.5 rounded-xl transition">
                            Hired ({{ $activeApps->where('status', 'selected')->count() }})
                        </button>
                    </div>
                </div>

                <!-- Active Applications Stream -->
                <div class="space-y-4">
                    @forelse($activeApps as $app)
                        @php
                            $talent = $app->talentProfile;
                            $creatorName = $talent->display_name ?? ($app->talentProfile->user->name ?? 'Creator');
                            $creatorAvatar = $talent->profile_photo_url ?? ($talent->profile_image ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80');
                        @endphp
                        <div class="bg-slate-50/70 border border-slate-200/80 hover:border-slate-300 p-5 rounded-2xl space-y-3.5 transition"
                             x-show="filter === 'all' || (filter === 'shortlisted' && '{{ $app->status }}' === 'shortlisted') || (filter === 'selected' && '{{ $app->status }}' === 'selected')">
                            
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center space-x-3.5">
                                    <img src="{{ $creatorAvatar }}" class="w-12 h-12 rounded-2xl object-cover border border-slate-200 shadow-2xs">
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <h4 class="font-bold text-slate-900 text-base font-display">{{ $creatorName }}</h4>
                                            @if($talent && $talent->city)
                                                <span class="px-2 py-0.5 bg-white border border-slate-200 text-slate-600 text-[10px] font-semibold rounded-md inline-flex items-center gap-1">
                                                    <i class="fa-solid fa-location-dot text-[9px] text-slate-400"></i> {{ $talent->city }}
                                                </span>
                                            @endif
                                            <span class="text-[10px] text-slate-400 font-medium hidden sm:inline">&bull; Applied {{ $app->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2 mt-0.5">
                                            <span class="text-xs text-pink-600 font-mono font-bold">{{ '@' . ($talent->username ?? 'talent') }}</span>
                                            <span class="text-slate-300">&bull;</span>
                                            <span class="text-xs text-slate-500 font-medium">{{ $talent->primary_niche ?? 'Creator' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sm:text-right">
                                    <span class="text-slate-900 font-black text-xl font-display tabular-nums block">₹{{ number_format($app->quoted_price) }}</span>
                                    <span class="text-[11px] text-slate-400 font-medium">Quoted Rate</span>
                                </div>
                            </div>

                            @if($app->cover_note || $app->proposal)
                                <div class="bg-white p-3.5 rounded-xl text-xs text-slate-700 leading-relaxed border border-slate-200/80">
                                    <span class="font-bold text-slate-900 block mb-1">Pitch & Proposal:</span>
                                    {{ $app->cover_note ?: $app->proposal }}
                                </div>
                            @endif

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-2 border-t border-slate-200/60 gap-3">
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-slate-500 font-medium">Stage:</span>
                                    @if($app->status === 'selected')
                                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-bold rounded-lg uppercase inline-flex items-center gap-1">
                                            <i class="fa-solid fa-check text-[9px]"></i> Hired & Escrow Held
                                        </span>
                                    @elseif($app->status === 'shortlisted')
                                        <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-bold rounded-lg uppercase">Shortlisted</span>
                                    @else
                                        <span class="px-2.5 py-0.5 bg-sky-50 text-sky-700 border border-sky-100 text-[11px] font-bold rounded-lg uppercase">Under Review</span>
                                    @endif
                                </div>

                                <div class="flex items-center space-x-2 flex-wrap gap-y-2">
                                    <!-- Chat Button -->
                                    <a href="{{ route('brand.chat', $app->id) }}" class="px-3.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 text-xs font-bold rounded-xl transition flex items-center space-x-1.5 shadow-2xs">
                                        <i class="fa-regular fa-comment-dots text-xs"></i>
                                        <span>Chat / Negotiate</span>
                                    </a>

                                    <form method="POST" action="{{ route('brand.applications.status', $app->id) }}" class="inline-flex space-x-1.5">
                                        @csrf
                                        @if($app->status !== 'shortlisted')
                                            <button type="submit" name="status" value="shortlisted" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold rounded-xl transition shadow-2xs">Shortlist</button>
                                        @endif
                                        @if($app->status !== 'selected')
                                            <button type="submit" name="status" value="selected" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-2xs inline-flex items-center gap-1">
                                                <i class="fa-solid fa-shield-halved text-[10px]"></i>
                                                <span>Hire & Hold Escrow</span>
                                            </button>
                                        @endif
                                        <button type="submit" name="status" value="rejected" class="px-2.5 py-1.5 bg-transparent hover:bg-rose-50 text-slate-400 hover:text-rose-600 text-xs font-medium rounded-xl transition" title="Decline application">Decline</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-slate-400 bg-slate-50 rounded-2xl">
                            <i class="fa-solid fa-paper-plane text-3xl mb-2 text-slate-300"></i>
                            <div class="font-bold text-slate-700">No applications received yet</div>
                            <p class="text-xs text-slate-400 mt-1">Creator pitches for this requirement will appear here.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Campaign Brief Details & Deliverables (1 Col) -->
        <div class="space-y-6">
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-5">
                <h3 class="text-base font-black text-slate-900 font-display border-b border-slate-100 pb-3">Campaign Overview</h3>
                
                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 uppercase font-bold text-[10px] block">Objective & Brief</span>
                        <p class="text-slate-700 mt-1 leading-relaxed">{{ $campaign->description }}</p>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-slate-400 uppercase font-bold text-[10px] block mb-2">Required Deliverables</span>
                        <div class="space-y-1.5">
                            @forelse($campaign->deliverables as $del)
                                <div class="flex items-center justify-between bg-slate-50 p-2.5 rounded-xl border border-slate-200/80 text-xs font-bold text-slate-800">
                                    <span>{{ $del->deliverable_name }}</span>
                                    <span class="text-indigo-600 tabular-nums font-black">{{ $del->quantity }}x</span>
                                </div>
                            @empty
                                <span class="text-slate-400">Standard collaboration deliverables.</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-slate-400 uppercase font-bold text-[10px] block mb-1">Target Shoot / Release Date</span>
                        <span class="font-bold text-slate-800">{{ $campaign->shoot_date ? $campaign->shoot_date->format('M d, Y') : 'Mutual Timeline' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
