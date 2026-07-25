<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_items')->insert([
    [
        'id' => 1,
        'order_id' => 1,
        'product_id' => 1,
        'quantity' => 1,
        'unit_price' => 1450.00,
    ],
    [
        'id' => 2,
        'order_id' => 2,
        'product_id' => 2,
        'quantity' => 1,
        'unit_price' => 2100.00,
    ],
    [
        'id' => 3,
        'order_id' => 3,
        'product_id' => 1,
        'quantity' => 1,
        'unit_price' => 1300.00,
    ],
    [
        'id' => 4,
        'order_id' => 4,
        'product_id' => 2,
        'quantity' => 1,
        'unit_price' => 2150.00,
    ],
    [
        'id' => 5,
        'order_id' => 5,
        'product_id' => 3,
        'quantity' => 1,
        'unit_price' => 750.00,
    ],
    [
        'id' => 6,
        'order_id' => 6,
        'product_id' => 2,
        'quantity' => 1,
        'unit_price' => 2100.00,
    ],
    [
        'id' => 7,
        'order_id' => 7,
        'product_id' => 4,
        'quantity' => 1,
        'unit_price' => 500.00,
    ],
    [
        'id' => 8,
        'order_id' => 8,
        'product_id' => 1,
        'quantity' => 1,
        'unit_price' => 1450.00,
    ],
    [
        'id' => 9,
        'order_id' => 9,
        'product_id' => 3,
        'quantity' => 1,
        'unit_price' => 750.00,
    ],
    [
        'id' => 10,
        'order_id' => 10,
        'product_id' => 2,
        'quantity' => 1,
        'unit_price' => 2100.00,
    ],
    [
        'id' => 11,
        'order_id' => 11,
        'product_id' => 2,
        'quantity' => 1,
        'unit_price' => 2100.00,
    ],
    [
        'id' => 12,
        'order_id' => 12,
        'product_id' => 1,
        'quantity' => 1,
        'unit_price' => 1250.00,
    ],
    [
        'id' => 13,
        'order_id' => 13,
        'product_id' => 4,
        'quantity' => 1,
        'unit_price' => 500.00,
    ],
    [
        'id' => 14,
        'order_id' => 14,
        'product_id' => 1,
        'quantity' => 1,
        'unit_price' => 1450.00,
    ],
    [
        'id' => 15,
        'order_id' => 15,
        'product_id' => 3,
        'quantity' => 1,
        'unit_price' => 750.00,
    ],
    [
        'id' => 16,
        'order_id' => 16,
        'product_id' => 2,
        'quantity' => 1,
        'unit_price' => 2100.00,
    ],
    [
        'id' => 17,
        'order_id' => 17,
        'product_id' => 1,
        'quantity' => 1,
        'unit_price' => 1950.00,
    ],
    [
        'id' => 18,
        'order_id' => 18,
        'product_id' => 4,
        'quantity' => 1,
        'unit_price' => 500.00,
    ],
    [
        'id' => 19,
        'order_id' => 19,
        'product_id' => 1,
        'quantity' => 1,
        'unit_price' => 1450.00,
    ],
    [
        'id' => 20,
        'order_id' => 20,
        'product_id' => 3,
        'quantity' => 1,
        'unit_price' => 750.00,
    ],
    [
        'id' => 21,
        'order_id' => 21,
        'product_id' => 2,
        'quantity' => 1,
        'unit_price' => 2100.00,
    ],
    [
        'id' => 22,
        'order_id' => 22,
        'product_id' => 1,
        'quantity' => 1,
        'unit_price' => 1250.00,
    ],
    [
        'id' => 23,
        'order_id' => 23,
        'product_id' => 4,
        'quantity' => 1,
        'unit_price' => 500.00,
    ],
    [
        'id' => 24,
        'order_id' => 24,
        'product_id' => 2,
        'quantity' => 1,
        'unit_price' => 2850.00,
    ],
    [
        'id' => 25,
        'order_id' => 25,
        'product_id' => 3,
        'quantity' => 1,
        'unit_price' => 750.00,
    ],
    [
        'id' => 26,
        'order_id' => 26,
        'product_id' => 1,
        'quantity' => 1,
        'unit_price' => 1450.00,
    ],
    [
        'id' => 27,
        'order_id' => 27,
        'product_id' => 2,
        'quantity' => 1,
        'unit_price' => 2100.00,
    ],
    [
        'id' => 28,
        'order_id' => 28,
        'product_id' => 4,
        'quantity' => 1,
        'unit_price' => 500.00,
    ],
    [
        'id' => 29,
        'order_id' => 29,
        'product_id' => 1,
        'quantity' => 1,
        'unit_price' => 1950.00,
    ],
    [
        'id' => 30,
        'order_id' => 30,
        'product_id' => 3,
        'quantity' => 1,
        'unit_price' => 750.00,
    ],
]);
    }
}
