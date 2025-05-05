<h2>SOLO VENDEDORES ACTIVOS / SOLO COMISION DIRECTA DE VENTA</h2>
<div class="container px-4 mx-auto">
             <table>
                    <tr>
                    <td>
                            <a href="<?php echo e(route('reports.generate',[1,'dgi_resumen_venta',0])); ?>">
                                  <button class="button btn-lg"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="<?php echo e(route('reports.generate',[1,'dgi_resumen_venta',1])); ?>">
                                  <button class="button btn-lg"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                    </tr>

                </table  >

                <table class="table text-xs font-medium table-striped text.center"  id="example3" style="table, th, td { border: 1px solid white;}">
                    <thead >    
                        <tr style="border: 2px solid white;">
                            <th style="border: 2px solid white;" rowspan="4">Sin IVA <br>comision <br>generada</th>
                            <th style="border: 2px solid white;" rowspan="4">Pedido Interno</th>
                            <th>No.vendedor</th>
                            <?php $__currentLoopData = $no_socios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e($row->folio); ?> </th> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        <tr style="border: 2px solid white;">
                            <th>Iniciales</th>
                            <?php $__currentLoopData = $no_socios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e($row->iniciales); ?> </th> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        <tr style="border: 2px solid white;">
                            <th>Nombre corto</th>
                            <?php $__currentLoopData = $no_socios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e(ltrim(strrchr($row->seller_name, " "))); ?> </th> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        <tr style="border: 2px solid white;">
                            <th>Comprobante</th>
                            <?php $__currentLoopData = $no_socios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th> Comision $</th> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                    <?php
                    $total_sum=0;
                    ?>
                    <?php $__currentLoopData = $Cobros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cobro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <?php
                       $this_comissions=$Comisiones->where('order_id',$cobro->order_id);

                       ?>
                    <tr>
                        <td>$<?php echo e(number_format($cobro->amount/1.16,2)); ?></td>
                        <td><?php echo e($cobro->invoice); ?> </td>
                        <td><?php echo e($cobro->comp); ?> </td>
                        <?php $__currentLoopData = $no_socios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           
                            <?php if($row->id==$cobro->seller_id): ?>
                            <?php
                            $total_sum=$total_sum+($cobro->amount*$cobro->comision)/1.16;
                            ?>

                                <td>$<?php echo e(number_format(($cobro->amount*$cobro->comision)/1.16,2)); ?>  </td> <!-- //caso en que es el vendedor princi´pal   -->
                            <?php elseif($this_comissions->where('seller_id',$row->id)->count()>0): ?>
                            <?php
                            $total_sum=$total_sum+($cobro->amount*$this_comissions->where('seller_id',$row->id)->first()->percentage)/1.16;
                            ?>
                                <td>$<?php echo e(number_format(($cobro->amount*$this_comissions->where('seller_id',$row->id)->first()->percentage)/1.16,2)); ?>  </td> <!-- //caso en que el vendedor tiene una comision   -->
                            <?php else: ?> 
                                <td> $0 </td>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tfoot>
                    <tr>
                       <th> $<?php echo e(number_format($total_sum,2)); ?></th>
                       <th></th>
                       <th></th>
                       <?php $__currentLoopData = $no_socios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <th>$<?php echo e(number_format($Cobros->where('seller_id',$row->id)->sum('amount')/1.16,2)); ?> </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        
                       <?php $__currentLoopData = $no_socios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <th><?php echo e(ltrim(strrchr($row->seller_name, " "))); ?> </th> 
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    </tfoot>
                </table>

                <!-- tabla de totales  -->
                 <table>
                   
                 </table>
</div><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/reportes/dgi_resumen_ventas.blade.php ENDPATH**/ ?>