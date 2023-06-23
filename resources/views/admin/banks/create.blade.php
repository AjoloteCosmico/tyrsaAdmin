@extends('adminlte::page')

@section('title', 'BANCOS')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-money-bill-1"></i>&nbsp; BANCOS</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; AGREGAR BANCO:
            </h5>
        </div>
        <form action="{{ route('banks.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="*BANCO" />
                                <x-jet-input type="text" name="coin" class="w-full text-xs " value="{{old('coin')}}"/>
                                <x-jet-input-error for='coin' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="CODIGO" />
                                <x-jet-input type="text" name="symbol" class="w-full text-xs " value="{{old('symbol')}}"/>
                                <x-jet-input-error for='symbol' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="*MONEDA " />
                                <x-jet-input type="text" name="code" class="w-full text-xs " value="{{old('code')}}"/>
                                <x-jet-input-error for='code' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* CUENTA" />
                                <x-jet-input type="number" step="0.01" name="exchange_buy" class="w-full text-xs " value="{{old('exchange_rate')}}"/>
                                <x-jet-input-error for='exchange_buy' />
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                <a href="{{ route('coins.index')}}" class="btn btn-black mb-2">
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