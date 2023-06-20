@extends('adminlte::page')

@section('title', 'EDITAR MONEDAS')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-money-bill-1"></i>&nbsp; Moneda</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-edit"></i>&nbsp; Editar Moneda:
            </h5>
        </div>
        <form action="{{ route('coins.update', $Coins->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="id" value="{{$Coins->id}}"/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Moneda" />
                                <x-jet-input type="text" name="coin" class="w-full text-xs " value="{{$Coins->coin}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='coin' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Símbolo" />
                                <x-jet-input type="text" name="symbol" class="w-full text-xs " value="{{$Coins->symbol}}" />
                                <x-jet-input-error for='symbol' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Código" />
                                <x-jet-input type="text" name="code" class="w-full text-xs " value="{{$Coins->code}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='code' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Tipo de Cambio Compra" />
                                <x-jet-input type="number" step="any" name="exchange_buy" class="w-full text-xs " value="{{$Coins->exchange_buy}}"/>
                                <x-jet-input-error for='exchange_buy' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Tipo de Cambio Venta" />
                                <x-jet-input type="number" step="any" name="exchange_sell" class="w-full text-xs " value="{{$Coins->exchange_sell}}"/>
                                <x-jet-input-error for='exchange_sell' />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 shadow-lg gap-2">
                <a href="{{ route('coins.index')}}" class="btn btn-green mb-2">
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