<!-- Mobile Bottom Ergonomic Navigation Bar -->
@if(auth()->check() && (auth()->user()->role === 'talent' || auth()->user()->role === 'influencer'))
    @php
        $unreadTalentMsgs = \App\Models\Message::whereHas('conversation', function($q) {
            $q->where('talent_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())->whereNull('read_at')->count();
    @endphp
    <div class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-slate-200 z-40 md:hidden px-2 py-1.5 shadow-lg">
        <div class="grid grid-cols-5 text-center text-[10px] font-semibold text-slate-500">
            <a href="{{ route('influencer.dashboard') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('influencer.dashboard') ? 'text-pink-600 font-bold' : 'hover:text-slate-900' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Home</span>
            </a>
            <a href="{{ route('influencer.campaigns') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('influencer.campaigns*') ? 'text-pink-600 font-bold' : 'hover:text-slate-900' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>Jobs</span>
            </a>
            <a href="{{ route('influencer.messages') }}" class="flex flex-col items-center py-1 relative {{ request()->routeIs('influencer.messages*') || request()->routeIs('influencer.chat*') ? 'text-pink-600 font-bold' : 'hover:text-slate-900' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <span>Chat</span>
                @if($unreadTalentMsgs > 0)
                    <span class="absolute top-1 right-3.5 w-2 h-2 bg-pink-600 rounded-full ring-2 ring-white"></span>
                @endif
            </a>
            <a href="{{ route('influencer.bookings') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('influencer.bookings*') ? 'text-pink-600 font-bold' : 'hover:text-slate-900' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <span>Orders</span>
            </a>
            <a href="{{ route('influencer.invoices') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('influencer.invoices*') ? 'text-pink-600 font-bold' : 'hover:text-slate-900' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                <span>Payouts</span>
            </a>
        </div>
    </div>
@elseif(auth()->check() && auth()->user()->role === 'brand')
    @php
        $unreadBrandMsgs = \App\Models\Message::whereHas('conversation', function($q) {
            $q->where('brand_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())->whereNull('read_at')->count();
    @endphp
    <div class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-slate-200 z-40 md:hidden px-2 py-1.5 shadow-lg">
        <div class="grid grid-cols-5 text-center text-[10px] font-semibold text-slate-500">
            <a href="{{ route('brand.dashboard') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('brand.dashboard') ? 'text-sky-600 font-bold' : 'hover:text-slate-900' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Studio</span>
            </a>
            <a href="{{ route('brand.campaigns') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('brand.campaigns*') ? 'text-sky-600 font-bold' : 'hover:text-slate-900' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>Jobs</span>
            </a>
            <a href="{{ route('influencers.public') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('influencers.public*') ? 'text-sky-600 font-bold' : 'hover:text-slate-900' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <span>Talent</span>
            </a>
            <a href="{{ route('brand.messages') }}" class="flex flex-col items-center py-1 relative {{ request()->routeIs('brand.messages*') || request()->routeIs('brand.chat*') ? 'text-sky-600 font-bold' : 'hover:text-slate-900' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <span>Chat</span>
                @if($unreadBrandMsgs > 0)
                    <span class="absolute top-1 right-3.5 w-2 h-2 bg-indigo-600 rounded-full ring-2 ring-white"></span>
                @endif
            </a>
            <a href="{{ route('brand.bookings') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('brand.bookings*') || request()->routeIs('brand.invoices*') ? 'text-sky-600 font-bold' : 'hover:text-slate-900' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <span>Orders</span>
            </a>
        </div>
    </div>
@endif
