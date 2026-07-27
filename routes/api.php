<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/orders', [apiController::class, 'apiOrder']);
Route::get('/products', [apiController::class, 'apiProducts']);
Route::get('/payments   ', [apiController::class, 'apiPayments']);
Route::get('/customers', [apiController::class, 'apiCustomer']);
Route::get('/getAllAPI', [apiController::class, 'apiGetAll']);