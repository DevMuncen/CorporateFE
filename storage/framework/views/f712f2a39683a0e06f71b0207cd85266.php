<?php if (isset($component)) { $__componentOriginalcf7e1d4949dbd350ec830409f7127ebc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf7e1d4949dbd350ec830409f7127ebc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.app','data' => ['title' => 'Vendor Logistik & Supplier | Corporate Merchant Portal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Vendor Logistik & Supplier | Corporate Merchant Portal']); ?>
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
                            <th class="py-3.5 pl-6">Nama Vendor</th>
                            <th class="py-3.5">Kategori / Layanan</th>
                            <th class="py-3.5">Kontak &amp; Telepon</th>
                            <th class="py-3.5">Alamat Operasional</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="vendorsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
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
    <div id="vendorModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700 relative">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-700 mb-4">
                <h3 id="vndModalTitle" class="text-base font-black text-slate-900 dark:text-white">Tambah Vendor Baru</h3>
                <button type="button" onclick="closeVendorModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                </button>
            </div>

            <form id="vendorForm" onsubmit="saveVendor(event)" class="space-y-4 text-xs">
                <input type="hidden" id="vndId" />
                <div class="grid grid-cols-2 gap-3">
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
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Telepon / Hotline *</label>
                        <input type="text" id="vndPhone" required placeholder="021-88997766" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                    <div>
                        <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Email Operasional</label>
                        <input type="email" id="vndEmail" placeholder="dispatch@muncenlogistic.com" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl" />
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-600 dark:text-slate-300 mb-1">Alamat Kantor / Pool Armada</label>
                    <textarea id="vndAddress" rows="3" placeholder="Jl. Raya Pelabuhan No. 45, Tanjung Priok..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" onclick="closeVendorModal()" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-white font-bold bg-blue-600 hover:bg-blue-500 shadow-md transition-all">
                        Simpan Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        async function fetchVendors() {
            const tbody = document.getElementById('vendorsTableBody');
            try {
                const res = await axios.get('/api/vendors');
                const data = res.data?.data || [];

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Belum ada vendor terdaftar.</td></tr>`;
                    return;
                }

                tbody.innerHTML = data.map(v => `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3.5 pl-6 font-bold text-slate-800 dark:text-slate-100">${v.name}</td>
                        <td class="py-3.5">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 uppercase tracking-wider">
                                ${v.type || 'Logistik'}
                            </span>
                        </td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-300">${v.phone || '-'} <br><span class="text-[10px] text-slate-400">${v.email || ''}</span></td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-400">${v.address || '-'}</td>
                        <td class="py-3.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">Aktif</span>
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
                `).join('');
            } catch (err) {
                console.error('Fetch vendors error:', err);
                tbody.innerHTML = `<tr><td colspan="6" class="py-12 text-center text-slate-400">Gagal memuat vendor.</td></tr>`;
            }
        }

        function openVendorModal() {
            document.getElementById('vndModalTitle').innerText = 'Tambah Vendor Baru';
            document.getElementById('vendorForm').reset();
            document.getElementById('vndId').value = '';
            document.getElementById('vendorModal').classList.remove('hidden');
        }

        function closeVendorModal() {
            document.getElementById('vendorModal').classList.add('hidden');
        }

        function editVendor(v) {
            document.getElementById('vndModalTitle').innerText = 'Edit Vendor';
            document.getElementById('vndId').value = v.id;
            document.getElementById('vndName').value = v.name || '';
            document.getElementById('vndType').value = v.type || 'logistic';
            document.getElementById('vndPhone').value = v.phone || '';
            document.getElementById('vndEmail').value = v.email || '';
            document.getElementById('vndAddress').value = v.address || '';
            document.getElementById('vendorModal').classList.remove('hidden');
        }

        async function saveVendor(e) {
            e.preventDefault();
            const id = document.getElementById('vndId').value;
            const payload = {
                name: document.getElementById('vndName').value,
                type: document.getElementById('vndType').value,
                phone: document.getElementById('vndPhone').value,
                email: document.getElementById('vndEmail').value,
                address: document.getElementById('vndAddress').value,
            };

            try {
                if (id) {
                    await axios.put(`/api/vendors/${id}`, payload);
                } else {
                    await axios.post('/api/vendors', payload);
                }
                closeVendorModal();
                fetchVendors();
            } catch (err) {
                alert('Gagal menyimpan vendor: ' + (err.response?.data?.message || err.message));
            }
        }

        async function deleteVendor(id) {
            if (!confirm('Yakin ingin menghapus vendor ini?')) return;
            try {
                await axios.delete(`/api/vendors/${id}`);
                fetchVendors();
            } catch (err) {
                alert('Gagal menghapus vendor: ' + (err.response?.data?.message || err.message));
            }
        }

        document.addEventListener('DOMContentLoaded', fetchVendors);
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
<?php /**PATH D:\DevMuncen\CorporateFE\resources\views/vendors/index.blade.php ENDPATH**/ ?>