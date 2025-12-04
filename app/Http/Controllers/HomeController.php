<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;


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

            // Buyer Logic
            // 1. Ambil Kategori untuk Dropdown (Solusi Error Anda)
            $categories = Category::all();

            // 2. Ambil Produk (Bisa ditambah logic filter jika mau search langsung dari dashboard)
            // Disini kita tampilkan default 4 produk terbaru
            $products = Product::with(['store', 'category'])
                ->withCount('reviews')
                ->latest()
                ->take(4) // Limit 4 untuk dashboard
                ->get();

            $orders = Order::where('user_id', $user->id)
                ->with('items.product')
                ->latest()
                ->get();

            return view('dashboard.user.home', compact('products', 'orders', 'categories'));
        } else {
            return redirect('login');
        }
    }
}
