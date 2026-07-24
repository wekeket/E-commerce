<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>OG TECH — Reports</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
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
        width:250px;
        background:var(--navy);
        color:#fff;
        display:flex;
        flex-direction:column;
        padding:24px 20px;
        flex-shrink:0;
    }
    .brand{
        display:flex;
        align-items:center;
        gap:8px;
        font-weight:800;
        font-size:19px;
        letter-spacing:0.5px;
        margin-bottom:26px;
    }
    .brand .g-icon{
        width:30px;height:30px;border-radius:50%;
        border:2px solid var(--green);
        display:flex;align-items:center;justify-content:center;
        font-size:14px;font-weight:800;color:var(--green);
        flex-shrink:0;
    }
    .sidebar-search{
        background:rgba(255,255,255,0.08);
        border:1px solid rgba(255,255,255,0.15);
        border-radius:999px;
        padding:9px 16px;
        font-size:12px;
        color:#cfd3e6;
        margin-bottom:26px;
        width:100%;
    }
    .sidebar-search::placeholder{ color:#cfd3e6; }
    .menu-label{
        font-size:11px;
        text-transform:uppercase;
        letter-spacing:1px;
        color:var(--green);
        margin-bottom:14px;
        font-weight:700;
    }
    nav.menu{ display:flex; flex-direction:column; gap:6px; flex:1; }
    .nav-btn{
        display:flex;
        align-items:center;
        gap:12px;
        background:transparent;
        border:none;
        color:#c7cbe6;
        font-family:inherit;
        font-size:13.5px;
        font-weight:500;
        text-align:left;
        padding:9px 12px;
        border-radius:12px;
        cursor:pointer;
        text-decoration:none;
        transition:.15s;
    }
    .nav-btn:hover{ background:rgba(255,255,255,0.06); color:#fff; }
    .nav-btn.active{ background:var(--green); color:#fff; font-weight:600; }
    .nav-btn.disabled{ opacity:.55; cursor:not-allowed; pointer-events:none; }
    .nav-btn .icon-box{
        width:32px;
        height:32px;
        border-radius:10px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:15px;
        flex-shrink:0;
    }
    .nav-btn.active .icon-box{ background:rgba(255,255,255,0.2); }
    .icon-blue{ background:rgba(58,160,232,0.2); }
    .icon-orange{ background:rgba(241,138,74,0.2); }
    .icon-yellow{ background:rgba(234,181,74,0.2); }
    .icon-slate{ background:rgba(139,147,192,0.2); }
    .icon-green{ background:rgba(27,196,155,0.2); }

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
<aside class="sidebar">
    <div class="brand"><span class="g-icon">G</span> OG TECH</div>
    <input class="sidebar-search" type="text" placeholder="Search">

    <div class="menu-label">Main Menu</div>
    <nav class="menu">
        <a class="nav-btn" href="{{ route('dashboard') }}">
            <span class="icon-box icon-blue">🔲</span> Dashboard
        </a>
        <a class="nav-btn disabled" title="Not wired up yet">
            <span class="icon-box icon-slate">📦</span> Inventory
        </a>
        <a class="nav-btn disabled" title="Not wired up yet">
            <span class="icon-box icon-orange">🛒</span> Orders
        </a>
        <a class="nav-btn disabled" title="Not wired up yet">
            <span class="icon-box icon-yellow">🏷️</span> Products
        </a>
        <a class="nav-btn disabled" title="Not wired up yet">
            <span class="icon-box icon-slate">💳</span> Customers &amp; Payments
        </a>
        <a class="nav-btn active" href="{{ route('reports') }}">
            <span class="icon-box">📊</span> Reports
        </a>
        <a class="nav-btn disabled" title="Not wired up yet">
            <span class="icon-box icon-slate">⚙️</span> Settings
        </a>
    </nav>
</aside>

<!-- ================= MAIN ================= -->
<div class="main">
    <div class="topbar">
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="logout-pill" style="background:#f16a6a;color:#fff;font-size:11px;font-weight:700;letter-spacing:.5px;padding:6px 14px;border-radius:14px;border:none;cursor:pointer;" onclick="return confirm('Log out of OG TECH?');">LOGOUT</button>
        </form>
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
</script>
</body>
</html>