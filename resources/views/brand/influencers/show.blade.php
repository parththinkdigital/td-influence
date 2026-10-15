@extends('layouts.brand')

@section('title', $talent->display_name . ' | Talent Profile | Brand Studio')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8" x-data="{ showInviteModal: false }">
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <a href="{{ route('brand.influencers') }}" class="text-xs font-bold text-slate-500 hover:text-slate-900 flex items-center space-x-1">
                <span>&larr; Back to In-Panel Talent Search</span>
            </a>
            <span class="px-3 py-1 bg-emerald-50 text-[#108a00] border border-emerald-200 text-xs font-bold rounded-full inline-flex items-center gap-1">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Level {{ $talent->verification_level ?: 1 }} Verified Talent
            </span>
        </div>

        <!-- Main Talent Header Card -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs flex flex-col md:flex-row items-start justify-between gap-6">
            <div class="flex items-start space-x-5">
                <div class="w-20 h-20 rounded-2xl bg-pink-100 text-[#E1306C] border border-pink-200 overflow-hidden flex items-center justify-center font-black text-3xl flex-shrink-0">
                    @if($talent->profile_image || $talent->user->avatar)
                        <img src="{{ $talent->profile_image ?: $talent->user->avatar }}" class="w-full h-full object-cover">
                    @else
                        <span>{{ strtoupper(substr($talent->display_name ?: $talent->user->name, 0, 1)) }}</span>
                    @endif
                </div>

                <div class="space-y-2">
                    <div class="flex items-center space-x-3">
                        <h1 class="text-2xl font-black text-slate-900">{{ $talent->display_name ?: $talent->user->name }}</h1>
                        <span class="text-xs text-slate-400 font-semibold">@ {{ $talent->username }}</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 text-xs text-slate-600 font-medium">
                        <span class="inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> {{ $talent->city ?: 'Mumbai' }}, {{ $talent->country ?: 'India' }}</span>
                        @if($talent->height_cm) <span class="inline-flex items-center gap-1">• <i data-lucide="ruler" class="w-3.5 h-3.5 text-slate-400"></i> {{ $talent->height_cm }} cm</span> @endif
                        @if($talent->clothing_size) <span class="inline-flex items-center gap-1">• <i data-lucide="tag" class="w-3.5 h-3.5 text-slate-400"></i> Size {{ $talent->clothing_size }}</span> @endif
                    </div>

                    @if(is_array($talent->primary_categories))
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            @foreach($talent->primary_categories as $cat)
                                <span class="px-3 py-1 bg-slate-100 text-slate-800 text-xs font-bold rounded-lg border border-slate-200">
                                    {{ $cat }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-col space-y-3 w-full md:w-auto">
                <button @click="showInviteModal = true" class="px-6 py-3 bg-[#0866FF] hover:bg-[#0052CC] text-white font-extrabold text-xs rounded-2xl shadow-md transition text-center">
                    + Invite to Campaign Brief
                </button>
            </div>
        </div>

        <!-- Bio & Social Reach -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <!-- Bio -->
            <div class="md:col-span-7 bg-white border border-slate-200 rounded-3xl p-6 shadow-xs space-y-4">
                <h3 class="text-base font-extrabold text-slate-900">About Creator</h3>
                <p class="text-slate-600 text-sm leading-relaxed">{{ $talent->bio ?: 'Commercial model and digital creator available for photoshoots, brand endorsements, reels, and video campaigns.' }}</p>
            </div>

            <!-- Social Reach Stats -->
            <div class="md:col-span-5 bg-white border border-slate-200 rounded-3xl p-6 shadow-xs space-y-4">
                <h3 class="text-base font-extrabold text-slate-900">Social Channels & Reach</h3>
                
                <div class="space-y-3">
                    @forelse($talent->socialAccounts as $acc)
                        @php
                            $isYT = strtolower($acc->platform) === 'youtube';
                            $isIG = strtolower($acc->platform) === 'instagram';
                        @endphp
                        <div class="bg-slate-50 border border-slate-100 p-3.5 rounded-2xl flex items-center justify-between text-xs font-bold">
                            <div class="flex items-center space-x-2.5">
                                <div class="w-7 h-7 rounded-xl flex items-center justify-center
                                    @if($isIG) bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 text-white shadow-2xs
                                    @elseif($isYT) bg-gradient-to-tr from-red-600 via-rose-600 to-red-700 text-white shadow-2xs
                                    @else bg-blue-50 text-[#0866FF] border border-blue-200 @endif">
                                    @if($isIG) <i data-lucide="instagram" class="w-4 h-4 text-white"></i>
                                    @elseif($isYT) <i data-lucide="youtube" class="w-4 h-4 text-white"></i>
                                    @else <i data-lucide="globe" class="w-4 h-4"></i> @endif
                                </div>
                                <span class="capitalize text-slate-800">{{ $acc->platform }} (@ {{ $acc->username }})</span>
                            </div>
                            <span class="text-[#0866FF] font-black">{{ number_format($acc->followers) }} followers</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400">No social accounts connected yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Dynamic Interactive Performance & Verified Deliverables Analytics -->
        <x-social-analytics-card :socialAccounts="$talent->socialAccounts" :talent="$talent" />

        <!-- Packages & Rates -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs space-y-4">
            <h3 class="text-base font-extrabold text-slate-900">Service Packages & Gigs</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse($talent->rates as $gig)
                    <div class="bg-slate-50 border border-slate-200 p-5 rounded-2xl space-y-2">
                        <span class="text-xs font-extrabold text-slate-900 uppercase block">{{ str_replace('_', ' ', $gig->rate_type) }}</span>
                        <span class="text-xl font-black text-slate-900 block">₹{{ number_format($gig->rate_amount) }} <span class="text-xs text-slate-400 font-normal">INR</span></span>
                        @if($gig->notes)
                            <p class="text-xs text-slate-500 line-clamp-2">{{ $gig->notes }}</p>
                        @endif
                    </div>
                @empty
                    <div class="col-span-3 text-xs text-slate-400">Starting package rate: ₹15,000 INR</div>
                @endforelse
            </div>
        </div>

        <!-- INVITE TO CAMPAIGN MODAL -->
        <div x-show="showInviteModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
            <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-xl" @click.away="showInviteModal = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-lg">Invite {{ $talent->display_name }} to Job</h3>
                        <p class="text-xs text-slate-500">Select one of your active campaign briefs</p>
                    </div>
                    <button @click="showInviteModal = false" class="text-slate-400 hover:text-slate-900 font-bold text-xl">&times;</button>
                </div>

                @if($myCampaigns->count() > 0)
                    <form method="GET" action="{{ route('brand.campaigns.show', $myCampaigns->first()->id) }}" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Select Campaign Brief</label>
                            <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF]">
                                @foreach($myCampaigns as $c)
                                    <option value="{{ $c->id }}">{{ $c->title }} (₹{{ number_format($c->budget_min) }} - ₹{{ number_format($c->budget_max) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <button type="button" @click="showInviteModal = false" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-xs">Cancel</button>
                            <button type="submit" class="px-6 py-3 bg-[#0866FF] text-white font-extrabold text-xs rounded-xl shadow-md">
                                Open Brief & Invite
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-6 space-y-3">
                        <p class="text-xs text-slate-500">You don't have any published campaign briefs yet.</p>
                        <a href="{{ route('brand.campaigns.create') }}" class="inline-block px-5 py-2.5 bg-[#0866FF] text-white font-extrabold text-xs rounded-xl shadow-md">
                            + Post New Campaign Brief
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
