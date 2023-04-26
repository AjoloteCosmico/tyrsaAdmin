@extends('adminlte::page')

@section('title', 'Contraportada')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-file"></i>&nbsp;CONTRAPORTADA </h1>
@stop

@section('content')
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-lg">
                
            
               
                <div class="col-sm-12 table-responsive">

                <table id="tableContraportada" class="table tablepayments table-striped text-xs font-medium">
  <thead class="thead">
    <tr>
      <th scope="col">Cliente</th>
      <th > Pedido</th>
      <th>fecha</th>
      <th scope="col">Cantidad</th>
      <th scope="col">---</th>
      <th scope="col">---</th>

    </tr>
  </thead>
  <tbody>
  @foreach ($InternalOrders as $row)
                            <tr class="text-center">
                            <td> {{ $row->invoice }}</td>
                                <td> <p>{{ $row->customer }}</p></td>
                                
                                
                                <td>{{date('d-m-Y', strtotime($row->date)) }}</td>
                                <td>{{$row->symbol}} {{ number_format($row->total)}} </td>
                               
                                <td>
                                <a href="{{route('reports.generate',[$row->id,'contraportada',0])}}">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               </td>
                               
                               <td>
                               <a href="{{route('reports.generate',[$row->id,'contraportada',1])}}">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               </td>
                               
                               
                            </tr>
                            @endforeach
  
  </tbody>
</table>
            </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    
@stop

@section('js')
<script>

$(document).ready(function () {
    $('#tableContraportada').DataTable();
});
</script>


@stop