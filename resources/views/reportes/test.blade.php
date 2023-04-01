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
    .demo-preview {
  padding-top: 10px;
  padding-bottom: 10px;
  margin: auto;
  text-align: center;
}
.demo-preview .badge{
  margin-right:10px;
}
.badge {
  display: stretch;
  font-size: small;
  font-weight: 600;
  /* padding: 3px 6px; */
  border:3px solid transparent;
  /* min-width: 10px; */
  /* line-height: 1; */
  color: #fff;
  /* text-align: center;*/
  white-space: nowrap; 
  /* vertical-align: middle; */
  border-radius: 4px;
  /* padding: 15px; */
  /* width: 100%;
  height: 100%; */
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

    <h1> Reporte de Pedido interno: {{$InternalOrders->Invoice }}</h1>
    <p></p>
    <table>
                        <tr><td> &nbsp; &nbsp; &nbsp;</td>
                            <td >
                                <div class="contaier">
                        
                                                <img src="{{asset('img/logo/logo.svg')}}" alt="TYRSA"  style="align-self: left;"></td>
                                                </div></td>
                                 
                            <td rowspan="2">
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
                    <h5 class="text-lg text-center text-bold">PEDIDO INTERNO</h5>
            <br>
                    <table>
                    <th colspan="7">Datos del Cliente</th>
                     </tr>
                    <tr class="text-center">
                        <td>
                        <div class="badge badge-danger badge-outlined"> Numero de cliente:</div></td>
                        <td>
                        <div class="badge badge-primary badge-outlined">{{$Customers->clave}}</div>  </td>
                        <td > <div class="badge badge-danger badge-outlined"> Nombre corto:</div> </td> 
                        <td colspan="2"><div class="badge badge-primary badge-outlined">{{$Customers->alias}} </div></td>
                        <td ><div class="badge badge-danger badge-outlined"> CP:</div> </td>
                        <td> <div class="badge badge-primary badge-outlined">{{$Customers->customer_zip_code}}</div></td>
                    <!-- 6 columas -->
                    </tr>
                  
                    <tr class="text-center">
                        <td><div class="badge badge-danger badge-outlined">  Razon Social: </div></td>
                        <td colspan="6" ><div class="badge badge-primary badge-outlined"> {{$Customers->legal_name}}</div></td>
                        
                        <!-- 6 columas -->
                    </tr>
                    <tr class="text-center">
                        <td><div class="badge badge-danger badge-outlined"> RFC: </div> </td>
                        <td><div class="badge badge-primary badge-outlined"> {{$Customers->customer_rfc}} <div></div> </td>
                        
                        <td><div class="badge badge-danger badge-outlined"> OC: </div></td>
                        <td><div class="badge badge-primary badge-outlined"> @if($InternalOrders->oc==0) - @else
                                                                              {{$InternalOrders->oc}} @endif</div></td>
                        <td> <div class="badge badge-danger badge-outlined">Contrato No.: </div></td>
                        <td colspan="2"> <div class="badge badge-primary badge-outlined" >@if($InternalOrders->ncontrato==0) - @else
                                                                              {{$InternalOrders->ncontrato}} @endif </div></td>
                        <!-- 6 columas -->
                         </tr>
                         
                         <tr class="text-center">
                        <td rowspan="3"><div class="badge badge-danger badge-outlined" ><br> <br> <br> <br>  Domicilio Fiscal:  <br><br><br><br> <br></div></td>
                        <td colspan="6"><div class="badge badge-primary badge-outlined"> {{$Customers->customer_street.' '.$Customers->customer_outdoor.' '.$Customers->customer_intdoor.' '.$Customers->customer_suburb}} <br> {{$Customers->customer_city.' '.$Customers->customer_state.' '.$Customers->customer_zip_code}}<br>
                                                                </td>
                         </tr>
                         <tr>
                            <td></td>
                            <td></td>
                            
                            <td></td>
                            <td  colspan = "3"> <div class="badge badge-danger badge-outlined">
                            Fechas </div></td>

                         </tr>
                          
                    <tr class="text-center">
                        <td></td>
                        <td> <div class="badge badge-danger badge-outlined">Tel:</div></td>
                        <td> <div class="badge badge-primary badge-outlined">{{$Customers->customer_telephone}}</div></td>
                        
                        
                        <td><div class="badge badge-danger badge-outlined">Semanas </div></td>
                        <td><div class="badge badge-danger badge-outlined">Evento </div> </td>
                        <td><div class="badge badge-danger badge-outlined">DD-MM-AAAA </div></td>
                    </tr >
                    <tr class="text-center">
                        <td rowspan="3"><div class="badge badge-danger badge-outlined" ><br><br> <br> Embarque: <br><br> <br> &nbsp;</div> </td>
                        <td rowspan="3"> <div class="badge badge-primary badge-outlined">
                        <br><br> <br>
                        @if($InternalOrders->shipment == 'Sí')
                            Si
                            @else
                            No
                            @endif
                            <br><br><br> &nbsp;
                              </div></td>
                              @php
{{$del = new DateTime($InternalOrders->date_delivery);
  $primerdia = new DateTime("2023-1-1");
  $semanasdel = (int) ($del->diff($primerdia)->format('%a')/7);
  $inst = new DateTime($InternalOrders->instalation_date);
  
  $semanasinst = (int) ($inst->diff($primerdia)->format('%a')/7);
  $reg = new DateTime($InternalOrders->reg_date);

  $semanasreg = (int)( $reg->diff($primerdia)->format('%a')/7);}}
@endphp
                        <td><div class="badge badge-danger badge-outlined">Domicilio Embarque: </div></td>
                        <td></td>
                        <td><div class="badge badge-primary badge-outlined">{{$semanasreg}}  </div></td>
                        <td> <div class="badge badge-primary badge-outlined">Emision PI </div></td>
                        <td> <div class="badge badge-primary badge-outlined">{{date('j - m - Y', strtotime($InternalOrders->reg_date))}} </div></td>
                    </tr>
           
                    
                    <tr class="text-center">
                        
                        <td colspan="2"> <div class="badge badge-primary badge-outlined">{{$CustomerShippingAddresses->customer_shipping_city.' '.$CustomerShippingAddresses->customer_shipping_suburb}} <br> {{$CustomerShippingAddresses->customer_shipping_street.' '.$CustomerShippingAddresses->customer_shipping_indoor}} </div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$semanasdel}} <br> &nbsp; </div></td>
                        
                        <td><div class="badge badge-primary badge-outlined">Entrega <br> Equipo </div></td>
                        <td><div class="badge badge-primary badge-outlined">{{date('j - m - Y', strtotime($InternalOrders->date_delivery))}}   <br> &nbsp;</div></td>
                    </tr>
                    
                    <tr class="text-center">
                        
                        <td><div class="badge badge-danger badge-outlined">CP: </div></td>
                        <td><div class="badge badge-primary badge-outlined">{{$CustomerShippingAddresses->customer_shipping_zip_code}} </div></td>
                    
                        <td><div class="badge badge-primary badge-outlined">{{$semanasinst}} </div></td>
                        <td><div class="badge badge-primary badge-outlined">Instalacion </div></td>
                        <td><div class="badge badge-primary badge-outlined">{{date('j - m - Y', strtotime($InternalOrders->instalation_date))}} </div></td>
                    </tr>
                    </table>
</body>
</html>