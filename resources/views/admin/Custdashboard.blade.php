<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Information Management</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Poppins', sans-serif;
            background:#eef2f7;
        }
    </style>

</head>
<body>

<div class="min-h-screen">

    <!-- Sidebar -->

    <aside
    id="sidebar"
    class="fixed top-0 left-0 h-screen w-64 bg-[#192b8d] text-white
           transform -translate-x-full
           transition-transform duration-300 ease-in-out
           z-50">
    
        <div class="p-6">

            <div class="flex items-center gap-2 mb-6">

                <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center font-bold text-xl">
                    G
                </div>

    <!-- Test comment 2 -->
                <div>

                    <h2 class="font-bold text-2xl">OG</h2>

                </div>

                <span class="font-semibold tracking-wide">
                    TECH
                </span>

            </div>

            <input
            type="text"
            placeholder="Search"
            class="w-full rounded-full px-4 py-2 text-black text-sm">

        </div>

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

    <div
    id="overlay"
    class="fixed inset-0 bg-black/40 hidden z-40">
    </div>


    <!-- Main -->

    <main id="mainContent" class="min-h-screen overflow-auto">

        <!-- Navbar -->

        <header class="bg-[#1f3b99] text-white px-8 py-4 flex justify-between items-center">

            <div class="flex items-center gap-4">

                <button id="menuToggle" class="text-2xl">
                    ☰
                </button>

                <h1 class="font-semibold text-lg">
                    OG TECH | Admin Panel
                </h1>

            </div>

            <div class="flex items-center gap-4">

                <button class="bg-green-500 px-5 py-2 rounded-full text-sm">
                    <a href="/Add-product">Add Product</a>   
                </button>

                <div class="w-10 h-10 rounded-full bg-white text-blue-700 flex items-center justify-center font-bold">
                    U
                </div>

            </div>

        </header>


        <!-- Content -->

        <section class="p-8">

            <h2 class="text-3xl font-bold">
                Product Information Management
            </h2>

            <p class="text-gray-500 mb-8">
                Manage all your products on one page
            </p>

            <!-- Cards -->

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="bg-[#2445b7] rounded-xl text-white p-6 shadow">

                    <p>Total Products</p>

                    <h2 class="text-3xl font-bold mt-2">
                        {{ $totalProducts }}
                    </h2>

                </div>

                <div class="bg-[#2445b7] rounded-xl text-white p-6 shadow">

                    <p>In Stock</p>

                    <h2 class="text-3xl font-bold text-green-400 mt-2">
                        {{ $inStock }}
                    </h2>

                </div>

                <div class="bg-[#2445b7] rounded-xl text-white p-6 shadow">

                    <p>Low Stock</p>

                    <h2 class="text-3xl font-bold text-yellow-300 mt-2">
                        {{ $lowStock }}
                    </h2>

                </div>

                <div class="bg-[#2445b7] rounded-xl text-white p-6 shadow">

                    <p>Out of Stock</p>

                    <h2 class="text-3xl font-bold text-red-400 mt-2">
                        {{ $outOfStock }}
                    </h2>

                </div>

            </div>


            <!-- Search -->

            <div class="bg-white rounded-xl shadow mt-8 p-4 flex justify-between items-center">

                <input
                id="searchProduct"
                type="text"
                placeholder="Search product"
                class="border rounded-md px-4 py-2 w-72 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <div class="relative w-48">

                    <select
                        id="sortBy"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 pr-10 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none cursor-pointer">

                        <option value="">Sort By</option>
                        <option value="name">Product Name</option>
                        <option value="price">Price</option>
                        <option value="stock">Stock</option>
                        <option value="status">Status</option>

                    </select>

                    <svg
                        class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7" />

                    </svg>

                </div>

            </div>


            <!-- Table -->

            <div class="bg-white mt-6 rounded-xl shadow overflow-hidden">

                <table class="w-full">

                    <thead class="text-blue-800">

                        <tr class="border-b">

                            <th class="py-4">Product Id</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>

                    </thead>

            <tbody id="productTable" class="text-center">

                @foreach($products as $product)

                <tr class="border-b hover:bg-gray-50">

                    <td class="py-4">{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>₱{{ number_format($product->selling_price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->status }}</td>

                    <td>
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('products.edit', $product->id) }}"
                            class="bg-blue-500 text-white px-3 py-1 rounded">
                                Edit
                            </a>

                            <form action="{{ route('products.destroy', $product->id) }}"
                                method="POST"
                                class="delete-form inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                    Delete
                                </button>

                            </form>
                        </div>
                    </td>

                </tr>

                @endforeach

            </tbody>

                </table>

                    <p id="noResults" class="hidden text-center text-gray-500 py-6">
                        No products found.
                    </p>
            </div>

        </section>

    </main>

</div>
<script>
    // Search Functionality
    const searchInput = document.getElementById("searchProduct");
    const tableRows = document.querySelectorAll("#productTable tr");
    const noResults = document.getElementById("noResults");

    searchInput.addEventListener("input", function () {

        const keyword = this.value.toLowerCase().trim();
        let visibleRows = 0;

        tableRows.forEach(row => {

            const rowText = row.textContent.toLowerCase();

            if (rowText.includes(keyword)) {
                row.style.display = "";
                visibleRows++;
            } else {
                row.style.display = "none";
            }

        });

        noResults.classList.toggle("hidden", visibleRows > 0);

    });

    // Sort Functionality
    const sortBy = document.getElementById("sortBy");
    const tableBody = document.getElementById("productTable");

    sortBy.addEventListener("change", function () {

        const rows = [...tableBody.rows];

        rows.sort((a, b) => {

            switch (this.value) {

                case "name":
                    return b.cells[1].textContent.trim().localeCompare(
                        a.cells[1].textContent.trim()
                    );

                case "price":
                    return parseFloat(b.cells[3].textContent.replace("$", "")) -
                        parseFloat(a.cells[3].textContent.replace("$", ""));

                case "stock":
                    return parseInt(b.cells[4].textContent) -
                        parseInt(a.cells[4].textContent);

                case "status":
                    return b.cells[5].textContent.trim().localeCompare(
                        a.cells[5].textContent.trim()
                    );

                default:
                    return 0;
            }

        });

    rows.forEach(row => tableBody.appendChild(row));

});

// Menu Function
const menuToggle = document.getElementById("menuToggle");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");

menuToggle.addEventListener("click", () => {
    sidebar.classList.toggle("-translate-x-full");
    overlay.classList.toggle("hidden");
});

overlay.addEventListener("click", () => {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("hidden");
});
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#22c55e'
    });
</script>
@endif

<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Delete Product?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

</body>
</html>