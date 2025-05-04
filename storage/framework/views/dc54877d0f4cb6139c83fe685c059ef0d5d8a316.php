

<?php $__env->startSection('title', 'Reportes'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-file"></i>&nbsp; REPORTE DE CUENTAS POR COBRAR</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-lg">
                    <h1>POR PEDIDO INTERNO</h1>
                    <br><br>
                    <table style="width: 60%">
                        <tr> 
                            <td> Cobrado y por Cobrar </td>
                            <br>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'CxC_pedido',0])); ?>">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'CxC_pedido',1])); ?>">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                        </tr>
                       
                        <tr> 
                            <td> Solo Cuentas Vigentes</td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'CxC_pedidos_vigentes',0])); ?>">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'CxC_pedidos_vigentes',1])); ?>">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                        </tr>
                    </table>
               
                                
                                  <BR><BR></BR></BR>
                    <h1> CONSOLIDADO POR CLIENTE</h1>
                    <br><br>
                    <table style="width: 60%">
                        <tr> 
                            <td> Cobrado y por Cobrar</td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'CxC_cliente_consolidado',0])); ?>">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'CxC_cliente_consolidado',1])); ?>">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                        </tr>
                        <tr> 
                            <td> Solo Cuentas Vigentes</td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'CxC_cliente_consolidado_vigente',0])); ?>">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'CxC_cliente_consolidado_vigente',1])); ?>">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                        </tr>
                    </table>




                
                    <BR><BR></BR></BR>
                    <h1>DESGLOSADO POR CLIENTE</h1>

                    <br><br>
                    <table style="width: 60%">
                        <tr> 
                            <td> Cobrado y por Cobrar</td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[0,'CxC_cliente_desglosado',0])); ?>">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'CxC_cliente_desglosado',1])); ?>">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                        </tr>
                        <tr> 
                            <td> Solo Cuentas Vigentes</td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'CxC_cliente_desglosado_vigente',0])); ?>">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'CxC__desglosado_vigente',1])); ?>">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                        </tr>
                    </table>


                    
                               
                               
        
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
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/reportes/rep_cuentas_cobrar.blade.php ENDPATH**/ ?>