<x-layout.app title="Vendor Logistik & Supplier | Corporate Merchant Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Vendor Logistik &amp; Pemasok
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Mitra penyedia jasa armada, transporter ekspedisi, dan pemasok bahan
                </p>
            </div>
            <button type="button" onclick="openVendorModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2 self-start sm:self-auto">
                <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                <span>+ Tambah Vendor</span>
            </button>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">Nama Vendor</th>
                            <th class="py-3.5">Kategori / Layanan</th>
                            <th class="py-3.5">Kontak &amp; Telepon</th>
                            <th class="py-3.5">Alamat Operasional</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="vendorsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat data vendor...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Form Vendor -->
    <div id="vendorModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;" onclick="closeVendorModal()">
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full h-full max-w-full flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <h3 id="vndModalTitle" class="text-lg font-bold text-slate-900 dark:text-white">Tambah Vendor Baru</h3>
                <button type="button" onclick="closeVendorModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>

            <form id="vendorForm" onsubmit="saveVendor(event)" class="flex flex-col flex-1 overflow-hidden text-xs">
                <div class="p-6 md:p-8 overflow-y-auto flex-1">
                    <input type="hidden" id="vndId" />
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block font-bold text-slate-600 dark:text-slate-300">Kode Vendor</label>
                                <button type="button" onclick="suggestVendorCode()" class="text-[11px] text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1 font-semibold cursor-pointer">
                                    <iconify-icon icon="solar:magic-stick-3-linear"></iconify-icon> Saran Kode
                                </button>
                            </div>
                            <input type="text" id="vndCode" placeholder="Otomatis jika dikosongkan" onblur="checkVendorCodeUniqueness()" oninput="debounceCheckVendorCode()" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl font-mono" />
                            <div id="vndCodeFeedback" class="text-xs mt-1 hidden"></div>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama Vendor / Carrier *</label>
                            <input type="text" id="vndName" required placeholder="PT Muncen Express Logistics" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kategori Layanan *</label>
                            <select id="vndType" required class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl">
                                <option value="logistic">Penyedia Armada Logistik (Transporter)</option>
                                <option value="supplier">Pemasok Bahan &amp; Komoditas</option>
                                <option value="3pl">3PL &amp; Pergudangan Transit</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Telepon / Hotline *</label>
                            <input type="text" id="vndPhone" required placeholder="021-88997766" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Email Operasional</label>
                            <input type="email" id="vndEmail" placeholder="dispatch@muncenlogistic.com" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Alamat Kantor / Pool Armada</label>
                            <textarea id="vndAddress" rows="2" placeholder="Jl. Raya Pelabuhan No. 45, Tanjung Priok..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl"></textarea>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Status Vendor *</label>
                            <select id="vndStatus" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl">
                                <option value="1">Aktif</option>
                                <option value="0">Inaktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 py-3.5 px-6 border-t border-slate-100 dark:border-slate-700 shrink-0 bg-slate-50/50 dark:bg-slate-800/50">
                    <button type="button" onclick="closeVendorModal()" class="px-5 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-bold bg-blue-600 hover:bg-blue-500 shadow-md transition-all">
                        Simpan Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        async function fetchVendors() {
            const tbody = document.getElementById('vendorsTableBody');
            try {
                const res = await axios.get('/api/vendors');
                const raw = res.data?.data;
                const data = Array.isArray(raw) ? raw : (raw?.data || []);

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Belum ada vendor terdaftar.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map((v, idx) => {
                    const isActive = (v.is_active == 1 || v.is_active === true || String(v.is_active).toLowerCase() === 'true' || String(v.status).toLowerCase() === 'active');
                    const badgeClass = isActive ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300';
                    const badgeLabel = isActive ? 'Aktif' : 'Inaktif';

                    return `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">
                            <div>${v.name}</div>
                            ${v.code ? `<div class="text-[10px] font-mono text-blue-600 dark:text-blue-400">${v.code}</div>` : ''}
                        </td>
                        <td class="py-3.5">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 uppercase tracking-wider">
                                ${v.type || 'Logistik'}
                            </span>
                        </td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-300">${v.phone || '-'} <br><span class="text-[10px] text-slate-400">${v.email || ''}</span></td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-400">${v.address || '-'}</td>
                        <td class="py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${badgeClass}">${badgeLabel}</span>
                        </td>
                        <td class="py-3.5 pr-6 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <button onclick='editVendor(${JSON.stringify(v)})' class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all">
                                    <iconify-icon icon="solar:pen-new-square-linear" class="text-base"></iconify-icon>
                                </button>
                                <button onclick="deleteVendor(${v.id})" class="p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 transition-all">
                                    <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    `;
                }).join('');
            } catch (err) {
                console.error('Fetch vendors error:', err);
                tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Gagal memuat vendor.</td></tr>`;
            }
        }

        let vndDebounceTimer = null;
        function debounceCheckVendorCode() {
            clearTimeout(vndDebounceTimer);
            vndDebounceTimer = setTimeout(() => {
                checkVendorCodeUniqueness();
            }, 300);
        }

        async function suggestVendorCode() {
            try {
                const res = await axios.get('/api/internal/corporate/code/suggest?type=vendor');
                const suggested = res.data?.data?.suggested_code;
                if (suggested) {
                    const input = document.getElementById('vndCode');
                    if (input) {
                        input.value = suggested;
                        checkVendorCodeUniqueness();
                    }
                }
            } catch (err) {
                console.error('Suggest vendor code error:', err);
            }
        }

        async function checkVendorCodeUniqueness() {
            const input = document.getElementById('vndCode');
            const code = input?.value?.trim();
            const id = document.getElementById('vndId')?.value;
            const feedback = document.getElementById('vndCodeFeedback');

            if (!code) {
                if (feedback) {
                    feedback.className = 'text-xs mt-1 hidden';
                    feedback.innerText = '';
                }
                input?.classList.remove('border-red-500', 'border-emerald-500');
                return true;
            }

            try {
                const res = await axios.get(`/api/internal/corporate/code/check?type=vendor&code=${encodeURIComponent(code)}&exclude_id=${id || ''}`);
                const isUnique = res.data?.data?.is_unique ?? res.data?.is_unique;

                if (isUnique === false) {
                    if (feedback) {
                        feedback.className = 'text-xs mt-1 text-red-500 block font-medium';
                        feedback.innerText = 'Kode vendor sudah digunakan untuk korporasi ini.';
                    }
                    input?.classList.add('border-red-500');
                    input?.classList.remove('border-emerald-500');
                    return false;
                } else {
                    if (feedback) {
                        feedback.className = 'text-xs mt-1 text-emerald-600 dark:text-emerald-400 block font-medium';
                        feedback.innerText = '✓ Kode vendor tersedia';
                    }
                    input?.classList.remove('border-red-500');
                    input?.classList.add('border-emerald-500');
                    return true;
                }
            } catch (err) {
                console.error('Check vendor code error:', err);
                return true;
            }
        }

        function openVendorModal() {
            document.getElementById('vndModalTitle').innerText = 'Tambah Vendor Baru';
            document.getElementById('vendorForm').reset();
            document.getElementById('vndId').value = '';
            document.getElementById('vndCode').value = '';
            document.getElementById('vndStatus').value = '1';
            const feedback = document.getElementById('vndCodeFeedback');
            if (feedback) {
                feedback.className = 'text-xs mt-1 hidden';
                feedback.innerText = '';
            }
            document.getElementById('vndCode')?.classList.remove('border-red-500', 'border-emerald-500');
            document.getElementById('vendorModal').style.display = 'flex';
        }

        function closeVendorModal() {
            document.getElementById('vendorModal').style.display = 'none';
            document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
        }

        function editVendor(v) {
            document.getElementById('vndModalTitle').innerText = 'Edit Vendor';
            document.getElementById('vndId').value = v.id;
            document.getElementById('vndCode').value = v.code || '';
            document.getElementById('vndName').value = v.name || '';
            document.getElementById('vndType').value = v.type || 'logistic';
            document.getElementById('vndPhone').value = v.phone || '';
            document.getElementById('vndEmail').value = v.email || '';
            document.getElementById('vndAddress').value = v.address || '';
            const isActive = (v.is_active == 1 || v.is_active === true || String(v.is_active).toLowerCase() === 'true' || String(v.status).toLowerCase() === 'active');
            document.getElementById('vndStatus').value = isActive ? '1' : '0';
            document.getElementById('vendorModal').style.display = 'flex';
        }

        async function saveVendor(e) {
            e.preventDefault();
            const id = document.getElementById('vndId').value;
            const codeVal = (document.getElementById('vndCode').value || '').trim();
            if (codeVal) {
                const isUnique = await checkVendorCodeUniqueness();
                if (!isUnique) {
                    Swal.fire({ icon: 'warning', title: 'Kode Duplikat', text: 'Kode vendor ini sudah digunakan di korporasi Anda. Harap gunakan kode lain.' });
                    document.getElementById('vndCode')?.focus();
                    return;
                }
            }
            const isAct = document.getElementById('vndStatus').value === '1';
            const payload = {
                code: codeVal || null,
                name: document.getElementById('vndName').value,
                type: document.getElementById('vndType').value,
                phone: document.getElementById('vndPhone').value,
                email: document.getElementById('vndEmail').value,
                address: document.getElementById('vndAddress').value,
                is_active: isAct,
                status: isAct ? 'Active' : 'Inactive',
            };

            try {
                if (id) {
                    await axios.put(`/api/vendors/${id}`, payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Vendor berhasil diperbarui.', timer: 1500, showConfirmButton: false });
                } else {
                    await axios.post('/api/vendors', payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Vendor baru berhasil disimpan.', timer: 1500, showConfirmButton: false });
                }
                closeVendorModal();
                fetchVendors();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menyimpan vendor: ' + (err.response?.data?.message || err.message) });
            }
        }

        async function deleteVendor(id) {
            const res = await Swal.fire({
                title: 'Hapus Vendor?',
                text: 'Yakin ingin menghapus vendor ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7a89',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            });
            if (!res.isConfirmed) return;
            try {
                await axios.delete(`/api/vendors/${id}`);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Vendor berhasil dihapus.', timer: 1500, showConfirmButton: false });
                fetchVendors();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menghapus vendor: ' + (err.response?.data?.message || err.message) });
            }
        }

        document.addEventListener('DOMContentLoaded', fetchVendors);
    </script>
    @endpush
</x-layout.app>
