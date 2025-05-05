@extends('adminlte::page')

@section('title', 'PERFIL DE COMPAÑÍA')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-industry"></i>&nbsp; COMPAÑÍA</h1>
@stop

@section('content')
    <div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="col-sm-12 text-right">
                @can('CREAR EMPRESAS')
                @if ($CompanyProfiles)
                    <a class="btn btn-disabled">
                        <i class="fas fa-plus-circle"></i>&nbsp; Agregar
                    </a>
                @else
                    <a href="{{ route('company_profiles.create')}}" class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
                        <i class="fas fa-plus-circle"></i>&nbsp; Agregar
                    </a>
                @endif
                @endcan
            </div>
            <div class="w-100">&nbsp;</div>
            <div class="col-sm-12 table-responsive">
                <table class="table tablecompanyprofile table-striped text-xs font-medium">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Empresa</th>
                            <th>Eslogan</th>
                            <th>RFC</th>
                            <th>Estado</th>
                            <th>Municipio</th>
                            <th>Colonia</th>
                            <th>Calle</th>
                            <th>Exterior</th>
                            <th>Interior</th>
                            <th>CP</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Teléfono 2</th>
                            <th>Web</th>
                            <th>Logo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($CompanyProfiles as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td>{{$row->company}}</td>
                            <td>{{$row->motto}}</td>
                            <td>{{$row->rfc}}</td>
                            <td>{{$row->state}}</td>
                            <td>{{$row->city}}</td>
                            <td>{{$row->suburb}}</td>
                            <td>{{$row->street}}</td>
                            <td>{{$row->outdoor}}</td>
                            <td>{{$row->intdoor}}</td>
                            <td>{{$row->zip_code}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{$row->telephone}}</td>
                            <td>{{$row->telephone2}}</td>
                            <td>{{$row->website}}</td>
                            <td>{{$row->logo}}</td>
                            <td class="w-10">
                                <div class="row">
                                    <div class="col-6 text-center w-10">
                                        @can('EDITAR EMPRESAS')
                                        <a href="{{ route('company_profiles.edit', $row->id)}}">
                                        <button class="btn btn-blue" style="background-color: rgb(37 ,99 ,235 );color: white;">
                                                <i class="fas fa-xl fa-edit   "></i>
                                                </button>
                                        </a>
                                        @endcan
                                    </div>
                                    &nbsp;&nbsp;&nbsp;
                                    <div class="col-6 text-center w-10">
                                        @can('BORRAR EMPRESAS')
                                        <form class="DeleteReg" action="{{ route('company_profiles.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" >
                                                <i class="fas fa-trash items-center fa-xl"></i>
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
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tablecatalogocompany_profiles.js') }}"></script>

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