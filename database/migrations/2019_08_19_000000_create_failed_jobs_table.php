<?php
// Kegunaan file: Membuat tabel pencatatan tugas antrean yang gagal.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Buat tabel untuk mencatat tugas antrean yang gagal dijalankan. */
    public function up(): void
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at  ')->useCurrent();
        });
    }

    /** Hapus tabel tugas gagal jika migrasi dibatalkan. */
    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
    }
};
