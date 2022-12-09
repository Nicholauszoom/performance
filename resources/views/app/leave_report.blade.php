
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')('content')

<?php  
  ?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Leaves </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>My Leave History Already Accepted</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                  
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
                </div>
              </div>

            <?php if (session('line')!= 0 || session('conf_leave')!= 0 ) {   ?>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Other Employees' Leaves Already Accepted 

                    <?php if (session('conf_leave')!= 0 ){ ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a><button type="button" id="modal" data-toggle="modal" data-target="#departmentModal" class="btn btn-success">LEAVE REPORT</button></a>
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="<?php echo  url(''); ?>/flex/attendance/customleavereport" ><button type="button" class="btn btn-success">View Individual Report</button></a> <?php } ?>
                    </h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                  
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
                </div>
              </div>
              <?php } ?>

            </div>
          </div>
        </div>


          <!-- Modal -->
                <div class="modal fade" id="departmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">View Custom Leave Report</h4>
                          </div>
                          <div class="modal-body">
                          <!-- Modal Form -->
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
                          <input type="submit"  value="SHOW" name="view" class="btn btn-primary"/>
                          <input type="submit"  value="PRINT" name="print" class="btn btn-success"/>
                      </div>
                      </form>
                  </div>
                  <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
          <!-- Modal Form -->          
          </div>           
          <!-- /.modal -->
        <!-- /page content -->



           


 @endsection