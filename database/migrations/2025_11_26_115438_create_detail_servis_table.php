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
        Schema::create('detail_servis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servis_id');
            $table->unsignedBigInteger('stok_id');
            $table->integer('jumlah'); // Quantity used
            $table->decimal('harga_satuan', 12, 2); // Price snapshot at time of adding
            $table->decimal('subtotal', 12, 2); // Calculated: jumlah * harga_satuan
            $table->timestamps();

            // Foreign keys
            $table->foreign('servis_id')->references('id')->on('servis')->onDelete('cascade');
            $table->foreign('stok_id')->references('stok_id')->on('stok')->onDelete('restrict');

            // Prevent duplicate items in same service
            $table->unique(['servis_id', 'stok_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_servis');
    }
};
