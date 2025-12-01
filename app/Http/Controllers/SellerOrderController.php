<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerOrderController extends Controller
{
    public function index()
    {
        $storeId = Auth::user()->store->id;

        // Ambil pesanan yang memiliki item dari toko seller ini
        // Kita menggunakan whereHas untuk memfilter Order berdasarkan relasi items -> product -> store_id
        $orders = Order::whereHas('items.product', function ($query) use ($storeId) {
            $query->where('store_id', $storeId);
        })->with(['items.product' => function ($query) use ($storeId) {
            // Eager load hanya produk dari toko ini (opsional, untuk optimasi view)
            $query->where('store_id', $storeId);
        }, 'user'])->latest()->paginate(10);

        return view('dashboard.seller.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Pastikan seller berhak melihat order ini (salah satu itemnya milik seller)
        $storeId = Auth::user()->store->id;
        $isMyOrder = $order->items->contains(function ($item) use ($storeId) {
            return $item->product->store_id == $storeId;
        });

        if (!$isMyOrder) {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.seller.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending_payment,processing,completed,cancelled',
        ]);

        // DB Transaction untuk keamanan data
        DB::transaction(function() use ($request, $order) {
            
            // Cek Logika Pengembalian Stok
            // Jika status diubah jadi 'cancelled' DAN sebelumnya bukan cancelled
            if ($request->status === 'cancelled' && $order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    // Kembalikan stok
                    $item->product->increment('stock', $item->quantity);
                }
            }

            // TODO: (Opsional) Jika status diubah DARI 'cancelled' KE 'processing' (Re-open order),
            // Kita harus kurangi stok lagi (tapi hati-hati stok bisa minus).
            // Untuk aman, sebaiknya jangan izinkan un-cancel order.

            $order->update([
                'status' => $request->status,
            ]);
        });

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}