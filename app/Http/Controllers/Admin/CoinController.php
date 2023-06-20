<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    public function index()
    {
        $Coins = Coin::all();

        return view('admin.coins.index', compact('Coins'));
    }

    public function create()
    {
        return view('admin.coins.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'coin' => 'required|unique:coins,coin',
            // 'exchange_buy' => 'required',
            // 'exchange_sell' => 'required',
        ];

        $messages = [
            'coin.required' => 'Capture el nombre de la Moneda',
            'coin.unique' => '¡La moneda ya ha sido capturada!',
            // 'exchange_buy.required' => 'Capture el tipo de cambio actual',
            // 'exchange_sell.numeric' => 'El tipo de cambio debe ser numérico',
            // 'exchange_sell.required' => 'Capture el tipo de cambio actual',
            // 'exchange_buy.numeric' => 'El tipo de cambio debe ser numérico',
        ];

        $request->validate($rules, $messages);

        $date_application = date('Y-m-d');

        $Coins = new Coin();
        $Coins->coin = $request->coin;
        $Coins->symbol = $request->symbol;
        $Coins->code = $request->code;
        $Coins->exchange_buy = $request->exchange_buy;
        $Coins->exchange_sell = $request->exchange_sell;
        $Coins->date_application = $date_application;
        $Coins->save();

        return redirect()->route('coins.index')->with('create_reg', 'ok');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $Coins = Coin::find($id);

        return view('admin.coins.show', compact('Coins'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'coin' => 'required',
            'exchange_buy' => 'required|numeric',
            'exchange_sell' => 'required|numeric',
        ];

        $messages = [
            'coin.required' => 'Capture el nombre de la Moneda',
            'coin.unique' => '¡La moneda ya ha sido capturada!',
            'exchange_buy.required' => 'Capture el tipo de cambio actual',
            'exchange_sell.numeric' => 'El tipo de cambio debe ser numérico',
            'exchange_sell.required' => 'Capture el tipo de cambio actual',
            'exchange_buy.numeric' => 'El tipo de cambio debe ser numérico',
        ];

        $request->validate($rules, $messages);

        $date_application = date('Y-m-d');

        $Coins = Coin::find($id);
        $Coins->coin = $request->coin;
        $Coins->symbol = $request->symbol;
        $Coins->code = $request->code;
        $Coins->exchange_buy = $request->exchange_buy;
        $Coins->exchange_sell = $request->exchange_sell;
        $Coins->date_application = $date_application;
        $Coins->save();

        return redirect()->route('coins.index')->with('update_reg', 'ok');
    }

    public function destroy($id)
    {
        Coin::destroy($id);
        return redirect()->route('coins.index')->with('delete_reg', 'ok');
    
    }
}
