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
        <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="px-3.5 py-1 bg-blue-50 text-[#0866FF] border border-blue-200 text-xs font-bold rounded-full inline-flex items-center gap-1.5 mb-2">
                    <i data-lucide="zap" class="w-3.5 h-3.5"></i> Live API Sync Engine Active
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Social Accounts & Reach Analytics</h1>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Connect your channels. Your live follower counts, 30-day views, and verified reels are automatically fetched directly from the live platforms via official APIs.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                @if($socialAccounts->isNotEmpty())
                    <form method="POST" action="{{ route('influencer.social.sync_all') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold rounded-xl transition shadow-xs flex items-center space-x-1.5">
                            <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                            <span>Sync All Metrics</span>
                        </button>
                    </form>
                @endif
                <a href="{{ route('auth.instagram.redirect') }}" class="px-5 py-2.5 bg-gradient-to-r from-[#833ab4] via-[#fd1d1d] to-[#fcb045] hover:opacity-95 text-white text-xs font-extrabold rounded-xl transition shadow-xs flex items-center space-x-2" title="Connect directly with Meta API to auto-fetch exact 30-day Reel views and reach">
                    <i class="fa-brands fa-instagram text-base"></i>
                    <span>Connect Instagram OAuth</span>
                </a>
                <button @click="showAddModal = true" class="px-5 py-2.5 bg-[#0866FF] hover:bg-[#0052CC] text-white text-xs font-extrabold rounded-xl transition shadow-xs flex items-center space-x-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Add Channel / Handle</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-sm shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs font-bold space-y-1">
                @foreach($errors->all() as $error)
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600 text-sm shrink-0"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Accounts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($socialAccounts as $acc)
                @php
                    $isYT = strtolower($acc->platform) === 'youtube';
                    $isIG = strtolower($acc->platform) === 'instagram';
                @endphp
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs flex flex-col justify-between space-y-5 hover:shadow-md transition group">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-lg
                                    @if($isYT) bg-gradient-to-tr from-red-600 via-rose-600 to-red-700 text-white shadow-xs
                                    @elseif($isIG) bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 text-white shadow-xs
                                    @else bg-blue-50 text-[#0866FF] border border-blue-200 @endif">
                                    @if($isIG) <i class="fa-brands fa-instagram text-xl text-white"></i>
                                    @elseif($isYT) <i class="fa-brands fa-youtube text-xl text-white"></i>
                                    @else <i class="fa-solid fa-globe text-lg"></i> @endif
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 text-base capitalize">{{ $acc->platform }}</h4>
                                    <span class="text-xs text-slate-500 font-semibold">@ {{ $acc->username }}</span>
                                </div>
                            </div>

                            <div class="text-right">
                                <span class="px-2.5 py-0.5 bg-emerald-50 text-[#108a00] text-[10px] font-extrabold rounded-full border border-emerald-200 inline-flex items-center gap-1">
                                    <i data-lucide="check" class="w-3 h-3"></i> Live Synced
                                </span>
                                @if($acc->last_synced_at)
                                    <span class="text-[9px] text-slate-400 block mt-0.5">Synced {{ $acc->last_synced_at->diffForHumans() }}</span>
                                @endif
                            </div>
                        </div>

                        @if($acc->profile_url)
                            <div class="mt-2 pt-3 border-t border-slate-100">
                                <a href="{{ $acc->profile_url }}" target="_blank" rel="noopener noreferrer" class="text-xs text-slate-500 hover:text-[#0866FF] truncate flex items-center gap-1 font-medium">
                                    <span class="truncate">{{ $acc->profile_url }}</span>
                                    <i data-lucide="external-link" class="w-3 h-3 shrink-0"></i>
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Action Bar -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                        <form method="POST" action="{{ route('influencer.social.refresh', $acc->id) }}">
                            @csrf
                            <button type="submit" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold rounded-xl transition flex items-center space-x-1.5" title="Force Sync from Live API">
                                <i data-lucide="refresh-cw" class="w-3.5 h-3.5 text-slate-600"></i>
                                <span>Refresh Live Stats</span>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('influencer.social.delete', $acc->id) }}" onsubmit="return confirm('Disconnect this platform?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2 text-slate-400 hover:text-rose-600 rounded-xl hover:bg-rose-50 transition text-xs font-bold flex items-center space-x-1" title="Disconnect account">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                <span>Disconnect</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-white border border-slate-200 rounded-3xl p-8 space-y-4 shadow-xs">
                    <div class="w-14 h-14 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                        <i data-lucide="smartphone" class="w-7 h-7"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-lg">No Channels Connected Yet</h3>
                    <p class="text-slate-500 text-xs max-w-sm mx-auto">
                        Link your Instagram or YouTube handle. Our live sync engine will automatically fetch your live reach, verified reels, and subscriber metrics.
                    </p>
                    <div class="pt-2">
                        <button @click="showAddModal = true" class="px-6 py-3 bg-[#0866FF] text-white text-xs font-bold rounded-2xl hover:bg-[#0052CC] transition shadow-md inline-flex items-center gap-1.5">
                            <i data-lucide="plus" class="w-4 h-4"></i> Connect Social Channel
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Interactive Reach, Timeframe Filtering & Content Analytics -->
        @if($socialAccounts->isNotEmpty())
            <x-social-analytics-card :socialAccounts="$socialAccounts" :talent="$profile" :isOwner="true" />
        @endif

        <!-- CONNECT SOCIAL ACCOUNT MODAL -->
        <div x-show="showAddModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
            <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-xl" @click.away="showAddModal = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-lg font-display">Connect Social Channel</h3>
                        <p class="text-xs text-slate-500">Live follower counts and 30-day reach are automatically fetched from the live platform API.</p>
                    </div>
                    <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-900 font-bold text-xl">&times;</button>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-3.5 text-xs text-blue-800 font-semibold flex items-center space-x-2">
                    <i data-lucide="zap" class="w-4 h-4 text-blue-600 shrink-0"></i>
                    <span><strong>100% Live Sync:</strong> Enter your handle and verified followers & 30-day views are fetched automatically without manual inputs.</span>
                </div>

                <form method="POST" action="{{ route('influencer.social') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Social Platform *</label>
                        <select name="platform" x-model="newPlatform" @change="updateNewUrl()" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF]">
                            <option value="instagram">Instagram</option>
                            <option value="youtube">YouTube</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Username / Handle *</label>
                        <input type="text" name="username" x-model="newUsername" @input="updateNewUrl()" required placeholder="e.g. gargi_era or NetworkChuck" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Profile URL (Auto-Generated)</label>
                        <input type="url" name="profile_url" x-model="newProfileUrl" placeholder="https://instagram.com/username" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF]">
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" @click="showAddModal = false" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-xs">Cancel</button>
                        <button type="submit" class="px-6 py-3 bg-[#0866FF] hover:bg-[#0052CC] text-white font-extrabold text-xs rounded-xl shadow-md transition inline-flex items-center gap-1.5">
                            <i data-lucide="zap" class="w-3.5 h-3.5"></i> Auto-Fetch & Save Channel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
