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
        body {
            background-image: url('{{ asset('img/bg.png') }}');
            background-color: #cccccc;

        }
    </style>

<body class="bg-white">

    {{-- style="background: #00204e;" --}}




    <div class="page-content">
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content d-flex justify-content-center align-items-center">

                    <div class="col-md-7 col-12">
                        <div class=" rounded-0 mb-0">
                            <div class="">
                                <div class="row " style="height:43.4em;">

                                    <div class="col-md-6  d-none d-md-block col-12 ">
                                        <div id="carouselExampleSlidesOnly" class="carousel slide"
                                            data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="{{ asset('img/slide1.png') }}"
                                                        class="img-fluid d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="{{ asset('img/slide2.png') }}"
                                                        class="img-fluid d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="{{ asset('img/slide5.png') }}"
                                                        class="img-fluid d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="{{ asset('img/slide3.png') }}"
                                                        class="img-fluid d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="{{ asset('img/slide4.png') }}"
                                                        class="img-fluid d-block w-100" alt="...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-5  col-sm-11 col-11 mx-auto bg-white border-top  border-top-width-3 border-bottom border-bottom-main  border-bottom-width-3 border-top-main rounded-0">

                                        <form action="{{ route('login') }}" method="POST" class="mb-4 py-4"
                                            autocomplete="off">
                                            @csrf

                                            <div class=" border-bottom-main mb-0">

                                                <div class="">
                                                    <div class="text-center mb-2 mt-5">
                                                        <div
                                                            class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                                            <img src="{{ asset('img/performance.png') }}"
                                                                class="img-fluid" style="height: 13.2em" alt="logo">
                                                        </div>


                                                    </div>
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

                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="alert"></button>
                                                            </div>
                                                        @endif

                                                    @if (session()->has('status'))
                                                        <div
                                                            class="alert alert-danger border-0 alert-dismissible fade show mb-3">
                                                            <span class="fw-semibold">Oh snap!</span>
                                                            {{ session('status') }}.

                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="alert"></button>
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

                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="alert"></button>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        <div class="mb-3">
                                                            <label class="form-label text-main">Username</label>

                                                            <div
                                                                class="form-control-feedback form-control-feedback-start">
                                                                <input
                                                                    class="form-control @if ($errors->has('emp_id')) is-invalid @endif"
                                                                    name="emp_id" type="text" id="emp-id"
                                                                    required placeholder="username" autocomplete="off">

                                                                <div class="form-control-feedback-icon">
                                                                    <i class="ph-user-circle text-muted"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label text-main">Password</label>

                                                            <div
                                                                class="form-control-feedback form-control-feedback-start">
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
                                                            <button type="submit" class="btn btn-main  w-100 border-0"
                                                                style="background: #00204e">Log In</button>
                                                        </div>

                                                        <div class="text-center mt-2">
                                                            <a href="{{ url('forgot-password') }}"
                                                                class="ms-auto text-main">Forgot password?</a>
                                                        </div>

                                                </div>
                                            </div>
                                        </form>
                                        {{-- /login card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0 --}}

                                    </div>
                                    <div class="col-md-1  d-none d-md-block col-12 ">
                                    <a href="{{ asset('img/slide2.png') }}" class="btn btn-main" download>App<i class="ph-download"></i></a>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <img src="{{ asset('img/logo.png') }}" class=" float-end"
            style="height:2.4em;width:16%;float-left;opacity:100%" alt="logo">

    </div>
    <div class="">
        <img src="{{ asset('img/top.png') }}" class=" float-end"
            style="height:3.5em;width:100%;float-left;opacity:100%" alt="logo">

    </div>

</body>

</html>
