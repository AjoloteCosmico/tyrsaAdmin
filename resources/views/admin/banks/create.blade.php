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
                                <x-jet-input type="text" name="bank_description" class="w-full text-xs " value="{{old('bank_description')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='bank_description' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="CODIGO" />
                                <x-jet-input type="text" name="bank_clue" class="w-full text-xs " value="{{old('bank_clue')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='bank_clue' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="*MONEDA " />
                                <x-jet-input type="text" name="coin" class="w-full text-xs " value="{{old('coin')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='coin' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* CUENTA" />
                                <x-jet-input type="text"  name="bank_account" class="w-full text-xs " value="{{old('bank_account')}}"/>
                                <x-jet-input-error for='bank_account' />
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                <a href="{{ route('banks.index')}}" class="btn btn-black mb-2">
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