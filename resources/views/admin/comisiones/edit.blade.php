@extends('adminlte::page')

@section('title', 'EDITAR COMISION FIJA')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-people-roof"></i>&nbsp; COMISION FIJA </h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-edit"></i>&nbsp; Editar Porcentaje:
            </h5>
        </div>
        <form action="{{ route('comisiones.update', $Comision->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="id" value="{{$Comision->id}}"/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Porcentaje" />
                                <x-jet-input type="number" step="0.01"  max="5.0" name="percentage" class="w-20 text-xs " value="{{$Comision->cant}}"/> %
                                <x-jet-input-error for='percentage' />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 shadow-lg gap-2">
                <a href="{{ route('comisiones.index')}}" class="btn btn-green mb-2">
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