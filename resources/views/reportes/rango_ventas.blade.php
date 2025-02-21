@extends('adminlte::page')

@section('title', 'REPORTE RANGO DE VENTAS POR CLIENTE')

@section('content_header')
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp; REPORTE DE RANGO DE VENTAS POR CLIENTES</h1>
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
                        <!-- Domicilio Fiscal:
                                {{$CompanyProfiles->street.' '.$CompanyProfiles->outdoor.' '}}
                                {{$CompanyProfiles->intdoor.' '.$CompanyProfiles->suburb}}
                                <br>{{$CompanyProfiles->city.' '.$CompanyProfiles->state.' '.$CompanyProfiles->zip_code}}<br>
                                R.F.C: {{$CompanyProfiles->rfc}} &nbsp; Tels: 01-52 {{$CompanyProfiles->telephone.', '.$CompanyProfiles->telephone2}} <br> E-mail: {{$CompanyProfiles->email}} &nbsp; Web: {{$CompanyProfiles->website}}
                             -->
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



            
            <h5 class="text-lg text-center text-bold">RANGO DE VENTAS POR CLIENTE </h5>
            <br>
            <div >
                <table>
                    <tr>
                    <td>
                            <a href="{{route('reports.generate',[1,'rango_ventas',0])}}">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="{{route('reports.generate',[1,'rango_ventas',1])}}">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                    </tr>
                </table>
                <!-- botones para switchear entre pestañas -->
                <div>
  <button id="btn-tabla" class="boton activo" onclick="mostrar('tabla', this)">Tabla</button>
  <button id="btn-graficos" class="boton" onclick="mostrar('graficos', this)">Gráficos</button>
</div>
                <div class="table-responsive contenedor" id="tabla" style="display: block;">
             
                @foreach($Rangos as $rango)
                @php 
                  $TargetClientes=$Clientes->where('total','>=',$rango[0]*1000)->where('total','<=',$rango[1]*1000);
                  @endphp
                  @if($TargetClientes->count()>0)      
               <table class="table text-xs font-medium table-striped " >
               <thead> 
                <!-- 4 columnas -->
               <tr class="text-center">
                <th  colspan="4">
                DE {{$rango[0]}} A {{$rango[1]}}</th>
               </tr>
               <tr>
                <th>No.</th>
                <th>Cliente</th>
                <th>PI</th>                
                <th>Total</th>
               </tr>
                </thead>
                <tbody>
                @foreach($TargetClientes as $cliente)
                  
                <tr>
                  <td>{{$cliente->clave}}</td>
                  <td>{{$cliente->customer}} </td>
                  <td>{{$cliente->pi}} </td>
                  <td> $ {{number_format($cliente->total/1.16,2)}} </td>
                </tr>
                  @endforeach
                </tbody>

                <tfoot>
                  <tr>
                    <th colspan="3">
                      Total
                    </th>
                    <th> $ {{number_format($TargetClientes->sum('total')/1.16,2 )}}</th>
                  </tr>
                </tfoot>
               
               </table>
               @endif
               @endforeach

               <br>
               <table>
                <tr>
                  <td>
                  <table>
                <thead>
                  <tr>
                    <th>Cantidad</th>
                    <th>Rango</th>
                    <th>$</th>
                    <th>%En PI</th>
                    <th>% en $</th>

                  </tr>
                </thead>
               <tbody>
               @foreach($Rangos as $rango)
                @php 
                  $TargetClientes=$Clientes->where('total','>=',$rango[0]*1000)->where('total','<=',$rango[1]*1000);
                @endphp
                @if($TargetClientes->count()>0)    
                <tr>  
                  <td>{{$TargetClientes->sum('pi')}}</td>
                  <td>DE {{$rango[0]}} A {{$rango[1]}}</td>
                  <td>$ {{number_format($TargetClientes->sum('total')/1.16,2 )}}</td>
                  <td>{{number_format($TargetClientes->sum('pi')*100/$Clientes->sum('pi'),2)}} %</td>
                  <td>{{number_format($TargetClientes->sum('total')*100/$Clientes->sum('total'),2)}} %</td>
                  </tr>
                  @endif
               @endforeach
               </tbody>
               </table>
                  </td>
                  <td>
                    <table>
                      <tr>
                        <th>Suma de Pedidos al año</th>
                        <td> {{$Clientes->sum('pi')}}</td>
                      </tr>
                      
                      <tr>
                        <th>Ventas en moneda nacional</th>
                        <td>$ {{number_format($Clientes->sum('total')/1.16,2) }}</td>
                      </tr>
                    </table>
                  </td>
                </tr>
               </table>
              
                     </div>
          <div class="contenedor" id="graficos">
          <div class="container px-4 mx-auto">
          <div class="p-6 m-20 bg-white rounded shadow">
                {!! $RangosChart->container() !!}
            </div>
            
            <div class="p-6 m-20 bg-white rounded shadow">
              
            {!! $RangosPie->container() !!}
            </div>
            <div class="p-6 m-20 bg-white rounded shadow">
              
              {!! $RangosPieMonto->container() !!}
              </div>
            
            <div class="p-6 m-20 bg-white rounded shadow">
                
            </div>

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


<script src="{{ $RangosChart->cdn() }}"></script>

{{ $RangosChart->script() }}

<script src="{{ $RangosPieMonto->cdn() }}"></script>

{{ $RangosPie->script() }}
<script src="{{ $RangosPieMonto->cdn() }}"></script>

{{ $RangosPieMonto->script() }}

@endpush