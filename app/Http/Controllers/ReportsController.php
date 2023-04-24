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
       public function generate($id,$report,$pdf)
       {
        
           $caminoalpoder=public_path();
           $process = new Process(['python3',$caminoalpoder.'/'.$report.'.py',$id]);
           $process->run();
           if (!$process->isSuccessful()) {
               throw new ProcessFailedException($process);
           }
           $data = $process->getOutput();
           if($pdf==0){
               return response()->download(public_path('storage/report/'.$report.$id.'.xlsx'));
           }else{
            $process = new Process(["soffice --convert-to 'pdf:calc_pdf_Export:{\"SinglePageSheets\":{\"type\":\"boolean\",\"value\":\"true\"}}' ".$report.$id.".xlsx "]);
            $process->setWorkingDirectory($caminoalpoder.'/storage/report/');
            
            $process->run();
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            $data = $process->getOutput();
            return response()->download(public_path('storage/report/'.$report.$id.'.pdf'));
          
        //       switch($report) {
        //       case('contraportada'):
        //        return $this->contraportada_pdf($id);
        //        break;
        //        default:
        //        $msg="no report";
        //    }
       }}
    
       public function contraportada()
       {
           $InternalOrders =  DB::table('internal_orders')
           ->join('customers', 'internal_orders.customer_id', '=', 'customers.id')
           ->join('coins', 'internal_orders.coin_id','=','coins.id')
           ->select('internal_orders.*','customers.customer','coins.symbol')
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
     
  public function prueba($name){
    return response()->download(public_path('storage/report/'.$name));
           
  }
}
