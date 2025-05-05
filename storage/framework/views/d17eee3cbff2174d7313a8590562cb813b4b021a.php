

<?php $__env->startSection('title', 'PEDIDOS INTERNOS'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp; PEDIDO INTERNO</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm">
                    <table>
                        <tr>
                            <td rowspan="4">
                               <img src="<?php echo e(asset('img/logo/logo.svg')); ?>" alt="TYRSA">
                               
                        
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lg" style="color: red"><?php echo e($CompanyProfiles->company); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e($CompanyProfiles->motto); ?></td>
                        </tr>
                        <tr class="text-xs">
                            <td>
                                <br>
                                Domicilio Fiscal:<br>
                                <?php echo e($CompanyProfiles->street.' '.$CompanyProfiles->outdoor.' '.$CompanyProfiles->intdoor.' '.$CompanyProfiles->suburb.' '.$CompanyProfiles->city.' '.$CompanyProfiles->state.' '.$CompanyProfiles->zip_code); ?><br>
                                R.F.C: <?php echo e($CompanyProfiles->rfc); ?> &nbsp; Tels: 01-52 <?php echo e($CompanyProfiles->telephone.', '.$CompanyProfiles->telephone2); ?> &nbsp; E-mail: <?php echo e($CompanyProfiles->email); ?> &nbsp; Web: <?php echo e($CompanyProfiles->website); ?>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="row p-4">
                <div class="col-sm-9 col-xs-12 font-bold text-sm">
                    <table>
                        <tr>
                            <td>
                                Cliente: <?php echo e($Customers->clave.' '. $Customers->customer); ?><br>
                                Dirección Fiscal: <?php echo e($Customers->customer_street.' '.$Customers->customer_outdoor.' '.$Customers->customer_intdoor.' '.$Customers->customer_suburb.' '.$Customers->customer_city.' '.$Customers->customer_state.' '.$Customers->customer_zip_code); ?><br>
                                R.F.C: <?php echo e($Customers->customer_rfc); ?> &nbsp; Tel: 01-52 <?php echo e($Customers->customer_telephone); ?> &nbsp; E-mail: <?php echo e($Customers->customer_email); ?> &nbsp; Web: <?php echo e($Customers->customer_website); ?>

                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-3 col-xs-12 font-bold text-sm">
                    <table>
                        <tr>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="row p-4">
                <div class="col-sm-12 font-bold text-sm">
                        

                <table >
        <tbody>
          <tr>
            <td>
            Total de Pedidos &nbsp;
            </td>
            <td>
            Abonos pagados&nbsp;
            </td>
            <td>
            Porcentaje completado&nbsp;
            </td>
            <td>
            Saldo deudor&nbsp;
            </td>
          </tr>
          <tr>
          <?php if($pagos->sum('amount') > 0): ?>
            <td>
             <?php echo e($pagos->count()); ?>

            </td>
            <td>
            <?php echo e($pagados->count()); ?> / <?php echo e($pagos->count()); ?>

            </td>
            <td>
                
              <?php echo e(round(  100*($pagados->sum('amount'))/($pagos->sum('amount'))  )); ?> %
             
            </td>
            <td style="color : red ">
            
             <?php echo e($pagos->first()->symbol); ?> <?php echo e(number_format($noPagados->sum('amount'))); ?>

            
            </td>
            <?php endif; ?>
          </tr>
        </tbody>
      </table>

<br><br><br>

<form action="<?php echo e(route('payments.multi_pay_actualize')); ?>" method="POST" enctype="multipart/form-data" id="form1">
<?php echo csrf_field(); ?>
        <table class="table-striped text-xs font-medium" >
            <thead class="thead">
               <tr style = "font-size : 14px ; padding : 15px">
               <th > Pedido</th>
               <th scope="col">concepto <br></th>
               <th scope="col">Cantidad</th>
               <th scope="col">Fechade pago</th>
               <th scope="col">Notas</th>
               <th scope="col">Estado</th>
               <th scope="col">Seleccionar</th>
               
               </tr>
               
            </thead>

            <tbody >
    <?php $__currentLoopData = $pagos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pago): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style = "font-size : 14px; margin : 15px" >

                   <td>
                   <?php echo e($pago->invoice); ?>

                   <br>
                    </td>
                    <td>
                   <?php echo e($pago->concept); ?>

                    </td>
                    <td>
                    <?php echo e($pago->symbol); ?><?php echo e(number_format($pago->amount)); ?>

                    </td>
                    <td>
                   <?php echo e($pago->date); ?>

                    </td>
                    <td>
                   <?php echo e($pago->nota); ?>

                    </td>
                    <td>
                    <?php {{
                      $fecha = new DateTime($pago->date);
                    }}?>

                    <?php if($pago->status == 'pagado'): ?>
                    <a href="<?php echo e(route('payments.pay_actualize',$pago->id)); ?>">
                        <button class="button" type="button"> <span class="badge badge-success">Pagado</span> </button>
                        </a> 
                      
                      <?php else: ?>
                      <?php if( now() > $fecha): ?>
                      <a href="<?php echo e(route('payments.pay_actualize',$pago->id)); ?>">
                      <button class="button" type="button"> <span class="badge badge-danger">atrasado</span> </button>
                      </a>  
                    <?php else: ?>
                      <a href="<?php echo e(route('payments.pay_actualize',$pago->id)); ?>">
                      <button class="button" type="button"> <span class="badge badge-info">por cobrar</span> </button>
                      </a>
                      <?php endif; ?>     
                    <?php endif; ?>           
                    </td>
                    <td>
                    </td>
                    <td>
                    
                       &nbsp; 
                      <?php if($pago->status == 'por cobrar'): ?>
                    <input class="form-check-input" type="checkbox" value="<?php echo e($pago->id); ?>" id="flexCheckDefault" name="pago[]">
                    
                    <?php endif; ?>
                    
                    </td>

                    
                </tr>



                
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      
            </tbody>
        </table>
        <br><br>

        <br>
        <button type="submit" class="btn btn-blue">PAGAR SELECCIONADOS</button>
        
    </div>
    </form>
  </div>
  <br>
  
            <br> <br> 
            
                </div>
                    <input  class="btn btn-green" type="button" name="imprimir" value="Imprimir" id="printPageButton" onclick="window.print();"> 
                    
                                    
                    
  
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tablecatalogocustomers.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/accounting/customer.blade.php ENDPATH**/ ?>