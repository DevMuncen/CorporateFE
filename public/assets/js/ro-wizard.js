// 5-Step Request Order Wizard Logic for CorporateFE (Direct Route & Direct Truck Rate strictly from Contract)

let currentStep = 1;
const totalSteps = 5;

window.availableProducts = [];
window.availableWarehouses = [];

const roState = {
    customer_id: null,
    distributor_id: null,
    customer_name: '',
    customer_code: '',
    customer_type: 'customer',
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
    logistic_id: null,
    logistic_name: '',
    contract_id: null,
    contract_number: '',
    fleet_type_id: null,
    fleet_name: '',
    available_fleets: [],
    total_qty: 0,
    total_weight: 0,
    total_volume: 0,
    items: [],
    pricing: {
        base_rate: 0,
        shunting: 0,
        insurance: 0,
        total: 0
    }
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

    // 5. Bind Customer Picker event (Autofill & Foreign Key)
    bindCustomerPicker();

    // 6. Bind Product Picker search
    bindProductPickerSearch();

    // 7. Pre-add 1 demo item row if empty
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
            roState.origin_city_code = item.city_code || (item.city && /^\d+$/.test(item.city) ? (item.city.length === 4 ? item.city.slice(0, 2) + '.' + item.city.slice(2) : item.city) : item.city) || '31.71';

            const picInput = document.getElementById('shipperPic');
            const phoneInput = document.getElementById('shipperPhone');
            const notesInput = document.getElementById('shipperNotes');

            if (picInput && item.pic_name) picInput.value = item.pic_name;
            if (phoneInput && item.phone) phoneInput.value = item.phone;
            if (notesInput && !notesInput.value && item.address) {
                notesInput.value = `Muatan dari ${item.name}, ${item.address}`;
            }

            if (roState.destination_city_code) {
                fetchCarrierAndFleetOptions();
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

            // If a registered customer is currently tied, sync this city to the customer profile
            if (roState.customer_id && item.id) {
                axios.put(`/api/customers/${roState.customer_id}`, {
                    city_code: item.id
                }).catch(err => console.warn('Customer city auto-sync warning:', err));
            }

            if (roState.origin_city_code) {
                fetchCarrierAndFleetOptions();
            }
        }
    });
}

// Bind Customer Picker Selection (Autofill Recipient, City, Phone, Address & Tie Foreign Key)
function bindCustomerPicker() {
    const hiddenCust = document.getElementById('hidden-corporateCustomer');
    if (!hiddenCust) return;

    hiddenCust.addEventListener('change', (e) => {
        let item = e.detail?.item;
        if (!item && hiddenCust.dataset.item) {
            try { item = JSON.parse(hiddenCust.dataset.item); } catch (err) {}
        }

        const badge = document.getElementById('customerTiedBadge');
        const badgeText = document.getElementById('customerTiedText');

        if (item && item.id) {
            roState.customer_id = item.id;
            roState.customer_name = item.name;
            roState.customer_code = item.code || '';
            roState.customer_type = item.type || 'customer';
            roState.distributor_id = (item.type === 'distributor') ? (item.distributor_id || item.id) : null;

            // 1. Autofill Recipient Name
            const recipientInput = document.querySelector('.drop-recipient');
            if (recipientInput) {
                recipientInput.value = item.name;
                roState.recipient_name = item.name;
            }

            // 2. Autofill Recipient Phone
            const phoneInput = document.querySelector('.drop-phone');
            const phoneVal = item.phone || item.pic_phone || '';
            if (phoneInput && phoneVal) {
                phoneInput.value = phoneVal;
                roState.recipient_phone = phoneVal;
            }

            // 3. Autofill Delivery Address
            const addressInput = document.querySelector('.drop-address');
            if (addressInput && item.address) {
                addressInput.value = item.address;
                roState.destination_address = item.address;
            }

            // 4. Autofill Destination City if configured on customer
            if (item.city_code) {
                const cityName = item.city_name || (item.city_code === '32.73' || item.city_code === '3273' ? 'KOTA BANDUNG' : item.city_code);
                roState.destination_city_code = item.city_code;
                roState.destination_city_name = cityName;

                const hiddenCity = document.getElementById('hidden-destinationCity');
                const displayCity = document.getElementById('display-destinationCity');
                if (hiddenCity) hiddenCity.value = item.city_code;
                if (displayCity) displayCity.value = cityName;

                if (window.setPickerValue) {
                    window.setPickerValue('destinationCity', item.city_code, cityName, { id: item.city_code, name: cityName });
                } else if (hiddenCity) {
                    hiddenCity.dispatchEvent(new CustomEvent('change', { bubbles: true, detail: { id: item.city_code, name: cityName, item: { id: item.city_code, name: cityName } } }));
                }

                if (roState.origin_city_code) {
                    fetchCarrierAndFleetOptions(false);
                }
            }

            // Show Customer / Distributor Tied Badge
            if (badge) {
                badge.classList.remove('hidden');
                if (badgeText) {
                    if (roState.customer_type === 'distributor') {
                        badge.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800 dark:bg-purple-900/60 dark:text-purple-300';
                        badgeText.innerText = `Terikat: ${item.name} (Mitra Distribusi: ${item.code || 'DIST'})`;
                    } else {
                        badge.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300';
                        badgeText.innerText = `Terikat: ${item.name} (Pelanggan B2B: ${item.code || 'B2B'})`;
                    }
                }
            }

            if (window.Alert) {
                const label = roState.customer_type === 'distributor' ? 'Mitra Distribusi' : 'Pelanggan B2B';
                window.Alert.toast(`Data ${label} ${item.name} berhasil dimuat otomatis.`, 'success');
            }
        } else {
            // Customer Cleared / Unlinked
            roState.customer_id = null;
            roState.distributor_id = null;
            roState.customer_name = '';
            roState.customer_code = '';
            roState.customer_type = 'customer';
            if (badge) badge.classList.add('hidden');
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
        tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-4 text-center text-slate-400">Tidak ada produk ditemukan.</td></tr>';
        return;
    }

    tbody.innerHTML = products.map(p => `
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">
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
    document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
    modalEl.style.display = 'flex';
    modalEl.classList.remove('hidden');
};

window.closeProductPickerModal = function() {
    const modalEl = document.getElementById('modal-product-picker');
    if (modalEl) {
        modalEl.style.display = 'none';
        modalEl.classList.add('hidden');
    }
    document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
};

// Handle product selected from modal
window.selectProductFromPicker = function(productId) {
    const prod = window.availableProducts.find(p => p.id == productId);
    if (!prod) return;

    addProductToCargo(prod, 10);
    window.closeProductPickerModal();
};

// Add product to cargo table
function addProductToCargo(prod, defaultQty = 10) {
    const tbody = document.getElementById('productRowsBody');
    if (!tbody) return;

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

    rows.forEach(r => {
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

    // Auto recommend suitable truck fleet based on cargo weight & available contracted fleets
    autoRecommendFleet(totalWeight);
};

// Copy route addendum request template to clipboard
window.copyRouteAddendumRequest = function() {
    const originText = roState.origin_name || 'Gudang Utama Korporasi';
    const originCode = roState.origin_city_code || '31.71';
    const destText = document.getElementById('display-destinationCity')?.value || roState.destination_city_name || 'Kota Tujuan';
    const destCode = roState.destination_city_code || '-';
    const contractRef = roState.contract_number || (roState.contract_diagnostic?.active_contracts?.[0]?.reference_number) || 'Kontrak Induk';
    const carrierName = roState.logistic_name || (roState.contract_diagnostic?.active_contracts?.[0]?.logistic_name) || 'Mitra Logistik';

    const text = `Halo ${carrierName},\n\nKami dari PT Korporasi ingin mengajukan penambahan addendum tarif rute baru pada Kontrak #${contractRef}:\n- Rute Asal: ${originText} (Kode Wilayah: ${originCode})\n- Rute Tujuan: ${destText} (Kode Wilayah: ${destCode})\n\nMohon bantuannya untuk mendaftarkan tarif rute armada ini ke sistem. Terima kasih.`;

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(() => {
            if (window.Swal) {
                Swal.fire({
                    icon: 'success',
                    title: 'Rincian Berhasil Disalin',
                    text: 'Teks permohonan addendum tarif rute telah disalin ke clipboard untuk dikirim ke Mitra Transporter / Admin.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                alert('Teks permohonan addendum rute telah disalin.');
            }
        });
    } else {
        prompt('Salin teks pengajuan addendum berikut:', text);
    }
};

// Fetch carriers and fleet types strictly from active corporate contract
window.fetchCarrierAndFleetOptions = async function(showAlert = false) {
    const originCity = roState.origin_city_code || '31.71';
    const destCity = roState.destination_city_code;

    const container = document.getElementById('fleetSelectionContainer');
    const carrierBadge = document.getElementById('carrierContractInfo');
    const badge = document.getElementById('fleetRecommendedBadge');
    const alertBanner = document.getElementById('noContractAlertBanner');
    const routeNotice = document.getElementById('routeContractNotice');
    const routeNoticeTitle = document.getElementById('routeContractNoticeTitle');
    const routeNoticeText = document.getElementById('routeContractNoticeText');
    const routeNoticeBadge = document.getElementById('routeContractNoticeBadge');
    const routeNoticeIconWrapper = document.getElementById('routeContractIconWrapper');
    const routeNoticeIcon = document.getElementById('routeContractIcon');

    if (!destCity) {
        if (container) {
            container.innerHTML = `
                <div class="col-span-full py-8 text-center bg-slate-50 dark:bg-slate-900/40 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                    <iconify-icon icon="solar:routing-2-bold-duotone" class="text-3xl text-slate-400 mb-2"></iconify-icon>
                    <p class="text-xs text-slate-500 font-medium">Silakan tentukan Kota / Kabupaten Tujuan pada Tahap 2 terlebih dahulu untuk memuat armada dari kontrak korporasi.</p>
                </div>
            `;
        }
        if (alertBanner) alertBanner.classList.add('hidden');
        if (routeNotice) routeNotice.classList.add('hidden');
        return false;
    }

    if (container) {
        container.innerHTML = `
            <div class="col-span-full py-8 text-center">
                <iconify-icon icon="solar:spinner-line" class="animate-spin text-2xl text-blue-600 mb-2"></iconify-icon>
                <p class="text-xs text-slate-500 font-medium">Memeriksa kontrak aktif dan tarif armada rute terpilih...</p>
            </div>
        `;
    }

    try {
        const res = await axios.post('/api/request-orders/inquire-routes', {
            origin_city_code: originCity,
            destination_city_codes: [destCity]
        });

        const carriers = res.data?.data?.available_carriers || res.data?.data?.carriers || [];
        const contractStatus = res.data?.data?.contract_status || {};
        roState.contract_diagnostic = contractStatus;

        const originName = roState.origin_name || 'Gudang Utama Korporasi';
        const destCityName = document.getElementById('display-destinationCity')?.value || roState.destination_city_name || `Kota (${destCity})`;

        // CASE A: No Carriers or Fleets Available (Missing Contract or Missing Route Pricing)
        if (!carriers || carriers.length === 0) {
            roState.available_fleets = [];
            roState.fleet_type_id = null;
            if (carrierBadge) carrierBadge.classList.add('hidden');
            if (badge) badge.classList.add('hidden');
            if (container) container.innerHTML = '';

            const isNoActiveContract = contractStatus.diagnostic_code === 'NO_ACTIVE_CONTRACT' || !contractStatus.has_active_contract;
            const activeContractList = contractStatus.active_contracts || [];
            const primaryContract = activeContractList[0] || null;

            // 1. Update Step 2 inline Notice
            if (routeNotice) {
                routeNotice.classList.remove('hidden');
                routeNotice.className = 'mt-3 p-3 rounded-xl border text-xs flex items-center justify-between gap-3 transition-all bg-amber-50 dark:bg-amber-950/40 border-amber-200 dark:border-amber-800 text-amber-900 dark:text-amber-200';
                if (routeNoticeIconWrapper) routeNoticeIconWrapper.className = 'w-7 h-7 rounded-lg flex items-center justify-center text-sm shrink-0 bg-amber-100 text-amber-700 dark:bg-amber-900/60 dark:text-amber-300';
                if (routeNoticeIcon) routeNoticeIcon.setAttribute('icon', 'solar:danger-triangle-bold');
                if (routeNoticeTitle) routeNoticeTitle.innerText = isNoActiveContract ? 'Belum Ada Kontrak Induk Logistik' : 'Tarif Rute Belum Terdaftar';
                if (routeNoticeText) routeNoticeText.innerText = isNoActiveContract
                    ? 'Perusahaan Anda belum memiliki Kontrak Induk aktif. Armada belum dapat dipesan.'
                    : `Rute ke ${destCityName} belum memiliki tarif resmi pada Kontrak #${primaryContract?.reference_number || 'Induk'}.`;
                if (routeNoticeBadge) {
                    routeNoticeBadge.className = 'text-[10px] font-bold px-2.5 py-1 rounded-full shrink-0 bg-amber-200 text-amber-900 dark:bg-amber-800 dark:text-amber-100';
                    routeNoticeBadge.innerText = isNoActiveContract ? 'Tanpa Kontrak' : 'Belum Ada Tarif';
                }
            }

            // 2. Render prominent Step 4 Alert Card
            if (alertBanner) {
                alertBanner.classList.remove('hidden');
                alertBanner.className = 'p-5 rounded-2xl border text-xs bg-amber-50/70 dark:bg-amber-950/30 border-amber-200 dark:border-amber-800/80 space-y-4';
                alertBanner.innerHTML = `
                    <div class="flex items-start gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl shrink-0 shadow-sm shadow-amber-500/20">
                            <iconify-icon icon="solar:danger-triangle-bold"></iconify-icon>
                        </span>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <h4 class="font-black text-sm text-amber-950 dark:text-amber-200">
                                    ${isNoActiveContract ? 'Belum Ada Kontrak Induk Kerjasama Logistik' : 'Tarif Kontrak Tidak Ditemukan untuk Rute Ini'}
                                </h4>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-200 text-amber-900 dark:bg-amber-900/60 dark:text-amber-200">
                                    ${isNoActiveContract ? 'Kontrak Tidak Ditemukan' : 'Perlu Addendum Rute'}
                                </span>
                            </div>
                            <p class="text-xs text-amber-800 dark:text-amber-300 mt-1">
                                ${isNoActiveContract 
                                    ? 'Perusahaan Anda belum memiliki Kontrak Induk aktif dengan Mitra Transporter logistik. Seluruh pemesanan armada memerlukan Kontrak resmi yang mengikat.'
                                    : `Kontrak Induk Anda <strong>#${primaryContract?.reference_number || 'CTR-AKTIF'}</strong> (${primaryContract?.logistic_name || 'Mitra Logistik'}) sudah aktif, namun belum mendaftarkan tarif resmi untuk rute <strong>${originName} (${originCity}) &rarr; ${destCityName} (${destCity})</strong>.`}
                            </p>
                        </div>
                    </div>

                    <div class="p-3.5 bg-white dark:bg-slate-900 rounded-xl border border-amber-200/80 dark:border-slate-700 space-y-2">
                        <div class="font-bold text-[11px] text-slate-800 dark:text-slate-200 uppercase tracking-wider">Detail Rute & Kontrak:</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-slate-600 dark:text-slate-300">
                            <div><strong>Titik Asal:</strong> ${originName} (Kode: ${originCity})</div>
                            <div><strong>Titik Tujuan:</strong> ${destCityName} (Kode: ${destCity})</div>
                            <div class="sm:col-span-2"><strong>Status Kontrak:</strong> ${isNoActiveContract ? '<span class="text-rose-600 font-bold">Tidak Ada Kontrak Aktif</span>' : `<span class="text-blue-600 font-bold font-mono">#${primaryContract?.reference_number}</span> - ${primaryContract?.logistic_name}`}</div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                        <div class="text-[11px] text-amber-900 dark:text-amber-300 font-medium">
                            💡 <strong>Solusi:</strong> Ubah rute tujuan pengiriman atau salin format permohonan addendum untuk menghubungi mitra logistik.
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" onclick="goToStep(2)" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold text-xs shadow-sm transition-all flex items-center gap-1.5">
                                <iconify-icon icon="solar:alt-arrow-left-linear" class="text-base"></iconify-icon>
                                <span>Ganti Kota Tujuan (Tahap 2)</span>
                            </button>
                            <button type="button" onclick="goToStep(1)" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl font-bold text-xs transition-all">
                                <span>Ganti Gudang Asal</span>
                            </button>
                            <button type="button" onclick="copyRouteAddendumRequest()" class="px-3.5 py-2 bg-amber-100 hover:bg-amber-200 dark:bg-amber-900/50 dark:hover:bg-amber-800 text-amber-900 dark:text-amber-200 rounded-xl font-bold text-xs transition-all flex items-center gap-1.5">
                                <iconify-icon icon="solar:copy-bold" class="text-sm"></iconify-icon>
                                <span>Salin Teks Addendum</span>
                            </button>
                        </div>
                    </div>
                `;
            }

            updatePricingDisplay(0, 0, 0, 0);

            // 3. If triggered interactively (showAlert = true), notify via SweetAlert
            if (showAlert && window.Swal) {
                Swal.fire({
                    icon: 'warning',
                    title: isNoActiveContract ? 'Belum Ada Kontrak Induk' : 'Tarif Rute Belum Terdaftar',
                    html: `
                        <div class="text-left text-xs space-y-3">
                            <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                                ${isNoActiveContract 
                                    ? 'Perusahaan Anda belum memiliki Kontrak Induk Kerjasama aktif dengan Mitra Logistik manapun.' 
                                    : `Kontrak Induk <strong>#${primaryContract?.reference_number || 'Aktif'}</strong> belum memiliki daftar tarif kontrak untuk rute:`}
                            </p>
                            <div class="p-3 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 font-mono text-[11px] space-y-1">
                                <div><strong>Asal:</strong> ${originName} (${originCity})</div>
                                <div><strong>Tujuan:</strong> ${destCityName} (${destCity})</div>
                                ${primaryContract ? `<div><strong>Mitra:</strong> ${primaryContract.logistic_name}</div>` : ''}
                            </div>
                            <p class="text-slate-500 text-[11px]">
                                Anda dapat mengganti kota tujuan dengan rute yang sudah memiliki kontrak aktif, atau mengajukan penambahan addendum tarif ke tim operasional.
                            </p>
                        </div>
                    `,
                    confirmButtonText: 'Tinjau Rincian di Tahap 4',
                    confirmButtonColor: '#2563eb',
                    showCancelButton: true,
                    cancelButtonText: 'Ubah Rute Tujuan',
                    cancelButtonColor: '#64748b'
                }).then(result => {
                    if (result.dismiss === Swal.DismissReason.cancel) {
                        goToStep(2);
                    }
                });
            }

            return false;
        }

        // CASE B: Contract & Route Pricing Found!
        if (alertBanner) alertBanner.classList.add('hidden');

        const carrier = carriers[0];
        roState.logistic_id = carrier.logistic_id;
        roState.logistic_name = carrier.logistic_name;
        roState.contract_id = carrier.contract_id;
        roState.contract_number = carrier.contract_number;

        const fleets = carrier.available_fleet_types || [];
        roState.available_fleets = fleets;

        const hiddenLogInput = document.getElementById('selectedLogisticId');
        const hiddenCtrInput = document.getElementById('selectedContractId');
        if (hiddenLogInput) hiddenLogInput.value = carrier.logistic_id;
        if (hiddenCtrInput) hiddenCtrInput.value = carrier.contract_id;

        // Update Step 2 inline Notice (Green Success)
        if (routeNotice) {
            routeNotice.classList.remove('hidden');
            routeNotice.className = 'mt-3 p-3 rounded-xl border text-xs flex items-center justify-between gap-3 transition-all bg-emerald-50 dark:bg-emerald-950/40 border-emerald-200 dark:border-emerald-800 text-emerald-900 dark:text-emerald-200';
            if (routeNoticeIconWrapper) routeNoticeIconWrapper.className = 'w-7 h-7 rounded-lg flex items-center justify-center text-sm shrink-0 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300';
            if (routeNoticeIcon) routeNoticeIcon.setAttribute('icon', 'solar:check-circle-bold');
            if (routeNoticeTitle) routeNoticeTitle.innerText = `Tarif Kontrak Aktif: ${carrier.logistic_name}`;
            if (routeNoticeText) routeNoticeText.innerText = `Rute tercakup pada Kontrak Induk #${carrier.contract_number}. Tersedia ${fleets.length} pilihan armada truk.`;
            if (routeNoticeBadge) {
                routeNoticeBadge.className = 'text-[10px] font-bold px-2.5 py-1 rounded-full shrink-0 bg-emerald-200 text-emerald-900 dark:bg-emerald-800 dark:text-emerald-100';
                routeNoticeBadge.innerText = 'Tarif Tersedia';
            }
        }

        if (carrierBadge) {
            carrierBadge.classList.remove('hidden');
            const cNameEl = document.getElementById('contractedCarrierName');
            const cNumEl = document.getElementById('contractedRefNumber');
            if (cNameEl) cNameEl.innerText = carrier.logistic_name;
            if (cNumEl) cNumEl.innerText = carrier.contract_number;
        }

        renderFleetCards(fleets);

        // Auto select best fitting fleet from contract
        autoRecommendFleet(roState.total_weight);
        return true;
    } catch (err) {
        console.error('Fetch carrier contracts error:', err);
        if (container) {
            container.innerHTML = `
                <div class="col-span-full py-6 text-center text-rose-500 text-xs">
                    Gagal mengambil data kontrak armada: ${err.response?.data?.message || err.message}
                </div>
            `;
        }
        return false;
    }
};

// Render Fleet Cards dynamically from contracted rates
function renderFleetCards(fleets) {
    const container = document.getElementById('fleetSelectionContainer');
    if (!container) return;

    if (!fleets || fleets.length === 0) {
        container.innerHTML = `
            <div class="col-span-full py-6 text-center text-slate-400 text-xs">
                Tidak ada model armada dalam kontrak untuk rute ini.
            </div>
        `;
        return;
    }

    container.innerHTML = fleets.map(f => {
        const isSelected = roState.fleet_type_id == f.fleet_type_id;
        const subtotalRate = f.rates?.subtotal_base_price || f.rates?.linehaul_price || 0;
        const capacityTon = (f.capacity_kg / 1000).toFixed(1);
        const isOverweight = roState.total_weight > f.capacity_kg;

        return `
            <div class="fleet-card cursor-pointer p-4 rounded-2xl ${isSelected ? 'border-2 border-blue-600 bg-blue-50/40 dark:bg-blue-950/40 shadow-md' : 'border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:border-blue-400'} relative flex flex-col justify-between transition-all" 
                 data-fleet-id="${f.fleet_type_id}" 
                 data-capacity="${f.capacity_kg}" 
                 onclick="selectFleet(${f.fleet_type_id})">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="p-2 rounded-xl ${isSelected ? 'bg-blue-100 dark:bg-blue-900/60 text-blue-600 dark:text-blue-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400'}">
                            <iconify-icon icon="solar:delivery-bold" class="text-xl"></iconify-icon>
                        </span>
                        <div class="flex items-center gap-1">
                            ${isOverweight ? '<span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-300">Over Capacity</span>' : ''}
                            <span class="fleet-badge px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-600 text-white ${isSelected ? '' : 'hidden'}">Dipilih</span>
                        </div>
                    </div>
                    <h4 class="font-black text-sm text-slate-900 dark:text-white">${f.fleet_type_name}</h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 font-mono">${f.service_code || 'Direct Route'}</p>
                    
                    <div class="mt-3 space-y-1 text-[11px] text-slate-600 dark:text-slate-300">
                        <div class="flex justify-between">
                            <span>Kapasitas Tonase:</span>
                            <span class="font-bold">${Number(f.capacity_kg).toLocaleString('id-ID')} kg (${capacityTon} Ton)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Volume Muatan:</span>
                            <span class="font-bold">${f.capacity_cbm || 0} CBM</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700">
                    <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Tarif Kontrak:</span>
                    <div class="text-sm font-black ${isSelected ? 'text-blue-600 dark:text-blue-400' : 'text-slate-900 dark:text-white'} fleet-rate-display">
                        Rp ${Number(subtotalRate).toLocaleString('id-ID')}
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

// Auto recommend fleet type strictly from available contracted fleets
function autoRecommendFleet(weightKg) {
    if (!roState.available_fleets || roState.available_fleets.length === 0) return;

    // Sort fleets by capacity ascending
    const sorted = [...roState.available_fleets].sort((a, b) => a.capacity_kg - b.capacity_kg);
    
    // Find smallest fleet that can carry weightKg
    let suitable = sorted.find(f => f.capacity_kg >= weightKg);
    if (!suitable) {
        // If weight exceeds all, pick largest
        suitable = sorted[sorted.length - 1];
    }

    const badge = document.getElementById('fleetRecommendedBadge');
    const badgeText = document.getElementById('recommendedFleetText');

    if (badge && badgeText && suitable) {
        badge.classList.remove('hidden');
        badgeText.innerText = `Rekomendasi Kontrak: ${suitable.fleet_type_name}`;
    }

    // Auto-select if nothing selected yet or current fleet is overweight
    const currentFleet = roState.available_fleets.find(f => f.fleet_type_id == roState.fleet_type_id);
    if (!currentFleet || (currentFleet.capacity_kg < weightKg && suitable.capacity_kg >= weightKg)) {
        selectFleet(suitable.fleet_type_id);
    } else if (currentFleet) {
        calculateDynamicTariff();
    }
}

// Select Fleet Type (Rate of Truck Direct)
window.selectFleet = function(fleetId) {
    const f = roState.available_fleets.find(item => item.fleet_type_id == fleetId);
    if (!f) return;

    roState.fleet_type_id = fleetId;
    roState.fleet_name = f.fleet_type_name;

    const hiddenFleetInput = document.getElementById('selectedFleetTypeId');
    if (hiddenFleetInput) hiddenFleetInput.value = fleetId;

    const badgeText = document.getElementById('selectedFleetBadgeText');
    if (badgeText) badgeText.innerText = `Armada: ${f.fleet_type_name}`;

    // Highlight card
    document.querySelectorAll('.fleet-card').forEach(card => {
        const id = card.getAttribute('data-fleet-id');
        const badge = card.querySelector('.fleet-badge');
        if (id == fleetId) {
            card.className = 'fleet-card cursor-pointer p-4 rounded-2xl border-2 border-blue-600 bg-blue-50/40 dark:bg-blue-950/40 relative flex flex-col justify-between transition-all shadow-md';
            if (badge) badge.classList.remove('hidden');
        } else {
            card.className = 'fleet-card cursor-pointer p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 relative flex flex-col justify-between transition-all hover:border-blue-400';
            if (badge) badge.classList.add('hidden');
        }
    });

    calculateDynamicTariff();
};

// Calculate Dynamic Truck Rate
window.calculateDynamicTariff = async function() {
    const currentFleet = roState.available_fleets.find(f => f.fleet_type_id == roState.fleet_type_id);
    let baseRate = currentFleet?.rates?.linehaul_price || 0;
    let shunting = currentFleet?.rates?.shunting_price || 0;

    const originCity = roState.origin_city_code || '31.71';
    const destCity = roState.destination_city_code;

    if (roState.logistic_id && roState.fleet_type_id && originCity && destCity) {
        try {
            const res = await axios.post('/api/request-orders/calculate-pricing', {
                logistic_id: roState.logistic_id,
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
            console.warn('Pricing API using contract table rates:', err);
        }
    }

    const insurance = Math.round(baseRate * 0.0015);
    const total = baseRate + shunting + insurance;

    roState.pricing = {
        base_rate: baseRate,
        shunting: shunting,
        insurance: insurance,
        total: total
    };

    updatePricingDisplay(baseRate, shunting, insurance, total);
};

function updatePricingDisplay(baseRate, shunting, insurance, total) {
    const baseEl = document.getElementById('rateBaseDisplay');
    const shuntingEl = document.getElementById('rateShuntingDisplay');
    const insuranceEl = document.getElementById('rateInsuranceDisplay');
    const totalEl = document.getElementById('rateTotalDisplay');

    if (baseEl) baseEl.innerText = `Rp ${Number(baseRate).toLocaleString('id-ID')}`;
    if (shuntingEl) shuntingEl.innerText = `Rp ${Number(shunting).toLocaleString('id-ID')}`;
    if (insuranceEl) insuranceEl.innerText = `Rp ${Number(insurance).toLocaleString('id-ID')}`;
    if (totalEl) totalEl.innerText = `Rp ${Number(total).toLocaleString('id-ID')}`;
}

// Wizard Step Navigation
window.goToStep = async function(step) {
    if (step < 1 || step > totalSteps) return;

    if (step > currentStep) {
        if (!validateStep(currentStep)) return;
    }

    // When entering Step 4, ensure carrier and fleet options are refreshed
    if (step === 4) {
        if (!roState.available_fleets || roState.available_fleets.length === 0) {
            await fetchCarrierAndFleetOptions(true);
            // Allow the corporate user to view Step 4 with the clear contract alert banner rather than locking them out
        }
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
    const draftBtn = document.getElementById('draftBtn');

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

    if (draftBtn) {
        if (step === totalSteps) draftBtn.classList.remove('hidden');
        else draftBtn.classList.add('hidden');
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
            calculateCargoTotals();
        }
        if (!roState.items || roState.items.length === 0 || roState.total_qty <= 0) {
            if (window.availableProducts && window.availableProducts.length > 0) {
                addProductToCargo(window.availableProducts[0], 10);
            } else {
                window.Alert ? window.Alert.toast('Silakan pilih minimal 1 produk kargo SKU.', 'error') : Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Muatan produk belum ditambahkan.' });
                return false;
            }
        }
    } else if (step === 4) {
        if (!roState.fleet_type_id || !roState.available_fleets || roState.available_fleets.length === 0) {
            if (!roState.available_fleets || roState.available_fleets.length === 0) {
                if (window.Swal) {
                    const originName = roState.origin_name || 'Gudang Utama Korporasi';
                    const destCityName = document.getElementById('display-destinationCity')?.value || roState.destination_city_name || 'Kota Tujuan';
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tarif Kontrak Tidak Tersedia',
                        html: `
                            <div class="text-left text-xs space-y-2">
                                <p class="text-slate-700 dark:text-slate-300">Pemesanan belum dapat dilanjutkan ke tahap konfirmasi karena tidak ada tarif kontrak aktif untuk rute ini:</p>
                                <div class="p-3 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 font-mono text-[11px] space-y-1">
                                    <div><strong>Asal:</strong> ${originName}</div>
                                    <div><strong>Tujuan:</strong> ${destCityName}</div>
                                </div>
                                <p class="text-slate-500 dark:text-slate-400">Silakan ubah kota tujuan pengiriman Anda pada Tahap 2, atau salin rincian addendum rute untuk diajukan ke mitra logistik.</p>
                            </div>
                        `,
                        confirmButtonText: 'Ganti Kota Tujuan (Tahap 2)',
                        confirmButtonColor: '#2563eb',
                        showCancelButton: true,
                        cancelButtonText: 'Tutup',
                        cancelButtonColor: '#64748b'
                    }).then(res => {
                        if (res.isConfirmed) goToStep(2);
                    });
                } else {
                    alert('Pemesanan tidak dapat dilanjutkan: Tarif kontrak belum tersedia untuk rute ini.');
                }
            } else {
                window.Alert ? window.Alert.toast('Silakan pilih salah satu model armada truk yang tersedia dalam kontrak.', 'error') : Swal.fire({ icon: 'warning', title: 'Pilih Armada Truk', text: 'Silakan pilih model armada truk terlebih dahulu sebelum melanjutkan.' });
            }
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
    const fleetText = roState.fleet_name || 'Armada Truk Terpilih';
    const weightText = `${roState.total_weight.toLocaleString('id-ID')} kg (${(roState.total_weight / 1000).toFixed(2)} ton) • ${roState.total_qty} Unit`;
    const costText = `Rp ${Number(roState.pricing.total).toLocaleString('id-ID')}`;

    const revCustomer = document.getElementById('reviewCustomer');
    const revOrigin = document.getElementById('reviewOrigin');
    const revDest = document.getElementById('reviewDestinations');
    const revDep = document.getElementById('reviewDeparture');
    const revContract = document.getElementById('reviewContract');
    const revLogistic = document.getElementById('reviewLogistic');
    const revFleet = document.getElementById('reviewFleet');
    const revWeight = document.getElementById('reviewWeight');
    const revCost = document.getElementById('reviewTotalCost');

    if (revCustomer) {
        if (roState.customer_name) {
            const typeStr = roState.customer_type === 'distributor' ? 'Mitra Distribusi' : 'Pelanggan B2B';
            revCustomer.innerText = `${roState.customer_name} (${roState.customer_code || 'B2B'}) [${typeStr}]`;
        } else {
            revCustomer.innerText = 'Penerima Manual (Non-Pelanggan)';
        }
    }
    if (revOrigin) revOrigin.innerText = originText;
    if (revDest) revDest.innerText = destText;
    if (revDep) revDep.innerText = roState.departure_date ? roState.departure_date.replace('T', ' ') : '-';
    if (revContract) revContract.innerText = roState.contract_number ? `${roState.contract_number} (Aktif)` : '-';
    if (revLogistic) revLogistic.innerText = roState.logistic_name || '-';
    if (revFleet) revFleet.innerText = fleetText;
    if (revWeight) revWeight.innerText = weightText;
    if (revCost) revCost.innerText = costText;
}

// Submit Request Order
window.submitRequestOrder = async function(targetStatus = 'submitted') {
    const submitBtn = document.getElementById('submitBtn');
    const draftBtn = document.getElementById('draftBtn');
    if (submitBtn) submitBtn.disabled = true;
    if (draftBtn) draftBtn.disabled = true;

    if (targetStatus === 'draft' && draftBtn) {
        draftBtn.innerHTML = '<iconify-icon icon="solar:spinner-line" class="animate-spin text-base"></iconify-icon><span>Menyimpan Draft...</span>';
    } else if (submitBtn) {
        submitBtn.innerHTML = '<iconify-icon icon="solar:spinner-line" class="animate-spin text-base"></iconify-icon><span>Mengajukan RO...</span>';
    }

    const payload = {
        status: targetStatus,
        customer_id: roState.customer_id || null,
        distributor_id: roState.distributor_id || null,
        order_date: roState.order_date,
        departure_date: roState.departure_date || new Date().toISOString().slice(0, 16),
        origin_warehouse_id: roState.origin_warehouse_id || 1,
        origin_city_code: roState.origin_city_code || '31.71',
        destination_city_code: roState.destination_city_code || '32.73',
        fleet_type_id: roState.fleet_type_id,
        cargo_type_id: 1,
        total_weight: roState.total_weight || 0,
        total_weight_kg: roState.total_weight || 0,
        total_volume: roState.total_volume || 0,
        total_volume_cbm: roState.total_volume || 0,
        logistic_id: roState.logistic_id || 1,
        contract_id: roState.contract_id || 1,
        shipper_name: roState.shipper_pic || 'PIC Gudang',
        shipper_phone: roState.shipper_phone || '08123456789',
        notes: roState.shipper_notes || '',
        po_number: document.getElementById('poReference')?.value || '',
        delivery_points: [
            {
                customer_id: roState.customer_id || null,
                distributor_id: roState.distributor_id || null,
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
        const isDraft = targetStatus === 'draft';
        Swal.fire({
            icon: 'success',
            title: isDraft ? 'Draft Disimpan!' : 'Request Order Diajukan!',
            text: isDraft 
                ? 'Order pemesanan armada berhasil disimpan sebagai draft dan dapat diedit kembali kapan saja sebelum diajukan.'
                : 'Order pemesanan armada truk berhasil diajukan dan diteruskan ke sistem mitra logistik.',
            confirmButtonColor: '#053363'
        }).then(() => {
            window.location.href = '/request-orders';
        });
    } catch (err) {
        console.error('Submit Request Order error:', err);
        const errMsg = err.response?.data?.message || 'Gagal memproses Request Order. Silakan periksa kembali data Anda.';
        Swal.fire({
            icon: 'error',
            title: targetStatus === 'draft' ? 'Gagal Menyimpan Draft' : 'Gagal Mengajukan RO',
            text: errMsg,
            confirmButtonColor: '#053363'
        });
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon><span>Konfirmasi &amp; Ajukan RO</span>';
        }
        if (draftBtn) {
            draftBtn.disabled = false;
            draftBtn.innerHTML = '<iconify-icon icon="solar:diskette-bold" class="text-base text-slate-500"></iconify-icon><span>Simpan sebagai Draft</span>';
        }
    }
};
