<x-layout.app title="Master Rekening Bank & Kemitraan VA | Corporate Merchant Portal">
    <div class="space-y-6">

        <!-- Page Header -->
        <div class="card bg-white dark:bg-slate-800 p-5 md:p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 text-xs font-semibold mb-2">
                        <iconify-icon icon="solar:card-2-bold-duotone" class="text-sm"></iconify-icon>
                        Corporate Merchant Cash & Bank Management
                    </div>
                    <h1 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                        Master Rekening Bank & Kemitraan (VA)
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Kelola rekening bank resmi korporasi untuk penerimaan pembayaran faktur distributor, integrasi Virtual Account perbankan, dan keterikatan COA Akuntansi.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                    <button type="button" onclick="corpBankApp.loadAccounts()" class="!bg-white dark:!bg-slate-700 hover:!bg-slate-50 dark:hover:!bg-slate-600 !text-slate-700 dark:!text-slate-200 py-2 px-3.5 rounded-lg flex items-center gap-1.5 text-xs font-semibold border border-slate-300 dark:border-slate-600 shadow-xs transition-colors">
                        <iconify-icon icon="solar:refresh-linear" class="text-base !text-slate-700 dark:!text-slate-200"></iconify-icon>
                        <span>{{ __('Refresh Data') }}</span>
                    </button>
                    <button type="button" onclick="corpBankApp.openCreateModal()" class="btn bg-blue-900 hover:bg-blue-800 text-white py-2 px-4 rounded-lg flex items-center gap-1.5 text-xs font-semibold shadow-xs transition-colors">
                        <iconify-icon icon="solar:add-circle-linear" class="text-base"></iconify-icon>
                        {{ __('Tambah Rekening Bank') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Accounts -->
            <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Total Rekening</p>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mt-1" id="statTotalAccounts">0</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <iconify-icon icon="solar:wallet-money-bold-duotone" class="text-xl"></iconify-icon>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-2">Rekening terverifikasi korporasi</p>
            </div>

            <!-- Default Account -->
            <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Rekening Utama</p>
                        <h3 class="text-base font-bold text-amber-600 dark:text-amber-400 mt-1 truncate max-w-[140px]" id="statDefaultAccount">-</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <iconify-icon icon="solar:star-bold-duotone" class="text-xl"></iconify-icon>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-2">Tujuan default faktur distributor</p>
            </div>

            <!-- Bank Partnership / VA -->
            <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Kemitraan Bank / VA</p>
                        <h3 class="text-xl font-bold text-emerald-600 dark:text-emerald-400 mt-1" id="statPartnershipCount">0</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <iconify-icon icon="solar:shield-check-bold-duotone" class="text-xl"></iconify-icon>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-2">Dukungan Virtual Account aktif</p>
            </div>

            <!-- Tied to COA -->
            <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Buku Besar Akuntansi</p>
                        <h3 class="text-xl font-bold text-purple-600 dark:text-purple-400 mt-1" id="statCoaLinkedCount">0</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                        <iconify-icon icon="solar:document-text-bold-duotone" class="text-xl"></iconify-icon>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-2">Terhubung ke COA Kas & Bank (1000)</p>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="card bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex flex-1 items-center gap-2 max-w-md">
                    <div class="relative w-full">
                        <iconify-icon icon="solar:magnifer-linear" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></iconify-icon>
                        <input type="text" id="bankSearchInput" onkeyup="corpBankApp.handleSearch(event)" placeholder="Cari nama bank, no. rekening, atas nama..." class="w-full pl-9 pr-3.5 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" onclick="corpBankApp.setFilter('all')" class="tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-blue-900 text-white" id="filterBtnAll">
                        Semua
                    </button>
                    <button type="button" onclick="corpBankApp.setFilter('active')" class="tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200" id="filterBtnActive">
                        Aktif Saja
                    </button>
                    <button type="button" onclick="corpBankApp.setFilter('partnership')" class="tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200" id="filterBtnPartnership">
                        Kemitraan VA
                    </button>
                </div>
            </div>
        </div>

        <!-- Bank Accounts Card Grid & List -->
        <div id="bankAccountsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <!-- Loading Skeletons -->
            <div class="col-span-full py-12 text-center text-slate-400">
                <iconify-icon icon="solar:restart-circle-bold-duotone" class="text-3xl animate-spin text-blue-500 mb-2"></iconify-icon>
                <p class="text-xs">Memuat data master rekening bank...</p>
            </div>
        </div>

    </div>

    <!-- Create / Edit Modal -->
    <div id="bankAccountModal" class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white dark:bg-slate-800 rounded-2xl max-w-xl w-full border border-slate-200 dark:border-slate-700 shadow-xl overflow-hidden flex flex-col max-h-[90vh]">
            <!-- Modal Header -->
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/50 shrink-0">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 text-blue-900 dark:text-blue-400 flex items-center justify-center">
                        <iconify-icon icon="solar:card-2-bold-duotone" class="text-lg"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white" id="modalTitle">Tambah Rekening Bank Baru</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Konfigurasi rekening korporasi, kemitraan VA, dan keterikatan COA.</p>
                    </div>
                </div>
                <button type="button" onclick="corpBankApp.closeModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1 rounded-lg">
                    <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                </button>
            </div>

            <!-- Modal Body (Scrollable) -->
            <form id="bankAccountForm" onsubmit="corpBankApp.handleSubmit(event)" class="p-5 overflow-y-auto space-y-4 text-xs">
                <input type="hidden" id="bankAccountId">

                <!-- Bank Selection Quick Presets -->
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Pilih Bank Cepat (Presets)
                    </label>
                    <div class="grid grid-cols-4 sm:grid-cols-7 gap-1.5">
                        <button type="button" onclick="corpBankApp.selectPresetBank('BCA', '014')" class="preset-btn px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-center hover:border-blue-500 transition-colors">
                            <span class="block font-bold text-slate-800 dark:text-slate-200">BCA</span>
                            <span class="block text-[9px] text-slate-400">014</span>
                        </button>
                        <button type="button" onclick="corpBankApp.selectPresetBank('Mandiri', '008')" class="preset-btn px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-center hover:border-blue-500 transition-colors">
                            <span class="block font-bold text-slate-800 dark:text-slate-200">Mandiri</span>
                            <span class="block text-[9px] text-slate-400">008</span>
                        </button>
                        <button type="button" onclick="corpBankApp.selectPresetBank('BRI', '002')" class="preset-btn px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-center hover:border-blue-500 transition-colors">
                            <span class="block font-bold text-slate-800 dark:text-slate-200">BRI</span>
                            <span class="block text-[9px] text-slate-400">002</span>
                        </button>
                        <button type="button" onclick="corpBankApp.selectPresetBank('BNI', '009')" class="preset-btn px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-center hover:border-blue-500 transition-colors">
                            <span class="block font-bold text-slate-800 dark:text-slate-200">BNI</span>
                            <span class="block text-[9px] text-slate-400">009</span>
                        </button>
                        <button type="button" onclick="corpBankApp.selectPresetBank('Permata', '013')" class="preset-btn px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-center hover:border-blue-500 transition-colors">
                            <span class="block font-bold text-slate-800 dark:text-slate-200">Permata</span>
                            <span class="block text-[9px] text-slate-400">013</span>
                        </button>
                        <button type="button" onclick="corpBankApp.selectPresetBank('CIMB Niaga', '022')" class="preset-btn px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-center hover:border-blue-500 transition-colors">
                            <span class="block font-bold text-slate-800 dark:text-slate-200">CIMB</span>
                            <span class="block text-[9px] text-slate-400">022</span>
                        </button>
                        <button type="button" onclick="corpBankApp.selectPresetBank('BSI', '451')" class="preset-btn px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-center hover:border-blue-500 transition-colors">
                            <span class="block font-bold text-slate-800 dark:text-slate-200">BSI</span>
                            <span class="block text-[9px] text-slate-400">451</span>
                        </button>
                    </div>
                </div>

                <!-- Bank Name & Bank Code -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            Nama Bank <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputBankName" required placeholder="Contoh: BCA, Mandiri, BRI" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            Kode Kliring <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputBankCode" required placeholder="014" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 font-mono focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Account Number & Account Holder -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            Nomor Rekening <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputAccountNumber" required placeholder="Contoh: 8271092819" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            Atas Nama (Pemilik) <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputAccountHolder" required placeholder="Nama PT / Pemilik Rekening" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Branch & SWIFT -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            Kantor Cabang
                        </label>
                        <input type="text" id="inputBranch" placeholder="Contoh: KCU Sudirman Jakarta" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            SWIFT / BIC Code
                        </label>
                        <input type="text" id="inputSwiftCode" placeholder="CENAIDJA (opsional)" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 font-mono uppercase focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- COA Binding (Akuntansi Kas & Bank) -->
                <div class="p-3 bg-purple-50/60 dark:bg-purple-950/20 rounded-xl border border-purple-200 dark:border-purple-800/40 space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="block font-bold text-purple-900 dark:text-purple-300">
                            Keterikatan Buku Besar COA (Chart of Accounts)
                        </label>
                        <span class="text-[10px] text-purple-700 dark:text-purple-400 font-semibold bg-purple-100 dark:bg-purple-900/50 px-2 py-0.5 rounded">
                            Klasifikasi Kas & Bank
                        </span>
                    </div>
                    <select id="inputAccountId" class="w-full px-3 py-2 rounded-lg border border-purple-200 dark:border-purple-800/60 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 font-mono focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">-- [Auto] Buat Akun COA Kas & Bank Baru Otomatis --</option>
                    </select>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400">
                        Pilih akun COA kas/bank yang sudah ada, atau biarkan kosong agar sistem secara otomatis membuat akun buku besar anak di bawah header COA 1000.
                    </p>
                </div>

                <!-- Bank Partnership & Virtual Account Section -->
                <div class="p-3.5 bg-emerald-50/60 dark:bg-emerald-950/20 rounded-xl border border-emerald-200 dark:border-emerald-800/40 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="block font-bold text-emerald-900 dark:text-emerald-300">
                                Kemitraan Bank (Virtual Account / H2H SNAP)
                            </span>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400">
                                Aktifkan jika bank ini terhubung ke integrasi Virtual Account otomatis untuk penagihan distributor.
                            </span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="inputIsPartnership" onchange="corpBankApp.togglePartnershipFields()" class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>

                    <div id="partnershipFields" class="hidden space-y-3 pt-2 border-t border-emerald-200/60 dark:border-emerald-800/40">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                    Penyedia Kemitraan
                                </label>
                                <select id="inputPartnershipProvider" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100">
                                    <option value="BCA_SNAP">BCA SNAP H2H</option>
                                    <option value="MANDIRI_H2H">Mandiri H2H</option>
                                    <option value="BRI_DIRECT">BRI Direct API</option>
                                    <option value="BNI_SMARTPAY">BNI SmartPay</option>
                                    <option value="XENDIT">Xendit Gateway</option>
                                    <option value="MIDTRANS">Midtrans Gateway</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                    Tipe Pembayaran
                                </label>
                                <select id="inputPartnershipType" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100">
                                    <option value="virtual_account">Virtual Account (VA)</option>
                                    <option value="direct_debit">Direct Debit</option>
                                    <option value="qris">QRIS Dinamis</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                    Prefix VA Bank
                                </label>
                                <input type="text" id="inputVaPrefix" placeholder="Contoh: 12903" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 font-mono">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings: Default & Active -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="inputIsDefault" class="rounded border-slate-300 text-blue-900 focus:ring-blue-900">
                        <span class="font-semibold text-slate-700 dark:text-slate-300">Jadikan Rekening Utama (Default Faktur Distributor)</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="inputIsActive" checked class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="font-semibold text-slate-700 dark:text-slate-300">Status Aktif</span>
                    </label>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">Catatan Tambahan</label>
                    <textarea id="inputNotes" rows="2" placeholder="Informasi internal atau instruksi pencairan kas..." class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100"></textarea>
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-200 dark:border-slate-700">
                    <button type="button" onclick="corpBankApp.closeModal()" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmit" class="px-5 py-2 rounded-lg bg-blue-900 hover:bg-blue-800 text-white font-semibold transition-colors flex items-center gap-1.5 shadow-sm">
                        <iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon>
                        <span>Simpan Rekening</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Client-side Logic -->
    <script>
        const corpBankApp = {
            accounts: [],
            coaAccounts: [],
            currentFilter: 'all',

            init() {
                this.loadCoaOptions();
                this.loadAccounts();
            },

            async loadCoaOptions() {
                try {
                    const res = await fetch('/api/internal/corporate/finance/bank-accounts/coa-options');
                    const json = await res.json();
                    if (json.status === 'success' && Array.isArray(json.data)) {
                        this.coaAccounts = json.data;
                        const select = document.getElementById('inputAccountId');
                        select.innerHTML = '<option value="">-- [Auto] Buat Akun COA Kas & Bank Baru Otomatis --</option>';
                        this.coaAccounts.forEach(acc => {
                            const opt = document.createElement('option');
                            opt.value = acc.id;
                            opt.textContent = `${acc.code} - ${acc.name}`;
                            select.appendChild(opt);
                        });
                    }
                } catch (e) {
                    console.warn('Failed to load COA accounts:', e);
                }
            },

            async loadAccounts() {
                const container = document.getElementById('bankAccountsContainer');
                container.innerHTML = `
                    <div class="col-span-full py-12 text-center text-slate-400">
                        <iconify-icon icon="solar:restart-circle-bold-duotone" class="text-3xl animate-spin text-blue-500 mb-2"></iconify-icon>
                        <p class="text-xs">Memuat data rekening bank korporasi...</p>
                    </div>
                `;

                try {
                    const res = await fetch('/api/internal/corporate/finance/bank-accounts');
                    const json = await res.json();
                    if (json.status === 'success') {
                        this.accounts = Array.isArray(json.data) ? json.data : [];
                        this.renderStats();
                        this.renderCards();
                    } else {
                        container.innerHTML = `
                            <div class="col-span-full py-10 text-center text-rose-500">
                                Gagal memuat data: ${json.message || 'Error'}
                            </div>
                        `;
                    }
                } catch (e) {
                    container.innerHTML = `
                        <div class="col-span-full py-10 text-center text-rose-500">
                            Terjadi kesalahan koneksi server.
                        </div>
                    `;
                }
            },

            renderStats() {
                document.getElementById('statTotalAccounts').textContent = this.accounts.length;
                
                const def = this.accounts.find(a => a.is_default);
                document.getElementById('statDefaultAccount').textContent = def ? `${def.bank_name}` : 'Belum Ada';

                const partnerships = this.accounts.filter(a => a.is_partnership);
                document.getElementById('statPartnershipCount').textContent = partnerships.length;

                const coaLinked = this.accounts.filter(a => a.account_id || a.coa_account);
                document.getElementById('statCoaLinkedCount').textContent = coaLinked.length;
            },

            setFilter(filter) {
                this.currentFilter = filter;
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('bg-blue-900', 'text-white');
                    btn.classList.add('bg-slate-100', 'dark:bg-slate-700', 'text-slate-700', 'dark:text-slate-300');
                });
                
                const activeBtn = filter === 'all' ? document.getElementById('filterBtnAll') :
                                  filter === 'active' ? document.getElementById('filterBtnActive') :
                                  document.getElementById('filterBtnPartnership');
                activeBtn.classList.remove('bg-slate-100', 'dark:bg-slate-700', 'text-slate-700', 'dark:text-slate-300');
                activeBtn.classList.add('bg-blue-900', 'text-white');

                this.renderCards();
            },

            handleSearch(e) {
                this.renderCards();
            },

            getFilteredAccounts() {
                const keyword = (document.getElementById('bankSearchInput')?.value || '').toLowerCase().trim();
                return this.accounts.filter(acc => {
                    if (this.currentFilter === 'active' && !acc.is_active) return false;
                    if (this.currentFilter === 'partnership' && !acc.is_partnership) return false;

                    if (keyword) {
                        const matchBank = (acc.bank_name || '').toLowerCase().includes(keyword);
                        const matchNumber = (acc.account_number || '').toLowerCase().includes(keyword);
                        const matchHolder = (acc.account_holder || '').toLowerCase().includes(keyword);
                        const matchVa = (acc.va_prefix || '').toLowerCase().includes(keyword);
                        if (!matchBank && !matchNumber && !matchHolder && !matchVa) return false;
                    }
                    return true;
                });
            },

            renderCards() {
                const container = document.getElementById('bankAccountsContainer');
                const list = this.getFilteredAccounts();

                if (list.length === 0) {
                    container.innerHTML = `
                        <div class="col-span-full py-12 text-center text-slate-400 bg-white dark:bg-slate-800 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 p-8">
                            <iconify-icon icon="solar:card-search-linear" class="text-4xl text-slate-300 dark:text-slate-600 mb-2"></iconify-icon>
                            <p class="font-bold text-slate-700 dark:text-slate-300">Belum ada rekening bank yang sesuai kriteria.</p>
                            <p class="text-xs text-slate-400 mt-1">Silakan tambahkan rekening bank baru dengan menekan tombol di atas.</p>
                        </div>
                    `;
                    return;
                }

                container.innerHTML = list.map(acc => {
                    const isDefault = acc.is_default;
                    const isActive = acc.is_active;
                    const coa = acc.coa_account || {};
                    const coaDisplay = coa.code ? `${coa.code} - ${coa.name}` : (acc.account_id ? `COA ID: #${acc.account_id}` : 'Belum Ditautkan');

                    // Brand accents based on bank name
                    let bankTheme = 'from-blue-900 to-indigo-900 text-white';
                    const bName = (acc.bank_name || '').toUpperCase();
                    if (bName.includes('MANDIRI')) {
                        bankTheme = 'from-blue-950 via-sky-900 to-amber-700 text-white';
                    } else if (bName.includes('BRI')) {
                        bankTheme = 'from-blue-900 to-cyan-700 text-white';
                    } else if (bName.includes('BNI')) {
                        bankTheme = 'from-teal-800 to-orange-700 text-white';
                    } else if (bName.includes('BSI')) {
                        bankTheme = 'from-emerald-800 to-teal-900 text-white';
                    }

                    return `
                        <div class="card bg-white dark:bg-slate-800 rounded-2xl border ${isDefault ? 'border-amber-400 dark:border-amber-500 ring-2 ring-amber-400/20' : 'border-slate-200 dark:border-slate-700'} shadow-sm overflow-hidden flex flex-col justify-between transition-all hover:shadow-md">
                            <div>
                                <!-- Top Card Header / Virtual Card Visual -->
                                <div class="bg-gradient-to-r ${bankTheme} p-5 rounded-t-2xl relative overflow-hidden">
                                    <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full bg-white/10 pointer-events-none"></div>
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-2">
                                            <iconify-icon icon="solar:card-bold" class="text-2xl text-white/90"></iconify-icon>
                                            <span class="font-extrabold tracking-wider uppercase text-base text-white">${acc.bank_name}</span>
                                        </div>
                                        ${isDefault ? `
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-amber-950 flex items-center gap-1 shadow-xs">
                                                <iconify-icon icon="solar:star-bold"></iconify-icon> UTAMA
                                            </span>
                                        ` : `
                                            <button type="button" onclick="corpBankApp.setDefault(${acc.id})" title="Jadikan Rekening Utama" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/20 hover:bg-white/30 text-white transition-colors">
                                                Jadikan Utama
                                            </button>
                                        `}
                                    </div>

                                    <!-- Account Number -->
                                    <div class="flex items-center justify-between">
                                        <span class="font-mono text-lg font-bold tracking-widest text-white drop-shadow-xs">
                                            ${acc.account_number}
                                        </span>
                                        <button type="button" onclick="corpBankApp.copyToClipboard('${acc.account_number}')" title="Salin No. Rekening" class="p-1 rounded bg-white/20 hover:bg-white/30 text-white text-xs transition-colors">
                                            <iconify-icon icon="solar:copy-linear"></iconify-icon>
                                        </button>
                                    </div>

                                    <!-- Account Holder & Branch -->
                                    <div class="mt-3 flex items-center justify-between text-xs text-white/80">
                                        <span class="font-semibold uppercase truncate max-w-[170px]">${acc.account_holder}</span>
                                        <span class="text-[10px] text-white/70">${acc.branch || 'Pusat'}</span>
                                    </div>
                                </div>

                                <!-- Body Details -->
                                <div class="p-4 space-y-2.5 text-xs">
                                    <!-- COA Link -->
                                    <div class="flex items-center justify-between p-2 rounded-lg bg-purple-50/70 dark:bg-purple-950/30 border border-purple-100 dark:border-purple-900/40">
                                        <div class="flex items-center gap-1.5 text-purple-900 dark:text-purple-300">
                                            <iconify-icon icon="solar:document-text-bold" class="text-sm shrink-0"></iconify-icon>
                                            <span class="font-semibold text-[11px] truncate max-w-[210px]" title="${coaDisplay}">
                                                ${coaDisplay}
                                            </span>
                                        </div>
                                        <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-purple-200 dark:bg-purple-800 text-purple-800 dark:text-purple-200">
                                            COA
                                        </span>
                                    </div>

                                    <!-- Partnership Status -->
                                    <div class="flex items-center justify-between text-[11px]">
                                        <span class="text-slate-500 dark:text-slate-400">Kemitraan Perbankan:</span>
                                        ${acc.is_partnership ? `
                                            <span class="px-2 py-0.5 rounded font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 flex items-center gap-1">
                                                <iconify-icon icon="solar:verified-check-bold" class="text-xs"></iconify-icon>
                                                ${acc.partnership_provider || 'VA Active'} ${acc.va_prefix ? `(${acc.va_prefix})` : ''}
                                            </span>
                                        ` : `
                                            <span class="px-2 py-0.5 rounded font-medium bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                                Manual Transfer
                                            </span>
                                        `}
                                    </div>

                                    <!-- Status Active / Inactive -->
                                    <div class="flex items-center justify-between text-[11px]">
                                        <span class="text-slate-500 dark:text-slate-400">Status Operasional:</span>
                                        ${isActive ? `
                                            <span class="text-emerald-600 dark:text-emerald-400 font-bold flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                            </span>
                                        ` : `
                                            <span class="text-rose-500 font-bold flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                                            </span>
                                        `}
                                    </div>

                                    ${acc.notes ? `
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 italic bg-slate-50 dark:bg-slate-900/40 p-2 rounded border border-slate-100 dark:border-slate-800">
                                            "${acc.notes}"
                                        </p>
                                    ` : ''}
                                </div>
                            </div>

                            <!-- Footer Actions -->
                            <div class="px-4 py-3 bg-slate-50/70 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between">
                                <span class="text-[10px] text-slate-400 font-mono">ID: #${acc.id}</span>
                                <div class="flex items-center gap-1.5">
                                    <button type="button" onclick="corpBankApp.openEditModal(${acc.id})" class="px-2.5 py-1 rounded bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-200 hover:text-blue-600 font-semibold text-xs flex items-center gap-1 transition-colors">
                                        <iconify-icon icon="solar:pen-linear"></iconify-icon> Edit
                                    </button>
                                    <button type="button" onclick="corpBankApp.deleteAccount(${acc.id})" class="p-1 rounded text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 text-xs transition-colors" title="Hapus Rekening">
                                        <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            },

            selectPresetBank(name, code) {
                document.getElementById('inputBankName').value = name;
                document.getElementById('inputBankCode').value = code;
            },

            togglePartnershipFields() {
                const checked = document.getElementById('inputIsPartnership').checked;
                const fields = document.getElementById('partnershipFields');
                if (checked) {
                    fields.classList.remove('hidden');
                } else {
                    fields.classList.add('hidden');
                }
            },

            openCreateModal() {
                document.getElementById('bankAccountForm').reset();
                document.getElementById('bankAccountId').value = '';
                document.getElementById('modalTitle').textContent = 'Tambah Rekening Bank Baru';
                document.getElementById('inputIsActive').checked = true;
                document.getElementById('inputIsDefault').checked = false;
                document.getElementById('inputIsPartnership').checked = false;
                this.togglePartnershipFields();
                document.getElementById('bankAccountModal').classList.remove('hidden');
            },

            openEditModal(id) {
                const acc = this.accounts.find(a => a.id === id);
                if (!acc) return;

                document.getElementById('bankAccountId').value = acc.id;
                document.getElementById('modalTitle').textContent = `Edit Rekening: ${acc.bank_name} (${acc.account_number})`;
                document.getElementById('inputBankName').value = acc.bank_name || '';
                document.getElementById('inputBankCode').value = acc.bank_code || '';
                document.getElementById('inputAccountNumber').value = acc.account_number || '';
                document.getElementById('inputAccountHolder').value = acc.account_holder || '';
                document.getElementById('inputBranch').value = acc.branch || '';
                document.getElementById('inputSwiftCode').value = acc.swift_code || '';
                document.getElementById('inputAccountId').value = acc.account_id || '';
                document.getElementById('inputIsPartnership').checked = Boolean(acc.is_partnership);
                document.getElementById('inputPartnershipProvider').value = acc.partnership_provider || 'BCA_SNAP';
                document.getElementById('inputPartnershipType').value = acc.partnership_type || 'virtual_account';
                document.getElementById('inputVaPrefix').value = acc.va_prefix || '';
                document.getElementById('inputIsDefault').checked = Boolean(acc.is_default);
                document.getElementById('inputIsActive').checked = Boolean(acc.is_active);
                document.getElementById('inputNotes').value = acc.notes || '';

                this.togglePartnershipFields();
                document.getElementById('bankAccountModal').classList.remove('hidden');
            },

            closeModal() {
                document.getElementById('bankAccountModal').classList.add('hidden');
            },

            async handleSubmit(e) {
                e.preventDefault();
                const id = document.getElementById('bankAccountId').value;
                const isEdit = Boolean(id);

                const payload = {
                    bank_name: document.getElementById('inputBankName').value.trim(),
                    bank_code: document.getElementById('inputBankCode').value.trim(),
                    account_number: document.getElementById('inputAccountNumber').value.trim(),
                    account_holder: document.getElementById('inputAccountHolder').value.trim(),
                    branch: document.getElementById('inputBranch').value.trim() || null,
                    swift_code: document.getElementById('inputSwiftCode').value.trim() || null,
                    account_id: document.getElementById('inputAccountId').value || null,
                    is_partnership: document.getElementById('inputIsPartnership').checked,
                    partnership_provider: document.getElementById('inputIsPartnership').checked ? document.getElementById('inputPartnershipProvider').value : null,
                    partnership_type: document.getElementById('inputIsPartnership').checked ? document.getElementById('inputPartnershipType').value : null,
                    va_prefix: document.getElementById('inputIsPartnership').checked ? document.getElementById('inputVaPrefix').value.trim() : null,
                    is_default: document.getElementById('inputIsDefault').checked,
                    is_active: document.getElementById('inputIsActive').checked,
                    notes: document.getElementById('inputNotes').value.trim() || null,
                };

                const url = isEdit ? `/api/internal/corporate/finance/bank-accounts/${id}` : '/api/internal/corporate/finance/bank-accounts';
                const method = isEdit ? 'PUT' : 'POST';

                const btn = document.getElementById('btnSubmit');
                btn.disabled = true;
                btn.innerHTML = `<iconify-icon icon="solar:restart-circle-bold" class="animate-spin text-base"></iconify-icon> Menyimpan...`;

                try {
                    const res = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        },
                        body: JSON.stringify(payload),
                    });

                    const json = await res.json();
                    if (res.ok && json.status === 'success') {
                        this.closeModal();
                        await this.loadAccounts();
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Rekening bank berhasil disimpan.', timer: 1500, showConfirmButton: false });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: json.message || 'Gagal menyimpan rekening bank.' });
                    }
                } catch (err) {
                    Swal.fire({ icon: 'error', title: 'Kesalahan Jaringan', text: 'Terjadi kesalahan jaringan.' });
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = `<iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon> Simpan Rekening`;
                }
            },

            async setDefault(id) {
                const conf = await Swal.fire({
                    title: 'Jadikan Rekening Utama?',
                    text: 'Jadikan rekening ini sebagai rekening utama (default) faktur distributor?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#053363',
                    cancelButtonColor: '#6e7a89',
                    confirmButtonText: 'Ya, Jadikan Utama',
                    cancelButtonText: 'Batal'
                });
                if (!conf.isConfirmed) return;
                try {
                    const res = await fetch(`/api/internal/corporate/finance/bank-accounts/${id}/set-default`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        },
                    });
                    const json = await res.json();
                    if (res.ok && json.status === 'success') {
                        await this.loadAccounts();
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Rekening utama berhasil diperbarui.', timer: 1500, showConfirmButton: false });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: json.message || 'Gagal menetapkan rekening utama.' });
                    }
                } catch (e) {
                    Swal.fire({ icon: 'error', title: 'Kesalahan Koneksi', text: 'Terjadi kesalahan koneksi.' });
                }
            },

            async deleteAccount(id) {
                const conf = await Swal.fire({
                    title: 'Hapus Rekening?',
                    text: 'Apakah Anda yakin ingin menghapus rekening bank ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6e7a89',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                });
                if (!conf.isConfirmed) return;
                try {
                    const res = await fetch(`/api/internal/corporate/finance/bank-accounts/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        },
                    });
                    const json = await res.json();
                    if (res.ok && json.status === 'success') {
                        await this.loadAccounts();
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Rekening berhasil dihapus.', timer: 1500, showConfirmButton: false });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: json.message || 'Gagal menghapus rekening.' });
                    }
                } catch (e) {
                    Swal.fire({ icon: 'error', title: 'Kesalahan Koneksi', text: 'Terjadi kesalahan koneksi.' });
                }
            },

            copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    if (window.Alert && typeof window.Alert.toast === 'function') {
                        window.Alert.toast('Nomor rekening disalin ke clipboard: ' + text);
                    } else {
                        Swal.fire({ icon: 'success', title: 'Tersalin', text: 'Nomor rekening disalin ke clipboard: ' + text, timer: 1500, showConfirmButton: false });
                    }
                });
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            corpBankApp.init();
        });
    </script>
</x-layout.app>
