<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerStatusController; 
use App\Http\Controllers\AdminController;   
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

// route untuk buyer/dashboard umum
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// grup auth umum (profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// route khusus seller (status pending/rejected)
Route::middleware(['auth'])->group(function () {
    Route::get('/seller/status', [SellerStatusController::class, 'index'])->name('seller.status');
    Route::delete('/seller/account', [SellerStatusController::class, 'destroy'])->name('seller.destroy');
});

// route khusus admin
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

// route khusus seller (active only)
    // Note: kita butuh middleware 'seller' yg mengecek role=seller dan status=active
Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {

    // cek status middleware (inline)
    Route::middleware(function ($request, $next) {
        if (Auth::user()->role !== 'seller' || Auth::user()->status !== 'active') {
            return redirect()->route('seller.status');
        }
        return $next($request);
    })->group(function () {

    // dashboard
    Route::get('/dashboard', function() {
        $productCount = Auth::user()->store->products()->count();
        // nanti tambah orderCount di tahap selanjutnya
        return view('dashboard.seller.home', compact('productCount'));
    })->name('dashboard');

    // Product management (resource)
    Route::resource('products', ProductController::class);

    // Store management 
    Route::get('/store/edit', [StoreController::class, 'edit'])->name('store.edit');
    Route::patch('/store/update', [StoreController::class, 'update'])->name('store.update');
    });
});

require __DIR__.'/auth.php';
