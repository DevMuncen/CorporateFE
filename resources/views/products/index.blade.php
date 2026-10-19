<x-layout.app title="Katalog Produk SKU | Corporate Merchant Portal">
    <div class="space-y-6">

        <!-- Top Header & Action Controls -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Katalog Produk SKU
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Kelola data master barang, dimensi, berat, dan harga dasar korporasi
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="/product-categories" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all flex items-center gap-1.5 shadow-xs">
                    <iconify-icon icon="solar:folder-with-files-bold-duotone" class="text-base text-blue-600"></iconify-icon>
                    <span>Kategori Produk</span>
                </a>
                <button type="button" onclick="openProductModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2">
                    <iconify-icon icon="solar:add-circle-bold" class="text-base"></iconify-icon>
                    <span>+ Tambah Produk</span>
                </button>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 shadow-xs">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="relative sm:col-span-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <iconify-icon icon="solar:magnifer-linear" class="text-base"></iconify-icon>
                    </span>
                    <input type="text" id="searchInput" oninput="debounceSearch()" placeholder="Cari nama produk, SKU, barcode..."
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                </div>
                <div>
                    <select id="categoryFilter" onchange="fetchProducts()" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="">Semua Kategori</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Product Table Card -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6">SKU / Kode</th>
                            <th class="py-3.5">Nama Produk</th>
                            <th class="py-3.5">Kategori</th>
                            <th class="py-3.5 text-right">Harga Dasar</th>
                            <th class="py-3.5 text-right">Berat (kg)</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat katalog produk...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between text-xs text-slate-500">
                <span id="paginationInfo">Menampilkan data</span>
                <div class="flex items-center gap-1.5" id="paginationControls"></div>
            </div>
        </div>

    </div>

    <!-- Modal Form Tambah / Edit Produk -->
    <div id="productModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700 relative">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-700 mb-4">
                <h3 id="modalTitle" class="text-base font-black text-slate-900 dark:text-white">Tambah Produk Baru</h3>
                <button type="button" onclick="closeProductModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                </button>
            </div>

            <form id="productForm" onsubmit="saveProduct(event)" class="space-y-4 text-xs">
                <input type="hidden" id="prodId" />
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kode SKU *</label>
                        <input type="text" id="prodSku" required placeholder="SKU-BRG-001" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kategori *</label>
                        <select id="prodCategory" required class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl">
                            <option value="">Pilih Kategori</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama Produk *</label>
                    <input type="text" id="prodName" required placeholder="Contoh: Beras Premium 5kg" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Harga Dasar (Rp) *</label>
                        <input type="number" id="prodPrice" required min="0" placeholder="75000" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Berat Satuan (kg) *</label>
                        <input type="number" step="0.01" id="prodWeight" required min="0" placeholder="5.0" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">P (cm)</label>
                        <input type="number" id="prodLength" min="0" placeholder="30" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">L (cm)</label>
                        <input type="number" id="prodWidth" min="0" placeholder="20" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">T (cm)</label>
                        <input type="number" id="prodHeight" min="0" placeholder="10" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" onclick="closeProductModal()" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-white font-bold bg-blue-600 hover:bg-blue-500 shadow-md transition-all">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let searchTimer = null;
        function debounceSearch() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(fetchProducts, 350);
        }

        async function fetchProducts(page = 1) {
            const search = document.getElementById('searchInput').value;
            const category = document.getElementById('categoryFilter').value;
            const tbody = document.getElementById('productsTableBody');

            try {
                const res = await axios.get('/api/products', {
                    params: { page, search, category_id: category }
                });
                const data = res.data?.data?.data || res.data?.data || [];

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Tidak ada produk ditemukan.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map(p => `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-mono font-bold text-blue-600 dark:text-blue-400">${p.sku || '-'}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${p.name}</td>
                        <td class="py-3.5 text-slate-500">${p.category?.name || 'Umum'}</td>
                        <td class="py-3.5 text-right font-semibold text-slate-800 dark:text-slate-200">Rp ${(p.base_price || p.price || 0).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 text-right text-slate-600 dark:text-slate-300">${p.weight || 0} kg</td>
                        <td class="py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${p.is_active !== false ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-red-50 text-red-700'}">
                                ${p.is_active !== false ? 'Aktif' : 'Nonaktif'}
                            </span>
                        </td>
                        <td class="py-3.5 pr-6 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <button onclick='editProduct(${JSON.stringify(p)})' class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-slate-700 transition-all">
                                    <iconify-icon icon="solar:pen-new-square-linear" class="text-base"></iconify-icon>
                                </button>
                                <button onclick="deleteProduct(${p.id})" class="p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-slate-700 transition-all">
                                    <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                `).join('');
            } catch (err) {
                console.error('Fetch products error:', err);
                tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Gagal memuat produk.</td></tr>`;
            }
        }

        function openProductModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Produk Baru';
            document.getElementById('productForm').reset();
            document.getElementById('prodId').value = '';
            document.getElementById('productModal').classList.remove('hidden');
        }

        function closeProductModal() {
            document.getElementById('productModal').classList.add('hidden');
        }

        function editProduct(p) {
            document.getElementById('modalTitle').innerText = 'Edit Produk SKU';
            document.getElementById('prodId').value = p.id;
            document.getElementById('prodSku').value = p.sku || '';
            document.getElementById('prodName').value = p.name || '';
            document.getElementById('prodCategory').value = p.category_id || '';
            document.getElementById('prodPrice').value = p.base_price || p.price || 0;
            document.getElementById('prodWeight').value = p.weight || 0;
            document.getElementById('prodLength').value = p.length || '';
            document.getElementById('prodWidth').value = p.width || '';
            document.getElementById('prodHeight').value = p.height || '';
            document.getElementById('productModal').classList.remove('hidden');
        }

        async function saveProduct(e) {
            e.preventDefault();
            const id = document.getElementById('prodId').value;
            const payload = {
                sku: document.getElementById('prodSku').value,
                name: document.getElementById('prodName').value,
                category_id: document.getElementById('prodCategory').value,
                base_price: parseFloat(document.getElementById('prodPrice').value),
                weight: parseFloat(document.getElementById('prodWeight').value),
                length: parseFloat(document.getElementById('prodLength').value || 0),
                width: parseFloat(document.getElementById('prodWidth').value || 0),
                height: parseFloat(document.getElementById('prodHeight').value || 0),
            };

            try {
                if (id) {
                    await axios.put(`/api/products/${id}`, payload);
                    alert('Produk berhasil diperbarui.');
                } else {
                    await axios.post('/api/products', payload);
                    alert('Produk baru berhasil disimpan.');
                }
                closeProductModal();
                fetchProducts();
            } catch (err) {
                alert('Gagal menyimpan produk: ' + (err.response?.data?.message || err.message));
            }
        }

        async function deleteProduct(id) {
            if (!confirm('Yakin ingin menghapus produk ini?')) return;
            try {
                await axios.delete(`/api/products/${id}`);
                alert('Produk berhasil dihapus.');
                fetchProducts();
            } catch (err) {
                alert('Gagal menghapus produk: ' + (err.response?.data?.message || err.message));
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchProducts();
        });
    </script>
    @endpush
</x-layout.app>
