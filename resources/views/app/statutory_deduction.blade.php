@extends('layouts.vertical', ['title' => 'Statutory Deductions'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

<div class="mb-3">
    <h5>Statutory Deductions</h5>
</div>

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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pension as $row)
                <tr id="{{ 'domain'.$row->id }}">
                    <td>{{ $row->SNo }}</td>
                    <td>{{ $row->name.' ('.$row->abbrv.')' }}</td>
                    <td>{{ ($row->amount_employee) * 100 .'%' }}</td>
                    <td> {{ ($row->amount_employer) * 100 .'%' }}</td>

                    <td>
                        @if ($row->deduction_from == 1)
                        <span class="badge bg-success">Basic Salary</span>
                        @else
                        <span class="badge bg-success">Gross</span>
                        @endif
                    </td>

                    <td>
                        <?php $par = $row->id. "|1" ?>
                        <a href="{{ route('flex.deduction_info', $par) }}" title="Info and Details" class="icon-2 info-tooltip">
                            <button type="button" class="btn btn-info btn-xs"><i class="ph-info"></i></button>
                        </a>
                    </td>

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
                @if ($pendingPayroll == 0)
                <th class="text-center">Option</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($deduction as $row)
                <tr>
                    <td>{{ $row->SNo }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ 100*($row->rate_employee) .'%' }}</td>
                    <td>{{ 100*($row->rate_employee) .'%' }}</td>

                    @if ($pendingPayroll == 0)
                    <td class="options-width">
                        <a

                            href="{{ url('/flex/common_deductions_info', $row->id) }}"  title="More Info" class="icon-2 info-tooltip">
                            <button type="button" class="btn btn-info btn-xs"><i class="ph-note-pencil"></i></button>
                        </a>
                    </td>
                    @endif
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
                    <th>Excess Added as </th>
                    <th>Rate to an Amount Excess of Minimum </th>
                    @if($pendingPayroll==0)
                    <th>Option</th>
                    @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($paye as $row)
                <tr>
                    <td>{{ $row->SNo }}</td>
                    <td>{{ number_format($row->minimum, 2) }}</td>
                    <td>{{ number_format($row->maximum, 2) }}</td>
                    <td>{{ number_format($row->excess_added, 2) }} </td>
                    <td> {{ 100 * ($row->rate) .'%' }} </td>
                    @if ( $pendingPayroll == 0 )
                    <td class="options-width">
                        <a class="tooltip-demo" data-toggle="tooltip" data-placement="top" title="Edit"  href="<?php echo url('')."/flex/paye_info/?id=".$row->id; ?>">
                            <button type="button" class="btn btn-info btn-xs" ><i class='ph-note-pencil'></i></button>
                        </a>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<div>
    <div id="save_department" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New P .A .Y .E Range</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form
                    action="{{ route('flex.addOvertimeCategory') }}"
                    method="POST"
                    class="form-horizontal"
                >
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label col-sm-3">Minimum</label>
                            <input type="text" name="minimum"  value="{{ old('minimum') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label col-sm-3">Maxmum</label>
                            <input type="number" name="maximum"  value="{{ old('maximum') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label col-sm-3">Excess added</label>
                            <input type="number" name="excess_added"  value="{{ old('excess_added') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label col-sm-3">Rate to an Amount Excess of Minimum</label>
                            <input type="number" name="rate"  value="{{ old('rate') }}" class="form-control">
                        </div>
                    <div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-perfrom">Save Range</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
