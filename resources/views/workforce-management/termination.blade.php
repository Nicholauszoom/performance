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

           
            @can('add-termination')

                <a href="{{ route('flex.addTermination') }}" class="btn btn-perfrom ">
                    <i class="ph-plus me-2"></i> Add Termination
                </a>
            @endcan
        </div>
    </div>

    @if (session('msg'))
    <div class="alert alert-success col-md-8 mx-auto" role="alert">
    {{ session('msg') }}
    </div>
    @endif

    <table class="table table-striped table-bordered datatable-basic">
        <thead>
            <tr>
                <th>SN</th>
                <th>Date</th>
                <th>Employee Name</th>
                <th>Reason(Description)</th>
                <th>Payments</th>
                <th>Deductions</th>
                <th>Status</th>
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
                    +$item->otherDeduction
                    )}}
             </td>
             <td>
                <span class="badge btn-main disabled">
                    {{ $item->status == '1' ? 'Terminated':'Pending' }} 
                </span>
                
             </td>
             <td>
                @if($item->status=='1')
                <a  href="{{ url('flex/view-termination/'.$item->id) }}"  title="Print Terminal Benefit">
                    <button type="button" class="btn btn-main btn-xs" ><i class="ph-printer"></i></button>
                </a>
                @endif
                @if($level)
                @if($item->status!='1')
                @if ($item->status!=$check)
                @can('confirm-termination')
                {{-- start of termination confirm button --}}
                <a  href="{{ url('flex/approve-termination/'.$item->id) }}"  title="Confirm Termination">
                    <button type="button" class="btn btn-main btn-xs" > <i class="ph-check"></i> Confirm</button>
                </a>
                {{-- / --}}

                {{-- start of termination confirm button --}}
                <a  href="{{ url('flex/cancel-termination/'.$item->id) }}"  title="Cancel Termination">
                    <button type="button" class="btn btn-danger btn-xs" ><i class="ph-trash"></i> Cancel </button>
                </a>
                {{-- / --}}
                @endcan
                @endif
                @endif
                @endif
             </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection


