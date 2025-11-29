<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:buyer, seller'],
            // Validasi nama toko wajib jika role adalah seller
            'store_name' => ['required_if:role,seller', 'nullable', 'string', 'max:255', 'unique:stores,name'],
        ]);

        // Tentukan status awal
        // Seller = pending (butuh approval admin)
        // Buyer = active (langsung bisa belanja)
        $status = $request->role === 'seller' ? 'pending' : 'active';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $status,
        ]);

        // Jika Seller, buatkan data Toko otomatis
        if ($request->role === 'seller') {
            Store::create([
                'user_id' => $user->id,
                'name' => $request->store_name,
                'slug' => Str::slug($request->store_name),
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirect sesuai Role
        if ($user->role === 'seller') {
            return redirect()->route('seller.status');
        }

        return redirect(route('dashboard', absolute: false));
    }
}
