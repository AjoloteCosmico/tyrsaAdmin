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
        
        
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                    
                        <div class="card-body">
                            <div class="row">
                            <h3> Datos del vendedor principal</h3> 
                                <div class="col-sm-12">
            <form action="{{ route('internal_orders.shipment') }}" id ="form-id" method="POST" enctype="multipart/form-data">
            @csrf
        <x-jet-input type="hidden" name="temp_internal_order_id" value="{{ $TempInternalOrders->id }}"/>

                                   
                               
        <div class="form-group">
                                        <x-jet-label value="* Vendedor" />
                                        <select id='seller_id' class="form-capture  w-full text-md uppercase" name="seller_id" style='width: 50%;'>
                                            @foreach ($Sellers as $row)
                                                <option value="{{$row->id}}" @if ($row->id == $p_seller_id) selected @endif >{{$row->seller_name}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='seller_id' />
                                    
                                    </div>
                                    
                                    <div class="col-sm-3 col-xs-5">
                                      <div class="form-group">
                                        <x-jet-label value="* Comision del Vendedor" />
                                        <div class="row">&nbsp;&nbsp;
                                        <input class="form-capture   text-md" value="{{$p_comission}}" type="number" name="comision2" style='width: 40%;' max=100 min=0.01 step=any id='comision2'> &nbsp; %</div>
                                        <x-jet-input-error for='seller_id' />
                                       </div>
                                       
                                    </div>
                                   
                                </form>
                                        
<br><br><br>

<h3> Agregar otras Comisiones: </h3>
<form action="{{ route('guardar_comissions') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-jet-input type="hidden" name="temp_internal_order_id" value="{{ $TempInternalOrders->id }}"/>
            <x-jet-input type="hidden" name="p_seller_id" id="p_seller_id"  value="."/>
            <x-jet-input type="hidden" name="p_comission" id="p_comission" value="."/>

                                    <div class="form-group">
                                        <x-jet-label value="* Vendedor" />
                                        <select class="form-capture  w-full text-md uppercase" name="seller_id" style='width: 50%;'>
                                            @foreach ($Sellers as $row)
                                                <option value="{{$row->id}}" @if ($row->id == old('seller_id')) selected @endif >{{$row->seller_name}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='seller_id' />
                                    
                                    </div>
                                    
                                    <div class="col-sm-3 col-xs-5">
                                      <div class="form-group">
                                        <x-jet-label value="* Comision del Vendedor" />
                                        <div class="row">&nbsp;&nbsp;
                                        <input class="form-capture   text-md"  type="number" name="comision" style='width: 40%;' max=100 min=0.01 step=any value=0.01> &nbsp; %</div>
                                        <x-jet-input-error for='seller_id' />
                                       </div>
                                       
                                    </div>
                                      <div class="form-group">
                                        <x-jet-label value="* Descripcion" />
                                        
                                        <input class="form-capture   text-md"  type="text" name="description" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <x-jet-input-error for='desc' />
                                       </div>
                                    
                                    <button type="submit" class="btn btn-green mb-2">
                                            <i class="fas fa-plus-circle fa-2x"></i>&nbsp; Agregar Comision</button>
                                    </div>
                                    </form>
                                    
                                    &nbsp;
                                    <br><br> 
                                    <div class="col-sm-12 table-responsive">
                                    <table class="table table-striped text-md font-medium" >
                                            <thead>
                                                <tr class="text-center">
                                                   <th>Clave Vendedor</th>
                                                    <th>Vendedor</th>
                                                    <th>Comision</th>
                                                    
                                                    <th>Descripcion</th>
                                                    <th></th>
                                                    <th></th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($Comisiones as $c)
                                                <tr class="text-center">
                                                    
                                                    <td>{{$c->iniciales}}</td>
                                                    <td>{{$c->seller_name}}</td>
                                                    <td>{{$c->percentage * 100}} %  </td>
                                                    
                                                    <td>{{$c->description}}  </td>
                                                    <td><a href="{{ route('edit_temp_comissions', $c->id) }} " class="btn btn-green">
                                                        <button type = "button" class="btn btn-green "> <i class="fas fa-edit"></i> </button>
                                                   </a></td>
                                                   <td><a href="{{ route('delete_temp_comissions', $c->id) }} " class="btn btn-red">
                                                        <button type = "button" class="btn btn-red "> <i class="fas fa-trash"></i> </button>
                                                   </a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100"><hr></div>
                           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                {{--  <a href="{{ route('internal_orders.index')}}" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>  --}}
        
                <button type="button" id='your-id' class="btn btn-green mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Guardar
                </button>
            </div>
        </div>
        
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

@if ($Message == 'duplicated')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/duplicated_seller_comission.js') }}"></script>
@endif
@if ($Message == 'error_principal')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/error_principal_seller_comission.js') }}"></script>
@endif

<script>

document.getElementById("comision2").addEventListener("input", function(){
   document.getElementById("p_comission").value = this.value;
   console.log(document.getElementById("p_comission").value)
    }); 
    
document.getElementById("seller_id").addEventListener("input", function(){
   document.getElementById("p_seller_id").value = this.value;
   console.log(document.getElementById("p_seller_id").value )
    }); 
    
</script>
@stop