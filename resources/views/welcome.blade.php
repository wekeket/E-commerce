<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers & Payments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            background-color: #F8FAFC; 
            color: #1E293B; 
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar Navigation */
        .sidebar{
            background: linear-gradient(
                180deg,
                #213a8f 0%,
                #13235e 100%
            );
        }

        .active-menu{
            background:#23d18b;
        }

        .icon-box{
            width:32px;
            height:32px;
            border-radius:10px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:15px;
            flex-shrink:0;
        }

        /* Workspace Main Layout */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        .header-section {
            margin-bottom: 20px;
        }

        .header-section h1 {
            font-size: 28px;
            font-weight: 700;
            color: #0F172A; 
        }

        .btn-update {
            background-color: #10B981; 
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 24px;
        }

        /* Top Metrics Row Panel Grid Cards */
        .metrics-grid {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }
        
        /* ADDED: Made metric cards clickable elements with hover effect */
        .metric-card {
            flex: 1;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 20px;
            text-decoration: none; 
            color: inherit;
            display: block;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-color: #CBD5E1;
        }

        .metric-card p {
            font-size: 13px;
            color: #64748B;
            font-weight: 500;
            margin-bottom: 6px;
        }
        .metric-card h2 {
            font-size: 24px;
            font-weight: 700;
            color: #0F172A;
        }
        .badge {
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
            margin-left: 6px;
        }
        .bg-green-soft { background-color: #D1FAE5; color: #065F46; }
        .bg-orange-soft { background-color: #FFEDD5; color: #9A3412; }

        /* Search & Filter Component Line */
        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 12px;
        }
        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #E2E8F0;
            border-radius: 20px;
            font-size: 14px;
            background: #FFFFFF;
        }
        .filter-dropdowns {
            display: flex;
            gap: 8px;
        }
        .filter-select {
            padding: 12px 16px;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            font-size: 14px;
            background: #FFFFFF;
            color: #475569;
            cursor: pointer;
        }

        /* Two Column Panel Grid */
        .split-view {
            display: flex;
            gap: 24px;
        }

        .left-panel { flex: 2.3; }
        .right-panel { flex: 1; display: flex; flex-direction: column; gap: 24px; }

        .dashboard-box {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 24px;
        }

        .dashboard-box h3 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1E293B;
            font-weight: 700;
        }

        /* Data Ledger Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #1E3A8A; 
            color: #FFFFFF;
            padding: 14px;
            font-weight: 600;
        }

        th:first-child { border-top-left-radius: 8px; border-bottom-left-radius: 8px; }
        th:last-child { border-top-right-radius: 8px; border-bottom-right-radius: 8px; }

        td {
            padding: 16px 14px;
            border-bottom: 1px solid #E2E8F0;
            color: #334155;
        }

        /* Status Flags styling */
        .status-pill {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-verified { background-color: #D1FAE5; color: #065F46; }
        .status-pending { background-color: #FEF3C7; color: #D97706; }
        .status-error { background-color: #FEE2E2; color: #EF4444; }
        .status-neutral { background-color: #F1F5F9; color: #475569; }

        /* Actions links layout */
        .action-container {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .action-link {
            color: #3B82F6;
            text-decoration: none;
            font-weight: 600;
        }
        .action-link:hover { text-decoration: underline; }
        .action-link.err-color { color: #EF4444; }

        /* Dynamic Activity Log Feed Rows */
        .live-payment-block {
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 16px;
            background: #FFFFFF;
        }
        .live-payment-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-top: 12px;
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }
        .live-payment-row:hover { background-color: #F8FAFC; }
        
        .red-dot {
            width: 8px;
            height: 8px;
            background-color: #EF4444;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        /* Distribution Summary Breakdown Lines */
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            font-size: 14px;
            border-bottom: 1px solid #F1F5F9;
        }
        .summary-row:last-child { border: none; }
        .summary-row span { font-weight: 600; color: #1E293B; }
        .summary-row label { color: #475569; }

        /* Modal Overlays Layout */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(30, 41, 59, 0.6); 
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s ease-in-out;
            z-index: 1000;
        }

        .modal-overlay:target { opacity: 1; pointer-events: auto; }
        
        .modal-card { 
            background: #FFFFFF; 
            border-radius: 16px; 
            width: 620px; 
            padding: 28px; 
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-card h3 { 
            font-size: 22px; 
            font-weight: 700;
            color: #1E293B; 
            margin-bottom: 2px;
        }

        /* Tabs styling from Figma view */
        .modal-tabs {
            display: flex;
            gap: 20px;
            border-bottom: 1px solid #E2E8F0;
            margin-top: 14px;
            margin-bottom: 16px;
        }
        .modal-tab {
            padding-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #64748B;
            text-decoration: none;
            border-bottom: 2px solid transparent;
        }
        .modal-tab.active {
            color: #1E3A8A;
            border-bottom-color: #1E3A8A;
        }
        .modal-tab:hover:not(.active) {
            color: #1E293B;
            border-bottom-color: #CBD5E1;
        }

        /* Restored CRM Data Grid Blocks layout from 1000045478.jpg */
        .crm-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 18px;
        }

        .crm-data-card {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 14px;
        }

        .crm-data-card label {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            color: #64748B;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .crm-data-card p {
            font-size: 15px;
            font-weight: 600;
            color: #1E293B;
        }
        
        /* Modal Table Styling matched to Platform History Grid */
        .modal-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .modal-table th {
            background-color: #1E3A8A;
            color: white;
            padding: 10px 12px;
            font-size: 13px;
            font-weight: 600;
        }
        .modal-table td {
            padding: 12px;
            border-bottom: 1px solid #E2E8F0;
            font-size: 13px;
            color: #334155;
        }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .form-group select { width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; background: white; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; }
        
        .modal-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 20px; }
        .btn-close { background-color: #1E293B; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px;}
        .btn-submit { background-color: #EF4444; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px;}
    </style>
</head>
<body>

    <!-- SIDEBAR NAVIGATION PANEL -->
    <aside class="sidebar w-64 text-white flex flex-col p-6">

        <div class="flex items-center gap-2 mb-8">
            <div
                class="w-9 h-9 rounded-full border-2 border-emerald-400 flex items-center justify-center text-emerald-400 font-bold text-lg">
                G
            </div>

            <div class="font-extrabold text-xl tracking-wide">
                OG TECH
            </div>
        </div>

        <div class="mb-8">
            <input
                type="text"
                placeholder="Search"
                class="w-full rounded-full bg-white/10 border border-white/20 placeholder-gray-300 text-white text-sm px-4 py-2 focus:outline-none focus:bg-white/20">
        </div>

        <h3 class="text-xs font-bold text-emerald-400 tracking-widest uppercase mb-4">
            Main Menu
        </h3>

        <nav class="space-y-2">

            <a href="{{ route('dashboard') }}"
               class="menu-item flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">
                <span class="icon-box bg-white/20">🔲</span>
                Dashboard
            </a>

            <a href="{{ route('inventory.index') }}"
               class="menu-item flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">
                <span class="icon-box bg-blue-400/20">📦</span>
                Inventory
            </a>

            <a href="{{ route('orders.index') }}"
               class="menu-item flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">
                <span class="icon-box bg-orange-400/20">🛒</span>
                Orders
            </a>

            <a href="{{ route('products.index') }}"
               class="menu-item flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">
                <span class="icon-box bg-yellow-400/20">🏷️</span>
                Products
            </a>

            <a href="{{ route('customers.index') }}"
               class="menu-item active-menu flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold">
                <span class="icon-box bg-slate-400/20">💳</span>
                Customers &amp; Payments
            </a>

            <a href="{{ route('reports') }}"
               class="menu-item flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">
                <span class="icon-box bg-emerald-400/20">📊</span>
                Reports
            </a>

            <a href="#"
               class="menu-item flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">
                <span class="icon-box bg-slate-400/20">⚙️</span>
                Settings
            </a>

        </nav>

    </aside>

    <!-- MAIN DASHBOARD CONTENT CONTROL PANEL -->
    <div class="main-content">
        
        <div class="header-section">
            <h1>Customers & Payments</h1>
        </div>

        <a href="#modal-refresh-complete" class="btn-update">Refresh List</a>

        <!-- TOP CARD METRICS ROW PANEL GRID (NOW CLICKABLE LINKS TO MODALS) -->
        <div class="metrics-grid">
            <a href="#modal-total-customers" class="metric-card">
                <p>Total Customers</p>
                <h2>{{ number_format($totalCustomers) }}</h2>
            </a>
            <a href="#modal-profiles-synced" class="metric-card">
                <p>Profiles Synced</p>
                <h2>{{ number_format($profilesSynced) }}</h2>
            </a>
            <a href="#modal-todays-sales" class="metric-card">
                <p>Today's Sales</p>
                <h2>₱{{ number_format($todaysSales, 2) }}</h2>
            </a>
            <a href="#modal-payment-alerts" class="metric-card">
                <p>Payment Alerts</p>
                <h2>{{ $paymentAlerts }} @if($paymentAlerts > 0)<span class="badge bg-orange-soft">Fix Req.</span>@endif</h2>
            </a>
        </div>

        <!-- Sorting and Filtering Component Inputs Line Bar -->
        <div class="table-controls">
            <input type="text" class="search-input" placeholder="Search customer name, email, or transaction ID...">
            <div class="filter-dropdowns">
                <select class="filter-select"><option>All Status</option></select>
                <select class="filter-select"><option>All Stores</option></select>
            </div>
        </div>

        <!-- Main Split Workspace Layout -->
        <div class="split-view">
            
            <!-- Left Data Panel Side -->
            <div class="left-panel">
                <div class="dashboard-box">
                    <h3 style="font-size:16px; color:#475569; font-weight:600; margin-bottom:16px;">Customer Status</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Store</th>
                                <th>Transaction ID</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $txn)
                            <tr>
                                <td>{{ $txn->customer_name ?? 'No customer linked' }}</td>
                                <td>{{ $txn->store }}</td>
                                <td style="font-family: monospace;">{{ $txn->transaction_id }}</td>
                                <td>{{ $txn->payment_method }}</td>
                                <td>₱{{ number_format($txn->amount, 2) }}</td>
                                <td>
                                    @if($txn->status === 'Verified')
                                        <span class="status-pill status-verified">Verified</span>
                                    @elseif($txn->status === 'Pending')
                                        <span class="status-pill status-pending">Pending</span>
                                    @else
                                        <span class="status-pill status-error">Error</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-container">
                                        @if($txn->status === 'Error')
                                            <a href="#fix-txn-{{ $txn->id }}" class="action-link err-color">Fix</a>
                                        @elseif($txn->status === 'Pending')
                                            <a href="#customer-summary-{{ $txn->id }}" class="action-link">Review</a>
                                        @else
                                            <a href="#customer-summary-{{ $txn->id }}" class="action-link">View</a>
                                        @endif
                                        <a href="#edit-profile-{{ $txn->id }}" class="action-link" style="color:#64748B;">Edit</a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding: 24px; color:#94A3B8;">No transactions found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Feed Monitoring Sideboards -->
            <div class="right-panel">
                
                <div class="live-payment-block">
                    <h3 style="font-size:16px; font-weight:700; margin-bottom:2px;"><span class="red-dot"></span>Live Sales Feed</h3>
                    @if($liveSale)
                    <a href="#customer-summary-{{ $liveSale->id }}" class="live-payment-row">
                        <div>
                            <strong style="font-size:16px; color:#1E293B;">₱{{ number_format($liveSale->amount, 2) }}</strong>
                            <p style="font-size:13px; color:#64748B; margin-top:4px;">{{ $liveSale->customer_email ?? 'No email on file' }}</p>
                            <p style="font-size:13px; color:#64748B; margin-top:1px;">• {{ $liveSale->payment_method }}</p>
                        </div>
                        @if($liveSale->status === 'Verified')
                            <span class="status-pill status-verified" style="font-size:11px; padding:2px 8px; border-radius:4px;">Verified</span>
                        @elseif($liveSale->status === 'Pending')
                            <span class="status-pill status-pending" style="font-size:11px; padding:2px 8px; border-radius:4px;">Pending</span>
                        @else
                            <span class="status-pill status-error" style="font-size:11px; padding:2px 8px; border-radius:4px;">Error</span>
                        @endif
                    </a>
                    @else
                    <p style="font-size:13px; color:#94A3B8; padding: 12px 0;">No transactions yet.</p>
                    @endif
                </div>

                <div class="dashboard-box">
                    <h3 style="font-size:16px; margin-bottom:14px;">Sales Breakdown Today</h3>
                    <div class="summary-row">
                        <label>📱 GCash Total</label>
                        <span>₱{{ number_format($salesBreakdown['Gcash'] ?? 0, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <label>💳 Maya Total</label>
                        <span>₱{{ number_format($salesBreakdown['Maya'] ?? 0, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <label>🏦 Card Payments</label>
                        <span>₱{{ number_format($salesBreakdown['Card'] ?? 0, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <label>📦 Cash on Delivery</label>
                        <span>₱{{ number_format($salesBreakdown['COD'] ?? 0, 2) }}</span>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- ==========================================================================
           RESTORED EXACT MODALS COMPONENT VIEW FROM FIGMA (1000045478.jpg)
           ========================================================================== -->

    <!-- REAL PER-TRANSACTION CUSTOMER SUMMARY MODALS -->
    @foreach($transactions as $txn)
    <div id="customer-summary-{{ $txn->id }}" class="modal-overlay">
        <div class="modal-card">
            <h3>Customer File Summary</h3>
            <p style="font-size: 14px; color: #64748B;">{{ $txn->transaction_id }} &middot; {{ $txn->store }}</p>

            <!-- Quadrant Metric Parameter Panels -->
            <div class="crm-meta-grid">
                <div class="crm-data-card">
                    <label>Customer</label>
                    <p>{{ $txn->customer_name ?? 'No customer linked' }}</p>
                </div>
                <div class="crm-data-card">
                    <label>Email</label>
                    <p>{{ $txn->customer_email ?? '—' }}</p>
                </div>
                <div class="crm-data-card">
                    <label>Payment Method (this transaction)</label>
                    <p>{{ $txn->payment_method }}</p>
                </div>
                <div class="crm-data-card">
                    <label>Total Logged Orders</label>
                    @php $orderCount = ($recentOrdersByCustomer[$txn->customer_id] ?? collect())->count(); @endphp
                    <p>{{ $orderCount }} {{ Str::plural('Purchase', $orderCount) }}</p>
                </div>
            </div>

            <!-- Real order history for the linked customer, if any -->
            <h4 style="font-size: 14px; color: #1E293B; font-weight: 700; margin-bottom: 8px;">Recent Order History</h4>
            <table class="modal-table">
                <thead>
                    <tr>
                        <th style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($recentOrdersByCustomer[$txn->customer_id] ?? collect())->take(5) as $order)
                    <tr>
                        <td style="font-family: monospace; font-weight:600;">{{ $order->order_code }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('M j, Y') }}</td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="status-pill {{ $order->status === 'Cancelled' ? 'status-error' : ($order->status === 'Pending' ? 'status-pending' : 'status-verified') }}">
                                {{ $order->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center; color:#94A3B8; padding: 16px;">
                            {{ $txn->customer_id ? 'No orders found for this customer.' : 'This transaction has no linked customer profile yet.' }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="modal-actions">
                <a href="#" class="btn-close" style="border-radius: 8px; font-weight:600; padding:12px 24px;">Close Profile</a>
            </div>
        </div>
    </div>
    @endforeach

    <!-- ==========================================================================
           NEW TOP 4 METRICS CARDS MODAL FRAMES
           ========================================================================== -->

    <!-- Total Customers Modal -->
    <div id="modal-total-customers" class="modal-overlay">
        <div class="modal-card">
            <h3>Total Customers Analytics</h3>
            <p style="font-size: 14px; color: #64748B; margin-bottom: 20px;">Detailed view of your 4,219 registered users.</p>
            
            <div class="crm-meta-grid" style="grid-template-columns: 1fr 1fr 1fr;">
                <div class="crm-data-card">
                    <label>New This Month</label>
                    <p style="color:#10B981;">+210 Users</p>
                </div>
                <div class="crm-data-card">
                    <label>Active Rate</label>
                    <p>84%</p>
                </div>
                <div class="crm-data-card">
                    <label>Top Platform</label>
                    <p>Shopify</p>
                </div>
            </div>

            <table class="modal-table">
                <thead>
                    <tr>
                        <th style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">Recent Signups</th>
                        <th>Email</th>
                        <th style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Mike Enriquez</td><td>mike@email.com</td><td>Today, 10:45 AM</td></tr>
                    <tr><td>Sarah Geronimo</td><td>sarah.g@email.com</td><td>Today, 09:12 AM</td></tr>
                </tbody>
            </table>
            <div class="modal-actions"><a href="#" class="btn-close">Close</a></div>
        </div>
    </div>

    <!-- Profiles Synced Modal -->
    <div id="modal-profiles-synced" class="modal-overlay">
        <div class="modal-card">
            <h3>Database Synchronization Log</h3>
            <p style="font-size: 14px; color: #64748B; margin-bottom: 20px;">Connection status for external CRM and Store profiles.</p>
            
            <div class="live-payment-block" style="margin-bottom: 16px;">
                <div class="summary-row" style="padding-top:0;">
                    <label>Last Full Sync</label>
                    <span>Today, 12:00 PM</span>
                </div>
                <div class="summary-row">
                    <label>Total Synced Profiles</label>
                    <span style="color:#10B981;">4,215 / 4,219 (99.9%)</span>
                </div>
                <div class="summary-row">
                    <label>Orphaned Profiles (No Store ID)</label>
                    <span style="color:#D97706;">4 Requires Mapping</span>
                </div>
            </div>

            <div class="modal-actions">
                <a href="#" class="btn-submit" style="background:#3B82F6;">Force Re-Sync Now</a>
                <a href="#" class="btn-close">Close</a>
            </div>
        </div>
    </div>

    <!-- Today's Sales Modal -->
    <div id="modal-todays-sales" class="modal-overlay">
        <div class="modal-card">
            <h3>Sales Performance Today</h3>
            <p style="font-size: 14px; color: #64748B; margin-bottom: 20px;">Gross revenue generation across all platforms.</p>

            <h2 style="font-size: 32px; font-weight: 700; color: #0F172A; text-align: center; margin-bottom: 20px;">
                ₱142,500.00
            </h2>
            
            <table class="modal-table">
                <thead>
                    <tr>
                        <th style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">Store Node</th>
                        <th>Transactions</th>
                        <th style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;">Volume Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Shopify</td><td>45</td><td>₱65,000.00</td></tr>
                    <tr><td>WooCommerce</td><td>32</td><td>₱38,500.00</td></tr>
                    <tr><td>TikTok Shop</td><td>28</td><td>₱22,000.00</td></tr>
                    <tr><td>Lazada</td><td>15</td><td>₱17,000.00</td></tr>
                </tbody>
            </table>
            <div class="modal-actions"><a href="#" class="btn-close">Close</a></div>
        </div>
    </div>

    <!-- Payment Alerts Modal -->
    <div id="modal-payment-alerts" class="modal-overlay">
        <div class="modal-card">
            <h3 style="color:#EF4444;">System Payment Alerts</h3>
            <p style="font-size: 14px; color: #64748B; margin-bottom: 20px;">Transactions requiring immediate administrator intervention.</p>
            
            <table class="modal-table">
                <thead>
                    <tr>
                        <th style="background:#EF4444; border-top-left-radius: 6px; border-bottom-left-radius: 6px;">Ref ID</th>
                        <th style="background:#EF4444;">Issue Type</th>
                        <th style="background:#EF4444;">Amount</th>
                        <th style="background:#EF4444; border-top-right-radius: 6px; border-bottom-right-radius: 6px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $alertTxn9021 = $transactions->firstWhere('transaction_id', 'TXN-9021');
                        $alertTxn6310 = $transactions->firstWhere('transaction_id', 'TXN-6310');
                    @endphp
                    <tr>
                        <td style="font-family: monospace;">TXN-9021</td>
                        <td>API Variance Logged</td>
                        <td>₱4,600.00</td>
                        <td><a href="{{ $alertTxn9021 ? '#fix-txn-' . $alertTxn9021->id : '#' }}" class="action-link err-color">Fix Now</a></td>
                    </tr>
                    <tr>
                        <td style="font-family: monospace;">TXN-6310</td>
                        <td>Hash Collision</td>
                        <td>₱755.00</td>
                        <td><a href="{{ $alertTxn6310 ? '#fix-txn-' . $alertTxn6310->id : '#' }}" class="action-link err-color">Fix Now</a></td>
                    </tr>
                    <tr>
                        <td style="font-family: monospace;">TXN-9912</td>
                        <td>Stripe Gateway Timeout</td>
                        <td>₱5,000.00</td>
                        <td><a href="#" class="action-link err-color">Fix Now</a></td>
                    </tr>
                </tbody>
            </table>
            <div class="modal-actions"><a href="#" class="btn-close">Close Alert Center</a></div>
        </div>
    </div>


    <!-- ==========================================================================
           EXISTING FIX/EDIT/REFRESH MODALS
           ========================================================================== -->

    <!-- RESOLVE PAYMENT MISMATCH — one real modal per Error transaction -->
    @foreach($transactions->where('status', 'Error') as $txn)
    <div id="fix-txn-{{ $txn->id }}" class="modal-overlay">
        <div class="modal-card" style="border-top: 5px solid #EF4444;">
            <h3 style="color:#EF4444; font-size:20px;">Resolve Payment Mismatch ({{ $txn->transaction_id }})</h3>

            <div class="crm-meta-grid" style="margin-top:14px; margin-bottom:14px;">
                <div class="crm-data-card"><label>Flagged Customer</label><p>{{ $txn->customer_email ?? 'No customer linked' }}</p></div>
                <div class="crm-data-card"><label>Store / Method</label><p>{{ $txn->store }} &middot; {{ $txn->payment_method }}</p></div>
            </div>

            <form action="{{ route('transactions.resolve', $txn->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Admin Action</label>
                    <select name="resolution_action" required>
                        <option value="bypass">Force-Bypass Inconsistency (Mark Verified)</option>
                        <option value="reject">Reject Token & Issue Void / Refund (Mark Pending)</option>
                        <option value="refetch" disabled>Re-fetch Webhook Payload (not connected to a real gateway yet)</option>
                    </select>
                </div>

                <div class="modal-actions">
                    <a href="#" class="btn-close" style="background:#94A3B8;">Cancel</a>
                    <button type="submit" class="btn-submit" style="border:none; cursor:pointer;">Apply Fix</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach


    <!-- PER-TRANSACTION EDIT MODALS -->
    @foreach($transactions as $txn)
    <div id="edit-profile-{{ $txn->id }}" class="modal-overlay">
        <div class="modal-card">
            <h3>Edit Transaction — {{ $txn->transaction_id }}</h3>
            <form action="{{ route('transactions.update', $txn->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group" style="margin-top:10px;">
                    <label>Store</label>
                    <input type="text" name="store" value="{{ $txn->store }}" required>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label>Payment Method</label>
                    <input type="text" name="payment_method" value="{{ $txn->payment_method }}" required>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label>Amount</label>
                    <input type="number" step="0.01" name="amount" value="{{ $txn->amount }}" required>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="Verified" {{ $txn->status === 'Verified' ? 'selected' : '' }}>Verified</option>
                        <option value="Pending" {{ $txn->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Error" {{ $txn->status === 'Error' ? 'selected' : '' }}>Error</option>
                    </select>
                </div>

                <div class="modal-actions">
                    <a href="#" class="btn-close" style="background:#94A3B8;">Cancel</a>
                    <button type="submit" class="btn-close" style="background:#3B82F6; border:none; cursor:pointer;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <!-- REFRESH STATUS MESSAGE MODAL -->
    <div id="modal-refresh-complete" class="modal-overlay">
        <div class="modal-card" style="text-align: center; width:400px;">
            <h3 style="color:#10B981; margin-bottom:10px;">System Synced</h3>
            <p style="font-size:14px; color:#64748B;">All incoming external payment ledger buffers are completely up to date.</p>
            <div class="modal-actions" style="justify-content:center; margin-top:16px;"><a href="#" class="btn-close" style="background:#10B981;">OK</a></div>
        </div>
    </div>

</body>
</html>