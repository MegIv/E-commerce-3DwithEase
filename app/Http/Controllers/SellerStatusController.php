<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class SellerStatusController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // jika user bukan seller atau sudah active, lempar ke dashboard
        if ($user->role !== 'seller' || $user->status === 'active') {
            return redirect()->route('dashboard');
        }

        return view('seller.status', ['user' => $user]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // keamanan: hanya bisa hapus diri sendiri jika status rejected (opsional: atau pending)
        if ($user->role === 'seller' && $user->status === 'rejected') {
            Auth::logout();
            // $user->delete();
            User::destroy($user->id); // Menghapus user berdasarkan ID (static destroy methode)
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('status', 'Account deleted successfully. You can register again if you wish.');
        }

        return back();
    }
}

