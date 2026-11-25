@extends('layouts.admin')

@section('title', 'Manage Creators | Admin Gateway')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="w-2 h-2 rounded-full bg-pink-500"></span>
                    <span>Talent Roster Governance</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Creator Network Moderation</h1>
                <p class="text-slate-500 text-sm mt-1">Audit creator channels, synced Meta Graph reels, cumulative follower footprint, and tier levels.</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-4 py-2 rounded-2xl bg-white border border-slate-200/80 text-slate-700 text-xs font-bold shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-users-viewfinder text-pink-500"></i>
                    <span>{{ method_exists($talents ?? $influencers, 'total') ? ($talents ?? $influencers)->total() : count($talents ?? $influencers) }} Enrolled Creators</span>
                </span>
            </div>
        </div>

        <!-- Creators Moderation Table -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[11px] border-b border-slate-100">
                        <tr>
                            <th class="p-4 rounded-l-2xl">Creator / Identity</th>
                            <th class="p-4">Connected Platforms</th>
                            <th class="p-4">Audience Reach</th>
                            <th class="p-4">30-Day Video Views</th>
                            <th class="p-4">Verification Level</th>
                            <th class="p-4 rounded-r-2xl text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-sans">
                        @php $creatorList = $influencers ?? $talents ?? collect([]); @endphp
                        @forelse($creatorList as $inf)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $inf->profile_image ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop' }}" 
                                             class="w-10 h-10 rounded-2xl object-cover border border-slate-200 shadow-2xs">
                                        <div>
                                            <span class="block font-black text-slate-900 text-sm">{{ $inf->display_name ?: ($inf->user->name ?? 'Creator') }}</span>
                                            <span class="text-xs text-pink-600 font-mono font-bold">{{ '@' . $inf->username }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        @forelse($inf->socialAccounts as $acc)
                                            @php
                                                $reelsCount = is_array($acc->recent_media) ? count($acc->recent_media) : 0;
                                            @endphp
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 border border-slate-200/80 rounded-lg text-slate-700 uppercase font-bold text-[10px]">
                                                @if(strtolower($acc->platform) === 'instagram')
                                                    <i class="fa-brands fa-instagram text-[#E1306C]"></i>
                                                @elseif(strtolower($acc->platform) === 'youtube')
                                                    <i class="fa-brands fa-youtube text-[#FF0000]"></i>
                                                @else
                                                    <i class="fa-solid fa-share-nodes text-slate-500"></i>
                                                @endif
                                                <span>{{ $acc->platform }}</span>
                                                @if($reelsCount > 0)
                                                    <span class="px-1.5 py-0.2 rounded-md bg-pink-100 text-[#E1306C] text-[9px] font-black inline-flex items-center gap-0.5">
                                                        <i class="fa-solid fa-bolt text-[8px]"></i> {{ $reelsCount }} synced
                                                    </span>
                                                @endif
                                            </span>
                                        @empty
                                            <span class="text-slate-400 text-xs">No linked social</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="p-4 font-black text-slate-900 tabular-nums text-sm">
                                    {{ number_format($inf->socialAccounts->sum('followers')) }}
                                    <span class="block text-[10px] text-slate-400 font-normal">Total Followers</span>
                                </td>
                                <td class="p-4 font-black text-emerald-600 tabular-nums text-sm">
                                    {{ number_format($inf->socialAccounts->sum('views_30d') ?: (int) ($inf->socialAccounts->sum('followers') * 3.2)) }}
                                    <span class="block text-[10px] text-slate-400 font-normal">Monthly Impressions</span>
                                </td>
                                <td class="p-4">
                                    <form method="POST" action="{{ route('admin.influencers.status', $inf->id) }}" class="inline-flex">
                                        @csrf
                                        <select name="verification_level" onchange="this.form.submit()" class="bg-slate-50 hover:bg-slate-100 border border-slate-300 rounded-xl px-3 py-1.5 text-xs text-slate-900 font-bold focus:outline-none focus:ring-2 focus:ring-slate-900 transition">
                                            <option value="1" {{ ($inf->verification_level ?? 1) == 1 ? 'selected' : '' }}>Level 1 (Basic)</option>
                                            <option value="2" {{ ($inf->verification_level ?? 1) == 2 ? 'selected' : '' }}>Level 2 (Phone OTP)</option>
                                            <option value="3" {{ ($inf->verification_level ?? 1) == 3 ? 'selected' : '' }}>Level 3 (Govt ID)</option>
                                            <option value="4" {{ ($inf->verification_level ?? 1) == 4 ? 'selected' : '' }}>Level 4 (Portfolio Pro)</option>
                                            <option value="5" {{ ($inf->verification_level ?? 1) == 5 ? 'selected' : '' }}>Level 5 (Elite Verified)</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('influencers.public.show', $inf->username) }}" target="_blank" class="px-3.5 py-1.5 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition inline-flex items-center gap-1 shadow-2xs">
                                        <span>View Comp Card</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-16 text-center text-slate-400">
                                    <div class="w-16 h-16 rounded-3xl bg-slate-50 border border-slate-200/80 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                                        <i class="fa-solid fa-users"></i>
                                    </div>
                                    <div class="font-bold text-slate-800 text-base">No creators registered yet</div>
                                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">New influencer signups will be listed here for moderation and badge governance.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($creatorList, 'links'))
                <div class="mt-6 border-t border-slate-100 pt-4">
                    {{ $creatorList->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
