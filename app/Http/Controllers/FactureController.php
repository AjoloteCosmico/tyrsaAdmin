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
        //traer todas las facturas
                $Factures=Factures::all();
                return view('factures.index',compact(
                'Factures'
                ));
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
