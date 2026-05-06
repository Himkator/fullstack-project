<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>F1 Academy - Main Page</title>
    <link rel="stylesheet" href="../css/app.css">
</head>
<body>

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
                    <a class="nav-link text-light" href="/courses">{{ __('messages.courses') }}</a>
                </li>
                @if(session('user_role') && in_array(session('user_role'), ['instructor', 'admin']))
                <li class="nav-item">
                    <a class="nav-link text-warning" href="/manage-courses">{{ __('messages.manage') }}</a>
                </li>
                @endif
                @if(session('user_role') == 'admin')
                <li class="nav-item">
                    <a class="nav-link text-danger" href="/admin">{{ __('messages.admin') }}</a>
                </li>
                @endif
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">

                @if(session('user_login'))
                    <li class="nav-item">
                        <a class="nav-link text-light" href="/dashboard">
                            {{ session('user_login') }}
                            <span class="badge ms-1
                                @if(session('user_role') == 'admin') bg-danger
                                @elseif(session('user_role') == 'instructor') bg-warning text-dark
                                @elseif(session('user_role') == 'student') bg-success
                                @else bg-secondary
                                @endif">
                                {{ strtoupper(session('user_role')) }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="/logout">{{ __('messages.logout') }}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-light" href="/login">{{ __('messages.login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fw-bold" href="/register">{{ __('messages.register') }}</a>
                    </li>
                @endif
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

<section class="hero d-flex justify-content-center align-items-center text-center">
    <div>
        <h1 class="display-3 fw-bold text-danger">{{ __('messages.hero_title') }}</h1>
        <p class="text-secondary mb-4">{{ __('messages.hero_sub') }}</p>

        <div id="adBox" class="ad-box d-inline-block px-5 py-4 mb-4">
            🏁 &nbsp;{{ __('messages.discount') }}
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2">
            <button class="btn btn-outline-danger btn-sm" id="hideBtn">{{ __('messages.hide') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="showBtn">{{ __('messages.show') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="fadeInBtn">{{ __('messages.fade_in') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="fadeOutBtn">{{ __('messages.fade_out') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="fadeToBtn">{{ __('messages.fade_50') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="slideUpBtn">{{ __('messages.slide_up') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="slideDownBtn">{{ __('messages.slide_down') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="animateBtn">{{ __('messages.animate') }}</button>
            <button class="btn btn-outline-light btn-sm" id="stopBtn">{{ __('messages.stop') }}</button>
        </div>
    </div>
</section>

<section class="bg-black py-5 border-top border-secondary">
    <div class="container">
        <h4 class="text-danger text-center mb-4 text-uppercase fw-bold">{{ __('messages.constructors_title') }}</h4>
        <canvas id="BarChart"></canvas>
    </div>
</section>

<section class="container py-5">
    <h4 class="text-danger text-center mb-4 text-uppercase fw-bold">{{ __('messages.academy_stats') }}</h4>
    <div class="row g-4">
        <div class="col-md-6"><canvas id="barChart"></canvas></div>
        <div class="col-md-6"><canvas id="pieChart"></canvas></div>
        <div class="col-md-6"><canvas id="polarChart"></canvas></div>
        <div class="col-md-6"><canvas id="lineChart"></canvas></div>
    </div>
</section>

<section class="bg-black border-top border-secondary text-center py-5">
    <div class="container">
        <h2 class="text-white fw-bold mb-2">{{ __('messages.academy_stats') }}</h2>
        <p class="text-secondary mb-4">{{ __('messages.cta_sub') }}</p>
        <a href="/register" class="btn btn-danger px-4 me-2">{{ __('messages.register_now') }}</a>
        <a href="/login" class="btn btn-outline-light px-4">{{ __('messages.sign_in') }}</a>
    </div>
</section>

<footer class="text-center py-3 border-top border-secondary">
    <small class="text-secondary">2026 F1 Academy</small>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/js/app.js"></script>
</body>
</html>