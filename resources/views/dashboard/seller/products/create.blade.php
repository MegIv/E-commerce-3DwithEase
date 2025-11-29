<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <x-input-label for="name" :value="__('Product Name')" />
                        <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00]" type="text" name="name" :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00] rounded-md shadow-sm">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="price" :value="__('Price ($)')" />
                            <x-text-input id="price" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00]" type="number" step="0.01" name="price" :value="old('price')" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="stock" :value="__('Stock')" />
                            <x-text-input id="stock" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00]" type="number" name="stock" :value="old('stock')" required />
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea name="description" id="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00] rounded-md shadow-sm">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="image" :value="__('Product Image')" />
                        <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-[#FF6B00] hover:file:bg-orange-100">
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('seller.products.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md font-semibold hover:bg-gray-200">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-[#FF6B00] text-white rounded-md font-semibold hover:bg-[#e65100]">Create Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>