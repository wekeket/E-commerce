<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| OG TECH Web Routes
|--------------------------------------------------------------------------
| Dashboard + Reports are combined into a single Blade view
| (resources/views/ogtech/dashboard.blade.php) that switches
| sections client-side via JS. Sidebar buttons for Inventory,
| Products, Customers & Payments, and Settings are not wired up
| yet per scope — only Dashboard, Reports, and Orders are functional.
*/

// ---- Auth screens (Welcome Back / Create Account) ----

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---- Dashboard / Reports (protected) ----
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');

    // ---- Add Product ----
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // ---- Edit / Update / Delete Product ----
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // ---- Customers & Payments ----
    Route::get('/customers', [ProductController::class, 'customerDashboard'])->name('customers.index');
    Route::put('/customer-transactions/{id}', [ProductController::class, 'updateTransaction'])->name('transactions.update');
    Route::post('/customer-transactions/{id}/resolve', [ProductController::class, 'resolveTransaction'])->name('transactions.resolve');

    // ---- Products (dedicated page) ----
    Route::get('/products', [ProductController::class, 'productsIndex'])->name('products.index');

    // ---- Inventory ----
    Route::get('/inventory', [ProductController::class, 'inventoryIndex'])->name('inventory.index');
    Route::post('/sync', [ProductController::class, 'syncInventory'])->name('inventory.sync');

    // ---- Orders ----
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/synced/sync', [OrderController::class, 'sync'])->name('orders.sync');
    Route::post('/orders/bulk-update', [OrderController::class, 'bulkUpdate'])->name('orders.bulk-update');
    Route::get('/orders/{order_id}', [OrderController::class, 'show'])->name('orders.show');
});

// Root redirects straight to login
Route::get('/', function () {
    return redirect()->route('login');
});