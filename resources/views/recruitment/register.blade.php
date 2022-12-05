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

<body style="background: #3b465a;">
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Registration form -->
                    <form class="login-form" action="index.html">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                        <img src="../../../assets/images/logo_icon.svg" class="h-48px" alt="">
                                    </div>
                                    <h5 class="mb-0">Create an Account</h5>
                                    <span class="d-block text-muted">All fields are required</span>
                                </div>

                                <div class="text-center text-muted content-divider mb-3">
                                    <span class="px-2">Your credentials</span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="text" class="form-control" placeholder="JohnDoe">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-user-circle text-muted"></i>
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="text" class="form-control" placeholder="john@doe.com">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-at text-muted"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="password" class="form-control" placeholder="•••••••••••">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-lock text-muted"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="password" class="form-control" placeholder="•••••••••••">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-lock text-muted"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    {{-- <label class="form-check mb-2">
                                        <input type="checkbox" name="remember" class="form-check-input" checked>
                                        <span class="form-check-label">Send me <a href="#">&nbsp;test account
                                                settings</a></span>
                                    </label>

                                    <label class="form-check mb-2">
                                        <input type="checkbox" name="remember" class="form-check-input" checked>
                                        <span class="form-check-label">Subscribe to monthly newsletter</span>
                                    </label> --}}

                                    <label class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input">
                                        <span class="form-check-label">Accept <a href="#">&nbsp;Terms and
                                                service</a></span>
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-teal w-100">Register</button>
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
</body>

</html>
