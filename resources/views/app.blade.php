<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OG TECH - Order Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans antialiased min-h-screen flex relative overflow-x-hidden">

    <button onclick="toggleSidebarMenu()" class="fixed top-4 left-4 z-50 bg-[#143695] text-white p-2.5 rounded-xl shadow-md hover:bg-[#0a1a44] transition-all cursor-pointer border border-white/10" aria-label="Toggle Navigation Menu">
        <i class="fas fa-bars text-sm"></i>
    </button>

    <div id="sidebar-backdrop" onclick="toggleSidebarMenu()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden transition-opacity"></div>

    <aside id="main-sidebar" class="fixed inset-y-0 left-0 z-50 w-[260px] bg-gradient-to-b from-[#143695] to-[#0a1a44] border-r-4 border-[#7c3aed] flex flex-col p-5 text-white shrink-0 -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl">
        
        <div class="flex items-center gap-2 px-2 py-4 mb-4">
            <div class="w-9 h-9 rounded-full border-4 border-[#00c49f] flex items-center justify-center font-bold text-lg text-[#00c49f] tracking-tighter">
                G
            </div>
            <div class="text-xl font-bold tracking-wider text-white flex items-center">
                OG <span class="font-light ml-1.5 tracking-widest text-gray-200">TECH</span>
            </div>
        </div>

        <div class="relative mb-8 px-1">
            <input type="text" placeholder="Search" class="w-full bg-white text-gray-800 placeholder-gray-400 rounded-full py-1.5 pl-4 pr-10 text-xs focus:outline-none focus:ring-2 focus:ring-[#00c49f]/50 transition-all">
            <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-[11px]"></i>
        </div>

        <div class="text-[11px] uppercase tracking-widest font-bold text-gray-300/80 px-3 mb-4">
            Main Menu
        </div>

        <nav class="flex flex-col gap-1.5 px-1">

            <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-[13px] font-bold text-gray-200 hover:bg-white/10 transition-all">
                <i class="fas fa-th-large text-center w-5 text-sm opacity-85"></i> Dashboard
            </a>

            <a href="{{ route('inventory.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-[13px] font-bold text-gray-200 hover:bg-white/10 transition-all">
                <i class="fas fa-box text-center w-5 text-sm opacity-85"></i> Inventory
            </a>

            <a href="{{ route('orders.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-r-2xl rounded-l-md text-[13px] font-bold bg-[#14b8a6] text-white shadow-sm transition-all">
                <i class="fas fa-shopping-cart text-center w-5 text-sm"></i> Orders
            </a>

            <a href="{{ route('products.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-[13px] font-bold text-gray-200 hover:bg-white/10 transition-all">
                <i class="fas fa-briefcase text-center w-5 text-sm opacity-85"></i> Products
            </a>

            <a href="{{ route('customers.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-[13px] font-bold text-gray-200 hover:bg-white/10 transition-all">
                <i class="fas fa-credit-card text-center w-5 text-sm opacity-85"></i> Customers & Payments
            </a>

            <a href="{{ route('reports') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-[13px] font-bold text-gray-200 hover:bg-white/10 transition-all">
                <i class="fas fa-chart-bar text-center w-5 text-sm opacity-85"></i> Reports
            </a>

            <a href="#" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-[13px] font-bold text-gray-200 hover:bg-white/10 transition-all">
                <i class="fas fa-cog text-center w-5 text-sm opacity-85"></i> Settings
            </a>

        </nav>
    </aside>

    <main class="flex-1 min-w-0 flex flex-col bg-[#f8fafc] pt-16 pl-16">
        @yield('content')
    </main>

    <script>
        function toggleSidebarMenu() {
            const sidebarElement = document.getElementById('main-sidebar');
            const backdropElement = document.getElementById('sidebar-backdrop');
            
            if (sidebarElement.classList.contains('-translate-x-full')) {
                sidebarElement.classList.remove('-translate-x-full');
                backdropElement.classList.remove('hidden');
            } else {
                sidebarElement.classList.add('-translate-x-full');
                backdropElement.classList.add('hidden');
            }
        }
    </script>

    @stack('scripts')
</body>
</html>