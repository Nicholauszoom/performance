<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.shared.title-meta', ['title' => 'Reset Password'])

    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/phosphor/styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <script src="{{ asset('assets/js/app.js') }}"></script>
</head>
<style>
    body {
 background-image: url('{{ asset('img/bg.png') }}');
 background-color: #cccccc;
 
}
 </style>

    <body class="bg-white" >
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Registration form -->
                    <form action="{{ route('password.new') }}" method="POST" class="login-form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0mb-0">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                        <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" style="height: 10em" alt="logo">
                                    </div>

                                </div>

                                <div class="text-center text-muted content-divider mb-3">
                                    <span class="px-2">Enter Your Credentials to Reset</span>
                                </div>

                                {{-- @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif --}}
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="form-control-feedback form-control-start">
                                        <input type="email" name="email" class="form-control"
                                            placeholder="">
                                    </div>
                                </div>
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror


                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="•••••••••••">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-lock text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control"
                                            placeholder="•••••••••••" autocomplete="current-password">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-lock text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if (Session::has('notMatch'))
                                    <p class="text-danger">{{ Session::get('notMatch') }}</p>
                                @endif
                                <button type="submit" class="btn btn-perfrom w-100">Reset Password</button>
                            </div>
                        </div>
                    </form>
                    <!-- /registration form -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->
    </div>
    {{-- @if (Session::has('success'))
        <p class="text-danger">{{ Session::get('success') }}</p>
    @endif --}}
</body>



</html>
