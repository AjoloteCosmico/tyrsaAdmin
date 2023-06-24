@extends('adminlte::page')

@section('title', 'EDITAR COBRO ')

@section('content_header')
    <h1 class="font-bold"><i class="fa fa-money"></i>&nbsp;  COMPROBANTE DE INGRESO</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; EDITAR COMPROBANTE DE INGRESO:
            </h5>
        </div>
        <form action="{{ route('cobros.update2',$Cobro->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-jet-input type="hidden" name="item" value=" "/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-body">
                            
                                    <div class="form-group">
                                        <x-jet-label value="* Cliente" />
                                        <select class="form-capture  w-full text-xs uppercase" name="customer_id" id='customer_id'>
                                        <option  > </option>    
                                        @foreach ($Customers as $row)
                                                <option value="{{$row->id}}" @if ($row->id == $Cobro->customer_id) selected @endif > {{$row->clave}} {{$row->customer}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='customer_id' />
                                    </div>
                                    <div class="form-group">
                                        <x-jet-label value="* Pedido Interno" />
                                        <select class="form-capture  w-full text-xs uppercase" name="order_id" id='order_id'>
                                          @foreach($Ordenes as $o)
                                                <option value="{{$o->id}}" >{{$o->invoice}} </option>
                                          @endforeach
                                          
                                        </select>
                                        <t-error for='order_id' />
                                    </div>
                                    <div class="form-group">
                                        <xx-jet-inpu-jet-label value="Fecha de cobro" />
                                        <x-jet-input type="date" name="date" id="date" class="form-control w-full text-xs" value="{{$Cobro->date}}"  />
                                        <x-jet-input-error for='date' />
                                    </div>

                                    <div class="form-group">
                                        <x-jet-label value="* COMPORBANTE DE INGRESO" />
                                        <x-jet-input type="text"  name="comp" id="comp" class="form-control  w-full text-xs" value="{{$Cobro->comp}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                        <x-jet-input-error for='comp' />
                                    </div>
                                    <div class="form-group">
                                        <x-jet-label value="* Factura" />
                                        <select class="form-capture  w-full text-xs uppercase" name="facture_id" >
                                        <option  > </option>    
                                        @foreach ($Factures as $row)
                                                <option value="{{$row->id}}" @if ($row->id == $Cobro->facture_id) selected @endif >  {{$row->facture}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='facture_id' />
                                    </div>
                                    <div class="form-group">
                                        <x-jet-label value="* Banco" />
                                        <select class="form-capture  w-full text-xs uppercase" name="bank_id" id='moneda'>
                                        <option  > </option>    
                                        @foreach ($Bancos as $row)
                                                <option value="{{$row->id}}" @if ($row->id == $Cobro->bank_id) selected @endif > {{$row->bank_clue}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='bank_id' />
                                    </div>
                                    <div class="form-group">
                                        <x-jet-label value="* Moneda" />
                                        <select class="form-capture  w-full text-xs uppercase" name="coin_id" id='coin_id'>
                                        <option  > </option>    
                                        @foreach ($Coins as $row)
                                                <option value="{{$row->id}}" @if ($row->id == $Cobro->coin_id) selected @endif > {{$row->coin}} {{$row->customer}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='coin_id' />
                                    </div>
                                    <div class="form-group">
                                        <x-jet-label value=" TIPO DE CAMBIO" />
                                        <x-jet-input type="number" step="0.01" name="tc" id="tc" class="form-control just-number price-format-input w-full text-xs" value="{{$Cobro->tc}}"/>
                                        <x-jet-input-error for='tc' />
                                    </div>
                                    <div class="form-group">
                                        <x-jet-label value=" IMPORTE PAGADO SIN IVA" />
                                        <x-jet-input type="number" step="0.01" name="unit_price" id="sniva" style="background-color :#E3E3E3;" class="form-control just-number price-format-input" class="w-full text-xs" value="{{number_format($Cobro->amount /1.16,2)}}" disabled/>
                                        <x-jet-input-error for='unit_price' />
                                    </div>
                                    <div class="form-group">
                                        <x-jet-label value=" IVA" />
                                        <x-jet-input type="number" step="0.01" name="unit_price" id="iva" style="background-color :#E3E3E3;" class="form-control just-number price-format-input" class="w-full text-xs" value="{{number_format($Cobro->amount *0.16 /1.16,2)}}" disabled/>
                                        <x-jet-input-error for='unit_price' />
                                    </div>
                                    <div class="form-group">
                                        <x-jet-label value="* IMPORTE PAGADO CON IVA" />
                                        <x-jet-input type="number" step="0.01" name="amount" id="import" class="form-control just-number price-format-input" class="w-full text-xs" value="{{$Cobro->amount}}"/>
                                        <x-jet-input-error for='amount' />
                                    </div>

                                    <br>


                                    Ingresa su comprobante
                                    <br>
                                    <input type="file" name="comp_file" id="comp_file">
                                    <br><br>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                  <a href="{{ route('factures.index')}}" class="btn btn-black mb-2">
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
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" /> -->

@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

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
});</script>

<script>
    
    $(document).ready(function () {
      $('#customer_id').selectize({
          sortField: 'text'
      });
  });
</script>

<script>
    function removeOptions(selectElement) {
   var i, L = selectElement.options.length - 1;
   for(i = L; i >= 0; i--) {
      selectElement.remove(i);
   }
}
</script>


<script>
     $(document).ready(function () {     
$('#customer_id').change(function(){
var seleccionado = $(this).val();
console.log('entrando a la funcion');
console.log(seleccionado);
removeOptions(document.getElementById('order_id'));
console.log('hecho¿?');
var desc = document.getElementById("order_id");
@foreach($Customers as $cliente)
if(seleccionado=='{{$cliente->id}}'){
    var example_array = {
        @foreach($InternalOrders as $order)
        @if($order->customer_id==$cliente->id)
    {{$order->id}} : '{{$order->invoice}}',
         @endif
    @endforeach
};}
   
  
@endforeach


for(index in example_array) {
    desc.options[desc.options.length] = new Option(example_array[index], index);
}


var npagos={
    @foreach($InternalOrders as $i)
    {{$i->id}}:{{$i->payment_conditions}},
    @endforeach};

var seleccionado = document.getElementById('order_id').value;
console.log('entrando a la funcion de num pagos');
console.log(seleccionado);
console.log(npagos[seleccionado]);
removeOptions(document.getElementById('ordinal'));
var desc = document.getElementById("ordinal");
@foreach($InternalOrders as $order)
if(seleccionado=='{{$order->id}}'){
    var example_array = {1:1};
    for (i = 2; i < {{$order->payment_conditions +1}} ;i++){
        example_array[i]=i;
    }
}
document.getElementById('tpagos').value=npagos[seleccionado];
   
@endforeach


for(index in example_array) {
    desc.options[desc.options.length] = new Option(example_array[index], index);
}


})
     });
</script>

<script>

$(document).ready(function () {     
$('#order_id').change(function(){
    var npagos={
    @foreach($InternalOrders as $i)
    {{$i->id}}:{{$i->payment_conditions}},
    @endforeach};

var seleccionado = $(this).val();
console.log('entrando a la funcion de num pagos');
console.log(seleccionado);
console.log(npagos[seleccionado]);
removeOptions(document.getElementById('ordinal'));
var desc = document.getElementById("ordinal");
@foreach($InternalOrders as $order)
if(seleccionado=='{{$order->id}}'){
    var example_array = {1:1};
    for (i = 2; i < {{$order->payment_conditions +1}} ;i++){
        example_array[i]=i;
    }
}
    
document.getElementById('tpagos').value=npagos[seleccionado];
 
   
  
@endforeach


for(index in example_array) {
    desc.options[desc.options.length] = new Option(example_array[index], index);
}

})
     });


</script>



<script>
    document.getElementById("import").addEventListener("input", function(){
    subtotal = parseFloat(this.value/1.16);
    iva=parseFloat(subtotal*0.16);
    document.getElementById("sniva").value = subtotal.toFixed(2);
    document.getElementById("iva").value = iva.toFixed(2);
    });
</script>


<script>
  
$(document).ready(function () {     
$('#coin_id').change(function(){
    
var seleccionado = $(this).val();
console.log('entrando a la funcion de num pagos');
console.log(seleccionado);
@foreach($Coins as $coin)
if(seleccionado=='{{$coin->id}}'){
    
document.getElementById('tc').value={{$coin->exchange_sell}};
}
    

   
  
@endforeach


})
     });
  
</script>
@stop