@props(['socialAccounts', 'talent', 'isOwner' => false])

@php
    $accountsList = $socialAccounts instanceof \Illuminate\Support\Collection ? $socialAccounts : collect($socialAccounts);
    $primaryAccount = $accountsList->firstWhere('platform', 'instagram') ?? $accountsList->first();
    $allMedia = [];
    
    foreach ($accountsList as $acc) {
        if (!empty($acc->recent_media) && is_array($acc->recent_media)) {
            foreach ($acc->recent_media as $m) {
                $type = strtolower($m['media_product_type'] ?? $m['media_type'] ?? '');
                $mediaType = strtolower($m['media_type'] ?? '');
                $isReel = !empty($m['is_reel']) || $type === 'reels' || $mediaType === 'video' || str_contains($type, 'reel');
                
                // Exclude static images - only retain Reels / Videos
                if ($isReel) {
                    $m['is_reel'] = true;
                    $m['account_platform'] = $acc->platform;
                    $m['account_username'] = $acc->username;
                    $m['shares_count'] = (int) ($m['shares_count'] ?? $m['shares'] ?? 0);
                    $m['saved_count'] = (int) ($m['saved_count'] ?? $m['saved'] ?? $m['reposts_count'] ?? $m['reposts'] ?? 0);

                    // Automatic detection of joint/co-authored Collaboration posts
                    $caption = (string) ($m['caption'] ?? '');
                    $isCollab = !empty($m['is_collab'])
                        || (!empty($m['collaborators']) || !empty($m['coauthor_producers']))
                        || preg_match('/@[\w\.]+\s*(?:×|x|X|\+|\&|and)\s*@[\w\.]+/u', $caption)
                        || preg_match('/(?:collab(?:oration)?\s*(?:with|:|\/)|in\s+collab(?:oration)?|paid\s+partnership|sponsored\s+by|partnered\s+with|co-?authored)/i', $caption);

                    $m['is_collab'] = (bool) $isCollab;

                    // Extract partner handles if missing
                    if ($isCollab && empty($m['collab_partners'])) {
                        $partners = [];
                        $accountUname = strtolower(ltrim(trim($acc->username ?? ''), '@'));
                        if (preg_match_all('/@([\w\.]+)/', $caption, $matches)) {
                            foreach ($matches[1] as $handle) {
                                $h = strtolower(trim($handle, '.'));
                                if (!empty($h) && $h !== $accountUname && !in_array($h, $partners, true)) {
                                    $partners[] = $h;
                                }
                            }
                        }
                        $m['collab_partners'] = $partners;
                    }
                    if ($isCollab && empty($m['collab_role'])) {
                        $m['collab_role'] = !empty($m['collab_partners']) ? 'Joint Collab' : 'Collab';
                    }

                    // Direct Instagram Post URL normalization
                    $pUrl = $m['permalink'] ?? '';
                    if (!empty($pUrl) && str_contains($pUrl, 'instagram.com/reel/')) {
                        $m['direct_post_url'] = preg_replace('~^https?://(?:www\.)?instagram\.com/reel/([^/?#]+).*~i', 'https://www.instagram.com/p/$1/', $pUrl);
                        $m['reel_url'] = $pUrl;
                        $m['permalink'] = $m['direct_post_url'];
                    } else {
                        $m['direct_post_url'] = $pUrl;
                        $m['reel_url'] = !empty($pUrl) && str_contains($pUrl, 'instagram.com/p/') ? str_replace('instagram.com/p/', 'instagram.com/reel/', $pUrl) : $pUrl;
                    }

                    $allMedia[] = $m;
                }
            }
        }
    }
    
    // Sort all media by timestamp descending by default
    usort($allMedia, function($a, $b) {
        $ta = !empty($a['timestamp']) ? strtotime($a['timestamp']) : 0;
        $tb = !empty($b['timestamp']) ? strtotime($b['timestamp']) : 0;
        return $tb <=> $ta;
    });
@endphp

<div x-data="{
    timeframe: '30',
    customStart: '',
    customEnd: '',
    selectedPlatform: 'all',
    sortBy: 'views',
    visibleCount: 25,
    showAddCollabModal: false,
    collabUrlInput: '',
    isAddingCollab: false,
    collabErrorMsg: '',
    collabSuccessMsg: '',

    loadMore() {
        this.visibleCount += 10;
    },

    async submitAddCollab() {
        if (!this.collabUrlInput.trim()) return;
        this.isAddingCollab = true;
        this.collabErrorMsg = '';
        this.collabSuccessMsg = '';

        try {
            const res = await fetch('{{ route('influencer.social.add_collab_reel') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ url: this.collabUrlInput.trim() })
            });
            const data = await res.json();
            if (data.success && data.reel) {
                const existsIdx = this.allMedia.findIndex(m => m.id === data.reel.id || m.permalink === data.reel.permalink);
                if (existsIdx >= 0) {
                    this.allMedia[existsIdx] = data.reel;
                } else {
                    this.allMedia.unshift(data.reel);
                }
                this.collabUrlInput = '';
                this.collabSuccessMsg = data.message || 'Collaboration reel added successfully!';
                setTimeout(() => {
                    this.showAddCollabModal = false;
                    this.collabSuccessMsg = '';
                }, 1500);
            } else {
                this.collabErrorMsg = data.message || 'Could not fetch reel details. Please verify the URL.';
            }
        } catch (e) {
            this.collabErrorMsg = 'Network error while adding collaboration reel.';
        } finally {
            this.isAddingCollab = false;
        }
    },

    async removeCollabReel(id) {
        if (!confirm('Remove this collaboration reel from your synced grid?')) return;
        try {
            const res = await fetch('{{ route('influencer.social.remove_collab_reel') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ id: id })
            });
            const data = await res.json();
            if (data.success) {
                this.allMedia = this.allMedia.filter(m => m.id !== id && m.permalink !== id);
            }
        } catch (e) {}
    },

    get totalCollabsCount() {
        return this.allMedia.filter(m => m.is_collab).length;
    },

    get totalOriginalCount() {
        return this.allMedia.filter(m => !m.is_collab).length;
    },

    get paginatedMedia() {
        return this.filteredMedia.slice(0, this.visibleCount);
    },

    getDirectPostUrl(url) {
        if (!url) return '';
        if (url.includes('instagram.com/reel/')) {
            return url.replace(/instagram\.com\/reel\/([^\/?#]+)/, 'instagram.com/p/$1');
        }
        return url;
    },

    allMedia: {{ Js::from($allMedia) }},
    accounts: {{ Js::from($accountsList->map(fn($a) => [
        'id' => $a->id,
        'platform' => $a->platform,
        'username' => $a->username,
        'followers' => $a->followers,
        'views_30d' => $a->views_30d,
        'avg_views' => $a->avg_views,
        'avg_likes' => $a->avg_likes,
        'avg_comments' => $a->avg_comments,
        'engagement_rate' => (float) ($a->engagement_rate ?? 0),
        'is_verified' => $a->is_verified,
    ])) }},

    init() {
        // Default custom dates to last 30 days
        const today = new Date();
        const past30 = new Date();
        past30.setDate(today.getDate() - 30);
        this.customEnd = today.toISOString().split('T')[0];
        this.customStart = past30.toISOString().split('T')[0];

        // Check if creator has uploads within last 30 days
        const past30Ms = past30.getTime();
        const hasRecent30d = this.allMedia.some(m => {
            if (!m.timestamp) return false;
            return new Date(m.timestamp).getTime() >= past30Ms;
        });

        // If no uploads in last 30 days, default to 'all' so creator data is immediately visible
        if (!hasRecent30d && this.allMedia.length > 0) {
            this.timeframe = 'all';
        }
    },

    get totalFollowers() {
        if (this.selectedPlatform !== 'all') {
            const acc = this.accounts.find(a => a.platform === this.selectedPlatform);
            return acc ? acc.followers : 0;
        }
        return this.accounts.reduce((sum, a) => sum + (a.followers || 0), 0);
    },

    get filteredMedia() {
        const now = new Date().getTime();
        let minDate = 0;
        let maxDate = now + 86400000;

        if (this.timeframe === '7') {
            minDate = now - (7 * 86400000);
        } else if (this.timeframe === '30') {
            minDate = now - (30 * 86400000);
        } else if (this.timeframe === '90') {
            minDate = now - (90 * 86400000);
        } else if (this.timeframe === 'custom') {
            if (this.customStart) minDate = new Date(this.customStart).getTime();
            if (this.customEnd) maxDate = new Date(this.customEnd + 'T23:59:59').getTime();
        } else if (this.timeframe === 'all') {
            minDate = 0;
        }

        let list = this.allMedia.filter(item => {
            // Platform filter
            if (this.selectedPlatform !== 'all' && item.account_platform !== this.selectedPlatform) {
                return false;
            }

            // Date filter
            if (this.timeframe !== 'all') {
                if (!item.timestamp) return false;
                const itemTime = new Date(item.timestamp).getTime();
                if (itemTime < minDate || itemTime > maxDate) return false;
            }

            return true;
        });

        // Sorting
        list.sort((a, b) => {
            if (this.sortBy === 'views') {
                return (b.view_count || 0) - (a.view_count || 0);
            }
            if (this.sortBy === 'likes') {
                return (b.like_count || 0) - (a.like_count || 0);
            }
            if (this.sortBy === 'comments') {
                return (b.comments_count || 0) - (a.comments_count || 0);
            }
            if (this.sortBy === 'shares') {
                return (b.shares_count || 0) - (a.shares_count || 0);
            }
            if (this.sortBy === 'reposts') {
                return (b.saved_count || 0) - (a.saved_count || 0);
            }
            // Date descending
            const ta = a.timestamp ? new Date(a.timestamp).getTime() : 0;
            const tb = b.timestamp ? new Date(b.timestamp).getTime() : 0;
            return tb - ta;
        });

        return list;
    },

    get stats() {
        const items = this.filteredMedia;
        const totalFollowers = this.totalFollowers || 1;
        const count = items.length;

        let totalViews = 0;
        let totalLikes = 0;
        let totalComments = 0;
        let totalShares = 0;
        let totalReposts = 0;
        let reelCount = 0;

        items.forEach(item => {
            totalViews += parseInt(item.view_count || 0);
            totalLikes += parseInt(item.like_count || 0);
            totalComments += parseInt(item.comments_count || 0);
            totalShares += parseInt(item.shares_count || 0);
            totalReposts += parseInt(item.saved_count || 0);
            if (item.is_reel) reelCount++;
        });

        const totalInteractions = totalLikes + totalComments + totalShares + totalReposts;

        // If items exist in window
        if (count > 0) {
            const avgViews = totalViews > 0 ? Math.round(totalViews / count) : 0;
            const avgLikes = Math.round(totalLikes / count);
            const avgComments = Math.round(totalComments / count);
            const avgShares = Math.round(totalShares / count);
            const avgReposts = Math.round(totalReposts / count);
            const avgInteractionsPerPost = totalInteractions / count;
            const er = totalFollowers > 0 ? ((avgInteractionsPerPost / totalFollowers) * 100).toFixed(2) : '0.00';

            return {
                allViews: totalViews,
                allLikes: totalLikes,
                allComments: totalComments,
                allShares: totalShares,
                allReposts: totalReposts,
                allInteractions: totalInteractions,
                hasDirectViews: totalViews > 0,

                avgViews: avgViews,
                avgLikes: avgLikes,
                avgComments: avgComments,
                avgShares: avgShares,
                avgReposts: avgReposts,

                engagementRate: er,
                postsCount: count,
                reelCount: reelCount,
            };
        }

        // When 0 items exist in selected timeframe
        return {
            allViews: 0,
            allLikes: 0,
            allComments: 0,
            allShares: 0,
            allReposts: 0,
            allInteractions: 0,
            hasDirectViews: false,

            avgViews: 0,
            avgLikes: 0,
            avgComments: 0,
            avgShares: 0,
            avgReposts: 0,

            engagementRate: '0.00',
            postsCount: 0,
            reelCount: 0,
        };
    },

    formatNumber(num) {
        if (!num && num !== 0) return '0';
        const n = parseInt(num);
        if (n >= 1000000) return (n / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
        if (n >= 20000) return (n / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
        return n.toLocaleString();
    },

    formatDate(dateStr) {
        if (!dateStr) return 'Recent';
        try {
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        } catch(e) {
            return 'Recent';
        }
    }
}" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs space-y-8">

    <!-- Header & Timeframe Control Bar -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 border-b border-slate-100 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="px-2.5 py-0.5 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-[10px] font-black uppercase tracking-wider rounded-full shadow-xs inline-flex items-center gap-1">
                    <i data-lucide="zap" class="w-3 h-3"></i> Verified Reels & Videos Only
                </span>
                <span class="text-xs font-bold text-slate-500">Live API Video Sync</span>
            </div>
            <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight font-display">
                Verified Reels & Video Performance Analytics
            </h3>
            <p class="text-slate-500 text-xs mt-0.5">
                Real-time performance totals (ALL) and per-reel averages (AVG) across 7-day, 30-day, 90-day, all-time, or custom date windows.
            </p>
        </div>

        <!-- Controls: Timeframe Pills & Custom Range -->
        <div class="flex flex-wrap items-center gap-2">
            <!-- Platform filter (if multi-channel) -->
            <template x-if="accounts.length > 1">
                <select x-model="selectedPlatform" class="bg-slate-50 hover:bg-slate-100 text-slate-800 text-xs font-bold px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0866FF] cursor-pointer">
                    <option value="all">All Channels (Combined)</option>
                    <template x-for="acc in accounts" :key="acc.id">
                        <option :value="acc.platform" x-text="acc.platform.toUpperCase() + ' (@' + acc.username + ')'"></option>
                    </template>
                </select>
            </template>

            <!-- Timeframe Segmented Switcher -->
            <div class="bg-slate-100 p-1 rounded-2xl flex items-center border border-slate-200 shadow-2xs">
                <button type="button" @click="timeframe = '7'" :class="timeframe === '7' ? 'bg-white text-slate-900 shadow-xs font-black' : 'text-slate-600 hover:text-slate-900 font-semibold'" class="px-3 py-1.5 text-xs rounded-xl transition">
                    7 Days
                </button>
                <button type="button" @click="timeframe = '30'" :class="timeframe === '30' ? 'bg-white text-slate-900 shadow-xs font-black' : 'text-slate-600 hover:text-slate-900 font-semibold'" class="px-3 py-1.5 text-xs rounded-xl transition">
                    30 Days
                </button>
                <button type="button" @click="timeframe = '90'" :class="timeframe === '90' ? 'bg-white text-slate-900 shadow-xs font-black' : 'text-slate-600 hover:text-slate-900 font-semibold'" class="px-3 py-1.5 text-xs rounded-xl transition">
                    90 Days
                </button>
                <button type="button" @click="timeframe = 'all'" :class="timeframe === 'all' ? 'bg-white text-slate-900 shadow-xs font-black' : 'text-slate-600 hover:text-slate-900 font-semibold'" class="px-3 py-1.5 text-xs rounded-xl transition">
                    All-Time
                </button>
                <button type="button" @click="timeframe = 'custom'" :class="timeframe === 'custom' ? 'bg-white text-slate-900 shadow-xs font-black' : 'text-slate-600 hover:text-slate-900 font-semibold'" class="px-3 py-1.5 text-xs rounded-xl transition flex items-center gap-1.5">
                    <i data-lucide="calendar" class="w-3.5 h-3.5 inline-block"></i> <span>Custom</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Custom Date Range Bar (conditional) -->
    <div x-show="timeframe === 'custom'" x-transition class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 p-4 rounded-2xl flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <i data-lucide="calendar-range" class="w-5 h-5 text-indigo-600 shrink-0"></i>
            <div>
                <h4 class="text-xs font-black text-slate-900">Custom Date Range Analytics</h4>
                <p class="text-[11px] text-slate-600">Pick custom start and end dates to compute verified Reel metrics in that exact period.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 text-xs">
            <div class="flex items-center gap-1.5">
                <span class="font-bold text-slate-600">From:</span>
                <input type="date" x-model="customStart" class="bg-white border border-slate-300 rounded-xl px-3 py-1.5 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#0866FF]">
            </div>
            <div class="flex items-center gap-1.5">
                <span class="font-bold text-slate-600">To:</span>
                <input type="date" x-model="customEnd" class="bg-white border border-slate-300 rounded-xl px-3 py-1.5 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#0866FF]">
            </div>
        </div>
    </div>

    <!-- Overview Highlights Banner -->
    <div class="bg-gradient-to-br from-slate-900 via-slate-900 to-indigo-950 text-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1.5">
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 rounded-full text-[10px] font-black uppercase tracking-wider" x-text="timeframe === 'all' ? 'All-Time Synced Window' : (timeframe === 'custom' ? customStart + ' to ' + customEnd : 'Last ' + timeframe + ' Days Window')"></span>
                <span class="text-xs text-slate-400 font-semibold" x-text="stats.postsCount + ' verified reel(s) published'"></span>
            </div>
            <h4 class="text-2xl sm:text-3xl font-black font-display tracking-tight text-white flex items-center gap-2">
                <span x-text="formatNumber(stats.allViews)"></span>
                <span class="text-xs font-bold text-slate-400 font-sans uppercase tracking-wider" x-text="stats.hasDirectViews ? 'Verified Views' : 'Total Views'"></span>
            </h4>
            <p class="text-xs text-slate-400">
                Total aggregate interactions across window: <strong class="text-white" x-text="formatNumber(stats.allInteractions)"></strong> (Likes, comments, shares & reposts).
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <div class="bg-white/10 backdrop-blur-md px-4 py-3 rounded-xl border border-white/10 text-center min-w-[110px]">
                <span class="text-[10px] uppercase font-bold text-emerald-400 block">Reel ER %</span>
                <span class="text-2xl font-black text-white font-display tabular-nums" x-text="stats.engagementRate + '%'"></span>
            </div>
            <div class="bg-white/10 backdrop-blur-md px-4 py-3 rounded-xl border border-white/10 text-center min-w-[110px]">
                <span class="text-[10px] uppercase font-bold text-pink-400 block">Reels in Window</span>
                <span class="text-2xl font-black text-white font-display tabular-nums" x-text="stats.postsCount"></span>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SECTION 1: ALL (Totals for the Period)      -->
    <!-- ========================================== -->
    <div class="space-y-3">
        <div class="flex items-center justify-between border-b border-slate-100 pb-2">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#0866FF]"></span>
                <h4 class="text-xs font-black uppercase tracking-wider text-slate-900">
                    Period Totals <span class="text-slate-400 font-semibold">(ALL: Views, Likes, Comments, Shares, Reposts)</span>
                </h4>
            </div>
            <span class="text-[11px] font-bold text-slate-500" x-text="'Window: ' + (timeframe === 'all' ? 'All-Time' : (timeframe === 'custom' ? 'Custom' : timeframe + ' Days'))"></span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
            <!-- 1. ALL Views -->
            <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl flex flex-col justify-between space-y-1.5 shadow-2xs hover:border-slate-300 transition">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold text-slate-500">Total Views</span>
                    <i data-lucide="eye" class="w-4 h-4 text-slate-500"></i>
                </div>
                <div>
                    <span class="text-xl sm:text-2xl font-black text-slate-900 font-display tabular-nums block" x-text="formatNumber(stats.allViews)"></span>
                    <span class="text-[10px] text-slate-500 font-semibold block mt-0.5" x-text="stats.hasDirectViews ? 'Direct API views' : (stats.allViews > 0 ? 'Verified views' : '0 views')"></span>
                </div>
            </div>

            <!-- 2. ALL Likes -->
            <div class="bg-pink-50/70 border border-pink-100 p-4 rounded-2xl flex flex-col justify-between space-y-1.5 shadow-2xs hover:border-pink-200 transition">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold text-pink-700">Total Likes</span>
                    <i data-lucide="heart" class="w-4 h-4 text-pink-600"></i>
                </div>
                <div>
                    <span class="text-xl sm:text-2xl font-black text-pink-900 font-display tabular-nums block" x-text="formatNumber(stats.allLikes)"></span>
                    <span class="text-[10px] text-pink-700/80 font-semibold block mt-0.5">Sum of reel likes</span>
                </div>
            </div>

            <!-- 3. ALL Comments -->
            <div class="bg-blue-50/70 border border-blue-100 p-4 rounded-2xl flex flex-col justify-between space-y-1.5 shadow-2xs hover:border-blue-200 transition">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold text-blue-700">Total Comments</span>
                    <i data-lucide="message-square" class="w-4 h-4 text-blue-600"></i>
                </div>
                <div>
                    <span class="text-xl sm:text-2xl font-black text-blue-900 font-display tabular-nums block" x-text="formatNumber(stats.allComments)"></span>
                    <span class="text-[10px] text-blue-700/80 font-semibold block mt-0.5">Sum of comments</span>
                </div>
            </div>

            <!-- 4. ALL Shares -->
            <div class="bg-purple-50/70 border border-purple-100 p-4 rounded-2xl flex flex-col justify-between space-y-1.5 shadow-2xs hover:border-purple-200 transition">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold text-purple-700">Total Shares</span>
                    <i data-lucide="share-2" class="w-4 h-4 text-purple-600"></i>
                </div>
                <div>
                    <span class="text-xl sm:text-2xl font-black text-purple-900 font-display tabular-nums block" x-text="formatNumber(stats.allShares)"></span>
                    <span class="text-[10px] text-purple-700/80 font-semibold block mt-0.5">Direct forwards</span>
                </div>
            </div>

            <!-- 5. ALL Reposts / Saves -->
            <div class="bg-amber-50/70 border border-amber-100 p-4 rounded-2xl flex flex-col justify-between space-y-1.5 shadow-2xs hover:border-amber-200 transition">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold text-amber-800">Total Reposts / Saves</span>
                    <i data-lucide="bookmark" class="w-4 h-4 text-amber-600"></i>
                </div>
                <div>
                    <span class="text-xl sm:text-2xl font-black text-amber-950 font-display tabular-nums block" x-text="formatNumber(stats.allReposts)"></span>
                    <span class="text-[10px] text-amber-800/80 font-semibold block mt-0.5">Bookmarks & reposts</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SECTION 2: AVG (Averages per Deliverable)   -->
    <!-- ========================================== -->
    <div class="space-y-3">
        <div class="flex items-center justify-between border-b border-slate-100 pb-2">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                <h4 class="text-xs font-black uppercase tracking-wider text-slate-900">
                    Per-Deliverable Averages <span class="text-slate-400 font-semibold">(AVG: Views, Likes, Comments, Shares, Reposts)</span>
                </h4>
            </div>
            <span class="text-[11px] font-bold text-slate-500">Calculated Per Reel</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
            <!-- 1. AVG Views -->
            <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl flex flex-col justify-between space-y-1.5 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold text-slate-500">Avg Views / Reel</span>
                    <i data-lucide="film" class="w-4 h-4 text-slate-500"></i>
                </div>
                <div>
                    <span class="text-xl sm:text-2xl font-black text-slate-900 font-display tabular-nums block" x-text="formatNumber(stats.avgViews)"></span>
                    <span class="text-[10px] text-slate-500 font-semibold block mt-0.5">Average reach/view</span>
                </div>
            </div>

            <!-- 2. AVG Likes -->
            <div class="bg-pink-50/50 border border-pink-100 p-4 rounded-2xl flex flex-col justify-between space-y-1.5 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold text-pink-700">Avg Likes / Reel</span>
                    <i data-lucide="heart" class="w-4 h-4 text-pink-600"></i>
                </div>
                <div>
                    <span class="text-xl sm:text-2xl font-black text-pink-900 font-display tabular-nums block" x-text="formatNumber(stats.avgLikes)"></span>
                    <span class="text-[10px] text-pink-700/80 font-semibold block mt-0.5">Likes per deliverable</span>
                </div>
            </div>

            <!-- 3. AVG Comments -->
            <div class="bg-blue-50/50 border border-blue-100 p-4 rounded-2xl flex flex-col justify-between space-y-1.5 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold text-blue-700">Avg Comments / Reel</span>
                    <i data-lucide="message-square" class="w-4 h-4 text-blue-600"></i>
                </div>
                <div>
                    <span class="text-xl sm:text-2xl font-black text-blue-900 font-display tabular-nums block" x-text="formatNumber(stats.avgComments)"></span>
                    <span class="text-[10px] text-blue-700/80 font-semibold block mt-0.5">Comments per deliverable</span>
                </div>
            </div>

            <!-- 4. AVG Shares -->
            <div class="bg-purple-50/50 border border-purple-100 p-4 rounded-2xl flex flex-col justify-between space-y-1.5 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold text-purple-700">Avg Shares / Reel</span>
                    <i data-lucide="share-2" class="w-4 h-4 text-purple-600"></i>
                </div>
                <div>
                    <span class="text-xl sm:text-2xl font-black text-purple-900 font-display tabular-nums block" x-text="formatNumber(stats.avgShares)"></span>
                    <span class="text-[10px] text-purple-700/80 font-semibold block mt-0.5">Shares per deliverable</span>
                </div>
            </div>

            <!-- 5. AVG Reposts / Saves -->
            <div class="bg-amber-50/50 border border-amber-100 p-4 rounded-2xl flex flex-col justify-between space-y-1.5 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold text-amber-800">Avg Reposts / Reel</span>
                    <i data-lucide="bookmark" class="w-4 h-4 text-amber-600"></i>
                </div>
                <div>
                    <span class="text-xl sm:text-2xl font-black text-amber-950 font-display tabular-nums block" x-text="formatNumber(stats.avgReposts)"></span>
                    <span class="text-[10px] text-amber-800/80 font-semibold block mt-0.5">Saves per deliverable</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Verified Reels Gallery Filtered by Timeframe -->
    <div class="space-y-4 pt-2">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
            <div class="flex flex-wrap items-center gap-2.5">
                <h4 class="text-base font-black text-slate-900 font-display">
                    Synced Live Reels
                </h4>
                <span class="px-2 py-0.5 bg-pink-50 text-pink-700 border border-pink-200 text-xs font-black rounded-full" x-text="filteredMedia.length + ' reel(s)'"></span>

                @if($isOwner || auth()->check())
                    <button type="button" @click="showAddCollabModal = !showAddCollabModal; collabErrorMsg = ''; collabSuccessMsg = '';" class="px-2.5 py-1 bg-purple-50 hover:bg-purple-100 text-purple-700 border border-purple-200 text-xs font-bold rounded-xl transition flex items-center gap-1.5 cursor-pointer shadow-2xs">
                        <i class="fa-solid fa-plus text-[10px] text-purple-600"></i>
                        <span>Add Collab Reel</span>
                    </button>
                @endif
            </div>

            <!-- Sorting Dropdown -->
            <div class="flex items-center gap-2">
                <select x-model="sortBy" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0866FF] cursor-pointer">
                    <option value="views">Sort by Most Views</option>
                    <option value="likes">Sort by Most Likes</option>
                    <option value="comments">Sort by Most Comments</option>
                    <option value="shares">Sort by Most Shares</option>
                    <option value="reposts">Sort by Most Reposts / Saves</option>
                    <option value="date">Sort by Latest Date</option>
                </select>
            </div>
        </div>

        <!-- Add Collab Reel Modal / Inline Dropdown -->
        <div x-show="showAddCollabModal" x-transition class="bg-gradient-to-r from-purple-50 via-indigo-50 to-pink-50 border border-purple-200 p-4 rounded-2xl space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-purple-600 text-white flex items-center justify-center shadow-xs">
                        <i class="fa-solid fa-handshake text-xs"></i>
                    </div>
                    <div>
                        <h5 class="text-xs font-black text-slate-900">Add Collaboration Reel</h5>
                        <p class="text-[11px] text-slate-600">Paste any Instagram Reel URL where you are an accepted collaborator or co-creator.</p>
                    </div>
                </div>
                <button type="button" @click="showAddCollabModal = false" class="text-slate-400 hover:text-slate-600 text-xs p-1 cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form @submit.prevent="submitAddCollab()" class="flex flex-col sm:flex-row items-center gap-2">
                <div class="relative w-full">
                    <i class="fa-brands fa-instagram absolute left-3 top-1/2 -translate-y-1/2 text-pink-500 text-sm"></i>
                    <input type="url" x-model="collabUrlInput" placeholder="https://www.instagram.com/reel/C8xK9yZ001/ or https://www.instagram.com/p/..." required class="w-full bg-white border border-slate-300 rounded-xl pl-9 pr-3 py-2 text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-purple-600 shadow-2xs">
                </div>
                <button type="submit" :disabled="isAddingCollab" class="w-full sm:w-auto shrink-0 px-4 py-2 bg-purple-600 hover:bg-purple-700 disabled:opacity-50 text-white font-black text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                    <i x-show="!isAddingCollab" class="fa-solid fa-bolt text-[10px]"></i>
                    <i x-show="isAddingCollab" class="fa-solid fa-spinner fa-spin text-[10px]"></i>
                    <span x-text="isAddingCollab ? 'Fetching Reel...' : 'Add Collab Reel'"></span>
                </button>
            </form>

            <template x-if="collabErrorMsg">
                <p class="text-[11px] font-bold text-red-600 flex items-center gap-1">
                    <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                    <span x-text="collabErrorMsg"></span>
                </p>
            </template>
            <template x-if="collabSuccessMsg">
                <p class="text-[11px] font-bold text-emerald-600 flex items-center gap-1">
                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                    <span x-text="collabSuccessMsg"></span>
                </p>
            </template>
        </div>

        <!-- Media Grid -->
        <template x-if="filteredMedia.length > 0">
            <div class="space-y-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3.5 sm:gap-4">
                    <template x-for="item in paginatedMedia" :key="item.id">
                        <div class="group relative aspect-[9/14] bg-slate-900 rounded-2xl overflow-hidden border border-slate-200 shadow-2xs hover:shadow-md transition duration-300 flex flex-col justify-between">
                            <!-- Media Thumbnail Image (Direct Clickable Link) -->
                            <a :href="getDirectPostUrl(item.permalink)" target="_blank" rel="noopener noreferrer" class="absolute inset-0 block cursor-pointer z-0" :title="item.account_platform === 'youtube' ? 'Watch on YouTube' : 'Watch on Instagram'">
                                <img :src="item.thumbnail_url || 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=400&h=600&fit=crop'" :alt="item.caption || 'Live Video'" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/25 to-slate-950/50"></div>
                            </a>

                            <!-- Top Tag & Views Pill -->
                            <div class="relative z-10 p-2.5 flex items-center justify-between gap-1 pointer-events-none">
                                <span class="px-1.5 py-0.5 bg-black/60 backdrop-blur-md rounded-md text-[9px] font-extrabold text-white flex items-center gap-0.5">
                                    <span x-text="item.is_reel ? 'Reel' : 'Video'"></span>
                                </span>
                                
                                <template x-if="item.view_count > 0">
                                    <span class="px-2 py-0.5 bg-pink-600/90 backdrop-blur-md rounded-md text-[10px] font-black text-white flex items-center gap-1 shadow-xs">
                                        <i class="fa-solid fa-play text-[8px] text-white"></i>
                                        <span x-text="formatNumber(item.view_count)"></span>
                                    </span>
                                </template>
                            </div>

                            <!-- Center Play Hover Icon (Clickable) -->
                            <a :href="getDirectPostUrl(item.permalink)" target="_blank" rel="noopener noreferrer" class="relative z-10 my-auto flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-auto" :title="item.account_platform === 'youtube' ? 'Watch on YouTube' : 'Watch on Instagram'">
                                <div class="w-11 h-11 rounded-full text-white flex items-center justify-center shadow-xl transform group-hover:scale-110 transition" :class="item.account_platform === 'youtube' ? 'bg-red-600' : 'bg-pink-600'">
                                    <i class="fa-solid fa-play text-base ml-0.5"></i>
                                </div>
                            </a>

                            <!-- Bottom Meta: Likes, Comments, Shares, Date & Direct Action Button -->
                            <div class="relative z-10 p-2.5 space-y-1.5 pointer-events-auto">
                                <div class="flex items-center justify-between text-[10px] text-slate-200 font-bold">
                                    <span class="flex items-center gap-1" x-show="item.like_count > 0">
                                        <i class="fa-solid fa-heart text-pink-400 text-[10px]"></i>
                                        <span x-text="formatNumber(item.like_count)"></span>
                                    </span>
                                    <span class="flex items-center gap-1" x-show="item.comments_count > 0">
                                        <i class="fa-solid fa-message text-blue-400 text-[10px]"></i>
                                        <span x-text="formatNumber(item.comments_count)"></span>
                                    </span>
                                    <span class="text-[9px] text-slate-400" x-text="formatDate(item.timestamp)"></span>
                                </div>

                                <template x-if="item.shares_count > 0 || item.saved_count > 0">
                                    <div class="flex items-center gap-2 text-[9px] text-slate-300 font-semibold">
                                        <span x-show="item.shares_count > 0"><span x-text="formatNumber(item.shares_count)"></span> shares</span>
                                        <span x-show="item.saved_count > 0"><span x-text="formatNumber(item.saved_count)"></span> saves</span>
                                    </div>
                                </template>

                                <template x-if="item.caption">
                                    <p class="text-[10px] text-slate-300 line-clamp-1 leading-tight font-medium" x-text="item.caption"></p>
                                </template>

                                <div class="pt-0.5">
                                    <a :href="getDirectPostUrl(item.permalink)" target="_blank" rel="noopener noreferrer" class="w-full py-2 px-2 bg-white/20 hover:bg-white text-white hover:text-slate-900 backdrop-blur-md text-[10px] font-black rounded-xl transition text-center flex items-center justify-center gap-1.5 shadow-xs group/btn">
                                        <i :class="item.account_platform === 'youtube' ? 'fa-brands fa-youtube text-red-500 group-hover/btn:text-red-600 text-xs' : 'fa-brands fa-instagram text-pink-400 group-hover/btn:text-pink-600 text-xs'"></i>
                                        <span x-text="item.account_platform === 'youtube' ? 'Watch on YouTube' : 'Watch on Instagram'"></span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[8px] opacity-75"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Pagination: View Next 10 Reels -->
                <template x-if="filteredMedia.length > visibleCount">
                    <div class="flex flex-col items-center justify-center pt-4 space-y-2 border-t border-slate-100">
                        <button type="button" 
                                @click="loadMore()" 
                                class="px-6 py-2.5 bg-slate-900 hover:bg-black text-white font-black text-xs rounded-xl shadow-xs hover:shadow-md transition flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-plus text-[10px] text-pink-400"></i>
                            <span>View Next 10 Reels</span>
                            <span class="px-2 py-0.5 bg-white/20 text-white text-[10px] font-bold rounded-full" x-text="(filteredMedia.length - visibleCount) + ' more'"></span>
                        </button>
                        <span class="text-[11px] text-slate-400 font-semibold" x-text="'Showing ' + paginatedMedia.length + ' of ' + filteredMedia.length + ' synced reels'"></span>
                    </div>
                </template>
            </div>
        </template>

        <!-- Empty State for Narrow Filter Windows -->
        <template x-if="filteredMedia.length === 0">
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-8 text-center space-y-3">
                <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                    <i data-lucide="calendar-x" class="w-6 h-6"></i>
                </div>
                <h4 class="text-sm font-extrabold text-slate-900">No uploads found in this specific timeframe (<span x-text="timeframe === 'custom' ? customStart + ' to ' + customEnd : 'Last ' + timeframe + ' Days'"></span>)</h4>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    The creator has not published content during this exact date window. You can switch to a broader timeframe to view all synced reels and historical metrics.
                </p>
                <div class="flex items-center justify-center gap-2 pt-2">
                    <button type="button" @click="timeframe = '30'" class="px-4 py-2 bg-white text-slate-800 text-xs font-bold rounded-xl border border-slate-200 hover:bg-slate-100 transition shadow-2xs">
                        View Last 30 Days
                    </button>
                    <button type="button" @click="timeframe = 'all'" class="px-4 py-2 bg-[#0866FF] text-white text-xs font-bold rounded-xl hover:bg-[#0052CC] transition shadow-xs">
                        View All-Time Verified Media
                    </button>
                </div>
            </div>
        </template>
    </div>

    <!-- SEO & Accessibility Index -->
    <div class="sr-only">
        <h4>Verified Reels & Video Performance</h4>
        @foreach($allMedia as $item)
            @if(!empty($item['permalink']))
                <a href="{{ $item['permalink'] }}">Watch on {{ ucfirst($item['account_platform'] ?? 'Instagram') }} - {{ $item['caption'] ?? '' }}</a>
            @endif
        @endforeach
    </div>

</div>
