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
                        <!-- 14 columas, para poder copiar del excel -->
               <table>
                <tr>
                    <th>Vendedor</th>
                    <th>Enero</th>
                    <th>Febrero</th>
                    <th>Marzo</th>
                    <th>Mayo</th>
                    <th>Abril</th>
                    <th>Junio</th>
                    <th>Julio</th>
                    <th>Agosto</th>
                    <th>Septiembre</th>
                    <th>Octubre</th>
                    <th>Noviembre</th>
                    <th>Diciembre</th>
                    <th>Total</th>
                    <th>%</th>
                </tr>
                @foreach($Sellers as $seller)
                <tr>
                    <td>{{$seller->seller_name}}</td>
                    @for($i=1;$i<=12;$i++)
                                          
                    <td>{{$InternalOrders->where('seller_id',$seller->id)->where('date','>=',$Year.'-'.$i.'-01')->where('date','<=',$Year.'-'.$i.'-31')->count()}} </td>
                        
                    @endfor
                    <td>{{$InternalOrders->where('seller_id',$seller->id)->count()}}</td>
                    
                    <td>{{number_format(100*$InternalOrders->where('seller_id',$seller->id)->count()/$InternalOrders->count(),1)}} %</td>
                </tr>
                @endforeach
               </table>
                     

                  

                  
                   
                                    

                                    
                    
  
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