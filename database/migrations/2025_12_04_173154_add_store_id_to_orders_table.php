<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom store_id setelah user_id
            // constrained() otomatis menghubungkan ke tabel stores
            // nullable() ditambahkan sementara agar tidak error jika sudah ada data order lama
            // Jika database masih kosong/bisa direset, hapus ->nullable()
            $table->foreignId('store_id')
                  ->nullable() 
                  ->after('user_id')
                  ->constrained('stores')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus foreign key dulu, baru kolomnya
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });
    }
};