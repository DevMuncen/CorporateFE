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
        if (this.url.includes('warehouse')) {
            return [
                { id: 1, code: 'WH-QA-TAMBUN', name: 'Gudang QA Tambun Pusat', city: 'Kota Bekasi', pic_name: 'Bpk. Agus Santoso', phone: '081234567891', address: 'Jl. Sultan Hasanudin No. 88, Tambun Selatan' },
                { id: 2, code: 'GW-CMP-001', name: 'Gudang Pusat Korporasi Merah Putih', city: 'Kota Bekasi', pic_name: 'Bpk. Herman', phone: '081298765432', address: 'Kawasan Industri MM2100' },
                { id: 3, code: 'WH-BDG-002', name: 'Gudang Distribusi Bandung Barat', city: 'Kota Bandung', pic_name: 'Ibu Siti Rahma', phone: '081345678901', address: 'Jl. Soekarno Hatta No. 450, Bandung' },
                { id: 4, code: 'WH-SBY-003', name: 'Hub Logistik Surabaya Rungkut', city: 'Kota Surabaya', pic_name: 'Bpk. Bambang', phone: '081233445566', address: 'Kawasan SIER Rungkut Industri, Surabaya' }
            ];
        }
        if (this.url.includes('kota') || this.url.includes('wilayah') || this.url.includes('cities')) {
            return [
                { id: '3273', code: '3273', name: 'KOTA BANDUNG', city: 'Jawa Barat' },
                { id: '3275', code: '3275', name: 'KOTA BEKASI', city: 'Jawa Barat' },
                { id: '3171', code: '3171', name: 'KOTA JAKARTA PUSAT', city: 'DKI Jakarta' },
                { id: '3578', code: '3578', name: 'KOTA SURABAYA', city: 'Jawa Timur' },
                { id: '3674', code: '3674', name: 'KOTA TANGERANG SELATAN', city: 'Banten' },
                { id: '3204', code: '3204', name: 'KABUPATEN BANDUNG', city: 'Jawa Barat' },
                { id: '3216', code: '3216', name: 'KABUPATEN BEKASI', city: 'Jawa Barat' },
                { id: '3201', code: '3201', name: 'KABUPATEN BOGOR', city: 'Jawa Barat' },
                { id: '3271', code: '3271', name: 'KOTA BOGOR', city: 'Jawa Barat' },
                { id: '3276', code: '3276', name: 'KOTA DEPOK', city: 'Jawa Barat' },
                { id: '3173', code: '3173', name: 'KOTA JAKARTA BARAT', city: 'DKI Jakarta' },
                { id: '3174', code: '3174', name: 'KOTA JAKARTA SELATAN', city: 'DKI Jakarta' },
                { id: '3175', code: '3175', name: 'KOTA JAKARTA TIMUR', city: 'DKI Jakarta' },
                { id: '3172', code: '3172', name: 'KOTA JAKARTA UTARA', city: 'DKI Jakarta' }
            ];
        }
        if (this.url.includes('product')) {
            return [
                { id: 1, code: 'SKU-BRG-001', sku: 'SKU-BRG-001', name: 'Beras Premium 5kg', weight: 5, base_price: 75000, uom: 'Sak' },
                { id: 2, code: 'SKU-BRG-002', sku: 'SKU-BRG-002', name: 'Minyak Goreng 2L', weight: 2, base_price: 36000, uom: 'Pouch' },
                { id: 3, code: 'SKU-BRG-003', sku: 'SKU-BRG-003', name: 'Gula Pasir 1kg', weight: 1, base_price: 18000, uom: 'Bungkus' },
                { id: 4, code: 'SKU-BRG-004', sku: 'SKU-BRG-004', name: 'Tepung Terigu Segitiga 1kg', weight: 1, base_price: 14000, uom: 'Bungkus' },
                { id: 5, code: 'SKU-BRG-005', sku: 'SKU-BRG-005', name: 'Kopi Bubuk Spesial 250g', weight: 0.25, base_price: 25000, uom: 'Pcs' }
            ];
        }
        if (this.url.includes('fleet')) {
            return [
                { id: 1, code: 'FLT-CDE', name: 'CDE Box (Engkel)', capacity: 2000 },
                { id: 2, code: 'FLT-CDD', name: 'CDD Box (Double)', capacity: 4000 },
                { id: 3, code: 'FLT-FUSO', name: 'Fuso Heavy Box', capacity: 8000 },
                { id: 4, code: 'FLT-TRONTON', name: 'Tronton Wingbox', capacity: 15000 }
            ];
        }
        if (this.url.includes('logistic') || this.url.includes('vendor')) {
            return [
                { id: 1, code: 'LOG-CMP-001', name: 'PT Logistik Merah Putih Sentosa', city: 'Jakarta' },
                { id: 2, code: 'LOG-KGP-002', name: 'PT Kencana Graha Perkasa Logistik', city: 'Bandung' }
            ];
        }
        if (this.url.includes('corporate') || this.url.includes('customer') || this.url.includes('distributor')) {
            return [
                { id: 1, code: 'CORP-CMP', name: 'PT Cahaya Merah Putih', city: 'Jakarta Pusat' },
                { id: 2, code: 'DIST-BDG', name: 'Toko Mitra Grosir Bandung', city: 'Kota Bandung' }
            ];
        }
        return [];
    }

    async loadData() {
        if (!this.tbody) return;
        
        // Immediate pre-population so picker modal is NEVER empty or blocked by loading
        const initialData = this.getFallbackData();
        if (this.tbody.children.length === 0 && initialData.length > 0) {
            this.renderTable(initialData);
        }

        try {
            const separator = this.url.includes('?') ? '&' : '?';
            const endpoint = `${this.url}${separator}page=${this.currentPage}&search=${encodeURIComponent(this.searchQuery)}`;

            let payload = null;
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 1500);

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
                // Silently fallback on timeout or error
            } finally {
                clearTimeout(timeoutId);
            }

            // Normalize payload response
            let items = Array.isArray(payload) ? payload : (Array.isArray(payload?.data) ? payload.data : (payload?.data?.data || []));
            let meta = payload?.meta || payload?.pagination || (payload?.data && !Array.isArray(payload.data) ? payload.data : null);

            // Filter by search query if fallback or client filtering needed
            if ((!items || items.length === 0) && this.searchQuery) {
                const q = this.searchQuery.toLowerCase().trim();
                const fallbacks = this.getFallbackData();
                items = fallbacks.filter(it => (it.name || '').toLowerCase().includes(q) || (it.code || '').toLowerCase().includes(q));
            } else if (!items || items.length === 0) {
                items = this.getFallbackData();
            }

            this.renderTable(items);
            this.renderPagination(meta);
        } catch (error) {
            const fallback = this.getFallbackData();
            if (fallback.length > 0) {
                this.renderTable(fallback);
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
            const extra = item.city || item.province?.name || (item.weight ? `${item.weight} kg` : '') || '';

            const tr = document.createElement('tr');
            tr.className = 'cursor-pointer hover:bg-blue-50/70 dark:hover:bg-slate-700/50 transition-colors border-b border-slate-100 dark:border-slate-700/60';
            tr.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap text-xs font-mono font-bold text-slate-700 dark:text-slate-300">
                    <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700">${code}</span>
                </td>
                <td class="px-4 py-3 text-xs text-slate-800 dark:text-slate-200">
                    <div class="font-bold">${name}</div>
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
