<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <!-- <div class="flex gap-4 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="text-[#FF6B00] border-b-2 border-[#FF6B00]">Overview & Approvals</a>
                <a href="{{ route('admin.users') }}" class="text-gray-500 hover:text-[#FF6B00] transition">All Users</a>
                <a href="{{ route('admin.categories') }}" class="text-gray-500 hover:text-[#FF6B00] transition">Categories</a>
            </div> -->
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- statistik singkat -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-[#FF6B00]">
                    <p class="text-gray-500 text-sm uppercase">Total Users</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-400">
                    <p class="text-gray-500 text-sm uppercase">Pending Sellers</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['pending_sellers'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <p class="text-gray-500 text-sm uppercase">Active Sellers</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['active_sellers'] }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Pending Seller Approvals</h3>

                    @if($pendingSellers->isEmpty())
                    <p class="text-gray-500 text-sm italic">No pending seller applications at the moment.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-500 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Seller Name</th>
                                    <th class="px-4 py-3">Store Name</th>
                                    <th class="px-4 py-3">Registered Date</th>
                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingSellers as $seller)
                                <tr class="border-b">
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $seller->name }}<br><span class="text-xs text-gray-500">{{ $seller->email }}</span></td>
                                    <td class="px-4 py-3">{{ $seller->store->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $seller->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-right flex justify-end gap-2">
                                        <form action="{{ route('admin.seller.approve', $seller->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="bg-green-100 text-green-700 px-3 py-1 rounded hover:bg-green-200 text-xs font-bold transition">
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.seller.reject', $seller->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 text-xs font-bold transition">
                                                Reject
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>