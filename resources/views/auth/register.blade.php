@extends('layouts.app')

@section('title', 'Join as a Brand or Influencer | Upwork-Style Signup')

@section('content')
    <section class="py-12 md:py-16 bg-slate-50 min-h-[85vh] flex items-center" x-data="{
        step: 1,
        role: 'influencer',
        agreeTerms: false
    }">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            
            <!-- STEP 1: Role Selection (Upwork Style) -->
            <div x-show="step === 1" x-transition.opacity class="space-y-8">
                <div class="text-center space-y-2">
                    <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Join as a Brand or Influencer</h1>
                    <p class="text-slate-500 text-sm">Choose how you want to experience the marketplace.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Brand Card -->
                    <div @click="role = 'brand'" 
                         :class="role === 'brand' ? 'border-[#108a00] bg-emerald-50/30 ring-2 ring-[#108a00]/20' : 'border-slate-200 bg-white hover:border-slate-300'"
                         class="p-6 rounded-3xl border-2 cursor-pointer transition-all duration-200 flex flex-col justify-between relative space-y-4 group">
                        
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#108a00] flex items-center justify-center font-extrabold text-xl">
                                <i data-lucide="building-2" class="w-6 h-6"></i>
                            </div>
                            <div :class="role === 'brand' ? 'bg-[#108a00] border-[#108a00]' : 'border-slate-300 bg-white'" 
                                 class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors">
                                <template x-if="role === 'brand'">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </template>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-black text-slate-900 text-lg leading-snug">I'm a Brand, hiring creators & talent</h3>
                            <p class="text-slate-500 text-xs mt-2 leading-relaxed">Post campaign briefs, negotiate proposals, and hire top influencers with escrow security.</p>
                        </div>
                    </div>

                    <!-- Influencer Card -->
                    <div @click="role = 'influencer'" 
                         :class="role === 'influencer' ? 'border-[#108a00] bg-emerald-50/30 ring-2 ring-[#108a00]/20' : 'border-slate-200 bg-white hover:border-slate-300'"
                         class="p-6 rounded-3xl border-2 cursor-pointer transition-all duration-200 flex flex-col justify-between relative space-y-4 group">
                        
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-pink-100 text-[#E1306C] flex items-center justify-center font-extrabold text-xl">
                                <i data-lucide="sparkles" class="w-6 h-6"></i>
                            </div>
                            <div :class="role === 'influencer' ? 'bg-[#108a00] border-[#108a00]' : 'border-slate-300 bg-white'" 
                                 class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors">
                                <template x-if="role === 'influencer'">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </template>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-black text-slate-900 text-lg leading-snug">I'm an Influencer, looking for work</h3>
                            <p class="text-slate-500 text-xs mt-2 leading-relaxed">Showcase portfolio, set commercial rate cards, apply to brand briefs, and get paid fast.</p>
                        </div>
                    </div>
                </div>

                <div class="text-center space-y-4 pt-2">
                    <button type="button" @click="step = 2" class="w-full sm:w-auto px-10 py-3.5 rounded-full font-bold bg-[#108a00] hover:bg-[#0e7700] text-white transition text-sm shadow-md">
                        <span x-text="role === 'brand' ? 'Join as a Brand' : 'Apply as an Influencer'"></span>
                    </button>

                    <div class="text-xs text-slate-500 font-medium">
                        Already have an account? <a href="{{ route('login') }}" class="text-[#108a00] font-extrabold hover:underline">Log In</a>
                    </div>
                </div>
            </div>

            <!-- STEP 2: Upwork Style Registration Form -->
            <div x-show="step === 2" x-transition.opacity class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-10 shadow-sm space-y-6 max-w-xl mx-auto">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <button type="button" @click="step = 1" class="text-xs font-bold text-slate-500 hover:text-slate-900 flex items-center space-x-1">
                        <span>&larr; Change role</span>
                    </button>
                    <span class="px-3 py-1 bg-emerald-50 text-[#108a00] border border-emerald-200 text-xs font-bold rounded-full capitalize" x-text="'Role: ' + role"></span>
                </div>

                <div class="text-center space-y-2">
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight" x-text="role === 'brand' ? 'Sign up to hire creators as a Brand' : 'Sign up to find work as an Influencer'"></h2>
                    <p class="text-slate-500 text-xs">Complete your account details to get started instantly.</p>
                </div>

                <!-- Social Sign Up Button -->
                <div class="space-y-3">
                    <a href="{{ route('auth.google') }}" class="flex items-center justify-center space-x-2.5 w-full py-3 px-4 rounded-full bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 font-bold text-xs transition shadow-xs">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Continue with Google</span>
                    </a>
                </div>

                <!-- Divider -->
                <div class="relative text-center my-4">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                    <span class="relative bg-white px-3 text-xs text-slate-400 font-semibold uppercase">or</span>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl text-xs space-y-1">
                        @foreach($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="role" :value="role">

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="First and last name" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:border-[#108a00] focus:ring-1 focus:ring-[#108a00]">
                    </div>

                    <div x-show="role === 'brand'">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Company / Brand Name *</label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Acme Studios" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:border-[#108a00] focus:ring-1 focus:ring-[#108a00]">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Work Email Address *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@company.com" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:border-[#108a00] focus:ring-1 focus:ring-[#108a00]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Mobile Contact</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+91 9876543210" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:border-[#108a00] focus:ring-1 focus:ring-[#108a00]">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password *</label>
                            <input type="password" name="password" required placeholder="8+ characters" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:border-[#108a00] focus:ring-1 focus:ring-[#108a00]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Confirm Password *</label>
                            <input type="password" name="password_confirmation" required placeholder="8+ characters" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:border-[#108a00] focus:ring-1 focus:ring-[#108a00]">
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-start space-x-3 cursor-pointer text-xs text-slate-600">
                            <input type="checkbox" x-model="agreeTerms" required class="mt-0.5 rounded border-slate-300 text-[#108a00] focus:ring-[#108a00]">
                            <span>Yes, I understand and agree to the <a href="{{ route('terms') }}" target="_blank" class="text-[#108a00] font-bold hover:underline">Terms of Service</a> and <a href="{{ route('privacy') }}" target="_blank" class="text-[#108a00] font-bold hover:underline">Privacy Policy</a>.</span>
                        </label>
                    </div>

                    <button type="submit" :disabled="!agreeTerms" :class="agreeTerms ? 'bg-[#108a00] hover:bg-[#0e7700]' : 'bg-slate-300 cursor-not-allowed'" class="w-full py-4 rounded-full font-extrabold text-white transition text-sm shadow-md mt-4">
                        Create my account
                    </button>
                </form>

                <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500 font-medium">
                    Already have an account? <a href="{{ route('login') }}" class="text-[#108a00] font-extrabold hover:underline">Log In</a>
                </div>
            </div>

        </div>
    </section>
@endsection
