{{-- Kegunaan file: Form admin untuk menambah produk baru. --}}
@extends('admin.layouts.app')

@section('title', 'Tambah Produk')
@section('eyebrow', 'PRODUK')
@section('heading', 'Tambah produk')
@section('description', 'Isi detail produk yang akan dikelola di website.')

@section('content')
    <form class="panel form-panel" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            <div class="form-field">   
                <label for="name">Nama produk <span class="required">*</span></label>
                <input id="name" name="name" value="{{ old('name') }}" required maxlength="255" 
                autocomplete="off">
                @error('name')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="slug">Slug</label>
                <input id="slug" name="slug" value="{{ old('slug') }}" maxlength="255" placeholder="Dibuat otomatis dari nama jika kosong">
                @error('slug')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field form-span">
                <label for="tagline">Tagline</label>
                <input id="tagline" name="tagline" value="{{ old('tagline') }}" maxlength="255">
               @error('tagline')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field form-span">
                <label for="description">Deskripsi <span class="required">*</span></label>
                <textarea id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
                @error('description')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="image_file">Pilih gambar produk</label>
                <input id="image_file" name="image_file" type="file" accept="image/jpeg,image/png,image/webp,image/gif">
                <small>Format JPG, PNG, WebP, atau GIF. Maksimal 5 MB.</small>
                @error('image_file')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="image">Atau URL/path gambar</label>
                <input id="image" name="image" value="{{ old('image') }}" maxlength="255" placeholder="Opsional; upload gambar akan diprioritaskan">
                @error('image')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="image_file_2">Foto kedua (opsional)</label>
                <input id="image_file_2" name="image_file_2" type="file" accept="image/jpeg,image/png,image/webp,image/gif">
                <small>Foto kedua akan menjadi slide tambahan. Format JPG, PNG, WebP, atau GIF; maksimal 5 MB.</small>
                @error('image_file_2')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="image_2">Atau URL/path foto kedua</label>
                <input id="image_2" name="image_2" value="{{ old('image_2') }}" maxlength="255" placeholder="Opsional; upload foto akan diprioritaskan">
                @error('image_2')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="website_url">URL website produk</label>
                <input id="website_url" name="website_url" type="url" value="{{ old('website_url') }}" maxlength="255" placeholder="https://">
                @error('website_url')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="is_active">Status <span class="required">*</span></label>
                <select id="is_active" name="is_active" required>
                    <option value="1" @selected(old('is_active', '1') === '1')>Aktif</option>
                    <option value="0" @selected(old('is_active') === '0')>Nonaktif</option>
                </select>
                @error('is_active')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-actions">
            <a class="button button-secondary" href="{{ route('admin.products.index') }}">Batal</a>
            <button class="button button-primary" type="submit">Simpan produk</button>
        </div>
    </form>
@endsection