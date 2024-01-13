@extends('adminlte::page')

@section('title', 'ROLES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-edit"></i>&nbsp; Editar Rol</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-4 rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-edit"></i>&nbsp; Editar Rol
            </h5>
        </div>
        {!! Form::open(['method'=>'PUT','route'=>['roles.update',$role->id]]) !!}
        <div class="row p-4 rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="col-xs-12 p-2 gap-2">
                <div class="form-group">
                    <x-jet-label value="* Nombre" />
                    {!! Form::text('name',$role->name, ['class'=>'inputjet w-full text-xs uppercase']) !!}
                    <x-jet-input-error for='name' />
                </div>
            </div>
            <div class="col-xs-12 p-2 gap-2">
                <div class="form-group">
                    <x-jet-label value="* Permisos para el Rol" />
                    {{--  <div class="row">
                    @foreach ($permission as $row)
                        <div class="col-3">
                            {!! Form::checkbox('permission[]', $row->id, in_array($row->id, $rolePermissions) ? true : false, ['class'=>'input-jet']) !!}
                            {{$row->name}}
                        </div>
                    @endforeach
                    </div>  --}}
                    <div class="row">
                    @foreach ($Categorias as $row)
                        <div class="col-4 gap-3 text-sm font-bold">
                            {!! Form::checkbox('permission[]', $row->id, in_array($row->id, $rolePermissions) ? true : false, ['class'=>'input-jet']) !!}
                            {{$row->name}}
                        </div>
                    @endforeach
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4 gap-3 text-sm">
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($Catalogos as $row)
                            {!! Form::checkbox('permission[]', $row->id, in_array($row->id, $rolePermissions) ? true : false, ['class'=>'input-jet']) !!}
                            {{$row->name}}<br>
                            @if ($count == 3)
                                <hr>
                                @php
                                $count = 0;
                                @endphp
                            @else
                                @php
                                $count = $count + 1;
                                @endphp
                            @endif
                            @endforeach
                        </div>
                        <div class="col-4 gap-3 text-sm">
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($Pedidos as $row)
                            {!! Form::checkbox('permission[]', $row->id, in_array($row->id, $rolePermissions) ? true : false, ['class'=>'input-jet']) !!}
                            {{$row->name}}<br>
                            @if ($count == 3)
                                <hr>
                                @php
                                $count = 0;
                                @endphp
                            @else
                                @php
                                $count = $count + 1;
                                @endphp
                            @endif
                            @endforeach
                        </div>
                        <div class="col-4 gap-3 text-sm">
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($Contabilidad as $row)
                            {!! Form::checkbox('permission[]', $row->id, in_array($row->id, $rolePermissions) ? true : false, ['class'=>'input-jet']) !!}
                            {{$row->name}}<br>
                            @if ($count == 3)
                                <hr>
                                @php
                                $count = 0;
                                @endphp
                            @else
                                @php
                                $count = $count + 1;
                                @endphp
                            @endif
                            @endforeach
                        </div>
                        <div class="col-4 gap-3 text-sm">
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($Confidencialidad as $row)
                            {!! Form::checkbox('permission[]', $row->id, in_array($row->id, $rolePermissions) ? true : false, ['class'=>'input-jet']) !!}
                            {{$row->name}}<br>
                            @if ($count == 3)
                                <hr>
                                @php
                                $count = 0;
                                @endphp
                            @else
                                @php
                                $count = $count + 1;
                                @endphp
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <x-jet-input-error for='permission' />
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                <a href="{{ route('roles.index')}}" class="btn btn-green mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>
                <button type="submit" class="btn btn-red mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Guardar
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop

@section('css')
    
@stop

@section('js')
    
@stop