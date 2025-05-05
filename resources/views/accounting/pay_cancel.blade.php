@extends('adminlte::page')

@section('title', 'Cuentas por Cobrar')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-credit-card"></i>&nbsp; Axel sandbox cajita de arena</h1>
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
                            <td>
                                <h1 style="font-size : 30px; color: red;">Cancelacion del pago NO. {{$pay->id}}</h1>
                            </td>
                        </tr>
                        <tr>
                            
                        </tr>
</table>

            </div>
            
            <br><br><br>
            <div>
            <div style="color : red; size : 20px; width : bolder">
            Estas a punto de cancelar el pago con id {{$pay->id}} asociado al concepto {{$pay->concept}}
            de la orden {{$order->invoice}} del cliente {{$order->customer}}, es nescesaria una autorizacion.
            <i class="fas fa-exclamation-triangle fa-2xl" ></i>
            </div>
            
                </div>
                <br><br><br>
                <div class="col-sm-5 col-xs-12 text-center text-xs font-bold">
            <ul>  <li>
            <div class="row">
            
            <form action="{{ route('accounting.invalidar') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <x-jet-input type="hidden" name="pay_id" value="{{$pay->id}}"/>
                                    <div class="col">
                                        <span class="text-xs uppercase">Firma: Contador </span><br>
                                    </div>
                                   <br><br>
                                    <div class="row">
                                    <div class="col"></div>
                                    
                                        
                                        <div class="col">
                                            <x-jet-input type="password" name="key" class="w-flex text-xs"/>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;"">Invalidar</button>
                                        </div>
                                       
                                    </div>
                                    </form>
                                    </div></li></ul></div>
            </div>
         <br><br>
         
            </div>
        </div>
    </div>
</div>

@stop

@section('css')

    
@stop


@section('js')

@stop