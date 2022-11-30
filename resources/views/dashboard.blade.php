@extends('layouts.vertical', ['title' => 'Audit-trail'])

@push('head-script')
    <script src="{{ asset('tasset/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('tasset/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('tasset/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Home - <span class="fw-normal">Dashboard</span>
            </h4>

            <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>

    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="index.html" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">Dashboard</a>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')

<!-- Basic datatable -->
<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Dashboard</h5>
    </div>
</div>
<!-- /basic datatable -->

@endsection


