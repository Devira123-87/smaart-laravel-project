{{-- Kegunaan file: Tampilan daftar dan pencarian permintaan konsultasi pengunjung. --}}
@extends('admin.layouts.app')

@section('title', 'Konsultasi Proyek')
@section('page-class', 'page-consultations')
@section('eyebrow', 'INBOX')
@section('heading', 'Konsultasi proyek')
@section('description', 'Permintaan konsultasi yang dikirim melalui formulir website.')

@section('content')
    <section class="panel">
        <form class="table-toolbar" method="GET" action="{{ route('admin.consultations.index') }}">
            <label class="search-field">
                <span class="sr-only">Cari konsultasi</span>
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.3"></circle><path d="m15.5 15.5 4.2 4.2"></path></svg>
                <input type="search" name="search" value="{{ $search }}" placeholder="Cari nama, email, perusahaan, layanan">
            </label>
            <button class="button button-secondary" type="submit">Cari</button>
            @if ($search !== '')<a class="clear-search" href="{{ route('admin.consultations.index') }}">Hapus pencarian</a>@endif
        </form>
        @if ($consultations->isEmpty())
            <div class="empty-state">{{ $search !== '' ? 'Tidak ada konsultasi yang cocok dengan pencarian.' : 'Belum ada konsultasi yang masuk.' }}</div>
        @else
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Kontak</th><th>Perusahaan</th><th>Layanan</th><th>Pesan</th><th>Status</th><th>Diterima</th></tr></thead>
                    <tbody>
                    @foreach ($consultations as $consultation)
                        <tr>
                            <td><strong>{{ $consultation->name }}</strong><a class="cell-subtext cell-email" href="mailto:{{ $consultation->email }}">{{ $consultation->email }}</a>@if ($consultation->phone)<small class="cell-subtext">{{ $consultation->phone }}</small>@endif</td>
                            <td>{{ $consultation->company ?: '—' }}</td>
                            <td>{{ $consultation->service }}</td>
                            <td class="message-cell" title="{{ $consultation->message }}">{{ $consultation->message }}</td>
                            <td><span @class(['status-badge', 'status-active' => strtolower($consultation->status) === 'baru', 'status-neutral' => strtolower($consultation->status) !== 'baru'])>{{ ucfirst($consultation->status) }}</span></td>
                            <td>{{ $consultation->created_at?->format('d M Y') ?? '—' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="table-footer"><span>Menampilkan {{ $consultations->firstItem() }}–{{ $consultations->lastItem() }} dari {{ $consultations->total() }} konsultasi</span>{{ $consultations->links() }}</div>
        @endif
    </section>
@endsection
