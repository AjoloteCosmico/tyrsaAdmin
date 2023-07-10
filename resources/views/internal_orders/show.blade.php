@extends('adminlte::page')

@section('title', 'PEDIDOS INTERNOS')

@section('content_header')
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp; PEDIDO INTERNO</h1>
@stop

@section('content')     <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm" >
                    <table>
                        <tr><td> &nbsp; &nbsp; &nbsp;</td>
                            <td >
                                <div class="contaier">
                        
                                                <img src="{{asset('img/logo/logo.svg')}}" alt="TYRSA"  style="align-self: left;"></td>
                                                </div></td>
                                 
                            <td rowspan="2">
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
                        <td rowspan="2" class="card-body bg-white rounded-xl shadow-md text-center text-sm">
                                <span style="color: darkblue">Numero PI:<br>
                                {{$InternalOrders->invoice}}</span>
                                <br> <br>
                                NOHA: {{$InternalOrders->noha}} 
                            </td>
                        </tr>
                        
                            
                        <td  colspan="2"class="text-lg " style="color: red;  width:23%;">{{ $CompanyProfiles->company}}
                        </td>
                        <tr>
                                           
                        </tr >

                    </table>


            
            <h5 class="text-lg text-center text-bold">PEDIDO INTERNO</h5>
            <br>
            <div >
                    <table class="table table-responsive text-xs">
                    <th colspan="7">Datos del Cliente</th>
                     </tr>
                    <tr class="text-center">
                        <td>
                        <div class="badge badge-danger badge-outlined"> Numero de cliente:</div></td>
                        <td>
                        <div class="badge badge-primary badge-outlined">{{$Customers->clave}}</div>  </td>
                        <td > <div class="badge badge-danger badge-outlined"> Nombre corto:</div> </td> 
                        <td colspan="2"><div class="badge badge-primary badge-outlined">{{$Customers->alias}} </div></td>
                        <td ><div class="badge badge-danger badge-outlined"> CP:</div> </td>
                        <td> <div class="badge badge-primary badge-outlined">{{$Customers->customer_zip_code}}</div></td>
                    <!-- 6 columas -->
                    </tr>
                  
                    <tr class="text-center">
                        <td><div class="badge badge-danger badge-outlined">  Razon Social: </div></td>
                        <td colspan="4" ><div class="badge badge-primary badge-outlined"> {{$Customers->customer}}</div></td>
                        <td><div class="badge badge-danger badge-outlined">  Regimen de capital: </div></td>
                        <td  ><div class="badge badge-primary badge-outlined"> {{$Customers->legal_name}}</div></td>
                        
                        <!-- 6 columas -->
                    </tr>
                    <tr class="text-center">
                        <td><div class="badge badge-danger badge-outlined"> RFC: </div> </td>
                        <td><div class="badge badge-primary badge-outlined"> {{$Customers->customer_rfc}} <div></div> </td>
                        
                        <td><div class="badge badge-danger badge-outlined"> OC: </div></td>
                        <td><div class="badge badge-primary badge-outlined"> @if($InternalOrders->oc==0) - @else
                                                                              {{$InternalOrders->oc}} @endif</div></td>
                        <td> <div class="badge badge-danger badge-outlined">Contrato No.: </div></td>
                        <td colspan="2"> <div class="badge badge-primary badge-outlined" >@if($InternalOrders->ncontrato==0) - @else
                                                                              {{$InternalOrders->ncontrato}} @endif </div></td>
                        <!-- 6 columas -->
                         </tr>
                         
                         <tr class="text-center">
                        <td rowspan="3"><div class="badge badge-danger badge-outlined" ><br> <br> <br> <br>  Domicilio Fiscal:  <br><br><br><br> <br></div></td>
                        <td colspan="6"><div class="badge badge-primary badge-outlined"> {{$Customers->customer_street.' '.$Customers->customer_outdoor.' '.$Customers->customer_intdoor.' '.$Customers->customer_suburb}} <br> {{$Customers->customer_city.' '.$Customers->customer_state.' '.$Customers->customer_zip_code}}<br>
                                                                </td>
                         </tr>
                         <tr>
                            <td></td>
                            <td></td>
                            
                            <td></td>
                            <td  colspan = "3"> <div class="badge badge-danger badge-outlined">
                            Fechas </div></td>

                         </tr>
                          
                    <tr class="text-center">
                        <td></td>
                        <td> <div class="badge badge-danger badge-outlined">Tel:</div></td>
                        <td> <div class="badge badge-primary badge-outlined">{{$Customers->customer_telephone}}</div></td>
                        
                        
                        <td><div class="badge badge-danger badge-outlined">Semanas </div></td>
                        <td><div class="badge badge-danger badge-outlined">Evento </div> </td>
                        <td><div class="badge badge-danger badge-outlined">DD-MM-AAAA </div></td>
                    </tr >
                    <tr class="text-center">
                        <td rowspan="3"><div class="badge badge-danger badge-outlined" ><br><br> <br> Embarque: <br><br> <br> &nbsp;</div> </td>
                        <td rowspan="3"> <div class="badge badge-primary badge-outlined">
                        <br><br> <br>
                        @if($InternalOrders->shipment == 'Sí')
                            Si
                            @else
                            No
                            @endif
                            <br><br><br> &nbsp;
                              </div></td>
                              @php
{{$del = new DateTime($InternalOrders->date_delivery);
    $pdia=$del->format('Y');
    $primerdia  = new DateTime($pdia."-1-1");
  
  $semanasdel = (int) floor($del->diff($primerdia)->format('%a')/7)+1;
  
  $inst = new DateTime($InternalOrders->instalation_date);
  $pdia=$inst->format('Y');
 $primerdia  = new DateTime($pdia."-1-1");
  $semanasinst = (int) floor($inst->diff($primerdia)->format('%a')/7)+1;
  $reg = new DateTime($InternalOrders->reg_date);
  $pdia=$reg->format('Y');
 $primerdia  = new DateTime($pdia."-1-1");
  $semanasreg = (int) floor( $reg->diff($primerdia)->format('%a')/7)+1;}}
@endphp
                        <td><div class="badge badge-danger badge-outlined">Domicilio Embarque: </div></td>
                        <td></td>
                        <td><div class="badge badge-primary badge-outlined">{{$semanasreg}}  </div></td>
                        <td> <div class="badge badge-primary badge-outlined">Emision PI </div></td>
                        <td> <div class="badge badge-primary badge-outlined">{{date('d - m - Y', strtotime($InternalOrders->reg_date))}} </div></td>
                    </tr>
           
                    
                    <tr class="text-center">
                        
                        <td colspan="2"> <div class="badge badge-primary badge-outlined">{{$CustomerShippingAddresses->customer_shipping_city.' '.$CustomerShippingAddresses->customer_shipping_suburb}} <br> {{$CustomerShippingAddresses->customer_shipping_street.' '.$CustomerShippingAddresses->customer_shipping_indoor}} </div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$semanasdel}} <br> &nbsp; </div></td>
                        
                        <td><div class="badge badge-primary badge-outlined">Entrega <br> Equipo </div></td>
                        <td><div class="badge badge-primary badge-outlined">{{date('j - m - Y', strtotime($InternalOrders->date_delivery))}}   <br> &nbsp;</div></td>
                    </tr>
                    
                    <tr class="text-center">
                        
                        <td><div class="badge badge-danger badge-outlined">CP: </div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$CustomerShippingAddresses->customer_shipping_zip_code}} </div></td>
                    
                        <td><div class="badge badge-primary badge-outlined">{{$semanasinst}} </div></td>
                        <td><div class="badge badge-primary badge-outlined">Instalacion </div></td>
                        <td><div class="badge badge-primary badge-outlined">{{date('j - m - Y', strtotime($InternalOrders->instalation_date))}} </div></td>
                    </tr>
                    </table>

               </div>
                
                <br> &nbsp;  
                <table>
                    <tr>
                        <td><div class="badge badge-danger badge-outlined"> Contacto </div>  </td>
                        <td><div class="badge badge-danger badge-outlined"> Nombre</div></td>
                        <td> <div class="badge badge-danger badge-outlined">Tel movil</div></td>
                        <td> <div class="badge badge-danger badge-outlined">Tel fijo</div></td>
                        <td><div class="badge badge-danger badge-outlined"> Ext.</div></td>
                        <td><div class="badge badge-danger badge-outlined"> Email &nbsp; &nbsp; &nbsp;</div></td>
                    </tr>
                    @php
                        $contact_index=1;
                        @endphp
                    <tbody>
                    @foreach($Contacts as $row)
                    <tr>
                        <td><div class="badge badge-primary badge-outlined">{{$contact_index}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$row->customer_contact_name}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$row->customer_contact_mobile}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$row->customer_contact_office_phone}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$row->customer_contact_office_phone_ext}}</div></td>
                        <td><div style="text-transform: lowercase;" class="badge badge-primary badge-outlined">{{$row->customer_contact_email}}</div></td>
                    </tr>
                        @php 
                        $contact_index=$contact_index+1; 
                        @endphp
                    @endforeach
                    </tbody>
                </table>
                
            <br> &nbsp;
            <table>
                <tr>
                    <td><div class="badge badge-danger badge-outlined">Vendedor <br><br> &nbsp;</div></td>
                    <td><div class="badge badge-danger badge-outlined">Iniciales <br><br> &nbsp;</div></td>
                    <td><div class="badge badge-danger badge-outlined">Comis.<br><br> &nbsp;</div></td>
                    <td><div class="badge badge-danger badge-outlined">Cotización <br> No.<br> &nbsp;</div></td>
                    <td><div class="badge badge-danger badge-outlined">Moneda <br><br> &nbsp;</div></td>
                    <td><div class="badge badge-danger badge-outlined">Cat <br> Equipo <br> &nbsp;</div></td>
                    <td><div class="badge badge-danger badge-outlined">Descripcion <br> Global <br>Proyecto</div></td>
                    <td><div class="badge badge-danger badge-outlined">Ubicación <br> Sucursal <br> Tienda</div></td>
                </tr>
                
                    <tr>
                        <td><div class="badge badge-primary badge-outlined"> {{$Sellers->id}}</div></td>
                        <td><div class="badge badge-primary badge-outlined"> {{$Sellers->iniciales}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$InternalOrders->comision * 100}} %</div></td>
                        <td><div class="badge badge-primary badge-outlined">@if($InternalOrders->ncotizacion==0) - @else
                                                                              {{$InternalOrders->ncotizacion}} @endif</div></td>
                        <td><div class="badge badge-primary badge-outlined"> {{$Coins->code}}</div></td>
                        <td><div class="badge badge-primary badge-outlined"> {{$InternalOrders->category}}</div></td>
                        <td><div class="badge badge-primary badge-outlined"> {{$InternalOrders->description}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$Customers->customer_city}}</div> </td>

                    </tr>
        
            </table>
            <div class="row p-4">
                <div class="col-sm-12 font-bold text-sm">
                    <div class="table-responsive">
                    <table style="text-align: center;">
                        
                            <tr class="text-center">
                                <td><div class="badge badge-danger badge-outlined">Pda</div></td>
                                <td><div class="badge badge-danger badge-outlined">Cant</div></td>
                                <td><div class="badge badge-danger badge-outlined">Unidad</div></td>
                                
                                
                                <td style="width:40%"><div class="badge badge-danger badge-outlined">Descripción</div></td>
                                
                                <td><div class="badge badge-danger badge-outlined">P. U.</div></td>
                                <td><div class="badge badge-danger badge-outlined">Importe</div></td>
                            </tr>
                        
                        
                            @foreach ($Items as $row)
                            <tr class="text-center">
                                <td><div class="badge badge-primary badge-outlined">{{ $row->item }}</div></td>
                                <td><div class="badge badge-primary badge-outlined">{{ $row->amount }}</div></td>
                                <td><div class="badge badge-primary badge-outlined">{{ $row->unit }}</div></td>
                                
                                
                                <td><div class="badge badge-primary badge-outlined "> <div class="com-text">SKU:  {{ $row->sku}} <br> Familia:   {{$row->family }} <br> {!!  nl2br($row->description )!!}</div></div></td>
                                
                                <td class="text-right"><div class="badge badge-primary badge-outlined">${{number_format($row->unit_price, 2) }}</div></td>
                                <td class="text-right"><div class="badge badge-primary badge-outlined">${{number_format($row->import, 2) }}</div></td>
                            </tr>
                            @endforeach
                    
                    </table></div>
                </div>
            </div>
            </div>
            <div class="row p-4">
                <div class="col-sm-12 text-left"  >
                    <table style="width:40%"  align="right">
                        <tr>
                        <td><div class="badge badge-danger badge-outlined">Subtotal: </div></td>
                        <td><div class="badge badge-primary badge-outlined">$ {{number_format($InternalOrders->subtotal,2)}}</div></td>
                        </tr>
                        <tr>
                        <td><div class="badge badge-danger badge-outlined">Descuento: </div></td>
                        <td><div class="badge badge-primary badge-outlined">$ {{number_format($InternalOrders->descuento * $InternalOrders->subtotal,2)}} </div></td>
                        </tr>
                        <tr>
                        <td><div class="badge badge-danger badge-outlined">I.E.P.S:</div></td>
                        <td><div class="badge badge-primary badge-outlined">$ {{number_format($InternalOrders->ieps * $InternalOrders->subtotal,2)}}</div></td>
                        </tr>
                        <tr>
                        <td><div class="badge badge-danger badge-outlined">RET ISR:</div></td>
                        <td><div class="badge badge-primary badge-outlined">$  {{number_format($InternalOrders->isr * $InternalOrders->subtotal,2)}}</div></td>
                        </tr>
                        <tr>
                        <td><div class="badge badge-danger badge-outlined">RET IVA:</div></td>
                        <td><div class="badge badge-primary badge-outlined">$  {{number_format($InternalOrders->tasa* $Items->where('family','FLETE')->sum('import'),2)}}</div></td>
                        
                        </tr> <tr>
                        <td><div class="badge badge-danger badge-outlined">IVA:</div></td>
                        <td><div class="badge badge-primary badge-outlined">$  {{number_format(0.16 * $InternalOrders->subtotal*(1-$InternalOrders->descuento),2)}}</div></td>
                        </tr>
                        <tr>
                        <td><div class="badge badge-danger badge-outlined">Total</div></td>
                        <td><div class="badge badge-primary badge-outlined">$ {{number_format($InternalOrders->total,2)}}</div></td>
                        </tr>
                        
                    </table>
                    </div>
                <br> <br> &nbsp; <br>
                <div class="col-sm-3 font-bold text-sm">
                <table  >
                   <tr>
                    <td><div class="badge badge-danger badge-outlined">Numero de COBROs:</div></td>
                    <td><div class="badge badge-primary badge-outlined">{{$payments->count()}}</div></td>
                   </tr>
                   <tr> 
                    <td><div class="badge badge-danger badge-outlined">Condiciones de COBRO: @foreach($payments as $pay) <br> @endforeach</div></td>
                    <td> <div class="badge badge-primary badge-outlined">@foreach($payments as $pay)
                        {{$pay->percentage}}% &nbsp; {{$pay->concept}},<br>
                        @endforeach</div>
                    </td>
                   </tr>
                   <tr>
                    <td><div class="badge badge-danger badge-outlined">Promesas de Cobros:</div></td>
                    <td></td>
                   </tr>
                </table>
                </div>
                
               <br><br>&nbsp; <br>
               <table >
               <tr> <td colspan="9" style="text-align: center;"><div class="badge badge-danger badge-outlined">Tabla de Promesas de Cobros / Derechos adquiridos </div></td></tr>
               
                <tr>
                    <td rowspan="2"><div class="badge badge-danger badge-outlined"><br> COBRO No. <br><br> &nbsp;</div></td>
                    <td rowspan="2"><div class="badge badge-danger badge-outlined"><br> Fecha <br><br> Promesa </div></td>
                    <td rowspan="2"><div class="badge badge-danger badge-outlined"><br> Dia<br><br> &nbsp;</div> </td>
                    <td rowspan="2"><div class="badge badge-danger badge-outlined"><br> Semana <br><br> &nbsp;</div></td>
                    <td colspan="3"><div class="badge badge-danger badge-outlined">Importe por cobrar</div></td>
                    <td rowspan="2"><div class="badge badge-danger badge-outlined"><br><br> % del Total<br><br> &nbsp;</div></td>
                </tr>
                <tr>
                    <td><div class="badge badge-danger badge-outlined">Subtotal</div></td>
                    <td><div class="badge badge-danger badge-outlined">Iva</div></td>
                    <td><div class="badge badge-danger badge-outlined">Total con Iva</div></td>
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
                        <td><div class="badge badge-primary badge-outlined">{{$p}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">{{date('d - m - Y', strtotime($pay->date))}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$dias}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">{{(int)floor($dias / 7)+1}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">${{number_format($InternalOrders->subtotal *$pay->percentage*0.01,2)}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">${{number_format($InternalOrders->subtotal *$pay->percentage*0.0016,2)}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">${{number_format($pay->amount,2)}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$pay->percentage}} %</div></td>
                        
                    </tr>
                    
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>   
                        <td><div class="badge badge-danger badge-outlined">Totales:</div></td>
                        <td><div class="badge badge-primary badge-outlined">${{number_format($InternalOrders->subtotal,2) }}</div></td>
                        <td><div class="badge badge-primary badge-outlined">${{number_format($InternalOrders->subtotal*0.16,2) }}</div></td>
                        <td><div class="badge badge-primary badge-outlined">${{number_format($payments->sum('amount'),2) }}</div></td>
                        <td><div class="badge badge-primary badge-outlined">100%</div></td>
                        
                
                    </tr>
                </tbody>
               </table>
                
               <br>&nbsp;
               <table style="text-align: center;">
                <tr>
                    <td><div class="badge badge-danger badge-outlined">Observaciones: </div></td>
                </tr>
                    <tr>
                        <td><div class="badge badge-primary badge-outlined"><div class="com-text"> {{$InternalOrders->observations}}</div></div></td>
                    </tr>
                
               </table>
               
               <div class="col-sm-9 font-bold text-sm">
               <br><br>&nbsp;
               <table align="left">

                <tr class="text-center"><td colspan="2"><div class="badge badge-danger badge-outlined">Correos Personales </div></td></tr>
                <tr class="text-center">
                    <td><div class="badge badge-danger badge-outlined">Contacto</div></td>
                    <td><div class="badge badge-danger badge-outlined">Email Personal</div></td>
                 </tr>
                 
                 @foreach($Contacts as $row)
                    <tr>
                        <td><div class="badge badge-primary badge-outlined">{{$row->id}}</div></td>
                        <td><div style="text-transform: lowercase;" class="badge badge-primary badge-outlined">{{$row->customer_contact_email}}</div></td>
                    </tr>
                    @endforeach
                  

               </table>
               <br><br><br>&nbsp;
               </div>
<br>&nbsp;
               <div class="col-sm-9 font-bold text-sm">
               <table>
                <tr class="text-center"><th colspan="5">COMISION PRINCIPAL</th></tr>
                <tr class="text-center">
                    <td><div class="badge badge-danger badge-outlined">Vendedor</div></td>
                    <td><div class="badge badge-danger badge-outlined">Inicia</div></td>
                    <td><div class="badge badge-danger badge-outlined">Descripcion</div></td>
                    <td><div class="badge badge-danger badge-outlined">% </div></td>
                    <td><div class="badge badge-danger badge-outlined">Monto con IVA </div></td>
                 </tr>
                 <tbody>
                 <tr>
                        <td><div class="badge badge-primary badge-outlined">{{$Sellers->seller_name}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$Sellers->iniciales}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">Comision principal</div></td>
                        <td><div class="badge badge-primary badge-outlined"> {{$InternalOrders->comision * 100}} %</div></td>
                        <td><div class="badge badge-primary badge-outlined"> ${{number_format($InternalOrders->comision * $InternalOrders->total,2)}} </div></td>
                    </tr>
                    </table>
                    <table>
                <tr class="text-center"><th colspan="5">DGI</th></tr>
                <tr class="text-center">
                    <td><div class="badge badge-danger badge-outlined">Vendedor</div></td>
                    <td><div class="badge badge-danger badge-outlined">Inicia</div></td>
                    <td><div class="badge badge-danger badge-outlined">Descripcion</div></td>
                    <td><div class="badge badge-danger badge-outlined">% </div></td>
                    <td><div class="badge badge-danger badge-outlined">Monto con IVA </div></td>
                 </tr>

               <br>
                 @foreach($Comisiones as $c)
                    <tr>
                        <td><div class="badge badge-primary badge-outlined">{{$c->seller_name}}</div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$c->iniciales}}</div></td>
                        <td><div class="badge badge-primary badge-outlined"> {{$c->description}}</div></td>
                        <td><div class="badge badge-primary badge-outlined"> {{$c->percentage * 100}} %</div></td>
                        <td><div class="badge badge-primary badge-outlined"> ${{number_format($c->percentage * $InternalOrders->total,2)}} </div></td>
                    </tr>
                    @endforeach
                    
                   <tr>
                    <td></td>
                    <td></td>
                    <td><div class="badge badge-danger badge-outlined">Totales:</div></td>
                    <td><div class="badge badge-primary badge-outlined">{{$Comisiones->sum('percentage')*100 }} %</div></td>
                    <td><div class="badge badge-primary badge-outlined">${{number_format($InternalOrders->total*$Comisiones->sum('percentage'),2) }}</div></td>
                    
                   </tr>
                 </tbody>

               </table>
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
@stop

@section('js')
<script>
    $('#badge').css('height', $('#badge').parent('td').height());
</script>

@stop