@extends('layouts.influencer')

@section('title', 'My Gigs & Service Packages | Talent Studio')

@section('content')
    <div class="space-y-8" x-data="{
        showCreateModal: false,
        showEditModal: false,
        editGigData: { id: null, rate_type: '', rate_amount: '', is_negotiable: true, notes: '' },
        openEdit(gig) {
            this.editGigData = {
                id: gig.id,
                rate_type: gig.rate_type,
                rate_amount: gig.rate_amount,
                is_negotiable: Boolean(gig.is_negotiable),
                notes: gig.notes || ''
            };
            this.showEditModal = true;
        }
    }">
        <!-- Header -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="px-3.5 py-1 bg-emerald-50 text-[#108a00] border border-emerald-200 text-xs font-bold rounded-full inline-block mb-2">
                    Service Package Marketplace (CRUD)
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">My Gigs & Packages</h1>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Create, edit, and manage your service packages (Reels, Shoot rates, Hosting packages) that brands can hire directly.
                </p>
            </div>
            <div>
                <button @click="showCreateModal = true" class="px-6 py-3 bg-[#108a00] hover:bg-[#0e7700] text-white text-xs font-extrabold rounded-2xl transition shadow-md flex items-center space-x-2">
                    <span>+ Create New Gig Package</span>
                </button>
            </div>
        </div>

        <!-- Gigs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($rates as $gig)
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs flex flex-col justify-between space-y-5 hover:shadow-md transition group relative">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="px-3 py-1 bg-slate-100 text-slate-800 font-extrabold text-xs rounded-full border border-slate-200 uppercase tracking-wider">
                                {{ str_replace('_', ' ', $gig->rate_type) }}
                            </span>
                            @if($gig->is_negotiable)
                                <span class="px-2.5 py-0.5 bg-emerald-50 text-[#108a00] text-[10px] font-extrabold rounded-full border border-emerald-200">
                                    Negotiable
                                </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-black text-slate-900 group-hover:text-[#108a00] transition capitalize">
                            {{ str_replace('_', ' ', $gig->rate_type) }}
                        </h3>

                        <div class="mt-3 py-2 px-4 bg-slate-50 border border-slate-100 rounded-2xl inline-block">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Package Fee</span>
                            <span class="text-2xl font-black text-slate-900">₹{{ number_format($gig->rate_amount) }} <span class="text-xs font-semibold text-slate-500">{{ $gig->currency ?: 'INR' }}</span></span>
                        </div>

                        @if($gig->notes)
                            <p class="text-xs text-slate-600 mt-4 leading-relaxed bg-slate-50/50 p-3 rounded-xl border border-slate-100">
                                {{ $gig->notes }}
                            </p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" @click="openEdit({{ json_encode($gig) }})" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition inline-flex items-center gap-1.5">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            <span>Edit Gig</span>
                        </button>

                        <form method="POST" action="{{ route('influencer.gigs.delete', $gig->id) }}" onsubmit="return confirm('Are you sure you want to delete this Gig package?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 text-xs font-bold text-red-500 hover:bg-red-50 rounded-xl transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-white border border-slate-200 rounded-3xl space-y-4">
                    <div class="w-16 h-16 rounded-full bg-emerald-50 text-[#108a00] flex items-center justify-center mx-auto">
                        <i data-lucide="credit-card" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">No Gigs created yet</h3>
                        <p class="text-slate-500 text-xs mt-1 max-w-md mx-auto">Set up your starting package rates (e.g. Reel package, model daily shoot rate, hosting fee) so brands can view and book your services.</p>
                    </div>
                    <button @click="showCreateModal = true" class="px-6 py-3 bg-[#108a00] text-white text-xs font-bold rounded-2xl hover:bg-[#0e7700] transition shadow-md">
                        + Create Your First Gig Package
                    </button>
                </div>
            @endforelse
        </div>

        <!-- CREATE GIG MODAL -->
        <div x-show="showCreateModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
            <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-xl" @click.away="showCreateModal = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-lg">Create New Gig Package</h3>
                        <p class="text-xs text-slate-500">Add a fixed or negotiable service rate package</p>
                    </div>
                    <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-900 font-bold text-xl">&times;</button>
                </div>

                <form method="POST" action="{{ route('influencer.gigs.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Gig Package Name / Service Type *</label>
                        <input type="text" name="rate_type" required placeholder="e.g. 1x Instagram Reel + 2 Stories / Model Daily Shoot Rate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#108a00] focus:bg-white">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Package Price (₹ INR) *</label>
                            <input type="number" name="rate_amount" required placeholder="15000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-extrabold focus:outline-none focus:border-[#108a00] focus:bg-white">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Negotiable Fee?</label>
                            <select name="is_negotiable" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#108a00]">
                                <option value="1">Yes - Negotiable</option>
                                <option value="0">Fixed Price</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Deliverables Included & Notes</label>
                        <textarea name="notes" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:border-[#108a00]" placeholder="e.g. Includes 1 reel (30s), raw footage, 1 month usage rights, 3-day turnaround..."></textarea>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" @click="showCreateModal = false" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-xs">Cancel</button>
                        <button type="submit" class="px-6 py-3 bg-[#108a00] hover:bg-[#0e7700] text-white font-extrabold text-xs rounded-xl shadow-md transition">
                            Create Gig Package
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- EDIT GIG MODAL -->
        <div x-show="showEditModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
            <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-xl" @click.away="showEditModal = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-lg">Edit Gig Package</h3>
                        <p class="text-xs text-slate-500">Update pricing or deliverables for this gig</p>
                    </div>
                    <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-900 font-bold text-xl">&times;</button>
                </div>

                <form method="POST" :action="'/influencer/gigs/' + editGigData.id" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Gig Package Name / Service Type *</label>
                        <input type="text" name="rate_type" x-model="editGigData.rate_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#108a00] focus:bg-white">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Package Price (₹ INR) *</label>
                            <input type="number" name="rate_amount" x-model="editGigData.rate_amount" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-extrabold focus:outline-none focus:border-[#108a00] focus:bg-white">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Negotiable Fee?</label>
                            <select name="is_negotiable" x-model="editGigData.is_negotiable" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#108a00]">
                                <option :value="true">Yes - Negotiable</option>
                                <option :value="false">Fixed Price</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Deliverables Included & Notes</label>
                        <textarea name="notes" rows="3" x-model="editGigData.notes" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:border-[#108a00]"></textarea>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" @click="showEditModal = false" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-xs">Cancel</button>
                        <button type="submit" class="px-6 py-3 bg-[#108a00] hover:bg-[#0e7700] text-white font-extrabold text-xs rounded-xl shadow-md transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
