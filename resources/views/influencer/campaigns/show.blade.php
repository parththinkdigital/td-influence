@extends('layouts.influencer')

@section('title', $campaign->name . ' | Apply in Studio')

@section('content')
    <div class="max-w-5xl space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs">
            <div>
                <span class="px-3 py-1 bg-pink-50 text-[#E1306C] border border-pink-200 text-xs font-bold rounded-full mb-3 inline-block">
                    {{ $campaign->category->name ?? 'General Category' }}
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $campaign->name }}</h1>
                <p class="text-[#0866FF] font-black text-2xl mt-1">₹{{ number_format($campaign->budget) }} <span class="text-xs text-slate-500 font-semibold">INR Budget</span></p>
            </div>
            <a href="{{ route('influencer.campaigns') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition border border-slate-200 self-start md:self-auto">
                &larr; Back to Job Briefs
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Overview -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs">
                    <h3 class="text-lg font-bold text-slate-900 mb-3">Brief Overview & Guidelines</h3>
                    <p class="text-slate-600 text-sm whitespace-pre-line leading-relaxed">{{ $campaign->description }}</p>
                </div>

                <!-- Deliverables -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Required Deliverables</h3>
                    <div class="space-y-3">
                        @foreach($campaign->deliverables as $del)
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex items-center justify-between">
                                <div>
                                    <span class="font-bold text-slate-900 text-sm block">{{ $del->name }}</span>
                                    <span class="text-xs text-slate-500 font-medium">Type: <span class="uppercase font-bold text-slate-700">{{ $del->type }}</span> (Qty: {{ $del->quantity }})</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Application Form -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs">
                    <h3 class="text-xl font-black text-slate-900 mb-1">Submit Your Pitch</h3>
                    <p class="text-slate-500 text-xs mb-6">Propose your rate and creative concept directly to the brand team.</p>

                    @if($existingApplication)
                        <div class="bg-emerald-50 border border-emerald-200 p-5 rounded-2xl text-emerald-900 text-xs space-y-2">
                            <div class="font-bold text-sm text-emerald-800 flex items-center space-x-2">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Pitch Submitted Successfully</span>
                            </div>
                            <div>Quoted Rate: <strong class="text-slate-900">₹{{ number_format($existingApplication->quoted_price) }} INR</strong></div>
                            <div>Status: <strong class="uppercase text-[#0866FF] font-bold">{{ $existingApplication->status }}</strong></div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('influencer.campaigns.apply', $campaign->id) }}" class="space-y-5">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Quoted Rate (₹ INR)</label>
                                <input type="number" step="0.01" name="quoted_price" value="{{ old('quoted_price', $campaign->budget) }}" required class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-[#0866FF]">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Pitch & Creative Concept</label>
                                <textarea name="cover_note" rows="4" required class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-[#0866FF]" placeholder="Explain how you will feature the product and engage your audience..."></textarea>
                            </div>

                            <button type="submit" class="w-full py-4 rounded-xl font-bold bg-[#0866FF] hover:bg-[#0052CC] text-white transition text-sm shadow-md shadow-blue-500/20">
                                Submit Pitch to Brand
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs space-y-3">
                    <span class="text-[11px] font-bold uppercase text-slate-400">Brand Information</span>
                    <h4 class="font-extrabold text-slate-900 text-base">{{ $campaign->brandProfile->company_name ?? 'Verified Brand' }}</h4>
                    <p class="text-xs text-slate-500">{{ $campaign->brandProfile->location ?: 'Global Location' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
