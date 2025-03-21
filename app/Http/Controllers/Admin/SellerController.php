<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class SellerController extends Controller
{
    public function index()
    {
        if(!Auth::user()->can('CATALOGOS')){
            return redirect()->route('dashboard');
        }
        $Sellers = Seller::all();

        return view('admin.sellers.index', compact('Sellers'));
    }

    public function create()
    {
        $usuarios = User::all();
        return view('admin.sellers.create',compact('usuarios'));
    }

    public function store(Request $request)
    {
        $rules = [
            'seller_name' => 'required',
            'gv' => 'required',
            'ga' => 'required',
            'gc' => 'required',
            'seller_mobile' => 'required|numeric|digits:10',
            'seller_office_phone' => 'required|numeric|digits:10',
            'seller_email' => 'required|email|unique:sellers,seller_email',
        ];

        $messages = [
            'seller_name.required' => 'Captura el Nombre del Vendedor',
            'gv.required' => 'Selecciona un Gerente de Ventas',
            'ga.required' => 'Selecciona un Gerente Administrativo',
            'gc.required' => 'Selecciona un Gerente Comercial',
            'seller_mobile.required' => 'Captura el Número Celular del Vendedor',
            'seller_mobile.numeric' => 'El número celular debe ser númerico',
            'seller_mobile.digits' => 'Captura el número celular a 10 dígitos',
            'seller_office_phone.required' => 'Captura el Número de Oficina del Vendedor',
            'seller_office_phone.numeric' => 'El número de Oficina debe ser númerico',
            'seller_office_phone.digits' => 'Captura el número de Oficina a 10 dígitos',
            'seller_email.required' => 'Captura el Email del Vendedor',
            'seller_email.email' => 'Captura un Email válido',
            'seller_email.unique' => 'El Email ya ha sido registrado',
        ];

        $request->validate($rules, $messages);

        $Sellers = new Seller();

        //por confirmar, nescesario agregar campo folio int  a sellers
        $Folio = Seller::orderBy('folio', 'DESC')->first();
        $Folio=$Folio->folio+1;
        
        $Sellers->folio= $Folio;
        //end por confirmar
        
        $Sellers->seller_name = $request->seller_name;
        $Sellers->seller_mobile = $request->seller_mobile;
        $Sellers->seller_office_phone = $request->seller_office_phone;
        $Sellers->seller_office_phone_ext = $request->seller_office_phone_ext;
        $Sellers->seller_email = $request->seller_email;
        $Sellers->seller_street = $request->seller_street;
        $Sellers->seller_outdoor = $request->seller_outdoor;
        $Sellers->seller_indoor = $request->seller_indoor;
        $Sellers->seller_suburb = $request->seller_suburb;
        $Sellers->seller_city = $request->seller_city;
        $Sellers->seller_state = $request->seller_state;
        $Sellers->seller_zip_code = $request->seller_zip_code;
        
        $Sellers->gv = $request->gv;
    
        $Sellers->gc = $request->gc;
        $Sellers->ga = $request->ga;
        $Sellers->firma= $request->seller_sign;
        $Sellers->status= $request->seller_status;
        $Sellers->iniciales= $request->seller_initials;

        $Sellers->save();

        return redirect()->route('sellers.index')->with('create_reg', 'ok');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $Sellers = Seller::find($id);

        return view('admin.sellers.show', compact('Sellers'));
    }

    public function update(Request $request, $id)
    {
        
        $Sellers = Seller::find($id);

        $rules = [
            'seller_name' => 'required',
            'folio' => 'required|unique:sellers,folio,'.$id,
            'seller_mobile' => 'required|numeric|digits:10',
            'seller_office_phone' => 'required|numeric|digits:10',
            'seller_email' => 'required|email',
        ];

        $messages = [
            'seller_name.required' => 'Captura el Nombre del Vendedor',
            'folio.required' => 'Captura el Numero del Vendedor',
            'seller_mobile.required' => 'Captura el Número Celular del Vendedor',
            'seller_mobile.numeric' => 'El número celular debe ser númerico',
            'seller_mobile.digits' => 'Captura el número celular a 10 dígitos',
            'seller_office_phone.required' => 'Captura el Número de Oficina del Vendedor',
            'seller_office_phone.numeric' => 'El número de Oficina debe ser númerico',
            'seller_office_phone.digits' => 'Captura el número de Oficina a 10 dígitos',
            'seller_email.required' => 'Captura el Email del Vendedor',
            'seller_email.email' => 'Captura un Email válido',
        ];

        $request->validate($rules, $messages);

        $Sellers = Seller::find($id);
        $Sellers->seller_name = $request->seller_name;
        $Sellers->folio = $request->folio;
        $Sellers->seller_mobile = $request->seller_mobile;
        $Sellers->seller_office_phone = $request->seller_office_phone;
        $Sellers->seller_office_phone_ext = $request->seller_office_phone_ext;
        $Sellers->seller_email = $request->seller_email;
        $Sellers->seller_street = $request->seller_street;
        $Sellers->seller_outdoor = $request->seller_outdoor;
        $Sellers->seller_indoor = $request->seller_indoor;
        $Sellers->seller_suburb = $request->seller_suburb;
        $Sellers->seller_city = $request->seller_city;
        $Sellers->seller_state = $request->seller_state;
        $Sellers->seller_zip_code = $request->seller_zip_code;
        $Sellers->status= $request->seller_status;
        $Sellers->firma= $request->seller_sign;
        $Sellers->iniciales=$request->seller_initials;
        $Sellers->save();

        return redirect()->route('sellers.index')->with('update_reg', 'ok');
    }

    public function destroy($id)
    {
        Seller::destroy($id);

        return redirect()->route('sellers.index')->with('eliminar', 'ok');
    }

    public function customers($id){
        $Seller=Seller::find($id);
        $Customers=DB::table('customers')->where('customers.seller_id',$id)
        ->leftJoin('internal_orders','internal_orders.customer_id','customers.id')
        ->select('customers.id','customers.customer','customers.alias','customers.clave','customers.customer_rfc','customers.seller_id', DB::raw('count(*) as npedidos'), DB::raw('sum(internal_orders.total) as total'))
        ->groupBy('customers.id','customers.customer','customers.alias','customers.clave','customers.customer_rfc','customers.seller_id',)
        
        ->get();
    //    dd($Customers);
    return view('admin.sellers.customers',compact('Customers','Seller'));
    }

    public function asign_customers(){
        
        $Sellers=Seller::all();
        
      foreach($Sellers as $seller){
        
        $Customers=DB::table('customers')
        ->join('internal_orders','internal_orders.customer_id','customers.id')
        ->select('customers.*')
        ->where('internal_orders.seller_id',$seller->id)
      
        ->get();
        foreach($Customers as $customer){
            $c=Customer::find($customer->id);
            $c->seller_id=$seller->id;
            $c->save();
        }

      } 
      return redirect()->route('notas');


    }

    public function select_customers($id){
        $Seller=Seller::find($id);
        $Customers=Customer::all();

        return view('admin.sellers.asign' ,compact('Seller','Customers'));
    }
    public function update_customers(Request $request,$id){
        $Seller=Seller::find($id);
        foreach($request->customers as $c_id){

            $Customer=Customer::find($c_id);
            $Customer->seller_id=$Seller->id;
            $Customer->save();
    }
        return redirect()->route('sellers.customers',$Seller->id);
    }
    
    public function reasign_customer($id){
        $Customer=Customer::find($id);
        $Seller=Seller::find($Customer->seller_id);
        $Sellers=Seller::all();
        return view('admin.sellers.reasign',compact('Customer','Sellers','Seller'));
    }
    
    public function confirm_reasign(Request $request){
        $Customer=Customer::find($request->customer_id);
        $Customer->seller_id=$request->seller_id;
        $Customer->save();
        
        return redirect()->route('sellers.customers',$Customer->seller_id);
    }


    public function dgi_index(){  
        $Socios=Seller::where('dgi','>',0)->get();
        return view('admin.sellers.dgi',compact('Socios'));
    }
    public function dgi_edit($id){  
        $Sellers=Seller::find($id);
        return view('admin.sellers.edit_dgi',compact('Sellers'));
    }
    public function dgi_update(Request $request,$id){  
        $Socio=Seller::find($id);
        $Socio->dgi=$request->dgi;
        $Socio->save();
        return redirect()->route('dgi_com.index')->with('update_reg','ok');
    }
}

