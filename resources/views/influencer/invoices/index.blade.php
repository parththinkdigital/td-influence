@extends('layouts.influencer')

@section('title', 'Invoices & Payout Receipts | Talent Portal')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-3 mb-1">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Invoices & Payout Receipts</h1>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-pink-100 text-pink-800 border border-pink-200">Direct Escrow Settlements</span>
            </div>
            <p class="text-sm text-slate-600">Access official disbursement receipts and statements for all your completed collaborations and brand partnerships.</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="text-xs text-slate-500">Auto-generated upon brand approval</span>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Total Payouts Received</div>
            <div class="text-2xl font-black text-slate-900 tabular-nums">₹{{ number_format($totalEarned, 2) }}</div>
            <div class="text-xs text-slate-500 mt-1">100% of your agreed creator collaboration fees</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Total Completed Disbursements</div>
            <div class="text-2xl font-black text-pink-600 tabular-nums">{{ $invoices->total() }}</div>
            <div class="text-xs text-slate-500 mt-1">Disbursed directly from platform escrow</div>
        </div>
    </div>

    <!-- Invoices Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">Payout Statements</h2>
            <span class="text-xs text-slate-500">Showing {{ $invoices->count() }} of {{ $invoices->total() }} receipts</span>
        </div>

        @if($invoices->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-slate-50/75 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">Receipt #</th>
                            <th class="px-6 py-3.5">Campaign & Client</th>
                            <th class="px-6 py-3.5 text-right">Agreed Creator Fee</th>
                            <th class="px-6 py-3.5 text-right">Disbursed Amount</th>
                            <th class="px-6 py-3.5 text-center">Status</th>
                            <th class="px-6 py-3.5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($invoices as $inv)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-slate-900 whitespace-nowrap">
                                    <a href="{{ route('influencer.invoices.show', $inv->id) }}" class="text-pink-600 hover:underline">
                                        {{ $inv->invoice_number }}
                                    </a>
                                    <div class="text-[11px] font-normal text-slate-400 mt-0.5">
                                        {{ $inv->issued_at ? $inv->issued_at->format('d M, Y') : $inv->created_at->format('d M, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 truncate max-w-xs">
                                        {{ $inv->booking->campaign->title ?? 'Direct Collaboration' }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        Client: {{ $inv->brandProfile->company_name ?? 'Brand Partner' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right tabular-nums text-slate-700 font-medium">
                                    ₹{{ number_format($inv->subtotal_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right tabular-nums font-black text-emerald-600">
                                    ₹{{ number_format($inv->grand_total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Disbursed
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('influencer.invoices.show', $inv->id) }}" class="inline-flex items-center space-x-1 px-3 py-1.5 bg-slate-100 hover:bg-pink-50 text-slate-700 hover:text-pink-700 font-semibold rounded-lg text-xs transition-colors border border-slate-200 hover:border-pink-200">
                                        <span>View Receipt</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-slate-100">
                {{ $invoices->links() }}
            </div>
        @else
            <div class="py-16 text-center">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4 text-slate-400 text-xl font-bold">
                    <i data-lucide="receipt" class="w-6 h-6 text-slate-400"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1">No Payout Receipts Yet</h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto mb-6">When brands approve your submitted deliverables and release the escrow, your disbursement receipts will appear here.</p>
                <a href="{{ route('influencer.bookings') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition">
                    View Active Bookings
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
