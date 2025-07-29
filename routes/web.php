<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Presensi;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;


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
Route::get('/Supplier/add', function(){
    return view('/Supplier/add');
})->name('supplier.add');

Route::post('/Supplier/add', function(){
    return view('/Supplier/add');
})->name('supplier.add');

// Route::get('/Supplier/edit', function(){
    //     return view('/Supplier/edit');
    // })->name('supplier.edit');
    
    // 
    Route::get('/Supplier/index', [SupplierController::class, 'index'])->name('supplier.index');
    
    // Route::post('/Supplier/store', function () {
        //     return view('Supplier/store');
        // })->name('supplier.store');
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
// Route::get('/Product/add', function () {
//     return view('Product/add');
// })->name('product.add');

Route::get('/Product/add', [ProductController::class, 'create'])->name('product.add');

// Route::get('/Product/cart', function () {
//     return view('Product/cart');
// })->name('product.cart');

Route::get('/Product/utama', [ProductController::class, 'utama'])->name('product.utama');


Route::put('/Product_update/{Id_Obat}', [ProductController::class, 'update'])->name('product.update');
Route::get('/Product/index', [ProductController::class, 'index'])->name('product.index');

// Laporan Product
Route::get('/product-laporan', [\App\Http\Controllers\ProductController::class, 'laporan'])->name('Product.laporan');

// Route::post('/Product/add', function () {
//     return view('Product/add');
// })->name('product.add');

// Route::get('/Product/edit', function(){
//     return view('/Product/edit');
// })->name('product.edit');

Route::post('/Product_store', [ProductController::class, 'store'])->name('product.store');
// Route::post('/Product_update/{Id_Obat}', [ProductController::class, 'update'])->name('product.update');
Route::post('/Product_destroy/{Id_Obat}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('/Product/edit/{Id_Obat}', [ProductController::class, 'edit'])->name('product.edit');
Route::post('Produk_cart/', [ProductController::class, 'addToCart'])->name('cart.add');






#PRESENSI
Route::get('/Presensi/index', function(){
    return view('/Presensi/index');
})->name('presensi.index');

Route::get('/Presensi/belum', function(){
    return view('/Presensi/belum');
})->name('presensi.belum');

// Route::post('/Presensi/berhasil', function(){
//     return view('/Presensi/berhasil');
// })->name('presensi.berhasil');
Route::get('/Presensi/sudah', function(){
    return view('/Presensi/sudah');
})->name('presensi.sudah');

Route::get('/Presensi/gagal', function(){
    return view('/Presensi/gagal');
})->name('presensi.gagal');

Route::post('/Presensi/berhasil', [PresensiController::class, 'store'])->name('presensi.store');



// Route::post('/Product/add', [ProductController::class, 'add'])->name('product.add');



// Route::get('/Supplier/add', [SupplierController::class, 'add'])->name('supplier.add');
// Route::get('/Supplier/index', [SupplierController::class, 'indexSupplier'])->name('supplier.index');
// Route::post('/Supplier/index', [SupplierController::class, 'index'])->name('supplier.index');
// Route::post('/Supplier/add', [SupplierController::class, 'add'])->name('supplier.add');


// Route::post('/dashboard_apoteker', [WarehouseController::class, 'dashboard_apoteker'])->name('dashboard_apoteker');

// Route::resource('supplier', SupplierController::class);

Route::get('/Product/cart', [CartController::class, 'cartView'])->name('cart.view');
Route::post('/Checkout', [CartController::class, 'checkout'])->name('checkout');
// Route::post('/Checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('/Cart/method', function(){
    return view('/Cart/method');
})->name('Cart.method');

Route::get('/Cart/qris', function(){
    return view('/Cart/qris');
})->name('method.qris');

Route::get('/Cart/cash', function(){
    return view('/Cart/cash');
})->name('method.cash');

Route::get('/Cart/pdf', function(){
    return view('/Cart/pdf');
})->name('print.pdf');

// Route::get('/Struk', [CartController::class, 'struk'])->name('struk');
// Cetak PDF berdasarkan kode transaksi (DIPAKAI SAAT CHECKOUT)
Route::get('/struk/{kode}', [CartController::class, 'cetakPDF'])->name('struk.pdf');

Route::resource('Supplier', SupplierController::class);
Route::resource('Product', ProductController::class);
