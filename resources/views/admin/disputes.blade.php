@extends('layouts.admin')

@section('title', 'Dispute Resolution Center | Admin Gateway')

@section('content')
    <div class="space-y-8" x-data="{ 
        detailModal: false, 
        activeDispute: null,
        openDispute(item) {
            this.activeDispute = item;
            this.detailModal = true;
        }
    }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                    <span>Arbitration & Custody Tribunal</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Escrow Dispute Resolution</h1>
                <p class="text-slate-500 text-sm mt-1">Review active contract disputes regarding briefs, creative revisions, timeline breaches, or escrow payouts.</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-4 py-2 rounded-2xl bg-white border border-slate-200/80 text-slate-700 text-xs font-bold shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-gavel text-rose-500"></i>
                    <span>{{ $disputes->total() }} Total Cases Recorded</span>
                </span>
            </div>
        </div>

        <!-- Dispute Metrics Ribbon -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Open Disputes</span>
                    <h3 class="text-2xl font-black text-rose-600 mt-1 font-display">
                        {{ $disputes->where('status', 'open')->count() }}
                    </h3>
                    <span class="text-[11px] text-slate-500 font-medium">Funds currently locked in custody</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-lock"></i>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Resolved Cases</span>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1 font-display">
                        {{ $disputes->where('status', 'resolved')->count() }}
                    </h3>
                    <span class="text-[11px] text-slate-500 font-medium">Arbitrated with final settlement</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Arbitration SLA</span>
                    <h3 class="text-2xl font-black text-indigo-600 mt-1 font-display">
                        &lt; 24 Hrs
                    </h3>
                    <span class="text-[11px] text-slate-500 font-medium">Platform guarantee for fair settlements</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-bolt"></i>
                </div>
            </div>
        </div>

        <!-- Disputes Table -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[11px] border-b border-slate-100">
                        <tr>
                            <th class="p-4 rounded-l-2xl">Campaign & Contract</th>
                            <th class="p-4">Disputing Party</th>
                            <th class="p-4">Reason & Description</th>
                            <th class="p-4">Locked Escrow Value</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Date Filed</th>
                            <th class="p-4 rounded-r-2xl text-right">Arbitration Decision</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-sans">
                        @forelse($disputes as $d)
                            @php
                                $disputeData = [
                                    'id' => $d->id,
                                    'campaign_title' => $d->booking->campaign->title ?? ('Contract #' . $d->booking_id),
                                    'brand' => $d->booking->brandProfile->company_name ?? 'Brand',
                                    'creator' => $d->booking->talentProfile->display_name ?? 'Creator',
                                    'opened_by' => $d->openedBy->name ?? 'User',
                                    'reason' => $d->reason,
                                    'description' => $d->description ?: 'No additional notes provided.',
                                    'amount' => number_format($d->booking->total_amount ?? 0),
                                    'status' => $d->status,
                                    'date' => $d->created_at->format('M d, Y • h:i A'),
                                    'action_url' => route('admin.disputes.status', $d->id),
                                ];
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <span class="block font-black text-slate-900 text-sm">{{ $d->booking->campaign->title ?? 'Contract #' . $d->booking_id }}</span>
                                    <div class="text-[11px] text-slate-500 font-medium flex items-center gap-1.5 mt-0.5">
                                        <span class="text-indigo-600 font-bold">{{ $d->booking->brandProfile->company_name ?? 'Brand' }}</span>
                                        <span class="text-slate-300">vs</span>
                                        <span class="text-pink-600 font-bold">{{ $d->booking->talentProfile->display_name ?? 'Talent' }}</span>
                                    </div>
                                </td>
                                <td class="p-4 font-bold text-slate-800">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 text-xs">
                                        <i class="fa-solid fa-user-tag text-[10px] text-slate-500"></i>
                                        <span>{{ $d->openedBy->name ?? 'User' }}</span>
                                    </div>
                                </td>
                                <td class="p-4 max-w-xs">
                                    <span class="font-black text-rose-600 text-xs block">{{ $d->reason }}</span>
                                    <span class="text-slate-500 text-[11px] line-clamp-1 mt-0.5">{{ $d->description ?: 'No additional notes provided' }}</span>
                                </td>
                                <td class="p-4 font-black text-slate-900 tabular-nums text-sm">
                                    ₹{{ number_format($d->booking->total_amount ?? 0) }}
                                    <span class="block text-[10px] text-slate-400 font-normal">Escrow Deposited</span>
                                </td>
                                <td class="p-4">
                                    @if($d->status === 'resolved')
                                        <span class="px-2.5 py-1 rounded-full font-bold uppercase text-[10px] bg-emerald-50 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                            <i class="fa-solid fa-check text-[9px]"></i> Resolved
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full font-bold uppercase text-[10px] bg-rose-50 text-rose-700 border border-rose-200 inline-flex items-center gap-1 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> {{ $d->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-slate-500 tabular-nums">
                                    <span class="font-medium text-slate-700">{{ $d->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="p-4 text-right">
                                    <div class="inline-flex items-center space-x-1.5">
                                        <button type="button" 
                                                @click="openDispute({{ json_encode($disputeData) }})" 
                                                class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition text-xs inline-flex items-center gap-1">
                                            <i class="fa-solid fa-scale-balanced text-xs"></i>
                                            <span>Arbitrate</span>
                                        </button>
                                        @if($d->status !== 'resolved')
                                            <form method="POST" action="{{ route('admin.disputes.status', $d->id) }}" class="inline-flex">
                                                @csrf
                                                <input type="hidden" name="status" value="resolved">
                                                <input type="hidden" name="resolution_decision" value="Escrow verified and released by admin arbitration.">
                                                <button type="submit" class="px-3.5 py-1.5 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl shadow-2xs transition inline-flex items-center gap-1">
                                                    <span>Resolve Case</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-emerald-600 font-bold inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 rounded-xl border border-emerald-100">
                                                <i class="fa-solid fa-circle-check text-xs"></i>
                                                <span>Settled</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-16 text-center text-slate-400">
                                    <div class="w-16 h-16 rounded-3xl bg-slate-50 border border-slate-200/80 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                                        <i class="fa-solid fa-handshake"></i>
                                    </div>
                                    <div class="font-bold text-slate-800 text-base">No active contract disputes</div>
                                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Platform escrow contracts are operating smoothly with 100% mutual sign-off.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($disputes, 'links'))
                <div class="mt-6 border-t border-slate-100 pt-4">
                    {{ $disputes->links() }}
                </div>
            @endif
        </div>

        <!-- Dispute Arbitration Modal -->
        <div x-show="detailModal" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4" 
             x-cloak>
            <div @click.away="detailModal = false" class="bg-white border border-slate-200 rounded-3xl max-w-xl w-full shadow-2xl overflow-hidden flex flex-col">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-rose-600 text-white flex items-center justify-center font-black text-sm">
                            <i class="fa-solid fa-gavel"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900 font-display">Dispute Arbitration Workbench</h3>
                            <p class="text-slate-500 text-xs" x-text="activeDispute ? activeDispute.campaign_title : ''"></p>
                        </div>
                    </div>
                    <button @click="detailModal = false" class="w-8 h-8 rounded-full bg-slate-200/80 hover:bg-slate-300 text-slate-600 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="p-6 space-y-5">
                    <!-- Dispute Overview -->
                    <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 space-y-3">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500 font-bold uppercase text-[10px]">Contracted Parties</span>
                            <span class="font-bold text-slate-800" x-text="activeDispute ? activeDispute.brand + ' ↔ ' + activeDispute.creator : ''"></span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500 font-bold uppercase text-[10px]">Held In Escrow</span>
                            <span class="font-black text-slate-900 text-sm" x-text="'₹' + (activeDispute ? activeDispute.amount : '0')"></span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500 font-bold uppercase text-[10px]">Dispute Reason</span>
                            <span class="font-bold text-rose-600" x-text="activeDispute ? activeDispute.reason : ''"></span>
                        </div>
                        <div class="border-t border-slate-200 pt-2 text-xs">
                            <span class="text-slate-500 font-bold uppercase text-[10px] block mb-1">Claim Statement</span>
                            <p class="text-slate-700 bg-white p-3 rounded-xl border border-slate-200/80 leading-relaxed" x-text="activeDispute ? activeDispute.description : ''"></p>
                        </div>
                    </div>

                    <!-- Resolution Form -->
                    <form method="POST" :action="activeDispute ? activeDispute.action_url : '#'" class="space-y-4">
                        @csrf
                        <input type="hidden" name="status" value="resolved">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Official Arbitration Ruling & Settlement Notes *
                            </label>
                            <textarea name="resolution_decision" 
                                      rows="3" 
                                      required
                                      placeholder="State reason for resolution, escrow disbursement ruling, and mutual settlement terms..."
                                      class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-indigo-600 transition"></textarea>
                        </div>

                        <div class="pt-2 flex items-center justify-between">
                            <button type="button" @click="detailModal = false" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition">
                                Dismiss
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white rounded-xl font-bold text-xs shadow-md transition inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-gavel"></i>
                                <span>Record Final Ruling & Disburse</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
