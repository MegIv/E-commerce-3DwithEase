<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Store extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'user_id',
        'name',
        'slug',
        'description',
        'logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi untuk mendapatkan produk toko
    public function products() : HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Relasi untuk mendapatkan review dari semua produk di toko ini
    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(
            Review::class,      // Model tujuan (Review)
            Product::class,     // Model perantara (Product)
            'store_id',         // Foreign key di tabel products
            'product_id',       // Foreign key di tabel reviews
            'id',               // Local key di tabel stores
            'id'                // Local key di tabel products
        );
    }

}
