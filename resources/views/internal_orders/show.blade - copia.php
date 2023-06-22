@extends('adminlte::page')

@section('title', 'PEDIDOS INTERNOS')

@section('content_header')
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp; PEDIDO INTERNO</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm">
                    <table>
                        <tr>
                            <td rowspan="4" >
                               <img src="{{asset('img/logo/logo.svg')}}" alt="TYRSA">
                               
                        
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lg" style="color: red">{{ $CompanyProfiles->company}}</td>
                        </tr>
                        <tr>
                            <td>{{ $CompanyProfiles->motto}}</td>
                        </tr>
                        <tr class="text-xs">
                            <td>
                                <br>
                                Domicilio Fiscal:<br>
                                {{$CompanyProfiles->street.' '.$CompanyProfiles->outdoor.' '.$CompanyProfiles->intdoor.' '.$CompanyProfiles->suburb.' '.$CompanyProfiles->city.' '.$CompanyProfiles->state.' '.$CompanyProfiles->zip_code}}<br>
                                R.F.C: {{$CompanyProfiles->rfc}} &nbsp; Tels: 01-52 {{$CompanyProfiles->telephone.', '.$CompanyProfiles->telephone2}} &nbsp; E-mail: {{$CompanyProfiles->email}} &nbsp; Web: {{$CompanyProfiles->website}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="row p-4">
                <div class="col-sm-9 col-xs-12 font-bold text-sm">
                    <table>
                        <tr>
                            <td>
                                Cliente: {{$Customers->clave.' '. $Customers->customer}}<br>
                                Dirección Fiscal: {{$Customers->customer_street.' '.$Customers->customer_outdoor.' '.$Customers->customer_intdoor.' '.$Customers->customer_suburb.' '.$Customers->customer_city.' '.$Customers->customer_state.' '.$Customers->customer_zip_code}}<br>
                                R.F.C: {{$Customers->customer_rfc}} &nbsp; Tel: 01-52 {{$Customers->customer_telephone}} &nbsp; E-mail: {{$Customers->customer_email}} &nbsp; Web: {{$Customers->customer_website}}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-3 col-xs-12 font-bold text-sm">
                    <table>
                        <tr>
                            <td class="card-body bg-white rounded-xl shadow-md text-center text-sm">
                                <span style="color: darkblue">PEDIDO No.:<br><br>
                                {{$InternalOrders->invoice}} {{$InternalOrders->total}}</span> 
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row p-4">
                <div class="col-sm-12 font-bold text-sm">
                    <table>
                        <tr>
                            <td>Vendedor: {{$Sellers->id}}</td>
                        </tr>
                        <tr>
                            <td>
                                @if ($InternalOrders->shipment == 'Sí')
                                    Dirección Embarque: {{$CustomerShippingAddresses->customer_shipping_street.' '.$CustomerShippingAddresses->customer_shipping_outdoor.' '.$CustomerShippingAddresses->customer_shipping_intdoor.' '.$CustomerShippingAddresses->customer_shipping_suburb.' '.$CustomerShippingAddresses->customer_shipping_city.' '.$CustomerShippingAddresses->customer_shipping_state.' '.$CustomerShippingAddresses->customer_shipping_zip_code}}<br>
                                @else
                                    Dirección Embarque:
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Fecha de Emision <br> del Pedido: <br>{{ date('d-m-Y', strtotime($InternalOrders->reg_date))}}
                            </td>
                            <td>
                                Fecha de Entrega del Equipo: <br>{{ date('d-m-Y', strtotime($InternalOrders->date_delivery))}}
                            </td>
                            <td>
                                Fecha de Entrega Instalación: <br> {{ date('d-m-Y', strtotime($InternalOrders->instalation_date))}}
                            </td>
                            <td>
                                Condiciones de Cobro: <br> {{ $InternalOrders->payment_conditions}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row p-4">
                <div class="col-sm-12 font-bold text-sm">
                    <table class="table table-striped text-xs font-medium">
                        <thead>
                            <tr class="text-center">
                                <th>Pda</th>
                                <th>Cant</th>
                                <th>Unidad</th>
                                <th>Familia</th>
                                <th>Clave</th>
                                <th>Descripción</th>
                                <th>P. U.</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Items as $row)
                            <tr class="text-center">
                                <td>{{ $row->item }}</td>
                                <td>{{ $row->amount }}</td>
                                <td>{{ $row->unit }}</td>
                                <td>{{ $row->family }}</td>
                                <td>{{ $row->code }}</td>
                                <td>{{ $row->description }}</td>
                                <td class="text-right">${{number_format($row->unit_price, 2) }}</td>
                                <td class="text-right">${{number_format($row->import, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row p-4">
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                        <span class="text-right font-bold text-md">Subtotal: $ {{number_format($InternalOrders->subtotal,2)}}</span>
                    </div>
                </div>
                
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                      <span class="text-right font-semibold text-sm">Descuento: $ 0.0</span>  
                    </div>
                </div>
                
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                      <span class="text-right font-semibold text-sm">Desc. Fin: $ 0.0</span>  
                    </div>
                </div>
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                      <span class="text-right font-semibold text-sm">I.E.P.S: $ 0.0</span>  
                    </div>
                </div>
                
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                      <span class="text-right font-semibold text-sm">RET ISR: $ 0.0</span>  
                    </div>
                </div>
                
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                      <span class="text-right font-semibold text-sm">RET IVA: $ {{number_format($InternalOrders->ret,2)}}</span>  
                    </div>
                </div>
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                      <span class="text-right font-semibold text-sm">IVA: $ {{number_format($InternalOrders->iva,2)}}</span>  
                    </div>
                </div>
                
                
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                      <span class="text-right font-bold text-xl">Total: $ {{number_format($InternalOrders->total,2)}}</span>  
                    </div>
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

                                    <span style="font-size: 17px"> <i style="color : green"  class="fa fa-check-circle" aria-hidden="true"></i> Autorizado por  {{$firma->job}} </span>
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
                        <br><div>PEDIDO 100% AUTORIZADO</div><br>
                                         <!--
                                        <form action="{{ route('internal_orders.pagos', $row->id) }}" method="POST">
                                            @csrf                               
                                            <x-jet-input type="hidden" name="order_id" value="{{$InternalOrders->id }}"/>
                                            <button type="submit" class="btn btn-green">
                                                <i class="fas fa-percent items-center fa-2x"></i> &nbsp; Porcentaje de Avances
                                            </button>
                                        </form>-->

                    @else 
                    <div>FALTAN AUTORIZACIONES</div>
                    @endif
                    <br><br><br>
                </div>
                    <input  class="btn btn-green" type="button" name="imprimir" value="Imprimir" id="printPageButton" onclick="window.print();"> 
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
@stop

@section('js')

@stop