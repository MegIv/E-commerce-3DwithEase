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
        
        // Validasi stok sederhana
        if ($product->stock < 1) {
            return back()->with('error', 'Product out of stock.');
        }

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

        // Hitung jumlah yang akan ada di keranjang jika ditambah 1
        $currentQty = $cart ? $cart->quantity : 0;
        
        // Validasi: Jika (qty sekarang + 1) lebih besar dari stok produk
        if (($currentQty + 1) > $product->stock) {
            return back()->with('error', 'Product stock limit reached.');
        }

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1
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