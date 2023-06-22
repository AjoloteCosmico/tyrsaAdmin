@extends('adminlte::page')

@section('title', 'PEDIDO INTERNO')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-credit-card"></i>&nbsp; CONDICIONES DE COBRO</h1>
    
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
<h2 style='color:#2C426C; font-size: 150%'>* Todos los cobros incluyen IVA</h2>
<br><br>
<form action="{{ route('internal_orders.pay_redefine')}}" method="POST" enctype="multipart/form-data" id="form1">
@csrf
<x-jet-input type="hidden" name="pe"  id="pe" value="{{$pe}}"/>
<x-jet-input type="hidden" name="rowcount"  id="rowcount" value="{{$npagos+1}}"/>
<x-jet-input type="hidden" name="customerID"   value="{{$InternalOrders->customer_id}}" />
<x-jet-input type="hidden" name="sellerID" value="{{$InternalOrders->seller_id}}"/>
<x-jet-input type="hidden" name="sellerID" value="{{$InternalOrders->customer_shipping_address_id}}"/>
<x-jet-input type="hidden" name="coinID" value="{{$InternalOrders->coin_id}}"/>
<x-jet-input type="hidden" name="subtotal" id="total" value="{{$InternalOrders->total}}"/>
<x-jet-input type="hidden" name="order_id" value="{{$InternalOrders->id}}"/>
<x-jet-input type="hidden" name="pagados" value="{{$pagados->count()+1}}"/>


<table class="table table-striped" name="tabla1" id="tabla1">
  <thead class="thead">
    <tr>
      <th scope="col">Entregable</th>
      <th scope="col">% negociado</th>
      <th scope="col">Cantidad</th>
      <th scope="col">Fecha</th>
      <th scope="col">Concepto</th>
    </tr>
  </thead>
  <tbody>
  
  @foreach($pagados as $row)
     <tr>
        <td> COBRO {{$aux_count}}</td>
        <td>  {{$row->percentage}}%</td>
        <td> {{ number_format($row->amount)}}</td>
        <td> {{$row->date}}</td>
        <td> {{$row->concept}}</td>
     </tr>
     @php
      $aux_count=$aux_count+1;
      @endphp
     @endforeach
     
     @foreach($no_pagados as $row)
     <tr>
        <td>COBRO {{$aux_count}}</td>
        <td> <input type='number' min='0' max='100' step='5'  style='width: 80%;' name="{{'porcentaje['.$aux_count.']'}}" value = "{{$row->percentage}}" id="{{'P'.$aux_count}}">%</td>
        <td>{{$Coins -> symbol}} <input type='number' min='0' max='{{$Total}}' id="{{'R'.$aux_count}}" style='width: 70%;' disabled></td>
        <td> <input type='date'  required class='w-full text-xs' name="{{'date['.$aux_count.']'}}" value = "{{$row->date}}" id="{{'D'.$aux_count}}"></td>
        
        <td> <input type='text' name="{{'CONCEPTO['.$aux_count.']'}}" value = "{{$row->concept}}" id ="{{'C'.$aux_count}}"></td>
        <td><button type="button" class="btn btn-danger rounded-0" id ="deleteRow"><i class="fa fa-trash"></i></button></td>
      </tr>
     @php
$aux_count=$aux_count+1;
@endphp

     @endforeach
     
    </tbody>
</table>
    
<table>
<tr >
    <th scope="row">TOTAL: </th>
      
      <td>{{$Coins -> symbol}} {{ number_format($Subtotal)}} <br> (subtotal)</td>
      <td> {{$Coins -> symbol}} {{number_format( $Subtotal*(1-$InternalOrders->descuento)*0.16,2)}} <br> (iva)</td>
      <td> {{$Coins -> symbol}} {{number_format( $InternalOrders->total,2)}}<br> (total)</td>
    </tr>
</table>
<br>
      <td> <span><button type="button" onclick="myFunction()"  class="btn btn-blue mb-2"> </span>
      <i class="fa fa-plus" ></i>
      &nbsp; &nbsp;
      <p>Agregar Concepto</p></button></td>
      
  
    <br>
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
@for ($i = $pagados->count()+1; $i <= $npagos; $i++)
<script>
  document.getElementById("{{'R'.$i}}").addEventListener("input", function(){
  total = parseFloat(document.getElementById('total').value);
    document.getElementById("{{'P'.$i}}").value = (this.value/total)*100;
    }); 
    
     document.getElementById("{{'P'.$i}}").addEventListener("input", function(){
      total = parseFloat(document.getElementById('total').value);
      document.getElementById("{{'R'.$i}}").value = parseFloat(this.value*total*0.01).toFixed(2);
    });
</script>
@endfor
<!-- <script>
  for (var i = parseInt('{{$pagados->count()+1}}'); i <= parseInt( '{{$npagos}}'); i++) {
    console.log(i);
    cant = document.getElementById("R"+String(i));
    per = document.getElementById("P"+String(i));
    console.log(per.value);
    cant.addEventListener("input", function(){
  total = parseInt(document.getElementById('subtotal').value)*1.16;
    document.getElementById("P"+String(i-1)).value = (this.value/total)*100;
    }); 
    console.log(i);
     document.getElementById("P"+String(i)).addEventListener("input", function(){
      total = parseInt(document.getElementById('subtotal').value)*1.16;
      document.getElementById("R"+String(i-1)).value = this.value*total*0.01;
    });
    console.log(String(i-1));}
</script> -->

@if ($actualized == 'SI')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/percentage_actualized.js') }}"></script>
@endif

@if ($actualized == 'NO')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/percentage_incorrect.js') }}"></script>
@endif



<script>
  
function myFunction() {
  index=1
  var count= parseInt(document.getElementById("rowcount").value);
  total = parseFloat(document.getElementById('subtotal').value)*1.16;
  console.log(count);
  var table = document.getElementById("tabla1");
  var row = table.insertRow(count);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  var cell5 = row.insertCell(4);
  var cell6 = row.insertCell(5);
  cell5.innerHTML = "<input type='text' name='CONCEPTO["+count+"]'  id='C"+count+"'>";
  cell2.innerHTML = "<input type='number' min='0' max='100' step='5'  value="+count+" style='width: 80%;' name='porcentaje["+count+"]' id='P"+count+"'> %";
  cell3.innerHTML = "$ <input type='number' min='0' id='R"+count+"' style='width: 70%;'>";
  cell4.innerHTML = "<input type='date'  required class='w-full text-xs' name='date["+count+"]' id='D"+count+"'>";
  cell1.innerHTML = "<span  style='width: 50%;' >PAGO "+count+"<span/>";
  cell6.innerHTML = '<button type="button" class="btn btn-danger rounded-0" id ="deleteRow"><i class="fa fa-trash"></i></button>' ;
  
  document.getElementById("R"+String(count)).addEventListener("input", function(){
     document.getElementById("P"+String(count-1)).value = (this.value/total)*100;
    });
  document.getElementById("P"+String(count)).addEventListener("input", function(){
    
     total = parseFloat(document.getElementById('subtotal').value)*1.16;
     document.getElementById("R"+String(count-1)).value = this.value*total*0.01;
    });
  count =count +1;
  document.getElementById("rowcount").value = count;
  index=count;
  console.log(count);
}



$("table").on("click", "#deleteRow", function (event) {
        $(this).closest("tr").remove();
        console.log(count);
        var count= document.getElementById("rowcount").value;
        count = count -0.5;
        document.getElementById("rowcount").value = count;
        console.log(count);
    });


    function guardar() {
      
      var total=parseInt(0);
      
      var count= document.getElementById("rowcount").value;
      
      console.log(count);
      var pe=document.getElementById("pe").value;
      console.log(pe);
      for (var i = parseInt('{{$pagados->count()+1}}'); i < count; i++) {
        console.log(i);
      var p=document.getElementById("P"+i).value;
      console.log(p);
      var c=document.getElementById("C"+i).value;
      console.log(c)
      var d=document.getElementById("D"+i);
      console.log(d)
      var campo = $('#id_del_input').val();
      total=total+parseFloat(p);
      if (c=="") {
        console.log("concepto vacio")
        alert("Concepto sin nombre");
        console.log("concepto vacio")
      }
      console.log(d)
      if (!d.value) {
        console.log("Fecha vacia");
        alert("Fecha Vacía");
      }
      }
      console.log(total);
      console.log(total);
      if (total != pe) {
      alert("Los porcentajes no suman 100%, sino "+ String((100-pe)+total));
      
         }else
      document.getElementById("form1").submit();


    }
</script>
@stop