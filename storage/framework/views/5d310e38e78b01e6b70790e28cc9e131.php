<script src="<?php echo e(asset('assets/js/vendor.min.js')); ?>?v=<?php echo e(time()); ?>"></script>
<script src="<?php echo e(asset('assets/js/theme/app.init.js')); ?>?v=<?php echo e(time()); ?>"></script>
<script src="<?php echo e(asset('assets/js/theme/app.min.js')); ?>?v=<?php echo e(time()); ?>"></script>
<script src="<?php echo e(asset('assets/js/theme.js')); ?>?v=<?php echo e(time()); ?>"></script>

<!-- Solar Icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

<!-- SweetAlert2 (Standardized Alert Engine) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php echo e($slot ?? ''); ?>

<?php echo $__env->yieldPushContent('scripts'); ?>
<?php /**PATH D:\DevMuncen\CorporateFE\resources\views/components/layout/scripts.blade.php ENDPATH**/ ?>