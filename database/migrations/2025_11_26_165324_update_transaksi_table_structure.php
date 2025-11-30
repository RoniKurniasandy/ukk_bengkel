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
        Schema::table('transaksi', function (Blueprint $table) {
            if (!Schema::hasColumn('transaksi', 'jenis_transaksi')) {
                $table->enum('jenis_transaksi', ['pemasukan', 'pengeluaran'])->default('pemasukan')->after('servis_id');
            }
            if (!Schema::hasColumn('transaksi', 'sumber')) {
                $table->string('sumber')->default('servis')->after('jenis_transaksi'); // servis, belanja_stok, penjualan_stok
            }
            if (!Schema::hasColumn('transaksi', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('total');
            }
            // Optional: Link to stock for stock transactions
            if (!Schema::hasColumn('transaksi', 'stok_id')) {
                $table->unsignedBigInteger('stok_id')->nullable()->after('servis_id');
                $table->foreign('stok_id')->references('stok_id')->on('stok')->onDelete('set null');
            }
            if (!Schema::hasColumn('transaksi', 'jumlah')) {
                $table->integer('jumlah')->nullable()->after('stok_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign(['stok_id']);
            $table->dropColumn(['jenis_transaksi', 'sumber', 'keterangan', 'stok_id', 'jumlah']);
        });
    }
};
