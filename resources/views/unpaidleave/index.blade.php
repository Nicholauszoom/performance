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

<div class="card">
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h6 class="mb-0 text-muted">Unpaid Leave Employee List</h6>

                {{-- start of add unpaid leave button --}}
                @can('add-unpaid-leaves')
                <a href="{{ route('flex.add_unpaid_leave') }}" class="btn btn-perfrom ">
                    <i class="ph-plus me-2"></i> Add Unpaid Leave
                </a>
                @endcan
                {{-- / --}}
        </div>
         @if(Session::has('note'))      {{ session('note') }}  @endif
    </div>


    <table class="table table-striped table-bordered datatable-basic">
        <thead>
            <tr>
                <th>SN</th>
                <th>Employee Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reason</th>
                <th hidden></th>

            </tr>
        </thead>
@php $i = 1;  @endphp
        <tbody>
               @foreach ($employee as $row)
            <tr>
            <td>{{$i++}}</td>
            <td>{{ $row->NAME }}</td>

            
             <td>{{ $row->start_date}}</td>
             <td>
                {{ $row->end_date}}
            </td>
             <td>
                {{ $row->reason }}
             </td>

             @can('end-unpaid-leaves')
             <td>
                {{-- start of end unpaid leave button --}}
                <a  href="{{ route('flex.end_unpaid_leave',$row->emp_id) }}"  title="End Unpaid Leave">
                    <button type="button" class="btn btn-info btn-xs" ><i class="ph-check"></i></button>
                </a>
                {{-- / --}}
             </td>
             @endcan
             <td hidden></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection


