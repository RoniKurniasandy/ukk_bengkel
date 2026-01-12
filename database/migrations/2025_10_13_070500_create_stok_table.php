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
        Schema::create('stok', function (Blueprint $table) {
            $table->id('stok_id');
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->string('satuan')->nullable(); // e.g., "pcs", "liter"
            $table->integer('jumlah')->default(0); // quantity
            $table->string('nomor_seri')->nullable();
            $table->decimal('harga_beli', 12, 2)->default(0);
            $table->decimal('harga_jual', 12, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
