@extends('layouts.brand')

@section('title', 'Talent Rosters & Shortlists | Brand Studio')

@section('content')
    <div class="space-y-6 sm:space-y-8" x-data="{ createModalOpen: false }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight font-display">Talent Rosters & Shortlists</h1>
                <p class="text-slate-600 text-xs sm:text-sm">Group creators into campaign moodboards, compare aggregated reach, and send bulk campaign invitations.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('influencers.public') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-2xl transition inline-flex items-center gap-1.5">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i>
                    <span>Browse Talent</span>
                </a>
                <button type="button" @click="createModalOpen = true" class="px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-2xl shadow-sm transition flex items-center space-x-1.5">
                    <span>+</span>
                    <span>Create New Roster</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Lists Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($lists as $list)
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-md hover:border-brand-300 transition duration-200 flex flex-col justify-between space-y-6 group">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="w-10 h-10 rounded-2xl bg-brand-50 text-brand-700 flex items-center justify-center font-bold text-base">
                                <i data-lucide="clipboard-list" class="w-5 h-5 text-brand-600"></i>
                            </span>
                            <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-full">
                                {{ $list->items_count }} Creators
                            </span>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-600 transition font-display">
                                {{ $list->name }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 mt-1">
                                {{ $list->description ?: 'Campaign talent roster created on ' . $list->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400 font-medium">Updated {{ $list->updated_at->diffForHumans() }}</span>
                        <a href="{{ route('brand.lists.show', $list->id) }}" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition shadow-2xs">
                            Open Roster &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-slate-200 shadow-sm space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                        <i data-lucide="folder" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">No Talent Rosters Created Yet</h3>
                    <p class="text-slate-500 text-xs max-w-sm mx-auto">Create your first shortlist to organize creators for upcoming product launches or seasonal campaigns.</p>
                    <button type="button" @click="createModalOpen = true" class="inline-block mt-2 px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                        + Create Your First Roster
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Create Shortlist Modal -->
        <div x-show="createModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div @click.away="createModalOpen = false" class="bg-white w-full max-w-md rounded-3xl border border-slate-200 shadow-2xl p-6 sm:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-lg font-bold font-display text-slate-900">Create Talent Roster</h3>
                    <button type="button" @click="createModalOpen = false" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center text-sm font-bold transition">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <form method="POST" action="{{ route('brand.lists.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 text-xs mb-1">Roster Name</label>
                        <input type="text" name="name" required placeholder="e.g. Q4 Festive Skincare Launch" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-xs mb-1">Description (Optional)</label>
                        <textarea name="description" rows="3" placeholder="Notes on campaign objective or required aesthetic..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500"></textarea>
                    </div>

                    <div class="flex items-center space-x-3 pt-2">
                        <button type="button" @click="createModalOpen = false" class="w-1/2 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                            Cancel
                        </button>
                        <button type="submit" class="w-1/2 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl transition shadow-xs">
                            Create Roster
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
