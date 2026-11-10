<x-layout.app title="Perbandingan & Audit Stok | Corporate Merchant Portal">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="/inventory/stocks" class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors inline-flex items-center gap-1 mb-1">
                    <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                    <span>Kembali ke Saldo Stok</span>
                </a>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Perbandingan Stok, Kebutuhan PO &amp; Audit Mutasi
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Bandingkan kapasitas stok gudang korporasi &amp; mitra distribusi terhadap permintaan Purchase Order (PO) serta rekonsiliasi saldo ledger.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="/inventory/item-ins" class="px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-500 shadow-sm transition-all flex items-center gap-1.5">
                    <iconify-icon icon="solar:import-bold"></iconify-icon>
                    <span>+ Catat Inbound Restock</span>
                </a>
                <button type="button" onclick="fetchComparison()" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all flex items-center gap-1.5">
                    <iconify-icon icon="solar:refresh-bold"></iconify-icon>
                    <span>Refresh</span>
                </button>
            </div>
        </div>

        <!-- KPI Strip -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total SKU Aktif</div>
                <div id="compKpiSkus" class="text-2xl font-black text-slate-900 dark:text-white mt-1">0</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="text-[11px] font-bold uppercase tracking-wider text-blue-500">Stok Tersedia (Net)</div>
                <div id="compKpiAvailable" class="text-2xl font-black text-blue-600 dark:text-blue-400 mt-1">0</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="text-[11px] font-bold uppercase tracking-wider text-amber-500">Kebutuhan PO (Draft)</div>
                <div id="compKpiDraftDemand" class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1">0</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="text-[11px] font-bold uppercase tracking-wider text-rose-500">SKU Defisit (Kurang)</div>
                <div id="compKpiShortage" class="text-2xl font-black text-rose-600 dark:text-rose-400 mt-1">0</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs col-span-2 lg:col-span-1">
                <div class="text-[11px] font-bold uppercase tracking-wider text-indigo-500">Selisih Audit Ledger</div>
                <div id="compKpiLedgerDiff" class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-1">0</div>
            </div>
        </div>

        <!-- Tabs + Filters -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 shadow-xs space-y-4">
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" onclick="switchTab('demand')" id="tabBtn-demand" class="comp-tab px-4 py-2 rounded-xl text-xs font-bold transition-all bg-blue-600 text-white shadow-sm">
                    1. Kebutuhan PO vs Stok Gudang
                </button>
                <button type="button" onclick="switchTab('matrix')" id="tabBtn-matrix" class="comp-tab px-4 py-2 rounded-xl text-xs font-bold transition-all bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                    2. Matriks Lintas Gudang &amp; Distributor
                </button>
                <button type="button" onclick="switchTab('ledger')" id="tabBtn-ledger" class="comp-tab px-4 py-2 rounded-xl text-xs font-bold transition-all bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                    3. Rekonsiliasi Mutasi Ledger
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="relative sm:col-span-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <iconify-icon icon="solar:magnifer-linear" class="text-base"></iconify-icon>
                    </span>
                    <input type="text" id="compSearch" oninput="debounceComparison()" placeholder="Cari kode SKU atau nama barang..." class="w-full !pl-10 !ps-10 pr-4 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                </div>
                <div>
                    <select id="compWarehouseFilter" onchange="fetchComparison()" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold">
                        <option value="">Semua Gudang Korporasi</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- TAB 1: Demand vs Supply -->
        <div id="tabPanel-demand" class="comp-panel bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">SKU &amp; Nama Produk</th>
                            <th class="py-3.5 text-right">Stok Fisik</th>
                            <th class="py-3.5 text-right">Teralokasi (PO Confirmed)</th>
                            <th class="py-3.5 text-right">Stok Tersedia</th>
                            <th class="py-3.5 text-right">Permintaan PO (Draft)</th>
                            <th class="py-3.5 text-right">Selisih Netto</th>
                            <th class="py-3.5 text-center">Status Kecukupan</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="demandTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr><td colspan="9" class="py-12 text-center text-slate-400">Memuat data perbandingan stok...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 2: Cross-Warehouse & Distributor Matrix -->
        <div id="tabPanel-matrix" class="comp-panel hidden bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead id="matrixTableHead"></thead>
                    <tbody id="matrixTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50"></tbody>
                </table>
            </div>
        </div>

        <!-- TAB 3: Ledger Reconciliation -->
        <div id="tabPanel-ledger" class="comp-panel hidden bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">SKU &amp; Nama Produk</th>
                            <th class="py-3.5 text-right">Total Masuk (Inbound)</th>
                            <th class="py-3.5 text-right">Total Keluar (Outbound)</th>
                            <th class="py-3.5 text-right">Saldo Ledger (In - Out)</th>
                            <th class="py-3.5 text-right">Stok Fisik Sistem</th>
                            <th class="py-3.5 text-right">Selisih Audit</th>
                            <th class="py-3.5 pr-6 text-center">Status Rekonsiliasi</th>
                        </tr>
                    </thead>
                    <tbody id="ledgerTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50"></tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let compData = null;
        let compTimer = null;
        let warehousesPopulated = false;

        function debounceComparison() {
            clearTimeout(compTimer);
            compTimer = setTimeout(fetchComparison, 350);
        }

        function switchTab(tab) {
            document.querySelectorAll('.comp-panel').forEach(p => p.classList.add('hidden'));
            document.querySelectorAll('.comp-tab').forEach(b => {
                b.classList.remove('bg-blue-600', 'text-white', 'shadow-sm');
                b.classList.add('bg-slate-100', 'dark:bg-slate-700', 'text-slate-600', 'dark:text-slate-300');
            });

            document.getElementById('tabPanel-' + tab)?.classList.remove('hidden');
            const activeBtn = document.getElementById('tabBtn-' + tab);
            if (activeBtn) {
                activeBtn.classList.remove('bg-slate-100', 'dark:bg-slate-700', 'text-slate-600', 'dark:text-slate-300');
                activeBtn.classList.add('bg-blue-600', 'text-white', 'shadow-sm');
            }
        }

        async function fetchComparison() {
            const search = document.getElementById('compSearch')?.value || '';
            const warehouseId = document.getElementById('compWarehouseFilter')?.value || '';

            try {
                const res = await axios.get('/api/internal/inventory/comparison', {
                    params: { search, warehouse_id: warehouseId }
                });
                compData = res.data?.data;
                if (!compData) return;

                if (!warehousesPopulated && Array.isArray(compData.warehouses)) {
                    const sel = document.getElementById('compWarehouseFilter');
                    compData.warehouses.forEach(w => {
                        const opt = document.createElement('option');
                        opt.value = w.id;
                        opt.textContent = `${w.name} (${w.code})`;
                        sel.appendChild(opt);
                    });
                    warehousesPopulated = true;
                }

                const s = compData.summary || {};
                document.getElementById('compKpiSkus').textContent = s.total_skus ?? 0;
                document.getElementById('compKpiAvailable').textContent = Number(s.total_available_units ?? 0).toLocaleString('id-ID');
                document.getElementById('compKpiDraftDemand').textContent = Number(s.total_draft_po_demand ?? 0).toLocaleString('id-ID');
                document.getElementById('compKpiShortage').textContent = s.shortage_sku_count ?? 0;
                document.getElementById('compKpiLedgerDiff').textContent = s.ledger_discrepancy_count ?? 0;

                renderDemandTable(compData.demand_vs_supply || []);
                renderMatrixTable(compData.warehouses || [], compData.distributors || [], compData.cross_warehouse_matrix || []);
                renderLedgerTable(compData.demand_vs_supply || []);
            } catch (err) {
                console.error('Fetch comparison error:', err);
                window.Alert.error('Error', 'Gagal memuat analisis perbandingan stok.');
            }
        }

        function renderDemandTable(rows) {
            const tbody = document.getElementById('demandTableBody');
            if (!rows.length) {
                tbody.innerHTML = '<tr><td colspan="9" class="py-12 text-center text-slate-400">Tidak ada data produk ditemukan.</td></tr>';
                return;
            }
            tbody.innerHTML = rows.map((r, idx) => {
                let badge = '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Surplus / Aman</span>';
                if (r.status === 'deficit') {
                    badge = '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Defisit (Perlu Restock)</span>';
                } else if (r.status === 'tight') {
                    badge = '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">Stok Ketat</span>';
                }

                const netCls = r.net_surplus_deficit < 0 ? 'text-rose-600 font-black' : 'text-emerald-600 font-bold';
                const netSign = r.net_surplus_deficit > 0 ? '+' : '';

                return `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                        <td class="py-3.5">
                            <div class="font-bold text-slate-800 dark:text-slate-100">${r.product_name}</div>
                            <div class="text-[10px] font-mono text-blue-600 dark:text-blue-400">${r.sku} &bull; ${r.uom}</div>
                        </td>
                        <td class="py-3.5 text-right font-semibold text-slate-700 dark:text-slate-300">${Number(r.physical_qty).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 text-right font-semibold text-amber-600">${Number(r.reserved_qty).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 text-right font-black text-blue-600 dark:text-blue-400">${Number(r.available_qty).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 text-right font-semibold text-purple-600 dark:text-purple-400">${Number(r.draft_po_demand).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 text-right ${netCls}">${netSign}${Number(r.net_surplus_deficit).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 text-center">${badge}</td>
                        <td class="py-3.5 pr-6 text-right">
                            <a href="/inventory/item-ins" class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold border border-emerald-200 text-[11px] inline-flex items-center gap-1">
                                <iconify-icon icon="solar:import-bold"></iconify-icon> Restock
                            </a>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function renderMatrixTable(warehouses, distributors, rows) {
            const thead = document.getElementById('matrixTableHead');
            const tbody = document.getElementById('matrixTableBody');

            const whHeaders = warehouses.map(w => `<th class="py-3.5 px-3 text-right bg-blue-50/50 dark:bg-blue-950/30">${w.name}<div class="text-[9px] font-mono text-blue-500">${w.code}</div></th>`).join('');
            const distHeaders = distributors.map(d => `<th class="py-3.5 px-3 text-right bg-purple-50/50 dark:bg-purple-950/30">${d.name}<div class="text-[9px] font-mono text-purple-500">Distributor</div></th>`).join('');

            thead.innerHTML = `
                <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                    <th class="py-3.5 pl-6 w-12">No</th>
                    <th class="py-3.5 min-w-[200px]">SKU &amp; Nama Produk</th>
                    ${whHeaders}
                    ${distHeaders}
                    <th class="py-3.5 pr-6 text-right">Total Jaringan</th>
                </tr>
            `;

            if (!rows.length) {
                tbody.innerHTML = `<tr><td colspan="${3 + warehouses.length + distributors.length}" class="py-12 text-center text-slate-400">Tidak ada data produk ditemukan.</td></tr>`;
                return;
            }

            tbody.innerHTML = rows.map((r, idx) => {
                const whCells = warehouses.map(w => {
                    const cell = r.corporate_warehouses[String(w.id)] || { physical: 0, reserved: 0, available: 0 };
                    const cls = cell.available <= 0 ? 'text-rose-500' : 'text-slate-800 dark:text-slate-200';
                    return `
                        <td class="py-3.5 px-3 text-right">
                            <div class="font-bold ${cls}">${Number(cell.physical).toLocaleString('id-ID')}</div>
                            ${cell.reserved > 0 ? `<div class="text-[9px] text-amber-600">(${cell.reserved} PO resv)</div>` : ''}
                        </td>
                    `;
                }).join('');

                const distCells = distributors.map(d => {
                    const qty = r.distributor_warehouses[String(d.id)] ?? 0;
                    return `<td class="py-3.5 px-3 text-right font-semibold text-purple-700 dark:text-purple-300">${Number(qty).toLocaleString('id-ID')}</td>`;
                }).join('');

                return `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                        <td class="py-3.5">
                            <div class="font-bold text-slate-800 dark:text-slate-100">${r.product_name}</div>
                            <div class="text-[10px] font-mono text-blue-600">${r.sku} &bull; ${r.uom}</div>
                        </td>
                        ${whCells}
                        ${distCells}
                        <td class="py-3.5 pr-6 text-right font-black text-slate-900 dark:text-white">${Number(r.total_network_stock).toLocaleString('id-ID')}</td>
                    </tr>
                `;
            }).join('');
        }

        function renderLedgerTable(rows) {
            const tbody = document.getElementById('ledgerTableBody');
            if (!rows.length) {
                tbody.innerHTML = '<tr><td colspan="8" class="py-12 text-center text-slate-400">Tidak ada data produk ditemukan.</td></tr>';
                return;
            }
            tbody.innerHTML = rows.map((r, idx) => {
                const isMatch = Math.abs(r.ledger_diff) < 0.01;
                const badge = isMatch
                    ? '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Cocok (Match)</span>'
                    : '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Selisih Ledger</span>';

                return `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                        <td class="py-3.5">
                            <div class="font-bold text-slate-800 dark:text-slate-100">${r.product_name}</div>
                            <div class="text-[10px] font-mono text-blue-600">${r.sku}</div>
                        </td>
                        <td class="py-3.5 text-right font-semibold text-emerald-600">+${Number(r.inbound_total).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 text-right font-semibold text-amber-600">-${Number(r.outbound_total).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 text-right font-bold text-slate-700 dark:text-slate-300">${Number(r.ledger_expected).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 text-right font-black text-blue-600 dark:text-blue-400">${Number(r.physical_qty).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 text-right font-mono font-bold ${isMatch ? 'text-slate-400' : 'text-rose-600'}">${r.ledger_diff > 0 ? '+' : ''}${Number(r.ledger_diff).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 pr-6 text-center">${badge}</td>
                    </tr>
                `;
            }).join('');
        }

        document.addEventListener('DOMContentLoaded', fetchComparison);
    </script>
    @endpush
</x-layout.app>
