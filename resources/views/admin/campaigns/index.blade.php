@extends('layouts.admin')

@section('title', 'Manage Campaigns | Admin')

@section('content')
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-charcoal">Campaign Approval & Governance</h1>
            <p class="text-stone text-sm mt-1">Review brand campaign submissions and set status to Published, Paused, or Cancelled.</p>
        </div>

        <div class="bg-cream border border-warmgray rounded-2xl p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-charcoal">
                    <thead class="bg-linen text-stone text-xs uppercase font-semibold">
                        <tr>
                            <th class="p-4 rounded-l-xl">Campaign Title</th>
                            <th class="p-4">Brand</th>
                            <th class="p-4">Category</th>
                            <th class="p-4">Budget</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 rounded-r-xl text-right">Moderation Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-warmgray">
                        @forelse($campaigns as $camp)
                            <tr>
                                <td class="p-4 font-bold text-charcoal">{{ $camp->name }}</td>
                                <td class="p-4 text-stone">{{ $camp->brandProfile->company_name ?? 'N/A' }}</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 bg-linen rounded-full text-xs text-stone">
                                        {{ $camp->category->name ?? 'General' }}
                                    </span>
                                </td>
                                <td class="p-4 font-bold text-charcoal">${{ number_format($camp->budget) }}</td>
                                <td class="p-4">
                                    @if($camp->status === 'published')
                                        <span class="px-2.5 py-1 bg-sage/10 text-sage border border-sage/20 rounded-full text-xs font-semibold">Published</span>
                                    @elseif($camp->status === 'pending_review')
                                        <span class="px-2.5 py-1 bg-sand/20 text-charcoal border border-sand/40 rounded-full text-xs font-semibold">Pending Review</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-linen text-stone rounded-full text-xs font-semibold">{{ ucfirst($camp->status) }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <form method="POST" action="{{ route('admin.campaigns.status', $camp->id) }}" class="inline-flex">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="bg-ivory border border-warmgray rounded-lg px-2.5 py-1 text-xs text-charcoal">
                                            <option value="published" {{ $camp->status == 'published' ? 'selected' : '' }}>Published (Approve)</option>
                                            <option value="pending_review" {{ $camp->status == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                                            <option value="paused" {{ $camp->status == 'paused' ? 'selected' : '' }}>Paused</option>
                                            <option value="cancelled" {{ $camp->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-stone">No campaigns found.</td>
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
