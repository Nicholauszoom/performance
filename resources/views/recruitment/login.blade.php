<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.shared.title-meta', ['title' => 'Log In'])

    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/phosphor/styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <script src="{{ asset('assets/js/app.js') }}"></script>
</head>

<body style="background:#3b465a;">

    <div class="page-content">
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content d-flex justify-content-center align-items-center">

                    {{-- Login card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0--}}
                    <form action="{{ route('jobseeker.login') }}" method="POST" class="login-form">
                        @csrf

                        <div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0mb-0">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                        <img src="{{ asset('login-assets/images/main-logo.png') }}"
                                            class="img-fluid rounded-circle" style="height: 10em" alt="logo">
                                    </div>
                                    <h6>Recruitment Portal</h6>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Username</label>

                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input class="form-control @if ($errors->has('username')) is-invalid @endif"
                                            name="username" type="text" id="emailaddress" required
                                            value="{{ old('username') }}" placeholder="JohnDoe">

                                        <div class="form-control-feedback-icon">
                                            <i class="ph-user-circle text-muted"></i>
                                        </div>
                                    </div>

                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>

                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="password" id="password"
                                            class="form-control @if ($errors->has('password')) is-invalid @endif"
                                            placeholder="password" name="password" required>

                                        <div class="form-control-feedback-icon">
                                            <i class="ph-lock text-muted"></i>
                                        </div>
                                    </div>

                                    @if ($errors->has('password'))
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
                                    <button type="submit" class="btn btn-main w-100 border-0"
                                        style="background: #012972">Log In</button>
                                </div>
                                <a href="{{ route('register.index') }}" title="Don't have an account? Register here"
                                    class="icon-2 info-tooltip"><button type="button"
                                        class="btn btn-main w-100 border-0">Register</button></a>


                            </div>
                        </div>
                    </form>
                    {{-- /login card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0--}}

                </div>
            </div>
        </div>
    </div>

</body>

</html>
