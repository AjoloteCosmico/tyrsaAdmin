

<?php $__env->startSection('title', 'NOTAS DE CREDITO'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fa-solid fa-clipboard-check"></i>&nbsp; NOTAS DE CREDITO</h1>
    <script src="/Scripts/jquery.dataTables.js"></script>
<script src="/Scripts/dataTables.bootstrap.js"></script>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
            <a href="<?php echo e(route('reports.generate',[0,'resumen_nota',0])); ?>" class="btn btn-blue">
                    <i class="fa-solid fa-eye"></i>&nbsp; Resumen
                </a> 
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('CREAR NOTAS')): ?>
                <a href="<?php echo e(route('credit_notes.create')); ?>" class="btn btn-green">
                    <i class="fa-solid fa-plus-circle"></i>&nbsp; Nuevo
                </a>

                <?php endif; ?>
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-6 col-sm-12 table-responsive">
                <table class="table tablefactures table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>PDA</th>
                            <th>FECHA </th>
                            <th>NOTA </th>
                            <th>CLIENTE</th>
                            <th>IMPORTE </th>
                            <th>Estatus</th>
                            <th></th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i=1;
                        ?>
                        <?php $__currentLoopData = $Notas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr class="text-center">
                          <td><?php echo e($i); ?></td>
                          <td><?php echo e($nota->date); ?></td>
                          <td><?php echo e($nota->credit_note); ?></td>
                          <td><?php echo e($nota->customer); ?></td>
                          <td> $ <?php echo e(number_format($nota->amount,2)); ?> </td>
                          <td><?php echo e($nota->status); ?> </td>
                          <td></td>
                          <td> <div class="row">
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('EDITAR NOTAS')): ?>
                                        <a href="<?php echo e(route('credit_notes.edit', $nota->id)); ?>">
                                        <button class="btn btn-blue">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                    &nbsp; &nbsp;
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BORRAR NOTAS')): ?>
                                        <form class="DeleteReg" action="<?php echo e(route('credit_notes.destroy', $nota->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-red ">
                                                <i class="fas fa-trash items-center fa-xl"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                        </div>
                                        
                                    <div class="col-6 text-center w-10">
                                        <a href="<?php echo e(route('credit_notes.show', $nota->id)); ?>">
                                        <button class="btn btn-blue">
                                                <i class="fas fa-xl fa-eye"> </i> </button>
                                            </a>
                                            
                                        <a href="<?php echo e(route('note_pdf', $nota->id)); ?>">
                                        <button class="btn btn-red">
                                                <i class="fa fa-xl fa-file-pdf-o">pdf </i> 
                                        </button></a>
                                            </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <?php
                            $i=$i+1;
                       ?>
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
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tablecatalogofactures.js')); ?>"></script>

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
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/credit_notes/index.blade.php ENDPATH**/ ?>