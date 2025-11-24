<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servis', function (Blueprint $table) {
            // Pastikan kolom booking_id belum ada sebelum menambah
            if (!Schema::hasColumn('servis', 'booking_id')) {
                $table->unsignedBigInteger('booking_id')->after('id')->nullable();
            }
            // Tambahkan foreign key jika belum ada
            $table->foreign('booking_id')->references('booking_id')->on('booking')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('servis', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropColumn('booking_id');
        });
    }
};
