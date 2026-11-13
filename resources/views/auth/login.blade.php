{{-- Kegunaan file: Template formulir login admin. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b1220">
    <title>Login Admin | SMAART.ID</title>
    <link rel="stylesheet" href="{{ asset('css/admin-auth.css') }}">
</head>
<body>
    <main class="auth-shell">
        <a class="auth-brand" href="{{ route('home') }}" aria-label="Kembali ke SMAART.ID">
            <img src="{{ asset('images/smaart-logo.png') }}" width="569" height="104" alt="SMAART Kreasi Digital — Limitless Creativity">
        </a>

        <section class="auth-panel" aria-labelledby="login-title">
            <p class="auth-kicker">Area administrator</p>
            <h1 id="login-title">Masuk ke dashboard</h1>
            <p class="auth-description">Gunakan akun yang telah terdaftar untuk mengelola produk dan layanan.</p>

            @if ($errors->any())
                <div class="auth-error" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div class="auth-field">
                    <label for="password">Kata sandi</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <label class="auth-remember">
                    <input type="checkbox" name="remember" value="1">
                    <span>Ingat saya</span>
                </label>

                <button type="submit" class="auth-submit">Masuk</button>
            </form>

            <a class="auth-back" href="{{ route('home') }}">Kembali ke situs SMAART.ID</a>
        </section>

        <p class="auth-footer">PT Smaart Kreasi Digital</p>
    </main>
</body>
</html>
