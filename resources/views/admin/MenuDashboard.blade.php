<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OG Tech Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

    <style>
        body{
            background:#dcdcdc;
            font-family:'Poppins', sans-serif;
        }

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

        .dashboard-card{
            transition:.3s;
        }

        .dashboard-card:hover{
            transform:translateY(-3px);
        }

        .quick-card:hover{
            transform:scale(1.03);
        }

        .quick-card{
            transition:.3s;
        }

        .table-header{
            background:#213a8f;
            color:white;
        }

        .hero-box{
            background:#213a8f;
        }

        .orders-table th,
        .orders-table td{
            padding:10px 12px;
            text-align:left;
            white-space:nowrap;
        }

        /* Quantity column - centered */
        .orders-table th:nth-child(2),
        .orders-table td:nth-child(2){
            text-align:center;
        }

        /* Total Amount column - right aligned */
        .orders-table th:nth-child(5),
        .orders-table td:nth-child(5){
            text-align:right;
        }

        /* Status column - centered */
        .orders-table th:nth-child(7),
        .orders-table td:nth-child(7){
            text-align:center;
        }
    </style>
</head>
<body>

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
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
               class="menu-item active-menu flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold">
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

    <!-- MAIN CONTENT -->
    <main class="flex-1">

        <!-- TOP NAVBAR -->
        <header class="bg-gray-300 px-8 py-3 flex justify-end items-center gap-5">
            

            <div class="relative">
                <input
                    id="searchDashboard"
                    type="text"
                    placeholder="Search"
                    class="w-64 rounded-full px-4 py-2 text-sm">
            </div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
    @csrf
    <button type="submit"
        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
        Logout
    </button>
</form>

            <button>🔔</button>
            <button>⚙️</button>

            <div class="w-10 h-10 rounded-full bg-blue-500"></div>

        </header>

        <div class="p-8">

            <!-- TITLE -->
            <h1 class="text-4xl font-bold text-blue-900 mb-4">
                Dashboard
            </h1>

            <!-- HERO -->
            <div class="hero-box rounded-3xl p-8 text-white mb-8">

                <h2 class="text-3xl mb-8">
                    Your store is performing well this month
                </h2>

                <a href="{{ route('reports') }}"
                   class="inline-block bg-white text-black px-6 py-2 rounded-xl hover:bg-gray-200 transition">
                   View Reports
                </a>

            </div>

            <!-- STATS -->
            <div class="grid md:grid-cols-4 gap-4 mb-8">

                <div class="dashboard-card bg-white rounded-2xl border p-5">
                    <p class="text-green-700 text-xl">💵</p>
                    <h3 class="text-center text-3xl font-bold text-blue-900">
                        ₱{{ number_format($totalRevenue / 1000, 1) }}K
                    </h3>
                    <p class="text-center text-xs text-gray-500">
                        Total Revenue
                    </p>
                </div>

                <div class="dashboard-card bg-white rounded-2xl border p-5">
                    <p>🧾</p>
                    <h3 class="text-center text-3xl font-bold text-green-600">
                        {{ $totalOrders }}
                    </h3>
                    <p class="text-center text-xs text-gray-500">
                        Total Orders
                    </p>
                </div>

                <div class="dashboard-card bg-white rounded-2xl border p-5">
                    <p>👤</p>
                    <h3 class="text-center text-3xl font-bold text-blue-900">
                        {{ number_format($totalCustomers) }}
                    </h3>
                    <p class="text-center text-xs text-gray-500">
                        Total Customers
                    </p>
                </div>

                <div class="dashboard-card bg-white rounded-2xl border p-5">
                    <p>📦</p>
                    <h3 class="text-center text-3xl font-bold text-green-500">
                        {{ $activeProducts }}
                    </h3>
                    <p class="text-center text-xs text-gray-500">
                        Active Products
                    </p>
                </div>

            </div>

            <!-- QUICK ACTIONS -->
            <div class="mb-8">

                <h2 class="font-bold mb-4">
                    Quick Actions
                </h2>

                <div class="flex gap-8 flex-wrap">

                    <a href="{{ route('products.create') }}"
                        class="quick-card bg-white border rounded-2xl w-44 h-28 flex flex-col items-center justify-center">
                        <div class="text-3xl">➕</div>
                        <div class="font-semibold">
                            Add Product
                        </div>
                        <div class="text-xs text-gray-500">
                            List New Item
                        </div>
                    </a>

                    

                </div>

            </div>

            <!-- TABLE + PRODUCTS -->
            <div class="grid lg:grid-cols-4 gap-4">

                <!-- TABLE -->
                <div class="lg:col-span-3 bg-white rounded-2xl border overflow-hidden">

                    <div class="table-header px-4 py-2 font-semibold">
                        Recent Orders
                    </div>

                    <table class="w-full text-sm orders-table">

                        <thead>
    <tr class="bg-blue-900 text-white">
        <th>Order ID</th>
        <th>Quantity</th>
        <th>Customer</th>
        <th>Date & Time</th>
        <th>Total Amount</th>
        <th>Payment Method</th>
        <th>Status</th>
    </tr>
</thead>

<tbody id="ordersTable">

    @forelse($recentOrders as $order)
    <tr class="border-b">
        <td>{{ $order->order_code }}</td>
        <td>1</td>
        <td>{{ $order->customer_name }}</td>
        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('M j, g:i A') }}</td>
        <td>₱{{ number_format($order->total_amount, 2) }}</td>
        <td>{{ $order->payment_method }}</td>
        <td class="font-semibold {{ $order->status === 'Shipped' ? 'text-green-500' : 'text-yellow-500' }}">
            {{ $order->status }}
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="p-4 text-center text-gray-400">No orders yet.</td>
    </tr>
    @endforelse

</tbody>

                    </table>

                </div>

                <!-- TOP PRODUCTS -->
                <div class="bg-white rounded-2xl border p-4">

                    <h3 class="font-bold mb-4">
                        Top Products
                    </h3>

                    @if($topProducts->isEmpty())
                        <p class="text-gray-400 text-sm">No sales data yet.</p>
                    @else
                        <canvas id="topProductsChart" class="mb-4"></canvas>

                        <ul class="space-y-2 text-sm">
                            @foreach($topProducts as $i => $product)
                                <li class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full inline-block" style="background:{{ ['#213a8f', '#23d18b', '#f59e0b', '#ef4444'][$i % 4] }}"></span>
                                    {{ $product->product_name }}
                                    <span class="text-gray-400 ml-auto">{{ $product->units_sold }} sold</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </div>

            </div>

        </div>

    </main>

</div>

<script>

    @if($topProducts->isNotEmpty())
    new Chart(document.getElementById('topProductsChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($topProducts->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode($topProducts->pluck('units_sold')) !!},
                backgroundColor: ['#213a8f', '#23d18b', '#f59e0b', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            }
        }
    });
    @endif

    const menuItems = document.querySelectorAll('.menu-item');

    menuItems.forEach(item => {

        item.addEventListener('click', function(){

            menuItems.forEach(m=>{
                m.classList.remove('active-menu');
            });

            this.classList.add('active-menu');

        });

    });

    document
        .getElementById('searchDashboard')
        .addEventListener('keyup', function(){

            let value = this.value.toLowerCase();

            let rows = document.querySelectorAll('#ordersTable tr');

            rows.forEach(row => {

                row.style.display =
                    row.innerText.toLowerCase().includes(value)
                    ? ''
                    : 'none';

            });

        });

</script>

</body>
</html>