@extends('layouts.brand')

@section('title', 'Direct Chat & Negotiation | Brand Studio')

@section('content')
@php
    $talent = $application->talentProfile;
    $creatorName = $talent->display_name ?? $application->talentProfile->user->name;
    $creatorAvatar = $talent->profile_photo_url ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80';
@endphp

<div class="space-y-6" x-data="brandChat({{ $conversation->id }}, {{ Auth::id() }})" x-init="initChat()">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
        <div class="flex items-center space-x-4">
            <div class="relative">
                <img src="{{ $creatorAvatar }}" alt="{{ $creatorName }}" class="w-13 h-13 rounded-2xl object-cover border-2 border-white shadow-md">
                <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></span>
            </div>
            <div>
                <div class="flex items-center space-x-2">
                    <h1 class="text-xl font-black text-slate-900">{{ $creatorName }}</h1>
                    @if($talent && $talent->city)
                        <span class="px-2.5 py-0.5 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg">{{ $talent->city }}, Maharashtra</span>
                    @endif
                    @if($booking && $booking->status === 'confirmed')
                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-lg flex items-center space-x-1">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
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
            <a href="{{ route('brand.messages') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-50 transition shadow-sm">
                ← Inbox
            </a>
            <a href="{{ route('brand.campaigns.show', $application->campaign_id) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold rounded-xl transition">
                Application Pipeline
            </a>
        </div>
    </div>

    <!-- Main Grid: Chat Stream (Left) + Campaign Summary (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chat Area (2 Cols) -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl shadow-sm flex flex-col h-[calc(100vh-210px)] min-h-[580px] overflow-hidden">
            <!-- Chat Feed (Takes flexible height and scrolls) -->
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
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    <span class="truncate font-semibold underline text-xs" x-text="msg.attachments.name || msg.attachments.url"></span>
                                </a>
                            </template>

                            <!-- Commercial Proposal Box (Blueprint Section 9 & 13) -->
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
                                            <i data-lucide="badge-percent" class="w-3.5 h-3.5"></i>
                                            <span>Commercial Proposal:</span>
                                            <span class="text-base font-black font-display tracking-tight tabular-nums"
                                                  :class="{
                                                      'line-through text-slate-400': msg.proposal_status === 'superseded',
                                                      'text-white': msg.is_me && msg.proposal_status !== 'superseded',
                                                      'text-amber-900': !msg.is_me && msg.proposal_status !== 'superseded'
                                                  }">
                                                ₹<span x-text="Number(msg.proposal_price).toLocaleString('en-IN')"></span>
                                            </span>
                                        </div>

                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider"
                                              :class="{
                                                  'bg-emerald-100 text-emerald-800 border border-emerald-300': msg.proposal_status === 'accepted',
                                                  'bg-rose-100 text-rose-800 border border-rose-200': msg.proposal_status === 'rejected',
                                                  'bg-slate-100 text-slate-500 border border-slate-300': msg.proposal_status === 'superseded',
                                                  'bg-amber-100 text-amber-900 border border-amber-300': msg.proposal_status === 'proposed' || msg.proposal_status === 'none'
                                              }"
                                              x-text="msg.proposal_status === 'accepted' ? 'Accepted & Confirmed' : (msg.proposal_status === 'rejected' ? 'Declined' : (msg.proposal_status === 'superseded' ? 'Superseded (Replaced)' : 'Active Offer'))">
                                        </span>
                                    </div>

                                    <!-- Commercial Licensing & Terms Badges -->
                                    <div class="flex flex-wrap items-center gap-1.5 pt-1 text-[11px] font-semibold">
                                        <span class="px-2 py-0.5 rounded-md border inline-flex items-center gap-1"
                                              :class="msg.is_me ? 'bg-indigo-800/80 border-indigo-400/40 text-indigo-100' : 'bg-white border-amber-200 text-slate-700'">
                                            <i data-lucide="shield-check" class="w-3 h-3"></i> <span x-text="getUsageRightsLabel(msg.usage_rights)"></span>
                                        </span>
                                        <span class="px-2 py-0.5 rounded-md border inline-flex items-center gap-1"
                                              :class="msg.is_me ? 'bg-indigo-800/80 border-indigo-400/40 text-indigo-100' : 'bg-white border-amber-200 text-slate-700'">
                                            <i data-lucide="rotate-ccw" class="w-3 h-3"></i> <span x-text="(msg.revisions_included || 1) + ' Revision(s)'"></span>
                                        </span>
                                        <template x-if="msg.exclusivity_days > 0">
                                            <span class="px-2 py-0.5 rounded-md border inline-flex items-center gap-1"
                                                  :class="msg.is_me ? 'bg-indigo-800/80 border-indigo-400/40 text-indigo-100' : 'bg-white border-amber-200 text-slate-700'">
                                                <i data-lucide="lock" class="w-3 h-3"></i> <span x-text="msg.exclusivity_days + 'd Exclusivity'"></span>
                                            </span>
                                        </template>
                                    </div>

                                    <!-- Proposal Note -->
                                    <template x-if="msg.counter_note">
                                        <p class="text-[11px] p-2 rounded-xl italic leading-relaxed"
                                           :class="msg.is_me ? 'bg-indigo-800/50 text-indigo-100' : 'bg-white/80 border border-amber-100 text-slate-700'"
                                           x-text="msg.counter_note"></p>
                                    </template>

                                    <!-- Action Buttons if proposal is latest from creator, active and not yet booked -->
                                    <template x-if="!msg.is_me && isLatestProposal(msg) && (msg.proposal_status === 'proposed' || msg.proposal_status === 'none') && !isBookingConfirmed">
                                        <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-amber-200/60">
                                            <form method="POST" action="{{ route('brand.chat.offer_action', $conversation->id) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="message_id" :value="msg.id">
                                                <input type="hidden" name="action" value="accept">
                                                <button type="submit" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold rounded-xl transition shadow-sm flex items-center space-x-1">
                                                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                                    <span>Accept & Lock Booking</span>
                                                </button>
                                            </form>
                                            <button type="button" @click="openCounter(msg)" class="px-3 py-1.5 bg-brand-600 hover:bg-brand-700 text-white text-[11px] font-bold rounded-xl transition shadow-sm inline-flex items-center gap-1">
                                                <i data-lucide="message-square" class="w-3.5 h-3.5"></i> Counter Offer
                                            </button>
                                            <form method="POST" action="{{ route('brand.chat.offer_action', $conversation->id) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="message_id" :value="msg.id">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="px-3.5 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 text-[11px] font-bold rounded-xl transition">
                                                    Decline
                                                </button>
                                            </form>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Quick Suggestion Chips -->
            <div class="px-4 py-2 bg-slate-50/75 border-t border-slate-200 flex items-center space-x-2 overflow-x-auto text-[11px] flex-shrink-0 no-scrollbar">
                <span class="text-slate-400 font-bold flex-shrink-0 inline-flex items-center gap-1"><i data-lucide="zap" class="w-3.5 h-3.5 text-amber-500"></i> Quick reply:</span>
                <button type="button" @click="setPrompt('Rate and terms look solid! Proceeding to formal escrow contract.')" class="px-3 py-1 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl whitespace-nowrap transition font-medium inline-flex items-center gap-1.5">
                    <i data-lucide="thumbs-up" class="w-3.5 h-3.5 text-slate-500"></i> Looks Good!
                </button>
                <button type="button" @click="setPrompt('Can you deliver the final first draft edit by this Friday?')" class="px-3 py-1 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl whitespace-nowrap transition font-medium inline-flex items-center gap-1.5">
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-500"></i> Delivery by Friday?
                </button>
                <button type="button" @click="setPrompt('Please include raw 4K b-roll clips along with the edited video.')" class="px-3 py-1 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl whitespace-nowrap transition font-medium inline-flex items-center gap-1.5">
                    <i data-lucide="video" class="w-3.5 h-3.5 text-slate-500"></i> Include Raw B-Roll
                </button>
                <button type="button" @click="openOfferBuilder()" class="px-3 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-xl whitespace-nowrap font-bold transition flex items-center space-x-1">
                    <i data-lucide="badge-percent" class="w-3.5 h-3.5"></i>
                    <span>Make Commercial Offer</span>
                </button>
            </div>

            <!-- Fixed Bottom Input Bar -->
            <div class="p-3 md:p-4 bg-white border-t border-slate-200 flex-shrink-0">
                <form @submit.prevent="submitMessage" class="space-y-3">
                    <!-- Expandable Offer & Licensing Negotiation Drawer (Blueprint Section 9 & 13) -->
                    <div x-show="showTools || proposalPrice || attachmentUrl" x-cloak x-transition class="bg-slate-50 border border-slate-200 rounded-2xl p-3.5 space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                            <span class="text-xs font-bold text-slate-800 uppercase tracking-wider inline-flex items-center gap-1.5">
                                <i data-lucide="badge-percent" class="w-3.5 h-3.5 text-indigo-600"></i> Commercial Deal & Usage Rights
                            </span>
                            <button type="button" @click="resetTools()" class="text-xs text-slate-400 hover:text-slate-700 p-1 rounded-lg inline-flex items-center gap-1" title="Clear options">
                                <i data-lucide="x" class="w-3 h-3"></i> Clear
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 text-xs">
                            <!-- Offer Price -->
                            <div class="bg-white border border-slate-200 rounded-xl px-3 py-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5">Offer Fee (₹) *</label>
                                <input type="number" x-model="proposalPrice" placeholder="e.g. 45000" class="w-full bg-transparent font-bold text-slate-900 focus:outline-none text-sm">
                            </div>

                            <!-- Usage Rights Tier -->
                            <div class="bg-white border border-slate-200 rounded-xl px-3 py-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5">Usage Rights *</label>
                                <select x-model="usageRights" class="w-full bg-transparent font-semibold text-slate-800 focus:outline-none text-xs">
                                    <option value="organic_only">Organic Social Only</option>
                                    <option value="digital_ads_30d">30-Day Digital Ad Rights</option>
                                    <option value="digital_ads_90d">90-Day Digital Ad Rights</option>
                                    <option value="commercial_full_1y">1-Yr Full Commercial Buyout</option>
                                    <option value="perpetual_buyout">Perpetual Buyout</option>
                                </select>
                            </div>

                            <!-- Revisions & Exclusivity -->
                            <div class="grid grid-cols-2 gap-1.5">
                                <div class="bg-white border border-slate-200 rounded-xl px-2.5 py-2">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5">Revisions</label>
                                    <select x-model="revisionsIncluded" class="w-full bg-transparent font-semibold text-slate-800 focus:outline-none text-xs">
                                        <option value="1">1 Round</option>
                                        <option value="2">2 Rounds</option>
                                        <option value="3">3 Rounds</option>
                                    </select>
                                </div>
                                <div class="bg-white border border-slate-200 rounded-xl px-2.5 py-2">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5">Exclusivity</label>
                                    <select x-model="exclusivityDays" class="w-full bg-transparent font-semibold text-slate-800 focus:outline-none text-xs">
                                        <option value="0">None</option>
                                        <option value="30">30 Days</option>
                                        <option value="60">60 Days</option>
                                        <option value="90">90 Days</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                            <input type="text" x-model="counterNote" placeholder="Specific deliverables note (e.g. 1 Reel + 2 Stories, RAW footage)" class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-slate-800 placeholder:text-slate-400 focus:outline-none text-xs">
                            <input type="url" x-model="attachmentUrl" placeholder="Attachment / Moodboard Link (Drive/Figma)" class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-slate-800 placeholder:text-slate-400 focus:outline-none text-xs">
                        </div>
                    </div>

                    <!-- Main Unified Clean Input Row -->
                    <div class="flex items-center space-x-2 bg-slate-50 border border-slate-200 rounded-2xl p-1.5 focus-within:border-indigo-500 focus-within:bg-white focus-within:ring-2 focus-within:ring-indigo-500/10 transition">
                        <!-- Extra Options Toggle Button -->
                        <button type="button" 
                                @click="showTools = !showTools" 
                                class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-slate-100 rounded-xl transition flex-shrink-0"
                                :class="(showTools || proposalPrice || attachmentUrl) ? 'text-indigo-600 bg-indigo-50' : ''"
                                title="Open Commercial Offer & Licensing Builder">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>

                        <!-- Clean Typing Area -->
                        <textarea x-model="messageText" 
                                  @keydown.enter.prevent="if(!$event.shiftKey) submitMessage()" 
                                  rows="1" 
                                  placeholder="Type a message... (Press Enter to send, Shift+Enter for new line)" 
                                  class="flex-grow bg-transparent border-0 px-2 py-2 text-xs md:text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none resize-none leading-relaxed"
                                  style="min-height: 40px; max-height: 120px;"></textarea>

                        <!-- Send Button -->
                        <button type="submit" 
                                :disabled="sending || (!messageText.trim() && !proposalPrice && !attachmentUrl.trim())" 
                                class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-40 text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center space-x-1.5 flex-shrink-0">
                            <span class="hidden sm:inline" x-text="sending ? 'Sending...' : 'Send'"></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Campaign / Commercial Summary Sidebar (1 Col) -->
        <div class="space-y-6">
            <!-- Campaign Info Card -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <span>Campaign Details</span>
                </div>
                <h3 class="text-base font-black text-slate-900 leading-snug">{{ $application->campaign->title }}</h3>

                <div class="space-y-3 pt-2 text-xs border-t border-slate-100">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Budget Range:</span>
                        <span class="font-bold text-slate-900">₹{{ number_format($application->campaign->budget_min) }} - ₹{{ number_format($application->campaign->budget_max) }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Location:</span>
                        <span class="font-bold text-slate-900">{{ $application->campaign->city ?: 'Nashik, Maharashtra' }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Applied Quote:</span>
                        <span class="font-bold text-indigo-600">₹{{ number_format($application->quoted_price) }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Application Status:</span>
                        <span class="px-2.5 py-0.5 bg-slate-100 text-slate-800 text-[11px] font-bold rounded-lg uppercase">{{ $application->status }}</span>
                    </div>
                </div>

                <!-- Deliverables List -->
                @if($application->campaign->deliverables && $application->campaign->deliverables->count() > 0)
                    <div class="pt-3 border-t border-slate-100 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-700">Required Deliverables:</span>
                            <span class="text-[10px] text-slate-400 font-semibold">{{ $application->campaign->deliverables->count() }} required</span>
                        </div>
                        <ul class="space-y-2 text-xs">
                            @foreach($application->campaign->deliverables as $del)
                                <li class="p-2.5 bg-slate-50 border border-slate-100 rounded-xl space-y-1">
                                    <div class="flex items-start justify-between gap-2">
                                        <span class="font-bold text-slate-900 text-xs">{{ $del->name ?: ($del->deliverable_type ?? 'Campaign Deliverable') }}</span>
                                        <span class="px-2 py-0.5 bg-white border border-slate-200 text-indigo-600 text-[10px] font-black rounded-md flex-shrink-0">
                                            {{ $del->quantity }}x {{ strtoupper(str_replace('_', ' ', $del->type ?: 'Item')) }}
                                        </span>
                                    </div>
                                    @if($del->description)
                                        <p class="text-[11px] text-slate-500 leading-snug">{{ $del->description }}</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Booking / Escrow Card with Locked Usage Rights -->
            @if($booking)
                @php
                    $usageLabels = [
                        'organic_only' => 'Organic Social Only',
                        'digital_ads_30d' => '30-Day Digital Ad Rights',
                        'digital_ads_90d' => '90-Day Digital Ad Rights',
                        'commercial_full_1y' => '1-Year Commercial Buyout',
                        'perpetual_buyout' => 'Perpetual Commercial Buyout',
                    ];
                    $currentUsage = $usageLabels[$booking->usage_rights] ?? ($booking->usage_rights ?: 'Organic Social Only');
                @endphp
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-200 rounded-3xl p-6 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Locked Contract</span>
                        <span class="px-2.5 py-0.5 bg-emerald-600 text-white text-[10px] font-black rounded-md uppercase">{{ $booking->status }}</span>
                    </div>

                    <div class="text-2xl font-black text-slate-900 font-display tabular-nums">
                        ₹{{ number_format($booking->agreed_fee) }}
                    </div>

                    <div class="space-y-2 pt-2 border-t border-emerald-200 text-xs text-emerald-950 font-medium">
                        <div class="flex items-center justify-between">
                            <span class="text-emerald-800 inline-flex items-center gap-1"><i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Licensing:</span>
                            <span class="font-bold">{{ $currentUsage }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-emerald-800 inline-flex items-center gap-1"><i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Revisions:</span>
                            <span class="font-bold">{{ $booking->revisions_included ?: 1 }} Round(s)</span>
                        </div>
                        @if($booking->exclusivity_days > 0)
                            <div class="flex items-center justify-between">
                                <span class="text-emerald-800 inline-flex items-center gap-1"><i data-lucide="lock" class="w-3.5 h-3.5"></i> Exclusivity:</span>
                                <span class="font-bold">{{ $booking->exclusivity_days }} Days Category Hold</span>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('brand.bookings') }}" class="mt-2 block text-center px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition shadow-xs">
                        Manage Booking & Deliverables &rarr;
                    </a>
                </div>
            @endif

            <!-- Quick Creator Profile Snapshot -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-3">
                <div class="flex items-center space-x-3">
                    <img src="{{ $creatorAvatar }}" alt="{{ $creatorName }}" class="w-11 h-11 rounded-xl object-cover border border-slate-200">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">{{ $creatorName }}</h4>
                        <p class="text-xs text-slate-500">{{ $talent->primary_niche ?? 'Content Creator' }}</p>
                    </div>
                </div>

                @if($talent && $talent->bio)
                    <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">{{ $talent->bio }}</p>
                @endif

                <div class="pt-2">
                    <a href="{{ route('brand.influencer.show', $talent->id) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center space-x-1">
                        <span>View Full Creator Portfolio</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function brandChat(conversationId, currentUserId) {
    return {
        conversationId: conversationId,
        currentUserId: currentUserId,
        messages: {!! json_encode($jsonMessages) !!},
        isBookingConfirmed: {{ ($booking && $booking->status === 'confirmed') ? 'true' : 'false' }},
        messageText: '',
        proposalPrice: '',
        usageRights: 'organic_only',
        revisionsIncluded: 1,
        exclusivityDays: 0,
        counterNote: '',
        attachmentUrl: '',
        showTools: false,
        sending: false,
        pollInterval: null,

        isLatestProposal(msg) {
            if (!msg || !msg.proposal_price) return false;
            if (msg.proposal_status === 'superseded' || msg.proposal_status === 'rejected') return false;
            if (this.isBookingConfirmed) return false;
            // Check if there is any newer proposal in this conversation
            return !this.messages.some(m => m.id > msg.id && m.proposal_price);
        },

        initChat() {
            if (typeof window.setActiveConversation === 'function') {
                window.setActiveConversation(this.conversationId);
            } else {
                window.__activeConversationId = String(this.conversationId);
            }
            window.addEventListener('beforeunload', () => {
                if (typeof window.setActiveConversation === 'function') {
                    window.setActiveConversation(null);
                }
            });

            this.scrollToBottom();
            this.pollInterval = setInterval(() => {
                this.fetchMessages();
            }, 3000);
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        },

        setPrompt(text) {
            this.messageText = text;
        },

        openOfferBuilder() {
            this.showTools = true;
            if (!this.proposalPrice) {
                this.proposalPrice = 45000;
            }
        },

        openCounter(msg) {
            this.showTools = true;
            this.proposalPrice = msg.proposal_price || '';
            this.usageRights = msg.usage_rights || 'organic_only';
            this.revisionsIncluded = msg.revisions_included || 1;
            this.exclusivityDays = msg.exclusivity_days || 0;
            this.counterNote = msg.counter_note || '';
            this.messageText = 'Here is our revised commercial counter-proposal with updated terms:';
            this.scrollToBottom();
        },

        resetTools() {
            this.showTools = false;
            this.proposalPrice = '';
            this.usageRights = 'organic_only';
            this.revisionsIncluded = 1;
            this.exclusivityDays = 0;
            this.counterNote = '';
            this.attachmentUrl = '';
        },

        getUsageRightsLabel(tier) {
            const labels = {
                'organic_only': 'Organic Social Only',
                'digital_ads_30d': '30-Day Digital Ad Rights',
                'digital_ads_90d': '90-Day Digital Ad Rights',
                'commercial_full_1y': '1-Year Commercial Buyout',
                'perpetual_buyout': 'Perpetual Buyout',
            };
            return labels[tier] || 'Organic Social Only';
        },

        async fetchMessages() {
            try {
                const response = await fetch(`/brand/chat/${this.conversationId}/fetch`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (response.ok) {
                    const data = await response.json();
                    if (data.messages && data.messages.length !== this.messages.length) {
                        this.messages = data.messages;
                        this.scrollToBottom();
                    }
                }
            } catch (err) {
                console.error('Failed to poll chat:', err);
            }
        },

        async submitMessage() {
            if (this.sending || (!this.messageText.trim() && !this.proposalPrice && !this.attachmentUrl.trim())) {
                return;
            }

            this.sending = true;
            const payload = {
                message_text: this.messageText,
                proposal_price: this.proposalPrice ? this.proposalPrice : null,
                usage_rights: this.proposalPrice ? this.usageRights : null,
                revisions_included: this.proposalPrice ? this.revisionsIncluded : 1,
                exclusivity_days: this.proposalPrice ? this.exclusivityDays : 0,
                counter_note: this.counterNote ? this.counterNote : null,
                attachment_url: this.attachmentUrl ? this.attachmentUrl : null,
            };

            try {
                const response = await fetch(`/brand/chat/${this.conversationId}/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.message) {
                        this.messages.push(data.message);
                        this.messageText = '';
                        this.resetTools();
                        this.scrollToBottom();
                    }
                } else {
                    window.location.reload();
                }
            } catch (err) {
                console.error('Error sending message:', err);
                window.location.reload();
            } finally {
                this.sending = false;
            }
        }
    };
}
</script>
@endsection
