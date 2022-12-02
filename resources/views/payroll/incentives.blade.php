@extends('layouts.vertical', ['title' => 'Incentives'])

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
        <h5 class="mb-0 text-muted">Employee Incentives</h5>
    </div>

    <div class="card-body">
        List Of Employees Entitled For Incentive This Month
    </div>


    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Inactive Name</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            
        </tbody>
    </table>
</div>

@endsection


