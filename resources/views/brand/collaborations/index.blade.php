@extends('layouts.brand')

@section('title', 'Collaborations & Submissions | Brand')

@section('content')
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-charcoal">Active Collaborations & Submissions</h1>
            <p class="text-stone text-sm mt-1">Review content deliverable links submitted by creators.</p>
        </div>

        <div class="bg-cream border border-warmgray rounded-2xl p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-charcoal">
                    <thead class="bg-linen text-stone text-xs uppercase font-semibold">
                        <tr>
                            <th class="p-4 rounded-l-xl">Campaign Title</th>
                            <th class="p-4">Creator</th>
                            <th class="p-4">Submissions</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 rounded-r-xl text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-warmgray">
                        @forelse($collaborations as $collab)
                            <tr>
                                <td class="p-4 font-bold text-charcoal">{{ $collab->campaign->name ?? 'N/A' }}</td>
                                <td class="p-4 text-terracotta font-semibold">@ {{ $collab->influencerProfile->username ?? 'Creator' }}</td>
                                <td class="p-4 font-bold text-charcoal">{{ $collab->contentSubmissions->count() }} Deliverable Links</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 bg-sage/10 text-sage border border-sage/20 rounded-full text-xs font-bold">
                                        {{ ucfirst($collab->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('brand.collaborations.show', $collab->id) }}" class="px-3.5 py-1.5 bg-terracotta hover:bg-terracotta-hover text-white text-xs font-bold rounded-lg transition">
                                        Review Submissions &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-stone">No active collaborations. Select a creator from campaign applicants to start a collaboration.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
