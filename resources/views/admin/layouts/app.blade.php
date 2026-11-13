{{-- Kegunaan file: Kerangka bersama untuk halaman dashboard admin. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#13263d">
    <title>@yield('title', 'Admin') | SMAART</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="admin-shell">
        <aside class="sidebar" id="admin-sidebar">
            <a class="brand" href="{{ route('admin.dashboard') }}" aria-label="SMAART Admin">
                <img class="admin-brand-logo" src="{{ asset('images/smaart-logo.png') }}" width="569" height="104" alt="SMAART Kreasi Digital — Limitless Creativity">
            </a>

            <div class="sidebar-label">WORKSPACE</div>
            <nav class="sidebar-nav" aria-label="Navigasi admin">
                <a href="{{ route('admin.dashboard') }}" @class(['nav-link', 'is-active' => request()->routeIs('admin.dashboard')])>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"></rect><rect x="14" y="3" width="7" height="7" rx="1"></rect><rect x="3" y="14" width="7" height="7" rx="1"></rect><rect x="14" y="14" width="7" height="7" rx="1"></rect></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.products.index') }}" @class(['nav-link', 'is-active' => request()->routeIs('admin.products.*')])>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4 7 8-4 8 4-8 4-8-4Z"></path><path d="m4 12 8 4 8-4M4 17l8 4 8-4"></path></svg>
                    <span>Produk</span>
                </a>
                <a href="{{ route('admin.services.index') }}" @class(['nav-link', 'is-active' => request()->routeIs('admin.services.*')])>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19.5V4.8A1.8 1.8 0 0 1 5.8 3H20v16H5.8A1.8 1.8 0 0 0 4 20.8"></path><path d="M8 7h8M8 11h8M8 15h5"></path></svg>
                    <span>Pilar Strategis</span>
                </a>
                <a href="{{ route('admin.consultations.index') }}" @class(['nav-link', 'is-active' => request()->routeIs('admin.consultations.*')])>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 11.5a7.5 7.5 0 0 1-7.5 7.5H5l-2 2v-6.5A7.5 7.5 0 1 1 20 11.5Z"></path><path d="M8 11h8M8 14h5"></path></svg>
                    <span>Konsultasi Proyek</span>
                </a>
                <a href="{{ route('admin.chats.index') }}" @class(['nav-link', 'is-active' => request()->routeIs('admin.chats.*')])>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 11.5a7.5 7.5 0 0 1-7.5 7.5H5l-2 2v-6.5A7.5 7.5 0 1 1 20 11.5Z"></path><path d="M8 9h8M8 13h6"></path></svg>
                    <span>Live Chat</span>
                </a>
                <a href="{{ route('admin.settings') }}" @class(['nav-link', 'is-active' => request()->routeIs('admin.settings')])>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3"></circle><path d="m19.4 15 .1.1 1.4 1.1-1.4 2.4-1.7-.6a8 8 0 0 1-1.5.9l-.3 1.8h-2.8l-.3-1.8a8 8 0 0 1-1.5-.9l-1.7.6-1.4-2.4 1.4-1.1a7 7 0 0 1 0-1.8l-1.4-1.1 1.4-2.4 1.7.6a8 8 0 0 1 1.5-.9l.3-1.8h2.8l.3 1.8a8 8 0 0 1 1.5.9l1.7-.6 1.4 2.4-1.4 1.1a7 7 0 0 1-.1 1.7Z"></path></svg>
                    <span>Pengaturan Website</span>
                </a>
            </nav>

            <div class="sidebar-bottom">
                <span class="sidebar-status"><i></i> Admin workspace</span>
                <a href="{{ route('home') }}" target="_blank" rel="noopener">Lihat website <span aria-hidden="true">↗</span></a>
            </div>
        </aside>

        <div class="admin-main">
            <header class="topbar">
                <button class="mobile-menu" type="button" aria-label="Buka navigasi" aria-controls="admin-sidebar" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
                <div class="topbar-context">
                    <span class="topbar-company">PT Smaart Kreasi Digital</span>
                    <span class="topbar-divider">/</span>
                    <span>Admin</span>
                </div>
                <div class="user-menu">
                    <span class="user-avatar" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="user-details"><strong>{{ auth()->user()->name }}</strong><small>Administrator</small></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="logout-button" type="submit">Keluar</button>
                    </form>
                </div>
            </header>

            <main class="page-content @yield('page-class')">
                <div class="page-heading">
                    <div>
                        @hasSection('eyebrow')<p class="eyebrow">@yield('eyebrow')</p>@endif
                        <h1>@yield('heading')</h1>
                        @hasSection('description')<p class="page-description">@yield('description')</p>@endif
                    </div>
                    @yield('heading-action')
                </div>

                @if (session('success'))
                    <div class="alert alert-success" role="status">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-error" role="alert">
                        <strong>Periksa kembali isian berikut.</strong>
                        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                @yield('content')
            </main>
            <footer class="admin-footer">SMAART Admin <span>·</span> PT Smaart Kreasi Digital</footer>
        </div>
    </div>
    <script>
        const menuButton = document.querySelector('.mobile-menu');
        const sidebar = document.querySelector('.sidebar');
        menuButton?.addEventListener('click', () => {
            const isOpen = sidebar.classList.toggle('is-open');
            menuButton.setAttribute('aria-expanded', String(isOpen));
        });
        document.querySelectorAll('[data-confirm]').forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (!window.confirm(form.dataset.confirm)) event.preventDefault();
            });
        });
    </script>
</body>
</html>
