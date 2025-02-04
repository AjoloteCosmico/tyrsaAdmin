@extends('adminlte::page')

@section('title', 'VENDEDORES')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-users-cog"></i>&nbsp; REASIGNAR CLEINTE</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; REASIGNAR CLIENTE {{$Customer->customer}}:
            </h5>
        </div>
        <form action="{{ route('sellers.confirm_reasign')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="customer_id" value="{{$Customer->id}}"/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-6 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center fw">Reasginar cliente del vendedor {{$Seller->seller_name}}</h1>
                        </div>
                        
                            <div class="form-group">
                                <x-jet-label value="Nuevo vendedor" />
                                <select class="form-select" aria-label="Default select example" name ="seller_id">                               
                                        @foreach( $Sellers as $row)
                                        <option value="{{$row->id}}">{{$row->seller_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                           
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-12 text-right p-2 gap-2">
                <a href="{{ route('sellers.index')}}" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>
                <button type="submit" class="btn btn-green mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Guardar
                </button>
            </div>
        </div>
        </form>
    </div>
@stop

@section('css')
    
@stop

@section('js')

@stop