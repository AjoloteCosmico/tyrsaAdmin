<h2>SOLO EJECUTIVOS ACTIVOS / SOLO DGI DIRECTO DE VENTAS</h2>
<h2>SOLO VENDEDORES ACTIVOS / SOLO COMISION DIRECTA DE VENTA</h2>
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

                </table  >

                <table class="table text-xs font-medium table-striped text.center"  id="example4" style="table, th, td { border: 1px solid white;}">
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
                    @php
                    $total_sum=0;
                    @endphp
                    @foreach($Cobros as $cobro)
                       @php
                       $this_comissions=$Comisiones->where('order_id',$cobro->order_id);

                       @endphp
                    <tr>
                        <td>${{number_format($cobro->amount/1.16,2)}}</td>
                        <td>{{$cobro->invoice}} </td>
                        <td>{{$cobro->comp}} </td>
                        @foreach($socios as $row)
                           
                            @if($row->id==$cobro->seller_id)
                            @php
                            $total_sum=$total_sum+($cobro->amount*$cobro->comision)/1.16;
                            @endphp

                                <td>${{number_format(($cobro->amount*$cobro->comision)/1.16,2)}}  </td> <!-- //caso en que es el vendedor princi´pal   -->
                            @elseif($this_comissions->where('seller_id',$row->id)->count()>0)
                            @php
                            $total_sum=$total_sum+($cobro->amount*$this_comissions->where('seller_id',$row->id)->first()->percentage)/1.16;
                            @endphp
                                <td>${{number_format(($cobro->amount*$this_comissions->where('seller_id',$row->id)->first()->percentage)/1.16,2)}}  </td> <!-- //caso en que el vendedor tiene una comision   -->
                            @else 
                                <td> $0 </td>
                            @endif
                        @endforeach
                    </tr>
                    @endforeach
                    <tfoot>
                    <tr>
                       <th> ${{number_format($total_sum,2)}}</th>
                       <th></th>
                       <th></th>
                       @foreach($socios as $row)
                           <th>${{number_format($Cobros->where('seller_id',$row->id)->sum('amount')/1.16,2)}} </th>
                        @endforeach
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        
                       @foreach($socios as $row)
                       <th>{{ ltrim(strrchr($row->seller_name, " "))}} </th> 
                            
                        @endforeach
                    </tr>
                    </tfoot>
                </table>

</div>