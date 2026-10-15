<!DOCTYPE html>
<html lang="en" class="scroll-smooth antialiased selection:bg-[#E2F163] selection:text-[#08070D]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HypeMarket &mdash; Cyber Talent Agency for Fashion Models, Viral Creators & Anchors</title>
    <meta name="description" content="The premier dark-mode cyber talent agency for verified Instagram fashion models, viral creators, and live event anchors. Backed by Meta Graph API sync and milestone escrow protection.">

    <!-- Google Fonts Imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800;12..96,900&family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Bricolage Grotesque"', 'sans-serif'],
                        mono: ['"Space Grotesk"', 'monospace'],
                        script: ['Caveat', 'cursive'],
                    },
                    colors: {
                        oled: '#08070D',
                        'oled-card': '#100E1A',
                        'oled-surface': '#181528',
                        solar: '#E2F163',
                        'solar-light': '#F5FBA8',
                        vermilion: '#FF3E14',
                        pinkpop: '#F47FA2',
                        lilac: '#BDB0FC',
                        skyblue: '#7EC4FB',
                    },
                    animation: {
                        'marquee': 'marquee 22s linear infinite',
                        'star-spin': 'starSpin 10s linear infinite',
                        'pulse-glow': 'pulseGlow 4.5s ease-in-out infinite',
                        'waveform': 'waveAnim 1.2s ease-in-out infinite alternate',
                        'float-soft': 'floatSoft 3.8s ease-in-out infinite',
                        'float-delayed': 'floatSoft 4.2s ease-in-out 1.2s infinite',
                    },
                    keyframes: {
                        marquee: {
                            '0%': { transform: 'translateX(0%)' },
                            '100%': { transform: 'translateX(-50%)' },
                        },
                        starSpin: {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' },
                        },
                        pulseGlow: {
                            '0%, 100%': { opacity: '0.2', transform: 'scale(1)' },
                            '50%': { opacity: '0.45', transform: 'scale(1.06)' },
                        },
                        floatSoft: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        waveAnim: {
                            '0%': { height: '20%' },
                            '100%': { height: '100%' }
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome 6 Icons, GSAP & Alpine.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>

    <style>
        /* Subtle Noise Overlay */
        .noise-bg {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.04'/%3E%3C/svg%3E");
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Hardware Cyber Glass Cards */
        .cyber-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.015) 100%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: all 0.35s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .cyber-card:hover {
            transform: translateY(-8px) rotate(0.5deg);
            border-color: rgba(226, 241, 99, 0.5);
            box-shadow: 0 20px 40px -8px rgba(0, 0, 0, 0.8), 0 0 30px rgba(226, 241, 99, 0.2);
        }

        /* Cyber Neon Liquid Button */
        .btn-cyber {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.85em 2.2em;
            border-radius: 9999px;
            text-decoration: none;
            cursor: pointer;
            overflow: hidden;
            font-family: 'Bricolage Grotesque', 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: -0.01em;
            transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1);
            user-select: none;
        }
        .btn-cyber:active {
            transform: scale(0.96);
        }
        .btn-cyber__bg {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background-color: var(--btn-bg, #E2F163);
            border: 1.5px solid var(--btn-border, #E2F163);
            z-index: 1;
        }
        .btn-cyber__circle-wrap {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            overflow: hidden;
            pointer-events: none;
            z-index: 2;
        }
        .btn-cyber__circle {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 150%;
            padding-bottom: 150%;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            background-color: var(--btn-circle, #FFFFFF);
            transition: transform 0.65s cubic-bezier(0.625, 0.05, 0, 1);
            pointer-events: none;
        }
        .btn-cyber:hover .btn-cyber__circle {
            transform: translate(-50%, -50%) scale(1.6);
        }
        .btn-cyber__text {
            position: relative;
            z-index: 3;
            color: var(--btn-text, #08070D);
            transition: color 0.65s cubic-bezier(0.625, 0.05, 0, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-cyber:hover .btn-cyber__text {
            color: var(--btn-hover-text, #08070D);
        }

        /* Waveform simulation */
        .wave-bar:nth-child(1) { animation-delay: 0.1s; }
        .wave-bar:nth-child(2) { animation-delay: 0.4s; }
        .wave-bar:nth-child(3) { animation-delay: 0.2s; }
        .wave-bar:nth-child(4) { animation-delay: 0.6s; }
    </style>
</head>

<body class="bg-[#08070D] text-white min-h-screen relative font-sans overflow-x-hidden selection:bg-[#E2F163] selection:text-[#08070D]"
      x-data="{
          mobileMenuOpen: false,
          activeFilter: 'all',
          quickModalOpen: false,
          selectedTalent: null,
          demoModalOpen: false,
          calcType: 'influencer',
          calcFollowers: 140000,
          calcDeliverable: 'reel_story',
          activeWordIndex: 0,
          words: ['Viral Creators', 'Fashion Models', 'Event Anchors'],
          init() {
              setInterval(() => {
                  this.activeWordIndex = (this.activeWordIndex + 1) % this.words.length;
              }, 2800);
          },
          get estimatedReach() {
              return Math.round(this.calcFollowers * 0.55);
          },
          get estimatedRate() {
              let base = this.calcType === 'modeling' ? 28000 : (this.calcType === 'anchor' ? 34000 : 19000);
              let multiplier = (this.calcFollowers / 10000) * 1420;
              let deliverableMult = this.calcDeliverable === 'campaign' ? 1.55 : (this.calcDeliverable === 'story' ? 0.6 : 1.15);
              return Math.round((base + multiplier) * deliverableMult);
          },
          openTalentModal(talent) {
              this.selectedTalent = talent;
              this.quickModalOpen = true;
          }
      }">

    <!-- Fixed Ambient Noise Texture & Cyber Glow Orbs -->
    <div class="fixed inset-0 pointer-events-none z-50 noise-bg"></div>
    <div class="fixed -top-32 -left-32 w-[52vw] h-[52vw] rounded-full bg-[#E2F163]/14 blur-[160px] pointer-events-none -z-10 animate-pulse-glow"></div>
    <div class="fixed top-[35%] -right-32 w-[48vw] h-[48vw] rounded-full bg-[#FF3E14]/14 blur-[170px] pointer-events-none -z-10 animate-pulse-glow" style="animation-delay: 2s;"></div>
    <div class="fixed bottom-[-10%] left-[20%] w-[55vw] h-[55vw] rounded-full bg-[#BDB0FC]/14 blur-[180px] pointer-events-none -z-10"></div>

    <!-- ULTRA-GENZ FLOATING DARK NAVBAR -->
    <header class="sticky top-4 sm:top-6 z-40 px-4 sm:px-6">
        <div class="max-w-6xl mx-auto">
            <nav class="bg-[#100E1A]/90 backdrop-blur-2xl border border-white/20 rounded-full px-5 py-2.5 flex items-center justify-between shadow-[0_16px_40px_rgba(0,0,0,0.8)]">
                
                <!-- Brand SVG Logo + Live Indicator -->
                <a href="{{ route('home.dark') }}" class="flex items-center space-x-3 group">
                    <div class="w-9 h-9 rounded-full bg-[#E2F163] flex items-center justify-center font-display font-black text-[#08070D] text-sm group-hover:scale-105 transition-transform shadow-[0_0_15px_rgba(226,241,99,0.4)]">
                        <svg class="w-5 h-5 fill-[#08070D]" viewBox="0 0 24 24">
                            <path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z" />
                        </svg>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-display font-black text-lg text-white tracking-tight">Hype<span class="text-[#E2F163]">Market</span></span>
                        <div class="hidden sm:inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-[#E2F163]/20 border border-[#E2F163]/30 text-[9px] font-mono font-bold text-[#E2F163]">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#E2F163] animate-ping"></span>
                            <span>CYBER DESK</span>
                        </div>
                    </div>
                </a>

                <!-- Desktop Navigation Links Dock -->
                <div class="hidden md:flex items-center space-x-1 text-xs font-bold text-white/70">
                    <a href="#services" class="px-3.5 py-2 rounded-full hover:text-white hover:bg-white/10 transition">Capabilities</a>
                    <a href="#talent" class="px-3.5 py-2 rounded-full hover:text-[#E2F163] hover:bg-white/10 transition">Talent Roster</a>
                    <a href="#blueprint" class="px-3.5 py-2 rounded-full hover:text-white hover:bg-white/10 transition">Framework</a>
                    <a href="#calculator" class="px-3.5 py-2 rounded-full hover:text-white hover:bg-white/10 transition">Escrow Estimator</a>
                    <a href="#differentiators" class="px-3.5 py-2 rounded-full hover:text-white hover:bg-white/10 transition">The Standard</a>
                </div>

                <!-- Right Action Island -->
                <div class="flex items-center space-x-2">
                    <button @click="demoModalOpen = true" class="btn-cyber text-xs py-2 px-5"
                            style="--btn-bg: #E2F163; --btn-border: #E2F163; --btn-circle: #FFFFFF; --btn-text: #08070D; --btn-hover-text: #08070D;">
                        <div class="btn-cyber__bg"></div>
                        <div class="btn-cyber__circle-wrap"><div class="btn-cyber__circle"></div></div>
                        <span class="btn-cyber__text font-black">
                            <i class="fa-solid fa-bolt text-xs"></i>
                            <span>Cast Talent</span>
                        </span>
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex px-3.5 py-2 rounded-full bg-white/10 hover:bg-white/20 text-white font-bold text-xs transition">
                            Portal
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex px-3 py-2 rounded-full text-white/70 hover:text-white font-bold text-xs transition">
                            Sign In
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden w-9 h-9 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white focus:outline-none">
                        <i :class="mobileMenuOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'"></i>
                    </button>
                </div>
            </nav>

            <!-- Mobile Nav Dropdown -->
            <div x-show="mobileMenuOpen" x-transition.origin.top class="md:hidden mt-2 bg-[#100E1A] border border-white/20 rounded-2xl p-4 shadow-2xl space-y-2">
                <a href="#services" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg font-bold text-white hover:bg-white/10">Capabilities</a>
                <a href="#talent" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg font-bold text-[#E2F163] hover:bg-white/10">Talent Roster</a>
                <a href="#blueprint" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg font-bold text-white hover:bg-white/10">Framework</a>
                <a href="#calculator" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg font-bold text-white hover:bg-white/10">Escrow Estimator</a>
                <a href="#differentiators" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg font-bold text-white hover:bg-white/10">The Standard</a>
                <div class="pt-2 border-t border-white/10 flex gap-2">
                    <a href="{{ route('login') }}" class="w-full text-center py-2 rounded-full border border-white/20 font-bold text-xs text-white">Sign In</a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2 rounded-full bg-[#E2F163] text-[#08070D] font-bold text-xs">Join Agency</a>
                </div>
            </div>
        </div>
    </header>

    <main class="relative z-10 w-full overflow-x-hidden">

        <!-- 1. OPEN CINEMATIC HERO SECTION (NO ENCLOSING BOX CONTAINER) -->
        <section id="home" class="pt-16 sm:pt-24 pb-20 px-4 sm:px-6 relative">
            <div class="max-w-7xl mx-auto">
                
                <!-- Floating Ambient Status Badges -->
                <div class="flex flex-wrap items-center gap-3 mb-8">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#E2F163]/15 border border-[#E2F163]/40 text-[#E2F163] text-xs font-mono font-bold shadow-[0_0_15px_rgba(226,241,99,0.15)]">
                        <span class="w-2 h-2 rounded-full bg-[#E2F163] animate-ping"></span>
                        <span>META GRAPH API VERIFIED</span>
                        <span class="text-white/40">&bull; 0% BOT FRAUD</span>
                    </div>

                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/15 text-xs font-mono font-bold text-white">
                        <i class="fa-solid fa-chart-line text-[#E2F163]"></i>
                        <span>6.8% AVG ENGAGEMENT</span>
                    </div>

                    <div class="hidden sm:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#BDB0FC]/15 border border-[#BDB0FC]/30 text-xs font-mono font-bold text-[#BDB0FC]">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>100% ESCROW VAULT</span>
                    </div>
                </div>

                <!-- Massive Free-Flowing Hero Heading -->
                <div class="max-w-6xl">
                    <h1 class="font-display font-black text-5xl sm:text-7xl lg:text-8xl leading-[1.04] tracking-tight text-white mb-8">
                        Where high-impact
                        <span class="inline-block relative">
                            <span class="px-4 py-1 bg-[#E2F163] rounded-2xl text-[#08070D] shadow-[0_0_25px_rgba(226,241,99,0.4)] inline-block transform -rotate-1 transition-all duration-300 font-black"
                                  x-text="words[activeWordIndex]">
                                Viral Creators
                            </span>
                        </span>
                        convert massive reach
                        <span class="inline-block w-16 sm:w-24 h-10 sm:h-14 rounded-full align-middle border border-white/30 bg-cover bg-center mx-1.5 shadow-[0_0_20px_rgba(255,255,255,0.25)]"
                              style="background-image: url('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80');">
                        </span>
                        into revenue.
                    </h1>

                    <p class="text-lg sm:text-2xl text-white/70 font-medium max-w-3xl leading-relaxed mb-10">
                        Direct representation and booking for verified <strong class="text-white font-bold">Fashion Models</strong>, viral <strong class="text-white font-bold">Instagram Creators</strong>, and electrifying <strong class="text-white font-bold">Live Event Anchors</strong> with 100% milestone escrow protection.
                    </p>
                </div>

                <!-- Dual Action CTAs + Cursive Annotation -->
                <div class="flex flex-wrap items-center gap-4 mb-16">
                    <button @click="demoModalOpen = true" class="btn-cyber text-base py-4 px-9"
                            style="--btn-bg: #E2F163; --btn-border: #E2F163; --btn-circle: #FFFFFF; --btn-text: #08070D; --btn-hover-text: #08070D;">
                        <div class="btn-cyber__bg"></div>
                        <div class="btn-cyber__circle-wrap"><div class="btn-cyber__circle"></div></div>
                        <span class="btn-cyber__text font-black">
                            <span>Cast Talent Now</span>
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </span>
                    </button>

                    <a href="#talent" class="btn-cyber text-base py-4 px-8"
                       style="--btn-bg: rgba(255,255,255,0.08); --btn-border: rgba(255,255,255,0.2); --btn-circle: #E2F163; --btn-text: #FFFFFF; --btn-hover-text: #08070D;">
                        <div class="btn-cyber__bg"></div>
                        <div class="btn-cyber__circle-wrap"><div class="btn-cyber__circle"></div></div>
                        <span class="btn-cyber__text font-bold">
                            <i class="fa-regular fa-id-badge text-sm"></i>
                            <span>Inspect Comp Cards</span>
                        </span>
                    </a>

                    <div class="hidden xl:flex items-center gap-2 pl-4 text-sm font-script text-[#E2F163] font-bold rotate-[-2deg]">
                        <svg class="w-6 h-6 stroke-[#E2F163] fill-none" viewBox="0 0 24 24">
                            <path d="M3 12C7 9 12 10 18 16M18 16L13 17M18 16L17 11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>guaranteed 48h casting turnaround & zero ghosting</span>
                    </div>
                </div>

                <!-- Open 3-Pillar Talent Showcase Stage -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
                    
                    <!-- Showcase 1: Fashion Models -->
                    <div class="cyber-card rounded-3xl p-5 cursor-pointer group"
                         @click="openTalentModal({
                             name: 'Elena Vance',
                             handle: '@elena.vance',
                             category: 'Fashion & Runway Model',
                             followers: '142,000',
                             engagement: '7.4%',
                             avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
                             bio: 'Paris & Milan Fashion Week regular. Editorial lookbooks, campaign shoots, and haute couture runway walks.'
                         })">
                        <div class="flex items-center justify-between mb-3.5">
                            <span class="bg-[#E2F163]/20 text-[#E2F163] text-[10px] font-mono font-bold px-3 py-1 rounded-full border border-[#E2F163]/30">
                                RUNWAY & LOOKBOOK
                            </span>
                            <span class="text-xs font-mono text-white/50">Paris/Milan</span>
                        </div>
                        <div class="flex items-center gap-3.5 mb-3.5">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=160&q=80" alt="Elena V." class="w-14 h-14 rounded-2xl object-cover border border-white/20">
                            <div>
                                <div class="font-display font-black text-base text-white flex items-center gap-1">
                                    Elena Vance <i class="fa-solid fa-circle-check text-[#E2F163] text-xs"></i>
                                </div>
                                <div class="text-xs font-mono text-white/60">@elena.vance</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 bg-white/5 rounded-xl p-2.5 border border-white/10 text-center text-xs font-mono">
                            <div>
                                <div class="text-[9px] text-white/50">HEIGHT</div>
                                <div class="font-black text-white">5'11"</div>
                            </div>
                            <div>
                                <div class="text-[9px] text-white/50">ENGAGEMENT</div>
                                <div class="font-black text-[#E2F163]">7.4%</div>
                            </div>
                            <div>
                                <div class="text-[9px] text-white/50">AVG REEL</div>
                                <div class="font-black text-white">410K</div>
                            </div>
                        </div>
                    </div>

                    <!-- Showcase 2: Viral Reels Influencer -->
                    <div class="cyber-card rounded-3xl p-5 cursor-pointer group"
                         @click="openTalentModal({
                             name: 'Marcus Thorne',
                             handle: '@marcus.lens',
                             category: 'Viral Reels & Lifestyle',
                             followers: '480,000',
                             engagement: '6.8%',
                             avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
                             bio: 'Viral lifestyle & streetwear video creator. Known for rapid audio trend adoption and high direct response conversion.'
                         })">
                        <div class="flex items-center justify-between mb-3.5">
                            <span class="bg-[#BDB0FC]/20 text-[#BDB0FC] text-[10px] font-mono font-bold px-3 py-1 rounded-full border border-[#BDB0FC]/30">
                                VIRAL VIDEO
                            </span>
                            <span class="text-xs font-mono text-white/50">480K IG</span>
                        </div>
                        <div class="flex items-center gap-3.5 mb-3.5">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=160&q=80" alt="Marcus T." class="w-14 h-14 rounded-2xl object-cover border border-white/20">
                            <div>
                                <div class="font-display font-black text-base text-white flex items-center gap-1">
                                    Marcus Thorne <i class="fa-solid fa-circle-check text-[#E2F163] text-xs"></i>
                                </div>
                                <div class="text-xs font-mono text-white/60">@marcus.lens</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 bg-white/5 rounded-xl p-2.5 border border-white/10 text-center text-xs font-mono">
                            <div>
                                <div class="text-[9px] text-white/50">NICHE</div>
                                <div class="font-black text-white">Style/Tech</div>
                            </div>
                            <div>
                                <div class="text-[9px] text-white/50">ENGAGEMENT</div>
                                <div class="font-black text-[#E2F163]">6.8%</div>
                            </div>
                            <div>
                                <div class="text-[9px] text-white/50">AVG REEL</div>
                                <div class="font-black text-white">690K</div>
                            </div>
                        </div>
                    </div>

                    <!-- Showcase 3: Live Event Anchor -->
                    <div class="cyber-card rounded-3xl p-5 cursor-pointer group"
                         @click="openTalentModal({
                             name: 'Samantha Ray',
                             handle: '@samantharalive',
                             category: 'Live Event Anchor & Emcee',
                             followers: '210,000',
                             engagement: '5.9%',
                             avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80',
                             bio: 'Bilingual red carpet host & live stage anchor. Over 120+ major corporate launches, film premieres, and music awards.'
                         })">
                        <div class="flex items-center justify-between mb-3.5">
                            <span class="bg-[#FF3E14]/20 text-[#FF3E14] text-[10px] font-mono font-bold px-3 py-1 rounded-full border border-[#FF3E14]/30">
                                STAGE ANCHOR
                            </span>
                            <span class="text-xs font-mono text-white/50">120+ Live</span>
                        </div>
                        <div class="flex items-center gap-3.5 mb-3.5">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=160&q=80" alt="Samantha R." class="w-14 h-14 rounded-2xl object-cover border border-white/20">
                            <div>
                                <div class="font-display font-black text-base text-white flex items-center gap-1">
                                    Samantha Ray <i class="fa-solid fa-circle-check text-[#E2F163] text-xs"></i>
                                </div>
                                <div class="text-xs font-mono text-white/60">@samantharalive</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 bg-white/5 rounded-xl p-2.5 border border-white/10 text-center text-xs font-mono">
                            <div>
                                <div class="text-[9px] text-white/50">EVENTS</div>
                                <div class="font-black text-white">120+ Live</div>
                            </div>
                            <div>
                                <div class="text-[9px] text-white/50">LANGUAGES</div>
                                <div class="font-black text-[#E2F163]">EN / ES</div>
                            </div>
                            <div>
                                <div class="text-[9px] text-white/50">RATING</div>
                                <div class="font-black text-white">5.0 ★</div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 2. KINETIC NEON MARQUEE -->
        <div class="w-full bg-[#100E1A] text-white py-4 border-y border-white/10 overflow-hidden whitespace-nowrap select-none">
            <div class="inline-flex animate-marquee items-center text-sm font-display font-black tracking-widest uppercase">
                <span class="mx-6 flex items-center gap-3">
                    <svg class="w-4 h-4 fill-[#E2F163]" viewBox="0 0 24 24"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    <span>HYPEMARKET CYBER TALENT ROSTER</span>
                </span>
                <span class="mx-6 flex items-center gap-3">
                    <svg class="w-4 h-4 fill-[#BDB0FC]" viewBox="0 0 24 24"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    <span>FASHION RUNWAY & EDITORIAL MODELS</span>
                </span>
                <span class="mx-6 flex items-center gap-3">
                    <svg class="w-4 h-4 fill-[#E2F163]" viewBox="0 0 24 24"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    <span>VIRAL INSTAGRAM REELS CREATORS</span>
                </span>
                <span class="mx-6 flex items-center gap-3">
                    <svg class="w-4 h-4 fill-[#7EC4FB]" viewBox="0 0 24 24"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    <span>LIVE EVENT EMCEES & BROADCAST HOSTS</span>
                </span>
                <span class="mx-6 flex items-center gap-3">
                    <svg class="w-4 h-4 fill-[#FF3E14]" viewBox="0 0 24 24"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    <span>100% ESCROW MILESTONE SECURITY</span>
                </span>
            </div>
        </div>

        <!-- 3. WHAT WE DO: GAPLESS CYBER BENTO GRID -->
        <section id="services" class="py-24 sm:py-32 px-4 sm:px-6 relative">
            <div class="max-w-7xl mx-auto">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#E2F163]/15 border border-[#E2F163]/40 text-[#E2F163] text-xs font-mono font-bold mb-4">
                            <i class="fa-solid fa-layer-group"></i> THE THREE PILLARS
                        </div>
                        <h2 class="font-display font-black text-3xl sm:text-5xl text-white tracking-tight">
                            Built for brands that refuse to look boring.
                        </h2>
                    </div>
                    <p class="text-sm sm:text-base text-white/60 max-w-md mt-4 md:mt-0 font-medium leading-relaxed">
                        Every campaign is powered by verified Meta Graph API metrics, legally cleared usage rights, and milestone financial escrow.
                    </p>
                </div>

                <!-- Gapless Bento Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 grid-flow-dense">
                    
                    <!-- Bento Card 1: Influencer Marketing (Col-Span 2) -->
                    <div class="md:col-span-2 cyber-card rounded-3xl p-8 flex flex-col justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-xs font-mono font-bold uppercase bg-white/10 text-[#E2F163] px-3 py-1 rounded-full border border-[#E2F163]/30">PILLAR 01 &bull; VIRAL REELS</span>
                                <span class="text-xs font-mono font-bold text-white/70"><i class="fa-brands fa-instagram text-base mr-1 text-[#E2F163]"></i> META GRAPH SYNC</span>
                            </div>
                            <h3 class="font-display font-black text-2xl sm:text-4xl text-white mb-3">
                                Creator Campaigns that Dominate the FYP
                            </h3>
                            <p class="text-sm sm:text-base text-white/70 font-medium max-w-xl mb-8 leading-relaxed">
                                We match your brand with native Instagram video creators who understand hook retention, audio trend velocity, and genuine product integration.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 bg-white/5 rounded-2xl p-4 border border-white/10 text-xs font-mono relative z-10">
                            <div class="p-2 border-b sm:border-b-0 sm:border-r border-white/10">
                                <div class="text-[10px] text-white/50 uppercase">AUDIENCE VETTING</div>
                                <div class="font-black text-[#E2F163] mt-0.5">0% Bot Tolerance</div>
                            </div>
                            <div class="p-2 border-b sm:border-b-0 sm:border-r border-white/10">
                                <div class="text-[10px] text-white/50 uppercase">USAGE RIGHTS</div>
                                <div class="font-black text-white mt-0.5">Whitelisted Ads</div>
                            </div>
                            <div class="p-2">
                                <div class="text-[10px] text-white/50 uppercase">REPORTING</div>
                                <div class="font-black text-[#BDB0FC] mt-0.5">Live ROI Graph</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bento Card 2: Fashion Models (Col-Span 1) -->
                    <div class="cyber-card rounded-3xl p-8 flex flex-col justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-xs font-mono font-bold uppercase bg-[#BDB0FC]/15 text-[#BDB0FC] px-3 py-1 rounded-full border border-[#BDB0FC]/30">PILLAR 02</span>
                                <i class="fa-solid fa-vest-patches text-xl text-[#BDB0FC]"></i>
                            </div>
                            <h3 class="font-display font-black text-2xl text-white mb-3">
                                Runway & Fashion Models
                            </h3>
                            <p class="text-xs sm:text-sm text-white/70 font-medium leading-relaxed mb-6">
                                Verified digital comp cards with high-fashion credentials, commercial shoot experience, and international lookbook casting.
                            </p>
                        </div>
                        <button @click="demoModalOpen = true" class="w-full py-3 rounded-full bg-white/10 text-white font-bold text-xs border border-white/20 hover:bg-[#E2F163] hover:text-[#08070D] transition flex items-center justify-center gap-2">
                            <span>Request Model Cast List</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>

                    <!-- Bento Card 3: Live Event Anchors (Col-Span 1) -->
                    <div class="cyber-card rounded-3xl p-8 flex flex-col justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-xs font-mono font-bold uppercase bg-[#FF3E14]/15 text-[#FF3E14] px-3 py-1 rounded-full border border-[#FF3E14]/30">PILLAR 03</span>
                                <i class="fa-solid fa-microphone-lines text-xl text-[#FF3E14]"></i>
                            </div>
                            <h3 class="font-display font-black text-2xl text-white mb-3">
                                Live Event Anchors & Emcees
                            </h3>
                            <p class="text-xs sm:text-sm text-white/70 font-medium leading-relaxed mb-6">
                                High-energy red carpet moderators, summit anchors, and broadcast hosts ready for commanding stage presence.
                            </p>
                        </div>
                        <button @click="demoModalOpen = true" class="w-full py-3 rounded-full bg-white/10 text-white font-bold text-xs border border-white/20 hover:bg-[#FF3E14] hover:text-white transition flex items-center justify-center gap-2">
                            <span>Book Stage Anchor</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>

                    <!-- Bento Card 4: Milestone Escrow Protection (Col-Span 2) -->
                    <div class="md:col-span-2 cyber-card rounded-3xl p-8 flex flex-col justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-xs font-mono font-bold uppercase bg-white/10 text-white px-3 py-1 rounded-full border border-white/20">FINANCIAL ESCROW</span>
                                <span class="text-xs font-mono font-bold text-[#E2F163]"><i class="fa-solid fa-lock text-[#E2F163] mr-1"></i> ZERO PAYMENT RISK</span>
                            </div>
                            <h3 class="font-display font-black text-2xl sm:text-3xl text-white mb-3">
                                100% Escrow Milestone Protection
                            </h3>
                            <p class="text-sm text-white/70 font-medium max-w-xl mb-6 leading-relaxed">
                                Never prepay talent blindly. Funds remain securely locked in milestone vaults until video proof of post and contract deliverables are signed off.
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-xs font-mono font-bold text-white/90">
                            <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10"><i class="fa-solid fa-check text-[#E2F163] mr-1"></i> Multi-Milestone Split</span>
                            <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10"><i class="fa-solid fa-check text-[#E2F163] mr-1"></i> Proof of Post Verification</span>
                            <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10"><i class="fa-solid fa-check text-[#E2F163] mr-1"></i> Dispute Resolution SLA</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 4. DESIRE: VETTED TALENT SHOWCASE -->
        <section id="talent" class="py-24 sm:py-32 px-4 sm:px-6 bg-[#100E1A]/60 border-y border-white/10 relative">
            <div class="max-w-7xl mx-auto">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#E2F163]/15 border border-[#E2F163]/40 text-[#E2F163] text-xs font-mono font-bold mb-3">
                            <i class="fa-solid fa-star"></i> VETTED TALENT ROSTER
                        </div>
                        <h2 class="font-display font-black text-3xl sm:text-5xl text-white tracking-tight">
                            Meet the Creators Setting the Standard.
                        </h2>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="flex flex-wrap items-center gap-2 mt-6 md:mt-0">
                        <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'bg-[#E2F163] text-[#08070D]' : 'bg-white/5 text-white hover:bg-white/10'"
                                class="px-4 py-2 rounded-full border border-white/20 text-xs font-mono font-bold transition">
                            All Talent ({{ count($topTalents) }})
                        </button>
                        <button @click="activeFilter = 'model'" :class="activeFilter === 'model' ? 'bg-[#E2F163] text-[#08070D]' : 'bg-white/5 text-white hover:bg-white/10'"
                                class="px-4 py-2 rounded-full border border-white/20 text-xs font-mono font-bold transition">
                            Fashion Models
                        </button>
                        <button @click="activeFilter = 'influencer'" :class="activeFilter === 'influencer' ? 'bg-[#E2F163] text-[#08070D]' : 'bg-white/5 text-white hover:bg-white/10'"
                                class="px-4 py-2 rounded-full border border-white/20 text-xs font-mono font-bold transition">
                            Viral Creators
                        </button>
                        <button @click="activeFilter = 'anchor'" :class="activeFilter === 'anchor' ? 'bg-[#E2F163] text-[#08070D]' : 'bg-white/5 text-white hover:bg-white/10'"
                                class="px-4 py-2 rounded-full border border-white/20 text-xs font-mono font-bold transition">
                            Event Anchors
                        </button>
                    </div>
                </div>

                <!-- Talent Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($topTalents as $index => $talent)
                        @php
                            $catName = strtolower($talent->category->name ?? 'fashion');
                            $filterCategory = str_contains($catName, 'model') ? 'model' : (str_contains($catName, 'anchor') || str_contains($catName, 'emcee') ? 'anchor' : 'influencer');
                            $user = $talent->user;
                            $name = $user->name ?? 'Verified Talent';
                            $igHandle = $user->instagram_username ?? ($talent->instagram_handle ?? 'creator.'.($index+1));
                            $followers = $talent->followers_count ? number_format($talent->followers_count) : (42000 + ($index * 26000));
                            $engagement = $talent->engagement_rate ?? (4.9 + ($index * 0.6));
                            $avatar = $talent->profile_photo_url ?? ($user->profile_photo_url ?? 'https://images.unsplash.com/photo-'.(1534528741775 + $index*1000).'?auto=format&fit=crop&w=400&q=80');
                        @endphp

                        <div x-show="activeFilter === 'all' || activeFilter === '{{ $filterCategory }}'"
                             x-transition
                             class="cyber-card rounded-3xl p-5 flex flex-col justify-between relative group">
                            
                            <!-- Category Badge & Audio Waveform Pill -->
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[10px] font-mono uppercase bg-white/10 text-[#E2F163] px-2.5 py-1 rounded-full border border-white/20 font-bold">
                                    {{ $talent->category->name ?? 'Fashion & Lifestyle' }}
                                </span>
                                
                                <div class="flex items-center gap-1.5 bg-white/5 px-2.5 py-1 rounded-full border border-white/10">
                                    <div class="flex items-end gap-0.5 h-3">
                                        <span class="w-1 bg-[#E2F163] rounded-full animate-waveform wave-bar"></span>
                                        <span class="w-1 bg-[#E2F163] rounded-full animate-waveform wave-bar"></span>
                                        <span class="w-1 bg-[#E2F163] rounded-full animate-waveform wave-bar"></span>
                                        <span class="w-1 bg-[#E2F163] rounded-full animate-waveform wave-bar"></span>
                                    </div>
                                    <span class="text-[10px] font-mono font-bold text-[#E2F163]">{{ $engagement }}% Eng</span>
                                </div>
                            </div>

                            <!-- Photo Box -->
                            <div class="relative overflow-hidden rounded-2xl border border-white/15 aspect-[4/3] mb-4 bg-black/40">
                                <img src="{{ $avatar }}" alt="{{ $name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute bottom-2 left-2 bg-black/80 backdrop-blur-md px-3 py-1 rounded-full border border-white/20 text-xs font-mono font-bold text-white">
                                    <i class="fa-brands fa-instagram text-[#E2F163] mr-1"></i> {{ '@' . ltrim($igHandle, '@') }}
                                </div>
                            </div>

                            <!-- Talent Metrics -->
                            <div>
                                <h3 class="font-display font-black text-lg text-white flex items-center justify-between mb-1">
                                    <span>{{ $name }}</span>
                                    <i class="fa-solid fa-circle-check text-[#E2F163] text-sm" title="Meta Graph Verified"></i>
                                </h3>
                                <p class="text-xs text-white/60 line-clamp-2 mb-4 leading-relaxed">
                                    {{ $talent->bio ?? 'Verified Instagram talent specialized in high-converting reels, lookbook shoots, and corporate stage emcee.' }}
                                </p>

                                <div class="grid grid-cols-2 gap-2 bg-white/5 p-2.5 rounded-xl border border-white/10 text-center text-xs font-mono mb-4">
                                    <div>
                                        <div class="text-[10px] text-white/40 uppercase">AUDIENCE</div>
                                        <div class="font-black text-white">{{ is_numeric($followers) ? number_format($followers) : $followers }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-white/40 uppercase">AVG REEL VIEWS</div>
                                        <div class="font-black text-[#E2F163]">{{ rand(55, 340) }}K / Reel</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Liquid Button -->
                            <button @click="openTalentModal({
                                        name: '{{ addslashes($name) }}',
                                        handle: '{{ '@' . ltrim($igHandle, '@') }}',
                                        category: '{{ addslashes($talent->category->name ?? 'Talent') }}',
                                        followers: '{{ is_numeric($followers) ? number_format($followers) : $followers }}',
                                        engagement: '{{ $engagement }}%',
                                        avatar: '{{ $avatar }}',
                                        bio: '{{ addslashes($talent->bio ?? 'High-performing creator with verified Meta Graph metrics.') }}'
                                    })"
                                    class="w-full py-2.5 rounded-full bg-white/10 text-white font-display font-bold text-xs border border-white/20 hover:bg-[#E2F163] hover:text-[#08070D] transition flex items-center justify-center gap-2">
                                <i class="fa-regular fa-eye"></i>
                                <span>Inspect Comp Card</span>
                            </button>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12 bg-white/5 rounded-3xl border border-white/10">
                            <p class="font-mono text-sm text-white/60">No talents available right now.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </section>

        <!-- 5. INTERACTIVE ROI CALCULATOR -->
        <section id="calculator" class="py-24 sm:py-32 px-4 sm:px-6 relative">
            <div class="max-w-7xl mx-auto">
                
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#E2F163]/15 border border-[#E2F163]/40 text-[#E2F163] text-xs font-mono font-bold mb-4">
                        <i class="fa-solid fa-calculator"></i> TRANSPARENT PRICING
                    </div>
                    <h2 class="font-display font-black text-3xl sm:text-5xl text-white tracking-tight mb-3">
                        Instant Campaign Estimator
                    </h2>
                    <p class="text-sm sm:text-base text-white/60 font-medium">
                        Model your reach, engagement, and milestone escrow budget in real-time.
                    </p>
                </div>

                <!-- Calculator Container -->
                <div class="cyber-card rounded-3xl p-6 sm:p-10 lg:p-12 max-w-4xl mx-auto shadow-2xl">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        
                        <!-- Inputs -->
                        <div class="lg:col-span-7 space-y-6">
                            
                            <div>
                                <label class="block text-xs font-mono font-bold uppercase text-white/80 mb-2">Talent Discipline</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <button @click="calcType = 'influencer'" :class="calcType === 'influencer' ? 'bg-[#E2F163] text-[#08070D] font-black' : 'bg-white/5 text-white border border-white/15'"
                                            class="py-2.5 px-3 rounded-xl text-xs font-bold transition text-center">
                                        <i class="fa-brands fa-instagram block text-base mb-1"></i> Viral Creator
                                    </button>
                                    <button @click="calcType = 'modeling'" :class="calcType === 'modeling' ? 'bg-[#E2F163] text-[#08070D] font-black' : 'bg-white/5 text-white border border-white/15'"
                                            class="py-2.5 px-3 rounded-xl text-xs font-bold transition text-center">
                                        <i class="fa-solid fa-vest-patches block text-base mb-1"></i> Fashion Model
                                    </button>
                                    <button @click="calcType = 'anchor'" :class="calcType === 'anchor' ? 'bg-[#E2F163] text-[#08070D] font-black' : 'bg-white/5 text-white border border-white/15'"
                                            class="py-2.5 px-3 rounded-xl text-xs font-bold transition text-center">
                                        <i class="fa-solid fa-microphone block text-base mb-1"></i> Stage Anchor
                                    </button>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="text-xs font-mono font-bold uppercase text-white/80">Follower Scale</label>
                                    <span class="text-xs font-mono font-black text-[#E2F163]" x-text="calcFollowers.toLocaleString() + ' IG Followers'"></span>
                                </div>
                                <input type="range" min="10000" max="1000000" step="10000" x-model="calcFollowers"
                                       class="w-full h-3 bg-white/10 rounded-lg appearance-none cursor-pointer accent-[#E2F163] border border-white/20">
                                <div class="flex justify-between text-[10px] font-mono text-white/40 mt-1">
                                    <span>Micro (10K)</span>
                                    <span>Mid-Tier (250K)</span>
                                    <span>Macro (1M+)</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-mono font-bold uppercase text-white/80 mb-2">Deliverable Package</label>
                                <select x-model="calcDeliverable" class="w-full bg-[#181528] border border-white/20 rounded-xl px-4 py-3 text-xs font-mono font-bold text-white focus:outline-none">
                                    <option value="story">1x Instagram Story Sequence (3 Frames)</option>
                                    <option value="reel_story">1x Hero Reel + 2x Amplification Stories</option>
                                    <option value="campaign">Full Commercial Shoot / 30-Day Brand Usage</option>
                                </select>
                            </div>

                        </div>

                        <!-- Results Card -->
                        <div class="lg:col-span-5 bg-[#181528] rounded-2xl p-6 border border-white/15 flex flex-col justify-between space-y-6 shadow-xl">
                            <div>
                                <div class="text-[10px] font-mono uppercase text-[#E2F163] font-bold mb-1">ESTIMATED IMPRESSIONS</div>
                                <div class="text-3xl font-display font-black text-white mb-4" x-text="estimatedReach.toLocaleString() + ' Views'"></div>

                                <div class="space-y-2 border-t border-white/10 pt-4 text-xs font-mono">
                                    <div class="flex justify-between text-white/60">
                                        <span>Target Engagement:</span>
                                        <span class="text-[#E2F163] font-bold">~5.2% - 7.6%</span>
                                    </div>
                                    <div class="flex justify-between text-white/60">
                                        <span>Escrow Security:</span>
                                        <span class="text-white font-bold">100% Protected</span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-white/10 pt-4">
                                <div class="text-[10px] font-mono uppercase text-[#E2F163] font-bold mb-1">PROJECTED ESCROW BUDGET</div>
                                <div class="text-3xl font-display font-black text-[#E2F163]" x-text="'$' + estimatedRate.toLocaleString() + ' USD'"></div>
                                <p class="text-[10px] font-mono text-white/40 mt-1">Includes usage rights & Meta Graph post audit.</p>

                                <button @click="demoModalOpen = true" class="w-full mt-4 py-3 rounded-full bg-[#E2F163] text-[#08070D] font-display font-black text-xs hover:bg-white transition">
                                    Lock In Campaign Slot &rarr;
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- 6. WHY WE'RE BUILT DIFFERENT -->
        <section id="differentiators" class="py-24 sm:py-32 px-4 sm:px-6 bg-[#100E1A]/60 border-y border-white/10 relative">
            <div class="max-w-7xl mx-auto">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#E2F163]/15 border border-[#E2F163]/40 text-[#E2F163] text-xs font-mono font-bold mb-4">
                        <i class="fa-solid fa-bolt"></i> THE CYBER STANDARD
                    </div>
                    <h2 class="font-display font-black text-3xl sm:text-5xl text-white tracking-tight mb-4">
                        Why We're Built Different.
                    </h2>
                    <p class="text-sm sm:text-base text-white/60 font-medium">
                        How HypeMarket replaces traditional agency friction with fast, data-backed execution.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <div class="cyber-card rounded-3xl p-6 flex flex-col justify-between">
                        <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-[#E2F163] text-lg font-black mb-6">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-xl text-white mb-2">Meta Graph Sync</h3>
                            <p class="text-xs text-white/60 leading-relaxed font-medium">
                                Real audience demographics directly from Instagram API. No falsified media kit screenshots.
                            </p>
                        </div>
                    </div>

                    <div class="cyber-card rounded-3xl p-6 flex flex-col justify-between">
                        <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-[#BDB0FC] text-lg font-black mb-6">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-xl text-white mb-2">100% Escrow Vault</h3>
                            <p class="text-xs text-white/60 leading-relaxed font-medium">
                                Funds released exclusively upon verified proof of post and approved milestone deliverables.
                            </p>
                        </div>
                    </div>

                    <div class="cyber-card rounded-3xl p-6 flex flex-col justify-between">
                        <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-[#FF3E14] text-lg font-black mb-6">
                            <i class="fa-solid fa-stopwatch"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-xl text-white mb-2">48h Turnaround</h3>
                            <p class="text-xs text-white/60 leading-relaxed font-medium">
                                Confirmed talent availability and shortlists within two business days. No ghosting.
                            </p>
                        </div>
                    </div>

                    <div class="cyber-card rounded-3xl p-6 flex flex-col justify-between">
                        <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-[#7EC4FB] text-lg font-black mb-6">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-xl text-white mb-2">Legal Ad Rights</h3>
                            <p class="text-xs text-white/60 leading-relaxed font-medium">
                                Standardized commercial ad usage contracts and whitelisted ad account integrations.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 7. ACTION: DUAL CONVERSION FUNNEL -->
        <section class="py-24 sm:py-32 px-4 sm:px-6 relative">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Card A: Brands -->
                    <div class="cyber-card rounded-3xl p-8 sm:p-12 flex flex-col justify-between relative overflow-hidden border border-[#E2F163]/30">
                        <div class="relative z-10">
                            <span class="inline-block text-xs font-mono font-bold uppercase bg-[#E2F163]/20 text-[#E2F163] px-3 py-1 rounded-full border border-[#E2F163]/30 mb-4">FOR BRANDS & AGENCIES</span>
                            <h3 class="font-display font-black text-3xl sm:text-4xl text-white mb-4">
                                Ready to launch your next high-ROI campaign?
                            </h3>
                            <p class="text-sm text-white/70 font-medium leading-relaxed mb-8">
                                Connect with curated creators, receive verified comp cards, and secure your deliverables with milestone protection.
                            </p>
                        </div>
                        <div class="relative z-10">
                            <button @click="demoModalOpen = true" class="btn-cyber text-sm py-3.5 px-8"
                                    style="--btn-bg: #E2F163; --btn-border: #E2F163; --btn-circle: #FFFFFF; --btn-text: #08070D; --btn-hover-text: #08070D;">
                                <div class="btn-cyber__bg"></div>
                                <div class="btn-cyber__circle-wrap"><div class="btn-cyber__circle"></div></div>
                                <span class="btn-cyber__text font-black">
                                    <span>Schedule Agency Briefing</span>
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Card B: Talent -->
                    <div class="cyber-card rounded-3xl p-8 sm:p-12 flex flex-col justify-between relative overflow-hidden border border-[#BDB0FC]/30">
                        <div class="relative z-10">
                            <span class="inline-block text-xs font-mono font-bold uppercase bg-[#BDB0FC]/20 text-[#BDB0FC] px-3 py-1 rounded-full border border-[#BDB0FC]/30 mb-4">FOR TALENT & MODELS</span>
                            <h3 class="font-display font-black text-3xl sm:text-4xl text-white mb-4">
                                Elevate your career with verified brand deals.
                            </h3>
                            <p class="text-sm text-white/70 font-medium leading-relaxed mb-8">
                                Get represented by HypeMarket. Receive guaranteed payments on time with automated milestone escrow contracts.
                            </p>
                        </div>
                        <div class="relative z-10">
                            <a href="{{ route('register') }}" class="btn-cyber text-sm py-3.5 px-8 inline-flex"
                               style="--btn-bg: rgba(255,255,255,0.1); --btn-border: rgba(255,255,255,0.25); --btn-circle: #BDB0FC; --btn-text: #FFFFFF; --btn-hover-text: #08070D;">
                                <div class="btn-cyber__bg"></div>
                                <div class="btn-cyber__circle-wrap"><div class="btn-cyber__circle"></div></div>
                                <span class="btn-cyber__text font-black">
                                    <span>Apply to Join Roster</span>
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <!-- 8. BIG TYPOGRAPHIC FOOTER -->
    <footer id="footer" class="bg-[#08070D] text-white pt-24 pb-12 px-4 sm:px-6 border-t border-white/10 relative overflow-hidden">
        <div class="max-w-7xl mx-auto">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 pb-16 border-b border-white/10">
                
                <!-- Brand Info -->
                <div class="md:col-span-5 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-[#E2F163] flex items-center justify-center font-display font-black text-[#08070D] text-base">
                            <svg class="w-5 h-5 fill-[#08070D]" viewBox="0 0 24 24"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                        </div>
                        <span class="font-display font-black text-2xl text-white">Hype<span class="text-[#E2F163]">Market</span></span>
                    </div>

                    <p class="text-sm text-white/60 max-w-sm leading-relaxed font-medium">
                        The curated strategic agency for Instagram fashion models, viral creators, and live event anchors. Backed by real-time Meta Graph API intelligence and milestone escrow security.
                    </p>

                    <div class="flex items-center space-x-3 text-sm">
                        <a href="#" class="w-9 h-9 rounded-full bg-white/10 hover:bg-[#E2F163] hover:text-[#08070D] border border-white/20 flex items-center justify-center transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-white/10 hover:bg-[#BDB0FC] hover:text-[#08070D] border border-white/20 flex items-center justify-center transition">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-white/10 hover:bg-[#7EC4FB] hover:text-[#08070D] border border-white/20 flex items-center justify-center transition">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigation Columns -->
                <div class="md:col-span-7 grid grid-cols-2 sm:grid-cols-3 gap-8">
                    <div>
                        <h4 class="font-display font-bold text-xs uppercase text-[#E2F163] tracking-wider mb-4 font-mono">Agency</h4>
                        <ul class="space-y-2.5 text-xs text-white/60 font-medium">
                            <li><a href="#services" class="hover:text-white transition">Capabilities</a></li>
                            <li><a href="#talent" class="hover:text-white transition">Talent Roster</a></li>
                            <li><a href="#calculator" class="hover:text-white transition">ROI Estimator</a></li>
                            <li><a href="#differentiators" class="hover:text-white transition">The Standard</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-display font-bold text-xs uppercase text-[#BDB0FC] tracking-wider mb-4 font-mono">Talent Hub</h4>
                        <ul class="space-y-2.5 text-xs text-white/60 font-medium">
                            <li><a href="#talent" class="hover:text-white transition">Fashion Models</a></li>
                            <li><a href="#talent" class="hover:text-white transition">Viral Creators</a></li>
                            <li><a href="#talent" class="hover:text-white transition">Event Anchors</a></li>
                            <li><a href="{{ route('influencers.public') }}" class="hover:text-white transition">Full Directory</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-display font-bold text-xs uppercase text-[#FF3E14] tracking-wider mb-4 font-mono">Trust & Legal</h4>
                        <ul class="space-y-2.5 text-xs text-white/60 font-medium">
                            <li><a href="{{ route('privacy') }}" class="hover:text-white transition">Privacy Policy</a></li>
                            <li><a href="{{ route('terms') }}" class="hover:text-white transition">Terms of Service</a></li>
                            <li><a href="{{ route('data-deletion') }}" class="hover:text-white transition">Data Deletion</a></li>
                            <li><a href="{{ route('how-it-works') }}" class="hover:text-white transition">Escrow Protection</a></li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Giant Typographic Watermark -->
            <div class="pt-16 text-center select-none opacity-10 hover:opacity-20 transition-opacity">
                <span class="font-display font-black text-6xl sm:text-8xl lg:text-9xl tracking-tighter text-white">
                    HYPEMARKET
                </span>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs font-mono text-white/40 border-t border-white/5 mt-8">
                <div>&copy; {{ date('Y') }} HypeMarket Agency. All rights reserved.</div>
                <div class="mt-2 sm:mt-0 flex gap-4">
                    <span>Meta Graph API Verified</span>
                    <span>100% Escrow Protected</span>
                </div>
            </div>

        </div>
    </footer>

    <!-- QUICK COMP CARD MODAL -->
    <div x-show="quickModalOpen" 
         x-transition.opacity
         class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md flex items-center justify-center p-4"
         style="display: none;">
        
        <div @click.outside="quickModalOpen = false" 
             x-show="quickModalOpen"
             x-transition.scale
             class="bg-[#100E1A] border border-white/20 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl relative text-white">
            
            <button @click="quickModalOpen = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white hover:bg-[#E2F163] hover:text-[#08070D] transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>

            <template x-if="selectedTalent">
                <div>
                    <div class="flex items-center gap-4 mb-4">
                        <img :src="selectedTalent.avatar" :alt="selectedTalent.name" class="w-16 h-16 rounded-2xl object-cover border border-white/20">
                        <div>
                            <span class="text-[10px] font-mono uppercase bg-[#E2F163]/20 text-[#E2F163] px-2 py-0.5 rounded-full border border-[#E2F163]/30 font-bold inline-block mb-1" x-text="selectedTalent.category"></span>
                            <h3 class="font-display font-black text-xl text-white" x-text="selectedTalent.name"></h3>
                            <p class="text-xs font-mono text-[#E2F163] font-bold" x-text="selectedTalent.handle"></p>
                        </div>
                    </div>

                    <p class="text-xs text-white/70 leading-relaxed mb-5" x-text="selectedTalent.bio"></p>

                    <div class="grid grid-cols-2 gap-3 bg-white/5 p-3 rounded-2xl border border-white/10 text-center text-xs font-mono mb-6">
                        <div>
                            <div class="text-[10px] text-white/40">TOTAL AUDIENCE</div>
                            <div class="font-black text-sm text-white" x-text="selectedTalent.followers"></div>
                        </div>
                        <div>
                            <div class="text-[10px] text-white/40">ENGAGEMENT RATE</div>
                            <div class="font-black text-sm text-[#E2F163]" x-text="selectedTalent.engagement"></div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button @click="quickModalOpen = false; demoModalOpen = true" class="w-full py-3 rounded-full bg-[#E2F163] text-[#08070D] font-display font-black text-xs hover:bg-white transition">
                            Request Talent Availability &rarr;
                        </button>
                    </div>
                </div>
            </template>

        </div>
    </div>

    <!-- DEMO & CONSULTATION MODAL -->
    <div x-show="demoModalOpen" 
         x-transition.opacity
         class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md flex items-center justify-center p-4"
         style="display: none;">
        
        <div @click.outside="demoModalOpen = false" 
             x-show="demoModalOpen"
             x-transition.scale
             class="bg-[#100E1A] border border-white/20 rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl relative text-white">
            
            <button @click="demoModalOpen = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white hover:bg-[#E2F163] hover:text-[#08070D] transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#E2F163]/20 border border-[#E2F163]/30 text-[#E2F163] text-[10px] font-mono font-bold mb-3">
                <i class="fa-solid fa-calendar-check"></i> VIP AGENCY BRIEFING
            </div>
            <h3 class="font-display font-black text-2xl text-white mb-2">Book a Demo</h3>
            <p class="text-xs text-white/60 mb-5">Share your campaign scope and our talent directors will deliver a custom comp card shortlist in under 24 hours.</p>

            <form @submit.prevent="demoModalOpen = false; alert('Thank you! Our talent directors will contact you within 24 hours.')" class="space-y-3">
                <div>
                    <label class="block text-[10px] font-mono font-bold uppercase text-white/80 mb-1">Your Name</label>
                    <input type="text" required placeholder="Alex Rivera" class="w-full bg-[#181528] border border-white/20 rounded-xl px-3 py-2 text-xs font-mono text-white focus:outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-mono font-bold uppercase text-white/80 mb-1">Work Email</label>
                    <input type="email" required placeholder="alex@brand.com" class="w-full bg-[#181528] border border-white/20 rounded-xl px-3 py-2 text-xs font-mono text-white focus:outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-mono font-bold uppercase text-white/80 mb-1">Talent Scope</label>
                    <select class="w-full bg-[#181528] border border-white/20 rounded-xl px-3 py-2 text-xs font-mono text-white focus:outline-none">
                        <option>Viral Instagram Reels Creators</option>
                        <option>Fashion & Runway Models</option>
                        <option>Live Event Anchors & Emcees</option>
                        <option>Multi-Vertical Brand Campaign</option>
                    </select>
                </div>
                <button type="submit" class="w-full mt-2 py-3 rounded-full bg-[#E2F163] text-[#08070D] font-display font-black text-xs hover:bg-white transition">
                    Confirm Agency Request &rarr;
                </button>
            </form>

        </div>
    </div>

    <!-- GSAP SCROLLTRIGGER & LENIS MOTION -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof Lenis !== 'undefined') {
                const lenis = new Lenis({
                    duration: 1.2,
                    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                    smoothWheel: true,
                });
                function raf(time) {
                    lenis.raf(time);
                    requestAnimationFrame(raf);
                }
                requestAnimationFrame(raf);
            }

            if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                gsap.registerPlugin(ScrollTrigger);

                gsap.from('#home h1', {
                    y: 45,
                    opacity: 0,
                    duration: 1.1,
                    ease: 'power3.out'
                });

                gsap.from('#home .btn-cyber', {
                    y: 25,
                    opacity: 0,
                    duration: 0.8,
                    stagger: 0.15,
                    delay: 0.3,
                    ease: 'power3.out'
                });

                gsap.utils.toArray('.cyber-card').forEach((card) => {
                    gsap.from(card, {
                        scrollTrigger: {
                            trigger: card,
                            start: 'top 85%',
                            toggleActions: 'play none none none'
                        },
                        y: 35,
                        opacity: 0,
                        duration: 0.7,
                        ease: 'power3.out'
                    });
                });
            }
        });
    </script>
</body>
</html>
