@extends('layouts.influencer')

@section('title', 'Submit Deliverable | Studio')

@section('content')
    <div class="max-w-4xl space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-charcoal">Submit Deliverables</h1>
                <p class="text-stone text-sm mt-1">Campaign: <strong class="text-charcoal">{{ $collaboration->campaign->name }}</strong> &bull; Brand: <strong class="text-charcoal">{{ $collaboration->campaign->brandProfile->company_name ?? 'Brand' }}</strong></p>
            </div>
            <a href="{{ route('influencer.collaborations') }}" class="px-4 py-2 bg-linen hover:bg-warmgray text-charcoal text-xs font-semibold rounded-xl border border-warmgray">
                &larr; Back to Collaborations
            </a>
        </div>

        <!-- Submit Content Link Form -->
        <div class="bg-cream border border-warmgray rounded-2xl p-8 shadow-sm">
            <h3 class="text-xl font-bold text-charcoal mb-1">Submit Live Content Link</h3>
            <p class="text-stone text-xs mb-6">Enter the live post, reel, or video URL for brand review.</p>

            <form method="POST" action="{{ route('influencer.collaborations.submit', $collaboration->id) }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-charcoal uppercase mb-2">Target Deliverable Item</label>
                    <select name="deliverable_id" class="w-full bg-ivory border border-warmgray rounded-xl px-4 py-3 text-charcoal text-sm focus:outline-none focus:border-terracotta">
                        <option value="">General Deliverable</option>
                        @foreach($collaboration->campaign->deliverables as $del)
                            <option value="{{ $del->id }}">{{ $del->name }} ({{ strtoupper($del->type) }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-charcoal uppercase mb-2">Content Link / URL</label>
                    <input type="url" name="content_url" required placeholder="https://instagram.com/reel/..." class="w-full bg-ivory border border-warmgray rounded-xl px-4 py-3 text-charcoal text-sm focus:outline-none focus:border-terracotta">
                </div>

                <div>
                    <label class="block text-xs font-bold text-charcoal uppercase mb-2">Post Caption Used (Optional)</label>
                    <textarea name="caption" rows="2" class="w-full bg-ivory border border-warmgray rounded-xl px-4 py-3 text-charcoal text-sm focus:outline-none focus:border-terracotta" placeholder="Include tags and hashtags used..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-charcoal uppercase mb-2">Notes for Brand Manager</label>
                    <input type="text" name="notes" placeholder="Draft video ready for signoff!" class="w-full bg-ivory border border-warmgray rounded-xl px-4 py-3 text-charcoal text-sm focus:outline-none focus:border-terracotta">
                </div>

                <button type="submit" class="w-full py-4 rounded-xl font-bold bg-terracotta text-white hover:bg-terracotta-hover transition text-sm">
                    Submit Content for Brand Review
                </button>
            </form>
        </div>

        <!-- History of Submissions -->
        <div class="bg-cream border border-warmgray rounded-2xl p-6">
            <h3 class="text-lg font-bold text-charcoal mb-4">Submission History</h3>

            <div class="space-y-4">
                @forelse($collaboration->contentSubmissions as $sub)
                    <div class="bg-ivory border border-warmgray p-5 rounded-xl space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-charcoal text-sm">{{ $sub->deliverable->name ?? 'Deliverable' }}</span>
                            @if($sub->status === 'approved')
                                <span class="px-3 py-1 bg-sage/10 text-sage border border-sage/20 rounded-full text-xs font-bold">Approved by Brand</span>
                            @elseif($sub->status === 'changes_requested')
                                <span class="px-3 py-1 bg-sand/30 text-charcoal border border-sand/50 rounded-full text-xs font-bold">Changes Requested</span>
                            @else
                                <span class="px-3 py-1 bg-linen text-stone rounded-full text-xs font-bold">Pending Review</span>
                            @endif
                        </div>

                        <div class="text-xs text-stone">
                            URL: <a href="{{ $sub->content_url }}" target="_blank" class="text-terracotta hover:underline font-bold">{{ $sub->content_url }}</a>
                        </div>

                        @if($sub->admin_notes)
                            <div class="mt-2 p-3 bg-linen rounded-lg text-xs text-charcoal border border-warmgray">
                                <strong>Brand Feedback:</strong> {{ $sub->admin_notes }}
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-stone text-sm py-2">No deliverables submitted yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
