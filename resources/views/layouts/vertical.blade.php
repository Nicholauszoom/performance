<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.shared.title-meta', ['title' => $title])
    @include('layouts.shared.head-css')
    <script src="{{ asset('assets/notification/js/bootstrap-growl.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/notification/css/notification.min.css') }}">
</head>
<style>
    body {
 background-image: url('{{ asset('img/bg.png') }}');
 /* background-color: #f1f1f1; */
 background-color: #ffff;
 background: cover;
 background-repeat: none;

 
}
 </style>

{{-- for hidding source codes --}}
{{-- oncontextmenu="return false" --}}
<body >
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
