<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Channel untuk Merchant: Menerima Order Baru
Broadcast::channel('merchant.{merchantId}', function ($user, $merchantId) {
    return (int) $user->id === (int) $merchantId && $user->role === 'merchant';
});

// Channel untuk Driver: Menerima Update Lokasi / Order
Broadcast::channel('driver.{driverId}', function ($user, $driverId) {
    return (int) $user->id === (int) $driverId && $user->role === 'driver';
});

// Channel Umum User (untuk tracking order mereka sendiri)
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
