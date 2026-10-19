<div class="w-full mx-auto px-4 lg:py-3 py-2.5 lg:px-6 bg-white dark:bg-slate-900 border-b border-slate-200/80 dark:border-slate-800" aria-label="Global">
  <div class="relative flex items-center justify-between">
    <div class="flex items-center gap-3">
      <!-- Navigation Toggle -->
      <a class="text-2xl icon-hover cursor-pointer text-slate-600 dark:text-slate-300 sidebartoggler h-9 w-9 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800 flex justify-center items-center rounded-xl transition-colors"
        data-hs-overlay="#application-sidebar-brand" aria-controls="application-sidebar-brand" aria-label="Toggle navigation">
        <iconify-icon icon="solar:hamburger-menu-linear" class="relative z-1"></iconify-icon>
      </a>

      <!-- Quick Search Bar -->
      <div class="hidden md:flex items-center">
        <div class="relative w-64 lg:w-72">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-slate-400">
            <iconify-icon icon="solar:magnifer-linear" class="text-base"></iconify-icon>
          </div>
          <input type="text" placeholder="{{ __('Cari SKU, Gudang, Waybill...') }}" class="form-control ps-9 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 w-full transition-all">
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

      <!-- Notifications Bell -->
      <div class="hs-dropdown relative inline-flex">
        <button type="button" class="icon-hover flex cursor-pointer items-center justify-center relative h-9 w-9 rounded-xl text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 transition-colors" title="Notifications">
          <iconify-icon icon="solar:bell-linear" class="text-lg"></iconify-icon>
          <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
          </span>
        </button>
      </div>

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
            <span class="inline-block mt-1 px-2 py-0.5 rounded-md text-[9px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300">
              Corporate Tenant #{{ session('corporate_id', '1') }}
            </span>
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
