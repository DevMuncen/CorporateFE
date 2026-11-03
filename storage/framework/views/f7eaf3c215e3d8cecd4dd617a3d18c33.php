<?php if (isset($component)) { $__componentOriginalcf7e1d4949dbd350ec830409f7127ebc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf7e1d4949dbd350ec830409f7127ebc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.app','data' => ['title' => 'Dashboard | Corporate Merchant Portal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard | Corporate Merchant Portal']); ?>
    <div class="space-y-6">

        <!-- 1. Top Greeting Card -->
        <div class="card bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden border border-blue-800/40">
            <!-- Background Decorative Illustration -->
            <div class="absolute right-0 top-0 bottom-0 w-1/3 opacity-10 pointer-events-none flex items-center justify-end pr-8">
                <iconify-icon icon="solar:buildings-bold-duotone" class="text-[240px]"></iconify-icon>
            </div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 text-blue-200 border border-blue-400/30 text-xs font-semibold mb-3 backdrop-blur-md">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Corporate Portal Port 8004 &bull; Backend 8001 Connected
                    </div>
                    <h1 class="text-2xl md:text-3xl font-black tracking-tight text-white mb-2" style="color: #ffffff !important;">
                        Selamat Datang, <?php echo e(session('user_name', 'Corporate Merchant')); ?> &#128075;
                    </h1>
                    <p class="text-slate-300 text-xs md:text-sm max-w-2xl font-medium leading-relaxed" style="color: #cbd5e1 !important;">
                        Pusat kendali operasional multi-gudang, manajemen katalog SKU korporasi, pesanan distributor, dan penerbitan Request Order (RO) pengiriman multimoda.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3 shrink-0">
                    <a href="/request-orders/create" class="px-4 py-2.5 rounded-xl font-bold text-xs md:text-sm text-white bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-600/30 border border-blue-400/30 transition-all flex items-center gap-2">
                        <iconify-icon icon="solar:cart-plus-bold-duotone" class="text-lg text-white"></iconify-icon>
                        <span class="text-white">+ Buat Request Order</span>
                    </a>
                    <a href="/products" class="px-4 py-2.5 rounded-xl font-bold text-xs md:text-sm text-white bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md transition-all flex items-center gap-2">
                        <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="text-lg text-blue-300"></iconify-icon>
                        <span class="text-white">Katalog Produk</span>
                    </a>
                    <a href="/waybills" class="px-4 py-2.5 rounded-xl font-bold text-xs md:text-sm text-slate-200 bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700 transition-all flex items-center gap-2">
                        <iconify-icon icon="solar:routing-2-bold-duotone" class="text-lg text-emerald-400"></iconify-icon>
                        <span>Lacak Waybill</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 2. Six Key Operational Metric Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-4">
            <!-- Card 1: Total SKU Products -->
            <div class="card stat-box bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl shrink-0">
                        <iconify-icon icon="solar:box-minimalistic-bold-duotone"></iconify-icon>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300">
                        Katalog
                    </span>
                </div>
                <div class="mt-3">
                    <p class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Produk</p>
                    <h4 id="stat-products" class="text-xl font-black text-slate-900 dark:text-white mt-0.5">...</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">SKU Terdaftar</p>
                </div>
            </div>

            <!-- Card 2: Warehouses -->
            <div class="card stat-box bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl shrink-0">
                        <iconify-icon icon="solar:buildings-bold-duotone"></iconify-icon>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300">
                        Hub Transit
                    </span>
                </div>
                <div class="mt-3">
                    <p class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Gudang Aktif</p>
                    <h4 id="stat-warehouses" class="text-xl font-black text-slate-900 dark:text-white mt-0.5">...</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Origin & Depo</p>
                </div>
            </div>

            <!-- Card 3: Request Orders -->
            <div class="card stat-box bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl shrink-0">
                        <iconify-icon icon="solar:cart-bold-duotone"></iconify-icon>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300">
                        Diproses
                    </span>
                </div>
                <div class="mt-3">
                    <p class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Request Order</p>
                    <h4 id="stat-ros" class="text-xl font-black text-slate-900 dark:text-white mt-0.5">...</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Menunggu Dispatch</p>
                </div>
            </div>

            <!-- Card 4: Waybills Dispatched -->
            <div class="card stat-box bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl shrink-0">
                        <iconify-icon icon="solar:delivery-bold-duotone"></iconify-icon>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300">
                        In Transit
                    </span>
                </div>
                <div class="mt-3">
                    <p class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Surat Jalan</p>
                    <h4 id="stat-waybills" class="text-xl font-black text-slate-900 dark:text-white mt-0.5">...</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Waybill Dispatched</p>
                </div>
            </div>

            <!-- Card 5: Inventory Stock Available -->
            <div class="card stat-box bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 dark:text-sky-400 flex items-center justify-center text-xl shrink-0">
                        <iconify-icon icon="solar:archive-bold-duotone"></iconify-icon>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-sky-50 text-sky-700 dark:bg-sky-950/60 dark:text-sky-300">
                        Tersedia
                    </span>
                </div>
                <div class="mt-3">
                    <p class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Stok Gudang</p>
                    <h4 id="stat-stocks" class="text-xl font-black text-slate-900 dark:text-white mt-0.5">...</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Total Koli / Unit</p>
                </div>
            </div>

            <!-- Card 6: Invoices & Receivables -->
            <div class="card stat-box bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl shrink-0">
                        <iconify-icon icon="solar:bill-list-bold-duotone"></iconify-icon>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 dark:bg-purple-950/60 dark:text-purple-300">
                        Piutang B2B
                    </span>
                </div>
                <div class="mt-3">
                    <p class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Faktur B2B</p>
                    <h4 id="stat-invoices" class="text-xl font-black text-slate-900 dark:text-white mt-0.5">...</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Invoice Terbit</p>
                </div>
            </div>
        </div>

        <!-- 3. Main Content: Recent Request Orders & Real-time Waybills -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: Active Request Orders -->
            <div class="lg:col-span-2 card bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs p-6">
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100 dark:border-slate-700/60">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">
                            Request Order (RO) Terbaru
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Status pesanan pengiriman dari korporasi ke jaringan logistik
                        </p>
                    </div>
                    <a href="/request-orders" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                        <span>Lihat Semua</span>
                        <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold bg-slate-50/75 dark:bg-slate-800/80">
                                <th class="py-3 px-3 rounded-l-lg w-12">No</th>
                                <th class="py-3 px-2">No. RO</th>
                                <th class="py-3 px-2">Gudang Asal</th>
                                <th class="py-3 px-2">Tujuan / Drop</th>
                                <th class="py-3 px-2 text-right">Muatan</th>
                                <th class="py-3 px-2 text-center">Status</th>
                                <th class="py-3 px-3 text-right rounded-r-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dash-recent-ros-body" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">
                                    <div class="inline-flex items-center gap-2">
                                        <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                        <span>Memuat daftar request order...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right 1 Col: Quick Links & Warehouse Status -->
            <div class="space-y-6">
                <!-- Warehouse Inventory Health Card -->
                <div class="card bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs p-6">
                    <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100 dark:border-slate-700/60">
                        <h3 class="text-base font-black text-slate-900 dark:text-white">
                            Hub Gudang Utama
                        </h3>
                        <a href="/warehouses" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">Kelola</a>
                    </div>
                    <div id="dash-warehouses-list" class="space-y-3">
                        <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-700/40 border border-slate-200/80 dark:border-slate-700 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 flex items-center justify-center font-bold text-lg shrink-0">
                                    <iconify-icon icon="solar:buildings-bold-duotone"></iconify-icon>
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold text-slate-900 dark:text-slate-100">Gudang Pusat Cikarang</h5>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">Bekasi, Jawa Barat</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/40">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const setStat = (id, val) => {
                const el = document.getElementById(id);
                if (el) el.innerText = val;
            };

            // 1. Fetch Dashboard Summary
            try {
                const res = await axios.get('/api/dashboard/summary');
                if (res && res.data) {
                    const raw = res.data.data || res.data;
                    const s = raw.summary || raw;
                    setStat('stat-products', s.total_products ?? s.jumlah_produk ?? 0);
                    setStat('stat-warehouses', s.total_warehouses ?? s.jumlah_gudang ?? 0);
                    setStat('stat-ros', s.total_request_orders ?? s.request_order ?? 0);
                    setStat('stat-waybills', s.total_waybills ?? s.surat_jalan ?? 0);
                    setStat('stat-stocks', (s.total_stock_units ?? s.stok_tersedia ?? 0).toLocaleString('id-ID'));
                    setStat('stat-invoices', s.total_invoices ?? s.jumlah_distributor ?? 0);
                }
            } catch (err) {
                console.warn('Dashboard summary fetch error:', err);
                setStat('stat-products', '0');
                setStat('stat-warehouses', '0');
                setStat('stat-ros', '0');
                setStat('stat-waybills', '0');
                setStat('stat-stocks', '0');
                setStat('stat-invoices', '0');
            }

            // 2. Fetch Active Warehouses for Widget
            try {
                const whRes = await axios.get('/api/warehouses');
                const whList = whRes.data?.data || [];
                const whContainer = document.getElementById('dash-warehouses-list');
                if (whContainer) {
                    if (!whList.length) {
                        whContainer.innerHTML = '<p class="text-xs text-slate-400 py-4 text-center">Belum ada gudang terdaftar.</p>';
                    } else {
                        whContainer.innerHTML = whList.slice(0, 4).map(wh => `
                            <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-700/40 border border-slate-200/80 dark:border-slate-700 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 flex items-center justify-center font-bold text-lg shrink-0">
                                        <iconify-icon icon="solar:buildings-bold-duotone"></iconify-icon>
                                    </div>
                                    <div>
                                        <h5 class="text-xs font-bold text-slate-900 dark:text-slate-100">${wh.name}</h5>
                                        <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">${wh.city || '-'}, ${wh.address || ''}</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/40">Aktif</span>
                            </div>
                        `).join('');
                    }
                }
            } catch (whErr) {
                console.warn('Fetch warehouses widget error:', whErr);
            }

            // 3. Fetch Recent Request Orders
            const tbody = document.getElementById('dash-recent-ros-body');
            try {
                const res = await axios.get('/api/request-orders?per_page=5');
                const items = res?.data?.data?.data || res?.data?.data || [];
                
                if (!items.length) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                Belum ada Request Order (RO) yang diterbitkan.
                            </td>
                        </tr>
                    `;
                    return;
                }

                tbody.innerHTML = items.map((ro, idx) => {
                    const statusClass = {
                        'draft': 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                        'submitted': 'bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300',
                        'approved': 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300',
                        'confirmed': 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300',
                        'dispatched': 'bg-amber-100 text-amber-700 dark:bg-amber-900/60 dark:text-amber-300',
                        'in_transit': 'bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300',
                        'delivered': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300',
                        'completed': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300',
                        'cancelled': 'bg-red-100 text-red-700 dark:bg-red-900/60 dark:text-red-300'
                    }[ro.status?.toLowerCase()] || 'bg-slate-100 text-slate-700';

                    return `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="py-3 px-3 font-bold text-slate-500">${idx + 1}</td>
                            <td class="py-3 px-2 font-bold text-blue-600 dark:text-blue-400 font-mono">${ro.order_number || ro.ro_number || 'RO-#' + ro.id}</td>
                            <td class="py-3 px-2 text-slate-800 dark:text-slate-200 font-semibold">${ro.origin_warehouse?.name || 'Gudang Pusat'}</td>
                            <td class="py-3 px-2 text-slate-600 dark:text-slate-400">${ro.destination_city || ro.recipient_name || 'Kota Tujuan'}</td>
                            <td class="py-3 px-2 text-right font-semibold text-slate-800 dark:text-slate-200">${ro.total_weight_kg || ro.total_weight || 0} kg</td>
                            <td class="py-3 px-2 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider ${statusClass}">
                                    ${ro.status || 'Draft'}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <a href="/request-orders/${ro.id}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">Detail &rarr;</a>
                            </td>
                        </tr>
                    `;
                }).join('');
            } catch (err) {
                console.warn('Recent ROs fetch error:', err);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400">
                            Gagal memuat Request Order terbaru.
                        </td>
                    </tr>
                `;
            }
        });
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
<?php /**PATH D:\DevMuncen\CorporateFE\resources\views/dashboard.blade.php ENDPATH**/ ?>