<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Brand Studio | Talent Marketplace')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#EEF2FF',
                            100: '#E0E7FF',
                            200: '#C7D2FE',
                            300: '#A5B4FC',
                            400: '#818CF8',
                            500: '#6366F1',
                            600: '#4F46E5',
                            700: '#4338CA',
                            800: '#3730A3',
                            900: '#312E81',
                            DEFAULT: '#4F46E5',
                        },
                        navy: {
                            900: '#0F172A',
                            800: '#1E293B',
                            700: '#334155',
                        },
                        studio: {
                            lime: '#E2F163',
                            vermilion: '#FF3E14',
                            emerald: '#10B981',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Outfit"', '"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"Space Grotesk"', 'monospace'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Alpine.js & FontAwesome 6 -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; color: #0F172A; }
        [x-cloak] { display: none !important; }
        .font-mono-numbers { font-family: 'Space Grotesk', monospace; }
        .font-display-title { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex relative" x-data="{ mobileSidebar: false }">

    <!-- Global Live Toast Container & Shell Overlays -->
    @include('components.toast-container')
    @include('components.command-palette')
    @include('components.mobile-bottom-nav')

    @php
        $unreadBrandMsgs = \App\Models\Message::whereHas('conversation', function($q) {
            $q->where('brand_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())->whereNull('read_at')->count();

        $unreadBrandNotifs = Auth::user()->appNotifications()->whereNull('read_at')->count();

        $activeBookingsCount = \App\Models\Booking::whereHas('campaign', function($q) {
            $q->where('brand_profile_id', Auth::user()->brandProfile->id ?? 0);
        })->whereIn('status', ['confirmed', 'in_progress', 'deliverables_submitted'])->count();
    @endphp

    <!-- Mobile Slide-over Drawer -->
    <div x-show="mobileSidebar" x-cloak class="relative z-[99999] md:hidden" role="dialog" aria-modal="true">
        <div x-show="mobileSidebar" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileSidebar = false" 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

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
                    <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center font-black text-white text-base shadow-md">
                                <i class="fa-solid fa-bolt text-sm text-[#E2F163]"></i>
                            </div>
                            <div>
                                <span class="font-display font-black text-lg text-slate-900 tracking-tight">Brand<span class="text-indigo-600">Studio</span></span>
                                <span class="block text-[10px] font-mono text-slate-400 uppercase tracking-widest">Client Console</span>
                            </div>
                        </div>
                        <button type="button" @click="mobileSidebar = false" class="p-2 text-slate-400 hover:text-slate-700 rounded-lg">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="space-y-1 text-xs font-semibold">
                        <p class="text-[10px] font-mono uppercase text-slate-400 tracking-wider px-3 mb-2 font-bold">Campaign Studio</p>
                        <a href="{{ route('brand.dashboard') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.dashboard') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-chart-pie w-4 text-center"></i>
                                <span>Overview</span>
                            </div>
                        </a>
                        <a href="{{ route('brand.campaigns') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.campaigns*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-briefcase w-4 text-center"></i>
                                <span>Jobs & Campaigns</span>
                            </div>
                        </a>
                        <a href="{{ route('influencers.public') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencers.public*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-compass w-4 text-center"></i>
                                <span>Search Talent</span>
                            </div>
                        </a>
                        <a href="{{ route('brand.lists.index') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.lists*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-bookmark w-4 text-center"></i>
                                <span>Talent Lists</span>
                            </div>
                        </a>

                        <p class="text-[10px] font-mono uppercase text-slate-400 tracking-wider px-3 pt-4 mb-2 font-bold">Collaborations</p>
                        <a href="{{ route('brand.messages') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.messages*') || request()->routeIs('brand.chat*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-comments w-4 text-center"></i>
                                <span>Messages & Offers</span>
                            </div>
                            @if($unreadBrandMsgs > 0)
                                <span class="px-2 py-0.5 bg-indigo-600 text-white text-[10px] font-bold rounded-full font-mono">{{ $unreadBrandMsgs }}</span>
                            @endif
                        </a>
                        <a href="{{ route('brand.bookings') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.bookings*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-layer-group w-4 text-center"></i>
                                <span>Active Bookings</span>
                            </div>
                            @if($activeBookingsCount > 0)
                                <span class="px-2 py-0.5 bg-emerald-500 text-white text-[10px] font-bold rounded-full font-mono">{{ $activeBookingsCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('brand.invoices') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.invoices*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-receipt w-4 text-center"></i>
                                <span>Tax Invoices & Billing</span>
                            </div>
                        </a>
                        <a href="{{ route('brand.notifications') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.notifications*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-bell w-4 text-center"></i>
                                <span>Notifications</span>
                            </div>
                            @if($unreadBrandNotifs > 0)
                                <span class="px-2 py-0.5 bg-amber-500 text-white text-[10px] font-bold rounded-full font-mono">{{ $unreadBrandNotifs }}</span>
                            @endif
                        </a>
                        <a href="{{ route('brand.profile') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.profile*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-building w-4 text-center"></i>
                                <span>Company Profile</span>
                            </div>
                        </a>
                    </nav>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-slate-900 text-xs truncate max-w-[130px]">{{ auth()->user()->brandProfile->company_name ?? auth()->user()->name }}</div>
                        <div class="text-[10px] text-indigo-600 font-mono">Verified Brand</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                            Exit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Sidebar -->
    <aside class="w-64 bg-white text-slate-900 border-r border-slate-200/80 hidden md:flex flex-col justify-between p-5 flex-shrink-0 sticky top-0 h-screen overflow-y-auto z-40">
        <div>
            <!-- Brand Logo -->
            <div class="flex items-center space-x-3 mb-8 px-2">
                <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center font-black text-white text-base shadow-md">
                    <i class="fa-solid fa-bolt text-sm text-[#E2F163]"></i>
                </div>
                <div>
                    <span class="font-display font-black text-lg text-slate-900 tracking-tight">Brand<span class="text-indigo-600">Studio</span></span>
                    <span class="block text-[9px] font-mono text-slate-400 uppercase tracking-widest">Client Console</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1 text-xs font-semibold">
                <p class="text-[10px] font-mono uppercase text-slate-400 tracking-wider px-3 mb-2 font-bold">Campaign Studio</p>

                <a href="{{ route('brand.dashboard') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.dashboard') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-chart-pie w-4 text-center {{ request()->routeIs('brand.dashboard') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                        <span>Overview</span>
                    </div>
                </a>

                <a href="{{ route('brand.campaigns') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.campaigns*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-briefcase w-4 text-center {{ request()->routeIs('brand.campaigns*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                        <span>Jobs & Campaigns</span>
                    </div>
                </a>

                <a href="{{ route('influencers.public') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencers.public*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-compass w-4 text-center {{ request()->routeIs('influencers.public*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                        <span>Search Talent</span>
                    </div>
                </a>

                <a href="{{ route('brand.lists.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.lists*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-bookmark w-4 text-center {{ request()->routeIs('brand.lists*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                        <span>Talent Lists</span>
                    </div>
                </a>

                <p class="text-[10px] font-mono uppercase text-slate-400 tracking-wider px-3 pt-5 mb-2 font-bold">Collaborations</p>

                <a href="{{ route('brand.messages') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.messages*') || request()->routeIs('brand.chat*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-comments w-4 text-center {{ request()->routeIs('brand.messages*') || request()->routeIs('brand.chat*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                        <span>Messages & Offers</span>
                    </div>
                    @if($unreadBrandMsgs > 0)
                        <span class="px-2 py-0.5 bg-indigo-600 text-white text-[10px] font-bold rounded-full font-mono">{{ $unreadBrandMsgs }}</span>
                    @endif
                </a>

                <a href="{{ route('brand.bookings') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.bookings*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-layer-group w-4 text-center {{ request()->routeIs('brand.bookings*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                        <span>Active Bookings</span>
                    </div>
                    @if($activeBookingsCount > 0)
                        <span class="px-2 py-0.5 bg-emerald-500 text-white text-[10px] font-bold rounded-full font-mono">{{ $activeBookingsCount }}</span>
                    @endif
                </a>

                <a href="{{ route('brand.invoices') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.invoices*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-receipt w-4 text-center {{ request()->routeIs('brand.invoices*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                        <span>Tax Invoices</span>
                    </div>
                </a>

                <a href="{{ route('brand.notifications') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.notifications*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-bell w-4 text-center {{ request()->routeIs('brand.notifications*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                        <span>Notifications</span>
                    </div>
                    @if($unreadBrandNotifs > 0)
                        <span class="px-2 py-0.5 bg-amber-500 text-white text-[10px] font-bold rounded-full font-mono">{{ $unreadBrandNotifs }}</span>
                    @endif
                </a>

                <a href="{{ route('brand.profile') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brand.profile*') ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-building w-4 text-center {{ request()->routeIs('brand.profile*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                        <span>Company Profile</span>
                    </div>
                </a>
            </nav>
        </div>

        <!-- User Profile & Logout -->
        <div class="pt-4 border-t border-slate-100">
            <div class="flex items-center justify-between bg-slate-50 p-2.5 rounded-xl border border-slate-200/80">
                <div class="flex items-center space-x-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-200 flex items-center justify-center font-bold text-xs flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->brandProfile->company_name ?? auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="font-bold text-slate-900 text-xs truncate max-w-[100px]">{{ auth()->user()->brandProfile->company_name ?? auth()->user()->name }}</div>
                        <div class="text-[9px] text-indigo-600 font-mono font-semibold uppercase">Verified Client</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-slate-800 p-1.5 transition text-xs" title="Logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0 bg-slate-50">
        <!-- Top Navbar -->
        <header class="sticky top-0 z-30 h-16 bg-white/95 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-3">
                <button type="button" @click="mobileSidebar = true" class="md:hidden p-2 text-slate-600 hover:text-slate-900 rounded-xl hover:bg-slate-100 transition" title="Open navigation menu">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>

                <div>
                    <h2 class="text-sm font-bold text-slate-900 truncate max-w-[160px] sm:max-w-xs">{{ auth()->user()->brandProfile->company_name ?? auth()->user()->name }}</h2>
                    <span class="text-[10px] font-mono text-slate-400">Escrow Milestone Protected</span>
                </div>
            </div>

            <div class="flex items-center space-x-2.5 sm:space-x-3" x-data="notificationDropdown('/brand/notifications')">
                <!-- Command Palette Trigger -->
                <button type="button" 
                        @click="window.dispatchEvent(new KeyboardEvent('keydown', {'key':'k', 'ctrlKey':true}))"
                        class="hidden sm:flex items-center space-x-2 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-medium transition border border-slate-200/60"
                        title="Search anything (Ctrl+K)">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
                    <span>Quick Search...</span>
                    <kbd class="px-1.5 py-0.5 bg-white text-slate-500 rounded text-[10px] font-mono font-bold shadow-2xs border border-slate-200">Ctrl+K</kbd>
                </button>

                <!-- Messages Shortcut -->
                <a href="{{ route('brand.messages') }}" class="relative p-2 text-slate-500 hover:text-indigo-600 hover:bg-slate-100 rounded-xl transition" title="Direct Messages">
                    <i class="fa-solid fa-comments text-base"></i>
                    @if($unreadBrandMsgs > 0)
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-indigo-600 rounded-full ring-2 ring-white"></span>
                    @endif
                </a>

                <!-- Notification Bell Dropdown -->
                <div class="relative" @click.outside="open = false">
                    <button type="button" @click="toggleDropdown()" class="relative p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition group" title="Notifications">
                        <i class="fa-solid fa-bell text-base transition-transform group-hover:rotate-12"></i>
                        <template x-if="count > 0">
                            <span class="absolute top-1.5 right-1.5 w-4 h-4 bg-rose-500 text-white text-[9px] font-black rounded-full flex items-center justify-center ring-2 ring-white animate-pulse" x-text="count"></span>
                        </template>
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="open" x-cloak class="absolute right-0 mt-2 w-72 sm:w-96 bg-white border border-slate-200 rounded-2xl shadow-xl z-50 overflow-hidden">
                        <div class="p-3.5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div class="flex items-center space-x-2">
                                <span class="font-bold text-xs text-slate-900">Notifications</span>
                                <template x-if="count > 0">
                                    <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[10px] font-black rounded-full border border-rose-100" x-text="count + ' New'"></span>
                                </template>
                            </div>
                            <a href="{{ route('brand.notifications') }}" class="text-[11px] font-bold text-indigo-600 hover:underline">View All</a>
                        </div>

                        <div class="max-h-72 overflow-y-auto divide-y divide-slate-100">
                            <template x-for="item in list" :key="item.id">
                                <a :href="item.action_url || '{{ route('brand.notifications') }}'" class="p-3.5 block hover:bg-slate-50 transition" :class="!item.is_read ? 'bg-indigo-50/20' : ''">
                                    <div class="flex items-start space-x-3">
                                        <span class="w-2 h-2 mt-1.5 rounded-full flex-shrink-0" :class="!item.is_read ? 'bg-indigo-600 ring-2 ring-indigo-200' : 'bg-transparent'"></span>
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

                <!-- Create Campaign Button -->
                <a href="{{ route('brand.campaigns.create') }}" class="px-3.5 sm:px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center space-x-1.5 whitespace-nowrap active:scale-95">
                    <i class="fa-solid fa-plus text-[11px]"></i>
                    <span class="hidden sm:inline">Post Campaign</span>
                    <span class="sm:hidden">Post</span>
                </a>

                <!-- Profile Dropdown -->
                <div class="relative pl-1 border-l border-slate-200" x-data="{ profileOpen: false }" @click.outside="profileOpen = false">
                    <button type="button" @click="profileOpen = !profileOpen" class="flex items-center space-x-2 p-1 rounded-xl hover:bg-slate-100 transition focus:outline-none">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-200 overflow-hidden flex items-center justify-center font-bold text-xs flex-shrink-0">
                            @if(auth()->user()->brandProfile && auth()->user()->brandProfile->logo)
                                <img src="{{ auth()->user()->brandProfile->logo }}" class="w-full h-full object-cover">
                            @elseif(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" class="w-full h-full object-cover">
                            @else
                                <span>{{ strtoupper(substr(auth()->user()->brandProfile->company_name ?? auth()->user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-[10px] transition-transform duration-200" :class="profileOpen ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="profileOpen" x-cloak class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-2xl shadow-xl z-50 overflow-hidden py-1 divide-y divide-slate-100">
                        <div class="px-4 py-3 bg-slate-50/70">
                            <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->brandProfile->company_name ?? auth()->user()->name }}</p>
                            <p class="text-[11px] text-slate-500 truncate font-mono mt-0.5">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('brand.profile') }}" class="flex items-center space-x-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition">
                                <i class="fa-solid fa-gear text-slate-400 text-xs"></i>
                                <span>Company Settings</span>
                            </a>
                        </div>
                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="w-full flex items-center space-x-2.5 px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition text-left">
                                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
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
                count: {{ $unreadBrandNotifs }},
                list: [],
                
                init() {
                    this.poll(true);
                    setInterval(() => this.poll(false), 8000);
                },

                triggerToasts() {
                    if (window.location.pathname.includes('/notifications') || this.open) return;
                    this.list.forEach((n) => {
                        if (!n.is_read && window.hasBeenToasted && !window.hasBeenToasted(n.id)) {
                            window.recordToastedId(n.id);
                            if (window.showToast) {
                                window.showToast({
                                    id: n.id,
                                    title: n.title,
                                    body: n.body,
                                    action_url: n.action_url,
                                    type: n.type || 'message'
                                });
                            }
                        }
                    });
                },

                toggleDropdown() {
                    this.open = !this.open;
                },

                async poll(isInitial = false) {
                    try {
                        const res = await fetch(endpoint + '/unread-count');
                        if (res.ok) {
                            const data = await res.json();
                            this.count = data.count;
                            this.list = data.notifications || [];
                            if (!isInitial) this.triggerToasts();
                        }
                    } catch (e) {}
                }
            };
        }
        </script>

        <!-- Main Body -->
        <main class="p-4 sm:p-6 lg:p-8 pb-24 md:pb-12 flex-grow max-w-7xl w-full mx-auto">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl mb-6 text-sm font-medium flex items-center space-x-3 shadow-xs">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl mb-6 text-sm font-medium flex items-center space-x-3 shadow-xs">
                    <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
