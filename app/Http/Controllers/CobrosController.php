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
use App\Models\Cobro;


use App\Models\bank;
use App\Http\Requests\StorepaymentsRequest;
use App\Http\Requests\UpdatepaymentsRequest;
use SplFileInfo;
use Illuminate\Support\Facades\Storage;
use DB;
use PDF;
use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException; 
use Illuminate\Support\Facades\Auth;

class CobrosController extends Controller
{
    public function index(){
        $Cobros=DB::table('cobros')
        ->join('internal_orders', 'internal_orders.id', '=', 'cobros.order_id')
        ->join('customers', 'internal_orders.customer_id','=','customers.id')
        ->join('coins', 'internal_orders.coin_id','=','coins.id')
        ->join('factures', 'cobros.facture_id','=','factures.id')
        ->join('banks', 'cobros.bank_id','=','banks.bank_id')
        ->select('cobros.*','customers.customer','customers.clave', 'coins.coin','coins.symbol', 'internal_orders.invoice','factures.facture','banks.bank_clue','banks.bank_description')
        // ->orderBy('internal_orders.invoice', 'DESC')
        ->get();
        return view('cobros.index',compact('Cobros'));
    }
    public function create(){
        //traer todas las facturas
                $Bancos=bank::all();
                $Coins=Coin::all();
                $Factures=Factures::all();
                $Customers=Customer::orderby('clave')->get();
                $InternalOrders=InternalOrder::all();
                return view('cobros.create',compact(
                'Coins',
                'Bancos',
                'Customers',
                'InternalOrders',
                'Factures'
                ));
            }
            public function store(Request $request){
        
                $Cobro=new Cobro();
                $Cobro->order_id=$request->order_id;
                $Cobro->amount=$request->amount;
                $Cobro->comp=$request->comp;
                $Cobro->facture_id=$request->facture_id;
                $Cobro->bank_id=$request->bank_id;
                $Cobro->coin_id=$request->coin_id;
                $Cobro->tc=$request->tc;
                $Cobro->date=$request->date;
                $Cobro->save();
                $comp=$request->comp_file;
                \Storage::disk('comp')->put('comp'.$Cobro->id.'.pdf',  \File::get($comp));
               
                return $this->index();
                }
}
