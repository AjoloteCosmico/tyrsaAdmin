<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalOrder;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class VisualizacionController extends Controller
{
   public function pedidos_no_autorizados(){
    // $hoy=now()->modify('-6 hours');
    $sna1dia=InternalOrder::where('date','>',now()->modify('-2 day'))->where('status','CAPTURADO')->get()->count();
    $sna2dia=InternalOrder::where('date','>',now()->modify('-4 day'))->where('status','CAPTURADO')->get()->count() -$sna1dia;
    $sna3dia=InternalOrder::where('date','>',now()->modify('-8 day'))->where('status','CAPTURADO')->get()->count() -$sna1dia -$sna2dia;
    $snamasdias=InternalOrder::where('date','<',now()->modify('-8 day'))->where('status','CAPTURADO')->get()->count() -$sna1dia -$sna2dia -$sna3dia;
    $grafica_autorizados = LarapexChart::barChart()
        ->setTitle('Pedidos sin autorizar')
        ->setSubtitle('por dias desde su emisión')
         ->addData('pedidos', [$sna1dia,$sna2dia,$sna3dia,$snamasdias])
         ->setColors(['#2C426C', '#229C32','#8C0C0C'])
         ->setXAxis(['1 o 2 día', '3-4', '1 semana dias', 'más antiguos']);

         return view('visualizacion.index',compact('grafica_autorizados'));
   }

        
}
