

<?php $__env->startSection('title', 'VENDEDORES'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; VENDEDORES</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('CREAR VENDEDORES')): ?>
                <a href="<?php echo e(route('sellers.create')); ?>" class="btn btn-green">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nuevo
                </a>
                <?php endif; ?>
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                <table class="table tableusuarios table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Móviil</th>
                            
                            
                            <th>Email</th>
                            <th>Iniciales</th>
                            <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('VER DGI')): ?>
                            <th>DGI</th>
                            <?php endif; ?> -->
                            <th>Estado</th>
                           <th style="width : 20%;"> &nbsp;</th>
                            <th style="width : 20%;">-</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $Sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="text-center">
                            <td><?php echo e($row->folio); ?></td>
                            <td><?php echo e($row->seller_name); ?></td>
                            <td><?php echo e($row->seller_mobile); ?></td>
                            <td><?php echo e($row->seller_email); ?></td>
                            <td><?php echo e($row->iniciales); ?></td>
                            <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('VER DGI')): ?>
                            <td><?php echo e(number_format($row->dgi,2)); ?> %</td>
                            <?php endif; ?> -->
                            <td><?php echo e($row->status); ?></td>
                            <td >
                            <div class="col-6 text-center">
                                <a href="<?php echo e(route('sellers.customers',$row->id)); ?>">
                                        <button class="btn btn-blue " style="font-size:0.6vw">
                                                <i class="fas fa-users fa-lg"> </i> <br>
                                                Clientes
                                            </button></a>
                                            </div>
                            </td>
                            <td class="w-10">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('EDITAR VENDEDORES')): ?>
                                        <a href="<?php echo e(route('sellers.edit', $row->id)); ?>">
                                            <button  class="btn btn-blue ">
                                                <i class="fas fa-edit items-center fa-xl"></i>
                                            </button>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                    &nbsp; &nbsp;
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BORRAR VENDEDORES')): ?>
                                        <!-- <form class="DeleteReg" action="<?php echo e(route('sellers.destroy', $row->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-red ">
                                                <i class="fas fa-trash items-center fa-xl"></i>
                                            </button>
                                        </form> -->
                                        <?php endif; ?>
                                        
                                    
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/admin/sellers/index.blade.php ENDPATH**/ ?>