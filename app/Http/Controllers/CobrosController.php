<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\InternalOrder;
use App\Models\payments;
use App\Models\Customer;
use App\Models\CompanyProfile;
use App\Models\CustomerShippingAddress;
use App\Models\Coin;
use App\Models\historical_payments;
use App\Models\Factures;
use App\Models\Seller;
use App\Models\Cobro;

use App\Models\cobro_order;
use App\Models\cobro_facture;


use App\Models\bank;
use App\Http\Requests\StorepaymentsRequest;
use App\Http\Requests\UpdatepaymentsRequest;
use SplFileInfo;
use Illuminate\Support\Facades\Storage;
use DB;
use PDF;
use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException; 
use Illuminate\Support\Facades\Auth;

class CobrosController extends Controller
{
    public function index(){
        $Cobros=DB::table('cobros')
        ->join('internal_orders', 'internal_orders.id', '=', 'cobros.order_id')
        ->join('customers', 'internal_orders.customer_id','=','customers.id')
        ->join('coins', 'internal_orders.coin_id','=','coins.id')
        ->leftjoin('factures', 'cobros.facture_id','=','factures.id')
        ->join('banks', 'cobros.bank_id','=','banks.id')
        
        ->leftjoin('users as capturistas', 'cobros.capturo','=','capturistas.id')
        ->leftjoin('users as revisores', 'cobros.reviso','=','revisores.id')
        ->leftjoin('users as autorizadores', 'cobros.autorizo','=','autorizadores.id')
        
        ->select('cobros.*','customers.customer','customers.clave', 'coins.coin','coins.symbol', 
                 'internal_orders.invoice','factures.facture','banks.bank_clue',
                 'banks.bank_description','capturistas.name as capturista','revisores.name as revisor','autorizadores.name as autorizador')
        // ->orderBy('internal_orders.invoice', 'DESC')
        ->get();
        $FacturasCobradas=DB::table('factures')
        ->join('cobro_factures','cobro_factures.facture_id','=','factures.id')
        ->select('factures.facture','cobro_factures.*')
        ->get();
        //dd($FacturasCobradas);
        return view('cobros.index',compact('Cobros','FacturasCobradas'));
    }
    public function create(){
        //traer todas las facturas
                $Bancos=bank::all();
                $Coins=Coin::all();
                $Factures=DB::table('factures')
                ->join('internal_orders','internal_orders.id','=','factures.order_id')
                ->select('factures.*','internal_orders.customer_id','internal_orders.invoice')
                ->get();
                $Customers=Customer::orderby('clave')->get();
                $InternalOrders=InternalOrder::all();
                return view('cobros.create',compact(
                'Coins',
                'Bancos',
                'Customers',
                'InternalOrders',
                'Factures'
                ));
            }
            public function show($id){
                $file_path = public_path('storage/comp'.$id.'.pdf');
                return response()->file($file_path);
                //return Storage::download('app/comp'.$id.'.pdf');
                
           }


            public function store(Request $request){
               
                

                $rules = [
                        'facture' => 'required',
                        'date' => 'required',
                        'comp'=> 'required',
                        'bank_id'=> 'required',
                        'coin_id'=> 'required',
                        'tc' => 'required',
                        'amount' => 'required',
                        'comp_file' => 'required',
                        // 'seller_id' => 'required',
                        // 'comision' => 'required',
                    ];
                
                    $messages = [
                        'facture.required' => 'Seleccione almenos una factura',
                        'date.required' => 'La fecha  es necesaria',
                        'coin_id.required' => 'El tipo de Moneda es necesario',
                        'bank_id.required' => 'Seleccione una factura valida',
                        'tc.required' => 'Indique el tipo de cambio',
                        'amount.required' => 'Indique una cantidad valida',
                        'comp_file.required' => 'agregue el comprobante',
                        // 'seller_id.required' => 'Elija un vendedor',
                        // 'comision.required' => 'Determine una comision para el vendedor',
                    ];
                
                $request->validate($rules, $messages);
                $Cobro=new Cobro();
                //$Cobro->order_id=$request->order_id;
                $Cobro->amount=$request->amount;
                $Cobro->comp=$request->comp;
                //$Cobro->facture_id=$request->facture_id;
                $Cobro->bank_id=$request->bank_id;
                $Cobro->coin_id=$request->coin_id;
                $Cobro->tc=$request->tc;
                $Cobro->date=$request->date;
                $Cobro->capturo=Auth::user()->id;
                $Cobro->save();

                 //Facturas asociadas al cobro via checkboxes
                if($request->facture){
                    //dd($request->contacto);
                      for($i=0; $i < count($request->facture); $i++){
                          $registro=new cobro_facture();
                          $registro->cobro_id=$Cobro->id;
                          $registro->facture_id=$request->facture[$i];
                          $registro->save();
                      }}
                $Cobro->order_id=Factures::find($request->facture[0])->order_id;
                $Cobro->save();
                $comp=$request->comp_file;
                \Storage::disk('comp')->put('comp'.$Cobro->id.'.pdf',  \File::get($comp));
                
                $Facturas=DB::table('cobro_factures')
                ->join('factures','factures.id','=','cobro_factures.facture_id')
                ->where('cobro_factures.cobro_id','=',$Cobro->id)
                ->select('factures.order_id')
                ->groupBy('factures.order_id')
                ->get();
                if($Facturas->count()>1){
                    return $this->desglosar_cobro($Cobro->id);
                }else{
                    $registro= new cobro_order();
                    $registro->order_id=$Facturas->first()->order_id;
                    $registro->cobro_id=$Cobro->id;
                    $registro->amount=$Cobro->amount;
                    $registro->save();
                    return redirect('cobros');
                }
                }

        public function desglosar_cobro($id){
            $Cobro=Cobro::find($id);
            $Pedidos=DB::table('cobro_factures')
                ->join('factures','factures.id','=','cobro_factures.facture_id')
                ->join('internal_orders','internal_orders.id','=','factures.order_id')
                ->where('cobro_factures.cobro_id','=',$Cobro->id)
                ->select('factures.order_id','internal_orders.total','internal_orders.invoice')
                ->groupBy('factures.order_id','internal_orders.total','internal_orders.invoice')
                ->get();
            return view('cobros.create_desglose',compact('Cobro','Pedidos'));
            
        }

        public function store_desglose($id,Request $request){
            $Cobro=Cobro::find($id);
            $Pedidos=DB::table('cobro_factures')
                ->join('factures','factures.id','=','cobro_factures.facture_id')
                ->join('internal_orders','internal_orders.id','=','factures.order_id')
                ->where('cobro_factures.cobro_id','=',$Cobro->id)
                ->select('factures.order_id','internal_orders.total','internal_orders.invoice')
                ->groupBy('factures.order_id','internal_orders.total','internal_orders.invoice')
                ->get();
        for($i=1;$i<=$Pedidos->count();$i++){
            
            $registro= new cobro_order();
            $registro->cobro_id=$id;
            $registro->order_id=$request->order_id[$i];
            $registro->amount=$request->amount[$i];
            $registro->save();
        }
        return redirect('cobros');

        }
        public function edit($id){
            $Cobro=DB::table('cobros')
            ->join('internal_orders', 'internal_orders.id', '=', 'cobros.order_id')
            ->where('cobros.id','=',$id)
            ->select('cobros.*','internal_orders.customer_id')
            ->first();
            $Ordenes=InternalOrder::where('customer_id',$Cobro->customer_id)->get();
            $Bancos=bank::all();
            $Coins=Coin::all();
            $Factures=Factures::all();
            $Customers=Customer::orderby('clave')->get();
            $InternalOrders=InternalOrder::all();
            
            return view('cobros.edit',
                            compact('Cobro',
                                    'Coins',
                                    'Bancos',
                                    'Customers',
                                    'InternalOrders',
                                    'Factures',
                                'Ordenes'));

        }
        public function update($id,Request $request){
                
            $rules = [
                'order_id' => 'required',
                'date' => 'required',
                'facture_id'=> 'required',
                'bank_id'=> 'required',
                'coin_id'=> 'required',
                'tc' => 'required',
                'amount' => 'required',
                'comp_file' => 'required',
                // 'seller_id' => 'required',
                // 'comision' => 'required',
            ];
        
            $messages = [
                'order_id.required' => 'Seleccione un pedido',
                'date.required' => 'La fecha  es necesaria',
                'coin_id.required' => 'El tipo de Moneda es necesario',
                'bank_id.required' => 'Seleccione una factura valida',
                'tc.required' => 'Indique el tipo de cambio',
                'amount.required' => 'Indique una cantidad valida',
                // 'seller_id.required' => 'Elija un vendedor',
                // 'comision.required' => 'Determine una comision para el vendedor',
            ];
        //$request->validate($rules, $messages);
        $Cobro= Cobro::find($id);
        $Cobro->order_id=$request->order_id;
        $Cobro->amount=$request->amount;
        $Cobro->comp=$request->comp;
        $Cobro->facture_id=$request->facture_id;
        $Cobro->bank_id=$request->bank_id;
        $Cobro->coin_id=$request->coin_id;
        $Cobro->tc=$request->tc;
        $Cobro->date=$request->date;
        $Cobro->reviso=Auth::user()->id;
        $Cobro->save();
        //$comp=$request->comp_file;
        //\Storage::disk('comp')->put('comp'.$Cobro->id.'.pdf',  \File::get($comp));
        


        return redirect('cobros');
        }


    public function destroy($id){
        $Facturas=cobro_facture::where('cobro_id',$id)->get();
            
            foreach ($Facturas as $f) {
                cobro_facture::destroy($f->id);
            }
        $Ordenes=cobro_order::where('cobro_id',$id)->get();
            
            foreach ($Ordenes as $o) {
                cobro_order::destroy($o->id);
            }
                   $file_path = public_path('storage/comp'.$id.'.pdf');
                   File::delete($file_path);
                    Cobro::destroy($id);
                    return $this->index();
            }
    

    public function revisar($id){
       $Cobro= Cobro::find($id);
       $Cobro->reviso=Auth::user()->id;
       $Cobro->save();
       return $this->index();

    }
    public function autorizar($id){
        $Cobro= Cobro::find($id);
        $Cobro->autorizo=Auth::user()->id;
        $Cobro->save();
        return redirect('/cobros');
    }
}
