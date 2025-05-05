@extends('adminlte::page')

@section('title', 'Cuentas por Cobrar')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-credit-card"></i>&nbsp; CUENTAS POR COBRAR</h1>
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
                                <h1 style="font-size : 30px;">COMPROBANTE DE INGRESOS   NO.
                 </h1>
                            </td>
                        </tr>
                        <tr>
                        Aplicacion del pago NO. {{$pay->id}}
                        </tr>
                        
</table>
           <div class ="row">  
            <div class ="col"></div>
            <div class ="col">

            <table class="table table-striped table-sm" style="width : 500px; align-self : center; display:flex">
                <tbody>
                    <tr>
                        <td style="background-color:#A6ADBC"> Cliente: </td>
                        <td>{{$cliente->customer}}</td>
                    </tr>
                    
                    <tr>
                        <td style="background-color:#A6ADBC"> Cantidad del pago: </td>
                        <td> $ {{number_format($pay -> amount)}}</td>
                    </tr>
                    <tr>
                        <td  style="background-color:#A6ADBC">Concepto: </td>
                        <td>Cantidad Fija</td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div class ="col"></div>
           </div>
            <div>
            <form action="{{ route('accounting.pay_amount_apply')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-jet-input type="hidden" name="pay_id" value="{{$pay->id}}"/>
                <x-jet-input type="hidden" name="customer_id" value="{{$cliente->id}}"/>
                
                @if($pay -> status == 'por cobrar')
                 
                 <h1>Datos de la factura:</h1>

                <div class="row">
                    <div class="col ">
                        <div class="form-group">
                            <x-jet-label value="* Numero de Factura" />
                            <x-jet-input type="text" name="nfactura"  value="{{old('customer_street')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>         
                        </div>
                        <div class="form-group">
                            <x-jet-label value="Cantidad a pagar" />
                            $ <x-jet-input type="number" min="0" name="amount" value=100  /> 
                         </div>
                        <div class="form-group">
                            <x-jet-label value="tipo_cambio" />
                            <x-jet-input type="number" min="0" name="tipo_cambio" value=1  /> 
                            </div>        
                     <div class="form-group">
                            <x-jet-label value="* BANCO" />
                            <x-jet-input type="text" name="banco"  value="{{old('customer_street')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>         
                        </div>
                        <!-- </div>
                         <div class="form-group">
                            <x-jet-label value="Fecha" />
                            <x-jet-input type="date" name="fecha_factura" value="{{old('customer_street')}}"/>         
                        
                         </div><div class="form-group">
                            <x-jet-label value="* Importe total (IVA incluido)" />
                            <x-jet-input type="text" name="importe_total" value="{{old('customer_street')}}"/>         
                        
                         </div><div class="form-group">
                            <x-jet-label value="* Porcentaje parcial" />
                            <x-jet-input type="text" name="porcentaje_parcial" value="{{old('customer_street')}}"/>         
                        
                         </div>
                         <div class="form-group">
                            <x-jet-label value="* Importe Acumulado" />
                            <x-jet-input type="text" name="importe_acumulado" value="{{old('customer_street')}}"/>         
                        
                         </div><div class="form-group">
                            <x-jet-label value="* Porcentaje de pago acumulado" />
                            <x-jet-input type="number" name="porcentaje_acumulado" value="{{old('customer_street')}}"/>%         
                        
                         </div>-->
                    
                         <br>
                <br>


                Ingresa su comprobante
                <br>
                <input type="file" name="comprobante" id="comp" onchange="mostrar()">
                <br><br>
                <div class="form-group" id="pass"  style="display: none">
                            
                            <x-jet-label value="* Firma de quien captura:  " />
                            <x-jet-input type="password" name="customer_street" value="{{old('customer_street')}}"/>         
                         </div>
                         <br>
                <button   type="submit" class="btn btn-green mb-2" id="btn"  onclick="guardar()" style="background-color: rgb(22,163,74);color: white; display: none">
                <i class="fas fa-usd fa-2x" ></i>
                
                         &nbsp; &nbsp;
                <p>Marcar como Pagado</p></button>
                
                     

                </div>
                         
                </form>
                @else
               
                <h1 style ="color : green; font-size: 30px" >Pago completado</h1>
              <br>
              <br>
              <table>
                <tr>
                    <th>Numero <br> de factura</th> 
                    <th>Numero de <br> comprobante</th>
                     <th>Moneda</th>
                    <th>Fecha</th>
                    <th>Importe <br>(IVA incluido)</th>
                    <th>% del Pago <br> Parcial</th>
                    <th>Tipo de <br> Cambio</th>
                    <th>Importe <br> acumulado</th>
                    <th>% de Pago Acumulado</th>

                </tr>
                <tbody>
                    <tr>
                        <td> {{$pay->nfactura}}</td>
                        <td>{{$pay->ncomp}}</td>
                        <td>{{$pay->moneda}}</td>
                        <td>{{$pay->fecha_factura}}</td>
                        <td>{{number_format($pay->importe_total)}}</td>
                        <td>{{$pay->porcentaje_parcial}}</td>
                        <td>{{$pay->tipo_cambio}}</td>
                        <td> {{ number_format($pay->importe_acumulado)}}</td>
                        <td>{{$pay->porcentaje_acumulado}}</td>
                    </tr>
                </tbody>
              </table>
              <br><br><br>
             <button type="button" onclick = "openPDF()"  class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;" > 
             <i class="fas fa-eye fa-2x"></i> &nbsp; Ver comprobante  </button>
             
             <br><br><br> <br>
             <div class="col" style="background-color : #d9d9d9 ; width : 220px ; align-self: center; ">  
             <p>¿Hubó algun problema con la validación  o el pago  fue revocadó?</p>
             <a href="{{route('pay_cancel',$pay->id)}}">
             <button type="button" ><span class="badge badge-pill badge-danger" style="font-size : 20px"> Invalidar pago</span></button>
              </a></div>
                @endif
                       
                
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
<script>
const inFile = document.getElementById("comp");

inFile.addEventListener("change", mostrar);

function mostrar(){
    document.getElementById("btn").style.display="flex";
    document.getElementById("pass").style.display="flex";
}

function openPDF(){
window.open("{{ asset('storage/'.$pay->id.'.pdf') }}");
}
</script>
@stop