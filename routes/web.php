<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;

// Route::get('/', function () {
//     return redirect()->route('dashboard');
// });

Route::get('/', function () {
    return view('welcome'); // tampilkan view login
})->name('welcome');

Route::get('/login', function () {
    return view('login'); // tampilkan view login
})->name('login');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::get('/dashboard_manager', function () {
    return view('dashboard_manager');
})->name('dashboard_manager');

Route::get('/dashboard_kasir', function () {
    return view('dashboard_kasir');
})->name('dashboard_kasir');

Route::get('/dashboard_apoteker', function () {
    return view('dashboard_apoteker');
})->name('dashboard_apoteker');

// Route::get('/registrasi', function () {
//     return view('registrasi');
// })->name('registrasi');

//SUPPLIER
Route::get('/Supplier/add', function(){
    return view('/Supplier/add');
})->name('supplier.add');

Route::post('/Supplier/add', function(){
    return view('/Supplier/add');
})->name('supplier.add');

Route::get('/Supplier/edit', function(){
    return view('/Supplier/edit');
})->name('supplier.edit');

// 
Route::get('/Supplier/index', [SupplierController::class, 'index'])->name('supplier.index');

// Route::post('/Supplier/store', function () {
//     return view('Supplier/store');
// })->name('supplier.store');
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::post('/supplier_edit', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::post('/supplier_destroy', [SupplierController::class, 'destroy'])->name('supplier.destroy');



//PRODUCT
Route::get('/Product/add', function () {
    return view('Product/add');
})->name('product.add');

Route::get('/Product/index', function () {
    return view('Product/index');
})->name('product.index');

// Route::post('/Product/add', function () {
//     return view('Product/add');
// })->name('product.add');

Route::get('/Product/edit', function(){
    return view('/Product/edit');
})->name('product.edit');

// Route::post('/Product/add', [ProductController::class, 'add'])->name('product.add');



// Route::get('/Supplier/add', [SupplierController::class, 'add'])->name('supplier.add');
// Route::get('/Supplier/index', [SupplierController::class, 'indexSupplier'])->name('supplier.index');
// Route::post('/Supplier/index', [SupplierController::class, 'index'])->name('supplier.index');
// Route::post('/Supplier/add', [SupplierController::class, 'add'])->name('supplier.add');


// Route::post('/dashboard_apoteker', [WarehouseController::class, 'dashboard_apoteker'])->name('dashboard_apoteker');

// Route::resource('supplier', SupplierController::class);