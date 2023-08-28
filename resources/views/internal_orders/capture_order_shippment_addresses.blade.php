@extends('adminlte::page')

@section('title', 'PEDIDO INTERNO')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-clipboard-check"></i>&nbsp; Pedido Interno</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; Agregar Pedido Interno:
            </h5>
        </div>
        <form action="{{ route('internal_orders.partida')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-jet-input type="hidden" name="customer_id" value="{{ $Customers->id }}"/>
        <x-jet-input type="hidden" name="temp_internal_order_id" value="{{ $TempInternalOrders->id }}"/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <h1 class="h2 text-center font-bold text-xs uppercase">Direcciones de Embarque</h1>
                                    <div class="col-sm-12 col-xs-12 text-right p-3">
                                        <a href="{{ route('customers_shipping_address.show', $TempInternalOrders->id) }}" class="btn btn-green">
                                            <i class="fas fa-plus-circle"></i>&nbsp; Agregar Domicilio
                                        </a>
                                    </div>
                                    <div class="col-sm-12 col-xs-12 table-responsive">
                                        <table class="table tableshippingaddress table-striped text-xs font-medium">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Domicilio</th>
                                                    <th>Dirección</th>
                                                    <th>Colonia</th>
                                                    <th>C.P.</th>
                                                    <th>Select</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($CustomerShippingAddresses as $row)
                                                <tr class="text-center">
                                                    <td>{{$row->customer_shipping_alias}}</td>
                                                    <td>{{$row->customer_shipping_street.' '.$row->customer_shipping_outdoor}}</td>
                                                    <td>{{$row->customer_shipping_city}}</td>
                                                    <td>{{$row->customer_shipping_zip_code}}</td>
                                                    <td><input type="radio" required name="shipping_address" value="{{$row->id}}" 
                                                        @if ($row->customer_shipping_alias == 'DOMICILIO FISCAL')
                                                            checked
                                                        @endif>
                                                    </td>
                                                    <td class="w-5">
                                                        <div class="row">
                                                            <div class="col-6 text-center w-10">
                                                                {{-- @can('EDITAR DIRECCIONES') --}}
                                                                {{--  <a href="{{ route('customers_shipping_address.edit', $row->id)}}">
                                                                    <i class="fas fa-edit btn btn-blue w-9 h-9"></i></span>
                                                                </a>  --}}
                                                                {{-- @endcan --}}
                                                            </div>
                                                            <div class="col-6 text-center w-10">
                                                                {{-- @can('BORRAR DIRECCIONES') --}}
                                                                 <a class="DeleteReg" href="{{ route('customers_shipping_address.borrar', [$row->id, $TempInternalOrders->id]) }}" method="POST">
                                                                  
                                                                    <button type="button" onclick="return confirm('Are you sure?')" class="btn btn-red h-9 w-9">
                                                                        <i class="fas fa-trash items-center"></i>
                                                                    </button>
                                                                  </a>  
                                                                {{-- @endcan --}}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <x-jet-input-error for='shipping_address' />
                                    </div>
                                </div>
                            </div>
                            <div class="w-100">&nbsp;</div>
                            <div class="row">
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <x-jet-label value="* Se Embarca" />
                                        <input type="radio" name="shipment" class="shipment_option" value="Sí" checked>&nbsp; Sí &nbsp; &nbsp;
                                        <input type="radio" name="shipment" class="shipment_option" value="No">&nbsp; No
                                        <x-jet-input-error for='shipment' />
                                    </div>
                                </div>
                            </div>
                            <div class="w-100"><hr></div>
                        </div>
                    
                <br><br><br>
                
            </div>
            <div class="col-12 text-right p-2 gap-2">
                {{--  <a href="{{ route('internal_orders.index')}}" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>  --}}
                <button type="submit" class="btn btn-green mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Siguiente
                </button>
            </div>
        </div>
        </form>
        
    </div>
@stop

@section('css')
    
@stop

@section('js')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tableitems.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tableshipping_addresses.js') }}"></script>

@if (session('eliminar') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/confirm_delete_reg.js') }}"></script>
@endif

@if (session('error_delete') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/error_delete_reg.js') }}"></script>
@endif



@stop

