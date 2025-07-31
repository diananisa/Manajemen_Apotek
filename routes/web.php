<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Presensi;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;


// Route::get('/', function () {
//     return redirect()->route('dashboard');
// });

Route::get('/', function () {
    return view('welcome'); // tampilkan view login
})->name('welcome');

//lOGIN

Route::get('Login/login', function () {
    return view('Login/login'); // tampilkan view login
})->name('Login.login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');


// Route::post('/login/showLoginForm', function(){
//     return view('/login/showLoginForm');
// })->name('login.form');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::get('/dashboard_manager', function () {
    return view('dashboard_manager', ['Username' =>session('Username')]);
})->name('dashboard_manager');

Route::get('/dashboard_kasir', function () {
    return view('dashboard_kasir', ['Username' =>session('Username')]);
})->name('dashboard_kasir');

Route::get('/dashboard_apoteker', function () {
    return view('dashboard_apoteker', ['Username' =>session('Username')]);
})->name('dashboard_apoteker');

// Route::get('/registrasi', function () {
//     return view('registrasi');
// })->name('registrasi');

//SUPPLIER
Route::get('/Supplier/add', [SupplierController::class, 'create'])->name('Supplier.add');

Route::get('/Supplier/index', [SupplierController::class, 'index'])->name('supplier.index');
Route::post('/Supplier_store', [SupplierController::class, 'store'])->name('supplier.store');
// Route::post('/supplier_edit/[{id}',pplierController::class, 'edit'])->name('supplier.edit');Route::post('/supplier_destroy', [SupplierController::class, 'destroy'])->name('supplier.destroy');
Route::post('/Supplier_update', [SupplierController::class, 'update'])->name('supplier.update');

Route::post('/Supplier_destroy/{Id_supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
Route::get('/Supplier/edit/{Id_supplier}', [SupplierController::class, 'edit'])->name('supplier.edit');

// Laporan Supplier
Route::get('/supplier-laporan', [\App\Http\Controllers\SupplierController::class, 'laporan'])->name('supplier.laporan');
// Route::post('/Supplier/update/{Id_supplier}', [SupplierController::class, 'update'])->name('supplier.update');

// Route::get('api/Supplier/{id}', [SupplierController::class, 'getSupplierbyId']);




//PRODUCT
Route::get('/Product/add', [ProductController::class, 'create'])->name('product.add');
Route::get('/Product/utama', [ProductController::class, 'utama'])->name('product.utama');


Route::put('/Product_update/{Id_Obat}', [ProductController::class, 'update'])->name('product.update');
Route::get('/Product/index', [ProductController::class, 'index'])->name('product.index');

// Laporan Product
Route::get('/product-laporan', [\App\Http\Controllers\ProductController::class, 'laporan'])->name('Product.laporan');

Route::post('/Product_store', [ProductController::class, 'store'])->name('product.store');
Route::post('/Product_destroy/{Id_Obat}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('/Product/edit/{Id_Obat}', [ProductController::class, 'edit'])->name('product.edit');
Route::post('Produk_cart/', [ProductController::class, 'addToCart'])->name('cart.add');

// DASHBOARD
Route::get('/dashboard_apoteker', [DashboardController::class, 'dashboardApoteker'])->name('dashboard_apoteker');
Route::get('/dashboard_kasir', [DashboardController::class, 'dashboardKasir'])->name('dashboard_kasir');
Route::get('/dashboard_manager', [DashboardController::class, 'dashboardManager'])->name('dashboard_manager');


#PRESENSI
Route::get('/Presensi/index', function(){
    return view('/Presensi/index');
})->name('presensi.index');

Route::get('/Presensi/belum', function(){
    return view('/Presensi/belum');
})->name('presensi.belum');

Route::get('/Presensi/sudah', function(){
    return view('/Presensi/sudah');
})->name('presensi.sudah');

Route::get('/Presensi/gagal', function(){
    return view('/Presensi/gagal');
})->name('presensi.gagal');

Route::post('/Presensi/berhasil', [PresensiController::class, 'store'])->name('presensi.store');

// Cart related
Route::get('/Cart/cart', [CartController::class, 'cartView'])->name('cart.view');
Route::post('/Cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/Checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/bayar', [CartController::class, 'bayar'])->name('bayar');
Route::get('/Cart/method', [CartController::class, 'method'])->name('Cart.method');
Route::get('/Cart/reset', [CartController::class, 'reset'])->name('cart.reset');

// Cart Update
Route::post('/Cart/updateQty/{id}/{mode}', [CartController::class, 'updateQty'])->name('Cart.updateQty');
Route::post('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('Cart.removeItem');

// Metode pembayaran
Route::match(['get', 'post'], '/Cart/cash/{kode}', [CartController::class, 'cash'])->name('method.cash');
Route::get('/Cart/qris/{kode}', [CartController::class, 'qris'])->name('method.qris');
Route::get('/Cart/debit/{kode}', [CartController::class, 'debit'])->name('method.debit');

// Success
Route::get('/Cart/success', function () {
    return view('Cart.success');
})->name('cart.success');

// Cetak struk
Route::get('/Cart/pdf', [CartController::class, 'printPDF'])->name('print.pdf');
Route::get('/struk/{kode}', [CartController::class, 'cetakPDF'])->name('struk.pdf');

Route::resource('Supplier', SupplierController::class);
Route::resource('Product', ProductController::class);
