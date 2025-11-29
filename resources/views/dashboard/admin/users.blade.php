<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Management') }}
            </h2>
            <div class="flex gap-4 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-[#FF6B00] transition">Overview & Approvals</a>
                <a href="{{ route('admin.users') }}" class="text-[#FF6B00] border-b-2 border-[#FF6B00]">All Users</a>
                <a href="{{ route('admin.categories') }}" class="text-gray-500 hover:text-[#FF6B00] transition">Categories</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold
                                        {{ $user->role === 'admin' ? 'bg-black text-white' : '' }}
                                        {{ $user->role === 'seller' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $user->role === 'buyer' ? 'bg-gray-100 text-gray-700' : '' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold
                                        {{ $user->status === 'active' ? 'text-green-600' : '' }}
                                        {{ $user->status === 'pending' ? 'text-yellow-600' : '' }}
                                        {{ $user->status === 'rejected' ? 'text-red-600' : '' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    @if($user->role !== 'admin')
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline text-xs">Delete</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs">Protected</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>