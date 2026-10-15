@extends('layouts.influencer')

@section('title', 'Identity Verification & Government KYC | Talent Studio')

@section('content')
    <div class="max-w-4xl space-y-8" x-data="{
        selectedDocType: 'aadhaar',
        docFrontPreview: null,
        docBackPreview: null,
        frontFileName: '',
        backFileName: '',
        instantVerify: true,

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
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight font-display flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-xs">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </span>
                    <span>Identity & Document Verification</span>
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Verify your official Government ID to unlock the verified badge, premium brand campaigns & escrow payouts.
                </p>
            </div>
            
            <div class="flex items-center gap-2">
                <x-verification-badge :level="$talent->verification_level ?: 1" size="md" />
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-semibold flex items-center space-x-2">
                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs font-semibold space-y-1">
                @foreach($errors->all() as $err)
                    <p class="flex items-center space-x-1.5">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0"></i>
                        <span>{{ $err }}</span>
                    </p>
                @endforeach
            </div>
        @endif

        <!-- VERIFICATION ROADMAP / TIER CARD -->
        <div class="bg-gradient-to-br from-slate-900 via-slate-900 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white shadow-md border border-slate-800 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-5">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-400 block mb-1">Creator Trust Architecture</span>
                    <h3 class="text-lg sm:text-xl font-black font-display text-white">Trust & Verification Tiers</h3>
                    <p class="text-xs text-slate-400">Verified creators receive 4.8x more brand offers and priority escrow payouts.</p>
                </div>
                <div class="text-left sm:text-right">
                    <span class="text-xs text-slate-400 block font-medium">Your Current Status</span>
                    <span class="text-base font-black text-emerald-400">
                        @if((int)$talent->verification_level >= 2) Level 2: Government ID Verified
                        @else Level 1: Basic Email Verified @endif
                    </span>
                </div>
            </div>

            <!-- Steps Grid -->
            @php
                $isGovtVerified = $govtVerification && $govtVerification->status === 'approved';
                $isGovtPending = $govtVerification && $govtVerification->status === 'pending';
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <!-- Level 1 -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-4 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-black text-slate-300">Level 1: Basic Account</span>
                        <span class="p-1 rounded-full bg-emerald-500 text-slate-900"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                    </div>
                    <p class="text-[11px] text-slate-400">Email address & Creator profile active.</p>
                </div>

                <!-- Level 2 -->
                <div class="bg-white/5 border {{ $isGovtVerified ? 'border-emerald-500/40 bg-emerald-500/5' : ($isGovtPending ? 'border-amber-500/40' : 'border-white/10') }} rounded-2xl p-4 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-black {{ $isGovtVerified ? 'text-emerald-300' : ($isGovtPending ? 'text-amber-300' : 'text-slate-300') }}">Level 2: Government ID KYC</span>
                        @if($isGovtVerified)
                            <span class="p-1 rounded-full bg-emerald-500 text-slate-900"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                        @elseif($isGovtPending)
                            <span class="text-[10px] font-bold text-amber-400">In Review</span>
                        @else
                            <span class="text-[10px] font-bold text-slate-400">Required</span>
                        @endif
                    </div>
                    <p class="text-[11px] text-slate-400">Aadhaar, Driving License, Passport, PAN or Voter ID verified.</p>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- GOVERNMENT DOCUMENT KYC SECTION           -->
        <!-- ========================================== -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-200 flex items-center justify-center font-bold text-lg shadow-2xs">
                        <i data-lucide="file-badge-2" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-base font-display">Government Document ID Verification</h3>
                        <p class="text-xs text-slate-500">Submit Aadhaar Card, Driving License, PAN Card, Passport, or Voter ID for Verified Badge.</p>
                    </div>
                </div>

                @if($isGovtVerified)
                    <span class="px-3 py-1 bg-emerald-50 text-[#108a00] border border-emerald-200 rounded-full text-xs font-bold inline-flex items-center gap-1.5 self-start">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> ID Verified
                    </span>
                @elseif($isGovtPending)
                    <span class="px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-full text-xs font-bold inline-flex items-center gap-1.5 self-start">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-600"></i> Under Compliance Review
                    </span>
                @else
                    <span class="px-3 py-1 bg-slate-100 text-slate-700 border border-slate-200 rounded-full text-xs font-bold inline-flex items-center gap-1.5 self-start">
                        <i data-lucide="shield-alert" class="w-3.5 h-3.5 text-slate-400"></i> Not Yet Submitted
                    </span>
                @endif
            </div>

            <!-- Existing Verified Card -->
            @if($isGovtVerified)
                <div class="bg-emerald-50/70 border border-emerald-200 rounded-2xl p-6 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <span class="text-[10px] font-extrabold uppercase text-emerald-700 tracking-wider">Verified Government Credential</span>
                            <h4 class="text-base font-black text-slate-900 capitalize">{{ str_replace('_', ' ', $govtVerification->id_type ?: $govtVerification->document_type) }}</h4>
                            <p class="text-xs text-slate-600 mt-0.5">
                                Verified Name: <strong>{{ $govtVerification->document_name ?: $user->name }}</strong> &bull; ID: <strong>{{ $govtVerification->document_number ?: 'XXXX-XXXX-Verified' }}</strong>
                            </p>
                        </div>
                        <div class="text-left sm:text-right">
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-lg inline-flex items-center gap-1">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i> Authenticated
                            </span>
                            <span class="text-[10px] text-slate-400 block mt-1">Verified on {{ $govtVerification->verified_at ? $govtVerification->verified_at->format('M d, Y') : 'Active' }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Pending Card -->
            @if($isGovtPending)
                <div class="bg-amber-50/80 border border-amber-200 rounded-2xl p-6 space-y-3">
                    <div class="flex items-center space-x-2.5 text-amber-900 font-bold text-sm">
                        <i data-lucide="clock" class="w-5 h-5 text-amber-600"></i>
                        <span>Your {{ strtoupper(str_replace('_', ' ', $govtVerification->id_type)) }} submission is currently under review</span>
                    </div>
                    <p class="text-xs text-amber-800">
                        Our compliance team validates document details against government registers. Verification is typically completed within 2 to 4 business hours.
                    </p>
                </div>
            @endif

            <!-- Form: When not verified -->
            @if(!$isGovtVerified)
                <form method="POST" action="{{ route('influencer.verification.submit_govt_id') }}" enctype="multipart/form-data" class="space-y-6 pt-2">
                    @csrf

                    <!-- 1. Document Type Picker -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase">1. Select Document Type *</label>
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-2.5 text-xs font-bold">
                            <!-- Aadhaar Card -->
                            <label class="flex flex-col items-center justify-center p-3 rounded-2xl border cursor-pointer transition text-center space-y-1.5"
                                   :class="selectedDocType === 'aadhaar' ? 'bg-indigo-50 border-indigo-500 text-indigo-900 shadow-xs ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'">
                                <input type="radio" name="id_type" value="aadhaar" x-model="selectedDocType" class="sr-only">
                                <i data-lucide="credit-card" class="w-5 h-5"></i>
                                <span>Aadhaar Card</span>
                            </label>

                            <!-- Driving License -->
                            <label class="flex flex-col items-center justify-center p-3 rounded-2xl border cursor-pointer transition text-center space-y-1.5"
                                   :class="selectedDocType === 'driving_license' ? 'bg-indigo-50 border-indigo-500 text-indigo-900 shadow-xs ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'">
                                <input type="radio" name="id_type" value="driving_license" x-model="selectedDocType" class="sr-only">
                                <i data-lucide="car" class="w-5 h-5"></i>
                                <span>Driver's License</span>
                            </label>

                            <!-- PAN Card -->
                            <label class="flex flex-col items-center justify-center p-3 rounded-2xl border cursor-pointer transition text-center space-y-1.5"
                                   :class="selectedDocType === 'pan_card' ? 'bg-indigo-50 border-indigo-500 text-indigo-900 shadow-xs ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'">
                                <input type="radio" name="id_type" value="pan_card" x-model="selectedDocType" class="sr-only">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                                <span>PAN Card</span>
                            </label>

                            <!-- Passport -->
                            <label class="flex flex-col items-center justify-center p-3 rounded-2xl border cursor-pointer transition text-center space-y-1.5"
                                   :class="selectedDocType === 'passport' ? 'bg-indigo-50 border-indigo-500 text-indigo-900 shadow-xs ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'">
                                <input type="radio" name="id_type" value="passport" x-model="selectedDocType" class="sr-only">
                                <i data-lucide="globe" class="w-5 h-5"></i>
                                <span>Passport</span>
                            </label>

                            <!-- Voter ID -->
                            <label class="flex flex-col items-center justify-center p-3 rounded-2xl border cursor-pointer transition text-center space-y-1.5"
                                   :class="selectedDocType === 'voter_id' ? 'bg-indigo-50 border-indigo-500 text-indigo-900 shadow-xs ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'">
                                <input type="radio" name="id_type" value="voter_id" x-model="selectedDocType" class="sr-only">
                                <i data-lucide="check-square" class="w-5 h-5"></i>
                                <span>Voter ID Card</span>
                            </label>
                        </div>
                    </div>

                    <!-- 2. Text Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase">2. Full Legal Name (as on document) *</label>
                            <input type="text" 
                                   name="document_name" 
                                   value="{{ old('document_name', $user->name) }}" 
                                   required 
                                   placeholder="e.g. Parth Sanjay Sharma" 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase">3. Document / ID Number *</label>
                            <input type="text" 
                                   name="document_number" 
                                   value="{{ old('document_number') }}" 
                                   required 
                                   placeholder="e.g. 5432 9876 1234 (Aadhaar) or MH15 20210001234 (DL)" 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- 3. Document Front & Back Upload -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Front Side -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase">4. Document Front Side (Photo / PDF) *</label>
                            <div class="relative border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/50 rounded-2xl p-5 text-center transition cursor-pointer group">
                                <input type="file" 
                                       name="document_file" 
                                       required 
                                       accept="image/*,application/pdf" 
                                       @change="previewFront($event)" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                                <template x-if="docFrontPreview">
                                    <div class="space-y-2">
                                        <img :src="docFrontPreview" class="h-28 mx-auto rounded-xl object-contain shadow-xs border border-slate-200">
                                        <p class="text-[11px] font-bold text-emerald-600 truncate" x-text="frontFileName"></p>
                                    </div>
                                </template>

                                <template x-if="!docFrontPreview">
                                    <div class="space-y-2 py-2">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto group-hover:scale-110 transition">
                                            <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                                        </div>
                                        <div class="text-xs font-bold text-slate-800">Upload Front Side</div>
                                        <p class="text-[10px] text-slate-400">JPG, PNG, WEBP or PDF (Max 10MB)</p>
                                        <template x-if="frontFileName">
                                            <p class="text-[11px] font-semibold text-indigo-600 truncate" x-text="frontFileName"></p>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Back Side -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase">5. Document Back Side (Address / Info) <span class="text-slate-400 lowercase font-normal">(optional)</span></label>
                            <div class="relative border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/50 rounded-2xl p-5 text-center transition cursor-pointer group">
                                <input type="file" 
                                       name="back_document_file" 
                                       accept="image/*,application/pdf" 
                                       @change="previewBack($event)" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                                <template x-if="docBackPreview">
                                    <div class="space-y-2">
                                        <img :src="docBackPreview" class="h-28 mx-auto rounded-xl object-contain shadow-xs border border-slate-200">
                                        <p class="text-[11px] font-bold text-emerald-600 truncate" x-text="backFileName"></p>
                                    </div>
                                </template>

                                <template x-if="!docBackPreview">
                                    <div class="space-y-2 py-2">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto group-hover:scale-110 transition">
                                            <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                                        </div>
                                        <div class="text-xs font-bold text-slate-800">Upload Back Side</div>
                                        <p class="text-[10px] text-slate-400">Required for Aadhaar & Driver's License</p>
                                        <template x-if="backFileName">
                                            <p class="text-[11px] font-semibold text-indigo-600 truncate" x-text="backFileName"></p>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Instant KYC Verification Option Toggle -->
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <i data-lucide="zap" class="w-4 h-4 text-amber-500 shrink-0"></i>
                            <div>
                                <span class="text-xs font-bold text-slate-900 block">Instant Automated KYC Verification</span>
                                <span class="text-[11px] text-slate-500">Enable to immediately verify your document and activate the verified badge.</span>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="instant_verify" value="1" x-model="instantVerify" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <span class="text-xs text-slate-400 font-medium">All documents are encrypted and safely stored in compliance with IT regulations.</span>
                        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-slate-900 hover:bg-black text-white font-black text-xs rounded-2xl shadow-md transition flex items-center justify-center space-x-2">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                            <span>Submit Government Document for Verification</span>
                        </button>
                    </div>
                </form>
            @endif
        </div>

        <!-- ========================================== -->
        <!-- VERIFICATION AUDIT TRAIL                   -->
        <!-- ========================================== -->
        @if($verifications->isNotEmpty())
            <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs space-y-4">
                <h3 class="text-base font-bold text-slate-900 font-display">Verification Records & Audit Trail</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold border-b border-slate-200">
                            <tr>
                                <th class="py-3 px-4">Verification Type</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Submitted At</th>
                                <th class="py-3 px-4">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-semibold text-slate-800">
                            @foreach($verifications as $v)
                                <tr>
                                    <td class="py-3 px-4 capitalize">
                                        <div class="flex items-center space-x-2">
                                            <i data-lucide="file-check" class="w-4 h-4 text-indigo-600"></i>
                                            <span>{{ str_replace('_', ' ', $v->id_type ?: $v->document_type) }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($v->status === 'approved')
                                            <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full font-bold inline-flex items-center gap-1 text-[10px]">
                                                <i data-lucide="check" class="w-3 h-3"></i> Approved
                                            </span>
                                        @elseif($v->status === 'pending')
                                            <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-full font-bold inline-flex items-center gap-1 text-[10px]">
                                                <i data-lucide="clock" class="w-3 h-3"></i> Pending
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded-full font-bold inline-flex items-center gap-1 text-[10px]">
                                                <i data-lucide="x" class="w-3 h-3"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-slate-500 font-normal">
                                        {{ $v->created_at->format('M d, Y h:i A') }}
                                    </td>
                                    <td class="py-3 px-4 text-slate-500 font-normal">
                                        {{ $v->admin_notes ?: ($v->rejection_reason ?: '—') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
@endsection
