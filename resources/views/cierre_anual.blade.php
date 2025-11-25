@extends('adminlte::page')

@section('title', 'CIERRE ANUAL')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-file"></i>&nbsp;PROTOCOLO PARA CIERRE ANUAL</h1>
@stop

@section('content')
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-lg">
                    <h1>PEDIDOS INTERNOS CERRADOS (COBRADOS) AL DIA DE HOY</h1>
                    <br><br>
                    <table style="width: 60%">
                        <tr> 
                            <td>Consecutivo de pedidos cerrados </td>
                            <br>
                            <td>
                            <a href="{{route('reports.generate',[1,'CxC_pedidos_cerrados',0])}}">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="{{route('reports.generate',[1,'CxC_pedidos_cerrados',1])}}">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                        </tr>
                       
                      
                    </table>
                    <br>
                    <h1>EJECUTAR PROTOCOLO</h1>
                    <center>
                        <p> Precaución: EL protocolo borrara del sistema todas las ordenes internas cuya suma de cobros sea mayor o igual al total con un rango de 1 unidad de la moneda del pedido</p>
                        <br>
                        <p>Tambien se eliminaran todas las facturas, cobros, pagos programados, comisiones y notas de crédito relacionadas a los pedidos asi como los comprobantes alojados </p>
                        <p><i class="fas fa-warning fa-2x"></i> <span style ="color:red"> Este cambio no es reversible desde el programa </span> </p>
                    <div style="width:50%">
                <form class="DeleteReg" action="{{ route('internal_orders.exterminio')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                     
                            <div class="row p-4">
                                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <x-jet-label value="* Contraseña (clave secreta mas el número total de ordenes en el catalogo actualmente;  ej: 'rgf234')" />
                                                <x-jet-input type="password" name="key" class="w-full text-xs " value="{{old('unit')}}"/>
                                                <x-jet-input-error for='unit' />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                                <button type="submit" class="btn btn-red mb-2">
                                    <i class="fas fa-warning fa-2x"></i>&nbsp; &nbsp; EJECUTAR
                                </button>
                            </div>
                        </div>
                        </form>
                        </div>
                    </div>
                    </center>
                     
                    
               
                                
                                  <BR><BR></BR></BR>
                    

                    
                               
                               
        
            </div>
           

@stop

@section('css')
    
@stop

@push('js')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/alert_delete_reg.js') }}"></script>

@if (session('password') == 'fail')
<script>
      Swal.fire({
            icon: 'error',
            title: "<i>El protocolo no se ejecutó</i>", 
            html: `la contraseña es incorrecta` ,  
                    showCancelButton: false,
                    showConfirmButton: true,
            });

</script>
 
@endif

@endpush