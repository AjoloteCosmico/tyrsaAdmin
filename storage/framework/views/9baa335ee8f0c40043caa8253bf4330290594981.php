

<?php $__env->startSection('title', 'Reportes'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-bar-chart"></i>&nbsp; CUENTAS POR COBRAR</h1>
    
    <h1 class="font-bold">&nbsp; Visualizacion de datos</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-lg">
                    <br><br>                    
                    <?php echo $grafica_autorizados->container(); ?>

                    <table style="width: 60%">
                        <tr> 
                            <td> Cosecutivo Pedidos no autorizados</td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[0,'pedidos_sn_aut',0])); ?>">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'pedidos_sn_aut',1])); ?>">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                        </tr>
                    </table>
                 <script src="<?php echo e($grafica_autorizados->cdn()); ?>"></script>
                <?php echo $grafica_autorizados->script(); ?>

              </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/visualizacion/index.blade.php ENDPATH**/ ?>