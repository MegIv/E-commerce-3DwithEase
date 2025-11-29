<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Incoming Orders') }}
            </h2>
            <div class="flex gap-4 text-sm font-medium">
                <a href="{{ route('seller.dashboard') }}" class="text-gray-500 hover:text-[#FF6B00] transition">Overview</a>
                <a href="{{ route('seller.products.index') }}" class="text-gray-500 hover:text-[#FF6B00] transition">My Products</a>
                <a href="{{ route('seller.orders.index') }}" class="text-[#FF6B00] border-b-2 border-[#FF6B00]">Orders</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($orders->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            No orders received yet.
                        </div>
                    @else
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-500 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Invoice</th>
                                    <th class="px-4 py-3">Buyer</th>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">Total</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 font-mono font-bold">{{ $order->invoice_number }}</td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $order->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="px-4 py-3">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3 font-bold text-[#FF6B00]">${{ number_format($order->total_price, 2) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold
                                            {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : 
                                              ($order->status == 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                            {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('seller.orders.show', $order->id) }}" class="bg-gray-800 text-white px-3 py-1 rounded hover:bg-black text-xs transition">
                                            Manage
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">{{ $orders->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>