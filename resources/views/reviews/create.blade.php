<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beri Ulasan Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Info Produk yang diulas --}}
                <div class="flex items-center mb-6 pb-6 border-b border-gray-100">
                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                        @if($product->image)
                            <img src="{{ '/Storage/'. $product->image }}" class="h-full w-full object-cover object-center">
                        @else
                            <div class="h-full w-full bg-gray-100 flex items-center justify-center text-xs text-gray-400">No Img</div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $product->store->store_name ?? 'Store' }}</p>
                    </div>
                </div>

                {{-- Form Review --}}
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    
                    {{-- Hidden Input (Penting) --}}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="order_id" value="{{ $orderId }}">

                    {{-- Rating Star --}}
                    <div class="mb-4">
                        <x-input-label for="rating" :value="__('Rating (1-5 Bintang)')" />
                        <select name="rating" id="rating" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Puas)</option>
                            <option value="4">⭐⭐⭐⭐ (4 - Puas)</option>
                            <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                            <option value="2">⭐⭐ (2 - Kurang)</option>
                            <option value="1">⭐ (1 - Sangat Buruk)</option>
                        </select>
                        <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                    </div>

                    {{-- Komentar --}}
                    <div class="mb-6">
                        <x-input-label for="comment" :value="__('Ulasan Anda')" />
                        <textarea id="comment" name="comment" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Ceritakan pengalaman Anda menggunakan produk ini..." required>{{ old('comment') }}</textarea>
                        <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                        <x-primary-button>
                            {{ __('Kirim Ulasan') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>