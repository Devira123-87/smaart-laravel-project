<?php
// Kegunaan file: Membuat tabel untuk menyimpan percakapan pengunjung.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_name')->nullable();
            $table->string('visitor_email')->nullable();
            $table->string('session_token')->unique();
            $table->string('status')->default('open');
            $table->boolean('is_bot_active')->default(true);
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_conversations');
    }
};