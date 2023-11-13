@extends('adminlte::page')

@section('title', 'COMPROBANTE DE INGRESO')

@section('content_header')
    <h1 class="font-bold"><i class="fa fa-money"></i>&nbsp;  COMPROBANTE DE INGRESO</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; DESGLOSAR MONTO DEL COMPROBANTE:
            </h5>
        </div>
        <form action="{{ route('cobros.store_desglose',$Cobro->id)}}" method="POST" enctype="multipart/form-data" id="form1">
        @csrf
        <x-jet-input type="hidden" name="item" value=" "/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-body">
                            <h1>Ingrese el monto que le corresponde a cada pedido</h1>
                            @php
                            $i=1;
                            @endphp
                            @foreach($Pedidos as $p)
                            <br>
                            <hr>
                            
                            <div class="col-sm-8 col-md-7 py-4">
                            Pedido {{$p->invoice}} </div>
                                    
                                    <div class="form-group">
                                        <x-jet-label value="* IMPORTE PARCIAL CON IVA" />
                                        <x-jet-input type="hidden" name="{{'order_id['.$i.']'}}"    value="{{$p->order_id}}"/>

                                        <x-jet-input type="number" min="0" step="any" name="{{'amount['.$i.']'}}"  id="{{'P'.$i}}" class="form-control just-number price-format-input" class="w-full text-xs" />
                                        <x-jet-input-error for='amount' />
                                    </div>
                                    @php 
                                    $i=$i+1;
                                    @endphp
                                    @endforeach
                            <table class="table table-striped text-lg text-center font-medium" style="width: 50%">
                                <tr>
                                    <td>Total Ingresado:</td>
                                    <td id="suma"> $ 0.0 </td>
                                </tr>
                                <tr>
                                    <td>Debe sumar:
                                        <br> (cantidad del cobro)
                                    </td>
                                    <td>$ {{number_format($Cobro->amount,2)}} </td>
                                </tr>

                            </table>
                                    


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                  <a href="{{ route('factures.index')}}" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>  
                <button type="button" class="btn btn-green mb-2"   onclick="guardar()">
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

@for ($i = 1; $i <= $Pedidos->count(); $i++)
<script>

    
     document.getElementById("{{'P'.$i}}").addEventListener("input", function(){
      actualizarTotal();
    });
</script>
@endfor

<script>
  function actualizarTotal(){
    var npedidos=parseInt("{{$Pedidos->count()}}");
    var total = 0;
    for (var i = 1; i <= npedidos; i++) {
      valor=document.getElementById("P"+i).value;
      if( parseFloat(valor)>0){
      total=total+ parseFloat(valor);}
    }
document.getElementById("suma").innerHTML='$'+String(parseFloat(total).toFixed(2));
  }
</script>

<script>
    function guardar(){
        var npedidos=parseInt("{{$Pedidos->count()}}");
    var total = 0;
    var flexin =0.001;

    var amount=parseFloat("{{$Cobro->amount}}");
    for (var i = 1; i <= npedidos; i++) {
      valor=document.getElementById("P"+i).value;
      if( parseFloat(valor)>0){
      total=total+ parseFloat(valor);}
    }
    if(total>=amount-0.001 && total>=amount-0.001){

        document.getElementById("form1").submit();

    }else{
        alert("Las cantidades ingresadas no suman el monto cobrado");
    }
    
    }
</script>
@stop

