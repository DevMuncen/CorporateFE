<?php if (isset($component)) { $__componentOriginalcf7e1d4949dbd350ec830409f7127ebc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf7e1d4949dbd350ec830409f7127ebc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.app','data' => ['title' => 'Hub & Gudang Korporasi | Corporate Merchant Portal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hub & Gudang Korporasi | Corporate Merchant Portal']); ?>
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
                            <th class="py-3.5 pl-6">Kode Gudang</th>
                            <th class="py-3.5">Nama Gudang / Hub</th>
                            <th class="py-3.5">Kota / Lokasi</th>
                            <th class="py-3.5">Kontak PIC</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="warehousesTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
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
    <div id="warehouseModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700 relative">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-700 mb-4">
                <h3 id="whModalTitle" class="text-base font-black text-slate-900 dark:text-white">Tambah Gudang Baru</h3>
                <button type="button" onclick="closeWarehouseModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                </button>
            </div>

            <form id="warehouseForm" onsubmit="saveWarehouse(event)" class="space-y-4 text-xs">
                <input type="hidden" id="whId" />
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kode Gudang *</label>
                        <input type="text" id="whCode" required placeholder="WH-CKR-01" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama Gudang *</label>
                        <input type="text" id="whName" required placeholder="Gudang Utama Cikarang" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kota / Kabupaten *</label>
                        <input type="text" id="whCity" required placeholder="Bekasi" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Nama PIC *</label>
                        <input type="text" id="whPic" required placeholder="Bpk. Herman" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Telepon PIC *</label>
                        <input type="text" id="whPhone" required placeholder="081234567890" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Kode Pos</label>
                        <input type="text" id="whPostal" placeholder="17530" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Alamat Lengkap *</label>
                    <textarea id="whAddress" required rows="3" placeholder="Kawasan Industri Jababeka Blok C..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" onclick="closeWarehouseModal()" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-white font-bold bg-blue-600 hover:bg-blue-500 shadow-md transition-all">
                        Simpan Gudang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        async function fetchWarehouses() {
            const tbody = document.getElementById('warehousesTableBody');
            try {
                const res = await axios.get('/api/warehouses');
                const data = res.data?.data || [];

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Belum ada gudang terdaftar.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map(w => `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-mono font-bold text-blue-600 dark:text-blue-400">${w.code || '-'}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${w.name}</td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-400">${w.city || '-'}, ${w.address || ''}</td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-300">${w.pic_name || '-'} (${w.phone || '-'})</td>
                        <td class="py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">Aktif</span>
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
                `).join('');
            } catch (err) {
                console.error('Fetch warehouses error:', err);
                tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Gagal memuat gudang.</td></tr>`;
            }
        }

        function openWarehouseModal() {
            document.getElementById('whModalTitle').innerText = 'Tambah Gudang Baru';
            document.getElementById('warehouseForm').reset();
            document.getElementById('whId').value = '';
            document.getElementById('warehouseModal').classList.remove('hidden');
        }

        function closeWarehouseModal() {
            document.getElementById('warehouseModal').classList.add('hidden');
        }

        function editWarehouse(w) {
            document.getElementById('whModalTitle').innerText = 'Edit Gudang';
            document.getElementById('whId').value = w.id;
            document.getElementById('whCode').value = w.code || '';
            document.getElementById('whName').value = w.name || '';
            document.getElementById('whCity').value = w.city || '';
            document.getElementById('whPic').value = w.pic_name || '';
            document.getElementById('whPhone').value = w.phone || '';
            document.getElementById('whPostal').value = w.postal_code || '';
            document.getElementById('whAddress').value = w.address || '';
            document.getElementById('warehouseModal').classList.remove('hidden');
        }

        async function saveWarehouse(e) {
            e.preventDefault();
            const id = document.getElementById('whId').value;
            const payload = {
                code: document.getElementById('whCode').value,
                name: document.getElementById('whName').value,
                city: document.getElementById('whCity').value,
                pic_name: document.getElementById('whPic').value,
                phone: document.getElementById('whPhone').value,
                postal_code: document.getElementById('whPostal').value,
                address: document.getElementById('whAddress').value,
            };

            try {
                if (id) {
                    await axios.put(`/api/warehouses/${id}`, payload);
                } else {
                    await axios.post('/api/warehouses', payload);
                }
                closeWarehouseModal();
                fetchWarehouses();
            } catch (err) {
                alert('Gagal menyimpan gudang: ' + (err.response?.data?.message || err.message));
            }
        }

        async function deleteWarehouse(id) {
            if (!confirm('Yakin ingin menghapus gudang ini?')) return;
            try {
                await axios.delete(`/api/warehouses/${id}`);
                fetchWarehouses();
            } catch (err) {
                alert('Gagal menghapus gudang: ' + (err.response?.data?.message || err.message));
            }
        }

        document.addEventListener('DOMContentLoaded', fetchWarehouses);
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf7e1d4949dbd350ec830409f7127ebc)): ?>
<?php $attributes = $__attributesOriginalcf7e1d4949dbd350ec830409f7127ebc; ?>
<?php unset($__attributesOriginalcf7e1d4949dbd350ec830409f7127ebc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf7e1d4949dbd350ec830409f7127ebc)): ?>
<?php $component = $__componentOriginalcf7e1d4949dbd350ec830409f7127ebc; ?>
<?php unset($__componentOriginalcf7e1d4949dbd350ec830409f7127ebc); ?>
<?php endif; ?>
<?php /**PATH D:\DevMuncen\CorporateFE\resources\views/warehouses/index.blade.php ENDPATH**/ ?>