<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Pesan Sukses/Error --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($orders->isEmpty())
                        {{-- Tampilan Jika Belum Ada Pesanan --}}
                        <div class="text-center py-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900">Belum ada pesanan</h3>
                            <p class="mt-1 text-gray-500">Anda belum melakukan transaksi apapun.</p>
                            <div class="mt-6">
                                <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Mulai Belanja
                                </a>
                            </div>
                        </div>
                    @else
                        {{-- Tabel Daftar Pesanan --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No. Invoice
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $order->invoice_number }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $order->items->count() }} Produk
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $order->created_at->format('d M Y') }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $order->created_at->format('H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">
                                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{-- Badge Status Warna-Warni --}}
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
                                                    $currentClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
                                                    $currentLabel = $statusLabel[$order->status] ?? $order->status;
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $currentClass }}">
                                                    {{ $currentLabel }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900 font-bold border border-indigo-200 hover:bg-indigo-50 px-3 py-1 rounded-md transition">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>