<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Per-order item quantity, summed from order_items and joined in
        // (avoids a GROUP BY on every orders/customers column)
        $itemTotals = DB::table('order_items')
            ->select('order_id', DB::raw('SUM(quantity) as qty'))
            ->groupBy('order_id');

        $query = DB::table('orders')
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoinSub($itemTotals, 'item_totals', function ($join) {
                $join->on('orders.id', '=', 'item_totals.order_id');
            })
            ->select(
                'orders.id',
                'orders.order_code',
                'orders.order_date',
                'orders.total_amount',
                'orders.payment_method',
                'orders.status',
                'customers.name as customer_name',
                DB::raw('COALESCE(item_totals.qty, 0) as qty')
            );

        // 1. Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('orders.order_code', 'LIKE', '%' . $search . '%')
                  ->orWhere('customers.name', 'LIKE', '%' . $search . '%');
            });
        }

        // 2. Dynamic Timeframe Filter
        if ($request->filled('export_range') && $request->export_range != 'all') {
            $today = Carbon::parse('2026-07-13');

            if ($request->export_range == 'daily') {
                $query->whereDate('orders.order_date', $today);
            } elseif ($request->export_range == 'weekly') {
                $query->whereBetween('orders.order_date', [$today->copy()->subDays(7), $today]);
            } elseif ($request->export_range == 'monthly') {
                $query->whereMonth('orders.order_date', $today->month)
                    ->whereYear('orders.order_date', $today->year);
            }
        }

        // Clone the query HERE to calculate metrics BEFORE the status filter locks it down
        $metricQuery = clone $query;
        $totalOrders = $metricQuery->count();
        $pendingCount = (clone $metricQuery)->where('orders.status', 'Pending')->count();
        $shippedCount = (clone $metricQuery)->where('orders.status', 'Shipped')->count();
        $cancelledCount = (clone $metricQuery)->where('orders.status', 'Cancelled')->count();

        // 3. Status Filter (applied after metrics so the cards stay accurate)
        if ($request->filled('status')) {
            $query->where('orders.status', $request->status);
        }

        // Capture ALL filtered records safely for the JavaScript export pool
        $allFilteredOrders = (clone $query)->orderBy('orders.order_date', 'desc')->get();

        // Cleanly generate paginated results for display
        $orders = $query->orderBy('orders.order_date', 'desc')->paginate(15)->withQueryString();

        return view('ogtech.synced', compact('orders', 'allFilteredOrders', 'totalOrders', 'pendingCount', 'shippedCount', 'cancelledCount'));
    }

    public function show($order_code)
    {
        $decoded = urldecode($order_code);

        $order = DB::table('orders')
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->where('orders.order_code', $decoded)
            ->select('orders.*', 'customers.name as customer_name')
            ->firstOrFail();

        return view('show', compact('order'));
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'status' => 'required|in:Pending,Shipped,Cancelled',
        ]);

        DB::table('orders')
            ->whereIn('order_code', $request->order_ids)
            ->update(['status' => $request->status]);

        return redirect()->back()->with('success', count($request->order_ids) . ' orders updated successfully!');
    }

    public function sync()
    {
        return redirect()->route('orders.index')->with('success', 'Orders ledger synced successfully!');
    }
}
