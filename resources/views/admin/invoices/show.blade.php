@extends('layouts.admin')

@section('title', 'Audit Invoice ' . $invoice->invoice_number . ' | Admin Portal')

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
        <a href="{{ route('admin.invoices') }}" class="inline-flex items-center space-x-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to Tax Ledger</span>
        </a>
        <div class="flex items-center space-x-3">
            <button onclick="window.print()" class="inline-flex items-center space-x-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Print Official Copy</span>
            </button>
        </div>
    </div>

    <!-- Invoice Sheet -->
    <div class="print-container bg-white border border-slate-200 rounded-2xl p-8 sm:p-12 shadow-xs space-y-8">
        <!-- Invoice Header -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 pb-8 border-b border-slate-200">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center font-black text-white text-lg tracking-tight">
                        TM
                    </div>
                    <div>
                        <div class="text-xl font-black tracking-tight text-slate-900">Talent Marketplace Ltd.</div>
                        <div class="text-xs text-slate-500 font-medium">GST Compliance & Tax Ledger Record</div>
                    </div>
                </div>
                <div class="text-xs text-slate-500 leading-relaxed mt-3">
                    Nashik IT Park, Mumbai-Agra Highway<br>
                    Maharashtra, India - 422009<br>
                    <span class="font-semibold text-slate-700">Platform GSTIN:</span> 27AAAAA0000A1Z5 | <span class="font-semibold text-slate-700">SAC:</span> {{ $invoice->hsn_sac_code }}
                </div>
            </div>

            <div class="sm:text-right">
                <div class="inline-block px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider {{ $invoice->invoice_type === 'brand_tax_invoice' ? 'bg-indigo-100 text-indigo-800 border border-indigo-200' : 'bg-pink-100 text-pink-800 border border-pink-200' }} mb-2">
                    {{ $invoice->invoice_type === 'brand_tax_invoice' ? 'BRAND TAX INVOICE' : 'CREATOR PAYOUT RECEIPT' }}
                </div>
                <div class="text-2xl font-black text-slate-900 font-mono tracking-tight">{{ $invoice->invoice_number }}</div>
                <div class="text-xs text-slate-500 mt-1">
                    <span class="font-semibold text-slate-700">Issued Date:</span> {{ $invoice->issued_at ? $invoice->issued_at->format('d F Y') : $invoice->created_at->format('d F Y') }}
                </div>
                <div class="text-xs text-slate-500">
                    <span class="font-semibold text-slate-700">Booking Ref:</span> #BOOKING-{{ $invoice->booking_id }}
                </div>
            </div>
        </div>

        <!-- Parties Details -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 py-2">
            <!-- Brand Details -->
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Brand Client Entity:</div>
                <div class="text-base font-black text-slate-900">{{ $invoice->billing_details['company_name'] ?? ($invoice->brandProfile->company_name ?? 'Brand Client') }}</div>
                <div class="text-xs text-slate-600 mt-1 leading-relaxed">
                    <span class="font-semibold">User:</span> {{ $invoice->brandProfile->user->name ?? '' }} ({{ $invoice->brandProfile->user->email ?? '' }})<br>
                    <span class="font-semibold">GSTIN/PAN:</span> {{ $invoice->billing_details['gstin'] ?? 'Unregistered' }}<br>
                    <span class="font-semibold">Place of Supply:</span> {{ $invoice->billing_details['state'] ?? 'Maharashtra' }}
                </div>
            </div>

            <!-- Creator Details -->
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Talent / Creator:</div>
                <div class="text-base font-black text-slate-900">{{ $invoice->talent_details['creator_name'] ?? ($invoice->talentProfile->display_name ?? 'Talent Creator') }}</div>
                <div class="text-xs text-slate-600 mt-1 leading-relaxed">
                    <span class="font-semibold">Handle:</span> &#64;{{ $invoice->talent_details['username'] ?? ($invoice->talentProfile->username ?? 'talent') }}<br>
                    <span class="font-semibold">Email:</span> {{ $invoice->talent_details['email'] ?? ($invoice->talentProfile->user->email ?? '') }}<br>
                    <span class="font-semibold">Location:</span> {{ $invoice->talent_details['city'] ?? 'Nashik' }}, {{ $invoice->talent_details['state'] ?? 'Maharashtra' }}
                </div>
            </div>
        </div>

        <!-- Line Items -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b-2 border-slate-900 text-slate-900 font-bold text-xs uppercase">
                        <th class="py-3 px-2">Description</th>
                        <th class="py-3 px-2">SAC</th>
                        <th class="py-3 px-2 text-right">Taxable Base</th>
                        <th class="py-3 px-2 text-right">Tax Rate</th>
                        <th class="py-3 px-2 text-right">Total (INR)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-700">
                    <tr>
                        <td class="py-4 px-2">
                            <div class="font-bold text-slate-900">{{ $invoice->booking->campaign->title ?? 'Campaign Milestone' }}</div>
                            <div class="text-xs text-slate-500">Agreed commercial deliverable & social license rights</div>
                        </td>
                        <td class="py-4 px-2 font-mono text-xs">{{ $invoice->hsn_sac_code }}</td>
                        <td class="py-4 px-2 text-right tabular-nums">₹{{ number_format($invoice->subtotal_amount, 2) }}</td>
                        <td class="py-4 px-2 text-right text-xs">{{ $invoice->tax_type === 'cgst_sgst' ? '18% (9+9)' : ($invoice->tax_type === 'igst' ? '18%' : '0%') }}</td>
                        <td class="py-4 px-2 text-right tabular-nums font-bold text-slate-900">₹{{ number_format($invoice->subtotal_amount, 2) }}</td>
                    </tr>
                    @if($invoice->platform_fee_amount > 0)
                    <tr>
                        <td class="py-4 px-2">
                            <div class="font-bold text-slate-900">Platform Technology & Escrow Fee</div>
                            <div class="text-xs text-slate-500">Escrow verification and marketplace fee</div>
                        </td>
                        <td class="py-4 px-2 font-mono text-xs">{{ $invoice->hsn_sac_code }}</td>
                        <td class="py-4 px-2 text-right tabular-nums">₹{{ number_format($invoice->platform_fee_amount, 2) }}</td>
                        <td class="py-4 px-2 text-right text-xs">18%</td>
                        <td class="py-4 px-2 text-right tabular-nums font-bold text-slate-900">₹{{ number_format($invoice->platform_fee_amount, 2) }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 pt-4 border-t border-slate-200">
            <div class="text-xs text-slate-500 space-y-1">
                <div class="font-bold text-slate-700">Tax Type: {{ strtoupper($invoice->tax_type) }}</div>
                <div>CGST: ₹{{ number_format($invoice->cgst_amount, 2) }}</div>
                <div>SGST: ₹{{ number_format($invoice->sgst_amount, 2) }}</div>
                <div>IGST: ₹{{ number_format($invoice->igst_amount, 2) }}</div>
            </div>

            <div class="w-full sm:w-80 space-y-2 text-sm">
                <div class="flex justify-between py-1 text-slate-600">
                    <span>Taxable Base:</span>
                    <span class="tabular-nums font-medium">₹{{ number_format($invoice->taxable_amount, 2) }}</span>
                </div>
                <div class="flex justify-between py-1 text-slate-600">
                    <span>Total Tax (GST):</span>
                    <span class="tabular-nums font-medium">₹{{ number_format($invoice->total_tax_amount, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 text-base font-black text-slate-900 border-t-2 border-slate-900">
                    <span>Grand Total:</span>
                    <span class="tabular-nums">₹{{ number_format($invoice->grand_total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
