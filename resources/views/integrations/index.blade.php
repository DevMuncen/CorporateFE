<x-layout.app title="Integrasi & External API | Corporate Merchant Portal">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
                    <iconify-icon icon="solar:widget-add-bold-duotone" class="text-amber-500"></iconify-icon>
                    <span>Integrasi &amp; External API Gateway</span>
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Hubungkan ERP eksternal (SAP, Oracle, Odoo), kelola webhook push, pemetaan ID, dan pantau log sinkronisasi
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ $backendUrl ?? (rtrim(config('services.backend.url') ?: config('app.backend_url') ?: env('BACKEND_URL', 'http://127.0.0.1:8001'), '/')) }}/partner" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all flex items-center gap-1.5 shadow-xs">
                    <iconify-icon icon="solar:book-bookmark-bold" class="text-base text-amber-500"></iconify-icon>
                    <span>Dokumentasi Partner &rarr;</span>
                </a>
                <button type="button" onclick="openCreateAppModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2">
                    <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                    <span>+ Daftarkan Aplikasi</span>
                </button>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex border-b border-slate-200 dark:border-slate-700 gap-2">
            <button type="button" onclick="switchCorpTab('apps')" id="tabBtn-apps" class="corp-tab-btn px-4 py-2.5 text-xs font-bold border-b-2 border-blue-600 text-blue-600 dark:text-blue-400 flex items-center gap-2">
                <iconify-icon icon="solar:laptop-minimalistic-bold" class="text-base"></iconify-icon>
                <span>Aplikasi Eksternal</span>
            </button>
            <button type="button" onclick="switchCorpTab('webhooks')" id="tabBtn-webhooks" class="corp-tab-btn px-4 py-2.5 text-xs font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center gap-2">
                <iconify-icon icon="solar:bolt-bold" class="text-base"></iconify-icon>
                <span>Webhook Endpoints</span>
            </button>
            <button type="button" onclick="switchCorpTab('mappings')" id="tabBtn-mappings" class="corp-tab-btn px-4 py-2.5 text-xs font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center gap-2">
                <iconify-icon icon="solar:link-circle-bold" class="text-base"></iconify-icon>
                <span>Pemetaan External ID</span>
            </button>
            <button type="button" onclick="switchCorpTab('logs')" id="tabBtn-logs" class="corp-tab-btn px-4 py-2.5 text-xs font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center gap-2">
                <iconify-icon icon="solar:history-bold" class="text-base"></iconify-icon>
                <span>Log API &amp; DLQ Replay</span>
            </button>
        </div>

        <!-- Panel 1: Apps -->
        <div id="corpPanel-apps" class="corp-tab-panel space-y-4">
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                                <th class="py-3.5 pl-6 w-12 text-center">No</th>
                                <th class="py-3.5">Nama Aplikasi</th>
                                <th class="py-3.5">Client ID</th>
                                <th class="py-3.5 text-center">Mode</th>
                                <th class="py-3.5 text-center">Status</th>
                                <th class="py-3.5 text-center">Quota (RPM)</th>
                                <th class="py-3.5 pr-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="corpAppsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    <div class="inline-flex items-center gap-2">
                                        <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                        <span>Memuat data aplikasi eksternal...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Panel 2: Webhooks -->
        <div id="corpPanel-webhooks" class="corp-tab-panel hidden space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100">Daftar Webhook Push Notification</h3>
                    <p class="text-xs text-slate-400">Pemberitahuan perubahan status order, waybill, dan POD secara real-time</p>
                </div>
                <button type="button" onclick="openCreateWebhookModal()" class="px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-xs flex items-center gap-1.5">
                    <iconify-icon icon="solar:add-circle-bold"></iconify-icon>
                    <span>+ Tambah Webhook Endpoint</span>
                </button>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                                <th class="py-3.5 pl-6 w-12 text-center">No</th>
                                <th class="py-3.5">Aplikasi</th>
                                <th class="py-3.5">Endpoint URL</th>
                                <th class="py-3.5">Events Subscribed</th>
                                <th class="py-3.5 text-center">Circuit State</th>
                                <th class="py-3.5 text-center">Verifikasi</th>
                                <th class="py-3.5 pr-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="corpWebhooksTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">Memuat data webhook...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Panel 3: Mappings -->
        <div id="corpPanel-mappings" class="corp-tab-panel hidden space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <input type="text" id="corpMappingSearch" oninput="debounceCorpFetchMappings()" placeholder="Cari external ID / SKU / internal ID..." class="px-3 py-2 text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl w-64 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <select id="corpMappingEntity" onchange="fetchCorpMappings()" class="px-3 py-2 text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="">Semua Tipe Entitas</option>
                        <option value="product">Produk (SKU)</option>
                        <option value="order">Pesanan (PO)</option>
                        <option value="request_order">Request Order (RO)</option>
                        <option value="customer">Pelanggan</option>
                        <option value="warehouse">Gudang</option>
                    </select>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                                <th class="py-3.5 pl-6 w-12 text-center">No</th>
                                <th class="py-3.5">Tipe Entitas</th>
                                <th class="py-3.5">Internal ID</th>
                                <th class="py-3.5">External ID</th>
                                <th class="py-3.5">External Code</th>
                                <th class="py-3.5 pr-6 text-right">Dibuat Pada</th>
                            </tr>
                        </thead>
                        <tbody id="corpMappingsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">Memuat data pemetaan external ID...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Panel 4: Logs -->
        <div id="corpPanel-logs" class="corp-tab-panel hidden space-y-6">
            <!-- Inbound Logs -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100">Log Panggilan Masuk (Inbound API Calls)</h3>
                    <button type="button" onclick="fetchCorpInboundLogs()" class="text-xs text-blue-600 hover:underline">Refresh</button>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                                    <th class="py-3 pl-6">Waktu</th>
                                    <th class="py-3">Method &amp; Path</th>
                                    <th class="py-3 text-center">Status</th>
                                    <th class="py-3">Client IP</th>
                                    <th class="py-3">Durasi</th>
                                    <th class="py-3 pr-6">Correlation ID</th>
                                </tr>
                            </thead>
                            <tbody id="corpInboundLogsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                                <tr><td colspan="6" class="py-8 text-center text-slate-400">Memuat log masuk...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Outbound Logs -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100">Log Pengiriman Webhook (Outbound &amp; DLQ)</h3>
                        <p class="text-xs text-slate-400">Pantau status pengiriman notifikasi ke webhook partner</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="retryBulkCorpOutbound()" class="px-3 py-1.5 rounded-lg text-xs font-bold text-amber-700 bg-amber-100 dark:bg-amber-950/50 dark:text-amber-300 hover:bg-amber-200 transition-colors flex items-center gap-1">
                            <iconify-icon icon="solar:refresh-circle-bold"></iconify-icon> Retry Semua Gagal (DLQ)
                        </button>
                        <button type="button" onclick="fetchCorpOutboundLogs()" class="text-xs text-blue-600 hover:underline">Refresh</button>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                                    <th class="py-3 pl-6">Waktu</th>
                                    <th class="py-3">Event</th>
                                    <th class="py-3">Target URL</th>
                                    <th class="py-3 text-center">Status</th>
                                    <th class="py-3 text-center">Attempt</th>
                                    <th class="py-3 pr-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="corpOutboundLogsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                                <tr><td colspan="6" class="py-8 text-center text-slate-400">Memuat log pengiriman...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Register App -->
    <div id="modal-create-app" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700 mb-4">
                <h3 class="text-sm font-black text-slate-900 dark:text-white">Daftarkan Aplikasi Eksternal Baru</h3>
                <button type="button" onclick="closeCreateAppModal()" class="text-slate-400 hover:text-slate-600"><iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon></button>
            </div>
            <form onsubmit="submitCreateApp(event)" class="space-y-3.5 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Aplikasi</label>
                    <input type="text" id="app_name" placeholder="e.g. Enterprise SAP Connector" required oninput="handleAppNameInput(this.value)" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block font-bold text-slate-700 dark:text-slate-300">Kode Aplikasi (Slug)</label>
                        <span id="app_code_feedback" class="text-[11px] font-semibold"></span>
                    </div>
                    <div class="relative">
                        <input type="text" id="app_code" placeholder="e.g. app-sap-connector" required oninput="handleAppCodeInput(this.value)" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                    <div id="app_code_suggestion_container" class="mt-1.5 flex items-center gap-1.5 text-[11px] hidden"></div>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Environment</label>
                    <select id="app_environment" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="sandbox">Sandbox (Pengujian)</option>
                        <option value="production">Production</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Allowed Origins (Opsional, pisahkan koma)</label>
                    <input type="text" id="app_origins" placeholder="e.g. https://erp.company.com" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Allowed IPs (Opsional, CIDR / IPv4, pisahkan koma)</label>
                    <input type="text" id="app_ips" placeholder="e.g. 103.24.56.0/24, 202.158.40.10" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div class="pt-3 flex justify-end gap-2 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" onclick="closeCreateAppModal()" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl text-white bg-blue-600 hover:bg-blue-500 font-bold">Simpan &amp; Terbitkan Kredensial</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Secret Reveal -->
    <div id="modal-reveal-secret" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700 mb-4">
                <h3 class="text-sm font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:key-square-bold" class="text-amber-500 text-lg"></iconify-icon>
                    <span>Kredensial Aplikasi Diterbitkan</span>
                </h3>
                <button type="button" onclick="closeRevealSecretModal()" class="text-slate-400 hover:text-slate-600"><iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon></button>
            </div>
            <div class="space-y-4 text-xs">
                <p class="text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 p-3 rounded-xl border border-amber-200 dark:border-amber-800/60">
                    <strong>PENTING:</strong> Simpan Signing Secret sekarang! Secret ini dienkripsi dan tidak akan ditampilkan utuh lagi setelah jendela ini ditutup.
                </p>
                <div>
                    <label class="block font-bold text-slate-500 uppercase tracking-wider text-[10px] mb-1">Client ID</label>
                    <div class="flex items-center gap-2">
                        <input type="text" id="reveal_client_id" readonly class="w-full px-3 py-2 font-mono bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl font-bold">
                        <button type="button" onclick="copyText('reveal_client_id')" class="px-3 py-2 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 rounded-xl font-bold">Salin</button>
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-slate-500 uppercase tracking-wider text-[10px] mb-1">Signing Secret (HMAC-SHA256 Key)</label>
                    <div class="flex items-center gap-2">
                        <input type="text" id="reveal_signing_secret" readonly class="w-full px-3 py-2 font-mono bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl font-bold text-rose-600 dark:text-rose-400">
                        <button type="button" onclick="copyText('reveal_signing_secret')" class="px-3 py-2 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 rounded-xl font-bold">Salin</button>
                    </div>
                </div>
                <div class="pt-3 text-right">
                    <button type="button" onclick="closeRevealSecretModal()" class="px-4 py-2 rounded-xl text-white bg-blue-600 hover:bg-blue-500 font-bold">Selesai &amp; Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Register Webhook Endpoint -->
    <div id="modal-create-webhook" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700 mb-4">
                <h3 class="text-sm font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:bolt-bold" class="text-amber-500 text-lg"></iconify-icon>
                    <span>Tambah Webhook Push Endpoint</span>
                </h3>
                <button type="button" onclick="closeCreateWebhookModal()" class="text-slate-400 hover:text-slate-600"><iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon></button>
            </div>
            <form onsubmit="submitCreateWebhook(event)" class="space-y-3.5 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Aplikasi Eksternal</label>
                    <select id="webhook_app_id" required class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="">-- Pilih Aplikasi Eksternal --</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Nama / Deskripsi Endpoint</label>
                    <input type="text" id="webhook_name" placeholder="Contoh: ERP Main Order &amp; Tracking Webhook" required class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Endpoint URL (HTTPS)</label>
                    <input type="url" id="webhook_url" placeholder="https://erp.perusahaan.com/api/webhooks/lmp" required class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none font-mono">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Subscribed Events (Pilih minimal 1)</label>
                    <div class="space-y-2 bg-slate-50 dark:bg-slate-900/60 p-3 rounded-xl border border-slate-200 dark:border-slate-700 max-h-44 overflow-y-auto">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="webhook_events" value="corporate.order.created" class="rounded text-blue-600" checked>
                            <span class="font-mono text-[11px] text-slate-700 dark:text-slate-300">corporate.order.created <small class="text-slate-400 font-sans">(Order Baru)</small></span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="webhook_events" value="corporate.order.confirmed" class="rounded text-blue-600" checked>
                            <span class="font-mono text-[11px] text-slate-700 dark:text-slate-300">corporate.order.confirmed <small class="text-slate-400 font-sans">(Order Disetujui)</small></span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="webhook_events" value="logistic.ro.confirmed" class="rounded text-blue-600" checked>
                            <span class="font-mono text-[11px] text-slate-700 dark:text-slate-300">logistic.ro.confirmed <small class="text-slate-400 font-sans">(RO Diterima Carrier)</small></span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="webhook_events" value="logistic.ro.dispatched" class="rounded text-blue-600" checked>
                            <span class="font-mono text-[11px] text-slate-700 dark:text-slate-300">logistic.ro.dispatched <small class="text-slate-400 font-sans">(Armada Berangkat)</small></span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="webhook_events" value="logistic.waybill.delivered" class="rounded text-blue-600" checked>
                            <span class="font-mono text-[11px] text-slate-700 dark:text-slate-300">logistic.waybill.delivered <small class="text-slate-400 font-sans">(Waybill Sampai)</small></span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="webhook_events" value="logistic.waybill.pod_uploaded" class="rounded text-blue-600" checked>
                            <span class="font-mono text-[11px] text-slate-700 dark:text-slate-300">logistic.waybill.pod_uploaded <small class="text-slate-400 font-sans">(e-POD Terunggah)</small></span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="webhook_events" value="corporate.inventory.adjusted" class="rounded text-blue-600">
                            <span class="font-mono text-[11px] text-slate-700 dark:text-slate-300">corporate.inventory.adjusted <small class="text-slate-400 font-sans">(Mutasi Stok)</small></span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="webhook_events" value="finance.invoice.issued" class="rounded text-blue-600">
                            <span class="font-mono text-[11px] text-slate-700 dark:text-slate-300">finance.invoice.issued <small class="text-slate-400 font-sans">(Invoice Terbit)</small></span>
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Timeout (ms)</label>
                        <input type="number" id="webhook_timeout" value="10000" min="1000" max="30000" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Max Retries</label>
                        <input type="number" id="webhook_max_retries" value="5" min="0" max="10" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                </div>
                <div class="pt-3 flex justify-end gap-2 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" onclick="closeCreateWebhookModal()" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl text-white bg-blue-600 hover:bg-blue-500 font-bold flex items-center gap-1.5">
                        <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                        <span>Daftarkan Webhook</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        let corpApps = [];
        let activeAppForWebhook = null;
        let debounceTimer = null;

        document.addEventListener('DOMContentLoaded', () => {
            fetchCorpApps();
        });

        function switchCorpTab(tab) {
            document.querySelectorAll('.corp-tab-btn').forEach(b => {
                b.classList.remove('border-blue-600', 'text-blue-600', 'dark:text-blue-400');
                b.classList.add('border-transparent', 'text-slate-500');
            });
            document.querySelectorAll('.corp-tab-panel').forEach(p => p.classList.add('hidden'));

            const activeBtn = document.getElementById('tabBtn-' + tab);
            const activePanel = document.getElementById('corpPanel-' + tab);
            if (activeBtn) {
                activeBtn.classList.remove('border-transparent', 'text-slate-500');
                activeBtn.classList.add('border-blue-600', 'text-blue-600', 'dark:text-blue-400');
            }
            if (activePanel) activePanel.classList.remove('hidden');

            if (tab === 'webhooks') fetchCorpWebhooks();
            if (tab === 'mappings') fetchCorpMappings();
            if (tab === 'logs') {
                fetchCorpInboundLogs();
                fetchCorpOutboundLogs();
            }
        }

        async function fetchCorpApps() {
            try {
                const res = await fetch('/api/integrations/apps');
                const json = await res.json();
                corpApps = json.data?.data || json.data || [];
                renderCorpApps();
            } catch (err) {
                console.error('Failed to fetch apps', err);
            }
        }

        function renderCorpApps() {
            const tbody = document.getElementById('corpAppsTableBody');
            if (!corpApps.length) {
                tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Belum ada aplikasi eksternal yang didaftarkan. Klik "+ Daftarkan Aplikasi" untuk memulai.</td></tr>`;
                return;
            }

            tbody.innerHTML = corpApps.map((app, idx) => {
                const statusBadge = app.status === 'active' 
                    ? `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300">Aktif</span>`
                    : (app.status === 'draft' 
                        ? `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300">Draft</span>`
                        : `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 dark:bg-rose-950/50 dark:text-rose-300">Suspended</span>`);

                const modeBadge = `<span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 dark:bg-slate-700">${app.environment || 'sandbox'}</span>`;

                return `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-750 transition-colors">
                        <td class="py-3 pl-6 text-center text-slate-400 font-mono">${idx + 1}</td>
                        <td class="py-3">
                            <div class="font-bold text-slate-800 dark:text-slate-100">${escapeHtml(app.name)}</div>
                            <div class="text-[10px] text-slate-400 font-mono">${escapeHtml(app.app_code)}</div>
                        </td>
                        <td class="py-3 font-mono font-semibold text-slate-600 dark:text-slate-300">${escapeHtml(app.client_id)}</td>
                        <td class="py-3 text-center">${modeBadge}</td>
                        <td class="py-3 text-center">${statusBadge}</td>
                        <td class="py-3 text-center font-mono font-bold text-slate-700 dark:text-slate-200">${app.rate_limit_rpm || 120} RPM</td>
                        <td class="py-3 pr-6 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <button type="button" onclick="rotateCorpSecret(${app.id})" title="Rotate Secret" class="p-1 text-slate-400 hover:text-amber-600">
                                    <iconify-icon icon="solar:key-minimalistic-square-bold" class="text-base"></iconify-icon>
                                </button>
                                <button type="button" onclick="toggleCorpStatus(${app.id}, '${app.status === 'active' ? 'suspended' : 'active'}')" title="Ubah Status" class="p-1 text-slate-400 hover:text-blue-600">
                                    <iconify-icon icon="solar:power-bold" class="text-base"></iconify-icon>
                                </button>
                                <button type="button" onclick="deleteCorpApp(${app.id})" title="Hapus" class="p-1 text-slate-400 hover:text-rose-600">
                                    <iconify-icon icon="solar:trash-bin-trash-bold" class="text-base"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        let isAppCodeManuallyEdited = false;
        let appCodeCheckTimeout = null;
        let currentCodeCheckResult = { is_unique: true, suggested_code: '' };

        function slugifyText(text) {
            return (text || '').toString().toLowerCase().trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
        }

        function handleAppNameInput(val) {
            if (!isAppCodeManuallyEdited) {
                const baseSlug = slugifyText(val);
                const suggestedSlug = baseSlug ? (baseSlug.startsWith('app-') ? baseSlug : 'app-' + baseSlug) : '';
                const codeInput = document.getElementById('app_code');
                codeInput.value = suggestedSlug;
                if (suggestedSlug) {
                    debouncedCheckAppCode(suggestedSlug);
                } else {
                    resetAppCodeFeedback();
                }
            }
        }

        function handleAppCodeInput(val) {
            isAppCodeManuallyEdited = true;
            const slug = slugifyText(val);
            if (slug) {
                debouncedCheckAppCode(slug);
            } else {
                resetAppCodeFeedback();
            }
        }

        function applySuggestedCode(code) {
            const input = document.getElementById('app_code');
            input.value = code;
            isAppCodeManuallyEdited = true;
            checkAppCodeUnique(code);
        }

        function resetAppCodeFeedback() {
            const feedback = document.getElementById('app_code_feedback');
            const container = document.getElementById('app_code_suggestion_container');
            const input = document.getElementById('app_code');
            if (feedback) feedback.innerHTML = '';
            if (container) {
                container.innerHTML = '';
                container.classList.add('hidden');
            }
            if (input) {
                input.classList.remove('border-rose-500', 'focus:ring-rose-500', 'border-emerald-500', 'focus:ring-emerald-500');
            }
            currentCodeCheckResult = { is_unique: true, suggested_code: '' };
        }

        function debouncedCheckAppCode(code) {
            if (appCodeCheckTimeout) clearTimeout(appCodeCheckTimeout);
            const feedback = document.getElementById('app_code_feedback');
            if (feedback) {
                feedback.innerHTML = '<span class="text-slate-400 dark:text-slate-500 flex items-center gap-1 font-medium"><iconify-icon icon="line-md:loading-loop"></iconify-icon> Memeriksa...</span>';
            }
            appCodeCheckTimeout = setTimeout(() => {
                checkAppCodeUnique(code);
            }, 300);
        }

        async function checkAppCodeUnique(code) {
            if (!code) {
                resetAppCodeFeedback();
                return;
            }
            const cleanCode = slugifyText(code);
            try {
                const res = await fetch(`/api/integrations/apps/check-code?code=${encodeURIComponent(cleanCode)}`);
                const json = await res.json();
                const feedback = document.getElementById('app_code_feedback');
                const container = document.getElementById('app_code_suggestion_container');
                const input = document.getElementById('app_code');

                if (json.status === 'success') {
                    currentCodeCheckResult = {
                        is_unique: json.is_unique,
                        suggested_code: json.suggested_code || ''
                    };

                    if (json.is_unique) {
                        if (feedback) feedback.innerHTML = '<span class="text-emerald-600 dark:text-emerald-400 flex items-center gap-1 font-bold"><iconify-icon icon="solar:check-circle-bold"></iconify-icon> Kode Tersedia</span>';
                        if (container) {
                            container.innerHTML = '';
                            container.classList.add('hidden');
                        }
                        if (input) {
                            input.classList.remove('border-rose-500', 'focus:ring-rose-500');
                            input.classList.add('border-emerald-500', 'focus:ring-emerald-500');
                        }
                    } else {
                        if (feedback) feedback.innerHTML = '<span class="text-rose-600 dark:text-rose-400 flex items-center gap-1 font-bold"><iconify-icon icon="solar:danger-triangle-bold"></iconify-icon> Sudah Digunakan</span>';
                        if (container && json.suggested_code) {
                            container.innerHTML = `
                                <span class="text-slate-500 dark:text-slate-400">Gunakan saran unik:</span>
                                <button type="button" onclick="applySuggestedCode('${escapeHtml(json.suggested_code)}')" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-900/40 dark:text-blue-300 font-bold hover:bg-blue-100 transition-colors cursor-pointer border border-blue-200 dark:border-blue-800">
                                    <span>${escapeHtml(json.suggested_code)}</span>
                                    <iconify-icon icon="solar:magic-stick-bold"></iconify-icon>
                                </button>
                            `;
                            container.classList.remove('hidden');
                        }
                        if (input) {
                            input.classList.remove('border-emerald-500', 'focus:ring-emerald-500');
                            input.classList.add('border-rose-500', 'focus:ring-rose-500');
                        }
                    }
                }
            } catch (e) {
                console.error('Check code failed:', e);
            }
        }

        async function submitCreateApp(e) {
            e.preventDefault();
            const rawCode = document.getElementById('app_code').value.trim();
            const appCode = slugifyText(rawCode);
            const appName = document.getElementById('app_name').value.trim();

            if (!appCode) {
                Swal.fire({ icon: 'warning', title: 'Kode Aplikasi Kosong', text: 'Silakan isi Kode Aplikasi (Slug).' });
                return;
            }

            // Quick pre-validation check
            if (currentCodeCheckResult.is_unique === false) {
                const suggested = currentCodeCheckResult.suggested_code || (appCode + '-2');
                const confirmSuggest = await Swal.fire({
                    icon: 'warning',
                    title: 'Kode Aplikasi Sudah Digunakan',
                    html: `Kode aplikasi <b>"${escapeHtml(appCode)}"</b> sudah terdaftar untuk akun ini.<br><br>Apakah Anda ingin menggunakan kode unik yang disarankan: <b class="text-blue-600">${escapeHtml(suggested)}</b>?`,
                    showCancelButton: true,
                    confirmButtonText: 'Gunakan Saran & Lanjutkan',
                    cancelButtonText: 'Ubah Manual',
                    confirmButtonColor: '#2563eb'
                });

                if (confirmSuggest.isConfirmed) {
                    applySuggestedCode(suggested);
                    document.getElementById('app_code').value = suggested;
                } else {
                    return;
                }
            }

            const finalCode = document.getElementById('app_code').value.trim();

            const payload = {
                app_code: finalCode,
                name: appName,
                environment: document.getElementById('app_environment').value,
                allowed_origins: document.getElementById('app_origins').value ? document.getElementById('app_origins').value.split(',').map(s => s.trim()) : [],
                allowed_ips: document.getElementById('app_ips').value ? document.getElementById('app_ips').value.split(',').map(s => s.trim()) : [],
            };

            try {
                const res = await fetch('/api/integrations/apps', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(payload)
                });
                const json = await res.json();
                if (res.ok && (json.status === 'success' || json.data)) {
                    closeCreateAppModal();
                    fetchCorpApps();
                    // Reveal secret modal
                    const rawSecret = json.data?.signing_secret || json.data?.raw_secret || json.credentials?.signing_secret || json.credentials?.raw_secret || '';
                    document.getElementById('reveal_client_id').value = json.data?.client_id || json.credentials?.client_id || '';
                    document.getElementById('reveal_signing_secret').value = rawSecret;
                    document.getElementById('modal-reveal-secret').classList.remove('hidden');
                } else if (res.status === 422 || json.suggested_code) {
                    const suggested = json.suggested_code;
                    if (suggested) {
                        const confirmUse = await Swal.fire({
                            icon: 'warning',
                            title: 'Kode Aplikasi Sudah Digunakan',
                            html: `${escapeHtml(json.message)}<br><br>Gunakan kode saran unik: <b class="text-blue-600">${escapeHtml(suggested)}</b>?`,
                            showCancelButton: true,
                            confirmButtonText: 'Gunakan Kode Saran',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#2563eb'
                        });
                        if (confirmUse.isConfirmed) {
                            applySuggestedCode(suggested);
                        }
                    } else {
                        Swal.fire({ icon: 'warning', title: 'Validasi Gagal', text: json.message || 'Kode aplikasi tidak valid atau sudah digunakan.' });
                    }
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: json.message || 'Gagal mendaftarkan aplikasi' });
                }
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Terjadi Kesalahan', text: err.message });
            }
        }

        async function rotateCorpSecret(id) {
            const confirmRes = await Swal.fire({
                title: 'Putar (Rotate) Signing Secret?',
                text: 'Kredensial lama akan diberikan masa transisi 24 jam sebelum kedaluwarsa.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Putar Secret',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2563eb'
            });
            if (!confirmRes.isConfirmed) return;
            try {
                const res = await fetch(`/api/integrations/apps/${id}/rotate-secret`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const json = await res.json();
                if (json.status === 'success') {
                    const rawSecret = json.data?.signing_secret || json.data?.raw_secret || json.credentials?.signing_secret || json.credentials?.new_signing_secret || json.credentials?.raw_secret || '';
                    document.getElementById('reveal_client_id').value = json.data?.client_id || json.credentials?.client_id || '';
                    document.getElementById('reveal_signing_secret').value = rawSecret;
                    document.getElementById('modal-reveal-secret').classList.remove('hidden');
                }
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal rotate secret: ' + err.message });
            }
        }

        async function toggleCorpStatus(id, newStatus) {
            try {
                await fetch(`/api/integrations/apps/${id}/status`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ status: newStatus })
                });
                fetchCorpApps();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal mengubah status aplikasi' });
            }
        }

        async function deleteCorpApp(id) {
            const confirmRes = await Swal.fire({
                title: 'Hapus Aplikasi Eksternal?',
                text: 'Registrasi aplikasi eksternal ini akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626'
            });
            if (!confirmRes.isConfirmed) return;
            try {
                await fetch(`/api/integrations/apps/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                fetchCorpApps();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menghapus aplikasi: ' + err.message });
            }
        }

        async function fetchCorpWebhooks() {
            if (!corpApps.length) await fetchCorpApps();
            const tbody = document.getElementById('corpWebhooksTableBody');
            let rowsHtml = '';
            let count = 0;

            for (const app of corpApps) {
                try {
                    const res = await fetch(`/api/integrations/apps/${app.id}/webhooks`);
                    const json = await res.json();
                    const webhooks = json.data || [];
                    webhooks.forEach(wh => {
                        count++;
                        rowsHtml += `
                            <tr>
                                <td class="py-3 pl-6 text-center text-slate-400 font-mono">${count}</td>
                                <td class="py-3 font-bold">${escapeHtml(app.name)}</td>
                                <td class="py-3 font-mono font-semibold text-slate-700 dark:text-slate-200">${escapeHtml(wh.url)}</td>
                                <td class="py-3">
                                    ${(wh.subscribed_events || []).map(ev => `<span class="px-1.5 py-0.5 rounded text-[10px] bg-slate-100 dark:bg-slate-700 mr-1">${ev}</span>`).join('')}
                                </td>
                                <td class="py-3 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${wh.circuit_state === 'closed' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'}">
                                        ${wh.circuit_state}
                                    </span>
                                </td>
                                <td class="py-3 text-center text-[11px] text-slate-400">${wh.handshake_verified_at ? 'Terverifikasi' : 'Pending'}</td>
                                <td class="py-3 pr-6 text-right space-x-1">
                                    <button type="button" onclick="pingCorpWebhook(${app.id}, ${wh.id})" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-50 text-blue-600 hover:bg-blue-100">Test Ping</button>
                                    ${wh.circuit_state === 'open' ? `<button type="button" onclick="resetCorpCircuit(${app.id}, ${wh.id})" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-50 text-amber-600 hover:bg-amber-100">Reset Circuit</button>` : ''}
                                </td>
                            </tr>
                        `;
                    });
                } catch (_) {}
            }

            tbody.innerHTML = rowsHtml || `<tr><td colspan="7" class="py-8 text-center text-slate-400">Belum ada webhook yang terdaftar.</td></tr>`;
        }

        async function pingCorpWebhook(appId, webhookId) {
            try {
                const res = await fetch(`/api/integrations/apps/${appId}/webhooks/${webhookId}/ping`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const json = await res.json();
                Swal.fire({ icon: 'success', title: 'Ping Berhasil', text: json.message || 'Ping request dispatched!' });
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal Ping', text: err.message });
            }
        }

        async function fetchCorpMappings() {
            const search = document.getElementById('corpMappingSearch').value;
            const entity = document.getElementById('corpMappingEntity').value;
            const tbody = document.getElementById('corpMappingsTableBody');

            try {
                const res = await fetch(`/api/integrations/mappings?search=${encodeURIComponent(search)}&entity_type=${encodeURIComponent(entity)}`);
                const json = await res.json();
                const mappings = json.data?.data || json.data || [];

                if (!mappings.length) {
                    tbody.innerHTML = `<tr><td colspan="6" class="py-8 text-center text-slate-400">Tidak ada pemetaan external ID ditemukan.</td></tr>`;
                    return;
                }

                tbody.innerHTML = mappings.map((m, idx) => `
                    <tr>
                        <td class="py-3 pl-6 text-center text-slate-400 font-mono">${idx + 1}</td>
                        <td class="py-3"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 dark:bg-slate-700">${m.entity_type}</span></td>
                        <td class="py-3 font-mono font-bold text-slate-800 dark:text-slate-100">#${m.internal_id}</td>
                        <td class="py-3 font-mono font-bold text-blue-600 dark:text-blue-400">${escapeHtml(m.external_id)}</td>
                        <td class="py-3 font-mono text-slate-500">${escapeHtml(m.external_code || '-')}</td>
                        <td class="py-3 pr-6 text-right text-slate-400 text-[11px]">${m.created_at ? m.created_at.substring(0, 16) : '-'}</td>
                    </tr>
                `).join('');
            } catch (err) {
                console.error(err);
            }
        }

        function debounceCorpFetchMappings() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fetchCorpMappings, 300);
        }

        async function fetchCorpInboundLogs() {
            const tbody = document.getElementById('corpInboundLogsTableBody');
            try {
                const res = await fetch('/api/integrations/logs/inbound');
                const json = await res.json();
                const logs = json.data?.data || json.data || [];
                if (!logs.length) {
                    tbody.innerHTML = `<tr><td colspan="6" class="py-8 text-center text-slate-400">Belum ada panggilan masuk tercatat.</td></tr>`;
                    return;
                }
                tbody.innerHTML = logs.map(l => `
                    <tr>
                        <td class="py-3 pl-6 text-slate-400 font-mono">${l.created_at ? l.created_at.substring(11, 19) : '-'}</td>
                        <td class="py-3 font-mono font-semibold"><span class="text-blue-600 font-bold">${l.method}</span> ${escapeHtml(l.path)}</td>
                        <td class="py-3 text-center"><span class="px-2 py-0.5 rounded text-[10px] font-bold ${l.status_code < 400 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'}">${l.status_code}</span></td>
                        <td class="py-3 font-mono text-slate-500">${escapeHtml(l.ip_address)}</td>
                        <td class="py-3 font-mono text-slate-500">${l.duration_ms}ms</td>
                        <td class="py-3 pr-6 font-mono text-[10px] text-slate-400">${escapeHtml(l.correlation_id || '-')}</td>
                    </tr>
                `).join('');
            } catch (err) {
                console.error(err);
            }
        }

        async function fetchCorpOutboundLogs() {
            const tbody = document.getElementById('corpOutboundLogsTableBody');
            try {
                const res = await fetch('/api/integrations/logs/outbound');
                const json = await res.json();
                const logs = json.data?.data || json.data || [];
                if (!logs.length) {
                    tbody.innerHTML = `<tr><td colspan="6" class="py-8 text-center text-slate-400">Belum ada pengiriman webhook tercatat.</td></tr>`;
                    return;
                }
                tbody.innerHTML = logs.map(l => `
                    <tr>
                        <td class="py-3 pl-6 text-slate-400 font-mono">${l.created_at ? l.created_at.substring(11, 19) : '-'}</td>
                        <td class="py-3 font-mono font-bold text-slate-700 dark:text-slate-200">${escapeHtml(l.event_type || l.event_name || '-')}</td>
                        <td class="py-3 font-mono text-slate-500 truncate max-w-xs">${escapeHtml(l.endpoint_url || '-')}</td>
                        <td class="py-3 text-center">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold ${l.status === 'succeeded' ? 'bg-emerald-100 text-emerald-700' : (l.status === 'retrying' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700')}">
                                ${l.status}
                            </span>
                        </td>
                        <td class="py-3 text-center font-mono">${l.attempt_count} / ${l.max_retries}</td>
                        <td class="py-3 pr-6 text-right">
                            <button type="button" onclick="retryCorpSingleOutbound(${l.id})" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-50 text-amber-600 hover:bg-amber-100">Retry</button>
                        </td>
                    </tr>
                `).join('');
            } catch (err) {
                console.error(err);
            }
        }

        async function retryCorpSingleOutbound(logId) {
            try {
                const res = await fetch(`/api/integrations/logs/outbound/${logId}/retry`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const json = await res.json();
                Swal.fire({ icon: 'success', title: 'Berhasil', text: json.message || 'Re-queued!', timer: 2000, showConfirmButton: false });
                fetchCorpOutboundLogs();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal melakukan retry webhook delivery' });
            }
        }

        async function retryBulkCorpOutbound() {
            const confirmRes = await Swal.fire({
                title: 'Re-queue Webhook Dead-Letter?',
                text: 'Re-queue semua webhook delivery yang saat ini berstatus dead-letter?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Re-queue Semua',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2563eb'
            });
            if (!confirmRes.isConfirmed) return;
            try {
                const res = await fetch('/api/integrations/logs/outbound/retry-bulk', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const json = await res.json();
                Swal.fire({ icon: 'success', title: 'Berhasil', text: json.message || 'Deliveries re-queued!', timer: 2500, showConfirmButton: false });
                fetchCorpOutboundLogs();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memproses bulk retry dead-letter' });
            }
        }

        function openCreateAppModal() {
            document.getElementById('app_name').value = '';
            document.getElementById('app_code').value = '';
            document.getElementById('app_origins').value = '';
            document.getElementById('app_ips').value = '';
            document.getElementById('app_environment').value = 'sandbox';
            isAppCodeManuallyEdited = false;
            resetAppCodeFeedback();
            document.getElementById('modal-create-app').classList.remove('hidden');
        }
        function closeCreateAppModal() {
            resetAppCodeFeedback();
            document.getElementById('modal-create-app').classList.add('hidden');
        }
        function closeRevealSecretModal() { document.getElementById('modal-reveal-secret').classList.add('hidden'); }

        async function openCreateWebhookModal(preselectedAppId = null) {
            if (!corpApps.length) {
                await fetchCorpApps();
            }
            if (!corpApps.length) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Silakan daftarkan aplikasi eksternal terlebih dahulu sebelum menambahkan webhook endpoint.',
                    confirmButtonText: 'Daftarkan Aplikasi',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    switchCorpTab('apps');
                });
                return;
            }
            const select = document.getElementById('webhook_app_id');
            select.innerHTML = '<option value="">-- Pilih Aplikasi Eksternal --</option>' +
                corpApps.map(a => `<option value="${a.id}">${escapeHtml(a.name)} (${escapeHtml(a.app_code)})</option>`).join('');
            if (preselectedAppId) {
                select.value = preselectedAppId;
            } else if (corpApps.length === 1) {
                select.value = corpApps[0].id;
            }
            document.getElementById('modal-create-webhook').classList.remove('hidden');
        }

        function closeCreateWebhookModal() {
            document.getElementById('modal-create-webhook').classList.add('hidden');
        }

        async function submitCreateWebhook(event) {
            event.preventDefault();
            const appId = document.getElementById('webhook_app_id').value;
            if (!appId) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih aplikasi eksternal terlebih dahulu.' });
                return;
            }
            const name = document.getElementById('webhook_name').value.trim();
            const url = document.getElementById('webhook_url').value.trim();
            const checkboxes = document.querySelectorAll('input[name="webhook_events"]:checked');
            const events = Array.from(checkboxes).map(cb => cb.value);

            if (!events.length) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih minimal satu event yang disubscribe.' });
                return;
            }

            const timeout_ms = parseInt(document.getElementById('webhook_timeout').value) || 10000;
            const max_retries = parseInt(document.getElementById('webhook_max_retries').value) || 5;

            try {
                const res = await fetch(`/api/integrations/apps/${appId}/webhooks`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({
                        name,
                        url,
                        subscribed_events: events,
                        timeout_ms,
                        max_retries
                    })
                });
                const json = await res.json();
                if (!res.ok) {
                    throw new Error(json.message || 'Gagal menyimpan webhook endpoint.');
                }

                closeCreateWebhookModal();

                if (json.webhook_secret) {
                    document.getElementById('reveal_client_id').value = 'Webhook #' + json.data.id + ' (' + json.data.name + ')';
                    document.getElementById('reveal_signing_secret').value = json.webhook_secret;
                    document.getElementById('modal-reveal-secret').classList.remove('hidden');
                } else {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Webhook endpoint berhasil didaftarkan!', timer: 2000, showConfirmButton: false });
                }

                fetchCorpWebhooks();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: err.message });
            }
        }

        async function resetCorpCircuit(appId, webhookId) {
            try {
                const res = await fetch(`/api/integrations/apps/${appId}/webhooks/${webhookId}/reset-circuit`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const json = await res.json();
                Swal.fire({ icon: 'success', title: 'Circuit Reset', text: json.message || 'Circuit breaker berhasil direset ke closed.' });
                fetchCorpWebhooks();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal reset circuit breaker' });
            }
        }

        function copyText(elemId) {
            const input = document.getElementById(elemId);
            input.select();
            navigator.clipboard.writeText(input.value);
            Swal.fire({
                icon: 'success',
                title: 'Tersalin!',
                text: 'Kredensial disalin ke clipboard',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1800
            });
        }

        function escapeHtml(str) {
            return String(str || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }
    </script>
</x-layout.app>
