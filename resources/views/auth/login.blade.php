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

    <body style="background: #00204e;">

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
                                            <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid rounded-circle" style="height: 10em" alt="logo">
                                            <!-- <br>
                                            <br>
                                            <h style="color:#001949" >Performance<h/> -->
                                        </div>

                                    </div>

                                    <div class="mb-3">
                                        <ul>
                                            <li class="text-danger">Wrong Username</li>
                                            <li class="text-danger">Wrong Password</li>
                                        </ul>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-main">Username</label>

                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input
                                                class="form-control @if($errors->has('emp_id')) is-invalid @endif"
                                                name="emp_id"
                                                type="text"
                                                id="emp-id"
                                                required
                                                {{-- value="{{ old('emp_id')}}" --}}
                                                value="255001"
                                                placeholder="username"
                                            >

                                            <div class="form-control-feedback-icon">
                                                <i class="ph-user-circle text-muted"></i>
                                            </div>
                                        </div>

                                        @if($errors->has('emp_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('emp_id') }}</strong>
                                        </span>
                                        @endif
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
                                                value="CallC1034"
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
                                        <a href="/forgot-password" class="ms-auto text-main">Forgot password?</a>
                                    </div>

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
