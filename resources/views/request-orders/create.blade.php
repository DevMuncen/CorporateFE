<x-layout.app title="Buat Request Order (RO) Baru | Corporate Merchant Portal">
    <div class="space-y-6 max-w-5xl mx-auto">

        <!-- Top Breadcrumbs & Title -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="/request-orders" class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors inline-flex items-center gap-1 mb-1">
                    <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                    <span>Kembali ke Daftar RO</span>
                </a>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Buat Request Order (RO) Pengiriman
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Formulir 5-tahap kalkulasi tarif dinamis dan pengaturan multi-drop tujuan
                </p>
            </div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 text-xs font-bold">
                <iconify-icon icon="solar:calculator-bold-duotone" class="text-base text-blue-600"></iconify-icon>
                <span>Dynamic Tariff Engine Active</span>
            </div>
        </div>

        <!-- 5-Step Progress Indicator -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-4 sm:p-6 shadow-sm">
            <div class="grid grid-cols-5 gap-2 text-center text-xs">
                <!-- Step 1 -->
                <div id="step-nav-1" class="step-nav-item flex flex-col items-center gap-1.5 cursor-pointer" onclick="goToStep(1)">
                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs shadow-md shadow-blue-600/30">1</div>
                    <span class="font-bold text-slate-900 dark:text-white hidden sm:block">Gudang Asal</span>
                </div>
                <!-- Step 2 -->
                <div id="step-nav-2" class="step-nav-item flex flex-col items-center gap-1.5 cursor-pointer opacity-40" onclick="goToStep(2)">
                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold flex items-center justify-center text-xs">2</div>
                    <span class="font-bold text-slate-600 dark:text-slate-400 hidden sm:block">Multi-Drop</span>
                </div>
                <!-- Step 3 -->
                <div id="step-nav-3" class="step-nav-item flex flex-col items-center gap-1.5 cursor-pointer opacity-40" onclick="goToStep(3)">
                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold flex items-center justify-center text-xs">3</div>
                    <span class="font-bold text-slate-600 dark:text-slate-400 hidden sm:block">Muatan SKU</span>
                </div>
                <!-- Step 4 -->
                <div id="step-nav-4" class="step-nav-item flex flex-col items-center gap-1.5 cursor-pointer opacity-40" onclick="goToStep(4)">
                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold flex items-center justify-center text-xs">4</div>
                    <span class="font-bold text-slate-600 dark:text-slate-400 hidden sm:block">Layanan &amp; Tarif</span>
                </div>
                <!-- Step 5 -->
                <div id="step-nav-5" class="step-nav-item flex flex-col items-center gap-1.5 cursor-pointer opacity-40" onclick="goToStep(5)">
                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold flex items-center justify-center text-xs">5</div>
                    <span class="font-bold text-slate-600 dark:text-slate-400 hidden sm:block">Konfirmasi</span>
                </div>
            </div>
        </div>

        <!-- Wizard Steps Container -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 sm:p-8 shadow-sm">

            <!-- STEP 1: Origin Warehouse & Shipper -->
            <div id="step-content-1" class="wizard-step space-y-5">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <iconify-icon icon="solar:warehouse-bold-duotone" class="text-xl text-blue-600"></iconify-icon>
                        <span>Tahap 1: Titik Muat / Gudang Asal</span>
                    </h3>
                    <p class="text-xs text-slate-500">Pilih hub keberangkatan armada dan waktu kesiapan kargo</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Gudang / Hub Asal *</label>
                        <select id="originWarehouse" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none">
                            <option value="">Pilih Gudang Asal...</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Jadwal Muat (Departure Date) *</label>
                        <input type="datetime-local" id="departureDate" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Kontak PIC Pemuatan *</label>
                        <input type="text" id="shipperPic" required placeholder="Nama PIC Gudang" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Nomor Telepon PIC *</label>
                        <input type="text" id="shipperPhone" required placeholder="081234567890" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Instruksi Pemuatan di Gudang Asal</label>
                    <textarea id="shipperNotes" rows="2" placeholder="Contoh: Muatan menggunakan pallet plastik, wajib lashing rapat..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs"></textarea>
                </div>
            </div>

            <!-- STEP 2: Multi-Drop Waypoints -->
            <div id="step-content-2" class="wizard-step space-y-5 hidden">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <iconify-icon icon="solar:routing-2-bold-duotone" class="text-xl text-blue-600"></iconify-icon>
                            <span>Tahap 2: Tujuan &amp; Multi-Drop Waypoint</span>
                        </h3>
                        <p class="text-xs text-slate-500">Tentukan lokasi penurunan barang. Tambah titik drop jika pengiriman multirute</p>
                    </div>
                    <button type="button" onclick="addDropPoint()" class="px-3 py-1.5 rounded-xl text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 hover:bg-blue-100 transition-all flex items-center gap-1.5">
                        <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                        <span>+ Titik Drop Tambahan</span>
                    </button>
                </div>

                <div id="dropPointsContainer" class="space-y-4">
                    <!-- Drop Point 1 (Default) -->
                    <div class="drop-point-card p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-600 text-white">
                                Drop #1 (Tujuan Utama)
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                            <div>
                                <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama Penerima / Toko *</label>
                                <input type="text" class="drop-recipient w-full px-3 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl" placeholder="Toko Mitra Grosir" required />
                            </div>
                            <div>
                                <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kota / Kabupaten *</label>
                                <input type="text" class="drop-city w-full px-3 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl" placeholder="Bandung" required />
                            </div>
                            <div>
                                <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Telepon Penerima *</label>
                                <input type="text" class="drop-phone w-full px-3 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl" placeholder="081987654321" required />
                            </div>
                        </div>
                        <div class="text-xs">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Alamat Lengkap Bongkar *</label>
                            <input type="text" class="drop-address w-full px-3 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl" placeholder="Jl. Raya Kopo No. 120, Kota Bandung" required />
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 3: Product Cargo Selection -->
            <div id="step-content-3" class="wizard-step space-y-5 hidden">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="text-xl text-blue-600"></iconify-icon>
                            <span>Tahap 3: Muatan Barang &amp; SKU Produk</span>
                        </h3>
                        <p class="text-xs text-slate-500">Pilih item dari katalog produk untuk kalkulasi otomatis tonase dan volume</p>
                    </div>
                    <button type="button" onclick="addProductRow()" class="px-3 py-1.5 rounded-xl text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 hover:bg-blue-100 transition-all flex items-center gap-1.5">
                        <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                        <span>+ Tambah Baris Barang</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-700 text-slate-500 font-bold uppercase">
                                <th class="pb-2">Produk SKU</th>
                                <th class="pb-2 w-28 text-center">Jumlah (Qty)</th>
                                <th class="pb-2 w-28 text-right">Berat / Unit</th>
                                <th class="pb-2 w-32 text-right">Subtotal Berat</th>
                                <th class="pb-2 w-12 text-center"></th>
                            </tr>
                        </thead>
                        <tbody id="productRowsBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            <!-- Rows injected dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Weight and Volume Totals Summary Card -->
                <div class="bg-blue-50/70 dark:bg-blue-950/40 p-4 rounded-2xl border border-blue-100 dark:border-blue-900 flex flex-wrap items-center justify-between gap-4 text-xs">
                    <div class="flex items-center gap-6">
                        <div>
                            <span class="text-slate-500 dark:text-slate-400">Total Kuantitas:</span>
                            <h5 id="totalQtyDisplay" class="text-base font-black text-slate-900 dark:text-white">0 unit</h5>
                        </div>
                        <div>
                            <span class="text-slate-500 dark:text-slate-400">Total Tonase:</span>
                            <h5 id="totalWeightDisplay" class="text-base font-black text-blue-600 dark:text-blue-400">0 kg (0.00 ton)</h5>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-full">
                            Kapasitas Muatan Terverifikasi
                        </span>
                    </div>
                </div>
            </div>

            <!-- STEP 4: Service Type & Dynamic Pricing -->
            <div id="step-content-4" class="wizard-step space-y-5 hidden">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <iconify-icon icon="solar:calculator-bold-duotone" class="text-xl text-blue-600"></iconify-icon>
                        <span>Tahap 4: Jenis Layanan &amp; Kalkulasi Tarif Otomatis</span>
                    </h3>
                    <p class="text-xs text-slate-500">Pilih opsi pengiriman FTL (Charter Truk) atau LTL (Kargo Konsolidasi)</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <!-- FTL Option -->
                    <label class="cursor-pointer p-4 rounded-2xl border-2 border-blue-600 bg-blue-50/50 dark:bg-blue-950/40 relative block">
                        <input type="radio" name="serviceType" value="FTL" checked onchange="calculateDynamicTariff()" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <h4 class="font-black text-sm text-slate-900 dark:text-white">FTL (Full Truckload)</h4>
                        <p class="text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Sewa armada penuh eksklusif (CDD/Fuso/Wingbox) untuk satu rute terpadu.</p>
                        <span class="inline-block mt-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-600 text-white">Rekomendasi Terbaik</span>
                    </label>

                    <!-- LTL Option -->
                    <label class="cursor-pointer p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 relative block hover:border-slate-400 transition-colors">
                        <input type="radio" name="serviceType" value="LTL" onchange="calculateDynamicTariff()" class="absolute top-4 right-4 text-blue-600 focus:ring-blue-500" />
                        <h4 class="font-black text-sm text-slate-900 dark:text-white">LTL (Less than Truckload)</h4>
                        <p class="text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Pengiriman kargo ritel berbasis tarif per kilogram koli.</p>
                    </label>
                </div>

                <!-- Dynamic Pricing Breakdown Card -->
                <div class="bg-slate-50 dark:bg-slate-900/60 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 space-y-3 text-xs">
                    <h4 class="font-black text-slate-900 dark:text-white uppercase tracking-wider text-[11px]">Rincian Perhitungan Tarif Transporter</h4>
                    
                    <div class="flex justify-between items-center text-slate-600 dark:text-slate-300">
                        <span>Tarif Dasar Rute:</span>
                        <span id="rateBaseDisplay" class="font-mono font-bold">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-600 dark:text-slate-300">
                        <span>Biaya Tambahan Multi-Drop (<span id="dropCountDisplay">0</span> drop tambahan):</span>
                        <span id="rateMultiDropDisplay" class="font-mono font-bold">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-600 dark:text-slate-300">
                        <span>Asuransi Muatan Barang (0.15%):</span>
                        <span id="rateInsuranceDisplay" class="font-mono font-bold">Rp 0</span>
                    </div>
                    <div class="pt-3 border-t border-slate-200 dark:border-slate-700 flex justify-between items-center text-sm font-black text-slate-900 dark:text-white">
                        <span>Total Estimasi Biaya Pengiriman:</span>
                        <span id="rateTotalDisplay" class="text-base text-blue-600 dark:text-blue-400 font-mono">Rp 0</span>
                    </div>
                </div>
            </div>

            <!-- STEP 5: Final Review & Confirmation -->
            <div id="step-content-5" class="wizard-step space-y-5 hidden">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <iconify-icon icon="solar:check-circle-bold-duotone" class="text-xl text-emerald-500"></iconify-icon>
                        <span>Tahap 5: Tinjauan &amp; Konfirmasi Request Order</span>
                    </h3>
                    <p class="text-xs text-slate-500">Periksa kembali detail pemesanan sebelum diteruskan ke kurir logistik</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-2">
                        <h5 class="font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider text-[10px]">Titik Muat &amp; Tujuan</h5>
                        <p><strong class="text-slate-700 dark:text-slate-300">Asal:</strong> <span id="reviewOrigin">-</span></p>
                        <p><strong class="text-slate-700 dark:text-slate-300">Tujuan:</strong> <span id="reviewDestinations">-</span></p>
                        <p><strong class="text-slate-700 dark:text-slate-300">Waktu Muat:</strong> <span id="reviewDeparture">-</span></p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-2">
                        <h5 class="font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider text-[10px]">Muatan &amp; Layanan</h5>
                        <p><strong class="text-slate-700 dark:text-slate-300">Layanan:</strong> <span id="reviewService">-</span></p>
                        <p><strong class="text-slate-700 dark:text-slate-300">Total Muatan:</strong> <span id="reviewWeight">-</span></p>
                        <p><strong class="text-slate-700 dark:text-slate-300">Total Tarif:</strong> <span id="reviewTotalCost" class="text-blue-600 font-bold">-</span></p>
                    </div>
                </div>

                <div class="text-xs">
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">No. Referensi PO Korporasi (Opsional)</label>
                    <input type="text" id="poReference" placeholder="PO/CORP/2026/10/001" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                </div>
            </div>

            <!-- Wizard Navigation Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-slate-100 dark:border-slate-700 mt-6">
                <button type="button" id="prevBtn" onclick="prevStep()" class="px-5 py-2.5 rounded-xl font-bold text-xs text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all hidden">
                    &larr; Kembali
                </button>
                <div class="ml-auto flex items-center gap-2">
                    <button type="button" id="nextBtn" onclick="nextStep()" class="px-6 py-2.5 rounded-xl font-bold text-xs text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2">
                        <span>Lanjut Tahap Berikutnya</span>
                        <iconify-icon icon="solar:arrow-right-linear" class="text-base"></iconify-icon>
                    </button>
                    <button type="button" id="submitBtn" onclick="submitRequestOrder()" class="px-6 py-2.5 rounded-xl font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-500 shadow-md shadow-emerald-600/25 transition-all flex items-center gap-2 hidden">
                        <iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon>
                        <span>Kirim Request Order Sekarang</span>
                    </button>
                </div>
            </div>

        </div>

    </div>

    @push('scripts')
    <script src="{{ asset('assets/js/ro-wizard.js') }}"></script>
    @endpush
</x-layout.app>
