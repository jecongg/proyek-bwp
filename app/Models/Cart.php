<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = ['user_id'];

    public function details()
    {
        return $this->hasMany(DCart::class, 'cart_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTotalAttribute()
    {
        return $this->details->sum(function($detail) {
            return $detail->product->price * $detail->quantity;
        });
    }
}
