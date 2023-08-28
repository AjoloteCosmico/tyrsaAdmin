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
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\BankController;

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
    Route::get('families/subfamilies/{id}', [ FamilyController::class, 'subfam_show'])->name('subfam_show');
    Route::get('categories', [ FamilyController::class, 'categories'])->name('categories');
    Route::get('categories/products/{id}', [ FamilyController::class, 'products_show'])->name('products_show');
    
    Route::resource('authorizations', AuthorizationController::class);    
    Route::resource('customers', CustomerController::class);
    Route::post('customers/register', [ CustomerController::class, 'rfc'])->name('customers.rfc');
    
    Route::resource('customers_shipping_address', CustomerShippingAddressController::class);
    Route::get('customers_shipping_address/delete/{id}/{temp_id}', [CustomerShippingAddressController::class,'destroyb'])->name('customers_shipping_address.borrar');
    
    
    Route::resource('customer_contacts', CustomerContactController::class);
    Route::post('customer_contacts/update_"/{id}', [CustomerContactController::class, 'update'])->name('customer_contacts.update2');
    
    Route::resource('sellers', SellerController::class);
    Route::get('sellers/customers/{id}', [ SellerController::class, 'customers'])->name('sellers.customers');
    
    Route::get('administrador', [AdministradorController::class, 'index'])->name('admin.index');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/contact/{customer_id}', [ContactController::class, 'principal'])->name('contactos.principal');
// Route::middleware(['auth:sanctum', 'verified'])->get('/newcontact/{customer_id}', [ContactController::class, 'new'])->name('contactos.nuevo');