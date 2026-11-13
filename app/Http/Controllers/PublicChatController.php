<?php
// Kegunaan file: Melayani permintaan API widget chat pengunjung dan riwayat percakapannya.

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Services\ChatbotReplyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicChatController extends Controller
{
    // Kirim riwayat chat milik pengunjung berdasarkan token sesi.
    public function show(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_token' => ['required', 'uuid'],
        ]);

        $conversation = ChatConversation::query()
            ->where('session_token', $validated['session_token'])
            ->first();

        return response()->json($this->conversationPayload($conversation));
    }

    // Simpan pesan pengunjung dan buat balasan otomatis jika bot masih aktif.
    public function send(Request $request, ChatbotReplyService $chatbot): JsonResponse
    {
        $validated = $request->validate([
            'session_token' => ['required', 'uuid'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        if (trim($validated['message']) === '') {
            return response()->json(['message' => 'Pesan tidak boleh kosong.'], 422);
        }

        $payload = DB::transaction(function () use ($validated, $chatbot) {
            $conversation = ChatConversation::firstOrCreate(
                ['session_token' => $validated['session_token']],
                ['status' => 'open', 'is_bot_active' => true]
            );

            if ($conversation->status === 'closed') {
                return ['closed' => true];
            }

            $conversation->messages()->create([
                'message' => trim($validated['message']),
                'sender_type' => 'visitor',
                'is_bot' => false,
            ]);

            if ($conversation->is_bot_active) {
                $answer = $chatbot->reply($validated['message']);

                if ($answer['handoff']) {
                    $conversation->status = 'waiting_admin';
                    $conversation->is_bot_active = false;
                }

                $conversation->messages()->create([
                    'message' => $answer['reply'],
                    'sender_type' => 'bot',
                    'is_bot' => true,
                ]);
            }

            $conversation->last_message_at = now();
            $conversation->save();

            return $this->conversationPayload($conversation->fresh());
        });

        if (($payload['closed'] ?? false) === true) {
            return response()->json([
                'message' => 'Percakapan ini sudah ditutup. Mulai chat baru untuk mengirim pesan lagi.',
            ], 409);
        }

        return response()->json($payload);
    }

    // Hentikan balasan bot dan pindahkan percakapan ke antrean admin.
    public function handoff(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_token' => ['required', 'uuid'],
        ]);

        $conversation = DB::transaction(function () use ($validated) {
            $conversation = ChatConversation::firstOrCreate(
                ['session_token' => $validated['session_token']],
                ['status' => 'open', 'is_bot_active' => true]
            );

            if ($conversation->status === 'closed') {
                return null;
            }

            if ($conversation->is_bot_active) {
                $conversation->is_bot_active = false;
                $conversation->status = 'waiting_admin';
                $conversation->messages()->create([
                    'message' => 'Permintaan bantuan admin diterima. Silakan tuliskan kebutuhan Anda; tim SMAART akan membalas melalui chat ini.',
                    'sender_type' => 'bot',
                    'is_bot' => true,
                ]);
                $conversation->last_message_at = now();
                $conversation->save();
            }

            return $conversation->fresh();
        });

        if (! $conversation) {
            return response()->json([
                'message' => 'Percakapan ini sudah ditutup. Mulai chat baru untuk meminta bantuan lagi.',
            ], 409);
        }

        return response()->json($this->conversationPayload($conversation));
    }

    // Samakan bentuk data percakapan yang dikirim kembali ke widget chat.
    private function conversationPayload(?ChatConversation $conversation): array
    {
        return [
            'status' => $conversation?->status ?? 'open',
            'messages' => $conversation
                ? $conversation->messages()
                    ->latest('id')
                    ->limit(200)
                    ->get(['id', 'message', 'sender_type', 'is_bot', 'created_at'])
                    ->reverse()
                    ->map(fn (ChatMessage $message) => [
                        'id' => $message->id,
                        'message' => $message->message,
                        'sender_type' => $message->sender_type,
                        'is_bot' => $message->is_bot,
                        'created_at' => $message->created_at?->toIso8601String(),
                    ])
                    ->values()
                : [],
        ];
    }
}
