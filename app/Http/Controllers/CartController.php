<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('shop.cart', compact('cartItems'));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        // 1. Ambil input quantity dari form frontend
        // Jika tidak ada input (misal dari halaman lain), default-nya 1
        $quantityToAdd = (int) $request->input('quantity', 1);

        // Validasi input minimal 1
        if ($quantityToAdd < 1) {
            return back()->with('error', 'Quantity must be at least 1.');
        }

        // 2. Cek stok awal produk vs jumlah yang diminta saat ini
        if ($product->stock < $quantityToAdd) {
            return back()->with('error', 'Insufficient stock.');
        }

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

        // Hitung total nanti (Barang di Keranjang + Barang yg mau ditambah)
        $currentQtyInCart = $cart ? $cart->quantity : 0;
        $finalQty = $currentQtyInCart + $quantityToAdd;

        // 3. Validasi Akhir: Pastikan total gabungan tidak melebihi stok
        if ($finalQty > $product->stock) {
            return back()->with('error', "Stock limit reached. You already have {$currentQtyInCart} in cart.");
        }

        if ($cart) {
            // Update: Tambahkan sesuai jumlah input
            $cart->increment('quantity', $quantityToAdd);
        } else {
            // Baru: Masukkan sesuai jumlah input
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantityToAdd
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', Auth::id())->with('product')->findOrFail($id);
        
        if ($request->action === 'plus') {
        // Cek apakah menambah 1 akan melebihi stok
        if ($cart->quantity + 1 <= $cart->product->stock) {
            $cart->increment('quantity');
        } else {
            // Opsional: Berikan feedback jika stok mentok (perlu logic frontend tambahan utk alert)
            return back()->with('error', 'Maximum stock reached.');
        }
    } elseif ($request->action === 'minus' && $cart->quantity > 1) {
        $cart->decrement('quantity');
    }

        return back();
    }

    public function destroy($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Item removed.');
    }
}