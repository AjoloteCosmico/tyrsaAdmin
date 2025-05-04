

<?php $__env->startSection('title', 'PEDIDOS INTERNOS'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp; REPORTE VENTAS POR FABRICACION</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>     <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm" >
                <table class=" table-responsive text-xs" style="border: none; border-collapse: collapse;">
                        <tr style="border: none; border-collapse: collapse;"><td style="border: none; border-collapse: collapse;"> &nbsp; &nbsp; &nbsp;</td>
                            <td style="border: none; border-collapse: collapse;">
                                <div class="contaier">
                        
                                                <img src="<?php echo e(asset('img/logo/logo.svg')); ?>" alt="TYRSA"  style="align-self: left;"></td>
                                                </div></td>
                                 
                            <td rowspan="2" style="border: none; border-collapse: collapse;">
                        <br>
            Calle Cuernavaca S/N, Col. Ejido del Quemado,<br>
            C.P. 54,963, Tultepec, Edo. México,<b> R.F.C.</b>  <br> <br>
            TCO990507S91 Tels: (55) 26472033 / 26473330 <br>
 <div style="text-transform: lowercase;"> info@tyrsa.com.mx <b> <a href="https://www.tyrsa.com.mx"> www.tyrsa.com.mx</a> </b></div>     <br>
                        <!-- Domicilio Fiscal:
                                <?php echo e($CompanyProfiles->street.' '.$CompanyProfiles->outdoor.' '); ?>

                                <?php echo e($CompanyProfiles->intdoor.' '.$CompanyProfiles->suburb); ?>

                                <br><?php echo e($CompanyProfiles->city.' '.$CompanyProfiles->state.' '.$CompanyProfiles->zip_code); ?><br>
                                R.F.C: <?php echo e($CompanyProfiles->rfc); ?> &nbsp; Tels: 01-52 <?php echo e($CompanyProfiles->telephone.', '.$CompanyProfiles->telephone2); ?> <br> E-mail: <?php echo e($CompanyProfiles->email); ?> &nbsp; Web: <?php echo e($CompanyProfiles->website); ?>

                             -->
                        </td>
                        <td rowspan="2" style="border: none; border-collapse: collapse;">
                       
                            <table>
                                <tr>
                                    <th>Año</th>
                                    <td><?php echo e($Year); ?></td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                        
                            
                        <td  colspan="2"class="text-lg " style="color: red;  width:23%; border: none; border-collapse: collapse;"><?php echo e($CompanyProfiles->company); ?>

                        </td>
                        <tr>
                                           
                        </tr >

                    </table>


                   <?php if($Monto=='MONTO'): ?>
                   <h5 class="text-lg text-center text-bold">RESULTADO DE PRESUPUESTO MENSUAL DE VENTAS POR FABRICACIÓN POR MARCA </h5>
                   
                   <?php else: ?>
                   <h5 class="text-lg text-center text-bold">RESULTADO DE VENTAS POR FABRICACIÓN POR MARCA </h5>
            
                   <?php endif; ?>
            <br>
            <div >
                <table>
                    <tr>
                    <td>
                            <a href="<?php echo e(route('reports.generate',[1,'objetivos_por_'.strtolower($Monto),0])); ?>">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'objetivos_por_'.strtolower($Monto),1])); ?>">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                    </tr>
                </table>
                <!-- botones para switchear entre pestañas -->
                <div>
  <button id="btn-tabla" class="boton activo" onclick="mostrar('tabla', this)">Tabla</button>
  <button id="btn-graficos" class="boton" onclick="mostrar('graficos', this)">Gráficos</button>
</div>
                <div class="table-responsive contenedor" id="tabla" style="display: block;">
             
                        <!-- 14 columas, para poder copiar del excel -->
               <table class="table text-xs font-medium table-striped "  id="example" >
               <thead> 
                <!-- 15 columnas -->
               <tr class="text-center">
                    <th width="18%">Vendedor</th>
                    <th>Enero</th>
                    <th>Febrero</th>
                    <th>Marzo</th>
                    <th>Mayo </th>
                    <th>Abril</th>
                    <th>Junio</th>
                    <th>Julio</th>
                    <th>Agosto</th>
                    <th>Septiembre</th>
                    <th>Octubre</th>
                    <th>Noviembre</th>
                    <th>Diciembre</th>
                    <th>Total</th>
                    <th width="8%"> &nbsp;% &nbsp; &nbsp;</th>
                </tr>
                </thead>

                <?php
                {{function divide($p,$q){
                  if($q==0){
                    return 0;
                  }
                  else{
                    return ($p/$q);
                  }
                } }}
                ?>

                <?php $__currentLoopData = $Marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($marca->name); ?></td>
                    <?php for($i=1;$i<=12;$i++): ?>
                      <?php if($Monto=='MONTO'): ?>                    
                        <td class="text-nowrap" > $ <?php echo e(number_format($InternalOrders->where('marca',$marca->id)->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->sum('total'),2)); ?>  </td>
                        <?php else: ?>
                        <td><?php echo e($InternalOrders->where('marca',$marca->id)->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->count()); ?>  </td>
                        
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if($Monto=='MONTO'): ?>  
                      <td class="text-nowrap" > $ <?php echo e(number_format($InternalOrders->where('marca',$marca->id)->sum('total'),2)); ?></td>
                      <td class="text-nowrap" ><?php echo e(number_format(divide(100*$InternalOrders->where('marca',$marca->id)->sum('total'),$InternalOrders->sum('total')),1)); ?> %</td>
                    <?php else: ?>
                    
                    <td class="text-nowrap" ><?php echo e($InternalOrders->where('marca',$marca->id)->count()); ?></td>
                      <td class="text-nowrap" > <?php echo e(number_format(divide(100*$InternalOrders->where('marca',$marca->id)->count(),$InternalOrders->count(),1))); ?> %</td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tfoot>

                <tr>
                    <th>TOTAL MENSUAL</th>
                    <?php for($i=1;$i<=12;$i++): ?>
                                  
                      <?php if($Monto=='MONTO'): ?>  
                        <th> $ <?php echo e(number_format($InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->sum('total'),2)); ?>  </th>
                    
                      <?php else: ?>
                        <th><?php echo e($InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->count()); ?>  </th>
                    
                      <?php endif; ?>
                    <?php endfor; ?>
                      <?php if($Monto=='MONTO'): ?>  
                      <th> $ <?php echo e(number_format($InternalOrders->sum('total'),2)); ?> </th>
                      <?php else: ?>
                      <th><?php echo e($InternalOrders->count()); ?> </th>
                      <?php endif; ?>
                    
                    <th>100% </th>
                </tr>
                <tr>
                    <td></td>
                    <?php for($i=1;$i<=12;$i++): ?>
                      <?php if($Monto=='MONTO'): ?>  
                      <td><?php echo e(number_format(divide(100*$InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->sum('total'),$InternalOrders->sum('total')),1)); ?> %</td>
               
                      <?php else: ?>
                      <td><?php echo e(number_format(divide(100*$InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->count(),$InternalOrders->count()),1)); ?> %</td>
               
                      <?php endif; ?>
                    
                    <?php endfor; ?>
                    <td></td>
                    <td></td>
                </tr>
                </tfoot>
               </table>
                     </div>
          <div class="contenedor" id="graficos">
          <div class="container px-4 mx-auto">

            <div class="p-6 m-20 bg-white rounded shadow">
                <?php echo $SellerChart->container(); ?>

            </div>
            
            <div class="p-6 m-20 bg-white rounded shadow">
                <?php echo $MesesChart->container(); ?>

            </div>

            </div>
          </div>          

                  

                  
                   
                                    

                                    
                    
  
        </div>
    </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
@media print {
  #printPageButton {
    display: none;
  }
}
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.min.css">

<style>
 th { white-space: nowrap; }
  /* Estilos de los botones */
  .boton {
    padding: 10px 20px;
    border: 1px solid #ccc;
    background-color: #e0e0e0;
    color: #333;
    cursor: pointer;
    border-radius: 5px 5px 0 0;
    outline: none;
    margin: 0; /* Sin espacio entre los botones */
  }

  .boton.activo {
    background-color: #007bff;
    color: white;
    border-bottom: 1px solid white; /* Para que parezca unido al contenedor */
  }

  .boton:hover {
    background-color: #ccc;
  }

  /* Contenedores */
  .contenedor {
    display: none; /* Ocultar inicialmente */
    border: 1px solid #ccc;
    padding: 20px;
    margin-top: -1px; /* Para unir con el botón */
    border-radius: 0 5px 5px 5px; /* Redondeo sólo en la parte inferior */
  }


</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
<script>
new DataTable('#example');
</script>
<script>
  function mostrar(id, boton) {
    // Ocultar todos los contenedores
    document.querySelectorAll('.contenedor').forEach(div => {
      div.style.display = 'none';
    });

    // Mostrar el contenedor seleccionado
    document.getElementById(id).style.display = 'block';

    // Cambiar estado de los botones
    document.querySelectorAll('.boton').forEach(btn => {
      btn.classList.remove('activo');
    });
    boton.classList.add('activo');
  }
</script>

<script src="<?php echo e($SellerChart->cdn()); ?>"></script>

<?php echo e($SellerChart->script()); ?>


<script src="<?php echo e($MesesChart->cdn()); ?>"></script>

<?php echo e($MesesChart->script()); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/reportes/fabricacion.blade.php ENDPATH**/ ?>