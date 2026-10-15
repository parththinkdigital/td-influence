@extends('layouts.influencer')

@section('title', 'Creator Onboarding Setup | Talent Studio')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8" x-data="{
        step: 1,
        displayName: '{{ auth()->user()->name }}',
        email: '{{ auth()->user()->email }}',
        phone: '{{ auth()->user()->phone ?? '' }}',
        password: '',
        password_confirmation: '',
        gender: '{{ $profile->gender ?? 'female' }}',
        city: '{{ $profile->city ?? 'Nashik' }}',
        state: '{{ $profile->state ?? 'Maharashtra' }}',
        country: '{{ $profile->country ?? 'India' }}',
        specialization: 'influencer',
        selectedCategories: ['Fashion & Lifestyle'],
        instagramHandle: '',
        instagramFollowers: 25000,
        youtubeHandle: '',
        youtubeSubscribers: 10000,
        heightCm: '168',
        clothingSize: 'M',
        selectedLanguages: ['English', 'Hindi'],
        bio: '{{ $profile->bio ?? 'Digital creator & commercial model specializing in high-engagement brand campaigns, authentic reviews, and visual storytelling.' }}',
        startingRate: 15000,
        rateType: 'instagram_reel',
        toggleCategory(cat) {
            if (this.selectedCategories.includes(cat)) {
                if (this.selectedCategories.length > 1) {
                    this.selectedCategories = this.selectedCategories.filter(c => c !== cat);
                }
            } else {
                this.selectedCategories.push(cat);
            }
        },
        toggleLanguage(lang) {
            if (this.selectedLanguages.includes(lang)) {
                if (this.selectedLanguages.length > 1) {
                    this.selectedLanguages = this.selectedLanguages.filter(l => l !== lang);
                }
            } else {
                this.selectedLanguages.push(lang);
            }
        }
    }">
        <!-- Progress Header -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <span class="px-3.5 py-1 bg-pink-50 text-[#E1306C] border border-pink-200 text-xs font-bold rounded-full inline-block mb-2">
                        Creator Profile Setup
                    </span>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Complete Your Creator Profile</h1>
                    <p class="text-slate-600 text-sm mt-1">Setup your verified talent card step-by-step to start pitching and getting hired by brands.</p>
                </div>
                <div class="bg-slate-100 px-5 py-2.5 rounded-2xl border border-slate-200 text-center self-start md:self-auto">
                    <span class="block text-[10px] text-slate-500 font-bold uppercase tracking-wider">Completion</span>
                    <span class="text-xl font-black text-[#0866FF]" x-text="step * 20 + '%'"></span>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden p-0.5 border border-slate-200">
                <div class="bg-gradient-to-r from-[#E1306C] via-purple-600 to-[#0866FF] h-2 rounded-full transition-all duration-500" :style="'width: ' + (step * 20) + '%'"></div>
            </div>

            <!-- Step Indicators -->
            <div class="grid grid-cols-5 gap-2 mt-6 text-center text-xs font-extrabold">
                <div :class="step >= 1 ? 'text-[#E1306C]' : 'text-slate-400'" class="transition-colors">1. Account</div>
                <div :class="step >= 2 ? 'text-[#E1306C]' : 'text-slate-400'" class="transition-colors">2. Role & Niche</div>
                <div :class="step >= 3 ? 'text-[#E1306C]' : 'text-slate-400'" class="transition-colors">3. Social Reach</div>
                <div :class="step >= 4 ? 'text-[#E1306C]' : 'text-slate-400'" class="transition-colors">4. Pitch Specs</div>
                <div :class="step >= 5 ? 'text-[#E1306C]' : 'text-slate-400'" class="transition-colors">5. Rate & Preview</div>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('influencer.onboarding.save') }}" class="space-y-8">
            @csrf

            <!-- STEP 1: Account, Email, Contact & Password -->
            <div x-show="step === 1" x-transition.opacity class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#E1306C]">Step 1 of 5</span>
                        <h2 class="text-2xl font-black text-slate-900 mt-1">Account & Contact Verification</h2>
                    </div>
                    <span class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center"><i data-lucide="user" class="w-6 h-6"></i></span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Full Name / Stage Name *</label>
                        <input type="text" name="display_name" x-model="displayName" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Email Address *</label>
                        <input type="email" name="email" x-model="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Mobile Contact Number</label>
                        <input type="text" name="phone" x-model="phone" placeholder="+91 9876543210" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white">
                        <span class="text-[11px] text-slate-400 mt-1 block">Used for job SMS notifications & direct brand callouts.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Gender</label>
                        <select name="gender" x-model="gender" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white">
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                            <option value="non_binary">Non-Binary</option>
                            <option value="other">Prefer not to say</option>
                        </select>
                    </div>
                </div>

                <!-- Password Setup / Security Update -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-4">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-700"></i>
                        <h4 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider">Account Password Setup (Optional)</h4>
                    </div>
                    <p class="text-slate-500 text-xs">Set or update your account password if you signed up using quick social login.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">New Password</label>
                            <input type="password" name="password" x-model="password" placeholder="Leave blank to keep current" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:border-[#0866FF]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" x-model="password_confirmation" placeholder="Confirm password" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm focus:outline-none focus:border-[#0866FF]">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">City</label>
                        <input type="text" name="city" x-model="city" placeholder="e.g. Mumbai" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">State</label>
                        <input type="text" name="state" x-model="state" placeholder="e.g. Maharashtra" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Country</label>
                        <input type="text" name="country" x-model="country" placeholder="e.g. India" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF]">
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button type="button" @click="step = 2" class="px-8 py-3.5 bg-[#0866FF] hover:bg-[#0052CC] text-white font-bold rounded-2xl transition text-sm shadow-md shadow-blue-500/20">
                        Continue to Role & Niche &rarr;
                    </button>
                </div>
            </div>

            <!-- STEP 2: Role Specialization & Category Selection -->
            <div x-show="step === 2" x-transition.opacity class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#E1306C]">Step 2 of 5</span>
                        <h2 class="text-2xl font-black text-slate-900 mt-1">Select Role & Niche Categories</h2>
                    </div>
                    <span class="w-10 h-10 rounded-2xl bg-pink-50 text-[#E1306C] flex items-center justify-center"><i data-lucide="sparkles" class="w-6 h-6"></i></span>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-3">Select Primary Talent Specialization</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div @click="specialization = 'influencer'" :class="specialization === 'influencer' ? 'border-[#0866FF] bg-blue-50/60 ring-2 ring-blue-500/20' : 'border-slate-200 bg-white hover:border-slate-300'" class="p-5 rounded-2xl border-2 cursor-pointer transition flex flex-col justify-between space-y-3">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-pink-100 text-[#E1306C] flex items-center justify-center mb-2"><i data-lucide="smartphone" class="w-5 h-5"></i></div>
                                <h4 class="font-extrabold text-slate-900 text-sm">Digital Influencer</h4>
                                <p class="text-slate-500 text-xs mt-1">Instagram Reels, Shorts, TikToks, sponsored posts & reviews.</p>
                            </div>
                            <span class="text-xs font-bold text-[#0866FF]">Select &rarr;</span>
                        </div>

                        <div @click="specialization = 'model'" :class="specialization === 'model' ? 'border-[#0866FF] bg-blue-50/60 ring-2 ring-blue-500/20' : 'border-slate-200 bg-white hover:border-slate-300'" class="p-5 rounded-2xl border-2 cursor-pointer transition flex flex-col justify-between space-y-3">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mb-2"><i data-lucide="camera" class="w-5 h-5"></i></div>
                                <h4 class="font-extrabold text-slate-900 text-sm">Commercial Model</h4>
                                <p class="text-slate-500 text-xs mt-1">Photoshoots, lookbooks, fashion catalogs, brand campaigns.</p>
                            </div>
                            <span class="text-xs font-bold text-[#0866FF]">Select &rarr;</span>
                        </div>

                        <div @click="specialization = 'anchor'" :class="specialization === 'anchor' ? 'border-[#0866FF] bg-blue-50/60 ring-2 ring-blue-500/20' : 'border-slate-200 bg-white hover:border-slate-300'" class="p-5 rounded-2xl border-2 cursor-pointer transition flex flex-col justify-between space-y-3">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-2"><i data-lucide="mic" class="w-5 h-5"></i></div>
                                <h4 class="font-extrabold text-slate-900 text-sm">Event & TV Anchor</h4>
                                <p class="text-slate-500 text-xs mt-1">Corporate emcee, event hosting, live streaming, voiceovers.</p>
                            </div>
                            <span class="text-xs font-bold text-[#0866FF]">Select &rarr;</span>
                        </div>
                    </div>
                    <input type="hidden" name="role_specialization" :value="specialization">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">Select Niche Categories (Select 1 or more)</label>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach(['Fashion & Lifestyle', 'Tech & Gaming', 'Beauty & Skincare', 'Health & Fitness', 'Travel & Food', 'Luxury & Jewelry', 'Corporate & Events', 'Entertainment', 'UGC Content'] as $cat)
                            <div @click="toggleCategory('{{ $cat }}')" 
                                 :class="selectedCategories.includes('{{ $cat }}') ? 'bg-[#E1306C] text-white border-[#E1306C]' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'" 
                                 class="px-4 py-2.5 rounded-xl border text-xs font-bold cursor-pointer transition flex items-center space-x-1.5">
                                <span>{{ $cat }}</span>
                                <span x-show="selectedCategories.includes('{{ $cat }}')" class="inline-flex"><i data-lucide="check" class="w-3.5 h-3.5"></i></span>
                            </div>
                        @endforeach
                    </div>
                    <template x-for="cat in selectedCategories" :key="cat">
                        <input type="hidden" name="primary_categories[]" :value="cat">
                    </template>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                    <button type="button" @click="step = 1" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-sm border border-slate-200">
                        &larr; Back
                    </button>
                    <button type="button" @click="step = 3" class="px-8 py-3.5 bg-[#0866FF] hover:bg-[#0052CC] text-white font-bold rounded-2xl transition text-sm shadow-md shadow-blue-500/20">
                        Continue to Social Reach &rarr;
                    </button>
                </div>
            </div>

            <!-- STEP 3: Social Media Accounts & Reach Analytics -->
            <div x-show="step === 3" x-transition.opacity class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#E1306C]">Step 3 of 5</span>
                        <h2 class="text-2xl font-black text-slate-900 mt-1">Connect Social Media Handles</h2>
                    </div>
                    <span class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center"><i data-lucide="bar-chart-3" class="w-6 h-6"></i></span>
                </div>

                <p class="text-slate-500 text-xs">Add your primary social handles so brands can verify your audience size and engagement metrics.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Instagram Handle & Followers -->
                    <div class="bg-gradient-to-br from-pink-50 to-purple-50 border border-pink-200/80 p-5 rounded-2xl space-y-3">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="camera" class="w-4 h-4 text-pink-600"></i>
                            <h4 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider">Instagram Account</h4>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Instagram Handle</label>
                            <input type="text" name="instagram_handle" x-model="instagramHandle" placeholder="@ananya_official" class="w-full bg-white border border-pink-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-[#E1306C]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Followers Count</label>
                            <input type="number" name="instagram_followers" x-model="instagramFollowers" placeholder="25000" class="w-full bg-white border border-pink-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-[#E1306C]">
                        </div>
                    </div>

                    <!-- YouTube Channel & Subscribers -->
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 border border-red-200/80 p-5 rounded-2xl space-y-3">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="film" class="w-4 h-4 text-red-600"></i>
                            <h4 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider">YouTube Channel</h4>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">YouTube Channel / Handle</label>
                            <input type="text" name="youtube_handle" x-model="youtubeHandle" placeholder="@AnanyaVlogs" class="w-full bg-white border border-red-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Subscribers Count</label>
                            <input type="number" name="youtube_subscribers" x-model="youtubeSubscribers" placeholder="10000" class="w-full bg-white border border-red-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                    <button type="button" @click="step = 2" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-sm border border-slate-200">
                        &larr; Back
                    </button>
                    <button type="button" @click="step = 4" class="px-8 py-3.5 bg-[#0866FF] hover:bg-[#0052CC] text-white font-bold rounded-2xl transition text-sm shadow-md shadow-blue-500/20">
                        Continue to Pitch Specs &rarr;
                    </button>
                </div>
            </div>

            <!-- STEP 4: Pitch Bio & Talent Attributes -->
            <div x-show="step === 4" x-transition.opacity class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#E1306C]">Step 4 of 5</span>
                        <h2 class="text-2xl font-black text-slate-900 mt-1">Creator Bio & Physical Specs</h2>
                    </div>
                    <span class="w-10 h-10 rounded-2xl bg-blue-50 text-[#0866FF] flex items-center justify-center"><i data-lucide="file-text" class="w-6 h-6"></i></span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Height (cm)</label>
                        <input type="number" name="height_cm" x-model="heightCm" placeholder="168" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Clothing / Apparel Size</label>
                        <select name="clothing_size" x-model="clothingSize" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF]">
                            <option value="XS">Extra Small (XS)</option>
                            <option value="S">Small (S)</option>
                            <option value="M">Medium (M)</option>
                            <option value="L">Large (L)</option>
                            <option value="XL">Extra Large (XL)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Spoken Languages</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['English', 'Hindi', 'Punjabi', 'Marathi', 'Bengali', 'Tamil', 'Telugu', 'Kannada', 'Spanish'] as $lang)
                            <div @click="toggleLanguage('{{ $lang }}')" 
                                 :class="selectedLanguages.includes('{{ $lang }}') ? 'bg-slate-800 text-white border-slate-800' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'"
                                 class="px-3.5 py-1.5 rounded-xl border text-xs font-bold cursor-pointer transition flex items-center">
                                <span>{{ $lang }}</span>
                                <span x-show="selectedLanguages.includes('{{ $lang }}')" class="inline-flex"><i data-lucide="check" class="w-3.5 h-3.5 ml-1"></i></span>
                            </div>
                        @endforeach
                    </div>
                    <template x-for="lang in selectedLanguages" :key="lang">
                        <input type="hidden" name="languages[]" :value="lang">
                    </template>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Bio / Creative Overview Pitch *</label>
                    <textarea name="bio" rows="4" x-model="bio" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:border-[#0866FF]" placeholder="Highlight your creative experience, past brand collaborations, and campaign strengths..."></textarea>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                    <button type="button" @click="step = 3" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-sm border border-slate-200">
                        &larr; Back
                    </button>
                    <button type="button" @click="step = 5" class="px-8 py-3.5 bg-[#0866FF] hover:bg-[#0052CC] text-white font-bold rounded-2xl transition text-sm shadow-md shadow-blue-500/20">
                        Continue to Rates & Preview &rarr;
                    </button>
                </div>
            </div>

            <!-- STEP 5: Service Rate & Upwork Live Card Preview -->
            <div x-show="step === 5" x-transition.opacity class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#E1306C]">Step 5 of 5</span>
                        <h2 class="text-2xl font-black text-slate-900 mt-1">Starting Rate & Profile Preview</h2>
                    </div>
                    <span class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center"><i data-lucide="credit-card" class="w-6 h-6"></i></span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Primary Service Package</label>
                        <select name="rate_type" x-model="rateType" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:border-[#0866FF]">
                            <option value="instagram_reel">Instagram Reel / Video</option>
                            <option value="model_day_rate">Model Daily Shoot Rate</option>
                            <option value="anchor_event_hosting">Event Hosting / Emcee Rate</option>
                            <option value="youtube_dedicated">YouTube Dedicated Video</option>
                            <option value="ugc_video_pack">UGC Video Ad Pack</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Starting Rate (₹ INR)</label>
                        <input type="number" name="rate_amount" x-model="startingRate" placeholder="15000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-bold focus:outline-none focus:border-[#0866FF]">
                    </div>
                </div>

                <!-- Live Upwork / Fiverr Card Preview -->
                <div class="bg-slate-50 border border-slate-200 p-6 rounded-3xl space-y-3">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Live Marketplace Card Preview</span>
                    
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 rounded-2xl bg-pink-100 text-[#E1306C] flex items-center justify-center font-black text-xl">
                                    <span x-text="displayName.charAt(0)"></span>
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-slate-900 text-base" x-text="displayName"></h4>
                                    <span class="text-xs text-slate-500 font-medium inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i><span x-text="city + ', ' + country"></span></span>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-full inline-flex items-center gap-1">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                <span>Verified Creator</span>
                            </span>
                        </div>

                        <div class="flex flex-wrap gap-2 text-xs">
                            <span class="px-2.5 py-1 bg-blue-50 text-[#0866FF] font-bold rounded-lg" x-text="specialization.toUpperCase()"></span>
                            <template x-for="cat in selectedCategories" :key="cat">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold rounded-lg" x-text="cat"></span>
                            </template>
                        </div>

                        <p class="text-xs text-slate-600 line-clamp-2" x-text="bio"></p>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center space-x-3 text-xs font-bold text-slate-700">
                                <span x-show="instagramHandle" class="inline-flex items-center gap-1"><i data-lucide="instagram" class="w-3.5 h-3.5 text-pink-600"></i><span x-text="'@' + instagramHandle + ' • ' + Number(instagramFollowers).toLocaleString() + ' followers'"></span></span>
                                <span x-show="youtubeHandle" class="inline-flex items-center gap-1"><i data-lucide="youtube" class="w-3.5 h-3.5 text-red-600"></i><span x-text="'@' + youtubeHandle"></span></span>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] text-slate-400 uppercase font-bold block">Starting From</span>
                                <span class="text-lg font-black text-slate-900" x-text="'₹' + Number(startingRate).toLocaleString()"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-600">
                    <label class="flex items-start space-x-3 cursor-pointer">
                        <input type="checkbox" required checked class="mt-0.5 rounded border-slate-300 text-[#0866FF] focus:ring-[#0866FF]">
                        <span>By launching your creator profile, you confirm that your submitted details are accurate and agree to our <a href="{{ route('terms') }}" target="_blank" class="text-[#0866FF] font-bold hover:underline">Terms of Service</a> and <a href="{{ route('privacy') }}" target="_blank" class="text-[#0866FF] font-bold hover:underline">Privacy Policy</a>.</span>
                    </label>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                    <button type="button" @click="step = 4" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-sm border border-slate-200">
                        &larr; Back
                    </button>
                    <button type="submit" class="px-8 py-4 bg-[#E1306C] hover:bg-[#c2255c] text-white font-extrabold rounded-2xl transition text-sm shadow-md shadow-pink-500/20 inline-flex items-center justify-center gap-2">
                        <i data-lucide="rocket" class="w-4 h-4"></i>
                        <span>Launch My Creator Profile</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
