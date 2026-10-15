<!DOCTYPE html>
<html lang="en" class="scroll-smooth antialiased selection:bg-[#E2F163] selection:text-[#181528]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Typography &amp; Handwritten Script Lab &mdash; HypeMarket</title>
    <meta name="description" content="Interactive font pairing and handwritten script showcase for HypeMarket. Compare Gen-Z display fonts, body fonts, and handwritten cursive accent scripts in real time.">

    <!-- Google Fonts Imports (Display + Body + Handwritten Scripts) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800;12..96,900&family=Caveat:wght@600;700&family=Fraunces:ital,opsz,wght@0,9..144,700;0,9..144,800;0,9..144,900;1,9..144,700&family=Instrument+Serif:ital@0;1&family=Kalam:wght@400;700&family=Nothing+You+Could+Do&family=Outfit:wght@400;500;600;700;800;900&family=Patrick+Hand&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Reenie+Beanie&family=Shadows+Into+Light&family=Space+Grotesk:wght@500;600;700&family=Syne:wght@700;800;900&family=Unbounded:wght@700;800;900&family=Urbanist:wght@700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        canvas: '#FAF5EC',
                        ink: '#181528',
                        solar: '#E2F163',
                        vermilion: '#FF3E14',
                        pinkpop: '#F47FA2',
                        lilac: '#BDB0FC',
                        skyblue: '#7EC4FB',
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome & Alpine.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        .noise-bg {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.035'/%3E%3C/svg%3E");
        }

        /* Display & Body Font Classes */
        .font-bricolage { font-family: 'Bricolage Grotesque', sans-serif; }
        .font-syne { font-family: 'Syne', sans-serif; }
        .font-fraunces { font-family: 'Fraunces', serif; }
        .font-unbounded { font-family: 'Unbounded', sans-serif; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        .font-jakarta { font-family: '"Plus Jakarta Sans"', sans-serif; }
        .font-space { font-family: '"Space Grotesk"', monospace; }
        .font-instrument { font-family: '"Instrument Serif"', serif; }
        .font-urbanist { font-family: 'Urbanist', sans-serif; }

        /* Handwritten & Cursive Script Classes */
        .font-caveat { font-family: 'Caveat', cursive; }
        .font-reenie { font-family: 'Reenie Beanie', cursive; }
        .font-kalam { font-family: 'Kalam', cursive; }
        .font-nothing { font-family: 'Nothing You Could Do', cursive; }
        .font-shadows { font-family: 'Shadows Into Light', cursive; }
        .font-patrick { font-family: 'Patrick Hand', cursive; }
    </style>
</head>

<body class="bg-[#FAF5EC] text-[#181528] min-h-screen font-jakarta noise-bg" x-data="{ 
    selectedPair: 'bricolage',
    selectedScript: 'caveat',
    scriptDoodleText: '100% verified &bull; zero bot followers!',
    pairs: {
        'bricolage': {
            name: 'Pair 01 &mdash; Kinetic Gen-Z Grotesk',
            display: 'font-bricolage',
            body: 'font-jakarta',
            badge: 'font-space',
            titleText: 'Cast verified Instagram models, influencers & anchors.',
            accentText: 'High Energy &bull; Punchy Character',
            desc: 'Bricolage Grotesque (900) + Plus Jakarta Sans + Space Grotesk. Highly expressive, bouncy and authentic.'
        },
        'syne': {
            name: 'Pair 02 &mdash; European Creative Agency',
            display: 'font-syne',
            body: 'font-outfit',
            badge: 'font-space',
            titleText: 'Cast verified Instagram models, influencers & anchors.',
            accentText: 'Geometric Agency &bull; Ultra Modern',
            desc: 'Syne (800/900) + Outfit + Space Grotesk. Broad geometric forms with an Awwwards design studio vibe.'
        },
        'unbounded': {
            name: 'Pair 03 &mdash; Cyber Streetwear & Comp Cards',
            display: 'font-unbounded',
            body: 'font-jakarta',
            badge: 'font-space',
            titleText: 'Cast verified Instagram models, influencers & anchors.',
            accentText: 'Bold Streetwear &bull; Tech Aesthetic',
            desc: 'Unbounded (800) + Plus Jakarta Sans + Space Grotesk. Wide futuristic stance with extreme visual punch.'
        },
        'fraunces': {
            name: 'Pair 04 &mdash; Vogue Editorial & Glam',
            display: 'font-fraunces',
            body: 'font-jakarta',
            badge: 'font-space',
            titleText: 'Cast verified Instagram models, influencers & anchors.',
            accentText: 'High-Fashion &bull; Soft Editorial Luxury',
            desc: 'Fraunces Variable (900) + Plus Jakarta Sans + Space Grotesk. Warm, character-rich editorial serif with organic curves.'
        },
        'outfit': {
            name: 'Pair 05 &mdash; Clean Neo-Grotesk Tech',
            display: 'font-outfit',
            body: 'font-jakarta',
            badge: 'font-space',
            titleText: 'Cast verified Instagram models, influencers & anchors.',
            accentText: 'Hyper Clean &bull; Universal Readability',
            desc: 'Outfit (900 Black) + Plus Jakarta Sans + Space Grotesk. Ultra-sleek, balanced, and approachable.'
        },
        'urbanist': {
            name: 'Pair 06 &mdash; Editorial Grotesque',
            display: 'font-urbanist',
            body: 'font-outfit',
            badge: 'font-space',
            titleText: 'Cast verified Instagram models, influencers & anchors.',
            accentText: 'Sharp Contrast &bull; Fashion Modern',
            desc: 'Urbanist (900) + Outfit + Space Grotesk. Tall, elegant proportions with clean contemporary cuts.'
        }
    },
    scripts: {
        'caveat': {
            name: 'Caveat',
            class: 'font-caveat',
            subtitle: 'The Expressive Flow Cursive (Top Pick)',
            sampleText: 'omg it\'s giving main character energy ✨',
            annotation: 'real engagement &bull; 0% bots',
            desc: 'Natural, smooth cursive flow with medium stroke weight. Exceptionally readable at both 14px badges and 32px giant sticky notes.'
        },
        'reenie': {
            name: 'Reenie Beanie',
            class: 'font-reenie',
            subtitle: 'The Streetwear Felt-Pen Doodle',
            sampleText: 'booked 4 collabs this week! 🚀',
            annotation: 'raw & unfiltered aesthetic',
            desc: 'Thin, sketchy felt-tip marker handwriting with playful vertical quirks. Gives an instant handmade scrapbook / zine feel.'
        },
        'kalam': {
            name: 'Kalam',
            class: 'font-kalam',
            subtitle: 'The Bold Organic Creator Marker',
            sampleText: 'approved in under 2 hours! ⚡',
            annotation: 'curated for Indian creator culture',
            desc: 'Organic marker stroke derived from modern South Asian / Indian calligraphy. Warm, approachable, and punchy.'
        },
        'nothing': {
            name: 'Nothing You Could Do',
            class: 'font-nothing',
            subtitle: 'The Casual Ballpoint Scribble',
            sampleText: 'literally the best ROI on Instagram 🔥',
            annotation: 'verified rate card',
            desc: 'Fast, authentic casual handwriting that looks like a note scribbled by a talent manager or creator in a backstage green room.'
        },
        'shadows': {
            name: 'Shadows Into Light',
            class: 'font-shadows',
            subtitle: 'The Chic Lifestyle Pen',
            sampleText: 'aesthetic reels that actually convert 💫',
            annotation: '4.8★ talent rating',
            desc: 'Neat, feminine, rounded pen script with clean terminals. Very popular for beauty, skincare, and fashion model comp cards.'
        },
        'patrick': {
            name: 'Patrick Hand',
            class: 'font-patrick',
            subtitle: 'The Friendly Comic-Chic Marker',
            sampleText: 'instant payout via escrow 🔒',
            annotation: 'Meta Graph synced',
            desc: 'Warm, rounded, and super easy to read. Balances playful Gen-Z humor with reliable clarity on mobile screens.'
        }
    }
}">

    <!-- Top Navigation -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl border-b border-[#181528]/10 py-4 px-4 sm:px-8 shadow-xs">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="w-9 h-9 rounded-full bg-[#E2F163] border border-[#181528]/20 flex items-center justify-center font-bold text-[#181528] text-sm hover:scale-105 transition">
                    H*
                </a>
                <div>
                    <h1 class="font-extrabold text-sm sm:text-base text-[#181528]">Typography &amp; Handwritten Script Lab</h1>
                    <p class="text-[11px] text-[#524B66]">Test Display Fonts + Handwritten Cursive Accents in Real-Time</p>
                </div>
            </div>

            <div class="flex items-center space-x-3 text-xs font-bold">
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-full bg-[#181528] hover:bg-[#FF3E14] text-white transition flex items-center gap-1.5 shadow-xs">
                    <span>Back to Home Page</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
        
        <!-- SECTION 1: DUAL LIVE CONTROLS (DISPLAY PAIR + HANDWRITTEN SCRIPT) -->
        <section class="p-6 sm:p-8 rounded-3xl bg-white border-2 border-[#181528] shadow-[6px_6px_0px_#181528] space-y-6">
            
            <!-- 1. Display Font Selector -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <span class="w-6 h-6 rounded-full bg-[#181528] text-white font-mono text-xs font-bold flex items-center justify-center">1</span>
                        <h2 class="font-black text-sm sm:text-base text-[#181528] uppercase tracking-wide">Select Primary Display Pairing</h2>
                    </div>
                    <span class="text-xs text-[#524B66] font-medium hidden sm:inline">Controls Hero &amp; Section Titles</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2">
                    <template x-for="(pairData, key) in pairs" :key="key">
                        <button @click="selectedPair = key" 
                                :class="selectedPair === key ? 'bg-[#181528] text-white shadow-md border-[#181528]' : 'bg-[#FAF5EC] text-[#181528] hover:bg-[#FFF385] border-[#181528]/15'"
                                class="p-3 rounded-2xl border-2 text-left transition-all duration-200 flex flex-col justify-between">
                            <span class="text-[10px] font-mono font-bold uppercase opacity-70" x-text="key.toUpperCase()"></span>
                            <span class="text-xs font-bold mt-1" x-text="pairData.name.split('&mdash;')[1] || pairData.name"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- 2. Handwritten Script Accent Selector -->
            <div class="pt-4 border-t border-[#181528]/10">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <span class="w-6 h-6 rounded-full bg-[#FF3E14] text-white font-mono text-xs font-bold flex items-center justify-center">2</span>
                        <h2 class="font-black text-sm sm:text-base text-[#181528] uppercase tracking-wide">Select Handwritten / Easy Cursive Accent</h2>
                        <span class="px-2 py-0.5 rounded-md bg-[#FFF385] text-[#181528] border border-[#181528]/20 text-[10px] font-mono font-bold">STICKERS &bull; NOTES &bull; ACCENTS</span>
                    </div>
                    <span class="text-xs text-[#FF3E14] font-bold hidden sm:inline">Adds Authentic Gen-Z Vibe</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2">
                    <template x-for="(scriptData, skey) in scripts" :key="skey">
                        <button @click="selectedScript = skey" 
                                :class="selectedScript === skey ? 'bg-[#FF3E14] text-white shadow-md border-[#181528]' : 'bg-[#FAF5EC] text-[#181528] hover:bg-[#FCE7EE] border-[#181528]/15'"
                                class="p-3 rounded-2xl border-2 text-left transition-all duration-200 flex flex-col justify-between">
                            <span class="text-[10px] font-mono font-bold uppercase opacity-75" x-text="skey.toUpperCase()"></span>
                            <span class="text-base font-bold mt-1" :class="scriptData.class" x-text="scriptData.name"></span>
                        </button>
                    </template>
                </div>
            </div>
        </section>

        <!-- LIVE HERO PREVIEW WITH INTEGRATED HANDWRITTEN ACCENTS -->
        <section class="p-8 sm:p-12 lg:p-16 rounded-[3rem] bg-white border-3 border-[#181528] shadow-[12px_12px_0px_#181528] relative overflow-hidden transition-all duration-300">
            <!-- Background Blob & Grid Decor -->
            <div class="absolute -top-12 -right-12 w-96 h-96 bg-[#E2F163]/30 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -left-12 w-96 h-96 bg-[#F47FA2]/20 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Floating Handwritten Sticky Note 1 (Top-Right) -->
            <div class="hidden md:flex absolute top-8 right-8 z-20 bg-[#FFF385] border-2 border-[#181528] p-3.5 rounded-2xl shadow-[4px_4px_0px_#181528] rotate-3 hover:rotate-0 transition-transform duration-300 max-w-[220px] flex-col space-y-1">
                <div class="flex items-center justify-between">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#FF3E14]/30 border border-[#181528]"></span>
                    <span class="text-[9px] font-space font-bold uppercase text-[#181528]">Sticky Note</span>
                </div>
                <p class="text-lg sm:text-xl font-bold text-[#181528] leading-tight" :class="scripts[selectedScript].class" x-text="scripts[selectedScript].sampleText"></p>
            </div>

            <div class="space-y-7 relative z-10 max-w-4xl">
                
                <!-- Eyebrow Pill + Script Annotation -->
                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-4 py-1.5 rounded-full bg-[#E2F163] text-[#181528] border-2 border-[#181528] text-xs font-black uppercase tracking-wider shadow-xs" :class="pairs[selectedPair].badge">
                        <i class="fa-brands fa-instagram text-[#FF3E14] mr-1.5"></i>
                        <span x-text="pairs[selectedPair].accentText"></span>
                    </span>

                    <!-- Handwritten Script Callout Tag -->
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FAF5EC] border border-[#181528]/20 -rotate-1 shadow-2xs">
                        <i class="fa-solid fa-arrow-turn-down text-[#FF3E14] text-xs rotate-90"></i>
                        <span class="text-base sm:text-lg font-bold text-[#FF3E14]" :class="scripts[selectedScript].class" x-text="scripts[selectedScript].annotation"></span>
                    </div>
                </div>

                <!-- Headline with Inline Script Highlighting -->
                <h2 class="text-4xl sm:text-6xl lg:text-7xl font-black text-[#181528] leading-[1.05] tracking-tight" :class="pairs[selectedPair].display">
                    Cast verified <span class="text-[#FF3E14] underline decoration-wavy decoration-[#E2F163] decoration-3">Instagram models,</span> 
                    <span class="inline-flex items-center align-middle mx-1 px-3 py-1 rounded-2xl bg-[#7EC4FB] text-[#181528] border-2 border-[#181528] -translate-y-1 shadow-[2px_2px_0px_#181528]">
                        <span class="text-xs sm:text-sm font-space font-black uppercase tracking-widest">REELS &bull; RUNWAY</span>
                    </span>
                    influencers &amp; 
                    <span class="relative inline-block">
                        <span class="relative z-10">anchors.</span>
                        <span class="absolute -top-6 -right-6 hidden sm:inline-block text-xl text-[#BDB0FC] -rotate-12 font-bold select-none" :class="scripts[selectedScript].class">
                            ~verified hype~ ✦
                        </span>
                    </span>
                </h2>

                <!-- Subtitle / Body -->
                <p class="text-base sm:text-xl text-[#524B66] font-medium max-w-2xl leading-relaxed" :class="pairs[selectedPair].body">
                    Direct access to authenticated Instagram creators, runway models, and live event anchors across India with real-time Meta Graph API analytics, comp cards, and milestone escrow security.
                </p>

                <!-- Search & Action Demo -->
                <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5">
                    <button class="px-8 py-4 rounded-full bg-[#181528] hover:bg-[#FF3E14] text-white font-extrabold text-sm tracking-wide transition shadow-[4px_4px_0px_#FF3E14] flex items-center justify-center space-x-2" :class="pairs[selectedPair].display">
                        <span>Cast Talent Now</span>
                        <i class="fa-solid fa-arrow-right text-xs ml-1"></i>
                    </button>
                    <button class="px-7 py-4 rounded-full bg-[#FAF5EC] hover:bg-[#E2F163] border-2 border-[#181528] text-[#181528] font-bold text-sm transition shadow-xs" :class="pairs[selectedPair].display">
                        Explore Comp Cards
                    </button>

                    <!-- Handwritten CTA Annotation -->
                    <div class="flex items-center space-x-1.5 text-[#181528] pl-2 self-center sm:self-auto">
                        <span class="text-xl sm:text-2xl text-[#FF3E14]" :class="scripts[selectedScript].class">
                            &larr; takes 60 seconds
                        </span>
                    </div>
                </div>

                <!-- Combined Stack Info Pill -->
                <div class="mt-8 p-4 rounded-2xl bg-[#FAF5EC] border-2 border-[#181528]/15 text-xs text-[#524B66] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="space-y-1">
                        <div>
                            <strong class="text-[#181528]">Display &amp; Body Stack:</strong> 
                            <span x-text="pairs[selectedPair].desc"></span>
                        </div>
                        <div>
                            <strong class="text-[#FF3E14]">Script Accent:</strong> 
                            <span class="text-[#181528] font-bold" x-text="scripts[selectedScript].name"></span> &mdash; 
                            <span x-text="scripts[selectedScript].desc"></span>
                        </div>
                    </div>
                    <div class="shrink-0 flex items-center gap-2">
                        <span class="px-3 py-1 rounded-lg bg-[#E2F163] text-[#181528] font-mono text-[10px] font-bold border border-[#181528]/20">
                            LIVE PREVIEW
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 2: SHOWCASE OF 6 HANDWRITTEN & EASY CURSIVE SCRIPTS -->
        <section class="space-y-6 pt-4">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-3">
                <div>
                    <span class="text-[10px] font-space font-bold uppercase bg-[#FF3E14] text-white px-2.5 py-0.5 rounded-full">Accent Typography</span>
                    <h3 class="font-extrabold text-2xl sm:text-3xl text-[#181528] mt-1">6 Curated Handwritten &amp; Cursive Scripts</h3>
                    <p class="text-sm text-[#524B66]">Perfect for stickers, sticky notes, annotations, doodle underlines, and badges</p>
                </div>
                <span class="text-xs text-[#827B96] font-mono font-bold">ALL GOOGLE FONTS &bull; ZERO LICENSE FEES</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Script 1: Caveat -->
                <div class="p-6 sm:p-7 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[5px_5px_0px_#181528] flex flex-col justify-between space-y-4 hover:-translate-y-1 transition duration-200 relative overflow-hidden">
                    <div class="absolute top-3 right-3">
                        <span class="px-2.5 py-0.5 rounded-full bg-[#E2F163] text-[#181528] font-mono text-[9px] font-black border border-[#181528]/20">★ TOP PICK</span>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="w-6 h-6 rounded-full bg-[#FAF5EC] border border-[#181528] text-xs font-mono font-bold flex items-center justify-center">01</span>
                            <div>
                                <h4 class="font-black text-lg text-[#181528]">Caveat</h4>
                                <p class="text-[11px] text-[#827B96]">The Expressive Smooth Cursive</p>
                            </div>
                        </div>

                        <!-- Big Preview Quote -->
                        <div class="my-5 p-4 rounded-2xl bg-[#FFF9AA] border border-[#181528]/20 text-center">
                            <p class="font-caveat text-3xl font-bold text-[#181528] leading-tight">
                                &ldquo;100% verified reach &bull; no cap! ✨&rdquo;
                            </p>
                        </div>

                        <p class="text-xs text-[#524B66] leading-relaxed">
                            Fluid cursive with perfect character weighting. Super clear on mobile screens, ideal for sticker chips and badge callouts.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-[#181528]/10 flex items-center justify-between">
                        <code class="text-[10px] font-mono bg-[#FAF5EC] px-2 py-1 rounded border border-[#181528]/15">.font-caveat</code>
                        <button @click="selectedScript = 'caveat'" class="text-xs font-bold text-[#FF3E14] hover:underline flex items-center gap-1">
                            <span>Test Live</span> &rarr;
                        </button>
                    </div>
                </div>

                <!-- Script 2: Reenie Beanie -->
                <div class="p-6 sm:p-7 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[5px_5px_0px_#181528] flex flex-col justify-between space-y-4 hover:-translate-y-1 transition duration-200 relative overflow-hidden">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="w-6 h-6 rounded-full bg-[#FAF5EC] border border-[#181528] text-xs font-mono font-bold flex items-center justify-center">02</span>
                            <div>
                                <h4 class="font-black text-lg text-[#181528]">Reenie Beanie</h4>
                                <p class="text-[11px] text-[#827B96]">Streetwear Felt-Tip Marker</p>
                            </div>
                        </div>

                        <!-- Big Preview Quote -->
                        <div class="my-5 p-4 rounded-2xl bg-[#EAF5FE] border border-[#181528]/20 text-center">
                            <p class="font-reenie text-3xl font-bold text-[#0E4875] leading-tight">
                                &ldquo;booked 4 brand collabs this week ⚡&rdquo;
                            </p>
                        </div>

                        <p class="text-xs text-[#524B66] leading-relaxed">
                            Ultra-expressive felt-tip pen handwriting with organic height variance. Adds genuine streetwear zine authenticity.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-[#181528]/10 flex items-center justify-between">
                        <code class="text-[10px] font-mono bg-[#FAF5EC] px-2 py-1 rounded border border-[#181528]/15">.font-reenie</code>
                        <button @click="selectedScript = 'reenie'" class="text-xs font-bold text-[#FF3E14] hover:underline flex items-center gap-1">
                            <span>Test Live</span> &rarr;
                        </button>
                    </div>
                </div>

                <!-- Script 3: Kalam -->
                <div class="p-6 sm:p-7 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[5px_5px_0px_#181528] flex flex-col justify-between space-y-4 hover:-translate-y-1 transition duration-200 relative overflow-hidden">
                    <div class="absolute top-3 right-3">
                        <span class="px-2.5 py-0.5 rounded-full bg-[#7EC4FB] text-[#0E4875] font-mono text-[9px] font-black border border-[#181528]/20">INDIAN ORIGIN</span>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="w-6 h-6 rounded-full bg-[#FAF5EC] border border-[#181528] text-xs font-mono font-bold flex items-center justify-center">03</span>
                            <div>
                                <h4 class="font-black text-lg text-[#181528]">Kalam</h4>
                                <p class="text-[11px] text-[#827B96]">Warm Indian Creator Marker</p>
                            </div>
                        </div>

                        <!-- Big Preview Quote -->
                        <div class="my-5 p-4 rounded-2xl bg-[#FCE7EE] border border-[#181528]/20 text-center">
                            <p class="font-kalam text-2xl sm:text-3xl font-bold text-[#8F1449] leading-tight">
                                &ldquo;Stage anchor &amp; Reels sensation 🔥&rdquo;
                            </p>
                        </div>

                        <p class="text-xs text-[#524B66] leading-relaxed">
                            Developed specifically for Devanagari and Latin scripts. Chunky, confident, and feels native to Indian creator culture.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-[#181528]/10 flex items-center justify-between">
                        <code class="text-[10px] font-mono bg-[#FAF5EC] px-2 py-1 rounded border border-[#181528]/15">.font-kalam</code>
                        <button @click="selectedScript = 'kalam'" class="text-xs font-bold text-[#FF3E14] hover:underline flex items-center gap-1">
                            <span>Test Live</span> &rarr;
                        </button>
                    </div>
                </div>

                <!-- Script 4: Nothing You Could Do -->
                <div class="p-6 sm:p-7 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[5px_5px_0px_#181528] flex flex-col justify-between space-y-4 hover:-translate-y-1 transition duration-200 relative overflow-hidden">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="w-6 h-6 rounded-full bg-[#FAF5EC] border border-[#181528] text-xs font-mono font-bold flex items-center justify-center">04</span>
                            <div>
                                <h4 class="font-black text-lg text-[#181528]">Nothing You Could Do</h4>
                                <p class="text-[11px] text-[#827B96]">Casual Green-Room Scribble</p>
                            </div>
                        </div>

                        <!-- Big Preview Quote -->
                        <div class="my-5 p-4 rounded-2xl bg-[#F1EEFD] border border-[#181528]/20 text-center">
                            <p class="font-nothing text-2xl sm:text-3xl font-bold text-[#3B2485] leading-tight">
                                &ldquo;instant payout via smart escrow 🔒&rdquo;
                            </p>
                        </div>

                        <p class="text-xs text-[#524B66] leading-relaxed">
                            Fast, expressive handwriting that looks scribbled on a backstage mirror or casting card. Full of spontaneous energy.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-[#181528]/10 flex items-center justify-between">
                        <code class="text-[10px] font-mono bg-[#FAF5EC] px-2 py-1 rounded border border-[#181528]/15">.font-nothing</code>
                        <button @click="selectedScript = 'nothing'" class="text-xs font-bold text-[#FF3E14] hover:underline flex items-center gap-1">
                            <span>Test Live</span> &rarr;
                        </button>
                    </div>
                </div>

                <!-- Script 5: Shadows Into Light -->
                <div class="p-6 sm:p-7 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[5px_5px_0px_#181528] flex flex-col justify-between space-y-4 hover:-translate-y-1 transition duration-200 relative overflow-hidden">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="w-6 h-6 rounded-full bg-[#FAF5EC] border border-[#181528] text-xs font-mono font-bold flex items-center justify-center">05</span>
                            <div>
                                <h4 class="font-black text-lg text-[#181528]">Shadows Into Light</h4>
                                <p class="text-[11px] text-[#827B96]">Chic Fashion &amp; Beauty Pen</p>
                            </div>
                        </div>

                        <!-- Big Preview Quote -->
                        <div class="my-5 p-4 rounded-2xl bg-[#FAF5EC] border border-[#181528]/20 text-center">
                            <p class="font-shadows text-2xl sm:text-3xl font-bold text-[#181528] leading-tight">
                                &ldquo;runway certified &bull; 178 cm height ✦&rdquo;
                            </p>
                        </div>

                        <p class="text-xs text-[#524B66] leading-relaxed">
                            Clean, neat feminine handwriting with rounded curves. Pairs exceptionally well with model comp cards and beauty brand reviews.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-[#181528]/10 flex items-center justify-between">
                        <code class="text-[10px] font-mono bg-[#FAF5EC] px-2 py-1 rounded border border-[#181528]/15">.font-shadows</code>
                        <button @click="selectedScript = 'shadows'" class="text-xs font-bold text-[#FF3E14] hover:underline flex items-center gap-1">
                            <span>Test Live</span> &rarr;
                        </button>
                    </div>
                </div>

                <!-- Script 6: Patrick Hand -->
                <div class="p-6 sm:p-7 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[5px_5px_0px_#181528] flex flex-col justify-between space-y-4 hover:-translate-y-1 transition duration-200 relative overflow-hidden">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="w-6 h-6 rounded-full bg-[#FAF5EC] border border-[#181528] text-xs font-mono font-bold flex items-center justify-center">06</span>
                            <div>
                                <h4 class="font-black text-lg text-[#181528]">Patrick Hand</h4>
                                <p class="text-[11px] text-[#827B96]">Easy-Read Friendly Marker</p>
                            </div>
                        </div>

                        <!-- Big Preview Quote -->
                        <div class="my-5 p-4 rounded-2xl bg-[#FFF385] border border-[#181528]/20 text-center">
                            <p class="font-patrick text-2xl sm:text-3xl font-bold text-[#181528] leading-tight">
                                &ldquo;Meta Graph API live data verified ✔&rdquo;
                            </p>
                        </div>

                        <p class="text-xs text-[#524B66] leading-relaxed">
                            Based on designer Patrick Schwarz's handwriting. Very structured and friendly, giving maximum legibility for small tooltips.
                        </p>
                    </div>

                    <div class="pt-3 border-t border-[#181528]/10 flex items-center justify-between">
                        <code class="text-[10px] font-mono bg-[#FAF5EC] px-2 py-1 rounded border border-[#181528]/15">.font-patrick</code>
                        <button @click="selectedScript = 'patrick'" class="text-xs font-bold text-[#FF3E14] hover:underline flex items-center gap-1">
                            <span>Test Live</span> &rarr;
                        </button>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION 3: COMPONENT DEMOS FEATURING HANDWRITTEN ACCENTS -->
        <section class="space-y-6 pt-6">
            <div>
                <span class="text-[10px] font-space font-bold uppercase bg-[#E2F163] text-[#181528] px-2.5 py-0.5 rounded-full border border-[#181528]/20">Real Component Demos</span>
                <h3 class="font-extrabold text-2xl sm:text-3xl text-[#181528] mt-1">How Handwritten Accents Elevate UI Elements</h3>
                <p class="text-sm text-[#524B66]">See how cursive annotations transform cards, price badges, and talent cards</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Demo 1: Talent Comp Card with Sticky Note -->
                <div class="p-6 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[6px_6px_0px_#181528] space-y-4 relative overflow-hidden">
                    <div class="aspect-[4/5] rounded-3xl bg-[#FAF5EC] border-2 border-[#181528] overflow-hidden relative group">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=600&h=750&fit=crop" alt="Model Demo" class="w-full h-full object-cover">
                        
                        <!-- Floating Script Tape Badge -->
                        <div class="absolute top-3 right-3 bg-[#E2F163] text-[#181528] border-2 border-[#181528] px-3 py-1 rounded-xl rotate-3 shadow-xs">
                            <span class="font-caveat text-base font-bold">~Lakmé Fashion Week casted~</span>
                        </div>

                        <!-- Sticky Note Overlay -->
                        <div class="absolute bottom-3 left-3 bg-white/95 backdrop-blur-md border border-[#181528]/30 px-3 py-1.5 rounded-xl flex items-center gap-1.5 shadow-xs">
                            <i class="fa-brands fa-instagram text-[#FF3E14] text-xs"></i>
                            <span class="font-space font-bold text-xs">@ananya.model</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-black text-lg text-[#181528]">Ananya Roy</h4>
                            <p class="text-xs text-[#524B66] font-medium">Runway Model &bull; 178 cm</p>
                        </div>
                        <div class="text-right">
                            <span class="font-caveat text-xl text-[#FF3E14] font-bold block -rotate-2">Starting at ₹25k</span>
                            <span class="text-[10px] font-space font-bold text-[#827B96] uppercase">Per Runway / Shoot</span>
                        </div>
                    </div>
                </div>

                <!-- Demo 2: Viral Reel Metric Card with Marker Callout -->
                <div class="p-6 rounded-[2.5rem] bg-[#FAF5EC] border-2 border-[#181528] shadow-[6px_6px_0px_#181528] space-y-5 relative">
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 rounded-full bg-[#181528] text-white font-space text-xs font-bold">Collab Analytics</span>
                        <span class="font-kalam text-lg text-[#FF3E14] font-bold rotate-2">~live Meta Graph sync~</span>
                    </div>

                    <div class="p-5 rounded-3xl bg-white border-2 border-[#181528] space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-space font-bold uppercase text-[#524B66]">Average Reel Views</span>
                            <span class="px-2 py-0.5 rounded bg-[#E2F163] text-[10px] font-bold font-mono">TOP 2%</span>
                        </div>
                        <div class="flex items-baseline space-x-2">
                            <span class="text-4xl font-black font-bricolage text-[#181528]">840.5K</span>
                            <span class="text-xs font-bold text-emerald-600 font-mono">+42% this month</span>
                        </div>

                        <!-- Handwritten Annotation Bubble -->
                        <div class="p-2.5 rounded-xl bg-[#FFF385] border border-[#181528]/20 flex items-center gap-2">
                            <i class="fa-solid fa-sparkles text-[#FF3E14] text-xs"></i>
                            <span class="font-caveat text-base font-bold text-[#181528]">
                                &ldquo;88% organic Indian audience between 18-24 yrs&rdquo;
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-[#524B66]">Audience Authenticity</span>
                            <span class="text-[#181528] font-mono">98.4%</span>
                        </div>
                        <div class="w-full h-3 rounded-full bg-white border border-[#181528] p-0.5">
                            <div class="h-full rounded-full bg-[#E2F163] border border-[#181528]" style="width: 98%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Demo 3: Live Anchor Booking Card with Quote -->
                <div class="p-6 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[6px_6px_0px_#181528] space-y-4 relative flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-[#181528]/10">
                            <span class="text-[10px] font-space font-bold uppercase bg-[#BDB0FC] text-[#3B2485] px-2.5 py-0.5 rounded-full border border-[#181528]/20">Stage &bull; Emcee</span>
                            <span class="text-xs font-bold text-[#827B96] font-mono">50+ Events</span>
                        </div>

                        <div class="my-4 p-4 rounded-2xl bg-[#FAF5EC] border-2 border-[#181528] relative">
                            <span class="absolute -top-3 left-4 bg-[#FF3E14] text-white px-2 py-0.5 rounded-md text-[9px] font-mono font-bold">CREATOR NOTE</span>
                            <p class="font-nothing text-xl font-bold text-[#181528] pt-1 leading-snug">
                                &ldquo;Fluent in English &amp; Hindi with high energy crowd engagement &amp; corporate awards experience!&rdquo;
                            </p>
                        </div>
                    </div>

                    <div class="pt-2 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                            <span class="text-xs font-bold text-[#181528]">Available this Weekend</span>
                        </div>
                        <button class="px-5 py-2.5 rounded-full bg-[#181528] hover:bg-[#FF3E14] text-white font-bold text-xs transition">
                            Book Slot &rarr;
                        </button>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION 4: DISPLAY FONT BREAKDOWNS (ALL 6 PAIRS) -->
        <section class="space-y-6 pt-6">
            <div>
                <h3 class="font-extrabold text-2xl sm:text-3xl text-[#181528]">Primary Display Font Pairings Breakdown</h3>
                <p class="text-sm text-[#524B66]">Explore all 6 curated typography sets with buttons, chips, and metrics</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Card 1: Bricolage Grotesque -->
                <div class="p-8 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[6px_6px_0px_#181528] space-y-5">
                    <div class="flex items-center justify-between border-b border-[#181528]/10 pb-4">
                        <div>
                            <span class="text-[10px] font-space font-bold uppercase bg-[#E2F163] text-[#181528] px-2.5 py-0.5 rounded-full border border-[#181528]/15">Pair 01</span>
                            <h4 class="text-lg font-black text-[#181528] mt-1">Bricolage Grotesque + Plus Jakarta Sans</h4>
                        </div>
                        <span class="text-xs font-mono font-bold text-[#FF3E14]">Gen-Z Kinetic Vibe</span>
                    </div>

                    <div class="space-y-3 font-bricolage">
                        <h3 class="text-3xl sm:text-4xl font-black text-[#181528] leading-tight">
                            Cast Top <span class="text-[#FF3E14]">Instagram Models</span> &amp; Reel Creators.
                        </h3>
                    </div>

                    <p class="text-sm text-[#524B66] font-jakarta leading-relaxed">
                        The definitive expressive grotesque font of 2026. Packed with quirky curves, high energy, and instant visual impact.
                    </p>

                    <div class="pt-2 flex items-center space-x-3">
                        <button class="px-6 py-2.5 rounded-full bg-[#181528] text-white font-bricolage font-black text-xs hover:bg-[#FF3E14] transition">
                            Explore Models &rarr;
                        </button>
                        <span class="px-3 py-1 rounded-full bg-[#FCE7EE] text-[#8F1449] font-space text-[10px] font-bold">L5 Comp Card</span>
                    </div>
                </div>

                <!-- Card 2: Syne -->
                <div class="p-8 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[6px_6px_0px_#181528] space-y-5">
                    <div class="flex items-center justify-between border-b border-[#181528]/10 pb-4">
                        <div>
                            <span class="text-[10px] font-space font-bold uppercase bg-[#7EC4FB] text-[#0E4875] px-2.5 py-0.5 rounded-full border border-[#181528]/15">Pair 02</span>
                            <h4 class="text-lg font-black text-[#181528] mt-1">Syne + Outfit</h4>
                        </div>
                        <span class="text-xs font-mono font-bold text-[#3B2485]">European Agency Vibe</span>
                    </div>

                    <div class="space-y-3 font-syne">
                        <h3 class="text-3xl sm:text-4xl font-extrabold text-[#181528] leading-tight">
                            Cast Top <span class="text-[#FF3E14]">Instagram Models</span> &amp; Reel Creators.
                        </h3>
                    </div>

                    <p class="text-sm text-[#524B66] font-outfit leading-relaxed">
                        Wide geometric stance, ultra-modern, giving an undeniable Awwwards design studio feel.
                    </p>

                    <div class="pt-2 flex items-center space-x-3">
                        <button class="px-6 py-2.5 rounded-full bg-[#181528] text-white font-syne font-extrabold text-xs hover:bg-[#FF3E14] transition">
                            Explore Models &rarr;
                        </button>
                        <span class="px-3 py-1 rounded-full bg-[#FFF9AA] text-[#181528] font-space text-[10px] font-bold">5.8% Avg. ER</span>
                    </div>
                </div>

                <!-- Card 3: Unbounded -->
                <div class="p-8 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[6px_6px_0px_#181528] space-y-5">
                    <div class="flex items-center justify-between border-b border-[#181528]/10 pb-4">
                        <div>
                            <span class="text-[10px] font-space font-bold uppercase bg-[#FFF385] text-[#181528] px-2.5 py-0.5 rounded-full border border-[#181528]/15">Pair 03</span>
                            <h4 class="text-lg font-black text-[#181528] mt-1">Unbounded + Plus Jakarta Sans</h4>
                        </div>
                        <span class="text-xs font-mono font-bold text-[#064E3B]">Cyber Streetwear Vibe</span>
                    </div>

                    <div class="space-y-3 font-unbounded">
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#181528] leading-tight">
                            Cast Top <span class="text-[#FF3E14]">Instagram Models</span> &amp; Reel Creators.
                        </h3>
                    </div>

                    <p class="text-sm text-[#524B66] font-jakarta leading-relaxed">
                        Wide futuristic stance with bold squircle curves. Looks exceptional on poster layouts and comp cards.
                    </p>

                    <div class="pt-2 flex items-center space-x-3">
                        <button class="px-6 py-2.5 rounded-full bg-[#181528] text-white font-unbounded font-bold text-xs hover:bg-[#FF3E14] transition">
                            Explore Models &rarr;
                        </button>
                        <span class="px-3 py-1 rounded-full bg-[#EAF5FE] text-[#0E4875] font-space text-[10px] font-bold">185K Reach</span>
                    </div>
                </div>

                <!-- Card 4: Fraunces -->
                <div class="p-8 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[6px_6px_0px_#181528] space-y-5">
                    <div class="flex items-center justify-between border-b border-[#181528]/10 pb-4">
                        <div>
                            <span class="text-[10px] font-space font-bold uppercase bg-[#F47FA2] text-white px-2.5 py-0.5 rounded-full border border-[#181528]/15">Pair 04</span>
                            <h4 class="text-lg font-black text-[#181528] mt-1">Fraunces Variable + Plus Jakarta Sans</h4>
                        </div>
                        <span class="text-xs font-mono font-bold text-[#8F1449]">Vogue High-Fashion Vibe</span>
                    </div>

                    <div class="space-y-3 font-fraunces">
                        <h3 class="text-3xl sm:text-4xl font-black text-[#181528] leading-tight">
                            Cast Top <span class="italic text-[#FF3E14]">Instagram Models</span> &amp; Reel Creators.
                        </h3>
                    </div>

                    <p class="text-sm text-[#524B66] font-jakarta leading-relaxed">
                        Rich variable optical serif with soft teardrop terminals. Gives high-end editorial prestige to fashion runway casting.
                    </p>

                    <div class="pt-2 flex items-center space-x-3">
                        <button class="px-6 py-2.5 rounded-full bg-[#181528] text-white font-fraunces font-bold text-xs hover:bg-[#FF3E14] transition">
                            Explore Models &rarr;
                        </button>
                        <span class="px-3 py-1 rounded-full bg-[#F1EEFD] text-[#3B2485] font-space text-[10px] font-bold">Editorial Runway</span>
                    </div>
                </div>

                <!-- Card 5: Outfit Pure -->
                <div class="p-8 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[6px_6px_0px_#181528] space-y-5">
                    <div class="flex items-center justify-between border-b border-[#181528]/10 pb-4">
                        <div>
                            <span class="text-[10px] font-space font-bold uppercase bg-[#BDB0FC] text-[#3B2485] px-2.5 py-0.5 rounded-full border border-[#181528]/15">Pair 05</span>
                            <h4 class="text-lg font-black text-[#181528] mt-1">Outfit (Black) + Plus Jakarta Sans</h4>
                        </div>
                        <span class="text-xs font-mono font-bold text-[#181528]">Clean Tech Neo-Grotesk</span>
                    </div>

                    <div class="space-y-3 font-outfit">
                        <h3 class="text-3xl sm:text-4xl font-black text-[#181528] leading-tight">
                            Cast Top <span class="text-[#FF3E14]">Instagram Models</span> &amp; Reel Creators.
                        </h3>
                    </div>

                    <p class="text-sm text-[#524B66] font-jakarta leading-relaxed">
                        Ultra-clean, modern geometric grotesque with smooth rounded terminals. Highly legible on all mobile devices.
                    </p>

                    <div class="pt-2 flex items-center space-x-3">
                        <button class="px-6 py-2.5 rounded-full bg-[#181528] text-white font-outfit font-black text-xs hover:bg-[#FF3E14] transition">
                            Explore Models &rarr;
                        </button>
                        <span class="px-3 py-1 rounded-full bg-[#E6F9F2] text-[#064E3B] font-space text-[10px] font-bold">Verified Reach</span>
                    </div>
                </div>

                <!-- Card 6: Urbanist -->
                <div class="p-8 rounded-[2.5rem] bg-white border-2 border-[#181528] shadow-[6px_6px_0px_#181528] space-y-5">
                    <div class="flex items-center justify-between border-b border-[#181528]/10 pb-4">
                        <div>
                            <span class="text-[10px] font-space font-bold uppercase bg-[#FAF5EC] text-[#181528] px-2.5 py-0.5 rounded-full border border-[#181528]/15">Pair 06</span>
                            <h4 class="text-lg font-black text-[#181528] mt-1">Urbanist + Outfit</h4>
                        </div>
                        <span class="text-xs font-mono font-bold text-[#FF3E14]">Sharp Fashion Grotesque</span>
                    </div>

                    <div class="space-y-3 font-urbanist">
                        <h3 class="text-3xl sm:text-4xl font-extrabold text-[#181528] leading-tight">
                            Cast Top <span class="text-[#FF3E14]">Instagram Models</span> &amp; Reel Creators.
                        </h3>
                    </div>

                    <p class="text-sm text-[#524B66] font-outfit leading-relaxed">
                        Crisp, tall geometric proportions designed for digital luxury interfaces and contemporary creator hubs.
                    </p>

                    <div class="pt-2 flex items-center space-x-3">
                        <button class="px-6 py-2.5 rounded-full bg-[#181528] text-white font-urbanist font-extrabold text-xs hover:bg-[#FF3E14] transition">
                            Explore Models &rarr;
                        </button>
                        <span class="px-3 py-1 rounded-full bg-[#FCE7EE] text-[#8F1449] font-space text-[10px] font-bold">Live API Sync</span>
                    </div>
                </div>

            </div>
        </section>

    </main>
</body>
</html>

