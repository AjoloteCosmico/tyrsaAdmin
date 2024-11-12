@extends('adminlte::page')

@section('title', 'PEDIDOS INTERNOS')

@section('content_header')
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp; PEDIDO INTERNO</h1>
@stop

@section('content')     <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm" >
                
            
            <h5 class="text-lg text-center text-bold">PEDIDO INTERNO</h5>
            <br>
            <div >
                        <!-- 14 columas, para poder copiar del excel -->
            <table >
                <tr><th colspan="14">Datos del Cliente</th></tr>
                    <tr class="text-center">
                        <th colspan="2"> Numero del cliente:</th>
                        <td colspan="2"> {{$Customers->clave}} </td>
                        <th colspan="2">  Nombre corto: </th> 
                        <td colspan="4">{{$Customers->alias}} </td>
                        <th colspan="2">CP: </th>
                        <td colspan="2"> {{$Customers->customer_zip_code}} </td>
                    </tr>

                    <tr>
                        <th colspan="2"> Razon Social: <br> </th>
                        <td colspan="12"> {{$Customers->customer}} <br> <br> </td>
                    </tr>

                    
                    <tr>
                        <th>vendedor:  </th>
                        <td> {{$Sellers->iniciales}} </td>
                        
                        <th colspan="2"> no. vendedor:</th>
                        <td >  {{$Sellers->folio}}</td>
                        
                        <th colspan="2">Comision del vend:</th>

                        <td colspan="2">  {{ number_format($InternalOrders->comision * 100,2)}} %</td>
                        <th colspan="2">O.C:</th>
                        <td>  {{$InternalOrders->oc}} </td>
                        <th> Moneda:</th>
                        <td>  {{$Coins->code}} </td>
                    </tr>
                    <tr>
                        <th colspan="2">categoria del proyecto:  </th>
                        <td colspan="2"> {{$InternalOrders->category}} </td>
                        
                        <th colspan="4">Descripcion global del proyecto:  </th>
                        <td colspan="2"> {{$InternalOrders->description}} </td>
                        <th colspan="2">ubicacion de la tienda:  </th>
                        <td colspan="2" > Edomex </td>
                        
                        </tr>
                    </table>

               </div>
                
            
            <br> &nbsp;
          

 <br>
            <!-- tablaunida -->
            <table>
                <tr>
                    <th>Numero de COBROs:</div></td>
                    <td> {{$payments->count()}}</div></td>
                    <td style="border: none;"> </td><!-- celda de espacio -->
                    <th>Subtotal: </td>
                    <td> $ {{number_format($InternalOrders->subtotal,2)}}</div></td>
                       
                </tr>

                <tr> 
                    <th rowspan="2">Condiciones de PAGO: @foreach($payments as $pay) <br> @endforeach</div></td>
                    <td rowspan="2">  @foreach($payments as $pay)
                        {{$pay->percentage}}% &nbsp; {{$pay->concept}},<br>
                        @endforeach</div>
                    </td>
                    <td  rowspan="2" style="border: none;"> </td><!-- celda de espacio -->
                    <th>Descuento: </td>
                        <td> $ {{number_format($InternalOrders->descuento * $InternalOrders->subtotal,2)}} </div></td>
                       
                </tr>

                <tr>
                <th>I.E.P.S:</td>
                <td> $ {{number_format($InternalOrders->ieps * $InternalOrders->subtotal,2)}}</div></td>   
                </tr>
                
                <tr>
                    <th>Forma de pago:</th>
                    <td> Transferencia Electronica</td>
                    <td style="border: none;"> </td><!-- celda de espacio -->
                    <th>RET ISR:</td>
                    <td> $  {{number_format($InternalOrders->isr * $InternalOrders->subtotal,2)}}</div></td>
                           
                    
                </tr>
                
                <tr>
                    <th rowspan="3">Observaciones: <br> <br> <br> </th>
                    <td rowspan="3"> <br> -<br> </td>
                    <td  rowspan="3" style="border: none;"> </td><!-- celda de espacio -->
                    <th>RET IVA:</td>
                        <td> $  {{number_format($InternalOrders->tasa* $Items->where('family','FLETE')->sum('import'),2)}}</div></td>
                        
                </tr>
                <tr>
                        <th>IVA:</td>
                        <td> $  {{number_format(0.16 * $InternalOrders->subtotal*(1-$InternalOrders->descuento),2)}}</div></td>
                        </tr>
                        <tr>
                        <th>Total</td>
                        <td> $ {{number_format($InternalOrders->total,2)}}</div></td>
                        </tr>
            </table>
    

             

               <table style="border: none;">
                <tr  id="primer_tr" style="border: none;">
                    <td style="border: none; word-wrap: break-word; width: 20%;">
                    <table  style="border: none; ">
                        <tr style="border: none; border-collapse: collapse;">
                            <td style="border: none; word-wrap: break-word;">
                                Firma o codigo
                              <!--  {{$Sellers->seller_email.' '.$Sellers->seller_mobile}}-->
                              <br> <br>
                              
                            <hr style="border-top: 0.3vw solid black; border-color:#000000; width: 90%">
                               
                              <p style="color:red"> Elaboró </p><br>
                                   {{$Sellers->firma}}
                            </td>
                        </tr>
                    </table>
                </td>

                    @foreach ($requiredSignatures as $firma)
       
<td style="border: none;  width: 20%;">
       <ul>
           <li>
               <div class="row" style="padding:0.5vw">


                   @if($firma->status == 0)
                   <form action="{{ route('internal_orders.firmar') }}" method="POST" enctype="multipart/form-data">
                   @csrf
                   <x-jet-input type="hidden" name="signature_id" value="{{$firma->id}}"/>
                   <div class="col">
                       <span class="text-xs uppercase">Firma: {{$firma->job}}</span><br>
                   </div>

                   <div class="col">
                       <div class="row">
                           <x-jet-input type="password" name="key" class="w-flex text-xs"/>
                       </div>
                       <div class="row">
                           <button class="btn btn-green">Firmar</button>
                       </div>
                   </div>
                   </form>
                   @else
                   <table  style="border: none; border-collapse: collapse;">
                       <tbody>
                           <tr style="font-size:16px; font-weight:bold" style="border: none;"><td style="border: none;">{{$firma->firma}} <br>  <hr style="border-top: 0.3vw solid black; border-color:#000000; width: 90%">
                              </td></tr>
                           <tr style="border: none;"><td style="border: none;"><span style="font-size: 17px"> <i style="color : green"  class="fa fa-check-circle" aria-hidden="true"></i> Autorizado por  {{$firma->job}} </span>
                   </td></tr>
                       </tbody>
                   </table>
                    
                   <br><br><br><br>
                   @endif
               </div>
           </li>
       </ul>
       </td>
   @endforeach

   @for ($i = $requiredSignatures->count()+1 ; $i <= 4; $i++)
   <td style="border: none;"><table  style="border: none; ">
                        <tr style="border: none; border-collapse: collapse;">
                            <td style="border: none; word-wrap: break-word;">
                                Firma o codigo
                              <!--  {{$Sellers->seller_email.' '.$Sellers->seller_mobile}}-->
                              <br> <br>
                              
                            <hr style="border-top: 0.3vw solid black; border-color:#000000; width: 90%">
                               
                              <p style="color:red"> Autorizacion {{$i}} </p><br>
                                   Iniciales
                            </td>
                        </tr>
                    </table></td>
    @endfor
                </tr>
               </table>
               

                  
                   
                                    

                    <br>
        <center>
        <form action="{{ route('internal_orders.unautorize',$InternalOrders->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
            <h1 class="text-center text-bold" style="font-size: 4.0vw">
                ¿Estas Seguro que deseas borrar estas autorizaciones?
            </h1>                
            <br>
            <h2  style="font-size: 2.0vw; color='#AFAFAF'">El pedido vovlera al status "Capturado" y tendra que volver a firmarse, ingresa tu contraseña y da click en</h2>
            <div class="form-group" style="width:50%">
                                        <x-jet-label value="* Confirma tu contraseña" />
                                        <x-jet-input type="password"  name="password" id="input-price" class="form-control  w-full text-xs" />
                                        <x-jet-input-error for='password' />
                
                                    </div>
            <div class="row">
            <div class="col-12 text-right p-2 gap-2">
                  <a href="{{ route('internal_orders.show',$InternalOrders->id)}}" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>  
                <button type="submit" class="btn btn-green mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Desautorizar
                </button>
            </form>
            </div>
            </div>
        </center>
        
        </div>
    </div>
    
            
@stop

@section('css')
<style>
@media print {
  #printPageButton {
    display: none;
  }
}
</style>
<style>
    td{
        border: 1px solid black;
        padding: 0.2vw;
    }
    th{
        border: 1px solid white;
        padding: 0.2vw;
    }
 
tr:first-child th {
  border-top: none;
}

tr:last-child th {
  border-bottom: none;
}

tr th:first-child {
  border-left: none;
}

tr th:last-child {
  border-right: none;
}
.com-text{
    white-space: pre-wrap;
      word-wrap: break-word;
}


</style>
@stop

@section('js')
<script>
    $('#badge').css('height', $('#badge').parent('td').height());
</script>

@stop