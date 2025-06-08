@extends('adminlte::page')

@section('title', 'COMPROBANTE DE INGRESO')

@section('content_header')
    <h1 class="font-bold"><i class="fa fa-money"></i>&nbsp;  ASSIGNAR A COBRO</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp;   ASSIGNAR A COBRO:
            </h5>
        </div>
        <form action="{{ route('factures.make_assign')}}" method="POST" enctype="multipart/form-data" id="form1">
        @csrf
        <x-jet-input type="hidden" name="facture_id" value="{{$Id}}"/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-body">
                            <h1>Existen cobros de este pedido sin facturar, ¿Desea asignar la factura a alguno?</h1>
                            
                            <br>
                            <hr>
                            
                            <div class="col-sm-8 col-md-7 py-4">
                            
                                                    
                            <div class="form-group">
                                        <x-jet-label value="* Cobro" />
                                        <select class="form-capture  w-full text-xs uppercase" name="cobro_id" >  
                                        @foreach ($Cobros as $row)
                                                <option value="{{$row->id}}" @if ($row->id == old('cobro_id')) selected @endif > {{$row->comp}} ${{number_format($row->amount,2)}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='customer_id' />
                                    </div>
                        
                        
                            </div>
                                    
                            
                                    


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                  <a href="{{ route('factures.index')}}" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>  
                <button class="btn btn-green mb-2">
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

