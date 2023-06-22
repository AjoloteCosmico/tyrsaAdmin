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

<table>
  <tbody>
    <tr>
     <td scope="col">Cliente:</td>
     <td>{{$Customers->customer}}</td>
    </tr>
    <tr   >
     <td scope="col">Saldo deudor     (-):</td>
     <td style="color:#ff0000"> {{$Coins -> symbol}} {{number_format( $Subtotal * 1.16 - $abonos->sum('amount'))}}</td>
    </tr>
    <tr style="background-color: #4dff88">
     <td scope="col">Abonos Recibidos (+):</td>
     <td>{{$abonos->count()}}</td>
    </tr>
  </tbody>
</table>


<br><br>
<h1 ><span class="badge badge-secondary" style="font-size : 19px; align-self: start;">Derechos Adquiridos PI: {{$InternalOrders->invoice}} <br>Convenio Inicial </span></h1>


<table class="table table-striped">
  <thead class="thead">
    <tr>
      <th scope="col">Entregable</th>
      <th > % Negociado</th>
      <th scope="col">Monto sin IVA</th>
      <th scope="col">IVA</th>
      <th scope="col">TOTAL</th>
      <th scope="col">Promesa de COBRO </th>
      <th scope="col"># Dias </th>
      <th scope="col"># Semanas </th>

    </tr>
  </thead>
  <tbody>
  @foreach ($hpayments as $row)


  @php
{{$datetime1 = new DateTime($row->date);
  $datetime2 = new DateTime("2022-1-1");
  $dias = $datetime1->diff($datetime2)->format('%a');}}
@endphp
                            <tr class="text-center">
                                <td>  {{ $row->concept }}</td>
                                <td>{{ $row->percentage }} %</td>
                                <td>{{$Coins -> symbol}} {{number_format( $row->percentage * $Subtotal * 0.01)}}</td>
                                <td>{{$Coins -> symbol}} {{number_format( $row->percentage * $Subtotal *0.0016) }}</td>
                                <td>{{$Coins -> symbol}} {{number_format( $row->amount )}}</td>
                                <td>{{ $row->date }}</td>
                                <td>{{$dias}}</td>
                                <td>{{(int)($dias / 7)}}</td>
                      
                                
                            </tr>
                            @endforeach
                            <tr >
                            <td> </td>
    <th scope="row">TOTAL: </th>
      
      <td style="background-color:#A6ADBC">{{$Coins -> symbol}} {{ number_format($Subtotal)}}</td>
      <td style="background-color:#A6ADBC"> {{$Coins -> symbol}} {{ number_format($Subtotal*0.16)}}</td>
      <td style="background-color:#A6ADBC"> {{$Coins -> symbol}} {{ number_format($Subtotal*1.16)}}</td>
    </tr>
   
  </tbody>
</table>
<br><br>


<h1 ><span class="badge badge-secondary" style="font-size : 19px; align-self: start;">Derechos adquiridos PI: {{$InternalOrders->invoice}}  <br>Modificado </span></h1>
<form action="{{ route('internal_orders.pay_conditions')}}" method="POST" enctype="multipart/form-data">
@csrf
<x-jet-input type="hidden" name="order_id" value=""/>

                    <table class="table table-striped">
  <thead class="thead">
    <tr>
      <th scope="col">Entregable</th>
      <th > % Negociado</th>
      <th scope="col">Monto sin IVA</th>
      <th scope="col">IVA</th>
      <th scope="col">TOTAL</th>
      <th scope="col">Promesa de COBRO </th>
      <th scope="col"># Dias </th>
      <th scope="col"># Semanas </th>

    </tr>
  </thead>
  <tbody>
  @foreach ($payments as $row)


  @php
{{$datetime1 = new DateTime($row->date);
  $datetime2 = new DateTime("2022-1-1");
  $dias = $datetime1->diff($datetime2)->format('%a');}}
@endphp
                            <tr class="text-center">
                                <td>  {{ $row->concept }}</td>
                                <td>{{ $row->percentage }} %</td>
                                <td>{{$Coins -> symbol}} {{number_format( $row->percentage * $Subtotal * 0.01)}}</td>
                                <td>{{$Coins -> symbol}} {{number_format( $row->percentage * $Subtotal *0.0016) }}</td>
                                <td>{{$Coins -> symbol}} {{number_format( $row->amount )}}</td>
                                <td>{{ $row->date }}</td>
                                <td>{{$dias}}</td>
                                <td>{{(int)($dias / 7)}}</td>
                      
                                
                            </tr>
                            @endforeach
                            <tr >
                            <td> </td>
    <th scope="row">TOTAL: </th>
      
      <td style="background-color:#A6ADBC">{{$Coins -> symbol}} {{ number_format($Subtotal)}}</td>
      <td style="background-color:#A6ADBC"> {{$Coins -> symbol}} {{ number_format($Subtotal*0.16)}}</td>
      <td style="background-color:#A6ADBC"> {{$Coins -> symbol}} {{ number_format($Subtotal*1.16)}}</td>
    </tr>
   
  </tbody>
</table>
                
                </form>
            
                               
                                    

                
  <div class="row">
    <div class ="col"><input  class="btn btn-gray" type="button" name="imprimir" value="Imprimir" onclick="window.print();"> 
                </div>
    <div class ="col">
                <form action="{{ route('internal_orders.payment_edit', $InternalOrders->id) }}" method="POST">
                                            @csrf                               
                                            <x-jet-input type="hidden" name="order_id" value="{{$InternalOrders->id }}"/>
                                            <button  class="btn btn-green" type="submit" name="editar" >
                                                <i class="fas fa-edit"></i> &nbsp; Editar
                                            </button>
                                        </form>
                                        </div>
    <div class ="col">@can('VER PEDIDOS')
                                        <a href="{{ route('internal_orders.show', $InternalOrders->id)}}">
                                            <i class="fas fa-eye btn btn-blue ">Ver Detalles</i></span>
                                        </a>
                                        @endcan</div>
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

@stop