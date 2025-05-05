

<?php $__env->startSection('title', 'CLIENTES'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; CLIENTES</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('CREAR CLIENTES')): ?>
                <a href="<?php echo e(route('customers.validar_rfc')); ?>" class="btn btn-green">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nueva
                </a>
                <?php endif; ?>
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                
            <table id="example"  class="table table-striped text-xs font-medium" >
                    <thead>
                        <tr>
                            
                            <th>Clave</th>
                            <th>Razón Social</th>
                            
                            <th>Regimen de Capital</th>
                            <th>Nombre Corto</th>
                            <th>RFC</th>
                            <th>Municipio</th>
                            
                            <th>Teléfono</th>
                            <th> Vendedor</th>
                            <th style="width : 10%;">&nbsp;&nbsp; </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $Customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($row->clave); ?></td>
                            <td style="word-wrap: break-word; width: 20.3vh"><?php echo e($row->customer); ?></td>
                            
                            <td><?php echo e($row->legal_name); ?></td>
                            <td><?php echo e($row->alias); ?></td>
                            <td><?php echo e($row->customer_rfc); ?></td>
                            <!-- <td><?php echo e($row->customer_state); ?></td> -->
                            <td><?php echo e($row->customer_city); ?></td>
                            <!-- <td><?php echo e($row->customer_email); ?></td> -->
                            <td><?php echo e($row->customer_telephone); ?></td>
                            <td>
                                <?php if($row->iniciales): ?> <?php echo e($row->iniciales); ?>

                                <?php else: ?>  
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ASIGNAR CLIENTES')): ?>
                                        <div >
                                        <a href="<?php echo e(route('customers.select_seller', $row->id)); ?>">
                                        <button type="button" class="btn btn-blue " style="font-size: 0.5vw;">
                                                <i class="fas fa-user items-center fa-lg"></i> Asignar
                                            </button>
                                        </a></div>
                                        <?php endif; ?>
                                     <?php endif; ?>
                            </td>
                            <td class="w-15">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('EDITAR CLIENTES')): ?>
                                        <a href="<?php echo e(route('customers.edit', $row->id)); ?>">
                                        <button type="submit" class="btn btn-blue ">
                                                <i class="fas fa-edit items-center fa-xl"></i>
                                            </button>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                    &nbsp;&nbsp;
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BORRAR CLIENTES')): ?>
                                        <form class="DeleteReg" action="<?php echo e(route('customers.destroy', $row->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-red">
                                                <i class="fas fa-trash items-center fa-xl"></i>
                                            </button>
                                        </form>
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
<script>

$(document).ready(function () {
    $('#example').DataTable();
});
</script>

<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tablecatalogocustomers.js')); ?>"></script>

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
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/admin/customers/index.blade.php ENDPATH**/ ?>