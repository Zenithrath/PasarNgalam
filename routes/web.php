<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('user');
});

Route::get('/mitra-login', function () {
    return view('merchant.auth'); 
});


Route::get('/merchant/dashboard', function () {
    return view('merchant.dashboard');
});

Route::get('/login', function () {
    return view('auth.login'); 
})->name('login');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');