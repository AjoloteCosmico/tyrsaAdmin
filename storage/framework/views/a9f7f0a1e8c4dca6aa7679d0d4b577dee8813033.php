

<?php $__env->startSection('title', 'COBROS'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fa fa-money"></i>&nbsp; COBROS</h1>
    <script src="/Scripts/jquery.dataTables.js"></script>
<script src="/Scripts/dataTables.bootstrap.js"></script>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
            <a href="<?php echo e(route('reports.generate',[0,'resumen_comprobante',0])); ?>" class="btn btn-blue">
                    <i class="fa-solid fa-eye"></i>&nbsp; Resumen
                </a>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('CREAR COBROS')): ?>
                <a href="<?php echo e(route('cobros.create')); ?>" class="btn btn-green">
                    <i class="fa-solid fa-plus-circle"></i>&nbsp; Nuevo
                </a>
                <?php endif; ?>
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-6 col-sm-12 table-responsive">
                <table class="table tablefactures table-striped text-xs text-center font-medium">
                    <thead>
                        <tr   class="text-center">
                            <th  >PDA</th>
                            <th  >NO. COMP</th>
                            <th  >FECHA EMISION</th>
                            <th  >FACTURA</th>
                            
                            <th  >CLIENTE </th>
                            <th  >P.I.</th>
                            <th  >BANCO</th>
                            <th  >MONEDA</th>
                            <th  >TC</th>
                            
                            <TH>DLL</TH>
                            <TH>M.N.</TH>
                            
                           
                            <th  >CAPTURO </th>
                            <th  >REVISO</th>
                            <th  >AUTORIZO</th>
                            <th  > </th>
                           
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            $i=1;
                        
                        ?>

                        <?php $__currentLoopData = $Cobros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr <?php if($FacturasCobradas->where('cobro_id',$c->id)->count()==0): ?> style="color:red; --bs-table-striped-color: red;" <?php endif; ?>>
                        <td ><?php echo e($c->id); ?> </td>
                        <td><?php echo e($c->comp); ?> </td>
                        <td><?php echo e($c->date); ?></td>

                        <?php if($FacturasCobradas->where('cobro_id',$c->id)->count()==1): ?>
                        <td><?php echo e($FacturasCobradas->where('cobro_id',$c->id)->first()->facture); ?></td>
                        <?php else: ?>
                            <?php if($FacturasCobradas->where('cobro_id',$c->id)->count()==0): ?> 
                                <td> <p style="font-weight: bold;">   <i class='fas fa-exclamation-triangle'></i> PENDIENTE POR FACTURAR</p> </td>
                            <?php else: ?>
                                <td><?php echo e($FacturasCobradas->where('cobro_id',$c->id)->count()); ?> Facturas asociadas</td>
                            <?php endif; ?>
                        <?php endif; ?>
                        <td><?php echo e($c->customer); ?></td>
                        <td><?php echo e($c->invoice); ?></td>
                        <td><?php echo e($c->bank_description); ?> <?php echo e($c->bank_clue); ?> </td>
                        
                        <td><?php echo e($c->coin); ?></td>
                        <td><?php echo e($c->tc); ?></td>
                        <?php if($c->coin=='NACIONAL'): ?>
                        <td> NA </td>
                        <td> <?php echo e($c->symbol); ?> <?php echo e(number_format($c->amount  ,2)); ?> </td>
                       <?php else: ?>
                        <td> <?php echo e($c->symbol); ?> <?php echo e(number_format($c->amount ,2)); ?> </td>
                        <td> <?php echo e($c->symbol); ?> <?php echo e(number_format($c->amount * $c->tc ,2)); ?></td>
                       <?php endif; ?>
                        <td> <?php echo e($c->capturista); ?></td>
                        <td><?php if($c->reviso): ?> <?php echo e($c->revisor); ?>

                             <?php else: ?>  
                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('REVISAR COBROS')): ?>
                             Marcar revisado <a href="<?php echo e(route('cobros.revisar', $c->id)); ?>">
                                        <button class="btn btn-green">
                                                <i class="fas fa-xl fa-check   "></i>
                                                </button>
                                        </a>
                            <?php endif; ?>

                                <?php endif; ?> </td>
                        <td><?php if($c->autorizo): ?> <?php echo e($c->autorizador); ?>

                             <?php else: ?>  
                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('AUTORIZAR COBROS')): ?>
                             Marcar autorizado <a href="<?php echo e(route('cobros.autorizar', $c->id)); ?>">
                                        <button class="btn btn-green">
                                                <i class="fas fa-xl fa-check   "></i>
                                                </button>
                                        </a> <?php endif; ?>
                                <?php endif; ?></td>
                        <td> <div class="row">
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('EDITAR COBROS')): ?>
                                        <a href="<?php echo e(route('cobros.edit', $c->id)); ?>">
                                        <button class="btn btn-blue">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                    &nbsp; &nbsp;
                                    <div class="col-6 text-center w-10">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BORRAR COBROS')): ?>
                                        <form class="DeleteReg" action="<?php echo e(route('cobros.destroy', $c->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-red ">
                                                <i class="fas fa-trash items-center fa-xl"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                        &nbsp; &nbsp;
                                        <a href="<?php echo e(route('cobros.show', $c->id)); ?>">
                                        <button class="btn btn-blue">
                                                <i class="fas fa-xl fa-eye"> </i> 
                                        </button></a>
                                        &nbsp; &nbsp;
                                        <a href="<?php echo e(route('cobro_pdf', $c->id)); ?>">
                                        <button class="btn btn-red">
                                                <i class="fa fa-xl fa-file-pdf-o">pdf </i> 
                                        </button></a>

                                    </div> 
                                </div></td>
                                
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
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/cobros/index.blade.php ENDPATH**/ ?>