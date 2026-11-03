<x-layout.app title="Manajemen Pengguna | Corporate Portal">
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                    Manajemen Pengguna
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Kelola akun PIC Admin dan staf operasional untuk unit korporasi Anda
                </p>
            </div>
            @if(session('user_role') === 'corporate_admin' || !session()->has('user_role'))
            <button type="button" onclick="openUserModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/25 transition-all flex items-center gap-2 self-start sm:self-auto">
                <iconify-icon icon="solar:user-plus-bold" class="text-base"></iconify-icon>
                <span>+ Tambah Pengguna</span>
            </button>
            @endif
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3.5 pl-6 w-12 text-center">No</th>
                            <th class="py-3.5">Nama</th>
                            <th class="py-3.5">Email</th>
                            <th class="py-3.5">Telepon</th>
                            <th class="py-3.5 text-center">Peran (Role)</th>
                            <th class="py-3.5 text-center">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="inline-flex items-center gap-2">
                                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Memuat data pengguna...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Form Pengguna -->
    <div id="userModal" class="fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-xs items-center justify-center p-2 sm:p-4" style="display: none;" onclick="closeUserModal()">
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full max-w-lg flex flex-col shadow-2xl border border-slate-200 dark:border-slate-700 relative overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between py-4 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
                <h3 id="userModalTitle" class="text-base font-bold text-slate-900 dark:text-white">Tambah Pengguna Baru</h3>
                <button type="button" onclick="closeUserModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>

            <form id="userForm" onsubmit="saveUser(event)" class="flex flex-col flex-1 overflow-hidden text-xs">
                <div class="p-6 space-y-4 overflow-y-auto max-h-[75vh]">
                    <input type="hidden" id="userId" name="id">

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-semibold mb-1">Nama Lengkap *</label>
                        <input type="text" id="userName" name="name" required class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/30" placeholder="e.g. John Doe">
                    </div>

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-semibold mb-1">Alamat Email *</label>
                        <input type="email" id="userEmail" name="email" required class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/30" placeholder="user@company.com">
                    </div>

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-semibold mb-1">Nomor Telepon</label>
                        <input type="text" id="userPhone" name="phone" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/30" placeholder="08123456789">
                    </div>

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-semibold mb-1">Peran (Role) *</label>
                        <select id="userRole" name="role" required class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/30">
                            <option value="corporate_admin">Admin PIC (Akses Penuh &amp; Pengguna)</option>
                            <option value="corporate_user" selected>Staff Operasional (Pesanan &amp; Logistik)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-semibold mb-1">
                            Kata Sandi <span id="passwordRequiredLabel">*</span>
                        </label>
                        <input type="password" id="userPassword" name="password" minlength="6" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/30" placeholder="••••••••">
                        <span id="passwordHelpText" class="text-[10px] text-slate-400 mt-1 block">Minimal 6 karakter.</span>
                    </div>

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-semibold mb-1">Status Akun</label>
                        <select id="userStatus" name="is_active" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/30">
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="py-3 px-6 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-700 flex justify-end gap-2 shrink-0">
                    <button type="button" onclick="closeUserModal()" class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 font-bold text-white shadow-md shadow-blue-600/25 transition-all">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let usersData = [];
        const isCurrentAdmin = @json(session('user_role') === 'corporate_admin' || !session()->has('user_role'));

        async function fetchUsers() {
            const tbody = document.getElementById('usersTableBody');
            try {
                const res = await axios.get('/api/internal/corporate/users');
                usersData = res.data.data || [];

                if (usersData.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Belum ada pengguna terdaftar.</td></tr>`;
                    return;
                }

                tbody.innerHTML = usersData.map((u, idx) => {
                    const isActive = (u.is_active === true || u.is_active == 1 || String(u.is_active) === 'true');
                    const isPic = (u.role === 'corporate_admin');

                    const roleBadge = isPic
                        ? `<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800">
                             <iconify-icon icon="solar:shield-check-bold" class="text-xs"></iconify-icon> Admin PIC
                           </span>`
                        : `<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-950/40 dark:text-blue-300 dark:border-blue-800">
                             <iconify-icon icon="solar:user-bold" class="text-xs"></iconify-icon> Staff Operasional
                           </span>`;

                    const statusBadge = isActive
                        ? `<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800">
                             <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                           </span>`
                        : `<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-200 dark:bg-red-950/40 dark:text-red-300 dark:border-red-800">
                             <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Non-Aktif
                           </span>`;

                    const actionsHtml = isCurrentAdmin
                        ? `<div class="flex items-center justify-end gap-1">
                               <button type="button" onclick="editUser(${u.id})" class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-slate-700 transition-colors" title="Edit Pengguna">
                                   <iconify-icon icon="solar:pen-bold-duotone" class="text-base"></iconify-icon>
                               </button>
                               <button type="button" onclick="deleteUser(${u.id})" class="p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-slate-700 transition-colors" title="Hapus Pengguna">
                                   <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                               </button>
                           </div>`
                        : `<span class="text-slate-400 text-[10px] italic">Hanya Baca</span>`;

                    return `
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="py-3.5 pl-6 font-semibold text-slate-400 text-center">${idx + 1}</td>
                        <td class="py-3.5 font-bold text-slate-800 dark:text-slate-100">${u.name || '-'}</td>
                        <td class="py-3.5 text-slate-600 dark:text-slate-300">${u.email || '-'}</td>
                        <td class="py-3.5 text-slate-500 dark:text-slate-400">${u.phone || '-'}</td>
                        <td class="py-3.5 text-center">${roleBadge}</td>
                        <td class="py-3.5 text-center">${statusBadge}</td>
                        <td class="py-3.5 pr-6 text-right">${actionsHtml}</td>
                    </tr>
                    `;
                }).join('');
            } catch (err) {
                console.error('Fetch users error:', err);
                tbody.innerHTML = `<tr><td colspan="7" class="py-12 text-center text-slate-400">Gagal memuat daftar pengguna.</td></tr>`;
            }
        }

        function openUserModal() {
            document.getElementById('userModalTitle').innerText = 'Tambah Pengguna Baru';
            document.getElementById('userForm').reset();
            document.getElementById('userId').value = '';
            document.getElementById('userRole').value = 'corporate_user';
            document.getElementById('userStatus').value = '1';
            document.getElementById('userPassword').setAttribute('required', 'required');
            document.getElementById('passwordRequiredLabel').innerText = '*';
            document.getElementById('passwordHelpText').innerText = 'Wajib diisi untuk pengguna baru (minimal 6 karakter).';
            document.getElementById('userModal').style.display = 'flex';
        }

        function closeUserModal() {
            document.getElementById('userModal').style.display = 'none';
        }

        function editUser(id) {
            const u = usersData.find(item => item.id === id);
            if (!u) return;

            document.getElementById('userModalTitle').innerText = 'Edit Pengguna';
            document.getElementById('userId').value = u.id;
            document.getElementById('userName').value = u.name || '';
            document.getElementById('userEmail').value = u.email || '';
            document.getElementById('userPhone').value = u.phone || '';
            document.getElementById('userRole').value = u.role || 'corporate_user';
            
            const isActive = (u.is_active === true || u.is_active == 1 || String(u.is_active) === 'true');
            document.getElementById('userStatus').value = isActive ? '1' : '0';

            // Password optional on edit
            document.getElementById('userPassword').removeAttribute('required');
            document.getElementById('userPassword').value = '';
            document.getElementById('passwordRequiredLabel').innerText = '(Opsional)';
            document.getElementById('passwordHelpText').innerText = 'Kosongkan jika tidak ingin mengubah kata sandi.';
            document.getElementById('userModal').style.display = 'flex';
        }

        async function saveUser(e) {
            e.preventDefault();
            const id = document.getElementById('userId').value;
            const payload = {
                name: document.getElementById('userName').value,
                email: document.getElementById('userEmail').value,
                phone: document.getElementById('userPhone').value,
                role: document.getElementById('userRole').value,
                is_active: document.getElementById('userStatus').value === '1',
            };

            const pwd = document.getElementById('userPassword').value;
            if (pwd) {
                payload.password = pwd;
            }

            try {
                if (id) {
                    await axios.put(`/api/internal/corporate/users/${id}`, payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Data pengguna berhasil diperbarui.', timer: 1500, showConfirmButton: false });
                } else {
                    await axios.post('/api/internal/corporate/users', payload);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Pengguna baru berhasil ditambahkan.', timer: 1500, showConfirmButton: false });
                }
                closeUserModal();
                fetchUsers();
            } catch (err) {
                const msg = err.response?.data?.message || err.response?.data?.errors?.email?.[0] || err.message;
                Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
            }
        }

        async function deleteUser(id) {
            const res = await Swal.fire({
                title: 'Hapus Pengguna?',
                text: 'Yakin ingin menghapus akses pengguna ini dari korporasi? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7a89',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            });
            if (!res.isConfirmed) return;

            try {
                await axios.delete(`/api/internal/corporate/users/${id}`);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Pengguna berhasil dihapus.', timer: 1500, showConfirmButton: false });
                fetchUsers();
            } catch (err) {
                const msg = err.response?.data?.message || err.message;
                Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
            }
        }

        document.addEventListener('DOMContentLoaded', fetchUsers);
    </script>
    @endpush
</x-layout.app>
