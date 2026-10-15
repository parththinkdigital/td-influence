@extends('layouts.app')

@section('title', ($campaign->title ?: $campaign->name) . ' — Campaign Brief & Casting | Talent Marketplace')

@section('content')
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Hero Brief Header Card -->
            <div class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-sm relative space-y-4">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-3.5 py-1 bg-brand-50 text-brand-700 border border-brand-200 text-xs font-bold rounded-full">
                        {{ $campaign->category->name ?? 'General Category' }}
                    </span>
                    <span class="px-3.5 py-1 bg-slate-50 text-slate-700 border border-slate-200 text-xs font-medium rounded-full inline-flex items-center gap-1.5">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i> {{ $campaign->city ? $campaign->city . ' (' . ($campaign->work_mode ?? 'On-Site') . ')' : 'Remote / Any City' }}
                    </span>
                    <span class="text-xs text-slate-500 font-medium">
                        Deadline: {{ $campaign->application_deadline ? (is_string($campaign->application_deadline) ? $campaign->application_deadline : $campaign->application_deadline->format('M d, Y')) : 'Open Casting' }}
                    </span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-black font-display text-slate-900 tracking-tight leading-tight">
                    {{ $campaign->title ?: $campaign->name }}
                </h1>

                <div class="flex items-baseline space-x-2 pt-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Campaign Budget:</span>
                    <span class="text-2xl sm:text-3xl font-black text-emerald-600 font-display">
                        ₹{{ number_format($campaign->budget_max ?: $campaign->budget_min ?: $campaign->budget) }}
                    </span>
                    <span class="text-xs text-slate-500 font-bold">INR</span>
                </div>
            </div>

            <!-- Main Brief Content & Sidebar Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Overview -->
                    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <h3 class="text-lg font-bold font-display text-slate-900">Campaign Overview & Objectives</h3>
                        <p class="text-slate-600 leading-relaxed text-sm whitespace-pre-line">
                            {{ $campaign->description }}
                        </p>
                    </div>

                    <!-- Deliverables Breakdown -->
                    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <h3 class="text-lg font-bold font-display text-slate-900">Deliverables Required</h3>
                        <div class="space-y-3">
                            @forelse($campaign->deliverables as $del)
                                <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl flex items-center justify-between">
                                    <div>
                                        <span class="font-bold text-slate-900 text-sm block">{{ $del->name }}</span>
                                        <span class="text-xs text-slate-500">Format: {{ strtoupper(str_replace('_', ' ', $del->type)) }} &bull; Quantity: {{ $del->quantity }}</span>
                                    </div>
                                    <span class="text-xs px-3 py-1 bg-brand-50 text-brand-700 border border-brand-200 rounded-full font-semibold">
                                        Required
                                    </span>
                                </div>
                            @empty
                                <p class="text-slate-500 text-xs py-2">Deliverables agreed upon pitch acceptance.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Commercial Usage Rights -->
                    @if($campaign->usageRight)
                        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                            <h3 class="text-lg font-bold font-display text-slate-900">Commercial Usage Rights</h3>
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200">
                                    <span class="text-slate-500 block font-semibold">Duration</span>
                                    <span class="font-bold text-slate-900 text-sm font-display">{{ str_replace('_', ' ', $campaign->usageRight->duration ?? '12 Months') }}</span>
                                </div>
                                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200">
                                    <span class="text-slate-500 block font-semibold">Geography</span>
                                    <span class="font-bold text-slate-900 text-sm font-display">{{ $campaign->usageRight->geography ?? 'India / Worldwide' }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Sidebar: Brand Info & Pitch Box -->
                <div class="space-y-6">
                    <!-- Brand Card -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-5">
                        <span class="text-xs font-bold uppercase tracking-widest text-brand-600 font-display block">Hiring Brand</span>
                        <div class="flex items-center space-x-3.5">
                            <div class="w-12 h-12 rounded-2xl bg-brand-50 border border-brand-200 flex items-center justify-center text-brand-600 font-bold text-lg font-display">
                                {{ substr($campaign->brandProfile->company_name ?? 'B', 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm font-display">{{ $campaign->brandProfile->company_name ?? 'Verified Brand' }}</h4>
                                <span class="text-xs text-emerald-600 font-semibold inline-flex items-center gap-1"><i data-lucide="check" class="w-3.5 h-3.5 shrink-0"></i> Verified Brand Partner</span>
                            </div>
                        </div>

                        <!-- Apply Button Action -->
                        <div class="pt-2 border-t border-slate-100 space-y-3">
                            @auth
                                @if(auth()->user()->isInfluencer() || auth()->user()->isTalent())
                                    <a href="{{ route('influencer.campaigns.show', $campaign->id) }}" class="block w-full py-3.5 rounded-xl font-bold bg-brand-600 hover:bg-brand-700 text-center text-white shadow-sm transition text-sm">
                                        Submit Custom Pitch &rarr;
                                    </a>
                                @else
                                    <div class="bg-slate-50 p-3.5 rounded-xl text-center text-xs text-slate-500 border border-slate-200">
                                        Logged in as {{ ucfirst(auth()->user()->role) }}. Talent account required to pitch.
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="block w-full py-3.5 rounded-xl font-bold bg-brand-600 hover:bg-brand-700 text-center text-white shadow-sm transition text-sm">
                                    Join as Talent to Apply &rarr;
                                </a>
                                <a href="{{ route('login') }}" class="block w-full py-2 text-center text-xs text-slate-500 hover:text-slate-900 transition">
                                    Already have an account? Sign In
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Escrow Protection Badge -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm text-xs text-slate-600 space-y-2">
                        <div class="flex items-center space-x-2 text-slate-900 font-bold">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                            <span>Escrow Protected Payment</span>
                        </div>
                        <p class="leading-relaxed text-[11px] text-slate-500">
                            Brand deposits agreed campaign fee upfront. Funds are released directly to creator upon deliverable approval.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
