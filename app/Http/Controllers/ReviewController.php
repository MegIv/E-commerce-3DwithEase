<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function create($productId, $orderId)
    {
        $user = Auth::user();

        // Validasi: Pastikan Order ada, milik user ini, dan statusnya completed
        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->first();

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Pesanan tidak ditemukan atau belum selesai.');
        }
        // Validasi: Pastikan Produk ada di dalam order tersebut
        // cek relasi items
        $hasProduct = $order->items()->where('product_id', $productId)->exists();

        if (!$hasProduct) {
            return redirect()->route('orders.show', $orderId)->with('error', 'Produk ini tidak ada dalam pesanan Anda.');
        }

        // Cek apakah sudah pernah direview (Opsional, agar tidak double review)
        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->where('order_id', $orderId)
            ->first();

        if ($existingReview) {
            return redirect()->route('orders.show', $orderId)->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        $product = Product::findOrFail($productId);

        return view('reviews.create', compact('product', 'orderId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        // Verifikasi: Apakah user benar-benar membeli produk ini di order tersebut?
        $order = Order::where('id', $request->order_id)
            ->where('user_id', $user->id)
            ->where('status', 'completed') // Hanya order selesai
            ->firstOrFail();

        // Cek apakah produk ada di dalam order
        $hasProduct = $order->items()->where('product_id', $request->product_id)->exists();

        if (!$hasProduct) {
            return back()->with('error', 'Invalid product for this order.');
        }

        // Cek apakah sudah pernah review sebelumnya
        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product for this order.');
        }

        Review::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('orders.show', $request->order_id)->with('success', 'Thank you for your review!');
    }
}
