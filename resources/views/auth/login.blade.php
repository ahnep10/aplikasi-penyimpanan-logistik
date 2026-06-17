<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body class="bg-light">
        <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
            <div class="row justify-content-center w-100">
                <div class="col-sm-10 col-md-7 col-lg-5 col-xl-4">
                    <div class="text-center mb-4">
                        <a href="/" class="text-decoration-none">
                            <h1 class="h3 text-dark mb-1">Logistics MIS</h1>
                        </a>
                        <p class="text-muted mb-0">Sign in to manage logistics operations.</p>
                    </div>

                    <div class="card shadow">
                        <div class="card-header bg-white">
                            <h2 class="h5 mb-0">{{ __('Login') }}</h2>
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success mb-4" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        required
                                        autofocus
                                        autocomplete="username"
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        required
                                        autocomplete="current-password"
                                    >
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4 form-check">
                                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                    <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                                </div>

                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    @if (Route::has('password.request'))
                                        <a class="link-secondary" href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                    @endif

                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Log in') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
