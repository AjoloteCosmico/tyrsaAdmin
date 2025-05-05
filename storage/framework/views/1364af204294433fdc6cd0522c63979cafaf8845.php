

<?php $__env->startSection('title', 'PEDIDOS INTERNOS'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp; PEDIDO INTERNO</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>     
<div class="page">
    <?php if($InternalOrders->status=='CANCELADO'): ?>
    <div class="watermark">Cancelado</div>
    <?php endif; ?>
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg" id='content'>
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm" >
                <table class=" table-responsive text-xs" style="border: none; border-collapse: collapse;">
                        <tr style="border: none; border-collapse: collapse;"><td style="border: none; border-collapse: collapse;"> &nbsp; &nbsp; &nbsp;</td>
                            <td style="border: none; border-collapse: collapse;">
                                <div class="contaier">
                        
                                                <img src="<?php echo e(asset('img/logo/logo.svg')); ?>" alt="TYRSA"  style="align-self: left;"> </div></td>
                                        </td>
                                 
                            <td rowspan="2" style="border: none; border-collapse: collapse;">
                        <br>
            Calle Cuernavaca S/N, Col. Ejido del Quemado,<br>
            C.P. 54,963, Tultepec, Edo. México,<b> R.F.C.</b>  <br> <br>
            TCO990507S91 Tels: (55) 26472033 / 26473330 <br>
 <div style="text-transform: lowercase;"> info@tyrsa.com.mx <b> <a href="https://www.tyrsa.com.mx"> www.tyrsa.com.mx</a> </b>    <br>
                        <!-- Domicilio Fiscal:
                                <?php echo e($CompanyProfiles->street.' '.$CompanyProfiles->outdoor.' '); ?>

                                <?php echo e($CompanyProfiles->intdoor.' '.$CompanyProfiles->suburb); ?>

                                <br><?php echo e($CompanyProfiles->city.' '.$CompanyProfiles->state.' '.$CompanyProfiles->zip_code); ?><br>
                                R.F.C: <?php echo e($CompanyProfiles->rfc); ?> &nbsp; Tels: 01-52 <?php echo e($CompanyProfiles->telephone.', '.$CompanyProfiles->telephone2); ?> <br> E-mail: <?php echo e($CompanyProfiles->email); ?> &nbsp; Web: <?php echo e($CompanyProfiles->website); ?>

                             -->
                        </td>
                        <td rowspan="2" style="border: none; border-collapse: collapse;">
                        <table>
                            <tr> <th colspan="2"> P.I. Numero:</th></tr>
                            <tr> <td colspan="2" style="font-size: 1.8vw; padding: 0.5vw; color: blue">  <?php echo e($InternalOrders->invoice); ?></td></tr>
                            <tr> <th>NOHA: </th> <td style="font-size: 1.0vw; padding: 0.2vw"> <?php echo e($InternalOrders->noha); ?> </td></tr>
                        </table>
                          <br>     
                        <table>
                            <tr> <th> semana </th>
                                <th colspan="2"> Fechas (dd-mm-aa):</th></tr>
                            <tr>  <td><?php echo e(date('W', strtotime($InternalOrders->reg_date))); ?>  </td> <th>Emision: </th> <td> <?php echo e(date('d - m - Y', strtotime($InternalOrders->reg_date))); ?>  </td></tr>
                            <tr>  <td> <?php echo e(date('W', strtotime($InternalOrders->date_delivery))); ?>   </td> <th>E. equipo: </th> <td> <?php echo e(date('d - m - Y', strtotime($InternalOrders->date_delivery))); ?>  </td></tr>
                            <tr>  <td> <?php echo e(date('W', strtotime($InternalOrders->instalation_date))); ?>   </td> <th>E. Final: </th> <td> <?php echo e(date('d - m - Y', strtotime($InternalOrders->instalation_date))); ?>  </td></tr>
                        </table>


                            </td>
                        </tr>
                        
                            
                        <td  colspan="2"class="text-lg " style="color: red;  width:23%; border: none; border-collapse: collapse;"><?php echo e($CompanyProfiles->company); ?>

                        </td>
                        <tr>
                                           
                        </tr >

                    </table>

</div>

            
            <h5 class="text-lg text-center text-bold">PEDIDO INTERNO</h5>
            <br>
                  <!-- 14 columas, para poder copiar del excel -->
            <table >
                <tr><th colspan="14">Datos del Cliente</th></tr>
                    <tr class="text-center">
                        <th colspan="2"> Numero del cliente:</th>
                        <td colspan="2"> <?php echo e($Customers->clave); ?> </td>
                        <th colspan="2">  Nombre corto: </th> 
                        <td colspan="4"><?php echo e($Customers->alias); ?> </td>
                        <th colspan="2">CP: </th>
                        <td colspan="2"> <?php echo e($Customers->customer_zip_code); ?> </td>
                    </tr>

                    <tr>
                        <th colspan="2"> Razon Social: <br> </th>
                        <td colspan="12"> <?php echo e($Customers->customer); ?> <br> <br> </td>
                    </tr>

                    <tr>
                        <th colspan="2"> Regimen de Capital: </th>
                        <td colspan="12"> S.A DE C.V </td>
                    </tr>

                    <tr>
                        <th colspan="2"> Regimen Fiscal: </th>
                        <td colspan="12"> REGIMEN GENERAL DE PERSONAS MORALES </td>
                    </tr>
                    
                    <tr>
                        <th colspan="2"> RFC</th>
                        <td colspan="2"> <?php echo e($Customers->customer_rfc); ?></td>
                        <th colspan="2"> cot no: </th>
                        <td colspan="3"> <?php if($InternalOrders->ncotizacion !=0): ?> <?php echo e($InternalOrders->ncotizacion); ?> <?php else: ?> - <?php endif; ?></td>
                        <th colspan="2"> contrato no: </th>
                        <td colspan="3">  <?php if($InternalOrders->ncontrato !=0): ?> <?php echo e($InternalOrders->ncontrato); ?> <?php else: ?> - <?php endif; ?></td>
                    </tr>

                    <tr>
                        <th colspan="2" rowspan="2"> Domicilio Fiscal <br> <br> </th>
                        <td colspan="12" style="word-wrap: break-word">  <?php echo e($Customers->customer_street.' '.$Customers->customer_outdoor.' '.$Customers->customer_intdoor.' '.$Customers->customer_suburb); ?> <br> <?php echo e($Customers->customer_city.' '.$Customers->customer_state.' '.$Customers->customer_zip_code); ?> </td>
                    </tr>
                    <tr>
                        <td colspan="7" > </td>
                        <th> telefono</th>
                        <td colspan="4" ><?php echo e($Customers->customer_telephone); ?></td>
                    </tr>

                    <tr>
                        <th rowspan="3">  Embarque</th>
                        <td rowspan="3"> <?php if($InternalOrders->shipment=="No"): ?> NO <?php else: ?> SI <?php endif; ?></td>
                        <th colspan="3"> Domicilio de Embarque </th>
                        <td colspan="9">  <?php if($InternalOrders->shipment=="No"): ?> <?php else: ?>  <?php echo e($CustomerShippingAddresses->customer_shipping_city.' '.$CustomerShippingAddresses->customer_shipping_suburb); ?> <br> <?php echo e($CustomerShippingAddresses->customer_shipping_street.' '.$CustomerShippingAddresses->customer_shipping_indoor); ?>  <?php endif; ?></td>
                    </tr>

                    <tr>
                        <td colspan="12">  <br></td>
                    </tr>

                    <tr>
                        <td colspan="10"> </td>
                        <th> cp:</th>
                        <td><?php echo e($CustomerShippingAddresses->customer_shipping_zip_code); ?> </td>
                    </tr>

                    <tr>
                        <th>vendedor:  </th>
                        <td> <?php echo e($Sellers->iniciales); ?> </td>
                        
                        <th colspan="2"> no. vendedor:</th>
                        <td >  <?php echo e($Sellers->folio); ?></td>
                        
                        <th colspan="2">Comision del vend:</th>

                        <td colspan="2">  <?php echo e(number_format($InternalOrders->comision * 100,2)); ?> %</td>
                        <th colspan="2">O.C:</th>
                        <td>  <?php echo e($InternalOrders->oc); ?> </td>
                        <th> Moneda:</th>
                        <td>  <?php echo e($Coins->code); ?> </td>
                    </tr>
                    <tr>
                        <th colspan="2">categoria del proyecto:  </th>
                        <td colspan="2"> <?php echo e($InternalOrders->category); ?> </td>
                        
                        <th colspan="4">Descripcion global del proyecto:  </th>
                        <td colspan="2"> <?php echo e($InternalOrders->description); ?> </td>
                        <th colspan="2">ubicacion de la tienda:  </th>
                        <td colspan="2" > Edomex </td>
                        
                        </tr>
                    </table>

               </div>
                
                <br> &nbsp;  
                <table>
                    <tr>
                        <th> Contacto   </th>
                        <th> Nombre </th>
                        <th>    Tel movil </th>
                        <th>    Tel fijo </th>
                        <th> Extension </th>
                        <th> Email empresrial &nbsp; &nbsp; &nbsp; </th>
                    </tr>
                    <?php
                        $contact_index=1;
                        ?>
                    <tbody>
                    <?php $__currentLoopData = $Contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td> <?php echo e($contact_index); ?> </td>
                        <td> <?php echo e($row->customer_contact_name); ?> </td>
                        <td> <?php echo e($row->customer_contact_mobile); ?> </td>
                        <td> <?php echo e($row->customer_contact_office_phone); ?> </td>
                        <td> <?php echo e($row->customer_contact_office_phone_ext); ?> </td>
                        <td><div style="text-transform: lowercase;"><?php echo e($row->customer_contact_email); ?></div></td>
                    </tr>
                        <?php 
                        $contact_index=$contact_index+1; 
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                
            <br> &nbsp;
            
           <h1>Descripcion de las partidas (Proyecto)</h1>
            <?php $__currentLoopData = $Items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <table style="text-align: center;">
                        
                            <tr class="text-center">
                                <th>Pda</th>
                                <th>Cant</th>
                                <th>Unidad</th>
                                <th>Familia</th>
                                <th>sku</th> 
                                <th>Precio unit(sin iva)</th>
                                <th  style="width:20%;" >Importe</th>
                            </tr>
                        
                        
                            <tr class="text-center">
                                <td> <?php echo e($row->item); ?></td>
                                <td> <?php echo e($row->amount); ?></div></td>
                                <td> <?php echo e($row->unit); ?></td>
                                <td> <?php echo e($row->sku); ?></td>
                                <td> <?php echo e($row->family); ?></td>
                                <td rowspan="2"> $<?php echo e(number_format($row->unit_price, 2)); ?></td>
                                <td rowspan="2"> $<?php echo e(number_format($row->import, 2)); ?>></td>
                            </tr>
                            <tr>
                                <td colspan="5"> <?php echo nl2br($row->description ); ?> </td>
                            </tr>
                    </table>
                    <br>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    

 <br>
            <!-- tablaunida -->
            <table>
                <tr>
                    <th>Numero de COBROs:</div></td>
                    <td> <?php echo e($payments->count()); ?></td>
                    <td style="border: none;"> </td><!-- celda de espacio -->
                    <th>Subtotal: </td>
                    <td> $ <?php echo e(number_format($InternalOrders->subtotal,2)); ?></td>
                       
                </tr>

                <tr> 
                    <th rowspan="2">Condiciones de PAGO: <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <br> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                    <td rowspan="2">  <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($pay->percentage); ?>% &nbsp; <?php echo e($pay->concept); ?>,<br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td  rowspan="2" style="border: none;"> </td><!-- celda de espacio -->
                    <th>Descuento: </td>
                        <td> $ <?php echo e(number_format($InternalOrders->descuento * $InternalOrders->subtotal,2)); ?> </td>
                       
                </tr>

                <tr>
                <th>I.E.P.S:</td>
                <td> $ <?php echo e(number_format($InternalOrders->ieps * $InternalOrders->subtotal,2)); ?></td>   
                </tr>
                
                <tr>
                    <th>Forma de pago:</th>
                    <td>  <?php $__currentLoopData = $payments->unique('payment_method')->pluck('payment_method'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($pay); ?> <?php if(!$loop->last): ?>, <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                    <td style="border: none;"> </td><!-- celda de espacio -->
                    <th>RET ISR:</td>
                    <td> $  <?php echo e(number_format($InternalOrders->isr * $InternalOrders->subtotal,2)); ?></td>
                </tr>
                
                <tr>
                    <th rowspan="3">Observaciones: <br> <br> <br> </th>
                    <td rowspan="3"> <?php echo e($InternalOrders->payment_observations); ?> </td>
                    <td  rowspan="3" style="border: none;"> </td><!-- celda de espacio -->
                    <th>RET IVA:</td>
                        <td> $  <?php echo e(number_format($InternalOrders->tasa* $Items->where('family','FLETE')->sum('import'),2)); ?></td>     
                </tr>
                <tr>
                        <th>IVA:</td>
                        <td> $  <?php echo e(number_format(0.16 * $InternalOrders->subtotal*(1-$InternalOrders->descuento),2)); ?></td>
                        </tr>
                        <tr>
                        <th>Total</td>
                        <td> $ <?php echo e(number_format($InternalOrders->total,2)); ?></td>
                        </tr>
            </table>
    

                <br>
                <?php
                $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
                
                $mystring=$formatterES->format(round($InternalOrders->total,2));
                $newstring = substr($mystring, 0, strrpos($mystring, 'coma'));
                
                if(strrpos($mystring, 'coma')==false){
                    $newstring = $mystring;
                }
                if($Coins->coin=='NACIONAL'){
                    $coin_name='PESOS';
                    $abrev_coin='M.N';
                }else{
                    $coin_name=$Coins->coin;
                    $abrev_coin='';
                }
                
                if(round($InternalOrders->total,2)*100%100==0){
                    $resto='';
                     
                }else{
                    $resto=strval((round($InternalOrders->total,2)*100%100) ).'/100';

                }
                                   ?>
                <table>
                    <tr>
                        <th> &nbsp; &nbsp; Son:&nbsp; &nbsp;  </th>
                        <td> <?php echo e($newstring.' '.$coin_name.' '.$resto.' '.$abrev_coin); ?>  </td>
                    </tr>
                </table>
               <br><br>&nbsp; <br>
        </div>
        </div>
        <div class="page">
        <?php if($InternalOrders->status=='CANCELADO'): ?>
    <div class="watermark">Cancelado</div>
    <?php endif; ?>
               <table >
               <tr> <th colspan="9" style="text-align: center;">   Tabla de Promesas de Cobros (Planeacion)</th> </tr>
                <tr>
                    <th rowspan="2">   <br> COBRO No. <br><br> &nbsp;</th>
                    <th rowspan="2">   <br> Fecha <br><br> Planeada </th>
                    <th rowspan="2">   <br> Dia<br> <br>(365 )&nbsp; </th>
                    <th rowspan="2">   <br> Semana <br><br>(52) &nbsp;</th>
                    <th colspan="3">   Importe por cobrar</th>
                    <th rowspan="2">   <br><br> % del Total<br><br> &nbsp;</th>
                </tr>
                <tr>
                    <th>Subtotal</div></td>
                    <th>Iva</div></td>
                    <th>Total con Iva</div></td>
                </tr>
                <tbody>
                    <?php
                    $p=0;
                    ?>
                    <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php
                    {{$datetime1 = new DateTime($pay->date);
                    $pdia=$datetime1->format('Y');
                    
                    $datetime2 = new DateTime($pdia."-1-1");
                    $dias = $datetime2->diff($datetime1)->format('%a')+1;
                    $p=$p+1;}}
                    ?>
                    <tr>
                        <td> <?php echo e($p); ?></div></td>
                        <td> <?php echo e(date('d - m - Y', strtotime($pay->date))); ?></div></td>
                        <td> <?php echo e($dias); ?></div></td>
                        <td> <?php echo e((int)floor($dias / 7)+1); ?></div></td>
                        <td> $<?php echo e(number_format((1-$InternalOrders->descuento)*$InternalOrders->subtotal *$pay->percentage*0.01,2)); ?></div></td>
                        <td> $<?php echo e(number_format((1-$InternalOrders->descuento)*$InternalOrders->subtotal *$pay->percentage*0.0016,2)); ?></div></td>
                        <td> $<?php echo e(number_format($pay->amount,2)); ?></div></td>
                        <td> <?php echo e($pay->percentage); ?> %</div></td>
                        
                    </tr>
                    
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>  
                        <th colspan="4">Totales:</div></td>
                        <td> $<?php echo e(number_format((1-$InternalOrders->descuento)*$InternalOrders->subtotal,2)); ?></div></td>
                        <td> $<?php echo e(number_format((1-$InternalOrders->descuento)*$InternalOrders->subtotal*0.16,2)); ?></div></td>
                        <td> $<?php echo e(number_format($payments->sum('amount'),2)); ?></div></td>
                        <td> 100%</div></td>
                    </tr>
                </tbody>
               </table>
                
               <br>&nbsp;
               <table style="text-align: center;" id="tabla-obsevaciones">
                <tr>
                    <th>Observaciones: </th>
                </tr>
                    <tr>
                        <td> <div class="com-text"> <?php echo e($InternalOrders->observations); ?></div></td>
                        
                    </tr>
               </table>
               <br>
               <table style="text-align: center;" id="tabla-obsevaciones">
                <tr>
                    <th>Kilos totales: </th>
                </tr>
                    <tr>
                        <td> <div class="com-text"> <?php echo e($InternalOrders->kilos); ?> KG</div></td>
                        
                    </tr>
               </table>
               

           
            
            <br> 
            <table>
            <tr class="text-center"><th colspan="7">Comision principal</th></tr>
                <tr class="text-center">
                    <th>Vendedor no.</th>
                    <th>Inicia</th>
                    <th>Descripcion</th>
                    <th>% </th>
                    <th>Monto sin IVA </th>
                    <th>Moneda </th>
                    <th>EQUIVALENTE EN  M.N. SIN IVA </th>
                 </tr>

               <br>
                 
                    <tr>
                        <td> <?php echo e($Sellers->folio); ?></td>
                        <td> <?php echo e($Sellers->iniciales); ?></td>
                        <td>  Comision Principal</td>
                        <td>  <?php echo e(number_format($InternalOrders->comision * 100,2)); ?> %</td>
                        <td>  $<?php echo e(number_format($InternalOrders->comision *(1-$InternalOrders->descuento)*$InternalOrders->subtotal ,2)); ?> </td>
                        <td> <?php echo e($Coins->code); ?></td>
                        <td>  $<?php echo e(number_format($Coins->exchange_sell*($InternalOrders->comision * (1-$InternalOrders->descuento)*$InternalOrders->subtotal) ,2)); ?> </td>
                    </tr>
                    
                    
                   <tr>
            </table>
            <br> 
           
             <br><br>

               <table style="border: none;">
                <tr  id="primer_tr" style="border: none;">
                    <td style="border: none; word-wrap: break-word; width: 20%;">
                    <table  style="border: none; ">
                        <tr style="border: none; border-collapse: collapse;">
                            <td style="border: none; word-wrap: break-word;">
                                Firma o codigo
                              <!--  <?php echo e($Sellers->seller_email.' '.$Sellers->seller_mobile); ?>-->
                              <br> <br>
                              
                            <hr style="border-top: 0.3vw solid black; border-color:#000000; width: 90%">
                               
                              <p style="color:red"> Elaboró </p><br>
                                   <?php echo e($Sellers->firma); ?>

                            </td>
                        </tr>
                    </table>
                </td>

                    <?php $__currentLoopData = $requiredSignatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $firma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
       
<td style="border: none;  width: 20%;">
       <ul>
           <li>
               <div class="row" style="padding:0.5vw">


                   <?php if($firma->status == 0): ?>
                   <form action="<?php echo e(route('internal_orders.firmar')); ?>" method="POST" enctype="multipart/form-data">
                   <?php echo csrf_field(); ?>
                   <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'hidden','name' => 'signature_id','value' => ''.e($firma->id).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'hidden','name' => 'signature_id','value' => ''.e($firma->id).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                   <div class="col" >
                       <span class="text-xs uppercase" >Firma: <?php echo e($firma->job); ?> --</span><br>
                   </div>

                   <div class="col">
                       <div class="row">
                           <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'password','name' => 'key','class' => 'w-flex text-xs']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'password','name' => 'key','class' => 'w-flex text-xs']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                       </div>
                       <div class="row">
                           <button class="btn btn-green">Firmar</button>
                       </div>
                   </div>
                   </form>
                   <?php else: ?>
                   <table  style="border: none; border-collapse: collapse;">
                       <tbody>
                           <tr style="font-size:16px; font-weight:bold" style="border: none;"><td style="border: none;"><?php echo e($firma->firma); ?> <br>  <hr style="border-top: 0.3vw solid black; border-color:#000000; width: 90%">
                              </td></tr>
                           <tr style="border: none;"><td style="border: none;"><span style="font-size: 17px"> <i style="color : green"  class="fa fa-check-circle" aria-hidden="true"></i> Autorizado por  <?php echo e($firma->job); ?> </span>
                   </td></tr>
                       </tbody>
                   </table>
                    
                   <br><br><br><br>
                   <?php endif; ?>
               </div>
           </li>
       </ul>
       </td>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

   <?php for($i = $requiredSignatures->count()+1 ; $i <= 4; $i++): ?>
   <td style="border: none;"><table  style="border: none; ">
                        <tr style="border: none; border-collapse: collapse;">
                            <td style="border: none; word-wrap: break-word;">
                                Firma o codigo
                              <!--  <?php echo e($Sellers->seller_email.' '.$Sellers->seller_mobile); ?>-->
                              <br> <br>
                              
                             
                              <p style="color:red"> Autorizacion <?php echo e($i); ?> </p><br>
                                   Iniciales
                            </td>
                        </tr>
                    </table></td>
    <?php endfor; ?>
                </tr>
               </table>
               
<br>
<hr>
<br>
<h4 style="size:2.1vw">OTROS FORMULARIOS: </h4>
<br>
<form action="<?php echo e(route('internal_orders.asignar_marca')); ?>" method="POST" enctype="multipart/form-data">
                   <?php echo csrf_field(); ?>
                   <input type="hidden" name="order_id" value="<?php echo e($InternalOrders->id); ?>">
MARCA:
<select name="marca" value="<?php echo e($InternalOrders->marca); ?>">
    <option value="">Ninguna marca asignada</option>
    <?php $__currentLoopData = $Marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($row->id); ?>" <?php if($InternalOrders->marca==$row->id): ?> selected <?php endif; ?>><?php echo e($row->name); ?> </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<button class="btn btn-blue mb-2" type="submit"> Asignar marca</button> 
              
</form>
<hr>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('VER DGI')): ?>
                    <br> <br>
                    <center> <h1> CONFIDENCIAL</h1> </center>
<br>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ASIGNAR DGI')): ?>
                    <!-- que aparezca solo si el pedido no esta aut -->
                <a href="<?php echo e(route('change_dgi',$InternalOrders->id)); ?>"><button class="btn btn-black mb-2"> Asignar dgi</button>  </a>
                <br> 
                    <?php endif; ?>
                    <table>
                <tr class="text-center"><th colspan="7">DGI</th></tr>
                <tr class="text-center">
                    <th>Vendedor no.</th>
                    <th>Inicia</th>
                    <th>Descripcion</th>
                    <th>% </th>
                    <th>Monto sin IVA </th>
                    <th>Moneda </th>
                    <th>EQUIVALENTE EN  M.N. SIN IVA </th>
                 </tr>

               <br>
                 <?php $__currentLoopData = $Comisiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td> <?php echo e($c->id); ?></td>
                        <td> <?php echo e($c->iniciales); ?></td>
                        <td>  <?php echo e($c->description); ?></td>
                        <td>  <?php echo e($c->percentage * 100); ?> %</td>
                        <td>  $<?php echo e(number_format(($c->percentage * (1-$InternalOrders->descuento)*$InternalOrders->subtotal) ,2)); ?>   </td>
                        <td> <?php echo e($Coins->code); ?></td>
                        <td>  $<?php echo e(number_format($Coins->exchange_sell*($c->percentage * (1-$InternalOrders->descuento)*$InternalOrders->subtotal)  ,2)); ?> </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                   <tr>
                    <th colspan="3">Totales:</th>
                    <th> <?php echo e($Comisiones->sum('percentage')*100); ?> %</div></td>
                    <th> $<?php echo e(number_format($InternalOrders->total*$Comisiones->sum('percentage')/1.16 ,2)); ?></div></td>
                    <th> <?php echo e($Coins->code); ?></td>
                    <th> $<?php echo e(number_format($Coins->exchange_sell*($InternalOrders->total*$Comisiones->sum('percentage')/1.16) ,2)); ?> </td>
                   </tr>
                 
                </tbody>

               </table>
               <?php endif; ?>


                <br><br>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('VER DGI')): ?>
               <table align="left">

                <tr class="text-center"><th colspan="2">   Correos Personales </th></tr>
                <tr class="text-center">
                    <th>Contacto</td>
                    <th>Email Personal</td>
                 </tr>
                 
                 <?php $__currentLoopData = $Contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td> <?php echo e($row->id); ?></div></td>
                        <td><div style="text-transform: lowercase;"><?php echo e($row->customer_contact_email); ?></div></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </table> <?php endif; ?>

               <br>
            <?php if($InternalOrders->status == 'autorizado'): ?>
            <br><br><br><br><br>
                        <br><div> <p style ="font-size:150%; color: #31701F; font-weight:bolder">PEDIDO 100% AUTORIZADO</p> </div><br>
                                         
                
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('VER DGI')): ?>        
                <button type = "button" class="btn btn-red mb-2" onclick="confirm_unauthorize()"> <i class="fas fa-warning"> &nbsp; </i> Desautorizar</button>
                <?php endif; ?>   
                <br><br><br>
                    </div></div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('EDITAR PEDIDO AUTORIZADO')): ?>
                    <a href="<?php echo e(route('internal_orders.edit_order', $InternalOrders->id)); ?> "  class="btn btn-green mb-2">
                        <button type = "button" class="btn btn-green mb-2"> <i class="fas fa-edit"> &nbsp; Editar</i> </button>
                    </a>
                    
                    <?php endif; ?>
                <button type = "button" class="btn btn-red mb-2"  onclick="window.print();"> <i class="fas fa-file-pdf fa-xl"> &nbsp; PDF </i> </button>
                
                      
                    <?php else: ?> 
                    <br><br><br><br><br>
                    <div><p style ="font-size:150%; color: #DE3022;font-weight:bolder">FALTAN AUTORIZACIONES </p> </div>
                     
                    <br><br><br>
                    </div></div>
                    <a href="<?php echo e(route('internal_orders.edit_order', $InternalOrders->id)); ?> "  class="btn btn-green mb-2">
                    <button type = "button" class="btn btn-green mb-2"> <i class="fas fa-edit"> &nbsp; Editar</i> </button>
                                    </a>
                    
                    <button type = "button" class="btn btn-red mb-2"  onclick="window.print();"> <i class="fas fa-file-pdf fa-xl"> &nbsp; PDF </i> </button>
                
                <?php endif; ?>
                                    
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
                    <button id="downloadPdf">Exportar a PDF</button>
                    
        </div>
    </div>
    </div>
      
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>



<style>
    
      .watermark {
            position: fixed;
            top: 90%;
            left: 50%;
            transform: translate(-35%, -50%) rotate(-45deg);
            transform-origin: bottom left;
            font-size: 10vw;
            opacity: 0.3;
            color: red;
            z-index: 9999;
            pointer-events: none;
            white-space: nowrap;
            font-family: Arial, sans-serif;
            font-weight: bold;
            text-transform: uppercase;
        }
</style>
<style>
 
    @media print {
        <?php if($InternalOrders->status=='CANCELADO'): ?>
    
  
        .page {
    position: relative;
    /* Ajusta el tamaño según tu hoja, por ejemplo A4: 210×297 mm */
    /* width: 210mm;
    height: 297mm; */
    page-break-after: always;
    overflow: hidden;
  }

  .watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
    font-size: 8em;
    font-weight: bold;
    color: red;
    opacity: 0.3;
    pointer-events: none;
    white-space: nowrap;
  }
  <?php endif; ?>
  #printPageButton {
    display: none;
  }

  td, th {
    border: 1px solid black !important; /* Fuerza los bordes */
    padding: 0.2vw;
  }

  th {
    color: white !important; /* Asegura que el texto de las cabeceras se mantenga blanco */
    background-color: black !important; /* O agrega un fondo oscuro si lo necesitas */
  }

  tr:first-child th {
    border-top: none !important;
  }

  tr:last-child th {
    border-bottom: none !important;
  }

  tr th:first-child {
    border-left: none !important;
  }

  tr th:last-child {
    border-right: none !important;
  }

  .com-text {
    white-space: pre-wrap;
    word-wrap: break-word;
  }
}
    td{
        border: 1px solid black;
        padding: 0.2vw;
    }
    th{
        border: 1px solid white;
        padding: 0.2vw;
    }
 
tr:first-child th {
  border-top: none;
}

tr:last-child th {
  border-bottom: none;
}

tr th:first-child {
  border-left: none;
}

tr th:last-child {
  border-right: none;
}
.com-text{
    white-space: pre-wrap;
      word-wrap: break-word;
}

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>

<script>
  document.getElementById("downloadPdf").addEventListener("click", () => {
    const element = document.getElementById("content");
    const opt = {
      margin: 0,
      filename: 'documento.pdf',
      html2canvas: { scale: 1 },
      jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(element).save();
  });
</script>
<script>
    $('#badge').css('height', $('#badge').parent('td').height());
</script>
<script>
    function confirm_unauthorize(){
        Swal.fire({
            icon: 'warning',
            title: "<i>¿Estas seguro que deseas desautorizar este pedido?</i>", 
            html: `EL pedido regresara al status <b>CAPTURADO</b> <br> 
                <form action="<?php echo e(route('internal_orders.unautorize',$InternalOrders->id)); ?>" method='POST' enctype='multipart/form-data'>
                    <?php echo csrf_field(); ?> 
                    <br>

                    <input type='password' name='password'> 
                    <button type="submit" class="btn btn-warning " style="background-color: #FCBF26"> Confirmar </button>
                    </form> ` ,  
                    showCancelButton: true,
                    showConfirmButton: false,

            });
                }
    
</script>

<?php if(session('unautorized') == 'ok'): ?>
<script>
      Swal.fire({
            icon: 'success',
            title: "<i>El pedido se desautorizo con exito</i>", 
            html: `El pedido ha regresado a status CAPTURADO` ,  
                    showCancelButton: false,
                    showConfirmButton: true,

            });
</script>
<?php endif; ?>

<?php if(session('unautorized') == 'fail'): ?>
<script>
      Swal.fire({
            icon: 'error',
            title: "<i>El pedido no se desautorizó</i>", 
            html: `la contraseña es incorrecta` ,  
                    showCancelButton: false,
                    showConfirmButton: true,

            });
</script>
<?php endif; ?>

<?php if(session('markasigned') == 'ok'): ?>
<script>
      Swal.fire({
            icon: 'success',
            title: "<i>El Se asigno con exito una marca al pedido</i>", 
            html: "El pedido ha sido registrado como fabricado o integrado por <?php echo e($Marcas->where('id',$InternalOrders->marca)->first()->name); ?>" ,  
                    showCancelButton: false,
                    showConfirmButton: true,

            });
</script>
<?php endif; ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/internal_orders/show.blade.php ENDPATH**/ ?>