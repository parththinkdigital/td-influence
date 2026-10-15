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

    <!-- Editorial Footer (Light Mode) -->
    <footer class="bg-white border-t border-slate-200 mt-24 text-slate-600 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-10">
                <!-- Brand Info -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-brand-600 flex items-center justify-center font-display font-black text-white text-base">
                            TM
                        </div>
                        <span class="text-lg font-black font-display text-slate-900">Talent<span class="text-brand-600">Marketplace</span></span>
                    </div>
                    <p class="text-slate-500 text-xs leading-relaxed max-w-sm">
                        The full-cycle talent marketplace connecting premium brands with verified fashion models, social media influencers, event anchors, and UGC video creators.
                    </p>
                    <div class="flex items-center space-x-3 pt-2 text-xs text-slate-600">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200"><i data-lucide="shield-check" class="w-3.5 h-3.5 text-indigo-600"></i> Escrow Protected</span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200"><i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i> Live API Verified Reach</span>
                    </div>
                </div>

                <!-- Column 1: Discover -->
                <div>
                    <h4 class="text-slate-900 font-bold text-xs uppercase tracking-widest font-display mb-4">Discover</h4>
                    <ul class="space-y-2.5 text-xs text-slate-600 font-medium">
                        <li><a href="{{ route('influencers.public', ['talent_type' => 'influencer']) }}" class="hover:text-slate-900 transition">Social Influencers</a></li>
                        <li><a href="{{ route('influencers.public', ['talent_type' => 'modeling']) }}" class="hover:text-slate-900 transition">Fashion Models</a></li>
                        <li><a href="{{ route('influencers.public', ['talent_type' => 'anchor']) }}" class="hover:text-slate-900 transition">Event Anchors & Emcees</a></li>
                        <li><a href="{{ route('influencers.public', ['talent_type' => 'ugc']) }}" class="hover:text-slate-900 transition">UGC Video Creators</a></li>
                        <li><a href="{{ route('campaigns.public') }}" class="hover:text-slate-900 transition">Open Campaign Briefs</a></li>
                    </ul>
                </div>

                <!-- Column 2: Platform -->
                <div>
                    <h4 class="text-slate-900 font-bold text-xs uppercase tracking-widest font-display mb-4">Platform</h4>
                    <ul class="space-y-2.5 text-xs text-slate-600 font-medium">
                        <li><a href="{{ route('how-it-works') }}" class="hover:text-slate-900 transition">How It Works</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-slate-900 transition">Pricing & Escrow Fees</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-slate-900 transition">About the Platform</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-slate-900 transition">Contact & Help</a></li>
                    </ul>
                </div>

                <!-- Column 3: Portals -->
                <div>
                    <h4 class="text-slate-900 font-bold text-xs uppercase tracking-widest font-display mb-4">Portals</h4>
                    <ul class="space-y-2.5 text-xs text-slate-600 font-medium">
                        <li><a href="{{ route('brand.login') }}" class="hover:text-slate-900 transition">Brand Studio Login</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Creator Studio Login</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-slate-900 transition">Admin Gateway</a></li>
                        <li><a href="{{ route('register') }}" class="text-brand-600 hover:text-brand-700 transition font-bold">+ Create Account</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-200 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Talent Marketplace. Powered by official Meta, Google & X API integrations.</p>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('privacy') }}" class="hover:text-slate-700 transition">Privacy Policy</a>
                    <a href="{{ route('terms') }}" class="hover:text-slate-700 transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

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
