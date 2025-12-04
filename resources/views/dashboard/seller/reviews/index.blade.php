<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ulasan Pembeli') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-medium mb-4">Daftar Review Produk Anda</h3>

                    @if($reviews->isEmpty())
                        <p class="text-gray-500">Belum ada ulasan untuk produk Anda.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">Produk</th>
                                        <th class="py-3 px-6 text-left">Pembeli</th>
                                        <th class="py-3 px-6 text-center">Rating</th>
                                        <th class="py-3 px-6 text-left">Komentar</th>
                                        <th class="py-3 px-6 text-center">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($reviews as $review)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($review->product->image)
                                                        <img class="w-10 h-10 rounded-full mr-2 object-cover" src="{{ '/Storage/'. $review->product->image }}" alt="Product Image">
                                                    @endif
                                                    <span class="font-medium">{{ $review->product->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <span>{{ $review->user->name }}</span>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs font-bold">
                                                    ★ {{ $review->rating }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <p class="italic">"{{Str::limit($review->comment, 50)}}"</p>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                {{ $review->created_at->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>