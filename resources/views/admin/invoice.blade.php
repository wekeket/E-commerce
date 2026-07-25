<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; padding: 0 !important; }
            .print-card { box-shadow: none !important; border: none !important; padding: 0 !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-4 sm:p-10 text-gray-800">

    <!-- Top Action Toolbar -->
    <div class="max-w-3xl mx-auto mb-6 flex justify-between items-center no-print">
        <a href="{{ route('orders.index') }}" class="text-xs font-semibold text-[#1e3d92] hover:underline flex items-center gap-1">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
        <button onclick="window.print()" class="bg-[#1e3d92] text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-[#162d6d] transition-all flex items-center gap-2 cursor-pointer shadow-sm">
            <i class="fas fa-print"></i> Print / Save as PDF
        </button>
    </div>

    <!-- Printable Invoice Card -->
    <div class="max-w-3xl mx-auto bg-white p-8 sm:p-12 rounded-xl shadow-sm border border-gray-200 print-card">
        
        <!-- Invoice Header -->
        <div class="flex justify-between items-start border-b border-gray-200 pb-8 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-[#0a2973] uppercase tracking-wider">TAX INVOICE</h1>
                <p class="text-xs text-gray-500 mt-1">Invoice #: <span class="font-mono font-bold text-gray-800">INV-{{ $order->order_code }}</span></p>
                <p class="text-xs text-gray-500">Date: {{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-lg font-bold text-gray-900">E-Commerce ERP System</h2>
                <p class="text-xs text-gray-500">Order Management & Fulfillment</p>
                <p class="text-xs text-gray-500">Channel: <span class="font-semibold text-indigo-600">{{ $order->channel ?? 'Web Store' }}</span></p>
            </div>
        </div>

        <!-- Customer & Order Information -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Billed To</h3>
                <p class="text-sm font-bold text-gray-800">{{ $order->customer_name }}</p>
                <p class="text-xs text-gray-600 mt-1">Payment Method: 
                    <span class="font-semibold text-gray-800">{{ $order->payment_method ?? 'N/A' }}</span>
                </p>
            </div>
            <div class="text-right">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Order Details</h3>
                <p class="text-xs text-gray-600">Order Code: <span class="font-mono font-semibold text-gray-800">{{ $order->order_code }}</span></p>
                <p class="text-xs text-gray-600 mt-1">Status: 
                    <span class="font-semibold text-emerald-600">{{ $order->status }}</span>
                </p>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="border border-gray-200 rounded-lg overflow-hidden mb-8">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-gray-200 text-gray-600 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-3">Item Description</th>
                        <th class="p-3 text-center">Quantity</th>
                        <th class="p-3 text-right">Unit Price</th>
                        <th class="p-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700">
    @forelse ($orderItems as $item)
        <tr>
            <td class="p-3 font-semibold text-gray-900">
                {{ $item->product_name ?? 'Product Item' }}
            </td>
            <td class="p-3 text-center font-mono">
                {{ $item->quantity }}
            </td>
            <td class="p-3 text-right font-mono">
                ₱{{ number_format($item->unit_price, 2) }}
            </td>
            <td class="p-3 text-right font-mono font-bold text-gray-900">
                ₱{{ number_format($item->quantity * $item->unit_price, 2) }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="p-3 text-center text-gray-400">
                No items found for this order.
            </td>
        </tr>
    @endforelse
</tbody>
            </table>
        </div>

        <!-- Summary Totals -->
        <div class="flex justify-end">
            <div class="w-full sm:w-1/2 space-y-2 text-xs">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal:</span>
                    <span class="font-mono">₱{{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm font-bold text-gray-900 border-t border-gray-200 pt-2 mt-2">
                    <span>Grand Total:</span>
                    <span class="text-[#0a2973] font-mono">₱{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-100 pt-6 mt-12 text-center text-[11px] text-gray-400">
            <p>Generated automatically via E-Commerce Order Management Module.</p>
        </div>

    </div>

</body>
</html>