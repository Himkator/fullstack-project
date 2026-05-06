<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>F1 Academy - {{ __('messages.register') }}</title>
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
                    <a class="nav-link text-light" href="/login">{{ __('messages.login') }}</a>
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
        <h2 class="text-white fw-bold mb-1">{{ __('messages.create_account') }}</h2>
        <p class="text-secondary small mb-4">{{ __('messages.register_sub') }}</p>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <p class="text-secondary small text-uppercase mb-2" style="letter-spacing:2px;">{{ __('messages.personal_info') }}</p>

            <div class="row g-3 mb-3">
                <div class="col">
                    <label class="form-label text-secondary small">{{ __('messages.first_name') }}</label>
                    <input type="text" name="firstName" class="form-control bg-black text-white border-secondary"
                           placeholder="Max" value="{{ old('firstName') }}">
                </div>
                <div class="col">
                    <label class="form-label text-secondary small">{{ __('messages.last_name') }}</label>
                    <input type="text" name="lastName" class="form-control bg-black text-white border-secondary"
                           placeholder="Verstappen" value="{{ old('lastName') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary small">{{ __('messages.email') }}</label>
                <input type="email" name="email" class="form-control bg-black text-white border-secondary"
                       placeholder="driver@f1academy.com" value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary small">{{ __('messages.dob') }}</label>
                <input type="date" name="dob" class="form-control bg-black text-white border-secondary"
                       value="{{ old('dob') }}">
            </div>

            <p class="text-secondary small text-uppercase mt-4 mb-2" style="letter-spacing:2px;">{{ __('messages.account_details') }}</p>

            <div class="mb-3">
                <label class="form-label text-secondary small">{{ __('messages.username') }}</label>
                <input type="text" name="login" class="form-control bg-black text-white border-secondary"
                       placeholder="speed_racer_99" value="{{ old('login') }}">
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary small">{{ __('messages.password') }}</label>
                <input type="password" name="password" id="password"
                       class="form-control bg-black text-white border-secondary"
                       oninput="checkStrength(this.value)">
                <div class="progress mt-2" style="height:4px;background:#1e1e1e;">
                    <div id="strengthBar" class="progress-bar" style="width:0%;transition:width 0.3s;"></div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary small">{{ __('messages.confirm_password') }}</label>
                <input type="password" id="confirmPassword"
                       class="form-control bg-black text-white border-secondary">
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary small">{{ __('messages.experience_level') }}</label>
                <select name="level" class="form-select bg-black text-white border-secondary">
                    <option value="" disabled selected>{{ __('messages.select_level') }}</option>
                    <option>Beginner</option>
                    <option>Intermediate</option>
                    <option>Advanced</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary small">{{ __('messages.role') }}</label>
                <select name="role" class="form-select bg-black text-white border-secondary">
                    <option value="" disabled selected>{{ __('messages.select_role') }}</option>
                    <option value="student">{{ __('messages.student') }}</option>
                    <option value="manager">{{ __('messages.manager') }}</option>
                    <option value="instructor">{{ __('messages.instructor') }}</option>
                </select>
            </div>

            <button type="submit" class="btn btn-danger w-100">{{ __('messages.create_account') }}</button>

        </form>

        <p class="text-center text-secondary small mt-3 mb-0">
            {{ __('messages.already') }} <a href="/login" class="text-danger">{{ __('messages.sign_in') }} →</a>
        </p>
    </div>
</div>

<footer class="text-center py-3 border-top border-secondary">
    <small class="text-secondary">2026 F1 Academy</small>
</footer>

<script src="../js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>