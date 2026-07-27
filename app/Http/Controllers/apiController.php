<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Customer;

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
        'source_module' => 'Ecommerce module',
        'target_module' => 'Sales and Customer Support Management module',
        'data_count' => $orders->count(),
        'data' => $orders,
    ], 200, [], JSON_PRETTY_PRINT);
    }


    public function apiProducts() {

        $products = Product::all();

        return response()->json([
            'status' => "success",
            'source_module' => 'Ecommerce module',
            'target_module' => 'Inventory and Warehouse Management System module',
            'data_count' => $products->count(),
            'data' => $products,
        ], 200, [], JSON_PRETTY_PRINT);
    }
    
    public function apiPayments() {
         
        $payment = Payment::all();

        return response()->json([
            'status' => "success",
            'source_module' => 'Ecommerce module',
            'target_module' => 'Financing and Accounting module',
            'data_count' => $payment->count(),
            'data' => $payment,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function apiCustomer() {
        
        $customer = Customer::all();

        return response()->json([
            'status' => "success",
            'source_module' => 'Ecommerce module',
            'target_module' => 'Customer Service / Helpdesk module',
            'data_count' => $customer->count(),
            'data' => $customer,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function apiGetAll()
{
    $orders = Order::all();
    $products = Product::all();
    $payments = Payment::all();
    $customers = Customer::all();

    return response()->json([
        'status' => 'success',
        'source_module' => 'Ecommerce Module',

        'modules' => [

            'sales_and_customer_support' => [
                'target_module' => 'Sales and Customer Support Management Module',
                'data_count' => $orders->count(),
                'data' => $orders,
            ],

            'inventory_and_warehouse' => [
                'target_module' => 'Inventory and Warehouse Management System Module',
                'data_count' => $products->count(),
                'data' => $products,
            ],

            'finance_and_accounting' => [
                'target_module' => 'Finance and Accounting Module',
                'data_count' => $payments->count(),
                'data' => $payments,
            ],

            'customer_service_helpdesk' => [
                'target_module' => 'Customer Service / Helpdesk Module',
                'data_count' => $customers->count(),
                'data' => $customers,
            ],
        ],
    ], 200, [], JSON_PRETTY_PRINT);
}
}
