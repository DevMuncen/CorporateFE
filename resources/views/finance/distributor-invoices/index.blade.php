<x-layout.app title="Faktur Pelanggan & Distributor | Corporate Merchant Portal">
    <div class="space-y-6">

        <!-- Page Header -->
        <div class="card bg-white dark:bg-slate-800 p-5 md:p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 dark:bg-blue-950/50 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 text-xs font-semibold mb-2">
                        <iconify-icon icon="solar:cart-bold-duotone" class="text-sm"></iconify-icon>
                        Accounts Receivable &amp; Distributor Invoicing
                    </div>
                    <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                        Faktur Penagihan Pelanggan (Distributor Invoices)
                    </h1>
                    <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                        Kelola piutang dagang korporasi atas pesanan dan pasokan produk barang jadi ke jaringan distributor rekanan.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                    <button type="button" onclick="distInvoiceApp.loadData()" class="!bg-white dark:!bg-slate-700 hover:!bg-slate-50 dark:hover:!bg-slate-600 !text-slate-700 dark:!text-slate-200 py-2 px-3.5 rounded-lg flex items-center gap-1.5 text-xs font-semibold border border-slate-300 dark:border-slate-600 shadow-xs transition-colors">
                        <iconify-icon icon="solar:refresh-linear" class="text-base !text-slate-700 dark:!text-slate-200"></iconify-icon>
                        <span>{{ __('Refresh') }}</span>
                    </button>
                    <button type="button" onclick="distInvoiceApp.openCreateModal()" class="bg-blue-600 hover:bg-blue-500 text-white py-2 px-4 rounded-lg flex items-center gap-1.5 text-xs font-bold shadow-md shadow-blue-600/20 transition-all">
                        <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                        <span>+ Buat Faktur Penagihan</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Total Piutang Produk</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 flex items-center justify-center text-base">
                        <iconify-icon icon="solar:bill-list-bold-duotone"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-2" id="stat-dist-total">0</h3>
                <p class="text-[11px] text-slate-400 mt-0.5" id="stat-dist-total-amt">Rp 0</p>
            </div>
            <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Belum Dibayar (Unpaid)</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center text-base">
                        <iconify-icon icon="solar:clock-circle-bold-duotone"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-2" id="stat-dist-unpaid">0</h3>
                <p class="text-[11px] text-slate-400 mt-0.5" id="stat-dist-unpaid-amt">Rp 0</p>
            </div>
            <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Menunggu Validasi</span>
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-base">
                        <iconify-icon icon="solar:card-2-bold-duotone"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-2" id="stat-dist-proof">0</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Bukti transfer distributor</p>
            </div>
            <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Lunas / Terkonfirmasi</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base">
                        <iconify-icon icon="solar:check-circle-bold-duotone"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-2" id="stat-dist-paid">0</h3>
                <p class="text-[11px] text-slate-400 mt-0.5" id="stat-dist-paid-amt">Rp 0</p>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-1.5" id="distFilterTabs">
                    <button type="button" onclick="distInvoiceApp.setFilter('all')" class="status-tab active px-3 py-1.5 rounded-lg text-xs font-bold transition-colors bg-blue-600 text-white" data-status="all">
                        Semua Faktur
                    </button>
                    <button type="button" onclick="distInvoiceApp.setFilter('unpaid')" class="status-tab px-3 py-1.5 rounded-lg text-xs font-bold transition-colors bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200" data-status="unpaid">
                        Belum Lunas
                    </button>
                    <button type="button" onclick="distInvoiceApp.setFilter('pending_validation')" class="status-tab px-3 py-1.5 rounded-lg text-xs font-bold transition-colors bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200" data-status="pending_validation">
                        Menunggu Validasi
                    </button>
                    <button type="button" onclick="distInvoiceApp.setFilter('paid')" class="status-tab px-3 py-1.5 rounded-lg text-xs font-bold transition-colors bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200" data-status="paid">
                        Lunas
                    </button>
                </div>
                <div class="relative w-full md:w-72">
                    <iconify-icon icon="solar:magnifer-linear" class="absolute left-3 top-2.5 text-slate-400 text-sm"></iconify-icon>
                    <input type="text" oninput="distInvoiceApp.handleSearch(this.value)" placeholder="Cari No. Faktur / Pelanggan..." class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Invoices Table -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">No. Invoice &amp; Tanggal</th>
                            <th class="py-3.5">Pelanggan / Distributor</th>
                            <th class="py-3.5">Item Produk</th>
                            <th class="py-3.5">Jatuh Tempo</th>
                            <th class="py-3.5 text-right">Total Tagihan</th>
                            <th class="py-3.5 text-center">Status Pembayaran</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="distInvoicesTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat faktur pelanggan...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
                <div id="distTableInfo">Menampilkan 0 faktur</div>
            </div>
        </div>

    </div>

    <!-- MODAL: Buat Faktur Penagihan Baru -->
    <div id="distInvoiceCreateModal" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-2xl w-full max-w-4xl max-h-[92vh] flex flex-col overflow-hidden">
            <div class="p-5 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between shrink-0 bg-slate-50/50 dark:bg-slate-900/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 flex items-center justify-center text-xl">
                        <iconify-icon icon="solar:bill-list-bold-duotone"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">Buat Faktur Penagihan Customer</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Terbitkan tagihan piutang produk kepada pelanggan / distributor</p>
                    </div>
                </div>
                <button type="button" onclick="distInvoiceApp.closeCreateModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <iconify-icon icon="solar:close-circle-linear" class="text-xl"></iconify-icon>
                </button>
            </div>

            <form id="createDistInvoiceForm" onsubmit="distInvoiceApp.submitCreateInvoice(event)" class="flex flex-col flex-1 overflow-hidden text-xs">
                <div class="p-6 overflow-y-auto space-y-5 flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="lg:col-span-2">
                            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Pelanggan / Distributor *</label>
                            <select id="createInvDistributorId" required class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100">
                                <option value="">Pilih Pelanggan / Distributor...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Tanggal Faktur *</label>
                            <input type="date" id="createInvDate" required class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Tanggal Jatuh Tempo *</label>
                            <input type="date" id="createInvDueDate" required class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Status Awal Faktur</label>
                            <select id="createInvStatus" class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100">
                                <option value="1">Terbitkan Langsung (Belum Lunas)</option>
                                <option value="0">Simpan sebagai Draft</option>
                            </select>
                        </div>
                        <div class="lg:col-span-3">
                            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Catatan Penagihan (Opsional)</label>
                            <input type="text" id="createInvNotes" placeholder="Referensi PO customer, termin pembayaran, dll..." class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100" />
                        </div>
                    </div>

                    <!-- Dynamic Line Items -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="text-blue-600"></iconify-icon>
                                <span>Daftar Item Produk yang Ditagihkan *</span>
                            </h4>
                            <button type="button" onclick="distInvoiceApp.addCreateItemRow()" class="px-3 py-1.5 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800 font-bold hover:bg-blue-100 transition-all flex items-center gap-1">
                                <iconify-icon icon="solar:add-circle-bold"></iconify-icon>
                                <span>+ Tambah Baris Produk</span>
                            </button>
                        </div>

                        <div class="border border-slate-200 dark:border-slate-700 rounded-xl overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 font-bold">
                                    <tr>
                                        <th class="py-2.5 pl-4 w-10">No</th>
                                        <th class="py-2.5">Produk Katalog / Nama Item</th>
                                        <th class="py-2.5 w-24 text-center">Qty</th>
                                        <th class="py-2.5 w-40 text-right">Harga Satuan (Rp)</th>
                                        <th class="py-2.5 w-40 text-right">Subtotal (Rp)</th>
                                        <th class="py-2.5 pr-4 w-12 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="createInvItemsBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Summary Box -->
                    <div class="bg-slate-50 dark:bg-slate-900/40 p-4 rounded-xl border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="text-slate-500 dark:text-slate-400 text-[11px]">
                            Pajak PPN 11% dihitung otomatis dari subtotal produk.
                        </div>
                        <div class="space-y-1 text-right min-w-[240px]">
                            <div class="flex justify-between text-slate-600 dark:text-slate-300">
                                <span>Subtotal:</span>
                                <span id="createInvSubtotalDisplay" class="font-mono font-semibold">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-slate-600 dark:text-slate-300">
                                <span>PPN (11%):</span>
                                <span id="createInvTaxDisplay" class="font-mono font-semibold">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-sm font-black text-blue-600 dark:text-blue-400 pt-1 border-t border-slate-200 dark:border-slate-700">
                                <span>Grand Total:</span>
                                <span id="createInvGrandTotalDisplay" class="font-mono">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 border-t border-slate-200 dark:border-slate-700 flex items-center justify-end gap-2.5 bg-slate-50/50 dark:bg-slate-900/30 shrink-0">
                    <button type="button" onclick="distInvoiceApp.closeCreateModal()" class="px-4 py-2 rounded-xl font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitCreateInv" class="px-5 py-2 rounded-xl font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/20 transition-all flex items-center gap-1.5">
                        <iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon>
                        <span>Simpan Faktur Penagihan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Detail Faktur Penagihan Pelanggan -->
    <div id="distInvoiceModal" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-2xl w-full max-w-4xl max-h-[92vh] flex flex-col overflow-hidden animate-in fade-in duration-150">
            <!-- Modal Header -->
            <div class="p-5 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between shrink-0 bg-slate-50/50 dark:bg-slate-900/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 flex items-center justify-center text-xl">
                        <iconify-icon icon="solar:cart-bold-duotone"></iconify-icon>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-black text-slate-900 dark:text-white" id="distModalInvNumber">INV-0000</h3>
                            <span id="distModalStatusBadge" class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-700">Unpaid</span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5" id="distModalCustomerSubtitle">Pelanggan Distributor</p>
                    </div>
                </div>
                <button type="button" onclick="distInvoiceApp.closeModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <iconify-icon icon="solar:close-circle-linear" class="text-xl"></iconify-icon>
                </button>
            </div>

            <!-- Modal Content (Scrollable) -->
            <div class="p-6 overflow-y-auto space-y-6 flex-1 text-xs">
                
                <!-- Info Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50 dark:bg-slate-900/30 p-4 rounded-xl border border-slate-200 dark:border-slate-700">
                    <div>
                        <span class="text-slate-400 text-[11px] block">Tanggal Faktur</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200" id="distModalDate">-</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[11px] block">Jatuh Tempo</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200" id="distModalDueDate">-</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[11px] block">Total Tagihan</span>
                        <span class="font-black font-mono text-blue-600 dark:text-blue-400 text-sm" id="distModalGrandTotal">Rp 0</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[11px] block">Total Tonase / Kubikasi</span>
                        <span class="font-medium text-slate-800 dark:text-slate-200" id="distModalTonnage">0 Ton / 0 CBM</span>
                    </div>
                </div>

                <!-- Product Items breakdown table -->
                <div class="space-y-2">
                    <h4 class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                        <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="text-blue-600"></iconify-icon>
                        Daftar Produk Pesanan (Invoice Items):
                    </h4>
                    <div class="border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden">
                        <table class="w-full text-left text-xs">
                            <thead id="distModalItemsHead" class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 font-bold">
                                <tr>
                                    <th class="py-2.5 pl-4 w-10">No</th>
                                    <th class="py-2.5">Nama Produk &amp; SKU</th>
                                    <th class="py-2.5 text-center">Qty Diterima</th>
                                    <th class="py-2.5 text-right">Harga Satuan (Rp)</th>
                                    <th class="py-2.5 pr-4 text-right">Subtotal (Rp)</th>
                                </tr>
                            </thead>
                            <tbody id="distModalItemsBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-slate-400">Memuat rincian produk...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Proof of Payment / Verification Box -->
                <div class="bg-slate-50 dark:bg-slate-900/40 p-4 rounded-xl border border-slate-200 dark:border-slate-700 space-y-3">
                    <h4 class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                        <iconify-icon icon="solar:card-2-bold-duotone" class="text-emerald-600 text-base"></iconify-icon>
                        Status Pembayaran &amp; Bukti Pelunasan Customer:
                    </h4>
                    <div id="distModalPaymentProofContent" class="text-slate-500">
                        Belum ada data bukti pelunasan dari distributor.
                    </div>
                </div>

            </div>

            <!-- Modal Footer with Contextual Workflow Actions -->
            <div class="p-4 border-t border-slate-200 dark:border-slate-700 flex flex-wrap items-center justify-between gap-2 bg-slate-50/60 dark:bg-slate-900/30 shrink-0">
                <div id="distModalWorkflowActions" class="flex flex-wrap items-center gap-2"></div>
                <button type="button" onclick="distInvoiceApp.closeModal()" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function getDistInvoiceMeta(inv) {
            const st = parseInt(inv?.status ?? 1);
            const rawStr = String(inv?.status ?? '').toLowerCase();
            const proofStatus = parseInt(inv?.payment_proof_status ?? 0);

            if (st === 3 || rawStr === 'paid' || rawStr === 'confirmed') {
                return {
                    code: 3,
                    key: 'paid',
                    label: 'Lunas (Terkonfirmasi)',
                    badgeClass: 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800'
                };
            }
            if (st === 4 || rawStr === 'cancelled' || rawStr === 'canceled') {
                return {
                    code: 4,
                    key: 'cancelled',
                    label: 'Dibatalkan',
                    badgeClass: 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/40 dark:text-rose-300 dark:border-rose-800'
                };
            }
            if (st === 2 || proofStatus === 1 || rawStr === 'pending_validation') {
                return {
                    code: 2,
                    key: 'pending_validation',
                    label: 'Menunggu Validasi',
                    badgeClass: 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-300 dark:border-indigo-800'
                };
            }
            if (st === 0 || rawStr === 'draft') {
                return {
                    code: 0,
                    key: 'draft',
                    label: 'Draft',
                    badgeClass: 'bg-slate-100 text-slate-700 border-slate-300 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600'
                };
            }
            return {
                code: 1,
                key: 'unpaid',
                label: 'Belum Lunas (Terbit)',
                badgeClass: 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800'
            };
        }

        const distInvoiceApp = {
            invoices: [],
            distributors: [],
            products: [],
            currentFilter: 'all',
            searchQuery: '',
            activeModalId: null,

            async init() {
                await Promise.all([
                    this.loadDependencies(),
                    this.loadData()
                ]);
            },

            async loadDependencies() {
                try {
                    const res = await axios.get('/api/finance/distributor-invoices/dependencies');
                    const d = res.data?.data || res.data || {};
                    this.distributors = Array.isArray(d.distributors) ? d.distributors : [];
                    this.products = Array.isArray(d.products) ? d.products : [];
                } catch (err) {
                    console.warn('Fallback loading distributor invoice dependencies:', err);
                    try {
                        const [distRes, prodRes] = await Promise.all([
                            axios.get('/api/distributors'),
                            axios.get('/api/products')
                        ]);
                        this.distributors = distRes.data?.data?.data || distRes.data?.data || [];
                        this.products = prodRes.data?.data?.data || prodRes.data?.data || [];
                    } catch (e2) {
                        console.error('Dependencies fallback error:', e2);
                    }
                }
                this.populateDistributorSelect();
            },

            populateDistributorSelect() {
                const sel = document.getElementById('createInvDistributorId');
                if (!sel) return;
                sel.innerHTML = '<option value="">Pilih Pelanggan / Distributor...</option>' +
                    this.distributors.map(d => `<option value="${d.id}">${d.code ? '[' + d.code + '] ' : ''}${d.name}${d.city ? ' - ' + d.city : ''}</option>`).join('');
            },

            async loadData() {
                const tbody = document.getElementById('distInvoicesTableBody');
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-400">
                            <div class="inline-flex items-center gap-2">
                                <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                <span>Memuat faktur pelanggan...</span>
                            </div>
                        </td>
                    </tr>
                `;

                try {
                    const res = await axios.get('/api/internal/corporate/finance/distributor-invoices');
                    const data = res.data?.data?.data || res.data?.data || res.data || [];
                    this.invoices = Array.isArray(data) ? data : [];
                    this.renderStats();
                    this.renderTable();
                } catch (err) {
                    console.error('Fetch dist invoices error:', err);
                    tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-rose-500">Gagal memuat faktur pelanggan.</td></tr>`;
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
                    const meta = getDistInvoiceMeta(inv);
                    if (meta.code === 4) return; // Ignore cancelled in receivable totals

                    const amt = parseFloat(inv.grand_total_amount || inv.total_amount || 0);
                    totalAmt += amt;

                    if (meta.code === 3) {
                        paidCount++;
                        paidAmt += amt;
                    } else {
                        unpaidCount++;
                        unpaidAmt += amt;
                    }

                    if (meta.code === 2) {
                        proofCount++;
                    }
                });

                document.getElementById('stat-dist-total').textContent = this.invoices.length;
                document.getElementById('stat-dist-total-amt').textContent = 'Rp ' + totalAmt.toLocaleString('id-ID');
                document.getElementById('stat-dist-unpaid').textContent = unpaidCount;
                document.getElementById('stat-dist-unpaid-amt').textContent = 'Rp ' + unpaidAmt.toLocaleString('id-ID');
                document.getElementById('stat-dist-proof').textContent = proofCount;
                document.getElementById('stat-dist-paid').textContent = paidCount;
                document.getElementById('stat-dist-paid-amt').textContent = 'Rp ' + paidAmt.toLocaleString('id-ID');
            },

            setFilter(status) {
                this.currentFilter = status;
                document.querySelectorAll('#distFilterTabs .status-tab').forEach(tab => {
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
                    const meta = getDistInvoiceMeta(inv);

                    if (this.currentFilter === 'unpaid' && !(meta.code === 0 || meta.code === 1)) return false;
                    if (this.currentFilter === 'pending_validation' && meta.code !== 2) return false;
                    if (this.currentFilter === 'paid' && meta.code !== 3) return false;

                    if (this.searchQuery) {
                        const invNo = String(inv.invoice_number || '').toLowerCase();
                        const distName = String(inv.distributor?.name || inv.customer?.name || '').toLowerCase();
                        if (!invNo.includes(this.searchQuery) && !distName.includes(this.searchQuery)) {
                            return false;
                        }
                    }

                    return true;
                });
            },

            renderActionButtons(inv, isModal = false) {
                const meta = getDistInvoiceMeta(inv);
                const btnSize = isModal ? 'px-3 py-1.5 text-xs' : 'px-2.5 py-1 text-[11px]';

                if (meta.code === 0) {
                    return `
                        <button type="button" onclick="distInvoiceApp.updateStatus(${inv.id}, 'issue')" class="${btnSize} rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold transition-all">
                            Terbitkan
                        </button>
                        <button type="button" onclick="distInvoiceApp.updateStatus(${inv.id}, 'cancel')" class="${btnSize} rounded-lg bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800 font-bold hover:bg-rose-100 transition-all">
                            Batalkan
                        </button>
                    `;
                }
                if (meta.code === 1) {
                    return `
                        <button type="button" onclick="distInvoiceApp.updateStatus(${inv.id}, 'submit_payment')" class="${btnSize} rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-bold transition-all">
                            Catat Bayar
                        </button>
                        <button type="button" onclick="distInvoiceApp.updateStatus(${inv.id}, 'confirm_payment')" class="${btnSize} rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold transition-all">
                            Tandai Lunas
                        </button>
                    `;
                }
                if (meta.code === 2) {
                    return `
                        <button type="button" onclick="distInvoiceApp.updateStatus(${inv.id}, 'confirm_payment')" class="${btnSize} rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold transition-all">
                            Validasi Lunas
                        </button>
                        <button type="button" onclick="distInvoiceApp.updateStatus(${inv.id}, 'reject_payment')" class="${btnSize} rounded-lg bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800 font-bold hover:bg-rose-100 transition-all">
                            Tolak Bukti
                        </button>
                    `;
                }
                return '';
            },

            renderTable() {
                const tbody = document.getElementById('distInvoicesTableBody');
                const list = this.getFiltered();

                if (!list.length) {
                    tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Tidak ada faktur penagihan pelanggan yang sesuai.</td></tr>`;
                    document.getElementById('distTableInfo').textContent = 'Menampilkan 0 faktur';
                    return;
                }

                tbody.innerHTML = list.map((inv, idx) => {
                    const meta = getDistInvoiceMeta(inv);
                    const statusBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border ${meta.badgeClass}">${meta.label}</span>`;

                    const distName = inv.distributor?.name || inv.customer?.name || 'Distributor Rekanan #' + (inv.distributor_id || '-');
                    const invNo = inv.invoice_number || ('INV-#' + inv.id);
                    const invDate = inv.invoice_date || (inv.created_at ? new Date(inv.created_at).toLocaleDateString('id-ID') : '-');
                    const dueDate = inv.due_date ? new Date(inv.due_date).toLocaleDateString('id-ID') : '-';
                    const itemsCount = (inv.items && inv.items.length) ? inv.items.length : (inv.total_products || 0);
                    const totalAmt = parseFloat(inv.grand_total_amount || inv.total_amount || 0).toLocaleString('id-ID');

                    return `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="py-3.5 pl-6 font-bold text-slate-500">
                                ${idx + 1}
                            </td>
                            <td class="py-3.5">
                                <div class="font-mono font-bold text-blue-600 dark:text-blue-400">${invNo}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">Tgl: ${invDate}</div>
                            </td>
                            <td class="py-3.5">
                                <div class="font-bold text-slate-800 dark:text-slate-100">${distName}</div>
                                <div class="text-[11px] text-slate-400 font-mono">ID: ${inv.distributor_id || '-'}</div>
                            </td>
                            <td class="py-3.5">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold text-[11px]">
                                    <iconify-icon icon="solar:box-minimalistic-bold" class="text-blue-500"></iconify-icon>
                                    ${itemsCount} Produk
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
                                <div class="inline-flex flex-wrap items-center justify-end gap-1.5">
                                    ${this.renderActionButtons(inv, false)}
                                    <button type="button" onclick="distInvoiceApp.openModal(${inv.id})" class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-slate-700 text-blue-600 dark:text-blue-400 font-bold hover:bg-blue-100 transition-all text-[11px]">
                                        Detail
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');

                document.getElementById('distTableInfo').textContent = `Menampilkan ${list.length} dari ${this.invoices.length} faktur`;
            },

            openCreateModal() {
                document.getElementById('createDistInvoiceForm').reset();
                const today = new Date();
                const due = new Date();
                due.setDate(today.getDate() + 14);
                document.getElementById('createInvDate').value = today.toISOString().split('T')[0];
                document.getElementById('createInvDueDate').value = due.toISOString().split('T')[0];
                document.getElementById('createInvStatus').value = '1';
                document.getElementById('createInvItemsBody').innerHTML = '';
                this.addCreateItemRow();
                this.recalcCreateTotals();
                document.getElementById('distInvoiceCreateModal').classList.remove('hidden');
            },

            closeCreateModal() {
                document.getElementById('distInvoiceCreateModal').classList.add('hidden');
            },

            addCreateItemRow() {
                const tbody = document.getElementById('createInvItemsBody');
                const tr = document.createElement('tr');
                tr.className = 'create-inv-item-row';

                const prodOptions = '<option value="">-- Pilih dari Katalog (atau ketik manual di bawah) --</option>' +
                    this.products.map(p => {
                        const price = p.default_price || p.base_price || p.price || 0;
                        const sku = p.code || p.sku || ('SKU-' + p.id);
                        return `<option value="${p.id}" data-name="${(p.name || '').replace(/"/g, '&quot;')}" data-sku="${sku}" data-price="${price}" data-weight="${p.weight_kg || p.weight || 0}" data-volume="${p.volume_m3 || 0}">[${sku}] ${p.name} — Rp ${Number(price).toLocaleString('id-ID')}</option>`;
                    }).join('');

                tr.innerHTML = `
                    <td class="py-2.5 pl-4 font-bold text-slate-500 item-row-no">1</td>
                    <td class="py-2.5 pr-2 space-y-1.5">
                        <select onchange="distInvoiceApp.onProductSelectChange(this)" class="item-prod-select w-full px-2.5 py-1.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-xs">
                            ${prodOptions}
                        </select>
                        <input type="text" required placeholder="Nama produk / deskripsi tagihan..." class="item-prod-name w-full px-2.5 py-1.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-xs font-semibold" />
                        <input type="hidden" class="item-prod-sku" value="" />
                    </td>
                    <td class="py-2.5 px-2 text-center align-top">
                        <input type="number" min="1" value="1" required oninput="distInvoiceApp.recalcCreateTotals()" class="item-prod-qty w-20 px-2 py-1.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-center font-bold text-xs" />
                    </td>
                    <td class="py-2.5 px-2 text-right align-top">
                        <input type="number" min="0" step="100" value="0" required oninput="distInvoiceApp.recalcCreateTotals()" class="item-prod-price w-36 px-2.5 py-1.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-right font-mono font-bold text-xs" />
                    </td>
                    <td class="py-2.5 px-2 text-right font-mono font-bold text-slate-800 dark:text-slate-100 align-top pt-4 item-prod-subtotal">
                        Rp 0
                    </td>
                    <td class="py-2.5 pr-4 text-center align-top pt-3.5">
                        <button type="button" onclick="distInvoiceApp.removeCreateItemRow(this)" class="text-slate-400 hover:text-rose-600">
                            <iconify-icon icon="solar:trash-bin-trash-bold" class="text-base"></iconify-icon>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
                this.renumberCreateItemRows();
                this.recalcCreateTotals();
            },

            removeCreateItemRow(btn) {
                const rows = document.querySelectorAll('#createInvItemsBody tr');
                if (rows.length <= 1) return;
                btn.closest('tr')?.remove();
                this.renumberCreateItemRows();
                this.recalcCreateTotals();
            },

            renumberCreateItemRows() {
                document.querySelectorAll('#createInvItemsBody tr').forEach((tr, idx) => {
                    const noCell = tr.querySelector('.item-row-no');
                    if (noCell) noCell.textContent = idx + 1;
                });
            },

            onProductSelectChange(selectEl) {
                const tr = selectEl.closest('tr');
                const opt = selectEl.options[selectEl.selectedIndex];
                if (!tr || !opt) return;

                const nameInput = tr.querySelector('.item-prod-name');
                const skuInput = tr.querySelector('.item-prod-sku');
                const priceInput = tr.querySelector('.item-prod-price');

                if (opt.value) {
                    if (nameInput) nameInput.value = opt.getAttribute('data-name') || '';
                    if (skuInput) skuInput.value = opt.getAttribute('data-sku') || '';
                    if (priceInput) priceInput.value = opt.getAttribute('data-price') || 0;
                }
                this.recalcCreateTotals();
            },

            recalcCreateTotals() {
                let subtotal = 0;
                document.querySelectorAll('#createInvItemsBody tr').forEach(tr => {
                    const qty = parseFloat(tr.querySelector('.item-prod-qty')?.value || 0);
                    const price = parseFloat(tr.querySelector('.item-prod-price')?.value || 0);
                    const lineSub = Math.max(0, qty * price);
                    subtotal += lineSub;
                    const subEl = tr.querySelector('.item-prod-subtotal');
                    if (subEl) subEl.textContent = 'Rp ' + lineSub.toLocaleString('id-ID');
                });
                const tax = Math.round(subtotal * 0.11);
                const grandTotal = subtotal + tax;

                document.getElementById('createInvSubtotalDisplay').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                document.getElementById('createInvTaxDisplay').textContent = 'Rp ' + tax.toLocaleString('id-ID');
                document.getElementById('createInvGrandTotalDisplay').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
            },

            async submitCreateInvoice(e) {
                e.preventDefault();
                const distId = document.getElementById('createInvDistributorId').value;
                if (!distId) {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan pilih Pelanggan / Distributor.' });
                    return;
                }

                const items = [];
                document.querySelectorAll('#createInvItemsBody tr').forEach(tr => {
                    const prodId = tr.querySelector('.item-prod-select')?.value;
                    const name = (tr.querySelector('.item-prod-name')?.value || '').trim();
                    const sku = (tr.querySelector('.item-prod-sku')?.value || '').trim();
                    const qty = parseInt(tr.querySelector('.item-prod-qty')?.value || 0);
                    const price = parseFloat(tr.querySelector('.item-prod-price')?.value || 0);
                    if (name && qty > 0) {
                        items.push({
                            corporate_product_id: prodId ? parseInt(prodId) : 0,
                            product_name: name,
                            sku: sku || ('SKU-ITEM-' + (items.length + 1)),
                            qty_received: qty,
                            unit_price: price
                        });
                    }
                });

                if (!items.length) {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Tambahkan minimal 1 item produk dengan nama dan kuantitas valid.' });
                    return;
                }

                const payload = {
                    distributor_id: parseInt(distId),
                    invoice_date: document.getElementById('createInvDate').value,
                    due_date: document.getElementById('createInvDueDate').value,
                    status: parseInt(document.getElementById('createInvStatus').value),
                    tax_type: 1,
                    notes: document.getElementById('createInvNotes').value || null,
                    items
                };

                const btn = document.getElementById('btnSubmitCreateInv');
                btn.disabled = true;

                try {
                    await axios.post('/api/finance/distributor-invoices', payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Faktur penagihan customer berhasil dibuat.', timer: 1600, showConfirmButton: false });
                    this.closeCreateModal();
                    await this.loadData();
                } catch (err) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: err.response?.data?.message || 'Gagal membuat faktur penagihan.' });
                } finally {
                    btn.disabled = false;
                }
            },

            async updateStatus(id, action) {
                const actionMeta = {
                    issue: {
                        title: 'Terbitkan Faktur?',
                        text: 'Faktur Draft akan diterbitkan menjadi tagihan aktif (Belum Lunas) kepada customer.',
                        confirmText: 'Ya, Terbitkan'
                    },
                    submit_payment: {
                        title: 'Catat Bukti Pembayaran Customer',
                        text: 'Masukkan nomor referensi transfer / catatan pembayaran customer untuk diajukan ke validasi Finance:',
                        input: 'text',
                        inputPlaceholder: 'Contoh: TRF-BCA-20261103 / Bukti Transfer Lunas',
                        confirmText: 'Simpan Bukti Bayar'
                    },
                    confirm_payment: {
                        title: 'Konfirmasi Pelunasan Faktur?',
                        text: 'Faktur akan ditandai Lunas (Terkonfirmasi) dan piutang dinyatakan selesai.',
                        confirmText: 'Ya, Konfirmasi Lunas'
                    },
                    reject_payment: {
                        title: 'Tolak Bukti Pembayaran?',
                        text: 'Masukkan alasan penolakan bukti bayar (status kembali ke Belum Lunas):',
                        input: 'text',
                        inputPlaceholder: 'Contoh: Nominal tidak sesuai / bukti buram',
                        confirmText: 'Tolak Bukti'
                    },
                    cancel: {
                        title: 'Batalkan Faktur?',
                        text: 'Faktur penagihan ini akan dibatalkan.',
                        confirmText: 'Ya, Batalkan'
                    }
                }[action] || { title: 'Perbarui Status?', text: 'Lanjutkan perubahan status faktur?', confirmText: 'Ya' };

                const swalConfig = {
                    title: actionMeta.title,
                    text: actionMeta.text,
                    icon: action === 'cancel' || action === 'reject_payment' ? 'warning' : 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: actionMeta.confirmText,
                    cancelButtonText: 'Batal'
                };

                if (actionMeta.input) {
                    swalConfig.input = actionMeta.input;
                    swalConfig.inputPlaceholder = actionMeta.inputPlaceholder;
                }

                const res = await Swal.fire(swalConfig);
                if (!res.isConfirmed) return;

                const payload = {
                    action,
                    notes: typeof res.value === 'string' && res.value.trim() ? res.value.trim() : undefined,
                    payment_proof: action === 'submit_payment' && typeof res.value === 'string' && res.value.trim() ? res.value.trim() : undefined
                };

                try {
                    await axios.put(`/api/finance/distributor-invoices/${id}/status`, payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Status faktur penagihan berhasil diperbarui.', timer: 1400, showConfirmButton: false });
                    await this.loadData();
                    if (this.activeModalId === id) {
                        await this.openModal(id);
                    }
                } catch (err) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: err.response?.data?.message || 'Gagal memperbarui status faktur.' });
                }
            },

            async openModal(id) {
                this.activeModalId = id;
                const modal = document.getElementById('distInvoiceModal');
                modal.classList.remove('hidden');

                document.getElementById('distModalInvNumber').textContent = 'Memuat...';
                document.getElementById('distModalItemsBody').innerHTML = `<tr><td colspan="6" class="py-6 text-center text-slate-400">Memuat rincian produk...</td></tr>`;
                document.getElementById('distModalWorkflowActions').innerHTML = '';

                try {
                    const res = await axios.get(`/api/internal/corporate/finance/distributor-invoices/${id}`);
                    const inv = res.data?.data || res.data;

                    document.getElementById('distModalInvNumber').textContent = inv.invoice_number || ('INV-#' + inv.id);
                    document.getElementById('distModalCustomerSubtitle').textContent = `Pelanggan: ${inv.distributor?.name || inv.customer?.name || ('Distributor #' + inv.distributor_id)}`;

                    const meta = getDistInvoiceMeta(inv);
                    const badge = `<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border ${meta.badgeClass}">${meta.label}</span>`;
                    document.getElementById('distModalStatusBadge').outerHTML = `<span id="distModalStatusBadge">${badge}</span>`;

                    document.getElementById('distModalDate').textContent = inv.invoice_date || (inv.created_at ? new Date(inv.created_at).toLocaleDateString('id-ID') : '-');
                    document.getElementById('distModalDueDate').textContent = inv.due_date ? new Date(inv.due_date).toLocaleDateString('id-ID') : '-';
                    document.getElementById('distModalGrandTotal').textContent = 'Rp ' + parseFloat(inv.grand_total_amount || inv.total_amount || 0).toLocaleString('id-ID');
                    const hasTonnage = (parseFloat(inv.total_tonnage || 0) > 0 || parseFloat(inv.total_cubage || 0) > 0);
                    document.getElementById('distModalTonnage').textContent = hasTonnage
                        ? `${parseFloat(inv.total_tonnage || 0)} Ton / ${parseFloat(inv.total_cubage || 0)} CBM`
                        : '-';

                    // Render items with No column and dynamic Discount column
                    const items = inv.items || [];
                    const tbody = document.getElementById('distModalItemsBody');
                    const thead = document.getElementById('distModalItemsHead');
                    const hasDiscount = items.some(it => parseFloat(it.discount_amount || 0) > 0);

                    if (thead) {
                        thead.innerHTML = `
                            <tr>
                                <th class="py-2.5 pl-4 w-10">No</th>
                                <th class="py-2.5">Nama Produk &amp; SKU</th>
                                <th class="py-2.5 text-center">Qty Diterima</th>
                                <th class="py-2.5 text-right">Harga Satuan (Rp)</th>
                                ${hasDiscount ? '<th class="py-2.5 text-right">Diskon (Rp)</th>' : ''}
                                <th class="py-2.5 pr-4 text-right">Subtotal (Rp)</th>
                            </tr>
                        `;
                    }

                    if (!items.length) {
                        const colCount = hasDiscount ? 6 : 5;
                        tbody.innerHTML = `<tr><td colspan="${colCount}" class="py-6 text-center text-slate-400">Tidak ada rincian produk pesanan.</td></tr>`;
                    } else {
                        tbody.innerHTML = items.map((it, idx) => {
                            const unitPrice = parseFloat(it.unit_price || 0).toLocaleString('id-ID');
                            const discount = parseFloat(it.discount_amount || 0).toLocaleString('id-ID');
                            const subtotal = parseFloat(it.subtotal || (it.qty_received * it.unit_price) || 0).toLocaleString('id-ID');

                            return `
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                    <td class="py-2.5 pl-4 font-bold text-slate-500">${idx + 1}</td>
                                    <td class="py-2.5">
                                        <div class="font-bold text-slate-800 dark:text-slate-100">${it.product_name || 'Produk Korporasi'}</div>
                                        <div class="font-mono text-[10px] text-slate-400">SKU: ${it.sku || '-'}</div>
                                    </td>
                                    <td class="py-2.5 text-center font-mono font-bold">${it.qty_received || it.qty || 0}</td>
                                    <td class="py-2.5 text-right font-mono">Rp ${unitPrice}</td>
                                    ${hasDiscount ? `<td class="py-2.5 text-right font-mono text-rose-500">Rp ${discount}</td>` : ''}
                                    <td class="py-2.5 pr-4 text-right font-mono font-bold text-slate-800 dark:text-slate-100">Rp ${subtotal}</td>
                                </tr>
                            `;
                        }).join('');
                    }

                    // Payment proof & validation status
                    const proofContent = document.getElementById('distModalPaymentProofContent');
                    if (meta.code === 3) {
                        proofContent.innerHTML = `
                            <div class="space-y-1">
                                <div class="font-bold text-emerald-700 dark:text-emerald-400">Status: Lunas &amp; Terkonfirmasi</div>
                                <div class="text-[11px] text-slate-600 dark:text-slate-300">Catatan: ${inv.payment_proof_notes || inv.notes || 'Pembayaran telah divalidasi lunas oleh Finance Corporate.'}</div>
                                <div class="text-[11px] text-slate-500">Divalidasi oleh: ${inv.payment_proof_validated_by || 'Finance Corporate'} (${inv.payment_proof_validated_at || '-'})</div>
                            </div>
                        `;
                    } else if (meta.code === 2) {
                        proofContent.innerHTML = `
                            <div class="space-y-1">
                                <div class="font-bold text-indigo-700 dark:text-indigo-400">Status: Bukti Pembayaran Diterima — Menunggu Validasi Finance</div>
                                <div class="text-[11px] text-slate-600 dark:text-slate-300">Catatan Bukti: ${inv.payment_proof_notes || 'Bukti transfer telah diunggah'}</div>
                                <div class="text-[11px] text-slate-500">Diunggah pada: ${inv.payment_proof_uploaded_at || '-'}</div>
                            </div>
                        `;
                    } else if (parseInt(inv.payment_proof_status) === 3) {
                        proofContent.innerHTML = `
                            <div class="space-y-1">
                                <div class="font-bold text-rose-600">Bukti Pembayaran Sebelumnya Ditolak</div>
                                <div class="text-[11px] text-slate-500">Alasan: ${inv.payment_proof_notes || 'Mohon unggah ulang bukti pembayaran yang valid.'}</div>
                            </div>
                        `;
                    } else {
                        proofContent.innerHTML = `<span class="italic text-slate-400">Customer / Distributor belum mengirimkan bukti pembayaran untuk faktur ini.</span>`;
                    }

                    // Render contextual workflow buttons in modal footer
                    document.getElementById('distModalWorkflowActions').innerHTML = this.renderActionButtons(inv, true);

                } catch (err) {
                    console.error('Fetch dist invoice detail error:', err);
                }
            },

            closeModal() {
                this.activeModalId = null;
                document.getElementById('distInvoiceModal').classList.add('hidden');
            }
        };

        document.addEventListener('DOMContentLoaded', () => distInvoiceApp.init());
    </script>
    @endpush
</x-layout.app>
