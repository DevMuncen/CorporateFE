@props([
    'entity',
    'title' => 'Master Data',
    'baseUrl' => '/api/internal/master-excel',
    'onImported' => '',
])

<div class="inline-flex items-center gap-1.5">
    <button type="button"
        onclick="window.MasterExcelModal.download(@js($entity), false, @js($baseUrl), this)"
        title="Unduh template Excel (.xlsx) lengkap dengan dropdown dan tabel referensi"
        class="px-3 py-2 rounded-xl text-xs font-semibold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition-all flex items-center gap-1.5 shadow-xs cursor-pointer">
        <iconify-icon icon="solar:file-download-bold-duotone" class="text-base"></iconify-icon>
        <span>Template .xlsx</span>
    </button>

    <button type="button"
        onclick="window.MasterExcelModal.open({ entity: @js($entity), title: @js($title), baseUrl: @js($baseUrl), onImported: @js($onImported) })"
        title="Impor massal dari file Excel / CSV dengan validasi pratinjau"
        class="px-3 py-2 rounded-xl text-xs font-semibold text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-800 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-all flex items-center gap-1.5 shadow-xs cursor-pointer">
        <iconify-icon icon="solar:upload-minimalistic-bold-duotone" class="text-base"></iconify-icon>
        <span>Import Excel</span>
    </button>
</div>

@once
<div id="masterExcelModalBackdrop"
    class="fixed inset-0 z-[80] bg-slate-900/70 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-6 overflow-y-auto"
    style="display: none;"
    onclick="if (event.target === this) window.MasterExcelModal.close()">
    <div class="bg-white dark:bg-slate-800 rounded-2xl w-full max-w-4xl shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden my-auto flex flex-col max-h-[92vh]"
        onclick="event.stopPropagation()">

        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-900/50 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 flex items-center justify-center">
                    <iconify-icon icon="solar:document-add-bold-duotone" class="text-2xl"></iconify-icon>
                </div>
                <div>
                    <h3 id="mexModalTitle" class="text-base font-bold text-slate-900 dark:text-white">Import Massal Excel</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Gunakan template resmi agar nama kolom & referensi dropdown otomatis terbaca akurat</p>
                </div>
            </div>
            <button type="button" onclick="window.MasterExcelModal.close()"
                class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-200/60 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="p-6 overflow-y-auto space-y-5 flex-1">
            <!-- Quick Alert / Error Banner -->
            <div id="mexGlobalAlert" class="hidden rounded-xl p-3.5 text-xs font-medium border"></div>

            <!-- Template Preparation Strip -->
            <div class="rounded-xl border border-emerald-200 dark:border-emerald-800/70 bg-emerald-50/60 dark:bg-emerald-950/25 p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="space-y-1">
                    <div class="text-xs font-bold text-emerald-900 dark:text-emerald-200 flex items-center gap-1.5">
                        <iconify-icon icon="solar:lightbulb-bolt-bold-duotone" class="text-base"></iconify-icon>
                        <span>Langkah 1 (Opsional): Unduh Template Terbaru</span>
                    </div>
                    <p class="text-[11px] text-emerald-700 dark:text-emerald-300/90">
                        Template sudah berisi Sheet <code class="font-bold">Data Import</code>, seluruh sheet referensi (<code class="font-bold">Ref_*</code>), dropdown Excel, serta <code class="font-bold">Panduan Pengisian</code>.
                    </p>
                    <label class="inline-flex items-center gap-2 pt-1 cursor-pointer select-none">
                        <input type="checkbox" id="mexIncludeExisting" class="rounded border-emerald-400 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-xs font-semibold text-emerald-900 dark:text-emerald-200">Sertakan data aktif saat ini (untuk Bulk Edit / Upsert)</span>
                    </label>
                </div>
                <button type="button" id="mexModalDownloadBtn" onclick="window.MasterExcelModal.downloadCurrent(this)"
                    class="shrink-0 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold flex items-center gap-2 shadow-sm transition-colors cursor-pointer">
                    <iconify-icon icon="solar:file-download-bold" class="text-base"></iconify-icon>
                    <span>Unduh Template (.xlsx)</span>
                </button>
            </div>

            <!-- Step 1: Upload Form -->
            <div id="mexStep1Panel" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Mode Impor Data</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-start gap-2.5 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-900/40 cursor-pointer hover:border-indigo-400 transition-colors">
                            <input type="radio" name="mexMode" value="create_only" checked class="mt-0.5 text-indigo-600 focus:ring-indigo-500">
                            <div>
                                <div class="text-xs font-bold text-slate-900 dark:text-white">Tambah Baru Saja (Aman)</div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400">Menolak otomatis jika kode / nomor rekening / email sudah terdaftar.</div>
                            </div>
                        </label>
                        <label class="flex items-start gap-2.5 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-900/40 cursor-pointer hover:border-indigo-400 transition-colors">
                            <input type="radio" name="mexMode" value="upsert" class="mt-0.5 text-indigo-600 focus:ring-indigo-500">
                            <div>
                                <div class="text-xs font-bold text-slate-900 dark:text-white">Tambah Baru & Update Existing (Upsert)</div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400">Memperbarui data lama jika kodenya cocok, dan menambah data baru.</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Pilih File Excel / CSV</label>
                    <div id="mexDropZone"
                        onclick="document.getElementById('mexFileInput').click()"
                        class="border-2 border-dashed border-slate-300 dark:border-slate-600 hover:border-indigo-500 dark:hover:border-indigo-400 rounded-2xl p-6 text-center bg-slate-50/50 dark:bg-slate-900/30 cursor-pointer transition-colors">
                        <input type="file" id="mexFileInput" accept=".xlsx,.xls,.csv" class="hidden" onchange="window.MasterExcelModal.handleFileSelect(this.files[0])">
                        <iconify-icon icon="solar:cloud-upload-bold-duotone" class="text-4xl text-indigo-500 mx-auto mb-2"></iconify-icon>
                        <p id="mexFileLabel" class="text-xs font-bold text-slate-800 dark:text-slate-200">
                            Klik untuk memilih atau seret file .xlsx / .xls / .csv ke area ini
                        </p>
                        <p class="text-[11px] text-slate-400 mt-1">Maksimal ukuran file 5 MB • Maksimal 2.000 baris per upload</p>
                    </div>
                </div>
            </div>

            <!-- Step 2: Dry-Run Result Panel -->
            <div id="mexStep2Panel" class="hidden space-y-4">
                <!-- Summary Cards -->
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-2.5">
                    <div class="rounded-xl p-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                        <div class="text-[10px] font-bold uppercase text-slate-400">Total Baris</div>
                        <div id="mexSumTotal" class="text-lg font-black text-slate-900 dark:text-white mt-0.5">0</div>
                    </div>
                    <div class="rounded-xl p-3 bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800">
                        <div class="text-[10px] font-bold uppercase text-blue-600 dark:text-blue-400">Baris Valid</div>
                        <div id="mexSumValid" class="text-lg font-black text-blue-700 dark:text-blue-300 mt-0.5">0</div>
                    </div>
                    <div class="rounded-xl p-3 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800">
                        <div class="text-[10px] font-bold uppercase text-emerald-600 dark:text-emerald-400">Akan Ditambah</div>
                        <div id="mexSumCreate" class="text-lg font-black text-emerald-700 dark:text-emerald-300 mt-0.5">0</div>
                    </div>
                    <div class="rounded-xl p-3 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800">
                        <div class="text-[10px] font-bold uppercase text-amber-600 dark:text-amber-400">Akan Diupdate</div>
                        <div id="mexSumUpdate" class="text-lg font-black text-amber-700 dark:text-amber-300 mt-0.5">0</div>
                    </div>
                    <div class="rounded-xl p-3 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800">
                        <div class="text-[10px] font-bold uppercase text-rose-600 dark:text-rose-400">Error</div>
                        <div id="mexSumError" class="text-lg font-black text-rose-700 dark:text-rose-300 mt-0.5">0</div>
                    </div>
                </div>

                <!-- Errors Table -->
                <div id="mexErrorsWrap" class="hidden space-y-2">
                    <div class="rounded-xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 p-3 text-xs text-rose-800 dark:text-rose-200 font-semibold">
                        Validasi gagal! Perbaiki baris yang bermasalah di file Excel Anda lalu unggah ulang. Tidak ada data yang disimpan (0 perubahan).
                    </div>
                    <div class="border border-rose-200 dark:border-rose-800 rounded-xl overflow-hidden max-h-60 overflow-y-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-rose-100/80 dark:bg-rose-900/50 text-rose-900 dark:text-rose-200 font-bold sticky top-0">
                                <tr>
                                    <th class="py-2 px-3 w-16">Baris</th>
                                    <th class="py-2 px-3 w-40">Kolom</th>
                                    <th class="py-2 px-3 w-40">Nilai</th>
                                    <th class="py-2 px-3">Alasan Error</th>
                                </tr>
                            </thead>
                            <tbody id="mexErrorsTbody" class="divide-y divide-rose-100 dark:divide-rose-900/50 bg-white dark:bg-slate-800"></tbody>
                        </table>
                    </div>
                </div>

                <!-- Preview Table -->
                <div id="mexPreviewWrap" class="hidden space-y-2">
                    <div class="rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 p-3 text-xs text-emerald-800 dark:text-emerald-200 font-semibold">
                        Semua baris lolos validasi! Periksa ringkasan pratinjau di bawah ini lalu klik <strong>Terapkan Impor Permanen</strong>.
                    </div>
                    <div class="border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden max-h-60 overflow-y-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-300 font-bold sticky top-0">
                                <tr>
                                    <th class="py-2 px-3 w-16">Baris</th>
                                    <th class="py-2 px-3 w-28">Aksi</th>
                                    <th class="py-2 px-3 w-44">Kode / Kunci</th>
                                    <th class="py-2 px-3">Nama / Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="mexPreviewTbody" class="divide-y divide-slate-100 dark:divide-slate-700/60 bg-white dark:bg-slate-800"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex flex-wrap items-center justify-between gap-2 px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-900/50 shrink-0">
            <button type="button" id="mexResetBtn" onclick="window.MasterExcelModal.resetToStep1()"
                class="hidden px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 hover:bg-slate-100 transition-colors cursor-pointer">
                ← Unggah File Lain
            </button>
            <div class="flex items-center gap-2 ml-auto">
                <button type="button" onclick="window.MasterExcelModal.close()"
                    class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 hover:bg-slate-100 transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="button" id="mexDryRunBtn" onclick="window.MasterExcelModal.submitImport(true)"
                    class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors cursor-pointer flex items-center gap-1.5">
                    <iconify-icon icon="solar:shield-check-bold" class="text-base"></iconify-icon>
                    <span>Validasi & Pratinjau (Dry-Run)</span>
                </button>
                <button type="button" id="mexCommitBtn" onclick="window.MasterExcelModal.submitImport(false)"
                    class="hidden px-4 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition-colors cursor-pointer flex items-center gap-1.5">
                    <iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon>
                    <span>Terapkan Impor Permanen</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
window.MasterExcelModal = window.MasterExcelModal || (function () {
    const state = {
        entity: '',
        title: '',
        baseUrl: '/api/internal/master-excel',
        onImported: '',
        file: null,
        busy: false,
    };

    const el = (id) => document.getElementById(id);

    function esc(str) {
        return String(str ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    function showAlert(msg, type = 'error') {
        const box = el('mexGlobalAlert');
        box.classList.remove('hidden', 'bg-rose-50', 'border-rose-200', 'text-rose-800', 'dark:bg-rose-950/50', 'dark:border-rose-800', 'dark:text-rose-200',
            'bg-emerald-50', 'border-emerald-200', 'text-emerald-800', 'dark:bg-emerald-950/50', 'dark:border-emerald-800', 'dark:text-emerald-200');
        if (type === 'success') {
            box.classList.add('bg-emerald-50', 'border-emerald-200', 'text-emerald-800', 'dark:bg-emerald-950/50', 'dark:border-emerald-800', 'dark:text-emerald-200');
        } else {
            box.classList.add('bg-rose-50', 'border-rose-200', 'text-rose-800', 'dark:bg-rose-950/50', 'dark:border-rose-800', 'dark:text-rose-200');
        }
        box.textContent = msg;
    }

    function hideAlert() {
        el('mexGlobalAlert')?.classList.add('hidden');
    }

    function notifyToast(msg, type = 'success') {
        if (window.Alert && typeof window.Alert.toast === 'function') {
            window.Alert.toast(msg, type);
        } else if (typeof window.showToast === 'function') {
            window.showToast(msg, type);
        } else if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: type, title: msg, toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
        }
    }

    function notifyError(title, msg) {
        if (window.Alert && typeof window.Alert.error === 'function') {
            window.Alert.error(title, msg);
        } else if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'error', title: title, text: msg, confirmButtonColor: '#2563eb' });
        }
    }

    async function download(entity, includeExisting, baseUrl, btn) {
        const origHtml = btn ? btn.innerHTML : '';
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span>Mengunduh...</span>';
        }
        try {
            const url = `${baseUrl || '/api/internal/master-excel'}/${encodeURIComponent(entity)}/template?include_existing=${includeExisting ? 1 : 0}`;
            const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!res.ok) {
                let errMsg = `Gagal mengunduh template (HTTP ${res.status})`;
                try {
                    const j = await res.json();
                    errMsg = j.message || errMsg;
                } catch (_) {}
                notifyError('Gagal Unduh Template', errMsg);
                return;
            }
            const blob = await res.blob();
            let filename = `template_${entity}.xlsx`;
            const cd = res.headers.get('Content-Disposition') || '';
            const match = cd.match(/filename\*=UTF-8''([^;]+)|filename="?([^";]+)"?/i);
            if (match) {
                filename = decodeURIComponent(match[1] || match[2]);
            }
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            link.remove();
            setTimeout(() => URL.revokeObjectURL(link.href), 5000);
        } catch (err) {
            notifyError('Koneksi Gagal', err?.message || 'Koneksi terputus saat mengunduh template.');
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = origHtml;
            }
        }
    }

    function downloadCurrent(btn) {
        const includeExisting = Boolean(el('mexIncludeExisting')?.checked);
        download(state.entity, includeExisting, state.baseUrl, btn);
    }

    function open(opts) {
        state.entity = opts.entity;
        state.title = opts.title || 'Master Data';
        state.baseUrl = opts.baseUrl || '/api/internal/master-excel';
        state.onImported = opts.onImported || '';
        el('mexModalTitle').textContent = `Import Massal Excel — ${state.title}`;
        resetToStep1();
        const modal = el('masterExcelModalBackdrop');
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
        document.body.classList.add('has-modal-open');
    }

    function close() {
        const modal = el('masterExcelModalBackdrop');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.style.display = 'none';
        document.body.classList.remove('has-modal-open');
    }

    function resetToStep1() {
        state.file = null;
        if (el('mexFileInput')) el('mexFileInput').value = '';
        if (el('mexFileLabel')) el('mexFileLabel').textContent = 'Klik untuk memilih atau seret file .xlsx / .xls / .csv ke area ini';
        hideAlert();
        el('mexStep1Panel').classList.remove('hidden');
        el('mexStep2Panel').classList.add('hidden');
        el('mexResetBtn').classList.add('hidden');
        el('mexDryRunBtn').classList.remove('hidden');
        el('mexCommitBtn').classList.add('hidden');
    }

    function handleFileSelect(file) {
        hideAlert();
        if (!file) return;
        const ext = (file.name.split('.').pop() || '').toLowerCase();
        if (!['xlsx', 'xls', 'csv'].includes(ext)) {
            state.file = null;
            if (el('mexFileInput')) el('mexFileInput').value = '';
            showAlert('Format file tidak didukung. Harap pilih file .xlsx, .xls, atau .csv.');
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            state.file = null;
            if (el('mexFileInput')) el('mexFileInput').value = '';
            showAlert('Ukuran file melebihi batas maksimal 5 MB.');
            return;
        }
        state.file = file;
        const kb = Math.max(1, Math.round(file.size / 1024));
        el('mexFileLabel').textContent = `File terpilih: ${file.name} (${kb} KB)`;
    }

    async function submitImport(dryRun) {
        if (state.busy) return;
        if (!state.file) {
            showAlert('Silakan pilih file .xlsx, .xls, atau .csv terlebih dahulu.');
            return;
        }
        hideAlert();
        state.busy = true;
        const activeBtn = dryRun ? el('mexDryRunBtn') : el('mexCommitBtn');
        const origHtml = activeBtn.innerHTML;
        activeBtn.disabled = true;
        activeBtn.innerHTML = '<span>Memproses...</span>';

        try {
            const mode = document.querySelector('input[name="mexMode"]:checked')?.value || 'create_only';
            const fd = new FormData();
            fd.append('file', state.file);
            fd.append('mode', mode);
            fd.append('dry_run', dryRun ? '1' : '0');

            const res = await fetch(`${state.baseUrl}/${encodeURIComponent(state.entity)}/import`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: fd,
            });

            const json = await res.json().catch(() => ({}));
            const data = json.data || {};
            const summary = data.summary || {};

            if (res.status === 403) {
                showAlert(json.message || 'Anda tidak memiliki hak akses admin untuk mengimpor modul ini.');
                return;
            }

            if (!summary || typeof summary.total_rows === 'undefined') {
                showAlert(json.message || `Gagal memproses file Excel (HTTP ${res.status}).`);
                return;
            }

            renderDryRunOrResult(data, json.message || '');

            if (!dryRun && res.ok && json.success) {
                const c = summary.created_count || 0;
                const u = summary.updated_count || 0;
                close();
                notifyToast(`Import ${state.title} berhasil: ${c} ditambah, ${u} diupdate.`, 'success');
                if (state.onImported) {
                    try {
                        new Function(state.onImported)();
                    } catch (_) {}
                }
                window.dispatchEvent(new CustomEvent('master-excel:imported', {
                    detail: { entity: state.entity, result: data }
                }));
            }
        } catch (err) {
            showAlert('Terjadi kesalahan jaringan saat memproses impor: ' + (err?.message || 'Unknown error'));
        } finally {
            state.busy = false;
            activeBtn.disabled = false;
            activeBtn.innerHTML = origHtml;
        }
    }

    function renderDryRunOrResult(data, message) {
        const s = data.summary || {};
        const errors = data.errors || [];
        const preview = data.preview || [];
        const validCount = Number(s.valid_count ?? s.valid_rows ?? 0);
        const wouldCreate = preview.length > 0
            ? preview.filter((p) => p.action !== 'update').length
            : Number(s.created_count ?? 0);
        const wouldUpdate = preview.length > 0
            ? preview.filter((p) => p.action === 'update').length
            : Number(s.updated_count ?? 0);

        el('mexStep1Panel').classList.add('hidden');
        el('mexStep2Panel').classList.remove('hidden');
        el('mexResetBtn').classList.remove('hidden');
        el('mexDryRunBtn').classList.add('hidden');

        el('mexSumTotal').textContent = s.total_rows ?? 0;
        el('mexSumValid').textContent = validCount;
        el('mexSumCreate').textContent = data.dry_run ? wouldCreate : (s.created_count ?? 0);
        el('mexSumUpdate').textContent = data.dry_run ? wouldUpdate : (s.updated_count ?? 0);
        el('mexSumError').textContent = s.error_count ?? 0;

        if (errors.length > 0) {
            el('mexErrorsWrap').classList.remove('hidden');
            el('mexPreviewWrap').classList.add('hidden');
            el('mexCommitBtn').classList.add('hidden');
            el('mexErrorsTbody').innerHTML = errors.map((e) => `
                <tr>
                    <td class="py-2 px-3 font-bold text-rose-700 dark:text-rose-300">#${esc(e.row)}</td>
                    <td class="py-2 px-3 font-mono text-[11px] text-slate-700 dark:text-slate-300">${esc(e.column)}</td>
                    <td class="py-2 px-3 text-slate-600 dark:text-slate-400 break-all">${esc(e.value || '-')}</td>
                    <td class="py-2 px-3 text-rose-700 dark:text-rose-300 font-medium">${esc(e.message)}</td>
                </tr>
            `).join('');
        } else {
            el('mexErrorsWrap').classList.add('hidden');
            el('mexPreviewWrap').classList.remove('hidden');
            const commitBtn = el('mexCommitBtn');
            if (validCount > 0) {
                commitBtn.classList.remove('hidden');
                commitBtn.innerHTML = `<iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon><span>Terapkan Impor Permanen (${validCount} Baris)</span>`;
            } else {
                commitBtn.classList.add('hidden');
                showAlert(message || 'File tidak memiliki baris data yang bisa diimpor.');
            }
            el('mexPreviewTbody').innerHTML = preview.map((p) => `
                <tr>
                    <td class="py-2 px-3 font-semibold text-slate-700 dark:text-slate-300">#${esc(p.row)}</td>
                    <td class="py-2 px-3">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${p.action === 'update'
                            ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300'
                            : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300'}">
                            ${p.action === 'update' ? 'Update' : 'Tambah Baru'}
                        </span>
                    </td>
                    <td class="py-2 px-3 font-mono text-[11px] font-semibold text-slate-900 dark:text-white">${esc(p.code || '-')}</td>
                    <td class="py-2 px-3 text-slate-700 dark:text-slate-300">${esc(p.name || '-')}</td>
                </tr>
            `).join('');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const dz = el('mexDropZone');
        if (!dz) return;
        dz.addEventListener('dragover', (e) => {
            e.preventDefault();
            dz.classList.add('border-indigo-500', 'bg-indigo-50/40', 'dark:bg-indigo-950/30');
        });
        dz.addEventListener('dragleave', () => {
            dz.classList.remove('border-indigo-500', 'bg-indigo-50/40', 'dark:bg-indigo-950/30');
        });
        dz.addEventListener('drop', (e) => {
            e.preventDefault();
            dz.classList.remove('border-indigo-500', 'bg-indigo-50/40', 'dark:bg-indigo-950/30');
            if (e.dataTransfer?.files?.[0]) {
                handleFileSelect(e.dataTransfer.files[0]);
            }
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') close();
    });

    return { open, close, download, downloadCurrent, resetToStep1, handleFileSelect, submitImport };
})();
</script>
@endonce
