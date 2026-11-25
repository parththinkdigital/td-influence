@extends('layouts.brand')

@section('title', 'Milestone Collaboration Tracker & Deliverable Vault | Brand Studio')

@section('content')
    <div class="space-y-8" x-data="{
        showApproveModal: false,
        showRevisionModal: false,
        activeBooking: null,
        activeSubmission: null,
        revisionFeedback: '',
        
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
        }
    }">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Milestone Collaboration Engine</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Bookings & Deliverable Proof Vault</h1>
                <p class="text-slate-500 text-sm mt-1">Track 4-stage campaign milestones, inspect creator proof links, request revisions, and disburse escrow payouts.</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-white border border-slate-200/80 rounded-2xl px-5 py-2.5 text-right shadow-2xs">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Active Orders</span>
                    <span class="text-xl font-black text-slate-900 font-display tabular-nums">{{ $bookings->total() }}</span>
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
                @endphp

                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-xs space-y-6">
                    <!-- Contract Top Row -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-black text-indigo-600 uppercase tracking-wider font-display">
                                    {{ $booking->talentProfile->display_name ?? 'Creator' }}
                                </span>
                                <span class="text-xs text-slate-400">&bull;</span>
                                <span class="text-xs text-slate-500 font-medium inline-flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-slate-400 text-xs"></i> 
                                    {{ $booking->talentProfile->city ?? 'Nashik, Maharashtra' }}
                                </span>
                            </div>

                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 font-display tracking-tight">
                                {{ $booking->campaign->title ?? 'Campaign Contract' }}
                            </h2>

                            <!-- Contract Badges -->
                            <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
                                <span class="px-3 py-1 rounded-xl bg-slate-50 border border-slate-200/80 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-shield-halved text-indigo-500"></i>
                                    <span>{{ $usageText }}</span>
                                </span>
                                <span class="px-3 py-1 rounded-xl bg-slate-50 border border-slate-200/80 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-rotate-left text-slate-400"></i>
                                    <span>{{ $revisionsAllowed }} Revision(s) Included</span>
                                    @if($revisionsUsed > 0)
                                        <span class="text-amber-600 font-bold">({{ $revisionsUsed }} used)</span>
                                    @endif
                                </span>
                                <span class="px-3 py-1 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-500 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-calendar text-slate-400"></i>
                                    <span>Target:</span>
                                    <span class="font-bold text-slate-800">{{ $booking->shoot_date ? $booking->shoot_date->format('M d, Y') : 'Agreed Timeline' }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Escrow Financial Snapshot -->
                        <div class="flex items-center lg:items-end flex-col bg-slate-50 p-4 rounded-2xl border border-slate-200/80 min-w-[220px]">
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
                                        <i class="fa-solid fa-check text-[9px]"></i> Escrow Disbursed
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-amber-50 text-amber-800 border border-amber-200 inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> In Progress
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 5-Stage Visual Milestone Stepper -->
                    <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200/80">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                            <span class="uppercase tracking-wider text-[10px] text-slate-400">Collaboration Lifecycle</span>
                            <span class="text-indigo-600 uppercase text-[10px] font-black">{{ str_replace('_', ' ', $booking->status) }}</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-3">
                            <div class="p-3 bg-white rounded-xl border border-slate-200 text-center">
                                <i class="fa-solid fa-lock text-indigo-600 text-sm mb-1 block"></i>
                                <span class="text-[11px] font-bold text-slate-900 block">1. Escrow Deposited</span>
                                <span class="text-[9px] text-emerald-600 font-bold">100% Secured</span>
                            </div>
                            <div class="p-3 bg-white rounded-xl border border-slate-200 text-center">
                                <i class="fa-solid fa-video text-indigo-600 text-sm mb-1 block"></i>
                                <span class="text-[11px] font-bold text-slate-900 block">2. Production / Shoot</span>
                                <span class="text-[9px] text-slate-400 font-medium">In Progress</span>
                            </div>
                            <div class="p-3 bg-white rounded-xl border border-slate-200 text-center">
                                <i class="fa-solid fa-cloud-arrow-up text-indigo-600 text-sm mb-1 block"></i>
                                <span class="text-[11px] font-bold text-slate-900 block">3. Proof Submitted</span>
                                <span class="text-[9px] text-slate-400 font-medium">{{ $booking->submissions->count() }} file(s)</span>
                            </div>
                            <div class="p-3 bg-white rounded-xl border border-slate-200 text-center">
                                <i class="fa-solid fa-money-bill-transfer text-emerald-600 text-sm mb-1 block"></i>
                                <span class="text-[11px] font-bold text-slate-900 block">4. Final Payout</span>
                                <span class="text-[9px] {{ $booking->status === 'completed' ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ $booking->status === 'completed' ? 'Disbursed' : 'Awaiting Review' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submissions / Deliverables Review Area -->
                    <div class="space-y-4">
                        <h3 class="text-xs font-black uppercase text-slate-900 tracking-wider">Submitted Deliverable Proofs</h3>
                        <div class="space-y-3">
                            @forelse($booking->submissions as $sub)
                                <div class="bg-white border border-slate-200 p-4 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs">
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <span class="font-bold text-slate-900 text-sm">{{ $sub->deliverable->deliverable_name ?? 'Submission Proof' }}</span>
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $sub->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                                {{ $sub->status }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-500 mt-1">Submitted on {{ $sub->created_at->format('M d, Y • h:i A') }}</p>
                                        
                                        @if($sub->submission_url || $sub->preview_url || $sub->file_url)
                                            <div class="mt-2 flex items-center space-x-3">
                                                <a href="{{ $sub->submission_url ?: ($sub->preview_url ?: $sub->file_url) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:underline inline-flex items-center gap-1 font-mono">
                                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                                    <span>{{ $sub->submission_url ?: 'Open Proof Link / Drive' }}</span>
                                                </a>
                                            </div>
                                        @endif

                                        @if($sub->revision_feedback)
                                            <div class="mt-2 p-2.5 bg-amber-50 rounded-xl border border-amber-200 text-xs text-amber-900">
                                                <span class="font-bold block text-[10px] uppercase tracking-wider text-amber-700">Requested Revision:</span>
                                                {{ $sub->revision_feedback }}
                                            </div>
                                        @endif
                                    </div>

                                    @if($sub->status !== 'approved')
                                        <div class="flex items-center space-x-2">
                                            <button type="button" 
                                                    @click="openRevision({{ json_encode(['id' => $booking->id]) }}, {{ json_encode(['id' => $sub->id]) }})" 
                                                    class="px-3.5 py-2 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 rounded-xl font-bold text-xs transition inline-flex items-center gap-1">
                                                <i class="fa-solid fa-rotate-left"></i>
                                                <span>Request Revision</span>
                                            </button>
                                            <form method="POST" action="{{ route('brand.bookings.approve', [$booking->id, $sub->id]) }}">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-2xs transition inline-flex items-center gap-1.5">
                                                    <i class="fa-solid fa-check"></i>
                                                    <span>Approve & Release Payout</span>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-xs font-bold text-emerald-600 inline-flex items-center gap-1">
                                            <i class="fa-solid fa-circle-check"></i>
                                            <span>Approved & Paid</span>
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <div class="p-6 text-center text-slate-400 bg-slate-50 rounded-2xl border border-slate-200/80">
                                    <p class="text-xs">No deliverables submitted by creator yet. Creator is shooting content.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-16 text-center text-slate-400 bg-white rounded-3xl border border-slate-200/80 shadow-xs">
                    <div class="w-16 h-16 rounded-3xl bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <div class="font-bold text-slate-800 text-base">No active orders or contracts yet</div>
                    <p class="text-xs text-slate-400 mt-1">Shortlist and hire creators from your campaign pitch board to open production orders.</p>
                </div>
            @endforelse
        </div>

        <!-- Modal: Request Revision -->
        <div x-show="showRevisionModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-sm p-4" x-cloak>
            <div @click.away="showRevisionModal = false" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl relative space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-rotate-left"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 font-display">Request Content Revision</h3>
                    </div>
                    <button @click="showRevisionModal = false" class="text-slate-400 hover:text-slate-900 font-bold text-xl">&times;</button>
                </div>

                <form method="POST" :action="'/brand/bookings/' + (activeBooking ? activeBooking.id : '') + '/submissions/' + (activeSubmission ? activeSubmission.id : '') + '/revision'" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Revision Feedback & Required Edits *</label>
                        <textarea name="revision_feedback" rows="4" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-indigo-600 transition" placeholder="Specify exact changes needed (e.g. Add logo at 0:03, re-record audio intro)..."></textarea>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <button type="button" @click="showRevisionModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl text-xs shadow-2xs">Send Revision Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
