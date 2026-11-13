<?php
// Kegunaan file: Membuat tabel pilar layanan.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Buat tabel untuk menyimpan pilar layanan website. */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->string('category')->nullable();
        $table->text('description');
        $table->string( 'icon')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        });
    }

    /** Hapus tabel layanan jika migrasi dibatalkan. */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
