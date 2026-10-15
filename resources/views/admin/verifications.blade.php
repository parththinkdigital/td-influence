@extends('layouts.admin')

@section('title', 'Verification Queue | Admin Gateway')

@section('content')
    <div class="space-y-8" x-data="{ inspectModal: false, activeDoc: null }">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Verification Queue (Levels 1 - 5)</h1>
                <p class="text-slate-500 text-sm mt-1">Review identity verification documents, government IDs, and creator portfolio proof.</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3.5 py-1.5 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold tabular-nums">
                    {{ $verifications->total() }} Total Submissions
                </span>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[11px]">
                        <tr>
                            <th class="p-4 rounded-l-xl">User / Creator</th>
                            <th class="p-4">Document Type</th>
                            <th class="p-4">Target Level</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Submitted Date</th>
                            <th class="p-4 rounded-r-xl text-right">Moderation Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($verifications as $v)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600 text-xs">
                                            {{ strtoupper(substr($v->user->name ?? 'U', 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="block font-bold text-slate-900">{{ $v->user->name ?? 'Creator' }}</span>
                                            <span class="text-[11px] text-slate-400">{{ $v->user->email ?? 'No email' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 uppercase font-semibold text-slate-800">
                                    <div class="space-y-1">
                                        <span class="px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-800 text-[10px] font-extrabold inline-block">
                                            {{ str_replace('_', ' ', $v->id_type ?: $v->document_type) }}
                                        </span>
                                        @if($v->document_name || $v->document_number)
                                            <div class="text-[11px] text-slate-600 font-medium normal-case">
                                                <span>{{ $v->document_name }}</span>
                                                @if($v->document_number)
                                                    <span class="text-slate-400">&bull; {{ $v->document_number }}</span>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="flex items-center gap-2 pt-1 normal-case">
                                            @if($v->document_path)
                                                <a href="{{ Storage::url($v->document_path) }}" target="_blank" class="text-indigo-600 hover:underline font-bold text-[11px] inline-flex items-center gap-0.5">
                                                    <span>Front File</span>
                                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                                </a>
                                            @endif
                                            @if($v->back_document_path)
                                                <a href="{{ Storage::url($v->back_document_path) }}" target="_blank" class="text-indigo-600 hover:underline font-bold text-[11px] inline-flex items-center gap-0.5">
                                                    <span>Back File</span>
                                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <x-verification-badge :level="$v->verification_level" size="xs" />
                                </td>
                                <td class="p-4">
                                    @if($v->status === 'approved')
                                        <span class="px-2.5 py-1 rounded-full font-bold uppercase text-[10px] bg-emerald-50 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                            <i data-lucide="check" class="w-3 h-3"></i> Approved
                                        </span>
                                    @elseif($v->status === 'rejected')
                                        <span class="px-2.5 py-1 rounded-full font-bold uppercase text-[10px] bg-rose-50 text-rose-800 border border-rose-200 inline-flex items-center gap-1">
                                            <i data-lucide="x" class="w-3 h-3"></i> Rejected
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full font-bold uppercase text-[10px] bg-amber-50 text-amber-800 border border-amber-200 animate-pulse inline-flex items-center gap-1">
                                            <i data-lucide="clock" class="w-3 h-3"></i> Pending Review
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-slate-500 tabular-nums">
                                    {{ $v->created_at->format('M d, Y') }}
                                </td>
                                <td class="p-4 text-right">
                                    <div class="inline-flex items-center space-x-2">
                                        @if($v->status !== 'approved')
                                            <form method="POST" action="{{ route('admin.verifications.status', $v->id) }}" class="inline-flex">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-2xs transition text-xs inline-flex items-center gap-1">
                                                    <i data-lucide="check" class="w-3.5 h-3.5"></i> Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.verifications.status', $v->id) }}" class="inline-flex">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-xl font-bold transition text-xs inline-flex items-center gap-1">
                                                    <i data-lucide="x" class="w-3.5 h-3.5"></i> Reject
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-emerald-600 font-bold inline-flex items-center gap-1"><i data-lucide="check" class="w-3.5 h-3.5"></i> Verified</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-slate-400">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center mx-auto mb-2">
                                        <i data-lucide="shield-check" class="w-6 h-6"></i>
                                    </div>
                                    <div class="font-bold text-slate-700">No pending verification documents</div>
                                    <p class="text-xs text-slate-400 mt-1">Creator verification submissions will appear here for review.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($verifications, 'links'))
                <div class="mt-6">
                    {{ $verifications->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
