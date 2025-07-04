<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InternalOrderController;
use App\Http\Controllers\TempItemController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\DgiReportsController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\CobrosController;
use App\Http\Controllers\UlamaController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\NotasCreditoController;

use App\Http\Controllers\VisualizacionController;
use App\Models\TempItem;
use App\Http\Controllers\Admin\CustomerContactController;
use App\Http\Controllers\Admin\CustomerController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect(route('login'));
});

// Route::group(['middleware' => ['auth']], function()
// {
//     Route::resource('dashboard', DashboardController::class);
// });

Route::middleware(['auth:sanctum', 'verified'])->get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['middleware' => ['auth']], function()
{
    Route::resource('internal_orders', InternalOrderController::class);
    Route::resource('temp_items', TempItemController::class);
    Route::resource('items', ItemController::class);
    Route::resource('cuentas_cobrar', PaymentsController::class);
    Route::resource('factures', FactureController::class);
    Route::post('factures/update_2/{id}', [FactureController::class, 'update'])->name('factures.update2');
    Route::get('factures/assign/{id}', [FactureController::class, 'assign'])->name('factures.assign');
    Route::post('factures/make_assign', [FactureController::class, 'make_assign'])->name('factures.make_assign');
    
    Route::resource('cobros', CobrosController::class);
    Route::post('cobros/update_2/{id}', [CobrosController::class, 'update'])->name('cobros.update2');
    Route::get('cobros/create_desglose/{id}', [CobrosController::class, 'desglosar_cobro'])->name('cobros.create_desglose');
    Route::post('cobros/store_desglose/{id}', [CobrosController::class, 'store_desglose'])->name('cobros.store_desglose');
    
    Route::resource('credit_notes', NotasCreditoController::class); 
    Route::post('credit_notes/update_/{id}', [NotasCreditoController::class, 'update'])->name('credit_notes.update2');
   
    Route::get('cobros/revisar/{id}', [CobrosController::class, 'revisar'])->name('cobros.revisar');
    Route::get('cobros/autorizar/{id}', [CobrosController::class, 'autorizar'])->name('cobros.autorizar');
    Route::get('aberelpdf/{name}', [ReportsController::class, 'prueba'])->name('pdf.prueba');
    Route::get('visualization', [VisualizacionController::class, 'pedidos_no_autorizados'])->name('visualizacion');

    Route::get('accounting/payed_accounts', [PaymentsController::class, 'payed_accounts'])->name('payed_accounts');
   //rutas para generar reportes
      //catalogos
    Route::get('reportes/contraportada', [ReportsController::class, 'contraportada'])->name('reportes.contraportada');
    Route::get('reportes/factura_resumida', [PaymentsController::class, 'factura_resumida'])->name('reportes.factura_resumida');
    Route::get('reportes/consecutivo_factura', [PaymentsController::class, 'consecutivo_factura'])->name('reportes.consecutivo_factura');
    Route::get('reportes/comprobante_ingresos', [PaymentsController::class, 'comprobante_ingresos'])->name('reportes.comprobante_ingresos');
    Route::get('reportes/consecutivo_comprobante', [PaymentsController::class, 'consecutivo_comprobante'])->name('reportes.consecutivo_comprobante');
    Route::get('consecutivo_pedido', [PaymentsController::class, 'consecutivo_pedido'])->name('payments.consecutivo_pedido');
   //Reportes nuevos 
    Route::get('reportes/objetivo/{monto}', [ReportsController::class, 'objetivos'])->name('reportes.objetivos');
    Route::get('reportes/fabricacion/{monto}', [ReportsController::class, 'fabricacion'])->name('reportes.fabricacion');
    Route::get('reportes/rango_ventas', [ReportsController::class, 'RangoVentas'])->name('reportes.rango_ventas');
    Route::get('reportes/rango_ventas_pi', [ReportsController::class, 'RangoVentasPi'])->name('reportes.rango_ventas_pi');
    Route::get('reportes/ventas_fabricacion', [ReportsController::class, 'ventasFabricacion'])->name('reportes.ventas_fabricacion');
    Route::get('reportes/kilos', [ReportsController::class, 'kilos'])->name('reportes.kilos');
    Route::get('reportes/medios', [ReportsController::class, 'medios'])->name('reportes.medios');
    Route::get('reportes/productos/{monto}', [ReportsController::class, 'productos'])->name('reportes.productos');
   

    //REPORTES DGI 
    Route::get('reportes/dgi_select_type', [DgiReportsController::class, 'dgi_select'])->name('reportes.dgi_select');
    Route::post('reportes/dgi/', [DgiReportsController::class, 'dgi'])->name('reportes.dgi');
   
    //  generar reporte
    Route::get('reporte/{id}/{report}/{pdf}/{tipo?}', [ReportsController::class, 'generate'])->name('reports.generate');
    
    Route::get('cobro_pdf/{id}', [ReportsController::class, 'cobro_pdf'])->name('cobro_pdf');
    Route::get('factura_pdf/{id}', [ReportsController::class, 'factura_pdf'])->name('factura_pdf');
    Route::get('credit_note_pdf/{id}', [ReportsController::class, 'note_pdf'])->name('note_pdf');
    



    Route::get('reportes/cuentas_cobrar', [ReportsController::class, 'cuentas_cobrar'])->name('reportes.cuentas_cobrar');
    
    Route::get('items/create/{id}', [ItemController::class, 'create'])->name('items.creation');
    Route::get('accounting/pay_cancel/{id}', [PaymentsController::class, 'pay_cancel'])->name('pay_cancel');
    Route::post('tempitems/{id}', [TempItemController::class, 'create_item'])->name('tempitems.create_item');
    Route::get('tempitems/edit/{id}/{captured}', [TempItemController::class, 'edit_item'])->name('tempitems.edit_item');
    Route::get('items/edit/{id}', [ItemController::class, 'edit_item'])->name('items.edit_item');
    
    Route::get('internal_orders/edit/{id}', [InternalOrderController::class, 'edit_order'])->name('internal_orders.edit_order');
    
    Route::post('internal_orders/validated_store}', [InternalOrderController::class, 'store'])->name('internal_orders.validated_store');
    Route::post('internal_orders/cancel/{id}}', [InternalOrderController::class, 'cancel'])->name('internal_orders.cancel');
    
    Route::post('internal_orders/capture', [InternalOrderController::class, 'capture'])->name('internal_orders.capture');
    Route::post('internal_orders/firmar', [InternalOrderController::class, 'firmar'])->name('internal_orders.firmar');
    Route::post('internal_orders/dgi', [InternalOrderController::class, 'dgi'])->name('internal_orders.dgi');
    Route::post('internal_orders/redefine', [InternalOrderController::class, 'redefine'])->name('internal_orders.redefine_order');
    Route::post('internal_orders/shipments', [InternalOrderController::class, 'shipment'])->name('internal_orders.shipment');
    Route::post('internal_orders/pay_conditions', [InternalOrderController::class, 'pay_conditions'])->name('internal_orders.pay_conditions');
    Route::post('internal_orders/pay_redefine', [InternalOrderController::class, 'pay_redefine'])->name('internal_orders.pay_redefine');
    Route::post('internal_orders/asignar_marca', [InternalOrderController::class, 'asignar_marca'])->name('internal_orders.asignar_marca');
    
    Route::get('internal_orders/print_order/{id}', [InternalOrderController::class, 'print_order'])->name('internal_orders.print_order');
    
    Route::get('exterminio', [InternalOrderController::class, 'exterminio'])->name('internal_orders.exterminio');
   
   //rutas par desautorizar un pedido
    Route::get('internal_orders/confirm_unautorize/{id}', [InternalOrderController::class, 'confirm_unautorize'])->name('internal_orders.confirm_unautorize');
    Route::post('internal_orders/auth_unautorize/{id}', [InternalOrderController::class, 'unautorize'])->name('internal_orders.unautorize');
  
   
    //rutas para agregar comisione
    Route::post('captura/comissions', [InternalOrderController::class, 'comissions'])->name('captura.comissions');
    Route::post('guardar_comission', [InternalOrderController::class, 'guardar_comissions'])->name('guardar_comissions');
    Route::get('comision/edit/{id}', [InternalOrderController::class, 'edit_temp_comissions'])->name('edit_temp_comissions');
    Route::post('comision/update/{id}', [InternalOrderController::class, 'update_temp_comissions'])->name('update_temp_comissions');
    Route::get('comision/delete/{id}', [InternalOrderController::class, 'delete_temp_comissions'])->name('delete_temp_comissions');
    Route::get('change_dgi/{id}/{mesagge?}', [InternalOrderController::class, 'change_dgi'])->name('change_dgi');
    Route::get('comision_real/edit/{id}/{origin}', [InternalOrderController::class, 'edit_comissions'])->name('edit_comissions');
    Route::post('comision_real/update/{id}', [InternalOrderController::class, 'update_comissions'])->name('update_comissions');
    Route::delete('comision_real/delete/{id}/{origin}', [InternalOrderController::class, 'delete_comissions'])->name('delete_comissions');
    Route::post('store_comission', [InternalOrderController::class, 'store_comissions'])->name('store_comissions');
    
    Route::get('accounting/order/{id}', [PaymentsController::class, 'cuentas_order'])->name('accounting.cuentas_order');
    Route::get('accounting/customer/{id}', [PaymentsController::class, 'cuentas_customer'])->name('accounting.cuentas_customer');
    Route::post('Items/redefine/{id}', [ItemController::class, 'redefine'])->name('items.redefine');
    Route::post('tempItems/redefine/{id}/{captured}', [TempItemController::class, 'redefine'])->name('temp_items.redefine');
    Route::post('internal_orders/pagos', [InternalOrderController::class, 'pagos'])->name('internal_orders.pagos');
    Route::post('accounting/pay_apply', [PaymentsController::class, 'pay_apply'])->name('accounting.pay_apply');
    Route::post('accounting/pay_amount_aply', [PaymentsController::class, 'pay_amount_apply'])->name('accounting.pay_amount_apply');
    Route::post('accounting/multi_pay_apply', [PaymentsController::class, 'multi_pay_apply'])->name('accounting.multi_pay_apply');
    
    Route::post('payments/invalidar', [PaymentsController::class, 'invalidar'])->name('accounting.invalidar');
    Route::get('payment/{id}', [InternalOrderController::class, 'payment'])->name('internal_orders.payment');
    Route::post('payment/edit/{id}', [InternalOrderController::class, 'payment_edit'])->name('internal_orders.payment_edit');
    Route::get('pay/{id}', [PaymentsController::class, 'pay_actualize'])->name('payments.pay_actualize');
    
    Route::get('pay_amount/{id}', [PaymentsController::class, 'pay_amount_actualize'])->name('payments.pay_amount_actualize');
    Route::post('multi_pay', [PaymentsController::class, 'multi_pay_actualize'])->name('payments.multi_pay_actualize');
    //metodos para reportes... 8 reportes son, bueno 7, tecnicamente son 11
    //ah pero ya nomas uso uno, soy la reata TODO: limpiar esta madre 
    
    Route::get('pedidoPDF/{id}', [ReportsController::class, 'pedido_pdf'])->name('pedido_pdf');
    Route::get('cuentas', [PaymentsController::class, 'cuentas_reporte'])->name('payments.cuentas_reporte');
    Route::post('internal_orders/partida', [InternalOrderController::class, 'partida'])->name('internal_orders.partida');
    Route::get('customer/crear_contacto({id}', [CustomerController::class, 'contacto'])->name('customers.contacto');
    Route::post('customer/guardar_contacto', [CustomerController::class, 'store_contact'])->name('customers.store_contact');
    
    Route::get('customers/validar_rfc', [ CustomerController::class, 'validar_rfc'])->name('customers.validar_rfc');
    Route::get('/foo', function () {
        Artisan::call('storage:link');
        });
});