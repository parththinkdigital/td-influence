@extends('layouts.brand')

@section('title', 'Post Job / Requirement | Brand Studio')

@section('content')
    <div class="max-w-4xl space-y-8" x-data="{
        campaignType: 'influencer_campaign',
        deliverables: [
            { name: '1x Instagram 4K Reel (30-60s)', type: 'instagram_reel', quantity: 1 },
            { name: '3x Story Sequence with Link', type: 'story_sequence', quantity: 3 }
        ],
        addDeliverable() {
            this.deliverables.push({ name: '', type: 'instagram_reel', quantity: 1 });
        },
        removeDeliverable(index) {
            this.deliverables.splice(index, 1);
        },
        presetReel() {
            this.deliverables = [
                { name: '1x Instagram 4K Reel (30-60s)', type: 'instagram_reel', quantity: 1 },
                { name: '3x Story Sequence with Link', type: 'story_sequence', quantity: 3 }
            ];
        },
        presetPhoto() {
            this.deliverables = [
                { name: 'High-Res Edited Fashion Lookbook', type: 'photo_pack', quantity: 10 },
                { name: '1x Behind The Scenes Reel', type: 'instagram_reel', quantity: 1 }
            ];
        },
        presetAnchor() {
            this.deliverables = [
                { name: 'Event Hosting & Emcee (Full Day)', type: 'event_hosting', quantity: 1 },
                { name: 'Pre-Event Story Promo Announcement', type: 'story_sequence', quantity: 2 }
            ];
        }
    }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200/80 pb-5">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    <span>Campaign Brief Studio</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Post Campaign Brief & Casting Call</h1>
                <p class="text-slate-500 text-sm mt-1">Specify campaign objectives, creative deliverables, usage rights, and budget range.</p>
            </div>
            <a href="{{ route('brand.campaigns') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition inline-flex items-center gap-1.5 shadow-2xs">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Back to Campaigns</span>
            </a>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-10 shadow-xs">
            <form method="POST" action="{{ route('brand.campaigns') }}" class="space-y-8">
                @csrf

                <!-- Section 1: Campaign Details -->
                <div class="space-y-4">
                    <h3 class="text-xs font-black text-slate-900 border-b border-slate-100 pb-3 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center text-xs font-black">1</span>
                        <span>Campaign Overview & Vertical</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Campaign Headline / Job Title *</label>
                            <input type="text" name="title" required placeholder="e.g. Sula Vineyard Lookbook Photoshoot" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold placeholder-slate-400 focus:outline-none focus:border-indigo-600 focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Campaign / Collection Code *</label>
                            <input type="text" name="campaign_name" required placeholder="e.g. Aura Festiva 2026" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold placeholder-slate-400 focus:outline-none focus:border-indigo-600 focus:bg-white transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Vertical Niche *</label>
                            <select name="category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-indigo-600 focus:bg-white transition">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Campaign Format *</label>
                            <select name="campaign_type" x-model="campaignType" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-indigo-600 focus:bg-white transition">
                                <option value="influencer_campaign">Instagram & YouTube Creator Collaboration</option>
                                <option value="photoshoot">Fashion Lookbook & Modeling Photoshoot</option>
                                <option value="event">Live Event Emcee & Anchor</option>
                                <option value="ugc">UGC Video Ad Pack (Performance Marketing)</option>
                                <option value="video_shoot">Commercial TVC / Video Production</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Brief & Moodboard Guidelines *</label>
                        <textarea name="description" rows="3" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm placeholder-slate-400 focus:outline-none focus:border-indigo-600 focus:bg-white transition" placeholder="Detail your campaign objective, moodboard guidelines, aesthetic style, and creator expectations..."></textarea>
                    </div>
                </div>

                <!-- Section 2: Deliverables Blueprint -->
                <div class="space-y-4 pt-6 border-t border-slate-100">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center text-xs font-black">2</span>
                            <span>Deliverables Package</span>
                        </h3>
                        <div class="flex items-center space-x-1.5 text-xs">
                            <span class="text-slate-400 text-[11px] font-bold">Presets:</span>
                            <button type="button" @click="presetReel()" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-bold">Reels Pack</button>
                            <button type="button" @click="presetPhoto()" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-bold">Photoshoot</button>
                            <button type="button" @click="presetAnchor()" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-bold">Anchor</button>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(del, idx) in deliverables" :key="idx">
                            <div class="flex items-center space-x-3 bg-slate-50 p-3.5 rounded-2xl border border-slate-200/80">
                                <div class="flex-grow">
                                    <input type="text" :name="'deliverables[' + idx + '][name]'" x-model="del.name" placeholder="Deliverable name (e.g. 1x Reel 30-60s)" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-900 focus:outline-none focus:border-indigo-600 transition">
                                </div>
                                <div class="w-44">
                                    <select :name="'deliverables[' + idx + '][type]'" x-model="del.type" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:outline-none focus:border-indigo-600 transition">
                                        <option value="instagram_reel">Instagram Reel</option>
                                        <option value="story_sequence">Instagram Story</option>
                                        <option value="photo_pack">Photo Pack</option>
                                        <option value="youtube_dedicated">YouTube Dedicated</option>
                                        <option value="event_hosting">Event Hosting</option>
                                    </select>
                                </div>
                                <div class="w-20">
                                    <input type="number" :name="'deliverables[' + idx + '][quantity]'" x-model="del.quantity" min="1" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-center text-slate-900 focus:outline-none focus:border-indigo-600 transition">
                                </div>
                                <button type="button" @click="removeDeliverable(idx)" class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    <button type="button" @click="addDeliverable()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Add Deliverable Item</span>
                    </button>
                </div>

                <!-- Section 3: Commercial Terms & Budget -->
                <div class="space-y-4 pt-6 border-t border-slate-100">
                    <h3 class="text-xs font-black text-slate-900 border-b border-slate-100 pb-3 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center text-xs font-black">3</span>
                        <span>Budget, Location & Timelines</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Minimum Budget (₹ INR) *</label>
                            <input type="number" name="budget_min" required placeholder="5000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-mono font-bold focus:outline-none focus:border-indigo-600 focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Maximum Budget (₹ INR) *</label>
                            <input type="number" name="budget_max" required placeholder="25000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-mono font-bold focus:outline-none focus:border-indigo-600 focus:bg-white transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Location / City</label>
                            <input type="text" name="city" placeholder="Nashik, Maharashtra" value="Nashik" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-xs font-bold focus:bg-white focus:outline-none focus:border-indigo-600 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Work Mode</label>
                            <select name="work_mode" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-xs font-bold focus:bg-white focus:outline-none focus:border-indigo-600 transition">
                                <option value="on_site">On-Site Shoot / Event</option>
                                <option value="remote">Remote Content Shipping (Courier)</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Shoot / Target Date</label>
                            <input type="date" name="shoot_date" value="{{ now()->addDays(7)->format('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-xs font-bold focus:bg-white focus:outline-none focus:border-indigo-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('brand.campaigns') }}" class="px-5 py-3 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition">Cancel</a>
                    <button type="submit" class="px-8 py-3.5 rounded-xl font-black bg-indigo-600 hover:bg-indigo-700 text-white transition text-xs shadow-md inline-flex items-center gap-2">
                        <i class="fa-solid fa-rocket"></i>
                        <span>Publish Campaign & Open Casting Call</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
