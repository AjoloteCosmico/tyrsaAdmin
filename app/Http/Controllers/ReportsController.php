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
use App\Models\Cobro;
use App\Models\CreditNote;
use App\Models\note_facture;

use App\Http\Requests\StorepaymentsRequest;
use App\Http\Requests\UpdatepaymentsRequest;
use SplFileInfo;
use Illuminate\Support\Facades\Storage;
use DB;
use PDF;
use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException; 
use Illuminate\Support\Facades\Auth;
class ReportsController extends Controller
{
       public function generate($id,$report,$pdf,$tipo=0)
       {
           $caminoalpoder=public_path();
           $process = new Process(['python3',$caminoalpoder.'/'.$report.'.py',$id,$tipo]);
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
    
       public function contraportada()
       {
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
                    $Banco=bank::where('bank_id',$Cobro->bank_id)->first();
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
}
