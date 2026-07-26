<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;

class apiController extends Controller
{
    public function apiIndex()
{    
    /* 
    $products = Product::all();

    return response()->json([
        'status' => "success",
        'source_module' => 'module',
        'target_module' => 'module',
        'data_count' => $products->count(),
        'data' => $products,
    ], 200, [], JSON_PRETTY_PRINT);

    

    // To Sales Module

    $orders = Order::all();

    return response()->json([
        'status' => "success",
        'source_module' => 'module',
        'target_module' => 'module',
        'data_count' => $orders->count(),
        'data' => $orders,
    ], 200, [], JSON_PRETTY_PRINT);
    */
}

    public function apiOrder() {
        $orders = Order::all();

    return response()->json([
        'status' => "success",
        'source_module' => 'module',
        'target_module' => 'module',
        'data_count' => $orders->count(),
        'data' => $orders,
    ], 200, [], JSON_PRETTY_PRINT);
    }

    public function apiCustomerOrder() {

    }
}
