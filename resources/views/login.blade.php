<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>F1 Academy – Login</title>
    <link rel="stylesheet" href="../css/app.css">
</head>
<body class="auth-wrapper">

<nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-danger">
    <div class="container">
        <a class="navbar-brand fw-bold text-danger" href="/">F1 Academy</a>
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu"
                aria-controls="navbarMenu"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-light" href="/">{{ __('messages.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light fw-bold" href="/register">{{ __('messages.register') }}</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item lang-switcher">
                    <div class="d-flex gap-1 mt-1 mt-lg-0 ms-lg-2">
                        <a href="/language/en"
                           class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-danger' : 'btn-outline-secondary' }}">
                            EN
                        </a>
                        <a href="/language/ru"
                           class="btn btn-sm {{ app()->getLocale() == 'ru' ? 'btn-danger' : 'btn-outline-secondary' }}">
                            RU
                        </a>
                        <a href="/language/kk"
                           class="btn btn-sm {{ app()->getLocale() == 'kk' ? 'btn-danger' : 'btn-outline-secondary' }}">
                            KK
                        </a>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</nav>

<div class="flex-grow-1 d-flex align-items-center justify-content-center py-5 px-3">
    <div class="auth-card">

        <h4 class="text-danger fw-bold mb-1">F1 Academy</h4>
        <h2 class="text-white fw-bold mb-1">{{ __('messages.sign_in') }}</h2>
        <p class="text-secondary small mb-4">Access your pit wall dashboard.</p>

        @if(session('success'))
            <div class="alert alert-success">
                <strong>Authorization Passed!</strong><br>
                {{ session('success') }}<br>
                <small>Redirecting to home…</small>
            </div>
            <script>setTimeout(() => { window.location.href = '/'; }, 2500);</script>
        @else
            @if(session('error'))
                <div class="alert alert-danger">
                    ⚠ {{ session('error') }}
                </div>
            @endif
            <form method="POST" action="/login">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-secondary small">{{ __('messages.username') }}</label>
                    <input type="text" name="login"
                           class="form-control bg-black text-white border-secondary"
                           placeholder="your_username" required
                           value="{{ old('username') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small">{{ __('messages.password') }}</label>
                    <input type="password" name="password"
                           class="form-control bg-black text-white border-secondary"
                           placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-danger w-100">Sign In</button>
            </form>
        @endif

        <p class="text-center text-secondary small mt-3 mb-0">
            {{ __('messages.no_account') }} <a href="/register" class="text-danger">{{ __('messages.register') }}</a>
        </p>
    </div>
</div>

<footer class="text-center py-3 border-top border-secondary">
    <small class="text-secondary">2026 F1 Academy</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>