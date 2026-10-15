@extends('layouts.brand')

@section('title', 'Review Submissions | Brand')

@section('content')
    <div class="space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-charcoal">Content Deliverables Review</h1>
                <p class="text-stone text-sm mt-1">Campaign: <strong class="text-charcoal">{{ $collaboration->campaign->name }}</strong> &bull; Creator: <strong class="text-terracotta">@ {{ $collaboration->influencerProfile->username }}</strong></p>
            </div>
            <a href="{{ route('brand.collaborations') }}" class="px-4 py-2 bg-linen hover:bg-warmgray text-charcoal text-xs font-semibold rounded-xl border border-warmgray">
                &larr; Back to Collaborations
            </a>
        </div>

        <div class="bg-cream border border-warmgray rounded-2xl p-6">
            <h3 class="text-lg font-bold text-charcoal mb-4">Submitted Content Items ({{ $collaboration->contentSubmissions->count() }})</h3>

            <div class="space-y-5">
                @forelse($collaboration->contentSubmissions as $sub)
                    <div class="bg-ivory border border-warmgray p-5 rounded-xl space-y-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-stone uppercase block">Deliverable</span>
                                <span class="font-bold text-charcoal text-base">{{ $sub->deliverable->name ?? 'General Deliverable' }}</span>
                            </div>
                            <div>
                                @if($sub->status === 'approved')
                                    <span class="px-3 py-1 bg-sage/10 text-sage border border-sage/20 rounded-full text-xs font-bold">Approved</span>
                                @elseif($sub->status === 'changes_requested')
                                    <span class="px-3 py-1 bg-sand/30 text-charcoal border border-sand/50 rounded-full text-xs font-bold">Changes Requested</span>
                                @else
                                    <span class="px-3 py-1 bg-linen text-stone rounded-full text-xs font-bold">Pending Review</span>
                                @endif
                            </div>
                        </div>

                        <div class="bg-cream p-4 rounded-xl text-xs space-y-1.5 border border-warmgray">
                            <div><span class="text-stone">Live Content Link:</span> <a href="{{ $sub->content_url }}" target="_blank" class="text-terracotta font-bold hover:underline break-all">{{ $sub->content_url }} &rarr;</a></div>
                            @if($sub->caption)
                                <div><span class="text-stone">Caption:</span> <span class="text-charcoal">{{ $sub->caption }}</span></div>
                            @endif
                            @if($sub->notes)
                                <div><span class="text-stone">Creator Notes:</span> <span class="text-stone italic">{{ $sub->notes }}</span></div>
                            @endif
                        </div>

                        <!-- Brand Review Action Form -->
                        <form method="POST" action="{{ route('brand.submissions.status', $sub->id) }}" class="bg-linen p-4 rounded-xl border border-warmgray space-y-3">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-charcoal mb-1">Feedback / Modification Notes</label>
                                <input type="text" name="admin_notes" value="{{ $sub->admin_notes }}" placeholder="Enter instructions or approval feedback..." class="w-full bg-cream border border-warmgray rounded-lg px-3 py-2 text-charcoal text-xs focus:outline-none focus:border-terracotta">
                            </div>

                            <div class="flex items-center space-x-2">
                                <button type="submit" name="status" value="approved" class="px-4 py-2 bg-sage text-white text-xs font-bold rounded-lg hover:opacity-90 transition inline-flex items-center gap-1">
                                    <i data-lucide="check" class="w-3.5 h-3.5"></i> Approve Content
                                </button>
                                <button type="submit" name="status" value="changes_requested" class="px-4 py-2 bg-linen text-charcoal border border-warmgray text-xs font-semibold rounded-lg hover:bg-warmgray transition inline-flex items-center gap-1">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> Request Revision
                                </button>
                            </div>
                        </form>
                    </div>
                @empty
                    <p class="text-stone text-sm py-4">No content items submitted by creator yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
