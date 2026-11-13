<?php
// Kegunaan file: Berisi pengujian otomatis untuk memastikan perilaku aplikasi berjalan sesuai harapan.

namespace Tests\Feature;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatConversationTest extends TestCase
{
    use RefreshDatabase;

    // Memastikan pesan terhubung ke percakapan yang benar.

    public function test_conversation_and_messages_are_connected(): void
    {
        $conversation = ChatConversation::create([
            'session_token' => 'visitor-session-123',
            'is_bot_active' => true,
        ]);

        $message = $conversation->messages()->create([
            'message' => 'Halo, saya ingin tahu layanan SMAART.',
            'sender_type' => 'visitor',
            'is_bot' => false,
        ]);

        $this->assertInstanceOf(ChatMessage::class, $conversation->messages()->first());
        $this->assertTrue($conversation->refresh()->is_bot_active);
        $this->assertSame($conversation->id, $message->conversation->id);
        $this->assertFalse($message->is_bot);
    }

    // Memastikan pesan ikut terhapus saat percakapannya dihapus.

    public function test_deleting_a_conversation_deletes_its_messages(): void
    {
        $conversation = ChatConversation::create([
            'session_token' => 'visitor-session-456',
        ]);

        $message = $conversation->messages()->create([
            'message' => 'Pesan pengunjung',
            'sender_type' => 'visitor',
        ]);

        $conversation->delete();

        $this->assertDatabaseMissing('chat_messages', ['id' => $message->id]);
    }
}
