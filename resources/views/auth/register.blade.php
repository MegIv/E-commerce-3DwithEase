<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Create Account</h2>
        <p class="text-sm text-gray-600">Join 3DwithEase ecosystem today</p>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="{ role: 'buyer' }">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00]" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label :value="__('I want to join as:')" class="mb-2" />
            <div class="grid grid-cols-2 gap-4">
                <label class="cursor-pointer">
                    <input type="radio" name="role" value="buyer" class="peer sr-only" x-model="role">
                    <div class="rounded-lg border border-gray-200 p-4 hover:bg-gray-50 peer-checked:border-[#FF6B00] peer-checked:bg-orange-50 transition text-center">
                        <div class="font-semibold text-gray-900">Buyer</div>
                        <div class="text-xs text-gray-500">I want to buy products</div>
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio" name="role" value="seller" class="peer sr-only" x-model="role">
                    <div class="rounded-lg border border-gray-200 p-4 hover:bg-gray-50 peer-checked:border-[#FF6B00] peer-checked:bg-orange-50 transition text-center">
                        <div class="font-semibold text-gray-900">Seller</div>
                        <div class="text-xs text-gray-500">I want to sell products</div>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>


        <!-- Store Name (Visible only for Sellers) -->
        <div class="mt-4" x-show="role === 'seller'" x-transition>
            <x-input-label for="store_name" :value="__('Store Name')" />
            <x-text-input id="store_name" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00]" type="text" name="store_name" :value="old('store_name')" />
            <p class="text-xs text-gray-500 mt-1">Your account will be pending approval by Admin.</p>
            <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00]"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-[#FF6B00] focus:ring-[#FF6B00]"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF6B00]" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-[#FF6B00] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#e65100] focus:bg-[#e65100] active:bg-[#cc4800] focus:outline-none focus:ring-2 focus:ring-[#FF6B00] focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>
