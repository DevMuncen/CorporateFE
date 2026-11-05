<!-- Required meta tags -->
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? 'Corporate Merchant Portal' }}</title>

<!-- Favicon icon-->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/logos/favicon.png') }}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">

<!-- Early Theme Initialization (prevents FOUC & ensures dark/light class is present) -->
<script>
(function() {
    try {
        var saved = localStorage.getItem('hs_theme');
        var html = document.documentElement;
        if (saved === 'dark') {
            html.classList.add('dark');
            html.classList.remove('light');
        } else {
            html.classList.remove('dark');
            html.classList.add('light');
        }
    } catch (e) {}
})();
</script>

<!-- Core Css (Theme defaults not handled by Vite/Tailwind) -->
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />

<!-- Vite Config -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Universal Backdrop Neutralizer & Desktop Sidebar Guarantee -->
<style>
.hs-overlay-backdrop,
div[data-hs-overlay-backdrop-template],
.hs-overlay-backdrop-open {
    display: none !important;
    pointer-events: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    z-index: -99999 !important;
    width: 0 !important;
    height: 0 !important;
}
body.has-modal-open {
    overflow: hidden;
}

/* Permanent Desktop Sidebar Guarantee - Prevents any accidental display:none or empty gap */
@media (min-width: 1280px) {
    #application-sidebar-brand {
        display: flex !important;
        position: fixed !important;
        top: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        width: 270px !important;
        height: 100vh !important;
        z-index: 40 !important;
        visibility: visible !important;
        opacity: 1 !important;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    [dir="rtl"] #application-sidebar-brand {
        left: auto !important;
        right: 0 !important;
    }
    #application-sidebar-brand.desktop-sidebar-collapsed {
        transform: translateX(-100%) !important;
    }
    [dir="rtl"] #application-sidebar-brand.desktop-sidebar-collapsed {
        transform: translateX(100%) !important;
    }
    #application-sidebar-brand:not(.desktop-sidebar-collapsed) {
        transform: translateX(0) !important;
    }
    
    .page-wrapper {
        transition: margin 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    #application-sidebar-brand.desktop-sidebar-collapsed ~ .page-wrapper {
        margin-left: 0px !important;
        width: 100% !important;
    }
    [dir="rtl"] #application-sidebar-brand.desktop-sidebar-collapsed ~ .page-wrapper {
        margin-right: 0px !important;
        width: 100% !important;
    }
    #application-sidebar-brand:not(.desktop-sidebar-collapsed) ~ .page-wrapper {
        margin-left: 270px !important;
        width: calc(100% - 270px) !important;
    }
    [dir="rtl"] #application-sidebar-brand:not(.desktop-sidebar-collapsed) ~ .page-wrapper {
        margin-right: 270px !important;
        margin-left: 0 !important;
        width: calc(100% - 270px) !important;
    }
}
</style>
