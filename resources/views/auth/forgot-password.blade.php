<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.shared.title-meta', ['title' => 'Password Recovery'])

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
{{-- <body style="background:#3b465a;"> --}}
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper ">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Password recovery form -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0mb-0">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <div
                                        class="d-inline-flex bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-3 mb-3 mt-1">
                                        <i class="ph-arrows-counter-clockwise ph-2x"></i>
                                    </div>
                                    <h5 class="mb-0">Password recovery</h5>
                                    <span class="d-block text-muted">We'll send you instructions in email</span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Your email</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Enter Your email">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-at text-muted"></i>
                                        </div>
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        @if (Session::has('message'))
                                                <p class="text-success">{{ Session::get('message') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-main w-100">
                                    <i class="ph-arrow-counter-clockwise me-2"></i>
                                    Reset password
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- /password recovery form -->

                </div>

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
</body>

</html>
