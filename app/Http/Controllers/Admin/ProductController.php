<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\report_product;
use Illuminate\Http\Request;



class ProductController extends Controller
{
    //
    public function index()
    {
        $Products = report_product::all();

        return view('admin.products.index', compact('Products'));
    }

    public function create()
    {
        return view('admin.marcas.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'Capture el nombre de la Marca',
        ];

        $request->validate($rules, $messages);

        $Marca = new Marca();
        $Marca->name = $request->name;
        $Marca->save();

        return redirect()->route('marcas.index')->with('create_reg', 'ok');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $Families = Family::find($id);

        return view('admin.families.show', compact('Families'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'family' => 'required',
        ];

        $messages = [
            'family.required' => 'Capture el nombre de la Familia',
        ];

        $request->validate($rules, $messages);

        $Families = Family::find($id);
        $Families->family = $request->family;
        $Families->save();

        return redirect()->route('families.index')->with('update_reg', 'ok');
    }

    public function destroy($id)
    {
        Family::destroy($id);

        return redirect()->route('families.index')->with('eliminar', 'ok');
    }
 
}
