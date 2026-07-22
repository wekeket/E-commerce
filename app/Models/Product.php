<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sku',
        'name',
        'category_id',
        'price',
        'cost',
        'stock_quantity',
        'status',
        'image_url',
    ];
}