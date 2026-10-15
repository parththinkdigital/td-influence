@extends('layouts.brand')

@section('title', $list->name . ' — Talent Roster | Brand Studio')

@section('content')
    <div class="space-y-6 sm:space-y-8" x-data="{ bulkInviteModalOpen: false }">
        <!-- Header & Summary -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-semibold text-slate-500 mb-1">
                    <a href="{{ route('brand.lists.index') }}" class="hover:text-brand-600">&larr; Back to All Rosters</a>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight font-display">{{ $list->name }}</h1>
                <p class="text-slate-600 text-xs sm:text-sm">{{ $list->description ?: 'Curated talent roster for brand influencer campaigns.' }}</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('influencers.public') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-2xl transition">
                    + Add More Talent
                </a>
                @if($list->talents->count() > 0)
                    <button type="button" @click="bulkInviteModalOpen = true" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-2xl shadow-sm transition flex items-center space-x-2">
                        <i data-lucide="zap" class="w-3.5 h-3.5"></i>
                        <span>Bulk Invite All • {{ $list->talents->count() }}</span>
                    </button>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Aggregate Roster KPI Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-2xs">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Shortlisted Creators</span>
                <span class="text-2xl sm:text-3xl font-black text-slate-900 font-display tabular-nums">{{ $list->talents->count() }}</span>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-2xs">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Cumulative Reach</span>
                <span class="text-2xl sm:text-3xl font-black text-emerald-600 font-display tabular-nums">{{ number_format($totalReach) }}</span>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-2xs">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Est. Combined Budget</span>
                <span class="text-2xl sm:text-3xl font-black text-brand-600 font-display tabular-nums">₹{{ number_format($totalEstimatedBudget) }}</span>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-2xs">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Avg Rating</span>
                <span class="text-2xl sm:text-3xl font-black text-amber-500 font-display tabular-nums inline-flex items-center gap-1.5"><i data-lucide="star" class="w-6 h-6 fill-amber-500 text-amber-500"></i> 5.0</span>
            </div>
        </div>

        <!-- Roster Talent Table / Cards -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-base font-display">Creators in this Roster</h3>
                <span class="text-xs text-slate-500">{{ $list->talents->count() }} Total</span>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($list->talents as $talent)
                    @php
                        $totFollowers = $talent->socialAccounts->sum('followers');
                        $avgER = $talent->socialAccounts->avg('engagement_rate') ?: 4.2;
                        $rate = $talent->rates->min('rate_amount') ?: 15000;
                    @endphp
                    <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50/80 transition">
                        <div class="flex items-center space-x-4 min-w-0">
                            <img src="{{ $talent->profile_image ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&h=150&fit=crop' }}" class="w-14 h-14 rounded-2xl object-cover border border-slate-200 flex-shrink-0">
                            <div class="min-w-0">
                                <div class="flex items-center space-x-2">
                                    <h4 class="font-bold text-slate-900 text-base truncate">{{ $talent->display_name ?: $talent->user->name }}</h4>
                                    <x-verification-badge :level="$talent->verification_level ?: 1" size="xs" />
                                </div>
                                <p class="text-xs text-brand-600 font-medium truncate">@ {{ $talent->username }} • {{ $talent->city ?: 'Nashik' }}</p>
                                <div class="flex items-center space-x-3 text-xs text-slate-500 mt-1 font-semibold">
                                    <span class="inline-flex items-center gap-1"><i data-lucide="users" class="w-3.5 h-3.5"></i> {{ number_format($totFollowers) }} reach</span>
                                    <span class="inline-flex items-center gap-1"><i data-lucide="flame" class="w-3.5 h-3.5 text-rose-500"></i> {{ number_format($avgER, 1) }}% ER</span>
                                    <span class="inline-flex items-center gap-1 text-amber-500"><i data-lucide="star" class="w-3.5 h-3.5 fill-amber-500 text-amber-500"></i> {{ number_format($talent->rating_avg ?: 5.0, 1) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">Starting Fee</span>
                                <span class="font-black text-slate-900 text-sm font-display tabular-nums">₹{{ number_format($rate) }}</span>
                            </div>

                            <div class="flex items-center space-x-2">
                                <a href="{{ route('influencers.public.show', $talent->username) }}" target="_blank" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition inline-flex items-center gap-1">
                                    <span>Media Kit</span>
                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                </a>
                                <a href="{{ route('brand.chat', ['talent_id' => $talent->id]) }}" class="px-3.5 py-2 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition shadow-2xs">
                                    Chat
                                </a>
                                <form method="POST" action="{{ route('brand.lists.toggle') }}">
                                    @csrf
                                    <input type="hidden" name="list_id" value="{{ $list->id }}">
                                    <input type="hidden" name="talent_profile_id" value="{{ $talent->id }}">
                                    <button type="submit" onclick="return confirm('Remove this creator from roster?')" class="p-2 text-slate-400 hover:text-rose-600 rounded-xl transition" title="Remove from list">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-slate-500 text-xs">
                        No creators in this roster yet. Browse talent and click 'Save to Roster'.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Bulk Invite Modal -->
        <div x-show="bulkInviteModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div @click.away="bulkInviteModalOpen = false" class="bg-white w-full max-w-lg rounded-3xl border border-slate-200 shadow-2xl p-6 sm:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-lg font-bold font-display text-slate-900">Bulk Invite Roster to Campaign</h3>
                        <p class="text-xs text-slate-500">Send direct campaign proposals to all {{ $list->talents->count() }} creators at once.</p>
                    </div>
                    <button type="button" @click="bulkInviteModalOpen = false" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center text-sm font-bold transition">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                @if($campaigns->count() > 0)
                    <form method="POST" action="{{ route('brand.lists.bulk_invite', $list->id) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block font-bold text-slate-700 text-xs mb-1">Select Published Campaign</label>
                            <select name="campaign_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                                @foreach($campaigns as $c)
                                    <option value="{{ $c->id }}">{{ $c->title }} (Budget: ₹{{ number_format($c->budget_min) }} - ₹{{ number_format($c->budget_max) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 text-xs mb-1">Custom Pitch Note</label>
                            <textarea name="note" rows="3" placeholder="Hello! We are inviting you to join our campaign. Please review the brief and send us your confirmation." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500"></textarea>
                        </div>

                        <div class="flex items-center space-x-3 pt-2">
                            <button type="button" @click="bulkInviteModalOpen = false" class="w-1/2 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                                Cancel
                            </button>
                            <button type="submit" class="w-1/2 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl transition shadow-xs inline-flex items-center justify-center gap-1.5">
                                <i data-lucide="send" class="w-3.5 h-3.5"></i>
                                <span>Send Bulk Invites</span>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-6 space-y-4">
                        <p class="text-xs text-slate-600">You need at least one published campaign to send bulk invites.</p>
                        <a href="{{ route('brand.campaigns.create') }}" class="inline-block py-2.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl transition">
                            + Create Campaign Now
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
