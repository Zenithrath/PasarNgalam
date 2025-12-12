<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController; 
use App\Models\User; // Import Model User

// --- HALAMAN UTAMA (USER DASHBOARD) ---
Route::get('/', function () {
    // Menampilkan Merchant yang aktif
    $merchants = User::where('role', 'merchant')
        ->where('is_active', true)
        ->whereHas('products') // Hanya yang punya produk
        ->get();
        
    return view('user.dashboard', compact('merchants'));
})->name('home');


// --- AUTHENTICATION ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::get('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- CUSTOMER ORDER FLOW (CHECKOUT & TRACKING) ---
Route::middleware(['auth'])->group(function () {
    
    // 1. Halaman Checkout
    Route::get('/checkout', [OrderController::class, 'indexCheckout'])->name('checkout'); 
    
    // 2. Proses Submit Order
    Route::post('/checkout/process', [OrderController::class, 'processCheckout'])->name('checkout.process');

    // 3. Halaman Pembayaran
    Route::get('/order/payment/{id}', [OrderController::class, 'showPayment'])->name('order.payment');
    Route::post('/order/payment/{id}/confirm', [OrderController::class, 'confirmPayment'])->name('order.confirmPayment');
    
    // 4. Halaman Tracking
    Route::get('/order/track/{id}', [OrderController::class, 'trackOrder'])->name('order.track');

    // 5. Submit Review Setelah Order Selesai
    Route::post('/order/{id}/review', [OrderController::class, 'submitReview'])->name('order.review');

});

// API Public (Untuk Map Tracking Realtime - Jika diperlukan tanpa auth)
Route::get('/api/order/{id}/location', [OrderController::class, 'getLocationData']);


// --- MERCHANT AREA ---
Route::middleware(['auth'])->group(function () {
    Route::get('/merchant/dashboard', [MerchantController::class, 'index'])->name('merchant.dashboard');

    // API Notifikasi Realtime Merchant
    Route::get('/merchant/orders/api', [MerchantController::class, 'getPendingOrdersApi'])->name('merchant.orders.api');

    // Manajemen Produk
    Route::post('/merchant/product', [MerchantController::class, 'storeProduct'])->name('merchant.product.store');
    Route::put('/merchant/product/{id}', [MerchantController::class, 'updateProduct'])->name('merchant.product.update');
    Route::delete('/merchant/product/{id}', [MerchantController::class, 'deleteProduct'])->name('merchant.product.delete');

    // Update Status Order (Terima/Masak/Selesai)
    Route::put('/merchant/order/{id}/update', [OrderController::class, 'updateStatus'])->name('merchant.order.update');
});


// --- DRIVER AREA ---
Route::middleware(['auth'])->group(function () {
    Route::get('/driver/dashboard', [DriverController::class, 'index'])->name('driver.dashboard');
    
    // Operasional Driver
    Route::post('/driver/update-location', [DriverController::class, 'updateLocation']); 
    Route::post('/driver/toggle-status', [DriverController::class, 'toggleStatus'])->name('driver.toggle'); 
    
    // Order Action (Terima & Selesai)
    Route::post('/driver/order/{id}/accept', [DriverController::class, 'acceptOrder'])->name('driver.order.accept'); 
    Route::post('/driver/order/{id}/complete', [DriverController::class, 'completeOrder'])->name('driver.order.complete'); 
});


// --- GLOBAL USER PROFILE ---
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
