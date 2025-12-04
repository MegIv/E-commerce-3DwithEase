<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cari atau Buat User Seller
        // Kita set status langsung 'active' agar bisa langsung akses dashboard
        $seller = User::firstOrCreate(
            ['email' => 'seller@example.com'], 
            [
                'name' => 'Seller One',
                'role' => 'seller',
                'status' => 'active', 
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Pastikan User tersebut punya Toko (Store)
        // Gunakan updateOrCreate untuk mencegah duplikasi jika seeder dijalankan ulang
        Store::updateOrCreate(
            ['user_id' => $seller->id], // Kunci pencarian: Toko milik user ID ini
            [
                'name' => 'Toko Seller One',
                'slug' => Str::slug('Toko Seller One'),
                'description' => 'Ini adalah toko contoh (dummy) untuk testing aplikasi.',
                'logo' => null, // Biarkan null atau isi path gambar jika ada
            ]
        );

        // Opsional: Output ke terminal agar kita tahu proses berhasil
        $this->command->info('Seller User & Store data seeded successfully!');
    }
}