<?php
// Kegunaan file: Membuat tabel token akses untuk autentikasi API.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Buat tabel token akses untuk autentikasi API. */
    public function up(): void
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /** Hapus tabel token akses jika migrasi dibatalkan. */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
