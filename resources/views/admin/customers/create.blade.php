@extends('adminlte::page')

@section('title', 'CLIENTES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; Cliente</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; Agregar Cliente:
            </h5>
        </div>
        <form action="{{ route('customers.store')}}" method="POST" enctype="multipart/form-data">
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
                                <x-jet-label value="* Nombre o Razón Social" />
                                <x-jet-input type="text" name="customer" class="w-full text-xs " value="{{old('customer')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='customer' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Regimen de Capital" />
                                <select class="form-capture  w-full text-xs uppercase" id="legal_name" name="legal_name">
                                
                                    <option value="FISICA CAEYP" > PERSONA FISICA CON ACTIVIDADES EMPRESARIALES Y PROFESIONALES </option>
                                    <option value="S.A." >SOCIEDAD ANONIMA </option>
                                    <option value="S.A. DE C.V." > SOCIEDAD ANONIMA DE CAPITAL VARIABLE </option>
                                    <option value="S DE R.L DE C.V." >SOCIEDAD DE RESPONSABILIDAD LIMITADA DE CAPITAL VARIABLE </option>
                                    <option value="SAPI" >SOCIEDAD ANONIMA PROMOTORA DE INVERSION </option>
                                    <option value="SAPI DE C.V." > SOCIEDAD ANONIMA PROMOTORA DE INVERSION DE CAPITAL VARIABLE</option>
                                    <option value="SAS" > SOCIEDAD POR ACCIONES SIMPLIFICADA</option>
                                    <option value="S.C" >SOCIEDAD COOPERATIVA </option>
                                    <option value="S en N. C" > SOCIEDAD EN NOMBRE COLECTIVO</option>
                                    <option value="S en N. C DE C.V." > SOCIEDAD EN NOMBRE COLECTIVO DE CAPITAL VARIABLE S en N. C DE C.V</option>
                                    <option value="S en C" >SOCIEDAD EN COMANDITA SIMPLE </option>
                                    <option value="S.C.A" >SOCIEDAD EN COMANDITA POR ACCIONES </option>
                                    
                                    <option value="R.S.C" >REGIMEN SIMPLIFICADO DE CONFIANZA </option>
                                    <option value="POR ASIGNAR" >POR ASIGNAR </option>
                                    <option value="otra" >OTRA </option>
                                    <option value="" > </option>
                                    
                                    
                                </select>
                                <br>
                                <x-jet-input type="text" name="otra" id='otra' class="w-full text-xs " style='display: none;' onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                
                                <x-jet-input-error for='legal_name' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Nombre Corto" />
                                <x-jet-input type="text" name="alias" class="w-full text-xs " value="{{old('customer')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='alias' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* RFC" />
                                <x-jet-input type="text" name="customer_rfc" class="w-full text-xs " value="{{session('rfc')}}"/>
                                <x-jet-input-error for='customer_rfc' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value=" Clave Cliente" />
                                <x-jet-input type="text" name="clave" class="w-full text-xs " />
                                <x-jet-input-error for='clave' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Email Coorporativo" />
                                <x-jet-input type="text" name="customer_email" class="w-full text-xs " value="{{old('customer_email')}}"/>
                                <x-jet-input-error for='customer_email' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Teléfono fiscal" />
                                <x-jet-input type="text" name="customer_telephone" class="w-full text-xs " value="{{old('customer_telephone')}}"/>
                                <x-jet-input-error for='customer_telephone' />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Domicilio Fiscal</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Estado" />
                                <x-jet-input type="text" name="customer_state" class="w-full text-xs " value="{{old('customer_state')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='customer_state' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Ciudad" />
                                <x-jet-input type="text" name="customer_city" class="w-full text-xs " value="{{old('customer_city')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='customer_city' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Colonia" />
                                <x-jet-input type="text" name="customer_suburb" class="w-full text-xs " value="{{old('customer_suburb')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='customer_suburb' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Calle" />
                                <x-jet-input type="text" name="customer_street" class="w-full text-xs " value="{{old('customer_street')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='customer_street' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Número Exterior" />
                                <x-jet-input type="text" name="customer_outdoor" class="w-full text-xs " value="{{old('customer_outdoor')}}" />
                                <x-jet-input-error for='customer_outdoor' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Número Interior" />
                                <x-jet-input type="text" name="customer_indoor" class="w-full text-xs " value="{{old('customer_indoor')}}"/>
                                <x-jet-input-error for='customer_indoor' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* C.P." />
                                <x-jet-input type="text" name="customer_zip_code" class="w-full text-xs " value="{{old('customer_zip_code')}}"/>
                                <x-jet-input-error for='customer_zip_code' />
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
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/rfc_disponible.js') }}"></script>

<script>
    $(document).ready(function () {     
$('#legal_name').change(function(){
var seleccionado = $(this).val();
if(seleccionado=='otra'){
document.getElementById('otra').style.display="block";
}
else{
    document.getElementById('otra').style.display="none"; 
}

})
});
</script>
@stop