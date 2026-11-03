<x-layout.app title="Kategori Produk | Corporate Merchant Portal">
    <div class="space-y-6">

        <!-- Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="/products" class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors">&larr; Katalog Produk</a>
                </div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Kategori Produk Korporasi
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Pengelompokan jenis komoditas, bahan baku, dan barang jadi
                </p>
            </div>
            <button type="button" onclick="openCategoryModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2 self-start sm:self-auto">
                <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                <span>+ Tambah Kategori</span>
            </button>
        </div>

        <!-- Table Card -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">Kode Kategori</th>
                            <th class="py-3.5">Nama Kategori</th>
                            <th class="py-3.5">Deskripsi</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat kategori produk...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Form Kategori -->
    <div id="categoryModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;" onclick="closeCategoryModal()">
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full h-full max-w-full flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <h3 id="catModalTitle" class="text-lg font-bold text-slate-900 dark:text-white">Tambah Kategori Baru</h3>
                <button type="button" onclick="closeCategoryModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>

            <form id="categoryForm" onsubmit="saveCategory(event)" class="flex flex-col flex-1 overflow-hidden text-xs">
                <div class="p-6 md:p-8 overflow-y-auto flex-1">
                    <input type="hidden" id="catId" />
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kode Kategori *</label>
                            <input type="text" id="catCode" required placeholder="CAT-SEMBAKO" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama Kategori *</label>
                            <input type="text" id="catName" required placeholder="Sembako & Pangan Pokok" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Status Kategori *</label>
                            <select id="catStatus" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl">
                                <option value="1">Aktif</option>
                                <option value="0">Inaktif</option>
                            </select>
                        </div>
                        <div class="col-span-full">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Deskripsi</label>
                            <textarea id="catDesc" rows="4" placeholder="Keterangan kategori produk..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 py-3.5 px-6 border-t border-slate-100 dark:border-slate-700 shrink-0 bg-slate-50/50 dark:bg-slate-800/50">
                    <button type="button" onclick="closeCategoryModal()" class="px-5 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-bold bg-blue-600 hover:bg-blue-500 shadow-md transition-all">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        async function fetchCategories() {
            const tbody = document.getElementById('categoriesTableBody');
            try {
                const res = await axios.get('/api/product-categories');
                const raw = res.data?.data;
                const data = Array.isArray(raw) ? raw : (raw?.data || []);

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Belum ada kategori terdaftar.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map((c, idx) => {
                    const isActive = (c.is_active == 1 || c.is_active === true || String(c.is_active).toLowerCase() === 'true' || String(c.status).toLowerCase() === 'active');
                    const badgeClass = isActive ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300';
                    const badgeLabel = isActive ? 'Aktif' : 'Inaktif';

                    return `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                        <td class="py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">${c.code || '-'}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${c.name}</td>
                        <td class="py-3.5 text-slate-500">${c.description || '-'}</td>
                        <td class="py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${badgeClass}">${badgeLabel}</span>
                        </td>
                        <td class="py-3.5 pr-6 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <button onclick='editCategory(${JSON.stringify(c)})' class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all">
                                    <iconify-icon icon="solar:pen-new-square-linear" class="text-base"></iconify-icon>
                                </button>
                                <button onclick="deleteCategory(${c.id})" class="p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 transition-all">
                                    <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    `;
                }).join('');
            } catch (err) {
                console.error('Fetch categories error:', err);
                tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Gagal memuat kategori.</td></tr>`;
            }
        }

        function openCategoryModal() {
            document.getElementById('catModalTitle').innerText = 'Tambah Kategori Baru';
            document.getElementById('categoryForm').reset();
            document.getElementById('catId').value = '';
            document.getElementById('catStatus').value = '1';
            document.getElementById('categoryModal').style.display = 'flex';
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').style.display = 'none';
            document.querySelectorAll('.hs-overlay-backdrop').forEach(b => b.remove());
        }

        function editCategory(c) {
            document.getElementById('catModalTitle').innerText = 'Edit Kategori';
            document.getElementById('catId').value = c.id;
            document.getElementById('catCode').value = c.code || '';
            document.getElementById('catName').value = c.name || '';
            document.getElementById('catDesc').value = c.description || '';
            const isActive = (c.is_active == 1 || c.is_active === true || String(c.is_active).toLowerCase() === 'true' || String(c.status).toLowerCase() === 'active');
            document.getElementById('catStatus').value = isActive ? '1' : '0';
            document.getElementById('categoryModal').style.display = 'flex';
        }

        async function saveCategory(e) {
            e.preventDefault();
            const id = document.getElementById('catId').value;
            const isAct = document.getElementById('catStatus').value === '1';
            const payload = {
                code: document.getElementById('catCode').value,
                name: document.getElementById('catName').value,
                description: document.getElementById('catDesc').value,
                is_active: isAct,
                status: isAct ? 'Active' : 'Inactive',
            };

            try {
                if (id) {
                    await axios.put(`/api/product-categories/${id}`, payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Kategori berhasil diperbarui.', timer: 1500, showConfirmButton: false });
                } else {
                    await axios.post('/api/product-categories', payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Kategori baru berhasil disimpan.', timer: 1500, showConfirmButton: false });
                }
                closeCategoryModal();
                fetchCategories();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menyimpan kategori: ' + (err.response?.data?.message || err.message) });
            }
        }

        async function deleteCategory(id) {
            const res = await Swal.fire({
                title: 'Hapus Kategori?',
                text: 'Yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7a89',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            });
            if (!res.isConfirmed) return;
            try {
                await axios.delete(`/api/product-categories/${id}`);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Kategori berhasil dihapus.', timer: 1500, showConfirmButton: false });
                fetchCategories();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menghapus kategori: ' + (err.response?.data?.message || err.message) });
            }
        }

        document.addEventListener('DOMContentLoaded', fetchCategories);
    </script>
    @endpush
</x-layout.app>
