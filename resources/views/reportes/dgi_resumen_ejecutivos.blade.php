<h2>SOLO EJECUTIVOS ACTIVOS / SOLO DGI DIRECTO DE VENTAS</h2>
<div class="container px-4 mx-auto">
             <table>
                    <tr>
                    <td>
                            <a href="{{route('reports.generate',[1,'dgi_resumen_ejecutivos',0])}}">
                                  <button class="button btn-lg"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                               
                            </td>
                            <td>
                            <a href="{{route('reports.generate',[1,'dgi_resumen_ejecutivos',1])}}">
                                  <button class="button btn-lg"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                    </tr>

                </table class="table text-xs font-medium table-striped text.center"  id="example3" >

                <table>
                    <thead >    
                        <tr style="border: 2px solid white;">
                            <th style="border: 2px solid white;" rowspan="4">Sin IVA <br>comision <br>generada</th>
                            <th style="border: 2px solid white;" rowspan="4">Pedido Interno</th>
                            <th>No.vendedor</th>
                            @foreach($socios as $row)
                            <th>{{$row->folio}} </th> 
                            @endforeach
                        </tr>
                        <tr style="border: 2px solid white;">
                            <th>Iniciales</th>
                            @foreach($socios as $row)
                            <th>{{$row->iniciales}} </th> 
                            @endforeach
                        </tr>
                        <tr style="border: 2px solid white;">
                            <th>Nombre corto</th>
                            @foreach($socios as $row)
                            <th>{{ ltrim(strrchr($row->seller_name, " "))}} </th> 
                            @endforeach
                        </tr>
                        <tr style="border: 2px solid white;">
                            <th>Comprobante</th>
                            @foreach($socios as $row)
                            <th> Comision $</th> 
                            @endforeach
                        </tr>
                    </thead>
                    @foreach($Cobros as $cobro)
                    
                    @endforeach
                </table>
</div>