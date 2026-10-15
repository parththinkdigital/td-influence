<!DOCTYPE html>
<html lang="en" class="scroll-smooth antialiased selection:bg-[#FCF27B] selection:text-[#2B135A]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HypeMarket &mdash; Curated Instagram Talent & Viral Campaign Agency</title>
    <meta name="description" content="The premier talent agency for verified Instagram fashion models, viral reels creators, and live event anchors. Backed by real-time Meta Graph API sync and 100% milestone escrow security.">

    <!-- Google Fonts Imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800;12..96,900&family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
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
                    },
                    colors: {
                        banana: '#FCF27B',
                        'banana-light': '#FEFBE0',
                        amethyst: '#2B135A',
                        'amethyst-dark': '#1E0D3F',
                        'amethyst-light': '#59477B',
                        mauve: '#CBAAF6',
                        'mauve-dark': '#7F59B1',
                        'mauve-light': '#F3EAFE',
                        bubblegum: '#FF8CBD',
                        'bubblegum-light': '#FFE5E7',
                        skyblue: '#9ECAF2',
                        'skyblue-light': '#EBF4FD',
                        bronze: '#B19A35',
                        cherry: '#A71F5F',
                        ivory: '#F6F4E5',
                        'ivory-subtle': '#FAF7EE',
                    },
                    animation: {
                        'marquee': 'marquee 22s linear infinite',
                        'star-spin': 'starSpin 10s linear infinite',
                        'float-soft': 'floatSoft 3.8s ease-in-out infinite',
                        'float-delayed': 'floatSoft 4.5s ease-in-out 1.2s infinite',
                        'waveform': 'waveAnim 1.2s ease-in-out infinite alternate',
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
        :root {
            --Banana-Cream: #FCF27B;
            --Dark-Amethyst: #2B135A;
            --Dark-Amethyst-dark: #1E0D3F;
            --Mauve: #CBAAF6;
            --Mauve-dark: #7F59B1;
            --Mauve-light: #F3EAFE;
            --Bubblegum-Tint: #FF8CBD;
            --Bubblegum-Tint-light: #FFE5E7;
            --Sky-Blue: #9ECAF2;
            --Golden-Bronze: #B19A35;
            --Cherry-Rose: #A71F5F;
            --Ivory: #F6F4E5;
            --Ivory-subtle: #FAF7EE;
            --White: #FFFFFF;
        }

        /* Hypefluency Signature Liquid Button */
        .btn {
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
        .btn:active {
            transform: scale(0.96);
        }
        .btn__bg {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background-color: var(--bg-color, var(--Banana-Cream));
            border: 2px solid var(--border-color, var(--Dark-Amethyst));
            z-index: 1;
        }
        .btn__circle-wrap {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            overflow: hidden;
            pointer-events: none;
            z-index: 2;
        }
        .btn__circle {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 150%;
            padding-bottom: 150%;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            background-color: var(--circle-color, var(--Dark-Amethyst));
            transition: transform 0.65s cubic-bezier(0.625, 0.05, 0, 1), background-color 0.4s ease;
            pointer-events: none;
        }
        .btn:hover .btn__circle {
            transform: translate(-50%, -50%) scale(1.6);
        }
        .btn__text {
            position: relative;
            z-index: 3;
            color: var(--text-color, var(--Dark-Amethyst));
            transition: color 0.65s cubic-bezier(0.625, 0.05, 0, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn:hover .btn__text {
            color: var(--hover-text-color, var(--Banana-Cream));
        }

        /* Subtle Noise Overlay */
        .noise-bg {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.035'/%3E%3C/svg%3E");
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Tactile Sticker Cards */
        .sticker-card {
            box-shadow: 0 12px 28px -6px rgba(43, 19, 90, 0.12), 0 0 0 2px #2B135A;
            transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.35s ease;
        }
        .sticker-card:hover {
            transform: translateY(-8px) rotate(0.75deg);
            box-shadow: 0 20px 40px -8px rgba(43, 19, 90, 0.2), 0 0 0 2.5px #2B135A;
        }

        /* Waveform simulation */
        .wave-bar:nth-child(1) { animation-delay: 0.1s; }
        .wave-bar:nth-child(2) { animation-delay: 0.4s; }
        .wave-bar:nth-child(3) { animation-delay: 0.2s; }
        .wave-bar:nth-child(4) { animation-delay: 0.6s; }
    </style>
</head>

<body class="bg-[#FAF7EE] text-[#2B135A] min-h-screen relative font-sans overflow-x-hidden selection:bg-[#FCF27B] selection:text-[#2B135A]"
      x-data="{
          mobileMenuOpen: false,
          activeFilter: 'all',
          quickModalOpen: false,
          selectedTalent: null,
          demoModalOpen: false,
          calcType: 'influencer',
          calcFollowers: 125000,
          calcDeliverable: 'reel_story',
          activeWordIndex: 0,
          words: ['Viral Creators', 'Fashion Models', 'Event Anchors'],
          init() {
              setInterval(() => {
                  this.activeWordIndex = (this.activeWordIndex + 1) % this.words.length;
              }, 2800);
          },
          get estimatedReach() {
              return Math.round(this.calcFollowers * 0.52);
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

    <!-- Fixed Ambient Noise Texture & Soft Color Fields -->
    <div class="fixed inset-0 pointer-events-none z-50 noise-bg"></div>
    <div class="fixed -top-32 -left-32 w-[48vw] h-[48vw] rounded-full bg-[#FCF27B]/35 blur-[140px] pointer-events-none -z-10 animate-float-soft"></div>
    <div class="fixed top-[35%] -right-32 w-[44vw] h-[44vw] rounded-full bg-[#CBAAF6]/30 blur-[150px] pointer-events-none -z-10 animate-float-delayed"></div>
    <div class="fixed bottom-0 left-[15%] w-[50vw] h-[50vw] rounded-full bg-[#FF8CBD]/25 blur-[160px] pointer-events-none -z-10"></div>

    <!-- ULTRA-GENZ FLOATING NAVBAR -->
    <header class="sticky top-4 sm:top-6 z-40 px-4 sm:px-6">
        <div class="max-w-6xl mx-auto">
            <nav class="bg-white/95 backdrop-blur-2xl border-2 border-[#2B135A] rounded-full px-5 py-2.5 flex items-center justify-between shadow-[0_12px_36px_rgba(43,19,90,0.08)]">
                
                <!-- Brand Signature + Live Indicator -->
                <a href="{{ route('home.light') }}" class="flex items-center space-x-3 group">
                    <div class="w-9 h-9 rounded-full bg-[#FCF27B] border-2 border-[#2B135A] flex items-center justify-center font-display font-black text-[#2B135A] text-sm group-hover:rotate-12 transition-transform shadow-xs">
                        <svg class="w-5 h-5 fill-[#2B135A]" viewBox="0 0 24 24">
                            <path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z" />
                        </svg>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-display font-black text-lg text-[#2B135A] tracking-tight">Hype<span class="text-[#A71F5F]">Market</span></span>
                        <div class="hidden sm:inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-[#FCF27B] border border-[#2B135A] text-[9px] font-mono font-bold text-[#2B135A]">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#A71F5F] animate-ping"></span>
                            <span>LIVE TALENT DESK</span>
                        </div>
                    </div>
                </a>

                <!-- Desktop Links Pill Dock -->
                <div class="hidden md:flex items-center space-x-1 text-xs font-bold text-[#2B135A]/80">
                    <a href="#services" class="px-3.5 py-2 rounded-full hover:text-[#2B135A] hover:bg-[#FCF27B]/60 transition">What We Do</a>
                    <a href="#talent" class="px-3.5 py-2 rounded-full hover:text-[#2B135A] hover:bg-[#CBAAF6]/40 transition">Talent Comp Cards</a>
                    <a href="#blueprint" class="px-3.5 py-2 rounded-full hover:text-[#2B135A] hover:bg-[#FF8CBD]/30 transition">How It Works</a>
                    <a href="#calculator" class="px-3.5 py-2 rounded-full hover:text-[#2B135A] hover:bg-[#9ECAF2]/40 transition">ROI Calculator</a>
                    <a href="#differentiators" class="px-3.5 py-2 rounded-full hover:text-[#2B135A] hover:bg-[#FCF27B]/60 transition">Why Us</a>
                </div>

                <!-- Right Action Island -->
                <div class="flex items-center space-x-2">
                    <button @click="demoModalOpen = true" class="btn text-xs py-2 px-5" 
                            style="--bg-color: var(--Banana-Cream); --border-color: var(--Dark-Amethyst); --circle-color: var(--Dark-Amethyst); --text-color: var(--Dark-Amethyst); --hover-text-color: var(--Banana-Cream);">
                        <div class="btn__bg"></div>
                        <div class="btn__circle-wrap"><div class="btn__circle"></div></div>
                        <span class="btn__text">
                            <i class="fa-solid fa-bolt text-xs"></i>
                            <span>Cast Talent</span>
                        </span>
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex btn text-xs py-2 px-4"
                           style="--bg-color: var(--Mauve); --border-color: var(--Dark-Amethyst); --circle-color: var(--Dark-Amethyst); --text-color: var(--Dark-Amethyst); --hover-text-color: var(--White);">
                            <div class="btn__bg"></div>
                            <div class="btn__circle-wrap"><div class="btn__circle"></div></div>
                            <span class="btn__text">Portal</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex px-3 py-2 rounded-full text-xs font-bold text-[#2B135A]/70 hover:text-[#2B135A] transition">
                            Sign In
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden w-9 h-9 rounded-full bg-[#FCF27B] border-2 border-[#2B135A] flex items-center justify-center text-[#2B135A] focus:outline-none">
                        <i :class="mobileMenuOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'"></i>
                    </button>
                </div>
            </nav>

            <!-- Mobile Nav Dropdown -->
            <div x-show="mobileMenuOpen" x-transition.origin.top class="md:hidden mt-2 bg-white border-2 border-[#2B135A] rounded-2xl p-4 shadow-xl space-y-2">
                <a href="#services" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg font-bold text-[#2B135A] hover:bg-[#FCF27B]">What We Do</a>
                <a href="#talent" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg font-bold text-[#2B135A] hover:bg-[#CBAAF6]">Talent Comp Cards</a>
                <a href="#blueprint" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg font-bold text-[#2B135A] hover:bg-[#FF8CBD]">How It Works</a>
                <a href="#calculator" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg font-bold text-[#2B135A] hover:bg-[#9ECAF2]">ROI Calculator</a>
                <a href="#differentiators" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg font-bold text-[#2B135A] hover:bg-[#FCF27B]">Why Us</a>
                <div class="pt-2 border-t border-[#2B135A]/10 flex gap-2">
                    <a href="{{ route('login') }}" class="w-full text-center py-2 rounded-full border-2 border-[#2B135A] font-bold text-xs text-[#2B135A]">Sign In</a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2 rounded-full bg-[#2B135A] text-[#FCF27B] font-bold text-xs">Join Agency</a>
                </div>
            </div>
        </div>
    </header>

    <main class="relative z-10 w-full overflow-x-hidden">

        <!-- 1. OPEN CINEMATIC HERO SECTION (NO ENCLOSING BOX CONTAINER) -->
        <section id="home" class="pt-16 sm:pt-24 pb-20 px-4 sm:px-6 relative">
            <div class="max-w-7xl mx-auto">
                
                <!-- Floating Ambient Sticker Badges (Scattered Organically) -->
                <div class="flex flex-wrap items-center gap-3 mb-8">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#FCF27B] border-2 border-[#2B135A] text-[#2B135A] text-xs font-mono font-bold shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-[#A71F5F] animate-ping"></span>
                        <span>META GRAPH API VERIFIED</span>
                        <span class="text-[#2B135A]/40">&bull; 0% BOT FRAUD</span>
                    </div>

                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border-2 border-[#2B135A] text-[#2B135A] text-xs font-mono font-bold shadow-xs">
                        <i class="fa-solid fa-chart-line text-[#A71F5F]"></i>
                        <span>6.8% AVG ENGAGEMENT</span>
                    </div>

                    <div class="hidden sm:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#CBAAF6] border-2 border-[#2B135A] text-[#2B135A] text-xs font-mono font-bold shadow-xs">
                        <i class="fa-solid fa-shield-halved text-[#2B135A]"></i>
                        <span>100% ESCROW VAULT</span>
                    </div>
                </div>

                <!-- Massive Free-Flowing Hero Heading -->
                <div class="max-w-6xl">
                    <h1 class="font-display font-black text-5xl sm:text-7xl lg:text-8xl leading-[1.04] tracking-tight text-[#2B135A] mb-8">
                        Where high-vibe
                        <span class="inline-block relative">
                            <span class="px-4 py-1 bg-[#FCF27B] rounded-2xl border-2 border-[#2B135A] text-[#2B135A] shadow-xs inline-block transform -rotate-1 transition-all duration-300 font-black"
                                  x-text="words[activeWordIndex]">
                                Viral Creators
                            </span>
                        </span>
                        drive real revenue
                        <span class="inline-block w-16 sm:w-24 h-10 sm:h-14 rounded-full align-middle border-2 border-[#2B135A] bg-cover bg-center mx-1.5 shadow-xs"
                              style="background-image: url('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80');">
                        </span>
                        for iconic brands.
                    </h1>

                    <p class="text-lg sm:text-2xl text-[#2B135A]/75 font-medium max-w-3xl leading-relaxed mb-10">
                        We represent vetted <strong class="text-[#2B135A] font-bold">Fashion Models</strong>, viral <strong class="text-[#2B135A] font-bold">Instagram Creators</strong>, and charismatic <strong class="text-[#2B135A] font-bold">Live Event Anchors</strong> backed by 100% milestone escrow security and real-time Meta Graph API audience metrics.
                    </p>
                </div>

                <!-- Dual Action CTAs + Handwritten Callout -->
                <div class="flex flex-wrap items-center gap-4 mb-16">
                    <button @click="demoModalOpen = true" class="btn text-base py-4 px-9"
                            style="--bg-color: var(--Banana-Cream); --border-color: var(--Dark-Amethyst); --circle-color: var(--Dark-Amethyst); --text-color: var(--Dark-Amethyst); --hover-text-color: var(--Banana-Cream);">
                        <div class="btn__bg"></div>
                        <div class="btn__circle-wrap"><div class="btn__circle"></div></div>
                        <span class="btn__text font-black">
                            <span>Book Talent Roster</span>
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </span>
                    </button>

                    <a href="#talent" class="btn text-base py-4 px-8"
                       style="--bg-color: var(--White); --border-color: var(--Dark-Amethyst); --circle-color: var(--Mauve); --text-color: var(--Dark-Amethyst); --hover-text-color: var(--Dark-Amethyst);">
                        <div class="btn__bg"></div>
                        <div class="btn__circle-wrap"><div class="btn__circle"></div></div>
                        <span class="btn__text font-bold">
                            <i class="fa-regular fa-id-badge text-sm"></i>
                            <span>Inspect Comp Cards</span>
                        </span>
                    </a>

                    <!-- Authentic Handwritten Annotation -->
                    <div class="hidden xl:flex items-center gap-2 pl-4 text-sm font-script text-[#A71F5F] font-bold rotate-[-2deg]">
                        <svg class="w-6 h-6 stroke-[#A71F5F] fill-none" viewBox="0 0 24 24">
                            <path d="M3 12C7 9 12 10 18 16M18 16L13 17M18 16L17 11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>guaranteed 48h casting turnaround & zero ghosting</span>
                    </div>
                </div>

                <!-- Open 3-Pillar Talent Showcase Stage -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
                    
                    <!-- Showcase 1: Fashion Model -->
                    <div class="bg-white border-2 border-[#2B135A] rounded-3xl p-5 sticker-card cursor-pointer group"
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
                            <span class="bg-[#FCF27B] text-[#2B135A] text-[10px] font-mono font-black px-3 py-1 rounded-full border border-[#2B135A] shadow-xs">
                                RUNWAY & LOOKBOOK
                            </span>
                            <span class="text-xs font-mono font-bold text-[#A71F5F]">Paris/Milan</span>
                        </div>
                        <div class="flex items-center gap-3.5 mb-3.5">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=160&q=80" alt="Elena V." class="w-14 h-14 rounded-2xl object-cover border-2 border-[#2B135A]">
                            <div>
                                <div class="font-display font-black text-base text-[#2B135A] flex items-center gap-1">
                                    Elena Vance <i class="fa-solid fa-circle-check text-[#A71F5F] text-xs"></i>
                                </div>
                                <div class="text-xs font-mono text-[#2B135A]/60">@elena.vance</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 bg-[#FAF7EE] rounded-xl p-2.5 border border-[#2B135A]/15 text-center text-xs font-mono">
                            <div>
                                <div class="text-[9px] text-[#2B135A]/50">HEIGHT</div>
                                <div class="font-black text-[#2B135A]">5'11"</div>
                            </div>
                            <div>
                                <div class="text-[9px] text-[#2B135A]/50">ENGAGEMENT</div>
                                <div class="font-black text-[#A71F5F]">7.4%</div>
                            </div>
                            <div>
                                <div class="text-[9px] text-[#2B135A]/50">AVG REEL</div>
                                <div class="font-black text-[#2B135A]">410K</div>
                            </div>
                        </div>
                    </div>

                    <!-- Showcase 2: Viral Reels Influencer -->
                    <div class="bg-white border-2 border-[#2B135A] rounded-3xl p-5 sticker-card cursor-pointer group"
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
                            <span class="bg-[#CBAAF6] text-[#2B135A] text-[10px] font-mono font-black px-3 py-1 rounded-full border border-[#2B135A] shadow-xs">
                                VIRAL VIDEO
                            </span>
                            <span class="text-xs font-mono font-bold text-[#2B135A]/70">480K IG</span>
                        </div>
                        <div class="flex items-center gap-3.5 mb-3.5">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=160&q=80" alt="Marcus T." class="w-14 h-14 rounded-2xl object-cover border-2 border-[#2B135A]">
                            <div>
                                <div class="font-display font-black text-base text-[#2B135A] flex items-center gap-1">
                                    Marcus Thorne <i class="fa-solid fa-circle-check text-[#A71F5F] text-xs"></i>
                                </div>
                                <div class="text-xs font-mono text-[#2B135A]/60">@marcus.lens</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 bg-[#FAF7EE] rounded-xl p-2.5 border border-[#2B135A]/15 text-center text-xs font-mono">
                            <div>
                                <div class="text-[9px] text-[#2B135A]/50">NICHE</div>
                                <div class="font-black text-[#2B135A]">Style/Tech</div>
                            </div>
                            <div>
                                <div class="text-[9px] text-[#2B135A]/50">ENGAGEMENT</div>
                                <div class="font-black text-[#A71F5F]">6.8%</div>
                            </div>
                            <div>
                                <div class="text-[9px] text-[#2B135A]/50">AVG REEL</div>
                                <div class="font-black text-[#2B135A]">690K</div>
                            </div>
                        </div>
                    </div>

                    <!-- Showcase 3: Live Event Anchor -->
                    <div class="bg-white border-2 border-[#2B135A] rounded-3xl p-5 sticker-card cursor-pointer group"
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
                            <span class="bg-[#FF8CBD] text-[#2B135A] text-[10px] font-mono font-black px-3 py-1 rounded-full border border-[#2B135A] shadow-xs">
                                STAGE ANCHOR
                            </span>
                            <span class="text-xs font-mono font-bold text-[#A71F5F]">120+ Live</span>
                        </div>
                        <div class="flex items-center gap-3.5 mb-3.5">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=160&q=80" alt="Samantha R." class="w-14 h-14 rounded-2xl object-cover border-2 border-[#2B135A]">
                            <div>
                                <div class="font-display font-black text-base text-[#2B135A] flex items-center gap-1">
                                    Samantha Ray <i class="fa-solid fa-circle-check text-[#A71F5F] text-xs"></i>
                                </div>
                                <div class="text-xs font-mono text-[#2B135A]/60">@samantharalive</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 bg-[#FAF7EE] rounded-xl p-2.5 border border-[#2B135A]/15 text-center text-xs font-mono">
                            <div>
                                <div class="text-[9px] text-[#2B135A]/50">EVENTS</div>
                                <div class="font-black text-[#2B135A]">120+ Live</div>
                            </div>
                            <div>
                                <div class="text-[9px] text-[#2B135A]/50">LANGUAGES</div>
                                <div class="font-black text-[#A71F5F]">EN / ES</div>
                            </div>
                            <div>
                                <div class="text-[9px] text-[#2B135A]/50">RATING</div>
                                <div class="font-black text-[#2B135A]">5.0 ★</div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 2. KINETIC SVG MARQUEE TICKER -->
        <div class="w-full bg-[#2B135A] text-[#F6F4E5] py-4 border-y-2 border-[#2B135A] overflow-hidden whitespace-nowrap select-none">
            <div class="inline-flex animate-marquee items-center text-sm font-display font-black tracking-widest uppercase">
                <span class="mx-6 flex items-center gap-3">
                    <svg class="w-4 h-4 fill-[#FCF27B]" viewBox="0 0 24 24"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    <span>HYPEFLUENCY TALENT ECOSYSTEM</span>
                </span>
                <span class="mx-6 flex items-center gap-3">
                    <svg class="w-4 h-4 fill-[#FF8CBD]" viewBox="0 0 24 24"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    <span>FASHION RUNWAY & EDITORIAL MODELS</span>
                </span>
                <span class="mx-6 flex items-center gap-3">
                    <svg class="w-4 h-4 fill-[#FCF27B]" viewBox="0 0 24 24"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    <span>VIRAL INSTAGRAM REELS CREATORS</span>
                </span>
                <span class="mx-6 flex items-center gap-3">
                    <svg class="w-4 h-4 fill-[#9ECAF2]" viewBox="0 0 24 24"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    <span>LIVE EVENT EMCEES & BROADCAST HOSTS</span>
                </span>
                <span class="mx-6 flex items-center gap-3">
                    <svg class="w-4 h-4 fill-[#CBAAF6]" viewBox="0 0 24 24"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    <span>100% ESCROW MILESTONE SECURITY</span>
                </span>
            </div>
        </div>

        <!-- 3. INTEREST: WHAT WE DO / GAPLESS BENTO GRID -->
        <section id="services" class="py-24 sm:py-32 px-4 sm:px-6 relative">
            <div class="max-w-7xl mx-auto">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#CBAAF6] border-2 border-[#2B135A] text-[#2B135A] text-xs font-mono font-bold mb-4 shadow-xs">
                            <i class="fa-solid fa-layer-group"></i> THE THREE PILLARS
                        </div>
                        <h2 class="font-display font-black text-3xl sm:text-5xl text-[#2B135A] tracking-tight">
                            Built for brands that refuse to look boring.
                        </h2>
                    </div>
                    <p class="text-sm sm:text-base text-[#2B135A]/70 max-w-md mt-4 md:mt-0 font-medium leading-relaxed">
                        Every collaboration is backed by authentic creative direction, legal commercial licensing, and zero bot fraud.
                    </p>
                </div>

                <!-- Gapless Bento Grid with grid-flow-dense -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 grid-flow-dense">
                    
                    <!-- Bento Card 1: Influencer Marketing (Col-Span 2 on Desktop) -->
                    <div class="md:col-span-2 bg-[#FCF27B] border-2 border-[#2B135A] rounded-3xl p-8 sticker-card flex flex-col justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-xs font-mono font-black uppercase bg-white text-[#2B135A] px-3 py-1 rounded-full border border-[#2B135A]">PILLAR 01 &bull; VIRAL REELS</span>
                                <span class="text-xs font-mono font-bold text-[#A71F5F]"><i class="fa-brands fa-instagram text-base mr-1"></i> META GRAPH SYNC</span>
                            </div>
                            <h3 class="font-display font-black text-2xl sm:text-4xl text-[#2B135A] mb-3">
                                Creator Campaigns that Dominate the FYP
                            </h3>
                            <p class="text-sm sm:text-base text-[#2B135A]/80 font-medium max-w-xl mb-8 leading-relaxed">
                                We match your brand with native Instagram video creators who understand hook retention, trending audio pacing, and genuine product integration.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 bg-white/90 backdrop-blur-md rounded-2xl p-4 border-2 border-[#2B135A] text-xs font-mono relative z-10">
                            <div class="p-2 border-b sm:border-b-0 sm:border-r border-[#2B135A]/20">
                                <div class="text-[10px] text-[#2B135A]/60 uppercase">AUDIENCE VETTING</div>
                                <div class="font-black text-[#2B135A] mt-0.5">0% Bot Tolerance</div>
                            </div>
                            <div class="p-2 border-b sm:border-b-0 sm:border-r border-[#2B135A]/20">
                                <div class="text-[10px] text-[#2B135A]/60 uppercase">USAGE RIGHTS</div>
                                <div class="font-black text-[#2B135A] mt-0.5">Whitelisted Ads</div>
                            </div>
                            <div class="p-2">
                                <div class="text-[10px] text-[#2B135A]/60 uppercase">REPORTING</div>
                                <div class="font-black text-[#A71F5F] mt-0.5">Live ROI Graph</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bento Card 2: Fashion Models (Col-Span 1) -->
                    <div class="bg-[#CBAAF6] border-2 border-[#2B135A] rounded-3xl p-8 sticker-card flex flex-col justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-xs font-mono font-black uppercase bg-white text-[#2B135A] px-3 py-1 rounded-full border border-[#2B135A]">PILLAR 02</span>
                                <i class="fa-solid fa-vest-patches text-xl text-[#2B135A]"></i>
                            </div>
                            <h3 class="font-display font-black text-2xl text-[#2B135A] mb-3">
                                Runway & Fashion Models
                            </h3>
                            <p class="text-xs sm:text-sm text-[#2B135A]/80 font-medium leading-relaxed mb-6">
                                Verified digital comp cards with high-fashion credentials, commercial shoot experience, and international lookbook casting.
                            </p>
                        </div>
                        <button @click="demoModalOpen = true" class="w-full py-3 rounded-full bg-white text-[#2B135A] font-bold text-xs border-2 border-[#2B135A] hover:bg-[#2B135A] hover:text-[#FCF27B] transition flex items-center justify-center gap-2">
                            <span>Request Model Cast List</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>

                    <!-- Bento Card 3: Live Event Anchors (Col-Span 1) -->
                    <div class="bg-[#FF8CBD] border-2 border-[#2B135A] rounded-3xl p-8 sticker-card flex flex-col justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-xs font-mono font-black uppercase bg-white text-[#2B135A] px-3 py-1 rounded-full border border-[#2B135A]">PILLAR 03</span>
                                <i class="fa-solid fa-microphone-lines text-xl text-[#2B135A]"></i>
                            </div>
                            <h3 class="font-display font-black text-2xl text-[#2B135A] mb-3">
                                Live Event Anchors & Emcees
                            </h3>
                            <p class="text-xs sm:text-sm text-[#2B135A]/80 font-medium leading-relaxed mb-6">
                                High-energy red carpet moderators, summit anchors, and broadcast hosts ready for stage commanding presence.
                            </p>
                        </div>
                        <button @click="demoModalOpen = true" class="w-full py-3 rounded-full bg-white text-[#2B135A] font-bold text-xs border-2 border-[#2B135A] hover:bg-[#2B135A] hover:text-[#FF8CBD] transition flex items-center justify-center gap-2">
                            <span>Book Stage Anchor</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>

                    <!-- Bento Card 4: Milestone Escrow Security (Col-Span 2) -->
                    <div class="md:col-span-2 bg-white border-2 border-[#2B135A] rounded-3xl p-8 sticker-card flex flex-col justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-xs font-mono font-black uppercase bg-[#FAF7EE] text-[#2B135A] px-3 py-1 rounded-full border border-[#2B135A]">FINANCIAL ESCROW</span>
                                <span class="text-xs font-mono font-bold text-[#2B135A]"><i class="fa-solid fa-lock text-[#A71F5F] mr-1"></i> ZERO PAYMENT RISK</span>
                            </div>
                            <h3 class="font-display font-black text-2xl sm:text-3xl text-[#2B135A] mb-3">
                                100% Escrow Milestone Protection
                            </h3>
                            <p class="text-sm text-[#2B135A]/80 font-medium max-w-xl mb-6 leading-relaxed">
                                Never prepay talent into a black hole. Funds remain securely locked in milestone vaults until video proof of post and contract deliverables are signed off.
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-xs font-mono font-bold text-[#2B135A]">
                            <span class="px-3 py-1.5 rounded-xl bg-[#FAF7EE] border border-[#2B135A]"><i class="fa-solid fa-check text-[#A71F5F] mr-1"></i> Multi-Milestone Split</span>
                            <span class="px-3 py-1.5 rounded-xl bg-[#FAF7EE] border border-[#2B135A]"><i class="fa-solid fa-check text-[#A71F5F] mr-1"></i> Proof of Post Verification</span>
                            <span class="px-3 py-1.5 rounded-xl bg-[#FAF7EE] border border-[#2B135A]"><i class="fa-solid fa-check text-[#A71F5F] mr-1"></i> Dispute Resolution SLA</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 4. DESIRE: TALENT COMP CARDS / INTERACTIVE DISCOVERY -->
        <section id="talent" class="py-24 sm:py-32 px-4 sm:px-6 bg-[#FAF7EE] border-y-2 border-[#2B135A]/15 relative">
            <div class="max-w-7xl mx-auto">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#FCF27B] border-2 border-[#2B135A] text-[#2B135A] text-xs font-mono font-bold mb-3 shadow-xs">
                            <i class="fa-solid fa-star"></i> VIBE CHECKED ROSTER
                        </div>
                        <h2 class="font-display font-black text-3xl sm:text-5xl text-[#2B135A] tracking-tight">
                            Meet the Creators Setting the Standard.
                        </h2>
                    </div>

                    <!-- Filter Pill Tabs -->
                    <div class="flex flex-wrap items-center gap-2 mt-6 md:mt-0">
                        <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'bg-[#2B135A] text-[#FCF27B]' : 'bg-white text-[#2B135A] hover:bg-white/80'"
                                class="px-4 py-2 rounded-full border-2 border-[#2B135A] text-xs font-mono font-bold transition">
                            All Talent ({{ count($topTalents) }})
                        </button>
                        <button @click="activeFilter = 'model'" :class="activeFilter === 'model' ? 'bg-[#2B135A] text-[#FCF27B]' : 'bg-white text-[#2B135A] hover:bg-white/80'"
                                class="px-4 py-2 rounded-full border-2 border-[#2B135A] text-xs font-mono font-bold transition">
                            Fashion Models
                        </button>
                        <button @click="activeFilter = 'influencer'" :class="activeFilter === 'influencer' ? 'bg-[#2B135A] text-[#FCF27B]' : 'bg-white text-[#2B135A] hover:bg-white/80'"
                                class="px-4 py-2 rounded-full border-2 border-[#2B135A] text-xs font-mono font-bold transition">
                            Viral Creators
                        </button>
                        <button @click="activeFilter = 'anchor'" :class="activeFilter === 'anchor' ? 'bg-[#2B135A] text-[#FCF27B]' : 'bg-white text-[#2B135A] hover:bg-white/80'"
                                class="px-4 py-2 rounded-full border-2 border-[#2B135A] text-xs font-mono font-bold transition">
                            Event Anchors
                        </button>
                    </div>
                </div>

                <!-- Talent Comp Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($topTalents as $index => $talent)
                        @php
                            $cardColors = ['#FCF27B', '#CBAAF6', '#FF8CBD', '#9ECAF2', '#FAF7EE'];
                            $color = $cardColors[$index % count($cardColors)];
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
                             class="bg-white border-2 border-[#2B135A] rounded-3xl p-5 sticker-card flex flex-col justify-between relative group">
                            
                            <!-- Category Badge & Audio Waveform Pill -->
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[10px] font-mono uppercase bg-[{{ $color }}] text-[#2B135A] px-2.5 py-1 rounded-full border border-[#2B135A] font-black">
                                    {{ $talent->category->name ?? 'Fashion & Viral Video' }}
                                </span>
                                
                                <!-- Audio Waveform Indicator -->
                                <div class="flex items-center gap-1.5 bg-[#FAF7EE] px-2.5 py-1 rounded-full border border-[#2B135A]/30">
                                    <div class="flex items-end gap-0.5 h-3">
                                        <span class="w-1 bg-[#A71F5F] rounded-full animate-waveform wave-bar"></span>
                                        <span class="w-1 bg-[#A71F5F] rounded-full animate-waveform wave-bar"></span>
                                        <span class="w-1 bg-[#A71F5F] rounded-full animate-waveform wave-bar"></span>
                                        <span class="w-1 bg-[#A71F5F] rounded-full animate-waveform wave-bar"></span>
                                    </div>
                                    <span class="text-[10px] font-mono font-bold text-[#2B135A]">{{ $engagement }}% Eng</span>
                                </div>
                            </div>

                            <!-- Photo Box with IG Handle Badge -->
                            <div class="relative overflow-hidden rounded-2xl border-2 border-[#2B135A] aspect-[4/3] mb-4 bg-[#FAF7EE]">
                                <img src="{{ $avatar }}" alt="{{ $name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute bottom-2 left-2 bg-white/95 backdrop-blur-md px-3 py-1 rounded-full border border-[#2B135A] text-xs font-mono font-bold text-[#2B135A]">
                                    <i class="fa-brands fa-instagram text-[#A71F5F] mr-1"></i> {{ '@' . ltrim($igHandle, '@') }}
                                </div>
                            </div>

                            <!-- Talent Metrics -->
                            <div>
                                <h3 class="font-display font-black text-lg text-[#2B135A] flex items-center justify-between mb-1">
                                    <span>{{ $name }}</span>
                                    <i class="fa-solid fa-circle-check text-[#A71F5F] text-sm" title="Meta Graph Verified"></i>
                                </h3>
                                <p class="text-xs text-[#2B135A]/70 line-clamp-2 mb-4 leading-relaxed">
                                    {{ $talent->bio ?? 'Verified Instagram talent specialized in high-converting reels, lookbook shoots, and corporate stage emcee.' }}
                                </p>

                                <div class="grid grid-cols-2 gap-2 bg-[#FAF7EE] p-2.5 rounded-xl border border-[#2B135A]/15 text-center text-xs font-mono mb-4">
                                    <div>
                                        <div class="text-[10px] text-[#2B135A]/50 uppercase">AUDIENCE</div>
                                        <div class="font-black text-[#2B135A]">{{ is_numeric($followers) ? number_format($followers) : $followers }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-[#2B135A]/50 uppercase">AVG REEL VIEWS</div>
                                        <div class="font-black text-[#A71F5F]">{{ rand(55, 340) }}K / Reel</div>
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
                                    class="w-full py-2.5 rounded-full bg-[#2B135A] text-[#FCF27B] font-display font-black text-xs border-2 border-[#2B135A] hover:bg-[#FCF27B] hover:text-[#2B135A] transition flex items-center justify-center gap-2">
                                <i class="fa-regular fa-eye"></i>
                                <span>Inspect Comp Card</span>
                            </button>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12 bg-white rounded-3xl border-2 border-[#2B135A]">
                            <p class="font-mono text-sm text-[#2B135A]/70">No talents available right now.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </section>

        <!-- 5. INTERACTIVE ROI CALCULATOR & CAMPAIGN PLANNER -->
        <section id="calculator" class="py-24 sm:py-32 px-4 sm:px-6 relative">
            <div class="max-w-7xl mx-auto">
                
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#9ECAF2] border-2 border-[#2B135A] text-[#2B135A] text-xs font-mono font-bold mb-4 shadow-xs">
                        <i class="fa-solid fa-calculator"></i> TRANSPARENT PRICING
                    </div>
                    <h2 class="font-display font-black text-3xl sm:text-5xl text-[#2B135A] tracking-tight mb-3">
                        Instant Campaign Estimator
                    </h2>
                    <p class="text-sm sm:text-base text-[#2B135A]/75 font-medium">
                        Model your reach, engagement, and milestone escrow budget in real-time.
                    </p>
                </div>

                <!-- Calculator Container -->
                <div class="bg-white border-2 border-[#2B135A] rounded-3xl p-6 sm:p-10 lg:p-12 shadow-[0_16px_40px_rgba(43,19,90,0.08)] max-w-4xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        
                        <!-- Inputs (7 cols) -->
                        <div class="lg:col-span-7 space-y-6">
                            
                            <!-- Talent Category Selector -->
                            <div>
                                <label class="block text-xs font-mono font-black uppercase text-[#2B135A] mb-2">Talent Discipline</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <button @click="calcType = 'influencer'" :class="calcType === 'influencer' ? 'bg-[#FCF27B] border-[#2B135A]' : 'bg-[#FAF7EE] border-[#2B135A]/30'"
                                            class="py-2.5 px-3 rounded-xl border-2 text-xs font-bold text-[#2B135A] transition text-center">
                                        <i class="fa-brands fa-instagram block text-base mb-1"></i> Viral Creator
                                    </button>
                                    <button @click="calcType = 'modeling'" :class="calcType === 'modeling' ? 'bg-[#CBAAF6] border-[#2B135A]' : 'bg-[#FAF7EE] border-[#2B135A]/30'"
                                            class="py-2.5 px-3 rounded-xl border-2 text-xs font-bold text-[#2B135A] transition text-center">
                                        <i class="fa-solid fa-vest-patches block text-base mb-1"></i> Fashion Model
                                    </button>
                                    <button @click="calcType = 'anchor'" :class="calcType === 'anchor' ? 'bg-[#FF8CBD] border-[#2B135A]' : 'bg-[#FAF7EE] border-[#2B135A]/30'"
                                            class="py-2.5 px-3 rounded-xl border-2 text-xs font-bold text-[#2B135A] transition text-center">
                                        <i class="fa-solid fa-microphone block text-base mb-1"></i> Stage Anchor
                                    </button>
                                </div>
                            </div>

                            <!-- Follower Slider -->
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="text-xs font-mono font-black uppercase text-[#2B135A]">Follower Scale</label>
                                    <span class="text-xs font-mono font-black text-[#A71F5F]" x-text="calcFollowers.toLocaleString() + ' IG Followers'"></span>
                                </div>
                                <input type="range" min="10000" max="1000000" step="10000" x-model="calcFollowers"
                                       class="w-full h-3 bg-[#FAF7EE] rounded-lg appearance-none cursor-pointer accent-[#2B135A] border border-[#2B135A]/30">
                                <div class="flex justify-between text-[10px] font-mono text-[#2B135A]/50 mt-1">
                                    <span>Micro (10K)</span>
                                    <span>Mid-Tier (250K)</span>
                                    <span>Macro (1M+)</span>
                                </div>
                            </div>

                            <!-- Deliverable Scope -->
                            <div>
                                <label class="block text-xs font-mono font-black uppercase text-[#2B135A] mb-2">Deliverable Package</label>
                                <select x-model="calcDeliverable" class="w-full bg-[#FAF7EE] border-2 border-[#2B135A] rounded-xl px-4 py-3 text-xs font-mono font-bold text-[#2B135A] focus:outline-none">
                                    <option value="story">1x Instagram Story Sequence (3 Frames)</option>
                                    <option value="reel_story">1x Hero Reel + 2x Amplification Stories</option>
                                    <option value="campaign">Full Commercial Shoot / 30-Day Brand Usage</option>
                                </select>
                            </div>

                        </div>

                        <!-- Results Card (5 cols) -->
                        <div class="lg:col-span-5 bg-[#2B135A] text-[#F6F4E5] rounded-2xl p-6 border-2 border-[#2B135A] flex flex-col justify-between space-y-6 shadow-md">
                            <div>
                                <div class="text-[10px] font-mono uppercase text-[#FCF27B] font-bold mb-1">ESTIMATED IMPRESSIONS</div>
                                <div class="text-3xl font-display font-black text-white mb-4" x-text="estimatedReach.toLocaleString() + ' Views'"></div>

                                <div class="space-y-2 border-t border-white/10 pt-4 text-xs font-mono">
                                    <div class="flex justify-between text-white/70">
                                        <span>Target Engagement:</span>
                                        <span class="text-[#FCF27B] font-bold">~5.2% - 7.6%</span>
                                    </div>
                                    <div class="flex justify-between text-white/70">
                                        <span>Escrow Security:</span>
                                        <span class="text-white font-bold">100% Protected</span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-white/10 pt-4">
                                <div class="text-[10px] font-mono uppercase text-[#FCF27B] font-bold mb-1">PROJECTED ESCROW BUDGET</div>
                                <div class="text-3xl font-display font-black text-[#FCF27B]" x-text="'$' + estimatedRate.toLocaleString() + ' USD'"></div>
                                <p class="text-[10px] font-mono text-white/50 mt-1">Includes usage rights & Meta Graph post audit.</p>

                                <button @click="demoModalOpen = true" class="w-full mt-4 py-3 rounded-full bg-[#FCF27B] text-[#2B135A] font-display font-black text-xs hover:bg-[#FFE5E7] transition">
                                    Lock In Campaign Slot &rarr;
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- 6. "WHY WE'RE BUILT DIFFERENT" / AGENCY COMPARISON BENTO -->
        <section id="differentiators" class="py-24 sm:py-32 px-4 sm:px-6 bg-[#FAF7EE] border-y-2 border-[#2B135A]/15 relative">
            <div class="max-w-7xl mx-auto">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#FCF27B] border-2 border-[#2B135A] text-[#2B135A] text-xs font-mono font-bold mb-4 shadow-xs">
                        <i class="fa-solid fa-bolt"></i> THE HYPEMARKET STANDARD
                    </div>
                    <h2 class="font-display font-black text-3xl sm:text-5xl text-[#2B135A] tracking-tight mb-4">
                        Why We're Built Different.
                    </h2>
                    <p class="text-sm sm:text-base text-[#2B135A]/75 font-medium">
                        How HypeMarket replaces traditional agency friction with fast, data-backed execution.
                    </p>
                </div>

                <!-- 4 Value Bento Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <div class="bg-[#FCF27B] border-2 border-[#2B135A] rounded-3xl p-6 sticker-card flex flex-col justify-between">
                        <div class="w-10 h-10 rounded-xl bg-white border-2 border-[#2B135A] flex items-center justify-center text-[#2B135A] text-lg font-black mb-6">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-xl text-[#2B135A] mb-2">Meta Graph Sync</h3>
                            <p class="text-xs text-[#2B135A]/80 leading-relaxed font-medium">
                                Real audience demographics directly from Instagram API. No falsified media kit screenshots.
                            </p>
                        </div>
                    </div>

                    <div class="bg-[#CBAAF6] border-2 border-[#2B135A] rounded-3xl p-6 sticker-card flex flex-col justify-between">
                        <div class="w-10 h-10 rounded-xl bg-white border-2 border-[#2B135A] flex items-center justify-center text-[#2B135A] text-lg font-black mb-6">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-xl text-[#2B135A] mb-2">100% Escrow Vault</h3>
                            <p class="text-xs text-[#2B135A]/80 leading-relaxed font-medium">
                                Funds released exclusively upon verified proof of post and approved milestone deliverables.
                            </p>
                        </div>
                    </div>

                    <div class="bg-[#FF8CBD] border-2 border-[#2B135A] rounded-3xl p-6 sticker-card flex flex-col justify-between">
                        <div class="w-10 h-10 rounded-xl bg-white border-2 border-[#2B135A] flex items-center justify-center text-[#2B135A] text-lg font-black mb-6">
                            <i class="fa-solid fa-stopwatch"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-xl text-[#2B135A] mb-2">48h Turnaround</h3>
                            <p class="text-xs text-[#2B135A]/80 leading-relaxed font-medium">
                                Confirmed talent availability and shortlists within two business days. No ghosting.
                            </p>
                        </div>
                    </div>

                    <div class="bg-[#9ECAF2] border-2 border-[#2B135A] rounded-3xl p-6 sticker-card flex flex-col justify-between">
                        <div class="w-10 h-10 rounded-xl bg-white border-2 border-[#2B135A] flex items-center justify-center text-[#2B135A] text-lg font-black mb-6">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-black text-xl text-[#2B135A] mb-2">Legal Ad Rights</h3>
                            <p class="text-xs text-[#2B135A]/80 leading-relaxed font-medium">
                                Standardized commercial ad usage contracts and whitelisted ad account integrations.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 7. ACTION: DUAL CONVERSION FUNNEL (BRANDS VS CREATORS) -->
        <section class="py-24 sm:py-32 px-4 sm:px-6 relative">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Card A: Brands -->
                    <div class="bg-[#FCF27B] border-2 border-[#2B135A] rounded-3xl p-8 sm:p-12 sticker-card flex flex-col justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <span class="inline-block text-xs font-mono font-black uppercase bg-white text-[#2B135A] px-3 py-1 rounded-full border border-[#2B135A] mb-4">FOR BRANDS & AGENCIES</span>
                            <h3 class="font-display font-black text-3xl sm:text-4xl text-[#2B135A] mb-4">
                                Ready to launch your next high-ROI campaign?
                            </h3>
                            <p class="text-sm text-[#2B135A]/80 font-medium leading-relaxed mb-8">
                                Connect with curated creators, receive verified comp cards, and secure your deliverables with milestone protection.
                            </p>
                        </div>
                        <div class="relative z-10">
                            <button @click="demoModalOpen = true" class="btn text-sm py-3.5 px-8"
                                    style="--bg-color: var(--Dark-Amethyst); --border-color: var(--Dark-Amethyst); --circle-color: var(--White); --text-color: var(--Banana-Cream); --hover-text-color: var(--Dark-Amethyst);">
                                <div class="btn__bg"></div>
                                <div class="btn__circle-wrap"><div class="btn__circle"></div></div>
                                <span class="btn__text font-black">
                                    <span>Schedule Agency Briefing</span>
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Card B: Talent -->
                    <div class="bg-[#CBAAF6] border-2 border-[#2B135A] rounded-3xl p-8 sm:p-12 sticker-card flex flex-col justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <span class="inline-block text-xs font-mono font-black uppercase bg-white text-[#2B135A] px-3 py-1 rounded-full border border-[#2B135A] mb-4">FOR TALENT & MODELS</span>
                            <h3 class="font-display font-black text-3xl sm:text-4xl text-[#2B135A] mb-4">
                                Elevate your career with verified brand deals.
                            </h3>
                            <p class="text-sm text-[#2B135A]/80 font-medium leading-relaxed mb-8">
                                Get represented by HypeMarket. Receive guaranteed payments on time with automated milestone escrow contracts.
                            </p>
                        </div>
                        <div class="relative z-10">
                            <a href="{{ route('register') }}" class="btn text-sm py-3.5 px-8 inline-flex"
                               style="--bg-color: var(--White); --border-color: var(--Dark-Amethyst); --circle-color: var(--Dark-Amethyst); --text-color: var(--Dark-Amethyst); --hover-text-color: var(--White);">
                                <div class="btn__bg"></div>
                                <div class="btn__circle-wrap"><div class="btn__circle"></div></div>
                                <span class="btn__text font-black">
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
    <footer id="footer" class="bg-[#2B135A] text-[#F6F4E5] pt-24 pb-12 px-4 sm:px-6 border-t-2 border-[#2B135A] relative overflow-hidden">
        <div class="max-w-7xl mx-auto">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 pb-16 border-b border-white/10">
                
                <!-- Brand Info (5 cols) -->
                <div class="md:col-span-5 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-[#FCF27B] border border-white flex items-center justify-center font-display font-black text-[#2B135A] text-base">
                            <svg class="w-5 h-5 fill-[#2B135A]" viewBox="0 0 24 24"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                        </div>
                        <span class="font-display font-black text-2xl text-white">Hype<span class="text-[#FF8CBD]">Market</span></span>
                    </div>

                    <p class="text-sm text-white/70 max-w-sm leading-relaxed font-medium">
                        The curated strategic agency for Instagram fashion models, viral creators, and live event anchors. Backed by real-time Meta Graph API intelligence and milestone escrow security.
                    </p>

                    <div class="flex items-center space-x-3 text-sm">
                        <a href="#" class="w-9 h-9 rounded-full bg-white/10 hover:bg-[#FCF27B] hover:text-[#2B135A] border border-white/20 flex items-center justify-center transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-white/10 hover:bg-[#CBAAF6] hover:text-[#2B135A] border border-white/20 flex items-center justify-center transition">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-white/10 hover:bg-[#9ECAF2] hover:text-[#2B135A] border border-white/20 flex items-center justify-center transition">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigation Columns (7 cols) -->
                <div class="md:col-span-7 grid grid-cols-2 sm:grid-cols-3 gap-8">
                    <div>
                        <h4 class="font-display font-bold text-xs uppercase text-[#FCF27B] tracking-wider mb-4 font-mono">Agency</h4>
                        <ul class="space-y-2.5 text-xs text-white/70 font-medium">
                            <li><a href="#services" class="hover:text-white transition">What We Do</a></li>
                            <li><a href="#talent" class="hover:text-white transition">Talent Comp Cards</a></li>
                            <li><a href="#calculator" class="hover:text-white transition">ROI Estimator</a></li>
                            <li><a href="#differentiators" class="hover:text-white transition">Why Us</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-display font-bold text-xs uppercase text-[#CBAAF6] tracking-wider mb-4 font-mono">Talent Hub</h4>
                        <ul class="space-y-2.5 text-xs text-white/70 font-medium">
                            <li><a href="#talent" class="hover:text-white transition">Fashion Models</a></li>
                            <li><a href="#talent" class="hover:text-white transition">Viral Creators</a></li>
                            <li><a href="#talent" class="hover:text-white transition">Event Anchors</a></li>
                            <li><a href="{{ route('influencers.public') }}" class="hover:text-white transition">Full Directory</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-display font-bold text-xs uppercase text-[#FF8CBD] tracking-wider mb-4 font-mono">Trust & Legal</h4>
                        <ul class="space-y-2.5 text-xs text-white/70 font-medium">
                            <li><a href="{{ route('privacy') }}" class="hover:text-white transition">Privacy Policy</a></li>
                            <li><a href="{{ route('terms') }}" class="hover:text-white transition">Terms of Service</a></li>
                            <li><a href="{{ route('data-deletion') }}" class="hover:text-white transition">Data Deletion</a></li>
                            <li><a href="{{ route('how-it-works') }}" class="hover:text-white transition">Escrow Protection</a></li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Giant Watermark Typography -->
            <div class="pt-16 text-center select-none opacity-20 hover:opacity-30 transition-opacity">
                <span class="font-display font-black text-6xl sm:text-8xl lg:text-9xl tracking-tighter text-white">
                    HYPEMARKET
                </span>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs font-mono text-white/50 border-t border-white/5 mt-8">
                <div>&copy; {{ date('Y') }} HypeMarket Agency. All rights reserved.</div>
                <div class="mt-2 sm:mt-0 flex gap-4">
                    <span>Meta Graph API Verified</span>
                    <span>100% Escrow Protected</span>
                </div>
            </div>

        </div>
    </footer>

    <!-- QUICK COMP CARD MODAL (ALPINE.JS) -->
    <div x-show="quickModalOpen" 
         x-transition.opacity
         class="fixed inset-0 z-50 bg-[#2B135A]/80 backdrop-blur-sm flex items-center justify-center p-4"
         style="display: none;">
        
        <div @click.outside="quickModalOpen = false" 
             x-show="quickModalOpen"
             x-transition.scale
             class="bg-white border-2 border-[#2B135A] rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl relative text-[#2B135A]">
            
            <button @click="quickModalOpen = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-[#FAF7EE] border border-[#2B135A] flex items-center justify-center text-[#2B135A] hover:bg-[#FF8CBD] transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>

            <template x-if="selectedTalent">
                <div>
                    <div class="flex items-center gap-4 mb-4">
                        <img :src="selectedTalent.avatar" :alt="selectedTalent.name" class="w-16 h-16 rounded-2xl object-cover border-2 border-[#2B135A]">
                        <div>
                            <span class="text-[10px] font-mono uppercase bg-[#FCF27B] text-[#2B135A] px-2 py-0.5 rounded-full border border-[#2B135A] font-bold inline-block mb-1" x-text="selectedTalent.category"></span>
                            <h3 class="font-display font-black text-xl text-[#2B135A]" x-text="selectedTalent.name"></h3>
                            <p class="text-xs font-mono text-[#A71F5F] font-bold" x-text="selectedTalent.handle"></p>
                        </div>
                    </div>

                    <p class="text-xs text-[#2B135A]/80 leading-relaxed mb-5" x-text="selectedTalent.bio"></p>

                    <div class="grid grid-cols-2 gap-3 bg-[#FAF7EE] p-3 rounded-2xl border border-[#2B135A]/15 text-center text-xs font-mono mb-6">
                        <div>
                            <div class="text-[10px] text-[#2B135A]/50">TOTAL AUDIENCE</div>
                            <div class="font-black text-sm text-[#2B135A]" x-text="selectedTalent.followers"></div>
                        </div>
                        <div>
                            <div class="text-[10px] text-[#2B135A]/50">ENGAGEMENT RATE</div>
                            <div class="font-black text-sm text-[#A71F5F]" x-text="selectedTalent.engagement"></div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button @click="quickModalOpen = false; demoModalOpen = true" class="w-full py-3 rounded-full bg-[#2B135A] text-[#FCF27B] font-display font-black text-xs hover:bg-[#A71F5F] hover:text-white transition">
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
         class="fixed inset-0 z-50 bg-[#2B135A]/80 backdrop-blur-sm flex items-center justify-center p-4"
         style="display: none;">
        
        <div @click.outside="demoModalOpen = false" 
             x-show="demoModalOpen"
             x-transition.scale
             class="bg-white border-2 border-[#2B135A] rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl relative text-[#2B135A]">
            
            <button @click="demoModalOpen = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-[#FAF7EE] border border-[#2B135A] flex items-center justify-center text-[#2B135A] hover:bg-[#FF8CBD] transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#FCF27B] border border-[#2B135A] text-[#2B135A] text-[10px] font-mono font-bold mb-3">
                <i class="fa-solid fa-calendar-check"></i> VIP AGENCY BRIEFING
            </div>
            <h3 class="font-display font-black text-2xl text-[#2B135A] mb-2">Book a Demo</h3>
            <p class="text-xs text-[#2B135A]/70 mb-5">Share your campaign scope and our talent directors will deliver a custom comp card shortlist in under 24 hours.</p>

            <form @submit.prevent="demoModalOpen = false; alert('Thank you! Our talent directors will contact you within 24 hours.')" class="space-y-3">
                <div>
                    <label class="block text-[10px] font-mono font-bold uppercase text-[#2B135A] mb-1">Your Name</label>
                    <input type="text" required placeholder="Alex Rivera" class="w-full bg-[#FAF7EE] border-2 border-[#2B135A] rounded-xl px-3 py-2 text-xs font-mono text-[#2B135A] focus:outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-mono font-bold uppercase text-[#2B135A] mb-1">Work Email</label>
                    <input type="email" required placeholder="alex@brand.com" class="w-full bg-[#FAF7EE] border-2 border-[#2B135A] rounded-xl px-3 py-2 text-xs font-mono text-[#2B135A] focus:outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-mono font-bold uppercase text-[#2B135A] mb-1">Talent Scope</label>
                    <select class="w-full bg-[#FAF7EE] border-2 border-[#2B135A] rounded-xl px-3 py-2 text-xs font-mono text-[#2B135A] focus:outline-none">
                        <option>Viral Instagram Reels Creators</option>
                        <option>Fashion & Runway Models</option>
                        <option>Live Event Anchors & Emcees</option>
                        <option>Multi-Vertical Brand Campaign</option>
                    </select>
                </div>
                <button type="submit" class="w-full mt-2 py-3 rounded-full bg-[#2B135A] text-[#FCF27B] font-display font-black text-xs hover:bg-[#FCF27B] hover:text-[#2B135A] transition border-2 border-[#2B135A]">
                    Confirm Agency Request &rarr;
                </button>
            </form>

        </div>
    </div>

    <!-- ADVANCED GSAP SCROLLTRIGGER & LENIS MOTION SCRIPT -->
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

                gsap.from('#home .btn', {
                    y: 25,
                    opacity: 0,
                    duration: 0.8,
                    stagger: 0.15,
                    delay: 0.3,
                    ease: 'power3.out'
                });

                gsap.utils.toArray('.sticker-card').forEach((card) => {
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
