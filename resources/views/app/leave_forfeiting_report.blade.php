@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-top border-top-width-3 border-top-main rounded-0 p-2">
                <div class="card-header">
                    <h5 class="text-warning">Annual Leave Forfeting</h5>
                </div>

                <div class="card-body">
                    <form id="demo-form2" enctype="multipart/form-data" method="post" action="{{ route('attendance.clear-leaves') }}" data-parsley-validate class="form-horizontal form-label-left">
                        @csrf

                        <div class="mb-3 row align-items-center">
                            <div class="col-md-4 col-lg-4 col-xs-12">
                                <label for="years" class="form-label col-md-4">Year of Forfeiting <span class="text-danger">*</span></label>
                                <select name="forfeit_year" id="forfeit_year" class="form-select col-md-8" tabindex="-1">
                                    <option value="">-- Select Year --</option>
                                    <option value="2008">2008</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="attachment" class="form-label col-md-5">Attachment <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="file" required accept=".xls, .xlsx">
                            </div>

                            <div class="col-md-2 pt-4">

                                <button type="submit" class="btn btn-main w-100">Forfeit</button>
                            </div>
                        </div>

                        <p>
                            <small>
                                <i>Note:</i> Please note that this action of forfeiting leave days is performed only once in a year.
                            </small>
                        </p><br>
                        <a  href="{{ asset('uploads/templates/leaveforfeiting_template.xlsx') }}" >
                            Click here to download leave forfeitings excel template
                        </a>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
        <div class="card-header border-0">
            <div class="">
                <h6 class="mb-0 text-warning">Annual Leaves Forfeitings</h6>

                <a href="{{ route('flex.updateOpeningBalance') }}" class="btn btn-main btn-sm float-end">Update Employee
                    Opening Balance</a>
                <br>
            </div>
            <hr>



        {{-- </div>
        <div class="col-md-4 col-lg-4 col-xs-12">
            <label for="years" class="control-label col-md-4">Year of Forfeiting <span class="text-danger">*</span></label>
            <select name="forfeit_year" id="forfeit_year" class="form-select col-md-8" tabindex="-1">
                <option value="">-- Select Year --</option>
                <option value="2008">2008</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
            </select>
        </div> --}}

        <table class="table table-striped table-bordered datatable-basic">
            <thead>
                <tr>
                    <th>Payroll No</th>
                    <th>Name</th>
                    <th>Leave Entitled</th>
                    <th>Opening Balance</th>
                    <th>Days Taken</th>
                    <th>Fortfeit Days</th>
                    <th>Fortfeit Year</th>
                    <th>Current Balance</th>
                    <th>Action</th>
                </tr>
            </thead>


            <tbody>
                @foreach ($leaveForfeiting as $item)
                    <tr>
                        <td>{{ $item->empID }}</td>
                        <td><?php $fname = App\Models\Employee::where('emp_id', $item->empID)->value('fname');
                        $mname = App\Models\Employee::where('emp_id', $item->empID)->value('mname');
                        $lname = App\Models\Employee::where('emp_id', $item->empID)->value('lname');
                        echo $fname . '  ' . $mname . '  ' . $lname; ?> </td>
                        <td>
                            <?php $leaveEntitled = App\Models\Employee::where('emp_id', $item->empID)->value('leave_days_entitled');
                            echo $leaveEntitled . ' Days'; ?>
                        </td>
                        <td>
                            {{ $item->opening_balance ? $item->opening_balance . ' Days' : '0 Days' }}

                        </td>
                        <td>
                            <?php $natureId = 1;
                            $currentYear = date('Y');
                            $startDate = $currentYear . '-01-01'; // Start of the current year
                            $endDate = $currentYear . '-12-31'; // Current date

                            $daysSpent = App\Models\Leaves::where('empId', $item->empID)
                                ->where('nature', $natureId)
                                ->whereBetween('created_at', [$startDate, $endDate])
                                ->where('state', 0)
                                ->sum('days');

                                $daysTaken = number_format($daysSpent, 2);


                            echo $daysTaken . ' Days';

                            ?>
                        </td>
                        <td>
                            {{ $item->days ? $item->days . ' Days' : '0 Days' }}
                        </td>
                        <td>
                            {{ $item->forfeiting_year ?? 'No Forfeiting' }}
                        </td>
                        <td>
                            <?php
                            $leaveBalance = number_format($item->leaveBalance, 2);

                            echo $leaveBalance . ' Days';
                            ?>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('flex.editLeaveForfeitings', $item->empID) }}" class="btn btn-sm bg-main"
                                title="Edit This Leave Approval">
                                <i class="ph-note-pencil"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
