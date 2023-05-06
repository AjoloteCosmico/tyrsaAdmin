@extends('adminlte::page')

@section('title', 'COMISIONES')

@section('content_header')
    <h1 class="font-bold"><i class="fa-brands fa-buffer"></i>&nbsp; Comisiones</h1>
@stop

@section('content')
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; Editando Comision:
            </h5>
        </div>
        <form action="{{ route('update_comissions',$Comission->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-jet-input type="hidden" name="order_id" value="{{ $InternalOrders->id }}"/>
        
        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                    <div class="card">
                        <div class="card-body">
                        <div class="form-group">
                                        <x-jet-label value="* Vendedor" />
                                        <select class="form-capture  w-full text-md uppercase" name="seller_id" style='width: 50%;'>
                                            @foreach ($Sellers as $row)
                                                <option value="{{$row->id}}" @if ($row->id == $Comission->seller_id) selected @endif >{{$row->seller_name}}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for='seller_id' />
                                    
                                    </div>
                                    
                                    <div class="col-sm-3 col-xs-5">
                                      <div class="form-group">
                                        <x-jet-label value="* Comision del Vendedor" />
                                        <div class="row">&nbsp;&nbsp;
                                        <input class="form-capture   text-md"  type="number" name="comision" style='width: 40%;' max=100 min=0.01 step=any value="{{$Comission->percentage * 100}}"> &nbsp; %</div>
                                        <x-jet-input-error for='seller_id' />
                                       </div>
                                       
                                    </div>
                                      <div class="form-group">
                                        <x-jet-label value="* Descripcion" />
                                        
                                        <input class="form-capture   text-md"  type="text" name="description" value="{{$Comission->description}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <x-jet-input-error for='desc' />
                                       </div>
                                    
                                    
                                  
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                {{--  <a href="{{ route('customers.index')}}" class="btn btn-black mb-2">
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
<script>
$(document).on("keypress", ".just-number", function (e) {
  let charCode = (e.which) ? e.which : e.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  }
});
$(document).on('keyup', '.price-format-input', function (e) {
  let val = this.value;
  val = val.replace(/,/g, "");
  if (val.length > 3) {
    let noCommas = Math.ceil(val.length / 3) - 1;
    let remain = val.length - (noCommas * 3);
    let newVal = [];
    for (let i = 0; i < noCommas; i++) {
      newVal.unshift(val.substr(val.length - (i * 3) - 3, 3));
    }
    newVal.unshift(val.substr(0, remain));
    this.value = newVal;
  }
  else {
    this.value = val;
  }
});

$(document).ready(function(){
  $('#input-price').focus();
})</script>
@stop