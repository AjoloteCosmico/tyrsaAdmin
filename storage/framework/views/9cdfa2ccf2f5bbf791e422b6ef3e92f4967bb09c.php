

<?php $__env->startSection('title', 'VENDEDORES'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; CLIENTES DEL VENDEDOR <?php echo e($Seller->seller_name); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                </div>
                <div class="row"> 
                <div class="col">
                    
                                <a href="<?php echo e(route('sellers.select_customers',$Seller->id)); ?>">
                                        <button class="btn btn-blue ">
                                                <i class="fas fa-users"> </i>
                                               Asignar Clientes
                                            </button></a>
                                </div>
                                
                <div class="col">
                                <a href="<?php echo e(route('sellers.index')); ?>">
                                        <button class="btn btn-black ">
                                                <i class="fas fa-arrow-left"> </i>
                                               Volver al menu
                                            </button></a>
                                    </div>
                                                  </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                <table class="table  datatable tableusuarios table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>Clave</th>
                            <th>Cliente</th>
                            <th>Nombre Corto</th>
                            <th>RFC</th>
                            <th>Num Pedidos</th>
                            <th>Monto total en Pedidos</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $Customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="text-center">
                            <td><?php echo e($row->clave); ?></td>
                            <td><?php echo e($row->customer); ?></td>
                            <td><?php echo e($row->alias); ?></td>
                            <td><?php echo e($row->customer_rfc); ?></td>
                            <td><?php echo e($row->npedidos); ?></td>
                            <td>$ <?php echo e(number_format($row->total,2)); ?> </td>
                            <td> 
                                <a href="<?php echo e(route('sellers.select_customers',$Seller->id)); ?>">
                                        <button class="btn btn-blue ">
                                                <i class=" fas fa-exchange-alt"> </i>
                                               Asignar a otro vendedor
                                            </button></a>
                                </div></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tablecatalogousers.js')); ?>"></script>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/admin/sellers/customers.blade.php ENDPATH**/ ?>