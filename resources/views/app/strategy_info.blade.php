@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section

<?php   
  foreach($strategy_details as $detail){
  
  $description = $detail->description;
  $start = $detail->start;
  $end = $detail->end;  
  $strategyTitle = $detail->title;
  $indicator = $detail->author;
  $strategyID = $detail->id;
  
  
    $startd=date_create($detail->start);
    $endd=date_create($detail->end);
    $diff=date_diff($startd, $endd);
    $DURATION = $diff->format("%a Days");
  } 
  
  ?>


        <!-- page content -->
         <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Strategy Details</h3>
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
                          <h3 class="green"><i class="fa fa-info-circle"></i> <?php echo $strategyTitle; ?></h3>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <div id ="resultfeedDes"></div>
    
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation"  class="active" ><a href="#description" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Description</a>
                            </li>
                            <li role="presentation" class=""><a href="#outputs" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Outcomes</a>
                            </li>
                            <li role="presentation" class=""><a href="#updateStrategy" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><font color = "green"><b><i class="fa fa-edit"></i>&nbsp;&nbsp;UPDATE</b></font></a>
                            </li>
                            <li role="presentation" class="" ><a href="#addOutcomeTab" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><font color = "blue"><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>ADD NEW OUTCOME</b></font></a>
                            </li>
                          </ul>
                          <div id="myTabContent" class="tab-content">
                            <div role="tabpanel"  id="description"  class="tab-pane fade active in"  aria-labelledby="home-tab">
                              <p><b><font class="green">Strategy Name: </font></b><?php echo $strategyTitle; ?></p>
                              <p><b><font class="green">Description: </font></b><?php echo $description; ?></p>
                              <p><b><font class="green">Start Date: </font></b><?php echo date('d-m-Y', strtotime($start)); ?></p>
                              <p><b><font class="green">End Date: </font></b><?php echo date('d-m-Y', strtotime($end)); ?></p>
                              
                              
                              
                            </div>
                            
                            <!--UPDATE OUTCOME-->
                            <div role="tabpanel" class="tab-pane fade" id="updateStrategy" aria-labelledby="profile-tab">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                <!--<div class="x_panel">-->
                                <!--  <div class="x_content">-->
                                
                                      <!-- Title -->

                                    <form autocomplete="off" id="update_strategyTitle" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Strategy Name
                                        </label><br>
                                           <!--<span id ="resultfeedDes" class="text-success"></span> -->
                                        <!--<div id ="resultfeedDes"></div>-->
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <textarea required="" class="form-control col-md-7 col-xs-12" name="title" placeholder="Title" rows="2"><?php echo $strategyTitle;?></textarea>
                                          
                                        </div>
                                      </div>
                                          <input type="text" name="attribute" value ="title" hidden >
                                          <input type="text" name="strategyID" value ="<?php echo $strategyID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                         <!--<div id ="resultfeedDes">e</div>-->
                                        </div>
                                      </div> 
                                      </form>
                                      <!--Title-->

                                      <!--DESCRIPTION-->
                                    <form autocomplete="off" id="update_strategyDescription" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                      
                                      
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
                                          <input type="text" name="attribute" value ="description" hidden >
                                          <input type="text" name="strategyID" value ="<?php echo $strategyID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                         <!--<div id ="resultfeedDes">e</div>-->
                                        </div>
                                      </div> 
                                      </form>
                                      <!--DESCRIPTION-->
                                      
                                      <!--START DATE-->
                                    <form autocomplete="off" id="updateStrategyDateRange" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start
                                        </label>
                                           <span class="text-info"><?php echo date('d-m-Y', strtotime($start)); ?></span> 
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" type="text" name="start" placeholder="Start Date" class="form-control col-xs-12 has-feedback-left" id="strategy_startDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End
                                        </label>
                                           <span class="text-info"><?php echo date('d-m-Y', strtotime($end)); ?></span> 
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" type="text" name="end" placeholder="End Date" class="form-control col-xs-12 has-feedback-left" id="strategy_endDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div>
                                      
                                          <input type="text" name="attribute" value ="startDate" hidden >
                                          <input type="text" name="strategyID" value ="<?php echo $strategyID; ?>" hidden >
                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button  class="btn btn-info">UPDATE</button> 
                                        </div>
                                      </div> 
                                      </form>
                                      <!--START DATE-->
                                      
                
                                <!--  </div>-->
                                <!--</div>-->
                              </div>  
                            </div>
                            <!-- UPDATE OUTCOME-->
                            
                            <div role="tabpanel" id="addOutcomeTab" class="tab-pane fade active"  aria-labelledby="profile-tab">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <!--<div class="x_panel">-->
                                <!--  <div class="x_content">-->
                                    <form autocomplete="off"  id="addOutcome" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                
                                      <!-- START -->
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Outcome Name
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input type="text" id="name" name="name" required class="form-control col-md-7 col-xs-12"  placeholder="Outcome Title" />
                                        </div>
                                        </div>
                                      </div> 
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <textarea id="textdescription" class="form-control col-md-7 col-xs-12" name="description" required placeholder="Description" rows="3"></textarea> 
                                          <!-- <span class="text-danger"><?php echo form_error("lname");?></span> -->
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input type="text" required="" placeholder="Start Date" name="start" class="form-control col-xs-12 has-feedback-left" id="outcome_startDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div> 
                                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End
                                        </label>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="has-feedback">
                                          <input required="" type="text" placeholder="End Date" name="end" class="form-control col-xs-12 has-feedback-left" id="outcome_endDate"  aria-describedby="inputSuccess2Status">
                                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        </div>
                                      </div>
                                      
                                      <div class="form-group">
                                            <label class="control-label col-md-3  col-xs-6" >Assign To</label>
                                            
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                            <select  name="employee" class="select4_single form-control" tabindex="-1">
                                            <option></option>
                                               <?php
                                              foreach ($employee as $row) {
                                                 # code... ?>
                                              <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                                            </select>
                                            </div>
                                      </div>
                                      
                                      
                                      <input type="text" name="strategyID" value = "<?php echo $strategyID; ?>" hidden >
                                      

                                      <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                           <button type="submit" class="btn btn-primary" >ADD</button>
                                          <!-- <input type="submit"  value="Add" name="add" class="btn btn-primary"/> -->
                                        </div>
                                      </div> 
                                      </form>
                
                                <!--  </div>-->
                                <!--</div>-->
                              </div>                            
                             </div>  <!--END ADD OUTPUT-->
                            <div role="tabpanel" class="tab-pane fade" id="outputs" aria-labelledby="profile-tab">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                  <div class="x_title">
                                    <h2>OUTCOME &nbsp;&nbsp;&nbsp;</h2>
                
                                    <div class="clearfix"></div>
                                  </div>
                                  <div class="x_content">
                
                                     @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                  
                                    <table id="datatable" class="table table-striped table-bordered" >
                      <thead>
                        <tr>
                            <th><b>S/N</b></th>
                            <th><b>Outcome Name</b></th>
                            <th><b>Accountable Executive</b></th>
                            <th><b>Duration</b></th>
                            <th><b>RAG Status</b></th>
                            <th><b>Option</b></th>
                                            
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        //if ($employee->num_rows() > 0){
                          foreach ($outcomes as $rowOutcome) { ?>
                          <tr id="record<?php echo $rowOutcome->id;?>">
                            <td><?php echo $rowOutcome->SNo; ?></td>
                            <td><p><b><?php echo $rowOutcome->title; ?></b></p></p>
                                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target=".bs-outcome-modal-lg<?php echo $rowOutcome->id; ?>">View More...</button>

                                <div class="modal fade bs-outcome-modal-lg<?php echo $rowOutcome->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Outcome Description</h4>
                                      </div>
                                      <div class="modal-body">
                                        <h4><b>Title: &nbsp;</b><?php echo $rowOutcome->title; ?></h4>
                                        <p><?php echo $rowOutcome->description; ?></p>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>

                                    </div>
                                  </div>
                                </div>
                            </td>
                            <td><?php  if($rowOutcome->isAssigned == 0){ ?> 
                                <div class="col-md-12">
                                    <span class="label label-warning"><b>Not Assigned</b></span></div>
                                <?php  }  else echo $rowOutcome->executive; ?> 
                            </td>
                            <td><?php 
            
                                $startd=date_create($rowOutcome->start);
                                $endd=date_create($rowOutcome->end);
                                $diff=date_diff($startd, $endd);
                                $DURATION = $diff->format("%a"); ?>
                                <p><b><font class="green"><?php  echo $DURATION+1; ?> Days </font></b><br>
                                From <b><font class="green"><?php echo date('d-m-Y', strtotime($rowOutcome->start)); ?></font></b> <br>
                                To <b><font class="green"><?php echo date('d-m-Y', strtotime($rowOutcome->end)); ?></font></b></p>
                                
                            </td>
                            
                            <td>
                              <ul class="list-inline prod_color">
                                <li>
                                    <?php 
                                    $totalTaskProgress = $rowOutcome->sumProgress;
                                    $taskCount = $rowOutcome->countOutput;
                                    if($taskCount==0) $progress = 0; else $progress = number_format(($totalTaskProgress/$taskCount),1);
                                    
                                    $todayDate=date('Y-m-d');
                                    $endd=$rowOutcome->end;
                                      
                                    
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
                                <a href="<?php echo url()."flex/performance/outcome_info/?id=".base64_encode($rowOutcome->strategy_ref."|".$rowOutcome->id); ?>"   title="Outcome Info and Details" class="icon-2 info-tooltip"><button  class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                <a href="javascript:void(0)" onclick="deleteOutcome(<?php echo $rowOutcome->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                                <!-- <a href = "<?php echo url()."flex/performance/output/".$rowOutcome->id; ?>"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button></a> -->
                                
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
                                <a href="#" class="btn btn-sm btn-primary">Add files</a>
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




    <?php  
        
       include_once "app/includes/unrefresh_form_submit.php";
     ?>

     <!-- DATE SCRIPTS  -->

<script>
$(function() {

  var minStartDate = "<?php echo date('d/m/Y', strtotime($start)); ?>";
  var maxEndDate = "<?php echo date('d/m/Y', strtotime($end)); ?>";
  $('#outcome_startDate').daterangepicker({
    drops: 'down',
    singleDatePicker: true,
    autoUpdateInput: false,
    minDate:minStartDate,
    maxDate:maxEndDate,
    startDate:minStartDate,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    // var years = moment().diff(start, 'years');
    // alert("The Employee is " + years+ " Years Old!");

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

  var minStartDate = "<?php echo date('d/m/Y', strtotime($start)); ?>";
  var maxEndDate = "<?php echo date('d/m/Y', strtotime($end)); ?>";
  $('#outcome_endDate').daterangepicker({
    drops: 'down',
    singleDatePicker: true,
    autoUpdateInput: false,
    minDate:minStartDate,
    maxDate:maxEndDate,
    startDate:minStartDate,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    // var years = moment().diff(start, 'years');
    // alert("The Employee is " + years+ " Years Old!");

  });
    $('#outcome_endDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#outcome_endDate').on('cancel.daterangepicker', function(ev, picker) {
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

  var minStartDate = "<?php echo date('d/m/Y', strtotime($start)); ?>";
  var dateToday = dd + '/' + mm + '/' + yyyy;
  $('#strategy_startDate').daterangepicker({
    drops: 'up',
    singleDatePicker: true,
    autoUpdateInput: false,
    // minDate:dateToday,
    startDate: minStartDate,
    
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#strategy_startDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#strategy_startDate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>

<script>
$(function() {
  var minStartDate = "<?php echo date('d/m/Y', strtotime($start)); ?>";
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
  $('#strategy_endDate').daterangepicker({
    drops: 'up',
    singleDatePicker: true,
    autoUpdateInput: false,
    // minDate:dateToday,
    startDate: minStartDate,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#strategy_endDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#strategy_endDate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>

 <!-- DATE SCRIPTS   -->
 @endsection