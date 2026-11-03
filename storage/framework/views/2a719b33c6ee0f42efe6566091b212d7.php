<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id', 
    'name', 
    'label' => null, 
    'url', 
    'placeholder' => 'Pilih Item...', 
    'required' => false,
    'value' => null,
    'displayValue' => null
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'id', 
    'name', 
    'label' => null, 
    'url', 
    'placeholder' => 'Pilih Item...', 
    'required' => false,
    'value' => null,
    'displayValue' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="space-y-1.5" id="picker-container-<?php echo e($id); ?>" data-modal-picker data-id="<?php echo e($id); ?>" data-name="<?php echo e($name); ?>" data-url="<?php echo e($url); ?>">
    <?php if($label): ?>
        <label class="block font-bold text-xs text-slate-700 dark:text-slate-300">
            <?php echo e($label); ?>

            <?php if($required): ?>
                <span class="text-rose-500">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>
    
    <div class="flex gap-2">
        <input type="hidden" name="<?php echo e($name); ?>" id="hidden-<?php echo e($id); ?>" value="<?php echo e($value ?? ''); ?>" <?php echo e($required ? 'required' : ''); ?>>
        <input type="text" id="display-<?php echo e($id); ?>" value="<?php echo e($displayValue ?? ''); ?>" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-100 placeholder:text-slate-400 placeholder:font-normal focus:ring-2 focus:ring-blue-600 focus:outline-none cursor-pointer" placeholder="<?php echo e($placeholder); ?>" onclick="window.openModalPicker('<?php echo e($id); ?>')" oninput="const h = document.getElementById('hidden-<?php echo e($id); ?>'); if (h) { h.value = this.value; h.dataset.item = JSON.stringify({ id: this.value, name: this.value }); h.dispatchEvent(new CustomEvent('change', { bubbles: true, detail: { item: { id: this.value, name: this.value } } })); }">
        
        <button type="button" class="px-3.5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl flex items-center justify-center transition-colors shadow-sm shadow-blue-600/20" onclick="window.openModalPicker('<?php echo e($id); ?>')" title="Pilih <?php echo e($label ?? 'Item'); ?>">
            <iconify-icon icon="solar:rounded-magnifer-linear" class="text-base"></iconify-icon>
        </button>
        <button type="button" class="px-3 py-2.5 bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 hover:bg-rose-100 rounded-xl flex items-center justify-center transition-colors <?php echo e(empty($value) ? 'hidden' : ''); ?>" id="clear-<?php echo e($id); ?>" title="Hapus Pilihan">
            <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
        </button>
    </div>
    <div id="<?php echo e($name); ?>-error" class="text-rose-500 text-xs mt-1 hidden"></div>

    <!-- Standalone Modal (Zero Backdrop Conflict) -->
    <div id="modal-picker-<?php echo e($id); ?>" class="fixed inset-0 z-[100] items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;" onclick="window.closeModalPicker('<?php echo e($id); ?>')">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700 relative z-10 max-h-[90vh] flex flex-col" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700 mb-3">
                <h3 class="text-sm font-black text-slate-900 dark:text-white">Pilih <?php echo e($label ?? 'Item'); ?></h3>
                <button type="button" onclick="window.closeModalPicker('<?php echo e($id); ?>')" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700">
                    <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                </button>
            </div>

            <!-- Search -->
            <div class="mb-3">
                <div class="relative">
                    <input type="text" id="search-<?php echo e($id); ?>" class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none text-slate-800 dark:text-slate-100" placeholder="Ketik kata kunci untuk mencari...">
                    <iconify-icon icon="solar:rounded-magnifer-linear" class="absolute left-3 top-2.5 text-slate-400 text-sm"></iconify-icon>
                </div>
            </div>
            
            <!-- Table -->
            <div class="overflow-y-auto overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-700 flex-1 max-h-72">
                <table class="w-full text-left text-xs divide-y divide-slate-100 dark:divide-slate-700">
                    <thead class="bg-slate-50 dark:bg-slate-900 text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider text-[10px] sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-4 py-2.5">Kode / Ref</th>
                            <th scope="col" class="px-4 py-2.5">Nama / Lokasi</th>
                            <th scope="col" class="px-4 py-2.5 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-<?php echo e($id); ?>" class="divide-y divide-slate-100 dark:divide-slate-700/60 bg-white dark:bg-slate-800">
                        <!-- Data rendered via JS -->
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Placeholder -->
            <div id="pagination-<?php echo e($id); ?>" class="mt-3 flex justify-between items-center text-xs pt-2 border-t border-slate-100 dark:border-slate-700">
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\DevMuncen\CorporateFE\resources\views/components/modal-picker.blade.php ENDPATH**/ ?>