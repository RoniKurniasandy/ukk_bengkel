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
        if (Schema::hasTable('spareparts')) {
            Schema::rename('spareparts', 'stok');
        }

        Schema::table('stok', function (Blueprint $table) {
            // Rename columns if they exist with old names
            if (Schema::hasColumn('stok', 'id')) {
                $table->renameColumn('id', 'stok_id');
            }
            if (Schema::hasColumn('stok', 'kode_sparepart')) {
                $table->renameColumn('kode_sparepart', 'kode_barang');
            }
            if (Schema::hasColumn('stok', 'nama_sparepart')) {
                $table->renameColumn('nama_sparepart', 'nama_barang');
            }
            if (Schema::hasColumn('stok', 'stok')) {
                $table->renameColumn('stok', 'jumlah');
            }
            if (Schema::hasColumn('stok', 'harga')) {
                $table->renameColumn('harga', 'harga_jual');
            }
        });

        Schema::table('stok', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('stok', 'harga_beli')) {
                $table->decimal('harga_beli', 12, 2)->default(0)->after('harga_jual');
            }
            if (!Schema::hasColumn('stok', 'satuan')) {
                $table->string('satuan')->nullable()->after('nama_barang');
            }
            if (!Schema::hasColumn('stok', 'nomor_seri')) {
                $table->string('nomor_seri')->nullable()->after('jumlah');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok', function (Blueprint $table) {
            $table->dropColumn(['harga_beli', 'satuan', 'nomor_seri']);

            $table->renameColumn('stok_id', 'id');
            $table->renameColumn('kode_barang', 'kode_sparepart');
            $table->renameColumn('nama_barang', 'nama_sparepart');
            $table->renameColumn('jumlah', 'stok');
            $table->renameColumn('harga_jual', 'harga');
        });

        Schema::rename('stok', 'spareparts');
    }
};
