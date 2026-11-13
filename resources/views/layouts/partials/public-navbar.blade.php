    <header class="sticky top-4 z-40 px-4 sm:px-6 mb-4">
        <div class="max-w-7xl mx-auto">
            <nav class="bg-white/85 backdrop-blur-2xl border-2 border-[#181528] rounded-full px-4 sm:px-6 py-3 flex items-center justify-between shadow-[4px_4px_0_#181528] transition-all duration-300" x-data="{ open: false }">
                
                <!-- Brand Signature -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-9 h-9 rounded-full bg-[#E2F163] border-2 border-[#181528] flex items-center justify-center font-display font-black text-[#181528] text-base group-hover:scale-105 transition-transform duration-300 shadow-[2px_2px_0_#181528]">
                        <span class="tracking-tighter text-sm font-extrabold">H<span class="text-[#FF3E14] text-xs">&lowast;</span></span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-display font-black text-sm sm:text-base tracking-tight text-[#181528] flex items-center gap-1.5">
                            Hype<span class="text-[#FF3E14]">Market</span>
                            <span class="text-[9px] font-mono uppercase bg-[#E2F163] text-[#181528] px-2 py-0.5 rounded-full border border-[#181528] font-bold hidden sm:inline-block shadow-[1px_1px_0_#181528]">TALENT HUB</span>
                        </span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center space-x-1 text-xs font-bold font-sans text-[#524B66]">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-full transition-all duration-200 {{ request()->routeIs('home') ? 'bg-[#181528] text-[#E2F163] shadow-[2px_2px_0_#181528]' : 'hover:text-[#181528] hover:bg-black/5' }}">
                        Discover
                    </a>
                    <a href="{{ route('influencers.public') }}" class="px-3.5 py-2 rounded-full transition-all duration-200 {{ request()->routeIs('influencers.public*') ? 'bg-[#181528] text-[#E2F163] shadow-[2px_2px_0_#181528]' : 'hover:text-[#181528] hover:bg-black/5' }}">
                        Talent Directory
                    </a>
                    <a href="{{ route('campaigns.public') }}" class="px-3.5 py-2 rounded-full transition-all duration-200 {{ request()->routeIs('campaigns.public*') ? 'bg-[#181528] text-[#E2F163] shadow-[2px_2px_0_#181528]' : 'hover:text-[#181528] hover:bg-black/5' }}">
                        Campaign Briefs
                    </a>
                    <a href="{{ route('how-it-works') }}" class="px-3.5 py-2 rounded-full transition-all duration-200 {{ request()->routeIs('how-it-works') ? 'bg-[#181528] text-[#E2F163] shadow-[2px_2px_0_#181528]' : 'hover:text-[#181528] hover:bg-black/5' }}">
                        How It Works
                    </a>
                    <a href="{{ route('pricing') }}" class="px-3.5 py-2 rounded-full transition-all duration-200 {{ request()->routeIs('pricing') ? 'bg-[#181528] text-[#E2F163] shadow-[2px_2px_0_#181528]' : 'hover:text-[#181528] hover:bg-black/5' }}">
                        Pricing
                    </a>
                </div>

                <!-- Right Action Island -->
                <div class="hidden md:flex items-center space-x-3 text-xs font-bold font-sans">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hm-btn inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-[#181528] text-white transition">
                                <span class="w-2 h-2 rounded-full bg-[#E2F163] animate-ping"></span>
                                <span>Admin Gateway</span>
                            </a>
                        @elseif(auth()->user()->isBrand())
                            <a href="{{ route('brand.dashboard') }}" class="hm-btn inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-[#E2F163] text-[#181528] font-black hover:bg-[#D4E64A] transition">
                                <span>Brand Studio</span>
                            </a>
                        @else
                            <a href="{{ route('influencer.dashboard') }}" class="hm-btn inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-[#F47FA2] text-[#181528] font-black hover:bg-pink-300 transition">
                                <span>Creator Studio</span>
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-[#827B96] hover:text-[#181528] transition" title="Log out">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="font-extrabold text-[#524B66] hover:text-[#181528] px-3 py-2 transition">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center rounded-full bg-[#181528] text-white px-5 py-2 text-xs font-black hover:bg-[#FF3E14] transition-all duration-300 shadow-[3px_3px_0_#181528] border-2 border-[#181528] active:translate-x-[2px] active:translate-y-[2px] space-x-1.5">
                            <span>Join Marketplace</span>
                            <div class="w-4 h-4 rounded-full bg-[#E2F163] text-[#181528] flex items-center justify-center text-[9px] group-hover:bg-white transition">
                                <i class="fa-solid fa-arrow-right"></i>
                            </div>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <button @click="open = !open" class="md:hidden w-9 h-9 rounded-full bg-black/5 flex items-center justify-center text-[#181528] hover:bg-black/10 transition border border-[#181528]/20">
                    <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </nav>

            <!-- Mobile Dropdown -->
            <div x-show="open" x-cloak class="md:hidden mt-2 bg-white/95 backdrop-blur-2xl border-2 border-[#181528] rounded-3xl p-5 shadow-[6px_6px_0_#181528] space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl text-[#181528] font-bold hover:bg-[#FAF5EC]">Discover</a>
                <a href="{{ route('influencers.public') }}" class="block px-3 py-2 rounded-xl text-[#181528] font-bold hover:bg-[#FAF5EC]">Talent Directory</a>
                <a href="{{ route('campaigns.public') }}" class="block px-3 py-2 rounded-xl text-[#181528] font-bold hover:bg-[#FAF5EC]">Campaign Briefs</a>
                <a href="{{ route('how-it-works') }}" class="block px-3 py-2 rounded-xl text-[#181528] font-bold hover:bg-[#FAF5EC]">How It Works</a>
                <a href="{{ route('pricing') }}" class="block px-3 py-2 rounded-xl text-[#181528] font-bold hover:bg-[#FAF5EC]">Pricing</a>
                <div class="pt-3 border-t-2 border-[#181528]/10 space-y-2">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block w-full text-center py-2.5 rounded-full font-black bg-[#181528] text-white">Admin Gateway</a>
                        @elseif(auth()->user()->isBrand())
                            <a href="{{ route('brand.dashboard') }}" class="block w-full text-center py-2.5 rounded-full font-black bg-[#E2F163] text-[#181528] border-2 border-[#181528]">Brand Studio</a>
                        @else
                            <a href="{{ route('influencer.dashboard') }}" class="block w-full text-center py-2.5 rounded-full font-black bg-[#F47FA2] text-[#181528] border-2 border-[#181528]">Creator Studio</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-center py-2 text-[#827B96] hover:text-[#181528] text-xs font-bold">Log out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center py-2.5 rounded-full text-[#181528] bg-[#FAF5EC] hover:bg-slate-200 font-black text-xs border-2 border-[#181528]">Sign In</a>
                        <a href="{{ route('register') }}" class="block w-full text-center py-2.5 rounded-full bg-[#181528] text-white font-black text-xs hover:bg-[#FF3E14] border-2 border-[#181528]">Join Marketplace</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>
