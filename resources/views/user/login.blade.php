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
<div class="container d-flex align-items-center" style="min-height: 100vh">
    <div class="row justify-content-center" style="width: 100%">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <picture>
                            <source srcset="/primary/logo_black.webp" type="image/webp">
                            <img src="/primary/logo_black.png" class="mb-4">
                        </picture>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="email_company" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email_company" type="email" class="form-control @error('email_company') is-invalid @enderror" name="email_company" value="{{ old('email_company') }}" required autocomplete="email_company" autofocus>

                                @error('email_company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                <a class="btn btn-link" href="">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@vite(['resources/js/app.js'])
</body>
</html>