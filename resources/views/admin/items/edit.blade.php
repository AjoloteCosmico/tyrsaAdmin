@extends('adminlte::page')

@section('title', 'PARTIDAS')

@section('content_header')
    <h1 class="font-bold"><i class="fa-brands fa-buffer"></i>&nbsp; Partida</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; Editar Partida:
            </h5>
        </div>
        <form action="{{ route('temp_items.redefine',[$Id,$Captured])}}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-jet-input type="hidden" name="temp_internal_order_id" value="{{ $TempInternalOrders }}"/>
        <x-jet-input type="hidden" name="item" value="{{ $Item ->item}}"/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-body">
                        <div class="form-group">
                                <x-jet-label value="* Cantidad" />
                                <x-jet-input type="number" name="amount" class="w-full text-xs" value="{{$Item->amount}}"/>
                                <x-jet-input-error for='amount' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Unidad" />
                                {{--  <x-jet-input type="text" name="unit" class="w-full text-xs" value="{{old('unit')}}"/>  --}}
                                <select class="form-capture  w-full text-xs uppercase" name="unit">
                                    @foreach ($Units as $row)
                                        <option value="{{$row->unit}}" @if ($row->id == $Item->unit) selected @endif >{{$row->unit}}</option>
                                    @endforeach
                                </select>
                                <x-jet-input-error for='unit' />
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Familia" />
                                {{--  <x-jet-input type="text" name="family" class="w-full text-xs" value="{{old('family')}}"/>  --}}
                                <select class="form-capture  w-full text-xs uppercase" name="family" id='fam' onchange="actualizarProductos()">
                                        <option value="RACKS" @if ($Item->family == 'RACKS') selected @endif >RACKS</option>
                                        <option value="TRANSPORTADORES" @if ($Item->family == 'TRANSPORTADORES') selected @endif >TRANSPORTADORES</option>
                                        <option value="EQUIPO AUXILIAR" @if ($Item->family == 'EQUIPO AUXILIAR') selected @endif >EQUIPO AUXILIAR</option>
                                        <option value="SOFTWARE" @if ($Item->family == 'SOFTWARE') selected @endif >SOFTWARE</option>
                                </select>
                                
                                <x-jet-input-error for='family' />
                                <br>
                                <x-jet-label value="* Especifique" hidden='hidden' id='esp' />
                                <x-jet-input type="text" name="otro" id='otro' hidden='hidden' class="w-full text-xs" /> 
                            </div>
                            <div class="form-group">
                                <x-jet-label value="* Descripcion" />
                                <x-jet-input type="text" name="description" class="w-full text-xs" value="{{$Item->description}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='fab' />
                            </div>                            <!-- 
                            <div class="form-group">
                                <x-jet-label value="* Racks" />
                                <x-jet-input type="text" name="racks" class="w-full text-xs" value="{{old('racks')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                <x-jet-input-error for='racks' /> 
                            </div> -->
                            <div class="form-group">
                                <x-jet-label value="* SKU" />
                                <select  name="sku" class="form-capture  w-full text-xs uppercase"  value="{{$Item->sku}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                            <option value="VT">VT</option>    
                            </select>
                                <x-jet-input-error for='sku' />
                            </div>
                            
                            <div class="form-group">
                                <x-jet-label value="* Precio Unitario" />
                                <x-jet-input type="number" step="0.01" name="unit_price" id="input-price" class="form-control just-number price-format-input" class="w-full text-xs" value="{{$Item->unit_price}}"/>
                                <x-jet-input-error for='unit_price' />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                {{--  <a href="{{ route('customers.index')}}" class="btn btn-black mb-2">
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
<script>
$(document).on("keypress", ".just-number", function (e) {
  let charCode = (e.which) ? e.which : e.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  }
});
$(document).on('keyup', '.price-format-input', function (e) {
  let val = this.value;
  val = val.replace(/,/g, "");
  if (val.length > 3) {
    let noCommas = Math.ceil(val.length / 3) - 1;
    let remain = val.length - (noCommas * 3);
    let newVal = [];
    for (let i = 0; i < noCommas; i++) {
      newVal.unshift(val.substr(val.length - (i * 3) - 3, 3));
    }
    newVal.unshift(val.substr(0, remain));
    this.value = newVal;
  }
  else {
    this.value = val;
  }
});

$(document).ready(function(){
  $('#input-price').focus();
})</script>

<script>
       $(document).ready(function () {     
$('#fam').change(function(){
var seleccionado = $(this).val();
console.log('entrando a la funcion');
console.log(seleccionado)
var esp=document.getElementById('esp');
var otro=document.getElementById('otro');
if(seleccionado=='OTRO'){
  
  otro.hidden=''  
  esp.hidden=''  

}
else{
    otro.hidden='hidden'  
    esp.hidden='hidden'  
    
}
})
});
</script>

<script>
function removeOptions(selectElement) {
   var i, L = selectElement.options.length - 1;
   for(i = L; i >= 0; i--) {
      selectElement.remove(i);
   }
}

function actualizarProductos(){
var seleccionado = document.getElementById("fam").value;
console.log('entrando a la funcion');
console.log(seleccionado)
removeOptions(document.getElementById('prod'));
var prod = document.getElementById("prod");

if(seleccionado=='RACKS'){
    var example_array = {
        @foreach($Products->where('familia','RACKS') as $row)
        {{$row->id}}:'{{$row->name}}',
        @endforeach
    
};}
if(seleccionado=='TRANSPORTADORES'){
    var example_array = {
        @foreach($Products->where('familia','TRANSPORTADORES') as $row)
        {{$row->id}}:'{{$row->name}}',
        @endforeach
    
};}
if(seleccionado=='EQUIPO AUXILIAR'){
    var example_array = {
        @foreach($Products->where('familia','EQUIPO AUXILIAR') as $row)
        {{$row->id}}:'{{$row->name}}',
        @endforeach
    
};}
if(seleccionado=='SOFTWARE'){
    var example_array = {
        @foreach($Products->where('familia','SOFTWARE') as $row)
        {{$row->id}}:'{{$row->name}}',
        @endforeach
    
};}
for(index in example_array) {
    prod.options[prod.options.length] = new Option(example_array[index], index);
}
}
</script>
@stop