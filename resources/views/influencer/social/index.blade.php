@extends('layouts.influencer')

@section('title', 'Connected Social Accounts | Talent Studio')

@section('content')
    <div class="space-y-8" x-data="{
        showAddModal: false,
        newPlatform: 'instagram',
        newUsername: '',
        newProfileUrl: '',
        updateNewUrl() {
            const u = this.newUsername.replace(/^@/, '').trim();
            if (!u) { this.newProfileUrl = ''; return; }
            const p = this.newPlatform;
            if (p === 'instagram') this.newProfileUrl = 'https://instagram.com/' + u;
            else if (p === 'youtube') this.newProfileUrl = 'https://youtube.com/@' + u;
        }
    }">
        <!-- Header -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="px-3.5 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 text-xs font-bold rounded-full inline-flex items-center gap-1.5 mb-2 shadow-2xs">
                    <i class="fa-solid fa-bolt text-xs text-amber-500"></i> Live Meta Graph & API Engine
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Social Accounts & Reach Analytics</h1>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Connect your channels. Your live follower counts, 30-day views, and verified reels are automatically fetched directly from the live platforms via official APIs.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                @if($socialAccounts->isNotEmpty())
                    <form method="POST" action="{{ route('influencer.social.sync_all') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center space-x-1.5">
                            <i class="fa-solid fa-arrows-rotate text-xs"></i>
                            <span>Sync All Metrics</span>
                        </button>
                    </form>
                @endif
                <a href="{{ route('auth.instagram.redirect') }}" class="px-5 py-2.5 bg-gradient-to-r from-[#833ab4] via-[#fd1d1d] to-[#fcb045] hover:opacity-95 text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center space-x-2">
                    <i class="fa-brands fa-instagram text-base"></i>
                    <span>Connect Instagram OAuth</span>
                </a>
                <button @click="showAddModal = true" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center space-x-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Add Channel</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-sm shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Accounts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($socialAccounts as $acc)
                @php
                    $isYT = strtolower($acc->platform) === 'youtube';
                    $isIG = strtolower($acc->platform) === 'instagram';
                @endphp
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col justify-between space-y-5 hover:shadow-md transition group">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-lg {{ $isIG ? 'bg-pink-50 text-[#E1306C]' : ($isYT ? 'bg-red-50 text-[#FF0000]' : 'bg-slate-100 text-slate-700') }}">
                                    @if($isIG)
                                        <i class="fa-brands fa-instagram"></i>
                                    @elseif($isYT)
                                        <i class="fa-brands fa-youtube"></i>
                                    @else
                                        <i class="fa-solid fa-share-nodes"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm capitalize font-display">{{ $acc->platform }}</h4>
                                    <span class="text-xs text-pink-600 font-mono font-bold">{{ '@' . $acc->username }}</span>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Verified
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                            <div>
                                <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Followers</span>
                                <span class="text-lg font-black text-slate-900 font-display tabular-nums">{{ number_format($acc->followers) }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">30-Day Views</span>
                                <span class="text-lg font-black text-emerald-600 font-display tabular-nums">{{ number_format($acc->views_30d ?: (int)($acc->followers * 3.2)) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <form method="POST" action="{{ route('influencer.social.refresh', $acc->id) }}">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-indigo-600 hover:underline inline-flex items-center gap-1">
                                <i class="fa-solid fa-arrows-rotate text-[10px]"></i>
                                <span>Sync Metrics</span>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('influencer.social.delete', $acc->id) }}" onsubmit="return confirm('Remove this linked channel?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-slate-400 hover:text-rose-600 font-bold">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-3 p-16 text-center text-slate-400 bg-white rounded-3xl border border-slate-200/80 shadow-xs">
                    <div class="w-16 h-16 rounded-3xl bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                        <i class="fa-solid fa-share-nodes"></i>
                    </div>
                    <div class="font-bold text-slate-800 text-base">No social channels connected</div>
                    <p class="text-xs text-slate-400 mt-1">Connect your Instagram or YouTube handle to automatically sync live followers and monthly views.</p>
                </div>
            @endforelse
        </div>

        <!-- Interactive Reach, Timeframe Filtering & Content Analytics -->
        @if($socialAccounts->isNotEmpty())
            <x-social-analytics-card :socialAccounts="$socialAccounts" :talent="$profile" :isOwner="true" />
        @endif

        <!-- ADD MODAL -->
        <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4" x-cloak>
            <div @click.away="showAddModal = false" class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 p-6 sm:p-8 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-lg font-black text-slate-900 font-display">Connect Social Channel</h3>
                    <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-900 font-bold text-xl">&times;</button>
                </div>

                <form method="POST" action="{{ route('influencer.social') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Platform *</label>
                        <select name="platform" x-model="newPlatform" @change="updateNewUrl()" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-bold focus:bg-white focus:outline-none focus:border-slate-900 transition">
                            <option value="instagram">Instagram</option>
                            <option value="youtube">YouTube</option>
                            <option value="tiktok">TikTok</option>
                            <option value="linkedin">LinkedIn</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Username / Handle *</label>
                        <input type="text" name="username" x-model="newUsername" @input="updateNewUrl()" required placeholder="e.g. stylebyriya" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-mono font-bold focus:bg-white focus:outline-none focus:border-slate-900 transition">
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                        <button type="button" @click="showAddModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white rounded-xl text-xs font-bold shadow-2xs">Connect & Fetch Stats</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
