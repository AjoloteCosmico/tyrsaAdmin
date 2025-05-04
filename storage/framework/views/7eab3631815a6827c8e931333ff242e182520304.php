

<?php $__env->startSection('title', 'VENDEDORES'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; CLEINTES DEL VENDEDOR <?php echo e($Seller->seller_name); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            
            <div class="col-sm-12 table-responsive">
            <form action="<?php echo e(route('sellers.update_customers',$Seller->id)); ?>" method="POST" enctype="multipart/form-data">
                 <?php echo csrf_field(); ?>
       
            <table class="table  tableusuarios table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>Clave</th>
                            <th>Nombre</th>
                            <th>Nombre Corto</th>
                            <th>Seleccionar</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $Customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="text-center">
                        <td class="w-10"> <p style="color:rgba(255,255,255,0.04)">
                            <?php if($row->seller_id == $Seller->id): ?>  a <?php endif; ?> z</p>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ASIGNAR CLIENTES')): ?>
                                        <input type="checkbox" name="customers[]" value="<?php echo e($row->id); ?>" <?php if($row->seller_id == $Seller->id): ?> checked <?php endif; ?>>
                                        <?php endif; ?>
                                        
                                    
                            </td>    
                        <td><?php echo e($row->clave); ?></td>
                            <td><?php echo e($row->customer); ?></td>
                            <td><?php echo e($row->alias); ?></td>
                           
                            
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <div class="col-12 text-right p-2 gap-2">
                <a href="<?php echo e(route('sellers.customers',$Seller->id)); ?>" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>
                <button type="submit" class="btn btn-green mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Guardar
                </button>
            </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tablecatalogosellers.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tablecatalogousers.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/alert_delete_reg.js')); ?>"></script>

<?php if(session('create_reg') == 'ok'): ?>
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/confirm_create_reg.js')); ?>"></script>
<?php endif; ?>

<?php if(session('eliminar') == 'ok'): ?>
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/confirm_delete_reg.js')); ?>"></script>
<?php endif; ?>

<?php if(session('error_delete') == 'ok'): ?>
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/error_delete_reg.js')); ?>"></script>
<?php endif; ?>

<?php if(session('update_reg') == 'ok'): ?>
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/update_reg.js')); ?>"></script>
<?php endif; ?>

<script>
    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/admin/sellers/asign.blade.php ENDPATH**/ ?>