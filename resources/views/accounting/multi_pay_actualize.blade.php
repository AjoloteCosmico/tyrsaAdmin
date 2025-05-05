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
                                <h1 style="font-size : 30px;">COMPROBANTE DE INGRESOS  NO. {{$lastComp +1}}</h1>
                            </td>
                        </tr>
                        <tr>
                            <td>Aplicacion del cobro NO. {{$lastComp +1}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>     
                        <h1 style="font-size : 20px;">La cantidad total de los cobros seleccionados es de :</h1>
                        <h1 style="font-size : 30px;"> $ {{number_format($pays->sum('amount'))}}</h1>
                        </td>
                        <td></td>
                        </tr>
                     </table>
                        
                
                        <br><br><br>
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
  <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked onclick="programado();">
  <label class="btn btn-outline-primary" for="btnradio1">Cobro <br> Programado</label>
  <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" onclick="otra();">
  <label class="btn btn-outline-primary" for="btnradio3">Cobrar otra <br> cantidad</label>
</div>
                        <br><br><br>
            <form action="{{ route('accounting.multi_pay_apply')}}" method="POST" enctype="multipart/form-data" id="form1" class="formaxd">
                @csrf
                <x-jet-input type="hidden" name="pay_id" value="{{$pay->id}}"/>
                
                @if($pay -> status == 'por cobrar')
                 
                 <h1>Ingresé el numero de factura para cada comprobante:</h1>
<br><br>
                <div class="row">
                    <div class="col ">
                    
                    <x-jet-input type="hidden" name="otra" id="otra" value="0"/>
                    <div class="form-group">
                        <x-jet-label value="Numero de comprobante " />
                        
                        <x-jet-input type="number" name="ncomp"  value="0" onkeyup="javascript:this.value=this.value.toUpperCase();"/>         
                    </div>
                    @foreach($pays as $pago)
                    
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
                        <td style="background-color:#A6ADBC"> Pedido: </td>
                        <td> @foreach($ordenes as $o) 
                            @if($o->id == $pago->order_id) {{$o->invoice}}
                        @endif @endforeach    </td>
                    </tr>
                    <tr>
                        <td style="background-color:#A6ADBC"> Cantidad del cobro: </td>
                        <td> $ {{number_format($pago -> amount)}}</td>
                    </tr>
                    <tr>
                        <td  style="background-color:#A6ADBC">Concepto: </td>
                        <td>{{ $pago ->concept }}</td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div class ="col"></div>
           </div>
                   <div class="form-group">
                            <x-jet-label value="Fecha" />
                            <x-jet-input type="date" name="fecha_factura" value="{{old('customer_street')}}"/>         
                        
                         </div>

                   <div class="form-group">
                        <x-jet-label value="* Numero de Factura " />
                        <x-jet-input type="hidden" name="pagos[]" value="{{$pago->id}}"/>
                        <x-jet-input type="text" name="nfactura[]"  value="{{old('customer_street')}}" onkeyup="javascript:this.value=this.value.toUpperCase();"/>         
                    </div>
                    
                    <div class="divCant"> 
                 <div class="form-group" >
                      <x-jet-label value="Cantidad a cobrar" />
                    $ <x-jet-input type="number" min="0" name="amount[]" /> 
                         </div></div>

                         <br>
                <input type="file" name="comprobante[]" id="comp" onchange="mostrar()">
                <br>
                    
    @endforeach
             
                   

                        <div class="form-group">
                            <x-jet-label value="tipo_cambio" />
                            <x-jet-input type="number" min="0" name="tipo_cambio" value=1  /> 
                            </div>        
                            <div class="form-group">
                            <x-jet-label value="* BANCO" />
                            <select class="form-capture  w-full text-xs uppercase" name="customer_id" id='customer'>
                                            
                                                <option value="BANAMEX MN" >BANAMEX MX</option>
                                                <option value="BANORTE MN" >BANORTE MX</option>
                                                <option value="BAJIO MN" >BAJIO MX</option>
                                                <option value="SANTANDER MN" >SANTANDER MX</option>
                                                <option value="BANAMEX DL" >BANAMEX DL</option>
                                                <option value="BANORTE DL" >BANORTE DL</option>
                                                <option value="BAJIO DL" >BAJIO DL</option>
                                                <option value="SANTANDER DL" >SANTANDER DL</option>
                                                
                                            
                                        </select> </div>
                    
                         <br>
                <br>

                
                <br>
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
               
                <h1 style ="color : green; font-size: 30px" >Cobro completado</h1>
              <br>
              <br>
              <table>
                <tr>
                    <th>Numero <br> de factura</th> 
                    <th>Numero de <br> comprobante</th>
                     <th>Moneda</th>
                    <th>Fecha</th>
                    <th>Importe <br>(IVA incluido)</th>
                    <th>% del Cobro <br> Parcial</th>
                    <th>Tipo de <br> Cambio</th>
                    <th>Importe <br> acumulado</th>
                    <th>% de Cobro Acumulado</th>

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
             <p>¿Hubó algun problema con la validación  o el cobro  fue revocadó?</p>
             <a href="{{route('pay_cancel',$pay->id)}}">
             <button type="button" ><span class="badge badge-pill badge-danger" style="font-size : 20px"> Invalidar cobro</span></button>
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
    $(".formaxd").on("submit", function(){
        var o = document.getElementById('otra');
        if(o.value==1){
        return confirm("Estas apunto de pagar una cantidad distinta a la programada, ¿Es correcta?");}
    });
</script>

<script>
const inFile = document.getElementById("comp");
const collection = document.getElementsByClassName("divCant");
for (let i = 0; i < collection.length; i++) {
  collection[i].style.display = "none";
}
inFile.addEventListener("change", mostrar);


function mostrar(){
    document.getElementById("btn").style.display="flex";
    document.getElementById("pass").style.display="flex";
}

function openPDF(){
window.open("{{ asset('storage/'.$pay->id.'.pdf') }}");
}

function programado(myRadio) {
    var coll = document.getElementsByClassName("divCant");
for (let i = 0; i < coll.length; i++) {
  coll[i].style.display = "none";
}

var o = document.getElementById('otra');
o.value=0;
console.log(o.value);
}
function otra(myRadio) {

var coll = document.getElementsByClassName("divCant");
for (let i = 0; i < coll.length; i++) {
  coll[i].style.display = "block";
}
var o = document.getElementById('otra');
o.value=1;
console.log(o.value);
    }


</script>
@stop