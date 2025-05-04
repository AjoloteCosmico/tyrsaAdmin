

<?php $__env->startSection('title', 'Cuentas por Cobrar'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-credit-card"></i>&nbsp; CUENTAS POR COBRAR</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
              
                <div class="col-sm-12 text-center font-bold text-sm">
                
  
                <div class="float-left"><h1><span class="badge badge-danger" style="font-size : 20px"> $ <?php echo e(number_format($total)); ?> <br> por cobrar <br> </span></h1></div>
                <br><br>
                <div class="container" style ="padding: 15px">
                <div class="btn-group" role="group"  aria-label="Basic example">
  <button type="button" class="btn btn-blue mb-2" onclick="Clientes()">Clientes</button>
  <button type="button" class="btn btn-blue mb-2" onclick="Ordenes()">Pedido</button>
  <button type="button"class="btn btn-blue mb-2"  onclick="Fechas()">Fecha</button>
</div></div>
<br> <br>
<div id = "ClientView">  
<div class ="justify-content-rigth"> </div>



<div class="col-sm-12 table-responsive">
            
<table id="tableCustomers" class="table table-striped text-xs font-small" >
                  <thead>
                            <tr>
                                
                                <th>Clave</th>
                                <th>Razón Social</th>
                                <th>RFC</th>
                                
                                <th>Municipio</th>
                                
                                
                                <th style="width:13%"> Ver cuentas por Cobrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $Customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <?php if($clientes->contains('id',$row->id)): ?>
                            <tr>
                                <td><?php echo e($row->clave); ?></td>
                                <td><?php echo e($row->customer); ?></td>
                                <td><?php echo e($row->customer_rfc); ?></td>
                                
                                <td><?php echo e($row->customer_city); ?></td>
                                
                                <td class="w-5">
                                    <div class="row">
                                    <div class="col"></div>
                                        <div class="col-6 text-center w-10" >
                                        
                                            <a href="<?php echo e(route('accounting.cuentas_customer', $row->id)); ?>">
                                                <i class="fas fa-usd btn btn-blue w-3 h-3"></i>
                                            </a>
                                            
                                        </div>
                                        <div class="col"></div> 
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>


</div>

</div>
<div id = "OrderView">  
<table id="tableOrders" class="table table-striped text-xs font-small" >
                  <thead>
                            <tr>
                                
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Clave</th>
                                
                                <th>Vendedor</th>
                                
                                
                                <th style="width:13%"> Ver cuentas por Cobrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $Orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              
                               <td><?php echo e($row->invoice); ?></td>
                               <td><?php echo e($row->reg_date); ?></td>
                                <td><?php echo e($row->customer); ?></td>
                                <td><?php echo e($row->clave); ?></td>
                                <td><?php echo e($row->seller_name); ?></td>
                                
                                
                                
                                <td class="w-5">
                                    <div class="row">
                                    <div class="col"></div>
                                        <div class="col-6 text-center w-10" >
                                        
                                            <a href="<?php echo e(route('accounting.cuentas_order', $row->id)); ?>">
                                                <i class="fas fa-usd btn btn-blue w-3 h-3"></i>
                                            </a>
                                            
                                        </div>
                                        <div class="col"></div> 
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
</div>

<br><br><br><br>
<div id = "DateView">  
  <div style ="flex-direction: row">  
    <p>Fehca Inicial</p>  <input type="date" style="width : 20%">&nbsp;&nbsp;&nbsp;
    <h1>Fehca Final</h1>  <input type="date" style="width : 20%">&nbsp;&nbsp;&nbsp;
  </div>
  <br>
        <div class="col-sm-12 table-responsive">
                  
<table class="table tablepayments table-striped text-xs font-medium">
  <thead class="thead">
    <tr>
      <th scope="col">Cliente</th>
      <th > Pedido</th>
      <th scope="col">concepto</th>
      <th scope="col">Cantidad</th>
      <th scope="col">Fechade pago</th>
      <th scope="col">Notas</th>
      <th scope="col">Estado</th>
    </tr>
  </thead>
  <tbody>
  <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  
<?php if($row->status=="por cobrar"): ?>
                            <tr class="text-center">
                            <?php
{{$order = DB::table('payments')
    ->join('internal_orders', 'payments.order_id', '=', 'internal_orders.id')
    ->join('customers','customers.id','=','internal_orders.customer_id')
    ->select('payments.*','customers.customer','internal_orders.invoice')
    ->where('payments.order_id', $row->order_id)
    ->first();
    $coin = DB::table('internal_orders')
    ->join('coins', 'coins.id', '=', 'internal_orders.coin_id')
    ->where('internal_orders.id', $row->order_id)
    ->first();
    $fecha = new DateTime($row->date);
    $hoy = new DateTime("2022-11-7");
  }}
?>
                                <td> <p><?php echo e($order->customer); ?></p></td>
                                <td> <?php echo e($order->invoice); ?></td>
                                <td> <?php echo e($row->concept); ?></td>
                                <td> <?php echo e($coin->symbol); ?><?php echo e(number_format($row->amount)); ?></td>
                                <td><?php echo e($row->date); ?> </td>
                               
                                <td><?php echo e($row->nota); ?></td>
                                <td>

                                <?php if($fecha < now()): ?>
                                <a href="<?php echo e(route('payments.pay_actualize',$row->id)); ?>">
                                  <button class="button"> <span class="badge badge-danger">Atrasado</span> </button>
                                  </a>  
                                  <?php else: ?>
                                  <a href="<?php echo e(route('payments.pay_actualize',$row->id)); ?>">
                                    <button class="button"> <span class="badge badge-info">por cobrar</span> </button>
                                     </a>     
                                  <?php endif; ?>
                                 
                               </td>
                                
                            </tr>
<?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  
  </tbody>
</table>
            </div>
            </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tablecatalogopayments.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tablecatalogocustomers.js')); ?>"></script>

<script>
  document.getElementById("DateView").hidden="hidden";
  document.getElementById("OrderView").hidden="hidden";

  function Clientes(){
    document.getElementById("ClientView").hidden="";
    document.getElementById("OrderView").hidden="hidden";
    document.getElementById("DateView").hidden="hidden";
  }
  
  function Ordenes(){
    document.getElementById("ClientView").hidden="hidden";
    document.getElementById("DateView").hidden="hidden";
    document.getElementById("OrderView").hidden="";
  }

  function Fechas(){
    document.getElementById("ClientView").hidden="hidden";
    document.getElementById("DateView").hidden="";
    document.getElementById("OrderView").hidden="hidden";
  }
</script>
<script>

$(document).ready(function () {
    $('#tableOrders').DataTable();
});
</script>
<script>

$(document).ready(function () {
    $('#tableCustomers').DataTable();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/accounting/cuentas_cobrar.blade.php ENDPATH**/ ?>