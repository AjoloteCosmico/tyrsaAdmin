@extends('adminlte::page')

@section('title', 'VENDEDORES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; CLIENTES DEL VENDEDOR {{$Seller->seller_name}}</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                <table class="table  datatable table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>Clave</th>
                            <th>Cliente</th>
                            <th>Nombre Corto</th>
                            
                            
                            <th>RFC</th>
                            <th>Num Pedidos</th>
                            <th>Monto total en Pedidos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Customers as $row)
                        <tr class="text-center">
                            <td>{{$row->clave}}</td>
                            <td>{{$row->customer}}</td>
                            <td>{{$row->alias}}</td>
                            <td>{{$row->customer_rfc}}</td>
                            <td>{{$row->npedidos}}</td>
                            <td>$ {{number_format($row->total,2)}} </td>
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

