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
        <form action="{{route('tempitems.create_item', $TempInternalOrders->id) }}" method="POST" id ="form-id" enctype="multipart/form-data">
        @csrf
        <x-jet-input type="hidden" name="temp_internal_order_id" value="{{ $TempInternalOrders->id }}"/>
        <x-jet-input type="hidden" name="session_desc" id="session_desc" value="."/>
        <x-jet-input type="hidden" name="session_cat" id="session_cat" value="."/>
        <x-jet-input type="hidden" name="session_obs" id="session_obs" value="."/>
        
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                    
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
           
                                    <div class="col-sm-12 text-right p-3">
                                        
                                        <button type="button" id="your-id" class="btn btn-green">
                                            <i class="fas fa-plus-circle"></i>&nbsp; Agregar Partida
                                         </button>
                                    </div></form>
                                    <form action="{{ route('internal_orders.store')}}" method="POST"  enctype="multipart/form-data" >
                                        @csrf
                                    <x-jet-input type="hidden" name="temp_internal_order_id" value="{{ $TempInternalOrders->id }}"/>
                                        
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
                            <div class="form-group">
                                <x-jet-label value="* Categoria" />
                                <select class="form-capture  w-full text-xs uppercase" name="category" id='cat'>
                                        
                                        <option value=" " > </option>
                                        
                                        <option value="Productos" @if($cat=="Productos") selected @endif>Productos</option>
                                        <option value="Servicios" @if($cat=="Servicios") selected @endif>Servicios</option>
                                        <option value="Integracion" @if($cat=="Integracion") selected @endif>Integracion</option>
                                       
                                    
                                </select>
                                <x-jet-input-error for='category' /> 
                            <div class="form-group">
                                <x-jet-label value="* Descripción del Proyecto" />
                                <select class="form-capture  w-full text-xs uppercase" name="description" id='desc'>
                                        <option value="Producto Fabricacion" @if($desc=="Producto Fabricacion") selected @endif>Producto fabricacion PF</option>
                                        <option value="Producto Comercializacion"  @if($desc=="Producto Comercializacion") selected @endif>Producto Comercializacion  PC</option>
                                        <option value="Servicio directo SD"  @if($desc=="Servicio directo SD") selected @endif>Servicio directo SD</option>
                                        <option value="Servicio indirecto SI"  @if($desc=="Servicio indirecto SI") selected @endif >Servicio indirecto SI</option>
                                        <option value="PF+SD" @if($desc=="PF+SD") selected @endif>PF+SD</option>
                                        <option value="PF+SI" @if($desc=="PF+SI") selected @endif>PF+SI</option>
                                        <option value="PC+SD" @if($desc=="PC+SD") selected @endif>PC+SD</option>
                                        <option value="PC+SI" @if($desc=="PC+SI") selected @endif>PC+SI</option>
                                       
                                </select><x-jet-input-error for='description' />
                            </div>
                    
                            <div class="row">
                                <div class="col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <x-jet-label value="Observaciones"  />
                                        <textarea  name="observations" id="observations"  rows="5" class="w-full text-xs inputjet" onkeyup="javascript:this.value=this.value.toUpperCase();"> {{$obs}}</textarea>
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
<script>
var form = document.getElementById("form-id");
document.getElementById("your-id").addEventListener("click", function () {
  form.submit();
});
</script>

<script>
    
document.getElementById("observations").addEventListener("input", function(){
   document.getElementById("session_obs").value = this.value;
   console.log(document.getElementById("session_obs").value)
    }); 

document.getElementById("cat").addEventListener("input", function(){
   document.getElementById("session_cat").value = this.value;
   console.log(document.getElementById("session_cat").value)
    }); 

document.getElementById("desc").addEventListener("input", function(){
   document.getElementById("session_desc").value = this.value;
   console.log(document.getElementById("session_desc").value)
    }); 
</script>
@stop