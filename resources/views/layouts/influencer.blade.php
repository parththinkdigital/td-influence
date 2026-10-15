<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Talent Studio | Talent Marketplace')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#FDF2F8',
                            100: '#FCE7F3',
                            200: '#FBCFE8',
                            300: '#F9A8D4',
                            400: '#F472B6',
                            500: '#EC4899',
                            600: '#DB2777',
                            700: '#BE185D',
                            800: '#9D174D',
                            900: '#831843',
                            DEFAULT: '#DB2777',
                        },
                        indigoBrand: {
                            DEFAULT: '#4F46E5',
                            hover: '#4338CA',
                            light: '#EEF2FF',
                        },
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body { font-family: 'DM Sans', sans-serif; background-color: #F8FAFC; color: #0F172A; }
        [x-cloak] { display: none !important; }
        .gradient-bg { background: linear-gradient(135deg, #4F46E5 0%, #DB2777 100%); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex relative" x-data="{ mobileSidebar: false }">

    <!-- Global Live Toast Container & Shell Overlays -->
    @include('components.toast-container')
    @include('components.command-palette')
    @include('components.mobile-bottom-nav')

    <!-- Mobile Slide-over Drawer -->
    <div x-show="mobileSidebar" x-cloak class="relative z-[99999] md:hidden" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div x-show="mobileSidebar" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileSidebar = false" 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <!-- Drawer Panel -->
        <div class="fixed inset-0 flex">
            <div x-show="mobileSidebar" 
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative mr-16 flex w-full max-w-xs flex-1 bg-white flex-col justify-between p-6 shadow-2xl">
                 
                <div>
                    <!-- Drawer Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-xl gradient-bg flex items-center justify-center font-bold text-white text-lg tracking-tight shadow-md">
                                TM
                            </div>
                            <span class="text-xl font-bold tracking-tight text-slate-900">Talent <span class="text-pink-600">Portal</span></span>
                        </div>
                        <button type="button" @click="mobileSidebar = false" class="p-2 text-slate-400 hover:text-slate-700 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="space-y-1 text-sm font-medium">
                        <a href="{{ route('influencer.dashboard') }}" @click="mobileSidebar = false" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.dashboard') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('influencer.portfolio') }}" @click="mobileSidebar = false" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.portfolio*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <span>Portfolio & Work</span>
                        </a>
                        <a href="{{ route('influencer.rates') }}" @click="mobileSidebar = false" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.rates*') || request()->routeIs('influencer.gigs*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <span>Gigs & Packages</span>
                        </a>
                        <a href="{{ route('influencer.social') }}" @click="mobileSidebar = false" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.social*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <span>Social Accounts</span>
                        </a>
                        <a href="{{ route('influencer.campaigns') }}" @click="mobileSidebar = false" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.campaigns*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <span>Open Brand Jobs</span>
                        </a>
                        <a href="{{ route('influencer.applications') }}" @click="mobileSidebar = false" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.applications*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <span>My Applications</span>
                        </a>
                        <a href="{{ route('influencer.messages') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.messages*') || request()->routeIs('influencer.chat*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <span>Messages & Offers</span>
                            </div>
                            @php
                                $unreadTalentMsgs = \App\Models\Message::whereHas('conversation', function($q) {
                                    $q->where('talent_user_id', Auth::id());
                                })->where('sender_id', '!=', Auth::id())->whereNull('read_at')->count();
                            @endphp
                            @if($unreadTalentMsgs > 0)
                                <span class="px-2 py-0.5 bg-pink-600 text-white text-[10px] font-bold rounded-full">{{ $unreadTalentMsgs }}</span>
                            @endif
                        </a>
                        <a href="{{ route('influencer.bookings') }}" @click="mobileSidebar = false" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.bookings*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <span>Bookings & Orders</span>
                        </a>
                        <a href="{{ route('influencer.invoices') }}" @click="mobileSidebar = false" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.invoices*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <span>Invoices & Payouts</span>
                        </a>
                        <a href="{{ route('influencer.notifications') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.notifications*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <span>Notifications</span>
                            </div>
                            @php
                                $unreadTalentNotifs = Auth::user()->appNotifications()->whereNull('read_at')->count();
                            @endphp
                            @if($unreadTalentNotifs > 0)
                                <span class="px-2 py-0.5 bg-amber-500 text-white text-[10px] font-bold rounded-full">{{ $unreadTalentNotifs }}</span>
                            @endif
                        </a>
                        <a href="{{ route('influencer.verification') }}" @click="mobileSidebar = false" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.verification*') ? 'bg-emerald-50 text-emerald-700 font-bold border border-emerald-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                            <span>Verification & KYC</span>
                        </a>
                    </nav>
                </div>

                <!-- User Profile & Logout -->
                <div class="pt-3 border-t border-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-bold text-slate-900 text-sm truncate max-w-[140px]">{{ auth()->user()->talentProfile->display_name ?? auth()->user()->name }}</div>
                            <div class="text-[10px] text-pink-600 font-semibold uppercase">Verified Talent</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-slate-500 hover:text-slate-900 p-2 text-xs font-semibold">Exit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Sidebar (Light Mode with Social Media Palette) -->
    <aside class="w-64 bg-white text-slate-900 border-r border-slate-200 hidden md:flex flex-col justify-between p-6 flex-shrink-0 sticky top-0 h-screen overflow-y-auto">
        <div>
            <!-- Logo -->
            <div class="flex items-center space-x-3 mb-10">
                <div class="w-9 h-9 rounded-xl gradient-bg flex items-center justify-center font-bold text-white text-lg tracking-tight shadow-md">
                    TM
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">Talent <span class="text-pink-600">Portal</span></span>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1 text-sm font-medium">
                <a href="{{ route('influencer.dashboard') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.dashboard') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('influencer.portfolio') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.portfolio*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Portfolio & Work</span>
                </a>
                <a href="{{ route('influencer.rates') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.rates*') || request()->routeIs('influencer.gigs*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Gigs & Packages</span>
                </a>
                <a href="{{ route('influencer.social') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.social*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Social Accounts</span>
                </a>
                <a href="{{ route('influencer.campaigns') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.campaigns*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Open Brand Jobs</span>
                </a>
                <a href="{{ route('influencer.applications') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.applications*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>My Applications</span>
                </a>
                <a href="{{ route('influencer.messages') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.messages*') || request()->routeIs('influencer.chat*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <span>Messages & Offers</span>
                    </div>
                    @if($unreadTalentMsgs > 0)
                        <span class="px-2 py-0.5 bg-pink-600 text-white text-[10px] font-bold rounded-full">{{ $unreadTalentMsgs }}</span>
                    @endif
                </a>
                <a href="{{ route('influencer.bookings') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.bookings*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Bookings & Orders</span>
                </a>
                <a href="{{ route('influencer.invoices') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.invoices*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Invoices & Payouts</span>
                </a>
                <a href="{{ route('influencer.notifications') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl {{ request()->routeIs('influencer.notifications*') ? 'bg-pink-50 text-pink-600 font-semibold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <span>Notifications</span>
                    </div>
                    @if($unreadTalentNotifs > 0)
                        <span class="px-2 py-0.5 bg-amber-500 text-white text-[10px] font-bold rounded-full">{{ $unreadTalentNotifs }}</span>
                    @endif
                </a>
            </nav>
        </div>

        <!-- User Profile & Logout -->
        <div class="pt-6 border-t border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="font-bold text-slate-900 text-sm truncate max-w-[140px]">{{ auth()->user()->talentProfile->display_name ?? auth()->user()->name }}</div>
                    <div class="text-[10px] text-pink-600 font-semibold uppercase">Verified Talent</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-500 hover:text-slate-900 p-2 text-xs font-semibold">Exit</button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top Header -->
        <header class="sticky top-0 z-30 h-20 bg-white/95 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 md:px-8">
            <div class="flex items-center space-x-3">
                <!-- Mobile Hamburger Menu Button -->
                <button type="button" @click="mobileSidebar = true" class="md:hidden p-2 text-slate-600 hover:text-slate-900 rounded-xl hover:bg-slate-100 transition" title="Open navigation menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 truncate max-w-[160px] sm:max-w-xs">Studio — {{ auth()->user()->talentProfile->display_name ?? auth()->user()->name }}</h2>
                    <span class="hidden sm:inline-block px-2 py-0.5 bg-slate-100 text-slate-600 text-[11px] font-semibold rounded-md">Nashik Creator</span>
                </div>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-3" x-data="notificationDropdown('/influencer/notifications')">
                <!-- Global Command Palette Trigger -->
                <button type="button" 
                        @click="window.dispatchEvent(new KeyboardEvent('keydown', {'key':'k', 'ctrlKey':true}))"
                        class="hidden sm:flex items-center space-x-2 px-3 py-1.5 bg-slate-100 hover:bg-slate-200/80 text-slate-500 hover:text-slate-800 rounded-xl text-xs font-medium transition border border-slate-200/60"
                        title="Search anything (Ctrl+K)">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Quick Search...</span>
                    <kbd class="px-1.5 py-0.5 bg-white text-slate-400 rounded text-[10px] font-mono font-bold shadow-2xs">Ctrl+K</kbd>
                </button>

                <!-- Messages Shortcut -->
                <a href="{{ route('influencer.messages') }}" class="relative p-2 sm:p-2.5 text-slate-600 hover:text-pink-600 hover:bg-slate-100 rounded-xl transition" title="Direct Messages">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    @if($unreadTalentMsgs > 0)
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-pink-600 rounded-full ring-2 ring-white"></span>
                    @endif
                </a>

                <!-- Notification Bell Dropdown & Toast Trigger -->
                <div class="relative" @click.outside="open = false">
                    <button type="button" @click="toggleDropdown()" class="relative p-2 sm:p-2.5 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition group" title="Click to view notifications & toast alerts">
                        <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <template x-if="count > 0">
                            <span class="absolute top-1.5 right-1.5 w-4 h-4 bg-rose-500 text-white text-[9px] font-black rounded-full flex items-center justify-center ring-2 ring-white animate-pulse" x-text="count"></span>
                        </template>
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="open" x-cloak class="absolute right-0 mt-2 w-72 sm:w-96 bg-white border border-slate-200 rounded-2xl shadow-xl z-50 overflow-hidden">
                        <div class="p-3.5 sm:p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div class="flex items-center space-x-2">
                                <span class="font-bold text-xs text-slate-900">Notifications</span>
                                <template x-if="count > 0">
                                    <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[10px] font-black rounded-full border border-rose-100" x-text="count + ' New'"></span>
                                </template>
                            </div>
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('influencer.notifications') }}" class="text-[11px] font-bold text-slate-500 hover:text-slate-900 transition">View All</a>
                            </div>
                        </div>

                        <div class="max-h-72 overflow-y-auto divide-y divide-slate-100">
                            <template x-for="item in list" :key="item.id">
                                <a :href="item.action_url || '{{ route('influencer.notifications') }}'" class="p-3.5 block hover:bg-slate-50 transition" :class="!item.is_read ? 'bg-pink-50/20' : ''">
                                    <div class="flex items-start space-x-3">
                                        <span class="w-2 h-2 mt-1.5 rounded-full flex-shrink-0" :class="!item.is_read ? 'bg-pink-600 ring-2 ring-pink-200' : 'bg-transparent'"></span>
                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-slate-900 truncate" x-text="item.title"></p>
                                            <p class="text-[11px] text-slate-600 mt-0.5 line-clamp-2" x-text="item.body_short || item.body"></p>
                                            <span class="text-[10px] text-slate-400 font-medium block mt-1" x-text="item.time_ago"></span>
                                        </div>
                                    </div>
                                </a>
                            </template>
                            <template x-if="list.length === 0">
                                <div class="p-8 text-center text-xs text-slate-400">No new notifications</div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Find Open Jobs Button -->
                <a href="{{ route('influencer.campaigns') }}" class="px-3.5 sm:px-4 py-2 sm:py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-md shadow-indigo-500/20 whitespace-nowrap">
                    <span class="hidden sm:inline">Find Open Jobs</span>
                    <span class="sm:hidden">Find Jobs</span>
                </a>

                <!-- Talent Profile Dropdown (Top Right) -->
                <div class="relative pl-1 border-l border-slate-200" x-data="{ profileOpen: false }" @click.outside="profileOpen = false">
                    <button type="button" @click="profileOpen = !profileOpen" class="flex items-center space-x-2.5 p-1 rounded-xl hover:bg-slate-100 transition focus:outline-none" title="Creator Profile">
                        <div class="w-8 h-8 rounded-lg bg-pink-100 text-pink-700 border border-pink-200 overflow-hidden flex items-center justify-center font-bold text-xs flex-shrink-0">
                            @if(auth()->user()->talentProfile && auth()->user()->talentProfile->profile_image)
                                <img src="{{ auth()->user()->talentProfile->profile_image }}" class="w-full h-full object-cover">
                            @elseif(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" class="w-full h-full object-cover">
                            @else
                                <span>{{ strtoupper(substr(auth()->user()->talentProfile->display_name ?? auth()->user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="hidden xl:block text-left">
                            <div class="text-xs font-bold text-slate-900 truncate max-w-[110px]">{{ auth()->user()->talentProfile->display_name ?? auth()->user()->name }}</div>
                            <div class="text-[10px] text-slate-400 font-semibold leading-none">Creator Account</div>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :class="profileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="profileOpen" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-64 bg-white border border-slate-200 rounded-2xl shadow-xl z-50 overflow-hidden py-1.5 divide-y divide-slate-100">
                        <!-- Profile Header -->
                        <div class="px-4 py-3 bg-slate-50/70">
                            <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->talentProfile->display_name ?? auth()->user()->name }}</p>
                            <p class="text-[11px] text-slate-500 truncate font-medium mt-0.5">{{ auth()->user()->email }}</p>
                            @if(auth()->user()->talentProfile && auth()->user()->talentProfile->username)
                                <p class="text-[10px] text-pink-600 font-bold mt-1 font-mono">{{"@" . auth()->user()->talentProfile->username}}</p>
                            @endif
                            <div class="mt-2 inline-flex items-center px-2 py-0.5 bg-pink-50 text-pink-700 border border-pink-200 text-[10px] font-bold rounded-md">
                                <i data-lucide="sparkles" class="w-3 h-3 mr-1 text-pink-600"></i>
                                <span>Verified Talent</span>
                            </div>
                        </div>

                        <!-- Profile Action Links -->
                        <div class="py-1">
                            <a href="{{ route('influencer.profile') }}" @click="profileOpen = false" class="flex items-center space-x-2.5 px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-pink-600 transition">
                                <i data-lucide="user-cog" class="w-4 h-4 text-slate-400"></i>
                                <span>Edit Profile & Availability</span>
                            </a>
                            @if(auth()->user()->talentProfile && auth()->user()->talentProfile->username)
                                <a href="{{ route('influencers.public.show', auth()->user()->talentProfile->username) }}" target="_blank" @click="profileOpen = false" class="flex items-center space-x-2.5 px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-pink-600 transition">
                                    <i data-lucide="external-link" class="w-4 h-4 text-slate-400"></i>
                                    <span>View Live Media Kit</span>
                                </a>
                            @endif
                        </div>

                        <!-- Logout Button -->
                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="w-full flex items-center space-x-2.5 px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 transition text-left">
                                    <i data-lucide="log-out" class="w-4 h-4 text-rose-500"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <script>
        function notificationDropdown(endpoint) {
            return {
                open: false,
                count: {{ $unreadTalentNotifs }},
                list: [],
                
                init() {
                    if (window.location.pathname.includes('/notifications')) {
                        if (typeof window.setNotificationDropdownOpen === 'function') {
                            window.setNotificationDropdownOpen(true);
                        }
                    }

                    this.$watch('open', (val) => {
                        if (typeof window.setNotificationDropdownOpen === 'function') {
                            window.setNotificationDropdownOpen(val);
                        } else {
                            window.__isNotificationDropdownOpen = val;
                        }
                        if (val) {
                            this.list.forEach(n => {
                                if (window.recordToastedId) window.recordToastedId(n.id);
                            });
                        }
                    });

                    // Initial poll on page load/refresh: populates count/list but does not toast
                    this.poll(true);
                    setInterval(() => this.poll(false), 5000);
                },

                triggerToasts() {
                    // Strictly suppress toasts if viewing notifications page or dropdown is currently open
                    if (window.location.pathname.includes('/notifications') || this.open || window.__isNotificationDropdownOpen) {
                        return;
                    }

                    let delay = 150;
                    this.list.forEach((n) => {
                        // Toast only if not marked read, not currently in view, and never toasted before
                        if (!n.is_read && !window.hasBeenToasted(n.id) && !window.isCurrentlyViewing(n)) {
                            window.recordToastedId(n.id);
                            setTimeout(() => {
                                window.showToast({
                                    id: n.id,
                                    title: n.title,
                                    body: n.body,
                                    action_url: n.action_url,
                                    conversation_id: n.conversation_id,
                                    is_read: n.is_read,
                                    type: n.type || 'message'
                                });
                            }, delay);
                            delay += 350;
                        }
                    });
                },

                toggleDropdown() {
                    this.open = !this.open;
                    if (this.open) {
                        this.list.forEach(n => {
                            if (window.recordToastedId) window.recordToastedId(n.id);
                        });
                        if (typeof window.setNotificationDropdownOpen === 'function') {
                            window.setNotificationDropdownOpen(true);
                        }
                    } else {
                        if (typeof window.setNotificationDropdownOpen === 'function') {
                            window.setNotificationDropdownOpen(false);
                        }
                    }
                },

                async poll(isInitial = false) {
                    try {
                        const res = await fetch(endpoint + '/unread-count');
                        if (res.ok) {
                            const data = await res.json();
                            this.count = data.count;
                            this.list = data.notifications || [];
                            
                            if (isInitial) {
                                // On initial page load / refresh: record all existing unread notifications so they do not pop as toasts
                                this.list.forEach(n => {
                                    if (window.recordToastedId) window.recordToastedId(n.id);
                                });
                                return;
                            }

                            // If user is on /notifications or dropdown is open, mark all as seen and suppress toasts
                            if (window.location.pathname.includes('/notifications') || this.open || window.__isNotificationDropdownOpen) {
                                this.list.forEach(n => {
                                    if (window.recordToastedId) window.recordToastedId(n.id);
                                });
                            } else {
                                this.triggerToasts();
                            }
                        }
                    } catch (e) {}
                }
            };
        }
        </script>

        <!-- Main Body -->
        <main class="p-4 sm:p-6 md:p-8 lg:p-10 pb-24 md:pb-12 flex-grow max-w-7xl w-full mx-auto">
            @yield('content')
        </main>
    </div>

    <script>
        function initFontAwesomeIcons() {
            const iconMap = {
                'instagram': 'fa-brands fa-instagram',
                'youtube': 'fa-brands fa-youtube',
                'tiktok': 'fa-brands fa-tiktok',
                'twitter': 'fa-brands fa-x-twitter',
                'facebook': 'fa-brands fa-facebook',
                'linkedin': 'fa-brands fa-linkedin',
                'whatsapp': 'fa-brands fa-whatsapp',
                'google': 'fa-brands fa-google',
                'sparkles': 'fa-solid fa-wand-magic-sparkles',
                'sparkle': 'fa-solid fa-wand-magic-sparkles',
                'shield-check': 'fa-solid fa-shield-halved',
                'shield-alert': 'fa-solid fa-shield-halved',
                'shield': 'fa-solid fa-shield-halved',
                'check': 'fa-solid fa-check',
                'check-check': 'fa-solid fa-check-double',
                'check-circle': 'fa-solid fa-circle-check',
                'alert-triangle': 'fa-solid fa-triangle-exclamation',
                'alert-circle': 'fa-solid fa-circle-exclamation',
                'clock': 'fa-solid fa-clock',
                'user': 'fa-solid fa-user',
                'user-cog': 'fa-solid fa-user-gear',
                'users': 'fa-solid fa-users',
                'lock': 'fa-solid fa-lock',
                'key-round': 'fa-solid fa-key',
                'key': 'fa-solid fa-key',
                'message-circle': 'fa-solid fa-message',
                'messages-square': 'fa-solid fa-comments',
                'search': 'fa-solid fa-magnifying-glass',
                'external-link': 'fa-solid fa-arrow-up-right-from-square',
                'calendar': 'fa-solid fa-calendar-days',
                'credit-card': 'fa-solid fa-credit-card',
                'dollar-sign': 'fa-solid fa-dollar-sign',
                'image': 'fa-solid fa-image',
                'camera': 'fa-solid fa-camera',
                'film': 'fa-solid fa-film',
                'video': 'fa-solid fa-video',
                'play': 'fa-solid fa-play',
                'upload-cloud': 'fa-solid fa-cloud-arrow-up',
                'upload': 'fa-solid fa-upload',
                'trash-2': 'fa-solid fa-trash-can',
                'trash': 'fa-solid fa-trash-can',
                'edit': 'fa-solid fa-pen-to-square',
                'edit-3': 'fa-solid fa-pen-to-square',
                'settings': 'fa-solid fa-gear',
                'log-out': 'fa-solid fa-right-from-bracket',
                'arrow-right': 'fa-solid fa-arrow-right',
                'arrow-left': 'fa-solid fa-arrow-left',
                'eye': 'fa-solid fa-eye',
                'heart': 'fa-solid fa-heart',
                'share-2': 'fa-solid fa-share-nodes',
                'share': 'fa-solid fa-share-nodes',
                'bookmark': 'fa-solid fa-bookmark',
                'zap': 'fa-solid fa-bolt',
                'plus': 'fa-solid fa-plus',
                'refresh-cw': 'fa-solid fa-rotate',
                'building-2': 'fa-solid fa-building',
                'briefcase': 'fa-solid fa-briefcase',
                'badge-check': 'fa-solid fa-certificate',
                'file-badge-2': 'fa-solid fa-file-shield',
                'file-check': 'fa-solid fa-file-circle-check',
                'file-text': 'fa-solid fa-file-lines',
                'globe': 'fa-solid fa-globe',
                'car': 'fa-solid fa-car',
                'check-square': 'fa-solid fa-square-check',
                'send': 'fa-solid fa-paper-plane',
                'bell': 'fa-solid fa-bell',
                'phone': 'fa-solid fa-phone',
                'smartphone': 'fa-solid fa-mobile-screen',
                'star': 'fa-solid fa-star',
                'x': 'fa-solid fa-xmark',
                'menu': 'fa-solid fa-bars',
                'chevron-down': 'fa-solid fa-chevron-down',
                'chevron-up': 'fa-solid fa-chevron-up',
                'chevron-right': 'fa-solid fa-chevron-right',
                'chevron-left': 'fa-solid fa-chevron-left',
                'trending-up': 'fa-solid fa-arrow-trend-up',
                'activity': 'fa-solid fa-chart-line',
                'bar-chart-2': 'fa-solid fa-chart-simple',
                'pie-chart': 'fa-solid fa-chart-pie',
                'award': 'fa-solid fa-award',
            };

            document.querySelectorAll('[data-lucide]').forEach(el => {
                const icon = el.getAttribute('data-lucide');
                const fa = iconMap[icon] || `fa-solid fa-${icon}`;
                el.className = `${el.className} ${fa}`.trim();
                el.removeAttribute('data-lucide');
            });
        }
        document.addEventListener('DOMContentLoaded', initFontAwesomeIcons);
        document.addEventListener('alpine:initialized', initFontAwesomeIcons);
        // Also re-run after any dynamic Alpine/DOM changes
        setInterval(initFontAwesomeIcons, 600);
    </script>
</body>
</html>
