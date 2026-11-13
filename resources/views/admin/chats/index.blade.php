{{-- Kegunaan file: Tampilan inbox percakapan agar admin dapat membaca dan membalas chat. --}}
@extends('admin.layouts.app')

@section('title', 'Live Chat')
@section('eyebrow', 'INBOX')
@section('heading', 'Live Chat')
@section('description', 'Tinjau percakapan pengunjung dan balas saat mereka meminta bantuan admin.')

@section('content')
    <div class="chat-inbox">
        <section class="panel chat-inbox-list" aria-label="Daftar percakapan">
            <div class="panel-heading">
                <div>
                    <h2>Percakapan</h2>
                    <p>{{ $conversations->count() }} percakapan terbaru</p>
                </div>
            </div>
            @forelse ($conversations as $item)
                <a
                    class="chat-inbox-item {{ $conversation?->id === $item->id ? 'is-selected' : '' }}"
                    href="{{ route('admin.chats.index', ['conversation' => $item->id]) }}"
                >
                    <span class="chat-inbox-item-top">
                        <strong>{{ $item->visitor_name ?: 'Pengunjung' }}</strong>
                        <span class="status-badge {{ $item->status === 'waiting_admin' ? 'status-active' : 'status-neutral' }}">{{ match ($item->status) {
                            'waiting_admin' => 'Perlu dibalas',
                            'with_admin' => 'Ditangani admin',
                            'closed' => 'Ditutup',
                            default => 'Bot aktif',
                        } }}</span>
                    </span>
                    <small>{{ $item->visitor_email ?: 'Pengunjung anonim' }}</small>
                    <small>{{ $item->latestMessage?->message ?: 'Belum ada pesan' }}</small>
                    <time>{{ $item->last_message_at?->format('d M Y, H:i') ?: $item->created_at?->format('d M Y, H:i') }}</time>
                </a>
            @empty
                <div class="empty-state">Belum ada percakapan. Pesan pengunjung akan muncul di sini.</div>
            @endforelse
        </section>

        <section class="panel chat-inbox-detail" aria-label="Isi percakapan">
            @if ($conversation)
                <div class="panel-heading chat-admin-heading">
                    <div>
                        <h2>{{ $conversation->visitor_name ?: 'Pengunjung' }}</h2>
                        <p>
                            {{ $conversation->visitor_email ?: 'Tanpa email' }}
                            <span>·</span>
                            Status:
                            {{ match ($conversation->status) {
                                'waiting_admin' => 'Menunggu admin',
                                'with_admin' => 'Ditangani admin',
                                'closed' => 'Ditutup',
                                default => 'Bot aktif',
                            } }}
                        </p>
                    </div>
                    @if ($conversation->status !== 'closed')
                        <form method="POST" action="{{ route('admin.chats.close', $conversation) }}" data-confirm="Tutup percakapan ini? Pengunjung tidak dapat mengirim pesan lagi di percakapan ini.">
                            @csrf
                            <button class="button button-secondary" type="submit">Tutup percakapan</button>
                        </form>
                    @endif
                </div>
                <div class="chat-admin-messages" role="log" aria-live="polite">
                    @forelse ($conversation->messages as $message)
                        <article @class(['chat-admin-message', 'is-visitor' => $message->sender_type === 'visitor', 'is-admin' => $message->sender_type === 'admin', 'is-bot' => $message->sender_type === 'bot'])>
                            <span>{{ match ($message->sender_type) {
                                'admin' => 'Admin',
                                'visitor' => 'Pengunjung',
                                default => 'Asisten otomatis',
                            } }}</span>
                            <p>{{ $message->message }}</p>
                            <time>{{ $message->created_at?->format('d M Y, H:i') }}</time>
                        </article>
                    @empty
                        <div class="empty-state">Belum ada pesan dalam percakapan ini.</div>
                    @endforelse
                </div>
                @if ($conversation->status !== 'closed')
                    <form class="chat-admin-reply" method="POST" action="{{ route('admin.chats.reply', $conversation) }}">
                        @csrf
                        <label class="sr-only" for="chat-admin-reply">Balasan admin</label>
                        <textarea id="chat-admin-reply" name="message" rows="3" maxlength="2000" required placeholder="Tulis balasan untuk pengunjung...">{{ old('message') }}</textarea>
                        <button class="button button-primary" type="submit">Kirim balasan</button>
                    </form>
                @else
                    <p class="chat-admin-closed">Percakapan ini sudah ditutup.</p>
                @endif
            @else
                <div class="empty-state">Pilih percakapan di sebelah kiri untuk melihat riwayat dan membalas.</div>
            @endif
        </section>
    </div>
@endsection
