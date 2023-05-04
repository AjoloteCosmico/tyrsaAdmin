<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerContact;
use Illuminate\Http\Request;
use Session;
class CustomerController extends Controller
{
    public function index()
    {
        $Customers = Customer::all();

        return view('admin.customers.index', compact(
            'Customers',
        ));
    }
    public function create(){
        return view('admin.customers.create');
    }

    public function validar_rfc()
    {
       
        return view('admin.customers.rfc');
    }
    public function rfc(Request $request)
    {
        $rules = ['customer_rfc' => 'required|max:13'];
        $messages = ['customer_rfc.required' => 'Capture el RFC del Cliente'];
        $request->validate($rules, $messages);
        
        $haycliente=Customer::where('customer_rfc',$request->customer_rfc)->first();
        //dd($haycliente);
        if($haycliente){
            return redirect('admin/customers/'.$haycliente->id.'/edit')->with('message', 'ok');;
        }else{
            $rfc=$request->customer_rfc;
            return redirect('admin/customers/create')->with('rfc', $rfc);
        }
    }

    public function store(Request $request)
    {
        
        $rules = [
            'customer' => 'required',
            'alias' => 'required',
            'legal_name' => 'required',
            'customer_rfc' => 'required|max:13',
            'customer_state' => 'required',
            'customer_city' => 'required',
            'customer_suburb' => 'required',
            'customer_street' => 'required',
            'customer_outdoor' => 'required',
            'customer_zip_code' => 'required|max:5',
            'customer_email' => 'required|email',
            'customer_telephone' => 'required|max:10',
        ];

        $messages = [
            'customer.required' => 'Escriba el Nombre del Cliente',
            'alias.required' => 'Escriba el Nombre Corto del Cliente',
            'legal_name.required' => 'Escriba el Nombre Júridico del Cliente',
            'alias.required' => 'Escriba el Nombre Corto del Cliente',
            'customer_rfc.required' => 'Capture el RFC del Cliente',
            'customer_rfc.max' => 'Sólo puede capturar un máximo de 13 caractéres',
            'customer_state.required' => 'Capture el Estado donde se ubica el Cliente',
            'customer_city.required' => 'Capture la Ciudad donde se ubica el Cliente',
            'customer_suburb.required' => 'Capture la Colonia donde se ubica el Cliente',
            'customer_street.required' => 'Capture la dirección donde se ubica el Cliente',
            'customer_outdoor.required' => 'Capture el Número Exterior donde se ubica el Cliente',
            'customer_email.required' => 'Capture la dirección electrónica del Cliente',
            'customer_email.email' => 'Capture una dirección de Email válida',
            'customer_telephone.required' => 'Capture el Número telefónico del CLiente',
            'customer_telephone.max' => 'Capture el Número telefónico a 10 dígitos',
            'customer_zip_code.required' => 'Capture el Código Postal del Cliente',
            'customer_zip_code.max' => 'Sólo puede capturar un máximo de 5 caractéres'
        ];
        
        $request->validate($rules, $messages);
        
        $Customers = new Customer();
        $Customers->customer = $request->customer;
        if($request->legal_name == 'otra'){
            $Customers->legal_name = $request->otra;
        }
        else{
        $Customers->legal_name = $request->legal_name;
        }
        
        $Customers->alias = $request->alias;
        $Customers->customer_rfc = $request->customer_rfc;
        $Customers->customer_state = $request->customer_state;
        $Customers->customer_city = $request->customer_city;
        $Customers->customer_suburb = $request->customer_suburb;
        $Customers->customer_street = $request->customer_street;
        $Customers->customer_outdoor = $request->customer_outdoor;
        $Customers->customer_indoor = $request->customer_indoor;
        $Customers->customer_zip_code = $request->customer_zip_code;
        $Customers->customer_email = $request->customer_email;
        $Customers->customer_telephone = $request->customer_telephone;
        $Customers->clave=$request->clave;
        $Customers->save();

        return redirect()->route('customers.index')->with('create_reg', 'ok');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $Customers = Customer::find($id);
        $Contacts = CustomerContact::where('customer_id', $id)->get();
        $nc=$Contacts->count();
        return view('admin.customers.show', compact(
            'Customers', 
            'Contacts',
            'nc'
        ));
    }

    public function update(Request $request, $id)
    {        
        $rules = [
            'customer' => 'required',
            'alias' => 'required',
            'customer_rfc' => 'required|max:13',
            'customer_state' => 'required',
            'customer_city' => 'required',
            'customer_suburb' => 'required',
            'customer_street' => 'required',
            'customer_outdoor' => 'required',
            'customer_email' => 'required|email',
            'customer_telephone' => 'required|max:10',
            'customer_zip_code' => 'required|max:5',
        ];

        $messages = [
            'customer.required' => 'Escriba el Nombre del Cliente',
            'alias.required' => 'Escriba el Nombre Corto del Cliente',
            'customer_rfc.required' => 'Capture el RFC del Cliente',
            'customer_rfc.max' => 'Sólo puede capturar un máximo de 13 caractéres',
            'customer_state.required' => 'Capture el Estado donde se ubica el Cliente',
            'customer_city.required' => 'Capture la Ciudad donde se ubica el Cliente',
            'customer_suburb.required' => 'Capture la Colonia donde se ubica el Cliente',
            'customer_street.required' => 'Capture la dirección donde se ubica el Cliente',
            'customer_outdoor.required' => 'Capture el Número Exterior donde se ubica el Cliente',
            'customer_email.required' => 'Capture la dirección electrónica del Cliente',
            'customer_email.email' => 'Capture una dirección de Email válida',
            'customer_telephone.required' => 'Capture el Número telefónico del CLiente',
            'customer_telephone.max' => 'Capture el Número telefónico a 10 dígitos',
            'customer_zip_code.required' => 'Capture el Código Postal del Cliente',
            'customer_zip_code.max' => 'Sólo puede capturar un máximo de 5 caractéres'
        ];

        $request->validate($rules, $messages);

        $Customers = Customer::where('id', $id)->first();
        $Customers->customer = $request->customer;
        if($request->legal_name == 'otra'){
            $Customers->legal_name = $request->otra;
        }
        else{
        $Customers->legal_name = $request->legal_name;}
        $Customers->alias = $request->alias;
        $Customers->customer_rfc = $request->customer_rfc;
        $Customers->customer_state = $request->customer_state;
        $Customers->customer_city = $request->customer_city;
        $Customers->customer_suburb = $request->customer_suburb;
        $Customers->customer_street = $request->customer_street;
        $Customers->customer_outdoor = $request->customer_outdoor;
        $Customers->customer_indoor = $request->customer_indoor;
        $Customers->customer_zip_code = $request->customer_zip_code;
        $Customers->customer_email = $request->customer_email;
        $Customers->customer_telephone = $request->customer_telephone;
        $Customers->save();

        return redirect()->route('customers.index')->with('update_reg', 'ok');
    }

    public function destroy($id)
    {
        Customer::destroy($id);

        return redirect()->route('customers.index')->with('eliminar', 'ok');
    }

    public function contacto( $id)
    {
        //$id=$request->customer_id;
        $Contacts = CustomerContact::where('customer_id', $id);
        $Customer = Customer::where('id', $id)->first();
        

        return view('admin.customer_contacts.create', compact(
            'Contacts',
            'Customer'
            ));

    }
    public function store_contact(Request $request)
    {
        $k=2;
        $rules = [
            'customer_contact_name' => 'required',
            'customer_state' => 'required',
            'customer_city' => 'required',
            'customer_suburb' => 'required',
            'customer_street' => 'required',
            'customer_outdoor' => 'required',
            'customer_zip_code' => 'required|max:5',
            'customer_email' => 'required|email',
            'customer_telephone' => 'required|max:10',
            'customer_mobile' => 'required|max:10',
        ];

        $messages = [
            'customer_contact_name.required' => 'Escriba el Nombre del Cliente',
            'customer_state.required' => 'Capture el Estado donde se ubica el Cliente',
            'customer_city.required' => 'Capture la Ciudad donde se ubica el Cliente',
            'customer_suburb.required' => 'Capture la Colonia donde se ubica el Cliente',
            'customer_street.required' => 'Capture la dirección donde se ubica el Cliente',
            'customer_outdoor.required' => 'Capture el Número Exterior donde se ubica el Cliente',
            'customer_email.required' => 'Capture la dirección electrónica del Cliente',
            'customer_email.email' => 'Capture una dirección de Email válida',
            'customer_telephone.required' => 'Capture el Número telefónico del CLiente',
            'customer_telephone.max' => 'Capture el Número telefónico a 10 dígitos',
            'customer_zip_code.required' => 'Capture el Código Postal del Cliente',
            'customer_zip_code.max' => 'Sólo puede capturar un máximo de 5 caractéres',
            'customer_mobile.required' => 'Capture el Número telefónico del CLiente',
            'customer_mobile.max' => 'Capture el Número telefónico a 10 dígitos',
            
        ];

        $request->validate($rules, $messages);
        $CustomersContact = new CustomerContact();
        $CustomersContact->customer_contact_name = $request->customer_contact_name;
        $CustomersContact->customer_contact_state = $request->customer_state;
        $CustomersContact->customer_contact_city = $request->customer_city;
        $CustomersContact->customer_contact_suburb = $request->customer_suburb;
        $CustomersContact->customer_contact_street = $request->customer_street;
        $CustomersContact->customer_contact_outdoor = $request->customer_outdoor;
        $CustomersContact->customer_contact_indoor = $request->customer_indoor;
        $CustomersContact->customer_contact_zip_code = $request->customer_zip_code;
        $CustomersContact->customer_contact_email = $request->customer_email;
        $CustomersContact->customer_contact_personal_email = $request->customer_personal_email;
        $CustomersContact->customer_contact_office_phone = $request->customer_telephone;
        $CustomersContact->customer_contact_office_phone_ext = $request->customer_telephone_ext;
        $CustomersContact->customer_contact_mobile = $request->customer_mobile;
        $CustomersContact->customer_id = $request->customer_id;
        $CustomersContact->save();
        return redirect()->route('customers.edit',$request->customer_id);
    }

    public function autocomplete(Request $request)
    {
        $data = Customer::select("customer")
                    ->where('customer', 'LIKE', '%'. $request->get('query'). '%')
                    ->get();
        return response()->json($data);
    }


}
