@extends('adminlte::page')

@section('title', 'CONTRATO')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-file"></i>&nbsp; Contrato </h1>
@stop

@section('content')
<div class="container bg-gray-300 shadow-lg rounded-lg">
    <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
        <h5 class="card-title p-2">
            <i class="fas fa-plus-circle"></i>&nbsp; Contrato:
        </h5>
    </div>

    <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
        <div class="row p-4">
            <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('internal_orders.save_contrat') }}"  method="POST" enctype="multipart/form-data">
                            @csrf
                            <x-jet-input type="hidden" name="order_id" value="{{$InternalOrder->id}}" />
                            
                                   <div class="form-group">
                                        <x-jet-label value="Observaciones"  />
                                        <textarea  name="observations" id="observations"  rows="5" class="w-full text-xs inputjet" onkeyup="javascript:this.value=this.value.toUpperCase();"> {{$InternalOrder->contrat_observations}}</textarea>
                                        <x-jet-input-error for='observations' />
                                    </div>
                                    

                                    <div class="form-group">
                                        <label for="contrat">Archivo de contrato en pdf</label>
                                        <input type="file" class="form-control" id="contrat" name="contrat" accept="application/pdf, application/vnd.ms-excel" ">
                                        <x-jet-input-error for='contrat' />
                                    </div>
                               @if($Contrato=='SI') 
                                    
                                    <a href="{{route('internal_orders.show_contrat',$InternalOrder->id)}}">   <button type = "button" class="btn btn-blue" style="background-color: rgba(38, 71, 220, 1);color: white;" mb-2" > <i class="fas fa-file"> </i>  &nbsp; VER ARCHIVO ANTERIOR</button></a>
                               @else
                               <P>AUN NO HAY UN CONTRATO GUARDADO </P>
                               @endif


                            <div class="w-100"><hr></div>

                            <div class="col-12 text-right p-2 gap-2">
                                <button type="submit"   class="btn btn-green mb-2">
                                    <i class="fas fa-save fa-2x"></i>&nbsp;&nbsp; Guardar
                                </button>
                                <a href="{{ route('internal_orders.index') }}" class="btn btn-black mb-2">
                                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')

@stop

@push('js')

@if (session('contrat') == 'void')
<script>
      Swal.fire({
            icon: 'error',
            title: "<i>CONTRATO VACIO</i>", 
            html: `Porfavor seleccione un archivo pdf valido` ,  
                    showCancelButton: false,
                    showConfirmButton: true,
            });

</script>
 
@endif

@endpush
