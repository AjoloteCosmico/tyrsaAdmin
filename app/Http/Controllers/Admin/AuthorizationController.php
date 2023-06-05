<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthorizationController extends Controller
{
    public function index()
    {
        $Authorizations = Authorization::where('id', '<>', 1)->get();

        return view('admin.authorizations.index', compact('Authorizations'));
    }

    public function create()
    {
        return view('admin.authorizations.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'job' => 'required',
            'clearance_level' => 'required',
            'key_code' => 'required|same:confirm-password|min:8',
        ];

        $messages = [
            'job.required' => 'Capture el nombre de la Familia',
            'clearance_level.required' => 'Capture el rango máximo de importe',
            'key_code.same' => 'Las contraseñas no coinciden, favor de verificarlas',
            'key_code.min' => 'La contraseña debe contener al menos 8 caracteres',
        ];

        $request->validate($rules, $messages);

        $Authorizations = new Authorization();
        $Authorizations->job = $request->job;
        $Authorizations->clearance_level = $request->clearance_level;
        $Authorizations->key_code = Hash::make($request->key_code);
        $Authorizations->save();

        return redirect()->route('authorizations.index')->with('create_reg', 'ok');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $Authorizations = Authorization::find($id);
//x
        return view('admin.authorizations.show', compact('Authorizations'));
    }

    public function update(Request $request, $id)
    {
        if($request->key_code){
            $rules = [
                'job' => 'required',
                'clearance_level' => 'required',
                'key_code' => 'required|same:confirm-password|min:8',
            ];

            $messages = [
                'job.required' => 'Capture el nombre de la Familia',
                'clearance_level.required' => 'Capture el rango máximo de importe',
                'key_code.required' => 'Capture una contraseña',
                'key_code.same' => 'Las contraseñas no coinciden, favor de verificarlas',
                'key_code.min' => 'La contraseña debe contener al menos 8 caracteres',
            ];

            $request->validate($rules, $messages);

            $Authorizations = Authorization::find($id);
            $Authorizations->job = $request->job;
            $Authorizations->clearance_level = $request->clearance_level;
            $Authorizations->key_code = Hash::make($request->key_code);
            $Authorizations->save();
        }else{
            $rules = [
                'job' => 'required',
                'clearance_level' => 'required',
            ];

            $messages = [
                'job.required' => 'Capture el nombre de la Familia',
                'clearance_level.required' => 'Capture el rango máximo de importe',
            ];

            $request->validate($rules, $messages);

            $Authorizations = Authorization::find($id);
            $Authorizations->job = $request->job;
            $Authorizations->clearance_level = $request->clearance_level;
            $Authorizations->save();
        }        


        return redirect()->route('authorizations.index')->with('update_reg', 'ok');
    }

    public function destroy($id)
    {
        Authorization::destroy($id);

        return redirect()->route('authorizations.index')->with('eliminar', 'ok');
    }
}
