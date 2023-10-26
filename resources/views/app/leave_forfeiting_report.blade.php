
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
    <div class="card-header">
        <h5 class="text-main">Annual Leaves Forfeitings </h5>
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
            <button type="button" class="btn btn-main btn-sm edit_role_btn mr-1" data-bs-toggle="modal" data-id="1" data-name="Human Capital Officer" data-slug="Human Capital Officer">
                <i class="ph-note-pencil"></i>
            </button>
            </td>

        </tr>
        {{-- @endif --}}



        @endforeach

      </tbody>
    </table>
</div>

@if (session('line')!= 0 || session('conf_leave')!= 0)
    <div class="card">
        <div class="card-body">
            Other Employees' Leaves Already Accepted

            <?php if (session('conf_leave')!= 0 ){ ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a><button type="button" id="modal" data-toggle="modal" data-target="#departmentModal" class="btn btn-success">LEAVE REPORT</button></a>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?php echo  url(''); ?>/flex/attendance/customleavereport" ><button type="button" class="btn btn-success">View Individual Report</button></a> <?php } ?>

        </div>

        <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Department</th>
                <th>Nature</th>
                <th>Duration(Days)</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>

              </tr>
            </thead>


            <tbody>
              <?php
                foreach ($other_leave as $row) { ?>
                <tr>
                  <td width="1px"><?php echo $row->SNo; ?></td>
                  <td><?php  echo $row->NAME; ?></td>
                  <td><?php echo "<b>DEPARTMENT:</b> ".$row->DEPARTMENT."<br><b>POSITION: </b>".$row->POSITION; ?></td>
                  <td><?php echo $row->TYPE; ?></td>
                  <td><?php echo $row->days; ?></td>
                  <td><?php  echo date('d-m-Y', strtotime($row->start));  ?></td>
                  <td><?php  echo date('d-m-Y', strtotime($row->end));  ?></td>
                  <td>
                    <?php if($row->end>=$today) echo '<span class="label label-success"><b>IN PROGRESS</b></span>'; else echo '<span class="label label-danger"><b>COMPLETED</b></span>';  ?>
                  </td>

                  </tr>

                <?php } //} ?>
            </tbody>
          </table>
    </div>
@endif


<div class="modal">
    <form id="demo-form2" enctype="multipart/form-data" target="_blank" method="post" action="<?php echo  url(''); ?>/flex/attendance/customleavereport"  data-parsley-validate class="form-horizontal form-label-left">


        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">From
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="has-feedback">
          <input type="text" name="from" class="form-control col-xs-12 has-feedback-left" id="single_cal1"  aria-describedby="inputSuccess2Status">
          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
        </div>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="has-feedback">
          <input type="text" name="to" class="form-control col-xs-12 has-feedback-left" id="single_cal2"  aria-describedby="inputSuccess2Status">
          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
        </div>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name" for="stream" >Type</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="target" class="form-control">
               <option value="1"> ALL LEAVES</option>
                <option value="2">COMPLETED</option>
                <option value="3">ON PROGRESS</option>
            </select>
        </div>
      </div>


      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <input type="submit"  value="SHOW" name="view" class="btn btn-main"/>
          <input type="submit"  value="PRINT" name="print" class="btn btn-success"/>
      </div>
      </form>
</div>




@endsection
