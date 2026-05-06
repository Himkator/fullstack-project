<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/app.css">
    <title>F1 Academy – Courses</title>
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
    <h2 class="text-white fw-bold mb-4">{{ __('messages.courses') }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        @forelse($courses as $course)
        <div class="col-md-4">

            <div class="card bg-dark border-secondary p-3 h-100 d-flex flex-column">
                <h5 class="text-danger">{{ $course->title }}</h5>
                <span class="badge mb-2
                    @if($course->level == 'Beginner') bg-success
                    @elseif($course->level == 'Advanced') bg-danger
                    @else bg-warning text-dark
                    @endif">
                    {{ $course->level }}
                </span>
                <p class="text-secondary small flex-grow-1">{{ $course->description }}</p>
                <p class="text-white fw-bold">${{ $course->price }}</p>

                @if($course->file_path)
                    <a href="{{ asset('storage/' . $course->file_path) }}"
                       class="btn btn-outline-light btn-sm mb-2" target="_blank">
                        View Materials
                    </a>
                @endif

                <a href="/courses/{{ $course->id }}" class="btn btn-outline-danger btn-sm w-100 mb-2">
                    View Details
                </a>

                @if(!session('user_login') || session('user_role') == 'student')
                    <form method="POST" action="/courses/enroll">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                            Enroll
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @empty
            <p class="text-secondary">No courses available yet.</p>
        @endforelse
    </div>
</div>

<footer class="text-center py-3 border-top border-secondary mt-5">
    <small class="text-secondary">2026 F1 Academy</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>