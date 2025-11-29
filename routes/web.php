<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerStatusController;    
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
    Route::get('/dashboard', function() {
        return view('dashboard.admin.home');
    })->name('dashboard');

    // space yg nantinya menambahkan: user management, category management
});

// route khusus seller (active only)
// Note: kita butuh middleware 'seller' yg mengecek role=seller dan status=active
Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', function() {
        // cek status manual sementara sebelum buat middleware khusus
        if (Auth::user()->role !== 'seller' || Auth::user()->status !== 'active') {
            return redirect()->route('seller.status');
        }
        return view('dashboard.seller.home');
    })->name('dashboard');

    // Product Resource sementara
    Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';
