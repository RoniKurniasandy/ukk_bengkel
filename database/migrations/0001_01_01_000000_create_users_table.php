<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id(); // id default Laravel
        $table->string('nama'); // ganti dari 'name' ke 'nama'
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('email_verification_code')->nullable();
        $table->string('password');
        $table->decimal('total_transaksi', 15, 2)->default(0);
        $table->foreignId('membership_tier_id')->nullable(); // FK constraint added in create_membership_tiers_table
        $table->string('foto')->nullable();
        $table->string('no_hp')->nullable()->unique();
        $table->string('pending_no_hp')->nullable();
        $table->string('phone_verification_code')->nullable();
        $table->text('alamat')->nullable();
        $table->string('role')->default('pelanggan');
        $table->rememberToken();
        $table->timestamps();
    });
}
};