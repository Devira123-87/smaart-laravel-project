<?php
// Kegunaan file: Berisi pengujian otomatis untuk memastikan perilaku aplikasi berjalan sesuai harapan.

namespace Tests\Feature;

use App\Models\ChatConversation;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    // Memastikan pesan disimpan dan mendapat balasan otomatis tanpa layanan AI eksternal.

    public function test_visitor_messages_are_saved_with_an_automatic_answer_without_an_ai_provider(): void
    {
        $response = $this->postJson('/api/chat', [
            'session_token' => '84fd7305-cf21-4f54-8f9a-998841a73d92',
            'message' => 'Bagaimana cara menghubungi SMAART?',
        ]);

        $response->assertOk()
            ->assertJsonPath('status', 'open')
            ->assertJsonCount(2, 'messages')
            ->assertJsonPath('messages.0.sender_type', 'visitor')
            ->assertJsonPath('messages.1.sender_type', 'bot')
            ->assertJsonPath('messages.1.is_bot', true)
            ->assertJsonPath('messages.1.message', fn ($message) => str_contains($message, 'info@smaart.id'));

        $conversation = ChatConversation::where('session_token', '84fd7305-cf21-4f54-8f9a-998841a73d92')->firstOrFail();
        $this->assertDatabaseCount('chat_messages', 2);
        $this->assertNotNull($conversation->last_message_at);
    }

    // Memastikan jawaban produk memakai data katalog aktif.

    public function test_product_questions_use_active_catalog_content(): void
    {
        Product::create([
            'name' => 'SMAART Catalog Test',
            'slug' => 'smaart-catalog-test',
            'tagline' => 'Layanan katalog digital',
            'description' => 'Membantu bisnis mengelola produk.',
            'is_active' => true,
        ]);

        $response = $this->postJson('/api/chat', [
            'session_token' => 'de66b46e-30e3-43a3-9d79-63861dbe4cd1',
            'message' => 'Ceritakan produk SMAART',
        ]);

        $response->assertOk()
            ->assertJsonPath('messages.1.message', fn ($message) => str_contains($message, 'SMAART Catalog Test'));
    }

    // Memastikan pengunjung dapat memuat kembali riwayat chat.

    public function test_visitor_can_load_their_saved_chat_history(): void
    {
        $conversation = ChatConversation::create([
            'session_token' => '4c82a1b8-febb-4f88-84db-6f0615ea00e0',
        ]);
        $conversation->messages()->create([
            'message' => 'Halo',
            'sender_type' => 'visitor',
        ]);

        $this->getJson('/api/chat?session_token='.$conversation->session_token)
            ->assertOk()
            ->assertJsonPath('status', 'open')
            ->assertJsonCount(1, 'messages')
            ->assertJsonPath('messages.0.message', 'Halo');
    }

    // Memastikan chat dapat dialihkan ke admin dan bot berhenti membalas.

    public function test_visitor_can_request_admin_handoff_and_further_messages_are_saved_without_bot_replies(): void
    {
        $token = 'c0ab4d4f-0dc5-49f2-a33e-15ea91d70242';
        $this->postJson('/api/chat', [
            'session_token' => $token,
            'message' => 'Tolong hubungkan saya ke admin',
        ])->assertOk()
            ->assertJsonPath('status', 'waiting_admin');

        $this->postJson('/api/chat', [
            'session_token' => $token,
            'message' => 'Saya perlu bantuan lebih lanjut.',
        ])->assertOk()
            ->assertJsonPath('status', 'waiting_admin')
            ->assertJsonCount(3, 'messages');

        $this->assertDatabaseCount('chat_messages', 3);
        $this->assertDatabaseHas('chat_conversations', [
            'session_token' => $token,
            'is_bot_active' => false,
            'status' => 'waiting_admin',
        ]);
    }

    // Memastikan tombol chat dapat meminta bantuan admin.

    public function test_visitor_can_request_admin_from_the_chat_widget(): void
    {
        $this->postJson('/api/chat/handoff', [
            'session_token' => '7fc12457-2d83-446a-a159-2b38a82cbcb1',
        ])->assertOk()
            ->assertJsonPath('status', 'waiting_admin')
            ->assertJsonCount(1, 'messages');
    }

    // Memastikan token sesi tidak valid dan pesan kosong ditolak.

    public function test_invalid_session_tokens_and_empty_messages_are_rejected(): void
    {
        $this->postJson('/api/chat', [
            'session_token' => 'invalid',
            'message' => 'Halo',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['session_token']);

        $this->postJson('/api/chat', [
            'session_token' => '5a029e72-4d77-4124-8a8f-82249cfc5e1f',
            'message' => '   ',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['message']);
    }

    // Memastikan admin dapat membaca dan membalas chat yang dialihkan.

    public function test_admin_can_read_and_reply_to_a_handed_off_conversation(): void
    {
        $conversation = ChatConversation::create([
            'session_token' => 'ed46ca5b-e96f-41ce-89c5-339ae636529d',
            'status' => 'waiting_admin',
            'is_bot_active' => false,
        ]);
        $conversation->messages()->create([
            'message' => 'Saya ingin bicara dengan admin.',
            'sender_type' => 'visitor',
        ]);

        $this->get(route('admin.chats.index'))
            ->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create())
            ->get(route('admin.chats.index', ['conversation' => $conversation->id]))
            ->assertOk()
            ->assertSee('Saya ingin bicara dengan admin.')
            ->assertSee('Kirim balasan');

        $this->post(route('admin.chats.reply', $conversation), [
            'message' => 'Halo, tim SMAART siap membantu.',
        ])->assertRedirect(route('admin.chats.index', ['conversation' => $conversation->id]))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('chat_messages', [
            'conversation_id' => $conversation->id,
            'message' => 'Halo, tim SMAART siap membantu.',
            'sender_type' => 'admin',
        ]);
        $this->assertDatabaseHas('chat_conversations', [
            'id' => $conversation->id,
            'status' => 'with_admin',
            'is_bot_active' => false,
        ]);

        $this->getJson('/api/chat?session_token='.$conversation->session_token)
            ->assertOk()
            ->assertJsonPath('status', 'with_admin')
            ->assertJsonPath('messages.1.sender_type', 'admin');
    }

    // Memastikan admin tidak dapat mengirim balasan kosong.

    public function test_admin_cannot_send_an_empty_reply_to_a_conversation(): void
    {
        $conversation = ChatConversation::create([
            'session_token' => '01cfd5e0-74f5-42fd-bf12-1d2e903e0df0',
            'status' => 'waiting_admin',
            'is_bot_active' => false,
        ]);

        $this->actingAs(User::factory()->create())
            ->from(route('admin.chats.index', ['conversation' => $conversation->id]))
            ->post(route('admin.chats.reply', $conversation), [
                'message' => "   \n\t  ",
            ])
            ->assertRedirect(route('admin.chats.index', ['conversation' => $conversation->id]))
            ->assertSessionHasErrors(['message']);

        $this->assertDatabaseCount('chat_messages', 0);
    }

    // Memastikan chat yang ditutup tidak menerima pesan baru.

    public function test_admin_can_close_a_conversation_and_closed_visitors_cannot_send_more_messages(): void
    {
        $conversation = ChatConversation::create([
            'session_token' => 'a4362bd2-93ca-48c9-8503-108824822ec5',
        ]);

        $this->actingAs(User::factory()->create())
            ->post(route('admin.chats.close', $conversation))
            ->assertRedirect(route('admin.chats.index', ['conversation' => $conversation->id]));

        $this->postJson('/api/chat', [
            'session_token' => $conversation->session_token,
            'message' => 'Apakah masih bisa mengirim?',
        ])->assertStatus(409);

        $this->assertDatabaseMissing('chat_messages', [
            'conversation_id' => $conversation->id,
            'message' => 'Apakah masih bisa mengirim?',
        ]);
    }
}
