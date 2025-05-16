@extends('adminlte::page')

@section('title', 'COBROS')

@section('content_header')
    <h1 class="font-bold"><i class="fa fa-money"></i>&nbsp; COBROS</h1>
    
    
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
            <a href="{{ route('reports.generate',[0,'resumen_comprobante',0])}}" class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">
                    <i class="fa-solid fa-eye"></i>&nbsp; Resumen
                </a>
                @can('CREAR COBROS')
                <a href="{{ route('cobros.create')}}" class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
                    <i class="fa-solid fa-plus-circle"></i>&nbsp; Nuevo
                </a>
                @endcan
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-6 col-sm-12 table-responsive">
                <table class="table tablefactures table-striped text-xs text-center font-medium" >
                    <thead>
                        <tr   class="text-center">
                            <th  >PDA</th>
                            <th  >NO. COMP</th>
                            <th  >FECHA EMISION</th>
                            <th  >FACTURA</th>
                            
                            <th  >CLIENTE </th>
                            <th  >P.I.</th>
                            <th  >BANCO</th>
                            <th  >MONEDA</th>
                            <th  >TC</th>
                            
                            <TH>DLL</TH>
                            <TH>M.N.</TH>
                            
                           
                            <th  >CAPTURO </th>
                            <th  >REVISO</th>
                            <th  >AUTORIZO</th>
                            <th  > </th>
                           
                        </tr>
                    </thead>
                    <tbody>
                    @php
                            $i=1;
                        
                        @endphp

                        @foreach($Cobros as $c)
                        <tr @if($FacturasCobradas->where('cobro_id',$c->id)->count()==0) style="color:red; --bs-table-striped-color: red;" @endif>
                        <td >{{$c->id}} </td>
                        <td>{{$c->comp}} </td>
                        <td>{{$c->date}}</td>

                        @if($FacturasCobradas->where('cobro_id',$c->id)->count()==1)
                        <td>{{$FacturasCobradas->where('cobro_id',$c->id)->first()->facture}}</td>
                        @else
                            @if($FacturasCobradas->where('cobro_id',$c->id)->count()==0) 
                                <td> <p style="font-weight: bold;">   <i class='fas fa-exclamation-triangle'></i> PENDIENTE POR FACTURAR</p> </td>
                            @else
                                <td>{{$FacturasCobradas->where('cobro_id',$c->id)->count()}} Facturas asociadas</td>
                            @endif
                        @endif
                        <td>{{$c->customer}}</td>
                        <td>{{$c->invoice}}</td>
                        <td>{{$c->bank_description}} {{$c->bank_clue}} </td>
                        
                        <td>{{$c->coin}}</td>
                        <td>{{$c->tc}}</td>
                        @if($c->coin=='NACIONAL')
                        <td> NA </td>
                        <td> {{$c->symbol}} {{number_format($c->amount  ,2)}} </td>
                       @else
                        <td> {{$c->symbol}} {{number_format($c->amount ,2)}} </td>
                        <td> {{$c->symbol}} {{number_format($c->amount * $c->tc ,2)}}</td>
                       @endif
                        <td> {{$c->capturista}}</td>
                        <td>@if($c->reviso) {{$c->revisor}}
                             @else  
                             @can('REVISAR COBROS')
                             Marcar revisado <a href="{{ route('cobros.revisar', $c->id)}}">
                                        <button class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
                                                <i class="fas fa-xl fa-check   "></i>
                                                </button>
                                        </a>
                            @endcan

                                @endif </td>
                        <td>@if($c->autorizo) {{$c->autorizador}}
                             @else  
                             @can('AUTORIZAR COBROS')
                             Marcar autorizado <a href="{{ route('cobros.autorizar', $c->id)}}">
                                        <button class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
                                                <i class="fas fa-xl fa-check   "></i>
                                                </button>
                                        </a> @endcan
                                @endif</td>
                        <td class="w-18"> 
                            <div class="row">
                                    <div class="col-6 text-center w-10">
                                        @can('EDITAR COBROS')
                                        <a href="{{ route('cobros.edit', $c->id)}}">
                                        <button class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        @endcan
                                    </div>
                                   
                                    <div class="col-6 text-center w-10">
                                        @can('BORRAR COBROS')
                                        <form class="DeleteReg" action="{{ route('cobros.destroy', $c->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" >
                                                <i class="fas fa-trash items-center fa-xl"></i>
                                            </button>
                                        </form>
                                        @endcan
                                        </div>
                                        <div class="col-6 text-center w-10">
                                        <a href="{{ route('cobros.show', $c->id)}}">
                                        <button class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">
                                                <i class="fas fa-xl fa-eye"> </i> 
                                        </button></a>
                                        </div>
                                        <div class="col-6 text-center w-10">
                                        <a href="{{ route('cobro_pdf', $c->id)}}">
                                        <button class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;"">
                                                <i class="fa fa-xl fa-file-pdf-o">pdf </i> 
                                        </button></a>

                                    </div> 
                                </div></td>
                                
                        </tr>
                        @php
                            $i=$i+1;
                        
                        @endphp
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    
@stop

@push('js')
<script>
    table = $(".tablefactures").DataTable({
        destroy: true,
        responsive: true,

        "columnDefs": [
       
            {
                "targets": [6],
                "searchable": false,
                "sortable": false,
                "visible": true,
            },
        ],

        /** Para usar los botones */ 
        dom: 'Bfrtilp',       
        buttons:[ 
            {
                extend:    'excelHtml5',
                text:      '<i class="fas fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-green'
            },
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-blue'
            },
            /**
             * 
             {
                extend:    'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-red'
            },
             * 
             */
        ],
    
        /** Traducciones */
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Registros del _START_ al _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Registros del 0 al 0 de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
            },
            "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
            "copy": "Copiar",
            "colvis": "Visibilidad"
            }
        },
    });
</script>
<!-- <script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablecatalogofactures.js') }}"></script> -->

<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/alert_delete_reg.js') }}"></script>

@if (session('create_reg') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/confirm_create_reg.js') }}"></script>
@endif

@if (session('eliminar') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/confirm_delete_reg.js') }}"></script>
@endif

@if (session('error_delete') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/error_delete_reg.js') }}"></script>
@endif

@if (session('update_reg') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/update_reg.js') }}"></script>
@endif


@endpush