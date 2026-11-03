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
                    Formulir pemesanan armada truk langsung (Direct Route) dengan tarif kontrak dinamis
                </p>
            </div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 text-xs font-bold">
                <iconify-icon icon="solar:calculator-bold-duotone" class="text-base text-blue-600"></iconify-icon>
                <span>Direct Truck Rate Engine Active</span>
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
                    <span class="font-bold text-slate-600 dark:text-slate-400 hidden sm:block">Tujuan Langsung</span>
                </div>
                <!-- Step 3 -->
                <div id="step-nav-3" class="step-nav-item flex flex-col items-center gap-1.5 cursor-pointer opacity-40" onclick="goToStep(3)">
                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold flex items-center justify-center text-xs">3</div>
                    <span class="font-bold text-slate-600 dark:text-slate-400 hidden sm:block">Muatan SKU</span>
                </div>
                <!-- Step 4 -->
                <div id="step-nav-4" class="step-nav-item flex flex-col items-center gap-1.5 cursor-pointer opacity-40" onclick="goToStep(4)">
                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold flex items-center justify-center text-xs">4</div>
                    <span class="font-bold text-slate-600 dark:text-slate-400 hidden sm:block">Armada &amp; Tarif Truk</span>
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

            <!-- STEP 1: Origin Warehouse & Shipper (Using Modal Picker) -->
            <div id="step-content-1" class="wizard-step space-y-5">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <iconify-icon icon="solar:warehouse-bold-duotone" class="text-xl text-blue-600"></iconify-icon>
                        <span>Tahap 1: Titik Muat / Gudang Asal</span>
                    </h3>
                    <p class="text-xs text-slate-500">Pilih hub keberangkatan armada dan waktu kesiapan kargo menggunakan picker pencarian</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <x-modal-picker 
                            id="originWarehouse" 
                            name="origin_warehouse_id" 
                            label="Gudang / Hub Asal" 
                            url="/api/warehouses" 
                            placeholder="Cari & Pilih Gudang Asal..." 
                            :required="true" 
                        />
                    </div>
                    <div>
                        <label class="block font-bold text-xs text-slate-700 dark:text-slate-300 mb-1.5">
                            Jadwal Muat (Departure Date) <span class="text-rose-500">*</span>
                        </label>
                        <input type="datetime-local" id="departureDate" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-600 focus:outline-none text-xs" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-bold text-xs text-slate-700 dark:text-slate-300 mb-1.5">
                            Kontak PIC Pemuatan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="shipperPic" required placeholder="Nama PIC Gudang" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs" />
                    </div>
                    <div>
                        <label class="block font-bold text-xs text-slate-700 dark:text-slate-300 mb-1.5">
                            Nomor Telepon PIC <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="shipperPhone" required placeholder="081234567890" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs" />
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-xs text-slate-700 dark:text-slate-300 mb-1.5">Instruksi Pemuatan di Gudang Asal</label>
                    <textarea id="shipperNotes" rows="2" placeholder="Contoh: Muatan menggunakan pallet plastik standar, wajib lashing rapat dan terpal ganda..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs"></textarea>
                </div>
            </div>

            <!-- STEP 2: Direct Route Destination (Using Modal Picker for Kota/Kabupaten) -->
            <div id="step-content-2" class="wizard-step space-y-5 hidden">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <iconify-icon icon="solar:routing-2-bold-duotone" class="text-xl text-blue-600"></iconify-icon>
                            <span>Tahap 2: Tujuan Pengiriman Langsung (Direct Route Destination)</span>
                        </h3>
                        <p class="text-xs text-slate-500">Tentukan lokasi penurunan barang langsung (direct route) dari gudang asal ke alamat penerima</p>
                    </div>
                </div>

                <div id="dropPointsContainer" class="space-y-4">
                    <!-- Drop Point 1 (Direct Destination) -->
                    <div class="drop-point-card p-4 sm:p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-600 text-white">
                                Tujuan Pengiriman Langsung (Direct Destination)
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                            <div>
                                <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">
                                    Nama Penerima / Toko <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" class="drop-recipient w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs" placeholder="Toko Mitra Grosir" required />
                            </div>
                            <div>
                                <x-modal-picker 
                                    id="destinationCity" 
                                    name="destination_city_code" 
                                    label="Kota / Kabupaten" 
                                    url="/api/wilayah/kota" 
                                    placeholder="Cari Kota / Kabupaten..." 
                                    :required="true" 
                                />
                            </div>
                            <div>
                                <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">
                                    Telepon Penerima <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" class="drop-phone w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs" placeholder="081987654321" required />
                            </div>
                        </div>
                        <div class="text-xs">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">
                                Alamat Lengkap Bongkar <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" class="drop-address w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs" placeholder="Jl. Raya Kopo No. 120, Kota Bandung" required />
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 3: Product Cargo Selection (With SKU Modal Picker) -->
            <div id="step-content-3" class="wizard-step space-y-5 hidden">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="text-xl text-blue-600"></iconify-icon>
                            <span>Tahap 3: Muatan Barang &amp; SKU Produk</span>
                        </h3>
                        <p class="text-xs text-slate-500">Pilih item dari katalog produk melalui picker SKU untuk kalkulasi otomatis tonase dan volume</p>
                    </div>
                    <button type="button" onclick="openProductPickerForNewRow()" class="px-3.5 py-2 rounded-xl text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-all flex items-center gap-1.5 shadow-sm">
                        <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                        <span>+ Tambah Baris Barang</span>
                    </button>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-700">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                <th class="py-3 px-4 w-12">No</th>
                                <th class="py-3 px-4">Produk SKU</th>
                                <th class="py-3 px-2 w-32 text-center">Jumlah (Qty)</th>
                                <th class="py-3 px-3 w-32 text-right">Berat / Unit</th>
                                <th class="py-3 px-4 w-36 text-right">Subtotal Berat</th>
                                <th class="py-3 px-2 w-12 text-center"></th>
                            </tr>
                        </thead>
                        <tbody id="productRowsBody" class="divide-y divide-slate-100 dark:divide-slate-700/50 bg-white dark:bg-slate-800">
                            <!-- Rows injected dynamically via Picker selection -->
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
                            <span class="text-slate-500 dark:text-slate-400">Total Tonase Kargo:</span>
                            <h5 id="totalWeightDisplay" class="text-base font-black text-blue-600 dark:text-blue-400">0 kg (0.00 ton)</h5>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-1 rounded-full border border-emerald-200 dark:border-emerald-800">
                            Kapasitas Muatan Terverifikasi
                        </span>
                    </div>
                </div>

                <!-- Product Modal Picker Component (Standalone, Zero Backdrop Conflict) -->
                <div id="modal-product-picker" class="fixed inset-0 z-[100] items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;" onclick="window.closeProductPickerModal && window.closeProductPickerModal()">
                    <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-xl w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700 relative z-10 max-h-[90vh] flex flex-col" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700 mb-4">
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">Pilih Muatan SKU Produk</h3>
                            <button type="button" onclick="window.closeProductPickerModal && window.closeProductPickerModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700">
                                <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                            </button>
                        </div>
                        <div class="mb-4">
                            <div class="relative">
                                <input type="text" id="search-product-picker" class="w-full pl-9 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none text-slate-800 dark:text-slate-100" placeholder="Ketik SKU atau nama produk...">
                                <iconify-icon icon="solar:rounded-magnifer-linear" class="absolute left-3 top-3 text-slate-400 text-sm"></iconify-icon>
                            </div>
                        </div>
                        
                        <div class="overflow-y-auto overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-700 flex-1 max-h-72">
                            <table class="w-full text-left text-xs divide-y divide-slate-100 dark:divide-slate-700">
                                <thead class="bg-slate-50 dark:bg-slate-900 text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider text-[10px] sticky top-0 z-10">
                                    <tr>
                                        <th scope="col" class="px-4 py-2.5 w-12">No</th>
                                        <th scope="col" class="px-4 py-2.5">SKU / Kode</th>
                                        <th scope="col" class="px-4 py-2.5">Nama Produk</th>
                                        <th scope="col" class="px-4 py-2.5 text-right">Berat Satuan</th>
                                        <th scope="col" class="px-4 py-2.5 text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-product-picker" class="divide-y divide-slate-100 dark:divide-slate-700/60 bg-white dark:bg-slate-800">
                                    <!-- Products rendered dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 4: Truck Fleet Selection & Direct Truck Rate (No Layanan FTL/LTL, Direct Rate of Truck) -->
            <div id="step-content-4" class="wizard-step space-y-5 hidden">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <iconify-icon icon="solar:delivery-bold-duotone" class="text-xl text-blue-600"></iconify-icon>
                            <span>Tahap 4: Pilihan Armada Truk &amp; Tarif Kontrak Langsung</span>
                        </h3>
                        <p class="text-xs text-slate-500">Pilih model armada truk charter sesuai kapasitas tonase kargo untuk mengunci tarif kontrak langsung</p>
                    </div>
                    <div id="fleetRecommendedBadge" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                        <iconify-icon icon="solar:check-circle-bold" class="text-blue-600"></iconify-icon>
                        <span id="recommendedFleetText">Rekomendasi Armada Aktif</span>
                    </div>
                </div>

                <!-- Fleet / Truck Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs" id="fleetSelectionContainer">
                    <!-- CDE Card -->
                    <div class="fleet-card cursor-pointer p-4 rounded-2xl border-2 border-blue-600 bg-blue-50/40 dark:bg-blue-950/40 relative flex flex-col justify-between transition-all hover:shadow-md" data-fleet-id="1" data-capacity="2000" onclick="selectFleet(1)">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="p-2 rounded-xl bg-blue-100 dark:bg-blue-900/60 text-blue-600 dark:text-blue-400">
                                    <iconify-icon icon="solar:delivery-bold" class="text-xl"></iconify-icon>
                                </span>
                                <span class="fleet-badge px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-600 text-white">Dipilih</span>
                            </div>
                            <h4 class="font-black text-sm text-slate-900 dark:text-white">CDE Box (Engkel)</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Colt Diesel Engkel 4 Roda</p>
                            
                            <div class="mt-3 space-y-1 text-[11px] text-slate-600 dark:text-slate-300">
                                <div class="flex justify-between">
                                    <span>Kapasitas Tonase:</span>
                                    <span class="font-bold">2.000 kg (2.0 Ton)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Volume Muatan:</span>
                                    <span class="font-bold">7.0 CBM</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700">
                            <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Tarif Dasar Truk:</span>
                            <div class="text-sm font-black text-blue-600 dark:text-blue-400 fleet-rate-display" id="cde-rate-display">Rp 3.500.000</div>
                        </div>
                    </div>

                    <!-- CDD Card -->
                    <div class="fleet-card cursor-pointer p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 relative flex flex-col justify-between transition-all hover:shadow-md hover:border-blue-400" data-fleet-id="2" data-capacity="4000" onclick="selectFleet(2)">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                    <iconify-icon icon="solar:transmission-bold" class="text-xl"></iconify-icon>
                                </span>
                                <span class="fleet-badge px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-300 hidden">Dipilih</span>
                            </div>
                            <h4 class="font-black text-sm text-slate-900 dark:text-white">CDD Box (Double)</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Colt Diesel Double 6 Roda</p>
                            
                            <div class="mt-3 space-y-1 text-[11px] text-slate-600 dark:text-slate-300">
                                <div class="flex justify-between">
                                    <span>Kapasitas Tonase:</span>
                                    <span class="font-bold">4.000 kg (4.0 Ton)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Volume Muatan:</span>
                                    <span class="font-bold">14.0 CBM</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700">
                            <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Tarif Dasar Truk:</span>
                            <div class="text-sm font-black text-slate-900 dark:text-white fleet-rate-display" id="cdd-rate-display">Rp 4.500.000</div>
                        </div>
                    </div>

                    <!-- Fuso Card -->
                    <div class="fleet-card cursor-pointer p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 relative flex flex-col justify-between transition-all hover:shadow-md hover:border-blue-400" data-fleet-id="3" data-capacity="8000" onclick="selectFleet(3)">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                    <iconify-icon icon="solar:bus-bold" class="text-xl"></iconify-icon>
                                </span>
                                <span class="fleet-badge px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-300 hidden">Dipilih</span>
                            </div>
                            <h4 class="font-black text-sm text-slate-900 dark:text-white">Fuso Heavy Box</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Medium Truck Heavy Duty</p>
                            
                            <div class="mt-3 space-y-1 text-[11px] text-slate-600 dark:text-slate-300">
                                <div class="flex justify-between">
                                    <span>Kapasitas Tonase:</span>
                                    <span class="font-bold">8.000 kg (8.0 Ton)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Volume Muatan:</span>
                                    <span class="font-bold">30.0 CBM</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700">
                            <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Tarif Dasar Truk:</span>
                            <div class="text-sm font-black text-slate-900 dark:text-white fleet-rate-display" id="fuso-rate-display">Rp 7.500.000</div>
                        </div>
                    </div>

                    <!-- Tronton Wingbox Card -->
                    <div class="fleet-card cursor-pointer p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 relative flex flex-col justify-between transition-all hover:shadow-md hover:border-blue-400" data-fleet-id="4" data-capacity="15000" onclick="selectFleet(4)">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                    <iconify-icon icon="solar:box-bold" class="text-xl"></iconify-icon>
                                </span>
                                <span class="fleet-badge px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-300 hidden">Dipilih</span>
                            </div>
                            <h4 class="font-black text-sm text-slate-900 dark:text-white">Tronton Wingbox</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Heavy Long Wingbox 3-Axle</p>
                            
                            <div class="mt-3 space-y-1 text-[11px] text-slate-600 dark:text-slate-300">
                                <div class="flex justify-between">
                                    <span>Kapasitas Tonase:</span>
                                    <span class="font-bold">15.000 kg (15.0 Ton)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Volume Muatan:</span>
                                    <span class="font-bold">48.0 CBM</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700">
                            <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Tarif Dasar Truk:</span>
                            <div class="text-sm font-black text-slate-900 dark:text-white fleet-rate-display" id="tronton-rate-display">Rp 12.500.000</div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="selectedFleetTypeId" name="fleet_type_id" value="1" />

                <!-- Direct Route Truck Pricing Breakdown Card -->
                <div class="bg-slate-50 dark:bg-slate-900/60 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 space-y-3 text-xs">
                    <div class="flex items-center justify-between">
                        <h4 class="font-black text-slate-900 dark:text-white uppercase tracking-wider text-[11px] flex items-center gap-1.5">
                            <iconify-icon icon="solar:bill-list-bold-duotone" class="text-base text-blue-600"></iconify-icon>
                            <span>Rincian Tarif Kontrak Truk (Direct Route Truck Rate)</span>
                        </h4>
                        <span id="selectedFleetBadgeText" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300">
                            Armada: CDE Box (Engkel)
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center text-slate-600 dark:text-slate-300">
                        <span>Tarif Sewa Armada Truk (Rate of Truck - Linehaul):</span>
                        <span id="rateBaseDisplay" class="font-mono font-bold">Rp 3.500.000</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-600 dark:text-slate-300">
                        <span>Biaya Langsir &amp; Handling (Direct Bongkar Muat):</span>
                        <span id="rateShuntingDisplay" class="font-mono font-bold">Rp 450.000</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-600 dark:text-slate-300">
                        <span>Asuransi Muatan Barang (0.15%):</span>
                        <span id="rateInsuranceDisplay" class="font-mono font-bold">Rp 5.250</span>
                    </div>
                    <div class="pt-3 border-t border-slate-200 dark:border-slate-700 flex justify-between items-center text-sm font-black text-slate-900 dark:text-white">
                        <span>Total Tarif Pengiriman Truk:</span>
                        <span id="rateTotalDisplay" class="text-base text-blue-600 dark:text-blue-400 font-mono font-black">Rp 3.955.250</span>
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
                    <p class="text-xs text-slate-500">Periksa kembali detail pemesanan armada truk sebelum diteruskan ke transporter logistik</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-2">
                        <h5 class="font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider text-[10px]">Titik Muat &amp; Tujuan</h5>
                        <p><strong class="text-slate-700 dark:text-slate-300">Gudang Asal:</strong> <span id="reviewOrigin">-</span></p>
                        <p><strong class="text-slate-700 dark:text-slate-300">Tujuan Direct:</strong> <span id="reviewDestinations">-</span></p>
                        <p><strong class="text-slate-700 dark:text-slate-300">Jadwal Muat:</strong> <span id="reviewDeparture">-</span></p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-2">
                        <h5 class="font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider text-[10px]">Armada &amp; Tarif Truk</h5>
                        <p><strong class="text-slate-700 dark:text-slate-300">Armada Truk:</strong> <span id="reviewFleet">-</span></p>
                        <p><strong class="text-slate-700 dark:text-slate-300">Total Muatan:</strong> <span id="reviewWeight">-</span></p>
                        <p><strong class="text-slate-700 dark:text-slate-300">Total Tarif Truk:</strong> <span id="reviewTotalCost" class="text-blue-600 font-black">-</span></p>
                    </div>
                </div>

                <div class="text-xs">
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">No. Referensi PO Korporasi (Opsional)</label>
                    <input type="text" id="poReference" placeholder="PO/CORP/2026/10/001" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs" />
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
    <script src="{{ asset('assets/js/ro-wizard.js') }}?v={{ time() }}"></script>
    @endpush
</x-layout.app>
