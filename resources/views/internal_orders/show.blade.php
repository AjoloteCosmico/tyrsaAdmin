@extends('adminlte::page')

@section('title', 'PEDIDO INTERNO')

@section('content_header')
    <h1 class="font-bold"><i class="fa-solid fa-clipboard-check"></i>&nbsp; PEDIDO INTERNO</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm">
                    <table>
                        <tr>
                            <td rowspan="4">
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
                                Cliente: {{$Customers->id.' '. $Customers->customer}}<br>
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
                                {{$InternalOrders->invoice}}</span> 
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
                                Fecha de Entrega del Equipo: {{ date('d-m-Y', strtotime($InternalOrders->date_delivery))}}
                            </td>
                            <td>
                                Fecha de Entrega Instalación: {{ date('d-m-Y', strtotime($InternalOrders->instalation_date))}}
                            </td>
                            <td>
                                Condiciones de Pago: {{ $InternalOrders->payment_conditions}}
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
                                <td class="text-right">$ {{ number_format($row->unit_price, 2) }}</td>
                                <td class="text-right">$ {{ number_format($row->import, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row p-4">
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                        <span class="text-right font-bold text-xl">Subtotal: $ {{number_format($InternalOrders->subtotal,2)}}</span>
                    </div>
                </div>
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                        {{--  <span class="text-right font-semibold text-sm">IVA: $ {{number_format($InternalOrders->iva,2)}}</span>  --}}
                    </div>
                </div>
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                        {{--  <span class="text-right font-bold text-xl">Total: $ {{number_format($InternalOrders->total,2)}}</span>  --}}
                    </div>
                </div>
            </div>
            <div class="row p-4">
                <div class="col-sm-4 col-xs-12 text-center text-xs font-bold">
                    <table>
                        <tr>
                            <td>
                                {{$Sellers->seller_name}}<br>
                                {{$Sellers->seller_email.' '.$Sellers->seller_mobile}}
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
                    @foreach ($Authorizations as $item)
                        <ul>
                            <li>
                                <div class="row">
                                    <div class="col">
                                        <span class="text-xs uppercase">Firma: {{$item->job}}</span><br>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <x-jet-input type="password" name="key_code" class="w-flex text-xs"/>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-green">Firmar</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                    <br>
                    <hr><br>
                    Autorizaciones
                </div>
            </div>
                
                    
                        <a href="{{route('internal_orders.payment',$InternalOrders->id)}}">
                        <button   class="btn btn-green mb-2">
                         <i class="fa-solid fa-credit-card fa-2x" ></i>
                         &nbsp; &nbsp; Pagos</button></a>
                    
                
        </div>
    </div>
@stop

@section('css')
    
@stop

@section('js')

@stop