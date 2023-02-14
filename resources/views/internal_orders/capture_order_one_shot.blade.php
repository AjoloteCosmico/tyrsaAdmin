@extends('adminlte::page')

@section('title', 'PEDIDO INTERNO')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-clipboard-check"></i>&nbsp; Pedido Interno</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; Editar Pedido Interno:
            </h5>
        
        <form action="{{ route('internal_orders.redefine_order')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-jet-input type="hidden" name="internal_order_id" value="{{$InternalOrders->id}}"/>
        <div class="col-12 text-right p-2 gap-2">
        <div class="form-group">
                                        <x-jet-label value="* Cliente" />
                                        <select class="form-capture  w-full text-xs uppercase" name="customer_id">
                                            @foreach ($Customers as $row)
                                                <option value="{{$row->id}}" @if ($row->id == $InternalOrders->customer_id) selected @endif >{{$row->clave}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='customer_id' />
                                    </div>
            <div class="row">
                            
                                     
                            <div class="col-sm-3 col-xs-12">   
                            <div class="form-group">
                               <x-jet-label value="* Fecha de Emisión " />
                               <x-jet-input type="date" name="reg_date" required class="w-full text-xs" value="{{ $InternalOrders->reg_date }}"/>
                               
                           </div>
                           </div>
                       <div class="col-sm-3 col-xs-12">
                           <div class="form-group">
                               <x-jet-label value="* Entrega de Equipo" />
                               <x-jet-input type="date" name="date_delivery" required class="w-full text-xs" value="{{  $InternalOrders->date_delivery }}"/>
                               <x-jet-input-error for='date_delivery' />
                           </div>
                       </div>
                       <div class="col-sm-3 col-xs-12">
                           <div class="form-group">
                               <x-jet-label value="* Entrega de la Instalación" />
                               <x-jet-input type="date" name="instalation_date" required class="w-full text-xs" value="{{  $InternalOrders->instalation_date}}"/>
                               <x-jet-input-error for='instalation_date' />
                           </div>
                       </div>
                       
                       <div class="col-sm-3 col-xs-12">
                           <div class="form-group">
                               <x-jet-label value="* Tipo de Moneda" />
                               <select class="form-capture  w-full text-xs uppercase" required name="coin_id">
                                   @foreach ($Coins as $row)
                                       <option value="{{$row->id}}" @if ($row->id == $InternalOrders->coin_id) selected @endif >{{$row->coin}}</option>
                                   @endforeach
                               </select>
                               <x-jet-input-error for='coin_id' />
                           </div>
                       </div>
                       <div class="col-sm-3 col-xs-12">
                           <div class="form-group">
                               <x-jet-label value="* Condiciones de Pago" />
                               <select class="form-capture  w-full text-xs uppercase" required name="payment_conditions">
                                   <option value="1">1 PAGO</option>
                                   <option value="2">2 PAGOS</option>
                                   <option value="3">3 PAGOS</option>
                                   <option value="4">4 PAGOS</option>
                                   <option value="5">5 PAGOS</option>
                                   <option value="6">6 PAGOS</option>
                                   <option value="7">7 PAGOS</option>
                                   <option value="8">8 PAGOS</option>
                                   <option value="9">9 PAGOS</option>
                                   <option value="10">10 PAGOS</option>
                                   <option value="11">11 PAGOS</option>
                                   <option value="12">12 PAGOS</option>
                                   <option value="13">13 PAGOS</option>
                                   <option value="14">14 PAGOS</option>
                                   <option value="15">15 PAGOS</option>
                                   <option value="16">16 PAGOS</option>
                                   <option value="17">17 PAGOS</option>
                                   <option value="18">18 PAGOS</option>
                                   <option value="19">19 PAGOS</option>
                                   <option value="20">20 PAGOS</option>
                                   <option value="21">21 PAGOS</option>
                                   <option value="22">22 PAGOS</option>
                                   <option value="23">23 PAGOS</option>
                                   <option value="24">24 PAGOS</option>
                                   <option value="25">25 PAGOS</option>
                                   <option value="26">26 PAGOS</option>
                                   <option value="27">27 PAGOS</option>
                                   <option value="28">28 PAGOS</option>
                                   <option value="29">29 PAGOS</option>
                                   <option value="30">30 PAGOS</option>
                                   <option value="31">31 PAGOS</option>
                                   <option value="32">32 PAGOS</option>
                                   <option value="33">33 PAGOS</option>
                                   <option value="34">34 PAGOS</option>
                                   <option value="35">35 PAGOS</option>
                               </select>
                               <x-jet-input-error for='payment_conditions' />
                           </div>
                       </div>
                   </div>
                   <div class="w-100">&nbsp;</div>
                   <div class="row">
                       <div class="col-sm-12">
                           <div class="form-group">
                               <x-jet-label value="* Vendedor" />
                               <select class="form-capture  w-full text-xs uppercase" name="seller_id">
                                   @foreach ($Sellers as $row)
                                       <option value="{{$row->id}}" @if ($row->id == $InternalOrders->seller_id) selected @endif >{{$row->seller_name}}</option>
                                   @endforeach
                               </select>
                               <x-jet-input-error for='seller_id' />
                           </div>
                           <div class="form-group">
                               <x-jet-label value="* Comision del Vendedor" />
                               <input type="number" name="comision" style='width: 10%;' value="{{$InternalOrders->comision}}"> %
                               <x-jet-input-error for='seller_id' />
                           </div>
                           <div class="form-group">
                               <x-jet-label value=" % Dgi" />
                               <input type="number" name="dgi" style='width: 10%;'> %
                               <x-jet-input-error for='seller_id' />
                           </div>
                           <div class="form-group">
                               <x-jet-label value="Otro" />
                               <input type="number" name="otro" style='width: 10%;'> %
                               <x-jet-input-error for='seller_id' />
                           </div>
                       </div>
                  
               
        <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-12 text-right p-3">
                                        <a href="{{ route('items.create', $InternalOrders->id) }} " class="btn btn-green">
                                            <i class="fas fa-plus-circle"></i>&nbsp; Agregar Partida
                                        </a>
                                    </div>
                                    <div class="col-sm-12 table-responsive">
                                        <table class="table tableitems table-striped text-xs font-medium">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Pda</th>
                                                    <th>Cant</th>
                                                    <th>Unidad</th>
                                                    <th>Familia</th>
                                                    <th>Clave</th>
                                                    <th>Descripción</th>
                                                    <th>P. U.</th>
                                                    <th>Importe</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($Items as $row)
                                                <tr class="text-center">
                                                    <td>{{ $row->item }}</td>
                                                    <td>{{ $row->amount }}</td>
                                                    <td>{{ $row->unit }}</td>
                                                    <td>{{ $row->family }}</td>
                                                    <td>{{ $row->code }}</td>
                                                    <td>{{ $row->description }}</td>
                                                    <td class="text-right">$ {{ number_format($row->unit_price, 2) }}</td>
                                                    <td class="text-right">$ {{ number_format($row->import, 2) }}</td>
                                                    <td><a href="{{ route('items.edit_item', $row->id) }} " class="btn btn-green">
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
                            <button type="submit" class="btn btn-green mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Guardar Cambios
                </button>
                <a href="{{ route('internal_orders.index')}}" class="btn btn-red mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>  
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
<script type="text/javascript">
    function unselect() {
        document.querySelectorAll('[name=shipping_address').forEach((x) => x.checked = false);
    }
</script>

{{--  <script>
    $(document).ready(function()
    {
        $(".shipment_option").click(function(evento)
        {      
            var valor = $(this).val();
          
            if(valor == 'Sí')
            {
                $("#shipment_answer").css("display", "block");
            }else
            {
                $("#shipment_answer").css("display", "none");
            }
        });
    });
</script>  --}}
@stop