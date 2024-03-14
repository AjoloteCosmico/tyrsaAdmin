@extends('adminlte::page')

@section('title', 'VENDEDORES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; CLEINTES DEL VENDEDOR {{$Seller->seller_name}}</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            
            <div class="col-sm-12 table-responsive">
            <form action="{{ route('sellers.update_customers',$Seller->id)}}" method="POST" enctype="multipart/form-data">
                 @csrf
       
            <table class="table  tableusuarios table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>Clave</th>
                            <th>Nombre</th>
                            <th>Nombre Corto</th>
                            <th>Seleccionar</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Customers as $row)
                        <tr class="text-center">
                        <td class="w-10"> <p style="color:rgba(255,255,255,0.04)">
                            @if($row->seller_id == $Seller->id)  a @endif z</p>
                                        @can('ASIGNAR CLIENTES')
                                        <input type="checkbox" name="customers[]" value="{{$row->id}}" @if($row->seller_id == $Seller->id) checked @endif>
                                        @endcan
                                        
                                    
                            </td>    
                        <td>{{$row->clave}}</td>
                            <td>{{$row->customer}}</td>
                            <td>{{$row->alias}}</td>
                           
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-12 text-right p-2 gap-2">
                <a href="{{ route('sellers.customers',$Seller->id)}}" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>
                <button type="submit" class="btn btn-green mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Guardar
                </button>
            </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    
@stop

@section('js')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablecatalogosellers.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablecatalogousers.js') }}"></script>

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

<script>
    
</script>
@stop