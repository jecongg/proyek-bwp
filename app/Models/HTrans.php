<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HTrans extends Model
{
    protected $table = 'htrans';
    protected $fillable = ['user_id', 'total_price', 'status'];

    public function details()
    {
        return $this->hasMany(DTrans::class, 'htrans_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->where('role', 'Customer');
    }
}
