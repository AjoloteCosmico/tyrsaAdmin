<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cantidades;


class PruebaController extends Controller
{
    public function index(){
        $Cantidades=Cantidades::all();
        return view('prueba.create',
    compact('Cantidades'));

    }
    public function store(Request $request){
    $Cant=new Cantidades();
    $Cant->cant=$request->cant;
    $Cant->save();
    return redirect('prueba');
    }
    public function destroy($id){
        Cantidades::destroy($id);
        
        return redirect('prueba');
        }
}
