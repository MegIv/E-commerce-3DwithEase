<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // halaman utama dashboard admin
    public function index()
    {
        // statistik ringkas
        $stats = [
            'total_users' => User::count(),
            'pending_sellers' => User::where('role', 'seller')->where('status', 'pending')->count(),
            'active_sellers' => User::where('role', 'seller')->where('status', 'active')->count(),
        ];

        // ambil seller yg statusnya pending untuk verifikasi
        $pendingSellers = User::where('role', 'seller')
            ->where('status', 'pending')
            ->with('store') // eager load data toko
            ->get();

        return view('dashboard.admin.home', compact('stats', 'pendingSellers'));
    }

    // halaman manajemen user (semua user)
    public function user()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.admin.users', compact('users'));
    }

    // logic approve seller
    public function approveSeller($id)
    {
        $seller = User::findOrFail($id);
        $seller->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Seller approved successfully.');
    }

    // logic reject seller
    public function rejectSeller($id)
    {
        $seller = User::findOrFail($id);
        $seller->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Seller rejected successfully.');
    }

    // logic hapus user (the power of admin)
    public function destroyUser($id)
    {
        // jangan hapus diri sendiri (admin)
        if ($id === Auth::id()) {
            dd('saya admin');
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
