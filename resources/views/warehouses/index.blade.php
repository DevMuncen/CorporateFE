<x-layout.app title="Hub & Gudang Korporasi | Corporate Merchant Portal">
    <div class="space-y-6">

        <!-- Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Hub &amp; Gudang Korporasi
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Titik origin pemuatan armada, depo satelit, dan pusat konsolidasi kargo
                </p>
            </div>
            <button type="button" onclick="openWarehouseModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2 self-start sm:self-auto">
                <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                <span>+ Tambah Gudang</span>
            </button>
        </div>

        <!-- Warehouses Table Card -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">Kode Gudang</th>
                            <th class="py-3.5">Nama Gudang / Hub</th>
                            <th class="py-3.5">Kota / Lokasi</th>
                            <th class="py-3.5">Kontak PIC</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="warehousesTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat data gudang...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Form Gudang -->
    <div id="warehouseModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;">
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full h-full max-w-full flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <h3 id="whModalTitle" class="text-lg font-bold text-slate-900 dark:text-white">Tambah Gudang Baru</h3>
                <button type="button" onclick="closeWarehouseModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>

            <form id="warehouseForm" onsubmit="saveWarehouse(event)" class="flex flex-col flex-1 overflow-hidden text-xs">
                <div class="p-6 md:p-8 overflow-y-auto flex-1">
                    <input type="hidden" id="whId" />
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block font-bold text-slate-600 dark:text-slate-300">Kode Gudang *</label>
                                <button type="button" onclick="suggestWarehouseCode()" class="text-[11px] text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1 font-semibold cursor-pointer">
                                    <iconify-icon icon="solar:magic-stick-3-linear"></iconify-icon> Saran Kode
                                </button>
                            </div>
                            <input type="text" id="whCode" required placeholder="GW-CMP-001" onblur="checkWarehouseCodeUniqueness()" oninput="debounceCheckWarehouseCode()" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl font-mono" />
                            <div id="whCodeFeedback" class="text-xs mt-1 hidden"></div>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama Gudang *</label>
                            <input type="text" id="whName" required placeholder="Gudang Utama Cikarang" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div>
                            <x-modal-picker 
                                id="whCityPicker" 
                                name="city" 
                                label="Kota / Kabupaten" 
                                url="/api/wilayah/kota" 
                                placeholder="Pilih Kota / Kabupaten..." 
                                :required="true" 
                            />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kode Pos</label>
                            <input type="text" id="whPostal" placeholder="17530" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama PIC *</label>
                            <input type="text" id="whPic" required placeholder="Bpk. Herman" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Telepon PIC *</label>
                            <input type="text" id="whPhone" required placeholder="081234567890" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Status Operasional *</label>
                            <select id="whStatus" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl">
                                <option value="1">Aktif</option>
                                <option value="0">Inaktif</option>
                            </select>
                        </div>
                        <div class="col-span-full">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Alamat Lengkap *</label>
                            <textarea id="whAddress" required rows="2" placeholder="Kawasan Industri Jababeka Blok C..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 py-3.5 px-6 border-t border-slate-100 dark:border-slate-700 shrink-0 bg-slate-50/50 dark:bg-slate-800/50">
                    <button type="button" onclick="closeWarehouseModal()" class="px-5 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-bold bg-blue-600 hover:bg-blue-500 shadow-md transition-all">
                        Simpan Gudang
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        async function fetchWarehouses() {
            const tbody = document.getElementById('warehousesTableBody');
            try {
                const res = await axios.get('/api/warehouses?per_page=100');
                const raw = res.data?.data;
                const data = Array.isArray(raw) ? raw : (raw?.data || []);

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Belum ada gudang terdaftar.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map((w, idx) => {
                    const isActive = (w.is_active == 1 || w.is_active === true || String(w.is_active).toLowerCase() === 'true' || String(w.status).toLowerCase() === 'active');
                    const badgeClass = isActive ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300';
                    const badgeLabel = isActive ? 'Aktif' : 'Inaktif';

                    return `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                        <td class="py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">${w.code || '-'}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${w.name}</td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-400">${w.city || '-'}, ${w.address || ''}</td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-300">${w.pic_name || '-'} (${w.phone || '-'})</td>
                        <td class="py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${badgeClass}">${badgeLabel}</span>
                        </td>
                        <td class="py-3.5 pr-6 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <button onclick='editWarehouse(${JSON.stringify(w)})' class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all">
                                    <iconify-icon icon="solar:pen-new-square-linear" class="text-base"></iconify-icon>
                                </button>
                                <button onclick="deleteWarehouse(${w.id})" class="p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 transition-all">
                                    <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    `;
                }).join('');
            } catch (err) {
                console.error('Fetch warehouses error:', err);
                tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Gagal memuat gudang.</td></tr>`;
            }
        }

        let whDebounceTimer = null;
        function debounceCheckWarehouseCode() {
            clearTimeout(whDebounceTimer);
            whDebounceTimer = setTimeout(() => {
                checkWarehouseCodeUniqueness();
            }, 300);
        }

        async function suggestWarehouseCode() {
            try {
                const res = await axios.get('/api/internal/corporate/code/suggest?type=warehouse');
                const suggested = res.data?.data?.suggested_code;
                if (suggested) {
                    const input = document.getElementById('whCode');
                    if (input) {
                        input.value = suggested;
                        checkWarehouseCodeUniqueness();
                    }
                }
            } catch (err) {
                console.error('Suggest warehouse code error:', err);
            }
        }

        async function checkWarehouseCodeUniqueness() {
            const input = document.getElementById('whCode');
            const code = input?.value?.trim();
            const id = document.getElementById('whId')?.value;
            const feedback = document.getElementById('whCodeFeedback');

            if (!code) {
                if (feedback) {
                    feedback.className = 'text-xs mt-1 hidden';
                    feedback.innerText = '';
                }
                input?.classList.remove('border-red-500', 'border-emerald-500');
                return true;
            }

            try {
                const res = await axios.get(`/api/internal/corporate/code/check?type=warehouse&code=${encodeURIComponent(code)}&exclude_id=${id || ''}`);
                const isUnique = res.data?.data?.is_unique ?? res.data?.is_unique;

                if (isUnique === false) {
                    if (feedback) {
                        feedback.className = 'text-xs mt-1 text-red-500 block font-medium';
                        feedback.innerText = 'Kode gudang sudah digunakan untuk korporasi ini.';
                    }
                    input?.classList.add('border-red-500');
                    input?.classList.remove('border-emerald-500');
                    return false;
                } else {
                    if (feedback) {
                        feedback.className = 'text-xs mt-1 text-emerald-600 dark:text-emerald-400 block font-medium';
                        feedback.innerText = '✓ Kode gudang tersedia';
                    }
                    input?.classList.remove('border-red-500');
                    input?.classList.add('border-emerald-500');
                    return true;
                }
            } catch (err) {
                console.error('Check warehouse code error:', err);
                return true;
            }
        }

        function openWarehouseModal() {
            document.getElementById('whModalTitle').innerText = 'Tambah Gudang Baru';
            document.getElementById('warehouseForm').reset();
            document.getElementById('whId').value = '';
            document.getElementById('whStatus').value = '1';
            const feedback = document.getElementById('whCodeFeedback');
            if (feedback) {
                feedback.className = 'text-xs mt-1 hidden';
                feedback.innerText = '';
            }
            document.getElementById('whCode')?.classList.remove('border-red-500', 'border-emerald-500');
            if (window.setPickerValue) {
                window.setPickerValue('whCityPicker', '', '');
            } else {
                const h = document.getElementById('hidden-whCityPicker');
                const d = document.getElementById('display-whCityPicker');
                if (h) h.value = '';
                if (d) d.value = '';
            }
            const modal = document.getElementById('warehouseModal');
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
        }

        function closeWarehouseModal() {
            const modal = document.getElementById('warehouseModal');
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }

        function editWarehouse(w) {
            document.getElementById('whModalTitle').innerText = 'Edit Gudang';
            document.getElementById('whId').value = w.id;
            document.getElementById('whCode').value = w.code || '';
            document.getElementById('whName').value = w.name || '';
            const cityName = w.city || '';
            if (window.setPickerValue) {
                window.setPickerValue('whCityPicker', cityName, cityName);
            } else {
                const h = document.getElementById('hidden-whCityPicker');
                const d = document.getElementById('display-whCityPicker');
                if (h) h.value = cityName;
                if (d) d.value = cityName;
            }
            document.getElementById('whPic').value = w.pic_name || '';
            document.getElementById('whPhone').value = w.phone || '';
            document.getElementById('whPostal').value = w.postal_code || '';
            document.getElementById('whAddress').value = w.address || '';
            const isActive = (w.is_active == 1 || w.is_active === true || String(w.is_active).toLowerCase() === 'true' || String(w.status).toLowerCase() === 'active');
            document.getElementById('whStatus').value = isActive ? '1' : '0';
            const modal = document.getElementById('warehouseModal');
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
        }

        async function saveWarehouse(e) {
            e.preventDefault();
            const id = document.getElementById('whId').value;
            const codeVal = document.getElementById('whCode').value.trim();
            if (!codeVal) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Kode gudang harus diisi.' });
                document.getElementById('whCode')?.focus();
                return;
            }

            const isUnique = await checkWarehouseCodeUniqueness();
            if (!isUnique) {
                Swal.fire({ icon: 'warning', title: 'Kode Duplikat', text: 'Kode gudang ini sudah digunakan di korporasi Anda. Harap gunakan kode lain.' });
                document.getElementById('whCode')?.focus();
                return;
            }

            const isAct = document.getElementById('whStatus').value === '1';
            const cityVal = document.getElementById('hidden-whCityPicker')?.value || document.getElementById('display-whCityPicker')?.value || '';
            if (!cityVal) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan pilih Kota / Kabupaten' });
                return;
            }
            const payload = {
                code: document.getElementById('whCode').value,
                name: document.getElementById('whName').value,
                city: cityVal,
                pic_name: document.getElementById('whPic').value,
                phone: document.getElementById('whPhone').value,
                postal_code: document.getElementById('whPostal').value,
                address: document.getElementById('whAddress').value,
                is_active: isAct,
                status: isAct ? 'Active' : 'Inactive',
            };

            try {
                if (id) {
                    await axios.put(`/api/warehouses/${id}`, payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Gudang berhasil diperbarui.', timer: 1500, showConfirmButton: false });
                } else {
                    await axios.post('/api/warehouses', payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Gudang baru berhasil disimpan.', timer: 1500, showConfirmButton: false });
                }
                closeWarehouseModal();
                fetchWarehouses();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menyimpan gudang: ' + (err.response?.data?.message || err.message) });
            }
        }

        async function deleteWarehouse(id) {
            const res = await Swal.fire({
                title: 'Hapus Gudang?',
                text: 'Yakin ingin menghapus gudang ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7a89',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            });
            if (!res.isConfirmed) return;
            try {
                await axios.delete(`/api/warehouses/${id}`);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Gudang berhasil dihapus.', timer: 1500, showConfirmButton: false });
                fetchWarehouses();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menghapus gudang: ' + (err.response?.data?.message || err.message) });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchWarehouses();
        });
    </script>
    @endpush
</x-layout.app>
