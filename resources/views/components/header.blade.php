<div class="w-full mx-auto px-4 lg:py-3 py-2.5 lg:px-6 bg-white dark:bg-slate-900 border-b border-slate-200/80 dark:border-slate-800" aria-label="Global">
  <div class="relative flex items-center justify-between">
    <div class="flex items-center gap-3">
      <!-- Universal Sidebar Toggle -->
      <button type="button" 
        class="text-2xl icon-hover cursor-pointer text-slate-600 dark:text-slate-300 sidebartoggler h-9 w-9 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800 flex justify-center items-center rounded-xl transition-colors border-0 bg-transparent focus:outline-none shrink-0"
        onclick="window.toggleAnySidebar(event)" 
        aria-label="Toggle navigation">
        <iconify-icon icon="solar:hamburger-menu-linear" class="relative z-1 text-xl"></iconify-icon>
      </button>

      <!-- Quick Search Bar -->
      <div class="hidden md:flex items-center">
        <div class="relative w-64 lg:w-72" id="corp-global-search-wrap">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-slate-400">
            <iconify-icon icon="solar:magnifer-linear" class="text-base"></iconify-icon>
          </div>
          <input id="corp-global-search" type="text" autocomplete="off" placeholder="{{ __('Cari SKU, Gudang, Waybill, Faktur...') }}" class="form-control !ps-10 !pl-10 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 w-full transition-all">
          <div id="corp-search-results" class="hidden absolute left-0 right-0 mt-1.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl z-50 overflow-hidden text-xs max-h-72 overflow-y-auto"></div>
        </div>
      </div>
    </div>

    <div class="icon-nav items-center gap-2.5 flex">
      <!-- Language Switcher -->
      <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
        <button id="hs-dropdown-language" type="button" class="hs-dropdown-toggle icon-hover flex cursor-pointer group items-center font-bold hover:text-blue-600 dark:hover:text-blue-400 text-slate-700 dark:text-slate-200 h-9 px-3 hover:bg-slate-100 dark:hover:bg-slate-800 justify-center rounded-xl text-xs gap-1.5 border border-slate-200 dark:border-slate-700 transition-colors">
          <iconify-icon icon="solar:global-linear" class="text-base text-blue-600 dark:text-blue-400"></iconify-icon>
          <span class="font-extrabold uppercase tracking-wider">{{ session('locale', 'id') }}</span>
          <iconify-icon icon="solar:alt-arrow-down-bold" class="text-xs"></iconify-icon>
        </button>
        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-[140px] bg-white shadow-lg rounded-xl p-1.5 mt-2 dark:bg-slate-800 dark:border dark:border-slate-700 z-50" aria-labelledby="hs-dropdown-language">
          <a href="{{ route('lang.switch', 'id') }}" class="flex items-center gap-2 py-1.5 px-3 rounded-lg text-xs text-slate-700 hover:bg-blue-50 dark:text-slate-200 dark:hover:bg-slate-700 {{ session('locale', 'id') === 'id' ? 'font-bold text-blue-600 bg-blue-50 dark:bg-blue-900/40 dark:text-blue-300' : '' }}">
            <span>🇮🇩 ID (Bahasa)</span>
          </a>
          <a href="{{ route('lang.switch', 'en') }}" class="flex items-center gap-2 py-1.5 px-3 rounded-lg text-xs text-slate-700 hover:bg-blue-50 dark:text-slate-200 dark:hover:bg-slate-700 {{ session('locale') === 'en' ? 'font-bold text-blue-600 bg-blue-50 dark:bg-blue-900/40 dark:text-blue-300' : '' }}">
            <span>🇬🇧 EN (English)</span>
          </a>
        </div>
      </div>

      <!-- Theme Toggle (Moon / Sun) -->
      <button type="button" class="hs-dark-mode-active:hidden icon-hover flex cursor-pointer hs-dark-mode group items-center font-medium hover:text-blue-600 text-slate-600 dark:text-slate-300 h-9 w-9 hover:bg-slate-100 dark:hover:bg-slate-800 justify-center rounded-xl border border-slate-200 dark:border-slate-700 transition-colors" data-hs-theme-click-value="dark" id="dark-layout" title="Switch to Dark Mode">
        <iconify-icon icon="solar:moon-linear" class="text-lg relative"></iconify-icon>
      </button>
      <button type="button" class="hs-dark-mode-active:flex cursor-pointer icon-hover hidden hs-dark-mode group items-center font-medium hover:text-amber-400 text-slate-300 h-9 w-9 hover:bg-slate-800 justify-center rounded-xl border border-slate-700 transition-colors" data-hs-theme-click-value="light" id="light-layout" title="Switch to Light Mode">
        <iconify-icon icon="solar:sun-2-linear" class="text-lg relative text-amber-400"></iconify-icon>
      </button>

      <!-- Profile Avatar Dropdown -->
      <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
        <button id="hs-dropdown-with-header" type="button" class="hs-dropdown-toggle inline-flex justify-center items-center h-9 w-9 rounded-xl p-0.5 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 focus:outline-none dark:hover:bg-slate-800 overflow-hidden shrink-0">
          <div class="w-full h-full rounded-lg bg-gradient-to-tr from-blue-900 to-indigo-800 flex items-center justify-center text-white font-bold text-xs">
            {{ strtoupper(substr(session('user_name', 'C'), 0, 1)) }}
          </div>
        </button>

        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-[220px] bg-white shadow-xl rounded-2xl p-2 mt-2 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 z-50" aria-labelledby="hs-dropdown-with-header">
          <div class="py-2 px-3 border-b border-slate-100 dark:border-slate-700">
            <p class="text-xs font-bold text-slate-800 dark:text-slate-100">{{ session('user_name', 'Corporate Merchant') }}</p>
            <p class="text-[10px] text-slate-500 dark:text-slate-400">{{ session('user_email', 'korporasi@muncen.com') }}</p>
            @php
              $r = session('user_role');
              $roleLabel = match($r) {
                'corporate_admin' => 'PIC Admin',
                'corporate_inventory' => 'Staf Inventori',
                'corporate_operations' => 'Staf Operasional',
                'corporate_finance' => 'Staf Keuangan',
                default => 'Staf Korporasi',
              };
              $roleBadgeColor = match($r) {
                'corporate_admin' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-300',
                'corporate_inventory' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300',
                'corporate_operations' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300',
                'corporate_finance' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/60 dark:text-purple-300',
                default => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
              };
            @endphp
            <div class="flex items-center gap-1.5 mt-1.5 flex-wrap">
              <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-bold {{ $roleBadgeColor }}">
                {{ $roleLabel }}
              </span>
              <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300">
                {{ session('corporate_name') ?: 'Tenant #' . session('corporate_id', '1') }}
              </span>
            </div>
          </div>

          <div class="py-1">
            <a href="/dashboard" class="flex items-center gap-2 py-1.5 px-3 rounded-lg text-xs text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700">
              <iconify-icon icon="solar:user-bold-duotone" class="text-base text-blue-600"></iconify-icon>
              <span>Profil Korporasi</span>
            </a>
          </div>

          <div class="pt-1 border-t border-slate-100 dark:border-slate-700">
            <form method="POST" action="/logout">
              @csrf
              <button type="submit" class="w-full flex items-center gap-2 py-1.5 px-3 rounded-lg text-xs text-red-600 hover:bg-red-50 dark:hover:bg-red-950/40 font-bold transition-colors">
                <iconify-icon icon="solar:logout-2-bold-duotone" class="text-base"></iconify-icon>
                <span>Keluar (Logout)</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  (function() {
    const input = document.getElementById('corp-global-search');
    const box = document.getElementById('corp-search-results');
    const wrap = document.getElementById('corp-global-search-wrap');
    if (!input || !box) return;

    @php
      $cRole = session('user_role');
      $cIsAdmin = ($cRole === 'corporate_admin' || !session()->has('user_role'));
      $cCanCatalog = $cIsAdmin || in_array($cRole, ['corporate_inventory', 'corporate_operations', 'corporate_user']);
      $cCanOps = $cIsAdmin || in_array($cRole, ['corporate_operations', 'corporate_user']);
      $cCanInv = $cIsAdmin || in_array($cRole, ['corporate_inventory', 'corporate_user']);
      $cCanFin = $cIsAdmin || in_array($cRole, ['corporate_finance']);
      $cCanUsers = $cIsAdmin;

      $corpRoutes = [
        ['label' => 'Dashboard', 'kw' => 'dashboard beranda ringkasan', 'url' => '/dashboard'],
      ];
      if ($cCanCatalog) {
        $corpRoutes[] = ['label' => 'Katalog SKU & Produk', 'kw' => 'sku produk barang katalog', 'url' => '/products'];
        $corpRoutes[] = ['label' => 'Kategori Produk', 'kw' => 'kategori produk', 'url' => '/product-categories'];
        $corpRoutes[] = ['label' => 'Hub & Gudang', 'kw' => 'hub gudang warehouse', 'url' => '/warehouses'];
        $corpRoutes[] = ['label' => 'Pelanggan & Mitra Distribusi', 'kw' => 'pelanggan distributor customer mitra', 'url' => '/customers'];
        $corpRoutes[] = ['label' => 'Vendor Logistik', 'kw' => 'vendor logistik kurir', 'url' => '/logistics'];
      }
      if ($cCanOps) {
        $corpRoutes[] = ['label' => 'Pesanan Pelanggan (PO)', 'kw' => 'po pesanan pelanggan order', 'url' => '/customer-orders'];
        $corpRoutes[] = ['label' => 'Request Orders (RO)', 'kw' => 'ro request order pengiriman', 'url' => '/request-orders'];
        $corpRoutes[] = ['label' => 'Surat Jalan & Waybills', 'kw' => 'waybill surat jalan awb', 'url' => '/waybills'];
      }
      if ($cCanInv) {
        $corpRoutes[] = ['label' => 'Saldo Stok Gudang', 'kw' => 'stok saldo gudang inventory', 'url' => '/inventory/stocks'];
        $corpRoutes[] = ['label' => 'Barang Masuk (Inbound)', 'kw' => 'inbound barang masuk penerimaan', 'url' => '/inventory/item-ins'];
        $corpRoutes[] = ['label' => 'Barang Keluar (Outbound)', 'kw' => 'outbound barang keluar', 'url' => '/inventory/item-outs'];
      }
      if ($cCanFin) {
        $corpRoutes[] = ['label' => 'Faktur Penagihan Customer', 'kw' => 'faktur invoice penagihan customer distributor', 'url' => '/finance/distributor-invoices'];
        $corpRoutes[] = ['label' => 'Tagihan Ongkir Logistik', 'kw' => 'tagihan ongkir invoice logistik', 'url' => '/finance/corporate-invoices'];
        $corpRoutes[] = ['label' => 'Rekening Bank & VA', 'kw' => 'rekening bank va', 'url' => '/finance/bank-accounts'];
      }
      if ($cCanUsers) {
        $corpRoutes[] = ['label' => 'Manajemen Pengguna', 'kw' => 'user pengguna akun', 'url' => '/users'];
        $corpRoutes[] = ['label' => 'Integrasi & External API', 'kw' => 'integrasi api webhook', 'url' => '/integrations'];
      }
    @endphp

    const routes = @json($corpRoutes);
    const canCatalog = @json($cCanCatalog);
    const canOps = @json($cCanOps);

    const render = (q) => {
      const term = (q || '').trim().toLowerCase();
      if (!term) { box.classList.add('hidden'); return; }
      const matches = routes.filter(r => r.label.toLowerCase().includes(term) || r.kw.includes(term)).slice(0, 6);
      const extras = [];
      if (canCatalog) extras.push({ label: `Cari Produk / SKU: "${q.trim()}"`, url: `/products?search=${encodeURIComponent(q.trim())}` });
      if (canOps) extras.push({ label: `Cari Waybill: "${q.trim()}"`, url: `/waybills?search=${encodeURIComponent(q.trim())}` });
      const all = [...matches, ...extras];
      box.innerHTML = all.length ? all.map(item => `
        <a href="${item.url}" class="flex items-center justify-between px-3.5 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border-b last:border-b-0 border-slate-100 dark:border-slate-700">
          <span class="font-semibold">${item.label}</span>
          <span class="text-[10px] text-slate-400">Buka →</span>
        </a>`).join('') : '<div class="px-3.5 py-3 text-slate-400">Tidak ada menu yang sesuai hak akses Anda.</div>';
      box.classList.remove('hidden');
    };

    input.addEventListener('input', (e) => render(e.target.value));
    input.addEventListener('focus', (e) => { if (e.target.value.trim()) render(e.target.value); });
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        const first = box.querySelector('a');
        if (first) window.location.href = first.getAttribute('href');
      } else if (e.key === 'Escape') {
        box.classList.add('hidden');
      }
    });
    document.addEventListener('click', (e) => {
      if (wrap && !wrap.contains(e.target)) box.classList.add('hidden');
    });
  })();
</script>
