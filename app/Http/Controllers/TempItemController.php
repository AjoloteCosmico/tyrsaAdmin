<?php

namespace App\Http\Controllers;
use Session;
use App\Models\TempItem;
use App\Models\Customer;
use App\Models\Family;
use App\Models\TempInternalOrder;
use App\Models\Unit;
use Illuminate\Http\Request;

class TempItemController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
      //
    }

    public function create_item($id,Request $request)
    {
        $cat=$request->session_cat;
        //$p_comission=$request->p_comission;
            if($cat!="."){
               
            session(['cat' => $cat]);
            }
        $desc=$request->session_desc;
            //$p_comission=$request->p_comission;
                if($desc!="."){
                   
                session(['desc' => $desc]);
                }
        $obs=$request->session_obs;
                //$p_comission=$request->p_comission;
                    if($obs!="."){
                       
                    session(['obs' => $obs]);
                    }


        $TempInternalOrders = $id;
        $TempItems = TempItem::where('temp_internal_order_id', $id)->OrderBy('id', 'DESC')->first();

        if($TempItems){
            $Item = $TempItems->item + 1;
        }else{
            $Item = 1;
        }

        $Units = Unit::all();
        $Families = Family::all();

        return view('admin.items.create', compact(
            'TempInternalOrders',
            'Item',
            'Units',
            'Families',
        ));
    }

    public function edit_item($id,$captured)
    {
        $Id=$id;
        $Captured=$captured;
        $Item = TempItem::find($id);
        $Units = Unit::all();
        $Families = Family::all();
        $TempInternalOrders = $Item->temp_internal_order_id;
        return view('admin.items.edit', compact(
            'TempInternalOrders',
            'Item',
            'Units',
            'Families',
            'Id',
            'Captured'
        ));
    }

    public function store(Request $request)
    {
        
        $rules = [
            'amount' => 'required',
            'unit' => 'required',
            'family' => 'required',
            
            
            'sku' => 'required',
            'description' => 'required',
            'unit_price' => 'required',
        ];

        $messages = [
            'amount.required' => 'La Cantidad es requerida',
            'unit.required' => 'La unidad es requerida',
            'family.required' => 'La familia es requerida',
            
            
            'sku.required' => 'SKU requerido',
            'description.required' => 'La descripción es requerida',
            'unit_price.required' => 'El precio unitario es requerido',
        ];

        $request->validate($rules, $messages);

        $Import = $request->amount * $request->unit_price;

        $TempItems = TempItem::where('item', $request->item)->first();
        if($TempItems){
            $TempItems->delete();
        }
        
            $TempItems = new TempItem();
            $TempItems->temp_internal_order_id = $request->temp_internal_order_id;
            $TempItems->item = $request->item;
            $TempItems->amount = $request->amount;
            $TempItems->unit = $request->unit;
            if($request->family=='OTRO'){
                $TempItems->family = $request->otro;
            }
            else{
            $TempItems->family = $request->family;}
            //$TempItems->subfamilia = $request->subfamily;
            $TempItems->categoria = $request->category;
            //$TempItems->products = $request->products;
            //$TempItems->code = $request->code;
           
            $TempItems->sku = $request->sku;
            
            $TempItems->description = $request->description;
            $TempItems->unit_price =(float) $request->unit_price;
            $TempItems->import = $Import;
            $TempItems->save();
        
        
        $TempInternalOrders = TempInternalOrder::where('id', $request->temp_internal_order_id)->first();
        $Customers = Customer::where('id', $TempInternalOrders->customer_id)->first();
        $TempItems = TempItem::where('temp_internal_order_id', $TempInternalOrders->id)->get();

        if(count($TempItems) > 0){
            $Subtotal = TempItem::where('temp_internal_order_id', $TempInternalOrders->id)->sum('import');
        }else{
            $Subtotal = '0';
        }

        $Iva = $Subtotal * 0.16;
        $Total = $Subtotal + $Iva;
        $cat=Session::get('cat');
        $desc=Session::get('desc');
        
        $obs=Session::get('obs');
        return view('internal_orders.capture_order_items', compact(
            'TempInternalOrders',
            'Customers',
            'TempItems',
            'Subtotal',
            'Iva',
            'Total',
            'cat','desc','obs'
        ));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function redefine(Request $request, $id,$captured)
    {        
        
        $cat=Session::get('cat');
        $desc=Session::get('desc');
        
        $obs=Session::get('obs');
        
        $rules = [
        'amount' => 'required',
        'unit' => 'required',
        'family' => 'required',
        
        
        'sku' => 'required',
        'description' => 'required',
        'unit_price' => 'required',
    ];

    $messages = [
        'amount.required' => 'La Cantidad es requerida',
        'unit.required' => 'La unidad es requerida',
        'family.required' => 'La familia es requerida',
        
        
        'sku.required' => 'SKU requerido',
        'description.required' => 'La descripción es requerida',
        'unit_price.required' => 'El precio unitario es requerido',
    ];

    $request->validate($rules, $messages);

    $Import = $request->amount * $request->unit_price;

    $TempItems = $Item = TempItem::find($id);

    $TempItems->temp_internal_order_id = $request->temp_internal_order_id;
    $TempItems->item = $request->item;
    $TempItems->amount = $request->amount;
    $TempItems->unit = $request->unit;
    if($request->family=='OTRO'){
        $TempItems->family = $request->otro;
    }
    else{
    $TempItems->family = $request->family;}
    //$TempItems->subfamilia = $request->subfamily;
    $TempItems->categoria = $request->category;
    //$TempItems->products = $request->products;
    //$TempItems->code = $request->code;
    
    $TempItems->sku = $request->sku;
    
    $TempItems->description = $request->description;
    $TempItems->unit_price =(float) $request->unit_price;
    $TempItems->import = $Import;
    $TempItems->save();
    
    
    $TempInternalOrders = TempInternalOrder::where('id', $request->temp_internal_order_id)->first();
    $Customers = Customer::where('id', $TempInternalOrders->customer_id)->first();
    $TempItems = TempItem::where('temp_internal_order_id', $TempInternalOrders->id)->get();

    if(count($TempItems) > 0){
        $Subtotal = TempItem::where('temp_internal_order_id', $TempInternalOrders->id)->sum('import');
    }else{
        $Subtotal = '0';
    }

    $Iva = $Subtotal * 0.16;
    $Total = $Subtotal + $Iva;
    
    if($captured==0){
    return view('internal_orders.capture_order_items', compact(
        'TempInternalOrders',
        'Customers',
        'TempItems',
        'Subtotal',
        'Iva',
        'Total',
        'cat','desc','obs'

    ));}
    else{
        
        return (new InternalOrderController)->edit_order($TempInternalOrders->id);
    }
        
    }

    public function destroy($id)
    {
        //
    }
}
