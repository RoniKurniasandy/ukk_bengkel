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
        Schema::table('transaksi', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('transaksi', 'subtotal')) {
                $table->decimal('subtotal', 15, 2)->default(0)->after('sumber');
            }
            $table->decimal('diskon_member', 15, 2)->default(0)->after('subtotal');
            $table->decimal('diskon_voucher', 15, 2)->default(0)->after('diskon_member');
            $table->string('kode_voucher')->nullable()->after('diskon_voucher');
            $table->decimal('diskon_manual', 15, 2)->default(0)->after('kode_voucher');
            $table->string('alasan_diskon_manual')->nullable()->after('diskon_manual');
            $table->decimal('grand_total', 15, 2)->default(0)->after('alasan_diskon_manual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
             $table->dropColumn([
                'subtotal', 
                'diskon_member', 
                'diskon_voucher', 
                'kode_voucher', 
                'diskon_manual', 
                'alasan_diskon_manual', 
                'grand_total'
            ]);
        });
    }
};
