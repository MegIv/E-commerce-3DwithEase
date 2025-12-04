<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                return view('dashboard.admin.home');
            }

            if ($user->role == 'seller') {
                return redirect()->route('seller.dashboard');
            }

            // Untuk Buyer: Tampilkan katalog produk dari semua seller terlebih dahulu,
            // lalu tampilkan riwayat order milik buyer.
            // Paginate product suggestions (12 per page) and include a reviews_count for quick display
            $products = Product::with(['store', 'category'])->withCount('reviews')->latest()->take(4)->get();

            $orders = Order::where('user_id', $user->id)
                ->with('items.product')
                ->latest()
                ->get();

            return view('dashboard.user.home', compact('products', 'orders'));
        } else {
            return redirect('login');
        }
    }
}
