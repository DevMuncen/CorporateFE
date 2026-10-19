<!DOCTYPE html>
<html lang="en" dir="ltr" data-color-theme="Blue_Theme" class="light selected">

<head>
    <?php if (isset($component)) { $__componentOriginal30de8f84a3b53438fc10f8a5d367579a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30de8f84a3b53438fc10f8a5d367579a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.head','data' => ['title' => 'Login | Corporate Merchant Portal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.head'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Login | Corporate Merchant Portal']); ?>
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

<body class="DEFAULT_THEME bg-white dark:bg-dark">
    <main class="h-screen w-full bg-lightprimary">
        <div class="h-full w-full flex justify-center items-center">
            <div class="flex justify-center w-full">
                <div class="xl:w-2/6 w-full">
                    <div class="max-w-[460px] px-4 mx-auto">
                        <div class="card bg-white dark:bg-dark shadow-xl shadow-slate-200/50 dark:shadow-none rounded-2xl border border-slate-100 dark:border-slate-800">
                            <div class="card-body p-6 sm:p-8">
                                <div class="mx-auto text-center mb-7">
                                    <div class="flex justify-center mb-3">
                                        <!-- Clean modern borderless logo constrained to compact 48px -->
                                        <img src="<?php echo e(asset('assets/images/logos/corporate-logo-b.png')); ?>" 
                                             alt="Corporate Logo" 
                                             width="48" 
                                             height="48"
                                             style="height: 48px; width: 48px; max-height: 48px; max-width: 48px; object-fit: contain;"
                                             class="h-12 w-12 object-contain dark:hidden drop-shadow-sm transition-transform hover:scale-105 duration-200" 
                                             onerror="this.onerror=null; this.src='<?php echo e(asset('assets/images/logos/logoIcon.svg')); ?>';" />
                                        <img src="<?php echo e(asset('assets/images/logos/corporate-logo-w.png')); ?>" 
                                             alt="Corporate Logo" 
                                             width="48" 
                                             height="48"
                                             style="height: 48px; width: 48px; max-height: 48px; max-width: 48px; object-fit: contain;"
                                             class="h-12 w-12 object-contain hidden dark:block drop-shadow-sm transition-transform hover:scale-105 duration-200" 
                                             onerror="this.onerror=null; this.src='<?php echo e(asset('assets/images/logos/logoIcon.svg')); ?>';" />
                                    </div>
                                    <h4 class="text-xl font-bold text-gray-800 dark:text-white tracking-tight">Corporate Merchant Portal</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sign in to manage catalog, multi-warehouse &amp; request orders</p>
                                </div>
                                
                                <?php if(session('error')): ?>
                                    <div class="mb-4 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/60 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl text-xs font-semibold" role="alert">
                                        <span><?php echo e(session('error')); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if(session('success')): ?>
                                    <div class="mb-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl text-xs font-semibold" role="alert">
                                        <span><?php echo e(session('success')); ?></span>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" action="/login" id="loginForm">
                                    <?php echo csrf_field(); ?>
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <label class="text-xs font-bold uppercase tracking-wider text-dark dark:text-darklink mb-1.5 block">Email / Username</label>
                                            <input type="text" name="email" required class="form-control py-2.5 px-3.5 w-full text-sm rounded-xl border border-gray-200 dark:border-gray-700" placeholder="Masukkan email atau username Anda" />
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold uppercase tracking-wider text-dark dark:text-darklink mb-1.5 block">Password</label>
                                            <input type="password" name="password" required class="form-control py-2.5 px-3.5 w-full text-sm rounded-xl border border-gray-200 dark:border-gray-700" placeholder="Masukkan kata sandi Anda" />
                                        </div>
                                        <button type="submit" class="btn btn-primary w-full py-2.5 mt-2 rounded-xl text-white font-bold text-sm bg-primary hover:bg-primaryemphasis shadow-md shadow-primary/25 transition-all">
                                            Sign In
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
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
<?php /**PATH D:\DevMuncen\CorporateFE\resources\views/auth/login.blade.php ENDPATH**/ ?>