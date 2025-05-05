

<?php $__env->startSection('title', 'Reportes'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-file"></i>&nbsp;CONTRAPORTADA </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-lg">
                
            
               
                <div class="col-sm-12 table-responsive">

                <table id="tableContraportada" class="table tablepayments table-striped text-xs font-medium">
  <thead class="thead">
    <tr>
      <th scope="col">Cliente</th>
      <th > Pedido</th>
      <th scope="col">Cantidad</th>
      <th scope="col">---</th>
      <th scope="col">---</th>

    </tr>
  </thead>
  <tbody>
  <?php $__currentLoopData = $InternalOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="text-center">
                            
                                <td> <p><?php echo e($row->customer); ?></p></td>
                                
                                <td> <?php echo e($row->invoice); ?></td>
                                
                                <td><?php echo e($row->symbol); ?> <?php echo e(number_format($row->total)); ?> </td>
                               
                                <td>
                                <a href="<?php echo e(route('payments.reporte',[$row->id,'contraportada',0])); ?>">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               </td>
                               
                               <td>
                                <a href="<?php echo e(route('payments.contraportadaPDF',$row->id)); ?>">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
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
<script>

$(document).ready(function () {
    $('#tableContraportada').DataTable();
});
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/accounting/reportes.blade.php ENDPATH**/ ?>