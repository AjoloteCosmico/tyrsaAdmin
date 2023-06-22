@extends('adminlte::page')

@section('title', 'PEDIDO INTERNO')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-credit-card"></i>&nbsp; CONDICIONES DE PAGO</h1>
    
@stop

@section('content')
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">

        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm">
                <table>
                        <tr>
                            <td rowspan="4">
                               <img src="{{asset('img/logo/logo.svg')}}" alt="TYRSA">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lg" style="color: red">{{ $CompanyProfiles->company}}</td>
                        </tr>
                        <tr>
                            <td>{{ $CompanyProfiles->motto}}</td>
                        </tr>
                        <tr class="text-xs">
                            <td>
                                <br>
                                Domicilio Fiscal:<br>
                                {{$CompanyProfiles->street.' '.$CompanyProfiles->outdoor.' '.$CompanyProfiles->intdoor.' '.$CompanyProfiles->suburb.' '.$CompanyProfiles->city.' '.$CompanyProfiles->state.' '.$CompanyProfiles->zip_code}}<br>
                                R.F.C: {{$CompanyProfiles->rfc}} &nbsp; Tels: 01-52 {{$CompanyProfiles->telephone.', '.$CompanyProfiles->telephone2}} &nbsp; E-mail: {{$CompanyProfiles->email}} &nbsp; Web: {{$CompanyProfiles->website}}
                            </td>
                        </tr>
                    </table>
                    <br><br>
                    <table class="table">
  <thead>
    <tr>
      <th scope="col">RESUMEN DEL PEDIDO INTERNO (P.I.) NUMERO</th>
      <td >{{$InternalOrders->invoice}}</td>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Moneda</th>
      <td>{{$Coins->code}}</td>
      
    </tr>
  </tbody>
  
</table>

                    <br><br>
<p style ="font-size:250%;">TABLA PROMESA DE COBROS</p>
<br>
<h2 style='color:#2C426C; font-size: 150%'>* Todos los pagos incluyen IVA</h2>
<br><br>
<form action="{{ route('internal_orders.pay_conditions')}}" method="POST" enctype="multipart/form-data" id="form1">
@csrf
<x-jet-input type="hidden" name="rowcount"  id="rowcount" value={{$npagos}}/>
<x-jet-input type="hidden" name="customerID"   value="{{$InternalOrders->customer_id}}" />
<x-jet-input type="hidden" name="sellerID" value="{{$InternalOrders->seller_id}}"/>
<x-jet-input type="hidden" name="sellerID" value="{{$InternalOrders->customer_shipping_address_id}}"/>
<x-jet-input type="hidden" name="coinID" value="{{$InternalOrders->coin_id}}"/>
<x-jet-input type="hidden" name="total" id="total" value="{{$InternalOrders->total}}"/>
<x-jet-input type="hidden" name="order_id" value="{{$InternalOrders->id}}"/>
<x-jet-input type="hidden" name="" value=0/>
<table class="table table-striped" name="tabla1" id="tabla1">
  <thead class="thead">
    <tr>
      <th scope="col">Entregable</th>
      <th scope="col">% negociado</th>
      <th scope="col">cantidad</th>
      <th scope="col">Fecha MM/DD/AAAA</th>
      <th scope="col">Concepto</th>
    </tr>
  </thead>
  <tbody>
  @php
    $emision = new DateTime($InternalOrders->reg_date);
    $entrega = new DateTime($InternalOrders->date_delivery);
    @endphp
    
   
   @for ($i = 1; $i <= $npagos; $i++)
    
   @php
      $aux_count=$aux_count+1;
      @endphp
    
    <tr>
        <td>{{'COBRO '.$aux_count}}</td>
        <td> <input type='number' min='0' max='100' step='1'  style='width: 70%;' name="{{'porcentaje['.$aux_count.']'}}"  id="{{'P'.$aux_count}}">%</td>
        <td>{{$Coins -> symbol}} <input type='number' min='0' step='any' max='{{number_format( $InternalOrders->total,2)}}' id="{{'R'.$aux_count}}" style='width: 70%;' ></td>
        @if($i==1)
        
    <td> <input type='date'  required class='w-full text-xs date' name="{{'date['.$aux_count.']'}}"  id="{{'D'.$aux_count}}" value="{{$emision->format('Y-m-d');}}"></td>
        
    @else
    <td> <input type='date'  required class='w-full text-xs date' name="{{'date['.$aux_count.']'}}"  id="{{'D'.$aux_count}}"  value="{{$entrega->format('Y-m-d');}}"></td>
         @endif
        <td> <input type='text' style='width: 50%;'  name="{{'concepto['.$aux_count.']'}}" id="{{'C'.$aux_count}}"onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
        
     </tr>
      

      @endfor
    <tr >
    <th rowspan="3" scope="row">TOTALES: </th>  
    <td> Subtotal: {{$Coins -> symbol}} {{ number_format($Subtotal,2)}}</td>
    <td> SUMA:</td>
    </tr>
    <tr>
    <td> Iva: {{$Coins -> symbol}} {{number_format( $Subtotal*(1-$InternalOrders->descuento)*0.16,2)}}</td>
    <td id="monitor">
    </td>
    </tr>
    <tr>
    <td> Total: {{$Coins -> symbol}} {{number_format( $InternalOrders->total,2)}}</td>
    
    </tr>
    
    </tbody>
</table>

<!--
      <td> <span><button type="button" onclick="myFunction()"  class="btn btn-blue mb-2"> </span>
      <i class="fa fa-plus" ></i>
      &nbsp; &nbsp;
      <p>Agregar Concepto</p></button></td>-->
      
  
    <br>
    <button   type="button" class="btn btn-blue mb-2"  onclick="redondear()">
                <i class="fa-regular fa-circle fa-2x" ></i>
                         &nbsp; &nbsp;
                <p>Redondear</p></button>
 
    <br><br>

    <button   type="button" class="btn btn-green mb-2"  onclick="guardar()">
                <i class="fas fa-save fa-2x" ></i>
                         &nbsp; &nbsp;
                <p>Guardar Porcentaje de Avance</p></button>
 

                </div>
                </form>
                
                
</div>

@stop

@section('css')
    
@stop

@section('js')

@if ($actualized == 'SI')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/percentage_actualized.js') }}"></script>
@endif

@if ($actualized == 'NO')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/percentage_incorrect.js') }}"></script>
@endif

<script>
  function actualizarTotal(){
    var npagos=parseInt("{{$npagos}}");
    var total = 0;
    for (var i = 1; i <= npagos; i++) {
      valor=document.getElementById("P"+i).value;
      if( parseFloat(valor)>0){
      total=total+ parseFloat(valor);}
    }
document.getElementById("monitor").innerHTML=String(parseFloat(total))+'%';
  }
</script>

@for ($i = 1; $i <= $npagos; $i++)
<script>
 document.getElementById("{{'R'.$i}}").addEventListener("input", function(){
  total = parseFloat(document.getElementById('total').value);
    document.getElementById("{{'P'.$i}}").value = (this.value/total)*100;
    actualizarTotal();
    }); 
    
     document.getElementById("{{'P'.$i}}").addEventListener("input", function(){
      total = parseFloat(document.getElementById('total').value);
      document.getElementById("{{'R'.$i}}").value = parseFloat(this.value*total*0.01).toFixed(2);
      actualizarTotal();
    });
</script>
@endfor

<script>
  function redondear(){
    var npagos=parseInt("{{$npagos}}");
    var total = 0;
    for (var i = 1; i <= npagos; i++) {
      valor=document.getElementById("P"+i).value;
      if( parseFloat(valor)>0){
      total=total+ parseFloat(valor);}
    }
    var diferencia=100-total;
    ultimo=document.getElementById("P"+"{{$npagos}}").value;
    console.log(parseFloat(ultimo)+diferencia);
    if(parseFloat(ultimo)+diferencia<0){
      
      alert("No se peude redondear, acerquese mas al 100%");
    }else{
    document.getElementById("P"+"{{$npagos}}").value=parseFloat(ultimo)+parseFloat(diferencia);
    actualizarTotal();}
  }
</script>

<script>
    function guardar() {
      var total=parseInt(0);
      console.log("todo bien");
      var count= parseInt("{{$npagos}}")
      var myForm = document.forms.form1;
      var myControls = myForm.elements['porcentaje'];
      
      for (var i = 1; i <= count; i++) {
      console.log(i);
      var p=document.getElementById("P"+i).value;
      var error=0;
      console.log("todo bien");
      var c=document.getElementById("C"+i).value;
      var d=document.getElementById("D"+i);
      console.log(c)
      //var campo = $('#id_del_input').val();
      total=total+parseFloat(p);
      if (c=="") {
        console.log("concepto vacio")
        alert("Concepto sin nombre");
        console.log("concepto vacio");
        error=1;
      }
      console.log(d)
      if (!d.value) {
        console.log("Fecha vacia");
        alert("Fecha Vacía");
        error=1;
      }
      }
      console.log(total);
      if (total >=101||total<=99) {
      alert("Los porcentajes no suman 100%");
      error=1;
      
         }
      if(error==0){  

      document.getElementById("form1").submit();}


    }
</script>
<script>
$(document).ready(function () {
  $('.date').datetimepicker({
    format: 'MM/DD/YYYY',
    locale: 'en'
  });
});
</script>
@stop