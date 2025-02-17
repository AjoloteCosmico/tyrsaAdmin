@extends('adminlte::page')

@section('title', 'REPORTES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp;SELECCIONE LA FECHA(QUINCENAL) Y  TIPO DEL REPORTE</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; SELECCIONE LA QUINCENA:
            </h5>
        </div>
        <form action="{{ route('reportes.dgi')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-6 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Seleccione un vendedor de la lista</h1>
                        </div>
                        <div class="card-body">
                            
                            <div class="form-group">
                                <x-jet-label value="* Intervalo Quincenal" />
                                <select class="form-capture  w-full text-xs uppercase"  name="seller">
                                @foreach($quincenas as $quincena)
                                <option value="{{$quincena['id']}}" >{{$quincena['inicio']}} - {{$quincena['fin']}} </option>
                                @endforeach
                                
                            </select>
                            <x-jet-input-error for='selle' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Tipo de reporte" />
                                <select class="form-capture  w-full text-xs uppercase"  name="seller">
                                
                                <option value="resumen" >Vendedores </option>
                                <option value="resumen" >Resumen </option>
                                
                                <option value="resumen" >Resumen Ventas directas</option>
                                <option value="resumen" >Resumen Ejecutivos</option>
                                <option value="resumen" >Comprobante Ing. </option>
                                <option value="resumen" > </option>

                                
                            </select>
                            <x-jet-input-error for='selle' />
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                <a href="{{ route('customers.index')}}" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>
                <button type="submit" class="btn btn-green mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Guardar
                </button>
            </div>
        </div>
        </form>
    </div>
@stop

@section('css')
    
@stop

@section('js')

@stop