<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Active Products — safe to query now, `products` already exists
        $activeProducts = Product::where('status', 'active')->count();

        // The rest depend on tables that may not exist yet
        // (orders, customers, order_items). Guarded with Schema::hasTable
        // so the dashboard doesn't crash if you haven't imported them yet.
        $totalRevenue   = Schema::hasTable('orders') ? DB::table('orders')->sum('total_amount') : 0;
        $totalOrders    = Schema::hasTable('orders') ? DB::table('orders')->count() : 0;
        $totalCustomers = Schema::hasTable('customers') ? DB::table('customers')->count() : 0;

        $recentOrders = Schema::hasTable('orders') && Schema::hasTable('customers')
            ? DB::table('orders')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->select('orders.*', 'customers.name as customer_name')
                ->orderByDesc('orders.order_date')
                ->limit(10)
                ->get()
            : collect();

        $topProducts = Schema::hasTable('order_items')
            ? DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select('products.product_name', DB::raw('SUM(order_items.quantity) as units_sold'))
                ->groupBy('products.id', 'products.product_name')
                ->orderByDesc('units_sold')
                ->limit(4)
                ->get()
            : collect();

        $pendingOrders = Schema::hasTable('orders')
            ? DB::table('orders')->where('status', 'Pending')->count()
            : 0;

        return view('admin.MenuDashboard', compact(
            'activeProducts',
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'recentOrders',
            'topProducts',
            'pendingOrders'
        ));
    }

    /**
     * Reports page: monthly revenue/orders, payment method breakdown,
     * and top products — all queried live from the database.
     */
    public function reports()
    {
        // ---- Revenue Overview: last 6 months, revenue + order count ----
        $monthlyRaw = Schema::hasTable('orders')
            ? DB::table('orders')
                ->selectRaw("DATE_FORMAT(order_date, '%Y-%m') as ym, SUM(total_amount) as revenue, COUNT(*) as orders")
                ->where('order_date', '>=', now()->subMonths(5)->startOfMonth())
                ->groupBy('ym')
                ->get()
                ->keyBy('ym')
            : collect();

        $monthLabels = [];
        $monthlyRevenue = [];
        $monthlyOrders = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $key = $month->format('Y-m');

            $monthLabels[] = $month->format('M');
            $monthlyRevenue[] = (float) ($monthlyRaw[$key]->revenue ?? 0);
            $monthlyOrders[] = (int) ($monthlyRaw[$key]->orders ?? 0);
        }

        // ---- Mode of Payments: share of orders by payment method ----
        $paymentRows = Schema::hasTable('orders')
            ? DB::table('orders')
                ->select('payment_method', DB::raw('COUNT(*) as cnt'))
                ->groupBy('payment_method')
                ->orderByDesc('cnt')
                ->get()
            : collect();

        $paymentTotal = $paymentRows->sum('cnt');

        $paymentLabels = $paymentRows->pluck('payment_method');
        $paymentValues = $paymentTotal > 0
            ? $paymentRows->map(fn ($row) => round(($row->cnt / $paymentTotal) * 100, 1))
            : collect();

        // ---- Top Products: units sold, live from order_items ----
        $topProducts = Schema::hasTable('order_items')
            ? DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select('products.product_name', DB::raw('SUM(order_items.quantity) as units_sold'))
                ->groupBy('products.id', 'products.product_name')
                ->orderByDesc('units_sold')
                ->limit(4)
                ->get()
            : collect();

        // ---- Revenue by Store: total booked vs. verified, from customer_transactions ----
        $storeRevenue = Schema::hasTable('customer_transactions')
            ? DB::table('customer_transactions')
                ->select(
                    'store',
                    DB::raw('SUM(amount) as total_booked'),
                    DB::raw("SUM(CASE WHEN status = 'Verified' THEN amount ELSE 0 END) as verified_revenue")
                )
                ->groupBy('store')
                ->orderByDesc('total_booked')
                ->get()
            : collect();

        // ---- Operational: Order Status Breakdown ----
        $orderStatusRows = Schema::hasTable('orders')
            ? DB::table('orders')
                ->select('status', DB::raw('COUNT(*) as cnt'))
                ->groupBy('status')
                ->get()
            : collect();

        $orderStatusLabels = $orderStatusRows->pluck('status');
        $orderStatusValues = $orderStatusRows->pluck('cnt');

        // ---- Operational: Cancelled & Refunded Value ----
        $cancelledValue = Schema::hasTable('orders')
            ? DB::table('orders')->where('status', 'Cancelled')->sum('total_amount')
            : 0;

        $refundedValue = Schema::hasTable('payments')
            ? DB::table('payments')->where('status', 'Refunded')->sum('amount')
            : 0;

        // ---- Inventory: Low Stock Alert (threshold = 10 units) ----
        $lowStockThreshold = 10;

        $lowStockProducts = Schema::hasTable('products')
            ? DB::table('products')
                ->where('stock_quantity', '<', $lowStockThreshold)
                ->orderBy('stock_quantity')
                ->select('product_name', 'sku', 'category', 'stock_quantity')
                ->get()
            : collect();

        // ---- Inventory: Inventory Value by Category ----
        $inventoryValueRows = Schema::hasTable('products') && Schema::hasTable('categories')
            ? DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('categories.name as category_name', DB::raw('SUM(products.stock_quantity * products.cost) as inventory_value'))
                ->groupBy('categories.name')
                ->orderByDesc('inventory_value')
                ->get()
            : collect();

        $inventoryValueLabels = $inventoryValueRows->pluck('category_name');
        $inventoryValueAmounts = $inventoryValueRows->pluck('inventory_value');

        return view('admin.reports', [
            'monthLabels'          => $monthLabels,
            'monthlyRevenue'       => $monthlyRevenue,
            'monthlyOrders'        => $monthlyOrders,
            'paymentLabels'        => $paymentLabels,
            'paymentValues'        => $paymentValues,
            'topProductNames'      => $topProducts->pluck('product_name'),
            'topProductUnits'      => $topProducts->pluck('units_sold'),
            'storeLabels'          => $storeRevenue->pluck('store'),
            'storeTotalBooked'     => $storeRevenue->pluck('total_booked'),
            'storeVerifiedRevenue' => $storeRevenue->pluck('verified_revenue'),
            'orderStatusLabels'     => $orderStatusLabels,
            'orderStatusValues'     => $orderStatusValues,
            'cancelledValue'        => $cancelledValue,
            'refundedValue'         => $refundedValue,
            'lowStockProducts'      => $lowStockProducts,
            'lowStockThreshold'     => $lowStockThreshold,
            'inventoryValueLabels'  => $inventoryValueLabels,
            'inventoryValueAmounts' => $inventoryValueAmounts,
        ]);
    }
}