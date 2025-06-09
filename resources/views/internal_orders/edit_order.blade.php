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
        <div class="col-12  p-2 gap-2">
        <!-- <div class="form-group">
                                        <x-jet-label value="* Cliente" />
                                        <select class="form-capture  w-full text-xs uppercase" name="customer_id">
                                            @foreach ($Customers as $row)
                                                <option value="{{$row->id}}" @if ($row->id == $InternalOrders->customer_id) selected @endif >{{$row->clave}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='customer_id' />
                                    </div> -->
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
                               <x-jet-label value="* Condiciones de COBRO" />
                               <select class="form-capture  w-full text-xs uppercase" required name="payment_conditions">
                                   <option value="1" @if($InternalOrders->payment_conditions ==1) selected @endif>1 COBRO</option>
                                   <option value="2" @if($InternalOrders->payment_conditions ==2) selected @endif>2 COBROS</option>
                                   <option value="3" @if($InternalOrders->payment_conditions ==3) selected @endif>3 COBROS</option>
                                   <option value="4" @if($InternalOrders->payment_conditions ==4) selected @endif>4 COBROS</option>
                                   <option value="5" @if($InternalOrders->payment_conditions ==5) selected @endif>5 COBROS</option>
                                   <option value="6" @if($InternalOrders->payment_conditions ==6) selected @endif>6 COBROS</option>
                                   <option value="7" @if($InternalOrders->payment_conditions ==7) selected @endif>7 COBROS</option>
                                   <option value="8" @if($InternalOrders->payment_conditions ==8) selected @endif>8 COBROS</option>
                                   <option value="9" @if($InternalOrders->payment_conditions ==9) selected @endif>9 COBROS</option>
                                   <option value="10" @if($InternalOrders->payment_conditions ==10) selected @endif>10 COBROS</option>
                                   <option value="11" @if($InternalOrders->payment_conditions ==11) selected @endif>11 COBROS</option>
                                   <option value="12" @if($InternalOrders->payment_conditions ==12) selected @endif>12 COBROS</option>
                                   <option value="13" @if($InternalOrders->payment_conditions ==13) selected @endif>13 COBROS</option>
                                   <option value="14" @if($InternalOrders->payment_conditions ==14) selected @endif>14 COBROS</option>
                                   <option value="15" @if($InternalOrders->payment_conditions ==15) selected @endif>15 COBROS</option>
                                   <option value="16" @if($InternalOrders->payment_conditions ==16) selected @endif>16 COBROS</option>
                                   <option value="17" @if($InternalOrders->payment_conditions ==17) selected @endif>17 COBROS</option>
                                   <option value="18" @if($InternalOrders->payment_conditions ==18) selected @endif>18 COBROS</option>
                                   <option value="19" @if($InternalOrders->payment_conditions ==19) selected @endif>19 COBROS</option>
                                   <option value="20" @if($InternalOrders->payment_conditions ==20) selected @endif>20 COBROS</option>
                                   <option value="21" @if($InternalOrders->payment_conditions ==21) selected @endif>21 COBROS</option>
                                   <option value="22" @if($InternalOrders->payment_conditions ==22) selected @endif>22 COBROS</option>
                                   <option value="23" @if($InternalOrders->payment_conditions ==23) selected @endif>23 COBROS</option>
                                   <option value="24" @if($InternalOrders->payment_conditions ==24) selected @endif>24 COBROS</option>
                                   <option value="25" @if($InternalOrders->payment_conditions ==25) selected @endif>25 COBROS</option>
                                   <option value="26" @if($InternalOrders->payment_conditions ==26) selected @endif>26 COBROS</option>
                                   <option value="27" @if($InternalOrders->payment_conditions ==27) selected @endif>27 COBROS</option>
                                   <option value="28" @if($InternalOrders->payment_conditions ==28) selected @endif>28 COBROS</option>
                                   <option value="29" @if($InternalOrders->payment_conditions ==29) selected @endif>29 COBROS</option>
                                   <option value="30" @if($InternalOrders->payment_conditions ==30) selected @endif>30 COBROS</option>
                                   <option value="31" @if($InternalOrders->payment_conditions ==31) selected @endif>31 COBROS</option>
                                   <option value="32" @if($InternalOrders->payment_conditions ==32) selected @endif>32 COBROS</option>
                                   <option value="33" @if($InternalOrders->payment_conditions ==33) selected @endif>33 COBROS</option>
                                   <option value="34" @if($InternalOrders->payment_conditions ==34) selected @endif>34 COBROS</option>
                                   <option value="35" @if($InternalOrders->payment_conditions ==35) selected @endif>35 COBROS</option>
                                   <option value="35" @if($InternalOrders->payment_conditions ==36) selected @endif>36 COBROS</option>
                                   <option value="35" @if($InternalOrders->payment_conditions ==37) selected @endif>37 COBROS</option>
                               </select>
                               <x-jet-input-error for='payment_conditions' />
                           </div>
                       </div>
                       
                       <div class="form-group">
       <x-jet-label value="Numero de Cotizacion" />
       <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
<input type="radio" class="btn-check" name="btnradio5" id="btnradio5" autocomplete="off" checked onclick="manual('ncotizacion');">
<label class="btn btn-outline-primary" for="btnradio5">Si</label>
<input type="radio" class="btn-check" name="btnradio6" id="btnradio6" autocomplete="off" onclick="automatico('ncotizacion');">
<label class="btn btn-outline-primary" for="btnradio6">No</label>
</div>
<br> <br>

       <input type="text"  onkeyup="javascript:this.value=this.value.toUpperCase();" name="ncotizacion" style='width: 10%;' id='ncotizacion' value="{{$InternalOrders->ncotizacion}}">
       <x-jet-input-error for='ncotizacion' />
   </div>

<div class="form-group">
       <x-jet-label value="Numero de Contrato" />
       <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
<input type="radio" class="btn-check" name="btnradio1" id="btnradio1" autocomplete="off" checked onclick="manual('ncontrato');">
<label class="btn btn-outline-primary" for="btnradio1">Si</label>
<input type="radio" class="btn-check" name="btnradio2" id="btnradio2" autocomplete="off" onclick="automatico('ncontrato');">
<label class="btn btn-outline-primary" for="btnradio2">No</label>
</div>
<br> <br>

       <input type="text"  onkeyup="javascript:this.value=this.value.toUpperCase();" name="ncontrato" style='width: 10%;' id='ncontrato'  value="{{$InternalOrders->ncontrato}}">
       <x-jet-input-error for='seller_id' />
   </div>
   <div class="form-group">
       <x-jet-label value="Orden de Compra" />
       <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
<input type="radio" class="btn-check" name="btnradio3" id="btnradio3" autocomplete="off" checked onclick="manual('oc');">
<label class="btn btn-outline-primary" for="btnradio3">Si</label>
<input type="radio" class="btn-check" name="btnradio4" id="btnradio4" autocomplete="off" onclick="automatico('oc');">
<label class="btn btn-outline-primary" for="btnradio4">No</label>
</div>
<br> <br>

       <input type="text"  onkeyup="javascript:this.value=this.value.toUpperCase();" name="oc" style='width: 10%;' id='oc'  value="{{$InternalOrders->oc}}">
       <x-jet-input-error for='seller_id' />
   </div>
   <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <h1 class="h2 text-center font-bold text-xs uppercase">Direcciones de Embarque</h1>
                                    <div class="col-sm-12 col-xs-12 text-right p-3">
                                        <a href="{{ route('customers_shipping_address.show_real', [0,$InternalOrders->id]) }}" class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
                                            <i class="fas fa-plus-circle"></i>&nbsp; Agregar Domicilio
                                        </a>
                                    </div>
                                    <div class="col-sm-12 col-xs-12 table-responsive">
                                        <table class="table tableshippingaddress table-striped text-xs font-medium">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Domicilio</th>
                                                    <th>Dirección</th>
                                                    <th>Colonia</th>
                                                    <th>C.P.</th>
                                                    <th>Select</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($CustomerShippingAddresses as $row)
                                                <tr class="text-center">
                                                    <td>{{$row->customer_shipping_alias}}</td>
                                                    <td>{{$row->customer_shipping_street.' '.$row->customer_shipping_outdoor}}</td>
                                                    <td>{{$row->customer_shipping_city}}</td>
                                                    <td>{{$row->customer_shipping_zip_code}}</td>
                                                    <td><input type="radio" required name="shipping_address" value="{{$row->id}}" 
                                                        @if ($InternalOrders->customer_shipping_address_id == $row->id)
                                                            checked
                                                        @endif>
                                                    </td>
                                                    <td class="w-5">
                                                        <div class="row">
                                                            <div class="col-6 text-center w-10">
                                                                 @can('EDITAR DIRECCIONES') 
                                                                 <button  class="btn btn-blue h-9 w-9  " style="background-color: rgb(37 ,99 ,235 );color: white;" type="button"><a href="{{ route('customers_shipping_address.editb', [$row->id,0,$InternalOrders->id])}}">
                                                                    <i class="fas fa-edit"></i></span>
                                                                </a>  </button>
                                                                 @endcan 
                                                            </div>
                                                            <div class="col-6 text-center w-10">
                                                                 @can('BORRAR DIRECCIONES') 
                                                                 <a class="DeleteReg" href="{{ route('customers_shipping_address.borrar', [$row->id, 0,$InternalOrders->id]) }}" method="POST">
                                                                  
                                                                    <button type="button" onclick="return confirm('Are you sure?')" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" h-9 w-9">
                                                                        <i class="fas fa-trash items-center"></i>
                                                                    </button>
                                                                  </a>  
                                                                 @endcan 
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <x-jet-input-error for='shipping_address' />
                                    </div>
                                </div>
                            </div>
                            <div class="w-100">&nbsp;</div>
                            <div class="row">
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <x-jet-label value="* Se Embarca" />
                                        <input type="radio" name="shipment" class="shipment_option" value="Sí" @if($InternalOrders->shipment=="Sí") checked @endif >&nbsp; Sí &nbsp; &nbsp;
                                        <input type="radio" name="shipment" class="shipment_option" value="No" @if($InternalOrders->shipment=="No") checked @endif >&nbsp; No
                                        <x-jet-input-error for='shipment' />
                                    </div>
                                </div>
                            </div>
                            <div class="w-100"><hr></div>
                   </div>
                   <div class="w-100">&nbsp;</div>
                   <div class="row">
                       <div class="col-sm-12">
                         @can('VER DGI')
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
                               <input type="number" name="comision" style='width: 10%;' max=100 min=0 step=any value="{{$InternalOrders->comision* 100}}"> %
                               <x-jet-input-error for='comision' />
                           </div>
                         @endcan

                           <div class="form-group">
                                <x-jet-label value="* Categoria" />
                                <select class="form-capture  w-full text-xs uppercase" name="category" id='cat'>
                                        
                                        <option value=" " > </option>
                                        
                                        <option value="Productos" @if($InternalOrders->category=="Productos") selected @endif>Productos</option>
                                        <option value="Servicios" @if($InternalOrders->category=="Servicios") selected @endif>Servicios</option>
                                        <option value="Integracion" @if($InternalOrders->category=="Integracion") selected @endif>Integracion</option>
                                       
                                </select>
                                <x-jet-input-error for='category' /> 
                            <div class="form-group">
                                <x-jet-label value="* Descripción del Proyecto" />
                                <select class="form-capture  w-full text-xs uppercase" name="description" id='desc'>
                                        <option value="Producto Fabricacion" @if($InternalOrders->description=="Producto Fabricacion") selected @endif>Producto fabricacion PF</option>
                                        <option value="Producto Comercializacion"  @if($InternalOrders->description=="Producto Comercializacion") selected @endif>Producto Comercializacion  PC</option>
                                        <option value="Servicio directo SD"  @if($InternalOrders->description=="Servicio directo SD") selected @endif>Servicio directo SD</option>
                                        <option value="Servicio indirecto SI"  @if($InternalOrders->description=="Servicio indirecto SI") selected @endif >Servicio indirecto SI</option>
                                        <option value="PF+SD" @if($InternalOrders->description=="PF+SD") selected @endif>PF+SD</option>
                                        <option value="PF+SI" @if($InternalOrders->description=="PF+SI") selected @endif>PF+SI</option>
                                        <option value="PC+SD" @if($InternalOrders->description=="PC+SD") selected @endif>PC+SD</option>
                                        <option value="PC+SI" @if($InternalOrders->description=="PC+SI") selected @endif>PC+SI</option>
                                       
                                </select><x-jet-input-error for='description' />
                            </div>
                    
                            <div class="row">
                                <div class="col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <x-jet-label value="Observaciones"  />
                                        <textarea  name="observations" id="observations"  rows="5" class="w-full text-xs inputjet" onkeyup="javascript:this.value=this.value.toUpperCase();"> {{$InternalOrders->observations}}</textarea>
                                        <x-jet-input-error for='observations' />
                                    </div>
                                </div>
                            </div>
                            
                          @can('VER DGI')
                           <div class="form-group">
                               <x-jet-label value=" % Dgi" />
                               <input type="number" name="dgi" style='width: 10%;' max=100 min=0 step=0.1 value="{{$InternalOrders->dgi * 100}}"> %
                               <x-jet-input-error for='seller_id' />
                           </div>
                           @endcan
                           <div class="form-group">
                               <x-jet-label value="Descuento" />
                               <input type="number" name="descuento" style='width: 10%;' max=100 min=0 step=0.1  value="{{$InternalOrders->descuento * 100}}"> %
                               <x-jet-input-error for='descuento' />
                           </div>
                           
                           <div class="form-group">
                               <x-jet-label value="Retencion IVA" />
                               <input type="number" name="tasa" style='width: 10%;' max=100 min=0 step=0.1  value="{{$InternalOrders->tasa * 100}}"> %
                               <x-jet-input-error for='descuento' />
                           </div>
                       </div>
                       <div class="form-group">
                               <x-jet-label value="Kilos totales del pedido" />
                               <input type="number" name="kilos" style='width: 10%;' min=0 step=0.01  value="{{$InternalOrders->kilos}}"> 
                               <x-jet-input-error for='descuento' />
                           </div>
               
                            <button type="submit" class="btn btn-green mb-2" style="background-color: rgb(22,163,74);color: white;">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Guardar Cambios
                </button>
                <a href="{{ route('internal_orders.show',$InternalOrders->id)}}" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>  </form>
           <h3 style="color:red"><b>Hasta aqui el formulario de datos generales de la orden, porfavor guarde los cambios aqui, si se han modificado</b></h3> 

                <br><br>

<h1>Agregar o editar Partidas:</h1>
<br>
                <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-12 text-right p-3">
                                        <a href="{{ route('items.creation', $InternalOrders->id) }} " class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
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
                                                    <td >$ {{ number_format($row->unit_price, 2) }}</td>
                                                    <td >$ {{ number_format($row->import, 2) }}</td>
                                                    <td>
                                                        <div class="row">
                                                             <div class="col-6 text-center w-10">
                                                                <a href="{{ route('items.edit_item', [$row->id,1]) }} " >
                                                                <button type = "button" class="btn btn-green btn-lg"> <i class="fas fa-edit"></i> </button>
                                                                </a>
                                                             </div>

                                                             <div class="col-6 text-center w-10">
                                                             @can('BORRAR PEDIDOS')
                                        <form class="DeleteReg" action="{{route('items.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" btn-lg ">
                                                <i class="fas fa-trash"></i>
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
                                        <br><br>
                                        
                       </div>
                                        {{--  <x-jet-input type="hidden" name="item" class="w-flex text-xs" value="{{ $ITEM }}"/>
                                        <x-jet-input-error for='item' />  --}}
                                    </div>
<br><br>
@can('VER DGI')

<h1>Agregar o editar Comisiones:</h1>
<br>
                <form action="{{ route('store_comissions') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-jet-input type="hidden" name="internal_order_id" value="{{ $InternalOrders->id }}"/>
            <x-jet-input type="hidden" name="origin" value="edit_order"/>
            <x-jet-input type="hidden" name="p_seller_id" id="p_seller_id"  value="."/>
            <x-jet-input type="hidden" name="p_comission" id="p_comission" value="."/>
    <div class ="row" >
                                    <div class="form-group">
                                        <x-jet-label value="* Vendedor" />
                                        <select class="form-capture  w-full text-md uppercase" name="seller_id" style='width: 50%;'>
                                            @foreach ($Sellers as $row)
                                                <option value="{{$row->id}}" @if ($row->id == old('seller_id')) selected @endif >{{$row->seller_name}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='seller_id' />
                                    </div>
                                    
                                      <div class="form-group">
                                        <x-jet-label value="* Comision del Vendedor" />
                                        
                                        <input class="form-capture   text-md"  type="number" name="comision" style='width: 20%;' max=100 min=0.01 step=any value=0.01>  %
                                        <x-jet-input-error for='seller_id' />
                
                                    </div>
                                      <div class="form-group">
                                        <x-jet-label value="* Descripcion" />
                                        
                                        <input class="form-capture   text-md"  type="text" name="description" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <x-jet-input-error for='desc' />
                                       </div>
                                    </div>
                                    <button type="submit" class="btn btn-green mb-2">
                                            <i class="fas fa-plus-circle fa-2x"></i>&nbsp; Agregar Comision</button>
                                    
                                    </form>
                                    </div>
                
            
       
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
                    <td><a href="{{ route('edit_comissions', [$c->id,'edit_order']) }} " class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
                        <button type = "button" class="btn btn-green "> <i class="fas fa-edit"></i> </button>
                    </a></td>
                    <td><a href="{{ route('delete_comissions', [$c->id,'edit_order']) }} " class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;"">
                        <button type = "button" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" > <i class="fas fa-trash"></i> </button>
                    </a></td>
                </tr>
                @endforeach
            </tbody>
                    
                </table>
      
                </div>
                @endcan
                <br><br>
                <a href="{{ route('internal_orders.show',$InternalOrders->id)}}" class="btn btn-green mb-2">
                    <i class="fa fa-sign-out"></i>&nbsp;&nbsp; Salir
                </a>  </form>

                <br><br>
                </div>
            </div>
        </div>
        
    </div>
@stop

@section('css')
     <!-- Bootstrap 5.0 -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
        <!-- Font Awesome 6 Kit LEPER SYSTEMS -->
        <script src="https://kit.fontawesome.com/1bfa36884d.js" crossorigin="anonymous"></script>
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <!-- Load Source Sans Pro font -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" rel="stylesheet">
        <!-- Load Nunito font -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Load Roboto font -->
        <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext" rel="stylesheet">
        <!-- Load Amaranth font -->
        <link href="https://fonts.googleapis.com/css2?family=Amaranth:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

        <!-- DataTables -->
    	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.3.1/dt-1.10.25/af-2.3.7/b-1.7.1/b-print-1.7.1/cr-1.5.4/date-1.1.0/fc-3.3.3/fh-3.1.9/kt-2.6.2/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.4/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css"/>

        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('vendor/img/ico/apple-touch-icon-144.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('vendor/img/ico/apple-touch-icon-114.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('vendor/img/ico/apple-touch-icon-72.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('vendor/img/ico/apple-touch-icon-57.png') }}">
        <link rel="shortcut icon" href="{{ asset('vendor/img/ico/favicon.ico') }}">

        <!-- My Style -->
        <link href="{{ asset('vendor/mystylesjs/css/datatable_gral.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    
@stop

@push('js')

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('eliminar') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/confirm_delete_reg.js') }}"></script>
@endif

@if (session('error_delete') == 'ok')
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/error_delete_reg.js') }}"></script>
@endif

<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tableitems.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/mystylesjs/js/tableshipping_addresses.js') }}"></script>
<script type="text/javascript">
    function unselect() {
        document.querySelectorAll('[name=shipping_address').forEach((x) => x.checked = false);
    }
</script>

<script>
    function automatico(campo) {
    console.log(campo);
    
    var entrada = document.getElementById(campo);
    entrada.style.display="none";
    entrada.value=0;
}


function manual(campo) {
    var entrada = document.getElementById(campo);
    console.log(campo);
    
    entrada.style.display="block";
}

@if($InternalOrders->ncotizacion==0)
automatico('ncotizacion');
@endif
@if($InternalOrders->ncontrato==0)
automatico('ncontrato');
@endif
@if($InternalOrders->oc==0)
automatico('oc');
@endif
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
@endpush