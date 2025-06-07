<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/welcome', function () {
    return view('welcome'); // tampilkan view login
})->name('welcome');

Route::get('/login', function () {
    return view('login'); // tampilkan view login
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dashboard_apoteker', function () {
    return view('dashboard_apoteker');
})->name('dashboard_apoteker');

Route::get('/registrasi', function () {
    return view('registrasi');
})->name('registrasi');

Route::get('/Supplier/add', function(){
    return view('/Supplier/add');
})->name('supplier.add');

Route::get('/Supplier/index', function () {
    return view('Supplier/index');
})->name('supplier.index');

Route::post('/Supplier/index', [SupplierController::class, 'indexSupplier'])->name('supplier.index');
Route::post('/Supplier/add', [SupplierController::class, 'addSupplier'])->name('supplier.add');


// Route::post('/dashboard_apoteker', [WarehouseController::class, 'dashboard_apoteker'])->name('dashboard_apoteker');

// Route::resource('supplier', SupplierController::class);