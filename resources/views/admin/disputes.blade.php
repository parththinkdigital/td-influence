@extends('layouts.admin')

@section('title', 'Dispute Resolution Center | Admin Gateway')

@section('content')
    <div class="space-y-8" x-data="{ resolveModal: false, selectedDispute: null }">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Dispute Resolution Center</h1>
                <p class="text-slate-500 text-sm mt-1">Review disputes regarding requirements, deliverable status, or contract escrow release.</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3.5 py-1.5 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold tabular-nums">
                    {{ $disputes->total() }} Cases Recorded
                </span>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[11px]">
                        <tr>
                            <th class="p-4 rounded-l-xl">Campaign / Booking</th>
                            <th class="p-4">Opened By</th>
                            <th class="p-4">Reason & Description</th>
                            <th class="p-4">Escrow Value</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Date</th>
                            <th class="p-4 rounded-r-xl text-right">Arbitration</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($disputes as $d)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <span class="block font-extrabold text-slate-900">{{ $d->booking->campaign->title ?? 'Contract #' . $d->booking_id }}</span>
                                    <span class="text-[11px] text-slate-400">Brand: {{ $d->booking->brandProfile->company_name ?? 'Brand' }} &bull; Creator: {{ $d->booking->talentProfile->display_name ?? 'Talent' }}</span>
                                </td>
                                <td class="p-4 font-semibold text-slate-800">
                                    {{ $d->openedBy->name ?? 'User' }}
                                </td>
                                <td class="p-4 max-w-xs">
                                    <span class="font-bold text-rose-600 block">{{ $d->reason }}</span>
                                    <span class="text-slate-500 text-[11px] line-clamp-1">{{ $d->description ?: 'No additional notes provided' }}</span>
                                </td>
                                <td class="p-4 font-black text-slate-900 tabular-nums">
                                    ₹{{ number_format($d->booking->total_amount ?? 0) }}
                                </td>
                                <td class="p-4">
                                    @if($d->status === 'resolved')
                                        <span class="px-2.5 py-1 rounded-full font-bold uppercase text-[10px] bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            Resolved
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full font-bold uppercase text-[10px] bg-rose-50 text-rose-700 border border-rose-200 animate-pulse">
                                            {{ $d->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-slate-500 tabular-nums">
                                    {{ $d->created_at->format('M d, Y') }}
                                </td>
                                <td class="p-4 text-right">
                                    @if($d->status !== 'resolved')
                                        <form method="POST" action="{{ route('admin.disputes.status', $d->id) }}" class="inline-flex items-center space-x-1.5">
                                            @csrf
                                            <input type="hidden" name="status" value="resolved">
                                            <input type="hidden" name="resolution_decision" value="Escrow verified and released by admin arbitration.">
                                            <button type="submit" class="px-3 py-1.5 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl shadow-2xs transition">
                                                Resolve & Release
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-emerald-600 font-bold inline-flex items-center gap-1"><i data-lucide="check" class="w-3.5 h-3.5"></i> Decision Final</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-12 text-center text-slate-400">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center mx-auto mb-2">
                                        <i data-lucide="scale" class="w-6 h-6"></i>
                                    </div>
                                    <div class="font-bold text-slate-700">No active disputes reported</div>
                                    <p class="text-xs text-slate-400 mt-1">Platform escrow contracts are operating normally.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($disputes, 'links'))
                <div class="mt-6">
                    {{ $disputes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
