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
                ->select('products.name', DB::raw('SUM(order_items.quantity) as units_sold'))
                ->groupBy('products.id', 'products.name')
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
                ->select('products.name', DB::raw('SUM(order_items.quantity) as units_sold'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('units_sold')
                ->limit(4)
                ->get()
            : collect();

        return view('admin.reports', [
            'monthLabels'     => $monthLabels,
            'monthlyRevenue'  => $monthlyRevenue,
            'monthlyOrders'   => $monthlyOrders,
            'paymentLabels'   => $paymentLabels,
            'paymentValues'   => $paymentValues,
            'topProductNames' => $topProducts->pluck('name'),
            'topProductUnits' => $topProducts->pluck('units_sold'),
        ]);
    }
}