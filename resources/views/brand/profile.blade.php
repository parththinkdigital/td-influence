@extends('layouts.brand')

@section('title', 'Company Profile & Logo | Brand Studio')

@section('content')
    <div class="max-w-3xl space-y-8" x-data="{ logoUrl: '{{ old('logo', $brandProfile->logo ?: auth()->user()->avatar) }}' }">
        <div class="flex items-center justify-between border-b border-slate-200 pb-5">
            <div>
                <span class="px-3.5 py-1 bg-sky-50 text-[#0866FF] border border-blue-200 text-xs font-bold rounded-full inline-block mb-2">
                    Brand Identity & Settings
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Company Profile & Studio Settings</h1>
                <p class="text-slate-600 text-sm mt-1">Manage brand logo, industry vertical, contact person, and official headquarters in or around Nashik.</p>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs">
            <form method="POST" action="{{ route('brand.profile') }}" class="space-y-6">
                @csrf
                
                <!-- Logo / Avatar Preview & Input -->
                <div class="bg-slate-50 border border-slate-200 p-5 rounded-2xl flex flex-col sm:flex-row items-center gap-5">
                    <div class="w-20 h-20 rounded-2xl bg-white border border-slate-200 shadow-xs flex items-center justify-center overflow-hidden flex-shrink-0">
                        <template x-if="logoUrl">
                            <img :src="logoUrl" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!logoUrl">
                            <i data-lucide="building-2" class="w-8 h-8 text-slate-400"></i>
                        </template>
                    </div>

                    <div class="flex-grow w-full">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Brand Logo / Avatar Image URL</label>
                        <input type="url" name="logo" x-model="logoUrl" placeholder="https://images.unsplash.com/... or company logo URL" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF] focus:ring-2 focus:ring-blue-500/10 transition">
                        <span class="text-[11px] text-slate-400 mt-1 block">Displayed on your campaign briefs, contracts, and talent invites.</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Company / Brand Name *</label>
                        <input type="text" name="company_name" value="{{ old('company_name', $brandProfile->company_name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Industry Vertical</label>
                        <select name="industry_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                            <option value="">Select Industry</option>
                            @foreach($industries as $ind)
                                <option value="{{ $ind->id }}" {{ $brandProfile->industry_id == $ind->id ? 'selected' : '' }}>{{ $ind->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Official Website</label>
                        <input type="url" name="website" value="{{ old('website', $brandProfile->website) }}" placeholder="https://example.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Headquarters / Location</label>
                        <input type="text" name="headquarters" value="{{ old('headquarters', $brandProfile->headquarters ?: 'College Road, Nashik, Maharashtra') }}" placeholder="e.g. College Road, Nashik / Maharashtra" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Company Description & Mission</label>
                    <textarea name="description" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition" placeholder="Briefly describe your company, target audience, and campaign style...">{{ old('description', $brandProfile->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Contact Person Name</label>
                        <input type="text" name="contact_person" value="{{ old('contact_person', $brandProfile->contact_person) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Contact Phone</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $brandProfile->contact_phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-8 py-3.5 bg-[#0866FF] hover:bg-[#0052CC] text-white font-extrabold rounded-2xl text-xs shadow-md transition">
                        Save Profile & Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
