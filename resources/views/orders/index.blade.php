<x-layout.app title="Pesanan Pelanggan & Mitra Distribusi (PO) | Corporate Portal">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Pesanan Pelanggan &amp; Mitra Distribusi (PO)
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Kelola Purchase Order masuk dari Pelanggan atau Mitra Distribusi, alokasi stok gudang, hingga impor ke Request Order (RO).
                </p>
            </div>
            <a href="/orders/create" class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2 self-start sm:self-auto">
                <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                <span>+ Buat Pesanan Pelanggan</span>
            </a>
        </div>

        <!-- Metric Summary Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Pesanan</div>
                <div id="statAll" class="text-2xl font-black text-slate-900 dark:text-white mt-1">0</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="text-[11px] font-bold uppercase tracking-wider text-amber-500">Draft</div>
                <div id="statDraft" class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1">0</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="text-[11px] font-bold uppercase tracking-wider text-blue-500">Terkonfirmasi (Siap RO)</div>
                <div id="statConfirmed" class="text-2xl font-black text-blue-600 dark:text-blue-400 mt-1">0</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="text-[11px] font-bold uppercase tracking-wider text-indigo-500">Dalam Pengiriman</div>
                <div id="statTransit" class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-1">0</div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm col-span-2 lg:col-span-1">
                <div class="text-[11px] font-bold uppercase tracking-wider text-emerald-500">Selesai Terkirim</div>
                <div id="statDelivered" class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">0</div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" onclick="setStatusFilter('all')" id="tab-all" class="status-tab px-3 py-1.5 rounded-xl text-xs font-bold transition-all bg-blue-600 text-white shadow-sm">Semua</button>
                <button type="button" onclick="setStatusFilter('draft')" id="tab-draft" class="status-tab px-3 py-1.5 rounded-xl text-xs font-bold transition-all bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">Draft</button>
                <button type="button" onclick="setStatusFilter('confirmed')" id="tab-confirmed" class="status-tab px-3 py-1.5 rounded-xl text-xs font-bold transition-all bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">Terkonfirmasi (Siap RO)</button>
                <button type="button" onclick="setStatusFilter('allocated_ro')" id="tab-allocated_ro" class="status-tab px-3 py-1.5 rounded-xl text-xs font-bold transition-all bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">Dialokasikan ke RO</button>
                <button type="button" onclick="setStatusFilter('in_transit')" id="tab-in_transit" class="status-tab px-3 py-1.5 rounded-xl text-xs font-bold transition-all bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">Dalam Pengiriman</button>
                <button type="button" onclick="setStatusFilter('delivered')" id="tab-delivered" class="status-tab px-3 py-1.5 rounded-xl text-xs font-bold transition-all bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">Selesai</button>
                <button type="button" onclick="setStatusFilter('cancelled')" id="tab-cancelled" class="status-tab px-3 py-1.5 rounded-xl text-xs font-bold transition-all bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">Dibatalkan</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div class="md:col-span-2">
                    <div class="relative">
                        <iconify-icon icon="solar:minimalistic-magnifer-linear" class="absolute left-3 top-2.5 text-slate-400 text-base"></iconify-icon>
                        <input type="text" id="orderSearch" oninput="debounceSearch()" placeholder="Cari nomor pesanan, no. PO pembeli, atau nama pelanggan..." class="w-full pl-9 pr-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                </div>
                <div>
                    <select id="customerTypeFilter" onchange="fetchOrders(1)" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold">
                        <option value="">Semua Tipe Pembeli</option>
                        <option value="customer">Pelanggan</option>
                        <option value="distributor">Mitra Distribusi</option>
                    </select>
                </div>
                <div>
                    <button type="button" onclick="fetchOrders(1)" class="w-full py-2 px-3 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-xs font-bold text-slate-700 dark:text-slate-200 transition-all flex items-center justify-center gap-1.5">
                        <iconify-icon icon="solar:refresh-bold" class="text-sm"></iconify-icon> Refresh Data
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">No. Pesanan &amp; PO</th>
                            <th class="py-3.5">Pelanggan / Mitra</th>
                            <th class="py-3.5">Gudang Asal</th>
                            <th class="py-3.5 text-right">Qty / Tonase</th>
                            <th class="py-3.5 text-right">Total Nilai</th>
                            <th class="py-3.5 text-center">Status &amp; Stok</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat data pesanan...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="ordersPagination" class="px-6 py-4 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between text-xs text-slate-500"></div>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentStatus = 'all';
        let currentPage = 1;
        let searchTimer = null;

        function debounceSearch() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => fetchOrders(1), 350);
        }

        function setStatusFilter(status) {
            currentStatus = status;
            document.querySelectorAll('.status-tab').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-sm');
                btn.classList.add('bg-slate-100', 'dark:bg-slate-700', 'text-slate-600', 'dark:text-slate-300');
            });
            const activeTab = document.getElementById('tab-' + status);
            if (activeTab) {
                activeTab.classList.remove('bg-slate-100', 'dark:bg-slate-700', 'text-slate-600', 'dark:text-slate-300');
                activeTab.classList.add('bg-blue-600', 'text-white', 'shadow-sm');
            }
            fetchOrders(1);
        }

        function renderStatusBadge(order) {
            const badges = {
                draft: '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800">Draft</span>',
                confirmed: '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-950/40 dark:text-blue-300 dark:border-blue-800">Terkonfirmasi</span>',
                allocated_ro: '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-300 dark:border-indigo-800">Terhubung ke RO</span>',
                in_transit: '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200 dark:bg-purple-950/40 dark:text-purple-300 dark:border-purple-800">Dalam Pengiriman</span>',
                delivered: '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800">Selesai Terkirim</span>',
                cancelled: '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-950/40 dark:text-rose-300 dark:border-rose-800">Dibatalkan</span>',
            };
            const stockTag = order.is_stock_reserved
                ? '<div class="text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 mt-1 flex items-center justify-center gap-1"><iconify-icon icon="solar:shield-check-bold"></iconify-icon>Stok Dialokasikan</div>'
                : (order.status === 'allocated_ro' || order.status === 'in_transit' || order.status === 'delivered'
                    ? '<div class="text-[10px] font-semibold text-indigo-600 dark:text-indigo-400 mt-1">Stok Tersinkronisasi</div>'
                    : '');
            return (badges[order.status] || order.status) + stockTag;
        }

        async function fetchOrders(page = 1) {
            currentPage = page;
            const tbody = document.getElementById('ordersTableBody');
            try {
                const res = await axios.get('/api/internal/orders', {
                    params: {
                        page: currentPage,
                        status: currentStatus,
                        customer_type: document.getElementById('customerTypeFilter')?.value || '',
                        search: document.getElementById('orderSearch')?.value || ''
                    }
                });

                const payload = res.data?.data || {};
                const rows = payload.data || [];
                const summary = payload.summary || {};

                document.getElementById('statAll').textContent = summary.all ?? 0;
                document.getElementById('statDraft').textContent = summary.draft ?? 0;
                document.getElementById('statConfirmed').textContent = summary.confirmed ?? 0;
                document.getElementById('statTransit').textContent = (summary.allocated_ro ?? 0) + (summary.in_transit ?? 0);
                document.getElementById('statDelivered').textContent = summary.delivered ?? 0;

                if (!rows.length) {
                    tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Belum ada pesanan pelanggan ditemukan. <a href="/orders/create" class="text-blue-600 font-bold hover:underline">Buat pesanan baru &rarr;</a></td></tr>`;
                    document.getElementById('ordersPagination').innerHTML = '';
                    return;
                }

                const offset = ((payload.current_page || 1) - 1) * (payload.per_page || 15);
                tbody.innerHTML = rows.map((o, idx) => {
                    const custBadge = o.customer_type === 'distributor'
                        ? '<span class="px-1.5 py-0.5 rounded bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300 text-[9px] font-bold">Mitra Distribusi</span>'
                        : '<span class="px-1.5 py-0.5 rounded bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 text-[9px] font-bold">Pelanggan</span>';

                    const roLink = o.request_order_id && o.request_order
                        ? `<a href="/request-orders/${o.request_order_id}" class="inline-flex items-center gap-1 text-[10px] font-mono font-bold text-indigo-600 dark:text-indigo-400 hover:underline mt-0.5"><iconify-icon icon="solar:routing-bold"></iconify-icon>${o.request_order.order_number}</a>`
                        : '';

                    let actionsHtml = `<a href="/orders/${o.id}" class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold hover:bg-slate-200 transition-all inline-flex items-center gap-1"><iconify-icon icon="solar:eye-bold"></iconify-icon> Detail</a>`;

                    if (o.status === 'draft') {
                        actionsHtml += `
                            <a href="/orders/create?edit_id=${o.id}" class="px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 font-bold hover:bg-amber-100 transition-all">Edit</a>
                            <button type="button" onclick="confirmOrder(${o.id}, '${o.order_number}')" class="px-2.5 py-1 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-500 transition-all">Konfirmasi</button>
                            <button type="button" onclick="deleteOrder(${o.id}, '${o.order_number}')" class="px-2 py-1 rounded-lg text-rose-500 hover:bg-rose-50 font-bold transition-all"><iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon></button>
                        `;
                    } else if (o.status === 'confirmed') {
                        actionsHtml += `
                            <a href="/request-orders/create?from_order_id=${o.id}" class="px-2.5 py-1 rounded-lg bg-emerald-600 text-white font-bold hover:bg-emerald-500 transition-all inline-flex items-center gap-1 shadow-sm">
                                <iconify-icon icon="solar:truck-bold"></iconify-icon> Impor ke RO
                            </a>
                            <button type="button" onclick="cancelOrder(${o.id}, '${o.order_number}')" class="px-2 py-1 rounded-lg text-rose-600 hover:bg-rose-50 font-bold transition-all">Batal</button>
                        `;
                    }

                    return `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="py-3.5 pl-6 font-bold text-slate-500">${offset + idx + 1}</td>
                            <td class="py-3.5">
                                <a href="/orders/${o.id}" class="font-mono font-bold text-blue-600 dark:text-blue-400 hover:underline">${o.order_number}</a>
                                ${o.customer_po_number ? `<div class="text-[10px] text-slate-500 font-mono">PO Pembeli: ${o.customer_po_number}</div>` : ''}
                                <div class="text-[10px] text-slate-400">${o.order_date || '-'}</div>
                                ${roLink}
                            </td>
                            <td class="py-3.5">
                                <div class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-1.5 flex-wrap">
                                    <span>${o.customer?.name || o.recipient_name}</span>
                                    ${custBadge}
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5">${o.destination_city_name || o.destination_city_code || '-'} &bull; ${o.recipient_phone || '-'}</div>
                            </td>
                            <td class="py-3.5">
                                <div class="font-semibold text-slate-700 dark:text-slate-300">${o.origin_warehouse?.name || '-'}</div>
                                <div class="text-[10px] text-slate-400 font-mono">${o.origin_warehouse?.code || ''}</div>
                            </td>
                            <td class="py-3.5 text-right">
                                <div class="font-bold text-slate-800 dark:text-slate-200">${Number(o.total_quantity || 0).toLocaleString('id-ID')} unit</div>
                                <div class="text-[10px] text-slate-400">${Number(o.total_weight_kg || 0).toLocaleString('id-ID')} kg</div>
                            </td>
                            <td class="py-3.5 text-right font-black text-slate-900 dark:text-white">
                                Rp ${Number(o.total_amount || 0).toLocaleString('id-ID')}
                            </td>
                            <td class="py-3.5 text-center">${renderStatusBadge(o)}</td>
                            <td class="py-3.5 pr-6 text-right">
                                <div class="inline-flex items-center justify-end gap-1.5 flex-wrap">${actionsHtml}</div>
                            </td>
                        </tr>
                    `;
                }).join('');

                renderPagination(payload);
            } catch (err) {
                console.error('Fetch orders error:', err);
                tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-rose-500">Gagal memuat daftar pesanan pelanggan.</td></tr>`;
            }
        }

        function renderPagination(meta) {
            const container = document.getElementById('ordersPagination');
            const total = meta.total || 0;
            const current = meta.current_page || 1;
            const last = meta.last_page || 1;
            container.innerHTML = `
                <span>Menampilkan halaman ${current} dari ${last} (Total ${total} pesanan)</span>
                <div class="inline-flex gap-1.5">
                    <button onclick="fetchOrders(${current - 1})" ${current <= 1 ? 'disabled' : ''} class="px-3 py-1 rounded-lg border border-slate-200 dark:border-slate-700 disabled:opacity-40 font-bold">Prev</button>
                    <button onclick="fetchOrders(${current + 1})" ${current >= last ? 'disabled' : ''} class="px-3 py-1 rounded-lg border border-slate-200 dark:border-slate-700 disabled:opacity-40 font-bold">Next</button>
                </div>
            `;
        }

        async function confirmOrder(id, orderNumber) {
            const res = await window.Alert.confirm(
                'Konfirmasi Pesanan?',
                `Konfirmasi pesanan ${orderNumber}? Sistem akan memvalidasi dan mengalokasikan (soft-reserve) stok barang di gudang asal.`
            );
            if (!res.isConfirmed) return;

            try {
                await axios.post(`/api/internal/orders/${id}/confirm`);
                window.Alert.toast(`Pesanan ${orderNumber} terkonfirmasi dan stok dialokasikan.`);
                fetchOrders(currentPage);
            } catch (err) {
                const msg = err.response?.data?.errors?.items?.[0] || err.response?.data?.message || 'Gagal mengonfirmasi pesanan.';
                window.Alert.error('Validasi Stok / Konfirmasi Gagal', msg);
            }
        }

        async function cancelOrder(id, orderNumber) {
            const res = await window.Alert.confirm(
                'Batalkan Pesanan?',
                `Batalkan pesanan ${orderNumber}? Alokasi stok yang dicadangkan akan dikembalikan ke gudang.`
            );
            if (!res.isConfirmed) return;

            try {
                await axios.post(`/api/internal/orders/${id}/cancel`);
                window.Alert.toast(`Pesanan ${orderNumber} telah dibatalkan.`);
                fetchOrders(currentPage);
            } catch (err) {
                window.Alert.error('Gagal', err.response?.data?.message || 'Gagal membatalkan pesanan.');
            }
        }

        async function deleteOrder(id, orderNumber) {
            const res = await window.Alert.confirm('Hapus Draft Pesanan?', `Yakin ingin menghapus ${orderNumber}?`);
            if (!res.isConfirmed) return;

            try {
                await axios.delete(`/api/internal/orders/${id}`);
                window.Alert.toast(`Pesanan ${orderNumber} berhasil dihapus.`);
                fetchOrders(currentPage);
            } catch (err) {
                window.Alert.error('Gagal', err.response?.data?.message || 'Gagal menghapus pesanan.');
            }
        }

        document.addEventListener('DOMContentLoaded', () => fetchOrders(1));
    </script>
    @endpush
</x-layout.app>
