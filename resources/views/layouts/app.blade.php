<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $appName ?? 'Work Plan' }}</title>
    @vite([
    'resources/sass/app.scss',
    'resources/css/app.css',
    ])
</head>
<body>
<div class="container-fluid m-0 p-0 d-flex container-body">
    @section('navAdmin')
        <div class="d-none d-md-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;min-height: 100vh">
            <a href="/" class="d-flex align-items-center me-md-auto text-white text-decoration-none">
               <picture>
                   <source srcset="/primary/logo_white.webp" type="image/webp">
                   <img src="/primary/logo_white.png">
               </picture>
            </a>
            <hr>

            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user.show') }}" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        @lang('global.settings_profil')
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user.index') }}" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        @lang('global.employees')
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user.create') }}" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        @lang('global.new_employee')
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('calendar.index') }}" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        @lang('global.calendar')
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('day.index') }}" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                            @lang('global.add_events')
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('logout') }}" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        @lang('global.log_out')
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
@yield('scriptJs')
</body>
</html>