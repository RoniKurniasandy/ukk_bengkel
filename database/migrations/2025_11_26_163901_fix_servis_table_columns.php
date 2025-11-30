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
        Schema::table('servis', function (Blueprint $table) {
            if (Schema::hasColumn('servis', 'harga')) {
                $table->renameColumn('harga', 'estimasi_biaya');
            }
            if (Schema::hasColumn('servis', 'sparepart')) {
                $table->dropColumn('sparepart');
            }
        });
    }

    public function down(): void
    {
        Schema::table('servis', function (Blueprint $table) {
            $table->renameColumn('estimasi_biaya', 'harga');
            $table->string('sparepart')->nullable();
        });
    }
};
