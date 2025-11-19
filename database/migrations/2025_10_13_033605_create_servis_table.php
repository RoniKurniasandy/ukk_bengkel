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
        Schema::table('servis', function (Blueprint $table) {
            if (!Schema::hasColumn('servis', 'booking_id')) {
                $table->unsignedBigInteger('booking_id');
            }
            if (!Schema::hasColumn('servis', 'harga')) {
                $table->decimal('harga', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('servis', 'sparepart')) {
                $table->string('sparepart')->nullable();
            }
            if (!Schema::hasColumn('servis', 'status')) {
                $table->enum('status', ['dikerjakan', 'selesai'])->default('dikerjakan');
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servis');
    }
};
