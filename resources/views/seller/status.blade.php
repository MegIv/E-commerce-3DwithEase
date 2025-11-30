<x-guest-layout>
    <div class="text-center">
        @if($user->status === 'pending')
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-yellow-100 mb-6">
                <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Application Pending</h2>
            <p class="mt-2 text-sm text-gray-600 mb-6">
                Thanks for registering your store! Your account is currently under review by our Admin team. <br>
                Please check back later or wait for an email confirmation.
            </p>
        @elseif($status === 'rejected')
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100 mb-6">
                <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Application Rejected</h2>
            <p class="mt-2 text-sm text-gray-600 mb-6">
                We are sorry, but your request to become a seller has been rejected by the Admin.
            </p>
            
            <form method="POST" action="{{ route('seller.destroy') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Delete Account
                </button>
            </form>
        @endif

        <div class="mt-6 border-t pt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 underline">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>