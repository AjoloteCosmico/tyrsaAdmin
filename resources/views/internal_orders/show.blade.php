@extends('adminlte::page')

@section('title', 'PEDIDOS INTERNOS')

@section('content_header')
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp; PEDIDO INTERNO</h1>
@stop

@section('content')     
<div class="page">
    @if($InternalOrders->status=='CANCELADO')
    <div class="watermark">Cancelado</div>
    @endif
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg" id='content'>
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm" >
                <table class=" table-responsive text-xs" style="border: none; border-collapse: collapse;">
                        <tr style="border: none; border-collapse: collapse;"><td style="border: none; border-collapse: collapse;"> &nbsp; &nbsp; &nbsp;</td>
                            <td style="border: none; border-collapse: collapse;">
                                <div class="contaier">
                        
                                                <img src="{{asset('img/logo/logo.svg')}}" alt="TYRSA"  style="align-self: left;"> </div></td>
                                        </td>
                                 
                            <td rowspan="2" style="border: none; border-collapse: collapse;">
                        <br>
            Calle Cuernavaca S/N, Col. Ejido del Quemado,<br>
            C.P. 54,963, Tultepec, Edo. México,<b> R.F.C.</b>  <br> <br>
            TCO990507S91 Tels: (55) 26472033 / 26473330 <br>
 <div style="text-transform: lowercase;"> info@tyrsa.com.mx <b> <a href="https://www.tyrsa.com.mx"> www.tyrsa.com.mx</a> </b>    <br>
                        <!-- Domicilio Fiscal:
                                {{$CompanyProfiles->street.' '.$CompanyProfiles->outdoor.' '}}
                                {{$CompanyProfiles->intdoor.' '.$CompanyProfiles->suburb}}
                                <br>{{$CompanyProfiles->city.' '.$CompanyProfiles->state.' '.$CompanyProfiles->zip_code}}<br>
                                R.F.C: {{$CompanyProfiles->rfc}} &nbsp; Tels: 01-52 {{$CompanyProfiles->telephone.', '.$CompanyProfiles->telephone2}} <br> E-mail: {{$CompanyProfiles->email}} &nbsp; Web: {{$CompanyProfiles->website}}
                             -->
                        </td>
                        <td rowspan="2" style="border: none; border-collapse: collapse;">
                        <table>
                            <tr> <th colspan="2"> P.I. Numero:</th></tr>
                            <tr> <td colspan="2" style="font-size: 1.8vw; padding: 0.5vw; color: blue">  {{$InternalOrders->invoice}}</td></tr>
                            <tr> <th>NOHA: </th> <td style="font-size: 1.0vw; padding: 0.2vw"> {{$InternalOrders->noha}} </td></tr>
                        </table>
                          <br>     
                        <table>
                            <tr> <th> semana </th>
                                <th colspan="2"> Fechas (dd-mm-aa):</th></tr>
                            <tr>  <td>{{date('W', strtotime($InternalOrders->reg_date))}}  </td> <th>Emision: </th> <td> {{date('d - m - Y', strtotime($InternalOrders->reg_date))}}  </td></tr>
                            <tr>  <td> {{date('W', strtotime($InternalOrders->date_delivery))}}   </td> <th>E. equipo: </th> <td> {{date('d - m - Y', strtotime($InternalOrders->date_delivery))}}  </td></tr>
                            <tr>  <td> {{date('W', strtotime($InternalOrders->instalation_date))}}   </td> <th>E. Final: </th> <td> {{date('d - m - Y', strtotime($InternalOrders->instalation_date))}}  </td></tr>
                        </table>

                            </td>
                        </tr>

                        <td  colspan="2"class="text-lg " style="color: red;  width:23%; border: none; border-collapse: collapse;">{{ $CompanyProfiles->company}}
                        </td>
                        <tr>              
                        </tr>

                    </table>
    </div>
            
            <h5 class="text-lg text-center text-bold">PEDIDO INTERNO</h5>
            <br>
                  <!-- 14 columas, para poder copiar del excel -->
            <table >
                <tr><th colspan="14">Datos del Cliente</th></tr>
                    <tr class="text-center">
                        <th colspan="2"> Numero del cliente:</th>
                        <td colspan="2"> {{$Customers->clave}} </td>
                        <th colspan="2">  Nombre corto: </th> 
                        <td colspan="4">{{$Customers->alias}} </td>
                        <th colspan="2">CP: </th>
                        <td colspan="2"> {{$Customers->customer_zip_code}} </td>
                    </tr>

                    <tr>
                        <th colspan="2"> Razon Social: <br> </th>
                        <td colspan="12"> {{$Customers->customer}} <br> <br> </td>
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
                        <td colspan="2"> {{$Customers->customer_rfc}}</td>
                        <th colspan="2"> cot no: </th>
                        <td colspan="3"> @if($InternalOrders->ncotizacion !=0) {{$InternalOrders->ncotizacion}} @else - @endif</td>
                        <th colspan="2"> contrato no: </th>
                        <td colspan="3">  @if($InternalOrders->ncontrato !=0) {{$InternalOrders->ncontrato}} @else - @endif</td>
                    </tr>

                    <tr>
                        <th colspan="2" rowspan="2"> Domicilio Fiscal <br> <br> </th>
                        <td colspan="12" style="word-wrap: break-word">  {{$Customers->customer_street.' '.$Customers->customer_outdoor.' '.$Customers->customer_intdoor.' '.$Customers->customer_suburb}} <br> {{$Customers->customer_city.' '.$Customers->customer_state.' '.$Customers->customer_zip_code}} </td>
                    </tr>
                    <tr>
                        <td colspan="7" > </td>
                        <th> telefono</th>
                        <td colspan="4" >{{$Customers->customer_telephone}}</td>
                    </tr>

                    <tr>
                        <th rowspan="3">  Embarque</th>
                        <td rowspan="3"> @if($InternalOrders->shipment=="No") NO @else SI @endif</td>
                        <th colspan="3"> Domicilio de Embarque </th>
                        <td colspan="9">  @if($InternalOrders->shipment=="No") @else  {{$CustomerShippingAddresses->customer_shipping_city.' '.$CustomerShippingAddresses->customer_shipping_suburb}} <br> {{$CustomerShippingAddresses->customer_shipping_street.' '.$CustomerShippingAddresses->customer_shipping_indoor}}  @endif</td>
                    </tr>

                    <tr>
                        <td colspan="12">  <br></td>
                    </tr>

                    <tr>
                        <td colspan="10"> </td>
                        <th> cp:</th>
                        <td>{{$CustomerShippingAddresses->customer_shipping_zip_code}} </td>
                    </tr>

                    <tr>
                        <th>vendedor:  </th>
                        <td> {{$Sellers->iniciales}} </td>
                        
                        <th colspan="2"> no. vendedor:</th>
                        <td >  {{$Sellers->folio}}</td>
                        
                        <th colspan="2">Comision del vend:</th>

                        <td colspan="2">  {{ number_format($InternalOrders->comision * 100,2)}} %</td>
                        <th colspan="2">O.C:</th>
                        <td>  {{$InternalOrders->oc}} </td>
                        <th> Moneda:</th>
                        <td>  {{$Coins->code}} </td>
                    </tr>
                    <tr>
                        <th colspan="2">categoria del proyecto:  </th>
                        <td colspan="2"> {{$InternalOrders->category}} </td>
                        
                        <th colspan="4">Descripcion global del proyecto:  </th>
                        <td colspan="2"> {{$InternalOrders->description}} </td>
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
                    @php
                        $contact_index=1;
                        @endphp
                    <tbody>
                    @foreach($Contacts as $row)
                    <tr>
                        <td> {{$contact_index}} </td>
                        <td> {{$row->customer_contact_name}} </td>
                        <td> {{$row->customer_contact_mobile}} </td>
                        <td> {{$row->customer_contact_office_phone}} </td>
                        <td> {{$row->customer_contact_office_phone_ext}} </td>
                        <td><div style="text-transform: lowercase;">{{$row->customer_contact_email}}</div></td>
                    </tr>
                        @php 
                        $contact_index=$contact_index+1; 
                        @endphp
                    @endforeach
                    </tbody>
                </table>
                
            <br> &nbsp;
            
           <h1>Descripcion de las partidas (Proyecto)</h1>
            @foreach ($Items as $row)
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
                                <td> {{ $row->item }}</td>
                                <td> {{ $row->amount }}</div></td>
                                <td> {{ $row->unit }}</td>
                                <td> {{ $row->sku }}</td>
                                <td> {{ $row->family }}</td>
                                <td rowspan="2"> ${{number_format($row->unit_price, 2) }}</td>
                                <td rowspan="2"> ${{number_format($row->import, 2) }}></td>
                            </tr>
                            <tr>
                                <td colspan="5"> {!!  nl2br($row->description )!!} </td>
                            </tr>
                    </table>
                    <br>
                            @endforeach
                    

 <br>
            <!-- tablaunida -->
            <table>
                <tr>
                    <th>Numero de COBROs:</div></td>
                    <td> {{$payments->count()}}</td>
                    <td style="border: none;"> </td><!-- celda de espacio -->
                    <th>Subtotal: </td>
                    <td> $ {{number_format($InternalOrders->subtotal,2)}}</td>
                       
                </tr>

                <tr> 
                    <th rowspan="2">Condiciones de PAGO: @foreach($payments as $pay) <br> @endforeach</td>
                    <td rowspan="2">  @foreach($payments as $pay)
                        {{$pay->percentage}}% &nbsp; {{$pay->concept}},<br>
                        @endforeach
                    </td>
                    <td  rowspan="2" style="border: none;"> </td><!-- celda de espacio -->
                    <th>Descuento: </td>
                        <td> $ {{number_format($InternalOrders->descuento * $InternalOrders->subtotal,2)}} </td>
                       
                </tr>

                <tr>
                <th>I.E.P.S:</td>
                <td> $ {{number_format($InternalOrders->ieps * $InternalOrders->subtotal,2)}}</td>   
                </tr>
                
                <tr>
                    <th>Forma de pago:</th>
                    <td>  @foreach($payments->unique('payment_method')->pluck('payment_method') as $pay) {{$pay}} @if(!$loop->last), @endif @endforeach</td>
                    <td style="border: none;"> </td><!-- celda de espacio -->
                    <th>RET ISR:</td>
                    <td> $  {{number_format($InternalOrders->isr * $InternalOrders->subtotal,2)}}</td>
                </tr>
                
                <tr>
                    <th rowspan="3">Observaciones: <br> <br> <br> </th>
                    <td rowspan="3"> {{$InternalOrders->payment_observations}} </td>
                    <td  rowspan="3" style="border: none;"> </td><!-- celda de espacio -->
                    <th>RET IVA:</td>
                        <td> $  {{number_format($InternalOrders->tasa* $Items->where('family','FLETE')->sum('import'),2)}}</td>     
                </tr>
                <tr>
                        <th>IVA:</td>
                        <td> $  {{number_format(0.16 * $InternalOrders->subtotal*(1-$InternalOrders->descuento),2)}}</td>
                        </tr>
                        <tr>
                        <th>Total</td>
                        <td> $ {{number_format($InternalOrders->total,2)}}</td>
                        </tr>
            </table>
    

                <br>
                @php
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
                                   @endphp
                <table>
                    <tr>
                        <th> &nbsp; &nbsp; Son:&nbsp; &nbsp;  </th>
                        <td> {{ $newstring.' '.$coin_name.' '.$resto.' '.$abrev_coin }}  </td>
                    </tr>
                </table>
               <br><br>&nbsp; <br>
        </div>
        </div>
        <div class="page">
        @if($InternalOrders->status=='CANCELADO')
    <div class="watermark">Cancelado</div>
    @endif
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
                    @php
                    $p=0;
                    @endphp
                    @foreach($payments as $pay)
                    
                    @php
                    {{$datetime1 = new DateTime($pay->date);
                    $pdia=$datetime1->format('Y');
                    
                    $datetime2 = new DateTime($pdia."-1-1");
                    $dias = $datetime2->diff($datetime1)->format('%a')+1;
                    $p=$p+1;}}
                    @endphp
                    <tr>
                        <td> {{$p}}</div></td>
                        <td> {{date('d - m - Y', strtotime($pay->date))}}</div></td>
                        <td> {{$dias}}</div></td>
                        <td> {{(int)floor($dias / 7)+1}}</div></td>
                        <td> ${{number_format((1-$InternalOrders->descuento)*$InternalOrders->subtotal *$pay->percentage*0.01,2)}}</div></td>
                        <td> ${{number_format((1-$InternalOrders->descuento)*$InternalOrders->subtotal *$pay->percentage*0.0016,2)}}</div></td>
                        <td> ${{number_format($pay->amount,2)}}</div></td>
                        <td> {{$pay->percentage}} %</div></td>
                        
                    </tr>
                    
                    @endforeach
                    <tr>  
                        <th colspan="4">Totales:</div></td>
                        <td> ${{number_format((1-$InternalOrders->descuento)*$InternalOrders->subtotal,2) }}</div></td>
                        <td> ${{number_format((1-$InternalOrders->descuento)*$InternalOrders->subtotal*0.16,2) }}</div></td>
                        <td> ${{number_format($payments->sum('amount'),2) }}</div></td>
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
                        <td> <div class="com-text"> {{$InternalOrders->observations}}</div></td>
                        
                    </tr>
               </table>
               <br>
               <table style="text-align: center;" >
                <tr>
                    <th>Marca: </th>
                </tr>
                    <tr>
                        @if($InternalOrders->marca==0)
                        <td> <div class="com-text"> No hay marca asignada</div></td>
                        @else
                        <td> <div class="com-text"> {{$Marcas->where('id',$InternalOrders->marca)->first()->name}}</div></td>
                        @endif
                    </tr>
               </table>
               <br>
                <table style="text-align: center;" >
                <tr>
                    <th>Kilos totales: </th>
                </tr>
                    <tr>
                        <td> <div class="com-text"> {{$InternalOrders->kilos}} KG</div></td>
                        
                    </tr>
               </table>
             <br><br>

               <table style="border: none;">
                <tr  id="primer_tr" style="border: none;">
                    <td style="border: none; word-wrap: break-word; width: 20%;">
                    <table  style="border: none; ">
                        <tr style="border: none; border-collapse: collapse;">
                            <td style="border: none; word-wrap: break-word;">
                                {{$Sellers->firma}}
                              <!--  {{$Sellers->seller_email.' '.$Sellers->seller_mobile}}-->
                              <br> 
                            <hr style="border-top: 0.3vw solid black; border-color:#000000; width: 90%">
                               
                           <p> <i style="color : green"  class="fa fa-check-circle" aria-hidden="true"></i> Elaboró </p> <br>
                                   
                            </td>
                        </tr>
                    </table>
                </td>

                    @foreach ($requiredSignatures as $firma)
       
<td style="border: none;  width: 20%;">
       <ul>
           <li>
               <div class="row" style="padding:0.5vw">


                   @if($firma->status == 0)
                   <form action="{{ route('internal_orders.firmar') }}" method="POST" enctype="multipart/form-data">
                   @csrf
                   <x-jet-input type="hidden" name="signature_id" value="{{$firma->id}}"/>
                   <div class="col" >
                       <span class="text-xs uppercase" >Firma: {{$firma->titulo}} </span><br>
                   </div>

                   <div class="col">
                       <div class="row">
                           <x-jet-input type="password" name="key" class="w-flex text-xs"/>
                       </div>
                       <div class="row">
                           <button class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">Firmar</button>
                       </div>
                   </div>
                   </form>
                   @else
                   <table  style="border: none; border-collapse: collapse;">
                       <tbody>
                           <tr style="font-size:16px; font-weight:bold" style="border: none;"><td style="border: none;">{{$firma->firma}} <br>  <hr style="border-top: 0.3vw solid black; border-color:#000000; width: 90%">
                              </td></tr>
                           <tr style="border: none;"><td style="border: none;"><span style="font-size: 17px"> <i style="color : green"  class="fa fa-check-circle" aria-hidden="true"></i> Autorizado por  {{$firma->titulo}} </span>
                   </td></tr>
                       </tbody>
                   </table>
                    
                   <br><br><br><br>
                   @endif
               </div>
           </li>
       </ul>
       </td>
   @endforeach

   @for ($i = $requiredSignatures->count()+1 ; $i <= 4; $i++)
   <td style="border: none;"><table  style="border: none; ">
                        <tr style="border: none; border-collapse: collapse;">
                            <td style="border: none; word-wrap: break-word;">
                                Firma o codigo
                              <!--  {{$Sellers->seller_email.' '.$Sellers->seller_mobile}}-->
                              <br> <br>
                              
                             
                              <p style="color:red"> Autorizacion {{$i}} </p><br>
                                   Iniciales
                            </td>
                        </tr>
                    </table></td>
    @endfor
                </tr>
               </table>
               
<br>
<hr>
<br>
<h4 style="size:2.1vw">OTROS FORMULARIOS: </h4>
<br>
<hr>
                @can('VER DGI')
                    <br> <br>
                    <center> <h1> CONFIDENCIAL</h1> </center>
<br>
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
                        <td> {{$Sellers->folio}}</td>
                        <td> {{$Sellers->iniciales}}</td>
                        <td>  Comision Principal</td>
                        <td>  {{ number_format($InternalOrders->comision * 100,2)}} %</td>
                        <td>  ${{number_format($InternalOrders->comision *(1-$InternalOrders->descuento)*$InternalOrders->subtotal ,2)}} </td>
                        <td> {{$Coins->code}}</td>
                        <td>  ${{number_format($Coins->exchange_sell*($InternalOrders->comision * (1-$InternalOrders->descuento)*$InternalOrders->subtotal) ,2)}} </td>
                    </tr>

                   <tr>
            </table>
            <br> 
                    @can('ASIGNAR DGI')
                    <!-- que aparezca solo si el pedido no esta aut -->
                <a href="{{route('change_dgi',$InternalOrders->id)}}"><button class="btn btn-black mb-2"> Asignar dgi</button>  </a>
                <br> 
                    @endcan
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
                 @foreach($Comisiones as $c)
                    <tr>
                        <td> {{$c->id}}</td>
                        <td> {{$c->iniciales}}</td>
                        <td>  {{$c->description}}</td>
                        <td>  {{$c->percentage * 100}} %</td>
                        <td>  ${{number_format(($c->percentage * (1-$InternalOrders->descuento)*$InternalOrders->subtotal) ,2)}}   </td>
                        <td> {{$Coins->code}}</td>
                        <td>  ${{number_format($Coins->exchange_sell*($c->percentage * (1-$InternalOrders->descuento)*$InternalOrders->subtotal)  ,2)}} </td>
                    </tr>
                    @endforeach
                    
                   <tr>
                    <th colspan="3">Totales:</th>
                    <th> {{$Comisiones->sum('percentage')*100 }} %</div></td>
                    <th> ${{number_format($InternalOrders->total*$Comisiones->sum('percentage')/1.16 ,2) }}</div></td>
                    <th> {{$Coins->code}}</td>
                    <th> ${{number_format($Coins->exchange_sell*($InternalOrders->total*$Comisiones->sum('percentage')/1.16) ,2) }} </td>
                   </tr>
                 
                </tbody>

               </table>
               @endcan


                <br><br>
               @can('VER DGI')
               <table align="left">

                <tr class="text-center"><th colspan="2">   Correos Personales </th></tr>
                <tr class="text-center">
                    <th>Contacto</td>
                    <th>Email Personal</td>
                 </tr>
                 
                 @foreach($Contacts as $row)
                    <tr>
                        <td> {{$row->id}}</div></td>
                        <td><div style="text-transform: lowercase;">{{$row->customer_contact_email}}</div></td>
                    </tr>
                    @endforeach
                  </table> @endcan

               <br>
            @if($InternalOrders->status == 'autorizado')
            <br><br><br><br><br>
                        <br><div> <p style ="font-size:150%; color: #31701F; font-weight:bolder">PEDIDO 100% AUTORIZADO</p> </div><br>
                                         
                
               @can('VER DGI')        
                <button type = "button" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" mb-2" onclick="confirm_unauthorize()"> <i class="fas fa-warning"> &nbsp; </i> Desautorizar</button>
                @endcan   
                <br><br><br>
                    </div></div>
                    @can('EDITAR PEDIDO AUTORIZADO')
                        <a href="{{ route('internal_orders.edit_order', $InternalOrders->id) }} "  class="btn btn-green mb-2">
                            <button type = "button" class="btn btn-green mb-2"> <i class="fas fa-edit"> &nbsp; Editar</i> </button>
                        </a>
                    @endcan
                <!-- <a href="{{route('internal_orders.print_order',$InternalOrders->id)}}">
                                    <button type = "button" class="btn btn-red mb2 " style="background-color: rgb(220 ,38 ,38);color: white;"  > <i class="fas fa-file-pdf fa-xl"> &nbsp; PDF </i> </button> 

                                     </a>    -->
                    
                    <button type = "button" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" mb-2"  onclick="window.print();"> <i class="fas fa-file-pdf fa-xl"> &nbsp; PDF </i> </button>
                
                    @else 
                    <br><br><br><br><br>
                    <div><p style ="font-size:150%; color: #DE3022;font-weight:bolder">FALTAN AUTORIZACIONES </p> </div>
                        @if($requiredSignatures->where('status',1)->count() > 0)
                            @can('VER DGI')        
                                <button type = "button" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" mb-2" onclick="confirm_unauthorize()"> <i class="fas fa-warning"> &nbsp; </i> Desautorizar</button>
                            @endcan   
                        @endif
                     @if($InternalOrders->status != 'CANCELADO')
                    <br><br><br>
                    </div></div>
                        @can('EDITAR PEDIDOS')
                            @if($requiredSignatures->where('status',1)->count() == 0)
                        <a href="{{ route('internal_orders.edit_order', $InternalOrders->id) }} "  class="btn btn-green mb-2">
                        <button type = "button" class="btn btn-green mb-2"> <i class="fas fa-edit"> &nbsp; Editar</i> </button>
                                        </a>
                            @endif

                                     <!-- <a href="{{route('internal_orders.print_order',$InternalOrders->id)}}">
                                    <button type = "button" class="btn btn-red mb2 " style="background-color: rgb(220 ,38 ,38);color: white;"  > <i class="fas fa-file-pdf fa-xl"> &nbsp; PDF </i> </button> 

                                     </a>    -->
                        <button type = "button" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" mb-2"  onclick="window.print();"> <i class="fas fa-file-pdf fa-xl"> &nbsp; PDF </i> </button>
                    @endcan
                   @endif
                @endif
<!--                                     
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
                    <button id="downloadPdf">Exportar a PDF</button> -->
                    
        </div>
    </div>
    </div>
      
@stop

@section('css')



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
        @if($InternalOrders->status=='CANCELADO')
    
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
  @endif
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
@stop

@push('js')

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
                <form action="{{ route('internal_orders.unautorize',$InternalOrders->id)}}" method='POST' enctype='multipart/form-data'>
                    @csrf 
                    <br>

                    <input type='password' name='password'> 
                    <button type="submit" class="btn btn-warning " style="background-color: #FCBF26"> Confirmar </button>
                    </form> ` ,  
                    showCancelButton: true,
                    showConfirmButton: false,

            });
                }
    
</script>

@if (session('unautorized') == 'ok')
<script>
      Swal.fire({
            icon: 'success',
            title: "<i>El pedido se desautorizo con exito</i>", 
            html: `El pedido ha regresado a status CAPTURADO` ,  
                    showCancelButton: false,
                    showConfirmButton: true,

            });
</script>
@endif

@if (session('unautorized') == 'fail')
<script>
      Swal.fire({
            icon: 'error',
            title: "<i>El pedido no se desautorizó</i>", 
            html: `la contraseña es incorrecta` ,  
                    showCancelButton: false,
                    showConfirmButton: true,
            });

</script>
 
@endif

@if (session('markasigned') == 'ok')
<script>
      Swal.fire({
            icon: 'success',
            title: "<i>El Se asigno con exito una marca al pedido</i>", 
            html: "El pedido ha sido registrado como fabricado o integrado por {{ $Marcas->where('id',$InternalOrders->marca)->first()->name}}" ,  
                    showCancelButton: false,
                    showConfirmButton: true,

            });
</script>
@endif

@if (session('firma') == 'ok')
<script>
      Swal.fire({
            icon: 'success',
            title: "<i>La firma se registro correctamente</i>", 
            html: "Se ha completado la autorizacion por parte del usuario autorizado" ,  
                    showCancelButton: false,
                    showConfirmButton: true,

            });
</script>
@endif

@if (in_array(session('firma'),['Contraseña Incorrecta','Usuario no autorizado']))
<script>
      Swal.fire({
            icon: 'error',
            title: "<i>La firma no se ha completado</i>", 
            html: `{{session('firma')}}` ,  
                    showCancelButton: false,
                    showConfirmButton: true,
            });

</script>
 
@endif

@endpush