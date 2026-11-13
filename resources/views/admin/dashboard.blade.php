{{-- Kegunaan file: Tampilan ringkasan konten dan aktivitas website untuk admin. --}}
@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-class', 'page-dashboard')
@section('eyebrow', 'RINGKASAN')
@section('heading', 'Dashboard')
@section('description', 'Ringkasan konten dan aktivitas yang tersimpan di website SMAART.')

@section('heading-action')
    <div class="dashboard-hero-actions">
        <a class="dashboard-hero-link" href="{{ route('home') }}" target="_blank" rel="noopener">Lihat website <span aria-hidden="true">↗</span></a>
        <a class="dashboard-hero-button" href="{{ route('admin.consultations.index') }}">Buka konsultasi <span aria-hidden="true">→</span></a>
    </div>
@endsection

@section('content')
    <div class="dashboard-shell">
    <section class="summary-grid" aria-label="Ringkasan data">
        <article class="summary-item">
            <div class="summary-topline">
                <span class="summary-label">Produk</span>
                <span class="summary-icon summary-icon-products" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="m3 7 9-4 9 4-9 4-9-4Z"></path><path d="m3 12 9 4 9-4M3 17l9 4 9-4"></path></svg>
                </span>
            </div>
            <strong class="summary-value">{{ number_format($productCount) }}</strong>
            <span class="summary-note"><i></i>{{ number_format($activeProductCount) }} aktif</span>
        </article>
        <article class="summary-item">
            <div class="summary-topline">
                <span class="summary-label">Pilar aktif</span>
                <span class="summary-icon summary-icon-services" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M4 19.5V4.8A1.8 1.8 0 0 1 5.8 3H20v16H5.8A1.8 1.8 0 0 0 4 20.8"></path><path d="M8 7h8M8 11h8M8 15h5"></path></svg>
                </span>
            </div>
            <strong class="summary-value">{{ number_format($serviceCount) }}</strong>
            <span class="summary-note">Tampil di website</span>
        </article>
        <article class="summary-item">
            <div class="summary-topline">
                <span class="summary-label">Konsultasi proyek</span>
                <span class="summary-icon summary-icon-consultations" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M20 11.5a7.5 7.5 0 0 1-7.5 7.5H5l-2 2v-6.5A7.5 7.5 0 1 1 20 11.5Z"></path><path d="M8 11h8M8 14h5"></path></svg>
                </span>
            </div>
            <strong class="summary-value">{{ number_format($consultationCount) }}</strong>
            <span class="summary-note">Total masuk</span>
        </article>
    </section>

    <section class="dashboard-actions" aria-labelledby="dashboard-actions-title">
        <div class="dashboard-section-heading">
            <div>
                <h2 id="dashboard-actions-title">Kelola website</h2>
                <p>Pilih bagian yang ingin Anda perbarui.</p>
            </div>
            <span class="dashboard-section-kicker">KONTEN WEBSITE</span>
        </div>
        <div class="dashboard-shortcuts">
            <a class="shortcut-card" href="{{ route('admin.products.index') }}">
                <span class="shortcut-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="m3 7 9-4 9 4-9 4-9-4Z"></path><path d="m3 12 9 4 9-4M3 17l9 4 9-4"></path></svg>
                </span>
                <span class="shortcut-copy"><strong>Kelola produk</strong><small>Atur katalog produk website</small></span>
                <span class="shortcut-arrow" aria-hidden="true">→</span>
            </a>
            <a class="shortcut-card" href="{{ route('admin.services.index') }}">
                <span class="shortcut-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M4 19.5V4.8A1.8 1.8 0 0 1 5.8 3H20v16H5.8A1.8 1.8 0 0 0 4 20.8"></path><path d="M8 7h8M8 11h8M8 15h5"></path></svg>
                </span>
                <span class="shortcut-copy"><strong>Kelola pilar strategis</strong><small>Atur deskripsi dan daftar layanan di website</small></span>
                <span class="shortcut-arrow" aria-hidden="true">→</span>
            </a>
            <a class="shortcut-card" href="{{ route('admin.consultations.index') }}">
                <span class="shortcut-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M20 11.5a7.5 7.5 0 0 1-7.5 7.5H5l-2 2v-6.5A7.5 7.5 0 1 1 20 11.5Z"></path><path d="M8 11h8M8 14h5"></path></svg>
                </span>
                <span class="shortcut-copy"><strong>Lihat konsultasi</strong><small>Buka semua permintaan masuk</small></span>
                <span class="shortcut-arrow" aria-hidden="true">→</span>
            </a>
        </div>
    </section>

    <section class="panel dashboard-consultations">
        <div class="panel-heading">
            <div>
                <h2>Konsultasi terbaru</h2>
                <p>Permintaan yang terakhir diterima melalui website.</p>
            </div>
            <a class="text-link" href="{{ route('admin.consultations.index') }}">Semua konsultasi <span aria-hidden="true">→</span></a>
        </div>
        @if ($recentConsultations->isEmpty())
            <div class="empty-state">Belum ada konsultasi yang tercatat.</div>
        @else
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Nama</th><th>Perusahaan</th><th>Layanan</th><th>Tanggal masuk</th></tr></thead>
                    <tbody>
                    @foreach ($recentConsultations as $consultation)
                        <tr>
                            <td><strong>{{ $consultation->name }}</strong><small class="cell-subtext">{{ $consultation->email }}</small></td>
                            <td>{{ $consultation->company ?: '—' }}</td>
                            <td>{{ $consultation->service }}</td>
                            <td>{{ $consultation->created_at?->format('d M Y') ?? '—' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
    </div>
@endsection
