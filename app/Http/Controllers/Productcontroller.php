<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Show the products list on the "Customers & Payments" page
     * (temporary placement per existing scope).
     */
    public function customerDashboard()
    {
        $totalCustomers = \Illuminate\Support\Facades\DB::table('customers')->count();

        // Source of truth is now `orders` (every order shows up here,
        // whether or not it has a matching payment transaction yet).
        $transactions = \Illuminate\Support\Facades\DB::table('orders')
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('customer_transactions', 'customer_transactions.order_id', '=', 'orders.id')
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

        $profilesSynced = \Illuminate\Support\Facades\DB::table('customer_transactions')->count();

        // Today's Sales — only Verified transactions count toward sales total
        $todaysSales = \Illuminate\Support\Facades\DB::table('customer_transactions')
            ->whereDate('created_at', now())
            ->where('status', 'Verified')
            ->sum('amount');

        $paymentAlerts = $transactions->where('status', 'Error')->count();

        // Sales Breakdown Today — totals per payment method, today only,
        // Verified transactions only (kept consistent with Today's Sales)
        $salesBreakdown = \Illuminate\Support\Facades\DB::table('customer_transactions')
            ->whereDate('created_at', now())
            ->where('status', 'Verified')
            ->select('payment_method', \Illuminate\Support\Facades\DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method');

        // Recent order history for every customer that has at least one
        // linked transaction, grouped by customer_id for quick lookup
        // in the per-row "View" modal.
        $customerIds = $transactions->pluck('customer_id')->filter()->unique();

        $recentOrdersByCustomer = \Illuminate\Support\Facades\DB::table('orders')
            ->whereIn('customer_id', $customerIds)
            ->orderByDesc('order_date')
            ->get()
            ->groupBy('customer_id');

        // Live Sales Feed — most recently touched transaction (edited or
        // created), joined with its customer's email for display.
        $liveSale = \Illuminate\Support\Facades\DB::table('customer_transactions')
            ->leftJoin('customers', 'customer_transactions.customer_id', '=', 'customers.id')
            ->select('customer_transactions.*', 'customers.email as customer_email')
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
     * Update a single customer transaction row (Customers & Payments
     * "Edit" modal).
     */
    public function updateTransaction(Request $request, $id)
    {
        $validated = $request->validate([
            'store'          => ['required', 'string', 'max:50'],
            'payment_method' => ['required', 'string', 'max:30'],
            'amount'         => ['required', 'numeric', 'min:0'],
            'status'         => ['required', 'in:Verified,Pending,Error'],
        ]);

        \Illuminate\Support\Facades\DB::table('customer_transactions')
            ->where('id', $id)
            ->update($validated);

        return redirect()->route('customers.index')->with('success', 'Transaction updated.');
    }

    /**
     * Apply an admin resolution action from the "Fix" modal on a
     * flagged (Error-status) transaction.
     */
    public function resolveTransaction(Request $request, $id)
    {
        $request->validate([
            'resolution_action' => ['required', 'in:bypass,reject,refetch'],
        ]);

        $newStatus = match ($request->resolution_action) {
            'bypass' => 'Verified',
            'reject' => 'Pending',
            'refetch' => null, // no-op, no real webhook system exists
        };

        if ($newStatus) {
            \Illuminate\Support\Facades\DB::table('customer_transactions')
                ->where('id', $id)
                ->update(['status' => $newStatus]);

            return redirect()->route('customers.index')->with('success', 'Transaction resolved and marked as ' . $newStatus . '.');
        }

        return redirect()->route('customers.index')->with('success', 'Re-fetch is not connected to a real payment gateway yet — no change made.');
    }

    /**
     * Show the products list on the dedicated Products page.
     */
    public function productsIndex()
    {
        return view('ogtech.ProdDashboard', $this->productListData());
    }

    /**
     * Show the Inventory page (bar/pie charts + full product table).
     */
    public function inventoryIndex()
    {
        return view('ogtech.index', $this->productListData());
    }

    /**
     * Handle the "Sync" button on the Inventory page. There's no real
     * external inventory source to sync against yet, so this just
     * records the sync timestamp for the "Last successful inventory
     * sync" card and confirms the products list is current.
     */
    public function syncInventory()
    {
        session(['last_sync' => now()]);

        return redirect()->route('inventory.index')->with('success', 'Inventory synced.');
    }

    /**
     * Build the stats + product list shared by both product-list views.
     */
    private function productListData(): array
    {
        $products = Product::latest()->get();

        $totalProducts = $products->count();

        // Assumption: "in stock" = more than 10 units, "low stock" = 1-10,
        // "out of stock" = 0. Adjust these thresholds if your business
        // rules differ.
        $inStock    = $products->where('stock_quantity', '>', 10)->count();
        $lowStock   = $products->whereBetween('stock_quantity', [1, 10])->count();
        $outOfStock = $products->where('stock_quantity', 0)->count();

        return compact('products', 'totalProducts', 'inStock', 'lowStock', 'outOfStock');
    }

    /**
     * Show the "Add New Product" form.
     */
    public function create()
    {
        return view('ogtech.Addproduct');
    }

    /**
     * Save a new product (from the Add New Product form,
     * triggered by the dashboard's "Add Product" quick action).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:150'],
            'price'          => ['nullable', 'numeric', 'min:0'],
            'cost'           => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'category_id'    => ['nullable', 'integer'],
            'status'         => ['nullable', 'string', 'max:50'],
        ]);

        // Store the uploaded image, if one was provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'sku'            => 'SKU-' . strtoupper(Str::random(6)),
            'name'           => $validated['name'],
            'category_id'    => $validated['category_id'] ?? null,
            'price'          => $validated['price'] ?? 0,
            'cost'           => $validated['cost'] ?? 0,
            'stock_quantity' => $validated['stock_quantity'] ?? 0,
            'status'         => $request->input('save_mode') === 'draft' ? 'inactive' : 'active',
            'image_url'      => $imagePath,
        ]);

        // AJAX request from the form's fetch() call
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'product' => $product]);
        }

        return redirect()->route('dashboard')->with('status', 'Product saved.');
    }

    /**
     * Show the edit form for an existing product.
     */
    public function edit(Product $product)
    {
        $categories = \Illuminate\Support\Facades\DB::table('categories')->orderBy('name')->get();

        return view('ogtech.edit-product', compact('product', 'categories'));
    }

    /**
     * Update an existing product (from the Edit form).
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:150'],
            'price'          => ['nullable', 'numeric', 'min:0'],
            'cost'           => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'category_id'    => ['nullable', 'integer'],
            'status'         => ['nullable', 'string', 'max:50'],
        ]);

        // Store a new image only if one was uploaded, otherwise keep the existing one
        $imagePath = $product->image_url;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'           => $validated['name'],
            'category_id'    => $validated['category_id'] ?? $product->category_id,
            'price'          => $validated['price'] ?? $product->price,
            'cost'           => $validated['cost'] ?? $product->cost,
            'stock_quantity' => $validated['stock_quantity'] ?? $product->stock_quantity,
            'status'         => $request->input('save_mode') === 'draft' ? 'inactive' : ($validated['status'] ?? $product->status),
            'image_url'      => $imagePath,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'product' => $product]);
        }

        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}