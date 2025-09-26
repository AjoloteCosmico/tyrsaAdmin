<?php

namespace App\Http\Controllers;
use Session;
use App\Models\Authorization;
use App\Models\InternalOrder;
use App\Models\Coin;
use App\Models\Cantidades;
use App\Models\Cobro;
use App\Models\Factures;
use App\Models\CreditNote;
use App\Models\CompanyProfile;
use App\Models\Customer;
use App\Models\CustomerShippingAddress;
use App\Models\CustomerContact;
use App\Models\Item;
use App\Models\Marca;
use App\Models\Medio;

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

use PDF;
class InternalOrderController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('VER TODOS LOS PEDIDOS')){
            
            $InternalOrders = DB::table('customers')
                ->join('internal_orders', 'internal_orders.customer_id', '=', 'customers.id')
                ->join('sellers', 'internal_orders.seller_id','=','sellers.id')
                ->join('coins', 'internal_orders.coin_id','=','coins.id')
                ->select('internal_orders.*','customers.customer','customers.clave', 'sellers.seller_name','coins.code')
                ->orderBy('internal_orders.invoice', 'DESC')
                ->get();  }   
            else{
                
            $Seller=Seller::where('seller_name',Auth::user()->name)->first();
            if($Seller){
                $Seller_key=$Seller->id;
            }else{
                $Seller_key=-1;
            }
            
           $InternalOrders = DB::table('customers')
            ->join('internal_orders', 'internal_orders.customer_id', '=', 'customers.id')
            ->join('sellers', 'internal_orders.seller_id','=','sellers.id')
             ->join('coins', 'internal_orders.coin_id','=','coins.id')
                
            
            // ->where('customers.seller_id',$Seller_key)
            ->where('internal_orders.seller_id',$Seller_key)
            ->select('internal_orders.*','customers.customer','customers.clave', 'sellers.seller_name','coins.code')
            
            ->orderBy('internal_orders.invoice', 'DESC')
            ->get();
            }
        //$InternalOrders = vinternal_orders::all();
       
        return view('internal_orders.index', compact('InternalOrders'));
    }

    public function create()
    {
        $Medios=Medio::all();
        $NextInvoice = InternalOrder::orderBy('invoice', 'DESC')->first()->invoice+1;
        if(Auth::user()->can('CAPTURAR PEDIDO TODOS LOS CLIENTES')){
            
        $Customers = Customer::all()->sortBy('clave');
        }   
        else{
            $Seller_key=Auth::user()->name;
            $Customers= $Customers = DB::table('customers')->leftJoin('sellers','sellers.id','=','customers.seller_id')
            ->select('customers.*','sellers.iniciales')
            ->where('sellers.seller_name',$Seller_key)->orderBy('clave')->get();
            // dd($Customers);
        }
        $contactos=CustomerContact::all();
        return view('internal_orders.create', compact(
            'Customers',
            'Medios',
            'contactos',
            'NextInvoice',

        ));
    }

    public function capture(Request $request)
    {
        
        $rules = [
            'invoice' => 'unique:internal_orders,invoice',
             'noha'=>  'unique:internal_orders,noha',
             'medio'=>  'required'
            ];
        $request->validate($rules);

        $NextInvoice = InternalOrder::orderBy('invoice', 'DESC')->first()->invoice+1;
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
            $TempInternalOrder->medio_id = $request->medio;
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
            'NextInvoice',
        ));
    }
   
    public function comissions(Request $request)
    {              
    $rules = [
        'customer_id' => 'required',
        'temp_internal_order_id' => 'required',
        'date_delivery' => 'required',
        'instalation_date' => 'required',
        'coin_id' => 'required',
        'payment_conditions'=> 'required',
        'seller_id' => 'required',
    ];

    $messages = [
        'customer_id.required' => 'Los datos del Cliente son necesarios',
        'temp_internal_order_id.required' => 'Existe un error en el pedido',
        'date_delivery.required' => 'La feha de entrega es necesaria',
        'instalation_date.required' => 'La fecha de Instalación es necesaria',
        'coin_id.required' => 'El tipo de Moneda es necesario',
        'payment_conditions.required' => 'Las condiciones de pago son necesarios',
        'seller_id.required' => 'Elija un vendedor',
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
    
    $TempInternalOrders->seller_id = $request->seller_id;
    $TempInternalOrders->tasa = $request->tasa*0.01;
    $TempInternalOrders->save();
    $Customers = Customer::where('id', $TempInternalOrders->customer_id)->first();
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
           
        ));
    // temp_comissions::truncate();
    // $Sellers = Seller::all();
    // $Comisiones=DB::table('temp_comissions')
    //  ->join('sellers', 'sellers.id', '=', 'temp_comissions.seller_id')
    //  ->where('temp_order_id',$TempInternalOrders->id)
    //  ->select('temp_comissions.*','sellers.seller_name','sellers.iniciales')
    //  ->get();
    //  session(['p_comission' => Cantidades::find(1)->cant]);
    //  session(['p_seller_id' => ' ']);
    //  #Asignar automaticamente DGI
    //  $Socios=Seller::where('dgi','>',0)->get();
    // //  dd($Socios);
    //  foreach($Socios as $socio){
        
    //  $comision = new temp_comissions();
    //  $comision->seller_id=$socio->id;
    //  $comision->percentage=$socio->dgi*0.01;
    //  $comision->temp_order_id=$TempInternalOrders->id;
    //  $comision->description='DGI';
    //  $comision->save();
    //  }
    // return $this->capture_comissions($TempInternalOrders->id,' ');
    // }


    // public function capture_comissions($id,$message){
    // $FixedComision=Cantidades::find(1)->cant;
    // $TempInternalOrders = TempInternalOrder::where('id', $id)->first();
    // $Message=$message;
    // if(Auth::user()->can('CAPTURAR PEDIDO TODOS LOS CLIENTES')){
    // $Sellers = Seller::all();
    // }else {
        
    //     $Seller=Seller::where('seller_name',Auth::user()->name)->first();
    //     $Sellers = Seller::where('id',$Seller->id)->get();
    //     # code...
    // }
    // $Comisiones=DB::table('temp_comissions')
    //  ->join('sellers', 'sellers.id', '=', 'temp_comissions.seller_id')
    //  ->where('temp_order_id',$TempInternalOrders->id)
    //  ->select('temp_comissions.*','sellers.seller_name','sellers.iniciales')
    //  ->get();
    //  $p_comission=Session::get('p_comission');
    //  $p_seller_id=Session::get('p_seller_id');
    // return view('internal_orders.capture_comissions', compact(
    //     'TempInternalOrders','Sellers','Comisiones','Message','p_seller_id','p_comission','FixedComision'
        
    // ));
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
        if($request->origin=='edit_dgi'){
            return redirect()->route('change_dgi',$InternalOrders->id)->with([ 'duplicated' => 'Si' ]);
          }else{
         return redirect()->route('internal_orders.edit_order',$InternalOrders->id)->with([ 'duplicated' => 'Si' ]);}
      }else{
      $comision = new comissions();
      $comision->seller_id=$request->seller_id;
      $comision->percentage=$request->comision*0.01;
      $comision->order_id=$InternalOrders->id;
      $comision->description=$request->description;
      $comision->save();
      
      if($request->origin=='edit_dgi'){
        return redirect()->route('change_dgi',$InternalOrders->id)->with([ 'created' => 'Si' ]);
      }else{
      return redirect('internal_orders/edit/'.$InternalOrders->id);}}
     }
    

    public function shipment(Request $request)
    {   
        
        $TempInternalOrders = TempInternalOrder::where('id', $request->temp_internal_order_id)->first();
        $Customers = Customer::where('id', $TempInternalOrders->customer_id)->first();
        $CustomerShippingAddresses = CustomerShippingAddress::where('customer_id', $TempInternalOrders->customer_id)->get();
        //Si el vendedor principal es un socio, eliminar la comision y continuar normal
        // $Seller=Seller::find($request->seller_id);
        // if($Seller->dgi > 0){
        //     temp_comissions::where('seller_id',$request->seller_id)
        //     ->where('temp_order_id',$TempInternalOrders->id)
        //     ->delete();
        // }
        //SI el vendedor principal es socio, quitar la comsion dgi
        $PrincipalSeller=Seller::find($request->seller_id);
        if($PrincipalSeller->dgi>0){
            temp_comissions::where('seller_id',$request->seller_id)->delete();
        }
        //verificar que el vendedor principal no tenga comisiones
        $allComissions=temp_comissions::where('seller_id',$request->seller_id)->get();

        if($allComissions->count() > 0){
            //no se puede seleccionar como vendedor principal a quien tiene ya una comision (si es un socio hay que quitarle el dgi)
            return $this->capture_comissions($TempInternalOrders->id,'error_principal');
        }else{
        $TempInternalOrders->seller_id = $request->seller_id;
        $TempInternalOrders->comision=$request->comision2 * 0.01;
        $TempInternalOrders->save();
        // dd($request->comision2);
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
        $Marcas = Marca::all();

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
        
        $marca=" ";
        return view('internal_orders.capture_order_items', compact(
            'TempInternalOrders',
            'Customers',
            'CustomerShippingAddresses',
            'TempItems',
            'Subtotal',
            'Marcas',
            'Iva',
            'Total',
            'cat','desc','obs','marca'
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
    $InternalOrder->total=$sub_con_descuento*($factor_aumento+1)-$ret;
    $InternalOrder->save();
    if($InternalOrder->status=='CANCELADO'){
        $InternalOrder->total=0;
        $InternalOrder->subtotal=0;
        $InternalOrder->save();
    }
}
    
    public function store(Request $request)
    {
        $Year=now()->format('Y');
        $noha=InternalOrder::whereYear('created_at', $Year)->count()+1;
        // dd($noha);
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
        
        $InternalOrders = InternalOrder::orderBy('invoice', 'DESC')->first();
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
            
            // $InternalOrders->marca=10;
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
            $InternalOrders->medio_id = $TempInternalOrders->medio_id;
            
            $InternalOrders->kilos = $request->kilos;
            $InternalOrders->authorization_id = 1;
            $InternalOrders->category = $request->category;
            $InternalOrders->description = $request->description;
            $InternalOrders->marca = $request->marca;
            $InternalOrders->user_id=AUth::user()->id;
            $InternalOrders->tc=Coin::find($TempInternalOrders->coin_id)->exchange_sell;
            $InternalOrders->save();
            $contactos=order_contacts::where('temp_order_id',$TempInternalOrders->id)->get();
            foreach($contactos as $c){
                $c->order_id=$InternalOrders->id;
                $c->save();
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
            //loop para crear las firmas desde la tabla de Autorizations
            $Authorizations=Authorization::all();
           
            foreach($Authorizations as $auth){
             
                if($InternalOrders->total >= (int)($auth->clearance_level)) {
                    
                    $Signature=new signatures();
                    $Signature->order_id = $InternalOrders->id;
                    $Signature->auth_id = $auth->id;
                    $Signature->save(); 
                }
            }
            // return pay_contitions con internal order id
            // $InternalOrders->id
            //return redirect()->route('internal_orders.index')->with('create_reg', 'ok');
            // return $this->payment($InternalOrders->id);
            return redirect()->route('internal_orders.payment',$InternalOrders->id);
    }

    public function edit_order($id){
        Session::put('eliminar', 'nook');
        Session::put('error_delete','nook');
        $InternalOrders = InternalOrder::find($id);
        if($InternalOrders->status!='CAPTURADO'){
            return redirect()->back();
        }
        
        $this->recalcular_total($id);
        $CompanyProfiles = CompanyProfile::first();
        //$comp=$CompanyProfiles->id;
        $InternalOrders = InternalOrder::find($id);
        
        if(Auth::user()->can('CAPTURAR PEDIDO TODOS LOS CLIENTES')){
            
        $Customers = Customer::all()->sortBy('clave');
        }   
        else{
            $Seller_key=Auth::user()->name;
            $Customers= $Customers = DB::table('customers')->leftJoin('sellers','sellers.id','=','customers.seller_id')
            ->select('customers.*','sellers.iniciales')
            ->where('sellers.seller_name',$Seller_key)->orderBy('clave')->get();
            // dd($Customers);
        }
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
        $CustomerShippingAddresses = CustomerShippingAddress::where('customer_id', $InternalOrders->customer_id)->get();
       
        return view('internal_orders.edit_order', compact(
                'CompanyProfiles',
                'InternalOrders',
                'Customers',
                'CustomerShippingAddresses',
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
        ->select('signatures.*','authorizations.titulo')
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
       $Marcas = Marca::all();
        if($payments->count() ==0){
            
            return redirect()->route('internal_orders.payment',$id);
        }
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
            'Marcas',
        ));
    }

    public function print_order($id){
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
         $Marcas = Marca::all();
         $imagePath = public_path('img/logo/logo.png');

         $type = pathinfo($imagePath, PATHINFO_EXTENSION);
         $data = file_get_contents($imagePath);

         $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
         $pdf = PDF::loadView('internal_orders.print_order', compact(
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
            'Marcas',
            'base64')); 

        return $pdf->download('Pedido_interno '.$InternalOrders->invoice.'.pdf');
        // return view('internal_orders.print_order', compact(
        //     'CompanyProfiles',
        //     'InternalOrders',
        //     'Customers',
        //     'Sellers',
        //     'CustomerShippingAddresses',
        //     'Coins',
        //     'Items',
        //     'Authorizations',
        //     'id',
        //     'requiredSignatures',
        //     'Contacts',
        //     'payments',
        //     'ASellers',
        //     'Comisiones',
        //     'base64',
        //     'Marcas')); 
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
        $signature_role_id=DB::table('signatures')
        ->join('authorizations','authorizations.id','signatures.auth_id')
        ->select('signatures.*','authorizations.role_id')
        ->where('signatures.id',$request->signature_id)
        ->first()->role_id;
        //  dd($signature);
        $internal_order = InternalOrder::find($signature->order_id);
        $auth = Authorization::find($signature->auth_id);
        $stored_key = Auth::user()->password;
        $key_code =  $request->key;
        $isPasswordCorrect = Hash::check($key_code, $stored_key);
        $userHasRole=False;
        //verificar que se tenga el rol necesario
        if(Auth::user()->id !=1){//el super usuario no se verifica (ni firma)
            $user_rol_id=DB::table('model_has_roles')->where('model_id',Auth::user()->id)->first()->role_id;
            //revisar los 3 casos de autorizacion
            //IF unico
            if($signature_role_id==$user_rol_id){
                $userHasRole=True;
            }
        }
        if(Auth::user()->id == 1){
            $userHasRole=True;
        }
        if($isPasswordCorrect && $userHasRole ){
            if($signature->auth_id==2){
                
                return $this->comisiones_firmar($internal_order->id,$signature->id);
            }
            $signature->status = 1;
            $signature->firma=Auth::user()->firma;
            $signature->save();
            $Warn='ok';
            //identificar si es la firma del Gerente Ventas roles id 16
            //marcar vent_auth=1
            if($user_rol_id=16){
                $internal_order->vent_auth=1;
                $internal_order->save();
            }
            
        }

        if(!$isPasswordCorrect){$Warn='Contraseña Incorrecta';}
        
        if(!$userHasRole){$Warn='Usuario no autorizado';}
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
            return redirect()->route('internal_orders.show',$internal_order->id)->with('firma',$Warn);
        //return view('internal_orders.test',compact('signature','internal_order','key_code','isPasswordCorrect','stored_key'));
    }
//recibe el id de la orden



    public function comisiones_firmar($id,$signature_id){
        $internal_order = InternalOrder::find($id);
        $Seller=Seller::find($internal_order->seller_id);
        $Sellers = Seller::all();
        $comisiones=comissions::where('order_id',$id)->get();
        $FixedComision=Cantidades::find(1)->cant;
        //  #Asignar automaticamente DGI
        $Socios=Seller::where('dgi','>',0)->get();
        //  dd($Socios);
        comissions::where('order_id', $id)->delete();
        $DGI=comissions::where('order_id',$id)->where('description','DGI')->get();
        if($DGI->count()==0){
            
            foreach($Socios as $socio){
                
            $comision = new comissions();
            $comision->seller_id=$socio->id;
            $comision->percentage=$socio->dgi*0.01;
            $comision->order_id=$id;
            $comision->description='DGI';
            $comision->save();
            }
        }
        $DGI=comissions::where('order_id',$id)->where('description','DGI')->get();

        return view('internal_orders.comisiones_firmar',
        compact('internal_order','comisiones',
                'Seller','FixedComision','Sellers','DGI','signature_id'));
    }

    public function store_comisiones_pos(Request $request){
     
        $internal_order = InternalOrder::find($request->order_id);
        $signature = signatures::find($request->firma_id);
        $signature->status = 1;
        $signature->firma=Auth::user()->firma;
        $signature->save();
        // --- Validaciones adicionales ---
        $total = 0;
        $seenSellers = [];
        $internalOrderId = $request->input('order_id');
        $sellerIds = $request->input('seller_id');
        $comisiones = $request->input('comision');
        $tipos = $request->input('tipo');
        foreach ($sellerIds as $index => $sellerId) {
            
            $com = floatval($comisiones[$index] ?? 0);
            $tipo = $tipos[$index] ?? '';

            
            // regla b) Ningún vendedor duplicado
            // if (in_array($sellerId, $seenSellers)) {
            //     return back()->with('error', 'Un vendedor no puede tener más de una comisión.')->withInput();
            // }
            $seenSellers[] = $sellerId;
            $total += $com;
        }

        // regla c) suma total no debe pasar de 3%
        // if ($total > 3) {
        //     return back()->with('error', "La suma de comisiones ($total%) supera el 3%.")->withInput();
        // }

            DB::transaction(function () use ($internalOrderId, $sellerIds, $comisiones, $tipos) {
                // Primero borra comisiones previas de esta orden (si aplica)
                comissions::where('order_id', $internalOrderId)->delete();
                $index=0;
                foreach ($sellerIds as $i => $sellerId) {
                    if($index==0){
                        
                            $internal_order = InternalOrder::find($internalOrderId);
                            $internal_order->comision=$comisiones[$i]*0.01;
                            $internal_order->save();
                    }else{
                    comissions::create([
                        'order_id' => $internalOrderId,
                        'seller_id'         => $sellerId,
                        'percentage'          => $comisiones[$i]*0.01,
                        'description'              => $tipos[$i],
                    ]);
                    }
                     $index++;
                    
                }
            });

        return redirect()->route('internal_orders.show', $internal_order->id)->with('firma', 'ok');
        
    }



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
        $Cobros=DB::table('cobro_orders')
        ->join('cobros', 'cobros.id', '=', 'cobro_orders.cobro_id')
        ->select('cobros.comp','cobros.date','cobro_orders.*')
        ->where('cobro_orders.order_id',$id)->get();
        
        $actualized = " ";
        return view('internal_orders.payment', compact(
            'CompanyProfiles',
            'InternalOrders',
            'Customers',
            'Sellers',
            'CustomerShippingAddresses',
            'Coins',
            'Cobros',
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
        $InternalOrders->payment_observations=$request->payment_observations;
        $InternalOrders->save();
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
        if($request->rowcount!=$InternalOrders->payment_conditions){
            return redirect()->back()->with('no_coinciden','ok');
        }
        
        for($i=1; $i < $nRows+1; $i++) {
            $this_payment= new payments(); 
            $hpayment= new historical_payments(); 
            $this_payment->order_id = $request->order_id;
            $this_payment->concept = $request->get('concepto')[$i];
            $this_payment->percentage = $request->get('porcentaje')[$i];
            $this_payment->payment_method = $request->get('forma')[$i];
            $this_payment->amount = $InternalOrders->total*$this_payment->percentage*0.01;
            $this_payment->date = $request->get('date')[$i];
            //$this_payment->nota = $request->get('nota')[$i];
            $this_payment->save();
            
            $hpayment->order_id = $request->order_id;
            $hpayment->concept = $request->get('concepto')[$i];
            $hpayment->percentage = $request->get('porcentaje')[$i];
            $hpayment->payment_method = $request->get('forma')[$i];
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
        // $abonos = payments ::where('status','pagado')->where('order_id', $request->order_id)->get();
        $abonos=DB::table('cobro_orders')->where('order_id',$InternalOrders->id)->get();
        
        
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
        // $abonos = payments ::where('status','pagado')->where('order_id', $id)->get();
        $abonos=DB::table('cobro_orders')->where('order_id',$InternalOrders->id)->get();

        $Cobros=DB::table('cobro_orders')
        ->join('cobros', 'cobros.id', '=', 'cobro_orders.cobro_id')
        ->select('cobros.comp','cobros.date','cobro_orders.*')
        ->where('cobro_orders.order_id',$id)->get();

            return view('internal_orders.store_payment', compact(
                'CompanyProfiles',
                'InternalOrders',
                'Customers',
                'Sellers',
                'CustomerShippingAddresses',
                'Coins',
                'Items',
                'Cobros',
                'Subtotal',
                'actualized',
                'payments',
                'hpayments',
                'abonos',
            ));
            
        }else{
            return redirect()->route('internal_orders.payment',$id);

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
        if($InternalOrders->payment_conditions==$request->payment_conditions){
            $PagosWasChanged=FALSE;
        }else{
            $PagosWasChanged=TRUE;
            $pagos=payments::where('order_id',$id)->delete();
        }
        
        $signatures=signatures::where('order_id',$id)->delete();
        //reasignarle Todo
        // $InternalOrders->customer_id=$request->customer_id;
        $InternalOrders->coin_id=$request->coin_id;
        $InternalOrders->seller_id=$request->seller_id;
        $InternalOrders->reg_date=$request->reg_date;
        $InternalOrders->date_delivery=$request->date_delivery;
        $InternalOrders->instalation_date=$request->instalation_date;
        $InternalOrders->payment_conditions=$request->payment_conditions;
        
        $InternalOrders->dgi=$request->dgi* 0.01;
        $InternalOrders->comision=$request->comision* 0.01;
        $InternalOrders->otra=$request->otra* 0.01;
        $InternalOrders->kilos=$request->kilos;
        
        $InternalOrders->description=$request->description;
        $InternalOrders->observations=$request->observations;
        $InternalOrders->category=$request->category;

        $InternalOrders->descuento=$request->descuento* 0.01;
        
        $InternalOrders->oc=$request->oc;
        $InternalOrders->ncotizacion=$request->ncotizacion;
        $InternalOrders->ncontrato=$request->ncontrato;

        //embarques
        if($request->shipment == 'Sí'){
            $CustomerShippingAddresses = CustomerShippingAddress::where('id', $request->shipping_address)->first();
        }else{
            $CustomerShippingAddresses = CustomerShippingAddress::where('customer_id', $request->customer_id)->first();
        }

        $InternalOrders->shipment = $request->shipment;
        $InternalOrders->customer_shipping_address_id = $CustomerShippingAddresses->id;
        
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
        $this->recalcular_total($id);
        $Authorizations=Authorization::all();
           
            foreach($Authorizations as $auth){
                if($InternalOrders->total>=$auth->clearance_level) {
                    $Signature=new signatures();
                    $Signature->order_id = $InternalOrders->id;
                    $Signature->auth_id = $auth->id;
                    $Signature->save(); 
                }
            }
             
        
        
        if($PagosWasChanged){
            return $this->payment($id);
        }else{
            return redirect()->route('internal_orders.show',$id);
        }         
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
    
    public function edit_comissions($id,$origin){
        $Comission=comissions::find($id);
        $InternalOrders = InternalOrder::find($Comission->order_id);
        $Sellers = Seller::all();
        return view('internal_orders.edit_comission_real', compact(
            'Comission',
            'InternalOrders',
            'Sellers',
            'origin'
        ));
    }
    public function update_comissions($id,Request $request){
        $InternalOrders = InternalOrder::find($request->order_id);
        $Comission=comissions::find($id);
        $Comission->seller_id=$request->seller_id;
        $Comission->percentage=$request->comision*0.01;
        $Comission->description=$request->description;
        $Comission->save();
        
        if($request->origin=='edit_dgi'){
            return redirect()->route('change_dgi',$InternalOrders->id);
         
        }
        else{
            return redirect('internal_orders/edit/'.$InternalOrders->id);
        } }
    public function delete_comissions($id,$origin){
        $Comission=comissions::find($id);
        $InternalOrders = InternalOrder::find($Comission->order_id);
        comissions::destroy($id);
        if($origin=='edit_dgi'){
            return redirect()->route('change_dgi',$InternalOrders->id)->with([ 'borrado' => 'Si' ]);
         
        }
        else{
            return redirect('internal_orders/edit/'.$InternalOrders->id);
        }
        return redirect('internal_orders/edit/'.$InternalOrders->id);
    }
    public function exterminio(){
        // comissions::truncate();
        // signatures::truncate();
        // historical_payments::truncate();
        // payments::truncate();
        // Item::truncate();
        // TempItem::truncate();
        // //TempInternalOrder::truncate();
        
        // InternalOrder::truncate();
        return $this->index();
    }
    
    public function change_dgi($id,$message=""){
        $InternalOrders = InternalOrder::where('id', $id)->first();
        $Message=$message;
        $Sellers = Seller::all();
        $Comisiones=DB::table('comissions')
         ->join('sellers', 'sellers.id', '=', 'comissions.seller_id')
         ->where('order_id',$InternalOrders->id)
         ->select('comissions.*','sellers.seller_name','sellers.iniciales')
         ->get();
        return view('internal_orders.change_dgi', compact(
            'InternalOrders','Sellers','Comisiones','Message'
        ));
        }

    public function confirm_unautorize($id){
        $InternalOrder=InternalOrder::find($id);
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
     
        return view('internal_orders.unautorize',compact('CompanyProfiles',
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
        'Comisiones',));
    }

    public function unautorize(Request $request,$id){
    
        $InternalOrders=InternalOrder::find($id);
        $stored_key = Auth::user()->password;
        $key_code =  $request->password;
        $isPasswordCorrect = Hash::check($key_code, $stored_key);
        if($isPasswordCorrect){
            
            $signatures=signatures::where('order_id',$id)->delete();
            $Authorizations=Authorization::all();
           
            foreach($Authorizations as $auth){
                if($InternalOrders->total>=$auth->clearance_level) {
                    $Signature=new signatures();
                    $Signature->order_id = $InternalOrders->id;
                    $Signature->auth_id = $auth->id;
                    $Signature->save(); 
                }
            }
            $InternalOrders->status='CAPTURADO';
            $InternalOrders->save();
            return redirect()->route('internal_orders.show',$id)->with('unautorized','ok');
        }else{
        return redirect()->route('internal_orders.show',$id)->with('unautorized','fail');
    }
}
public function asignar_marca(Request $request){
    $InternalOrder=InternalOrder::find($request->order_id);
    $InternalOrder->marca=$request->marca;
    $InternalOrder->save();
    return redirect()->route('internal_orders.show',$request->order_id)->with('markasigned','ok');
}

public function cancel($id){
    $InternalOrder = InternalOrder::find($id);
    $InternalOrder->status='CANCELADO';
    $InternalOrder->total=0;
    $InternalOrder->subtotal=0;
    $InternalOrder->save();
    return redirect()->route('internal_orders.index')->with('cancel','ok');
}
}


