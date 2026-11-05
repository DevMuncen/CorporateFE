<!DOCTYPE html>
<html lang="en" dir="ltr" data-color-theme="Blue_Theme" class="light selected" data-layout="vertical" data-boxed-layout="boxed" data-card="shadow">

<head>
    <x-layout.head :title="$title ?? 'Corporate Merchant Portal'" />
</head>

<body class="DEFAULT_THEME bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100">
    <main>
        <div id="main-wrapper" class="flex relative">
            <!-- Sidebar -->
            <aside id="application-sidebar-brand" class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full xl:rtl:-translate-x-0 rtl:translate-x-full left-0 rtl:left-auto rtl:right-0 transform xl:translate-x-0 xl:end-auto xl:bottom-0 fixed top-0 left-0 transition-all duration-300 h-screen z-50 flex-shrink-0 flex flex-col overflow-hidden border-r rtl:border-l rtl:border-r-0 w-[270px] border-slate-200/60 dark:border-slate-800/60 bg-white dark:bg-slate-900 shadow-lg xl:shadow-none">
                <x-sidebar />
            </aside>
            
            <div class="page-wrapper w-full xl:ml-[270px] xl:w-[calc(100%-270px)] min-h-screen flex flex-col relative transition-all duration-300" role="main">
                <!-- Header -->
                <header class="sticky top-0 inset-x-0 z-30 flex flex-wrap md:justify-start md:flex-nowrap text-sm bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200/60 dark:border-slate-800/60">
                    <div class="with-vertical w-full">
                        <x-header />
                    </div>
                </header>

                <!-- Main Content -->
                <main class="max-w-full pt-4 flex-1">
                    <div class="container full-container py-5 px-4 md:px-6">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <x-layout.scripts>
        {{ $scripts ?? '' }}
    </x-layout.scripts>
</body>
</html>
