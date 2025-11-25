<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalOrder;
use App\Models\Coin;
use App\Models\CompanyProfile;
use App\Models\Factures;
use App\Models\cobro_facture;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class FactureController extends Controller
{
    public function index(){
        
        //traer todas las facturas
        $Factures=DB::table('factures')
        ->join('internal_orders', 'internal_orders.id', '=', 'factures.order_id')
        ->join('customers', 'internal_orders.customer_id','=','customers.id')
        ->join('coins', 'internal_orders.coin_id','=','coins.id')
        ->select('factures.*','customers.customer','customers.clave', 'coins.symbol', 'internal_orders.invoice','internal_orders.reg_date','internal_orders.payment_conditions')
        // ->orderBy('internal_orders.invoice', 'DESC')
        ->get();
        return view('factures.index',compact(
        'Factures'
        ));
    }   
    public function create(){
        //traer todas las facturas
                $LastComp = Factures::orderByRaw('CAST(REGEXP_REPLACE(facture, "[^0-9]", "") AS UNSIGNED) DESC')->first();
               $ncomp = '100';
               
               if($LastComp){
                    $lastNumber = intval(preg_replace('/[^0-9]/', '', $LastComp->facture));
                    $ncomp =  strval($lastNumber + 1);
                }
                $Factures=Factures::all();
                $Customers=Customer::orderby('clave')->get();
                $InternalOrders=InternalOrder::all();
                $Coins=Coin::all();
                return view('factures.create',compact(
                'Factures',
                'Customers',
                'InternalOrders',
                'Coins','ncomp'
                ));
            }
            
    public function store(Request $request){
        
                    $rules = [
                        
                        'date' => 'required',
                        'facture'=> 'unique:factures,facture',
                        'coin_id'=> 'required',
                        'tc' => 'required',
                        'amount' => 'required',
                    ];

                $messages = [
                        'date.required' => 'La fecha  es necesaria',
                        'facture.unique' => 'Ya existe un registro con este numero de factura',
                        'coin_id.required' => 'Seleccione una moneda',
                        'tc.required' => 'Indique el tipo de cambio',
                        'amount.required' => 'Indique una cantidad valida',
                        
                    ];
                $request->validate($rules, $messages);
                $Facture= new Factures();
                $Facture->order_id=$request->order_id;
                $Facture->amount=$request->amount;
                $Facture->ordinal=$request->ordinal;
                $Facture->status='CAPTURA';
                $Facture->npagos=$request->tpagos;
                $Facture->facture=$request->facture;
                $Facture->coin_id=$request->coin_id;
                $Facture->tc=$request->tc;
                $Facture->date=$request->date;
                $Facture->save();
                // dd($request->comp_file,$request->file('comp_file'),$request->hasFile('comp_file'),$request); // O dd($request->allFiles());

                if ($request->hasFile('comp_file')) {
                    $comp = $request->file('comp_file'); // Obtiene el archivo subido
                    $contenidoPDF = file_get_contents($comp->getRealPath()); // Ruta temporal correcta
                    \Storage::disk('comp')->put('fac'.$Facture->id.'.pdf', $contenidoPDF);
                } else {
                    throw new \Exception("Archivo no subido");
                }

                //revisar si el pedido tiene cobros para ligar sin facturas
                 $Cobros=DB::table('cobros')
                        ->leftJoin('cobro_factures','cobros.id','cobro_factures.cobro_id','left_otter')
                        ->select('cobros.id','cobro_factures.facture_id')
                        ->where('cobros.order_id',$request->order_id)
                        ->whereNull('cobro_factures.facture_id')
                        ->get();
                // dd($Cobros,$request->order_id);     
                if($Cobros->count()>0) {
                    return redirect()->route('factures.assign',$Facture->id);
                }else{
                    return redirect()->route('factures.index');
                
                }         
                }
    public function assign($id){
        $Id=$id;
        $Facture=Factures::find($id);
        $Cobros=DB::table('cobros')
                        ->leftJoin('cobro_factures','cobros.id','cobro_factures.cobro_id','left_otter')
                        ->select('cobros.*')
                        ->where('cobros.order_id',$Facture->order_id)
                        ->whereNull('cobro_factures.facture_id')
                        ->get();
        
    return view('factures.assign',compact('Cobros','Id')) ;       
    }

    public function make_assign(Request $request){
        $registro=new cobro_facture();
        $registro->cobro_id=$request->cobro_id;
        $registro->facture_id=$request->facture_id;
        $registro->save();
        
        return redirect()->route('factures.index');
    }

    public function show($id){
        
        $filename = 'fac'.$id.'.pdf';
        //Crear un pdf en blanco si no existe
        
        if (!\Storage::disk('comp')->exists($filename)) {
            // Crear PDF en blanco si no existe
            $pdfBlank = app('dompdf.wrapper');
            $pdfBlank->loadHTML('<h3>comprobante factura</h3>');
            \Storage::disk('comp')->put($filename, $pdfBlank->output());
        }
        
    $file_path = public_path('storage/fac'.$id.'.pdf');
    // dd($file_path);
    return response()->file($file_path);
    //return Storage::download('app/comp'.$id.'.pdf');
                    
               }
    public function edit($facture){
        //traer todas las facturas
        $Facture=DB::table('factures')
        ->join('internal_orders', 'internal_orders.id', '=', 'factures.order_id')
        ->join('customers', 'internal_orders.customer_id','=','customers.id')
        ->join('coins', 'internal_orders.coin_id','=','coins.id')
        ->select('factures.*','customers.id as customer_id','customers.clave', 'coins.symbol', 'internal_orders.invoice','internal_orders.reg_date','internal_orders.payment_conditions')
        ->where('factures.id','=',$facture)
        ->first();
        $Factures=Factures::all();
        $Customers=Customer::orderby('clave')->get();
        $InternalOrders=InternalOrder::all();
        
                return view('factures.edit',compact(
                'Facture',
                'Factures',
                'Customers',
                'InternalOrders',
                ));
                }
    public function update($id,Request $request){
        //traer todas las facturas
                $Facture=Factures::find($id);
                $Facture->amount=$request->amount;
                $Facture->order_id=$request->order_id;
                $Facture->ordinal=$request->ordinal;
                $Facture->status='CAPTURA';
                $Facture->npagos=$request->tpagos;
                $Facture->facture=$request->facture;
                $Facture->save();

                if ($request->hasFile('comp_file')) {
                    $comp = $request->file('comp_file'); // Obtiene el archivo subido
                    $contenidoPDF = file_get_contents($comp->getRealPath()); // Ruta temporal correcta
                    \Storage::disk('comp')->put('fac'.$Facture->id.'.pdf', $contenidoPDF);
                }
                // $Facture->customer_id=$request->customer_id;
                
                // $Facture->customer_id=$request->customer_id;

                return redirect()->route('factures.index');
                }

    public function destroy($id){
           $Facture=Factures::find($id);
           // Nombre del archivo tal como lo guardaste
            $filename = 'fac' . $Facture->id . '.pdf';

            // Verifica si existe en el disco y elimínalo
            if (\Storage::disk('comp')->exists($filename)) {
                \Storage::disk('comp')->delete($filename);
            }
            Factures::destroy($id);
            cobro_facture::where('facture_id',$id)->delete();
            return $this->index();
    }
    
    
    
        

        
}
