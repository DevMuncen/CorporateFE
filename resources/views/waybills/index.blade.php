<x-layout.app title="Surat Jalan & Waybill | Corporate Merchant Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Surat Jalan &amp; Waybill Logistik
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Pelacakan status armada transporter, dokumen surat jalan pengiriman, dan serah terima kargo
                </p>
            </div>
        </div>

        <!-- Filter bar -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 shadow-xs">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div class="relative sm:col-span-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <iconify-icon icon="solar:magnifer-linear" class="text-base"></iconify-icon>
                    </span>
                    <input type="text" id="wbSearch" oninput="debounceFetchWaybills()" placeholder="Cari No. Waybill, No. Polisi, Driver..."
                        class="w-full !pl-10 !ps-10 pr-4 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                </div>
                <div>
                    <select id="wbStatusFilter" onchange="fetchWaybills()" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="">Semua Status</option>
                        <option value="allocated">Allocated</option>
                        <option value="dispatched">Dispatched</option>
                        <option value="in_transit">In Transit</option>
                        <option value="arrived">Arrived</option>
                        <option value="delivered">Delivered</option>
                    </select>
                </div>
                <div>
                    <button type="button" onclick="fetchWaybills()" class="w-full py-2 px-3 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 text-xs font-bold text-slate-700 dark:text-slate-200 transition-all flex items-center justify-center gap-1.5">
                        <iconify-icon icon="solar:refresh-linear" class="text-base"></iconify-icon>
                        <span>Refresh Data</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Waybills Table Card -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">No. Waybill</th>
                            <th class="py-3.5">Ref. Request Order</th>
                            <th class="py-3.5">Transporter &amp; Armada</th>
                            <th class="py-3.5">Rute Pengiriman</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="waybillsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat surat jalan...</span>
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
        let wbTimer = null;
        function debounceFetchWaybills() {
            clearTimeout(wbTimer);
            wbTimer = setTimeout(fetchWaybills, 350);
        }

        async function fetchWaybills() {
            const tbody = document.getElementById('waybillsTableBody');
            const search = document.getElementById('wbSearch').value;
            const status = document.getElementById('wbStatusFilter').value;

            try {
                const res = await axios.get('/api/waybills', {
                    params: { search, status }
                });
                const data = res.data?.data?.data || res.data?.data || [];

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Belum ada surat jalan / waybill yang diterbitkan.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map((wb, idx) => {
                    const statusKey = (wb.status || 'draft').toLowerCase();
                    const statusClass = {
                        'draft': 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                        'confirmed': 'bg-amber-100 text-amber-700 dark:bg-amber-900/60 dark:text-amber-300',
                        'allocated': 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                        'dispatched': 'bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300',
                        'transit': 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300',
                        'in_transit': 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300',
                        'arrived': 'bg-purple-100 text-purple-700 dark:bg-purple-900/60 dark:text-purple-300',
                        'delivered': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300',
                        'finalized': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300'
                    }[statusKey] || 'bg-slate-100 text-slate-700';

                    const roId = wb.request_order_id || wb.request_order?.id;
                    const roNumber = wb.request_order?.order_number || wb.request_order?.ro_number || (roId ? 'RO-#' + roId : null);
                    const carrierName = wb.request_order?.logistic?.name || wb.vendor?.name || 'Muncen Logistics Carrier';
                    const origin = wb.origin_city_name || wb.origin_warehouse?.name || wb.origin_city || 'Origin';
                    const destination = wb.destination_city_name || wb.destination_address || wb.destination_city || 'Tujuan';

                    return `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                            <td class="py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">
                                <a href="/waybills/${wb.id}" class="hover:underline">${wb.waybill_number || 'WB-#' + wb.id}</a>
                                <div class="text-[10px] text-slate-400 font-sans font-normal">${wb.created_at ? new Date(wb.created_at).toLocaleDateString('id-ID') : 'Hari ini'}</div>
                            </td>
                            <td class="py-3.5 font-mono">
                                ${roNumber && roId ? `
                                    <a href="/request-orders/${roId}" class="inline-flex items-center gap-1 text-[11px] font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/60 px-2 py-0.5 rounded border border-indigo-200 dark:border-indigo-800 hover:underline">
                                        <iconify-icon icon="solar:document-bold" class="text-xs"></iconify-icon>
                                        <span>${roNumber}</span>
                                    </a>
                                ` : '<span class="text-slate-400 text-xs">-</span>'}
                            </td>
                            <td class="py-3.5 text-slate-700 dark:text-slate-300">
                                <div class="font-bold text-xs">${carrierName}</div>
                                <div class="text-[10px] text-slate-400">${wb.plate_number || wb.request_order?.fleet_type?.name || 'Armada Dedicated'}</div>
                            </td>
                            <td class="py-3.5 text-slate-600 dark:text-slate-300 text-xs">
                                <span>${origin}</span> &rarr; <span class="font-bold text-slate-800 dark:text-slate-100">${destination}</span>
                            </td>
                            <td class="py-3.5 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider ${statusClass}">
                                    ${wb.status || 'Draft'}
                                </span>
                            </td>
                            <td class="py-3.5 pr-6 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="/waybills/${wb.id}" class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-slate-700 text-blue-600 dark:text-blue-400 font-bold hover:bg-blue-100 transition-all text-xs">
                                        Lacak
                                    </a>
                                    <a href="/waybills/${wb.id}/print" target="_blank" class="p-1 rounded-lg text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 transition-all" title="Cetak Surat Jalan">
                                        <iconify-icon icon="solar:printer-bold" class="text-base"></iconify-icon>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');
            } catch (err) {
                console.error('Fetch waybills error:', err);
                tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Gagal memuat waybill.</td></tr>`;
            }
        }

        document.addEventListener('DOMContentLoaded', fetchWaybills);
    </script>
    @endpush
</x-layout.app>
