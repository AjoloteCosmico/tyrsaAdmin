@extends('adminlte::page')

@section('title', 'REPORTE DGI')

@section('content_header')
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp;REPORTE DGI</h1>
@stop

@section('content')     <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm" >
                <table class=" table-responsive text-xs" style="border: none; border-collapse: collapse;">
                        <tr style="border: none; border-collapse: collapse;"><td style="border: none; border-collapse: collapse;"> &nbsp; &nbsp; &nbsp;</td>
                            <td style="border: none; border-collapse: collapse;">
                                <div class="contaier">
                        
                                                <img src="{{asset('img/logo/logo.svg')}}" alt="TYRSA"  style="align-self: left;"></td>
                                                </div></td>
                                 
                            <td rowspan="2" style="border: none; border-collapse: collapse;">
                        <br>
            Calle Cuernavaca S/N, Col. Ejido del Quemado,<br>
            C.P. 54,963, Tultepec, Edo. México,<b> R.F.C.</b>  <br> <br>
            TCO990507S91 Tels: (55) 26472033 / 26473330 <br>
 <div style="text-transform: lowercase;"> info@tyrsa.com.mx <b> <a href="https://www.tyrsa.com.mx"> www.tyrsa.com.mx</a> </b></div>     <br>

                        </td>
                        <td rowspan="2" style="border: none; border-collapse: collapse;">
                       
                            <table>
                                <tr>
                                    <th>Año</th>
                                    <td>{{$Year}}</td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                        
                            
                        <td  colspan="2"class="text-lg " style="color: red;  width:23%; border: none; border-collapse: collapse;">{{ $CompanyProfiles->company}}
                        </td>
                        <tr>
                                           
                        </tr >

                    </table>



            
            <h5 class="text-lg text-center text-bold">REPORTES DE DGI</h5>
            <br>
            <div >
                
                <!-- botones para switchear entre pestañas -->
                <div>
  <button id="btn-tabla" class="boton activo" onclick="mostrar('vendedores', this)">VENDEDORES</button>
  
  <button id="btn-tabla" class="boton activo" onclick="mostrar('comp_ing', this)">COMP. INGRESOS</button>
  <button id="btn-tabla" class="boton activo" onclick="mostrar('resumen', this)">RESUMEN (todos los comp.)</button>
  
  <button id="btn-tabla" class="boton activo" onclick="mostrar('resumen_ventas', this)">RESUMEN (ventas directas) </button>
  
  <button id="btn-tabla" class="boton activo" onclick="mostrar('resumen_ejecutivos', this)">RESUMEN(comisiones ejecutivos)</button>
  <button id="btn-graficos" class="boton" onclick="mostrar('graficos', this)">GRAFICOS</button>
</div>
                <div class="table-responsive contenedor" id="vendedores" style="display: block;">
                <table>
                    <tr>
                    <td>
                            <a href="{{route('reports.generate',[1,'dgi_vendedores',0])}}">
                                  <button class="button btn-lg"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="{{route('reports.generate',[1,'dgi_vendedores',1])}}">
                                  <button class="button btn-lg"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                    </tr>
                </table>
                        <!-- 14 columas, para poder copiar del excel -->
               <table class="table text-xs font-medium table-striped text.center"  id="example" >
               <thead> 
                <!-- 15 columnas -->
               <tr >
                
                    <th> No. vendedor</th>
                    <th>Iniciales</th>
                    <th width="23%">Vendedor</th>
                    <th>Estatus</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($Sellers as $seller)
                
                <tr @if($seller->status=='INACTIVO') style="color:red"  @endif>
                    <td>{{$seller->folio}}</td>
                    <td>{{$seller->iniciales}} </td>
                    <td>{{$seller->seller_name}} </td>
                    <td>{{$seller->status}} </td>
                    <td> </td>

                </tr>
                @endforeach
                </tbody>
               </table>
                     </div>
          <div class="contenedor" id="comp_ing">
          <table>
                    <tr>
                    <td>
                            <a href="{{route('reports.generate',[1,'dgi_comp',0])}}">
                                  <button class="button btn-lg"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                            </a>  
                            </td>
                            <td>
                            <a href="{{route('reports.generate',[1,'dgi_comp',1])}}">
                                  <button class="button btn-lg"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                    </tr>
                </table>
            @php
            $last_id=0;
            $ordinal=1;
            @endphp
                
            @foreach($Cobros as $comp)
            @php
                    if($last_id!=$comp->order_id){
                      $last_id=$comp->order_id;
                      $ordinal=1;
                    }else{
                      $ordinal=$ordinal+1;
                    }
                    $pedido=$Orders->where('id',$comp->order_id)->first();
                    $factura=$Facturas->where('id',$comp->facture_id)->first();
                    $total_cobrado=$Cobros->where('order_id',$comp->order_id)->sum('amount');
                    $pagos=$Pagos->where('order_id',$comp->order_id);
                    $banco=$Bancos->where('id',$comp->bank_id)->first();
                    $moneda=$Monedas->where('id',$comp->coin_id)->first();
                    $comisiones=$Comisiones->where('order_id',$comp->order_id);
                    @endphp
             <div class="col">
                <div class="row mydiv">
                   <div class="col mydiv">
                    <table class="table-bordered">
                        <tr>
                            <th>Comprobante de Ingresos no.</th>
                            <td>{{$comp->comp}} </td>
                        </tr>
                        
                        <tr>
                            <th>NOHA C.I.</th>
                            <td>{{$comp->noha}} </td>
                        </tr>
                        
                        <tr>
                            <th>FECHA</th>
                            <td> {{$comp->date}} </td>
                        </tr>
                    </table>
                   </div>
                   <div class="col mydiv">
                        <table class="table-bordered">
                            <tr>
                                <th>CLIENTE</th>
                                <td>{{$comp->alias}} </td>
                                <th>Tipo de cambio</th>
                                <td>{{$comp->tc}}</td>
                            </tr>
                            
                            <tr>
                                <th>BANCO</th>
                                <td>{{$banco->bank_description}} </td>
                                <th>FACTOR IVA</th>
                                <td>1.16</td>
                            </tr>
                            
                            <tr>
                                <th>MONEDA</th>
                                <td>{{$moneda->coin}}</td>
                            </tr>
                        </table>
                   </div>
                   <br>
                </div>
                
                <div class="row">
                    <div class="col table-responsive">
                    <table class="table-bordered">
                        <thead>
                          <tr>
                            <th rowspan="2">PDA</th>
                            <th rowspan="2">P.I NO.</th>
                            <th rowspan="2">FACTURA NO. &nbsp; &nbsp;</th>
                            <th colspan="2"> &nbsp; &nbsp;IMPORTE TOTAL <br> DEL COBRO &nbsp;</th>
                            <th rowspan="2">VENDEDOR</th>
                            <th colspan="2">COMISION</th>
                            <th colspan="2"> &nbsp; &nbsp; IMPORTE TOTAL<br> DEL PEDIDO &nbsp;</th>
                            <th colspan="2">IMPORTE PAGADO <br>POR EL CLIENTE A LA FECHA</th>
                            <th rowspan="2">% DE LA COMISION <br>QUE SE DEBE SOBRE<br> AVANCE</th>
                            <th rowspan="2">COMISION A <br> PAGAR M.N.</th>
                            <th rowspan="2">VALIDAR <br> DEBE SER 0</th>
                            <th rowspan="2">ESTATUS</th>
                          </tr>
                          <tr>
                            <th style="color:#36B500" > DLLS </th>
                            <th>M.N.</th>
                            <th>% NEGOCIADA</th>
                            <th>PAGAR M.N.</th>
                           
                            <th style="color:#36B500" > DLLS </th>
                            <th>M.N.</th>
                           
                            <th>%</th>
                            <th>M.N.</th>
                           
                          </tr>
                        </thead>
                        <tr>
                            <td>{{$loop->index}}</td>
                            <td>{{$pedido->invoice}}</td>
                            <td> @if($factura){{$factura->facture}} @else sin factura @endif</td>
                            <td style="color:#36B500">$0 </td>
                            <td>$ {{number_format($comp->amount,2)}}</td>
                            <td>{{$pedido->seller_name}}</td>
                            <td>{{number_format($pedido->comision*100,2)}} %</td>
                            <td> ${{number_format($pedido->comision*$pedido->total,2)}} </td>
                            
                            <td style="color:#36B500" > $0</td>
                            <td> ${{number_format($pedido->total,2)}} </td>
                            <td> {{number_format($total_cobrado*100/$pedido->total,2)}} %</td>
                            <td> ${{number_format($total_cobrado,2)}}</td>
                            <td> {{number_format($comp->amount*100/$pedido->total,2)}} %</td>
                            <td> ${{number_format(($comp->amount*100/$pedido->total)*$pedido->comision*$pedido->total,2)}} </td>
                            <td>0</td>
                            <td>@if($pagos->count() >= $ordinal)
                              {{$pagos->skip($ordinal-1)->first()->concept}}@endif </td>
                        </tr>
                        
                      </table>
                    </div>
                </div>
                
                  <div class="row">
                    <div class="col"><br> <hr> <br> CAPTURÓ </div>
                    <div class="col"><br> <hr> <br> REVISÓ</div>
                    <div class="col"><br> <hr> <br> AUTORIZÓ</div>
                    <div class="col">
                  <table> 
                    <tr><th>Observaciones</th></tr>
                    <tr><td> &nbsp; ------------------- <br> ----------------------</td></tr>
                  </table></div>
                  </div>
                 
                  <div class="row"> 
                    <div class="col table-responsive"> <table>
                      <tr>
                        <th >Sin Iva</th>
                           <td>&nbsp;&nbsp; </td>
                            <td>&nbsp;&nbsp; </td>
                            <td style="color:#36B500">$0 </td>
                            <th>$ {{number_format($comp->amount/1.16,2)}}</th>
                            <td>&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;</td>
                            <th> ${{number_format(($pedido->comision*$pedido->total)/1.16,2)}} </th>
                            
                            <td style="color:#36B500" > $0</td>
                            <th> ${{number_format($pedido->total/1.16,2)}} </th>
                            <td>  &nbsp;&nbsp;</td>
                            <th> ${{number_format($total_cobrado/1.16,2)}}</th>
                            <td> &nbsp;&nbsp;</td>
                            <th> ${{number_format((($comp->amount*100/$pedido->total)*$pedido->comision*$pedido->total)/1.16,2)}} </td>
                            <td>&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;</td>
                      </tr>
                    </table></div>
                  </div>
                  <!-- ultimas tablas inferiores (comisiones socios y vendedores) -->
                  <div class='row mydiv'>
                    <!-- tabla de vendedores -->
                    <div class="col mydiv">
                      <div class="row"> <h2>VENDEDORES ACTIVOS / DISPERSION DE COMISIONES SIN IVA</h2> <p>$ {{number_format(($comisiones->where('seller_dgi',0)->sum('percentage')*$comp->amount)/1.16,2)}}</p> </div>
                       <div class="row mydiv">
                          <table>
                            <thead>
                              <tr>
                                <th rowspan="2">Vendedor</th>
                                
                                <th colspan="2">Comision</th>
                              </tr>
                              <tr>
                                <th> porcentaje </th>
                                <th> M.N. sin iva</th>
                              </tr>
                              @foreach($comisiones as $comision)
                              
                              @if($comision->seller_dgi==0)
                              <tr>
                                <td>{{$comision->seller_name}} </td>
                                <td>{{number_format($comision->percentage*100,2)}} %</td>
                                <td>${{number_format(($comision->percentage*$comp->amount)/1.16,2)}}</td>
                              </tr>
                              @endif
                              @endforeach
                            </thead>
                          </table>
                       </div>
                    </div>
                    <!-- tabla de Socios -->
                    <div class="col mydiv">
                      <div class="row"> <h2>EJECUTIVOS ACTIVOS / DISPERSION DE COMISIONES SIN IVA</h2> <p>$ {{number_format(($comisiones->where('seller_dgi','>',0)->sum('percentage')*$comp->amount)/1.16,2)}}</p> </div>
                       <div class="row mydiv">
                          <table>
                            <thead>
                              <tr>
                                <th rowspan="2">Ejecutivo</th>
                                
                                <th colspan="2">Comision</th>
                              </tr>
                              <tr>
                                <th> porcentaje  </th>
                                <th> M.N. sin iva</th>
                              </tr>
                              @foreach($comisiones as $comision)
                              
                              @if($comision->seller_dgi>0)
                              <tr>
                                <td>{{$comision->seller_name}} </td>
                                <td>{{number_format($comision->percentage*100,2)}} %</td>
                                <td>${{number_format(($comision->percentage*$comp->amount)/1.16,2)}}</td>
                              </tr>
                              @endif
                              @endforeach
                            </thead>
                          </table>
                       </div>
                    </div>


                  </div>
             </div>
                    <br><br> <br><br>
@endforeach  
          </div>
                  

                  
          <div class="table-responsive contenedor" id="resumen">
             <div class="container px-4 mx-auto">
             <table>
                    <tr>
                    <td>
                            <a href="{{route('reports.generate',[1,'dgi_resumen',0])}}">
                                  <button class="button btn-lg"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="{{route('reports.generate',[1,'dgi_resumen',1])}}">
                                  <button class="button btn-lg"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                    </tr>
                </table>
                <table class="table text-xs font-medium table-striped text-center"  id="example2" >
                <thead>
                  <tr>
                    <th rowspan="2">PDA</th>
                    <th rowspan="2">FECHA</th>
                    <th rowspan="2">CLIENTE NOMBRE CORTO</th>
                    <th rowspan="2"> COMPROBANTE DE INGRESOS no.</th>
                    <th rowspan="2">IMPORTE  COBRADO <br> sin iva</th>
                    <th rowspan="2">VENDEDOR </th>
                    <th rowspan="2">PEDIDO INTERNO</th>
                    <th colspan="3">IMPORTE TOTAL DEL PEDIDO SIN IVA</th>
                    <th colspan="2">IMPORTE TOTAL PAGADO POR EL CLIENTE A LA FECHA</th>
                    <th rowspan="2">% DE LA COMISION QUE SE DEBE</th>
                    <th rowspan="2">% DE LA COMISION NEGOCIADA</th>
                    <th rowspan="2">% DE LA COMISION POR PAGAR SIN IVA</th>
                    <th rowspan="2">ESTATUS</th>
                  </tr>
                  <tr>
                    <th>USD</th>
                    <th>TIPO DE CAMBIO</th>
                    <th>M.N.</th>
                    <th>%</th>
                    <th>M.N.</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($Cobros as $comp)
                  <tr>
                    @php
                    $pedido=$Orders->where('id',$comp->order_id)->first();
                    $total_cobrado=$Cobros->where('order_id',$comp->order_id)->sum('amount');
                  
                    @endphp
                    <td>{{$loop->index}} </td>
                    <td>{{$comp->date}} </td>
                    <td>{{$comp->alias}} </td>
                    <td>{{$comp->comp}}</td>
                    <td>$ {{number_format($comp->amount /1.16,2)}}</td>
                    <td>{{$pedido->seller_name}} </td>
                    <td>{{$pedido->invoice}} </td>
                    <td>$ 0 </td>
                    <td>$ 1 </td>
                    <td>$ {{number_format($pedido->total/1.16,2)}} </td>
                    <td>{{number_format($total_cobrado*100/$pedido->total,2)}} %</td>
                    <td>{{number_format($total_cobrado/1.16,2)}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  @endforeach
                </tbody>
                </table>
          
            </div>
          </div>   
          <div class="table-responsive contenedor" id="resumen_ventas" style="display: block;">
          
            @include('reportes.dgi_resumen_ventas')
          </div>                       
                
          <div class="table-responsive contenedor" id="resumen_ejecutivos" style="display: block;">
          
            @include('reportes.dgi_resumen_ejecutivos')
          </div>

          <div class="contenedor" id="graficos">
             <div class="container px-4 mx-auto">

            </div>
          </div>    
        </div>
    </div>
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
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.min.css">

<style>
 th { white-space: nowrap; }
  /* Estilos de los botones */
  .boton {
    padding: 10px 20px;
    border: 1px solid #ccc;
    background-color: #e0e0e0;
    color: #333;
    cursor: pointer;
    border-radius: 5px 5px 0 0;
    outline: none;
    margin: 0; /* Sin espacio entre los botones */
  }

  .boton.activo {
    background-color: #007bff;
    color: white;
    border-bottom: 1px solid white; /* Para que parezca unido al contenedor */
  }

  .boton:hover {
    background-color: #ccc;
  }

  /* Contenedores */
  .contenedor {
    display: none; /* Ocultar inicialmente */
    border: 1px solid #ccc;
    padding: 20px;
    margin-top: -1px; /* Para unir con el botón */
    border-radius: 0 5px 5px 5px; /* Redondeo sólo en la parte inferior */
  }

  .mydiv{
    padding:1.3vh;
  }

</style>
@stop

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
<script>
  new DataTable('#example');
</script>
<script>
  new DataTable('#example2');
</script>
<script>
  new DataTable('#example4');
</script>
<script>
  function mostrar(id, boton) {
    // Ocultar todos los contenedores
    document.querySelectorAll('.contenedor').forEach(div => {
      div.style.display = 'none';
    });

    // Mostrar el contenedor seleccionado
    document.getElementById(id).style.display = 'block';

    // Cambiar estado de los botones
    document.querySelectorAll('.boton').forEach(btn => {
      btn.classList.remove('activo');
    });
    boton.classList.add('activo');
  }
</script>

@endpush