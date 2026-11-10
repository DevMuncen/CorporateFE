<x-layout.app title="{{ $editId ? 'Edit Pesanan Pelanggan' : 'Buat Pesanan Pelanggan Baru (PO)' }} | Corporate Portal">
    <div class="space-y-6 max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="/orders" class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors inline-flex items-center gap-1 mb-1">
                    <iconify-icon icon="solar:arrow-left-linear"></iconify-icon> Kembali ke Daftar Pesanan
                </a>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    {{ $editId ? 'Edit Draft Pesanan Pelanggan' : 'Buat Pesanan Pelanggan / Mitra Distribusi (PO)' }}
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    Catat Purchase Order dari Pelanggan atau Mitra Distribusi, cek stok real-time gudang asal, lalu konfirmasi untuk siap diimpor ke Request Order.
                </p>
            </div>
        </div>

        <form id="customerOrderForm" onsubmit="event.preventDefault(); submitOrder('draft');" class="space-y-6">
            <input type="hidden" id="editOrderId" value="{{ $editId ?? '' }}">

            <!-- Step 1: Buyer & Reference Info -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-5">
                <div class="flex items-center gap-2.5 border-b border-slate-100 dark:border-slate-700 pb-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-950/60 flex items-center justify-center text-blue-600">
                        <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="text-lg"></iconify-icon>
                    </div>
                    <div>
                        <h2 class="text-sm font-black text-slate-900 dark:text-white">1. Informasi Pembeli &amp; Referensi PO</h2>
                        <p class="text-[11px] text-slate-400">Pilih Pelanggan atau Mitra Distribusi yang memesan barang</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <x-modal-picker
                            id="orderCustomerPicker"
                            name="customer_id"
                            label="Pelanggan / Mitra Distribusi *"
                            url="/api/customers"
                            placeholder="Klik untuk memilih Pelanggan atau Mitra Distribusi..."
                            required="true"
                        />
                        <div id="buyerTypeBadge" class="hidden mt-1.5 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold"></div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-1.5">Nomor PO Pembeli (Eksternal)</label>
                        <input type="text" id="customerPoNumber" placeholder="Contoh: PO/CMP/2026/110" class="w-full px-3 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-1.5">Tanggal Pesanan *</label>
                        <input type="date" id="orderDate" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-1.5">Target Tanggal Kirim</label>
                        <input type="date" id="expectedDeliveryDate" class="w-full px-3 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-1.5">Gudang Pemenuhan Asal *</label>
                        <select id="originWarehouseId" required onchange="refreshStockIndicators()" class="w-full px-3 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold">
                            <option value="">-- Memuat Gudang Asal --</option>
                        </select>
                    </div>
                </div>

                <!-- Destination Delivery Details (Auto-filled from Customer) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-1.5">Nama PIC / Penerima *</label>
                        <input type="text" id="recipientName" required placeholder="Nama penerima di lokasi" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-1.5">Telepon Penerima *</label>
                        <input type="text" id="recipientPhone" required placeholder="0812xxxxxxxx" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs">
                    </div>
                    <div>
                        <x-modal-picker
                            id="orderDestCityPicker"
                            name="destination_city_code"
                            label="Kota / Kabupaten Tujuan *"
                            url="/api/wilayah/kota"
                            placeholder="Pilih Kota Tujuan..."
                            required="true"
                        />
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-1.5">Alamat Lengkap Pengiriman *</label>
                        <textarea id="deliveryAddress" required rows="2" placeholder="Jalan, gedung, nomor, kecamatan..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs"></textarea>
                    </div>
                </div>
            </div>

            <!-- Step 2: Order Items & Real-Time Stock Sync -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-950/60 flex items-center justify-center text-amber-600">
                            <iconify-icon icon="solar:box-bold-duotone" class="text-lg"></iconify-icon>
                        </div>
                        <div>
                            <h2 class="text-sm font-black text-slate-900 dark:text-white">2. Daftar Barang (SKU) &amp; Ketersediaan Stok</h2>
                            <p class="text-[11px] text-slate-400">Stok tersedia di gudang asal ditampilkan secara otomatis</p>
                        </div>
                    </div>
                    <button type="button" onclick="addItemRow()" class="px-3.5 py-2 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-300 hover:bg-blue-100 text-xs font-bold transition-all flex items-center gap-1.5">
                        <iconify-icon icon="solar:add-circle-bold"></iconify-icon> Tambah Barang
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 uppercase font-bold border-b border-slate-200 dark:border-slate-700">
                                <th class="py-2.5 pl-3 min-w-[240px]">Produk (SKU)</th>
                                <th class="py-2.5 text-center">Stok Tersedia</th>
                                <th class="py-2.5 w-24">Qty Pesan</th>
                                <th class="py-2.5 w-36">Harga Satuan (Rp)</th>
                                <th class="py-2.5 w-28">Diskon (Rp)</th>
                                <th class="py-2.5 text-right">Subtotal (Rp)</th>
                                <th class="py-2.5 pr-3 text-center w-12">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="orderItemsBody" class="divide-y divide-slate-100 dark:divide-slate-700/50"></tbody>
                    </table>
                </div>

                <!-- Summary & Notes -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-1.5">Catatan Pesanan</label>
                        <textarea id="orderNotes" rows="3" placeholder="Instruksi pengiriman khusus, jadwal bongkar muat, dll..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs"></textarea>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-900/60 rounded-2xl p-4 space-y-2.5 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Total Kuantitas &amp; Tonase</span>
                            <span id="summaryPhysical" class="font-bold text-slate-800 dark:text-slate-200">0 unit &bull; 0 kg &bull; 0 m³</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Subtotal Barang</span>
                            <span id="summarySubtotal" class="font-bold text-slate-800 dark:text-slate-200">Rp 0</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-slate-500">Diskon Pesanan (Rp)</span>
                            <input type="number" id="orderDiscount" value="0" min="0" oninput="recalcTotals()" class="w-36 px-2.5 py-1 text-right bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg font-mono">
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-slate-500">PPN / Pajak (%)</span>
                            <div class="flex items-center gap-2">
                                <input type="number" id="orderTaxPercent" value="0" min="0" max="100" step="0.1" oninput="recalcTotals()" class="w-20 px-2.5 py-1 text-right bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg font-mono">
                                <span id="summaryTaxAmount" class="font-mono text-slate-600 dark:text-slate-400">Rp 0</span>
                            </div>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-slate-200 dark:border-slate-700 text-sm font-black text-slate-900 dark:text-white">
                            <span>TOTAL TAGIHAN PESANAN</span>
                            <span id="summaryGrandTotal" class="text-blue-600 dark:text-blue-400">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="/orders" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 text-center">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white text-xs font-bold shadow-sm transition-all flex items-center justify-center gap-2">
                    <iconify-icon icon="solar:diskette-bold"></iconify-icon>
                    <span>Simpan sebagai Draft</span>
                </button>
                <button type="button" onclick="submitOrder('confirm')" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-md shadow-blue-600/25 transition-all flex items-center justify-center gap-2">
                    <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                    <span>Simpan &amp; Konfirmasi Pesanan (Alokasikan Stok)</span>
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        let deps = { customers: [], warehouses: [], products: [], stock_map: {} };
        let itemRows = [];
        let rowCounter = 0;

        async function initOrderForm() {
            try {
                const res = await axios.get('/api/internal/orders/form-dependencies');
                deps = res.data?.data || { customers: [], warehouses: [], products: [], stock_map: {} };

                const whSelect = document.getElementById('originWarehouseId');
                whSelect.innerHTML = '<option value="">-- Pilih Gudang Asal --</option>' +
                    deps.warehouses.map(w => `<option value="${w.id}">${w.name} (${w.code})</option>`).join('');

                if (deps.warehouses.length === 1) {
                    whSelect.value = deps.warehouses[0].id;
                }

                // Listen to customer selection
                const custHidden = document.getElementById('hidden-orderCustomerPicker');
                if (custHidden) {
                    custHidden.addEventListener('change', (e) => {
                        const custId = e.target.value;
                        const cust = deps.customers.find(c => String(c.id) === String(custId));
                        const badge = document.getElementById('buyerTypeBadge');
                        if (cust) {
                            document.getElementById('recipientName').value = cust.pic_name || cust.name || '';
                            document.getElementById('recipientPhone').value = cust.pic_phone || cust.phone || '';
                            document.getElementById('deliveryAddress').value = cust.address || '';

                            if (cust.city_code && window.setPickerValue) {
                                window.setPickerValue('orderDestCityPicker', cust.city_code, cust.city_name || cust.city_code);
                            }

                            if (badge) {
                                badge.classList.remove('hidden');
                                if (cust.type === 'distributor') {
                                    badge.className = 'mt-1.5 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300';
                                    badge.innerHTML = '<iconify-icon icon="solar:shop-2-bold"></iconify-icon> Mitra Distribusi (Terhubung ke Stok Distributor)';
                                } else {
                                    badge.className = 'mt-1.5 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300';
                                    badge.innerHTML = '<iconify-icon icon="solar:users-group-two-rounded-bold"></iconify-icon> Pelanggan';
                                }
                            }
                        } else if (badge) {
                            badge.classList.add('hidden');
                        }
                    });
                }

                const editId = document.getElementById('editOrderId')?.value;
                if (editId) {
                    await loadEditOrder(editId);
                } else {
                    addItemRow();
                }
            } catch (err) {
                console.error('Init order form error:', err);
                window.Alert.error('Error', 'Gagal memuat dependensi form pesanan.');
            }
        }

        async function loadEditOrder(id) {
            try {
                const res = await axios.get(`/api/internal/orders/${id}`);
                const order = res.data?.data;
                if (!order) return;

                if (window.setPickerValue && order.customer) {
                    window.setPickerValue('orderCustomerPicker', order.customer_id, `${order.customer.code} - ${order.customer.name}`, order.customer);
                }
                document.getElementById('customerPoNumber').value = order.customer_po_number || '';
                document.getElementById('orderDate').value = (order.order_date || '').substring(0, 10);
                document.getElementById('expectedDeliveryDate').value = (order.expected_delivery_date || '').substring(0, 10);
                document.getElementById('originWarehouseId').value = order.origin_warehouse_id || '';
                document.getElementById('recipientName').value = order.recipient_name || '';
                document.getElementById('recipientPhone').value = order.recipient_phone || '';
                document.getElementById('deliveryAddress').value = order.delivery_address || '';
                if (window.setPickerValue && order.destination_city_code) {
                    window.setPickerValue('orderDestCityPicker', order.destination_city_code, order.destination_city_name || order.destination_city_code);
                }
                document.getElementById('orderNotes').value = order.notes || '';
                document.getElementById('orderDiscount').value = Number(order.discount_amount || 0);
                document.getElementById('orderTaxPercent').value = Number(order.tax_percent || 0);

                itemRows = [];
                (order.items || []).forEach(item => {
                    addItemRow({
                        product_id: item.product_id,
                        quantity: Number(item.quantity),
                        unit_price: Number(item.unit_price),
                        discount_amount: Number(item.discount_amount || 0),
                    });
                });
                recalcTotals();
            } catch (err) {
                window.Alert.error('Error', 'Gagal memuat detail draft pesanan.');
            }
        }

        function addItemRow(preset = {}) {
            rowCounter++;
            const rowId = rowCounter;
            itemRows.push({
                rowId,
                product_id: preset.product_id || '',
                quantity: preset.quantity || 1,
                unit_price: preset.unit_price || 0,
                discount_amount: preset.discount_amount || 0,
            });
            renderItemsTable();
        }

        function removeItemRow(rowId) {
            if (itemRows.length <= 1) {
                window.Alert.toast('Minimal harus ada 1 barang dalam pesanan.', 'warning');
                return;
            }
            itemRows = itemRows.filter(r => r.rowId !== rowId);
            renderItemsTable();
        }

        function onProductChange(rowId, prodId) {
            const row = itemRows.find(r => r.rowId === rowId);
            if (!row) return;
            row.product_id = prodId;
            const prod = deps.products.find(p => String(p.id) === String(prodId));
            if (prod) {
                row.unit_price = Number(prod.default_price || 0);
            }
            renderItemsTable();
        }

        function onItemFieldChange(rowId, field, value) {
            const row = itemRows.find(r => r.rowId === rowId);
            if (!row) return;
            row[field] = Number(value) || 0;
            recalcTotals();
            updateRowSubtotal(rowId);
        }

        function getStockForProduct(prodId) {
            const whId = document.getElementById('originWarehouseId')?.value;
            if (!whId || !prodId) return null;
            return deps.stock_map?.[whId]?.[prodId] || { physical: 0, reserved: 0, available: 0 };
        }

        function refreshStockIndicators() {
            renderItemsTable();
        }

        function updateRowSubtotal(rowId) {
            const row = itemRows.find(r => r.rowId === rowId);
            if (!row) return;
            const sub = Math.max(0, (row.quantity * row.unit_price) - row.discount_amount);
            const el = document.getElementById(`row-sub-${rowId}`);
            if (el) el.textContent = 'Rp ' + sub.toLocaleString('id-ID');

            // Update stock badge
            const stock = getStockForProduct(row.product_id);
            const stEl = document.getElementById(`row-stock-${rowId}`);
            if (stEl && stock !== null) {
                const isShort = row.quantity > stock.available;
                stEl.className = isShort
                    ? 'px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700'
                    : 'px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700';
                stEl.textContent = `${stock.available} tersedia` + (isShort ? ' (Kurang!)' : '');
            }
        }

        function renderItemsTable() {
            const tbody = document.getElementById('orderItemsBody');
            tbody.innerHTML = itemRows.map(row => {
                const options = deps.products.map(p =>
                    `<option value="${p.id}" ${String(row.product_id) === String(p.id) ? 'selected' : ''}>${p.code} - ${p.name}</option>`
                ).join('');

                const stock = getStockForProduct(row.product_id);
                let stockBadge = '<span class="text-slate-400 text-[10px]">Pilih gudang &amp; produk</span>';
                if (stock !== null) {
                    const isShort = row.quantity > stock.available;
                    const cls = isShort ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700';
                    stockBadge = `<span id="row-stock-${row.rowId}" class="px-2 py-0.5 rounded-full text-[10px] font-bold ${cls}">${stock.available} tersedia${isShort ? ' (Kurang!)' : ''}</span>`;
                }

                const sub = Math.max(0, (row.quantity * row.unit_price) - row.discount_amount);

                return `
                    <tr>
                        <td class="py-2.5 pl-3">
                            <select onchange="onProductChange(${row.rowId}, this.value)" class="w-full px-2.5 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold">
                                <option value="">-- Pilih Produk SKU --</option>
                                ${options}
                            </select>
                        </td>
                        <td class="py-2.5 text-center">${stockBadge}</td>
                        <td class="py-2.5">
                            <input type="number" min="1" step="1" value="${row.quantity}" oninput="onItemFieldChange(${row.rowId}, 'quantity', this.value)" class="w-24 px-2.5 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono text-right">
                        </td>
                        <td class="py-2.5">
                            <input type="number" min="0" value="${row.unit_price}" oninput="onItemFieldChange(${row.rowId}, 'unit_price', this.value)" class="w-36 px-2.5 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono text-right">
                        </td>
                        <td class="py-2.5">
                            <input type="number" min="0" value="${row.discount_amount}" oninput="onItemFieldChange(${row.rowId}, 'discount_amount', this.value)" class="w-28 px-2.5 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono text-right">
                        </td>
                        <td id="row-sub-${row.rowId}" class="py-2.5 text-right font-bold text-slate-800 dark:text-slate-100">
                            Rp ${sub.toLocaleString('id-ID')}
                        </td>
                        <td class="py-2.5 pr-3 text-center">
                            <button type="button" onclick="removeItemRow(${row.rowId})" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50">
                                <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');

            recalcTotals();
        }

        function recalcTotals() {
            let totalQty = 0;
            let totalWeight = 0;
            let totalVol = 0;
            let subtotal = 0;

            itemRows.forEach(row => {
                const prod = deps.products.find(p => String(p.id) === String(row.product_id));
                const qty = Number(row.quantity) || 0;
                const price = Number(row.unit_price) || 0;
                const disc = Number(row.discount_amount) || 0;

                totalQty += qty;
                if (prod) {
                    totalWeight += qty * (Number(prod.weight_kg) || 0);
                    totalVol += qty * (Number(prod.volume_m3) || 0);
                }
                subtotal += Math.max(0, (qty * price) - disc);
            });

            const orderDisc = Number(document.getElementById('orderDiscount')?.value) || 0;
            const taxPct = Number(document.getElementById('orderTaxPercent')?.value) || 0;
            const taxable = Math.max(0, subtotal - orderDisc);
            const taxAmt = Math.round(taxable * (taxPct / 100));
            const grandTotal = taxable + taxAmt;

            document.getElementById('summaryPhysical').textContent = `${totalQty.toLocaleString('id-ID')} unit • ${totalWeight.toFixed(2)} kg • ${totalVol.toFixed(3)} m³`;
            document.getElementById('summarySubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('summaryTaxAmount').textContent = 'Rp ' + taxAmt.toLocaleString('id-ID');
            document.getElementById('summaryGrandTotal').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }

        async function submitOrder(submitAction) {
            const customerId = document.getElementById('hidden-orderCustomerPicker')?.value;
            const originWhId = document.getElementById('originWarehouseId')?.value;
            const destCityCode = document.getElementById('hidden-orderDestCityPicker')?.value;

            if (!customerId) {
                window.Alert.warning('Pilih Pembeli', 'Silakan pilih Pelanggan atau Mitra Distribusi terlebih dahulu.');
                return;
            }
            if (!originWhId) {
                window.Alert.warning('Pilih Gudang Asal', 'Silakan pilih Gudang Pemenuhan Asal terlebih dahulu.');
                return;
            }

            const validItems = itemRows.filter(r => r.product_id && r.quantity > 0).map(r => ({
                product_id: Number(r.product_id),
                quantity: Number(r.quantity),
                unit_price: Number(r.unit_price),
                discount_amount: Number(r.discount_amount) || 0,
            }));

            if (!validItems.length) {
                window.Alert.warning('Barang Kosong', 'Tambahkan minimal 1 produk SKU yang valid.');
                return;
            }

            const payload = {
                customer_id: Number(customerId),
                customer_po_number: document.getElementById('customerPoNumber')?.value || null,
                origin_warehouse_id: Number(originWhId),
                destination_city_code: destCityCode || null,
                recipient_name: document.getElementById('recipientName')?.value,
                recipient_phone: document.getElementById('recipientPhone')?.value,
                delivery_address: document.getElementById('deliveryAddress')?.value,
                order_date: document.getElementById('orderDate')?.value,
                expected_delivery_date: document.getElementById('expectedDeliveryDate')?.value || null,
                discount_amount: Number(document.getElementById('orderDiscount')?.value) || 0,
                tax_percent: Number(document.getElementById('orderTaxPercent')?.value) || 0,
                notes: document.getElementById('orderNotes')?.value || null,
                submit_action: submitAction,
                items: validItems,
            };

            const editId = document.getElementById('editOrderId')?.value;

            try {
                let res;
                if (editId) {
                    await axios.put(`/api/internal/orders/${editId}`, payload);
                    if (submitAction === 'confirm') {
                        await axios.post(`/api/internal/orders/${editId}/confirm`);
                    }
                    window.Alert.toast('Pesanan pelanggan berhasil diperbarui.');
                    window.location.href = `/orders/${editId}`;
                } else {
                    res = await axios.post('/api/internal/orders', payload);
                    const createdId = res.data?.data?.id;
                    window.Alert.toast(submitAction === 'confirm' ? 'Pesanan dikonfirmasi & stok dialokasikan!' : 'Draft pesanan tersimpan.');
                    window.location.href = createdId ? `/orders/${createdId}` : '/orders';
                }
            } catch (err) {
                const msg = err.response?.data?.errors?.items?.[0] || err.response?.data?.message || 'Gagal menyimpan pesanan.';
                window.Alert.error('Gagal Menyimpan Pesanan', msg);
            }
        }

        document.addEventListener('DOMContentLoaded', initOrderForm);
    </script>
    @endpush
</x-layout.app>
