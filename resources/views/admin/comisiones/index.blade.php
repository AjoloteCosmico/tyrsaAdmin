@extends('adminlte::page')

@section('title', 'CONFIGURACIONES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-cogs"></i>&nbsp; COMISION PRINCIPAL</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                <table class="table  table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>COMISION PORCENTAJE</th>
                            <th>Ultima modif</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td> {{number_format($Comision->cant,2)}} %</td>
                            <td> {{$Comision->updated_at}}</td>
                            <td class="w-15">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        @can('EDITAR COMISION PRINCIPAL')
                                        <a href="{{ route('comisiones.edit', $Comision->id)}}">
                                        
                                        <button class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        @endcan
                                    </div>
                                    &nbsp; &nbsp;
                                   
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    
@stop

@section('js')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablecatalogosettings.js') }}"></script>

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