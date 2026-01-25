<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalOrder;
use App\Models\payments;
use App\Models\Customer;
use App\Models\CompanyProfile;
use App\Models\CustomerShippingAddress;
use App\Models\Coin;
use App\Models\historical_payments;
use App\Models\Factures;
use App\Models\Seller;
use App\Models\bank;

use App\Models\Marca;
use App\Models\Medio;
use App\Models\Cobro;
use App\Models\CreditNote;
use App\Models\note_facture;
use App\Models\Item;
use App\Models\report_product;

use App\Http\Requests\StorepaymentsRequest;
use App\Http\Requests\UpdatepaymentsRequest;
use SplFileInfo;
use Illuminate\Support\Facades\Storage;

use DB;
use PDF;
use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException; 
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class ReportsController extends Controller
{
       public function generate($id,$report,$pdf,$tipo=0)
       {  
           $caminoalpoder=public_path();
           $process = new Process(["/var/www/app-env/bin/python3", $caminoalpoder.'/'.$report.'.py',$id,$tipo]);
           $process->setTimeout(300); 
           $process->run();
           if (!$process->isSuccessful()) {
               throw new ProcessFailedException($process);
           }
           
           $data = $process->getOutput();
           if($pdf==0){
               return response()->download(public_path('storage/report/'.$report.$id.'.xlsx'));
           }else{
            //shell_exec('cd'.$caminoalpoder.'/storage/report/;'.' localc --headless --convert-to pdf '.$report.$id.'.xlsx');
             $process2=new Process(['localc','--headless','--convert-to', 'pdf', $report.$id.'.xlsx'],$caminoalpoder.'/storage/report/');
            //$process=new Process(['localc','--headless','--convert-to','pdf','--outdir',$caminoalpoder.'/storage/report/',$report.$id.'.xlsx'],$caminoalpoder.'/storage/report/');
            //$process2 = new Process(["soffice", "--convert-to","pdf:calc_pdf_Export:{\"SinglePageSheets\":{\"type\":\"boolean\",\"value\":\"true\"}}",$report.$id.".xlsx "],$caminoalpoder.'/storage/report/');
            // $process2->setTimeout(null);
            // $process2->setIdleTimeout(null);
             $process2->run();
             if (!$process2->isSuccessful()) {
                throw new ProcessFailedException($process2);
             }
             $data = $process2->getOutput();
             
            return response()->download(public_path('storage/report/'.$report.$id.'.pdf'));
       }}


          public function impresion_pedido($id,$report,$pdf,$tipo=0)
                {  
        //    $caminoalpoder=public_path();
        //    $process = new Process(["/var/www/app-env/bin/python3", $caminoalpoder.'/'.$report.'.py',$id,$tipo]);
        //    ini_set('max_execution_time', '300');  
        // //    dd(env('PY_COMAND'));
        //    $process->run();
        //    if (!$process->isSuccessful()) {
        //        throw new ProcessFailedException($process);
        //    }
           
        //    $data = $process->getOutput();
        //    if($pdf==0){
        //        return response()->download(public_path('storage/report/'.$report.$id.'.xlsx'));
        //    }else{
            //shell_exec('cd'.$caminoalpoder.'/storage/report/;'.' localc --headless --convert-to pdf '.$report.$id.'.xlsx');
             $process2=new Process(['localc','--headless','--convert-to', 'pdf', $report.$id.'.xlsx'],$caminoalpoder.'/storage/report/');
            //$process=new Process(['localc','--headless','--convert-to','pdf','--outdir',$caminoalpoder.'/storage/report/',$report.$id.'.xlsx'],$caminoalpoder.'/storage/report/');
            //$process2 = new Process(["soffice", "--convert-to","pdf:calc_pdf_Export:{\"SinglePageSheets\":{\"type\":\"boolean\",\"value\":\"true\"}}",$report.$id.".xlsx "],$caminoalpoder.'/storage/report/');
            // $process2->setTimeout(null);
            // $process2->setIdleTimeout(null);
             $process2->run();
             if (!$process2->isSuccessful()) {
                throw new ProcessFailedException($process2);
             }
             $data = $process2->getOutput();
             
            return response()->download(public_path('storage/report/'.$report.$id.'.pdf'));
        
       }
    
       public function contraportada()
       {
        if(!Auth::user()->can('DESCARGAR CONTRAPORTADA')){
            return redirect()->route('dashboard');
        }
           $InternalOrders =  DB::table('internal_orders')
           ->join('customers', 'internal_orders.customer_id', '=', 'customers.id')
           ->join('coins', 'internal_orders.coin_id','=','coins.id')
           ->select('internal_orders.*','customers.customer','coins.symbol')
           ->orderByRaw('internal_orders.invoice * 1 asc') 
           ->get();
           return view('reportes.contraportada', compact(
               'InternalOrders',
           ));
       }

   public function contraportada_pdf($id){

    $CompanyProfiles = CompanyProfile::first();
    $comp=$CompanyProfiles->id;
    $InternalOrders = InternalOrder::find($id);
    $Customers = Customer::find($InternalOrders->customer_id);
    $Sellers = Seller::find($InternalOrders->seller_id);
    $CustomerShippingAddresses = CustomerShippingAddress::find($InternalOrders->customer_shipping_address_id);
    $Coins=Coin::find($InternalOrders->coin_id);
    $hpagos=historical_payments::where('order_id',$InternalOrders->id)->get();
    $facturas=Factures::where('order_id',$InternalOrders->id)->get();
    $cobros=DB::table('cobros')
    ->join('internal_orders', 'internal_orders.id', '=', 'cobros.order_id')
    ->join('customers', 'internal_orders.customer_id','=','customers.id')
    ->join('coins', 'internal_orders.coin_id','=','coins.id')
    ->join('factures', 'cobros.facture_id','=','factures.id')
    ->join('banks', 'cobros.bank_id','=','banks.bank_id')
    ->leftjoin('users as capturistas', 'cobros.capturo','=','capturistas.id')
    ->leftjoin('users as revisores', 'cobros.reviso','=','revisores.id')
    ->leftjoin('users as autorizadores', 'cobros.autorizo','=','autorizadores.id')
    ->where('cobros.order_id','=',$InternalOrders->id)
    ->select('cobros.*','customers.customer','customers.clave', 'coins.coin','coins.symbol', 
             'internal_orders.invoice','factures.facture','banks.bank_clue',
             'banks.bank_description','capturistas.name as capturista','revisores.name as revisor','autorizadores.name as autorizador')
    // ->orderBy('internal_orders.invoice', 'DESC')
    ->get();
    
    $max=max($facturas->count(),$hpagos->count(),$cobros->count());
    $pdf = PDF::loadView('reportes.contraportada_pdf', compact(
           'CompanyProfiles',
           'InternalOrders',
           'Customers',
           'Sellers',
           'CustomerShippingAddresses',
           'Coins',
           'hpagos',
           'max',
           'facturas',
           'cobros'));    
    
       $pdf->setPaper('A4', 'landscape');
    return $pdf->download('contraportada_pedido'.$InternalOrders->invoice.'.pdf');   
//     return view('reportes.contraportada_pdf', compact(
//         'CompanyProfiles',
//         'InternalOrders',
//         'Customers',
//         'Sellers',
//         'CustomerShippingAddresses', 
//         'Coins',
//     ));

   }
   public function pedido_pdf($id){

    
      $CompanyProfiles = CompanyProfile::first();
      $comp=$CompanyProfiles->id;
      $InternalOrders = InternalOrder::find($id);
      $Customers = Customer::find($InternalOrders->customer_id);
      $Sellers = Seller::find($InternalOrders->seller_id);
      $CustomerShippingAddresses = CustomerShippingAddress::find($InternalOrders->customer_shipping_address_id);
      $title='chales';
      
      $pdf = PDF::loadView('reportes.test', compact(
             'title',
             'CompanyProfiles',
             'InternalOrders',
             'Customers',
             'Sellers',
             'CustomerShippingAddresses'));    
      return $pdf->download('Pedido_interno'.$InternalOrders->invoice.'.pdf');   
      // return view('reportes.contraportada_pdf', compact(
      //     'CompanyProfiles',
      //     'InternalOrders',
      //     'Customers',
      //     'Sellers',
      //     'CustomerShippingAddresses', 
      // ));
  
     }

     public function cobro_pdf($id){
                    //hacer el pdf
                    $Cobro=Cobro::find($id);
                    $CompanyProfiles = CompanyProfile::first();
                    $comp=$CompanyProfiles->id;
                    $InternalOrders = InternalOrder::find($Cobro->order_id);
                    $Customers = Customer::find($InternalOrders->customer_id);
                    $Sellers = Seller::find($InternalOrders->seller_id);
                    $CustomerShippingAddresses = CustomerShippingAddress::find($InternalOrders->customer_shipping_address_id);
                    $Coins=Coin::find($InternalOrders->coin_id);
                    $Banco=bank::find($Cobro->bank_id);
                    $Factura=Factures::find($Cobro->facture_id);
                    
                    $pdf = PDF::loadView('reportes.test', compact(
                        'CompanyProfiles',
                        'InternalOrders',
                        'Customers',
                        'Sellers',
                        'CustomerShippingAddresses',
                        'Coins','Cobro',
                        'Banco',
                        'Factura'));    
                 
                    $pdf->setPaper('A4', 'landscape');
                 return $pdf->download('Comprobante_Ingresos'.$Cobro->comp.'.pdf');   
                //  
     }
     public function factura_pdf($id){
        //hacer el pdf
        $Factura=Factures::find($id);
        $CompanyProfiles = CompanyProfile::first();
        $comp=$CompanyProfiles->id;
        $InternalOrders = InternalOrder::find($Factura->order_id);
        $Customers = Customer::find($InternalOrders->customer_id);
        $Sellers = Seller::find($InternalOrders->seller_id);
        $CustomerShippingAddresses = CustomerShippingAddress::find($InternalOrders->customer_shipping_address_id);
        $Coins=Coin::find($InternalOrders->coin_id);
        $Factura=Factures::find($id);
        
        $pdf = PDF::loadView('reportes.factura_pdf', compact(
            'CompanyProfiles',
            'InternalOrders',
            'Customers',
            'Sellers',
            'CustomerShippingAddresses',
            'Coins',
            
            'Factura'));    
     
        $pdf->setPaper('A4', 'landscape');
     return $pdf->download('Factura'.$Factura->facture.'.pdf');   
    //  
}
public function note_pdf($id){
    //hacer el pdf
    $Nota=CreditNote::find($id);
    $Linked_factures=DB::table('note_factures')
    ->join('factures','factures.id','=','note_factures.facture_id')
    ->where('note_factures.note_id','=',$id)
    ->select('factures.*')
    ->get(); 
    $CompanyProfiles = CompanyProfile::first();
    $comp=$CompanyProfiles->id;
    $InternalOrders = InternalOrder::find($Nota->order_id);
    $Customers = Customer::find($InternalOrders->customer_id);
    $Sellers = Seller::find($InternalOrders->seller_id);
    $CustomerShippingAddresses = CustomerShippingAddress::find($InternalOrders->customer_shipping_address_id);
    $Coins=Coin::find($InternalOrders->coin_id);
    
    $pdf = PDF::loadView('reportes.nota_pdf', compact(
        'CompanyProfiles',
        'InternalOrders',
        'Customers',
        'Sellers',
        'CustomerShippingAddresses',
        'Coins',
        'Linked_factures',
        'Nota'));    
 
    $pdf->setPaper('A4', 'landscape');
 return $pdf->download('Nota'.$Nota->facture.'.pdf');   
//  
}    
  public function prueba($name){
    return response()->download(public_path('storage/report/'.$name));
           
  }
  public function cuentas_cobrar(){
    if(!Auth::user()->can('DESCARGAR CXC')){
        return redirect()->route('dashboard');
    }
    $InternalOrders =  DB::table('internal_orders')
        ->join('customers', 'internal_orders.customer_id', '=', 'customers.id')
        ->join('coins', 'internal_orders.coin_id','=','coins.id')
        ->join('factures','factures.order_id','=','internal_orders.id')
        ->groupBy('internal_orders.id','internal_orders.invoice','internal_orders.total','customers.customer','coins.symbol')
        ->select('internal_orders.id','internal_orders.invoice','internal_orders.total','customers.customer','coins.symbol')
        ->get();
    $Customers= DB::table('customers')
        ->rightjoin('internal_orders','internal_orders.customer_id','=','customers.id')
        ->join('factures','factures.order_id','=','internal_orders.id')
        ->select('customers.id','customers.clave','customers.customer')
        ->groupBy('customers.id','customers.clave','customers.customer')
        ->get();
        
        return view('reportes.rep_cuentas_cobrar', compact(
            'InternalOrders',  
            'Customers',
        ));
    
  }
 
  public function productos($Monto){
    $CompanyProfiles = CompanyProfile::first();
    $comp=$CompanyProfiles->id;
    $Year=now()->year;
    $Products=report_product::all();
    $Items=DB::table('items')
    ->join('report_products','report_products.id','items.products')
    ->join('internal_orders','items.internal_order_id','internal_orders.id')
    ->select('internal_orders.date','report_products.name','items.*')
    ->where('date','>=',$Year.'-01-01')
    ->get();
    // dd($Items);

    #Grafica vendedores
    if($Monto=='MONTO'){
    #por montn total de pedidos
        $productos = DB::table('report_products')
        ->join('items','report_products.id','items.products')
        ->select('report_products.name')
        ->selectRaw("SUM(items.import) as total")
        ->groupBy('items.products','report_products.name')
        ->orderBy('total','desc')
        ->get();
        $prod_data=$productos->pluck('total')->toArray();
        foreach($prod_data as &$hits) {
        $hits = round(($hits * 100)/ $productos->sum('total'),2);
         }
         $subtitle='Porcentaje del monto total de P.I';
         $meses_title='Suma total del monto de PI en miles de pesos';
         $Mes_axis='Monto total en miles';
         $Mes_data=array();
        for($i=1;$i<=12;$i++){
            array_push($Mes_data,
            (int)($Items->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')
            ->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')
            ->sum('total')/1000));
        }
    }

    else{

    #por total de pedidos
        $productos = DB::table('report_products')
        ->join('items','items.products','=','report_products.id')
        ->select('report_products.name')
        ->selectRaw("COUNT(items.products) as internal_orders_count")
        ->groupBy('items.products','report_products.name')
        ->orderBy('internal_orders_count','desc')
        ->get();
        $prod_data=$productos->pluck('internal_orders_count')->toArray();
        foreach($prod_data as &$hits) {
            $hits = round(($hits * 100)/ $productos->sum('internal_orders_count'),2);
         }
         
        $subtitle='Porcentaje total de P.I';
        $meses_title='Suma total  de PI';
        $Mes_axis='Total de pedidos en el mes';
        $Mes_data=array();
        for($i=1;$i<=12;$i++){
            array_push($Mes_data,
            $Items->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')
            ->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')
            ->count());
        }
    }
    // dd($vendedores);
    
    // dd($ven_data);
    $SellerChart=LarapexChart::pieChart()
    ->setTitle($subtitle)
    ->setSubtitle('Anual productos')
    ->addData($prod_data)
    ->setLabels($productos->pluck('name')->toArray());
    #Grafica por meses
    $Meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
       'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    
    $MesesChart=LarapexChart::lineChart()
    ->setTitle($meses_title)
    ->setSubtitle('Anual')
    ->addData($Mes_axis,$Mes_data)
    ->setLabels($Meses);
    
    return view('reportes.productos',compact(
                   'Products',
                   'Items',
                   'Year',
                   'CompanyProfiles',
                   'comp',
                   'SellerChart',
                    'MesesChart',
                    'Monto',
    ));
  }

  
  //reporte por producto
  public function objetivos($Monto){
    $CompanyProfiles = CompanyProfile::first();
    $comp=$CompanyProfiles->id;
    $Year=now()->year;
    $Sellers=Seller::where('status','ACTIVO')->get();
    $InternalOrders=DB::table('internal_orders')
    ->join('sellers','sellers.id','internal_orders.seller_id')
    ->join('coins','internal_orders.coin_id','coins.id')
    ->select('internal_orders.*','sellers.seller_name', DB::raw('(coins.exchange_sell * internal_orders.total) as exchange_total'))
    ->where('date','>=',$Year.'-01-01')
    ->where('sellers.status','ACTIVO')
    ->get();
    // dd($InternalOrders);

    #Grafica vendedores
    if($Monto=='MONTO'){

    #por montn total de pedidos
        $vendedores = DB::table('sellers')
        ->where('sellers.status','ACTIVO')
        ->join('internal_orders','internal_orders.seller_id','=','sellers.id')
        ->where('internal_orders.date','>=',$Year.'-01-01')
        ->select('sellers.seller_name')
        ->selectRaw("SUM(internal_orders.total) as total")
        ->groupBy('internal_orders.seller_id','sellers.seller_name')
        ->orderBy('total','desc')
        ->get();
        // dd($vendedores);
        $ven_data=$vendedores->pluck('total')->toArray();
        foreach($ven_data as &$hits) {
        $hits = round(($hits * 100)/ $vendedores->sum('total'),2);
         }
         $subtitle='Porcentaje del monto total de P.I';
         $meses_title='Suma total del monto de PI en miles de pesos';
         $Mes_axis='Monto total en miles';
        $Mes_data=array();
        for($i=1;$i<=12;$i++){
            array_push($Mes_data,
            (int)(($InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')
            ->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')
            ->sum('total')/1.16)/1000));
        }
    }

    else{

    #por total de pedidos
        $vendedores = Seller::withCount('internalOrders')
        ->where('status','ACTIVO')
        ->orderBy('internal_orders_count','desc')
        ->get();
        $ven_data=$vendedores->pluck('internal_orders_count')->toArray();
        foreach($ven_data as &$hits) {
            $hits = round(($hits * 100)/ $vendedores->sum('internal_orders_count'),2);
         }
         
        $subtitle='Porcentaje total de P.I';
        $meses_title='Suma total  de PI';
        $Mes_axis='Total de pedidos en el mes';
        $Mes_data=array();
        for($i=1;$i<=12;$i++){
            array_push($Mes_data,
            $InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')
            ->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')
            ->count());
        }
    }
    // dd($vendedores);
    
    // dd($ven_data);
    $SellerChart=LarapexChart::pieChart()
    ->setTitle($subtitle)
    ->setSubtitle('Anual vendedores activos')
    ->addData($ven_data)
    ->setLabels($vendedores->pluck('seller_name')->toArray());
    #Grafica por meses
    $Meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
       'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    
    $MesesChart=LarapexChart::lineChart()
    ->setTitle($meses_title)
    ->setSubtitle('Anual')
    ->addData($Mes_axis,$Mes_data)
    ->setLabels($Meses);
    
    return view('reportes.objetivos',compact(
                   'Sellers',
                   'InternalOrders',
                   'Year',
                   'CompanyProfiles',
                   'comp',
                   'SellerChart',
                    'MesesChart',
                    'Monto',
    ));
  }

  public function medios(){
    $CompanyProfiles = CompanyProfile::first();
    $comp=$CompanyProfiles->id;
    $Year=now()->year;
    $Medios=Medio::all();
    $InternalOrders=DB::table('internal_orders')
    ->join('marcas','marcas.id','internal_orders.marca')
    ->select('internal_orders.*','marcas.name')
    ->where('date','>=',$Year.'-01-01')
    ->get();
    // dd($InternalOrders);


    #por total de pedidos
    $medios  = DB::table('medios')
            ->join('internal_orders','internal_orders.medio_id','medios.id')
    
            ->groupBy('medios.description')
            
            ->selectRaw('COUNT(*) as internal_orders_count ,medios.description')
            ->orderBy('internal_orders_count','desc')
            ->get();
        $medios_data=$medios->pluck('internal_orders_count')->toArray();
        // dd($vendedores);
        foreach($medios_data as &$hits) {
        $hits = round(($hits * 100)/ $medios->sum('internal_orders_count'),2);
         }
         $subtitle='Porcentaje del monto total de P.I';
         $meses_title='total de pedidos por medio';
         $Mes_axis='Total de pedidos por mes';
        $Mes_data=array();
        for($i=1;$i<=12;$i++){
            array_push($Mes_data,
            (int)($InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')
            ->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')
            ->sum('total')/1000));
        }
    // dd($ven_data);
    $SellerChart=LarapexChart::pieChart()
    ->setTitle($subtitle)
    ->setSubtitle('Anual vendedores activOs')
    ->addData($medios_data)
    ->setLabels($medios->pluck('name')->toArray());
    #Grafica por meses
    $Meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
       'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    
    $MesesChart=LarapexChart::lineChart()
    ->setTitle($meses_title)
    ->setSubtitle('Anual')
    ->addData($Mes_axis,$Mes_data)
    ->setLabels($Meses);
    
    return view('reportes.medios',compact(
                   'Medios',
                   'InternalOrders',
                   'Year',
                   'CompanyProfiles',
                   'comp',
                   'SellerChart',
                    'MesesChart',
    ));
    }


  public function fabricacion($Monto){
    $CompanyProfiles = CompanyProfile::first();
    $comp=$CompanyProfiles->id;
    $Year=now()->year;
    $Marcas=Marca::all();
    $InternalOrders=DB::table('internal_orders')
    ->join('marcas','marcas.id','internal_orders.marca')
    ->select('internal_orders.*','marcas.name')
    ->where('date','>=',$Year.'-01-01')
    ->get();
    // dd($InternalOrders);

    #Grafica vendedores
    if($Monto=='MONTO'){

    #por montn total de pedidos
        $marcas = DB::table('marcas')
        ->join('internal_orders','internal_orders.marca','=','marcas.id')
        ->select('marcas.name')
        ->where('internal_orders.date','>=',$Year.'-01-01')   
        ->selectRaw("SUM(internal_orders.total) as total")
        ->groupBy('internal_orders.marca','marcas.name')
        ->orderBy('total','desc')
        ->get();
        // dd($vendedores);
        $marcas_data=$marcas->pluck('total')->toArray();
        foreach($marcas_data as &$hits) {
        $hits = round(($hits * 100)/ $marcas->sum('total'),2);
         }
         $subtitle='Porcentaje del monto total de P.I';
         $meses_title='Suma total del monto de PI en miles de pesos';
         $Mes_axis='Monto total en miles';
        $Mes_data=array();
        for($i=1;$i<=12;$i++){
            array_push($Mes_data,
            (int)($InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')
            ->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')
            ->sum('total')/1000));
        }
    }

    else{

    #por total de pedidos
        $marcas = DB::table('marcas')
        ->join('internal_orders','internal_orders.marca','marcas.id')

        ->groupBy('marcas.name')
        
        ->selectRaw('COUNT(*) as internal_orders_count ,marcas.name')
        ->orderBy('internal_orders_count','desc')
        ->get();
        $marcas_data=$marcas->pluck('internal_orders_count')->toArray();
        foreach($marcas_data as &$hits) {
            $hits = round(($hits * 100)/ $marcas->sum('internal_orders_count'),2);
         }
         
        $subtitle='Porcentaje total de P.I';
        $meses_title='Suma total  de PI';
        $Mes_axis='Total de pedidos en el mes';
        $Mes_data=array();
        for($i=1;$i<=12;$i++){
            array_push($Mes_data,
            $InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')
            ->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')
            ->count());
        }
    }
    // dd($vendedores);
    
    // dd($ven_data);
    $SellerChart=LarapexChart::pieChart()
    ->setTitle($subtitle)
    ->setSubtitle('Anual vendedores activos')
    ->addData($marcas_data)
    ->setLabels($marcas->pluck('name')->toArray());
    #Grafica por meses
    $Meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
       'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    
    $MesesChart=LarapexChart::lineChart()
    ->setTitle($meses_title)
    ->setSubtitle('Anual')
    ->addData($Mes_axis,$Mes_data)
    ->setLabels($Meses);
    
    return view('reportes.fabricacion',compact(
                   'Marcas',
                   'InternalOrders',
                   'Year',
                   'CompanyProfiles',
                   'comp',
                   'SellerChart',
                    'MesesChart',
                    'Monto',
    ));
  }

public function RangoVentas(){
    $CompanyProfiles = CompanyProfile::first();
    $comp=$CompanyProfiles->id;
    $Year=now()->year;
    $Clientes=DB::table('customers')
    ->selectRaw('
        SUM(internal_orders.total) as total,
        COUNT(internal_orders.id) as pi,
        customers.customer,
        customers.clave
    ')
    ->join('internal_orders', 'internal_orders.customer_id', '=', 'customers.id')
    ->where('internal_orders.date', '>', $Year.'-01-01')
    ->groupBy('customers.customer', 'customers.clave')
    ->orderBy('total')
    ->get();
    $Rangos=Array(
        Array(0,50),
        Array(51,100),
        Array(101,200),
        Array(301,400),
        Array(401,500),
        Array(500,600),
        Array(601,700),
        Array(701,800),
        Array(801,900),
        Array(901,1000),
        Array(1000,2000),
        Array(2001,3000),
        Array(3001,99000)
    );
    $etiquetas = [];
    $numPedidos = [];
    $totalDinero = [];
    
    // Inicializa los arrays de salida
    foreach ($Rangos as $rango) {
        $etiquetas[] = 'De ' . $rango[0] . ' a ' . $rango[1];
        $numPedidos[] = 0;
        $totalDinero[] = 0;
    }
    
    // Clasifica los clientes según el rango
    foreach ($Clientes as $cliente) {
        $totalCliente = $cliente->total;
    
        foreach ($Rangos as $index => $rango) {
    
            if ($totalCliente >= $rango[0]*1000 && $totalCliente <= $rango[1]*1000) {
                $numPedidos[$index] += $cliente->pi;
                $totalDinero[$index] += $totalCliente;
                break;
            }
        }
    }
    
    $RangosChart=LarapexChart::barChart()
    ->setTitle('Rango de ventas')
    ->setSubtitle('Anual')
    ->addData('total pedidos',$numPedidos)
    ->addData('Monto',$totalDinero)
    ->setLabels($etiquetas);
    $RangosPie=LarapexChart::pieChart()
    ->setTitle('Rango de ventas no. Pi')
    ->setSubtitle('Anual')
    ->addData($numPedidos)
    ->setLabels($etiquetas);
    $RangosPieMonto=LarapexChart::pieChart()
    ->setTitle('Rango de ventas Suma moneda nacional')
    ->setSubtitle('Anual')
    ->addData($totalDinero)
    ->setLabels($etiquetas);

    return view('reportes.rango_ventas',compact(
        'Clientes','Rangos','Year',
                   'CompanyProfiles',
                   'comp', 'RangosChart','RangosPie','RangosPieMonto'
    ));

}
public function RangoVentasPi(){
    $CompanyProfiles = CompanyProfile::first();
    $comp=$CompanyProfiles->id;
    $Year=now()->year;
    $Pedidos=DB::table('internal_orders')
    ->selectRaw('
        internal_orders.*,
        customers.customer,
        customers.clave
    ')
    ->join('customers', 'internal_orders.customer_id', '=', 'customers.id')
    ->where('internal_orders.date', '>', $Year.'-01-01')
    ->orderBy('internal_orders.total')
    ->get();
    $Rangos=Array(
        Array(0,50),
        Array(51,100),
        Array(101,200),
        Array(301,400),
        Array(401,500),
        Array(500,600),
        Array(601,700),
        Array(701,800),
        Array(801,900),
        Array(901,1000),
        Array(1000,2000),
        Array(2001,3000),
        Array(3001,99000)
    );
    $etiquetas = [];
    $numPedidos = [];
    $totalDinero = [];
    
    // Inicializa los arrays de salida
    foreach ($Rangos as $rango) {
        $etiquetas[] = 'De ' . $rango[0] . ' a ' . $rango[1];
        $numPedidos[] = 0;
        $totalDinero[] = 0;
    }
    
    // Clasifica los clientes según el rango
    foreach ($Pedidos as $pedido) {
        foreach ($Rangos as $index => $rango) {
    
            if ($pedido->total >= $rango[0]*1000 && $pedido->total <= $rango[1]*1000) {
                $numPedidos[$index] += 1;
                $totalDinero[$index] += ((int)($pedido->total/1000));
                break;
            }
        }
    }
    // dd($numPedidos);
    $RangosChart=LarapexChart::barChart()
    ->setTitle('Rango de ventas')
    ->setSubtitle('Anual')
    ->addData('total pedidos',$numPedidos)
    ->addData('Monto',$totalDinero)
    ->setLabels($etiquetas)
    ->setGrid();
    $RangosPie=LarapexChart::pieChart()
    ->setTitle('Rango de ventas no. Pi')
    ->setSubtitle('Anual')
    ->addData($numPedidos)
    ->setLabels($etiquetas);
    $RangosPieMonto=LarapexChart::pieChart()
    ->setTitle('Rango de ventas suma en miles de pesos')
    ->setSubtitle('Anual')
    ->addData($totalDinero)
    ->setLabels($etiquetas);

    return view('reportes.rango_ventas_pi',compact(
        'Pedidos','Rangos','Year',
                   'CompanyProfiles',
                   'comp', 'RangosChart','RangosPie','RangosPieMonto'
    ));

}

public function ventasFabricacion(){
    $CompanyProfiles = CompanyProfile::first();
    $comp=$CompanyProfiles->id;
    $Year=now()->year;
    $Items=DB::table('items')
    ->selectRaw('
        items.*,
        internal_orders.date
    ')
    ->join('internal_orders', 'internal_orders.id', '=', 'items.internal_order_id')
    ->where('internal_orders.date', '>', $Year.'-01-01')
    ->orderBy('items.family')
    ->get();
    $Productos=DB::table('items')
    ->select('items.family')
    ->join('internal_orders', 'internal_orders.id', '=', 'items.internal_order_id')
    ->where('internal_orders.date', '>', $Year.'-01-01')
    ->distinct('items.family')
    ->get();
    // dd($Productos);
    $fams = DB::table('items')
    ->selectRaw('
        items.family,COUNT(items.family) as total
    ')
    ->join('internal_orders', 'internal_orders.id', '=', 'items.internal_order_id')
    ->where('internal_orders.date', '>', $Year.'-01-01')
    ->groupBy('items.family')
    ->orderBy('total','desc')
    ->get();
    
        $fam_data=$fams->pluck('total')->toArray();

    $FabChart=LarapexChart::pieChart()
    ->setTitle('Ventas por fabricacion')
    ->setSubtitle('Anual vendedores activos')
    ->addData($fam_data)
    ->setLabels($fams->pluck('family')->toArray());

    $Meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
       'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $Mes_data=array();
       for($i=1;$i<=12;$i++){
           array_push($Mes_data,
           $Items->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')
           ->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')
           ->count());
       }
    $MesesChart=LarapexChart::lineChart()
    ->setTitle('Ventas de porductos por mes')
    ->setSubtitle('Anual')
    ->addData('total ventas',$Mes_data)
    ->setLabels($Meses);

    return view('reportes.ventas_fabricacion',compact(
                   'Year',
                   'CompanyProfiles',
                   'comp', 'Items','Productos','FabChart','MesesChart'
    ));
}


public function kilos(){
    $CompanyProfiles = CompanyProfile::first();
    $comp=$CompanyProfiles->id;
    $Year=now()->year;
    $Sellers=Seller::where('status','ACTIVO')->get();
    $InternalOrders=DB::table('internal_orders')
    ->join('sellers','sellers.id','internal_orders.seller_id')
    ->select('internal_orders.*','sellers.seller_name')
    ->where('date','>=',$Year.'-01-01')
    ->where('sellers.status','ACTIVO')
    ->get();
    $vendedores = DB::table('sellers')
        ->where('sellers.status','ACTIVO')
        ->join('internal_orders','internal_orders.seller_id','=','sellers.id')
        ->select('sellers.seller_name')
        ->selectRaw("SUM(internal_orders.kilos) as kilos")
        ->groupBy('internal_orders.seller_id','sellers.seller_name')
        ->orderBy('kilos','desc')
        ->get();

        $ven_data=$vendedores->pluck('kilos')->toArray();
        foreach($ven_data as &$hits) {
        $hits = round(($hits * 100)/ $vendedores->sum('kilos'),2);
         }
        $Mes_data=array();
        for($i=1;$i<=12;$i++){
            array_push($Mes_data,
            $InternalOrders->where('date','>=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')
            ->where('date','<=',$Year.'-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-31')
            ->sum('kilos'));
        }
        
    $SellerChart=LarapexChart::pieChart()
    ->setTitle('Grafica de kilos por vendedor')
    ->setSubtitle('Anual total de kilos por vendedor activo')
    ->addData($ven_data)
    ->setLabels($vendedores->pluck('seller_name')->toArray());
    #Grafica por meses
    $Meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
       'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    
    $MesesChart=LarapexChart::lineChart()
    ->setTitle('Total de kilos vendidos por mes en '.$Year)
    ->setSubtitle('Anual')
    ->addData('total pedidos',$Mes_data)
    ->setLabels($Meses);

    return view('reportes.kilos',compact(
                   'Year',
                   'CompanyProfiles',
                   'comp', 'InternalOrders','vendedores',
                   'Sellers','SellerChart','MesesChart'
    ));
}


public function historico(){

    return redirect()->away('https://tyrsa-apps.com/');   
}

}
