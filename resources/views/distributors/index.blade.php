<x-layout.app title="Jaringan Distributor | Corporate Merchant Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Jaringan Distributor Mitra
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Mitra distribusi wilayah resmi untuk penyaluran produk korporasi
                </p>
            </div>
            <button type="button" onclick="openDistributorModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2 self-start sm:self-auto">
                <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                <span>+ Tambah Distributor</span>
            </button>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6">Kode</th>
                            <th class="py-3.5">Nama Distributor</th>
                            <th class="py-3.5">Wilayah Distribusi</th>
                            <th class="py-3.5">Kontak &amp; Telepon</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="distributorsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat data distributor...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Form Distributor -->
    <div id="distributorModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700 relative">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-700 mb-4">
                <h3 id="distModalTitle" class="text-base font-black text-slate-900 dark:text-white">Tambah Distributor Baru</h3>
                <button type="button" onclick="closeDistributorModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                </button>
            </div>

            <form id="distributorForm" onsubmit="saveDistributor(event)" class="space-y-4 text-xs">
                <input type="hidden" id="distId" />
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kode Distributor *</label>
                        <input type="text" id="distCode" required placeholder="DIST-JABODETABEK" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama Perusahaan *</label>
                        <input type="text" id="distName" required placeholder="CV Prima Niaga Distribusi" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Wilayah / Kota *</label>
                        <input type="text" id="distRegion" required placeholder="Jabodetabek / Bandung" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Telepon / WhatsApp *</label>
                        <input type="text" id="distPhone" required placeholder="081388776655" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Alamat Kantor / Depo Distribusi</label>
                    <textarea id="distAddress" rows="3" placeholder="Jl. Soekarno Hatta No. 88, Bandung..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" onclick="closeDistributorModal()" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-white font-bold bg-blue-600 hover:bg-blue-500 shadow-md transition-all">
                        Simpan Distributor
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
                const data = res.data?.data || [];

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Belum ada distributor terdaftar.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map(d => `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-mono font-bold text-blue-600 dark:text-blue-400">${d.code || '-'}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${d.name}</td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-300">${d.region || d.city || '-'}</td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-300">${d.phone || '-'}</td>
                        <td class="py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">Aktif</span>
                        </td>
                        <td class="py-3.5 pr-6 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <button onclick='editDistributor(${JSON.stringify(d)})' class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all">
                                    <iconify-icon icon="solar:pen-new-square-linear" class="text-base"></iconify-icon>
                                </button>
                                <button onclick="deleteDistributor(${d.id})" class="p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 transition-all">
                                    <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                `).join('');
            } catch (err) {
                console.error('Fetch distributors error:', err);
                tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Gagal memuat distributor.</td></tr>`;
            }
        }

        function openDistributorModal() {
            document.getElementById('distModalTitle').innerText = 'Tambah Distributor Baru';
            document.getElementById('distributorForm').reset();
            document.getElementById('distId').value = '';
            document.getElementById('distributorModal').classList.remove('hidden');
        }

        function closeDistributorModal() {
            document.getElementById('distributorModal').classList.add('hidden');
        }

        function editDistributor(d) {
            document.getElementById('distModalTitle').innerText = 'Edit Distributor';
            document.getElementById('distId').value = d.id;
            document.getElementById('distCode').value = d.code || '';
            document.getElementById('distName').value = d.name || '';
            document.getElementById('distRegion').value = d.region || d.city || '';
            document.getElementById('distPhone').value = d.phone || '';
            document.getElementById('distAddress').value = d.address || '';
            document.getElementById('distributorModal').classList.remove('hidden');
        }

        async function saveDistributor(e) {
            e.preventDefault();
            const id = document.getElementById('distId').value;
            const payload = {
                code: document.getElementById('distCode').value,
                name: document.getElementById('distName').value,
                region: document.getElementById('distRegion').value,
                phone: document.getElementById('distPhone').value,
                address: document.getElementById('distAddress').value,
            };

            try {
                if (id) {
                    await axios.put(`/api/distributors/${id}`, payload);
                } else {
                    await axios.post('/api/distributors', payload);
                }
                closeDistributorModal();
                fetchDistributors();
            } catch (err) {
                alert('Gagal menyimpan distributor: ' + (err.response?.data?.message || err.message));
            }
        }

        async function deleteDistributor(id) {
            if (!confirm('Yakin ingin menghapus distributor ini?')) return;
            try {
                await axios.delete(`/api/distributors/${id}`);
                fetchDistributors();
            } catch (err) {
                alert('Gagal menghapus distributor: ' + (err.response?.data?.message || err.message));
            }
        }

        document.addEventListener('DOMContentLoaded', fetchDistributors);
    </script>
    @endpush
</x-layout.app>
