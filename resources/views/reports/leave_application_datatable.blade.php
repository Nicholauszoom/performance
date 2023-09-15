@extends('layouts.vertical', ['title' => 'Annual Leave Report'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/buttons.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_extension_buttons_excel.js') }}"></script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="text-main">{{ $leave_name }} Leave Report</h5>
        </div>

        <table class="table datatable-excel-filter">
            <thead>
                <tr>
                    <th>Payroll No</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    @if(isset($employee))
                    <th>Approver</th>
                    @endif
                    @if(isset($is_all))
                    <th>Nature</th>
                    @endif
                    <th>Leave Address</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Days</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($leave_data as $row)
                    <td>{{ $row->emp_id }}</td>
                    <td>{{ $row->full_name }}</td>
                    <td>{{ $row->department_name }}</td>
                    <td>{{ $row->position_name }}</td>
                    @if(isset($employee))
                    @foreach($employee as $emp)
                    @if($emp->emp_id == $row->level1)
                    <td>{{ $emp->fname.' '.$emp->mname.' '.$emp->lname }}</td>
                    @endif
                    @endforeach
                    @endif
                    @isset($is_all)
                        <td>  @php
                            echo App\Models\LeaveType::where('id',$row->nature)->first()->type;
                            @endphp
                            </td>
                    @endisset
                    <td>{{ $row->leave_address }}</td>
                    <td> {{ $row->start }} </td>
                    <td>{{ $row->end }}</td>
                    <td>{{ number_format($row->days, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
