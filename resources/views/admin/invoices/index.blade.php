@extends('layouts.admin')

@section('title', 'Platform Tax Ledger & Invoices | Admin Portal')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-3 mb-1">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Platform Tax Ledger & Invoices</h1>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-200">GST Compliance Hub</span>
            </div>
            <p class="text-sm text-slate-600">Centralized audit trail of all generated Brand GST Tax Invoices and Creator Payout Receipts.</p>
        </div>
    </div>

    <!-- Financial KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Gross Invoiced Volume (GMV)</div>
            <div class="text-2xl font-black text-slate-900 tabular-nums">₹{{ number_format($totalBilled, 2) }}</div>
            <div class="text-xs text-slate-500 mt-1">Total brand invoiced billings</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Total GST Collected</div>
            <div class="text-2xl font-black text-indigo-600 tabular-nums">₹{{ number_format($totalGstCollected, 2) }}</div>
            <div class="text-xs text-slate-500 mt-1">CGST + SGST + IGST liability</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Total Disbursed to Creators</div>
            <div class="text-2xl font-black text-emerald-600 tabular-nums">₹{{ number_format($totalPaidOut, 2) }}</div>
            <div class="text-xs text-slate-500 mt-1">Direct net talent settlements</div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('admin.invoices') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Search Reference</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Invoice #, Brand or Creator..." class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:border-red-500 focus:ring-1 focus:ring-red-500">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Document Type</label>
                <select name="type" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:border-red-500 focus:ring-1 focus:ring-red-500">
                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Documents</option>
                    <option value="brand_tax_invoice" {{ request('type') == 'brand_tax_invoice' ? 'selected' : '' }}>Brand Tax Invoices</option>
                    <option value="creator_payout_receipt" {{ request('type') == 'creator_payout_receipt' ? 'selected' : '' }}>Creator Payout Receipts</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="w-full px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-xs transition">
                    Filter Ledger
                </button>
                @if(request()->hasAny(['search', 'type']))
                    <a href="{{ route('admin.invoices') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">Audit Ledger</h2>
            <span class="text-xs text-slate-500">Showing {{ $invoices->count() }} of {{ $invoices->total() }} records</span>
        </div>

        @if($invoices->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-slate-50/75 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">Invoice #</th>
                            <th class="px-6 py-3.5">Type</th>
                            <th class="px-6 py-3.5">Brand Client</th>
                            <th class="px-6 py-3.5">Talent Creator</th>
                            <th class="px-6 py-3.5 text-right">Taxable</th>
                            <th class="px-6 py-3.5 text-right">Tax (GST)</th>
                            <th class="px-6 py-3.5 text-right">Total (INR)</th>
                            <th class="px-6 py-3.5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($invoices as $inv)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-slate-900 whitespace-nowrap">
                                    <a href="{{ route('admin.invoices.show', $inv->id) }}" class="text-indigo-600 hover:underline">
                                        {{ $inv->invoice_number }}
                                    </a>
                                    <div class="text-[11px] font-normal text-slate-400 mt-0.5">
                                        {{ $inv->issued_at ? $inv->issued_at->format('d M, Y') : $inv->created_at->format('d M, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($inv->invoice_type === 'brand_tax_invoice')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            Tax Invoice
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-pink-50 text-pink-700 border border-pink-200">
                                            Payout Receipt
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 truncate max-w-xs">
                                        {{ $inv->brandProfile->company_name ?? 'Brand Partner' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900 truncate max-w-xs">
                                        {{ $inv->talentProfile->display_name ?? 'Talent Creator' }}
                                    </div>
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
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.invoices.show', $inv->id) }}" class="inline-flex items-center space-x-1 px-3 py-1.5 bg-slate-100 hover:bg-indigo-50 text-slate-700 hover:text-indigo-700 font-semibold rounded-lg text-xs transition-colors border border-slate-200 hover:border-indigo-200">
                                        <span>Audit</span>
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
                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <i data-lucide="receipt" class="w-6 h-6"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1">No Invoice Records Found</h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto">No invoices match your current search criteria.</p>
            </div>
        @endif
    </div>
</div>
@endsection
