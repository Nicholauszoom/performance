<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.shared.title-meta', ['title' => $title])
    @include('layouts.shared.head-css')
    <script src="{{ asset('assets/notification/js/bootstrap-growl.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/notification/css/notification.min.css') }}">

    {{-- @laravelPWA --}}

    <style>
        .request__spinner {

/* background: red; */
position: absolute;
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
border-radius: 50%;
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
     </style>
</head>



{{-- for hidding source codes --}}
{{-- oncontextmenu="return false" --}}
<body >
    <div class="request__spinner"></div>
    @include('layouts.shared.topbar')

    <!-- Page content -->
    <div class="page-content">

        {{-- @if (auth()->user()->hasRole('jobSeeker')) --}}
        {{-- @include('recruitment.jobseeker.left-sidebar') --}}
        {{-- @else --}}
        @include('layouts.shared.left-sidebar')
        {{-- @endif --}}
        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">
                <!-- Page header -->
                <div class="page-header page-header-light shadow">
                    @include('layouts.shared.page-header')
                </div>
                <!-- /page header -->

                <!-- Content area -->
                <div class="content">

                    @yield('content')
                </div>
                <!-- /content area -->

                @include('layouts.shared.footer')

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    @yield('modal')


    @stack('footer-script')

</body>

</html>
