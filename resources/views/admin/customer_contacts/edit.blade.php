@extends('adminlte::page')

@section('title', 'EDITAR CONTACTO')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-user-plus"></i>&nbsp; Crear contacto</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; EDITAR CONTACTO:
            </h5>
        </div>
        <form action="{{ route('customer_contacts.update2',$Contacto->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-6 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Datos Generales</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Nombre del contacto" />
                                <x-jet-input type="text" name="customer_contact_name" class="w-full text-xs " value="{{$Contacto->customer_contact_name}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='customer_contact_name' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Teléfono Movil" />
                                <x-jet-input type="text" name="customer_contact_mobile" class="w-full text-xs " value="{{$Contacto->customer_contact_mobile}}"/>
                                <x-jet-input-error for='customer_contact_mobile' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Teléfono de Oficina" />
                                <x-jet-input type="text" name="customer_contact_office_phone" class="w-full text-xs " value="{{$Contacto->customer_contact_office_phone}}"/>
                                <x-jet-input-error for='customer_contact_office_phone' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Extension" />
                                <x-jet-input type="text" name="customer_contact_office_phone_ext" class="w-full text-xs " value="{{$Contacto->customer_contact_office_phone_ext}}"/>
                                <x-jet-input-error for='customer_contact_office_phone_ext' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Email Corporativo" />
                                <x-jet-input type="text" name="customer_contact_email" class="w-full text-xs " value="{{$Contacto->customer_contact_email}}"/>
                                <x-jet-input-error for='customer_contact_email' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Email personal" />
                                <x-jet-input type="text" name="customer_contact_personal_email" class="w-full text-xs " value="{{$Contacto->customer_contact_personal_email}}"/>
                                <x-jet-input-error for='customer_contact_personal_email' />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Domicilio del contacto</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Estado" />
                                <x-jet-input type="text" name="customer_contact_state" class="w-full text-xs " value="{{$Contacto->customer_contact_state}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='customer_contact_state' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Ciudad" />
                                <x-jet-input type="text" name="customer_contact_city" class="w-full text-xs " value="{{$Contacto->customer_contact_city}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='customer_contact_city' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Colonia" />
                                <x-jet-input type="text" name="customer_contact_suburb" class="w-full text-xs " value="{{$Contacto->customer_contact_suburb}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='customer_contact_suburb' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Calle" />
                                <x-jet-input type="text" name="customer_contact_street" class="w-full text-xs " value="{{$Contacto->customer_contact_street}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='customer_contact_street' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Número Exterior" />
                                <x-jet-input type="text" name="customer_contact_outdoor" class="w-full text-xs " value="{{$Contacto->customer_contact_outdoor}}" onkeyup="javascript:this.value=this.value.toUpperCase();" />
                                <x-jet-input-error for='customer_contact_outdoor' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Número Interior" />
                                <x-jet-input type="text" name="customer_contact_indoor" class="w-full text-xs " value="{{$Contacto->customer_contact_indoor}}"/>
                                <x-jet-input-error for='customer_contact_indoor' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* C.P." />
                                <x-jet-input type="text" name="customer_contact_zip_code" class="w-full text-xs " value="{{$Contacto->customer_contact_zip_code}}"/>
                                <x-jet-input-error for='customer_contact_zip_code' />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                <a href="{{ route('customers.index')}}" class="btn btn-black mb-2">
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