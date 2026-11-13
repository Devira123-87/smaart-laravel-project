<?php
// Kegunaan file: Mewakili satu percakapan pengunjung dan relasinya dengan pesan-pesan chat.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

// Satu percakapan pengunjung memiliki banyak pesan dan satu pesan terbaru.
class ChatConversation extends Model
{
    // Kolom percakapan yang boleh diisi melalui aplikasi.
    protected $fillable = [
        'visitor_name',
        'visitor_email',
        'session_token',
        'status',
        'is_bot_active',
        'last_message_at',
    ];
    
    // Ubah status bot dan waktu pesan terakhir ke tipe data yang sesuai.
    protected $casts = [
        'is_bot_active' => 'boolean',
        'last_message_at' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(ChatMessage::class, 'conversation_id')->latestOfMany();
    }
}
