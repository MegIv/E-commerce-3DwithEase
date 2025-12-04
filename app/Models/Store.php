<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Providers\FoundationServiceProvider;

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

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
