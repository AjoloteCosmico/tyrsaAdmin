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
                            <h1>ASIGNAR DGI </h1>
                                        
        <br><br><br>
    @can('ASIGNAR DGI')
        <form action="{{ route('store_comissions') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-jet-input type="hidden" name="internal_order_id" value="{{ $InternalOrders->id }}"/>
            <x-jet-input type="hidden" name="origin" value="edit_dgi"/>
            
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
                                    <table class="table tableitems table-striped text-xs font-medium">
                    <thead>
                        <tr class="text-center">
                    <th>Clave Vendedor</th>
                    <th>Vendedor</th>
                    <th>Comision</th>
                    
                    <th>Descripcion</th>
                    <th></th>
                    <th></th> </tr> </thead>
                    <tbody>
                @foreach($Comisiones as $c)
                <tr class="text-center">
                    
                    <td>{{$c->iniciales}}</td>
                    <td>{{$c->seller_name}}</td>
                    <td>{{$c->percentage * 100}} %  </td>
                    
                    <td>{{$c->description}}  </td>
                    <td><a href="{{ route('edit_comissions', [$c->id,'edit_dgi']) }} " class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
                        <button type = "button" class="btn btn-green "> <i class="fas fa-edit"></i> </button>
                    </a></td>
                    <td>
                        
                    @can('ASIGNAR DGI')
                                        <form class="DeleteReg" action="{{ route('delete_comissions', [$c->id,'edit_dgi']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;"">
                                                <i class="fas fa-trash items-center fa-xl"></i>
                                            </button>
                                        </form>
                                        @endcan

                </td>
                </tr>
                @endforeach
            </tbody>
                    
                </table>
                                    </div>
    @endcan
                                </div>
                            </div>
                            <div class="w-100"><hr></div>
                           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
              
                <a href="{{route('internal_orders.show',$InternalOrders->id)}}"><button type="button" class="btn btn-green mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Terminar
                </button></a>
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



<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/alert_delete_reg.js') }}"></script>
@if (Session::has('duplicated'))
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/duplicated_seller_comission.js') }}"></script>
@endif
@if ($Message == 'error_principal')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/error_principal_seller_comission.js') }}"></script>
@endif

@if (Session::has('borrado'))
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/confirm_delete_reg.js') }}"></script>
@endif

@if (Session::has('created'))
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/confirm_create_reg.js') }}"></script>
@endif
@stop