<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.shared.title-meta', ['title' => $title])
        @include('layouts.shared.head-css')

        <script src="{{ asset('assets/notification/js/bootstrap-growl.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('assets/notification/css/notification.min.css') }}">
        <script src="{{ asset('assets/loader.js') }}"></script>

        <style>
            .request__spinner {
                /* background: red; */
                /* position: absolute;
                z-index: 99999;
                left: 50%;
                top: 50%;
                display: none;
                width: 50px;
                height: 50px;
                margin: 20px auto;
                border: 5px solid rgba(0, 0, 0, 0.1);
                border-left: 5px solid #003366;
                border-right: 5px solid #003366;
                animation: request__spinner 1s linear infinite forwards;
                -webkit-border-radius: 50%;
                -moz-border-radius: 50%;
                -o-border-radius: 50%;
                -ms-border-radius: 50%;
                border-radius: 50%; */
            }

            @keyframes request__spinner {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            body {
                background-image: url('{{ asset('img/bg2.png') }}');
                /* background-color: #f1f1f1; */
                background-color: #ffff;
                /* background: cover; */
                background-position:center;
                background-repeat: no-repeat;
            }

            .card {
                background-color: transparent !important;
            }

            .jumping-dots-loader {
                width: 100px;
                height: 100px;
                border-radius: 100%;
                position: relative;
                margin: 0 auto;
            }

            .jumping-dots-loader span {
                display: inline-block;
                width: 20px;
                height: 20px;
                border-radius: 100%;
                margin: 35px 5px;
                border: 1px solid #fff;
                background-color: #a49324;
            }

            .jumping-dots-loader span:nth-child(1) {
                animation: bounce 1s ease-in-out infinite;
            }

            .jumping-dots-loader span:nth-child(2) {
                animation: bounce 1s ease-in-out 0.33s infinite;
            }

            .jumping-dots-loader span:nth-child(3) {
                animation: bounce 1s ease-in-out 0.66s infinite;
            }

            @keyframes bounce {
                0%,
                75%,
                100% {
                    -webkit-transform: translateY(0);
                    -ms-transform: translateY(0);
                    -o-transform: translateY(0);
                    transform: translateY(0);
                }

                25% {
                    -webkit-transform: translateY(-20px);
                    -ms-transform: translateY(-20px);
                    -o-transform: translateY(-20px);
                    transform: translateY(-20px);
                }
            }

            .modal-backdrop {
                background-color: rgba(0, 16, 38, 0.983); /* Adjust the alpha (0.5) to change opacity */
                /* You can also use rgba to set both background color and opacity */
            }




        </style>
    </head>

    <body>
        <div class="request__spinner"></div>

        @include('layouts.shared.topbar')

       {{-- Page content --}}
        <div class="page-content">

            <div id="loadingOverlay" class="loading-overlay">
                <div class="modal-backdrop fade show d-flex align-items-center justify-content-center">
                    <div class="jumping-dots-loader">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="moving-gradient"></div>
                </div>
            </div>

            @include('layouts.shared.left-sidebar')

            {{-- main content --}}
            <div class="content-wrapper">

                {{-- Inner content --}}
                <div class="content-inner">
                    {{-- Page header --}}
                    <div class="page-header page-header-light shadow">
                        @include('layouts.shared.page-header')
                    </div>
                    {{-- /Page header --}}

                    {{-- Content area --}}
                    <div class="content">
                        @include('layouts.alerts.message')

                        @if ($errors->any())
                        <div class="btn disabled btn-danger ">
                            <div class="col-12">
                                @foreach ($errors->all() as $error)
                                <p>{{$error}}</p>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @yield('content')
                    </div>
                    {{-- /Content area --}}

                    @include('layouts.shared.footer')

                </div>
                {{-- /Inner content --}}

            </div>
            {{-- /Main content --}}

        </div>
        {{-- /Page content --}}

        @yield('modal')

        @stack('footer-script')
    </body>

</html>
