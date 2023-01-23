<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $appName ?? 'Admin - Profil' }}</title>
    @vite([
    'resources/sass/app.scss',
    'resources/css/app.css',
    ])
</head>
<body>
<div class="container-fluid m-0 p-0 d-flex container-main-page">
    @section('navAdmin')
        <div class="d-none d-md-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;min-height: 100vh">
            <a href="/" class="d-flex align-items-center mb-4 mb-md-3 me-md-auto text-white text-decoration-none">
               <picture>
                   <source srcset="/primary/logo_white.webp" type="image/webp">
                   <img src="/primary/logo_white.png">
               </picture>
            </a>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>{{ $profil->first_name }} {{ $profil->last_name }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" style="">
                    <li><a class="dropdown-item" href="{{ route('user.index') }}">Użytkownicy</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.show') }}">Ustawienia</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
                </ul>
            </div>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('calendar.index') }}" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        Kalendarz
                    </a>
                </li>
                @if($superAdmin)
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('user.create') }}" aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                            Dodaj użytkownika
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('day.index') }}" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        Lista dni
                    </a>
                </li>
            </ul>
        </div>
        <nav class="navbar navbar-dark bg-dark d-md-none">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-dark p-4">
                <h5 class="text-white h4">Collapsed content</h5>
                <span class="text-muted">Toggleable via the navbar brand.</span>
            </div>
        </div>
    @show
    <div class="content-container">
        @yield('content')
    </div>
</div>

@vite(['resources/js/app.js'])
</body>
</html>