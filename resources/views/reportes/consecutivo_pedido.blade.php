@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-file"></i>&nbsp; CONSECUTIVO POR PEDIDO INTERNO</h1>
@stop

@section('content')
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-lg">
                <a href="{{route('reports.generate',[1,'consecutivo_pedido',0])}}">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                                <a href="{{route('reports.generate',[1,'consecutivo_pedido',1])}}">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                               
        
            </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    
@stop

@section('js')


@stop