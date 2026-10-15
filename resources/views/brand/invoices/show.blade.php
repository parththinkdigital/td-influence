@extends('layouts.brand')

@section('title', 'Tax Invoice ' . $invoice->invoice_number . ' | Brand Studio')

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
        <a href="{{ route('brand.invoices') }}" class="inline-flex items-center space-x-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to Invoices</span>
        </a>
        <div class="flex items-center space-x-3">
            <button onclick="window.print()" class="inline-flex items-center space-x-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Print / Download PDF</span>
            </button>
        </div>
    </div>

    <!-- Invoice Sheet -->
    <div class="print-container bg-white border border-slate-200 rounded-2xl p-8 sm:p-12 shadow-xs space-y-8">
        <!-- Invoice Header -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 pb-8 border-b border-slate-200">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center font-black text-white text-lg tracking-tight">
                        TM
                    </div>
                    <div>
                        <div class="text-xl font-black tracking-tight text-slate-900">Talent Marketplace</div>
                        <div class="text-xs text-slate-500 font-medium">Digital Influencer & Creator Platform</div>
                    </div>
                </div>
                <div class="text-xs text-slate-500 leading-relaxed mt-3">
                    Nashik IT Park, Mumbai-Agra Highway<br>
                    Maharashtra, India - 422009<br>
                    <span class="font-semibold text-slate-700">GSTIN:</span> 27AAAAA0000A1Z5 | <span class="font-semibold text-slate-700">PAN:</span> AAAAA0000A<br>
                    <span class="font-semibold text-slate-700">Support:</span> billing@talentmarketplace.com
                </div>
            </div>

            <div class="sm:text-right">
                <div class="inline-block px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200 mb-2">
                    TAX INVOICE
                </div>
                <div class="text-2xl font-black text-slate-900 font-mono tracking-tight">{{ $invoice->invoice_number }}</div>
                <div class="text-xs text-slate-500 mt-1">
                    <span class="font-semibold text-slate-700">Date Issued:</span> {{ $invoice->issued_at ? $invoice->issued_at->format('d F Y') : $invoice->created_at->format('d F Y') }}
                </div>
                <div class="text-xs text-slate-500">
                    <span class="font-semibold text-slate-700">Payment Status:</span> <span class="text-emerald-600 font-bold uppercase">{{ $invoice->status }}</span>
                </div>
                <div class="text-xs text-slate-500">
                    <span class="font-semibold text-slate-700">SAC Code:</span> {{ $invoice->hsn_sac_code }} (Advertising Services)
                </div>
            </div>
        </div>

        <!-- Party Details (Bill To / Talent) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 py-2">
            <!-- Billed To (Client) -->
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Billed To (Client):</div>
                <div class="text-base font-black text-slate-900">{{ $invoice->billing_details['company_name'] ?? ($invoice->brandProfile->company_name ?? 'Brand Client') }}</div>
                <div class="text-xs text-slate-600 mt-1 leading-relaxed">
                    @if(!empty($invoice->billing_details['contact_person']))
                        <span class="font-semibold">Attn:</span> {{ $invoice->billing_details['contact_person'] }}<br>
                    @endif
                    <span class="font-semibold">Email:</span> {{ $invoice->billing_details['email'] ?? ($invoice->brandProfile->user->email ?? '') }}<br>
                    <span class="font-semibold">GSTIN/PAN:</span> {{ $invoice->billing_details['gstin'] ?? ($invoice->brandProfile->gstin_pan ?? 'Unregistered / Consumer') }}<br>
                    <span class="font-semibold">Place of Supply:</span> {{ $invoice->billing_details['state'] ?? 'Maharashtra' }} (State Code: {{ $invoice->billing_details['state_code'] ?? '27' }})
                </div>
            </div>

            <!-- Service Details (Talent Partner) -->
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Service Executed By:</div>
                <div class="text-base font-black text-slate-900">{{ $invoice->talent_details['creator_name'] ?? ($invoice->talentProfile->display_name ?? 'Creator') }}</div>
                <div class="text-xs text-slate-600 mt-1 leading-relaxed">
                    <span class="font-semibold">Creator Handle:</span> &#64;{{ $invoice->talent_details['username'] ?? ($invoice->talentProfile->username ?? 'talent') }}<br>
                    <span class="font-semibold">Location:</span> {{ $invoice->talent_details['city'] ?? ($invoice->talentProfile->city ?? 'Nashik') }}, {{ $invoice->talent_details['state'] ?? ($invoice->talentProfile->state ?? 'Maharashtra') }}<br>
                    <span class="font-semibold">Campaign ID:</span> #{{ $invoice->booking->campaign_id }} &mdash; {{ $invoice->booking->campaign->title ?? 'Direct Collaboration' }}<br>
                    <span class="font-semibold">Escrow Release ID:</span> #ESCROW-{{ $invoice->booking->id }}
                </div>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b-2 border-slate-900 text-slate-900 font-bold text-xs uppercase">
                        <th class="py-3 px-2">#</th>
                        <th class="py-3 px-2">Description of Services</th>
                        <th class="py-3 px-2">SAC</th>
                        <th class="py-3 px-2 text-right">Taxable Base</th>
                        <th class="py-3 px-2 text-right">Rate</th>
                        <th class="py-3 px-2 text-right">Amount (INR)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-700">
                    <tr>
                        <td class="py-4 px-2 font-mono text-xs">01</td>
                        <td class="py-4 px-2">
                            <div class="font-bold text-slate-900">{{ $invoice->booking->campaign->title ?? 'Creator Marketing Campaign' }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">Influencer content creation, deliverable production, and licensed commercial usage.</div>
                        </td>
                        <td class="py-4 px-2 font-mono text-xs text-slate-500">{{ $invoice->hsn_sac_code }}</td>
                        <td class="py-4 px-2 text-right tabular-nums">₹{{ number_format($invoice->subtotal_amount, 2) }}</td>
                        <td class="py-4 px-2 text-right text-xs">1.00</td>
                        <td class="py-4 px-2 text-right tabular-nums font-semibold text-slate-900">₹{{ number_format($invoice->subtotal_amount, 2) }}</td>
                    </tr>
                    @if($invoice->platform_fee_amount > 0)
                    <tr>
                        <td class="py-4 px-2 font-mono text-xs">02</td>
                        <td class="py-4 px-2">
                            <div class="font-bold text-slate-900">Platform Technology & Escrow Facilitation Fee</div>
                            <div class="text-xs text-slate-500 mt-0.5">Secure payment processing, dispute arbitration, and verification infrastructure.</div>
                        </td>
                        <td class="py-4 px-2 font-mono text-xs text-slate-500">{{ $invoice->hsn_sac_code }}</td>
                        <td class="py-4 px-2 text-right tabular-nums">₹{{ number_format($invoice->platform_fee_amount, 2) }}</td>
                        <td class="py-4 px-2 text-right text-xs">10.00%</td>
                        <td class="py-4 px-2 text-right tabular-nums font-semibold text-slate-900">₹{{ number_format($invoice->platform_fee_amount, 2) }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Calculation Summary Box -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 pt-4 border-t border-slate-200">
            <div class="text-xs text-slate-500 space-y-2 max-w-sm">
                <div class="font-bold text-slate-700">Tax Breakdown & Notes:</div>
                <p>
                    @if($invoice->tax_type === 'cgst_sgst')
                        • Intra-state supply within Maharashtra: CGST @ 9.00% (₹{{ number_format($invoice->cgst_amount, 2) }}) + SGST @ 9.00% (₹{{ number_format($invoice->sgst_amount, 2) }}).
                    @elseif($invoice->tax_type === 'igst')
                        • Inter-state supply outside Maharashtra: IGST @ 18.00% (₹{{ number_format($invoice->igst_amount, 2) }}).
                    @else
                        • GST Exemption / Not Applicable.
                    @endif
                </p>
                <p class="italic">Whether tax is payable on reverse charge basis: <strong>No</strong></p>
            </div>

            <div class="w-full sm:w-80 space-y-2 text-sm">
                <div class="flex justify-between py-1 text-slate-600">
                    <span>Taxable Base Value:</span>
                    <span class="tabular-nums font-medium">₹{{ number_format($invoice->taxable_amount, 2) }}</span>
                </div>
                @if($invoice->tax_type === 'cgst_sgst')
                    <div class="flex justify-between py-1 text-slate-600">
                        <span>Central GST (CGST 9%):</span>
                        <span class="tabular-nums font-medium">₹{{ number_format($invoice->cgst_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-1 text-slate-600">
                        <span>State GST (SGST 9%):</span>
                        <span class="tabular-nums font-medium">₹{{ number_format($invoice->sgst_amount, 2) }}</span>
                    </div>
                @elseif($invoice->tax_type === 'igst')
                    <div class="flex justify-between py-1 text-slate-600">
                        <span>Integrated GST (IGST 18%):</span>
                        <span class="tabular-nums font-medium">₹{{ number_format($invoice->igst_amount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between py-1 text-slate-600 border-t border-slate-200">
                    <span>Total Tax:</span>
                    <span class="tabular-nums font-medium">₹{{ number_format($invoice->total_tax_amount, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 text-base font-black text-slate-900 border-t-2 border-slate-900">
                    <span>Grand Total (INR):</span>
                    <span class="tabular-nums">₹{{ number_format($invoice->grand_total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Notice & Signature -->
        <div class="pt-8 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 text-xs text-slate-500">
            <div>
                <div class="font-bold text-slate-700">Digital Tax Invoice & Escrow Settlement</div>
                <div>This is a system-generated electronic tax invoice certified under Section 31 of CGST Act, 2017.</div>
            </div>
            <div class="sm:text-right">
                <div class="font-serif italic font-bold text-slate-800 text-sm">Talent Marketplace Ltd.</div>
                <div class="text-[11px] text-slate-400">Authorized Signatory</div>
            </div>
        </div>
    </div>
</div>
@endsection
