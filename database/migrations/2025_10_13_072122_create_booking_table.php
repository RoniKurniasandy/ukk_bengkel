<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id('booking_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('kendaraan_id');
            $table->enum('jenis_layanan', ['servis mesin', 'listrik', 'tune up', 'ganti oli', 'aki', 'ganti ban', 'servis AC']);
            $table->text('keluhan')->nullable();
            $table->dateTime('tanggal_booking');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'dibatalkan', 'selesai'])->default('menunggu');
            $table->timestamps();
            $table->string('jenis_servis')->after('user_id');
            $table->dropForeign(['servis_id']);
            $table->dropColumn('servis_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
