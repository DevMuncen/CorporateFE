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
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full h-full max-w-full flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 flex items-center justify-center">
                        <iconify-icon icon="solar:import-bold-duotone" class="text-xl"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Catat Barang Masuk (Inbound)</h3>
                        <p class="text-xs text-slate-400">Penerimaan pasokan barang ke saldo inventori gudang</p>
                    </div>
                </div>
                <button type="button" onclick="closeItemInModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>

            <form id="itemInForm" onsubmit="saveItemIn(event)" class="flex flex-col flex-1 overflow-hidden text-xs">
                <div class="p-6 md:p-8 overflow-y-auto flex-1 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Gudang Penerima *</label>
                            <select id="inWarehouseId" required class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                                <option value="">Pilih Gudang...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Vendor / Pemasok (Opsional)</label>
                            <select id="inVendorId" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                                <option value="">Pilih Vendor / Pemasok...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Tanggal Penerimaan *</label>
                            <input type="date" id="inReceiptDate" required class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-emerald-600 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">No. Surat Jalan / PO Ref</label>
                            <input type="text" id="inReferenceNumber" placeholder="Contoh: SJ-2026/09/8812" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-emerald-600 focus:outline-none" />
                        </div>
                        <div class="col-span-full">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Catatan Penerimaan</label>
                            <input type="text" id="inActionNotes" placeholder="Catatan kondisi muatan, nomor kontainer, dll..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-emerald-600 focus:outline-none" />
                        </div>
                    </div>

                    <!-- Daftar Item Produk -->
                    <div class="pt-2">
                        <div class="flex items-center justify-between mb-3">
                            <label class="font-bold text-slate-700 dark:text-slate-200 text-sm flex items-center gap-2">
                                <iconify-icon icon="solar:box-minimalistic-linear" class="text-base text-emerald-600"></iconify-icon>
                                <span>Daftar Barang Diterima *</span>
                            </label>
                            <button type="button" onclick="addItemInRow()" class="px-3 py-1.5 text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-xl hover:bg-emerald-100 flex items-center gap-1.5 shadow-xs">
                                <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                                <span>+ Tambah Baris Produk</span>
                            </button>
                        </div>

                        <div class="border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-xs">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 text-slate-500 font-bold">
                                    <tr>
                                        <th class="py-3 pl-4">Produk / SKU *</th>
                                        <th class="py-3 w-40">Kuantitas *</th>
                                        <th class="py-3 w-48">Kondisi</th>
                                        <th class="py-3 pr-4 w-14 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="inItemsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                                    <!-- Dynamic Rows -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 py-3.5 px-6 border-t border-slate-100 dark:border-slate-700 shrink-0 bg-slate-50/50 dark:bg-slate-800/50">
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

    <!-- Modal Detail Item In -->
    <div id="itemInDetailModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;" onclick="closeItemInDetailModal()">
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full h-full max-w-full flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <h3 id="detailInTitle" class="text-lg font-bold text-slate-900 dark:text-white">Rincian Barang Masuk</h3>
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
        let cachedWarehouses = [];
        let cachedVendors = [];
        let itemInsList = [];

        async function initDependencies() {
            try {
                const [whRes, vendRes, prodRes] = await Promise.all([
                    axios.get('/api/warehouses'),
                    axios.get('/api/vendors'),
                    axios.get('/api/products')
                ]);

                cachedWarehouses = whRes.data?.data?.data || whRes.data?.data || [];
                cachedVendors = vendRes.data?.data?.data || vendRes.data?.data || [];
                cachedProducts = prodRes.data?.data?.data || prodRes.data?.data || [];

                // Populate warehouse dropdown
                const whSelect = document.getElementById('inWarehouseId');
                whSelect.innerHTML = '<option value="">Pilih Gudang...</option>' + 
                    cachedWarehouses.map(w => `<option value="${w.id}">${w.name} ${w.city ? '('+w.city+')' : ''}</option>`).join('');

                // Populate vendor dropdown
                const vendSelect = document.getElementById('inVendorId');
                vendSelect.innerHTML = '<option value="">Pilih Vendor / Pemasok...</option>' + 
                    cachedVendors.map(v => `<option value="${v.id}">${v.name}</option>`).join('');
            } catch (e) {
                console.error('Error loading item in dependencies:', e);
            }
        }

        async function fetchItemIns() {
            const tbody = document.getElementById('itemInsTableBody');
            try {
                const res = await axios.get('/api/inventory/item-ins');
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
            document.getElementById('inItemsTableBody').innerHTML = '';
            addItemInRow();
            document.getElementById('itemInModal').style.display = 'flex';
        }

        function closeItemInModal() {
            document.getElementById('itemInModal').style.display = 'none';
            document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
        }

        function addItemInRow() {
            const tbody = document.getElementById('inItemsTableBody');
            const rowId = 'row_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4);

            const productOptions = cachedProducts.map(p => 
                `<option value="${p.id}">${p.sku ? '['+p.sku+'] ' : ''}${p.name}</option>`
            ).join('');

            const tr = document.createElement('tr');
            tr.id = rowId;
            tr.innerHTML = `
                <td class="py-2 pl-3 pr-2">
                    <select required class="in-product-select w-full px-2 py-1.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-xs focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        <option value="">Pilih SKU / Produk...</option>
                        ${productOptions}
                    </select>
                </td>
                <td class="py-2 pr-2">
                    <input type="number" min="1" value="1" required class="in-qty-input w-full px-2 py-1.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-xs text-right font-bold focus:ring-1 focus:ring-emerald-600 focus:outline-none" />
                </td>
                <td class="py-2 pr-2">
                    <select class="in-condition-select w-full px-2 py-1.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-xs focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        <option value="good">Bagus (Good)</option>
                        <option value="damaged">Rusak (Damaged)</option>
                    </select>
                </td>
                <td class="py-2 pr-3 text-center">
                    <button type="button" onclick="document.getElementById('${rowId}').remove()" class="text-slate-400 hover:text-red-500">
                        <iconify-icon icon="solar:trash-bin-trash-bold" class="text-base"></iconify-icon>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        }

        async function saveItemIn(e) {
            e.preventDefault();
            const btn = document.getElementById('saveInboundBtn');
            const rows = document.querySelectorAll('#inItemsTableBody tr');

            if (!rows.length) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan tambahkan minimal 1 baris produk yang diterima.' });
                return;
            }

            const details = [];
            for (const r of rows) {
                const prodId = r.querySelector('.in-product-select').value;
                const qty = Number(r.querySelector('.in-qty-input').value);
                const cond = r.querySelector('.in-condition-select').value;

                if (!prodId) {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Mohon pilih produk untuk semua baris.' });
                    return;
                }
                if (!qty || qty <= 0) {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Kuantitas harus lebih dari 0.' });
                    return;
                }

                details.push({
                    product_id: Number(prodId),
                    quantity: qty,
                    condition: cond
                });
            }

            const payload = {
                warehouse_id: Number(document.getElementById('inWarehouseId').value),
                vendor_id: document.getElementById('inVendorId').value ? Number(document.getElementById('inVendorId').value) : null,
                receipt_date: document.getElementById('inReceiptDate').value,
                reference_number: document.getElementById('inReferenceNumber').value || null,
                action_notes: document.getElementById('inActionNotes').value || null,
                details: details
            };

            btn.disabled = true;
            btn.innerHTML = 'Menyimpan...';

            try {
                await axios.post('/api/inventory/item-ins', payload);
                closeItemInModal();
                fetchItemIns();
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Penerimaan barang berhasil dicatat dan saldo stok telah diperbarui!' });
            } catch (err) {
                console.error('Save item in error:', err);
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menyimpan penerimaan: ' + (err.response?.data?.message || err.message) });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon><span>Simpan Penerimaan</span>';
            }
        }

        function showItemInDetail(idx) {
            const item = itemInsList[idx];
            if (!item) return;

            document.getElementById('detailInTitle').innerText = 'Rincian: ' + (item.transaction_number || 'IN-#' + item.id);
            const content = document.getElementById('detailInContent');

            const detailsHtml = (item.details || []).map(d => `
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100 dark:border-slate-700 text-xs">
                    <div>
                        <div class="font-bold text-slate-800 dark:text-slate-100">${d.product?.name || 'Produk ID #' + d.product_id}</div>
                        <div class="text-[10px] text-slate-400 font-mono">${d.product?.sku || '-'} | Kondisi: <span class="capitalize">${d.condition || 'good'}</span></div>
                    </div>
                    <div class="font-black text-emerald-600 text-sm">${(d.quantity || 0).toLocaleString('id-ID')} unit</div>
                </div>
            `).join('') || '<div class="text-slate-400 italic">Tidak ada rincian item.</div>';

            content.innerHTML = `
                <div class="grid grid-cols-2 gap-2 pb-2 border-b border-slate-100 dark:border-slate-700 text-[11px]">
                    <div><span class="text-slate-400">Gudang:</span> <strong class="text-slate-700 dark:text-slate-200">${item.warehouse?.name || '-'}</strong></div>
                    <div><span class="text-slate-400">Tanggal:</span> <strong class="text-slate-700 dark:text-slate-200">${item.receipt_date || '-'}</strong></div>
                    <div><span class="text-slate-400">Vendor:</span> <strong class="text-slate-700 dark:text-slate-200">${item.vendor?.name || '-'}</strong></div>
                    <div><span class="text-slate-400">Ref. PO/SJ:</span> <strong class="text-slate-700 dark:text-slate-200 font-mono">${item.reference_number || '-'}</strong></div>
                </div>
                ${item.action_notes ? `<div class="text-[11px] text-slate-500 bg-slate-50 dark:bg-slate-900 p-2 rounded-lg italic">${item.action_notes}</div>` : ''}
                <div class="font-bold text-slate-700 dark:text-slate-300 pt-1">Daftar Produk:</div>
                <div class="max-h-48 overflow-y-auto space-y-1">
                    ${detailsHtml}
                </div>
            `;

            document.getElementById('itemInDetailModal').style.display = 'flex';
        }

        function closeItemInDetailModal() {
            document.getElementById('itemInDetailModal').style.display = 'none';
            document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
        }

        document.addEventListener('DOMContentLoaded', () => {
            initDependencies();
            fetchItemIns();
        });
    </script>
    @endpush
</x-layout.app>
