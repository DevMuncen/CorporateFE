<x-layout.app title="Barang Masuk (Item In) | Corporate Merchant Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="/inventory/stocks" class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors inline-flex items-center gap-1 mb-1">
                    <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                    <span>Kembali ke Monitoring Stok</span>
                </a>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Penerimaan Barang Masuk (Inbound)
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Catatan penerimaan kargo dari pabrik produsen atau supplier ke dalam gudang korporasi
                </p>
            </div>
            <button type="button" onclick="openItemInModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-500 shadow-md shadow-emerald-600/25 transition-all flex items-center gap-2 self-start sm:self-auto">
                <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                <span>+ Catat Barang Masuk</span>
            </button>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">No. Transaksi</th>
                            <th class="py-3.5">Ref. Surat Jalan / PO</th>
                            <th class="py-3.5">Tanggal Masuk</th>
                            <th class="py-3.5">Gudang Penerima</th>
                            <th class="py-3.5">Vendor / Pemasok</th>
                            <th class="py-3.5 text-right">Total Kuantitas</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="itemInsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat riwayat barang masuk...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Form Catat Barang Masuk -->
    <div id="itemInModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;" onclick="closeItemInModal()">
        <div class="bg-white dark:bg-slate-800 rounded-3xl w-full max-w-4xl max-h-[92vh] flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 flex items-center justify-center">
                        <iconify-icon icon="solar:import-bold-duotone" class="text-xl"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 dark:text-white">Catat Barang Masuk (Inbound)</h3>
                        <p class="text-xs text-slate-400">Penerimaan pasokan barang ke saldo inventori gudang</p>
                    </div>
                </div>
                <button type="button" onclick="closeItemInModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>

            <form id="itemInForm" onsubmit="saveItemIn(event)" class="flex flex-col flex-1 overflow-hidden text-xs">
                <div class="p-6 md:p-8 overflow-y-auto flex-1 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="lg:col-span-2">
                            <x-modal-picker 
                                id="inWarehousePicker" 
                                name="warehouse_id" 
                                label="Gudang Penerima" 
                                url="/api/warehouses" 
                                required="true" 
                                placeholder="Pilih Gudang Penerima..." 
                            />
                        </div>
                        <div class="lg:col-span-2">
                            <x-modal-picker 
                                id="inVendorPicker" 
                                name="vendor_id" 
                                label="Vendor / Pemasok (Opsional)" 
                                url="/api/vendors" 
                                placeholder="Pilih Vendor / Pemasok..." 
                            />
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Penerimaan <span class="text-rose-500">*</span></label>
                            <input type="date" id="inReceiptDate" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-600 focus:outline-none" />
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">No. Surat Jalan / PO Ref</label>
                            <input type="text" id="inReferenceNumber" placeholder="Contoh: SJ-2026/09/8812" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-100 placeholder:text-slate-400 placeholder:font-normal focus:ring-2 focus:ring-emerald-600 focus:outline-none" />
                        </div>
                        <div class="col-span-full">
                            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Catatan Penerimaan</label>
                            <input type="text" id="inActionNotes" placeholder="Catatan kondisi muatan, nomor kontainer, armada supplier..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-100 placeholder:text-slate-400 placeholder:font-normal focus:ring-2 focus:ring-emerald-600 focus:outline-none" />
                        </div>
                    </div>

                    <!-- Daftar Item Produk (Menggunakan Picker) -->
                    <div class="pt-2">
                        <div class="flex items-center justify-between mb-3">
                            <label class="font-black text-slate-800 dark:text-slate-200 text-sm flex items-center gap-2">
                                <iconify-icon icon="solar:box-minimalistic-linear" class="text-lg text-emerald-600"></iconify-icon>
                                <span>Daftar Barang Diterima <span class="text-rose-500">*</span></span>
                            </label>
                            <button type="button" onclick="openInboundProductPicker(null)" class="px-3.5 py-1.5 text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-xl hover:bg-emerald-100 flex items-center gap-1.5 shadow-xs transition-all">
                                <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                                <span>+ Tambah Baris Produk</span>
                            </button>
                        </div>

                        <div class="border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-xs">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                                    <tr>
                                        <th class="py-3 pl-4">Produk / SKU <span class="text-rose-500">*</span></th>
                                        <th class="py-3 w-40">Kuantitas <span class="text-rose-500">*</span></th>
                                        <th class="py-3 w-48">Kondisi</th>
                                        <th class="py-3 pr-4 w-14 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="inItemsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                                    <!-- Dynamic Rows with Picker -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 py-4 px-6 border-t border-slate-100 dark:border-slate-700 shrink-0 bg-slate-50/50 dark:bg-slate-800/50">
                    <button type="button" onclick="closeItemInModal()" class="px-5 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button type="submit" id="saveInboundBtn" class="px-6 py-2.5 rounded-xl text-white font-bold bg-emerald-600 hover:bg-emerald-500 shadow-md shadow-emerald-600/25 transition-all flex items-center gap-2">
                        <iconify-icon icon="solar:check-circle-bold" class="text-lg"></iconify-icon>
                        <span>Simpan Penerimaan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Modal Picker for Inbound (Dynamic Picker Engine) -->
    <div id="modal-inbound-product-picker" class="fixed inset-0 z-[100] items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;" onclick="closeInboundProductPicker()">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-2xl w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700 relative z-10 max-h-[90vh] flex flex-col" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700 mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 flex items-center justify-center">
                        <iconify-icon icon="solar:box-minimalistic-bold" class="text-xl"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900 dark:text-white">Pilih Produk SKU (Inbound)</h3>
                        <p class="text-[11px] text-slate-400">Pilih dari katalog produk atau gunakan pencarian nama / kode SKU</p>
                    </div>
                </div>
                <button type="button" onclick="closeInboundProductPicker()" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700">
                    <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                </button>
            </div>
            <div class="mb-4">
                <div class="relative">
                    <input type="text" id="search-inbound-product-picker" oninput="filterInboundProductPicker(this.value)" class="w-full pl-9 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-emerald-600 focus:outline-none text-slate-800 dark:text-slate-100" placeholder="Ketik kode SKU atau nama barang...">
                    <iconify-icon icon="solar:rounded-magnifer-linear" class="absolute left-3 top-3 text-slate-400 text-sm"></iconify-icon>
                </div>
            </div>
            <div class="overflow-y-auto overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-700 flex-1 max-h-80">
                <table class="w-full text-left text-xs divide-y divide-slate-100 dark:divide-slate-700">
                    <thead class="bg-slate-50 dark:bg-slate-900 text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider text-[10px] sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-4 py-2.5 w-10">No</th>
                            <th scope="col" class="px-4 py-2.5">SKU / Kode</th>
                            <th scope="col" class="px-4 py-2.5">Nama Produk</th>
                            <th scope="col" class="px-4 py-2.5">Kategori / Satuan</th>
                            <th scope="col" class="px-4 py-2.5 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-inbound-product-picker" class="divide-y divide-slate-100 dark:divide-slate-700/60 bg-white dark:bg-slate-800">
                        <!-- Populated by JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detail Item In -->
    <div id="itemInDetailModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;" onclick="closeItemInDetailModal()">
        <div class="bg-white dark:bg-slate-800 rounded-3xl w-full max-w-2xl max-h-[90vh] flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <h3 id="detailInTitle" class="text-lg font-black text-slate-900 dark:text-white">Rincian Barang Masuk</h3>
                <button type="button" onclick="closeItemInDetailModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div id="detailInContent" class="p-6 md:p-8 overflow-y-auto flex-1 space-y-4 text-xs">
                <!-- Injected via JS -->
            </div>
            <div class="flex justify-end py-3.5 px-6 border-t border-slate-100 dark:border-slate-700 shrink-0 bg-slate-50/50 dark:bg-slate-800/50">
                <button type="button" onclick="closeItemInDetailModal()" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-200 transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let cachedProducts = [];
        let itemInsList = [];
        let activeInboundRowId = null;

        async function initDependencies() {
            try {
                const prodRes = await axios.get('/api/products?per_page=100');
                cachedProducts = prodRes.data?.data?.data || prodRes.data?.data || [];
            } catch (e) {
                console.error('Error loading product catalog for picker:', e);
            }
        }

        async function fetchItemIns() {
            const tbody = document.getElementById('itemInsTableBody');
            try {
                let res;
                try {
                    res = await axios.get('/api/inventory/item-ins');
                } catch (err404) {
                    try {
                        res = await axios.get('/api/internal/corporate/item-ins');
                    } catch (e2) {
                        res = await axios.get('/api/item-ins');
                    }
                }

                const data = res.data?.data?.data || res.data?.data || [];
                itemInsList = data;

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Belum ada catatan penerimaan barang masuk.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map((i, idx) => {
                    const totalQty = i.total_quantity || (i.details ? i.details.reduce((a, b) => a + (Number(b.quantity) || 0), 0) : 0);
                    return `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                            <td class="py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">${i.transaction_number || 'IN-#' + i.id}</td>
                            <td class="py-3.5 font-mono text-slate-600 dark:text-slate-400">${i.reference_number || '-'}</td>
                            <td class="py-3.5 text-slate-500">${i.receipt_date || (i.created_at ? new Date(i.created_at).toLocaleDateString('id-ID') : '-')}</td>
                            <td class="py-3.5 font-bold text-slate-800 dark:text-slate-200">${i.warehouse?.name || 'Gudang Pusat'}</td>
                            <td class="py-3.5 text-slate-600 dark:text-slate-300">${i.vendor?.name || i.supplier_name || '-'}</td>
                            <td class="py-3.5 text-right font-black text-emerald-600">${totalQty.toLocaleString('id-ID')} unit</td>
                            <td class="py-3.5 pr-6 text-right">
                                <button type="button" onclick="showItemInDetail(${idx})" class="px-2.5 py-1 rounded-lg text-blue-600 bg-blue-50 dark:bg-blue-950/40 hover:bg-blue-100 font-bold transition-all">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');
            } catch (err) {
                console.error('Fetch item ins error:', err);
                tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Gagal memuat catatan barang masuk.</td></tr>`;
            }
        }

        function openItemInModal() {
            document.getElementById('itemInForm').reset();
            document.getElementById('inReceiptDate').value = new Date().toISOString().split('T')[0];
            document.getElementById('inReferenceNumber').value = '';
            document.getElementById('inActionNotes').value = '';

            // Reset pickers
            const whH = document.getElementById('hidden-inWarehousePicker');
            const whD = document.getElementById('display-inWarehousePicker');
            if (whH) whH.value = '';
            if (whD) whD.value = '';

            const vendH = document.getElementById('hidden-inVendorPicker');
            const vendD = document.getElementById('display-inVendorPicker');
            if (vendH) vendH.value = '';
            if (vendD) vendD.value = '';

            document.getElementById('inItemsTableBody').innerHTML = '';
            addItemInRow();
            document.getElementById('itemInModal').style.display = 'flex';
        }

        function closeItemInModal() {
            document.getElementById('itemInModal').style.display = 'none';
            document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
        }

        function addItemInRow(initialProdId = null) {
            const tbody = document.getElementById('inItemsTableBody');
            const rowId = 'inrow_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4);

            let displayText = '';
            if (initialProdId) {
                const found = cachedProducts.find(p => String(p.id) === String(initialProdId));
                if (found) {
                    displayText = (found.sku ? `[${found.sku}] ` : '') + found.name;
                }
            }

            const tr = document.createElement('tr');
            tr.id = rowId;
            tr.className = 'hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors';
            tr.innerHTML = `
                <td class="py-2.5 pl-3 pr-2">
                    <div class="flex items-center gap-1.5">
                        <input type="text" readonly id="display-in-prod-${rowId}" value="${escapeHtml(displayText)}" placeholder="-- Klik untuk Pilih Produk SKU --" onclick="openInboundProductPicker('${rowId}')" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-100 placeholder:text-slate-400 placeholder:font-normal cursor-pointer focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        <input type="hidden" id="hidden-in-prod-${rowId}" class="in-product-hidden" value="${initialProdId || ''}">
                        <button type="button" onclick="openInboundProductPicker('${rowId}')" title="Cari Produk SKU" class="px-2.5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl flex items-center justify-center transition-colors shrink-0 shadow-xs">
                            <iconify-icon icon="solar:rounded-magnifer-linear" class="text-sm"></iconify-icon>
                        </button>
                    </div>
                </td>
                <td class="py-2.5 pr-2">
                    <input type="number" min="1" value="1" required class="in-qty-input w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-right font-bold focus:ring-2 focus:ring-emerald-600 focus:outline-none" />
                </td>
                <td class="py-2.5 pr-2">
                    <select class="in-condition-select w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        <option value="good">Bagus (Good)</option>
                        <option value="damaged">Rusak (Damaged)</option>
                    </select>
                </td>
                <td class="py-2.5 pr-3 text-center">
                    <button type="button" onclick="removeInboundRow('${rowId}')" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors">
                        <iconify-icon icon="solar:trash-bin-trash-bold" class="text-base"></iconify-icon>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        }

        function removeInboundRow(rowId) {
            const row = document.getElementById(rowId);
            if (row) row.remove();
        }

        // Product Modal Picker Logic
        function openInboundProductPicker(rowId = null) {
            activeInboundRowId = rowId;
            const searchEl = document.getElementById('search-inbound-product-picker');
            if (searchEl) searchEl.value = '';
            renderInboundProductPickerList(cachedProducts);
            const modalEl = document.getElementById('modal-inbound-product-picker');
            if (modalEl) {
                modalEl.style.display = 'flex';
                setTimeout(() => searchEl && searchEl.focus(), 60);
            }
        }

        function closeInboundProductPicker() {
            const modalEl = document.getElementById('modal-inbound-product-picker');
            if (modalEl) modalEl.style.display = 'none';
        }

        function filterInboundProductPicker(query) {
            const q = String(query || '').trim().toLowerCase();
            const filtered = (cachedProducts || []).filter(p => {
                const sku = String(p.sku || p.code || '').toLowerCase();
                const name = String(p.name || '').toLowerCase();
                return !q || sku.includes(q) || name.includes(q);
            });
            renderInboundProductPickerList(filtered);
        }

        function renderInboundProductPickerList(list) {
            const tbody = document.getElementById('tbody-inbound-product-picker');
            if (!tbody) return;

            if (!list || list.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-slate-400">Tidak ada produk ditemukan.</td></tr>';
                return;
            }

            tbody.innerHTML = list.map((p, idx) => {
                const sku = p.sku || p.code || ('SKU-' + p.id);
                const category = p.category?.name || p.category_name || '-';
                const uom = p.unit_of_measure?.name || p.uom?.name || p.uom || 'Unit';
                return `
                    <tr class="hover:bg-emerald-50/60 dark:hover:bg-slate-700/40 transition-colors cursor-pointer" onclick="selectInboundProduct(${p.id})">
                        <td class="px-4 py-2.5 text-xs text-slate-400">${idx + 1}</td>
                        <td class="px-4 py-2.5 whitespace-nowrap text-xs font-mono font-bold text-slate-700 dark:text-slate-200">
                            <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700">${escapeHtml(sku)}</span>
                        </td>
                        <td class="px-4 py-2.5 text-xs font-bold text-slate-800 dark:text-slate-100">${escapeHtml(p.name)}</td>
                        <td class="px-4 py-2.5 text-xs text-slate-500">${escapeHtml(category)} <span class="text-slate-400">(${escapeHtml(uom)})</span></td>
                        <td class="px-4 py-2.5 text-end">
                            <button type="button" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-[11px] font-bold transition-all shadow-xs pointer-events-none">
                                Pilih
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function selectInboundProduct(prodId) {
            const prod = cachedProducts.find(p => String(p.id) === String(prodId));
            if (!prod) return;

            const displayText = (prod.sku ? `[${prod.sku}] ` : '') + prod.name;

            if (activeInboundRowId) {
                const disp = document.getElementById(`display-in-prod-${activeInboundRowId}`);
                const hid = document.getElementById(`hidden-in-prod-${activeInboundRowId}`);
                if (disp) disp.value = displayText;
                if (hid) hid.value = prod.id;
            } else {
                // If added from + Tambah Baris Produk
                const emptyRow = Array.from(document.querySelectorAll('#inItemsTableBody tr')).find(r => !r.querySelector('.in-product-hidden')?.value);
                if (emptyRow) {
                    const rowId = emptyRow.id;
                    const disp = document.getElementById(`display-in-prod-${rowId}`);
                    const hid = document.getElementById(`hidden-in-prod-${rowId}`);
                    if (disp) disp.value = displayText;
                    if (hid) hid.value = prod.id;
                } else {
                    addItemInRow(prod.id);
                }
            }

            closeInboundProductPicker();
        }

        async function saveItemIn(e) {
            e.preventDefault();
            const btn = document.getElementById('saveInboundBtn');
            const rows = document.querySelectorAll('#inItemsTableBody tr');

            const warehouseId = document.getElementById('hidden-inWarehousePicker')?.value;
            const vendorId = document.getElementById('hidden-inVendorPicker')?.value;

            if (!warehouseId) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan pilih Gudang Penerima terlebih dahulu.' });
                return;
            }

            if (!rows.length) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan tambahkan minimal 1 baris produk yang diterima.' });
                return;
            }

            const details = [];
            for (const r of rows) {
                const prodId = r.querySelector('.in-product-hidden')?.value;
                const qty = Number(r.querySelector('.in-qty-input')?.value);
                const cond = r.querySelector('.in-condition-select')?.value || 'good';

                if (!prodId) {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Mohon pilih produk SKU untuk semua baris barang.' });
                    return;
                }
                if (!qty || qty <= 0) {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Kuantitas barang harus lebih dari 0.' });
                    return;
                }

                details.push({
                    product_id: Number(prodId),
                    quantity: qty,
                    condition: cond
                });
            }

            const payload = {
                warehouse_id: Number(warehouseId),
                vendor_id: vendorId ? Number(vendorId) : null,
                receipt_date: document.getElementById('inReceiptDate').value,
                reference_number: document.getElementById('inReferenceNumber').value || null,
                action_notes: document.getElementById('inActionNotes').value || null,
                details: details
            };

            btn.disabled = true;
            btn.innerHTML = '<div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div><span>Menyimpan...</span>';

            try {
                try {
                    await axios.post('/api/inventory/item-ins', payload);
                } catch (errPost) {
                    try {
                        await axios.post('/api/internal/corporate/item-ins', payload);
                    } catch (e2) {
                        await axios.post('/api/item-ins', payload);
                    }
                }
                closeItemInModal();
                fetchItemIns();
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Penerimaan barang masuk berhasil dicatat dan saldo inventori telah diperbarui!' });
            } catch (err) {
                console.error('Save item in error:', err);
                const msg = err.response?.data?.message || err.message || 'Terjadi kesalahan sistem saat menyimpan penerimaan.';
                Swal.fire({ icon: 'error', title: 'Gagal Menyimpan', text: msg });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<iconify-icon icon="solar:check-circle-bold" class="text-lg"></iconify-icon><span>Simpan Penerimaan</span>';
            }
        }

        function showItemInDetail(idx) {
            const item = itemInsList[idx];
            if (!item) return;

            document.getElementById('detailInTitle').innerText = 'Rincian: ' + (item.transaction_number || 'IN-#' + item.id);
            const content = document.getElementById('detailInContent');

            const detailsHtml = (item.details || []).map(d => `
                <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-700 text-xs">
                    <div>
                        <div class="font-bold text-slate-800 dark:text-slate-100">${escapeHtml(d.product?.name || 'Produk ID #' + d.product_id)}</div>
                        <div class="text-[10px] text-slate-400 font-mono">${escapeHtml(d.product?.sku || '-')} | Kondisi: <span class="capitalize font-semibold text-emerald-600">${d.condition || 'good'}</span></div>
                    </div>
                    <div class="font-black text-emerald-600 text-sm">${(d.quantity || 0).toLocaleString('id-ID')} unit</div>
                </div>
            `).join('') || '<div class="text-slate-400 italic">Tidak ada rincian item.</div>';

            content.innerHTML = `
                <div class="grid grid-cols-2 gap-3 pb-3 border-b border-slate-100 dark:border-slate-700 text-xs">
                    <div><span class="text-slate-400">Gudang Penerima:</span> <strong class="text-slate-700 dark:text-slate-200 block mt-0.5">${escapeHtml(item.warehouse?.name || '-')}</strong></div>
                    <div><span class="text-slate-400">Vendor / Pemasok:</span> <strong class="text-slate-700 dark:text-slate-200 block mt-0.5">${escapeHtml(item.vendor?.name || item.supplier_name || '-')}</strong></div>
                    <div><span class="text-slate-400">Tanggal Masuk:</span> <strong class="text-slate-700 dark:text-slate-200 block mt-0.5">${item.receipt_date || '-'}</strong></div>
                    <div><span class="text-slate-400">Ref. Surat Jalan:</span> <strong class="text-slate-700 dark:text-slate-200 font-mono block mt-0.5">${escapeHtml(item.reference_number || '-')}</strong></div>
                    <div class="col-span-2"><span class="text-slate-400">Catatan:</span> <strong class="text-slate-700 dark:text-slate-200 block mt-0.5">${escapeHtml(item.action_notes || '-')}</strong></div>
                </div>
                <div class="pt-2">
                    <h4 class="font-bold text-slate-700 dark:text-slate-300 mb-2">Item Barang Diterima:</h4>
                    <div class="space-y-1">
                        ${detailsHtml}
                    </div>
                </div>
            `;

            document.getElementById('itemInDetailModal').style.display = 'flex';
        }

        function closeItemInDetailModal() {
            document.getElementById('itemInDetailModal').style.display = 'none';
        }

        function escapeHtml(text) {
            if (!text) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        document.addEventListener('DOMContentLoaded', () => {
            initDependencies();
            fetchItemIns();
        });
    </script>
    @endpush
</x-layout.app>