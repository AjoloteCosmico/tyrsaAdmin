<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = bank::all();

        return view('admin.banks.index', compact('banks'));
    }
    
    public function create(){
        return view('admin.banks.create');
    }
    
    public function store(Request $request)
    {
        $rules = [
            'bank_clue' => 'required',
            'bank_description' => 'required',
            'coin' => 'required',
        ];

        $messages = [
        
            'bank_clue.required' => 'Ingrese un Codigo',
            'bank_description.required' => 'Ingrese el nombre largo del banco',
            'coin.required' => 'seleccioine la moneda',];

        $request->validate($rules, $messages);


        $Bank = new bank();
        $Bank->bank_clue = $request->bank_clue;
        $Bank->bank_description = $request->bank_description;
        $Bank->coin = $request->coin;
        $Bank->bank_account = $request->bank_account;
        $Bank->save();

        return redirect()->route('banks.index')->with('create_reg', 'ok');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $Bank = bank::find($id);

        
        return view('admin.banks.show', compact('Bank'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'bank_clue' => 'required',
            'bank_description' => 'required',
            'coin' => 'required',
        ];

        $messages = [
        
            'bank_clue.required' => 'Ingrese un Codigo',
            'bank_description.required' => 'Ingrese el nombre largo del banco',
            'coin.required' => 'seleccioine la moneda',];

        $request->validate($rules, $messages);


        $Bank = bank::find($id);
        $Bank->bank_clue = $request->bank_clue;
        $Bank->bank_description = $request->bank_description;
        $Bank->coin = $request->coin;
        $Bank->bank_account = $request->bank_account;
        $Bank->save();

        return redirect()->route('banks.index')->with('update_reg', 'ok');
    }

    public function destroy($id)
    {
        bank::destroy($id);
        return redirect()->route('banks.index')->with('delete_reg', 'ok');
    
    }
}
