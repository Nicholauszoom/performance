<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.shared.title-meta', ['title' => 'Log In'])

    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/phosphor/styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <script src="{{ asset('assets/js/configurator.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <style>
    .login-cover {
        background-image: url('{{ asset('img/s-1.jpg') }}');
        min-height: 500px;
        /* background-color: #cccccc; */
        /* background-position:center; */
        background-repeat: no-repeat;
        background-size: cover;
        /* background-attachment: fixed; */
    }
    </style>
</head>

<body>




    <div class="page-content login-cover">
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content d-flex align-items-center walpic">

                    <div class="col-md-7 col-12 offset-2">
                        <div class="rounded-0 mb-0">
                            <div class="row">

                                <div  class="col-md-5 offset-8  border-top  border-top-width-3 border-bottom border-bottom-main  border-bottom-width-3 border-top-main rounded-0" style="background: #ffffff8e">
                                    <form action="{{ url('login') }}" method="POST" class="" autocomplete="off">
                                        @csrf

                                        <div class=" border-bottom-main mb-0 pt-4">
                                            <div class="">
                                                {{-- <div class="text-center  mb-2 mt-1"> --}}
                                                    {{-- <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                                        <img src="{{ asset('img/performance.png') }}" class="img-fluid" style="height: 13.2em" alt="logo">
                                                    </div> --}}
                                                {{-- </div> --}}

                                                {{-- @if (Session::has('password_set'))
                                                    <div class="alert alert-success" role="alert">
                                                        <p>{{ Session::get('password_set') }}</p>
                                                    </div>
                                                    @endif --}}
                                                @if (session()->has('password_set'))
                                                <div
                                                    class="alert alert-success border-0 alert-dismissible fade show mb-3">
                                                    <span class="fw-semibold">Success!!!</span>
                                                    {{ session('password_set') }}.

                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                </div>
                                                @endif

                                                @if (session()->has('status'))
                                                <div
                                                    class="alert alert-danger border-0 alert-dismissible fade show mb-3">
                                                    <span class="fw-semibold">Oh snap!</span>
                                                    {{ session('status') }}.

                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                </div>
                                                @else

                                                @if ($errors->any())
                                                <div
                                                    class="alert alert-danger border-0 alert-dismissible fade show mb-3">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                        <li> {{ $error }}</li>
                                                        @endforeach
                                                    </ul>

                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                </div>
                                                @endif
                                                @endif
                                                @if ($next)
                                                    <input name="next" type="hidden" value="{{ $next }}">
                                                @endif
                                                <div class="mb-3">
                                                    <label class="form-label text-main font-weight-bold">Payroll Number</label>

                                                    <div class="form-control-feedback form-control-feedback-start">
                                                        <input
                                                            class="form-control @if ($errors->has('emp_id')) is-invalid @endif"
                                                            name="emp_id" type="text" id="emp-id" required
                                                            placeholder="username" autocomplete="off">

                                                        <div class="form-control-feedback-icon">
                                                            <i class="ph-user-circle text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-main">Password</label>

                                                    <div class="form-control-feedback form-control-feedback-start">
                                                        <input type="password" id="password"
                                                            class="form-control @if ($errors->has('password')) is-invalid @endif"
                                                            placeholder="password" name="password" required
                                                            autocomplete="off">

                                                        <div class="form-control-feedback-icon">
                                                            <i class="ph-lock text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-1 mt-3">
                                                    <button type="submit" class="btn btn-main  w-100 border-0" style="background: #00204e">Log In</button>
                                                </div>

                                                <div class="text-center mt-2">
                                                    <a href="{{ url('forgot-password') }}" class="ms-auto text-main">Forgot password?</a>
                                                </div>

                                                <div class="">
                                                    <div class="d-flex justify-content-end"><img src="{{ asset('assets/images/hc-hub-logo3.png') }}" alt="HC-HUB logo" height="100px" width="100px" class="img-fluid"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- <div class="mb-2">
        <img src="{{ asset('img/logo.png') }}" class=" float-end"
            style="height:2.4em;width:16%;float-left;opacity:100%" alt="logo">

    </div>
    <div class="">
        <img src="{{ asset('img/top.png') }}" class=" float-end"
            style="height:3.5em;width:100%;float-left;opacity:100%" alt="logo">

    </div> -->

</body>

</html>
