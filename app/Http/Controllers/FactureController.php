<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function index(){
//traer todas las facturas
        $Factures=0;
        return view('factures.index',compact(
        'Factures'
        ));
    }
}
