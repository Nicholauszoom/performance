@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php   
  foreach($outcome_details as $detail){
  
  $description = $detail->description;
  $start = $detail->start;
  $startShow = $detail->start;
  $end = $detail->end;  
  $title = $detail->title;
  $indicator = $detail->indicator;
  $outcomeID = $detail->id;
  $strategy_title = $detail->strategyTitle;
  $strategy_ref = $detail->strategy_ref;
  if($detail->isAssigned==0){
  $assignedTo = "NOT ASSIGNED";
  } else { $assignedTo = $detail->responsible; }
  
  } 

  foreach($outcomeCost as $summary){
  
  $outputCount = $summary->outputCount;
  $outcomeCost = $summary->outcomeCost;
  $taskCount = $summary->taskCount;  
  }

  foreach($strategyDateRange as $row){
  
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
                <h3>Outcome Details</h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-head">
                      <h2 class="green"><b>Outcome Name:</b> <?php echo $title; ?></h2>
                    <!--<h2><?php echo $title; ?></h2>-->
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

                          <span class="name"> Outputs </span>
                          <span class="value text-success"> <?php echo $outputCount; ?> </span>
                        </li>
                        <li>
                          <span class="name"> Time Cost </span>
                          <span class="value text-success"> <?php echo number_format($outcomeCost, 2); ?> </span> 
                        </li>
                        <li class="hidden-phone">
                          <span class="name"> Resource Cost </span>
                          <span class="value text-success"> <?php echo number_format($outcomeResourceCost,2); ?> </span>
                        </li>
                      </ul>

                      <ul class="stats-overview">
                        <li>
                          <span class="name"> Outputs Completed </span>
                          <span class="value text-success"> <?php echo $outcomeOutputCompleted; ?></span>
                        </li>
                        <li>
                          <span class="name"> Outputs On Progress </span>
                          <span class="value text-success"> <?php echo $outcomeOutputProgress; ?> </span>
                        </li>
                        <li class="hidden-phone">
                          <span class="name"> Not Yet Started </span>
                          <span class="value text-success"> <?php echo $outcomeOutputNotStarted; ?> </span>
                        </li>
                      </ul>
                      <br/>

                      <!--<div id="outputs" style="height:350px;"></div>-->

                    </div>

                    <!-- start project-detail sidebar -->
                    <div class="col-md-12 col-sm-3 col-xs-12">

                      <section class="panel">

                        <!--<div class="card-head">
                          <h2 class="green">Project Description</h2>
                          <div class="clearfix"></div>
                        </div>-->
                        <div class="panel-body">
                          
                          <!--Start Tabs Content-->
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="card">
                      <div class="card-head">
                        <div class="clearfix"></div>
                      </div>
                      <div class="card-body">
                        <div id ="resultfeedDes"></div>
    
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#description" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Description</a>
                            </li>
                            <li role="presentation" class=""><a href="#outputs" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Outputs</a>
                            </li>
                            <li role="presentation" class=""><a href="#updateOutcome" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><font color = "green"><b><i class="fa fa-edit"></i>&nbsp;&nbsp;UPDATE</b></font></a>
                            </li>
                            <li role="presentation" class=""><a href="#addoutput" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><font color = "blue"><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>ADD NEW OUTPUT</b></font></a>
                            </li>
                          </ul>
                          <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="description" aria-labelledby="home-tab">
                              <p><b><font class="green">Outcome Name: </font></b><?php echo $title; ?></p>
                              <p><b><font class="green">Description: </font></b><?php echo $description; ?></p>
                              <p><b><font class="green">Srategy Reference</font>: </font></b><?php echo $strategy_title; ?></p>
                              <p><b><font class="green">Start Date: </font></b><?php echo date('d-m-Y', strtotime($start)); ?></p>
                              <p><b><font class="green">End Date: </font></b><?php echo date('d-m-Y', strtotime($end)); ?></p>
                              <p><b><font class="green">Assigned To: </font></b><?php echo $assignedTo; ?></p>  
                            </div>
                            
                            <!--UPDATE OUTCOME-->
                            <div role="tabpanel" class="tab-pane fade active" id="updateOutcome" aria-labelledby="profile-tab">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                <!--<div class="card">-->
                                <!--  <div class="card-body">-->
                                
                                      <!-- Title -->
                                    <form autocomplete="off" id="update_outcomeTitle" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Outcome Name
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" type="text" name="title" class="form-control col-md-7 col-xs-12" value ="<?php echo $title; ?>"  placeholder="Output Title" />
                                        </div>
                                        </div>
                                      </div>
                                          <input type="text" name="attribute" value ="title" hidden >
                                          <input type="text" name="outcomeID" value ="<?php echo $outcomeID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      <!--Title-->
                                      
                                      <!--DESCRIPTION-->
                                    <form autocomplete="off" id="update_outcomeDescriptions" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                      
                                      
                                      <!--<div id ="resultfeedDes">SWER</div>-->
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description  
                                        </label><br>
                                           <!--<span id ="resultfeedDes" class="text-success"></span> -->
                                        <!--<div id ="resultfeedDes"></div>-->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <textarea required="" class="form-control col-md-7 col-xs-12" name="description" placeholder="Description" rows="3"><?php echo $description;?></textarea>
                                          
                                        </div>
                                      </div>
                                          <input type="text" name="attribute" value ="description" hidden >
                                          <input type="text" name="outcomeID" value ="<?php echo $outcomeID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                         <!--<div id ="resultfeedDes">e</div>-->
                                        </div>
                                      </div> 
                                      </form>
                                      <!--DESCRIPTION-->
                                      
                                      <form autocomplete="off" id="outcomeAdvancedAssign"  enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                          <div id="assigned_to" class="form-group">
                                            <label class="control-label col-md-3  col-xs-6" >Re Assign To</label>
                                            <span class="text-info"><b><font class="value text-success"><?php echo $assignedTo; ?></font></b></span> 
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="assigned_to" required="" class="select4_single form-control" tabindex="-1">
                                            <option></option>
                                               <?php
                                              foreach ($employee as $row) { ?>
                                              <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                                            </select>
                                            </div>
                                          </div> 
                                          <!-- END -->
                          
                                          <input type="text" name="attribute" value ="assigned_to" hidden >
                                          <input type="text" name="outcomeID" value ="<?php echo $outcomeID; ?>" hidden >
                    
                                          <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button  class="btn btn-info">UPDATE</button> 
                                            </div>
                                          </div>
                                         </form>
                                      
                                      <!--START DATE-->
                                    <form autocomplete="off" id="updateOutcomeDateRange" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start
                                        </label>
                                           <span class="text-info"><?php echo date('d-m-Y', strtotime($start)); ?></span> 
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" placeholder="Start Date" type="text" name="start" class="form-control col-xs-12 has-feedback-left" id="outcome_startDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End
                                        </label>
                                           <span class="text-info"><?php echo date('d-m-Y', strtotime($end)); ?></span> 
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" placeholder="End Date" type="text" name="end" class="form-control col-xs-12 has-feedback-left" id="outcome_endDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div>
                                      
                                          <input type="text" name="attribute" value ="startDate" hidden >
                                          <input type="text" name="outcomeID" value ="<?php echo $outcomeID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      <!-- DATE-->
                                      
                
                                <!--  </div>-->
                                <!--</div>-->
                              </div>  
                            </div>
                            <!-- UPDATE OUTCOME-->
                            
                            <div role="tabpanel" class="tab-pane fade active" id="addoutput" aria-labelledby="profile-tab">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <!--<div class="card">-->
                                <!--  <div class="card-body">-->
                                    <form autocomplete="off" id="formAddOutput" enctype="multipart/form-data"  method="post"  data-parsley-validate class="form-horizontal form-label-left">
                
                                      <!-- START -->
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Output Name
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input  type="text" id="title" required="" name="title" class="form-control col-md-7 col-xs-12"  placeholder="Output Title" />
                                        </div>
                                        </div>
                                      </div> 
                                          <input type="text" name="strategyID"  hidden value="<?php echo $strategyID; ?>"/>
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <textarea required="" id="textdescription" class="form-control col-md-7 col-xs-12" name="description" placeholder="Description" rows="4"></textarea> 
                                          <!-- <span class="text-danger"><?php// echo form_error("lname");?></span> -->
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" placeholder="Start Date" type="text" name="start" class="form-control col-xs-12 has-feedback-left" id="output_startDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div> 
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" placeholder="End Date" type="text" name="end" class="form-control col-xs-12 has-feedback-left" id="output_endDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div>
                                      
                                      <div class="form-group">
                                            <label class="control-label col-md-3 col-md-3  col-xs-6" >Assign To</label>
                                            
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  name="employee" class="select4_single form-control" tabindex="-1">
                                            <option></option>
                                               <?php
                                              foreach ($employee as $row) {
                                                 # code... ?>
                                              <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                                            </select>
                                            </div>
                                      </div>

                                      <input type="text" name="outcomeKEY" value = "<?php echo $outcomeID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                           <button  class="btn btn-main"> ADD </button>
                                        </div>
                                      </div> 
                                      </form>
                
                                <!--  </div>-->
                                <!--</div>-->
                              </div>                            
                             </div>  <!--END ADD OUTPUT-->
                            <div role="tabpanel" class="tab-pane fade" id="outputs" aria-labelledby="profile-tab">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                  <div class="card-head">
                                    <h2>OUTPUTS </h2>
                
                                    <div class="clearfix"></div>
                                  </div>
                                  <div class="card-body">
                
                                     @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                  
                                    <table id="datatable" class="table table-striped table-bordered">
                                      <thead>
                                        <tr>
                                            <th><b>S/N</b></th>
                                            <th><b>Output Name</b></th>
                                            <th><b>Accountable Executive</b></th>
                                            <th><b>Duration</b></th>
                                            <th><b>RAG Status</b></th>
                                            <th><b>Option</b></th>
                                        </tr>
                                      </thead>
                
                                      <tbody>
                                        <?php
                                        //if ($employee->num_rows() > 0){
                                          foreach ($outputs as $rowOutput) { ?>
                                          <tr id="recordOutput<?php echo $rowOutput->id;?>">
                                            <td><?php echo $rowOutput->SNo; ?></td>
                                            <td><p><b><?php echo $rowOutput->title; ?></b></p></p>
                                                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target=".bs-output-modal-lg<?php echo $rowOutput->id; ?>">View More...</button>
                
                                                <div class="modal fade bs-output-modal-lg<?php echo $rowOutput->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                        </button>
                                                        <h4 class="modal-title" id="myModalLabel">Outcome Description</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                        <h4><b>Outcome Name: &nbsp;</b><?php echo $rowOutput->title; ?></h4>
                                                        <p><?php echo $rowOutput->description; ?></p>
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                      </div>
                
                                                    </div>
                                                  </div>
                                                </div>
                                            </td>
                                            <td>
                                            <?php  if($rowOutput->isAssigned == 0){ ?> 
                                                <div class="col-md-12">
                                                    <span class="label label-warning"><b>Not Assigned</b></span></div>
                                                <?php  }  else echo $rowOutput->executive; ?> 
                                            </td>
                                            <td><?php 
                            
                                                $startd=date_create($rowOutput->start);
                                                $endd=date_create($rowOutput->end);
                                                $diff=date_diff($startd, $endd);
                                                $DURATION = $diff->format("%a"); ?>
                                                <p><b><font class="green"><?php  echo $DURATION+1; ?>  Days</font></b><br>
                                                From <b><font class="green"><?php echo date('d-m-Y', strtotime($rowOutput->start)); ?></font></b> <br>
                                                To <b><font class="green"><?php echo date('d-m-Y', strtotime($rowOutput->end)); ?></font></b></p>
                                                
                                            </td>
                                            <td>
                                              <ul class="list-inline prod_color">
                                                <li>
                                                    <?php 
                                                    $totalTaskProgress = $rowOutput->sumProgress;
                                                    $taskCount = $rowOutput->countTask;
                                                    if($taskCount==0) $progress = 0; else $progress = ($totalTaskProgress/$taskCount);
                                                    
                                                    $todayDate=date('Y-m-d');
                                                    $endd=$rowOutput->end;
                                                    
                                          if($todayDate>$endd) {
                              
                                              if($progress==100){ ?>
                                                  <p><b>Completed</b></p>
                                                      <div class="color bg-green"></div> 
                                                      <?php } elseif($progress<100) { ?>
                                                      <p><b>Overdue(<?php echo $progress; ?>%)</b></p>
                                                      <div class="color bg-red"></div> <?php } 
                                              } else { 
                                                  if($progress==0){ ?>
                                                  <p><b>Not Started</b></p>
                                                      <div class="color bg-orange"></div>
                                                      <?php } elseif($progress>0 && $progress<100) { ?>
                                                  <p><b>
                                                      In Progress (<?php echo $progress; ?>%) </b></p>
                                                      <div class="color bg-blue-sky"></div>
                                                  <?php } elseif($progress==100){ ?>
                                                      <p><b>Completed</b></p>
                                                      <div class="color bg-green"></div>
                                                  <?php }  }  ?> 
                                                  </li>
                                              </ul>
                                          </td>
                                            <td class="options-width">
                                                <a href="<?php echo  url('')."flex/performance/output_info".base64_encode($rowOutput->strategy_ref."|".$rowOutput->outcome_ref."|".$rowOutput->id); ?>"   title="Output Info and Details" class="icon-2 info-tooltip"><button  class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                                <a href="javascript:void(0)" onclick="deleteOutput(<?php echo $rowOutput->id;?>)"    title="Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="ph-trash-o"></i></button> </a>
                                                <a href="<?php echo  url('')."flex/performance/assigntask".base64_encode($rowOutput->strategy_ref."|".$rowOutput->outcome_ref."|".$rowOutput->id); ?>"><button type="button" class="btn btn-main btn-xs"><i class="fa fa-plus"></i></button></a>
                                            </td>
                                        </tr> 
                                          <?php } //} ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div> <!-- class="col-md-12 col-sm-12 col-xs-12" -->
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="resources" aria-labelledby="profile-tab">
                              
                              <h5>Project files</h5>
                              <ul class="list-unstyled project_files">
                                <li><a href=""><i class="fa fa-file-word-o"></i> Functional-requirements.docx</a>
                                </li>
                                <li><a href=""><i class="fa fa-file-pdf-o"></i> UAT.pdf</a>
                                </li>
                                <li><a href=""><i class="fa fa-mail-forward"></i> Email-from-flatbal.mln</a>
                                </li>
                                <li><a href=""><i class="fa fa-picture-o"></i> Logo.png</a>
                                </li>
                                <li><a href=""><i class="fa fa-file-word-o"></i> Contract-10_12_2014.docx</a>
                                </li>
                              </ul>
                              

                              <div class="text-center mtop20">
                                <a href="#" class="btn btn-sm btn-main">Add files</a>
                                <a href="#" class="btn btn-sm btn-warning">Report contact</a>
                              </div>
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
        <!-- /page content -->





<?php @include("app/includes/unrefresh_form_submit")

    <!-- DATE SCRIPTS  -->



<script>
$(function() {
  var minStartDate = "<?php echo date('d/m/Y', strtotime($start)); ?>";
  var maxEndDate = "<?php echo date('d/m/Y', strtotime($end)); ?>";
  $('#output_startDate').daterangepicker({
    drops: 'down',
    singleDatePicker: true,
    autoUpdateInput: false,
    startDate: "<?php echo date('d/m/Y', strtotime($start)); ?>",
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
  var minStartDate = "<?php echo date('d/m/Y', strtotime($start)); ?>";
  var maxEndDate = "<?php echo date('d/m/Y', strtotime($end)); ?>";
  $('#output_endDate').daterangepicker({
    drops: 'down',
    singleDatePicker: true,
    autoUpdateInput: false,
    startDate: "<?php echo date('d/m/Y', strtotime($start)); ?>",
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


<script>
$(function() {
  var minStartDate = "<?php echo date('d/m/Y', strtotime($startLimit)); ?>";
  var maxEndDate = "<?php echo date('d/m/Y', strtotime($endLimit)); ?>";
  $('#outcome_startDate').daterangepicker({
    drops: 'up',
    singleDatePicker: true,
    autoUpdateInput: false,
    startDate: "<?php echo date('d/m/Y', strtotime($start)); ?>",
    minDate:minStartDate,
    maxDate:maxEndDate,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#outcome_startDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#outcome_startDate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>

<script>
$(function() {
  var minStartDate = "<?php echo date('d/m/Y', strtotime($startLimit)); ?>";
  var maxEndDate = "<?php echo date('d/m/Y', strtotime($endLimit)); ?>";
  $('#outcome_endDate').daterangepicker({
    drops: 'up',
    singleDatePicker: true,
    autoUpdateInput: false,
    startDate: "<?php echo date('d/m/Y', strtotime($start)); ?>",
    minDate:minStartDate,
    maxDate:maxEndDate,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#outcome_endDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#outcome_endDate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>

 <!-- DATE SCRIPTS   -->
 @endsection