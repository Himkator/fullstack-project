<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/app.css">
    <title>F1 Academy – Admin Panel</title>
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
                    <a class="nav-link text-warning" href="/manage-courses">{{ __('messages.manage') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="/admin">{{ __('messages.admin') }}</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link text-light" href="/dashboard">
                        {{ session('user_login') }}
                        <span class="badge bg-danger ms-1">
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
    <h2 class="text-white fw-bold mb-4">Admin Panel</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class='table-responsive'>
        <table class="table table-dark table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Current Role</th>
                    <th>Change Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->login }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge
                            @if($user->getRoleNames()->first() == 'admin') bg-danger
                            @elseif($user->getRoleNames()->first() == 'instructor') bg-warning text-dark
                            @elseif($user->getRoleNames()->first() == 'student') bg-success
                            @else bg-secondary
                            @endif">
                            {{ strtoupper($user->getRoleNames()->first() ?? 'none') }}
                        </span>
                    </td>
                    <td>
                        <form method="POST" action="/admin/change-role" class="d-flex gap-2">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <select name="role_name" class="form-select form-select-sm bg-dark text-white border-secondary">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $user->getRoleNames()->first() == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-danger btn-sm">Save</button>
                        </form>
                    </td>
                </tr>
                @endforeach
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