{{-- Kegunaan file: Tampilan daftar pilar layanan yang dapat dikelola admin. --}}
@extends('admin.layouts.app')

@section('title', 'Pilar Strategis')
@section('eyebrow', 'KONTEN WEBSITE')
@section('heading', 'Pilar Strategis')
@section('description', 'Kelola pilar, deskripsi, dan daftar layanan yang ditampilkan di beranda SMAART.')
@section('heading-action')
    <a class="button button-primary" href="{{ route('admin.services.create') }}"><span aria-hidden="true">+</span> Tambah pilar</a>
@endsection

@section('content')
    <section class="panel">
        <form class="table-toolbar" method="GET" action="{{ route('admin.services.index') }}">
            <label class="search-field">
                <span class="sr-only">Cari pilar strategis</span>
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.3"></circle><path d="m15.5 15.5 4.2 4.2"></path></svg>
                <input type="search" name="search" value="{{ $search }}" placeholder="Cari nama pilar, slug, atau kategori">
            </label>
            <button class="button button-secondary" type="submit">Cari</button>
            @if ($search !== '')<a class="clear-search" href="{{ route('admin.services.index') }}">Hapus pencarian</a>@endif
        </form>
        @if ($services->isEmpty())
            <div class="empty-state">{{ $search !== '' ? 'Tidak ada pilar yang cocok dengan pencarian.' : 'Belum ada pilar. Tambahkan pilar pertama untuk mulai mengelola konten.' }}</div>
        @else
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Nama pilar</th><th>Kategori</th><th>Status</th><th class="actions-heading">Aksi</th></tr></thead>
                    <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <td><strong>{{ $service->name }}</strong><small class="cell-subtext">{{ $service->slug }}</small></td>
                            <td>{{ $service->category ?: '—' }}</td>
                            <td><span @class(['status-badge', 'status-active' => $service->is_active, 'status-inactive' => ! $service->is_active])>{{ $service->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td class="row-actions">
                                <a class="action-link" href="{{ route('admin.services.edit', $service) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" data-confirm="Hapus pilar {{ $service->name }}? Tindakan ini tidak dapat dibatalkan.">
                                    @csrf @method('DELETE')
                                    <button class="action-link action-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="table-footer"><span>Menampilkan {{ $services->firstItem() }}–{{ $services->lastItem() }} dari {{ $services->total() }} pilar</span>{{ $services->links() }}</div>
        @endif
    </section>
@endsection