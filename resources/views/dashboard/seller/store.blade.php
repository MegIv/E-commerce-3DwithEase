<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Store Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 text-sm text-green-600 bg-green-50 p-2 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf @method('PATCH')
                    
                    <div class="text-center">
                        <x-input-label :value="__('Store Logo')" class="mb-2" />
                        <div class="relative w-24 h-24 mx-auto mb-4">
                            @if($store->logo)
                                
                                    <img src="{{ '/Storage/'. $store->logo }}" class="w-full h-full rounded-full object-cover border-2 border-gray-200" loading="lazy" alt="{{ $store->name }} logo">
                                @else
                                    <div class="w-full h-full rounded-full bg-gray-100"></div>
                                @endif
                                
                        </div>
                        <input type="file" name="logo" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-[#FF6B00] hover:file:bg-orange-100">
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="name" :value="__('Store Name')" />
                        <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00]" type="text" name="name" :value="old('name', $store->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Store Description')" />
                        <textarea name="description" id="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00] rounded-md shadow-sm">{{ old('description', $store->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md font-semibold hover:bg-gray-900">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>