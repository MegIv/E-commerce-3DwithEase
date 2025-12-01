<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi alamat pengiriman (opsional tapi disarankan)
        // $request->validate([
        //     'address' => 'required|string|max:500',
        // ]);

        // Ambil item cart
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }
        
        // Hitung total awal (hanya estimasi, hitung ulang di dalam transaksi untuk akurasi)
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        try {
            DB::transaction(function () use ($user, $cartItems, $totalPrice, $request) {
                
                // Buat Order
                $order = Order::create([
                    'user_id' => $user->id,
                    'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
                    'total_price' => $totalPrice, 
                    'status' => 'pending_payment',
                    'shipping_address' => $request->address,
                ]);

                // Loop item untuk dipindahkan ke OrderItems
                foreach ($cartItems as $item) {
                    // Lock produk untuk mencegah race condition (rebutan stok)
                    // query ulang produknya di dalam transaksi
                    $product = Product::lockForUpdate()->find($item->product_id);

                    // Cek stok lagi untuk keamanan terakhir
                    if (!$product || $product->stock < $item->quantity) {
                        // Lempar exception agar transaksi dibatalkan (rollback) otomatis
                        throw new \Exception("Stock for product '{$item->product->name}' is insufficient.");
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $product->price, // Gunakan harga terbaru dari DB
                    ]);

                    // Kurangi stok
                    $product->decrement('stock', $item->quantity);
                }

                // Kosongkan Cart setelah sukses
                Cart::where('user_id', $user->id)->delete();
            });

            return redirect()->route('dashboard')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            // Jika stok habis atau error lain, transaksi otomatis batal (rollback)
            // Cart user tidak akan hilang, stok tidak akan berkurang
            return back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }
}