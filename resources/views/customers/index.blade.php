<x-layout.app title="Pelanggan & Mitra Distribusi | Corporate Merchant Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Pelanggan &amp; Mitra Distribusi
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Direktori pembeli grosir, jaringan retail, konsumen korporasi, dan mitra distribusi
                </p>
            </div>
            <button type="button" onclick="openCustomerModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2 self-start sm:self-auto">
                <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                <span>+ Tambah Data</span>
            </button>
        </div>

        <!-- Filter tabs -->
        <div class="flex items-center gap-2">
            <button type="button" onclick="setFilterType('')" id="btnFilterAll" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all bg-blue-600 text-white shadow-sm">
                Semua Data
            </button>
            <button type="button" onclick="setFilterType('customer')" id="btnFilterCust" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200">
                Pelanggan B2B
            </button>
            <button type="button" onclick="setFilterType('distributor')" id="btnFilterDist" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200">
                Mitra Distribusi (Distributor)
            </button>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">Kode</th>
                            <th class="py-3.5">Tipe</th>
                            <th class="py-3.5">Nama Perusahaan / Toko</th>
                            <th class="py-3.5">Kota / Wilayah</th>
                            <th class="py-3.5">Kontak &amp; Telepon</th>
                            <th class="py-3.5">Alamat Pengiriman</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="customersTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat data pelanggan &amp; distributor...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Form Pelanggan / Distributor -->
    <div id="customerModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;" onclick="closeCustomerModal()">
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full h-full max-w-full flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <h3 id="custModalTitle" class="text-lg font-bold text-slate-900 dark:text-white">Tambah Pelanggan / Distributor Baru</h3>
                <button type="button" onclick="closeCustomerModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>

            <form id="customerForm" onsubmit="saveCustomer(event)" class="flex flex-col flex-1 overflow-hidden text-xs">
                <div class="p-6 md:p-8 overflow-y-auto flex-1">
                    <input type="hidden" id="custId" />
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Tipe Entitas *</label>
                            <select id="custType" required class="w-full px-3 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold">
                                <option value="customer">Pelanggan (Customer B2B)</option>
                                <option value="distributor">Mitra Distribusi (Distributor Partner)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kode *</label>
                            <input type="text" id="custCode" required placeholder="CUST-B2B-01 / DIST-01" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama Perusahaan / Toko / Distributor *</label>
                            <input type="text" id="custName" required placeholder="PT Sumber Berkah Makmur / CV Iwan Distributor" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Telepon / WhatsApp *</label>
                            <input type="text" id="custPhone" required placeholder="081298765432" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Email</label>
                            <input type="email" id="custEmail" placeholder="procurement@sumberberkah.com" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div class="lg:col-span-2">
                            <x-modal-picker 
                                id="custCityPicker" 
                                name="city_code" 
                                label="Kota / Kabupaten Pengiriman" 
                                url="/api/wilayah/kota" 
                                placeholder="Pilih Kota / Kabupaten Pengiriman..." 
                            />
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Status Entitas *</label>
                            <select id="custStatus" class="w-full px-3 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold">
                                <option value="1">Aktif</option>
                                <option value="0">Inaktif</option>
                            </select>
                        </div>
                        <div class="lg:col-span-4">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Alamat Penerima / Drop *</label>
                            <textarea id="custAddress" required rows="2" placeholder="Jl. Raya Daan Mogot KM 12, Jakarta Barat..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 py-3.5 px-6 border-t border-slate-100 dark:border-slate-700 shrink-0 bg-slate-50/50 dark:bg-slate-800/50">
                    <button type="button" onclick="closeCustomerModal()" class="px-5 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-bold bg-blue-600 hover:bg-blue-500 shadow-md transition-all">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentTypeFilter = '';

        function setFilterType(type) {
            currentTypeFilter = type;
            const btnAll = document.getElementById('btnFilterAll');
            const btnCust = document.getElementById('btnFilterCust');
            const btnDist = document.getElementById('btnFilterDist');

            const activeCls = ['bg-blue-600', 'text-white', 'shadow-sm'];
            const inactiveCls = ['bg-slate-100', 'dark:bg-slate-800', 'text-slate-600', 'dark:text-slate-300', 'hover:bg-slate-200'];

            [btnAll, btnCust, btnDist].forEach(b => {
                b.classList.remove(...activeCls);
                b.classList.add(...inactiveCls);
            });

            if (type === 'customer') {
                btnCust.classList.remove(...inactiveCls);
                btnCust.classList.add(...activeCls);
            } else if (type === 'distributor') {
                btnDist.classList.remove(...inactiveCls);
                btnDist.classList.add(...activeCls);
            } else {
                btnAll.classList.remove(...inactiveCls);
                btnAll.classList.add(...activeCls);
            }

            fetchCustomers();
        }

        async function fetchCustomers() {
            const tbody = document.getElementById('customersTableBody');
            try {
                let url = '/api/customers?per_page=100';
                if (currentTypeFilter) {
                    url += `&type=${currentTypeFilter}`;
                }
                const res = await axios.get(url);
                const raw = res.data?.data;
                const data = Array.isArray(raw) ? raw : (raw?.data || []);

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="9" class="py-12 text-center text-slate-400">Belum ada data pelanggan / distributor terdaftar.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map((c, idx) => {
                    const isActive = (c.is_active == 1 || c.is_active === true || String(c.is_active).toLowerCase() === 'true' || String(c.status).toLowerCase() === 'active');
                    const badgeClass = isActive ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300';
                    const badgeLabel = isActive ? 'Aktif' : 'Inaktif';
                    const cityLabel = c.city_name || c.city_code || '';

                    const isDist = (c.type === 'distributor');
                    const typeBadge = isDist 
                        ? '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 dark:bg-purple-950/40 dark:text-purple-400 border border-purple-200 dark:border-purple-800"><iconify-icon icon="solar:shop-2-bold"></iconify-icon>Mitra Distribusi</span>'
                        : '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-400 border border-blue-200 dark:border-blue-800"><iconify-icon icon="solar:users-group-two-rounded-bold"></iconify-icon>Pelanggan B2B</span>';

                    return `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                        <td class="py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">${c.code || '-'}</td>
                        <td class="py-3.5">${typeBadge}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${c.name}</td>
                        <td class="py-3.5 font-semibold text-slate-700 dark:text-slate-200">
                            ${cityLabel ? `<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300"><iconify-icon icon="solar:map-point-bold"></iconify-icon>${cityLabel}</span>` : '<span class="text-slate-400 italic">Belum Diatur</span>'}
                        </td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-300">${c.phone || '-'} <br><span class="text-[10px] text-slate-400">${c.email || ''}</span></td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-400">${c.address || '-'}</td>
                        <td class="py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${badgeClass}">${badgeLabel}</span>
                        </td>
                        <td class="py-3.5 pr-6 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <button onclick='editCustomer(${JSON.stringify(c)})' class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all" title="Edit">
                                    <iconify-icon icon="solar:pen-new-square-linear" class="text-base"></iconify-icon>
                                </button>
                                <button onclick="deleteCustomer(${c.id})" class="p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 transition-all" title="Hapus">
                                    <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    `;
                }).join('');
            } catch (err) {
                console.error('Fetch customers error:', err);
                tbody.innerHTML = `<tr><td colspan="9" class="py-12 text-center text-slate-400">Gagal memuat data pelanggan.</td></tr>`;
            }
        }

        function openCustomerModal() {
            document.getElementById('custModalTitle').innerText = 'Tambah Pelanggan / Distributor Baru';
            document.getElementById('customerForm').reset();
            document.getElementById('custId').value = '';
            document.getElementById('custType').value = 'customer';
            document.getElementById('custStatus').value = '1';
            if (window.setPickerValue) {
                window.setPickerValue('custCityPicker', '', '');
            } else {
                const h = document.getElementById('hidden-custCityPicker');
                const d = document.getElementById('display-custCityPicker');
                if (h) h.value = '';
                if (d) d.value = '';
            }
            document.getElementById('customerModal').style.display = 'flex';
        }

        function closeCustomerModal() {
            document.getElementById('customerModal').style.display = 'none';
            document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
        }

        function editCustomer(c) {
            document.getElementById('custModalTitle').innerText = c.type === 'distributor' ? 'Edit Distributor' : 'Edit Pelanggan';
            document.getElementById('custId').value = c.id;
            document.getElementById('custType').value = c.type || 'customer';
            document.getElementById('custCode').value = c.code || '';
            document.getElementById('custName').value = c.name || '';
            document.getElementById('custPhone').value = c.phone || '';
            document.getElementById('custEmail').value = c.email || '';
            document.getElementById('custAddress').value = c.address || '';
            const isActive = (c.is_active == 1 || c.is_active === true || String(c.is_active).toLowerCase() === 'true' || String(c.status).toLowerCase() === 'active');
            document.getElementById('custStatus').value = isActive ? '1' : '0';
            const cityCode = c.city_code || '';
            const cityName = c.city_name || c.city_code || '';
            if (window.setPickerValue) {
                window.setPickerValue('custCityPicker', cityCode, cityName, { id: cityCode, name: cityName });
            } else {
                const h = document.getElementById('hidden-custCityPicker');
                const d = document.getElementById('display-custCityPicker');
                if (h) h.value = cityCode;
                if (d) d.value = cityName;
            }
            document.getElementById('customerModal').style.display = 'flex';
        }

        async function saveCustomer(e) {
            e.preventDefault();
            const id = document.getElementById('custId').value;
            const isAct = document.getElementById('custStatus').value === '1';
            const hiddenCity = document.getElementById('hidden-custCityPicker');
            const cityCodeVal = hiddenCity ? hiddenCity.value : '';

            const payload = {
                type: document.getElementById('custType').value,
                code: document.getElementById('custCode').value,
                name: document.getElementById('custName').value,
                phone: document.getElementById('custPhone').value,
                email: document.getElementById('custEmail').value,
                address: document.getElementById('custAddress').value,
                city_code: cityCodeVal,
                is_active: isAct,
                status: isAct ? 'Active' : 'Inactive',
            };

            try {
                if (id) {
                    await axios.put(`/api/customers/${id}`, payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Data berhasil diperbarui.', timer: 1500, showConfirmButton: false });
                } else {
                    await axios.post('/api/customers', payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Data baru berhasil disimpan.', timer: 1500, showConfirmButton: false });
                }
                closeCustomerModal();
                fetchCustomers();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menyimpan: ' + (err.response?.data?.message || err.message) });
            }
        }

        async function deleteCustomer(id) {
            const res = await Swal.fire({
                title: 'Hapus Data?',
                text: 'Yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7a89',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            });
            if (!res.isConfirmed) return;
            try {
                await axios.delete(`/api/customers/${id}`);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Data berhasil dihapus.', timer: 1500, showConfirmButton: false });
                fetchCustomers();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menghapus data: ' + (err.response?.data?.message || err.message) });
            }
        }

        document.addEventListener('DOMContentLoaded', () => fetchCustomers());
    </script>
    @endpush
</x-layout.app>
