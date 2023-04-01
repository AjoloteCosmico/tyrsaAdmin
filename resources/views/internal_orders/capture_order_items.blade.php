@extends('adminlte::page')

@section('title', 'PEDIDO INTERNO')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-clipboard-check"></i>&nbsp; Pedido Interno</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; Agregar Pedido Interno:
            </h5>
        </div>
        <form action="{{ route('internal_orders.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-jet-input type="hidden" name="temp_internal_order_id" value="{{ $TempInternalOrders->id }}"/>
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                    
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                <form action="{{route('tempitems.create_item', $TempInternalOrders->id) }}" id ="form-id" method="POST" enctype="multipart/form-data">
            @csrf
        <x-jet-input type="hidden" name="temp_internal_order_id" value="{{ $TempInternalOrders->id }}"/>
                
                    <div class="form-group">
                                <x-jet-label value="* Categoria" />
                                <select class="form-capture  w-full text-xs uppercase" name="category" id='cat'>
                                        
                                        <option value=" " > </option>
                                        <option value="Productos" >Productos</option>
                                        <option value="Servicios" >Servicios</option>
                                        <option value="Integracion" >Integracion</option>
                                       
                                    
                                </select>
                                <x-jet-input-error for='family' /> 
                            <div class="form-group">
                                <x-jet-label value="* Descripción del Proyecto" />
                                <select class="form-capture  w-full text-xs uppercase" name="description" id='desc'>
                                <option value="Producto Fabricacion" >Producto fabricacion PF</option>
                                        <option value="Producto Comercializacion" >Producto Comercializacion  PC</option>
                                        <option value="Servicio directo SD" >Servicio directo SD</option>
                                        <option value="Servicio indirecto SI" >Servicio indirecto SI</option>
                                        <option value="PF+SD" >PF+SD</option>
                                        <option value="PF+SI" >PF+SI</option>
                                        <option value="PC+SD" >PC+SD</option>
                                        <option value="PC+SI" >PC+SI</option>
                                       
                                </select><x-jet-input-error for='description' />
                            </div>
                                    <div class="col-sm-12 text-right p-3">
                                        
                                        <button type="submit" class="btn btn-green">
                                            <i class="fas fa-plus-circle"></i>&nbsp; Agregar Partida
                                         </button>
                                    </div></form>
                                    <div class="col-sm-12 table-responsive">
                                        <table class="table tableitems table-striped text-xs font-medium">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Pda</th>
                                                    <th>Cant</th>
                                                    <th>Unidad</th>
                                                    <th>Familia</th>
                                                    <th>SKU</th>
                                                    <th>Descripción</th>
                                                    <th>P. U.</th>
                                                    <th>Importe</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($TempItems as $row)
                                                <tr class="text-center">
                                                    <td>{{ $row->item }}</td>
                                                    <td>{{ $row->amount }}</td>
                                                    <td>{{ $row->unit }}</td>
                                                    <td>{{ $row->family }}</td>
                                                    <td>{{ $row->sku }}</td>
                                                    <td>{{ $row->description }}</td>
                                                    <td class="text-right">$ {{ number_format($row->unit_price, 2) }}</td>
                                                    <td class="text-right">$ {{ number_format($row->import, 2) }}</td>
                                                    <td><a href="{{ route('tempitems.edit_item', [$row->id,0]) }} " class="btn btn-green">
                                                        <button type = "button" class="btn btn-green "> <i class="fas fa-edit"></i> </button>
                                                   </a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{--  <x-jet-input type="hidden" name="item" class="w-flex text-xs" value="{{ $ITEM }}"/>
                                        <x-jet-input-error for='item' />  --}}
                                    </div>
                                </div>
                            </div>
                            <div class="w-100"><hr></div>
                            <div class="row p-3">
                                <div class="col-sm-12 text-right">
                                    <div class="form-group">
                                        <span class="text-right font-bold text-lg">Subtotal: $ {{number_format($Subtotal,2)}}</span>
                                        <x-jet-input type="hidden" name="subtotal" class="w-flex text-xs" value="{{ $Subtotal }}"/>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-right">
                                    <div class="form-group">
                                        {{--  <span class="text-right font-semibold text-sm">IVA: $ {{number_format($Iva,2)}}</span>  --}}
                                        <x-jet-input type="hidden" name="iva" class="w-flex text-xs" value="{{ $Iva }}"/>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-right">
                                    <div class="form-group">
                                        {{--  <span class="text-right font-bold text-xl">Total: $ {{number_format($Total,2)}}</span>  --}}
                                        <x-jet-input type="hidden" name="total" class="w-flex text-xs" value="{{ $Total }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <x-jet-label value="Observaciones" />
                                        <textarea name="observations" rows="5" class="w-full text-xs inputjet" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                                        <x-jet-input-error for='observations' />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                {{--  <a href="{{ route('internal_orders.index')}}" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>  --}}
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
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tableitems.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tableshipping_addresses.js') }}"></script>
@stop