@extends('layouts.brand')

@section('title', 'Messages & Negotiations | Brand Studio')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">
                <span>Communications Hub</span>
                <span>&bull;</span>
                <span class="text-sky-600">Active Negotiations</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Direct Messages & Offers</h1>
            <p class="text-slate-600 text-sm mt-1">Communicate directly with shortlisted and applied creators, negotiate deliverables, and finalize commercial terms.</p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('brand.campaigns') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-50 hover:border-slate-300 transition shadow-sm">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>Campaigns</span>
            </a>
            <a href="{{ route('influencers.public') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <span>Find More Talent</span>
            </a>
        </div>
    </div>

    <!-- Conversations Grid / List -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden" x-data="{ search: '' }">
        <div class="p-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
            <div class="relative flex-grow max-w-md">
                <svg class="w-4 h-4 absolute left-3.5 top-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" x-model="search" placeholder="Search conversations by creator or campaign..." class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-2 text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 transition">
            </div>
            <div class="text-xs font-semibold text-slate-500">
                <span>{{ $conversations->count() }} active discussions</span>
            </div>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($conversations as $conv)
                @php
                    $lastMessage = $conv->messages->first();
                    $unreadCount = $conv->messages->where('sender_id', '!=', Auth::id())->whereNull('read_at')->count();
                    $talentProfile = $conv->talentUser->talentProfile;
                    $creatorName = $talentProfile->display_name ?? $conv->talentUser->name;
                    $avatar = $talentProfile->profile_photo_url ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80';
                @endphp
                <div class="p-5 hover:bg-slate-50 transition flex items-center justify-between gap-4"
                     x-show="search === '' || '{{ strtolower($creatorName) }}'.includes(search.toLowerCase()) || '{{ strtolower($conv->campaign->title ?? '') }}'.includes(search.toLowerCase())">
                    <div class="flex items-center space-x-4 min-w-0">
                        <div class="relative flex-shrink-0">
                            <img src="{{ $avatar }}" alt="{{ $creatorName }}" class="w-12 h-12 rounded-full object-cover border border-slate-200 shadow-sm">
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-indigo-600 text-white text-[9px] font-black rounded-full flex items-center justify-center ring-2 ring-white">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <div class="flex items-center space-x-2">
                                <h3 class="font-bold text-slate-900 text-sm truncate">{{ $creatorName }}</h3>
                                @if($talentProfile && $talentProfile->city)
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-semibold rounded-md">{{ $talentProfile->city }}</span>
                                @endif
                                @if($unreadCount > 0)
                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded-full border border-indigo-100">New Message</span>
                                @endif
                            </div>

                            <p class="text-xs text-slate-500 font-medium truncate mt-0.5">
                                Campaign: <span class="text-slate-700 font-semibold">{{ $conv->campaign->title ?? 'Campaign' }}</span>
                            </p>

                            <p class="text-xs text-slate-600 mt-1 truncate max-w-lg">
                                @if($lastMessage)
                                    @if($lastMessage->sender_id === Auth::id())
                                        <span class="font-bold text-slate-700">You: </span>
                                    @else
                                        <span class="font-bold text-indigo-600">{{ $creatorName }}: </span>
                                    @endif

                                    @if($lastMessage->proposal_price)
                                        <span class="font-bold text-emerald-600 inline-flex items-center gap-1"><i data-lucide="badge-percent" class="w-3.5 h-3.5"></i> Commercial Offer: ₹{{ number_format($lastMessage->proposal_price) }}</span>
                                    @else
                                        {{ $lastMessage->message_text ?: 'Shared an attachment' }}
                                    @endif
                                @else
                                    <span class="text-slate-400 italic">No messages yet. Open chat to begin negotiation.</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 flex-shrink-0">
                        <div class="text-right hidden sm:block">
                            <span class="text-[11px] text-slate-400 font-medium">
                                {{ $lastMessage ? $lastMessage->created_at->diffForHumans() : $conv->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <a href="{{ $conv->application_id ? route('brand.chat', $conv->application_id) : route('brand.chat.conversation', $conv->id) }}" 
                           class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center space-x-1.5">
                            <span>Open Chat</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 px-4">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto text-slate-400 mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">No active discussions yet</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Start by browsing applicants in your campaigns or discover talent in Nashik and click "Start Discussion".</p>
                    <div class="mt-4">
                        <a href="{{ route('brand.campaigns') }}" class="inline-flex px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition">
                            View Campaign Applicants
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
