<?php
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\QuickEditController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\VariantController;
use Illuminate\Support\Facades\Route;

Route::get('/',[StorefrontController::class,'index'])->name('storefront');
Route::middleware('guest')->group(function(){ Route::get('/admin/login',[AuthController::class,'create'])->name('admin.login'); Route::post('/admin/login',[AuthController::class,'store'])->middleware('throttle:8,1')->name('admin.login.store'); });
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::post('/logout',[AuthController::class,'destroy'])->name('logout');
    Route::get('/',DashboardController::class)->name('dashboard');
    Route::get('/products/quick-edit',[QuickEditController::class,'index'])->name('products.quick-edit');
    Route::put('/products/quick-edit',[QuickEditController::class,'update'])->name('products.quick-update');
    Route::post('/products/reorder',[ProductController::class,'reorder'])->name('products.reorder');
    Route::resource('products',ProductController::class)->except('show');
    Route::post('/products/{product}/options',[VariantController::class,'storeOption'])->name('products.options.store');
    Route::put('/products/{product}/options/{option}',[VariantController::class,'updateOption'])->name('products.options.update');
    Route::delete('/products/{product}/options/{option}',[VariantController::class,'destroyOption'])->name('products.options.destroy');
    Route::post('/products/{product}/options/{option}/values',[VariantController::class,'storeValue'])->name('products.options.values.store');
    Route::put('/products/{product}/options/{option}/values/{value}',[VariantController::class,'updateValue'])->name('products.options.values.update');
    Route::delete('/products/{product}/options/{option}/values/{value}',[VariantController::class,'destroyValue'])->name('products.options.values.destroy');
    Route::post('/products/{product}/variants',[VariantController::class,'storeVariant'])->name('products.variants.store');
    Route::delete('/products/{product}/variants/{variant}',[VariantController::class,'destroyVariant'])->name('products.variants.destroy');
    Route::post('/categories/reorder',[CategoryController::class,'reorder'])->name('categories.reorder');
    Route::resource('categories',CategoryController::class)->only(['index','store','update','destroy']);
    Route::get('/settings',[SettingController::class,'edit'])->name('settings.edit');
    Route::put('/settings',[SettingController::class,'update'])->name('settings.update');
});
