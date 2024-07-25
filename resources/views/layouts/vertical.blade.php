<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.shared.title-meta', ['title' => $title])
    @include('layouts.shared.head-css')

    <script src="{{ asset('assets/notification/js/bootstrap-growl.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/notification/css/notification.min.css') }}">
    <script src="{{ asset('assets/loader.js') }}"></script>

    @php
        $brandSetting = \App\Models\BrandSetting::first();
    @endphp


{{-- <script>
    $(document).ready(function() {
        $("form").submit(function(e) {
            // Disable the buttons and show the spinner
            $("button[type='submit']").html("<i class='ph-spinner spinner me-2'></i> Saving ...").addClass('disabled');


        });
    });
</script> --}}



    {{-- {{dd($brandSetting->body_background)}} --}}

    <style>
        :root {
            /* previous bank ABC #00204e */
            --primary-color: {{ $brandSetting->primary_color }};
            /* previous bank ABC #f0ab00 */
            --secondary-color: {{ $brandSetting->secondary_color }};
            /* previous bankABC #f0ab00 */
            --hover-color: {{ $brandSetting->hover_color }};

            /* previous bankABC ##f7c341 */
            --hover-color-two: {{ $brandSetting->hover_color_two }};
            /* Add more variables for other colors as needed */

            /* previous bankABC ##f7c341 */
            --loader-colorone: {{ $brandSetting->loader_color_one }};

            /* previous bankABC ##f7c341 */
            --loader-colortwo: {{ $brandSetting->loader_color_two }};

            /* previous bankABC ##f7c341 */
            --loader-colorthree: {{ $brandSetting->loader_color_three }};

            /* previous bankABC ##f7c341 */
            --loader-colorfor: {{ $brandSetting->loader_color_four }};

            /* previous bankABC ##f7c341 */
            --loader-colorfive: {{ $brandSetting->loader_color_five }};

            /* previous bankABC ##f7c341 */
            --loader-colorsix: {{ $brandSetting->loader_color_six }};

        }
    </style>



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

            position: absolute;
            top: calc(50% - 15px);
            left: calc(50% - 15px);
            width: 40px;
            height: 40px;
            border: 4px solid #a9a9a9;
            border-top-color: #000;
            border-radius: 30px;
            animation: spin 1s linear infinite;
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        body {
            /* background-image: url('{{ asset('img/bg2.png') }}'); */
            background-image: url('{{$brandSetting !=null && $brandSetting->body_background != null ? asset('storage/' . $brandSetting->body_background) : asset('img/bg2.png') }}');
            /* background-color: #f1f1f1; */
            background-color: #ffff;
            /* background: cover; */
            background-position: center;
            background-repeat: no-repeat;
        }

        .card {
            background-color: transparent !important;
        }


        .loader {
            height: 100vh;
            width: 100vw;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            background: #ffffff;
            z-index: 99;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .removed {
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .loader--dot {
            animation-name: loader;
            animation-timing-function: ease-in-out;
            animation-duration: 3s;
            animation-iteration-count: infinite;
            height: 20px;
            width: 20px;
            border-radius: 100%;
            background-color: black;
            position: absolute;
            border: 2px solid white;
        }

        .loader--dot:first-child {
            background-color: var(--loader-colorone, #00204e);
            animation-delay: 0.5s;
        }

        .loader--dot:nth-child(2) {
            background-color: var(--loader-colortwo, #f58646);
            animation-delay: 0.4s;
        }

        .loader--dot:nth-child(3) {
            background-color: var(--loader-colorthree, #da2128);
            animation-delay: 0.3s;
        }

        .loader--dot:nth-child(4) {
            background-color: var(--loader-colorfour, #00204e);
            animation-delay: 0.2s;
        }

        .loader--dot:nth-child(5) {
            background-color: var(--loader-colorfive, #37719f);
            animation-delay: 0.1s;
        }

        .loader--dot:nth-child(6) {
            background-color: var(--loader-colorsix, #818386);
            animation-delay: 0s;
        }




        .loader--text {
            position: absolute;
            top: 200%;
            left: 0;
            right: 0;
            width: 10rem;
            margin: auto;
        }

        .loader--text:after {
            content: "Loading ...";
            font-weight: bold;
            animation-name: loading-text;
            animation-duration: 3s;
            animation-iteration-count: infinite;
        }

        @keyframes loader {
            15% {
                transform: translateX(0);
            }

            45% {
                transform: translateX(230px);
            }

            65% {
                transform: translateX(230px);
            }

            95% {
                transform: translateX(0);
            }
        }

        @keyframes loading-text {
            0% {
                content: "Loading";
            }

            25% {
                content: "Loading .";
            }

            50% {
                content: "Loading  ..";
            }

            75% {
                content: "Loading  ...";
            }
        }
    </style>
</head>

<body>
    <div class="request__spinner"></div>

    <div class="page-content">
        {{-- page loader --}}
        <div id="loadingOverlay" class="loading-overlay">
            <div class='loader' id="element-to-remove">
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--text'></div>
            </div>
        </div>
        {{-- / Page loader --}}

        {{-- Left sidebar --}}
        @include('layouts.shared.left-sidebar')
        {{-- /Left sidebar --}}

        {{-- main content --}}
        <div class="content-wrapper">

            @include('layouts.shared.topbar')


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
                                    <p>{{ $error }}</p>
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

    <!-- Notifications -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="notifications">
        <div class="offcanvas-header py-0">
            <h5 class="offcanvas-title py-3">Activity</h5>
            <button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill"
                data-bs-dismiss="offcanvas">
                <i class="ph-x"></i>
            </button>
        </div>


    </div>
    <!-- /notifications -->

    @yield('modal')

    @stack('footer-script')
</body>

</html>
