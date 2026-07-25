<!DOCTYPE html>

<html lang="en">

<head>

```
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Product</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>

    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    @keyframes popup {

        0% {
            opacity: 0;
            transform: scale(.85) translateY(30px);
        }

        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

    }

    .animate-popup {
        animation: popup .35s ease;
    }

</style>
```

</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

```
<!-- ========================= -->
<!-- SIDEBAR -->
<!-- ========================= -->

<aside class="w-64 bg-gradient-to-b from-indigo-900 to-indigo-800 text-white shadow-2xl">

    <div class="p-6 border-b border-indigo-700">

        <h1 class="text-3xl font-black tracking-wide">

            <span class="text-green-400">
                OG
            </span>

            TECH

        </h1>

        <p class="text-indigo-200 text-sm mt-2">
            Inventory Management
        </p>

    </div>

    <nav class="mt-5 px-3 space-y-2">

        <a href="{{ url('/home') }}"
           class="block px-4 py-3 rounded-lg hover:bg-indigo-700 transition">

            🏠 Dashboard

        </a>

        <a href="{{ url('/inventory') }}"
           class="block px-4 py-3 rounded-lg bg-emerald-500 font-semibold shadow">

            📦 Inventory

        </a>

    </nav>

</aside>


<!-- ========================= -->
<!-- MAIN CONTENT -->
<!-- ========================= -->

<main class="flex-1 p-10">

    <!-- HEADER -->

    <div class="flex justify-between items-center mb-8">

        <div>

            <h2 class="text-4xl font-black text-indigo-900">

                Edit Product

            </h2>

            <p class="text-gray-500 mt-2">

                Update product information stored in your inventory.

            </p>

        </div>

        <a href="{{ url('/inventory') }}"
           class="bg-gray-800 hover:bg-black text-white px-6 py-3 rounded-xl shadow-lg transition">

            ← Back to Inventory

        </a>

    </div>


    <!-- ========================= -->
    <!-- ERROR MESSAGES -->
    <!-- ========================= -->

    @if ($errors->any())

        <div class="bg-red-100 border border-red-300 text-red-700 rounded-xl p-5 mb-8">

            <h3 class="font-bold mb-2">
                Please fix the following errors:
            </h3>

            <ul class="list-disc list-inside">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- ========================= -->
    <!-- SUCCESS MESSAGE -->
    <!-- ========================= -->

    @if (session('success'))

        <div class="bg-green-100 border border-green-300 text-green-700 rounded-xl p-5 mb-8">

            {{ session('success') }}

        </div>

    @endif


    <!-- ========================= -->
    <!-- PRODUCT SUMMARY -->
    <!-- ========================= -->

    <div class="grid md:grid-cols-4 gap-5 mb-8">


        <!-- PRODUCT ID -->

        <div class="bg-white rounded-2xl shadow-lg p-6">

            <p class="text-gray-500 text-sm">

                Product ID

            </p>

            <h2 class="text-3xl font-bold text-indigo-700 mt-2">

                #{{ $product->id }}

            </h2>

        </div>


        <!-- CURRENT STOCK -->

        <div class="bg-white rounded-2xl shadow-lg p-6">

            <p class="text-gray-500 text-sm">

                Current Stock

            </p>

            <h2 id="stockPreview"
                class="text-3xl font-bold text-green-600 mt-2">

                {{ $product->stock_quantity }}

            </h2>

        </div>


        <!-- SELLING PRICE -->

        <div class="bg-white rounded-2xl shadow-lg p-6">

            <p class="text-gray-500 text-sm">

                Selling Price

            </p>

            <h2 class="text-3xl font-bold text-blue-700 mt-2">

                ₱{{ number_format($product->price, 2) }}

            </h2>

        </div>


        <!-- STATUS -->

        <div class="bg-white rounded-2xl shadow-lg p-6">

            <p class="text-gray-500 text-sm">

                Status

            </p>

            <div class="mt-3">

                @if ($product->status === 'active')

                    <span class="px-4 py-2 rounded-full bg-green-600 text-white font-semibold">

                        Active

                    </span>

                @else

                    <span class="px-4 py-2 rounded-full bg-red-600 text-white font-semibold">

                        Inactive

                    </span>

                @endif

            </div>

        </div>

    </div>


    <!-- ========================= -->
    <!-- EDIT FORM -->
    <!-- ========================= -->

    <form

        action="{{ route('products.update', $product->id) }}"

        method="POST"

        id="editForm"

        class="bg-white rounded-3xl shadow-2xl p-10">

        @csrf

        @method('PUT')


        <div class="grid md:grid-cols-2 gap-8">


            <!-- PRODUCT NAME -->

            <div>

                <label class="font-bold text-gray-700">

                    Product Name

                </label>

                <input

                    type="text"

                    name="product_name"

                    required

                    value="{{ old('product_name', $product->product_name) }}"

                    class="mt-2 w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

            </div>


            <!-- BRAND -->

            <div>

                <label class="font-bold text-gray-700">

                    Brand

                </label>

                <input

                    type="text"

                    name="brand"

                    value="{{ old('brand', $product->brand) }}"

                    class="mt-2 w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

            </div>


            <!-- CATEGORY -->

            <div>

                <label class="font-bold text-gray-700">

                    Category

                </label>

                <input

                    type="text"

                    name="category"

                    value="{{ old('category', $product->category) }}"

                    class="mt-2 w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

            </div>


            <!-- STATUS -->

            <div>

                <label class="font-bold text-gray-700">

                    Status

                </label>

                <select

                    name="status"

                    class="mt-2 w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                    <option value="active"

                        {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>

                        Active

                    </option>

                    <option value="inactive"

                        {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>

                        Inactive

                    </option>

                </select>

            </div>


            <!-- SELLING PRICE -->

            <div>

                <label class="font-bold text-gray-700">

                    Selling Price (₱)

                </label>

                <input

                    type="number"

                    step="0.01"

                    min="0"

                    name="price"

                    required

                    value="{{ old('price', $product->price) }}"

                    class="mt-2 w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

            </div>


            <!-- COST PRICE -->

            <div>

                <label class="font-bold text-gray-700">

                    Cost Price (₱)

                </label>

                <input

                    type="number"

                    step="0.01"

                    min="0"

                    name="cost"

                    value="{{ old('cost', $product->cost) }}"

                    class="mt-2 w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

            </div>


            <!-- STOCK QUANTITY -->

            <div>

                <label class="font-bold text-gray-700">

                    Stock Quantity

                </label>

                <input

                    type="number"

                    id="stockInput"

                    min="0"

                    name="stock_quantity"

                    required

                    value="{{ old('stock_quantity', $product->stock_quantity) }}"

                    class="mt-2 w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

            </div>


            <!-- DESCRIPTION -->

            <div class="md:col-span-2">

                <label class="font-bold text-gray-700">

                    Product Description

                </label>

                <textarea

                    name="description"

                    rows="5"

                    class="mt-2 w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('description', $product->description) }}</textarea>

            </div>

        </div>


        <!-- ========================= -->
        <!-- PRODUCT INFORMATION -->
        <!-- ========================= -->

        <div class="mt-10 border-t pt-8">

            <h3 class="text-2xl font-bold text-gray-700 mb-6">

                Product Information

            </h3>


            <div class="grid md:grid-cols-3 gap-6">


                <!-- PRODUCT ID -->

                <div class="bg-indigo-50 rounded-2xl p-6 border">

                    <p class="text-gray-500">

                        Product ID

                    </p>

                    <p class="text-3xl font-bold text-indigo-700 mt-3">

                        #{{ $product->id }}

                    </p>

                </div>


                <!-- CURRENT STATUS -->

                <div class="bg-green-50 rounded-2xl p-6 border">

                    <p class="text-gray-500">

                        Current Status

                    </p>

                    <div class="mt-4">

                        @if ($product->status === 'active')

                            <span class="bg-green-600 text-white px-4 py-2 rounded-full">

                                Active

                            </span>

                        @else

                            <span class="bg-red-600 text-white px-4 py-2 rounded-full">

                                Inactive

                            </span>

                        @endif

                    </div>

                </div>


                <!-- LAST UPDATED -->

                <div class="bg-blue-50 rounded-2xl p-6 border">

                    <p class="text-gray-500">

                        Last Updated

                    </p>

                    <p class="mt-3 font-bold text-lg">

                        {{ $product->updated_at ? $product->updated_at->format('F d, Y h:i A') : 'N/A' }}

                    </p>

                </div>

            </div>

        </div>


        <!-- ========================= -->
        <!-- ACTION BUTTONS -->
        <!-- ========================= -->

        <div class="flex justify-end gap-4 mt-10">


            <!-- CANCEL -->

            <a

                href="{{ url('/inventory') }}"

                class="px-6 py-3 rounded-xl bg-gray-300 hover:bg-gray-400 transition">

                Cancel

            </a>


            <!-- SAVE -->

            <button

                type="submit"

                class="px-8 py-3 rounded-xl bg-indigo-700 hover:bg-indigo-800 text-white font-semibold shadow-lg transition hover:scale-105">

                💾 Save Changes

            </button>

        </div>

    </form>

</main>
```

</div>

<!-- ========================= -->

<!-- CONFIRMATION MODAL -->

<!-- ========================= -->

<div

```
id="confirmModal"

class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">


<div class="bg-white rounded-2xl shadow-2xl w-[420px] p-7 animate-popup">


    <div class="flex justify-center">

        <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center">

            <svg xmlns="http://www.w3.org/2000/svg"

                 class="w-10 h-10 text-blue-600"

                 fill="none"

                 viewBox="0 0 24 24"

                 stroke="currentColor">

                <path

                    stroke-linecap="round"

                    stroke-linejoin="round"

                    stroke-width="2"

                    d="M5 13l4 4L19 7"/>

            </svg>

        </div>

    </div>


    <h2 class="text-2xl font-bold text-center mt-5">

        Save Changes?

    </h2>


    <p class="text-center text-gray-600 mt-3">

        This will update the selected product information.

    </p>


    <div class="flex justify-center gap-4 mt-8">


        <button

            type="button"

            id="cancelBtn"

            class="px-6 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 transition">

            Cancel

        </button>


        <button

            type="button"

            id="confirmBtn"

            class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition">

            Update

        </button>

    </div>

</div>
```

</div>

<!-- ========================= -->

<!-- JAVASCRIPT -->

<!-- ========================= -->

<script>

    const form = document.getElementById("editForm");

    const modal = document.getElementById("confirmModal");

    const confirmBtn = document.getElementById("confirmBtn");

    const cancelBtn = document.getElementById("cancelBtn");


    // Show confirmation modal

    form.addEventListener("submit", function (e) {

        e.preventDefault();

        modal.classList.remove("hidden");

        modal.classList.add("flex");

    });


    // Cancel modal

    cancelBtn.addEventListener("click", function () {

        modal.classList.add("hidden");

        modal.classList.remove("flex");

    });


    // Confirm update

    confirmBtn.addEventListener("click", function () {

        modal.classList.add("hidden");

        modal.classList.remove("flex");

        form.submit();

    });


    // Close modal when clicking outside

    modal.addEventListener("click", function (e) {

        if (e.target === modal) {

            modal.classList.add("hidden");

            modal.classList.remove("flex");

        }

    });


    // Live stock preview

    const stockInput = document.getElementById("stockInput");

    const stockPreview = document.getElementById("stockPreview");


    stockInput.addEventListener("input", function () {

        stockPreview.textContent = this.value || 0;

    });

</script>

</body>

</html>
