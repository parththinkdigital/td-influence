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
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="px-3.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold rounded-full inline-block mb-2 shadow-2xs">
                    Service Packages & Rate Card
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">My Gigs & Packages</h1>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Create, edit, and manage your standard service packages (Reels, Shoot rates, Hosting packages) that brands can hire directly.
                </p>
            </div>
            <div>
                <button @click="showCreateModal = true" class="px-6 py-3 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-2xl transition shadow-md flex items-center space-x-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Create New Gig Package</span>
                </button>
            </div>
        </div>

        <!-- Gigs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($rates as $gig)
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col justify-between space-y-5 hover:shadow-md hover:border-pink-200 transition group relative">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="px-3 py-1 bg-slate-100 text-slate-800 font-extrabold text-xs rounded-full border border-slate-200/80 uppercase tracking-wider">
                                {{ str_replace('_', ' ', $gig->rate_type) }}
                            </span>
                            @if($gig->is_negotiable)
                                <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-800 text-[10px] font-extrabold rounded-full border border-emerald-200">
                                    Negotiable
                                </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-black text-slate-900 group-hover:text-pink-600 transition capitalize font-display">
                            {{ str_replace('_', ' ', $gig->rate_type) }}
                        </h3>

                        <div class="mt-3 py-2 px-4 bg-slate-50 border border-slate-100 rounded-2xl inline-block">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Package Fee</span>
                            <span class="text-2xl font-black text-slate-900 font-display tabular-nums">₹{{ number_format($gig->rate_amount) }} <span class="text-xs font-semibold text-slate-500 font-mono">{{ $gig->currency ?: 'INR' }}</span></span>
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
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                            <span>Edit Gig</span>
                        </button>

                        <form method="POST" action="{{ route('influencer.gigs.delete', $gig->id) }}" onsubmit="return confirm('Are you sure you want to delete this Gig package?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-400 hover:text-rose-600 text-xs font-bold p-2 transition">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-3 p-16 text-center text-slate-400 bg-white rounded-3xl border border-slate-200/80 shadow-xs">
                    <div class="w-16 h-16 rounded-3xl bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <div class="font-bold text-slate-800 text-base">No service packages created yet</div>
                    <p class="text-xs text-slate-400 mt-1">Add standard rate packages (e.g. 1 Reel, 3 Story pack) so brands can send direct booking proposals.</p>
                </div>
            @endforelse
        </div>

        <!-- CREATE GIG MODAL -->
        <div x-show="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4" x-cloak>
            <div @click.away="showCreateModal = false" class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-200 p-6 sm:p-8 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-lg font-black text-slate-900 font-display">Create Service Gig Package</h3>
                    <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-900 font-bold text-xl">&times;</button>
                </div>

                <form method="POST" action="{{ route('influencer.gigs.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Package Type *</label>
                        <select name="rate_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-bold focus:bg-white focus:outline-none focus:border-slate-900 transition">
                            <option value="instagram_reel">1x Instagram 4K Reel</option>
                            <option value="story_sequence">3x Instagram Story Sequence</option>
                            <option value="carousel_post">1x Instagram Carousel Post</option>
                            <option value="youtube_dedicated">Dedicated YouTube Video</option>
                            <option value="event_hosting">Full-Day Event Hosting / Emcee</option>
                            <option value="photoshoot_lookbook">Fashion Lookbook Shoot (Full Day)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Package Fee (₹ INR) *</label>
                        <input type="number" name="rate_amount" required placeholder="10000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-mono font-bold focus:bg-white focus:outline-none focus:border-slate-900 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Package Deliverables & Description</label>
                        <textarea name="notes" rows="3" placeholder="Includes 1 revision, raw footage export, 30-day organic rights..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 transition"></textarea>
                    </div>

                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_negotiable" id="is_negotiable" value="1" checked class="rounded text-pink-600 focus:ring-pink-500">
                        <label for="is_negotiable" class="text-xs font-bold text-slate-700">Open to negotiation in chat</label>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                        <button type="button" @click="showCreateModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white rounded-xl text-xs font-bold shadow-2xs">Create Gig Package</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- EDIT GIG MODAL -->
        <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4" x-cloak>
            <div @click.away="showEditModal = false" class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-200 p-6 sm:p-8 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-lg font-black text-slate-900 font-display">Edit Service Package</h3>
                    <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-900 font-bold text-xl">&times;</button>
                </div>

                <form method="POST" :action="'/influencer/gigs/' + editGigData.id" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Package Type *</label>
                        <input type="text" name="rate_type" x-model="editGigData.rate_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-bold focus:bg-white focus:outline-none focus:border-slate-900 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Package Fee (₹ INR) *</label>
                        <input type="number" name="rate_amount" x-model="editGigData.rate_amount" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-mono font-bold focus:bg-white focus:outline-none focus:border-slate-900 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deliverables & Notes</label>
                        <textarea name="notes" x-model="editGigData.notes" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 transition"></textarea>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white rounded-xl text-xs font-bold shadow-2xs">Update Package</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
