@extends('layouts.app')

@section('title', ($campaign->title ?: $campaign->name) . ' — Campaign Brief & Casting | HypeMarket')

@section('content')
    <div class="py-10 lg:py-14 relative min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Breadcrumbs -->
            <div class="flex items-center space-x-2 text-xs font-mono font-bold text-[#524B66]">
                <a href="{{ route('campaigns.public') }}" class="hover:text-[#FF3E14] transition">&larr; All Campaign Briefs</a>
                <span>/</span>
                <span class="text-[#181528] truncate">{{ $campaign->title ?: $campaign->name }}</span>
            </div>

            <!-- Hero Brief Header Card -->
            <div class="bg-white p-6 sm:p-10 rounded-[32px] border-2 border-[#181528] shadow-[8px_8px_0_#E2F163] relative space-y-5 text-left">
                <div class="flex flex-wrap items-center gap-2.5">
                    <span class="px-3.5 py-1 bg-[#FAF5EC] text-[#181528] border-2 border-[#181528] text-xs font-mono font-black rounded-full shadow-[2px_2px_0_#181528]">
                        {{ $campaign->category->name ?? 'General Category' }}
                    </span>
                    <span class="px-3.5 py-1 bg-[#EAF5FE] text-[#0E4875] border-2 border-[#181528] text-xs font-mono font-bold rounded-full inline-flex items-center gap-1.5 shadow-[1.5px_1.5px_0_#181528]">
                        <i class="fa-solid fa-location-dot text-[#FF3E14]"></i>
                        <span>{{ $campaign->city ? $campaign->city . ' (' . ($campaign->work_mode ?? 'On-Site') . ')' : 'Remote / Any City' }}</span>
                    </span>
                    <span class="px-3.5 py-1 bg-[#FFF9AA] text-[#181528] border-2 border-[#181528] text-xs font-mono font-bold rounded-full shadow-[1.5px_1.5px_0_#181528]">
                        <i class="fa-solid fa-clock text-[#FF3E14]"></i>
                        <span>Deadline: {{ $campaign->application_deadline ? (is_string($campaign->application_deadline) ? $campaign->application_deadline : $campaign->application_deadline->format('M d, Y')) : 'Open Casting' }}</span>
                    </span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black font-display text-[#181528] tracking-tight leading-tight">
                    {{ $campaign->title ?: $campaign->name }}
                </h1>

                <div class="flex flex-wrap items-center justify-between gap-4 pt-3 border-t-2 border-[#181528]/10">
                    <div class="flex items-baseline space-x-2">
                        <span class="text-xs font-mono font-bold text-[#524B66] uppercase tracking-wider">Campaign Budget:</span>
                        <span class="text-3xl sm:text-4xl font-black text-[#181528] font-display">
                            ₹{{ number_format((float) ($campaign->budget_max ?: ($campaign->budget_min ?: ($campaign->budget ?: 0)))) }}
                        </span>
                        <span class="text-xs font-mono font-bold text-[#FF3E14]">INR (Escrow Guaranteed)</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 text-xs font-mono font-bold text-[#064E3B] bg-[#E6F9F2] border-2 border-[#181528] px-3 py-1 rounded-full shadow-[2px_2px_0_#181528]">
                            <i class="fa-solid fa-shield-halved text-[#10B981]"></i>
                            <span>100% Pre-funded Escrow</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Brief Content & Sidebar Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Details -->
                <div class="lg:col-span-2 space-y-6 text-left">
                    <!-- Overview -->
                    <div class="bg-white p-6 sm:p-8 rounded-[32px] border-2 border-[#181528] shadow-[6px_6px_0_#181528] space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-xl bg-[#FAF5EC] border-2 border-[#181528] flex items-center justify-center text-[#FF3E14] text-xs">
                                <i class="fa-solid fa-file-lines"></i>
                            </span>
                            <h3 class="text-lg font-black font-display text-[#181528]">Campaign Overview &amp; Objectives</h3>
                        </div>
                        <p class="text-[#524B66] leading-relaxed text-sm font-sans whitespace-pre-line">
                            {{ $campaign->description }}
                        </p>
                    </div>

                    <!-- Deliverables Breakdown -->
                    <div class="bg-white p-6 sm:p-8 rounded-[32px] border-2 border-[#181528] shadow-[6px_6px_0_#181528] space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-xl bg-[#FAF5EC] border-2 border-[#181528] flex items-center justify-center text-[#FF3E14] text-xs">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </span>
                            <h3 class="text-lg font-black font-display text-[#181528]">Deliverables Required</h3>
                        </div>
                        <div class="space-y-3">
                            @forelse($campaign->deliverables as $del)
                                <div class="bg-[#FAF5EC] border-2 border-[#181528] p-4 rounded-2xl flex items-center justify-between shadow-[2px_2px_0_#181528]">
                                    <div>
                                        <span class="font-black text-[#181528] text-sm block font-display">{{ $del->name }}</span>
                                        <span class="text-xs font-mono font-bold text-[#524B66]">Format: {{ strtoupper(str_replace('_', ' ', $del->type)) }} &bull; Quantity: {{ $del->quantity }}</span>
                                    </div>
                                    <span class="text-xs px-3 py-1 bg-[#E2F163] text-[#181528] border-2 border-[#181528] rounded-full font-mono font-black shadow-[1.5px_1.5px_0_#181528]">
                                        Required
                                    </span>
                                </div>
                            @empty
                                <p class="text-[#524B66] font-mono text-xs py-2">Deliverables agreed upon custom pitch acceptance.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Commercial Usage Rights -->
                    @if($campaign->usageRight)
                        <div class="bg-white p-6 sm:p-8 rounded-[32px] border-2 border-[#181528] shadow-[6px_6px_0_#181528] space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-xl bg-[#FAF5EC] border-2 border-[#181528] flex items-center justify-center text-[#FF3E14] text-xs">
                                    <i class="fa-solid fa-copyright"></i>
                                </span>
                                <h3 class="text-lg font-black font-display text-[#181528]">Commercial Usage Rights</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                <div class="bg-[#FAF5EC] p-4 rounded-2xl border-2 border-[#181528] shadow-[2px_2px_0_#181528]">
                                    <span class="text-[#524B66] font-mono font-bold block mb-1">Duration</span>
                                    <span class="font-black text-[#181528] text-sm font-display">{{ str_replace('_', ' ', $campaign->usageRight->duration ?? '12 Months') }}</span>
                                </div>
                                <div class="bg-[#FAF5EC] p-4 rounded-2xl border-2 border-[#181528] shadow-[2px_2px_0_#181528]">
                                    <span class="text-[#524B66] font-mono font-bold block mb-1">Geography</span>
                                    <span class="font-black text-[#181528] text-sm font-display">{{ $campaign->usageRight->geography ?? 'India / Worldwide' }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Sidebar: Brand Info & Pitch Box -->
                <div class="space-y-6 text-left">
                    <!-- Brand Card -->
                    <div class="bg-white p-6 rounded-[32px] border-2 border-[#181528] shadow-[6px_6px_0_#F47FA2] space-y-5">
                        <span class="text-xs font-mono font-black uppercase tracking-wider text-[#FF3E14] block">Hiring Brand</span>
                        <div class="flex items-center space-x-3.5">
                            <div class="w-14 h-14 rounded-2xl bg-[#E2F163] border-2 border-[#181528] flex items-center justify-center text-[#181528] font-black text-xl font-display shadow-[2px_2px_0_#181528]">
                                {{ substr($campaign->brandProfile->company_name ?? 'B', 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-black text-[#181528] text-base font-display leading-tight">{{ $campaign->brandProfile->company_name ?? 'Verified Brand' }}</h4>
                                <span class="text-xs font-mono font-bold text-[#10B981] inline-flex items-center gap-1 mt-0.5">
                                    <i class="fa-solid fa-circle-check"></i> Verified Partner
                                </span>
                            </div>
                        </div>

                        <!-- Apply Button Action -->
                        <div class="pt-2 border-t-2 border-[#181528]/10 space-y-3">
                            @auth
                                @if(auth()->user()->isInfluencer() || auth()->user()->isTalent())
                                    <a href="{{ route('influencer.campaigns.show', $campaign->id) }}" class="hm-btn block w-full py-3.5 rounded-2xl font-black font-display bg-[#E2F163] hover:bg-[#D4E64A] text-[#181528] border-2 border-[#181528] text-center shadow-[4px_4px_0_#181528] transition text-sm">
                                        Submit Custom Pitch &rarr;
                                    </a>
                                @else
                                    <div class="bg-[#FAF5EC] p-3.5 rounded-2xl text-center text-xs font-mono font-bold text-[#524B66] border-2 border-[#181528]">
                                        Logged in as {{ ucfirst(auth()->user()->role) }}. Creator account required to pitch.
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="hm-btn block w-full py-3.5 rounded-2xl font-black font-display bg-[#181528] hover:bg-[#FF3E14] text-white text-center shadow-[4px_4px_0_#E2F163] border-2 border-[#181528] transition text-sm">
                                    Join As Creator to Pitch &rarr;
                                </a>
                                <a href="{{ route('login') }}" class="block w-full py-2 text-center text-xs font-mono font-bold text-[#524B66] hover:text-[#181528] transition">
                                    Already have an account? Sign In
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Escrow Protection Badge Box -->
                    <div class="bg-white p-6 rounded-[32px] border-2 border-[#181528] shadow-[4px_4px_0_#181528] text-xs text-[#524B66] space-y-2.5">
                        <div class="flex items-center space-x-2 text-[#181528] font-black font-display text-sm">
                            <i class="fa-solid fa-shield-halved text-[#10B981] text-base"></i>
                            <span>Escrow Protected Collaboration</span>
                        </div>
                        <p class="leading-relaxed text-xs font-sans text-[#524B66]">
                            The hiring brand pre-funds agreed campaign milestones into secure escrow before any deliverables or shoots commence. Payouts are released directly to your wallet upon brief completion.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
