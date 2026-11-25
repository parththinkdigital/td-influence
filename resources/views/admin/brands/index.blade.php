@extends('layouts.admin')

@section('title', 'Manage Brands | Admin Gateway')

@section('content')
    <div class="space-y-8" x-data="{ 
        showModal: false,
        copied: false,
        generatePassword() {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$';
            let pass = 'Brand#';
            for (let i = 0; i < 6; i++) {
                pass += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return pass;
        },
        passwordVal: 'BrandPass#789',
        copyCredentials(text) {
            navigator.clipboard.writeText(text);
            this.copied = true;
            setTimeout(() => this.copied = false, 2500);
        }
    }" x-init="passwordVal = generatePassword()">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    <span>Enterprise Governance</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Brand Accounts & Credentials</h1>
                <p class="text-slate-500 text-sm mt-1">Issue secure single-sign-on credentials and verify registered brand entities across Nashik & national markets.</p>
            </div>
            <button @click="showModal = true; passwordVal = generatePassword()" class="px-5 py-3 rounded-2xl font-bold bg-slate-900 hover:bg-black text-white transition text-xs shadow-md inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Issue Brand Credentials</span>
            </button>
        </div>

        @if(session('credential_created'))
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200/80 p-6 rounded-3xl space-y-4 shadow-sm"
                 x-data="{ copiedNotice: false }">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 animate-ping"></span>
                        <h3 class="text-base font-black text-emerald-950 font-display">Brand Credentials Issued Successfully</h3>
                    </div>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-[10px] font-extrabold uppercase tracking-wider rounded-full">
                        Ready to Dispatch
                    </span>
                </div>
                <p class="text-emerald-800 text-xs">Forward these credentials securely to the authorized company representative to log in to the Brand Studio:</p>
                
                <div class="bg-white border border-emerald-200 p-5 rounded-2xl font-mono text-xs space-y-2.5 text-slate-900 shadow-2xs relative">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 uppercase text-[10px] font-bold font-sans">Authorized Entity</span>
                        <span class="font-bold text-slate-900 font-sans text-sm">{{ session('credential_created.company_name') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 uppercase text-[10px] font-bold font-sans">Brand Portal Email</span>
                        <span class="font-black text-indigo-600">{{ session('credential_created.email') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 uppercase text-[10px] font-bold font-sans">Temporary Password</span>
                        <span class="font-black text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200 text-sm tracking-wider">{{ session('credential_created.password') }}</span>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex justify-end">
                        <button type="button" 
                                @click="
                                    navigator.clipboard.writeText('Brand Portal Login\nCompany: {{ session('credential_created.company_name') }}\nEmail: {{ session('credential_created.email') }}\nPassword: {{ session('credential_created.password') }}\nLogin URL: ' + window.location.origin + '/brand/login');
                                    copiedNotice = true;
                                    setTimeout(() => copiedNotice = false, 2500);
                                "
                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs font-sans transition inline-flex items-center gap-1.5 shadow-2xs">
                            <i class="fa-regular fa-copy"></i>
                            <span x-text="copiedNotice ? 'Copied to Clipboard!' : 'Copy Dispatch Note'"></span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Brands Table -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-display">Active Brand Directory</h3>
                    <p class="text-slate-400 text-xs">Registered companies with campaign posting & escrow booking capabilities.</p>
                </div>
                <div class="text-xs text-slate-500 font-medium">
                    <span class="font-bold text-slate-900 tabular-nums">{{ $brands->total() }}</span> verified brands enrolled
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[11px] border-b border-slate-100">
                        <tr>
                            <th class="p-4 rounded-l-2xl">Company & Brand</th>
                            <th class="p-4">Contact Person</th>
                            <th class="p-4">Login Email</th>
                            <th class="p-4">Industry Sector</th>
                            <th class="p-4">Headquarters</th>
                            <th class="p-4 rounded-r-2xl text-right">Date Issued</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-sans">
                        @forelse($brands as $brand)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center font-black text-indigo-700 text-xs shadow-2xs">
                                            {{ strtoupper(substr($brand->company_name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="block font-black text-slate-900 text-sm">{{ $brand->company_name }}</span>
                                            <span class="text-[10px] text-emerald-600 font-bold inline-flex items-center gap-1">
                                                <i class="fa-solid fa-circle-check text-[9px]"></i>
                                                <span>Verified Entity</span>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 font-medium text-slate-700">
                                    <span class="font-bold text-slate-900">{{ $brand->contact_name ?: ($brand->contact_person ?: 'Authorized Rep') }}</span>
                                    @if($brand->contact_phone)
                                        <span class="block text-[10px] text-slate-400 font-mono">{{ $brand->contact_phone }}</span>
                                    @endif
                                </td>
                                <td class="p-4 font-mono text-xs text-slate-800">
                                    {{ $brand->user->email ?? 'N/A' }}
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 bg-slate-100 border border-slate-200/80 rounded-lg text-[10px] font-extrabold uppercase tracking-wider text-slate-700">
                                        {{ $brand->industry->name ?? 'General' }}
                                    </span>
                                </td>
                                <td class="p-4 text-xs text-slate-600">
                                    <span class="inline-flex items-center gap-1">
                                        <i class="fa-solid fa-location-dot text-slate-400 text-[10px]"></i>
                                        <span>{{ $brand->headquarters ?: 'Nashik, Maharashtra' }}</span>
                                    </span>
                                </td>
                                <td class="p-4 text-right text-slate-500 tabular-nums">
                                    <span class="font-medium text-slate-700">{{ $brand->created_at->format('M d, Y') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-16 text-center text-slate-400">
                                    <div class="w-16 h-16 rounded-3xl bg-slate-50 border border-slate-200/80 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                                        <i class="fa-solid fa-building"></i>
                                    </div>
                                    <div class="font-bold text-slate-800 text-base">No brand accounts registered yet</div>
                                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Click "+ Issue Brand Credentials" to issue the first corporate portal account.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($brands, 'links'))
                <div class="mt-6 border-t border-slate-100 pt-4">
                    {{ $brands->links() }}
                </div>
            @endif
        </div>

        <!-- Modal: Generate Brand Credentials -->
        <div x-show="showModal" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4" 
             x-cloak>
            <div @click.away="showModal = false" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl relative space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-sm">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 font-display">Issue Brand Credentials</h3>
                            <p class="text-slate-500 text-xs">Create instant portal login for verified companies.</p>
                        </div>
                    </div>
                    <button @click="showModal = false" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.brands.generate') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Registered Company Name *</label>
                        <input type="text" name="company_name" required placeholder="e.g. Sula Vineyards Studio Nashik" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-slate-900 transition">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Contact Person *</label>
                            <input type="text" name="contact_name" required placeholder="Aarav Deshmukh" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-slate-900 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Contact Phone</label>
                            <input type="text" name="phone" placeholder="+91 98220 12345" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-slate-900 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Brand Login Email (Username) *</label>
                        <input type="email" name="email" required placeholder="marketing@branddomain.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-slate-900 transition">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Initial Password *</label>
                            <button type="button" @click="passwordVal = generatePassword()" class="text-indigo-600 hover:text-indigo-800 text-[10px] font-bold">
                                <i class="fa-solid fa-arrows-rotate mr-1"></i> Regenerate
                            </button>
                        </div>
                        <input type="text" name="password" required x-model="passwordVal" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 font-mono font-bold text-xs focus:bg-white focus:outline-none focus:border-slate-900 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Industry Vertical</label>
                        <select name="industry_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-slate-900 transition">
                            <option value="">Select Industry</option>
                            @foreach($industries as $ind)
                                <option value="{{ $ind->id }}">{{ $ind->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" @click="showModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl font-bold bg-slate-900 hover:bg-black text-white transition text-xs shadow-md inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-check"></i>
                            <span>Generate & Dispatch</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
