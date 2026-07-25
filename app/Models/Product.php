<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'sku',
        'product_name',
        'brand',
        'category',
        'description',
        'category_id',
        'price',
        'cost',
        'stock_quantity',
        'status',
        'image_url',
    ];
}