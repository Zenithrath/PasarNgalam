<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['order_id', 'reviewer_id', 'target_id', 'rating', 'comment'];

    public function reviewer() {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function target() {
        return $this->belongsTo(User::class, 'target_id');
    }
}