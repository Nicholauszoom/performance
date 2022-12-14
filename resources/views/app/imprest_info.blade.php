@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php   
  foreach($imprest_details as $detail){        
  
    $imprestID = $detail->id;
    $description = $detail->description;
    $startDate = $detail->start;
    $applicant = $detail->empID;
    $endDate = $detail->end;   
    $title = $detail->title;
    $status = $detail->status;
    $application_date = $detail->application_date;
    $total_initial_cost = $detail->initial_cost;
    $total_final_cost = $detail->final_cost;
    
    $recommended_by = $detail->recommended_by;
    $date_recommended = $detail->date_recommended;

    $approved_by = $detail->approved_by;
    $date_approved = $detail->date_approved;
  }
  
  ?>
    <div class="card">
      <div class="card-header border-0">
          <h2 class="text-muted">Pending Payments <small>Need To Be Responded On</small></h2>
      </div>

      <div class="card-body">
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Imprest Info and Details</h3>
                <?php //echo session("note");  ?>
              </div>
            </div>            
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_content">
                              <!-- start project-detail sidebar -->
                    <div class="col-md-12 col-sm-3 col-xs-12">
                      <section class="panel">
                        <div class="panel-body">
                                  <!--Start Tabs Content-->
                            <div class="col-md-12 col-sm-6 col-xs-12">
                              <div class="x_panel">
                                <div class="x_title">
                                    <h3 class="green"><i class="fa fa-info-circle"></i> Info and Details</h3>
                                      @if(Session::has('note'))      {{ session('note') }}  @endif  
                                      <div id ="resultFeed"></div>
          
                                  <div class="clearfix"></div>
                                </div>
                                <div class="x_content">    
                                  <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
                             
                                    
                                      <li class="nav-item" role="presentation">
                                          <a href="#description" class="nav-item active show " data-bs-toggle="tab"
                                              aria-selected="false" role="tab" tabindex="-1">
                                              <i class="ph-at me-2"></i>
                                              Details
                                          </a>
                                      </li>
                      
                                      <?php if ($applicant == session('emp_id') && $status==0 || $status==6){ ?>
                                     
                                      <li class="nav-item" role="presentation">
                                        <a href="#updateImprest" class="nav-item" id="profile-tab2" data-bs-toggle="tab"
                                            aria-selected="false" role="tab" tabindex="-1">
                                            <i class="ph-at me-2"></i>
                                            &nbsp;&nbsp;<b>UPDATE IMPREST
                                        </a>
                                    </li>
                                      <?php } ?>
                                      <li class="nav-item" role="presentation">
                                        <a href="#requirement_tab" class="nav-item" id="profile-tab2" data-bs-toggle="tab"
                                            aria-selected="false" role="tab" tabindex="-1">
                                            <i class="ph-at me-2"></i>
                                            Requirement
                                        </a>
                                    </li>
                                    
                                      <?php 
                                      if($applicant == session('emp_id')){ 
                                      if ($status==0 || $status==6 ){ ?>
                                        <li class="nav-item" role="presentation">
                                          <a href="#add_new_requirement" class="nav-item" id="profile-tab2" data-bs-toggle="tab"
                                              aria-selected="false" role="tab" tabindex="-1">
                                              <i class="ph-at me-2"></i>
                                              ADD NEW REQUIREMENTS
                                          </a>
                                      </li>
                                     
                                      <?php } } ?>
                                  </ul>
                                    <div id="myTabContent" class="tab-content">
                                      <div role="tabpanel" class="tab-pane fade active show" id="description" aria-labelledby="home-tab">
                                        <p><b><font class="green">Title: </font></b><?php echo $title; ?></p>
                                        <p><b><font class="green">Description: </font></b><?php echo $description; ?></p>
                                        <p><b><font class="green">Requirement Cost: </font></b><?php echo $total_initial_cost; ?></p>
                                        <p><b><font class="green">Start Date: </font></b><?php echo date('d-m-Y', strtotime($startDate)); ?></p>
                                        <p><b><font class="green">End Date: </font></b><?php echo date('d-m-Y', strtotime($endDate)); ?></p>
                                        
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
          
          
                                        <?php if($status == 2){  ?>                              
          
                                        <?php } ?>                      
                                    </div> 
          
                                       <!--Update IMPREST-->
                                       <?php if ($status==0 || $status==6){ ?>
                                      <div role="tabpanel" class="tab-pane fade active" id="updateImprest" aria-labelledby="profile-tab">
                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                              <form autocomplete="off" id="update_imprestTitle" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">
                                                <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title
                                                  </label>
                                                  <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <div class="has-feedback">
                                                    <input type="text" name="title" required class="form-control col-md-7 col-xs-12" value ="<?php echo $title; ?>"  placeholder="Output Title" />
                                                  </div>
                                                  </div>
                                                </div>
                                                    <input type="text" name="imprestID" value ="<?php echo $imprestID; ?>" hidden >
                                                <div class="form-group">
                                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                  <button  class="btn btn-info">UPDATE</button> 
                                                  </div>
                                                </div> 
                                                </form>
                                                <!--Title-->
                                                
                                                <!--DESCRIPTION-->
                                              <form  autocomplete="off" id="update_imprestDescription" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                                
                                                
                                                <!--<div id ="resultfeedDes">SWER</div>-->
                                                <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description  
                                                  </label><br>
                                                  <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <textarea class="form-control col-md-7 col-xs-12" required name="description" placeholder="Description" rows="3"><?php echo $description;?></textarea>
                                                    
                                                  </div>
                                                </div>
                                                    <input type="text" name="imprestID" value ="<?php echo $imprestID; ?>" hidden >
                                                <div class="form-group">
                                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                  <button  class="btn btn-info">UPDATE</button> 
                                                  </div>
                                                </div> 
                                                </form>
                                                <!--DESCRIPTION-->
                                                
                                                <!--START DATE-->
                                              <form autocomplete="off" id="updateImprestDateRange" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                                <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start
                                                  </label>
                                                     <span class="text-info"><?php echo date('d-m-Y', strtotime($startDate)); ?></span> 
                                                  <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <div class="has-feedback">
                                                    <input type="text" name="start" class="form-control col-xs-12 has-feedback-left" id="imprest_startDate"  aria-describedby="inputSuccess2Status">
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
                                                    <input type="text" name="end" class="form-control col-xs-12 has-feedback-left" id="imprest_endDate"  aria-describedby="inputSuccess2Status">
                                                    <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                                  </div>
                                                  </div>
                                                </div>
                                                    <input type="text" name="imprestID" value ="<?php echo $imprestID; ?>" hidden >
                                                
                                                <div class="form-group">
                                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                  <button  class="btn btn-info">UPDATE</button> 
                                                  </div>
                                                </div> 
                                                </form>
                                                <!--END DATE-->
                                        </div>                            
                                       </div>  <!--END UPDATE IMPREST--> 
                                       <?php } ?>
          
          
          
                                       <!--Add requirement-->
                                       <?php 
                                        if($applicant == session('emp_id')){
                                        if ($status==0 || $status==6){ ?>
                                      <div role="tabpanel" class="tab-pane fade active" id="add_new_requirement" aria-labelledby="profile-tab">
                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                              <form autocomplete="off" id="addRequirement" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                          
                                                <!-- START -->
                                                <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
                                                  </label>
                                                  <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <textarea required="" id="textdescription" class="form-control col-md-7 col-xs-12" required name="description" placeholder="Description" rows="3"></textarea> 
                                                    <!-- <span class="text-danger"><?php// echo form_error("lname");?></span> -->
                                                  </div>
                                                </div>
                                                <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" >Initial Cost<span class="required">*</span>
                                                  </label>
                                                  <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <input required="" id="target" type="number" min="1" max="99999999999" step="1" name="initial_amount" placeholder= "Cost Amount" class="form-control col-md-7 col-xs-12">
                                                  </div>
                                                </div> <br>
                                                    <input type="number" value ="<?php echo $imprestID;  ?>" name="imprestID" hidden >        
                                                <div class="form-group">
                                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <input type="submit"  value="ADD" name="assign" class="btn btn-primary"/>
                                                  </div>
                                                </div> 
                                                </form>
                                        </div>                            
                                       </div>  <!--END Add Requirement--> 
                                       <?php } } ?>  
          
                                       <!-- Requirement Tab -->
                                       <div role="tabpanel" class="tab-pane fade" id="requirement_tab" aria-labelledby="profile-tab">
                                      <!-- START ASSIGNED TO OTHERs -->
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                      <div class="x_panel">
                                        <div class="x_title">
                                          <h2>Imprest Requirements &nbsp;&nbsp;&nbsp;<?php echo number_format($total_initial_cost, 2);?>/= 
                                          </h2>
                                          <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                      
                                        <?php
                      
                                           // echo session("note");  ?>
                                           <div id="resultFeedback"></div>
                                        
                                          <table id="" class="table table-striped table-bordered">
                                            <thead>
                                              <tr>
                                                <th>S/N</th>
                                                <th>Description</th> 
                                                <th>Initial Cost</th>
                                                <th>Final Cost</th>
                                                <th>Evidence</th>
                                                <th>Status</th>
                                                <?php if( session('mng_paym')){ ?>
                                                <th>Option</th>
                                                <?php } ?>
                                              </tr>
                                            </thead>            
                      
                                            <tbody>
                                              <?php
                                                foreach ($requirements as $row) { ?>
                                                <tr id="recordRequirement<?php echo $row->id;?>">
                                                  <td width="1px"><?php echo $row->SNo; ?></td>
                                                  
                                                  <td>  <?php echo $row->description; ?>  </td>
                                                  <td>  <?php echo number_format($row->initial_amount, 2); ?> 
                                                  </td>
                                                  <td>
                                                  <?php echo number_format($row->final_amount, 2); ?>
                                                  <?php if( $row->status==2 || $row->status==7){
                                                    if($applicant == session('emp_id')){ ?> 
                                                  <a title="Upload Evidence" class="icon-2 info-tooltip"><button type="button" id="modal" data-toggle="modal" data-target="#uploadEvidence<?php echo $row->id; ?>" class="btn btn-info btn-xs "> RETIREMENT</button> </a>
          
                                                  <!-- UPLOAD EVIDENCE MODAL (RETIREMENT)-->
                                                  <div class="modal fade" id="uploadEvidence<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">Update Requirement</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                            <!-- Modal Form -->
                                                            <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/imprest/uploadRequirementEvidence"  data-parsley-validate class="form-horizontal form-label-left">
          
                                                        
                                                            <div class="form-group">
                                                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Final Cost
                                                              </label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <input  required type="number" name="final_amount" value="<?php echo $row->final_amount; ?>" class="form-control col-md-7 col-xs-12">
                                                              </div>
                                                            </div>
          
                                                            <input type="text" name="requirementID" hidden="" value="<?php echo $row->id; ?>">
          
                                                            <input type="text" name="imprestID" hidden="" value="<?php echo $imprestID; ?>">
                                                            <div class="form-group">
                                                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Evidence
                                                              </label>
                                                              <div class="col-md-4 col-sm-6 col-xs-12">
                                                              <input type='file' name='userfile'  />
                                                              </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                                                <input type="submit"  value="CONFIRM" name="confirm" class="btn btn-primary"/>
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
                                                  <!-- UPLOAD EVIDENCE MODAL -->
          
                                                  <?php } } //} else { ?> 
                                                  <!-- <div class="col-md-12"><span class="label label-warning">WAITING FOR APPROVAL</span></div> -->
                                                  <?php //} ?>
          
                                                  </td> 
                                                  <td>
                                                  <?php if( $row->status==3) {
          
                                                  if($row->evidence!="0") { ?>
                                                  <a download= '' href ="<?php echo url('uploads/imprests/').$row->evidence; ?>"> <div class='col-md-12'>
                                                  <span class='label label-info'>DOWNLOAD</span></div></a> 
                                                  <?php } else { ?>
                                                  <div class="col-md-12"><span class="label label-warning">NO EVIDENCE</span></div>
                                                  <?php } if($applicant == session('emp_id')){ ?>
                                                  <a href="javascript:void(0)" onclick="deleteEvidence(<?php echo $row->id;?> )" title="Cancel Retirement" class="icon-2 info-tooltip">
                                                  <div class="col-md-12"><span class="label label-danger"><i class="fa fa-times"></i> CANCEL RETIREMENT</span>
                                                  </div> </a>
                                                  <?php } } else { ?>
                                                  <div class="col-md-12"><span class="label label-warning">NOT RETIRED</span></div>
                                                  <?php } ?>
          
                                                  </td>
                                                  <td>
                                                   <div id ="status<?php echo $row->id; ?>">
                                                    <?php if($row->status==0){ ?> <div class="col-md-12"><span class="label label-default">REQUESTED</span></div><?php } 
                                                    elseif($row->status==1){ ?><div class="col-md-12"><span class="label label-info">RECOMENDED</span></div><?php }
                                                    elseif($row->status==2){ ?><div class="col-md-12"><span class="label label-success">APPROVED</span></div><?php } 
                                                    elseif($row->status==3){ ?><div class="col-md-12"><span class="label label-warning">UNAPPROVED RETIREMENT</span></div><?php } 
                                                    elseif($row->status==4){ ?><div class="col-md-12"><span class="label label-success">CONFIRMED</span></div><?php } 
                                                    elseif($row->status==5){ ?><div class="col-md-12"><span class="label label-danger">UNCONFIRMED</span></div><?php }
                                                    ?></div>
                                                    
                                                    </td> 
                                                  <?php if(session('mng_paym')){ ?>
                                                  <td class="options-width">
                                                  <?php if($row->status==0 || $row->status==5){  
          
                                                    if($applicant == session('emp_id')){ ?>
                                                    <!-- NO Modifications allowed after approval, Recommend or  Confirmatiom -->
                                                      <a title="Update" class="icon-2 info-tooltip"><button type="button" id="modal" data-toggle="modal" data-target="#updateRequirementModal<?php echo $row->id; ?>" class="btn btn-info btn-xs"> <i class="fa fa-edit"></i></button>
                                                      </a>
                                                  
                                                    <!-- <a href="javascript:void(0)" onclick="deleteRequirement(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                                                       -->
                                                      <?php } } ?> 
                                                   <!-- APPROVAL -->
                                                  <?php 
                                                  if($status==0 || $status==1 || $status==6){
          
                                                    if( $status != 3 && session('mng_paym')){ 
          
                                                   if($row->status==0 || $row->status==1){ ?>
                                                   <!-- <a href="javascript:void(0)" onclick="deleteRequirement(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                                                     -->
                                                     <?php } if($row->status==0 || $row->status==5) { ?>
                                                  <a href="javascript:void(0)" onclick="approveRequirement(<?php echo $row->id;?>)"   title="Approve" class="icon-2 info-tooltip"><button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>
                                                  <?php } } } ?>
                                                  
                                                  <!-- CONFIRMATION -->
                                                  <?php if( session('mng_paym')){ 
                                                  if( $status == 2) { ?>
                                                  <?php if($row->status==1 || $row->status==6){ ?>        
                                                  <a href="javascript:void(0)" onclick="confirmRequirement(<?php echo $row->id;?>)"   title="Confirm" class="icon-2 info-tooltip"><button class="btn btn-info btn-xs"><i class="fa fa-check"></i></button> </a>
                                                  <?php }  if($row->status==1 || $row->status==2) { ?>
                                                  <a href="javascript:void(0)" onclick="unconfirmRequirement(<?php echo $row->id;?>)"   title="Unconfirm" class="icon-2 info-tooltip"><button class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> </a>
                                                  <?php } } 
          
                                                  //RETIREMENT CONFIRMATION
                                                  // if( $status == 4) {
                                                  if($row->status==3 || $row->status==8 || $row->status==7 ){ ?>
          
                                                  <a href="javascript:void(0)" onclick="confirmRequirementRetirement(<?php echo $row->id;?>)"   title="Unconfirm" class="icon-2 info-tooltip"><button class="btn btn-success btn-xs">CONFIRM RETIREMENT</button> </a>
          
                                                  <?php } //}
                                                   if($row->status==3 || $row->status== 2 ){ ?>
          
                                                  <!-- <a href="javascript:void(0)" onclick="unconfirmRequirementRetirement(<?php echo $row->id;?>)"   title="Unconfirm" class="icon-2 info-tooltip"><button class="btn btn-danger btn-xs">UNCONFIRM RETIREMENT</button> </a> -->
          
          
          
                                                  <?php } } 
                                                  // END  RETIREMENT CONFIRMATION
          
                                                  if($row->status==0 || $row->status==5){ ?>
                                                    <a href="javascript:void(0)" onclick="deleteRequirement(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                                                     
                                                <?php   // UPDATE REQUIREMENT
                                                    if($applicant == session('emp_id')){  ?>
                                                    <!-- NO Modifications allowed after approval, Recommend or  Confirmatiom -->
                    
                                            <!--update Modal -->
                                                  <div class="modal fade" id="updateRequirementModal<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">Update Requirement</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                            <!-- Modal Form -->
                                                            <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/imprest/update_imprestRequirement"  data-parsley-validate class="form-horizontal form-label-left">
          
                                                            <input type="text" name="imprestID" hidden="" value="<?php echo $imprestID;?>">
                                                            <input type="text" name="requirementID" hidden="" value="<?php echo $row->id; ?>">
                                                            
                                                            <div class="form-group">
                                                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Requirement Description
                                                              </label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <textarea maxlength="256" class="form-control col-md-7 col-xs-12" required name="description" placeholder="Description" rows="3"> <?php   echo $row->description; ?></textarea> 
                                                              </div>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Initial Cost
                                                              </label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <input required type="number" name="initial_amount" value="<?php echo $row->initial_amount; ?>" class="form-control col-md-7 col-xs-12">
                                                              </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <input type="submit"  value="UPDATE" name="update" class="btn btn-primary"/>
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
                                                  <!-- Update Modal-->            
                                                    <!--ACTIONS-->
                                                    <?php } } ?>
          
                                                    </td>
                                                    <?php } ?>
                                                  </tr>
                                                <?php }  ?>
                                            </tbody>
                                          </table>
                                        </div>
                                      </div>
                                    </div> 
                                  </div> <!-- END Requirement Tab -->   
          
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
      </div>
    </div>

        <!-- page content -->
<!-- page content -->

        <!-- /page content -->

@include("app/includes/imprest_operations")


 @endsection