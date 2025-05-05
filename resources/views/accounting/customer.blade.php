@extends('adminlte::page')

@section('title', 'PEDIDOS INTERNOS')

@section('content_header')
    <h1 class="font-bold"> <i class="fas fa-clipboard-check"></i>&nbsp; PEDIDO INTERNO</h1>
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
                        </tr>
                        <tr>
                            <td class="text-lg" style="color: red">{{ $CompanyProfiles->company}}</td>
                        </tr>
                        <tr>
                            <td>{{ $CompanyProfiles->motto}}</td>
                        </tr>
                        <tr class="text-xs">
                            <td>
                                <br>
                                Domicilio Fiscal:<br>
                                {{$CompanyProfiles->street.' '.$CompanyProfiles->outdoor.' '.$CompanyProfiles->intdoor.' '.$CompanyProfiles->suburb.' '.$CompanyProfiles->city.' '.$CompanyProfiles->state.' '.$CompanyProfiles->zip_code}}<br>
                                R.F.C: {{$CompanyProfiles->rfc}} &nbsp; Tels: 01-52 {{$CompanyProfiles->telephone.', '.$CompanyProfiles->telephone2}} &nbsp; E-mail: {{$CompanyProfiles->email}} &nbsp; Web: {{$CompanyProfiles->website}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="row p-4">
                <div class="col-sm-9 col-xs-12 font-bold text-sm">
                    <table>
                        <tr>
                            <td>
                                Cliente: {{$Customers->clave.' '. $Customers->customer}}<br>
                                Dirección Fiscal: {{$Customers->customer_street.' '.$Customers->customer_outdoor.' '.$Customers->customer_intdoor.' '.$Customers->customer_suburb.' '.$Customers->customer_city.' '.$Customers->customer_state.' '.$Customers->customer_zip_code}}<br>
                                R.F.C: {{$Customers->customer_rfc}} &nbsp; Tel: 01-52 {{$Customers->customer_telephone}} &nbsp; E-mail: {{$Customers->customer_email}} &nbsp; Web: {{$Customers->customer_website}}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-3 col-xs-12 font-bold text-sm">
                    <table>
                        <tr>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="row p-4">
                <div class="col-sm-12 font-bold text-sm">
                        

                <table >
        <tbody>
          <tr>
            <td>
            Total de Pedidos &nbsp;
            </td>
            <td>
            Abonos pagados&nbsp;
            </td>
            <td>
            Porcentaje completado&nbsp;
            </td>
            <td>
            Saldo deudor&nbsp;
            </td>
          </tr>
          <tr>
          @if($pagos->sum('amount') > 0)
            <td>
             {{$pagos->count()}}
            </td>
            <td>
            {{$pagados->count() }} / {{ $pagos->count()}}
            </td>
            <td>
                
              {{round(  100*($pagados->sum('amount'))/($pagos->sum('amount'))  )}} %
             
            </td>
            <td style="color : red ">
            
             {{$pagos->first()->symbol}} {{number_format($noPagados->sum('amount'))}}
            
            </td>
            @endif
          </tr>
        </tbody>
      </table>

<br><br><br>

<form action="{{route('payments.multi_pay_actualize')}}" method="POST" enctype="multipart/form-data" id="form1">
@csrf
        <table class="table-striped text-xs font-medium" >
            <thead class="thead">
               <tr style = "font-size : 14px ; padding : 15px">
               <th > Pedido</th>
               <th scope="col">concepto <br></th>
               <th scope="col">Cantidad</th>
               <th scope="col">Fechade pago</th>
               <th scope="col">Notas</th>
               <th scope="col">Estado</th>
               <th scope="col">Seleccionar</th>
               
               </tr>
               
            </thead>

            <tbody >
    @foreach ($pagos as $pago)
                <tr style = "font-size : 14px; margin : 15px" >

                   <td>
                   {{$pago->invoice}}
                   <br>
                    </td>
                    <td>
                   {{$pago->concept}}
                    </td>
                    <td>
                    {{$pago->symbol}}{{number_format($pago->amount)}}
                    </td>
                    <td>
                   {{$pago->date}}
                    </td>
                    <td>
                   {{$pago->nota}}
                    </td>
                    <td>
                    @php {{
                      $fecha = new DateTime($pago->date);
                    }}@endphp

                    @if($pago->status == 'pagado')
                    <a href="{{route('payments.pay_actualize',$pago->id)}}">
                        <button class="button" type="button"> <span class="badge badge-success">Pagado</span> </button>
                        </a> 
                      
                      @else
                      @if( now() > $fecha)
                      <a href="{{route('payments.pay_actualize',$pago->id)}}">
                      <button class="button" type="button"> <span class="badge badge-danger">atrasado</span> </button>
                      </a>  
                    @else
                      <a href="{{route('payments.pay_actualize',$pago->id)}}">
                      <button class="button" type="button"> <span class="badge badge-info">por cobrar</span> </button>
                      </a>
                      @endif     
                    @endif           
                    </td>
                    <td>
                    </td>
                    <td>
                    
                       &nbsp; 
                      @if($pago->status == 'por cobrar')
                    <input class="form-check-input" type="checkbox" value="{{$pago->id}}" id="flexCheckDefault" name="pago[]">
                    
                    @endif
                    
                    </td>

                    
                </tr>



                
      @endforeach
      
            </tbody>
        </table>
        <br><br>

        <br>
        <button type="submit" class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">PAGAR SELECCIONADOS</button>
        
    </div>
    </form>
  </div>
  <br>
  
            <br> <br> 
            
                </div>
                    <input  class="btn btn-green" style="background-color: rgb(22,163,74);color: white;" type="button" name="imprimir" value="Imprimir" id="printPageButton" onclick="window.print();"> 
                    
                                    
                    
  
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
@stop

@section('js')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablecatalogocustomers.js') }}"></script>
@stop