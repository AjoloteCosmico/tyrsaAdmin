@extends('adminlte::page')

@section('title', 'PRODUCTOS')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-money-bill-1"></i>&nbsp; PRODUCTOS</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                @can('CREAR MONEDAS')
                <a href="{{ route('coins.create')}}" class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nueva
                </a>
                @endcan
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                <table class="table tablecoins table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>producto</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Products as $row)
                        <tr class="text-center">
                            <td>{{$row->id}}</td>
                            <td>{{$row->name}}</td>
                            <td class="w-15">
                                <div class="row">
                                    <div class="col-6 text-center">
                                        @can('EDITAR MONEDAS')
                                        <a href="{{ route('coins.edit', $row->id)}}">
                                        <button class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        @endcan
                                    </div>
                                    <div class="col-6 text-center">
                                        @can('BORRAR MONEDAS')
                                        <form class="DeleteReg" action="{{ route('coins.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;">
                                                <i class="fas fa-trash items-center fa-xl"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                            <td></td>
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
        <!-- <script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablecatalogocoins.js') }}"></script> -->

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