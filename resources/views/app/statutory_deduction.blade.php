@extends('layouts.vertical', ['title' => 'Statutory Deductions'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

<div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0">Pension Funds</h5>
            </div>
        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Employee Amount</th>
                    <th>Employer Amount</th>
                    <th>Deduction From</th>
                    <th class="text-center">Action</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pension as $row)
                    <tr>
                        <td>{{ $row->SNo }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->amount_employee }}</td>
                        <td> {{ $row->amount_employer }}</td>
                        <td> {{ $row->deduction_from }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0">List of Deduction</h5>
            </div>
        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Employee Amount(in %)</th>
                    <th>Employer Amonut(in %)</th>
                    <th class="text-center">Action</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deduction as $row)
                    <tr>
                        <td>{{ $row->SNo }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->rate_employee }}</td>
                        <td>{{ $row->rate_employer }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0">P .A .Y .E Ranges</h5>
                <button type="button" class="btn btn-perfrom" data-bs-toggle="modal" data-bs-target="#save_department">
                    <i class="ph-plus me-2"></i> Overtime
                </button>
            </div>
        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Minimum Amount</th>
                    <th>Maximum Amount</th>
                    <th>Excess Added as</th>
                    <th>Rate to an Amount Excess of Minimum</th>
                    <th class="text-center">Action</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paye as $row)
                    <tr>
                        <td>{{ $row->SNo }}</td>
                        <td>{{ $row->minimum }}</td>
                        <td>{{ $row->maximum }}</td>
                        <td>{{ $row->excess_added }} </td>
                        <td> {{ $row->rate }} </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('modal')
    @include('setting.deduction.add_paye')
@endsection
