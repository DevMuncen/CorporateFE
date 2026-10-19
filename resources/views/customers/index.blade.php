<x-layout.app title="Pelanggan & Mitra B2B | Corporate Merchant Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Pelanggan &amp; Mitra B2B
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Direktori pembeli grosir, jaringan retail, dan konsumen korporasi
                </p>
            </div>
            <button type="button" onclick="openCustomerModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2 self-start sm:self-auto">
                <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                <span>+ Tambah Pelanggan</span>
            </button>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6">Kode</th>
                            <th class="py-3.5">Nama Pelanggan</th>
                            <th class="py-3.5">Kontak &amp; Telepon</th>
                            <th class="py-3.5">Alamat Pengiriman</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="customersTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat data pelanggan...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Form Pelanggan -->
    <div id="customerModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700 relative">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-700 mb-4">
                <h3 id="custModalTitle" class="text-base font-black text-slate-900 dark:text-white">Tambah Pelanggan Baru</h3>
                <button type="button" onclick="closeCustomerModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                </button>
            </div>

            <form id="customerForm" onsubmit="saveCustomer(event)" class="space-y-4 text-xs">
                <input type="hidden" id="custId" />
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kode Pelanggan *</label>
                        <input type="text" id="custCode" required placeholder="CUST-B2B-01" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama Perusahaan / Toko *</label>
                        <input type="text" id="custName" required placeholder="PT Sumber Berkah Makmur" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Telepon / WhatsApp *</label>
                        <input type="text" id="custPhone" required placeholder="081298765432" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Email</label>
                        <input type="email" id="custEmail" placeholder="procurement@sumberberkah.com" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Alamat Penerima / Drop *</label>
                    <textarea id="custAddress" required rows="3" placeholder="Jl. Raya Daan Mogot KM 12, Jakarta Barat..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" onclick="closeCustomerModal()" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-white font-bold bg-blue-600 hover:bg-blue-500 shadow-md transition-all">
                        Simpan Pelanggan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        async function fetchCustomers() {
            const tbody = document.getElementById('customersTableBody');
            try {
                const res = await axios.get('/api/customers');
                const data = res.data?.data || [];

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Belum ada pelanggan terdaftar.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map(c => `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-mono font-bold text-blue-600 dark:text-blue-400">${c.code || '-'}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${c.name}</td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-300">${c.phone || '-'} <br><span class="text-[10px] text-slate-400">${c.email || ''}</span></td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-400">${c.address || '-'}</td>
                        <td class="py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">Aktif</span>
                        </td>
                        <td class="py-3.5 pr-6 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <button onclick='editCustomer(${JSON.stringify(c)})' class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all">
                                    <iconify-icon icon="solar:pen-new-square-linear" class="text-base"></iconify-icon>
                                </button>
                                <button onclick="deleteCustomer(${c.id})" class="p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 transition-all">
                                    <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                `).join('');
            } catch (err) {
                console.error('Fetch customers error:', err);
                tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Gagal memuat pelanggan.</td></tr>`;
            }
        }

        function openCustomerModal() {
            document.getElementById('custModalTitle').innerText = 'Tambah Pelanggan Baru';
            document.getElementById('customerForm').reset();
            document.getElementById('custId').value = '';
            document.getElementById('customerModal').classList.remove('hidden');
        }

        function closeCustomerModal() {
            document.getElementById('customerModal').classList.add('hidden');
        }

        function editCustomer(c) {
            document.getElementById('custModalTitle').innerText = 'Edit Pelanggan';
            document.getElementById('custId').value = c.id;
            document.getElementById('custCode').value = c.code || '';
            document.getElementById('custName').value = c.name || '';
            document.getElementById('custPhone').value = c.phone || '';
            document.getElementById('custEmail').value = c.email || '';
            document.getElementById('custAddress').value = c.address || '';
            document.getElementById('customerModal').classList.remove('hidden');
        }

        async function saveCustomer(e) {
            e.preventDefault();
            const id = document.getElementById('custId').value;
            const payload = {
                code: document.getElementById('custCode').value,
                name: document.getElementById('custName').value,
                phone: document.getElementById('custPhone').value,
                email: document.getElementById('custEmail').value,
                address: document.getElementById('custAddress').value,
            };

            try {
                if (id) {
                    await axios.put(`/api/customers/${id}`, payload);
                } else {
                    await axios.post('/api/customers', payload);
                }
                closeCustomerModal();
                fetchCustomers();
            } catch (err) {
                alert('Gagal menyimpan pelanggan: ' + (err.response?.data?.message || err.message));
            }
        }

        async function deleteCustomer(id) {
            if (!confirm('Yakin ingin menghapus pelanggan ini?')) return;
            try {
                await axios.delete(`/api/customers/${id}`);
                fetchCustomers();
            } catch (err) {
                alert('Gagal menghapus pelanggan: ' + (err.response?.data?.message || err.message));
            }
        }

        document.addEventListener('DOMContentLoaded', fetchCustomers);
    </script>
    @endpush
</x-layout.app>
