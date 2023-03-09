@extends('adminlte::page')

@section('title', 'EDITAR CLIENTES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; Cliente</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-edit"></i>&nbsp; Editar Datos del Cliente:
            </h5>
            
        </div>
        <form action="{{ route('customers.update', $Customers->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="id" value="{{$Customers->id}}"/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-6 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Datos Generales</h1>
                        </div>
                        <div class="card-body">
                            
                                <x-jet-label value="Clave del cliente: 0{{$Customers->id}}" />
                             </div>
                        <div class="card-body">
                            <div class="form-group">
                                <x-jet-label value="* Razón Social" />
                                <x-jet-input type="text" name="customer" class="w-full text-xs uppercase" value="{{$Customers->customer}}" />
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
                                    <option value="otra" >OTRA </option>
                                    <option value="" > </option>
                                    
                                    
                                </select>
                                <br>
                                <x-jet-input type="text" name="otra" id='otra' class="w-full text-xs " style='display: none;' onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                
                                <x-jet-input-error for='legal_name' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Nombre Corto" />
                                <x-jet-input type="text" name="alias" class="w-full text-xs " value="{{$Customers->alias}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='alias' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* RFC" />
                                <x-jet-input type="text" name="customer_rfc" class="w-full text-xs uppercase" value="{{$Customers->customer_rfc}}" />
                                <x-jet-input-error for='customer_rfc' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Email Coorporativo" />
                                <x-jet-input type="text" name="customer_email" class="w-full text-xs uppercase" value="{{$Customers->customer_email}}" />
                                <x-jet-input-error for='customer_email' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Teléfono Fiscal" />
                                <x-jet-input type="text" name="customer_telephone" class="w-full text-xs uppercase" value="{{$Customers->customer_telephone}}" />
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
                                <x-jet-input type="text" name="customer_state" class="w-full text-xs uppercase" value="{{$Customers->customer_state}}" />
                                <x-jet-input-error for='customer_state' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Ciudad" />
                                <x-jet-input type="text" name="customer_city" class="w-full text-xs uppercase" value="{{$Customers->customer_city}}" />
                                <x-jet-input-error for='customer_city' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Colonia" />
                                <x-jet-input type="text" name="customer_suburb" class="w-full text-xs uppercase" value="{{$Customers->customer_suburb}}" />
                                <x-jet-input-error for='customer_suburb' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Calle" />
                                <x-jet-input type="text" name="customer_street" class="w-full text-xs uppercase" value="{{$Customers->customer_street}}" />
                                <x-jet-input-error for='customer_street' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Número Exterior" />
                                <x-jet-input type="text" name="customer_outdoor" class="w-full text-xs uppercase" value="{{$Customers->customer_outdoor}}"/>
                                <x-jet-input-error for='customer_outdoor' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="Número Interior" />
                                <x-jet-input type="text" name="customer_intdoor" class="w-full text-xs uppercase" value="{{$Customers->customer_intdoor}}"/>
                                <x-jet-input-error for='customer_intdoor' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* C.P." />
                                <x-jet-input type="text" name="customer_zip_code" class="w-full text-xs uppercase" value="{{$Customers->customer_zip_code}}" />
                                <x-jet-input-error for='customer_zip_code' />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 shadow-lg gap-2">
                <a href="{{ route('customers.index')}}" class="btn btn-green mb-2">
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
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-edit"></i>&nbsp; Agregar Contactos:
            </h5>
        </div>{{$nc}}
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="col-xs-12 col-sm-9 p-3 table-responsive bg-white">
                <table class="table tablemembers table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Sede</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Contacts as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->customer_contact_name}}</td>
                                <td>{{$row->customer_contact_mobile}}</td>
                                <td>{{$row->customer_contact_email}}</td>
                                <td>{{$row->customer_contact_city}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            <br>
            <form action="{{ route('customers.contacto') }}" method="POST">
                                            @csrf                               
                                            <x-jet-input type="hidden" name="customer_id" value="{{$Customers->id }}"/>
                                            <button  type="submit" class="btn btn-green mb-2">
                                            <i class="fas fa fa-user-plus"></i>&nbsp; Añadir <br> contacto</button>
                                        </form>
        </div>
    </div>
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