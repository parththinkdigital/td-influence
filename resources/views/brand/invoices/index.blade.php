@extends('layouts.brand')

@section('title', 'Tax Invoices & Billing | Brand Studio')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-3 mb-1">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tax Invoices & Financial Ledger</h1>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">GST Compliant (SAC 998365)</span>
            </div>
            <p class="text-sm text-slate-600">Download and inspect official GST-compliant tax invoices for all completed collaborations and escrow disbursements.</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="text-xs text-slate-500">Auto-generated upon milestone completion</span>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Total Amount Invoiced</div>
            <div class="text-2xl font-black text-slate-900 tabular-nums">₹{{ number_format($totalSpent, 2) }}</div>
            <div class="text-xs text-slate-500 mt-1">Across all completed talent bookings</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Total GST (Input Tax Credit)</div>
            <div class="text-2xl font-black text-indigo-600 tabular-nums">₹{{ number_format($totalTaxPaid, 2) }}</div>
            <div class="text-xs text-slate-500 mt-1">18% GST (CGST/SGST or IGST)</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Total Invoices</div>
            <div class="text-2xl font-black text-slate-900 tabular-nums">{{ $invoices->total() }}</div>
            <div class="text-xs text-slate-500 mt-1">Issued & fully settled</div>
        </div>
    </div>

    <!-- Invoices Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">Invoices & Statements</h2>
            <span class="text-xs text-slate-500">Showing {{ $invoices->count() }} of {{ $invoices->total() }} records</span>
        </div>

        @if($invoices->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-slate-50/75 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">Invoice #</th>
                            <th class="px-6 py-3.5">Campaign & Talent</th>
                            <th class="px-6 py-3.5">Tax Type</th>
                            <th class="px-6 py-3.5 text-right">Taxable Base</th>
                            <th class="px-6 py-3.5 text-right">Tax Amount</th>
                            <th class="px-6 py-3.5 text-right">Grand Total</th>
                            <th class="px-6 py-3.5 text-center">Status</th>
                            <th class="px-6 py-3.5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($invoices as $inv)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-slate-900 whitespace-nowrap">
                                    <a href="{{ route('brand.invoices.show', $inv->id) }}" class="text-sky-600 hover:underline">
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
                                        Talent: {{ $inv->talentProfile->display_name ?? 'Creator' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($inv->tax_type === 'cgst_sgst')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            CGST 9% + SGST 9%
                                        </span>
                                    @elseif($inv->tax_type === 'igst')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                            IGST 18%
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-700">
                                            Exempt
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right tabular-nums text-slate-700 font-medium">
                                    ₹{{ number_format($inv->taxable_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right tabular-nums text-slate-700 font-medium">
                                    ₹{{ number_format($inv->total_tax_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right tabular-nums font-black text-slate-900">
                                    ₹{{ number_format($inv->grand_total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Paid
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('brand.invoices.show', $inv->id) }}" class="inline-flex items-center space-x-1 px-3 py-1.5 bg-slate-100 hover:bg-sky-50 text-slate-700 hover:text-sky-700 font-semibold rounded-lg text-xs transition-colors border border-slate-200 hover:border-sky-200">
                                        <span>View Invoice</span>
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
                <h3 class="text-base font-bold text-slate-900 mb-1">No Invoices Generated Yet</h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto mb-6">Tax invoices are automatically created with full GST breakdown whenever you approve deliverables and release escrow to a creator.</p>
                <a href="{{ route('brand.bookings') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition">
                    View Hired Bookings
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
