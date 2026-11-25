@extends('layouts.influencer')

@section('title', 'Identity Verification & Government KYC | Talent Studio')

@section('content')
    <div class="max-w-4xl space-y-8" x-data="{
        selectedDocType: 'aadhaar',
        docFrontPreview: null,
        docBackPreview: null,
        frontFileName: '',
        backFileName: '',

        previewFront(e) {
            const file = e.target.files[0];
            if (file) {
                this.frontFileName = file.name;
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (ev) => { this.docFrontPreview = ev.target.result; };
                    reader.readAsDataURL(file);
                } else {
                    this.docFrontPreview = null;
                }
            }
        },

        previewBack(e) {
            const file = e.target.files[0];
            if (file) {
                this.backFileName = file.name;
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (ev) => { this.docBackPreview = ev.target.result; };
                    reader.readAsDataURL(file);
                } else {
                    this.docBackPreview = null;
                }
            }
        }
    }">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/80 pb-5">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Identity Trust & Verification Gateway</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Creator Verification & KYC</h1>
                <p class="text-slate-500 text-sm mt-1">
                    Complete identity verification to unlock Level 5 elite badge, priority brand recommendations, and instant escrow releases.
                </p>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="px-4 py-2 rounded-2xl bg-white border border-slate-200/80 text-slate-800 text-xs font-black shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-award text-amber-500"></i>
                    <span>Current: Level {{ $talent->verification_level ?: 1 }}</span>
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-sm shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- 5-Tier Verification Progression Ribbon -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4">
            <h3 class="text-xs font-black uppercase text-slate-900 tracking-wider font-display">5-Tier Creator Trust Framework</h3>
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                <div class="p-3.5 rounded-2xl border text-center {{ ($talent->verification_level ?? 1) >= 1 ? 'bg-emerald-50/70 border-emerald-200' : 'bg-slate-50 border-slate-200' }}">
                    <i class="fa-solid fa-user-check text-sm mb-1 block {{ ($talent->verification_level ?? 1) >= 1 ? 'text-emerald-600' : 'text-slate-400' }}"></i>
                    <span class="text-[11px] font-black text-slate-900 block font-display">L1: Signup</span>
                    <span class="text-[9px] font-bold {{ ($talent->verification_level ?? 1) >= 1 ? 'text-emerald-700' : 'text-slate-400' }}">{{ ($talent->verification_level ?? 1) >= 1 ? 'Completed' : 'Pending' }}</span>
                </div>
                <div class="p-3.5 rounded-2xl border text-center {{ ($talent->verification_level ?? 1) >= 2 ? 'bg-emerald-50/70 border-emerald-200' : 'bg-slate-50 border-slate-200' }}">
                    <i class="fa-solid fa-phone text-sm mb-1 block {{ ($talent->verification_level ?? 1) >= 2 ? 'text-emerald-600' : 'text-slate-400' }}"></i>
                    <span class="text-[11px] font-black text-slate-900 block font-display">L2: Phone OTP</span>
                    <span class="text-[9px] font-bold {{ ($talent->verification_level ?? 1) >= 2 ? 'text-emerald-700' : 'text-slate-400' }}">{{ ($talent->verification_level ?? 1) >= 2 ? 'Verified' : 'Pending' }}</span>
                </div>
                <div class="p-3.5 rounded-2xl border text-center {{ ($talent->verification_level ?? 1) >= 3 ? 'bg-emerald-50/70 border-emerald-200' : 'bg-slate-50 border-slate-200' }}">
                    <i class="fa-solid fa-id-card text-sm mb-1 block {{ ($talent->verification_level ?? 1) >= 3 ? 'text-emerald-600' : 'text-slate-400' }}"></i>
                    <span class="text-[11px] font-black text-slate-900 block font-display">L3: Govt ID</span>
                    <span class="text-[9px] font-bold {{ ($talent->verification_level ?? 1) >= 3 ? 'text-emerald-700' : 'text-slate-400' }}">{{ ($talent->verification_level ?? 1) >= 3 ? 'Verified' : 'Upload Proof' }}</span>
                </div>
                <div class="p-3.5 rounded-2xl border text-center {{ ($talent->verification_level ?? 1) >= 4 ? 'bg-emerald-50/70 border-emerald-200' : 'bg-slate-50 border-slate-200' }}">
                    <i class="fa-solid fa-briefcase text-sm mb-1 block {{ ($talent->verification_level ?? 1) >= 4 ? 'text-emerald-600' : 'text-slate-400' }}"></i>
                    <span class="text-[11px] font-black text-slate-900 block font-display">L4: Portfolio</span>
                    <span class="text-[9px] font-bold {{ ($talent->verification_level ?? 1) >= 4 ? 'text-emerald-700' : 'text-slate-400' }}">{{ ($talent->verification_level ?? 1) >= 4 ? 'Verified' : 'Add Items' }}</span>
                </div>
                <div class="p-3.5 rounded-2xl border text-center {{ ($talent->verification_level ?? 1) >= 5 ? 'bg-emerald-50/70 border-emerald-200' : 'bg-slate-50 border-slate-200' }}">
                    <i class="fa-solid fa-award text-sm mb-1 block {{ ($talent->verification_level ?? 1) >= 5 ? 'text-amber-500' : 'text-slate-400' }}"></i>
                    <span class="text-[11px] font-black text-slate-900 block font-display">L5: Elite</span>
                    <span class="text-[9px] font-bold {{ ($talent->verification_level ?? 1) >= 5 ? 'text-emerald-700' : 'text-slate-400' }}">{{ ($talent->verification_level ?? 1) >= 5 ? 'Elite Verified' : 'Locked' }}</span>
                </div>
            </div>
        </div>

        <!-- Government ID Document Upload Card -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-xs space-y-6">
            <div class="flex items-center space-x-3 border-b border-slate-100 pb-4">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-id-badge text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 font-display">Submit Government ID Proof (Level 3)</h3>
                    <p class="text-xs text-slate-500">Accepted: Aadhaar Card, Driving License, PAN Card, Passport, or Voter ID.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('influencer.verification.submit_govt_id') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Document Type *</label>
                        <select name="id_type" x-model="selectedDocType" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-bold focus:bg-white focus:outline-none focus:border-indigo-600 transition">
                            <option value="aadhaar">Aadhaar Card</option>
                            <option value="driving_license">Driving License</option>
                            <option value="pan_card">PAN Card</option>
                            <option value="passport">Passport</option>
                            <option value="voter_id">Voter ID</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Document ID / Number (Optional)</label>
                        <input type="text" name="document_number" placeholder="e.g. XXXX-XXXX-XXXX" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-mono font-bold focus:bg-white focus:outline-none focus:border-indigo-600 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Front Image -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Document Front *</label>
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-indigo-400 transition cursor-pointer relative bg-slate-50/50">
                            <input type="file" name="document_file" required accept="image/*,application/pdf" @change="previewFront($event)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                            <template x-if="!docFrontPreview && !frontFileName">
                                <div class="py-4 space-y-1">
                                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400"></i>
                                    <p class="text-xs font-bold text-slate-700">Upload Front Side</p>
                                    <p class="text-[10px] text-slate-400">PNG, JPG or PDF up to 10MB</p>
                                </div>
                            </template>
                            <template x-if="docFrontPreview">
                                <img :src="docFrontPreview" class="max-h-36 mx-auto rounded-lg shadow-sm">
                            </template>
                            <template x-if="frontFileName && !docFrontPreview">
                                <p class="text-xs font-bold text-indigo-600 py-4" x-text="frontFileName"></p>
                            </template>
                        </div>
                    </div>

                    <!-- Back Image -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Document Back (Optional for PAN)</label>
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-indigo-400 transition cursor-pointer relative bg-slate-50/50">
                            <input type="file" name="back_document_file" accept="image/*,application/pdf" @change="previewBack($event)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                            <template x-if="!docBackPreview && !backFileName">
                                <div class="py-4 space-y-1">
                                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400"></i>
                                    <p class="text-xs font-bold text-slate-700">Upload Back Side</p>
                                    <p class="text-[10px] text-slate-400">PNG, JPG or PDF up to 10MB</p>
                                </div>
                            </template>
                            <template x-if="docBackPreview">
                                <img :src="docBackPreview" class="max-h-36 mx-auto rounded-lg shadow-sm">
                            </template>
                            <template x-if="backFileName && !docBackPreview">
                                <p class="text-xs font-bold text-indigo-600 py-4" x-text="backFileName"></p>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-400 flex items-center gap-1.5">
                        <i class="fa-solid fa-lock text-slate-400"></i>
                        <span>Encrypted & reviewed strictly by admin moderation.</span>
                    </span>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-xs transition inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Submit for Verification</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
