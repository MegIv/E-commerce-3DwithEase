<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan') }} #{{ $order->invoice_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Kolom Kiri: Daftar Barang --}}
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Produk</h3>
                        <div class="divide-y divide-gray-200">
                            @foreach($order->items as $item)
                            <div class="py-4 flex items-center">
                                {{-- Gambar Produk --}}
                                <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                    @if($item->product->image)
                                    <img src="{{ '/Storage/'. $item->product->image }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center">
                                    @else
                                    <div class="h-full w-full bg-gray-100 flex items-center justify-center text-gray-400">
                                        No Img
                                    </div>
                                    @endif

                                </div>

                                <div class="ml-4 flex-1 flex flex-col">
                                    <div>
                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                            <h3>
                                                <a href="{{ route('shop.show', $item->product) }}">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h3>
                                            <p class="ml-4">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">{{ $item->product->store->store_name ?? 'Toko' }}</p>
                                    </div>
                                    <div class="flex flex-1 items-end justify-between text-sm">
                                        <p class="text-gray-500">Qty {{ $item->quantity }}</p>

                                        {{-- LOGIC TAMPILAN REVIEW --}}
    
                                        @php
                                            // Cek apakah ada review untuk produk ini di order ini
                                            $userReview = $reviews->get($item->product_id);
                                        @endphp

                                        @if($userReview)
                                            {{-- KONDISI 1: SUDAH DIREVIEW (Tampilkan Bintang & Komentar) --}}
                                            <div class="text-right">
                                                <div class="flex items-center justify-end mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $userReview->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <p class="text-xs text-gray-600 italic">"{{ Str::limit($userReview->comment, 30) }}"</p>
                                            </div>

                                        @elseif($order->status === 'completed')
                                            {{-- KONDISI 2: BELUM DIREVIEW & ORDER SELESAI (Tampilkan Tombol) --}}
                                            <a href="{{ route('reviews.create', ['product' => $item->product_id, 'order_id' => $order->id]) }}" class="text-indigo-600 hover:text-indigo-500 font-medium border border-indigo-200 px-3 py-1 rounded hover:bg-indigo-50 transition">
                                                Beri Ulasan
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Ringkasan & Info Pengiriman --}}
                <div class="md:col-span-1 space-y-6">

                    {{-- Status Card --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Status Pesanan</h3>
                        @php
                        $statusClasses = [
                        'pending_payment' => 'bg-yellow-100 text-yellow-800',
                        'processing' => 'bg-blue-100 text-blue-800',
                        'completed' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        ];
                        $statusLabel = [
                        'pending_payment' => 'Menunggu Pembayaran',
                        'processing' => 'Diproses',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusLabel[$order->status] ?? $order->status }}
                        </span>

                        @if($order->status === 'pending_payment')
                        <p class="text-sm text-gray-500 mt-2 mb-4">
                            Mohon segera selesaikan pembayaran Anda agar pesanan dapat diproses.
                        </p>

                        {{-- FORM PEMBATALAN PESANAN --}}
                        <form action="{{ route('orders.destroy', $order) }}" method="POST">
                            @csrf
                            @method('DELETE') {{-- Penting: Mengubah method POST menjadi DELETE --}}

                            <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.')"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batalkan Pesanan
                            </button>
                        </form>
                        @endif

                        @if($order->status === 'cancelled')
                        <p class="text-sm text-red-500 mt-2 font-medium">
                            Pesanan ini telah dibatalkan.
                        </p>
                        @endif
                    </div>

                    {{-- Shipping Info --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Alamat Pengiriman</h3>
                        <p class="text-gray-600 text-sm whitespace-pre-line">{{ $order->shipping_address }}</p>
                    </div>

                    {{-- Summary --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Pembayaran</h3>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Total Item</span>
                            <span class="font-medium">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="font-medium text-green-600">Gratis</span>
                        </div>
                        <div class="flex justify-between py-4">
                            <span class="text-lg font-bold text-gray-900">Total Belanja</span>
                            <span class="text-lg font-bold text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Tombol Back --}}
                    <div class="mt-4">
                        <a href="{{ route('orders.index') }}" class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition">
                            &larr; Kembali ke Pesanan Saya
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>