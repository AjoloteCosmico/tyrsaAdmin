

<?php $__env->startSection('title', 'Cuentas por Cobrar'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-credit-card"></i>&nbsp; CUENTAS POR COBRAR</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm">
                
                <div class="float-left"><h1><span class="badge badge-success"> $ <?php echo e($total); ?> <br> Recaudados <br> </span></h1>
               </div>
               
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
                            <tr class="text-center">
                            <?php
{{$order = DB::table('payments')
    ->join('internal_orders', 'payments.order_id', '=', 'internal_orders.id')
    ->where('internal_orders.id', $row->order_id)
    ->first();
    $coin = DB::table('internal_orders')
    ->join('coins', 'coins.id', '=', 'internal_orders.coin_id')
    ->where('internal_orders.id', $row->order_id)
    ->first();
    $fecha = new DateTime($row->date);
    $hoy = new DateTime("2022-11-7");
  }}
?>
                                <td> <p>Cliente de prueba 01</p></td>
                                <td> <?php echo e($order->invoice); ?></td>
                                <td> <?php echo e($row->concept); ?></td>
                                <td> <?php echo e($coin->symbol); ?><?php echo e($row->amount); ?></td>
                                <td><?php echo e($row->date); ?> </td>
                               
                                <td><?php echo e($row->nota); ?></td>
                                <td>

                                
                                <a href="<?php echo e(route('payments.pay_actualize',$row->id)); ?>">
                                  <button class="button"> <span class="badge badge-success">Pagado</span> </button>
                                  </a>  
                                 
                                   
                                 
                                 
                               </td>
                                
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  
  </tbody>
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

<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tablecatalogopayments.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/accounting/cuentas_pagadas.blade.php ENDPATH**/ ?>