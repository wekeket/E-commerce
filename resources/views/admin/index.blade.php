@php

$warehouseData = [
    'Dispatch' => 0,
    'Receiving' => 0,
    'Main' => 0,
    'N/A' => 0,
];

$productNames = [];
$productStocks = [];

foreach ($products as $product) {

    if (array_key_exists($product->warehouse, $warehouseData)) {
        $warehouseData[$product->warehouse]++;
    }

    $productNames[] = $product->name;
    $productStocks[] = $product->stock_quantity;
}

@endphp

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Inventory Management</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
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
</style>

</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
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
               class="menu-item active-menu flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold">
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

    <!-- Main Content -->
    <main class="flex-1 p-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">

            <div>

                <h2 class="text-3xl font-bold text-indigo-900">
                    Inventory Dashboard
                </h2>

                <p class="text-gray-500 mt-1">
                    Monitor and manage your inventory in real time.
                </p>

            </div>
                    
            <div class="w-11 h-11 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shadow">

                A

            </div>

        </div>
                    @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
            @endif
        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

            <!-- Total Products -->
            <div class="bg-gradient-to-r from-indigo-700 to-indigo-900 rounded-xl shadow-lg text-white p-6">

                <p class="text-indigo-200 text-sm">
                    Total Products
                </p>

                <h3 class="text-4xl font-bold mt-3">
                    {{ $totalProducts }}
                </h3>

            </div>

            <!-- In Stock -->
            <div class="bg-gradient-to-r from-green-500 to-green-700 rounded-xl shadow-lg text-white p-6">

                <p class="text-green-100 text-sm">
                    In Stock
                </p>

                <h3 class="text-4xl font-bold mt-3">
                    {{ $inStock }}
                </h3>

            </div>

            <!-- Low Stock -->
            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl shadow-lg text-white p-6">

                <p class="text-yellow-100 text-sm">
                    Low Stock
                </p>

                <h3 class="text-4xl font-bold mt-3">
                    {{ $lowStock }}
                </h3>

            </div>

            <!-- Out of Stock -->
            <div class="bg-gradient-to-r from-red-500 to-red-700 rounded-xl shadow-lg text-white p-6">

                <p class="text-red-100 text-sm">
                    Out of Stock
                </p>

                <h3 class="text-4xl font-bold mt-3">
                    {{ $outOfStock }}
                </h3>

            </div>

        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Inventory Table -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">

                <div class="flex justify-between items-center mb-6">

    <h3 class="text-xl font-bold text-gray-700">
        Inventory Table
    </h3>

    <div class="flex items-center gap-3">

        <!-- Search -->
        <form class="flex items-center" onsubmit="return false;">

                <input
                    id="searchInput"
                    type="text"
                    autocomplete="off"
                    placeholder="Search products..."
                    class="w-64 border rounded-l-lg px-4 py-2">

                <button
                    type="button"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-r-lg cursor-default">

                    🔍

                </button>

            </form>

        <!-- Filter -->
        <form method="GET" action="{{ url('/home') }}">

            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <select
                name="status"
                onchange="this.form.submit()"
                class="border rounded-lg px-4 py-2">

                <option value="">All Products</option>
                <option value="In Stock" {{ request('status')=='In Stock' ? 'selected' : '' }}>In Stock</option>
                <option value="Low Stock" {{ request('status')=='Low Stock' ? 'selected' : '' }}>Low Stock</option>
                <option value="Out of Stock" {{ request('status')=='Out of Stock' ? 'selected' : '' }}>Out of Stock</option>

            </select>

        </form>

        <!-- Sync -->
        <form action="{{ url('/sync') }}" method="POST">
            @csrf
            <button
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                Sync
            </button>
        </form>

        <!-- Add Product -->
        <a href="{{ route('products.create') }}"
           class="bg-indigo-700 hover:bg-indigo-800 text-white px-4 py-2 rounded-lg">
            + Add Product
        </a>

    </div>

</div>

                <table class="w-full border-collapse">

                    <thead class="bg-indigo-800 text-white">

                        <tr>

                            <th class="p-3">ID</th>
                            <th class="p-3">Product</th>
                            <th class="p-3">Warehouse</th>
                            <th class="p-3">Category</th>
                            <th class="p-3">Stock</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Updated</th>
                            <th class="p-3">Action</th>

                        </tr>

                    </thead>

                    <tbody id="productTable">

                        @foreach($products as $item)
<tr class="product-row border-b hover:bg-slate-50 transition">

    <td class="p-3 text-center">
        {{ $item->id }}
    </td>

    <td class="p-3 font-semibold">
        {{ $item->name }}
    </td>

    <td class="p-3">
        {{ $item->warehouse }}
    </td>

    <td class="p-3">
        {{ $item->category_id }}
    </td>

    <td class="p-3 text-center font-semibold">
        {{ $item->stock_quantity }}
    </td>

    <td class="p-3">

        @if($item->status=="In Stock")

            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                {{ $item->status }}
            </span>

        @elseif($item->status=="Low Stock")

            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
                {{ $item->status }}
            </span>

        @else

            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                {{ $item->status }}
            </span>

        @endif

    </td>

    <td class="p-3 text-sm text-gray-600">
        {{ \Carbon\Carbon::parse($item->updated_at)->format('F d, Y h:i A') }}
    </td>

    <td class="p-3">

    <div class="flex gap-2">

        <a href="{{ route('products.edit', $item->id) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition">

            Edit

        </a>

        <button
            type="button"
            onclick="openDeleteModal({{ $item->id }}, '{{ $item->name }}')"
            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition">

            Delete

        </button>

    </div>

</td>

</tr>

@endforeach
    <tr id="noResults" class="hidden">

    <td colspan="8"
        class="text-center py-10 text-gray-500">

        <div class="text-5xl mb-3">
            🔍
        </div>

        <div class="font-bold text-lg">
            No products found
        </div>

        <div class="text-sm">
            Try another search keyword.
        </div>

    </td>

</tr>

</tbody>

</table>

<!-- Inventory Synchronization Card -->

<div class="mt-6">

    <div class="rounded-2xl overflow-hidden shadow-lg bg-gradient-to-r from-indigo-700 via-indigo-800 to-indigo-900">

        <div class="flex justify-between items-center px-6 py-5">

            <div>

                <h3 class="text-xl font-bold text-white">
                    Inventory Synchronization
                </h3>

                <p class="text-indigo-200 text-sm mt-1">
                    Last successful inventory sync
                </p>

            </div>

            <div class="text-right">

                @if(session('last_sync'))

    @php
        $syncTime = \Carbon\Carbon::parse(session('last_sync'));
    @endphp

    <div class="text-2xl font-bold text-white">
        {{ $syncTime->format('F d, Y') }}
    </div>

    <div class="text-indigo-200 font-medium text-lg">
        {{ $syncTime->format('h:i A') }}
    </div>

@endif

            </div>

        </div>

    </div>

</div>

</div>

<!-- Charts -->
<div class="space-y-6">

    <!-- Warehouse Distribution -->
    <div class="bg-white rounded-2xl shadow-lg p-5">

        <h3 class="text-lg font-bold text-center text-gray-700 mb-4">
            Warehouse Distribution
        </h3>

        <canvas id="barChart" height="230"></canvas>

    </div>

    <!-- Stock Distribution -->
    <div class="bg-white rounded-2xl shadow-lg p-5">

        <h3 class="text-lg font-bold text-center text-gray-700 mb-4">
            Product Stock Distribution
        </h3>

        <canvas id="pieChart" height="250"></canvas>

    </div>

</div>

</div>

</main>

</div>

<div id="deleteModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-xl w-[430px] p-8">

        <div class="flex justify-center">

            <div class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center">

                🗑️

            </div>

        </div>

        <h2 class="text-2xl font-bold text-center mt-5">
            Delete Product?
        </h2>

        <p class="text-center text-gray-500 mt-3">

            Are you sure you want to delete

            <span id="deleteProductName"
                  class="font-bold text-red-600"></span>?

        </p>

        <form id="deleteForm" method="POST" class="mt-8">

            @csrf
            @method('DELETE')

            <div class="flex justify-center gap-3">

                <button
                    type="button"
                    onclick="closeDeleteModal()"
                    class="px-6 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">

                    Cancel

                </button>

                <button
                    class="px-6 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white">

                    Delete

                </button>

            </div>

        </form>

    </div>

</div>

<script>

//
// Warehouse Chart
//

new Chart(document.getElementById('barChart'), {

    type: 'bar',

    data: {

        labels: {!! json_encode(array_keys($warehouseData)) !!},

        datasets: [{

            label: 'Products',

            data: {!! json_encode(array_values($warehouseData)) !!},

            backgroundColor: [
                '#4F46E5',
                '#22C55E',
                '#F59E0B',
                '#EF4444'
            ],

            borderRadius: 8

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: true,

        plugins: {

            legend: {

                display: false

            }

        },

        scales: {

            y: {

                beginAtZero: true,

                ticks: {

                    precision: 0

                }

            }

        }

    }

});


//
// Pie Chart
//

new Chart(document.getElementById('pieChart'), {

    type: 'pie',

    data: {

        labels: {!! json_encode($productNames) !!},

        datasets: [{

            data: {!! json_encode($productStocks) !!},

            backgroundColor: [

                '#4F46E5',
                '#22C55E',
                '#F59E0B',
                '#EF4444',
                '#06B6D4',
                '#8B5CF6',
                '#EC4899',
                '#14B8A6',
                '#84CC16',
                '#F97316',
                '#3B82F6',
                '#A855F7',
                '#10B981',
                '#F43F5E',
                '#EAB308'

            ],

            hoverOffset: 18

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                position: 'bottom',

                labels: {

                    padding: 18,

                    font: {

                        size: 12

                    }

                }

            },

            tooltip: {

                callbacks: {

                    label: function(context) {

                        return context.label + " : " + context.raw + " pcs";

                    }

                }

            }

        }

    }

});


// ================================
// Live Search
// ================================
const searchInput = document.getElementById("searchInput");
const rows = document.querySelectorAll(".product-row");
const noResults = document.getElementById("noResults");

searchInput.addEventListener("keyup", function () {

    const value = this.value.toLowerCase().trim();

    let found = false;

    rows.forEach(row => {

        const text = row.textContent.toLowerCase();

        if (text.includes(value)) {

            row.style.display = "";
            found = true;

        } else {

            row.style.display = "none";

        }

    });

    if (found) {

        noResults.classList.add("hidden");

    } else {

        noResults.classList.remove("hidden");

    }

});


function openDeleteModal(id, name){

    document.getElementById('deleteProductName').innerText = name;

    const deleteUrlTemplate = "{{ route('products.destroy', ['product' => 'PRODUCT_ID']) }}";
    document.getElementById('deleteForm').action = deleteUrlTemplate.replace('PRODUCT_ID', id);

    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');

}

function closeDeleteModal(){

    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');

}

</script>

</body>
</html>