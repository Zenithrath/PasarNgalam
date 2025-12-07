<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderActivity extends Model
{
    protected $fillable = [
        'order_id', 'actor_type', 'actor_id', 'action', 'message'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
