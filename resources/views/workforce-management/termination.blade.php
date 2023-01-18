@extends('layouts.vertical', ['title' => 'Termination'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('page-header')
  @include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card">
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0 text-muted">Terminated Employees</h5>

           

                <a href="{{ route('flex.addTermination') }}" class="btn btn-perfrom ">
                    <i class="ph-plus me-2"></i> Add Termination
                </a>
        </div>
    </div>


    <table class="table table-striped table-bordered datatable-basic">
        <thead>
            <tr>
                <th>SN</th>
                <th>Date</th>
                <th>Employee Name</th>
                <th>Reason(Description)</th>
                <th>Payments</th>
                <th>Deductions</th>
                <th>Option</th>
            </tr>
        </thead>

        <tbody>
               @foreach ($terminations as $item)
            <tr>
            <td>{{$i++}}</td>
            <td>{{ $item->terminationDate }}</td>
             <td>{{ $item->employee->fname}} {{ $item->employee->mname}} {{ $item->employee->lname}}</td>
             <td>{{ $item->reason}}</td>
             <td>
                {{ ($item->salaryEnrollment
                    +$item->normalDays
                    +$item->publicDays
                    +$item->leavePay
                    +$item->noticePay
                    +$item->houseAllowance
                    +$item->livingCost
                    +$item->utilityAllowance
                    +$item->serevanceCost
                    +$item->leaveStand
                    +$item->tellerAllowance
                    +$item->arrears
                    +$item->exgracia
                    +$item->bonus
                    +$item->longServing
                    +$item->otherPayments
                    )}}
            </td>
             <td>
                {{ (
                    $item->salaryAdvance
                    +$item->otherDeductions
                    )}}
             </td>
             <td>
                <a  href=""  title="Edit Loan">
                    <button type="button" class="btn btn-info btn-xs" ><i class="ph-printer"></i></button>
                </a>
             </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection


