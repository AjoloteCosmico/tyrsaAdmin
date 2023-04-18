<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UlamaController extends Controller
{
   public function index(){
return view('ulama.index');

   }

   public function create(){
      return view('ulama.create');
      
         }
}
