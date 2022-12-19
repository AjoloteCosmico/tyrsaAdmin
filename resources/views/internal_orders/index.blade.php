@extends('adminlte::page')

@section('title', 'PEDIDO INTERNO')

@section('content_header')
    <h1 class="font-bold"><i class="fa-solid fa-clipboard-check"></i>&nbsp; PEDIDO INTERNO</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
            <img src="https://i0.wp.com/codigoespagueti.com/wp-content/uploads/2020/10/neon-genesis-evangelion-y-la-revolucion-del-genero-mecha.jpg?fit=1280%2C720&quality=80&ssl=1" style="width:500px;height:600px;">
                @can('CREAR PEDIDOS')
                <a href="{{ route('internal_orders.create')}}" class="btn btn-green">
                    <i class="fa-solid fa-plus-circle"></i>&nbsp; Nuevo
                </a>
                @endcan
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                <table class="table tableinternalorders table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Folio</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Estatus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($InternalOrders as $row)
                        <tr class="text-center">
                            <td>{{$row->id}}</td>
                            <td>{{$row->invoice}}</td>
                            <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                            <td>{{$row->customer}}</td>
                            <td>{{$row->seller_name}}</td>
                            <td>{{$row->status}}</td>
                            <td class="w-15">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        @can('VER PEDIDOS')
                                        <a href="{{ route('internal_orders.show', $row->id)}}">
                                            <i class="fa-solid fa-eye btn btn-blue w-9 h-9"></i></span>
                                        </a>
                                        @endcan
                                    </div>
                                    @if($row->status == 'CAPTURADO')
                                    <div class="col-6 text-center w-10">
                                        
                                        @can('BORRAR PEDIDOS')
                                        <form class="DeleteReg" action="{{ route('internal_orders.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red h-9 w-9">
                                                <i class="fa-solid fa-trash items-center"></i>
                                            </button>
                                        </form>
                                        @endcan
                                        
                                    </div>@endif
                                    @if($row->status == 'autorizado')
                                    <div class="col-6 text-center w-10">
                                        <form action="{{ route('internal_orders.pagos', $row->id) }}" method="POST">
                                            @csrf
                                            <x-jet-input type="hidden" name="order_id" value="{{ $row->id}}"/>
                                            <button type="submit" class="btn btn-green h-9 w-9">
                                                <i class="fa-solid fa-percent items-center"></i>
                                            </button>
                                        </form>
                                       
                                    </div>
                                    @endif
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
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablecatalogointernal_orders.js') }}"></script>

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