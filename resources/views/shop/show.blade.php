<div class="mt-12 border-t border-gray-100 pt-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            Customer Reviews 
                            <span class="text-sm font-normal text-gray-500">({{ $reviewCount }})</span>
                        </h3>
                        
                        <div class="flex items-center mb-6">
                            <div class="text-yellow-400 text-xl tracking-widest">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= round($avgRating)) ★ @else <span class="text-gray-300">★</span> @endif
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-600">{{ number_format($avgRating, 1) }} out of 5</span>
                        </div>

                        @if($product->reviews->isEmpty())
                            <p class="text-gray-500 text-sm">No reviews yet.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($product->reviews as $review)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-bold text-sm text-gray-900">{{ $review->user->name }}</p>
                                                <div class="text-yellow-400 text-xs">
                                                    @for($i=1; $i<=5; $i++)
                                                        @if($i <= $review->rating) ★ @else <span class="text-gray-300">★</span> @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-2">{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>