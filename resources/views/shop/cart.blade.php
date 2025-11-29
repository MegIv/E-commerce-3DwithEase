<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($cartItems->isEmpty())
                <div class="bg-white p-12 text-center rounded-lg shadow-sm">
                    <p class="text-gray-500 text-lg mb-4">Your cart is empty.</p>
                    <a href="{{ route('shop.index') }}" class="text-[#FF6B00] font-bold hover:underline">Continue Shopping</a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm overflow-hidden">
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-500 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4">Product</th>
                                    <th class="px-6 py-4">Price</th>
                                    <th class="px-6 py-4">Quantity</th>
                                    <th class="px-6 py-4">Total</th>
                                    <th class="px-6 py-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr class="border-b">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $item->product->name }}
                                        <div class="text-xs text-gray-500">{{ $item->product->store->name }}</div>
                                    </td>
                                    <td class="px-6 py-4">${{ number_format($item->product->price, 2) }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="action" value="minus">
                                                <button type="submit" class="text-gray-500 hover:text-black font-bold">-</button>
                                            </form>
                                            <span class="w-8 text-center">{{ $item->quantity }}</span>
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="action" value="plus">
                                                <button type="submit" class="text-gray-500 hover:text-black font-bold">+</button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold">${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline text-xs">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h3 class="text-lg font-bold mb-4">Order Summary</h3>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Subtotal</span>
                                @php
                                    $total = 0;
                                    foreach($cartItems as $item) { $total += $item->product->price * $item->quantity; }
                                @endphp
                                <span class="font-bold">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-100 my-4"></div>
                            
                            <form action="{{ route('checkout.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Address</label>
                                    <textarea name="address" rows="2" class="w-full border-gray-300 rounded-md text-sm focus:border-[#FF6B00] focus:ring-[#FF6B00]" required placeholder="Enter delivery address..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-[#FF6B00] text-white py-3 rounded-md font-bold hover:bg-[#e65100] transition">
                                    Checkout Now
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>