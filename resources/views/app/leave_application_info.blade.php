@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php   
  foreach ($data as $row) {
        $leaveID = $row->id; 
        $applicant = $row->empID; 
        $nature = $row->nature; 
        $startDate = $row->start; 
        $endDate = $row->end; 
        $type = $row->leave_type; 
        $address = $row->leave_address; 
        $mobile = $row->mobile;
        $reason = $row->reason;
        $status = $row->status;
    }
    $totalAccrued = number_format($leaveBalance,1);
  
  ?>


        <!-- page content -->
<!-- page content -->
<div class="right_col" role="main">
<div class="">
             
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
                    <!-- start project-detail sidebar -->
          <div class="col-md-12 col-sm-3 col-xs-12">
            <section class="panel">
              <div class="panel-body">
                        <!--Start Tabs Content-->
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="card">
                      <div class="card-head">
                          <h3 class="green"><i class="fa fa-info-circle"></i> Info and Details</h3>
                            @if(Session::has('note'))      {{ session('note') }}  @endif  
                            <div id ="resultFeed"></div>

                        <div class="clearfix"></div>
                      </div>
                      <div class="card-body">    
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#description" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">DETAILS</a>
                            </li>
                            <?php if(auth()->user()->emp_id ==$applicant && $status !=1 && $status!=2){  ?>
                            <li role="presentation" class=""><a href="#updateLeave" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><font class = "text-info"><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>UPDATE LEAVE</b></font></a>
                            </li>
                            <?php } ?>
                          </ul>
                          <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="description" aria-labelledby="home-tab">
                              <p><b><font class="green">Reason and Description: </font></b><?php echo $reason; ?></p>
                              <p><b><font class="green">Leave Type: </font></b><?php echo $type; ?></p>
                              <p><b><font class="green">Start Date: </font></b><?php echo date('d-m-Y', strtotime($startDate)); ?></p>
                              <p><b><font class="green">End Date: </font></b><?php echo date('d-m-Y', strtotime($endDate)); ?></p>
                              <p><b><font class="green">Address: </font></b><?php echo $address; ?></p>
                              <p><b><font class="green">Mobile: </font></b><?php echo $mobile; ?></p>

                              
                              <p><b><font class="green">Status: </font></b><?php if ($status==0){ ?>
                                <div class="col-md-12">
                                <span class="label label-default">On Progress</span></div><?php } 
                                elseif($status==1){?>
                                <div class="col-md-12">
                                <span class="label label-info">Submitted</span></div><?php }
                                elseif($status==2){?>
                                <div class="col-md-12">
                                <span class="label label-success">Approved</span></div><br><br>
                                

                                <?php } elseif($status==3){?>
                                <div class="col-md-12">
                                <span class="label label-warning">Canceled</span></div><?php }elseif($status==5){?>
                                <div class="col-md-12">
                                <span class="label label-warning">Disapproved</span></div><?php }
                                elseif ($status==4) { ?>
                                <div class="col-md-12">
                                <span class="label label-danger">Overdue</span></div> <?php } ?> <br></p>                     
                          </div> 

                            <?php if(auth()->user()->emp_id ==$applicant && $status !=1 && $status!=2){  ?>
                             <!--Update Leave-->
                            <div role="tabpanel" class="tab-pane fade active" id="updateLeave" aria-labelledby="profile-tab">
                            <div id="resultFeed"></div>
                              <div class="col-md-12 col-sm-6 col-xs-12">

                                      
                                      <!--START DATE-->
                                    <form autocomplete="off" id="updateLeaveDateRange" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Leave Nature
                                        </label>
                                           <span class="text-info"><?php echo $type; ?></span> 
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <select name="nature" class="form-control">
                                          <?php 
                                          $sex = session('gender');
                                          if ($sex=='Male') {
                                            $gender = 1; 
                                          } else if($sex=='Female'){
                                            $gender = 2; 
                                          }
                                          foreach($leave_type as $key){ 
                                            if($key->gender > 0 && $key->gender!= $gender) continue; ?>
                                            <option <?php if ($nature==$key->id){ ?> selected="" <?php } ?> value="<?php echo $key->id; ?>">
                                            <?php echo $key->type; ?>
                                            </option> 
                                            <?php  } ?>
                                            </select>
                                        </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start
                                        </label>
                                           <span class="text-info"><?php echo date('d-m-Y', strtotime($startDate)); ?></span> 
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input type="text" name="start" class="form-control col-xs-12 has-feedback-left" id="leave_startDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End
                                        </label>
                                           <span class="text-info"><?php echo date('d-m-Y', strtotime($endDate)); ?></span> 
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input type="text" name="end" class="form-control col-xs-12 has-feedback-left" id="leave_endDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                          <span id="age" class="text-danger">Maximum: <?php echo $totalAccrued; ?> Days</span>
                                        </div>
                                        </div>
                                      </div>
                                        <input type="text" name="leaveID" value ="<?php echo $leaveID; ?>" hidden >
                                        <input type="text" name="limit" hidden value="<?php echo $totalAccrued; ?>">

                                      
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      <!--END DATE-->

                                    <form autocomplete="off" id="updateLeaveReason" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Reason
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <textarea rows="3" type="text" name="reason" required class="form-control col-md-7 col-xs-12"  placeholder="Output Title" ><?php echo $reason; ?></textarea> 
                                        </div>
                                        </div>
                                      </div>
                                          <input type="text" name="leaveID" value ="<?php echo $leaveID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>

                                    <form autocomplete="off" id="updateLeaveMobile" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mobile Phone
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input type="text" name="mobile" required class="form-control col-md-7 col-xs-12" value="<?php echo $mobile; ?>" placeholder="Mobile" /> 
                                        </div>
                                        </div>
                                      </div>
                                          <input type="text" name="leaveID" value ="<?php echo $leaveID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      
                                      <!--DESCRIPTION-->
                                    <form  autocomplete="off" id="updateLeaveAddress" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                      
                                      
                                      <!--<div id ="resultfeedDes">SWER</div>-->
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address 
                                        </label><br>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <textarea class="form-control col-md-7 col-xs-12" required name="address" placeholder="Leave Address" rows="3"><?php echo $address;?></textarea>
                                          
                                        </div>
                                      </div>
                                          <input type="text" name="leaveID" value ="<?php echo $leaveID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      <!--DESCRIPTION-->
                              </div>                            
                             </div>  <!--END UPDATE Leave-->
                             <?php } ?> 
                          </div>
                        </div>    
                      </div>
                    </div>
                  </div><!-- End Tabs Content-->                        
                </div>
            </section>
            </div>
            <!-- end project-detail sidebar -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
        <!-- /page content -->

@include("app/includes/leave_operations")


 @endsection