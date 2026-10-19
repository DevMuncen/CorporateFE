<x-layout.app title="Detail & Pelacakan Waybill | Corporate Merchant Portal">
    <div class="space-y-6 max-w-5xl mx-auto">

        <!-- Top Header & Back -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="/waybills" class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors inline-flex items-center gap-1 mb-1">
                    <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                    <span>Kembali ke Daftar Waybill</span>
                </a>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white flex items-center gap-3">
                    <span>Surat Jalan &amp; Pelacakan Real-time</span>
                    <span id="wbNumberBadge" class="text-sm font-mono px-3 py-1 rounded-xl bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300">...</span>
                </h1>
            </div>
            <div class="flex items-center gap-2">
                <a id="printBtn" href="#" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all flex items-center gap-1.5 shadow-xs">
                    <iconify-icon icon="solar:printer-bold" class="text-base text-blue-600"></iconify-icon>
                    <span>Cetak Surat Jalan</span>
                </a>
            </div>
        </div>

        <!-- Waybill Summary Header Card -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                <div>
                    <span class="text-slate-400 uppercase font-bold text-[10px] tracking-wider">Status Perjalanan</span>
                    <h5 id="wbStatus" class="text-sm font-black text-blue-600 dark:text-blue-400 uppercase mt-0.5">...</h5>
                </div>
                <div>
                    <span class="text-slate-400 uppercase font-bold text-[10px] tracking-wider">Transporter &amp; Armada</span>
                    <h5 id="wbTransporter" class="text-sm font-black text-slate-800 dark:text-slate-200 mt-0.5">...</h5>
                </div>
                <div>
                    <span class="text-slate-400 uppercase font-bold text-[10px] tracking-wider">Supir (Driver)</span>
                    <h5 id="wbDriver" class="text-sm font-black text-slate-800 dark:text-slate-200 mt-0.5">...</h5>
                </div>
                <div>
                    <span class="text-slate-400 uppercase font-bold text-[10px] tracking-wider">No. Polisi Armada</span>
                    <h5 id="wbPlate" class="text-sm font-mono font-black text-slate-800 dark:text-slate-200 mt-0.5">...</h5>
                </div>
            </div>
        </div>

        <!-- Tracking Timeline & Checkpoints -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-6">
                <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:routing-2-bold-duotone" class="text-xl text-blue-600"></iconify-icon>
                    <span>Jejak Riwayat Pengiriman (Milestone Tracking)</span>
                </h3>

                <div class="relative pl-6 space-y-6 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200 dark:before:bg-slate-700 text-xs" id="timelineContainer">
                    <!-- Dynamic timeline checkpoints -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-blue-600 border-2 border-white dark:border-slate-800"></div>
                        <h5 class="font-bold text-slate-900 dark:text-white">Pemuatan Selesai di Gudang Asal</h5>
                        <p class="text-slate-500">Armada diberangkatkan dari Hub Cikarang</p>
                    </div>
                </div>
            </div>

            <!-- Proof of Delivery (POD) & Documents Card -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-4">
                <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:document-text-bold-duotone" class="text-xl text-emerald-500"></iconify-icon>
                    <span>Bukti Serah Terima (POD)</span>
                </h3>

                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-center text-xs space-y-2">
                    <iconify-icon icon="solar:camera-bold-duotone" class="text-3xl text-slate-400"></iconify-icon>
                    <p class="text-slate-500">Foto bukti serah terima atau tanda tangan digital penerima</p>
                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700">
                        Menunggu Konfirmasi Drop
                    </span>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const pathParts = window.location.pathname.split('/');
            const id = pathParts[pathParts.length - 1];

            try {
                const res = await axios.get(`/api/waybills/${id}`);
                const wb = res.data?.data;
                if (!wb) return;

                document.getElementById('wbNumberBadge').innerText = wb.waybill_number || 'WB-#' + wb.id;
                document.getElementById('wbStatus').innerText = wb.status || 'Dispatched';
                document.getElementById('wbTransporter').innerText = wb.vendor?.name || 'Muncen Logistics';
                document.getElementById('wbDriver').innerText = wb.driver_name || 'Driver Ekspedisi';
                document.getElementById('wbPlate').innerText = wb.plate_number || 'B 9999 MCN';
                document.getElementById('printBtn').href = `/waybills/${id}/print`;
            } catch (err) {
                console.error('Fetch waybill detail error:', err);
            }
        });
    </script>
    @endpush
</x-layout.app>
