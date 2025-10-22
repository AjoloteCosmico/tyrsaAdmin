@extends('adminlte::page')

@section('title', 'EDITAR SOCIO')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; SOCIOS</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-edit"></i>&nbsp; Editar la comision DGI del socio:
            </h5>
        </div>
        
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-6 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Datos Generales</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Nombre" />
                                <x-jet-input type="text" name="seller_name" class="w-full text-xs " value="{{ $Sellers->seller_name }}" disabled/>
                                <x-jet-input-error for='seller_name' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Numero" />
                                <x-jet-input type="number" step="1" name="folio" class="w-full text-xs " value="{{ $Sellers->folio }}" disabled/>
                                <x-jet-input-error for='folio' />
                            </div>
                           
                            <div class="form-group">
                                <x-jet-label value="Iniciales" />
                                <x-jet-input type="text" name="seller_initials" class="w-full text-xs "  value="{{ $Sellers->iniciales }}" disabled/>
                                <x-jet-input-error for='seller_initials' />
                            </div>
                
                        </div>
                    </div>
                </div>
               
                    @can('ASIGNAR DGI')
                    <form action="{{ route('dgi_com.update', $Sellers->id)}}" method="POST" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <input type="hidden" name="id" value="{{$Sellers->id}}"/>
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">DGI</h1>
                        </div>
                        <div class="card-body">
                        <div class="form-group">
                                <x-jet-label value="Comisión dgi preestablecida para este vendedor" />
                                <x-jet-input type="number" step="0.001"  name="dgi" style="width:6.4vw" class="w-full text-xs " value="{{ number_format($Sellers->dgi*100,4)}}"/>%
                                <x-jet-input-error for='dgi' />
                            </div>
                         </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 text-right p-2 shadow-lg gap-2">
                <a href="{{ route('sellers.index')}}" class="btn btn-green mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>
                <button type="submit" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Guardar
                </button>
            </div>
        </div>
        </form>
    </div>
    <div class="w-100 mb-4"><hr></div>
@stop

@section('css')
    
@stop

@section('js')

@stop