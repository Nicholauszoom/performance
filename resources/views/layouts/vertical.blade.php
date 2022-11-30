<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.shared.title-meta', ['title' => $title])
    @include('layouts.shared.head-css')
</head>

<body>
    @include('layouts.shared.topbar')

    <!-- Page content -->
    <div class="page-content">

        @include('layouts.shared.left-sidebar')

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">
                <!-- Page header -->
                <div class="page-header page-header-light shadow">
                    @yield('page-header')
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


    @stack('footer-script')

</body>

</html>
