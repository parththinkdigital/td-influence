@extends('layouts.admin')

@section('title', 'Categories & Industries | Admin Gateway')

@section('content')
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight font-display">Categories & Industries</h1>
            <p class="text-slate-500 text-sm mt-1">Manage deliverable categories and brand industry verticals for the marketplace.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Categories -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs space-y-6">
                <h3 class="text-base font-extrabold text-slate-900 font-display">Deliverable Categories</h3>
                <form method="POST" action="{{ route('admin.categories.store') }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="Category name (e.g. Lookbook Shoot / Podcast Slot)" class="flex-grow bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:bg-white transition">
                    <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white font-bold rounded-xl text-xs shadow-xs transition">+ Add</button>
                </form>

                <div class="divide-y divide-slate-100">
                    @foreach($categories as $cat)
                        <div class="py-3 flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-900">{{ $cat->name }}</span>
                            <span class="text-slate-400 font-mono text-[11px]">{{ $cat->slug }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Industries -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs space-y-6">
                <h3 class="text-base font-extrabold text-slate-900 font-display">Brand Industries</h3>
                <form method="POST" action="{{ route('admin.industries.store') }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="Industry name (e.g. Wine & Hospitality / Fashion)" class="flex-grow bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 text-sm placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:bg-white transition">
                    <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white font-bold rounded-xl text-xs shadow-xs transition">+ Add</button>
                </form>

                <div class="divide-y divide-slate-100">
                    @foreach($industries as $ind)
                        <div class="py-3 flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-900">{{ $ind->name }}</span>
                            <span class="text-slate-400 font-mono text-[11px]">{{ $ind->slug }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
