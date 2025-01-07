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
        'url_image',
        'id_category',
        'deleted_at'
    ];

    public function Category(){
        return $this->hasOne(Category::class, 'id', 'id_category');
    }
}
