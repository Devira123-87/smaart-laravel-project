{{-- Kegunaan file: Tampilan informasi pengaturan dan akun admin. --}}
@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')
@section('eyebrow', 'KONFIGURASI')
@section('heading', 'Pengaturan website')
@section('description', 'Informasi konfigurasi dasar yang sedang digunakan aplikasi.')

@section('content')
    <section class="panel settings-panel">
        <div class="panel-heading">
            <div>
                <h2>Informasi aplikasi</h2>
                <p>Nilai ini berasal dari konfigurasi Laravel dan tidak dapat diubah dari halaman ini.</p>
            </div>
            <span class="status-badge status-neutral">Baca saja</span>
        </div>
        <dl class="settings-list">
            <div><dt>Nama aplikasi</dt><dd>{{ config('app.name') }}</dd></div>
            <div><dt>Alamat aplikasi</dt><dd>{{ config('app.url') }}</dd></div>
            <div><dt>Bahasa</dt><dd>{{ config('app.locale') }}</dd></div>
            <div><dt>Zona waktu</dt><dd>{{ config('app.timezone') }}</dd></div>
        </dl>
        <p class="settings-note">Pengaturan yang dapat diedit dan disimpan belum tersedia. Pengelolaan nilai konfigurasi tetap dilakukan melalui environment aplikasi, bukan dari dashboard.</p>
    </section>
@endsection
