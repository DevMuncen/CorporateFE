<?php if (isset($component)) { $__componentOriginalcf7e1d4949dbd350ec830409f7127ebc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf7e1d4949dbd350ec830409f7127ebc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.app','data' => ['title' => 'Tagihan Logistik (Carrier Freight Invoices) | Corporate Merchant Portal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tagihan Logistik (Carrier Freight Invoices) | Corporate Merchant Portal']); ?>
    <div class="space-y-6">

        <!-- Page Header -->
        <div class="card bg-white dark:bg-slate-800 p-5 md:p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 dark:bg-blue-950/50 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 text-xs font-semibold mb-2">
                        <iconify-icon icon="solar:delivery-bold-duotone" class="text-sm"></iconify-icon>
                        Freight Accounts Payable & Transporter Settlement
                    </div>
                    <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                        Tagihan Ongkos Kirim Logistik (Freight Payables)
                    </h1>
                    <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                        Audit dan bayar kewajiban tarif pengangkutan muatan dari transporter ekspedisi untuk pengiriman yang telah selesai.
                    </p>
                </div>
                <div class="flex items-center gap-2.5 shrink-0">
                    <button type="button" onclick="corpInvoiceApp.loadData()" class="btn bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 py-2 px-3.5 rounded-lg flex items-center gap-1.5 text-xs font-semibold border border-slate-300 dark:border-slate-600 shadow-xs transition-colors">
                        <iconify-icon icon="solar:refresh-linear" class="text-base"></iconify-icon>
                        <?php echo e(__('Refresh')); ?>

                    </button>
                </div>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Total Tagihan</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 flex items-center justify-center text-base">
                        <iconify-icon icon="solar:bill-list-bold-duotone"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-2" id="stat-corp-total">0</h3>
                <p class="text-[11px] text-slate-400 mt-0.5" id="stat-corp-total-amt">Rp 0</p>
            </div>
            <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Belum Dibayar</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center text-base">
                        <iconify-icon icon="solar:clock-circle-bold-duotone"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-2" id="stat-corp-unpaid">0</h3>
                <p class="text-[11px] text-slate-400 mt-0.5" id="stat-corp-unpaid-amt">Rp 0</p>
            </div>
            <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Menunggu Verifikasi</span>
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-base">
                        <iconify-icon icon="solar:card-2-bold-duotone"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-2" id="stat-corp-proof">0</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Bukti transfer terkirim</p>
            </div>
            <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Lunas / Settled</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base">
                        <iconify-icon icon="solar:check-circle-bold-duotone"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-2" id="stat-corp-paid">0</h3>
                <p class="text-[11px] text-slate-400 mt-0.5" id="stat-corp-paid-amt">Rp 0</p>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-1.5" id="corpFilterTabs">
                    <button type="button" onclick="corpInvoiceApp.setFilter('all')" class="status-tab active px-3 py-1.5 rounded-lg text-xs font-bold transition-colors bg-blue-600 text-white" data-status="all">
                        Semua Tagihan
                    </button>
                    <button type="button" onclick="corpInvoiceApp.setFilter('unpaid')" class="status-tab px-3 py-1.5 rounded-lg text-xs font-bold transition-colors bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200" data-status="unpaid">
                        Menunggu Pembayaran
                    </button>
                    <button type="button" onclick="corpInvoiceApp.setFilter('verification')" class="status-tab px-3 py-1.5 rounded-lg text-xs font-bold transition-colors bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200" data-status="verification">
                        Menunggu Verifikasi
                    </button>
                    <button type="button" onclick="corpInvoiceApp.setFilter('paid')" class="status-tab px-3 py-1.5 rounded-lg text-xs font-bold transition-colors bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200" data-status="paid">
                        Lunas
                    </button>
                </div>
                <div class="relative w-full md:w-72">
                    <iconify-icon icon="solar:magnifer-linear" class="absolute left-3 top-2.5 text-slate-400 text-sm"></iconify-icon>
                    <input type="text" oninput="corpInvoiceApp.handleSearch(this.value)" placeholder="Cari No. Faktur / Transporter..." class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Invoices Table -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6">No. Invoice Logistik</th>
                            <th class="py-3.5">Vendor / Transporter</th>
                            <th class="py-3.5">Surat Jalan (Waybills)</th>
                            <th class="py-3.5">Jatuh Tempo</th>
                            <th class="py-3.5 text-right">Biaya Ekspedisi</th>
                            <th class="py-3.5 text-center">Status Pembayaran</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="corpInvoicesTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat tagihan logistik...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
                <div id="corpTableInfo">Menampilkan 0 tagihan</div>
            </div>
        </div>

    </div>

    <!-- MODAL: Detail Tagihan Logistik & Upload Bukti Pembayaran -->
    <div id="corpInvoiceModal" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-2xl w-full max-w-3xl max-h-[92vh] flex flex-col overflow-hidden animate-in fade-in duration-150">
            <!-- Modal Header -->
            <div class="p-5 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between shrink-0 bg-slate-50/50 dark:bg-slate-900/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 flex items-center justify-center text-xl">
                        <iconify-icon icon="solar:bill-list-bold-duotone"></iconify-icon>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-black text-slate-900 dark:text-white" id="modalInvNumber">INV-LOG-0000</h3>
                            <span id="modalStatusBadge" class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-700">Unpaid</span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5" id="modalVendorSubtitle">Transporter</p>
                    </div>
                </div>
                <button type="button" onclick="corpInvoiceApp.closeModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <iconify-icon icon="solar:close-circle-linear" class="text-xl"></iconify-icon>
                </button>
            </div>

            <!-- Modal Content (Scrollable) -->
            <div class="p-6 overflow-y-auto space-y-6 flex-1 text-xs">
                
                <!-- Info Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50 dark:bg-slate-900/30 p-4 rounded-xl border border-slate-200 dark:border-slate-700">
                    <div>
                        <span class="text-slate-400 text-[11px] block">Tanggal Terbit</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200" id="modalIssueDate">-</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[11px] block">Jatuh Tempo</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200" id="modalDueDate">-</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[11px] block">Total Kewajiban</span>
                        <span class="font-black font-mono text-blue-600 dark:text-blue-400 text-sm" id="modalTotalAmount">Rp 0</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[11px] block">Rekening Transporter</span>
                        <span class="font-medium text-slate-800 dark:text-slate-200" id="modalPaymentInfo">Transfer Bank</span>
                    </div>
                </div>

                <!-- Waybill breakdown table -->
                <div class="space-y-2">
                    <h4 class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                        <iconify-icon icon="solar:delivery-bold-duotone" class="text-blue-600"></iconify-icon>
                        Rincian Muatan Surat Jalan (Waybills):
                    </h4>
                    <div class="border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 font-bold">
                                <tr>
                                    <th class="py-2.5 pl-4">No. Waybill</th>
                                    <th class="py-2.5">Ref. Request Order</th>
                                    <th class="py-2.5">Rute Pengiriman</th>
                                    <th class="py-2.5 pr-4 text-right">Tarif Ongkir</th>
                                </tr>
                            </thead>
                            <tbody id="modalWaybillsBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-400">Memuat rincian muatan...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Existing Proof Display (if already uploaded) -->
                <div id="modalExistingProofBox" class="bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/40 p-4 rounded-xl space-y-3 hidden">
                    <div class="flex items-center gap-2 text-emerald-800 dark:text-emerald-300 font-bold">
                        <iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon>
                        Bukti Pembayaran Telah Diunggah
                    </div>
                    <div id="modalProofDetails" class="text-slate-600 dark:text-slate-300 text-xs"></div>
                </div>

                <!-- Upload Payment Proof Form (if not paid) -->
                <div id="modalUploadProofBox" class="bg-slate-50 dark:bg-slate-900/40 p-5 rounded-xl border border-slate-200 dark:border-slate-700 space-y-4">
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                            <iconify-icon icon="solar:card-upload-bold-duotone" class="text-blue-600 text-base"></iconify-icon>
                            Unggah Bukti Transfer Pembayaran
                        </h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">
                            Kirimkan foto resi / struk bukti transfer bank agar transporter dapat merekonsiliasi pelunasan tagihan ini.
                        </p>
                    </div>

                    <form id="uploadProofForm" novalidate onsubmit="corpInvoiceApp.submitProof(event)" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">
                                    File Bukti Transfer (JPG, PNG, PDF) <span class="text-rose-500">*</span>
                                </label>
                                <input type="file" id="proofFileInput" accept="image/*,application/pdf" required class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">
                                    Tanggal Transfer <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" id="proofDateInput" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">
                                    Metode / Rekening Pengirim <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="proofMethodInput" placeholder="Contoh: Transfer BCA Corporate (PT ABC)" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">
                                    Nominal yang Ditransfer (Rp)
                                </label>
                                <input type="number" id="proofAmountInput" step="1000" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Catatan Tambahan</label>
                            <textarea id="proofNotesInput" rows="2" placeholder="Nomor referensi bank / catatan pelunasan..." class="w-full px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="submit" id="btnSubmitProof" class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-md shadow-blue-500/20 flex items-center gap-1.5">
                                <iconify-icon icon="solar:upload-bold" class="text-base"></iconify-icon>
                                <span>Kirim Bukti Pembayaran</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function getInvoiceStatusMeta(inv) {
            if (!inv) {
                return { key: 'unknown', label: 'Unknown', badgeClass: 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700' };
            }

            const st = String(inv.status || '').toLowerCase().trim();
            const proofStatus = parseInt(inv.payment_proof_status || 0);

            const isPaid = st === 'paid' || st === '3' || st === 'settled' || proofStatus === 2;
            const isCanceled = st === 'canceled' || st === 'cancelled' || st === '4';

            // Proof uploaded and waiting for transporter verification:
            const hasPendingProof = !isPaid && !isCanceled && (
                proofStatus === 1 ||
                Boolean(inv.payment_proof) ||
                (Array.isArray(inv.payments) && inv.payments.some(p => parseInt(p.status) === 1 || (!p.status && proofStatus === 1)))
            );

            const isDraft = !isPaid && !isCanceled && !hasPendingProof && (st === 'draft' || st === '0');

            if (isPaid) {
                return {
                    key: 'paid',
                    label: 'Lunas / Paid',
                    badgeClass: 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800/40'
                };
            }

            if (isCanceled) {
                return {
                    key: 'canceled',
                    label: 'Dibatalkan',
                    badgeClass: 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/40 dark:text-rose-300 dark:border-rose-800/40'
                };
            }

            if (hasPendingProof) {
                return {
                    key: 'verification',
                    label: 'Menunggu Verifikasi',
                    badgeClass: 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-300 dark:border-indigo-800/40'
                };
            }

            if (isDraft) {
                return {
                    key: 'draft',
                    label: 'Draft',
                    badgeClass: 'bg-slate-100 text-slate-600 border-slate-300 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700'
                };
            }

            return {
                key: 'unpaid',
                label: 'Menunggu Pembayaran',
                badgeClass: 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800/40'
            };
        }

        const corpInvoiceApp = {
            invoices: [],
            currentFilter: 'all',
            searchQuery: '',
            activeInvoiceId: null,

            async init() {
                await this.loadData();
            },

            async loadData() {
                const tbody = document.getElementById('corpInvoicesTableBody');
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <div class="inline-flex items-center gap-2">
                                <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                <span>Memuat tagihan logistik...</span>
                            </div>
                        </td>
                    </tr>
                `;

                try {
                    const res = await axios.get('/api/internal/corporate/finance/corporate-invoices');
                    const data = res.data?.data?.data || res.data?.data || res.data || [];
                    this.invoices = Array.isArray(data) ? data : [];
                    this.renderStats();
                    this.renderTable();
                } catch (err) {
                    console.error('Fetch corp invoices error:', err);
                    tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-rose-500">Gagal memuat tagihan logistik.</td></tr>`;
                }
            },

            renderStats() {
                let totalAmt = 0;
                let unpaidAmt = 0;
                let paidAmt = 0;
                let unpaidCount = 0;
                let paidCount = 0;
                let proofCount = 0;

                this.invoices.forEach(inv => {
                    const amt = parseFloat(inv.total_amount || inv.total_invoice || 0);
                    totalAmt += amt;

                    const meta = getInvoiceStatusMeta(inv);

                    if (meta.key === 'paid') {
                        paidCount++;
                        paidAmt += amt;
                    } else if (meta.key === 'verification') {
                        proofCount++;
                        unpaidAmt += amt;
                    } else if (meta.key === 'unpaid') {
                        unpaidCount++;
                        unpaidAmt += amt;
                    }
                });

                document.getElementById('stat-corp-total').textContent = this.invoices.length;
                document.getElementById('stat-corp-total-amt').textContent = 'Rp ' + totalAmt.toLocaleString('id-ID');
                document.getElementById('stat-corp-unpaid').textContent = unpaidCount;
                document.getElementById('stat-corp-unpaid-amt').textContent = 'Rp ' + unpaidAmt.toLocaleString('id-ID');
                document.getElementById('stat-corp-proof').textContent = proofCount;
                document.getElementById('stat-corp-paid').textContent = paidCount;
                document.getElementById('stat-corp-paid-amt').textContent = 'Rp ' + paidAmt.toLocaleString('id-ID');
            },

            setFilter(status) {
                this.currentFilter = status;
                document.querySelectorAll('#corpFilterTabs .status-tab').forEach(tab => {
                    if (tab.dataset.status === status) {
                        tab.className = 'status-tab active px-3 py-1.5 rounded-lg text-xs font-bold transition-colors bg-blue-600 text-white';
                    } else {
                        tab.className = 'status-tab px-3 py-1.5 rounded-lg text-xs font-bold transition-colors bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200';
                    }
                });
                this.renderTable();
            },

            handleSearch(query) {
                this.searchQuery = (query || '').toLowerCase().trim();
                this.renderTable();
            },

            getFiltered() {
                return this.invoices.filter(inv => {
                    const meta = getInvoiceStatusMeta(inv);

                    if (this.currentFilter !== 'all' && meta.key !== this.currentFilter) {
                        return false;
                    }

                    if (this.searchQuery) {
                        const invNo = String(inv.invoice_number || '').toLowerCase();
                        const vendor = String(inv.logistic?.name || inv.vendor?.name || '').toLowerCase();
                        if (!invNo.includes(this.searchQuery) && !vendor.includes(this.searchQuery)) {
                            return false;
                        }
                    }

                    return true;
                });
            },

            renderTable() {
                const tbody = document.getElementById('corpInvoicesTableBody');
                const list = this.getFiltered();

                if (!list.length) {
                    tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Tidak ada tagihan ongkos logistik.</td></tr>`;
                    document.getElementById('corpTableInfo').textContent = 'Menampilkan 0 tagihan';
                    return;
                }

                tbody.innerHTML = list.map(inv => {
                    const meta = getInvoiceStatusMeta(inv);
                    const statusBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border ${meta.badgeClass}">${meta.label}</span>`;

                    const waybillCount = (inv.details && inv.details.length) ? inv.details.length : (inv.waybill_id ? 1 : 0);
                    const vendorName = inv.logistic?.name || inv.vendor?.name || 'Muncen Logistics';
                    const invNo = inv.invoice_number || ('INV-LOG-' + inv.id);
                    const dueDate = inv.due_date ? new Date(inv.due_date).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' }) : '-';
                    const totalAmt = parseFloat(inv.total_amount || inv.total_invoice || 0).toLocaleString('id-ID');

                    return `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="py-3.5 pl-6 font-mono font-bold text-blue-600 dark:text-blue-400">
                                ${invNo}
                            </td>
                            <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">
                                ${vendorName}
                            </td>
                            <td class="py-3.5">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold text-[11px]">
                                    <iconify-icon icon="solar:box-minimalistic-bold" class="text-blue-500"></iconify-icon>
                                    ${waybillCount} Surat Jalan
                                </span>
                            </td>
                            <td class="py-3.5 text-slate-500">
                                ${dueDate}
                            </td>
                            <td class="py-3.5 text-right font-black font-mono text-slate-900 dark:text-slate-100">
                                Rp ${totalAmt}
                            </td>
                            <td class="py-3.5 text-center">
                                ${statusBadge}
                            </td>
                            <td class="py-3.5 pr-6 text-right">
                                <button type="button" onclick="corpInvoiceApp.openModal(${inv.id})" class="px-3 py-1 rounded-lg bg-blue-50 dark:bg-slate-700 text-blue-600 dark:text-blue-400 font-bold hover:bg-blue-100 transition-all">
                                    Detail & Bayar
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');

                document.getElementById('corpTableInfo').textContent = `Menampilkan ${list.length} dari ${this.invoices.length} tagihan`;
            },

            async openModal(id) {
                this.activeInvoiceId = id;
                const modal = document.getElementById('corpInvoiceModal');
                modal.classList.remove('hidden');

                document.getElementById('modalInvNumber').textContent = 'Memuat...';
                document.getElementById('modalWaybillsBody').innerHTML = `<tr><td colspan="4" class="py-6 text-center text-slate-400">Memuat rincian muatan...</td></tr>`;

                // Set today's date for upload form
                document.getElementById('proofDateInput').value = new Date().toISOString().split('T')[0];

                try {
                    const res = await axios.get(`/api/internal/corporate/finance/corporate-invoices/${id}`);
                    const inv = res.data?.data || res.data;

                    document.getElementById('modalInvNumber').textContent = inv.invoice_number || ('INV-LOG-' + inv.id);
                    document.getElementById('modalVendorSubtitle').textContent = `Transporter: ${inv.logistic?.name || inv.vendor?.name || 'Muncen Logistics'}`;

                    const meta = getInvoiceStatusMeta(inv);
                    const isPaid = meta.key === 'paid';
                    const hasProof = meta.key === 'verification' || (inv.payments && inv.payments.length > 0) || inv.payment_proof;

                    const badge = `<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border ${meta.badgeClass}">${meta.label}</span>`;
                    document.getElementById('modalStatusBadge').outerHTML = `<span id="modalStatusBadge">${badge}</span>`;

                    document.getElementById('modalIssueDate').textContent = inv.issue_date || (inv.created_at ? new Date(inv.created_at).toLocaleDateString('id-ID') : '-');
                    document.getElementById('modalDueDate').textContent = inv.due_date ? new Date(inv.due_date).toLocaleDateString('id-ID') : '-';
                    document.getElementById('modalTotalAmount').textContent = 'Rp ' + parseFloat(inv.total_amount || 0).toLocaleString('id-ID');
                    document.getElementById('modalPaymentInfo').textContent = inv.payment_method || 'Transfer Bank Transporter';
                    document.getElementById('proofAmountInput').value = parseFloat(inv.total_amount || 0);

                    // Details waybills
                    const details = inv.details || [];
                    const tbody = document.getElementById('modalWaybillsBody');
                    if (!details.length) {
                        tbody.innerHTML = `<tr><td colspan="4" class="py-6 text-center text-slate-400">Tidak ada rincian waybills.</td></tr>`;
                    } else {
                        tbody.innerHTML = details.map(d => {
                            const wb = d.waybill || {};
                            const ro = d.request_order || wb.request_order || {};
                            const orig = wb.origin_city_name || wb.origin || wb.origin_city_code || 'Gudang Asal';
                            const dest = wb.destination_city_name || wb.destination || wb.destination_city_code || wb.destination_address || 'Tujuan';
                            const route = wb.route || `${orig} → ${dest}`;
                            const subtotal = parseFloat(d.subtotal || d.shipping_cost || d.price || 0).toLocaleString('id-ID');

                            return `
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                    <td class="py-2.5 pl-4 font-mono font-bold text-blue-600">${wb.waybill_number || ('WB-#' + d.waybill_id)}</td>
                                    <td class="py-2.5 font-mono text-slate-600">${ro.order_number || ro.ro_number || (d.request_order_id ? ('RO-#' + d.request_order_id) : '-')}</td>
                                    <td class="py-2.5 text-slate-600">${route}</td>
                                    <td class="py-2.5 pr-4 text-right font-mono font-bold text-slate-800">Rp ${subtotal}</td>
                                </tr>
                            `;
                        }).join('');
                    }

                    // Payment proof state
                    const payments = inv.payments || [];
                    const existingProofBox = document.getElementById('modalExistingProofBox');
                    const uploadBox = document.getElementById('modalUploadProofBox');

                    if (payments.length > 0 || inv.payment_proof) {
                        const p = payments.length > 0 ? payments[payments.length - 1] : {};
                        const proofUrl = p.proof_url || inv.payment_proof_url;
                        existingProofBox.classList.remove('hidden');
                        document.getElementById('modalProofDetails').innerHTML = `
                            <div class="flex flex-col sm:flex-row items-start gap-4">
                                ${proofUrl ? `
                                    <a href="${proofUrl}" target="_blank" class="block shrink-0 rounded-lg overflow-hidden border border-emerald-300 hover:opacity-90">
                                        <img src="${proofUrl}" alt="Bukti Transfer" class="w-24 h-24 object-cover">
                                    </a>
                                ` : ''}
                                <div>
                                    <div class="font-bold text-slate-800">Nominal: Rp ${parseFloat(p.amount || inv.total_amount || 0).toLocaleString('id-ID')}</div>
                                    <div class="text-[11px] text-slate-500">Tgl: ${p.payment_date || '-'} | Metode: ${p.payment_method || 'Bank Transfer'}</div>
                                    <div class="text-[11px] text-slate-500">Catatan: ${p.notes || '-'}</div>
                                    <div class="text-[11px] font-bold ${isPaid || p.status === 2 ? 'text-emerald-600' : 'text-indigo-600'} mt-1">
                                        Status: ${isPaid || p.status === 2 ? 'Pembayaran telah dikonfirmasi LUNAS oleh pihak transporter.' : 'Menunggu verifikasi pelunasan dari pihak transporter.'}
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        existingProofBox.classList.add('hidden');
                    }

                    if (isPaid) {
                        uploadBox.classList.add('hidden');
                    } else {
                        uploadBox.classList.remove('hidden');
                    }

                } catch (err) {
                    console.error('Fetch invoice detail error:', err);
                }
            },

            closeModal() {
                document.getElementById('corpInvoiceModal').classList.add('hidden');
                document.getElementById('uploadProofForm').reset();
                this.activeInvoiceId = null;
            },

            async submitProof(e) {
                e.preventDefault();
                if (!this.activeInvoiceId) return;

                const fileInput = document.getElementById('proofFileInput');
                if (!fileInput.files || !fileInput.files.length) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Harap pilih file bukti transfer pembayaran (format: JPG, PNG, atau PDF)!',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }

                const dateVal = document.getElementById('proofDateInput').value;
                if (!dateVal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Harap tentukan tanggal transfer pembayaran!',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }

                const methodVal = (document.getElementById('proofMethodInput').value || '').trim();
                if (!methodVal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Harap masukkan metode transfer atau nama bank / rekening pengirim!',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }

                const formData = new FormData();
                formData.append('payment_proof', fileInput.files[0]);
                formData.append('payment_date', dateVal);
                formData.append('payment_method', methodVal);
                formData.append('amount', document.getElementById('proofAmountInput').value);
                formData.append('notes', document.getElementById('proofNotesInput').value);

                const btn = document.getElementById('btnSubmitProof');
                btn.disabled = true;
                btn.innerHTML = `<div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div><span>Mengunggah...</span>`;

                try {
                    await axios.post(`/api/internal/corporate/finance/corporate-invoices/${this.activeInvoiceId}/payment-proof`, formData, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    });
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Bukti transfer pembayaran berhasil diunggah! Transporter akan segera merekonsiliasi pembayaran Anda.',
                        confirmButtonColor: '#2563eb'
                    });
                    this.closeModal();
                    await this.loadData();
                } catch (err) {
                    console.error('Upload proof error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: err.response?.data?.message || 'Gagal mengunggah bukti pembayaran.',
                        confirmButtonColor: '#2563eb'
                    });
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = `<iconify-icon icon="solar:upload-bold" class="text-base"></iconify-icon><span>Kirim Bukti Pembayaran</span>`;
                }
            }
        };

        document.addEventListener('DOMContentLoaded', () => corpInvoiceApp.init());
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf7e1d4949dbd350ec830409f7127ebc)): ?>
<?php $attributes = $__attributesOriginalcf7e1d4949dbd350ec830409f7127ebc; ?>
<?php unset($__attributesOriginalcf7e1d4949dbd350ec830409f7127ebc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf7e1d4949dbd350ec830409f7127ebc)): ?>
<?php $component = $__componentOriginalcf7e1d4949dbd350ec830409f7127ebc; ?>
<?php unset($__componentOriginalcf7e1d4949dbd350ec830409f7127ebc); ?>
<?php endif; ?>
<?php /**PATH D:\DevMuncen\CorporateFE\resources\views/finance/corporate-invoices/index.blade.php ENDPATH**/ ?>