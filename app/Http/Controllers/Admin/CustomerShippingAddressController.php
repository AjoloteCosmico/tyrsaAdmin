<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerShippingAddress;
use App\Models\TempInternalOrder;
use App\Models\InternalOrder;
use Illuminate\Http\Request;
use Session;
class CustomerShippingAddressController extends Controller
{
    public function index()
    {
        return 'Inicio';
        $CustomerShippingAddresses = CustomerShippingAddress::all();

        return view('admin.customer_shipping_addresses.index', compact('CustomerShippingAddresses'));
    }

    public function customer($id)
    {
        return 'ID:'.$id;

        return $Customers = Customer::where('id', $id)->first();

        return view('customer_shipping_addresses.create', compact(
            'Customers',
        ));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $rules = [
            'customer_shipping_alias' => 'required',
            'customer_shipping_state' => 'required',
            'customer_shipping_city' => 'required',
            'customer_shipping_suburb' => 'required',
            'customer_shipping_street' => 'required',
            'customer_shipping_outdoor' => 'required',
            'customer_shipping_zip_code' => 'required|max:5',
        ];

        $messages = [
            'customer_shipping_alias.required' => 'Escriba un alias para la Dirección de Embarque',
            'customer_shipping_state.required' => 'Capture el Estado donde se ubica la Dirección de Embarque',
            'customer_shipping_city.required' => 'Capture la Ciudad donde se ubica la Dirección de Embarque',
            'customer_shipping_suburb.required' => 'Capture la Colonia donde se ubica la Dirección de Embarque',
            'customer_shipping_street.required' => 'Capture la dirección donde se ubica la Dirección de Embarque',
            'customer_shipping_outdoor.required' => 'Capture el Número Exterior donde se ubica la Dirección de Embarque',
            'customer_shipping_zip_code.required' => 'Capture el Código Postal de la Dirección de Embarque',
            'customer_shipping_zip_code.max' => 'Sólo puede capturar un máximo de 5 caractéres'
        ];

        $request->validate($rules, $messages);

        $Customers_Shipping_Addresses = CustomerShippingAddress::where('customer_id', $request->customer_id)
            ->where('customer_shipping_alias', $request->customer_shipping_alias)
            ->get();
            
        if(count($Customers_Shipping_Addresses) <= 0){
            $Customers_Shipping_Addresses = new CustomerShippingAddress();
            $Customers_Shipping_Addresses->customer_id = $request->customer_id;
            $Customers_Shipping_Addresses->customer_shipping_alias = $request->customer_shipping_alias;
            $Customers_Shipping_Addresses->customer_shipping_state = $request->customer_shipping_state;
            $Customers_Shipping_Addresses->customer_shipping_city = $request->customer_shipping_city;
            $Customers_Shipping_Addresses->customer_shipping_suburb = $request->customer_shipping_suburb;
            $Customers_Shipping_Addresses->customer_shipping_street = $request->customer_shipping_street;
            $Customers_Shipping_Addresses->customer_shipping_outdoor = $request->customer_shipping_outdoor;
            $Customers_Shipping_Addresses->customer_shipping_indoor = $request->customer_shipping_indoor;
            $Customers_Shipping_Addresses->customer_shipping_zip_code = $request->customer_shipping_zip_code;
            $Customers_Shipping_Addresses->save();
        }else{
            $MNSJ="YASTABA REGISTRADO";
        }

        $TempInternalOrders = TempInternalOrder::where('id', $request->temp_internal_order_id)->first();
        $Customers = Customer::where('id', $request->customer_id)->first();
        $CustomerShippingAddresses = CustomerShippingAddress::where('customer_id', $request->customer_id)->get();
        
        return view('internal_orders.capture_order_shippment_addresses', compact(
            'TempInternalOrders',
            'Customers',
            'CustomerShippingAddresses',
        ));
    }

    public function show($id)
    {
        $TempInternalOrders = TempInternalOrder::where('id', $id)->first();

        $Customers = Customer::where('id', $TempInternalOrders->customer_id)->first();

        return view('admin.customer_shipping_addresses.create', compact(
            'Customers',
            'TempInternalOrders',
        ));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroyb($id,$temp_id)
    {

        $Ordenes=InternalOrder::where('customer_shipping_address_id',$id)->get();
        if($Ordenes->count()<=0){
            CustomerShippingAddress::destroy($id);
            Session::put('eliminar', 'ok');
        }
        else{
            Session::put('error_delete','ok');
        }
       
        $TempInternalOrders = TempInternalOrder::where('id', $temp_id)->first();
        $Customers = Customer::where('id', $TempInternalOrders->customer_id)->first();
        $CustomerShippingAddresses = CustomerShippingAddress::where('customer_id', $TempInternalOrders->customer_id)->get();
        
        return view('internal_orders.capture_order_shippment_addresses', compact(
            'TempInternalOrders',
            'Customers',
            'CustomerShippingAddresses', 
        ));
    
    }
}
