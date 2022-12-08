<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.shared.title-meta', ['title' => "Log In"])

        <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/icons/phosphor/styles.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}">

        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

        <script src="{{ asset('assets/js/app.js') }}"></script>
    </head>

    <body style="background: #001949;">

        <div class="page-content">
            <div class="content-wrapper">
                <div class="content-inner">
                    <div class="content d-flex justify-content-center align-items-center">

                        {{-- Login card --}}
                        <form
                            action="{{ route('login') }}"
                            method="POST"
                            class="login-form"
                        >
                        @csrf

                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                            <img src="{{ asset('login-assets/images/main-logo.png') }}" class="img-fluid rounded-circle" style="height: 10em" alt="logo">
                                        </div>

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Username</label>

                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input
                                                class="form-control @if($errors->has('email')) is-invalid @endif"
                                                name="email"
                                                type="email"
                                                id="emailaddress"
                                                required
                                                value="{{ old('email')}}"
                                                placeholder="admin@gmail.com"
                                            >

                                            <div class="form-control-feedback-icon">
                                                <i class="ph-user-circle text-muted"></i>
                                            </div>
                                        </div>

                                        @if($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>

                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input
                                                type="password"
                                                id="password"
                                                class="form-control @if($errors->has('password')) is-invalid @endif"
                                                placeholder="password"
                                                name="password"
                                                required
                                            >

                                            <div class="form-control-feedback-icon">
                                                <i class="ph-lock text-muted"></i>
                                            </div>
                                        </div>

                                        @if($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <label class="form-check">
                                            <input type="checkbox" name="remember" class="form-check-input" checked>
                                            <span class="form-check-label">Remember</span>
                                        </label>

                                        <a href="/forgot-password" class="ms-auto">Forgot password?</a>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100 border-0" style="background: #012972">Log In</button>
                                    </div>

                                  </div>
                            </div>
                        </form>
                        {{-- /login card --}}

                    </div>
                </div>
            </div>
        </div>

    </body>

</html>
