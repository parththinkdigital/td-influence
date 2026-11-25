<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Talent Studio | Talent Marketplace')</title>
    @vite(['resources/js/app.js'])

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        creator: {
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
                        studio: {
                            lime: '#E2F163',
                            vermilion: '#FF3E14',
                            emerald: '#10B981',
                            purple: '#8B5CF6',
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
<body class="bg-slate-50 text-slate-900 min-h-screen flex relative" x-data="{ mobileSidebar: false, copiedKit: false }">

    <!-- Global Live Toast Container & Shell Overlays -->
    @include('components.toast-container')
    @include('components.command-palette')
    @include('components.mobile-bottom-nav')

    @php
        $unreadTalentMsgs = \App\Models\Message::whereHas('conversation', function($q) {
            $q->where('talent_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())->whereNull('read_at')->count();

        $unreadTalentNotifs = Auth::user()->appNotifications()->whereNull('read_at')->count();

        $activeOrdersCount = \App\Models\Booking::where('talent_profile_id', Auth::user()->talentProfile->id ?? 0)
            ->whereIn('status', ['confirmed', 'in_progress', 'deliverables_submitted'])->count();

        $talentProfile = Auth::user()->talentProfile;
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
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-pink-600 to-rose-500 flex items-center justify-center font-black text-white text-base shadow-md">
                                <i class="fa-solid fa-sparkles text-sm text-[#E2F163]"></i>
                            </div>
                            <div>
                                <span class="font-display font-black text-lg text-slate-900 tracking-tight">Creator<span class="text-pink-600">Studio</span></span>
                                <span class="block text-[10px] font-mono text-slate-400 uppercase tracking-widest">Comp Card &amp; Gigs</span>
                            </div>
                        </div>
                        <button type="button" @click="mobileSidebar = false" class="p-2 text-slate-400 hover:text-slate-700 rounded-lg">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="space-y-1 text-xs font-semibold">
                        <p class="text-[10px] font-mono uppercase text-slate-400 tracking-wider px-3 mb-2 font-bold">Studio Hub</p>
                        <a href="{{ route('influencer.dashboard') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.dashboard') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-chart-line w-4 text-center"></i>
                                <span>Overview</span>
                            </div>
                        </a>
                        <a href="{{ route('influencer.portfolio') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.portfolio*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-images w-4 text-center"></i>
                                <span>Portfolio &amp; Lookbook</span>
                            </div>
                        </a>
                        <a href="{{ route('influencer.rates') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.rates*') || request()->routeIs('influencer.gigs*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-tags w-4 text-center"></i>
                                <span>Gigs &amp; Rate Cards</span>
                            </div>
                        </a>
                        <a href="{{ route('influencer.social') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.social*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-brands fa-instagram w-4 text-center"></i>
                                <span>Instagram &amp; Meta Sync</span>
                            </div>
                        </a>

                        <p class="text-[10px] font-mono uppercase text-slate-400 tracking-wider px-3 pt-4 mb-2 font-bold">Gigs &amp; Deals</p>
                        <a href="{{ route('influencer.campaigns') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.campaigns*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-bullhorn w-4 text-center"></i>
                                <span>Open Brand Briefs</span>
                            </div>
                        </a>
                        <a href="{{ route('influencer.applications') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.applications*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-paper-plane w-4 text-center"></i>
                                <span>My Proposals</span>
                            </div>
                        </a>
                        <a href="{{ route('influencer.messages') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.messages*') || request()->routeIs('influencer.chat*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-comments w-4 text-center"></i>
                                <span>Messages &amp; Offers</span>
                            </div>
                            @if($unreadTalentMsgs > 0)
                                <span class="px-2 py-0.5 bg-pink-600 text-white text-[10px] font-bold rounded-full font-mono">{{ $unreadTalentMsgs }}</span>
                            @endif
                        </a>
                        <a href="{{ route('influencer.bookings') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.bookings*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-box-archive w-4 text-center"></i>
                                <span>Orders &amp; Deliverables</span>
                            </div>
                            @if($activeOrdersCount > 0)
                                <span class="px-2 py-0.5 bg-emerald-500 text-white text-[10px] font-bold rounded-full font-mono">{{ $activeOrdersCount }}</span>
                            @endif
                        </a>

                        <p class="text-[10px] font-mono uppercase text-slate-400 tracking-wider px-3 pt-4 mb-2 font-bold">Account &amp; Trust</p>
                        <a href="{{ route('influencer.verification') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.verification*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-shield-halved w-4 text-center text-emerald-600"></i>
                                <span>Verification &amp; KYC</span>
                            </div>
                        </a>
                        <a href="{{ route('influencer.invoices') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.invoices*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-receipt w-4 text-center"></i>
                                <span>Invoices &amp; Payouts</span>
                            </div>
                        </a>
                        <a href="{{ route('influencer.notifications') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.notifications*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-bell w-4 text-center"></i>
                                <span>Notifications</span>
                            </div>
                            @if($unreadTalentNotifs > 0)
                                <span class="px-2 py-0.5 bg-amber-500 text-white text-[10px] font-bold rounded-full font-mono">{{ $unreadTalentNotifs }}</span>
                            @endif
                        </a>
                    </nav>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-slate-900 text-xs truncate max-w-[130px]">{{ $talentProfile->display_name ?? auth()->user()->name }}</div>
                        <div class="text-[10px] text-pink-600 font-mono">Level {{ $talentProfile->verification_level ?? 1 }} Creator</div>
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
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-pink-600 to-rose-500 flex items-center justify-center font-black text-white text-base shadow-md">
                    <i class="fa-solid fa-sparkles text-sm text-[#E2F163]"></i>
                </div>
                <div>
                    <span class="font-display font-black text-lg text-slate-900 tracking-tight">Creator<span class="text-pink-600">Studio</span></span>
                    <span class="block text-[9px] font-mono text-slate-400 uppercase tracking-widest">Comp Card &amp; Gigs</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1 text-xs font-semibold">
                <p class="text-[10px] font-mono uppercase text-slate-400 tracking-wider px-3 mb-2 font-bold">Studio Hub</p>

                <a href="{{ route('influencer.dashboard') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.dashboard') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-chart-line w-4 text-center {{ request()->routeIs('influencer.dashboard') ? 'text-pink-600' : 'text-slate-400' }}"></i>
                        <span>Overview</span>
                    </div>
                </a>

                <a href="{{ route('influencer.portfolio') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.portfolio*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-images w-4 text-center {{ request()->routeIs('influencer.portfolio*') ? 'text-pink-600' : 'text-slate-400' }}"></i>
                        <span>Portfolio &amp; Lookbook</span>
                    </div>
                </a>

                <a href="{{ route('influencer.rates') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.rates*') || request()->routeIs('influencer.gigs*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-tags w-4 text-center {{ request()->routeIs('influencer.rates*') || request()->routeIs('influencer.gigs*') ? 'text-pink-600' : 'text-slate-400' }}"></i>
                        <span>Gigs &amp; Rate Cards</span>
                    </div>
                </a>

                <a href="{{ route('influencer.social') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.social*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-brands fa-instagram w-4 text-center {{ request()->routeIs('influencer.social*') ? 'text-pink-600' : 'text-slate-400' }}"></i>
                        <span>Instagram &amp; Meta Sync</span>
                    </div>
                </a>

                <p class="text-[10px] font-mono uppercase text-slate-400 tracking-wider px-3 pt-5 mb-2 font-bold">Gigs &amp; Deals</p>

                <a href="{{ route('influencer.campaigns') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.campaigns*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-bullhorn w-4 text-center {{ request()->routeIs('influencer.campaigns*') ? 'text-pink-600' : 'text-slate-400' }}"></i>
                        <span>Open Brand Briefs</span>
                    </div>
                </a>

                <a href="{{ route('influencer.applications') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.applications*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-paper-plane w-4 text-center {{ request()->routeIs('influencer.applications*') ? 'text-pink-600' : 'text-slate-400' }}"></i>
                        <span>My Proposals</span>
                    </div>
                </a>

                <a href="{{ route('influencer.messages') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.messages*') || request()->routeIs('influencer.chat*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-comments w-4 text-center {{ request()->routeIs('influencer.messages*') || request()->routeIs('influencer.chat*') ? 'text-pink-600' : 'text-slate-400' }}"></i>
                        <span>Messages &amp; Offers</span>
                    </div>
                    @if($unreadTalentMsgs > 0)
                        <span class="px-2 py-0.5 bg-pink-600 text-white text-[10px] font-bold rounded-full font-mono">{{ $unreadTalentMsgs }}</span>
                    @endif
                </a>

                <a href="{{ route('influencer.bookings') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.bookings*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-box-archive w-4 text-center {{ request()->routeIs('influencer.bookings*') ? 'text-pink-600' : 'text-slate-400' }}"></i>
                        <span>Orders &amp; Deliverables</span>
                    </div>
                    @if($activeOrdersCount > 0)
                        <span class="px-2 py-0.5 bg-emerald-500 text-white text-[10px] font-bold rounded-full font-mono">{{ $activeOrdersCount }}</span>
                    @endif
                </a>

                <p class="text-[10px] font-mono uppercase text-slate-400 tracking-wider px-3 pt-5 mb-2 font-bold">Account &amp; Trust</p>

                <a href="{{ route('influencer.verification') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.verification*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-shield-halved w-4 text-center text-emerald-600"></i>
                        <span>Verification &amp; KYC</span>
                    </div>
                </a>

                <a href="{{ route('influencer.invoices') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.invoices*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-receipt w-4 text-center {{ request()->routeIs('influencer.invoices*') ? 'text-pink-600' : 'text-slate-400' }}"></i>
                        <span>Invoices &amp; Payouts</span>
                    </div>
                </a>

                <a href="{{ route('influencer.notifications') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('influencer.notifications*') ? 'bg-pink-50 text-pink-600 font-bold border border-pink-200 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-bell w-4 text-center {{ request()->routeIs('influencer.notifications*') ? 'text-pink-600' : 'text-slate-400' }}"></i>
                        <span>Notifications</span>
                    </div>
                    @if($unreadTalentNotifs > 0)
                        <span class="px-2 py-0.5 bg-amber-500 text-white text-[10px] font-bold rounded-full font-mono">{{ $unreadTalentNotifs }}</span>
                    @endif
                </a>
            </nav>
        </div>

        <!-- User Profile & Logout -->
        <div class="pt-4 border-t border-slate-100">
            <div class="flex items-center justify-between bg-slate-50 p-2.5 rounded-xl border border-slate-200/80">
                <div class="flex items-center space-x-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-pink-100 text-pink-600 border border-pink-200 flex items-center justify-center font-bold text-xs flex-shrink-0">
                        {{ strtoupper(substr($talentProfile->display_name ?? auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="font-bold text-slate-900 text-xs truncate max-w-[100px]">{{ $talentProfile->display_name ?? auth()->user()->name }}</div>
                        <div class="text-[9px] text-pink-600 font-mono font-semibold uppercase">Level {{ $talentProfile->verification_level ?? 1 }} Creator</div>
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

                <div class="flex items-center space-x-2">
                    <h2 class="text-sm font-bold text-slate-900 truncate max-w-[160px] sm:max-w-xs">{{ $talentProfile->display_name ?? auth()->user()->name }}</h2>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-pink-50 text-pink-700 border border-pink-200">
                        L{{ $talentProfile->verification_level ?? 1 }} Verified
                    </span>
                </div>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-3">
                <!-- Share Public Comp Card Button -->
                <button type="button" 
                        @click="
                            navigator.clipboard.writeText('{{ route('influencers.public.show', $talentProfile->username ?: ($talentProfile->id ?? 'me')) }}');
                            copiedKit = true;
                            setTimeout(() => copiedKit = false, 2500);
                        "
                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition border border-slate-200/80 active:scale-95"
                        title="Copy public comp card link">
                    <i class="fa-solid fa-share-nodes text-[11px] text-pink-600"></i>
                    <span x-text="copiedKit ? 'Copied Link!' : 'Share Comp Card'">Share Comp Card</span>
                </button>

                <!-- Command Palette Trigger -->
                <button type="button" 
                        @click="window.dispatchEvent(new KeyboardEvent('keydown', {'key':'k', 'ctrlKey':true}))"
                        class="hidden sm:flex items-center space-x-2 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-medium transition border border-slate-200/60"
                        title="Search anything (Ctrl+K)">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
                    <span>Search...</span>
                    <kbd class="px-1.5 py-0.5 bg-white text-slate-500 rounded text-[10px] font-mono font-bold shadow-2xs border border-slate-200">Ctrl+K</kbd>
                </button>

                <!-- Messages -->
                <a href="{{ route('influencer.messages') }}" class="relative p-2 text-slate-500 hover:text-pink-600 hover:bg-slate-100 rounded-xl transition" title="Direct Messages">
                    <i class="fa-solid fa-comments text-base"></i>
                    @if($unreadTalentMsgs > 0)
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-pink-600 rounded-full ring-2 ring-white"></span>
                    @endif
                </a>

                <!-- Profile Dropdown -->
                <div class="relative pl-1 border-l border-slate-200" x-data="{ profileOpen: false }" @click.outside="profileOpen = false">
                    <button type="button" @click="profileOpen = !profileOpen" class="flex items-center space-x-2 p-1 rounded-xl hover:bg-slate-100 transition focus:outline-none">
                        <div class="w-8 h-8 rounded-lg bg-pink-100 text-pink-600 border border-pink-200 overflow-hidden flex items-center justify-center font-bold text-xs flex-shrink-0">
                            @if($talentProfile && $talentProfile->profile_image)
                                <img src="{{ $talentProfile->profile_image }}" class="w-full h-full object-cover">
                            @elseif(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" class="w-full h-full object-cover">
                            @else
                                <span>{{ strtoupper(substr($talentProfile->display_name ?? auth()->user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-[10px] transition-transform duration-200" :class="profileOpen ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="profileOpen" x-cloak class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-2xl shadow-xl z-50 overflow-hidden py-1 divide-y divide-slate-100">
                        <div class="px-4 py-3 bg-slate-50/70">
                            <p class="text-xs font-bold text-slate-900 truncate">{{ $talentProfile->display_name ?? auth()->user()->name }}</p>
                            <p class="text-[11px] text-slate-500 truncate font-mono mt-0.5">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('influencer.profile') }}" class="flex items-center space-x-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-pink-600 transition">
                                <i class="fa-solid fa-user-pen text-slate-400 text-xs"></i>
                                <span>Edit Comp Card</span>
                            </a>
                            <a href="{{ route('influencer.verification') }}" class="flex items-center space-x-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-emerald-600 transition">
                                <i class="fa-solid fa-shield-halved text-emerald-500 text-xs"></i>
                                <span>KYC &amp; Verification</span>
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
