@extends('layouts.vertical', ['title' => 'Dashboard'])

{{-- @push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('assets/js/components/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/buttons.min.js') }}"></script>
@endpush --}}

{{-- @push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables_extension_buttons_html5.js') }} "></script>
@endpush --}}


@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/buttons.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_extension_buttons_excel.js') }}"></script>
@endpush

@section('content')
    <!-- Column selectors -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ $leave_name }}  Leave Balance : {{ $date }}</h5>
            @if(isset($department_name))
            <h5 class="mb-0">Department : {{ $department_name }}</h5>
            @elseif(isset($position_name))
            <h5 class="mb-0">Position : {{ $position_name }}</h5>
            @endif
        </div>
        <table class="table datatable-excel-filter">
            <thead>
                <tr>
                    <th>No</th>
                    <th>EMP ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>department</th>
                    <th>Position</th>

                    @if(isset($is_all))
                    <th>Leave Type</th>
                    @endif
                    <th>Leave Days Taken</th>
                </tr>
            </thead>

            <tbody>
                <?php
              $i=0;

                foreach ($employees as $employee) { $i++ ?>
               <?php
                $flag = true;
               if($employee->gender == 'Male' && $nature == 5){
                 $flag = true;
                }elseif($employee->gender == 'Female' && $nature == 4){
                    $flag  = true;
                } elseif($nature !=5 && $nature != 4){
                    $flag  = true;
                }

                else{
                    $flag = false;
                }

                ?>
                @if($flag)
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $employee->emp_id; ?></td>
                    <td><?php echo $employee->fname; ?></td>
                    <td><?php echo $employee->lname; ?></td>
                    <td><?php echo $employee->departments->name; ?></td>
                    <td><?php echo $employee->positions->name; ?></td>


                    @if(isset($is_all))
                    <td><?php echo App\Models\LeaveType::where('id',$employee->nature)->first()->type; ?></td>
                    @endif

                    <td><?php echo number_format(($employee->opening_balance < 0?($employee->days_spent +(-1*$employee->opening_balance)):$employee->days_spent),2) ?></td>

                </tr>
                @else
                <tr>
                    <td><?php echo $i; ?></td>
                            <td><?php echo $employee->emp_id; ?></td>
                            <td><?php echo $employee->fname; ?></td>
                            <td><?php echo $employee->lname; ?></td>
                            <td><?php echo $employee->departments->name; ?></td>
                            <td><?php echo $employee->positions->name; ?></td>
                            @if(isset($is_all))
                            <td><?php echo App\Models\LeaveType::where('id',$employee->nature)->first()->type; ?></td>
                            @endif
                            <td><?php echo number_format(($employee->days_spent*0)) ?></td>

                </tr>
                @endif

                <?php } ?>
            </tbody>

        </table>
    </div>
    <!-- /column selectors -->
@endsection
