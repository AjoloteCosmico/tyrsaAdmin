<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', '')); ?> <?php echo $__env->yieldContent('title'); ?> </title>

        <!-- Bootstrap 5.0 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
        <!-- Font Awesome 6 Kit LEPER SYSTEMS -->
        <script src="https://kit.fontawesome.com/1bfa36884d.js" crossorigin="anonymous"></script>
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <!-- Load Source Sans Pro font -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" rel="stylesheet">
        <!-- Load Nunito font -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Load Roboto font -->
        <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext" rel="stylesheet">
        <!-- Load Amaranth font -->
        <link href="https://fonts.googleapis.com/css2?family=Amaranth:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

        <!-- DataTables -->
    	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.3.1/dt-1.10.25/af-2.3.7/b-1.7.1/b-print-1.7.1/cr-1.5.4/date-1.1.0/fc-3.3.3/fh-3.1.9/kt-2.6.2/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.4/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css"/>

        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo e(asset('vendor/img/ico/apple-touch-icon-144.png')); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo e(asset('vendor/img/ico/apple-touch-icon-114.png')); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo e(asset('vendor/img/ico/apple-touch-icon-72.png')); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo e(asset('vendor/img/ico/apple-touch-icon-57.png')); ?>">
        <link rel="shortcut icon" href="<?php echo e(asset('vendor/img/ico/favicon.ico')); ?>">

        <!-- My Style -->
        <link href="<?php echo e(asset('vendor/mystylesjs/css/datatable_gral.css')); ?>" rel="stylesheet">

        <!-- Styles Tailwind Laravel Breeze -->
        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
        

        <!-- Scripts Tailwind Laravel Breeze -->
        <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
        

        <?php echo \Livewire\Livewire::styles(); ?>


        <?php echo $__env->yieldPushContent('css'); ?>
        
<style>
    .demo-preview {
  padding-top: 10px;
  padding-bottom: 10px;
  margin: auto;
  text-align: center;
}
.demo-preview .badge{
  margin-right:10px;
}
.com-text{
    white-space: pre-wrap;
      word-wrap: break-word;
}
.badge {
    display: block;
     padding: 1em;
  font-size: small;
  font-weight: 600;
  /* padding: 3px 6px; */
  border:3px solid transparent;
  /* min-width: 10px; */
  /* line-height: 1; 
  color: #fff;
  /* text-align: center;*/
  white-space: nowrap; 
   vertical-align: middle; 
  border-radius: 5px;
  /* padding: 15px; */
  width: 100%;
  min-height: 1px;    
  height:auto !important;
  height:100%;
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


            <!-- Page Content -->
            <main>
            <div class="row"> 
      <div class="col"> &nbsp;&nbsp;&nbsp;</div> 
      <div class="col">
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
            <br>
                    <table>
                    
                    <tr class="text-center">
                        <td> <div style="font-size:17px" class="badge badge-danger badge-outlined"> Cliente: &nbsp; </div></td>
                        <td> <div  style="font-size:17px" class="badge badge-primary badge-outlined"> <?php echo e($Customers->customer); ?> <?php if($Customers->legal_name!= 'POR ASIGNAR'): ?><?php echo e($Customers->legal_name); ?> <?php endif; ?></div>  </td>
                        <td > <div   style="font-size:17px" class="badge badge-danger badge-outlined"> Subtotal:</div> </td> 
                        <td ><div   style="font-size:17px" class="badge badge-primary badge-outlined"> <?php echo e($Coins->symbol); ?><?php echo e(number_format($InternalOrders->subtotal,2)); ?> </div></td>
                        <td >- &nbsp;&nbsp;&nbsp; - </td>
                        <td> - &nbsp;&nbsp;&nbsp; -</td>
                    
                    </tr>
                    <tr class="text-center">
                        <td> <div class="badge badge-danger badge-outlined"> Moneda:</div></td>
                        <td> <div class="badge badge-primary badge-outlined"><?php echo e($Coins->coin); ?> </div>  </td>
                        <td > <div class="badge badge-danger badge-outlined"> IVA:</div> </td> 
                        <td ><div class="badge badge-primary badge-outlined"> <?php echo e($Coins->symbol); ?><?php echo e(number_format($InternalOrders->subtotal*0.16,2)); ?> </div></td>
                        <td > &nbsp;&nbsp;&nbsp;  </td>
                        <td>  &nbsp;&nbsp;&nbsp; </td>
                    
                    </tr><tr class="text-center">
                        <td> <div class="badge badge-danger badge-outlined"> Fecha:</div></td>
                        <td> <div class="badge badge-primary badge-outlined"><?php echo e($InternalOrders->reg_date); ?></div>  </td>
                        <td > <div class="badge badge-danger badge-outlined"> Total:</div> </td> 
                        <td ><div class="badge badge-primary badge-outlined"> <?php echo e($Coins->symbol); ?><?php echo e(number_format($InternalOrders->total,2)); ?> </div></td>
                        <td > -&nbsp;&nbsp;&nbsp; - </td>
                        <td> - &nbsp;&nbsp;&nbsp; -</td>
                    
                    </tr>
                    </table>
                    <br><br>
                    <!-- espacio -->
                    <table>
                      
                  <tr>
                  <td rowspan="2"> <div class="badge badge-danger badge-outlined"> <br> <br> PAGO <br> <br> <br> <br> <br>  </div></td>
                  <td colspan="4"> <div class="badge badge-danger badge-outlined"> <br>  &nbsp;&nbsp;&nbsp;&nbsp; PROGRAMADO &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br>  </div></td>
                  <td rowspan="2"> <div class="badge badge-danger badge-outlined"> <br> FACTURA <BR> NUMERO <br> <br> </div></td>
                  <td rowspan="2"> <div class="badge badge-danger badge-outlined"> <br> FECHA <BR>(D-M-A) <br> <br></div></td>
                  <td rowspan="2"> <div class="badge badge-danger badge-outlined"> <br> IMPORTE <BR>FACTURA <br> <br></div></td>
                  <td colspan="5"> <div class="badge badge-danger badge-outlined"> COMP. INGRESOS</div></td>
                  <td rowspan="2"> <div class="badge badge-danger badge-outlined"> <br> TIPO <BR> DE <BR> CAMBIO <br> <br></div></td>
                  <td colspan="2"> <div class="badge badge-danger badge-outlined"> <br>  EQUIVALENETE EN M.N.</div></td>
                  <td colspan="3"> <div class="badge badge-danger badge-outlined"> <br> VERIFICACION DEL COBRO</div></td>
                  </tr>
                  <tr>
                    
                    <td> <div class="badge badge-danger badge-outlined"> <br> MONEDA <br> <br> <br></div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> FECHA <BR>(D-M-A) <br> <br></div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> IMPORTE <br> IVA INCLUIDO  <br><br></div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> % DEL <br> PAGO <br> PARCIAL  <br></div></td>
                    
                    <td> <div class="badge badge-danger badge-outlined"> <br> <br> NUMERO <br> <br></div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> FECHA <BR>(D-M-A)<br> <br></div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> <br> MONEDA <br> <br></div></td>
                    <td> <div class="badge badge-danger badge-outlined"><br> <br> IMPORTE <br> IVA INCLUIDO <br> </div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> <br> % DEL <br> PAGO <br> PARCIAL <br></div></td>
                    
                    <td> <div class="badge badge-danger badge-outlined"> <br> IMPORTE <br> ACUMULADO <br> </div></td>
                    <td> <div class="badge badge-danger badge-outlined"><br>  % DEL <br> PAGO <br> ACUMULADO<br> </div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> CAPT <br> </div></td>
                    <td> <div class="badge badge-danger badge-outlined"><br>  G.A <br> </div></td>
                    <td> <div class="badge badge-danger badge-outlined"><br>  D.A <br></div></td>
                  
                  
                  </tr>
             
                  <?php for($i=0;$i<$max;$i++): ?>
                  <tr>
                    
                  <?php if($i<$hpagos->count()): ?>
                  <td><div class="badge badge-primary badge-outlined"><?php echo e($i+1); ?></div></td>
                  <td><div class="badge badge-primary badge-outlined"><?php echo e($Coins->code); ?></div></td>
                  <td><div class="badge badge-primary badge-outlined"><?php echo e($hpagos[$i]->date); ?></div></td>
                  <td><div class="badge badge-primary badge-outlined"><?php echo e($Coins->symbol); ?> <?php echo e(number_format($hpagos[$i]->amount,2)); ?></div></td>
                  <td><div class="badge badge-primary badge-outlined"><?php echo e(number_format($hpagos[$i]->percentage,2)); ?> %</div></td>
                  <?php else: ?>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  
                  <?php endif; ?>
                  <!-- datos de las facturas -->
                    <?php if($i<$facturas->count()): ?>
                  <td><div class="badge badge-primary badge-outlined"><?php echo e($facturas[$i]->facture); ?> </div></td>
                  <td><div class="badge badge-primary badge-outlined"><?php echo e($facturas[$i]->date); ?> </div></td>
                  <td><div class="badge badge-primary badge-outlined"><?php echo e($Coins->symbol); ?> <?php echo e(number_format($facturas[$i]->amount,2)); ?> </div></td>
                    <?php endif; ?>
                  </tr>
                  
                  <?php endfor; ?>
                  <tr>
                    <td> <br></td>
                  </tr>
                  <tr>
                  <td></td>
                  <td></td>
                  <td> <div style="font-size:15px"  class="badge badge-danger badge-outlined"> Totales</div></td>
                  <td> <div style="font-size:15px" class="badge badge-primary badge-outlined"> <?php echo e($Coins->symbol); ?> <?php echo e(number_format($hpagos->sum('amount'),2)); ?></div></td>
                  <td> <div style="font-size:15px" class="badge badge-primary badge-outlined"> <?php echo e($hpagos->sum('percentage')); ?> %</div></td>
                  </tr>
                  <tr>
                  <td></td>
                  <td></td>
                  <td> <div class="badge badge-danger badge-outlined"> Debe ser 0</div></td>
                  <td> <div class="badge badge-primary badge-outlined"> $ 0 </div></td>
                  <td> <div class="badge badge-primary badge-outlined">  0% </div></td>
                  </tr><tr>
                  <td></td>
                  <td></td>
                  <td> <div class="badge badge-danger badge-outlined"> Validacion</div></td>
                  <td> <div class="badge badge-primary badge-outlined"> OK</div></td>
                  <td> <div class="badge badge-primary badge-outlined"> OK</div></td>
                  </tr>
                    </table>

                    </div>
      <div class="col"></div>
    </div>
            </main>
        </div>

        <?php echo $__env->yieldPushContent('modals'); ?>

        <!-- Bootstrap 5.0 Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        
        <!-- DataTables  -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.3.1/jszip-2.5.0/dt-1.10.25/af-2.3.7/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/cr-1.5.4/date-1.1.0/fc-3.3.3/fh-3.1.9/kt-2.6.2/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.4/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js"></script>

        <!-- JQuery 3.x -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <!-- CDN Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Sweet Alert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js" integrity="sha256-qIEdjJD0ON7AbXQpi7N1CBcZy2AqQNoyWXLMTye8Qbc=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

        <?php echo $__env->yieldPushContent('js'); ?>

        <?php if(session('no_existe') == 'ok'): ?>
            <script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/no_existe.js')); ?>"></script>
        <?php endif; ?>

        <?php echo \Livewire\Livewire::scripts(); ?>


        <script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tableActions.js')); ?>"></script>

        
        <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>

        <script>
            ClassicEditor
                .create( document.queryselector('#editor'))
                .catch( error => {
                    console.error(error);
                });
        </script>
    </body>
</html><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/reportes/otrotest.blade.php ENDPATH**/ ?>