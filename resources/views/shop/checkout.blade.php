<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout Pengiriman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- Kolom Kiri: Form Alamat --}}
                    <div class="space-y-6">
                        <div class="bg-white p-6 shadow sm:rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pengiriman</h3>
                            
                            <div>
                                <x-input-label for="name" :value="__('Nama Penerima')" />
                                <x-text-input id="name" class="block mt-1 w-full bg-gray-100" type="text" :value="Auth::user()->name" readonly />
                                <p class="text-xs text-gray-500 mt-1">Sesuai nama akun Anda.</p>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="address" :value="__('Alamat Lengkap')" />
                                <textarea id="address" name="address" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Jalan, Nomor Rumah, RT/RW, Kecamatan, Kota..." required>{{ old('address') }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Ringkasan Order --}}
                    <div class="space-y-6">
                        <div class="bg-white p-6 shadow sm:rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Pesanan</h3>
                            
                            <ul class="divide-y divide-gray-200 mb-4">
                                @foreach($cartItems as $item)
                                    <li class="flex py-4">
                                        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                            @if($item->product->image)
                                                <img src="{{ Storage::url($item->product->image) }}" class="h-full w-full object-cover object-center">
                                            @else
                                                <div class="h-full w-full bg-gray-100"></div>
                                            @endif
                                        </div>

                                        <div class="ml-4 flex flex-1 flex-col">
                                            <div>
                                                <div class="flex justify-between text-base font-medium text-gray-900">
                                                    <h3>{{ $item->product->name }}</h3>
                                                    <p class="ml-4">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-500">{{ $item->product->store->store_name ?? 'Store' }}</p>
                                            </div>
                                            <div class="flex flex-1 items-end justify-between text-sm">
                                                <p class="text-gray-500">Qty {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="border-t border-gray-200 pt-4 space-y-2">
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <p>Total Tagihan</p>
                                    <p>Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                                </div>
                                <p class="mt-0.5 text-sm text-gray-500">Termasuk pajak dan biaya layanan.</p>
                            </div>

                            <div class="mt-6">
                                <x-primary-button class="w-full justify-center py-3 text-lg">
                                    {{ __('Buat Pesanan') }}
                                </x-primary-button>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <a href="{{ route('cart.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                                    Kembali ke Keranjang
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>