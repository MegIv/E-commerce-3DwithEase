<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shop Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <form action="{{ route('shop.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" placeholder="Search products..." class="w-full border-gray-300 rounded-md focus:border-[#FF6B00] focus:ring-[#FF6B00]">
                    <button type="submit" class="bg-[#FF6B00] text-white px-6 py-2 rounded-md font-bold hover:bg-[#e65100]">Search</button>
                </form>
            </div>

            @if($products->isEmpty())
                <p class="text-center text-gray-500">No products found.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition group">
                        <div class="h-48 bg-gray-100 relative overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-[#FF6B00] font-bold uppercase mb-1">{{ $product->category->name ?? 'General' }}</p>
                            <h3 class="font-bold text-lg text-gray-900 mb-1 truncate">{{ $product->name }}</h3>
                            <p class="text-gray-500 text-sm mb-4">Store: {{ $product->store->name ?? 'Unknown' }}</p>
                            
                            <div class="flex items-center justify-between">
                                <span class="font-mono font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                <a href="{{ route('shop.show', $product->id) }}" class="text-sm text-[#FF6B00] hover:underline">View Details &rarr;</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>