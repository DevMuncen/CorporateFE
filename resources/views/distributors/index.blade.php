<x-layout.app title="Mitra Distribusi (Distributor) | Corporate Merchant Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Mitra Distribusi (Distributor Partner)
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Data jaringan rekanan distribusi, agen utama, dan mitra logistik regional korporasi
                </p>
            </div>
            <button type="button" onclick="openDistributorModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2 self-start sm:self-auto">
                <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                <span>+ Tambah Mitra Distribusi</span>
            </button>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">Kode</th>
                            <th class="py-3.5">Nama Mitra Distribusi</th>
                            <th class="py-3.5">Wilayah / Kota</th>
                            <th class="py-3.5">Kontak &amp; Telepon</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="distributorsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat data mitra distribusi...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Form Mitra Distribusi -->
    <div id="distributorModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;" onclick="closeDistributorModal()">
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full h-full max-w-full flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <h3 id="distModalTitle" class="text-lg font-bold text-slate-900 dark:text-white">Tambah Mitra Distribusi Baru</h3>
                <button type="button" onclick="closeDistributorModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>

            <form id="distributorForm" onsubmit="saveDistributor(event)" class="flex flex-col flex-1 overflow-hidden text-xs">
                <div class="p-6 md:p-8 overflow-y-auto flex-1">
                    <input type="hidden" id="distId" />
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block font-bold text-slate-600 dark:text-slate-300">Kode Mitra Distribusi *</label>
                                <button type="button" onclick="suggestDistributorCode()" class="text-[11px] text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1 font-semibold cursor-pointer">
                                    <iconify-icon icon="solar:magic-stick-3-linear"></iconify-icon> Saran Kode
                                </button>
                            </div>
                            <input type="text" id="distCode" required placeholder="DST-CMP-001" onblur="checkDistributorCodeUniqueness()" oninput="debounceCheckDistributorCode()" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl font-mono" />
                            <div id="distCodeFeedback" class="text-xs mt-1 hidden"></div>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama Mitra / Distributor *</label>
                            <input type="text" id="distName" required placeholder="CV Prima Niaga Distribusi" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div>
                            <x-modal-picker 
                                id="distRegionPicker" 
                                name="region" 
                                label="Wilayah / Kota" 
                                url="/api/wilayah/kota" 
                                placeholder="Pilih Kota / Kabupaten..." 
                                :required="true" 
                            />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Telepon / WhatsApp *</label>
                            <input type="text" id="distPhone" required placeholder="081388776655" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div class="lg:col-span-3">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Alamat Kantor / Depo Distribusi</label>
                            <textarea id="distAddress" rows="2" placeholder="Jl. Soekarno Hatta No. 88, Bandung..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl"></textarea>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Status Mitra</label>
                            <select id="distStatus" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl">
                                <option value="1">Aktif</option>
                                <option value="0">Inaktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 py-3.5 px-6 border-t border-slate-100 dark:border-slate-700 shrink-0 bg-slate-50/50 dark:bg-slate-800/50">
                    <button type="button" onclick="closeDistributorModal()" class="px-5 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-bold bg-blue-600 hover:bg-blue-500 shadow-md transition-all">
                        Simpan Mitra Distribusi
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        async function fetchDistributors() {
            const tbody = document.getElementById('distributorsTableBody');
            try {
                const res = await axios.get('/api/distributors');
                const raw = res.data?.data;
                const data = Array.isArray(raw) ? raw : (raw?.data || []);

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Belum ada mitra distribusi terdaftar.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map((d, idx) => {
                    const isActive = (d.is_active == 1 || d.is_active === true || String(d.is_active).toLowerCase() === 'true' || (typeof d.status === 'string' && d.status.toLowerCase() === 'active'));
                    const statusBadge = isActive
                        ? `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Aktif</span>`
                        : `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300">Inaktif</span>`;

                    return `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                        <td class="py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">${d.code || '-'}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${d.name}</td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-300">${d.region || d.city || '-'}</td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-300">${d.phone || '-'}</td>
                        <td class="py-3.5 text-center">
                            ${statusBadge}
                        </td>
                        <td class="py-3.5 pr-6 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <button onclick='editDistributor(${JSON.stringify(d)})' class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all" title="Edit">
                                    <iconify-icon icon="solar:pen-new-square-linear" class="text-base"></iconify-icon>
                                </button>
                                <button onclick="deleteDistributor(${d.id})" class="p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 transition-all" title="Hapus">
                                    <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                }).join('');
            } catch (err) {
                console.error('Fetch distributors error:', err);
                tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Gagal memuat data mitra distribusi.</td></tr>`;
            }
        }

        let distDebounceTimer = null;
        function debounceCheckDistributorCode() {
            clearTimeout(distDebounceTimer);
            distDebounceTimer = setTimeout(() => {
                checkDistributorCodeUniqueness();
            }, 300);
        }

        async function suggestDistributorCode() {
            try {
                const res = await axios.get('/api/internal/corporate/code/suggest?type=distributor');
                const suggested = res.data?.data?.suggested_code;
                if (suggested) {
                    const input = document.getElementById('distCode');
                    if (input) {
                        input.value = suggested;
                        checkDistributorCodeUniqueness();
                    }
                }
            } catch (err) {
                console.error('Suggest distributor code error:', err);
            }
        }

        async function checkDistributorCodeUniqueness() {
            const input = document.getElementById('distCode');
            const code = input?.value?.trim();
            const id = document.getElementById('distId')?.value;
            const feedback = document.getElementById('distCodeFeedback');

            if (!code) {
                if (feedback) {
                    feedback.className = 'text-xs mt-1 hidden';
                    feedback.innerText = '';
                }
                input?.classList.remove('border-red-500', 'border-emerald-500');
                return true;
            }

            try {
                const res = await axios.get(`/api/internal/corporate/code/check?type=distributor&code=${encodeURIComponent(code)}&exclude_id=${id || ''}`);
                const isUnique = res.data?.data?.is_unique ?? res.data?.is_unique;

                if (isUnique === false) {
                    if (feedback) {
                        feedback.className = 'text-xs mt-1 text-red-500 block font-medium';
                        feedback.innerText = 'Kode mitra distribusi sudah digunakan untuk korporasi ini.';
                    }
                    input?.classList.add('border-red-500');
                    input?.classList.remove('border-emerald-500');
                    return false;
                } else {
                    if (feedback) {
                        feedback.className = 'text-xs mt-1 text-emerald-600 dark:text-emerald-400 block font-medium';
                        feedback.innerText = '✓ Kode mitra distribusi tersedia';
                    }
                    input?.classList.remove('border-red-500');
                    input?.classList.add('border-emerald-500');
                    return true;
                }
            } catch (err) {
                console.error('Check distributor code error:', err);
                return true;
            }
        }

        function openDistributorModal() {
            document.getElementById('distModalTitle').innerText = 'Tambah Mitra Distribusi Baru';
            document.getElementById('distributorForm').reset();
            document.getElementById('distId').value = '';
            document.getElementById('distStatus').value = '1';
            const feedback = document.getElementById('distCodeFeedback');
            if (feedback) {
                feedback.className = 'text-xs mt-1 hidden';
                feedback.innerText = '';
            }
            document.getElementById('distCode')?.classList.remove('border-red-500', 'border-emerald-500');
            if (window.setPickerValue) {
                window.setPickerValue('distRegionPicker', '', '');
            } else {
                const h = document.getElementById('hidden-distRegionPicker');
                const disp = document.getElementById('display-distRegionPicker');
                if (h) h.value = '';
                if (disp) disp.value = '';
            }
            document.getElementById('distributorModal').style.display = 'flex';
        }

        function closeDistributorModal() {
            document.getElementById('distributorModal').style.display = 'none';
            document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
        }

        function editDistributor(d) {
            document.getElementById('distModalTitle').innerText = 'Edit Mitra Distribusi';
            document.getElementById('distId').value = d.id;
            document.getElementById('distCode').value = d.code || '';
            document.getElementById('distName').value = d.name || '';
            const regionVal = d.region || d.city || '';
            if (window.setPickerValue) {
                window.setPickerValue('distRegionPicker', regionVal, regionVal);
            } else {
                const h = document.getElementById('hidden-distRegionPicker');
                const disp = document.getElementById('display-distRegionPicker');
                if (h) h.value = regionVal;
                if (disp) disp.value = regionVal;
            }
            document.getElementById('distPhone').value = d.phone || '';
            document.getElementById('distAddress').value = d.address || '';
            const isActive = (d.is_active == 1 || d.is_active === true || String(d.is_active).toLowerCase() === 'true' || (typeof d.status === 'string' && d.status.toLowerCase() === 'active'));
            document.getElementById('distStatus').value = isActive ? '1' : '0';
            document.getElementById('distributorModal').style.display = 'flex';
        }

        async function saveDistributor(e) {
            e.preventDefault();
            const id = document.getElementById('distId').value;
            const codeVal = document.getElementById('distCode').value.trim();
            if (!codeVal) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Kode mitra distribusi harus diisi.' });
                document.getElementById('distCode')?.focus();
                return;
            }

            const isUnique = await checkDistributorCodeUniqueness();
            if (!isUnique) {
                Swal.fire({ icon: 'warning', title: 'Kode Duplikat', text: 'Kode mitra distribusi ini sudah terdaftar di korporasi Anda. Harap gunakan kode lain.' });
                document.getElementById('distCode')?.focus();
                return;
            }

            const isAct = document.getElementById('distStatus').value === '1';
            const regionVal = document.getElementById('hidden-distRegionPicker')?.value || document.getElementById('display-distRegionPicker')?.value || '';
            if (!regionVal) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan pilih Wilayah / Kota' });
                return;
            }
            const payload = {
                code: document.getElementById('distCode').value,
                name: document.getElementById('distName').value,
                region: regionVal,
                city: regionVal,
                phone: document.getElementById('distPhone').value,
                address: document.getElementById('distAddress').value,
                is_active: isAct ? 1 : 0,
                status: isAct ? 'Active' : 'Inactive',
            };

            try {
                if (id) {
                    await axios.put(`/api/distributors/${id}`, payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Mitra distribusi berhasil diperbarui.', timer: 1500, showConfirmButton: false });
                } else {
                    await axios.post('/api/distributors', payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Mitra distribusi baru berhasil disimpan.', timer: 1500, showConfirmButton: false });
                }
                closeDistributorModal();
                fetchDistributors();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menyimpan mitra distribusi: ' + (err.response?.data?.message || err.message) });
            }
        }

        async function deleteDistributor(id) {
            const res = await Swal.fire({
                title: 'Hapus Mitra Distribusi?',
                text: 'Yakin ingin menghapus mitra distribusi ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7a89',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            });
            if (!res.isConfirmed) return;
            try {
                await axios.delete(`/api/distributors/${id}`);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Mitra distribusi berhasil dihapus.', timer: 1500, showConfirmButton: false });
                fetchDistributors();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menghapus mitra distribusi: ' + (err.response?.data?.message || err.message) });
            }
        }

        document.addEventListener('DOMContentLoaded', fetchDistributors);
    </script>
    @endpush
</x-layout.app>
