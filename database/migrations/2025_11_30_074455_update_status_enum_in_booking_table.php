<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menggunakan raw SQL untuk mengubah kolom ENUM karena Doctrine DBAL memiliki keterbatasan dengan ENUM
        DB::statement("ALTER TABLE booking MODIFY COLUMN status ENUM('menunggu', 'disetujui', 'dikerjakan', 'ditolak', 'dibatalkan', 'selesai') DEFAULT 'menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke status semula (hati-hati jika ada data 'dikerjakan' akan error/truncated)
        // Kita biarkan saja atau ubah ke string jika perlu rollback aman.
        // Untuk safety, kita tidak rollback paksa ke enum yang lebih kecil jika ada data.
        // Tapi untuk structure, ini kebalikannya:
        DB::statement("ALTER TABLE booking MODIFY COLUMN status ENUM('menunggu', 'disetujui', 'ditolak', 'dibatalkan', 'selesai') DEFAULT 'menunggu'");
    }
};
