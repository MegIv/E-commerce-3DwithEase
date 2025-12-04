<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Products') }}
            </h2>
            <!-- <div class="flex gap-4 text-sm font-medium">
                <a href="{{ route('seller.dashboard') }}" class="text-gray-500 hover:text-[#FF6B00] transition">Overview</a>
                <a href="{{ route('seller.products.index') }}" class="text-[#FF6B00] border-b-2 border-[#FF6B00]">My Products</a>
                <a href="{{ route('seller.store.edit') }}" class="text-gray-500 hover:text-[#FF6B00] transition">Store Settings</a>
            </div> -->
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('seller.products.create') }}" class="bg-[#FF6B00] text-white px-4 py-2 rounded-md font-bold text-sm hover:bg-[#e65100] transition">
                            + Add Product
                        </a>
                    </div>

                    @if($products->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            You haven't added any products yet.
                        </div>
                    @else
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-500 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Image</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Category</th>
                                    <th class="px-4 py-3">Price</th>
                                    <th class="px-4 py-3">Stock</th>
                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        @if($product->image)
                                                <img src="{{ '/Storage/'. $product->image }}" class="w-12 h-12 object-cover rounded" loading="lazy" alt="{{ $product->name }}">
                                            @else
                                                <div class="w-12 h-12 bg-gray-100 rounded"></div>
                                            @endif
                                            <!-- <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center text-xs">No Img</div> -->
                                        
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $product->name }}</td>
                                    <td class="px-4 py-3">{{ $product->category->name }}</td>
                                    <td class="px-4 py-3 font-mono text-[#FF6B00]">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">{{ $product->stock }}</td>
                                    <td class="px-4 py-3 text-right flex justify-end gap-2">
                                        <a href="{{ route('seller.products.edit', $product->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">{{ $products->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>