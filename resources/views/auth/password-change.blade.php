<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.shared.title-meta', ['title' => "Change Password"])

        <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/icons/phosphor/styles.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}">


        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

        <script src="{{ asset('assets/js/configurator.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

        <script src="{{ asset('assets/js/app.js') }}"></script>
    </head>
    <style>
        body {
     background-image: url('{{ asset('img/bg.png') }}');
     background-color: #cccccc;
     
    }
     </style>
    <body class="bg-white">

        <div class="page-content">
            <div class="content-wrapper">
                <div class="content-inner">
                    <div class="content d-flex justify-content-center align-items-center">

                        {{-- Login card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0--}}
                        <form action="{{ route('password.update') }}" method="POST" class="login-form" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0mb-0">

                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                            <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid rounded-circle" style="height: 10em" alt="logo">
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
                                        <label class="form-label text-main" for="current_password">Current Password</label>

                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input
                                                class="form-control @if($errors->has('current_password')) is-invalid @endif"
                                                name="current_password"
                                                type="password"
                                                id="current_password"
                                                required
                                                value="{{ old('current_password')}}"
                                                autocomplete="off"
                                            >

                                            <div class="form-control-feedback-icon">
                                                <i class="ph-lock text-muted"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-main" for="password">New Password</label>

                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input
                                                type="password"
                                                id="password"
                                                class="form-control @if($errors->has('password')) is-invalid @endif"
                                                name="password"
                                                value="{{ old('password') }}"
                                                required
                                                autocomplete="off"
                                            >

                                            <div class="form-control-feedback-icon">
                                                <i class="ph-lock text-muted"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-main" for="password_confirmation">Confirm Password</label>

                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input
                                                type="password"
                                                id="password_confirmation"
                                                class="form-control @if($errors->has('password_confirmation')) is-invalid @endif"
                                                name="password_confirmation"
                                                value="{{ old('password_confirmation') }}"
                                                required
                                                autocomplete="off"
                                            >

                                            <div class="form-control-feedback-icon">
                                                <i class="ph-lock text-muted"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-main w-100 border-0" style="background: #00204e">Log In</button>
                                    </div>

                                  </div>
                            </div>
                        </form>
                        {{-- /login card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0--}}

                    </div>
                </div>
            </div>
        </div>
        <div class="mb-2">
            <img src="{{ asset('img/logo.png') }}" class=" float-end"  style="height:2.4em;width:16%;float-left;opacity:100%" alt="logo">

          </div>
          <div class="">
            <img src="{{ asset('img/top.png') }}" class=" float-end"  style="height:3.5em;width:100%;float-left;opacity:100%" alt="logo">

         </div>
    </body>

</html>
