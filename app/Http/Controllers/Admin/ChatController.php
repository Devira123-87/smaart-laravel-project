<?php
// Kegunaan file: Menyediakan daftar percakapan dan aksi balas atau tutup chat untuk admin.

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    // Tampilkan daftar percakapan dan pesan agar admin dapat meninjau chat.
    public function index(Request $request): View
    {
        $conversations = ChatConversation::query()
            ->with('latestMessage')
            ->latest('last_message_at')
            ->latest()
            ->limit(100)
            ->get();

        $conversation = $request->filled('conversation')
            ? $conversations->firstWhere('id', (int) $request->query('conversation'))
            : $conversations->first();

        $conversation?->load(['messages' => fn ($query) => $query->orderBy('id')]);

        return view('admin.chats.index', compact('conversations', 'conversation'));
    }

    // Simpan balasan admin dan nonaktifkan balasan otomatis pada percakapan ini.
    public function reply(Request $request, ChatConversation $conversation): RedirectResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $message = trim($validated['message']);

        if ($message === '') {
            return back()->withErrors(['message' => 'Pesan tidak boleh kosong.']);
        }

        if ($conversation->status === 'closed') {
            return back()->withErrors(['message' => 'Percakapan sudah ditutup.']);
        }

        $conversation->messages()->create([
            'message' => $message,
            'sender_type' => 'admin',
    
            'is_bot' => false,
        ]);
        $conversation->forceFill([
            'status' => 'with_admin',
            'is_bot_active' => false,
            'last_message_at' => now(),
        ])->save();

        return redirect()->route('admin.chats.index', ['conversation' => $conversation->id])
            ->with('success', 'Balasan berhasil dikirim.');
    }

    // Tandai percakapan selesai dan blokir pesan baru dari pengunjung.
    public function close(ChatConversation $conversation): RedirectResponse
    {
        $conversation->forceFill([
            'status' => 'closed',
            'is_bot_active' => false,
            'last_message_at' => now(),
        ])->save();

        return redirect()->route('admin.chats.index', ['conversation' => $conversation->id])
            ->with('success', 'Percakapan ditutup.');
    }
}
