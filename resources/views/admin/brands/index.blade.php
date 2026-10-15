@extends('layouts.admin')

@section('title', 'Manage Brands | Admin Gateway')

@section('content')
    <div class="space-y-8" x-data="{ showModal: false }">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Brand Credentials Governance</h1>
                <p class="text-slate-500 text-sm mt-1">Generate and issue secure login credentials for verified Brand accounts in Nashik & beyond.</p>
            </div>
            <button @click="showModal = true" class="px-5 py-3 rounded-xl font-bold bg-slate-900 hover:bg-black text-white transition text-xs shadow-sm">
                + Generate Brand Credentials
            </button>
        </div>

        @if(session('credential_created'))
            <div class="bg-emerald-50 border border-emerald-200 p-6 rounded-3xl space-y-3">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <h3 class="text-base font-bold text-emerald-900 font-display">Brand Credentials Generated Successfully</h3>
                </div>
                <p class="text-emerald-700 text-xs">Provide these credentials to the brand representative to log in:</p>
                <div class="bg-white border border-emerald-200 p-4 rounded-2xl font-mono text-xs space-y-1.5 text-slate-900 shadow-2xs">
                    <div><span class="text-slate-500">Company:</span> {{ session('credential_created.company_name') }}</div>
                    <div><span class="text-slate-500">Login Email:</span> <strong class="text-slate-900">{{ session('credential_created.email') }}</strong></div>
                    <div><span class="text-slate-500">Issued Password:</span> <strong class="text-emerald-700 font-bold">{{ session('credential_created.password') }}</strong></div>
                </div>
            </div>
        @endif

        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs">
            <h3 class="text-lg font-bold text-slate-900 mb-4 font-display">Issued Brand Accounts</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-900">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold">
                        <tr>
                            <th class="p-4 rounded-l-xl">Company Name</th>
                            <th class="p-4">Contact Representative</th>
                            <th class="p-4">Login Email</th>
                            <th class="p-4">Industry</th>
                            <th class="p-4">Location</th>
                            <th class="p-4 rounded-r-xl">Date Issued</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($brands as $brand)
                            <tr>
                                <td class="p-4 font-bold text-slate-900 flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-brand-50 border border-brand-100 flex items-center justify-center font-bold text-brand-700 text-xs">
                                        {{ substr($brand->company_name, 0, 1) }}
                                    </div>
                                    <span>{{ $brand->company_name }}</span>
                                </td>
                                <td class="p-4 text-slate-600">{{ $brand->contact_name ?: 'N/A' }}</td>
                                <td class="p-4 font-mono text-xs text-slate-900">{{ $brand->user->email ?? 'N/A' }}</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 bg-slate-100 rounded-full text-xs text-slate-700 font-semibold">
                                        {{ $brand->industry->name ?? 'General' }}
                                    </span>
                                </td>
                                <td class="p-4 text-xs text-slate-600">{{ $brand->headquarters ?: 'Nashik, Maharashtra' }}</td>
                                <td class="p-4 text-xs text-slate-400">{{ $brand->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">No brand accounts created yet. Click "+ Generate Brand Credentials" to issue an account.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $brands->links() }}
            </div>
        </div>

        <!-- Modal: Generate Brand Credentials -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-cloak>
            <div @click.away="showModal = false" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl relative space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 font-display">Issue Brand Account</h3>
                        <p class="text-slate-500 text-xs">Create credentials for brand portal login.</p>
                    </div>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-900 font-bold text-xl">&times;</button>
                </div>

                <form method="POST" action="{{ route('admin.brands.generate') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Company Name *</label>
                        <input type="text" name="company_name" required placeholder="e.g. Sula Studios Nashik" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:border-slate-900 focus:bg-white transition">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Contact Person *</label>
                            <input type="text" name="contact_name" required placeholder="Ria Sharma" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:border-slate-900 focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Contact Phone</label>
                            <input type="text" name="phone" placeholder="+91 98765 43210" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:border-slate-900 focus:bg-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Brand Email (Username) *</label>
                        <input type="email" name="email" required placeholder="contact@brand.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:border-slate-900 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Generated Password *</label>
                        <input type="text" name="password" required value="BrandPass#{{ rand(100, 999) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 font-mono font-bold text-sm focus:outline-none focus:border-slate-900 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Industry</label>
                        <select name="industry_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:border-slate-900 focus:bg-white transition">
                            <option value="">Select Industry</option>
                            @foreach($industries as $ind)
                                <option value="{{ $ind->id }}">{{ $ind->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" @click="showModal = false" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-xs">Cancel</button>
                        <button type="submit" class="px-6 py-3 rounded-xl font-bold bg-slate-900 hover:bg-black text-white transition text-xs shadow-md">
                            Issue Brand Credentials
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
