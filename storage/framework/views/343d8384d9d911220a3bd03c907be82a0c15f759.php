

<?php $__env->startSection('title', 'Configuración'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-cogs"></i> TYRSAWES - ADMIN</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10 p-3 m-2 rounded-lg shadow-xl bg-white">
                <div class="card-header">
                    <h4 class="font-bold text-center uppercase"></h4>
                </div>
                <div class="card-body">
                    <center>
                        <img src="<?php echo e(asset('vendor/img/logo.png')); ?>" width="500" class="text-center" alt="logo">
                    </center>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/admin/index.blade.php ENDPATH**/ ?>