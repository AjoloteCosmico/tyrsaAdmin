@extends('adminlte::page')

@section('title', 'DIRECCIÓN')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-house"></i>&nbsp; Dirección</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; Agregar Dirección:
            </h5>
        </div>
        <form action="{{ route('customers_shipping_address.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-jet-input type="hidden" name="temp_internal_order_id" value="{{ $TempInternalOrders->id }}"/>
        <x-jet-input type="hidden" name="customer_id" value="{{ $Customers->id }}"/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Domicilio de Embarque</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Alias" />
                                <x-jet-input type="text" name="customer_shipping_alias" class="w-full text-xs " value="{{old('customer_shipping_alias')}}"/>
                                <x-jet-input-error for='customer_shipping_alias' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Estado" />
                                <x-jet-input type="text" name="customer_shipping_state" class="w-full text-xs " value="{{old('customer_shipping_state')}}"/>
                                <x-jet-input-error for='customer_shipping_state' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Ciudad" />
                                <x-jet-input type="text" name="customer_shipping_city" class="w-full text-xs " value="{{old('customer_shipping_city')}}"/>
                                <x-jet-input-error for='customer_shipping_city' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Colonia" />
                                <x-jet-input type="text" name="customer_shipping_suburb" class="w-full text-xs " value="{{old('customer_shipping_suburb')}}"/>
                                <x-jet-input-error for='customer_shipping_suburb' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Calle" />
                                <x-jet-input type="text" name="customer_shipping_street" class="w-full text-xs " value="{{old('customer_shipping_street')}}"/>
                                <x-jet-input-error for='customer_shipping_street' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Número Exterior" />
                                <x-jet-input type="text" name="customer_shipping_outdoor" class="w-full text-xs " value="{{old('customer_shipping_outdoor')}}"/>
                                <x-jet-input-error for='customer_shipping_outdoor' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Número Interior" />
                                <x-jet-input type="text" name="customer_shipping_indoor" class="w-full text-xs " value="{{old('customer_shipping_indoor')}}"/>
                                <x-jet-input-error for='customer_shipping_indoor' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* C.P." />
                                <x-jet-input type="text" name="customer_shipping_zip_code" class="w-full text-xs " value="{{old('customer_shipping_zip_code')}}"/>
                                <x-jet-input-error for='customer_shipping_zip_code' />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                {{--  <a href="{{ route('customers_shipping_address.index')}}" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>  --}}
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