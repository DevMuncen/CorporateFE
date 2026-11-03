<x-layout.app title="Monitoring Stok Multi-Gudang | Corporate Merchant Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Monitoring Stok Multi-Gudang
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Visibilitas saldo inventori real-time per gudang hub, kuota teralokasi, dan stok siap kirim
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="/inventory/item-ins" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all flex items-center gap-1.5 shadow-xs">
                    <iconify-icon icon="solar:import-bold-duotone" class="text-base text-emerald-600"></iconify-icon>
                    <span>Riwayat Masuk (Inbound)</span>
                </a>
                <a href="/inventory/item-outs" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all flex items-center gap-1.5 shadow-xs">
                    <iconify-icon icon="solar:export-bold-duotone" class="text-base text-amber-600"></iconify-icon>
                    <span>Riwayat Keluar (Outbound)</span>
                </a>
            </div>
        </div>

        <!-- Filter bar -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 shadow-xs">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="relative sm:col-span-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <iconify-icon icon="solar:magnifer-linear" class="text-base"></iconify-icon>
                    </span>
                    <input type="text" id="stockSearch" oninput="debounceFetchStocks()" placeholder="Cari nama barang atau kode SKU..."
                        class="w-full !pl-10 !ps-10 pr-4 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                </div>
                <div>
                    <select id="warehouseFilter" onchange="fetchStocks()" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="">Semua Lokasi Gudang</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Stocks Table Card -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">Kode SKU</th>
                            <th class="py-3.5">Nama Produk</th>
                            <th class="py-3.5">Lokasi Gudang</th>
                            <th class="py-3.5 text-right">Stok Fisik</th>
                            <th class="py-3.5 text-right">Teralokasi (RO)</th>
                            <th class="py-3.5 text-right">Stok Tersedia</th>
                            <th class="py-3.5 pr-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="stocksTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat data saldo stok...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        let stockTimer = null;
        function debounceFetchStocks() {
            clearTimeout(stockTimer);
            stockTimer = setTimeout(fetchStocks, 350);
        }

        async function fetchStocks() {
            const tbody = document.getElementById('stocksTableBody');
            const search = document.getElementById('stockSearch').value;
            const wh = document.getElementById('warehouseFilter').value;

            try {
                const res = await axios.get('/api/inventory/stocks', {
                    params: { search, warehouse_id: wh }
                });
                const data = res.data?.data?.data || res.data?.data || [];

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Tidak ada data stok ditemukan.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map((s, idx) => {
                    const available = (s.quantity || 0) - (s.allocated_quantity || 0);
                    const isLow = available <= (s.minimum_stock || 10);

                    return `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                            <td class="py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">${s.product?.sku || s.sku || '-'}</td>
                            <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${s.product?.name || s.product_name || 'Produk'}</td>
                            <td class="py-3.5 text-slate-600 dark:text-slate-300">${s.warehouse?.name || 'Gudang Pusat'}</td>
                            <td class="py-3.5 text-right font-semibold text-slate-800 dark:text-slate-200">${(s.quantity || 0).toLocaleString('id-ID')} unit</td>
                            <td class="py-3.5 text-right text-amber-600 dark:text-amber-400 font-semibold">${(s.allocated_quantity || 0).toLocaleString('id-ID')} unit</td>
                            <td class="py-3.5 text-right font-black text-emerald-600 dark:text-emerald-400">${available.toLocaleString('id-ID')} unit</td>
                            <td class="py-3.5 pr-6 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${isLow ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-emerald-50 text-emerald-700'}">
                                    ${isLow ? 'Stok Menipis' : 'Aman'}
                                </span>
                            </td>
                        </tr>
                    `;
                }).join('');
            } catch (err) {
                console.error('Fetch stocks error:', err);
                tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Gagal memuat saldo stok.</td></tr>`;
            }
        }

        async function fetchWarehousesFilter() {
            try {
                const res = await axios.get('/api/warehouses');
                const list = res.data?.data?.data || res.data?.data || [];
                const sel = document.getElementById('warehouseFilter');
                list.forEach(w => {
                    const opt = document.createElement('option');
                    opt.value = w.id;
                    opt.textContent = w.name + (w.city ? ` (${w.city})` : '');
                    sel.appendChild(opt);
                });
            } catch (e) {
                console.error('Fetch warehouses error:', e);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchWarehousesFilter();
            fetchStocks();
        });
    </script>
    @endpush
</x-layout.app>
