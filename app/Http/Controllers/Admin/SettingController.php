<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $Settings = Setting::all();

        return view('admin.settings.index', compact('Settings'));
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'iva' => 'required|numeric|integer',
            'year_application' => 'required|numeric|digits:4|min:2022|max:2072|unique:settings,year_application',
        ];

        $messages = [
            'iva.required' => 'Capture el Porcentaje de IVA actual',
            'iva.numeric' => 'El campo capturado debe ser numérico',
            'iva.integer' => 'El campo capturado debe ser numérico y entero',
            'year_application.required' => 'Capture el año de aplicación',
            'year_application.numeric' => 'El año de aplicación debe ser numérico',
            'year_application.digits:4' => 'Capture el año de aplicación a 4 dígitos',
            'year_application.min' => 'El año de aplicación no debe ser menor a 2022',
            'year_application.max' => 'El año de aplicación no debe ser mayor a 2072',
            'year_application.unique' => 'El año de aplicación ya ha sido capturado',
        ];

        $request->validate($rules, $messages);

        $Settings = new Setting();
        $Settings->minimum_salary_zlfn = $request->minimum_salary_zlfn;
        $Settings->minimum_salary = $request->minimum_salary;
        $Settings->uma = $request->uma;
        $Settings->iva = $request->iva;
        $Settings->year_application = $request->year_application;
        $Settings->save();

        return redirect()->route('settings.index')->with('create_reg', 'ok');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $Settings = Setting::find($id);

        return view('admin.settings.show', compact('Settings'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'iva' => 'required|numeric|integer',
            'year_application' => 'required|numeric|digits:4|min:2022|max:2072',
        ];

        $messages = [
            'iva.required' => 'Capture el Porcentaje de IVA actual',
            'iva.numeric' => 'El campo capturado debe ser numérico',
            'iva.integer' => 'El campo capturado debe ser numérico y entero',
            'year_application.required' => 'Capture el año de aplicación',
            'year_application.numeric' => 'El año de aplicación debe ser numérico',
            'year_application.digits:4' => 'Capture el año de aplicación a 4 dígitos',
            'year_application.min' => 'El año de aplicación no debe ser menor a 2022',
            'year_application.max' => 'El año de aplicación no debe ser mayor a 2072',
        ];

        $request->validate($rules, $messages);

        $Settings = Setting::find($id);
        $Settings->minimum_salary_zlfn = $request->minimum_salary_zlfn;
        $Settings->minimum_salary = $request->minimum_salary;
        $Settings->uma = $request->uma;
        $Settings->iva = $request->iva;
        $Settings->objetivo_anual = $request->obj;
        $Settings->year_application = $request->year_application;
        $Settings->save();

        return redirect()->route('settings.index')->with('update_reg', 'ok');
    }

    public function destroy($id)
    {
        //
    }
}
