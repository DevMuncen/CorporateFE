<x-layout.app title="Daftar Request Order (RO) | Corporate Merchant Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Permintaan Pengiriman (Request Order)
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Order dispatch pengiriman langsung (direct route), konsolidasi muatan, dan monitoring status pengiriman
                </p>
            </div>
            <a href="/request-orders/create" class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2 self-start sm:self-auto">
                <iconify-icon icon="solar:cart-plus-bold-duotone" class="text-lg"></iconify-icon>
                <span>+ Buat Request Order (RO)</span>
            </a>
        </div>

        <!-- Filter bar -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 shadow-xs">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div class="relative sm:col-span-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <iconify-icon icon="solar:magnifer-linear" class="text-base"></iconify-icon>
                    </span>
                    <input type="text" id="roSearch" oninput="debounceFetchROs()" placeholder="Cari No. RO, Gudang Asal, Penerima..."
                        class="w-full !pl-10 !ps-10 pr-4 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                </div>
                <div>
                    <select id="roStatusFilter" onchange="fetchRequestOrders()" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="">Semua Status</option>
                        <option value="draft">Draft</option>
                        <option value="submitted">Submitted</option>
                        <option value="approved">Approved</option>
                        <option value="confirmed">Confirmed (Diterima Hub)</option>
                        <option value="dispatched">Dispatched</option>
                        <option value="in_transit">In Transit</option>
                        <option value="delivered">Delivered / Selesai</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div>
                    <button type="button" onclick="fetchRequestOrders()" class="w-full py-2 px-3 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-xs font-bold text-slate-700 dark:text-slate-200 transition-all flex items-center justify-center gap-1.5">
                        <iconify-icon icon="solar:refresh-linear" class="text-base"></iconify-icon>
                        <span>Refresh Data</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- RO Table Card -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">No. RO</th>
                            <th class="py-3.5">Tanggal</th>
                            <th class="py-3.5">Gudang Asal</th>
                            <th class="py-3.5">Tujuan / Drop Points</th>
                            <th class="py-3.5 text-right">Muatan &amp; Berat</th>
                            <th class="py-3.5 text-right">Estimasi Tarif</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="rosTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat data request order...</span>
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
        let searchTimer = null;
        function debounceFetchROs() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(fetchRequestOrders, 350);
        }

        async function fetchRequestOrders() {
            const tbody = document.getElementById('rosTableBody');
            const search = document.getElementById('roSearch').value;
            const status = document.getElementById('roStatusFilter').value;

            try {
                const res = await axios.get('/api/request-orders', {
                    params: { search, status }
                });
                const raw = res.data?.data;
                const data = Array.isArray(raw) ? raw : (raw?.data || []);

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="9" class="py-12 text-center text-slate-400">Tidak ada request order ditemukan. <a href="/request-orders/create" class="text-blue-600 font-bold hover:underline">Buat RO sekarang &rarr;</a></td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map((ro, idx) => {
                    const statusClass = {
                        'draft': 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                        'submitted': 'bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300',
                        'approved': 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300',
                        'confirmed': 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300',
                        'dispatched': 'bg-amber-100 text-amber-700 dark:bg-amber-900/60 dark:text-amber-300',
                        'in_transit': 'bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300',
                        'delivered': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300',
                        'completed': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300',
                        'processed': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300',
                        'cancelled': 'bg-red-100 text-red-700 dark:bg-red-900/60 dark:text-red-300'
                    }[ro.status?.toLowerCase()] || 'bg-slate-100 text-slate-700';

                    const dropsCount = ro.destinations?.length || ro.delivery_points?.length || 1;
                    const dateFormatted = ro.order_date ? new Date(ro.order_date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : (ro.created_at ? new Date(ro.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-');
                    const destinationLabel = ro.destination_city_name || ro.destination_city || ro.recipient_name || (ro.delivery_points?.[0]?.recipient_name) || 'Kota Tujuan';
                    const warehouseLabel = ro.origin_warehouse?.name || ro.origin_warehouse_name || 'Gudang Utama';
                    const totalWeight = parseFloat(ro.total_weight_kg || ro.total_weight || 0);
                    const totalCost = parseFloat(ro.estimated_cost || ro.total_cost || 0);
                    const itemsCount = ro.items?.length || (ro.delivery_points?.[0]?.items?.length || 1);

                    return `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                            <td class="py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">${ro.order_number || ro.ro_number || 'RO-#' + ro.id}</td>
                            <td class="py-3.5 text-slate-500">${dateFormatted}</td>
                            <td class="py-3.5 font-medium text-slate-800 dark:text-slate-200">${warehouseLabel}</td>
                            <td class="py-3.5 text-slate-600 dark:text-slate-300">
                                <span class="font-bold text-slate-800 dark:text-slate-100">${destinationLabel}</span>
                                ${dropsCount > 1 ? `<span class="ml-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-purple-100 text-purple-700">+${dropsCount - 1} drop</span>` : ''}
                            </td>
                            <td class="py-3.5 text-right font-medium text-slate-700 dark:text-slate-300">
                                <div>${totalWeight} kg</div>
                                <div class="text-[10px] text-slate-400">${itemsCount} SKU barang</div>
                            </td>
                            <td class="py-3.5 text-right font-bold text-slate-800 dark:text-slate-200">
                                Rp ${totalCost.toLocaleString('id-ID')}
                            </td>
                            <td class="py-3.5 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider ${statusClass}">
                                    ${ro.status || 'Draft'}
                                </span>
                            </td>
                            <td class="py-3.5 pr-6 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    ${(ro.status || '').toLowerCase() === 'draft' ? `
                                        <button type="button" onclick="quickSubmitRO(${ro.id})" class="px-2 py-1 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 font-bold transition-all text-xs flex items-center gap-1" title="Ajukan ke Logistik">
                                            <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                            <span class="hidden md:inline">Ajukan</span>
                                        </button>
                                        <button type="button" onclick="quickDeleteDraft(${ro.id})" class="p-1 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all text-xs" title="Hapus Draft">
                                            <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                        </button>
                                    ` : ''}
                                    ${(ro.status || '').toLowerCase() === 'submitted' ? `
                                        <button type="button" onclick="quickWithdrawRO(${ro.id})" class="px-2 py-1 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold transition-all text-xs flex items-center gap-1" title="Tarik Kembali ke Draft">
                                            <iconify-icon icon="solar:restart-bold"></iconify-icon>
                                            <span class="hidden md:inline">Tarik</span>
                                        </button>
                                    ` : ''}
                                    <a href="/request-orders/${ro.id}" class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-slate-700 text-blue-600 dark:text-blue-400 font-bold hover:bg-blue-100 transition-all">
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');
            } catch (err) {
                console.error('Fetch ROs error:', err);
                tbody.innerHTML = `<tr><td colspan="9" class="py-12 text-center text-slate-400">Gagal memuat request order.</td></tr>`;
            }
        }

        async function quickSubmitRO(id) {
            const confirm = await Swal.fire({
                title: 'Ajukan ke Logistik?',
                text: 'Order akan diteruskan ke mitra logistik untuk dialokasikan armada truk & driver.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ajukan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#053363'
            });
            if (!confirm.isConfirmed) return;

            try {
                await axios.post(`/api/request-orders/${id}/submit`);
                Swal.fire({ icon: 'success', title: 'Berhasil Diajukan', text: 'RO telah diteruskan ke logistik.', confirmButtonColor: '#053363' });
                fetchRequestOrders();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: err.response?.data?.message || 'Gagal mengajukan RO.', confirmButtonColor: '#053363' });
            }
        }

        async function quickWithdrawRO(id) {
            const confirm = await Swal.fire({
                title: 'Tarik ke Draft?',
                text: 'Pesanan akan kembali berstatus Draft sehingga dapat diubah.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tarik',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d97706'
            });
            if (!confirm.isConfirmed) return;

            try {
                await axios.post(`/api/request-orders/${id}/withdraw`);
                Swal.fire({ icon: 'success', title: 'Berhasil Ditarik', text: 'RO kembali menjadi draft.', confirmButtonColor: '#053363' });
                fetchRequestOrders();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: err.response?.data?.message || 'Gagal menarik RO.', confirmButtonColor: '#053363' });
            }
        }

        async function quickDeleteDraft(id) {
            const confirm = await Swal.fire({
                title: 'Hapus Draft?',
                text: 'Data draft pemesanan dan alokasi stok akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626'
            });
            if (!confirm.isConfirmed) return;

            try {
                await axios.delete(`/api/request-orders/${id}`);
                Swal.fire({ icon: 'success', title: 'Dihapus', text: 'Draft berhasil dihapus.', confirmButtonColor: '#053363' });
                fetchRequestOrders();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: err.response?.data?.message || 'Gagal menghapus draft.', confirmButtonColor: '#053363' });
            }
        }

        document.addEventListener('DOMContentLoaded', fetchRequestOrders);
    </script>
    @endpush
</x-layout.app>
