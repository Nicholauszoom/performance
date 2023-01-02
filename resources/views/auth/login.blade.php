<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.shared.title-meta', ['title' => "Log In"])

        <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/icons/phosphor/styles.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}">

        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

        <script src="{{ asset('assets/js/configurator.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

        <script src="{{ asset('assets/js/app.js') }}"></script>
    </head>

    <body style="background: #00204e;">

        <div class="page-content">
            <div class="content-wrapper">
                <div class="content-inner">
                    <div class="content d-flex justify-content-center align-items-center">

                        <form action="{{ route('login') }}" method="POST" class="login-form" autocomplete="off">
                            @csrf

                            <div class="card mb-0">

                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                            <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" style="height: 10em" alt="logo">
                                        </div>

                                    </div>

                                    @if (session()->has('status'))
                                        <div class="alert alert-danger border-0 alert-dismissible fade show mb-3">
                                            <span class="fw-semibold">Oh snap!</span> {{ session('status') }}.

                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @else
                                        @if ($errors->any())
                                        <div class="alert alert-danger border-0 alert-dismissible fade show mb-3">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li> {{ $error }}</li>
                                                @endforeach
                                            </ul>

                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                        @endif
                                    @endif

                                    <div class="mb-3">
                                        <label class="form-label text-main">Username</label>

                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input
                                                class="form-control @if($errors->has('emp_id')) is-invalid @endif"
                                                name="emp_id"
                                                type="text"
                                                id="emp-id"
                                                required
                                                placeholder="username"
                                                autocomplete="off"
                                            >

                                            <div class="form-control-feedback-icon">
                                                <i class="ph-user-circle text-muted"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-main">Password</label>

                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input
                                                type="password"
                                                id="password"
                                                class="form-control @if($errors->has('password')) is-invalid @endif"
                                                placeholder="password"
                                                name="password"
                                                required
                                                autocomplete="off"
                                            >

                                            <div class="form-control-feedback-icon">
                                                <i class="ph-lock text-muted"></i>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="d-flex align-items-center mb-3">
                                        <a href="/forgot-password" class="ms-auto text-main">Forgot password?</a>
                                    </div> --}}

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-main w-100 border-0" style="background: #00204e">Log In</button>
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
