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
                        class="w-full !pl-10 !ps-10 pr-4 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" />
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
                            <th class="py-3.5 pl-6 w-12">No</th>
                            <th class="py-3.5">SKU / Kode</th>
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
                            <td colspan="8" class="py-12 text-center text-slate-400">
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
    <div id="productModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;">
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full h-full max-w-full flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <h3 id="modalTitle" class="text-lg font-bold text-slate-900 dark:text-white">Tambah Produk Baru</h3>
                <button type="button" onclick="closeProductModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>

            <form id="productForm" onsubmit="saveProduct(event)" class="flex flex-col flex-1 overflow-hidden text-xs">
                <div class="p-6 md:p-8 overflow-y-auto flex-1 space-y-4">
                    <input type="hidden" id="prodId" />
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kode SKU *</label>
                            <input type="text" id="prodSku" required placeholder="SKU-BRG-001" onblur="checkSkuUniqueness()" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                            <div id="prodSkuFeedback" class="text-xs mt-1 hidden"></div>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kategori (Opsional)</label>
                            <select id="prodCategory" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl">
                                <option value="">-- Tanpa Kategori / Umum --</option>
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama Produk *</label>
                            <input type="text" id="prodName" required placeholder="Contoh: Beras Premium 5kg" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Harga Dasar (Rp) *</label>
                            <input type="number" id="prodPrice" required min="0" placeholder="75000" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Berat Satuan (kg) *</label>
                            <input type="number" step="0.01" id="prodWeight" required min="0" placeholder="5.0" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Status Produk *</label>
                            <select id="prodStatus" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dimensi & Estimasi Volumetrik Section -->
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 space-y-3">
                        <div class="text-[11px] font-bold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                            <iconify-icon icon="solar:box-minimalistic-linear" class="text-base text-blue-600"></iconify-icon>
                            <span>Dimensi Produk & Estimasi Volumetrik</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Panjang (cm)</label>
                                <input type="number" step="0.1" id="prodLength" min="0" placeholder="30" oninput="calcVolumetric()" class="w-full px-3 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl" />
                            </div>
                            <div>
                                <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Lebar (cm)</label>
                                <input type="number" step="0.1" id="prodWidth" min="0" placeholder="20" oninput="calcVolumetric()" class="w-full px-3 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl" />
                            </div>
                            <div>
                                <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Tinggi (cm)</label>
                                <input type="number" step="0.1" id="prodHeight" min="0" placeholder="10" oninput="calcVolumetric()" class="w-full px-3 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-[11px] text-slate-500 bg-white dark:bg-slate-800 p-3 rounded-xl border border-slate-200 dark:border-slate-700">
                            <span>Estimasi Volumetrik (P×L×T / 4000):</span>
                            <span id="prodVolumetricDisplay" class="font-bold text-blue-600 dark:text-blue-400">0.00 kgv (0.000 m³)</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 py-3.5 px-6 border-t border-slate-100 dark:border-slate-700 shrink-0 bg-slate-50/50 dark:bg-slate-800/50">
                    <button type="button" onclick="closeProductModal()" class="px-5 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-bold bg-blue-600 hover:bg-blue-500 shadow-md transition-all">
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
                    tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Tidak ada produk ditemukan.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map((p, idx) => {
                    const isActive = (p.is_active == 1 || p.is_active === true || String(p.is_active).toLowerCase() === 'true' || String(p.status).toLowerCase() === 'active');
                    const badgeClass = isActive ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-red-50 text-red-700 dark:bg-red-950/60 dark:text-red-300';
                    const badgeLabel = isActive ? 'Aktif' : 'Nonaktif';

                    return `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-bold text-slate-500">${idx + 1}</td>
                        <td class="py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">${p.sku || p.code || '-'}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${p.name}</td>
                        <td class="py-3.5 text-slate-500">${p.category?.name || 'Umum'}</td>
                        <td class="py-3.5 text-right font-semibold text-slate-800 dark:text-slate-200">Rp ${(p.base_price || p.price || 0).toLocaleString('id-ID')}</td>
                        <td class="py-3.5 text-right text-slate-600 dark:text-slate-300">${p.weight || 0} kg</td>
                        <td class="py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${badgeClass}">
                                ${badgeLabel}
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
                    `;
                }).join('');
            } catch (err) {
                console.error('Fetch products error:', err);
                tbody.innerHTML = `<tr><td colspan="8" class="py-12 text-center text-slate-400">Gagal memuat produk.</td></tr>`;
            }
        }

        function calcVolumetric() {
            const l = parseFloat(document.getElementById('prodLength')?.value || 0);
            const w = parseFloat(document.getElementById('prodWidth')?.value || 0);
            const h = parseFloat(document.getElementById('prodHeight')?.value || 0);
            const volumetric = (l > 0 && w > 0 && h > 0) ? (l * w * h) / 4000 : 0;
            const cbm = (l > 0 && w > 0 && h > 0) ? (l * w * h) / 1000000 : 0;
            const display = document.getElementById('prodVolumetricDisplay');
            if (display) display.innerText = `${volumetric.toFixed(2)} kgv (${cbm.toFixed(3)} m³)`;
        }

        async function checkSkuUniqueness() {
            const skuInput = document.getElementById('prodSku');
            const sku = skuInput?.value?.trim();
            const id = document.getElementById('prodId')?.value;
            const feedback = document.getElementById('prodSkuFeedback');

            if (!sku) {
                if (feedback) {
                    feedback.className = 'text-xs mt-1 hidden';
                    feedback.innerText = '';
                }
                skuInput?.classList.remove('border-red-500', 'border-emerald-500');
                return true;
            }

            try {
                const url = `/api/products/check-sku?sku=${encodeURIComponent(sku)}&exclude_id=${id || ''}`;
                const res = await axios.get(url);
                const isUnique = res.data?.data?.is_unique ?? res.data?.is_unique;

                if (isUnique === false) {
                    if (feedback) {
                        feedback.className = 'text-xs mt-1 text-red-500 block font-medium';
                        feedback.innerText = 'SKU sudah digunakan untuk korporasi ini.';
                    }
                    skuInput?.classList.add('border-red-500');
                    skuInput?.classList.remove('border-emerald-500');
                    return false;
                } else {
                    if (feedback) {
                        feedback.className = 'text-xs mt-1 text-emerald-600 dark:text-emerald-400 block font-medium';
                        feedback.innerText = '✓ SKU tersedia';
                    }
                    skuInput?.classList.remove('border-red-500');
                    skuInput?.classList.add('border-emerald-500');
                    return true;
                }
            } catch (err) {
                console.error('Check SKU error:', err);
                return true;
            }
        }

        function openProductModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Produk Baru';
            document.getElementById('productForm').reset();
            document.getElementById('prodId').value = '';
            
            const skuInput = document.getElementById('prodSku');
            skuInput?.classList.remove('border-red-500', 'border-emerald-500');
            const feedback = document.getElementById('prodSkuFeedback');
            if (feedback) {
                feedback.className = 'text-xs mt-1 hidden';
                feedback.innerText = '';
            }

            calcVolumetric();
            const modal = document.getElementById('productModal');
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
        }

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }

        function editProduct(p) {
            document.getElementById('modalTitle').innerText = 'Edit Produk SKU';
            document.getElementById('prodId').value = p.id;
            document.getElementById('prodSku').value = p.sku || p.code || '';
            document.getElementById('prodName').value = p.name || '';
            document.getElementById('prodCategory').value = p.category_id || '';
            document.getElementById('prodPrice').value = p.base_price || p.price || 0;
            document.getElementById('prodWeight').value = p.weight || p.weight_kg || 0;
            document.getElementById('prodLength').value = p.length ?? (p.length_cm ?? '');
            document.getElementById('prodWidth').value = p.width ?? (p.width_cm ?? '');
            document.getElementById('prodHeight').value = p.height ?? (p.height_cm ?? '');
            
            const skuInput = document.getElementById('prodSku');
            skuInput?.classList.remove('border-red-500', 'border-emerald-500');
            const feedback = document.getElementById('prodSkuFeedback');
            if (feedback) {
                feedback.className = 'text-xs mt-1 hidden';
                feedback.innerText = '';
            }

            calcVolumetric();
            const isActive = (p.is_active == 1 || p.is_active === true || String(p.is_active).toLowerCase() === 'true' || String(p.status).toLowerCase() === 'active');
            document.getElementById('prodStatus').value = isActive ? '1' : '0';
            const modal = document.getElementById('productModal');
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
        }

        async function saveProduct(e) {
            e.preventDefault();
            const id = document.getElementById('prodId').value;
            const skuVal = document.getElementById('prodSku').value.trim();

            if (!skuVal) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Kode SKU harus diisi.' });
                document.getElementById('prodSku')?.focus();
                return;
            }

            // Check SKU uniqueness via endpoint first before allowing save (excluding current edit id)
            const isUnique = await checkSkuUniqueness();
            if (!isUnique) {
                Swal.fire({ icon: 'warning', title: 'SKU Duplikat', text: 'SKU / Kode Produk ini sudah terdaftar di korporasi Anda. Harap gunakan kode SKU lain.' });
                document.getElementById('prodSku')?.focus();
                return;
            }

            const categoryVal = document.getElementById('prodCategory').value;
            const isAct = document.getElementById('prodStatus').value === '1';
            const l = parseFloat(document.getElementById('prodLength').value || 0);
            const w = parseFloat(document.getElementById('prodWidth').value || 0);
            const h = parseFloat(document.getElementById('prodHeight').value || 0);
            const vol = (l > 0 && w > 0 && h > 0) ? (l * w * h) / 4000 : 0;

            const payload = {
                sku: skuVal,
                code: skuVal,
                name: document.getElementById('prodName').value,
                category_id: categoryVal ? categoryVal : null,
                base_price: parseFloat(document.getElementById('prodPrice').value),
                weight: parseFloat(document.getElementById('prodWeight').value),
                weight_kg: parseFloat(document.getElementById('prodWeight').value),
                length: l,
                length_cm: l,
                width: w,
                width_cm: w,
                height: h,
                height_cm: h,
                volumetric_weight: vol,
                volumetric_weight_kg: vol,
                is_active: isAct,
                status: isAct ? 'Active' : 'Inactive',
            };

            try {
                if (id) {
                    await axios.put(`/api/products/${id}`, payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Produk berhasil diperbarui.', timer: 1500, showConfirmButton: false });
                } else {
                    await axios.post('/api/products', payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Produk baru berhasil disimpan.', timer: 1500, showConfirmButton: false });
                }
                closeProductModal();
                fetchProducts();
            } catch (err) {
                const apiMsg = err.response?.data?.errors?.sku?.[0] || err.response?.data?.message || err.message;
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menyimpan produk: ' + apiMsg });
            }
        }

        async function deleteProduct(id) {
            const res = await Swal.fire({
                title: 'Hapus Produk?',
                text: 'Yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7a89',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            });
            if (!res.isConfirmed) return;
            try {
                await axios.delete(`/api/products/${id}`);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Produk berhasil dihapus.', timer: 1500, showConfirmButton: false });
                fetchProducts();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menghapus produk: ' + (err.response?.data?.message || err.message) });
            }
        }

        async function fetchCategories() {
            try {
                const res = await axios.get('/api/product-categories');
                const raw = res.data?.data;
                const categories = Array.isArray(raw) ? raw : (raw?.data || []);
                const filterSelect = document.getElementById('categoryFilter');
                const modalSelect = document.getElementById('prodCategory');

                if (filterSelect) {
                    filterSelect.innerHTML = '<option value="">Semua Kategori</option>' +
                        categories.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
                }

                if (modalSelect) {
                    modalSelect.innerHTML = '<option value="">-- Tanpa Kategori / Umum --</option>' +
                        categories.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
                }
            } catch (err) {
                console.error('Fetch categories error:', err);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchCategories();
            fetchProducts();
        });
    </script>
    @endpush
</x-layout.app>
