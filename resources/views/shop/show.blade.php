<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    @php
        $avgRating = $product->reviews->avg('rating') ?? 0;
        $reviewCount = $product->reviews->count();
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <nav class="flex mb-6 text-sm text-gray-500">
                <a href="{{ route('shop.index') }}" class="hover:text-[#FF6B00]">Shop</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $product->name }}</span>
            </nav>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        
                        <div class="space-y-4">
                            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden relative">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-cover w-full h-full hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                
                                <span class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-gray-700 shadow-sm">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Sold by</span>
                                <a href="#" class="text-xs font-bold text-[#FF6B00] hover:underline">
                                    {{ $product->store->name ?? 'Official Store' }}
                                </a>
                            </div>

                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                            <div class="flex items-center gap-2 mb-6">
                                <div class="flex text-yellow-400 text-sm">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= round($avgRating)) ★ @else <span class="text-gray-300">★</span> @endif
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500">({{ $reviewCount }} Reviews)</span>
                            </div>

                            <div class="text-4xl font-bold text-[#FF6B00] mb-6">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            <div class="prose text-gray-600 mb-8 border-t border-b border-gray-100 py-4">
                                <p>{{ $product->description ?? 'No description available.' }}</p>
                            </div>

                            <div class="space-y-6">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-gray-700">Availability:</span>
                                    @if($product->stock > 0)
                                        <span class="text-green-600 font-bold bg-green-50 px-2 py-1 rounded text-sm">In Stock ({{ $product->stock }})</span>
                                    @else
                                        <span class="text-red-600 font-bold bg-red-50 px-2 py-1 rounded text-sm">Out of Stock</span>
                                    @endif
                                </div>

                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    
                                    <div class="flex flex-col sm:flex-row gap-4">
                                        <div class="flex items-center border border-gray-300 rounded-lg w-max" x-data="{ qty: 1, max: {{ $product->stock }} }">
                                            <button type="button" onclick="decrement()" class="px-4 py-3 text-gray-600 hover:bg-gray-100 border-r border-gray-300 font-bold text-lg disabled:opacity-50" id="btn-minus">-</button>
                                            
                                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                                class="w-16 text-center border-none focus:ring-0 font-bold text-gray-900" readonly>
                                            
                                            <button type="button" onclick="increment()" class="px-4 py-3 text-gray-600 hover:bg-gray-100 border-l border-gray-300 font-bold text-lg disabled:opacity-50" id="btn-plus" {{ $product->stock <= 1 ? 'disabled' : '' }}>+</button>
                                        </div>

                                        <button type="submit" 
                                            class="flex-1 py-3 px-6 rounded-lg font-bold text-lg shadow-md transition transform active:scale-95 flex justify-center items-center gap-2
                                            {{ $product->stock > 0 ? 'text-white hover:bg-orange-600' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                                            {{ $product->stock < 1 ? 'disabled' : '' }}
                                            @if($product->stock > 0) style="background-color: #111827;" @endif>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            
                                            <span>{{ $product->stock > 0 ? 'Add to Cart' : 'Sold Out' }}</span>     
                                        </button>
                                    </div>
                                </form>
                                <p class="text-xs text-gray-400 mt-2">Secure checkout guaranteed.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-16 border-t border-gray-100 pt-10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Customer Reviews</h3>
                        
                        @if($product->reviews->isEmpty())
                            <div class="bg-gray-50 rounded-lg p-8 text-center">
                                <p class="text-gray-500">No reviews yet. Be the first to review this product!</p>
                            </div>
                        @else
                            <div class="grid gap-6">
                                @foreach($product->reviews as $review)
                                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-500 text-xs">
                                                    {{ substr($review->user->name, 0, 2) }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-sm text-gray-900">{{ $review->user->name }}</p>
                                                    <div class="flex text-yellow-400 text-xs mt-0.5">
                                                        @for($i=1; $i<=5; $i++)
                                                            @if($i <= $review->rating) ★ @else <span class="text-gray-300">★</span> @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-600 text-sm leading-relaxed ml-11">{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function increment() {
            let input = document.getElementById('quantity');
            let max = parseInt(input.getAttribute('max'));
            let val = parseInt(input.value);
            
            if (val < max) {
                input.value = val + 1;
            }
            updateButtons();
        }

        function decrement() {
            let input = document.getElementById('quantity');
            let val = parseInt(input.value);
            
            if (val > 1) {
                input.value = val - 1;
            }
            updateButtons();
        }

        function updateButtons() {
            let input = document.getElementById('quantity');
            let max = parseInt(input.getAttribute('max'));
            let val = parseInt(input.value);
            
            document.getElementById('btn-minus').disabled = (val <= 1);
            document.getElementById('btn-plus').disabled = (val >= max);
        }
    </script>
</x-app-layout>