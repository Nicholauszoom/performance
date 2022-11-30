@extends('layouts.vertical', ['title' => 'starter'])

@push('head-css')

@endpush

@push('head-script')
    <script src="{{ asset('tasset/js/pages/dashboard.js') }}"></script>
@endpush
