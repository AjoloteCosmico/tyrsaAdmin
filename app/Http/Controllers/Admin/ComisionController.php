<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cantidades;
use Illuminate\Http\Request;

class ComisionController extends Controller
{
    public function index()
    {
        $Comision= Cantidades::where('id', 1)->first();
        // Logic to display a list of commissions
        return view('admin.comisiones.index', compact('Comision'));
    }

    public function edit($id)
    {
        
        $Comision= Cantidades::where('id', 1)->first();
        // Logic to edit a specific commission
        return view('admin.comisiones.edit', compact('Comision'));
    }

    public function update(Request $request, $id)
    {
         $Comision= Cantidades::where('id', 1)->first();
         $Comision->cant=$request->percentage;
         $Comision->save();
        return redirect()->route('comisiones.index')->with('update_reg', 'ok');
    }
}
