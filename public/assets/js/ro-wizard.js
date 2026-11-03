// 5-Step Request Order Wizard Logic for CorporateFE (Direct Route & Direct Truck Rate)

let currentStep = 1;
const totalSteps = 5;

window.availableProducts = [];
window.availableWarehouses = [];

const roState = {
    order_date: new Date().toISOString().split('T')[0],
    origin_warehouse_id: '',
    origin_name: '',
    origin_city_code: '31.71',
    destination_city_code: '',
    destination_city_name: '',
    recipient_name: '',
    recipient_phone: '',
    destination_address: '',
    departure_date: '',
    shipper_pic: '',
    shipper_phone: '',
    shipper_notes: '',
    fleet_type_id: 1,
    fleet_name: 'CDE Box (Engkel)',
    total_qty: 0,
    total_weight: 0,
    items: [],
    pricing: {
        base_rate: 3500000,
        shunting: 450000,
        insurance: 5250,
        total: 3955250
    }
};

const fleetSpecs = {
    1: { name: 'CDE Box (Engkel)', capacity_kg: 2000, capacity_cbm: 7.0, default_base: 3500000 },
    2: { name: 'CDD Box (Double)', capacity_kg: 4000, capacity_cbm: 14.0, default_base: 4500000 },
    3: { name: 'Fuso Heavy Box', capacity_kg: 8000, capacity_cbm: 30.0, default_base: 7500000 },
    4: { name: 'Tronton Wingbox', capacity_kg: 15000, capacity_cbm: 48.0, default_base: 12500000 }
};

document.addEventListener('DOMContentLoaded', async () => {
    // 1. Set default departure date to now + 2 hours
    const depInput = document.getElementById('departureDate');
    if (depInput && !depInput.value) {
        const now = new Date();
        now.setHours(now.getHours() + 2);
        now.setMinutes(0);
        depInput.value = now.toISOString().slice(0, 16);
    }

    // 2. Fetch products for SKU catalog
    await fetchCargoProducts();

    // 3. Bind Warehouse Picker event
    bindWarehousePicker();

    // 4. Bind Destination City Picker event
    bindDestinationCityPicker();

    // 5. Bind Product Picker search
    bindProductPickerSearch();

    // 6. Pre-add 1 demo item row if empty
    if (window.availableProducts.length > 0) {
        addProductToCargo(window.availableProducts[0], 10);
    }
});

// Bind Origin Warehouse Picker Selection
function bindWarehousePicker() {
    const hiddenWh = document.getElementById('hidden-originWarehouse');
    if (!hiddenWh) return;

    hiddenWh.addEventListener('change', (e) => {
        let item = e.detail?.item;
        if (!item && hiddenWh.dataset.item) {
            try { item = JSON.parse(hiddenWh.dataset.item); } catch (err) {}
        }

        if (item) {
            roState.origin_warehouse_id = item.id;
            roState.origin_name = item.name;
            roState.origin_city_code = item.city_code || '31.71';

            const picInput = document.getElementById('shipperPic');
            const phoneInput = document.getElementById('shipperPhone');
            const notesInput = document.getElementById('shipperNotes');

            if (picInput && item.pic_name) picInput.value = item.pic_name;
            if (phoneInput && item.phone) phoneInput.value = item.phone;
            if (notesInput && !notesInput.value && item.address) {
                notesInput.value = `Muatan dari ${item.name}, ${item.address}`;
            }

            if (roState.destination_city_code) {
                calculateDynamicTariff();
            }
        }
    });
}

// Bind Destination City Picker Selection
function bindDestinationCityPicker() {
    const hiddenCity = document.getElementById('hidden-destinationCity');
    if (!hiddenCity) return;

    hiddenCity.addEventListener('change', (e) => {
        let item = e.detail?.item;
        if (!item && hiddenCity.dataset.item) {
            try { item = JSON.parse(hiddenCity.dataset.item); } catch (err) {}
        }

        if (item) {
            roState.destination_city_code = item.id;
            roState.destination_city_name = item.name;

            // Update drop address placeholder or prepopulate if empty
            const dropAddress = document.querySelector('.drop-address');
            if (dropAddress && !dropAddress.value) {
                dropAddress.placeholder = `Alamat lengkap penerima di ${item.name}`;
            }

            if (roState.origin_city_code) {
                calculateDynamicTariff();
            }
        }
    });
}

// Fetch products from API
async function fetchCargoProducts() {
    try {
        const res = await axios.get('/api/products?per_page=100');
        const raw = res.data?.data;
        const list = Array.isArray(raw) ? raw : (raw?.data || []);
        window.availableProducts = list.length > 0 ? list : getDefaultProducts();
    } catch (err) {
        console.warn('Fetch products warning, using defaults:', err);
        window.availableProducts = getDefaultProducts();
    }
    renderProductPickerModal(window.availableProducts);
}

function getDefaultProducts() {
    return [
        { id: 1, name: 'Beras Premium 5kg', sku: 'SKU-BRG-001', weight: 5, base_price: 75000, uom: 'Sak' },
        { id: 2, name: 'Minyak Goreng 2L', sku: 'SKU-BRG-002', weight: 2, base_price: 36000, uom: 'Pouch' },
        { id: 3, name: 'Gula Pasir 1kg', sku: 'SKU-BRG-003', weight: 1, base_price: 18000, uom: 'Bungkus' },
        { id: 4, name: 'Tepung Terigu 25kg', sku: 'SKU-BRG-004', weight: 25, base_price: 245000, uom: 'Karung' },
        { id: 5, name: 'Mie Instan Dus (40 Pcs)', sku: 'SKU-BRG-005', weight: 4.5, base_price: 120000, uom: 'Karton' }
    ];
}

// Render Product Modal Picker List
function renderProductPickerModal(products) {
    const tbody = document.getElementById('tbody-product-picker');
    if (!tbody) return;

    if (!products || products.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="px-4 py-4 text-center text-slate-400">Tidak ada produk ditemukan.</td></tr>';
        return;
    }

    tbody.innerHTML = products.map((p, idx) => `
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">
            <td class="px-4 py-3 whitespace-nowrap text-xs font-bold text-slate-500">${idx + 1}</td>
            <td class="px-4 py-3 whitespace-nowrap text-xs font-mono font-bold text-slate-700 dark:text-slate-300">
                <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700">${p.sku || p.code || 'SKU-' + p.id}</span>
            </td>
            <td class="px-4 py-3 text-xs text-slate-800 dark:text-slate-200">
                <div class="font-bold">${p.name}</div>
                <div class="text-[11px] text-slate-400">${p.uom || 'Unit'} • Rp ${Number(p.base_price || p.price || 0).toLocaleString('id-ID')}</div>
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-right text-xs font-bold text-slate-600 dark:text-slate-300">
                ${Number(p.weight || p.weight_kg || 1).toLocaleString('id-ID')} kg
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-end text-xs">
                <button type="button" onclick="selectProductFromPicker(${p.id})" class="px-3 py-1 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-sm transition-all">
                    Pilih
                </button>
            </td>
        </tr>
    `).join('');
}

// Bind search input on product modal
function bindProductPickerSearch() {
    const searchInput = document.getElementById('search-product-picker');
    if (!searchInput) return;

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        const filtered = window.availableProducts.filter(p => {
            const name = (p.name || '').toLowerCase();
            const sku = (p.sku || p.code || '').toLowerCase();
            return name.includes(query) || sku.includes(query);
        });
        renderProductPickerModal(filtered);
    });
}

// Open Product Picker for new row
window.openProductPickerForNewRow = function() {
    const modalEl = document.getElementById('modal-product-picker');
    if (!modalEl) return;
    if (modalEl.parentElement !== document.body) {
        document.body.appendChild(modalEl);
    }
    document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
    document.body.classList.remove('overflow-hidden');
    document.body.style.overflow = '';
    modalEl.style.display = 'flex';
    modalEl.classList.remove('hidden');
    
    // Ensure product modal list is immediately rendered
    if (!window.availableProducts || window.availableProducts.length === 0) {
        window.availableProducts = getDefaultProducts();
    }
    renderProductPickerModal(window.availableProducts);

    const searchInput = document.getElementById('search-product-picker');
    if (searchInput) {
        setTimeout(() => searchInput.focus(), 60);
    }
};

window.closeProductPickerModal = function() {
    const modalEl = document.getElementById('modal-product-picker');
    if (modalEl) {
        modalEl.style.display = 'none';
        modalEl.classList.add('hidden');
    }
    document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
    document.body.classList.remove('overflow-hidden');
    document.body.style.overflow = '';
};

// Handle product selected from modal
window.selectProductFromPicker = function(productId) {
    const prod = window.availableProducts.find(p => p.id == productId);
    if (!prod) return;

    addProductToCargo(prod, 10);

    // Close product picker modal
    window.closeProductPickerModal();
};

// Add product to cargo table
function addProductToCargo(prod, defaultQty = 10) {
    const tbody = document.getElementById('productRowsBody');
    if (!tbody) return;

    // Check if already in table, then increment qty
    const existingRow = tbody.querySelector(`tr[data-product-id="${prod.id}"]`);
    if (existingRow) {
        const qtyInput = existingRow.querySelector('.prod-qty');
        if (qtyInput) {
            qtyInput.value = parseInt(qtyInput.value || 0) + defaultQty;
            calculateCargoTotals();
            return;
        }
    }

    const rawWeight = parseFloat(prod.weight !== undefined && prod.weight !== null ? prod.weight : (prod.weight_kg ?? 1));
    const weight = (rawWeight > 0) ? rawWeight : 5;
    const lengthCm = parseFloat(prod.length || prod.length_cm || 0);
    const widthCm = parseFloat(prod.width || prod.width_cm || 0);
    const heightCm = parseFloat(prod.height || prod.height_cm || 0);
    const cbmPerUnit = (lengthCm > 0 && widthCm > 0 && heightCm > 0)
        ? (lengthCm * widthCm * heightCm) / 1000000
        : (parseFloat(prod.volume_cbm || prod.volume || 0) || Math.max(0.01, parseFloat((weight / 250).toFixed(4))));
    const subtotalWeight = weight * defaultQty;

    const row = document.createElement('tr');
    row.className = 'hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors';
    row.dataset.productId = prod.id;
    row.dataset.weight = weight;
    row.dataset.cbm = cbmPerUnit;

    row.innerHTML = `
        <td class="py-3 px-4 font-bold text-slate-500 prod-row-no">1</td>
        <td class="py-3 px-4">
            <div class="flex items-center gap-2">
                <span class="px-2 py-0.5 rounded bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 font-mono text-[11px] font-bold">
                    ${prod.sku || prod.code || 'SKU-' + prod.id}
                </span>
                <span class="font-bold text-slate-800 dark:text-slate-200">${prod.name}</span>
            </div>
        </td>
        <td class="py-3 px-2 text-center">
            <input type="number" min="1" value="${defaultQty}" class="prod-qty w-24 px-2.5 py-1.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-center font-bold" oninput="calculateCargoTotals()" />
        </td>
        <td class="py-3 px-3 text-right font-medium text-slate-600 dark:text-slate-400 prod-unit-weight">
            ${weight.toLocaleString('id-ID')} kg
        </td>
        <td class="py-3 px-4 text-right font-black text-slate-800 dark:text-slate-200 prod-subtotal-weight">
            ${subtotalWeight.toLocaleString('id-ID')} kg
        </td>
        <td class="py-3 px-2 text-center">
            <button type="button" onclick="removeProductRow(this)" class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-all" title="Hapus Barang">
                <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
            </button>
        </td>
    `;

    tbody.appendChild(row);
    calculateCargoTotals();
}

window.removeProductRow = function(btn) {
    const row = btn.closest('tr');
    if (row) {
        row.remove();
        calculateCargoTotals();
    }
};

window.calculateCargoTotals = function() {
    const rows = document.querySelectorAll('#productRowsBody tr');
    let totalQty = 0;
    let totalWeight = 0;
    let totalVolume = 0;
    const items = [];

    rows.forEach((r, idx) => {
        const noEl = r.querySelector('.prod-row-no');
        if (noEl) noEl.innerText = idx + 1;
        const prodId = r.dataset.productId;
        const rawW = parseFloat(r.dataset.weight || 0);
        const weight = (rawW > 0) ? rawW : 5;
        const cbm = parseFloat(r.dataset.cbm || 0);
        const qtyInput = r.querySelector('.prod-qty');
        const qty = parseFloat(qtyInput?.value || 0);
        const subtotal = weight * qty;
        const subtotalCbm = cbm * qty;

        totalQty += qty;
        totalWeight += subtotal;
        totalVolume += subtotalCbm;

        const subtotalEl = r.querySelector('.prod-subtotal-weight');
        if (subtotalEl) subtotalEl.innerText = `${subtotal.toLocaleString('id-ID')} kg`;

        items.push({
            product_id: prodId,
            quantity: qty,
            weight_per_unit: weight,
            subtotal_weight: subtotal,
            volume_cbm: cbm,
            subtotal_volume: subtotalCbm
        });
    });

    roState.total_qty = totalQty;
    roState.total_weight = totalWeight;
    roState.total_volume = parseFloat(totalVolume.toFixed(2));
    roState.items = items;

    const qtyDisplay = document.getElementById('totalQtyDisplay');
    const weightDisplay = document.getElementById('totalWeightDisplay');

    if (qtyDisplay) qtyDisplay.innerText = `${totalQty.toLocaleString('id-ID')} unit`;
    if (weightDisplay) {
        const ton = (totalWeight / 1000).toFixed(2);
        weightDisplay.innerText = `${totalWeight.toLocaleString('id-ID')} kg (${ton} ton)`;
    }

    // Auto recommend suitable truck fleet based on cargo weight
    autoRecommendFleet(totalWeight);
};

// Auto recommend fleet type based on weight
function autoRecommendFleet(weightKg) {
    let recommendedId = 1;
    if (weightKg <= 2000) recommendedId = 1; // CDE
    else if (weightKg <= 4000) recommendedId = 2; // CDD
    else if (weightKg <= 8000) recommendedId = 3; // Fuso
    else recommendedId = 4; // Tronton Wingbox

    const badge = document.getElementById('fleetRecommendedBadge');
    const badgeText = document.getElementById('recommendedFleetText');
    const spec = fleetSpecs[recommendedId];

    if (badge && badgeText && spec) {
        badge.classList.remove('hidden');
        badgeText.innerText = `Rekomendasi Muatan: ${spec.name}`;
    }

    // Only auto-select if current fleet cannot hold weight
    const currentSpec = fleetSpecs[roState.fleet_type_id];
    if (currentSpec && currentSpec.capacity_kg < weightKg) {
        selectFleet(recommendedId);
    }
}

// Select Fleet Type (Rate of Truck Direct)
window.selectFleet = function(fleetId) {
    roState.fleet_type_id = fleetId;
    const spec = fleetSpecs[fleetId] || fleetSpecs[1];
    roState.fleet_name = spec.name;

    const hiddenFleetInput = document.getElementById('selectedFleetTypeId');
    if (hiddenFleetInput) hiddenFleetInput.value = fleetId;

    const badgeText = document.getElementById('selectedFleetBadgeText');
    if (badgeText) badgeText.innerText = `Armada: ${spec.name}`;

    // Highlight card
    document.querySelectorAll('.fleet-card').forEach(card => {
        const id = card.getAttribute('data-fleet-id');
        const badge = card.querySelector('.fleet-badge');
        if (id == fleetId) {
            card.className = 'fleet-card cursor-pointer p-4 rounded-2xl border-2 border-blue-600 bg-blue-50/40 dark:bg-blue-950/40 relative flex flex-col justify-between transition-all shadow-md';
            if (badge) {
                badge.className = 'fleet-badge px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-600 text-white';
                badge.classList.remove('hidden');
            }
        } else {
            card.className = 'fleet-card cursor-pointer p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 relative flex flex-col justify-between transition-all hover:border-blue-400';
            if (badge) {
                badge.classList.add('hidden');
            }
        }
    });

    calculateDynamicTariff();
};

// Calculate Dynamic Truck Rate
window.calculateDynamicTariff = async function() {
    const spec = fleetSpecs[roState.fleet_type_id] || fleetSpecs[1];
    let baseRate = spec.default_base;
    let shunting = 450000;

    const originCity = roState.origin_city_code || '31.71';
    const destCity = roState.destination_city_code || '32.73';

    try {
        const res = await axios.post('/api/request-orders/calculate-pricing', {
            origin_city_code: originCity,
            destination_city_code: destCity,
            fleet_type_id: roState.fleet_type_id,
            total_weight_kg: roState.total_weight,
            is_direct_route: true
        });

        const data = res.data?.data || {};
        const rates = data.rates || {};
        baseRate = Number(rates.linehaul_price || rates.subtotal_base_rate || data.base_rate || baseRate);
        shunting = Number(rates.shunting_price || data.shunting_price || shunting);
    } catch (err) {
        console.info('Pricing API using contract table rates for route', originCity, '->', destCity);
    }

    const insurance = Math.round(baseRate * 0.0015);
    const total = baseRate + shunting + insurance;

    roState.pricing = {
        base_rate: baseRate,
        shunting: shunting,
        insurance: insurance,
        total: total
    };

    // Update displays in Step 4
    const baseEl = document.getElementById('rateBaseDisplay');
    const shuntingEl = document.getElementById('rateShuntingDisplay');
    const insuranceEl = document.getElementById('rateInsuranceDisplay');
    const totalEl = document.getElementById('rateTotalDisplay');

    if (baseEl) baseEl.innerText = `Rp ${baseRate.toLocaleString('id-ID')}`;
    if (shuntingEl) shuntingEl.innerText = `Rp ${shunting.toLocaleString('id-ID')}`;
    if (insuranceEl) insuranceEl.innerText = `Rp ${insurance.toLocaleString('id-ID')}`;
    if (totalEl) totalEl.innerText = `Rp ${total.toLocaleString('id-ID')}`;

    // Update current fleet rate display on the card
    const cdeRate = document.getElementById('cde-rate-display');
    const cddRate = document.getElementById('cdd-rate-display');
    const fusoRate = document.getElementById('fuso-rate-display');
    const trontonRate = document.getElementById('tronton-rate-display');

    if (cdeRate && roState.fleet_type_id === 1) cdeRate.innerText = `Rp ${baseRate.toLocaleString('id-ID')}`;
    if (cddRate && roState.fleet_type_id === 2) cddRate.innerText = `Rp ${baseRate.toLocaleString('id-ID')}`;
    if (fusoRate && roState.fleet_type_id === 3) fusoRate.innerText = `Rp ${baseRate.toLocaleString('id-ID')}`;
    if (trontonRate && roState.fleet_type_id === 4) trontonRate.innerText = `Rp ${baseRate.toLocaleString('id-ID')}`;
};

// Wizard Step Navigation
window.goToStep = function(step) {
    if (step < 1 || step > totalSteps) return;

    if (step > currentStep) {
        if (!validateStep(currentStep)) return;
    }

    for (let i = 1; i <= totalSteps; i++) {
        const content = document.getElementById(`step-content-${i}`);
        const nav = document.getElementById(`step-nav-${i}`);

        if (content) {
            if (i === step) content.classList.remove('hidden');
            else content.classList.add('hidden');
        }

        if (nav) {
            const badge = nav.querySelector('div');
            if (i === step) {
                nav.classList.remove('opacity-40');
                if (badge) badge.className = 'w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs shadow-md shadow-blue-600/30';
            } else if (i < step) {
                nav.classList.remove('opacity-40');
                if (badge) badge.className = 'w-8 h-8 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-xs';
            } else {
                nav.classList.add('opacity-40');
                if (badge) badge.className = 'w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold flex items-center justify-center text-xs';
            }
        }
    }

    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    if (prevBtn) {
        if (step === 1) prevBtn.classList.add('hidden');
        else prevBtn.classList.remove('hidden');
    }

    if (nextBtn) {
        if (step === totalSteps) nextBtn.classList.add('hidden');
        else nextBtn.classList.remove('hidden');
    }

    if (submitBtn) {
        if (step === totalSteps) submitBtn.classList.remove('hidden');
        else submitBtn.classList.add('hidden');
    }

    currentStep = step;

    if (currentStep === 4) {
        calculateDynamicTariff();
    } else if (currentStep === 5) {
        populateReviewStep();
    }

    window.scrollTo({ top: 120, behavior: 'smooth' });
};

window.nextStep = function() {
    goToStep(currentStep + 1);
};

window.prevStep = function() {
    goToStep(currentStep - 1);
};

// Validate steps
function validateStep(step) {
    if (step === 1) {
        const whId = document.getElementById('hidden-originWarehouse')?.value;
        const dep = document.getElementById('departureDate')?.value;
        const pic = document.getElementById('shipperPic')?.value;
        const phone = document.getElementById('shipperPhone')?.value;

        if (!whId) {
            window.Alert ? window.Alert.toast('Silakan pilih Gudang Asal menggunakan picker.', 'error') : Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan pilih Gudang Asal pemuatan.' });
            return false;
        }
        if (!dep) {
            window.Alert ? window.Alert.toast('Silakan tentukan Jadwal Muat (Departure Date).', 'error') : Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan tentukan Jadwal Muat.' });
            return false;
        }
        if (!pic || !phone) {
            window.Alert ? window.Alert.toast('Lengkapi nama PIC dan nomor telepon pemuatan.', 'error') : Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan lengkapi kontak dan telepon PIC.' });
            return false;
        }

        roState.origin_warehouse_id = whId;
        roState.departure_date = dep;
        roState.shipper_pic = pic;
        roState.shipper_phone = phone;
        roState.shipper_notes = document.getElementById('shipperNotes')?.value || '';
    } else if (step === 2) {
        const rec = document.querySelector('.drop-recipient')?.value;
        const cityId = document.getElementById('hidden-destinationCity')?.value;
        const phone = document.querySelector('.drop-phone')?.value;
        const addr = document.querySelector('.drop-address')?.value;

        if (!rec) {
            window.Alert ? window.Alert.toast('Silakan masukkan Nama Penerima / Toko.', 'error') : Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Nama Penerima wajib diisi.' });
            return false;
        }
        if (!cityId) {
            window.Alert ? window.Alert.toast('Silakan pilih Kota / Kabupaten tujuan menggunakan picker.', 'error') : Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Kota / Kabupaten tujuan wajib dipilih.' });
            return false;
        }
        if (!phone) {
            window.Alert ? window.Alert.toast('Silakan masukkan Nomor Telepon penerima.', 'error') : Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Telepon penerima wajib diisi.' });
            return false;
        }
        if (!addr) {
            window.Alert ? window.Alert.toast('Silakan masukkan Alamat Lengkap Bongkar.', 'error') : Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Alamat bongkar wajib diisi.' });
            return false;
        }

        roState.recipient_name = rec;
        roState.recipient_phone = phone;
        roState.destination_city_code = cityId;
        roState.destination_address = addr;
    } else if (step === 3) {
        if (!roState.items || roState.items.length === 0 || roState.total_qty <= 0) {
            window.Alert ? window.Alert.toast('Silakan pilih minimal 1 produk kargo SKU.', 'error') : Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Muatan produk belum ditambahkan.' });
            return false;
        }
    }

    return true;
}

// Populate Step 5 Review
function populateReviewStep() {
    const originText = roState.origin_name ? `${roState.origin_name} (Hub Asal)` : 'Gudang Utama Korporasi';
    const destCityText = document.getElementById('display-destinationCity')?.value || roState.destination_city_name || 'Kota Bandung';
    const destText = `${roState.recipient_name || 'Toko Mitra'} - ${destCityText}`;
    const fleetText = roState.fleet_name || 'CDE Box (Engkel)';
    const weightText = `${roState.total_weight.toLocaleString('id-ID')} kg (${(roState.total_weight / 1000).toFixed(2)} ton) • ${roState.total_qty} Unit`;
    const costText = `Rp ${roState.pricing.total.toLocaleString('id-ID')}`;

    const revOrigin = document.getElementById('reviewOrigin');
    const revDest = document.getElementById('reviewDestinations');
    const revDep = document.getElementById('reviewDeparture');
    const revFleet = document.getElementById('reviewFleet');
    const revWeight = document.getElementById('reviewWeight');
    const revCost = document.getElementById('reviewTotalCost');

    if (revOrigin) revOrigin.innerText = originText;
    if (revDest) revDest.innerText = destText;
    if (revDep) revDep.innerText = roState.departure_date ? roState.departure_date.replace('T', ' ') : '-';
    if (revFleet) revFleet.innerText = fleetText;
    if (revWeight) revWeight.innerText = weightText;
    if (revCost) revCost.innerText = costText;
}

// Submit Request Order
window.submitRequestOrder = async function() {
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<iconify-icon icon="solar:spinner-line" class="animate-spin text-base"></iconify-icon><span>Memproses RO...</span>';
    }

    const payload = {
        order_date: roState.order_date,
        departure_date: roState.departure_date || new Date().toISOString().slice(0, 16),
        origin_warehouse_id: roState.origin_warehouse_id || 1,
        origin_city_code: roState.origin_city_code || '31.71',
        destination_city_code: roState.destination_city_code || '32.73',
        fleet_type_id: roState.fleet_type_id || 1,
        cargo_type_id: 1,
        total_weight: roState.total_weight || 0,
        total_weight_kg: roState.total_weight || 0,
        total_volume: roState.total_volume || 0,
        total_volume_cbm: roState.total_volume || 0,
        logistic_id: 1, // Logistik Merah Putih primary contractor
        shipper_name: roState.shipper_pic || 'PIC Gudang',
        shipper_phone: roState.shipper_phone || '08123456789',
        notes: roState.shipper_notes || '',
        po_number: document.getElementById('poReference')?.value || '',
        delivery_points: [
            {
                stop_sequence: 1,
                delivery_type: 1,
                city_code: roState.destination_city_code || '32.73',
                recipient_name: roState.recipient_name || 'Toko Mitra Grosir',
                recipient_phone: roState.recipient_phone || '081987654321',
                address: roState.destination_address || 'Alamat Penerima',
                total_weight_kg: roState.total_weight || 0,
                total_volume_cbm: roState.total_volume || 0,
                items: roState.items
            }
        ],
        items: roState.items
    };

    try {
        const res = await axios.post('/api/request-orders', payload);
        Swal.fire({
            icon: 'success',
            title: 'Request Order Terbit!',
            text: 'Order pemesanan armada truk berhasil dibuat dan diteruskan ke sistem logistik.',
            confirmButtonColor: '#2563eb'
        }).then(() => {
            window.location.href = '/request-orders';
        });
    } catch (err) {
        console.error('Submit Request Order error:', err);
        const errMsg = err.response?.data?.message || 'Gagal membuat Request Order. Silakan periksa kembali data Anda.';
        Swal.fire({
            icon: 'error',
            title: 'Gagal Membuat RO',
            text: errMsg,
            confirmButtonColor: '#2563eb'
        });
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon><span>Kirim Request Order Sekarang</span>';
        }
    }
};
