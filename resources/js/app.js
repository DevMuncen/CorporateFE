import 'preline';
import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Global Toast Notification Helper
window.showToast = function(message, type = 'success') {
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
