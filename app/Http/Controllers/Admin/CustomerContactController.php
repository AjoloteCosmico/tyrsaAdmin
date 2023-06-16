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
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $customer_id=CustomerContact::find($id)->customer_id;
        CustomerContact::destroy($id);
        //TODO: regresar al cliente que se estaba editando
        return redirect('customers');
    }
}
