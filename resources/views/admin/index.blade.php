@php

$totalProducts = $products->count();

$inStock = $products->where('stock_quantity', '>', 10)->count();
$lowStock = $products->whereBetween('stock_quantity', [1, 10])->count();
$outOfStock = $products->where('stock_quantity', 0)->count();

$productDistribution = $products
    ->groupBy('category')
    ->map(function ($items) {
        return $items->count();
    });

/*
|--------------------------------------------------------------------------
| TOP PRODUCTS BY HIGHEST STOCK QUANTITY
|--------------------------------------------------------------------------
*/

$productNameDistribution = $products
    ->sortByDesc('stock_quantity')
    ->take(10)
    ->mapWithKeys(function ($product) {
        return [
            $product->product_name => $product->stock_quantity
        ];
    });

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

body {
    font-family: 'Poppins', sans-serif;
}

.sidebar {
    background: linear-gradient(
        180deg,
        #213a8f 0%,
        #13235e 100%
    );
}

.active-menu {
    background: #23d18b;
}

.icon-box {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}

.chart-card {
    transition: all .25s ease;
}

.chart-card:hover {
    transform: translateY(-3px);
}

</style>

</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">


<!-- SIDEBAR -->

<aside class="sidebar w-64 text-white flex flex-col p-6">


    <!-- LOGO -->

    <div class="flex items-center gap-2 mb-8">

        <div
            class="w-9 h-9 rounded-full border-2 border-emerald-400 flex items-center justify-center text-emerald-400 font-bold text-lg">

            G

        </div>


        <div class="font-extrabold text-xl tracking-wide">

            OG TECH

        </div>

    </div>


    <!-- SEARCH -->

    <div class="mb-8">

        <input
            type="text"
            placeholder="Search"
            class="w-full rounded-full bg-white/10 border border-white/20 placeholder-gray-300 text-white text-sm px-4 py-2 focus:outline-none focus:bg-white/20">

    </div>


    <!-- MAIN MENU -->

    <h3 class="text-xs font-bold text-emerald-400 tracking-widest uppercase mb-4">

        Main Menu

    </h3>


    <nav class="space-y-2">


        <a
            href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">

            <span class="icon-box bg-white/20">

                🔲

            </span>

            Dashboard

        </a>


        <a
            href="{{ route('inventory.index') }}"
            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold active-menu">

            <span class="icon-box bg-blue-400/20">

                📦

            </span>

            Inventory

        </a>


        <a
            href="{{ route('orders.index') }}"
            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">

            <span class="icon-box bg-orange-400/20">

                🛒

            </span>

            Orders

        </a>


        <a
            href="{{ route('products.index') }}"
            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">

            <span class="icon-box bg-yellow-400/20">

                🏷️

            </span>

            Products

        </a>


        <a
            href="{{ route('customers.index') }}"
            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">

            <span class="icon-box bg-slate-400/20">

                💳

            </span>

            Customers & Payments

        </a>


        <a
            href="{{ route('reports') }}"
            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">

            <span class="icon-box bg-emerald-400/20">

                📊

            </span>

            Reports

        </a>


        <a
            href="#"
            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">

            <span class="icon-box bg-slate-400/20">

                ⚙️

            </span>

            Settings

        </a>

    </nav>

</aside>


<!-- MAIN CONTENT -->

<main class="flex-1 p-8">


    <!-- HEADER -->

    <div class="flex justify-between items-center mb-8">

        <div>

            <h2 class="text-3xl font-bold text-indigo-900">

                Inventory Dashboard

            </h2>


            <p class="text-gray-500 mt-1">

                Monitor and manage your inventory in real time.

            </p>

        </div>


        <div
            class="w-11 h-11 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shadow">

            A

        </div>

    </div>


    <!-- SUCCESS MESSAGE -->

    @if(session('success'))

        <div
            class="mb-6 rounded-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3">

            {{ session('success') }}

        </div>

    @endif


    <!-- DASHBOARD CARDS -->

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">


        <!-- TOTAL PRODUCTS -->

        <div
            class="bg-gradient-to-r from-indigo-700 to-indigo-900 rounded-xl shadow-lg text-white p-6">

            <p class="text-indigo-200 text-sm">

                Total Products

            </p>


            <h3 class="text-4xl font-bold mt-3">

                {{ $totalProducts }}

            </h3>

        </div>


        <!-- IN STOCK -->

        <div
            class="bg-gradient-to-r from-green-500 to-green-700 rounded-xl shadow-lg text-white p-6">

            <p class="text-green-100 text-sm">

                In Stock

            </p>


            <h3 class="text-4xl font-bold mt-3">

                {{ $inStock }}

            </h3>

        </div>


        <!-- LOW STOCK -->

        <div
            class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl shadow-lg text-white p-6">

            <p class="text-yellow-100 text-sm">

                Low Stock

            </p>


            <h3 class="text-4xl font-bold mt-3">

                {{ $lowStock }}

            </h3>

        </div>


        <!-- OUT OF STOCK -->

        <div
            class="bg-gradient-to-r from-red-500 to-red-700 rounded-xl shadow-lg text-white p-6">

            <p class="text-red-100 text-sm">

                Out of Stock

            </p>


            <h3 class="text-4xl font-bold mt-3">

                {{ $outOfStock }}

            </h3>

        </div>

    </div>


    <!-- MAIN DASHBOARD GRID -->

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">


        <!-- INVENTORY TABLE -->

        <div class="xl:col-span-2 bg-white rounded-xl shadow-lg p-6">


            <!-- TABLE HEADER -->

            <div class="flex justify-between items-center mb-6">

                <h3 class="text-xl font-bold text-gray-700">

                    Inventory Table

                </h3>


                <div class="flex items-center gap-3">


                    <!-- SEARCH -->

                    <form
                        class="flex items-center"
                        onsubmit="return false;">

                        <input
                            id="searchInput"
                            type="text"
                            autocomplete="off"
                            placeholder="Search products..."
                            class="w-64 border rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">


                        <button
                            type="button"
                            class="bg-indigo-700 text-white px-4 py-2 rounded-r-lg cursor-default">

                            🔍

                        </button>

                    </form>


                    <!-- STATUS FILTER -->

                    <form
                        method="GET"
                        action="{{ route('inventory.index') }}">

                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="border rounded-lg px-4 py-2">

                            <option value="">

                                All Products

                            </option>


                            <option
                                value="active"
                                {{ request('status') == 'active' ? 'selected' : '' }}>

                                Active

                            </option>


                            <option
                                value="inactive"
                                {{ request('status') == 'inactive' ? 'selected' : '' }}>

                                Inactive

                            </option>

                        </select>

                    </form>


                    <!-- SYNC -->

                    <form
                        action="{{ route('inventory.sync') }}"
                        method="POST">

                        @csrf

                        <button
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">

                            Sync

                        </button>

                    </form>


                    <!-- ADD PRODUCT -->

                    <a
                        href="{{ route('products.create') }}"
                        class="bg-indigo-700 hover:bg-indigo-800 text-white px-4 py-2 rounded-lg">

                        + Add Product

                    </a>

                </div>

            </div>


            <!-- TABLE -->

            <div class="overflow-x-auto">

                <table class="w-full table-fixed border-collapse">

                    <thead class="bg-indigo-800 text-white">

                        <tr>

                            <th class="w-[7%] p-3 text-center">

                                ID

                            </th>


                            <th class="w-[25%] p-3 text-left">

                                Product

                            </th>


                            <th class="w-[18%] p-3 text-left">

                                Category

                            </th>


                            <th class="w-[10%] p-3 text-center">

                                Stock

                            </th>


                            <th class="w-[13%] p-3 text-center">

                                Status

                            </th>


                            <th class="w-[17%] p-3 text-center">

                                Updated

                            </th>


                            <th class="w-[20%] p-3 text-center">

                                Action

                            </th>

                        </tr>

                    </thead>


                    <tbody id="productTable">


                        @foreach($products as $item)

                            <tr
                                class="product-row border-b hover:bg-slate-50 transition">


                                <!-- ID -->

                                <td class="p-3 text-center align-middle">

                                    {{ $item->id }}

                                </td>


                                <!-- PRODUCT -->

                                <td
                                    class="p-3 font-semibold text-left align-middle truncate">

                                    {{ $item->product_name }}

                                </td>


                                <!-- CATEGORY -->

                                <td class="p-3 text-left align-middle">

                                    {{ $item->category ?? 'N/A' }}

                                </td>


                                <!-- STOCK -->

                                <td
                                    class="p-3 text-center font-semibold align-middle">

                                    {{ $item->stock_quantity }}

                                </td>


                                <!-- STATUS -->

                                <td class="p-3 text-center align-middle">


                                    @if($item->status === 'active')

                                        <span
                                            class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">

                                            Active

                                        </span>

                                    @else

                                        <span
                                            class="inline-block bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">

                                            Inactive

                                        </span>

                                    @endif

                                </td>


                                <!-- UPDATED -->

                                <td
                                    class="p-3 text-center text-sm text-gray-600 align-middle">

                                    @if($item->updated_at)

                                        {{ \Carbon\Carbon::parse($item->updated_at)
                                            ->timezone('Asia/Manila')
                                            ->format('M d, Y h:i A') }}

                                    @else

                                        N/A

                                    @endif

                                </td>


                                <!-- ACTION -->

                                <td class="p-3 align-middle">

                                    <div class="flex justify-center gap-2">


                                        <a
                                            href="{{ route('products.edit', $item->id) }}"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition">

                                            Edit

                                        </a>


                                        <button
                                            type="button"
                                            onclick="openDeleteModal(
                                                {{ $item->id }},
                                                '{{ addslashes($item->product_name) }}'
                                            )"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition">

                                            Delete

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @endforeach


                        <!-- NO RESULTS -->

                        <tr
                            id="noResults"
                            class="hidden">

                            <td
                                colspan="7"
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

            </div>

        </div>


        <!-- CHARTS SIDEBAR -->

        <div class="space-y-6">


            <!-- STOCK OVERVIEW -->

            <div
                class="chart-card bg-white rounded-xl shadow-lg p-6">

                <div
                    class="flex justify-between items-center mb-5">

                    <div>

                        <h3
                            class="text-lg font-bold text-gray-700">

                            Stock Overview

                        </h3>


                        <p
                            class="text-sm text-gray-400">

                            Current inventory health

                        </p>

                    </div>


                    <div class="text-2xl">

                        📊

                    </div>

                </div>


                <div class="h-64">

                    <canvas id="stockChart"></canvas>

                </div>

            </div>


            <!-- PRODUCT DISTRIBUTION -->

            <div
                class="chart-card bg-white rounded-xl shadow-lg p-6">

                <div
                    class="flex justify-between items-center mb-5">

                    <div>

                        <h3
                            class="text-lg font-bold text-gray-700">

                            Product Distribution

                        </h3>


                        <p
                            class="text-sm text-gray-400">

                            Products by category

                        </p>

                    </div>


                    <div class="text-2xl">

                        🥧

                    </div>

                </div>


                <div
                    class="h-64 flex justify-center">

                    <canvas id="productChart"></canvas>

                </div>

            </div>


            <!-- TOP PRODUCTS BY STOCK -->

            <div
                class="chart-card bg-white rounded-xl shadow-lg p-6">

                <div
                    class="flex justify-between items-center mb-5">

                    <div>

                        <h3
                            class="text-lg font-bold text-gray-700">

                            Top Products by Stock

                        </h3>


                        <p
                            class="text-sm text-gray-400">

                            Products with the highest quantity

                        </p>

                    </div>


                    <div class="text-2xl">

                        📦

                    </div>

                </div>


                <div class="h-96">

                    <canvas id="productNameChart"></canvas>

                </div>

            </div>

        </div>

    </div>


    <!-- INVENTORY SYNCHRONIZATION -->

    <div class="mt-6">

        <div
            class="rounded-2xl overflow-hidden shadow-lg bg-gradient-to-r from-indigo-700 via-indigo-800 to-indigo-900">

            <div
                class="flex justify-between items-center px-6 py-5">


                <div>

                    <h3
                        class="text-xl font-bold text-white">

                        Inventory Synchronization

                    </h3>


                    <p
                        class="text-indigo-200 text-sm mt-1">

                        Last successful inventory sync

                    </p>

                </div>


                <div class="text-right">


                    @if(session('last_sync'))

                        @php

                            $syncTime = \Carbon\Carbon::parse(
                                    session('last_sync')
                                )->timezone('Asia/Manila');

                        @endphp


                        <div
                            class="text-2xl font-bold text-white">

                            {{ $syncTime->format('F d, Y') }}

                        </div>


                        <div
                            class="text-indigo-200 font-medium text-lg">

                            {{ $syncTime->format('h:i A') }}

                        </div>

                    @else

                        <div
                            class="text-indigo-200">

                            No sync yet

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</main>

</div>


<!-- DELETE MODAL -->

<div
    id="deleteModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">


    <div
        class="bg-white rounded-2xl shadow-xl w-[430px] p-8">


        <div
            class="flex justify-center">

            <div
                class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center">

                🗑️

            </div>

        </div>


        <h2
            class="text-2xl font-bold text-center mt-5">

            Delete Product?

        </h2>


        <p
            class="text-center text-gray-500 mt-3">

            Are you sure you want to delete

            <span
                id="deleteProductName"
                class="font-bold text-red-600">

            </span>?

        </p>


        <form
            id="deleteForm"
            method="POST"
            class="mt-8">

            @csrf

            @method('DELETE')


            <div
                class="flex justify-center gap-3">


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


// ================================
// LIVE SEARCH
// ================================

const searchInput =
    document.getElementById("searchInput");

const rows =
    document.querySelectorAll(".product-row");

const noResults =
    document.getElementById("noResults");


searchInput.addEventListener(
    "keyup",
    function () {

        const value =
            this.value.toLowerCase().trim();

        let found = false;


        rows.forEach(row => {

            const text =
                row.textContent.toLowerCase();


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

    }

);


// ================================
// STOCK CHART
// ================================

new Chart(
    document.getElementById('stockChart'),
    {

        type: 'bar',

        data: {

            labels: [
                'In Stock',
                'Low Stock',
                'Out of Stock'
            ],

            datasets: [

                {

                    label: 'Products',

                    data: [

                        {{ $inStock }},

                        {{ $lowStock }},

                        {{ $outOfStock }}

                    ],

                    borderRadius: 8

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

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

    }

);


// ================================
// PRODUCT DISTRIBUTION PIE CHART
// ================================

new Chart(
    document.getElementById('productChart'),
    {

        type: 'doughnut',

        data: {

            labels: @json($productDistribution->keys()),

            datasets: [

                {

                    data: @json($productDistribution->values()),

                    borderWidth: 2

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: '58%',

            plugins: {

                legend: {

                    position: 'bottom',

                    labels: {

                        padding: 15,

                        usePointStyle: true

                    }

                }

            }

        }

    }

);


// ================================
// TOP PRODUCTS BY STOCK QUANTITY
// ================================

new Chart(
    document.getElementById('productNameChart'),
    {

        type: 'bar',

        data: {

            labels: @json($productNameDistribution->keys()),

            datasets: [

                {

                    label: 'Stock Quantity',

                    data: @json($productNameDistribution->values()),

                    borderRadius: 8

                }

            ]

        },

        options: {

            indexAxis: 'y',

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    display: false

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return ' Stock: ' + context.raw;

                        }

                    }

                }

            },

            scales: {

                x: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0

                    }

                }

            }

        }

    }

);


// ================================
// DELETE MODAL
// ================================

function openDeleteModal(id, name) {


    document.getElementById(
        'deleteProductName'
    ).innerText = name;


    const deleteUrlTemplate =
        "{{ route('products.destroy', ['product' => 'PRODUCT_ID']) }}";


    document.getElementById(
        'deleteForm'
    ).action =
        deleteUrlTemplate.replace(
            'PRODUCT_ID',
            id
        );


    document.getElementById(
        'deleteModal'
    ).classList.remove('hidden');


    document.getElementById(
        'deleteModal'
    ).classList.add('flex');

}


function closeDeleteModal() {


    document.getElementById(
        'deleteModal'
    ).classList.add('hidden');


    document.getElementById(
        'deleteModal'
    ).classList.remove('flex');

}

</script>


</body>

</html>