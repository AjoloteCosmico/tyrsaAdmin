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
                                       
                                    SELECCIONA LAS FACTURAS A CUBRIR CON EL COMPROBANTE
                                    <table class="table tableshippingaddress table-striped text-xs font-medium tableFixHead " style=".tableFixHead          { overflow: auto; height: 10px; }
.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

 border-collapse: collapse; width: 90%;
th, td { padding: 8px 16px; }
th     { background:#eee; }" >
                                    <thead>
                                                <tr class="text-center">
                                                    <th>FACTURA</th>
                                                    <th>CANTIDAD</th>
                                                    <th>PEDIDO</th>
                                                    <th>SELECCIONAR</th>
                                                    
                                                </tr>
                                            </thead> 
                                           <tbody id='ctable'>
                                                @foreach($Factures as $f)
                                                <tr class='{{$f->customer_id}} '>
                                                    <td class="text-center">{{$f->facture}} </td>
                                                    <td class="text-center"> $ {{number_format($f->amount,2)}}</td>
                                                    <td class="text-center">{{$f->invoice}}</td>
                                                    <td class="text-center"><div class="row">
                                                        <div class='col'><input class="form-check-input customer-facture" type="checkbox" value="{{$f->id}}" id="flexCheckDefault{{$f->id}}" name="facture[]" onclick="si_factura();" ></div>
                                                    </div> 
                                                        &nbsp;&nbsp;&nbsp;  </td>
                                                  </tr>
                                        @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row" style="padding:3.4vw">  No se ha facturado   <input class="form-check-input nofactura" type="checkbox"  id="no_facturado"  onclick="no_factura();" ></div>
                                   <br><br>
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
                                     <p><a href="{{ route('cobros.show', $Cobro->id)}}">Comprobante <i class='far fa-file'></i></a> </p>

                                    <br>
                                    <!-- <input type="file" name="comp_file" id="comp_file"> -->
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
console.log('entrando a la funcion cambio cliente');
console.log(seleccionado);
console.log('hecho¿?');


var npagos={
    @foreach($InternalOrders as $i)
    {{$i->id}}:{{$i->payment_conditions}},
    @endforeach};

console.log(seleccionado);
console.log('entrando a la funcion cjaas');
console.log(seleccionado)
var boxes = document.getElementsByClassName("customer-facture");
for (var i = 0; i < boxes.length; i++) {
    console.log(boxes.item(i).checked);
   boxes.item(i).checked=false;
}
var table = document.getElementById("ctable");
for (var i = 0, row; row = table.rows[i]; i++) {
     
       table.style.display='';

       console.log('calss name :'+ row.className);
       console.log('selected:'+seleccionado);
        if (parseInt(row.className)==parseInt(seleccionado)) {
            console.log('matched');
            row.style.display='';
        }else{
            row.style.display='none';
            
        }
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


<script>
var mytable = document.getElementById("ctable");
for (var i = 0, row; row = mytable.rows[i]; i++) {
     
       mytable.style.display='';
        
        
            row.style.display='none';
            
        
}
    $(document).ready(function () {     
$('#customer_id').change(function(){
var seleccionado = $(this).val();
console.log('entrando a la funcion cjaas');
console.log(seleccionado)
var boxes = document.getElementsByClassName("customer-facture");
for (var i = 0; i < boxes.length; i++) {
    console.log(boxes.item(i).checked);
   boxes.item(i).checked=false;
}
var table = document.getElementById("ctable");
for (var i = 0, row; row = table.rows[i]; i++) {
     
       table.style.display='';

       console.log('calss name :'+ row.className);
       console.log('selected:'+seleccionado);
        if (parseInt(row.className)==parseInt(seleccionado)) {
            console.log('matched');
            row.style.display='';
        }else{
            row.style.display='none';
            
        }
    }

})
});

function no_factura(){
    if(document.getElementById('no_facturado').checked){

    
    var boxes = document.getElementsByClassName("customer-facture");
    for (var i = 0; i < boxes.length; i++) {
        console.log(boxes.item(i).checked);
       boxes.item(i).checked=false;
    }
}

}
function si_factura(){
   
    
    var boxes = document.getElementsByClassName("nofactura");
    for (var i = 0; i < boxes.length; i++) {
        console.log(boxes.item(i).checked);
       boxes.item(i).checked=false;
    }
}


var seleccionado = document.getElementById('customer_id').value;
console.log('PRELLENANDO¿?');
console.log(seleccionado)
var boxes = document.getElementsByClassName("customer-facture");
for (var i = 0; i < boxes.length; i++) {
    console.log(boxes.item(i).checked);
   boxes.item(i).checked=false;
}
var table = document.getElementById("ctable");
for (var i = 0, row; row = table.rows[i]; i++) {
     
       table.style.display='';

       console.log('calss name :'+ row.className);
       console.log('selected:'+seleccionado);
        if (parseInt(row.className)==parseInt(seleccionado)) {
            console.log('matched');
            row.style.display='';
        }else{
            row.style.display='none';
            
        }
    }
@foreach($SelectedFactures as $row)
document.getElementById('flexCheckDefault{{$row->facture_id}}').checked=true;
@endforeach
</script>
@stop