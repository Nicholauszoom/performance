
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
    <div class="col-md-7">
        <div class="card border-top border-top-width-3 border-top-main rounded-0 p-2">
            <div class="card-header">
                <h5 class="text-warning">Annual Leave Forfeting</h5>
            </div>
            <div class="card-body">
                <form id="demo-form2" enctype="multipart/form-data" method="post" action="{{ route('attendance.clear-leaves')}}" data-parsley-validate class="form-horizontal form-label-left">
                    @csrf
                    <div class="mb-3">
                        <div class="form-group row align-items-center">
                            <div class="col-md-12 col-lg-12 col-xs-12 d-flex gap-5">
                                <div class="col-8 d-flex ">
                                    <label for="attachment" class="control-label col-md-3">Attachment <span class="text-danger">*</span></label>
                                    <div class="col-9"> <!-- Reduce the column width and adjust the margin to the right -->
                                        <input class="form-control col-md-12 col-xs-12" type="file" name="file" requiredes accept=".xls, .xlsx">
                                    </div>
                                </div>

                                <div class="col-4"> <!-- Adjust the column width, no need to adjust the margin -->
                                    <button type="submit" class="btn btn-main w-75">Upload</button>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger"><?php // echo form_error("mname"); ?></span>
                    </div>
                    <p>
                        <small>
                            <i>Note:</i> Please note that this action of uploading bulk remaining leaves for balancing and clearing is performed only once in the system, especially at the end of the year, right before entering another new year.
                        </small>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>







<div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-header border-0">
<div class="">
    <h6 class="mb-0 text-warning">Annual Leaves Forfeitings</h6>

    <a href="{{ route('flex.updateOpeningBalance') }}" class="btn btn-main btn-sm float-end">Update Employee Opening Balance</a>
<br>
</div>
<hr>



    </div>

    <table  class="table table-striped table-bordered datatable-basic">
      <thead>
        <tr>
          <th>Payroll No</th>
          <th>Name</th>
          <th>Leave Entitled</th>
          <th>Opening Balance</th>
          <th>Days Spent</th>
          <th>Fortfeit Days</th>
          <th>Current Balance</th>
          <th>Action</th>
        </tr>
      </thead>


      <tbody>
        @foreach($leaveForfeiting as $item)
        <tr>
          <td>{{ $item->empID }}</td>
          <td><?php  $fname = App\Models\Employee::where('emp_id', $item->empID)->value('fname');
          $mname = App\Models\Employee::where('emp_id', $item->empID)->value('mname');
          $lname = App\Models\Employee::where('emp_id', $item->empID)->value('lname');
            echo ($fname.'  '.$mname. '  '.$lname)?> </td>
          <td>
            <?php  $leaveEntitled = App\Models\Employee::where('emp_id', $item->empID)->value('leave_days_entitled');
              echo ($leaveEntitled ." Days")?>
          </td>
          <td>
            {{$item->opening_balance ?? 0 ." Days"}}
          </td>
          <td>
           <?php  $natureId = 1;
           $currentYear = date('Y');
           $startDate = $currentYear . '-01-01'; // Start of the current year
           $endDate = date('Y-m-d'); // Current date

           $daysSpent = App\Models\Leaves::where('empId', $item->empID)
               ->where('nature', $natureId)
               ->whereBetween('created_at', [$startDate, $endDate])
               ->where('state',0)
               ->sum('days');

            echo ($daysSpent ." Days");

            ?>
          </td>
          <td>
            {{$item->days ." Days"}}
          </td>
          <td>
            <?php
            $leaveBalance = number_format($item->leaveBalance,2);

            echo ($leaveBalance." Days");
            ?>
          </td>
        <td class="text-center">
            <a href="{{ route('flex.editLeaveForfeitings', $item->empID) }}" class="btn btn-sm bg-main" title="Edit This Leave Approval">
                <i class="ph-note-pencil"></i>
            </a>
            </td>
        </tr>
        @endforeach

      </tbody>
    </table>
</div>




@endsection
