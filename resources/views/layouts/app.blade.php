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
<div class="container-fluid m-0 p-0 d-flex flex-nowrap">
    @section('navAdmin')
        <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;min-height: 100vh">
            <a href="/" class="d-flex align-items-center mb-4 mb-md-3 me-md-auto text-white text-decoration-none">
                <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
                <span class="fs-4">Work Plan</span>
            </a>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>mdo</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" style="">
                    <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="" class="nav-link active" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        Kalendarz
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link text-white" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        Lista dni
                    </a>
                </li>
                <li>
                    <a href="" class="nav-link text-white">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        Dokumentacja Api
                    </a>
                </li>
            </ul>
        </div>
    @show
    <div class="content-container">
        @yield('content')
    </div>
</div>
<div class="holidays d-none">
    <div class="holidays-form shadow-sm">
        <div class="holidays-header fs-4 text-start">
            Add free day
        </div>
        <div class="holidays-body">
            <form>
                <label for="first">First day</label>
                <input>
                <label for="first">End day</label>
                <label for="first">Type of free day</label>
            </form>
        </div>
    </div>
</div>
@vite(['resources/js/app.js'])
</body>
</html>