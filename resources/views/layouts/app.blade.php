<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bautista - Customers & Payment v3</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#eaeef3] font-sans antialiased text-gray-800">
    
    <div x-data="{ sidebarOpen: true }" class="flex h-screen overflow-hidden">
        
        <aside :class="sidebarOpen ? 'w-[260px]' : 'w-20'" class="bg-gradient-to-b from-[#1e3a8a] via-[#0f172a] to-[#070a13] text-slate-300 transition-all duration-300 flex flex-col z-20 shadow-xl">
            
            <div class="p-5 flex flex-col space-y-4">
                <div class="flex items-center justify-between">
                    <div x-show="sidebarOpen" class="flex items-center space-x-2 font-bold text-xl text-white tracking-wide">
                        <span class="text-[#00c853] text-2xl font-black">㈠</span> <span>OG TECH</span>
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white hover:text-[#00c853] transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <div x-show="sidebarOpen" class="relative">
                    <input type="text" placeholder="Search..." class="w-full bg-white/90 text-gray-800 placeholder-gray-400 text-xs rounded-full px-4 py-2 focus:outline-none shadow-inner">
                    <span class="absolute right-3 top-2 text-gray-400 text-xs">🔍</span>
                </div>
            </div>

            <div class="px-3 py-2 text-[11px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Main Menu</div>
            <nav class="flex-1 px-3 space-y-1.5">
                <a href="#" class="flex items-center px-4 py-2.5 hover:bg-white/10 rounded-lg text-sm text-slate-300 transition">
                    <span class="text-base">🎛️</span> <span x-show="sidebarOpen" class="ml-3 font-medium">Dashboard</span>
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 hover:bg-white/10 rounded-lg text-sm text-slate-300 transition">
                    <span class="text-base">📦</span> <span x-show="sidebarOpen" class="ml-3 font-medium">Inventory</span>
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 hover:bg-white/10 rounded-lg text-sm text-slate-300 transition">
                    <span class="text-base">🛒</span> <span x-show="sidebarOpen" class="ml-3 font-medium">Orders</span>
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 hover:bg-white/10 rounded-lg text-sm text-slate-300 transition">
                    <span class="text-base">🏷️</span> <span x-show="sidebarOpen" class="ml-3 font-medium">Products</span>
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 bg-[#00c853] text-white rounded-full shadow-md">
                    <span class="text-base">💳</span> <span x-show="sidebarOpen" class="ml-3 font-semibold">Customers & Payments</span>
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 hover:bg-white/10 rounded-lg text-sm text-slate-300 transition">
                    <span class="text-base">📊</span> <span x-show="sidebarOpen" class="ml-3 font-medium">Reports</span>
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 hover:bg-white/10 rounded-lg text-sm text-slate-300 transition">
                    <span class="text-base">⚙️</span> <span x-show="sidebarOpen" class="ml-3 font-medium">Settings</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto bg-[#eaeef3] p-6">
                @yield('content')
            </main>
        </div>
        
    </div>
</body>
</html>
