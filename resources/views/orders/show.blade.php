<x-layout.app title="Detail Pesanan Pelanggan (PO) | Corporate Portal">
    <div class="space-y-6 max-w-6xl mx-auto">
        <!-- Back & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="/orders" class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors inline-flex items-center gap-1 mb-1">
                    <iconify-icon icon="solar:arrow-left-linear"></iconify-icon> Kembali ke Daftar Pesanan
                </a>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 id="orderTitle" class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white font-mono">
                        Memuat Pesanan...
                    </h1>
                    <div id="orderStatusBadge"></div>
                </div>
                <p id="orderSubtitle" class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">-</p>
            </div>
            <div id="orderActionButtons" class="flex flex-wrap items-center gap-2"></div>
        </div>

        <!-- Lifecycle Progress Stepper -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div id="orderStepper" class="grid grid-cols-5 gap-2 text-center text-[11px] font-bold"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: Info & Line Items -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2 text-xs">
                        <div class="font-black text-slate-900 dark:text-white flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-700">
                            <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="text-blue-600 text-base"></iconify-icon>
                            <span>Informasi Pembeli &amp; Tujuan</span>
                        </div>
                        <div><span class="text-slate-400">Nama Pembeli:</span> <span id="infoCustomerName" class="font-bold text-slate-800 dark:text-slate-100">-</span></div>
                        <div><span class="text-slate-400">PIC / Telepon:</span> <span id="infoRecipientContact" class="font-semibold text-slate-700 dark:text-slate-300">-</span></div>
                        <div><span class="text-slate-400">Kota Tujuan:</span> <span id="infoDestCity" class="font-bold text-blue-600 dark:text-blue-400">-</span></div>
                        <div><span class="text-slate-400">Alamat Kirim:</span> <span id="infoDeliveryAddress" class="text-slate-600 dark:text-slate-300">-</span></div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2 text-xs">
                        <div class="font-black text-slate-900 dark:text-white flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-700">
                            <iconify-icon icon="solar:buildings-bold-duotone" class="text-amber-600 text-base"></iconify-icon>
                            <span>Gudang Asal &amp; Sinkronisasi Stok</span>
                        </div>
                        <div><span class="text-slate-400">Gudang Asal:</span> <span id="infoOriginWh" class="font-bold text-slate-800 dark:text-slate-100">-</span></div>
                        <div><span class="text-slate-400">Tanggal PO / Target Kirim:</span> <span id="infoDates" class="font-semibold text-slate-700 dark:text-slate-300">-</span></div>
                        <div><span class="text-slate-400">Status Stok:</span> <span id="infoStockReserve" class="font-bold">-</span></div>
                        <div><span class="text-slate-400">Catatan:</span> <span id="infoNotes" class="text-slate-600 dark:text-slate-300 italic">-</span></div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                        <h3 class="text-sm font-black text-slate-900 dark:text-white">Rincian Barang Pesanan</h3>
                        <span id="itemsSummaryBadge" class="text-xs font-bold text-slate-500">0 item</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 uppercase font-bold border-b border-slate-200 dark:border-slate-700">
                                    <th class="py-3 pl-5">No</th>
                                    <th class="py-3">SKU &amp; Nama Barang</th>
                                    <th class="py-3 text-right">Qty</th>
                                    <th class="py-3 text-right">Berat / Vol</th>
                                    <th class="py-3 text-right">Harga Satuan</th>
                                    <th class="py-3 pr-5 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="orderItemsDetailBody" class="divide-y divide-slate-100 dark:divide-slate-700/50"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Col: Financials & Request Order Linkage -->
            <div class="space-y-6">
                <!-- Financial Breakdown -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-3 text-xs">
                    <h3 class="text-sm font-black text-slate-900 dark:text-white pb-2 border-b border-slate-100 dark:border-slate-700">Ringkasan Nilai Pesanan</h3>
                    <div class="flex justify-between"><span class="text-slate-500">Subtotal Barang</span><span id="finSubtotal" class="font-bold">-</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Diskon Pesanan</span><span id="finDiscount" class="font-bold text-rose-500">-</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">PPN / Pajak</span><span id="finTax" class="font-bold">-</span></div>
                    <div class="flex justify-between pt-3 border-t border-slate-200 dark:border-slate-700 text-sm font-black text-slate-900 dark:text-white">
                        <span>Total Tagihan</span>
                        <span id="finTotal" class="text-blue-600 dark:text-blue-400">-</span>
                    </div>
                </div>

                <!-- Logistics RO Link Panel -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-3 text-xs">
                    <h3 class="text-sm font-black text-slate-900 dark:text-white pb-2 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
                        <iconify-icon icon="solar:truck-bold-duotone" class="text-indigo-600 text-base"></iconify-icon>
                        <span>Integrasi Pengiriman (RO)</span>
                    </h3>
                    <div id="roLinkContent" class="text-slate-500">Memuat informasi pengiriman...</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const orderId = @json($id);

        async function loadOrderDetail() {
            try {
                const res = await axios.get(`/api/internal/orders/${orderId}`);
                const o = res.data?.data;
                if (!o) return;

                document.getElementById('orderTitle').textContent = o.order_number;
                document.getElementById('orderSubtitle').textContent =
                    (o.customer_po_number ? `PO Pembeli: ${o.customer_po_number} • ` : '') +
                    `Dibuat pada ${o.order_date || '-'}`;

                const statusMap = {
                    draft: ['Draft', 'bg-amber-100 text-amber-800'],
                    confirmed: ['Terkonfirmasi (Siap RO)', 'bg-blue-100 text-blue-800'],
                    allocated_ro: ['Dialokasikan ke RO', 'bg-indigo-100 text-indigo-800'],
                    in_transit: ['Dalam Pengiriman', 'bg-purple-100 text-purple-800'],
                    delivered: ['Selesai Terkirim', 'bg-emerald-100 text-emerald-800'],
                    cancelled: ['Dibatalkan', 'bg-rose-100 text-rose-800'],
                };
                const st = statusMap[o.status] || [o.status, 'bg-slate-100 text-slate-700'];
                document.getElementById('orderStatusBadge').innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-bold ${st[1]}">${st[0]}</span>`;

                renderStepper(o.status);
                renderActionButtons(o);

                const custTypeLabel = o.customer_type === 'distributor' ? '[Mitra Distribusi]' : '[Pelanggan]';
                document.getElementById('infoCustomerName').textContent = `${o.customer?.name || o.recipient_name} ${custTypeLabel}`;
                document.getElementById('infoRecipientContact').textContent = `${o.recipient_name} (${o.recipient_phone})`;
                document.getElementById('infoDestCity').textContent = o.destination_city_name || o.destination_city_code || '-';
                document.getElementById('infoDeliveryAddress').textContent = o.delivery_address || '-';

                document.getElementById('infoOriginWh').textContent = `${o.origin_warehouse?.name || '-'} (${o.origin_warehouse?.code || ''})`;
                document.getElementById('infoDates').textContent = `${o.order_date || '-'} / Target: ${o.expected_delivery_date || '-'}`;
                document.getElementById('infoStockReserve').innerHTML = o.is_stock_reserved
                    ? '<span class="text-emerald-600">Stok Dialokasikan (Soft Reserved)</span>'
                    : (o.status === 'allocated_ro' || o.status === 'in_transit' || o.status === 'delivered'
                        ? '<span class="text-indigo-600">Stok Terpotong via Request Order (Item Out)</span>'
                        : '<span class="text-slate-500">Belum Dialokasikan</span>');
                document.getElementById('infoNotes').textContent = o.notes || 'Tidak ada catatan';

                const items = o.items || [];
                document.getElementById('itemsSummaryBadge').textContent = `${items.length} produk (${Number(o.total_quantity || 0).toLocaleString('id-ID')} unit)`;
                document.getElementById('orderItemsDetailBody').innerHTML = items.map((item, idx) => `
                    <tr>
                        <td class="py-3 pl-5 font-bold text-slate-500">${idx + 1}</td>
                        <td class="py-3">
                            <div class="font-bold text-slate-800 dark:text-slate-100">${item.product?.name || 'Produk #' + item.product_id}</div>
                            <div class="text-[10px] font-mono text-slate-400">${item.product?.code || '-'}</div>
                        </td>
                        <td class="py-3 text-right font-bold text-slate-800 dark:text-slate-200">${Number(item.quantity).toLocaleString('id-ID')}</td>
                        <td class="py-3 text-right text-slate-500">${Number(item.total_weight_kg || 0).toFixed(1)} kg / ${Number(item.total_volume_cbm || 0).toFixed(3)} m³</td>
                        <td class="py-3 text-right font-mono">Rp ${Number(item.unit_price || 0).toLocaleString('id-ID')}</td>
                        <td class="py-3 pr-5 text-right font-bold text-slate-900 dark:text-white">Rp ${Number(item.total_price || 0).toLocaleString('id-ID')}</td>
                    </tr>
                `).join('');

                document.getElementById('finSubtotal').textContent = 'Rp ' + Number(o.subtotal || 0).toLocaleString('id-ID');
                document.getElementById('finDiscount').textContent = '- Rp ' + Number(o.discount_amount || 0).toLocaleString('id-ID');
                document.getElementById('finTax').textContent = `Rp ${Number(o.tax_amount || 0).toLocaleString('id-ID')} (${Number(o.tax_percent || 0)}%)`;
                document.getElementById('finTotal').textContent = 'Rp ' + Number(o.total_amount || 0).toLocaleString('id-ID');

                renderRoPanel(o);
            } catch (err) {
                console.error('Load order detail error:', err);
                window.Alert.error('Error', 'Gagal memuat detail pesanan.');
            }
        }

        function renderStepper(status) {
            const steps = [
                { key: 'draft', label: '1. Draft PO' },
                { key: 'confirmed', label: '2. Terkonfirmasi' },
                { key: 'allocated_ro', label: '3. Impor ke RO' },
                { key: 'in_transit', label: '4. Pengiriman' },
                { key: 'delivered', label: '5. Selesai (POD)' },
            ];
            const orderIdx = steps.findIndex(s => s.key === status);
            document.getElementById('orderStepper').innerHTML = steps.map((s, i) => {
                if (status === 'cancelled') {
                    return `<div class="p-2 rounded-xl bg-rose-50 text-rose-500 border border-rose-200">${s.label}</div>`;
                }
                const done = i <= orderIdx;
                const cls = done
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'bg-slate-100 dark:bg-slate-700 text-slate-400';
                return `<div class="p-2 rounded-xl ${cls}">${s.label}</div>`;
            }).join('');
        }

        function renderActionButtons(o) {
            const container = document.getElementById('orderActionButtons');
            let html = '';
            if (o.status === 'draft') {
                html = `
                    <a href="/orders/create?edit_id=${o.id}" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-white text-xs font-bold shadow-sm">Edit Draft</a>
                    <button type="button" onclick="confirmOrderAction()" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-md">Konfirmasi &amp; Alokasikan Stok</button>
                    <button type="button" onclick="deleteOrderAction()" class="px-4 py-2 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-bold">Hapus Draft</button>
                `;
            } else if (o.status === 'confirmed') {
                html = `
                    <a href="/request-orders/create?from_order_id=${o.id}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-md shadow-emerald-600/25 flex items-center gap-1.5">
                        <iconify-icon icon="solar:truck-bold" class="text-base"></iconify-icon>
                        <span>Buat Pengiriman / Impor ke Request Order (RO)</span>
                    </a>
                    <button type="button" onclick="cancelOrderAction()" class="px-4 py-2 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-bold">Batalkan Pesanan</button>
                `;
            } else if (o.request_order_id) {
                html = `
                    <a href="/request-orders/${o.request_order_id}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold shadow-sm flex items-center gap-1.5">
                        <iconify-icon icon="solar:routing-bold"></iconify-icon>
                        <span>Pantau Request Order (${o.request_order?.order_number || '#' + o.request_order_id})</span>
                    </a>
                `;
            }
            container.innerHTML = html;
        }

        function renderRoPanel(o) {
            const container = document.getElementById('roLinkContent');
            if (o.request_order_id && o.request_order) {
                const ro = o.request_order;
                const waybills = ro.waybills || [];
                container.innerHTML = `
                    <div class="space-y-2">
                        <div class="p-3 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-800">
                            <div class="text-[10px] font-bold uppercase text-indigo-500">Request Order Terkait</div>
                            <a href="/request-orders/${ro.id}" class="text-sm font-black font-mono text-indigo-700 dark:text-indigo-300 hover:underline">${ro.order_number}</a>
                            <div class="text-[11px] text-slate-600 dark:text-slate-300 mt-1">Status RO: <span class="font-bold uppercase">${ro.status}</span></div>
                            <div class="text-[11px] text-slate-600 dark:text-slate-300">Ekspedisi: <span class="font-bold">${ro.logistic?.name || '-'}</span></div>
                        </div>
                        ${waybills.length ? `
                            <div class="space-y-1.5 pt-2">
                                <div class="text-[10px] font-bold uppercase text-slate-400">Surat Jalan (Waybill)</div>
                                ${waybills.map(w => `
                                    <a href="/waybills/${w.id}" class="flex items-center justify-between p-2 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-blue-400">
                                        <span class="font-mono font-bold text-blue-600">${w.waybill_number}</span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-700">${w.status}</span>
                                    </a>
                                `).join('')}
                            </div>
                        ` : ''}
                    </div>
                `;
            } else if (o.status === 'confirmed') {
                container.innerHTML = `
                    <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 space-y-2">
                        <p class="text-emerald-800 dark:text-emerald-300 font-semibold">Pesanan telah terkonfirmasi dan siap diimpor ke modul Request Order untuk penjadwalan ekspedisi.</p>
                        <a href="/request-orders/create?from_order_id=${o.id}" class="w-full py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold flex items-center justify-center gap-1.5">
                            <iconify-icon icon="solar:truck-bold"></iconify-icon> Impor ke RO Sekarang
                        </a>
                    </div>
                `;
            } else {
                container.innerHTML = '<p class="text-slate-400 italic">Konfirmasi pesanan terlebih dahulu sebelum membuat Request Order pengiriman.</p>';
            }
        }

        async function confirmOrderAction() {
            const res = await window.Alert.confirm('Konfirmasi Pesanan?', 'Stok barang di gudang asal akan divalidasi dan dialokasikan.');
            if (!res.isConfirmed) return;
            try {
                await axios.post(`/api/internal/orders/${orderId}/confirm`);
                window.Alert.toast('Pesanan terkonfirmasi!');
                loadOrderDetail();
            } catch (err) {
                const msg = err.response?.data?.errors?.items?.[0] || err.response?.data?.message || 'Gagal mengonfirmasi pesanan.';
                window.Alert.error('Gagal', msg);
            }
        }

        async function cancelOrderAction() {
            const res = await window.Alert.confirm('Batalkan Pesanan?', 'Alokasi stok yang sudah dicadangkan akan dikembalikan.');
            if (!res.isConfirmed) return;
            try {
                await axios.post(`/api/internal/orders/${orderId}/cancel`);
                window.Alert.toast('Pesanan dibatalkan.');
                loadOrderDetail();
            } catch (err) {
                window.Alert.error('Gagal', err.response?.data?.message || 'Gagal membatalkan pesanan.');
            }
        }

        async function deleteOrderAction() {
            const res = await window.Alert.confirm('Hapus Draft?', 'Draft pesanan ini akan dihapus permanen.');
            if (!res.isConfirmed) return;
            try {
                await axios.delete(`/api/internal/orders/${orderId}`);
                window.Alert.toast('Draft berhasil dihapus.');
                window.location.href = '/orders';
            } catch (err) {
                window.Alert.error('Gagal', err.response?.data?.message || 'Gagal menghapus draft.');
            }
        }

        document.addEventListener('DOMContentLoaded', loadOrderDetail);
    </script>
    @endpush
</x-layout.app>
