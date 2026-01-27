@extends('adminlte::page')

@section('title', 'Configuración')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-cogs"></i> TYRSAWES - ADMIN HISTORICO</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10 p-3 m-2 rounded-lg shadow-xl bg-white">
                <div class="card-header">
                    <h4 class="font-bold text-center uppercase"></h4>
                </div>
                <div class="card-body">
                    <center>
                        <img src="{{ asset('vendor/img/logo.png') }}" width="500" class="text-center" alt="logo">
                    </center>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    
@stop

@section('js')
    
@stop