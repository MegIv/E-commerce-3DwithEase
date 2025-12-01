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
    
    $request->validate([
        'address' => 'required|string|max:500',
    ]);

    $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

    if ($cartItems->isEmpty()) {
        return back()->with('error', 'Your cart is empty.');
    }

    DB::transaction(function () use ($user, $cartItems, $request) {
        
        // 1. Kelompokkan item berdasarkan Store ID
        $itemsByStore = $cartItems->groupBy(function($item) {
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
                // Invoice unik per toko
                'invoice_number' => 'INV-' . strtoupper(Str::random(10)), 
                'total_price' => $storeTotal,
                'status' => 'pending_payment',
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

    return redirect()->route('dashboard')->with('success', 'Orders placed successfully! Packages are split by store.');
}
}