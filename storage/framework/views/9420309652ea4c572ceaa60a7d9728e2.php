<!-- Required meta tags -->
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<title><?php echo e($title ?? 'Corporate Merchant Portal'); ?></title>

<!-- Favicon icon-->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>" />
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('assets/images/logos/favicon.png')); ?>" />
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('apple-touch-icon.png')); ?>" />
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
<link rel="stylesheet" href="<?php echo e(asset('assets/css/theme.css')); ?>" />

<!-- Vite Config -->
<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

<!-- Universal Backdrop Neutralizer (Prevents any Preline backdrop from blocking picker clicks) -->
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
</style>
<?php /**PATH D:\DevMuncen\CorporateFE\resources\views/components/layout/head.blade.php ENDPATH**/ ?>