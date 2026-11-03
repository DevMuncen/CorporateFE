<x-layout.app title="Detail Request Order | Corporate Merchant Portal">
    <div class="space-y-6 max-w-5xl mx-auto" id="roDetailContainer">

        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="/request-orders" class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors inline-flex items-center gap-1 mb-1">
                    <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                    <span>Kembali ke Daftar Request Order</span>
                </a>
                <div class="flex items-center gap-3">
                    <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white" id="roNumberTitle">
                        Detail Request Order
                    </h1>
                    <span id="roStatusBadge" class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
                        Memuat...
                    </span>
                </div>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Rincian pesanan pemuatan, gudang asal, rute langsung, muatan kargo, dan estimasi biaya
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="window.print()" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all flex items-center gap-1.5 shadow-xs">
                    <iconify-icon icon="solar:printer-bold-duotone" class="text-base text-blue-600"></iconify-icon>
                    <span>Cetak PO / RO</span>
                </button>
            </div>
        </div>

        <!-- Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Pemuatan & Jadwal -->
            <div class="p-5 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xs space-y-3">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider">
                    <iconify-icon icon="solar:calendar-date-bold-duotone" class="text-base text-blue-600"></iconify-icon>
                    <span>Jadwal &amp; Info Pengiriman</span>
                </div>
                <div class="space-y-1.5 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tanggal Order:</span>
                        <span id="roOrderDate" class="font-bold text-slate-800 dark:text-slate-200">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Jadwal Muat:</span>
                        <span id="roDepartureDate" class="font-bold text-slate-800 dark:text-slate-200">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Layanan:</span>
                        <span id="roServiceType" class="font-bold text-blue-600 dark:text-blue-400">FTL Direct Route</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Mitra Logistik:</span>
                        <span id="roLogistic" class="font-bold text-slate-800 dark:text-slate-200">-</span>
                    </div>
                </div>
            </div>

            <!-- Gudang Asal (Origin) -->
            <div class="p-5 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xs space-y-3">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider">
                    <iconify-icon icon="solar:warehouse-bold-duotone" class="text-base text-blue-600"></iconify-icon>
                    <span>Gudang Asal (Origin)</span>
                </div>
                <div class="space-y-1 text-xs">
                    <h4 id="roOriginName" class="font-black text-slate-900 dark:text-white">-</h4>
                    <p id="roOriginCity" class="text-slate-600 dark:text-slate-400 font-semibold">-</p>
                    <p id="roOriginAddress" class="text-slate-500 leading-relaxed text-[11px]">-</p>
                    <p id="roOriginContact" class="text-slate-600 dark:text-slate-300 font-mono text-[11px] pt-1">-</p>
                </div>
            </div>

            <!-- Biaya & Muatan -->
            <div class="p-5 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xs space-y-3">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider">
                    <iconify-icon icon="solar:wallet-money-bold-duotone" class="text-base text-emerald-600"></iconify-icon>
                    <span>Ringkasan Tarif &amp; Muatan</span>
                </div>
                <div class="space-y-1.5 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Total Berat:</span>
                        <span id="roTotalWeight" class="font-bold text-slate-800 dark:text-slate-200">0 kg</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Jumlah SKU:</span>
                        <span id="roItemCount" class="font-bold text-slate-800 dark:text-slate-200">0 item</span>
                    </div>
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-700 flex justify-between items-center">
                        <span class="text-slate-700 dark:text-slate-300 font-bold">Total Tarif:</span>
                        <span id="roTotalCost" class="text-base font-black text-blue-600 dark:text-blue-400">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tujuan Drop Point Langsung (Direct Destination) -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <h3 class="text-sm font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:routing-2-bold-duotone" class="text-lg text-blue-600"></iconify-icon>
                    <span>Titik Penurunan Kargo (Direct Delivery Points)</span>
                </h3>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300">
                    Direct Point-to-Point
                </span>
            </div>

            <div id="destinationsContainer" class="space-y-3">
                <!-- Drop points rendered here -->
            </div>
        </div>

        <!-- Tabel Barang Muatan (Items) -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="text-sm font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="text-lg text-blue-600"></iconify-icon>
                    <span>Daftar Barang &amp; SKU Muatan</span>
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 uppercase font-bold">
                            <th class="py-3 pl-6 w-12">No</th>
                            <th class="py-3">Kode SKU</th>
                            <th class="py-3">Nama Produk</th>
                            <th class="py-3 text-center">Jumlah (Qty)</th>
                            <th class="py-3 text-right">Harga Satuan</th>
                            <th class="py-3 pr-6 text-right">Subtotal Nilai</th>
                        </tr>
                    </thead>
                    <tbody id="roItemsBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Memuat rincian barang...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Waybill Terkait (Jika Sudah Diterbitkan Logistik) -->
        <div id="waybillSection" class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-xs hidden space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <div>
                    <h3 class="text-sm font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <iconify-icon icon="solar:document-text-bold-duotone" class="text-lg text-indigo-600"></iconify-icon>
                        <span>Surat Jalan &amp; Resi Pengiriman (Waybills)</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar Surat Jalan yang diterbitkan carrier untuk pengiriman kargo order ini</p>
                </div>
                <span id="waybillCountBadge" class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">0 Waybill</span>
            </div>
            <div id="waybillsListContainer" class="space-y-2.5"></div>
        </div>

    </div>

    @push('scripts')
    <script>
        const roId = {{ $id }};

        async function fetchRODetail() {
            try {
                const res = await axios.get(`/api/request-orders/${roId}`);
                const ro = res.data?.data || {};

                // Header
                document.getElementById('roNumberTitle').innerText = ro.order_number || ro.ro_number || `RO-#${ro.id}`;
                
                const statusClass = {
                    'draft': 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                    'submitted': 'bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300',
                    'approved': 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300',
                    'confirmed': 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300',
                    'processed': 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300',
                    'dispatched': 'bg-amber-100 text-amber-700 dark:bg-amber-900/60 dark:text-amber-300',
                    'in_transit': 'bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300',
                    'delivered': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300',
                    'completed': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300',
                    'cancelled': 'bg-red-100 text-red-700 dark:bg-red-900/60 dark:text-red-300'
                }[ro.status?.toLowerCase()] || 'bg-slate-100 text-slate-700';

                const statusBadge = document.getElementById('roStatusBadge');
                statusBadge.className = `px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider ${statusClass}`;
                statusBadge.innerText = ro.status || 'Draft';

                // Schedule
                document.getElementById('roOrderDate').innerText = ro.order_date || (ro.created_at ? new Date(ro.created_at).toLocaleDateString('id-ID') : '-');
                document.getElementById('roDepartureDate').innerText = ro.departure_date ? new Date(ro.departure_date).toLocaleString('id-ID') : (ro.order_date ? new Date(ro.order_date).toLocaleDateString('id-ID') : '-');
                const fleetName = ro.fleet_type?.name || ro.service_type || 'FTL';
                document.getElementById('roServiceType').innerText = `${fleetName} (Direct Route)`;
                document.getElementById('roLogistic').innerText = ro.logistic?.name || 'Muncen Logistics';

                // Origin
                const originWh = ro.origin_warehouse || ro.originWarehouse || {};
                document.getElementById('roOriginName').innerText = originWh.name || ro.sender_name || 'Gudang Utama';
                const originCity = originWh.city || ro.origin_city_name || ro.origin_city?.name || '-';
                document.getElementById('roOriginCity').innerText = originCity;
                document.getElementById('roOriginAddress').innerText = originWh.address || ro.origin_address || ro.sender_address || 'Alamat Gudang Asal';
                const picName = ro.sender_name || originWh.pic_name || '-';
                const picPhone = ro.sender_phone || originWh.phone || '-';
                document.getElementById('roOriginContact').innerText = (picName !== '-' || picPhone !== '-') ? `PIC: ${picName} (${picPhone})` : 'PIC: -';

                // Summary
                const totalWeight = parseFloat(ro.total_weight || ro.total_weight_kg || 0);
                document.getElementById('roTotalWeight').innerText = `${totalWeight.toLocaleString('id-ID')} kg`;
                
                // Extract items - checking both ro.items and ro.delivery_points
                let items = Array.isArray(ro.items) && ro.items.length > 0 ? ro.items : [];
                if (items.length === 0 && Array.isArray(ro.delivery_points)) {
                    ro.delivery_points.forEach(dp => {
                        if (Array.isArray(dp.items)) {
                            dp.items.forEach(it => {
                                items.push({
                                    ...it,
                                    recipient_name: dp.recipient_name,
                                    delivery_address: dp.address
                                });
                            });
                        }
                    });
                }
                document.getElementById('roItemCount').innerText = `${items.length} item`;
                
                const cost = parseFloat(ro.estimated_cost || ro.total_cost || ro.snapshot_pricing?.total_estimated_cost || 0);
                document.getElementById('roTotalCost').innerText = `Rp ${cost.toLocaleString('id-ID')}`;

                // Delivery Points / Destinations
                const destContainer = document.getElementById('destinationsContainer');
                const destinations = ro.destinations || ro.delivery_points || [];

                if (destinations.length > 0) {
                    destContainer.innerHTML = destinations.map((d, idx) => {
                        const cityName = d.destination_city || d.city_name || d.city || (d.city_code === ro.destination_city_code ? ro.destination_city_name : null) || ro.destination_city_name || '';
                        const address = d.address || d.delivery_address || ro.destination_address || '';
                        const cityAndAddress = cityName ? `<span class="font-bold text-slate-700 dark:text-slate-300">${cityName}</span> &bull; ${address}` : address;

                        return `
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-600 text-white">Drop #${d.stop_sequence || idx + 1}</span>
                                        <h4 class="font-bold text-slate-900 dark:text-white">${d.recipient_name || ro.recipient_name || 'Toko Mitra'}</h4>
                                    </div>
                                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">${cityAndAddress}</p>
                                </div>
                                <div class="text-slate-500 font-mono text-[11px] whitespace-nowrap">
                                    Telp: ${d.recipient_phone || ro.recipient_phone || '-'}
                                </div>
                            </div>
                        `;
                    }).join('');
                } else {
                    const destCity = ro.destination_city_name || ro.destination_city?.name || ro.destination_city || 'Kota Tujuan';
                    destContainer.innerHTML = `
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-xs text-slate-500">
                            <strong>Tujuan Langsung:</strong> ${destCity} - ${ro.destination_address || 'Alamat Tujuan'}
                        </div>
                    `;
                }

                // Items Table
                const itemsBody = document.getElementById('roItemsBody');
                if (items.length > 0) {
                    itemsBody.innerHTML = items.map((it, idx) => {
                        const prod = it.product || {};
                        const sku = prod.code || prod.sku || it.product_sku || it.sku || '-';
                        const name = prod.name || it.product_name || (it.product_id ? `Produk #${it.product_id}` : 'Barang SKU');
                        const qty = parseFloat(it.quantity || it.qty || 1);
                        const unitPrice = parseFloat(it.unit_price) > 0 ? parseFloat(it.unit_price) : (parseFloat(prod.default_price || prod.base_price || prod.price || 0));
                        const subtotal = parseFloat(it.total_price) > 0 ? parseFloat(it.total_price) : (qty * unitPrice);

                        return `
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="py-3 pl-6 font-bold text-slate-500">${idx + 1}</td>
                                <td class="py-3 font-mono font-bold text-blue-600 dark:text-blue-400">
                                    <span class="px-2 py-0.5 rounded bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 font-mono text-[11px] font-bold">${sku}</span>
                                </td>
                                <td class="py-3 font-semibold text-slate-800 dark:text-slate-200">${name}</td>
                                <td class="py-3 text-center font-bold text-slate-900 dark:text-slate-100">${qty.toLocaleString('id-ID')}</td>
                                <td class="py-3 text-right text-slate-600 dark:text-slate-300 font-mono">Rp ${unitPrice.toLocaleString('id-ID')}</td>
                                <td class="py-3 pr-6 text-right font-black text-slate-900 dark:text-slate-100 font-mono">Rp ${subtotal.toLocaleString('id-ID')}</td>
                            </tr>
                        `;
                    }).join('');
                } else {
                    itemsBody.innerHTML = `<tr><td colspan="6" class="py-6 text-center text-slate-400">Tidak ada rincian item barang.</td></tr>`;
                }

                // Waybills
                const waybills = ro.waybills || (ro.waybill ? [ro.waybill] : []);
                const wbSection = document.getElementById('waybillSection');
                if (waybills.length > 0) {
                    wbSection.classList.remove('hidden');
                    const badgeEl = document.getElementById('waybillCountBadge');
                    if (badgeEl) badgeEl.innerText = `${waybills.length} Waybill Terbit`;
                    const wbListEl = document.getElementById('waybillsListContainer');
                    if (wbListEl) {
                        wbListEl.innerHTML = waybills.map((wb, idx) => {
                            const statusKey = (wb.status || 'draft').toLowerCase();
                            const statusClass = {
                                'draft': 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                                'confirmed': 'bg-amber-100 text-amber-700 dark:bg-amber-900/60 dark:text-amber-300',
                                'transit': 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300',
                                'in_transit': 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300',
                                'delivered': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300',
                                'finalized': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300'
                            }[statusKey] || 'bg-slate-100 text-slate-700';

                            const dest = wb.destination_address || `Titik Drop #${wb.delivery_point_sequence || idx + 1}`;
                            const awbNum = wb.waybill_number || `AWB-${wb.id}`;

                            return `
                                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono font-bold text-sm text-blue-600 dark:text-blue-400">${awbNum}</span>
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider ${statusClass}">${wb.status || 'Draft'}</span>
                                        </div>
                                        <p class="text-slate-600 dark:text-slate-400">
                                            <span class="font-medium text-slate-500">Tujuan Drop:</span> ${dest}
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <a href="/waybills/${wb.id}" class="px-3 py-1.5 rounded-xl text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-500 shadow-xs transition-all inline-flex items-center gap-1.5">
                                            <span>Lacak Resi</span>
                                            <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
                                        </a>
                                        <a href="/waybills/${wb.id}/print" target="_blank" class="p-1.5 rounded-xl text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 transition-all" title="Cetak Surat Jalan">
                                            <iconify-icon icon="solar:printer-bold" class="text-base text-blue-600"></iconify-icon>
                                        </a>
                                    </div>
                                </div>
                            `;
                        }).join('');
                    }
                } else {
                    wbSection.classList.add('hidden');
                }

            } catch (err) {
                console.error('Fetch RO detail error:', err);
                document.getElementById('roDetailContainer').innerHTML = `
                    <div class="p-12 text-center text-slate-400 bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700">
                        <iconify-icon icon="solar:danger-triangle-bold" class="text-4xl text-amber-500 mb-2"></iconify-icon>
                        <h3 class="font-bold text-slate-800 dark:text-white">Gagal Memuat Detail Request Order</h3>
                        <p class="text-xs text-slate-500 mt-1">${err.response?.data?.message || err.message}</p>
                        <a href="/request-orders" class="mt-4 inline-block px-4 py-2 rounded-xl text-xs font-bold bg-blue-600 text-white">Kembali ke Daftar RO</a>
                    </div>
                `;
            }
        }

        document.addEventListener('DOMContentLoaded', fetchRODetail);
    </script>
    @endpush
</x-layout.app>
