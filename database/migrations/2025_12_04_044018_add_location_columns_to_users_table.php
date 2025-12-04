<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom lokasi di tabel 'users' (Untuk Driver)
        Schema::table('users', function (Blueprint $table) {
            // Kita cek dulu biar tidak error kalau sudah ada
            if (!Schema::hasColumn('users', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->boolean('is_online')->default(false); // Status Driver Aktif/Tidak
            }
        });

        // 2. Tambah kolom lokasi tujuan di tabel 'orders' (Untuk Customer)
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'dest_latitude')) {
                $table->decimal('dest_latitude', 10, 8)->nullable();
                $table->decimal('dest_longitude', 11, 8)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'is_online']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['dest_latitude', 'dest_longitude']);
        });
    }
};