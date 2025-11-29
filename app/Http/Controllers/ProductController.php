<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //menampilkan daftar produk milik seller yang sedang login
        $store = Auth::user()->store;
        $products = Product::where('store_id', $store->id)->latest()->paginate(10);

        return view('dashboard.seller.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // form tambah produk
    public function create()
    {
        // mengambil semua kategori untuk dropdown
        $categories = Category::all();
        return view('dashboard.seller.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string', //untuk sekarang nullable, diubah required jika perlu
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', //maks 2MB
        ]);

        $store = Auth::user()->store;
        $imagePath = null;

        //menyimpan gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
        
        Product::create([
            'store_id' => $store->id,
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name). '-' . Str::random(5), //untuk menghindari slug duplikat
            'price' => $request->price,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // form edit produk
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        // pastikan produk milik seller yg sedang mengedit
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $categories = Category::all();
        return view('dashboard.seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    // yep update (secara harfiah) produk
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        // pastikan produk milik seller yang sedang mengupdate
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string', // sementara nullable, required jika perlu
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        //mengambil semua data kecuali gambar
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            //hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            //simpan gambar baru
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // kill the product (hapus)
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        // pastikan produk milik seller yang sedang menghapus   
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        // hapus gambar jika ada
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully.');
    }
}
