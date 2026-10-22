<!DOCTYPE html>
<html lang="en" class="antialiased selection:bg-[#D6FF3D] selection:text-[#181528]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Light 03 &mdash; HypeMarket Playground</title>
    <meta name="description" content="The video-first, high-contrast creator marketplace. Swipe the roster, pick your vibe, watch the reels and cast verified Instagram talent with escrow-safe payouts.">

    <!-- Google Fonts (Bricolage Grotesque + Unbounded + Fraunces + Instrument Serif + Jakarta + Space Grotesk + Caveat) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800;12..96,900&family=Caveat:wght@600;700&family=Fraunces:ital,opsz,wght@0,9..144,700;0,9..144,800;1,9..144,700&family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&family=Unbounded:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Bricolage Grotesque"', 'sans-serif'],
                        ransom: ['Unbounded', 'sans-serif'],
                        serifx: ['Fraunces', 'serif'],
                        editorial: ['"Instrument Serif"', 'serif'],
                        mono: ['"Space Grotesk"', 'monospace'],
                        script: ['Caveat', 'cursive'],
                    },
                    colors: {
                        canvas: '#FAF5EC',
                        paper: '#FFFFFF',
                        ink: '#181528',
                        lime: '#D6FF3D',
                        magenta: '#FF2E7E',
                        cobalt: '#2B4CFF',
                        tangerine: '#FF5A14',
                        grape: '#8A3FFC',
                        sky: '#7EC4FB',
                        lemon: '#FFF9AA',
                    },
                    animation: {
                        marquee: 'marqueeX 26s linear infinite',
                        'marquee-rev': 'marqueeRev 30s linear infinite',
                        'float-soft': 'floatSoft 4s ease-in-out infinite',
                        'float-delay': 'floatSoft 5s ease-in-out 1.2s infinite',
                        'spin-slow': 'spinSlow 14s linear infinite',
                        'wobble': 'wobble 2.6s ease-in-out infinite',
                        'pop-in': 'popIn .5s cubic-bezier(.22,1,.36,1) both',
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
                        wobble: {
                            '0%, 100%': { transform: 'rotate(-3deg)' },
                            '50%': { transform: 'rotate(3deg)' },
                        },
                        popIn: {
                            '0%': { transform: 'scale(.8)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                    },
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15.0/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15.0/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15.0/dist/ScrollSmoother.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15.0/dist/SplitText.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    <style>
        body.preload .fx-hidden { opacity: 0 !important; }
        .char { display: inline-block; will-change: transform; }

        /* Grainy gradient grain layer */
        .grain::after {
            content: "";
            position: fixed;
            inset: 0;
            z-index: 60;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Niche marquee */
        @keyframes marqueeX { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .animate-marquee-x { animation: marqueeX 34s linear infinite; }

        .ink-btn { transition: transform .25s cubic-bezier(.32,.72,0,1), background-color .25s, box-shadow .25s; }
        .ink-btn:hover { transform: translateY(-2px); box-shadow: 6px 6px 0 #D6FF3D; }
        .ink-btn:active { transform: translateY(0) scale(.96); }

        /* Ransom-note type */
        .ransom { display: inline-block; border: 2px solid #181528; box-shadow: 4px 4px 0 #181528; line-height: .92; }
        .ransom:hover { animation: wobble .5s ease-in-out; }

        .mask-line { overflow: hidden; }
        .sticker { transition: transform .3s cubic-bezier(.32,.72,0,1); }
        .sticker:hover { transform: rotate(0deg) scale(1.04); }

        .talent-card img { transition: transform .7s cubic-bezier(.32,.72,0,1); }
        .talent-card:hover img { transform: scale(1.06); }

        /* Vertical range sliders */
        input[type="range"].pop-range { -webkit-appearance: none; appearance: none; height: 8px; border-radius: 9999px; background: rgba(255,255,255,.15); outline: none; }
        input[type="range"].pop-range::-webkit-slider-thumb { -webkit-appearance: none; appearance: none; width: 26px; height: 26px; border-radius: 9999px; background: #D6FF3D; border: 3px solid #181528; cursor: grab; box-shadow: 0 0 0 4px rgba(214,255,61,.25); }
        input[type="range"].pop-range::-moz-range-thumb { width: 26px; height: 26px; border-radius: 9999px; background: #D6FF3D; border: 3px solid #181528; cursor: grab; }

        /* =============================================================
           REEL STORIES — sticker rail (self-contained section)
           Tokens are scoped to .reel-stories so the rest of the page
           keeps its own palette. Sticker surfaces (lime / pink) keep a
           constant navy so their contrast survives the dark-mode flip.
           ============================================================= */
        .reel-stories {
            --bg: #f8f3ea;
            --ink: #1a1830;
            --lime: #d8ff3e;
            --blue: #2b4bff;
            --pink: #fbd0dc;
            --muted: #6b6878;
            --navy: #1a1830;
            background: var(--bg);
            color: var(--ink);
            overflow: hidden;
            padding: clamp(56px, 7vw, 88px) 0 clamp(40px, 5vw, 64px);
            font-family: "Plus Jakarta Sans", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }
        @media (prefers-color-scheme: dark) {
            .reel-stories {
                --bg: #12101f;
                --ink: #f8f3ea;
                --muted: #a9a5b8;
            }
        }
        /* Container: 1186px so the whole rail fits — 4 x 260px cards + 3 x 22px gaps
           = 1106px, plus 16px corner clearance per side = 1138px row content,
           plus 48px page padding = 1186px. */
        .rs-inner { max-width: 1186px; margin: 0 auto; padding: 0 24px; }

        /* Header: pill tag + heading + lead */
        .rs-tag {
            display: inline-flex;
            align-items: center;
            padding: 5px 14px;
            background: var(--pink);
            color: var(--navy);
            border: 2px solid var(--navy);
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .1em;
        }
        .rs-heading {
            margin: 18px 0 0;
            font-size: clamp(34px, 6vw, 58px);
            line-height: .98;
            letter-spacing: -.03em;
            font-weight: 800;
            color: var(--ink);
        }
        .rs-serif { font-family: Georgia, "Times New Roman", serif; font-style: italic; font-weight: 400; color: var(--blue); }
        .rs-lead {
            margin: 16px 0 0;
            max-width: 560px;
            font-size: 13px;
            line-height: 1.65;
            color: var(--muted);
        }

        /* Rail */
        .rs-row {
            display: flex;
            gap: 22px;
            overflow-x: auto;
            margin-top: 40px;
            /* 16px side padding keeps the tilted card corners (they poke ~11px past
               their box) from being clipped by the scroll container. */
            padding: 26px 16px 34px;
            scroll-snap-type: x proximity;
            scroll-padding-left: 16px;
        }
        .rs-card {
            position: relative;
            flex: 0 0 auto;
            width: 260px;
            z-index: 1;
            transition: opacity .6s ease, transform .6s cubic-bezier(.22, 1, .36, 1);
            transition-delay: calc(var(--i, 0) * 60ms);
        }
        /* Hidden states only apply once the script has booted (.rs-anim) */
        .reel-stories.rs-anim .rs-card { opacity: 0; transform: translateY(26px); }
        .reel-stories.rs-anim .rs-card.is-in { opacity: 1; transform: none; }
        .rs-card:hover { z-index: 3; }
        .rs-card-inner {
            position: relative;
            width: 260px;
            height: 420px;
            padding: 18px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            border: 3px solid var(--ink);
            border-radius: 30px;
            box-shadow: 10px 10px 0 var(--lime);
            background-image: linear-gradient(160deg, var(--c1), var(--c2) var(--c2s, 70%));
            color: #fff;
            transform: rotate(var(--rot, 0deg)) translateY(var(--shift, 0px));
            transition: transform .3s cubic-bezier(.3, 1.6, .5, 1);
            scroll-snap-align: start;
        }
        .rs-card:hover .rs-card-inner { transform: rotate(0deg) scale(1.06) translateY(-8px); }

        /* Reel layer: poster frame -> video -> scrim. The poster keeps the card
           attractive while the clip buffers and stays put if the clip fails. */
        .rs-media { position: absolute; inset: 0; border-radius: inherit; overflow: hidden; }
        .rs-poster { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0; }
        .rs-video { position: relative; z-index: 1; display: block; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity .45s ease; }
        .rs-video.is-loaded { opacity: 1; }
        .rs-scrim { position: absolute; inset: 0; z-index: 2; background: linear-gradient(to top, rgba(0,0,0,.62), rgba(0,0,0,.06) 55%, rgba(0,0,0,.28)); }

        /* Sticker badge */
        .rs-badge {
            position: absolute;
            top: -14px;
            right: -12px;
            z-index: 5;
            padding: 6px 12px;
            background: var(--lime);
            color: var(--navy);
            border: 2px solid var(--navy);
            border-radius: 999px;
            box-shadow: 3px 3px 0 var(--ink);
            font-size: 12px;
            font-weight: 800;
            line-height: 1;
            white-space: nowrap;
            transform: rotate(8deg);
        }
        .rs-badge--left { left: -12px; right: auto; background: var(--pink); transform: rotate(-8deg); }

        /* Card body */
        .rs-body { position: relative; z-index: 3; }
        .rs-place {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            background: rgba(255,255,255,.18);
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 999px;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .08em;
        }
        .rs-pin { width: 9px; height: 9px; fill: var(--lime); }
        .rs-card-title { margin: 10px 0 14px; font-size: 22px; line-height: 1.1; font-weight: 800; color: #fff; }
        .rs-foot { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .rs-handle { font-size: 12px; font-weight: 700; color: rgba(255,255,255,.92); }
        .rs-play {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding-left: 2px;
            background: var(--lime);
            color: var(--navy);
            border: 2px solid var(--navy);
            border-radius: 50%;
            font-size: 13px;
            line-height: 1;
            cursor: pointer;
            transition: transform .25s cubic-bezier(.3, 1.6, .5, 1);
        }
        .rs-play:hover { transform: scale(1.08) rotate(-6deg); }
        .rs-play .fa-pause { display: none; }
        .rs-play.is-playing .fa-play { display: none; }
        .rs-play.is-playing .fa-pause { display: inline-block; }

        /* Sound toggle — muted by default, one click to hear the reel */
        .rs-mute {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .18);
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 50%;
            color: #fff;
            font-size: 11px;
            line-height: 1;
            cursor: pointer;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            transition: transform .25s cubic-bezier(.3, 1.6, .5, 1), background-color .25s, color .25s;
        }
        .rs-mute:hover { transform: scale(1.08); background: rgba(255, 255, 255, .3); }
        .rs-mute.is-on { background: var(--lime); border-color: var(--navy); color: var(--navy); }

        /* Story-style watch progress */
        .rs-progress {
            position: absolute;
            left: 20px;
            right: 20px;
            bottom: 10px;
            height: 3px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .3);
            overflow: hidden;
            z-index: 4;
            opacity: 0;
            transition: opacity .35s ease;
        }
        .rs-progress.is-live { opacity: 1; }
        .rs-progress span {
            display: block;
            width: 0;
            height: 100%;
            border-radius: inherit;
            background: var(--lime);
        }

        /* Scroll reveal (vanilla JS adds .is-in) */
        .rs-reveal { transition: opacity .7s ease, transform .7s cubic-bezier(.22, 1, .36, 1); }
        .reel-stories.rs-anim .rs-reveal { opacity: 0; transform: translateY(22px); }
        .reel-stories.rs-anim .rs-reveal.is-in { opacity: 1; transform: none; }

        @media (prefers-reduced-motion: reduce) {
            .rs-reveal, .rs-card { opacity: 1 !important; transform: none !important; }
        }

        /* Swipe deck */
        .match-card { touch-action: none; will-change: transform; }
        .match-stamp { opacity: 0; transition: opacity .15s linear; }

        /* Vibe quiz */
        .vibe-opt { transition: transform .2s cubic-bezier(.32,.72,0,1), background-color .2s, border-color .2s; }
        .vibe-opt:hover { transform: translateY(-3px) rotate(-1deg); }
        .vibe-opt.chosen { background: #181528; color: #D6FF3D; border-color: #181528; }

        .xp-fill { transform-origin: left; transition: transform .5s cubic-bezier(.32,.72,0,1); }

        /* ===== Hero + nav design tokens (change colours in one place) ===== */
        :root {
            --hm-bg: #f4efff;
            --hm-ink: #17112b;
            --hm-line: #17112b;
            --hm-card: #ffffff;
            --hm-lime: #d4ff3a;
            --hm-pink: #ff4fa3;
            --hm-blue: #4a3cff;
            --hm-muted: rgba(23, 17, 43, .62);
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --hm-bg: #0e0b1a;
                --hm-ink: #f5f1ff;
                --hm-line: #f5f1ff;
                --hm-card: #1b1630;
                --hm-lime: #d4ff3a;
                --hm-pink: #ff6cb3;
                --hm-blue: #8b80ff;
                --hm-muted: rgba(245, 241, 255, .66);
            }
        }
        .hm-root { background: var(--hm-bg); color: var(--hm-ink); }
        .hm-glow { position: absolute; border-radius: 9999px; filter: blur(90px); pointer-events: none; z-index: 0; }

        /* Mockups pop in (one staggered entrance) */
        .mock-pop { animation: mockPop .6s cubic-bezier(.22,1,.36,1) both; }
        @keyframes mockPop { from { opacity: 0; transform: scale(.85) translateY(16px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .d1 { animation-delay: .05s; } .d2 { animation-delay: .15s; } .d3 { animation-delay: .25s; } .d4 { animation-delay: .35s; } .d5 { animation-delay: .45s; }

        /* Neo-brutalist card + button */
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

        a:focus-visible, button:focus-visible { outline: 3px solid var(--hm-blue); outline-offset: 2px; }

        .sticker-lime { background: var(--hm-lime); color: var(--hm-line); border: 2px solid var(--hm-line); box-shadow: 4px 4px 0 var(--hm-line); }
        .grad-text2 { background-image: linear-gradient(100deg, var(--hm-blue), var(--hm-pink)); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .script-accent { font-family: 'Caveat', cursive; color: var(--hm-pink); }

        /* ScrollSmoother scaffolding */
        #smooth-wrapper { overflow: hidden; }
        #smooth-content { width: 100%; }
        body { overscroll-behavior: none; }

        /* Fixed scroll progress bar (tracks #smooth-content scroll) */
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 70;
            height: 3px;
            width: 100%;
            transform: scaleX(0);
            transform-origin: left center;
            background: linear-gradient(90deg, var(--hm-blue), var(--hm-pink), var(--hm-lime));
            pointer-events: none;
        }

        @media (prefers-reduced-motion: reduce) {
            .mock-pop { animation: none !important; opacity: 1 !important; }
        }

        /* Immersive paper-punch footer */
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

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
        }
    </style>
</head>

<body class="preload grain bg-canvas text-ink font-sans min-h-screen overflow-x-hidden">
    <div class="scroll-progress" id="scrollProgress" aria-hidden="true"></div>

    <div id="smooth-wrapper">
        <div id="smooth-content">
    <main class="overflow-x-hidden w-full max-w-full relative">

        <!-- ===================== HERO ===================== -->
        <section id="hero" class="hm-root relative isolate overflow-hidden pb-10 pt-32 sm:pt-36 lg:pb-16">
            <!-- two blurred colour glows (pink + blue) -->
            <div aria-hidden="true" class="hm-glow -left-24 top-16 h-[26rem] w-[26rem] bg-[var(--hm-pink)] opacity-30 sm:h-[34rem] sm:w-[34rem]"></div>
            <div aria-hidden="true" class="hm-glow -right-24 top-40 h-[26rem] w-[26rem] bg-[var(--hm-blue)] opacity-25 sm:h-[34rem] sm:w-[34rem]"></div>

            <div class="relative z-10 mx-auto grid w-full max-w-7xl grid-cols-1 items-center gap-14 px-5 sm:px-8 lg:grid-cols-2 lg:gap-10">
                <!-- ============ LEFT: copy ============ -->
                <div id="heroCopy" class="text-center lg:text-left">
                    <span id="heroBadge" class="fx-hidden inline-flex -rotate-2 items-center gap-2 rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-card)] px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-[var(--hm-ink)] shadow-[3px_3px_0_var(--hm-line)]">
                        <span class="h-2 w-2 rounded-full bg-[var(--hm-pink)]"></span>
                        Creator marketplace &mdash; live now
                    </span>

                    <h1 id="heroTitle" class="fx-hidden mt-6 font-display font-extrabold leading-[0.95] tracking-[-0.035em] text-[var(--hm-ink)]" style="font-size: clamp(2.6rem, 7vw, 5.6rem)">
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

                    <p id="heroSub" class="fx-hidden mx-auto mt-6 max-w-xl text-base font-medium leading-relaxed text-[var(--hm-muted)] lg:mx-0 sm:text-lg">
                        Swipe the roster, watch the reels, pick your vibe. Then lock in escrow-safe payouts with verified Instagram creators. It feels like your feed, not a spreadsheet.
                    </p>

                    <div id="heroCtas" class="fx-hidden mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row lg:justify-start">
                        <button type="button" data-confetti class="hm-btn inline-flex items-center gap-2 rounded-full bg-[var(--hm-lime)] px-7 py-3.5 text-sm font-extrabold text-[var(--hm-line)]" onclick="location.href='{{ route('register') }}'">
                            Start free <span aria-hidden="true">&#10024;</span>
                        </button>
                        <a href="#stories" class="hm-btn inline-flex items-center gap-2 rounded-full bg-[var(--hm-card)] px-7 py-3.5 text-sm font-extrabold text-[var(--hm-ink)]">
                            <i class="fa-solid fa-play text-[10px] text-[var(--hm-pink)]"></i> Watch the reels
                        </a>
                    </div>

                    <!-- social proof -->
                    <div id="heroProof" class="fx-hidden mt-9 flex flex-col items-center gap-4 sm:flex-row lg:justify-start">
                        <div class="flex -space-x-3">
                            <span class="h-10 w-10 rounded-full border-2 border-[var(--hm-line)]" style="background-image: linear-gradient(135deg, var(--hm-pink), var(--hm-blue))"></span>
                            <span class="h-10 w-10 rounded-full border-2 border-[var(--hm-line)]" style="background-image: linear-gradient(135deg, var(--hm-lime), var(--hm-blue))"></span>
                            <span class="h-10 w-10 rounded-full border-2 border-[var(--hm-line)]" style="background-image: linear-gradient(135deg, var(--hm-pink), var(--hm-lime))"></span>
                            <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-ink)] text-[10px] font-extrabold text-[var(--hm-lime)]">12K</span>
                        </div>
                        <div class="text-center sm:text-left">
                            <p class="font-display text-sm font-extrabold text-[var(--hm-ink)]">12,800+ verified creators</p>
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
                                <div class="relative aspect-[9/16] overflow-hidden rounded-[1rem]" style="background-image: linear-gradient(150deg, var(--hm-blue), var(--hm-pink))">
                                    <div class="absolute inset-x-0 top-0 flex items-center justify-between p-3">
                                        <span class="inline-flex items-center gap-1 rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-pink)] px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-white">LIVE</span>
                                        <span class="rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-card)] px-2 py-0.5 text-[9px] font-bold text-[var(--hm-ink)]">@ananya.model</span>
                                    </div>
                                    <div class="absolute bottom-24 right-3 flex flex-col items-center gap-4 text-white">
                                        <span class="flex flex-col items-center gap-0.5"><i class="fa-solid fa-heart text-xl text-[var(--hm-pink)]"></i><span class="text-[10px] font-bold">84K</span></span>
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
                                <div class="relative aspect-[4/5] overflow-hidden rounded-xl" style="background-image: linear-gradient(160deg, var(--hm-lime), var(--hm-blue))">
                                    <span class="absolute right-2 top-2 rotate-6 rounded-lg border-2 border-[var(--hm-line)] bg-[var(--hm-card)] px-2 py-0.5 font-display text-xs font-extrabold text-[var(--hm-line)]">MATCH</span>
                                </div>
                                <div class="mt-2">
                                    <p class="font-display text-sm font-extrabold text-[var(--hm-ink)]">Zoya Khan</p>
                                    <p class="text-[11px] font-semibold text-[var(--hm-muted)]">Delhi &bull; Dance &bull; 480K</p>
                                </div>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-card)]"><i class="fa-solid fa-xmark text-[11px] text-[var(--hm-ink)]"></i></span>
                                    <span class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-card)]"><i class="fa-solid fa-star text-[11px] text-[var(--hm-blue)]"></i></span>
                                    <span class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-pink)]"><i class="fa-solid fa-heart text-[11px] text-white"></i></span>
                                </div>
                            </div>
                        </div>

                        <!-- 3. payout (lime) -->
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
                                        <circle cx="18" cy="18" r="15.5" fill="none" stroke="var(--hm-pink)" stroke-width="4" stroke-linecap="round" stroke-dasharray="97.4" stroke-dashoffset="5.8"></circle>
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
                                <p class="mt-2 text-right text-[10px] font-bold text-[var(--hm-blue)]"><i class="fa-solid fa-check-double"></i> Deal locked in escrow</p>
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
                        <span class="flex items-center gap-8 font-display text-lg font-extrabold uppercase tracking-tight text-[var(--hm-ink)]">{{ $niche }}<i class="fa-solid fa-bolt text-[11px] text-[var(--hm-pink)]"></i></span>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-8 pr-8">
                        @foreach ($niches as $niche)
                        <span class="flex items-center gap-8 font-display text-lg font-extrabold uppercase tracking-tight text-[var(--hm-ink)]">{{ $niche }}<i class="fa-solid fa-bolt text-[11px] text-[var(--hm-pink)]"></i></span>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== REEL STORIES (sticker rail) ===================== -->
        <section id="stories" class="reel-stories">
            <div class="rs-inner">
                <!-- 1 · Pill tag -->
                <span class="rs-tag rs-reveal">REEL STORIES</span>

                <!-- 2 · Heading -->
                <h2 class="rs-heading rs-reveal">Short-form,<br>long story. <em class="rs-serif">Scroll it.</em></h2>

                <!-- 3 · Lead paragraph -->
                <p class="rs-lead rs-reveal">Autoplaying, unmuted-optional, always-on reels from the roster. Each card is a chapter &mdash; read them like a story.</p>
            </div>

            <!-- 4 · Reel cards — rendered from the JS data array below -->
            <div class="rs-inner">
                <div class="rs-row no-scrollbar" id="rsRow"></div>
            </div>
        </section>

        <script>
            /* =============================================================
               REEL STORIES — reel library, card data + renderer
               Framework-free. Every card draws a random clip from its own
               theme pool on each page load, so the rail never repeats
               itself and no two cards show the same reel.
               ============================================================= */
            (() => {
                const CD = 'https://cdn.coverr.co/videos';
                const clip = (id) => ({
                    src: `${CD}/${id}/720p.mp4`,
                    poster: `${CD}/${id}/thumbnail?width=560`
                });

                const REEL_LIBRARY = {
                    fashion: [
                        clip('coverr-temp-gen-3-alpha-turbo-4010599000-parisianstreetfash-m-5-mp4-4750'),
                        clip('user-ai-generation-4u6KTwZOVa3Y'),
                        clip('user-ai-generation-PcuCvB12ZMyg'),
                        clip('user-ai-generation-KTMRBOIVNjoz'),
                        clip('user-ai-generation-d3XAUBVDSgYB'),
                        clip('coverr-girl-posing-on-the-edge-of-a-terrace-9533'),
                        clip('coverr-woman-staring-into-the-camera-4258')
                    ],
                    beauty: [
                        clip('coverr-temp-professionalmode9x16macrotowidetransitionshot6-mp4-5960'),
                        clip('user-ai-generation-YbPk2NsnjntP'),
                        clip('coverr-a-makeup-artist-applying-makeup-1127'),
                        clip('coverr-makeup-artist-applies-red-lipstick-8795'),
                        clip('coverr-cosmic-blue-glitter-makeup-close-up'),
                        clip('coverr-woman-taking-a-selfie-with-makeup-on-7110')
                    ],
                    tech: [
                        clip('user-ai-generation-IsDQn0PEUQeR'),
                        clip('user-ai-generation-9sF70EOySV2P'),
                        clip('user-ai-generation-EUlJuQpDXVVj'),
                        clip('coverr-cloaked-figure-standing-next-to-a-futuristic-car'),
                        clip('coverr-man-in-front-of-a-neon-sign-7353'),
                        clip('coverr-people-trying-vr-for-the-first-time-5800')
                    ],
                    host: [
                        clip('coverr-having-fun-at-a-concert-3590'),
                        clip('coverr-temp-yrevgrainy1977disco202505231653-mp4-2416'),
                        clip('coverr-temp-iwx4grainy1977disco202505231653-1-mp4-1736'),
                        clip('coverr-live-music-concert-5249'),
                        clip('coverr-confetti-and-party-poppers-6906'),
                        clip('coverr-friends-raising-a-toast-7037')
                    ]
                };

                const REELS = [
                    { badge: '🔥 12.4K', city: 'MUMBAI',    title: 'Runway to reels in 48h', handle: '@ananya.model', rot: '-3deg', shift: '0px',  from: '#2f6b3a', to: '#142a1a', stop: '70%', side: 'right', themes: ['fashion'] },
                    { badge: '👀 8.1K',  city: 'DELHI',     title: 'The 8.8% ER truth',     handle: '@zoya.moves',   rot: '2deg',  shift: '18px', from: '#c2410c', to: '#3b0d3b', stop: '75%', side: 'left',  themes: ['beauty'] },
                    { badge: '🎮 21K',   city: 'BENGALURU', title: 'Gaming drops, zero flops', handle: '@arjun.reels', rot: '-2deg', shift: '0px',  from: '#3b82f6', to: '#1a1830', stop: '75%', side: 'right', themes: ['tech'] },
                    { badge: '🎤 5.6K',  city: 'PUNE',      title: 'Hosting a room of 500', handle: '@diya.grid',    rot: '3deg',  shift: '14px', from: '#ec4899', to: '#2b1055', stop: '75%', side: 'left',  themes: ['host'] }
                ];

                const section = document.querySelector('.reel-stories');
                const row = document.getElementById('rsRow');
                if (!section || !row) { return; }

                /* Boot flag: hides the reveal targets only when JS is alive */
                section.classList.add('rs-anim');

                const PIN = '<svg class="rs-pin" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.6a2.6 2.6 0 1 1 0-5.2 2.6 2.6 0 0 1 0 5.2Z"/></svg>';

                /* ---- build a shuffled deck so every card gets a fresh reel ---- */
                const deck = [];
                Object.keys(REEL_LIBRARY).forEach((theme) => {
                    REEL_LIBRARY[theme].forEach((item) => deck.push({ theme: theme, src: item.src, poster: item.poster }));
                });
                for (let i = deck.length - 1; i > 0; i -= 1) {
                    const j = Math.floor(Math.random() * (i + 1));
                    const swap = deck[i];
                    deck[i] = deck[j];
                    deck[j] = swap;
                }
                const drawClip = (themes) => {
                    const index = deck.findIndex((item) => themes.indexOf(item.theme) !== -1);
                    if (index === -1) { return deck.shift(); }
                    return deck.splice(index, 1)[0];
                };

                /* ---- render the cards ---- */
                row.innerHTML = REELS.map((r, i) => {
                    const reel = drawClip(r.themes);
                    const media = `<img class="rs-poster" src="${reel.poster}" alt="" loading="lazy" decoding="async"><video class="rs-video" muted loop playsinline preload="metadata" aria-label="${r.title}"><source src="${reel.src}" type="video/mp4"></video><div class="rs-scrim"></div>`;

                    return `<article class="rs-card" style="--i:${i};--rot:${r.rot};--shift:${r.shift};--c1:${r.from};--c2:${r.to};--c2s:${r.stop}">
                        <div class="rs-card-inner">
                            <div class="rs-media">${media}</div>
                            <span class="rs-badge${r.side === 'left' ? ' rs-badge--left' : ''}">${r.badge}</span>
                            <div class="rs-body">
                                <span class="rs-place">${PIN}${r.city}</span>
                                <h3 class="rs-card-title">${r.title}</h3>
                                <div class="rs-foot">
                                    <span class="rs-handle">${r.handle}</span>
                                    <button class="rs-mute" type="button" aria-label="Toggle sound"><i class="fa-solid fa-volume-x"></i></button>
                                    <button class="rs-play" type="button" aria-label="Play ${r.title}"><i class="fa-solid fa-play"></i></button>
                                </div>
                            </div>
                            <div class="rs-progress" aria-hidden="true"><span></span></div>
                        </div>
                    </article>`;
                }).join('');

                /* ---- reveal on scroll ---- */
                const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const reveals = Array.from(section.querySelectorAll('.rs-reveal, .rs-card'));

                if (reduce || !('IntersectionObserver' in window)) {
                    reveals.forEach((el) => el.classList.add('is-in'));
                } else {
                    const io = new IntersectionObserver((entries) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('is-in');
                                io.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
                    reveals.forEach((el) => io.observe(el));
                }

                /* ---- reel plumbing: load state, progress, sound ---- */
                row.querySelectorAll('.rs-card').forEach((card) => {
                    const video = card.querySelector('video');
                    const source = video ? video.querySelector('source') : null;
                    const playButton = card.querySelector('.rs-play');
                    const muteButton = card.querySelector('.rs-mute');
                    const progress = card.querySelector('.rs-progress');
                    const bar = progress ? progress.querySelector('span') : null;
                    if (!video) { return; }

                    const setPlaying = (playing) => {
                        if (playButton) { playButton.classList.toggle('is-playing', playing); }
                        if (progress) { progress.classList.toggle('is-live', playing); }
                    };

                    const setSound = () => {
                        if (!muteButton) { return; }
                        const on = !video.muted;
                        muteButton.classList.toggle('is-on', on);
                        muteButton.innerHTML = `<i class="fa-solid fa-volume-${on ? 'high' : 'x'}"></i>`;
                    };

                    video.addEventListener('loadeddata', () => video.classList.add('is-loaded'));
                    video.addEventListener('play', () => setPlaying(true));
                    video.addEventListener('pause', () => setPlaying(false));
                    video.addEventListener('timeupdate', () => {
                        if (bar && video.duration) {
                            bar.style.width = `${Math.min(100, (video.currentTime / video.duration) * 100)}%`;
                        }
                    });

                    /* A dead clip keeps its poster frame instead of a black box */
                    const fail = () => {
                        video.classList.remove('is-loaded');
                        video.style.display = 'none';
                        setPlaying(false);
                    };
                    video.addEventListener('error', fail);
                    if (source) { source.addEventListener('error', fail); }

                    if (muteButton) {
                        muteButton.addEventListener('click', () => {
                            video.muted = !video.muted;
                            setSound();
                            if (video.paused) { video.play().catch(() => {}); }
                        });
                    }
                });

                /* ---- muted autoplay while the reel is on screen ---- */
                const videos = Array.from(row.querySelectorAll('video'));
                if (videos.length && 'IntersectionObserver' in window && !reduce) {
                    const vio = new IntersectionObserver((entries) => {
                        entries.forEach((entry) => {
                            const video = entry.target;
                            if (entry.isIntersecting && entry.intersectionRatio > 0.55) {
                                video.play().catch(() => {});
                            } else {
                                video.pause();
                            }
                        });
                    }, { threshold: [0, 0.55, 1] });
                    videos.forEach((v) => vio.observe(v));
                }

                /* ---- play button toggles the reel (and wakes the sound up) ---- */
                row.addEventListener('click', (event) => {
                    const button = event.target.closest('.rs-play');
                    if (!button) { return; }
                    const card = button.closest('.rs-card');
                    const video = card ? card.querySelector('video') : null;
                    if (!video) { return; }
                    if (video.paused) {
                        video.muted = false;
                        const muteButton = card.querySelector('.rs-mute');
                        if (muteButton) {
                            muteButton.classList.add('is-on');
                            muteButton.innerHTML = '<i class="fa-solid fa-volume-high"></i>';
                        }
                        video.play().catch(() => {});
                    } else {
                        video.pause();
                    }
                });
            })();
        </script>


        <!-- ===================== PICK-YOUR-VIBE QUIZ (GAMIFICATION) ===================== -->
        <section id="vibe" class="relative bg-lime border-y-2 border-ink overflow-hidden">
            <div aria-hidden="true" class="absolute -top-24 right-0 w-80 h-80 rounded-full bg-magenta/30 blur-3xl"></div>
            <div aria-hidden="true" class="absolute -bottom-24 left-0 w-80 h-80 rounded-full bg-cobalt/20 blur-3xl"></div>
            <div class="relative max-w-6xl mx-auto px-6 py-24 md:py-36 grid lg:grid-cols-2 gap-14 items-center">
                <div>
                    <span class="reveal inline-flex items-center gap-2 rounded-full bg-ink text-lime px-4 py-1.5 text-[11px] font-mono font-bold uppercase tracking-[0.2em]">
                        <i class="fa-solid fa-gamepad"></i> Play your vibe
                    </span>
                    <h2 class="reveal mt-5 font-display font-black text-ink leading-[1.02] tracking-tight" style="font-size: clamp(2.2rem, 4.6vw, 4rem)">
                        Three taps.<br>Zero <span class="font-editorial italic text-[#FF2E7E]">guesswork.</span>
                    </h2>
                    <p class="reveal mt-5 max-w-md text-ink/70 font-medium leading-relaxed">
                        Tell us your vibe and we'll line up the roster that fits. Finish the round and we'll pop the confetti.
                    </p>
                    <div class="reveal mt-8 flex items-center gap-4">
                        <div class="flex-1">
                            <div class="flex items-center justify-between font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60">
                                <span>Creator XP</span>
                                <span><span id="xpValue">0</span> XP</span>
                            </div>
                            <div class="mt-2 h-3 rounded-full bg-ink/10 border-2 border-ink overflow-hidden">
                                <div id="xpFill" class="xp-fill h-full w-full bg-ink" style="transform:scaleX(0)"></div>
                            </div>
                        </div>
                        <span id="xpBadge" class="hidden shrink-0 font-ransom font-extrabold text-xs bg-magenta text-white border-2 border-ink rounded-full px-3 py-2">VIBE MATCH!</span>
                    </div>
                </div>

                <div class="relative bg-paper border-2 border-ink rounded-[2rem] p-6 sm:p-8 shadow-[12px_12px_0_#181528]">
                    <div class="flex items-center justify-between mb-6">
                        <span class="font-mono text-[11px] font-bold uppercase tracking-widest text-ink/50">Vibe check</span>
                        <span class="font-mono text-[11px] font-bold uppercase tracking-widest text-ink/50"><span id="vibeStep">1</span> / 3</span>
                    </div>

                    <div class="quiz-stage" data-stage="1">
                        <p class="font-display font-black text-xl mb-4">What are we making?</p>
                        <div class="grid gap-3">
                            <button class="vibe-opt text-left rounded-2xl border-2 border-ink/15 px-5 py-4 font-bold flex items-center gap-3" data-vibe="fashion"><i class="fa-solid fa-shirt text-[#FF2E7E]"></i> A fashion drop</button>
                            <button class="vibe-opt text-left rounded-2xl border-2 border-ink/15 px-5 py-4 font-bold flex items-center gap-3" data-vibe="reels"><i class="fa-solid fa-mobile-screen text-[#2B4CFF]"></i> Viral reel noise</button>
                            <button class="vibe-opt text-left rounded-2xl border-2 border-ink/15 px-5 py-4 font-bold flex items-center gap-3" data-vibe="anchor"><i class="fa-solid fa-microphone-lines text-[#FF5A14]"></i> An event to host</button>
                        </div>
                    </div>

                    <div class="quiz-stage hidden" data-stage="2">
                        <p class="font-display font-black text-xl mb-4">What's the energy?</p>
                        <div class="grid gap-3">
                            <button class="vibe-opt text-left rounded-2xl border-2 border-ink/15 px-5 py-4 font-bold flex items-center gap-3" data-vibe="fashion"><i class="fa-solid fa-gem"></i> Editorial &amp; glossy</button>
                            <button class="vibe-opt text-left rounded-2xl border-2 border-ink/15 px-5 py-4 font-bold flex items-center gap-3" data-vibe="reels"><i class="fa-solid fa-fire"></i> Fast &amp; chaotic</button>
                            <button class="vibe-opt text-left rounded-2xl border-2 border-ink/15 px-5 py-4 font-bold flex items-center gap-3" data-vibe="anchor"><i class="fa-solid fa-star"></i> Polished &amp; live</button>
                        </div>
                    </div>

                    <div class="quiz-stage hidden" data-stage="3">
                        <p class="font-display font-black text-xl mb-4">The budget vibe?</p>
                        <div class="grid gap-3">
                            <button class="vibe-opt text-left rounded-2xl border-2 border-ink/15 px-5 py-4 font-bold flex items-center gap-3" data-vibe="fashion"><i class="fa-solid fa-gem"></i> Premium</button>
                            <button class="vibe-opt text-left rounded-2xl border-2 border-ink/15 px-5 py-4 font-bold flex items-center gap-3" data-vibe="reels"><i class="fa-solid fa-bolt text-[#2B4CFF]"></i> Value-smart</button>
                            <button class="vibe-opt text-left rounded-2xl border-2 border-ink/15 px-5 py-4 font-bold flex items-center gap-3" data-vibe="anchor"><i class="fa-solid fa-handshake text-[#FF5A14]"></i> Long-term partner</button>
                        </div>
                    </div>

                    <div id="vibeResult" class="hidden text-center py-4 animate-pop-in">
                        <div class="w-16 h-16 mx-auto rounded-full bg-lime border-2 border-ink flex items-center justify-center text-2xl"><i class="fa-solid fa-bolt"></i></span></div>
                        <p class="mt-4 font-mono text-[11px] font-bold uppercase tracking-widest text-ink/50">Your roster vibe</p>
                        <p id="vibeResultName" class="mt-2 font-display font-black text-3xl">Reels Creator</p>
                        <p id="vibeResultCopy" class="mt-3 text-sm text-ink/65 font-medium max-w-sm mx-auto">Fast-moving reel makers with verified reach and 2x engagement.</p>
                        <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">
                            <a id="vibeCta" href="#roster" class="inline-flex items-center justify-center gap-2 rounded-full bg-ink text-white font-extrabold text-sm px-6 py-3 ink-btn">Meet the roster <i class="fa-solid fa-arrow-down text-[10px]"></i></a>
                            <button id="vibeReset" class="inline-flex items-center justify-center gap-2 rounded-full bg-paper border-2 border-ink text-ink font-bold text-sm px-6 py-3">Play again</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== SWIPE-TO-MATCH ROSTER ===================== -->
        <section id="roster" class="relative bg-grape text-white border-y-2 border-ink overflow-hidden">
            <div aria-hidden="true" class="absolute top-10 -left-20 w-80 h-80 rounded-full bg-magenta/40 blur-3xl"></div>
            <div aria-hidden="true" class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-cobalt/40 blur-3xl"></div>
            <div class="relative max-w-6xl mx-auto px-6 py-24 md:py-36 grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="reveal inline-flex items-center gap-2 rounded-full bg-white/15 backdrop-blur border border-white/30 px-4 py-1.5 text-[11px] font-mono font-bold uppercase tracking-[0.2em]">
                        <i class="fa-solid fa-hand-pointer"></i> Swipe the roster
                    </button>
                    </span>
                    <h2 class="reveal mt-5 font-display font-black leading-[1.02] tracking-tight" style="font-size: clamp(2.2rem, 4.6vw, 4rem)">
                        Left to pass.<br>Right to <span class="font-editorial italic text-lime">shortlist.</span>
                    </h2>
                    <p class="reveal mt-5 max-w-md text-white/70 font-medium leading-relaxed">
                        It's a marketplace, so we made browsing feel like matching. Match three and we'll celebrate for you.
                    </p>
                    <div class="reveal mt-8 flex items-center gap-6">
                        <div>
                            <p class="font-ransom font-extrabold text-3xl"><span id="matchCount">0</span></p>
                            <p class="font-mono text-[10px] font-bold uppercase tracking-widest text-white/60">Shortlisted</p>
                        </div>
                        <div class="h-10 w-px bg-white/20"></div>
                        <p class="max-w-[12rem] text-xs text-white/60 font-medium">Drag the top card. Release past the line to decide.</p>
                    </div>
                </div>

                <!-- Swipe deck -->
                <div class="flex justify-center">
                    <div id="matchDeck" class="relative w-[300px] h-[440px]">
                        @php
                            $deck = [
                                ['name' => 'Ananya Roy', 'handle' => '@ananya.model', 'niche' => 'Runway & Fashion', 'reach' => '1.2M', 'er' => '6.4%', 'img' => 'women/47'],
                                ['name' => 'Zoya Khan', 'handle' => '@zoya.moves', 'niche' => 'Beauty & Reels', 'reach' => '840K', 'er' => '8.8%', 'img' => 'women/65'],
                                ['name' => 'Meera Nair', 'handle' => '@meera.makes', 'niche' => 'Food & Lifestyle', 'reach' => '1.6M', 'er' => '5.1%', 'img' => 'women/68'],
                                ['name' => 'Arjun Verma', 'handle' => '@arjun.reels', 'niche' => 'Gaming Creator', 'reach' => '2.0M', 'er' => '7.2%', 'img' => 'men/32'],
                                ['name' => 'Diya Patel', 'handle' => '@diya.grid', 'niche' => 'Live Anchor & Host', 'reach' => '540K', 'er' => '9.3%', 'img' => 'women/90'],
                            ];
                        @endphp
                        @foreach ($deck as $i => $d)
                        <div class="match-card absolute inset-0 rounded-[2rem] bg-paper border-2 border-ink overflow-hidden shadow-[10px_10px_0_#181528]" data-index="{{ $i }}">
                            <div class="relative h-[62%] overflow-hidden">
                                <img src="https://randomuser.me/api/portraits/{{ $d['img'] }}.jpg" alt="{{ $d['name'] }}" class="w-full h-full object-cover pointer-events-none" draggable="false">
                                <span class="match-stamp match-stamp-like absolute top-6 left-6 -rotate-12 font-ransom font-extrabold text-2xl text-lime bg-ink border-2 border-lime rounded-xl px-4 py-2">MATCH</span>
                                <span class="match-stamp match-stamp-pass absolute top-6 right-6 rotate-12 font-ransom font-extrabold text-2xl text-white bg-[#FF2E7E] border-2 border-white rounded-xl px-4 py-2">PASS</span>
                            </div>
                            <div class="p-5 text-ink">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-display font-black text-xl">{{ $d['name'] }}</h3>
                                    <span class="w-6 h-6 rounded-full bg-lime border border-ink flex items-center justify-center text-[10px]"><i class="fa-solid fa-check"></i></span>
                                </div>
                                <p class="text-[12px] text-ink/55 font-semibold mt-0.5">{{ $d['niche'] }}</p>
                                <div class="mt-4 grid grid-cols-3 gap-2 border-t border-ink/10 pt-4">
                                    <div><p class="font-mono font-extrabold text-base">{{ $d['reach'] }}</p><p class="text-[9px] font-mono font-bold uppercase text-ink/45">Reach</p></div>
                                    <div><p class="font-mono font-extrabold text-base text-[#FF2E7E]">{{ $d['er'] }}</p><p class="text-[9px] font-mono font-bold uppercase text-ink/45">Eng. Rate</p></div>
                                    <div><p class="font-mono font-extrabold text-base">IG</p><p class="text-[9px] font-mono font-bold uppercase text-ink/45">Verified</p></div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Empty state -->
                        <div id="deckEmpty" class="hidden absolute inset-0 rounded-[2rem] bg-paper border-2 border-ink border-dashed flex flex-col items-center justify-center text-center p-8 text-ink">
                            <span class="w-16 h-16 rounded-full bg-lime border-2 border-ink flex items-center justify-center text-2xl"><i class="fa-solid fa-hand-sparkles"></i></span>
                            <p class="mt-5 font-display font-black text-xl">That's the whole roster.</p>
                            <p class="mt-2 text-sm text-ink/60 font-medium">You shortlisted <span id="deckMatched">0</span> creators.</p>
                            <button id="deckReset" class="mt-6 rounded-full bg-ink text-lime font-extrabold text-sm px-6 py-3 ink-btn">Replay the deck</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== GAMIFIED RATE ESTIMATOR ===================== -->
        <section id="estimate" class="relative bg-ink text-white border-y-2 border-ink overflow-hidden">
            <div aria-hidden="true" class="absolute inset-0 opacity-[0.06] bg-[linear-gradient(to_right,#D6FF3D_1px,transparent_1px)] bg-[size:90px_1px]"></div>
            <div class="relative max-w-6xl mx-auto px-6 py-24 md:py-32">
                <div class="max-w-2xl mb-12">
                    <span class="reveal inline-flex items-center gap-2 rounded-full bg-lime text-ink px-4 py-1.5 text-[11px] font-mono font-bold uppercase tracking-[0.2em]">
                        <i class="fa-solid fa-coins"></i> Get paid
                    </span>
                    <h2 class="reveal mt-5 font-display font-black leading-[1.02] tracking-tight" style="font-size: clamp(2.1rem, 4.4vw, 3.8rem)">
                        Slide. See. <span class="font-editorial italic text-lime">Get paid.</span>
                    </h2>
                    <p class="reveal mt-5 text-white/60 font-medium leading-relaxed max-w-xl">
                        Dial in your brief and watch the estimate move. Every number is escrow-protected and released on delivery.
                    </p>
                </div>

                <div class="grid lg:grid-cols-5 gap-8 items-stretch">
                    <!-- Controls -->
                    <div class="reveal lg:col-span-3 rounded-[2rem] border-2 border-white/15 bg-white/[0.03] p-7 sm:p-9 space-y-9">
                        <div>
                            <div class="flex items-center justify-between">
                                <label for="followers" class="font-mono text-[11px] font-bold uppercase tracking-widest text-white/60">Audience size</label>
                                <span id="followersOut" class="font-ransom font-extrabold text-lime text-sm">250K</span>
                            </div>
                            <input id="followers" type="range" min="10000" max="2000000" step="10000" value="250000" class="pop-range w-full mt-4">
                        </div>
                        <div>
                            <div class="flex items-center justify-between">
                                <label for="engagement" class="font-mono text-[11px] font-bold uppercase tracking-widest text-white/60">Engagement rate</label>
                                <span id="engagementOut" class="font-ransom font-extrabold text-lime text-sm">6.0%</span>
                            </div>
                            <input id="engagement" type="range" min="10" max="120" step="1" value="60" class="pop-range w-full mt-4">
                        </div>
                        <div>
                            <span class="font-mono text-[11px] font-bold uppercase tracking-widest text-white/60">Deliverables</span>
                            <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <button class="deliv-opt rounded-2xl border-2 border-white/15 px-3 py-3 text-xs font-bold hover:border-lime transition" data-mult="1">1 Reel</button>
                                <button class="deliv-opt chosen rounded-2xl border-2 border-lime bg-lime text-ink px-3 py-3 text-xs font-bold transition" data-mult="1.8">3 Stories</button>
                                <button class="deliv-opt rounded-2xl border-2 border-white/15 px-3 py-3 text-xs font-bold hover:border-lime transition" data-mult="2.6">Reel + Story</button>
                                <button class="deliv-opt rounded-2xl border-2 border-white/15 px-3 py-3 text-xs font-bold hover:border-lime transition" data-mult="4.2">Full Drop</button>
                            </div>
                        </div>
                    </div>

                    <!-- Output -->
                    <div class="reveal lg:col-span-2 rounded-[2rem] bg-lime text-ink border-2 border-ink p-7 sm:p-9 flex flex-col justify-between shadow-[10px_10px_0_#FF2E7E]">
                        <div>
                            <span class="font-mono text-[11px] font-bold uppercase tracking-widest text-ink/50">Estimated package</span>
                            <p class="mt-4 font-display font-black leading-none" style="font-size: clamp(2.6rem, 6vw, 4rem)">₹<span id="estimateValue">0</span></p>
                            <p class="mt-3 text-sm font-semibold text-ink/70">+ escrow protected &bull; 48h release max</p>
                        </div>
                        <div class="mt-8">
                            <div class="flex items-center justify-between font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60">
                                <span>Deal strength</span>
                                <span id="estimateTier">Solid</span>
                            </div>
                            <div class="mt-2 h-3 rounded-full bg-ink/15 border-2 border-ink overflow-hidden">
                                <div id="estimateBar" class="h-full bg-ink" style="width:55%"></div>
                            </div>
                            <button type="button" data-confetti class="mt-7 w-full rounded-full bg-ink text-lime font-extrabold text-sm py-3.5 ink-btn" onclick="location.href='{{ route('register') }}'">Lock this brief</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== RANSOM MANIFESTO (SCRUB) ===================== -->
        <section id="vibes" class="relative max-w-5xl mx-auto px-6 py-36 md:py-52">
            <span class="reveal inline-flex items-center gap-2 rounded-full bg-tangerine text-white border-2 border-ink px-4 py-1.5 text-[11px] font-mono font-bold uppercase tracking-[0.2em]">
                <i class="fa-solid fa-comment-dots"></i> The Vibes
            </span>
            <p id="manifesto" class="mt-10 font-display font-black leading-[1.16] tracking-tight text-ink" style="font-size: clamp(1.7rem, 3.6vw, 3.1rem)">
                <span class="scrub-word">Your</span> <span class="scrub-word">feed</span> <span class="scrub-word">is</span> <span class="scrub-word">loud.</span>
                <span class="scrub-word">Your</span> <span class="scrub-word">roster</span> <span class="scrub-word">should</span> <span class="scrub-word">be</span> <span class="scrub-word">louder.</span>
                <span class="scrub-word">No</span> <span class="scrub-word">bought</span> <span class="scrub-word">followers,</span> <span class="scrub-word">no</span> <span class="scrub-word">ghost</span> <span class="scrub-word">engagement,</span>
                <span class="scrub-word">no</span> <span class="scrub-word">screenshots</span> <span class="scrub-word">as</span> <span class="scrub-word">proof.</span>
                <span class="scrub-word font-editorial italic text-[#2B4CFF]">just real reach, verified live.</span>
            </p>
            <div class="reveal mt-12 flex flex-wrap items-center gap-4">
                <span class="ransom font-mono text-xs font-bold bg-lime px-4 py-2 rounded-lg" style="transform: rotate(-2deg)">API first</span>
                <span class="ransom font-mono text-xs font-bold bg-paper px-4 py-2 rounded-lg" style="transform: rotate(1.5deg)">No bots ever</span>
                <span class="ransom font-mono text-xs font-bold bg-magenta text-white px-4 py-2 rounded-lg" style="transform: rotate(-1deg)">Escrow payouts</span>
                <span class="font-script text-2xl text-[#FF5A14] rotate-2">the old way knew no cap</span>
            </div>
        </section>

        <!-- ===================== LIVE RECEIPTS (COUNTERS) ===================== -->
        <section id="receipts" class="relative bg-magenta text-white border-y-2 border-ink overflow-hidden">
            <div aria-hidden="true" class="absolute -top-24 left-1/3 w-96 h-96 rounded-full bg-lime/20 blur-3xl"></div>
            <div class="relative max-w-7xl mx-auto px-6 py-24 md:py-32">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-12">
                    <div class="reveal">
                        <p class="font-display font-black text-5xl sm:text-6xl"><span data-count="12800">0</span></p>
                        <p class="mt-2 text-[11px] font-mono font-bold uppercase tracking-widest text-white/70">Creators rostered</p>
                    </div>
                    <div class="reveal">
                        <p class="font-display font-black text-5xl sm:text-6xl"><span data-count="2500">0</span><span class="text-lime">+</span></p>
                        <p class="mt-2 text-[11px] font-mono font-bold uppercase tracking-widest text-white/70">Campaigns shipped</p>
                    </div>
                    <div class="reveal">
                        <p class="font-display font-black text-5xl sm:text-6xl"><span data-count="12">0</span>.5M<span class="text-lime">+</span></p>
                        <p class="mt-2 text-[11px] font-mono font-bold uppercase tracking-widest text-white/70">Verified reach</p>
                    </div>
                    <div class="reveal">
                        <p class="font-display font-black text-5xl sm:text-6xl"><span data-count="2.1">0</span>M</p>
                        <p class="mt-2 text-[11px] font-mono font-bold uppercase tracking-widest text-white/70">Escrow protected ₹</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== TESTIMONIAL CAROUSEL ===================== -->
        <section class="relative max-w-7xl mx-auto px-6 py-32 md:py-44">
            <div class="grid lg:grid-cols-2 gap-14 items-center">
                <div>
                    <span class="reveal inline-flex items-center gap-2 rounded-full bg-cobalt/15 text-ink border-2 border-ink px-4 py-1.5 text-[11px] font-mono font-bold uppercase tracking-[0.2em]">
                        <i class="fa-solid fa-heart text-[#FF2E7E]"></i> The Receipts
                    </span>
                    <h2 class="reveal mt-5 font-display font-black leading-[1.04] tracking-tight" style="font-size: clamp(2.2rem, 4vw, 3.6rem)">
                        Receipts from<br>the front <span class="font-editorial italic text-[#2B4CFF]">lines.</span>
                    </h2>

                    <div class="reveal mt-8 flex items-center gap-4">
                        <div class="flex -space-x-3">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="w-11 h-11 rounded-full border-2 border-paper object-cover">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Client" class="w-11 h-11 rounded-full border-2 border-paper object-cover">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Client" class="w-11 h-11 rounded-full border-2 border-paper object-cover">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Client" class="w-11 h-11 rounded-full border-2 border-paper object-cover">
                        </div>
                    </div>

                    <!-- Mini reel tile -->
                    <div class="reveal mt-8 inline-flex items-center gap-4 rounded-2xl border-2 border-ink bg-paper p-3 pr-5 shadow-[6px_6px_0_#BDB0FC]">
                        <span class="relative block w-16 h-16 rounded-xl overflow-hidden">
                            <video class="w-full h-full object-cover" muted loop playsinline autoplay preload="metadata" poster="https://picsum.photos/seed/light3quote/160/160">
                                <source src="https://media.w3.org/2010/05/bunny/movie.mp4" type="video/mp4">
                            </video>
                        </span>
                        <span class="font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60 leading-tight">Real client<br>video review</span>
                    </div>
                </div>

                <div class="relative">
                    <div id="tCarousel" class="reveal relative rounded-[2rem] bg-paper border-2 border-ink shadow-[10px_10px_0_#D6FF3D] overflow-hidden">
                        <div class="t-track flex transition-transform duration-700 ease-[cubic-bezier(0.32,0.72,0,1)]">
                            <div class="t-slide w-full shrink-0 p-8 sm:p-10">
                                <div class="flex gap-1 text-[#FF2E7E] text-sm"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                <blockquote class="mt-5 font-display font-bold text-xl sm:text-2xl leading-snug">
                                    "We briefed six creators across five cities. Nine days later we had a full campaign of reels with real, verified reach &mdash; and escrow meant nobody chased anyone for payment."
                                </blockquote>
                                <p class="mt-6 font-mono text-xs font-bold text-ink/60">Tara M. &bull; Head of Growth &mdash; urbanwear label</p>
                            </div>
                            <div class="t-slide w-full shrink-0 p-8 sm:p-10">
                                <div class="flex gap-1 text-[#FF2E7E] text-sm"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                <blockquote class="mt-5 font-display font-bold text-xl sm:text-2xl leading-snug">
                                    "The swipe roster is weirdly addictive. Reach, engagement rate, audience geography &mdash; all pulled live. Selecting talent took minutes, not weeks."
                                </blockquote>
                                <p class="mt-6 font-mono text-xs font-bold text-ink/60">Rahul S. &bull; Founder &mdash; D2C skincare</p>
                            </div>
                            <div class="t-slide w-full shrink-0 p-8 sm:p-10">
                                <div class="flex gap-1 text-[#FF2E7E] text-sm"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                <blockquote class="mt-5 font-display font-bold text-xl sm:text-2xl leading-snug">
                                    "Booked an anchor for a 5,000-seat stream in under a week. The vibe quiz actually nailed the brief. Confetti felt earned."
                                </blockquote>
                                <p class="mt-6 font-mono text-xs font-bold text-ink/60">Diya P. &bull; Producer &mdash; live events</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-center gap-3">
                        <button id="tPrev" aria-label="Previous" class="w-11 h-11 rounded-full bg-paper border-2 border-ink flex items-center justify-center hover:bg-lime transition"><i class="fa-solid fa-arrow-left text-xs"></i></button>
                        <button id="tNext" aria-label="Next" class="w-11 h-11 rounded-full bg-ink text-white flex items-center justify-center hover:bg-[#FF2E7E] transition"><i class="fa-solid fa-arrow-right text-xs"></i></button>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== ACTION CTA ===================== -->
        <section class="relative max-w-7xl mx-auto px-6 pb-32 md:pb-44">
            <div class="relative rounded-[3rem] bg-lime border-2 border-ink p-8 sm:p-16 overflow-hidden shadow-[14px_14px_0_#181528]">
                <div aria-hidden="true" class="cta-blob absolute -top-20 -right-16 w-72 h-72 rounded-full bg-magenta/40 blur-3xl"></div>
                <div aria-hidden="true" class="cta-blob absolute -bottom-24 -left-16 w-80 h-80 rounded-full bg-cobalt/30 blur-3xl"></div>

                <div class="relative z-10 flex flex-col items-center text-center max-w-3xl mx-auto">
                    <span class="rounded-full bg-ink text-lime px-5 py-2 font-mono text-[11px] font-bold uppercase tracking-[0.2em]">Your brand, their feed</span>
                    <h2 class="mt-7 font-display font-black leading-[1.02] tracking-tight" style="font-size: clamp(2.6rem, 5.2vw, 5rem)">
                        Book a face.<br>Drop a <span class="font-editorial italic text-[#FF2E7E]">blockbuster.</span>
                    </h2>
                    <p class="mt-6 text-ink/70 font-medium leading-relaxed max-w-xl">
                        Post a brief, compare verified creators, and let escrow keep every payout honest. First casting is on us.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row items-center gap-4">
                        <button type="button" data-confetti class="group inline-flex items-center gap-3 rounded-full bg-ink text-white font-extrabold text-sm pl-7 pr-2 py-3 ink-btn" onclick="location.href='{{ route('register') }}'">
                            <span>Start a casting</span>
                            <span class="w-9 h-9 rounded-full bg-lime text-ink flex items-center justify-center text-xs transition-transform duration-300 group-hover:rotate-45"><i class="fa-solid fa-arrow-up"></i></span>
                        </button>
                        <a href="{{ route('campaigns.public') }}" class="inline-flex items-center gap-2 rounded-full bg-paper border-2 border-ink text-ink font-bold text-sm px-7 py-3.5 transition-transform duration-300 hover:-translate-y-0.5">
                            Browse live briefs
                        </a>
                    </div>
                </div>

                <div class="absolute top-6 right-6 sm:top-10 sm:right-10 w-24 h-24 sm:w-28 sm:h-28 animate-spin-slow">
                    <svg viewBox="0 0 100 100" class="w-full h-full">
                        <defs><path id="circ3" d="M50,50 m-37,0 a37,37 0 1,1 74,0 a37,37 0 1,1 -74,0"></path></defs>
                        <text class="fill-ink font-mono" style="font-size:9.5px; letter-spacing:2.5px;">
                            <textPath href="#circ3">CAST &bull; SWIPE &bull; CONVERT &bull; </textPath>
                        </text>
                    </svg>
                    <span class="absolute inset-0 m-auto w-9 h-9 rounded-full bg-ink text-lime flex items-center justify-center text-sm"><i class="fa-solid fa-bolt"></i></span>
                </div>
            </div>
        </section>

        <!-- ===================== FOOTER (interactive paper punch) ===================== -->
        <footer class="relative mt-24 w-full" id="site-footer">
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
                    <rect id="tm-green-rect" x="0" y="0" width="1440" height="320" fill="#D6FE3F" mask="url(#tmPaperMask)"/>
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
                p.setAttribute('fill', '#D6FE3F');
                p.setAttribute('stroke', 'rgba(18,22,29,0.08)');
                p.setAttribute('stroke-width', '1');
                pieceSvg.appendChild(p);

                shapeLayerEl.appendChild(pieceSvg);

                // Animate fall using smooth gravity curve
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
                if (maskEl) {
                    var holes = maskEl.querySelectorAll('path');
                    holes.forEach(function (h) { h.remove(); });
                }
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

                /* ── Footer mouse events (use document-level to bypass ScrollSmoother) ── */
                document.addEventListener('mousemove', function (e) {
                    if (!footerEl || !cursorEl) { return; }
                    var fRect = footerEl.getBoundingClientRect();
                    var inFooter = e.clientX >= fRect.left && e.clientX <= fRect.right &&
                                   e.clientY >= fRect.top  && e.clientY <= fRect.bottom;
                    if (inFooter && isInPaperZone(e.clientY)) {
                        moveCursor(e.clientX, e.clientY);
                        cursorEl.style.display = 'block';
                    } else {
                        cursorEl.style.display = 'none';
                    }
                });

                /* Click punches a hole only in the green paper zone */
                footerEl.addEventListener('click', function (e) {
                    if (!isInPaperZone(e.clientY)) { return; }
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
                    var t = e.target;
                    if (t && (t.tagName === 'INPUT' || t.tagName === 'TEXTAREA' || t.tagName === 'SELECT' || t.isContentEditable)) { return; }
                    if (e.key === 'ArrowRight') { cycleShape(1); }
                    if (e.key === 'ArrowLeft')  { cycleShape(-1); }
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        }());
        </script>
    </main>
        </div>
    </div>

    <!-- ===================== FIXED NAV (kept outside #smooth-content so it does not scroll away) ===================== -->
    <header id="siteNav" class="fixed inset-x-0 top-0 z-50 mt-4 px-3 pointer-events-none sm:mt-6 sm:px-4">
        <nav class="pointer-events-auto mx-auto flex max-w-6xl items-center justify-between gap-3 rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-card)] py-2 pl-3 pr-2 shadow-[4px_4px_0_var(--hm-line)] sm:py-2.5 sm:pl-4 sm:pr-2.5">
            <a href="{{ route('home.light3') }}" class="flex shrink-0 items-center gap-2.5 rounded-full">
                <span class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-lime)] font-display text-sm font-extrabold text-[var(--hm-line)]">H*</span>
                <span class="hidden font-display text-base font-extrabold tracking-tight text-[var(--hm-ink)] sm:inline-block">HypeMarket<span class="text-[var(--hm-pink)]">.</span></span>
            </a>

            <ul class="hidden items-center gap-1 md:flex">
                <li><a href="#stories" class="rounded-full px-3.5 py-2 text-[13px] font-bold text-[var(--hm-ink)] transition-colors hover:bg-[var(--hm-lime)] hover:text-[var(--hm-line)]">Stories</a></li>
                <li><a href="#vibe" class="rounded-full px-3.5 py-2 text-[13px] font-bold text-[var(--hm-ink)] transition-colors hover:bg-[var(--hm-lime)] hover:text-[var(--hm-line)]">Your Vibe</a></li>
                <li><a href="#roster" class="rounded-full px-3.5 py-2 text-[13px] font-bold text-[var(--hm-ink)] transition-colors hover:bg-[var(--hm-lime)] hover:text-[var(--hm-line)]">Swipe Roster</a></li>
                <li><a href="#estimate" class="rounded-full px-3.5 py-2 text-[13px] font-bold text-[var(--hm-ink)] transition-colors hover:bg-[var(--hm-lime)] hover:text-[var(--hm-line)]">Get Paid</a></li>
            </ul>

            <div class="flex items-center gap-2">
                <button id="soundToggle" aria-label="Toggle sound" aria-pressed="false" class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-bg)] text-[var(--hm-ink)] transition-colors hover:bg-[var(--hm-lime)]">
                    <i id="soundIcon" class="fa-solid fa-volume-xmark text-xs"></i>
                </button>
                <a href="{{ route('register') }}" class="hm-btn hidden items-center gap-2 rounded-full bg-[var(--hm-lime)] px-5 py-2.5 text-[13px] font-extrabold text-[var(--hm-line)] sm:inline-flex">
                    Start free <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
                <button id="navToggle" aria-label="Open menu" class="flex h-10 w-10 flex-col items-center justify-center gap-[5px] rounded-full border-2 border-[var(--hm-line)] bg-[var(--hm-line)] text-[var(--hm-card)] md:hidden">
                    <span id="navLine1" class="block h-[2px] w-4 origin-center bg-current"></span>
                    <span id="navLine2" class="block h-[2px] w-4 origin-center bg-current"></span>
                </button>
            </div>
        </nav>
    </header>

    <!-- Fullscreen menu overlay -->
    <div id="navOverlay" class="hm-root hidden fixed inset-0 z-40 bg-[var(--hm-bg)]/95 backdrop-blur-2xl">
        <div class="mx-auto flex h-full max-w-4xl flex-col justify-center gap-2 px-8">
            <a href="#stories" class="navLink flex items-baseline gap-4 border-b-2 border-[var(--hm-line)] py-3 font-display text-4xl font-extrabold text-[var(--hm-ink)] sm:text-6xl"><span class="font-mono text-xs text-[var(--hm-blue)]">01</span>Stories</a>
            <a href="#vibe" class="navLink flex items-baseline gap-4 border-b-2 border-[var(--hm-line)] py-3 font-display text-4xl font-extrabold text-[var(--hm-ink)] sm:text-6xl"><span class="font-mono text-xs text-[var(--hm-blue)]">02</span>Your Vibe</a>
            <a href="#roster" class="navLink flex items-baseline gap-4 border-b-2 border-[var(--hm-line)] py-3 font-display text-4xl font-extrabold text-[var(--hm-ink)] sm:text-6xl"><span class="font-mono text-xs text-[var(--hm-blue)]">03</span>Swipe Roster</a>
            <a href="#estimate" class="navLink flex items-baseline gap-4 border-b-2 border-[var(--hm-line)] py-3 font-display text-4xl font-extrabold text-[var(--hm-ink)] sm:text-6xl"><span class="font-mono text-xs text-[var(--hm-blue)]">04</span>Get Paid</a>
            <a href="{{ route('register') }}" class="navLink hm-btn mt-8 self-start rounded-full bg-[var(--hm-lime)] px-8 py-4 text-sm font-extrabold text-[var(--hm-line)]">Start free</a>
        </div>
    </div>

    {{-- Custom cursor: shape outline, follows mouse, only visible inside footer (kept outside #smooth-content so it is fixed) --}}
    <div id="tm-cursor" aria-hidden="true" style="position:fixed;top:0;left:0;pointer-events:none;z-index:99999;display:none;will-change:transform;">
        <svg width="80" height="80" viewBox="-40 -40 80 80" style="display:block;overflow:visible;filter:drop-shadow(0 2px 6px rgba(0,0,0,0.35));">
            <path id="tm-cursor-path"
                  d="M 0 -42 C 22 -52 42 -32 32 -10 C 50 -2 50 26 26 30 C 30 50 4 56 -4 38 C -22 52 -42 32 -32 14 C -52 8 -48 -22 -26 -22 C -22 -42 -10 -50 0 -42 Z"
                  fill="rgba(255,255,255,0.55)"
                  stroke="#12161d"
                  stroke-width="2.5"
                  style="transform:scale(0.85);"/>
        </svg>
    </div>

    <!-- ===================== MOTION CHOREOGRAPHY (GSAP + SCROLLTRIGGER + SCROLLSMOOTHER + MICRO-INTERACTIONS) ===================== -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const hasGsap = typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined';
            const hasSmoother = typeof ScrollSmoother !== 'undefined';
            const hasSplit = typeof SplitText !== 'undefined';

            /* ---------- Sound engine (WebAudio synth, opt-in) ---------- */
            let audioCtx = null;
            let soundOn = false;
            const soundToggle = document.getElementById('soundToggle');
            const soundIcon = document.getElementById('soundIcon');
            const ensureAudio = () => {
                if (!audioCtx) {
                    try { audioCtx = new (window.AudioContext || window.webkitAudioContext)(); } catch (e) { audioCtx = null; }
                }
                return audioCtx;
            };
            const tone = (freq, dur, type, vol) => {
                if (!soundOn) { return; }
                const ctx = ensureAudio();
                if (!ctx) { return; }
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = type || 'sine';
                osc.frequency.value = freq;
                gain.gain.setValueAtTime(0.0001, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(vol || 0.08, ctx.currentTime + 0.01);
                gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + dur);
                osc.connect(gain).connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + dur + 0.02);
            };
            const sfx = {
                blip: () => tone(520, 0.09, 'triangle', 0.06),
                pop: () => tone(760, 0.12, 'square', 0.05),
                chime: () => { tone(660, 0.12, 'sine', 0.07); setTimeout(() => tone(990, 0.18, 'sine', 0.06), 90); },
                whoosh: () => tone(220, 0.18, 'sawtooth', 0.04),
            };
            if (soundToggle) {
                soundToggle.addEventListener('click', () => {
                    soundOn = !soundOn;
                    soundToggle.setAttribute('aria-pressed', soundOn ? 'true' : 'false');
                    if (soundIcon) { soundIcon.className = soundOn ? 'fa-solid fa-volume-high text-xs' : 'fa-solid fa-volume-xmark text-xs'; }
                    if (soundOn) { ensureAudio(); sfx.chime(); }
                });
            }

            /* ---------- Confetti helper ---------- */
            const palette = ['#D6FF3D', '#FF2E7E', '#2B4CFF', '#FF5A14', '#8A3FFC'];
            const burst = (opts) => {
                if (prefersReduced || typeof confetti !== 'function') { return; }
                confetti(Object.assign({
                    particleCount: 70,
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
                el.addEventListener('click', () => {
                    const r = el.getBoundingClientRect();
                    burst({ origin: { x: (r.left + r.width / 2) / window.innerWidth, y: (r.top + r.height / 2) / window.innerHeight } });
                    sfx.pop();
                });
            });

            /* ---------- Smooth scroll engine (ScrollSmoother) ---------- */
            let smoother = null;
            if (hasGsap) {
                gsap.registerPlugin(ScrollTrigger);
                if (hasSmoother) {
                    gsap.registerPlugin(ScrollSmoother);
                    if (hasSplit) { gsap.registerPlugin(SplitText); }
                    if (!prefersReduced) {
                        smoother = ScrollSmoother.create({
                            wrapper: '#smooth-wrapper',
                            content: '#smooth-content',
                            smooth: 1,
                            effects: true,
                            normalizeScroll: true,
                        });
                    }
                }
            }

            document.querySelectorAll('a[href^="#"]').forEach((a) => {
                a.addEventListener('click', (e) => {
                    const target = document.querySelector(a.getAttribute('href'));
                    if (!target) { return; }
                    e.preventDefault();
                    sfx.blip();
                    if (smoother) { smoother.scrollTo(target, true, 'top top+=80'); }
                    else { target.scrollIntoView({ behavior: prefersReduced ? 'auto' : 'smooth' }); }
                });
            });

            /* ---------- Nav toggle ---------- */
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
                        if (hasGsap && !prefersReduced) {
                            gsap.fromTo('.navLink', { y: 40, opacity: 0 }, { y: 0, opacity: 1, duration: 0.7, stagger: 0.08, ease: 'power3.out', delay: 0.1 });
                        }
                    }
                    if (hasGsap) {
                        gsap.to(n1, { rotate: menuOpen ? 45 : 0, y: menuOpen ? 7 : 0, duration: 0.35, ease: 'power2.out' });
                        gsap.to(n2, { rotate: menuOpen ? -45 : 0, y: menuOpen ? -7 : 0, duration: 0.35, ease: 'power2.out' });
                    }
                    sfx.blip();
                });
                navOverlay.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => {
                    menuOpen = false;
                    navOverlay.classList.add('hidden');
                    if (hasGsap) { gsap.to(n1, { rotate: 0, y: 0, duration: 0.3 }); gsap.to(n2, { rotate: 0, y: 0, duration: 0.3 }); }
                }));
            }

            /* ---------- Vibe quiz (gamified) ---------- */
            const quizStages = Array.from(document.querySelectorAll('.quiz-stage'));
            const vibeStepEl = document.getElementById('vibeStep');
            const xpFill = document.getElementById('xpFill');
            const xpValue = document.getElementById('xpValue');
            const xpBadge = document.getElementById('xpBadge');
            if (quizStages.length) {
                const tally = {};
                let step = 0;
                let xp = 0;
                const setXp = (v) => {
                    xp = v;
                    if (xpValue) { xpValue.textContent = String(v); }
                    if (xpFill) { xpFill.style.transform = 'scaleX(' + Math.min(1, v / 100) + ')'; }
                };
                const showStage = (i) => {
                    quizStages.forEach((s, idx) => s.classList.toggle('hidden', idx !== i));
                    if (vibeStepEl) { vibeStepEl.textContent = String(Math.min(i + 1, 3)); }
                };
                const results = {
                    fashion: { title: 'Runway Energy', copy: 'Editorial models with runway-grade comp cards and premium brand fit.' },
                    reels: { title: 'Viral Reels Energy', copy: 'Short-form creators with the highest engagement-to-reach ratio.' },
                    anchor: { title: 'Stage Anchor Energy', copy: 'Live hosts and emcees who own a room, on stage and on stream.' },
                };
                document.querySelectorAll('.quiz-stage button.vibe-opt').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const vibe = btn.dataset.vibe;
                        tally[vibe] = (tally[vibe] || 0) + 1;
                        setXp(xp + 34);
                        sfx.blip();
                        if (step < quizStages.length - 1) {
                            step += 1;
                            showStage(step);
                        } else {
                            const winner = Object.keys(tally).sort((a, b) => tally[b] - tally[a])[0] || 'reels';
                            const res = results[winner] || results.reels;
                            quizStages.forEach((s) => s.classList.add('hidden'));
                            const resultPanel = document.createElement('div');
                            resultPanel.className = 'animate-pop-in text-center py-4';
                            resultPanel.innerHTML =
                                '<div class="w-16 h-16 mx-auto rounded-full bg-lime border-2 border-ink flex items-center justify-center text-2xl"><i class="fa-solid fa-bolt"></i></div>' +
                                '<p class="mt-5 font-mono text-[11px] font-bold uppercase tracking-widest text-ink/50">Your vibe</p>' +
                                '<h3 class="mt-2 font-display font-black text-3xl text-ink">' + res.title + '</h3>' +
                                '<p class="mt-3 text-sm text-ink/65 font-medium max-w-sm mx-auto">' + res.copy + '</p>';
                            quizStages[0].parentNode.appendChild(resultPanel);
                            if (vibeStepEl) { vibeStepEl.textContent = '3'; }
                            setXp(100);
                            if (xpBadge) { xpBadge.classList.remove('hidden'); }
                            sfx.chime();
                            burst({ particleCount: 130, spread: 90, origin: { y: 0.5 } });
                        }
                    });
                });
            }

            /* ---------- Swipe-to-match deck ---------- */
            const deckEl = document.getElementById('matchDeck');
            if (deckEl) {
                const cards = Array.from(deckEl.querySelectorAll('.match-card'));
                const emptyEl = document.getElementById('deckEmpty');
                const matchedEl = document.getElementById('deckMatched');
                let matched = 0;
                let active = cards.length - 1;

                const layout = () => {
                    cards.forEach((c, i) => {
                        const depth = active - i;
                        c.style.zIndex = String(i + 1);
                        if (depth < 0 || depth > 3) { c.style.opacity = '0'; c.style.pointerEvents = 'none'; }
                        else {
                            c.style.opacity = '1';
                            c.style.pointerEvents = depth === 0 ? 'auto' : 'none';
                            c.style.transform = 'translateY(' + (depth * 10) + 'px) scale(' + (1 - depth * 0.04) + ')';
                        }
                    });
                };
                layout();

                const flyOut = (card, dir, dragX, dragY) => {
                    const good = dir > 0;
                    if (good) { matched += 1; if (matchedEl) { matchedEl.textContent = String(matched); } sfx.chime(); }
                    else { sfx.whoosh(); }
                    if (good && matched % 3 === 0) { burst({ particleCount: 120, spread: 100, origin: { y: 0.5 } }); }
                    const stamp = card.querySelector(good ? '.match-stamp-like' : '.match-stamp-pass');
                    if (stamp) { stamp.style.opacity = '1'; }
                    if (hasGsap && !prefersReduced) {
                        card.style.transform = 'translate(' + dragX + 'px,' + dragY + 'px) rotate(' + (dragX * 0.06) + 'deg)';
                        gsap.to(card, {
                            x: dir * (window.innerWidth + 400),
                            rotate: dir * 24,
                            duration: 0.5,
                            ease: 'power2.in',
                            onComplete: () => {
                                card.style.display = 'none';
                                active -= 1;
                                if (active < 0) {
                                    if (emptyEl) { emptyEl.classList.remove('hidden'); }
                                } else {
                                    layout();
                                }
                            },
                        });
                    } else {
                        card.style.display = 'none';
                        active -= 1;
                        if (active < 0) { if (emptyEl) { emptyEl.classList.remove('hidden'); } } else { layout(); }
                    }
                };

                cards.forEach((card, idx) => {
                    let startX = 0, startY = 0, dragging = false, dx = 0, dy = 0;
                    const likeStamp = card.querySelector('.match-stamp-like');
                    const passStamp = card.querySelector('.match-stamp-pass');
                    card.addEventListener('pointerdown', (e) => {
                        if (idx !== active) { return; }
                        dragging = true;
                        startX = e.clientX; startY = e.clientY;
                        card.setPointerCapture(e.pointerId);
                        card.style.transition = 'none';
                    });
                    card.addEventListener('pointermove', (e) => {
                        if (!dragging || idx !== active) { return; }
                        dx = e.clientX - startX;
                        dy = e.clientY - startY;
                        card.style.transform = 'translate(' + dx + 'px,' + dy + 'px) rotate(' + (dx * 0.06) + 'deg)';
                        if (likeStamp) { likeStamp.style.opacity = String(Math.max(0, Math.min(1, dx / 110))); }
                        if (passStamp) { passStamp.style.opacity = String(Math.max(0, Math.min(1, -dx / 110))); }
                    });
                    const end = () => {
                        if (!dragging) { return; }
                        dragging = false;
                        if (Math.abs(dx) > 110) {
                            flyOut(card, dx > 0 ? 1 : -1, dx, dy);
                        } else if (hasGsap) {
                            gsap.to(card, { x: 0, y: 0, rotate: 0, duration: 0.4, ease: 'elastic.out(1,0.6)' });
                            if (likeStamp) { likeStamp.style.opacity = '0'; }
                            if (passStamp) { passStamp.style.opacity = '0'; }
                        } else {
                            card.style.transform = '';
                        }
                        dx = 0; dy = 0;
                    };
                    card.addEventListener('pointerup', end);
                    card.addEventListener('pointercancel', end);
                    card.addEventListener('pointerleave', end);
                });

                const deckReset = document.getElementById('deckReset');
                if (deckReset) {
                    deckReset.addEventListener('click', () => {
                        cards.forEach((c) => { c.style.display = ''; c.style.transform = ''; const s = c.querySelectorAll('.match-stamp'); s.forEach((n) => n.style.opacity = '0'); });
                        matched = 0;
                        if (matchedEl) { matchedEl.textContent = '0'; }
                        active = cards.length - 1;
                        if (emptyEl) { emptyEl.classList.add('hidden'); }
                        layout();
                        sfx.pop();
                    });
                }
            }

            /* ---------- Gamified estimator ---------- */
            const followers = document.getElementById('followers');
            const engagement = document.getElementById('engagement');
            const followersOut = document.getElementById('followersOut');
            const engagementOut = document.getElementById('engagementOut');
            const estimateValue = document.getElementById('estimateValue');
            const delivOpts = Array.from(document.querySelectorAll('.deliv-opt'));
            let mult = 1.8;
            let estimateAnim = null;
            const money = (n) => n.toLocaleString('en-IN');

            const computeEstimate = () => {
                if (!followers || !engagement) { return; }
                const f = Number(followers.value);
                const er = Number(engagement.value) / 10;
                const base = Math.round((f / 1000) * 42 * (er / 4) * mult);
                const value = Math.max(1500, base);
                if (followersOut) { followersOut.textContent = f >= 1000000 ? (f / 1000000).toFixed(2) + 'M' : Math.round(f / 1000) + 'K'; }
                if (engagementOut) { engagementOut.textContent = er.toFixed(1) + '%'; }
                if (estimateValue) {
                    if (hasGsap && !prefersReduced) {
                        if (estimateAnim) { estimateAnim.kill(); }
                        const obj = { v: Number(String(estimateValue.textContent).replace(/[^0-9]/g, '')) || 0 };
                        estimateAnim = gsap.to(obj, {
                            v: value, duration: 0.5, ease: 'power2.out',
                            onUpdate: () => { estimateValue.textContent = money(Math.round(obj.v)); },
                        });
                    } else {
                        estimateValue.textContent = money(value);
                    }
                }
                sfx.blip();
            };
            if (followers) { followers.addEventListener('input', computeEstimate); }
            if (engagement) { engagement.addEventListener('input', computeEstimate); }
            delivOpts.forEach((btn) => {
                btn.addEventListener('click', () => {
                    delivOpts.forEach((b) => { b.classList.remove('chosen', 'border-lime', 'bg-lime', 'text-ink'); b.classList.add('border-white/15'); });
                    btn.classList.remove('border-white/15');
                    btn.classList.add('chosen', 'border-lime', 'bg-lime', 'text-ink');
                    mult = Number(btn.dataset.mult) || 1;
                    computeEstimate();
                });
            });
            if (followers && estimateValue) { computeEstimate(); }

            /* ---------- Motion (GSAP) ---------- */
            if (!hasGsap || prefersReduced) {
                document.body.classList.remove('preload');
                return;
            }

            gsap.registerPlugin(ScrollTrigger);

            // Hero entrance (mask reveal)
            gsap.set('.fx-hidden', { opacity: 0 });
            const tl = gsap.timeline({ delay: 0.15 });
            tl.to('.fx-hidden', { opacity: 1, duration: 0.6, stagger: 0.06, ease: 'power2.out' }, 0.1)
                .fromTo('#heroCtas > *', { y: 18, opacity: 0 }, { y: 0, opacity: 1, duration: 0.5, stagger: 0.08, ease: 'power3.out' }, 0.35)
                .add(() => { document.body.classList.remove('preload'); }, 0.35);

            // Scroll reveals (headings get a SplitText treatment instead)
            gsap.utils.toArray('.reveal').forEach((el) => {
                if (el.matches('h1, h2') && hasSplit && !prefersReduced) { return; }
                gsap.from(el, {
                    scrollTrigger: { trigger: el, start: 'top 88%', toggleActions: 'play none none none' },
                    y: 42, opacity: 0, duration: 0.9, ease: 'power3.out',
                });
            });

            // Manifesto scrub
            const manifestoWords = gsap.utils.toArray('.scrub-word');
            if (manifestoWords.length) {
                gsap.from(manifestoWords, {
                    opacity: 0.1, stagger: 0.02, ease: 'none',
                    scrollTrigger: { trigger: '#manifesto', start: 'top 80%', end: 'bottom 55%', scrub: 0.4 },
                });
            }

            // Counters (with one confetti pop)
            let counted = false;
            document.querySelectorAll('[data-count]').forEach((el) => {
                const end = parseFloat(el.dataset.count);
                const isFloat = el.dataset.count.indexOf('.') !== -1;
                const obj = { val: 0 };
                gsap.to(obj, {
                    val: end, duration: 2, ease: 'power2.out',
                    scrollTrigger: {
                        trigger: el, start: 'top 88%', once: true,
                        onEnter: () => {
                            if (!receiptsBurstDone) { burst({ origin: { y: 0.7 }, particleCount: 90 }); receiptsBurstDone = true; }
                        },
                    },
                    onUpdate() { el.textContent = isFloat ? obj.val.toFixed(1) : Math.round(obj.val).toLocaleString('en-IN'); },
                });
            });
            let receiptsBurstDone = false;

            // Testimonial carousel
            const tTrack = document.querySelector('.t-track');
            const tSlides = gsap.utils.toArray('.t-slide');
            const tCarousel = document.getElementById('tCarousel');
            if (tTrack && tSlides.length > 1 && tTrack) {
                let idx = 0;
                let paused = false;
                const go = (i) => {
                    idx = (i + tSlides.length) % tSlides.length;
                    gsap.to(tTrack, { xPercent: -idx * 100, duration: 0.75, ease: 'power3.out' });
                };
                const auto = window.setInterval(() => { if (!paused && !prefersReduced) { go(idx + 1); } }, 5000);
                const nextBtn = document.getElementById('tNext');
                const prevBtn = document.getElementById('tPrev');
                if (tNext) { tNext.addEventListener('click', () => { go(ixx(1)); sfx.blip(); }); }
                if (tPrev) { tPrev.addEventListener('click', () => { go(idx - 1); sfx.blip(); }); }
                const c = document.getElementById('tCarousel');
                if (c) {
                    c.addEventListener('mouseenter', () => { /* pause */ });
                }
                function ixNext(n) { return null; }
            }

            /* ---------- SplitText headline reveals ---------- */
            if (hasGsap && hasSplit && !prefersReduced) {
                gsap.utils.toArray('.reveal h2').forEach((h2) => {
                    const split = new SplitText(h2, { type: 'words,chars' });
                    gsap.from(split.chars, {
                        yPercent: 60, opacity: 0, duration: 0.7, stagger: 0.012, ease: 'power3.out',
                        scrollTrigger: { trigger: h2, start: 'top 85%', toggleActions: 'play none none none' },
                    });
                });
            }

            /* ---------- Parallax depth (ScrollSmoother effects) ---------- */
            if (smoother && !prefersReduced) {
                smoother.effects('.hm-glow', { speed: 0.5, lag: 0.25 });
                smoother.effects('.cta-blob', { speed: 0.6, lag: 0.3 });
                smoother.effects('.reveal h2', { speed: 0.92 });
            }

            /* ---------- Scroll progress bar ---------- */
            const progressBar = document.getElementById('scrollProgress');
            if (progressBar && hasGsap) {
                ScrollTrigger.create({
                    start: 0, end: 'max',
                    onUpdate: (self) => { progressBar.style.transform = 'scaleX(' + self.progress + ')'; },
                });
            }

            ScrollTrigger.refresh();
            window.addEventListener('load', () => ScrollTrigger.refresh());
        });
    </script>
</body>
</html>
