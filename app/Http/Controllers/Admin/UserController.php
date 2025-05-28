<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Zones;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    public function index()
    {
        if(!Auth::user()->can('CATALOGOS')){
            return redirect()->route('dashboard');
        }
        $usuarios = User::where('id', '<>', '1')->get();

        return view('admin.users.index', compact(
            'usuarios',
        ));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $zones = Zones::pluck('zone', 'id')->all();
       
        return view('admin.users.create', compact(
            'roles',
            'zones',
        ));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'roles' => 'required',
            'zones' => 'required',
            'password' => 'required|same:confirm-password',
            
        ];

        $messages = [
            'name.required' => 'Escriba el nombre del Usuario que desea Generar',
            'email.required' => 'Escriba un Email',
            'email.unique' => 'El email capturado ya existe en el sistema',
            'email.email' => 'Escriba un Email válido',
            'roles.required' => 'Elija el Rol del Usuario',
            'zones.required' => 'Elija una Zona válida',
            'password.required' => 'La contraseña es obligatoria',
            'password.same' => 'Las Contraseñas no Coinciden',
        ];

        $request->validate($rules, $messages);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        $user->firma=$request->sign;
        $user->save();
        return redirect()->route('users.index')->with('create_reg', 'ok');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $usuario = User::find($id);
        $user_id = $id;

        $roles = Role::pluck('name', 'name')->all();
        $Zonas = Zones::all();
       
        $usuarioRole = $usuario->roles->pluck('name', 'name')->all();

        return view('admin.users.show', compact(
            'usuario',
            'roles',
            'usuarioRole',
            'Zonas'
        ));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
        ];

        $messages = [
            'name.required' => 'Escriba el nombre del Rol que desea Generar',
            'email.required' => 'required',
            'email.unique' => 'El email capturado ya existe en el sistema',
            'email.email' => 'Escriba un email válido',
            'roles.required' => 'Elija el Rol del Usuario',
        ];

        $request->validate($rules, $messages);

        $input = $request->all();
        // dd($input);
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);

        $user->update($input);
        

        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('update_reg', 'ok');
    }

    public function destroy($id)
    {
        User::destroy($id);

        return redirect()->route('users.index')->with('eliminar', 'ok');
    }
}
