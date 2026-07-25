<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Poppins',sans-serif;
            background:#f5f7fb;
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

        .form-card{
            transition:.3s;
        }

        .upload-box{
            border:2px dashed #cbd1e0;
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
               class="menu-item flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">
                <span class="icon-box bg-white/20">🔲</span>
                Dashboard
            </a>

            <a href="{{ route('inventory.index') }}"
               class="menu-item flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">
                <span class="icon-box bg-blue-400/20">📦</span>
                Inventory
            </a>

            <a href="#" title="Not wired up yet"
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

            <a href="#" title="Not wired up yet"
               class="menu-item flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-gray-200 hover:bg-white/10">
                <span class="icon-box bg-slate-400/20">⚙️</span>
                Settings
            </a>

        </nav>

    </aside>
    
    <main class="flex-1 p-8">

        <h2 class="text-4xl font-bold">
            Edit Product Information
        </h2>

        <p class="text-gray-500 mb-8">
            Edit product information.
        </p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        <form action="{{ route('products.update', $product->id) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="grid lg:grid-cols-3 gap-6">

                <!-- PRODUCT INFORMATION -->
                <div class="form-card lg:col-span-2 bg-white rounded-2xl border p-6">

                    <h2 class="font-bold text-lg text-blue-950 mb-5">
                        Product Information
                    </h2>

                    <div class="grid md:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-semibold mb-1">Product Name</label>
                            <input type="text" name="name" placeholder="Name"
                                   class="w-full border rounded-lg px-3 py-2 text-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Status</label>
                            <input type="text" name="status" placeholder="On Stock, Low, etc."
                                   class="w-full border rounded-lg px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Brand</label>
                            <input type="text" name="brand" placeholder="ASUS"
                                   class="w-full border rounded-lg px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Category</label>
                            <select name="category_id" class="w-full border rounded-lg px-3 py-2 text-sm">
                                <option value="">Select category</option>
                                <option value="1">Peripherals</option>
                                <option value="2">Audio</option>
                                <option value="3">Accessories</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Supplier</label>
                            <input type="text" name="supplier" placeholder="Company Name etc."
                                   class="w-full border rounded-lg px-3 py-2 text-sm">
                        </div>

                    </div>

                    <div class="mt-5">
                        <label class="block text-sm font-semibold mb-1">Description</label>
                        <textarea name="description" rows="5"
                                  class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>
                    </div>

                </div>

                <!-- PRODUCT DETAILS -->
                <div class="form-card bg-white rounded-2xl border p-6">

                    <h2 class="font-bold text-lg text-blue-950 mb-5">
                        Product Details
                    </h2>

                    <label for="productImage"
                           class="upload-box rounded-xl h-40 flex items-center justify-center text-sm text-gray-500 mb-5 cursor-pointer text-center px-3">
                        <span id="uploadLabel">Upload Product Image</span>
                    </label>
                    <input type="file" id="productImage" name="image" accept="image/*" class="hidden">

                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1">Selling Price</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400 text-sm">₱</span>
                            <input type="number" step="0.01" name="price" placeholder="0.00"
                                   class="w-full border rounded-lg pl-7 pr-3 py-2 text-sm">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1">Cost Price</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400 text-sm">₱</span>
                            <input type="number" step="0.01" name="cost" placeholder="0.00"
                                   class="w-full border rounded-lg pl-7 pr-3 py-2 text-sm">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1">Initial Stock</label>
                        <input type="number" name="stock_quantity" placeholder="0"
                               class="w-full border rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Warehouse</label>
                        <select name="warehouse" class="w-full border rounded-lg px-3 py-2 text-sm">
                            <option>Main Warehouse</option>
                            <option>Secondary Warehouse</option>
                        </select>
                    </div>

                </div>

            </div>

            <!-- GUIDELINES + ACTIONS -->
            <div class="form-card bg-white rounded-2xl border p-6 mt-6">

                <h2 class="font-bold text-lg text-blue-950 mb-3">
                    Product Guidelines
                </h2>

                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1 mb-6">
                    <li>Appropriate Product Name.</li>
                    <li>Upload a clear product image.</li>
                    <li>Verify prices before saving.</li>
                    <li>Select the correct warehouse.</li>
                </ul>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="window.location.href='{{ route('dashboard') }}'"
                            class="border rounded-lg px-5 py-2 text-sm font-semibold hover:bg-gray-100">
                        Cancel
                    </button>

                    <button type="button" onclick="saveProduct('draft')"
                            class="border rounded-lg px-5 py-2 text-sm font-semibold hover:bg-gray-100">
                        Save Draft
                    </button>

                    <button type="submit"
                            class="bg-emerald-500 text-white rounded-lg px-6 py-2 text-sm font-semibold hover:bg-emerald-600">
                        Save Product
                    </button>
                </div>

            </div>

        </form>

    </main>

</div>

</body>
</html>