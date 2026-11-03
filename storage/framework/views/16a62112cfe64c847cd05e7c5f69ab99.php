<div class="py-3 px-5 flex items-center justify-between border-b border-slate-200 dark:border-slate-800 shadow-none shrink-0 h-[70px] bg-white dark:bg-slate-900 relative z-20 overflow-hidden">
  <?php if (isset($component)) { $__componentOriginal987d96ec78ed1cf75b349e2e5981978f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal987d96ec78ed1cf75b349e2e5981978f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal987d96ec78ed1cf75b349e2e5981978f)): ?>
<?php $attributes = $__attributesOriginal987d96ec78ed1cf75b349e2e5981978f; ?>
<?php unset($__attributesOriginal987d96ec78ed1cf75b349e2e5981978f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal987d96ec78ed1cf75b349e2e5981978f)): ?>
<?php $component = $__componentOriginal987d96ec78ed1cf75b349e2e5981978f; ?>
<?php unset($__componentOriginal987d96ec78ed1cf75b349e2e5981978f); ?>
<?php endif; ?>
</div>

<div class="scroll-sidebar flex-1 overflow-y-auto pb-6 px-4 pt-4 select-none relative z-10 bg-white dark:bg-slate-900">
  <nav class="w-full flex flex-col">
    <ul id="sidebarnav" class="space-y-4">
      
      <!-- Section 1: Governance & Analytics -->
      <div>
        <div class="caption text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2 px-3">
          <span><?php echo e(__('Governance & Analytics')); ?></span>
        </div>
        <li class="sidebar-item">
          <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('dashboard') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md shadow-blue-900/25' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400'); ?>" href="/dashboard">
            <div class="flex items-center gap-3">
              <iconify-icon icon="solar:widget-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('dashboard') ? 'text-white' : 'text-blue-600 dark:text-blue-400'); ?>"></iconify-icon>
              <span class="hide-menu shrink-0 <?php echo e(request()->is('dashboard') ? '!text-white font-bold' : ''); ?>"><?php echo e(__('Dashboard')); ?></span>
            </div>
            <?php if(request()->is('dashboard')): ?>
              <span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>
            <?php endif; ?>
          </a>
        </li>
      </div>

      <!-- Section 2: Catalog & Master Data -->
      <div>
        <button type="button" 
          onclick="const el = document.getElementById('menu-catalog'); el.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180');" 
          class="w-full flex items-center justify-between px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md transition-colors select-none">
          <span><?php echo e(__('Katalog & Master')); ?></span>
          <iconify-icon icon="solar:alt-arrow-down-bold" class="arrow-icon transition-transform text-xs text-slate-400 <?php echo e(request()->is('products*', 'product-categories*', 'warehouses*', 'customers*', 'vendors*', 'distributors*') ? 'rotate-180' : ''); ?>"></iconify-icon>
        </button>
        <ul id="menu-catalog" class="mt-1 space-y-1">
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('products') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/products">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('products') ? 'text-white' : 'text-blue-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Katalog SKU')); ?></span>
              </div>
              <?php if(request()->is('products')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('product-categories*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/product-categories">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:folder-with-files-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('product-categories*') ? 'text-white' : 'text-indigo-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Kategori Produk')); ?></span>
              </div>
              <?php if(request()->is('product-categories*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('warehouses*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/warehouses">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:buildings-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('warehouses*') ? 'text-white' : 'text-blue-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Hub & Gudang')); ?></span>
              </div>
              <?php if(request()->is('warehouses*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('customers*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/customers">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('customers*') ? 'text-white' : 'text-purple-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Pelanggan B2B')); ?></span>
              </div>
              <?php if(request()->is('customers*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('vendors*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/vendors">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:hand-shake-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('vendors*') ? 'text-white' : 'text-amber-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Vendor Logistik')); ?></span>
              </div>
              <?php if(request()->is('vendors*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('distributors*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/distributors">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:buildings-2-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('distributors*') ? 'text-white' : 'text-teal-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Pelanggan (Customer)')); ?></span>
              </div>
              <?php if(request()->is('distributors*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
        </ul>
      </div>

      <!-- Section 3: Operations & Dispatch -->
      <div>
        <button type="button" 
          onclick="const el = document.getElementById('menu-operations'); el.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180');" 
          class="w-full flex items-center justify-between px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md transition-colors select-none">
          <span><?php echo e(__('Operasional & Rute')); ?></span>
          <iconify-icon icon="solar:alt-arrow-down-bold" class="arrow-icon transition-transform text-xs text-slate-400 <?php echo e(request()->is('request-orders*', 'distributor-orders*', 'waybills*') ? 'rotate-180' : ''); ?>"></iconify-icon>
        </button>
        <ul id="menu-operations" class="mt-1 space-y-1">
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('request-orders*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md shadow-blue-900/25' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/request-orders">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:cart-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('request-orders*') ? 'text-white' : 'text-blue-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0 <?php echo e(request()->is('request-orders*') ? '!text-white font-bold' : ''); ?>"><?php echo e(__('Request Orders (RO)')); ?></span>
              </div>
              <?php if(request()->is('request-orders*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('distributor-orders*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/distributor-orders">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:bag-3-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('distributor-orders*') ? 'text-white' : 'text-amber-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Pesanan Customer')); ?></span>
              </div>
              <?php if(request()->is('distributor-orders*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('waybills*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/waybills">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:delivery-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('waybills*') ? 'text-white' : 'text-purple-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Surat Jalan & Waybills')); ?></span>
              </div>
              <?php if(request()->is('waybills*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
        </ul>
      </div>

      <!-- Section 4: Inventory & Warehouse -->
      <div>
        <button type="button" 
          onclick="const el = document.getElementById('menu-inventory'); el.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180');" 
          class="w-full flex items-center justify-between px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md transition-colors select-none">
          <span><?php echo e(__('Multi-Gudang & Stok')); ?></span>
          <iconify-icon icon="solar:alt-arrow-down-bold" class="arrow-icon transition-transform text-xs text-slate-400 <?php echo e(request()->is('inventory*') ? 'rotate-180' : ''); ?>"></iconify-icon>
        </button>
        <ul id="menu-inventory" class="mt-1 space-y-1">
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('inventory/stocks*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/inventory/stocks">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:archive-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('inventory/stocks*') ? 'text-white' : 'text-blue-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Saldo Stok Gudang')); ?></span>
              </div>
              <?php if(request()->is('inventory/stocks*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('inventory/item-ins*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/inventory/item-ins">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:import-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('inventory/item-ins*') ? 'text-white' : 'text-emerald-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Barang Masuk (Inbound)')); ?></span>
              </div>
              <?php if(request()->is('inventory/item-ins*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('inventory/item-outs*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/inventory/item-outs">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:export-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('inventory/item-outs*') ? 'text-white' : 'text-amber-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Barang Keluar (Outbound)')); ?></span>
              </div>
              <?php if(request()->is('inventory/item-outs*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
        </ul>
      </div>

      <!-- Section 5: Finance & Billing -->
      <div>
        <button type="button" 
          onclick="const el = document.getElementById('menu-finance'); el.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180');" 
          class="w-full flex items-center justify-between px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md transition-colors select-none">
          <span><?php echo e(__('Keuangan & Faktur')); ?></span>
          <iconify-icon icon="solar:alt-arrow-down-bold" class="arrow-icon transition-transform text-xs text-slate-400 <?php echo e(request()->is('finance*') ? 'rotate-180' : ''); ?>"></iconify-icon>
        </button>
        <ul id="menu-finance" class="mt-1 space-y-1">
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('finance/distributor-invoices*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/finance/distributor-invoices">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:bill-list-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('finance/distributor-invoices*') ? 'text-white' : 'text-purple-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Faktur Penagihan Customer')); ?></span>
              </div>
              <?php if(request()->is('finance/distributor-invoices*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('finance/corporate-invoices*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/finance/corporate-invoices">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:bill-check-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('finance/corporate-invoices*') ? 'text-white' : 'text-blue-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Tagihan Ongkir Logistik')); ?></span>
              </div>
              <?php if(request()->is('finance/corporate-invoices*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('finance/bank-accounts*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600'); ?>" href="/finance/bank-accounts">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:card-2-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('finance/bank-accounts*') ? 'text-white' : 'text-indigo-600'); ?>"></iconify-icon>
                <span class="hide-menu shrink-0"><?php echo e(__('Rekening Bank & VA')); ?></span>
              </div>
              <?php if(request()->is('finance/bank-accounts*')): ?><span class="w-1.5 h-1.5 rounded-full bg-white/90"></span><?php endif; ?>
            </a>
          </li>
        </ul>
      </div>

      <!-- Section 6: Governance & Users -->
      <?php if(session('user_role') === 'corporate_admin' || !session()->has('user_role')): ?>
      <div>
        <div class="caption text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2 px-3">
          <span><?php echo e(__('Pengaturan & Tim')); ?></span>
        </div>
        <li class="sidebar-item">
          <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all <?php echo e(request()->is('users*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md shadow-blue-900/25' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400'); ?>" href="/users">
            <div class="flex items-center gap-3">
              <iconify-icon icon="solar:user-id-bold-duotone" class="shrink-0 text-xl <?php echo e(request()->is('users*') ? 'text-white' : 'text-blue-600 dark:text-blue-400'); ?>"></iconify-icon>
              <span class="hide-menu shrink-0 <?php echo e(request()->is('users*') ? '!text-white font-bold' : ''); ?>"><?php echo e(__('Manajemen Pengguna')); ?></span>
            </div>
            <?php if(request()->is('users*')): ?>
              <span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>
            <?php endif; ?>
          </a>
        </li>
      </div>
      <?php endif; ?>

    </ul>
  </nav>
</div>
<?php /**PATH D:\DevMuncen\CorporateFE\resources\views/components/sidebar.blade.php ENDPATH**/ ?>