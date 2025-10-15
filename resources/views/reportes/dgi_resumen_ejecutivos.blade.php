<h2>SOLO EJECUTIVOS ACTIVOS / SOLO DGI DIRECTO DE VENTAS</h2>
<h2>SE REPORTAN COMPROBANTES CON FECHA DEL {{$StartDate}} AL {{$EndDate}} </h2>

<div class="container px-4 mx-auto">
             <table>
                    <tr>
                    <td>
                            <a href="{{route('reports.generate',[$Quincena,'dgi_resumen_ejecutivos',0])}}">
                                  <button class="button btn-lg"> <span class="badge badge-success">Excel &nbsp; <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                            <td>
                            <a href="{{route('reports.generate',[$Quincena,'dgi_resumen_ejecutivos',1])}}">
                                  <button class="button btn-lg"> <span class="badge badge-danger">PDF &nbsp;<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></span> </button>
                                  </a>  
                            </td>
                    </tr>

                </table  >

                <table class="table text-xs font-medium table-striped text.center"  id="example4" style="table, th, td { border: 1px solid white;}">
                    <thead >    
                        <tr style="border: 2px solid white;">
                           <th style="border: 2px solid white;width:5%" rowspan="4">Pedido Interno</th>
                            <th>No.vendedor</th>
                            @foreach($socios as $row)
                            <th>{{$row->folio}} </th> 
                            @endforeach
                             <th style="border: 2px solid white;" rowspan="4">Sin IVA <br>comision <br>generada</th>
                            
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
                    $totales=[];
                        foreach($socios as $row){
                        $totales+=[$row->iniciales => 0];
                        }
                    @endphp
                    @foreach($Cobros as $cobro)
                       @php
                       $this_comissions=$Comisiones->where('order_id',$cobro->order_id);
                       $total_sum=$total_sum+($cobro->amount/1.16)*$this_comissions->sum('percentage')
                       @endphp
                    <tr>
                        <td> <center>{{$cobro->invoice}}</center> </td>
                        <td><center>{{$cobro->comp}} </center></td>
                        @foreach($socios as $row)
                           
                            @if($row->id==$cobro->seller_id)
                                @php
                                
                                $totales[$row->iniciales]+=($cobro->amount/1.16)*$cobro->comision;
                                @endphp

                            @elseif($this_comissions->where('seller_id',$row->id)->where('description','DGI')->count()>0)
                                @php
                                $totales[$row->iniciales]+=($cobro->amount/1.16)*$this_comissions->where('seller_id',$row->id)->where('description','!=','DGI')->sum('percentage');
                                 @endphp
                            @else 
                                
                            @endif
                            <td><center>${{number_format(($cobro->amount/1.16)*$this_comissions->where('seller_id',$row->id)->where('description', '!=', 'compartida')->sum('percentage'),2)}} </center> </td> 
                       
                        @endforeach
                         <td><center>${{number_format(($cobro->amount/1.16)* $this_comissions->where('description','!=', 'compartida')->sum('percentage'),2)}}</center> </td>
                        
                    </tr>
                    @endforeach
                    <tfoot>
                    <tr class="text-center">
                       
                       <th></th>
                       <th></th>
                       @foreach($socios as $row)
                           <th><center></center> </th>
                        @endforeach
                        <th> <center> </center></th>
                    </tr>
                   <tr>
                        <th></th>
                        <th></th>
                    @foreach($socios as $row)
                         <th> <center> {{ ltrim(strrchr($row->seller_name, " "))}}</center> </th> 
                    @endforeach
                    <th><center> Totales</center></th>
                    </tr>
                    <tr>
                        
                        <th></th>
                        <th>DGI</th>
                        @foreach($socios as $row)
                           <td> </td>
                        @endforeach
                        <th></th>
                    </tr>
                    <tr>
                       
                        <th></th>
                        <th>Comisiones</th>
                        @foreach($socios as $row)
                           <td><center>${{number_format($totales[$row->iniciales],2)}} </center> </td>
                        @endforeach
                        <th><center>${{number_format(array_sum($totales),2)}} </center></th>
                    </tr> 
                    <tr>
                        <th></th>
                        <th > Totales </h>
                        @foreach($socios as $row)
                           <td> </td>
                        @endforeach
                        <th></th>
                    </tr> 
                    
                    </tfoot>
                </table>
<br>
                <table>
                    <tr>
                        <tr>
                            <td>Total Comisiones</td>
                            <td id="total_com"></td>
                           
                        </tr>
                         <tr>
                            <td>Total DGI</td>
                            <td id="total_dgi"></td>
                           
                        </tr>
                        <tr>
                            <th>Total egresos Quincena</th>
                            <th id="total_quincena"></th>
                        </tr>
                        
                   
                </table>
</div>