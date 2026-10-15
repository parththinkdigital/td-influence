@extends('layouts.brand')

@section('title', 'Edit Campaign Brief | Brand Studio')

@section('content')
    <div class="max-w-3xl space-y-8">
        <div class="flex items-center justify-between border-b border-slate-200 pb-5">
            <div>
                <span class="px-3.5 py-1 bg-sky-50 text-[#0866FF] border border-blue-200 text-xs font-bold rounded-full inline-block mb-2">
                    Campaign Brief Editor
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Campaign Brief</h1>
                <p class="text-slate-600 text-sm mt-1">Update your requirement details, budget range, and location (Nashik & surrounding regions).</p>
            </div>
            <a href="{{ route('brand.campaigns') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition">
                &larr; Back to Campaigns
            </a>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs">
            <form method="POST" action="{{ route('brand.campaigns.update', $campaign->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Campaign Title *</label>
                    <input type="text" name="title" value="{{ old('title', $campaign->title) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Category *</label>
                        <select name="category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $campaign->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Campaign Type *</label>
                        <select name="campaign_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                            <option value="photoshoot" {{ $campaign->campaign_type === 'photoshoot' ? 'selected' : '' }}>Photoshoot / Modeling</option>
                            <option value="influencer_campaign" {{ $campaign->campaign_type === 'influencer_campaign' ? 'selected' : '' }}>Influencer Reel / Post</option>
                            <option value="ugc" {{ $campaign->campaign_type === 'ugc' ? 'selected' : '' }}>UGC Video Ads</option>
                            <option value="hosting" {{ $campaign->campaign_type === 'hosting' ? 'selected' : '' }}>Event Hosting / Emcee</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Target Talent Type *</label>
                        <select name="talent_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                            <option value="influencer" {{ $campaign->talent_type === 'influencer' ? 'selected' : '' }}>Digital Influencer</option>
                            <option value="model" {{ $campaign->talent_type === 'model' ? 'selected' : '' }}>Commercial Model</option>
                            <option value="anchor" {{ $campaign->talent_type === 'anchor' ? 'selected' : '' }}>Event & TV Anchor</option>
                            <option value="ugc_creator" {{ $campaign->talent_type === 'ugc_creator' ? 'selected' : '' }}>UGC Video Creator</option>
                            <option value="any" {{ $campaign->talent_type === 'any' ? 'selected' : '' }}>Any Creator Type</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">City / Location</label>
                        <input type="text" name="city" value="{{ old('city', $campaign->city ?: 'Nashik') }}" placeholder="e.g. Nashik, Maharashtra" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Minimum Budget (₹ INR) *</label>
                        <input type="number" name="budget_min" value="{{ old('budget_min', $campaign->budget_min) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-extrabold text-slate-900 focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Maximum Budget (₹ INR) *</label>
                        <input type="number" name="budget_max" value="{{ old('budget_max', $campaign->budget_max) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-extrabold text-slate-900 focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Campaign Description & Requirements *</label>
                    <textarea name="description" rows="5" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">{{ old('description', $campaign->description) }}</textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('brand.campaigns') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-xs transition">Cancel</a>
                    <button type="submit" class="px-8 py-3.5 bg-[#0866FF] hover:bg-[#0052CC] text-white font-extrabold text-xs rounded-xl shadow-md transition">
                        Save Campaign Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
