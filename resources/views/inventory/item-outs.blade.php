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
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full h-full max-w-full flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 flex items-center justify-center">
                        <iconify-icon icon="solar:export-bold-duotone" class="text-xl"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Catat Barang Keluar (Outbound)</h3>
                        <p class="text-xs text-slate-400">Pengurangan saldo stok gudang untuk pesanan / pengiriman</p>
                    </div>
                </div>
                <button type="button" onclick="closeItemOutModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>

            <form id="itemOutForm" onsubmit="saveItemOut(event)" class="flex flex-col flex-1 overflow-hidden text-xs">
                <div class="p-6 md:p-8 overflow-y-auto flex-1 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Gudang Asal *</label>
                            <select id="outWarehouseId" required class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-amber-600 focus:outline-none">
                                <option value="">Pilih Gudang Asal...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Pelanggan / Penerima (Opsional)</label>
                            <select id="outCustomerId" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-amber-600 focus:outline-none">
                                <option value="">Pilih Pelanggan / Customer...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Tanggal Keluar *</label>
                            <input type="date" id="outIssueDate" required class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-amber-600 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">No. Ref Surat Jalan / RO Ref</label>
                            <input type="text" id="outReferenceNumber" placeholder="Contoh: RO-20261020-001 / SJ-091" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-amber-600 focus:outline-none" />
                        </div>
                        <div class="col-span-full">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Catatan Pengeluaran</label>
                            <input type="text" id="outActionNotes" placeholder="Catatan armada jemput, supir, tujuan, dll..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-amber-600 focus:outline-none" />
                        </div>
                    </div>

                    <!-- Daftar Item Produk -->
                    <div class="pt-2">
                        <div class="flex items-center justify-between mb-3">
                            <label class="font-bold text-slate-700 dark:text-slate-200 text-sm flex items-center gap-2">
                                <iconify-icon icon="solar:box-minimalistic-linear" class="text-base text-amber-600"></iconify-icon>
                                <span>Daftar Barang Dikeluarkan *</span>
                            </label>
                            <button type="button" onclick="addItemOutRow()" class="px-3 py-1.5 text-xs font-bold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 rounded-xl hover:bg-amber-100 flex items-center gap-1.5 shadow-xs">
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
                                        <th class="py-3 w-48">Catatan Item</th>
                                        <th class="py-3 pr-4 w-14 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="outItemsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                                    <!-- Dynamic Rows -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 py-3.5 px-6 border-t border-slate-100 dark:border-slate-700 shrink-0 bg-slate-50/50 dark:bg-slate-800/50">
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

    <!-- Modal Detail Item Out -->
    <div id="itemOutDetailModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;" onclick="closeItemOutDetailModal()">
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full h-full max-w-full flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <h3 id="detailOutTitle" class="text-lg font-bold text-slate-900 dark:text-white">Rincian Barang Keluar</h3>
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
        let cachedWarehouses = [];
        let cachedCustomers = [];
        let itemOutsList = [];

        async function initDependencies() {
            try {
                const [whRes, custRes, prodRes] = await Promise.all([
                    axios.get('/api/warehouses'),
                    axios.get('/api/customers'),
                    axios.get('/api/products')
                ]);

                cachedWarehouses = whRes.data?.data?.data || whRes.data?.data || [];
                cachedCustomers = custRes.data?.data?.data || custRes.data?.data || [];
                cachedProducts = prodRes.data?.data?.data || prodRes.data?.data || [];

                // Populate warehouse dropdown
                const whSelect = document.getElementById('outWarehouseId');
                whSelect.innerHTML = '<option value="">Pilih Gudang Asal...</option>' + 
                    cachedWarehouses.map(w => `<option value="${w.id}">${w.name} ${w.city ? '('+w.city+')' : ''}</option>`).join('');

                // Populate customer dropdown
                const custSelect = document.getElementById('outCustomerId');
                custSelect.innerHTML = '<option value="">Pilih Pelanggan / Customer...</option>' + 
                    cachedCustomers.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
            } catch (e) {
                console.error('Error loading item out dependencies:', e);
            }
        }

        async function fetchItemOuts() {
            const tbody = document.getElementById('itemOutsTableBody');
            try {
                const res = await axios.get('/api/inventory/item-outs');
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
                            <td class="py-3.5 text-slate-600 dark:text-slate-300">${o.customer?.name || '-'}</td>
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
            document.getElementById('outItemsTableBody').innerHTML = '';
            addItemOutRow();
            document.getElementById('itemOutModal').style.display = 'flex';
        }

        function closeItemOutModal() {
            document.getElementById('itemOutModal').style.display = 'none';
            document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
        }

        function addItemOutRow() {
            const tbody = document.getElementById('outItemsTableBody');
            const rowId = 'row_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4);

            const productOptions = cachedProducts.map(p => 
                `<option value="${p.id}">${p.sku ? '['+p.sku+'] ' : ''}${p.name}</option>`
            ).join('');

            const tr = document.createElement('tr');
            tr.id = rowId;
            tr.innerHTML = `
                <td class="py-2 pl-3 pr-2">
                    <select required class="out-product-select w-full px-2 py-1.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-xs focus:ring-1 focus:ring-amber-600 focus:outline-none">
                        <option value="">Pilih SKU / Produk...</option>
                        ${productOptions}
                    </select>
                </td>
                <td class="py-2 pr-2">
                    <input type="number" min="1" value="1" required class="out-qty-input w-full px-2 py-1.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-xs text-right font-bold focus:ring-1 focus:ring-amber-600 focus:outline-none" />
                </td>
                <td class="py-2 pr-2">
                    <input type="text" placeholder="Keterangan..." class="out-notes-input w-full px-2 py-1.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-xs focus:ring-1 focus:ring-amber-600 focus:outline-none" />
                </td>
                <td class="py-2 pr-3 text-center">
                    <button type="button" onclick="document.getElementById('${rowId}').remove()" class="text-slate-400 hover:text-red-500">
                        <iconify-icon icon="solar:trash-bin-trash-bold" class="text-base"></iconify-icon>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        }

        async function saveItemOut(e) {
            e.preventDefault();
            const btn = document.getElementById('saveOutboundBtn');
            const rows = document.querySelectorAll('#outItemsTableBody tr');

            if (!rows.length) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan tambahkan minimal 1 baris produk yang dikeluarkan.' });
                return;
            }

            const details = [];
            for (const r of rows) {
                const prodId = r.querySelector('.out-product-select').value;
                const qty = Number(r.querySelector('.out-qty-input').value);
                const notes = r.querySelector('.out-notes-input').value;

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
                    notes: notes || null
                });
            }

            const payload = {
                warehouse_id: Number(document.getElementById('outWarehouseId').value),
                customer_id: document.getElementById('outCustomerId').value ? Number(document.getElementById('outCustomerId').value) : null,
                issue_date: document.getElementById('outIssueDate').value,
                reference_number: document.getElementById('outReferenceNumber').value || null,
                action_notes: document.getElementById('outActionNotes').value || null,
                details: details
            };

            btn.disabled = true;
            btn.innerHTML = 'Menyimpan...';

            try {
                await axios.post('/api/inventory/item-outs', payload);
                closeItemOutModal();
                fetchItemOuts();
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Pengeluaran barang berhasil dicatat dan saldo stok telah dikurangkan!' });
            } catch (err) {
                console.error('Save item out error:', err);
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menyimpan pengeluaran: ' + (err.response?.data?.message || err.message) });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon><span>Simpan Pengeluaran</span>';
            }
        }

        function showItemOutDetail(idx) {
            const item = itemOutsList[idx];
            if (!item) return;

            document.getElementById('detailOutTitle').innerText = 'Rincian: ' + (item.transaction_number || 'OUT-#' + item.id);
            const content = document.getElementById('detailOutContent');

            const detailsHtml = (item.details || []).map(d => `
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100 dark:border-slate-700 text-xs">
                    <div>
                        <div class="font-bold text-slate-800 dark:text-slate-100">${d.product?.name || 'Produk ID #' + d.product_id}</div>
                        <div class="text-[10px] text-slate-400 font-mono">${d.product?.sku || '-'} ${d.notes ? '| ' + d.notes : ''}</div>
                    </div>
                    <div class="font-black text-amber-600 text-sm">${(d.quantity || 0).toLocaleString('id-ID')} unit</div>
                </div>
            `).join('') || '<div class="text-slate-400 italic">Tidak ada rincian item.</div>';

            content.innerHTML = `
                <div class="grid grid-cols-2 gap-2 pb-2 border-b border-slate-100 dark:border-slate-700 text-[11px]">
                    <div><span class="text-slate-400">Gudang Asal:</span> <strong class="text-slate-700 dark:text-slate-200">${item.warehouse?.name || '-'}</strong></div>
                    <div><span class="text-slate-400">Tanggal:</span> <strong class="text-slate-700 dark:text-slate-200">${item.issue_date || '-'}</strong></div>
                    <div><span class="text-slate-400">Pelanggan:</span> <strong class="text-slate-700 dark:text-slate-200">${item.customer?.name || '-'}</strong></div>
                    <div><span class="text-slate-400">Ref. Dokumen:</span> <strong class="text-slate-700 dark:text-slate-200 font-mono">${item.reference_number || '-'}</strong></div>
                </div>
                ${item.action_notes ? `<div class="text-[11px] text-slate-500 bg-slate-50 dark:bg-slate-900 p-2 rounded-lg italic">${item.action_notes}</div>` : ''}
                <div class="font-bold text-slate-700 dark:text-slate-300 pt-1">Daftar Produk:</div>
                <div class="max-h-48 overflow-y-auto space-y-1">
                    ${detailsHtml}
                </div>
            `;

            document.getElementById('itemOutDetailModal').style.display = 'flex';
        }

        function closeItemOutDetailModal() {
            document.getElementById('itemOutDetailModal').style.display = 'none';
            document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
        }

        document.addEventListener('DOMContentLoaded', () => {
            initDependencies();
            fetchItemOuts();
        });
    </script>
    @endpush
</x-layout.app>
