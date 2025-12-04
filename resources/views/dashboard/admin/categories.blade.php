<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Category Management') }}
            </h2>
            <!-- <div class="flex gap-4 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-[#FF6B00] transition">Overview & Approvals</a>
                <a href="{{ route('admin.users') }}" class="text-gray-500 hover:text-[#FF6B00] transition">All Users</a>
                <a href="{{ route('admin.categories') }}" class="text-[#FF6B00] border-b-2 border-[#FF6B00]">Categories</a>
            </div> -->
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1">
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <h3 class="text-lg font-bold mb-4">Add New Category</h3>
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Category Name')" />
                            <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00]" type="text" name="name" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <button type="submit" class="w-full bg-[#FF6B00] text-white py-2 rounded-md font-bold hover:bg-[#e65100] transition">
                            Create Category
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Slug</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr class="border-b last:border-0 hover:bg-gray-50">
                                <td class="px-6 py-3 font-medium">{{ $category->name }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ $category->slug }}</td>
                                <td class="px-6 py-3 text-right">
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category? Products might be affected.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($categories->isEmpty())
                        <div class="p-6 text-center text-gray-500 italic">No categories yet.</div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>