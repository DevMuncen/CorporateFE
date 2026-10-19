// 5-Step Request Order Wizard Logic for CorporateFE

document.addEventListener('DOMContentLoaded', function() {
    const wizardForm = document.getElementById('ro-wizard-form');
    if (!wizardForm) return;

    let currentStep = 1;
    const totalSteps = 5;

    // State Object
    const roState = {
        order_date: new Date().toISOString().split('T')[0],
        origin_warehouse_id: '',
        origin_city_code: '',
        destination_city_code: '',
        origin_address: '',
        sender_name: 'Gudang Utama Korporasi',
        sender_phone: '081234567890',
        fleet_type_id: 1,
        logistic_id: '',
        notes: '',
        delivery_points: []
    };

    // Step Navigation Handlers
    window.goToStep = function(step) {
        if (step < 1 || step > totalSteps) return;

        // Validation before proceeding
        if (step > currentStep) {
            if (currentStep === 1 && (!roState.origin_warehouse_id || !roState.destination_city_code || !roState.logistic_id)) {
                window.showToast('Silakan pilih Gudang Asal, Kota Tujuan, dan Mitra Logistik terlebih dahulu.', 'error');
                return;
            }
            if (currentStep === 3 && roState.delivery_points.length === 0) {
                window.showToast('Minimal harus ada 1 titik drop pengiriman (Delivery Point).', 'error');
                return;
            }
        }

        // Hide all steps
        for (let i = 1; i <= totalSteps; i++) {
            const stepEl = document.getElementById(`step-card-${i}`);
            const tabEl = document.getElementById(`step-tab-${i}`);
            if (stepEl) stepEl.classList.add('hidden');
            if (tabEl) {
                tabEl.classList.remove('bg-corporate-800', 'text-white');
                tabEl.classList.add('bg-slate-100', 'text-slate-600');
            }
        }

        // Show active step
        const activeStepEl = document.getElementById(`step-card-${step}`);
        const activeTabEl = document.getElementById(`step-tab-${step}`);
        if (activeStepEl) activeStepEl.classList.remove('hidden');
        if (activeTabEl) {
            activeTabEl.classList.remove('bg-slate-100', 'text-slate-600');
            activeTabEl.classList.add('bg-corporate-800', 'text-white');
        }

        currentStep = step;

        if (currentStep === 5) {
            calculateAndRenderTariffSummary();
        }
    };

    // Route Inquiry Trigger
    window.inquireRoutes = async function() {
        const originWhSelect = document.getElementById('origin_warehouse_id');
        const destCitySelect = document.getElementById('destination_city_code');
        const carrierContainer = document.getElementById('carrier-selection-list');

        if (!originWhSelect.value || !destCitySelect.value) return;

        roState.origin_warehouse_id = originWhSelect.value;
        const selectedWhOption = originWhSelect.options[originWhSelect.selectedIndex];
        roState.origin_city_code = selectedWhOption.getAttribute('data-city-code') || '31.71';
        roState.origin_address = selectedWhOption.getAttribute('data-address') || '';
        roState.destination_city_code = destCitySelect.value;

        carrierContainer.innerHTML = '<div class="py-4 text-center text-slate-500 text-sm">Mencari kontrak tarif logistik aktif...</div>';

        try {
            const response = await axios.post('/api/internal/corporate/request-orders/inquire-routes', {
                origin_city_code: roState.origin_city_code,
                destination_city_code: roState.destination_city_code,
                fleet_type_id: roState.fleet_type_id
            });

            const carriers = response.data?.data?.available_carriers || [];
            if (carriers.length === 0) {
                carrierContainer.innerHTML = '<div class="p-3 bg-amber-50 text-amber-800 rounded-lg text-sm">Tidak ditemukan mitra logistik dengan kontrak aktif untuk rute ini. Silakan hubungi Aggregator.</div>';
                return;
            }

            let html = '';
            carriers.forEach((c, idx) => {
                const checked = idx === 0 ? 'checked' : '';
                if (idx === 0) roState.logistic_id = c.logistic_id;
                html += `
                    <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-slate-50 border-slate-200">
                        <div class="flex items-center space-x-3">
                            <input type="radio" name="selected_carrier" value="${c.logistic_id}" ${checked} onchange="window.selectCarrier(${c.logistic_id})" class="text-corporate-800 focus:ring-corporate-700">
                            <div>
                                <div class="font-semibold text-slate-800 text-sm">${c.logistic_name}</div>
                                <div class="text-xs text-slate-500">Estimasi Base: ${window.formatCurrency(c.total_estimated || c.linehaul_price)}</div>
                            </div>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded font-medium">Kontrak Aktif</span>
                    </label>
                `;
            });
            carrierContainer.innerHTML = html;
        } catch (e) {
            carrierContainer.innerHTML = '<div class="p-3 bg-rose-50 text-rose-800 rounded-lg text-sm">Gagal memuat rute kontrak. Default ke Logistik Merah Putih.</div>';
            roState.logistic_id = 1;
        }
    };

    window.selectCarrier = function(logisticId) {
        roState.logistic_id = logisticId;
    };

    window.selectFleetType = function(fleetTypeId) {
        roState.fleet_type_id = fleetTypeId;
        document.querySelectorAll('.fleet-card').forEach(card => {
            card.classList.remove('border-corporate-800', 'bg-blue-50/50');
        });
        const activeCard = document.getElementById(`fleet-card-${fleetTypeId}`);
        if (activeCard) activeCard.classList.add('border-corporate-800', 'bg-blue-50/50');
    };

    // Multi-Drop Sequencer Logic
    window.addDeliveryPoint = function() {
        const seq = roState.delivery_points.length + 1;
        roState.delivery_points.push({
            stop_sequence: seq,
            city_code: roState.destination_city_code,
            delivery_type: 2, // Distributor WH default
            distributor_warehouse_id: '',
            distributor_order_id: null,
            po_number: '',
            recipient_name: '',
            recipient_phone: '',
            address: '',
            items: [
                { product_id: 1, cargo_type_id: 1, quantity: 10, unit_price: 150000, notes: '' }
            ]
        });
        renderDeliveryPoints();
    };

    window.removeDeliveryPoint = function(index) {
        roState.delivery_points.splice(index, 1);
        roState.delivery_points.forEach((dp, idx) => dp.stop_sequence = idx + 1);
        renderDeliveryPoints();
    };

    function renderDeliveryPoints() {
        const container = document.getElementById('delivery-points-container');
        if (!container) return;

        if (roState.delivery_points.length === 0) {
            container.innerHTML = '<div class="p-6 text-center border-2 border-dashed border-slate-200 rounded-xl text-slate-500 text-sm">Belum ada titik drop pengiriman. Klik "+ Tambah Titik Drop" untuk memulai.</div>';
            return;
        }

        let html = '';
        roState.delivery_points.forEach((dp, idx) => {
            html += `
                <div class="p-5 border border-slate-200 rounded-xl bg-white shadow-sm mb-4">
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                        <div class="flex items-center space-x-2">
                            <span class="w-7 h-7 rounded-full bg-corporate-800 text-white flex items-center justify-center font-bold text-xs">${dp.stop_sequence}</span>
                            <h4 class="font-bold text-slate-800 text-sm">Drop Point #${dp.stop_sequence}</h4>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="window.openDistributorPoPicker(${idx})" class="px-2.5 py-1 text-xs font-medium text-corporate-800 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100">
                                📥 Import Distributor PO
                            </button>
                            <button type="button" onclick="window.removeDeliveryPoint(${idx})" class="text-rose-500 hover:text-rose-700 text-xs font-semibold">
                                Hapus Stop
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Tipe Tujuan (Delivery Type)</label>
                            <select class="w-full text-xs rounded-lg border-slate-200 p-2 border" onchange="window.updateDropField(${idx}, 'delivery_type', Number(this.value))">
                                <option value="1" ${dp.delivery_type === 1 ? 'selected' : ''}>Gudang Korporasi (Wh-to-Wh)</option>
                                <option value="2" ${dp.delivery_type === 2 ? 'selected' : ''}>Gudang Distributor</option>
                                <option value="3" ${dp.delivery_type === 3 ? 'selected' : ''}>End Customer B2B</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Nama Penerima</label>
                            <input type="text" value="${dp.recipient_name}" class="w-full text-xs rounded-lg border-slate-200 p-2 border" placeholder="Contoh: Distributor Bandung" oninput="window.updateDropField(${idx}, 'recipient_name', this.value)">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">No. Telp Penerima</label>
                            <input type="text" value="${dp.recipient_phone}" class="w-full text-xs rounded-lg border-slate-200 p-2 border" placeholder="0813..." oninput="window.updateDropField(${idx}, 'recipient_phone', this.value)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="block text-xs font-medium text-slate-600 mb-1">Alamat Lengkap Drop</label>
                        <input type="text" value="${dp.address}" class="w-full text-xs rounded-lg border-slate-200 p-2 border" placeholder="Jl. Raya Industri..." oninput="window.updateDropField(${idx}, 'address', this.value)">
                    </div>

                    <!-- Encapsulated Items -->
                    <div class="mt-4 pt-3 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-700">Daftar Produk untuk Stop #${dp.stop_sequence}:</span>
                            <button type="button" onclick="window.addItemToDrop(${idx})" class="text-xs text-corporate-800 font-semibold hover:underline">+ Tambah SKU Produk</button>
                        </div>
                        <div class="space-y-2">
                            ${dp.items.map((item, itemIdx) => `
                                <div class="flex items-center space-x-2 text-xs">
                                    <span class="text-slate-400 w-5 text-right">${itemIdx + 1}.</span>
                                    <select class="rounded border-slate-200 p-1 text-xs flex-1 border" onchange="window.updateItemField(${idx}, ${itemIdx}, 'product_id', Number(this.value))">
                                        <option value="1" ${item.product_id === 1 ? 'selected' : ''}>Produk Karton Merah Putih (PRD-CMP-001)</option>
                                        <option value="2" ${item.product_id === 2 ? 'selected' : ''}>Produk Cold Chain Merah Putih (PRD-CMP-002)</option>
                                    </select>
                                    <input type="number" min="1" value="${item.quantity}" class="w-20 rounded border-slate-200 p-1 text-xs border" placeholder="Qty" oninput="window.updateItemField(${idx}, ${itemIdx}, 'quantity', Number(this.value))">
                                    <input type="number" value="${item.unit_price}" class="w-28 rounded border-slate-200 p-1 text-xs border" placeholder="Harga Satuan" oninput="window.updateItemField(${idx}, ${itemIdx}, 'unit_price', Number(this.value))">
                                    <button type="button" onclick="window.removeItemFromDrop(${idx}, ${itemIdx})" class="text-rose-500 font-bold px-1 hover:text-rose-700">&times;</button>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;
    }

    window.updateDropField = function(dropIdx, field, val) {
        roState.delivery_points[dropIdx][field] = val;
    };

    window.updateItemField = function(dropIdx, itemIdx, field, val) {
        roState.delivery_points[dropIdx].items[itemIdx][field] = val;
    };

    window.addItemToDrop = function(dropIdx) {
        roState.delivery_points[dropIdx].items.push({
            product_id: 1,
            cargo_type_id: 1,
            quantity: 10,
            unit_price: 150000,
            notes: ''
        });
        renderDeliveryPoints();
    };

    window.removeItemFromDrop = function(dropIdx, itemIdx) {
        roState.delivery_points[dropIdx].items.splice(itemIdx, 1);
        renderDeliveryPoints();
    };

    // Calculate Dynamic Pricing in Step 5
    async function calculateAndRenderTariffSummary() {
        const summaryCard = document.getElementById('step-5-tariff-breakdown');
        summaryCard.innerHTML = '<div class="py-6 text-center text-slate-500 text-sm">Menghitung kalkulasi tarif dinamis berdasarkan kontrak...</div>';

        try {
            const response = await axios.post('/api/internal/corporate/request-orders/calculate-pricing', {
                logistic_id: roState.logistic_id || 1,
                origin_city_code: roState.origin_city_code || '31.71',
                destination_city_code: roState.destination_city_code || '35.78',
                fleet_type_id: roState.fleet_type_id || 1,
                cargo_type_id: 1,
                waypoints_count: roState.delivery_points.length
            });

            const pricing = response.data?.data || {};
            const rates = pricing.rates || {};

            summaryCard.innerHTML = `
                <div class="space-y-3">
                    <div class="flex justify-between text-sm text-slate-600">
                        <span>Tarif Antar Kota (Linehaul):</span>
                        <span class="font-semibold text-slate-800">${window.formatCurrency(rates.linehaul_price || 3500000)}</span>
                    </div>
                    <div class="flex justify-between text-sm text-slate-600">
                        <span>Biaya Langsir Luar Kota (Shunting):</span>
                        <span class="font-semibold text-slate-800">${window.formatCurrency(rates.shunting_price || 450000)}</span>
                    </div>
                    <div class="flex justify-between text-sm text-slate-600">
                        <span>Langsir Dalam Kota (Inner-City):</span>
                        <span class="font-semibold text-slate-800">${window.formatCurrency(rates.inner_city_shunting_price || 250000)}</span>
                    </div>
                    <div class="pt-3 border-t border-slate-200 flex justify-between text-base font-bold text-corporate-800">
                        <span>Total Estimasi Ongkos Kirim:</span>
                        <span>${window.formatCurrency(pricing.total_estimated_cost || 4200000)}</span>
                    </div>
                    <div class="p-3 bg-blue-50 text-blue-800 rounded-lg text-xs mt-2">
                        🔒 Tarif ini akan dibekukan ke dalam <b>snapshot_pricing</b> saat pesanan diajukan.
                    </div>
                </div>
            `;
        } catch (e) {
            summaryCard.innerHTML = `
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between font-bold text-slate-800">
                        <span>Total Estimasi Tarif:</span>
                        <span>Rp 4.200.000</span>
                    </div>
                </div>
            `;
        }
    }

    // Submit Request Order
    window.submitRequestOrder = async function() {
        const submitBtn = document.getElementById('submit-ro-btn');
        if (submitBtn) submitBtn.disabled = true;

        try {
            const response = await axios.post('/api/internal/corporate/request-orders', roState);
            window.showToast('Request Order berhasil diajukan!', 'success');
            setTimeout(() => {
                window.location.href = '/request-orders';
            }, 1000);
        } catch (e) {
            if (submitBtn) submitBtn.disabled = false;
            window.showToast(e.response?.data?.message || 'Gagal mengajukan Request Order.', 'error');
        }
    };
});
