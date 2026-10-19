<!DOCTYPE html>
<html lang="en" dir="ltr" data-color-theme="Blue_Theme" class="light selected" data-layout="vertical" data-boxed-layout="boxed" data-card="shadow">

<head>
    <?php if (isset($component)) { $__componentOriginal30de8f84a3b53438fc10f8a5d367579a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30de8f84a3b53438fc10f8a5d367579a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.head','data' => ['title' => $title ?? 'Corporate Merchant Portal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.head'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title ?? 'Corporate Merchant Portal')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal30de8f84a3b53438fc10f8a5d367579a)): ?>
<?php $attributes = $__attributesOriginal30de8f84a3b53438fc10f8a5d367579a; ?>
<?php unset($__attributesOriginal30de8f84a3b53438fc10f8a5d367579a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal30de8f84a3b53438fc10f8a5d367579a)): ?>
<?php $component = $__componentOriginal30de8f84a3b53438fc10f8a5d367579a; ?>
<?php unset($__componentOriginal30de8f84a3b53438fc10f8a5d367579a); ?>
<?php endif; ?>
</head>

<body class="DEFAULT_THEME bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100">
    <main>
        <div id="main-wrapper" class="flex relative">
            <!-- Sidebar -->
            <aside id="application-sidebar-brand" class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full xl:rtl:-translate-x-0 rtl:translate-x-full left-0 rtl:left-auto rtl:right-0 transform xl:translate-x-0 xl:end-auto xl:bottom-0 fixed top-0 left-0 transition-all duration-300 h-screen z-50 flex-shrink-0 flex flex-col overflow-hidden border-r rtl:border-l rtl:border-r-0 w-[270px] border-slate-200/60 dark:border-slate-800/60 bg-white dark:bg-slate-900 shadow-lg xl:shadow-none">
                <?php if (isset($component)) { $__componentOriginal2880b66d47486b4bfeaf519598a469d6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2880b66d47486b4bfeaf519598a469d6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2880b66d47486b4bfeaf519598a469d6)): ?>
<?php $attributes = $__attributesOriginal2880b66d47486b4bfeaf519598a469d6; ?>
<?php unset($__attributesOriginal2880b66d47486b4bfeaf519598a469d6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2880b66d47486b4bfeaf519598a469d6)): ?>
<?php $component = $__componentOriginal2880b66d47486b4bfeaf519598a469d6; ?>
<?php unset($__componentOriginal2880b66d47486b4bfeaf519598a469d6); ?>
<?php endif; ?>
            </aside>
            
            <div class="page-wrapper w-full xl:ml-[270px] xl:w-[calc(100%-270px)] min-h-screen flex flex-col relative" role="main">
                <!-- Header -->
                <header class="sticky top-0 inset-x-0 z-30 flex flex-wrap md:justify-start md:flex-nowrap text-sm bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200/60 dark:border-slate-800/60">
                    <div class="with-vertical w-full">
                        <?php if (isset($component)) { $__componentOriginalfd1f218809a441e923395fcbf03e4272 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfd1f218809a441e923395fcbf03e4272 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfd1f218809a441e923395fcbf03e4272)): ?>
<?php $attributes = $__attributesOriginalfd1f218809a441e923395fcbf03e4272; ?>
<?php unset($__attributesOriginalfd1f218809a441e923395fcbf03e4272); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfd1f218809a441e923395fcbf03e4272)): ?>
<?php $component = $__componentOriginalfd1f218809a441e923395fcbf03e4272; ?>
<?php unset($__componentOriginalfd1f218809a441e923395fcbf03e4272); ?>
<?php endif; ?>
                    </div>
                </header>

                <!-- Main Content -->
                <main class="max-w-full pt-4 flex-1">
                    <div class="container full-container py-5 px-4 md:px-6">
                        <?php echo e($slot); ?>

                    </div>
                </main>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <?php if (isset($component)) { $__componentOriginal217a6909b2c49cb97556df109e5b835d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal217a6909b2c49cb97556df109e5b835d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.scripts','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <?php echo e($scripts ?? ''); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal217a6909b2c49cb97556df109e5b835d)): ?>
<?php $attributes = $__attributesOriginal217a6909b2c49cb97556df109e5b835d; ?>
<?php unset($__attributesOriginal217a6909b2c49cb97556df109e5b835d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal217a6909b2c49cb97556df109e5b835d)): ?>
<?php $component = $__componentOriginal217a6909b2c49cb97556df109e5b835d; ?>
<?php unset($__componentOriginal217a6909b2c49cb97556df109e5b835d); ?>
<?php endif; ?>
</body>
</html>
<?php /**PATH D:\DevMuncen\CorporateFE\resources\views/components/layout/app.blade.php ENDPATH**/ ?>