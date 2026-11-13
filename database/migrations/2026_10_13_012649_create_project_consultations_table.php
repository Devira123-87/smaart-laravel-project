<?php
// Kegunaan file: Membuat tabel permintaan konsultasi pengunjung.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Buat tabel untuk menyimpan formulir konsultasi pengunjung. */
    public function up(): void
    {
       Schema::create('project_consultations', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->string('phone')->nullable();
        $table->string('company')->nullable();
        $table->string('service');
        $table->text('message');
        $table->string('status')->default('baru');
        $table->timestamps();
        });
    }

    /** Hapus tabel konsultasi jika migrasi dibatalkan. */
    public function down(): void
    {
        Schema::dropIfExists('project_consultations');
    }
};
