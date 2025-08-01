<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    SupplierController,
    ProductController,
    PresensiController,
    CartController,
    LoginController
};

// ------------------------
// ROUTE BEBAS LOGIN
// ------------------------
Route::get('/', fn() => view('welcome'))->name('welcome');
Route::get('Login/login', fn() => view('Login/login'))->name('Login.login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ------------------------
// ROUTE WAJIB LOGIN
// ------------------------
Route::middleware('auth.session')->group(function () {

    // ======================
    // APOTEKER
    // ======================
    Route::middleware('role:Apoteker')->group(function () {
        Route::get('/dashboard/apoteker', [DashboardController::class, 'dashboardApoteker'])->name('dashboard_apoteker');

        Route::get('/Supplier/add', [SupplierController::class, 'create'])->name('Supplier.add');
        Route::get('/Supplier/index', [SupplierController::class, 'index'])->name('Supplier.index');
        Route::post('/Supplier_store', [SupplierController::class, 'store'])->name('Supplier.store');
        Route::post('/Supplier_update', [SupplierController::class, 'update'])->name('Supplier.update');
        Route::post('/Supplier_destroy/{Id_supplier}', [SupplierController::class, 'destroy'])->name('Supplier.destroy');
        Route::get('/Supplier/edit/{Id_supplier}', [SupplierController::class, 'edit'])->name('Supplier.edit');

        Route::get('/Product/add', [ProductController::class, 'create'])->name('Product.add');
        Route::put('/Product_update/{Id_Obat}', [ProductController::class, 'update'])->name('Product.update');
        Route::get('/Product/index', [ProductController::class, 'index'])->name('Product.index');
        Route::post('/Product_store', [ProductController::class, 'store'])->name('Product.store');
        Route::post('/Product_destroy/{Id_Obat}', [ProductController::class, 'destroy'])->name('Product.destroy');
        Route::get('/Product/edit/{Id_Obat}', [ProductController::class, 'edit'])->name('Product.edit');
        Route::get('/Presensi/apoteker/belum', fn() => view('Presensi.apoteker.belum'))->name('Presensi.apoteker.belum');
        Route::get('/Presensi/apoteker/sudah', fn() => view('Presensi.apoteker.sudah'))->name('Presensi.apoteker.sudah');
    });
    
    // ======================
    // MANAJER
    // ======================
    Route::middleware('role:Manajer')->group(function () {
        Route::get('/dashboard/manajer', [DashboardController::class, 'dashboardManager'])->name('dashboard_manager');
        Route::get('/supplier-laporan', [SupplierController::class, 'laporan'])->name('Supplier.laporan');
        Route::get('/product-laporan', [ProductController::class, 'laporan'])->name('Product.laporan');
        Route::post('/presensi/update-status', [PresensiController::class, 'updateStatus'])
            ->name('Presensi.updateStatus');
    });
    
    Route::get('/Presensi/index', [PresensiController::class, 'index'])->name('Presensi.index');
    // ======================
    // KASIR
    // ======================
    Route::middleware('role:Kasir')->group(function () {
        Route::get('/dashboard/kasir', [DashboardController::class, 'dashboardKasir'])->name('dashboard_kasir');
        
        // Transaksi / Cart
        Route::get('/Product/utama', [ProductController::class, 'utama'])->name('Product.utama');
        Route::get('/Cart/cart', [CartController::class, 'cartView'])->name('cart.view');
        Route::post('/Cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/Checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/bayar', [CartController::class, 'bayar'])->name('bayar');
        Route::get('/Cart/method', [CartController::class, 'method'])->name('Cart.method');
        Route::get('/Cart/reset', [CartController::class, 'reset'])->name('cart.reset');
        Route::post('/Cart/updateQty/{id}/{mode}', [CartController::class, 'updateQty'])->name('Cart.updateQty');
        Route::post('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('Cart.removeItem');
        Route::match(['get', 'post'], '/Cart/cash/{kode}', [CartController::class, 'cash'])->name('method.cash');
        Route::get('/Cart/qris/{kode}', [CartController::class, 'qris'])->name('method.qris');
        Route::get('/Cart/debit/{kode}', [CartController::class, 'debit'])->name('method.debit');
        Route::get('/Cart/success', fn() => view('Cart.success'))->name('cart.success');
        Route::get('/Cart/pdf', [CartController::class, 'printPDF'])->name('print.pdf');
        Route::get('/struk/{kode}', [CartController::class, 'cetakPDF'])->name('struk.pdf');
        Route::get('/Presensi/kasir/sudah', fn() => view('Presensi.kasir.sudah'))->name('Presensi.kasir.sudah');
        Route::get('/Presensi/kasir/belum', fn() => view('Presensi.kasir.belum'))->name('Presensi.kasir.belum');
    });

    // ======================
    // PRESENSI (Bisa diakses semua yang login)
    // ======================
    Route::get('/Presensi/belum', fn() => view('Presensi.belum'))->name('Presensi.belum');
    Route::get('/Presensi/sudah', fn() => view('Presensi.sudah'))->name('Presensi.sudah');
    Route::post('/Presensi', [PresensiController::class, 'store'])->name('Presensi.store');
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap'])->name('Presensi.rekap');
});
