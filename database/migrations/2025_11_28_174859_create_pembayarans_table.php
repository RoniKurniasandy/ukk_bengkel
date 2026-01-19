<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servis_id');
            $table->decimal('jumlah', 10, 2);
            $table->decimal('subtotal', 15, 2)->nullable();
            $table->decimal('diskon_member', 15, 2)->default(0);
            $table->decimal('diskon_voucher', 15, 2)->default(0);
            $table->string('kode_voucher')->nullable();
            $table->decimal('grand_total', 15, 2)->nullable();
            $table->decimal('diskon_manual', 15, 2)->default(0);
            $table->string('alasan_diskon_manual')->nullable();
            $table->enum('jenis_pembayaran', ['dp', 'pelunasan', 'full']); // dp = down payment, pelunasan = sisa, full = bayar lunas langsung
            $table->string('metode_pembayaran')->default('tunai'); // tunai, transfer
            $table->string('bukti_pembayaran')->nullable(); // path gambar
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('servis_id')->references('id')->on('servis')->onDelete('cascade');
        });

        Schema::table('servis', function (Blueprint $table) {
            if (!Schema::hasColumn('servis', 'status_pembayaran')) {
                $table->enum('status_pembayaran', ['belum_bayar', 'dp_lunas', 'lunas'])->default('belum_bayar')->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');

        Schema::table('servis', function (Blueprint $table) {
            if (Schema::hasColumn('servis', 'status_pembayaran')) {
                $table->dropColumn('status_pembayaran');
            }
        });
    }
};
