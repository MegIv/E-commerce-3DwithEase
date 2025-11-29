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
                                            <p class="text-xs text-gray-500 uppercase">Status</p>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                                {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        @foreach($order->items as $item)
                                            <div class="flex justify-between items-center bg-gray-50 p-3 rounded">
                                                <div class="flex items-center gap-3">
                                                    @if($item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-10 h-10 object-cover rounded">
                                                    @else
                                                        <div class="w-10 h-10 bg-gray-200 rounded"></div>
                                                    @endif
                                                    <div>
                                                        <p class="text-sm font-bold">{{ $item->product->name }}</p>
                                                        <p class="text-xs text-gray-500">{{ $item->quantity }} x ${{ number_format($item->price, 2) }}</p>
                                                    </div>
                                                </div>

                                                @if($order->status === 'completed')
                                                    <div x-data="{ open: false }">
                                                        <button @click="open = true" class="text-xs font-bold text-[#FF6B00] hover:underline border border-[#FF6B00] px-3 py-1 rounded">
                                                            Write Review
                                                        </button>

                                                        <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                                            <div class="flex items-center justify-center min-h-screen px-4">
                                                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                                                </div>

                                                                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6 relative z-10">
                                                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Review {{ $item->product->name }}</h3>
                                                                    
                                                                    <form action="{{ route('reviews.store') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                                                                        <div class="mb-4">
                                                                            <label class="block text-sm font-medium text-gray-700">Rating</label>
                                                                            <select name="rating" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#FF6B00] focus:ring-[#FF6B00]">
                                                                                <option value="5">⭐⭐⭐⭐⭐ (Excellent)</option>
                                                                                <option value="4">⭐⭐⭐⭐ (Good)</option>
                                                                                <option value="3">⭐⭐⭐ (Average)</option>
                                                                                <option value="2">⭐⭐ (Poor)</option>
                                                                                <option value="1">⭐ (Terrible)</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-4">
                                                                            <label class="block text-sm font-medium text-gray-700">Comment</label>
                                                                            <textarea name="comment" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#FF6B00] focus:ring-[#FF6B00]" required></textarea>
                                                                        </div>

                                                                        <div class="flex justify-end gap-2">
                                                                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md">Cancel</button>
                                                                            <button type="submit" class="px-4 py-2 bg-[#FF6B00] text-white rounded-md font-bold">Submit Review</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
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