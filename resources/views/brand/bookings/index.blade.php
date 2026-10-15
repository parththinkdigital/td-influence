@extends('layouts.brand')

@section('title', 'Milestone Collaboration Tracker & Deliverable Vault | Brand Studio')

@section('content')
    <div class="space-y-8" x-data="{
        showApproveModal: false,
        showRevisionModal: false,
        showReviewModal: false,
        activeBooking: null,
        activeSubmission: null,
        revisionFeedback: '',
        reviewRating: 5,
        reviewQuality: 5,
        reviewCommunication: 5,
        reviewPunctuality: 5,
        reviewText: '',
        
        openApprove(booking, submission) {
            this.activeBooking = booking;
            this.activeSubmission = submission;
            this.showApproveModal = true;
        },
        openRevision(booking, submission) {
            this.activeBooking = booking;
            this.activeSubmission = submission;
            this.revisionFeedback = '';
            this.showRevisionModal = true;
        },
        openReview(booking) {
            this.activeBooking = booking;
            this.reviewRating = 5;
            this.reviewQuality = 5;
            this.reviewCommunication = 5;
            this.reviewPunctuality = 5;
            this.reviewText = '';
            this.showReviewModal = true;
        }
    }">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="px-2.5 py-1 rounded-md bg-brand-50 border border-brand-200 text-brand-700 text-xs font-bold uppercase tracking-wider">
                        Milestone Collaboration Engine
                    </span>
                    <span class="text-xs text-slate-400">&bull;</span>
                    <span class="text-xs font-semibold text-slate-500">100% Escrow Protected</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display mt-1">Bookings & Deliverable Proof Vault</h1>
                <p class="text-slate-500 text-sm mt-1">Track 4-stage campaign milestones, inspect creator proof links, request revisions, and disburse escrow payouts.</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-white border border-slate-200 rounded-2xl px-4 py-2 text-right shadow-2xs">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Active Orders</span>
                    <span class="text-lg font-black text-slate-900 font-display tabular-nums">{{ $bookings->total() }}</span>
                </div>
            </div>
        </div>

        <!-- Bookings List -->
        <div class="space-y-8">
            @forelse($bookings as $booking)
                @php
                    $usageLabels = [
                        'organic_only' => 'Organic Social Only',
                        'digital_ads_30d' => '30-Day Digital Ad Rights',
                        'digital_ads_90d' => '90-Day Digital Ad Rights',
                        'commercial_full_1y' => '1-Year Commercial Buyout',
                        'perpetual_buyout' => 'Perpetual Buyout',
                    ];
                    $usageText = $usageLabels[$booking->usage_rights] ?? ($booking->usage_rights ?: 'Organic Social Only');
                    $revisionsUsed = $booking->submissions->where('status', 'changes_requested')->count();
                    $revisionsAllowed = $booking->revisions_included ?: 1;
                    $revisionsRemaining = max(0, $revisionsAllowed - $revisionsUsed);
                    $myReview = $booking->reviews->firstWhere('reviewer_id', auth()->id());
                @endphp

                <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs space-y-6">
                    <!-- Contract Top Row -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-bold text-brand-600 uppercase tracking-wider font-display">
                                    {{ $booking->talentProfile->display_name ?? 'Creator' }}
                                </span>
                                <x-verification-badge :level="$booking->talentProfile->verification_level ?: 1" size="xs" />
                                @if($booking->talentProfile && $booking->talentProfile->city)
                                    <span class="text-slate-400 text-xs">&bull;</span>
                                    <span class="text-xs text-slate-500 font-medium inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> {{ $booking->talentProfile->city }}</span>
                                @endif
                            </div>

                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 font-display tracking-tight">
                                {{ $booking->campaign->title ?? 'Campaign Contract' }}
                            </h2>

                            <!-- Contract Badges -->
                            <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
                                <span class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-200 font-semibold text-slate-700 flex items-center space-x-1.5">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-slate-500 shrink-0"></i>
                                    <span>{{ $usageText }}</span>
                                </span>
                                <span class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-200 font-semibold text-slate-700 flex items-center space-x-1.5">
                                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 text-slate-500 shrink-0"></i>
                                    <span>{{ $revisionsAllowed }} Revision(s) Included</span>
                                    @if($revisionsUsed > 0)
                                        <span class="text-amber-600 font-bold">({{ $revisionsUsed }} used)</span>
                                    @endif
                                </span>
                                @if($booking->exclusivity_days > 0)
                                    <span class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-200 font-semibold text-slate-700 flex items-center space-x-1.5">
                                        <i data-lucide="lock" class="w-3.5 h-3.5 text-slate-500 shrink-0"></i>
                                        <span>{{ $booking->exclusivity_days }}d Exclusivity</span>
                                    </span>
                                @endif
                                <span class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 flex items-center space-x-1.5">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                    <span>Target:</span>
                                    <span class="font-bold text-slate-700">{{ $booking->shoot_date ? $booking->shoot_date->format('M d, Y') : 'Agreed Timeline' }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Escrow Financial Snapshot -->
                        <div class="flex items-center lg:items-end flex-col bg-slate-50 p-4 rounded-2xl border border-slate-200 min-w-[220px]">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Escrow Total Held</span>
                            <div class="text-2xl font-black text-slate-900 font-display tabular-nums">
                                ₹{{ number_format($booking->total_amount) }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5 space-x-2">
                                <span>Talent: <b class="text-slate-800 tabular-nums">₹{{ number_format($booking->agreed_fee) }}</b></span>
                                <span>&bull;</span>
                                <span>Fee: <b class="text-slate-800 tabular-nums">₹{{ number_format($booking->platform_fee) }}</b></span>
                            </div>
                            <div class="mt-2">
                                @if($booking->status === 'completed')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-300 inline-flex items-center gap-1">
                                        <i data-lucide="check" class="w-3 h-3"></i> Escrow Disbursed
                                    </span>
                                @elseif($booking->status === 'deliverables_submitted')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-amber-100 text-amber-800 border border-amber-300 animate-pulse inline-flex items-center gap-1">
                                        <i data-lucide="zap" class="w-3 h-3"></i> Proof Ready For Review
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-indigo-100 text-indigo-800 border border-indigo-300 inline-flex items-center gap-1">
                                        <i data-lucide="lock" class="w-3 h-3"></i> Escrow Locked In Progress
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Visual 4-Stage Milestone Progress Tracker -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-600">
                            <span>Milestone Collaboration Tracker</span>
                            <span class="text-slate-400">
                                @if($booking->status === 'completed')
                                    Stage 4/4 Completed
                                @elseif($booking->submissions->where('status', 'approved')->isNotEmpty() || $booking->status === 'approved')
                                    Stage 4/4 Sign-Off
                                @elseif($booking->submissions->isNotEmpty())
                                    Stage 3/4 Deliverable In Verification
                                @else
                                    Stage 2/4 Content Production
                                @endif
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                            <!-- Step 1: Contract & Escrow -->
                            <div class="p-3.5 rounded-2xl border bg-emerald-50/70 border-emerald-200 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black text-emerald-800 uppercase tracking-wider">STAGE 1</span>
                                    <span class="text-xs font-bold text-emerald-600 inline-flex items-center gap-1"><i data-lucide="check" class="w-3 h-3"></i> Done</span>
                                </div>
                                <div class="font-bold text-slate-900 text-xs">Contract & Escrow</div>
                                <p class="text-[11px] text-slate-600">100% Funds locked in vault</p>
                            </div>

                            <!-- Step 2: Production -->
                            <div class="p-3.5 rounded-2xl border {{ $booking->submissions->isNotEmpty() || $booking->status === 'completed' ? 'bg-emerald-50/70 border-emerald-200' : 'bg-indigo-50/70 border-indigo-200 ring-2 ring-indigo-500/20' }} space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black {{ $booking->submissions->isNotEmpty() || $booking->status === 'completed' ? 'text-emerald-800' : 'text-indigo-800' }} uppercase tracking-wider">STAGE 2</span>
                                    <span class="text-xs font-bold {{ $booking->submissions->isNotEmpty() || $booking->status === 'completed' ? 'text-emerald-600' : 'text-indigo-600' }}">
                                        {{ $booking->submissions->isNotEmpty() || $booking->status === 'completed' ? 'Done' : 'Active' }}
                                    </span>
                                </div>
                                <div class="font-bold text-slate-900 text-xs">Creation & Production</div>
                                <p class="text-[11px] text-slate-600">Creator filming content</p>
                            </div>

                            <!-- Step 3: Deliverable Proof -->
                            <div class="p-3.5 rounded-2xl border {{ $booking->status === 'completed' || $booking->submissions->where('status', 'approved')->isNotEmpty() ? 'bg-emerald-50/70 border-emerald-200' : ($booking->submissions->isNotEmpty() ? 'bg-amber-50/80 border-amber-300 ring-2 ring-amber-500/20' : 'bg-slate-50 border-slate-200 opacity-60') }} space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black {{ $booking->status === 'completed' || $booking->submissions->where('status', 'approved')->isNotEmpty() ? 'text-emerald-800' : ($booking->submissions->isNotEmpty() ? 'text-amber-800' : 'text-slate-400') }} uppercase tracking-wider">STAGE 3</span>
                                    <span class="text-xs font-bold {{ $booking->status === 'completed' || $booking->submissions->where('status', 'approved')->isNotEmpty() ? 'text-emerald-600' : ($booking->submissions->isNotEmpty() ? 'text-amber-700' : 'text-slate-400') }}">
                                        {{ $booking->status === 'completed' || $booking->submissions->where('status', 'approved')->isNotEmpty() ? 'Approved' : ($booking->submissions->isNotEmpty() ? 'In Review' : 'Pending') }}
                                    </span>
                                </div>
                                <div class="font-bold text-slate-900 text-xs">Proof Vault Submission</div>
                                <p class="text-[11px] text-slate-600">{{ $booking->submissions->count() }} Link(s) / files submitted</p>
                            </div>

                            <!-- Step 4: Escrow Release & Review -->
                            <div class="p-3.5 rounded-2xl border {{ $booking->status === 'completed' ? 'bg-emerald-50/70 border-emerald-200' : 'bg-slate-50 border-slate-200 opacity-60' }} space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black {{ $booking->status === 'completed' ? 'text-emerald-800' : 'text-slate-400' }} uppercase tracking-wider">STAGE 4</span>
                                    <span class="text-xs font-bold {{ $booking->status === 'completed' ? 'text-emerald-600' : 'text-slate-400' }}">
                                        {{ $booking->status === 'completed' ? 'Disbursed' : 'Payout' }}
                                    </span>
                                </div>
                                <div class="font-bold text-slate-900 text-xs">Disbursal & Rating</div>
                                <p class="text-[11px] text-slate-600">{{ $myReview ? $myReview->rating_overall . '/5 Rated' : 'Sign-off release' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Deliverable Proof Vault & Review Cards -->
                    <div class="space-y-4 pt-2">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-bold text-slate-900 font-display flex items-center space-x-2">
                                <span class="inline-flex items-center gap-1.5"><i data-lucide="folder" class="w-4 h-4 text-brand-600"></i> Proof Vault Submissions</span>
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[11px] font-bold tabular-nums">
                                    {{ $booking->submissions->count() }}
                                </span>
                            </h3>
                            @if($booking->application_id)
                                <a href="{{ route('brand.chat', $booking->application_id) }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center space-x-1">
                                    <span class="inline-flex items-center gap-1"><i data-lucide="message-square" class="w-3.5 h-3.5"></i> Chat with Creator</span>
                                    <span>&rarr;</span>
                                </a>
                            @endif
                        </div>

                        @forelse($booking->submissions as $sub)
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-4">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs font-bold text-slate-900 font-display">
                                                {{ $sub->deliverable->name ?? 'Deliverable Item' }}
                                            </span>
                                            <span class="text-slate-400 text-xs">&bull;</span>
                                            <span class="text-[11px] text-slate-500 tabular-nums">
                                                Submitted {{ $sub->submitted_at ? $sub->submitted_at->format('M d, Y h:i A') : 'Recently' }}
                                            </span>
                                        </div>

                                        <!-- Live Link Launcher -->
                                        <div class="flex items-center space-x-2 pt-1">
                                            <a href="{{ $sub->submission_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-white border border-brand-200 text-brand-600 hover:bg-brand-50 font-bold text-xs transition shadow-2xs">
                                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                                <span>Launch Live Proof URL</span>
                                                <span class="text-slate-400">&rarr;</span>
                                            </a>
                                            <span class="text-xs text-slate-500 truncate max-w-xs sm:max-w-md">{{ $sub->submission_url }}</span>
                                        </div>
                                    </div>

                                    <!-- Status Pill -->
                                    <div>
                                        @if($sub->status === 'approved')
                                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-300 flex items-center space-x-1">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                                <span>Approved & Verified</span>
                                            </span>
                                        @elseif($sub->status === 'changes_requested')
                                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-amber-100 text-amber-800 border border-amber-300 flex items-center space-x-1">
                                                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                                <span>Changes Requested</span>
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-blue-100 text-blue-800 border border-blue-300 flex items-center space-x-1">
                                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                                <span>Awaiting Your Review</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Creator Notes / Captions -->
                                @if($sub->caption || $sub->notes)
                                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 text-xs space-y-1">
                                        @if($sub->caption)
                                            <div><span class="font-bold text-slate-700">Caption:</span> <span class="text-slate-600">{{ $sub->caption }}</span></div>
                                        @endif
                                        @if($sub->notes)
                                            <div><span class="font-bold text-slate-700">Notes from Creator:</span> <span class="text-slate-600">{{ $sub->notes }}</span></div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Revision History Callout -->
                                @if($sub->revision_feedback)
                                    <div class="bg-amber-50/80 p-3.5 rounded-xl border border-amber-200 text-xs text-amber-900 space-y-1">
                                        <span class="font-bold uppercase tracking-wider text-[10px] text-amber-700 block">Requested Changes Log:</span>
                                        <p>{{ $sub->revision_feedback }}</p>
                                    </div>
                                @endif

                                <!-- Brand Review Actions (Approve vs Request Changes) -->
                                @if($sub->status !== 'approved' && $booking->status !== 'completed')
                                    <div class="pt-2 border-t border-slate-200/80 flex flex-wrap items-center justify-end gap-2">
                                        <button type="button" @click="openRevision({{ json_encode($booking) }}, {{ json_encode($sub) }})" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold transition flex items-center space-x-1 shadow-2xs">
                                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                            <span>Request Revision</span>
                                            <span class="text-slate-400">• {{ $revisionsRemaining }} left</span>
                                        </button>

                                        <button type="button" @click="openApprove({{ json_encode($booking) }}, {{ json_encode($sub) }})" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center space-x-1.5 shadow-sm">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                            <span>Approve & Release Escrow • ₹{{ number_format($booking->agreed_fee) }}</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="p-8 text-center bg-slate-50 border border-slate-200 rounded-2xl text-slate-400 space-y-2">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2"><i data-lucide="video" class="w-6 h-6"></i></div>
                                <p class="text-xs font-medium text-slate-600">The creator has not submitted content proof links yet.</p>
                                <p class="text-[11px] text-slate-400">You can use direct chat to align on draft shoot dates and creative guidelines.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Completed Review Callout -->
                    @if($booking->status === 'completed')
                        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-emerald-50/50 p-4 rounded-2xl border border-emerald-200">
                            <div class="space-y-0.5">
                                <div class="text-xs font-bold text-emerald-900 flex items-center space-x-1.5">
                                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                                    <span>Collaboration Completed & Escrow Paid</span>
                                </div>
                                <p class="text-[11px] text-emerald-700">Talent profile has been credited. You can leave or update your rating.</p>
                            </div>

                            <div>
                                @if($myReview)
                                    <div class="flex items-center space-x-2 text-xs font-bold text-slate-800">
                                        <span class="px-2.5 py-1 rounded-lg bg-white border border-emerald-200 text-emerald-800 font-display inline-flex items-center gap-1">
                                            <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-500 text-amber-500"></i> {{ $myReview->rating_overall }}.0 / 5.0 Rated
                                        </span>
                                        <button type="button" @click="openReview({{ json_encode($booking) }})" class="text-brand-600 hover:underline text-xs">
                                            Edit Review
                                        </button>
                                    </div>
                                @else
                                    <button type="button" @click="openReview({{ json_encode($booking) }})" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-2xs transition flex items-center space-x-1">
                                        <i data-lucide="star" class="w-3.5 h-3.5"></i>
                                        <span>Rate & Review Creator</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-20 bg-white border border-slate-200 rounded-3xl p-8 space-y-3">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2"><i data-lucide="briefcase" class="w-8 h-8"></i></div>
                    <h3 class="text-lg font-bold text-slate-900 font-display">No Active Bookings Recorded</h3>
                    <p class="text-slate-400 text-xs max-w-sm mx-auto">When you accept creator quotes from campaign applications or in-chat offers, contracts with 100% escrow protection will appear here.</p>
                    <div class="pt-3">
                        <a href="{{ route('brand.campaigns') }}" class="inline-flex px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition shadow-2xs">
                            View Open Campaigns Briefs &rarr;
                        </a>
                    </div>
                </div>
            @endforelse

            @if(method_exists($bookings, 'links'))
                <div class="pt-4">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>

        <!-- 1. APPROVE & RELEASE ESCROW MODAL -->
        <div x-show="showApproveModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showApproveModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="showApproveModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showApproveModal" x-transition class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 p-6 sm:p-8 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-black">
                            <i data-lucide="check" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 font-display">Approve Deliverable & Release Escrow</h3>
                            <p class="text-xs text-slate-500">Authorize final sign-off and disburse guaranteed payment.</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Creator:</span>
                            <span class="font-bold text-slate-900" x-text="activeBooking?.talent_profile?.display_name || 'Creator'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Agreed Creator Fee:</span>
                            <span class="font-black text-emerald-700 font-display tabular-nums">₹<span x-text="Number(activeBooking?.agreed_fee || 0).toLocaleString('en-IN')"></span></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Submitted Proof Link:</span>
                            <a :href="activeSubmission?.submission_url" target="_blank" class="font-bold text-brand-600 truncate max-w-[200px]" x-text="activeSubmission?.submission_url"></a>
                        </div>
                    </div>

                    <p class="text-xs text-slate-500 leading-relaxed">
                        By confirming, you verify that the content meets all brand guidelines and commercial usage agreements. The escrow funds will be immediately released to the creator.
                    </p>

                    <form :action="'/brand/bookings/' + activeBooking?.id + '/submissions/' + activeSubmission?.id + '/approve'" method="POST" class="flex items-center justify-end space-x-3 pt-2">
                        @csrf
                        <button type="button" @click="showApproveModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm">
                            Confirm Approval & Release Funds
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 2. REQUEST REVISION MODAL -->
        <div x-show="showRevisionModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showRevisionModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="showRevisionModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showRevisionModal" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 p-6 sm:p-8 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-black">
                            <i data-lucide="rotate-ccw" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 font-display">Request Deliverable Modification</h3>
                            <p class="text-xs text-slate-500">Provide actionable feedback for the creator to make edits.</p>
                        </div>
                    </div>

                    <form :action="'/brand/bookings/' + activeBooking?.id + '/submissions/' + activeSubmission?.id + '/revision'" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Revision Instructions & Feedback</label>
                            <textarea name="revision_feedback" x-model="revisionFeedback" required rows="4" placeholder="Be specific about audio adjustments, brand logo placement, caption hashtag edits, or color grading..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition"></textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-2">
                            <button type="button" @click="showRevisionModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition shadow-sm">
                                Send Revision Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 3. STAR RATING & REVIEW MODAL -->
        <div x-show="showReviewModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showReviewModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="showReviewModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showReviewModal" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 p-6 sm:p-8 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl">
                            <i data-lucide="star" class="w-6 h-6 fill-amber-500 text-amber-500"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 font-display">Rate & Review Creator</h3>
                            <p class="text-xs text-slate-500">Your feedback helps build trusted talent reputation metrics.</p>
                        </div>
                    </div>

                    <form :action="'/brand/bookings/' + activeBooking?.id + '/review'" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1">Overall Rating</label>
                            <div class="flex items-center space-x-2">
                                <template x-for="star in [1,2,3,4,5]">
                                    <button type="button" @click="reviewRating = star" class="p-1 transition transform hover:scale-110">
                                        <svg class="w-7 h-7" :class="star <= reviewRating ? 'text-amber-400 fill-amber-400' : 'text-slate-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                    </button>
                                </template>
                                <input type="hidden" name="rating_overall" :value="reviewRating">
                                <span class="text-xs font-bold text-slate-700 ml-2" x-text="reviewRating + ' / 5 Stars'"></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 pt-2">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Quality</label>
                                <select name="quality_rating" x-model="reviewQuality" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs font-medium text-slate-900">
                                    <option value="5">5 - Exceptional</option>
                                    <option value="4">4 - Good</option>
                                    <option value="3">3 - Average</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="1">1 - Poor</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Communication</label>
                                <select name="communication_rating" x-model="reviewCommunication" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs font-medium text-slate-900">
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Good</option>
                                    <option value="3">3 - Normal</option>
                                    <option value="2">2 - Slow</option>
                                    <option value="1">1 - Unresponsive</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Punctuality</label>
                                <select name="punctuality_rating" x-model="reviewPunctuality" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs font-medium text-slate-900">
                                    <option value="5">5 - On Time</option>
                                    <option value="4">4 - Minor Delay</option>
                                    <option value="3">3 - Acceptable</option>
                                    <option value="2">2 - Late</option>
                                    <option value="1">1 - Missed Due</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Review Feedback</label>
                            <textarea name="review_text" x-model="reviewText" rows="3" placeholder="Great communication, delivered 4K high quality reel on time..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition"></textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-2">
                            <button type="button" @click="showReviewModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold transition shadow-sm">
                                Submit Rating
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

                        <div class="grid grid-cols-3 gap-2 pt-2">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Quality</label>
                                <select name="quality_rating" x-model="reviewQuality" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs font-medium text-slate-900">
                                    <option value="5">5 - Exceptional</option>
                                    <option value="4">4 - Good</option>
                                    <option value="3">3 - Average</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="1">1 - Poor</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Communication</label>
                                <select name="communication_rating" x-model="reviewCommunication" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs font-medium text-slate-900">
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Good</option>
                                    <option value="3">3 - Normal</option>
                                    <option value="2">2 - Slow</option>
                                    <option value="1">1 - Unresponsive</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Punctuality</label>
                                <select name="punctuality_rating" x-model="reviewPunctuality" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs font-medium text-slate-900">
                                    <option value="5">5 - On Time</option>
                                    <option value="4">4 - Minor Delay</option>
                                    <option value="3">3 - Acceptable</option>
                                    <option value="2">2 - Late</option>
                                    <option value="1">1 - Missed Due</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Review Feedback</label>
                            <textarea name="review_text" x-model="reviewText" rows="3" placeholder="Great communication, delivered 4K high quality reel on time..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition"></textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-2">
                            <button type="button" @click="showReviewModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold transition shadow-sm">
                                Submit Rating
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
