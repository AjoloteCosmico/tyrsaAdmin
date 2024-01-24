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
            C.P. 54,963, Tultepec, Edo. México, R.F.C. <br>
            TCO990507S91 Tels: (55) 26472033 / 26473330 <br>
 <div style="text-transform: lowercase;"> info@tyrsa.com.mx www.tyrsa.com.mx</div>     <br>
                        <!-- Domicilio Fiscal:
                                {{$CompanyProfiles->street.' '.$CompanyProfiles->outdoor.' '}}
                                {{$CompanyProfiles->intdoor.' '.$CompanyProfiles->suburb}}
                                <br>{{$CompanyProfiles->city.' '.$CompanyProfiles->state.' '.$CompanyProfiles->zip_code}}<br>
                                R.F.C: {{$CompanyProfiles->rfc}} &nbsp; Tels: 01-52 {{$CompanyProfiles->telephone.', '.$CompanyProfiles->telephone2}} <br> E-mail: {{$CompanyProfiles->email}} &nbsp; Web: {{$CompanyProfiles->website}}
                             -->
                        </td>
                        <td rowspan="2" style="border: none; border-collapse: collapse;">
                        <table>
                            <tr> <th colspan="2"> Requisicion numero:</th></tr>
                            <tr> <td colspan="2" style="font-size: 1.8vw; padding: 0.5vw">  {{$InternalOrders->invoice}}</td></tr>
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
            <table class="table table-responsive text-xs">
                <tr><th colspan="14">Datos del Cliete</th></tr>
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
                        <td colspan="12"> </td>
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
                        <td >  {{$Sellers->id}}</td>
                        
                        <th colspan="2">Comision del vend:</th>

                        <td colspan="2">  {{ number_format($InternalOrders->comision * 100,2)}} %</td>
                        <th colspan="2"> cot no:</th>
                        <td>  {{$InternalOrders->ncotizacion}} </td>
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
                        <th> Ext. </th>
                        <th> Email &nbsp; &nbsp; &nbsp; </th>
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
            
            
                    <table style="text-align: center;">
                        
                            <tr class="text-center">
                                <th>Pda</th>
                                <th>Cant</th>
                                <th>Unidad</th>
                                <th>Familia</th>
                                <th>sku</th> 
                                <th>Precio unit(sin iva)</th>
                                <th>Importe</th>
                            </tr>
                        
                        
                            @foreach ($Items as $row)
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
                            @endforeach
                    
                    </table>
                    
                    <table style="border: none; border-collapse: collapse;">

                        <tr style="border: none; border-collapse: collapse;">
                            <td style="border: none; border-collapse: collapse;">
                            <table  >
                   <tr>
                    <th>Numero de COBROs:</div></td>
                    <td> {{$payments->count()}}</div></td>
                   </tr>
                   <tr> 
                    <th>Condiciones de COBRO: @foreach($payments as $pay) <br> @endforeach</div></td>
                    <td>  @foreach($payments as $pay)
                        {{$pay->percentage}}% &nbsp; {{$pay->concept}},<br>
                        @endforeach</div>
                    </td>
                   </tr>
                   <tr>
                    <th>Promesas de Cobros:</div></td>
                    <td></td>
                   </tr>
                </table>
                            </td>
                            <td style="border: none; border-collapse: collapse;">
                            <table style="width:40%"align="right"> >
                        <tr>
                        <th>Subtotal: </div></td>
                        <td> $ {{number_format($InternalOrders->subtotal,2)}}</div></td>
                        </tr>
                        <tr>
                        <th>Descuento: </div></td>
                        <td> $ {{number_format($InternalOrders->descuento * $InternalOrders->subtotal,2)}} </div></td>
                        </tr>
                        <tr>
                        <th>I.E.P.S:</div></td>
                        <td> $ {{number_format($InternalOrders->ieps * $InternalOrders->subtotal,2)}}</div></td>
                        </tr>
                        <tr>
                        <th>RET ISR:</div></td>
                        <td> $  {{number_format($InternalOrders->isr * $InternalOrders->subtotal,2)}}</div></td>
                        </tr>
                        <tr>
                        <th>RET IVA:</div></td>
                        <td> $  {{number_format($InternalOrders->tasa* $Items->where('family','FLETE')->sum('import'),2)}}</div></td>
                        
                        </tr> <tr>
                        <th>IVA:</div></td>
                        <td> $  {{number_format(0.16 * $InternalOrders->subtotal*(1-$InternalOrders->descuento),2)}}</div></td>
                        </tr>
                        <tr>
                        <th>Total</div></td>
                        <td> $ {{number_format($InternalOrders->total,2)}}</div></td>
                        </tr>
                        
                    </table>
                            </td>
                        </tr>
                    </table>

                
               <br><br>&nbsp; <br>
               <table >
               <tr> <td colspan="9" style="text-align: center;">   Tabla de Promesas de Cobros / Derechos adquiridos </div></td></tr>
               
                <tr>
                    <th rowspan="2">   <br> COBRO No. <br><br> &nbsp;</th>
                    <th rowspan="2">   <br> Fecha <br><br> Promesa </th>
                    <th rowspan="2">   <br> Dia<br><br> &nbsp; </th>
                    <th rowspan="2">   <br> Semana <br><br> &nbsp;</th>
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
               <table style="text-align: center;">
                <tr>
                    <th>Observaciones: </div></td>
                </tr>
                    <tr>
                        <td> <div class="com-text"> {{$InternalOrders->observations}}</div></div></td>
                    </tr>
                
               </table>
               
               <div class="col-sm-9 font-bold text-sm">
               <br><br>&nbsp;

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
                        <td><div style="text-transform: lowercase;" class="badge badge-primary badge-outlined">{{$row->customer_contact_email}}</div></td>
                    </tr>
                    @endforeach
                  

               </table> @endcan

                    @can('VER DGI')
                    <table>
                <tr class="text-center"><th colspan="5">DGI</th></tr>
                <tr class="text-center">
                    <th>Vendedor</div></td>
                    <th>Inicia</div></td>
                    <th>Descripcion</div></td>
                    <th>% </div></td>
                    <th>Monto con IVA </div></td>
                 </tr>

               <br>
                 @foreach($Comisiones as $c)
                    <tr>
                        <td> {{$c->seller_name}}</div></td>
                        <td> {{$c->iniciales}}</div></td>
                        <td>  {{$c->description}}</div></td>
                        <td>  {{$c->percentage * 100}} %</div></td>
                        <td>  ${{number_format($c->percentage * $InternalOrders->total,2)}} </div></td>
                    </tr>
                    @endforeach
                    
                   <tr>
                    <td></td>
                    <td></td>
                    <th>Totales:</div></td>
                    <td> {{$Comisiones->sum('percentage')*100 }} %</div></td>
                    <td> ${{number_format($InternalOrders->total*$Comisiones->sum('percentage'),2) }}</div></td>
                    
                   </tr>
                 </tbody>

               </table>
               @endcan
               </div>


            </div>
            <div class="row p-4">
                <div class="col-sm-4 col-xs-12 text-center text-xs font-bold">
                    <table>
                        <tr>
                            <td>
                                {{$Sellers->seller_name}}<br>
                              <!--  {{$Sellers->seller_email.' '.$Sellers->seller_mobile}}-->
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                            {{$Sellers->firma}}
                                <br>
                                <hr><br><br>

                                Elaboró
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-3 col-xs-12 text-center text-xs font-bold">
                    &nbsp;
                </div>
                
                <div class="col-sm-5 col-xs-12 text-center text-xs font-bold">
                    <br>
                    {{-- <form action="{{ route('internal_orders.dgi') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                    <x-jet-input type="hidden" name="order_id" value="{{$InternalOrders->id}}"/>
                           
                                     <select class="form-capture  w-full text-md uppercase" name="seller_id" style='width: 50%;'>
                                            @foreach ($ASellers as $row)
                                                <option value="{{$row->id}}" @if ($row->id == old('seller_id')) selected @endif >{{$row->seller_name}}</option>
                                            @endforeach
                                        </select>
                    
                                    <div class="form-group">
                                    <div class="row">
                                      <div class=col>
                                        <x-jet-label value="dgi" />
                                        <input type="number" name="dgi" style='width: 50%;'max=100 min=0 step=0.1 value=0> %
                                        <x-jet-input-error for='seller_id' />
                                    </div>
                                    <div class="col">
                                            <button class="btn btn-blue">Agregar Comision DGI</button>
                                        </div></div>
                                    </div>
                                    
                    
                      </form> --}}
                      
                            
                      
                     @foreach ($requiredSignatures as $firma)
       

                        <ul>
                            <li>
                                <div class="row">


                                    @if($firma->status == 0)
                                    <form action="{{ route('internal_orders.firmar') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <x-jet-input type="hidden" name="signature_id" value="{{$firma->id}}"/>
                                    <div class="col">
                                        <span class="text-xs uppercase">Firma: {{$firma->job}}</span><br>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <x-jet-input type="password" name="key" class="w-flex text-xs"/>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-green">Firmar</button>
                                        </div>
                                    </div>
                                    </form>
                                    @else
                                    <table>
                                        <tbody>
                                            <tr style="font-size:16px; font-weight:bold"><td>{{$firma->firma}}</td></tr>
                                            <tr><td><span style="font-size: 17px"> <i style="color : green"  class="fa fa-check-circle" aria-hidden="true"></i> Autorizado por  {{$firma->job}} </span>
                                    </td></tr>
                                        </tbody>
                                    </table>
                                     
                                    <br><br><br><br>
                                    @endif
                                </div>
                            </li>
                        </ul>
                    @endforeach
                    <br>
                    <hr><br>
                    Autorizaciones
                </div>
            </div>
            <br> <br> 
            @if($InternalOrders->status == 'autorizado')
            <br><br><br><br><br>
                        <br><div> <p style ="font-size:150%; color: #31701F; font-weight:bolder">PEDIDO 100% AUTORIZADO</p> </div><br>
                                         

                    @else 
                    <div><p style ="font-size:150%; color: #DE3022;font-weight:bolder">FALTAN AUTORIZACIONES </p> </div>
                    @endif
                    <br><br><br>
                </div></div>
                     <!-- <input  class="btn btn-green" type="button" name="imprimir" value="Imprimir" id="printPageButton" onclick="window.print();">   -->
                     <button type = "button" class="btn btn-red btn-sm "  onclick="window.print();"> <i class="fas fa-file-pdf fa-xl"> &nbsp; PDF </i> </button>
                     
                     <!-- <a href="{{ route('pedido_pdf', $InternalOrders->id) }} " class="btn btn-red btn-sm">
                     <button type = "button" class="btn btn-red "> <i class="fas fa-file-pdf"> &nbsp; PDF </i> </button>
                                    </a></td> -->
                                    
                   <a href="{{ route('internal_orders.edit_order', $InternalOrders->id) }} " class="btn btn-green btn-sm">
                     <button type = "button" class="btn btn-green "> <i class="fas fa-edit"> &nbsp; Editar</i> </button>
                                    </a></td>

                                    
                    
  
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
    }
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
  white-space: pre-line; 
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
@stop

@section('js')
<script>
    $('#badge').css('height', $('#badge').parent('td').height());
</script>

@stop