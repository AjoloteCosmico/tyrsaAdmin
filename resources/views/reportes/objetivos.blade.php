@extends('adminlte::page')

@section('title', 'PEDIDOS INTERNOS')

@section('content_header')
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp; REPORTE DE OBJETIVOS</h1>
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



            
            <h5 class="text-lg text-center text-bold">OBJETIVOS Y RESULTADOS POR {{$Monto}} </h5>
            <br>
            <div >
                <table>
                    <tr>
                    <td>
                            <a href="{{route('reports.generate',[1,'objetivos_por_'.strtolower($Monto),0])}}">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="{{route('reports.generate',[1,'objetivos_por_'.strtolower($Monto),1])}}">
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
             
                        <!-- 14 columas, para poder copiar del excel -->
               <table class="table text-xs font-medium table-striped "  id="example" >
               <thead> 
                <!-- 15 columnas -->
               <tr class="text-center">
                    <th width="18%">Vendedor</th>
                    <th>Enero</th>
                    <th>Febrero</th>
                    <th>Marzo</th>
                    <th>Mayo </th>
                    <th>Abril</th>
                    <th>Junio</th>
                    <th>Julio</th>
                    <th>Agosto</th>
                    <th>Septiembre</th>
                    <th>Octubre</th>
                    <th>Noviembre</th>
                    <th>Diciembre</th>
                    <th>Total</th>
                    <th width="8%"> &nbsp;% &nbsp; &nbsp;</th>
                </tr>
                </thead>
                @foreach($Sellers as $seller)
                <tr>
                    <td>{{$seller->seller_name}}</td>
                    @for($i=1;$i<=12;$i++)
                      @if($Monto=='MONTO')                    
                        <td class="text-nowrap" > $ {{number_format($InternalOrders->where('seller_id',$seller->id)->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->sum('total'),2)}}  </td>
                        @else
                        <td>{{$InternalOrders->where('seller_id',$seller->id)->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->count()}}  </td>
                        
                        @endif
                    @endfor
                    @if($Monto=='MONTO')  
                      <td class="text-nowrap" > $ {{number_format($InternalOrders->where('seller_id',$seller->id)->sum('total'),2)}}</td>
                      <td class="text-nowrap" >{{number_format(100*$InternalOrders->where('seller_id',$seller->id)->sum('total')/$InternalOrders->sum('total'),1)}} %</td>
                    @else
                    
                    <td class="text-nowrap" >{{$InternalOrders->where('seller_id',$seller->id)->count()}}</td>
                      <td class="text-nowrap" > {{number_format(100*$InternalOrders->where('seller_id',$seller->id)->count()/$InternalOrders->count(),1)}} %</td>
                    @endif
                </tr>
                @endforeach
                <tfoot>

                <tr>
                    <th>TOTAL MENSUAL</th>
                    @for($i=1;$i<=12;$i++)
                                  
                      @if($Monto=='MONTO')  
                        <th> $ {{number_format($InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->sum('total'),2)}}  </th>
                    
                      @else
                        <th>{{$InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->count()}}  </th>
                    
                      @endif
                    @endfor
                      @if($Monto=='MONTO')  
                      <th> $ {{number_format($InternalOrders->sum('total'),2)}} </th>
                      @else
                      <th>{{$InternalOrders->count()}} </th>
                      @endif
                    
                    <th>100% </th>
                </tr>
                <tr>
                    <td></td>
                    @for($i=1;$i<=12;$i++)
                      @if($Monto=='MONTO')  
                      <td>{{number_format(100*$InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->sum('total')/$InternalOrders->sum('total'),1)}} %</td>
               
                      @else
                      <td>{{number_format(100*$InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->count()/$InternalOrders->count(),1)}} %</td>
               
                      @endif
                    
                    @endfor
                    <td></td>
                    <td></td>
                </tr>
                </tfoot>
               </table>
                     </div>
          <div class="contenedor" id="graficos">
          <div class="container px-4 mx-auto">

            <div class="p-6 m-20 bg-white rounded shadow">
                {!! $SellerChart->container() !!}
            </div>
            
            <div class="p-6 m-20 bg-white rounded shadow">
                {!! $MesesChart->container() !!}
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

<script src="{{ $SellerChart->cdn() }}"></script>

{{ $SellerChart->script() }}

<script src="{{ $MesesChart->cdn() }}"></script>

{{ $MesesChart->script() }}
@endpush