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
                                        <input class="form-capture   text-md"  type="number" name="comision" style='width: 40%;' max=5 min=0.01 step=0.01 value=0.01> &nbsp; %</div>
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
                                                    <td><a href="{{ route('edit_temp_comissions', $c->id) }} " class="btn btn-green" style="background-color: rgb(22,163,74);color: white;">
                                                        <button type = "button" class="btn btn-green "> <i class="fas fa-edit"></i> </button>
                                                   </a></td>
                                                   <td><a href="{{ route('delete_temp_comissions', $c->id) }} " class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;"">
                                                        <button type = "button" class="btn btn-red " style="background-color: rgb(220 ,38 ,38);color: white;" > <i class="fas fa-trash"></i> </button>
                                                   </a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            </table>
                                    </div>