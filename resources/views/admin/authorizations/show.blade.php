@extends('adminlte::page')

@section('title', 'EDITAR AUTORIZACIONES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-fingerprint"></i>&nbsp; Autorización</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-edit"></i>&nbsp; Editar Autorización:
            </h5>
        </div>
        <form action="{{ route('authorizations.update', $Authorizations->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="id" value="{{$Authorizations->id}}"/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Puesto" />
                                <x-jet-input type="text" name="job" class="w-full text-xs " value="{{$Authorizations->job}}"/>
                                <x-jet-input-error for='job' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Rango superior en pesos" />
                                <x-jet-input type="number" step="0.01" name="clearance_level" class="w-full text-xs " value="{{$Authorizations->clearance_level}}"/>
                                <x-jet-input-error for='clearance_level' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Contraseña" />
                                <x-jet-input type="password" name="key_code" class="w-full text-xs " />
                                <x-jet-input-error for='key_code' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Confirmar Contraseña" />
                                <x-jet-input type="password" step="0.01" name="confirm-password" class="w-full text-xs "/>
                                <x-jet-input-error for='confirm-password' />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 shadow-lg gap-2">
                <a href="{{ route('authorizations.index')}}" class="btn btn-green mb-2" style="background-color: rgb(22,163,74);color: white;" >
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