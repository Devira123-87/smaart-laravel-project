<!DOCTYPE html>
<html lang="id">
    <head>
        {{-- Kegunaan file: Template halaman publik: beranda, pilar, produk, konsultasi, dan widget chat. --}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="PT Smaart Kreasi Digital adalah IT Solution &amp; Service Provider berbasis di Bogor, membangun ekosistem komprehensif yang menggabungkan efisiensi sistem dan keunggulan SDM.">
        <title>PT Smaart Kreasi Digital | Arsitek Masa Depan Digital</title>
        <script> 
            try {
                if (window.localStorage.getItem('smaart-theme') === 'dark') {
                    document.documentElement.classList.add('smaart-dark-mode');
                } 
            } catch (error) {
                console.warn('Unable to readn the saved SMAART theme preference.', error);
            }
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/global-search.css') }}">
        <link rel="stylesheet" href="{{ asset('css/global-theme.css') }}">
        <link rel="stylesheet" href="{{ asset('css/site-refinement.css') }}">
        <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
        <script src="{{ asset('js/global-search.js') }}" defer></script>
        <script src="{{ asset('js/global-theme.js') }}" defer></script>
    </head>
    <body>
        <header class="site-header" id="top">
            <div class="container nav-shell">
                <a href="#top" class="brand home-brand" aria-label="SMAART, beranda">
                    <img src="{{ asset('images/smaart-logo.png') }}" width="569" height="104" alt="SMAART Kreasi Digital — Limitless Creativity">
                </a>

                <button class="nav-toggle" aria-expanded="false" aria-controls="main-nav" aria-label="Buka menu navigasi">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <nav class="main-nav" id="main-nav" aria-label="Navigasi utama">
                    <a href="#hero">Home</a>
                    <a href="#pillars">Pilar Strategis</a>
                    <a href="#about">Visi</a>
                    <a href="#featured-products">Produk Unggulan</a>
                    <a href="#contact">Kontak</a>
                    <a class="button button-primary nav-cta" href="#contact">Hubungi Kami <span aria-hidden="true">↗</span></a>
                </nav>
                <div class="smaart-nav-tools">
                    <button class="smaart-theme-toggle" type="button" aria-label="Aktifkan mode gelap" aria-pressed="false" title="Aktifkan mode gelap">
                        <svg class="smaart-theme-icon smaart-theme-icon-sun" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="4"></circle>
                            <path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32 1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"></path>
                        </svg>
                        <svg class="smaart-theme-icon smaart-theme-icon-moon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20.2 15.4A8.5 8.5 0 0 1 8.6 3.8 8.5 8.5 0 1 0 20.2 15.4Z"></path>
                        </svg>
                    </button>
                    <button class="smaart-search-trigger" type="button" aria-label="Buka pencarian" aria-haspopup="dialog" aria-expanded="false" aria-controls="smaart-global-search-dialog">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.3"></circle><path d="m15.5 15.5 4.2 4.2"></path></svg>
                    </button>
                </div>
            </div>
        </header>

        <dialog class="smaart-search-dialog" id="smaart-global-search-dialog" aria-labelledby="smaart-search-title">
            <div class="smaart-search-panel">
                <div class="smaart-search-heading">
                    <h2 id="smaart-search-title">Cari di SMAART.ID</h2>
                    <button class="smaart-search-close" type="button" aria-label="Tutup pencarian">&times;</button>
                </div>
                <form class="smaart-search-form" role="search">
                    <label class="smaart-search-visually-hidden" for="smaart-search-input">Cari produk atau kontak</label>
                    <input id="smaart-search-input" type="search" placeholder="Cari produk atau kontak..." autocomplete="off" aria-describedby="smaart-search-status">
                </form>
                <p class="smaart-search-status" id="smaart-search-status" role="status" aria-live="polite">Ketik kata kunci untuk mulai mencari.</p>
                <ul class="smaart-search-results" id="smaart-search-results"></ul>
            </div>
        </dialog>

        <main>
            <section class="home-hero" id="hero">
                <div class="home-hero-photo" aria-hidden="true"></div>
                <div class="container home-hero-inner">
                    <div class="home-hero-copy reveal">
                        <span class="home-eyebrow">PT SMAART KREASI DIGITAL · BOGOR</span>
                        <h1>ARSITEK MASA DEPAN <span>DIGITAL</span></h1>
                        <p>Mensintesiskan infrastruktur teknologi cerdas dan kapasitas SDM tak terbatas.</p>
                        <div class="home-hero-actions">
                            <a class="home-button home-b 
                            utton-light" href="#contact">Hubungi Kami <span aria-hidden="true">↗</span></a>
                            <a class="home-button home-button-outline" href="#featured-products">Produk Unggulan</a>
                        </div>
                    </div>
                </div>
                <div class="home-quick-wrap container">
                    <nav class="home-quick-nav" aria-label="Jelajahi SMAART">
                        <a href="#pillars"><span class="home-quick-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 19V5m0 14h16M7 15l4-4 3 2 5-6"></path><path d="M16 7h3v3"></path></svg></span><span>Pilar Strategis</span><b aria-hidden="true">↗</b></a>
                        <a href="#featured-products"><span class="home-quick-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2"></rect><path d="M8 8h8M8 12h8M8 16h4"></path></svg></span><span>Produk Unggulan</span><b aria-hidden="true">↗</b></a>
                    </nav>
                </div>
            </section>

            <section class="home-pillars home-section" id="pillars">
                <div class="container">
                    <div class="home-section-heading reveal">
                        <div><span class="home-eyebrow-dark">ARAH PENGEMBANGAN SMAART</span><h2>Pilar Strategis</h2></div>
                        <p class="pillar-system-status"><span aria-hidden="true"></span>Status Sistem: Dual-Engine Terhubung</p>
                    </div>
                    @if ($pillars->isNotEmpty())
                        <div class="home-pillar-grid">
                            @foreach ($pillars as $pillar)
                                <article class="home-pillar-card reveal">
                                    @if ($pillar->icon)<span class="home-pillar-icon" aria-hidden="true">{{ $pillar->icon }}</span>@endif
                                    <span class="home-pillar-index">{{ $pillar->category ?: 'Pilar ' . $loop->iteration }}</span>
                                    <h3>{{ $pillar->name }}</h3>
                                    <p>{{ $pillar->description }}</p>
                                    @if ($pillar->features)
                                        <ul>
                                            @foreach ($pillar->features as $feature)
                                                <li>{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <a class="home-button home-button-light home-pillar-consultation" href="#contact" data-consultation-service="{{ $pillar->name }}">
                                        Konsultasi layanan ini <span aria-hidden="true">→</span>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <section class="home-about home-section" id="about">
                <div class="container home-about-grid">
                    <div class="home-about-copy reveal">
                        <span class="home-eyebrow-dark">VISI SMAART</span>
                        <h2>Limitless Creativity</h2>
                        <p>Kami adalah IT Solution &amp; Service Provider yang berbasis di Bogor. Fokus kami adalah membangun ekosistem komprehensif yang menggabungkan efisiensi sistem dan keunggulan SDM.</p>
                    </div>  

                    <div class="home-about-values reveal" aria-label="Nilai utama SMAART">
                        <article class="home-value-card">
                            <span class="home-value-kicker">01</span>
                            <h3>IT Solution &amp; Service Provider</h3>
                            <p>Menyediakan fondasi teknologi yang siap mendukung kebutuhan operasional dan layanan publik.</p>
                        </article>
                        <article class="home-value-card"
                        >
                            <span class="home-value-kicker">02</span>
                            <h3>Limitless Creativity</h3>
                            <p>Menjabarkan ide menjadi solusi digital yang bisa diimplementasikan secara nyata dan terukur.</p>
                        </article>
                        
                        <article class="home-value-card">
                            <span class="home-value-kicker">03</span>
                            <h3>Ekosistem Komprehensif</h3>
                            <p>Menggabungkan efisiensi sistem dengan keunggulan SDM untuk membangun masa depan yang lebih terarah.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section class="home-products home-section" id="featured-products">
                <div class="container">
                    <div class="home-section-heading reveal">
                        <div><span class="home-e
                        yebrow-dark">PRODUK UNGGULAN</span><h2>Produk Unggulan</h2></div>
                        <p>Solusi digital SMAART untuk mendukung kebijakan publik, komunikasi bisnis, ritel, dan pengelolaan SDM.</p>
                    </div>

                    <div class="home-product-grid">
                        @forelse ($products as $product)
                            <article class="home-product reveal">
                                <div class="home-product-preview{{ $product->image_2_url ? ' home-product-slideshow' : '' }}" @if ($product->image_2_url) role="group" aria-label="Galeri foto {{ $product->name }}" @endif>
                                    <img class="is-active" src="{{ $product->image_url ?: asset('images/products/product-preview.svg') }}" alt="{{ $product->name }}" loading="lazy">
                                    @if ($product->image_2_url)
                                        <img src="{{ $product->image_2_url }}" alt="{{ $product->name }} - foto 2" loading="lazy">
                                    @endif
                                </div>
                                <span class="home-product-type">{{ $product->tagline ?: 'PRODUK DIGITAL' }}</span>
                                <h3>{{ $product->name }}</h3>
                                <p>{{ $product->description }}</p>
                                <div class="home-product-actions">
                                    <button
                                        class="home-text-link home-product-details-trigger"
                                        type="button"
                                        data-product-details
                                        data-name="{{ $product->name }}"
                                        data-tagline="{{ $product->tagline ?: 'PRODUK DIGITAL' }}"
                                        data-description="{{ $product->description }}"
                                        data-image="{{ $product->image_url ?: asset('images/products/product-preview.svg') }}"
                                        aria-haspopup="dialog"
                                    >Lihat detail <span aria-hidden="true">→</span></button>
                                @if ($product->website_url)
                                    <a class="home-text-link" href="{{ $product->website_url }}" target="_blank" rel="noopener noreferrer">Kunjungi produk <span aria-hidden="true">↗</span></a>
                                @else
                                    <button class="home-text-link home-product-details-trigger" type="button" data-product="{{ $product->name }}">Tanyakan produk <span aria-hidden="true">→</span></button>
                                @endif
                                </div>
                            </article>
                        @empty
                            <p class="home-products-empty">Produk unggulan sedang disiapkan. Silakan hubungi tim kami untuk informasi lebih lanjut.</p>
                        @endforelse
                    </div>
                    @if ($products->contains(fn ($product) => $product->image))
                        <p class="home-product-note"></p>
                    @endif
                </div>
            </section>

            <dialog class="home-product-dialog" id="home-product-dialog" aria-labelledby="home-product-dialog-title">
                <article class="home-product-dialog-content">
                    <button class="home-product-dialog-close" type="button" aria-label="Tutup detail produk">&times;</button>
                    <img class="home-product-dialog-image" src="" alt="">
                    <div class="home-product-dialog-copy">
                        <span class="home-product-type" id="home-product-dialog-tagline"></span>
                        <h2 id="home-product-dialog-title"></h2>
                        <p id="home-product-dialog-description"></p>
                        <button class="home-button home-button-light" id="home-product-dialog-contact" type="button" data-product="">Tanya produk ini <span aria-hidden="true">→</span></button>
                    </div>
                </article>
            </dialog>

            <section class="home-contact home-section" id="contact">
                <div class="container home-contact-grid">
                    <div class="home-contact-copy reveal">
                        <span class="home-eyebrow">Mau ngobrol soal proyek?</span>
                        <h2>Ceritakan kebutuhan Anda, kami bantu carikan solusinya.</h2>
                        <p>Isi formulir di samping, atau hubungi langsung lewat email atau telepon. Tim kami yang akan membalas, bukan sistem otomatis.</p>
                        <div class="home-contact-details">
                            <div><span>ALAMAT</span><p>Jl. Farmasi II Blok BG No 4, Bogor 16111</p></div>
                            <div><span>EMAIL</span><a href="mailto:info@smaart.id">info@smaart.id</a></div>
                            <div><span>TELEPON</span><a href="tel:+622513102030">+62 251 3102030</a></div>
                        </div>
                    </div>
                    <div class="home-consultation">
                    <div class="home-consultation-header reveal">
                        <span class="home-eyebrow">KONSULTASI SMAART</span>
                        <h2 id="consultation-heading" aria-live="polite">Ada yang ingin ditanyakan?</h2>
                        <p id="consultation-intro">Ceritakan kebutuhan Anda melalui formulir ini. Tim SMAART akan membantu menindaklanjutinya.</p>
                    </div>
                    <form class="home-consultation-form reveal" method="POST" action="{{ route('consultations.store') }}" id="contact-form">
                        @csrf
                        @if (session('success'))
                            <p class="consultation-feedback is-success" role="status">{{ session('success') }}</p>
                        @endif
                        @if ($errors->any())
                            <div class="consultation-feedback is-error" role="alert">
                                <strong>Periksa kembali formulir:</strong>
                                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                            </div>
                        @endif
                        <div class="consultation-form-grid">
                            <label class="consultation-field" for="consultation-name">
                                <strong class="field-name">Nama <em>*</em></strong>
                                <input id="consultation-name" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="255" required>
                            </label>
                            <label class="consultation-field" for="consultation-email">
                                <strong class="field-name">Email <em>*</em></strong>
                                <input id="consultation-email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" required>
                            </label>
                            <label class="consultation-field" for="consultation-phone">
                                <strong class="field-name">Nomor telepon <small>(opsional)</small></strong>
                                <input id="consultation-phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" maxlength="30">
                            </label>
                            <label class="consultation-field" for="consultation-company">
                                <strong class="field-name">Perusahaan <small>(opsional)</small></strong>
                                <input id="consultation-company" name="company" value="{{ old('company') }}" autocomplete="organization" maxlength="255">
                            </label>
                            <label class="consultation-field consultation-field-full" for="inquiry-topic">
                                <strong class="field-name">Layanan yang diminati <em>*</em></strong>
                                <select id="inquiry-topic" name="service" required>
                                    <option value="">Pilih layanan atau topik</option>
                                    @foreach ($pillars as $pillar)
                                        <option value="{{ $pillar->name }}" @selected(old('service') === $pillar->name)>{{ $pillar->name }}</option>
                                    @endforeach
                                    <option value="Produk SMAART" @selected(old('service') === 'Produk SMAART')>Produk SMAART</option>
                                    <option value="Lainnya" @selected(old('service') === 'Lainnya')>Lainnya</option>
                                </select>
                            </label>
                            <label class="consultation-field consultation-field-full" for="message">
                                <strong class="field-name">Ceritakan kebutuhan Anda <em>*</em></strong>
                                <textarea id="message" name="message" rows="4" maxlength="5000" required>{{ old('message') }}</textarea>
                            </label>
                            <button class="home-button home-button-light consultation-submit" type="submit">Kirim permintaan konsultasi <span aria-hidden="true">→</span></button>
                            <p class="consultation-privacy">Data Anda digunakan untuk menindaklanjuti permintaan konsultasi ini.</p>
                        </div>
                    </form>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer home-footer">
            <div class="container home-footer-inner">
                <a href="#top" class="home-brand home-brand-footer" aria-label="SMAART, kembali ke beranda"><img src="{{ asset('images/smaart-logo.png') }}" width="569" height="104" alt="SMAART Kreasi Digital — Limitless Creativity"></a>
                <nav aria-label="Navigasi footer"><a href="#hero">Home</a><a href="#pillars">Pilar Strategis</a><a href="#about">Visi</a><a href="#featured-products">Produk Unggulan</a><a href="#contact">Kontak</a></nav>
                <p>© 2026 PT Smaart Kreasi Digital. Arsitek Masa Depan Digital.</p>
            </div>
        </footer>

        <button class="back-to-top" type="button" aria-label="Kembali ke atas">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5.5 5.5 12l1.4 1.4 4.1-4.1V19h2V9.3l4.1 4.1 1.4-1.4L12 5.5Z"/></svg>
        </button>

        <div class="chatbot" data-chat-endpoint="{{ url('/api/chat') }}" data-handoff-endpoint="{{ url('/api/chat/handoff') }}">
            <button class="chatbot-toggle" type="button" aria-label="Buka chat SMAART" aria-expanded="false" aria-controls="chatbot-panel">
                <span class="chatbot-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M5 5.75A2.75 2.75 0 0 1 7.75 3h8.5A2.75 2.75 0 0 1 19 5.75v6.5A2.75 2.75 0 0 1 16.25 15H11l-4.5 3v-3.2A2.75 2.75 0 0 1 5 12.25v-6.5Z"/><path d="M8 8h8M8 11h5"/></svg>
                </span>
                <span class="chatbot-toggle-label">Tanya SMAART</span>
                <span class="chatbot-status"><span class="chatbot-status-dot" aria-hidden="true"></span>Online</span>
            </button>

            <div class="chatbot-panel" id="chatbot-panel" hidden>
                <div class="chatbot-header">
                    <div class="chatbot-header-brand">
                        <span class="chatbot-avatar" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="m12 2 1.7 6.3L20 10l-6.3 1.7L12 18l-1.7-6.3L4 10l6.3-1.7L12 2Z"/><path d="m19 15 .9 2.1L22 18l-2.1.9L19 21l-.9-2.1L16 18l2.1-.9L19 15Z"/></svg>
                        </span>
                        <div class="chatbot-header-copy">
                            <strong>Asisten SMAART</strong>
                            <small><span class="chatbot-status-dot" aria-hidden="true"></span> Asisten virtual SMAART</small>
                        </div>
                    </div>
                    <div class="chatbot-header-actions">
                        <button class="chatbot-reset" type="button" aria-label="Mulai percakapan baru" title="Mulai percakapan baru">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                            <span>Baru</span>
                        </button>
                        <button class="chatbot-close" type="button" aria-label="Tutup chat">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg>
                        </button>
                    </div>
                </div>

                <div class="chatbot-body" id="chatbot-body" role="log" aria-live="polite" aria-relevant="additions">
                    <div class="chat-message bot">
                        <p>Halo! Saya Asisten SMAART. Saya bisa membantu Anda mengenal produk unggulan SMAART dan menghubungkan Anda dengan tim kami. Apa yang ingin Anda tanyakan?</p>
                    </div>
                </div>

                <div class="chatbot-quick-replies" aria-label="Pertanyaan cepat">
                    <span class="quick-replies-label">Mulai dengan topik</span>
                    <button type="button" class="quick-reply">Apa saja layanan SMAART?</button>
                    <button type="button" class="quick-reply">Apa saja produk SMAART?</button>
                    <button type="button" class="quick-reply">Bagaimana menghubungi SMAART?</button>
                </div>

                <div class="chatbot-handoff-wrap">
                    <button type="button" class="chatbot-handoff">Minta bantuan admin</button>
                    <span class="chatbot-conversation-status" role="status" aria-live="polite"></span>
                </div>
                <div class="chatbot-input-wrap">
                    <textarea id="chatbot-input" rows="1" placeholder="Tanyakan sesuatu..." aria-label="Tulis pesan"></textarea>
                    <button type="button" class="chatbot-send" aria-label="Kirim pesan" title="Kirim pesan">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 11.2 19.3 4.8l-4.1 14.7-3.1-6.2-3.1-6.2-7.6-2.1Z"/><path d="m12.1 13.3 4.2-4.2"/></svg>
                    </button>
                </div>
                <p class="chatbot-disclaimer">Jawaban otomatis · Admin dapat mengambil alih percakapan · Maksimal 20 pesan per hari.</p>
            </div>
        </div>
    </body>
</html>
