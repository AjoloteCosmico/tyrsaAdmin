@extends('adminlte::page')

@section('title', 'DIRECCIONES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-money-bill-1"></i>&nbsp; DIRECCIONES</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                @can('CREAR DIRECCIONES')
                <a href="{{ route('customers_shipping_address.create')}}" class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nueva
                </a>
                @endcan
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
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
                            <td><input type="radio" name="shipping_address" value="{{$row->id}}"></td>
                            <td class="w-5">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        @can('EDITAR DIRECCIONES')
                                        <a href="{{ route('customers_shipping_address.edit', $row->id)}}">
                                            <i class="fas fa-edit btn btn-blue  " style="background-color: rgb(37 ,99 ,235 );color: white;"></i></span>
                                        </a>
                                        @endcan
                                    </div>
                                    <div class="col-6 text-center w-10">
                                        @can('BORRAR DIRECCIONES')
                                        <form class="DeleteReg" action="{{ route('customers_shipping_address.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" >
                                                <i class="fas fa-trash items-center"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    
@stop

@section('js')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tableshipping_addresses.js') }}"></script>

<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/alert_delete_reg.js') }}"></script>

@if (session('create_reg') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/confirm_create_reg.js') }}"></script>
@endif

@if (session('eliminar') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/confirm_delete_reg.js') }}"></script>
@endif

@if (session('error_delete') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/error_delete_reg.js') }}"></script>
@endif

@if (session('update_reg') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/update_reg.js') }}"></script>
@endif
@stop