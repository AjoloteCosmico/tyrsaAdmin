@extends('adminlte::page')

@section('title', 'COBROS')

@section('content_header')
    <h1 class="font-bold"><i class="fa fa-money"></i>&nbsp; COBROS</h1>
     <!-- Bootstrap 5.0 -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
        <!-- Font Awesome 6 Kit LEPER SYSTEMS -->
        <script src="https://kit.fontawesome.com/1bfa36884d.js" crossorigin="anonymous"></script>
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <!-- Load Source Sans Pro font -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" rel="stylesheet">
        <!-- Load Nunito font -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Load Roboto font -->
        <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext" rel="stylesheet">
        <!-- Load Amaranth font -->
        <link href="https://fonts.googleapis.com/css2?family=Amaranth:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

        <!-- DataTables -->
    	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.3.1/dt-1.10.25/af-2.3.7/b-1.7.1/b-print-1.7.1/cr-1.5.4/date-1.1.0/fc-3.3.3/fh-3.1.9/kt-2.6.2/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.4/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css"/>

        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('vendor/img/ico/apple-touch-icon-144.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('vendor/img/ico/apple-touch-icon-114.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('vendor/img/ico/apple-touch-icon-72.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('vendor/img/ico/apple-touch-icon-57.png') }}">
        <link rel="shortcut icon" href="{{ asset('vendor/img/ico/favicon.ico') }}">

        <!-- My Style -->
        <link href="{{ asset('vendor/mystylesjs/css/datatable_gral.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    
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
                <table class="table tablefactures table-striped text-xs text-center font-medium" id="example">
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
                        <td> <div class="row">
                                    <div class="col-6 text-center w-10">
                                        @can('EDITAR COBROS')
                                        <a href="{{ route('cobros.edit', $c->id)}}">
                                        <button class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        @endcan
                                    </div>
                                    &nbsp; &nbsp;
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
                                        &nbsp; &nbsp;
                                        <a href="{{ route('cobros.show', $c->id)}}">
                                        <button class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">
                                                <i class="fas fa-xl fa-eye"> </i> 
                                        </button></a>
                                        &nbsp; &nbsp;
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  new DataTable('#example');
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