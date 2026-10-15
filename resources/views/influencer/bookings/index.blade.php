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
                <div class="flex items-center space-x-2">
                    <span class="px-2.5 py-1 rounded-md bg-brand-50 border border-brand-200 text-brand-700 text-xs font-bold uppercase tracking-wider">
                        Milestone Escrow Collaboration
                    </span>
                    <span class="text-xs text-slate-400">&bull;</span>
                    <span class="text-xs font-semibold text-emerald-600">Guaranteed Creator Payout</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display mt-1">My Bookings & Deliverable Proofs</h1>
                <p class="text-slate-500 text-sm mt-1">Submit live content proofs, monitor milestone approval, review brand feedback, and receive guaranteed escrow payouts.</p>
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
                    $pendingRevision = $booking->submissions->firstWhere('status', 'changes_requested');
                    $myReview = $booking->reviews->first();
                @endphp

                <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs space-y-6">
                    <!-- Contract Top Row -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-bold text-brand-600 uppercase tracking-wider font-display">
                                    {{ $booking->campaign->brandProfile->company_name ?? 'Brand Client' }}
                                </span>
                                @if($booking->campaign->city)
                                    <span class="text-slate-400 text-xs">&bull;</span>
                                    <span class="text-xs text-slate-500 font-medium inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i> {{ $booking->campaign->city }}</span>
                                @endif
                            </div>

                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 font-display tracking-tight">
                                {{ $booking->campaign->title ?? 'Campaign Order' }}
                            </h2>

                            <!-- Contract Badges -->
                            <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
                                <span class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-200 font-semibold text-slate-700 flex items-center space-x-1.5">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-slate-500"></i>
                                    <span>{{ $usageText }}</span>
                                </span>
                                <span class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-200 font-semibold text-slate-700 flex items-center space-x-1.5">
                                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 text-slate-500"></i>
                                    <span>{{ $revisionsAllowed }} Revision(s) Allowed</span>
                                    @if($revisionsUsed > 0)
                                        <span class="text-amber-600 font-bold">({{ $revisionsUsed }} used)</span>
                                    @endif
                                </span>
                                @if($booking->exclusivity_days > 0)
                                    <span class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-200 font-semibold text-slate-700 flex items-center space-x-1.5">
                                        <i data-lucide="lock" class="w-3.5 h-3.5 text-slate-500"></i>
                                        <span>{{ $booking->exclusivity_days }}d Exclusivity</span>
                                    </span>
                                @endif
                                <span class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 flex items-center space-x-1.5">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                    <span>Due Date:</span>
                                    <span class="font-bold text-slate-700">{{ $booking->shoot_date ? $booking->shoot_date->format('M d, Y') : 'Agreed Timeline' }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Escrow Financial Snapshot -->
                        <div class="flex items-center lg:items-end flex-col bg-slate-50 p-4 rounded-2xl border border-slate-200 min-w-[220px]">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Your Agreed Creator Fee</span>
                            <div class="text-2xl font-black text-emerald-600 font-display tabular-nums">
                                ₹{{ number_format($booking->agreed_fee) }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                <span class="inline-flex items-center gap-1"><i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i> 100% Guaranteed Escrow</span>
                            </div>
                            <div class="mt-2">
                                @if($booking->status === 'completed')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-300 inline-flex items-center gap-1">
                                        <i data-lucide="check" class="w-3 h-3"></i>
                                        <span>Payout Released</span>
                                    </span>
                                @elseif($booking->status === 'deliverables_submitted')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-amber-100 text-amber-800 border border-amber-300 animate-pulse inline-flex items-center gap-1">
                                        <i data-lucide="clock" class="w-3 h-3"></i>
                                        <span>In Brand Verification</span>
                                    </span>
                                @elseif($pendingRevision)
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-rose-100 text-rose-800 border border-rose-300 animate-bounce inline-flex items-center gap-1">
                                        <i data-lucide="alert-triangle" class="w-3 h-3"></i>
                                        <span>Revision Requested</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-brand-100 text-brand-800 border border-brand-300">
                                        Active Contract
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
                                    Stage 4/4 Payout Disbursed
                                @elseif($booking->submissions->where('status', 'approved')->isNotEmpty() || $booking->status === 'approved')
                                    Stage 4/4 Final Sign-off
                                @elseif($booking->submissions->isNotEmpty())
                                    Stage 3/4 Proof Submitted
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
                                <div class="font-bold text-slate-900 text-xs">Agreed & Funded</div>
                                <p class="text-[11px] text-slate-600">Escrow held securely</p>
                            </div>

                            <!-- Step 2: Production -->
                            <div class="p-3.5 rounded-2xl border {{ $booking->submissions->isNotEmpty() || $booking->status === 'completed' ? 'bg-emerald-50/70 border-emerald-200' : 'bg-brand-50/70 border-brand-200 ring-2 ring-brand-500/20' }} space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black {{ $booking->submissions->isNotEmpty() || $booking->status === 'completed' ? 'text-emerald-800' : 'text-brand-800' }} uppercase tracking-wider">STAGE 2</span>
                                    <span class="text-xs font-bold {{ $booking->submissions->isNotEmpty() || $booking->status === 'completed' ? 'text-emerald-600' : 'text-brand-600' }} inline-flex items-center gap-1">
                                        @if($booking->submissions->isNotEmpty() || $booking->status === 'completed')
                                            <i data-lucide="check" class="w-3 h-3"></i> Done
                                        @else
                                            <i data-lucide="video" class="w-3 h-3"></i> Filming
                                        @endif
                                    </span>
                                </div>
                                <div class="font-bold text-slate-900 text-xs">Creation & Production</div>
                                <p class="text-[11px] text-slate-600">Shoot & edit content</p>
                            </div>

                            <!-- Step 3: Deliverable Proof -->
                            <div class="p-3.5 rounded-2xl border {{ $booking->status === 'completed' || $booking->submissions->where('status', 'approved')->isNotEmpty() ? 'bg-emerald-50/70 border-emerald-200' : ($booking->submissions->isNotEmpty() ? 'bg-amber-50/80 border-amber-300 ring-2 ring-amber-500/20' : 'bg-slate-50 border-slate-200') }} space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black {{ $booking->status === 'completed' || $booking->submissions->where('status', 'approved')->isNotEmpty() ? 'text-emerald-800' : ($booking->submissions->isNotEmpty() ? 'text-amber-800' : 'text-slate-400') }} uppercase tracking-wider">STAGE 3</span>
                                    <span class="text-xs font-bold {{ $booking->status === 'completed' || $booking->submissions->where('status', 'approved')->isNotEmpty() ? 'text-emerald-600' : ($booking->submissions->isNotEmpty() ? 'text-amber-700' : 'text-slate-500') }} inline-flex items-center gap-1">
                                        @if($booking->status === 'completed' || $booking->submissions->where('status', 'approved')->isNotEmpty())
                                            <i data-lucide="check" class="w-3 h-3"></i> Approved
                                        @elseif($booking->submissions->isNotEmpty())
                                            <i data-lucide="clock" class="w-3 h-3"></i> Review
                                        @else
                                            <i data-lucide="upload" class="w-3 h-3"></i> Submit Proof
                                        @endif
                                    </span>
                                </div>
                                <div class="font-bold text-slate-900 text-xs">Proof Link Vault</div>
                                <p class="text-[11px] text-slate-600">{{ $booking->submissions->count() }} Link(s) logged</p>
                            </div>

                            <!-- Step 4: Escrow Release & Review -->
                            <div class="p-3.5 rounded-2xl border {{ $booking->status === 'completed' ? 'bg-emerald-50/70 border-emerald-200' : 'bg-slate-50 border-slate-200 opacity-60' }} space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black {{ $booking->status === 'completed' ? 'text-emerald-800' : 'text-slate-400' }} uppercase tracking-wider">STAGE 4</span>
                                    <span class="text-xs font-bold {{ $booking->status === 'completed' ? 'text-emerald-600' : 'text-slate-400' }} inline-flex items-center gap-1">
                                        @if($booking->status === 'completed')
                                            <i data-lucide="check" class="w-3 h-3"></i> Disbursed
                                        @else
                                            <i data-lucide="clock" class="w-3 h-3"></i> Payout
                                        @endif
                                    </span>
                                </div>
                                <div class="font-bold text-slate-900 text-xs">Payout & Rating</div>
                                <p class="text-[11px] text-slate-600">{{ $myReview ? $myReview->rating_overall . '/5 Rating' : 'Escrow release' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Banner for Pending Revisions -->
                    @if($pendingRevision && $booking->status !== 'completed')
                        <div class="bg-rose-50 border-2 border-rose-300 rounded-2xl p-5 space-y-3">
                            <div class="flex items-center space-x-2 text-rose-900 font-bold text-sm">
                                <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-600"></i>
                                <span>Action Required: Brand Client Requested Revisions</span>
                            </div>
                            <div class="bg-white p-3.5 rounded-xl border border-rose-200 text-xs text-slate-800 space-y-1">
                                <span class="font-bold uppercase tracking-wider text-[10px] text-rose-700 block">Feedback from Brand:</span>
                                <p class="leading-relaxed">{{ $pendingRevision->revision_feedback }}</p>
                            </div>
                            <div class="flex items-center justify-between pt-1">
                                <span class="text-xs text-rose-700 font-semibold">Please make edits and submit an updated proof link below:</span>
                                <button type="button" @click="openSubmit({{ json_encode($booking) }})" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
                                    Submit Revised Proof &rarr;
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Submit Deliverable Action Panel -->
                    @if($booking->status !== 'completed')
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900 font-display">Submit Deliverable Live Link / Proof</h3>
                                    <p class="text-xs text-slate-500">Provide public Instagram Reel/Post URL, YouTube link, or Google Drive folder.</p>
                                </div>
                                <button type="button" @click="openSubmit({{ json_encode($booking) }})" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-2xs transition flex items-center space-x-1.5 self-start sm:self-auto">
                                    <span>+ New Proof Submission</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Deliverable Submission Vault History -->
                    <div class="space-y-4 pt-2">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-bold text-slate-900 font-display flex items-center space-x-2">
                                <i data-lucide="folder" class="w-4 h-4 text-slate-500"></i>
                                <span>Proof Vault Submission Log</span>
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[11px] font-bold tabular-nums">
                                    {{ $booking->submissions->count() }}
                                </span>
                            </h3>
                            @if($booking->application_id)
                                <a href="{{ route('influencer.chat', $booking->application_id) }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center space-x-1">
                                    <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                                    <span>Chat with Brand</span>
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
                                                {{ $sub->deliverable->name ?? 'Deliverable Content' }}
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
                                                <span>Launch Proof URL</span>
                                                <span class="text-slate-400">&rarr;</span>
                                            </a>
                                            <span class="text-xs text-slate-500 truncate max-w-xs sm:max-w-md">{{ $sub->submission_url }}</span>
                                        </div>
                                    </div>

                                    <!-- Status Pill -->
                                    <div>
                                        @if($sub->status === 'approved')
                                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-300 flex items-center space-x-1">
                                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
                                                <span>Approved & Escrow Released</span>
                                            </span>
                                        @elseif($sub->status === 'changes_requested')
                                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-rose-100 text-rose-800 border border-rose-300 flex items-center space-x-1">
                                                <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>
                                                <span>Changes Requested</span>
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-amber-100 text-amber-800 border border-amber-300 flex items-center space-x-1">
                                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                                <span>In Brand Review</span>
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
                                            <div><span class="font-bold text-slate-700">Your Submission Note:</span> <span class="text-slate-600">{{ $sub->notes }}</span></div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Revision Feedback Log -->
                                @if($sub->revision_feedback)
                                    <div class="bg-rose-50 p-3.5 rounded-xl border border-rose-200 text-xs text-rose-900 space-y-1">
                                        <span class="font-bold uppercase tracking-wider text-[10px] text-rose-700 block">Brand Revision Feedback:</span>
                                        <p>{{ $sub->revision_feedback }}</p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="p-8 text-center bg-slate-50 border border-slate-200 rounded-2xl text-slate-400 space-y-2">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                                    <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                                </div>
                                <p class="text-xs font-medium text-slate-600">No deliverable proofs submitted yet.</p>
                                <p class="text-[11px] text-slate-400">Once your content is recorded or live, click "New Proof Submission" to share the URL with the brand.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Completed Review & Testimonial -->
                    @if($booking->status === 'completed')
                        <div class="pt-4 border-t border-slate-100 bg-emerald-50/50 p-5 rounded-2xl border border-emerald-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="text-xs font-bold text-emerald-900 flex items-center space-x-1.5">
                                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                                    <span>Milestone Completed & Payout Disbursed</span>
                                </div>
                                <span class="text-xs font-black text-emerald-800 tabular-nums font-display">
                                    ₹{{ number_format($booking->agreed_fee) }} Credited
                                </span>
                            </div>

                            @if($myReview)
                                <div class="bg-white p-4 rounded-xl border border-emerald-200 text-xs space-y-1.5">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-amber-500 font-bold inline-flex items-center gap-0.5">
                                            @for($i = 0; $i < $myReview->rating_overall; $i++) <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400 text-amber-400 inline"></i> @endfor
                                        </span>
                                        <span class="font-bold text-slate-900">{{ $myReview->rating_overall }}.0 Star Client Rating</span>
                                    </div>
                                    @if($myReview->review_text)
                                        <p class="text-slate-600 italic">"{{ $myReview->review_text }}"</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-20 bg-white border border-slate-200 rounded-3xl p-8 space-y-3">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                        <i data-lucide="calendar" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-display">No Active Bookings Recorded</h3>
                    <p class="text-slate-400 text-xs max-w-sm mx-auto">When brands select your campaign proposals or accept your chat quotes, active milestone orders will appear here.</p>
                    <div class="pt-3">
                        <a href="{{ route('influencer.campaigns') }}" class="inline-flex px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition shadow-2xs">
                            Discover Open Campaign Briefs &rarr;
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

        <!-- DELIVERABLE SUBMISSION MODAL -->
        <div x-show="openSubmitModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openSubmitModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="openSubmitModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="openSubmitModal" x-transition class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 p-6 sm:p-8 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center">
                            <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 font-display">Submit Deliverable Proof Link</h3>
                            <p class="text-xs text-slate-500">Provide public URL for client verification and escrow release.</p>
                        </div>
                    </div>

                    <form :action="'/influencer/bookings/' + activeBooking?.id + '/submit'" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Live Content / Proof URL <span class="text-rose-500">*</span></label>
                            <input type="url" name="submission_url" x-model="submissionUrl" required placeholder="https://instagram.com/reel/... or https://youtu.be/... or Google Drive HD Link" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:bg-white transition">
                            
                            <!-- Live Platform Detection Chip -->
                            <div class="mt-1.5 flex items-center space-x-1.5 text-[11px]" x-show="submissionUrl.trim().length > 5" x-cloak>
                                <template x-if="submissionUrl.includes('instagram.com')">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md font-bold bg-pink-100 text-pink-700 border border-pink-200"><i data-lucide="camera" class="w-3 h-3"></i> Instagram Content Detected</span>
                                </template>
                                <template x-if="submissionUrl.includes('youtube.com') || submissionUrl.includes('youtu.be')">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md font-bold bg-red-100 text-red-700 border border-red-200"><i data-lucide="film" class="w-3 h-3"></i> YouTube Video / Short Detected</span>
                                </template>
                                <template x-if="submissionUrl.includes('tiktok.com')">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md font-bold bg-slate-900 text-white border border-slate-700"><i data-lucide="music" class="w-3 h-3"></i> TikTok Video Detected</span>
                                </template>
                                <template x-if="submissionUrl.includes('drive.google.com') || submissionUrl.includes('dropbox.com')">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md font-bold bg-blue-100 text-blue-700 border border-blue-200"><i data-lucide="folder" class="w-3 h-3"></i> Cloud Drive Deliverables</span>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Caption Used (Optional)</label>
                            <textarea name="caption" x-model="caption" rows="2" placeholder="Paste the exact caption, hashtags, and brand tags used..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Creator Notes for Brand (Optional)</label>
                            <textarea name="notes" x-model="notes" rows="2" placeholder="e.g. Story tags added, 4K reel exported, insights screenshot attached..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Upload Screenshot / Evidence File (Optional)</label>
                            <input type="file" name="proof_file" accept="image/*,video/*,application/pdf" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs text-slate-700">
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-2">
                            <button type="button" @click="openSubmitModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold transition shadow-sm">
                                Submit for Verification &rarr;
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Caption Used (Optional)</label>
                            <textarea name="caption" x-model="caption" rows="2" placeholder="Paste the exact caption, hashtags, and brand tags used..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Creator Notes for Brand (Optional)</label>
                            <textarea name="notes" x-model="notes" rows="2" placeholder="e.g. Story tags added, 4K reel exported, insights screenshot attached..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Upload Screenshot / Evidence File (Optional)</label>
                            <input type="file" name="proof_file" accept="image/*,video/*,application/pdf" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs text-slate-700">
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-2">
                            <button type="button" @click="openSubmitModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold transition shadow-sm">
                                Submit for Verification &rarr;
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
