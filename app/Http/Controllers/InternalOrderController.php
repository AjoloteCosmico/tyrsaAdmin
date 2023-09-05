<?php

namespace App\Http\Controllers;
use Session;
use App\Models\Authorization;
use App\Models\InternalOrder;
use App\Models\Coin;

use App\Models\Cobro;
use App\Models\Factures;
use App\Models\CreditNote;
use App\Models\CompanyProfile;
use App\Models\Customer;
use App\Models\CustomerShippingAddress;
use App\Models\CustomerContact;
use App\Models\Item;
use App\Models\Seller;
use App\Models\TempInternalOrder;
use App\Models\TempItem;
use App\Models\vinternal_orders;
use App\Models\order_contacts;
use App\Models\comissions;
use App\Models\temp_comissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\payments;
use App\Models\historical_payments;
use App\Models\signatures;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth;

class InternalOrderController extends Controller
{
    public function index()
    {
        //$InternalOrders = vinternal_orders::all();
        $InternalOrders = DB::table('customers')
            ->join('internal_orders', 'internal_orders.customer_id', '=', 'customers.id')
            ->join('sellers', 'internal_orders.seller_id','=','sellers.id')
            ->select('internal_orders.*','customers.customer','customers.clave', 'sellers.seller_name')
            ->orderBy('internal_orders.invoice', 'DESC')
            ->get();
        return view('internal_orders.index', compact('InternalOrders'));
    }

    public function create()
    {
        $Customers = Customer::all()->sortBy('clave');
        $contactos=CustomerContact::all();
        return view('internal_orders.create', compact(
            'Customers',
            'contactos'
        ));
    }

    public function capture(Request $request)
    {
        
        $rules = [
            'invoice' => 'unique:internal_orders,invoice',
             'noha'=>  'unique:internal_orders,noha'];

        $Fecha = date('Y-m-d');
        $TempInternalOrders = TempInternalOrder::where('customer_id', $request->customer_id)->where('date', $Fecha)->get();
        if(count($TempInternalOrders)>0)
        {
            $TempInternalOrders = TempInternalOrder::where('customer_id', $request->customer_id)->where('date', $Fecha)->first();
        }
        else
        {
            $TempInternalOrder = new TempInternalOrder();
            $TempInternalOrder->date = $Fecha;
            $TempInternalOrder->customer_id = $request->customer_id;
            $TempInternalOrder->invoice = $request->invoice;
            $TempInternalOrder->noha = $request->noha;
            
            $TempInternalOrder->save();
            if($request->contacto){
                //dd($request->contacto);
                  for($i=0; $i < count($request->contacto); $i++){
                      $registro=new order_contacts();
                      $registro->temp_order_id=$TempInternalOrder->id;
                      $registro->contact_id=$request->contacto[$i];
                      $registro->save();
                  }}
            $TempInternalOrders = TempInternalOrder::orderBy('id', 'DESC')->first();
        }
        
        $Customers = Customer::where('id', $request->customer_id)->first();
        $CustomerShippingAddresses = CustomerShippingAddress::where('customer_id', $Customers->id)->get();
        $Coins = Coin::all();
        $Sellers = Seller::all();
        $hoy = now();
        
        return view('internal_orders.capture_order', compact(
            'TempInternalOrders',
            'Customers',
            'CustomerShippingAddresses',
            'Coins',
            'Sellers',
            'hoy',
        ));
    }
   
    public function comissions(Request $request)
    {           $rules = [
        'customer_id' => 'required',
        'temp_internal_order_id' => 'required',
        'date_delivery' => 'required',
        'instalation_date' => 'required',
        'coin_id' => 'required',
        'payment_conditions'=> 'required',
        // 'seller_id' => 'required',
        // 'comision' => 'required',
    ];

    $messages = [
        'customer_id.required' => 'Los datos del Cliente son necesarios',
        'temp_internal_order_id.required' => 'Existe un error en el pedido',
        'date_delivery.required' => 'La feha de entrega es necesaria',
        'instalation_date.required' => 'La fecha de Instalación es necesaria',
        'coin_id.required' => 'El tipo de Moneda es necesario',
        'payment_conditions.required' => 'Las condiciones de pago son necesarios',
        // 'seller_id.required' => 'Elija un vendedor',
        // 'comision.required' => 'Determine una comision para el vendedor',
    ];

    $request->validate($rules, $messages);
    $TempInternalOrders = TempInternalOrder::where('id', $request->temp_internal_order_id)->first();

    $TempInternalOrders->date_delivery = $request->date_delivery;
    $TempInternalOrders->instalation_date = $request->instalation_date;
    $TempInternalOrders->reg_date = $request->reg_date;        
    $TempInternalOrders->coin_id = $request->coin_id;
    $TempInternalOrders->payment_conditions = $request->payment_conditions;
    
    $TempInternalOrders->dgi=$request->dgi * 0.01;
    $TempInternalOrders->otra=$request->otra * 0.01;
    $TempInternalOrders->ieps=$request->ieps * 0.01;
    $TempInternalOrders->isr=$request->isr * 0.01;
    $TempInternalOrders->descuento=$request->descuento * 0.01;
    $TempInternalOrders->oc=$request->oc;
    $TempInternalOrders->ncotizacion=$request->ncotizacion;
    $TempInternalOrders->ncontrato=$request->ncontrato;
    
    $TempInternalOrders->tasa = $request->tasa*0.01;
    $TempInternalOrders->save();
    temp_comissions::truncate();
    $Sellers = Seller::all();
    $Comisiones=DB::table('temp_comissions')
     ->join('sellers', 'sellers.id', '=', 'temp_comissions.seller_id')
     ->where('temp_order_id',$TempInternalOrders->id)
     ->select('temp_comissions.*','sellers.seller_name','sellers.iniciales')
     ->get();
     session(['p_comission' => '']);
     session(['p_seller_id' => ' ']);
     
    return $this->capture_comissions($TempInternalOrders->id,' ');
    }


    public function capture_comissions($id,$message){
    $TempInternalOrders = TempInternalOrder::where('id', $id)->first();
    $Message=$message;
    $Sellers = Seller::all();
    $Comisiones=DB::table('temp_comissions')
     ->join('sellers', 'sellers.id', '=', 'temp_comissions.seller_id')
     ->where('temp_order_id',$TempInternalOrders->id)
     ->select('temp_comissions.*','sellers.seller_name','sellers.iniciales')
     ->get();
     $p_comission=Session::get('p_comission');
     $p_seller_id=Session::get('p_seller_id');
    return view('internal_orders.capture_comissions', compact(
        'TempInternalOrders','Sellers','Comisiones','Message','p_seller_id','p_comission'
        
    ));
    }


    public function guardar_comissions(Request $request)
    {$p_seller_id=$request->p_seller_id;
     $p_comission=$request->p_comission;
     if($p_seller_id!="."){
        
     session(['p_seller_id' => $p_seller_id]);
     }
     if($p_comission!="."){
        session(['p_comission' => $p_comission]);
    }
     $TempInternalOrders = TempInternalOrder::where('id', $request->temp_internal_order_id)->first();
     $allComissions=temp_comissions::where('seller_id',$request->seller_id)->get();

     if($allComissions->count() > 0){
        
        return $this->capture_comissions($TempInternalOrders->id,'duplicated');
     }else{
     $comision = new temp_comissions();
     $comision->seller_id=$request->seller_id;
     $comision->percentage=$request->comision*0.01;
     $comision->temp_order_id=$TempInternalOrders->id;
     $comision->description=$request->description;
     $comision->save();
     return $this->capture_comissions($TempInternalOrders->id,' ',compact('p_seller_id','p_comission'));
     }}

public function store_comissions(Request $request)
     {

      $InternalOrders = InternalOrder::where('id', $request->internal_order_id)->first();
      $allComissions=comissions::where('seller_id',$request->seller_id)
      ->where('order_id',$InternalOrders->id)
      ->get();
 
      if($allComissions->count() > 0){
         
         return redirect()->route('internal_orders.edit_order',$InternalOrders->id)->with([ 'duplicated' => 'Si' ]);;
      }else{
      $comision = new comissions();
      $comision->seller_id=$request->seller_id;
      $comision->percentage=$request->comision*0.01;
      $comision->order_id=$InternalOrders->id;
      $comision->description=$request->description;
      $comision->save();
      
      return redirect('internal_orders/edit/'.$InternalOrders->id);}
     }
    

    public function shipment(Request $request)
    {   
        
        $TempInternalOrders = TempInternalOrder::where('id', $request->temp_internal_order_id)->first();
        $Customers = Customer::where('id', $TempInternalOrders->customer_id)->first();
        $CustomerShippingAddresses = CustomerShippingAddress::where('customer_id', $TempInternalOrders->customer_id)->get();
        //verificar que el vendedor principal no tenga comisiones
        $allComissions=temp_comissions::where('seller_id',$request->seller_id)->get();

        if($allComissions->count() > 0){
            
            return $this->capture_comissions($TempInternalOrders->id,'error_principal');
        }else{
        $TempInternalOrders->seller_id = $request->seller_id;
        $TempInternalOrders->comision=$request->comision2 * 0.01;
        $TempInternalOrders->save();
        //dd($request->comision2,$TempInternalOrders->comision);
        $CustomerAddress = CustomerShippingAddress::where('customer_id', $TempInternalOrders->customer_id)->first();
       
        if(!$CustomerAddress){
            
            $CustomerShippingAddres = new CustomerShippingAddress();
            $CustomerShippingAddres->customer_id = $Customers->id;
            $CustomerShippingAddres->customer_shipping_alias = "DOMICILIO FISCAL";
            $CustomerShippingAddres->customer_shipping_state = $Customers->customer_state;
            $CustomerShippingAddres->customer_shipping_city = $Customers->customer_city;
            $CustomerShippingAddres->customer_shipping_suburb = $Customers->customer_suburb;
            $CustomerShippingAddres->customer_shipping_street = $Customers->customer_street;
            $CustomerShippingAddres->customer_shipping_outdoor = $Customers->customer_outdoor;
            $CustomerShippingAddres->customer_shipping_indoor = $Customers->customer_indoor;
            $CustomerShippingAddres->customer_shipping_zip_code = $Customers->customer_zip_code;
            $CustomerShippingAddres->save();   
        }
        $CustomerShippingAddresses = CustomerShippingAddress::where('customer_id', $Customers->id)->get();
        
        
        $contactos=CustomerContact::where('customer_id',$Customers->id)->get();
        TempItem::truncate();
        
        return view('internal_orders.capture_order_shippment_addresses', compact(
            'TempInternalOrders',
            'Customers',
            'CustomerShippingAddresses',
            'contactos',
           
        ));}
    }

    public function partida(Request $request)
    {
        
        if($request->shipment == 'Sí'){
            $CustomerShippingAddresses = CustomerShippingAddress::where('id', $request->shipping_address)->first();
        }else{
            $CustomerShippingAddresses = CustomerShippingAddress::where('customer_id', $request->customer_id)->first();
        }

        $TempInternalOrders = TempInternalOrder::where('id', $request->temp_internal_order_id)->first();
        $TempInternalOrders->shipment = $request->shipment;
        $TempInternalOrders->customer_shipping_address_id = $CustomerShippingAddresses->id;
        $TempInternalOrders->save();
        

        $Customers = Customer::where('id', $request->customer_id)->first();
        $TempItems = TempItem::where('temp_internal_order_id', $TempInternalOrders->id)->get();

        if(count($TempItems) > 0){
            $Subtotal = TempItem::where('temp_internal_order_id', $TempInternalOrders->id)->sum('import');
            $TempItems = TempItem::orderBy('item', 'DESC')->where('temp_internal_order_id', $TempInternalOrders->id)->first();
            $ITEM = $TempItems->item;
        }else{
            $Subtotal = '0';
            // $ITEM = '';
        }

        $Iva = $Subtotal * 0.16;
        $Total = $Subtotal + $Iva;
        $cat=" ";
        $desc=" ";
        $obs=" ";
        return view('internal_orders.capture_order_items', compact(
            'TempInternalOrders',
            'Customers',
            'CustomerShippingAddresses',
            'TempItems',
            'Subtotal',
            'Iva',
            'Total',
            'cat','desc','obs'
            // 'ITEM',
        ));
        
    }

public function recalcular_total($id){
    $InternalOrder=InternalOrder::find($id);
    $Items=Item::where('internal_order_id',$id)->get();
    
    $InternalOrder->subtotal=$Items->sum('import');
    $InternalOrder->save();
    //dd($Items->where('family','=','FLETE')->sum('import')*$InternalOrder->tasa);
    $ret=$Items->where('family','=','FLETE')->sum('import')*$InternalOrder->tasa;
    $sub_con_descuento=$InternalOrder->subtotal*(1-$InternalOrder->descuento);
    $factor_aumento= +$InternalOrder->ieps+$InternalOrder->isr+0.16;
    $InternalOrder->total=$sub_con_descuento*($factor_aumento+1)-$ret ;
    $InternalOrder->save();
}
    
    public function store(Request $request)
    {
        $noha=InternalOrder::all()->count();
        $Id = $request->temp_internal_order_id;
        $TempInternalOrders = TempInternalOrder::find($Id);
        $TempInternalOrders->subtotal = $request->subtotal;
        $TempInternalOrders->iva = $request->iva;
        $TempInternalOrders->observations = $request->observations;
        //variable para calcular la retencion del iva
        $ret=0;
        $TempInternalOrders->status = 'CAPTURADO';
        if($TempInternalOrders->noha ==0 ){
            $TempInternalOrders->noha=$noha;
        }
        
        $TempInternalOrders->save();
        $Authorizations = Authorization::where('id', '<>', 1)->orderBy('clearance_level', 'ASC')->get();
        
        $InternalOrders = InternalOrder::orderBy('id', 'DESC')->first();
        $Invoice = '100';
        if($InternalOrders){
            $Invoice = $InternalOrders->invoice + 1;
        }
        
           
            $I=InternalOrder::find($TempInternalOrders->id);
            if($I){
                InternalOrder::destroy($TempInternalOrders->id);
            }
            $InternalOrders = new InternalOrder();
            $InternalOrders->id = $TempInternalOrders->id;
            if($TempInternalOrders->invoice != 0){
                $InternalOrders->invoice = $TempInternalOrders->invoice;
            }else{
                $InternalOrders->invoice=$Invoice;
            }
            $InternalOrders->date = $TempInternalOrders->date;
            $InternalOrders->customer_id = $TempInternalOrders->customer_id;
            $InternalOrders->seller_id = $TempInternalOrders->seller_id;
            $InternalOrders->comision = $TempInternalOrders->comision;
            $InternalOrders->date_delivery = $TempInternalOrders->date_delivery;
            $InternalOrders->instalation_date = $TempInternalOrders->instalation_date;
            $InternalOrders->reg_date = $TempInternalOrders->reg_date;
            $InternalOrders->shipment = $TempInternalOrders->shipment;
            $InternalOrders->customer_shipping_address_id = $TempInternalOrders->customer_shipping_address_id;
            $InternalOrders->coin_id = $TempInternalOrders->coin_id;
            $InternalOrders->subtotal = $TempInternalOrders->subtotal;
            $InternalOrders->iva = $TempInternalOrders->iva;
            $InternalOrders->total = $TempInternalOrders->total;
            $InternalOrders->payment_conditions = $TempInternalOrders->payment_conditions;
            $InternalOrders->observations = $TempInternalOrders->observations;
            $InternalOrders->status = $TempInternalOrders->status;
            $InternalOrders->oc = $TempInternalOrders->oc;
            $InternalOrders->ncontrato = $TempInternalOrders->ncontrato;
            $InternalOrders->dgi = $TempInternalOrders->dgi;
            $InternalOrders->otra = $TempInternalOrders->otra;
            $InternalOrders->ieps = $TempInternalOrders->ieps;
            $InternalOrders->isr = $TempInternalOrders->isr;
            $InternalOrders->tasa = $TempInternalOrders->tasa;
            $InternalOrders->ncotizacion = $TempInternalOrders->ncotizacion;
            $InternalOrders->noha = $TempInternalOrders->noha;
            $InternalOrders->descuento = $TempInternalOrders->descuento;
            $InternalOrders->authorization_id = 1;
            $InternalOrders->category = $request->category;
            $InternalOrders->description = $request->description;
            $InternalOrders->save();
            $contactos=order_contacts::where('temp_order_id',$TempInternalOrders->id)->get();
            foreach($contactos as $c){
                $c->order_id=$InternalOrders->id;
                $c->save();
            }
            $Signature=new signatures();
            $Signature->order_id = $InternalOrders->id;
            $Signature->auth_id = 2;
            $Signature->save();
            if($InternalOrders->subtotal >= 500000){
                    $Signature=new signatures();
                    //$Signature->order_id = $InternalOrders->id;
                    //$Signature->auth_id = 5;
                    //$Signature->save(); 
                    $Signature->order_id = $InternalOrders->id;
                    $Signature->auth_id = 3;
                    $Signature->save(); 
                    $Signature=new signatures();
                    $Signature->order_id = $InternalOrders->id;
                    $Signature->auth_id = 4;
                    $Signature->save(); 
                 }
            if($InternalOrders->subtotal >= 5000000){
                    $Signature=new signatures();
                    $Signature->order_id = $InternalOrders->id;
                    $Signature->auth_id = 6;
                    $Signature->save(); 
                 }

            $TempItems = TempItem::where('temp_internal_order_id', $TempInternalOrders->id)->get();
            $t=0;
            foreach($TempItems as $row){
                $Items = new Item();
                $Items->internal_order_id = $row->temp_internal_order_id;
                $Items->item = $row->item;
                $Items->amount = $row->amount;
                $Items->unit = $row->unit;
                $Items->family = $row->family;
                
                $Items->subfamilia = $row->subfamilia;
                $Items->categoria = $row->categoria;
                $Items->products = $row->products;
                $Items->code = $row->code;
                $Items->racks = $row->racks;
                $Items->fab = $row->fab;
                $Items->sku = $row->sku;
                $Items->description = $row->description;
                $Items->unit_price = $row->unit_price;
                $Items->import = $row->import;
                $Items->save();
                $t=$t+$Items->import;
                if($Items->categoria=='Servicios'){
                    $ret=$ret+$Items->amount*0.04;
                }
            }
            
            $TempItems = TempItem::where('temp_internal_order_id', $TempInternalOrders->id)->get();
            foreach($TempItems as $rs){
                TempItem::destroy($rs->id);
            }
            $tcomisiones=temp_comissions::where('temp_order_id',$TempInternalOrders->id)->get();
            foreach($tcomisiones as $tc){
                $comision=new comissions();
                $comision->order_id=$InternalOrders->id;
                $comision->percentage=$tc->percentage;
                $comision->description=$tc->description;
                $comision->dgi=0;

                $comision->seller_id=$tc->seller_id;
                $comision->save();
                temp_comissions::destroy($tc->id);
            }
            TempInternalOrder::destroy($TempInternalOrders->id);
            //$InternalOrders->ret=$ret;
            
            $factor_aumento= +$TempInternalOrders->ieps+$TempInternalOrders->isr+$TempInternalOrders->tasa+0.16;
            $InternalOrders->total=$t*($factor_aumento-$InternalOrders->descuento)+$ret +$t;
            
            
            $InternalOrders->save();
            $this->recalcular_total($InternalOrders->id);
            // return pay_contitions con internal order id
            // $InternalOrders->id
            //return redirect()->route('internal_orders.index')->with('create_reg', 'ok');
            return $this->payment($InternalOrders->id);

             
    }

    public function edit_order($id){
        $this->recalcular_total($id);
        $CompanyProfiles = CompanyProfile::first();
        //$comp=$CompanyProfiles->id;
        $InternalOrders = InternalOrder::find($id);
        
        $Customers = Customer::all();
        $Sellers = Seller::all();
        $CustomerShippingAddresses = CustomerShippingAddress::find($InternalOrders->customer_shipping_address_id);
        $Coins = Coin::all();
        // $TempOrder=TempInternalOrder::find($InternalOrders->id);
        // if($TempOrder){
        // TempInternalOrder::destroy($InternalOrders->id) ;}
        // $TempOrder= new TempInternalOrder();
        // $TempOrder->id=$InternalOrders->id;
        // $TempOrder->date=$InternalOrders->date;
        // $TempOrder->customer_id=$InternalOrders->customer_id;
        // // $TempOrder->date=$InternalOrders->date;
        // // $TempOrder->date=$InternalOrders->date;
        
        // $TempOrder->save();
        $Items = Item::where('internal_order_id', $id)->get();
        $Comisiones=DB::table('comissions')
        ->join('sellers', 'sellers.id', '=', 'comissions.seller_id')
        ->where('order_id',$InternalOrders->id)
        ->select('comissions.*','sellers.seller_name','sellers.iniciales')
        ->get();
        $hoy=now();
        return view('internal_orders.edit_order', compact(
                'CompanyProfiles',
                'InternalOrders',
                'Customers',
                'Sellers',
                'CustomerShippingAddresses',
                'Coins',
                'Items',
                'hoy',
                'Comisiones'
        ));
    }

    public function show($id)
    {
        $CompanyProfiles = CompanyProfile::first();
        $comp=$CompanyProfiles->id;
        $InternalOrders = InternalOrder::find($id);
        $Customers = Customer::find($InternalOrders->customer_id);
        $Contacts =DB::table('order_contacts')
        ->join('customer_contacts', 'customer_contacts.id', '=', 'order_contacts.contact_id')
        ->where('order_contacts.order_id', $id)
        ->select('customer_contacts.*')
        ->get();
        $Sellers = Seller::find($InternalOrders->seller_id);
        $CustomerShippingAddresses = CustomerShippingAddress::find($InternalOrders->customer_shipping_address_id);
        $Coins = Coin::find($InternalOrders->coin_id);
        $Items = Item::where('internal_order_id', $id)->get();
        $requiredSignatures = DB::table('authorizations')
        ->join('signatures', 'authorizations.id', '=', 'signatures.auth_id')
        ->where('signatures.order_id', $id)
        ->select('signatures.*','authorizations.job')
        ->get();
        $Subtotal = $InternalOrders->subtotal;
        $payments=payments::where('order_id',$InternalOrders->id)->get();
        $Authorizations = Authorization::where('id', '<>', 1)->orderBy('clearance_level', 'ASC')->get();
        
        $ASellers = Seller::all();
        $Comisiones=DB::table('comissions')
     ->join('sellers', 'sellers.id', '=', 'comissions.seller_id')
     ->where('order_id',$InternalOrders->id)
     ->select('comissions.*','sellers.seller_name','sellers.iniciales')
     ->get();
     
        return view('internal_orders.show', compact(
            'CompanyProfiles',
            'InternalOrders',
            'Customers',
            'Sellers',
            'CustomerShippingAddresses',
            'Coins',
            'Items',
            'Authorizations',
            'id',
            'requiredSignatures',
            'Contacts',
            'payments',
            'ASellers',
            'Comisiones',
            
        ));
    }
    public function dgi(Request $request){
    
    $internal_order = InternalOrder::find($request->order_id);
    $internal_order ->dgi=$request->dgi *0.01;
    $internal_order->save();
    $comision=new comissions();
    $comision->seller_id=$request->seller_id;
    $comision->order_id=$internal_order->id;
    $comision->percentage=$request->dgi *0.01;
    $comision->dgi=1;
    
    $comision->description='DGI';
    $comision->save();
    return $this->show($internal_order->id);
    }

    public function firmar(Request $request){
    $signature = signatures::find($request->signature_id);
    $internal_order = InternalOrder::find($signature->order_id);
    $auth = Authorization::find($signature->auth_id);
    $stored_key = $auth ->key_code;
    $key_code =  $request->key;
    $isPasswordCorrect = Hash::check($key_code, $stored_key);
    if($isPasswordCorrect){
        $signature->status = 1;
        $signature->firma=Auth::user()->firma;
        $signature->save();
    }
    $required_signatures = signatures::where('order_id',$internal_order->id)->get();
    #$areAllSigns=0;
    $nSigns=$required_signatures->count();
    $areAllSigns=$required_signatures->where('status',1)->count();
    #foreach($required_signatures as $r){
    #    if($r->status == 1){
    #        $areAllSigns+=1;)
    #    }
    #}
    if($areAllSigns ==$nSigns){
    $internal_order->status = 'autorizado';}
    $internal_order->save();
//hay que retornar el id de la orden, no del pago
        return $this->show($internal_order->id);
        //return view('internal_orders.test',compact('signature','internal_order','key_code','isPasswordCorrect','stored_key'));
    }
//recibe el id de la orden
    public function payment($id)
    {
        $CompanyProfiles = CompanyProfile::first();
        $InternalOrders = InternalOrder::find($id);
        $date=$InternalOrders->date_delivery;
        $Customers = Customer::find($InternalOrders->customer_id);
        $Sellers = Seller::find($InternalOrders->seller_id);
        $CustomerShippingAddresses = CustomerShippingAddress::find($InternalOrders->customer_shipping_address_id);
        $Coins = Coin::find($InternalOrders->coin_id);
        $Items = Item::where('internal_order_id', $id)->get();
        $aux_count=0;
        $Subtotal = $InternalOrders->subtotal;
        $npagos=(int)$InternalOrders->payment_conditions;
        $Authorizations = Authorization::where('id', '<>', 1)->orderBy('clearance_level', 'ASC')->get();
        
        $actualized = " ";
        return view('internal_orders.payment', compact(
            'CompanyProfiles',
            'InternalOrders',
            'Customers',
            'Sellers',
            'CustomerShippingAddresses',
            'Coins',
            'Items',
            'Authorizations',
            'Subtotal',
            'id',
            'actualized',
            'aux_count',
            'npagos',
            'date',
        ));

    }

    public function payment_edit($id)
    {
        
        $CompanyProfiles = CompanyProfile::first();
        $InternalOrders = InternalOrder::find($id);
        $payments = payments::where('order_id', $id)->get();
        $pagados = $payments->where('status','pagado');
        $no_pagados =$payments->where('status','por cobrar');
        $pe=$no_pagados->sum('percentage');
        $npagos=$payments->count();
        $npagados=$pagados->count();
        $Customers = Customer::find($InternalOrders->customer_id);
        $Sellers = Seller::find($InternalOrders->seller_id);
        $CustomerShippingAddresses = CustomerShippingAddress::find($InternalOrders->customer_shipping_address_id);
        $Coins = Coin::find($InternalOrders->coin_id);
        $Items = Item::where('internal_order_id', $id)->get();
        $numpagos=(int)$InternalOrders->payment_conditions;
        $Subtotal = $InternalOrders->subtotal;
        $Total = $InternalOrders->total;
        $Authorizations = Authorization::where('id', '<>', 1)->orderBy('clearance_level', 'ASC')->get();
        $aux_count=1;
        $actualized = " ";
        return view('internal_orders.edit_pay', compact(
            'CompanyProfiles',
            'InternalOrders',
            'Customers',
            'Sellers',
            'CustomerShippingAddresses',
            'Coins',
            'Items',
            'Authorizations',
            'Subtotal',
            'Total',
            'id',
            'actualized',
            'payments',
            'pagados',
            'no_pagados',
            'pe',
            'npagos',
            'npagados',
            'aux_count',
            'numpagos'
        ));

    }
    
    //cambiar a que en ves de request traireciba solo el id
    public function pay_conditions(Request $request)
    {
        $CompanyProfiles = CompanyProfile::first();
        $InternalOrders = InternalOrder::find($request->order_id);
        $Customers = Customer::find($request->customerID);
        $Sellers = Seller::find($request->sellerID);
        $CustomerShippingAddresses = CustomerShippingAddress::find($request->customerAdressID);
        $Coins = Coin::find($request->coinID);
        $Items = Item::where('internal_order_id', $request->order_id)->get();
        $actualized='';
        $Subtotal = $request->subtotal;
        $nRows = $request->rowcount;
        $payments = payments::where('order_id', $request->order_id)->delete();
        $hpayments = historical_payments::where('order_id', $request->order_id)->delete();
        
        for($i=1; $i < $nRows+1; $i++) {
             
            $this_payment= new payments(); 
            $hpayment= new historical_payments(); 
            $this_payment->order_id = $request->order_id;
            $this_payment->concept = $request->get('concepto')[$i];
            $this_payment->percentage = $request->get('porcentaje')[$i];
            $this_payment->amount = $InternalOrders->total*$this_payment->percentage*0.01;
            $this_payment->date = $request->get('date')[$i];
            //$this_payment->nota = $request->get('nota')[$i];
            $this_payment->save();
            
            $hpayment->order_id = $request->order_id;
            $hpayment->concept = $request->get('concepto')[$i];
            $hpayment->percentage = $request->get('porcentaje')[$i];
            $hpayment->amount = (float)$InternalOrders->total*(float)$this_payment->percentage*0.01;
            $hpayment->date = $request->get('date')[$i];
            //$hpayment->nota = $request->get('nota')[$i];
            $hpayment->save();
        }
        $Authorizations = Authorization::where('id', '<>', 1)->orderBy('clearance_level', 'ASC')->get();

        #ahora hay que traer de la base de datos lo que se acaba de guardar
        $payments = payments::where('order_id', $request->order_id)->get();
        $abonos = payments ::where('status','pagado')->where('order_id', $request->order_id)->get();
        $hpayments = historical_payments::where('order_id', $request->order_id)->get();
        
        $diferencia=100-$payments->sum('percentage');

        
            $ultimo=$payments->last();
            $ultimo->percentage=$ultimo->percentage+$diferencia;
            $ultimo->amount=$InternalOrders->total*$ultimo->percentage*0.01;
            $ultimo->save();
            $ultimo=$hpayments->last();
            $ultimo->percentage=$ultimo->percentage+$diferencia;
            $ultimo->amount=$InternalOrders->total*$ultimo->percentage*0.01;
            $ultimo->save();
        
        
        //return view('internal_orders.store_payment', compact(
            //'CompanyProfiles','InternalOrders','Customers','Sellers','CustomerShippingAddresses','Coins',
            //'Items','Authorizations','Subtotal','actualized','nRows','payments',
            //'hpayments','abonos',));
            return redirect('internal_orders/'.$InternalOrders->id);
    }

    public function pay_redefine(Request $request)
    {
        $CompanyProfiles = CompanyProfile::first();
        $InternalOrders = InternalOrder::find($request->order_id);
        $Customers = Customer::find($request->customerID);
        $Sellers = Seller::find($request->sellerID);
        $CustomerShippingAddresses = CustomerShippingAddress::find($request->customerAdressID);
        $Coins = Coin::find($request->coinID);
        $Items = Item::where('internal_order_id', $request->order_id)->get();
        $correcto=''; 
        $Subtotal = $request->subtotal;
        $nRows = $request->rowcount;
        $actualized='';
        $old_payments = payments::where('order_id', $request->order_id)
        ->where('status','por cobrar')
        ->delete();
        for($i=$request->pagados; $i < $nRows; $i++) {
             
            $this_payment= new payments(); 
            $this_payment->order_id = $request->order_id;
            $this_payment->concept = $request->get('CONCEPTO')[$i];
            $this_payment->percentage = (float)$request->get('porcentaje')[$i];
            $this_payment->amount = (float)$Subtotal*(float)$this_payment->percentage*0.0116;
            $this_payment->date = $request->get('date')[$i];
          //$this_payment->nota = $request->get('nota')[$i];
            $this_payment->save();
        }
        $Authorizations = Authorization::where('id', '<>', 1)->orderBy('clearance_level', 'ASC')->get();

        #ahora hay que traer de la base de datos lo que se acaba de guardar
        $payments = payments::where('order_id', $request->order_id)->get();
        $hpayments = historical_payments::where('order_id', $request->order_id)->get();
        $abonos = payments ::where('status','pagado')->where('order_id', $request->order_id)->get();
        
        
        return view('internal_orders.store_payment', compact(
            'CompanyProfiles',
            'InternalOrders',
            'Customers',
            'Sellers',
            'CustomerShippingAddresses',
            'Coins',
            'Items',
            'Authorizations',
            'Subtotal',
            'actualized',
            'nRows',
            'payments',
            'hpayments',
            'abonos',
        ));
    }

    public function pagos(Request $request){
        $id = $request->order_id;
        //$InternalOrders = InternalOrder::find($id);
        $payments = payments::where('order_id', $id)->get();
        $hpayments = historical_payments::where('order_id', $id)->get();
        $npagos = $payments->count();


        if($npagos > 0){// si no hay pagos, crear pagos
            $CompanyProfiles = CompanyProfile::first();
        $InternalOrders = InternalOrder::find($id);
        $Customers = Customer::find($InternalOrders->customer_id);
        $Sellers = Seller::find(1);
        $CustomerShippingAddresses = CustomerShippingAddress::find($InternalOrders->customerAdress_id);
        $Coins = Coin::find($InternalOrders->coin_id);
        $Items = Item::where('internal_order_id', $id)->get();
        $actualized='';
        $Subtotal = $InternalOrders->subtotal;
        $abonos = payments ::where('status','pagado')->where('order_id', $id)->get();
            return view('internal_orders.store_payment', compact(
                'CompanyProfiles',
                'InternalOrders',
                'Customers',
                'Sellers',
                'CustomerShippingAddresses',
                'Coins',
                'Items',
                
                'Subtotal',
                'actualized',
                'payments',
                'hpayments',
                'abonos',
            ));
            
        }else{
            return $this->payment($id);

        }
    // si hay pagos mostrar el iva uwu
    //mostrar saldo del cliente en la parte de clientes
    }
   

    public function destroy($id)
    {
     $partidas=Item::where('internal_order_id',$id);
     $partidas->delete();
     
     $pagos=payments::where('order_id',$id);
     $pagos->delete();
     
     $hpagos=historical_payments::where('order_id',$id);
     $hpagos->delete();
     

     $firmas=signatures::where('order_id',$id);
     $firmas->delete();

     $Cobros=Cobro::where('order_id',$id)->get();
     foreach($Cobros as $c){
        (new CobrosController)->destroy($c->id);
     }
     
     $Facturas=Factures::where('order_id',$id)->get();
     foreach($Facturas as $f){
        (new FactureController)->destroy($f->id);
     }
     $Notas=CreditNote::where('order_id',$id)->get();
     foreach($Notas as $n){
        (new NotasCreditoController)->destroy($n->id);
     }
     $orden=InternalOrder::find($id);
     $orden->delete();

     

     return $this->index();
    }
    public function redefine(Request $request)
    {
        $id=$request->internal_order_id;
        $InternalOrders = InternalOrder::find($id);
        $pagos=payments::where('order_id',$id)->delete();
        $signatures=signatures::where('order_id',$id)->delete();
        //reasignarle Todo
        $InternalOrders->customer_id=$request->customer_id;
        $InternalOrders->coin_id=$request->coin_id;
        $InternalOrders->seller_id=$request->seller_id;
        $InternalOrders->reg_date=$request->reg_date;
        $InternalOrders->date_delivery=$request->date_delivery;
        $InternalOrders->instalation_date=$request->instalation_date;
        $InternalOrders->payment_conditions=$request->payment_conditions;
        
        $InternalOrders->dgi=$request->dgi* 0.01;
        $InternalOrders->comision=$request->comision* 0.01;
        $InternalOrders->otra=$request->otra* 0.01;
        
        $InternalOrders->description=$request->description;
        $InternalOrders->observations=$request->observations;
        $InternalOrders->category=$request->category;

        $InternalOrders->descuento=$request->descuento* 0.01;
        
        $InternalOrders->tasa=$request->tasa* 0.01;
        $InternalOrders->status="CAPTURADO";
        $Items = Item::where('internal_order_id', $InternalOrders->id)->get();
            if(count($Items) > 0){
                    $Subtotal = Item::where('internal_order_id', $InternalOrders->id)->sum('import');
                }else{
                    $Subtotal = '0';
                }
        
                $Iva = $Subtotal * 0.16;
                $Total = $Subtotal + $Iva;
        $InternalOrders->subtotal = $Subtotal;
        $InternalOrders->iva = $Iva;
        $InternalOrders->total = $Total;
        $InternalOrders->save();
        $Signature=new signatures();
            $Signature->order_id = $InternalOrders->id;
            $Signature->auth_id = 2;
            $Signature->save();
            if($InternalOrders->subtotal >= 500000){
                    $Signature=new signatures();
                    //$Signature->order_id = $InternalOrders->id;
                    //$Signature->auth_id = 5;
                    //$Signature->save(); 
                    $Signature->order_id = $InternalOrders->id;
                    $Signature->auth_id = 3;
                    $Signature->save(); 
                    $Signature=new signatures();
                    $Signature->order_id = $InternalOrders->id;
                    $Signature->auth_id = 4;
                    $Signature->save(); 
                 }
            if($InternalOrders->subtotal >= 5000000){
                    $Signature=new signatures();
                    $Signature->order_id = $InternalOrders->id;
                    $Signature->auth_id = 6;
                    $Signature->save(); 
                 }
             
        
        $this->recalcular_total($id);         
        return $this->payment($id);
    }

    public function edit_temp_comissions($id){
        $Comission=temp_comissions::find($id);
        $TempInternalOrders = TempInternalOrder::find($Comission->temp_order_id);
        $Sellers = Seller::all();
        return view('internal_orders.edit_comission', compact(
            'Comission',
            'TempInternalOrders',
            'Sellers',
        ));
    }
    public function update_temp_comissions($id,Request $request){
        $TempInternalOrders = TempInternalOrder::find($request->temp_order_id);
        $Comission=temp_comissions::find($id);
        $Comission->seller_id=$request->seller_id;
        $Comission->percentage=$request->comision*0.01;
        $Comission->description=$request->description;
        $Comission->save();
        return $this->capture_comissions($TempInternalOrders->id,' ');
    }
    public function delete_temp_comissions($id){
        $Comission=temp_comissions::find($id);
        $TempInternalOrders = TempInternalOrder::find($Comission->temp_order_id);
        temp_comissions::destroy($id);
        return $this->capture_comissions($TempInternalOrders->id,' ');
    }
    
    public function edit_comissions($id){
        $Comission=comissions::find($id);
        $InternalOrders = InternalOrder::find($Comission->order_id);
        $Sellers = Seller::all();
        return view('internal_orders.edit_comission_real', compact(
            'Comission',
            'InternalOrders',
            'Sellers',
        ));
    }
    public function update_comissions($id,Request $request){
        $InternalOrders = InternalOrder::find($request->order_id);
        $Comission=comissions::find($id);
        $Comission->seller_id=$request->seller_id;
        $Comission->percentage=$request->comision*0.01;
        $Comission->description=$request->description;
        $Comission->save();
        return redirect('internal_orders/edit/'.$InternalOrders->id);
    }
    public function delete_comissions($id){
        $Comission=comissions::find($id);
        $InternalOrders = InternalOrder::find($Comission->order_id);
        comissions::destroy($id);
        return redirect('internal_orders/edit/'.$InternalOrders->id);
    }
    public function exterminio(){
        comissions::truncate();
        signatures::truncate();
        historical_payments::truncate();
        payments::truncate();
        Item::truncate();
        TempItem::truncate();
        //TempInternalOrder::truncate();
        
        InternalOrder::truncate();
        return $this->index();
    }
}


