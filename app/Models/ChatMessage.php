<?php
// Kegunaan file: Mewakili satu pesan dan percakapan tempat pesan tersebut berada.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Model satu pesan; relasi menghubungkan pesan ke percakapannya.
class ChatMessage extends Model
{
    // Kolom pesan yang boleh disimpan melalui aplikasi.
    protected $fillable = [
        'conversation_id',
        'message',
        'sender_type',
        'is_bot', 
    ];

    // Baca penanda bot sebagai nilai benar atau salah.
    protected $casts = [
        'is_bot' => 'boolean',
    ];
    
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(ChatConversation::class, 'conversation_id');
    }
}
