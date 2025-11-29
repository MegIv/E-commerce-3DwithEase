<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <div class="h-96 bg-gray-100 rounded-lg overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">No Image Available</div>
                    @endif
                </div>

                <div class="flex flex-col justify-center">
                    <span class="text-[#FF6B00] font-bold uppercase tracking-wide text-sm mb-2">{{ $product->category->name }}</span>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    <div class="text-3xl font-mono text-gray-900 mb-6">${{ number_format($product->price, 2) }}</div>
                    
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        {{ $product->description }}
                    </p>

                    <div class="border-t border-b border-gray-100 py-4 mb-8">
                        <div class="flex items-center gap-4">
                            @if($product->store->logo)
                                <img src="{{ asset('storage/' . $product->store->logo) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200"></div>
                            @endif
                            <div>
                                <p class="text-sm text-gray-500">Sold by</p>
                                <p class="font-bold text-gray-900">{{ $product->store->name }}</p>
                            </div>
                        </div>
                    </div>

                    @auth
                        @if(Auth::user()->role === 'buyer')
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-[#FF6B00] text-white py-4 rounded-lg font-bold text-lg hover:bg-[#e65100] transition shadow-lg shadow-orange-200">
                                    Add to Cart
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block text-center w-full bg-gray-900 text-white py-4 rounded-lg font-bold text-lg hover:bg-black transition">
                            Login to Buy
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>