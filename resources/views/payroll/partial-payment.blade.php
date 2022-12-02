@extends('layouts.vertical', ['title' => 'Partial Payments'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
  @include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Partial Payment</h5>
    </div>

    <div class="card-body">
        Partial Payment List
    </div>


    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Employee Name</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Days</th>
                <th>Payroll Date</th>
                <th>Status</th>
                <th>Option</th>
            </tr>
        </thead>

        <tbody>

        </tbody>
    </table>
</div>

@endsection


