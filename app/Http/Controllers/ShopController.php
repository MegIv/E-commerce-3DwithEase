<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Fitur Search sederhana
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);
        return view('shop.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('store', 'category')->findOrFail($id);
        return view('shop.show', compact('product'));
    }

}
