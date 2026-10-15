<!DOCTYPE html>
<html lang="en" class="scroll-smooth antialiased selection:bg-[#E2F163] selection:text-[#181528]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HypeMarket &mdash; Curated Instagram Talent for Models, Influencers &amp; Anchors</title>
    <meta name="description" content="Curated Instagram talent network. Connect with verified fashion models, Instagram reel creators, event anchors, and emcees with real-time Meta Graph API analytics and milestone escrow security.">

    <!-- Google Fonts: Bricolage Grotesque, Plus Jakarta Sans, Space Grotesk, Caveat, Reenie Beanie -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800;12..96,900&family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Reenie+Beanie&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN with custom config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Bricolage Grotesque"', 'sans-serif'],
                        mono: ['"Space Grotesk"', 'monospace'],
                        script: ['Caveat', 'cursive'],
                        reenie: ['"Reenie Beanie"', 'cursive'],
                    },
                    colors: {
                        canvas: {
                            DEFAULT: '#FAF5EC',
                            soft: '#F4ECE0',
                            card: '#FFFFFF',
                            subtle: '#F6EFE3',
                        },
                        ink: {
                            DEFAULT: '#181528',
                            muted: '#524B66',
                            subtle: '#827B96',
                        },
                        solar: {
                            DEFAULT: '#E2F163',
                            hover: '#D4E64A',
                            soft: '#FFF9AA',
                            pale: '#FFFDE0'
                        },
                        vermilion: {
                            DEFAULT: '#FF3E14',
                            hover: '#E5320A',
                            soft: '#FFEBE6',
                            light: '#FFF0EC'
                        },
                        pinkpop: {
                            DEFAULT: '#F47FA2',
                            hover: '#E8668E',
                            deep: '#8F1449',
                            soft: '#FCE7EE',
                            pale: '#FFF2F6'
                        },
                        lilac: {
                            DEFAULT: '#BDB0FC',
                            hover: '#A998FA',
                            deep: '#3B2485',
                            soft: '#F1EEFD'
                        },
                        skyblue: {
                            DEFAULT: '#7EC4FB',
                            hover: '#61B4F7',
                            deep: '#0E4875',
                            soft: '#EAF5FE'
                        },
                        emeraldpop: {
                            DEFAULT: '#10B981',
                            soft: '#E6F9F2',
                            deep: '#064E3B'
                        }
                    },
                    animation: {
                        'marquee': 'marquee 30s linear infinite',
                        'marquee-reverse': 'marquee-reverse 30s linear infinite',
                        'pulse-glow': 'pulseGlow 5s ease-in-out infinite',
                        'float-gentle': 'floatGentle 4s ease-in-out infinite',
                    },
                    keyframes: {
                        marquee: {
                            '0%': { transform: 'translateX(0%)' },
                            '100%': { transform: 'translateX(-50%)' },
                        },
                        'marquee-reverse': {
                            '0%': { transform: 'translateX(-50%)' },
                            '100%': { transform: 'translateX(0%)' },
                        },
                        pulseGlow: {
                            '0%, 100%': { opacity: '0.6', transform: 'scale(1)' },
                            '50%': { opacity: '0.9', transform: 'scale(1.08)' },
                        },
                        floatGentle: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-8px)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome 6 Icons & Alpine.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Lenis Smooth Scroll -->
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>

    <style>
        .noise-bg {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.035'/%3E%3C/svg%3E");
        }

        .font-caveat { font-family: 'Caveat', cursive; }
        .font-reenie { font-family: 'Reenie Beanie', cursive; }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="bg-[#FAF5EC] text-[#181528] min-h-screen relative font-sans overflow-x-hidden" x-data="{ mobileMenuOpen: false }">

    <!-- Fixed Ambient Noise Texture -->
    <div class="fixed inset-0 pointer-events-none z-50 noise-bg"></div>

    <!-- Ambient Glow Orbs -->
    <div class="fixed top-[-5%] left-[-5%] w-[48vw] h-[48vw] rounded-full bg-[#E2F163]/30 blur-[130px] pointer-events-none -z-10 animate-pulse-glow"></div>
    <div class="fixed top-[25%] right-[-10%] w-[45vw] h-[45vw] rounded-full bg-[#F47FA2]/25 blur-[150px] pointer-events-none -z-10 animate-pulse-glow" style="animation-delay: 2s;"></div>
    <div class="fixed top-[60%] left-[-5%] w-[40vw] h-[40vw] rounded-full bg-[#7EC4FB]/30 blur-[140px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-[-5%] right-[15%] w-[50vw] h-[50vw] rounded-full bg-[#BDB0FC]/30 blur-[140px] pointer-events-none -z-10"></div>

    <!-- FLOATING GLASS PILL NAVBAR -->
    <header class="fixed top-5 left-0 right-0 z-40 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto">
            <nav class="bg-white/80 backdrop-blur-2xl border border-[#181528]/10 rounded-full px-4 sm:px-6 py-3 flex items-center justify-between shadow-[0_12px_36px_rgba(24,21,40,0.07)] transition-all duration-300">
                
                <!-- Brand Signature -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-9 h-9 rounded-full bg-[#E2F163] border border-[#181528]/15 flex items-center justify-center font-display font-black text-[#181528] text-base group-hover:scale-105 transition-transform duration-300 shadow-sm">
                        <span class="tracking-tighter text-sm font-extrabold">H<span class="text-[#FF3E14] text-xs">&lowast;</span></span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-display font-black text-sm sm:text-base tracking-tight text-[#181528] flex items-center gap-1.5">
                            Hype<span class="text-[#FF3E14]">Market</span>
                            <span class="text-[9px] font-mono uppercase bg-[#E2F163] text-[#181528] px-2 py-0.5 rounded-full border border-[#181528]/10 font-bold hidden sm:inline-block">TALENT HUB</span>
                        </span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center space-x-1 text-xs font-bold text-[#524B66]">
                    <a href="{{ route('influencers.public') }}" class="px-4 py-2 rounded-full hover:text-[#181528] hover:bg-black/5 transition-all duration-200">
                        Explore Talent
                    </a>
                    <a href="{{ route('influencers.public', ['talent_type' => 'influencer']) }}" class="px-3.5 py-2 rounded-full hover:text-[#181528] hover:bg-[#FCE7EE] transition-all duration-200 flex items-center gap-1.5">
                        <i class="fa-brands fa-instagram text-xs text-[#E1306C]"></i>
                        <span>Instagram Influencers</span>
                    </a>
                    <a href="{{ route('influencers.public', ['talent_type' => 'modeling']) }}" class="px-3.5 py-2 rounded-full hover:text-[#181528] hover:bg-[#FFF9AA] transition-all duration-200 flex items-center gap-1.5">
                        <i class="fa-solid fa-camera text-xs text-[#FF3E14]"></i>
                        <span>Fashion Models</span>
                    </a>
                    <a href="{{ route('influencers.public', ['talent_type' => 'anchor']) }}" class="px-3.5 py-2 rounded-full hover:text-[#181528] hover:bg-[#F1EEFD] transition-all duration-200 flex items-center gap-1.5">
                        <i class="fa-solid fa-microphone-lines text-xs text-[#3B2485]"></i>
                        <span>Event Anchors</span>
                    </a>
                    <a href="{{ route('campaigns.public') }}" class="px-4 py-2 rounded-full hover:text-[#181528] hover:bg-black/5 transition-all duration-200">
                        Campaign Briefs
                    </a>
                    <a href="{{ route('font.pairs') }}" class="px-3.5 py-2 rounded-full bg-[#E2F163]/40 text-[#181528] hover:bg-[#E2F163] transition-all duration-200 flex items-center gap-1">
                        <i class="fa-solid fa-font text-[10px]"></i>
                        <span>Font Lab</span>
                    </a>
                </div>

                <!-- Right Action Island -->
                <div class="hidden sm:flex items-center space-x-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-[#181528] text-white text-xs font-bold transition shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-[#E2F163] animate-ping"></span>
                                <span>Admin Gateway</span>
                            </a>
                        @elseif(auth()->user()->isBrand())
                            <a href="{{ route('brand.dashboard') }}" class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-[#E2F163] text-[#181528] text-xs font-black hover:bg-[#D4E64A] transition shadow-sm border border-[#181528]/10">
                                <span>Brand Studio</span>
                            </a>
                        @else
                            <a href="{{ route('influencer.dashboard') }}" class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-[#F47FA2] text-[#181528] text-xs font-black hover:bg-pink-300 transition shadow-sm border border-[#181528]/10">
                                <span>Creator Studio</span>
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-[#827B96] hover:text-[#181528] text-xs transition" title="Log out">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-extrabold text-[#524B66] hover:text-[#181528] px-3 py-2 transition">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center rounded-full bg-[#181528] text-white px-5 py-2 text-xs font-black hover:bg-[#FF3E14] transition-all duration-300 shadow-sm active:scale-95 flex items-center space-x-1.5">
                            <span>Join The Hype</span>
                            <div class="w-4 h-4 rounded-full bg-[#E2F163] text-[#181528] flex items-center justify-center text-[9px] group-hover:bg-white transition">
                                <i class="fa-solid fa-arrow-right"></i>
                            </div>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden w-9 h-9 rounded-full bg-black/5 flex items-center justify-center text-[#181528] hover:bg-black/10 transition">
                    <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </nav>
        </div>

        <!-- Mobile Drawer -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden max-w-7xl mx-auto mt-3 bg-white/95 backdrop-blur-3xl border border-[#181528]/10 rounded-3xl p-6 space-y-4 shadow-2xl" 
             x-cloak>
            <div class="grid grid-cols-2 gap-2 text-xs font-bold text-[#181528]">
                <a href="{{ route('influencers.public') }}" class="p-3 rounded-2xl bg-[#FAF5EC] hover:bg-[#E2F163] flex items-center gap-2">
                    <i class="fa-solid fa-compass text-[#FF3E14]"></i> Discover All
                </a>
                <a href="{{ route('influencers.public', ['talent_type' => 'influencer']) }}" class="p-3 rounded-2xl bg-[#FCE7EE] hover:bg-[#F47FA2] flex items-center gap-2">
                    <i class="fa-brands fa-instagram text-[#E1306C]"></i> IG Influencers
                </a>
                <a href="{{ route('influencers.public', ['talent_type' => 'modeling']) }}" class="p-3 rounded-2xl bg-[#FFF9AA] hover:bg-[#E2F163] flex items-center gap-2">
                    <i class="fa-solid fa-camera text-[#FF3E14]"></i> Fashion Models
                </a>
                <a href="{{ route('influencers.public', ['talent_type' => 'anchor']) }}" class="p-3 rounded-2xl bg-[#F1EEFD] hover:bg-[#BDB0FC] flex items-center gap-2">
                    <i class="fa-solid fa-microphone-lines text-[#3B2485]"></i> Stage Anchors
                </a>
                <a href="{{ route('campaigns.public') }}" class="p-3 rounded-2xl bg-[#EAF5FE] hover:bg-[#7EC4FB] flex items-center gap-2">
                    <i class="fa-solid fa-briefcase text-[#0E4875]"></i> Brand Briefs
                </a>
                <a href="{{ route('font.pairs') }}" class="p-3 rounded-2xl bg-[#FFF385] hover:bg-[#E2F163] flex items-center gap-2">
                    <i class="fa-solid fa-font text-[#181528]"></i> Font Lab
                </a>
            </div>
            
            <div class="pt-2 border-t border-[#181528]/10 flex flex-col gap-2">
                @auth
                    @if(auth()->user()->isBrand())
                        <a href="{{ route('brand.dashboard') }}" class="w-full text-center py-3 rounded-2xl font-bold bg-[#E2F163] text-[#181528]">Enter Brand Studio</a>
                    @elseif(auth()->user()->isTalent())
                        <a href="{{ route('influencer.dashboard') }}" class="w-full text-center py-3 rounded-2xl font-bold bg-[#F47FA2] text-[#181528]">Enter Creator Studio</a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="w-full text-center py-3 rounded-2xl font-bold bg-[#181528] text-white">Admin Gateway</a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="w-full text-center py-3 rounded-2xl font-black bg-[#FF3E14] text-white shadow-md">Join as Creator / Brand &rarr;</a>
                    <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-2xl font-bold bg-black/5 text-[#181528]">Sign In to Account</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="w-full max-w-full overflow-x-hidden">
        
        <!-- HERO SECTION (BRICOLAGE GROTESQUE HEADLINE) -->
        <section class="relative pt-36 pb-20 md:pt-48 md:pb-32 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                
                <!-- Tagline Badge Pill -->
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2.5 mb-6">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-[#FFF385] text-[#181528] border border-[#181528]/15 text-xs font-mono font-bold uppercase tracking-wide shadow-xs">
                        <i class="fa-brands fa-instagram text-[#E1306C] text-sm"></i>
                        <span>CURATED INSTAGRAM TALENT NETWORK</span>
                        <span class="text-[#FF3E14]">&bull;</span>
                        <span>VERIFIED CASTING</span>
                    </div>
                    <div class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-full bg-white border border-[#181528]/15 text-xs font-mono font-bold text-[#FF3E14] shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-[#10B981] animate-pulse"></span>
                        <span>REELS &bull; RUNWAY &bull; LIVE STAGE</span>
                    </div>
                    <!-- Handwritten Callout Sticker -->
                    <div class="hidden lg:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FAF5EC] border border-[#181528]/20 -rotate-2 shadow-2xs">
                        <i class="fa-solid fa-sparkles text-[#FF3E14] text-xs"></i>
                        <span class="font-caveat text-base font-bold text-[#FF3E14]">~ authentic Meta Graph sync ~</span>
                    </div>
                </div>

                <!-- 2-Line Editorial Headline -->
                <div class="space-y-4 text-center md:text-left">
                    <h1 class="font-display font-black text-4xl sm:text-6xl lg:text-7xl xl:text-8xl tracking-tight text-[#181528] leading-[1.04] max-w-6xl">
                        Cast verified <span class="text-[#FF3E14]">Instagram models,</span> 
                        <span class="inline-flex items-center align-middle mx-1 sm:mx-2 px-3.5 py-1 rounded-full bg-[#E2F163] text-[#181528] border border-[#181528]/20 -translate-y-1 sm:-translate-y-2 shadow-xs">
                            <span class="text-xs sm:text-sm font-mono font-black tracking-widest uppercase">REELS &bull; HOSTS</span>
                        </span>
                        influencers &amp; anchors.
                    </h1>

                    <p class="text-[#524B66] text-base sm:text-xl font-medium max-w-2xl leading-relaxed pt-2">
                        Direct access to authenticated Instagram creators, runway models, and live event anchors with real-time Meta Graph API analytics, comp cards, and milestone escrow security.
                    </p>
                </div>

                <!-- Hardware Search Console Bar -->
                <div class="mt-10 max-w-5xl">
                    <div class="p-1.5 rounded-[2rem] bg-white border border-[#181528]/15 shadow-xl shadow-amber-950/5">
                        <form action="{{ route('influencers.public') }}" method="GET" class="bg-[#FAF5EC] rounded-[calc(2rem-0.375rem)] p-2 sm:p-2.5 flex flex-col sm:flex-row items-center gap-2">
                            
                            <!-- Search Input -->
                            <div class="flex-grow flex items-center px-4 w-full text-[#181528]">
                                <i class="fa-solid fa-magnifying-glass text-[#FF3E14] mr-3 text-sm"></i>
                                <input type="text" name="search" placeholder="Search by creator name, niche, 'Runway Model', 'Event Emcee', 'Reels Creator'..." class="w-full bg-transparent text-sm sm:text-base font-semibold text-[#181528] placeholder-[#827B96] outline-none">
                            </div>

                            <!-- Colorful Filter Pills -->
                            <div class="hidden lg:flex items-center space-x-1.5 px-2 text-xs font-mono font-bold">
                                <a href="{{ route('influencers.public', ['talent_type' => 'influencer']) }}" class="px-2.5 py-1 rounded-full bg-[#FCE7EE] text-[#8F1449] hover:bg-[#F47FA2] hover:text-[#181528] transition flex items-center gap-1">
                                    <i class="fa-brands fa-instagram text-[11px]"></i>
                                    <span>#Influencers</span>
                                </a>
                                <a href="{{ route('influencers.public', ['talent_type' => 'modeling']) }}" class="px-2.5 py-1 rounded-full bg-[#FFF385] text-[#181528] hover:bg-[#E2F163] transition flex items-center gap-1">
                                    <i class="fa-solid fa-camera text-[10px]"></i>
                                    <span>#Models</span>
                                </a>
                                <a href="{{ route('influencers.public', ['talent_type' => 'anchor']) }}" class="px-2.5 py-1 rounded-full bg-[#F1EEFD] text-[#3B2485] hover:bg-[#BDB0FC] hover:text-[#181528] transition flex items-center gap-1">
                                    <i class="fa-solid fa-microphone-lines text-[10px]"></i>
                                    <span>#Anchors</span>
                                </a>
                            </div>

                            <!-- CTA Button with Nested Arrow -->
                            <button type="submit" class="w-full sm:w-auto px-7 py-3.5 rounded-full bg-[#181528] hover:bg-[#FF3E14] text-white font-display font-extrabold text-sm tracking-wide transition-all duration-300 flex items-center justify-center space-x-2 shadow-md active:scale-95 flex-shrink-0">
                                <span>Cast Talent Now</span>
                                <div class="w-6 h-6 rounded-full bg-[#E2F163] text-[#181528] flex items-center justify-center text-xs ml-1">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Hero Micro Stat Chips -->
                <div class="mt-8 flex flex-wrap items-center justify-center md:justify-start gap-4 sm:gap-8 text-xs font-mono text-[#524B66]">
                    <div class="flex items-center space-x-2">
                        <i class="fa-brands fa-instagram text-[#E1306C] text-sm"></i>
                        <span><strong class="text-[#181528]">{{ $stats['talents'] ?? '4,800+' }}</strong> Verified Creators</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-bolt text-[#FF3E14]"></i>
                        <span><strong class="text-[#181528]">12.5M+</strong> Monthly Reach</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-shield-halved text-[#10B981]"></i>
                        <span><strong class="text-[#181528]">100%</strong> Escrow Protected</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- INSTAGRAM REELS & RUNWAY TICKER -->
        <section class="py-6 bg-[#FF3E14] text-white overflow-hidden rotate-[-1deg] scale-105 my-6 border-y-2 border-[#181528] shadow-md">
            <div class="flex whitespace-nowrap animate-marquee">
                @for ($i = 0; $i < 2; $i++)
                    <div class="flex items-center space-x-12 sm:space-x-16 mx-6 sm:mx-8 font-display font-black text-xl sm:text-2xl uppercase tracking-wider text-white">
                        <span class="flex items-center gap-2 text-[#FFF385]"><i class="fa-brands fa-instagram text-white"></i> INSTAGRAM REEL CREATORS</span>
                        <span class="text-[#FFF385]">&bull;</span>
                        <span class="flex items-center gap-2"><i class="fa-solid fa-camera text-[#FFF385]"></i> FASHION &amp; RUNWAY MODELS</span>
                        <span class="text-[#FFF385]">&bull;</span>
                        <span class="flex items-center gap-2 text-[#FFF385]"><i class="fa-solid fa-microphone-lines text-white"></i> STAGE &amp; EVENT ANCHORS</span>
                        <span class="text-[#FFF385]">&bull;</span>
                        <span class="flex items-center gap-2"><i class="fa-solid fa-bolt text-[#FFF385]"></i> INSTAGRAM COLLAB POSTS</span>
                        <span class="text-[#FFF385]">&bull;</span>
                        <span class="flex items-center gap-2 text-[#FFF385]"><i class="fa-solid fa-shield-halved text-white"></i> 100% ESCROW PROTECTED</span>
                        <span class="text-[#FFF385]">&bull;</span>
                    </div>
                @endfor
            </div>
        </section>

        <!-- INTEREST: 3 CORE TALENT PILLARS BENTO GRID -->
        <section class="py-24 sm:py-36 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            
            <!-- Section Header -->
            <div class="mb-14 text-center md:text-left flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-[#E2F163] text-[#181528] border border-[#181528]/15 text-[11px] font-mono font-bold uppercase mb-3 shadow-xs">
                        <i class="fa-brands fa-instagram text-[#E1306C]"></i>
                        <span>3 Core Talent Categories</span>
                    </div>
                    <h2 class="font-display font-black text-3xl sm:text-5xl text-[#181528] tracking-tight leading-tight">
                        Cast Across <span class="text-[#FF3E14]">Models, Influencers &amp; Anchors.</span>
                    </h2>
                </div>
                <p class="text-[#524B66] text-sm font-medium max-w-md">
                    Targeted casting for brand campaigns. Verified Instagram Graph API metrics, comp cards, and video showreels.
                </p>
            </div>

            <!-- Interlocking 12-Column Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 grid-flow-dense">
                
                <!-- Pillar 1: Instagram Influencers & Reel Makers (Col-span 7 - Pop Pink) -->
                <div class="md:col-span-7 group relative p-2 rounded-[2.5rem] bg-[#F47FA2] border-2 border-[#181528] shadow-[6px_6px_0px_#181528] transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-white rounded-[calc(2.5rem-0.5rem)] p-7 sm:p-9 h-full flex flex-col justify-between">
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="w-12 h-12 rounded-2xl bg-[#FCE7EE] border border-[#F47FA2] flex items-center justify-center text-[#E1306C] text-2xl font-bold shadow-xs">
                                    <i class="fa-brands fa-instagram"></i>
                                </div>
                                <span class="text-xs font-mono font-bold text-[#8F1449] bg-[#FCE7EE] border border-[#F47FA2] px-3 py-1 rounded-full">
                                    Reels &bull; Stories &bull; Collabs
                                </span>
                            </div>
                            <h3 class="font-display font-black text-2xl sm:text-3xl text-[#181528]">Instagram Influencers &amp; Reel Creators</h3>
                            <p class="text-[#524B66] text-sm leading-relaxed max-w-md font-sans">
                                Authentic fashion, beauty, food, tech, and lifestyle creators with real-time Instagram Graph API sync. Live audience retention, genuine engagement rates, and demographic data.
                            </p>
                        </div>

                        <!-- Mini stack -->
                        <div class="pt-8 flex flex-wrap items-center justify-between gap-4 border-t border-[#181528]/10 mt-6">
                            <div class="flex -space-x-3 overflow-hidden">
                                <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop" alt="Talent 1">
                                <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" alt="Talent 2">
                                <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop" alt="Talent 3">
                                <div class="w-10 h-10 rounded-full bg-[#E2F163] border border-[#181528] text-[#181528] flex items-center justify-center text-xs font-mono font-black">
                                    +3.5K
                                </div>
                            </div>
                            <a href="{{ route('influencers.public', ['talent_type' => 'influencer']) }}" class="text-xs font-black text-[#181528] hover:text-[#FF3E14] flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                                <span>Browse Instagram Influencers</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pillar 2: Fashion & Commercial Models (Col-span 5 - Solar Acid Yellow & Vermilion) -->
                <div class="md:col-span-5 group relative p-2 rounded-[2.5rem] bg-[#E2F163] border-2 border-[#181528] shadow-[6px_6px_0px_#181528] transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-[#FFFDE0] rounded-[calc(2.5rem-0.5rem)] p-7 sm:p-9 h-full flex flex-col justify-between">
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="w-12 h-12 rounded-2xl bg-[#FF3E14] text-white flex items-center justify-center text-xl shadow-xs">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                                <span class="text-xs font-mono font-black text-[#181528] bg-[#E2F163] border border-[#181528]/20 px-3 py-1 rounded-full">
                                    Runway &bull; Comp Cards
                                </span>
                            </div>
                            <h3 class="font-display font-black text-2xl sm:text-3xl text-[#181528]">Fashion &amp; Editorial Models</h3>
                            <p class="text-[#524B66] text-sm leading-relaxed font-sans">
                                Professional apparel catalogue, bridal, ecommerce, and high-fashion runway models with verified measurements, Polaroids, and physical comp cards.
                            </p>
                        </div>

                        <div class="pt-8 border-t border-[#181528]/10 mt-6 flex items-center justify-between">
                            <span class="text-xs font-mono font-bold text-[#181528]">Verified Heights &amp; Stats</span>
                            <a href="{{ route('influencers.public', ['talent_type' => 'modeling']) }}" class="text-xs font-black text-[#181528] hover:text-[#FF3E14] flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                                <span>Cast Models</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pillar 3: Event Anchors, Emcees & Voice Talent (Col-span 7 - Lavender Lilac) -->
                <div class="md:col-span-7 group relative p-2 rounded-[2.5rem] bg-[#BDB0FC] border-2 border-[#181528] shadow-[6px_6px_0px_#181528] transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-[#F1EEFD] rounded-[calc(2.5rem-0.5rem)] p-7 sm:p-9 h-full flex flex-col justify-between">
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="w-12 h-12 rounded-2xl bg-[#BDB0FC] border border-[#181528] text-[#181528] flex items-center justify-center text-xl shadow-xs">
                                    <i class="fa-solid fa-microphone-lines"></i>
                                </div>
                                <span class="text-xs font-mono font-black text-[#3B2485] bg-white px-3 py-1 rounded-full border border-[#BDB0FC]">
                                    Live Stage &bull; Corporate
                                </span>
                            </div>
                            <h3 class="font-display font-black text-2xl sm:text-3xl text-[#181528]">Event Anchors &amp; Stage Emcees</h3>
                            <p class="text-[#524B66] text-sm leading-relaxed max-w-md font-sans">
                                High-energy corporate event hosts, destination wedding anchors, campus fests, and bilingual presenters with verified video showreels.
                            </p>
                        </div>

                        <div class="pt-8 border-t border-[#181528]/10 mt-6 flex items-center justify-between">
                            <span class="text-xs font-mono font-bold text-[#3B2485]">Video Showreels Attached</span>
                            <a href="{{ route('influencers.public', ['talent_type' => 'anchor']) }}" class="text-xs font-black text-[#181528] hover:text-[#3B2485] flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                                <span>Book Event Anchors</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Instant Gig Booking & Escrow Card (Col-span 5 - Sky Blue) -->
                <div class="md:col-span-5 group relative p-2 rounded-[2.5rem] bg-[#7EC4FB] border-2 border-[#181528] shadow-[6px_6px_0px_#181528] transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-white rounded-[calc(2.5rem-0.5rem)] p-7 sm:p-9 h-full flex flex-col justify-between">
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="w-12 h-12 rounded-2xl bg-[#7EC4FB] border border-[#181528] text-[#181528] flex items-center justify-center text-xl shadow-xs">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <span class="text-xs font-mono font-bold text-[#0E4875] bg-[#EAF5FE] border border-[#7EC4FB] px-3 py-1 rounded-full">
                                    Milestone Escrow
                                </span>
                            </div>
                            <h3 class="font-display font-black text-2xl sm:text-3xl text-[#181528]">Instant Booking &amp; Escrow</h3>
                            <p class="text-[#524B66] text-sm leading-relaxed font-sans">
                                Direct offer dispatch, usage rights licensing agreements, and guaranteed payout release once deliverables pass brand review.
                            </p>
                        </div>

                        <div class="pt-8 border-t border-[#181528]/10 mt-6 flex items-center justify-between">
                            <span class="text-xs font-mono font-bold text-[#0E4875]">100% Payout Security</span>
                            <a href="{{ route('campaigns.public') }}" class="text-xs font-black text-[#181528] hover:text-[#0E4875] flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                                <span>Post Campaign</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- DESIRE: SPOTLIGHT TALENT ROSTER (CLEAN COMP CARDS WITHOUT LOCATION LABELS) -->
        <section class="py-24 sm:py-36 px-4 sm:px-6 lg:px-8 bg-white/60 border-y border-[#181528]/10">
            <div class="max-w-7xl mx-auto">
                
                <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-12">
                    <div>
                        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-[#FFF385] text-[#181528] border border-[#181528]/15 text-[11px] font-mono font-bold uppercase mb-3 shadow-xs">
                            <i class="fa-brands fa-instagram text-[#E1306C]"></i>
                            <span>Trending Creators</span>
                        </div>
                        <h2 class="font-display font-black text-3xl sm:text-5xl text-[#181528] tracking-tight">
                            Meet Verified <span class="text-[#FF3E14]">Models, Creators &amp; Anchors.</span>
                        </h2>
                    </div>
                    <a href="{{ route('influencers.public') }}" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-full bg-white hover:bg-[#E2F163] border border-[#181528]/20 text-xs font-mono font-bold text-[#181528] transition shadow-xs">
                        <span>View All Talent</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>

                <!-- Talent Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($topTalents ?? [] as $talent)
                        @php
                            $topSocial = $talent->socialAccounts->sortByDesc('followers')->first();
                            $totFollowers = $talent->socialAccounts->sum('followers');
                            $startingRate = $talent->rates->min('rate_amount');
                            $avatar = $talent->profile_image ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=400&fit=crop';
                        @endphp
                        
                        <div class="group relative p-2 rounded-[2rem] bg-white border-2 border-[#181528] shadow-[5px_5px_0px_#181528] hover:shadow-[7px_7px_0px_#FF3E14] transition-all duration-300 hover:-translate-y-1">
                            <div class="bg-[#FAF5EC] rounded-[calc(2rem-0.5rem)] p-5 flex flex-col justify-between h-full">
                                
                                <div>
                                    <div class="relative h-56 w-full rounded-2xl overflow-hidden mb-4 bg-slate-200 border border-[#181528]/15">
                                        <img src="{{ $avatar }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $talent->display_name ?: $talent->user->name }}">
                                        
                                        <!-- Rising Star Sticker Badge -->
                                        <div class="absolute top-3 left-3 bg-[#E2F163] border border-[#181528] px-2.5 py-1 rounded-full text-[10px] font-mono font-black text-[#181528] flex items-center gap-1 shadow-xs">
                                            <i class="fa-brands fa-instagram text-[10px] text-[#E1306C]"></i>
                                            <span>L{{ $talent->verification_level ?? 5 }} Verified</span>
                                        </div>

                                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-full border border-[#181528]/20 text-[10px] font-mono font-black text-[#181528] flex items-center gap-1 shadow-xs">
                                            <i class="fa-solid fa-star text-[#FF3E14] text-[9px]"></i>
                                            <span>{{ number_format((float)($talent->rating_avg ?: 5.0), 1) }}</span>
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        <h3 class="font-display font-black text-lg text-[#181528] flex items-center justify-between">
                                            <span>{{ $talent->display_name ?: $talent->user->name }}</span>
                                            @if($talent->price_negotiable)
                                                <span class="text-[10px] font-mono text-[#064E3B] bg-[#E6F9F2] px-2 py-0.5 rounded border border-[#10B981]/30 font-bold">Open to Offers</span>
                                            @endif
                                        </h3>
                                        <p class="text-xs font-medium text-[#524B66] line-clamp-1 font-sans">
                                            {{ is_array($talent->primary_categories) ? implode(' • ', $talent->primary_categories) : ($talent->primary_categories ?: 'Instagram Fashion & Lifestyle Creator') }}
                                        </p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 mt-4 p-2.5 rounded-xl bg-white border border-[#181528]/10 text-xs font-mono">
                                        <div>
                                            <span class="text-[10px] text-[#827B96] uppercase font-bold block">IG Followers</span>
                                            <span class="font-extrabold text-[#181528]">{{ $totFollowers ? number_format($totFollowers) : '185K+' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-[#827B96] uppercase font-bold block">Starting At</span>
                                            <span class="font-extrabold text-[#FF3E14]">{{ $startingRate ? '₹'.number_format($startingRate) : '₹15,000' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 pt-4 border-t border-[#181528]/10">
                                    <a href="{{ route('influencers.public.show', $talent->username ?: $talent->id) }}" class="w-full py-2.5 rounded-xl bg-[#181528] hover:bg-[#FF3E14] text-white text-xs font-black font-display text-center transition-all duration-200 flex items-center justify-center gap-1.5 shadow-xs">
                                        <span>View Comp Card &amp; Rates</span>
                                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Mock Fallback Indian Creators -->
                        @php
                            $mockCreators = [
                                [
                                    'name' => 'Arya Varma',
                                    'role' => 'Fashion Runway Model & IG Reels',
                                    'reach' => '185K',
                                    'rate' => '₹15,000',
                                    'accent' => '#FF3E14',
                                    'img' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=500&h=500&fit=crop'
                                ],
                                [
                                    'name' => 'Rohan Sen',
                                    'role' => 'Tech Reviewer & Event Host',
                                    'reach' => '320K',
                                    'rate' => '₹22,000',
                                    'accent' => '#7EC4FB',
                                    'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500&h=500&fit=crop'
                                ],
                                [
                                    'name' => 'Zara Merchant',
                                    'role' => 'Streetwear & Lifestyle Anchor',
                                    'reach' => '490K',
                                    'rate' => '₹35,000',
                                    'accent' => '#F47FA2',
                                    'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=500&h=500&fit=crop'
                                ],
                            ];
                        @endphp
                        @foreach($mockCreators as $creator)
                            <div class="group relative p-2 rounded-[2rem] bg-white border-2 border-[#181528] shadow-[5px_5px_0px_#181528] hover:shadow-[7px_7px_0px_{{ $creator['accent'] }}] transition-all duration-300 hover:-translate-y-1">
                                <div class="bg-[#FAF5EC] rounded-[calc(2rem-0.5rem)] p-5 flex flex-col justify-between h-full">
                                    <div>
                                        <div class="relative h-56 w-full rounded-2xl overflow-hidden mb-4 bg-slate-200 border border-[#181528]/15">
                                            <img src="{{ $creator['img'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $creator['name'] }}">
                                            <div class="absolute top-3 left-3 bg-[#E2F163] border border-[#181528] px-2.5 py-1 rounded-full text-[10px] font-mono font-black text-[#181528] flex items-center gap-1 shadow-xs">
                                                <i class="fa-brands fa-instagram text-[10px] text-[#E1306C]"></i>
                                                <span>L5 Verified</span>
                                            </div>
                                        </div>

                                        <div class="space-y-1">
                                            <h3 class="font-display font-black text-lg text-[#181528]">{{ $creator['name'] }}</h3>
                                            <p class="text-xs font-medium text-[#524B66] font-sans">{{ $creator['role'] }}</p>
                                        </div>

                                        <div class="grid grid-cols-2 gap-2 mt-4 p-2.5 rounded-xl bg-white border border-[#181528]/10 text-xs font-mono">
                                            <div>
                                                <span class="text-[10px] text-[#827B96] uppercase font-bold block">IG Reach</span>
                                                <span class="font-extrabold text-[#181528]">{{ $creator['reach'] }}</span>
                                            </div>
                                            <div>
                                                <span class="text-[10px] text-[#827B96] uppercase font-bold block">Starting At</span>
                                                <span class="font-extrabold text-[#FF3E14]">{{ $creator['rate'] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-5 pt-4 border-t border-[#181528]/10">
                                        <a href="{{ route('influencers.public') }}" class="w-full py-2.5 rounded-xl bg-[#181528] hover:bg-[#FF3E14] text-white text-xs font-black font-display text-center transition-all duration-200 flex items-center justify-center gap-1.5 shadow-xs">
                                            <span>Explore Comp Card</span>
                                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>

        <!-- ACTION: MASSIVE VIBRANT LIGHT CTA SECTION -->
        <section class="py-24 sm:py-36 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative p-2 rounded-[3rem] bg-[#E2F163] border-3 border-[#181528] shadow-[10px_10px_0px_#181528] overflow-hidden">
                    <div class="bg-white rounded-[calc(3rem-0.5rem)] p-10 sm:p-16 lg:p-20 text-center space-y-8 relative overflow-hidden">
                        
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[450px] h-[450px] bg-[#F47FA2]/20 rounded-full blur-3xl pointer-events-none"></div>

                        <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-[#FFF385] text-[#181528] border border-[#181528]/15 text-xs font-mono font-bold uppercase shadow-xs">
                            <i class="fa-brands fa-instagram text-[#E1306C]"></i>
                            <span>Scale your Instagram campaigns</span>
                        </div>

                        <h2 class="font-display font-black text-4xl sm:text-6xl lg:text-7xl text-[#181528] tracking-tight leading-[1.05] max-w-5xl mx-auto">
                            Cast Top Instagram <br />
                            <span class="text-[#FF3E14]">Models, Creators &amp; Anchors.</span>
                        </h2>

                        <p class="text-[#524B66] text-sm sm:text-lg font-medium max-w-xl mx-auto font-sans">
                            Whether you're a brand seeking authenticated Instagram talent or a creator looking to monetize your audience with guaranteed escrow payouts, get started in 60 seconds.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4 relative z-10">
                            <a href="{{ route('register') }}" class="w-full sm:w-auto px-9 py-4 rounded-full bg-[#181528] text-white font-display font-black text-base hover:bg-[#FF3E14] transition-all duration-300 flex items-center justify-center space-x-3 shadow-lg active:scale-95">
                                <span>Join The Hype &rarr;</span>
                            </a>

                            <a href="{{ route('influencers.public') }}" class="w-full sm:w-auto px-8 py-4 rounded-full bg-[#FAF5EC] hover:bg-[#E2F163] border-2 border-[#181528] text-[#181528] font-display font-extrabold text-base transition shadow-xs">
                                Explore Talent Roster
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- GEN-Z EDITORIAL FOOTER -->
        <footer class="border-t border-[#181528]/10 bg-[#FAF5EC] pt-16 pb-12 px-4 sm:px-6 lg:px-8 text-xs font-mono text-[#524B66]">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-[#181528]/10">
                
                <div class="space-y-3">
                    <div class="flex items-center space-x-2">
                        <div class="w-7 h-7 rounded-full bg-[#E2F163] border border-[#181528] text-[#181528] font-display font-black flex items-center justify-center text-xs">
                            H*
                        </div>
                        <span class="font-display font-black text-[#181528] text-base">Hype<span class="text-[#FF3E14]">Market</span></span>
                    </div>
                    <p class="text-[#524B66] text-xs font-sans leading-relaxed">
                        Curated Instagram casting ecosystem. Connecting verified models, influencers, and event emcees with verified Meta Graph API analytics &amp; escrow payouts.
                    </p>
                </div>

                <div class="space-y-2.5">
                    <h4 class="text-[#181528] font-black uppercase tracking-wider text-[11px]">Talent Pillars</h4>
                    <ul class="space-y-1.5 font-medium">
                        <li><a href="{{ route('influencers.public', ['talent_type' => 'influencer']) }}" class="hover:text-[#FF3E14] transition flex items-center gap-1.5"><i class="fa-brands fa-instagram text-[11px] text-[#E1306C]"></i> Instagram Influencers</a></li>
                        <li><a href="{{ route('influencers.public', ['talent_type' => 'modeling']) }}" class="hover:text-[#FF3E14] transition flex items-center gap-1.5"><i class="fa-solid fa-camera text-[10px] text-[#FF3E14]"></i> Fashion Models</a></li>
                        <li><a href="{{ route('influencers.public', ['talent_type' => 'anchor']) }}" class="hover:text-[#FF3E14] transition flex items-center gap-1.5"><i class="fa-solid fa-microphone-lines text-[10px] text-[#3B2485]"></i> Event Anchors &amp; Emcees</a></li>
                        <li><a href="{{ route('influencers.public') }}" class="hover:text-[#FF3E14] transition">Full Talent Directory</a></li>
                    </ul>
                </div>

                <div class="space-y-2.5">
                    <h4 class="text-[#181528] font-black uppercase tracking-wider text-[11px]">Portals &amp; Hub</h4>
                    <ul class="space-y-1.5 font-medium">
                        <li><a href="{{ route('brand.login') }}" class="hover:text-[#181528] transition">Brand Studio</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-[#181528] transition">Creator Portal</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-[#181528] transition">Escrow Fee Structure</a></li>
                        <li><a href="{{ route('font.pairs') }}" class="text-[#FF3E14] font-bold hover:underline transition">Typography &amp; Font Lab &rarr;</a></li>
                    </ul>
                </div>

                <div class="space-y-2.5">
                    <h4 class="text-[#181528] font-black uppercase tracking-wider text-[11px]">Meta &amp; Trust</h4>
                    <ul class="space-y-1.5 font-medium">
                        <li><a href="{{ route('privacy') }}" class="hover:text-[#181528] transition">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-[#181528] transition">Terms of Service</a></li>
                        <li><a href="{{ route('data-deletion') }}" class="hover:text-[#181528] transition">Data Deletion Callback</a></li>
                        <li class="pt-2 text-[#181528] flex items-center gap-1.5 font-bold">
                            <i class="fa-brands fa-instagram text-[#E1306C] text-sm"></i>
                            <span>Meta Graph API Verified</span>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="max-w-7xl mx-auto pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] font-medium">
                <p>&copy; {{ date('Y') }} Talent Marketplace Inc. Curated Instagram Casting Hub.</p>
                <div class="flex items-center space-x-6 text-[#524B66]">
                    <a href="{{ route('home') }}" class="hover:text-[#FF3E14] transition font-bold">Home</a>
                    <a href="{{ route('influencers.public') }}" class="hover:text-[#FF3E14] transition font-bold">Talent Directory</a>
                    <a href="{{ route('campaigns.public') }}" class="hover:text-[#FF3E14] transition font-bold">Campaign Briefs</a>
                </div>
            </div>
        </footer>
    </main>

    <!-- Lenis Smooth Scroll -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof Lenis !== 'undefined') {
                const lenis = new Lenis({
                    duration: 1.2,
                    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                    smooth: true,
                });
                function raf(time) {
                    lenis.raf(time);
                    requestAnimationFrame(raf);
                }
                requestAnimationFrame(raf);
            }
        });
    </script>
</body>
</html>