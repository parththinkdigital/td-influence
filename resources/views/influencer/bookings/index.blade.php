@extends('layouts.influencer')

@section('title', 'Collaborations, Milestones & Deliverables Vault | Creator Studio')

@section('content')
    <div class="space-y-8" x-data="{
        openSubmitModal: false,
        activeBooking: null,
        submissionUrl: '',
        deliverableId: '',
        caption: '',
        notes: '',

        openSubmit(booking) {
            this.activeBooking = booking;
            this.submissionUrl = '';
            this.deliverableId = booking.campaign?.deliverables?.[0]?.id || '';
            this.caption = '';
            this.notes = '';
            this.openSubmitModal = true;
        }
    }">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Milestone Escrow Collaboration</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">My Bookings & Deliverable Proofs</h1>
                <p class="text-slate-500 text-sm mt-1">Submit live content proofs, monitor milestone approval, review brand feedback, and receive guaranteed escrow payouts.</p>
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
                    $pendingRevision = $booking->submissions->firstWhere('status', 'changes_requested');
                    $myReview = $booking->reviews->first();
                @endphp

                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-xs space-y-6">
                    <!-- Contract Top Row -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-black text-pink-600 uppercase tracking-wider font-display">
                                    {{ $booking->campaign->brandProfile->company_name ?? 'Brand Client' }}
                                </span>
                                @if($booking->campaign->city)
                                    <span class="text-slate-400 text-xs">&bull;</span>
                                    <span class="text-xs text-slate-500 font-medium inline-flex items-center gap-1">
                                        <i class="fa-solid fa-location-dot text-slate-400 text-xs"></i> 
                                        {{ $booking->campaign->city }}
                                    </span>
                                @endif
                            </div>

                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 font-display tracking-tight">
                                {{ $booking->campaign->title ?? 'Campaign Order' }}
                            </h2>

                            <!-- Contract Badges -->
                            <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
                                <span class="px-3 py-1 rounded-xl bg-slate-50 border border-slate-200/80 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                                    <span>{{ $usageText }}</span>
                                </span>
                                <span class="px-3 py-1 rounded-xl bg-slate-50 border border-slate-200/80 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-rotate-left text-slate-400"></i>
                                    <span>{{ $revisionsAllowed }} Revision(s) Allowed</span>
                                    @if($revisionsUsed > 0)
                                        <span class="text-amber-600 font-bold">({{ $revisionsUsed }} used)</span>
                                    @endif
                                </span>
                                <span class="px-3 py-1 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-500 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-calendar text-slate-400"></i>
                                    <span>Due Date:</span>
                                    <span class="font-bold text-slate-800">{{ $booking->shoot_date ? $booking->shoot_date->format('M d, Y') : 'Agreed Timeline' }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Escrow Financial Snapshot -->
                        <div class="flex items-center lg:items-end flex-col bg-slate-50 p-4 rounded-2xl border border-slate-200/80 min-w-[220px]">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Your Agreed Creator Fee</span>
                            <div class="text-2xl font-black text-emerald-600 font-display tabular-nums">
                                ₹{{ number_format($booking->agreed_fee) }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                <span class="inline-flex items-center gap-1 text-emerald-600 font-bold">
                                    <i class="fa-solid fa-shield-halved"></i> 100% Guaranteed Escrow
                                </span>
                            </div>
                            <div class="mt-2">
                                @if($booking->status === 'completed')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-300 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-check text-[9px]"></i> Payout Released
                                    </span>
                                @elseif($booking->status === 'deliverables_submitted')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-amber-50 text-amber-800 border border-amber-200 inline-flex items-center gap-1 animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> In Brand Verification
                                    </span>
                                @elseif($pendingRevision)
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-rose-50 text-rose-800 border border-rose-200 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-triangle-exclamation text-[9px]"></i> Revision Requested
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-indigo-50 text-indigo-800 border border-indigo-200">
                                        Active Contract
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Banner for Pending Revisions -->
                    @if($pendingRevision && $booking->status !== 'completed')
                        <div class="bg-rose-50 border-2 border-rose-200 rounded-2xl p-5 space-y-3">
                            <div class="flex items-center space-x-2 text-rose-900 font-black text-sm font-display">
                                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                                <span>Action Required: Brand Client Requested Revisions</span>
                            </div>
                            <div class="bg-white p-3.5 rounded-xl border border-rose-200 text-xs text-slate-800 space-y-1">
                                <span class="font-bold uppercase tracking-wider text-[10px] text-rose-700 block">Feedback from Brand:</span>
                                <p class="leading-relaxed">{{ $pendingRevision->revision_feedback }}</p>
                            </div>
                            <div class="flex items-center justify-between pt-1">
                                <span class="text-xs text-rose-700 font-semibold">Please make edits and submit an updated proof link below:</span>
                                <button type="button" @click="openSubmit({{ json_encode($booking) }})" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <span>Submit Revised Proof &rarr;</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Completed Milestone & Testimonial Review Banner -->
                    @if($booking->status === 'completed')
                        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 sm:p-5 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="text-xs font-black text-emerald-900 flex items-center space-x-2 font-display">
                                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                                    <span>Milestone Completed &amp; Payout Disbursed</span>
                                </div>
                                <span class="text-xs font-black text-emerald-800 tabular-nums font-display">
                                    ₹{{ number_format($booking->agreed_fee) }} Credited
                                </span>
                            </div>

                            @if($myReview)
                                <div class="bg-white p-4 rounded-xl border border-emerald-200 text-xs space-y-1.5 shadow-2xs">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-amber-500 font-bold inline-flex items-center gap-0.5">
                                            @for($i = 0; $i < ($myReview->rating_overall ?? 5); $i++)
                                                <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                            @endfor
                                        </span>
                                        <span class="font-bold text-slate-900">{{ $myReview->rating_overall }}.0 Star Brand Review</span>
                                    </div>
                                    @if($myReview->review_text)
                                        <p class="text-slate-600 italic">"{{ $myReview->review_text }}"</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Submit Deliverable Action Panel -->
                    @if($booking->status !== 'completed')
                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-5 space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900 font-display">Submit Deliverable Live Link / Proof</h3>
                                    <p class="text-xs text-slate-500">Provide public Instagram Reel/Post URL, YouTube link, or Google Drive folder.</p>
                                </div>
                                <button type="button" @click="openSubmit({{ json_encode($booking) }})" class="px-5 py-2.5 bg-pink-600 hover:bg-pink-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center space-x-1.5 self-start sm:self-auto">
                                    <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                                    <span>+ New Proof Submission</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Deliverable Submission Vault History -->
                    <div class="space-y-3">
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
                                                <a href="{{ $sub->submission_url ?: ($sub->preview_url ?: $sub->file_url) }}" target="_blank" class="text-xs font-bold text-pink-600 hover:underline inline-flex items-center gap-1 font-mono">
                                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                                    <span>{{ $sub->submission_url ?: 'Open Proof Link / Drive' }}</span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        @if($sub->status === 'approved')
                                            <span class="text-xs font-bold text-emerald-600 inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 rounded-xl border border-emerald-100">
                                                <i class="fa-solid fa-circle-check"></i>
                                                <span>Approved & Escrow Released</span>
                                            </span>
                                        @else
                                            <span class="text-xs font-bold text-amber-600 inline-flex items-center gap-1 px-3 py-1 bg-amber-50 rounded-xl border border-amber-100">
                                                <i class="fa-solid fa-clock"></i>
                                                <span>Awaiting Brand Review</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center text-slate-400 bg-slate-50 rounded-2xl border border-slate-200/80">
                                    <p class="text-xs">No deliverables submitted yet. Shoot your content and click "+ New Proof Submission".</p>
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
                    <div class="font-bold text-slate-800 text-base">No active bookings recorded</div>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">When brands select your campaign proposals or accept your chat quotes, active milestone orders will appear here.</p>
                </div>
            @endforelse
        </div>

        <!-- DELIVERABLE SUBMISSION MODAL -->
        <div x-show="openSubmitModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4">
            <div @click.away="openSubmitModal = false" class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-200 p-6 sm:p-8 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900 font-display">Submit Deliverable Proof Link</h3>
                            <p class="text-xs text-slate-500">Provide live content URL for client verification & escrow release.</p>
                        </div>
                    </div>
                    <button @click="openSubmitModal = false" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <form :action="'/influencer/bookings/' + (activeBooking ? activeBooking.id : '') + '/submit'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Live Content / Proof URL *</label>
                        <input type="url" name="submission_url" x-model="submissionUrl" required placeholder="https://instagram.com/reel/... or YouTube URL or Google Drive HD Link" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-pink-600 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Caption Used (Optional)</label>
                        <textarea name="caption" x-model="caption" rows="2" placeholder="Paste the exact caption, hashtags, and brand tags used..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 focus:outline-none focus:border-pink-600 focus:bg-white transition"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Creator Notes for Brand (Optional)</label>
                        <textarea name="notes" x-model="notes" rows="2" placeholder="e.g. 4K reel exported, brand tagged in video and audio credits..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 focus:outline-none focus:border-pink-600 focus:bg-white transition"></textarea>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-2 border-t border-slate-100">
                        <button type="button" @click="openSubmitModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-pink-600 hover:bg-pink-700 text-white text-xs font-bold transition shadow-xs inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-check"></i>
                            <span>Submit for Verification</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
