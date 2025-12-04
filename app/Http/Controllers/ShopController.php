<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // logika search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%'. $request->search. '%');
            });
        }

        // Logika Filter Kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->with('store')->latest()->paginate(12);

        // 3. Ambil semua kategori untuk isi dropdown filter
        $categories = Category::all();

        return view('dashboard.user.home', compact('products', 'categories'));
    }

    public function show($id)
    {
        // Eager load reviews dan user pembuat review
        $product = Product::with(['store', 'category', 'reviews.user'])->findOrFail($id);

        // Hitung rata-rata rating
        $avgRating = $product->reviews->avg('rating') ?? 0;
        $reviewCount = $product->reviews->count();

        return view('shop.show', compact('product', 'avgRating', 'reviewCount'));
    }

    // Tambahkan method ini
    public function welcome()
    {
        // Ambil 8 produk terbaru untuk display di Landing Page
        $products = Product::with('store')
            ->latest()
            ->take(8)
            ->get();

        return view('welcome', compact('products'));
    }
}
