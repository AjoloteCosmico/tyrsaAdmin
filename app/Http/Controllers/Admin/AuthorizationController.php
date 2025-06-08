<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Authorization;

use Spatie\Permission\Models\Role;
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
        $Roles=Role::all();
        return view('admin.authorizations.create',compact('Roles'));
    }

    public function store(Request $request)
    {
        $rules = [
            'titulo' => 'required',
            'role_id' => 'required',
            'clearance_level' => 'required',
            // 'key_code' => 'required|same:confirm-password|min:8',
        ];

        $messages = [
            'titulo.required' => 'Capture el nombre de la autorizacion',
            
            'role_id.required' => 'Capture el rol de la autorizacion',
            'clearance_level.required' => 'Capture el rango máximo de importe',
            // 'key_code.same' => 'Las contraseñas no coinciden, favor de verificarlas',
            // 'key_code.min' => 'La contraseña debe contener al menos 8 caracteres',
        ];

        $request->validate($rules, $messages);
        $Job=Role::Find($request->role_id)->name;
        $Authorizations = new Authorization();
        $Authorizations->job = $Job;
        $Authorizations->titulo = $request->titulo;
        $Authorizations->role_id = $request->role_id;
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
        
        $Roles=Role::all();
        return view('admin.authorizations.show', compact('Authorizations','Roles'));
    }

    public function update(Request $request, $id)
    {
        if($request->key_code){
            
            $rules = [
            'titulo' => 'required',
            'role_id' => 'required',
            'clearance_level' => 'required',
            // 'key_code' => 'required|same:confirm-password|min:8',
        ];

        $messages = [
            'titulo.required' => 'Capture el nombre de la autorizacion',
            
            'role_id.required' => 'Capture el rol de la autorizacion',
            'clearance_level.required' => 'Capture el rango máximo de importe',
            // 'key_code.same' => 'Las contraseñas no coinciden, favor de verificarlas',
            // 'key_code.min' => 'La contraseña debe contener al menos 8 caracteres',
        ];

            $Job=Role::Find($request->role_id)->name;
            $request->validate($rules, $messages);

            $Authorizations = Authorization::find($id);
            $Authorizations->job = $Job;
            $Authorizations->clearance_level = $request->clearance_level;
            $Authorizations->titulo = $request->titulo;
            $Authorizations->role_id = $request->role_id;
            // $Authorizations->key_code = Hash::make($request->key_code);
            $Authorizations->save();
        }else{
            $rules = [
                'titulo' => 'required',
                'role_id' => 'required',
                'clearance_level' => 'required',
                // 'key_code' => 'required|same:confirm-password|min:8',
            ];
    
            $messages = [
                'titulo.required' => 'Capture el nombre de la autorizacion',
                
                'role_id.required' => 'Capture el rol de la autorizacion',
                'clearance_level.required' => 'Capture el rango máximo de importe',
                // 'key_code.same' => 'Las contraseñas no coinciden, favor de verificarlas',
                // 'key_code.min' => 'La contraseña debe contener al menos 8 caracteres',
            ];
    
                $Job=Role::Find($request->role_id)->name;
                $request->validate($rules, $messages);
    
                $Authorizations = Authorization::find($id);
                $Authorizations->job = $Job;
                $Authorizations->clearance_level = $request->clearance_level;
                $Authorizations->titulo = $request->titulo;
                $Authorizations->role_id = $request->role_id;
                // $Authorizations->key_code = Hash::make($request->key_code);
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
