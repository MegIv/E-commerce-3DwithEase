<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Bagian 1: Statistik (Kode Lama) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Kartu Produk --}}
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-[#FF6B00]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm uppercase">Total Products</p>
                            <h3 class="text-3xl font-bold text-gray-800">{{ $productCount }}</h3>
                        </div>
                        <div class="bg-orange-100 p-3 rounded-full text-[#FF6B00]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('seller.products.index') }}" class="text-sm text-[#FF6B00] hover:underline font-medium">Manage Products</a>
                    </div>
                </div>

                {{-- Kartu Order --}}
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm uppercase">Total Orders</p>
                            <h3 class="text-3xl font-bold text-gray-800">{{ $orderCount }}</h3>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('seller.orders.index') }}" class="text-sm text-blue-600 hover:underline font-medium">View Orders</a>
                    </div>
                </div>

                {{-- Kartu Toko --}}
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-gray-800">
                    <div class="flex items-center gap-4">
                        @if(Auth::user()->store->logo)
                            <img src="{{ '/Storage/'. Auth::user()->store->logo }}" class="w-16 h-16 rounded-full object-cover border border-gray-200" alt="Logo">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
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

            {{-- Bagian 2: Review Terbaru (BARU) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Ulasan Terbaru</h3>
                        <a href="{{ route('seller.reviews.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua Review &rarr;</a>
                    </div>

                    @if($recentReviews->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <p>Belum ada ulasan yang masuk.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($recentReviews as $review)
                                <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center gap-3">
                                            {{-- Gambar Produk Kecil --}}
                                            <div class="w-12 h-12 bg-gray-100 rounded-md overflow-hidden flex-shrink-0">
                                                @if($review->product->image)
                                                    <img src="{{ '/Storage/'. $review->product->image }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Img</div>
                                                @endif
                                            </div>
                                            
                                            <div>
                                                <h4 class="text-sm font-semibold text-gray-800">{{ $review->product->name }}</h4>
                                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                                    <span>Oleh: {{ $review->user->name }}</span>
                                                    <span>&bull;</span>
                                                    <span>{{ $review->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Rating Bintang --}}
                                        <div class="flex items-center bg-yellow-50 px-2 py-1 rounded-lg">
                                            <span class="text-yellow-500 text-sm mr-1">★</span>
                                            <span class="font-bold text-gray-700 text-sm">{{ $review->rating }}</span>
                                        </div>
                                    </div>

                                    {{-- Komentar --}}
                                    <div class="mt-2 text-sm text-gray-600 pl-[60px]">
                                        <p class="italic">"{{ $review->comment }}"</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>