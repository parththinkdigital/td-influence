@extends('layouts.admin')

@section('title', 'Verification Queue | Admin Gateway')

@section('content')
    <div class="space-y-8" x-data="{ 
        inspectModal: false, 
        activeItem: null,
        activeTab: 'all',
        previewImage: null,
        openInspect(item) {
            this.activeItem = item;
            this.previewImage = item.document_path ? ('/storage/' + item.document_path.replace(/^\/+/, '')) : null;
            this.inspectModal = true;
        }
    }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Identity Trust & Verification Gateway</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Creator Verification Queue</h1>
                <p class="text-slate-500 text-sm mt-1">Audit identity credentials, government IDs (Aadhaar / PAN / Passport), and assign creator trust levels (L1–L5).</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-4 py-2 rounded-2xl bg-white border border-slate-200/80 text-slate-700 text-xs font-bold shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-indigo-500"></i>
                    <span>{{ $verifications->total() }} Submissions Tracked</span>
                </span>
            </div>
        </div>

        <!-- Verification Metrics Ribbon -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Audit</span>
                    <h3 class="text-2xl font-black text-amber-600 mt-1 font-display">
                        {{ $verifications->where('status', 'pending')->count() }}
                    </h3>
                    <span class="text-[11px] text-slate-500 font-medium">Awaiting administrator approval</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Approved Credentials</span>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1 font-display">
                        {{ $verifications->where('status', 'approved')->count() }}
                    </h3>
                    <span class="text-[11px] text-slate-500 font-medium">Level 3–5 Trust Badges assigned</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rejected / Resubmit</span>
                    <h3 class="text-2xl font-black text-rose-600 mt-1 font-display">
                        {{ $verifications->where('status', 'rejected')->count() }}
                    </h3>
                    <span class="text-[11px] text-slate-500 font-medium">Flagged for blurred/invalid proof</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
        </div>

        <!-- Verification Table Card -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[11px] border-b border-slate-100">
                        <tr>
                            <th class="p-4 rounded-l-2xl">Creator / Talent</th>
                            <th class="p-4">Document / Proof Type</th>
                            <th class="p-4">Requested Level</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Submitted Date</th>
                            <th class="p-4 rounded-r-2xl text-right">Moderation Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-sans">
                        @forelse($verifications as $v)
                            @php
                                $payload = [
                                    'id' => $v->id,
                                    'name' => $v->user->name ?? 'Creator',
                                    'email' => $v->user->email ?? 'No email',
                                    'doc_type' => str_replace('_', ' ', $v->id_type ?: $v->document_type),
                                    'doc_name' => $v->document_name,
                                    'doc_number' => $v->document_number,
                                    'target_level' => $v->verification_level,
                                    'status' => $v->status,
                                    'document_path' => $v->document_path,
                                    'back_document_path' => $v->back_document_path,
                                    'created_at' => $v->created_at->format('M d, Y • h:i A'),
                                    'approve_url' => route('admin.verifications.status', $v->id),
                                ];
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-black text-sm shadow-2xs">
                                            {{ strtoupper(substr($v->user->name ?? 'U', 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="block font-bold text-slate-900 text-sm">{{ $v->user->name ?? 'Creator' }}</span>
                                            <span class="text-[11px] text-slate-400 font-mono">{{ $v->user->email ?? 'No email' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 font-semibold text-slate-800">
                                    <div class="space-y-1">
                                        <span class="px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-200/80 text-indigo-700 text-[10px] font-black uppercase tracking-wider inline-flex items-center gap-1">
                                            <i class="fa-solid fa-id-card text-[9px]"></i>
                                            {{ str_replace('_', ' ', $v->id_type ?: $v->document_type) }}
                                        </span>
                                        @if($v->document_name || $v->document_number)
                                            <div class="text-[11px] text-slate-600 font-medium">
                                                <span>{{ $v->document_name }}</span>
                                                @if($v->document_number)
                                                    <span class="text-slate-400 font-mono">• {{ $v->document_number }}</span>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="flex items-center gap-2 pt-1">
                                            <button type="button" 
                                                    @click="openInspect({{ json_encode($payload) }})" 
                                                    class="text-indigo-600 hover:text-indigo-800 font-bold text-[11px] inline-flex items-center gap-1 bg-indigo-50/50 hover:bg-indigo-100/60 px-2 py-0.5 rounded-md transition">
                                                <i class="fa-solid fa-magnifying-glass-plus text-[10px]"></i>
                                                <span>Inspect Proof</span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 border border-slate-200 text-slate-800 font-extrabold text-[11px]">
                                        <i class="fa-solid fa-award text-amber-500"></i>
                                        <span>Level {{ $v->verification_level }}</span>
                                    </span>
                                </td>
                                <td class="p-4">
                                    @if($v->status === 'approved')
                                        <span class="px-2.5 py-1 rounded-full font-bold uppercase text-[10px] bg-emerald-50 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Verified
                                        </span>
                                    @elseif($v->status === 'rejected')
                                        <span class="px-2.5 py-1 rounded-full font-bold uppercase text-[10px] bg-rose-50 text-rose-800 border border-rose-200 inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Rejected
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full font-bold uppercase text-[10px] bg-amber-50 text-amber-800 border border-amber-200 inline-flex items-center gap-1.5 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Pending Audit
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-slate-500 tabular-nums">
                                    <span class="font-medium text-slate-700">{{ $v->created_at->format('M d, Y') }}</span>
                                    <span class="block text-[10px] text-slate-400">{{ $v->created_at->format('h:i A') }}</span>
                                </td>
                                <td class="p-4 text-right">
                                    <div class="inline-flex items-center space-x-1.5">
                                        <button type="button" 
                                                @click="openInspect({{ json_encode($payload) }})" 
                                                class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition text-xs inline-flex items-center gap-1">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                            <span>Inspect</span>
                                        </button>
                                        @if($v->status !== 'approved')
                                            <form method="POST" action="{{ route('admin.verifications.status', $v->id) }}" class="inline-flex">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-2xs transition text-xs inline-flex items-center gap-1">
                                                    <i class="fa-solid fa-check text-xs"></i>
                                                    <span>Approve</span>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.verifications.status', $v->id) }}" class="inline-flex">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-xl font-bold transition text-xs inline-flex items-center gap-1">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                    <span>Reject</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-emerald-600 font-bold inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 rounded-xl border border-emerald-100">
                                                <i class="fa-solid fa-circle-check text-xs"></i>
                                                <span>Active</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-16 text-center text-slate-400">
                                    <div class="w-16 h-16 rounded-3xl bg-slate-50 border border-slate-200/80 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>
                                    <div class="font-bold text-slate-800 text-base">All verification requests cleared</div>
                                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">New identity documents, Aadhaar cards, and government records submitted by creators will populate here in real-time.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($verifications, 'links'))
                <div class="mt-6 border-t border-slate-100 pt-4">
                    {{ $verifications->links() }}
                </div>
            @endif
        </div>

        <!-- Document Inspection & Decision Modal -->
        <div x-show="inspectModal" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             x-cloak>
            <div @click.away="inspectModal = false" class="bg-white border border-slate-200 rounded-3xl max-w-3xl w-full shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-sm">
                            <i class="fa-solid fa-id-badge"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900 font-display flex items-center gap-2">
                                <span>Audit Identity Proof</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-700" x-text="'Level ' + (activeItem ? activeItem.target_level : '')"></span>
                            </h3>
                            <p class="text-slate-500 text-xs" x-text="activeItem ? activeItem.name + ' • ' + activeItem.email : ''"></p>
                        </div>
                    </div>
                    <button @click="inspectModal = false" class="w-8 h-8 rounded-full bg-slate-200/80 hover:bg-slate-300 text-slate-600 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto space-y-6 flex-1">
                    <!-- Proof Information Card -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-slate-50 border border-slate-200/80 rounded-2xl p-4">
                        <div>
                            <span class="block text-[10px] font-bold uppercase text-slate-400">Document Type</span>
                            <span class="text-xs font-bold text-slate-800 uppercase" x-text="activeItem ? activeItem.doc_type : 'N/A'"></span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold uppercase text-slate-400">Document ID / Number</span>
                            <span class="text-xs font-mono font-bold text-slate-800" x-text="activeItem && activeItem.doc_number ? activeItem.doc_number : 'Not Recorded'"></span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold uppercase text-slate-400">Document Name</span>
                            <span class="text-xs font-bold text-slate-800" x-text="activeItem && activeItem.doc_name ? activeItem.doc_name : 'Identity Record'"></span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold uppercase text-slate-400">Current Status</span>
                            <span class="text-xs font-bold uppercase" :class="activeItem && activeItem.status === 'approved' ? 'text-emerald-600' : (activeItem && activeItem.status === 'rejected' ? 'text-rose-600' : 'text-amber-600')" x-text="activeItem ? activeItem.status : ''"></span>
                        </div>
                    </div>

                    <!-- Front & Back Switcher -->
                    <div class="flex items-center space-x-2 border-b border-slate-200 pb-2">
                        <button type="button" 
                                @click="previewImage = activeItem && activeItem.document_path ? ('/storage/' + activeItem.document_path.replace(/^\/+/, '')) : null"
                                class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5"
                                :class="previewImage && previewImage.includes(activeItem?.document_path) ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'">
                            <i class="fa-solid fa-file-image"></i>
                            <span>Front Side</span>
                        </button>
                        <template x-if="activeItem && activeItem.back_document_path">
                            <button type="button" 
                                    @click="previewImage = '/storage/' + activeItem.back_document_path.replace(/^\/+/, '')"
                                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5"
                                    :class="previewImage && previewImage.includes(activeItem?.back_document_path) ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'">
                                <i class="fa-solid fa-file-image"></i>
                                <span>Back Side</span>
                            </button>
                        </template>
                    </div>

                    <!-- Image / Preview Viewer -->
                    <div class="bg-slate-900 rounded-2xl p-4 flex items-center justify-center min-h-[260px] border border-slate-800 overflow-hidden relative group">
                        <template x-if="previewImage">
                            <img :src="previewImage" 
                                 alt="Verification Document" 
                                 class="max-h-80 w-auto object-contain rounded-lg shadow-lg group-hover:scale-105 transition duration-300">
                        </template>
                        <template x-if="!previewImage">
                            <div class="text-center text-slate-500 py-12">
                                <i class="fa-solid fa-file-circle-xmark text-4xl mb-2 text-slate-600"></i>
                                <p class="text-xs">No direct image document uploaded for this proof slot.</p>
                            </div>
                        </template>
                    </div>

                    <!-- Form with notes for approval/rejection -->
                    <form method="POST" :action="activeItem ? activeItem.approve_url : '#'" class="space-y-4 pt-2">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Administrator Audit Notes (Sent to Creator)
                            </label>
                            <textarea name="admin_notes" 
                                      rows="2" 
                                      placeholder="e.g. Identity verified against government records. Level 3 awarded."
                                      class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-indigo-600 transition"></textarea>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <button type="button" @click="inspectModal = false" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition">
                                Close Preview
                            </button>
                            <div class="flex items-center space-x-2">
                                <button type="submit" name="status" value="rejected" class="px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-xl font-bold text-xs transition inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-xmark"></i>
                                    <span>Reject Proof</span>
                                </button>
                                <button type="submit" name="status" value="approved" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-md transition inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-check"></i>
                                    <span>Approve & Assign Level</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
