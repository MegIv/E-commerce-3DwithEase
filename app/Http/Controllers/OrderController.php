<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar riwayat pesanan (History).
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product']) // Eager load untuk performa
            ->latest()
            ->get();

        // $orderCount = $orders->count();

        // Pastikan Anda nanti membuat view ini: resources/views/shop/orders/index.blade.php
        return view('shop.orders.index', compact('orders'));
    }

    /**
     * Menampilkan halaman Checkout (Form pembuatan order).
     */
    public function create()
    {
        // Ambil item di keranjang untuk ditampilkan di halaman checkout
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Keranjang Anda kosong.');
        }

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Pastikan Anda nanti membuat view ini: resources/views/shop/checkout.blade.php
        return view('shop.checkout', compact('cartItems', 'totalPrice'));
    }

    /**
     * Menyimpan order baru (Proses Checkout).
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'address' => 'required|string|max:500',
        ]);

        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        DB::transaction(function () use ($user, $cartItems, $request) {

            // 1. Kelompokkan item berdasarkan Store ID
            $itemsByStore = $cartItems->groupBy(function ($item) {
                return $item->product->store_id;
            });

            // 2. Buat Order terpisah untuk setiap Toko
            foreach ($itemsByStore as $storeId => $items) {

                // Hitung total per toko
                $storeTotal = 0;
                foreach ($items as $item) {
                    $storeTotal += $item->product->price * $item->quantity;
                }

                // Buat Order untuk Toko ini
                $order = Order::create([
                    'user_id' => $user->id,
                    'store_id' => $storeId,
                    'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
                    'total_price' => $storeTotal,
                    'status' => 'pending_payment', // Default status
                    'shipping_address' => $request->address,
                ]);

                // Pindahkan item ke OrderItems
                foreach ($items as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);

                    if (!$product || $product->stock < $item->quantity) {
                        throw new \Exception("Stock for product '{$item->product->name}' is insufficient.");
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $product->price,
                    ]);

                    $product->decrement('stock', $item->quantity);
                }
            }

            // 3. Kosongkan Cart
            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Orders placed successfully! Packages are split by store.');
    }

    /**
     * Menampilkan detail satu pesanan spesifik.
     */
    public function show(Order $order)
    {
        // 1. Keamanan: Pastikan Buyer hanya bisa melihat order miliknya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Muat relasi item dan produk agar bisa ditampilkan di view
        $order->load(['items.product', 'items.product.store']);

    // Kita gunakan keyBy('product_id') agar mudah dipanggil di view nanti
    // Hasilnya array: [product_id_1 => ReviewObj, product_id_2 => ReviewObj]
    $reviews = Review::where('order_id', $order->id)
                     ->where('user_id', Auth::id())
                     ->get()
                     ->keyBy('product_id');

        // Pastikan Anda nanti membuat view ini: resources/views/shop/orders/show.blade.php
        return view('shop.orders.show', compact('order', 'reviews'));
    }

    /**
     * Menampilkan form edit order (Biasanya jarang dipakai oleh Buyer).
     */
    public function edit(Order $order)
    {
        // Biasanya buyer tidak mengedit order, kecuali mungkin ganti alamat jika status masih pending
        return abort(404);
    }

    /**
     * Mengupdate data order.
     */
    public function update(Request $request, Order $order)
    {
        // Implementasi logika update jika diperlukan (misal: cancel order)
        return abort(404);
    }

    /**
     * Menghapus order (Soft delete atau pembatalan).
     */
    public function destroy(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Contoh: Buyer hanya bisa cancel jika status masih pending payment
        if ($order->status === 'pending_payment') {
            $order->status = 'cancelled';
            $order->save();
            return back()->with('success', 'Order cancelled.');
        }

        return back()->with('error', 'Cannot cancel this order.');
    }
}
