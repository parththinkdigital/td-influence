<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Governance Gateway | Talent Marketplace')</title>
    @vite(['resources/js/app.js'])

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        admin: {
                            base: '#0B0F17',
                            sidebar: '#0F172A',
                            card: '#1E293B',
                            accent: '#FF3E14',
                            border: '#334155',
                        },
                        studio: {
                            lime: '#E2F163',
                            vermilion: '#FF3E14',
                            emerald: '#10B981',
                            amber: '#F59E0B',
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
<body class="bg-slate-50 text-slate-900 min-h-screen flex relative" x-data="{ mobileSidebar: false }">

    <!-- Global Toast Alert Container & Command Palette -->
    @include('components.toast-container')
    @include('components.command-palette')

    @php
        $pendingVerifCount = \App\Models\Verification::where('status', 'pending')->count();
        $openDisputesCount = \App\Models\Dispute::where('status', 'open')->count();
        $pendingCampCount = \App\Models\Campaign::where('status', 'pending_review')->count();
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
             class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm"></div>

        <div class="fixed inset-0 flex">
            <div x-show="mobileSidebar" 
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative mr-16 flex w-full max-w-xs flex-1 bg-[#0F172A] text-slate-200 flex-col justify-between p-6 shadow-2xl">
                 
                <div>
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-800">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-red-600 to-amber-500 flex items-center justify-center font-black text-white text-base shadow-md">
                                <i class="fa-solid fa-shield-halved text-sm"></i>
                            </div>
                            <div>
                                <span class="font-display font-black text-lg text-white tracking-tight">Admin<span class="text-red-500">Gateway</span></span>
                                <span class="block text-[10px] font-mono text-slate-400 uppercase tracking-widest">Platform Escrow</span>
                            </div>
                        </div>
                        <button type="button" @click="mobileSidebar = false" class="p-2 text-slate-400 hover:text-white rounded-lg">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="space-y-1.5 text-xs font-semibold">
                        <p class="text-[10px] font-mono uppercase text-slate-500 tracking-wider px-3 mb-2 font-bold">Governance</p>
                        <a href="{{ route('admin.dashboard') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-red-500/10 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-gauge-high w-4 text-center"></i>
                                <span>Overview & Escrow</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.brands') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.brands*') ? 'bg-red-500/10 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-building-circle-check w-4 text-center"></i>
                                <span>Brands & Clients</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.influencers') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.influencers*') ? 'bg-red-500/10 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-users-viewfinder w-4 text-center"></i>
                                <span>Talent Directory</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.verifications') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.verifications*') ? 'bg-red-500/10 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-id-card-clip w-4 text-center"></i>
                                <span>Verification Queue</span>
                            </div>
                            @if($pendingVerifCount > 0)
                                <span class="px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-400 text-[10px] font-mono font-bold border border-amber-500/30">{{ $pendingVerifCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.campaigns') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.campaigns*') ? 'bg-red-500/10 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-bullhorn w-4 text-center"></i>
                                <span>Campaign Briefs</span>
                            </div>
                            @if($pendingCampCount > 0)
                                <span class="px-2 py-0.5 rounded-full bg-red-500/20 text-red-400 text-[10px] font-mono font-bold border border-red-500/30">{{ $pendingCampCount }}</span>
                            @endif
                        </a>

                        <p class="text-[10px] font-mono uppercase text-slate-500 tracking-wider px-3 pt-4 mb-2 font-bold">Finance & Safety</p>
                        <a href="{{ route('admin.disputes') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.disputes*') ? 'bg-red-500/10 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-scale-balanced w-4 text-center"></i>
                                <span>Disputes & Escrow</span>
                            </div>
                            @if($openDisputesCount > 0)
                                <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-mono font-bold">{{ $openDisputesCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.invoices') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.invoices*') ? 'bg-red-500/10 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-file-invoice-dollar w-4 text-center"></i>
                                <span>Tax Ledger & GMV</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.categories') }}" @click="mobileSidebar = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.categories*') ? 'bg-red-500/10 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-tags w-4 text-center"></i>
                                <span>Taxonomies & Niches</span>
                            </div>
                        </a>
                    </nav>
                </div>

                <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-white text-xs truncate max-w-[130px]">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-red-400 font-mono">Super Moderator</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-red-600 text-white text-xs font-semibold transition">
                            Exit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Sidebar (Midnight Slate & Red Governance Palette) -->
    <aside class="w-64 bg-[#0F172A] text-slate-200 border-r border-slate-800 hidden md:flex flex-col justify-between p-5 flex-shrink-0 sticky top-0 h-screen overflow-y-auto z-40">
        <div>
            <!-- Brand Logo -->
            <div class="flex items-center space-x-3 mb-8 px-2">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-red-600 to-amber-500 flex items-center justify-center font-black text-white text-base shadow-md">
                    <i class="fa-solid fa-shield-halved text-sm"></i>
                </div>
                <div>
                    <span class="font-display font-black text-lg text-white tracking-tight">Admin<span class="text-red-500">Gateway</span></span>
                    <span class="block text-[9px] font-mono text-slate-400 uppercase tracking-widest">Platform Escrow</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1 text-xs font-semibold">
                <p class="text-[10px] font-mono uppercase text-slate-500 tracking-wider px-3 mb-2 font-bold">Governance</p>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-red-500/15 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-gauge-high w-4 text-center {{ request()->routeIs('admin.dashboard') ? 'text-red-400' : 'text-slate-400' }}"></i>
                        <span>Overview & Escrow</span>
                    </div>
                </a>

                <a href="{{ route('admin.brands') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.brands*') ? 'bg-red-500/15 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-building-circle-check w-4 text-center {{ request()->routeIs('admin.brands*') ? 'text-red-400' : 'text-slate-400' }}"></i>
                        <span>Brands & Clients</span>
                    </div>
                </a>

                <a href="{{ route('admin.influencers') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.influencers*') ? 'bg-red-500/15 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-users-viewfinder w-4 text-center {{ request()->routeIs('admin.influencers*') ? 'text-red-400' : 'text-slate-400' }}"></i>
                        <span>Talent Directory</span>
                    </div>
                </a>

                <a href="{{ route('admin.verifications') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.verifications*') ? 'bg-red-500/15 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-id-card-clip w-4 text-center {{ request()->routeIs('admin.verifications*') ? 'text-red-400' : 'text-slate-400' }}"></i>
                        <span>Verification Queue</span>
                    </div>
                    @if($pendingVerifCount > 0)
                        <span class="px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-400 text-[10px] font-mono font-bold border border-amber-500/30">{{ $pendingVerifCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.campaigns') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.campaigns*') ? 'bg-red-500/15 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-bullhorn w-4 text-center {{ request()->routeIs('admin.campaigns*') ? 'text-red-400' : 'text-slate-400' }}"></i>
                        <span>Campaign Briefs</span>
                    </div>
                    @if($pendingCampCount > 0)
                        <span class="px-2 py-0.5 rounded-full bg-red-500/20 text-red-400 text-[10px] font-mono font-bold border border-red-500/30">{{ $pendingCampCount }}</span>
                    @endif
                </a>

                <p class="text-[10px] font-mono uppercase text-slate-500 tracking-wider px-3 pt-5 mb-2 font-bold">Finance & Safety</p>

                <a href="{{ route('admin.disputes') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.disputes*') ? 'bg-red-500/15 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-scale-balanced w-4 text-center {{ request()->routeIs('admin.disputes*') ? 'text-red-400' : 'text-slate-400' }}"></i>
                        <span>Disputes & Escrow</span>
                    </div>
                    @if($openDisputesCount > 0)
                        <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-mono font-bold">{{ $openDisputesCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.invoices') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.invoices*') ? 'bg-red-500/15 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-file-invoice-dollar w-4 text-center {{ request()->routeIs('admin.invoices*') ? 'text-red-400' : 'text-slate-400' }}"></i>
                        <span>Tax Ledger & GMV</span>
                    </div>
                </a>

                <a href="{{ route('admin.categories') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.categories*') ? 'bg-red-500/15 text-red-400 font-bold border border-red-500/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-tags w-4 text-center {{ request()->routeIs('admin.categories*') ? 'text-red-400' : 'text-slate-400' }}"></i>
                        <span>Taxonomies & Niches</span>
                    </div>
                </a>
            </nav>
        </div>

        <!-- Footer Profile -->
        <div class="pt-4 border-t border-slate-800">
            <div class="flex items-center justify-between bg-slate-800/40 p-2.5 rounded-xl border border-slate-800">
                <div class="flex items-center space-x-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-red-600/20 text-red-400 border border-red-500/30 flex items-center justify-center font-bold text-xs flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="font-bold text-white text-xs truncate max-w-[100px]">{{ auth()->user()->name }}</div>
                        <div class="text-[9px] text-red-400 font-mono font-semibold uppercase">Super Moderator</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-rose-400 p-1.5 transition text-xs" title="Logout">
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

                <div class="flex items-center space-x-2 text-xs text-slate-500 font-medium">
                    <a href="{{ route('home') }}" target="_blank" class="hover:text-red-600 flex items-center space-x-1.5 transition">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
                        <span class="hidden sm:inline">Public Marketplace</span>
                    </a>
                    <span class="text-slate-300">/</span>
                    <span class="text-slate-800 font-semibold font-mono">Platform Governance</span>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <!-- Command Palette Trigger -->
                <button type="button" 
                        @click="window.dispatchEvent(new KeyboardEvent('keydown', {'key':'k', 'ctrlKey':true}))"
                        class="hidden sm:flex items-center space-x-2 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-medium transition border border-slate-200/60"
                        title="Search anything (Ctrl+K)">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
                    <span>Quick Search...</span>
                    <kbd class="px-1.5 py-0.5 bg-white text-slate-500 rounded text-[10px] font-mono font-bold shadow-2xs border border-slate-200">Ctrl+K</kbd>
                </button>

                <div class="flex items-center space-x-2 px-3 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold rounded-full font-mono">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="hidden sm:inline">Escrow Protocol Active</span>
                    <span class="sm:hidden">Active</span>
                </div>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="p-4 sm:p-6 lg:p-8 flex-grow max-w-7xl w-full mx-auto">
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
