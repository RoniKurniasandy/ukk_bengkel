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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->enum('tipe_diskon', ['nominal', 'persen'])->default('nominal');
            $table->decimal('nilai', 15, 2); // Nilai Rupiah atau Persen
            $table->decimal('min_transaksi', 15, 2)->default(0);
            $table->integer('kuota')->default(0); // 0 = unlimited, atau bisa pakai -1
            $table->dateTime('tgl_mulai')->nullable();
            $table->dateTime('tgl_berakhir')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
