<!DOCTYPE html>
<html lang="en" class="scroll-smooth antialiased selection:bg-[#E2F163] selection:text-[#181528]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Light 02 &mdash; HypeMarket Creator Studio</title>
    <meta name="description" content="The Gen-Z friendly creator marketplace where brands cast verified Instagram models, reels creators and live anchors &mdash; with real Meta Graph data and escrow-safe payouts.">

    <!-- Google Fonts (Bricolage Grotesque + Jakarta + Space Grotesk + Caveat + Syne + Fraunces + Unbounded) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800;12..96,900&family=Caveat:wght@600;700&family=Fraunces:ital,opsz,wght@0,9..144,700;0,9..144,800;1,9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&family=Syne:wght@700;800&family=Unbounded:wght@700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Bricolage Grotesque"', 'sans-serif'],
                        syne: ['Syne', 'sans-serif'],
                        unbounded: ['Unbounded', 'sans-serif'],
                        serifx: ['Fraunces', 'serif'],
                        mono: ['"Space Grotesk"', 'monospace'],
                        script: ['Caveat', 'cursive'],
                    },
                    colors: {
                        canvas: '#FAF5EC',
                        paper: '#FFFFFF',
                        ink: '#181528',
                        solar: '#E2F163',
                        vermilion: '#FF3E14',
                        'vermilion-deep': '#C32D00',
                        pink: '#F47FA2',
                        lilac: '#BDB0FC',
                        sky: '#7EC4FB',
                        lemon: '#FFF385',
                        sand: '#F0E7D8',
                    },
                    animation: {
                        'marquee': 'marqueeX 26s linear infinite',
                        'marquee-rev': 'marqueeRev 30s linear infinite',
                        'float-soft': 'floatSoft 4s ease-in-out infinite',
                        'float-delay': 'floatSoft 5s ease-in-out 1.2s infinite',
                        'spin-slow': 'spinSlow 14s linear infinite',
                    },
                    keyframes: {
                        marqueeX: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-50%)' },
                        },
                        marqueeRev: {
                            '0%': { transform: 'translateX(-50%)' },
                            '100%': { transform: 'translateX(0)' },
                        },
                        floatSoft: {
                            '0%, 100%': { transform: 'translateY(0) rotate(var(--rot,0deg))' },
                            '50%': { transform: 'translateY(-12px) rotate(var(--rot,0deg))' },
                        },
                        spinSlow: {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' },
                        },
                    },
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>

    <style>
        body.preload .fx-hidden { opacity: 0 !important; }
        .char {
            display: inline-block;
            will-change: transform;
        }
        .noise-overlay::after {
            content: "";
            position: fixed;
            inset: 0;
            z-index: 60;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        }
        .mask-line { overflow: hidden; }
        .ink-btn { transition: transform .25s cubic-bezier(.32,.72,0,1), background-color .25s, box-shadow .25s; }
        .ink-btn:hover { transform: translateY(-2px); box-shadow: 6px 6px 0 #E2F163; }
        .ink-btn:active { transform: translateY(0) scale(.98); }
        .talent-card img { transition: transform .7s cubic-bezier(.32,.72,0,1), filter .7s; }
        .talent-card:hover img { transform: scale(1.06); }
        .bento-card { transition: transform .5s cubic-bezier(.32,.72,0,1), box-shadow .5s cubic-bezier(.32,.72,0,1); }
        .bento-card:hover { transform: translateY(-6px); }
        .marquee-pause p { transition: opacity .3s; }
        .marquee-pause:hover p { opacity: .55; }
        .bar { transform-origin: bottom; }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
        }
    </style>
</head>

<body class="preload noise-overlay bg-canvas text-ink font-sans min-h-screen overflow-x-hidden">
    <main class="overflow-x-hidden w-full max-w-full relative">

        <!-- ===================== FLUID ISLAND NAV ===================== -->
        <header id="siteNav" class="fixed top-0 inset-x-0 z-50 px-4 mt-4 sm:mt-6 pointer-events-none">
            <nav class="pointer-events-auto mx-auto max-w-6xl flex items-center justify-between rounded-full bg-white/85 backdrop-blur-xl border border-ink/10 px-4 sm:px-5 py-3 shadow-[0_12px_40px_rgba(24,21,40,0.10)]">
                <a href="{{ route('home.light2') }}" class="flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-full bg-solar border-2 border-ink flex items-center justify-center font-display font-black text-sm text-ink">H*</span>
                    <span class="hidden sm:inline-block text-sm font-extrabold tracking-tight">HypeMarket<span class="text-[#C32D00]">.</span></span>
                </a>

                <ul class="hidden md:flex items-center gap-7 text-[13px] font-bold text-ink/80">
                    <li><a href="#bento" class="hover:text-[#C32D00] transition hover:underline decoration-wavy decoration-[#E2F163] underline-offset-4">The Studio</a></li>
                    <li><a href="#lineup" class="hover:text-[#C32D00] transition hover:underline decoration-wavy decoration-[#E2F163] underline-offset-4">The Lineup</a></li>
                    <li><a href="#vibes" class="hover:text-[#C32D00] transition hover:underline decoration-wavy decoration-[#E2F163] underline-offset-4">The Vibes</a></li>
                    <li><a href="#receipts" class="hover:text-[#C32D00] transition hover:underline decoration-wavy decoration-[#E2F163] underline-offset-4">The Receipts</a></li>
                </ul>

                <div class="flex items-center gap-2">
                    <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center gap-2.5 rounded-full bg-ink text-white text-[13px] font-extrabold pl-5 pr-2 py-2 ink-btn">
                        <span>Cast Talent</span>
                        <span class="w-7 h-7 rounded-full bg-solar text-ink flex items-center justify-center text-[11px] group-hover:translate-x-0.5 transition"><i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                    <button id="navToggle" aria-label="Open menu" class="md:hidden w-10 h-10 rounded-full bg-ink text-white flex flex-col items-center justify-center gap-[5px]">
                        <span id="navLine1" class="block w-4 h-[2px] bg-current origin-center"></span>
                        <span id="navLine2" class="block w-4 h-[2px] bg-current origin-center"></span>
                    </button>
                </div>
            </nav>
        </header>

        <!-- Fullscreen menu overlay -->
        <div id="navOverlay" class="hidden fixed inset-0 z-40 bg-canvas/95 backdrop-blur-2xl">
            <div class="h-full flex flex-col justify-center px-8 max-w-4xl mx-auto gap-2">
                <a href="#bento" class="navLink font-display font-black text-4xl sm:text-6xl py-3 border-b border-ink/10 flex items-baseline gap-4"><span class="text-xs font-mono text-[#C32D00]">01</span>The Studio</a>
                <a href="#lineup" class="navLink font-display font-black text-4xl sm:text-6xl py-3 border-b border-ink/10 flex items-baseline gap-4"><span class="text-xs font-mono text-[#C32D00]">02</span>The Lineup</a>
                <a href="#vibes" class="navLink font-display font-black text-4xl sm:text-6xl py-3 border-b border-ink/10 flex items-baseline gap-4"><span class="text-xs font-mono text-[#C32D00]">03</span>The Vibes</a>
                <a href="#receipts" class="navLink font-display font-black text-4xl sm:text-6xl py-3 border-b border-ink/10 flex items-baseline gap-4"><span class="text-xs font-mono text-[#C32D00]">04</span>The Receipts</a>
                <a href="{{ route('register') }}" class="navLink mt-8 self-start rounded-full bg-ink text-solar font-extrabold px-8 py-4 text-sm ink-btn">Cast Talent Now</a>
            </div>
        </div>

        <!-- ===================== HERO (ATTENTION) ===================== -->
        <section class="relative min-h-[100dvh] flex flex-col items-center justify-center px-6 pt-28 pb-16 overflow-hidden">
            <!-- Ambient blobs -->
            <div aria-hidden="true" class="absolute -top-32 -right-24 w-[34rem] h-[34rem] rounded-full bg-solar/40 blur-3xl fx-hidden"></div>
            <div aria-hidden="true" class="absolute -bottom-40 -left-28 w-[36rem] h-[36rem] rounded-full bg-lilac/40 blur-3xl fx-hidden"></div>
            <div aria-hidden="true" class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[26rem] h-[26rem] rounded-full bg-sky/25 blur-3xl fx-hidden"></div>
            <div aria-hidden="true" class="absolute inset-0 opacity-[0.05] bg-[linear-gradient(to_right,#181528_1px,transparent_1px),linear-gradient(to_bottom,#181528_1px,transparent_1px)] bg-[size:56px_56px]"></div>

            <div class="relative z-10 flex flex-col items-center text-center max-w-6xl mx-auto">
                <span id="heroBadge" class="fx-hidden mb-8 inline-flex items-center gap-2 rounded-full bg-paper border border-ink/15 px-4 py-2 text-[11px] font-mono font-bold uppercase tracking-[0.22em] text-ink/70">
                    <span class="w-2 h-2 rounded-full bg-vermilion animate-ping"></span>
                    The Creator Marketplace &mdash; Zero-Bot Certified
                </span>

                <!-- H1 split into chars for GSAP mask reveal -->
                <h1 id="heroTitle" class="fx-hidden font-display font-black leading-[1.02] tracking-[-0.02em] text-ink" style="font-size: clamp(2.6rem, 5.6vw, 5.6rem)">
                    <span class="mask-line block"><span class="heroChars inline-block">Find your</span></span>
                    <span class="mask-line block">
                        <span class="heroChars inline-block">
                            <span class="inline-block w-[2.1em] h-[0.72em] align-baseline -my-1 mx-1 rounded-full overflow-hidden ring-2 ring-ink/20">
                                <img src="https://picsum.photos/seed/reels/180/90" alt="Reels creator" class="w-full h-full object-cover grayscale contrast-125 opacity-90">
                            </span>
                            next
                        </span>
                    </span>
                    <span class="mask-line block">
                        <span class="heroChars inline-block">
                            viral face<span class="text-[#C32D00]"> &mdash; </span>verified,
                        </span>
                    </span>
                    <span class="mask-line block">
                        <span class="heroChars inline-block">
                            escrow-safe, <em class="font-serifx italic font-bold">no flops.</em>
                        </span>
                    </span>
                </h1>

                <p id="heroSub" class="fx-hidden mt-7 max-w-xl text-base sm:text-lg text-ink/65 leading-relaxed font-medium">
                    Real Instagram models, reels creators and live anchors &mdash; authenticated through Meta Graph API with fresh analytics, roster comp cards and payout protection on every booking.
                </p>

                <div id="heroCtas" class="fx-hidden mt-10 flex flex-col sm:flex-row items-center gap-4">
                    <a href="{{ route('register') }}" class="group inline-flex items-center gap-3 rounded-full bg-ink text-white font-extrabold text-sm pl-7 pr-2 py-2.5 ink-btn">
                        <span>Cast Talent Now</span>
                        <span class="w-9 h-9 rounded-full bg-solar text-ink flex items-center justify-center text-xs transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"><i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                    <a href="#lineup" class="inline-flex items-center gap-2.5 rounded-full bg-paper border-2 border-ink text-ink font-bold text-sm px-7 py-3 transition-transform duration-300 hover:-translate-y-0.5">
                        <i class="fa-solid fa-play text-[#C32D00] text-[10px]"></i>
                        Tour the lineup
                    </a>
                    <span class="font-script text-2xl text-[#C32D00] -rotate-2 mt-1 sm:mt-0">&larr; takes 60 seconds</span>
                </div>
            </div>

            <!-- Floating handwritten sticky notes (desktop) -->
            <div id="floatNote1" class="fx-hidden pointer-events-none absolute top-[18%] right-[8%] hidden xl:flex flex-col gap-1 bg-lemon border-2 border-ink rounded-2xl px-5 py-4 shadow-[6px_6px_0_#181528]" style="--rot:3deg">
                <span class="text-[9px] font-mono font-bold uppercase tracking-widest text-ink/50">Verified Reach</span>
                <span class="font-script text-xl text-ink leading-tight">organic fans only. promise.</span>
            </div>
            <div id="floatNote2" class="fx-hidden pointer-events-none absolute bottom-[16%] left-[7%] hidden xl:block bg-sky border-2 border-ink rounded-2xl px-5 py-4 shadow-[6px_6px_0_#181528]" style="--rot:-3deg">
                <p class="font-script text-xl text-ink leading-tight">avg. engagement 2.4&times; higher</p>
            </div>

            <!-- scroll hint (SVG, non-bouncing) -->
            <div class="fx-hidden mt-auto pt-10 pb-2 flex flex-col items-center gap-2 text-ink/40">
                <span class="text-[10px] font-mono font-bold uppercase tracking-[0.3em]">Scroll to vibe</span>
                <svg class="w-5 h-5 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </section>

        <!-- ===================== MARQUEE STRIP (SOCIAL PROOF) ===================== -->
        <section class="relative py-10 border-y-2 border-ink bg-paper overflow-hidden">
            <div aria-hidden="true" class="absolute inset-0 bg-[linear-gradient(to_right,#181528_1px,transparent_1px)] bg-[size:120px_1px] opacity-[0.04]"></div>
            <div class="marquee-pause relative flex flex-col gap-6">
                <div class="flex w-max animate-[marqueeX_26s_linear_infinite]">
                    <div class="flex items-center gap-10 pr-10 whitespace-nowrap">
                        <span class="font-unbounded font-extrabold text-lg text-ink/85">@ananya.model</span><i class="fa-solid fa-bolt text-[#C32D00] text-sm"></i>
                        <span class="font-unbounded font-extrabold text-lg text-ink/85">@zoya.moves</span><i class="fa-solid fa-bolt text-[#C32D00] text-sm"></i>
                        <span class="font-unbounded font-extrabold text-lg text-ink/85">@meera.makes</span><i class="fa-solid fa-bolt text-[#C32D00] text-sm"></i>
                        <span class="font-unbounded font-extrabold text-lg text-ink/85">@arjun.reels</span><i class="fa-solid fa-bolt text-[#C32D00] text-sm"></i>
                        <span class="font-unbounded font-extrabold text-lg text-ink/85">@diya.grid</span><i class="fa-solid fa-bolt text-[#C32D00] text-sm"></i>
                    </div>
                    <div class="flex items-center gap-10 pr-10 whitespace-nowrap" aria-hidden="true">
                        <span class="font-unbounded font-extrabold text-lg text-ink/85">@ananya.model</span><i class="fa-solid fa-bolt text-[#C32D00] text-sm"></i>
                        <span class="font-unbounded font-extrabold text-lg text-ink/85">@zoya.moves</span><i class="fa-solid fa-bolt text-[#C32D00] text-sm"></i>
                        <span class="font-unbounded font-extrabold text-lg text-ink/85">@meera.makes</span><i class="fa-solid fa-bolt text-[#C32D00] text-sm"></i>
                        <span class="font-unbounded font-extrabold text-lg text-ink/85">@arjun.reels</span><i class="fa-solid fa-bolt text-[#C32D00] text-sm"></i>
                        <span class="font-unbounded font-extrabold text-lg text-ink/85">@diya.grid</span><i class="fa-solid fa-bolt text-[#C32D00] text-sm"></i>
                    </div>
                </div>
                <div class="flex w-max animate-[marqueeRev_30s_linear_infinite]">
                    <div class="flex items-center gap-10 pr-10 whitespace-nowrap">
                        <span class="font-mono font-bold text-sm text-ink/60 uppercase tracking-widest">840K avg. reel reach</span><span class="w-2 h-2 rounded-full bg-vermilion"></span>
                        <span class="font-mono font-bold text-sm text-ink/60 uppercase tracking-widest">98.4% authentic audience</span><span class="w-2 h-2 rounded-full bg-sky"></span>
                        <span class="font-mono font-bold text-sm text-ink/60 uppercase tracking-widest">2.1M brand payouts sent</span><span class="w-2 h-2 rounded-full bg-lilac"></span>
                        <span class="font-mono font-bold text-sm text-ink/60 uppercase tracking-widest">41 city creators</span><span class="w-2 h-2 rounded-full bg-pink"></span>
                    </div>
                    <div class="flex items-center gap-10 pr-10 whitespace-nowrap" aria-hidden="true">
                        <span class="font-mono font-bold text-sm text-ink/60 uppercase tracking-widest">840K avg. reel reach</span><span class="w-2 h-2 rounded-full bg-vermilion"></span>
                        <span class="font-mono font-bold text-sm text-ink/60 uppercase tracking-widest">98.4% authentic audience</span><span class="w-2 h-2 rounded-full bg-sky"></span>
                        <span class="font-mono font-bold text-sm text-ink/60 uppercase tracking-widest">2.1M brand payouts sent</span><span class="w-2 h-2 rounded-full bg-lilac"></span>
                        <span class="font-mono font-bold text-sm text-ink/60 uppercase tracking-widest">41 city creators</span><span class="w-2 h-2 rounded-full bg-pink"></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== BENTO STUDIO (INTEREST) ===================== -->
        <section id="bento" class="relative max-w-7xl mx-auto px-6 py-32 md:py-44">
            <div class="max-w-3xl mb-16">
                <span class="reveal inline-flex items-center gap-2 rounded-full bg-sky/30 text-ink border border-ink/15 px-4 py-1.5 text-[11px] font-mono font-bold uppercase tracking-[0.2em]">
                    <i class="fa-solid fa-bolt text-[#C32D00]"></i> The Studio
                </span>
                <h2 class="reveal mt-5 font-display font-black text-ink leading-[1.04] tracking-tight" style="font-size: clamp(2.2rem, 4.4vw, 4rem)">
                    A talent stack that<br class="hidden sm:block"> actually <span class="bg-solar px-2 rounded-2xl -rotate-1 inline-block">performs.</span>
                </h2>
                <p class="reveal mt-5 max-w-2xl text-ink/60 text-lg leading-relaxed font-medium">
                    Every profile ships with live analytics, comp-card style portfolios and payout escrow. No bots, no vanity metrics, no disappearing acts.
                </p>
            </div>

            <!-- 5-card gapless bento (3 rows x 6 cols = 18 cells) -->
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4 md:gap-5 auto-rows-auto grid-flow-dense">

                <!-- A: Big feature card (4x2) -->
                <div class="bento-card md:col-span-4 md:row-span-2 relative rounded-[2.5rem] bg-paper border-2 border-ink shadow-[10px_10px_0_#E2F163] overflow-hidden group">
                    <div class="absolute inset-0 overflow-hidden">
                        <img src="https://picsum.photos/seed/brandcollab/1200/900" alt="Creator production set" class="w-full h-full object-cover grayscale-[0.2] group-hover:scale-105 transition-transform duration-700 ease-out" style="mix-blend-mode:multiply; opacity:.92">
                    </div>
                    <div class="relative z-10 p-7 sm:p-9 flex flex-col justify-between min-h-[24rem] h-full">
                        <div class="flex items-center justify-between">
                            <span class="rounded-full bg-paper/90 backdrop-blur border border-ink/15 px-3.5 py-1.5 font-mono text-[10px] font-bold uppercase tracking-widest">Featured Playbook</span>
                            <span class="w-10 h-10 rounded-full bg-vermilion text-white flex items-center justify-center"><i class="fa-solid fa-play text-xs"></i></span>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-3xl sm:text-4xl leading-[1.05] text-ink drop-shadow-[0_2px_0_#fff]">Launch week,<br>booked <span class="text-[#C32D00]">&amp; shipped</span>.</h3>
                            <p class="mt-3 max-w-md text-sm text-ink/80 font-semibold leading-relaxed bg-paper/70 backdrop-blur p-3 rounded-2xl border border-ink/10">
                                A fashion label briefed <span class="font-mono font-bold">6 creators</span>, shot 12 reels in 5 cities and went from concept to viral in 9 days &mdash; all inside one dashboard.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- B: Live graph card -->
                <div class="bento-card md:col-span-2 rounded-[2.2rem] bg-ink text-white border-2 border-ink p-6 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="font-mono text-[10px] font-bold uppercase tracking-widest text-white/50">Live Reach</span>
                        <span class="w-2.5 h-2.5 rounded-full bg-solar animate-pulse"></span>
                    </div>
                    <div>
                        <p class="font-display font-black text-3xl">840.5K</p>
                        <p class="text-xs text-solar font-bold font-mono">+42% this week</p>
                    </div>
                    <div class="flex items-end gap-1.5 h-16 mt-4" id="reachBars">
                        <span class="bar w-full bg-solar/80 rounded-t-md" data-h="35"></span>
                        <span class="bar w-full bg-solar/80 rounded-t-md" data-h="55"></span>
                        <span class="bar w-full bg-solar/80 rounded-t-md" data-h="42"></span>
                        <span class="bar w-full bg-solar/80 rounded-t-md" data-h="70"></span>
                        <span class="bar w-full bg-solar/80 rounded-t-md" data-h="60"></span>
                        <span class="bar w-full bg-solar/80 rounded-t-md" data-h="88"></span>
                        <span class="bar w-full bg-solar/80 rounded-t-md" data-h="100"></span>
                    </div>
                </div>

                <!-- C: handwritten sticky card -->
                <div class="bento-card md:col-span-2 rounded-[2.2rem] bg-lemon border-2 border-ink p-6 flex flex-col justify-between shadow-[6px_6px_0_#181528]" style="--rot:0deg">
                    <span class="text-[9px] font-mono font-bold uppercase tracking-widest text-ink/50">Creator Note</span>
                    <div class="my-5">
                        <p class="font-script text-2xl sm:text-3xl text-ink leading-tight">
                            "audience is 88% organic Indian, 18&ndash;24. the reels basically sell themselves."
                        </p>
                        <span class="font-script text-lg text-[#C32D00]">&mdash; Zoya, beauty creator</span>
                    </div>
                    <div class="pt-3 border-t border-ink/15 font-mono text-[10px] font-bold uppercase text-ink/50">Dated &bull; this morning</div>
                </div>

                <!-- D: feature strip (4 cols) -->
                <div class="bento-card md:col-span-4 rounded-[2.2rem] bg-paper border-2 border-ink p-7 sm:p-8 flex flex-col sm:flex-row sm:items-center gap-8">
                    <div class="flex-1">
                        <span class="inline-flex items-center gap-2 rounded-full bg-lilac/40 text-ink border border-ink/15 px-3.5 py-1.5 font-mono text-[10px] font-bold uppercase tracking-widest">
                            <i class="fa-solid fa-shield-halved text-[#C32D00]"></i> Escrow built-in
                        </span>
                        <h3 class="mt-4 font-display font-black text-2xl sm:text-3xl leading-tight">
                            Get paid on<br>deliverables, not<br class="hidden sm:block"> <span class="font-serifx italic font-bold text-[#C32D00]">promises.</span>
                        </h3>
                    </div>
                    <div class="shrink-0 grid grid-cols-3 gap-3 max-sm:w-full">
                        <div class="rounded-2xl bg-sand px-4 py-5 text-center border border-ink/10">
                            <p class="font-mono font-extrabold text-lg text-ink">100%</p>
                            <p class="text-[10px] font-mono font-bold uppercase text-ink/50 mt-1">Held safely</p>
                        </div>
                        <div class="rounded-2xl bg-sand px-4 py-5 text-center border border-ink/10">
                            <p class="font-mono font-extrabold text-lg text-ink">48h</p>
                            <p class="text-[10px] font-mono font-bold uppercase text-ink/50 mt-1">Release max</p>
                        </div>
                        <div class="rounded-2xl bg-sand px-4 py-5 text-center border border-ink/10">
                            <p class="font-mono font-extrabold text-lg text-ink">0%</p>
                            <p class="text-[10px] font-mono font-bold uppercase text-ink/50 mt-1">Chargebacks</p>
                        </div>
                    </div>
                </div>

                <!-- E: utility chip card (2 cols) -->
                <div class="bento-card md:col-span-2 rounded-[2.2rem] bg-sky/40 border-2 border-ink p-7 flex flex-col justify-between">
                    <span class="font-mono text-[10px] font-bold uppercase tracking-widest text-ink/60">Role Filters</span>
                    <p class="mt-3 font-display font-black text-xl leading-tight">Models &bull; Reels &bull; Anchors &bull; Mascots &bull; Hosts</p>
                    <div class="mt-5 flex flex-wrap gap-2">
                        <span class="cursor-pointer rounded-full bg-paper border border-ink/20 px-3 py-1.5 text-[11px] font-bold hover:bg-ink hover:text-solar transition">Fashion</span>
                        <span class="cursor-pointer rounded-full bg-paper border border-ink/20 px-3 py-1.5 text-[11px] font-bold hover:bg-ink hover:text-solar transition">Beauty</span>
                        <span class="cursor-pointer rounded-full bg-paper border border-ink/20 px-3 py-1.5 text-[11px] font-bold hover:bg-ink hover:text-solar transition">Gaming</span>
                        <span class="cursor-pointer rounded-full bg-paper border border-ink/20 px-3 py-1.5 text-[11px] font-bold hover:bg-ink hover:text-solar transition">Events</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== PINNED LINEUP (DESIRE / HORIZONTAL) ===================== -->
        <section id="lineup" class="pin-wrap relative overflow-hidden border-y-2 border-ink bg-paper">
            <div class="flex items-center h-auto min-h-[100dvh]">
                <!-- Pinned heading column -->
                <div class="shrink-0 w-full lg:w-[36%] px-8 lg:px-16 py-16 flex flex-col justify-center">
                    <span class="inline-flex items-center gap-2 self-start rounded-full bg-vermilion text-white px-4 py-1.5 text-[11px] font-mono font-bold uppercase tracking-[0.2em]">
                        <i class="fa-solid fa-users"></i> The Lineup
                    </span>
                    <h2 class="pin-heading mt-6 font-syne font-extrabold text-ink leading-[1.02] tracking-tight" style="font-size: clamp(2.4rem, 4vw, 3.6rem)">
                        Real creators.<br>Swipe the roster.
                    </h2>
                    <p class="mt-6 max-w-sm text-ink/60 leading-relaxed font-medium">
                        Each card is a living comp card &mdash; reach, engagement, rate card and verified tag, refreshed straight from the graph.
                    </p>
                    <p class="mt-8 font-mono text-xs font-bold uppercase tracking-widest text-ink/40">Scroll &rarr; to browse</p>
                    <!-- progress rail -->
                    <div class="mt-4 w-40 h-1.5 rounded-full bg-ink/10 overflow-hidden">
                        <div class="pin-progress h-full w-full origin-left rounded-full bg-vermilion" style="transform:scaleX(0)"></div>
                    </div>
                </div>

                <!-- Horizontal talent track -->
                <div class="flex items-center gap-6 pl-4 lg:pl-12 pr-16 w-full">
                    <div class="pin-track flex gap-6 pr-10 will-change-transform">
                        @php
                            $talent = [
                                ['name' => 'Ananya Roy', 'handle' => '@ananya.model', 'niche' => 'Runway &amp; Fashion', 'reach' => '1.2M', 'er' => '6.4%', 'rate' => '₹25K', 'img' => 'women/47', 'tag' => 'Lakmé Casted'],
                                ['name' => 'Zoya Khan', 'handle' => '@zoya.moves', 'niche' => 'Beauty &amp; Reels', 'reach' => '840K', 'er' => '8.8%', 'rate' => '₹18K', 'img' => 'women/65', 'tag' => 'Top 2% ER'],
                                ['name' => 'Meera Nair', 'handle' => '@meera.makes', 'niche' => 'Food &amp; Lifestyle', 'reach' => '1.6M', 'er' => '5.1%', 'rate' => '₹22K', 'img' => 'women/68', 'tag' => 'Verified'],
                                ['name' => 'Arjun Verma', 'handle' => '@arjun.reels', 'niche' => 'Gaming Creator', 'reach' => '2.0M', 'er' => '7.2%', 'rate' => '₹30K', 'img' => 'men/32', 'tag' => 'Live Streamer'],
                                ['name' => 'Diya Patel', 'handle' => '@diya.grid', 'niche' => 'Live Anchor &amp; Host', 'reach' => '540K', 'er' => '9.3%', 'rate' => '₹35K', 'img' => 'women/90', 'tag' => 'Emcee 50+'],
                                ['name' => 'Kabir Sethi', 'handle' => '@kabir.lens', 'niche' => 'Travel &amp; Vogue', 'reach' => '1.1M', 'er' => '6.0%', 'rate' => '₹20K', 'img' => 'men/75', 'tag' => 'Verified'],
                            ];
                        @endphp
                        @foreach ($talent as $t)
                        <div class="talent-card w-[280px] sm:w-[320px] shrink-0 rounded-[2.2rem] bg-canvas border-2 border-ink overflow-hidden shadow-[8px_8px_0_#E2F163]">
                            <div class="relative aspect-[4/5] overflow-hidden rounded-t-[2rem]">
                                <img src="https://randomuser.me/api/portraits/{{ $t['img'] }}.jpg" alt="{{ $t['name'] }}" class="w-full h-full object-cover">
                                <span class="absolute top-3 right-3 rounded-full bg-solar border border-ink px-3 py-1 font-mono text-[10px] font-bold uppercase shadow-sm">{{ $t['tag'] }}</span>
                                <div class="absolute bottom-3 left-3 flex items-center gap-1.5 rounded-full bg-paper/90 backdrop-blur border border-ink/20 px-3 py-1.5">
                                    <i class="fa-brands fa-instagram text-[#C32D00] text-xs"></i>
                                    <span class="font-mono font-bold text-[11px]">{{ $t['handle'] }}</span>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-display font-black text-lg">{{ $t['name'] }}</h3>
                                    <span class="w-5 h-5 rounded-full bg-sky flex items-center justify-center text-[9px] text-ink"><i class="fa-solid fa-check"></i></span>
                                </div>
                                <p class="text-[12px] text-ink/55 font-semibold mt-0.5">{!! $t['niche'] !!}</p>
                                <div class="mt-4 grid grid-cols-3 gap-2 border-t border-ink/10 pt-4">
                                    <div><p class="font-mono font-extrabold text-base">{{ $t['reach'] }}</p><p class="text-[9px] font-mono font-bold uppercase text-ink/45">Reach</p></div>
                                    <div><p class="font-mono font-extrabold text-base text-[#C32D00]">{{ $t['er'] }}</p><p class="text-[9px] font-mono font-bold uppercase text-ink/45">Eng. Rate</p></div>
                                    <div><p class="font-mono font-extrabold text-base">{{ $t['rate'] }}</p><p class="text-[9px] font-mono font-bold uppercase text-ink/45">Rolls</p></div>
                                </div>
                                <a href="{{ route('influencers.public') }}" class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-full bg-ink text-white text-xs font-extrabold py-3 hover:bg-[#C32D00] transition-colors">
                                    View comp card <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== SCRUBBING MANIFESTO (DESIRE) ===================== -->
        <section id="vibes" class="relative max-w-5xl mx-auto px-6 py-36 md:py-56">
            <span class="reveal inline-flex items-center gap-2 rounded-full bg-solar text-ink border border-ink/15 px-4 py-1.5 text-[11px] font-mono font-bold uppercase tracking-[0.2em]">
                <i class="fa-solid fa-comment-dots"></i> The Vibes
            </span>
            <p id="manifesto" class="mt-10 font-display font-black leading-[1.18] tracking-tight text-ink" style="font-size: clamp(1.7rem, 3.4vw, 3rem)">
                <span class="scrub-word">Social</span> <span class="scrub-word">proof</span> <span class="scrub-word">died</span> <span class="scrub-word">the</span> <span class="scrub-word">moment</span> <span class="scrub-word">buy</span> <span class="scrub-word">followers</span> <span class="scrub-word">became</span> <span class="scrub-word">a</span> <span class="scrub-word">cart</span> <span class="scrub-word">item.</span>
                <span class="scrub-word">We</span> <span class="scrub-word">rebuild</span> <span class="scrub-word">it</span> <span class="scrub-word">with</span> <span class="scrub-word">graph</span> <span class="scrub-word">data</span> <span class="scrub-word">&mdash;</span> <span class="scrub-word">reach,</span> <span class="scrub-word">retention</span> <span class="scrub-word">and</span> <span class="scrub-word">audience</span> <span class="scrub-word">truth,</span>
                <span class="scrub-word">not</span> <span class="scrub-word">screenshots.</span> <span class="scrub-word font-serifx italic text-[#C32D00]">trust, but verify.</span>
            </p>
            <div class="reveal mt-12 flex flex-wrap items-center gap-4">
                <span class="rounded-full bg-paper border-2 border-ink px-5 py-2.5 font-mono text-xs font-bold">API first</span>
                <span class="rounded-full bg-paper border-2 border-ink px-5 py-2.5 font-mono text-xs font-bold">No bots ever</span>
                <span class="rounded-full bg-paper border-2 border-ink px-5 py-2.5 font-mono text-xs font-bold">Escrow payouts</span>
                <span class="font-script text-2xl text-[#C32D00] rotate-2">&mdash; the old way knew no cap</span>
            </div>
        </section>

        <!-- ===================== LIVE RECEIPTS (COUNTERS) ===================== -->
        <section id="receipts" class="relative border-y-2 border-ink bg-paper overflow-hidden">
            <div aria-hidden="true" class="absolute -top-24 left-1/3 w-96 h-96 rounded-full bg-lilac/30 blur-3xl"></div>
            <div class="max-w-7xl mx-auto px-6 py-24 md:py-32">
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-x-6 gap-y-12">
                    <div class="reveal lg:col-span-1"></div>
                    <div class="reveal">
                        <p class="font-display font-black text-5xl sm:text-6xl text-ink"><span data-count="12800">0</span></p>
                        <p class="mt-2 text-[11px] font-mono font-bold uppercase tracking-widest text-ink/50">Creators rostered</p>
                    </div>
                    <div class="reveal">
                        <p class="font-display font-black text-5xl sm:text-6xl text-ink"><span data-count="2500">0</span><span class="text-vermilion">+</span></p>
                        <p class="mt-2 text-[11px] font-mono font-bold uppercase tracking-widest text-ink/50">Campaigns shipped</p>
                    </div>
                    <div class="reveal">
                        <p class="font-display font-black text-5xl sm:text-6xl text-ink"><span data-count="12">0</span>.5M<span class="text-vermilion">+</span></p>
                        <p class="mt-2 text-[11px] font-mono font-bold uppercase tracking-widest text-ink/50">Verified reach</p>
                    </div>
                    <div class="reveal">
                        <p class="font-display font-black text-5xl sm:text-6xl text-ink"><span data-count="2.1">0</span>M</p>
                        <p class="mt-2 text-[11px] font-mono font-bold uppercase tracking-widest text-ink/50">Escrow protected ₹</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== TESTIMONIAL CAROUSEL ===================== -->
        <section class="relative max-w-7xl mx-auto px-6 py-32 md:py-44">
            <div class="grid lg:grid-cols-2 gap-14 items-center">
                <div>
                    <span class="reveal inline-flex items-center gap-2 rounded-full bg-pink/30 text-ink border border-ink/15 px-4 py-1.5 text-[11px] font-mono font-bold uppercase tracking-[0.2em]">
                        <i class="fa-solid fa-heart"></i> The Receipts
                    </span>
                    <h2 class="reveal mt-5 font-display font-black leading-[1.04] tracking-tight" style="font-size: clamp(2.2rem, 4vw, 3.6rem)">
                        Receipts from<br>the front <span class="font-serifx italic text-[#C32D00]">lines.</span>
                    </h2>

                    <div class="reveal mt-8 flex items-center gap-4">
                        <div class="flex -space-x-3">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="w-11 h-11 rounded-full border-2 border-paper object-cover">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Client" class="w-11 h-11 rounded-full border-2 border-paper object-cover">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Client" class="w-11 h-11 rounded-full border-2 border-paper object-cover">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Client" class="w-11 h-11 rounded-full border-2 border-paper object-cover">
                        </div>
                        <div class="flex gap-2">
                            <button id="tPrev" aria-label="Previous testimonial" class="w-10 h-10 rounded-full bg-paper border-2 border-ink flex items-center justify-center hover:bg-solar transition-colors"><i class="fa-solid fa-arrow-left text-xs"></i></button>
                            <button id="tNext" aria-label="Next testimonial" class="w-10 h-10 rounded-full bg-ink text-white flex items-center justify-center hover:bg-[#C32D00] transition-colors"><i class="fa-solid fa-arrow-right text-xs"></i></button>
                        </div>
                    </div>
                </div>

                <div id="tCarousel" class="reveal relative overflow-hidden rounded-[2.5rem] bg-canvas border-2 border-ink shadow-[10px_10px_0_#BDB0FC]">
                    <div class="t-track flex transition-transform duration-700 ease-[cubic-bezier(0.32,0.72,0,1)]">
                        <div class="t-slide w-full shrink-0 p-8 sm:p-10">
                            <div class="flex gap-1 text-[#C32D00] text-sm"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <blockquote class="mt-5 font-display font-bold text-xl sm:text-2xl leading-snug">
                                "We briefed six creators across five cities. Nine days later we had a full campaign of reels with real, verified reach &mdash; and the escrow meant nobody had to chase anyone for payment."
                            </blockquote>
                            <p class="mt-6 font-mono text-xs font-bold text-ink/60">Tara M. &bull; Head of Growth &mdash; urbanwear label</p>
                        </div>
                        <div class="t-slide w-full shrink-0 p-8 sm:p-10">
                            <div class="flex gap-1 text-[#C32D00] text-sm"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <blockquote class="mt-5 font-display font-bold text-xl sm:text-2xl leading-snug">
                                "The comp cards are the future. Reach, engagement rate, audience geography &mdash; all pulled live, all verifiable. Selecting talent took minutes, not weeks."
                            </blockquote>
                            <p class="mt-6 font-mono text-xs font-bold text-ink/60">Rahul S. &bull; Founder &mdash; D2C skincare</p>
                        </div>
                        <div class="t-slide w-full shrink-0 p-8 sm:p-10">
                            <div class="flex gap-1 text-[#C32D00] text-sm"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <blockquote class="mt-5 font-display font-bold text-xl sm:text-2xl leading-snug">
                                "Booked an emcee for our awards night in 48 hours. Clean contract, clean payout. The talent side is finally as organised as the brand side."
                            </blockquote>
                            <p class="mt-6 font-mono text-xs font-bold text-ink/60">Neha K. &bull; Events Producer &mdash; Mumbai</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== ACTION CTA (ACTION) ===================== -->
        <section class="relative max-w-7xl mx-auto px-6 pb-32 md:pb-44">
            <div class="relative rounded-[3rem] bg-solar border-2 border-ink p-8 sm:p-16 overflow-hidden shadow-[14px_14px_0_#181528]">
                <div aria-hidden="true" class="absolute -top-20 -right-16 w-72 h-72 rounded-full bg-pink/40 blur-3xl"></div>
                <div aria-hidden="true" class="absolute -bottom-24 -left-16 w-80 h-80 rounded-full bg-sky/40 blur-3xl"></div>

                <div class="relative z-10 flex flex-col items-center text-center max-w-3xl mx-auto">
                    <span class="rounded-full bg-paper border-2 border-ink px-5 py-2 font-mono text-[11px] font-bold uppercase tracking-[0.2em]">Your brand, their feed</span>
                    <h2 class="mt-7 font-display font-black leading-[1.02] tracking-tight" style="font-size: clamp(2.6rem, 5.2vw, 5rem)">
                        Book a face.<br>Drop a <span class="font-script text-[#C32D00]">blockbuster.</span>
                    </h2>
                    <p class="mt-6 text-ink/70 font-medium leading-relaxed max-w-xl">
                        Post your brief, compare verified creators side by side, and let escrow keep every payout honest. First casting is on us.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row items-center gap-4">
                        <a href="{{ route('register') }}" class="group inline-flex items-center gap-3 rounded-full bg-ink text-white font-extrabold text-sm pl-7 pr-2 py-3 ink-btn">
                            <span>Start a casting</span>
                            <span class="w-9 h-9 rounded-full bg-solar text-ink flex items-center justify-center text-xs transition-transform duration-300 group-hover:rotate-45"><i class="fa-solid fa-arrow-up"></i></span>
                        </a>
                        <a href="{{ route('campaigns.public') }}" class="inline-flex items-center gap-2 rounded-full bg-paper border-2 border-ink text-ink font-bold text-sm px-7 py-3.5 transition-transform duration-300 hover:-translate-y-0.5">
                            Browse live briefs
                        </a>
                    </div>
                </div>

                <!-- rotating badge -->
                <div class="absolute top-6 right-6 sm:top-10 sm:right-10 w-24 h-24 sm:w-28 sm:h-28 animate-spin-slow">
                    <svg viewBox="0 0 100 100" class="w-full h-full">
                        <defs><path id="circ" d="M50,50 m-37,0 a37,37 0 1,1 74,0 a37,37 0 1,1 -74,0"></path></defs>
                        <text class="fill-ink font-mono" style="font-size:9.5px; letter-spacing:2.5px;">
                            <textPath href="#circ">CAST &bull; CREATE &bull; CONVERT &bull; </textPath>
                        </text>
                    </svg>
                    <span class="absolute inset-0 m-auto w-9 h-9 rounded-full bg-ink text-solar flex items-center justify-center text-sm"><i class="fa-solid fa-bolt"></i></span>
                </div>
            </div>
        </section>

        <!-- ===================== FOOTER ===================== -->
        <footer class="border-t-2 border-ink bg-canvas">
            <div class="max-w-7xl mx-auto px-6 py-14 grid md:grid-cols-4 gap-10">
                <div class="md:col-span-2">
                    <a href="{{ route('home.light2') }}" class="flex items-center gap-2.5">
                        <span class="w-10 h-10 rounded-full bg-solar border-2 border-ink flex items-center justify-center font-display font-black text-ink">H*</span>
                        <span class="text-lg font-extrabold tracking-tight">HypeMarket</span>
                    </a>
                    <p class="mt-4 max-w-sm text-sm text-ink/60 leading-relaxed">
                        The verified creator marketplace. Cast Instagram models, reels creators and anchors with live graph analytics, comp cards and escrow-protected payouts.
                    </p>
                    <span class="mt-5 inline-block font-script text-xl text-[#C32D00] rotate-[-2deg]">built for the feed generation &#10022;</span>
                </div>
                <div>
                    <h4 class="font-mono text-[11px] font-bold uppercase tracking-widest text-ink/50">Marketplace</h4>
                    <ul class="mt-4 space-y-3 text-sm font-semibold text-ink/75">
                        <li><a href="{{ route('influencers.public') }}" class="hover:text-[#C32D00] transition">Creators</a></li>
                        <li><a href="{{ route('campaigns.public') }}" class="hover:text-[#C32D00] transition">Campaigns</a></li>
                        <li><a href="{{ route('how-it-works') }}" class="hover:text-[#C32D00] transition">How it works</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-[#C32D00] transition">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-mono text-[11px] font-bold uppercase tracking-widest text-ink/50">Policies</h4>
                    <ul class="mt-4 space-y-3 text-sm font-semibold text-ink/75">
                        <li><a href="{{ route('terms') }}" class="hover:text-[#C32D00] transition">Terms of service</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-[#C32D00] transition">Privacy policy</a></li>
                        <li><a href="{{ route('data-deletion') }}" class="hover:text-[#C32D00] transition">Data deletion</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-[#C32D00] transition">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-ink/10">
                <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs font-mono text-ink/45">
                    <span>&copy; {{ date('Y') }} HypeMarket. Verified reach only, always.</span>
                    <span class="flex items-center gap-4">
                        <a href="#" aria-label="Instagram" class="hover:text-ink transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" aria-label="X" class="hover:text-ink transition"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn" class="hover:text-ink transition"><i class="fa-brands fa-linkedin-in"></i></a>
                    </span>
                </div>
            </div>
        </footer>
    </main>

    <!-- ===================== MOTION CHOREOGRAPHY (GSAP + SCROLLTRIGGER + LENIS) ===================== -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const hasGsap = typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined';
            const hasLenis = typeof Lenis !== 'undefined' && !prefersReduced;

            // Smooth scroll engine
            let lenis = null;
            if (hasLenis && hasGsap) {
                gsap.registerPlugin(ScrollTrigger);
                lenis = new Lenis({ duration: 1.2, easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)) });
                lenis.on('scroll', ScrollTrigger.update);
                gsap.ticker.add((time) => lenis.raf(time * 1000));
                gsap.ticker.lagSmoothing(0);
            } else if (hasGsap) {
                gsap.registerPlugin(ScrollTrigger);
            }

            // Smooth-scroll: convert in-page anchors to Lenis scroll
            document.querySelectorAll('a[href^="#"]').forEach((a) => {
                a.addEventListener('click', (e) => {
                    const target = document.querySelector(a.getAttribute('href'));
                    if (!target) return;
                    e.preventDefault();
                    if (lenis) { lenis.scrollTo(target, { offset: -80 }); }
                    else { target.scrollIntoView({ behavior: prefersReduced ? 'auto' : 'smooth' }); }
                });
            });

            // Nav toggle + morph to X + staggered overlay links
            const navToggle = document.getElementById('navToggle');
            const navOverlay = document.getElementById('navOverlay');
            const n1 = document.getElementById('navLine1');
            const n2 = document.getElementById('navLine2');
            let menuOpen = false;
            if (navToggle && navOverlay) {
                navToggle.addEventListener('click', () => {
                    menuOpen = !menuOpen;
                    navOverlay.classList.toggle('hidden');
                    if (menuOpen) {
                        navOverlay.classList.remove('hidden');
                        if (hasGsap && !prefersReduced) {
                            gsap.fromTo('.navLink', { y: 40, opacity: 0 }, { y: 0, opacity: 1, duration: 0.7, stagger: 0.08, ease: 'power3.out', delay: 0.1 });
                        } else {
                            gsap.set('.navLink', { clearProps: 'all' });
                        }
                    }
                    gsap.to(n1, { rotate: menuOpen ? 45 : 0, y: menuOpen ? 7 : 0, duration: 0.35, ease: 'power2.out' });
                    gsap.to(n2, { rotate: menuOpen ? -45 : 0, y: menuOpen ? -7 : 0, duration: 0.35, ease: 'power2.out' });
                });
                navOverlay.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => {
                    menuOpen = false;
                    navOverlay.classList.add('hidden');
                    gsap.to(n1, { rotate: 0, y: 0, duration: 0.3 });
                    gsap.to(n2, { rotate: 0, y: 0, duration: 0.3 });
                }));
            }

            if (!hasGsap || prefersReduced) {
                document.body.classList.remove('preload');
                return;
            }

            gsap.registerPlugin(ScrollTrigger);

            // ---- HERO ENTRANCE (mask line reveal) ----
            gsap.set('.fx-hidden', { opacity: 0 });
            const tl = gsap.timeline({ delay: 0.25, defaults: { ease: 'power4.out' } });
            tl.from('.heroChars', { yPercent: 120, duration: 1.2, stagger: 0.12, ease: 'power4.out', clearProps: 'transform' }, 0.05)
                .to('.fx-hidden', { opacity: 1, duration: 1, stagger: 0.05, ease: 'power3.out' }, 0.5)
                .fromTo('#heroCtas > *', { y: 26, opacity: 0 }, { y: 0, opacity: 1, duration: 0.7, stagger: 0.14, ease: 'power3.out' }, 0.8)
                .fromTo(['#floatNote1', '#floatNote2'], { y: 40, rotate: 0 }, { y: 0, rotate: (i) => (i === 0 ? 3 : -3), duration: 0.8, stagger: 0.15, ease: 'power3.out' }, 0.9)
                .add(() => { document.body.classList.remove('preload'); }, 0.4);

            // ---- SCROLL REVEALS ----
            gsap.utils.toArray('.reveal').forEach((el) => {
                gsap.from(el, {
                    scrollTrigger: { trigger: el, start: 'top 86%', toggleActions: 'play none none none' },
                    y: 42,
                    blur: 6,
                    opacity: 0,
                    duration: 0.9,
                    ease: 'power3.out'
                });
            });

            // ---- BENTO CARDS + inner images ----
            gsap.utils.toArray('.bento-card').forEach((card) => {
                gsap.from(card, {
                    scrollTrigger: { trigger: card, start: 'top 90%', toggleActions: 'play none none none' },
                    y: 60,
                    rotate: (card.id || Math.random()) * 0 + (Math.random() > 0.5 ? 2 : -2),
                    opacity: 0,
                    duration: 0.9,
                    ease: 'power3.out'
                });
            });
            // reach bars grow
            gsap.from('.bar', {
                scrollTrigger: { trigger: '#reachBars', start: 'top 90%', toggleActions: 'play none none none' },
                scaleY: 0,
                transformOrigin: 'bottom',
                duration: 1.1,
                stagger: 0.06,
                ease: 'power3.inOut'
            });

            // ---- PINNED HORIZONTAL LINEUP ----
            const pinWrap = document.querySelector('.pin-wrap');
            const track = document.querySelector('.pin-track');
            if (pinWrap && track) {
                const getAmount = () => Math.max(0, track.scrollWidth - window.innerWidth);
                gsap.to(track, {
                    x: () => -getAmount(),
                    ease: 'none',
                    scrollTrigger: {
                        trigger: pinWrap,
                        start: 'top top',
                        end: () => '+=' + getAmount(),
                        scrub: 1,
                        pin: true,
                        anticipatePin: 1,
                        invalidateOnRefresh: true,
                        onUpdate: (self) => {
                            const progressBar = document.querySelector('.pin-progress');
                            if (progressBar) progressBar.style.transform = 'scaleX(' + self.progress + ')';
                        }
                    }
                });
                // entrance for heading
                gsap.from('.pin-heading', {
                    scrollTrigger: { trigger: pinWrap, start: 'top 60%', toggleActions: 'play none none none' },
                    y: 40, opacity: 0, duration: 0.8, ease: 'power3.out'
                });
            }

            // ---- SCRUBBING MANIFESTO ----
            const manifestoWords = gsap.utils.toArray('.scrub-word');
            if (manifestoWords.length) {
                gsap.from(manifestoWords, {
                    opacity: 0.1,
                    stagger: 0.02,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: '#manifesto',
                        start: 'top 80%',
                        end: 'bottom 55%',
                        scrub: 0.4
                    }
                });
            }

            // ---- COUNTERS ----
            document.querySelectorAll('[data-count]').forEach((el) => {
                const end = parseFloat(el.dataset.count);
                const isFloat = el.dataset.count.includes('.');
                const obj = { val: 0 };
                gsap.to(obj, {
                    val: end,
                    duration: 2,
                    ease: 'power2.out',
                    scrollTrigger: { trigger: el, start: 'top 88%', once: true },
                    onUpdate() {
                        el.textContent = isFloat ? obj.val.toFixed(1) : Math.round(obj.val).toLocaleString('en-IN');
                    }
                });
            });

            // ---- TESTIMONIAL CAROUSEL ----
            const tTrack = document.querySelector('.t-track');
            const tSlides = gsap.utils.toArray('.t-slide');
            const c = document.getElementById('tCarousel');
            if (tTrack && tSlides.length > 1 && c) {
                let idx = 0;
                let paused = false;
                const go = (i) => {
                    idx = (i + tSlides.length) % tSlides.length;
                    gsap.to(tTrack, { xPercent: -idx * 100, duration: 0.75, ease: 'power3.out' });
                };
                const auto = window.setInterval(() => { if (!paused && !prefersReduced) go(idx + 1); }, 4500);
                document.getElementById('tPrev').addEventListener('click', () => go(idx - 1));
                document.getElementById('tNext').addEventListener('click', () => go(idx + 1));
                c.addEventListener('mouseenter', () => paused = true);
                c.addEventListener('mouseleave', () => paused = false);
            }

            // Kill pin on resize to avoid broken scroll on mobile landscape
            window.addEventListener('load', () => ScrollTrigger.refresh());
        });
    </script>
</body>
</html>