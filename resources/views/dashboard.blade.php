<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/app.css">
    <title>F1 Academy – Dashboard</title>
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
                @if(in_array(session('user_role'), ['instructor', 'manager', 'admin']))
                <li class="nav-item">
                    @if(session('user_role') == 'admin')
                        <a class="nav-link text-warning" href="/admin/manage-courses">{{ __('messages.manage') }}</a>
                    @else
                        <a class="nav-link text-warning" href="/manage-courses">{{ __('messages.manage') }}</a>
                    @endif
                </li>
                @endif
                @if(session('user_role') == 'admin')
                <li class="nav-item">
                    <a class="nav-link text-danger" href="/admin">{{ __('messages.admin') }}</a>
                </li>
                @endif
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">

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
    <h2 class="text-white fw-bold mb-1">{{ __('messages.welcome') }}, {{ session('user_login') }}!</h2>
    <p class="text-secondary mb-4">
        {{ __('messages.your_role') }}:
        <span class="badge
            @if(session('user_role') == 'admin') bg-danger
            @elseif(session('user_role') == 'instructor') bg-warning text-dark
            @elseif(session('user_role') == 'student') bg-success
            @else bg-secondary
            @endif">
            {{ strtoupper(session('user_role')) }}
        </span>
    </p>

    {{-- QUICK LINKS --}}
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3">
                <h5 class="text-white">Courses</h5>
                <p class="text-secondary small">Browse available F1 Academy courses.</p>
                <a href="/courses" class="btn btn-outline-danger btn-sm">View Courses</a>
            </div>
        </div>

        @if(in_array(session('user_role'), ['manager', 'instructor', 'admin']))
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3">
                <h5 class="text-white">Manage Courses</h5>
                <p class="text-secondary small">Create and edit courses.</p>
                @if(session('user_role') == 'admin')
                    <a href="/admin/manage-courses" class="btn btn-outline-warning btn-sm">Manage</a>
                @else
                    <a href="/manage-courses" class="btn btn-outline-warning btn-sm">Manage</a>
                @endif
            </div>
        </div>
        @endif

        @if(session('user_role') == 'admin')
        <div class="col-md-4">
            <div class="card bg-dark border-danger p-3">
                <h5 class="text-white">Admin Panel</h5>
                <p class="text-secondary small">Manage users and assign roles.</p>
                <a href="/admin" class="btn btn-danger btn-sm">Open Admin Panel</a>
            </div>
        </div>
        @endif
    </div>

    {{-- ENROLLED COURSES (student) --}}
    @if(session('user_role') == 'student')
    <h4 class="text-white fw-bold mb-3">{{ __('messages.enrolled') }}</h4>
    @if($enrolledCourses->isEmpty())
        <p class="text-secondary mb-5">{{ __('messages.no_enrolled') }}<a href="/courses" class="text-danger">{{ __('messages.browse') }} →</a></p>
    @else
    <div class="row g-3 mb-5">
        @foreach($enrolledCourses as $course)
        <div class="col-md-4">
            <div class="card bg-dark border-success p-3">
                <h6 class="text-white">{{ $course->title }}</h6>
                <span class="badge
                    @if($course->level == 'Beginner') bg-success
                    @elseif($course->level == 'Advanced') bg-danger
                    @else bg-warning text-dark
                    @endif mb-2">
                    {{ $course->level }}
                </span>
                <p class="text-secondary small">${{ $course->price }}</p>
                <a href="/courses/{{ $course->id }}" class="btn btn-outline-success btn-sm">View Course</a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    @endif

    @if(in_array(session('user_role'), ['instructor', 'admin']))
    <h4 class="text-white fw-bold mb-3">{{ __('messages.created') }}</h4>
    @if($createdCourses->isEmpty())
        <p class="text-secondary">You have not created any courses yet. <a href="/manage-courses" class="text-danger">Create one →</a></p>
    @else
    <div class="row g-3">
        @foreach($createdCourses as $course)
        <div class="col-md-4">
            <div class="card bg-dark border-warning p-3">
                <h6 class="text-white">{{ $course->title }}</h6>
                <span class="badge
                    @if($course->level == 'Beginner') bg-success
                    @elseif($course->level == 'Advanced') bg-danger
                    @else bg-warning text-dark
                    @endif mb-2">
                    {{ $course->level }}
                </span>
                <p class="text-secondary small">
                    {{ $course->enrollments->count() }} {{ __('messages.students') }}
                </p>
                <a href="/courses/{{ $course->id }}" class="btn btn-outline-warning btn-sm">View Course</a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    @endif

</div>

<footer class="text-center py-3 border-top border-secondary mt-5">
    <small class="text-secondary">2026 F1 Academy</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>