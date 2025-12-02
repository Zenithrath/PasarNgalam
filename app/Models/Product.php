<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['merchant_id', 'name', 'price', 'description', 'image', 'is_available'];
}
