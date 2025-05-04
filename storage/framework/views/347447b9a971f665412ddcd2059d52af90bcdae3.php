

<?php $__env->startSection('title', 'CATEGORIAS'); ?>

<?php $__env->startSection('content_header'); ?>

    <h1 class="font-bold"><i class="fas fa-people-roof"></i>&nbsp; CATEGORIAS</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('CREAR FAMILIAS')): ?>
                <a href="<?php echo e(route('families.create')); ?>" class="btn btn-green">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nueva
                </a>
                <?php endif; ?>
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                <table class="table tablefamilies table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Categoria</th>
                            <th> </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <tr class="text-center">
                            <td>1</td>
                            <td>PRODUCTOS</td>
                            
                            <td class="w-20">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('EDITAR FAMILIAS')): ?>
                                        <a href="">
                                        <button class="btn btn-blue">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                    &nbsp; &nbsp;
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BORRAR FAMILIAS')): ?>
                                        <form class="DeleteReg" action="" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-red ">
                                                <i class="fas fa-trash items-center fa-xl"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>2</td>
                            <td>SERVICOS</td>
                            
                            <td class="w-20">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('EDITAR FAMILIAS')): ?>
                                        <a href="">
                                        <button class="btn btn-blue">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                    &nbsp; &nbsp;
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BORRAR FAMILIAS')): ?>
                                        <form class="DeleteReg" action="" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-red ">
                                                <i class="fas fa-trash items-center fa-xl"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                        </tr><tr class="text-center">
                            <td>3</td>
                            <td>INTEGRACION</td>
                            
                            <td class="w-20">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('EDITAR FAMILIAS')): ?>
                                        <a href="">
                                        <button class="btn btn-blue">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                    &nbsp; &nbsp;
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BORRAR FAMILIAS')): ?>
                                        <form class="DeleteReg" action="" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-red ">
                                                <i class="fas fa-trash items-center fa-xl"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tablecatalogofamilies.js')); ?>"></script>

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
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/admin/families/category.blade.php ENDPATH**/ ?>