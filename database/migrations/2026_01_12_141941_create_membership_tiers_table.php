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
        Schema::create('membership_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_level')->unique(); // Bronze, Silver, Gold
            $table->decimal('min_transaksi', 15, 2)->default(0); // Syarat total belanja
            $table->decimal('diskon_jasa', 5, 2)->default(0); // Persen diskon jasa (0-100)
            $table->decimal('diskon_part', 5, 2)->default(0); // Persen diskon part (0-100)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_tiers');
    }
};
