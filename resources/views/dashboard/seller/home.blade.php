<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Seller Dashboard') }}
            </h2>
            <div class="flex gap-4 text-sm font-medium">
                <a href="{{ route('seller.dashboard') }}" class="text-[#FF6B00] border-b-2 border-[#FF6B00]">Overview</a>
                <a href="{{ route('seller.products.index') }}" class="text-gray-500 hover:text-[#FF6B00] transition">My Products</a>
                <a href="{{ route('seller.orders.index') }}" class="text-gray-500 hover:text-[#FF6B00] transition">Orders</a>
                <a href="{{ route('seller.store.edit') }}" class="text-gray-500 hover:text-[#FF6B00] transition">Store Settings</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-[#FF6B00]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm uppercase">Total Products</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $productCount }}</p>
                        </div>
                        <div class="bg-orange-50 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#FF6B00]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('seller.products.create') }}" class="text-sm text-[#FF6B00] hover:underline font-medium">+ Add New Product</a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm uppercase">Incoming Orders</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $orderCount ?? 0 }}</p>
                        </div>
                        <div class="bg-blue-50 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('seller.orders.index') }}" class="text-sm text-blue-600 hover:underline font-medium">View Orders</a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-gray-800">
                    <div class="flex items-center gap-4">
                        @if(Auth::user()->store->logo)
                            <img src="{{ asset('storage/' . Auth::user()->store->logo) }}" class="w-16 h-16 rounded-full object-cover border border-gray-200">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">Logo</div>
                        @endif
                        <div>
                            <p class="text-gray-500 text-sm uppercase">Your Store</p>
                            <h3 class="text-xl font-bold text-gray-800">{{ Auth::user()->store->name }}</h3>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('seller.store.edit') }}" class="text-sm text-gray-600 hover:text-black hover:underline">Edit Store Info</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>