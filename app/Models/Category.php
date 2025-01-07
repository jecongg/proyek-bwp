<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection = "mysql";
    protected $table = "category";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'url_image',
    ];
}
