<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\SellerAuthController;
use App\Http\Controllers\Auth\PelangganAuthController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendefinisikan rute–rute untuk aplikasi Anda.
|
*/

// Route utama (misal: halaman landing/welcome)
Route::get('/', function () {
    return redirect()->route('customer.login');
});

Route::prefix('customer')->group(function () {
    Route::get('/login', [PelangganAuthController::class, 'loginForm'])->name('customer.login');
    Route::post('/login', [PelangganAuthController::class, 'login'])->name('customer.login.process');
    Route::get('/register', [PelangganAuthController::class, 'registerForm'])->name('customer.register');
    Route::post('/register', [PelangganAuthController::class, 'register'])->name('customer.register.process');
    Route::get('/home', [HomeController::class, 'index'])->name('customer.home');
   
});
Route::middleware('auth:pelanggan')->group(function () {
    Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
    Route::get('/payment/{id_transaksi}', [PaymentController::class, 'paymentForm'])->name('payment.form');
    Route::post('/payment/{id_transaksi}', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
});Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('customer.cart');
Route::prefix('seller')->group(function () {
    Route::get('/login', [SellerAuthController::class, 'loginForm'])->name('seller.login');
    Route::post('/login', [SellerAuthController::class, 'login'])->name('seller.login.process');
    Route::middleware('auth:penjual')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('seller.dashboard');
        Route::resource('produk', ProductController::class, ['as' => 'seller']);
        Route::get('/reports', [ReportController::class, 'index'])->name('seller.reports.index');
    });
});
Route::post('/logout', function () {
    if (auth()->guard('penjual')->check()) {
        auth()->guard('penjual')->logout();
    }
    if (auth()->guard('pelanggan')->check()) {
        auth()->guard('pelanggan')->logout();
    }
    return redirect('/');
})->name('logout');
