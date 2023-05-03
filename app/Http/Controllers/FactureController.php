<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalOrder;
use App\Models\Coin;
use App\Models\CompanyProfile;
use App\Models\Factures;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class FactureController extends Controller
{
    public function index(){
//traer todas las facturas
        
        $Factures=DB::table('factures')
        ->join('internal_orders', 'internal_orders.id', '=', 'factures.order_id')
        ->join('customers', 'internal_orders.customer_id','=','customers.id')
        ->join('coins', 'internal_orders.coin_id','=','coins.id')
        ->select('factures.*','customers.customer','customers.clave', 'coins.symbol', 'internal_orders.invoice','internal_orders.reg_date','internal_orders.payment_conditions')
        // ->orderBy('internal_orders.invoice', 'DESC')
        ->get();
    
        return view('factures.index',compact(
        'Factures'
        ));
    }   
    public function create(){
        //traer todas las facturas
                $Factures=Factures::all();
                $Customers=Customer::orderby('clave')->get();
                $InternalOrders=InternalOrder::all();
                $Coins=Coin::all();
                return view('factures.create',compact(
                'Factures',
                'Customers',
                'InternalOrders',
                'Coins'
                ));
            }
    public function store(Request $request){
        
                $Facture= new Factures();
                $Facture->order_id=$request->order_id;
                $Facture->amount=$request->amount;
                $Facture->ordinal=$request->ordinal;
                $Facture->status='CAPTURA';
                $Facture->npagos=$request->npagos;
                $Facture->facture=$request->facture;
                $Facture->coin_id=$request->coin_id;
                $Facture->tc=$request->tc;
                $Facture->date=$request->date;
                $Facture->save();
                // $Facture->customer_id=$request->customer_id;
                
                // $Facture->customer_id=$request->customer_id;
                $comp=$request->comp_file;
                \Storage::disk('comp')->put('fac'.$Facture->id.'.pdf',  \File::get($comp));
               
                return $this->index();
                }
    public function show($id){
    $file_path = public_path('storage/fac'.$id.'.pdf');
    return response()->file($file_path);
    //return Storage::download('app/comp'.$id.'.pdf');
                    
               }
    public function edit($facture){
        //traer todas las facturas
        $Facture=DB::table('factures')
        ->join('internal_orders', 'internal_orders.id', '=', 'factures.order_id')
        ->join('customers', 'internal_orders.customer_id','=','customers.id')
        ->join('coins', 'internal_orders.coin_id','=','coins.id')
        ->select('factures.*','customers.id as customer_id','customers.clave', 'coins.symbol', 'internal_orders.invoice','internal_orders.reg_date','internal_orders.payment_conditions')
        ->where('factures.id','=',$facture)
        ->first();
                $Factures=Factures::all();
                $Customers=Customer::orderby('clave')->get();
                $InternalOrders=InternalOrder::all();
                
                return view('factures.edit',compact(
                'Facture',
                'Factures',
                'Customers',
                'InternalOrders'
                ));
                }
    public function update($id,Request $request){
        //traer todas las facturas
                $Facture=Factures::find($id);
                $Facture->amount=$request->amount;
                $Facture->ordinal=$request->ordinal;
                $Facture->status='CAPTURA';
                $Facture->npagos=$request->npagos;
                $Facture->facture=$request->facture;
                $Facture->save();
                // $Facture->customer_id=$request->customer_id;
                
                // $Facture->customer_id=$request->customer_id;

                return $this->index();
                }

    public function destroy($id){
            Factures::destroy($id);
            return $this->index();
    }
    
    
    
        

        
}
