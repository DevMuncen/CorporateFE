/**
 * Modal Picker Engine for CorporateFE
 * Handles entity picking with modal search, pagination, and debounce
 */

export class ModalPicker {
    constructor(config) {
        this.id = config.id;
        this.name = config.name;
        this.url = config.url;
        this.valueField = config.valueField || null;

        this.hiddenInput = document.getElementById(`hidden-${this.id}`);
        this.displayInput = document.getElementById(`display-${this.id}`);
        this.searchInput = document.getElementById(`search-${this.id}`);
        this.clearBtn = document.getElementById(`clear-${this.id}`);
        this.tbody = document.getElementById(`tbody-${this.id}`);
        this.paginationContainer = document.getElementById(`pagination-${this.id}`);
        this.modalEl = document.getElementById(`modal-picker-${this.id}`);
        this.triggerBtn = document.querySelector(`[data-hs-overlay="#modal-picker-${this.id}"]`);

        this.currentPage = 1;
        this.searchQuery = '';
        this.debounceTimeout = null;

        window.modalPickerInstances = window.modalPickerInstances || {};
        window.modalPickerInstances[this.id] = this;

        this.init();
    }

    init() {
        if (!this.tbody) return;

        // Move modal element to body root to prevent clipping or backdrop z-index issues
        if (this.modalEl && this.modalEl.parentElement !== document.body) {
            document.body.appendChild(this.modalEl);
        }

        // Search Input with Debounce
        if (this.searchInput) {
            this.searchInput.addEventListener('input', (e) => {
                clearTimeout(this.debounceTimeout);
                this.debounceTimeout = setTimeout(() => {
                    this.searchQuery = e.target.value;
                    this.currentPage = 1;
                    this.loadData();
                }, 400);
            });
        }

        // Load data when any trigger button or input is clicked or modal opened
        document.querySelectorAll(`[data-hs-overlay="#modal-picker-${this.id}"]`).forEach(trig => {
            trig.addEventListener('click', () => {
                this.loadData();
            });
        });
        if (this.modalEl) {
            this.modalEl.addEventListener('open.hs.overlay', () => {
                this.loadData();
            });
        }

        // Clear Button
        if (this.clearBtn) {
            this.clearBtn.addEventListener('click', () => {
                if (this.hiddenInput) {
                    this.hiddenInput.value = '';
                    delete this.hiddenInput.dataset.item;
                    this.hiddenInput.dispatchEvent(new CustomEvent('change', { bubbles: true, detail: { item: null } }));
                }
                if (this.displayInput) this.displayInput.value = '';
                this.clearBtn.classList.add('hidden');
            });
        }
    }

    getFallbackData() {
        return [];
    }

    async loadData() {
        if (!this.tbody) return;
        
        // Show clean loading spinner state instead of dummy standby data
        this.tbody.innerHTML = `
            <tr>
                <td colspan="3" class="px-6 py-8 text-center text-xs text-slate-400 dark:text-slate-500">
                    <div class="inline-flex items-center gap-2">
                        <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                        <span>Memuat data...</span>
                    </div>
                </td>
            </tr>
        `;

        try {
            const separator = this.url.includes('?') ? '&' : '?';
            const endpoint = `${this.url}${separator}page=${this.currentPage}&search=${encodeURIComponent(this.searchQuery)}`;

            let payload = null;
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 8000);

            try {
                if (window.axios) {
                    const res = await window.axios.get(endpoint, { signal: controller.signal });
                    payload = res.data;
                } else {
                    const res = await fetch(endpoint, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        signal: controller.signal
                    });
                    payload = await res.json();
                }
            } catch (networkErr) {
                console.warn('Modal picker network fetch warning:', networkErr);
            } finally {
                clearTimeout(timeoutId);
            }

            // Normalize payload response
            let items = Array.isArray(payload) ? payload : (Array.isArray(payload?.data) ? payload.data : (payload?.data?.data || []));
            let meta = payload?.meta || payload?.pagination || (payload?.data && !Array.isArray(payload.data) ? payload.data : null);

            this.renderTable(items || []);
            this.renderPagination(meta);
        } catch (error) {
            console.error('Modal picker loadData error:', error);
            if (this.tbody) {
                this.tbody.innerHTML = '<tr><td colspan="3" class="px-6 py-8 text-center text-xs text-rose-500 dark:text-rose-400">Gagal memuat data. Silakan coba lagi.</td></tr>';
            }
        }
    }

    renderTable(items) {
        if (!this.tbody) return;
        if (!items || items.length === 0) {
            this.tbody.innerHTML = '<tr><td colspan="3" class="px-6 py-6 text-center text-xs text-slate-400 dark:text-slate-500">Tidak ada data ditemukan.</td></tr>';
            return;
        }

        this.tbody.innerHTML = '';
        items.forEach((item, index) => {
            const code = item.code || item.reference_number || item.sku || item.id || `#${index + 1}`;
            const name = item.name || item.title || item.description || '-';
            const typeBadge = item.type === 'distributor' 
                ? '<span class="inline-flex items-center gap-0.5 ml-1 px-1.5 py-0.2 rounded text-[10px] font-bold bg-purple-100 text-purple-700 dark:bg-purple-900/60 dark:text-purple-300">Mitra Distribusi</span>'
                : (item.type === 'customer' ? '<span class="inline-flex items-center gap-0.5 ml-1 px-1.5 py-0.2 rounded text-[10px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300">Pelanggan</span>' : '');
            const extra = item.city_name || item.city || item.province?.name || (item.weight ? `${item.weight} kg` : '') || (item.phone ? `Telp: ${item.phone}` : '') || '';

            const tr = document.createElement('tr');
            tr.className = 'cursor-pointer hover:bg-blue-50/70 dark:hover:bg-slate-700/50 transition-colors border-b border-slate-100 dark:border-slate-700/60';
            tr.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap text-xs font-mono font-bold text-slate-700 dark:text-slate-300">
                    <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700">${code}</span>
                </td>
                <td class="px-4 py-3 text-xs text-slate-800 dark:text-slate-200">
                    <div class="font-bold flex items-center flex-wrap gap-1">${name} ${typeBadge}</div>
                    ${extra ? `<div class="text-[11px] text-slate-400 mt-0.5">${extra}</div>` : ''}
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-end text-xs font-medium">
                    <button type="button" class="px-3.5 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-sm shadow-blue-600/20 transition-all pointer-events-none">
                        Pilih
                    </button>
                </td>
            `;

            // Row-level click handler for seamless selection
            tr.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.selectItem(item);
            });

            this.tbody.appendChild(tr);
        });
    }

    renderPagination(meta) {
        if (!this.paginationContainer) return;
        if (!meta || !meta.last_page || meta.last_page <= 1) {
            this.paginationContainer.innerHTML = '';
            return;
        }

        const currentPage = meta.current_page || this.currentPage;
        const lastPage = meta.last_page || 1;

        let html = `
            <span class="text-xs text-slate-500 dark:text-slate-400">Halaman ${currentPage} dari ${lastPage}</span>
            <div class="inline-flex gap-1.5">
                <button type="button" class="picker-prev-btn px-2.5 py-1 text-xs font-medium rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-50 disabled:opacity-40" ${currentPage === 1 ? 'disabled' : ''}>
                    &larr; Prev
                </button>
                <button type="button" class="picker-next-btn px-2.5 py-1 text-xs font-medium rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-50 disabled:opacity-40" ${currentPage === lastPage ? 'disabled' : ''}>
                    Next &rarr;
                </button>
            </div>
        `;

        this.paginationContainer.innerHTML = html;

        const prevBtn = this.paginationContainer.querySelector('.picker-prev-btn');
        const nextBtn = this.paginationContainer.querySelector('.picker-next-btn');

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                if (this.currentPage > 1) {
                    this.currentPage--;
                    this.loadData();
                }
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                if (this.currentPage < lastPage) {
                    this.currentPage++;
                    this.loadData();
                }
            });
        }
    }

    selectItem(item) {
        if (!item) return;
        const valField = this.valueField || null;
        const id = (valField && item[valField] !== undefined) ? item[valField] : (item.id || item.code || item.name);
        const name = item.name || item.title || item.description || id;

        if (this.hiddenInput) {
            this.hiddenInput.value = id;
            this.hiddenInput.dataset.item = JSON.stringify(item);
            this.hiddenInput.dispatchEvent(new CustomEvent('change', { bubbles: true, detail: { id, name, item } }));
        }

        if (this.displayInput) {
            this.displayInput.value = name;
        }

        if (this.clearBtn) {
            this.clearBtn.classList.remove('hidden');
        }

        this.closeModal();
    }

    openModal() {
        if (!this.modalEl) return;
        document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
        document.body.classList.remove('overflow-hidden');
        document.body.style.overflow = '';
        this.modalEl.style.display = 'flex';
        this.modalEl.classList.remove('hidden');
        this.loadData();
        if (this.searchInput) {
            setTimeout(() => this.searchInput.focus(), 60);
        }
    }

    closeModal() {
        if (!this.modalEl) return;
        this.modalEl.style.display = 'none';
        this.modalEl.classList.add('hidden');
        document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
        document.body.classList.remove('overflow-hidden');
        document.body.style.overflow = '';
    }
}

window.modalPickerInstances = window.modalPickerInstances || {};

window.openModalPicker = function(pickerId) {
    let p = window.modalPickerInstances[pickerId];
    if (!p) {
        const container = document.getElementById(`picker-container-${pickerId}`) || document.querySelector(`[data-modal-picker][data-id="${pickerId}"]`);
        if (container) {
            container.dataset.pickerInitialized = 'true';
            p = new ModalPicker({
                id: container.dataset.id || pickerId,
                name: container.dataset.name,
                url: container.dataset.url,
                valueField: container.dataset.valueField
            });
        }
    }

    if (p) {
        p.openModal();
    } else {
        const el = document.getElementById(`modal-picker-${pickerId}`);
        if (el) {
            document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
            document.body.classList.remove('overflow-hidden');
            document.body.style.overflow = '';
            el.style.display = 'flex';
            el.classList.remove('hidden');
        }
    }
};

window.closeModalPicker = function(pickerId) {
    const p = window.modalPickerInstances[pickerId];
    if (p) {
        p.closeModal();
    } else {
        const el = document.getElementById(`modal-picker-${pickerId}`);
        if (el) {
            el.style.display = 'none';
            el.classList.add('hidden');
            document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
            document.body.classList.remove('overflow-hidden');
            document.body.style.overflow = '';
        }
    }
};

/**
 * Universal Global Helper to set and autoload modal picker values across pages
 */
window.setPickerValue = async function(pickerId, value, displayText = null, extraItemData = null) {
    const hidden = document.getElementById(`hidden-${pickerId}`);
    const display = document.getElementById(`display-${pickerId}`);
    const clear = document.getElementById(`clear-${pickerId}`);
    if (!hidden) return;

    if (!value && value !== 0) {
        hidden.value = '';
        delete hidden.dataset.item;
        if (display) display.value = '';
        if (clear) clear.classList.add('hidden');
        hidden.dispatchEvent(new CustomEvent('change', { bubbles: true, detail: { item: null } }));
        return;
    }

    hidden.value = value;
    if (extraItemData) {
        hidden.dataset.item = JSON.stringify(extraItemData);
    }

    if (displayText) {
        if (display) display.value = displayText;
        if (clear) clear.classList.remove('hidden');
        hidden.dispatchEvent(new CustomEvent('change', { bubbles: true, detail: { item: extraItemData || { id: value, name: displayText } } }));
        return;
    }

    // Autoload from picker url if displayText is not provided
    const container = document.getElementById(`picker-container-${pickerId}`) || document.querySelector(`[data-modal-picker][data-id="${pickerId}"]`);
    const url = container?.dataset?.url;
    if (url) {
        if (display) display.value = 'Memuat...';
        try {
            const sep = url.includes('?') ? '&' : '?';
            let res;
            if (window.axios) {
                res = await window.axios.get(`${url}/${value}`);
            } else if (window.Api) {
                res = await window.Api.get(`${url}/${value}`);
            } else {
                const response = await fetch(`${url}/${value}`, { headers: { 'Accept': 'application/json' } });
                res = await response.json();
            }
            const item = res.data?.data || res.data || res;
            const name = item.name || item.title || item.reference_number || item.code || item.description || value;
            if (display) display.value = name;
            hidden.dataset.item = JSON.stringify(item);
            if (clear) clear.classList.remove('hidden');
            hidden.dispatchEvent(new CustomEvent('change', { bubbles: true, detail: { item } }));
            return;
        } catch (e) {
            try {
                const sep = url.includes('?') ? '&' : '?';
                let res;
                if (window.axios) {
                    res = await window.axios.get(`${url}${sep}search=${encodeURIComponent(value)}`);
                } else if (window.Api) {
                    res = await window.Api.get(`${url}${sep}search=${encodeURIComponent(value)}`);
                }
                const raw = res?.data?.data || res?.data || res;
                const items = Array.isArray(raw) ? raw : (raw?.data || []);
                const found = items.find(it => String(it.id) === String(value) || String(it.code) === String(value) || String(it.name).toLowerCase() === String(value).toLowerCase());
                if (found) {
                    const name = found.name || found.title || found.reference_number || found.code || value;
                    if (display) display.value = name;
                    hidden.dataset.item = JSON.stringify(found);
                    if (clear) clear.classList.remove('hidden');
                    hidden.dispatchEvent(new CustomEvent('change', { bubbles: true, detail: { item: found } }));
                    return;
                }
            } catch (err2) {
                // Ignore fallback error
            }
            if (display) display.value = value;
            if (clear) clear.classList.remove('hidden');
        }
    } else {
        if (display) display.value = value;
        if (clear) clear.classList.remove('hidden');
    }
};

ModalPicker.setValue = window.setPickerValue;
window.setModalPickerValue = window.setPickerValue;

export function initModalPickers() {
    document.querySelectorAll('[data-modal-picker]').forEach(el => {
        if (!el.dataset.pickerInitialized) {
            el.dataset.pickerInitialized = 'true';
            new ModalPicker({
                id: el.dataset.id,
                name: el.dataset.name,
                url: el.dataset.url,
                valueField: el.dataset.valueField
            });
        }
    });
}

window.ModalPicker = ModalPicker;
window.initModalPickers = initModalPickers;

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initModalPickers);
} else {
    initModalPickers();
}
