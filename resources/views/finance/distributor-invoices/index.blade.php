<x-layout.app title="Faktur Distributor (B2B Receivables) | Corporate Merchant Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Faktur Penagihan Distributor
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Piutang dagang korporasi atas pesanan dan pasokan barang ke jaringan distributor
                </p>
            </div>
            <a href="/finance/corporate-invoices" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all flex items-center gap-1.5 shadow-xs">
                <iconify-icon icon="solar:bill-check-bold-duotone" class="text-base text-blue-600"></iconify-icon>
                <span>Tagihan Ekspedisi Logistik &rarr;</span>
            </a>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6">No. Invoice</th>
                            <th class="py-3.5">Distributor</th>
                            <th class="py-3.5">Jatuh Tempo</th>
                            <th class="py-3.5 text-right">Total Tagihan</th>
                            <th class="py-3.5 text-center">Status Pembayaran</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="distInvoicesTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat faktur distributor...</span>
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
        async function fetchDistributorInvoices() {
            const tbody = document.getElementById('distInvoicesTableBody');
            try {
                const res = await axios.get('/api/finance/distributor-invoices');
                const data = res.data?.data?.data || res.data?.data || [];

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Belum ada faktur penagihan distributor.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map(inv => {
                    const statusClass = {
                        'unpaid': 'bg-amber-50 text-amber-700 border border-amber-200',
                        'partial': 'bg-blue-50 text-blue-700 border border-blue-200',
                        'paid': 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                        'overdue': 'bg-red-50 text-red-700 border border-red-200'
                    }[inv.status?.toLowerCase()] || 'bg-slate-100 text-slate-700';

                    return `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="py-3.5 pl-6 font-mono font-bold text-blue-600 dark:text-blue-400">${inv.invoice_number || 'INV-#' + inv.id}</td>
                            <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${inv.distributor?.name || 'Distributor Mitra'}</td>
                            <td class="py-3.5 text-slate-500">${inv.due_date || '-'}</td>
                            <td class="py-3.5 text-right font-black text-slate-900 dark:text-slate-100">Rp ${(inv.total_amount || 0).toLocaleString('id-ID')}</td>
                            <td class="py-3.5 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider ${statusClass}">
                                    ${inv.status || 'Unpaid'}
                                </span>
                            </td>
                            <td class="py-3.5 pr-6 text-right">
                                <a href="/finance/distributor-invoices/${inv.id}" class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-slate-700 text-blue-600 dark:text-blue-400 font-bold hover:bg-blue-100 transition-all">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    `;
                }).join('');
            } catch (err) {
                console.error('Fetch dist invoices error:', err);
                tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Gagal memuat faktur distributor.</td></tr>`;
            }
        }

        document.addEventListener('DOMContentLoaded', fetchDistributorInvoices);
    </script>
    @endpush
</x-layout.app>
