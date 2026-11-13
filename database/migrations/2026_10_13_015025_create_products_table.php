<?php
// Kegunaan file: Membuat tabel katalog produk.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Buat tabel untuk menyimpan informasi katalog produk. */
    public function up(): void
    {
         Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->string('tagline')->nullable();
        $table->text('description');
        $table->string('image')->nullable();
        $table->string('website_url')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        });
    }

    /** Hapus tabel produk jika migrasi dibatalkan. */
    public function down(): void
    {
        Schema::dropIfExists('products');
        
    }
};
