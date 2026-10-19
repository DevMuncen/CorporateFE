<div class="py-3 px-5 flex items-center justify-between border-b border-slate-200 dark:border-slate-800 shadow-none shrink-0 h-[70px] bg-white dark:bg-slate-900 relative z-20 overflow-hidden">
  <x-logo />
</div>

<div class="scroll-sidebar flex-1 overflow-y-auto pb-6 px-4 pt-4 select-none relative z-10 bg-white dark:bg-slate-900">
  <nav class="w-full flex flex-col">
    <ul id="sidebarnav" class="space-y-4">
      
      <!-- Section 1: Governance & Analytics -->
      <div>
        <div class="caption text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2 px-3">
          <span>{{ __('Governance & Analytics') }}</span>
        </div>
        <li class="sidebar-item">
          <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('dashboard') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md shadow-blue-900/25' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400' }}" href="/dashboard">
            <div class="flex items-center gap-3">
              <iconify-icon icon="solar:widget-bold-duotone" class="shrink-0 text-xl {{ request()->is('dashboard') ? 'text-white' : 'text-blue-600 dark:text-blue-400' }}"></iconify-icon>
              <span class="hide-menu shrink-0 {{ request()->is('dashboard') ? '!text-white font-bold' : '' }}">{{ __('Dashboard') }}</span>
            </div>
            @if(request()->is('dashboard'))
              <span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>
            @endif
          </a>
        </li>
      </div>

      <!-- Section 2: Catalog & Master Data -->
      <div>
        <button type="button" 
          onclick="const el = document.getElementById('menu-catalog'); el.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180');" 
          class="w-full flex items-center justify-between px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md transition-colors select-none">
          <span>{{ __('Katalog & Master') }}</span>
          <iconify-icon icon="solar:alt-arrow-down-bold" class="arrow-icon transition-transform text-xs text-slate-400 {{ request()->is('products*', 'product-categories*', 'warehouses*', 'customers*', 'vendors*', 'distributors*') ? 'rotate-180' : '' }}"></iconify-icon>
        </button>
        <ul id="menu-catalog" class="mt-1 space-y-1">
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('products') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/products">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="shrink-0 text-xl {{ request()->is('products') ? 'text-white' : 'text-blue-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Katalog SKU') }}</span>
              </div>
              @if(request()->is('products'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('product-categories*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/product-categories">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:folder-with-files-bold-duotone" class="shrink-0 text-xl {{ request()->is('product-categories*') ? 'text-white' : 'text-indigo-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Kategori Produk') }}</span>
              </div>
              @if(request()->is('product-categories*'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('warehouses*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/warehouses">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:buildings-bold-duotone" class="shrink-0 text-xl {{ request()->is('warehouses*') ? 'text-white' : 'text-blue-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Hub & Gudang') }}</span>
              </div>
              @if(request()->is('warehouses*'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('customers*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/customers">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="shrink-0 text-xl {{ request()->is('customers*') ? 'text-white' : 'text-purple-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Pelanggan B2B') }}</span>
              </div>
              @if(request()->is('customers*'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('vendors*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/vendors">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:hand-shake-bold-duotone" class="shrink-0 text-xl {{ request()->is('vendors*') ? 'text-white' : 'text-amber-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Vendor Logistik') }}</span>
              </div>
              @if(request()->is('vendors*'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('distributors*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/distributors">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:buildings-2-bold-duotone" class="shrink-0 text-xl {{ request()->is('distributors*') ? 'text-white' : 'text-teal-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Mitra Distributor') }}</span>
              </div>
              @if(request()->is('distributors*'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
        </ul>
      </div>

      <!-- Section 3: Operations & Dispatch -->
      <div>
        <button type="button" 
          onclick="const el = document.getElementById('menu-operations'); el.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180');" 
          class="w-full flex items-center justify-between px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md transition-colors select-none">
          <span>{{ __('Operasional & Rute') }}</span>
          <iconify-icon icon="solar:alt-arrow-down-bold" class="arrow-icon transition-transform text-xs text-slate-400 {{ request()->is('request-orders*', 'distributor-orders*', 'waybills*') ? 'rotate-180' : '' }}"></iconify-icon>
        </button>
        <ul id="menu-operations" class="mt-1 space-y-1">
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('request-orders') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/request-orders">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:cart-bold-duotone" class="shrink-0 text-xl {{ request()->is('request-orders') ? 'text-white' : 'text-blue-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Request Orders (RO)') }}</span>
              </div>
              @if(request()->is('request-orders'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('request-orders/create') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/request-orders/create">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:cart-plus-bold-duotone" class="shrink-0 text-xl {{ request()->is('request-orders/create') ? 'text-white' : 'text-emerald-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('+ Buat RO Wizard') }}</span>
              </div>
              @if(request()->is('request-orders/create'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('distributor-orders*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/distributor-orders">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:bag-3-bold-duotone" class="shrink-0 text-xl {{ request()->is('distributor-orders*') ? 'text-white' : 'text-amber-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Pesanan Distributor') }}</span>
              </div>
              @if(request()->is('distributor-orders*'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('waybills*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/waybills">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:delivery-bold-duotone" class="shrink-0 text-xl {{ request()->is('waybills*') ? 'text-white' : 'text-purple-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Surat Jalan & Waybills') }}</span>
              </div>
              @if(request()->is('waybills*'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
        </ul>
      </div>

      <!-- Section 4: Inventory & Warehouse -->
      <div>
        <button type="button" 
          onclick="const el = document.getElementById('menu-inventory'); el.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180');" 
          class="w-full flex items-center justify-between px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md transition-colors select-none">
          <span>{{ __('Multi-Gudang & Stok') }}</span>
          <iconify-icon icon="solar:alt-arrow-down-bold" class="arrow-icon transition-transform text-xs text-slate-400 {{ request()->is('inventory*') ? 'rotate-180' : '' }}"></iconify-icon>
        </button>
        <ul id="menu-inventory" class="mt-1 space-y-1">
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('inventory/stocks*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/inventory/stocks">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:archive-bold-duotone" class="shrink-0 text-xl {{ request()->is('inventory/stocks*') ? 'text-white' : 'text-blue-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Saldo Stok Gudang') }}</span>
              </div>
              @if(request()->is('inventory/stocks*'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('inventory/item-ins*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/inventory/item-ins">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:import-bold-duotone" class="shrink-0 text-xl {{ request()->is('inventory/item-ins*') ? 'text-white' : 'text-emerald-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Barang Masuk (Inbound)') }}</span>
              </div>
              @if(request()->is('inventory/item-ins*'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('inventory/item-outs*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/inventory/item-outs">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:export-bold-duotone" class="shrink-0 text-xl {{ request()->is('inventory/item-outs*') ? 'text-white' : 'text-amber-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Barang Keluar (Outbound)') }}</span>
              </div>
              @if(request()->is('inventory/item-outs*'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
        </ul>
      </div>

      <!-- Section 5: Finance & Billing -->
      <div>
        <button type="button" 
          onclick="const el = document.getElementById('menu-finance'); el.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180');" 
          class="w-full flex items-center justify-between px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md transition-colors select-none">
          <span>{{ __('Keuangan & Faktur') }}</span>
          <iconify-icon icon="solar:alt-arrow-down-bold" class="arrow-icon transition-transform text-xs text-slate-400 {{ request()->is('finance*') ? 'rotate-180' : '' }}"></iconify-icon>
        </button>
        <ul id="menu-finance" class="mt-1 space-y-1">
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('finance/distributor-invoices*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/finance/distributor-invoices">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:bill-list-bold-duotone" class="shrink-0 text-xl {{ request()->is('finance/distributor-invoices*') ? 'text-white' : 'text-purple-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Faktur Distributor') }}</span>
              </div>
              @if(request()->is('finance/distributor-invoices*'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link flex items-center justify-between py-2.5 px-3.5 rounded-xl text-sm font-semibold transition-all {{ request()->is('finance/corporate-invoices*') ? 'active activemenu bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md' : 'text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" href="/finance/corporate-invoices">
              <div class="flex items-center gap-3">
                <iconify-icon icon="solar:bill-check-bold-duotone" class="shrink-0 text-xl {{ request()->is('finance/corporate-invoices*') ? 'text-white' : 'text-blue-600' }}"></iconify-icon>
                <span class="hide-menu shrink-0">{{ __('Tagihan Ongkir Logistik') }}</span>
              </div>
              @if(request()->is('finance/corporate-invoices*'))<span class="w-1.5 h-1.5 rounded-full bg-white/90"></span>@endif
            </a>
          </li>
        </ul>
      </div>

    </ul>
  </nav>
</div>
