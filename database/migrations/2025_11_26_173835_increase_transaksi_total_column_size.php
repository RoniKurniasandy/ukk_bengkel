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
            // Change total column from decimal(10,2) to decimal(15,2)
            // This allows values up to 9,999,999,999,999.99 (almost 10 trillion)
            $table->decimal('total', 15, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->decimal('total', 10, 2)->default(0)->change();
        });
    }
};
