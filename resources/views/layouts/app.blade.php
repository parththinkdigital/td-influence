<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Talent Marketplace — Connect Brands with Models, Influencers, Anchors & UGC Creators')</title>
    
    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#EEF2FF',
                            100: '#E0E7FF',
                            500: '#6366F1',
                            600: '#4F46E5',
                            700: '#4338CA',
                        },
                        accent: {
                            blue: '#0866FF',
                            emerald: '#10B981',
                            amber: '#F59E0B',
                            pink: '#EC4899',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js & Font Awesome 6 Icons -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
            color: #0F172A;
        }
        .font-display {
            font-family: '"Plus Jakarta Sans"', 'Inter', sans-serif;
        }
        .btn-brand {
            background-color: #4F46E5;
            color: #FFFFFF;
        }
        .btn-brand:hover {
            background-color: #4338CA;
        }
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-100%); }
        }
        @keyframes marquee2 {
            0% { transform: translateX(100%); }
            100% { transform: translateX(0%); }
        }
        .animate-marquee {
            animation: marquee 35s linear infinite;
        }
        .animate-marquee2 {
            animation: marquee2 35s linear infinite;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 flex flex-col min-h-screen antialiased selection:bg-brand-50 selection:text-brand-600 relative">

    <!-- Global Live Toast Alert Container -->
    @include('components.toast-container')

    @auth
        @php
            $pollEndpoint = auth()->user()->isBrand() ? '/brand/notifications' : (auth()->user()->isTalent() ? '/influencer/notifications' : null);
        @endphp
        @if($pollEndpoint)
            <div x-data="globalNotifPoller('{{ $pollEndpoint }}')" class="hidden"></div>
            <script>
            function globalNotifPoller(endpoint) {
                return {
                    isInitial: true,
                    init() {
                        this.poll(true);
                        setInterval(() => this.poll(false), 4000);
                    },
                    async poll(isInitial = false) {
                        try {
                            if (window.location.pathname.includes('/notifications') || window.__isNotificationDropdownOpen) {
                                return;
                            }
                            const res = await fetch(endpoint + '/unread-count');
                            if (res.ok) {
                                const data = await res.json();
                                const notifs = data.notifications || [];

                                if (isInitial || this.isInitial) {
                                    this.isInitial = false;
                                    notifs.forEach(n => {
                                        if (window.recordToastedId) window.recordToastedId(n.id);
                                    });
                                    return;
                                }

                                if (window.location.pathname.includes('/notifications') || window.__isNotificationDropdownOpen) {
                                    notifs.forEach(n => {
                                        if (window.recordToastedId) window.recordToastedId(n.id);
                                    });
                                    return;
                                }

                                let delay = 150;
                                notifs.forEach(n => {
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
                            }
                        } catch(e) {}
                    }
                };
            }
            </script>
        @endif
    @endauth

    <!-- Top Navigation Bar (Clean Light) -->
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 transition duration-200" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center font-display font-black text-white text-lg shadow-sm group-hover:bg-brand-700 transition">
                        TM
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-black font-display tracking-tight text-slate-900 flex items-center gap-1">
                            Talent<span class="text-brand-600">Marketplace</span>
                        </span>
                        <span class="text-[10px] font-bold tracking-widest text-slate-500 uppercase">Creator & Brand Studio</span>
                    </div>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-1 font-semibold text-sm text-slate-600">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl transition {{ request()->routeIs('home') ? 'bg-slate-100 text-brand-600 font-bold' : 'hover:text-slate-900 hover:bg-slate-50' }}">
                        Discover
                    </a>
                    <a href="{{ route('influencers.public') }}" class="px-4 py-2 rounded-xl transition {{ request()->routeIs('influencers.public*') ? 'bg-slate-100 text-brand-600 font-bold' : 'hover:text-slate-900 hover:bg-slate-50' }}">
                        Talent Directory
                    </a>
                    <a href="{{ route('campaigns.public') }}" class="px-4 py-2 rounded-xl transition {{ request()->routeIs('campaigns.public*') ? 'bg-slate-100 text-brand-600 font-bold' : 'hover:text-slate-900 hover:bg-slate-50' }}">
                        Campaign Briefs
                    </a>
                    <a href="{{ route('how-it-works') }}" class="px-4 py-2 rounded-xl transition {{ request()->routeIs('how-it-works') ? 'bg-slate-100 text-brand-600 font-bold' : 'hover:text-slate-900 hover:bg-slate-50' }}">
                        How It Works
                    </a>
                    <a href="{{ route('pricing') }}" class="px-4 py-2 rounded-xl transition {{ request()->routeIs('pricing') ? 'bg-slate-100 text-brand-600 font-bold' : 'hover:text-slate-900 hover:bg-slate-50' }}">
                        Pricing
                    </a>
                </div>

                <!-- Right Action Buttons -->
                <div class="hidden md:flex items-center space-x-3 text-sm">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl font-bold bg-slate-900 hover:bg-black text-white transition shadow-sm flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-accent-purple"></span>
                                <span>Admin Gateway</span>
                            </a>
                        @elseif(auth()->user()->isBrand())
                            <a href="{{ route('brand.dashboard') }}" class="px-4 py-2.5 rounded-xl font-bold btn-brand text-white transition shadow-sm flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span>Brand Studio</span>
                            </a>
                        @else
                            <a href="{{ route('influencer.dashboard') }}" class="px-4 py-2.5 rounded-xl font-bold btn-brand text-white transition shadow-sm flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span>Creator Studio</span>
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-2 text-slate-500 hover:text-slate-900 transition text-xs font-semibold">Log out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-slate-700 hover:text-slate-900 font-bold text-sm transition">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="btn-brand px-5 py-2.5 rounded-xl font-bold text-white shadow-sm hover:shadow transition text-sm flex items-center space-x-1.5">
                            <span>Join Marketplace</span>
                            <span class="text-xs">&rarr;</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="p-2 text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-100 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="open" class="md:hidden bg-white border-b border-slate-200 px-4 py-5 space-y-3" x-cloak>
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50 font-medium">Discover</a>
            <a href="{{ route('influencers.public') }}" class="block px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50 font-medium">Talent Directory</a>
            <a href="{{ route('campaigns.public') }}" class="block px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50 font-medium">Campaign Briefs</a>
            <a href="{{ route('how-it-works') }}" class="block px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50 font-medium">How It Works</a>
            <a href="{{ route('pricing') }}" class="block px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50 font-medium">Pricing</a>
            <div class="pt-3 border-t border-slate-200 space-y-2">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block w-full text-center py-2.5 rounded-xl font-bold bg-slate-900 text-white">Admin Gateway</a>
                    @elseif(auth()->user()->isBrand())
                        <a href="{{ route('brand.dashboard') }}" class="block w-full text-center py-2.5 rounded-xl font-bold btn-brand text-white">Brand Studio</a>
                    @else
                        <a href="{{ route('influencer.dashboard') }}" class="block w-full text-center py-2.5 rounded-xl font-bold btn-brand text-white">Creator Studio</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-center py-2 text-slate-500 hover:text-slate-900 text-xs font-semibold">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center py-2.5 rounded-xl text-slate-800 bg-slate-100 hover:bg-slate-200 font-bold text-sm">Sign In</a>
                    <a href="{{ route('register') }}" class="block w-full text-center py-2.5 rounded-xl btn-brand text-white font-bold text-sm">Join Marketplace</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Notifications -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-2xl flex items-center justify-between text-sm font-medium shadow-xs">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 inline-block shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-5 py-3.5 rounded-2xl flex items-center justify-between text-sm font-medium shadow-xs">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600 inline-block shrink-0"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Immersive Footer inspired by carolynlee.me -->
    <footer class="relative mt-24" id="site-footer">
        <div id="tm-footer-inner" class="relative flex w-full flex-col overflow-hidden"
             style="background-image:url('/footer-scene.jpg');background-size:cover;background-position:center 60%;min-height:100vh;">

            {{-- Paper SVG — covers FULL footer height; JS sets viewBox + punches holes --}}
            <svg id="tm-paper-svg" class="absolute inset-0 z-10 block h-full w-full" preserveAspectRatio="none" viewBox="0 0 1440 600" xmlns="http://www.w3.org/2000/svg" style="pointer-events:none;">
                <defs>
                    <filter id="tmGrain" x="0" y="0" width="100%" height="100%">
                        <feTurbulence type="fractalNoise" baseFrequency="0.85" numOctaves="2" seed="5"/>
                        <feColorMatrix values="0 0 0 0 0  0 0 0 0 0  0 0 0 0 0  0 0 0 .07 0"/>
                        <feComposite in2="SourceGraphic" operator="in"/>
                    </filter>
                    <mask id="tmPaperMask" maskUnits="userSpaceOnUse" x="0" y="0" width="1440" height="600">
                        <rect id="tm-mask-bg" x="0" y="0" width="1440" height="600" fill="white"/>
                        {{-- JS appends one <path fill="black"> per click — they accumulate --}}
                    </mask>
                </defs>
                {{-- Green paper — top portion only; JS updates height to match content div --}}
                <rect id="tm-green-rect" x="0" y="0" width="1440" height="320" fill="#9CC4A4" mask="url(#tmPaperMask)"/>
                <rect id="tm-grain-rect" x="0" y="0" width="1440" height="320" fill="#000" mask="url(#tmPaperMask)" filter="url(#tmGrain)" opacity="0.4" style="mix-blend-mode:multiply"/>
            </svg>

            {{-- Content area — sits above the SVG --}}
            <div id="tm-content-div" class="relative" style="min-height:55vh;">
                {{-- Footer Content --}}
                <div class="pointer-events-none relative z-20 flex flex-col justify-between gap-8 px-6 py-8 sm:px-12 sm:py-10" style="color:#12161d; min-height:55vh;">

                    {{-- Top row: brand + nav columns --}}
                    <div class="flex flex-col gap-8 md:grid md:items-start" style="grid-template-columns: 1.6fr auto auto auto; gap: 3.5rem;">

                        {{-- Brand --}}
                        <div>
                            <span class="block font-sans font-black leading-none" style="font-size:clamp(32px,5vw,58px);letter-spacing:-0.03em;opacity:0.65;color:#12161d;">
                                Talent<br>Marketplace
                            </span>
                            <p class="mt-3 text-xs leading-relaxed max-w-xs font-mono" style="color:#12161d;opacity:0.6;">
                                The full-cycle talent platform connecting premium brands with verified models, influencers, anchors & UGC creators.
                            </p>
                        </div>

                        {{-- Discover --}}
                        <nav aria-label="Discover" class="pointer-events-auto">
                            <h4 class="mb-3 font-mono text-[10px] font-normal uppercase tracking-[0.14em]" style="color:#12161d;opacity:0.55;">Discover</h4>
                            <ul class="flex flex-col gap-2 font-sans text-[14px]" style="color:#12161d;">
                                <li><a href="{{ route('influencers.public', ['talent_type' => 'influencer']) }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">Social Influencers</a></li>
                                <li><a href="{{ route('influencers.public', ['talent_type' => 'modeling']) }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">Fashion Models</a></li>
                                <li><a href="{{ route('influencers.public', ['talent_type' => 'anchor']) }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">Event Anchors</a></li>
                                <li><a href="{{ route('influencers.public', ['talent_type' => 'ugc']) }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">UGC Creators</a></li>
                                <li><a href="{{ route('campaigns.public') }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">Open Briefs</a></li>
                            </ul>
                        </nav>

                        {{-- Platform --}}
                        <nav aria-label="Platform" class="pointer-events-auto">
                            <h4 class="mb-3 font-mono text-[10px] font-normal uppercase tracking-[0.14em]" style="color:#12161d;opacity:0.55;">Platform</h4>
                            <ul class="flex flex-col gap-2 font-sans text-[14px]" style="color:#12161d;">
                                <li><a href="{{ route('how-it-works') }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">How It Works</a></li>
                                <li><a href="{{ route('pricing') }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">Pricing & Escrow</a></li>
                                <li><a href="{{ route('about') }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">About</a></li>
                                <li><a href="{{ route('contact') }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">Contact & Help</a></li>
                            </ul>
                        </nav>

                        {{-- Portals + Social --}}
                        <div class="pointer-events-auto">
                            <h4 class="mb-3 font-mono text-[10px] font-normal uppercase tracking-[0.14em]" style="color:#12161d;opacity:0.55;">Portals</h4>
                            <ul class="flex flex-col gap-2 font-sans text-[14px]" style="color:#12161d;">
                                <li><a href="{{ route('brand.login') }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">Brand Studio</a></li>
                                <li><a href="{{ route('login') }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">Creator Studio</a></li>
                                <li><a href="{{ route('admin.login') }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">Admin Gateway</a></li>
                                <li><a href="{{ route('register') }}" class="pointer-events-auto font-bold transition-opacity hover:opacity-60" style="color:#12161d;">+ Create Account ↗</a></li>
                            </ul>
                            <div class="mt-5">
                                <h4 class="mb-3 font-mono text-[10px] font-normal uppercase tracking-[0.14em]" style="color:#12161d;opacity:0.55;">Legal</h4>
                                <ul class="flex flex-col gap-2 font-sans text-[14px]" style="color:#12161d;">
                                    <li><a href="{{ route('privacy') }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">Privacy Policy</a></li>
                                    <li><a href="{{ route('terms') }}" class="pointer-events-auto transition-opacity hover:opacity-60" style="color:#12161d;">Terms of Service</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    {{-- Bottom bar --}}
                    <div class="flex flex-wrap items-center justify-between gap-x-6 gap-y-2 font-mono text-[10px] uppercase tracking-[0.1em]" style="color:#12161d;opacity:0.55;">
                        <span>&copy; {{ date('Y') }} Talent Marketplace · Built with precision &amp; passion</span>
                        <span class="flex items-center gap-[10px] whitespace-nowrap">
                            <span id="tm-footer-pulse" class="inline-block h-1.5 w-1.5 rounded-full" style="background:#12161d;animation:tmPulse 1.6s ease-in-out infinite;"></span>
                            click to punch &nbsp;·&nbsp; ← → to cycle shapes
                        </span>
                    </div>

                </div>
            </div>

            {{-- Lower scenic area (Layer 2) --}}
            <div id="tm-scenic-area" style="min-height:45vh;flex:1;display:block;"></div>

            {{-- Falling / Draggable punched shapes layer --}}
            <div class="pointer-events-none absolute inset-0 z-30" id="tm-footer-shape-layer" style="overflow:hidden;"></div>

            {{-- New sheet / reset button --}}
            <button id="tm-new-sheet-btn"
                    class="absolute z-40 inline-flex items-center gap-2 rounded-full font-mono text-[10px] uppercase tracking-[0.12em] text-white opacity-90 hover:opacity-100 transition-opacity"
                    style="right:18px;bottom:18px;background:rgba(0,0,0,0.65);backdrop-filter:blur(6px);border:0;padding:9px 16px 9px 12px;cursor:pointer;">
                <svg width="11" height="11" viewBox="0 0 11 11">
                    <path d="M1 5.5 A 4.5 4.5 0 1 1 5.5 10" fill="none" stroke="white" stroke-width="1.4" stroke-linecap="round"/>
                    <path d="M1 1 V 5.5 H 5.5" fill="none" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                new sheet
            </button>

        </div>
    </footer>

    {{-- Custom cursor: shape outline, follows mouse, only visible inside footer --}}
    <div id="tm-cursor" aria-hidden="true" style="position:fixed;top:0;left:0;pointer-events:none;z-index:99999;display:none;will-change:transform;">
        <svg width="80" height="80" viewBox="-40 -40 80 80" style="display:block;overflow:visible;">
            <path id="tm-cursor-path"
                  d="M 0 -42 C 22 -52 42 -32 32 -10 C 50 -2 50 26 26 30 C 30 50 4 56 -4 38 C -22 52 -42 32 -32 14 C -52 8 -48 -22 -26 -22 C -22 -42 -10 -50 0 -42 Z"
                  fill="none"
                  stroke="rgba(18,22,29,0.85)"
                  stroke-width="1.8"
                  style="transform:scale(0.85);"/>
        </svg>
    </div>

    <style>
        @keyframes tmPulse {
            0%,100% { opacity:1;  transform:scale(1);   }
            50%      { opacity:.35; transform:scale(.6); }
        }
        /* Hide native cursor only inside the green paper zone */
        #tm-content-div,
        #tm-content-div * { cursor: none !important; }
        #tm-content-div a,
        #tm-content-div button { cursor: pointer !important; }
        /* Scenic photo area keeps its native cursor */
        #tm-scenic-area { cursor: auto; }
    </style>

    <script>
    (function () {
        'use strict';

        /* ── Shape library ────────────────────────────── */
        var SHAPES = [
            /* flower  */ 'M 0 -42 C 22 -52 42 -32 32 -10 C 50 -2 50 26 26 30 C 30 50 4 56 -4 38 C -22 52 -42 32 -32 14 C -52 8 -48 -22 -26 -22 C -22 -42 -10 -50 0 -42 Z',
            /* star    */ 'M 0 -44 L 10 -15 L 40 -15 L 16 5 L 26 34 L 0 18 L -26 34 L -16 5 L -40 -15 L -10 -15 Z',
            /* heart   */ 'M 0 38 C -4 34 -40 14 -40 -10 C -40 -28 -26 -40 0 -20 C 26 -40 40 -28 40 -10 C 40 14 4 34 0 38 Z',
            /* blob    */ 'M 38 -8 C 44 12 28 42 4 44 C -20 46 -44 28 -42 4 C -40 -20 -18 -44 8 -42 C 34 -40 32 -28 38 -8 Z',
            /* diamond */ 'M 0 -44 L 30 0 L 0 44 L -30 0 Z',
        ];

        var SHAPE_HALF = 44;
        var HOLE_RADIUS = 50;

        var shapeIdx = 0;

        /* DOM refs */
        var footerEl, paperSvgEl, maskEl, contentDivEl, greenRectEl, grainRectEl, maskBgEl;
        var shapeLayerEl;
        var cursorEl, cursorPathEl;
        var btnEl;

        /* ViewBox dimensions — set dynamically in init() */
        var VB_W = 1440, VB_H = 600;

        /* ── Helpers ──────────────────────────────────── */
        function mod(n, m) { return ((n % m) + m) % m; }

        function clientToSvgCoords(cx, cy) {
            var rect = paperSvgEl.getBoundingClientRect();
            return {
                x: ((cx - rect.left) / rect.width)  * VB_W,
                y: ((cy - rect.top)  / rect.height) * VB_H
            };
        }

        /* ── Create a falling / draggable cutout piece ──── */
        function spawnFallingPiece(clientX, clientY, currentPath, rotAngle) {
            if (!shapeLayerEl) return;
            var layerRect = shapeLayerEl.getBoundingClientRect();
            var startX = clientX - layerRect.left;
            var startY = clientY - layerRect.top;

            // Target landing zone in the lower scenic area (Layer 2)
            var layerHeight = layerRect.height;
            var cRect = contentDivEl ? contentDivEl.getBoundingClientRect() : null;
            var contentBottom = cRect ? (cRect.bottom - layerRect.top) : (layerHeight * 0.55);
            var landingMinY = contentBottom + 25;
            var landingMaxY = layerHeight - 75;
            if (landingMaxY <= landingMinY) {
                landingMaxY = layerHeight - 40;
                landingMinY = Math.max(contentBottom + 10, layerHeight - 80);
            }

            // Target Y with random variation and slight horizontal drift
            var targetY = landingMinY + Math.random() * (landingMaxY - landingMinY);
            var driftX = (Math.random() - 0.5) * 80;
            var targetX = Math.max(30, Math.min(layerRect.width - 70, startX + driftX));
            var targetRot = parseFloat(rotAngle) + (Math.random() * 90 - 45);

            var svgNs = 'http://www.w3.org/2000/svg';
            var pieceSvg = document.createElementNS(svgNs, 'svg');
            pieceSvg.setAttribute('width', '84');
            pieceSvg.setAttribute('height', '84');
            pieceSvg.setAttribute('viewBox', '-42 -42 84 84');
            pieceSvg.style.position = 'absolute';
            pieceSvg.style.left = '0';
            pieceSvg.style.top = '0';
            pieceSvg.style.pointerEvents = 'auto';
            pieceSvg.style.cursor = 'grab';
            pieceSvg.style.touchAction = 'none';
            pieceSvg.style.filter = 'drop-shadow(0 4px 8px rgba(0,0,0,0.22))';
            pieceSvg.style.willChange = 'transform';
            pieceSvg.style.transform = 'translate(' + (startX - 42) + 'px,' + (startY - 42) + 'px) rotate(' + rotAngle + 'deg)';

            var p = document.createElementNS(svgNs, 'path');
            p.setAttribute('d', currentPath);
            p.setAttribute('fill', '#9CC4A4');
            p.setAttribute('stroke', 'rgba(18,22,29,0.08)');
            p.setAttribute('stroke-width', '1');
            pieceSvg.appendChild(p);

            shapeLayerEl.appendChild(pieceSvg);

            // Animate fall using smooth gravity curve
            var posX = startX - 42;
            var posY = startY - 42;
            var endPosX = targetX - 42;
            var endPosY = targetY - 42;
            var currentRot = parseFloat(rotAngle) || 0;

            var fallDuration = 850 + Math.random() * 250; // ms

            // Store current position for dragging
            var state = {
                x: startX - 42,
                y: startY - 42,
                rot: currentRot,
                isDragging: false,
                isFalling: true,
                startX: 0,
                startY: 0,
                initialX: 0,
                initialY: 0
            };

            // Start drop animation
            requestAnimationFrame(function () {
                pieceSvg.style.transition = 'transform ' + (fallDuration / 1000) + 's cubic-bezier(0.25, 0.46, 0.45, 0.94), filter 0.25s';
                pieceSvg.style.transform = 'translate(' + endPosX + 'px,' + endPosY + 'px) rotate(' + targetRot + 'deg)';
            });

            var fallTimer = setTimeout(function () {
                state.isFalling = false;
                state.x = endPosX;
                state.y = endPosY;
                state.rot = targetRot;
                pieceSvg.style.transition = 'filter 0.2s';
            }, fallDuration);

            // Make the piece draggable
            function onDragStart(e) {
                if (state.isFalling) {
                    clearTimeout(fallTimer);
                    state.isFalling = false;
                    // Freeze at current computed transform
                    var style = window.getComputedStyle(pieceSvg);
                    var matrix = style.transform;
                    if (matrix && matrix !== 'none') {
                        var values = matrix.split('(')[1].split(')')[0].split(',');
                        var a = parseFloat(values[0]);
                        var b = parseFloat(values[1]);
                        var tx = parseFloat(values[4]);
                        var ty = parseFloat(values[5]);
                        state.x = isNaN(tx) ? endPosX : tx;
                        state.y = isNaN(ty) ? endPosY : ty;
                        state.rot = isNaN(a) ? targetRot : Math.round(Math.atan2(b, a) * (180 / Math.PI));
                    }
                }
                state.isDragging = true;
                pieceSvg.style.transition = 'none';
                pieceSvg.style.cursor = 'grabbing';
                pieceSvg.style.filter = 'drop-shadow(0 12px 24px rgba(0,0,0,0.38))';
                var pt = e.touches ? e.touches[0] : e;
                state.startX = pt.clientX;
                state.startY = pt.clientY;
                state.initialX = state.x;
                state.initialY = state.y;

                function onDragMove(moveEvt) {
                    if (!state.isDragging) return;
                    var mPt = moveEvt.touches ? moveEvt.touches[0] : moveEvt;
                    var dx = mPt.clientX - state.startX;
                    var dy = mPt.clientY - state.startY;
                    state.x = state.initialX + dx;
                    state.y = state.initialY + dy;
                    state.rot += (dx * 0.08);
                    pieceSvg.style.transform = 'translate(' + state.x + 'px,' + state.y + 'px) rotate(' + state.rot + 'deg)';
                    moveEvt.preventDefault();
                }

                function onDragEnd() {
                    state.isDragging = false;
                    pieceSvg.style.cursor = 'grab';
                    pieceSvg.style.filter = 'drop-shadow(0 4px 8px rgba(0,0,0,0.22))';
                    document.removeEventListener('mousemove', onDragMove);
                    document.removeEventListener('mouseup', onDragEnd);
                    document.removeEventListener('touchmove', onDragMove);
                    document.removeEventListener('touchend', onDragEnd);
                }

                document.addEventListener('mousemove', onDragMove);
                document.addEventListener('mouseup', onDragEnd);
                document.addEventListener('touchmove', onDragMove, { passive: false });
                document.addEventListener('touchend', onDragEnd);

                e.preventDefault();
                e.stopPropagation();
            }

            pieceSvg.addEventListener('mousedown', onDragStart);
            pieceSvg.addEventListener('touchstart', onDragStart, { passive: false });
        }

        /* ── Punch hole — ACCUMULATES, never replaces ──── */
        function punchAt(cx, cy) {
            if (!maskEl) { return; }
            var pt = clientToSvgCoords(cx, cy);
            var scale = HOLE_RADIUS / SHAPE_HALF;
            var rot = (Math.random() * 60 - 30).toFixed(1);

            // 1. Cut hole in the green paper mask
            var hole = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            hole.setAttribute('fill', 'black');
            hole.setAttribute('d', SHAPES[shapeIdx]);
            hole.setAttribute('transform',
                'translate(' + pt.x.toFixed(1) + ' ' + pt.y.toFixed(1) + ')'
                + ' rotate(' + rot + ')'
                + ' scale(' + scale.toFixed(3) + ')');
            maskEl.appendChild(hole);

            // 2. Spawn the cut piece and drop it down to the scenic bottom area
            spawnFallingPiece(cx, cy, SHAPES[shapeIdx], rot);
        }

        /* ── Shape change ── */
        function applyShape() {
            var d = SHAPES[shapeIdx];
            if (cursorPathEl) { cursorPathEl.setAttribute('d', d); }
        }

        /* ── Custom cursor ────────────────────────────── */
        function moveCursor(cx, cy) {
            if (!cursorEl) { return; }
            cursorEl.style.transform = 'translate(' + (cx - 40) + 'px,' + (cy - 40) + 'px)';
        }

        /* ── Cycle shapes ─────────────────────────────── */
        function cycleShape(delta) {
            shapeIdx = mod(shapeIdx + delta, SHAPES.length);
            applyShape();
        }

        /* ── Reset sheet ──────────────────────────────── */
        function resetSheet() {
            // Remove all punched holes from mask
            if (maskEl) {
                var holes = maskEl.querySelectorAll('path');
                holes.forEach(function (h) { h.remove(); });
            }
            // Remove all falling cutouts
            if (shapeLayerEl) {
                shapeLayerEl.innerHTML = '';
            }
        }

        /* ── Init ─────────────────────────────────────── */
        function init() {
            footerEl     = document.getElementById('site-footer');
            paperSvgEl   = document.getElementById('tm-paper-svg');
            maskEl       = document.getElementById('tmPaperMask');
            maskBgEl     = document.getElementById('tm-mask-bg');
            greenRectEl  = document.getElementById('tm-green-rect');
            grainRectEl  = document.getElementById('tm-grain-rect');
            contentDivEl = document.getElementById('tm-content-div');
            shapeLayerEl = document.getElementById('tm-footer-shape-layer');
            cursorEl     = document.getElementById('tm-cursor');
            cursorPathEl = document.getElementById('tm-cursor-path');
            btnEl        = document.getElementById('tm-new-sheet-btn');

            if (!footerEl || !paperSvgEl || !maskEl) { return; }

            function updateDimensions() {
                var innerEl = document.getElementById('tm-footer-inner');
                if (!innerEl || !paperSvgEl || !maskEl) { return; }
                VB_H = Math.round(innerEl.getBoundingClientRect().height) || 600;
                paperSvgEl.setAttribute('viewBox', '0 0 ' + VB_W + ' ' + VB_H);
                if (maskBgEl) {
                    maskBgEl.setAttribute('height', VB_H);
                    maskBgEl.setAttribute('width', VB_W);
                }
                maskEl.setAttribute('height', VB_H);
                maskEl.setAttribute('width', VB_W);

                if (contentDivEl) {
                    var pxH = contentDivEl.getBoundingClientRect().height;
                    var vbH = Math.round((pxH / innerEl.getBoundingClientRect().height) * VB_H);
                    if (greenRectEl) { greenRectEl.setAttribute('height', vbH); }
                    if (grainRectEl) { grainRectEl.setAttribute('height', vbH); }
                }
            }

            updateDimensions();
            window.addEventListener('resize', updateDimensions);
            window.addEventListener('load', updateDimensions);

            /* ── Paper zone: full green paper section (content div), NOT the scenic photo below ── */
            function isInPaperZone(clientY) {
                if (!contentDivEl) { return true; }
                var r = contentDivEl.getBoundingClientRect();
                return clientY >= r.top && clientY <= r.bottom;
            }

            /* ── Footer mouse events ── */
            footerEl.addEventListener('mouseenter', function (e) {
                if (cursorEl && isInPaperZone(e.clientY)) { cursorEl.style.display = 'block'; }
            });
            footerEl.addEventListener('mouseleave', function () {
                if (cursorEl) { cursorEl.style.display = 'none'; }
            });
            footerEl.addEventListener('mousemove', function (e) {
                if (isInPaperZone(e.clientY)) {
                    moveCursor(e.clientX, e.clientY);
                    if (cursorEl) { cursorEl.style.display = 'block'; }
                } else {
                    if (cursorEl) { cursorEl.style.display = 'none'; }
                }
            });

            /* Click punches a hole only in the green paper zone */
            footerEl.addEventListener('click', function (e) {
                if (!isInPaperZone(e.clientY)) { return; }  // scenic photo — no punch
                if (e.target.closest('a') || e.target.closest('button')) { return; }
                if (e.target.closest('svg') && e.target.closest('svg').parentNode === shapeLayerEl) { return; }
                punchAt(e.clientX, e.clientY);
            });

            /* New sheet button */
            if (btnEl) {
                btnEl.addEventListener('click', function (e) {
                    e.stopPropagation();
                    resetSheet();
                });
            }

            /* Arrow key cycling */
            document.addEventListener('keydown', function (e) {
                if (e.key === 'ArrowRight') { cycleShape(1); }
                if (e.key === 'ArrowLeft')  { cycleShape(-1); }
            });
        }

        document.addEventListener('DOMContentLoaded', init);
    }());
    </script>

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
    </script>
</body>
</html>
