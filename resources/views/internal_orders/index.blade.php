@extends('adminlte::page')

@section('title', 'PEDIDO INTERNO')

@section('content_header')
    <h1 class="font-bold"><i class="fa-solid fa-clipboard-check"></i>&nbsp; PEDIDO INTERNO</h1>
    
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                @CAN('VER RESUMEN PI')
            <a href="{{ route('reports.generate',[0,'resumen_pedido',0])}}" class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">
                    <i class="fa-solid fa-eye"></i>&nbsp; Resumen
                </a>
                @endcan
                @can('CREAR PEDIDOS')
                <a href="{{ route('internal_orders.create')}}" class="btn btn-green"  >
                    <i class="fa-solid fa-plus-circle"></i>&nbsp; Nuevo
                </a>
                @endcan
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                <table class="table tableinternalorders table-striped text-xs font-medium" >
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Folio</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Clave</th>
                            <th>Vendedor</th>
                            <th>Total</th>
                            <th>Estatus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($InternalOrders as $row)
                        <tr class="text-center">
                            <td>{{$row->id}}</td>
                            <td>{{$row->invoice}}</td>
                            <td>{{date('d-m-Y', strtotime($row->date)) }}</td>
                            <td style="word-wrap: break-word; width: 38.3vh">{{$row->customer}}</td>
                            <td>{{$row->clave}}</td>
                            <td>{{$row->seller_name}}</td>
                            <td> $ {{number_format($row->total,2)}} {{$row->code}}</td>
                            <td>{{$row->status}}</td>
                            <td class="w-18">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        @can('VER PEDIDOS')
                                        <a href="{{ route('internal_orders.show', $row->id)}}">
                                            <i class="fa-solid fa-eye btn btn-blue"  style="background-color: rgb(37 ,99 ,235 );color: white;"></i></span>
                                        </a>
                                        @endcan
                                    </div>
                                    @if($row->status == 'CAPTURADO')
                                    <div class="col-6 text-center w-10">
                                        @can('BORRAR PEDIDOS')
                                        <form class="DeleteReg" action="{{route('internal_orders.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;"  style="background-color: rgb(220 ,38 ,38);color: white;">
                                                <i class="fa-solid fa-trash items-center"></i>
                                            </button>
                                        </form>
                                        @endcan
                                        @can('CANCELAR PEDIDO')
                                        <form class="CancelReg" action="{{route('internal_orders.cancel', $row->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;"  style="background-color: rgb(220 ,38 ,38);color: white;">
                                                <i class="fa-solid fa-xmark items-center"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                    @endif
                                    @if($row->vent_auth == 1)
                                    <div class="col-6 text-center w-10">
                                        <form action="{{ route('internal_orders.pagos', $row->id) }}" method="POST">
                                            @csrf
                                            <x-jet-input type="hidden" name="order_id" value="{{ $row->id}}"/>
                                            <button type="submit" class="btn btn-green" style="background-color: rgb(22,163,74);color: white;" style="background-color: rgb(22,163,74);color: white;">
                                                <i class="fa-solid fa-percent items-center"></i>
                                            </button>
                                        </form>
                                       
                                        @can('BORRAR PEDIDO AUTORIZADO')
                                        @if($row->status == 'autorizado')
                                        <form class="DeleteReg" action="{{route('internal_orders.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;"  style="background-color: rgb(220 ,38 ,38);color: white;">
                                                <i class="fa-solid fa-trash items-center"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @endcan

                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
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
    table = $(".tableinternalorders").DataTable({
        destroy: true,
        responsive: true,

        "columnDefs": [
            {
                "targets": [0],
                "searchable": false,
                "sortable": false,
                "visible": false,
            },
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
<!-- <script  src="{{ asset('vendor/mystylesjs/js/tablecatalogointernal_orders.js') }}"> </script>  -->

<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/alert_delete_reg.js') }}"></script>

<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/alert_cancel_reg.js') }}"></script>

@if (session('create_reg') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/confirm_create_reg.js') }}"></script>
@endif

@if (session('eliminar') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/confirm_delete_reg.js') }}"></script>
@endif
@if (session('cancel') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/confirm_cancel_reg.js') }}"></script>
@endif

@if (session('error_delete') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/error_delete_reg.js') }}"></script>
@endif

@if (session('update_reg') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/update_reg.js') }}"></script>
@endif
@endpush