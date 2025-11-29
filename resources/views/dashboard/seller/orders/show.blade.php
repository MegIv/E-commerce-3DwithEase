<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Details: {{ $order->invoice_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Items Ordered from Your Store</h3>
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">Product</th>
                                <th class="px-4 py-2">Price</th>
                                <th class="px-4 py-2">Qty</th>
                                <th class="px-4 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                @if($item->product->store_id == Auth::user()->store->id)
                                <tr class="border-b">
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                                    </td>
                                    <td class="px-4 py-3">${{ number_format($item->price, 2) }}</td>
                                    <td class="px-4 py-3">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-right font-bold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">Customer Info</h3>
                        <p class="text-sm text-gray-500 uppercase">Name</p>
                        <p class="font-medium mb-3">{{ $order->user->name }}</p>
                        
                        <p class="text-sm text-gray-500 uppercase">Email</p>
                        <p class="font-medium mb-3">{{ $order->user->email }}</p>

                        <p class="text-sm text-gray-500 uppercase">Shipping Address</p>
                        <p class="font-medium bg-gray-50 p-2 rounded border">{{ $order->shipping_address }}</p>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">Update Status</h3>
                        <form action="{{ route('seller.orders.update', $order->id) }}" method="POST">
                            @csrf @method('PATCH')
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Status</label>
                                <select name="status" class="w-full border-gray-300 rounded-md focus:border-[#FF6B00] focus:ring-[#FF6B00]">
                                    <option value="pending_payment" {{ $order->status == 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-[#FF6B00] text-white py-2 rounded-md font-bold hover:bg-[#e65100] transition">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>