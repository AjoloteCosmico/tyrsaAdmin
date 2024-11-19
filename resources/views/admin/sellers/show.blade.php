@extends('adminlte::page')

@section('title', 'EDITAR VENDEDOR')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; Vendedor</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-edit"></i>&nbsp; Editar Datos del Vendedor:
            </h5>
        </div>
        <form action="{{ route('sellers.update', $Sellers->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="id" value="{{$Sellers->id}}"/>
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
                                <x-jet-input type="text" name="seller_name" class="w-full text-xs " value="{{ $Sellers->seller_name }}"/>
                                <x-jet-input-error for='seller_name' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Numero" />
                                <x-jet-input type="number" step="1" name="folio" class="w-full text-xs " value="{{ $Sellers->folio }}"/>
                                <x-jet-input-error for='folio' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Teléfono Móvil" />
                                <x-jet-input type="text" name="seller_mobile" class="w-full text-xs " value="{{ $Sellers->seller_mobile }}"/>
                                <x-jet-input-error for='seller_mobile' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Email" />
                                <x-jet-input type="text" name="seller_email" class="w-full text-xs " value="{{ $Sellers->seller_email }}"/>
                                <x-jet-input-error for='seller_email' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Teléfono de Oficina" />
                                <x-jet-input type="text" name="seller_office_phone" class="w-full text-xs " value="{{ $Sellers->seller_office_phone }}"/>
                                <x-jet-input-error for='seller_office_phone' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Extención Teléfono de Oficina" />
                                <x-jet-input type="text" name="seller_office_phone_ext" class="w-full text-xs " value="{{ $Sellers->seller_office_phone_ext }}"/>
                                <x-jet-input-error for='seller_office_phone_ext' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Iniciales" />
                                <x-jet-input type="text" name="seller_initials" class="w-full text-xs "  value="{{ $Sellers->iniciales }}"/>
                                <x-jet-input-error for='seller_initials' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Firma" />
                                <x-jet-input type="text" name="seller_sign" class="w-full text-xs "  value="{{ $Sellers->firma }}"/>
                                <x-jet-input-error for='seller_sign' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Status" />
                                <select class="form-select" aria-label="Default select example" name ="seller_status">                               
                                        
                                        <option value="ACTIVO" @if($Sellers->status=='ACTIVO') selected @endif>Activo</option>
                                        <option value="INACTIVO" @if($Sellers->status=='INACTIVO') selected @endif>Inactivo</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Domicilio</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="Estado" />
                                <x-jet-input type="text" name="seller_state" class="w-full text-xs " value="{{ $Sellers->seller_state }}"/>
                                <x-jet-input-error for='seller_state' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Ciudad" />
                                <x-jet-input type="text" name="seller_city" class="w-full text-xs " value="{{ $Sellers->seller_city }}"/>
                                <x-jet-input-error for='seller_city' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Colonia" />
                                <x-jet-input type="text" name="seller_suburb" class="w-full text-xs " value="{{ $Sellers->seller_suburb }}"/>
                                <x-jet-input-error for='seller_suburb' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Calle" />
                                <x-jet-input type="text" name="seller_street" class="w-full text-xs " value="{{ $Sellers->seller_street }}"/>
                                <x-jet-input-error for='seller_street' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Número Exterior" />
                                <x-jet-input type="text" name="seller_outdoor" class="w-full text-xs " value="{{ $Sellers->seller_outdoor }}"/>
                                <x-jet-input-error for='seller_outdoor' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Número Interior" />
                                <x-jet-input type="text" name="seller_indoor" class="w-full text-xs " value="{{ $Sellers->seller_indoor }}"/>
                                <x-jet-input-error for='seller_indoor' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="C.P." />
                                <x-jet-input type="text" name="seller_zip_code" class="w-full text-xs " value="{{ $Sellers->seller_zip_code }}"/>
                                <x-jet-input-error for='seller_zip_code' />
                            </div>
                        </div>
                        
                    </div>
                    @can('ASIGNAR DGI')
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">DGI</h1>
                        </div>
                        <div class="card-body">
                        <div class="form-group">
                                <x-jet-label value="Comisión dgi preestablecida para este vendedor" />
                                <x-jet-input type="number" step="0.01"  name="dgi" style="width:6.4vw" class="w-full text-xs " value="{{ number_format($Sellers->dgi ,2)}}"/>%
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
    
@stop

@section('js')

@stop