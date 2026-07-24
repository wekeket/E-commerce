@extends('layouts.app')

@section('content')
<div x-data="{ 
    showPendingModal: false, 
    showEditModal: false, 
    showSyncModal: false,
    showViewModal: false,
    showCustomersModal: false,
    showAvgOrderModal: false,
    showRevenueModal: false,
    showIncomeModal: false,
    filterPlatform: 'All Platforms',
    filterStatus: 'All Status',
    searchQuery: '',
    selectedUser: { email: '', platform: '', receipt: '', method: '', amount: '', status: '', errorReason: '' },
    incomeDetail: { gateway: '', total: '', percent: 0, transactions: '', volumeBar: '' },
    customers: [
        { email: 'kristel@gmail.com', plat: 'Shopify', id: 'TXN-9021', method: 'GCash', amount: '₱4,600.00', stat: 'Verified' },
        { email: 'chloeSantos@outlook.com', plat: 'Lazada', id: 'TXN-5529', method: 'Card', amount: '₱12,450.00', stat: 'Verified' },
        { email: 'elena.reyes@yahoo.com', plat: 'Shopify', id: 'TXN-8841', method: 'COD', amount: '₱850.00', stat: 'Verified' },
        { email: 'marvs_02@gmail.com', plat: 'Amazon', id: 'TXN-0021', method: 'Paypal', amount: '₱2,980.00', stat: 'Verified' },
        { email: 'john123@gmail.com', plat: 'Lazada', id: 'TXN-1122', method: 'Maya', amount: '₱120.00', stat: 'Failed', errorReason: 'Error: Maya payment amount doesn\'t match the checkout price.' },
        { email: 'joshua@yahoo.com', plat: 'Shopify', id: 'TXN-3344', method: 'Maya', amount: '₱475.00', stat: 'Pending', errorReason: 'Pending: Waiting for Maya confirmation webhook response.' },
        { email: 'matthewss@gmail.com', plat: 'Lazada', id: 'TXN-5567', method: 'Card', amount: '₱650.00', stat: 'Verified' },
        { email: 'jeremy@yahoo.com', plat: 'Shopify', id: 'TXN-7788', method: 'Paypal', amount: '₱1,520.00', stat: 'Verified' },
        { email: 'john_doe@gmail.com', plat: 'Amazon', id: 'TXN-9900', method: 'Cash', amount: '₱4,750.00', stat: 'Verified' },
    ],
    editingCustomer: null,
    editSnapshot: null,
    openEdit(customer) {
        this.editSnapshot = JSON.parse(JSON.stringify(customer));
        this.editingCustomer = customer;
        this.showEditModal = true;
    },
    cancelEdit() {
        if (this.editingCustomer && this.editSnapshot) {
            Object.assign(this.editingCustomer, this.editSnapshot);
        }
        this.showEditModal = false;
    },
    saveEdit() {
        // TODO: replace with a real backend call, e.g.
        // fetch(`/customers/${this.editingCustomer.id}`, { method: 'PUT', body: JSON.stringify(this.editingCustomer) })
        this.showEditModal = false;
    }
}">

    <!-- FRAME TOPBAR REGION -->
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#1e3a8a] to-blue-600 tracking-tight">Customers and Payments</h1>
            <p class="text-xs text-gray-400 font-medium mt-1">Manage client transactions and track platform revenue</p>
        </div>
        <button @click="showSyncModal = true" class="bg-gradient-to-r from-[#00c853] to-emerald-600 hover:from-emerald-500 hover:to-emerald-700 text-white font-bold text-xs px-4 py-2 rounded-lg transition-all duration-300 shadow-[0_4px_15px_rgba(0,200,83,0.3)] hover:shadow-[0_6px_20px_rgba(0,200,83,0.4)] hover:-translate-y-0.5 flex items-center space-x-2">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            <span>Update List</span>
        </button>
    </div>

    <!-- METRIC CARDS TRACK (WITH MINI CHARTS) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
        <!-- CARD 1: Total Customers -->
        <div @click="showCustomersModal = true" class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.04)] border border-slate-100 cursor-pointer hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-900/10 transition-all duration-300 relative overflow-hidden group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 group-hover:text-blue-600 transition-colors uppercase tracking-wider">Total Customers</p>
                    <div class="flex items-baseline space-x-2 mt-1.5">
                        <span class="text-3xl font-extrabold text-gray-900 tracking-tight">3,229</span>
                        <span class="text-[10px] font-bold text-[#00c853] bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">+5.2%</span>
                    </div>
                </div>
                <!-- Mini Bar Chart Graphic -->
                <div class="flex items-end space-x-1 h-8 opacity-60 group-hover:opacity-100 transition-opacity">
                    <div class="w-1.5 bg-blue-100 h-1/4 rounded-t-sm"></div>
                    <div class="w-1.5 bg-blue-200 h-2/4 rounded-t-sm"></div>
                    <div class="w-1.5 bg-blue-400 h-3/4 rounded-t-sm"></div>
                    <div class="w-1.5 bg-[#1e3a8a] h-full rounded-t-sm"></div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400 to-[#1e3a8a] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
        </div>

        <!-- CARD 2: AVG Order Value -->
        <div @click="showAvgOrderModal = true" class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.04)] border border-slate-100 cursor-pointer hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-900/10 transition-all duration-300 relative overflow-hidden group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 group-hover:text-[#00c853] transition-colors uppercase tracking-wider">AVG Order Value</p>
                    <div class="flex items-baseline space-x-2 mt-1.5">
                        <span class="text-3xl font-extrabold text-gray-900 tracking-tight">₱24.5K</span>
                        <span class="text-[10px] font-bold text-[#00c853] bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">+3.2%</span>
                    </div>
                </div>
                <!-- Mini Line Trend Graphic -->
                <svg class="w-10 h-8 text-emerald-400 opacity-60 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-300 to-[#00c853] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
        </div>

        <!-- CARD 3: Total Revenue -->
        <div @click="showRevenueModal = true" class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.04)] border border-slate-100 cursor-pointer hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-900/10 transition-all duration-300 relative overflow-hidden group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 group-hover:text-indigo-600 transition-colors uppercase tracking-wider">Total Revenue</p>
                    <div class="flex items-baseline space-x-2 mt-1.5">
                        <span class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-indigo-800 tracking-tight">₱148.6K</span>
                        <span class="text-[10px] font-bold text-[#00c853] bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">+11%</span>
                    </div>
                </div>
                <!-- Mini Area Chart Graphic -->
                 <div class="flex items-end space-x-0.5 h-8 opacity-50 group-hover:opacity-100 transition-opacity">
                    <div class="w-2 bg-indigo-100 h-1/3"></div>
                    <div class="w-2 bg-indigo-200 h-2/3"></div>
                    <div class="w-2 bg-indigo-300 h-1/2"></div>
                    <div class="w-2 bg-indigo-400 h-5/6"></div>
                    <div class="w-2 bg-indigo-600 h-full"></div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-400 to-purple-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
        </div>

        <!-- CARD 4: Pending Payments -->
        <div @click="showPendingModal = true" class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.04)] border border-slate-100 cursor-pointer hover:-translate-y-1 hover:shadow-[0_10px_25px_rgba(249,115,22,0.15)] transition-all duration-300 relative overflow-hidden group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 group-hover:text-orange-500 transition-colors uppercase tracking-wider">Pending Payments</p>
                    <div class="flex items-baseline space-x-3 mt-1.5">
                        <span class="text-3xl font-extrabold text-orange-500 tracking-tight">3</span>
                        <span class="text-[9px] font-black text-white bg-gradient-to-r from-orange-400 to-red-500 px-2.5 py-1 rounded-md shadow-sm uppercase tracking-wide animate-pulse">Action Needed</span>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-orange-400 to-red-500"></div>
        </div>
    </div>

    <!-- FUNCTIONAL FILTER BAR BLOCK -->
    <div class="bg-white p-2.5 rounded-2xl border border-slate-100 shadow-[0_4px_15px_rgba(0,0,0,0.03)] mb-6 flex flex-col md:flex-row md:items-center justify-between gap-3 relative z-10">
        <div class="relative flex-1">
            <input x-model="searchQuery" type="text" placeholder="Search customer name, email, or transaction ID..." class="w-full bg-slate-50 border-none text-xs rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#00c853]/40 focus:bg-white transition-all shadow-inner text-slate-700 font-medium">
            <svg class="absolute left-3.5 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <div class="flex items-center space-x-2">
            <select x-model="filterPlatform" class="bg-slate-50 border-none text-xs font-medium rounded-xl px-4 py-2.5 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:bg-white cursor-pointer transition-all shadow-sm hover:bg-slate-100">
                <option value="All Platforms">🚀 All Platforms</option>
                <option value="Shopify">🛍️ Shopify</option>
                <option value="Lazada">🛒 Lazada</option>
                <option value="Amazon">📦 Amazon</option>
            </select>
            <select x-model="filterStatus" class="bg-slate-50 border-none text-xs font-medium rounded-xl px-4 py-2.5 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:bg-white cursor-pointer transition-all shadow-sm hover:bg-slate-100">
                <option value="All Status">📊 All Status</option>
                <option value="Verified">✅ Verified</option>
                <option value="Pending">⏳ Pending</option>
                <option value="Failed">❌ Failed</option>
            </select>
        </div>
    </div>

    <!-- MAIN GRID CONTAINER -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- MAIN DATA TABLE HUB -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-gradient-to-b from-white to-slate-50/50">
                <h3 class="font-extrabold text-[#1e3a8a] text-sm uppercase tracking-wider flex items-center space-x-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>Customer Info & Payment History</span>
                </h3>
            </div>
            
            <div class="overflow-x-auto min-h-[400px]">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#1e3a8a] to-[#2a4365] text-white font-semibold">
                            <th class="p-3.5 pl-5 rounded-tl-lg">Customer Info</th>
                            <th class="p-3.5">Platform</th>
                            <th class="p-3.5">Receipt ID</th>
                            <th class="p-3.5">Pymnt Met.</th>
                            <th class="p-3.5">Amount</th>
                            <th class="p-3.5">Payment Status</th>
                            <th class="p-3.5 text-center pr-5 rounded-tr-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-[11px] font-medium text-slate-700">

                        <template x-for="customer in customers" :key="customer.id">
                            <tr x-show="(filterPlatform === 'All Platforms' || filterPlatform === customer.plat) && (filterStatus === 'All Status' || filterStatus === customer.stat) && (searchQuery === '' || customer.email.toLowerCase().includes(searchQuery.toLowerCase()) || customer.id.toLowerCase().includes(searchQuery.toLowerCase()))"
                                x-transition
                                :class="customer.stat === 'Failed' ? 'bg-red-50/20 hover:bg-red-50/60 hover:shadow-[inset_4px_0_0_#ef4444]' : (customer.stat === 'Pending' ? 'bg-orange-50/20 hover:bg-orange-50/60 hover:shadow-[inset_4px_0_0_#f97316]' : 'hover:bg-blue-50/40 hover:shadow-[inset_4px_0_0_#3b82f6]')"
                                class="transition-all duration-200 group">
                                <td class="p-3.5 pl-5 font-bold transition-colors" :class="customer.stat === 'Failed' ? 'text-red-900 group-hover:text-red-600' : (customer.stat === 'Pending' ? 'text-orange-900 group-hover:text-orange-600' : 'text-blue-900 group-hover:text-blue-600')" x-text="customer.email"></td>
                                <td class="p-3.5"><span class="bg-slate-100 text-slate-600 px-2 py-1 rounded-md font-semibold" x-text="customer.plat"></span></td>
                                <td class="p-3.5 text-gray-400 font-mono" x-text="customer.id"></td>
                                <td class="p-3.5 font-semibold text-slate-600" x-text="customer.method"></td>
                                <td class="p-3.5 font-extrabold text-slate-900" x-text="customer.amount"></td>
                                <td class="p-3.5">
                                    <span class="text-[10px] px-2.5 py-0.5 rounded-full font-bold shadow-sm border"
                                          :class="customer.stat === 'Verified' ? 'bg-gradient-to-r from-emerald-100 to-emerald-50 text-emerald-700 border-emerald-200' : (customer.stat === 'Pending' ? 'bg-gradient-to-r from-orange-100 to-orange-50 text-orange-700 border-orange-200' : 'bg-gradient-to-r from-red-100 to-red-50 text-red-700 border-red-200')"
                                          x-text="customer.stat"></span>
                                </td>
                                <td class="p-3.5 text-center whitespace-nowrap space-x-1.5 pr-5">
                                    <button @click="selectedUser = { email: customer.email, platform: customer.plat, receipt: customer.id, method: customer.method, amount: customer.amount, status: customer.stat, errorReason: customer.errorReason || '' }; showViewModal = true" class="inline-flex items-center bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-600 px-3 py-1.5 rounded-lg font-bold transition-all shadow-sm hover:shadow">View</button>
                                    <button @click="openEdit(customer)" class="inline-flex items-center bg-blue-50 border border-blue-100 hover:bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg font-bold transition-all shadow-sm hover:shadow">Edit</button>
                                </td>
                            </tr>
                        </template>

                        <!-- Empty State Check for Filters -->
                        <tr x-show="customers.filter(c => (filterPlatform === 'All Platforms' || filterPlatform === c.plat) && (filterStatus === 'All Status' || filterStatus === c.stat) && (searchQuery === '' || c.email.toLowerCase().includes(searchQuery.toLowerCase()) || c.id.toLowerCase().includes(searchQuery.toLowerCase()))).length === 0" x-cloak>
                            <td colspan="7" class="p-10 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="font-medium text-sm">No records match your selected filters.</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RIGHT BOARDS PANEL -->
        <div class="space-y-6">
            <!-- LIVE SALES FEED SIDEBOARD -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-[0_4px_20px_rgba(0,0,0,0.03)] relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-red-50 rounded-bl-full -z-10 opacity-50"></div>
                <h3 class="font-extrabold text-red-600 text-xs tracking-wider flex items-center mb-4">
                    <span class="relative flex h-2.5 w-2.5 mr-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-gradient-to-r from-red-600 to-red-500"></span>
                    </span>
                    <span>Live Sales Feed</span>
                </h3>
                
                <div class="space-y-3">
                    <div @click="selectedUser = { email: 'marvs_02@gmail.com', platform: 'Amazon Store', receipt: 'TXN-0021', method: 'Card', amount: '₱2,980.00', status: 'Verified', errorReason: '' }; showViewModal = true"
                         class="p-3 rounded-xl border border-slate-100 bg-gradient-to-br from-white to-slate-50 hover:to-emerald-50/50 hover:border-emerald-300 cursor-pointer shadow-sm transition-all duration-300 group flex items-center justify-between hover:shadow-md hover:-translate-y-0.5">
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="font-extrabold text-xs text-slate-900">₱2,980.00</span>
                                <span class="bg-emerald-100 text-emerald-800 text-[9px] font-bold px-2 py-0.5 rounded-full border border-emerald-200">Verified</span>
                            </div>
                            <p class="text-[10px] text-gray-500 mt-1 font-medium">marvs_02@gmail.com • Card</p>
                        </div>
                        <div class="bg-slate-100 p-1.5 rounded-lg group-hover:bg-[#00c853] group-hover:text-white text-slate-400 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>

                    <div @click="selectedUser = { email: 'kristelsantos@gmail.com', platform: 'External Pipeline', receipt: 'TXN-4089', method: 'Card', amount: '₱8,780.80', status: 'Verified', errorReason: '' }; showViewModal = true"
                         class="p-3 rounded-xl border border-slate-100 bg-gradient-to-br from-white to-slate-50 hover:to-emerald-50/50 hover:border-emerald-300 cursor-pointer shadow-sm transition-all duration-300 group flex items-center justify-between hover:shadow-md hover:-translate-y-0.5">
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="font-extrabold text-xs text-slate-900">₱8,780.80</span>
                                <span class="bg-emerald-100 text-emerald-800 text-[9px] font-bold px-2 py-0.5 rounded-full border border-emerald-200">Verified</span>
                            </div>
                            <p class="text-[10px] text-gray-500 mt-1 font-medium">kristelsantos@gmail.com • Card</p>
                        </div>
                        <div class="bg-slate-100 p-1.5 rounded-lg group-hover:bg-[#00c853] group-hover:text-white text-slate-400 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>

                    <div @click="selectedUser = { email: 'juliusdelacruz@gmail.com', platform: 'Direct App Gateway', receipt: 'TXN-1044', method: 'GCash', amount: '₱13,552.80', status: 'Verified', errorReason: '' }; showViewModal = true"
                         class="p-3 rounded-xl border border-slate-100 bg-gradient-to-br from-white to-slate-50 hover:to-emerald-50/50 hover:border-emerald-300 cursor-pointer shadow-sm transition-all duration-300 group flex items-center justify-between hover:shadow-md hover:-translate-y-0.5">
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="font-extrabold text-xs text-slate-900">₱13,552.80</span>
                                <span class="bg-emerald-100 text-emerald-800 text-[9px] font-bold px-2 py-0.5 rounded-full border border-emerald-200">Verified</span>
                            </div>
                            <p class="text-[10px] text-gray-500 mt-1 font-medium">juliusdelacruz@gmail.com • GCash</p>
                        </div>
                        <div class="bg-slate-100 p-1.5 rounded-lg group-hover:bg-[#00c853] group-hover:text-white text-slate-400 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INCOME BREAKDOWN BOARD -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <h4 class="text-xs font-extrabold text-[#1e3a8a] uppercase tracking-wider mb-1">Today's Income Breakdown</h4>
                <p class="text-[10px] text-slate-400 font-medium mb-4">Click rows to analyze active gateway volume tracks:</p>
                
                <div class="space-y-3 text-xs font-medium text-slate-700">
                    <div @click="incomeDetail = { gateway: 'GCash Digital Hub', total: '₱ 30,780.00', percent: '65%', transactions: '14 Active Webhooks', volumeBar: 'w-[65%]' }; showIncomeModal = true" 
                         class="group relative bg-slate-50 hover:bg-blue-50/80 p-3 rounded-xl cursor-pointer transition-all duration-300 border border-slate-100 hover:border-blue-200 shadow-sm hover:shadow-md overflow-hidden">
                        <div class="absolute bottom-0 left-0 h-0.5 bg-blue-400 w-[65%] opacity-50"></div>
                        <div class="flex justify-between items-center relative z-10">
                            <div class="flex items-center space-x-2.5">
                                <div class="bg-white p-1.5 rounded-lg shadow-sm">📱</div> 
                                <span class="group-hover:text-blue-700 font-semibold transition-colors">GCash Total</span>
                            </div>
                            <span class="font-extrabold text-slate-900 group-hover:scale-105 transition-transform">₱ 30,780.00</span>
                        </div>
                    </div>

                    <div @click="incomeDetail = { gateway: 'Maya Payment Terminal', total: '₱ 35,522.20', percent: '72%', transactions: '19 Active Webhooks', volumeBar: 'w-[72%]' }; showIncomeModal = true" 
                         class="group relative bg-slate-50 hover:bg-blue-50/80 p-3 rounded-xl cursor-pointer transition-all duration-300 border border-slate-100 hover:border-blue-200 shadow-sm hover:shadow-md overflow-hidden">
                        <div class="absolute bottom-0 left-0 h-0.5 bg-indigo-400 w-[72%] opacity-50"></div>
                        <div class="flex justify-between items-center relative z-10">
                            <div class="flex items-center space-x-2.5">
                                <div class="bg-white p-1.5 rounded-lg shadow-sm">💳</div> 
                                <span class="group-hover:text-indigo-700 font-semibold transition-colors">Maya Total</span>
                            </div>
                            <span class="font-extrabold text-slate-900 group-hover:scale-105 transition-transform">₱ 35,522.20</span>
                        </div>
                    </div>

                    <div @click="incomeDetail = { gateway: 'Credit Card Credit Pipeline', total: '₱ 62,887.00', percent: '88%', transactions: '42 Settled Batches', volumeBar: 'w-[88%]' }; showIncomeModal = true" 
                         class="group relative bg-slate-50 hover:bg-blue-50/80 p-3 rounded-xl cursor-pointer transition-all duration-300 border border-slate-100 hover:border-blue-200 shadow-sm hover:shadow-md overflow-hidden">
                         <div class="absolute bottom-0 left-0 h-0.5 bg-emerald-400 w-[88%] opacity-50"></div>
                        <div class="flex justify-between items-center relative z-10">
                            <div class="flex items-center space-x-2.5">
                                <div class="bg-white p-1.5 rounded-lg shadow-sm">🏦</div> 
                                <span class="group-hover:text-emerald-700 font-semibold transition-colors">Card Payments</span>
                            </div>
                            <span class="font-extrabold text-slate-900 group-hover:scale-105 transition-transform">₱ 62,887.00</span>
                        </div>
                    </div>

                    <div @click="incomeDetail = { gateway: 'Cash on Delivery (COD Lockers)', total: '₱ 19,857.30', percent: '40%', transactions: '8 Pending Dispatches', volumeBar: 'w-[40%]' }; showIncomeModal = true" 
                         class="group relative bg-slate-50 hover:bg-blue-50/80 p-3 rounded-xl cursor-pointer transition-all duration-300 border border-slate-100 hover:border-blue-200 shadow-sm hover:shadow-md overflow-hidden">
                        <div class="absolute bottom-0 left-0 h-0.5 bg-orange-400 w-[40%] opacity-50"></div>
                        <div class="flex justify-between items-center relative z-10">
                            <div class="flex items-center space-x-2.5">
                                <div class="bg-white p-1.5 rounded-lg shadow-sm">📦</div> 
                                <span class="group-hover:text-orange-700 font-semibold transition-colors">Cash on Delivery</span>
                            </div>
                            <span class="font-extrabold text-slate-900 group-hover:scale-105 transition-transform">₱ 19,857.30</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- VISUALIZATION & DATA MODALS (ENHANCED VISUALS) -->
    <!-- ========================================== -->

    <!-- CUSTOMER FILE SUMMARY HUB -->
    <div x-show="showViewModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md flex items-center justify-center z-50" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
        <div @click.away="showViewModal = false" class="bg-[#f8fafc] rounded-2xl p-6 w-full max-w-xl shadow-2xl border border-white/20">
            <div class="mb-5 flex justify-between items-start">
                <div>
                    <h3 class="font-extrabold text-[#1e3a8a] text-lg">Customer File Summary</h3>
                    <p class="text-xs text-gray-500 mt-1 font-medium">Unified overview Details</p>
                </div>
                <span :class="{'bg-emerald-100 text-emerald-800 border-emerald-200': selectedUser.status === 'Verified', 'bg-red-100 text-red-800 border-red-200': selectedUser.status === 'Failed', 'bg-amber-100 text-amber-800 border-amber-200': selectedUser.status === 'Pending'}" 
                      class="text-[11px] font-black px-3.5 py-1.5 rounded-lg shadow-sm border uppercase tracking-wider" 
                      x-text="selectedUser.status"></span>
            </div>
            
            <!-- CONDITIONAL ERROR REASON PANEL -->
            <template x-if="selectedUser.errorReason">
                <div class="mb-5 bg-white border-l-4 border-red-500 p-4 rounded-r-xl shadow-[0_4px_15px_rgba(239,68,68,0.1)]">
                    <div class="flex items-center space-x-2 mb-1.5">
                        <div class="bg-red-100 rounded-full p-1"><svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></div>
                        <span class="text-xs font-black text-red-700 uppercase tracking-wider">System Diagnostic Log</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-700 ml-7" x-text="selectedUser.errorReason"></p>
                </div>
            </template>

            <div class="flex space-x-6 border-b border-gray-200 text-xs font-bold pb-0 mb-5">
                <span class="text-blue-700 border-b-2 border-blue-700 pb-2 cursor-pointer">Overview</span>
                <span class="text-gray-400 hover:text-gray-600 cursor-not-allowed pb-2 transition-colors">Wallet History</span>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <span class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Account Status</span>
                    <span class="text-sm font-extrabold text-[#1e3a8a]">Active Merchant</span>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <span class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Preferred Payment Method</span>
                    <span class="text-sm font-extrabold text-[#1e3a8a]" x-text="selectedUser.method || 'GCash/App'"></span>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <span class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Total Logged Orders</span>
                    <span class="text-sm font-extrabold text-[#1e3a8a]">24 Purchases</span>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <span class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Tracked System Returns</span>
                    <span class="text-sm font-extrabold text-emerald-600">0 Items Returned</span>
                </div>
            </div>
            <div class="bg-gradient-to-br from-[#cbd5e1] to-[#94a3b8] p-1 rounded-2xl shadow-inner">
                <div class="bg-slate-50 p-4 rounded-xl">
                    <h4 class="text-xs font-extrabold text-[#1e3a8a] mb-3">Recent Platform History</h4>
                    <table class="w-full text-left text-[11px] border-collapse bg-white rounded-lg overflow-hidden shadow-sm border border-slate-100">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#1e3a8a] to-blue-800 text-white font-semibold">
                                <th class="p-2.5">Date</th>
                                <th class="p-2.5">Platform</th>
                                <th class="p-2.5">Amount</th>
                                <th class="p-2.5">Type</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-gray-700 font-medium">
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-2.5 text-gray-500">Yesterday</td>
                                <td class="p-2.5 font-bold text-blue-700" x-text="selectedUser.platform || 'Shopify'"></td>
                                <td class="p-2.5 font-extrabold text-slate-900" x-text="selectedUser.amount || '₱4,600.00'"></td>
                                <td class="p-2.5"><span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded text-[10px] font-bold">Successful</span></td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-2.5 text-gray-500">2 weeks ago</td>
                                <td class="p-2.5 font-bold text-blue-700">Lazada</td>
                                <td class="p-2.5 font-extrabold text-slate-900">₱12,450.00</td>
                                <td class="p-2.5"><span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded text-[10px] font-bold">Successful</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button @click="showViewModal = false" class="bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs px-6 py-2.5 rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">Close Profile</button>
            </div>
        </div>
    </div>

    <!-- IMPROVED POPUP FRAME: EDIT CUSTOMER DETAILS -->
    <div x-show="showEditModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md flex items-center justify-center z-50" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
        <div @click.away="cancelEdit()" x-show="editingCustomer" class="bg-white rounded-2xl p-7 w-full max-w-md shadow-2xl border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-500 to-[#1e3a8a]"></div>
            <h2 class="text-lg font-extrabold text-[#1e3a8a] mb-5">Edit Customer Details</h2>
            <template x-if="editingCustomer">
                <div class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-wide">Customer Email / Username</label>
                        <input type="text" x-model="editingCustomer.email" placeholder="e.g. customer@email.com" class="w-full bg-slate-50 border border-slate-200 p-3 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-all shadow-inner">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-wide">Store Platform</label>
                        <input type="text" x-model="editingCustomer.plat" placeholder="e.g Lazada, Shopify, Tiktok Shop" class="w-full bg-slate-50 border border-slate-200 p-3 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-all shadow-inner">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-wide">Payment Status</label>
                        <select x-model="editingCustomer.stat" class="w-full bg-slate-50 border border-slate-200 p-3 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-all shadow-inner">
                            <option value="Verified">Verified</option>
                            <option value="Pending">Pending</option>
                            <option value="Failed">Failed</option>
                        </select>
                    </div>
                </div>
            </template>
            <div class="mt-7 flex justify-end space-x-3">
                <button @click="cancelEdit()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-5 py-2.5 rounded-xl transition-all">Cancel</button>
                <button @click="saveEdit()" class="bg-gradient-to-r from-[#00c853] to-emerald-600 hover:from-emerald-500 hover:to-emerald-700 text-white font-bold text-xs px-6 py-2.5 rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- OTHER MODALS (VISUALLY POLISHED) -->
    <div x-show="showCustomersModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50" x-cloak x-transition>
        <div @click.away="showCustomersModal = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl border border-slate-100"><h3 class="font-extrabold text-[#1e3a8a] text-base mb-1">Customer Growth & Distribution</h3><p class="text-[11px] text-gray-400 mb-5 font-medium">Live analytics sync overview data channel</p><div class="space-y-4 text-xs"><div><div class="flex justify-between mb-1.5"><span class="text-gray-500 font-semibold">Shopify Base Users</span> <span class="font-black text-slate-900">1,820</span></div><div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden shadow-inner"><div class="bg-gradient-to-r from-purple-500 to-purple-600 h-full w-[56%] rounded-full"></div></div></div><div><div class="flex justify-between mb-1.5"><span class="text-gray-500 font-semibold">Lazada Linked Nodes</span> <span class="font-black text-slate-900">945</span></div><div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden shadow-inner"><div class="bg-gradient-to-r from-orange-400 to-orange-500 h-full w-[29%] rounded-full"></div></div></div><div><div class="flex justify-between mb-1.5"><span class="text-gray-500 font-semibold">Amazon Hub Merchants</span> <span class="font-black text-slate-900">464</span></div><div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden shadow-inner"><div class="bg-gradient-to-r from-blue-400 to-blue-500 h-full w-[15%] rounded-full"></div></div></div></div><button @click="showCustomersModal = false" class="mt-6 w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-2.5 rounded-xl transition-all">Close View</button></div>
    </div>
    <div x-show="showAvgOrderModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50" x-cloak x-transition>
        <div @click.away="showAvgOrderModal = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl border border-slate-100"><h3 class="font-extrabold text-[#1e3a8a] text-base mb-1">Ticket Size Ranges</h3><p class="text-[11px] text-gray-400 mb-5 font-medium">Volume separation distribution index</p><div class="space-y-4 text-xs"><div><div class="flex justify-between mb-1.5"><span class="text-gray-500 font-semibold">High Tier ( > ₱10K )</span> <span class="font-black text-[#00c853]">42% of Sales</span></div><div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden shadow-inner"><div class="bg-gradient-to-r from-emerald-400 to-[#00c853] h-full w-[42%] rounded-full"></div></div></div><div><div class="flex justify-between mb-1.5"><span class="text-gray-500 font-semibold">Mid Tier ( ₱2K - ₱10K )</span> <span class="font-black text-indigo-600">38% of Sales</span></div><div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden shadow-inner"><div class="bg-gradient-to-r from-indigo-400 to-indigo-600 h-full w-[38%] rounded-full"></div></div></div><div><div class="flex justify-between mb-1.5"><span class="text-gray-500 font-semibold">Low Tier ( < ₱2K )</span> <span class="font-black text-amber-500">20% of Sales</span></div><div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden shadow-inner"><div class="bg-gradient-to-r from-amber-400 to-amber-500 h-full w-[20%] rounded-full"></div></div></div></div><button @click="showAvgOrderModal = false" class="mt-6 w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-2.5 rounded-xl transition-all">Close View</button></div>
    </div>
    <div x-show="showRevenueModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50" x-cloak x-transition>
        <div @click.away="showRevenueModal = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl border border-slate-100"><h3 class="font-extrabold text-[#1e3a8a] text-base mb-1">Pipeline Tracking Integrity</h3><p class="text-[11px] text-gray-400 mb-5 font-medium">Financial clearance buffer parameters</p><div class="space-y-3 text-xs"><div class="flex justify-between items-center p-3 bg-gradient-to-r from-emerald-50 to-white border border-emerald-100 text-emerald-800 rounded-xl shadow-sm"><span class="font-semibold">Settled Gross Volume</span><span class="font-black text-sm">₱148,600.00</span></div><div class="flex justify-between items-center p-3 bg-gradient-to-r from-amber-50 to-white border border-amber-100 text-amber-800 rounded-xl shadow-sm"><span class="font-semibold">Held Validation Buffer</span><span class="font-black text-sm">₱5,195.00</span></div><div class="flex justify-between items-center p-3 bg-gradient-to-r from-red-50 to-white border border-red-100 text-red-800 rounded-xl shadow-sm"><span class="font-semibold">Rejected/Flagged Drops</span><span class="font-black text-sm">₱120.00</span></div></div><button @click="showRevenueModal = false" class="mt-6 w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-2.5 rounded-xl transition-all">Close View</button></div>
    </div>
    <div x-show="showIncomeModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50" x-cloak x-transition>
        <div @click.away="showIncomeModal = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl border border-slate-100"><div class="flex items-center space-x-2 mb-1"><span class="text-xl bg-blue-50 p-2 rounded-lg">📊</span><h3 class="font-extrabold text-[#1e3a8a] text-base" x-text="incomeDetail.gateway"></h3></div><p class="text-[11px] text-gray-400 mb-5 font-medium ml-11">Real-time infrastructure channel tracking</p><div class="space-y-4 text-xs bg-slate-50 p-4 rounded-xl border border-slate-100 shadow-inner"><div class="flex justify-between items-center border-b border-slate-200 pb-2"><span class="text-gray-500 font-semibold">Captured Value:</span> <span class="font-black text-lg text-slate-900" x-text="incomeDetail.total"></span></div><div class="flex justify-between items-center"><span class="text-gray-500 font-semibold">Active Streams:</span> <span class="font-bold text-slate-700 bg-white px-2 py-1 rounded shadow-sm border border-slate-100" x-text="incomeDetail.transactions"></span></div><div><div class="flex justify-between mb-1.5"><span class="text-gray-500 font-semibold">Gateway Efficiency Load</span> <span class="font-black text-blue-600" x-text="incomeDetail.percent"></span></div><div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden shadow-inner"><div class="bg-gradient-to-r from-blue-500 to-blue-600 h-full transition-all duration-700 ease-out rounded-full" :class="incomeDetail.volumeBar"></div></div></div></div><button @click="showIncomeModal = false" class="mt-5 w-full bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs py-2.5 rounded-xl transition-all shadow-lg hover:-translate-y-0.5">Acknowledge Track</button></div>
    </div>
    <div x-show="showSyncModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md flex items-center justify-center z-50" x-cloak x-transition>
        <div @click.away="showSyncModal = false" class="bg-white rounded-3xl p-8 w-full max-w-xs text-center shadow-2xl border border-slate-100 relative overflow-hidden"><div class="absolute top-0 left-0 w-full h-2 bg-[#00c853]"></div><div class="mx-auto w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-4 shadow-inner"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div><h2 class="text-xl font-extrabold text-slate-800 tracking-tight">System Synced!</h2><p class="text-xs text-gray-500 mt-2 font-medium leading-relaxed">All incoming payments have been successfully updated to the latest nodes.</p><button @click="showSyncModal = false" class="mt-6 w-full bg-gradient-to-r from-[#00c853] to-emerald-600 hover:from-emerald-500 hover:to-emerald-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition-all shadow-lg hover:-translate-y-0.5">Excellent</button></div>
    </div>
    <div x-show="showPendingModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md flex items-center justify-center z-50" x-cloak x-transition>
        <div @click.away="showPendingModal = false" class="bg-[#f8fafc] rounded-2xl p-6 w-full max-w-xl shadow-2xl border border-white/20"><div class="flex justify-between items-center mb-2"><h2 class="text-lg font-extrabold text-orange-700 flex items-center space-x-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg><span>Action Required Logs</span></h2><span class="bg-orange-100 text-orange-700 border border-orange-200 font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wide shadow-sm">3 Issues Found</span></div><p class="text-[11px] text-gray-500 mb-5 font-medium">Transactions that experienced checkout delay, wrong references, or timed out gateway payments.</p><div class="space-y-3"><div class="bg-white border-l-4 border-red-500 p-3.5 rounded-r-xl flex justify-between items-center shadow-[0_2px_10px_rgba(0,0,0,0.03)] hover:shadow-md transition-shadow"><div class="flex-1"><p class="font-extrabold text-xs text-slate-900">TXN-5522 (john doe)</p><p class="text-[11px] text-gray-500 mt-1 pr-2 font-medium">Error: Maya payment amount doesn't match the checkout price.</p></div><span class="bg-red-50 text-red-600 text-[10px] font-black px-2.5 py-1 rounded border border-red-100 uppercase shadow-sm">Error</span></div><div class="bg-white border-l-4 border-orange-400 p-3.5 rounded-r-xl flex justify-between items-center shadow-[0_2px_10px_rgba(0,0,0,0.03)] hover:shadow-md transition-shadow"><div class="flex-1"><p class="font-extrabold text-xs text-slate-900">TXN-1122 (Jason)</p><p class="text-[11px] text-gray-500 mt-1 pr-2 font-medium">Pending: Waiting for GCash confirmation webhook.</p></div><span class="bg-orange-50 text-orange-600 text-[10px] font-black px-2.5 py-1 rounded border border-orange-100 uppercase shadow-sm">Pending</span></div><div class="bg-white border-l-4 border-orange-400 p-3.5 rounded-r-xl flex justify-between items-center shadow-[0_2px_10px_rgba(0,0,0,0.03)] hover:shadow-md transition-shadow"><div class="flex-1"><p class="font-extrabold text-xs text-slate-900">TXN-1178 (marry)</p><p class="text-[11px] text-gray-500 mt-1 pr-2 font-medium">Pending: Waiting for rider acceptance or dispatch.</p></div><span class="bg-orange-50 text-orange-600 text-[10px] font-black px-2.5 py-1 rounded border border-orange-100 uppercase shadow-sm">Pending</span></div></div><div class="mt-6 flex justify-end"><button @click="showPendingModal = false" class="bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs px-6 py-2.5 rounded-xl transition-all shadow-lg hover:-translate-y-0.5">Close Logs</button></div></div>
    </div>

</div>
@endsection