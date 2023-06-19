<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerContact;

class CustomerContactController extends Controller
{
    public function index()
    {
        //
    }

    public function crear_contacto($id)
    {
        $Contacts = CustomerContact::where('customer_id', $id);
        $parametro=2;
        return view('admin.customer_contacts.create', compact(
        'Contacts',
        'parametro'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $Contacto=CustomerContact::find($id);
       return view('admin.customer_contacts.edit',compact('Contacto'));
    }

    public function update(Request $request, $id)
    {
        
        $rules = [
            'customer_contact_name' => 'required',
            'customer_contact_state' => 'required',
            'customer_contact_city' => 'required',
            'customer_contact_suburb' => 'required',
            'customer_contact_street' => 'required',
            'customer_contact_outdoor' => 'required',
            'customer_contact_zip_code' => 'required|max:5',
            'customer_contact_email' => 'required|email',
            'customer_contact_office_phone' => 'required|max:10',
            'customer_contact_mobile' => 'required|max:10',
        ];

        $messages = [
            'customer_contact_name.required' => 'Escriba el Nombre del Cliente',
            'customer_contact_state.required' => 'Capture el Estado donde se ubica el Cliente',
            'customer_contact_city.required' => 'Capture la Ciudad donde se ubica el Cliente',
            'customer_contact_suburb.required' => 'Capture la Colonia donde se ubica el Cliente',
            'customer_contact_street.required' => 'Capture la dirección donde se ubica el Cliente',
            'customer_contact_outdoor.required' => 'Capture el Número Exterior donde se ubica el Cliente',
            'customer_contact_email.required' => 'Capture la dirección electrónica del Cliente',
            'customer_contact_email.email' => 'Capture una dirección de Email válida',
            'customer_contact_office_phone.required' => 'Capture el Número telefónico del CLiente',
            'customer_contact_office_phone.max' => 'Capture el Número telefónico a 10 dígitos',
            'customer_contact_zip_code.required' => 'Capture el Código Postal del Cliente',
            'customer_contact_zip_code.max' => 'Sólo puede capturar un máximo de 5 caractéres',
            'customer_contact_mobile.required' => 'Capture el Número telefónico del CLiente',
            'customer_contact_mobile.max' => 'Capture el Número telefónico a 10 dígitos',
            
        ];
        $request->validate($rules, $messages);

        $Contact=CustomerContact::where('id',$id)->first();
        // dd($Contact);
        $Contact->customer_contact_name = $request->customer_contact_name;
        $Contact->customer_contact_state = $request->customer_contact_state;
        $Contact->customer_contact_city = $request->customer_contact_city;
        $Contact->customer_contact_suburb = $request->customer_contact_suburb;
        $Contact->customer_contact_street = $request->customer_contact_street;
        $Contact->customer_contact_outdoor = $request->customer_contact_outdoor;
        $Contact->customer_contact_indoor = $request->customer_contact_indoor;
        $Contact->customer_contact_zip_code = $request->customer_contact_zip_code;
        $Contact->customer_contact_email = $request->customer_contact_email;
        $Contact->customer_contact_personal_email = $request->customer_contact_personal_email;
        $Contact->customer_contact_office_phone = $request->customer_contact_office_phone;
        $Contact->customer_contact_office_phone_ext = $request->customer_contact_telephone_ext;
        $Contact->customer_contact_mobile = $request->customer_contact_mobile;
        $Contact->save();
        
        return redirect()->route('customers.edit',$Contact->customer_id);
    

    }

    public function destroy($id)
    {
        $customer_id=CustomerContact::find($id)->customer_id;
        CustomerContact::destroy($id);
        //TODO: regresar al cliente que se estaba editando
        return redirect('customers');
    }
}
