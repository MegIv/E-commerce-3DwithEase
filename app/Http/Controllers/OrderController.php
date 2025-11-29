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
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        DB::transaction(function () use ($user, $cartItems, $totalPrice, $request) {
            // 1. Buat Order
            $order = Order::create([
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
                'total_price' => $totalPrice,
                'status' => 'pending_payment', // Default status
                'shipping_address' => $request->address ?? 'Default Address',
            ]);

            // 2. Pindahkan item cart ke OrderItems & Kurangi Stok
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Kurangi stok
                $item->product->decrement('stock', $item->quantity);
            }

            // 3. Kosongkan Cart
            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('dashboard')->with('success', 'Order placed successfully!');
    }
}