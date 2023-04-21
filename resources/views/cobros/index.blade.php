@extends('adminlte::page')

@section('title', 'COBROS')

@section('content_header')
    <h1 class="font-bold"><i class="fa fa-money"></i>&nbsp; COBROS</h1>
    <script src="/Scripts/jquery.dataTables.js"></script>
<script src="/Scripts/dataTables.bootstrap.js"></script>
    
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
            <a href="{{ route('reports.generate',[1,'resumen_comprobante',0])}}" class="btn btn-blue">
                    <i class="fa-solid fa-eye"></i>&nbsp; Resumen
                </a>
                @can('CREAR PEDIDOS')
                <a href="{{ route('cobros.create')}}" class="btn btn-green">
                    <i class="fa-solid fa-plus-circle"></i>&nbsp; Nuevo
                </a>
                @endcan
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-6 col-sm-12 table-responsive">
                <table class="table tablefactures table-striped text-xs text-center font-medium">
                    <thead>
                        <tr class="text-center">
                            <th rowspan="2">PDA</th>
                            <th rowspan="2">FECHA EMISION</th>
                            <th rowspan="2">FACTURA</th>
                            <th rowspan="2">BANCO</th>
                            <th rowspan="2">P.I.</th>
                            <th rowspan="2">CLIENTE </th>
                            <th rowspan="2">MONEDA</th>
                            <th rowspan="2">TC</th>
                            <th colspan="2">IMPORTE TOTAL</th>
                            <th rowspan="2">CAPTURO </th>
                            <th rowspan="2">REVISO</th>
                            <th rowspan="2">AUTORIZO</th>
                            <th rowspan="2"> </th>
                            <th rowspan="2"> </th>
                           
                        </tr>
                        <TR>
                            <TH>DLL</TH>
                            <TH>M.N.</TH>
                        </TR>
                    </thead>
                    <tbody>
                        @foreach($Cobros as $c)
                        <tr>
                        <td>{{$c->id}}</td>
                        <td>{{$c->date}}</td>
                        <td>{{$c->facture}}</td>
                        <td>{{$c->bank_description}} {{$c->bank_clue}} </td>
                        <td>{{$c->invoice}}</td>
                        <td>{{$c->customer}}</td>
                        <td>{{$c->coin}}</td>
                        <td>{{$c->tc}}</td>
                        <td> {{$c->symbol}} {{number_format($c->amount  ,2)}} </td>
                        <td> {{$c->symbol}} {{number_format($c->amount * $c->tc ,2)}} </td>
                        <td> {{$c->capturista}}</td>
                        <td>@if($c->reviso) {{$c->revisor}}
                             @else  Marcar revisado <a href="{{ route('cobros.revisar', $c->id)}}">
                                        <button class="btn btn-green">
                                                <i class="fas fa-xl fa-check   "></i>
                                                </button>
                                        </a>
                                @endif </td>
                        <td>@if($c->autorizo) {{$c->autorizador}}
                             @else  Marcar autorizado <a href="{{ route('cobros.autorizar', $c->id)}}">
                                        <button class="btn btn-green">
                                                <i class="fas fa-xl fa-check   "></i>
                                                </button>
                                        </a>
                                @endif</td>
                        <td> <div class="row">
                                    <div class="col-6 text-center w-10">
                                        @can('EDITAR FAMILIAS')
                                        <a href="{{ route('cobros.edit', $c->id)}}">
                                        <button class="btn btn-blue">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        @endcan
                                    </div>
                                    &nbsp; &nbsp;
                                    <div class="col-6 text-center w-10">
                                        @can('BORRAR FAMILIAS')
                                        <form class="DeleteReg" action="{{ route('cobros.destroy', $c->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red ">
                                                <i class="fas fa-trash items-center fa-xl"></i>
                                            </button>
                                        </form>
                                        @endcan
                                        &nbsp; &nbsp;
                                        <a href="{{ route('cobros.show', $c->id)}}">
                                        <button class="btn btn-blue">
                                                <i class="fas fa-xl fa-eye"> </i> 
                                        </button></a>
                                        &nbsp; &nbsp;
                                        <a href="{{ route('cobro_pdf', $c->id)}}">
                                        <button class="btn btn-red">
                                                <i class="fa fa-xl fa-file-pdf-o">pdf </i> 
                                        </button></a>

                                    </div> 
                                </div></td>
                                
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

@section('js')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablecatalogofactures.js') }}"></script>

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


@stop