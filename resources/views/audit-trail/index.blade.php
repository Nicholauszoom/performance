@extends('layouts.vertical', ['title' => 'Audit-trail'])

@push('head-script')
    <script src="{{ asset('tasset/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('tasset/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('tasset/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Setting - <span class="fw-normal">Audit Trail</span>
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
                <a href="#" class="breadcrumb-item">Setting</a>
                <span class="breadcrumb-item active">Audit Trail</span>
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
        <h5 class="mb-0 text-muted">Audit Trail</h5>
    </div>


    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>Action</th>
                <th>IP Adress</th>
                <th>Time performed</th>
                <th>Risk</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($audits as $audit)
            <tr>
                <td>{{ $audit->user_id }}</td>
                <td><a href="#">{{ $audit->user_name }}</a></td>
                <td>{{ $audit->action_performed }}</td>
                <td>{{ $audit->ip_address }}</td>
                <td>{{ $audit->created_at }}</td>
                <td>
                    @isset($audit->risk)
                        @if ($audit->risk == 1)
                        <span class="badge bg-success bg-opacity-10 text-success">Low</span>
                        @elseif ($audit->risk == 2)
                        <span class="badge bg-info bg-opacity-10 text-info">Medium</span>
                        @elseif ($audit->risk == 3)
                        <span class="badge bg-danger bg-opacity-10 text-danger">High</span>
                        @else
                        <span class="badge bg-secondary bg-opacity-10 text-secondary">Unrecognized</span>
                        @endif
                    @endisset
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- /basic datatable -->

@endsection


