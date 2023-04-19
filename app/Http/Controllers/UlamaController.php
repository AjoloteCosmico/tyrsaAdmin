<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jugador;
use App\Models\Pelota;
use App\Models\Rotacion;
use DB;
class UlamaController extends Controller
{
   public function index(){
      $Rotaciones=DB::table('rotaciones')
        ->join('jugadores', 'jugadores.id', '=', 'rotaciones.jugador_id')
        ->join('pelotas', 'pelotas.id','=','rotaciones.pelota_id')
        ->select('rotaciones.*','pelotas.name as pelota','jugadores.name as jugador' )
        ->get();
      return view('ulama.index',compact('Rotaciones'));
      }

   public function create(){
      $Jugadores=Jugador::all();
      $Pelotas=Pelota::all();
      return view('ulama.create',compact('Jugadores','Pelotas'));
         }

   public function store(Request $request){
      $Rotacion=new Rotacion();
      $Rotacion->jugador_id=$request->jugador_id;
      $Rotacion->pelota_id=$request->pelota_id;
      $Rotacion->date=$request->date;
      $Rotacion->save();
      return redirect('ulama');
      
         }
}
