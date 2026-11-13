<?php
// Kegunaan file: Membuat tabel token reset kata sandi.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Buat tabel untuk menyimpan token reset kata sandi. */
    public function up(): void 
    {
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /** Hapus tabel token reset kata sandi jika migrasi dibatalkan. */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};
