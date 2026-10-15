<!-- Global Toast System Script Setup -->
<script>
window.__pendingToasts = window.__pendingToasts || [];
window.__toastedIdsInView = window.__toastedIdsInView || new Set();
window.__activeConversationId = null;
window.__isNotificationDropdownOpen = false;

window.hasBeenToasted = function(id) {
    if (!id) return false;
    const strId = String(id);
    if (window.__toastedIdsInView && window.__toastedIdsInView.has(strId)) return true;
    try {
        const stored = localStorage.getItem('__toasted_notification_ids');
        if (stored) {
            const arr = JSON.parse(stored);
            if (Array.isArray(arr) && arr.includes(strId)) {
                window.__toastedIdsInView.add(strId);
                return true;
            }
        }
    } catch (e) {}
    return false;
};

window.recordToastedId = function(id) {
    if (!id) return;
    const strId = String(id);
    window.__toastedIdsInView.add(strId);
    try {
        let arr = [];
        const stored = localStorage.getItem('__toasted_notification_ids');
        if (stored) {
            arr = JSON.parse(stored);
            if (!Array.isArray(arr)) arr = [];
        }
        if (!arr.includes(strId)) {
            arr.push(strId);
            if (arr.length > 200) arr = arr.slice(-200);
            localStorage.setItem('__toasted_notification_ids', JSON.stringify(arr));
        }
    } catch (e) {}
};

window.setActiveConversation = function(conversationId) {
    window.__activeConversationId = conversationId ? String(conversationId) : null;
};

window.setNotificationDropdownOpen = function(isOpen) {
    window.__isNotificationDropdownOpen = !!isOpen;
    if (isOpen && window.__toastManagerInstance) {
        window.__toastManagerInstance.clearAll();
    }
};

window.isCurrentlyViewing = function(detail) {
    if (!detail) return false;

    // 1. If notification is already marked as read
    if (detail.is_read || detail.read_at) return true;

    // 2. If notification has already been toasted once across page refreshes / sessions
    if (detail.id && window.hasBeenToasted(detail.id)) return true;

    // 3. Notifications page suppression: completely suppress all toasts if user is on any notifications screen
    const currentPath = (window.location.pathname || '').toLowerCase();
    if (currentPath.includes('/notifications')) {
        return true;
    }

    // 4. Bell dropdown suppression: suppress all toasts if user opened the notification bell dropdown
    if (window.__isNotificationDropdownOpen) {
        return true;
    }

    // 5. Active Chat suppression: if user has this chat/conversation open
    const currentConvId = window.__activeConversationId;
    if (currentConvId) {
        if (detail.conversation_id && String(detail.conversation_id) === currentConvId) {
            return true;
        }
        if (detail.action_url && (
            detail.action_url.includes('/chat/' + currentConvId) ||
            detail.action_url.endsWith('/chat/' + currentConvId)
        )) {
            return true;
        }
    }

    // 6. Current page suppression: if user is already viewing the target action_url
    if (detail.action_url) {
        try {
            const urlObj = new URL(detail.action_url, window.location.origin);
            if (window.location.pathname === urlObj.pathname && (urlObj.search === '' || window.location.search === urlObj.search)) {
                return true;
            }
        } catch (e) {}
    }

    return false;
};

window.showToast = function(detail) {
    if (!detail) return;
    if (detail.id && window.hasBeenToasted(detail.id)) return;
    if (window.isCurrentlyViewing(detail)) return;

    if (detail.id) {
        window.recordToastedId(detail.id);
    }

    if (window.__toastManagerInstance) {
        window.__toastManagerInstance.addToast(detail);
    } else {
        window.__pendingToasts.push(detail);
    }
};

window.addEventListener('show-toast', function(e) {
    if (e.detail) {
        window.showToast(e.detail);
    }
});
</script>

<!-- Live Toast Notification Container -->
<div x-data="toastManager()" 
     class="fixed top-5 right-5 z-[999999] flex flex-col space-y-3 max-w-sm w-full pointer-events-none px-4 sm:px-0">
    <template x-for="toast in toasts" :key="toast.id">
        <div class="pointer-events-auto bg-white border border-slate-200 rounded-2xl shadow-2xl p-4 transition-all duration-300 transform flex items-start space-x-3.5 ring-1 ring-black/5 overflow-hidden relative group hover:border-slate-400 hover:shadow-indigo-500/20 cursor-pointer"
             @mouseenter="pauseTimer(toast)"
             @mouseleave="resumeTimer(toast)"
             @click="handleToastClick(toast, $event)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-3 sm:translate-y-0 sm:translate-x-6 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <!-- Toast Accent Left Bar -->
            <div class="absolute left-0 top-0 bottom-0 w-1.5"
                 :class="{
                     'bg-indigo-600': toast.type === 'message',
                     'bg-emerald-500': toast.type === 'proposal' || toast.type === 'success' || toast.type === 'booking',
                     'bg-pink-500': toast.type === 'application',
                     'bg-rose-500': toast.type === 'error',
                     'bg-amber-500': toast.type === 'warning' || toast.type === 'info'
                 }">
            </div>

            <!-- Icon -->
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm mt-0.5"
                 :class="{
                     'bg-indigo-50 text-indigo-600 border border-indigo-100': toast.type === 'message',
                     'bg-emerald-50 text-emerald-600 border border-emerald-100': toast.type === 'proposal' || toast.type === 'success' || toast.type === 'booking',
                     'bg-pink-50 text-pink-600 border border-pink-100': toast.type === 'application',
                     'bg-rose-50 text-rose-600 border border-rose-100': toast.type === 'error',
                     'bg-amber-50 text-amber-600 border border-amber-100': toast.type === 'warning' || toast.type === 'info'
                 }">
                <!-- Message Icon -->
                <template x-if="toast.type === 'message'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </template>
                <!-- Proposal / Offer Icon -->
                <template x-if="toast.type === 'proposal'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </template>
                <!-- Booking Confirmed Icon -->
                <template x-if="toast.type === 'booking' || toast.type === 'success'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </template>
                <!-- Application Icon -->
                <template x-if="toast.type === 'application'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </template>
                <!-- Error Icon -->
                <template x-if="toast.type === 'error'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </template>
                <!-- Warning / Info Icon -->
                <template x-if="toast.type === 'warning' || toast.type === 'info'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </template>
            </div>

            <!-- Content -->
            <div class="min-w-0 flex-grow pr-2">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-slate-900 truncate" x-text="toast.title"></h4>
                </div>
                <p class="text-xs text-slate-600 mt-0.5 leading-snug line-clamp-2" x-text="toast.body"></p>

                <!-- Action Link / Button -->
                <template x-if="toast.action_url">
                    <div class="mt-2 flex items-center space-x-2">
                        <span class="inline-flex items-center space-x-1 px-3 py-1 bg-slate-900 group-hover:bg-indigo-600 text-white text-[11px] font-bold rounded-lg transition shadow-sm">
                            <span x-text="toast.action_text || 'View Details'"></span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </span>
                    </div>
                </template>
            </div>

            <!-- Close Button -->
            <button type="button" @click.stop="removeToast(toast.id)" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg transition" title="Dismiss">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </template>
</div>

<script>
function toastManager() {
    return {
        toasts: [],
        init() {
            window.__toastManagerInstance = this;

            // Drain any pending toasts
            if (window.__pendingToasts && window.__pendingToasts.length > 0) {
                while (window.__pendingToasts.length > 0) {
                    const item = window.__pendingToasts.shift();
                    this.addToast(item);
                }
            }

            @if(session('success'))
                this.addToast({
                    title: 'Success',
                    body: "{{ session('success') }}",
                    type: 'success'
                });
            @endif

            @if(session('error'))
                this.addToast({
                    title: 'Alert',
                    body: "{{ session('error') }}",
                    type: 'error'
                });
            @endif

            @if(session('info'))
                this.addToast({
                    title: 'Information',
                    body: "{{ session('info') }}",
                    type: 'info'
                });
            @endif
        },
        addToast(detail) {
            if (!detail || (!detail.title && !detail.body)) return;
            if (window.isCurrentlyViewing(detail)) return;
            
            // Avoid duplicate of identical active toast
            if (detail.id && (this.toasts.some(t => t.notifId === detail.id) || window.hasBeenToasted(detail.id))) {
                return;
            }

            if (detail.id) {
                window.recordToastedId(detail.id);
            }

            const id = Date.now() + Math.random();
            const actionText = detail.action_text || (
                detail.type === 'message' ? 'Open Chat' : 
                (detail.type === 'proposal' ? 'Review Commercial Offer' : 
                (detail.type === 'booking' ? 'View Booking' : 
                (detail.type === 'application' ? 'Review Application' : 'View Details')))
            );

            const toast = {
                id: id,
                notifId: detail.id || null,
                title: detail.title || 'Notification',
                body: detail.body || '',
                action_url: detail.action_url || null,
                action_text: actionText,
                type: detail.type || 'info',
                timer: null,
                remainingTime: 8000,
                startTime: Date.now(),
            };

            // Limit to max 4 visible toasts at a time
            if (this.toasts.length >= 4) {
                this.toasts.shift();
            }

            this.toasts.push(toast);
            this.startTimer(toast);
        },
        startTimer(toast) {
            toast.startTime = Date.now();
            toast.timer = setTimeout(() => {
                this.removeToast(toast.id);
            }, toast.remainingTime);
        },
        pauseTimer(toast) {
            if (toast.timer) {
                clearTimeout(toast.timer);
                toast.timer = null;
                toast.remainingTime -= (Date.now() - toast.startTime);
                if (toast.remainingTime < 1000) toast.remainingTime = 1000;
            }
        },
        resumeTimer(toast) {
            this.startTimer(toast);
        },
        handleToastClick(toast, event) {
            if (toast.action_url) {
                window.location.href = toast.action_url;
            }
        },
        removeToast(id) {
            const toast = this.toasts.find(t => t.id === id);
            if (toast && toast.timer) clearTimeout(toast.timer);
            this.toasts = this.toasts.filter(t => t.id !== id);
        },
        clearAll() {
            this.toasts.forEach(t => {
                if (t.timer) clearTimeout(t.timer);
            });
            this.toasts = [];
        }
    };
}
</script>
