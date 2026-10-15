<!-- Global Command Palette (Ctrl+K) -->
<div x-data="{
    openPalette: false,
    query: '',
    items: [
        @if(auth()->check() && (auth()->user()->role === 'talent' || auth()->user()->role === 'influencer'))
            { title: 'Creator Dashboard', category: 'Navigation', url: '{{ route('influencer.dashboard') }}', icon: 'zap' },
            { title: 'Open Brand Jobs & Campaigns', category: 'Jobs', url: '{{ route('influencer.campaigns') }}', icon: 'briefcase' },
            { title: 'My Portfolio & Work Showcase', category: 'Portfolio', url: '{{ route('influencer.portfolio') }}', icon: 'palette' },
            { title: 'Gigs & Pricing Packages', category: 'Services', url: '{{ route('influencer.rates') }}', icon: 'coins' },
            { title: 'Social Accounts & Live Sync', category: 'Channels', url: '{{ route('influencer.social') }}', icon: 'smartphone' },
            { title: 'Bookings & Orders', category: 'Orders', url: '{{ route('influencer.bookings') }}', icon: 'clipboard-list' },
            { title: 'Invoices & Payout Receipts', category: 'Finance', url: '{{ route('influencer.invoices') }}', icon: 'receipt' },
            { title: 'Messages & Offers', category: 'Chat', url: '{{ route('influencer.messages') }}', icon: 'message-square' },
            { title: 'Notifications', category: 'Alerts', url: '{{ route('influencer.notifications') }}', icon: 'bell' },
            { title: 'Edit Creator Profile', category: 'Account', url: '{{ route('influencer.profile') }}', icon: 'settings' },
        @elseif(auth()->check() && auth()->user()->role === 'brand')
            { title: 'Brand Studio Dashboard', category: 'Navigation', url: '{{ route('brand.dashboard') }}', icon: 'layout-dashboard' },
            { title: 'Post New Job / Campaign Brief', category: 'Campaigns', url: '{{ route('brand.campaigns.create') }}', icon: 'plus-circle' },
            { title: 'Manage Campaigns & Jobs', category: 'Campaigns', url: '{{ route('brand.campaigns') }}', icon: 'briefcase' },
            { title: 'Search & Discover Talent', category: 'Creators', url: '{{ route('influencers.public') }}', icon: 'search' },
            { title: 'Bookings & Hired Talent', category: 'Bookings', url: '{{ route('brand.bookings') }}', icon: 'clipboard-list' },
            { title: 'Tax Invoices & Billing Ledger', category: 'Finance', url: '{{ route('brand.invoices') }}', icon: 'receipt' },
            { title: 'Messages & Counter-Offers', category: 'Chat', url: '{{ route('brand.messages') }}', icon: 'message-square' },
            { title: 'Notifications', category: 'Alerts', url: '{{ route('brand.notifications') }}', icon: 'bell' },
            { title: 'Company Profile & KYC', category: 'Account', url: '{{ route('brand.profile') }}', icon: 'settings' },
        @elseif(auth()->check() && auth()->user()->role === 'admin')
            { title: 'Admin Central Dashboard', category: 'Overview', url: '{{ route('admin.dashboard') }}', icon: 'shield-check' },
            { title: 'Manage Brand Profiles', category: 'Users', url: '{{ route('admin.brands') }}', icon: 'building-2' },
            { title: 'Manage Talent & Verification', category: 'Users', url: '{{ route('admin.influencers') }}', icon: 'users' },
            { title: 'Campaign Briefs Moderation', category: 'Jobs', url: '{{ route('admin.campaigns') }}', icon: 'briefcase' },
            { title: 'Central Tax Ledger & GST Invoices', category: 'Finance', url: '{{ route('admin.invoices') }}', icon: 'receipt' },
            { title: 'Dispute Arbitration', category: 'Escrow', url: '{{ route('admin.disputes') }}', icon: 'scale' },
        @endif
    ],
    get filteredItems() {
        if (!this.query.trim()) return this.items;
        const q = this.query.toLowerCase();
        return this.items.filter(i => i.title.toLowerCase().includes(q) || i.category.toLowerCase().includes(q));
    }
}" 
x-init="
    $watch('openPalette', value => {
        if (value) $nextTick(() => { if (window.lucide) lucide.createIcons(); });
    });
    $watch('query', () => {
        $nextTick(() => { if (window.lucide) lucide.createIcons(); });
    });
    window.addEventListener('keydown', (e) => {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            openPalette = !openPalette;
            if (openPalette) setTimeout(() => $refs.commandInput.focus(), 50);
        }
        if (e.key === 'Escape' && openPalette) {
            openPalette = false;
        }
    });
"
x-cloak
class="relative z-[999999]">

    <!-- Backdrop -->
    <div x-show="openPalette" 
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="openPalette = false" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

    <!-- Modal Box -->
    <div x-show="openPalette"
         x-transition:enter="transition ease-out duration-200 transform"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150 transform"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-x-4 top-20 max-w-xl mx-auto bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">
        
        <!-- Search Input Bar -->
        <div class="p-4 border-b border-slate-100 flex items-center space-x-3 bg-slate-50/50">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input x-ref="commandInput"
                   type="text"
                   x-model="query"
                   placeholder="Type a page, action, or command... (e.g. Invoices, Campaigns)" 
                   class="w-full bg-transparent text-sm font-medium text-slate-900 placeholder-slate-400 focus:outline-hidden">
            <span class="px-2 py-0.5 bg-slate-200/80 text-slate-500 text-[10px] font-mono font-bold rounded-md">ESC</span>
        </div>

        <!-- Filtered Items List -->
        <div class="max-h-80 overflow-y-auto p-2 divide-y divide-slate-50">
            <template x-for="item in filteredItems" :key="item.title">
                <a :href="item.url" 
                   @click="openPalette = false"
                   class="flex items-center justify-between p-3 rounded-xl hover:bg-indigo-50/70 group transition-colors">
                    <div class="flex items-center space-x-3">
                        <i :data-lucide="item.icon" class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors"></i>
                        <div>
                            <div class="text-sm font-bold text-slate-800 group-hover:text-indigo-600 transition-colors" x-text="item.title"></div>
                            <div class="text-[11px] text-slate-400 font-medium" x-text="item.category"></div>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-slate-300 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </template>
            <template x-if="filteredItems.length === 0">
                <div class="p-8 text-center text-xs text-slate-400">
                    No results found for "<span x-text="query"></span>".
                </div>
            </template>
        </div>

        <!-- Footer -->
        <div class="p-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400 px-4">
            <div class="flex items-center space-x-2">
                <span>Navigate</span>
                <kbd class="px-1.5 py-0.5 bg-white border border-slate-200 rounded font-mono text-[10px]">↑</kbd>
                <kbd class="px-1.5 py-0.5 bg-white border border-slate-200 rounded font-mono text-[10px]">↓</kbd>
            </div>
            <div>Press <kbd class="px-1.5 py-0.5 bg-white border border-slate-200 rounded font-mono text-[10px]">Ctrl+K</kbd> anywhere</div>
        </div>
    </div>
</div>
