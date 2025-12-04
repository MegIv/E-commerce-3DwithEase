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
            <div class="text-center py-20 bg-white rounded-lg shadow-sm">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a4 4 0 118 0v4i" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Produk tidak ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Coba kata kunci lain atau hubungi admin.</p>
            </div>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                    <div class="bg-white group rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">

                        {{-- Gambar Produk --}}
                        <div class="relative aspect-square overflow-hidden bg-gray-100">
                            @if($product->image)
                            <img src="{{ '/Storage/' . $product->image }}" alt="{{ $product->name }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300">
                            @else
                            <div class="flex items-center justify-center h-full w-full text-gray-400 bg-gray-200">
                                <span class="text-xs">No Image</span>
                            </div>
                            @endif

                            {{-- Badge Stok --}}
                            @if($product->stock <= 0)
                                <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                Habis
                        </div>
                        @elseif($product->stock < 5)
                            <div class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded">
                            Sisa {{ $product->stock }}
                    </div>
                    @endif
                    </div>

                    {{-- Info Produk --}}
                    <div class="p-4 flex-1 flex flex-col">
                        {{-- Kategori & Toko --}}
                        <div class="flex justify-between items-center text-xs text-gray-500 mb-1">
                            <span>{{ $product->category->name ?? 'Uncategorized' }}</span>
                            <span class="truncate max-w-[50%]">{{ $product->store->store_name ?? 'Store' }}</span>
                        </div>

                        {{-- Nama Produk --}}
                        <a href="{{ route('shop.show', $product) }}" class="block">
                            <h3 class="font-bold text-gray-900 text-lg mb-1 truncate hover:text-indigo-600 transition">
                                {{ $product->name }}
                            </h3>
                        </a>

                        {{-- Harga --}}
                        <div class="text-indigo-600 font-bold text-lg mb-4">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        {{-- Tombol Aksi (Sticky Bottom) --}}
                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between gap-2">

                            {{-- Tombol Detail --}}
                            <a href="{{ route('shop.show', $product) }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                                Detail
                            </a>
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