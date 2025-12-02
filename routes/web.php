<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ProfileController;

// --- HALAMAN PUBLIK ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// --- AUTHENTICATION ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- MERCHANT AREA ---
// Kita hanya cek login (auth) di sini. Cek Role dilakukan di Controller.
Route::middleware(['auth'])->group(function () {
    Route::get('/merchant/dashboard', [MerchantController::class, 'index'])->name('merchant.dashboard');
    Route::post('/merchant/product', [MerchantController::class, 'storeProduct'])->name('merchant.product.store');
    Route::put('/merchant/product/{id}', [MerchantController::class, 'updateProduct'])->name('merchant.product.update');
    Route::delete('/merchant/product/{id}', [MerchantController::class, 'deleteProduct'])->name('merchant.product.delete');
});



// --- DRIVER AREA ---
// Kita hanya cek login (auth) di sini. Cek Role dilakukan di Controller.
Route::middleware(['auth'])->group(function () {
    Route::get('/driver/dashboard', [DriverController::class, 'index'])->name('driver.dashboard');
    Route::post('/driver/order/{id}/take', [DriverController::class, 'takeOrder'])->name('driver.order.take');
    Route::post('/driver/order/{id}/complete', [DriverController::class, 'completeOrder'])->name('driver.order.complete');
});


// --- CUSTOMER CHECKOUT ---
Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::post('/checkout-process', function () {
    return redirect('/')->with('success', 'Pesanan berhasil dibuat! Driver sedang mencarimu.');
})->name('checkout.process');