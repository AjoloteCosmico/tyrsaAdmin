@extends('adminlte::page')

@section('title', 'AUTORIZACIONES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-fingerprint"></i>&nbsp; AUTORIZACIONES</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                @can('CREAR AUTORIZACIONES')
                <a href="{{ route('authorizations.create')}}" class="btn btn-green">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nueva
                </a>
                @endcan
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                <table class="table tableauthorizations table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Puesto</th>
                            <th>Rango Mayor</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Authorizations as $row)
                        <tr class="text-center">
                            <td>{{$row->id}}</td>
                            <td>{{$row->job}}</td>
                            <td>$ {{number_format($row->clearance_level,2)}}</td>
                            <td class="w-15">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        @can('EDITAR AUTORIZACIONES')
                                        <a href="{{ route('authorizations.edit', $row->id)}}">
                                        <button class="btn btn-blue">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        @endcan
                                    </div>
                                    &nbsp;
                                    &nbsp;
                                    <div class="col-6 text-center w-10">
                                        @can('BORRAR AUTORIZACIONES')
                                        <form class="DeleteReg" action="{{ route('authorizations.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red ">
                                                <i class="fas fa-trash fa-xl"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
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

@section('js')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablecatalogoauthorizations.js') }}"></script>

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