@extends('layouts.admin')

@section('title', 'Manage Creators | Admin Gateway')

@section('content')
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Creator Network Moderation</h1>
            <p class="text-slate-500 text-sm mt-1">Review creator profiles, social channels, 30-day views, and verification status.</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-900">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold">
                        <tr>
                            <th class="p-4 rounded-l-xl">Creator</th>
                            <th class="p-4">Connected Platforms</th>
                            <th class="p-4">Total Followers</th>
                            <th class="p-4">30-Day Views</th>
                            <th class="p-4">Verification Level</th>
                            <th class="p-4 rounded-r-xl text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php $creatorList = $influencers ?? $talents ?? collect([]); @endphp
                        @forelse($creatorList as $inf)
                            <tr>
                                <td class="p-4 font-bold text-slate-900 flex items-center space-x-3">
                                    <img src="{{ $inf->profile_image ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop' }}" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                                    <div>
                                        <span class="block font-extrabold text-slate-900">{{ $inf->display_name ?: ($inf->user->name ?? 'Creator') }}</span>
                                        <span class="text-xs text-[#0866FF] font-semibold">@ {{ $inf->username }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-wrap items-center gap-1.5 text-xs">
                                        @forelse($inf->socialAccounts as $acc)
                                            @php
                                                $reelsCount = is_array($acc->recent_media) ? count($acc->recent_media) : 0;
                                            @endphp
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-slate-100 border border-slate-200 rounded text-slate-700 uppercase font-bold text-[10px]">
                                                <span>{{ $acc->platform }}</span>
                                                @if($reelsCount > 0)
                                                    <span class="px-1 rounded bg-pink-100 text-[#E1306C] text-[9px] font-black inline-flex items-center gap-0.5"><i data-lucide="film" class="w-2.5 h-2.5"></i> {{ $reelsCount }} synced</span>
                                                @endif
                                            </span>
                                        @empty
                                            <span class="text-xs text-slate-400">None</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="p-4 font-black text-slate-900">
                                    {{ number_format($inf->socialAccounts->sum('followers')) }}
                                </td>
                                <td class="p-4 font-black text-emerald-600">
                                    {{ number_format($inf->socialAccounts->sum('views_30d') ?: (int) ($inf->socialAccounts->sum('followers') * 3.2)) }}
                                </td>
                                <td class="p-4">
                                    <form method="POST" action="{{ route('admin.influencers.status', $inf->id) }}" class="inline-flex">
                                        @csrf
                                        <select name="verification_level" onchange="this.form.submit()" class="bg-white border border-slate-300 rounded-lg px-2.5 py-1 text-xs text-slate-900 font-bold focus:outline-none focus:ring-2 focus:ring-[#0866FF]">
                                            <option value="1" {{ ($inf->verification_level ?? 1) == 1 ? 'selected' : '' }}>Level 1 (Basic)</option>
                                            <option value="2" {{ ($inf->verification_level ?? 1) == 2 ? 'selected' : '' }}>Level 2 (Phone)</option>
                                            <option value="3" {{ ($inf->verification_level ?? 1) == 3 ? 'selected' : '' }}>Level 3 (ID Proof)</option>
                                            <option value="4" {{ ($inf->verification_level ?? 1) == 4 ? 'selected' : '' }}>Level 4 (Portfolio)</option>
                                            <option value="5" {{ ($inf->verification_level ?? 1) == 5 ? 'selected' : '' }}>Level 5 (Verified Elite)</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('influencers.public.show', $inf->username) }}" target="_blank" class="px-3.5 py-1.5 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition inline-block">
                                        View Profile &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">No creators found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($creatorList, 'links'))
                <div class="mt-6">
                    {{ $creatorList->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
