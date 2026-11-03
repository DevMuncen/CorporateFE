import 'preline';
import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import './modal-picker';
import './alert';

// Global Toast Notification Helper
window.showToast = function(message, type = 'success') {
    if (window.Alert && typeof window.Alert.toast === 'function') {
        return window.Alert.toast(message, type);
    }
    const toast = document.createElement('div');
    const bgClass = type === 'success' ? 'bg-emerald-600' : (type === 'error' ? 'bg-rose-600' : 'bg-blue-600');
    toast.className = `fixed bottom-5 right-5 z-[100] flex items-center px-4 py-3 rounded-lg shadow-xl text-white text-sm font-medium transition-opacity duration-300 ${bgClass}`;
    toast.innerHTML = `
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'}"></path>
        </svg>
        <span>${message}</span>
    `;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
};

// Global formatCurrency Helper (IDR)
window.formatCurrency = function(amount) {
    return 'Rp ' + Number(amount || 0).toLocaleString('id-ID');
};

// Universal Sidebar Toggle Helper
window.toggleAnySidebar = function(e) {
    if (e && e.preventDefault) e.preventDefault();
    const sidebar = document.getElementById('application-sidebar-brand');
    const pageWrapper = document.querySelector('.page-wrapper');
    if (!sidebar) return;

    // Clean up any stray backdrops or body locks
    document.querySelectorAll('.hs-overlay-backdrop').forEach(el => el.remove());
    document.body.classList.remove('overflow-hidden');
    document.body.style.overflow = '';

    const isDesktop = window.innerWidth >= 1280;
    if (isDesktop) {
        const isCollapsed = sidebar.classList.contains('desktop-sidebar-collapsed');
        if (isCollapsed) {
            sidebar.classList.remove('desktop-sidebar-collapsed');
            sidebar.style.transform = '';
            if (pageWrapper) {
                pageWrapper.style.marginLeft = '';
                pageWrapper.style.width = '';
            }
        } else {
            sidebar.classList.add('desktop-sidebar-collapsed');
            sidebar.style.transform = 'translateX(-100%)';
            if (pageWrapper) {
                pageWrapper.style.marginLeft = '0px';
                pageWrapper.style.width = '100%';
            }
        }
    } else {
        if (window.HSOverlay) {
            const isOpened = sidebar.classList.contains('open') || sidebar.classList.contains('hs-overlay-open');
            if (isOpened) {
                window.HSOverlay.close(sidebar);
            } else {
                window.HSOverlay.open(sidebar);
            }
        } else {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('translate-x-0');
        }
    }
};
window.toggleDesktopSidebar = window.toggleAnySidebar;

// Global safeguard against Preline backdrop locking screens on any device or viewport
function cleanupAllBackdrops() {
    const backdrops = document.querySelectorAll('.hs-overlay-backdrop, [data-hs-overlay-backdrop-template], .hs-overlay-backdrop-open');
    if (backdrops.length > 0) {
        backdrops.forEach(el => el.remove());
    }
    if (!document.querySelector('.has-modal-open') && !document.querySelector('[id^="modal-"]:not([style*="display: none"]):not(.hidden)')) {
        document.body.classList.remove('overflow-hidden');
        document.body.style.overflow = '';
    }
}

window.cleanupAllBackdrops = cleanupAllBackdrops;
window.addEventListener('resize', cleanupAllBackdrops);
window.addEventListener('click', () => setTimeout(cleanupAllBackdrops, 20));
setInterval(cleanupAllBackdrops, 500);

// MutationObserver to automatically and immediately remove any injected hs-overlay-backdrop
const backdropObserver = new MutationObserver((mutations) => {
    for (const m of mutations) {
        for (const node of m.addedNodes) {
            if (node.nodeType === 1) {
                if (node.classList?.contains('hs-overlay-backdrop') || node.hasAttribute?.('data-hs-overlay-backdrop-template')) {
                    node.remove();
                    cleanupAllBackdrops();
                }
            }
        }
    }
});

document.addEventListener('DOMContentLoaded', () => {
    if (window.HSStaticMethods) {
        window.HSStaticMethods.autoInit();
    }
    cleanupAllBackdrops();
    if (document.body) {
        backdropObserver.observe(document.body, { childList: true, subtree: true });
    }

    // Explicit Dark / Light Mode Toggle Handlers
    const darkBtn = document.getElementById('dark-layout');
    const lightBtn = document.getElementById('light-layout');

    function applyThemeMode(mode) {
        const html = document.documentElement;
        if (mode === 'dark') {
            html.classList.add('dark');
            html.classList.remove('light');
            localStorage.setItem('hs_theme', 'dark');
            if (darkBtn) {
                darkBtn.classList.add('hidden');
                darkBtn.classList.remove('flex');
            }
            if (lightBtn) {
                lightBtn.classList.remove('hidden');
                lightBtn.classList.add('flex');
            }
        } else {
            html.classList.remove('dark');
            html.classList.add('light');
            localStorage.setItem('hs_theme', 'light');
            if (lightBtn) {
                lightBtn.classList.add('hidden');
                lightBtn.classList.remove('flex');
            }
            if (darkBtn) {
                darkBtn.classList.remove('hidden');
                darkBtn.classList.add('flex');
            }
        }
    }

    const currentTheme = localStorage.getItem('hs_theme') === 'dark' || document.documentElement.classList.contains('dark') ? 'dark' : 'light';
    applyThemeMode(currentTheme);

    if (darkBtn) {
        darkBtn.addEventListener('click', (e) => {
            e.preventDefault();
            applyThemeMode('dark');
        });
    }
    if (lightBtn) {
        lightBtn.addEventListener('click', (e) => {
            e.preventDefault();
            applyThemeMode('light');
        });
    }
});
