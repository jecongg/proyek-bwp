<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = "mysql";
    protected $table = "product";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image_url',
        'id_category'
    ];
}
