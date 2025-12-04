<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($cartItems->isEmpty())
                <div class="bg-white p-12 text-center rounded-lg shadow-sm flex flex-col items-center justify-center">
                    <div class="bg-gray-100 p-6 rounded-full mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Your cart is empty</h3>
                    <p class="text-gray-500 mb-6">Looks like you haven't added anything to your cart yet.</p>
                    <a href="{{ route('shop.index') }}" class="px-6 py-3 bg-[#FF6B00] text-white rounded-lg font-bold hover:bg-[#e65100] transition shadow-md">
                        Start Shopping
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-6 py-4 w-1/2">Product</th>
                                        <th class="px-6 py-4">Price</th>
                                        <th class="px-6 py-4">Quantity</th>
                                        <th class="px-6 py-4 text-right">Total</th>
                                        <th class="px-6 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($cartItems as $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <div class="w-16 h-16 flex-shrink-0 bg-gray-100 rounded-md overflow-hidden border border-gray-200">
                                                    
                                                        @if($item->product->image)
                                                            <img src="{{ '/storage/' . $item->product->image }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full bg-gray-100"></div>
                                                        @endif
                                                    
                                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    
                                                </div>
                                                <div>
                                                    <a href="{{ route('shop.show', $item->product->id) }}" class="font-bold text-gray-900 hover:text-[#FF6B00] line-clamp-1">
                                                        {{ $item->product->name }}
                                                    </a>
                                                    <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                        {{ $item->product->store->name }}
                                                    </div>
                                                    @if($item->product->stock <= 5)
                                                        <span class="text-[10px] text-red-500 font-bold mt-1 block">Only {{ $item->product->stock }} left!</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 font-medium text-gray-600">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </td>
                                        
                                        <td class="px-6 py-4">
                                            <div class="flex items-center border border-gray-300 rounded-md w-max bg-white">
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="action" value="minus">
                                                    <button type="submit" 
                                                        class="px-3 py-1 text-gray-600 hover:bg-gray-100 border-r border-gray-300 disabled:opacity-50"
                                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        -
                                                    </button>
                                                </form>
                                                
                                                <span class="px-3 py-1 text-sm font-bold text-gray-900 min-w-[2rem] text-center">
                                                    {{ $item->quantity }}
                                                </span>
                                                
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="action" value="plus">
                                                    <button type="submit" 
                                                        class="px-3 py-1 text-gray-600 hover:bg-gray-100 border-l border-gray-300 disabled:opacity-30 disabled:cursor-not-allowed disabled:bg-gray-50"
                                                        {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}
                                                        title="{{ $item->quantity >= $item->product->stock ? 'Max stock reached' : 'Add one' }}">
                                                        +
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 text-right font-bold text-gray-900">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                        
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 transition p-2">
                                                    <span class="sr-only">Remove</span>
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-lg shadow-sm sticky top-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-6">Order Summary</h3>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    @php
                                        $total = 0;
                                        foreach($cartItems as $item) { $total += $item->product->price * $item->quantity; }
                                    @endphp
                                    <span class="font-medium">${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping Estimate</span>
                                    <span class="text-green-600 font-medium">Free</span>
                                </div>
                                <div class="border-t border-gray-100 pt-3 flex justify-between items-center">
                                    <span class="font-bold text-gray-900 text-lg">Total</span>
                                    <span class="font-bold text-[#FF6B00] text-xl">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                            
                            <form action="{{ route('checkout.store') }}" method="POST">
                                @csrf
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Address</label>
                                    <textarea name="address" rows="3" 
                                        class="w-full border-gray-300 rounded-lg text-sm shadow-sm focus:border-[#FF6B00] focus:ring-[#FF6B00] placeholder-gray-400" 
                                        required 
                                        placeholder="Street address, City, Postal Code..."></textarea>
                                </div>
                                
                                <button type="submit" class="w-full bg-[#FF6B00] text-white py-3.5 rounded-lg font-bold hover:bg-[#e65100] transition shadow-lg transform active:scale-[0.98]">
                                    Checkout Now
                                </button>
                            </form>
                            
                            <div class="mt-6 text-center">
                                <a href="{{ route('shop.index') }}" class="text-sm text-gray-500 hover:text-[#FF6B00] hover:underline">
                                    or Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>