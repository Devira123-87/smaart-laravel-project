{{-- Kegunaan file: Tampilan daftar katalog produk yang dapat dikelola admin. --}}
@extends('admin.layouts.app')

@section('title', 'Produk')
@section('eyebrow', 'KONTEN WEBSITE')
@section('heading', 'Produk')
@section('description', 'Kelola produk yang ditampilkan pada website SMAART.')
@section('heading-action')
    <a class="button button-primary" href="{{ route('admin.products.create') }}"><span aria-hidden="true">+</span> Tambah produk</a>
@endsection

@section('content')
    <section class="panel">
        <form class="table-toolbar" method="GET" action="{{ route('admin.products.index') }}">
            <label class="search-field">
                <span class="sr-only">Cari produk</span>
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.3"></circle><path d="m15.5 15.5 4.2 4.2"></path></svg>
                <input type="search" name="search" value="{{ $search }}" placeholder="Cari nama atau slug">
            </label>
            <button class="button button-secondary" type="submit">Cari</button>
            @if ($search !== '')<a class="clear-search" href="{{ route('admin.products.index') }}">Hapus pencarian</a>@endif
        </form>
        @if ($products->isEmpty())
            <div class="empty-state">{{ $search !== '' ? 'Tidak ada produk yang cocok dengan pencarian.' : 'Belum ada produk. Tambahkan produk pertama untuk mulai mengelola konten.' }}</div>
        @else
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Nama produk</th><th>Slug</th><th>Gambar</th><th>Status</th><th class="actions-heading">Aksi</th></tr></thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td><strong>{{ $product->name }}</strong>@if ($product->tagline)<small class="cell-subtext">{{ $product->tagline }}</small>@endif</td>
                            <td><code>{{ $product->slug }}</code></td>
                            <td>@if ($product->image_url)<img class="product-table-image" src="{{ $product->image_url }}" alt="" loading="lazy">@else<span class="cell-subtext">Belum ada</span>@endif</td>
                            <td><span @class(['status-badge', 'status-active' => $product->is_active, 'status-inactive' => ! $product->is_active])>{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td class="row-actions">
                                <a class="action-link" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" data-confirm="Hapus produk {{ $product->name }}? Tindakan ini tidak dapat dibatalkan.">
                                    @csrf @method('DELETE')
                                    <button class="action-link action-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="table-footer"><span>Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }} produk</span>{{ $products->links() }}</div>
        @endif
    </section>
@endsection