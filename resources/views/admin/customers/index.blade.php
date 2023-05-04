@extends('adminlte::page')

@section('title', 'CLIENTES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; CLIENTES</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                @can('CREAR CLIENTES')
                <a href="{{ route('customers.validar_rfc')}}" class="btn btn-green">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nueva
                </a>
                @endcan
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                
            <table id="example"  class="table table-striped text-xs font-medium" >
                    <thead>
                        <tr>
                            
                            <th>Clave</th>
                            <th>Razón Social</th>
                            
                            <th>Regimen de Capital</th>
                            <th>Nombre Corto</th>
                            <th>RFC</th>
                            <th>Municipio</th>
                            
                            <th>Teléfono</th>
                            <th style="width : 10%;">&nbsp;&nbsp; </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Customers as $row)
                        <tr>
                            <td>{{$row->clave}}</td>
                            <td>{{$row->customer}}</td>
                            
                            <td>{{$row->legal_name}}</td>
                            <td>{{$row->alias}}</td>
                            <td>{{$row->customer_rfc}}</td>
                            <!-- <td>{{$row->customer_state}}</td> -->
                            <td>{{$row->customer_city}}</td>
                            <!-- <td>{{$row->customer_email}}</td> -->
                            <td>{{$row->customer_telephone}}</td>
                            <td class="w-15">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        @can('EDITAR CLIENTES')
                                        <a href="{{ route('customers.edit', $row->id)}}">
                                        <button type="submit" class="btn btn-blue ">
                                                <i class="fas fa-edit items-center fa-xl"></i>
                                            </button>
                                        </a>
                                        @endcan
                                    </div>
                                    &nbsp;&nbsp;
                                    <div class="col-6 text-center w-10">
                                        @can('BORRAR CLIENTES')
                                        <form class="DeleteReg" action="{{ route('customers.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red">
                                                <i class="fas fa-trash items-center fa-xl"></i>
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
<script>

$(document).ready(function () {
    $('#example').DataTable();
});
</script>

<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablecatalogocustomers.js') }}"></script>

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