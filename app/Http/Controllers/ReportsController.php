<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalOrder;
use App\Models\payments;
use App\Models\Customer;
use App\Models\CompanyProfile;
use App\Models\CustomerShippingAddress;
use App\Models\Coin;

use App\Models\Seller;
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

              switch($report) {
              case('contraportada'):
               return $this->contraportada_pdf($id);
               break;
               default:
               $msg="no report";
           }
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
    
    $pdf = PDF::loadView('reportes.contraportada_pdf', compact(
           'CompanyProfiles',
           'InternalOrders',
           'Customers',
           'Sellers',
           'CustomerShippingAddresses',
       'Coins'));    
    
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

     
}
