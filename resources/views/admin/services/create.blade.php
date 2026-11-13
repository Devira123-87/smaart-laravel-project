{{-- Kegunaan file: Form admin untuk menambahkan pilar layanan. --}}
@extends('admin.layouts.app')

@section('title', 'Tambah Pilar Strategis')
@section('eyebrow', 'PILAR STRATEGIS')
@section('heading', 'Tambah pilar strategis')
@section('description', 'Isi judul, deskripsi, dan daftar layanan yang akan ditampilkan di website.')

@section('content')
    <form class="panel form-panel" method="POST" action="{{ route('admin.services.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-field">
                <label for="name">Nama pilar <span class="required">*</span></label>
                <input id="name" name="name" value="{{ old('name') }}" required maxlength="255">
                @error('name')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="slug">Slug</label>
                <input id="slug" name="slug" value="{{ old('slug') }}" maxlength="255" placeholder="Dibuat otomatis dari nama jika kosong">
                @error('slug')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="category">Label pilar (misalnya Pilar 1)</label>
                <input id="category" name="category" value="{{ old('category') }}" maxlength="255">
                @error('category')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
                <label for="icon">Ikon pilar</label>
                <input id="icon" name="icon" value="{{ old('icon') }}" maxlength="255" placeholder="Contoh: 💡">
                <small>Gunakan emoji atau teks singkat. Kosongkan jika tidak ingin memakai ikon.</small>
                @error('icon')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field form-span">
                <label for="description">Deskripsi <span class="required">*</span></label>
                <textarea id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
                @error('description')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-field form-span">
                <label for="features">Daftar layanan</label>
                <textarea id="features" name="features" rows="6" maxlength="4000" placeholder="Satu layanan per baris">{{ old('features') }}</textarea>
                <small>Masukkan satu layanan per baris. Baris kosong akan diabaikan.</small>
                @error('features')<span class="field-error">{{ $message }}</span>@enderror
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

        <section class="pillar-preview-wrap" aria-labelledby="pillar-preview-heading">
            <h2 id="pillar-preview-heading">Pratinjau pilar</h2>
            <article class="pillar-preview-card">
                <span class="pillar-preview-icon" data-preview="icon" @if (! old('icon')) hidden @endif>{{ old('icon') }}</span>
                <span class="pillar-preview-category" data-preview="category">{{ old('category') ?: 'Pilar 1' }}</span>
                <h3 data-preview="name">{{ old('name') ?: 'Nama pilar' }}</h3>
                <p data-preview="description">{{ old('description') ?: 'Deskripsi pilar akan tampil di sini.' }}</p>
                <ul data-preview="features">
                    @foreach (preg_split('/\r\n|\r|\n/', old('features', '')) as $feature)
                        @if (trim($feature) !== '')<li>{{ trim($feature) }}</li>@endif
                    @endforeach
                </ul>
            </article>
        </section>

        <div class="form-actions">
            <a class="button button-secondary" href="{{ route('admin.services.index') }}">Batal</a>
            <button class="button button-primary" type="submit">Simpan pilar</button>
        </div>
    </form>

    <script>
        const previewFields = {
            name: { input: document.querySelector('#name'), output: document.querySelector('[data-preview="name"]'), fallback: 'Nama pilar' },
            category: { input: document.querySelector('#category'), output: document.querySelector('[data-preview="category"]'), fallback: 'Pilar 1' },
            description: { input: document.querySelector('#description'), output: document.querySelector('[data-preview="description"]'), fallback: 'Deskripsi pilar akan tampil di sini.' },
        };

        Object.values(previewFields).forEach(({ input, output, fallback }) => {
            input.addEventListener('input', () => {
                output.textContent = input.value.trim() || fallback;
            });
        });

        const iconInput = document.querySelector('#icon');
        const iconPreview = document.querySelector('[data-preview="icon"]');
        iconInput.addEventListener('input', () => {
            iconPreview.textContent = iconInput.value;
            iconPreview.hidden = !iconInput.value.trim();
        });

        const featuresInput = document.querySelector('#features');
        const featuresPreview = document.querySelector('[data-preview="features"]');
        featuresInput.addEventListener('input', () => {
            featuresPreview.replaceChildren(...featuresInput.value
                .split(/\r\n|\r|\n/)
                .map((feature) => feature.trim())
                .filter(Boolean)
                .map((feature) => {
                    const item = document.createElement('li');
                    item.textContent = feature;
                    return item;
                }));
        });
    </script>
@endsection