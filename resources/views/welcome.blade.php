<!DOCTYPE html>
<html lang="en" class="antialiased selection:bg-[#E2F163] selection:text-[#181528]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HypeMarket &mdash; Curated Instagram Talent for Models, Influencers &amp; Anchors</title>
    <meta name="description" content="Curated Instagram talent network. Connect with verified fashion models, Instagram reel creators, event anchors, and emcees with real-time Meta Graph API analytics and milestone escrow security.">

    <!-- Google Fonts: Bricolage Grotesque, Plus Jakarta Sans, Space Grotesk, Caveat, Reenie Beanie -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800;12..96,900&family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Reenie+Beanie&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Raleway:wght@500&display=swap" rel="stylesheet">

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
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    <!-- Lenis Smooth Scroll (Modern v1.1.20) -->
    <link rel="stylesheet" href="https://unpkg.com/lenis@1.1.20/dist/lenis.css">
    <script src="https://unpkg.com/lenis@1.1.20/dist/lenis.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        /* ===== Hero Design Tokens & Utilities (Preserving home page palette) ===== */
        :root {
            --hm-bg: #FAF5EC;
            --hm-ink: #181528;
            --hm-line: #181528;
            --hm-card: #FFFFFF;
            --hm-lime: #E2F163;
            --hm-pink: #FF3E14;
            --hm-pinkpop: #F47FA2;
            --hm-blue: #7EC4FB;
            --hm-lilac: #BDB0FC;
            --hm-muted: #524B66;
        }

        .hm-root { background: transparent; color: var(--hm-ink); }
        .hm-glow { position: absolute; border-radius: 9999px; filter: blur(100px); pointer-events: none; z-index: 0; }

        /* Mockups pop in entrance */
        .mock-pop { animation: mockPop .6s cubic-bezier(.22,1,.36,1) both; }
        @keyframes mockPop { from { opacity: 0; transform: scale(.85) translateY(16px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .d1 { animation-delay: .05s; } .d2 { animation-delay: .15s; } .d3 { animation-delay: .25s; } .d4 { animation-delay: .35s; } .d5 { animation-delay: .45s; }

        /* Neo-brutalist card & button */
        .mock-card {
            background: var(--hm-card);
            color: var(--hm-ink);
            border: 2px solid var(--hm-line);
            border-radius: 1.25rem;
            box-shadow: 5px 5px 0 var(--hm-line);
            transform: rotate(var(--tilt, 0deg));
            transition: transform .3s cubic-bezier(.22,1,.36,1);
        }
        .mock-card:hover { transform: rotate(var(--tilt, 0deg)) translateY(-5px); }

        .hm-btn {
            border: 2px solid var(--hm-line);
            box-shadow: 5px 5px 0 var(--hm-line);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .hm-btn:hover { transform: translate(2px, 2px); box-shadow: 2px 2px 0 var(--hm-line); }
        .hm-btn:active { transform: translate(3px, 3px); box-shadow: 0 0 0 var(--hm-line); }

        .sticker-lime { background: var(--hm-lime); color: var(--hm-line); border: 2px solid var(--hm-line); box-shadow: 4px 4px 0 var(--hm-line); }
        .grad-text2 { background-image: linear-gradient(100deg, #FF3E14, #F47FA2); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .script-accent { font-family: 'Caveat', cursive; color: var(--hm-pink); }
        .mask-line { overflow: hidden; }

        /* Niche marquee */
        @keyframes marqueeX { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .animate-marquee-x { animation: marqueeX 30s linear infinite; }

        /* Lenis recommended smooth scrolling styles */
        html.lenis, html.lenis body {
            height: auto;
        }
        .lenis.lenis-smooth {
            scroll-behavior: auto !important;
        }
        .lenis.lenis-smooth [data-lenis-prevent] {
            overscroll-behavior: contain;
        }
        .lenis.lenis-stopped {
            overflow: hidden;
        }
        .lenis.lenis-smooth iframe {
            pointer-events: none;
        }

        .noise-bg {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.035'/%3E%3C/svg%3E");
        }

        .font-caveat { font-family: 'Caveat', cursive; }
        .font-reenie { font-family: 'Reenie Beanie', cursive; }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Movable & Animated Symbols */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(4deg); }
        }
        @keyframes floatWobble {
            0%, 100% { transform: translateY(0) rotate(-6deg) scale(1); }
            50% { transform: translateY(-10px) rotate(6deg) scale(1.05); }
        }
        @keyframes pulseGlowSymbol {
            0%, 100% { transform: scale(1); filter: drop-shadow(0 0 0 rgba(0,0,0,0)); }
            50% { transform: scale(1.08); filter: drop-shadow(0 8px 16px rgba(226,241,99,0.45)); }
        }
        @keyframes spinSlowSymbol {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .anim-float { animation: floatSlow 4s ease-in-out infinite; }
        .anim-wobble { animation: floatWobble 3.5s ease-in-out infinite; }
        .anim-pulse { animation: pulseGlowSymbol 3s ease-in-out infinite; }
        .anim-spin-slow { animation: spinSlowSymbol 20s linear infinite; }
        
        .movable-symbol {
            cursor: grab;
            user-select: none;
            touch-action: none;
            will-change: transform;
            transition: transform 0.15s ease-out;
        }
        .movable-symbol:active {
            cursor: grabbing;
            transform: scale(1.15) !important;
            z-index: 50 !important;
        }

        @media (prefers-reduced-motion: reduce) {
            .mock-pop, .anim-float, .anim-wobble, .anim-pulse, .anim-spin-slow { animation: none !important; opacity: 1 !important; }
        }
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
    @include('layouts.partials.public-navbar')

    <main class="w-full max-w-full overflow-x-hidden">
        
        <!-- ===================== HERO (home-light3 style) ===================== -->
        <section id="hero" class="hm-root relative isolate overflow-hidden pb-10 pt-32 sm:pt-36 lg:pb-16">
            <!-- two blurred colour glows (pinkpop + blue) -->
            <div aria-hidden="true" class="hm-glow -left-24 top-16 h-[26rem] w-[26rem] bg-[#FF3E14] opacity-25 sm:h-[34rem] sm:w-[34rem]"></div>
            <div aria-hidden="true" class="hm-glow -right-24 top-40 h-[26rem] w-[26rem] bg-[#7EC4FB] opacity-25 sm:h-[34rem] sm:w-[34rem]"></div>

            <div class="relative z-10 mx-auto grid w-full max-w-7xl grid-cols-1 items-center gap-14 px-5 sm:px-8 lg:grid-cols-2 lg:gap-10">
                <!-- ============ LEFT: copy ============ -->
                <div id="heroCopy" class="text-center lg:text-left">
                    <span id="heroBadge" class="inline-flex -rotate-2 items-center gap-2 rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-card)] px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-[var(--hm-ink)] shadow-[3px_3px_0_var(--hm-line)]">
                        <span class="h-2 w-2 rounded-full bg-[#FF3E14]"></span>
                        Creator marketplace &mdash; live now
                    </span>

                    <h1 id="heroTitle" class="mt-6 font-display font-extrabold leading-[0.95] tracking-[-0.035em] text-[var(--hm-ink)]" style="font-size: clamp(2.6rem, 7vw, 5.6rem)">
                        <span class="mask-line block">
                            <span class="heroChars inline-block">Cast the</span>
                            <span class="heroChars grad-text2 inline-block">vibe.</span>
                        </span>
                        <span class="mask-line block">
                            <span class="heroChars inline-block align-middle">
                                <span class="sticker-lime mx-1 inline-block -rotate-6 rounded-xl px-3 py-1 align-middle font-display font-extrabold">Skip</span>
                            </span>
                            <span class="heroChars inline-block align-middle">the</span>
                            <span class="heroChars script-accent inline-block align-middle" style="font-size:1.15em">bots.</span>
                        </span>
                    </h1>

                    <p id="heroSub" class="mx-auto mt-6 max-w-xl text-base font-medium leading-relaxed text-[var(--hm-muted)] lg:mx-0 sm:text-lg">
                        Swipe the roster, watch the reels, pick your vibe. Then lock in escrow-safe payouts with verified Instagram creators. It feels like your feed, not a spreadsheet.
                    </p>

                    <div id="heroCtas" class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row lg:justify-start">
                        <button type="button" data-confetti class="hm-btn inline-flex items-center gap-2 rounded-full bg-[var(--hm-lime)] px-7 py-3.5 text-sm font-extrabold text-[var(--hm-line)]" onclick="location.href='{{ route('register') }}'">
                            Start free <span aria-hidden="true">&#10024;</span>
                        </button>
                        <a href="{{ route('influencers.public') }}" class="hm-btn inline-flex items-center gap-2 rounded-full bg-[var(--hm-card)] px-7 py-3.5 text-sm font-extrabold text-[var(--hm-ink)]">
                            <i class="fa-solid fa-play text-[10px] text-[#FF3E14]"></i> Watch the reels
                        </a>
                    </div>

                    <!-- social proof -->
                    <div id="heroProof" class="mt-9 flex flex-col items-center gap-4 sm:flex-row lg:justify-start">
                        <div class="flex -space-x-3">
                            <span class="h-10 w-10 rounded-full border-2 border-[var(--hm-line)]" style="background-image: linear-gradient(135deg, #FF3E14, #7EC4FB)"></span>
                            <span class="h-10 w-10 rounded-full border-2 border-[var(--hm-line)]" style="background-image: linear-gradient(135deg, #E2F163, #7EC4FB)"></span>
                            <span class="h-10 w-10 rounded-full border-2 border-[var(--hm-line)]" style="background-image: linear-gradient(135deg, #F47FA2, #E2F163)"></span>
                            <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-ink)] text-[10px] font-extrabold text-[var(--hm-lime)]">{{ $stats['talents'] ?? '12K' }}</span>
                        </div>
                        <div class="text-center sm:text-left">
                            <p class="font-display text-sm font-extrabold text-[var(--hm-ink)]">{{ $stats['talents'] ?? '12,800' }}+ verified creators</p>
                            <p class="text-[11px] font-bold uppercase tracking-widest text-[var(--hm-muted)]">98.4% real audiences</p>
                        </div>
                    </div>
                </div>

                <!-- ============ RIGHT: overlapping mockups ============ -->
                <div id="heroStage" class="relative mx-auto w-full max-w-[32rem] lg:max-w-none">
                    <div class="relative grid grid-cols-2 gap-4 sm:gap-5 lg:block lg:aspect-[5/6]">

                        <!-- 1. phone reel -->
                        <div class="mock-pop d1 col-span-2 lg:absolute lg:right-0 lg:top-0 lg:w-[54%]" style="--tilt:3deg">
                            <div class="mock-card p-2.5">
                                <div class="relative aspect-[9/16] overflow-hidden rounded-[1rem]" style="background-image: linear-gradient(150deg, #7EC4FB, #F47FA2)">
                                    <div class="absolute inset-x-0 top-0 flex items-center justify-between p-3">
                                        <span class="inline-flex items-center gap-1 rounded-full border-2 border-[var(--hm-line)] bg-[#FF3E14] px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-white">LIVE</span>
                                        <span class="rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-card)] px-2 py-0.5 text-[9px] font-bold text-[var(--hm-ink)]">@ananya.model</span>
                                    </div>
                                    <div class="absolute bottom-24 right-3 flex flex-col items-center gap-4 text-white">
                                        <span class="flex flex-col items-center gap-0.5"><i class="fa-solid fa-heart text-xl text-[#FF3E14]"></i><span class="text-[10px] font-bold">84K</span></span>
                                        <span class="flex flex-col items-center gap-0.5"><i class="fa-solid fa-comment text-lg"></i><span class="text-[10px] font-bold">2.1K</span></span>
                                        <span class="flex flex-col items-center gap-0.5"><i class="fa-solid fa-paper-plane text-lg"></i><span class="text-[10px] font-bold">Share</span></span>
                                    </div>
                                    <div class="absolute inset-x-0 bottom-0 bg-[linear-gradient(to_top,var(--hm-ink),transparent)] p-3">
                                        <p class="font-display text-sm font-extrabold leading-tight text-white">Runway to reels in 48h &mdash; <span class="text-[var(--hm-lime)]">6.4% engagement</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. swipe card -->
                        <div class="mock-pop d2 col-span-1 lg:absolute lg:left-0 lg:top-[5%] lg:w-[52%]" style="--tilt:-6deg">
                            <div class="mock-card p-2.5">
                                <div class="relative aspect-[4/5] overflow-hidden rounded-xl" style="background-image: linear-gradient(160deg, #E2F163, #7EC4FB)">
                                    <span class="absolute right-2 top-2 rotate-6 rounded-lg border-2 border-[var(--hm-line)] bg-[var(--hm-card)] px-2 py-0.5 font-display text-xs font-extrabold text-[var(--hm-line)]">MATCH</span>
                                </div>
                                <div class="mt-2">
                                    <p class="font-display text-sm font-extrabold text-[var(--hm-ink)]">Zoya Khan</p>
                                    <p class="text-[11px] font-semibold text-[var(--hm-muted)]">Delhi &bull; Dance &bull; 480K</p>
                                </div>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-card)]"><i class="fa-solid fa-xmark text-[11px] text-[var(--hm-ink)]"></i></span>
                                    <span class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-card)]"><i class="fa-solid fa-star text-[11px] text-[#7EC4FB]"></i></span>
                                    <span class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-[var(--hm-line)] bg-[#FF3E14]"><i class="fa-solid fa-heart text-[11px] text-white"></i></span>
                                </div>
                            </div>
                        </div>

                        <!-- 3. payout (solar lime) -->
                        <div class="mock-pop d3 col-span-1 lg:absolute lg:bottom-[20%] lg:left-[1%] lg:w-[48%]" style="--tilt:4deg">
                            <div class="mock-card bg-[var(--hm-lime)] p-3">
                                <p class="font-display text-[11px] font-extrabold uppercase tracking-wider text-[var(--hm-line)]">Payout released</p>
                                <p class="font-display text-xl font-extrabold text-[var(--hm-line)]">&#8377;48,000</p>
                                <span class="mt-1.5 inline-flex items-center gap-1 rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-card)] px-2 py-0.5 text-[10px] font-bold text-[var(--hm-line)]">Escrow <i class="fa-solid fa-check text-[8px]"></i> campaign done</span>
                            </div>
                        </div>

                        <!-- 4. audience ring -->
                        <div class="mock-pop d4 col-span-2 lg:absolute lg:bottom-[20%] lg:left-[35%] lg:w-[34%]" style="--tilt:-8deg">
                            <div class="mock-card flex flex-col items-center p-3 text-center">
                                <div class="relative h-14 w-14">
                                    <svg viewBox="0 0 36 36" class="h-full w-full -rotate-90">
                                        <circle cx="18" cy="18" r="15.5" fill="none" stroke="var(--hm-line)" stroke-opacity="0.15" stroke-width="4"></circle>
                                        <circle cx="18" cy="18" r="15.5" fill="none" stroke="#FF3E14" stroke-width="4" stroke-linecap="round" stroke-dasharray="97.4" stroke-dashoffset="5.8"></circle>
                                    </svg>
                                    <span class="absolute inset-0 flex items-center justify-center font-display text-sm font-extrabold text-[var(--hm-ink)]">94%</span>
                                </div>
                                <p class="script-accent mt-1 text-base leading-tight">every follower is a real human</p>
                            </div>
                        </div>

                        <!-- 5. DM chat -->
                        <div class="mock-pop d5 col-span-2 lg:absolute lg:bottom-0 lg:right-0 lg:w-[74%]" style="--tilt:-3deg">
                            <div class="mock-card p-3">
                                <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-[var(--hm-muted)]">@glowup.brand</p>
                                <p class="max-w-[88%] rounded-2xl rounded-bl-sm border-2 border-[var(--hm-line)] bg-[var(--hm-bg)] px-3 py-2 text-[12px] font-medium text-[var(--hm-ink)]">Yo, we love your vibe &#128293; Down for a 3-reel collab?</p>
                                <p class="ml-auto mt-2 max-w-[88%] rounded-2xl rounded-br-sm border-2 border-[var(--hm-line)] bg-[var(--hm-lime)] px-3 py-2 text-[12px] font-bold text-[var(--hm-line)]">Say less. Send the brief &#128588;</p>
                                <p class="mt-2 text-right text-[10px] font-bold text-[#FF3E14]"><i class="fa-solid fa-check-double"></i> Deal locked in escrow</p>
                            </div>
                        </div>

                        <!-- floating emoji stickers -->
                        <span aria-hidden="true" class="absolute -left-3 top-[42%] z-20 hidden text-3xl lg:block" style="transform: rotate(-12deg)">&#128293;</span>
                        <span aria-hidden="true" class="absolute bottom-[34%] left-[46%] z-20 hidden text-2xl lg:block" style="transform: rotate(10deg)">&#10024;</span>
                    </div>
                </div>
            </div>

            <!-- niche marquee -->
            <div class="relative z-10 mt-14 flex overflow-hidden border-y-2 border-[var(--hm-line)] bg-[var(--hm-card)] py-4" aria-hidden="true">
                @php $niches = ['Fashion', 'Beauty', 'Gaming', 'Travel', 'Food', 'Fitness', 'Music', 'Comedy', 'Tech', 'Lifestyle']; @endphp
                <div class="flex w-max animate-marquee-x items-center">
                    <div class="flex items-center gap-8 pr-8">
                        @foreach ($niches as $niche)
                        <span class="flex items-center gap-8 font-display text-lg font-extrabold uppercase tracking-tight text-[var(--hm-ink)]">{{ $niche }}<i class="fa-solid fa-bolt text-[11px] text-[#FF3E14]"></i></span>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-8 pr-8">
                        @foreach ($niches as $niche)
                        <span class="flex items-center gap-8 font-display text-lg font-extrabold uppercase tracking-tight text-[var(--hm-ink)]">{{ $niche }}<i class="fa-solid fa-bolt text-[11px] text-[#FF3E14]"></i></span>
                        @endforeach
                    </div>
                </div>
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

        <!-- ===================== HYPEFLUENCY MOODBOARD BENTO GRID (WITH VIDEOS & MOVABLE SYMBOLS) ===================== -->
        <section class="py-6 sm:py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto overflow-hidden">
            
            <!-- Bento Layout Wrapper (compact height fitting standard screens, clean borderless) -->
            <div class="relative">
                
                <!-- Main Mosaic Grid (Scaled down row heights to 80px - 108px) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 lg:grid-cols-12 gap-2 sm:gap-3 auto-rows-[78px] sm:auto-rows-[88px] md:auto-rows-[96px] lg:auto-rows-[106px]">

                    <!-- 1. TOP LEFT: Wide Video Card with 'TDinfluence' Cursive Signature (Col-span 4, Row-span 2) -->
                    <div class="sm:col-span-2 md:col-span-3 lg:col-span-4 row-span-2 relative rounded-[1.15rem] sm:rounded-[1.35rem] overflow-hidden border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] group">
                        <video class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" autoplay muted loop playsinline preload="metadata">
                            <source src="{{ asset('videos/1st.mp4') }}" type="video/mp4">
                        </video>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent pointer-events-none"></div>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none p-3">
                            <span class="font-script font-bold text-2xl sm:text-3xl md:text-4xl text-[#E2F163] drop-shadow-[0_3px_8px_rgba(0,0,0,0.85)] tracking-wide transform -rotate-3 select-none">
                                TDinfluence
                            </span>
                        </div>
                    </div>

                    <!-- 2. TOP MIDDLE-LEFT: Rising Star Pink Card with Movable Neon Star (Col-span 2, Row-span 2) -->
                    <div class="sm:col-span-2 md:col-span-3 lg:col-span-2 row-span-2 relative rounded-[1.25rem] sm:rounded-[1.5rem] bg-[#F47FA2] border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] p-3 flex items-center justify-center overflow-hidden">
                        <!-- Movable & Animated Rising Star Sticker -->
                        <div class="movable-symbol anim-wobble cursor-grab active:cursor-grabbing transform hover:scale-110 transition-transform" title="Drag me!">
                            <svg class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 drop-shadow-[2px_2px_0px_#181528]" viewBox="0 0 200 200" fill="none">
                                <!-- Outer White/Cream 4-point star -->
                                <path d="M100 5 C110 65 135 90 195 100 C135 110 110 135 100 195 C90 135 65 110 5 100 C65 90 90 65 100 5 Z" fill="#FFFBE6" stroke="#181528" stroke-width="7" stroke-linejoin="round"/>
                                <!-- Inner Yellow star core -->
                                <path d="M100 25 C108 68 132 78 175 100 C132 122 108 132 100 175 C92 132 68 122 25 100 C68 78 92 68 100 25 Z" fill="#E2F163"/>

                                <!-- RISING label: dark rectangle, perfectly centered -->
                                <rect x="62" y="76" width="76" height="22" rx="4" fill="#181528"/>
                                <text x="100" y="92" text-anchor="middle" dominant-baseline="middle" font-family="Arial, sans-serif" font-weight="900" font-size="13" fill="#E2F163" letter-spacing="2">RISING</text>

                                <!-- STAR text centered below -->
                                <text x="100" y="120" text-anchor="middle" dominant-baseline="middle" font-family="Arial, sans-serif" font-weight="900" font-size="20" fill="#181528" letter-spacing="3">STAR</text>
                            </svg>
                        </div>
                    </div>

                    <!-- 3. TOP CENTER: Vertical Tall Video Card - Model in Jacket (Col-span 2, Row-span 3) -->
                    <div class="sm:col-span-2 md:col-span-3 lg:col-span-2 row-span-3 relative rounded-[1.25rem] sm:rounded-[1.5rem] overflow-hidden border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] group">
                        <video class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" autoplay muted loop playsinline preload="metadata">
                            <source src="{{ asset('videos/2nd.mp4') }}" type="video/mp4">
                        </video>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
                        <span class="absolute top-2.5 left-2.5 bg-[#181528] text-[#E2F163] border border-[#181528] text-[9px] font-mono font-black uppercase px-2 py-0.5 rounded-full shadow-xs">
                            Casting
                        </span>
                    </div>

                    <!-- 4. TOP RIGHT-CENTER: Big Pink 'Join the Hype' + Giant Arrow Card (Col-span 3, Row-span 3) -->
                    <div class="sm:col-span-2 md:col-span-3 lg:col-span-3 row-span-3 relative rounded-[1.25rem] sm:rounded-[1.5rem] bg-[#F47FA2] border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] p-4 sm:p-5 flex flex-col justify-between group overflow-hidden">
                        <div>
                            <h3 class="font-display font-black text-3xl sm:text-4xl lg:text-[2.85rem] text-[#8F1449] leading-[0.92] tracking-tight">
                                Join the<br>Hype
                            </h3>
                        </div>
                        <a href="{{ route('register') }}" class="mt-auto self-start group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform duration-300">
                            <!-- Direct bold diagonal arrow matching reference image -->
                            <svg class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 text-[#8F1449]" viewBox="0 0 48 48" fill="currentColor">
                                <path d="M14 38 L30 22 L30 34 C30 35.1 30.9 36 32 36 C33.1 36 34 35.1 34 34 L34 16 C34 14.9 33.1 14 32 14 L14 14 C12.9 14 12 14.9 12 16 C12 17.1 12.9 18 14 18 L26 18 L10 34 C9.2 34.8 9.2 36.1 10 36.9 C10.8 37.7 12.1 37.7 12.9 36.9 Z"/>
                            </svg>
                        </a>
                    </div>

                    <!-- 5. TOP FAR-RIGHT: Mini Video Card - Accessories / Creator Gear (Col-span 1, Row-span 2) -->
                    <div class="sm:col-span-2 md:col-span-3 lg:col-span-1 row-span-2 relative rounded-[1.25rem] sm:rounded-[1.5rem] overflow-hidden border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] group">
                        <video class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" autoplay muted loop playsinline preload="metadata">
                            <source src="{{ asset('videos/3rd.mp4') }}" type="video/mp4">
                        </video>
                        <div class="absolute inset-0 bg-black/10 pointer-events-none"></div>
                        <!-- Mini pin badge -->
                        <div class="absolute top-2 right-2 w-4 h-4 rounded-full bg-[#E2F163] border border-[#181528] flex items-center justify-center text-[8px] font-bold text-[#181528]">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    </div>

                    <!-- 6. ROW 2 LEFT: Sky Blue Card with Movable Diamond Sparkle Star (Col-span 2, Row-span 1) -->
                    <div class="sm:col-span-1 md:col-span-2 lg:col-span-2 row-span-1 relative rounded-[1.25rem] sm:rounded-[1.5rem] bg-[#7EC4FB] border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] flex items-center justify-center p-2 overflow-hidden">
                        <!-- Movable 4-point Diamond Star Icon -->
                        <div class="movable-symbol anim-float text-[#181528] cursor-grab active:cursor-grabbing hover:scale-125 transition-transform" title="Drag me!">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20 drop-shadow-[2px_2px_0px_#181528]" viewBox="0 0 100 100" fill="#181528">
                                <path d="M50 0 C50 35 65 50 100 50 C65 50 50 65 50 100 C50 65 35 50 0 50 C35 50 50 35 50 0 Z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- 7. ROW 2 MIDDLE-LEFT: Lilac 'Be a Talent' Card (Col-span 2, Row-span 1) -->
                    <div class="sm:col-span-1 md:col-span-2 lg:col-span-2 row-span-1 relative rounded-[1.25rem] sm:rounded-[1.5rem] bg-[#BDB0FC] border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] p-3 sm:p-4 flex flex-col justify-center">
                        <a href="{{ route('register') }}" class="group block">
                            <span class="font-display font-black text-2xl sm:text-3xl lg:text-[2.1rem] text-[#181528] leading-[0.92] tracking-tight block group-hover:text-[#FF3E14] transition-colors">
                                Be a<br>Talent
                            </span>
                        </a>
                    </div>

                    <!-- 8. ROW 2 CENTER: Dark Purple Card with Movable Animated Hashtag Symbol (Col-span 2, Row-span 1) -->
                    <div class="sm:col-span-2 md:col-span-2 lg:col-span-2 row-span-1 relative rounded-[1.25rem] sm:rounded-[1.5rem] bg-[#181528] border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] p-2 flex items-center justify-center overflow-hidden">
                        <!-- Movable Stylized Speed Hashtag Symbol -->
                        <div class="movable-symbol anim-pulse flex items-center justify-center cursor-grab active:cursor-grabbing hover:scale-110" title="Drag me!">
                            <div class="relative flex items-center">
                                <span class="font-display font-black italic text-5xl sm:text-6xl text-[#BDB0FC] tracking-tighter">
                                    #
                                </span>
                                <div class="w-8 sm:w-12 h-1.5 bg-[#BDB0FC] rounded-full ml-1.5 relative">
                                    <span class="absolute -top-4 right-0 text-base text-[#E2F163]">✦</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 9. ROW 2 FAR RIGHT: Follow Sticker Card (Col-span 1, Row-span 1) -->
                    <div class="sm:col-span-2 md:col-span-3 lg:col-span-1 row-span-1 relative rounded-[1.25rem] sm:rounded-[1.5rem] bg-[#181528] border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] p-2 flex items-center justify-center overflow-hidden">
                        <div class="movable-symbol anim-wobble transform -rotate-12 px-2.5 py-0.5 bg-white border-2 border-[#7EC4FB] rounded-lg shadow-sm cursor-grab active:cursor-grabbing">
                            <span class="font-sans font-black text-[10px] text-[#0E4875] tracking-wide uppercase">
                                Follow
                            </span>
                        </div>
                    </div>

                    <!-- 10. BOTTOM LEFT: Square Video Card - Creator in pink striped shirt (Col-span 2, Row-span 2) -->
                    <div class="sm:col-span-1 md:col-span-2 lg:col-span-2 row-span-2 relative rounded-[1.25rem] sm:rounded-[1.5rem] overflow-hidden border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] group">
                        <video class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" autoplay muted loop playsinline preload="metadata">
                            <source src="{{ asset('videos/4th.mp4') }}" type="video/mp4">
                        </video>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
                    </div>

                    <!-- 11. BOTTOM MIDDLE: Deep Magenta Typography Card 'AaBbCc' (Col-span 4, Row-span 2) -->
                    <div class="sm:col-span-2 md:col-span-4 lg:col-span-4 row-span-2 relative rounded-[1.25rem] sm:rounded-[1.5rem] bg-[#8F1449] border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] p-4 sm:p-5 flex flex-col justify-between overflow-hidden">
                        <div class="flex items-center justify-between text-[9px] font-mono text-white/80 uppercase tracking-widest">
                            <span class="px-2 py-0.5 rounded-full border border-white/20 bg-white/10">Polymath</span>
                            <span class="px-2 py-0.5 rounded-full border border-white/20 bg-white/10">Typography</span>
                        </div>
                        <div class="mt-auto">
                            <span class="font-display font-black text-3xl sm:text-4xl lg:text-5xl text-[#FFF2F6] tracking-tight block">
                                AaBbCc
                            </span>
                        </div>
                    </div>

                    <!-- 12. BOTTOM CENTER-RIGHT: Solar Acid Yellow Card with Movable Animated '@' Symbol (Col-span 2, Row-span 2) -->
                    <div class="sm:col-span-1 md:col-span-2 lg:col-span-2 row-span-2 relative rounded-[1.25rem] sm:rounded-[1.5rem] bg-[#E2F163] border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] p-3 flex items-center justify-center overflow-hidden">
                        <!-- Movable & Animated @ Symbol -->
                        <div class="movable-symbol anim-float text-[#8F1449] cursor-grab active:cursor-grabbing hover:scale-125 transition-transform" title="Drag me!">
                            <span class="font-display font-black text-7xl sm:text-8xl lg:text-9xl select-none leading-none opacity-85">
                                @
                            </span>
                        </div>
                    </div>

                    <!-- 13. BOTTOM RIGHT: Wide Video Card - 'Run By Talent' with Cap & Star (Col-span 4, Row-span 2) -->
                    <div class="sm:col-span-2 md:col-span-4 lg:col-span-4 row-span-2 relative rounded-[1.25rem] sm:rounded-[1.5rem] overflow-hidden border-2 border-[#181528] shadow-[2px_2px_0px_rgba(24,21,40,0.25)] group">
                        <video class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" autoplay muted loop playsinline preload="metadata" poster="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&fit=crop">
                            <source src="https://cdn.coverr.co/videos/coverr-friends-raising-a-toast-7037/720p.mp4" type="video/mp4">
                        </video>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none"></div>
                        
                        <!-- Floating Movable Sparkle Star in top corner -->
                        <div class="movable-symbol anim-wobble absolute top-2.5 right-3 text-[#FFF9AA] cursor-grab active:cursor-grabbing hover:scale-125 transition-transform" title="Drag me!">
                            <svg class="w-12 h-12 sm:w-14 sm:h-14 drop-shadow-[0_2px_6px_rgba(0,0,0,0.8)]" viewBox="0 0 100 100" fill="#E2F163">
                                <path d="M50 0 C50 35 65 50 100 50 C65 50 50 65 50 100 C50 65 35 50 0 50 C35 50 50 35 50 0 Z"/>
                            </svg>
                        </div>

                        <!-- 'Run By Talent' Caption -->
                        <div class="absolute bottom-3 left-3 sm:left-4 pointer-events-none">
                            <span class="font-display font-black text-lg sm:text-xl text-white leading-tight block drop-shadow-md">
                                Run<br>By Talent
                            </span>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- ===================== CINEMATIC PARALLAX VIDEO SHOWCASE ===================== -->
        <section id="showcase-video-section" class="relative w-full overflow-hidden bg-[#181528] border-b-2 border-[#181528]" style="height: 120vh; min-height: 850px; max-height: 1400px;">
            <!-- Parallax Video Wrapper -->
            <div id="parallax-video-wrapper" class="absolute inset-x-0 w-full overflow-hidden pointer-events-none" style="height: 160%; top: -30%; will-change: transform;">
                <video id="parallax-showcase-video"
                       src="{{ asset('videos/midsection1.mp4') }}"
                       autoplay
                       muted
                       loop
                       playsinline
                       preload="auto"
                       class="w-full h-full object-cover scale-110"
                       style="will-change: transform;">
                </video>
            </div>

            <!-- Soft Overlay Vignette -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#181528]/80 via-transparent to-[#181528]/60 pointer-events-none"></div>

            <!-- Corner Badges / Floating Accents for Brand Consistency -->
            <div class="absolute top-6 left-6 sm:top-10 sm:left-10 z-10 flex items-center gap-2 px-4 py-2 rounded-full bg-[#E2F163] text-[#181528] border-2 border-[#181528] text-xs font-mono font-black uppercase shadow-[3px_3px_0px_#181528] backdrop-blur-sm">
                <span class="w-2.5 h-2.5 rounded-full bg-[#FF3E14] animate-pulse"></span>
                <span>Exclusive Reel Showcase</span>
            </div>

            <div class="absolute bottom-6 right-6 sm:bottom-10 sm:right-10 z-10 hidden sm:flex items-center gap-3 px-5 py-2.5 rounded-full bg-white/90 backdrop-blur border-2 border-[#181528] text-[#181528] text-xs font-display font-black shadow-[4px_4px_0px_#181528]">
                <i class="fa-solid fa-film text-[#FF3E14]"></i>
                <span>Direct Direction &amp; Cinematic Production</span>
            </div>
        </section>

        <script>
            // Ultra-Smooth High-Velocity Parallax Scroll Effect
            (function () {
                const section = document.getElementById('showcase-video-section');
                const videoWrapper = document.getElementById('parallax-video-wrapper');
                if (!section || !videoWrapper) return;

                function renderParallax() {
                    const rect = section.getBoundingClientRect();
                    const windowH = window.innerHeight;

                    // Execute when section intersects viewport
                    if (rect.bottom > -100 && rect.top < windowH + 100) {
                        const totalDistance = windowH + rect.height;
                        const currentPosition = windowH - rect.top;
                        // Progress from -0.5 (top entering) to +0.5 (bottom leaving)
                        const progress = (currentPosition / totalDistance) - 0.5;

                        // Powerful, unmistakable travel offset (+/- 220px = 440px total glide)
                        const translateY = progress * 420;
                        videoWrapper.style.transform = `translate3d(0, ${translateY.toFixed(2)}px, 0)`;
                    }
                }

                // Listen to window scroll + Lenis scroll events
                window.addEventListener('scroll', renderParallax, { passive: true });
                window.addEventListener('resize', renderParallax);

                if (window.lenis) {
                    window.lenis.on('scroll', renderParallax);
                } else {
                    document.addEventListener('DOMContentLoaded', () => {
                        if (window.lenis) window.lenis.on('scroll', renderParallax);
                    });
                }

                // Initial render
                renderParallax();
                setTimeout(renderParallax, 150);
            })();
        </script>

        <!-- ===================== TRENDING CREATORS — SWIPE CARD RAIL ===================== -->
        <section id="trending-creators" class="py-20 sm:py-28 px-0 bg-[#FAF5EC] overflow-hidden border-y-2 border-[#181528]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Header -->
                <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-10">
                    <div>
                        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-[#F47FA2] text-[#181528] border-2 border-[#181528] text-[11px] font-mono font-bold uppercase mb-4 shadow-[3px_3px_0px_#181528]">
                            <i class="fa-brands fa-instagram text-[#8F1449]"></i>
                            <span>Trending Creators</span>
                        </div>
                        <h2 class="font-display font-black text-3xl sm:text-5xl text-[#181528] tracking-tight leading-tight">
                            Meet Verified <span class="text-[#FF3E14]">Models, Creators</span><br class="hidden sm:block"> <span class="text-[#FF3E14]">&amp; Anchors.</span>
                        </h2>
                    </div>
                    <a href="{{ route('influencers.public') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#181528] hover:bg-[#FF3E14] text-[#E2F163] hover:text-white text-xs font-black font-display uppercase tracking-wider transition-all duration-200 shadow-[4px_4px_0px_#E2F163] hover:shadow-[4px_4px_0px_#181528]">
                        <span>View All Talent</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Swipe Rail — centered with smooth scrolling and drag -->
            <div id="creator-rail" class="flex gap-6 overflow-x-auto pb-8 pt-6 px-6 sm:px-12 no-scrollbar mx-auto justify-start md:justify-center"
                 style="scroll-snap-type: x proximity; scroll-padding-inline: 24px; cursor: grab;">

                @forelse($topTalents ?? [] as $talent)
                    @php
                        $topSocial     = $talent->socialAccounts->sortByDesc('followers')->first();
                        $totFollowers  = $talent->socialAccounts->sum('followers');
                        $startingRate  = $talent->rates->min('rate_amount');
                        $avatar        = $talent->profile_image ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=500&h=700&fit=crop';
                        $accentColors  = ['#F47FA2','#7EC4FB','#BDB0FC','#E2F163','#FF3E14'];
                        $accent        = $accentColors[$loop->index % count($accentColors)];
                        $tilts         = ['-2deg','-1deg','0deg','1.5deg','2deg','-1.5deg'];
                        $tilt          = $tilts[$loop->index % count($tilts)];
                    @endphp
                    <div class="creator-swipe-card flex-shrink-0 relative"
                         style="width:260px; scroll-snap-align:start; transform:rotate({{ $tilt }}); transition:transform .3s cubic-bezier(.3,1.6,.5,1);"
                         onmouseenter="this.style.transform='rotate(0deg) scale(1.05) translateY(-8px)'"
                         onmouseleave="this.style.transform='rotate({{ $tilt }}) scale(1) translateY(0)'">
                        <div class="relative w-full rounded-[28px] overflow-hidden border-2 border-[#181528] shadow-[8px_8px_0px_{{ $accent }}]"
                             style="height:400px;">
                            <!-- Photo -->
                            <img src="{{ $avatar }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $talent->display_name ?: $talent->user->name }}">
                            <!-- Gradient scrim -->
                            <div class="absolute inset-0 bg-gradient-to-t from-[#181528]/80 via-[#181528]/10 to-transparent pointer-events-none"></div>
                            <!-- Verified badge -->
                            <div class="absolute top-3 left-3 flex items-center gap-1 bg-[#E2F163] border border-[#181528] px-2.5 py-1 rounded-full text-[10px] font-mono font-black text-[#181528] shadow-[2px_2px_0px_#181528]">
                                <i class="fa-brands fa-instagram text-[#E1306C]"></i>
                                <span>L{{ $talent->verification_level ?? 5 }} Verified</span>
                            </div>
                            <!-- Body -->
                            <div class="absolute bottom-0 left-0 right-0 p-4 z-10">
                                <h3 class="font-display font-black text-xl text-white leading-tight mb-1">{{ $talent->display_name ?: $talent->user->name }}</h3>
                                <p class="text-[11px] text-white/70 font-sans mb-3 line-clamp-1">{{ is_array($talent->primary_categories) ? implode(' · ', array_slice($talent->primary_categories,0,2)) : ($talent->primary_categories ?: 'Fashion & Lifestyle') }}</p>
                                <div class="flex items-center justify-between">
                                    <div class="text-left">
                                        <span class="block text-[9px] text-white/50 uppercase font-bold">Followers</span>
                                        <span class="text-sm font-extrabold text-white font-display">{{ $totFollowers ? number_format($totFollowers) : '185K+' }}</span>
                                    </div>
                                    <div class="text-left">
                                        <span class="block text-[9px] text-white/50 uppercase font-bold">From</span>
                                        <span class="text-sm font-extrabold font-display" style="color:{{ $accent }}">{{ $startingRate ? '₹'.number_format($startingRate) : '₹15K' }}</span>
                                    </div>
                                    <a href="{{ route('influencers.public.show', $talent->username ?: $talent->id) }}"
                                       class="w-10 h-10 rounded-full flex items-center justify-center text-[#181528] font-black text-sm border-2 border-[#181528] shadow-[2px_2px_0px_#181528] hover:scale-110 transition-transform"
                                       style="background:{{ $accent }}">
                                        <i class="fa-solid fa-arrow-up-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Mock fallback cards --}}
                    @php
                        $mockCreators = [
                            ['name'=>'Arya Varma',    'role'=>'Fashion Runway Model & IG Reels',   'reach'=>'185K', 'rate'=>'₹15,000', 'accent'=>'#F47FA2', 'tilt'=>'-2deg',  'img'=>'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=500&h=700&fit=crop'],
                            ['name'=>'Rohan Sen',     'role'=>'Tech Reviewer & Event Host',          'reach'=>'320K', 'rate'=>'₹22,000', 'accent'=>'#7EC4FB', 'tilt'=>'-1deg',  'img'=>'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500&h=700&fit=crop'],
                            ['name'=>'Zara Merchant', 'role'=>'Streetwear & Lifestyle Anchor',       'reach'=>'490K', 'rate'=>'₹35,000', 'accent'=>'#E2F163', 'tilt'=>'1.5deg', 'img'=>'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=500&h=700&fit=crop'],
                            ['name'=>'Priya Nair',    'role'=>'Beauty & Skincare Content Creator',  'reach'=>'210K', 'rate'=>'₹18,000', 'accent'=>'#BDB0FC', 'tilt'=>'2deg',   'img'=>'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=500&h=700&fit=crop'],
                            ['name'=>'Kabir Khanna',  'role'=>'Fitness & Brand Ambassador',          'reach'=>'670K', 'rate'=>'₹45,000', 'accent'=>'#FF3E14', 'tilt'=>'-1.5deg','img'=>'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=500&h=700&fit=crop'],
                            ['name'=>'Ananya Bose',   'role'=>'Dance Reels & Gen-Z Micro Influencer','reach'=>'95K',  'rate'=>'₹8,000',  'accent'=>'#F47FA2', 'tilt'=>'1deg',   'img'=>'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=500&h=700&fit=crop'],
                        ];
                    @endphp
                    @foreach($mockCreators as $creator)
                        <div class="creator-swipe-card flex-shrink-0 relative"
                             style="width:260px; scroll-snap-align:start; transform:rotate({{ $creator['tilt'] }}); transition:transform .3s cubic-bezier(.3,1.6,.5,1);"
                             onmouseenter="this.style.transform='rotate(0deg) scale(1.05) translateY(-8px)'"
                             onmouseleave="this.style.transform='rotate({{ $creator['tilt'] }}) scale(1) translateY(0)'">
                            <div class="relative w-full rounded-[28px] overflow-hidden border-2 border-[#181528]"
                                 style="height:400px; box-shadow:8px 8px 0 {{ $creator['accent'] }};">
                                <img src="{{ $creator['img'] }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $creator['name'] }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#181528]/80 via-[#181528]/10 to-transparent pointer-events-none"></div>
                                <!-- Verified badge -->
                                <div class="absolute top-3 left-3 flex items-center gap-1 bg-[#E2F163] border border-[#181528] px-2.5 py-1 rounded-full text-[10px] font-mono font-black text-[#181528] shadow-[2px_2px_0px_#181528]">
                                    <i class="fa-brands fa-instagram text-[#E1306C]"></i>
                                    <span>L5 Verified</span>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-4 z-10">
                                    <h3 class="font-display font-black text-xl text-white leading-tight mb-1">{{ $creator['name'] }}</h3>
                                    <p class="text-[11px] text-white/70 font-sans mb-3">{{ $creator['role'] }}</p>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="block text-[9px] text-white/50 uppercase font-bold">Followers</span>
                                            <span class="text-sm font-extrabold text-white font-display">{{ $creator['reach'] }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-[9px] text-white/50 uppercase font-bold">From</span>
                                            <span class="text-sm font-extrabold font-display" style="color:{{ $creator['accent'] }}">{{ $creator['rate'] }}</span>
                                        </div>
                                        <a href="{{ route('influencers.public') }}"
                                           class="w-10 h-10 rounded-full flex items-center justify-center text-[#181528] font-black text-sm border-2 border-[#181528] hover:scale-110 transition-transform"
                                           style="background:{{ $creator['accent'] }}; box-shadow:2px 2px 0 #181528;">
                                            <i class="fa-solid fa-arrow-up-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforelse

            </div>

            <!-- Navigation controls & Scroll hint -->
            <div class="flex items-center justify-center gap-4 mt-8 select-none">
                <button type="button" onclick="document.getElementById('creator-rail').scrollBy({ left: -320, behavior: 'smooth' })"
                        class="w-10 h-10 rounded-full bg-white hover:bg-[#E2F163] text-[#181528] border-2 border-[#181528] flex items-center justify-center shadow-[3px_3px_0px_#181528] hover:shadow-[1px_1px_0px_#181528] transition-all"
                        aria-label="Scroll left">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/70 border border-[#181528]/20 text-[#181528]/60 text-xs font-mono font-bold">
                    <span>Swipe or click to explore</span>
                </div>
                <button type="button" onclick="document.getElementById('creator-rail').scrollBy({ left: 320, behavior: 'smooth' })"
                        class="w-10 h-10 rounded-full bg-white hover:bg-[#E2F163] text-[#181528] border-2 border-[#181528] flex items-center justify-center shadow-[3px_3px_0px_#181528] hover:shadow-[1px_1px_0px_#181528] transition-all"
                        aria-label="Scroll right">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </section>

        <style>
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>

        <script>
            // Drag-to-scroll for the creator rail
            (function () {
                const rail = document.getElementById('creator-rail');
                if (!rail) return;
                let isDown = false, startX, scrollLeft;
                rail.addEventListener('mousedown', e => {
                    isDown = true;
                    rail.style.cursor = 'grabbing';
                    startX = e.pageX - rail.offsetLeft;
                    scrollLeft = rail.scrollLeft;
                });
                rail.addEventListener('mouseleave', () => { isDown = false; rail.style.cursor = 'grab'; });
                rail.addEventListener('mouseup',    () => { isDown = false; rail.style.cursor = 'grab'; });
                rail.addEventListener('mousemove',  e => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - rail.offsetLeft;
                    rail.scrollLeft = scrollLeft - (x - startX) * 1.4;
                });
            })();
        </script>

        <!-- ===================== THE SALTIEST INFLUENCER ===================== -->
        <style>
            #saltiest-influencer{
                --bg:#7EC4FB;
                --ink:#0F254B;
                --title-color:#0F254B;
                --text-color:#102A54;
                position:relative;
                width:100%;
                height:100vh;
                min-height:560px;
                overflow:hidden;
                background-color: var(--bg);
                background-image: 
                    radial-gradient(circle 380px at 18% 22%, rgba(255, 255, 255, 0.42) 0%, rgba(255, 255, 255, 0) 70%),
                    radial-gradient(circle 440px at 82% 16%, rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0) 65%),
                    radial-gradient(circle 350px at 45% 78%, rgba(255, 255, 255, 0.32) 0%, rgba(255, 255, 255, 0) 70%),
                    radial-gradient(circle 260px at 90% 74%, rgba(255, 255, 255, 0.28) 0%, rgba(255, 255, 255, 0) 60%),
                    radial-gradient(circle 280px at 8% 85%, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0) 65%);
                box-sizing:border-box;
            }
            #saltiest-influencer .si-hero{--w:min(71.3vw,960px);--u:calc(var(--w)/562);position:absolute;z-index:2;top:15%;left:50%;transform:translateX(-50%);display:flex;gap:calc(var(--u)*15);align-items:flex-start;width:var(--w);pointer-events:none}
            #saltiest-influencer .si-title{margin:0;flex:0 0 calc(var(--u)*210);width:calc(var(--u)*210)}
            #saltiest-influencer .si-title svg{display:block;width:100%;height:auto;overflow:visible}
            #saltiest-influencer .si-title text{font-family:Anton,Impact,"Arial Narrow",sans-serif;font-size:38px;fill:var(--title-color);text-anchor:end}
            #saltiest-influencer .si-text{margin:calc(var(--u)*6) 0 0;font:500 calc(var(--u)*10.5)/calc(var(--u)*17.4) Raleway,Arial,sans-serif;color:var(--text-color);flex:1}
            #saltiest-influencer .si-ln{display:block;white-space:nowrap}
            #saltiest-influencer .si-c{position:absolute;left:0;top:0;width:108px;height:108px;z-index:1;cursor:pointer;will-change:transform;touch-action:manipulation}
            #saltiest-influencer .si-c svg{width:100%;height:100%;overflow:visible}
            #saltiest-influencer .si-lid{transform-box:fill-box;transform-origin:center;transition:transform .08s}
            #saltiest-influencer .si-blink .si-lid{transform:scaleY(.1)}
            @media (max-width:600px){#saltiest-influencer .si-hero{--w:90vw;top:12%;flex-direction:column;gap:18px}#saltiest-influencer .si-title{flex:none;width:min(70vw,300px)}#saltiest-influencer .si-text{font-size:14px;line-height:1.5;margin:0}#saltiest-influencer .si-ln{display:inline;white-space:normal}}
        </style>

        <section id="saltiest-influencer" aria-labelledby="si-heading">
          <div class="si-hero">
            <h2 class="si-title" id="si-heading"><svg viewBox="0 0 210 118" role="img" aria-label="The saltiest influencer"><text x="210" y="32" textLength="65" lengthAdjust="spacingAndGlyphs">THE</text><text x="210" y="74" textLength="158" lengthAdjust="spacingAndGlyphs">SALTIEST</text><text x="210" y="116" textLength="210" lengthAdjust="spacingAndGlyphs">INFLUENCER</text></svg></h2>
            <p class="si-text"><span class="si-ln">A salt brand social accounts are usually very quiet.</span>
        <span class="si-ln">And so were ours. Until suddenly, a salty influencer convinced</span>
        <span class="si-ln">thousands of people to ask us to bring back “Salmon”, a salt flavor</span>
        <span class="si-ln">we discontinued years ago. After receiving 198,851 comments</span>
        <span class="si-ln">overnight we decided to give him what he asked for and maybe</span>
        <span class="si-ln">even a little bit more.</span></p>
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

    <!-- Confetti & Lenis Smooth Scroll Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Confetti Trigger on [data-confetti]
            const palette = ['#E2F163', '#FF3E14', '#F47FA2', '#7EC4FB', '#BDB0FC'];
            const burst = (opts) => {
                if (typeof confetti !== 'function') { return; }
                confetti(Object.assign({
                    particleCount: 75,
                    spread: 74,
                    startVelocity: 42,
                    ticks: 200,
                    origin: { y: 0.6 },
                    colors: palette,
                    scalar: 0.95,
                    disableForReducedMotion: true,
                }, opts || {}));
            };
            document.querySelectorAll('[data-confetti]').forEach((el) => {
                el.addEventListener('click', (e) => {
                    const r = el.getBoundingClientRect();
                    burst({ origin: { x: (r.left + r.width / 2) / window.innerWidth, y: (r.top + r.height / 2) / window.innerHeight } });
                });
            });

            // Lenis Smooth Scroll
            if (typeof Lenis !== 'undefined') {
                const lenis = new Lenis({
                    duration: 0.9,
                    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                    orientation: 'vertical',
                    gestureOrientation: 'vertical',
                    smoothWheel: true,
                    wheelMultiplier: 1.1,
                    touchMultiplier: 1.5,
                    syncTouch: false,
                    infinite: false,
                });

                function raf(time) {
                    lenis.raf(time);
                    requestAnimationFrame(raf);
                }
                requestAnimationFrame(raf);

                window.lenis = lenis;
            }

            // Interactive Movable Symbols (Drag & Drop physics)
            document.querySelectorAll('.movable-symbol').forEach((item) => {
                let isDragging = false;
                let startX, startY;
                let currentTranslateX = 0;
                let currentTranslateY = 0;

                const onPointerDown = (e) => {
                    isDragging = true;
                    startX = e.clientX || (e.touches && e.touches[0].clientX);
                    startY = e.clientY || (e.touches && e.touches[0].clientY);
                    
                    // Stop animation while moving
                    item.style.animationPlayState = 'paused';
                    item.style.zIndex = '50';

                    window.addEventListener('pointermove', onPointerMove);
                    window.addEventListener('pointerup', onPointerUp);
                    window.addEventListener('pointercancel', onPointerUp);
                };

                const onPointerMove = (e) => {
                    if (!isDragging) return;
                    const clientX = e.clientX || (e.touches && e.touches[0].clientX);
                    const clientY = e.clientY || (e.touches && e.touches[0].clientY);
                    const deltaX = clientX - startX;
                    const deltaY = clientY - startY;

                    const nextX = currentTranslateX + deltaX;
                    const nextY = currentTranslateY + deltaY;
                    item.style.transform = `translate3d(${nextX}px, ${nextY}px, 0px) scale(1.15)`;
                };

                const onPointerUp = (e) => {
                    if (!isDragging) return;
                    isDragging = false;
                    const clientX = (e.clientX !== undefined) ? e.clientX : (e.changedTouches && e.changedTouches[0].clientX);
                    const clientY = (e.clientY !== undefined) ? e.clientY : (e.changedTouches && e.changedTouches[0].clientY);
                    if (clientX !== undefined && clientY !== undefined) {
                        currentTranslateX += (clientX - startX);
                        currentTranslateY += (clientY - startY);
                    }
                    
                    // Resume soft idle animation with offset
                    item.style.transform = `translate3d(${currentTranslateX}px, ${currentTranslateY}px, 0px)`;
                    item.style.animationPlayState = 'running';
                    setTimeout(() => { item.style.zIndex = ''; }, 250);

                    window.removeEventListener('pointermove', onPointerMove);
                    window.removeEventListener('pointerup', onPointerUp);
                    window.removeEventListener('pointercancel', onPointerUp);
                };

                item.addEventListener('pointerdown', onPointerDown);
            });
        });
    </script>

    <!-- Saltiest Influencer Animation -->
    <script>
        (function(){
        const stage=document.getElementById('saltiest-influencer');
        if(!stage)return;
        const INK='#0F254B',W='#fff';
        const eyesWhite=()=>`<g class="si-lid"><circle cx="20" cy="18" r="9" fill="${W}"/><circle class="si-p" cx="20" cy="18" r="4.2" fill="${INK}"/></g><g class="si-lid"><circle cx="42" cy="18" r="9" fill="${W}"/><circle class="si-p" cx="42" cy="18" r="4.2" fill="${INK}"/></g>`;
        const eyesDark=`<circle cx="20" cy="18" r="10" fill="${INK}"/><circle cx="42" cy="18" r="10" fill="${INK}"/>`;
        const stroke=`fill="none" stroke="${INK}" stroke-width="3" stroke-linecap="round"`;
        const defs=[
         eyesWhite()+`<line x1="14" y1="40" x2="34" y2="40" ${stroke}/>`,
         eyesWhite()+`<path d="M8 34 H54 A23 23 0 0 1 8 34Z" fill="${INK}"/>`,
         eyesWhite()+`<ellipse cx="32" cy="42" rx="5" ry="7" fill="${INK}"/>`,
         eyesWhite()+`<path d="M16 34 H48 A16 16 0 0 1 16 34Z" fill="${INK}"/>`,
         eyesWhite()+`<path d="M26 38 Q32 48 38 38" ${stroke}/>`,
         eyesDark+`<line x1="18" y1="40" x2="44" y2="40" ${stroke}/>`,
         eyesWhite()+`<path d="M14 42 q4 -10 8 0 t8 0 t8 0 t6 0" ${stroke}/>`,
         eyesDark+`<path d="M26 38 Q32 48 38 38" ${stroke}/>`
        ];
        const hero=stage.querySelector('.si-hero'),pp=stage.querySelector('.si-text');
        function fit(){
          pp.style.fontSize='';
          if(innerWidth<=600)return;
          const target=hero.clientWidth*330/562;
          const cur=Math.max(...[...pp.querySelectorAll('.si-ln')].map(l=>{const r=document.createRange();r.selectNodeContents(l);return r.getBoundingClientRect().width}));
          if(cur>0)pp.style.fontSize=(parseFloat(getComputedStyle(pp).fontSize)*target/cur)+'px';
        }
        fit();if(document.fonts)document.fonts.ready.then(fit);addEventListener('resize',fit);
        const reduce=matchMedia('(prefers-reduced-motion: reduce)').matches;
        let W_=0,H_=0,mouse=null,off=0,on=true,raf=0;
        const size=()=>{W_=stage.clientWidth;H_=stage.clientHeight};
        size();addEventListener('resize',size);
        const chars=defs.map((d,i)=>{
          const el=document.createElement('div');el.className='si-c';
          el.innerHTML=`<svg viewBox="0 0 64 64" aria-hidden="true">${d}</svg>`;
          stage.appendChild(el);
          const o={el,pups:[...el.querySelectorAll('.si-p')],i,x:0,y:0,vx:-1.1,vy:0,rot:0,spin:0,j:0,jv:0,t:i*0.7};
          el.addEventListener('pointerdown',()=>{o.jv=-9;o.spin=(Math.random()<.5?-1:1)*14});
          (function blink(){setTimeout(()=>{el.classList.add('si-blink');setTimeout(()=>el.classList.remove('si-blink'),120);blink()},1500+Math.random()*3500)})();
          return o;
        });
        stage.addEventListener('pointermove',e=>{const r=stage.getBoundingClientRect();mouse={x:e.clientX-r.left,y:e.clientY-r.top}});
        stage.addEventListener('pointerleave',()=>mouse=null);
        function tick(){
          if(!on)return;
          off+=1.1;const L=Math.max(W_+216,8*160);
          for(const c of chars){
            c.t+=.07;
            c.x=(((c.i*L/8-off)%L)+L)%L-108;           // equal spacing, right to left
            const s=Math.abs(Math.sin(c.t)),bob=s*24;   // bouncy walk scaled to size
            c.jv+=.6;c.j+=c.jv;if(c.j>0){c.j=0;c.jv=0}
            c.spin*=.93;c.rot+=c.spin;
            const base=Math.max(340,H_*.73);
            c.y=base-bob+c.j;
            const sq=(1-s)*.14,tilt=Math.sin(c.t)*5;
            c.el.style.transform=`translate(${c.x}px,${c.y}px) rotate(${c.rot+tilt}deg) scale(${1+sq*.6},${1-sq})`;
            let ax=c.vx,ay=c.vy;
            if(mouse){ax=mouse.x-c.x-54;ay=mouse.y-c.y-54}
            const m=Math.hypot(ax,ay)||1,px=ax/m*5.4,py=ay/m*5.4;
            for(const p of c.pups)p.setAttribute('transform',`translate(${px.toFixed(2)} ${py.toFixed(2)})`);
          }
          raf=requestAnimationFrame(tick);
        }
        if(reduce){chars.forEach((c,i)=>{c.el.style.transform=`translate(${80+i*(W_-200)/8}px,${H_*.7}px)`})}
        else{
          new IntersectionObserver(([e])=>{on=e.isIntersecting;cancelAnimationFrame(raf);if(on)raf=requestAnimationFrame(tick)}).observe(stage);
          raf=requestAnimationFrame(tick);
        }
        })();
    </script>
</body>
</html>