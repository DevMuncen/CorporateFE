<x-layout.app title="Pesanan Customer (Customer Orders) | Corporate Merchant Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Pesanan Masuk Customer
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Permintaan pasokan barang dari pelanggan / customer untuk diproses menjadi Request Order
                </p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">No. Pesanan</th>
                            <th class="py-3.5">Pelanggan / Customer</th>
                            <th class="py-3.5">Tanggal</th>
                            <th class="py-3.5 text-right">Total Item</th>
                            <th class="py-3.5 text-right">Nilai Pesanan</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="distOrdersTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat pesanan customer...</span>
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
        async function fetchDistributorOrders() {
            const tbody = document.getElementById('distOrdersTableBody');
            try {
                const res = await axios.get('/api/distributor-orders');
                const data = res.data?.data?.data || res.data?.data || [];

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Belum ada pesanan customer baru.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map((o, idx) => `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                        <td class="py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">${o.order_number || 'DO-#' + o.id}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${o.customer?.name || o.distributor?.name || 'Customer Mitra'}</td>
                        <td class="py-3.5 text-slate-500">${o.created_at ? new Date(o.created_at).toLocaleDateString('id-ID') : '-'}</td>
                        <td class="py-3.5 text-right font-medium text-slate-700 dark:text-slate-300">${o.total_quantity || 0} unit</td>
                        <td class="py-3.5 text-right font-bold text-slate-900 dark:text-slate-100">Rp ${(o.total_amount || 0).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 uppercase tracking-wider">
                                ${o.status || 'Pending'}
                            </span>
                        </td>
                        <td class="py-3.5 pr-6 text-right">
                            <a href="/request-orders/${o.id}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-slate-700 text-blue-600 dark:text-blue-400 font-bold hover:bg-blue-100 transition-all">
                                <iconify-icon icon="solar:eye-bold"></iconify-icon> Detail
                            </a>
                        </td>
                    </tr>
                `).join('');
            } catch (err) {
                console.error('Fetch dist orders error:', err);
                tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Gagal memuat pesanan customer.</td></tr>`;
            }
        }

        document.addEventListener('DOMContentLoaded', fetchDistributorOrders);
    </script>
    @endpush
</x-layout.app>
