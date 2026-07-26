<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class apiController extends Controller
{
    public function apiIndex()
{
    $products = Product::all();

    return response()->json([
        'success' => true,
        'message' => 'Products retrieved successfully.',
        'count' => $products->count(),
        'data' => $products,
    ], 200, [], JSON_PRETTY_PRINT);
}
}
