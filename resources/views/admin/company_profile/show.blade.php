@extends('adminlte::page')

@section('title', 'EDITAR PERFIL DE COMPAÑÍA')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-industry"></i>&nbsp; Perfil</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-edit"></i>&nbsp; Editar Perfil de Compañía:
            </h5>
        </div>
        <form action="{{ route('company_profiles.update', $CompanyProfiles->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="id" value="{{$CompanyProfiles->id}}"/>
        <div class="row">
            <div class="row p-4">
                <div class="col-sm-6 col-xs-12 rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Datos Generales</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Razón Social" />
                                <x-jet-input type="text" name="company" class="w-full text-xs uppercase" value="{{$CompanyProfiles->company}}" />
                                <x-jet-input-error for='company' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Eslogan" />
                                <x-jet-input type="text" name="motto" class="w-full text-xs uppercase" value="{{$CompanyProfiles->motto}}" />
                                <x-jet-input-error for='motto' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* RFC" />
                                <x-jet-input type="text" name="rfc" class="w-full text-xs uppercase" value="{{$CompanyProfiles->rfc}}" />
                                <x-jet-input-error for='rfc' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Email Coorporativo" />
                                <x-jet-input type="text" name="email" class="w-full text-xs uppercase" value="{{$CompanyProfiles->email}}" />
                                <x-jet-input-error for='email' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Teléfono de Oficina" />
                                <x-jet-input type="text" name="telephone" class="w-full text-xs uppercase" value="{{$CompanyProfiles->telephone}}" />
                                <x-jet-input-error for='telephone' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Teléfono de Oficina 2" />
                                <x-jet-input type="text" name="telephone2" class="w-full text-xs uppercase" value="{{$CompanyProfiles->telephone2}}" />
                                <x-jet-input-error for='telephone2' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Página Web" />
                                <x-jet-input type="text" name="website" class="w-full text-xs uppercase" value="{{$CompanyProfiles->website}}" />
                                <x-jet-input-error for='website' />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12 rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Domicilio Fiscal</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Estado" />
                                <x-jet-input type="text" name="state" class="w-full text-xs uppercase" value="{{$CompanyProfiles->state}}" />
                                <x-jet-input-error for='state' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Ciudad" />
                                <x-jet-input type="text" name="city" class="w-full text-xs uppercase" value="{{$CompanyProfiles->city}}" />
                                <x-jet-input-error for='city' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Colonia" />
                                <x-jet-input type="text" name="suburb" class="w-full text-xs uppercase" value="{{$CompanyProfiles->suburb}}" />
                                <x-jet-input-error for='suburb' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Calle" />
                                <x-jet-input type="text" name="street" class="w-full text-xs uppercase" value="{{$CompanyProfiles->street}}" />
                                <x-jet-input-error for='street' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Número Exterior" />
                                <x-jet-input type="text" name="outdoor" class="w-full text-xs uppercase" value="{{$CompanyProfiles->outdoor}}"/>
                                <x-jet-input-error for='outdoor' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Número Interior" />
                                <x-jet-input type="text" name="intdoor" class="w-full text-xs uppercase" value="{{$CompanyProfiles->intdoor}}"/>
                                <x-jet-input-error for='intdoor' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* C.P." />
                                <x-jet-input type="text" name="zip_code" class="w-full text-xs uppercase" value="{{$CompanyProfiles->zip_code}}" />
                                <x-jet-input-error for='zip_code' />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Imagotipo / Logotipo</h1>
                        </div>
                        <div class="card-body">
                            <div class="col-12 mb-4 p-4">
                                @livewire('change-imagotype', ['company_profile_id' => $CompanyProfiles->id])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-right p-4">
                    <a href="{{ route('company_profiles.index')}}" class="btn btn-blue mb-2 " style="background-color: rgb(37 ,99 ,235 );color: white;">
                        <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                    </a>
                    <button type="submit" class="btn btn-green mb-2" style="background-color: rgb(22,163,74);color: white;" >
                        <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Guardar
                    </button>
                </div>
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