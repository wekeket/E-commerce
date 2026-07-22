@extends('app')

@section('content')
<div class="flex-1 p-6 overflow-y-auto bg-[#f8fafc]">
    <!-- View Structural Header -->
    <header class="mb-5 flex items-center gap-3">
        <h1 class="text-[28px] font-bold text-[#0a2973] tracking-tight">Order Management</h1>
    </header>

    <!-- Master Column Splitting Grid Framework (Wrapped around Metrics + Table) -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 items-start">
        
        <!-- Left Column Wrapper (Holds Metrics Cards and Orders Table together) -->
        <div class="lg:col-span-3 flex flex-col gap-5">
            
            <!-- Top Metrics Status Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-[#1e3d92] text-white p-4 rounded-xl shadow-sm flex flex-col justify-between min-h-[90px]">
                    <div class="flex justify-between items-center text-[10px] font-bold tracking-wider text-gray-300 uppercase">
                        <span>Total Orders</span>
                        <i class="fas fa-box text-xs opacity-80"></i>
                    </div>
                    <div class="text-2xl font-extrabold tracking-tight mt-1 text-center">{{ number_format($totalOrders) }}</div>
                </div>

                <div class="bg-[#1e3d92] text-white p-4 rounded-xl shadow-sm flex flex-col justify-between min-h-[90px]">
                    <div class="flex justify-between items-center text-[10px] font-bold tracking-wider text-gray-300 uppercase">
                        <span>Pending</span>
                        <i class="fas fa-exclamation-triangle text-xs opacity-80"></i>
                    </div>
                    <div class="text-2xl font-extrabold tracking-tight mt-1 text-center text-[#fca311]">{{ number_format($pendingCount) }}</div>
                </div>

                <div class="bg-[#1e3d92] text-white p-4 rounded-xl shadow-sm flex flex-col justify-between min-h-[90px]">
                    <div class="flex justify-between items-center text-[10px] font-bold tracking-wider text-gray-300 uppercase">
                        <span>Shipped</span>
                        <i class="fas fa-truck text-xs opacity-80"></i>
                    </div>
                    <div class="text-2xl font-extrabold tracking-tight mt-1 text-center text-[#00c49f]">{{ number_format($shippedCount) }}</div>
                </div>

                <div class="bg-[#1e3d92] text-white p-4 rounded-xl shadow-sm flex flex-col justify-between min-h-[90px]">
                    <div class="flex justify-between items-center text-[10px] font-bold tracking-wider text-gray-300 uppercase">
                        <span>Cancelled</span>
                        <i class="fas fa-exclamation-circle text-xs opacity-80"></i>
                    </div>
                    <div class="text-2xl font-extrabold tracking-tight mt-1 text-center text-[#ff4d4d]">{{ number_format($cancelledCount) }}</div>
                </div>
            </div>

            <!-- Orders Table Container Box -->
            <div class="w-full">
                <!-- Combined Toolbar Form with layout fix -->
                <form action="{{ url()->current() }}" method="GET" class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 mb-4 w-full">
                    <h2 class="text-lg font-bold text-gray-900 tracking-tight">Orders Table</h2>
                    
                    <div class="flex flex-wrap items-center gap-2 w-full xl:w-auto justify-end">
                        <!-- Search Bar -->
                        <div class="relative min-w-[240px] flex-1 sm:flex-none">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Order ID, customer..." class="w-full pl-8 pr-3 py-1.5 border border-gray-200 rounded-lg text-xs font-medium focus:outline-none focus:border-[#1e3d92] transition-colors" onchange="this.form.submit()" />
                        </div>

                        <!-- Timeframe Selector -->
                        <div class="relative">
                            <select name="export_range" onchange="this.form.submit()" class="appearance-none border border-gray-200 text-gray-700 pl-8 pr-8 py-1.5 rounded-lg text-xs font-semibold bg-white hover:bg-gray-50 transition-all focus:outline-none focus:border-[#1e3d92] cursor-pointer">
                                <option value="all" {{ request('export_range') == 'all' ? 'selected' : '' }}>Export All Records</option>
                                <option value="daily" {{ request('export_range') == 'daily' ? 'selected' : '' }}>Today's Orders</option>
                                <option value="weekly" {{ request('export_range') == 'weekly' ? 'selected' : '' }}>This Week's Orders</option>
                                <option value="monthly" {{ request('export_range') == 'monthly' ? 'selected' : '' }}>This Month's Orders</option>
                            </select>
                            <i class="fas fa-calendar-alt absolute left-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
                            <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[9px] text-gray-400 pointer-events-none"></i>
                        </div>

                        <!-- Action Buttons -->
                        <button type="button" onclick="executeProfessionalExport()" class="border border-gray-200 text-gray-700 px-3.5 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 bg-white hover:bg-gray-50 transition-all cursor-pointer">
                            <i id="export-icon" class="fas fa-download text-[10px] text-gray-400"></i> Export
                        </button>
                        <a href="/orders/synced/sync" class="bg-[#00c49f] text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 hover:bg-[#00b08f] transition-all whitespace-nowrap">
                           <i class="fas fa-sync-alt text-[10px]"></i> Sync Orders
                        </a>
                    </div>
                </form>   

                <!-- Bulk Selection Alert Strip -->
                <div id="bulk-actions-bar" class="hidden mb-3 p-2 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-between text-xs animate-fade-in">
                    <span class="text-gray-700 font-semibold pl-2"><i class="fas fa-info-circle text-[#1e3d92] mr-1"></i> <span id="selected-count">0</span> orders selected</span>
                    <div class="flex gap-2">
                        <button onclick="submitBulkAction('Shipped')" class="bg-white border border-gray-200 px-2.5 py-1 rounded text-gray-700 font-medium hover:bg-gray-50">Mark Shipped</button>
                        <button onclick="submitBulkAction('Cancelled')" class="bg-white border border-red-200 px-2.5 py-1 rounded text-red-600 font-medium hover:bg-red-50">Cancel Selected</button>
                    </div>
                </div>

                <!-- Table Frame -->
                <div class="overflow-x-auto rounded-xl border border-[#1e3d92] overflow-hidden">
                    <table class="w-full text-left text-[12px] border-collapse">
                        <thead class="bg-[#1e3d92] text-white text-xs tracking-wide">
                            <tr>
                                <th class="p-2.5 w-10 text-center"><input type="checkbox" id="select-all-orders" class="rounded border-gray-300 accent-[#1e3d92] cursor-pointer" onclick="toggleSelectAll(this)"></th>
                                <th class="p-2.5 font-semibold text-center w-24">Order ID</th>
                                <th class="p-2.5 font-semibold text-center w-20">Quantity</th>
                                <th class="p-3 font-semibold">Customer</th>
                                <th class="p-3 font-semibold">Date & Time</th>
                                <th class="p-3 font-semibold">Total Amount</th>
                                <th class="p-3 font-semibold">Payment Method</th>
                                <th class="p-2.5 font-semibold text-center w-28">Status</th>
                                <th class="p-2.5 font-semibold text-center w-16">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 font-medium bg-white">
                            @foreach ($orders as $order)
                            <tr class="border-b border-gray-200 last:border-b-0 hover:bg-slate-50/70 transition-colors">
                                <td class="p-2.5 text-center">
                                    <input type="checkbox" value="{{ $order->order_code }}" class="order-checkbox rounded border-gray-300 accent-[#1e3d92] cursor-pointer" onclick="updateBulkBarStatus()">
                                </td>
                                <td class="p-2.5 text-center text-gray-900 font-mono font-normal">
                                    <a href="/orders/{{ urlencode($order->order_code) }}" class="text-[#1e3d92] font-bold hover:underline inline-flex items-center gap-1">
                                        {{ $order->order_code }}
                                        <i class="fas fa-external-link-alt text-[9px] opacity-50"></i>
                                    </a>
                                </td>
                                <td class="p-2.5 text-center text-gray-900 font-bold">{{ $order->qty }}</td>
                                <td class="p-3 text-gray-900">{{ $order->customer_name }}</td>
                                <td class="p-3 text-gray-500">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, g:i A') }}</td>
                                <td class="p-3 font-bold text-gray-900">₱{{ number_format($order->total_amount, 2) }}</td>
                                <td class="p-3 text-gray-600">{{ $order->payment_method }}</td>
                                <td class="p-2.5 text-center">
                                    @if($order->status === 'Shipped')
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-[#00c49f] border border-emerald-100/50">Shipped</span>
                                    @elseif($order->status === 'Cancelled')
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-50 text-[#ff4d4d] border border-red-100/50">Cancelled</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-[#fca311] border border-amber-100/50">Pending</span>
                                    @endif
                                </td>
                                <td class="p-2.5 text-center relative">
                                    <div class="inline-block text-left dropdown">
                                        <button onclick="toggleDropdown(event, '{{ $order->order_code }}')" class="text-gray-400 hover:text-gray-600 p-1 focus:outline-none cursor-pointer">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div id="dropdown-{{ $order->order_code }}" class="hidden absolute right-0 mt-1 w-44 bg-white border border-gray-200 rounded-lg shadow-lg z-30 py-1 text-left">
                                            <button onclick="alert('Viewing Invoice for {{ $order->order_code }}')" class="w-full text-left px-3 py-2 text-xs text-gray-700 hover:bg-slate-50 flex items-center gap-2">
                                                <i class="fas fa-file-invoice text-gray-400 w-4"></i> View Invoice
                                            </button>
                                            <button onclick="alert('Printing Packing Slip for {{ $order->order_code }}')" class="w-full text-left px-3 py-2 text-xs text-gray-700 hover:bg-slate-50 flex items-center gap-2">
                                                <i class="fas fa-print text-gray-400 w-4"></i> Print Packing Slip
                                            </button>
                                            <div class="border-t border-gray-100 my-1"></div>
                                            <button onclick="alert('Raw Gateway Sync Payload:\n\n' + JSON.stringify({order_id: '{{ $order->order_code }}', source: 'E-Commerce API', status: '{{ $order->status }}', sync_state: 'Verified'}, null, 4))" class="w-full text-left px-3 py-2 text-xs text-gray-500 hover:bg-slate-50 flex items-center gap-2">
                                                <i class="fas fa-code text-gray-400 w-4"></i> View Sync Payload
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Container -->
                <div class="mt-4 py-3 bg-white flex justify-center">
                    {{ $orders->links('vendor.pagination.tailwind-blue') }}
                </div>

                <!-- Last Order Ledger Sync Badge -->
                <div class="mt-2 self-start inline-block border border-gray-300 bg-white px-4 py-1.5 rounded-lg text-[12px] text-gray-800 tracking-tight shadow-sm">
                    Last Order Ledger Sync : <span class="font-extrabold text-black">Today, {{ now()->timezone('Asia/Hong_Kong')->format('g:i A') }}</span>
                </div>
            </div>

        </div>

        <!-- Right Side Activities Stream -->
        <div class="lg:col-span-1 flex flex-col gap-4">
            <div class="bg-white rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.01)] border border-gray-200 flex flex-col divide-y divide-gray-100">
                <div class="p-4 text-center bg-slate-50/50 rounded-t-xl">
                    <h3 class="text-sm font-bold text-gray-900 tracking-tight">Recent Activity Log</h3>
                </div>
                
                <div class="p-4 flex flex-col gap-4 max-h-[450px] overflow-y-auto bg-white rounded-b-xl">
                    @foreach($orders->take(4) as $historyItem)
                    <div class="flex flex-col gap-1 text-[12px] border-b border-gray-100 pb-2 last:border-none">
                        <div class="flex justify-between items-center font-bold text-gray-900">
                            <span class="font-mono text-[#1e3d92]">{{ $historyItem->order_code }}</span>
                            <span class="text-[9px] uppercase tracking-wide px-1.5 py-0.5 rounded-md font-extrabold
                                {{ $historyItem->status === 'Shipped' ? 'bg-emerald-50 text-[#00c49f]' : '' }}
                                {{ $historyItem->status === 'Cancelled' ? 'bg-red-50 text-[#ff4d4d]' : '' }}
                                {{ $historyItem->status === 'Pending' ? 'bg-amber-50 text-[#fca311]' : '' }}">
                                {{ $historyItem->status }}
                            </span>
                        </div>
                        <p class="text-[11px] text-gray-600">
                            Customer <strong>{{ $historyItem->customer_name }}</strong> bought items totaling <strong>₱{{ number_format($historyItem->total_amount, 2) }}</strong>.
                        </p>
                        <span class="text-[9px] text-gray-400 font-bold">
                            Updated: {{ \Carbon\Carbon::parse($historyItem->order_date)->diffForHumans() }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Slide-Up Notification Toast Bar Element -->
<div id="export-toast" onclick="openMetadataLogPage()" class="fixed bottom-0 left-1/2 -translate-x-1/2 bg-[#0a2973] text-white px-16 py-3 text-xs font-bold rounded-t-xl tracking-wide text-center cursor-pointer opacity-0 translate-y-full transition-all duration-300 z-40 hover:bg-[#0b2b73] shadow-lg flex items-center gap-3">
    <i class="fas fa-file-csv text-emerald-400 text-sm"></i>
    <span>CSV Ledger Exported Successfully. Click to view raw rows.</span>
</div>

<!-- Metadata Log Overlay -->
<div id="metadata-overlay" class="fixed inset-0 bg-white z-50 hidden flex-col overflow-y-auto p-12">
    <button onclick="closeMetadataLogPage()" class="absolute top-6 right-10 text-4xl text-gray-900 hover:text-gray-600 font-light cursor-pointer leading-none">&times;</button>
    <div class="w-full max-w-7xl mx-auto flex flex-col gap-6">
        <div class="text-left">
            <!-- FIX 1: Updated Total Count calculation context targeting complete unpaginated pool -->
            <h2 class="text-[15px] font-extrabold text-gray-900 tracking-tight leading-relaxed uppercase">
                SYSTEM AUDIT TRAIL: Complete Order Modification History Ledger | Total Sync Pool: {{ $allFilteredOrders->count() }} Records
            </h2>
        </div>

        <div class="border border-gray-400/80 rounded-sm overflow-hidden">
            <table class="w-full text-left text-[12px] border-collapse bg-white">
                <thead class="bg-slate-100 border-b border-gray-400 text-gray-800 text-center font-bold">
                    <tr>
                        <th class="p-2.5 border-r border-gray-300 w-28">Order ID</th>
                        <th class="p-2.5 border-r border-gray-300 w-20">Quantity</th>
                        <th class="p-2.5 border-r border-gray-300">Customer</th>
                        <th class="p-2.5 border-r border-gray-300">Date & Time</th>
                        <th class="p-2.5 border-r border-gray-300">Total Amount</th>
                        <th class="p-2.5 border-r border-gray-300">Payment Method</th>
                        <th class="p-2.5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 text-gray-700 text-center font-medium">
                    <!-- Iterating the complete unpaginated list inside overlay grid -->
                    @foreach ($allFilteredOrders as $order)
                    <tr>
                        <td class="p-2.5 border-r border-gray-300 font-mono">{{ $order->order_code }}</td>
                        <td class="p-2.5 border-r border-gray-300">{{ $order->qty }}</td>
                        <td class="p-2.5 border-r border-gray-300 text-left pl-4">{{ $order->customer_name }}</td>
                        <td class="p-2.5 border-r border-gray-300 font-mono text-gray-500">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y g:i A') }}</td>
                        <td class="p-2.5 border-r border-gray-300 font-semibold">{{ number_format($order->total_amount, 2) }}</td>
                        <td class="p-2.5 border-r border-gray-300">{{ $order->payment_method }}</td>
                        <td class="p-2.5">{{ $order->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function submitBulkAction(status) {
    const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
    const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);

    if (selectedIds.length === 0) return;
    if (!confirm(`Are you sure you want to mark ${selectedIds.length} orders as ${status}?`)) return;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/orders/bulk-update';

    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);

    const statusInput = document.createElement('input');
    statusInput.type = 'hidden';
    statusInput.name = 'status';
    statusInput.value = status;
    form.appendChild(statusInput);

    selectedIds.forEach(id => {
        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'order_ids[]';
        idInput.value = id;
        form.appendChild(idInput);
    });

    document.body.appendChild(form);
    form.submit();
}

function toggleDropdown(event, orderId) {
    event.stopPropagation();
    const targetMenu = document.getElementById(`dropdown-${orderId}`);
    
    document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
        if (el.id !== `dropdown-${orderId}`) el.classList.add('hidden');
    });

    targetMenu.classList.toggle('hidden');
}

document.addEventListener('click', () => {
    document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));
});

function toggleSelectAll(masterCheckbox) {
    const checkboxes = document.querySelectorAll('.order-checkbox');
    checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
    updateBulkBarStatus();
}

function updateBulkBarStatus() {
    const checkboxes = document.querySelectorAll('.order-checkbox');
    const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
    const bulkBar = document.getElementById('bulk-actions-bar');
    const countSpan = document.getElementById('selected-count');
    const masterCb = document.getElementById('select-all-orders');

    if(masterCb) {
        masterCb.checked = checkedCount === checkboxes.length;
    }

    if (checkedCount > 0) {
        countSpan.textContent = checkedCount;
        bulkBar.classList.remove('hidden');
    } else {
        bulkBar.classList.add('hidden');
    }
}

function executeProfessionalExport() {
    const icon = document.getElementById('export-icon');
    icon.className = "fas fa-spinner animate-spin text-[10px] text-emerald-500";

    const baseRows = [
        ["Order ID", "Quantity", "Customer", "Date & Time", "Total Amount", "Payment Method", "Status"]
    ];
    
    // FIX 2: Target clean array structure passed from unpaginated collection context directly
    const records = @json($allFilteredOrders);

    records.forEach(o => {
        baseRows.push([
            o.order_code, 
            o.qty.toString(), 
            o.customer_name, 
            o.order_date, 
            o.total_amount.toString(), 
            o.payment_method, 
            o.status
        ]);
    });

    const csvContent = "data:text/csv;charset=utf-8," + baseRows.map(row => 
        row.map(field => `"${String(field || '').replace(/"/g, '""')}"`).join(",")
    ).join("\n");
    
    const encodedUri = encodeURI(csvContent);
    const downloadAnchor = document.createElement("a");
    downloadAnchor.setAttribute("href", encodedUri);
    downloadAnchor.setAttribute("download", "Filtered_Order_Export.csv");
    document.body.appendChild(downloadAnchor);

    setTimeout(() => {
        downloadAnchor.click();
        document.body.removeChild(downloadAnchor);
        icon.className = "fas fa-download text-[10px] text-gray-400";

        const toast = document.getElementById('export-toast');
        toast.classList.remove('opacity-0', 'translate-y-full');
        toast.classList.add('opacity-100', '-translate-y-2');
    }, 600);
}

function openMetadataLogPage() {
    document.getElementById('metadata-overlay').classList.replace('hidden', 'flex');
    document.body.classList.add('overflow-hidden');
}

// Ensure overlay list renders full unpaginated details context cleanly
function closeMetadataLogPage() {
    document.getElementById('metadata-overlay').classList.replace('flex', 'hidden');
    document.body.classList.remove('overflow-hidden');
}
</script>
@endpush