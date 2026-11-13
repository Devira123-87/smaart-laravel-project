{{-- Kegunaan file: Form admin untuk mengubah data produk. --}}
@extends('admin.layouts.app')

@section('title', 'Edit Produk')
@section('eyebrow', 'PRODUK')
@section('heading', 'Edit produk')
@section('description', 'Perbarui informasi produk SMAART.')

@section('content')
    <form class="panel form-panel" method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf @method('PUT')    
        <div class="form-grid">
            <div class="form-field">
                <label for="name">Nama produk <span class="required">*</span></label>
                <input id="name" name="name" value="{{ old('name', $product->name) }}" required maxlength="255">
                @error('name')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="slug">Slug</label>
                <input id="slug" name="slug" value="{{ old('slug', $product->slug) }}" maxlength="255">
                @error('slug')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-field form-span">
                <label for="tagline">Tagline</label>
                <input id="tagline" name="tagline" value="{{ old('tagline', $product->tagline) }}" maxlength="255">
                @error('tagline')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field form-span">
                <label for="description">Deskripsi <span class="required">*</span></label>
                <textarea id="description" name="description" rows="6" required>{{ old('description', $product->description) }}</textarea>
                @error('description')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="image_file">Ganti gambar produk</label>
                <input id="image_file" name="image_file" type="file" accept="image/jpeg,image/png,image/webp,image/gif">
                <small>Format JPG, PNG, WebP, atau GIF. Maksimal 5 MB. Kosongkan jika tidak ingin mengganti gambar.</small>
                @error('image_file')<span class="field-error">{{ $message }}</span>@enderror
                @if ($product->image_url)
                    <img class="product-image-preview" src="{{ $product->image_url }}" alt="Gambar {{ $product->name }}">
                @endif
            </div>
            <div class="form-field">
                <label for="image">URL/path gambar (opsional)</label>
                <input id="image" name="image" value="{{ old('image', $product->image) }}" maxlength="255" placeholder="Diabaikan jika Anda mengunggah gambar">
                @error('image')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="image_file_2">Foto kedua (opsional)</label>
                <input id="image_file_2" name="image_file_2" type="file" accept="image/jpeg,image/png,image/webp,image/gif">
                <small>Unggah untuk mengganti foto kedua. Format JPG, PNG, WebP, atau GIF; maksimal 5 MB.</small>
                @error('image_file_2')<span class="field-error">{{ $message }}</span>@enderror
                @if ($product->image_2_url)
                    <img class="product-image-preview" src="{{ $product->image_2_url }}" alt="Foto kedua {{ $product->name }}">
                    <label class="checkbox-field">
                        <input type="checkbox" name="remove_image_2" value="1" @checked(old('remove_image_2'))>
                        Hapus foto kedua
                    </label>
                @endif
            </div>
            <div class="form-field">
                <label for="image_2">Atau URL/path foto kedua</label>
                <input id="image_2" name="image_2" value="{{ old('image_2', $product->image_2) }}" maxlength="255" placeholder="Opsional; upload foto akan diprioritaskan">
                @error('image_2')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">

                <label for="website_url">URL website produk</label>
                <input id="website_url" name="website_url" type="url" value="{{ old('website_url', $product->website_url) }}" maxlength="255">
                @error('website_url')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="is_active">Status <span classt="required">*</span></label>
                <select id="is_active" name="is_active" required>
                    <option value="1" @selected((string) old('is_active', (int) $product->is_active) === '1')>Aktif</option>
                    <option value="0" @selected((string) old('is_active', (int) $product->is_active) === '0')>Nonaktif</option>
                </select> 
                @error('is_active')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-actions">
            <a class="button button-secondary" href="{{ route('admin.products.index') }}">Batal</a>
            <button class="button button-primary" type="submit">Simpan perubahan</button>
        </div>
    </form>
@endsection