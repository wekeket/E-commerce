<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Show the products list on the "Customers & Payments" page.
     */
    public function customerDashboard()
    {
        $totalCustomers = DB::table('customers')->count();

        $transactions = DB::table('orders')
            ->leftJoin(
                'customers',
                'orders.customer_id',
                '=',
                'customers.id'
            )
            ->leftJoin(
                'customer_transactions',
                'customer_transactions.order_id',
                '=',
                'orders.id'
            )
            ->select(
                'orders.id as order_id',
                'orders.order_code',
                'orders.order_date',
                'orders.total_amount',
                'orders.payment_method as order_payment_method',
                'orders.status as order_status',
                'customer_transactions.id',
                'customer_transactions.customer_id',
                'customer_transactions.store',
                'customer_transactions.transaction_id',
                'customer_transactions.payment_method',
                'customer_transactions.amount',
                'customer_transactions.status',
                'customer_transactions.created_at',
                'customers.name as customer_name',
                'customers.email as customer_email'
            )
            ->orderByDesc('orders.order_date')
            ->get();

        $profilesSynced = DB::table('customer_transactions')->count();

        $todaysSales = DB::table('customer_transactions')
            ->whereDate('created_at', now())
            ->where('status', 'Verified')
            ->sum('amount');

        $paymentAlerts = $transactions
            ->where('status', 'Error')
            ->count();

        $salesBreakdown = DB::table('customer_transactions')
            ->whereDate('created_at', now())
            ->where('status', 'Verified')
            ->select(
                'payment_method',
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method');

        $customerIds = $transactions
            ->pluck('customer_id')
            ->filter()
            ->unique();

        $recentOrdersByCustomer = DB::table('orders')
            ->whereIn('customer_id', $customerIds)
            ->orderByDesc('order_date')
            ->get()
            ->groupBy('customer_id');

        $liveSale = DB::table('customer_transactions')
            ->leftJoin(
                'customers',
                'customer_transactions.customer_id',
                '=',
                'customers.id'
            )
            ->select(
                'customer_transactions.*',
                'customers.email as customer_email'
            )
            ->orderByDesc('customer_transactions.updated_at')
            ->orderByDesc('customer_transactions.created_at')
            ->orderByDesc('customer_transactions.id')
            ->first();

        return view('welcome', compact(
            'totalCustomers',
            'transactions',
            'profilesSynced',
            'todaysSales',
            'paymentAlerts',
            'salesBreakdown',
            'recentOrdersByCustomer',
            'liveSale'
        ));
    }


    /**
     * Update a customer transaction.
     */
    public function updateTransaction(Request $request, $id)
    {
        $validated = $request->validate([
            'store'          => ['required', 'string', 'max:50'],
            'payment_method' => ['required', 'string', 'max:30'],
            'amount'         => ['required', 'numeric', 'min:0'],
            'status'         => ['required', 'in:Verified,Pending,Error'],
        ]);

        DB::table('customer_transactions')
            ->where('id', $id)
            ->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Transaction updated.');
    }


    /**
     * Resolve a flagged transaction.
     */
    public function resolveTransaction(Request $request, $id)
    {
        $request->validate([
            'resolution_action' => [
                'required',
                'in:bypass,reject,refetch'
            ],
        ]);

        $newStatus = match ($request->resolution_action) {
            'bypass'  => 'Verified',
            'reject'  => 'Pending',
            'refetch' => null,
        };

        if ($newStatus) {
            DB::table('customer_transactions')
                ->where('id', $id)
                ->update([
                    'status' => $newStatus
                ]);

            return redirect()
                ->route('customers.index')
                ->with(
                    'success',
                    'Transaction resolved and marked as ' . $newStatus . '.'
                );
        }

        return redirect()
            ->route('customers.index')
            ->with(
                'success',
                'Re-fetch is not connected to a real payment gateway yet — no change made.'
            );
    }


    /**
     * Show the products page.
     */
    public function productsIndex(Request $request)
    {
        return view(
            'admin.ProdDashboard',
            $this->productListData($request)
        );
    }


    /**
     * Show the inventory page.
     */
    public function inventoryIndex(Request $request)
    {
        return view(
            'admin.index',
            $this->productListData($request)
        );
    }


    /**
     * Sync inventory.
     */
    public function syncInventory()
    {
        session([
            'last_sync' => now()
        ]);

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Inventory synced.');
    }


    /**
     * Build product statistics.
     */
    private function productListData(Request $request): array
    {
        /*
        |--------------------------------------------------------------------------
        | Get products
        |--------------------------------------------------------------------------
        */

        $query = Product::query();


        /*
        |--------------------------------------------------------------------------
        | Active / Inactive Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Get filtered products
        |--------------------------------------------------------------------------
        */

        $products = $query
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        // Statistics remain based on ALL products
        $allProducts = Product::all();


        $totalProducts = $allProducts->count();


        $inStock = $allProducts
            ->where('stock_quantity', '>', 10)
            ->count();


        $lowStock = $allProducts
            ->whereBetween(
                'stock_quantity',
                [1, 10]
            )
            ->count();


        $outOfStock = $allProducts
            ->where(
                'stock_quantity',
                0
            )
            ->count();


        return compact(
            'products',
            'totalProducts',
            'inStock',
            'lowStock',
            'outOfStock'
        );
    }


    /**
     * Show the Add Product form.
     */
    public function create()
    {
        return view('admin.Addproduct');
    }


    /**
     * Store a new product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'product_name' => [
                'required',
                'string',
                'max:150'
            ],

            'brand' => [
                'nullable',
                'string',
                'max:100'
            ],

            'category' => [
                'nullable',
                'string',
                'max:100'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'cost' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'stock_quantity' => [
                'nullable',
                'integer',
                'min:0'
            ],

            'status' => [
                'nullable',
                'in:active,inactive'
            ],

        ]);


        $product = Product::create([

            'sku' => 'SKU-' . strtoupper(
                Str::random(6)
            ),

            'product_name' => $validated['product_name'],

            'brand' => $validated['brand'] ?? null,

            'category' => $validated['category'] ?? null,

            'description' => $validated['description'] ?? null,

            'price' => $validated['price'] ?? 0,

            'cost' => $validated['cost'] ?? 0,

            'stock_quantity' => $validated['stock_quantity'] ?? 0,

            'status' => $request->input('save_mode') === 'draft'
                ? 'inactive'
                : ($validated['status'] ?? 'active'),

        ]);


        if (
            $request->wantsJson()
            || $request->ajax()
        ) {

            return response()->json([

                'success' => true,

                'product' => $product

            ]);

        }


        return redirect()
            ->route('inventory.index')
            ->with(
                'success',
                'Product saved successfully.'
            );
    }


    /**
     * Show the Edit Product form.
     */
    public function edit(Product $product)
    {
        $categories = DB::table('categories')
            ->orderBy('name')
            ->get();

        return view(
            'admin.edit-product',
            compact(
                'product',
                'categories'
            )
        );
    }


    /**
     * Update an existing product.
     */
    public function update(
        Request $request,
        Product $product
    ) {
        $validated = $request->validate([

            'product_name' => [
                'required',
                'string',
                'max:150'
            ],

            'brand' => [
                'nullable',
                'string',
                'max:100'
            ],

            'category' => [
                'nullable',
                'string',
                'max:100'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'cost' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'stock_quantity' => [
                'nullable',
                'integer',
                'min:0'
            ],

            'status' => [
                'required',
                'in:active,inactive'
            ],

        ]);


        $product->update([

            'product_name' => $validated['product_name'],

            'brand' => $validated['brand'] ?? null,

            'category' => $validated['category'] ?? null,

            'description' => $validated['description'] ?? null,

            'price' => $validated['price'] ?? 0,

            'cost' => $validated['cost'] ?? 0,

            'stock_quantity' => $validated['stock_quantity'] ?? 0,

            'status' => $validated['status'],

        ]);


        if (
            $request->wantsJson()
            || $request->ajax()
        ) {

            return response()->json([

                'success' => true,

                'product' => $product

            ]);

        }


        return redirect()
            ->route('inventory.index')
            ->with(
                'success',
                'Product updated successfully.'
            );
    }


    /**
     * Delete a product.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product deleted.'
            );
    }
}