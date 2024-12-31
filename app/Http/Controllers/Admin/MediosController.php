<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Medio;
use Illuminate\Http\Request;

class MediosController extends Controller
{
    //
    public function index()
    {
        $Medios = Medio::all();

        return view('admin.medios.index', compact('Medios'));
    }

    public function create()
    {
        return view('admin.medios.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'description' => 'required',
        ];

        $messages = [
            'description.required' => 'Capture el nombre de la Familia',
        ];

        $request->validate($rules, $messages);

        $Families = new Family();
        $Families->family = $request->family;
        $Families->save();

        return redirect()->route('medioss.index')->with('create_reg', 'ok');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $Families = Family::find($id);

        return view('admin.description.show', compact('Families'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'description' => 'required',
        ];

        $messages = [
            'description.required' => 'Capture el nombre de la Familia',
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
