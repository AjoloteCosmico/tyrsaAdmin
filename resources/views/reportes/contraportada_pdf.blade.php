<!DOCTYPE html>
<html>
<head>
    <title>Hi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
@media print {
  #printPageButton {
    display: none;
  }
}
</style>
<style>
  html { margin: 0px}

    .demo-preview {
  padding-top: 10px;
  padding-bottom: 10px;
  margin: auto;
  text-align: center;
  font-family: "Source Sans Pro";
}
.demo-preview .badge{
  margin-right:10px;
}
.badge {
  display: strech;
  font-size: 7px
  /* font-weight: 50;
  padding: 3px 3px;  */
  border:2px solid transparent;
  /* min-width: 10px; */
   line-height: 1; 
  color: #fff;
   text-align: center;
  white-space: nowrap; 
   vertical-align: middle; 
  border-radius: 4px;
   /* padding: 3px; 
   margin: 1px; */ */
   width: 100%;

  font-family: "Sans-Serif";
}

.badge.badge-default {
  background-color: #B0BEC5
}

.badge.badge-primary {
  background-color: #2B416D
}

.badge.badge-secondary {
  background-color: #323a45
}

.badge.badge-success {
  background-color: #64DD17
}

.badge.badge-warning {
  background-color: #FFD600
}

.badge.badge-info {
  background-color: #29B6F6
}

.badge.badge-danger {
  background-color: #9b9b9b;
  border-color: #9b9b9b;
}

.badge.badge-outlined {
  background-color: transparent
}

.badge.badge-outlined.badge-default {
  border-color: #B0BEC5;
  color: #B0BEC5
}

.badge.badge-outlined.badge-primary {
  
  border-color: #9b9b9b;
  color: #000000
}
.badge.badge-outlined.badge-danger {
border-color: #2B416D;
background-color: #2B416D;
  color: #ffffff;
}
.badge.badge-outlined.badge-secondary {
  border-color: #323a45;
  color: #323a45;
}

.badge.badge-outlined.badge-success {
  border-color: #64DD17;
  color: #64DD17
}

.badge.badge-outlined.badge-warning {
  border-color: #FFD600;
  color: #FFD600
}

.badge.badge-outlined.badge-info {
  border-color: #29B6F6;
  color: #29B6F6
}


</style>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <div class="row"> 
      <div class="col"> &nbsp;&nbsp;&nbsp;</div> 
      <div class="col">
    <table>
                        <tr><td> </td>
                            <td >
                                <div style="padding:15px"  class="contaier">
                        
                                <img src="{{ public_path('img/logo/logo.png') }}"  alt="TYRSA"  style="align-self: left;"></td>
                                                </div></td>
                                 
                            <td style="padding:15px"  rowspan="2">
                        <br>
            Calle Cuernavaca S/N, Col. Ejido del Quemado,<br>
            C.P. 54,963, Tultepec, Edo. México, R.F.C. <br>
            TCO990507S91 Tels: (55) 26472033 / 26473330 <br>
 <div style="text-transform: lowercase;"> info@tyrsa.com.mx www.tyrsa.com.mx</div>     <br>
                        <!-- Domicilio Fiscal:
                                {{$CompanyProfiles->street.' '.$CompanyProfiles->outdoor.' '}}
                                {{$CompanyProfiles->intdoor.' '.$CompanyProfiles->suburb}}
                                <br>{{$CompanyProfiles->city.' '.$CompanyProfiles->state.' '.$CompanyProfiles->zip_code}}<br>
                                R.F.C: {{$CompanyProfiles->rfc}} &nbsp; Tels: 01-52 {{$CompanyProfiles->telephone.', '.$CompanyProfiles->telephone2}} <br> E-mail: {{$CompanyProfiles->email}} &nbsp; Web: {{$CompanyProfiles->website}}
                             -->
                        </td>
                        <td rowspan="2" class="card-body bg-white rounded-xl shadow-md text-center text-sm">
                                <span style="color: darkblue">Numero PI:<br>
                                {{$InternalOrders->invoice}}</span>
                                <br> <br>
                                NOHA: {{$InternalOrders->noha}} 
                            </td>
                        </tr>
                        
                            
                        <td  colspan="2"class="text-lg " style="color: red;  width:23%;">{{ $CompanyProfiles->company}}
                        </td>
                        <tr>
                                           
                        </tr >
                    </table>
            <br>
                    <table>
                    
                    <tr class="text-center">
                        <td> <div style="font-size:17px" class="badge badge-danger badge-outlined"> Cliente: &nbsp; </div></td>
                        <td> <div  style="font-size:17px" class="badge badge-primary badge-outlined"> {{$Customers->customer}} @if($Customers->legal_name!= 'POR ASIGNAR'){{$Customers->legal_name}} @endif</div>  </td>
                        <td > <div   style="font-size:17px" class="badge badge-danger badge-outlined"> Subtotal:</div> </td> 
                        <td ><div   style="font-size:17px" class="badge badge-primary badge-outlined"> {{$Coins->symbol}}{{number_format($InternalOrders->subtotal,2)}} </div></td>
                        <td >- &nbsp;&nbsp;&nbsp; - </td>
                        <td> - &nbsp;&nbsp;&nbsp; -</td>
                    
                    </tr>
                    <tr class="text-center">
                        <td> <div class="badge badge-danger badge-outlined"> Moneda:</div></td>
                        <td> <div class="badge badge-primary badge-outlined">{{$Coins->coin}} </div>  </td>
                        <td > <div class="badge badge-danger badge-outlined"> IVA:</div> </td> 
                        <td ><div class="badge badge-primary badge-outlined"> {{$Coins->symbol}}{{number_format($InternalOrders->subtotal*0.16,2)}} </div></td>
                        <td > &nbsp;&nbsp;&nbsp;  </td>
                        <td>  &nbsp;&nbsp;&nbsp; </td>
                    
                    </tr><tr class="text-center">
                        <td> <div class="badge badge-danger badge-outlined"> Fecha:</div></td>
                        <td> <div class="badge badge-primary badge-outlined">{{$InternalOrders->reg_date}}</div>  </td>
                        <td > <div class="badge badge-danger badge-outlined"> Total:</div> </td> 
                        <td ><div class="badge badge-primary badge-outlined"> {{$Coins->symbol}}{{number_format($InternalOrders->total,2)}} </div></td>
                        <td > -&nbsp;&nbsp;&nbsp; - </td>
                        <td> - &nbsp;&nbsp;&nbsp; -</td>
                    
                    </tr>
                    </table>
                    <br><br>
                    <!-- espacio -->
                    <table>
                      
                  <tr>
                  <td rowspan="2"> <div class="badge badge-danger badge-outlined"> <br> <br> COBRO <br> <br> <br> <br> <br>  </div></td>
                  <td colspan="4"> <div class="badge badge-danger badge-outlined"> <br>  &nbsp;&nbsp;&nbsp;&nbsp; PROGRAMADO &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br>  </div></td>
                  <td rowspan="2"> <div class="badge badge-danger badge-outlined"> <br> FACTURA <BR> NUMERO <br> <br> </div></td>
                  <td rowspan="2"> <div class="badge badge-danger badge-outlined"> <br> FECHA <BR>(D-M-A) <br> <br></div></td>
                  <td rowspan="2"> <div class="badge badge-danger badge-outlined"> <br> IMPORTE <BR>FACTURA <br> <br></div></td>
                  <td colspan="5"> <div class="badge badge-danger badge-outlined"> COMP. INGRESOS</div></td>
                  <td rowspan="2"> <div class="badge badge-danger badge-outlined"> <br> TIPO <BR> DE <BR> CAMBIO <br> <br></div></td>
                  <td colspan="2"> <div class="badge badge-danger badge-outlined"> <br>  EQUIVALENETE EN M.N.</div></td>
                  <td colspan="3"> <div class="badge badge-danger badge-outlined"> <br> VERIFICACION DEL COBRO</div></td>
                  </tr>
                  <tr>
                    
                    <td> <div class="badge badge-danger badge-outlined"> <br> MONEDA <br> <br> <br></div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> FECHA <BR>(D-M-A) <br> <br></div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> IMPORTE <br> IVA INCLUIDO  <br><br></div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> % DEL <br> COBRO <br> PARCIAL  <br></div></td>
                    
                    <td> <div class="badge badge-danger badge-outlined"> <br> <br> NUMERO <br> <br></div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> FECHA <BR>(D-M-A)<br> <br></div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> <br> MONEDA <br> <br></div></td>
                    <td> <div class="badge badge-danger badge-outlined"><br> <br> IMPORTE <br> IVA INCLUIDO <br> </div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> <br> % DEL <br> COBRO <br> PARCIAL <br></div></td>
                    
                    <td> <div class="badge badge-danger badge-outlined"> <br> IMPORTE <br> ACUMULADO <br> </div></td>
                    <td> <div class="badge badge-danger badge-outlined"><br>  % DEL <br> COBRO <br> ACUMULADO<br> </div></td>
                    <td> <div class="badge badge-danger badge-outlined"> <br> CAPT <br> </div></td>
                    <td> <div class="badge badge-danger badge-outlined"><br>  G.A <br> </div></td>
                    <td> <div class="badge badge-danger badge-outlined"><br>  D.A <br></div></td>
                  
                  
                  </tr>
                  @php $porcentaje_acumulado=0;
                       $monto_acumulado=0; @endphp

                  @for($i=0;$i<$max;$i++)
                  <tr>
                      

                  @if($i<$hpagos->count())
                  <td><div class="badge badge-primary badge-outlined">{{$i+1}}</div></td>
                  <td><div class="badge badge-primary badge-outlined">{{$Coins->code}}</div></td>
                  <td><div class="badge badge-primary badge-outlined">{{$hpagos[$i]->date}}</div></td>
                  <td><div class="badge badge-primary badge-outlined">{{$Coins->symbol}} {{number_format($hpagos[$i]->amount,2)}}</div></td>
                  <td><div class="badge badge-primary badge-outlined">{{number_format($hpagos[$i]->percentage,2)}} %</div></td>
                  @else
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  
                  @endif
                  <!-- datos de las facturas -->
                    @if($i<$facturas->count())
                  <td><div class="badge badge-primary badge-outlined">{{$facturas[$i]->facture}} </div></td>
                  <td><div class="badge badge-primary badge-outlined">{{$facturas[$i]->date}} </div></td>
                  <td><div class="badge badge-primary badge-outlined">{{$Coins->symbol}} {{number_format($facturas[$i]->amount,2)}} </div></td>
                    @else
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                    
                    @endif
                    <!-- datos de cobros -->
                  @if($i<$cobros->count())
                  @php 
                       $monto_acumulado=$porcentaje_acumulado+$cobros[$i]->amount; 
                       $porcentaje_acumulado=100*$monto_acumulado/$InternalOrders->total;
                       @endphp
                  <td><div class="badge badge-primary badge-outlined">{{$cobros[$i]->comp}} </div></td>
                  <td><div class="badge badge-primary badge-outlined">{{$cobros[$i]->date}} </div></td>
                  <td><div class="badge badge-primary badge-outlined">{{$Coins->code}}</div></td>
                  <td><div class="badge badge-primary badge-outlined">{{$Coins->symbol}} {{number_format($cobros[$i]->amount,2)}} </div></td>
                  <td><div class="badge badge-primary badge-outlined">{{number_format($cobros[$i]->amount*100/$InternalOrders->total,2) }} %</div></td>
                  
                  <td><div class="badge badge-primary badge-outlined">{{$cobros[$i]->tc}} </div></td>
                  <td><div class="badge badge-primary badge-outlined"> {{$Coins->symbol}} {{number_format($cobros[$i]->tc*$monto_acumulado,2)}}</div></td>
                  
                  <td><div class="badge badge-primary badge-outlined">{{number_format($porcentaje_acumulado,2)}}  %</div></td>
                  
                  <td><div class="badge badge-primary badge-outlined">{{$cobros[$i]->capturista}}</div></td>
                  <td><div class="badge badge-primary badge-outlined">{{$cobros[$i]->revisor}}</div></td>
                  <td><div class="badge badge-primary badge-outlined">{{$cobros[$i]->autorizador}}</div></td>
                    @else
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                  <td><div class="badge badge-primary badge-outlined"> </div></td>
                    
                    @endif

                  </tr>
                  
                  @endfor
                  <tr>
                    <td> <br></td>
                  </tr>
                  <tr>
                  <td></td>
                  <td></td>
                  <td> <div style="font-size:15px"  class="badge badge-danger badge-outlined"> Totales</div></td>
                  <td> <div style="font-size:15px" class="badge badge-primary badge-outlined"> {{$Coins->symbol}} {{number_format($hpagos->sum('amount'),2)}}</div></td>
                  <td> <div style="font-size:15px" class="badge badge-primary badge-outlined"> {{$hpagos->sum('percentage')}} %</div></td>
                  
                  <td colspan="2"> <div style="font-size:15px"  class="badge badge-danger badge-outlined"> Facturado:</div></td>
                  <td colspan="2"> <div style="font-size:15px" class="badge badge-primary badge-outlined"> {{$Coins->symbol}} {{number_format($facturas->sum('amount'),2)}}</div></td>
                  
                  <td colspan="2"> <div style="font-size:15px"  class="badge badge-danger badge-outlined"> Total <br> Cobrado:</div></td>
                  <td colspan="2"> <div style="font-size:15px" class="badge badge-primary badge-outlined"> {{$Coins->symbol}} {{number_format($cobros->sum('amount'),2)}}</div></td>
                  
                </tr>

                  <tr>
                  <td></td>
                  <td></td>
                  <td> <div class="badge badge-danger badge-outlined"> Debe ser 0</div></td>
                  <td> <div class="badge badge-primary badge-outlined"> $ 0 </div></td>
                  <td> <div class="badge badge-primary badge-outlined">  0% </div></td>
                  <td colspan="4"></td>
                  
                  </tr><tr>


                  <td></td>
                  <td></td>
                  <td> <div class="badge badge-danger badge-outlined"> Validacion</div></td>
                  <td> <div class="badge badge-primary badge-outlined"> OK</div></td>
                  <td> <div class="badge badge-primary badge-outlined"> OK</div></td>
                 
                  <td colspan="2"> <div style="font-size:15px"  class="badge badge-danger badge-outlined"> Por facturar:</div></td>
                  <td colspan="2"> <div style="font-size:15px" class="badge badge-primary badge-outlined"> {{$Coins->symbol}} {{number_format($InternalOrders->total-$facturas->sum('amount'),2)}}</div></td>
                  <td colspan="2"> <div style="font-size:15px"  class="badge badge-danger badge-outlined"> Total por <br> Cobrar:</div></td>
                  <td colspan="2"> <div style="font-size:15px" class="badge badge-primary badge-outlined"> {{$Coins->symbol}} {{number_format($InternalOrders->total-$cobros->sum('amount'),2)}}</div></td>
                  
                  </tr>
                    </table>
                    <table>
                      <thead>
                        <tr style= width:100px;>
                        <th><div class="badge badge-danger badge-outlined"> Observaciones</div></th></tr>
                      </thead>
                      <tbody>
                        
                      </tr>
                        <tr style= width:60%;>
                        <td > <div class="badge badge-primary badge-outlined"><div class="com-text">{{$InternalOrders->observations}} </div></div></td>
                    
                        </tr>
                      </tbody>
                    </table>

                    </div>
      <div class="col"></div>
    </div>
</body>
</html>