@extends('adminlte::page')

@section('title', 'SOCIOS')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; SOCIOS</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
        <table>
                    <tr>
                    <td>
                            <a href="{{route('reports.generate',[1,'dgi',0])}}">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="{{route('reports.generate',[1,'dgi',1])}}">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                    </tr>
                </table>
            <div class="col-sm-12 text-right">
                @can('VER DGI')
                <a href="{{ route('sellers.create')}}" class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nuevo
                </a>
                @endcan
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                <table class="table tableusuarios table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Iniciales</th>
                            @can('VER DGI')
                            <th>DGI</th>
                            @endcan
                            <th style="width : 20%;">-</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Socios as $row)
                        <tr class="text-center">
                            <td>{{$row->folio}}</td>
                            <td>{{$row->seller_name}}</td>
                            <td>{{$row->iniciales}}</td>
                            @can('VER DGI')
                            <td>{{number_format($row->dgi*100,4)}} %</td>
                            @endcan
                            
                            <td class="w-10">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        @can('EDITAR VENDEDORES')
                                        <a href="{{ route('dgi_com.edit', $row->id)}}">
                                        <button  class="btn btn-blue  " style="background-color: rgb(37 ,99 ,235 );color: white;">
                                                <i class="fas fa-edit items-center fa-xl"></i>
                                            </button>
                                        </a>
                                        @endcan
                                    </div>
                                    &nbsp; &nbsp;
                                   
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
@stop