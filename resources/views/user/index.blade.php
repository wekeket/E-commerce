<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechHub</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

<!-- Top Navbar -->
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-center h-16">

            <div class="flex items-center space-x-8">

                <h1 class="text-3xl font-bold text-blue-600">
                    TechHub
                </h1>

                <a href="#" class="font-medium hover:text-blue-600">Home</a>
                <a href="#" class="font-medium hover:text-blue-600">Products</a>
                <a href="#" class="font-medium hover:text-blue-600">Categories</a>
                <a href="#" class="font-medium hover:text-blue-600">Deals</a>

            </div>

            <div class="flex items-center space-x-5">

                <input
                    type="text"
                    placeholder="Search Products..."
                    class="border rounded-lg px-4 py-2 w-72 focus:ring-2 focus:ring-blue-500 outline-none">

                <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                    Search
                </button>

                <button>❤️</button>
                <button>🛒</button>

                <button
                    class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-black">
                    Login
                </button>

            </div>

        </div>

    </div>
</nav>

<!-- Hero -->

<section class="bg-gradient-to-r from-blue-700 to-blue-500">

<div class="max-w-7xl mx-auto px-6 py-24">

<div class="grid lg:grid-cols-2 gap-10 items-center">

<div>

<h1 class="text-5xl font-bold text-white leading-tight">

Build Your Dream PC

</h1>

<p class="text-blue-100 mt-6 text-lg">

Shop authentic processors, graphics cards,
motherboards, RAM, SSDs and accessories
at unbeatable prices.

</p>

<div class="mt-8 flex gap-4">

<button class="bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">

Shop Now

</button>

<button class="border border-white text-white px-6 py-3 rounded-lg hover:bg-white hover:text-blue-600">

View Deals

</button>

</div>

</div>

<div>

<img
src="https://images.unsplash.com/photo-1587202372775-e229f172b9d7"
class="rounded-xl shadow-2xl">

</div>

</div>

</div>

</section>

<!-- Categories -->

<section class="max-w-7xl mx-auto py-16 px-6">

<h2 class="text-3xl font-bold mb-8">

Shop By Category

</h2>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">

<div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-xl cursor-pointer">

💻

<p class="mt-3 font-semibold">

Processors

</p>

</div>

<div class="bg-white rounded-xl shadow p-6 text-center">

🎮

<p class="mt-3 font-semibold">

Graphics Cards

</p>

</div>

<div class="bg-white rounded-xl shadow p-6 text-center">

🖥️

<p class="mt-3 font-semibold">

Motherboards

</p>

</div>

<div class="bg-white rounded-xl shadow p-6 text-center">

💾

<p class="mt-3 font-semibold">

Storage

</p>

</div>

<div class="bg-white rounded-xl shadow p-6 text-center">

⚡

<p class="mt-3 font-semibold">

Power Supply

</p>

</div>

<div class="bg-white rounded-xl shadow p-6 text-center">

🎧

<p class="mt-3 font-semibold">

Accessories

</p>

</div>

</div>

</section>

<!-- Featured Products -->

<section class="max-w-7xl mx-auto px-6 pb-20">

<div class="flex justify-between items-center mb-8">

<h2 class="text-3xl font-bold">

Featured Products

</h2>

<a href="#" class="text-blue-600 font-semibold">

View All →

</a>

</div>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

<!-- Product -->

<div class="bg-white rounded-xl shadow hover:shadow-xl overflow-hidden">

<img
src="https://images.unsplash.com/photo-1591799265444-d66432b91588"
class="h-52 w-full object-cover">

<div class="p-5">

<h3 class="font-bold">

AMD Ryzen 7 7700X

</h3>

<p class="text-gray-500 mt-2">

8-Core Processor

</p>

<p class="text-2xl font-bold text-blue-600 mt-4">

$329

</p>

<button
class="w-full mt-5 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">

Add to Cart

</button>

</div>

</div>

<!-- Duplicate this card -->

<div class="bg-white rounded-xl shadow hover:shadow-xl overflow-hidden">

<img
src="https://images.unsplash.com/photo-1587202372775-e229f172b9d7"
class="h-52 w-full object-cover">

<div class="p-5">

<h3 class="font-bold">

RTX 4070 SUPER

</h3>

<p class="text-gray-500 mt-2">

Graphics Card

</p>

<p class="text-2xl font-bold text-blue-600 mt-4">

$599

</p>

<button
class="w-full mt-5 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">

Add to Cart

</button>

</div>

</div>

<div class="bg-white rounded-xl shadow hover:shadow-xl overflow-hidden">

<img
src="https://images.unsplash.com/photo-1611078489935-0cb964de46d6"
class="h-52 w-full object-cover">

<div class="p-5">

<h3 class="font-bold">

Corsair Vengeance 32GB

</h3>

<p class="text-gray-500 mt-2">

DDR5 RAM

</p>

<p class="text-2xl font-bold text-blue-600 mt-4">

$149

</p>

<button
class="w-full mt-5 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">

Add to Cart

</button>

</div>

</div>

<div class="bg-white rounded-xl shadow hover:shadow-xl overflow-hidden">

<img
src="https://images.unsplash.com/photo-1591488320449-011701bb6704"
class="h-52 w-full object-cover">

<div class="p-5">

<h3 class="font-bold">

Samsung 990 Pro SSD

</h3>

<p class="text-gray-500 mt-2">

2TB NVMe

</p>

<p class="text-2xl font-bold text-blue-600 mt-4">

$199

</p>

<button
class="w-full mt-5 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">

Add to Cart

</button>

</div>

</div>

</div>

</section>

<footer class="bg-gray-900 text-white py-10">

<div class="max-w-7xl mx-auto px-6">

<div class="grid md:grid-cols-4 gap-8">

<div>

<h3 class="font-bold text-xl">

TechHub

</h3>

<p class="mt-3 text-gray-400">

Build your dream PC with trusted hardware.

</p>

</div>

<div>

<h3 class="font-bold">

Customer Service

</h3>

<ul class="mt-3 space-y-2 text-gray-400">

<li>Contact Us</li>

<li>Returns</li>

<li>Shipping</li>

</ul>

</div>

<div>

<h3 class="font-bold">

Information

</h3>

<ul class="mt-3 space-y-2 text-gray-400">

<li>About</li>

<li>Privacy</li>

<li>Terms</li>

</ul>

</div>

<div>

<h3 class="font-bold">

Newsletter

</h3>

<input
class="mt-4 w-full rounded-lg p-3 text-black"
placeholder="Email Address">

<button
class="mt-3 w-full bg-blue-600 py-3 rounded-lg hover:bg-blue-700">

Subscribe

</button>

</div>

</div>

</div>

</footer>

</body>
</html>