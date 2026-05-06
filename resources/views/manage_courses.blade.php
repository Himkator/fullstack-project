<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/app.css">
    <title>F1 Academy – {{ __('messages.manage_courses') }}</title>
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
                <li class="nav-item">
                    <a class="nav-link text-warning" href="/manage-courses">{{ __('messages.manage_courses') }}</a>
                </li>
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
    <h2 class="text-white fw-bold mb-4">{{ __('messages.manage_courses') }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ADD COURSE FORM --}}
    <div class="card bg-dark border-secondary p-4 mb-5">
        <h5 class="text-white mb-3">{{ __('messages.add_course') }}</h5>

        <form method="POST" action="/manage-courses/store" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label text-secondary">{{ __('messages.course_title') }}</label>
                <input type="text" name="title" class="form-control bg-black text-white border-secondary" placeholder="Course title" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary">{{ __('messages.level') }}</label>
                <select name="level" class="form-select bg-black text-white border-secondary">
                    <option>{{ __('messages.beginner') }}</option>
                    <option>{{ __('messages.intermediate') }}</option>
                    <option>{{ __('messages.advanced') }}</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary">{{ __('messages.description') }}</label>
                <textarea name="description" class="form-control bg-black text-white border-secondary" rows="3" placeholder="Course description"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary">{{ __('messages.price') }} ($)</label>
                <input type="number" name="price" step="0.01" class="form-control bg-black text-white border-secondary" placeholder="0.00">
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary">{{ __('messages.upload_hint') }}</label>
                <input type="file" name="course_file" class="form-control bg-black text-white border-secondary">
                <small class="text-secondary">Upload materials for this course.</small>
            </div>

            <button type="submit" class="btn btn-danger">{{ __('messages.add_course_btn') }}</button>
        </form>
    </div>

    {{-- COURSES TABLE --}}
    <h5 class="text-white mb-3">{{ __('messages.existing_courses') }}</h5>
    <div class="table-responsive">
        <table class="table table-dark table-bordered">
            <thead>
                <tr>
                    <th>{{ __('messages.course_title') }}</th>
                    <th>{{ __('messages.level') }}</th>
                    <th>{{ __('messages.price') }}</th>
                    <th>{{ __('messages.file') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>
                        <span class="badge
                            @if($course->level == 'Beginner') bg-success
                            @elseif($course->level == 'Advanced') bg-danger
                            @else bg-warning text-dark
                            @endif">
                            {{ $course->level }}
                        </span>
                    </td>
                    <td>${{ $course->price }}</td>
                    <td>
                        @if($course->file_path)
                            <a href="{{ asset('storage/' . $course->file_path) }}"
                            class="btn btn-outline-light btn-sm" target="_blank">
                                {{ __('messages.download') }}
                            </a>
                        @else
                            <span class="text-secondary small">No file</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="/manage-courses/delete">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this course?')">
                                {{ __('messages.delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-secondary">No courses yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<footer class="text-center py-3 border-top border-secondary mt-5">
    <small class="text-secondary">2026 F1 Academy</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>