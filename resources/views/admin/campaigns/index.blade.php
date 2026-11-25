@extends('layouts.admin')

@section('title', 'Manage Campaigns | Admin Gateway')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    <span>Campaign Pipeline Governance</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Campaign Moderation & Status</h1>
                <p class="text-slate-500 text-sm mt-1">Review brand campaign briefs, deliverable requirements, budget allocation, and publishing status.</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-4 py-2 rounded-2xl bg-white border border-slate-200/80 text-slate-700 text-xs font-bold shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-briefcase text-indigo-500"></i>
                    <span>{{ $campaigns->total() }} Campaigns Total</span>
                </span>
            </div>
        </div>

        <!-- Campaigns Table -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[11px] border-b border-slate-100">
                        <tr>
                            <th class="p-4 rounded-l-2xl">Campaign Brief</th>
                            <th class="p-4">Brand Client</th>
                            <th class="p-4">Vertical Category</th>
                            <th class="p-4">Target Budget</th>
                            <th class="p-4">Current Status</th>
                            <th class="p-4 rounded-r-2xl text-right">Moderation Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-sans">
                        @forelse($campaigns as $camp)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <span class="block font-black text-slate-900 text-sm">{{ $camp->title ?: $camp->name }}</span>
                                    <span class="text-[11px] text-slate-400 font-mono">ID: #{{ $camp->id }} • {{ $camp->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="p-4 font-bold text-slate-800">
                                    <span class="px-2.5 py-1 rounded-xl bg-slate-100 text-slate-800 inline-block">
                                        {{ $camp->brandProfile->company_name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-lg text-[10px] font-extrabold uppercase tracking-wider">
                                        {{ $camp->category->name ?? 'General' }}
                                    </span>
                                </td>
                                <td class="p-4 font-black text-slate-900 tabular-nums text-sm">
                                    ₹{{ number_format($camp->budget) }}
                                </td>
                                <td class="p-4">
                                    @if($camp->status === 'published')
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full text-[10px] font-bold uppercase inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                                        </span>
                                    @elseif($camp->status === 'pending_review')
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-full text-[10px] font-bold uppercase inline-flex items-center gap-1 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Review
                                        </span>
                                    @elseif($camp->status === 'paused')
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 border border-slate-200 rounded-full text-[10px] font-bold uppercase">
                                            Paused
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-[10px] font-bold uppercase">
                                            {{ ucfirst($camp->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <form method="POST" action="{{ route('admin.campaigns.status', $camp->id) }}" class="inline-flex">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="bg-slate-50 hover:bg-slate-100 border border-slate-300 rounded-xl px-3 py-1.5 text-xs text-slate-900 font-bold focus:outline-none focus:ring-2 focus:ring-slate-900 transition">
                                            <option value="published" {{ $camp->status == 'published' ? 'selected' : '' }}>Published (Active)</option>
                                            <option value="pending_review" {{ $camp->status == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                                            <option value="paused" {{ $camp->status == 'paused' ? 'selected' : '' }}>Paused</option>
                                            <option value="completed" {{ $camp->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $camp->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-16 text-center text-slate-400">
                                    <div class="w-16 h-16 rounded-3xl bg-slate-50 border border-slate-200/80 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                                        <i class="fa-solid fa-briefcase"></i>
                                    </div>
                                    <div class="font-bold text-slate-800 text-base">No campaigns found</div>
                                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Brand campaign submissions will appear here for governance and publishing.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($campaigns, 'links'))
                <div class="mt-6 border-t border-slate-100 pt-4">
                    {{ $campaigns->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
