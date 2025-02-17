@extends('layouts.vertical', ['title' => 'Unpaid Leaves'])

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

<div class="card  border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5 class="text-warning ">Unpaid Leave Employee List</h5>
                @can('add-unpaid-leaves')
                <a href="{{ route('flex.add_unpaid_leave') }}" class="btn btn-perfrom ">
                    <i class="ph-plus me-2"></i> Add Unpaid Leave
                </a>
                @endcan
        </div>
         @if(Session::has('note'))      {{ session('note') }}  @endif
         <div id="resultfeed"></div>

    </div>

    <div class="card-body">


    <table class="table table-striped table-bordered datatable-basic">
        <thead>
            <tr>
                <th>SN</th>
                <th>Employee Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>

            </tr>
        </thead>
@php $i = 1;  @endphp
        <tbody>
               @foreach ($employee as $row)
            <tr>
            <td>{{$i++}}</td>
            <td>{{ $row->NAME }}</td>


             <td>{{ \Carbon\Carbon::parse($row->start_date)->format('d-m-Y')}}</td>
             <td>
                {{  \Carbon\Carbon::parse($row->end_date)->format('d-m-Y')}}
            </td>
             <td>
                {{ $row->reason }}
             </td>


             <td>
                {{ ($row->status == 1)?'Approved':'Not Approved' }}
             </td>
             <td>
                @can('end-unpaid-leaves')
                <a  href="{{ route('flex.end_unpaid_leave',$row->emp_id) }}"  title="End Unpaid Leave">
                    <button type="button" class="btn btn-danger btn-xs" ><i class="ph-info"></i></button>
                </a>
                @endcan
                @if($row->status != 1)
                <a  href="{{ route('flex.confirm_unpaid_leave',$row->emp_id) }}"  title="Confirm Unpaid Leave">
                    <button type="button" class="btn btn-main btn-xs" ><i class="ph-check"></i></button>
                </a>
                @endif
             </td>


            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

@endsection


