<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Str; // Uncomment jika Trait UUID bermasalah

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data User yang akan dibuat
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => Hash::make('password'), // Password default
            ],
            [
                'name' => 'Seller One',
                'email' => 'seller@example.com',
                'role' => 'seller',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Buyer One',
                'email' => 'buyer@example.com',
                'role' => 'buyer',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            // Gunakan updateOrCreate untuk menghindari duplikasi email
            User::updateOrCreate(
                ['email' => $userData['email']], // Kunci pencarian
                $userData // Data yang akan diisi/diupdate
            );
        }
    }
}