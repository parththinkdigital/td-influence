<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth antialiased selection:bg-[#E1FF01] selection:text-[#161616]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MATTERS. &mdash; Curated Instagram Talent SaaS for Models, Influencers &amp; Anchors</title>
    <meta name="description" content="The intelligent SaaS infrastructure connecting premier brands with verified Instagram creators, fashion models, and live event anchors through Meta Graph API telemetry and 100% milestone escrow.">

    <!-- Fonts: Cabinet Grotesk, Montserrat, Instrument Serif, Plus Jakarta Sans, Space Grotesk, Caveat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Instrument+Serif:ital@0;1&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,700;1,900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN with custom design tokens -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        studio: {
                            base: '#161616',
                            card: '#1D1D1D',
                            elevated: '#242424',
                            border: 'rgba(227, 225, 216, 0.12)',
                            text: '#E3E1D8',
                            subtext: '#A09E95',
                            lime: '#E1FF01',
                            sand: '#DEDED1',
                            dark: '#0E0E0E',
                            pink: '#F47FA2',
                            blue: '#7EC4FB',
                            purple: '#BDB0FC',
                            coral: '#FF3E14'
                        }
                    },
                    fontFamily: {
                        sans: ['Montserrat', 'Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Instrument Serif', 'Georgia', 'serif'],
                        mono: ['Space Grotesk', 'monospace'],
                        body: ['Plus Jakarta Sans', 'sans-serif'],
                        caveat: ['Caveat', 'cursive']
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- GSAP 3.12 & ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- Lenis Smooth Scroll -->
    <script src="https://unpkg.com/lenis@1.1.18/dist/lenis.min.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Matters.sg Signature Design Styles */
        :root {
            --fill: #deded1;
            --sweep: 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            --lime: #E1FF01;
            --bg-dark: #161616;
        }

        html, body {
            background-color: #161616;
            color: #E3E1D8;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        html::-webkit-scrollbar {
            display: none;
        }

        /* Hero Typography & Manual Kerning Interaction */
        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            line-height: 0.85;
            letter-spacing: -0.06em;
            text-transform: uppercase;
            transition: font-weight 0.4s ease, letter-spacing 0.4s ease;
        }
        .hero-title:hover {
            font-weight: 200;
            letter-spacing: -0.02em;
        }
        .hero-title-2 {
            font-family: 'Instrument Serif', Georgia, serif;
            font-style: italic;
            font-weight: 400;
            line-height: 0.9;
            letter-spacing: -0.02em;
            color: #E3E1D8;
        }

        /* Matters.sg Work Cover Hover Sweep */
        .work-cover-content {
            position: relative;
            overflow: hidden;
            background-color: #1a1a1a;
            border: 1px solid rgba(227, 225, 216, 0.1);
            transition: border-color 0.4s ease, transform 0.4s ease;
        }
        .work-cover-content:hover {
            border-color: rgba(225, 255, 1, 0.4);
        }

        .bar-work-cover {
            background-color: #161616;
            isolation: isolate;
            overflow: hidden;
            position: relative;
            width: calc(100% - 3.5rem);
            border-radius: 9999px;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
        }
        .bar-work-cover::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            border-radius: inherit;
            background-image: linear-gradient(to right, rgba(222, 222, 209, 0) 42%, var(--fill) 58%);
            background-size: 250% 100%;
            background-position: 0% 0;
            transition: background-position var(--sweep);
        }
        .work-cover-content:hover .bar-work-cover::before {
            background-position: 100% 0;
        }

        .bar-work-cover .title-work-cover {
            flex: 1 1 auto;
            background-image: linear-gradient(to right, #deded1 42%, #161616 58%);
            background-size: 250% 100%;
            background-position: 0% 0;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
            transition: background-position var(--sweep), font-weight var(--sweep);
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            letter-spacing: -0.03em;
        }
        .work-cover-content:hover .bar-work-cover .title-work-cover {
            background-position: 100% 0;
            font-weight: 800;
        }

        .work-tag-pill {
            opacity: 0;
            transform: translateY(12px);
            transition: opacity 0.35s ease, transform 0.45s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .work-cover-content:hover .work-tag-pill {
            opacity: 1;
            transform: translateY(0);
        }
        .work-cover-content:hover .work-tag-pill:nth-child(1) { transition-delay: 0.05s; }
        .work-cover-content:hover .work-tag-pill:nth-child(2) { transition-delay: 0.12s; }
        .work-cover-content:hover .work-tag-pill:nth-child(3) { transition-delay: 0.19s; }
        .work-cover-content:hover .work-tag-pill:nth-child(4) { transition-delay: 0.26s; }

        /* Kinetic Marquee */
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marquee 26s linear infinite;
        }
        .marquee-track:hover {
            animation-play-state: paused;
        }
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }

        /* Ambient subtle grain overlay */
        .noise-overlay {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.035'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Live pulse animation */
        .pulse-lime {
            box-shadow: 0 0 0 0 rgba(225, 255, 1, 0.7);
            animation: pulse-lime-anim 2s infinite cubic-bezier(0.66, 0, 0, 1);
        }
        @keyframes pulse-lime-anim {
            to {
                box-shadow: 0 0 0 10px rgba(225, 255, 1, 0);
            }
        }

        /* Magnetic button glow */
        .glow-hover {
            transition: all 0.4s ease;
        }
        .glow-hover:hover {
            box-shadow: 0 0 35px -5px rgba(225, 255, 1, 0.35);
        }
    </style>
</head>
<body class="bg-[#161616] text-[#E3E1D8] antialiased selection:bg-[#E1FF01] selection:text-[#161616] noise-overlay"
      x-data="{
          menuOpen: false,
          briefOpen: false,
          activePillar: 'influencers',
          filterSearch: '',
          selectedVertical: 'influencer',
          selectedScope: 'campaign',
          calcReach: '3.4M - 5.8M',
          calcFee: '₹45,000',
          activeTestimonial: 0,
          testimonials: [
              {
                  quote: 'HypeMarket has fundamentally changed how we cast talent. Being able to browse authentic Instagram comp cards, verify real-time Meta Graph API retention data, and lock campaign payouts in milestone escrow gives our brand team 100% confidence.',
                  author: 'Ananya Singhania',
                  role: 'Head of Brand & Growth, Nykaa Luxe',
                  metric: '4.8M Verified Impressions'
              },
              {
                  quote: 'As an editorial runway model and Reels creator, having guaranteed escrow deposits before stepping on set is life-changing. No chasing invoices or payment disputes—just verified brand contracts and instant milestone payouts.',
                  author: 'Arya Varma',
                  role: 'Fashion Model & Viral Creator (L5 Verified)',
                  metric: '185K Followers • 8.9% Eng'
              },
              {
                  quote: 'We booked 4 keynote event anchors for our 3-day tech summit in 15 minutes. Showreels were attached directly on their comp cards, and contracts with commercial usage rights were automatically executed.',
                  author: 'Vikram Malhotra',
                  role: 'Executive Producer, Asia Tech Summit',
                  metric: '100% Escrow Settled'
              }
          ]
      }">

    <!-- ========================================== -->
    <!-- 1. FLOATING NAVIGATION (Matters.sg Exact Bar) -->
    <!-- ========================================== -->
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 backdrop-blur-md bg-[#161616]/80 border-b border-[#E3E1D8]/10" id="main-header">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo with Pulse -->
            <a href="{{ route('home.dark3') }}" class="group flex items-center space-x-2.5 text-decoration-none">
                <span class="font-extrabold tracking-tighter text-2xl font-mono text-[#E3E1D8] group-hover:text-[#E1FF01] transition-colors">
                    MATTERS<span class="text-[#E1FF01]">.</span>
                </span>
                <span class="text-[10px] font-mono font-bold uppercase bg-[#E1FF01]/10 text-[#E1FF01] px-2 py-0.5 rounded-full border border-[#E1FF01]/25 hidden sm:inline-block">
                    TALENT SAAS
                </span>
                <span class="inline-block w-2 h-2 rounded-full bg-[#E1FF01] pulse-lime"></span>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center space-x-8 text-xs font-mono tracking-widest uppercase text-[#E3E1D8]/70">
                <a href="#hero" class="hover:text-[#E1FF01] transition-colors">Manifesto</a>
                <a href="#pillars" class="hover:text-[#E1FF01] transition-colors">3 Pillars</a>
                <a href="#search-console" class="hover:text-[#E1FF01] transition-colors">Cast Talent</a>
                <a href="#roster" class="hover:text-[#E1FF01] transition-colors">Verified Roster</a>
                <a href="#telemetry" class="hover:text-[#E1FF01] transition-colors">Escrow &amp; Meta API</a>
                <a href="#estimator" class="hover:text-[#E1FF01] transition-colors">Scope Estimator</a>
            </nav>

            <!-- Action Island -->
            <div class="flex items-center space-x-4">
                @auth
                    @if(auth()->user()->isBrand())
                        <a href="{{ route('brand.dashboard') }}" class="px-4 py-2 rounded-full bg-[#E1FF01] text-[#161616] text-xs font-mono font-black uppercase tracking-wider hover:bg-white transition-all">
                            Brand Studio
                        </a>
                    @elseif(auth()->user()->isTalent())
                        <a href="{{ route('influencer.dashboard') }}" class="px-4 py-2 rounded-full bg-[#F47FA2] text-[#161616] text-xs font-mono font-black uppercase tracking-wider hover:bg-white transition-all">
                            Creator Studio
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-full bg-white text-[#161616] text-xs font-mono font-black uppercase tracking-wider hover:bg-[#E1FF01] transition-all">
                            Admin Gateway
                        </a>
                    @endif
                @else
                    <!-- Sign In Link -->
                    <a href="{{ route('login') }}" class="hidden sm:inline-block text-xs font-mono uppercase tracking-wider text-[#E3E1D8]/70 hover:text-white transition-colors">
                        Sign In
                    </a>

                    <!-- Join / Cast Talent Pill Button (Matters.sg Sweep Style) -->
                    <a href="{{ route('register') }}" class="relative group overflow-hidden rounded-full border border-[#E3E1D8]/30 px-5 py-2 text-xs font-mono uppercase tracking-wider text-[#E3E1D8] transition-all duration-500 hover:border-[#E1FF01]">
                        <span class="relative z-10 transition-colors duration-300 group-hover:text-[#161616] font-bold flex items-center space-x-2">
                            <span>Join Platform</span>
                            <i class="fa-solid fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform duration-300"></i>
                        </span>
                        <span class="absolute inset-0 z-0 bg-[#E1FF01] translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out"></span>
                    </a>
                @endauth

                <!-- Fullscreen Menu Toggle -->
                <button @click="menuOpen = !menuOpen" class="w-10 h-10 rounded-full border border-[#E3E1D8]/20 flex flex-col items-center justify-center space-y-1 hover:border-[#E1FF01] transition-colors" aria-label="Toggle Menu">
                    <span class="w-4 h-[1.5px] bg-[#E3E1D8] transition-all duration-300" :class="menuOpen ? 'rotate-45 translate-y-[3.5px] bg-[#E1FF01]' : ''"></span>
                    <span class="w-4 h-[1.5px] bg-[#E3E1D8] transition-all duration-300" :class="menuOpen ? '-rotate-45 -translate-y-[2px] bg-[#E1FF01]' : ''"></span>
                </button>
            </div>
        </div>
    </header>

    <!-- ========================================== -->
    <!-- FULLSCREEN MEGA MENU DRAWER (Matters.sg Style) -->
    <!-- ========================================== -->
    <div x-show="menuOpen"
         x-transition:enter="transition ease-out duration-400"
         x-transition:enter-start="opacity-0 -translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-8"
         class="fixed inset-0 z-40 bg-[#161616]/98 backdrop-blur-2xl flex flex-col justify-between p-8 sm:p-16 pt-28"
         style="display: none;">
        <div class="max-w-7xl mx-auto w-full grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <p class="text-xs font-mono uppercase tracking-widest text-[#E1FF01]">// SAAS PLATFORM NAVIGATION</p>
                <div class="flex flex-col space-y-4 text-3xl sm:text-5xl font-black font-sans uppercase tracking-tight">
                    <a @click="menuOpen = false" href="{{ route('influencers.public') }}" class="hover:text-[#E1FF01] hover:translate-x-3 transition-all duration-300">01. Explore All Talent</a>
                    <a @click="menuOpen = false" href="{{ route('influencers.public', ['talent_type' => 'influencer']) }}" class="hover:text-[#E1FF01] hover:translate-x-3 transition-all duration-300">02. Instagram Influencers</a>
                    <a @click="menuOpen = false" href="{{ route('influencers.public', ['talent_type' => 'modeling']) }}" class="hover:text-[#E1FF01] hover:translate-x-3 transition-all duration-300">03. Fashion &amp; Runway Models</a>
                    <a @click="menuOpen = false" href="{{ route('influencers.public', ['talent_type' => 'anchor']) }}" class="hover:text-[#E1FF01] hover:translate-x-3 transition-all duration-300">04. Event Anchors &amp; Emcees</a>
                    <a @click="menuOpen = false" href="{{ route('campaigns.public') }}" class="hover:text-[#E1FF01] hover:translate-x-3 transition-all duration-300">05. Live Campaign Briefs</a>
                    <a @click="menuOpen = false" href="{{ route('pricing') }}" class="hover:text-[#E1FF01] hover:translate-x-3 transition-all duration-300">06. Escrow Pricing &amp; Fees</a>
                </div>
            </div>

            <div class="space-y-8 border-t md:border-t-0 md:border-l border-[#E3E1D8]/10 md:pl-12">
                <div>
                    <h4 class="text-xs font-mono uppercase tracking-widest text-[#E3E1D8]/60 mb-2">Platform Concierge &amp; Inquiries</h4>
                    <a href="mailto:concierge@matters.agency" class="text-xl sm:text-2xl font-mono text-[#E3E1D8] hover:text-[#E1FF01] transition-colors underline decoration-[#E1FF01]">
                        concierge@matters.agency
                    </a>
                </div>
                <div>
                    <h4 class="text-xs font-mono uppercase tracking-widest text-[#E3E1D8]/60 mb-3">Live Platform Telemetry</h4>
                    <div class="grid grid-cols-2 gap-4 text-xs font-mono">
                        <div class="p-3 bg-[#242424] rounded-lg border border-white/5">
                            <span class="text-[#E1FF01]">● {{ $stats['talents'] ?? '4,800+' }}</span> Verified Creators
                        </div>
                        <div class="p-3 bg-[#242424] rounded-lg border border-white/5">
                            <span class="text-[#E1FF01]">● 12.5M+</span> Monthly Reach
                        </div>
                        <div class="p-3 bg-[#242424] rounded-lg border border-white/5">
                            <span class="text-[#E1FF01]">● 100%</span> Escrow Protected
                        </div>
                        <div class="p-3 bg-[#242424] rounded-lg border border-white/5">
                            <span class="text-[#E1FF01]">● Meta Graph</span> Real-Time Sync
                        </div>
                    </div>
                </div>
                <div class="flex space-x-4 pt-2">
                    <a href="{{ route('register') }}" class="px-6 py-3 rounded-full bg-[#E1FF01] text-[#161616] font-black text-xs font-mono uppercase tracking-wider hover:bg-white transition-colors">
                        Create Account &rarr;
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-full bg-[#242424] border border-white/10 text-white font-bold text-xs font-mono uppercase tracking-wider hover:border-[#E1FF01] transition-colors">
                        Sign In
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto w-full pt-8 border-t border-[#E3E1D8]/10 flex flex-col sm:flex-row justify-between items-center text-xs font-mono text-[#E3E1D8]/50">
            <div>&copy; {{ date('Y') }} MATTERS. / HypeMarket Inc. &bull; Curated Instagram Casting &amp; Escrow Infrastructure.</div>
            <div class="flex space-x-6 mt-4 sm:mt-0">
                <a href="{{ route('home.light') }}" class="hover:text-[#E1FF01] transition-colors">Light (Ivory)</a>
                <a href="{{ route('home.dark') }}" class="hover:text-[#E1FF01] transition-colors">Cyber Dark</a>
                <a href="{{ route('font.pairs') }}" class="hover:text-[#E1FF01] transition-colors">Font Lab</a>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 2. HERO SECTION (Matters.sg Exact Flow + Welcome Content) -->
    <!-- ========================================== -->
    <section id="hero" class="relative pt-36 pb-20 sm:pt-44 sm:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            
            <!-- Hero Top Tagline & Telemetry Bar -->
            <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-[#E3E1D8]/15 pb-8 mb-12 gap-6">
                <div>
                    <span class="text-xs font-mono tracking-widest uppercase text-[#E1FF01] flex items-center gap-2 mb-1">
                        <i class="fa-brands fa-instagram text-[#E1306C]"></i>
                        <span>// CURATED INSTAGRAM TALENT NETWORK</span>
                        <span>&bull;</span>
                        <span>VERIFIED CASTING SAAS</span>
                    </span>
                    <h2 class="text-sm font-body text-[#E3E1D8]/70">
                        Fashion &amp; Runway Models &bull; Viral Reels Creators &bull; Stage &amp; Event Anchors
                    </h2>
                </div>

                <!-- Matters.sg Live Telemetry Widget -->
                <div class="flex items-center space-x-6 sm:space-x-8 text-xs font-mono">
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-[#E1FF01] pulse-lime"></span>
                        <span class="text-[#E3E1D8] font-bold">28˚C</span>
                        <span class="text-[#E3E1D8]/50">Singapore Now</span>
                    </div>
                    <div class="w-px h-6 bg-[#E3E1D8]/20"></div>
                    <div>
                        <span class="text-[#E1FF01] font-bold">{{ $stats['talents'] ?? '4,800+' }}</span>
                        <span class="text-[#E3E1D8]/50 ml-1">Creators</span>
                    </div>
                    <div class="w-px h-6 bg-[#E3E1D8]/20"></div>
                    <div>
                        <span class="text-[#E3E1D8] font-bold">100%</span>
                        <span class="text-[#E3E1D8]/50 ml-1">Escrow Guarded</span>
                    </div>
                </div>
            </div>

            <!-- Giant Typographic Hero: CAST with precision. (Matters.sg Style) -->
            <div class="my-10 sm:my-16 text-center sm:text-left">
                <div class="hero-tire-wrap select-none">
                    <h1 class="hero-title text-7xl sm:text-[9.5vw] text-[#E3E1D8] font-black leading-none tracking-tighter cursor-pointer" title="Hover to interact">
                        CAST
                    </h1>
                    <div class="hero-title-2 text-5xl sm:text-[7vw] text-[#DEDED1] mt-2 sm:-mt-4 font-serif italic">
                        with verified impact.
                    </div>
                </div>
            </div>

            <!-- HARDWARE SEARCH CONSOLE BAR (From Welcome Content) -->
            <div class="my-10 max-w-5xl" id="search-console">
                <div class="p-1.5 rounded-3xl bg-[#1D1D1D] border border-[#E3E1D8]/20 shadow-2xl glow-hover">
                    <form action="{{ route('influencers.public') }}" method="GET" class="bg-[#161616] rounded-[calc(1.5rem-0.375rem)] p-3 sm:p-4 flex flex-col sm:flex-row items-center gap-3">
                        <!-- Input -->
                        <div class="flex-grow flex items-center px-4 w-full text-[#E3E1D8]">
                            <i class="fa-solid fa-magnifying-glass text-[#E1FF01] mr-3 text-sm"></i>
                            <input type="text" name="search" x-model="filterSearch" placeholder="Search verified creators: 'Runway Model', 'Tech Reviewer', 'Event Emcee', 'Reels Director'..." class="w-full bg-transparent text-sm sm:text-base font-medium text-[#E3E1D8] placeholder-[#A09E95] outline-none">
                        </div>

                        <!-- Category Filter Quick Pills -->
                        <div class="hidden lg:flex items-center space-x-2 px-2 text-xs font-mono">
                            <a href="{{ route('influencers.public', ['talent_type' => 'influencer']) }}" class="px-3 py-1.5 rounded-full bg-[#242424] text-[#F47FA2] hover:bg-[#F47FA2] hover:text-[#161616] border border-white/5 transition flex items-center gap-1.5">
                                <i class="fa-brands fa-instagram text-xs"></i>
                                <span>#Influencers</span>
                            </a>
                            <a href="{{ route('influencers.public', ['talent_type' => 'modeling']) }}" class="px-3 py-1.5 rounded-full bg-[#242424] text-[#E1FF01] hover:bg-[#E1FF01] hover:text-[#161616] border border-white/5 transition flex items-center gap-1.5">
                                <i class="fa-solid fa-camera text-xs"></i>
                                <span>#Models</span>
                            </a>
                            <a href="{{ route('influencers.public', ['talent_type' => 'anchor']) }}" class="px-3 py-1.5 rounded-full bg-[#242424] text-[#BDB0FC] hover:bg-[#BDB0FC] hover:text-[#161616] border border-white/5 transition flex items-center gap-1.5">
                                <i class="fa-solid fa-microphone-lines text-xs"></i>
                                <span>#Anchors</span>
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-[#E1FF01] hover:bg-white text-[#161616] font-mono font-black text-xs uppercase tracking-wider transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg active:scale-95 flex-shrink-0">
                            <span>Cast Talent</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Pill Showreel / SaaS Comp-Card Showcase (Matters.sg Center Video Pill) -->
            <div class="relative w-full rounded-3xl overflow-hidden border border-[#E3E1D8]/20 bg-[#1D1D1D] my-12 group shadow-2xl">
                <div class="aspect-[21/9] sm:aspect-[24/9] w-full relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=2000&q=85" 
                         alt="Editorial Runway and Instagram Talent Showreel" 
                         class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-1000 brightness-75 contrast-125">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-[#161616] via-transparent to-[#161616]/40"></div>

                    <!-- Floating Pill Telemetry HUD -->
                    <div class="absolute bottom-6 left-6 right-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 sm:p-6 rounded-2xl bg-[#161616]/85 backdrop-blur-xl border border-white/10">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-full bg-[#E1FF01] text-[#161616] flex items-center justify-center font-black font-mono text-sm">
                                <i class="fa-brands fa-instagram text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm tracking-tight text-white font-sans">AUTHENTICATED INSTAGRAM GRAPH TALENT HUB</h4>
                                <p class="text-xs text-[#E3E1D8]/60 font-mono">Live Audience Sync &bull; Polaroid Comp Cards &bull; Video Showreels &bull; Milestone Escrow</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-3 py-1 rounded-full bg-[#E1FF01]/10 text-[#E1FF01] text-xs font-mono border border-[#E1FF01]/20">
                                100% Escrow Guarded
                            </span>
                            <a href="{{ route('influencers.public') }}" class="px-4 py-2 rounded-full bg-[#E1FF01] text-[#161616] font-bold text-xs uppercase tracking-wider font-mono hover:bg-white transition-colors">
                                Browse 4.8K+ Roster
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manifesto / Positioning Statement (Line-by-line GSAP reveal style) -->
            <div class="max-w-4xl pt-8 pb-12">
                <p class="text-2xl sm:text-4xl font-normal leading-tight font-serif text-[#DEDED1] tracking-tight">
                    Direct access to authenticated <span class="text-[#E1FF01] font-sans font-bold not-italic">Instagram creators</span>, <span class="text-white underline decoration-[#E1FF01]/50 underline-offset-8">runway models</span>, and <span class="text-white italic">live event anchors</span> with real-time Meta Graph API analytics, digital comp cards, and <span class="text-[#E1FF01]">100% milestone escrow protection.</span>
                </p>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 3. KINETIC TICKER (Welcome Content Styled Matters-Style) -->
    <!-- ========================================== -->
    <div class="py-8 bg-[#E1FF01] text-[#161616] overflow-hidden select-none border-y border-[#161616]/20">
        <div class="marquee-track flex items-center space-x-12 text-4xl sm:text-6xl font-black uppercase tracking-tighter">
            <span class="flex items-center gap-3"><i class="fa-brands fa-instagram"></i> INSTAGRAM REEL CREATORS</span>
            <span class="inline-block w-4 h-4 rounded-full bg-[#161616]"></span>
            <span class="font-serif italic font-normal">Fashion Runway</span>
            <span class="inline-block w-4 h-4 rounded-full bg-[#161616]"></span>
            <span>STAGE ANCHORS</span>
            <span class="inline-block w-4 h-4 rounded-full bg-[#161616]"></span>
            <span class="font-mono text-3xl sm:text-4xl">100% ESCROW PROTECTED</span>
            <span class="inline-block w-4 h-4 rounded-full bg-[#161616]"></span>
            <span>META GRAPH SYNC</span>
            <span class="inline-block w-4 h-4 rounded-full bg-[#161616]"></span>
            <span class="font-serif italic font-normal">that matters.</span>
            <span class="inline-block w-4 h-4 rounded-full bg-[#161616]"></span>
            
            <!-- Loop Repeat -->
            <span class="flex items-center gap-3"><i class="fa-brands fa-instagram"></i> INSTAGRAM REEL CREATORS</span>
            <span class="inline-block w-4 h-4 rounded-full bg-[#161616]"></span>
            <span class="font-serif italic font-normal">Fashion Runway</span>
            <span class="inline-block w-4 h-4 rounded-full bg-[#161616]"></span>
            <span>STAGE ANCHORS</span>
            <span class="inline-block w-4 h-4 rounded-full bg-[#161616]"></span>
            <span class="font-mono text-3xl sm:text-4xl">100% ESCROW PROTECTED</span>
            <span class="inline-block w-4 h-4 rounded-full bg-[#161616]"></span>
            <span>META GRAPH SYNC</span>
            <span class="inline-block w-4 h-4 rounded-full bg-[#161616]"></span>
            <span class="font-serif italic font-normal">that matters.</span>
            <span class="inline-block w-4 h-4 rounded-full bg-[#161616]"></span>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 4. THE 3 CORE TALENT PILLARS BENTO (From Welcome Content) -->
    <!-- ========================================== -->
    <section id="pillars" class="py-24 border-t border-[#E3E1D8]/10 bg-[#161616]">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-[#E1FF01] block mb-2">// 3 CORE TALENT CATEGORIES</span>
                    <h2 class="text-4xl sm:text-6xl font-black tracking-tighter uppercase font-sans">
                        Cast Across Niches.
                    </h2>
                </div>
                <p class="text-sm font-mono text-[#E3E1D8]/60 max-w-md">
                    Targeted casting for brand campaigns. Authenticated Meta Graph API audience analytics, Polaroids, physical comp cards, and verified showreels.
                </p>
            </div>

            <!-- Bento Grid of the 3 Pillars -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Pillar 1: Instagram Influencers & Reel Creators -->
                <div class="group relative rounded-3xl bg-[#1D1D1D] p-8 border border-[#E3E1D8]/10 hover:border-[#F47FA2]/60 transition-all duration-500 flex flex-col justify-between overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#F47FA2]/5 rounded-full blur-3xl group-hover:bg-[#F47FA2]/20 transition-all duration-500"></div>

                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-3xl font-black font-mono text-[#F47FA2]">01</span>
                            <span class="text-xs font-mono uppercase tracking-widest text-[#F47FA2] bg-[#F47FA2]/10 border border-[#F47FA2]/30 px-3 py-1 rounded-full">
                                Reels &bull; Stories &bull; Collabs
                            </span>
                        </div>

                        <div class="aspect-video w-full rounded-2xl overflow-hidden mb-6 relative">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80" 
                                 alt="Instagram Influencer Creator" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 brightness-90">
                            <div class="absolute bottom-2 left-2 px-2.5 py-1 bg-black/70 backdrop-blur-md rounded-md text-[10px] font-mono text-[#F47FA2] flex items-center gap-1.5">
                                <i class="fa-brands fa-instagram"></i> Meta Graph Live Sync
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold font-sans tracking-tight text-[#E3E1D8] mb-3">
                            Instagram Influencers &amp; Reel Creators
                        </h3>
                        <p class="text-xs text-[#E3E1D8]/70 leading-relaxed mb-6 font-body">
                            Authentic fashion, beauty, food, tech, and lifestyle creators with real-time Instagram Graph API sync. Live audience retention, genuine engagement rates, and demographic breakdown.
                        </p>
                    </div>

                    <div class="border-t border-[#E3E1D8]/10 pt-4 flex items-center justify-between">
                        <span class="text-xs font-mono text-[#E3E1D8]/60">3,500+ Verified Creators</span>
                        <a href="{{ route('influencers.public', ['talent_type' => 'influencer']) }}" class="text-xs font-mono font-bold text-[#F47FA2] hover:underline flex items-center gap-1">
                            <span>Browse Creators</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Pillar 2: Fashion & Editorial Models -->
                <div class="group relative rounded-3xl bg-[#1D1D1D] p-8 border border-[#E3E1D8]/10 hover:border-[#E1FF01]/60 transition-all duration-500 flex flex-col justify-between overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#E1FF01]/5 rounded-full blur-3xl group-hover:bg-[#E1FF01]/20 transition-all duration-500"></div>

                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-3xl font-black font-mono text-[#E1FF01]">02</span>
                            <span class="text-xs font-mono uppercase tracking-widest text-[#E1FF01] bg-[#E1FF01]/10 border border-[#E1FF01]/30 px-3 py-1 rounded-full">
                                Runway &bull; Comp Cards
                            </span>
                        </div>

                        <div class="aspect-video w-full rounded-2xl overflow-hidden mb-6 relative">
                            <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80" 
                                 alt="Fashion & Editorial Model" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 brightness-90">
                            <div class="absolute bottom-2 left-2 px-2.5 py-1 bg-black/70 backdrop-blur-md rounded-md text-[10px] font-mono text-[#E1FF01] flex items-center gap-1.5">
                                <i class="fa-solid fa-camera"></i> Verified Comp Cards &amp; Stats
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold font-sans tracking-tight text-[#E3E1D8] mb-3">
                            Fashion &amp; Editorial Models
                        </h3>
                        <p class="text-xs text-[#E3E1D8]/70 leading-relaxed mb-6 font-body">
                            Professional apparel catalogue, bridal, ecommerce, and high-fashion runway models with verified measurements, Polaroids, and physical comp cards.
                        </p>
                    </div>

                    <div class="border-t border-[#E3E1D8]/10 pt-4 flex items-center justify-between">
                        <span class="text-xs font-mono text-[#E3E1D8]/60">Verified Heights &amp; Bust/Waist</span>
                        <a href="{{ route('influencers.public', ['talent_type' => 'modeling']) }}" class="text-xs font-mono font-bold text-[#E1FF01] hover:underline flex items-center gap-1">
                            <span>Cast Models</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Pillar 3: Event Anchors & Stage Emcees -->
                <div class="group relative rounded-3xl bg-[#1D1D1D] p-8 border border-[#E3E1D8]/10 hover:border-[#BDB0FC]/60 transition-all duration-500 flex flex-col justify-between overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#BDB0FC]/5 rounded-full blur-3xl group-hover:bg-[#BDB0FC]/20 transition-all duration-500"></div>

                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-3xl font-black font-mono text-[#BDB0FC]">03</span>
                            <span class="text-xs font-mono uppercase tracking-widest text-[#BDB0FC] bg-[#BDB0FC]/10 border border-[#BDB0FC]/30 px-3 py-1 rounded-full">
                                Stage &bull; Keynotes &bull; Galas
                            </span>
                        </div>

                        <div class="aspect-video w-full rounded-2xl overflow-hidden mb-6 relative">
                            <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=800&q=80" 
                                 alt="Event Anchor & Emcee" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 brightness-90">
                            <div class="absolute bottom-2 left-2 px-2.5 py-1 bg-black/70 backdrop-blur-md rounded-md text-[10px] font-mono text-[#BDB0FC] flex items-center gap-1.5">
                                <i class="fa-solid fa-microphone-lines"></i> 4K Video Showreels
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold font-sans tracking-tight text-[#E3E1D8] mb-3">
                            Event Anchors &amp; Stage Emcees
                        </h3>
                        <p class="text-xs text-[#E3E1D8]/70 leading-relaxed mb-6 font-body">
                            High-energy corporate event hosts, destination wedding anchors, campus fests, and bilingual presenters with verified video showreels attached.
                        </p>
                    </div>

                    <div class="border-t border-[#E3E1D8]/10 pt-4 flex items-center justify-between">
                        <span class="text-xs font-mono text-[#E3E1D8]/60">Bilingual &amp; Global Stages</span>
                        <a href="{{ route('influencers.public', ['talent_type' => 'anchor']) }}" class="text-xs font-mono font-bold text-[#BDB0FC] hover:underline flex items-center gap-1">
                            <span>Book Emcees</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 5. CURATED SPOTLIGHT TALENT ROSTER (Matters.sg Sweep Effect) -->
    <!-- ========================================== -->
    <section id="roster" class="py-24 border-t border-[#E3E1D8]/10 bg-[#161616]">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-16 gap-6">
                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-[#E1FF01] block mb-2">// VERIFIED COMP CARDS</span>
                    <h2 class="text-4xl sm:text-6xl font-black tracking-tighter uppercase font-sans">
                        Spotlight Talent.
                    </h2>
                </div>
                <a href="{{ route('influencers.public') }}" class="inline-flex items-center space-x-2 text-xs font-mono uppercase tracking-widest text-[#E1FF01] hover:underline">
                    <span>View All {{ $stats['talents'] ?? '4,800+' }} Talent Profiles</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <!-- Dynamic Grid from Welcome Top Talents with Matters.sg Sweep -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($topTalents ?? [] as $talent)
                    @php
                        $totFollowers = $talent->socialAccounts ? $talent->socialAccounts->sum('followers') : 185000;
                        $startingRate = $talent->rates ? $talent->rates->min('rate_amount') : 15000;
                        $avatar = $talent->profile_image ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=500&h=500&fit=crop';
                        $displayName = $talent->display_name ?: ($talent->user->name ?? 'Elena Rostova');
                        $primaryCategory = is_array($talent->primary_categories) ? implode(' • ', $talent->primary_categories) : ($talent->primary_categories ?: 'Fashion & Viral Reels');
                    @endphp

                    <div class="work-cover-content rounded-3xl p-6 sm:p-7 flex flex-col justify-between min-h-[520px]">
                        <div>
                            <!-- Tags that glide in on hover -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="work-tag-pill px-3 py-1 bg-[#242424] border border-white/10 rounded-full text-[11px] font-mono text-[#E3E1D8]">
                                    L{{ $talent->verification_level ?? 5 }} Verified
                                </span>
                                <span class="work-tag-pill px-3 py-1 bg-[#242424] border border-white/10 rounded-full text-[11px] font-mono text-[#E3E1D8]">
                                    ★ {{ number_format((float)($talent->rating_avg ?: 5.0), 1) }}
                                </span>
                                <span class="work-tag-pill px-3 py-1 bg-[#E1FF01]/15 border border-[#E1FF01]/30 rounded-full text-[11px] font-mono text-[#E1FF01]">
                                    {{ $totFollowers ? number_format($totFollowers).' Reach' : '185K Reach' }}
                                </span>
                            </div>

                            <!-- Avatar / Comp Card Image Preview -->
                            <div class="aspect-[3/4] w-full rounded-2xl overflow-hidden relative bg-[#242424]">
                                <img src="{{ $avatar }}" 
                                     alt="{{ $displayName }}" 
                                     class="w-full h-full object-cover brightness-95 group-hover:scale-105 transition-transform duration-700">
                                
                                <div class="absolute bottom-3 left-3 right-3 p-3 bg-black/80 backdrop-blur-md rounded-xl text-xs font-mono flex items-center justify-between text-[#E3E1D8]">
                                    <span>From ₹{{ number_format($startingRate ?: 15000) }}</span>
                                    <span class="text-[#E1FF01] font-bold">100% Escrow</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <p class="text-xs font-mono text-[#E3E1D8]/60">{{ $primaryCategory }}</p>
                            </div>
                        </div>

                        <!-- Bottom Title Bar with Matters.sg Sweep Effect -->
                        <div class="mt-6 flex items-center justify-between">
                            <div class="bar-work-cover">
                                <h3 class="title-work-cover text-base sm:text-lg truncate">
                                    {{ strtoupper($displayName) }}
                                </h3>
                            </div>
                            <a href="{{ route('influencers.public.show', $talent->username ?: ($talent->id ?? 1)) }}" class="w-11 h-11 rounded-full border border-[#E3E1D8]/20 flex items-center justify-center text-[#E3E1D8] hover:border-[#E1FF01] hover:text-[#E1FF01] transition-all flex-shrink-0">
                                <i class="fa-solid fa-arrow-up-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- High-Fashion Mock Talents -->
                    @php
                        $fallbackTalents = [
                            ['name' => 'Arya Varma', 'role' => 'Fashion Runway Model & IG Reels', 'reach' => '185K', 'rate' => '₹15,000', 'img' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=500&h=500&fit=crop'],
                            ['name' => 'Rohan Sen', 'role' => 'Tech Reviewer & Event Host', 'reach' => '320K', 'rate' => '₹22,000', 'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500&h=500&fit=crop'],
                            ['name' => 'Zara Merchant', 'role' => 'Streetwear & Lifestyle Anchor', 'reach' => '490K', 'rate' => '₹35,000', 'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=500&h=500&fit=crop'],
                        ];
                    @endphp
                    @foreach($fallbackTalents as $fb)
                        <div class="work-cover-content rounded-3xl p-6 sm:p-7 flex flex-col justify-between min-h-[520px]">
                            <div>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="work-tag-pill px-3 py-1 bg-[#242424] border border-white/10 rounded-full text-[11px] font-mono text-[#E3E1D8]">L5 Verified</span>
                                    <span class="work-tag-pill px-3 py-1 bg-[#E1FF01]/15 border border-[#E1FF01]/30 rounded-full text-[11px] font-mono text-[#E1FF01]">{{ $fb['reach'] }} Reach</span>
                                </div>
                                <div class="aspect-[3/4] w-full rounded-2xl overflow-hidden relative">
                                    <img src="{{ $fb['img'] }}" alt="{{ $fb['name'] }}" class="w-full h-full object-cover">
                                </div>
                                <p class="text-xs font-mono text-[#E3E1D8]/60 mt-4">{{ $fb['role'] }}</p>
                            </div>
                            <div class="mt-6 flex items-center justify-between">
                                <div class="bar-work-cover">
                                    <h3 class="title-work-cover text-base sm:text-lg">{{ strtoupper($fb['name']) }}</h3>
                                </div>
                                <a href="{{ route('influencers.public') }}" class="w-11 h-11 rounded-full border border-[#E3E1D8]/20 flex items-center justify-center text-[#E3E1D8]">
                                    <i class="fa-solid fa-arrow-up-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 6. META GRAPH API & ESCROW TELEMETRY -->
    <!-- ========================================== -->
    <section id="telemetry" class="py-24 border-t border-[#E3E1D8]/10 bg-[#161616]">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-5 space-y-6">
                    <span class="text-xs font-mono uppercase tracking-widest text-[#E1FF01] block">// SECURITY &amp; META TELEMETRY</span>
                    <h2 class="text-4xl sm:text-5xl font-black tracking-tight font-sans uppercase">
                        Zero Bot Fluff.<br>
                        <span class="font-serif italic font-normal text-[#DEDED1]">100% Escrow Guarded.</span>
                    </h2>
                    <p class="text-sm text-[#E3E1D8]/70 leading-relaxed font-body">
                        Direct offer dispatch, usage rights licensing agreements, and guaranteed payout release once deliverables pass brand review. Powered by direct Meta Graph API token sync.
                    </p>

                    <div class="space-y-4 pt-4 text-xs font-mono">
                        <div class="flex items-start space-x-4 p-4 rounded-2xl bg-[#1D1D1D] border border-white/5">
                            <div class="w-8 h-8 rounded-full bg-[#E1FF01]/10 text-[#E1FF01] flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#E3E1D8] mb-1">Instant Milestone Escrow</h4>
                                <p class="text-[#E3E1D8]/60">Funds are deposited into secure escrow and only released after raw 4K footage and published reels meet agreed KPIs.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 rounded-2xl bg-[#1D1D1D] border border-white/5">
                            <div class="w-8 h-8 rounded-full bg-[#E1FF01]/10 text-[#E1FF01] flex items-center justify-center flex-shrink-0">
                                <i class="fa-brands fa-instagram"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#E3E1D8] mb-1">Real-Time Meta Graph Sync</h4>
                                <p class="text-[#E3E1D8]/60">Direct token verification of genuine engagement rate, audience retention, and zero-bot fraud score.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Live Terminal HUD -->
                <div class="lg:col-span-7 rounded-3xl bg-[#1D1D1D] border border-[#E3E1D8]/15 p-8 font-mono shadow-2xl relative overflow-hidden">
                    <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-6 text-xs text-[#E3E1D8]/60">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-red-500/80"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-500/80"></span>
                            <span class="w-3 h-3 rounded-full bg-green-500/80"></span>
                            <span class="ml-2 text-[#E3E1D8] font-bold">META_GRAPH_AUDIT_v26.0</span>
                        </div>
                        <span class="text-[#E1FF01] bg-[#E1FF01]/10 px-2.5 py-1 rounded-full text-[11px] border border-[#E1FF01]/25">LIVE TELEMETRY</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 mb-8">
                        <div class="p-4 bg-[#242424] rounded-2xl border border-white/5">
                            <div class="text-[10px] text-[#E3E1D8]/50 uppercase mb-1">Audited Creators</div>
                            <div class="text-2xl font-black text-[#E3E1D8] tracking-tight">{{ $stats['talents'] ?? '4,800+' }}</div>
                            <div class="text-[10px] text-[#E1FF01] mt-1">100% Verified Demographics</div>
                        </div>
                        <div class="p-4 bg-[#242424] rounded-2xl border border-white/5">
                            <div class="text-[10px] text-[#E3E1D8]/50 uppercase mb-1">Monthly Reach</div>
                            <div class="text-2xl font-black text-[#E1FF01] tracking-tight">12.5M+</div>
                            <div class="text-[10px] text-[#E3E1D8]/60 mt-1">Active High-Intent Viewers</div>
                        </div>
                        <div class="p-4 bg-[#242424] rounded-2xl border border-white/5">
                            <div class="text-[10px] text-[#E3E1D8]/50 uppercase mb-1">Escrow Success</div>
                            <div class="text-2xl font-black text-[#E3E1D8] tracking-tight">100.0%</div>
                            <div class="text-[10px] text-green-400 mt-1">0 Disputes Unresolved</div>
                        </div>
                    </div>

                    <div class="p-4 bg-[#161616] rounded-2xl border border-white/5 text-xs text-[#E3E1D8]/70 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-[#E1FF01]">[13:42:01]</span>
                            <span>AUTH_SUCCESS: Fashion Model Runway Escrow Cleared</span>
                            <span class="text-green-400">₹35,000 RELEASED</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#E1FF01]">[13:40:19]</span>
                            <span>META_TOKEN_VERIFY: Instagram Reel Creator (8.9% engagement)</span>
                            <span class="text-[#E1FF01]">VERIFIED</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#E1FF01]">[13:38:44]</span>
                            <span>ESCROW_LOCK: Stage Anchor Keynote Host Agreement</span>
                            <span class="text-yellow-400">HELD_IN_ESCROW</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 7. INTERACTIVE CAMPAIGN & ESCROW ESTIMATOR -->
    <!-- ========================================== -->
    <section id="estimator" class="py-24 border-t border-[#E3E1D8]/10 bg-[#161616]">
        <div class="max-w-5xl mx-auto px-6 sm:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-mono uppercase tracking-widest text-[#E1FF01] block mb-2">// CAMPAIGN ESTIMATOR</span>
                <h2 class="text-4xl sm:text-5xl font-black tracking-tight font-sans uppercase">
                    Plan Your Campaign.
                </h2>
                <p class="text-sm text-[#E3E1D8]/60 mt-3 font-body">
                    Select your required talent tier and deliverables for an instant reach projection and escrow schedule.
                </p>
            </div>

            <div class="rounded-3xl bg-[#1D1D1D] border border-[#E3E1D8]/15 p-8 sm:p-12 shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Step 1: Select Talent Discipline -->
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-[#E3E1D8]/70 mb-3">1. Select Talent Vertical</label>
                        <div class="grid grid-cols-3 gap-3">
                            <button @click="selectedVertical = 'influencer'; calcReach = '4.2M - 7.5M'; calcFee = '₹45,000'" 
                                    :class="selectedVertical === 'influencer' ? 'bg-[#E1FF01] text-[#161616] font-bold border-[#E1FF01]' : 'bg-[#242424] text-[#E3E1D8] border-white/10'"
                                    class="p-4 rounded-2xl border text-xs font-mono transition-all text-center">
                                IG Reels Creator
                            </button>
                            <button @click="selectedVertical = 'model'; calcReach = '2.8M - 4.5M'; calcFee = '₹35,000'" 
                                    :class="selectedVertical === 'model' ? 'bg-[#E1FF01] text-[#161616] font-bold border-[#E1FF01]' : 'bg-[#242424] text-[#E3E1D8] border-white/10'"
                                    class="p-4 rounded-2xl border text-xs font-mono transition-all text-center">
                                Runway Model
                            </button>
                            <button @click="selectedVertical = 'anchor'; calcReach = '1.2M + Live'; calcFee = '₹25,000'" 
                                    :class="selectedVertical === 'anchor' ? 'bg-[#E1FF01] text-[#161616] font-bold border-[#E1FF01]' : 'bg-[#242424] text-[#E3E1D8] border-white/10'"
                                    class="p-4 rounded-2xl border text-xs font-mono transition-all text-center">
                                Stage Anchor
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Select Scope -->
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-[#E3E1D8]/70 mb-3">2. Campaign Scope</label>
                        <div class="grid grid-cols-3 gap-3">
                            <button @click="selectedScope = 'single'" 
                                    :class="selectedScope === 'single' ? 'bg-[#E1FF01] text-[#161616] font-bold border-[#E1FF01]' : 'bg-[#242424] text-[#E3E1D8] border-white/10'"
                                    class="p-4 rounded-2xl border text-xs font-mono transition-all text-center">
                                1 Hero Post
                            </button>
                            <button @click="selectedScope = 'campaign'" 
                                    :class="selectedScope === 'campaign' ? 'bg-[#E1FF01] text-[#161616] font-bold border-[#E1FF01]' : 'bg-[#242424] text-[#E3E1D8] border-white/10'"
                                    class="p-4 rounded-2xl border text-xs font-mono transition-all text-center">
                                3-Reel Series
                            </button>
                            <button @click="selectedScope = 'omni'" 
                                    :class="selectedScope === 'omni' ? 'bg-[#E1FF01] text-[#161616] font-bold border-[#E1FF01]' : 'bg-[#242424] text-[#E3E1D8] border-white/10'"
                                    class="p-4 rounded-2xl border text-xs font-mono transition-all text-center">
                                Full 360° Collab
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Estimator Output Box -->
                <div class="p-6 bg-[#161616] rounded-2xl border border-white/10 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center space-x-8 text-center sm:text-left">
                        <div>
                            <div class="text-[11px] font-mono text-[#E3E1D8]/50 uppercase">Projected Verified Reach</div>
                            <div class="text-2xl font-black text-[#E1FF01] font-mono" x-text="calcReach">3.4M - 5.8M</div>
                        </div>
                        <div class="w-px h-10 bg-white/10"></div>
                        <div>
                            <div class="text-[11px] font-mono text-[#E3E1D8]/50 uppercase">Estimated Escrow Lock</div>
                            <div class="text-2xl font-black text-white font-mono" x-text="calcFee">₹45,000</div>
                        </div>
                    </div>

                    <a href="{{ route('campaigns.public') }}" class="w-full sm:w-auto px-8 py-4 rounded-full bg-[#E1FF01] text-[#161616] font-extrabold text-xs font-mono uppercase tracking-wider hover:bg-white transition-all shadow-lg text-center">
                        Post Campaign Brief &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 8. KIND WORDS & TESTIMONIALS (Matters.sg Exact Slider) -->
    <!-- ========================================== -->
    <section class="py-24 border-t border-[#E3E1D8]/10 bg-[#161616]">
        <div class="max-w-5xl mx-auto px-6 sm:px-8">
            <div class="flex items-center justify-between mb-12">
                <span class="text-xs font-mono uppercase tracking-widest text-[#E1FF01]">// KIND WORDS &amp; IMPACT</span>
                <div class="flex space-x-3">
                    <button @click="activeTestimonial = (activeTestimonial === 0) ? testimonials.length - 1 : activeTestimonial - 1" 
                            class="w-10 h-10 rounded-full border border-[#E3E1D8]/20 flex items-center justify-center hover:border-[#E1FF01] hover:text-[#E1FF01] transition-colors"
                            aria-label="Previous Testimonial">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                    </button>
                    <button @click="activeTestimonial = (activeTestimonial === testimonials.length - 1) ? 0 : activeTestimonial + 1" 
                            class="w-10 h-10 rounded-full border border-[#E3E1D8]/20 flex items-center justify-center hover:border-[#E1FF01] hover:text-[#E1FF01] transition-colors"
                            aria-label="Next Testimonial">
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Testimonial Carousel -->
            <div class="min-h-[240px] flex flex-col justify-between">
                <blockquote class="text-2xl sm:text-4xl font-serif italic text-[#DEDED1] leading-relaxed tracking-tight"
                            x-text="'“' + testimonials[activeTestimonial].quote + '”'">
                    “HypeMarket has fundamentally changed how we cast talent. Being able to browse authentic Instagram comp cards, verify real-time Meta Graph API retention data, and lock campaign payouts in milestone escrow gives our brand team 100% confidence.”
                </blockquote>

                <div class="mt-8 flex items-center justify-between pt-6 border-t border-white/10">
                    <div>
                        <h4 class="font-bold text-sm font-sans text-white" x-text="testimonials[activeTestimonial].author">Ananya Singhania</h4>
                        <p class="text-xs font-mono text-[#E3E1D8]/60" x-text="testimonials[activeTestimonial].role">Head of Brand & Growth, Nykaa Luxe</p>
                    </div>
                    <div class="text-xs font-mono font-bold tracking-widest text-[#E1FF01]" x-text="testimonials[activeTestimonial].metric">
                        4.8M Verified Impressions
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 9. MASSIVE FOOTER (Matters.sg Exact Editorial Footer) -->
    <!-- ========================================== -->
    <footer id="contact" class="py-24 border-t border-[#E3E1D8]/10 bg-[#161616] relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 mb-20">
                <!-- Left Massive CTA -->
                <div class="lg:col-span-8 space-y-6">
                    <p class="text-xs font-mono uppercase tracking-widest text-[#E1FF01]">// CAST &amp; MONETIZE</p>
                    <h2 class="text-5xl sm:text-7xl lg:text-8xl font-black font-sans uppercase tracking-tighter leading-none text-[#E3E1D8]">
                        Cast verified talent.<br>
                        <span class="font-serif italic font-normal text-[#DEDED1] text-4xl sm:text-6xl lg:text-7xl">No strings attached.</span>
                    </h2>
                    <div class="pt-6 flex flex-wrap gap-4 items-center">
                        <a href="{{ route('register') }}" class="px-8 py-4 rounded-full bg-[#E1FF01] text-[#161616] font-mono font-black text-xs uppercase tracking-wider hover:bg-white transition-all shadow-lg">
                            Join The Hype &rarr;
                        </a>
                        <a href="{{ route('influencers.public') }}" class="px-8 py-4 rounded-full bg-[#242424] border border-white/15 text-[#E3E1D8] font-mono font-bold text-xs uppercase tracking-wider hover:border-[#E1FF01] transition-all">
                            Explore Talent Directory
                        </a>
                    </div>
                    <p class="text-sm font-mono text-[#E3E1D8]/60 pt-2">
                        Get started in 60 seconds. Escrow payouts &amp; Meta Graph API token verification included.
                    </p>
                </div>

                <!-- Right Navigation Links -->
                <div class="lg:col-span-4 flex flex-col justify-between space-y-8 border-t lg:border-t-0 lg:border-l border-[#E3E1D8]/10 lg:pl-12 pt-8 lg:pt-0">
                    <div class="grid grid-cols-2 gap-6 font-mono text-xs">
                        <div class="space-y-3">
                            <h4 class="text-[#E3E1D8]/50 uppercase tracking-widest text-[10px]">Categories</h4>
                            <div class="flex flex-col space-y-2">
                                <a href="{{ route('influencers.public', ['talent_type' => 'influencer']) }}" class="hover:text-[#E1FF01] transition-colors">IG Influencers</a>
                                <a href="{{ route('influencers.public', ['talent_type' => 'modeling']) }}" class="hover:text-[#E1FF01] transition-colors">Fashion Models</a>
                                <a href="{{ route('influencers.public', ['talent_type' => 'anchor']) }}" class="hover:text-[#E1FF01] transition-colors">Event Anchors</a>
                                <a href="{{ route('campaigns.public') }}" class="hover:text-[#E1FF01] transition-colors">Brand Briefs</a>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h4 class="text-[#E3E1D8]/50 uppercase tracking-widest text-[10px]">Platform</h4>
                            <div class="flex flex-col space-y-2">
                                <a href="{{ route('login') }}" class="hover:text-[#E1FF01] transition-colors">Sign In</a>
                                <a href="{{ route('register') }}" class="hover:text-[#E1FF01] transition-colors">Join Free</a>
                                <a href="{{ route('pricing') }}" class="hover:text-[#E1FF01] transition-colors">Escrow Pricing</a>
                                <a href="{{ route('font.pairs') }}" class="hover:text-[#E1FF01] transition-colors">Font Lab</a>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-[#E3E1D8]/10 text-xs font-mono">
                        <a href="mailto:concierge@matters.agency" class="text-xl font-bold text-[#E1FF01] hover:underline">
                            concierge@matters.agency
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Legal & Telemetry -->
            <div class="border-t border-[#E3E1D8]/10 pt-8 flex flex-col md:flex-row items-center justify-between text-xs font-mono text-[#E3E1D8]/50 gap-4">
                <div>
                    &copy; {{ date('Y') }} MATTERS. / HypeMarket Inc. &bull; An Instagram Verified Talent Ecosystem.
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('privacy') }}" class="hover:text-[#E1FF01]">Privacy Policy</a>
                    <a href="{{ route('terms') }}" class="hover:text-[#E1FF01]">Terms of Service</a>
                    <a href="{{ route('data-deletion') }}" class="hover:text-[#E1FF01]">Data Deletion</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- GSAP & Lenis Smooth Scrolling Animations -->
    <script>
        // Initialize Lenis Smooth Scrolling
        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            direction: 'vertical',
            smooth: true
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        // Register ScrollTrigger with GSAP
        gsap.registerPlugin(ScrollTrigger);

        // Header Scroll Hide/Show
        let lastScroll = 0;
        const header = document.getElementById('main-header');
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            if (currentScroll > 100) {
                if (currentScroll > lastScroll && currentScroll > 200) {
                    header.style.transform = 'translateY(-100%)';
                } else {
                    header.style.transform = 'translateY(0)';
                }
            } else {
                header.style.transform = 'translateY(0)';
            }
            lastScroll = currentScroll;
        });

        // GSAP Animations on DOM Load
        document.addEventListener('DOMContentLoaded', () => {
            // Animate hero headline
            gsap.from('.hero-title', {
                opacity: 0,
                y: 60,
                duration: 1.2,
                ease: 'power3.out',
                delay: 0.1
            });

            gsap.from('.hero-title-2', {
                opacity: 0,
                y: 40,
                duration: 1.2,
                ease: 'power3.out',
                delay: 0.3
            });

            // Animate search bar
            gsap.from('#search-console', {
                opacity: 0,
                y: 30,
                duration: 1,
                ease: 'power3.out',
                delay: 0.5
            });

            // Animate work/roster cards on scroll
            gsap.utils.toArray('.work-cover-content').forEach((card, index) => {
                gsap.from(card, {
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 88%'
                    },
                    opacity: 0,
                    y: 50,
                    duration: 0.8,
                    delay: (index % 3) * 0.15,
                    ease: 'power3.out'
                });
            });
        });
    </script>
</body>
</html>
