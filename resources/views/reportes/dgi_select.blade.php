@extends('adminlte::page')

@section('title', 'REPORTES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-users"></i>&nbsp;REPORTES DE COMISIONES</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; SELECCIONE LA FECHA (QUINCENAL) Y  TIPO DEL REPORTE:
            </h5>
        </div>
        <form action="{{ route('reportes.dgi')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-6 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Seleccione un intervalo</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Intervalo Quincenal" />
                                <select class="form-capture  w-full text-xs uppercase"  name="interval">
                                @foreach($quincenas as $quincena)
                                <option value="{{$quincena['id'] }}" >Quincena {{$quincena['id']+1}}: del {{$quincena['inicio']}} al {{$quincena['fin']}} </option>
                                @endforeach
                                
                            </select>
                            <x-jet-input-error for='interval' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Tipo de reporte" />
                                <select class="form-capture  w-full text-xs uppercase"  name="type">
                                
                                <option value="vendedores" >Vendedores </option>
                                <option value="resumen" >Resumen </option>
                                
                                <option value="resumen_ventas" >Resumen Ventas directas</option>
                                <option value="resumen_ejecutivos" >Resumen Ejecutivos</option>
                                <option value="comp" >Comprobante Ing. </option>

                                
                            </select>
                            <x-jet-input-error for='type' />
                            </div>
                            
                        </div>
                        <div class="col-12 text-right p-2 gap-2">
                            <button type="submit" class="btn btn-green mb-2">
                                <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Generar
                            </button>
                        </div>
                    </div>
                </div>
                
                    </div>
                </div>
            </div>
           
        </div>
        </form>
    </div>
@stop

@section('css')
    
@stop

@section('js')

@stop