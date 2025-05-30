@extends('adminlte::page')

@section('title', 'NOTAS DE CREDITO')

@section('content_header')
    <h1 class="font-bold"><i class="fa-solid fa-clipboard-check"></i>&nbsp; NOTAS DE CREDITO</h1>
     
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
            <a href="{{ route('reports.generate',[0,'resumen_nota',0])}}" class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">
                    <i class="fa-solid fa-eye"></i>&nbsp; Resumen
                </a> 
                @can('CREAR NOTAS')
                <a href="{{ route('credit_notes.create')}}" class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
                    <i class="fa-solid fa-plus-circle"></i>&nbsp; Nuevo
                </a>

                @endcan
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-6 col-sm-12 table-responsive">
                <table class="table tablefactures table-striped text-xs font-medium" id="example">
                    <thead>
                        <tr class="text-center">
                            <th>PDA</th>
                            <th>FECHA </th>
                            <th>NOTA </th>
                            <th>CLIENTE</th>
                            <th>IMPORTE </th>
                            <th>Estatus</th>
                            <th></th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach($Notas as $nota)

                        <tr class="text-center">
                          <td>{{$i}}</td>
                          <td>{{$nota->date}}</td>
                          <td>{{$nota->credit_note}}</td>
                          <td>{{$nota->customer}}</td>
                          <td> $ {{number_format($nota->amount,2)}} </td>
                          <td>{{$nota->status}} </td>
                          <td></td>
                          <td class="w-18"> <div class="row">
                                    <div class="col-6 text-center w-10">
                                        @can('EDITAR NOTAS')
                                        <a href="{{ route('credit_notes.edit', $nota->id)}}">
                                        <button class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        @endcan
                                    </div>
                                    
                                    <div class="col-6 text-center w-10">
                                        @can('BORRAR NOTAS')
                                        <form class="DeleteReg" action="{{ route('credit_notes.destroy', $nota->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" >
                                                <i class="fas fa-trash items-center fa-xl"></i>
                                            </button>
                                        </form>
                                        @endcan
                                        </div>
                                        
                                    <div class="col-6 text-center w-10">
                                        <a href="{{ route('credit_notes.show', $nota->id)}}">
                                        <button class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">
                                                <i class="fas fa-xl fa-eye"> </i> </button>
                                            </a>
                                           </div> 
                                            <div class="col-6 text-center w-10">
                                        <a href="{{ route('note_pdf', $nota->id)}}">
                                        <button class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;">
                                                <i class="fa fa-xl fa-file-pdf-o">pdf </i> 
                                        </button></a>
                                            </div>
                                    
                                </div>
                            </td>
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