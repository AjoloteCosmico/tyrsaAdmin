@extends('adminlte::page')

@section('title', 'PEDIDO INTERNO')

@section('content_header')
    <h1 class="font-bold"><i class="fa-solid fa-credit-card"></i>&nbsp; CONDICIONES DE PAGO</h1>
    
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
      <td >2990</td>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Moneda</th>
      <td>MN</td>
      
    </tr>
  </tbody>
  
</table>
                    <br><br>

<form action="{{ route('internal_orders.pay_conditions')}}" method="POST" enctype="multipart/form-data">
@csrf
<x-jet-input type="hidden" name="order_id" value="{{ $percentage->order_id }}"/>
<x-jet-input type="hidden" name="rowcount"  id="rowcount" value=1/>
<table class="table table-striped" name="tabla1" id="tabla1">
  <thead class="thead">
    <tr>
      <th scope="col">Entregable</th>
      <th scope="col">% negociado</th>
      <th scope="col">Monto sin IVA</th>
      <th scope="col">IVA</th>
      <th scope="col">TOTAL</th>
      <th scope="col">Avances requeridos </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="table-active">Factura y finanzas</td>
      <td ><input type="number" min="0" max="100" step="5"  value="{{$percentage->factures }}" style="width: 20%;" name="factures" > %</td>
      <td> {{$Coins -> symbol}} {{$Subtotal * $percentage->factures}}</td>
      <td> {{$Coins -> symbol}} {{$Subtotal * $percentage->factures* 0.16 }}</td>
      <td> {{$Coins -> symbol}} {{$Subtotal * $percentage->factures* 1.16 }}</td>
      <td>{{$percentage->factures}} %</td>
    </tr>
    
    <td ></td>
    <th scope="row">TOTAL: </th>
      
      <td>{{$Coins -> symbol}} {{ $Subtotal}}</td>
      <td> {{$Coins -> symbol}} {{ $Subtotal*0.16}}</td>
      <td> {{$Coins -> symbol}} {{ $Subtotal*1.16}}</td>
      <td></td>
      <td></td>
    </tr>
    
    <tr>
    <td > </td>
    </tbody>
</table>
      <td><button type="submit" class="btn btn-dark" hidden = "hidden" >
                <i class="fa-solid fa-repeat fa-2x" ></i>
                         &nbsp; &nbsp;
                <p>Actualizar Porcentajes</p></button></td>


      <td><button type="button" onclick="myFunction()"  class="btn btn-dark" >
      <i class="fa fa-plus" aria-hidden="true"></i>
      &nbsp; &nbsp;
      <p>Agregar Concepto</p></button></td>
      <td></td>
      <td></td>
    </tr>
   
 

                </div>
                </form>
                <button  class="btn btn-dark" >
                <i class="fa-solid fa-calendar fa-2x" ></i>
                         &nbsp; &nbsp;
                <p>Guardar Pagos</p></button></td>
                <div class="collapse" id="collapseExample">
                <div class="column">
                  <br><br><br>

               
             </div>
        </div>
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
function myFunction() {
  var count= document.getElementById("rowcount").value;
  count ++;
  console.log(count);
  var table = document.getElementById("tabla1");
  var row = table.insertRow(count);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  cell1.innerHTML ="<input type='text' id='lname' name='lname'>";
  cell2.innerHTML = "<input type='number' min='0' max='100' step='5'  value=5 style='width: 20%;' name='factures' > %";
  cell3.innerHTML = '<td><button type="button" class="btn btn-danger rounded-0" id ="deleteRow"><i class="fa fa-trash"></i></button</td>';
  document.getElementById("rowcount").value = count;
}

$("table").on("click", "#deleteRow", function (event) {
        $(this).closest("tr").remove();
        count -= 1
    });
</script>
@stop