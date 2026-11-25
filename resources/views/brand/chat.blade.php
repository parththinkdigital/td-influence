@extends('layouts.brand')

@section('title', 'Direct Chat & Negotiation | Brand Studio')

@section('content')
@php
    $talent = $application->talentProfile;
    $creatorName = $talent->display_name ?? $application->talentProfile->user->name;
    $creatorAvatar = $talent->profile_photo_url ?? ($talent->profile_image ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80');
@endphp

<div class="space-y-6" x-data="brandChat({{ $conversation->id }}, {{ Auth::id() }})" x-init="initChat()">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/80 pb-5">
        <div class="flex items-center space-x-4">
            <div class="relative">
                <img src="{{ $creatorAvatar }}" alt="{{ $creatorName }}" class="w-12 h-12 rounded-2xl object-cover border border-slate-200 shadow-2xs">
                <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></span>
            </div>
            <div>
                <div class="flex items-center space-x-2">
                    <h1 class="text-xl font-black text-slate-900 font-display">{{ $creatorName }}</h1>
                    @if($talent && $talent->city)
                        <span class="px-2.5 py-0.5 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg">{{ $talent->city }}, Maharashtra</span>
                    @endif
                    @if($booking && $booking->status === 'confirmed')
                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-lg flex items-center space-x-1">
                            <i class="fa-solid fa-check text-[10px]"></i>
                            <span>Booking Confirmed</span>
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    Campaign Requirement: <span class="font-bold text-indigo-600">{{ $application->campaign->title }}</span>
                </p>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('brand.messages') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-50 transition shadow-2xs">
                &larr; Inbox
            </a>
            <a href="{{ route('brand.campaigns.show', $application->campaign_id) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold rounded-xl transition">
                Application Pipeline
            </a>
        </div>
    </div>

    <!-- Main Grid: Chat Stream (Left) + Campaign Summary (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chat Area (2 Cols) -->
        <div class="lg:col-span-2 bg-white border border-slate-200/80 rounded-3xl shadow-xs flex flex-col h-[calc(100vh-210px)] min-h-[580px] overflow-hidden">
            <!-- Chat Feed -->
            <div class="flex-1 p-5 md:p-6 overflow-y-auto space-y-4 bg-slate-50/50" id="messagesContainer" x-ref="messagesContainer">
                <div class="text-center my-2">
                    <span class="px-3 py-1 bg-white border border-slate-200 text-slate-500 text-[11px] font-semibold rounded-full shadow-2xs">
                        Direct conversation started for {{ $application->campaign->title }}
                    </span>
                </div>

                <template x-for="msg in messages" :key="msg.id">
                    <div class="flex flex-col" :class="msg.is_me ? 'items-end' : 'items-start'">
                        <div class="max-w-md md:max-w-lg rounded-2xl p-4 text-xs shadow-2xs space-y-2 transition"
                             :class="msg.is_me ? 'bg-indigo-600 text-white rounded-br-xs' : 'bg-white border border-slate-200 text-slate-800 rounded-bl-xs'">
                            
                            <!-- Sender & Time -->
                            <div class="flex items-center justify-between space-x-2 text-[10px] font-semibold"
                                 :class="msg.is_me ? 'text-indigo-200' : 'text-slate-400'">
                                <span x-text="msg.is_me ? 'You (Brand)' : msg.sender_name"></span>
                                <span x-text="msg.created_at_human"></span>
                            </div>

                            <!-- Message Text -->
                            <p class="leading-relaxed whitespace-pre-wrap text-sm" x-show="msg.message_text" x-text="msg.message_text"></p>

                            <!-- Attachment Link Card -->
                            <template x-if="msg.attachments && msg.attachments.url">
                                <a :href="msg.attachments.url" target="_blank" 
                                   class="mt-2 block p-2.5 rounded-xl border transition flex items-center space-x-2"
                                   :class="msg.is_me ? 'bg-indigo-700/50 border-indigo-400/40 text-white hover:bg-indigo-700' : 'bg-slate-50 border-slate-200 text-indigo-600 hover:bg-indigo-50/50'">
                                    <i class="fa-solid fa-paperclip text-xs"></i>
                                    <span class="truncate font-semibold underline text-xs" x-text="msg.attachments.name || msg.attachments.url"></span>
                                </a>
                            </template>

                            <!-- Commercial Proposal Box -->
                            <template x-if="msg.proposal_price">
                                <div class="mt-3 pt-3 border-t p-3.5 rounded-2xl space-y-2.5 transition"
                                     :class="{
                                         'border-indigo-400/30 bg-indigo-700/70 text-white': msg.is_me && msg.proposal_status !== 'superseded',
                                         'border-indigo-400/20 bg-indigo-800/40 text-indigo-200 opacity-75': msg.is_me && msg.proposal_status === 'superseded',
                                         'border-slate-200 bg-slate-50/80 text-slate-500 opacity-75': !msg.is_me && msg.proposal_status === 'superseded',
                                         'border-amber-200 bg-amber-50/95 text-slate-900 shadow-xs': !msg.is_me && msg.proposal_status !== 'superseded'
                                     }">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-1.5 font-bold">
                                            <i class="fa-solid fa-hand-holding-dollar text-xs"></i>
                                            <span>Commercial Proposal:</span>
                                            <span class="text-base font-black font-display tracking-tight tabular-nums"
                                                  x-text="'₹' + Number(msg.proposal_price).toLocaleString()"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Chat Input Bar -->
            <form @submit.prevent="sendMessage()" class="p-4 bg-white border-t border-slate-200 flex items-center space-x-3">
                <input type="text" x-model="newMessage" placeholder="Type your message or negotiate terms..." 
                       class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-indigo-600 transition">
                <button type="submit" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition shadow-2xs inline-flex items-center gap-1.5">
                    <span>Send</span>
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </form>
        </div>

        <!-- Deal Terms & Campaign Summary Sidebar (1 Col) -->
        <div class="space-y-5">
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4">
                <h3 class="text-base font-black text-slate-900 font-display border-b border-slate-100 pb-3">Contract Deal Terms</h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-bold uppercase text-[10px]">Creator Rate</span>
                        <span class="font-black text-slate-900 text-sm font-display tabular-nums">₹{{ number_format($application->quoted_price) }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-bold uppercase text-[10px]">Usage Rights</span>
                        <span class="font-bold text-slate-800">Organic Social & Digital</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-bold uppercase text-[10px]">Revisions Included</span>
                        <span class="font-bold text-slate-800">1 Revision Cycle</span>
                    </div>

                    <div class="pt-3 border-t border-slate-100 space-y-2">
                        <span class="text-slate-400 font-bold uppercase text-[10px] block">Escrow Custody</span>
                        <p class="text-[11px] text-slate-600 leading-relaxed">
                            Payment is deposited into 100% secure escrow and held until deliverable content is submitted and approved by you.
                        </p>
                    </div>

                    <div class="pt-3">
                        <form method="POST" action="{{ route('brand.applications.status', $application->id) }}">
                            @csrf
                            @if($application->status !== 'selected')
                                <button type="submit" name="status" value="selected" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-xs transition inline-flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-shield-halved"></i>
                                    <span>Accept Terms & Hire Creator</span>
                                </button>
                            @else
                                <div class="p-3 bg-emerald-50 text-emerald-800 rounded-xl text-center font-bold border border-emerald-200">
                                    <i class="fa-solid fa-circle-check mr-1"></i> Creator Hired
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function brandChat(conversationId, authUserId) {
    return {
        conversationId: conversationId,
        authUserId: authUserId,
        messages: [],
        newMessage: '',
        initChat() {
            this.fetchMessages();
            setInterval(() => this.fetchMessages(), 5000);
        },
        fetchMessages() {
            fetch(`/brand/chat/${this.conversationId}/fetch`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.messages) {
                        this.messages = data.messages;
                    }
                })
                .catch(() => {});
        },
        sendMessage() {
            if (!this.newMessage.trim()) return;
            const text = this.newMessage;
            this.newMessage = '';

            fetch(`/brand/chat/${this.conversationId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ message_text: text })
            })
            .then(res => res.json())
            .then(data => {
                this.fetchMessages();
            })
            .catch(() => {});
        }
    };
}
</script>
@endsection
