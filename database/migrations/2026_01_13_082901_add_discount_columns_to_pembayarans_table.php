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
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->decimal('subtotal', 15, 2)->after('jumlah')->nullable();
            $table->decimal('diskon_member', 15, 2)->after('subtotal')->default(0);
            $table->decimal('diskon_voucher', 15, 2)->after('diskon_member')->default(0);
            $table->string('kode_voucher')->after('diskon_voucher')->nullable();
            $table->decimal('grand_total', 15, 2)->after('kode_voucher')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'diskon_member', 'diskon_voucher', 'kode_voucher', 'grand_total']);
        });
    }
};
