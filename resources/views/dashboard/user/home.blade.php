<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($orders->isEmpty())
                        <p class="text-gray-500 italic">You haven't placed any orders yet.</p>
                        <a href="{{ route('shop.index') }}" class="text-[#FF6B00] font-bold hover:underline mt-2 inline-block">Start Shopping</a>
                    @else
                        <div class="space-y-6">
                            @foreach($orders as $order)
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-4">
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase">Invoice</p>
                                            <p class="font-bold text-gray-900">{{ $order->invoice_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase">Date</p>
                                            <p class="font-bold text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase">Total</p>
                                            <p class="font-bold text-[#FF6B00]">${{ number_format($order->total_price, 2) }}</p>
                                        </div>
                                        <div>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                                {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        @foreach($order->items as $item)
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-700">{{ $item->quantity }}x {{ $item->product->name }}</span>
                                                <span class="font-mono text-gray-500">${{ number_format($item->price, 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>