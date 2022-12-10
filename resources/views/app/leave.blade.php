
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

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
            
            
            <?php $totalAccrued = number_format($leaveBalance,2); ?>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Leaves Applied By You  <a href="#bottom"><button type="button"  class="btn btn-primary">APPLY LEAVE</button></a></h2>
                  
                    <div class="clearfix"></div>
                    <h5>Days Accrued: <b> <?php echo $totalAccrued; ?> Days</b></h5>
                  </div>
                  <div class="x_content">

                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <div id ="resultfeedCancel"></div>
                  
                  
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Duration</th>
                          <th>Nature</th>
                          <th>Reason</th>
                          <th>Status</th>
                          <th>Option</th>
                          <th>Remarks</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        // if ($leave->num_rows() > 0){
                          foreach ($myleave as $row) {
                            if($row->status==2){ continue; }
                            $date1=date_create($row->start);
                            $date2=date_create($row->end);
                            $diff=date_diff($date1,$date2);
                            $final = $diff->format("%a Days");
                            $final2 = $diff->format("%a");
                           ?>
                          <tr id="record<?php echo $row->id; ?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>

                            

                            <td><?php 
                            // // DATE MANIPULATION
                              $start = $row->start;
                              $end =$row->end;
                              $datewells = explode("-",$start);
                              $datewelle = explode("-",$end);
                              $mms = $datewells[1];
                              $dds = $datewells[2];
                              $yyyys = $datewells[0];
                              $dates = $dds."-".$mms."-".$yyyys; 

                              $mme = $datewelle[1];
                              $dde = $datewelle[2];
                              $yyyye = $datewelle[0];  
                              $datee = $dde."-".$mme."-".$yyyye;
                            // 
                            echo $final."<br>From <b>".$dates."</b><br>To <b>".$datee."</b>";?></td>

                            <td><?php echo $row->type; ?></td>
                            <td><?php echo $row->reason; ?></td>

                            <td><div >
                                    <?php if ($row->status==0){ ?>
                                    <div class="col-md-12">
                                    <span class="label label-default">SENT</span></div><?php } 
                                    elseif($row->status==1){?>
                                    <div class="col-md-12">
                                    <span class="label label-info">RECOMMENDED</span></div><?php }
                                    elseif($row->status==2){  ?>
                                    <div class="col-md-12">
                                    <span class="label label-success">APPROVED</span></div><?php }
                                    elseif($row->status==3){?>
                                    <div class="col-md-12">
                                    <span class="label label-warning">HELD</span></div><?php }
                                    elseif ($row->status==4) { ?>
                                    <div class="col-md-12">
                                    <span class="label label-warning">CANCELLED</span></div><?php }
                                    elseif($row->status==5){?>
                                    <div class="col-md-12">
                                    <span class="label label-danger">DISAPPROVED</span></div><?php }  ?>
                                </div>
                                
                            </td>
                            <td class="options-width">
                            <?php if($row->status==0 || $row->status==3){ ?>
                            <a href="javascript:void(0)" onclick="cancelLeave(<?php echo $row->id;?>)">
                                <button  class="btn btn-warning btn-xs">CANCEL</button></a>
                            <?php } ?>
                            <a href="<?php echo  url('')."flex/attendance/leave_application_info/?id=".$row->id."&empID=".$row->empID; ?>"    title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                            </td>
                            <td>
                            <?php echo $row->remarks."<br>"; ?>                             
                            </td>
                            </tr>

                          <?php } //} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <?php
            if (session('mng_emp') || session('appr_leave')) {   ?>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Leaves Applied By Others(To be Confirmed if Not Yet)  </h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <div id ="resultfeed"></div>
                  
                    <table id="datatable-keytable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Duration</th>
                          <th>Nature</th>
                          <th>Reason</th>
                          <th>Status</th>
                          <th>Action</th>
                          <th>Remarks</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php

                          foreach ($otherleave as $row) {
                           if($row->status==2){ continue; }
                            $date1=date_create($row->start);
                            $date2=date_create($row->end);
                            $diff=date_diff($date1,$date2);
                            $final = $diff->format("%a Days");
                            $final2 = $diff->format("%a");
                           ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>

                            <td><?php echo $row->NAME; ?></td>

                            <td><?php 
                            // // DATE MANIPULATION
                              $start = $row->start;
                              $end =$row->end;
                              $datewells = explode("-",$start);
                              $datewelle = explode("-",$end);
                              $mms = $datewells[1];
                              $dds = $datewells[2];
                              $yyyys = $datewells[0]; 
                              $dates = date('d-m-Y', strtotime($start));

                              $mme = $datewelle[1];
                              $dde = $datewelle[2];
                              $yyyye = $datewelle[0];  
                              $datee = date('d-m-Y', strtotime($end));
                            
                              echo $final."<br>From <b>".$dates."</b><br>To <b>".$datee."</b>";?></td>

                            <td><?php echo $row->TYPE; ?></td>
                            <td><?php echo $row->reason; ?></td>
                            <td><div id ="status<?php echo $row->id; ?>">
                                
                                <?php if ($row->status==0){ ?>
                                <div class="col-md-12">
                                <span class="label label-default">REQUESTED</span></div><?php } 
                                elseif($row->status==1){?>
                                <div class="col-md-12">
                                <span class="label label-info">RECOMMENDED</span></div><?php }
                                elseif($row->status==2){  ?>
                                <div class="col-md-12">
                                <span class="label label-success">APPROVED</span></div><?php }
                                elseif($row->status==3){?>
                                <div class="col-md-12">
                                <span class="label label-warning">HELD</span></div><?php }
                                elseif ($row->status==4) { ?>
                                <div class="col-md-12">
                                <span class="label label-warning">CANCELLED</span></div><?php }
                                elseif($row->status==5){?>
                                <div class="col-md-12">
                                <span class="label label-danger">DISAPPROVED</span></div><?php }  ?>
                                </div>
                            </td>
                              <!--Line Manager and HR -->
                              <td>
                            
                            <?php if(session('appr_leave')){
                            
                            if($row->status==0){ ?>
                            
                            <a href="javascript:void(0)" onclick="recommendLeave(<?php echo $row->id;?>)" title="Recommend">
                                <button  class="btn btn-primary btn-xs"><i class="fa fa-check"></i></button></a>
                            
                            <a href="javascript:void(0)" onclick="holdLeave(<?php echo $row->id;?>)" title="Hold">
                                <button  class="btn btn-warning btn-xs"><i class="fa fa-times"></i></button></a>
                            <?php }  if($row->status==1) { ?>
                            
                            <a href="javascript:void(0)" onclick="holdLeave(<?php echo $row->id;?>)" title="Hold">
                                <button  class="btn btn-warning btn-xs"><i class="fa fa-times"></i></button></a>
                            
                            <?php } if($row->status==3) {  ?>
                            <a href="javascript:void(0)" onclick="recommendLeave(<?php echo $row->id;?>)" title="Recommend">
                                <button  class="btn btn-primary btn-xs"><i class="fa fa-check"></i></button></a>
                            <?php }} ?>
                            <?php if($row->status==5){ ?>
                                <a href="javascript:void(0)" onclick="cancelLeave(<?php echo $row->id;?>)" title="Cancel">
                                <button  class="btn btn-warning btn-xs"><i class="fa fa-times"></i></button></a>
                            <?php } ?>
                            
                            <!-- HR -->
                            
                            <?php if(session('mng_emp')){
                            
                            if($row->status==1 ){ ?>
                            
                            <a href="javascript:void(0)" onclick="approveLeave(<?php echo $row->id;?>)" title="Approve">
                                <button  class="btn btn-success btn-xs"><i class="fa fa-check"></i></button></a>
                            
                            <?php }  if($row->status==2) { ?>
<!--                             
                            <a href="javascript:void(0)" onclick="rejectLeave(<?php echo $row->id;?>)">
                                <button  class="btn btn-danger btn-xs">DISAPPROVE</button></a> -->
                            
                            <?php } if($row->status==5) {  ?>
                            <a href="javascript:void(0)" onclick="approveLeave(<?php echo $row->id;?>)" title="Approve">
                                <button  class="btn btn-success btn-xs"><i class="fa fa-check"></i></button></a>
                            <?php } } ?>
                            </td>
                            <td>
                            <?php echo $row->remarks."<br>"; ?>
                              <a href="<?php echo  url('')."flex/attendance/leave_remarks/?id=".$row->id; ?>">
                              <button type="submit" name="go" class="btn btn-info btn-xs">Add Remark</button></a>
                              <a href="<?php echo  url('')."flex/attendance/leave_application_info/?id=".$row->id."&empID=".$row->empID; ?>" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                            </td> 
                            </tr>

                          <?php } //} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <?php } ?>
              
              
              
               <div id="bottom" class="col-md-12 col-sm-12 col-xs-12">
                            
                    <div class="x_panel">
                      <div class="x_title">
                        <h2><i class="fa fa-tasks"></i> Apply Leave</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <div id ="resultfeedSubmission"></div>
                        <form id="applyLeave" autocomplete="off"  method="post"  data-parsley-validate class="form-horizontal form-label-left">
                          <!-- START -->
                          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date to Start 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="has-feedback">
                          <input type="text" name="start" class="form-control col-xs-12 has-feedback-left" placeholder="Start Date" id="leave_startDate" required="" aria-describedby="inputSuccess2Status">
                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                          <span class="text-danger"><?php// echo form_error("fname");?></span>
                        </div>
                      </div> 
                          <input type="text" name="limit" hidden value="<?php echo $totalAccrued; ?>">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date to Finish
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="has-feedback">
                          <input type="text" required="" placeholder="End Date" name="end" class="form-control col-xs-12 has-feedback-left" id="leave_endDate"  aria-describedby="inputSuccess2Status">
                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                          <span class="text-danger"><?php// echo form_error("fname");?></span>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name" for="stream" >Nature of Leave</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select required  name="nature"  class="select_leave_type form-control">
                            <option></option>
                            <?php  $sex = session('gender');
                           if ($sex=='Male') { $gender = 1; }else if($sex=='Female') {$gender = 2; }
                           foreach($leave_type as $key){ if($key->gender > 0 && $key->gender!= $gender) continue; ?>
                          <option value="<?php echo $key->id; ?>"><?php echo $key->type; ?></option> <?php  } ?>
                        </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Leave Address
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required="required" type="text" id="address" name="address" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php// echo form_error("lname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required="required" class="form-control col-md-7 col-xs-12" type="text" name="mobile">
                          <span class="text-danger"><?php// echo form_error("mname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reason For Leave(Optional)
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea maxlength="256" class="form-control col-md-7 col-xs-12" name="reason" placeholder="Reason" required="required" rows="3"></textarea> 
                          <span class="text-danger"><?php// echo form_error("lname");?></span>
                        </div>
                      </div>
                          <!-- END -->
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                               <button  class="btn btn-primary" >APPLY</button>
                            </div>
                          </div> 
                          </form>
            
                      </div>
                    </div>
                </div>

            </div>
          </div>
        </div>
           

@include   ("app/includes/leave_operations")



        <script>
        $(function() {
          var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth() + 1; //January is 0!

          var yyyy = today.getFullYear();
          if (dd < 10) {
            dd = '0' + dd;
          } 
          if (mm < 10) {
            mm = '0' + mm;
          } 
          var dateToday = dd + '/' + mm + '/' + yyyy;
          $('#leave_startDate').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            startDate:dateToday,
            minDate:dateToday,
            locale: {      
              format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_1"
          }, function(start, end, label) {
            // var years = moment().diff(start, 'years');
            // alert("The Employee is " + years+ " Years Old!");

          });
            $('#leave_startDate').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('DD/MM/YYYY'));
          });
            $('#leave_startDate').on('cancel.daterangepicker', function(ev, picker) {
              $(this).val('');
          });
        });
        </script>
        <script>
        $(function() {
          var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth() + 1; //January is 0!

          var yyyy = today.getFullYear();
          if (dd < 10) {
            dd = '0' + dd;
          } 
          if (mm < 10) {
            mm = '0' + mm;
          } 
          var dateToday = dd + '/' + mm + '/' + yyyy;
          $('#leave_endDate').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            startDate:dateToday,
            minDate:dateToday,
            locale: {      
              format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_1"
          }, function(start, end, label) {
            // var years = moment().diff(start, 'years');
            // alert("The Employee is " + years+ " Years Old!");

          });
            $('#leave_endDate').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('DD/MM/YYYY'));
          });
            $('#leave_endDate').on('cancel.daterangepicker', function(ev, picker) {
              $(this).val('');
          });
        });
        </script>
 @endsection