<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerStatusController; 
use App\Http\Controllers\AdminController;   
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

// Route untuk buyer/dashboard umum
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// grup auth umum (profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/// Route khusus seller (status pending/rejected)
Route::middleware(['auth'])->group(function () {
    Route::get('/seller/status', [SellerStatusController::class, 'index'])->name('seller.status');
    Route::delete('/seller/account', [SellerStatusController::class, 'destroy'])->name('seller.destroy');
});

/// Route khusus seller (active only)
    // Note: kita butuh middleware 'seller' yg mengecek role=seller dan status=active
Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    
    // cek status middleware (dipindahkan ke CheckActiveMiddleware yg tadinya inline namun error)
    Route::middleware('active.seller')->group(function (){

        // dashboard
        Route::get('/dashboard', function() {
            $store = Auth::user()->store;
            $productCount = $store->products()->count();
            // menghitung order yang masuk ke toko ini
            $orderCount = \App\Models\Order::whereHas('items.product', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })->count();

            return view('dashboard.seller.home', compact('productCount'));
        })->name('dashboard');

        // Product management (resource)
        Route::resource('products', ProductController::class);

        // Store management 
        Route::get('/store/edit', [StoreController::class, 'edit'])->name('store.edit');
        Route::patch('/store/update', [StoreController::class, 'update'])->name('store.update');
        

        // Order management
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}', [SellerOrderController::class, 'update'])->name('orders.update');
    });
});

// Route khusus admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // dashboard utama (statistik singkat, verifikasi seller)
    Route::get('/dashboard', function() {
        return view('dashboard.admin.home');
    })->name('dashboard');

    // action: verifikai seller
    Route::patch('/seller/{id}/approve', [AdminController::class, 'approveSeller'])->name('seller.approve');
    Route::patch('/seller/{id}/reject', [AdminController::class, 'rejectSeller'])->name('seller.reject');

    // manajemen user
    Route::get('/users', [AdminController::class, 'user'])->name('users');
    Route::delete('/user/{id}', [AdminController::class, 'destroyUser'])->name('user.destroy');

    // manajemen kategori
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Route Public (Bisa diakses Guest)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop.show');

// Route Khusus Buyer (Cart & Checkout)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Update Dashboard User untuk menampilkan Order History
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/auth.php';
