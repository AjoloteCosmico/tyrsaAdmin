@extends('adminlte::page')

@section('title', 'PEDIDO INTERNO')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-clipboard-check"></i>&nbsp; Pedido Interno</h1>

    @stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; Agregar Pedido Interno:
            </h5>
        </div>
        <form action="{{ route('internal_orders.capture') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">

            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">



                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    
        
<div class="row"></div>
@can('NOHA MANUAL')

<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
<input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked onclick="automatico();">
<label class="btn btn-outline-primary" for="btnradio1">Folio<br> automatico</label>
<input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" onclick="manual();">
<label class="btn btn-outline-primary" for="btnradio3">Ingresar <br> Folio </label>
</div>
<br> <br>
@else
<h1 class="font-bold " >EL NOHA Y EL FOLIO SE AGREGARAN DE MANERA AUTOMATICA</h1>
@endcan


<div class="form-group" id="folio" style="display:none;">
                            <x-jet-label value="FOLIO" />
                            <x-jet-input type="number" min="0" name="invoice" id="invoice" value=0  /> 
                            </div>      

@can('NOHA MANUAL')
<br><br>
<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
<input type="radio" class="btn-check" name="btnradio" id="btnradioa" autocomplete="off" checked onclick="automatico2();">
<label class="btn btn-outline-primary" for="btnradioa">NOHA<br> automatico</label>
<input type="radio" class="btn-check" name="btnradio" id="btnradiob" autocomplete="off" onclick="manual2();">
<label class="btn btn-outline-primary" for="btnradiob">Ingresar <br> NOHA </label>
</div>
<br> <br>
@endcan


<div class="form-group" id="noha-group" style="display:none;">
                            <x-jet-label value="NOHA" />
                            <x-jet-input type="number" min="0" name="noha" id="noha" value=0  /> 
                            </div>      
<br><br>

                                    <div class="form-group">
                                        <x-jet-label value="* Cliente" />
                                        <select class="form-capture  w-full text-xs uppercase" name="customer_id" id='customer'>
                                            @foreach ($Customers as $row)
                                                <option value="{{$row->id}}" @if ($row->id == old('customer_id')) selected @endif > {{$row->clave}} {{$row->customer}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='customer_id' />
                                    </div>
                                </div>
                            </div>
                            <h1 class="h2 text-center font-bold text-xs uppercase">Seleccione los contactos para este pedido</h1>
                                    <br>
            
            <div class="col-sm-12 col-xs-12 table-responsive">

                
                                        <table class="table tableshippingaddress table-striped text-xs font-medium" >
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Nombre</th>
                                                    <th>Ciudad</th>
                                                    <th>Telefono</th>
                                                    <th>Correo</th>
                                                    <th>Select</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            </table>
                                            <table class="table tableshippingaddress table-striped text-xs font-medium" id='ctable'>
                                            <tbody>
                                                @foreach($contactos as $contact)
                                                <tr class='{{$contact->customer_id}}'>
                                                <td>{{$contact->customer_contact_name}}</td>
                                                <td>{{$contact->customer_contact_city}}</td>
                                                <td>{{$contact->customer_contact_office_phone}}</td>
                                                <td>{{$contact->customer_contact_email}}</td>
                                                <td><div class="row">     
                                                    <div class='col'> Seleccionar :</div>
                                                    <div class='col'><input class="form-check-input" type="checkbox" value="{{$contact->id}}" id="flexCheckDefault" name="contacto[]"></div>
                                                </div> 
                                                    &nbsp;&nbsp;&nbsp;  </td>
                                                  </tr>
                                        @endforeach
                                            </tbody>
                                        </table>
                                    <!-- Si no hay contactos boton para agregar contactos -->

            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                <a href="{{ route('internal_orders.index')}}" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>
                <button type="submit" class="btn btn-green mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Siguiente
                </button>
            </div>
        </div>
        </form>
    </div>
@stop

@section('css')<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
@stop

@section('js')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tableitems.js') }}"></script>

<script>
    $(document).ready(function(){
        $(".shipment_option").click(function(evento){
          
            var valor = $(this).val();
          
            if(valor == 'Sí'){
                $("#shipment_answer").css("display", "block");
                $("#div2").css("display", "none");
            }else{
                $("#shipment_answer").css("display", "none");
                $("#div2").css("display", "block");
            }
    });
});
</script>

<script>
    $(document).ready(function(){
        $(".shipment_address_equal_option").click(function(evento){
          
            var valor = $(this).val();
          
            if(valor == 'No'){
                $("#shipment_address").css("display", "block");
            }else{
                $("#shipment_address").css("display", "none");
            }
    });
});
</script>

<script>
    function automatico(myRadio) {
    var folio = document.getElementById("folio");
    var invoice = document.getElementById("invoice");
    folio.style.display="none";
    invoice.value=0;
}


function manual(myRadio) {
    var folio = document.getElementById("folio");
    folio.style.display="block";
}
function automatico2(myRadio) {
    var group = document.getElementById("noha-group");
    var noha = document.getElementById("noha");
    group.style.display="none";
    noha.value=0;
}


function manual2(myRadio) {
    var folio = document.getElementById("noha-group");
    folio.style.display="block";
}

$(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });
</script>
<script>
var mytable = document.getElementById("ctable");
for (var i = 0, row; row = mytable.rows[i]; i++) {
     
       mytable.style.display='';
        
        
            row.style.display='none';
            
        
    }
    $(document).ready(function () {     
$('#customer').change(function(){
var seleccionado = $(this).val();
console.log('entrando a la funcion');
console.log(seleccionado)
var boxes = document.getElementsByClassName("form-check-input");
for (var i = 0; i < boxes.length; i++) {
    console.log(boxes.item(i).checked);
   boxes.item(i).checked=false;
}
var table = document.getElementById("ctable");
for (var i = 0, row; row = table.rows[i]; i++) {
     
       table.style.display='';
        
        if (row.className==String(seleccionado)) {
            row.style.display='';
            
        }else{
            row.style.display='none';
            
        }
    }

})
});
</script>
@stop