@extends('adminlte::page')

@section('title', 'EDITAR CONFIGURACIÓN')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-cogs"></i>&nbsp; Configuración</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-edit"></i>&nbsp; Editar Configuración:
            </h5>
        </div>
        <form action="{{ route('settings.update', $Settings->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="id" value="{{$Settings->id}}"/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Datos Generales</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Salario Mínimo Zona Libre de la Frontera Norte" />
                                <x-jet-input type="number" step="0.01" name="minimum_salary_zlfn" class="w-full text-xs " value="{{$Settings->minimum_salary_zlfn}}"/>
                                <x-jet-input-error for='minimum_salary_zlfn' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Salario Mínimo Resto del País" />
                                <x-jet-input type="number" step="0.01" name="minimum_salary" class="w-full text-xs " value="{{$Settings->minimum_salary}}"/>
                                <x-jet-input-error for='minimum_salary' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* UMA" />
                                <x-jet-input type="number" step="0.01" name="uma" class="w-full text-xs " value="{{$Settings->uma}}"/>
                                <x-jet-input-error for='uma' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* I.V.A." />
                                <x-jet-input type="number" name="iva" class="w-full text-xs " value="{{$Settings->iva}}"/>
                                <x-jet-input-error for='iva' />
                            </div>
                            <x-jet-input type="hidden" name="year_application" class="w-full text-xs " value="{{$Settings->year_application}}"/>
                            {{--  <div class="form-group">
                                <x-jet-label value="* AÑO DE APLICACIÓN" />
                                <x-jet-input type="number" name="year_application" class="w-full text-xs " value="{{$Settings->year_application}}"/>
                                <x-jet-input-error for='year_application' />
                            </div>  --}}
                            <div class="form-group">
                                <x-jet-label value="Objetivo Anual" />
                                <x-jet-input type="number" name="obj" class="w-full text-xs " value="{{$Settings->objetivo_anual}}"/>
                                <x-jet-input-error for='obj' />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 shadow-lg gap-2">
                <a href="{{ route('settings.index')}}" class="btn btn-green mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>
                <button type="submit" class="btn btn-red mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Guardar
                </button>
            </div>
        </div>
        </form>
    </div>
    <div class="w-100 mb-4"><hr></div>
@stop

@section('css')
    <style>
        .image-wrapper{
            position: relative;
            padding-bottom: 60%;
        }

        .image-wrapper img{
            position: absolute;
            object-fit:scale-down;
            width: 100%;
            height: 100%;
            max-width: 180px;
            max-height: 180px
        }
    </style>
@stop

@section('js')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablemembers.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/refresh_image.js') }}"></script>
@stop