
<link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
<link rel="stylesheet" href="{{ asset('assets/icons/phosphor/styles.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}">

@stack('head-css')

<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

<link href="{{ asset('assets/date-picker/daterangepicker.css') }}" rel="stylesheet">


<script src="{{ asset('assets/js/configurator.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


<script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/components/notifications/noty.min.js') }}"></script>
<script src="{{ asset('assets/js/components/notifications/sweet_alert.min.js') }}"></script>

@stack('head-script')

<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/pages/extra_noty.js') }}"></script>
<script src="{{ asset('assets/js/pages/extra_sweetalert.js') }}"></script>

@stack('head-scriptTwo')
