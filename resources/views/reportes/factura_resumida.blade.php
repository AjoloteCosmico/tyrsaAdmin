@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-file"></i>&nbsp; FACTURA RESUMIDA</h1>
@stop

@section('content')
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">
  
        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
          <br><br>
          <table><tbody><tr><td>
        <div class="btn-group"  role="group" aria-label="Basic radio toggle button group">
<input type="radio" class="btn-check" name="btnradio1" id="btnradio1" autocomplete="off" checked onclick="Pedido();">
<label class="btn btn-outline-primary" for="btnradio1">Pedido</label>
<input type="radio" class="btn-check" name="btnradio2" id="btnradio2" autocomplete="off" onclick="Cliente();">
<label class="btn btn-outline-primary" for="btnradio2">Cliente</label>
</div> <br><br>&nbsp; <br>
            <div class="row p-4">  </td></tr>
           </tbody></table>
<br><br>
                <div class="col-sm-12 text-center font-bold text-lg">
               
      <div>
               
                <div id='ordenes'  class="col-sm-12 table-responsive">

                <table class="table tablepayments table-striped text-xs font-medium">
  <thead class="thead">
    <tr>
      <th scope="col">Cliente</th>
      <th > Pedido</th>
      <th scope="col">Cantidad</th>
      <th scope="col">---</th>
      <th scope="col">---</th>

    </tr>
  </thead>
  <tbody>
  @foreach ($InternalOrders as $row)
                            <tr class="text-center">
                            
                                <td> <p>{{ $row->customer }}</p></td>
                                
                                <td> {{ $row->invoice }}</td>
                                
                                <td>{{$row->symbol}} {{ number_format($row->total)}} </td>
                               
                                <td>
                                <a href="{{route('reports.generate',[$row->id,'resumen_factura',0])}}">
                                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               </td>
                               
                               <td>
                                <a href="{{route('reports.generate',[$row->id,'resumen_factura',1])}}">
                                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               </td>
                               
                                
                            </tr>
                            @endforeach
  
  </tbody>
</table>
            </div>
            <div id='clientes' style="display:none" class="col-sm-12 table-responsive">

<table class="table tablepayments table-striped text-xs font-medium">
<thead class="thead">
<tr>
<th scope="col">Clave <br> Cliente</th>
<th > Cliente</th>
<th scope="col">---</th>
<th scope="col">---</th>

</tr>
</thead>
<tbody>
@foreach ($Customers as $row)
            <tr class="text-center">
            
                <td> <p>{{ $row->clave }}</p></td>
                
                <td> {{ $row->customer }}</td>
                
                
                <td>
                <a href="{{route('reports.generate',[$row->id,'resumen_factura',0,1])}}">
                  <button class="button"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                  </a>  
               </td>
               
               <td>
                <a href="{{route('reports.generate',[$row->id,'resumen_factura',1,1])}}">
                  <button class="button"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                  </a>  
               </td>
               
                
            </tr>
            @endforeach

</tbody>
</table>
</div></div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    
@stop

@section('js')
<script>
    function Cliente() {
    
    
    var ordenes = document.getElementById('ordenes');
    ordenes.style.display="none";
    var ordenes = document.getElementById('clientes');
    clientes.style.display="block";
    
}


function Pedido() {
  var ordenes = document.getElementById('ordenes');
    ordenes.style.display="block";
    var ordenes = document.getElementById('clientes');
    clientes.style.display="none";
    
}
</script>

@stop