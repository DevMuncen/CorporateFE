<x-layout.app title="Barang Keluar (Item Out) | Corporate Merchant Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="/inventory/stocks" class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors inline-flex items-center gap-1 mb-1">
                    <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                    <span>Kembali ke Monitoring Stok</span>
                </a>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Pengeluaran Barang (Outbound)
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Catatan pemuatan kargo keluar gudang berdasarkan penerbitan Request Order dan Waybill
                </p>
            </div>
            <button type="button" onclick="openItemOutModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-amber-600 hover:bg-amber-500 shadow-md shadow-amber-600/25 transition-all flex items-center gap-2 self-start sm:self-auto">
                <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                <span>+ Catat Barang Keluar</span>
            </button>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">No. Pengeluaran</th>
                            <th class="py-3.5">Ref. Surat Jalan / RO</th>
                            <th class="py-3.5">Tanggal Keluar</th>
                            <th class="py-3.5">Gudang Asal</th>
                            <th class="py-3.5">Pelanggan / Penerima</th>
                            <th class="py-3.5 text-right">Total Kuantitas</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="itemOutsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-amber-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat riwayat pengeluaran barang...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Form Catat Barang Keluar -->
    <div id="itemOutModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;" onclick="closeItemOutModal()">
        <div class="bg-white dark:bg-slate-800 rounded-3xl w-full max-w-4xl max-h-[92vh] flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 flex items-center justify-center">
                        <iconify-icon icon="solar:export-bold-duotone" class="text-xl"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 dark:text-white">Catat Barang Keluar (Outbound)</h3>
                        <p class="text-xs text-slate-400">Pengurangan saldo stok gudang untuk pesanan / pengiriman mitra</p>
                    </div>
                </div>
                <button type="button" onclick="closeItemOutModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>

            <form id="itemOutForm" onsubmit="saveItemOut(event)" class="flex flex-col flex-1 overflow-hidden text-xs">
                <div class="p-6 md:p-8 overflow-y-auto flex-1 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="lg:col-span-2">
                            <x-modal-picker 
                                id="outWarehousePicker" 
                                name="warehouse_id" 
                                label="Gudang Asal" 
                                url="/api/warehouses" 
                                required="true" 
                                placeholder="Pilih Gudang Asal..." 
                            />
                        </div>
                        <div class="lg:col-span-2">
                            <x-modal-picker 
                                id="outCustomerPicker" 
                                name="customer_id" 
                                label="Pelanggan / Penerima (Opsional)" 
                                url="/api/customers" 
                                placeholder="Pilih Pelanggan / Customer..." 
                            />
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Keluar <span class="text-rose-500">*</span></label>
                            <input type="date" id="outIssueDate" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-amber-600 focus:outline-none" />
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">No. Ref Surat Jalan / RO Ref</label>
                            <input type="text" id="outReferenceNumber" placeholder="Contoh: RO-20261020-001 / SJ-091" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-100 placeholder:text-slate-400 placeholder:font-normal focus:ring-2 focus:ring-amber-600 focus:outline-none" />
                        </div>
                        <div class="col-span-full">
                            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Catatan Pengeluaran</label>
                            <input type="text" id="outActionNotes" placeholder="Catatan armada jemput, nama driver/supir, tujuan distribusi..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-100 placeholder:text-slate-400 placeholder:font-normal focus:ring-2 focus:ring-amber-600 focus:outline-none" />
                        </div>
                    </div>

                    <!-- Daftar Item Produk (Menggunakan Picker) -->
                    <div class="pt-2">
                        <div class="flex items-center justify-between mb-3">
                            <label class="font-black text-slate-800 dark:text-slate-200 text-sm flex items-center gap-2">
                                <iconify-icon icon="solar:box-minimalistic-linear" class="text-lg text-amber-600"></iconify-icon>
                                <span>Daftar Barang Dikeluarkan <span class="text-rose-500">*</span></span>
                            </label>
                            <button type="button" onclick="openOutboundProductPicker(null)" class="px-3.5 py-1.5 text-xs font-bold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 rounded-xl hover:bg-amber-100 flex items-center gap-1.5 shadow-xs transition-all">
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
                                        <th class="py-3 w-48">Catatan Item</th>
                                        <th class="py-3 pr-4 w-14 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="outItemsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                                    <!-- Dynamic Rows with Picker -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 py-4 px-6 border-t border-slate-100 dark:border-slate-700 shrink-0 bg-slate-50/50 dark:bg-slate-800/50">
                    <button type="button" onclick="closeItemOutModal()" class="px-5 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button type="submit" id="saveOutboundBtn" class="px-6 py-2.5 rounded-xl text-white font-bold bg-amber-600 hover:bg-amber-500 shadow-md shadow-amber-600/25 transition-all flex items-center gap-2">
                        <iconify-icon icon="solar:check-circle-bold" class="text-lg"></iconify-icon>
                        <span>Simpan Pengeluaran</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Modal Picker for Outbound (Dynamic Picker Engine) -->
    <div id="modal-outbound-product-picker" class="fixed inset-0 z-[100] items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;" onclick="closeOutboundProductPicker()">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-2xl w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700 relative z-10 max-h-[90vh] flex flex-col" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700 mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 flex items-center justify-center">
                        <iconify-icon icon="solar:box-minimalistic-bold" class="text-xl"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900 dark:text-white">Pilih Produk SKU (Outbound)</h3>
                        <p class="text-[11px] text-slate-400">Pilih dari katalog produk atau gunakan pencarian nama / kode SKU</p>
                    </div>
                </div>
                <button type="button" onclick="closeOutboundProductPicker()" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700">
                    <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                </button>
            </div>
            <div class="mb-4">
                <div class="relative">
                    <input type="text" id="search-outbound-product-picker" oninput="filterOutboundProductPicker(this.value)" class="w-full pl-9 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-amber-600 focus:outline-none text-slate-800 dark:text-slate-100" placeholder="Ketik kode SKU atau nama barang...">
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
                    <tbody id="tbody-outbound-product-picker" class="divide-y divide-slate-100 dark:divide-slate-700/60 bg-white dark:bg-slate-800">
                        <!-- Populated by JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detail Item Out -->
    <div id="itemOutDetailModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;" onclick="closeItemOutDetailModal()">
        <div class="bg-white dark:bg-slate-800 rounded-3xl w-full max-w-2xl max-h-[90vh] flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <h3 id="detailOutTitle" class="text-lg font-black text-slate-900 dark:text-white">Rincian Barang Keluar</h3>
                <button type="button" onclick="closeItemOutDetailModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div id="detailOutContent" class="p-6 md:p-8 overflow-y-auto flex-1 space-y-4 text-xs">
                <!-- Injected via JS -->
            </div>
            <div class="flex justify-end py-3.5 px-6 border-t border-slate-100 dark:border-slate-700 shrink-0 bg-slate-50/50 dark:bg-slate-800/50">
                <button type="button" onclick="closeItemOutDetailModal()" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-200 transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let cachedProducts = [];
        let itemOutsList = [];
        let activeOutboundRowId = null;

        async function initDependencies() {
            try {
                const prodRes = await axios.get('/api/products?per_page=100');
                cachedProducts = prodRes.data?.data?.data || prodRes.data?.data || [];
            } catch (e) {
                console.error('Error loading products for picker:', e);
            }
        }

        async function fetchItemOuts() {
            const tbody = document.getElementById('itemOutsTableBody');
            try {
                let res;
                try {
                    res = await axios.get('/api/inventory/item-outs');
                } catch (err404) {
                    try {
                        res = await axios.get('/api/internal/corporate/item-outs');
                    } catch (e2) {
                        res = await axios.get('/api/item-outs');
                    }
                }

                const data = res.data?.data?.data || res.data?.data || [];
                itemOutsList = data;

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Belum ada catatan pengeluaran barang keluar.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map((o, idx) => {
                    const totalQty = o.total_quantity || (o.details ? o.details.reduce((a, b) => a + (Number(b.quantity) || 0), 0) : 0);
                    return `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                            <td class="py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">${o.transaction_number || 'OUT-#' + o.id}</td>
                            <td class="py-3.5 font-mono text-slate-600 dark:text-slate-400">${o.reference_number || o.request_order?.order_number || o.waybill?.waybill_number || '-'}</td>
                            <td class="py-3.5 text-slate-500">${o.issue_date || (o.created_at ? new Date(o.created_at).toLocaleDateString('id-ID') : '-')}</td>
                            <td class="py-3.5 font-bold text-slate-800 dark:text-slate-200">${o.warehouse?.name || 'Gudang Pusat'}</td>
                            <td class="py-3.5 text-slate-600 dark:text-slate-300">${o.recipient_name || o.customer?.name || o.waybill?.request_order?.recipient_name || o.waybill?.request_order?.customer?.name || '-'}</td>
                            <td class="py-3.5 text-right font-black text-amber-600">${totalQty.toLocaleString('id-ID')} unit</td>
                            <td class="py-3.5 pr-6 text-right">
                                <button type="button" onclick="showItemOutDetail(${idx})" class="px-2.5 py-1 rounded-lg text-blue-600 bg-blue-50 dark:bg-blue-950/40 hover:bg-blue-100 font-bold transition-all">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');
            } catch (err) {
                console.error('Fetch item outs error:', err);
                tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Gagal memuat catatan barang keluar.</td></tr>`;
            }
        }

        function openItemOutModal() {
            document.getElementById('itemOutForm').reset();
            document.getElementById('outIssueDate').value = new Date().toISOString().split('T')[0];
            document.getElementById('outReferenceNumber').value = '';
            document.getElementById('outActionNotes').value = '';

            // Reset pickers
            const whH = document.getElementById('hidden-outWarehousePicker');
            const whD = document.getElementById('display-outWarehousePicker');
            if (whH) whH.value = '';
            if (whD) whD.value = '';

            const custH = document.getElementById('hidden-outCustomerPicker');
            const custD = document.getElementById('display-outCustomerPicker');
            if (custH) custH.value = '';
            if (custD) custD.value = '';

            document.getElementById('outItemsTableBody').innerHTML = '';
            addItemOutRow();
            document.getElementById('itemOutModal').style.display = 'flex';
        }

        function closeItemOutModal() {
            document.getElementById('itemOutModal').style.display = 'none';
            document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
        }

        function addItemOutRow(initialProdId = null) {
            const tbody = document.getElementById('outItemsTableBody');
            const rowId = 'outrow_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4);

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
                        <input type="text" readonly id="display-out-prod-${rowId}" value="${escapeHtml(displayText)}" placeholder="-- Klik untuk Pilih Produk SKU --" onclick="openOutboundProductPicker('${rowId}')" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-100 placeholder:text-slate-400 placeholder:font-normal cursor-pointer focus:ring-2 focus:ring-amber-600 focus:outline-none">
                        <input type="hidden" id="hidden-out-prod-${rowId}" class="out-product-hidden" value="${initialProdId || ''}">
                        <button type="button" onclick="openOutboundProductPicker('${rowId}')" title="Cari Produk SKU" class="px-2.5 py-2 bg-amber-600 hover:bg-amber-500 text-white rounded-xl flex items-center justify-center transition-colors shrink-0 shadow-xs">
                            <iconify-icon icon="solar:rounded-magnifer-linear" class="text-sm"></iconify-icon>
                        </button>
                    </div>
                </td>
                <td class="py-2.5 pr-2">
                    <input type="number" min="1" value="1" required class="out-qty-input w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-right font-bold focus:ring-2 focus:ring-amber-600 focus:outline-none" />
                </td>
                <td class="py-2.5 pr-2">
                    <input type="text" placeholder="Keterangan pengeluaran..." class="out-notes-input w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-amber-600 focus:outline-none" />
                </td>
                <td class="py-2.5 pr-3 text-center">
                    <button type="button" onclick="removeOutboundRow('${rowId}')" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors">
                        <iconify-icon icon="solar:trash-bin-trash-bold" class="text-base"></iconify-icon>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        }

        function removeOutboundRow(rowId) {
            const row = document.getElementById(rowId);
            if (row) row.remove();
        }

        // Product Modal Picker Logic
        function openOutboundProductPicker(rowId = null) {
            activeOutboundRowId = rowId;
            const searchEl = document.getElementById('search-outbound-product-picker');
            if (searchEl) searchEl.value = '';
            renderOutboundProductPickerList(cachedProducts);
            const modalEl = document.getElementById('modal-outbound-product-picker');
            if (modalEl) {
                modalEl.style.display = 'flex';
                setTimeout(() => searchEl && searchEl.focus(), 60);
            }
        }

        function closeOutboundProductPicker() {
            const modalEl = document.getElementById('modal-outbound-product-picker');
            if (modalEl) modalEl.style.display = 'none';
        }

        function filterOutboundProductPicker(query) {
            const q = String(query || '').trim().toLowerCase();
            const filtered = (cachedProducts || []).filter(p => {
                const sku = String(p.sku || p.code || '').toLowerCase();
                const name = String(p.name || '').toLowerCase();
                return !q || sku.includes(q) || name.includes(q);
            });
            renderOutboundProductPickerList(filtered);
        }

        function renderOutboundProductPickerList(list) {
            const tbody = document.getElementById('tbody-outbound-product-picker');
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
                    <tr class="hover:bg-amber-50/60 dark:hover:bg-slate-700/40 transition-colors cursor-pointer" onclick="selectOutboundProduct(${p.id})">
                        <td class="px-4 py-2.5 text-xs text-slate-400">${idx + 1}</td>
                        <td class="px-4 py-2.5 whitespace-nowrap text-xs font-mono font-bold text-slate-700 dark:text-slate-200">
                            <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700">${escapeHtml(sku)}</span>
                        </td>
                        <td class="px-4 py-2.5 text-xs font-bold text-slate-800 dark:text-slate-100">${escapeHtml(p.name)}</td>
                        <td class="px-4 py-2.5 text-xs text-slate-500">${escapeHtml(category)} <span class="text-slate-400">(${escapeHtml(uom)})</span></td>
                        <td class="px-4 py-2.5 text-end">
                            <button type="button" class="px-3 py-1.5 rounded-lg bg-amber-600 hover:bg-amber-500 text-white text-[11px] font-bold transition-all shadow-xs pointer-events-none">
                                Pilih
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function selectOutboundProduct(prodId) {
            const prod = cachedProducts.find(p => String(p.id) === String(prodId));
            if (!prod) return;

            const displayText = (prod.sku ? `[${prod.sku}] ` : '') + prod.name;

            if (activeOutboundRowId) {
                const disp = document.getElementById(`display-out-prod-${activeOutboundRowId}`);
                const hid = document.getElementById(`hidden-out-prod-${activeOutboundRowId}`);
                if (disp) disp.value = displayText;
                if (hid) hid.value = prod.id;
            } else {
                // If added from + Tambah Baris Produk
                const emptyRow = Array.from(document.querySelectorAll('#outItemsTableBody tr')).find(r => !r.querySelector('.out-product-hidden')?.value);
                if (emptyRow) {
                    const rowId = emptyRow.id;
                    const disp = document.getElementById(`display-out-prod-${rowId}`);
                    const hid = document.getElementById(`hidden-out-prod-${rowId}`);
                    if (disp) disp.value = displayText;
                    if (hid) hid.value = prod.id;
                } else {
                    addItemOutRow(prod.id);
                }
            }

            closeOutboundProductPicker();
        }

        async function saveItemOut(e) {
            e.preventDefault();
            const btn = document.getElementById('saveOutboundBtn');
            const rows = document.querySelectorAll('#outItemsTableBody tr');

            const warehouseId = document.getElementById('hidden-outWarehousePicker')?.value;
            const customerId = document.getElementById('hidden-outCustomerPicker')?.value;

            if (!warehouseId) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan pilih Gudang Asal terlebih dahulu.' });
                return;
            }

            if (!rows.length) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan tambahkan minimal 1 baris produk yang dikeluarkan.' });
                return;
            }

            const details = [];
            for (const r of rows) {
                const prodId = r.querySelector('.out-product-hidden')?.value;
                const qty = Number(r.querySelector('.out-qty-input')?.value);
                const notes = r.querySelector('.out-notes-input')?.value || null;

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
                    notes: notes
                });
            }

            const payload = {
                warehouse_id: Number(warehouseId),
                customer_id: customerId ? Number(customerId) : null,
                issue_date: document.getElementById('outIssueDate').value,
                reference_number: document.getElementById('outReferenceNumber').value || null,
                action_notes: document.getElementById('outActionNotes').value || null,
                details: details
            };

            btn.disabled = true;
            btn.innerHTML = '<div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div><span>Menyimpan...</span>';

            try {
                try {
                    await axios.post('/api/inventory/item-outs', payload);
                } catch (errPost) {
                    try {
                        await axios.post('/api/internal/corporate/item-outs', payload);
                    } catch (e2) {
                        await axios.post('/api/item-outs', payload);
                    }
                }
                closeItemOutModal();
                fetchItemOuts();
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Pengeluaran barang keluar berhasil dicatat dan saldo inventori telah dikurangkan!' });
            } catch (err) {
                console.error('Save item out error:', err);
                const msg = err.response?.data?.message || err.message || 'Terjadi kesalahan sistem saat menyimpan pengeluaran.';
                Swal.fire({ icon: 'error', title: 'Gagal Menyimpan', text: msg });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<iconify-icon icon="solar:check-circle-bold" class="text-lg"></iconify-icon><span>Simpan Pengeluaran</span>';
            }
        }

        function showItemOutDetail(idx) {
            const item = itemOutsList[idx];
            if (!item) return;

            document.getElementById('detailOutTitle').innerText = 'Rincian: ' + (item.transaction_number || 'OUT-#' + item.id);
            const content = document.getElementById('detailOutContent');

            const detailsHtml = (item.details || []).map(d => `
                <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-700 text-xs">
                    <div>
                        <div class="font-bold text-slate-800 dark:text-slate-100">${escapeHtml(d.product?.name || 'Produk ID #' + d.product_id)}</div>
                        <div class="text-[10px] text-slate-400 font-mono">${escapeHtml(d.product?.sku || '-')} ${d.notes ? '| ' + escapeHtml(d.notes) : ''}</div>
                    </div>
                    <div class="font-black text-amber-600 text-sm">${(d.quantity || 0).toLocaleString('id-ID')} unit</div>
                </div>
            `).join('') || '<div class="text-slate-400 italic">Tidak ada rincian item.</div>';

            content.innerHTML = `
                <div class="grid grid-cols-2 gap-3 pb-3 border-b border-slate-100 dark:border-slate-700 text-xs">
                    <div><span class="text-slate-400">Gudang Asal:</span> <strong class="text-slate-700 dark:text-slate-200 block mt-0.5">${escapeHtml(item.warehouse?.name || '-')}</strong></div>
                    <div><span class="text-slate-400">Pelanggan / Penerima:</span> <strong class="text-slate-700 dark:text-slate-200 block mt-0.5">${escapeHtml(item.recipient_name || item.customer?.name || item.waybill?.request_order?.recipient_name || item.waybill?.request_order?.customer?.name || '-')}</strong></div>
                    <div><span class="text-slate-400">Tanggal Keluar:</span> <strong class="text-slate-700 dark:text-slate-200 block mt-0.5">${item.issue_date || '-'}</strong></div>
                    <div><span class="text-slate-400">Ref. Dokumen / RO:</span> <strong class="text-slate-700 dark:text-slate-200 font-mono block mt-0.5">${escapeHtml(item.reference_number || '-')}</strong></div>
                    <div class="col-span-2"><span class="text-slate-400">Catatan Pengeluaran:</span> <strong class="text-slate-700 dark:text-slate-200 block mt-0.5">${escapeHtml(item.action_notes || '-')}</strong></div>
                </div>
                <div class="pt-2">
                    <h4 class="font-bold text-slate-700 dark:text-slate-300 mb-2">Item Barang Dikeluarkan:</h4>
                    <div class="space-y-1">
                        ${detailsHtml}
                    </div>
                </div>
            `;

            document.getElementById('itemOutDetailModal').style.display = 'flex';
        }

        function closeItemOutDetailModal() {
            document.getElementById('itemOutDetailModal').style.display = 'none';
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
            fetchItemOuts();
        });
    </script>
    @endpush
</x-layout.app>