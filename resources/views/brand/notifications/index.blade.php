@extends('layouts.brand')

@section('title', 'Notifications & Alerts | Brand Studio')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">
                <span>Alerts & Activity</span>
                <span>&bull;</span>
                <span class="text-sky-600">Real-time Updates</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Notifications</h1>
            <p class="text-slate-600 text-sm mt-1">Stay updated with creator applications, chat messages, counter-offers, and deliverable submissions.</p>
        </div>

        <div class="flex items-center space-x-3">
            @if($notifications->whereNull('read_at')->count() > 0)
                <form method="POST" action="{{ route('brand.notifications.read_all') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-50 transition shadow-sm">
                        Mark All as Read
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden divide-y divide-slate-100">
        @forelse($notifications as $notif)
            <div class="p-5 flex items-start justify-between gap-4 transition {{ is_null($notif->read_at) ? 'bg-indigo-50/30' : 'hover:bg-slate-50' }}">
                <div class="flex items-start space-x-4 min-w-0">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0 mt-0.5 shadow-2xs {{ is_null($notif->read_at) ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600' }}">
                        @if($notif->type === 'message')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        @elseif($notif->type === 'proposal')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        @elseif($notif->type === 'booking')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @endif
                    </div>

                    <div class="min-w-0">
                        <div class="flex items-center space-x-2">
                            <h3 class="text-sm font-bold text-slate-900">{{ $notif->title }}</h3>
                            @if(is_null($notif->read_at))
                                <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $notif->body }}</p>
                        <span class="text-[11px] text-slate-400 font-medium block mt-1.5">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="flex items-center space-x-2 flex-shrink-0">
                    @if($notif->action_url)
                        <form method="POST" action="{{ route('brand.notifications.read', $notif->id) }}">
                            @csrf
                            <button type="submit" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-2xs">
                                View
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-16 px-4">
                <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto text-slate-400 mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">No notifications yet</h3>
                <p class="text-xs text-slate-500 mt-1">You will receive real-time notifications when creators message you or apply to your campaigns.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
