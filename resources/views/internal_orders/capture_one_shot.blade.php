@extends('adminlte::page')

@section('title', 'PEDIDO INTERNO')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-clipboard-check"></i>&nbsp; Pedido Interno</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; Nuevo Pedido Interno:
            </h5>
        
        <form action="{{ route('internal_orders.redefine_order')}}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="col-12 text-right p-2 gap-2">
        <div class="form-group">
                                        <x-jet-label value="* Cliente" />
                                        <select class="form-capture  w-full text-xs uppercase" name="customer_id">
                                            @foreach ($Customers as $row)
                                                <option value="{{$row->id}}" >{{$row->clave}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='customer_id' />
                                    </div>
            <div class="row">
                            
                                     
                            <div class="col-sm-3 col-xs-12">   
                            <div class="form-group">
                               <x-jet-label value="* Fecha de Emisión " />
                               <x-jet-input type="date" name="reg_date" required class="w-full text-xs" />
                               
                           </div>
                           </div>
                       <div class="col-sm-3 col-xs-12">
                           <div class="form-group">
                               <x-jet-label value="* Entrega de Equipo" />
                               <x-jet-input type="date" name="date_delivery" required class="w-full text-xs" />
                               <x-jet-input-error for='date_delivery' />
                           </div>
                       </div>
                       <div class="col-sm-3 col-xs-12">
                           <div class="form-group">
                               <x-jet-label value="* Entrega de la Instalación" />
                               <x-jet-input type="date" name="instalation_date" required class="w-full text-xs" />
                               <x-jet-input-error for='instalation_date' />
                           </div>
                       </div>
                       
                       <div class="col-sm-3 col-xs-12">
                           <div class="form-group">
                               <x-jet-label value="* Tipo de Moneda" />
                               <select class="form-capture  w-full text-xs uppercase" required name="coin_id">
                                   @foreach ($Coins as $row)
                                       <option value="{{$row->id}}"  >{{$row->coin}}</option>
                                   @endforeach
                               </select>
                               <x-jet-input-error for='coin_id' />
                           </div>
                       </div>
                       <div class="col-sm-3 col-xs-12">
                           <div class="form-group">
                               <x-jet-label value="* Condiciones de Cobro" />
                               <select class="form-capture  w-full text-xs uppercase" required name="payment_conditions">
                                   <option value="1">1 COBRO</option>
                                   <option value="2">2 COBROS</option>
                                   <option value="3">3 COBROS</option>
                                   <option value="4">4 COBROS</option>
                                   <option value="5">5 COBROS</option>
                                   <option value="6">6 COBROS</option>
                                   <option value="7">7 COBROS</option>
                                   <option value="8">8 COBROS</option>
                                   <option value="9">9 COBROS</option>
                                   <option value="10">10 COBROS</option>
                                   <option value="11">11 COBROS</option>
                                   <option value="12">12 COBROS</option>
                                   <option value="13">13 COBROS</option>
                                   <option value="14">14 COBROS</option>
                                   <option value="15">15 COBROS</option>
                                   <option value="16">16 COBROS</option>
                                   <option value="17">17 COBROS</option>
                                   <option value="18">18 COBROS</option>
                                   <option value="19">19 COBROS</option>
                                   <option value="20">20 COBROS</option>
                                   <option value="21">21 COBROS</option>
                                   <option value="22">22 COBROS</option>
                                   <option value="23">23 COBROS</option>
                                   <option value="24">24 COBROS</option>
                                   <option value="25">25 COBROS</option>
                                   <option value="26">26 COBROS</option>
                                   <option value="27">27 COBROS</option>
                                   <option value="28">28 COBROS</option>
                                   <option value="29">29 COBROS</option>
                                   <option value="30">30 COBROS</option>
                                   <option value="31">31 COBROS</option>
                                   <option value="32">32 COBROS</option>
                                   <option value="33">33 COBROS</option>
                                   <option value="34">34 COBROS</option>
                                   <option value="35">35 COBROS</option>
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
                                       <option value="{{$row->id}}"  >{{$row->seller_name}}</option>
                                   @endforeach
                               </select>
                               <x-jet-input-error for='seller_id' />
                           </div>
                           <div class="form-group">
                               <x-jet-label value="* Comision del Vendedor" />
                               <input type="number" name="comision" style='width: 10%;' > %
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
                                        <a href="{{ route('items.create', 5) }} " class="btn btn-green">
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
                                             
                                            </tbody>
                                        </table>
                                        
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