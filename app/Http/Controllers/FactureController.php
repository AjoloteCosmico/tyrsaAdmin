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
        $Factures=Factures::all();
        return view('factures.index',compact(
        'Factures'
        ));
    }
    public function create(){
        //traer todas las facturas
                $Factures=Factures::all();
                $Customers=Customer::orderby('clave')->get();
                $InternalOrders=InternalOrder::all();
                return view('factures.create',compact(
                'Factures',
                'Customers',
                'InternalOrders'
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
                $Facture->save();
                // $Facture->customer_id=$request->customer_id;
                
                // $Facture->customer_id=$request->customer_id;

                return $this->index();
                }
    public function edit($id){
        //traer todas las facturas
                $Factures=Factures::all();
                return view('factures.index',compact(
                'Factures'
                ));
                }
    public function update(Request $request){
        //traer todas las facturas
                $Factures=Factures::all();
                return view('factures.index',compact(
                'Factures'
                ));
                }
    
    
    
        

        
}
