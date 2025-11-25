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
        Schema::table('booking', function (Blueprint $table) {
            // Remove unused columns
            $table->dropColumn(['jenis_layanan', 'jenis_servis']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            // Restore columns if needed
            $table->enum('jenis_layanan', ['servis mesin', 'listrik', 'tune up', 'ganti oli', 'aki', 'ganti ban', 'servis AC'])->nullable();
            $table->string('jenis_servis')->nullable();
        });
    }
};
