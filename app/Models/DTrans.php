<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DTrans extends Model
{
    protected $table = 'dtrans';
    protected $fillable = ['htrans_id', 'product_id', 'quantity', 'price', 'subtotal'];

    public function header()
    {
        return $this->belongsTo(HTrans::class, 'htrans_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
