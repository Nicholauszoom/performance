@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php   
  foreach($output as $detail){
      
  
  $description = $detail->description;
  $startDate = $detail->start;
  $endDate = $detail->end; 
  $title = $detail->title; 
  $outputID = $detail->id;  
  $outcomeID = $detail->outcome_ref; 
  $strategyID = $detail->strategy_ref;  
  $assignedTo = $detail->assigned_to;
  $nameAssignedTo = $detail->NAME;
  $OUTCOME_REF = $detail->OUTCOME_REF; 
    
    
  } 
  if($outputResourceCost>0) $resource_cost = number_format($outputResourceCost, 2); else $resource_cost = 0;
  
  foreach($outputCost as $summary){
  $COST = $summary->outputCost;
  $TASKCOUNT = $summary->taskCount; 
  }
  
  
  
   
  
  foreach($outcomeDateRange as $row){
  
  $startLimit = $row->start;
  $endLimit = $row->end; 
  } 
  ?>


        <!-- page content -->
         <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Output  Detail</h3>
                @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-head">
                    <h2><?php echo $title;?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="card-body">

                    <div class="col-md-12 col-sm-9 col-xs-12">

                      <ul class="stats-overview">
                        <li>
                          <span class="name"> Number of Tasks Within </span>
                          <span class="value text-success"> <?php echo $TASKCOUNT; ?> </span>
                        </li>
                        <li>
                          <span class="name"> Time Cost </span>
                          <span class="value text-success"> <?php echo number_format($COST,2); ?></span>
                        </li>
                        <li class="hidden-phone">
                          <span class="name"> Resource Cost </span>
                          <span class="value text-success"> <?php echo $resource_cost; ?> </span>
                        </li>
                      </ul>

                      <ul class="stats-overview">
                        <li>
                          <span class="name"> Completed Task </span>
                          <span class="value text-success"> <?php echo $completeTask; ?> </span>
                        </li>
                        <li>
                          <span class="name"> In Progress Tasks </span>
                          <span class="value text-success"> <?php echo  $progressTask; ?> </span>
                        </li>
                        <li class="hidden-phone">
                          <span class="name"> Not Yet Started </span>
                          <span class="value text-success"> <?php echo $notStartedTask; ?> </span>
                        </li>
                      </ul>
                      <br />

                      <!--<div id="mainbTest" style="height:350px;"></div>-->

                    </div>

                    <!-- start project-detail sidebar -->
                    <div class="col-md-12 col-sm-3 col-xs-12">

                      <section class="panel">

                        <div class="card-head">
                          <h2 class="green">Project Description</h2>
                          
                          <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            
                            
                          
                          <!--Start Tabs Content-->
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="card">
                      <div class="card-head">
                          <h3 class="green"><i class="fa fa-info-circle"></i> Info and Details</h3>
                            @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                            <div id ="resultfeedDes"></div>

                        <div class="clearfix"></div>
                      </div>
                      <div class="card-body">
    
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#description" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Description</a>
                            </li>
                            <li role="presentation" class=""><a href="#outputs" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Tasks</a>
                            </li>
                            <li role="presentation" class=""><a href="#updateOutput" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><font class = "text-info"><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>UPDATE OUTPUT</b></font></a>
                            </li>
                            <li role="presentation" class=""><a href="#addTask" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><font color = "blue"><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>ADD NEW TASK</b></font></a>
                            </li>
                            <!--<li role="presentation" class=""><a href="#assignTo" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><font color = "blue"><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>ASSIGN TO</b></font></a>-->
                            <!--</li>-->
                          </ul>
                          <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="description" aria-labelledby="home-tab">
                              <p><b><font class="green">Output Name: </font></b><?php echo $title; ?></p>
                              <p><b><font class="green">Description: </font></b><?php echo $description; ?></p>
                              <p><b><font class="green">Outcome Reference</font>: </font></b><?php echo $OUTCOME_REF ; ?></p>
                              <p><b><font class="green">Start Date: </font></b><?php echo date('d-m-Y', strtotime($startDate)); ?></p>
                              <p><b><font class="green">End Date: </font></b><?php echo date('d-m-Y', strtotime($endDate)); ?></p>
                              <p><b><font class="green">Assigned To: </font></b><?php echo $nameAssignedTo; ?></p>                            
                          </div>
                            
                            <div role="tabpanel" class="tab-pane fade active" id="addTask" aria-labelledby="profile-tab">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <!--<div class="card">-->
                                <!--  <div class="card-body">-->
                                    <form autocomplete="off" id="createNewTask" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                
                                      <!-- START -->
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Task Name
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <textarea required="" id="title" class="form-control col-md-7 col-xs-12" required name="title" placeholder="Title" rows="2"></textarea> 
                                          <!-- <span class="text-danger"><?php// echo form_error("lname");?></span> -->
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <textarea required="" id="textdescription" class="form-control col-md-7 col-xs-12" required name="description" placeholder="Description" rows="3"></textarea> 
                                          <!-- <span class="text-danger"><?php// echo form_error("lname");?></span> -->
                                        </div>
                                      </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Target Type</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Financial Target 
                                              <input type="radio" checked name="quantity_type" value="1">
                                              <span class="checkmark"></span>
                                            </label>
                                            
                                            <label class="containercheckbox">Numerical Target 
                                              <input type="radio" name="quantity_type" value="2">
                                              <span class="checkmark"></span>
                                            </label>
                                            </div>
                                        </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Target<span class="required">*</span>
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <input required="" id="target" type="number" min="1" max="99999999999" step="1" name="quantity" placeholder= "Amount or Quantity" class="form-control col-md-7 col-xs-12">
                                        </div>
                                      </div>
                                          <input type="number" value ="<?php echo $strategyID;  ?>" name="strategyID" hidden >
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Time Cost<span class="required">*</span>
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <input required="" type="number" id="timecost" required="" min="0" max="100000000" step="1" placeholder="Cost" name="monetary_value" required class="form-control col-md-7 col-xs-12">
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" placeholder="Start Date"  type="text" name="start" class="form-control col-xs-12 has-feedback-left" id="task_startDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div> 
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" placeholder="End Date" type="text" name="end" class="form-control col-xs-12 has-feedback-left" id="task_endDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div>                                     
                                      
                                      <div class="form-group">
                                            <label class="control-label col-md-3 col-md-3  col-xs-6" >Assign To</label>
                                            
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                            <select id="employee"  name="employee" class="select4_single form-control" tabindex="-1">
                                            <option></option>
                                               <?php
                                              foreach ($employee as $row) {
                                                 # code... ?>
                                              <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                                            </select>
                                            </div>
                                      </div>
                                          <input type="text" name="outputID" value ="<?php echo $outputID; ?>" hidden >
                                          <div id = "refreshKey"><input type="text" name="outcomeID" value ="<?php echo $outcomeID; ?>" hidden ></div>
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          <input type="submit"  value="ADD" name="assign" class="btn btn-main"/>
                                        </div>
                                      </div> 
                                      </form>
                
                                <!--  </div>-->
                                <!--</div>-->
                              </div>                            
                             </div>  <!--END ADD TASK-->
                             
                             
                             <!--Update OUPUT-->
                            <div role="tabpanel" class="tab-pane fade active" id="updateOutput" aria-labelledby="profile-tab">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <!--<div class="card">-->
                                <!--  <div class="card-body">-->
                                      <!-- Title -->
                                    <form autocomplete="off" id="update_outputTitle" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Output Name
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" type="text" name="title" class="form-control col-md-7 col-xs-12" value ="<?php echo $title; ?>"  placeholder="Output Title" />
                                        </div>
                                        </div>
                                      </div>
                                          <input type="text" name="outputID" value ="<?php echo $outputID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      <!--Title-->
                                      
                                      <!--DESCRIPTION-->
                                    <form autocomplete="off" id="update_outputDes" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                      
                                      
                                      <!--<div id ="resultfeedDes">SWER</div>-->
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description  
                                        </label><br>
                                           <!--<span id ="resultfeedDes" class="text-success"></span> -->
                                        <!--<div id ="resultfeedDes"></div>-->
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <textarea required="" class="form-control col-md-7 col-xs-12" name="description" placeholder="Description" rows="3"><?php echo $description;?></textarea>
                                          
                                        </div>
                                      </div>
                                          <input type="text" name="outputID" value ="<?php echo $outputID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      <!--DESCRIPTION-->

                                      <form autocomplete="off" id="outputAdvancedAssign"  enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                        <div class="form-group">
                                          <label class="control-label col-md-3  col-xs-6" >Assign or Re Assign To</label>
                                          <span class="text-info"><b><font class="value text-success"><?php echo $nameAssignedTo; ?></font></b></span> 
                                          <div class="col-md-4 col-sm-6 col-xs-12">
                                          <select name="employeeID" required="" class="select4_single form-control" tabindex="-1">
                                          <option></option>
                                             <?php
                                            foreach ($employee as $row) {
                                               # code... ?>
                                            <option <?php if($row->empID==$assignedTo){ ?>  selected <?php } ?> value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                                          </select>
                                          </div>
                                        </div> 
                                        <!-- END -->
                                        
                                        <input type="text" name="outputID" value = "<?php echo $outputID; ?>" hidden >
                  
                                        <div class="form-group">
                                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <input type="submit"  value="ASSIGN" name="assign" class="btn btn-info"/>
                                          </div>
                                        </div>
                                       </form>
                                       
                                        <!--OUTCOME REFERENCE-->
                                      <form autocomplete="off" id="outputAdvancedOutcomeRef" enctype="multipart/form-data"  method="post"  data-parsley-validate class="form-horizontal form-label-left">
                                        <div class="form-group">
                                          <label class="control-label col-md-3  col-xs-6" >Outcome For This Output</label>
                                          <span class="text-info"><b><font class="value text-success"><?php echo $OUTCOME_REF; ?></font></b></span> 
                                          <div class="col-md-4 col-sm-6 col-xs-12">
                                          <select name="outcomeKEY" required="" class="select6_single form-control" tabindex="-1">
                                          <option></option>
                                             <?php
                                            foreach ($outcome as $row) {
                                               # code... ?>
                                            <option <?php if($row->id==$outcomeID){ ?>  selected <?php } ?> value="<?php echo $row->id; ?>"><?php echo $row->title; ?></option> <?php } ?>
                                          </select>
                                          </div>
                                        </div> 
                                        <input type="text" name="outputID" value = "<?php echo $outputID; ?>" hidden >
                                        <div class="form-group">
                                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <input type="submit"  value="UPDATE" name="updateOutcomeRef" class="btn btn-info"/>
                                          </div>
                                        </div> 
                                        </form>
                                      
                                      <!--START DATE-->
                                    <form autocomplete="off" id="updateOutputDateRange" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" placeholder="Start Date"  type="text" name="start" class="form-control col-xs-12 has-feedback-left" id="output_startDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" placeholder="End Date"  type="text" name="end" class="form-control col-xs-12 has-feedback-left" id="output_endDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div>
                                          <input type="text" name="outputID" value ="<?php echo $outputID; ?>" hidden >
                                      
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      <!--END DATE-->
                
                                <!--  </div>-->
                                <!--</div>-->
                              </div>                            
                             </div>  <!--END UPDATE OUTPUT-->
                             
                            <div role="tabpanel" class="tab-pane fade" id="outputs" aria-labelledby="profile-tab">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                  <div class="card-body">
                
                
                                     <!--@if(Session::has('note'))      {{ session('note') }}  @endif  ?>-->
                                  
                                    <table id="datatable" class="table table-striped table-bordered">
                                      <thead>
                                        <tr>
                                          <th>S/N</th>
                                          <th>Task Name</th> 
                                          <th>Assigned To</th>
                                          <th>Duration</th>
                                          <th><b>Progress</b></th>
                                          <th><b>Option</b></th>
                                          <th>Remarks</th>
                                        </tr>
                                      </thead>
                
                
                                      <tbody>
                                        <?php
                                          foreach ($tasks as $row) { ?>
                                          <tr id="recordTask<?php echo $row->id;?>">
                                            <td width="1px"><?php echo $row->SNo; ?></td>
                                            <td><p><b>Name: &nbsp;</b><?php echo $row->title; ?></p>

                                            <button type="button" class="btn btn-main btn-xs" data-toggle="modal" data-target=".bs-example-modal-lg<?php echo $row->SNo; ?>">More Description</button>

                                            <div class="modal fade bs-example-modal-lg<?php echo $row->SNo; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                              <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">Task Description</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                    <h4><b>Name: &nbsp;</b><?php echo $row->title; ?></h4>
                                                    <p><?php echo $row->description; ?></p>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                  </div>

                                                </div>
                                              </div>
                                            </div>                                            

                                            <td><?php  if($row->isAssigned == 0){ ?> 
                                              <div class="col-md-12">
                                                  <span class="label label-warning"><b>Not Assigned</b></span></div>
                                              <?php  }  else { echo $row->NAME; 
                                              
                                              if($row->status==1){ ?> 
                                              <div class="col-md-12">
                                                  <span class="label label-primary"><b>Submitted</b></span></div>
                                              <?php  } else if($row->status==2) { ?>
                                              <div class="col-md-12">
                                                  <span class="label label-success"><b>Approved</b></span></div>
                                              <?php } else if($row->status==3) { ?>
                                              <div class="col-md-12">
                                                  <span class="label label-warning"><b>Cancelled</b></span></div>
                                              <?php } else if($row->status==5) { ?>
                                              <div class="col-md-12">
                                                  <span class="label label-danger"><b>Dissapproved</b></span></div>
                                              
                                              <?php }  } ?> 
                                            </td>
                
                
                                            <td>
                                            <?php
                                            $date1=date_create($row->start);
                                            $date2=date_create($row->end);
                                            $diff=date_diff($date1,$date2);
                                            echo 1+$diff->format("%a")." Days";

                                            $dates = date('d-m-Y', strtotime($row->start));
                                            $datee = date('d-m-Y', strtotime($row->end));
                                            
                                            echo "<br>From <b>".$dates."</b> To <b>".$datee."</b>"; ?>
                                            </td>                                            
                                                                                 
                                            <td>
                                                <ul class="list-inline prod_color">
                                                  <li>
                                                      <?php 
                                                      $progress = $row->progress;
                                                      
                                                      $todayDate=date('Y-m-d');
                                                      $endd=$row->end;
                                                        
                                                      
                                            if($todayDate>$endd) {
                                
                                                if($row->status==2){ ?>
                                                    <p><b>Completed</b></p>
                                                        <div class="color bg-green"></div> 
                                                        <?php } else{ ?>
                                                        <p><b>Overdue(<?php echo $progress; ?>%)</b></p>
                                                        <div class="color bg-red"></div> <?php } 
                                                } else { 
                                                    if($row->status==2){ ?>
                                                    <p><b>Completed</b></p>
                                                        <div class="color bg-green"></div> 
                                                        <?php } else {
                                                          if($progress==0){ ?>
                                                    <p><b>Not Started</b></p>
                                                        <div class="color bg-orange"></div>
                                                        <?php } elseif($progress>0) { ?>
                                                    <p><b>
                                                        In Progress (<?php echo $progress; ?>%) </b></p>
                                                        <div class="color bg-blue-sky"></div>
                                                    <?php }  } }  ?> 
                                                    </li>
                                                </ul>
                                            </td>
                                            <td class="options-width">
                                                <?php if($row->output_ref==0) {?>
                                                <a href="<?php echo  url('')."flex/performance/task_info".base64_encode($row->id."|".$row->output_ref); ?>"   title="Outcome Info and Details" class="icon-2 info-tooltip"><button  class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i> | <i class="fa fa-edit"></i></button> </a>
                                                <?php } else { ?>
                                                <a href="<?php echo  url('')."flex/performance/task_info".base64_encode($row->id."|".$row->output_ref); ?>"    title="Outcome Info and Details" class="icon-2 info-tooltip"><button  class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i> | <i class="fa fa-edit"></i></button> </a>
                                                <?php }  ?>

                                                <!--ACTIONS-->

                                          <!-- Line Manager WHO  ASSIGNED The Task -->
                                          <?php 
                                            if($row->status==1){ ?>
                                            <button type="submit" name="notdone" class="btn btn-warning btn-xs">Disapprove</button>
                
                                            <a href="<?php echo  url('')."/flex/performance/task_approval".$row->id; ?>"><button type="button" name="go" class="btn btn-success btn-xs">Approve</button></a>
                
                
                                            <?php } if($row->status==0){ ?>
                                                <!--<button type="submit" name="cancel" class="btn btn-warning btn-xs"><i class="fa fa-times"></i></button>-->
                                            <br><a href="javascript:void(0)" onclick="cancelTask(<?php echo $row->id;?>)"   title="Cancel" class="icon-2 info-tooltip"><button class="btn btn-warning btn-xs"><i class="fa fa-times"></i></button> </a>
                                          <?php } ?>
                                            <!--</form>-->
                                            
                                            <a href="javascript:void(0)" onclick="deleteTask(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button class="btn btn-danger btn-xs"><i class="ph-trash-o"></i></button> </a>
                
                                                <!--ACTIONS-->
                                                </td>
                
                                            <td><a href="<?php echo  url('')."flex/performance/comment".$row->id; ?>"><button type="submit" name="go" class="btn btn-main btn-xs">Progress<br>and<br>Comments</button></a>

                                            
                                            
                                            </td>
                                            </tr>
                                          <?php }  ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div> <!-- class="col-md-12 col-sm-12 col-xs-12" -->
                            </div>
                            <!--</div>-->
                            
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
        <!-- /page content -->
        
        
    





<?php 

// @include("app/includes/projectchart")

@include("app/includes/unrefresh_form_submit");

 ?>



<script>
$(function() {
  var minStartDate = "<?php if(isset($startDate)){echo date('d/m/Y', strtotime($startDate));} ?>";
  var maxEndDate = "<?php if(isset($endDate)){echo date('d/m/Y', strtotime($endDate));} ?>";
  $('#task_startDate').daterangepicker({
    drops: 'up',
    singleDatePicker: true,
    autoUpdateInput: false,
    startDate: "<?php if(isset($startDate)){echo date('d/m/Y', strtotime($startDate));} ?>",
    minDate:minStartDate,
    maxDate:maxEndDate,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#task_startDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#task_startDate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>

<script>
$(function() {
  var minStartDate = "<?php if(isset($startDate)){echo date('d/m/Y', strtotime($startDate));} ?>";
  var maxEndDate = "<?php if(isset($endDate)){echo date('d/m/Y', strtotime($endDate));} ?>";
  $('#task_endDate').daterangepicker({
    drops: 'up',
    singleDatePicker: true,
    autoUpdateInput: false,
    startDate: "<?php if(isset($startDate)){echo date('d/m/Y', strtotime($startDate));} ?>",
    minDate:minStartDate,
    maxDate:maxEndDate,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#task_endDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#task_endDate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>

<script>
$(function() {
  var minStartDate = "<?php echo date('d/m/Y', strtotime($startLimit)); ?>";
  var maxEndDate = "<?php echo date('d/m/Y', strtotime($endLimit)); ?>";
  $('#output_startDate').daterangepicker({
    drops: 'up',
    singleDatePicker: true,
    autoUpdateInput: false,
    startDate: "<?php if(isset($startDate)){echo date('d/m/Y', strtotime($startDate));} ?>",
    minDate:minStartDate,
    maxDate:maxEndDate,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#output_startDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#output_startDate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>

<script>
$(function() {
  var minStartDate = "<?php echo date('d/m/Y', strtotime($startLimit)); ?>";
  var maxEndDate = "<?php echo date('d/m/Y', strtotime($endLimit)); ?>";
  $('#output_endDate').daterangepicker({
    drops: 'up',
    singleDatePicker: true,
    autoUpdateInput: false,
    startDate: "<?php if(isset($endDate)){echo date('d/m/Y', strtotime($endDate));} ?>",
    minDate:minStartDate,
    maxDate:maxEndDate,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#output_endDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#output_endDate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>
 @endsection