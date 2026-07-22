@extends('app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-sm border border-gray-100 mt-10">
    <!-- Back Button -->
    <a href="/orders/synced" class="text-xs font-semibold text-[#1e3d92] hover:underline flex items-center gap-1 mb-6">
        <i class="fas fa-arrow-left"></i> Back to Orders Table
    </a>

    <!-- Header Section -->
    <div class="flex justify-between items-start border-b border-gray-100 pb-5 mb-5">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Order #{{ $order->order_id }}</h1>
            <p class="text-xs text-gray-500 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
        </div>
        <div>
            <!-- Dynamic Status Badge -->
            @if($order->status === 'Shipped')
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#00c49f] border border-emerald-100">Shipped</span>
            @elseif($order->status === 'Cancelled')
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-[#ff4d4d] border border-red-100">Cancelled</span>
            @else
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-[#fca311] border border-amber-100">Pending</span>
            @endif
        </div>
    </div>

    <!-- Details Grid Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Customer Info Box -->
        <div class="p-4 bg-slate-50/50 rounded-lg border border-gray-100">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Customer Details</h3>
            <p class="text-sm font-semibold text-gray-800">{{ $order->customer }}</p>
            <p class="text-xs text-gray-500 mt-1">Payment Method: <span class="font-medium text-gray-700">{{ $order->method }}</span></p>
        </div>

        <!-- Fulfillment Calculations Box -->
        <div class="p-4 bg-slate-50/50 rounded-lg border border-gray-100">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Order Summary</h3>
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Items Ordered:</span>
                <span class="font-bold text-gray-800">{{ $order->qty }} units</span>
            </div>
            <div class="flex justify-between text-base font-bold text-gray-900 border-t border-dashed border-gray-200 pt-2 mt-2">
                <span>Total Amount:</span>
                <span>₱{{ number_format($order->amount, 2) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection