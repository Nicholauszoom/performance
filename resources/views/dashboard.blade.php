@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('tasset/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('tasset/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

    {{-- content will come in this section --}}

@endsection


