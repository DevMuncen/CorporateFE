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
            <div class="flex flex-wrap items-center gap-2">
                <a href="/inventory/comparison" class="px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-500 shadow-sm transition-all flex items-center gap-1.5">
                    <iconify-icon icon="solar:chart-square-bold-duotone" class="text-base"></iconify-icon>
                    <span>Perbandingan &amp; Audit Stok &rarr;</span>
                </a>
                <a href="/inventory/item-ins" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all flex items-center gap-1.5 shadow-xs">
                    <iconify-icon icon="solar:import-bold-duotone" class="text-base text-emerald-600"></iconify-icon>
                    <span>Riwayat Masuk</span>
                </a>
                <a href="/inventory/item-outs" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all flex items-center gap-1.5 shadow-xs">
                    <iconify-icon icon="solar:export-bold-duotone" class="text-base text-amber-600"></iconify-icon>
                    <span>Riwayat Keluar</span>
                </a>
            </div>
        </div>

        <!-- Summary KPI Strip -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Baris SKU Gudang</div>
                <div id="kpiStockRows" class="text-2xl font-black text-slate-900 dark:text-white mt-1">0</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="text-[11px] font-bold uppercase tracking-wider text-blue-500">Total Stok Fisik</div>
                <div id="kpiPhysicalTotal" class="text-2xl font-black text-blue-600 dark:text-blue-400 mt-1">0 unit</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="text-[11px] font-bold uppercase tracking-wider text-amber-500">Teralokasi (PO/RO)</div>
                <div id="kpiAllocatedTotal" class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1">0 unit</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="text-[11px] font-bold uppercase tracking-wider text-emerald-500">Siap Pakai (Available)</div>
                <div class="flex items-baseline gap-2 mt-1">
                    <span id="kpiAvailableTotal" class="text-2xl font-black text-emerald-600 dark:text-emerald-400">0</span>
                    <span id="kpiLowCount" class="text-[11px] font-bold text-rose-500"></span>
                </div>
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
                            <th class="py-3.5 text-right">Teralokasi (PO/RO)</th>
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
            <div class="px-6 py-3.5 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                <span id="stocksPaginationInfo">Memuat...</span>
                <div id="stocksPaginationControls" class="flex items-center gap-1.5"></div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        let stockTimer = null;
        let currentStockPage = 1;
        function debounceFetchStocks() {
            clearTimeout(stockTimer);
            stockTimer = setTimeout(() => fetchStocks(1), 350);
        }

        async function fetchStocks(page = 1) {
            currentStockPage = page;
            const tbody = document.getElementById('stocksTableBody');
            const search = document.getElementById('stockSearch').value;
            const wh = document.getElementById('warehouseFilter').value;

            try {
                const res = await axios.get('/api/inventory/stocks', {
                    params: { search, warehouse_id: wh, page, per_page: 50 }
                });
                const paginator = res.data?.data;
                const data = Array.isArray(paginator) ? paginator : (paginator?.data || []);
                const meta = Array.isArray(paginator) ? null : paginator;
                const offset = meta ? ((meta.current_page || 1) - 1) * (meta.per_page || 50) : 0;

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Tidak ada data stok ditemukan.</td></tr>`;
                    document.getElementById('kpiStockRows').textContent = '0';
                    document.getElementById('kpiPhysicalTotal').textContent = '0 unit';
                    document.getElementById('kpiAllocatedTotal').textContent = '0 unit';
                    document.getElementById('kpiAvailableTotal').textContent = '0';
                    document.getElementById('kpiLowCount').textContent = '';
                    document.getElementById('stocksPaginationInfo').textContent = '0 data';
                    document.getElementById('stocksPaginationControls').innerHTML = '';
                    return;
                }

                let sumPhys = 0, sumAlloc = 0, sumAvail = 0, lowCount = 0;

                tbody.innerHTML = data.map((s, idx) => {
                    const phys = Number(s.quantity || 0);
                    const alloc = Number(s.reserved_quantity ?? s.allocated_quantity ?? 0);
                    const available = Math.max(0, phys - alloc);
                    const isLow = available <= (s.minimum_stock || 10);

                    sumPhys += phys;
                    sumAlloc += alloc;
                    sumAvail += available;
                    if (isLow) lowCount++;

                    return `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="py-3.5 pl-6 font-bold text-slate-500">${offset + idx + 1}</td>
                            <td class="py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">${s.product?.sku || s.product?.code || s.sku || '-'}</td>
                            <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${s.product?.name || s.product_name || 'Produk'}</td>
                            <td class="py-3.5 text-slate-600 dark:text-slate-300">${s.warehouse?.name || 'Gudang Pusat'}</td>
                            <td class="py-3.5 text-right font-semibold text-slate-800 dark:text-slate-200">${phys.toLocaleString('id-ID')} unit</td>
                            <td class="py-3.5 text-right text-amber-600 dark:text-amber-400 font-semibold">${alloc.toLocaleString('id-ID')} unit</td>
                            <td class="py-3.5 text-right font-black text-emerald-600 dark:text-emerald-400">${available.toLocaleString('id-ID')} unit</td>
                            <td class="py-3.5 pr-6 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${isLow ? 'bg-red-50 text-red-700 border border-red-200 dark:bg-red-950/50 dark:text-red-300 dark:border-red-800' : 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-emerald-800'}">
                                    ${isLow ? 'Stok Menipis' : 'Aman'}
                                </span>
                            </td>
                        </tr>
                    `;
                }).join('');

                document.getElementById('kpiStockRows').textContent = meta?.total ?? data.length;
                document.getElementById('kpiPhysicalTotal').textContent = sumPhys.toLocaleString('id-ID') + ' unit';
                document.getElementById('kpiAllocatedTotal').textContent = sumAlloc.toLocaleString('id-ID') + ' unit';
                document.getElementById('kpiAvailableTotal').textContent = sumAvail.toLocaleString('id-ID') + ' unit';
                document.getElementById('kpiLowCount').textContent = lowCount > 0 ? `(${lowCount} SKU menipis)` : '';

                const pInfo = document.getElementById('stocksPaginationInfo');
                const pCtrl = document.getElementById('stocksPaginationControls');
                if (meta && meta.last_page > 1) {
                    pInfo.textContent = `Halaman ${meta.current_page} dari ${meta.last_page} (${meta.total} baris)`;
                    pCtrl.innerHTML = `
                        <button type="button" ${meta.current_page <= 1 ? 'disabled' : ''} onclick="fetchStocks(${meta.current_page - 1})" class="px-2.5 py-1 rounded-lg border border-slate-200 dark:border-slate-700 disabled:opacity-40 hover:bg-slate-100 dark:hover:bg-slate-700">Prev</button>
                        <button type="button" ${meta.current_page >= meta.last_page ? 'disabled' : ''} onclick="fetchStocks(${meta.current_page + 1})" class="px-2.5 py-1 rounded-lg border border-slate-200 dark:border-slate-700 disabled:opacity-40 hover:bg-slate-100 dark:hover:bg-slate-700">Next</button>
                    `;
                } else {
                    pInfo.textContent = `Menampilkan ${data.length} baris stok`;
                    pCtrl.innerHTML = '';
                }
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
