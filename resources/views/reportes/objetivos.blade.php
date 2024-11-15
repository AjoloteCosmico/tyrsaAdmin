@extends('adminlte::page')

@section('title', 'PEDIDOS INTERNOS')

@section('content_header')
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp; PEDIDO INTERNO</h1>
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



            
            <h5 class="text-lg text-center text-bold">OBJETIVOS Y RESULTADOS</h5>
            <br>
            <div >
                <table>
                    <tr>
                    <td>
                            <a href="{{route('reports.generate',[1,'objetivos',0])}}">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="{{route('reports.generate',[1,'objetivos',1])}}">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                    </tr>
                </table>
                        <!-- 14 columas, para poder copiar del excel -->
               <table class="table text-xs font-medium table-striped " >
               <thead> 
               <tr class="text-center">
                    <th>Vendedor</th>
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
                    <th width="6%">% </th>
                </tr>
                </thead>
                @foreach($Sellers as $seller)
                <tr>
                    <td>{{$seller->seller_name}}</td>
                    @for($i=1;$i<=12;$i++)
                                          
                    <td>{{$InternalOrders->where('seller_id',$seller->id)->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->count()}}  </td>
                        
                    @endfor
                    <td>{{$InternalOrders->where('seller_id',$seller->id)->count()}}</td>
                    
                    <td>{{number_format(100*$InternalOrders->where('seller_id',$seller->id)->count()/$InternalOrders->count(),1)}} %</td>
                </tr>
                @endforeach
                <tfoot>
                <tr>
                    <th>TOTAL MENSUAL</th>
                    @for($i=1;$i<=12;$i++)
                                          
                    <th>{{$InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->count()}}  </th>
                    
                    @endfor
                    <th>{{$InternalOrders->count()}} </th>
                    <th>100% </th>
                </tr>
                <tr>
                    <td></td>
                    @for($i=1;$i<=12;$i++)
                    <td>{{number_format(100*$InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')->count()/$InternalOrders->count(),1)}} %</td>
               
                    @endfor
                    <td></td>
                    <td></td>
                </tr>
                </tfoot>
               </table>
                     

                  

                  
                   
                                    

                                    
                    
  
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
    new DataTable('#table',{
    
      buttons: ['copy','excel']
        
    
    });
</script>
@endpush