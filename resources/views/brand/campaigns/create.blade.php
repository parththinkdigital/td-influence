@extends('layouts.brand')

@section('title', 'Post Job / Requirement | Brand Studio')

@section('content')
    <div class="max-w-4xl space-y-8" x-data="{
        campaignType: 'photoshoot',
        deliverables: [{ name: 'High-Res Edited Photos', type: 'photo_pack', quantity: 10 }],
        questions: ['Have you worked with fashion & lifestyle brands in or around Nashik/Maharashtra before?']
    }">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <span class="px-3.5 py-1 bg-sky-50 text-[#0866FF] border border-blue-200 text-xs font-bold rounded-full inline-block mb-2">
                    Create New Requirement
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Post Campaign Brief & Casting Call</h1>
                <p class="text-slate-600 text-sm mt-1">Specify your campaign objective, talent criteria, shoot location, and budget.</p>
            </div>
            <a href="{{ route('brand.campaigns') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition">
                &larr; Back to Campaigns
            </a>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-10 shadow-xs">
            <form method="POST" action="{{ route('brand.campaigns') }}" class="space-y-8">
                @csrf

                <!-- Section 1: Campaign Details -->
                <div class="space-y-4">
                    <h3 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-3 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-sky-100 text-[#0866FF] flex items-center justify-center text-xs font-bold">1</span>
                        <span>Campaign Overview & Type</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Job / Campaign Title *</label>
                            <input type="text" name="title" required placeholder="e.g. Sula Vineyard Lookbook Photoshoot" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold placeholder-slate-400 focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Campaign Name *</label>
                            <input type="text" name="campaign_name" required placeholder="e.g. Aura Festiva 2026" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold placeholder-slate-400 focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Marketplace Category *</label>
                            <select name="category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Campaign Format Type *</label>
                            <select name="campaign_type" x-model="campaignType" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                                <option value="photoshoot">Photoshoot / Modeling</option>
                                <option value="video_shoot">Commercial Video Shoot</option>
                                <option value="influencer_campaign">Instagram & YouTube Influencer Post</option>
                                <option value="event">Event Hosting & Anchor</option>
                                <option value="ugc">UGC Video Ad Pack</option>
                                <option value="tv_ott">TV / OTT Commercial</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Brief & Objective *</label>
                        <textarea name="description" rows="3" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm placeholder-slate-400 focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition" placeholder="Detail your campaign objective, moodboard guidelines, aesthetic style, and creator expectations..."></textarea>
                    </div>
                </div>

                <!-- Section 2: Talent Requirements -->
                <div class="space-y-4 pt-6 border-t border-slate-100">
                    <h3 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-3 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-sky-100 text-[#0866FF] flex items-center justify-center text-xs font-bold">2</span>
                        <span>Talent Specifications & Criteria</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Talent Role</label>
                            <select name="talent_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                                <option value="model">Fashion Model</option>
                                <option value="influencer">Digital Influencer</option>
                                <option value="anchor">Event Anchor / Emcee</option>
                                <option value="ugc_creator">UGC Video Creator</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Gender Preference</label>
                            <select name="gender_req" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                                <option value="any">Any Gender</option>
                                <option value="female">Female</option>
                                <option value="male">Male</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Creators Needed</label>
                            <input type="number" name="number_required" value="1" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-bold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4" x-show="campaignType === 'photoshoot'">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Min Height (cm)</label>
                            <input type="number" name="height_min_cm" placeholder="170" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Max Height (cm)</label>
                            <input type="number" name="height_max_cm" placeholder="182" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Age Min</label>
                            <input type="number" name="age_min" placeholder="18" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Age Max</label>
                            <input type="number" name="age_max" placeholder="32" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Location & Schedule (In and around Nashik) -->
                <div class="space-y-4 pt-6 border-t border-slate-100">
                    <h3 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-3 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-sky-100 text-[#0866FF] flex items-center justify-center text-xs font-bold">3</span>
                        <span>Shoot Location & Dates (Nashik & Surrounding Regions)</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Work Mode</label>
                            <select name="work_mode" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                                <option value="on_site">On-Site Shoot</option>
                                <option value="remote">Remote / UGC Content</option>
                                <option value="hybrid">Hybrid (Local Shoot + Reel)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">City / Region *</label>
                            <input type="text" name="city" value="Nashik" placeholder="e.g. Nashik / College Road / Gangapur Road" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Venue / Studio Location</label>
                            <input type="text" name="venue" placeholder="e.g. Sula Vineyards Studio / College Road Studio" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Shoot Date</label>
                            <input type="date" name="shoot_date" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Call Time</label>
                            <input type="text" name="call_time" placeholder="08:30 AM" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Application Deadline</label>
                            <input type="date" name="application_deadline" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                        </div>
                    </div>
                </div>

                <!-- Section 4: Budget & Commercials -->
                <div class="space-y-4 pt-6 border-t border-slate-100">
                    <h3 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-3 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-sky-100 text-[#0866FF] flex items-center justify-center text-xs font-bold">4</span>
                        <span>Campaign Budget & Escrow (₹ INR)</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Budget Type</label>
                            <select name="budget_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                                <option value="fixed">Fixed Budget</option>
                                <option value="hourly">Hourly Rate</option>
                                <option value="negotiable">Open to Proposals</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Min Budget (₹ INR) *</label>
                            <input type="number" name="budget_min" required placeholder="30000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-extrabold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Max Budget (₹ INR) *</label>
                            <input type="number" name="budget_max" required placeholder="60000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-extrabold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                        </div>
                    </div>
                </div>

                <!-- Section 5: Deliverables & Usage Rights -->
                <div class="space-y-4 pt-6 border-t border-slate-100">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-sky-100 text-[#0866FF] flex items-center justify-center text-xs font-bold">5</span>
                            <span>Deliverables & Usage Rights</span>
                        </h3>
                        <button type="button" @click="deliverables.push({ name: '', type: 'reel', quantity: 1 })" class="text-xs text-[#0866FF] font-bold hover:underline">
                            + Add Deliverable
                        </button>
                    </div>

                    <template x-for="(d, idx) in deliverables" :key="idx">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 bg-slate-50 p-3.5 rounded-2xl border border-slate-200 items-center">
                            <div class="sm:col-span-6">
                                <input type="text" :name="'deliverable_names[' + idx + ']'" x-model="d.name" placeholder="Deliverable name (e.g. 1x Reel + 5 Edited Photos)" class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF]">
                            </div>
                            <div class="sm:col-span-4">
                                <select :name="'deliverable_types[' + idx + ']'" x-model="d.type" class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF]">
                                    <option value="photo_pack">High-Res Photos Pack</option>
                                    <option value="reel">Instagram Reel</option>
                                    <option value="story">Instagram Story</option>
                                    <option value="youtube_video">YouTube Video</option>
                                    <option value="event_duration">Event Hosting Hours</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <input type="number" min="1" :name="'deliverable_quantities[' + idx + ']'" x-model="d.quantity" class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs text-slate-900 font-bold focus:outline-none focus:border-[#0866FF]">
                            </div>
                        </div>
                    </template>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Commercial Usage Duration</label>
                            <select name="usage_duration" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                                <option value="3_months">3 Months</option>
                                <option value="6_months">6 Months</option>
                                <option value="12_months">12 Months</option>
                                <option value="perpetual">Perpetual</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Licensing Geography</label>
                            <select name="geography" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                                <option value="India">India</option>
                                <option value="Maharashtra">Maharashtra / Local Region</option>
                                <option value="international">Worldwide / Digital Ad Rights</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Exclusivity</label>
                            <select name="exclusivity" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white transition">
                                <option value="none">None</option>
                                <option value="category">Category Exclusive</option>
                                <option value="full">Full Exclusivity</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('brand.campaigns') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-4 rounded-xl font-black bg-brand-600 hover:bg-brand-700 text-white transition text-sm shadow-md shadow-indigo-500/20">
                        Publish Requirement to Marketplace &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
