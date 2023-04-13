@extends('adminlte::page')

@section('title', 'COBROS')

@section('content_header')
    <h1 class="font-bold"><i class="fa fa-money"></i>&nbsp; COBROS</h1>
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
                <table class="table tablefactures table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th rowspan="2">PDA</th>
                            <th rowspan="2">FECHA EMISION</th>
                            <th rowspan="2">BANCO</th>
                            <th rowspan="2">P.I.</th>
                            <th rowspan="2">CLIENTE </th>
                            <th rowspan="2">MONEDA</th>
                            <th colspan="2">TIPO DE CAMBIO</th>
                            <th rowspan="2">CAPTURO </th>
                            <th rowspan="2">REVISO</th>
                            <th rowspan="2">AUTORIZO</th>
                           
                        </tr>
                        <TR>
                            <TH>DLL</TH>
                            <TH>M.N.</TH>
                        </TR>
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
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablecatalogofactures.js') }}"></script>

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