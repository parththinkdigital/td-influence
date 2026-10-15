@extends('layouts.influencer')

@section('title', 'My Applications & Pitches | Talent Studio')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">
                <span>Campaign Submissions</span>
                <span>&bull;</span>
                <span class="text-pink-600">Applied Jobs</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">My Applications</h1>
            <p class="text-slate-600 text-sm mt-1">Track proposal statuses, negotiate rates directly with brands, and manage collaborations.</p>
        </div>

        <a href="{{ route('influencer.campaigns') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <span>Explore Open Jobs</span>
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 text-[11px] uppercase font-bold border-b border-slate-200">
                    <tr>
                        <th class="p-4 pl-6">Campaign Requirement</th>
                        <th class="p-4">Brand Client</th>
                        <th class="p-4">Quoted Rate</th>
                        <th class="p-4">Date Applied</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 pr-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($applications as $app)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="p-4 pl-6 font-bold text-slate-900 text-sm">
                                <a href="{{ route('influencer.campaigns.show', $app->campaign_id) }}" class="hover:text-indigo-600 transition">
                                    {{ $app->campaign->title ?? $app->campaign->name }}
                                </a>
                                @if($app->campaign && $app->campaign->city)
                                    <div class="text-[11px] text-slate-400 font-normal mt-0.5 inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> {{ $app->campaign->city }}</div>
                                @endif
                            </td>
                            <td class="p-4 font-medium text-slate-700">
                                {{ $app->campaign->brandProfile->company_name ?? 'Brand Client' }}
                            </td>
                            <td class="p-4 font-bold text-slate-900">
                                ₹{{ number_format($app->quoted_price) }}
                            </td>
                            <td class="p-4 text-slate-500 font-medium">
                                {{ $app->created_at->format('M d, Y') }}
                            </td>
                            <td class="p-4">
                                @if($app->status === 'selected')
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[10px] font-bold uppercase">Selected & Confirmed</span>
                                @elseif($app->status === 'shortlisted')
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-[10px] font-bold uppercase">Shortlisted</span>
                                @elseif($app->status === 'rejected')
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold uppercase">Declined</span>
                                @else
                                    <span class="px-2.5 py-1 bg-sky-50 text-sky-700 border border-sky-100 rounded-full text-[10px] font-bold uppercase">Under Review</span>
                                @endif
                            </td>
                            <td class="p-4 pr-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Chat button -->
                                    <a href="{{ route('influencer.chat', $app->id) }}" class="px-3.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 text-xs font-bold rounded-xl transition flex items-center space-x-1.5 shadow-2xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        <span>Chat & Offer</span>
                                    </a>

                                    @if($app->status === 'selected')
                                        <a href="{{ route('influencer.bookings') }}" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                            Booking →
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400">
                                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto text-slate-400 mb-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <p class="text-sm font-bold text-slate-700">No applications submitted yet</p>
                                <p class="text-xs text-slate-400 mt-0.5">Explore open campaigns in Nashik to start pitching your rates.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection
