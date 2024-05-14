@extends('adminlte::page')

@section('title', 'PEDIDOS INTERNOS')

@section('content_header')
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp; PEDIDO INTERNO</h1>
@stop

@section('content')     <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm" >
                <table class=" table-responsive text-xs" style="border: none; border-collapse: collapse;">
                        <tr style="border: none; border-collapse: collapse;"><td style="border: none; border-collapse: collapse;"> &nbsp; &nbsp; &nbsp;</td>
                            <td style="border: none; border-collapse: collapse;">
                                <div class="contaier">
                        
                                                <img src="{{asset('img/logo/logo.svg')}}" alt="TYRSA"  style="align-self: left;"></td>
                                                </div></td>
                                 
                            <td rowspan="2" style="border: none; border-collapse: collapse;">
                        <br>
            Calle Cuernavaca S/N, Col. Ejido del Quemado,<br>
            C.P. 54,963, Tultepec, Edo. México,<b> R.F.C.</b>  <br> <br>
            TCO990507S91 Tels: (55) 26472033 / 26473330 <br>
 <div style="text-transform: lowercase;"> info@tyrsa.com.mx <b> <a href="https://www.tyrsa.com.mx"> www.tyrsa.com.mx</a> </b></div>     <br>
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
                                           
                        </tr >

                    </table>



            
            <h5 class="text-lg text-center text-bold">PEDIDO INTERNO</h5>
            <br>
            <div >
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
                        <td rowspan="3"> Si</td>
                        <th colspan="3"> Domicilio de Embarque </th>
                        <td colspan="9">  {{$CustomerShippingAddresses->customer_shipping_city.' '.$CustomerShippingAddresses->customer_shipping_suburb}} <br> {{$CustomerShippingAddresses->customer_shipping_street.' '.$CustomerShippingAddresses->customer_shipping_indoor}}</td>
                    </tr>

                    <tr>
                        <td colspan="12">  <br></td>
                    </tr>

                    <tr>
                        <td colspan="10"> </td>
                        <th>cp:</th>
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
                                <td> {{ $row->item }}</div></td>
                                <td> {{ $row->amount }}</div></td>
                                <td> {{ $row->unit }}</div></td>
                                <td> {{ $row->sku }}</div></td>
                                <td> {{ $row->family }}</div></td>
                                <td rowspan="2"> ${{number_format($row->unit_price, 2) }}</div></td>
                                <td rowspan="2"> ${{number_format($row->import, 2) }}</div></td>
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
                    <td> {{$payments->count()}}</div></td>
                    <td style="border: none;"> </td><!-- celda de espacio -->
                    <th>Subtotal: </td>
                    <td> $ {{number_format($InternalOrders->subtotal,2)}}</div></td>
                       
                </tr>

                <tr> 
                    <th rowspan="2">Condiciones de PAGO: @foreach($payments as $pay) <br> @endforeach</div></td>
                    <td rowspan="2">  @foreach($payments as $pay)
                        {{$pay->percentage}}% &nbsp; {{$pay->concept}},<br>
                        @endforeach</div>
                    </td>
                    <td  rowspan="2" style="border: none;"> </td><!-- celda de espacio -->
                    <th>Descuento: </td>
                        <td> $ {{number_format($InternalOrders->descuento * $InternalOrders->subtotal,2)}} </div></td>
                       
                </tr>

                <tr>
                <th>I.E.P.S:</td>
                <td> $ {{number_format($InternalOrders->ieps * $InternalOrders->subtotal,2)}}</div></td>   
                </tr>
                
                <tr>
                    <th>Forma de pago:</th>
                    <td> Transferencia Electronica</td>
                    <td style="border: none;"> </td><!-- celda de espacio -->
                    <th>RET ISR:</td>
                    <td> $  {{number_format($InternalOrders->isr * $InternalOrders->subtotal,2)}}</div></td>
                           
                    
                </tr>
                
                <tr>
                    <th rowspan="3">Observaciones: <br> <br> <br> </th>
                    <td rowspan="3"> <br> -<br> </td>
                    <td  rowspan="3" style="border: none;"> </td><!-- celda de espacio -->
                    <th>RET IVA:</td>
                        <td> $  {{number_format($InternalOrders->tasa* $Items->where('family','FLETE')->sum('import'),2)}}</div></td>
                        
                </tr>
                <tr>
                        <th>IVA:</td>
                        <td> $  {{number_format(0.16 * $InternalOrders->subtotal*(1-$InternalOrders->descuento),2)}}</div></td>
                        </tr>
                        <tr>
                        <th>Total</td>
                        <td> $ {{number_format($InternalOrders->total,2)}}</div></td>
                        </tr>
            </table>
    

                <br>
                @php
                $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
                
                @endphp
                <table>
                    <tr>
                        <th> &nbsp; &nbsp; Son:&nbsp; &nbsp;  </th>
                        <td> {{str_replace('coma','punto',$formatterES->format(round($InternalOrders->total,2)))}}  {{$Coins->coin}}</td>
                    </tr>
                </table>
               <br><br>&nbsp; <br>

               <table >
               <tr> <th colspan="9" style="text-align: center;">   Tabla de Promesas de Cobros (Planeacion) </div></th></tr>
               
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
                        <td> ${{number_format($InternalOrders->subtotal *$pay->percentage*0.01,2)}}</div></td>
                        <td> ${{number_format($InternalOrders->subtotal *$pay->percentage*0.0016,2)}}</div></td>
                        <td> ${{number_format($pay->amount,2)}}</div></td>
                        <td> {{$pay->percentage}} %</div></td>
                        
                    </tr>
                    
                    @endforeach
                    <tr>  
                        <th colspan="4">Totales:</div></td>
                        <td> ${{number_format($InternalOrders->subtotal,2) }}</div></td>
                        <td> ${{number_format($InternalOrders->subtotal*0.16,2) }}</div></td>
                        <td> ${{number_format($payments->sum('amount'),2) }}</div></td>
                        <td> 100%</div></td>
                    </tr>
                </tbody>
               </table>
                
               <br>&nbsp;
               <table style="text-align: center;" id="tabla-obsevaciones">
                <tr>
                    <th>Observaciones: </div></td>
                </tr>
                    <tr>
                        <td> <div class="com-text"> {{$InternalOrders->observations}}</div></div></td>
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
                    <th>Monto con IVA </th>
                    <th>Moneda </th>
                    <th>EQUIVALENTE EN  M.N. SIN IVA </th>
                 </tr>

               <br>
                 
                    <tr>
                        <td> {{$Sellers->id}}</td>
                        <td> {{$Sellers->iniciales}}</td>
                        <td>  Comision Principal</td>
                        <td>  {{ number_format($InternalOrders->comision * 100,2)}} %</td>
                        <td>  ${{number_format(($InternalOrders->comision * $InternalOrders->total)*100 / 1.16 ,2)}} </td>
                        <td> {{$Coins->code}}</td>
                        <td>  ${{number_format($Coins->exchange_sell*($InternalOrders->comision * $InternalOrders->total)*100 / 1.16 ,2)}} </td>
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
                              <!--  {{$Sellers->seller_email.' '.$Sellers->seller_mobile}}-->
                              <br> <br>
                              
                            <hr style="border-top: 0.3vw solid black; border-color:#000000; width: 90%">
                               
                              <p style="color:red"> Elaboró </p><br>
                                   {{$Sellers->firma}}
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
                   <div class="col">
                       <span class="text-xs uppercase">Firma: {{$firma->job}}</span><br>
                   </div>

                   <div class="col">
                       <div class="row">
                           <x-jet-input type="password" name="key" class="w-flex text-xs"/>
                       </div>
                       <div class="row">
                           <button class="btn btn-green">Firmar</button>
                       </div>
                   </div>
                   </form>
                   @else
                   <table  style="border: none; border-collapse: collapse;">
                       <tbody>
                           <tr style="font-size:16px; font-weight:bold" style="border: none;"><td style="border: none;">{{$firma->firma}} <br>  <hr style="border-top: 0.3vw solid black; border-color:#000000; width: 90%">
                              </td></tr>
                           <tr style="border: none;"><td style="border: none;"><span style="font-size: 17px"> <i style="color : green"  class="fa fa-check-circle" aria-hidden="true"></i> Autorizado por  {{$firma->job}} </span>
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
                              
                            <hr style="border-top: 0.3vw solid black; border-color:#000000; width: 90%">
                               
                              <p style="color:red"> Autorizacion {{$i}} </p><br>
                                   Iniciales
                            </td>
                        </tr>
                    </table></td>
    @endfor
                </tr>
               </table>
               

                @can('VER DGI')
                    <br> <br>
                    <center> <h1> CONFIDENCIAL</h1> </center>
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
                        <td>  ${{number_format(($c->percentage * (1-$InternalOrders->descuento)*$InternalOrders->subtotal) ,2)}} </td>
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
                                         

                    @else 
                    <br><br><br><br><br>
                    <div><p style ="font-size:150%; color: #DE3022;font-weight:bolder">FALTAN AUTORIZACIONES </p> </div>
                    @endif
                    <br><br><br>
                </div></div>
                     
                <button type = "button" class="btn btn-red mb-2"  onclick="window.print();"> <i class="fas fa-file-pdf fa-xl"> &nbsp; PDF </i> </button>
                <a href="{{ route('internal_orders.edit_order', $InternalOrders->id) }} " class="btn btn-green mb-2">
                <button type = "button" class="btn btn-green mb-2"> <i class="fas fa-edit"> &nbsp; Editar</i> </button>
                                    </a>

                  

                  
                   
                                    

                                    
                    
  
        </div>
    </div>
    
            
@stop

@section('css')
<style>
@media print {
  #printPageButton {
    display: none;
  }
}
</style>
<style>
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

@section('js')
<script>
    $('#badge').css('height', $('#badge').parent('td').height());
</script>

@stop