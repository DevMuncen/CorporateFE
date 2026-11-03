<?php if (isset($component)) { $__componentOriginalcf7e1d4949dbd350ec830409f7127ebc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf7e1d4949dbd350ec830409f7127ebc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.app','data' => ['title' => 'Detail & Pelacakan Waybill | Corporate Merchant Portal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Detail & Pelacakan Waybill | Corporate Merchant Portal']); ?>
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
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 text-xs">
                <div>
                    <span class="text-slate-400 uppercase font-bold text-[10px] tracking-wider">Ref Request Order</span>
                    <h5 class="mt-0.5">
                        <a id="wbRoLink" href="/request-orders" class="text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:underline">-</a>
                    </h5>
                </div>
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

        <!-- Manifest Muatan Kargo (Cargo Items) -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div class="flex items-center gap-2 text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider">
                    <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="text-xl text-blue-600"></iconify-icon>
                    <span>Manifest Muatan Kargo (Cargo Items)</span>
                </div>
                <div class="text-xs font-bold text-slate-600 dark:text-slate-300">
                    Total: <span id="wbTotalKoli" class="text-blue-600">0</span> Koli | <span id="wbTotalWeight" class="text-blue-600">0</span> Kg
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-100 dark:border-slate-700">
                <table class="w-full text-left text-xs divide-y divide-slate-100 dark:divide-slate-700">
                    <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 font-bold uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-4 w-12">No</th>
                            <th class="py-3 px-4 w-28">Kode SKU</th>
                            <th class="py-3 px-4">Produk / Deskripsi Kargo</th>
                            <th class="py-3 px-4 text-center w-28">Jumlah (Qty)</th>
                            <th class="py-3 px-4 text-end w-36">Berat Estimasi</th>
                            <th class="py-3 px-4">Catatan</th>
                        </tr>
                    </thead>
                    <tbody id="wbManifestTbody" class="divide-y divide-slate-100 dark:divide-slate-700">
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Memuat rincian muatan...</td>
                        </tr>
                    </tbody>
                </table>
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
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-blue-600 border-2 border-white dark:border-slate-800"></div>
                        <h5 class="font-bold text-slate-900 dark:text-white">Waybill Diterbitkan</h5>
                        <p class="text-slate-500" id="tlCreatedText">Surat jalan diterbitkan dan armada dijadwalkan.</p>
                    </div>
                </div>
            </div>

            <!-- Proof of Delivery (POD) & Documents Card -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-4">
                <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:document-text-bold-duotone" class="text-xl text-emerald-500"></iconify-icon>
                    <span>Bukti Serah Terima (POD)</span>
                </h3>

                <div id="podCard" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-center text-xs space-y-3">
                    <iconify-icon icon="solar:camera-bold-duotone" class="text-3xl text-slate-400"></iconify-icon>
                    <p class="text-slate-500">Foto bukti serah terima atau tanda tangan digital penerima</p>
                    <span id="podBadge" class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700">
                        Menunggu Konfirmasi Drop
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Preview Lampiran POD -->
    <div id="podPreviewModal" class="fixed inset-0 z-[80] hidden items-center justify-center bg-slate-900/70 backdrop-blur-xs p-4" onclick="closePodPreviewModal()">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-2xl max-w-3xl w-full overflow-hidden flex flex-col max-h-[90vh]" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-2">
                    <iconify-icon icon="solar:verified-check-bold" class="text-lg text-emerald-600"></iconify-icon>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white" id="podPreviewTitle">Lampiran Bukti Serah Terima (POD)</h4>
                </div>
                <button type="button" onclick="closePodPreviewModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 overflow-y-auto flex-1 flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-900/50 space-y-3">
                <img id="podPreviewImage" src="" alt="Bukti Serah Terima (POD)" class="max-h-[65vh] w-auto rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm object-contain bg-white" />
                <div id="podPreviewMeta" class="text-xs text-slate-600 dark:text-slate-300 text-center"></div>
            </div>
            <div class="px-5 py-3 border-t border-slate-200 dark:border-slate-700 flex items-center justify-end gap-2 bg-white dark:bg-slate-800">
                <a id="podModalPrintBtn" href="#" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 transition-all inline-flex items-center gap-1.5">
                    <iconify-icon icon="solar:printer-bold"></iconify-icon>
                    <span>Cetak Surat Jalan / POD</span>
                </a>
                <button type="button" onclick="closePodPreviewModal()" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function openPodPreviewModal(imgUrl, wbNumber, receiverName, deliveredAt) {
            const modal = document.getElementById('podPreviewModal');
            const img = document.getElementById('podPreviewImage');
            const title = document.getElementById('podPreviewTitle');
            const meta = document.getElementById('podPreviewMeta');
            if (img) img.src = imgUrl;
            if (title) title.innerText = `Lampiran POD — ${wbNumber || 'Waybill'}`;
            if (meta) {
                meta.innerHTML = `<span class="font-bold text-slate-800 dark:text-slate-100">Penerima: ${receiverName || '-'}</span> &bull; <span>Waktu Serah Terima: ${deliveredAt || '-'}</span>`;
            }
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closePodPreviewModal() {
            const modal = document.getElementById('podPreviewModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        async function loadDetail() {
            const pathParts = window.location.pathname.split('/');
            const id = pathParts[pathParts.length - 1];

            try {
                const res = await axios.get(`/api/waybills/${id}`);
                const wb = res.data?.data;
                if (!wb) return;

                document.getElementById('wbNumberBadge').innerText = wb.waybill_number || 'WB-#' + wb.id;
                const status = (wb.status || 'draft').toUpperCase();
                document.getElementById('wbStatus').innerText = status;
                document.getElementById('wbTransporter').innerText = wb.request_order?.logistic?.name || wb.vendor?.name || 'Muncen Logistics';
                document.getElementById('wbDriver').innerText = wb.driver_name || 'Driver Ekspedisi';
                document.getElementById('wbPlate').innerText = wb.plate_number || wb.request_order?.fleet_type?.name || 'Armada Dedicated';
                document.getElementById('printBtn').href = `/waybills/${id}/print`;
                const modalPrintBtn = document.getElementById('podModalPrintBtn');
                if (modalPrintBtn) modalPrintBtn.href = `/waybills/${id}/print`;

                const roId = wb.request_order_id || wb.request_order?.id;
                const roNum = wb.request_order?.order_number || wb.request_order?.ro_number || (roId ? 'RO-#' + roId : '-');
                const roEl = document.getElementById('wbRoLink');
                if (roEl) {
                    roEl.innerText = roNum;
                    if (roId) roEl.href = `/request-orders/${roId}`;
                }

                // Timeline & POD
                const timeline = document.getElementById('timelineContainer');
                const podCard = document.getElementById('podCard');
                const podBadge = document.getElementById('podBadge');

                if (wb.created_at) {
                    const d = new Date(wb.created_at);
                    document.getElementById('tlCreatedText').innerText = 'Surat jalan diterbitkan pada ' + d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                }

                if (status === 'CONFIRMED' || status === 'TRANSIT' || status === 'IN_TRANSIT' || status === 'DELIVERED' || status === 'PROCESSED' || status === 'FINALIZED') {
                    timeline.innerHTML += `
                        <div class="relative">
                            <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-indigo-500 border-2 border-white dark:border-slate-800"></div>
                            <h5 class="font-bold text-slate-900 dark:text-white">Diterima Hub / Siap Kirim (Confirmed)</h5>
                            <p class="text-slate-500">Kargo telah diverifikasi di hub keberangkatan dan siap diberangkatkan.</p>
                        </div>
                    `;
                }

                if (status === 'TRANSIT' || status === 'IN_TRANSIT' || status === 'DELIVERED' || status === 'PROCESSED' || status === 'FINALIZED') {
                    timeline.innerHTML += `
                        <div class="relative">
                            <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-blue-600 border-2 border-white dark:border-slate-800"></div>
                            <h5 class="font-bold text-slate-900 dark:text-white">Dalam Perjalanan (In Transit)</h5>
                            <p class="text-slate-500">Armada membawa kargo menuju lokasi tujuan penerima.</p>
                        </div>
                    `;
                }

                const isDelivered = (status === 'DELIVERED' || status === 'PROCESSED' || status === 'FINALIZED');
                const podImgUrl = wb.pod_proof_url || wb.pod_proof_photo || '';
                const receiverName = wb.receiver_name || wb.request_order?.recipient_name || wb.request_order?.delivery_points?.[0]?.recipient_name || 'Penerima Terverifikasi';
                const deliveredAtFormatted = wb.delivered_at
                    ? new Date(wb.delivered_at).toLocaleString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })
                    : (wb.updated_at ? new Date(wb.updated_at).toLocaleString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-');

                if (isDelivered || podImgUrl) {
                    if (isDelivered) {
                        timeline.innerHTML += `
                            <div class="relative">
                                <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-800"></div>
                                <h5 class="font-bold text-emerald-600 dark:text-emerald-400">Terkirim / Selesai (Delivered)</h5>
                                <p class="text-slate-500">Kargo telah diterima oleh <strong>${receiverName}</strong> pada ${deliveredAtFormatted}.</p>
                            </div>
                        `;
                    }

                    const fallbackSvg = `data:image/svg+xml;utf8,` + encodeURIComponent(
                        `<svg xmlns="http://www.w3.org/2000/svg" width="520" height="300" viewBox="0 0 520 300">
                            <rect width="520" height="300" rx="16" fill="#f8fafc" stroke="#10b981" stroke-width="3"/>
                            <rect x="20" y="20" width="480" height="52" rx="10" fill="#ecfdf5"/>
                            <text x="40" y="52" font-family="Arial, sans-serif" font-size="18" font-weight="bold" fill="#047857">BUKTI SERAH TERIMA DIGITAL (POD)</text>
                            <text x="40" y="105" font-family="Arial, sans-serif" font-size="14" fill="#334155">No. Waybill: ${wb.waybill_number || 'WB-#' + wb.id}</text>
                            <text x="40" y="135" font-family="Arial, sans-serif" font-size="14" fill="#334155">Penerima: ${receiverName}</text>
                            <text x="40" y="165" font-family="Arial, sans-serif" font-size="14" fill="#334155">Supir / Armada: ${wb.driver_name || 'Driver Ekspedisi'} (${wb.plate_number || 'Dedicated'})</text>
                            <text x="40" y="195" font-family="Arial, sans-serif" font-size="14" fill="#334155">Waktu Terima: ${deliveredAtFormatted}</text>
                            <rect x="310" y="215" width="180" height="55" rx="8" fill="#d1fae5" stroke="#059669" stroke-width="2"/>
                            <text x="400" y="248" text-anchor="middle" font-family="Arial, sans-serif" font-size="13" font-weight="bold" fill="#065f46">TERKONFIRMASI LUNAS / POD</text>
                        </svg>`
                    );
                    const finalPodUrl = podImgUrl || fallbackSvg;
                    window.__currentPodUrl = finalPodUrl;
                    window.__currentWbNumber = wb.waybill_number || ('WB-#' + wb.id);
                    window.__currentReceiver = receiverName;
                    window.__currentDeliveredAt = deliveredAtFormatted;

                    if (podCard) {
                        podCard.innerHTML = `
                            <div class="space-y-3 text-left">
                                <div class="flex items-center justify-between">
                                    <span id="podBadge" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <iconify-icon icon="solar:verified-check-bold" class="text-xs"></iconify-icon>
                                        Terkonfirmasi Diterima (POD)
                                    </span>
                                    <span class="text-[10px] font-mono text-slate-400">${deliveredAtFormatted}</span>
                                </div>

                                <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 cursor-pointer group relative" onclick="openPodPreviewModal(window.__currentPodUrl, window.__currentWbNumber, window.__currentReceiver, window.__currentDeliveredAt)">
                                    <img src="${finalPodUrl}" alt="Lampiran Bukti POD" class="w-full h-44 object-contain bg-white p-1 transition-transform group-hover:scale-[1.02]" />
                                    <div class="px-3 py-1.5 bg-slate-900/75 text-white text-[10px] font-semibold flex items-center justify-between">
                                        <span>Lampiran Bukti Serah Terima</span>
                                        <span class="underline">Klik untuk perbesar</span>
                                    </div>
                                </div>

                                <div class="p-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[11px] space-y-1">
                                    <div class="flex justify-between">
                                        <span class="text-slate-400">Nama Penerima:</span>
                                        <span class="font-bold text-slate-800 dark:text-slate-100">${receiverName}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-400">Waktu Serah Terima:</span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-300">${deliveredAtFormatted}</span>
                                    </div>
                                    ${wb.notes ? `
                                    <div class="pt-1 border-t border-slate-100 dark:border-slate-700 text-slate-500 italic">
                                        "${wb.notes}"
                                    </div>` : ''}
                                </div>

                                <div class="grid grid-cols-1 gap-2 pt-1">
                                    <button type="button" onclick="openPodPreviewModal(window.__currentPodUrl, window.__currentWbNumber, window.__currentReceiver, window.__currentDeliveredAt)" class="w-full py-2 px-3 rounded-xl text-xs font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 hover:bg-emerald-100 transition-all flex items-center justify-center gap-1.5">
                                        <iconify-icon icon="solar:eye-bold" class="text-base"></iconify-icon>
                                        <span>Lihat Lampiran POD</span>
                                    </button>
                                    <a href="/waybills/${wb.id}/print" target="_blank" class="w-full py-2 px-3 rounded-xl text-xs font-bold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-950/50 border border-blue-200 dark:border-blue-800 hover:bg-blue-100 transition-all flex items-center justify-center gap-1.5">
                                        <iconify-icon icon="solar:printer-bold" class="text-base"></iconify-icon>
                                        <span>Cetak Surat Jalan / POD</span>
                                    </a>
                                </div>
                            </div>
                        `;
                    }
                }

                // Cargo Manifest Items
                let rawItems = [];
                if (Array.isArray(wb.manifest_items) && wb.manifest_items.length) {
                    rawItems = wb.manifest_items;
                } else if (Array.isArray(wb.items_payload) && wb.items_payload.length) {
                    rawItems = wb.items_payload;
                } else if (Array.isArray(wb.request_order?.cargo_items) && wb.request_order.cargo_items.length) {
                    rawItems = wb.request_order.cargo_items;
                } else if (Array.isArray(wb.request_order?.items) && wb.request_order.items.length) {
                    rawItems = wb.request_order.items;
                }

                const roItemsList = wb.request_order?.cargo_items || wb.request_order?.items || [];
                const roProductMap = {};
                if (Array.isArray(roItemsList)) {
                    roItemsList.forEach(r => {
                        const pid = r.product_id || r.id;
                        if (pid) roProductMap[pid] = r;
                    });
                }

                const tbody = document.getElementById('wbManifestTbody');
                const initialTotalWeight = Number(wb.total_weight || wb.request_order?.total_weight_kg || wb.request_order?.total_weight || 0);

                if (!rawItems.length) {
                    const fallbackWeight = initialTotalWeight > 0 ? initialTotalWeight : 50;
                    tbody.innerHTML = `
                        <tr>
                            <td class="py-3 px-4 font-bold text-slate-800">1</td>
                            <td class="py-3 px-4 font-mono text-slate-500">-</td>
                            <td class="py-3 px-4 font-medium text-slate-800 dark:text-slate-200">Kargo Muatan FTL (General Cargo Langsung dari Gudang)</td>
                            <td class="py-3 px-4 text-center font-bold text-slate-800">${wb.total_koli || 1}</td>
                            <td class="py-3 px-4 text-end font-medium text-slate-800">${fallbackWeight.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} Kg</td>
                            <td class="py-3 px-4 text-slate-400">Kondisi Baik &amp; Tersegel</td>
                        </tr>
                    `;
                    document.getElementById('wbTotalKoli').innerText = wb.total_koli || 1;
                    document.getElementById('wbTotalWeight').innerText = fallbackWeight.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                } else {
                    let koliSum = 0;
                    let weightSum = 0;
                    let itemsWithoutWeightCount = 0;

                    const parsedItems = rawItems.map((it, idx) => {
                        const qty = Number(it.quantity || it.qty || 1);
                        koliSum += qty;

                        const pid = it.product_id || it.id;
                        const roRef = pid && roProductMap[pid] ? roProductMap[pid] : null;

                        let rowWeight = null;
                        if (it.subtotal_weight != null && it.subtotal_weight !== '' && !isNaN(it.subtotal_weight) && Number(it.subtotal_weight) > 0) {
                            rowWeight = Number(it.subtotal_weight);
                        } else if (it.weight_per_unit != null && it.weight_per_unit !== '' && !isNaN(it.weight_per_unit) && Number(it.weight_per_unit) > 0) {
                            rowWeight = Number(it.weight_per_unit) * qty;
                        } else if (it.weight_kg != null && it.weight_kg !== '' && !isNaN(it.weight_kg) && Number(it.weight_kg) > 0) {
                            rowWeight = Number(it.weight_kg);
                        } else if (it.weight != null && it.weight !== '' && !isNaN(it.weight) && Number(it.weight) > 0) {
                            rowWeight = Number(it.weight);
                        } else if (it.product?.weight_kg != null && !isNaN(it.product.weight_kg) && Number(it.product.weight_kg) > 0) {
                            rowWeight = Number(it.product.weight_kg) * qty;
                        } else if (roRef?.subtotal_weight != null && Number(roRef.subtotal_weight) > 0) {
                            rowWeight = Number(roRef.subtotal_weight);
                        } else if (roRef?.weight_per_unit != null && Number(roRef.weight_per_unit) > 0) {
                            rowWeight = Number(roRef.weight_per_unit) * qty;
                        } else if (roRef?.product?.weight_kg != null && Number(roRef.product.weight_kg) > 0) {
                            rowWeight = Number(roRef.product.weight_kg) * qty;
                        } else if (it.tonase != null && !isNaN(it.tonase) && Number(it.tonase) > 0) {
                            rowWeight = Number(it.tonase);
                        }

                        if (rowWeight != null && rowWeight > 0) {
                            weightSum += rowWeight;
                        } else {
                            itemsWithoutWeightCount++;
                        }

                        const sku = it.product_sku || it.sku || it.product?.sku || roRef?.product_sku || roRef?.sku || '-';
                        const desc = it.product_name || it.name || it.product?.name || roRef?.product_name || roRef?.product?.name || it.notes || ('Produk #' + (pid || (idx + 1)));
                        const notes = it.notes || 'Kondisi Baik &amp; Tersegel';

                        return { it, idx, qty, sku, desc, notes, rowWeight };
                    });

                    let finalTotalWeight = initialTotalWeight > 0 ? initialTotalWeight : weightSum;
                    if (itemsWithoutWeightCount > 0 && finalTotalWeight > weightSum && koliSum > 0) {
                        const remainingWeight = finalTotalWeight - weightSum;
                        let unallocatedKoliSum = 0;
                        parsedItems.forEach(item => {
                            if (item.rowWeight == null || item.rowWeight <= 0) unallocatedKoliSum += item.qty;
                        });

                        parsedItems.forEach(item => {
                            if (item.rowWeight == null || item.rowWeight <= 0) {
                                if (unallocatedKoliSum > 0) {
                                    item.rowWeight = (item.qty / unallocatedKoliSum) * remainingWeight;
                                }
                            }
                        });
                        weightSum = finalTotalWeight;
                    } else if (finalTotalWeight <= 0 && weightSum > 0) {
                        finalTotalWeight = weightSum;
                    }

                    tbody.innerHTML = parsedItems.map(item => {
                        let weightText = '-';
                        if (item.rowWeight != null && !isNaN(item.rowWeight) && item.rowWeight > 0) {
                            weightText = `${Number(item.rowWeight).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} Kg`;
                        } else if (finalTotalWeight > 0 && koliSum > 0) {
                            const distributed = (item.qty / koliSum) * finalTotalWeight;
                            weightText = `${Number(distributed).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} Kg`;
                        } else {
                            weightText = '0.00 Kg';
                        }

                        return `
                            <tr>
                                <td class="py-3 px-4 font-bold text-slate-800">${item.idx + 1}</td>
                                <td class="py-3 px-4 font-mono text-slate-500">${item.sku}</td>
                                <td class="py-3 px-4 font-medium text-slate-800 dark:text-slate-200">${item.desc}</td>
                                <td class="py-3 px-4 text-center font-bold text-slate-800">${item.qty}</td>
                                <td class="py-3 px-4 text-end font-medium text-slate-800">${weightText}</td>
                                <td class="py-3 px-4 text-slate-400">${item.notes}</td>
                            </tr>
                        `;
                    }).join('');

                    const displayKoli = wb.total_koli || koliSum;
                    const displayWeight = finalTotalWeight > 0 ? finalTotalWeight : weightSum;

                    document.getElementById('wbTotalKoli').innerText = displayKoli;
                    document.getElementById('wbTotalWeight').innerText = Number(displayWeight).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            } catch (err) {
                console.error('Fetch waybill detail error:', err);
            }
        }

        document.addEventListener('DOMContentLoaded', loadDetail);
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
<?php /**PATH D:\DevMuncen\CorporateFE\resources\views/waybills/show.blade.php ENDPATH**/ ?>