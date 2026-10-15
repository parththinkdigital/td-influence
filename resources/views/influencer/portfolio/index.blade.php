@extends('layouts.influencer')

@section('title', 'My Portfolio & Work Showcase | Talent Studio')

@section('content')
    <div class="space-y-8" x-data="{ showModal: false, showDemoNotice: false }">
        <!-- Header -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="px-3.5 py-1 bg-purple-50 text-purple-600 border border-purple-200 text-xs font-bold rounded-full inline-block mb-2">
                    Creator Work Showcase
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Portfolio & Work Showcase</h1>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Add photoshoots, video campaigns, brand lookbooks, and hosting clips to attach to job applications.
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <button @click="showModal = true" class="px-5 py-3 bg-[#E1306C] hover:bg-[#c2255c] text-white text-xs font-bold rounded-2xl transition shadow-md shadow-pink-500/20 flex items-center space-x-2">
                    <span>+ Add Work / Portfolio Item</span>
                </button>
            </div>
        </div>

        <!-- Portfolios Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($portfolios as $item)
                <div class="bg-white border border-slate-200 rounded-3xl p-5 shadow-xs flex flex-col justify-between space-y-4 hover:shadow-md transition group">
                    <div>
                        @if(!empty($item->media_files[0]))
                            <div class="relative overflow-hidden rounded-2xl mb-4 bg-slate-100 aspect-video">
                                <img src="{{ $item->media_files[0] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                <span class="absolute top-3 left-3 px-3 py-1 bg-slate-900/80 backdrop-blur text-white text-[10px] font-bold rounded-full uppercase tracking-wider">
                                    {{ $item->category ?: 'Portfolio Work' }}
                                </span>
                            </div>
                        @endif

                        <h3 class="font-extrabold text-slate-900 text-base group-hover:text-[#E1306C] transition">{{ $item->title }}</h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-3 leading-relaxed">{{ $item->description }}</p>

                        @if($item->brand_worked_with)
                            <div class="mt-3 inline-flex items-center space-x-1.5 px-3 py-1 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg border border-slate-200">
                                <span class="inline-flex items-center gap-1"><i data-lucide="building-2" class="w-3.5 h-3.5"></i> Brand:</span>
                                <strong class="text-slate-900">{{ $item->brand_worked_with }}</strong>
                            </div>
                        @endif

                        @if($item->role_played)
                            <div class="mt-2 text-[11px] text-slate-500 font-medium">
                                <span>Role: {{ $item->role_played }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        @if(!empty($item->media_files[0]))
                            <a href="{{ $item->media_files[0] }}" target="_blank" class="text-xs font-bold text-[#0866FF] hover:underline">View Media Link &rarr;</a>
                        @else
                            <span></span>
                        @endif

                        <form method="POST" action="{{ route('influencer.portfolio.delete', $item->id) }}" onsubmit="return confirm('Are you sure you want to remove this portfolio item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-white border border-slate-200 rounded-3xl space-y-4">
                    <div class="w-16 h-16 rounded-full bg-pink-50 text-[#E1306C] flex items-center justify-center mx-auto">
                        <i data-lucide="palette" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">No portfolio items added yet</h3>
                        <p class="text-slate-500 text-xs mt-1 max-w-md mx-auto">Upload images or paste links to your Instagram reels, photoshoots, or brand campaigns.</p>
                    </div>
                    <button @click="showModal = true" class="px-6 py-3 bg-[#E1306C] text-white text-xs font-bold rounded-2xl hover:bg-[#c2255c] transition">
                        + Add Work / Portfolio Item
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Add Portfolio Item Modal -->
        <div x-show="showModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
            <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-xl" @click.away="showModal = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-lg">Add Work / Portfolio Item</h3>
                        <p class="text-xs text-slate-500">Showcase past campaign photos or video links</p>
                    </div>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-900 font-bold text-xl">&times;</button>
                </div>

                <form method="POST" action="{{ route('influencer.portfolio') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Project / Work Title *</label>
                        <input type="text" name="title" required placeholder="e.g. Summer Fashion Campaign / Tech Review" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF] focus:bg-white">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Category</label>
                            <select name="category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF]">
                                <option value="Photoshoot">Photoshoot / Modeling</option>
                                <option value="Instagram Reel">Instagram Reel / Story</option>
                                <option value="YouTube Video">YouTube Video</option>
                                <option value="Commercial Ad">Commercial Ad / TV</option>
                                <option value="Event Hosting">Event Hosting / Anchor</option>
                                <option value="UGC Content">UGC Video Ad</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Brand / Client Name</label>
                            <input type="text" name="brand_worked_with" placeholder="e.g. Vogue, Nykaa, Samsung" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Media Image / Video URL *</label>
                        <input type="url" name="media_url" required placeholder="https://images.unsplash.com/... or https://instagram.com/p/..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF]">
                        <span class="text-[11px] text-slate-400 mt-1 block">Paste direct image link, Instagram post link, or Unsplash sample URL.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Role Played</label>
                        <input type="text" name="role_played" placeholder="e.g. Lead Model, Product Reviewer, Emcee" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-[#0866FF]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Description & Highlights</label>
                        <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:border-[#0866FF]" placeholder="Detail your experience, engagement reach, or campaign outcomes..."></textarea>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" @click="showModal = false" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-xs">Cancel</button>
                        <button type="submit" class="px-6 py-3 bg-[#E1306C] hover:bg-[#c2255c] text-white font-extrabold text-xs rounded-xl shadow-md transition">
                            Save Portfolio Work
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
