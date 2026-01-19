<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('transaksi_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('servis_id')->nullable()->constrained('servis')->onDelete('set null');
            
            // Optional: Link to stock for direct sales/purchases
            $table->unsignedBigInteger('stok_id')->nullable();
            $table->foreign('stok_id')->references('stok_id')->on('stok')->onDelete('set null');
            $table->integer('jumlah')->nullable();

            $table->enum('jenis_transaksi', ['pemasukan', 'pengeluaran'])->default('pemasukan');
            $table->string('sumber')->default('servis'); // servis, belanja_stok, penjualan_stok
            
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('diskon_member', 15, 2)->default(0);
            $table->decimal('diskon_voucher', 15, 2)->default(0);
            $table->string('kode_voucher')->nullable();
            $table->decimal('diskon_manual', 15, 2)->default(0);
            $table->string('alasan_diskon_manual')->nullable();
            $table->decimal('grand_total', 15, 2)->default(0);

            $table->decimal('total', 15, 2)->default(0); // Increased size
            $table->string('status', 50)->default('pending');
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
