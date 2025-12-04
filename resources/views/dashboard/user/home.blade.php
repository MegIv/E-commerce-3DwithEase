<x-app-layout>
    {{-- HEADER: Judul & Search Bar --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Marketplace') }}
            </h2>

            {{-- Search Bar --}}
            <form action="{{ route('shop.index') }}" method="GET" class="w-full md:w-1/3">
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari produk 3D..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Bagian 1: Pesan Selamat Datang (Opsional - Bagus untuk UX) --}}
            @if(!request('search'))
            <div class="mb-8 bg-[#e65100] rounded-2xl p-6 text-white shadow-lg" style="background-color: #e65100;">
                <!-- <div class="mb-8 bg-gradient-to-r from-[#e65100] to-[#ff8f00] rounded-2xl p-6 text-white shadow-lg"> -->
                <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="opacity-90">Temukan aset 3D berkualitas tinggi untuk proyek kreatif Anda hari ini.</p>
            </div>
            @endif


            {{-- Bagian 2: Hasil Pencarian (Jika sedang mencari) --}}
            @if(request('search'))
            <div class="mb-6">
                <h3 class="text-lg text-gray-700">
                    Hasil pencarian untuk: <span class="font-bold">"{{ request('search') }}"</span>
                </h3>
                <a href="{{ route('shop.index') }}" class="text-sm text-indigo-600 hover:underline">Reset Pencarian</a>
            </div>
            @endif

            {{-- Bagian 3: Grid Produk --}}
            @if($products->isEmpty())
            {{-- State Kosong --}}
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

        <div class="mt-8 text-center">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Lihat Selengkapnya') }}
                
                {{-- Ikon Panah Kanan --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

    @endif
    </div>
    </div>
</x-app-layout>