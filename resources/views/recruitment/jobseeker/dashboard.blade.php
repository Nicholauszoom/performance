@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-4">

            <!-- Members online -->
            
            <!-- /members online -->

        </div>

        <div class="col-lg-4">

            <!-- Current server load -->
            
            <!-- /current server load -->

        </div>

        <div class="col-lg-4">

            <!-- Today's revenue -->
            
            <!-- /today's revenue -->

        </div>
    </div>
@endsection
