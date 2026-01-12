<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id('booking_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->onDelete('cascade');
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
            $table->foreignId('mekanik_id')->nullable()->constrained('users')->onDelete('set null'); // Mekanik uses users table
            $table->text('keluhan')->nullable();
            $table->dateTime('tanggal_booking');
            $table->time('jam_booking')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'dikerjakan', 'ditolak', 'dibatalkan', 'selesai'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
