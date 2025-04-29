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

use App\Models\User;
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

class DgiReportsController extends Controller
{
    
public function dgi_select(){
    
    $year=now()->format('Y');
    $quincenas = [];
    for ($i = 1; $i <= 24; $i++) {
        $month = ceil($i/ 2);
        $isFirstHalf = $i % 2 !== 0;
        $startDate = $isFirstHalf ? "$year-$month-01" : "$year-$month-16";
        $endDate = $isFirstHalf ? "$year-$month-15" : date("Y-m-t", strtotime($startDate));
        if(now()->format('Y-m-d')>=date("Y-m-d", strtotime($endDate))){
        $quincenas[] = [
            'id' => ($i-1),
            'inicio' => date("Y-m-d", strtotime($startDate)),
            'fin' => date("Y-m-d", strtotime($endDate))
        ];}
    }
    return view('reportes.dgi_select',compact('quincenas'));

}
    
public function dgi(Request $request){
    $year=now()->format('Y');
    $quincenas = [];
    
    for ($i = 1; $i <= 24; $i++) {
        $month = ceil($i/ 2);
        $isFirstHalf = $i % 2 !== 0;
        $startDate = $isFirstHalf ? "$year-$month-01" : "$year-$month-16";
        $endDate = $isFirstHalf ? "$year-$month-15" : date("Y-m-t", strtotime($startDate));
        
        $quincenas[] = [
            'id' => ($i-1),
            'inicio' => date("Y-m-d", strtotime($startDate)),
            'fin' => date("Y-m-d", strtotime($endDate))
        ];
    }

    $CompanyProfiles = CompanyProfile::first();
    $comp=$CompanyProfiles->id;
    $Year=now()->year;
    $Sellers=Seller::all()->sortBy('status');
    $Usuarios=User::all();

    $socios = Seller::where('status','ACTIVO')->where('dgi','>','0')->get();
    $no_socios =  Seller::where('status','ACTIVO')->where('dgi','<=','0')->get();
    $Cobros=DB::table('cobro_orders')
    ->selectRaw('cobro_orders.*,
                internal_orders.noha,internal_orders.invoice,internal_orders.comision,internal_orders.seller_id,
                cobros.comp,cobros.bank_id,cobros.coin_id,cobros.tc, cobros.capturo,cobros.reviso,cobros.autorizo,
                cobros.facture_id,cobros.date,customers.alias')
    ->join('cobros','cobros.id','cobro_orders.cobro_id')
    ->join('internal_orders','cobro_orders.order_id','internal_orders.id')
    ->join('customers','customers.id','internal_orders.customer_id')
    ->where('cobros.date','>=',$quincenas[$request->interval]['inicio'])
    ->where('cobros.date','<=',$quincenas[$request->interval]['fin'])
    ->orderBy('cobros.date')
    ->get();
    $TodosLosCobros=DB::table('cobro_orders')
    ->selectRaw('cobro_orders.*,
                internal_orders.noha,internal_orders.invoice,internal_orders.comision,internal_orders.seller_id,
                cobros.comp,cobros.bank_id,cobros.coin_id,cobros.tc,
                cobros.facture_id,cobros.date,customers.alias')
    ->join('cobros','cobros.id','cobro_orders.cobro_id')
    ->join('internal_orders','cobro_orders.order_id','internal_orders.id')
    ->join('customers','customers.id','internal_orders.customer_id')
    ->where('internal_orders.status','!=','CANCELADO')
    ->orderBy('cobros.date')
    ->get();
    $Bancos=Bank::all();
    $Monedas=Coin::all();
    $Facturas=Factures::all();
    $Pagos=payments::all();
    $Orders=DB::table('internal_orders')
    ->selectRaw('internal_orders.*,sellers.seller_name')
    ->join('sellers','sellers.id','internal_orders.seller_id')
    ->selectRaw('internal_orders.*,sellers.seller_name')
    ->where('internal_orders.status','!=','CANCELADO')
    ->get();
    $Comisiones=DB::table('comissions')
    ->selectRaw('comissions.*,sellers.seller_name,sellers.dgi as seller_dgi')
    ->join('sellers','sellers.id','comissions.seller_id')
    ->get();
    $Type=$request->type;
    $Quincena=$request->interval;
    $StartDate=$quincenas[$request->interval]['inicio'];
    $EndDate=$quincenas[$request->interval]['fin'];
    // dd($quincenas[$request->interval]['inicio'],$quincenas[$request->interval]['fin'],$Cobros);
    return view('reportes.dgi',compact(
        'Year',
        'CompanyProfiles',
        'comp',
        'Sellers',
        'Cobros',
        'TodosLosCobros',
        'Pagos',
        'Orders',
        'Facturas',
        'Bancos',
        'Monedas',
        'Comisiones',
        'socios',
        'no_socios',
        'Type',
        'Usuarios',
        'Quincena', 'StartDate','EndDate'
    ));

}


}
