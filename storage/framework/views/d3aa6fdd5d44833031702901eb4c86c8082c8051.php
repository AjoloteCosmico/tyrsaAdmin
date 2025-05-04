<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <style>
  html { margin: 0px}

    .demo-preview {
  padding-top: 10px;
  padding-bottom: 10px;
  margin: auto;
  text-align: center;
  font-family: "Source Sans Pro";
}
.demo-preview .badge{
  margin-right:10px;
}
.badge {
  display: strech;
  font-size: 20px
  /* font-weight: 50;
  padding: 3px 3px;  */
  border:2px solid transparent;
  /* min-width: 10px; */
   line-height: 1; 
  color: #fff;
   text-align: center;
  white-space: nowrap; 
   vertical-align: middle; 
  border-radius: 4px;
   /* padding: 3px; 
   margin: 1px; */ */
   width: 100%;
   padding: 3px;
  font-family: "Sans-Serif";
}

.badge.badge-default {
  background-color: #B0BEC5
}

.badge.badge-primary {
  background-color: #2B416D
}

.badge.badge-secondary {
  background-color: #323a45
}

.badge.badge-success {
  background-color: #64DD17
}

.badge.badge-warning {
  background-color: #FFD600
}

.badge.badge-info {
  background-color: #29B6F6
}

.badge.badge-danger {
  background-color: #9b9b9b;
  border-color: #9b9b9b;
}

.badge.badge-outlined {
  background-color: transparent
}

.badge.badge-outlined.badge-default {
  border-color: #B0BEC5;
  color: #B0BEC5
}

.badge.badge-outlined.badge-primary {
  
  border-color: #9b9b9b;
  color: #000000
}
.badge.badge-outlined.badge-danger {
border-color: #2B416D;
background-color: #2B416D;
  color: #ffffff;
}
.badge.badge-outlined.badge-secondary {
  border-color: #323a45;
  color: #323a45;
}

.badge.badge-outlined.badge-success {
  border-color: #64DD17;
  color: #64DD17
}

.badge.badge-outlined.badge-warning {
  border-color: #FFD600;
  color: #FFD600
}

.badge.badge-outlined.badge-info {
  border-color: #29B6F6;
  color: #29B6F6
}
</style>

    </head>
    <body class="font-sans antialiased">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.banner','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-banner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="min-h-screen bg-gray-200">
        <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-lg">
                <table>
                        <tr><td> </td>
                            <td >
                                <div style="padding:15px"  class="contaier">
                        
                                <img src="<?php echo e(public_path('img/logo/logo.png')); ?>"  alt="TYRSA"  style="align-self: left;"></td>
                                                </div></td>
                                 
                            <td style="padding:15px"  rowspan="2">
                        <br>
            Calle Cuernavaca S/N, Col. Ejido del Quemado,<br>
            C.P. 54,963, Tultepec, Edo. México, R.F.C. <br>
            TCO990507S91 Tels: (55) 26472033 / 26473330 <br>
 <div style="text-transform: lowercase;"> info@tyrsa.com.mx www.tyrsa.com.mx</div>     <br>
                        <!-- Domicilio Fiscal:
                                <?php echo e($CompanyProfiles->street.' '.$CompanyProfiles->outdoor.' '); ?>

                                <?php echo e($CompanyProfiles->intdoor.' '.$CompanyProfiles->suburb); ?>

                                <br><?php echo e($CompanyProfiles->city.' '.$CompanyProfiles->state.' '.$CompanyProfiles->zip_code); ?><br>
                                R.F.C: <?php echo e($CompanyProfiles->rfc); ?> &nbsp; Tels: 01-52 <?php echo e($CompanyProfiles->telephone.', '.$CompanyProfiles->telephone2); ?> <br> E-mail: <?php echo e($CompanyProfiles->email); ?> &nbsp; Web: <?php echo e($CompanyProfiles->website); ?>

                             -->
                        </td>
                        <td rowspan="2" class="card-body bg-white rounded-xl shadow-md text-center text-sm">
                                <span style="color: darkblue">Numero PI:<br>
                                <?php echo e($InternalOrders->invoice); ?></span>
                                <br> <br>
                                NOHA: <?php echo e($InternalOrders->noha); ?> 
                            </td>
                        </tr>
                        
                            
                        <td  colspan="2"class="text-lg " style="color: red;  width:23%;"><?php echo e($CompanyProfiles->company); ?>

                        </td>
                        <tr>
                                           
                        </tr >
                    </table>
                    <br><br>

                    <table>
                      <tr>
                      <td> <div class="badge badge-danger badge-outlined"> Comprobante Ingresos:</div></td>
                      <td> <div class="badge badge-primary badge-outlined"> <?php echo e($Cobro->comp); ?></div></td>
                      <td> &nbsp; &nbsp;<br>&nbsp;&nbsp; </td>
                      <td> <div class="badge badge-danger badge-outlined">Fecha: </div></td>
                      <td> <div class="badge badge-danger badge-outlined"><?php echo e($Cobro->date); ?></div></td>
                        
                      </tr>
                      <tr>
                      <td> <div class="badge badge-danger badge-outlined"> Pedido Interno:</div></td>
                      <td> <div class="badge badge-danger badge-outlined"><?php echo e($InternalOrders->invoice); ?></div></td>
                        
                      </tr>
                    </table>
    <br><br><br>
    <table>
      <tr>
      <td> <div class="badge badge-danger badge-outlined">BANCO: </div></td>
      <td colspan="3"> <div class="badge badge-primary badge-outlined"><?php echo e($Banco->bank_description); ?> <?php echo e($Banco->bank_clue); ?> </div></td>                
      </tr>
      <tr>
      <td> <div class="badge badge-danger badge-outlined">Factura: </div></td>
      <td colspan="3"> <div class="badge badge-primary badge-outlined"><?php echo e($Factura->facture); ?> </div></td>                
      </tr><tr>
      <td> <div class="badge badge-danger badge-outlined">Cliente: </div></td>
      <td colspan="3"> <div class="badge badge-primary badge-outlined"><?php echo e($Customers->customer); ?> <?php echo e($Customers->legal_name); ?> </div></td>                
      </tr>
      <tr>
      <td> <div class="badge badge-danger badge-outlined">Moneda: </div></td>
      <td > <div class="badge badge-primary badge-outlined"><?php echo e($Coins->coin); ?>  </div></td>                
      <td> <div class="badge badge-danger badge-outlined">T.C: </div></td>
      <td > <div class="badge badge-primary badge-outlined"> <?php echo e($Coins->symbol); ?> <?php echo e(number_format($Cobro->tc,2)); ?>  </div></td>                
      
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td> <div class="badge badge-danger badge-outlined">Subtotal: </div></td>
      <td > <div class="badge badge-primary badge-outlined"> <?php echo e($Coins->symbol); ?> <?php echo e(number_format( $Cobro->amount/1.16 ,2)); ?>  </div></td>                
      
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td> <div class="badge badge-danger badge-outlined">IVA: </div></td>
      <td > <div class="badge badge-primary badge-outlined"> <?php echo e($Coins->symbol); ?> <?php echo e(number_format($Cobro->amount - ( $Cobro->amount/1.16),2)); ?>  </div></td>                
      
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td> <div class="badge badge-danger badge-outlined">Total: </div></td>
      <td > <div class="badge badge-primary badge-outlined"> <?php echo e($Coins->symbol); ?> <?php echo e(number_format($Cobro->amount,2)); ?>  </div></td>                
      
      </tr>
    </table>
                </div>
            </div>
        </div>
        </div>

        </div>

    </body>
</html>
<?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/reportes/test.blade.php ENDPATH**/ ?>