@extends('layouts.influencer')

@section('title', 'Payout Receipt ' . $invoice->invoice_number . ' | Talent Portal')

@section('content')
<style>
@media print {
    body {
        background: white !important;
        color: black !important;
    }
    aside, header, .no-print {
        display: none !important;
    }
    main {
        padding: 0 !important;
        max-width: 100% !important;
        margin: 0 !important;
    }
    .print-container {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
}
</style>

<div class="max-w-4xl mx-auto space-y-6">
    <!-- Top Action Bar (hidden on print) -->
    <div class="no-print flex items-center justify-between">
        <a href="{{ route('influencer.invoices') }}" class="inline-flex items-center space-x-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to Payout Receipts</span>
        </a>
        <div class="flex items-center space-x-3">
            <button onclick="window.print()" class="inline-flex items-center space-x-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Print / Download PDF</span>
            </button>
        </div>
    </div>

    <!-- Receipt Sheet -->
    <div class="print-container bg-white border border-slate-200 rounded-2xl p-8 sm:p-12 shadow-xs space-y-8">
        <!-- Receipt Header -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 pb-8 border-b border-slate-200">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-pink-600 flex items-center justify-center font-black text-white text-lg tracking-tight">
                        TM
                    </div>
                    <div>
                        <div class="text-xl font-black tracking-tight text-slate-900">Talent Marketplace</div>
                        <div class="text-xs text-slate-500 font-medium">Creator Disbursement Settlement</div>
                    </div>
                </div>
                <div class="text-xs text-slate-500 leading-relaxed mt-3">
                    Nashik IT Park, Mumbai-Agra Highway<br>
                    Maharashtra, India - 422009<br>
                    <span class="font-semibold text-slate-700">Platform GSTIN:</span> 27AAAAA0000A1Z5<br>
                    <span class="font-semibold text-slate-700">Disbursement Desk:</span> payouts@talentmarketplace.com
                </div>
            </div>

            <div class="sm:text-right">
                <div class="inline-block px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider bg-pink-100 text-pink-800 border border-pink-200 mb-2">
                    PAYOUT RECEIPT
                </div>
                <div class="text-2xl font-black text-slate-900 font-mono tracking-tight">{{ $invoice->invoice_number }}</div>
                <div class="text-xs text-slate-500 mt-1">
                    <span class="font-semibold text-slate-700">Disbursed Date:</span> {{ $invoice->issued_at ? $invoice->issued_at->format('d F Y') : $invoice->created_at->format('d F Y') }}
                </div>
                <div class="text-xs text-slate-500">
                    <span class="font-semibold text-slate-700">Disbursement Status:</span> <span class="text-emerald-600 font-bold uppercase">PAID & SETTLED</span>
                </div>
            </div>
        </div>

        <!-- Beneficiary & Client Details -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 py-2">
            <!-- Beneficiary (Creator) -->
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Paid To (Beneficiary Creator):</div>
                <div class="text-base font-black text-slate-900">{{ $invoice->talent_details['creator_name'] ?? ($invoice->talentProfile->display_name ?? 'Creator') }}</div>
                <div class="text-xs text-slate-600 mt-1 leading-relaxed">
                    <span class="font-semibold">Handle:</span> &#64;{{ $invoice->talent_details['username'] ?? ($invoice->talentProfile->username ?? 'creator') }}<br>
                    <span class="font-semibold">Email:</span> {{ $invoice->talent_details['email'] ?? ($invoice->talentProfile->user->email ?? '') }}<br>
                    <span class="font-semibold">City / State:</span> {{ $invoice->talent_details['city'] ?? 'Nashik' }}, {{ $invoice->talent_details['state'] ?? 'Maharashtra' }}
                </div>
            </div>

            <!-- Client / Campaign Source -->
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Funded By (Brand Client):</div>
                <div class="text-base font-black text-slate-900">{{ $invoice->billing_details['company_name'] ?? ($invoice->brandProfile->company_name ?? 'Brand Partner') }}</div>
                <div class="text-xs text-slate-600 mt-1 leading-relaxed">
                    <span class="font-semibold">Campaign:</span> {{ $invoice->booking->campaign->title ?? 'Direct Collaboration' }}<br>
                    <span class="font-semibold">Booking Reference:</span> #BOOK-{{ $invoice->booking->id }}<br>
                    <span class="font-semibold">Settlement Mechanism:</span> Escrow Fund Release
                </div>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b-2 border-slate-900 text-slate-900 font-bold text-xs uppercase">
                        <th class="py-3 px-2">#</th>
                        <th class="py-3 px-2">Description of Deliverable</th>
                        <th class="py-3 px-2">SAC</th>
                        <th class="py-3 px-2 text-right">Agreed Fee</th>
                        <th class="py-3 px-2 text-right">Platform Deduction</th>
                        <th class="py-3 px-2 text-right">Net Payout (INR)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-700">
                    <tr>
                        <td class="py-4 px-2 font-mono text-xs">01</td>
                        <td class="py-4 px-2">
                            <div class="font-bold text-slate-900">{{ $invoice->booking->campaign->title ?? 'Influencer Deliverable Production' }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">Approved sponsored creative output & licensed commercial usage.</div>
                        </td>
                        <td class="py-4 px-2 font-mono text-xs text-slate-500">{{ $invoice->hsn_sac_code }}</td>
                        <td class="py-4 px-2 text-right tabular-nums">₹{{ number_format($invoice->subtotal_amount, 2) }}</td>
                        <td class="py-4 px-2 text-right text-xs text-emerald-600 font-bold">₹0.00 (0%)</td>
                        <td class="py-4 px-2 text-right tabular-nums font-black text-emerald-600">₹{{ number_format($invoice->grand_total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Calculation Summary Box -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 pt-4 border-t border-slate-200">
            <div class="text-xs text-slate-500 space-y-2 max-w-sm">
                <div class="font-bold text-slate-700">Payment & Tax Notes:</div>
                <p>• 100% of the gross agreed fee was disbursed to your designated bank account with zero creator-side platform commissions.</p>
                <p>• Retain this receipt for your professional annual tax return (ITR-3/ITR-4 Section 44ADA).</p>
            </div>

            <div class="w-full sm:w-80 space-y-2 text-sm">
                <div class="flex justify-between py-1 text-slate-600">
                    <span>Agreed Creator Fee:</span>
                    <span class="tabular-nums font-medium">₹{{ number_format($invoice->subtotal_amount, 2) }}</span>
                </div>
                <div class="flex justify-between py-1 text-slate-600">
                    <span>Creator Service Commission:</span>
                    <span class="tabular-nums font-medium text-emerald-600">₹0.00</span>
                </div>
                <div class="flex justify-between py-2 text-base font-black text-slate-900 border-t-2 border-slate-900">
                    <span>Net Disbursed Amount:</span>
                    <span class="tabular-nums text-emerald-600">₹{{ number_format($invoice->grand_total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Notice & Signature -->
        <div class="pt-8 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 text-xs text-slate-500">
            <div>
                <div class="font-bold text-slate-700">Platform Escrow Transfer Statement</div>
                <div>Funds settled directly via Talent Marketplace Automated Escrow Engine.</div>
            </div>
            <div class="sm:text-right">
                <div class="font-serif italic font-bold text-slate-800 text-sm">Talent Marketplace Ltd.</div>
                <div class="text-[11px] text-slate-400">Finance & Disbursements Officer</div>
            </div>
        </div>
    </div>
</div>
@endsection
