
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')


<div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-header">
        <h3 class="text-main">Leaves </h3>
    </div>

    <div class="card-body">
        My Leave History Already Accepted
    </div>

    <table  class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>Department</th>
            <th>Nature</th>
            <th>Duration(Days)</th>
            <th>From</th>
            <th>To</th>

          </tr>
        </thead>


        <tbody>
          <?php
            foreach ($my_leave as $row) { ?>
            <tr>
              <td width="1px"><?php echo $row->SNo; ?></td>
              <td><?php  echo $row->NAME; ?></td>
              <td><?php echo "<b>DEPARTMENT:</b> ".$row->DEPARTMENT."<br><b>POSITION: </b>".$row->POSITION; ?></td>
              <td><?php echo $row->TYPE; ?></td>
              <td><?php echo $row->days; ?></td>
              <td><?php  echo date('d-m-Y', strtotime($row->start));  ?></td>
              <td <?php if($row->state==0){ ?> bgcolor="#F5B7B1" <?php } ?>>
              <?php  echo date('d-m-Y', strtotime($row->end))."<br>"; ?>  </td>
              </td>

              </tr>

            <?php }  ?>
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
