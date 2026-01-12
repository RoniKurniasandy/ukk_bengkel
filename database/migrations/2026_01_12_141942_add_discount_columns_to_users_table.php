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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('total_transaksi', 15, 2)->default(0)->after('password');
            $table->foreignId('membership_tier_id')->nullable()->after('total_transaksi')->constrained('membership_tiers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['membership_tier_id']);
            $table->dropColumn(['membership_tier_id', 'total_transaksi']);
        });
    }
};
