@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section

<?php   
  foreach($task_details as $detail){
      
  
  $description = $detail->description;
  $startDate = $detail->start;
  $endDate = $detail->end;  
  $isAssigned = $detail->isAssigned;  
  $title = $detail->title;
  $qty_type = $detail->quantity_type;
  $referenceOutputID = $detail->output_ref; 
  
  if($referenceOutputID !=0){
  $outputID = $detail->outpID; 
  $outputTitle = $detail->outpTitle;
  $startLimit = $detail->outpStart;
  $endLimit = $detail->outpEnd;

  } else {
      $outputTitle = "AD-HOC TASK";
  }
  
  $assignedTo = $detail->empName;
  $assignedBy = $detail->lineName;
  $status = $detail->status;
  $initial_quantity = $detail->initial_quantity;
  $submitted_quantity = $detail->submitted_quantity;
  $date_assigned = $detail->date_assigned; 
  $monetary_value = $detail->monetaryValue;  
  $isAssigned = $detail->isAssigned;  
  $remarks = $detail->remarks;
  $date_completed = $detail->date_completed;
  $date_marked = $detail->date_marked;
  $taskID = $detail->id;
  $quantity = $detail->quantity;
  $behaviour = $detail->quality;
  $qb_ratio = $detail->qb_ratio;

  $splitt = explode(":", $qb_ratio);
  $percent_quantity = $splitt[0];
  $percent_behaviour = $splitt[1];
  }


  
  $startd=date_create($startDate);
  $endd=date_create($endDate);
  $diff=date_diff( $endd, $startd);
  $duration = $diff->format("%a");


  
  $targetFinish=date_create($endDate);
  $actualFinish=date_create($date_completed);
  $timeTargetDiff=date_diff($actualFinish,$targetFinish);
  $timeTargetDuration = $timeTargetDiff->format("%R%a");
  if ($duration<=0)  $delayPercent=0; else {
  $delayPercent = ($timeTargetDuration/$duration)*100; }
  if($delayPercent>=0){
    $tag = "Early Submission";
  } else {$tag = "Late Submission"; }

  $totalResources = $totalResourceCost;

  
  
  
  ?>


        <!-- page content -->
<!-- page content -->
<div class="right_col" role="main">
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Task Info and Details</h3>
      <?php //echo $this->session->flashdata("note");  ?>
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
                            @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                            <div id ="resultfeedDes"></div>

                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">    
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#description" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">DESCRIPTIONS</a>
                            </li>
                            </li>                            
                            <?php if($status!=2){ ?>
                            <li role="presentation" class=""><a href="#updateOutput" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><font class = "text-info"><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>UPDATE TASK</b></font></a>
                            </li>
                            <?php } if($status==2) { ?>
                            <li role="presentation" class=""><a href="#resource_tab" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><font class = "text-info">&nbsp;&nbsp;<b>TASK RESOURCES</b></font></a>
                            </li>
                            <?php } ?>
                          </ul>
                          <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="description" aria-labelledby="home-tab">
                              <p><b><font class="green">Task Name: </font></b><?php echo $title; ?></p>
                              <p><b><font class="green">Description: </font></b><?php echo $description; ?></p>                              
                              <p><b><font class="green">Type: </font> <?php if($qty_type==1) { echo "FINANCIAL"; } else { echo "NUMERICAL";} ?> </b></p> 
                              <p><b><font class="green">Target: </font></b><?php echo $initial_quantity; ?></p>
                              <p><b><font class="green">Output Reference</font>: </font></b><?php echo $outputTitle; ?></p>
                              <p><b><font class="green">Start Date: </font></b><?php echo date('d-m-Y', strtotime($startDate)); ?></p>
                              <p><b><font class="green">End Date: </font></b><?php echo date('d-m-Y', strtotime($endDate)); ?></p>
                              <p><b><font class="green">Assigned To: </font></b><?php if($isAssigned == 0) echo "NOT ASSIGNED"; else  echo $assignedTo; ?></p> 
                              <?php if($isAssigned != 0){ ?><p><b><font class="green">Assigned By: </font></b><?php echo $assignedBy; ?></p> <?php } ?> 
                              <p><b><font class="green">Status: </font></b><?php if ($status==0){ ?>
                                <div class="col-md-12">
                                <span class="label label-default">On Progress</span></div><?php } 
                                elseif($status==1){?>
                                <div class="col-md-12">
                                <span class="label label-info">Submitted</span></div><?php }
                                elseif($status==2){?>
                                <div class="col-md-12">
                                <span class="label label-success">Approved</span></div><br><br>
                                <table id="" class="table table-striped table-bordered">
                                <caption>Evaluations</caption>
                                  <thead>
                                    <tr>
                                      <th>S/N</th>
                                      <th>Name</th> 
                                      <th>Target</th> 
                                      <th>Submitted</th>
                                      <th>%</th>
                                    </tr>
                                  </thead>           
            
                                  <tbody>
                                    <tr>
                                      <td>1</td>
                                      <td><?php if($qty_type==1){ echo "Amount"; }else { echo "Quantity"; } ?></td>
                                      <td><?php if($qty_type==1){ echo number_format($initial_quantity, 2); }else { echo $initial_quantity; } ?></td>
                                      <td><?php if($qty_type==1){ echo number_format($submitted_quantity, 2); }else { echo $submitted_quantity; } ?></td>
                                      <td><?php $target = ($submitted_quantity/$initial_quantity)*100;
                                      echo number_format($target, 1); ?>%</td>
                                    </tr>
                                    <tr>
                                      <td>2</td>
                                      <td>Due Date</td>
                                      <td><?php echo date('d-m-Y', strtotime($endDate)); ?></td>
                                      <td><?php echo date('d-m-Y', strtotime($date_completed)); ?></td>
                                      <td> <?php echo number_format($delayPercent,2); ?>% <br>
                                      <?php echo $timeTargetDuration." Days Extra ".$tag; ?> </td>
                                    </tr>
                                  </tbody>
                                </table>

                                <?php }
                                elseif($status==3){?>
                                <div class="col-md-12">
                                <span class="label label-warning">Canceled</span></div><?php }elseif($status==5){?>
                                <div class="col-md-12">
                                <span class="label label-warning">Disapproved</span></div><?php }
                                elseif ($status==4) { ?>
                                <div class="col-md-12">
                                <span class="label label-danger">Overdue</span></div> <?php } ?> <br></p>




                              <?php if($status == 2){  ?>

                              <p><b><font class="green">Date Submitted: </font></b><?php echo date('d-m-Y', strtotime($date_completed)); ?></p>
                              <p><b><font class="green">Date Marked: </font></b><?php echo date('d-m-Y', strtotime($date_marked)); ?></p>

                              <p><b><font class="green">Quantity Performance(WHAT): </font></b><?php echo number_format($quantity, 2)."% out of ".number_format($percent_quantity, 2); ?>% </p>
                              <p><b><font class="green">Behavioural Performance(HOW):  </font></b><?php echo number_format($behaviour, 2)."% out of ".number_format($percent_behaviour, 2); ?>% </p>

                              <p><b><font class="green">Overall Performance: </font></b><?php echo number_format($quantity, 2)+number_format($behaviour, 2); ?> out of 100%</p>

                              <?php } ?>




                              <p><b><font class="green">Time Cost: </font></b><?php echo number_format($monetary_value, 2); ?>/= Tsh</p>  
                              <p><b><font class="green">Remarks or Additional Recommendations: </font></b><?php echo $remarks; ?></p>                        
                          </div> 

                             <?php if($status!=2){ ?>
                             <!--Update OUPUT-->
                            <div role="tabpanel" class="tab-pane fade active" id="updateOutput" aria-labelledby="profile-tab">
                              <div class="col-md-12 col-sm-6 col-xs-12">
                                    <form id="update_taskTitle" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Task Name
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input type="text" name="title" required class="form-control col-md-7 col-xs-12" value ="<?php echo $title; ?>"  placeholder="Output Name" />
                                        </div>
                                        </div>
                                      </div>
                                          <input type="text" name="attribute" value ="title" hidden >
                                          <input type="text" name="taskID" value ="<?php echo $taskID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      <!--Title-->
                                      
                                      <!--DESCRIPTION-->
                                    <form id="update_taskDes" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                      
                                      
                                      <!--<div id ="resultfeedDes">SWER</div>-->
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description  
                                        </label><br>
                                           <!--<span id ="resultfeedDes" class="text-success"></span> -->
                                        <!--<div id ="resultfeedDes"></div>-->
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <textarea class="form-control col-md-7 col-xs-12" required name="description" placeholder="Description" rows="3"><?php echo $description;?></textarea>
                                          
                                        </div>
                                      </div>
                                          <input type="text" name="taskID" value ="<?php echo $taskID; ?>" hidden >
                                          <input type="text" name="attribute" value ="description" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      <!--DESCRIPTION-->


                      <form id="update_taskAssignedTo"  enctype="multipart/form-data"  method="post"  data-parsley-validate class="form-horizontal form-label-left">
                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >Re Assign To</label>
                            <span class="text-info"><b><font class="value text-success"><?php if($isAssigned == 0) echo "NOT ASSIGNED"; else echo $assignedTo; ?></font></b></span> 
                            <div class="col-md-4 col-sm-6 col-xs-12">
                            <select name="employeeID" required="" class="select4_single form-control" tabindex="-1">
                            <option></option>
                               <?php
                              foreach ($employee as $row) {
                                 # code... ?>
                              <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                            </select>
                            </div>
                          </div> 
                          <!-- END -->
                          
                          <input type="text" name="taskID" value = "<?php echo $taskID; ?>" hidden >
    
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button  class="btn btn-info">UPDATE</button>
                            </div>
                          </div>
                         </form>
                         
                         <?php if($referenceOutputID!=0){ ?>

                          <!--OUTPUT REFERENCE-->
                        <form id="update_taskOutputReference" enctype="multipart/form-data"  method="post"  data-parsley-validate class="form-horizontal form-label-left">
                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >OutPut For This Task</label>
                            <span class="text-info"><b><font class="value text-success"><?php echo $outputTitle; ?></font></b></span> 
                            <div class="col-md-4 col-sm-6 col-xs-12">
                            <select name="outputID" required="" class="select6_single form-control" tabindex="-1">
                            <option></option>
                               <?php
                              foreach ($output as $row) {
                                 # code... ?>
                              <option value="<?php echo $row->id; ?>|<?php echo $row->outcome_ref; ?>"><?php echo $row->title; ?></option> <?php } ?>
                            </select>
                            </div>
                          </div> 
                          <input type="text" name="taskID" value = "<?php echo $taskID; ?>" hidden >
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button  class="btn btn-info">UPDATE</button>
                            </div>
                          </div> 
                          </form>
                          <!--OUTCOME REFERENCE-->
                          <?php } ?>
                                      
                                      <!--Cost Value-->
                                      <form id="update_taskCost" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Time Cost
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input type="number" min="1" max="100000000" step = "1" name="cost" required class="form-control col-md-7 col-xs-12" value ="<?php echo $monetary_value; ?>"  placeholder="Output Name" />
                                        </div>
                                        </div>
                                      </div>
                                          <input type="text" name="attribute" value ="title" hidden >
                                          <input type="text" name="taskID" value ="<?php echo $taskID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      <!--Monetary Value-->
                                      
                                      <!--START DATE-->
                                    <form id="updateTaskDateRange" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start
                                        </label>
                                           <span class="text-info"><?php echo date('d-m-Y', strtotime($startDate)); ?></span> 
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input type="text" name="start" class="form-control col-xs-12 has-feedback-left" id="task_startDate"  aria-describedby="inputSuccess2Status">
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
                                          <input type="text" name="end" class="form-control col-xs-12 has-feedback-left" id="task_endDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div>
                                          <input type="text" name="attribute" value ="endDate" hidden >
                                          <input type="text" name="taskID" value ="<?php echo $taskID; ?>" hidden >
                                      
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      <!--END DATE-->
                              </div>                            
                             </div>  <!--END UPDATE OUTPUT-->    
                             <?php } ?> 
                             <div role="tabpanel" class="tab-pane fade" id="resource_tab" aria-labelledby="profile-tab">
                            <!-- START ASSIGNED TO OTHERs -->
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Task Resources &nbsp;&nbsp;&nbsp;<?php echo number_format($totalResources, 2);?>/=          
                                <!-- <a href="javascript:void(0)" onclick="commitTask(<?php echo $taskID;?>)" ><button class="btn btn-info">COMMIT TASK</button> </a> -->
                                </h2>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
            
                              <?php
            
                                 echo $this->session->flashdata("note");  ?>
                                 <div id="resultFeedback"></div>
                              
                                <table id="" class="table table-striped table-bordered">
                                  <thead>
                                    <tr>
                                      <th>S/N</th>
                                      <th>Name</th> 
                                      <th>Cost</th>
                                      <th>Option</th>
                                    </tr>
                                  </thead>
            
            
                                  <tbody>
                                    <?php
                                      foreach ($resource as $row) { ?>
                                      <tr id="recordResource<?php echo $row->id;?>">
                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                        
                                        <td>  <?php   echo $row->name; ?>  </td>
                                        <td>  <?php   echo number_format($row->cost, 2); ?>  </td>
                                        
                                        <td class="options-width">
                                            <a title="Update" class="icon-2 info-tooltip"><button type="button" id="modal" data-toggle="modal" data-target="#resourceModal<?php echo $row->id; ?>" class="btn btn-info "> <i class="fa fa-edit"></i></button> </a>
                                        
                                        <a href="javascript:void(0)" onclick="deleteResource(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button class="btn btn-danger"><i class="fa fa-trash-o"></i></button> </a>


          
                                  <!--update Modal -->
                                        <div class="modal fade" id="resourceModal<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                      <h4 class="modal-title" id="myModalLabel">Add New Strategy</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                  <!-- Modal Form -->
                                                  <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/performance/update_taskResource"  data-parsley-validate class="form-horizontal form-label-left">

                                                  <input type="text" name="taskID" hidden="" value="<?php echo $taskID;?>">
                                                  <input type="text" name="resourceID" hidden="" value="<?php echo $row->id; ?>">
                                                  <input type="text" name="outputID" hidden="" value="<?php echo $outputID;?>">
                                                  
                                                  <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Resource Name
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <textarea maxlength="256" class="form-control col-md-7 col-xs-12" required name="description" placeholder="Description" rows="3"> <?php   echo $row->name; ?></textarea> 
                                                    </div>
                                                  </div>
                                              
                                                  <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Cost
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <input required type="number" name="cost" value="<?php echo $row->cost; ?>" class="form-control col-md-7 col-xs-12">
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
                                            </td>
                                        </tr>
                                      <?php }  ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div> <?php //} ?>
                          <!-- END ASSIGNED TO OTHERS -->
                        </div>                       
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

        
        
    





@include( "app/includes/unrefresh_form_submit
 <?php if ($referenceOutputID>=1 ) { ?>
      <script type="text/javascript">

      $(document).ready(function() {
         
        var minStartDate = "<?php echo date('d/m/Y', strtotime($startLimit)); ?>";
        var maxEndDate = "<?php echo date('d/m/Y', strtotime($endLimit)); ?>";
        $('#task_startDate').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'DD/MM/YYYY'
          },
          singleClasses: "picker_1",
          startDate: "<?php echo date('d/m/Y', strtotime($startDate)); ?>",
          minDate:minStartDate,
          maxDate:maxEndDate
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
      </script>

      <script type="text/javascript">

      $(document).ready(function() {

        var minStartDate = "<?php echo date('d/m/Y', strtotime($startLimit)); ?>";
        var maxEndDate = "<?php echo date('d/m/Y', strtotime($endLimit)); ?>";
        $('#task_endDate').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'DD/MM/YYYY'
          },
          singleClasses: "picker_1",
          startDate: "<?php echo date('d/m/Y', strtotime($endDate)); ?>",
          minDate:minStartDate,
          maxDate:maxEndDate
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
      </script>

      

      <?php } else { ?>
      <script type="text/javascript">
        

      $(document).ready(function() {
        $('#task_startDate').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'DD/MM/YYYY'
          },
          singleClasses: "picker_1",
          startDate: "<?php echo date('d/m/Y', strtotime($startDate)); ?>"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
      </script>

      <script type="text/javascript">

      $(document).ready(function() {

        $('#task_endDate').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'DD/MM/YYYY'
          },
          singleClasses: "picker_1",
          startDate: "<?php echo date('d/m/Y', strtotime($endDate)); ?>"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
      </script>
      <?php } ?>


      <script type="text/javascript">
        
    
    function deleteResource(id)
    {
        if (confirm("Are You Sure You Want To Delete This TResource") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/performance/deleteResource');?>/"+id,
            success:function(data)
            {
              if(data.status == 'OK'){
              alert("Resource Deleted Sussessifully!");
              }else if(data.status != 'SUCCESS'){
              alert("Resource Not Deleted, Some Error Occured In Deleting");
              }
           $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data.message);
        });
            $('#recordResource'+id).hide();
               
            }
               
            });
        }
    }
      </script>

 @endsection