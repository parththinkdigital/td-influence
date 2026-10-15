<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Portal | Talent Marketplace')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
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
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex relative">

    <!-- Global Toast Alert Container -->
    @include('components.toast-container')
    @include('components.command-palette')

    <!-- Sidebar (Light Mode with Admin Moderation Palette) -->
    <aside class="w-64 bg-white text-slate-900 border-r border-slate-200 hidden md:flex flex-col justify-between p-6 flex-shrink-0 sticky top-0 h-screen overflow-y-auto">
        <div>
            <!-- Logo -->
            <div class="flex items-center space-x-3 mb-10">
                <div class="w-9 h-9 rounded-xl bg-red-600 flex items-center justify-center font-bold text-white text-lg tracking-tight shadow-md">
                    TM
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">Admin <span class="text-red-600">Gateway</span></span>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1.5 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-600 font-semibold border border-red-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.brands') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.brands*') ? 'bg-red-50 text-red-600 font-semibold border border-red-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Manage Brands</span>
                </a>
                <a href="{{ route('admin.influencers') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.influencers*') ? 'bg-red-50 text-red-600 font-semibold border border-red-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Manage Talent</span>
                </a>
                <a href="{{ route('admin.verifications') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.verifications*') ? 'bg-red-50 text-red-600 font-semibold border border-red-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Verification Queue</span>
                </a>
                <a href="{{ route('admin.campaigns') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.campaigns*') ? 'bg-red-50 text-red-600 font-semibold border border-red-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Campaign Briefs</span>
                </a>
                <a href="{{ route('admin.categories') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.categories*') ? 'bg-red-50 text-red-600 font-semibold border border-red-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Taxonomies</span>
                </a>
                <a href="{{ route('admin.disputes') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.disputes*') ? 'bg-red-50 text-red-600 font-semibold border border-red-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Dispute Resolution</span>
                </a>
                <a href="{{ route('admin.invoices') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.invoices*') ? 'bg-red-50 text-red-600 font-semibold border border-red-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>Tax Ledger & Invoices</span>
                </a>
            </nav>
        </div>

        <!-- User Profile & Logout -->
        <div class="pt-6 border-t border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="font-bold text-slate-900 text-sm truncate max-w-[140px]">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-red-600 font-semibold uppercase">Super Moderator</div>
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
        <!-- Top Navbar -->
        <header class="sticky top-0 z-30 h-20 bg-white/95 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-8">
            <div>
                <a href="{{ route('home') }}" target="_blank" class="text-xs text-slate-500 hover:text-slate-900 flex items-center space-x-1 font-medium">
                    <span>View Marketplace Website &rarr;</span>
                </a>
            </div>

            <div class="flex items-center space-x-4">
                <button type="button" 
                        @click="window.dispatchEvent(new KeyboardEvent('keydown', {'key':'k', 'ctrlKey':true}))"
                        class="hidden sm:flex items-center space-x-2 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-medium transition border border-slate-200"
                        title="Search anything (Ctrl+K)">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Quick Search...</span>
                    <kbd class="px-1.5 py-0.5 bg-white text-slate-500 rounded text-[10px] font-mono font-bold shadow-2xs">Ctrl+K</kbd>
                </button>

                <span class="px-3.5 py-1.5 bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-bold rounded-full">
                    Platform Moderation Active
                </span>
            </div>
        </header>

        <!-- Main Body -->
        <main class="p-6 md:p-8 lg:p-10 flex-grow max-w-7xl w-full mx-auto">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

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
        setInterval(initFontAwesomeIcons, 600);
    </script>
</body>
</html>
