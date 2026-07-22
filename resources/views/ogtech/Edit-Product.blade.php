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
    </style>
</head>

<body>

<div class="min-h-screen">

    <!-- Navbar -->
    <header class="bg-[#1f3b99] text-white h-14 flex items-center justify-between px-6 shadow">

        <h1 class="font-semibold text-lg">
            OG TECH | Admin Panel
        </h1>

        <div class="flex items-center gap-4">

            <div class="w-10 h-10 rounded-full bg-white text-[#1f3b99] flex items-center justify-center font-bold">
                U
            </div>

        </div>

    </header>



    <main class="max-w-7xl mx-auto p-8">

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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Card -->

                <div class="lg:col-span-2 bg-white rounded-xl border p-6 shadow-sm">

                    <h3 class="font-semibold text-xl mb-6">
                        Product Information
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6">

                        <div>
                            <label class="font-medium">Product Name</label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $product->name) }}"
                                class="w-full mt-2 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="font-medium">Status</label>

                            <select
                                name="status"
                                class="w-full mt-2 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">

                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>
                        </div>

                        <div>
                            <label class="font-medium">Category</label>

                            <select
                                name="category_id"
                                class="w-full mt-2 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">

                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>



                <!-- Right Card -->

                <div class="bg-white rounded-xl border p-6 shadow-sm">

                    <h3 class="font-semibold text-xl mb-6">
                        Product Details
                    </h3>

                    <label class="font-medium">
                        Product Image
                    </label>

                    <label class="mt-3 border-2 border-dashed rounded-lg h-52 flex items-center justify-center cursor-pointer hover:bg-gray-50">

                        <input
                            type="file"
                            name="image"
                            class="hidden">

                        <span class="text-gray-400">
                            Upload Image
                        </span>

                    </label>


                    <div class="mt-6 space-y-4">

                        <div>

                            <label class="font-medium">
                                Selling Price
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="price"
                                value="{{ old('price', $product->price) }}"
                                class="w-full mt-2 border rounded-lg px-4 py-2">

                        </div>

                        <div>

                            <label class="font-medium">
                                Cost Price
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="cost"
                                value="{{ old('cost', $product->cost) }}"
                                class="w-full mt-2 border rounded-lg px-4 py-2">

                        </div>

                        <div>

                            <label class="font-medium">
                                Stock Quantity
                            </label>

                            <input
                                type="number"
                                name="stock_quantity"
                                value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                class="w-full mt-2 border rounded-lg px-4 py-2">

                        </div>

                    </div>

                </div>

            </div>



            <!-- Buttons -->

            <div class="flex justify-end gap-4 mt-8">

                <a href="{{ route('products.index') }}"
                    class="px-6 py-2 rounded-lg border hover:bg-gray-100">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-8 py-2 rounded-lg">
                    Save Product
                </button>

            </div>

        </form>

    </main>

</div>

</body>
</html>