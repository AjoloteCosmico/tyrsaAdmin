<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CreditNote;

use Illuminate\Support\Facades\File;
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
use App\Models\note_facture;


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

class NotasCreditoController extends Controller
{
    public function index(){
    $Notas=DB::table('credit_notes')
    ->join('customers', 'credit_notes.customer_id','=','customers.id')
    //->join('factures', 'credit_notes.facture_id','=','factures.id')
    
    ->select('credit_notes.*','customers.customer','customers.clave',  
             )
    // ->orderBy('internal_orders.invoice', 'DESC')
    ->get();
    return view('credit_notes.index',compact('Notas'));

    }
    public function create(){
        //traer todas las facturas
                $Bancos=bank::all();
                $Coins=Coin::all();
                $Factures=Factures::all();
                $Customers=Customer::orderby('clave')->get();
                $InternalOrders=InternalOrder::all();
                return view('credit_notes.create',compact(
                'Coins',
                'Bancos',
                'Customers',
                'InternalOrders',
                'Factures'
                ));
            }
        
            public function store(Request $request){
 
                $rules = [
                        'customer_id' => 'required',
                        'credit_note' => 'required',
                        'date' => 'required',
                        'amount' => 'required',
                        'comp_file' => 'required',
                    ];
                
                    $messages = [
                        'customer_id.required' => 'Seleccione un cliente',
                        'date.required' => 'La fecha  es necesaria',
                        'credit_note.required' => 'Ingrese una clave para la nota de credito',
                        'amount.required' => 'Indique una cantidad valida',
                        'comp_file.required' => 'Adjunte un comprobante en pdf por favor',
                
                        // 'seller_id.required' => 'Elija un vendedor',
                        // 'comision.required' => 'Determine una comision para el vendedor',
                    ];
                
                $request->validate($rules, $messages);
                $Nota=new CreditNote();
                $Nota->customer_id=$request->customer_id;
                $Nota->order_id=$request->order_id;
                $Nota->amount=$request->amount;
                //$Nota->facture_id=$request->facture_id;
                $Nota->date=$request->date;
                $Nota->credit_note=$request->credit_note;
                $Nota->status='CAPTURADA';
                $Nota->save();
                if($request->facture){
                    //dd($request->contacto);
                      for($i=0; $i < count($request->facture); $i++){
                          $registro=new note_facture();
                          $registro->note_id=$Nota->id;
                          $registro->facture_id=$request->facture[$i];
                          $registro->save();
                      }}
                $comp=$request->comp_file;
                \Storage::disk('comp')->put('note'.$Nota->id.'.pdf',  \File::get($comp));
       
                return redirect('credit_notes');
                }
        public function destroy($id){

            
            $Facturas=note_facture::where('note_id',$id)->get();
            
            foreach ($Facturas as $f) {
                note_facture::destroy($f->id);
            }
            $file_path = public_path('storage/note'.$id.'.pdf');
            File::delete($file_path);
            CreditNote::destroy($id);
            return redirect('credit_notes');
        }
        public function show($id){
            $file_path = public_path('storage/note'.$id.'.pdf');
            return response()->file($file_path);
            //return Storage::download('app/comp'.$id.'.pdf');
                            
                       }

        public function edit($id){
            $Nota=CreditNote::find($id);
            $Linked_factures=note_facture::where('note_id',$id)->get();            
            $Bancos=bank::all();
            $Coins=Coin::all();
            $Factures=Factures::all();
            $Customers=Customer::orderby('clave')->get();
            $InternalOrders=InternalOrder::all();
            $file_path = public_path('storage/note'.$id.'.pdf');
            return view('credit_notes.edit',compact(
                'Coins',
                'Bancos',
                'Customers',
                'InternalOrders',
                'Factures',
                'Nota',
                'Linked_factures',
                'file_path'
                ));

        }
        public function update($id,Request $request){
            
            
            $rules = [
                'customer_id' => 'required',
                'credit_note' => 'required',
                'date' => 'required',
                'amount' => 'required',s
            ];
        
            $messages = [
                'customer_id.required' => 'Seleccione un cliente',
                'date.required' => 'La fecha  es necesaria',
                'credit_note.required' => 'Ingrese una clave para la nota de credito',
                'amount.required' => 'Indique una cantidad valida',
        
                // 'seller_id.required' => 'Elija un vendedor',
                // 'comision.required' => 'Determine una comision para el vendedor',
            ];
        
        $request->validate($rules, $messages);
        $Nota=CreditNote::find($id);    
        $Facturas=note_facture::where('note_id',$id)->get();
            
        foreach ($Facturas as $f) {
                note_facture::destroy($f->id);
            }
        $Nota->customer_id=$request->customer_id;
        $Nota->order_id=$request->order_id;
        $Nota->amount=$request->amount;
        //$Nota->facture_id=$request->facture_id;
        $Nota->date=$request->date;
        $Nota->credit_note=$request->credit_note;
        $Nota->status='CAPTURADA';
        $Nota->save();
        if($request->facture){
            //dd($request->contacto);
              for($i=0; $i < count($request->facture); $i++){
                  $registro=new note_facture();
                  $registro->note_id=$Nota->id;
                  $registro->facture_id=$request->facture[$i];
                  $registro->save();
              }}
        $comp=$request->comp_file;
        \Storage::disk('comp')->put('note'.$Nota->id.'.pdf',  \File::get($comp));

            return $this->index();
        }

}
