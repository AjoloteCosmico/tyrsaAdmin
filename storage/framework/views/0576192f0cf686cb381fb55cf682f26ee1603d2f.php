

<?php $__env->startSection('title', 'PERFIL DE COMPAÑÍA'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-industry"></i>&nbsp; COMPAÑÍA</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('CREAR EMPRESAS')): ?>
                <?php if($CompanyProfiles): ?>
                    <a class="btn btn-disabled">
                        <i class="fas fa-plus-circle"></i>&nbsp; Agregar
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('company_profiles.create')); ?>" class="btn btn-green">
                        <i class="fas fa-plus-circle"></i>&nbsp; Agregar
                    </a>
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                <table class="table tablecompanyprofile table-striped text-xs font-medium">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Empresa</th>
                            <th>Eslogan</th>
                            <th>RFC</th>
                            <th>Estado</th>
                            <th>Municipio</th>
                            <th>Colonia</th>
                            <th>Calle</th>
                            <th>Exterior</th>
                            <th>Interior</th>
                            <th>CP</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Teléfono 2</th>
                            <th>Web</th>
                            <th>Logo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $CompanyProfiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($row->id); ?></td>
                            <td><?php echo e($row->company); ?></td>
                            <td><?php echo e($row->motto); ?></td>
                            <td><?php echo e($row->rfc); ?></td>
                            <td><?php echo e($row->state); ?></td>
                            <td><?php echo e($row->city); ?></td>
                            <td><?php echo e($row->suburb); ?></td>
                            <td><?php echo e($row->street); ?></td>
                            <td><?php echo e($row->outdoor); ?></td>
                            <td><?php echo e($row->intdoor); ?></td>
                            <td><?php echo e($row->zip_code); ?></td>
                            <td><?php echo e($row->email); ?></td>
                            <td><?php echo e($row->telephone); ?></td>
                            <td><?php echo e($row->telephone2); ?></td>
                            <td><?php echo e($row->website); ?></td>
                            <td><?php echo e($row->logo); ?></td>
                            <td class="w-10">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('EDITAR EMPRESAS')): ?>
                                        <a href="<?php echo e(route('company_profiles.edit', $row->id)); ?>">
                                        <button class="btn btn-blue">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BORRAR EMPRESAS')): ?>
                                        <form class="DeleteReg" action="<?php echo e(route('company_profiles.destroy', $row->id)); ?>" method="POST">
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
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tablecatalogocompany_profiles.js')); ?>"></script>

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
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/admin/company_profile/index.blade.php ENDPATH**/ ?>