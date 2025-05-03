<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\UserSystemProfileController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CoinController;
use App\Http\Controllers\Admin\CustomerContactController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerShippingAddressController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\AdministradorController;
use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\MarcasController;
use App\Http\Controllers\Admin\MediosController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\ProductController;

Route::group(['middleware' => ['auth']], function()
{
    Route::resource('users', UserController::class);
    Route::resource('roles', RolController::class);
    Route::resource('user_system_profiles', UserSystemProfileController::class);
    Route::resource('company_profiles', CompanyProfileController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('coins', CoinController::class);
    Route::resource('banks', BankController::class);
    Route::resource('units', UnitController::class);
    Route::resource('families', FamilyController::class);
    
    Route::resource('report_product', ProductController::class);
    
    Route::resource('marcas', MarcasController::class);
    Route::resource('medios', MediosController::class);
    
    Route::get('families/subfamilies/{id}', [ FamilyController::class, 'subfam_show'])->name('subfam_show');
    Route::get('categories', [ FamilyController::class, 'categories'])->name('categories');
    Route::get('categories/products', [ FamilyController::class, 'categories'])->name('products');
   
    Route::get('categories/products/{id}', [ FamilyController::class, 'products_show'])->name('products_show');
    
    Route::resource('authorizations', AuthorizationController::class);    
    Route::resource('customers', CustomerController::class);
    Route::post('customers/register', [ CustomerController::class, 'rfc'])->name('customers.rfc');
    
    Route::get('customers/select_seller/{id}', [ CustomerController::class, 'select_seller'])->name('customers.select_seller');
    Route::post('customers/update_seller/{id}', [ CustomerController::class, 'update_seller'])->name('customers.update_seller');

    Route::resource('customers_shipping_address', CustomerShippingAddressController::class);
    Route::get('customers_shipping_address/delete/{id}/{temp_id}/{order_id?}', [CustomerShippingAddressController::class,'destroyb'])->name('customers_shipping_address.borrar');
    Route::get('customers_shipping_address/show/{id}/{order_id?}', [CustomerShippingAddressController::class,'show'])->name('customers_shipping_address.show_real');
    Route::get('customers_shipping_address/edit/{id}/{temp_id}/{order_id?}', [CustomerShippingAddressController::class,'edit'])->name('customers_shipping_address.editb');
    
    
    
    Route::resource('customer_contacts', CustomerContactController::class);
    Route::post('customer_contacts/update_"/{id}', [CustomerContactController::class, 'update'])->name('customer_contacts.update2');
    
    Route::resource('sellers', SellerController::class);
    Route::get('sellers/customers/{id}', [ SellerController::class, 'customers'])->name('sellers.customers');
    
    Route::get('sellers_asign', [ SellerController::class, 'asign_customers'])->name('sellers.aSsign_customers');


    
    Route::get('sellers_reasiganar/{id}', [ SellerController::class, 'reasign_customer'])->name('sellers.reasign_customer');
    Route::post('confirm_reasign', [ SellerController::class, 'confirm_reasign'])->name('sellers.confirm_reasign');

    Route::get('sellers/select_customers/{id}', [ SellerController::class, 'select_customers'])->name('sellers.select_customers');
    Route::post('sellers/update_customers/{id}', [ SellerController::class, 'update_customers'])->name('sellers.update_customers');

    Route::get('dgi_com', [ SellerController::class, 'dgi_index'])->name('dgi_com.index');
    Route::get('dgi_com/edit/{id}', [ SellerController::class, 'dgi_edit'])->name('dgi_com.edit');
    Route::post('dgi_com/update/{id}', [ SellerController::class, 'dgi_update'])->name('dgi_com.update');

    Route::get('administrador', [AdministradorController::class, 'index'])->name('admin.index');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/contact/{customer_id}', [ContactController::class, 'principal'])->name('contactos.principal');
// Route::middleware(['auth:sanctum', 'verified'])->get('/newcontact/{customer_id}', [ContactController::class, 'new'])->name('contactos.nuevo');