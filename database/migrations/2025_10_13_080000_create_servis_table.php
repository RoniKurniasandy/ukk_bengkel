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
        Schema::create('servis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id')->references('booking_id')->on('booking')->onDelete('cascade');
            
            $table->foreignId('mekanik_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->decimal('estimasi_biaya', 12, 2)->default(0);
            $table->enum('status', ['dikerjakan', 'selesai'])->default('dikerjakan');
            
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            
            $table->timestamps();
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
