@extends('layouts.influencer')

@section('title', 'Profile & Availability Calendar | Creator Studio')

@section('content')
    <div class="max-w-4xl space-y-8" x-data="{ 
        pfpUrl: '{{ old('profile_image', $profile->profile_image ?: auth()->user()->avatar) }}',
        activeTab: 'availability',
        isFetchingSocial: false,
        fetchMsg: '',
        fetchError: '',
        fileName: '',
        showUrlInput: false,
        previewFile(event) {
            const file = event.target.files[0];
            if (file) {
                this.fileName = file.name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.pfpUrl = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        async autoFetchAvatar(platform = 'instagram', username = '') {
            this.isFetchingSocial = true;
            this.fetchMsg = '';
            this.fetchError = '';
            try {
                const response = await fetch('{{ route('influencer.profile.fetch_social_avatar') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ platform: platform, username: username })
                });
                const data = await response.json();
                if (data.success && data.avatar_url) {
                    this.pfpUrl = data.avatar_url;
                    this.fetchMsg = data.message || 'Avatar fetched successfully!';
                    if (window.showToast) {
                        window.showToast({
                            title: 'Profile Photo Synced',
                            body: data.message,
                            type: 'success'
                        });
                    }
                } else {
                    this.fetchError = data.message || 'Could not fetch avatar.';
                }
            } catch (err) {
                this.fetchError = 'Connection failed while fetching social avatar.';
            } finally {
                this.isFetchingSocial = false;
            }
        }
    }">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <span class="px-3.5 py-1 bg-brand-50 text-brand-700 border border-brand-200 text-xs font-bold rounded-full inline-block mb-2">
                    Talent Settings & Availability
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Creator Profile & Booking Availability</h1>
                <p class="text-slate-600 text-sm mt-1">Manage manual booking status, calendar dates, physical specs for modeling, and emcee hosting specialties.</p>
            </div>
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <a href="{{ route('influencer.verification') }}" class="px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold rounded-2xl border border-emerald-200 transition shadow-2xs inline-flex items-center gap-1.5">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                    <span>Govt KYC & ID Verification &rarr;</span>
                </a>
                <a href="{{ route('influencers.public.show', $profile->username ?: 'me') }}" target="_blank" class="px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-800 text-xs font-bold rounded-2xl border border-slate-200 transition shadow-2xs inline-flex items-center gap-1.5">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    <span>View Live Media Kit &rarr;</span>
                </a>
            </div>
        </div>

        <!-- 1. LIVE AVAILABILITY STATUS CONTROLLER (Section 5 of Blueprint) -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 font-display flex items-center space-x-2">
                        <i data-lucide="calendar" class="w-5 h-5 text-indigo-600"></i>
                        <span>Live Booking Availability Status</span>
                        @if($profile->availability_status === 'available')
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        @elseif($profile->availability_status === 'tentative')
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        @elseif($profile->availability_status === 'booked')
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                        @else
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                        @endif
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">Brands and casting directors see this badge on your profile when scouting talent.</p>
                </div>
                <div class="text-xs font-bold px-3 py-1.5 rounded-xl border {{ 
                    $profile->availability_status === 'available' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' :
                    ($profile->availability_status === 'tentative' ? 'bg-amber-50 text-amber-800 border-amber-200' :
                    ($profile->availability_status === 'booked' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'bg-slate-100 text-slate-700 border-slate-200'))
                }}">
                    Current: {{ strtoupper(str_replace('_', ' ', $profile->availability_status ?? 'available')) }}
                </div>
            </div>

            <form method="POST" action="{{ route('influencer.availability.update') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="availability_status" value="available" {{ ($profile->availability_status ?? 'available') === 'available' ? 'checked' : '' }} class="peer sr-only">
                        <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 hover:bg-slate-50 transition text-center space-y-1">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 mx-auto block"></i>
                            <span class="font-bold text-slate-900 text-xs block">Available</span>
                            <span class="text-[10px] text-slate-500 block">Open for new jobs</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="availability_status" value="tentative" {{ ($profile->availability_status ?? '') === 'tentative' ? 'checked' : '' }} class="peer sr-only">
                        <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 hover:bg-slate-50 transition text-center space-y-1">
                            <i data-lucide="clock" class="w-5 h-5 text-amber-500 mx-auto block"></i>
                            <span class="font-bold text-slate-900 text-xs block">Tentative</span>
                            <span class="text-[10px] text-slate-500 block">Limited slots open</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="availability_status" value="booked" {{ ($profile->availability_status ?? '') === 'booked' ? 'checked' : '' }} class="peer sr-only">
                        <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50/50 hover:bg-slate-50 transition text-center space-y-1">
                            <i data-lucide="briefcase" class="w-5 h-5 text-indigo-600 mx-auto block"></i>
                            <span class="font-bold text-slate-900 text-xs block">Booked / Busy</span>
                            <span class="text-[10px] text-slate-500 block">Active shoot in progress</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="availability_status" value="unavailable" {{ ($profile->availability_status ?? '') === 'unavailable' ? 'checked' : '' }} class="peer sr-only">
                        <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-rose-500 peer-checked:bg-rose-50/50 hover:bg-slate-50 transition text-center space-y-1">
                            <i data-lucide="minus-circle" class="w-5 h-5 text-rose-500 mx-auto block"></i>
                            <span class="font-bold text-slate-900 text-xs block">Unavailable</span>
                            <span class="text-[10px] text-slate-500 block">On break / Offline</span>
                        </div>
                    </label>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2">
                    <label class="inline-flex items-center space-x-2 text-xs font-semibold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="price_negotiable" value="1" {{ $profile->price_negotiable ? 'checked' : '' }} class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        <span>Allow 'Price Negotiable' counter-offers on my card</span>
                    </label>

                    <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition shadow-2xs">
                        Update Availability Status
                    </button>
                </div>
            </form>
        </div>

        <!-- 2. CALENDAR DATE-SPECIFIC AVAILABILITY OVERRIDES -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-base font-bold text-slate-900 font-display">Specific Calendar Date Holds & Bookings</h3>
                <p class="text-xs text-slate-500 mt-0.5">Block dates when you are occupied with shoots or unavailable for bookings.</p>
            </div>

            <!-- Add Date Form -->
            <form method="POST" action="{{ route('influencer.availability.date.store') }}" class="bg-slate-50 border border-slate-200 p-4 sm:p-5 rounded-2xl grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                @csrf
                <div class="sm:col-span-4">
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Select Date *</label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Status on Date *</label>
                    <select name="status" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <option value="booked">Booked</option>
                        <option value="tentative">Tentative Hold</option>
                        <option value="unavailable">Unavailable</option>
                        <option value="available">Available</option>
                    </select>
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Reason / Note (Optional)</label>
                    <input type="text" name="notes" placeholder="e.g. Sula Monsoon Shoot" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <div class="sm:col-span-2">
                    <button type="submit" class="w-full py-2 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition shadow-2xs">
                        + Add Date
                    </button>
                </div>
            </form>

            <!-- Active Date Overrides List -->
            <div class="space-y-2">
                @forelse($availabilities as $av)
                    <div class="flex items-center justify-between bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl text-xs">
                        <div class="flex items-center space-x-3">
                            <span class="font-bold text-slate-900 tabular-nums inline-flex items-center gap-1.5"><i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-500"></i> {{ $av->date->format('M d, Y') }}</span>
                            <span class="px-2.5 py-0.5 rounded-full font-bold uppercase text-[10px] {{
                                $av->status === 'booked' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' :
                                ($av->status === 'tentative' ? 'bg-amber-50 text-amber-800 border border-amber-200' :
                                ($av->status === 'unavailable' ? 'bg-rose-50 text-rose-800 border border-rose-200' : 'bg-emerald-50 text-emerald-800 border border-emerald-200'))
                            }}">
                                {{ $av->status }}
                            </span>
                            @if($av->notes || $av->note)
                                <span class="text-slate-500 italic text-[11px]">({{ $av->notes ?: $av->note }})</span>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('influencer.availability.date.delete', $av->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold text-xs p-1 inline-flex items-center gap-1">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                <span>Remove</span>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic text-center py-4">No specific date blocks added. You are shown according to your default availability status.</p>
                @endforelse
            </div>
        </div>

        <!-- 3. COMPREHENSIVE PERSONA PROFILE FORM -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs">
            <form method="POST" action="{{ route('influencer.profile') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Basic Profile Details -->
                <div class="space-y-5">
                    <h3 class="text-base font-bold text-slate-900 font-display border-b border-slate-100 pb-3">Identity & Bio</h3>
                    
                    <!-- PFP Avatar Upload & Instagram Photo Card -->
                    <div class="bg-gradient-to-br from-slate-50 to-pink-50/30 border border-slate-200 p-5 sm:p-6 rounded-2xl space-y-5">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-200/80 pb-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-900 uppercase tracking-wider">Profile Photo</label>
                                <p class="text-xs text-slate-500 mt-0.5">Upload a photo from your device or use your profile photo from Instagram or YouTube.</p>
                            </div>
                            
                            <!-- Social Photo Action Buttons -->
                            <div class="flex flex-wrap items-center gap-2">
                                <!-- Instagram Photo Button -->
                                @if(isset($instagramAccount) && $instagramAccount)
                                    <button type="button" 
                                            @click="autoFetchAvatar('instagram', '{{ $instagramAccount->username }}')" 
                                            :disabled="isFetchingSocial"
                                            class="inline-flex items-center space-x-2 px-3.5 py-2 bg-gradient-to-r from-pink-500 via-rose-500 to-amber-500 hover:from-pink-600 hover:to-amber-600 text-white text-xs font-bold rounded-xl shadow-xs transition hover:shadow-md disabled:opacity-50">
                                        <template x-if="!isFetchingSocial">
                                            <span class="flex items-center space-x-1.5">
                                                <i data-lucide="instagram" class="w-4 h-4"></i>
                                                <span>Use Instagram</span>
                                            </span>
                                        </template>
                                        <template x-if="isFetchingSocial">
                                            <span class="flex items-center space-x-1.5">
                                                <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                                <span>Adding...</span>
                                            </span>
                                        </template>
                                    </button>
                                @else
                                    <button type="button" 
                                            @click="autoFetchAvatar('instagram', '{{ $profile->username ?: auth()->user()->name }}')" 
                                            :disabled="isFetchingSocial"
                                            class="inline-flex items-center space-x-2 px-3.5 py-2 bg-gradient-to-r from-pink-500 via-rose-500 to-amber-500 hover:from-pink-600 hover:to-amber-600 text-white text-xs font-bold rounded-xl shadow-xs transition hover:shadow-md disabled:opacity-50">
                                        <template x-if="!isFetchingSocial">
                                            <span class="flex items-center space-x-1.5">
                                                <i data-lucide="instagram" class="w-4 h-4"></i>
                                                <span>Add from Instagram</span>
                                            </span>
                                        </template>
                                        <template x-if="isFetchingSocial">
                                            <span class="flex items-center space-x-1.5">
                                                <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                                <span>Adding...</span>
                                            </span>
                                        </template>
                                    </button>
                                @endif

                                <!-- YouTube Photo Button -->
                                @if(isset($youtubeAccount) && $youtubeAccount)
                                    <button type="button" 
                                            @click="autoFetchAvatar('youtube', '{{ $youtubeAccount->username }}')" 
                                            :disabled="isFetchingSocial"
                                            class="inline-flex items-center space-x-2 px-3.5 py-2 bg-gradient-to-r from-red-600 via-rose-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white text-xs font-bold rounded-xl shadow-xs transition hover:shadow-md disabled:opacity-50">
                                        <template x-if="!isFetchingSocial">
                                            <span class="flex items-center space-x-1.5">
                                                <i data-lucide="youtube" class="w-4 h-4"></i>
                                                <span>Use YouTube</span>
                                            </span>
                                        </template>
                                        <template x-if="isFetchingSocial">
                                            <span class="flex items-center space-x-1.5">
                                                <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                                <span>Adding...</span>
                                            </span>
                                        </template>
                                    </button>
                                @else
                                    <button type="button" 
                                            @click="autoFetchAvatar('youtube', '{{ $profile->username ?: auth()->user()->name }}')" 
                                            :disabled="isFetchingSocial"
                                            class="inline-flex items-center space-x-2 px-3.5 py-2 bg-gradient-to-r from-red-600 via-rose-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white text-xs font-bold rounded-xl shadow-xs transition hover:shadow-md disabled:opacity-50">
                                        <template x-if="!isFetchingSocial">
                                            <span class="flex items-center space-x-1.5">
                                                <i data-lucide="youtube" class="w-4 h-4"></i>
                                                <span>Add from YouTube</span>
                                            </span>
                                        </template>
                                        <template x-if="isFetchingSocial">
                                            <span class="flex items-center space-x-1.5">
                                                <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                                <span>Adding...</span>
                                            </span>
                                        </template>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Alert message when fetched -->
                        <template x-if="fetchMsg">
                            <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-semibold flex items-center justify-between">
                                <span x-text="fetchMsg"></span>
                                <button type="button" @click="fetchMsg = ''" class="text-emerald-600 hover:text-emerald-900 ml-2 font-bold">&times;</button>
                            </div>
                        </template>
                        <template x-if="fetchError">
                            <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-semibold flex items-center justify-between">
                                <span x-text="fetchError"></span>
                                <button type="button" @click="fetchError = ''" class="text-rose-600 hover:text-rose-900 ml-2 font-bold">&times;</button>
                            </div>
                        </template>

                        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                            <!-- Live Avatar Preview Container -->
                            <div class="relative group flex-shrink-0">
                                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-pink-100 border-2 border-pink-200 text-pink-700 shadow-md flex items-center justify-center overflow-hidden font-black text-3xl transition-transform group-hover:scale-105">
                                    <template x-if="pfpUrl">
                                        <img :src="pfpUrl" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!pfpUrl">
                                        <span>{{ strtoupper(substr($profile->display_name ?: auth()->user()->name, 0, 1)) }}</span>
                                    </template>
                                </div>
                                <label for="profile_image_file_input" class="absolute -bottom-2 -right-2 p-2 bg-slate-900 hover:bg-black text-white rounded-xl shadow-md cursor-pointer transition transform hover:scale-110" title="Upload new photo">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </label>
                            </div>

                            <!-- Upload & Action Controls -->
                            <div class="flex-grow w-full space-y-3">
                                <div>
                                    <input type="file" 
                                           id="profile_image_file_input" 
                                           name="profile_image_file" 
                                           accept="image/*" 
                                           @change="previewFile($event)" 
                                           class="sr-only">
                                    
                                    <div class="flex flex-wrap items-center gap-3">
                                        <label for="profile_image_file_input" 
                                               class="px-4 py-2.5 bg-white hover:bg-slate-50 border border-slate-300 hover:border-slate-400 text-slate-800 text-xs font-bold rounded-xl cursor-pointer transition shadow-2xs inline-flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            <span>Choose Photo from Device</span>
                                        </label>

                                        <button type="button" 
                                                @click="showUrlInput = !showUrlInput" 
                                                class="px-3 py-2 text-xs font-semibold text-slate-500 hover:text-slate-800 transition inline-flex items-center gap-1.5">
                                            <i data-lucide="link" class="w-3.5 h-3.5"></i>
                                            <span x-text="showUrlInput ? 'Hide URL link' : 'Paste Image URL instead'"></span>
                                        </button>
                                    </div>

                                    <template x-if="fileName">
                                        <p class="text-[11px] font-semibold text-emerald-600 mt-2 flex items-center space-x-1">
                                            <i data-lucide="check" class="w-3.5 h-3.5 inline-block"></i>
                                            <span>Selected file:</span>
                                            <span class="underline" x-text="fileName"></span>
                                        </p>
                                    </template>
                                    <p class="text-[11px] text-slate-400 mt-1">Supports JPG, PNG, WEBP, or GIF up to 5MB. Recommended: square portrait 800x800px.</p>
                                </div>

                                <!-- Optional Image URL Input (collapsible) -->
                                <div x-show="showUrlInput" x-cloak class="pt-2">
                                    <input type="url" 
                                           name="profile_image" 
                                           x-model="pfpUrl" 
                                           placeholder="https://... direct image URL" 
                                           class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Display / Stage Name *</label>
                            <input type="text" name="display_name" value="{{ old('display_name', $profile->display_name ?: auth()->user()->name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Gender</label>
                            <select name="gender" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm font-semibold focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-500 transition">
                                <option value="female" {{ $profile->gender === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="male" {{ $profile->gender === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="non_binary" {{ $profile->gender === 'non_binary' ? 'selected' : '' }}>Non-Binary</option>
                                <option value="other" {{ $profile->gender === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">City / Hub</label>
                            <input type="text" name="city" value="{{ old('city', $profile->city ?: 'Nashik') }}" placeholder="e.g. Nashik" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">State</label>
                            <input type="text" name="state" value="{{ old('state', $profile->state ?: 'Maharashtra') }}" placeholder="Maharashtra" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Country</label>
                            <input type="text" name="country" value="{{ old('country', $profile->country ?: 'India') }}" placeholder="India" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">About & Creative Bio</label>
                        <textarea name="bio" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-slate-900 text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-500 transition" placeholder="Describe your creative experience, niche, style, and brand collaboration goals...">{{ old('bio', $profile->bio) }}</textarea>
                    </div>
                </div>

                <!-- Model Specific Fields (Section 3 of Blueprint) -->
                <div class="space-y-5 pt-4 border-t border-slate-200">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 font-display flex items-center gap-1.5">
                            <i data-lucide="sparkles" class="w-4 h-4 text-pink-600"></i>
                            <span>Fashion & Commercial Model Attributes</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Physical statistics and modeling categories for runway, catalogue, and commercial shoots.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Height (cm)</label>
                            <input type="number" name="height_cm" value="{{ old('height_cm', $profile->height_cm) }}" placeholder="172" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Weight (kg)</label>
                            <input type="number" step="0.5" name="weight_kg" value="{{ old('weight_kg', $profile->weight_kg) }}" placeholder="58" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Clothing Size</label>
                            <input type="text" name="clothing_size" value="{{ old('clothing_size', $profile->clothing_size) }}" placeholder="S / M" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Shoe Size (UK/EU)</label>
                            <input type="text" name="shoe_size" value="{{ old('shoe_size', $profile->shoe_size) }}" placeholder="6 / 39" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Hair Color</label>
                            <input type="text" name="hair_color" value="{{ old('hair_color', $profile->hair_color) }}" placeholder="Dark Brown" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Eye Color</label>
                            <input type="text" name="eye_color" value="{{ old('eye_color', $profile->eye_color) }}" placeholder="Hazel" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Beard / Style</label>
                            <input type="text" name="beard" value="{{ old('beard', $profile->beard) }}" placeholder="Clean shaved / Stubble" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold">
                        </div>
                    </div>

                    <!-- Modeling Categories Checkboxes -->
                    @php
                        $modelCats = ['Fashion', 'Commercial', 'Lifestyle', 'Fitness', 'E-commerce', 'Jewellery', 'Beauty', 'Ethnic & Bridal', 'Runway', 'Catalogue', 'Western'];
                        $selectedModelCats = (array) ($profile->modeling_categories ?? []);
                    @endphp
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Modeling Categories</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                            @foreach($modelCats as $mc)
                                <label class="flex items-center space-x-2 bg-slate-50 border border-slate-200 p-2.5 rounded-xl cursor-pointer hover:bg-slate-100">
                                    <input type="checkbox" name="modeling_categories[]" value="{{ $mc }}" {{ in_array($mc, $selectedModelCats) ? 'checked' : '' }} class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                    <span class="text-slate-800 font-medium">{{ $mc }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Anchor / Emcee Specific Fields (Section 3 of Blueprint) -->
                <div class="space-y-5 pt-4 border-t border-slate-200">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 font-display flex items-center gap-1.5">
                            <i data-lucide="mic" class="w-4 h-4 text-amber-600"></i>
                            <span>Event Anchor & Emcee Attributes</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Hosting experience, stage presence, and event specialties.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Years of Experience</label>
                            <input type="number" name="years_experience" value="{{ old('years_experience', $profile->years_experience) }}" placeholder="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Hosting Style</label>
                            <input type="text" name="hosting_style" value="{{ old('hosting_style', $profile->hosting_style) }}" placeholder="High Energy, Professional, Bilingual" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Voice Style / Tone</label>
                            <input type="text" name="voice_style" value="{{ old('voice_style', $profile->voice_style) }}" placeholder="Clear, Articulate, Dynamic" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm font-semibold">
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 pt-1">
                        <label class="inline-flex items-center space-x-2 text-xs font-semibold text-slate-800 cursor-pointer">
                            <input type="checkbox" name="has_stage_exp" value="1" {{ $profile->has_stage_exp ? 'checked' : '' }} class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                            <span>Stage / Live Audience Hosting Experience</span>
                        </label>
                        <label class="inline-flex items-center space-x-2 text-xs font-semibold text-slate-800 cursor-pointer">
                            <input type="checkbox" name="has_tv_radio_exp" value="1" {{ $profile->has_tv_radio_exp ? 'checked' : '' }} class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                            <span>TV / Radio / Broadcast Experience</span>
                        </label>
                    </div>

                    <!-- Event Types Checkboxes -->
                    @php
                        $eventTypesList = ['Corporate Events', 'Product Launches', 'Award Functions', 'Conferences & Summits', 'Fashion Shows', 'Concerts & Festivals', 'Weddings & Private Galas'];
                        $selectedEventTypes = (array) ($profile->event_types ?? []);
                    @endphp
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Event Types Handled</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                            @foreach($eventTypesList as $et)
                                <label class="flex items-center space-x-2 bg-slate-50 border border-slate-200 p-2.5 rounded-xl cursor-pointer hover:bg-slate-100">
                                    <input type="checkbox" name="event_types[]" value="{{ $et }}" {{ in_array($et, $selectedEventTypes) ? 'checked' : '' }} class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                    <span class="text-slate-800 font-medium">{{ $et }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-slate-900 hover:bg-black text-white font-black rounded-2xl transition shadow-lg hover:shadow-xl text-sm flex items-center justify-center space-x-2 cursor-pointer transform hover:-translate-y-0.5">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Save Complete Profile Specifications</span>
                    </button>
                    <span class="text-xs text-slate-400 font-medium">All changes sync directly to your live public Media Kit</span>
                </div>
            </form>
        </div>
    </div>
@endsection
