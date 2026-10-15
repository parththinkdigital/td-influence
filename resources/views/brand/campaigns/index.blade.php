@extends('layouts.brand')

@section('title', 'My Campaigns & Jobs | Brand Studio')

@section('content')
    <div class="space-y-8">
        <!-- Header Banner with Create Campaign Button -->
        <div class="bg-gradient-to-r from-sky-50 via-blue-50 to-indigo-50 border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="px-3.5 py-1 bg-white/80 backdrop-blur border border-blue-200 text-[#0866FF] text-xs font-bold rounded-full inline-block mb-2 shadow-xs">
                    Campaign Management (CRUD)
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Jobs & Campaign Briefs</h1>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Create, edit, manage requirements, review applications, and hire talent.
                </p>
            </div>

            <div>
                <a href="{{ route('brand.campaigns.create') }}" class="px-6 py-3.5 rounded-2xl font-extrabold bg-[#0866FF] hover:bg-[#0052CC] text-white transition text-xs shadow-md shadow-blue-500/20 flex items-center space-x-2">
                    <span>+ Create Campaign Brief</span>
                </a>
            </div>
        </div>

        <!-- Campaigns Table & Cards -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-900">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="p-4 rounded-l-2xl">Campaign Title</th>
                            <th class="p-4">Category</th>
                            <th class="p-4">Budget Range</th>
                            <th class="p-4">Applicants</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 rounded-r-2xl text-right">Actions (CRUD)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($campaigns as $camp)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4 font-bold text-slate-900">
                                    <a href="{{ route('brand.campaigns.show', $camp->id) }}" class="hover:text-[#0866FF]">
                                        {{ $camp->title ?: $camp->name }}
                                    </a>
                                </td>
                                <td class="p-4">
                                    <span class="px-3 py-1 bg-slate-100 rounded-full text-xs text-slate-700 font-semibold border border-slate-200">
                                        {{ $camp->category->name ?? 'General' }}
                                    </span>
                                </td>
                                <td class="p-4 font-black text-slate-900">
                                    ₹{{ number_format($camp->budget_min ?: $camp->budget) }} - ₹{{ number_format($camp->budget_max ?: $camp->budget) }}
                                </td>
                                <td class="p-4 font-bold text-[#E1306C]">
                                    {{ $camp->applications->count() }} Applicants
                                </td>
                                <td class="p-4">
                                    @if($camp->status === 'published')
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold">Published</span>
                                    @else
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold">{{ ucfirst($camp->status) }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- View Applicants -->
                                        <a href="{{ route('brand.campaigns.show', $camp->id) }}" class="px-3 py-1.5 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition shadow-xs">
                                            Applicants ({{ $camp->applications->count() }})
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('brand.campaigns.edit', $camp->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition border border-slate-200">
                                            Edit
                                        </a>

                                        <!-- Delete -->
                                        <form method="POST" action="{{ route('brand.campaigns.delete', $camp->id) }}" onsubmit="return confirm('Delete this campaign brief?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 text-xs font-bold text-red-500 hover:bg-red-50 rounded-xl transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-slate-500 space-y-3">
                                    <div class="w-16 h-16 rounded-full bg-blue-50 text-[#0866FF] flex items-center justify-center mx-auto"><i data-lucide="clipboard-list" class="w-8 h-8"></i></div>
                                    <h3 class="text-base font-bold text-slate-800">No campaign briefs created yet</h3>
                                    <p class="text-slate-500 text-xs max-w-md mx-auto">Post your campaign brief specifying requirements, model specs, and budget to receive creator proposals.</p>
                                    <a href="{{ route('brand.campaigns.create') }}" class="inline-block px-6 py-3 bg-[#0866FF] text-white text-xs font-extrabold rounded-2xl hover:bg-[#0052CC] transition shadow-md">
                                        + Create Campaign Brief
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $campaigns->links() }}
            </div>
        </div>
    </div>
@endsection
