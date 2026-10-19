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
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6">No. Transaksi</th>
                            <th class="py-3.5">Tanggal Masuk</th>
                            <th class="py-3.5">Gudang Penerima</th>
                            <th class="py-3.5">Asal Pengirim / Pemasok</th>
                            <th class="py-3.5 text-right">Total Kuantitas</th>
                            <th class="py-3.5 pr-6 text-right">Petugas PIC</th>
                        </tr>
                    </thead>
                    <tbody id="itemInsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat riwayat barang masuk...</span>
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
        async function fetchItemIns() {
            const tbody = document.getElementById('itemInsTableBody');
            try {
                const res = await axios.get('/api/inventory/item-ins');
                const data = res.data?.data?.data || res.data?.data || [];

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Belum ada catatan penerimaan barang masuk.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map(i => `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-mono font-bold text-blue-600 dark:text-blue-400">${i.reference_number || 'IN-#' + i.id}</td>
                        <td class="py-3.5 text-slate-500">${i.received_date || (i.created_at ? new Date(i.created_at).toLocaleDateString('id-ID') : '-')}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-200">${i.warehouse?.name || 'Gudang Pusat'}</td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-300">${i.supplier_name || i.source || 'Pemasok Utama'}</td>
                        <td class="py-3.5 text-right font-black text-emerald-600">${(i.total_quantity || 0).toLocaleString('id-ID')} unit</td>
                        <td class="py-3.5 pr-6 text-right text-slate-600 dark:text-slate-300">${i.receiver_name || 'Staff Gudang'}</td>
                    </tr>
                `).join('');
            } catch (err) {
                console.error('Fetch item ins error:', err);
                tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Gagal memuat catatan barang masuk.</td></tr>`;
            }
        }

        document.addEventListener('DOMContentLoaded', fetchItemIns);
    </script>
    @endpush
</x-layout.app>
