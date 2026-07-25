<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>OG TECH — Reports</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<style>
    :root{
        --navy:            #142666;
        --green:           #1BC49B;
        --panel-bg:        #eef0f5;
        --card-bg:         #ffffff;
        --text-dark:       #1c2340;
        --text-muted:      #7a8095;
        --border:          #e3e6ee;
    }
    *{ box-sizing:border-box; margin:0; padding:0; }
    body{
        font-family:'Poppins', sans-serif;
        background:var(--panel-bg);
        color:var(--text-dark);
        display:flex;
        min-height:100vh;
    }

    /* ---------- SIDEBAR ---------- */
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
    
    /* ---------- MAIN ---------- */
    .main{ flex:1; display:flex; flex-direction:column; min-width:0; }
    .topbar{
        display:flex;
        align-items:center;
        justify-content:flex-end;
        gap:16px;
        padding:16px 28px;
        background:#fff;
        border-bottom:1px solid var(--border);
    }
    .top-search{
        background:var(--panel-bg);
        border:1px solid var(--border);
        border-radius:16px;
        padding:7px 14px;
        font-size:12px;
        width:180px;
        color:var(--text-muted);
    }
    .icon-btn{
        background:none;border:none;font-size:16px;color:var(--text-muted);cursor:pointer;
    }
    .avatar{
        width:30px;height:30px;border-radius:50%;
        background:var(--navy);color:#fff;
        display:flex;align-items:center;justify-content:center;font-size:13px;
    }

    .content{ padding:26px 30px; flex:1; }
    .page-title{ font-size:22px; font-weight:700; color:var(--navy); margin-bottom:16px; }

    .report-panel{
        background:var(--card-bg);
        border:1px solid var(--border);
        border-radius:12px;
        padding:20px;
        max-width:640px;
    }
    .report-panel h3{ font-size:14px; font-weight:700; color:var(--navy); }
    .report-panel .sub{ font-size:11.5px; color:var(--text-muted); margin-bottom:14px; }

    .report-grid{
        display:grid;
        grid-template-columns:1fr 1fr 1fr;
        gap:18px;
        margin-top:18px;
    }
    .report-grid .report-panel{ max-width:none; }

    @media(max-width:1100px){
        .report-grid{ grid-template-columns:1fr 1fr; }
    }
    @media(max-width:650px){
        .report-grid{ grid-template-columns:1fr; }
    }
</style>
</head>
<body>

<!-- ================= SIDEBAR ================= -->
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
               class="menu-item flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold">
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
               class="menu-item flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">
                <span class="icon-box bg-slate-400/20">💳</span>
                Customers &amp; Payments
            </a>

            <a href="{{ route('reports') }}"
               class="menu-item active-menu flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">
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

<!-- ================= MAIN ================= -->
<div class="main">
    <div class="topbar">
        <input class="top-search" type="text" placeholder="Search">
        <button class="icon-btn">🔔</button>
        <button class="icon-btn">⚙️</button>
        <div class="avatar">👤</div>
    </div>

    <div class="content">
        <h1 class="page-title">Reports</h1>

        <div class="report-grid">
            <div class="report-panel">
                <h3>Revenue Overview</h3>
                <div class="sub">Monthly Revenue ({{ $monthLabels[0] }} – {{ end($monthLabels) }})</div>
                <canvas id="revenueChart" height="300"></canvas>
            </div>

            <div class="report-panel">
                <h3>Mode of Payments</h3>
                <div class="sub">Share of orders by payment method</div>
                <canvas id="paymentsChart" height="300"></canvas>
            </div>

            <div class="report-panel">
                <h3>Top Products</h3>
                <div class="sub">Units sold this month</div>
                <canvas id="topProductsChart" height="300"></canvas>
            </div>

            <div class="report-panel">
                <h3>Revenue by Store</h3>
                <div class="sub">Total booked vs. verified revenue (customer_transactions)</div>
                <canvas id="storeRevenueChart" height="300"></canvas>
            </div>

            <div class="report-panel">
                <h3>Order Status Breakdown</h3>
                <div class="sub">Distribution of orders by current status</div>
                <canvas id="orderStatusChart" height="300"></canvas>
            </div>

            <div class="report-panel">
                <h3>Cancelled &amp; Refunded Value</h3>
                <div class="sub">Revenue lost to cancellations and refunds</div>
                <div style="display:flex; gap:16px; margin-top:24px;">
                    <div style="flex:1; background:#fff5f5; border:1px solid #f5c2c2; border-radius:10px; padding:16px; text-align:center;">
                        <div style="font-size:11px; color:var(--text-muted); margin-bottom:6px;">Cancelled Orders</div>
                        <div style="font-size:22px; font-weight:700; color:#e05a5a;">₱{{ number_format($cancelledValue, 2) }}</div>
                    </div>
                    <div style="flex:1; background:#fff8ec; border:1px solid #f0dba8; border-radius:10px; padding:16px; text-align:center;">
                        <div style="font-size:11px; color:var(--text-muted); margin-bottom:6px;">Refunded Payments</div>
                        <div style="font-size:22px; font-weight:700; color:#d9a441;">₱{{ number_format($refundedValue, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="report-panel">
                <h3>Low Stock Alert</h3>
                <div class="sub">Products below {{ $lowStockThreshold }} units</div>
                <div style="max-height:260px; overflow-y:auto; margin-top:12px;">
                    <table style="width:100%; border-collapse:collapse; font-size:12px;">
                        <thead>
                            <tr style="text-align:left; color:var(--text-muted); border-bottom:1px solid var(--border);">
                                <th style="padding:6px 4px;">Product</th>
                                <th style="padding:6px 4px;">SKU</th>
                                <th style="padding:6px 4px; text-align:right;">Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProducts as $product)
                                <tr style="border-bottom:1px solid var(--border);">
                                    <td style="padding:6px 4px;">{{ $product->product_name }}</td>
                                    <td style="padding:6px 4px; color:var(--text-muted);">{{ $product->sku }}</td>
                                    <td style="padding:6px 4px; text-align:right; font-weight:600; color:#e05a5a;">{{ $product->stock_quantity }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" style="padding:12px 4px; color:var(--text-muted); text-align:center;">All stock levels healthy 🎉</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="report-panel">
                <h3>Inventory Value by Category</h3>
                <div class="sub">Stock quantity × cost, grouped by category</div>
                <canvas id="inventoryValueChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
/* Injected live from DashboardController@reports */
const revenueData = {
    labels: {!! json_encode($monthLabels) !!},
    revenue: {!! json_encode($monthlyRevenue) !!},
    orders:  {!! json_encode($monthlyOrders) !!}
};

const paymentsData = {
    labels: {!! json_encode($paymentLabels) !!},
    values: {!! json_encode($paymentValues) !!}
};

const topProductsData = {
    labels: {!! json_encode($topProductNames) !!},
    unitsSold: {!! json_encode($topProductUnits) !!}
};

/* Sourced from customer_transactions: total booked amount vs. amount with status = 'Verified', grouped by store */
const storeRevenueData = {
    labels: {!! json_encode($storeLabels) !!},
    totalBooked: {!! json_encode($storeTotalBooked) !!},
    verifiedRevenue: {!! json_encode($storeVerifiedRevenue) !!}
};

const orderStatusData = {
    labels: {!! json_encode($orderStatusLabels) !!},
    values: {!! json_encode($orderStatusValues) !!}
};

const inventoryValueData = {
    labels: {!! json_encode($inventoryValueLabels) !!},
    values: {!! json_encode($inventoryValueAmounts) !!}
};

const ctx = document.getElementById('revenueChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: revenueData.labels,
        datasets: [
            { label: 'Revenue', data: revenueData.revenue, backgroundColor: '#3aa0e8', borderRadius: 3, barThickness: 24 },
            { label: 'Orders',  data: revenueData.orders,  backgroundColor: '#1BC49B', borderRadius: 3, barThickness: 24 }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } },
        scales: {
            y: { grid: { color: '#eef0f5' }, ticks: { font: { size: 10 } } },
            x: { grid: { display: false }, ticks: { font: { size: 10 } } }
        }
    }
});

const paymentsCtx = document.getElementById('paymentsChart');
new Chart(paymentsCtx, {
    type: 'pie',
    data: {
        labels: paymentsData.labels,
        datasets: [{
            data: paymentsData.values,
            backgroundColor: ['#1BC49B', '#3aa0e8', '#eab54a', '#f16a6a', '#8b6be0'],
            borderColor: '#ffffff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10.5 }, padding: 12 } },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.label + ': ' + context.parsed + '%';
                    }
                }
            }
        }
    }
});

const topProductsCtx = document.getElementById('topProductsChart');
new Chart(topProductsCtx, {
    type: 'bar',
    data: {
        labels: topProductsData.labels,
        datasets: [{
            label: 'Units Sold',
            data: topProductsData.unitsSold,
            backgroundColor: '#1BC49B',
            borderRadius: 4,
            barThickness: 34
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: '#eef0f5' }, ticks: { font: { size: 10 } } },
            y: { grid: { display: false }, ticks: { font: { size: 10.5 } } }
        }
    }
});

const storeRevenueCtx = document.getElementById('storeRevenueChart');
new Chart(storeRevenueCtx, {
    type: 'bar',
    data: {
        labels: storeRevenueData.labels,
        datasets: [
            { label: 'Total Booked', data: storeRevenueData.totalBooked, backgroundColor: '#3aa0e8', borderRadius: 3, barThickness: 22 },
            { label: 'Verified Revenue', data: storeRevenueData.verifiedRevenue, backgroundColor: '#1BC49B', borderRadius: 3, barThickness: 22 }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } },
        scales: {
            y: {
                grid: { color: '#eef0f5' },
                ticks: { font: { size: 10 }, callback: function(value) { return '₱' + value.toLocaleString(); } }
            },
            x: { grid: { display: false }, ticks: { font: { size: 10 } } }
        }
    }
});

const orderStatusCtx = document.getElementById('orderStatusChart');
new Chart(orderStatusCtx, {
    type: 'doughnut',
    data: {
        labels: orderStatusData.labels,
        datasets: [{
            data: orderStatusData.values,
            backgroundColor: ['#eab54a', '#3aa0e8', '#1BC49B', '#f16a6a'],
            borderColor: '#ffffff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10.5 }, padding: 12 } }
        }
    }
});

const inventoryValueCtx = document.getElementById('inventoryValueChart');
new Chart(inventoryValueCtx, {
    type: 'bar',
    data: {
        labels: inventoryValueData.labels,
        datasets: [{
            label: 'Inventory Value',
            data: inventoryValueData.values,
            backgroundColor: '#8b6be0',
            borderRadius: 4,
            barThickness: 30
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                grid: { color: '#eef0f5' },
                ticks: { font: { size: 10 }, callback: function(value) { return '₱' + value.toLocaleString(); } }
            },
            x: { grid: { display: false }, ticks: { font: { size: 10 } } }
        }
    }
});

const menuItems = document.querySelectorAll('.menu-item');

    menuItems.forEach(item => {

        item.addEventListener('click', function(){

            menuItems.forEach(m=>{
                m.classList.remove('active-menu');
            });

            this.classList.add('active-menu');

        });

    });
</script>
</body>
</html>