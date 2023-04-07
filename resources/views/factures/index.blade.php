@extends('adminlte::page')

@section('title', 'FACTURAS')

@section('content_header')
    <h1 class="font-bold"><i class="fa-solid fa-clipboard-check"></i>&nbsp; FACTURAS</h1>
    <script src="/Scripts/jquery.dataTables.js"></script>
<script src="/Scripts/dataTables.bootstrap.js"></script>
    
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                @can('CREAR PEDIDOS')
                <a href="{{ route('factures.create')}}" class="btn btn-green">
                    <i class="fa-solid fa-plus-circle"></i>&nbsp; Nuevo
                </a>
                @endcan
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-6 col-sm-12 table-responsive">
                <table class="table tableinternalorders table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>PDA</th>
                            <th>FECHA EMISION</th>
                            <th>TOTAL</th>
                            <th>FACTURA</th>
                            <th>CLIENTE</th>
                            <th>IMPORTE </th>
                            <th>Estatus</th>
                            <th></th>
                        </tr>

                        @foreach($Factures as $f)

                        <tr>
                          <td>{{$f->id}}</td>
                          <td></td>
                          <td>{{$f->npagos}}</td>
                          <td></td>
                          <td>{{$f->facture}} </td>
                          
                          <td>{{$f->amount}} </td>
                          
                          <td>{{$f->status}} </td>
                        </tr>
                    @endforeach
                    </thead>
                    <tbody>
                        
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