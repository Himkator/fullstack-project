<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/app.css">
    <title>F1 Academy – {{ $course->title }}</title>
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
                    <a class="nav-link text-warning" href="/manage-courses">{{ __('messages.manage_courses') }}</a>
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
                                @elseif(session('user_role') == 'manager') bg-info text-dark
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

<div class="container mt-5">

    {{-- back button --}}
    <a href="/courses" class="btn btn-outline-secondary btn-sm mb-4">← {{ __('messages.back') }}</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4">

        {{-- LEFT: course info --}}
        <div class="col-md-8">
            <div class="card bg-dark border-secondary p-4">

                <div class="d-flex align-items-center gap-3 mb-3">
                    <h2 class="text-white fw-bold mb-0">{{ $course->title }}</h2>
                    <span class="badge
                        @if($course->level == 'Beginner') bg-success
                        @elseif($course->level == 'Advanced') bg-danger
                        @else bg-warning text-dark
                        @endif">
                        {{ $course->level }}
                    </span>
                </div>

                <p class="text-secondary mb-4" style="line-height:1.8;">
                    {{ $course->description ?? 'No description available.' }}
                </p>

                <hr class="border-secondary">

                <div class="row g-3 mt-1">
                    <div class="col-sm-4">
                        <p class="text-secondary small mb-1">{{ __('messages.price') }}</p>
                        <p class="text-white fw-bold fs-5">${{ $course->price }}</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="text-secondary small mb-1">{{ __('messages.level') }}</p>
                        <p class="text-white fw-bold fs-5">{{ $course->level }}</p>
                    </div>
                    <div class="col-sm-4">
                        <p class="text-secondary small mb-1">{{ __('messages.added') }}</p>
                        <p class="text-white fw-bold fs-5">{{ $course->created_at->format('d M Y') }}</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT: actions --}}
        <div class="col-md-4">

            {{-- enroll card --}}
            @if(!session('user_login') || session('user_role') == 'student')
            <div class="card bg-dark border-danger p-4 mb-3">
                <h5 class="text-white mb-3">Ready to race?</h5>
                <p class="text-secondary small">Enroll now and get a confirmation email instantly.</p>
                <form method="POST" action="/courses/enroll">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <button type="submit" class="btn btn-danger w-100">{{ __('messages.enroll') }}</button>
                </form>
            </div>
            @endif

            {{-- file download card --}}
            <div class="card bg-dark border-secondary p-4">
                <h5 class="text-white mb-3">Course Materials</h5>
                @if($course->file_path)
                    <p class="text-secondary small mb-3">
                        Course materials are available for download.
                    </p>
                    <a href="{{ asset('storage/' . $course->file_path) }}"
                       class="btn btn-outline-light w-100"
                       target="_blank"
                       download>
                        {{ __('messages.download') }}
                    </a>
                @else
                    <p class="text-secondary small mb-0">
                        {{ __('messages.no_materials') }}
                    </p>
                @endif
            </div>

        </div>

    </div>
</div>

<footer class="text-center py-3 border-top border-secondary mt-5">
    <small class="text-secondary">2026 F1 Academy</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>