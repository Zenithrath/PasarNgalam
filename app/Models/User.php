<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'store_name',
        'vehicle_plate',
        'vehicle_type',
        'is_active',
        'profile_picture',
        'address',
        'banner',
        'latitude',
        'longitude',
        'is_online',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Agar average_rating ikut muncul saat dikonversi ke JSON
    protected $appends = ['average_rating', 'total_reviews'];

    // =====================
    //     RELASI
    // =====================

    public function products()
    {
        return $this->hasMany(Product::class, 'merchant_id');
    }

    public function merchantOrders()
    {
        return $this->hasMany(Order::class, 'merchant_id');
    }

    public function driverOrders()
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    // Review yang diterima user (merchant/driver)
    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'target_id');
    }

    // Review yang ditulis oleh user
    public function reviewsWritten()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    // =====================
    //     RATING HELPER
    // =====================

    public function getAverageRatingAttribute()
    {
        $avg = $this->reviewsReceived()->avg('rating');
        return number_format($avg ?? 5.0, 1);
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviewsReceived()->count();
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
